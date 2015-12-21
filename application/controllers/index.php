<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/MY_base_controller.php');
class Index extends MY_base_controller{

    public $page_title = 'Tanya Prykhodko Photography';
    function __construct()
    {
        parent::__construct('index');
    }

    public function index()
    {
        $this->render_view('index', [], ['page_title' => $this->page_title], 'index');
    }

    public function portfolio_list()
    {
        $this->render_view('portfolio_list', [], ['page_title' => $this->page_title], 'index');
    }

    public function portfolio($id)
    {

        $this->render_view('portfolio', [], ['page_title' => $this->page_title], 'index');
    }

}
