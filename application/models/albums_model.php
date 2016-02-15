<?php
require_once('MY_base_model.php');
class Albums_model extends MY_base_model
{
   /** @var  albums_texts_model */
    public $albums_texts_model;
    public $default_cover = 'assets/images/no_picture.png';

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
        unset($data['errors']);
        if($id) $this->update($id, $data);
        else $id = $this->add($data);
        $this->albums_texts_model->save_albums_texts($texts, $id);
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
        $result['photos_list'] = $this->get_albums_images($id);
        $result['photos'] = count($result['photos_list']);
        return $result;
    }

    public function get_album_by_slug($slug, $language)
    {

        /** @var  $CI Index */
        $CI = &get_instance();
        $this->db->select('a.*, at.title, at.description');
        $this->db->join($this->albums_texts_model->table.' at', 'at.albums_id = a.id ');
        $this->db->join($CI->languages_model->table.' l', 'l.id = at.languages_id');
        $result = $this->db->get_where($this->table.' a',['a.breadcrumb' => $slug, 'l.code' => $language])->row_array();
        if(!$result) return $result;
        $result['photos_list'] = $this->get_albums_images($result['id']);
        $result['photos'] = count($result['photos_list']);
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

    public function get_all($active_only = false)
    {
        if($active_only) $this->db->where('active', 1);
        $results = $this->db->get($this->table)->result_array();
        if(!$results) return $results;
        foreach($results as &$result)
        {
            $id = $result['id'];
            $result['texts'] = $this->albums_texts_model->get_albums_texts($id);
            $path = asset_path()."/images/albums/$id/main.png";
            $result['cover'] = file_exists($path) ? base_url("assets/images/albums/$id/main.png") : base_url($this->default_cover);
            $result['photos'] = count($this->get_albums_images($id));

        }

        return $results;
    }

    public function get_list($language, $active_only = true)
    {
        /** @var  $CI Index */
        $CI = &get_instance();
        $this->db->select('a.*, at.title, at.description');
        $this->db->join($this->albums_texts_model->table.' at', 'at.albums_id = a.id ');
        $this->db->join($CI->languages_model->table.' l', 'l.id = at.languages_id');
        $this->db->where('l.code', $language);
        if($active_only) $this->db->where('active', 1);
        $results = $this->db->get($this->table.' a')->result_array();
        if(!$results) return $results;
        foreach($results as $k => &$result)
        {
            $id = $result['id'];
            $path = asset_path()."/images/albums/$id/main.png";
            $result['cover'] = file_exists($path) ? base_url("assets/images/albums/$id/main.png") : base_url($this->default_cover);
            $result['photos'] = count($this->get_albums_images($id));
            if(!$result['photos']) unset($results[$k]);

        }
        return $results;
    }

    private function get_albums_images($id)
    {
        $path = asset_path().'/images/albums/'.$id;
        if(!is_dir($path)) return [];
        $result = [];
        if ($objs = glob($path."/*"))
        {
            foreach($objs as $obj) {
                if(is_dir($obj)) continue;
                $filename = str_replace($path.'/', '', $obj);
                if($filename == 'main.png') continue;
                $result[$filename] = base_url('assets/images/albums/'.$id.'/'.$filename);
            }
        }
        return $result;

    }
}