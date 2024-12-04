<?php


defined('BASEPATH') or exit('No direct script access allowed');


class Personelpoint_model extends CI_Model
{

    var $table = 'personel_point';

    var $column_order = array('personel_point.id','geopos_employees.name','geopos_role.name','personel_point.created_at');

    var $column_search = array('personel_point.id', 'geopos_employees.name','geopos_role.name', 'personel_point.created_at');
    var $column_search_details = array('geopos_employees.name', 'personel_point_value.name','personel_point.puan', 'personel_point.created_at','personel_point.id');

    var $column_order_details = array( 'personel_point_value.name', 'personel_point.puan','geopos_employees.name', 'personel_point.created_at');

    var $order = array('personel_point.id' => 'desc');

    var $order_details = array('id' => 'desc');

    public function list()
    {
        $this->_list();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();
    }

    private function _list()
    {

        $this->db->select('personel_point.*, geopos_users.roleid,geopos_employees.id, geopos_employees.`name` as personel_name,  geopos_role.name as role_name');
        $this->db->from('personel_point');
        $this->db->join('geopos_employees', 'personel_point.personel_id=geopos_employees.id');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->join('geopos_role', 'geopos_users.roleid = geopos_role.role_id','left');
        $this->db->where('personel_point.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->group_by('personel_point.personel_id');
        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);

                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }


        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered($id = '')
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows($id = '');

    }
    public function row_query($id)
    {

        $this->db->select('personel_point.*, personel_point_value.name ,  geopos_employees.`name` as personel_name, ');
        $this->db->from('personel_point');
        $this->db->join('personel_point_value', 'personel_point.point_value_id=personel_point_value.id');
        $this->db->join('geopos_employees', 'personel_point.personel_id=geopos_employees.id');
        $this->db->where('personel_point.loc =', $this->session->userdata('set_firma_id'));
        $this->db->where('personel_point.id =', $id);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row();
            return $row;
        }

    }
    public function row_query_all($id)
    {

        $this->db->select('personel_point.*, personel_point_value.name ,  geopos_employees.`name` as personel_name, ');
        $this->db->from('personel_point');
        $this->db->join('personel_point_value', 'personel_point.point_value_id=personel_point_value.id');
        $this->db->join('geopos_employees', 'personel_point.personel_id=geopos_employees.id');
        $this->db->where('personel_point.loc =', $this->session->userdata('set_firma_id'));
        $this->db->where('personel_point.personel_id =', $id);
        $query = $this->db->get();

        if ( $query->num_rows() > 0 )
        {
            $result = $query->result();
            return $result;
        }

    }

    public function create_save(){
        $personel_name = $this->input->post('personel_name');
        $deger_name = $this->input->post('deger_name');
        $personel_id = $this->input->post('personel_id');
        $deger_id = $this->input->post('deger_id');
        $puan = $this->input->post('puan');
        $created_at = date('Y-m-d H:i:s');
        $data = array
        (
            'auth_id' => $this->aauth->get_user()->id,
            'personel_id' =>$personel_id,
            'point_value_id'=> $deger_id,
            'puan' => $puan,
            'loc' => $this->session->userdata('set_firma_id')
        );



        $this->db->where('personel_point.personel_id=',$personel_id);
        $this->db->where('personel_point.point_value_id=',$deger_id);
        $query = $this->db->get('personel_point');

        if ($query->num_rows()>0)
        {
            $data_update = array(
                'puan' => $puan,
                'created_at'=>$created_at,
            );



            $this->db->set($data_update);
            $this->db->where('personel_point.personel_id=',$personel_id);
            $this->db->where('personel_point.point_value_id=',$deger_id);
            if ($this->db->update('personel_point'))
            {

                $output ="============".date('Y - m - d  H:i:s')."==============\n";
                $output .="-------  updated at      : ".$created_at."\n";
                $output .="-------  personel name   : ".$personel_name."\n";
                $output .="-------  who updated     : ".$this->aauth->get_user()->id."\n";
                $output .="-------  point value     : ".$deger_name."\n";
                $output .="-------  Puan            : ".$puan."\n";
                $output .="================================================\n \n \n";
                write_file(APPPATH . 'logs/logger.php', $output,'a+');


                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Personel degeri Güncellendi'
                ];
            }
            else
            {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }
        }
        else
        {
            if ($this->db->insert('personel_point', $data))
            {
                $output ="============".date('Y - m - d  H:i:s')."==============\n";
                $output .="-------  updated at      : ".$created_at."\n";
                $output .="-------  personel name   : ".$personel_name."\n";
                $output .="-------  who created     : ".$this->aauth->get_user()->id."\n";
                $output .="-------  point value     : ".$deger_name."\n";
                $output .="-------  Puan            : ".$puan."\n";
                $output .="==================================================\n \n \n";
                write_file(APPPATH . 'logs/logger.php', $output,'a+');
                return [
                    'status'=> 1,
                    'message'=> 'Başarılı Bir Şekilde Oluşturuldu'
                ];
            }
            else
            {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }
        }
    }

    public function details(){

        $this->_details();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();
    }

    public function _details(){

        $id = $this->input->post('id');
        $this->db->select('personel_point.*, personel_point_value.name ,  geopos_employees.`name` as personel_name, ');
        $this->db->from('personel_point');
        $this->db->join('personel_point_value', 'personel_point.point_value_id=personel_point_value.id');
        $this->db->join('geopos_employees', 'personel_point.auth_id=geopos_employees.id');
        $this->db->where('personel_point.loc =', $this->session->userdata('set_firma_id'));
        $this->db->where('personel_point.personel_id =', $id);
        $i = 0;

        foreach ($this->column_search_details as $item) // loop column

        {
            if ($_POST['search']['value']) // if datatable send POST for search

            {
                if ($i === 0) // first loop

                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

                if (count($this->column_search_details) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_details[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order_details)) {

            $order = $this->order_details;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    public function delete()
    {
        $pers_id = $this->input->post('pers_id');
        $row_query_all=$this->row_query_all($pers_id);


        if ($this->db->where(['personel_id' => $pers_id])->delete('personel_point')) {

            $output ="===================================QUERY DELETED ======================================\n";
            foreach ($row_query_all as $row) {

                $output .="============".date('Y - m - d  H:i:s')."==============\n";
                $output .="-------  created at      : ".$row->created_at."\n";
                $output .="-------  personel name   : ".$row->personel_name."\n";
                $output .="-------  who deleted     : ".$this->aauth->get_user()->id."\n";
                $output .="-------  point value     : ".$row->name."\n";
                $output .="-------  Puan            : ".$row->puan."\n";
                $output .="================================================\n";
            }
            $output .="===================================QUERY DELETED ======================================\n\n\n";
            write_file(APPPATH . 'logs/logger.php', $output,'a+');
            return [
                'status' => 1,
                'messages' => 'Başarıyla Silindi'
            ];
        } else {
            return [
                'status' => 0,
                'messages' => 'Hata Aldınız. Yöneticiye Başvurun'
            ];
        }
    }
    public function delete_line()
    {

        $deger_id = $this->input->post('deger_id');

        $row_query=$this->row_query($deger_id);

        if ($this->db->where(['id' => $deger_id,'auth_id'=>$this->aauth->get_user()->id])->delete('personel_point')) {
            $output ="============".date('Y - m - d  H:i:s')."==============\n";
            $output .="-------  created at      : ".$row_query->created_at."\n";
            $output .="-------  personel name   : ".$row_query->personel_name."\n";
            $output .="-------  who deleted     : ".$this->aauth->get_user()->id."\n";
            $output .="-------  point value     : ".$row_query->name."\n";
            $output .="-------  Puan            : ".$row_query->puan."\n";
            $output .="================================================\n \n \n";
            write_file(APPPATH . 'logs/logger.php', $output,'a+');

            return [
                'status' => 1,
                'messages' => 'Başarıyla Silindi'
            ];
        } else {
            return [
                'status' => 0,
                'messages' => 'Üzgünüm!Giriş Yetkiniz Bulunmamaktadır'
            ];
        }
    }
}
