<?php
require_once('MY_base_model.php');
class Albums_texts_model extends MY_base_model
{
    public function __construct()
    {
        parent::__construct('albums_texts');
    }

    public function save_albums_texts($data, $album_id = null)
    {
        $this->db->delete($this->table, ['albums_id' => $album_id]);
        foreach($data as &$row)
        {
            $row['albums_id'] = $album_id;
        }
        return $this->db->insert_batch($this->table, $data);
    }

    public function get_albums_texts($album_id )
    {
        $res =  $this->db->get_where($this->table, ['albums_id' => $album_id])->result_array();
        if(!$res) return $res;
        $result = [];
        foreach($res as $row)
        {
            $result[$row['languages_id']] = $row;
        }
        return $result;
    }
}