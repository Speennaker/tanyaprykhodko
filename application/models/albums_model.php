<?php
require_once('MY_base_model.php');
class Albums_model extends MY_base_model
{
   /** @var  albums_texts_model */
    public $albums_texts_model;
    public $default_cover;

    public function __construct()
    {
        parent::__construct('albums');
        $CI = &get_instance();
        $CI->load->model('albums_texts_model');
        $this->albums_texts_model = $CI->albums_texts_model;
    }

    public function save_album($data, $id = null)
    {
        $texts = $data['texts'];
        $cover  = isset($data['cover']) ? $data['cover'] : null;
        unset($data['cover']);
        unset($data['texts']);
        if($id) $this->update($id, $data);
        else $id = $this->add($data);
        $this->albums_texts_model->save_albums_texts($texts, $id);
//        var_dump($cover);die;
        if($cover){
            $this->save_cover($cover, $id);
        }
        return $id;
    }

    public function get_album($id)
    {
        $result = $this->get_by_id($id);
        if(!$result) return $result;
        $result['texts'] = $this->albums_texts_model->get_albums_texts($id);
        return $result;
    }


    protected function save_cover($cover, $album_id)
    {
        $cover = asset_path().'/uploads/'.$cover;
        if(!file_exists($cover)) return false;
        $album_path = asset_path().'/images/albums/'.$album_id.'/';
        if(!is_dir($album_path)) mkdir($album_path);
        return rename($cover, $album_path.'main.png');
    }

    public function get_all()
    {
        $results = $this->db->get($this->table)->result_array();
        if(!$results) return $results;
        foreach($results as &$result)
        {
            $id = $result['id'];
            $result['texts'] = $this->albums_texts_model->get_albums_texts($id);
            $path = asset_path()."/images/albums/$id/main.png";
            $result['cover'] = file_exists($path) ? base_url("assets/albums/$id/main.png") : base_url($this->default_cover);
        }

        return $results;
    }
}