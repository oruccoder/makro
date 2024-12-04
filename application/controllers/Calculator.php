<?php
class Calculator extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(5)) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }
    }
    public function index(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Hesap Makinesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('calculator/index', $head);
        $this->load->view('fixed/footer');

    }

}