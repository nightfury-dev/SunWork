<?php

namespace App\Models;

class Workfeed_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'workfeeds';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $workfeed_table = $this->db->prefixTable('workfeeds');
        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $workfeed_table.id=$id";
        }

        $department_id = get_array_value($options, "department_id");
        if ($department_id) {
            $where .= " AND $workfeed_table.department_id=$department_id";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql = "SELECT *
        FROM $workfeed_table
        WHERE $workfeed_table.deleted=0 $where
        ORDER BY $workfeed_table.created_at DESC";

        return $this->db->query($sql);
    }

    function delete_reposted_record($options = array()) {
        $workfeed_table = $this->db->prefixTable('workfeeds');
        $where = "";

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " $workfeed_table.user_id=$user_id";
        }

        $reposted_id = get_array_value($options, "reposted_id");
        if ($reposted_id) {
            $where .= " AND $workfeed_table.reposted_id=$reposted_id";
        }

        $sql = "Update $workfeed_table
        SET $workfeed_table.deleted=1
        WHERE $where";

        return $this->db->query($sql);
    }
}
