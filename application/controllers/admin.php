<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/MY_base_controller.php');
class Admin extends MY_base_controller{

    public $per_page = 20;
    public $module = 'admin';
    public $default_cover = 'assets/images/no_picture.png';
    public $upload_path = 'assets/uploads/';
    public $albums_path = 'assets/images/albums/';
    /** @var  albums_model */
    public $albums_model;

    public $image_sizes = [
        'cover' => [
            'width' => 1269,
            'height' => 180,
            'ratio' => 1.3,
            'align' => 'width'
        ]
    ];

    public $languages;
    function __construct()
    {
        parent::__construct('admin');
        $this->languages = $this->languages_model->get_languages();
        $this->load->model('albums_model');
        $this->load->helper('string');
        $this->bulk_actions = [
            'separated' =>
                [
//                    [
//                        'url' => 'categories/ajax_delete',
//                        'title' => lang('delete'),
//                        'class' => 'danger'
//                    ]
                ],
        ];

    }

    public function index($page = 1)
    {
        $pages = 4;
        if(!$this->session->userdata('logged_in')) redirect(base_url('login'));
        $list = $this->albums_model->get_all();
        $this->render_view('index', [['url' => $this->module, 'title' => 'Альбомы']], ['list' => $list, 'page' => $page, 'pages' => $pages] , $this->module);
    }

    public function photos($id)
    {
        if(!$this->session->userdata('logged_in')) redirect(base_url('login'));
        $album = $this->albums_model->get_album($id);
        $breadcrumbs = [
            ['url' => $this->module, 'title' => 'Альбомы'],
            ['url' => $this->module.'/edit/'.$id, 'title' => $album['texts'][1]['title']],
            ['url' => $this->module.'/photos/'.$id, 'title' => 'Фотографии']
        ];
        $this->render_view('photos', $breadcrumbs, ['album' => $album, 'list' => $album['photos_list']] , $this->module);
    }


    public function create()
    {
        if(!$this->session->userdata('logged_in')) redirect(base_url('login'));
        $data_form = ['action' => 'create', 'cover' => '', 'cover_path' => base_url($this->default_cover), 'errors' => []];
        if($this->input->post())
        {
            $prepared = $this->prepare_data();
            $data = $prepared['data'];
            $data['errors'] = $errors = $prepared['errors'];
            if(!$errors)
            {
                $id = $this->albums_model->save_album($data);
                $this->session->set_flashdata('success', ['title' => 'Успех!', 'text' => 'Альбом успешно сохранен']);
                redirect(base_url($this->module.'/edit/'.$id));
            }
            else
            {
                $error = '<br><br>'.implode('<br><br>', $errors);
                $this->session->set_flashdata('danger', ['title' => 'Ошибка!', 'text' => $error]);
                if($data['cover']) $data['cover_path'] = base_url($this->upload_path.$data['cover']);
                $data_form = array_merge($data_form, $data);
            }
        }
//        var_dump($data_form);die;

        $breadcrumbs = [
            ['url' => $this->module, 'title' => 'Альбомы'],
            ['url' => $this->module.'/create', 'title' => 'Новый альбом']
        ];
        $this->render_view('form', $breadcrumbs, $data_form, $this->module);
    }



