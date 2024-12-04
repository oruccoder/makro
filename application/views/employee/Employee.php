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


defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model', 'employee');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
       if (!$this->aauth->premission(9)) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }
        $this->li_a = 'emp';
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $data['employee'] = $this->employee->list_employee();


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/list', $data);
        $this->load->view('fixed/footer');
    }

        public function salaries()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salaries', $data);
        $this->load->view('fixed/footer');
    }




    public function view()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Detaylar';
        $data['employee'] = $this->employee->employee_details($id);
        $data['permissions'] = $this->employee->permission_details();
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view', $data);
        $this->load->view('fixed/footer');

    }

        public function history()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Detaylar';
        $data['employee'] = $this->employee->employee_details($id);
        $data['history'] = $this->employee->salary_history($data['employee']['id']);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/history', $data);
        $this->load->view('fixed/footer');

    }


    public function add()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Ekle';
        $head['roles'] =role_names();

        $data['dept'] = $this->employee->department_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/add',$data);
        $this->load->view('fixed/footer');


    }

    public function submit_user()
    {
        if ($this->aauth->get_user()->roleid < 4) {
            redirect('/dashboard/', 'refresh');
        }

        $username = $this->input->post('username',true);
        $email = $this->input->post('email',true);
        $password = $this->input->post('password',true);
        $roleid = 3;
        if ($this->input->post('roleid')) {
            $roleid = $this->input->post('roleid');

        }

        if ($roleid > 3) {
            if ($this->aauth->get_user()->roleid < 5) {
                die('Yetkiniz Yok!');
            }
        }

        $location = $this->input->post('location',true);
        $name = $this->input->post('name',true);
        $phone = $this->input->post('phone',true);
        $email = $this->input->post('email',true);
        $address = $this->input->post('address',true);
        $city = $this->input->post('city',true);
        $region = $this->input->post('region',true);
        $country = $this->input->post('country',true);
        $postbox = $this->input->post('postbox',true);

        //Yeni Alanlar
        $salary = numberClean($this->input->post('salary', true));
        $commission = $this->input->post('commission', true);
        $department = $this->input->post('department', true);
        $calisma_sekli = $this->input->post('calisma_sekli', true);
        $sozlesme_turu = $this->input->post('sozlesme_turu', true);
        $sozlesme_date = $this->input->post('sozlesme_date', true);
        $resmi_maas = $this->input->post('resmi_maas', true);
        $gayri_resmi_maas = $this->input->post('gayri_resmi_maas', true);
        $date_created = $this->input->post('date_created', true);


        $sozlesme_dates=datefordatabase($sozlesme_date);
        $date_createds=datefordatabase($date_created);


        $a = $this->aauth->create_user($email, $password, $username);

        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $nuid = (string)$this->aauth->get_user($a)->id;

            if ($nuid > 0) {


                $this->employee->add_employee(
                    $nuid, (string)$this->aauth->get_user($a)->username,
                    $name, $roleid, $phone, $address, $city, $region, $country, $postbox,
                    $location, $salary, $commission, $department,$calisma_sekli,$sozlesme_turu,$sozlesme_dates
                ,$resmi_maas,$gayri_resmi_maas,$date_createds);

            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'There has been an error, please try again.'));
        }
    }

    public function invoices()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Faturaları';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountFormat($invoices->total);
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Ödemeler';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function translist()
    {
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->invoicedate;
            $row[] = $prd->account;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {

            $this->db->select('banned');
            $this->db->from('geopos_users');
            $this->db->where('id', $uid);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result['banned'] == 0) {
                $this->aauth->ban_user($uid);
            } else {
                $this->aauth->unban_user($uid);
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile updated successfully!'));


        }
    }

    function enable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {


            $a = $this->aauth->unban_user($uid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile disabled successfully!'));


        }
    }

    function delete_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('empid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not delete yourself!'));
        } else {

            $this->db->delete('geopos_employees', array('id' => $uid));

            $this->db->delete('geopos_users', array('id' => $uid));

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Toplam Alacak: ' . $details['credit'] . '<br> Topla Borç: ' . $details['debit']));

        }


    }


    public function test()
    {

    }

    public function calc_sales()
    {
        $csd = $this->input->post('eid');
        $total = $this->input->post('new_maas');
        $eid=$this->aauth->get_user()->id;

        $this->employee->sales_details($csd,$total,$eid);


    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 4) {
            redirect('/dashboard/', 'refresh');
        }

        $username = $this->input->post('username',true);
        $email = $this->input->post('email',true);
        $password = $this->input->post('password',true);
        $roleid = $this->input->post('roleid');

        /* if ($roleid > 3) {
            if ($this->aauth->get_user()->roleid < 5) {
                die('Yetkiniz Yok!');
            }
        }
        */


        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $eid = $this->input->post('eid',true);
            $name = $this->input->post('name',true);
            $phone = $this->input->post('phone',true);
            $phonealt = $this->input->post('phonealt',true);
            $address = $this->input->post('address',true);
            $city = $this->input->post('city',true);
            $region = $this->input->post('region',true);
            $country = $this->input->post('country',true);
            $postbox = $this->input->post('postbox',true);
            $location = $this->input->post('location',true);
            $salary = $this->input->post('salary',true);
             $department = $this->input->post('department',true);
             $commission = $this->input->post('commission',true);
             $date_created = $this->input->post('date_created',true);
              $calisma_sekli = $this->input->post('calisma_sekli', true);
        $sozlesme_turu = $this->input->post('sozlesme_turu', true);
        $sozlesme_date = $this->input->post('sozlesme_date', true);
        $resmi_maas = $this->input->post('resmi_maas', true);
        $gayri_resmi_maas = $this->input->post('gayri_resmi_maas', true);

            $date_createds = datefordatabase($date_created);
            $this->employee->update_employee($eid, $name, $roleid,
                $phone, $phonealt, $address, $city, $region, $country, $postbox, $location,$salary,
        $department,$commission,$date_createds,$calisma_sekli,$sozlesme_turu,$sozlesme_date,
                $resmi_maas,$gayri_resmi_maas);

        } else {

            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profili Düzenle';


            $data['user'] = $this->employee->employee_details($id);


             $data['dept'] = $this->employee->department_list($id);


            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("form_validation");

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {

                $newpassword = $this->input->post('newpassword');


                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));

                $this->aauth->update_user($eid, false, $newpassword, false);


            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }

        public function permissions()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kullanıcı İzinleri';
        $data['permission'] = $this->employee->employee_permissions();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/permissions',$data);
        $this->load->view('fixed/footer');


    }

            public function permissions_update()
            {

                $head['usernm'] = $this->aauth->get_user()->username;
                $head['title'] = 'Kullanıcı İzinleri';
                $permission = $this->employee->employee_permissions();

                foreach ($permission as $row) {
                    $i = $row['id'];
                    $name1 = 'r_' . $i . '_1';
                    $name2 = 'r_' . $i . '_2';
                    $name3 = 'r_' . $i . '_3';
                    $name4 = 'r_' . $i . '_4';
                    $name5 = 'r_' . $i . '_5';
                    $name6 = 'r_' . $i . '_6';
                    $name7 = 'r_' . $i . '_7';
                    $name8 = 'r_' . $i . '_8';
                    $name9 = 'r_' . $i . '_9';
                    $name10 = 'r_' . $i . '_10';
                    $name11 = 'r_' . $i . '_11';



                    $val1 = 0;
                    $val2 = 0;
                    $val3 = 0;
                    $val4 = 0;
                    $val5 = 0;
                    $val6 = 0;
                    $val7 = 0;
                    $val8 = 0;
                    $val9 = 0;
                    $val10 = 0;
                    $val11 = 0;


                    if ($this->input->post($name1)) $val1 = 1;
                    if ($this->input->post($name2)) $val2 = 1;
                    if ($this->input->post($name3)) $val3 = 1;
                    if ($this->input->post($name4)) $val4 = 1;
                    if ($this->input->post($name5)) $val5 = 1;
                    if ($this->input->post($name6)) $val6 = 1;
                    if ($this->input->post($name7)) $val7 = 1;
                    if ($this->input->post($name8)) $val8 = 1;
                    if ($this->input->post($name9)) $val9 = 1;
                    if ($this->input->post($name10)) $val10 = 1;
                    if ($this->input->post($name11)) $val11 = 1;

                    if($this->aauth->get_user()->roleid==5 && $i==9)  $val5=1;
                    $data = array('r_1' => $val1, 'r_2' => $val2, 'r_3' => $val3, 'r_4' => $val4, 'r_5' => $val5, 'r_6' => $val6, 'r_7' => $val7, 'r_8' => $val9, 'r_9' => $val9, 'r_10' => $val10, 'r_11' => $val11);
                    $this->db->set($data);
                    $this->db->where('id', $i);
                    $this->db->update('geopos_premissions');


                }

                 echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
            }


  public function holidays()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Holidays';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/holidays');
        $this->load->view('fixed/footer');

    }


       public function hday_list()
    {
        $list = $this->employee->holidays_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {
            $datetime1 = date_create($obj->val1);
$datetime2 = date_create($obj->val2);
$interval = date_diff($datetime1, $datetime2);
$day=$interval->format('%a days');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->val1;
            $row[] = $obj->val2;
            $row[] = $day;
            $row[] = $obj->val3;
            $row[] = "<a href='" . base_url("employee/editholiday?id=$obj->id") . "' class='btn btn-indigo btn-xs'><i class='icon-pen'></i> " . $this->lang->line('Edit') ."</a> ".'<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><i class="fas fa-trash-alt"></i></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->holidays_count_all(),
            "recordsFiltered" => $this->employee->holidays_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

        public function delete_hday()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteholidays($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

     public function addhday()
    {

        if ($this->input->post()) {

            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note',true);

            $date1=new DateTime($from);
            $date2=new DateTime($todate);
            if($date1<=$date2){


            if ($this->employee->addholidays($this->aauth->get_user()->loc,$from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "   <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            }
}
            else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR').'- Invalid'));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/addholyday', $data);
            $this->load->view('fixed/footer');
        }

    }


         public function editholiday()
    {

        if ($this->input->post()) {


            $id = $this->input->post('did');
            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note',true);

            if ($this->employee->edithday($id,$this->aauth->get_user()->loc,$from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['hday'] = $this->employee->hday_view($data['id'],$this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edithday', $data);
            $this->load->view('fixed/footer');
        }

    }


  public function departments()
    {
       $this->li_a = 'dep';
        $head['usernm'] = $this->aauth->get_user()->username;
         $data['department_list'] = $this->employee->department_list(0,$this->aauth->get_user()->loc);
        $head['title'] = 'Bölümler';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/departments',$data);
        $this->load->view('fixed/footer');

    }

    public function department()
    {
         $this->li_a = 'dep';
         $data['id'] = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
         $data['department'] = $this->employee->department_view($data['id'],$this->aauth->get_user()->loc);
         $data['department_list'] = $this->employee->department_elist($data['id'] );
        $head['title'] = 'Bölümler';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/department',$data);
        $this->load->view('fixed/footer');

    }

       public function delete_dep()
    {
         $this->li_a = 'dep';
        $id = $this->input->post('deleteid');


        if ($this->employee->deletedepartment($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

     public function adddep()
    {
 $this->li_a = 'dep';
        if ($this->input->post()) {

            $name = $this->input->post('name',true);


            if ($this->employee->adddepartment($this->aauth->get_user()->loc,$name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Bölüm Ekle';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/adddep');
            $this->load->view('fixed/footer');
        }

    }

         public function editdep()
    {
 $this->li_a = 'dep';
        if ($this->input->post()) {

            $name = $this->input->post('name',true);
            $id = $this->input->post('did');

            if ($this->employee->editdepartment($id,$this->aauth->get_user()->loc,$name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['department'] = $this->employee->department_view($data['id'],$this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Bölüm Düzenle';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editdep', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function payroll_create()
    {
        $this->load->library("Custom");
        $this->li_a = 'pay';
        $this->load->model('transactions_model', 'transactions');

        $data['dual'] = $this->custom->api_config(65);
       $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_create', $data);
        $this->load->view('fixed/footer');

    }

       public function emp_search()
    {

        $name = $this->input->get('keyword', true);


$whr='';
       if ($this->aauth->get_user()->loc) {
            $whr=' (geopos_users.loc='.$this->aauth->get_user()->loc.') AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_employees.* ,geopos_users.email FROM geopos_employees  LEFT JOIN geopos_users ON geopos_users.id=geopos_employees.id  WHERE $whr (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectPay('" . $row['id'] . "','" . $row['name'] . " ','" . $row['salary'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

     public function payroll()
    { $this->li_a = 'pay';

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll');
        $this->load->view('fixed/footer');
    }

     public function payroll_emp()
    {     $this->li_a = 'pay';
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_employee', $data);
        $this->load->view('fixed/footer');
    }



    public function payrolllist()
    {  $this->li_a = 'pay';
        $eid = $this->input->post('eid');
        $list = $this->employee->pay_get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->invoicedate;

            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
   $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a  href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span></a> ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->pay_count_all($eid),
            "recordsFiltered" => $this->employee->pay_count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

              public function attendances()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Attendance';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/attendance_list');
        $this->load->view('fixed/footer');

    }

                      public function attendance()
    {
            if ($this->input->post()) {
                   $emp = $this->input->post('employee');
                   $adate = datefordatabase($this->input->post('adate'));
            $from = timefordatabase($this->input->post('from'));
            $todate = timefordatabase($this->input->post('to'));
            $note = $this->input->post('note');

            if ($this->employee->addattendance($emp,$adate,$from,$todate,$note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='attendance' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='attendances' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }else {


                $data['emp'] = $this->employee->list_employee();
                $head['usernm'] = $this->aauth->get_user()->username;
                $head['title'] = 'New Attendance';
                $this->load->view('fixed/header', $head);
                $this->load->view('employee/attendance', $data);
                $this->load->view('fixed/footer');
            }

    }


       public function att_list()
    {
         $cid = $this->input->post('cid');
        $list = $this->employee->attendance_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate).' '.$obj->tfrom.' - '.$obj->tto;
           $row[] = $obj->note;

            $row[] = '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->attendance_count_all($cid),
            "recordsFiltered" => $this->employee->attendance_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
      public function delete_attendance()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteattendance($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function ekstre_data()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list = $this->employee->ekstre_datatables($cid, $tid,$para_birimi);

        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;

        foreach ($list as $invoices) {
            if($this->input->post('para_birimi')!='tumu')
            {
                $carpim=1;
            }
            else
            {
                $carpim=$invoices['kur_degeri'];
            }
            $no++;
            $row = array();
            $borc=$invoices['borc']*$carpim;
            $alacak=$invoices['alacak']*$carpim;


            if ($invoices['transactions'] == 'expense') {
                $alacak_toplam += $invoices['total']*$carpim;
            } elseif ($invoices['transactions'] == 'income') {
                $borc_toplam += $invoices['total']*$carpim;
            }
            $bakiye += ($borc-$alacak);

            $row[] = dateformat($invoices['invoicedate']);
            $row[] = $invoices['description'];
            $row[] = $this->lang->line($invoices['odeme_tipi']);
            $row[] = amountFormat($borc,$para_birimi);
            $row[] = amountFormat($alacak,$para_birimi);

            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->inv_count_all($cid),
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function izinler()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->employee->izinler_datatables($cid, $tid);

        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $invoices) {

            $id=$invoices['id'];
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = dateformat($invoices['created_date']);
            $row[] = izin_durumu($invoices['status']);
            if ($invoices['status']==0) {

               $row[] = '<a href="' . base_url() . 'employee/permissions_details?id=' . $id . '" data-toggle="modal"
         ><span class="icon-eye"></span> Görüntüle</a>

         <a href="' . base_url() . 'employee/permissions_edit?id=' . $id . '"  class="btn btn-warning ><span class="icon-plus-circle"></span> Düzenle</a>';;
           $data[] = $row;
            }else{

            $row[] = '<a href="' . base_url() . 'employee/permissions_details?id=' . $id . '" data-toggle="modal" id ="view_detail"
         ><span class="icon-eye"></span> Görüntüle</a>

         ';;

            $data[] = $row;
        }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->izinler_count_all($cid),
            "recordsFiltered" =>$this->employee->izinler_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


 public function permissions_add(){


    $this->load->view('fixed/header');
    $this->load->view('employee/permissions-add');
    $this->load->view('fixed/footer');

 }
 public function permissions_action(){

     $description = $this->input->post('description',true);
     $baslangic_tarihi = $this->input->post('baslangic_tarihi',true);
     $baslangic_saati = $this->input->post('baslangic_saati',true);
     $bitis_tarihi = $this->input->post('bitis_tarihi',true);
     $bitis_saati = $this->input->post('bitis_saati',true);

     $bas_t=datefordatabase($baslangic_tarihi);
     $bit_t=datefordatabase($bitis_tarihi);
     $emp_id= $this->aauth->get_user()->id;

     if($this->employee->add_permissions($description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id))
     {
         $this->load->model('communication_model');
         $yetkili_id=izin_yetkili_pers_id();
         $emp_fullname=personel_details($emp_id);
         $yetkili_izin_pers_email=personel_email($yetkili_id)['email'];
         $message=$emp_fullname.' Adlı Personeliniz İzin Talep Etmektedir.';

         $this->communication_model->send_email($yetkili_izin_pers_email, $emp_fullname, 'İzin Talebi', $message, false, '');


         echo json_encode(array('status' => 'Success', 'message' =>
             $this->lang->line('izin_talebi_basarili')));

     }else
         {
             echo json_encode(array('status' => 'Error', 'message' =>
                 $this->lang->line('ERROR')));
         }



 }
 public function permissions_details(){

     $id = $this->input->post('id');
  $data = $this->db->select('*')
                    ->from('geopos_izinler')
                    ->where('id',$id)
                    ->get()
                    ->row();
    print_r($data);
    exit();
    }


    public function permissions_edit(){
    $id = $this->input->get('id');
  $row = $this->db
  ->where("id",$id)
  ->get("geopos_izinler")->row();
  $viewdata = new stdClass();
  $viewdata->row = $row;

   $this->load->view('fixed/header');
  $this->load->view("employee/pers_edit",$viewdata);
   $this->load->view('fixed/footer');

    }
    public function pers_update(){
    $id = $this->input->post('id');
     $description = $this->input->post('description',true);
     $baslangic_tarihi = $this->input->post('baslangic_tarihi',true);
     $baslangic_saati = $this->input->post('baslangic_saati',true);
     $bitis_tarihi = $this->input->post('bitis_tarihi',true);
     $bitis_saati = $this->input->post('bitis_saati',true);

     $bas_t=datefordatabase($baslangic_tarihi);
     $bit_t=datefordatabase($bitis_tarihi);
     $emp_id= $this->aauth->get_user()->id;

     if($this->employee->edit_permissions($id,$description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id))
     {
         $this->load->model('communication_model');
         $yetkili_id=izin_yetkili_pers_id();
         $emp_fullname=personel_details($emp_id);
         $yetkili_izin_pers_email=personel_email($yetkili_id)['email'];
         $message=$emp_fullname.' Adlı Personeliniz İzin Talep Etmektedir.';

         $this->communication_model->send_email($yetkili_izin_pers_email, $emp_fullname, 'İzin Talebi', $message, false, '');


         echo json_encode(array('status' => 'Success', 'message' =>
             $this->lang->line('izin_Düzenleme_basarili')));

     }else
         {
             echo json_encode(array('status' => 'Error', 'message' =>
                 $this->lang->line('ERROR')));
         }



 }

 public function personel_salary(){
     $id = $this->input->post('personel_id');
     $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $id and status = 1")->row();
     $salary_type = $this->db->query("SELECT * FROM salary_type")->result();
     echo json_encode(array('status' => 'Success', 'item' =>$salary_details,'salary_type'=>$salary_type));
 }

}
