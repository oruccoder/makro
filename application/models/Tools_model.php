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



class Tools_model extends CI_Model

{



    var $column_order = array('status', 'name', 'duedate', 'tdate', null,null);

    var $column_search = array('name', 'duedate', 'tdate');

    var $notecolumn_order = array(null, 'title', 'cdate', null);

    var $notecolumn_search = array('id', 'title', 'cdate');


    var $order = array('id' => 'DESC');



    private function _task_datatables_query($cday = '')

    {



        $this->db->from('geopos_todolist');

        if ($cday) {

            $this->db->where('DATE(duedate)=', $cday);

        }





        $i = 0;



        foreach ($this->column_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function task_datatables($cday = '')

    {





        $this->_task_datatables_query($cday);



        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    function task_count_filtered($cday = '')

    {

        $this->_task_datatables_query($cday);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function task_count_all($cday = '')

    {

        $this->_task_datatables_query($cday);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content,$uretim_id=0)

    {



        $data = array(
            'tdate' => date('Y-m-d H:i:s'),
            'name' => $name,
            'uretim_id' => $uretim_id,
            'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'aid' => $assign, 'related' => 0, 'priority' => $priority, 'rid' => 0);

        return $this->db->insert('geopos_todolist', $data);

    }

    public function addtask_purchase($name, $status, $priority, $employee, $assign, $content,$purchase_id)

    {



        $data = array(
            'tdate' => date('Y-m-d H:i:s'),
            'name' => $name,
            'status' => $status,'description' => $content, 'eid' => $employee, 'aid' => $assign, 'related' => 0, 'priority' => $priority, 'rid' => 0,'purchase_id'=>$purchase_id);

        return $this->db->insert('geopos_todolist', $data);

    }

    public function addtask_sayim($name, $status, $priority, $employee, $assign, $content,$sayim_id,$gorev_adi,$yetkili_id)

    {



        $data = array(
            'tdate' => date('Y-m-d H:i:s'),
            'name' => $name,
            'status' => $status,'description' => $content, 'eid' => $employee, 'aid' => $assign, 'related' => 0, 'priority' => $priority, 'rid' => 0,'sayim_id'=>$sayim_id,'description' =>$gorev_adi, 'eid' => $yetkili_id, 'aid' => $yetkili_id);

        return $this->db->insert('geopos_todolist', $data);

    }



    public function edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)

    {



        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'related' => 0, 'priority' => $priority, 'rid' => 0);

        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_todolist');

        //return $this->db->insert('geopos_todolist', $data);

    }



    public function settask($id, $stat)

    {



        $data = array('status' => $stat);

        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_todolist');

    }



    public function deletetask($id)

    {



        return $this->db->delete('geopos_todolist', array('id' => $id));

    }



    public function viewtask($id)

    {



        $this->db->select('geopos_todolist.*,geopos_employees.name AS emp, assi.name AS assign');

        $this->db->from('geopos_todolist');

        $this->db->where('geopos_todolist.id', $id);

        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_todolist.eid', 'left');

        $this->db->join('geopos_employees AS assi', 'assi.id = geopos_todolist.aid', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }





    public function task_stats()

    {



        $query = $this->db->query("SELECT

				COUNT(IF( status = 'Due', id, NULL)) AS Due,

				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,

				COUNT(IF( status = 'Done', id, NULL)) AS Done

				FROM geopos_todolist ");



        echo json_encode($query->result_array());



    }



    //goals



    public function goals($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_goals');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function setgoals($income, $expense, $sales, $netincome)

    {





        $data = array('income' => $income, 'expense' => $expense, 'sales' => $sales, 'netincome' => $netincome);

        $this->db->set($data);

        $this->db->where('id', 1);

        return $this->db->update('geopos_goals');

    }



    //notes



    private function _notes_datatables_query()

    {



        $this->db->from('geopos_notes');

        $this->db->where('ntype',0);

        $i = 0;



        foreach ($this->notecolumn_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->notecolumn_order[$search['0']['column']], $search['0']['dir']);

        }

        $this->db->order_by('id','desc');

    }



    function notes_datatables()

    {

        $this->_notes_datatables_query();

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    function notes_count_filtered()

    {

        $this->_notes_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function notes_count_all()

    {

        $this->_notes_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function mesaj_gonder($proje_sorumlusu_no,$mesaj)
    {
        $result='';




        $tel=str_replace(" ","",$proje_sorumlusu_no);

        $domain="https://sms.atatexnologiya.az/bulksms/api";
        $operation='submit';
        $login='makro2000';
        $password="makro!sms";
        $title='MAKRO2000';
        $bulkmessage=$mesaj;
        $scheduled='now';
        $isbulk='true';
        $msisdn='994'.$tel;

        $cont_id=rand(1,999999999);



        $input_xml = "<?xml version='1.0' encoding='UTF-8'?>
               <request>	
                <head>	
                    <operation>$operation</operation>	
                    <login>$login</login>	
                    <password>$password</password>	
                    <title>$title</title>	
                    <bulkmessage>$bulkmessage</bulkmessage>	
                    <scheduled>$scheduled</scheduled>
                    <isbulk>$isbulk</isbulk>
                    <controlid>$cont_id</controlid>
                </head>
                    <body>
                    <msisdn>$msisdn</msisdn>
                    </body>
                </request>";



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);

        // For xml, change the content-type.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $result = curl_exec($ch);
        curl_close($ch);



        return 1;




    }

    public  function getSmallLink($longurl){
        $sayi=rand(1,99999999);
        $name='makro2000'.$sayi;
        $url = urlencode("$longurl");
        $json = file_get_contents("https://cutt.ly/api/api.php?key=e67f08835022a9c59b736d5c9e109ba5a8c4a&short=$url&name=$name");
        $data = json_decode ($json, true);

        return $data['url']['shortLink'];

    }


    function addnote($title, $content,$pers_id=0)

    {



        date_default_timezone_set('Asia/Baku');
        $data = array(
            'title' => $title,
            'pers_id' => $pers_id,
            'content' => $content, 'cdate' => date('Y-m-d'),'last_edit' => date('Y-m-d H:i:s'),'cid' => $this->aauth->get_user()->id,'fid' => $this->aauth->get_user()->id,'ntype'=>0);


        if($this->db->insert('geopos_notes', $data))
        {

            $last_id = $this->db->insert_id();
            $sayi=rand(1,99999999);
            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];
            $validtoken = hash_hmac('ripemd160', 'p' . $last_id, $this->config->item('encryption_key'));


            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$last_id&pers_id=$pers_id&type=gorusme_onay&token=$validtoken";

            $short_url = $this->getSmallLink($href);
            $proje_sorumlusu_no = personel_detailsa($pers_id)['phone'];


            $meesage=$title.' '.'İncelemek icin tiklayiniz '.$short_url;



            $this->mesaj_gonder($proje_sorumlusu_no,$meesage);

            return 1;
        }



    }



    public function note_v($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_notes');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    function deletenote($id)

    {

        return $this->db->delete('geopos_notes', array('id' => $id));



    }





    //documents list



    var $doccolumn_order = array(null, 'title', 'cdate', null);

    var $doccolumn_search = array('title', 'cdate');



    public function documentlist()

    {

        $this->db->select('*');

        $this->db->from('geopos_documents');

        $query = $this->db->get();

        return $query->result_array();

    }



    function adddocument($title, $filename)

    {

        $data = array('title' => $title, 'filename' => $filename, 'cdate' => date('Y-m-d'));

        return $this->db->insert('geopos_documents', $data);



    }



    function deletedocument($id)

    {

        $this->db->select('filename');

        $this->db->from('geopos_documents');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $result = $query->row_array();

        if ($this->db->delete('geopos_documents', array('id' => $id))) {



            unlink(FCPATH . 'userfiles/documents/' . $result['filename']);

            return true;

        } else {

            return false;

        }



    }





    function document_datatables()

    {

        $this->document_datatables_query();

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    private function document_datatables_query()

    {



        $this->db->from('geopos_documents');



        $i = 0;



        foreach ($this->doccolumn_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->doccolumn_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function document_count_filtered()

    {

        $this->document_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function document_count_all()

    {

        $this->document_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function pending_tasks()

    {

        $this->db->select('*');

        $this->db->from('geopos_todolist');

        $this->db->where('status', 'Due');

        $this->db->order_by('DATE(duedate)', 'ASC');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



    public function pending_tasks_user($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_todolist');

        $this->db->where('status', 'Due');

        $this->db->where('eid', $id);

        $this->db->order_by('DATE(duedate)', 'ASC');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }





    public function editnote($id, $title, $content,$pers_id=0)

    {

        $data = array(

            'title' => $title,

            'content' => $content,

            'pers_id' => $pers_id



        );



         $data = array('title' => $title,'pers_id' => $pers_id, 'content' => $content, 'last_edit' => date('Y-m-d H:i:s'),'fid' => $this->aauth->get_user()->id);





        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_notes')) {

            return true;

        } else {

            return false;

        }



    }





}