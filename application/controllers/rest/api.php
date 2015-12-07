<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/libraries/REST_Controller.php');
class Api extends REST_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function batch_get($device_name)
    {

        $this->load->model('categories_model');
        $r = $this->categories_model->get_batch($device_name);
        $this->response($r, 200);
    }

}
