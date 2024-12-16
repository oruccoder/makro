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



class Projects_model extends CI_Model

{



    var $column_order = array('geopos_projects.id', 'geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.worth', null,null);

    var $column_search = array('geopos_projects.name','geopos_projects.code', 'geopos_projects.edate', 'geopos_projects.status');

    var $column_search_gider = array('geopos_invoices.invoicedate', 'geopos_customers.company', 'geopos_invoices.invoice_no', 'geopos_invoices.notes','geopos_account_type.name');

    var $tcolumn_order = array('geopos_todolist.name', 'geopos_milestones.name', 'geopos_project_bolum.name');

    var $tcolumn_search = array('geopos_todolist.name', 'geopos_milestones.name', 'geopos_project_bolum.name');

    var $acolumn_search = array('geopos_milestones.name', 'geopos_milestones.edate', 'geopos_milestones.sdate', 'geopos_employees.name');

    var $bcolumn_search = array('name', 'exp');

    var $order = array('id' => 'DESC');


    var $table_prd = 'geopos_products';

    var $column_order_prd = array(null, 'geopos_products.product_name', 'geopos_products.qty','geopos_products.rezerv_qty', 'geopos_products.product_code','geopos_products.kalite','geopos_products.uretim_yeri', 'geopos_product_cat.title', 'geopos_products.product_price', null); //set column field database for datatable orderable

    var $column_search_prd = array('geopos_products.product_name', 'geopos_products.product_code','geopos_products.qty'); //set column field database for datatable searchable

    var $order_prd = array('geopos_products.pid' => 'desc'); // default order



    var $all_table = 'geopos_invoices';
    var $all_column_order = array('geopos_invoices.invoicedate','geopos_invoices.invoice_type_desc','geopos_customers.invoice_no', 'geopos_customers.company', 'geopos_invoices.total', 'geopos_invoices.status',  null);
    var $all_column_search = array('geopos_invoices.tid', 'geopos_customers.company', 'geopos_customers.name', 'geopos_invoices.invoicedate','geopos_invoices.invoice_no' ,'geopos_invoices.total','geopos_invoices.status','geopos_invoices.invoice_type_desc');
    var $all_order = array('geopos_invoices.tid' => 'desc');






    public function explore($id)

    {

        //project

        $this->db->select('geopos_projects.*,geopos_customers.company AS customer,geopos_customers.email');

        $this->db->from('geopos_projects');

        $this->db->where('geopos_projects.id', $id);

        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_projects.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $query = $this->db->get();

        $project = $query->row_array();

        //employee

        $this->db->select('geopos_employees.name');

        $this->db->from('geopos_project_meta');

        $this->db->where('geopos_project_meta.pid', $id);

        $this->db->where('geopos_project_meta.meta_key', 6);

        $this->db->join('geopos_employees', 'geopos_project_meta.meta_data = geopos_employees.id', 'left');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_employees.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        $query = $this->db->get();

        $employee = $query->result_array();

        //invoices

        $this->db->select('geopos_invoices.*');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.proje_id', $id);
        $this->db->where_in('geopos_invoices.invoice_type_id', [1,2,7,8,38,41]);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $query = $this->db->get();

        $invoices = $query->result_array();



        return array('project' => $project, 'employee' => $employee, 'invoices' => $invoices);



    }


