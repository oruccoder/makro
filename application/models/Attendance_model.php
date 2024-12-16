<?php
class Attendance_model extends CI_Model
{
    public function get_daily_records($date)
    {
        $this->db->select('a.*, u.name AS user_name, p.name AS project_name');
        $this->db->from('attendance a');
        $this->db->join('geopos_employees u', 'a.user_id = u.id');
        $this->db->join('geopos_projects p', 'a.project_id = p.id');
        $this->db->where('a.date', $date);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_users_with_attendance($project_id, $date)
    {
        $this->db->select('geopos_employees.id, geopos_employees.name, attendance.entry_time, attendance.break_start,
         attendance.break_end, attendance.exit_time, attendance.description,attendance.in_signature_path,attendance.out_signature_path,attendance.in_signature_date,attendance.out_signature_date');
        $this->db->from('geopos_employees');
        $this->db->join('personel_salary','geopos_employees.id=personel_salary.personel_id','inner');
        $this->db->join('geopos_users','geopos_employees.id=geopos_users.id','inner');
        $this->db->join('attendance', 'attendance.user_id = geopos_employees.id AND attendance.date = "' . $date . '"', 'left');
        $this->db->where('personel_salary.proje_id', $project_id);
        $this->db->where('personel_salary.status', 1);
        $this->db->where('geopos_users.banned', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function get_users_with_attendance_podradci($project_id, $date)
    {
        $this->db->select('geopos_employees_p.id, geopos_employees_p.name, attendance.entry_time, attendance.break_start,
         attendance.break_end, attendance.exit_time, attendance.description,attendance.in_signature_path,attendance.out_signature_path,attendance.in_signature_date,attendance.out_signature_date');
        $this->db->from('geopos_employees_p');
        $this->db->join('personel_salary_p','geopos_employees_p.id=personel_salary_p.personel_id','inner');
        $this->db->join('geopos_users_p','geopos_employees_p.id=geopos_users_p.id','inner');
        $this->db->join('attendance', 'attendance.user_id = geopos_employees_p.id AND attendance.date = "' . $date . '"', 'left');
        $this->db->where('personel_salary_p.proje_id', $project_id);
        $this->db->where('personel_salary_p.status', 1);
        $this->db->where('geopos_users_p.banned', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_record($user_id, $project_id, $date,$tip)
    {
        $this->db->select('id');
        $this->db->from('attendance');
        $this->db->where('user_id', $user_id);
        $this->db->where('tip', $tip);
        $this->db->where('project_id', $project_id);
        $this->db->where('date', $date);
        $query = $this->db->get();
        return $query->row(); // Tek bir kayıt döner
    }

    public function update_record($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('attendance', $data);
    }


    public function save_record($data)
    {
        $this->db->insert('attendance', $data);
    }

    public function get_all_projects()
    {
        $query = $this->db->get('geopos_projects');
        return $query->result_array();
    }

    public function save_all_records($data)
    {
        $this->db->insert_batch('attendance', $data);
    }

    public function get_project_with_files($project_id, $date)
    {
        $this->db->select('f.file_path, p.name AS project_name');
        $this->db->from('attendance_files f');
        $this->db->join('projects p', 'f.project_id = p.id');
        $this->db->where('f.project_id', $project_id);
        $this->db->where('f.date', $date);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_daily_records_by_project($project_id, $date)
    {
        $this->db->select('a.*, u.name AS user_name');
        $this->db->from('attendance a');
        $this->db->join('users u', 'a.user_id = u.id');
        $this->db->where('a.project_id', $project_id);
        $this->db->where('a.date', $date);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_all_reports($project_id = null, $user_id = null, $start_date = null, $end_date = null, $search_value = null)
    {
        // UNION sorgusunu al
        $union_query = $this->_reports($project_id, $user_id, $start_date, $end_date, $search_value);

        // Tüm sonuçların sayısını almak için bir dış sorgu oluştur
        $count_query = "SELECT COUNT(*) AS total FROM ($union_query) AS subquery";

        // Sorguyu çalıştır ve sonucu döndür
        $query = $this->db->query($count_query);
        return $query->row()->total;
    }

    public function count_filtered_reports($project_id = null, $user_id = null, $start_date = null, $end_date = null, $search_value = null)
    {
        // UNION sorgusunu al
        $union_query = $this->_reports($project_id, $user_id, $start_date, $end_date, $search_value);

        // Filtrelenmiş sonuçların sayısını almak için bir dış sorgu oluştur
        $count_query = "SELECT COUNT(*) AS total FROM ($union_query) AS subquery";

        // Sorguyu çalıştır ve sonucu döndür
        $query = $this->db->query($count_query);
        return $query->row()->total;
    }

    public function _reports($project_id = null, $user_id = null, $start_date = null, $end_date = null, $search_value = null)
    {
        $user = $this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;
        $santiye_id = personel_salary_details_get($user)->proje_id;

        // Ortak SELECT sorgusu
        $common_select = "
        p.name AS project_name,
        u.name AS user_name,
        a.user_id,
        a.project_id,
        a.in_signature_path,
        a.out_signature_path,
        MIN(a.date) AS start_date,  -- Başlangıç tarihi
        MAX(a.date) AS end_date,    -- Bitiş tarihi
        SUM(TIMESTAMPDIFF(MINUTE, a.entry_time, a.exit_time)) AS total_work_minutes,
        SUM(TIMESTAMPDIFF(MINUTE, a.break_start, a.break_end)) AS total_break_minutes,
        COUNT(DISTINCT a.date) AS total_days,
        CASE 
            WHEN a.tip = 1 THEN 'Personel'
            WHEN a.tip = 2 THEN 'Podradçı Personel'
            ELSE 'Diğer'
        END AS user_type
    ";

        // Birinci sorgu (tip = 1)
        $this->db->select($common_select, false);
        $this->db->from('attendance a');
        $this->db->join('geopos_projects p', 'a.project_id = p.id', 'left');
        $this->db->join('geopos_employees u', 'a.user_id = u.id', 'left');
        $this->db->where('a.tip', 1);

        // Filtreleme koşulları
        $this->_apply_filters($project_id, $user_id, $start_date, $end_date, $search_value, $santiye_id, $role_id);
        $this->db->group_by('a.project_id, a.user_id, user_type');
        $query1 = $this->db->get_compiled_select(); // İlk sorguyu hazırla

        // İkinci sorgu (tip = 2)
        $this->db->select($common_select, false);
        $this->db->from('attendance a');
        $this->db->join('geopos_projects p', 'a.project_id = p.id', 'left');
        $this->db->join('geopos_employees_p u', 'a.user_id = u.id', 'left');
        $this->db->where('a.tip', 2);

        // Filtreleme koşulları
        $this->_apply_filters($project_id, $user_id, $start_date, $end_date, $search_value, $santiye_id, $role_id);
        $this->db->group_by('a.project_id, a.user_id, user_type');
        $query2 = $this->db->get_compiled_select(); // İkinci sorguyu hazırla

        // UNION sorgusunu döndür
        return "($query1) UNION ($query2)";
    }
    public function get_paginated_reports($project_id = null, $user_id = null, $start_date = null, $end_date = null, $search_value = null, $start = 0, $length = 10)
    {
        // UNION sorgusunu al
        $union_query = $this->_reports($project_id, $user_id, $start_date, $end_date, $search_value);

        // Sayfalama uygulama
        $paginated_query = "$union_query LIMIT $start, $length";

        // Sorguyu çalıştır ve sonucu döndür
        $query = $this->db->query($paginated_query);
        return $query->result_array();
    }

    private function _apply_filters($project_id, $user_id, $start_date, $end_date, $search_value, $santiye_id, $role_id)
    {
        if (!empty($project_id)) $this->db->where('a.project_id', $project_id);
        if (!empty($user_id)) $this->db->where('a.user_id', $user_id);
        if (!empty($start_date) && !empty($end_date)) {
            $start_date_db = DateTime::createFromFormat('d-m-Y', $start_date)->format('Y-m-d');
            $end_date_db = DateTime::createFromFormat('d-m-Y', $end_date)->format('Y-m-d');
            $this->db->where('a.date >=', $start_date_db);
            $this->db->where('a.date <=', $end_date_db);
        }
        if (!empty($search_value)) {
            $this->db->group_start();
            $this->db->like('p.name', $search_value);
            $this->db->or_like('u.name', $search_value);
            $this->db->group_end();
        }

        // Yetki kontrolü
        if (!$this->aauth->premission(96)->read) {
            if (in_array($role_id, personel_yetkileri())) {
                $this->db->where('a.project_id', $santiye_id);
            } else {
                $this->db->where('1', 0);
            }
        }
    }

    public function save_file($data)
    {
        $this->db->insert('attendance_project_files', $data);
    }

    public function get_files_by_project_and_date($project_id, $date)
    {
        $this->db->select('*');
        $this->db->from('attendance_project_files');
        $this->db->where('project_id', $project_id);
        $this->db->where('date', $date);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_imza_list()

    {
        $this->_get_imza_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();

    }

    private function _get_imza_list()
    {
        $proje_id = $this->input->post('proje_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $pers_id = $this->input->post('pers_id');

        $this->db->select('*');
        $this->db->from('attendance');

        // Proje ID'sine göre filtreleme
        if (!empty($proje_id)) {
            $this->db->where('project_id', $proje_id);
        }

        // Tarih aralığına göre filtreleme
        if (!empty($start_date) && !empty($end_date)) {
            // Gelen tarih formatı doğrudan uygun olduğu için formatlama yapılmadan kullanılıyor
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
        }

        // Kullanıcı ID'sine göre filtreleme
        if (!empty($pers_id)) {
            $this->db->where('user_id', $pers_id);
        }

        // Sıralama
        $this->db->order_by('id', 'DESC');


    }


    public function filtered_get_imza_list()
    {
        $this->_get_imza_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_get_imza_list()
    {
        $this->_get_imza_list();
        return $this->db->count_all_results();
    }


}
