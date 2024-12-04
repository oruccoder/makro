<?php
/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ************************************************************************
 */

use Endroid\QrCode\QrCode;

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rest extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('restservice_model', 'restservice');
        $this->load->model('mobilapi_model', 'mobilapi');
        $this->load->model('malzemetalep_model', 'talep');
        $this->load->model('Carigidertalepnew_model', 'model_cari_gider');
        $this->load->model('Customeravanstalep_model', 'model_cari_avans');
        $this->load->model('Personelgidertalep_model', 'model_personel_gider');
        $this->load->model('Nakliye_model', 'model_nakliye');
        $this->load->model('onay_model', 'onay');
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function clients_get()
    {
        $id = $this->get('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function clients_post()
    {
        $id = $this->post('id');
        if ($id === NULL) {
            $list = $this->restservice->customers();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Client were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->customers($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Client could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


    public function clients_delete()
    {
        $id = (int)$this->get('id');
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        if ($this->restservice->delete_customers($id)) {
            $message = [
                'id' => $id,
                'message' => 'Deleted the resource'
            ];

            $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
        }
    }

    public function products_post()
    {

        $id = $this->post('id');
        if ($id === NULL) {
            $list_new = $this->restservice->products();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list_new) {
                // Set the response and exit
                $this->response($list_new, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list_new = $this->restservice->products($id);
        if (!empty($list_new)) {
            $this->set_response($list_new[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Products could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function invoice_get()
    {
        $id = $this->get('id');

        if ($id === NULL) {
            $list = $this->restservice->invoice($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($list) {
                // Set the response and exit
                $this->response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Products were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        // Find and return a single record for a particular user.
        $id = (int)$id;
        // Validate the id.
        if ($id <= 0) {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.
        $list = $this->restservice->invoice($id);
        if (!empty($list)) {
            $this->set_response($list[0], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invoice could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function test_api()
    {
        $id = $this->get('id');
        echo $id;
    }

    public function allcount()
    {
        $user_id=$_GET['userInfoID'];
        $result = $this->mobilapi->allcount($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }

    public function login_kontrol()
    {
        $email = $this->get('email');
        $password = $this->get('password');
        $result = $this->mobilapi->user_details($email,$password);

        $this->response($result, REST_Controller::HTTP_OK); // OK (200)
    }


    public function cari_avans_get_api()
    {

    }


    public function bekleyen_malzeme_ajax_list_get_api(){

        $start = $_GET['start'];
        $length = $_GET['length'];
        $tip = $_GET['tip'];
        $user_id = $_GET['user_id'];

        $list = $this->mobilapi->get_datatables_query_details_talep_list($start,$length,$tip,$user_id);


        $data = array();
        $no = $start;
        $href = "malzemetalep";
        $talep_type_hizmet = [105,106,107,108,109,110,111,112,113];

        if(in_array($tip,$talep_type_hizmet)){
            $href="hizmet";
        }

        foreach ($list as $prd) {
            $view = "<a class='btn btn-md btn-primary view' href='/$href/view/$prd->id' type='button'>Görüntüle</a>&nbsp;";
            if($tip==105){
                $view = "<a class='btn btn-md btn-primary view' href='/$href/view/$prd->id' type='button'>Görüntüle</a>&nbsp;";
            }
            $no++;
            $row = array();
            $row['code'] = $prd->code;
            $row['date'] = $prd->created_at;
            $row['proje'] = $prd->proje_name;
            $row['buttons'] =$view;
            $data[] = $row;
        }

        //output to json format
        echo json_encode(array(
            'data' => $data,
            'recordsFiltered' => $this->mobilapi->count_filtered_talep($start,$length,$tip,$user_id),
            'recordsTotal' => $this->mobilapi->count_all_talep($start,$length,$tip,$user_id),
        ));
    }
    public function bekleyen_malzeme_count($aauth_id){

        $loc = 5;
        if($aauth_id){
            $where_talep_form='';

            $where_talep_form.='and talep_form.loc='.$loc;
            $count = $this->db->query("SELECT * FROM `talep_onay_new` 
INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id
WHERE talep_onay_new.type = 1 AND  talep_form.status=1 and talep_form.talep_type=1 and talep_onay_new.user_id = $aauth_id AND `staff` = 1 $where_talep_form
")->num_rows();
            echo json_encode(array('status' => 1, 'count' =>$count));

        }
        else {

            echo json_encode(array('status' => 0, 'count' =>0));
        }


    }



}