    public function maas_sort_info($id){
        $this->db->select('maas_onay_sort.user_id,maas_onay_sort.sort,maas_onay_sort.id,geopos_employees.name');
        $this->db->from('maas_onay_sort');
        $this->db->join('geopos_employees', 'maas_onay_sort.user_id = geopos_employees.id');
        $this->db->where('maas_onay_sort.proje_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function details($id)

    {

//project

        $this->db->select('geopos_projects.*,geopos_projects.id AS prj, geopos_customers.company AS customer,geopos_project_meta.*');
        $this->db->from('geopos_projects');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $this->db->join('geopos_project_meta', 'geopos_project_meta.pid = geopos_projects.id', 'left');
        $this->db->where('geopos_projects.id', $id);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_projects.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        //$this->db->where('geopos_project_meta.meta_key', 2);
        $query = $this->db->get();
        return $query->row_array();

    }



    private function _project_datatables_query()

    {
        $auth_id = $this->aauth->get_user()->id;



        $this->db->select("geopos_projects.*,geopos_customers.name AS customer");

        $this->db->from('geopos_projects');

        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_projects.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $this->db->where_in('geopos_projects.status ', [0,1,2]); //2019-11-23 14:28:57





        if($auth_id==21 || $auth_id==39 || $auth_id==66 || $auth_id==61 || $auth_id==741){

        }
        else {
            $this->db->where_not_in('geopos_projects.id', [219, 220]);
        }



        $i = 0;

        foreach ($this->column_search as $item) // loop column

        {
            if($_POST){
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

                        $this->db->group_end(); //close bracket

                }

                $i++;
            }


        }

        $search = $this->input->post('order');

        if (isset($search)) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function project_datatables()

    {





        $this->_project_datatables_query();



        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }





    function project_count_filtered()

    {

        $this->_project_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function project_count_all()

    {

        $this->_project_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function project_status()
    {
        $this->db->select('*');

        $this->db->from('geopos_project_status');

        $query = $this->db->get();

        return $query->result_array();

    }
    public function project_derece()
    {
        $this->db->select('*');

        $this->db->from('geopos_project_derece');

        $query = $this->db->get();

        return $query->result_array();

    }

    public function addiskalemstatus($name)
    {
        $data = array(
            'name' => $name);

        if($this->db->insert('geopos_is_kalemleri_status', $data))
        {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')."  <a href='/projects/is_kalemleri_durumlari'
    class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));


        }
    }
    public function editiskalemstatus($id,$name)
    {
        $data = array(
            'name' => $name);

        $this->db->set($data);

        $this->db->where('id', $id);

        if($this->db->update('geopos_is_kalemleri_status', $data))
        {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')."  <a href='/projects/is_kalemleri_durumlari'
    class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));


        }
    }



    public function addproject()
    {
        $code = $this->input->post('code', true);

        // Eğer kod boşsa otomatik numara oluştur
        if (empty($code)) {
            $code = numaric(22);
            numaric_update(22);
        }

        // Gelen verileri düzenli bir şekilde al
        $data = [
            'name' => $this->input->post('name', true),
            'status' => $this->input->post('status', true),
            'priority' => $this->input->post('priority', true),
            'progress' => $this->input->post('progress', true),
            'cid' => $this->input->post('customer', true),
            'sdate' => $this->convertToDatabaseDate($this->input->post('sdate', true)),
            'edate' => $this->convertToDatabaseDate($this->input->post('edate', true)),
            'sozlesme_tutari' => $this->input->post('sozlesme_tutari', true),
            'ptype' => $this->input->post('ptype', true),
            'project_adresi' => $this->input->post('project_adresi', true),
            'sozlesme_numarasi' => $this->input->post('sozlesme_numarasi', true),
            'sozlesme_date' => $this->convertToDatabaseDate($this->input->post('sozlesme_date', true)),
            'code' => $code,
            'loc' => $this->session->userdata('set_firma_id'),
        ];

        // Veritabanına ekleme işlemi
        if ($this->db->insert('geopos_projects', $data)) {
            $proje_id = $this->db->insert_id();

            // Depo oluşturma işlemi
            $this->addwarehouse(
                $this->input->post('name', true),
                $this->input->post('name', true),
                $this->session->userdata('set_firma_id'),
                $proje_id
            );
            // Uygulama kaydı
            $this->aauth->applog(
                "Proje Oluşturuldu. ID : " . $proje_id,
                $this->aauth->get_user()->username
            );
            return [
                'status'=>1,
                'message'=>'Başarıyla Oluşturuldu'
            ];
        } else {
            // Hata durumunda false döndür
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

// Yardımcı metot: Tarih formatını veritabanı uyumlu hale çevirir
    private function convertToDatabaseDate($date)
    {
        if (!empty($date)) {
            return datefordatabase($date);
        }
        return null;
    }

    public function addwarehouse($cat_name, $cat_desc,$lid,$proje_id=0)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc,
            'proje_id' => $proje_id,
            'loc'=>$lid
        );
        if ($this->db->insert('geopos_warehouse', $data)) {
            $this->aauth->applog("Depo Oluşturuldu $cat_name ID ".$this->db->insert_id(),$this->aauth->get_user()->username);
        }
    }



