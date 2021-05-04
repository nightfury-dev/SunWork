<?php

namespace App\Models;

class Workfeed_file_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'workfeed_files';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $workfeed_file_table = $this->db->prefixTable('workfeed_files');
        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $workfeed_file_table.id=$id";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql = "SELECT *
        FROM $workfeed_file_table
        WHERE $workfeed_file_table.deleted=0 $where
        ORDER BY $workfeed_file_table.created_at DESC";

        return $this->db->query($sql);
    }

    function get_file_path($id) {
        $result = $this->get_one($id);
        return $result->name;
    }

    function delete_file($id) {
        $workfeed_file_table = $this->db->prefixTable('workfeed_files');
        
        $file_path = get_setting("workfeed_file_path") . "/";
        $file = $this->get_file_path($id);
        if($file !== '') {
            delete_app_files($file_path, array($file));
        }

        //delete the project and sub items
        $delete_workfeed_file_sql = "UPDATE $workfeed_file_table SET $workfeed_file_table.deleted=1 WHERE $workfeed_file_table.id=$id; ";
        $this->db->query($delete_workfeed_file_sql);
        return 1;
    }
}
