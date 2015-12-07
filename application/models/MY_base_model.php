<?php


abstract class MY_base_model extends CI_Model
{
    public $table;
    /** @var  CI_DB_query_builder */
    public $db;
    /** @var  CI_Controller */
    public $_ci;

    public $boolean_fields = [];

//    /** @var  categories_model */
//    public $categories_model;
//    /** @var  poses_model */
//    public $poses_model;
//    /** @var  arrows_model */
//    public $arrows_model;
//    /** @var  transformations_model */
//    public $transformations_model;
//    /** @var  transform_model */
//    public $transform_model;
//    /** @var  clouds_model */
//    public $clouds_model;
//    /** @var  cloud_texts_model */
//    public $cloud_texts_model;
//    /** @var  devices_model */
//    public $devices_model;
    /** @var languages_model  languages_model */

    public function __construct($table)
    {
        $this->table = $table;
        parent::__construct();

//        $this->db = clone $this->CI->db;
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        $CR = new CI_DB_result($this->db);
        return mysqli_insert_id($CR->conn_id);
    }

    public function update($id, array $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table,['id' => $id]);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table,['id' => $id])->row_array();
    }

    public function process_row($array)
    {
        foreach($array as $field => &$value)
        {
//            $value = (intval($value) !== false) ? intval($value) : $value;
            if(in_array($field, $this->boolean_fields))
            {
                $value = !!$value;
            }

        }
        return $array;
    }

    public function process_batch($batch)
    {
        foreach($batch as &$array)
        {
            $array = $this->process_row($array);
        }
        return $batch;
    }



}