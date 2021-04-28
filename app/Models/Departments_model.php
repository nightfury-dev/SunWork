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

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $departments_table.client_id=$client_id";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql = "SELECT *
        FROM $departments_table
        WHERE $departments_table.deleted=0 $where
        ORDER BY $departments_table.start_date DESC";
        return $this->db->query($sql);
    }
}
