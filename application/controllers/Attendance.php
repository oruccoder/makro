<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Attendance_model');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {

        $user = $this->aauth->get_user()->id; // Giriş yapan kullanıcı ID'si
        $role_id = $this->aauth->get_user()->roleid; // Kullanıcı rolü
        $santiye_id = personel_salary_details_get($user)->proje_id; // Kullanıcının şantiyesi
        $status = true;

        // Kullanıcı tüm personelleri görme yetkisine sahip değilse
        if (!$this->aauth->premission(96)->read) {
            if (in_array($role_id, [10, 40, 48,6,19,30])) {

                $status = true;
            } else {
                // Diğer rollerde kullanıcı yetkisiz
                $status = false;
            }
        }


        if($status){
            date_default_timezone_set('Asia/Baku');
            $logged_user_id = $this->aauth->get_user()->id;
            $user_project_id = personel_salary_details_get($logged_user_id)->proje_id;

            if (!$user_project_id) {
                show_error("Proje bilgisi bulunamadı.");
                return;
            }

            $data['date'] = date('Y-m-d');
            $data['project_id'] = $user_project_id;
            $data['project_users'] = $this->Attendance_model->get_users_with_attendance($user_project_id, $data['date']);
            $data['project_users_podradci'] = $this->Attendance_model->get_users_with_attendance_podradci($user_project_id, $data['date']);
            $data['project_name'] = proje_code($user_project_id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Personel Çizelgesi';
            $this->load->view('fixed/header', $head);
            $this->load->view('attendance/index', $data);
            $this->load->view('fixed/footer');
        }
        else {
            exit('<h3>Üzgünüm! Giriş Yetkiniz Yoktur</h3>');
        }

    }

    public function get_users_by_type()
    {
        $tip = $this->input->post('tip');

        $logged_user_id = $this->aauth->get_user()->id;
        $user_project_id = personel_salary_details_get($logged_user_id)->proje_id;


        if ($tip == 1) {
            // Personel için tablo oluştur
            $project_users = $this->Attendance_model->get_users_with_attendance($user_project_id, date('Y-m-d'));
            $this->load->view('attendance/personel_table', [
                'project_users' => $project_users,
                'date' => date('Y-m-d'),
                'project_id' => $user_project_id
            ]);
        } elseif ($tip == 2) {
            // Podradçı Personel için tablo oluştur
            $project_users_podradci = $this->Attendance_model->get_users_with_attendance_podradci($user_project_id, date('Y-m-d'));

            $data['project_users']=$project_users_podradci;
            $data['date']=date('Y-m-d');
            $data['project_id']=$user_project_id;

            $this->load->view('attendance/podradci_table',$data);
        }
    }

    public function report()
    {
        $head['title'] = 'Personel Çizelge Raporu';
        $this->load->view('fixed/header', $head);
        $this->load->view('attendance/report');
        $this->load->view('fixed/footer');
    }

    public function all_reports_ajax()
    {
        // CSRF koruma
        if (!$this->input->is_ajax_request()) {
            show_error('Geçersiz istek', 403);
            return;
        }

        // DataTables parametrelerini al
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start')); // Kaçıncı kayıttan başlanacağı
        $length = intval($this->input->post('length')); // Sayfa başına kaç kayıt gösterileceği
        $search_value = $this->input->post('search')['value']; // Arama terimi
        // Girdi verilerini al
        $project_id = $this->input->post('project_id');
        $user_id = $this->input->post('user_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $tip = $this->input->post('tip');
        $report_type = $this->input->post('report_type');

        // Model'den veri al

        // Toplam kayıt sayısı
        $total_records = $this->Attendance_model->count_all_reports( $project_id,
            $user_id,
            $start_date,
            $end_date,
            $search_value,
            $tip
        );

        // Filtrelenmiş kayıt sayısı
        $filtered_records = $this->Attendance_model->count_filtered_reports($project_id,
            $user_id,
            $start_date,
            $end_date,
            $search_value,
            $tip
        );

        // Sorgudan alınan veriler (sayfalama uygulanır)
        $records = $this->Attendance_model->get_paginated_reports(
            $project_id,
            $user_id,
            $start_date,
            $end_date,
            $search_value,
            $start,
            $length,
            $tip
        );

        $data = [];
        $say=0;
        foreach ($records as $row) {

            $st_date = $row['start_date'];
            $en_date = $row['end_date'];
            $pers_id = $row['user_id'];
            $proje_id_row = $row['project_id'];
            $imza_dosyalari = "<button class='signature_history' proje_id='$proje_id_row' start_date='$st_date' end_date='$en_date' pers_id ='$pers_id' >İmzaları Görüntüle</button>";
            $say++;
            if($row['user_type']=='Personel'){
                $role_name = role_name_user($row['user_id']);

            }
            else {
                $role_name = role_name_user_p($row['user_id']);

            }
            $data[] = [
                $say,
                $row['project_name'],
                $row['user_name'],
                $role_name,
                round($row['total_work_minutes'] / 60, 2), // Çalışma saatine dönüştür
                round($row['total_break_minutes'] / 60, 2), // Mola saatine dönüştür
                $row['total_days'],
                $row['start_date'].' | '.$row['end_date'],
                $row['user_type'],
                $imza_dosyalari,
            ];
        }
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filtered_records,
            'data' => $data
        ]);
    }
    public function save_all_records_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Geçersiz istek', 403);
            return;
        }

        $project_id = $this->input->post('project_id');
        $date = $this->input->post('date');
        $tip = $this->input->post('tip');
        $auth_id = $this->aauth->get_user()->id;

        $is_any_row_filled = false;

        foreach ($this->input->post('entry_time') as $user_id => $entry_time) {
            $break_start = $this->input->post('break_start')[$user_id];
            $break_end = $this->input->post('break_end')[$user_id];
            $exit_time = $this->input->post('exit_time')[$user_id];
            $description = trim($this->input->post('description')[$user_id]); // Trim ile boşlukları temizle

            // Eğer tüm alanlar boşsa bu kullanıcıyı atla
            if (empty($entry_time) && empty($break_start) && empty($break_end) && empty($exit_time) && empty($description)) {
                continue;
            }

            $is_any_row_filled = true;

            // Aynı gün ve aynı kullanıcı için bir kayıt var mı kontrol et
            $existing_record = $this->Attendance_model->get_record($user_id, $project_id, $date,$tip);

            $data = [
                'user_id' => $user_id,
                'project_id' => $project_id,
                'date' => $date,
                'auth_id' => $auth_id,
                'tip' => $tip,
                'entry_time' => (!empty($entry_time) && $entry_time !== '00:00:00') ? $entry_time : null,
                'break_start' => (!empty($break_start) && $break_start !== '00:00:00') ? $break_start : null,
                'break_end' => (!empty($break_end) && $break_end !== '00:00:00') ? $break_end : null,
                'exit_time' => (!empty($exit_time) && $exit_time !== '00:00:00') ? $exit_time : null,
                'description' => !empty($description) ? $description : null
            ];

            if ($existing_record) {
                // Kayıt varsa güncelle
                $this->Attendance_model->update_record($existing_record->id, $data);
                $this->talep_history($project_id,$data);

            } else {
                // Kayıt yoksa yeni ekle
                $this->Attendance_model->save_record($data);
                $this->talep_history($project_id,$data);

            }
        }

        if (!$is_any_row_filled) {
            echo json_encode(['status' => 'error', 'message' => 'En az bir personelin verisi girilmelidir.']);
            return;
        }

        echo json_encode(['status' => 'success', 'message' => 'Tüm kayıtlar başarıyla kaydedildi.']);
    }

    public function talep_history($id,$data)
    {
        date_default_timezone_set('Asia/Baku');
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $this->aauth->get_user()->id,
            'desc' => json_encode($data),
        );
        $this->db->insert('attendance_history', $data_step);
    }

    public function upload_file_ajax()
    {
        $config['upload_path'] = './userfiles/attach/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|png';
        $config['max_size'] = 2048;
        $project_id = $this->input->post('project_id'); // Proje ID'sini al
        $date = $this->input->post('date'); // Tarihi al


        // Dosya adını benzersiz hale getirme
        $file_name = uniqid() . "_" . time(); // Rastgele dosya adı oluştur
        $config['file_name'] = $file_name;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
            return;
        }

        $file_data = $this->upload->data();
        $file_path = 'userfiles/attach/' . $file_data['file_name'];


        // Daha önce bu proje ve tarih için yüklenmiş dosya var mı?
        $existing_file = $this->db->select('file_path')
            ->from('attendance_project_files')
            ->where('project_id', $project_id)
            ->where('date', $date)
            ->get()
            ->row();

        if ($existing_file) {
            // Var olan dosyayı sil
            $old_file_path = $existing_file->file_path;
            if (file_exists($old_file_path)) {
                unlink($old_file_path); // Eski dosyayı sil
            }

            // Veritabanında mevcut kaydı güncelle
            $this->db->where('project_id', $project_id)
                ->where('date', $date)
                ->update('attendance_project_files', ['file_path' => $file_path]);


            $text=[
                'mesaj'=>'File Güncellendi',
                'file_path'=>$file_path,
                'date'=>$date,
            ];
            $this->talep_history($project_id,$text);

        } else {
            // Yeni kayıt oluştur
            $data = [
                'project_id' => $project_id,
                'date' => $date,
                'file_path' => $file_path
            ];
            $this->db->insert('attendance_project_files', $data);

            $text=[
                'mesaj'=>'File Eklendi',
                'file_path'=>$file_path,
                'date'=>$date,
            ];
            $this->talep_history($project_id,$text);

        }


        echo json_encode(['status' => 'success', 'file_path' => $file_path, 'message' => 'Dosya başarıyla yüklendi.']);
    }

    public function get_existing_file()
    {
        $project_id = $this->input->post('project_id');
        $date = $this->input->post('date');

        $existing_file = $this->db->select('file_path')
            ->from('attendance_project_files')
            ->where('project_id', $project_id)
            ->where('date', $date)
            ->get()
            ->row();

        if ($existing_file) {
            echo json_encode(['status' => 'success', 'file_path' => base_url($existing_file->file_path)]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Dosya bulunamadı.']);
        }
    }



    public function view_records($project_id, $date)
    {
        $data['date'] = $date;
        $data['project'] = $this->Attendance_model->get_project_with_files($project_id, $date);
        $data['attendance'] = $this->Attendance_model->get_daily_records_by_project($project_id, $date);
        $this->load->view('attendance_records_view', $data);
    }

    public function signature()
    {

        $user = $this->aauth->get_user()->id; // Giriş yapan kullanıcı ID'si
        $role_id = $this->aauth->get_user()->roleid; // Kullanıcı rolü
        $santiye_id = personel_salary_details_get($user)->proje_id; // Kullanıcının şantiyesi
        $status = true;

        // Kullanıcı tüm personelleri görme yetkisine sahip değilse
        if (!$this->aauth->premission(96)->read) {
            if (in_array($role_id, [10, 40, 48,6,19,30])) {

                $status = true;
            } else {
                // Diğer rollerde kullanıcı yetkisiz
                $status = false;
            }
        }

        if($status){
            $proje_id= personel_salary_details_get($this->aauth->get_user()->id)->proje_id;
            $data['proje_id']=$proje_id;
            $head['title'] = 'Personel Çizelgesi';
            $this->load->view('fixed/header', $head);
            $this->load->view('attendance/signature',$data);
            $this->load->view('fixed/footer');
        }
        else {
            exit('<h3>Üzgünüm! Giriş Yetkiniz Yoktur</h3>');
        }

    }



    public function upload_signature_ajax()
    {
        date_default_timezone_set('Asia/Baku');
        $pers_id = $this->input->post('pers_id'); // Personel ID
        $signature = $this->input->post('signature'); // Base64 formatındaki imza
        $imza_type = $this->input->post('imza_type'); //1 Giriş İmzası 0 Çıkış İmzası
        $date = date('Y-m-d'); // Bugünün tarihi

        if (!$pers_id || !$signature) {
            echo json_encode(['status' => 410, 'message' => 'Personel ID veya imza eksik.']);
            return;
        }

        // Base64 imzayı dosyaya kaydet
        $signature_data = str_replace('data:image/png;base64,', '', $signature);
        $signature_data = base64_decode($signature_data);

        $file_name = 'signature_' . $pers_id . '_' . time() . '.png';
        $file_path = 'userfiles/attach/' . $file_name;

        if (!file_put_contents($file_path, $signature_data)) {
            echo json_encode(['status' => 'error', 'message' => 'İmza kaydedilemedi.']);
            return;
        }

        $date_now = date('Y-m-d H:i:s'); // Şu anki tarih ve saat

        // attendance tablosunda personel ve tarih bazlı kayıt kontrolü

        if($imza_type==1){
            $proje_id= personel_salary_details_get($pers_id)->proje_id;
            $existing_record = $this->db->select('id, in_signature_path')
                ->from('attendance')
                ->where('user_id', $pers_id)
                ->where('project_id', $proje_id)
                ->where('date', $date)
                ->where('entry_time IS NOT NULL') // entry_time doluysa
                ->get()
                ->row();

            if ($existing_record) {
                // Kayıt varsa eski dosyayı sil ve kaydı güncelle
                if (!empty($existing_record->in_signature_path) && file_exists($existing_record->in_signature_path)) {
                    unlink($existing_record->in_signature_path);
                }

                $this->db->where('id', $existing_record->id)
                    ->update('attendance', ['in_signature_path' => $file_path,'in_signature_date'=>$date_now]);

                $data_histor=[
                    'durum'=>'Giriş imzası Güncellendi',
                    'imza_atan_pers'=>$pers_id,
                    'imzayi_attiran_pers'=>$this->aauth->get_user()->id,
                    'kayit_tarihi'=>$date_now
                ];
                $this->talep_history($proje_id,$data_histor);


                echo json_encode(['status' => 200, 'message' => 'İmza başarıyla güncellendi.', 'file_path' => $file_path]);
            } else {
                // Yeni kayıt ekle
                // Attendance tablosunda mevcut kayıt kontrolü
                $existing_record_entry_kontrol = $this->db->select('id, entry_time')
                    ->from('attendance')
                    ->where('user_id', $pers_id)
                    ->where('date', $date)
                    ->get()
                    ->row();

                if ($existing_record_entry_kontrol) {
                    // Eğer entry_time doluysa yeni kayıt ekle
                    if (!empty($existing_record_entry_kontrol->entry_time)) {
                        $data = [
                            'user_id' => $pers_id,
                            'date' => $date,
                            'in_signature_path' => $file_path,
                            'in_signature_date' => $date_now
                        ];
                        $this->db->insert('attendance', $data);

                        $data_histor=[
                            'durum'=>'Giriş imzası Eklendi',
                            'imza_atan_pers'=>$pers_id,
                            'imzayi_attiran_pers'=>$this->aauth->get_user()->id,
                            'kayit_tarihi'=>$date_now
                        ];
                        $this->talep_history($proje_id,$data_histor);

                        echo json_encode(['status' => 200, 'message' => 'İmza başarıyla kaydedildi.', 'file_path' => $file_path]);

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Yeni kayıt başarıyla eklendi.'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Kayıt mevcut ancak Giriş Kaydı boş. İmza Atmak İçin Giriş Saatlerini Doldurunuz.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Kullanıcıya Giriş Saatleri Tanımlanmamış'
                    ]);
                }

            }
        }
        else {
            $proje_id= personel_salary_details_get($pers_id)->proje_id;
            $existing_record = $this->db->select('id, out_signature_path')
                ->from('attendance')
                ->where('user_id', $pers_id)
                ->where('project_id', $proje_id)
                ->where('date', $date)
                ->where('exit_time IS NOT NULL') // entry_time doluysa
                ->get()
                ->row();

            if ($existing_record) {
                // Kayıt varsa eski dosyayı sil ve kaydı güncelle
                if (!empty($existing_record->out_signature_path) && file_exists($existing_record->out_signature_path)) {
                    unlink($existing_record->out_signature_path);
                }

                $this->db->where('id', $existing_record->id)
                    ->update('attendance', ['out_signature_path' => $file_path, 'out_signature_date' => $date_now]);


                $data_histor=[
                    'durum'=>'Çıkış imzası Güncellendi',
                    'imza_atan_pers'=>$pers_id,
                    'imzayi_attiran_pers'=>$this->aauth->get_user()->id,
                    'kayit_tarihi'=>$date_now
                ];
                $this->talep_history($proje_id,$data_histor);

                echo json_encode(['status' => 200, 'message' => 'İmza başarıyla güncellendi.', 'file_path' => $file_path]);
            } else {


                // Yeni kayıt ekle
                // Attendance tablosunda mevcut kayıt kontrolü
                $existing_record_exit_time_kontrol = $this->db->select('id, exit_time')
                    ->from('attendance')
                    ->where('user_id', $pers_id)
                    ->where('date', $date)
                    ->get()
                    ->row();

                if ($existing_record_exit_time_kontrol) {
                    // Eğer entry_time doluysa yeni kayıt ekle
                    if (!empty($existing_record_exit_time_kontrol->exit_time)) {
                        $data = [
                            'user_id' => $pers_id,
                            'date' => $date,
                            'out_signature_path' => $file_path,
                            'out_signature_date' => $date_now
                        ];
                        $this->db->insert('attendance', $data);

                        $data_histor=[
                            'durum'=>'Çıkış imzası Eklendi',
                            'imza_atan_pers'=>$pers_id,
                            'imzayi_attiran_pers'=>$this->aauth->get_user()->id,
                            'kayit_tarihi'=>$date_now
                        ];
                        $this->talep_history($proje_id,$data_histor);

                        echo json_encode(['status' => 200, 'message' => 'İmza başarıyla kaydedildi.', 'file_path' => $file_path]);

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Yeni kayıt başarıyla eklendi.'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Kayıt mevcut ancak Çıkış Kaydı boş. İmza Atmak İçin Çıkış Saatlerini Doldurunuz.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Kullanıcıya Çıkış Saatleri Tanımlanmamış'
                    ]);
                }




            }
        }


    }

    public function imza_list()
    {
        $list = $this->Attendance_model->get_imza_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $image_html = '<img src="' .
                ($prd->out_signature_path && $prd->out_signature_path !== base_url() . 'userfiles/attach/no_signature.png'
                    ? base_url() . $prd->out_signature_path
                    : base_url() . 'userfiles/attach/no_signature.png') .
                '" class="img-resonsive" width="120px" height="100px">';

            $image_html_in = '<img src="' .
                ($prd->in_signature_path && $prd->in_signature_path !== base_url() . 'userfiles/attach/no_signature.png'
                    ? base_url() . $prd->in_signature_path
                    : base_url() . 'userfiles/attach/no_signature.png') .
                '" class="img-resonsive" width="120px" height="100px">';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->date;
            $row[] = $image_html_in.' '.$prd->in_signature_date;
            $row[] = $image_html.' '.$prd->out_signature_date;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Attendance_model->count_get_imza_list(),
            "recordsFiltered" => $this->Attendance_model->filtered_get_imza_list(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



}