    public function edit($id)
    {
        if(!$this->session->userdata('logged_in')) redirect(base_url('login'));
        $data_form = [
            'action' => 'edit/'.$id,
            'cover_path' => file_exists($this->albums_path.$id.'/main.png') ? base_url('assets/images/albums/'.$id.'/main.png') : base_url($this->default_cover),
            'cover' => '',
            'errors' => []
        ];
        if($this->input->post())
        {
            $prepared = $this->prepare_data();
            $data = $prepared['data'];
            $data['errors'] = $errors = $prepared['errors'];
            $data['id'] = $id;
            if(!$errors)
            {
                $this->albums_model->save_album($data, $id);
                $this->session->set_flashdata('success', ['title' => 'Успех!', 'text' => 'Альбом успешно сохранен']);
                $data['cover_path'] = file_exists($this->albums_path.$id.'/main.png') ? base_url('assets/images/albums/'.$id.'/main.png?s='.random_string()) : base_url($this->default_cover);
            }

            else
            {
                $error = '<br><br>'.implode('<br><br>', $errors);
                $this->session->set_flashdata('danger', ['title' => 'Ошибка!', 'text' => $error]);
                if($data['cover']) $data['cover_path'] = base_url($this->upload_path.$data['cover']);

            }
        }
        else
        {
            $data = $this->albums_model->get_album($id);
        }
        $data_form = array_merge($data_form, $data);
        $breadcrumbs = [
            ['url' => $this->module, 'title' => 'Альбомы'],
            ['url' => $this->module.'/edit/'.$id, 'title' => $data_form['texts'][1]['title']]
        ];


        $this->render_view('form', $breadcrumbs, $data_form, $this->module);
    }


    public function render_view($view, $breadcrumbs, $data, $folder = 'admin', $js = [], $css = [], $return = false)
    {
        // Загружаем хэдер
        $page['header'] = $this->load->view('_blocks/header', [
            'page_title' => 'Admin Module', // Заголовок страницы
            'custom_js' => $js, // Кастомные JS
            'custom_css' => $css, // Кастомные стили
        ], $return);

        $page['additional_header'] = $this->load->view('_blocks/admin_head', [
            'page_title' => 'Main Title', // Заголовок страницы
            'custom_js' => $js, // Кастомные JS
            'custom_css' => $css, // Кастомные стили
            'menus' => $this->menus, // Элементы бокового меню
            'menu_item' => $this->module, // Текущий элемент меню,
            'breadcrumbs' => $breadcrumbs
        ], $return);

        // Загружаем шаблон страницы
        $page['body'] = $this->load->view($folder.'/'.$view, $data, $return);


        // Загружаем футер
        $page['footer'] = $this->load->view('_blocks/footer', [], $return);

        if($return) return implode('', $page);
    }

    protected function prepare_data()
    {
        $data['font_color'] = $this->input->post('font_color');
        $data['breadcrumb'] = $this->input->post('breadcrumb');
        $data['active'] = !!$this->input->post('active') ? 1 : 0;
        $errors = [];
        $data['texts']  = $this->input->post('texts');
        foreach($data['texts'] as $langugage_id => &$text)
        {
            if(!$text['title'])
            {
                $errors[$langugage_id] = 'Введите заголовок для языка '.$this->languages[$langugage_id]['title'].'!';
            }
            $text['languages_id'] = $langugage_id;

        }

        if(!$data['breadcrumb']) $errors['url'] = 'Введите URL!';
        $data['cover'] = '';

        if($this->input->post('uploaded_cover') && file_exists( asset_path().'/uploads/'.$this->input->post('uploaded_cover')))
        {
            $data['cover'] = $this->input->post('uploaded_cover');
        }
        return ['data' => $data, 'errors' => $errors];
    }

    protected function delete_cover()
    {
        $id = $this->input->post('id');
        if(!$id) die('FALSE');
        $path = asset_path().'/images/albums/'.$id.'/main.png';
        if(file_exists($path)) unlink($path);

        echo 'TRUE';

    }

    protected function delete_album()
    {
        $id = $this->input->post('id');
        if(!$id) die('FALSE');
        $this->albums_model->delete($id);
        $path = asset_path().'/images/albums/'.$id;
        if(is_dir($path)) $this->clear_directory($path);

        echo 'TRUE';
    }

    protected function update_album_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if(!$id || $status === false ) die('FALSE');
        $this->albums_model->update($id, ['active' => $status]);
        echo 'TRUE';
    }

    protected function delete_photo()
    {
        $album_id = $this->input->post('album_id');
        $filename = $this->input->post('filename');
        if(!$album_id || !$filename) die('FALSE');
        $path = asset_path().'/images/albums/'.$album_id.'/'.$filename;
        if(file_exists($path)) unlink($path);
        echo('TRUE');
    }




}
