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



defined('BASEPATH') or exit('No direct script access allowed');



class Categories_model extends CI_Model

{

    public function category_list($cat_id = 0)

    {

        if ($cat_id != 0) {

            $query = $this->db->query("SELECT `id`,`parent_id`,`cat_type`,`extra`, if( (SELECT GROUP_CONCAT(cat2.title,' | ',cat1.title) From 
            geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) is null ,cat2.title, (SELECT GROUP_CONCAT(cat1.title,' | ',cat2.title) From 
            geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) ) as title FROM `geopos_product_cat` cat2 where cat2.id!=$cat_id
            ORDER BY cat2.id DESC");
        } else {

            $query = $this->db->query("SELECT `id`,`parent_id`,`cat_type`,`extra`, if( (SELECT GROUP_CONCAT(cat2.title,' | ',cat1.title) From 
            geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) is null ,cat2.title, (SELECT GROUP_CONCAT(cat1.title,' | ',cat2.title) From 
            geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) ) as title FROM 
            `geopos_product_cat` cat2
            ORDER BY cat2.id DESC");
        }

        return $query->result_array();
    }




    public function category_list_($cat_id = 0)
    {

        if ($cat_id != 0) {
            $query = $this->db->query("SELECT `id`,`parent_id`,`cat_type`,`extra`, if( (SELECT GROUP_CONCAT(cat2.title,'-->',cat1.title) From 
            geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) is null ,cat2.title, (SELECT GROUP_CONCAT(cat1.title,'-->',cat2.title) From 
            geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) ) as title FROM `geopos_product_cat` cat2 where cat2.id!=$cat_id
            ORDER BY cat2.id DESC");
        } else {
            $query = $this->db->query("SELECT * From geopos_product_cat Where parent_id=0");
        }

        return $query->result_array();
    }



    public function alt_kat($cat_id = 0)

    {
        $query = $this->db->query("SELECT * FROM geopos_product_cat Where parent_id!=0");

        return $query->result_array();
    }



    public function warehouse_list()

    {
        $where = '';

        if ($this->aauth->get_user()->loc) $where = ' WHERE loc=' . $this->aauth->get_user()->loc . ' OR loc=0';

        $query = $this->db->query("SELECT id,title FROM geopos_warehouse $where ORDER BY id DESC");

        return $query->result_array();
    }



    public function category_stock()

    {

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_product_cat AS c LEFT JOIN ( SELECT geopos_products.pcat,COUNT(geopos_products.pid) AS pc,SUM(geopos_products.product_price*geopos_products.qty) AS salessum, SUM(geopos_products.fproduct_price*geopos_products.qty) AS worthsum,SUM(geopos_products.qty) AS qty FROM geopos_products LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id WHERE  geopos_products.parent_id=0 and (geopos_warehouse.loc=" . $this->aauth->get_user()->loc . " OR geopos_warehouse.loc=0) GROUP BY geopos_products.pcat ) AS p ON c.id=p.pcat ");

        return $query->result_array();
    }



    public function warehouse()

    {

        $where = '';

        if ($this->aauth->get_user()->loc) $where = ' WHERE c.loc=' . $this->aauth->get_user()->loc . ' OR c.loc=0';

        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM geopos_warehouse AS c LEFT JOIN 
	( 
		SELECT geopos_product_to_warehouse.warehouse_id,geopos_product_to_warehouse.id,COUNT(geopos_product_to_warehouse.product_id) AS pc,
		SUM(geopos_products.product_price*geopos_product_to_warehouse.qty) AS salessum, SUM(geopos_products.fproduct_price*geopos_product_to_warehouse.qty) AS worthsum
		,SUM(geopos_product_to_warehouse.qty) AS qty FROM  geopos_product_to_warehouse INNER JOIN geopos_products on
		geopos_product_to_warehouse.product_id=geopos_products.pid where geopos_products.parent_id=0
		
		 GROUP BY warehouse_id ) 
		AS p ON 
		c.id=p.warehouse_id  
  $where");

        return $query->result_array();
    }



    public function cat_ware($id)

    {

        $query = $this->db->query("SELECT c.id AS cid, w.id AS wid,c.title AS catt,w.title AS watt FROM geopos_products AS p LEFT JOIN geopos_product_cat AS c ON p.pcat=c.id LEFT JOIN geopos_warehouse AS w ON p.warehouse=w.id WHERE

p.pid='$id' ");

        return $query->row_array();
    }



    public function addnew($cat_name, $cat_desc, $cat_type = 0, $cat_rel = 0)

    {

        if (!$cat_type) $cat_type = 0;
        if (!$cat_rel) $cat_rel = 0;

        $data = array(

            'title' => $cat_name,

            'parent_id' => $cat_rel,

            'cat_type' => $cat_type,

            'extra' => $cat_desc

        );



        if ($this->db->insert('geopos_product_cat', $data)) {

            $id = $this->db->insert_id();
            $this->aauth->applog("Kategori Oluşturuldu $cat_name ID " . $this->db->insert_id(), $this->aauth->get_user()->username);

            kont_kayit(3, $id);

            echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('ADDED') . "  <a href='add' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

            $this->lang->line('ERROR')));
        }
    }



    public function addwarehouse($cat_name, $cat_desc, $lid, $proje_id = 0)

    {

        $data = array(

            'title' => $cat_name,

            'extra' => $cat_desc,

            'proje_id' => $proje_id,

            'loc' => $lid

        );




        if ($this->db->insert('geopos_warehouse', $data)) {

            $id = $this->db->insert_id();

            $this->aauth->applog("Depo Açıldı $cat_name ID " . $id, $this->aauth->get_user()->username);

            kont_kayit(5, $id);

            echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('ADDED') . "  <a href='addwarehouse' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

            $this->lang->line('ERROR')));
        }
    }



    public function edit($catid, $product_cat_name, $product_cat_desc, $cat_type = 0, $cat_rel = 0)

    {

        if (!$cat_type) $cat_type = 0;
        if (!$cat_rel) $cat_rel = 0;

        $data = array(

            'title' => $product_cat_name,

            'parent_id' => $cat_rel,

            'cat_type' => $cat_type,

            'extra' => $product_cat_desc

        );





        $this->db->set($data);

        $this->db->where('id', $catid);



        if ($this->db->update('geopos_product_cat')) {

            $this->aauth->applog("[Kategori Düzenlend] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);

            kont_kayit(4, $catid);

            echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('UPDATED')));
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

            $this->lang->line('ERROR')));
        }
    }



    public function editwarehouse($catid, $product_cat_name, $product_cat_desc, $lid, $proje_id = 0)

    {

        $data = array(

            'title' => $product_cat_name,

            'extra' => $product_cat_desc,
            'proje_id' => $proje_id,

            'loc' => $lid

        );





        $this->db->set($data);

        $this->db->where('id', $catid);



        if ($this->db->update('geopos_warehouse')) {

            $this->aauth->applog("[Depo Düzenlendi] $product_cat_name ID " . $catid, $this->aauth->get_user()->username);

            kont_kayit(6, $catid);

            echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('UPDATED')));
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

            $this->lang->line('ERROR')));
        }
    }
}
