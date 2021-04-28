<?php

namespace App\Models;

class Departments_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'departments';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $departments_table = $this->db->prefixTable('departments');
        $where = "";

        $created_by = get_array_value($options, "created_by");
        if ($created_by) {
            $where .= " AND $departments_table.created_by=$created_by";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql = "SELECT *
        FROM $departments_table
        WHERE $departments_table.deleted=0 $where
        ORDER BY $departments_table.created_at DESC";
        return $this->db->query($sql);
    }

    function get_icon_path($id) {
        $result = $this->get_one($id);
        return $result->icon;
    }

    function delete_department_and_sub_items($department_id) {
        $departments_table = $this->db->prefixTable('departments');
        // $tasks_table = $this->db->prefixTable('tasks');
        // $milestones_table = $this->db->prefixTable('milestones');
        // $project_files_table = $this->db->prefixTable('project_files');
        // $project_comments_table = $this->db->prefixTable('project_comments');
        // $activity_logs_table = $this->db->prefixTable('activity_logs');
        // $notifications_table = $this->db->prefixTable('notifications');

        //get project files info to delete the files from directory

        // $project_files_sql = "SELECT * FROM $project_files_table WHERE $project_files_table.deleted=0 AND $project_files_table.project_id=$project_id; ";
        // $project_files = $this->db->query($project_files_sql)->getResult();

        //get project comments info to delete the files from directory 

        // $project_comments_sql = "SELECT * FROM $project_comments_table WHERE $project_comments_table.deleted=0 AND $project_comments_table.project_id=$project_id; ";
        // $project_comments = $this->db->query($project_comments_sql)->getResult();

        
        //delete the project files from directory
        
        $file_path = get_setting("department_icon_path") . "/";
        $file = $this->get_icon_path($department_id);
        if($file !== '') {
            delete_app_files($file_path, array($file));
        }

        //delete the project and sub items
        $delete_department_sql = "UPDATE $departments_table SET $departments_table.deleted=1 WHERE $departments_table.id=$department_id; ";
        $this->db->query($delete_department_sql);

        // $delete_tasks_sql = "UPDATE $tasks_table SET $tasks_table.deleted=1 WHERE $tasks_table.project_id=$project_id; ";
        // $this->db->query($delete_tasks_sql);

        // $delete_milestones_sql = "UPDATE $milestones_table SET $milestones_table.deleted=1 WHERE $milestones_table.project_id=$project_id; ";
        // $this->db->query($delete_milestones_sql);

        // $delete_files_sql = "UPDATE $project_files_table SET $project_files_table.deleted=1 WHERE $project_files_table.project_id=$project_id; ";
        // $this->db->query($delete_files_sql);

        // $delete_comments_sql = "UPDATE $project_comments_table SET $project_comments_table.deleted=1 WHERE $project_comments_table.project_id=$project_id; ";
        // $this->db->query($delete_comments_sql);

        // $delete_activity_logs_sql = "UPDATE $activity_logs_table SET $activity_logs_table.deleted=1 WHERE $activity_logs_table.log_for='project' AND $activity_logs_table.log_for_id=$project_id; ";
        // $this->db->query($delete_activity_logs_sql);

        // $delete_notifications_sql = "UPDATE $notifications_table SET $notifications_table.deleted=1 WHERE $notifications_table.project_id=$project_id; ";
        // $this->db->query($delete_notifications_sql);


        //delete the comment files from directory
        // $comment_file_path = get_setting("timeline_file_path");
        // foreach ($project_comments as $comment_info) {
        //     if ($comment_info->files && $comment_info->files != "a:0:{}") {
        //         $files = unserialize($comment_info->files);
        //         foreach ($files as $file) {
        //             delete_app_files($comment_file_path, array($file));
        //         }
        //     }
        // }

        return true;
    }
}
