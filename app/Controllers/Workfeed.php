<?php

namespace App\Controllers;

class Workfeed extends Security_Controller {

    public function __construct() {
        parent::__construct();
    }

    /* load timeline view */

    function index() {
        $this->check_module_availability("module_work_feed");

        $view_data = array();
        
        return $this->template->rander("work_feed/index", $view_data);
    }

    public function save() {
        $post_text = $this->request->getPost('post_text');
        $post_files = $this->request->getPost('file_hidden_data');
        $department = $this->request->getPost('department_id');
        
        $text = '';
        if($post_text) {
            $text = $post_text;
        }

        $department_id = 0;
        if($department) {
            $department_id = $department;
        }
        
        $files = '';
        if($post_files) {
            for($i=0; $i<count($post_files); $i++) {
                if($i==0) {
                    $files .= $post_files[$i];
                }
                else {
                    $files .= ':' . $post_files[$i];
                }
            }
        }

        $data = array(
            'user_id' => $this->login_user->id,
            'department_id' => $department_id,
            'content' => $text,
            'files' => $files,
            'share_link' => '',
            'favourite' => 0,
            'reposted' => 0,
            "created_at" => date("Y-m-d h:i:s"),
            'blocked' => 0,
            'deleted' => 0
        );

        $data = clean_data($data);
        $save_id = $this->Workfeed_model->ci_save($data, 0);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    private function _row_data($id) {
        $options = array(
            "id" => $id,
        );

        $data = $this->Workfeed_model->get_details($options)->getRow();
        $files = $data->files;
        $file_arr = explode(':', $files);
        
        $temp = array();
        for($i=0; $i<count($file_arr); $i++) {
            $file_options = array(
                'id' => $file_arr[$i]
            );

            $file_data = $this->Workfeed_file_model->get_details($file_options)->getRow();
            $file_name = $file_data->name;
            array_push($temp, $file_name);
        }

        $data->files = $temp;

        $comment_option = array(
            'post_id' => $id
        );
        $comments_data = $this->Workfeed_comment_model->get_details($comment_option)->getResult();
        $data->comment_count = count($comments_data);

        $user_id = $data->user_id;
        $user_option = array(
            'id' => $user_id
        );
        $user_data = $this->Users_model->get_details($user_option)->getRow();
        $user_images = unserialize($user_data->image);
        $user_avatar = $user_images['file_name'];

        if($user_avatar && $user_avatar != '') {
            $data->user_avatar = $user_avatar;

        }
        else {
            $data->user_avatar = '';
        }

        $data->user_name = $user_data->first_name . ' ' . $user_data->last_name;

        return $data;
    }

    public function delete_file() {
        $id = $this->request->getPost('id');
        if($id) {
            $flag = $this->Workfeed_file_model->delete_file($id);
            if($flag == 1) {
                print_r(json_encode(array(
                    'flag' => 1
                )));
            }
        }
    }

    public function upload_post_file() {
        
        $file = str_replace("~", ":", $this->request->getPost("file"));
        $flag = $this->request->getPost('flag');

        if ($file) {
            if($flag == 1) {
                $newName = time().".png";
            }
            else {
                $newName = time().".mp4";
            }
            
            $file = move_temp_file($newName, 'files/workfeed_file/', "", $file);
            $filepath = $file['file_name'];

            $data = array(
                "name" => $filepath,
                "type" => 0,
                "created_at" => date("Y-m-d h:i:s"),
            );
    
            $data = clean_data($data);
    
            $save_id = $this->Workfeed_file_model->ci_save($data, 0);

            print_r(json_encode(array(
                'flag' => 1,
                'save_id' => $save_id
            )));
            exit(1);
        }
    }

    public function upload_comment_file() {
        
        $file = str_replace("~", ":", $this->request->getPost("file"));
        $flag = $this->request->getPost('flag');

        if ($file) {
            if($flag == 1) {
                $newName = time().".png";
            }
            else {
                $newName = time().".mp4";
            }
            
            $file = move_temp_file($newName, 'files/workfeed_file/', "", $file);
            $filepath = $file['file_name'];

            $data = array(
                "name" => $filepath,
                "type" => 1,
                "created_at" => date("Y-m-d hh:ii:ss"),
            );
    
            $data = clean_data($data);
    
            $save_id = $this->Workfeed_file_model->ci_save($data, 0);

            print_r(json_encode(array(
                'flag' => 1,
                'save_id' => $save_id
            )));
            exit(1);
        }
    }

    function make_favoutite() {
        $id = $this->request->getPost('id');
        $flag = $this->request->getPost('flag');
        $type = $this->request->getPost('type');

        $option = array(
            'id' => $id
        );

        if($type == 0) {
            $now_record = $this->Workfeed_model->get_details($option)->getRow();
        }
        else {
            $now_record = $this->Workfeed_comment_model->get_details($option)->getRow();
        }
        
        $now_favourite = $now_record->favourite;
        $now_favourite_user = $now_record->favourite_user;

        $user_id = $this->login_user->id;
    
        if($flag == 0) {
            $favourite_user_id = $now_favourite_user . $user_id . ':';
            
            $data = array(
                "favourite" => ($now_favourite + 1),
                "favourite_user" => $favourite_user_id
            );
        }
        else {
            $position = strpos($now_favourite_user, $user_id.":", 0);
            if (is_numeric($position)){
                $favourite_user_id = str_replace ($user_id.":", "", $now_favourite_user);

                $data = array(
                    "favourite" => ($now_favourite-1),
                    "favourite_user" => $favourite_user_id
                );
            }
            else{
                $data = array(
                    "favourite" => ($now_favourite-1),
                );
            }
        }

        $data = clean_data($data);
        if($type == 0) {
            $save_id = $this->Workfeed_model->ci_save($data, $id);
        }
        else {
            $save_id = $this->Workfeed_comment_model->ci_save($data, $id);
        }
        
        if($save_id) {
            print_r(json_encode(array('flag' => 1)));
        }
        else {
            print_r(json_encode(array('flag' => 0)));
        }
    }

    function make_repost() {
        $id = $this->request->getPost('id');
        $flag = $this->request->getPost('flag');

        $option = array(
            'id' => $id
        );

        $now_record = $this->Workfeed_model->get_details($option)->getRow();
        
        $now_reposted = $now_record->reposted;
        $now_reposted_user = $now_record->reposted_user;

        $user_id = $this->login_user->id;
    
        if($flag == 0) {
            $reposted_user_id = $now_reposted_user . $user_id . ':';

            $now_reposted_id = $now_record->reposted_id;

            $duplicate_record = array(
                'user_id' => $user_id,
                'department_id' => $now_record->department_id,
                'content' => $now_record->content,
                'files' => $now_record->files,
                'reposted_id' => $id
            );

            $duplicate_record = clean_data($duplicate_record);
            $save_id = $this->Workfeed_model->ci_save($duplicate_record, 0);

            $data = array(
                "reposted" => ($now_reposted + 1),
                "reposted_user" => $reposted_user_id,
            );
        }
        else {
            $delete_reposted_data = array(
                'user_id' => $user_id,
                'reposted_id' => $id
            );
            
            $deleted_reposted = $this->Workfeed_model->delete_reposted_record($delete_reposted_data);
            
            $position = strpos($now_reposted_user, $user_id.":", 0);
            if (is_numeric($position)){
                $reposted_user_id = str_replace ($user_id.":", "", $now_reposted_user);

                $data = array(
                    "reposted" => ($now_reposted-1),
                    "reposted_user" => $reposted_user_id
                );
            }
            else{
                $data = array(
                    "reposted" => ($now_reposted-1),
                );
            }
        }

        $data = clean_data($data);
        $save_id = $this->Workfeed_model->ci_save($data, $id);
        if($save_id) {
            print_r(json_encode(array('flag' => 1)));
        }
        else {
            print_r(json_encode(array('flag' => 0)));
        }
    }

    function comment_save() {
        $post_id = $this->request->getPost('parent_id');
        $comment_text  = $this->request->getPost('comment_text');
        $comment_type = $this->request->getPost('comment_type');
        $comment_files = $this->request->getPost('file_hidden_data');

        $text = '';
        if($comment_text) {
            $text = $comment_text;
        }
        
        $files = '';
        if($comment_files) {
            for($i=0; $i<count($comment_files); $i++) {
                if($i==0) {
                    $files .= $comment_files[$i];
                }
                else {
                    $files .= ':' . $comment_files[$i];
                }
            }
        }

        $data = array(
            'user_id' => $this->login_user->id,
            'parent_id' => $post_id,
            'comment_type' => $comment_type,
            'comment' => $text,
            'files' => $files,
            'favourite' => 0,
            "created_at" => date("Y-m-d h:i:s"),
            'blocked' => 0,
            'deleted' => 0
        );

        $data = clean_data($data);
        $save_id = $this->Workfeed_comment_model->ci_save($data, 0);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_comment_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    private function _comment_row_data($id) {
        $options = array(
            "id" => $id,
        );

        $data = $this->Workfeed_comment_model->get_details($options)->getRow();
        $files = $data->files;
        $file_arr = explode(':', $files);
        
        $temp = array();
        for($i=0; $i<count($file_arr); $i++) {
            $file_options = array(
                'id' => $file_arr[$i]
            );

            $file_data = $this->Workfeed_file_model->get_details($file_options)->getRow();
            $file_name = $file_data->name;
            array_push($temp, $file_name);
        }

        $data->files = $temp;

        $user_id = $data->user_id;
        $user_option = array(
            'id' => $user_id
        );
        $user_data = $this->Users_model->get_details($user_option)->getRow();
        $user_images = unserialize($user_data->image);
        $user_avatar = $user_images['file_name'];

        if($user_avatar && $user_avatar != '') {
            $data->user_avatar = $user_avatar;
        }
        else {
            $data->user_avatar = '';
        }

        $data->user_name = $user_data->first_name . ' ' . $user_data->last_name;

        return $data;
    }

    function get_comments() {
        $id = $this->request->getPost('id');
        
        $post_record = $this->_row_data($id);
        
        $option = array(
            'parent_id' => $id
        );
        $result = $this->Workfeed_comment_model->get_details($option)->getResult();
        for($i=0; $i<count($result); $i++) {
            $this->get_comments_data($result[$i]);
        }

        print_r(json_encode(array(
            'flag' => 1,
            'post' => $post_record,
            'comments' => $result,
        )));
        exit(1);
    }

    function get_comments_data($data) {
        ////////file
        $files = $data->files;
        $file_arr = explode(':', $files);
        
        $temp = array();
        for($j=0; $j<count($file_arr); $j++) {
            $file_options = array(
                'id' => $file_arr[$j]
            );

            $file_data = $this->Workfeed_file_model->get_details($file_options)->getRow();
            $file_name = $file_data->name;
            array_push($temp, $file_name);
        }

        $data->files = $temp;
        //////////comment
        $user_id = $this->login_user->id;
                
        $favourite_user = $data->favourite_user;
        $position = strpos($favourite_user, $user_id.":", 0);
        if (is_numeric($position)){
            $data->favourite_user_flag = 1;
        }
        else{
            $data->favourite_user_flag = 0;
        }

        ////////user
        $user_id = $data->user_id;
        $user_option = array(
            'id' => $user_id
        );
        $user_data = $this->Users_model->get_details($user_option)->getRow();
        $user_images = unserialize($user_data->image);
        $user_avatar = $user_images['file_name'];

        if($user_avatar && $user_avatar != '') {
            $data->user_avatar = $user_avatar;
        }
        else {
            $data->user_avatar = '';
        }
        $data->user_name = $user_data->first_name . ' ' . $user_data->last_name;
        
        $parent_id = $data->id;
        
        $sub_options = array(
            'parent_id' => $parent_id,  
            'comment_type' => 1
        );

        $result = $this->Workfeed_comment_model->get_details($sub_options)->getResult();
        if($result) {
            $data->sub_menu = $result;
            for($i=0; $i<count($result); $i++) {
                $this->get_comments_data($result[$i]);
            }
        }
    }
}