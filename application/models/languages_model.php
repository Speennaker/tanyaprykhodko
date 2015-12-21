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

    public function get_languages($enabled_only = true)
    {
        $this->db->from($this->table);
        $this->db->select('title, code, id');
        if($enabled_only) $this->db->where('enabled', 1);
        $r = $this->db->get()->result_array();
        $result = [];
        foreach($r as $row)
        {
            $result[$row['id']] = $row;
        }
        return $result;
    }
}