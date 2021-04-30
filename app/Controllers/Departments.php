<?php

namespace App\Controllers;

class Departments extends Security_Controller {

    protected $Departments_model;
    
    public function __construct() {
        parent::__construct();
        $this->Departments_model = model('App\Models\Departments_model');
        
    }

    /* load timeline view */

    function index() {
        app_redirect("departments/all_departments");
    }

    function all_departments($status = "") {
        $view_data['department_labels_dropdown'] = json_encode($this->make_labels_dropdown("department" , "", true));
        // $view_data["can_create_projects"] = $this->can_create_projects();
        $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("departments", $this->login_user->is_admin, $this->login_user->user_type);
        $view_data["status"] = $status;

        if ($this->login_user->user_type === "staff") {
            // $view_data["can_edit_projects"] = $this->can_edit_projects();
            // $view_data["can_delete_projects"] = $this->can_delete_projects();

            // return $this->template->rander("projects/index", $view_data);
        } else {
            $view_data['created_by'] = $this->login_user->id;
            return $this->template->rander("department/index", $view_data);
        }
    }

    function modal_form() {
        $department_id = $this->request->getPost('id');
        
        if ($department_id) {
            // if (!$this->can_edit_projects()) {
            //     app_redirect("forbidden");
            // }
        } else {
            // if (!$this->can_create_projects()) {
            //     app_redirect("forbidden");
            // }
        }
        
        $view_data['model_info'] = $this->Departments_model->get_one($department_id);
        
        $all_persons = $this->Users_model->all_persons();
        $persons_data_for_drop = array();
        
        for($i=0; $i<count($all_persons); $i++) {
            $persons_data_for_drop[] = array('id' => $all_persons[$i]['id'], 'text' => $all_persons[$i]['email']);
        }

        $view_data['all_persons'] = $persons_data_for_drop;

        // $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("departments", $view_data['model_info']->id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();
    
        // $view_data['clients_dropdown'] = $this->Clients_model->get_dropdown_list(array("company_name"), "id", array("is_lead" => 0));
        
        // $view_data['label_suggestions'] = $this->make_labels_dropdown("project", $view_data['model_info']->labels);
        
        return $this->template->view('department/modal_form', $view_data);
    }

