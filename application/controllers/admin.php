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
            'ratio' => (4/3),
            'align' => 'width'
        ]
    ];

    public $languages;
    function __construct()
    {
        parent::__construct('admin');
        $this->languages = $this->languages_model->get_languages();
        $this->load->model('albums_model');
        $this->albums_model->default_cover = $this->default_cover;
        $this->load->helper('string');
        $this->bulk_actions = [
            'separated' =>
                [
                    [
                        'url' => 'categories/ajax_delete',
                        'title' => lang('delete'),
                        'class' => 'danger'
                    ]
                ],
        ];

    }

    public function index($page = 1)
    {
        $pages = 4;
        $list = $this->albums_model->get_all();
        $this->render_view('index', [['url' => $this->module, 'title' => 'Альбомы']], ['list' => $list, 'page' => $page, 'pages' => $pages] , $this->module);
    }


    public function create()
    {
        $data_form = ['action' => 'create', 'cover' => '', 'cover_path' => base_url($this->default_cover)];
        if($this->input->post())
        {
            $prepared = $this->prepare_data();
            $data = $prepared['data'];
            $errors = $prepared['errors'];
            if(!$errors)
            {
                $id = $this->albums_model->save_album($data);
                $this->session->set_flashdata('success', ['title' => 'Успех!', 'text' => 'Альбом успешно сохранен']);
                redirect(base_url($this->module.'/edit/'.$id));
            }
            else
            {
                $error = '';
                foreach($errors as $err){

                    $error .= '<br>'.$err;
                }
                $this->session->set_flashdata('danger', ['title' => 'Ошибка!', 'text' => $error]);
                if($data['cover']) $data['cover'] = base_url($this->upload_path.$data['cover']);
                $data_form = array_merge($data_form, $data);
            }
        }


        $breadcrumbs = [
            ['url' => $this->module, 'title' => 'Альбомы'],
            ['url' => $this->module.'/create', 'title' => 'Новый альбом']
        ];
        $this->render_view('form', $breadcrumbs, $data_form, $this->module);
    }



    public function edit($id)
    {
        $data_form = [
            'action' => 'edit/'.$id,
            'cover_path' => file_exists($this->albums_path.$id.'/main.png') ? base_url('assets/images/albums/'.$id.'/main.png') : base_url($this->default_cover),
            'cover' => ''
        ];
        if($this->input->post())
        {
            $prepared = $this->prepare_data();
            $data = $prepared['data'];
            $errors = $prepared['errors'];
            $data['id'] = $id;
            if(!$errors)
            {
                $this->albums_model->save_album($data, $id);
                $this->session->set_flashdata('success', ['title' => 'Успех!', 'text' => 'Альбом успешно сохранен']);
                $data['cover_path'] = file_exists($this->albums_path.$id.'/main.png') ? base_url('assets/images/albums/'.$id.'/main.png?s='.random_string()) : base_url($this->default_cover);
            }

            else
            {
                $error = '';
                foreach($errors as $err){

                    $error .= '<br>'.$err;
                }
                $this->session->set_flashdata('danger', ['title' => 'Ошибка!', 'text' => $error]);
                if($data['cover']) $data['cover_path'] = base_url($this->upload_path.$data['cover']);

            }
        }
        else
        {
            $data = $this->albums_model->get_album($id);
        }
        $breadcrumbs = [
            ['url' => $this->module, 'title' => 'Альбомы'],
            ['url' => $this->module.'/edit/'.$id, 'title' => '#'.$id]
        ];
        $data_form = array_merge($data_form, $data);

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
            'page_title' => lang('main_title'), // Заголовок страницы
            'custom_js' => $js, // Кастомные JS
            'custom_css' => $css, // Кастомные стили
            'menus' => $this->get_menus(), // Элементы бокового меню
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
                $errors[] = 'Введите заголовок для языка '.$this->languages[$langugage_id]['title'].'!';
            }
            $text['languages_id'] = $langugage_id;

        }

        if(!$data['breadcrumb']) $errors[] = 'Введите URL!';
        $data['cover'] = '';
        if($this->input->post('uploaded_cover') && file_exists( asset_path().'/uploads/'.$this->input->post('uploaded_cover')))
        {
                $data['cover'] = $this->input->post('uploaded_cover');
        }
        return ['data' => $data, 'errors' => $errors];
    }

    public function delete_cover()
    {
        $id = $this->input->post('id');
        if(!$id) echo 'FALSE';
        $path = asset_path().'/images/albums/'.$id.'/main.png';
        if(file_exists($path)) unlink($path);

        echo 'TRUE';

    }


}
