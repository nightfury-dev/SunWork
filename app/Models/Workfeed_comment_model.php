<?php

namespace App\Models;

class Workfeed_comment_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'workfeed_comments';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $workfeed_comment_table = $this->db->prefixTable('workfeed_comments');
        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $workfeed_comment_table.id=$id";
        }

        $parent_id = get_array_value($options, "parent_id");
        if ($parent_id) {
            $where .= " AND $workfeed_comment_table.parent_id='$parent_id'";
        }

        $comment_type = get_array_value($options, 'comment_type');
        if ($comment_type) {
            $where .= " AND $workfeed_comment_table.comment_type='$comment_type'";
        }

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql = "SELECT *
        FROM $workfeed_comment_table
        WHERE $workfeed_comment_table.deleted=0 $where
        ORDER BY $workfeed_comment_table.created_at DESC";

        return $this->db->query($sql);
    }

    
}
