<?php

defined('BASEPATH') or exit('No direct script access allowed');
	date_default_timezone_set('Asia/Baku');


class Customermeeting_model extends CI_Model
{

    var $table_news = 'stock_io ';
    var $column_order = array(null, 'meeting.by_user', 'meeting.who_created' , 'meeting.time' , 'meeting.location' , 'meeting.status' , 'meeting.created_at' , 'meeting.uniqid');
    var $column_search = array('meeting.by_user', 'meeting.who_created' , 'meeting.time' , 'meeting.location' , 'meeting.status' ,  'meeting.created_at' , 'meeting.uniqid');
    var $meeting = array('meeting.id', 'DESC');


    public function __construct()
    {
        parent::__construct();
    }


    public function get_datatables_query_details_list()
    {

        $this->_get_datatables_query_details_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_details_list()
    {
        $this->db->select('meeting.* , geopos_customers.name , geopos_users.username as confirm_user');
        $this->db->from('meeting');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('meeting.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->where('meeting.customer_id !=', NULL);
		$this->db->or_where('meeting.customer_name !=', NULL);
        $this->db->join('geopos_customers', 'meeting.customer_id=geopos_customers.id' , "LEFT");
        $this->db->join('geopos_users', 'meeting.confirm_user=geopos_users.id' , "LEFT");

        
        $i = 0;

        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;
        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->meeting)) {
            $order = $this->meeting;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function count_filtered()
    {
        $this->_get_datatables_query_details_list();
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all()
    {
        $this->_get_datatables_query_details_list();
        return $this->db->count_all_results();
    }


    public function create_save()
    {
		
        $this->db->trans_start();

        $uniqid = uniqid();

		if($this->input->post('customer_id') > 0)
		{
			$customer_id = $this->input->post('customer_id');
		}else{
			$customer_id = NULL;
		}
			
        $data = array(
            'uniqid' => $uniqid,
            'confirm_user'=> $this->input->post('confirm_user'),
            'by_user' =>  $this->input->post('by_user'),
            'who_created' => $this->aauth->get_user()->employes->username,
            'type' => $this->input->post('type'),
            'location' => $this->input->post('location'),
            'time'=> $this->input->post('time'),
            'customer_id'=> $customer_id,
            'status' => "Bekliyor",
            'loc'=>$this->session->userdata('set_firma_id'),
            'description' => $this->input->post('description'),
            'who_created_id' => $this->aauth->get_user()->employes->id,
            'customer_name' => $this->input->post('customer_name') == "" ? NULL : $this->input->post('customer_name'),
            'created_at' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('meeting', $data);
        $insert_id = $this->db->insert_id();

		
		if($this->input->post('members') != NULL){
			
        foreach($this->input->post('members') as $item)
        {
            $arr = [
                'meeting_id'=>$insert_id,
                'user_id' =>$item,
            ];
            $this->db->insert('meeting_users', $arr);

        }
			
		}

        $complete = $this->db->trans_complete();

        if ($complete) {
            $this->db->select('geopos_employees.phone');
            $confirm_user = $this->db->from('geopos_employees')->where('id' , $this->input->post('confirm_user'))->get()->row();

            $this->mesaj_gonder($confirm_user->phone, "$uniqid".' Kodlu Toplantiyi '."Lutfen Onaylayin");

            return [
                'status' => 1,
            ];
            } else {
            return [
                'status' => 0,
            ];
        }

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
        //echo "<pre>";print_r($result);
        //die();
        curl_close($ch);

        return 1;




    }


    public function update()
    {
        $meeting_id =  $this->input->post('meeting_id');

        $this->db->trans_start();

        $this->db->where(['meeting_id' => $meeting_id])->delete('meeting_users');

        $data = array(
            'type' => $this->input->post('type'),
            'location' => $this->input->post('location'),
            'time'=> $this->input->post('time'),
            'customer_id'=> $this->input->post('customer_id') ?? NULL,
            'status' => "Onaylandı",
            'description' => $this->input->post('description'),
			'customer_name' => $this->input->post('customer_name') ?? NULL,
            'confirm_date' => date('Y-m-d H:i:s'),
        );

        $time = date('Y-m-d \ H:i:s' , strtotime($this->input->post('time')));

        
        $content = "Merhaba sizi ".$time." tarihinde ".$this->input->post('location')."-da olacak toplantiya davet ediyoruz ".$this->input->post('description');

        
        $this->db->where(['id' => $meeting_id])->update('meeting', $data);

        $costumer = $this->db->select('geopos_customers.phone')->from('geopos_customers')->where('id' , $this->input->post('customer_id'))->get()->row();


        $this->mesaj_gonder($costumer->phone, $content);


        foreach($this->input->post('members') as $item)
        {
            $arr = [
                'meeting_id'=>$meeting_id,
                'user_id' =>$item,
            ];

            $this->db->insert('meeting_users', $arr);

            $this->db->select('geopos_employees.phone');

            $user = $this->db->from('geopos_employees')->where('id' , $item)->get()->row();

            $this->mesaj_gonder($user->phone, $content);

        }

        $complete = $this->db->trans_complete();


        if ($complete) {

            return [
                'status' => 1,
            ];
            } else {
            return [
                'status' => 0,
            ];
        }
    }


    public function cancel()
    {
        $meeting_id =  $this->input->post('meeting_id');

        $this->db->trans_start();

        $this->db->where(['id' => $meeting_id])->update('meeting' , ['status' => 'Iptal Edildi' , 'cancel_date'=>date('Y-m-d H:i:s')]);

        $user_id = $this->db->select('who_created_id , uniqid')->from('meeting')->where('id' , $meeting_id)->get()->row();

        $who_created_phone = $this->db->from('geopos_employees')->where('id' , $user_id->who_created_id)->get()->row();

        $this->db->where(['meeting_id' => $meeting_id])->delete('meeting_users');


        $complete = $this->db->trans_complete();

        if ($complete) {
            $this->mesaj_gonder($who_created_phone->phone, "$user_id->uniqid".' Kodlu'." Toplanti Iptal Edildi");

            return [
                'status' => 1,
                'messages' => 'Başarıyla Iptal Edildi'
            ];
        } else {
            return [
                'status' => 0,
                'messages' => 'Hata Aldınız. Yöneticiye Başvurun'
            ];
        }
    }


    public function details_item($meeting_id)
    {
        $this->db->select('meeting.* , geopos_employees.name as user_name, meeting_users.id as meeting_users_id , meeting_users.meeting_id as meeting_id, meeting_users.user_id as user_id');
        $this->db->from('meeting');
        $this->db->where('meeting.id', $meeting_id);
        $this->db->join('meeting_users', 'meeting_users.meeting_id=meeting.id','LEFT');
        $this->db->join('geopos_employees', 'meeting_users.user_id=geopos_employees.id','LEFT');
        $query = $this->db->get();
//        $query = $query->row();
//        echo $this->db->last_query();
//        die();
        return $query->result();
    }


    public function details_member($meeting_id)
    {

        $this->db->select('geopos_employees.name as user_name');
        $this->db->from('meeting');
        $this->db->where('meeting.id', $meeting_id);
        $this->db->join('meeting_users', 'meeting_users.meeting_id=meeting.id');
        $this->db->join('geopos_employees', 'user_id=geopos_employees.id');
        
        $query = $this->db->get();
        return $query->result();

    }
}
