<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/MY_base_controller.php');
class Index extends MY_base_controller{

    function __construct()
    {
        parent::__construct('index');
    }

    public function index()
    {
        $this->render_view('index', [], [], 'index');
    }

    public function portfolio_list()
    {
        $this->render_view('portfolio_list', [], [], 'index');
    }

    public function portfolio($id)
    {
        $this->render_view('portfolio', [], [], 'index');
    }

}
