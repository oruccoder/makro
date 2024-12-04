<?php



class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->library("Custom");
        $this->load->model("UploadModel");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');
        }
    }


    public function file_upload()
    {

        $name = $this->input->get('name');
        $path = $this->input->get('path');
        $type = $this->input->get('op');


        $result = $this->UploadModel->file_upload($name = '', $path, $type = null);

        print_r($result);

    }
}
