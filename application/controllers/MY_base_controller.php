<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_base_controller extends CI_Controller {

   /** @var  CI_Input */
    public $input;
    /** @var  CI_Loader */
    public $load;
    protected $menu_item;
    protected $menus = [];
    public $bulk_actions = [];
    /** @var  languages_model */
    public $languages_model;
    public $messages = [];
    /** @var CI_Session*/
    public $session;
    public $image_sizes = [];
    public $long_to_short = [
        'russian'=> 'ru',
        'english'=> 'en'
    ];
    public $current_language = 'english';
    public $current_language_short = 'en';
    public $custom_body_class = '';


    function __construct($menu_item = null)
    {
        parent::__construct();
        $this->menu_item = $menu_item;
        $this->load->model('languages_model');
        $get_lang = $this->input->get('l');
//        dump($this->lang->language);die;
        if($get_lang && array_key_exists($get_lang, $this->long_to_short))
        {
            $this->current_language = $get_lang;
            $this->session->set_userdata('language', $get_lang);
        }
        else
        {
            if(!$this->session->userdata('language'))
            {
                $this->session->set_userdata('language', $this->getLanguage());
            }
            else
            {
                $this->current_language = $this->session->userdata('language');
            }
        }
        $this->lang->load("main",$this->current_language);
        $this->current_language_short = $this->long_to_short[$this->current_language];
        $this->menus = [
            'home' => [
                'url' => base_url(''),
                'title' => lang('home'),
                'additional_params' => 'data-href="1"'
            ],
            'contacts' => [
                'url' =>  base_url('contacts'),
                'title' => lang('contacts'),
                'additional_params' => 'data-href="11"'
            ],
            'about_me' => [
                'url' => base_url('about'),
                'title' => lang('about_me'),
                'additional_params' => ''
            ],
            'portfolio' => [
                'url' => base_url('portfolio'),
                'title' => lang('portfolio'),
                'additional_params' => ''
            ]
        ];
    }

    private function getLanguage($default = 'english')
    {
        if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
            if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                $language = array_combine($list[1], $list[2]);
                foreach ($language as $n => $v)
                    $language[$n] = $v ? $v : 1;
                arsort($language, SORT_NUMERIC);
            }
            else $language = array();
        } else $language = array();
        $langs = [
            'russian'=> ['ru','be','uk','ky','ab','mo','et','lv'],
//            'arabian'=> 'ar',
            'english'=> ['en', 'fr', 'de', 'es', 'pt', 'ar']
        ];


        $languages=array();
        foreach ($langs as $lang => $alias) {
            if (is_array($alias)) {
                foreach ($alias as $alias_lang) {
                    $languages[strtolower($alias_lang)] = strtolower($lang);
                }
            }else $languages[strtolower($alias)]=strtolower($lang);
        }

        foreach ($language as $l => $v) {
            $s = strtok($l, '-'); // убираем то что идет после тире в языках вида "en-us, ru-ru"
            if (isset($languages[$s]))
                $this->current_language = $languages[$s];
                return $languages[$s];
        }
        return $default;
    }
    public function render_view($view, $breadcrumbs, $data, $folder = 'admin', $js = [], $css = [], $return = false)
    {
        // Загружаем хэдер
        $page['header'] = $this->load->view('_blocks/header', [
            'page_title' => isset($data['page_title']) ? $data['page_title'] : '', // Заголовок страницы
            'custom_js' => $js, // Кастомные JS
            'custom_css' => $css, // Кастомные стили
            'menus' => $this->menus, // Элементы бокового меню
            'menu_item' => $this->menu_item, // Текущий элемент меню
            'breadcrumbs' => $breadcrumbs

        ], $return);

        // Загружаем шаблон страницы
        $page['body'] = $this->load->view($folder.'/'.$view, $data, $return);

        // Загружаем футер
        $page['footer'] = $this->load->view('_blocks/footer', [], $return);

        if($return) return implode('', $page);
    }


    public function ajax($function)
    {
        if(!$this->input->is_ajax_request() || !method_exists($this, $function))
        {
            show_404();
            return false;
        }

        $this->$function();
        return true;
    }


    public function images_upload($type = null)
    {
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = asset_path().'/uploads/';
            if(!is_dir($targetPath))
            {
                mkdir($targetPath, DIR_WRITE_MODE, TRUE);
            }
            if ($handle = opendir($targetPath)) {

                while (false !== ($del_file = readdir($handle))) {
                    if ($del_file != "." && $del_file != "..") {
                        unlink($targetPath.$del_file);
                    }
                }
                closedir($handle);
            }
            $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png', 'bmp'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);


            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                if($type && array_key_exists($type, $this->image_sizes))
                {
                    $params = $this->image_sizes[$type];
                    $image_info = getimagesize($targetFile);
                    if($image_info[0] > $params['width'] || $image_info[1] > $params['height'])
                    {
                        if(
                        (isset($params['align']) && in_array($params['align'], ['width', 'height']))
                        )
                        {
                            if($params['align'] == 'width')
                            {
                                $width = $params['width'];
                                $height = ($width / $image_info[0]) * $image_info[1];
                            }
                            else
                            {
                                $height = $params['height'];
                                $width = ($height / $image_info[1]) * $image_info[0];
                            }
                        }
                        else
                        {
                            $width = $params['width'];
                            $height = $params['height'];
                        }
                        $fileParts['extension'] = $fileParts['extension'] == 'jpg' ? 'jpeg' : $fileParts['extension'];
                        $open_function = 'imagecreatefrom'.$fileParts ['extension'];
                        $write_function = 'image'.$fileParts ['extension'];
                        $rsr_org = $open_function($targetFile);
                        $rsr_org = imagescale($rsr_org, $width, $height,  IMG_BICUBIC_FIXED);
                        $write_function($rsr_org, $targetFile);
                        imagedestroy($rsr_org);
                    }
                }


                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function photos_upload($id)
    {
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = asset_path().'/images/albums/'.$id.'/';
            if(!is_dir($targetPath))
            {
                mkdir($targetPath, DIR_WRITE_MODE, TRUE);
            }


            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png' ,'bmp'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            $extension = strtolower($fileParts['extension']);
            $filename = substr(md5(rand()), 0, 7).'.'.$extension;
            $targetFile = rtrim($targetPath,'/') . '/' . $filename;

            if (in_array($extension,$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);

                echo $filename;
            } else {
                echo 'FALSE';
            }
        }
    }

    protected  function clear_directory($path)
    {
        if ($objs = glob($path."/*"))
        {
            foreach($objs as $obj) {
                is_dir($obj) ? $this->clear_directory($obj) : unlink($obj);
            }
        }
        rmdir($path);
    }



}
