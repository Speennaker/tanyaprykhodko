<?php
require_once('MY_base_model.php');
class Languages_model extends MY_base_model
{
    public function __construct()
    {
        parent::__construct('languages');
    }

    public function get_languages_associated()
    {
        $this->db->from($this->table);
        $this->db->select('code, id');
        $r = $this->db->get()->result_array();
        $list = [];
        foreach($r as $row)
        {
            $list[$row['code']] = $row['id'];
        }
        return $list;
    }
}