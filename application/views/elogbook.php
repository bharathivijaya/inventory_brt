<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Elogbook extends CI_Controller {

    public function index()
    {
        redirect('elogbook/dashboard');
    }

    public function dashboard()
    {
        $this->view();
    }


}