    function departments_list_data_of_user($created_by = 0) {

        // $this->access_only_team_members_or_client_contact($client_id);
        
        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("departments", $this->login_user->is_admin, $this->login_user->user_type);
        
        // $statuses = $this->request->getPost('status') ? implode(",", $this->request->getPost('status')) : "";

        $options = array(
            "created_by" => $created_by,
            // "statuses" => $statuses,
            // "project_label" => $this->request->getPost("project_label"),
            // "custom_fields" => $custom_fields
        );

        $list_data = $this->Departments_model->get_details($options)->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data, $custom_fields);
        }

        echo json_encode(array("data" => $result));
    }

    private function _make_row($data, $custom_fields) {
        $start_date = is_date_exists($data->start_date) ? format_to_date($data->start_date, false) : "-";
        
        $optoins = "";
        // if ($this->can_edit_projects()) {
            $optoins .= modal_anchor(get_uri("departments/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_department'), "data-post-id" => $data->id));
        // }

        // if ($this->can_delete_projects()) {
            $optoins .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_department'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("departments/delete"), "data-action" => "delete-confirmation"));
        // }

        $row_data = array(
            anchor(get_uri("departments/view/" . $data->name), $data->id),
            $data->icon != '' ? "<span class='avatar avatar-xs mr10'><img src='". base_url()."/files/department_icon/". $data->icon ."' alt='...'></span>" : "",
            anchor(get_uri("departments/view/" . $data->name), $data->name),
            $data->description,
            $data->created_at,
            $data->status,
            $data->private == 1 ? 'Private' : ''
        );

        foreach ($custom_fields as $field) {
            $cf_id = "cfv_" . $field->id;
            $row_data[] = $this->template->view("custom_fields/output_" . $field->field_type, array("value" => $data->$cf_id));
        }

        $row_data[] = $optoins;

        return $row_data;
    }

    function save() {
        $id = $this->request->getPost('id');
            
        // if ($id) {
        //     if (!$this->can_edit_projects()) {
        //         app_redirect("forbidden");
        //     }
        // } else {
        //     if (!$this->can_create_projects()) {
        //         app_redirect("forbidden");
        //     }
        // }

        $this->validate_submitted_data(array(
            "name" => "required",
            // 'department_icon' => 'uploaded[file]|max_size[file,1024]|ext_in[file,jpg,jpeg,png,gif]|required'
        ));
        
        $data = array();

        $status = $this->request->getPost('status');
        $file = $this->request->getFile('department_icon');
        $filepath = "";

        $profile_image = str_replace("~", ":", $this->request->getPost("profile_image"));

        if ($profile_image) {
            $newName = time().".png";
            $profile_image = move_temp_file($newName, 'files/department_icon/', "", $profile_image);
            $filepath = $profile_image['file_name'];
        }
        else {
            if($id) {
                $icon_path = $this->Departments_model->get_icon_path($id);
                if($icon_path !== '') {
                    $filepath = $icon_path;
                }
            }
        }

        $data = array(
            "name" => $this->request->getPost('name'),
            "description" => $this->request->getPost('description'),
            "members_id" => $this->request->getPost('members_id'),
            "icon" => $filepath,
            "private" => $this->request->getPost('private') ? 1 : 0,
            "status" => $status ? $status : "open"
        );

        if(!$id) {
            $data['created_at'] = date("Y-m-d");
            $data['created_by'] = $this->login_user->id;
        }

        $data = clean_data($data);

        $save_id = $this->Departments_model->ci_save($data, $id);
        
        if ($save_id) {
            save_custom_fields("departments", $save_id, $this->login_user->is_admin, $this->login_user->user_type);
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    private function _row_data($id) {
        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("departments", $this->login_user->is_admin, $this->login_user->user_type);

        $options = array(
            "id" => $id,
            "custom_fields" => $custom_fields
        );

        $data = $this->Departments_model->get_details($options)->getRow();
        return $this->_make_row($data, $custom_fields);
    }

    function delete() {
        // if (!$this->can_delete_projects()) {
        //     app_redirect("forbidden");
        // }

        $id = $this->request->getPost('id');

        if ($this->Departments_model->delete_department_and_sub_items($id)) {
            // log_notification("department_deleted", array("project_id" => $id));
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    function view($department_name = "") {
        $view_data = $this->_get_department_info_data($department_name);
        return $this->template->rander("department/view", $view_data);
    }

    private function _get_department_info_data($department_name) {
        $options = array(
            "name" => $department_name,
        );

        $department_info = $this->Departments_model->get_details($options)->getRow();
        
        if ($department_info) {
            $members_id = $department_info->members_id;
            $members_string = '';
            if($members_id !== '') {
                $members_arr = explode(',', $members_id);
                for($i=0; $i<count($members_arr); $i++) {
                    $options = array(
                        'id' => $members_arr[$i]
                    );
                    $user_record = $this->Users_model->get_details($options)->getRow();
                    $username = $user_record->first_name . ' ' . $user_record->last_name . '(' . $user_record->email . ')';
                    $members_string .= $username . ' <br>';

                }
            }
            
            $view_data['members_string'] = $members_string;
            $view_data['department_info'] = $department_info;
            return $view_data;
        } else {
            show_404();
        }
    }

    function work_feed_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/workfeed_tab', $view_data);    
        }
    }

    function people_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/people_tab', $view_data);    
        }
    }

    function todo_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/todo_tab', $view_data);    
        }
    }

    function project_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/project_tab', $view_data);    
        }
    }

    function job_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/job_tab', $view_data);    
        }
    }

    function event_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/event_tab', $view_data);    
        }
    }

    function more_tab($department_id = 0) {
        if($department_id) {
            $view_data = array();
            return $this->template->view('department/tabs/more_tab', $view_data);    
        }
    }
}

/* End of file Departments.php */
/* Location: ./app/controllers/Departments.php */