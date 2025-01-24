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

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class User extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();


        // YRegards constructor code

        $this->load->library("Aauth");

        $this->load->library("Captcha_u");

        $this->load->library("form_validation");

        $this->captcha = $this->captcha_u->public_key()->captcha;

    }

    public function index()

    {

        $this->load->model('settings_model','settings');
        
        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $data['response'] = '';

        $data['captcha_on'] = $this->captcha;

        $data['firma_adi'] = $this->settings->firma_adi();



        $data['captcha'] = $this->captcha_u->public_key()->recaptcha_p;

        if ($this->input->get('e')) {

            $data['response'] = 'Parola,Kod veya Kullanıcı Adı Yanlış Girildi!';

        }




        $this->load->view('user/header');

        $this->load->view('user/index', $data);

        $this->load->view('user/footer');





    }

    public function yetki()

    {



        $this->load->model('settings_model','settings');

        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $data['response'] = '';

        $data['captcha_on'] = $this->captcha;

        $data['firma_adi'] = $this->settings->firma_adi();



        $data['captcha'] = $this->captcha_u->public_key()->recaptcha_p;

        if ($this->input->get('e')) {

            $data['response'] = 'Parola,Kod veya Kullanıcı Adı Yanlış Girildi!';

        }
        $this->load->library('session');
        if (!$this->session->userdata('selected_db')) {
            $this->session->set_userdata('selected_db', 'mobile_db');
        }


        $data['databases'] = [
            'default' => 'Varsayılan Veritabanı',
            'mobile_db' => 'Mobil Veritabanı'
        ];

        $this->load->view('user/header');

        $this->load->view('user/yetki', $data);

        $this->load->view('user/footer');





    }

    public function user_admin()

    {



        $this->load->model('settings_model','settings');



        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $data['response'] = '';

        $data['captcha_on'] = $this->captcha;

        $data['firma_adi'] = $this->settings->firma_adi();



        $data['captcha'] = $this->captcha_u->public_key()->recaptcha_p;

        if ($this->input->get('e')) {

            $data['response'] = 'Parola,Kod veya Kullanıcı Adı Yanlış Girildi!';

        }

        $this->load->view('user/header');

        $this->load->view('user/user_admin', $data);

        $this->load->view('user/footer');





    }







	public function hash_password_($id){
	 print $this->aauth->hash_password('makro7373',$id);
	}
    public function checklogin()

    {

        $user = $this->input->post('username');

        $password = $this->input->post('password');

        $remember_me = $this->input->post('remember_me');

        $yetki = $this->input->post('yetki');
       // $kode = $this->input->post('kode');

        $rem = false;

        if ($remember_me == 'on') {

            $rem = true;

        }

        if ($this->aauth->login(0,$user, $password, $rem, $this->captcha,$yetki=0)) {

            $ip_adres = $_SERVER["REMOTE_ADDR"];

            $this->aauth->applog("[Giriş Yapıldı] $user $ip_adres");
            $subject = 'Giriş Bilgisi';
            $message = "<h4>Sevgili $user</h4>, <p>".$_SERVER["REMOTE_ADDR"]." IP Adresinden Sizin adınıza Giriş Yapıldı</p><p>Saygılarımızla,<br>Firma " . $this->config->item('ctitle') . "</p>";
            if($_SERVER['HTTP_HOST']!='localhost:8089'){
                if($this->send_mail($this->aauth->get_user()->id,$subject,$message)){
                    redirect('/dashboard/', 'refresh');
                }
            }
            else{
                redirect('/dashboard/', 'refresh');
            }
        }
        else {
            redirect('/user/?e=eyxde', 'refresh');
        }
    }

    public function checklogin_yetki()
{
    $database = $this->input->post('database');
    $this->session->set_userdata('selected_db', $database);

    $user = $this->input->post('username');
    $password = $this->input->post('password');
    $remember_me = $this->input->post('remember_me');

    $rem = false;

    if ($remember_me == 'on') {
        $rem = true;
    }

    if ($this->aauth->login(0, $user, $password, $rem, $this->captcha)) {
        $user_data = $this->db->get_where('users', ['username' => $user])->row();

        $this->session->set_userdata('role', $user_data->role);

        redirect('/dashboard/', 'refresh');
    } else {
        redirect('/user/yetki', 'refresh');
    }
}


    public function send_mail($user_id,$subject,$message){
        $this->load->model('communication_model');
        if(!$user_id){
            return 0;
        }
        else {
            $message .= "<br><br><br><br>";
            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
            $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
            $recipients = array($proje_sorumlusu_email);
            $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
            return 1;
        }

    }

    public function profile()

    {

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = $head['usernm'] . ' Profil';

        $this->load->model('employee_model', 'employee');

        $id = $this->aauth->get_user()->id;

        $data['employee'] = $this->employee->employee_details($id);

        $data['eid'] = intval($id);

        $this->load->view('fixed/header', $head);

        $this->load->view('user/profile', $data);

        $this->load->view('fixed/footer');





    }



    public function attendance()

    {

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }





        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = $head['usernm'] . ' attendance ';





        $this->load->view('fixed/header', $head);

        $this->load->view('user/attendance');

        $this->load->view('fixed/footer');





    }



        public function holidays()

        {

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = $head['usernm'] . ' attendance ';



        $this->load->view('fixed/header', $head);

        $this->load->view('user/holidays');

        $this->load->view('fixed/footer');



    }



       public function getAttendance()

    {

         if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

           $this->load->model('employee_model', 'employee');

         $id = $this->aauth->get_user()->id;



        $start = $this->input->get('start');

        $end = $this->input->get('end');

        $result = $this->employee->getAttendance($id,$start, $end);

        echo json_encode($result);

    }



           public function getHolidays()

    {

         if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

           $this->load->model('employee_model', 'employee');

         $id = $this->aauth->get_user()->loc;



        $start = $this->input->get('start');

        $end = $this->input->get('end');

        $result = $this->employee->getHolidays($id,$start, $end);

        echo json_encode($result);

    }



    public function update()

    {

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }





        $id = $this->aauth->get_user()->id;

        $this->load->model('employee_model', 'employee');

        if ($this->input->post()) {

            $name = $this->input->post('name',true);

            $phone = $this->input->post('phone',true);

            $phonealt = $this->input->post('phonealt',true);

            $address = $this->input->post('address',true);

            $city = $this->input->post('city',true);

            $region = $this->input->post('region',true);

            $country = $this->input->post('country',true);

            $postbox = $this->input->post('postbox',true);

            $this->employee->update_employee($id, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox,$this->aauth->get_user()->loc);



        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = $head['usernm'] . ' Profile';





            $data['user'] = $this->employee->employee_details($id);

            $data['eid'] = intval($id);

            $this->load->view('fixed/header', $head);

            $this->load->view('user/edit', $data);

            $this->load->view('fixed/footer');

        }





    }



    public function displaypic()

    {



        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        $this->load->model('employee_model', 'employee');

        $id = $this->aauth->get_user()->id;

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

        $id = $this->aauth->get_user()->id;

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


		//print $this->aauth->hash_password('makro7373',727);
        //exit();
		if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        $id = $this->aauth->get_user()->id;

        $this->load->model('employee_model', 'employee');



        if ($this->input->post()) {

            $this->form_validation->set_rules('newpassword', 'Password', 'required');

            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');

            if ($this->form_validation->run() == FALSE) {

                echo json_encode(array('status' => 'Error', 'message' => '<br>Şifre uzunluğu en az 6 [a-z-0-9] olmalıdır!<br>Şifreler Eşleşmelidir!.'));

            }
            else {

                $cpassword = $this->input->post('cpassword');

                $newpassword = $this->input->post('newpassword');

                $renewpassword = $this->input->post('renewpassword');

                $hash = $this->aauth->hash_password($cpassword, $id);

                $metin=strtolower($newpassword);

                if (strstr($metin, "makro7373")) {
                    echo json_encode(array('status' => 'Error', 'message' => 'Yeni Şifreniz geçerli Değildir'));
                }
                else {
                    if (hash_equals($this->aauth->get_user()->pass, $hash)) {
                        $this->aauth->update_user($id, false, $newpassword, false);
                        $this->aauth->applog("Şifre Değiştirildi",$this->aauth->get_user()->username);

                        $data_onay = array(
                            'user_id' => $this->aauth->get_user()->id,
                            'pass_new' => $newpassword,
                            'status' => 1,
                        );
                        $this->db->insert('new_pass', $data_onay);

                        echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Şifreniz Güncellendi'));



                    }
                    else {

                        echo json_encode(array('status' => 'Error', 'message' => 'Geçerli şifreniz yanlış!'));

                    }
                }



            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = $head['usernm'] . ' Profile';

            $data['user'] = $this->employee->employee_details($id);

            $data['eid'] = intval($id);

            $this->load->view('fixed/header2', $head);

            $this->load->view('user/password', $data);

            $this->load->view('fixed/footer');

        }

    }

    public function forgot()

    {

        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $data['response'] = '';

        if ($this->input->get('e')) {

            $data['response'] = 'Parola,Kod veya Kullanıcı Adı Yanlış Girildi!';

        }

        $this->load->view('user/header');

        $this->load->view('user/forgot', $data);

        $this->load->view('user/footer');

    }


    public function send_reset()

    {

        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $data['response'] = '';

        $email = $this->input->post('email',true);

        $out = $this->aauth->remind_password($email);

        if ($out) {

            $this->load->model('communication_model');

            $mailtoc = $out['email'];

            $mailtotilte = $out['username'];

            $subject = '[' . $this->config->item('ctitle') . '] Password Reset Link';

            $link = base_url('user/reset_pass?code=' . $out['vcode'] . '&email=' . $email);

            $message = "<h4>Sevgili $mailtotilte</h4>, <p>Sizin için bir şifre sıfırlama isteği oluşturduk. Aşağıdaki bağlantıyı kullanarak şifreyi sıfırlayabilirsiniz.</p> <p><a href='$link'>$link</a></p><p>Saygılarımızla,<br>Firma " . $this->config->item('ctitle') . "</p>";

            $attachmenttrue = false;

            $attachment = '';

            $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
            echo json_encode(array('status' => 'Success', 'message' => 'Mail Başarıyla İletildi!'));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => 'Böyle Bir Mail Adresi Bulunamadı'));

        }

    }

    public function reset_pass()

    {

        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $data['code'] = $this->input->get('code',true);

        $data['email'] = $this->input->get('email',true);

        $data['response'] = '';

        if ($this->input->get('e')) {

            $data['response'] = 'Parola veya Kullanıcı Adı Yanlış Girildi';

        }

        if ($this->input->post('k')) {

            $this->load->model('general_model', 'general');

            $this->general->reset($this->input->post('k'));

        }

        $this->load->view('user/header');

        $this->load->view('user/reset', $data);

        $this->load->view('user/footer');

    }

    public function reset_change()

    {

        if ($this->aauth->is_loggedin()) {

            redirect('/dashboard/', 'refresh');

        }

        $password = $this->input->post('n_password',true);

        $code = $this->input->post('n_code',true);

        $email = $this->input->post('email',true);

        if (strlen($password) > 5) {

            $out = $this->aauth->reset_password($email, $code, $password);

            //   print_r($out);

            if ($out) echo json_encode(array('status' => 'Success', 'message' => "Şifreniz Başarıyla Güncellendi!  <a href='" . base_url() . "' class='btn btn-indigo btn-md'><span class='icon-home' aria-hidden='true'></span> " . $this->lang->line('Login') . "  </a>"));

            else echo json_encode(array('status' => 'Error', 'message' => "Süre Doldu! <a href='" . base_url() . "' class='btn btn-indigo btn-md'><span class='icon-home' aria-hidden='true'></span> " . $this->lang->line('Login') . "  </a>"));

        }

        $data['response'] = '';

        if ($this->input->get('e')) {

            $data['response'] = 'Parola,Kod veya Kullanıcı Adı Yanlış Girildi!';

        }

    }

    public function logout()

    {

        $this->aauth->applog('[Logged Out] '.$this->aauth->get_user()->username);

        $this->aauth->logout();

        redirect('/user/', 'refresh');

    }

    public function logout_new()

    {

        $this->aauth->applog('[Şifre Değişikli] '.$this->aauth->get_user()->username);
        $this->aauth->logout();
        echo json_encode(array('status' => 'Success', 'message' => 'Mail Başarıyla İletildi!'));


    }

            public function salary()

    {

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        $id = $this->aauth->get_user()->id;

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = $head['usernm'] . ' salary ';

      $this->load->model('employee_model', 'employee');

      $id = $this->aauth->get_user()->id;

       $data['employee_salary'] = $this->employee->salary_view($id);

  $data['employee'] = $this->employee->employee_details($id);

        $this->load->view('fixed/header', $head);

        $this->load->view('user/salary',$data);

        $this->load->view('fixed/footer');

    }

    public function firma_unut()

    {

        $this->load->helper('cookie');

        delete_cookie("db_name");
        redirect('/', 'refresh');

    }

}
