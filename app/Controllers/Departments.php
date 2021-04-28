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

    function all_departments() {
        // $view_data['project_labels_dropdown'] = json_encode($this->make_labels_dropdown("project", "", true));

        // $view_data["can_create_projects"] = $this->can_create_projects();

        // $view_data["custom_field_headers"] = $this->Custom_fields_model->get_custom_field_headers_for_table("projects", $this->login_user->is_admin, $this->login_user->user_type);

        // $view_data["status"] = $status;

        if ($this->login_user->user_type === "staff") {
            // $view_data["can_edit_projects"] = $this->can_edit_projects();
            // $view_data["can_delete_projects"] = $this->can_delete_projects();

            // return $this->template->rander("projects/index", $view_data);
        } else {
            $view_data['client_id'] = $this->login_user->client_id;
            return $this->template->rander("department/index", $view_data);
        }
    }

    function modal_form() {
        $department_id = $this->request->getPost('id');
        $client_id = $this->request->getPost('client_id');

        if ($department_id) {
            // if (!$this->can_edit_projects()) {
            //     app_redirect("forbidden");
            // }
        } else {
            // if (!$this->can_create_projects()) {
            //     app_redirect("forbidden");
            // }
        }
        
        $view_data["client_id"] = $client_id;
        $view_data['model_info'] = $this->Departments_model->get_one($department_id);
        
        if ($client_id) {
            $view_data['model_info']->client_id = $client_id;
        }

        //check if it's from estimate. if so, then prepare for project
        $estimate_id = $this->request->getPost('estimate_id');
        if ($estimate_id) {
            $view_data['model_info']->estimate_id = $estimate_id;
        }

        $view_data["custom_fields"] = $this->Custom_fields_model->get_combined_details("projects", $view_data['model_info']->id, $this->login_user->is_admin, $this->login_user->user_type)->getResult();
    
        $view_data['clients_dropdown'] = $this->Clients_model->get_dropdown_list(array("company_name"), "id", array("is_lead" => 0));
        
        $view_data['label_suggestions'] = $this->make_labels_dropdown("project", $view_data['model_info']->labels);
        
        return $this->template->view('department/modal_form', $view_data);
    }

    function departments_list_data_of_client($client_id = 0) {

        // $this->access_only_team_members_or_client_contact($client_id);
        
        $custom_fields = $this->Custom_fields_model->get_available_fields_for_table("departments", $this->login_user->is_admin, $this->login_user->user_type);
        
        // $statuses = $this->request->getPost('status') ? implode(",", $this->request->getPost('status')) : "";

        $options = array(
            "client_id" => $client_id,
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

    /* prepare a row of project list table */

    private function _make_row($data, $custom_fields) {
        $start_date = is_date_exists($data->start_date) ? format_to_date($data->start_date, false) : "-";
        
        // $name = anchor(get_uri("departments/view/" . $data->id), $data->name);

        // if ($data->labels_list) {
        //     $project_labels = make_labels_view_data($data->labels_list, true);
        //     $title .= "<br />" . $project_labels;
        // }

        // $optoins = "";
        // if ($this->can_edit_projects()) {
        //     $optoins .= modal_anchor(get_uri("projects/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_project'), "data-post-id" => $data->id));
        // }

        // if ($this->can_delete_projects()) {
        //     $optoins .= js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_project'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("projects/delete"), "data-action" => "delete-confirmation"));
        // }

        // //show the project price to them who has permission to create projects
        // if ($this->login_user->user_type == "staff" && !$this->can_create_projects()) {
        //     $price = "-";
        // }


        // $row_data = array(
        //     anchor(get_uri("projects/view/" . $data->id), $data->id),
        //     $title,
        //     anchor(get_uri("clients/view/" . $data->client_id), $data->company_name),
        //     $price,
        //     $data->start_date,
        //     $start_date,
        //     $data->deadline,
        //     $dateline,
        //     $progress_bar,
        //     app_lang($data->status)
        // );

        $row_data = array(
            $data->id,
            $data->name,
            $data->description,
            $data->start_date,
            $data->status
        );

        foreach ($custom_fields as $field) {
            $cf_id = "cfv_" . $field->id;
            $row_data[] = $this->template->view("custom_fields/output_" . $field->field_type, array("value" => $data->$cf_id));
        }

        $row_data[] = $optoins;

        return $row_data;
    }
}

/* End of file Departments.php */
    /* Location: ./app/controllers/Departments.php */