    public function updateProje()
    {

        $id= $this->input->post('p_id');
        $data = [
            'name' => $this->input->post('name', true),
            'status' => $this->input->post('status', true),
            'priority' => $this->input->post('priority', true),
            'progress' => $this->input->post('progress', true),
            'cid' => $this->input->post('customer', true),
            'sdate' => $this->convertToDatabaseDate($this->input->post('sdate', true)),
            'edate' => $this->convertToDatabaseDate($this->input->post('edate', true)),
            'sozlesme_tutari' => $this->input->post('sozlesme_tutari', true),
            'ptype' => $this->input->post('ptype', true),
            'project_adresi' => $this->input->post('project_adresi', true),
            'sozlesme_numarasi' => $this->input->post('sozlesme_numarasi', true),
            'proje_muduru_id' => $this->input->post('proje_muduru_id',true),
            'proje_sorumlusu_id' => $this->input->post('proje_sorumlusu_id',true),
            'muhasebe_muduru_id' => $this->input->post('muhasebe_muduru_id',true),
            'genel_mudur_id' => $this->input->post('genel_mudur_id',true),
            'sozlesme_date' => $this->convertToDatabaseDate($this->input->post('sozlesme_date', true)),
        ];

        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_projects')) {
            $this->aauth->applog(
                "Proje Oluşturuldu. ID : " . $id,
                $this->aauth->get_user()->username
            );
            return [
                'status'=>1,
                'message'=>'Başarıyla Güncellendi'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Güncelleme Olurken Hata Aldınız'
            ];
        }


    }


    public function updateTask($oran,$new_prd_id,$name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone,$quantity,$fiyat,$olcu_birimi,$total,$cari_id,$gorev_tipi,$task_id,$proje_id,$simeta_status)
    {

        $data = array(
            'tdate' => date('Y-m-d H:i:s'),
            'name' => $name,
            'status' => $status,
            'start' => $stdate,
            'duedate' => $tdate,
            'description' => $content,
            'eid' => $employee,
            'aid' => $assign,
            'related' => 1,
            'priority' => $priority,
            'rid' => $prid,
            'proje_id' => $prid,
            'asama_id' => $milestone,
            'quantity' => $quantity,
            'oran' => $oran,
            'fiyat' => $fiyat,
            'unit' => $olcu_birimi,
            'cari_id' => $cari_id,
            'toplam_fiyat' => $total,
            'gorev_tipi' => $gorev_tipi,
            'product_id' => $new_prd_id,
            'simeta_status' => $simeta_status

        );

        $this->db->set($data);

        $this->db->where('id', $task_id);

        return $this->db->update('geopos_todolist');

    }

    public function addtask($oran,$new_prd_id,$name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone,$quantity,$fiyat,$olcu_birimi,$total,$cari_id,$gorev_tipi,$simeta_status)

    {


        $data = array(
            'tdate' => date('Y-m-d H:i:s'),
            'name' => $name,
            'oran' => $oran,
            'status' => $status,
            'start' => $stdate,
            'duedate' => $tdate,
            'description' => $content,
            'eid' => $employee,
            'aid' => $assign,
            'related' => 1,
            'priority' => $priority,
            'rid' => $prid,
            'proje_id' => $prid,
            'asama_id' => $milestone,
            'quantity' => $quantity,
            'fiyat' => $fiyat,
            'unit' => $olcu_birimi,
            'cari_id' => $cari_id,
            'toplam_fiyat' => $total,
            'gorev_tipi' => $gorev_tipi,
            'product_id' => $new_prd_id,
            'simeta_status' => $simeta_status,

        );

        if ($prid) {



            $this->db->insert('geopos_todolist', $data);

            $last = $this->db->insert_id();

            kont_kayit(35,$last);



            if ($milestone) {

                $this->meta_insert($prid, 8, $milestone, $last);

            }



            $out = $this->communication($prid, $name);



            return 1;

        } else {

            return 0;

        }

    }


    public function update_asaama($olcu_birimi,$quantity,$fiyat,$total,$name, $stdate, $tdate, $content, $color, $prid,$bolum,$pers_id,$butce,$customer,$id,$parent_id)
    {
        $data = array('pid' => $prid, 'name' => $name, 'sdate' => $stdate, 'edate' => $tdate, 'color' => $color,
            'exp' => $content,'bolum_id'=>$bolum,'pers_id'=>$pers_id,'total'=>$butce,'customer_id'=>$customer,
            'olcu_birimi'=>$olcu_birimi,
            'quantity'=>$quantity,
            'fiyat'=>$fiyat,
            'toplam'=>$total,
            'parent_id'=>$parent_id);
        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_milestones');
    }

    public function salary_sort_update()
    {
        if($this->aauth->get_user()->id==21){
            $proje_id = $this->input->post('proje_id');
            $this->db->delete('maas_onay_sort', array('proje_id' => $proje_id));
            $details = $this->input->post('details');
            $product_list=[];
            $index=0;
            foreach ($details as $items){
                $data = [
                    'proje_id'=>$proje_id,
                    'user_id'=>$items['user_id'],
                    'sort'=>$items['sort'],
                ];
                $productlist[$index] = $data;
                $index++;
            }
            if($this->db->insert_batch('maas_onay_sort', $productlist)){
                return array('code' => 200, 'text' =>'Başarıyla Güncellendi');
            }
            else {
                return array('code' => 410, 'text' =>'Hata Aldınız');
            }
        }
        else {
            return array('code' => 410, 'text' =>'Yetkiniz Yok');
        }

    }

    public function add_milestone($olcu_birimi,$quantity,$fiyat,$total,$name, $stdate, $tdate, $content, $color, $prid,$bolum,$pers_id,$butce,$customer,$parent_id)

    {



        $data = array('pid' => $prid, 'name' => $name, 'sdate' => $stdate, 'edate' => $tdate, 'color' => $color,
            'exp' => $content,'bolum_id'=>$bolum,'pers_id'=>$pers_id,'total'=>$butce,
            'customer_id'=>$customer,
            'olcu_birimi'=>$olcu_birimi,
            'quantity'=>$quantity,
            'fiyat'=>$fiyat,
            'toplam'=>$total,
            'parent_id'=>$parent_id
        );

        if ($prid) {




            if($this->db->insert('geopos_milestones', $data))
            {
                $last_id=$this->db->insert_id();

                $title = '[Aşama Eklendi] ' . $name;
                $this->add_activity($title, $prid);

                kont_kayit(39,$last_id);
                return $last_id;
            }


        } else {

            return 0;

        }

    }





    public function edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)

    {



        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'related' => 0, 'priority' => $priority, 'rid' => 0);

        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_todolist');

        //return $this->db->insert('geopos_todolist', $data);

    }

    public function edit_bolum($bolum_id,$proje_id, $name, $content,$butce)

    {



        $data = array( 'name' => $name, 'exp' => $content, 'pid' => $proje_id,'butce' => $butce);

        $this->db->set($data);

        $this->db->where('id', $bolum_id);

        return $this->db->update('geopos_project_bolum');

    }



    public function settask($id, $stat)

    {



        $data = array('status' => $stat);

        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_todolist');

    }



    public function setnote($id, $stat)

    {



        $data = array('note' => $stat);

        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_projects');

    }



    public function deletetask($id)

    {



        return $this->db->delete('geopos_todolist', array('id' => $id));

    }



    public function deleteproject($id)

    {
        $sql=$this->db->query("SELECT * FROM  geopos_invoices Where proje_id=$id")->result();
        if($sql)
        {
            foreach ($sql as $invoices)
            {

                $this->db->delete('geopos_invoice_items', array('tid' => $invoices->id));
                $this->db->delete('geopos_invoices', array('id' => $invoices->id));
            }
        }

        $this->db->delete('geopos_todolist', array('related' => 1, 'rid' => $id));
        $this->db->delete('geopos_project_meta', array('pid' => $id));
        $this->db->delete('geopos_project_bolum', array('pid' => $id));
        $this->db->delete('geopos_milestones', array('pid' => $id));
        return $this->db->delete('geopos_projects', array('id' => $id));

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

    public function viewbolum($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_project_bolum');

        $this->db->where('geopos_project_bolum.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }



    public function project_stats($project)

    {



        $query = $this->db->query("SELECT

				COUNT(IF( status = 'Waiting', id, NULL)) AS Waiting,

				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,

				COUNT(IF( status = 'Finished', id, NULL)) AS Finished

				FROM geopos_projects");



        echo json_encode($query->result_array());



    }



    //project tasks


    //thread task





    public function task_thread($id)

    {



        $this->db->select('geopos_todolist.*, geopos_employees.name AS emp');

        $this->db->from('geopos_todolist');

        $this->db->where('geopos_todolist.related', 1);

        $this->db->where('geopos_todolist.rid', $id);

        $this->db->join('geopos_employees', 'geopos_todolist.eid = geopos_employees.id', 'left');

        $this->db->order_by('geopos_todolist.id', 'desc');

        $query = $this->db->get();

        return $query->result_array();

    }





    public function milestones($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_milestones');

        $this->db->where('pid', $id);

        $this->db->order_by('id', 'desc');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function milestones_list($id)

    {



        $query = $this->db->query('SELECT geopos_milestones.*,geopos_todolist.name as task FROM geopos_milestones LEFT JOIN geopos_project_meta ON geopos_project_meta.meta_data=geopos_milestones.id AND geopos_project_meta.meta_key=8 LEFT JOIN geopos_todolist ON geopos_project_meta.value=geopos_todolist.id WHERE geopos_milestones.pid=' . $id . ' GROUP BY geopos_milestones.id  ORDER BY geopos_milestones.id ASC;');

        return $query->result_array();





    }

    public function bolumler($id)
    {

        $this->db->select('*');

        $this->db->from('geopos_project_bolum');

        $this->db->where('pid', $id);

        $this->db->order_by('id', 'asc');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function bolumler_list($id)

    {



        $query = $this->db->query('
        SELECT geopos_project_bolum.*,geopos_project_bolum.name as task FROM geopos_project_bolum

        WHERE geopos_project_bolum.pid=' . $id . ' ORDER BY geopos_project_bolum.id ASC;');

        return $query->result_array();





    }



    public function activities($id)

    {



        $this->db->select('geopos_project_meta.value');

        $this->db->from('geopos_project_meta');

        $this->db->where('pid', $id);

        $this->db->where('meta_key', 12);

        $query = $this->db->get();

        return $query->result_array();

    }



    public function p_files($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_project_meta');

        $this->db->where('pid', $id);

        $this->db->where('meta_key', 9);

        $query = $this->db->get();

        return $query->result_array();

    }



    public function add_activity($name, $prid,$key3='',$tutar=0)

    {



        $data = array('key3'=>$key3,'pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'),'total'=>$tutar);

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;

        }

    }



    public function meta_insert($prid, $meta_key, $meta_data, $value)

    {



        $data = array('pid' => $prid, 'meta_key' => $meta_key, 'meta_data' => $meta_data, 'value' => $value);

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;

        }

    }



    public function deletefile($pid, $mid)

    {



        $this->db->select('value');

        $this->db->from('geopos_project_meta');

        $this->db->where('pid', $pid);

        $this->db->where('meta_key', 9);

        $this->db->where('meta_data', $mid);

        $query = $this->db->get();

        $result = $query->row_array();

        unlink(FCPATH . 'userfiles/project/' . $result['value']);

        $this->db->delete('geopos_project_meta', array('pid' => $pid, 'meta_key' => 9, 'meta_data' => $mid));

    }



    public function deletemilestone($mid)

    {

        $this->db->delete('geopos_milestones', array('id' => $mid));

    }

    public function delete_bolum($mid)

    {

        return $this->db->delete('geopos_project_bolum', array('id' => $mid));

    }



    //comments



    public function comments_thread($id)

    {



        $this->db->select('geopos_project_meta.value, geopos_project_meta.key3,geopos_employees.name AS employee, geopos_customers.name AS customer');

        $this->db->from('geopos_project_meta');

        $this->db->where('geopos_project_meta.pid', $id);

        $this->db->where('geopos_project_meta.meta_key', 13);

        $this->db->join('geopos_employees', 'geopos_project_meta.meta_data = geopos_employees.id', 'left');

        $this->db->join('geopos_customers', 'geopos_project_meta.key3 = geopos_customers.id', 'left');

        $this->db->order_by('geopos_project_meta.id', 'desc');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function add_comment($comment, $prid, $emp)

    {



        $data = array('pid' => $prid, 'meta_key' => 13, 'meta_data' => $emp, 'value' => $comment . '<br><small>@' . date('Y-m-d H:i:s') . '</small>');

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;

        }

    }



    public function progress($id, $val)

    {

        if ($val == 100) $stat = 'Finished'; else $stat = 'Progress';

        $data = array('status' => $stat, 'progress' => $val);

        $this->db->set($data);

        $this->db->where('id', $id);

        return $this->db->update('geopos_projects');

    }





    public function task_stats($id)

    {

        $query = $this->db->query("SELECT

				COUNT(IF( status = 'Due', id, NULL)) AS Due,

				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,

				COUNT(IF( status = 'Done', id, NULL)) AS Done

				FROM geopos_todolist WHERE related=1 AND rid=$id");



        echo json_encode($query->result_array());



    }



    public function list_project_employee($id)

    {

        $this->db->select('geopos_employees.*');

        $this->db->from('geopos_project_meta');

        $this->db->where('geopos_project_meta.pid', $id);

        $this->db->where('geopos_project_meta.meta_key', 19);

        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_project_meta.meta_data', 'left');

        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');

        $this->db->order_by('geopos_users.roleid', 'DESC');

        $query = $this->db->get();

        return $query->result_array();

    }



    private function communication($id, $sub)

    {



        $this->db->select('geopos_projects.name as pname,geopos_projects.ptype,geopos_customers.name as cust,geopos_customers.email');

        $this->db->from('geopos_projects');

        $this->db->where('geopos_projects.id', $id);

        $this->db->join('geopos_customers', "geopos_customers.id = geopos_projects.cid", 'left');

        $query = $this->db->get();

        $result = $query->row_array();



        if ($result['ptype'] == '1') {

            $this->db->select('geopos_users.email,geopos_users.username');

            $this->db->from('geopos_project_meta');

            $this->db->where('geopos_project_meta.pid', $id);

            $this->db->where('geopos_project_meta.meta_key', 19);

            $this->db->join('geopos_users', "geopos_project_meta.meta_data = geopos_users.id", 'left');

            $query = $this->db->get();

            $result_c = $query->result_array();

            $message = '<h3>Dear Project Participant,</h3>

                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added ' . $sub . '</p><p>With Reagrds,<br>Project Communication Manager';

            foreach ($result_c as $row) {

                $this->send_email($row['email'], $row['username'], '[Task Added]' . $sub, $message);

            }





        } else if ($result['ptype'] == '2') {



            $this->db->select('geopos_users.email,geopos_users.username');

            $this->db->from('geopos_project_meta');

            $this->db->where('geopos_project_meta.pid', $id);

            $this->db->where('geopos_project_meta.meta_key', 19);

            $this->db->join('geopos_users', "geopos_project_meta.meta_data = geopos_users.id", 'left');

            $query = $this->db->get();

            $result_c = $query->result_array();

            $message = '<h3>Dear Project Participant,</h3>

                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added <strong>' . $sub . '</strong></p><p>With Regards,<br>Project Communication Manager</p>';

            foreach ($result_c as $row) {

                $this->send_email($row['email'], $row['username'], '[Task Added] ' . $sub, $message);

            }



            $message = '<h3>Dear Customer,</h3>

                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added <strong>' . $sub . '</strong></p><p>With Warm Regards,<br>Project Communication Manager</p>';



            $this->send_email($result['email'], $result['cust'], '[Task Added] ' . $sub, $message);



        }



    }



    private function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth_type = $smtpresult['auth_type'];

        $auth = $smtpresult['auth'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');



        $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type,$username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);



    }

    public function customer_details()
    {
        $this->db->select('*');

        $this->db->from('geopos_customers');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function task_status()
    {
        $this->db->select('*');

        $this->db->from('geopos_task_status');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function hizmetler_list($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_todolist');
        $this->db->where('proje_id',$id);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function addnew($product_name,
                           $product_code, $product_price, $factoryprice, $taxrate,
                           $disrate, $product_qty, $product_qty_alert, $product_desc,
                           $image, $unit, $barcode,$product_type)

    {

        $depo_id=firmaya_gore_depo_ogren($this->session->userdata('set_firma_id'));

        if (is_numeric($barcode)) {



            $data = array(

                'project_status' => 0,
                'product_name' => $product_name,

                'product_code' => $product_code,

                'product_price' => $product_price,

                'fproduct_price' => $factoryprice,

                'taxrate' => $taxrate,

                'disrate' => $disrate,

                'qty' => $product_qty,

                'product_des' => $product_desc,

                'alert' => $product_qty_alert,

                'unit' => $unit,

                'image' => $image,

                'barcode' => $barcode,

                'product_type' => $product_type,
                'warehouse' => 13 // Deposunu bul ekle

            );



        } else {



            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);



            $data = array(
                'project_status' => 1,

                'product_name' => $product_name,

                'product_code' => $product_code,

                'product_price' => $product_price,

                'fproduct_price' => $factoryprice,

                'taxrate' => $taxrate,

                'disrate' => $disrate,

                'qty' => $product_qty,

                'product_des' => $product_desc,

                'alert' => $product_qty_alert,

                'unit' => $unit,

                'image' => $image,

                'barcode' => $barcode,

                'product_type' => $product_type,
                'warehouse' => 13


            );

        }

        $this->db->trans_start();

        if ($this->db->insert('geopos_products', $data)) {

            $pid = $this->db->insert_id();

            //depo tablosuna insert

            $depo_arr=array(
                'product_id'=>$pid,
                'warehouse_id'=>$depo_id,
                'qty'=>0,
                'loc'=>$this->session->userdata('set_firma_id')
            );
            $this->db->insert('geopos_product_to_warehouse', $depo_arr);

            //depo tablosuna insert

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED') . "  <a href='service_product' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }
        $this->db->trans_complete();
    }


    public function addnew_todo($product_name,
                                $product_code, $product_price, $factoryprice, $taxrate,
                                $disrate, $product_qty, $product_qty_alert, $product_desc,
                                $image, $unit, $barcode,$product_type)

    {

        $depo_id=firmaya_gore_depo_ogren($this->session->userdata('set_firma_id'));

        if (is_numeric($barcode)) {



            $data = array(

                'project_status' => 1,
                'product_name' => $product_name,

                'product_code' => $product_code,

                'product_price' => $product_price,

                'fproduct_price' => $factoryprice,

                'taxrate' => $taxrate,

                'disrate' => $disrate,

                'qty' => $product_qty,

                'product_des' => $product_desc,

                'alert' => $product_qty_alert,

                'unit' => $unit,

                'image' => $image,

                'barcode' => $barcode,

                'product_type' => $product_type,
                'warehouse' => 13

            );



        } else {



            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);



            $data = array(
                'project_status' => 1,

                'product_name' => $product_name,

                'product_code' => $product_code,

                'product_price' => $product_price,

                'fproduct_price' => $factoryprice,

                'taxrate' => $taxrate,

                'disrate' => $disrate,

                'qty' => $product_qty,

                'product_des' => $product_desc,

                'alert' => $product_qty_alert,

                'unit' => $unit,

                'image' => $image,

                'barcode' => $barcode,

                'product_type' => $product_type,
                'warehouse' => 13


            );

        }

        $this->db->trans_start();

        if ($this->db->insert('geopos_products', $data)) {

            $pid = $this->db->insert_id();

            //depo tablosuna insert

            $depo_arr=array(
                'product_id'=>$pid,
                'warehouse_id'=>$depo_id,
                'qty'=>0,
                'loc'=>$this->session->userdata('set_firma_id')
            );
            $this->db->insert('geopos_product_to_warehouse', $depo_arr);

            //depo tablosuna insert


        }
        $this->db->trans_complete();
        return $pid;
    }


    //aşamalar

    public function asama_details($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_milestones');

        $this->db->where('geopos_milestones.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }




    //Bolumler

    private function _get_datatables_query($id = '', $w = '')

    {





        $this->db->from($this->table_prd);

        $this->db->where('geopos_products.merge', 0);
        $this->db->where('geopos_products.parent_id', 0);
        $this->db->where('geopos_products.project_status', 1);

        $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat','LEFT');
        $this->db->join('geopos_product_to_warehouse', 'geopos_product_to_warehouse.product_id = geopos_products.pid');

        if ($this->session->userdata('set_firma_id')) {




            $this->db->group_start();

            $this->db->where('geopos_product_to_warehouse.loc', $this->session->userdata('set_firma_id'));

            $this->db->or_where('geopos_product_to_warehouse.loc', 0);

            $this->db->group_end();

        }








        $i = 0;



        foreach ($this->column_search_prd as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search_prd) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) // here order processing

        {

            $this->db->order_by($this->column_order_prd[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order_prd)) {

            $order = $this->order_prd;

            $this->db->order_by(key($order), $order[key($order)]);

        }



    }



    function get_datatables($id = '', $w = '')

    {

        if ($id > 0) {

            $this->_get_datatables_query($id, $w);

        } else {

            $this->_get_datatables_query();

        }

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }

    public function count_all()

    {

        $this->db->from($this->table_prd);

        if ($this->session->userdata('set_firma_id')) {

            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

            $this->db->where('geopos_warehouse.loc', $this->session->userdata('set_firma_id'));

            $this->db->or_where('geopos_warehouse.loc', 0);

        }

        return $this->db->count_all_results();

    }

    function count_filtered($id, $w = '')

    {

        if ($id > 0) {

            $this->_get_datatables_query($id, $w);

        } else {

            $this->_get_datatables_query();

        }



        $query = $this->db->get();

        return $query->num_rows();

    }

    // Tüm Giderler
    function all_gider_datatables($proje_id)

    {
        $this->_all_gider_datatables($proje_id);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _all_gider_datatables($proje_id)

    {

        $this->db->select("
        geopos_invoice_type.type_value,
        geopos_invoice_type.description as invoice_desc,
        geopos_project_items_gider.*,
        geopos_invoices.kur_degeri,
        geopos_invoice_items.tax as product_tax,
        geopos_invoices.refer,geopos_invoices.csd,geopos_invoices.method,geopos_account_type.name as method_name,
        geopos_invoices.odeme_durumu,geopos_invoices.invoicedate,geopos_customers.company,geopos_invoices.invoice_no,geopos_invoices.notes");

        $this->db->from('geopos_invoices');
        if($this->input->post('customer_id'))
        {
            $this->db->where_in('geopos_invoices.csd', $this->input->post('customer_id'));
        }

        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id = geopos_invoice_type.id','LEFT');
        $this->db->join('geopos_account_type', 'geopos_invoices.method = geopos_account_type.id','LEFT');
        $this->db->join('geopos_project_items_gider', 'geopos_project_items_gider.tid = geopos_invoices.id','LEFT');
        $this->db->join('geopos_invoice_items', 'geopos_invoices.id = geopos_invoice_items.tid','LEFT');
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id','LEFT');



        //$this->db->where("IF(geopos_invoice_type.type_value='fatura',geopos_invoice_items.proje_id=$proje_id,geopos_invoices.proje_id=$proje_id)");
        $this->db->where("geopos_project_items_gider.proje_id=$proje_id");
        $this->db->where("geopos_invoices.status!=3");
        $this->db->where_not_in("geopos_project_items_gider.invoice_type_id",'1,29,64');




        $i = 0;



        foreach ($this->column_search_gider as $item) // loop column

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



                if (count($this->column_search_gider) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by('geopos_invoices.invoicedate', 'DESC');

        }

        $this->db->group_by('geopos_project_items_gider.id');

    }



    public function update_stock(){

        $proje_id = $this->input->post('proje_id');
        $details = $this->details($proje_id);
        $name = $details['name'];
        $data = [
            'stok_giris_durumu'=>1
        ];
        $this->db->where('id',$proje_id);
        $this->db->set($data);
        if($this->db->update('geopos_projects', $data)){
            $title = 'Proje Stokları Girişi Kapatıldı ' . $name.' | Personel'.$this->aauth->get_user()->username;;
            $this->add_activity($title, $proje_id);
            $this->aauth->applog("Proje Stokları Girişi Kapatıldı: ".$proje_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Stok Girişi Kapatıldı',
                'id'=>$proje_id
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                'id'=>0
            ];
        }
    }


}
