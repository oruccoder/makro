<?php
defined('BASEPATH') OR exit('Dosya Yolu Bulunamadı');
require APPPATH.'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class ApiDemoController extends REST_Controller
{
    public function index()
    {
        $id = $this->get('id');
        $this->load->model('Personel_model', 'model');
        $data['details'] = $this->model->details($id);
        echo json_encode(array('status' => 200, 'details' =>$data['details']));

    }
}