<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/MY_base_controller.php');
class Index extends MY_base_controller{

    public $page_title = 'Tanya Prykhodko Photography';
    /** @var  albums_model */
    public $albums_model;
    function __construct()
    {
        parent::__construct('home');
    }

    public function index($contacts = 0)
    {
        $this->menus['home']['url'] = $this->menus['contacts']['url'] = '#';
        $this->render_view('index', [], ['page_title' => $this->page_title, 'contacts' => $contacts], 'index');
    }

    public function about()
    {

        $this->menu_item = 'about_me';
        $this->custom_body_class = 'about-me_page ';
        $this->render_view('about-me', [], ['page_title' => $this->page_title], 'index');
    }

    public function portfolio_list()
    {
        $this->load->model('albums_model');
        $this->menu_item = 'portfolio';
        $this->render_view('portfolio_list', [], ['page_title' => $this->page_title, 'albums' => $this->albums_model->get_list($this->current_language_short)], 'index');
    }

    public function portfolio($slug)
    {
        $this->load->model('albums_model');
        $this->menu_item = 'portfolio';
        $album = $this->albums_model->get_album_by_slug($slug, $this->current_language_short);
        if(!$album)redirect(base_url('portfolio'));
        $this->render_view('portfolio', [], ['page_title' => $this->page_title, 'album' => $album], 'index');
    }


    public function form_process()
    {
        $post = $this->input->post();
        if(
            !$post ||
            !array_key_exists('name', $post) || !$post['name'] ||
            !array_key_exists('email', $post) || !$post['email'] || !filter_var($post['email'], FILTER_VALIDATE_EMAIL) ||
            !array_key_exists('message', $post) || !$post['message']
        )
        {
            echo(lang('required_empty'));
            return false;
        }
        $subject = $this->input->post('subject') ?: '-- НЕ УКАЗАНА --';
        $date = $this->input->post('date') ?: '-- НЕ УКАЗАНА --';
        $letter = "
    <html xmlns='http://www.w3.org/1999/xhtml'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
            <meta name='viewport' content='width=device-width, initial-scale=1.'/>
        </head>
        <body>
            <table style='padding: 10px; width: 80%'>
                <tr style='padding: 10px'>
                    <td style='padding: 10px; width: 20%'>
                        <b>Имя</b>
                    </td>
                    <td style='padding: 10px; width: 60%'>
                        {$post['name']}
                    </td>
                </tr>
                <tr>
                    <td style='padding: 10px; width: 20%'>
                        <b>Email</b>
                    </td>
                    <td style='padding: 10px; width: 60%'>
                        {$post['email']}
                    </td>
                </tr>
                <tr>
                    <td style='padding: 10px; width: 20%'>
                        <b>Тема</b>
                    </td>
                    <td style='padding: 10px; width: 60%'>
                        {$subject}
                    </td>
                </tr>
                <tr>
                    <td style='padding: 10px; width: 20%'>
                        <b>Желаемая Дата</b>
                    </td>
                    <td style='padding: 10px; width: 60%'>
                        {$date}
                    </td>
                </tr>
                <tr>
                    <td style='padding: 10px; width: 20%'>
                        <b>Сообщение</b>
                    </td>
                    <td style='padding: 10px; width: 60%'>
                        {$post['message']}
                    </td>
                </tr>
                <tr>
                    <td style='padding: 10px; width: 20%'>
                        <b>Отправлено с сайта:</b>
                    </td>
                    <td style='padding: 10px; width: 60%'>
                        ".date('Y-m-d H:i:s')."
                    </td>
                </tr>
            </table>
        </body>
    </html>
        ";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Server <'.FORM_SENDER.'>' . "\r\n";
        if(mail(FORM_RECIPIENT, 'Сообщение с сайта', $letter, $headers))
        {
            echo 'TRUE';
            return false;
        }
        else {
            echo 'error';
            return false;
        }
    }
}
