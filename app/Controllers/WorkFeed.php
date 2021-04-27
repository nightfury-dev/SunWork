<?php

namespace App\Controllers;

class WorkFeed extends Security_Controller {

    public function __construct() {
        parent::__construct();
    }

    /* load timeline view */

    function index() {
        $this->check_module_availability("module_work_feed");

        $view_data = array();
        // $view_data['team_members'] = "";
        // $this->init_permission_checker("message_permission");
        // if (get_array_value($this->login_user->permissions, "message_permission") !== "no") {
        //     $view_data['team_members'] = $this->Messages_model->get_users_for_messaging($this->get_user_options_for_query("staff"))->getResult();
        // }

        return $this->template->rander("work_feed/index", $view_data);
    }

}

/* End of file timeline.php */
    /* Location: ./app/controllers/timeline.php */