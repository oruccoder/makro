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


if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Baku');


function all_products_like($like,$warehouse_id=0)
{
    $ci =& get_instance();
    $ci->load->database();

    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM `geopos_products`  Where  geopos_products.loc=$loc 
                           and (geopos_products.product_code LIKE '%$like%'  or
                                geopos_products.short_name LIKE '%$like%'  or
                     geopos_products.product_name_tr LIKE '%$like%'  or 
                     geopos_products.product_name_en LIKE '%$like%'  or
                     geopos_products.short_name LIKE '%$like%'  or
                     geopos_products.product_name LIKE '%$like%') and deleted_at is null");
    //$query2 = $ci->db->query("SELECT * FROM `geopos_products` INNER JOIN stock ON geopos_products.pid = stock.product_id Where stock.warehouse_id = $warehouse_id and geopos_products.product_name LIKE '%$like%' GROUP BY stock.product_id");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return false;
    }

}
function all_products_like_warehouse($tip,$like,$warehouse_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $loc = $ci->session->userdata('set_firma_id');
    if($tip==0){
        $query2 = $ci->db->query("SELECT * FROM `geopos_products` INNER JOIN stock ON geopos_products.pid = stock.product_id Where geopos_products.loc=$loc and stock.warehouse_id = $warehouse_id and geopos_products.product_name LIKE '%$like%' GROUP BY stock.product_id");

    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `geopos_products` Where geopos_products.loc=$loc and geopos_products.product_name LIKE '%$like%'");

    }

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return false;
    }

}
function datatable_lang()
{
    $ci =& get_instance();
    $result='';
    $lang= $ci->config->item('mylang');
    $dfile=FCPATH . 'application/language/'.$lang.'/datatable.php';
    if(file_exists($dfile)) $result=include_once($dfile);
    echo $result;
}

function doviz_transfer_item($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM doviz_transfer_item where (talep_eden_id= $id or talep_edilen_id=$id)");
    $row = $query2->row();
    return $row;


}

function tatil_gunleri($m,$y)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT COUNT(id) as say FROM holidays where `month`= $m and `year`=$y and deleted_at IS NULL");
    $row = $query2->row()->say;
    return $row;


}

function tatil_kontrol($y,$m,$d)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT COUNT(id) as say FROM holidays where `month`= $m and `year`=$y  and `day`=$d and deleted_at IS NULL");
    $row = $query2->row()->say;
    return $row;


}


function amountFormat_general($number)
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    $number = @number_format($number, $row['url'], $row['key1'], '');
    return $number;
}

function dateformat($input)
{

    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat'));

    return $date;
}
function dateformat_time($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat').' H:i:s');
    return $date;
}
function dateformat_local($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}
function dateformat_new($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format('d/m/Y');
    return $date;
}

function now_date()
{
    date_default_timezone_set('Asia/Baku');
    $ci =& get_instance();
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}


function date_ajanda($input)
{
    $date = new DateTime($input);
    $date = $date->format('Y-m-d');
    return $date;
}

function date_izin($input)
{
    $date = new DateTime($input);
    $date = $date->format('d-m-Y');
    return $date;
}

function date_filter($input)
{
    $date = new DateTime($input);
    $date = $date->format('Y-m-d');
    return $date;
}

function datefordatabase($input)
{

    date_default_timezone_set('Asia/Baku');
    $time = date('H:i:s');
    $date = new DateTime($input.' '.$time);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}

function datefordatabasefilter($input)
{

    date_default_timezone_set('Asia/Baku');
    $time ='00:00:00';
    $date = new DateTime($input.' '.$time);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}


function timefordatabase($input)
{
    $time = new DateTime($input);
    $time = $time->format('H:i:s');
    return $time;
}

function user_role($id = 5)
{  $ci =& get_instance();
    switch ($id) {
        case 5:
            return $ci->lang->line('Business Owner');
            break;
        case 4:
            return $ci->lang->line('Business Manager');
            break;
        case 3:
            return $ci->lang->line('Sales Manager');
            break;
        case 2:
            return $ci->lang->line('Sales Person');
            break;
        case 1:
            return $ci->lang->line('Inventory Manager');
            break;
        case -1:
            return $ci->lang->line('Project Manager');
            break;


    }
}

function roles($id=0)
{

    $ci =& get_instance();



    $query = $ci->db->query("SELECT name FROM geopos_role WHERE role_id=$id");
    $row = $query->row_array();
    $name = $row['name'];


    return $name;
}
function role_id($id)
{
    $ci =& get_instance();

    $query = $ci->db->query("SELECT roleid FROM geopos_users WHERE id=$id");
    $row = $query->row_array();
    $name = $row['roleid'];


    return $name;
}
function salary_type($id=0)
{

    $ci =& get_instance();
    if($id){
        $query = $ci->db->query("SELECT * FROM salary_type Where id=$id");
        $row = $query->row();
        return $row;
    }
    else{
        $query = $ci->db->query("SELECT * FROM salary_type ");
        $row = $query->result();
        return $row;
        }

}

function role_name($id=0)
{

    $ci =& get_instance();



    if($id){
        $query = $ci->db->query("SELECT * FROM geopos_role Where role_id=$id");
        $row = $query->row_array();
        return $row;
    }
    else {
        $query = $ci->db->query("SELECT * FROM geopos_role ");
        $row = $query->result_array();
        return $row;
    }

}

function vatandaslik($id=0)
{

    $ci =& get_instance();



    if($id){
        $query = $ci->db->query("SELECT * FROM geopos_vatandaslik Where id=$id");
        $row = $query->row_array();
        return $row;
    }
    else {
        $query = $ci->db->query("SELECT * FROM geopos_vatandaslik ");
        $row = $query->result_array();


        return $row;
    }


}


function genel_mudur_onay_kontrol($id)
{

    $ci =& get_instance();

    $query = $ci->db->query("SELECT * FROM geopos_onay Where malzeme_items_id=$id")->row()->genel_mudur_status;
    if($query==3){
        return true;
    }
    elseif($query==1){
        return true;
    }
    else {
        return false;
    }

}


function cari_product_details($product_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `cari_products` WHERE id=$product_id");
    return $query2->row();
}
function product_details_($product_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_products` WHERE pid=$product_id");
    return $query2->row();
}

function firma_teklif_tutar($firma,$satin_alma_id)
{
    $ci =& get_instance();
    $sub_total=0;
    $query = $ci->db->query("SELECT * FROM geopos_talep_items WHERE firma='$firma' and tip=$satin_alma_id and ref_urun=0")->result();
    foreach ($query as $qr)
    {
        $sub_total+=$qr->subtotal;
    }
    return $sub_total;
}
function firma_teklif_tutar_ekstra($firma,$satin_alma_id)
{
    $ci =& get_instance();
    $sub_total=0;
    $query = $ci->db->query("SELECT * FROM geopos_talep_items WHERE firma='$firma' and tip=$satin_alma_id and ref_urun=1")->result();
    foreach ($query as $qr)
    {
        $sub_total+=$qr->subtotal;
    }
    return $sub_total;
}

function satinalma_ortalama_getir($talep_item_id,$talep_id)
{

    $ci =& get_instance();



    $query = $ci->db->query("SELECT * FROM geopos_item_alt WHERE talep_id=$talep_id and talep_id_item=$talep_item_id")->result();
    $sayi=0;
    $price=0;
    foreach ($query as $q)
    {
        if($q->price!=0)
        {
            $price+=$q->price;
            $sayi++;
        }

    }


    $ort=0;
    if($price!=0)
    {
        $ort=$price/$sayi;
    }


    return $ort;


}

function onay_kontrol($talep_id)
{
    $ci =& get_instance();
    $querys=$ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and  status NOT IN (6,4)")->row_array();
    return $querys['bildirim_durumu'];
}
//function satinalma_onay($talep_id,$role_id,$user_id)
//{
//
//    $ci =& get_instance();
//
//
//    $querys=$ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and (`proje_muduru_id`=$user_id or `bolum_mudur_id`=$user_id or `genel_mudur_id`=$user_id or `finans_departman_pers_id`=$user_id)
//");
//    if($querys->num_rows()>0 )
//    {
//        $tip=$querys->row()->tip;
//
//        if($querys->row()->proje_sorumlusu_id==$user_id)
//        {
//            $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//
//            if($query->num_rows()>0)
//            {
//                foreach ($query->result() as $q)
//                {
//                    if($q->proje_sorumlusu_status==3)
//                    {
//                        return 1;
//                    }
//                    if($q->proje_sorumlusu_status==4)
//                    {
//                        return 1;
//                    }
//                    if($q->proje_sorumlusu_status==2)
//                    {
//                        return 1;
//                    }
//                    else
//                    {
//                        return  0;
//
//                    }
//                }
//            }
//            else
//            {
//                return 1;
//            }
//        }
//        if($querys->row()->proje_muduru_id==$user_id)
//        {
//            $query='';
//            if($tip==2)
//            {
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//            }
//            else
//            {
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3 ");
//            }
//
//            if($query->num_rows()>0)
//            {
//                $array=array();
//                foreach ($query->result() as $q)
//                {
//
//                    $array[]=$q->proje_muduru_status;
//
//                }
//                if (in_array("3", $array)) // Onay
//                {
//                    return 1;
//                }
//                else if (in_array("2", $array)) // Yorum
//                {
//                    return 1;
//                }
//                else if (in_array("4", $array)) //iptal
//                {
//                    return 1;
//                }
//                else
//                {
//                    return 0;
//                }
//
//            }
//            else
//            {
//                return 1;
//            }
//        }
//        if($querys->row()->genel_mudur_id==$user_id)
//        {
//            $query_='';
//            if($tip==2)
//            {
//
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//                if($query_->num_rows()>0)
//                {
//                    $array=array();
//                    $array_proje=array();
//                    foreach ($query_->result() as $q)
//                    {
//
//                        $array[]=$q->genel_mudur_status;
//                        $array_proje[]=$q->proje_muduru_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 1;
//                    }
//                    else if (in_array("2", $array)) // Yorum
//                    {
//                        return 1;
//                    }
//                    else if (in_array("4", $array)) //iptal
//                    {
//                        return 1;
//                    }
//                    else if(in_array('1',$array_proje))
//                    {
//                        return 1;
//                    }
//                    else
//                    {
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//
//            }
//            else
//            {
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and proje_sorumlusu_status=3  and bolum_muduru_status=3");
//
//                if($query_->num_rows()>0)
//                {
//                    $array=array();
//                    foreach ($query_->result() as $q)
//                    {
//
//                        $array[]=$q->genel_mudur_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 1;
//                    }
//                    else if (in_array("2", $array)) // Yorum
//                    {
//                        return 1;
//                    }
//                    else if (in_array("4", $array)) //iptal
//                    {
//                        return 1;
//                    }
//                    else
//                    {
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//
//
//
//
//        }
//        if($querys->row()->finans_departman_pers_id==$user_id)
//        {
//            $query_='';
//            if($tip==2)
//            {
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");
//            }
//            else
//            {
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");
//            }
//
//            if($query_->num_rows()>0)
//            {
//                $array=array();
//                foreach ($query_->result() as $q)
//                {
//
//                    $array[]=$q->finans_status;
//
//                }
//                if (in_array("3", $array)) // Onay
//                {
//                    return 1;
//                }
//                else if (in_array("2", $array)) // Yorum
//                {
//                    return 1;
//                }
//                else if (in_array("4", $array)) //iptal
//                {
//                    return 1;
//                }
//                else
//                {
//                    return 0;
//                }
//            }
//            else
//            {
//                return 1;
//            }
//
//
//
//        }
//
//        if($tip!=2)
//        {
//            if($querys->row()->bolum_mudur_id==$user_id) // Depo Müdürü
//            {
//                $query_='';
//                if($tip==2)
//                {
//                    $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//                }
//                else
//                {
//                    $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 ");
//                }
//                if($query_->num_rows()>0)
//                {
//                    $array=array();
//                    foreach ($query_->result() as $q)
//                    {
//
//                        $array[]=$q->bolum_muduru_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 1;
//                    }
//                    else if (in_array("2", $array)) // Yorum
//                    {
//                        return 1;
//                    }
//                    else if (in_array("4", $array)) //iptal
//                    {
//                        return 1;
//                    }
//                    else
//                    {
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//
//
//        }
//
//        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE satinalma_yonlendirme=$user_id");
//        if($query_->num_rows()>0)
//        {
//            $array = array();
//            foreach ($query_->result() as $q) {
//
//                $array[] = $q->genel_mudur_status;
//
//            }
//            if (in_array("3", $array)) // Onay
//            {
//                return 0;
//            } else if (in_array("2", $array)) // Yorum
//            {
//                return 0;
//            } else if (in_array("4", $array)) //iptal
//            {
//                return 0;
//            } else {
//                return 1;
//            }
//
//        }
//        else
//        {
//            return 1;
//        }
//
//    }
//    else
//    {
//
//        $sf_kontrol = $ci->db->query("SELECT * FROM geopos_talep WHERE hazirlayan_pers_id=$user_id and malzeme_talep_form_id=$talep_id");
//        $sf_kontrol2 = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id")->row();
//        if($sf_kontrol->num_rows()>0)
//        {
//            return 1;
//        }
//
//        if($sf_kontrol2->malzeme_talep_durumu==1)
//        {
//            return 1;
//        }
//        else
//        {
//            $queryKs = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and hazirlayan_pers_id=$user_id"); //64 //3
//            $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE  type=1 and satinalma_status=1 and file_id=$talep_id and satinalma_yonlendirme=$user_id");
//
//            if($query_->num_rows()>0)
//            {
//                $array = array();
//                foreach ($query_->result() as $q) {
//
//                    $array[] = $q->genel_mudur_status;
//
//                }
//                if (in_array("3", $array)) // Onay
//                {
//                    return 0;
//                } else if (in_array("2", $array)) // Yorum
//                {
//                    return 0;
//                } else if (in_array("4", $array)) //iptal
//                {
//                    return 0;
//                } else {
//                    return 1;
//                }
//
//            }
//            else if($queryKs->num_rows()>0)
//            {
//                $queryK = $ci->db->query("SELECT * FROM geopos_onay WHERE satinalma_status=1 and file_id=$talep_id");
//                if($queryK->num_rows()>0)
//                {
//                    $array = array();
//                    foreach ($queryK->result() as $q) {
//
//                        $array[] = $q->genel_mudur_status;
//
//                    }
//
//                    foreach ($queryK->result() as $q) {
//
//                        $array[] = $q->proje_muduru_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 0;
//                    } else if (in_array("2", $array)) // Yorum
//                    {
//                        return 0;
//                    } else if (in_array("4", $array)) //iptal
//                    {
//                        return 0;
//                    } else
//                    {
//                        return 0;
//                    }
//                }
//                else
//                {
//                    return 1;
//                }
//
//            }
//            else
//            {
//                return 1;
//            }
//        }
//
//    }
//
//}


//function satinalma_onay($talep_id,$role_id,$user_id,$invoice_status=0) son
//{
//
//    $ci =& get_instance();
//    if($invoice_status==1){
//        $querys=$ci->db->query("SELECT * FROM geopos_invoices WHERE id=$talep_id and (`proje_sorumlu_id`=$user_id  or `proje_muduru_id`=$user_id  or `genel_mudur_id`=$user_id) and status !=3 ");
//
//        if($querys->num_rows()>0 ){
//
//            if($querys->row()->proje_sorumlu_id==$user_id)
//            {
//
//                $query='';
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id  and type = 10");
//                if($query->num_rows()>0)
//                {
//                    if($query->row()->proje_sorumlusu_status==3){
//                        return 1;
//                    }
//                    else if($query->row()->proje_sorumlusu_status==4){
//                        return 1;
//                    }
//                    else if($query->row()->proje_sorumlusu_status==1){
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//            if($querys->row()->proje_muduru_id==$user_id)
//            {
//
//                $query='';
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3  and type = 10");
//                if($query->num_rows()>0)
//                {
//                    if($query->row()->proje_muduru_status==3){
//                        return 1;
//                    }
//                    else if($query->row()->proje_muduru_status==4){
//                        return 1;
//                    }
//                    else if($query->row()->proje_muduru_status==1){
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//            if($querys->row()->genel_mudur_id==$user_id)
//            {
//
//                $query_='';
//
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and type = 10");
//
//                if($query_->num_rows()>0)
//                {
//                    if($query_->row()->genel_mudur_status==3){
//                        return 1;
//                    }
//                    else if($query_->row()->genel_mudur_status==4){
//                        return 1;
//                    }
//                    else if($query_->row()->genel_mudur_status==1){
//                        return 0;
//                    }
//                }
//                else
//                {
//                    return 1;
//                }
//
//
//
//
//
//            }
//        }
//        else {
//            return 1;
//        }
//    }
//    else if($invoice_status==2){
//        $querys=$ci->db->query("SELECT * FROM lojistik_talep WHERE id=$talep_id and (`lojistik_muduru`=$user_id  or `proje_muduru`=$user_id  or `genel_mudur`=$user_id) and status !=3 ");
//
//        if($querys->num_rows()>0 ){
//
//            if($querys->row()->lojistik_muduru==$user_id)
//            {
//
//                $query='';
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id  and type = 11");
//                if($query->num_rows()>0)
//                {
//                    if($query->row()->proje_sorumlusu_status==3){
//                        return 1;
//                    }
//                    else if($query->row()->proje_sorumlusu_status==4){
//                        return 1;
//                    }
//                    else if($query->row()->proje_sorumlusu_status==1){
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//            if($querys->row()->proje_muduru==$user_id)
//            {
//
//                $query='';
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3  and type = 11");
//                if($query->num_rows()>0)
//                {
//                    if($query->row()->proje_muduru_status==3){
//                        return 1;
//                    }
//                    else if($query->row()->proje_muduru_status==4){
//                        return 1;
//                    }
//                    else if($query->row()->proje_muduru_status==1){
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//            if($querys->row()->genel_mudur==$user_id)
//            {
//
//                $query_='';
//
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and type = 11");
//
//                if($query_->num_rows()>0)
//                {
//                    if($query_->row()->genel_mudur_status==3){
//                        return 1;
//                    }
//                    else if($query_->row()->genel_mudur_status==4){
//                        return 1;
//                    }
//                    else if($query_->row()->genel_mudur_status==1){
//                        return 0;
//                    }
//                }
//                else
//                {
//                    return 1;
//                }
//
//
//
//
//
//            }
//        }
//        else {
//            return 1;
//        }
//    }
//    else if($invoice_status==3){
//        $querys=$ci->db->query("SELECT * FROM lojistik_satinalma_talep WHERE id=$talep_id and (`lojistik_muduru`=$user_id  or `proje_muduru`=$user_id  or `genel_mudur`=$user_id) and status !=3 ");
//
//        if($querys->num_rows()>0 ){
//
//            if($querys->row()->lojistik_muduru==$user_id)
//            {
//
//                $query='';
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id  and type = 12");
//                if($query->num_rows()>0)
//                {
//                    if($query->row()->proje_sorumlusu_status==3){
//                        return 1;
//                    }
//                    else if($query->row()->proje_sorumlusu_status==4){
//                        return 1;
//                    }
//                    else if($query->row()->proje_sorumlusu_status==1){
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//            if($querys->row()->proje_muduru==$user_id)
//            {
//
//                $query='';
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3  and type = 12");
//                if($query->num_rows()>0)
//                {
//                    if($query->row()->proje_muduru_status==3){
//                        return 1;
//                    }
//                    else if($query->row()->proje_muduru_status==4){
//                        return 1;
//                    }
//                    else if($query->row()->proje_muduru_status==1){
//                        return 0;
//                    }
//
//                }
//                else
//                {
//                    return 1;
//                }
//            }
//            if($querys->row()->genel_mudur==$user_id)
//            {
//
//                $query_='';
//
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and type = 12");
//
//                if($query_->num_rows()>0)
//                {
//                    if($query_->row()->genel_mudur_status==3){
//                        return 1;
//                    }
//                    else if($query_->row()->genel_mudur_status==4){
//                        return 1;
//                    }
//                    else if($query_->row()->genel_mudur_status==1){
//                        return 0;
//                    }
//                }
//                else
//                {
//                    return 1;
//                }
//
//
//
//
//
//            }
//        }
//        else {
//            return 1;
//        }
//    }
//
//    else {
//    $querys = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and (`proje_sorumlusu_id`=$user_id or `proje_muduru_id`=$user_id or `bolum_mudur_id`=$user_id or `genel_mudur_id`=$user_id or `finans_departman_pers_id`=$user_id)");
//    if ($querys->num_rows() > 0) {
//        $tip = $querys->row()->tip;
//
//
//        if ($querys->row()->proje_sorumlusu_id == $user_id) {
//            $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//
//            if ($query->num_rows() > 0) {
//                foreach ($query->result() as $q) {
//                    if ($q->proje_sorumlusu_status == 3) {
//                        return 1;
//                    }
//                    if ($q->proje_sorumlusu_status == 4) {
//                        return 1;
//                    }
//                    if ($q->proje_sorumlusu_status == 2) {
//                        return 1;
//                    } else {
//                        return 0;
//
//                    }
//                }
//            } else {
//                return 1;
//            }
//        }
//        if ($querys->row()->proje_muduru_id == $user_id) {
//            $query = '';
//            if ($tip == 2) {
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//            } else {
//                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3 ");
//            }
//
//            if ($query->num_rows() > 0) {
//                $array = array();
//                foreach ($query->result() as $q) {
//
//                    $array[] = $q->proje_muduru_status;
//
//                }
//                if (in_array("3", $array)) // Onay
//                {
//                    return 1;
//                } else if (in_array("2", $array)) // Yorum
//                {
//                    return 1;
//                } else if (in_array("4", $array)) //iptal
//                {
//                    return 1;
//                } else {
//                    return 0;
//                }
//
//            } else {
//                return 1;
//            }
//        }
//        if ($querys->row()->genel_mudur_id == $user_id) {
//
//            $query_ = '';
//            if ($tip == 2) {
//
//
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//                if ($query_->num_rows() > 0) {
//                    $array = array();
//                    $array_proje = array();
//                    foreach ($query_->result() as $q) {
//
//                        $array[] = $q->genel_mudur_status;
//                        $array_proje[] = $q->proje_muduru_status;
//
//                    }
//                    if (in_array('3', $array)) // Onay
//                    {
//                        return 1;
//                    } else if (in_array('2', $array)) // Yorum
//                    {
//                        return 1;
//                    } else if (in_array('4', $array)) //iptal
//                    {
//                        return 1;
//                    }
////                    else if(in_array('1',$array_proje))
////                    {
////                        return 1;
////                    }
//                    else if (in_array('3', $array_proje)) {
//                        if (in_array('1', $array)) //iptal
//                        {
//                            return 0;
//                        }
//
//                    } else if (in_array('1', $array_proje)) {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//
//
//                } else {
//                    return 1;
//                }
//
//            } else {
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and proje_sorumlusu_status=3  and bolum_muduru_status=3");
//
//                if ($query_->num_rows() > 0) {
//                    $array = array();
//                    foreach ($query_->result() as $q) {
//
//                        $array[] = $q->genel_mudur_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 1;
//                    } else if (in_array("2", $array)) // Yorum
//                    {
//                        return 1;
//                    } else if (in_array("4", $array)) //iptal
//                    {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//
//                } else {
//                    return 1;
//                }
//            }
//
//
//        }
//        if ($querys->row()->finans_departman_pers_id == $user_id) {
//            $query_ = '';
//            if ($tip == 2) {
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");
//            } else {
//                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");
//            }
//
//            if ($query_->num_rows() > 0) {
//                $array = array();
//                foreach ($query_->result() as $q) {
//
//                    $array[] = $q->finans_status;
//
//                }
//                if (in_array("3", $array)) // Onay
//                {
//                    return 1;
//                } else if (in_array("2", $array)) // Yorum
//                {
//                    return 1;
//                } else if (in_array("4", $array)) //iptal
//                {
//                    return 1;
//                } else {
//                    return 0;
//                }
//            } else {
//                return 1;
//            }
//
//
//        }
//
//        if ($tip != 2) {
//            if ($querys->row()->bolum_mudur_id == $user_id) // Depo Müdürü
//            {
//                $query_ = '';
//                if ($tip == 2) {
//                    $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
//                } else {
//                    $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 ");
//                }
//                if ($query_->num_rows() > 0) {
//                    $array = array();
//                    foreach ($query_->result() as $q) {
//
//                        $array[] = $q->bolum_muduru_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 1;
//                    } else if (in_array("2", $array)) // Yorum
//                    {
//                        return 1;
//                    } else if (in_array("4", $array)) //iptal
//                    {
//                        return 1;
//                    } else {
//                        return 0;
//                    }
//
//                } else {
//                    return 1;
//                }
//            }
//
//
//        }
//
//        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE satinalma_yonlendirme=$user_id");
//        if ($query_->num_rows() > 0) {
//            $array = array();
//            foreach ($query_->result() as $q) {
//
//                $array[] = $q->genel_mudur_status;
//
//            }
//            if (in_array("3", $array)) // Onay
//            {
//                return 0;
//            } else if (in_array("2", $array)) // Yorum
//            {
//                return 0;
//            } else if (in_array("4", $array)) //iptal
//            {
//                return 0;
//            } else {
//                return 1;
//            }
//
//        } else {
//            return 1;
//        }
//
//    } else {
//
//        $sf_kontrol = $ci->db->query("SELECT * FROM geopos_talep WHERE hazirlayan_pers_id=$user_id and malzeme_talep_form_id=$talep_id");
//        $sf_kontrol2 = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id")->row();
//        if ($sf_kontrol->num_rows() > 0) {
//            return 1;
//        }
//
//        if ($sf_kontrol2->malzeme_talep_durumu == 1) {
//            return 1;
//        } else {
//            $queryKs = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and hazirlayan_pers_id=$user_id"); //64 //3
//            $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE  type=1 and satinalma_status=1 and file_id=$talep_id and satinalma_yonlendirme=$user_id");
//
//            if ($query_->num_rows() > 0) {
//                $array = array();
//                foreach ($query_->result() as $q) {
//
//                    $array[] = $q->genel_mudur_status;
//
//                }
//                if (in_array("3", $array)) // Onay
//                {
//                    return 0;
//                } else if (in_array("2", $array)) // Yorum
//                {
//                    return 0;
//                } else if (in_array("4", $array)) //iptal
//                {
//                    return 0;
//                } else {
//                    return 1;
//                }
//
//            } else if ($queryKs->num_rows() > 0) {
//                $queryK = $ci->db->query("SELECT * FROM geopos_onay WHERE satinalma_status=1 and file_id=$talep_id");
//                if ($queryK->num_rows() > 0) {
//                    $array = array();
//                    foreach ($queryK->result() as $q) {
//
//                        $array[] = $q->genel_mudur_status;
//
//                    }
//
//                    foreach ($queryK->result() as $q) {
//
//                        $array[] = $q->proje_muduru_status;
//
//                    }
//                    if (in_array("3", $array)) // Onay
//                    {
//                        return 0;
//                    } else if (in_array("2", $array)) // Yorum
//                    {
//                        return 0;
//                    } else if (in_array("4", $array)) //iptal
//                    {
//                        return 0;
//                    } else {
//                        return 0;
//                    }
//                } else {
//                    return 1;
//                }
//
//            } else {
//                return 1;
//            }
//        }
//
//    }
//    }
//
//}

function satinalma_onay($talep_id,$role_id,$user_id,$invoice_status=0)
{

    $ci =& get_instance();
    if($invoice_status==1){
        $querys=$ci->db->query("SELECT * FROM geopos_invoices WHERE id=$talep_id and (`proje_sorumlu_id`=$user_id  or `proje_muduru_id`=$user_id  or `genel_mudur_id`=$user_id) and status !=3 ");

        if($querys->num_rows()>0 ){

            if($querys->row()->proje_sorumlu_id==$user_id)
            {

                $query='';
                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id  and type = 10");
                if($query->num_rows()>0)
                {
                    if($query->row()->proje_sorumlusu_status==3){
                        return 1;
                    }
                    else if($query->row()->proje_sorumlusu_status==4){
                        return 1;
                    }
                    else if($query->row()->proje_sorumlusu_status==1){
                        return 0;
                    }

                }
                else
                {
                    return 1;
                }
            }
            if($querys->row()->proje_muduru_id==$user_id)
            {

                $query='';
                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3  and type = 10");
                if($query->num_rows()>0)
                {
                    if($query->row()->proje_muduru_status==3){
                        return 1;
                    }
                    else if($query->row()->proje_muduru_status==4){
                        return 1;
                    }
                    else if($query->row()->proje_muduru_status==1){
                        return 0;
                    }

                }
                else
                {
                    return 1;
                }
            }
            if($querys->row()->genel_mudur_id==$user_id)
            {

                $query_='';

                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and type = 10");

                if($query_->num_rows()>0)
                {
                    if($query_->row()->genel_mudur_status==3){
                        return 1;
                    }
                    else if($query_->row()->genel_mudur_status==4){
                        return 1;
                    }
                    else if($query_->row()->genel_mudur_status==1){
                        return 0;
                    }
                }
                else
                {
                    return 1;
                }





            }
        }
        else {
            return 1;
        }
    }
    else if($invoice_status==2){
        $querys=$ci->db->query("SELECT * FROM lojistik_talep WHERE id=$talep_id and (`lojistik_muduru`=$user_id  or `proje_muduru`=$user_id  or `genel_mudur`=$user_id) and status !=3 ");

        if($querys->num_rows()>0 ){

            if($querys->row()->lojistik_muduru==$user_id)
            {

                $query='';
                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id  and type = 11");
                if($query->num_rows()>0)
                {
                    if($query->row()->proje_sorumlusu_status==3){
                        return 1;
                    }
                    else if($query->row()->proje_sorumlusu_status==4){
                        return 1;
                    }
                    else if($query->row()->proje_sorumlusu_status==1){
                        return 0;
                    }

                }
                else
                {
                    return 1;
                }
            }
            if($querys->row()->proje_muduru==$user_id)
            {

                $query='';
                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3  and type = 11");
                if($query->num_rows()>0)
                {
                    if($query->row()->proje_muduru_status==3){
                        return 1;
                    }
                    else if($query->row()->proje_muduru_status==4){
                        return 1;
                    }
                    else if($query->row()->proje_muduru_status==1){
                        return 0;
                    }

                }
                else
                {
                    return 1;
                }
            }
            if($querys->row()->genel_mudur==$user_id)
            {

                $query_='';

                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and type = 11");

                if($query_->num_rows()>0)
                {
                    if($query_->row()->genel_mudur_status==3){
                        return 1;
                    }
                    else if($query_->row()->genel_mudur_status==4){
                        return 1;
                    }
                    else if($query_->row()->genel_mudur_status==1){
                        return 0;
                    }
                }
                else
                {
                    return 1;
                }





            }
        }
        else {
            return 1;
        }
    }
    else if($invoice_status==3){
        $querys=$ci->db->query("SELECT * FROM lojistik_satinalma_talep WHERE id=$talep_id and (`lojistik_muduru`=$user_id  or `proje_muduru`=$user_id  or `genel_mudur`=$user_id) and status !=3 ");

        if($querys->num_rows()>0 ){

            if($querys->row()->lojistik_muduru==$user_id)
            {

                $query='';
                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id  and type = 12");
                if($query->num_rows()>0)
                {
                    if($query->row()->proje_sorumlusu_status==3){
                        return 1;
                    }
                    else if($query->row()->proje_sorumlusu_status==4){
                        return 1;
                    }
                    else if($query->row()->proje_sorumlusu_status==1){
                        return 0;
                    }

                }
                else
                {
                    return 1;
                }
            }
            if($querys->row()->proje_muduru==$user_id)
            {

                $query='';
                $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3  and type = 12");
                if($query->num_rows()>0)
                {
                    if($query->row()->proje_muduru_status==3){
                        return 1;
                    }
                    else if($query->row()->proje_muduru_status==4){
                        return 1;
                    }
                    else if($query->row()->proje_muduru_status==1){
                        return 0;
                    }

                }
                else
                {
                    return 1;
                }
            }
            if($querys->row()->genel_mudur==$user_id)
            {

                $query_='';

                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and type = 12");

                if($query_->num_rows()>0)
                {
                    if($query_->row()->genel_mudur_status==3){
                        return 1;
                    }
                    else if($query_->row()->genel_mudur_status==4){
                        return 1;
                    }
                    else if($query_->row()->genel_mudur_status==1){
                        return 0;
                    }
                }
                else
                {
                    return 1;
                }





            }
        }
        else {
            return 1;
        }
    }

    else {
        $querys = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and (`proje_sorumlusu_id`=$user_id or `proje_muduru_id`=$user_id or `bolum_mudur_id`=$user_id or `genel_mudur_id`=$user_id or `finans_departman_pers_id`=$user_id)");
        if ($querys->num_rows() > 0) {
            $tip = $querys->row()->tip;
            if($tip==2){
                if ($querys->row()->proje_muduru_id == $user_id) {

                    $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");

                    if ($query->num_rows() > 0) {
                        $array = array();
                        foreach ($query->result() as $q) {

                            $array[] = $q->proje_muduru_status;

                        }
                        if (in_array("3", $array)) // Onay
                        {
                            return 1;
                        } else if (in_array("2", $array)) // Yorum
                        {
                            return 1;
                        } else if (in_array("4", $array)) //iptal
                        {
                            return 1;
                        } else {
                            return 0;
                        }

                    } else {
                        return 1;
                    }
                }
                elseif ($querys->row()->genel_mudur_id == $user_id) {


                    $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
                    if ($query_->num_rows() > 0) {
                        $array = array();
                        $array_proje = array();
                        foreach ($query_->result() as $q) {

                            $array[] = $q->genel_mudur_status;
                            $array_proje[] = $q->proje_muduru_status;

                        }
                        if (in_array('3', $array)) // Onay
                        {
                            return 1;
                        } else if (in_array('2', $array)) // Yorum
                        {
                            return 1;
                        } else if (in_array('4', $array)) //iptal
                        {
                            return 1;
                        }
//                    else if(in_array('1',$array_proje))
//                    {
//                        return 1;
//                    }
                        else if (in_array('3', $array_proje)) {
                            if (in_array('1', $array)) //iptal
                            {
                                return 0;
                            }

                        } else if (in_array('1', $array_proje)) {
                            return 1;
                        } else {
                            return 0;
                        }


                    } else {
                        return 1;
                    }


                }
                elseif ($querys->row()->finans_departman_pers_id == $user_id) {
                    $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");

                    if ($query_->num_rows() > 0) {
                        $array = array();
                        foreach ($query_->result() as $q) {

                            $array[] = $q->finans_status;

                        }
                        if (in_array("3", $array)) // Onay
                        {
                            return 1;
                        } else if (in_array("2", $array)) // Yorum
                        {
                            return 1;
                        } else if (in_array("4", $array)) //iptal
                        {
                            return 1;
                        } else {
                            return 0;
                        }
                    } else {
                        return 1;
                    }


                }
                else {
                    return 1;
                }
            }
            else {
                if ($querys->row()->proje_sorumlusu_id == $user_id) {
                    $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");

                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $q) {
                            if ($q->proje_sorumlusu_status == 3) {
                                return 1;
                            }
                            if ($q->proje_sorumlusu_status == 4) {
                                return 1;
                            }
                            if ($q->proje_sorumlusu_status == 2) {
                                return 1;
                            } else {
                                return 0;

                            }
                        }
                    } else {
                        return 1;
                    }
                }
                if ($querys->row()->bolum_mudur_id == $user_id) // Depo Müdürü
                {
                    $query_ = '';
                    if ($tip == 2) {
                        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
                    } else {
                        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 ");
                    }
                    if ($query_->num_rows() > 0) {
                        $array = array();
                        foreach ($query_->result() as $q) {

                            $array[] = $q->bolum_muduru_status;

                        }
                        if (in_array("3", $array)) // Onay
                        {
                            return 1;
                        } else if (in_array("2", $array)) // Yorum
                        {
                            return 1;
                        } else if (in_array("4", $array)) //iptal
                        {
                            return 1;
                        } else {
                            return 0;
                        }

                    } else {
                        return 1;
                    }
                }
                if ($querys->row()->proje_muduru_id == $user_id) {
                    $query = '';
                    if ($tip == 2) {
                        $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
                    } else {
                        $query = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_sorumlusu_status=3 ");
                    }

                    if ($query->num_rows() > 0) {
                        $array = array();
                        foreach ($query->result() as $q) {

                            $array[] = $q->proje_muduru_status;

                        }
                        if (in_array("3", $array)) // Onay
                        {
                            return 1;
                        } else if (in_array("2", $array)) // Yorum
                        {
                            return 1;
                        } else if (in_array("4", $array)) //iptal
                        {
                            return 1;
                        } else {
                            return 0;
                        }

                    } else {
                        return 1;
                    }
                }
                if ($querys->row()->genel_mudur_id == $user_id) {

                    $query_ = '';
                    if ($tip == 2) {


                        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id");
                        if ($query_->num_rows() > 0) {
                            $array = array();
                            $array_proje = array();
                            foreach ($query_->result() as $q) {

                                $array[] = $q->genel_mudur_status;
                                $array_proje[] = $q->proje_muduru_status;

                            }
                            if (in_array('3', $array)) // Onay
                            {
                                return 1;
                            } else if (in_array('2', $array)) // Yorum
                            {
                                return 1;
                            } else if (in_array('4', $array)) //iptal
                            {
                                return 1;
                            }
//                    else if(in_array('1',$array_proje))
//                    {
//                        return 1;
//                    }
                            else if (in_array('3', $array_proje)) {
                                if (in_array('1', $array)) //iptal
                                {
                                    return 0;
                                }

                            } else if (in_array('1', $array_proje)) {
                                return 1;
                            } else {
                                return 0;
                            }


                        } else {
                            return 1;
                        }

                    } else {
                        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and proje_muduru_status=3 and proje_sorumlusu_status=3  and bolum_muduru_status=3");

                        if ($query_->num_rows() > 0) {
                            $array = array();
                            foreach ($query_->result() as $q) {

                                $array[] = $q->genel_mudur_status;

                            }
                            if (in_array("3", $array)) // Onay
                            {
                                return 1;
                            } else if (in_array("2", $array)) // Yorum
                            {
                                return 1;
                            } else if (in_array("4", $array)) //iptal
                            {
                                return 1;
                            } else {
                                return 0;
                            }

                        } else {
                            return 1;
                        }
                    }


                }
                if ($querys->row()->finans_departman_pers_id == $user_id) {
                    $query_ = '';
                    if ($tip == 2) {
                        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");
                    } else {
                        $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE file_id=$talep_id and genel_mudur_status=3 ");
                    }

                    if ($query_->num_rows() > 0) {
                        $array = array();
                        foreach ($query_->result() as $q) {

                            $array[] = $q->finans_status;

                        }
                        if (in_array("3", $array)) // Onay
                        {
                            return 1;
                        } else if (in_array("2", $array)) // Yorum
                        {
                            return 1;
                        } else if (in_array("4", $array)) //iptal
                        {
                            return 1;
                        } else {
                            return 0;
                        }
                    } else {
                        return 1;
                    }


                }
            }



            $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE satinalma_yonlendirme=$user_id");
            if ($query_->num_rows() > 0) {
                $array = array();
                foreach ($query_->result() as $q) {

                    $array[] = $q->genel_mudur_status;

                }
                if (in_array("3", $array)) // Onay
                {
                    return 0;
                } else if (in_array("2", $array)) // Yorum
                {
                    return 0;
                } else if (in_array("4", $array)) //iptal
                {
                    return 0;
                } else {
                    return 1;
                }

            } else {
                return 1;
            }

        } else {

            $sf_kontrol = $ci->db->query("SELECT * FROM geopos_talep WHERE hazirlayan_pers_id=$user_id and malzeme_talep_form_id=$talep_id");
            $sf_kontrol2 = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id")->row();
            if ($sf_kontrol->num_rows() > 0) {
                return 1;
            }

            if ($sf_kontrol2->malzeme_talep_durumu == 1) {
                return 1;
            } else {
                $queryKs = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id and hazirlayan_pers_id=$user_id"); //64 //3
                $query_ = $ci->db->query("SELECT * FROM geopos_onay WHERE  type=1 and satinalma_status=1 and file_id=$talep_id and satinalma_yonlendirme=$user_id");

                if ($query_->num_rows() > 0) {
                    $array = array();
                    foreach ($query_->result() as $q) {

                        $array[] = $q->genel_mudur_status;

                    }
                    if (in_array("3", $array)) // Onay
                    {
                        return 0;
                    } else if (in_array("2", $array)) // Yorum
                    {
                        return 0;
                    } else if (in_array("4", $array)) //iptal
                    {
                        return 0;
                    } else {
                        return 1;
                    }

                } else if ($queryKs->num_rows() > 0) {
                    $queryK = $ci->db->query("SELECT * FROM geopos_onay WHERE satinalma_status=1 and file_id=$talep_id");
                    if ($queryK->num_rows() > 0) {
                        $array = array();
                        foreach ($queryK->result() as $q) {

                            $array[] = $q->genel_mudur_status;

                        }

                        foreach ($queryK->result() as $q) {

                            $array[] = $q->proje_muduru_status;

                        }
                        if (in_array("3", $array)) // Onay
                        {
                            return 0;
                        } else if (in_array("2", $array)) // Yorum
                        {
                            return 0;
                        } else if (in_array("4", $array)) //iptal
                        {
                            return 0;
                        } else {
                            return 0;
                        }
                    } else {
                        return 1;
                    }

                } else {
                    return 1;
                }
            }

        }
    }

}
function alt_file_id_geti($talep_item_id,$talep_id,$firma)
{

    $ci =& get_instance();

    if(isset($firma))
    {
        $query = $ci->db->query("SELECT *  FROM geopos_item_alt WHERE talep_id=$talep_id and talep_id_item=$talep_item_id and firma='$firma' ")->row_array();

        return $query['id'];
    }
    else
    {
        return 0;
    }



}


function amountFormat($number,$para_birimi = 0)
{

    $ci =& get_instance();

    if($para_birimi==0)
    {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];

        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country

        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }
    else
    {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id=$para_birimi LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];

        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country

        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }



}

function hesap_types()
{
    $type='3,4,12,14,17,18,19,20,25,27,28,33,43,44,46,46,47,48';
    return $type;
}


function hesap_types_array()
{
    $type=array(3,4,12,14,17,18,19,20,25,27,28,33,43,44,45,46,47,48,49,50,51,52,59,60,61,68,55,54,57,61,65);
    return $type;
}

function new_balace($id){
    date_default_timezone_set('Asia/Baku');

    $date = new DateTime();
    $date = $date->format('Y-m-d').' 00:00:00';

    $ci =& get_instance();

    $query = $ci->db->query('SELECT invoice_type_id, SUM(IF(invoice_type_id IN (3,18,20,25,27,51,50,60,44,70),total,0)) as borc,SUM(IF(invoice_type_id IN (4,12,14,17,19,28,33,35,36,37,38,39,40,41,42,45,46,47,48,49,52,59,43,61,68),total,0)) as alacak From geopos_invoices Where geopos_invoices.acid = '.$id)->row();

    $bakiye = floatval($query->alacak)-floatval($query->borc);
    $style='';
    if($bakiye > 0){
        $style='background:#bc0404;color:white';
    }
    return
        [
            'bakiye'=>abs($bakiye),
            'style'=>$style
        ];

}

function hesap_balance($id)
{
    $bakiye=0;

    $ci =& get_instance();
    $type=hesap_types();
    $query = $ci->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices LEFT JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id WHERE geopos_invoices.acid=$id and  geopos_invoices.invoice_type_id
 IN($type )

  ");
    $row = $query->result_array();
    foreach ($row as $rows)
    {
        $bakiye+=($rows['alacak']*$rows['kur_degeri'])-($rows['borc']*$rows['kur_degeri']);
    }
    return $bakiye;
}


function prefix($number)
{
    $ci =& get_instance();

    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=51 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    switch ($number){
        case 1: return $row['name'];
            break;
        case 2: return $row['key1'];
            break;
        case 3: return $row['key2'];
            break;
        case 4: return $row['url'];
            break;
        case 5: return $row['method'];
            break;
        case 6: return $row['other'];
            break;
    }
}
function user_premission($input1, $input2)
{
    if (hash_equals($input1, $input2)) {
        return true;
    } else {
        return false;
    }
}

function active($input1)
{

    $t_file = APPPATH . "/config/lic.php";
    if ($t_file) {
        file_put_contents($t_file, $input1);
        if ($input1 == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'License error!'));
        } else {
            echo json_encode(array('status' => 'Success', 'message' => 'License updated!'));
        }
    } else {

        echo json_encode(array('status' => 'Error', 'message' => 'Server write premissions denied'));

    }

}

function amountFormat_s($number)
{
    $ci =& get_instance();
    $ci->load->database();

    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    if ($row['method'] == 'l') {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']);
    }

}
function amountFormat_proje($number)
{
    $ci =& get_instance();
    $ci->load->database();

    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    if ($row['method'] == 'l') {
        return @number_format($number, 3, $row['key1'], $row['key2']);
    } else {
        return @number_format($number, 3, $row['key1'], $row['key2']);
    }

}
function amountFormat_se($number)
{
    $ci =& get_instance();
    $ci->load->database();

    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country

    if ($row['method'] == 'l') {
        return @number_format($number, $row['url'], $row['key1'],'');
    } else {
        return @number_format($number, $row['url'], $row['key1'],'');
    }

}

function loc_para_birimi($loc)
{
    $ci =& get_instance();
    $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
    $row = $query->row_array();
    return $row['cur'];
}
function alis_faturalari()
{
    $ci =& get_instance();
    $loc =   $ci->session->userdata('set_firma_id');
    $query = $ci->db->query("SELECT geopos_customers.company as firma_adi,geopos_invoices.id,geopos_invoices.invoice_no,geopos_invoices.total FROM `geopos_invoices`  INNER JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id WHERE geopos_invoices.loc=$loc and geopos_invoices.invoice_type_id = 2 ");
    $row = $query->result();
    return $row;
}


function amountExchange($number, $id = 0,$loc=0)
{
    $ci =& get_instance();

    $ci->load->database();
    if($loc>0 && $id == 0){
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
        $rate = $row['rate'];
        $thosand = $row['thous'];
        $dec_point = $row['dpoint'];
        $decimal_after = $row['decim'];

        $totalamount =  $number;

        //get data from database

        //Format money as per country

        if ($row['cpos'] == 0) {
            return $currency . ' ' . @number_format($totalamount, $decimal_after, $dec_point, $thosand);
        } else {
            return @number_format($totalamount, $decimal_after, $dec_point, $thosand) . ' ' . $currency;
        }
    } else {

        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];

        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country

        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }

}

function rev_amountExchange($number, $id = 0)
{
    $ci =& get_instance();

    $query = $ci->db->query("SELECT other FROM univarsal_api WHERE id='5' LIMIT 1");
    $row = $query->row_array();
    $reverse = $row['other'];

    if($reverse && $id>0) {

        $query = $ci->db->query("SELECT rate FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();

        $rate = $row['rate'];

        $totalamount = $number/$rate;

        return $totalamount;

    }
    else{
        return $number;
    }

}


function array_compare() {
    $criteriaNames = func_get_args();
    $compare = function($first, $second) use ($criteriaNames) {
        while(!empty($criteriaNames)) {
            $criterion = array_shift($criteriaNames);
            $sortOrder = 1;
            if (is_array($criterion)) {
                $sortOrder = $criterion[1] == SORT_DESC ? -1 : 1;
                $criterion = $criterion[0];
            }
            if ($first[$criterion] < $second[$criterion]) {
                return -1 * $sortOrder;
            }
            else if ($first[$criterion] > $second[$criterion]) {
                return 1 * $sortOrder;
            }

        }

        return 0;
    };

    return $compare;
}

function locations()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_locations");
    return $query2->result_array();

}
function location($number=0)
{
    $ci =& get_instance();
    $ci->load->database();

    if ($number > 0) {
        $query2 = $ci->db->query("SELECT * FROM geopos_locations WHERE id=$number");
        return $query2->row_array();
    } else {
        $query2 = $ci->db->query("SELECT cname,address,city,region,country,postbox,phone,email,taxid,logo FROM geopos_system WHERE id=1 LIMIT 1");
        return $query2->row_array();
    }

}

function currency($loc=0,$id = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    $currency='';

    if($loc>0 && $id == 0){
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
        if ($id > 0) {
            $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
            $row = $query->row_array();
            $currency = $row['symbol'];

        }
    }



    elseif($loc>0 && $id >0){
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
    }

    else {

        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];

    }

    return $currency;


}

function para_birimi_ogren($str)
{
    $ci =& get_instance();
    $ci->load->database();
    $currency='tumu';



    $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE code='$str' LIMIT 1");
    if($query->num_rows()>0)
    {
        $row = $query->row_array();
        $currency = $row['id'];
    }






    return $currency;

}
function geopos_currencies_details($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $currency='tumu';



    $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id=$id");
    if($query->num_rows()>0)
    {
        $row = $query->row();
      return $row;
    }
    else {
        return  false;
    }



}
function para_birimi_ogren_id($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $currency=1;



    $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id=$id LIMIT 1");
    if($query)
    {
        $row = $query->row_array();
        $currency = $row['code'];
    }






    return $currency;

}

function plugins_checker(){
    $path=FCPATH . 'application/plugins';

    $plugins=array_diff(scandir($path), array('.', '..'));
    foreach ($plugins as $row){

        $url=file_get_contents($path.'/'.$row);
        $plug=json_decode($url, true);
        echo  '<li>
                            <a href="'.base_url().$plug['path'].'">'.$plug['name'].'</a>
                        </li>';

    }
}



function invoice_type_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE id=$id");
    $res=$query2->row_array();

    return $res['description'];
}
function personel_alacak_borc()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE id in (26,34,53)");
    $res=$query2->result();

    return $res;
}
function cari_alacak_borc()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE id in (39,40)");
    $res=$query2->result();

    return $res;
}

function invoice_type()
{
    $ci =& get_instance();
    $ci->load->database();

    if ($ci->aauth->premission(92)->read) {
        $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE type_value IN ('fatura','fatura_')");
        return $query2->result_array();
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE type_value='fatura'");
        return $query2->result_array();
    }

}
function invoice_type_where($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE id=$id ");
    return $query2->row();

}
function kodu_getir()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM kode LIMIT 1");
    $q = $query2->row_array();
    return $q['kode'];

}
function forma2_invoice_type()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE meta=4");
    return $query2->result();

}

function product_type()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_product_type ");
    return $query2->result_array();



}
function product_detail($id)
{
    $ci =& get_instance();
    $ci->load->database();
    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_products where pid=$id");
        $data=$query2->row_array();
        $type_id=$data['product_type'];
        $cat_id=$data['pcat'];
        $warehouse_id=$data['warehouse'];


        if(isset($type_id))
        {
            $type= $ci->db->query("SELECT * FROM geopos_product_type where id=$type_id");
            $data2=$type->row_array();

            $cat_name= $ci->db->query("SELECT * FROM geopos_product_cat where id=$cat_id");
            $data3=$cat_name->row_array();


            $warehouse_name= $ci->db->query("SELECT * FROM geopos_warehouse where id=$warehouse_id");
            $data4=$warehouse_name->row_array();


            return array('product_detail'=>$data,'type_name'=>$data2['name'],'cat_name'=>$data3['title'],'warehouse_name'=>$data4['title']);

        }
        else
        {
            return array('product_detail'=>'','type_name'=>'','cat_name'=>'','warehouse_name'=>'');

        }
    }
    else
    {
        return array('product_detail'=>array(),'type_name'=>'','cat_name'=>'','warehouse_name'=>'');
    }



}
function product_detail_cost($id,$invoice_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_items where tid=$invoice_id and pid=$id");
    $data=$query2->row_array();



    return $data['product'];


}


function transaction_type()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE (type_value='transaction' or type_value='devir') and  meta=1");
    return $query2->result_array();

}

function randevu_personelleri($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_events_pers WHERE event_id=$id");
    if($query2->num_rows()>0)
    {
        $pers_='';
        if($query2->num_rows()==1)
        {
            $pers_=personel_details($query2->row()->pers_id);
        }
        foreach ($query2->result() as $pers)
        {
            $pers_.=personel_details($pers->pers_id).' | ';
        }

        return $pers_;
    }
    else
    {
        return 'Personel Dahil Edilmemiş';
    }


}
function randevu_personelleri_list($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $array=array();
    $query2 = $ci->db->query("SELECT * FROM geopos_events_pers WHERE event_id=$id");
    if($query2->num_rows()>0)
    {
        foreach ($query2->result() as $pers)
        {
            $array[]=$pers->pers_id;
        }
    }

    return $array;


}
function transaction_type_kdv()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type WHERE id IN(19,20) and  meta=1");
    return $query2->result_array();

}

function invoice_type_id($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT description FROM geopos_invoice_type WHERE id=$id");
    $row = $query2->row_array();
    $description = $row['description'];
    return $description;

}


function cari_in_invoice($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_transactions WHERE transaction_id=$id");
    $row = $query2->row();
    return $row;

}




function product_name($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_products WHERE pid=$id");
    if($query2->num_rows()){
        $row = $query2->row();
        $product_name = $row->product_name;
        return $product_name;
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$id");
        $row = $query2->row();
        $product_name = $row->name;
        return $product_name;
    }



}
function product_full_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    return $row;


}
function arac_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if(intval($id)){
        $query2 = $ci->db->query("SELECT * FROM araclar WHERE id=$id");
        $row = $query2->row();
        return $row;
    }
    else {
        return false;
    }
}
function arac_talep_form_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM arac_form WHERE id=$id");
    $row = $query2->row();
    return $row;


}
function arac_talep_kontrol($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM arac_suruculeri WHERE arac_id = $id and status=2 and talep_id!=0");
    if($query2->num_rows()){
        $row = $query2->row();
        $talep_details = $ci->db->query("SELECT * FROM arac_form WHERE id = $row->talep_id");
        return  $talep_details->row();
    }
    else {
        return false;
    }


}

function product_desc($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT product_des FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    $product_name = $row['product_des'];
    return $product_name;


}
function role_id_pers_id()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT id FROM `geopos_users` WHERE roleid=2 or roleid=4 LIMIT 1");
    $row = $query2->row_array();
    $id = $row['id'];
    return $id;
}

function personel_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $name='';
    if($id!=0)
    {
        $query2 = $ci->db->query("SELECT name FROM `geopos_employees` WHERE id=$id");
        if($query2->num_rows()>0){
            $row = $query2->row_array();
            $name = $row['name'];
        }else {
            $name='Firma';
        }

    }
    else
    {
        $name='Firma';
    }


    return $name;
}

function pesonel_picture_url($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_users` WHERE id=$id")->row_array();
    return $query2['picture'];
}

function pesonelp_picture_url($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_users_p` WHERE id=$id")->row_array();
    return $query2['picture'];
}
function sender_id($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_pms` WHERE id=$id")->row_array();
    return $query2['sender_id'];
}
function gelen_mesaj_header($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_pms.*,geopos_pms.id AS pid,geopos_employees.* FROM `geopos_pms`  LEFT JOIN geopos_employees ON geopos_employees.id = geopos_pms.sender_id  WHERE geopos_pms.receiver_id=$id")->result();
    return $query2;
}
function gelen_mesajlarim($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_pms.*,geopos_pms.id AS pid,geopos_employees.*  FROM `geopos_pms` LEFT JOIN geopos_employees ON geopos_employees.id = geopos_pms.sender_id WHERE (geopos_pms.receiver_id=$id or geopos_pms.sender_id=$id) GROUP BY geopos_pms.receiver_id,geopos_pms.sender_id")->result();
    return $query2;
}
function gelen_mesajlarim_pers($id,$gelen_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_pms.*,geopos_pms.id AS pid,geopos_employees.*  FROM `geopos_pms` LEFT JOIN
 geopos_employees ON geopos_employees.id = geopos_pms.sender_id WHERE

  (geopos_pms.receiver_id=$id and geopos_pms.sender_id=$gelen_id) or (geopos_pms.receiver_id=$gelen_id and geopos_pms.sender_id=$id)  ORDER BY geopos_pms.id DESC")->result();
    return $query2;
}

function array_recursive_search_key_map($needle, $haystack) {
    foreach($haystack as $first_level_key=>$value) {
        if ($needle === $value) {
            return array($first_level_key);
        } elseif (is_array($value)) {
            $callback = array_recursive_search_key_map($needle, $value);
            if ($callback) {
                return array_merge(array($first_level_key), $callback);
            }
        }
    }
    return false;
}
function invoice_details_hizmet($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_invoices` WHERE tid=$id");
    $row = $query2->row();


    return $row;
}
function invoice_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_invoices` WHERE id=$id");
    $row = $query2->row();


    return $row;
}

function personel_list()
{
    $ci =& get_instance();
    $ci->load->database();


    $loc = $ci->session->userdata('set_firma_id');


    $query2 = $ci->db->query("SELECT geopos_employees.* FROM `geopos_employees` Inner JOIN geopos_users On geopos_users.id = geopos_employees.id Where geopos_users.banned = 0  and geopos_employees.loc=$loc ORDER BY geopos_employees.id ASC");
    $row = $query2->result_array();


    return $row;
}
function personel_list_dep_id($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_employees.* FROM `geopos_employees` Inner JOIN geopos_users On geopos_users.id = geopos_employees.id  WHERE (geopos_employees.dept=$id or geopos_employees.dept=114 or geopos_employees.dept=111) and geopos_users.banned = 0  ORDER BY geopos_employees.id ASC");
    $row = $query2->result_array();
    return $row;
}

function controller_users()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_controller_users.*,geopos_employees.name From geopos_controller_users INNER JOIN geopos_employees ON geopos_employees.id = geopos_controller_users.user_id ");
    $row = $query2->result();
    return $row;
}



function izin_yetkilisi_pers($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_system` WHERE izin_yetkili_pers_id=$id and id=1");
    $row = $query2->num_rows();

    if($row>0)
    {
        return true;
    }
    else
    {
        return false;
    }
}


function personel_detailsa($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_employees.*,geopos_users.banned,geopos_users.email,geopos_users.loc,geopos_users.roleid,geopos_users.date_created FROM `geopos_employees`
  INNER JOIN geopos_users ON geopos_employees.id = geopos_users.id
 WHERE geopos_employees.id=$id");
    $row = $query2->row_array();
    return $row;
}
function izin_yetkili_pers_id()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_system` WHERE id=1");
    $row = $query2->row_array();
    return $row['izin_yetkili_pers_id'];
}
function izin_yetkili_genel_mudur_id()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_system` WHERE id=1");
    $row = $query2->row_array();
    return $row['genel_mudur_id'];
}
function finans_yetkili_id()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_system` WHERE id=1");
    $row = $query2->row_array();
    return $row['finans_id'];
}
function lojistik_yetkili_id()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_system` WHERE id=1");
    $row = $query2->row_array();
    return $row['lojistik_sorumlusu'];
}

function komisyon_orani($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id!=0)
    {
        $query2 = $ci->db->query("SELECT c_rate FROM `geopos_employees` WHERE id=$id");
        $row = $query2->row_array();
        $name = $row['c_rate'];
    }
    else
    {
        $name=0;
    }


    return $name;
}

function sadece_tarih($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat').' d.m.Y');
    return $date;
}


function personel_details_full($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id!=0)
    {
        $query2 = $ci->db->query("SELECT geopos_employees.*,geopos_users.roleid,geopos_users.picture FROM `geopos_employees` INNER JOIN geopos_users ON geopos_employees.id=geopos_users.id WHERE geopos_employees.id=$id");
        $row = $query2->row_array();

    }
    else
    {
        $row=array('name'=>'Firma');
    }


    return $row;
}

function pers_detay_rapor($tip,$pers_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $date = new DateTime('now');
    $date->modify('last day of this month');
    $hesaplanacak_ay=$date->format('m');
    $date_y=$date->format('Y');
    $guns_=date("t");
    $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;

    $sorgu_t=$ci->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM
 geopos_employees INNER JOIN geopos_users On
 geopos_users.id=geopos_employees.id Where  geopos_employees.id=$pers_id")->row();

    $toplam_gun=$sorgu_t->gun_sayisi;
    $total=0;

    if($tip==2) //Çalıştığı birimi gönder
    {
        $query = $ci->db->query("SELECT * FROM geopos_employees Where id=$pers_id ");
        $row = $query->row_array();
        return $row['birim'];
    }
    else if($tip==3) //Alacak Resmi
    {


        $query = $ci->db->query("SELECT * FROM geopos_invoices Where  invoice_type_id=31 and csd=$pers_id ")->result();


        foreach ($query as $q)
        {
            $total+=$q->total;
        }
        return round($total,2);
    }

    else if($tip==4) //Alacak Nakit
    {
        $query = $ci->db->query("SELECT * FROM geopos_invoices Where  invoice_type_id=13 and csd=$pers_id")->result();
        foreach ($query as $q)
        {
            $total+=$q->total;
        }
        return round($total,2);
    }

    else if($tip==5) //Ödenen Resmi
    {

        $alacak_resmi=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and invoice_type_id=12 and method=3")->result();
        foreach ($alacak_list as $list)
        {
            $alacak_resmi+=$list->total;
        }
        return $alacak_resmi;
    }

    else if($tip==6) //Ödenen Nakit
    {

        $alacak_resmi=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and (invoice_type_id=12 or invoice_type_id=14) and method=1")->result();
        foreach ($alacak_list as $list)
        {
            $alacak_resmi+=$list->total;
        }
        return $alacak_resmi;
    }

    else if($tip==7) //Resmi Bakiye
    {

        $query = $ci->db->query("SELECT * FROM geopos_invoices Where  invoice_type_id=31 and csd=$pers_id ")->result();

        $alacak_resmi=0;
        foreach ($query as $q)
        {
            $alacak_resmi+=$q->total;
        }

        $odenen_resmi=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and invoice_type_id=12 and method=3")->result();
        foreach ($alacak_list as $list)
        {
            $odenen_resmi+=$list->total;
        }

        return  round($alacak_resmi-$odenen_resmi,2);


    }


    else if($tip==8) //Gayri Resmi Bakiye
    {

        $alacak_g=0;
        $query = $ci->db->query("SELECT * FROM geopos_invoices Where  invoice_type_id=13 and csd=$pers_id")->result();
        foreach ($query as $q)
        {
            $alacak_g+=$q->total;
        }


        $odenen_g=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and (invoice_type_id=12 or invoice_type_id=14) and method=1")->result();
        foreach ($alacak_list as $list)
        {
            $odenen_g+=$list->total;
        }

        return  round($alacak_g-$odenen_g,2);


    }

    else if($tip==9) //Gayri Resmi Bakiye
    {

        $alacak_g=0;
        $query = $ci->db->query("SELECT * FROM geopos_invoices Where  invoice_type_id=13 and csd=$pers_id")->result();
        foreach ($query as $q)
        {
            $alacak_g+=$q->total;
        }


        $odenen_g=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and (invoice_type_id=12 or invoice_type_id=14) and method=1")->result();
        foreach ($alacak_list as $list)
        {
            $odenen_g+=$list->total;
        }

        $g_r_b=$alacak_g-$odenen_g;



        $alacak_resmi=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and (invoice_type_id=12 or invoice_type_id=14) and method=1")->result();
        foreach ($alacak_list as $list)
        {
            $alacak_resmi+=$list->total;
        }

        $odenen_resmi=0;
        $alacak_list = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$pers_id and invoice_type_id=12 and method=3")->result();
        foreach ($alacak_list as $list)
        {
            $odenen_resmi+=$list->total;
        }

        $resmi_bakiye=$alacak_resmi-$odenen_resmi;

        return round($resmi_bakiye+$g_r_b,2);





    }
    else if($tip==10) //Durum
    {
        $query = $ci->db->query("SELECT * FROM geopos_employees Where id=$pers_id ")->row();
        return  $query->firma_durumu;
    }


    else
    {
        return 0;
    }

}


function personel_email($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id!=0)
    {
        $query2 = $ci->db->query("SELECT * FROM `geopos_users` WHERE id=$id");
        $row = $query2->row_array();

    }
    else
    {
        $row='info@makropro.az';
    }


    return $row;
}
function product_image($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT image FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    $image = $row['image'];
    return $image;


}
function product_cat($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT pcat FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    $cat_id = $row['pcat'];

    $query3 = $ci->db->query("SELECT title FROM geopos_product_cat WHERE id=$cat_id");
    $row2 = $query3->row_array();
    $cat_name = $row2['title'];
    return $cat_name;


}
function category_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $result = $ci->db->query("SELECT * FROM geopos_product_cat WHERE id=$id");
    if($result->num_rows()){
        return $result->row();
    }
    else {
        return  false;
    }



}
function product_unit($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT unit FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    $unit = $row['unit'];
    return $unit;


}
function units()
{
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_units where  `type`=0 and loc=$loc");
    $row = $query2->result_array();

    return $row;


}

function asama_list_rows($proje_id,$bolum_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_milestones WHERE pid=$proje_id and bolum_id=$bolum_id");
    $row = $query2->result_array();

    return $row;


}


function proje_asamalar($proje_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_milestones WHERE pid=$proje_id and parent_id=0");
    $row = $query2->result();

    return $row;


}

function all_bolum_to_asama($bolum_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_milestones WHERE bolum_id=$bolum_id");
    $row = $query2->result();

    return $row;


}
function units_($id)
{
    $ci =& get_instance();
    $ci->load->database();
    if(is_numeric($id))
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_units where  id=$id");
        $row = $query2->row_array();

        return $row;
    }
    return array('name'=>'');




}
function masraf_gider_count($id)
{
    $ci =& get_instance();
    $ci->load->database();
    if($id!=''||  $id!=0)
    {
        $query2 = $ci->db->query("SELECT COUNT(geopos_invoices.id) as sayi FROM `geopos_invoices` WHERE `masraf_id` = $id ");
        $row = $query2->row_array();

        return $row['sayi'];
    }
    return array('sayi'=>'0');




}
function geopos_customer_type()
{
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_customer_type Where loc=$loc");
    $row = $query2->result();
    return $row;



}
function geopos_customer_type_id($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_customer_type WHERE  id=$id");
    $row = $query2->row_array();

    return $row;





}

function product_total_tuketim($id,$uretim_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT toplam_tuketilen FROM geopos_uretim_item WHERE pid=$id and type='uretim' and uretim_id=$uretim_id ");
    $row = $query2->row_array();
    $toplam_tuketilen = $row['toplam_tuketilen'];
    return $toplam_tuketilen;


}
function product_depo($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT warehouse_id FROM geopos_product_to_warehouse WHERE product_id=$id");
    $row = $query2->result_array();
    return $row;


}
function all_warehouse($id = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    $where='';
    if($id){
        $where=' and pers_id='.$id;
    }
    $loc =   $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_warehouse Where loc=$loc $where");
    $row = $query2->result();
    return $row;


}
function warehouse_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_warehouse where id=".$id);
    $row = $query2->row();
    return $row;


}

function stock_qty($id,$options=0)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=[];

    $warehouse_details = $ci->db->query("SELECT * FROM `stock` WHERE `product_id`=$id GROUP BY warehouse_id");
    if($warehouse_details->num_rows()){
        foreach ($warehouse_details->result() as $warehouse_items){



            $query_giren_qty=0;
            $warehouse_name='';
            $query_cikan_qty=0;
            $warehouse_de= $ci->db->query("SELECT * FROM geopos_warehouse where id=$warehouse_items->warehouse_id");
            if($warehouse_de->num_rows()){
                $warehouse_name=$warehouse_de->row()->title;
            }



            if($options){
                $i=0;
                $options_id='';
                $option_value_id='';
                foreach ($options as $options_details){

                    if ($i === array_key_last($options)) {// first loop
                        $options_id.=$options_details['option_id'];
                        $option_value_id.=$options_details['option_value_id'];
                    }
                    else {
                        $options_id.=$options_details['option_id'].',';
                        $option_value_id.=$options_details['option_value_id'].',';
                    }
                    $i++;
                }
                $options_id=option_sort($options_id);
                $option_value_id=option_sort($option_value_id);

                $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_id='$options_id' and stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=1 and stock.warehouse_id=$warehouse_items->warehouse_id");
                if($query_giren->num_rows()){
                    $query_giren_qty = $query_giren->row()->total_giren;
                }
                $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_id='$options_id' and stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=0 and stock.warehouse_id=$warehouse_items->warehouse_id");
                if($query_cikan->num_rows()){
                    $query_cikan_qty = $query_cikan->row()->total_cikan;
                }
            }
            else {
                $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse_items->warehouse_id");
                if($query_giren->num_rows()){
                    $query_giren_qty = $query_giren->row()->total_giren;
                }

                $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse_items->warehouse_id");
                if($query_cikan->num_rows()){
                    $query_cikan_qty = $query_cikan->row()->total_cikan;
                }
            }




            $data[]=[
              'product_id'=>$id,
              'product_name'=>product_full_details($id)['product_name'],
              'warehouse_id'=>$warehouse_items->warehouse_id,
              'warehouse_name'=>$warehouse_name,
              'unit_id'=>$warehouse_items->unit,
              'unit_name'=>units_($warehouse_items->unit)['name'],
              'qty'=>floatval($query_giren_qty)-floatval($query_cikan_qty),
            ];
        }
    }
    return $data;
}

function stock_qty_new($id,$product_stock_id=0,$warehouse_id=0)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=[];
    $warehouse_details = $ci->db->query("SELECT * FROM `stock` WHERE `product_id`=$id GROUP BY warehouse_id");
    if($warehouse_id){
        $warehouse_details = $ci->db->query("SELECT * FROM `stock` WHERE `product_id`=$id and warehouse_id=$warehouse_id GROUP BY warehouse_id");
    }

    if($warehouse_details->num_rows()){
        $total_giren=0;
        $total_cikan=0;
        foreach ($warehouse_details->result() as $warehouse_items){




            $warehouse_name='';

            $warehouse_de= $ci->db->query("SELECT * FROM geopos_warehouse where id=$warehouse_items->warehouse_id");
            if($warehouse_de->num_rows()){
                $warehouse_name=$warehouse_de->row()->title;
            }



            if($product_stock_id){

                $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE  stock_to_options.product_stock_code_id=$product_stock_id and stock.product_id=$id and stock.types=1 and stock.warehouse_id=$warehouse_items->warehouse_id");
                if($query_giren->num_rows()){
                    $query_giren_qty = $query_giren->row()->total_giren;
                }
                $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE  stock_to_options.product_stock_code_id=$product_stock_id and stock.product_id=$id and stock.types=0 and stock.warehouse_id=$warehouse_items->warehouse_id");
                if($query_cikan->num_rows()){
                    $query_cikan_qty = $query_cikan->row()->total_cikan;
                }
            }
            else {
                $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse_items->warehouse_id");
                if($query_giren->num_rows()){
                    $query_giren_qty = $query_giren->row()->total_giren;
                }

                $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse_items->warehouse_id");
                if($query_cikan->num_rows()){
                    $query_cikan_qty = $query_cikan->row()->total_cikan;
                }
            }
            $total_giren+=$query_giren_qty;
            $total_cikan+=$query_cikan_qty;

        }

        $data=[
            'product_id'=>$id,
            'product_name'=>product_full_details($id)['product_name'],
            'unit_id'=>product_full_details($id)['unit'],
            'unit_name'=>units_(product_full_details($id)['unit'])['name'],
            'qty'=>floatval($total_giren)-floatval($total_cikan)
        ];
    }
    return $data;
}

function stock_qty_new_mt($id,$product_stock_id=0,$form_id,$warehouse_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=[
        'qty'=>0
    ];

    $warehouse_details = $ci->db->query("SELECT * FROM `stock` WHERE `product_id`=$id GROUP BY warehouse_id");
    if($warehouse_id){
        $warehouse_details = $ci->db->query("SELECT * FROM `stock` WHERE form_type = 1 and mt_id=$form_id and `product_id`=$id and warehouse_id=$warehouse_id GROUP BY warehouse_id");
    }

    if($warehouse_details->num_rows()){
        $total_giren=0;
        $total_cikan=0;
        foreach ($warehouse_details->result() as $warehouse_items){

            $warehouse_name='';

            $warehouse_de= $ci->db->query("SELECT * FROM geopos_warehouse where id=$warehouse_items->warehouse_id");
            if($warehouse_de->num_rows()){
                $warehouse_name=$warehouse_de->row()->title;
            }



            if($product_stock_id){

                $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE  stock_to_options.product_stock_code_id=$product_stock_id and stock.product_id=$id and stock.types=1 and stock.warehouse_id=$warehouse_items->warehouse_id");
                if($query_giren->num_rows()){
                    $query_giren_qty = $query_giren->row()->total_giren;
                }
                $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE  stock_to_options.product_stock_code_id=$product_stock_id and stock.product_id=$id and stock.types=0 and stock.warehouse_id=$warehouse_items->warehouse_id");
                if($query_cikan->num_rows()){
                    $query_cikan_qty = $query_cikan->row()->total_cikan;
                }
            }
            else {
                $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse_items->warehouse_id");
                if($query_giren->num_rows()){
                    $query_giren_qty = $query_giren->row()->total_giren;
                }

                $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse_items->warehouse_id");
                if($query_cikan->num_rows()){
                    $query_cikan_qty = $query_cikan->row()->total_cikan;
                }
            }
            $total_giren+=$query_giren_qty;
            $total_cikan+=$query_cikan_qty;

        }

        $data=[
            'product_id'=>$id,
            'product_name'=>product_full_details($id)['product_name'],
            'unit_id'=>product_full_details($id)['unit'],
            'unit_name'=>units_(product_full_details($id)['unit'])['name'],
            'qty'=>floatval($total_giren)
        ];
    }
    return $data;
}

function stock_qty_warehouse_new($id,$warehouse,$options=0){
    $ci =& get_instance();
    $ci->load->database();

    $query_cikan=0;
    $query_giren=0;

    $stock_code_id=0;
    $options_id='';
    $option_value_id='';
    $option_value_name='';
    $i=0;

    $prd_name='';
    $product_type=1;
    $pd_details = $ci->db->query("SELECT * FROM geopos_products Where pid = $id");
    if($pd_details->num_rows()){
        $product_type=$pd_details->row()->product_type;
        $prd_name=product_details_($id)->product_name;
    }
    else {
        $prd_name = $ci->db->query("SELECT * FROM geopos_cost Where id = $id")->row()->name;
    }

    $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse");
    $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse");

    if($options[0]['stock_code_id']){

        $stock_code_id = $options[0]['stock_code_id'];
        $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.product_stock_code_id='$stock_code_id'and stock.types=1 and stock.warehouse_id=$warehouse");
        $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.product_stock_code_id='$stock_code_id'and stock.types=0 and stock.warehouse_id=$warehouse");
    }


    if($query_cikan_db->num_rows()){
        $query_cikan=$query_cikan_db->row()->total_cikan;
    }
    if($query_giren_db->num_rows()){
        $query_giren=$query_giren_db->row();
    }

    if($query_giren){
        $unit = $query_giren->unit;
        $unit_name = units_($query_giren->unit)['name'];
        if(!isset($query_giren->unit)){
            $unit = $query_cikan_db->row()->unit;
            $unit_name = units_($query_cikan_db->row()->unit)['name'];
        }

        $kalan = floatval($query_giren->total_giren)-floatval($query_cikan);
        $data=[
            'product_id'=>$id,
            'product_name'=>$prd_name,
            'unit_id'=>$unit,
            'unit_name'=>$unit_name,
            'qty'=>$kalan,
            'option_details'=>$options,
            'product_stock_code_id'=>$stock_code_id,
            'option_value_name'=>$option_value_name,
            'varyasyon_name'=>varyasyon_string_name_new($stock_code_id),
            'product_type'=>$product_type,
        ];
    }





    return $data;


}

function stock_qty_warehouse($id,$warehouse,$options=0)
{
    $ci =& get_instance();
    $ci->load->database();

    $query_cikan=0;
    $query_giren=0;

    $options_id='';
    $option_value_id='';
    $option_value_name='';
    $i=0;

    $data = [];
    $prd_name='';
    $product_type=1;
    $pd_details = $ci->db->query("SELECT * FROM geopos_products Where pid = $id");
    if($pd_details->num_rows()){
        $product_type=$pd_details->row()->product_type;
        $prd_name=product_details_($id)->product_name;


        $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse");
        $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse");


        if($options){
            foreach ($options as $options_details){

                if ($i === array_key_last($options)) {// first loop

                    $option_value_id.=$options_details['option_value_id'];
                    if($options_details['option_id']){
                        $options_id.=$options_details['option_id'];
                    }

                }
                else {

                    $option_value_id.=$options_details['option_value_id'].',';
                    if($options_details['option_id']){
                        $options_id.=$options_details['option_id'].',';;
                    }

                }
                $i++;
            }

            $option_value_id=option_sort($option_value_id);
            $option_value_name_details=$ci->db->query("SELECT * FROM product_option_value Where id in($option_value_id)")->result();
            foreach ($option_value_name_details as $items){
                $option_value_name.=$items->name.' ';
            }

            $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=1 and stock.warehouse_id=$warehouse");
            $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=0 and stock.warehouse_id=$warehouse");
        }




        if($query_cikan_db->num_rows()){
            $query_cikan=$query_cikan_db->row()->total_cikan;
        }
        if($query_giren_db->num_rows()){
            $query_giren=$query_giren_db->row();
        }

        if($query_giren){
            $unit = $query_giren->unit;
            $unit_name = units_($query_giren->unit)['name'];
            if(!isset($query_giren->unit)){
                $unit = $query_cikan_db->row()->unit;
                $unit_name = units_($query_cikan_db->row()->unit)['name'];
            }

            $kalan = floatval($query_giren->total_giren)-floatval($query_cikan);
            $data=[
                'product_id'=>$id,
                'product_name'=>$prd_name,
                'unit_id'=>$unit,
                'unit_name'=>$unit_name,
                'qty'=>$kalan,
                'option_details'=>$options,
                'option_value_name'=>$option_value_name,
                'product_type'=>$product_type,
            ];
        }


    }
    else {
        $prd_name = $ci->db->query("SELECT * FROM geopos_cost Where id = $id");
        if($prd_name->num_rows()){
            $prd_name = $prd_name->row()->name;


            $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse");
            $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse");


            if($options){
                foreach ($options as $options_details){

                    if ($i === array_key_last($options)) {// first loop

                        $option_value_id.=$options_details['option_value_id'];
                        if($options_details['option_id']){
                            $options_id.=$options_details['option_id'];
                        }

                    }
                    else {

                        $option_value_id.=$options_details['option_value_id'].',';
                        if($options_details['option_id']){
                            $options_id.=$options_details['option_id'].',';;
                        }

                    }
                    $i++;
                }

                $option_value_id=option_sort($option_value_id);
                $option_value_name_details=$ci->db->query("SELECT * FROM product_option_value Where id in($option_value_id)")->result();
                foreach ($option_value_name_details as $items){
                    $option_value_name.=$items->name.' ';
                }

                $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=1 and stock.warehouse_id=$warehouse");
                $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=0 and stock.warehouse_id=$warehouse");
            }




            if($query_cikan_db->num_rows()){
                $query_cikan=$query_cikan_db->row()->total_cikan;
            }
            if($query_giren_db->num_rows()){
                $query_giren=$query_giren_db->row();
            }

            if($query_giren){
                $unit = $query_giren->unit;
                $unit_name = units_($query_giren->unit)['name'];
                if(!isset($query_giren->unit)){
                    $unit = $query_cikan_db->row()->unit;
                    $unit_name = units_($query_cikan_db->row()->unit)['name'];
                }

                $kalan = floatval($query_giren->total_giren)-floatval($query_cikan);
                $data=[
                    'product_id'=>$id,
                    'product_name'=>$prd_name,
                    'unit_id'=>$unit,
                    'unit_name'=>$unit_name,
                    'qty'=>$kalan,
                    'option_details'=>$options,
                    'option_value_name'=>$option_value_name,
                    'product_type'=>$product_type,
                ];
            }


        }
    }




    return $data;
}

function stock_qty_warehouse_str_option_new($id,$warehouse,$product_stock_code_id){
    $ci =& get_instance();
    $ci->load->database();
    $data=[];

    $query_giren='';


    if($product_stock_code_id){
        $query_giren = $ci->db->query("SELECT geopos_products.product_name,stock_to_options.option_id,stock_to_options.option_value_id,
    (SUM(IF(types=1,stock.qty,0)) - SUM(IF(types=0,stock.qty,0)) ) as kalan,
       geopos_units.name as birim,stock.unit as unit_id,
    stock.types,stock.mt_id,stock.aauth_id,stock.created_at,stock.product_id

FROM stock
Inner JOIN stock_to_options ON stock.id = stock_to_options.stock_id
Inner JOIN geopos_products ON stock.product_id = geopos_products.pid
Inner JOIN geopos_units ON stock.unit =geopos_units.id

WHERE  stock.warehouse_id=$warehouse and stock.product_id=$id and stock_to_options.product_stock_code_id = $product_stock_code_id

GROUP BY stock_to_options.product_stock_code_id");
    }
    else {
        $query_giren = $ci->db->query("SELECT geopos_products.product_name,stock_to_options.option_id,stock_to_options.option_value_id,
    (SUM(IF(types=1,stock.qty,0)) - SUM(IF(types=0,stock.qty,0)) ) as kalan,
       geopos_units.name as birim,stock.unit as unit_id,
    stock.types,stock.mt_id,stock.aauth_id,stock.created_at,stock.product_id

FROM stock
LEFT JOIN stock_to_options ON stock.id = stock_to_options.stock_id
Inner JOIN geopos_products ON stock.product_id = geopos_products.pid
Inner JOIN geopos_units ON stock.unit =geopos_units.id

WHERE  stock.warehouse_id=$warehouse and stock.product_id=$id");
    }

    if($query_giren->num_rows()){
        $data=[
            'product_id'=>$id,
            'product_name'=>$query_giren->row()->product_name,
            'unit_id'=>$query_giren->row()->unit_id,
            'unit_name'=>$query_giren->row()->birim,
            'qty'=>$query_giren->row()->kalan,
        ];
    }

    return $data;



}
function stock_qty_warehouse_str_option($id,$warehouse,$options_id,$option_value_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=[];

//    $query_cikan=0;
//    $query_giren=0;
//
//    $i=0;
//
//    $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock WHERE product_id=$id and types=1 and warehouse_id=$warehouse");
//    $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock WHERE product_id=$id and types=0 and warehouse_id=$warehouse");
//
//
//    if($option_value_id){
//        $query_giren_db = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_id='$options_id' and stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=1 and stock.warehouse_id=$warehouse");
//        $query_cikan_db = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit FROM stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE stock_to_options.option_id='$options_id' and stock_to_options.option_value_id='$option_value_id' and stock.product_id=$id and stock.types=0 and stock.warehouse_id=$warehouse");
//    }
//
//
//
//
//    if($query_cikan_db->num_rows()){
//        $query_cikan=$query_cikan_db->row()->total_cikan;
//    }
//    if($query_giren_db->num_rows()){
//        $query_giren=$query_giren_db->row();
//    }
//
//    if($query_giren){
//        $unit = $query_giren->unit;
//        $unit_name = units_($query_giren->unit)['name'];
//        if(!isset($query_giren->unit)){
//            $unit = product_details_($id)->unit;
//            $unit_name = units_(product_details_($id)->unit)['name'];
//        }
//
//        $data=[
//            'product_id'=>$id,
//            'product_name'=>product_details_($id)->product_name,
//            'unit_id'=>$unit,
//            'unit_name'=>$unit_name,
//            'qty'=>floatval($query_giren->total_giren)-floatval($query_cikan),
//        ];
//    }


    if($option_value_id){
        $query_giren = $ci->db->query("SELECT geopos_products.product_name,stock_to_options.option_id,stock_to_options.option_value_id,
    (SUM(IF(types=1,stock.qty,0)) - SUM(IF(types=0,stock.qty,0)) ) as kalan,
       geopos_units.name as birim,stock.unit as unit_id,
    stock.types,stock.mt_id,stock.aauth_id,stock.created_at,stock.product_id

FROM stock
Inner JOIN stock_to_options ON stock.id = stock_to_options.stock_id
Inner JOIN geopos_products ON stock.product_id = geopos_products.pid
Inner JOIN geopos_units ON stock.unit =geopos_units.id

WHERE  stock.warehouse_id=$warehouse and stock.product_id=$id and stock_to_options.option_id = '$options_id'
  and stock_to_options.option_value_id  = '$option_value_id'
GROUP BY stock_to_options.option_id,stock_to_options.option_value_id");
    }
    else {
        $query_giren = $ci->db->query("SELECT geopos_products.product_name,stock_to_options.option_id,stock_to_options.option_value_id,
    (SUM(IF(types=1,stock.qty,0)) - SUM(IF(types=0,stock.qty,0)) ) as kalan,
       geopos_units.name as birim,stock.unit as unit_id,
    stock.types,stock.mt_id,stock.aauth_id,stock.created_at,stock.product_id

FROM stock
LEFT JOIN stock_to_options ON stock.id = stock_to_options.stock_id
Inner JOIN geopos_products ON stock.product_id = geopos_products.pid
Inner JOIN geopos_units ON stock.unit =geopos_units.id

WHERE  stock.warehouse_id=$warehouse and stock.product_id=$id");
    }


//
    if($query_giren->num_rows()){
        $data=[
            'product_id'=>$id,
           'product_name'=>$query_giren->row()->product_name,
            'unit_id'=>$query_giren->row()->unit_id,
            'unit_name'=>$query_giren->row()->birim,
            'qty'=>floatval($query_giren->row()->kalan),
        ];
    }

    return $data;
}
function stock_qty_warehouse_products($warehouse)
{
    $ci =& get_instance();
    $ci->load->database();

    $query_giren = $ci->db->query("SELECT SUM(qty) as total_giren,warehouse_id,unit,product_id FROM stock WHERE types=1 and warehouse_id=$warehouse GROUP  BY stock.product_id")->result();

    $data=[];
    foreach ($query_giren as $items){

        $query_cikan = $ci->db->query("SELECT SUM(qty) as total_cikan,warehouse_id,unit,product_id FROM stock WHERE types=0 and warehouse_id=$warehouse  and product_id = $items->product_id GROUP  BY stock.product_id");
        $total_cikan=0;
        if($query_cikan->num_rows()){
            $total_cikan=$query_cikan->row()->total_cikan;
        }
        $data[]=[
            'product_id'=>$items->product_id,
            'product_name'=>product_details_($items->product_id)->product_name,
            'unit_id'=>$items->unit,
            'unit_name'=>units_($items->unit)['name'],
            'qty'=>floatval($items->total_giren)-floatval($total_cikan),
        ];
    }


    return $data;
}
function kategoriler()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_product_cat");
    $row = $query2->result();
    return $row;


}

function product_alis_fiyati($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT price FROM geopos_product_price WHERE product_id=$id ORDER BY `geopos_product_price`.`id` DESC LIMIT 1");
    $row = $query2->row_array();
    $product_price = $row['price'];
    return $product_price;


}
function depo_urun_sayisi($depo_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2=$ci->db->query("SELECT COUNT(geopos_product_to_warehouse.product_id) as qty FROM `geopos_product_to_warehouse` INNER JOIN geopos_products ON geopos_product_to_warehouse.product_id=geopos_products.pid WHERE geopos_product_to_warehouse.warehouse_id=$depo_id
");
    $row1 = $query2->row_array();

    return $row1['qty'];
}

function stok_ogren($id,$depo_id=0)
{
    $ci =& get_instance();
    $ci->load->database();



    if($depo_id!=0)
    {
        $query2 = $ci->db->query("SELECT IF(SUM(qty),SUM(qty),0) as qty   FROM geopos_product_to_warehouse WHERE product_id=$id and warehouse_id=$depo_id");
    }
    else
    {
        $query2 = $ci->db->query("SELECT IF(SUM(qty),SUM(qty),0) as qty  FROM geopos_product_to_warehouse WHERE product_id=$id");
    }

    $row1 = $query2->row_array();



    $qty = $row1['qty'];

    return $qty;


}
function invoice_durum_sorgula($id)
{
    $ci =& get_instance();
    $ci->load->database();



    $query2 = $ci->db->query("SELECT * From geopos_invoices WHERE  id=$id ");
    $row1 = $query2->row_array();



    $status = $row1['status'];

    return $status;


}

function toplam_agirlik($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $urun=$ci->db->query("SELECT * FROM geopos_products WHERE pid=$id");

    $urunler = $urun->row_array();

    $toplam_agirlik=$urunler['metrekare_agirligi']/1000*$urunler['paketleme_miktari'];
    return $toplam_agirlik.' KG';

}

function toplam_rulo_adet($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $table='geopos_product_to_warehouse';

    if ($ci->aauth->get_user()->roleid==14) {

        $table='geopos_product_to_warehouse_r';

    }

    $urun=$ci->db->query("SELECT * FROM geopos_products WHERE pid=$id");

    $urunler = $urun->row_array();

    $paketleme_miktari=$urunler['paketleme_miktari']; //40



    if($urunler['product_type']==6)
    {
        $toplam_adet=0;
        $toplam_rulo=0;
        $rezerve_qty=0;

        $parent_id=$ci->db->query("SELECT * FROM geopos_products WHERE parent_id=$id");

        $parent_ids = $parent_id->result_array();

        foreach ($parent_ids as $urn)
        {


            $product_id=$urn['pid'];
            $paketleme_miktari_par=$urn['paketleme_miktari']; //40


            $query1 = $ci->db->query("SELECT if(SUM(qty),SUM(qty),0) as qty, if(SUM(rezerve_qty),SUM(rezerve_qty),0) as rezerve_qty FROM $table WHERE product_id=$product_id");
            $row1 = $query1->row_array();

            if($paketleme_miktari_par!=0)
            {
                $toplam_adet+=$row1['qty'];
                $toplam_rulo+=$row1['qty']/$paketleme_miktari_par;
                $rezerve_qty+=$row1['rezerve_qty'];

            }
            else
            {

                if ($row1['qty']!=0)
                {

                    $toplam_adet+=$row1['qty'];
                    $toplam_rulo=0;
                    $rezerve_qty+=$row1['rezerve_qty'];
                }
                else
                {

                    $toplam_adet=0;
                    $toplam_rulo=0;
                    $rezerve_qty=0;
                }

            }


        }

        return array('toplam_rulo'=>$toplam_rulo,
            'toplam_adet'=>$toplam_adet,
            'rezerve_qty'=>$rezerve_qty
        );
    }

    else
    {
        $query1 = $ci->db->query("SELECT if(SUM(qty),SUM(qty),0) as qty, if(SUM(rezerve_qty),SUM(rezerve_qty),0) as rezerve_qty FROM $table WHERE product_id=$id");
        $parent_ids = $query1->row_array();

        if($paketleme_miktari>0 )
        {
            $toplam_adet=$parent_ids['qty'];
            $rezerve_qty=$parent_ids['rezerve_qty'];
            $toplam_rulo=$parent_ids['qty']/$paketleme_miktari;

        }
        else
        {

            if($parent_ids['qty']>0)
            {
                $toplam_adet=$parent_ids['qty'];
                $rezerve_qty=$parent_ids['rezerve_qty'];
                $toplam_rulo=$parent_ids['qty'];
            }
            else
            {
                $toplam_adet=0;
                $rezerve_qty=0;
                $toplam_rulo=0;
            }


        }



        return array('toplam_rulo'=>$toplam_rulo,
            'toplam_adet'=>$toplam_adet,
            'rezerve_qty'=>$rezerve_qty
        );
    }



}



function toplam_rulo_adet_depo($id,$depo_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $urun=$ci->db->query("SELECT * FROM geopos_products WHERE pid=$id");

    $urunler = $urun->row_array();

    $toplam_adet=0;
    $toplam_rulo=0;
    $rezerve_qty=0;



    if($urunler['parent_id']!=0)
    {

        $product_id=$urunler['pid'];
        $paketleme_miktari=$urunler['paketleme_miktari']; //40

        $query1 = $ci->db->query("SELECT SUM(qty) as qty , Sum(rezerve_qty) as rezerve_qty FROM geopos_product_to_warehouse WHERE product_id=$product_id and warehouse_id=$depo_id");
        $row1 = $query1->row_array();

        if($row1['qty']!=0)
        {
            if($paketleme_miktari!=0)
            {
                $toplam_rulo=$row1['qty']/$paketleme_miktari;
            }
            else
            {
                $toplam_rulo='Paketleme Miktarı Giriniz!';
            }
            $toplam_adet=$row1['qty'];
            $rezerve_qty=$row1['rezerve_qty'];


        }


        return array('toplam_rulo'=>$toplam_rulo,
            'toplam_adet'=>$toplam_adet,
            'rezerve_qty'=>$rezerve_qty
        );
    }

    else
    {

        $product=$ci->db->query("SELECT * FROM geopos_products WHERE pid=$id");
        $product_details = $product->row_array();
        $paketleme_miktari=$product_details['paketleme_miktari']; //40


        $query1 = $ci->db->query("SELECT SUM(qty) as qty, Sum(rezerve_qty) as rezerve_qty  FROM geopos_product_to_warehouse WHERE product_id=$id and warehouse_id=$depo_id");
        $parent_ids = $query1->row_array();



        if($parent_ids['qty']!=0)
        {
            $toplam_adet=$parent_ids['qty'];
            $rezerve_qty=$parent_ids['rezerve_qty'];
            if($product_details['product_type']!=1)
            {
                $toplam_rulo=$parent_ids['qty']/$paketleme_miktari;
            }


        }


        return array('toplam_rulo'=>$toplam_rulo,
            'toplam_adet'=>$toplam_adet,
            'rezerve_qty'=>$rezerve_qty
        );
    }



}

function stok_ogren_qty($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT qty,toplam_rulo FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    $qty = $row['qty'];

    return $qty;


}
function fis_tip($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id==1)
    {
        return 'Stok Çıkış Fişi';
    }

    else
    {
        return 'Stok Giriş Fişi';
    }


}

function depo_name($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_warehouse WHERE id=$id");
        if($query2->num_rows()>0)
        {
            $row = $query2->row_array();
            $title = $row['title'];

            return $title;
        }
        else
        {
            return '';
        }
    }
    else
    {
        return '';
    }




}

function firmaya_gore_depo_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_warehouse WHERE loc=$id");
    $row = $query2->row_array();
    $title = $row['id'];

    return $title;


}
function rezerv_stok_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT rezerv_qty FROM geopos_products WHERE pid=$id");
    $row = $query2->row_array();
    $qty = $row['rezerv_qty'];
    return $qty;


}
function recete_id($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT id FROM geopos_invoices WHERE new_prd_id=$id");
    $row = $query2->row_array();
    $ids = $row['id'];
    return $ids;


}

function stok_fis_id_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT id FROM geopos_stok_cikis WHERE uretim_id=$id");
    $row = $query2->row_array();
    $ids = $row['id'];
    return $ids;
}

function alt_kategoriler($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $res='';
    $query2 = $ci->db->query("SELECT * FROM geopos_product_cat WHERE parent_id=$id");
    if($query2->num_rows()>0)
    {
        $row = $query2->result();

        foreach ($row as $rows)
        {
            $res.="<option value='$rows->id'>$rows->title</option>";
        }
    }
    else
    {
        $res.="<option value='0'>Alt Kategori Mevcut Değil</option>";

    }
    return $res;

}

function stok_cikisi($id,$warehouse)
{
    $ci =& get_instance();
    $ci->load->database();



    $query2 = $ci->db->query("SELECT  SUM(geopos_stok_cikis_items.qty) as prd_qty   FROM geopos_stok_cikis INNER JOIN geopos_stok_cikis_items ON geopos_stok_cikis_items.tid=geopos_stok_cikis.id
 WHERE geopos_stok_cikis_items.`pid` = $id and type=1 and geopos_stok_cikis.warehouse_id=$warehouse");

    if($query2->num_rows())
    {

        $qty_s = $query2->row_array()['prd_qty'];
        return round($qty_s,2);
    }
    else
    {
        return 0;
    }


}

function recete_id_in_product($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT new_prd_id FROM geopos_invoices WHERE id=$id");
    $row = $query2->row_array();
    $ids = $row['new_prd_id'];
    return $ids;


}

function recete_id_maliyet($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT recete_id FROM geopos_uretim WHERE id=$id");
    $row = $query2->row_array();
    $ids = $row['recete_id'];
    return $ids;


}


function product_id_uretim($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT product_id FROM geopos_uretim WHERE id=$id");
    $row = $query2->row_array();
    $ids = $row['product_id'];
    return $ids;


}
function product_id_uretim_maliyet($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT maliyet FROM geopos_uretim WHERE id=$id");
    $row = $query2->row_array();
    $ids = $row['maliyet'];
    return $ids;


}


function product_id_uretim_qty($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT quantity FROM geopos_uretim WHERE id=$id");
    $row = $query2->row_array();
    $ids = $row['quantity'];
    return $ids;


}
function tahmini_bitirme_tarhi($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT duedate FROM geopos_todolist WHERE uretim_id=$id");
    $row = $query2->row_array();
    $ids = $row['duedate'];
    return $ids;
}
function is_kalemi_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_todolist WHERE id=$id");
    $row = $query2->row();
    return $row;
}


function uretim_in_pers_id($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT user_id FROM geopos_uretim WHERE id=$id");
    $row = $query2->row_array();
    $ids = $row['user_id'];
    return $ids;


}

function recete_name($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT invoice_name FROM geopos_invoices WHERE id=$id");
    $row = $query2->row_array();
    $invoice_name = $row['invoice_name'];
    return $invoice_name;
}

function customer_id_recete($id)
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT csd FROM geopos_invoices WHERE id=$id");
    $row = $query2->row_array();
    $csd = $row['csd'];
    return $csd;
}
function all_customer()
{

    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_customers Where loc=$loc");
    $row = $query2->result();
    return $row;
}

function all_cost()
{
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_cost Where loc=$loc");
    $row = $query2->result();
    return $row;
}

function all_personel()
{

    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT geopos_employees.*,geopos_users.username FROM geopos_employees INNER JOIN geopos_users ON geopos_employees.id=geopos_users.id Where geopos_users.banned=0 and geopos_employees.loc=$loc");
    $row = $query2->result();
    return $row;

}
function all_list_proje_asamalari()
{

    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("Select * From project_asama Where  project_asama.loc=$loc");
    $row = $query2->result();
    return $row;

}

function all_list_podradci()
{

    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("Select * From podradci Where  podradci.loc=$loc");
    $row = $query2->result();
    return $row;

}

function parent_podradci_kontrol_list($asama_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $name='';
    $name_10='';
    $name_9='';
    $name_8='';
    $name_7='';
    $name_6='';
    $name_5='';
    $name_4='';
    $name_3='';
    $name_2='';
    $result = $ci->db->query("SELECT * FROM podradci_parent Where podradci_id = $asama_id");
    if($result->num_rows()){
        if($result->row()->parent_id){
            $parent_id=$result->row()->parent_id;

            $query2 = $ci->db->query("Select company as name,parent_id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id")->row();
            $name_2 = $query2->name.' -> ';
            if($query2->parent_id){
                $parent_id2 = $query2->parent_id;
                $query3 = $ci->db->query("Select company as name,parent_id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id2")->row();
                $name_3 = $query3->name.' -> ';
                if($query3->parent_id){
                    $parent_id3 = $query3->parent_id;
                    $query4 = $ci->db->query("Select company as name,parent_id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id3")->row();
                    $name_4 = $query4->name.' -> ';
                    if($query4->parent_id){
                        $parent_id4 = $query4->parent_id;
                        $query5 = $ci->db->query("Select company as name,parent_id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id4")->row();
                        $name_5 = $query5->name.' -> ';
                        if($query5->parent_id){
                            $parent_id5 = $query5->parent_id;
                            $query6 = $ci->db->query("Select company as name,parent_id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id5")->row();
                            $name_6 = $query6->name.' -> ';
                            if($query6->parent_id){
                                $parent_id6 = $query6->parent_id;
                                $query7 = $ci->db->query("Select company as name,parent_id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id6")->row();
                                $name_7 = $query7->name.' -> ';
                            }
                        }
                    }

                }

            }

        }
    }
    else {
        $name.'->';
    }
    $name = $name_10.$name_9.$name_8.$name_7.$name_6.$name_5.$name_4.$name_3.$name_2;
    return $name;


}

function parent_podradci_kontrol_list_cari($asama_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $name='';
    $name_10='';
    $name_9='';
    $name_8='';
    $name_7='';
    $name_6='';
    $name_5='';
    $name_4='';
    $name_3='';
    $name_2='';
    $ana_cari_id=0;
    $result = $ci->db->query("SELECT * FROM podradci_parent Where podradci_id = $asama_id");
    if($result->num_rows()){
        if($result->row()->parent_id){
            $parent_id=$result->row()->parent_id;
            $query2 = $ci->db->query("Select company as name,parent_id,podradci.id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id")->row();
            $ana_cari_id=$query2->id;
            if($query2->parent_id){
                $parent_id2 = $query2->parent_id;
                $query3 = $ci->db->query("Select company as name,parent_id,podradci.id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id2")->row();
                $ana_cari_id=$parent_id2;
                if($query3->parent_id){
                    $parent_id3 = $query3->parent_id;
                    $query4 = $ci->db->query("Select company as name,parent_id,podradci.id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id3")->row();
                    $ana_cari_id=$query4->id;
                    if($query4->parent_id){
                        $parent_id4 = $query4->parent_id;
                        $query5 = $ci->db->query("Select company as name,parent_id,podradci.id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id4")->row();
                        $ana_cari_id=$query5->id;
                        if($query5->parent_id){
                            $parent_id5 = $query5->parent_id;
                            $query6 = $ci->db->query("Select company as name,parent_id,podradci.id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id5")->row();
                            $ana_cari_id=$query6->id;
                            if($query6->parent_id){
                                $parent_id6 = $query6->parent_id;
                                $query7 = $ci->db->query("Select company as name,parent_id,podradci.id From podradci LEFT JOIN podradci_parent ON podradci.id=podradci_parent.podradci_id Where  podradci.id=$parent_id6")->row();
                                $ana_cari_id=$query7->id;
                            }
                        }
                    }

                }

            }

        }

    }
    else {
        $name.'->';
    }
    return $ana_cari_id;


}
function parent_asama_kontrol_list($asama_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $name='';
    $name_10='';
    $name_9='';
    $name_8='';
    $name_7='';
    $name_6='';
    $name_5='';
    $name_4='';
    $name_3='';
    $name_2='';
    $result = $ci->db->query("SELECT * FROM project_asama_parent Where asama_id = $asama_id");
    if($result->num_rows()){
        if($result->row()->parent_id){
            $parent_id=$result->row()->parent_id;
            $query2 = $ci->db->query("Select name,parent_id From project_asama LEFT JOIN project_asama_parent ON project_asama.id=project_asama_parent.asama_id Where  project_asama.id=$parent_id")->row();
            $name_2 = $query2->name.' -> ';
            if($query2->parent_id){
                $parent_id2 = $query2->parent_id;
                $query3 = $ci->db->query("Select name,parent_id From project_asama LEFT JOIN project_asama_parent ON project_asama.id=project_asama_parent.asama_id Where  project_asama.id=$parent_id2")->row();
                $name_3 = $query3->name.' -> ';
                if($query3->parent_id){
                    $parent_id3 = $query3->parent_id;
                    $query4 = $ci->db->query("Select name,parent_id From project_asama LEFT JOIN project_asama_parent ON project_asama.id=project_asama_parent.asama_id Where  project_asama.id=$parent_id3")->row();
                    $name_4 = $query4->name.' -> ';
                    if($query4->parent_id){
                        $parent_id4 = $query4->parent_id;
                        $query5 = $ci->db->query("Select name,parent_id From project_asama LEFT JOIN project_asama_parent ON project_asama.id=project_asama_parent.asama_id Where  project_asama.id=$parent_id4")->row();
                        $name_5 = $query5->name.' -> ';
                        if($query5->parent_id){
                            $parent_id5 = $query5->parent_id;
                            $query6 = $ci->db->query("Select name,parent_id From project_asama LEFT JOIN project_asama_parent ON project_asama.id=project_asama_parent.asama_id Where  project_asama.id=$parent_id5")->row();
                            $name_6 = $query6->name.' -> ';
                            if($query6->parent_id){
                                $parent_id6 = $query6->parent_id;
                                $query7 = $ci->db->query("Select name,parent_id From project_asama LEFT JOIN project_asama_parent ON project_asama.id=project_asama_parent.asama_id Where  project_asama.id=$parent_id6")->row();
                                $name_7 = $query7->name.' -> ';
                            }
                        }
                    }

                }

            }

        }
    }
    else {
        $name.'->';
    }
    $name = $name_10.$name_9.$name_8.$name_7.$name_6.$name_5.$name_4.$name_3.$name_2;
    return $name;


}
function all_faktoring()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_invoices WHERE invoice_type_id=37");
    $row = $query2->result();
    return $row;

}
function progress_status()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM progress_status");
    $row = $query2->result();
    return $row;

}
function piyasa_fiyati($product_id,$varyasyon_value)
{
    $ci =& get_instance();
    $ci->load->database();
    $options_id='';
    $option_value_id='';
    if($varyasyon_value){
        $i=0;
        foreach ($varyasyon_value as $item){
            if ($i === array_key_last($varyasyon_value)) {// first loop
                $options_id.=$item['option_id'];
                $option_value_id.=$item['option_value_id'];
            }
            else {
                $options_id.=$item['option_id'].',';
                $option_value_id.=$item['option_value_id'].',';
            }
            $i++;
        }
    }

    //echo $options_id;die(); 9,10,15
    //echo $option_value_id;die(); 14,19,33

    $query2='';
     if($options_id){
        $query2 = $ci->db->query("SELECT product_price_details.* FROM product_price_details Inner JOIN product_price_options ON  product_price_details.id=product_price_options.product_price_id
WHERE  product_price_details.product_id=$product_id and product_price_options.option_id LIKE '%$options_id%' and product_price_options.option_value_id LIKE '%$option_value_id%' ORDER BY product_price_details.id DESC LIMIT 1 ");
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM product_price_details where product_id = $product_id ORDER BY id DESC LIMIT 1 ");

    }
   if($query2->num_rows()){
        return  $query2->row()->price;

   }
    else {
        return  0;
    }

}
function piyasa_fiyati_new($product_id,$talep_form_product_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2='';
    $product_stock_code_id = talep_form_product_options_teklif_values($talep_form_product_id);
    if($product_stock_code_id){
        $query2 = $ci->db->query("SELECT product_price_details.* FROM product_price_details Inner JOIN product_price_options ON  product_price_details.id=product_price_options.product_price_id
WHERE  product_price_details.product_id=$product_id and  product_price_options.product_stock_code_id=$product_stock_code_id ORDER BY product_price_details.id DESC LIMIT 1 ");
    }


    else {
        $query2 = $ci->db->query("SELECT * FROM product_price_details where product_id = $product_id ORDER BY id DESC LIMIT 1 ");

    }
   if($query2->num_rows()){
        return  $query2->row()->price;

   }
    else {
        return  0;
    }

}
function teklif_onay_kontrol($id)
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM teklif_onay_list WHERE talep_form_teklifler_item_details_id = $id ORDER BY `id` DESC");
    if($query2->num_rows()){
        return  $query2->result();
    }
    else {
        return  0;
    }

}
function teklif_onay_kontrol_warehouse($warehouse_id,$product_id,$talep_id)
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM teklif_onay_list where warehouse_id = $warehouse_id and
                                     product_id=$product_id and form_id=$talep_id");
    if($query2->num_rows()){
        return  $query2->result();
    }
    else {
        return  0;
    }

}
function progress_status_details($id)
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM progress_status Where id=$id");
    $row = $query2->row();
    return $row;

}
function bakimlar()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM bakimlar");
    $row = $query2->result();
    return $row;


}
function personel_file_type()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM personel_file_type");
    $row = $query2->result();
    return $row;


}
function personel_file_type_id($id)
{

    $ci =& get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM personel_file_type where id=$id");
        $row = $query2->row();
        return $row->name;
    }
    else {
        return '';
    }



}
function trafik_cezalari()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM trafil_cezalari");
    $row = $query2->result();
    return $row;


}
function icazeler()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM icazeler");
    $row = $query2->result();
    return $row;


}
function lojistik_talepleri()
{

    $ci =& get_instance();
    $ci->load->database();

    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM lojistik_talep  Where status=2 and loc=$loc");
    $row = $query2->result();
    return $row;


}
function all_ekstre_tipi()
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM ekstre_tipi");
    $row = $query2->result();
    return $row;


}

function all_invoice_gider()
{

    $ci =& get_instance();
    $ci->load->database();
    $whr='';
    if ($ci->aauth->get_user()->loc) {

        $whr='loc ='.$ci->aauth->get_user()->loc.' AND';
    }

    $query=$ci->db->query("SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE $whr `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal) ");
    return $query->result();


}

function customer_details($id)
{

    $ci =& get_instance();
    $ci->load->database();

    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_customers WHERE id=$id");
        $row = $query2->row_array();
        return $row;
    }
    else
    {
        return  array('company'=>'');
    }



}function cost_details($id)
{

    $ci =& get_instance();
    $ci->load->database();

    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$id");
        $row = $query2->row();
        return $row;
    }
    else
    {
        return  false;
    }



}

function parent_cari($id)
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_customers WHERE parent_id=$id");
    $row = $query2->result();
    return $row;
    
}
function car_to_parent_cari($id)
{

    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM customer_to_parent WHERE parent_id=$id");
    $row = $query2->row();
    if($query2->num_rows()){
        $pr_id=$row->customer_id;
        return  $ci->db->query("SELECT * FROM geopos_customers WHERE id=$pr_id")->row();
    }
    else {
        return false;
    }

    
}

function cart_count($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $count = 0;

    $query2 = $ci->db->query("SELECT COUNT(id) as count FROM `geopos_cart` WHERE user_id=$id");
    $row = $query2->row_array();
    $count = $row['count'];
    return $count;


}
function urun_image($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT image FROM `geopos_products` WHERE pid=$id");
    $row = $query2->row_array();
    $image = $row['image'];
    return $image;


}
function proje_name($id)
{
    $ci =& get_instance();
    $ci->load->database();


    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT name FROM `geopos_projects` WHERE id=$id");
        if($query2->num_rows()>0)
        {
            $row = $query2->row_array();
            $name = $row['name'];
            return $name;
        }
        else
        {
            return "Makro2000 Firması";
        }
    }
    else
    {
        return "Makro2000 Firması";
    }





}


function proje_code($id)
{
    $ci =& get_instance();
    $ci->load->database();


    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT code FROM `geopos_projects` WHERE id=$id");
        if($query2->num_rows()>0)
        {
            $row = $query2->row_array();
            $name = $row['code'];
            return $name;
        }
        else
        {
            return "Makro2000 Firması";
        }
    }
    else
    {
        return "Makro2000 Firması";
    }





}
function proje_id_meta($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `geopos_project_meta` WHERE meta_data=$id  AND `meta_key` = 11");
    $row = $query2->row_array();
    if($row)
    {
        $name = $row['pid'];
    }
    else
    {
        $name = 0;
    }

    return $name;


}
function all_projects()
{
    $ci =& get_instance();
    $ci->load->database();

    $loc =  $ci->session->userdata('set_firma_id');

    $query2 = $ci->db->query("SELECT * FROM `geopos_projects` Where loc = $loc and status not in  (3,4)");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}

function pay_type_next_process($cari_pers_type,$pay_type,$payer_id,$paymethod){
    $ci =& get_instance();
    $ci->load->database();
    $invoices=[];
    $account=[];
    $list_durum=0;
    $account_durum=1;
    $title='';

    $loc = $ci->session->userdata('set_firma_id');
    if($cari_pers_type == 1) //cari
    {
        if($pay_type==17 || $pay_type==18 || $pay_type==19 || $pay_type==20 || $pay_type==47 || $pay_type==48){
            // Faturalar Listelenecek
            $types='1,2,7,8,24';
            $invoice_list = $ci->db->query("SELECT * FROM `geopos_invoices` Where loc = $loc and csd = $payer_id and invoice_type_id IN ($types) ");
            if($invoice_list->num_rows()){
                $invoices = $invoice_list->result();
            }
            else {
                $account_durum = 0;
            }

            $list_durum = 1;
            $title='Fatura Listesi';

        }
        elseif($pay_type==45 || $pay_type==46 || $pay_type==54 || $pay_type==65 || $pay_type==55 || $pay_type==61 || $pay_type==57){
            // Forma2 Listelenecek
            $types='29,30';
            $invoice_list = $ci->db->query("SELECT * FROM `geopos_invoices` Where loc =$loc and csd = $payer_id and invoice_type_id IN ($types) ");
            if($invoice_list->num_rows()){
                $invoices = $invoice_list->result();
            }
            $list_durum=1;
            $title='Forma 2 Listesi';
            if( $pay_type==54 ||  $pay_type==55 || $pay_type==57 ||  $pay_type==61 ||  $pay_type==65){
                $account_durum = 0;
            }

        }

        elseif($pay_type==3 || $pay_type==4 || $pay_type==43 || $pay_type==44 ){

            $list_durum=0;
            $account_durum = 1;

        }
        else {
            $list_durum=0;
            $account_durum = 0;
        }
    }
    elseif($cari_pers_type == 2) // Personel
    {
        if($pay_type==52){
            $account_durum = 0;
        }
    }

    elseif($cari_pers_type == 6) // Faktorinq
    {
        if($pay_type==52){
            $account_durum = 0;
        }
    }
    elseif($cari_pers_type == 7) // Faktorinq
    {

    }

    $where='';
//    if($ci->aauth->get_user()->roleid!=1 || $ci->aauth->get_user()->roleid!=2){
//        $user_id = $ci->aauth->get_user()->id;
//        $where=' and eid='.$user_id;
//    }

    if ($ci->aauth->premission(27)->read) {

    }
    else {
        if ($ci->aauth->premission(65)->read) {
            $user_id = $ci->aauth->get_user()->id;
            $where=' and eid='.$user_id;
        }
        else {
            $where=' and eid=0';
        }

    }

    $account_list = $ci->db->query("SELECT * FROM `geopos_accounts` Where loc=$loc and status = 1 and account_type = $paymethod $where");
    if($account_list->num_rows()){
        $account= $account_list->result();
    }


    return [
        'invoice_list'=>$invoices,
        'account_list'=>$account,
        'title'=>$title,
        'account_durum'=>$account_durum,
        'list_durum'=>$list_durum,
    ];
}

function pay_type($cari_pers_type)
{
    $ci =& get_instance();
    $ci->load->database();
    $types='';
    if($cari_pers_type==1){
        $types='3,4,43,44,45,46,54,65,55,61,57,17,18,19,20,47,48,22,23';
    }
    else if($cari_pers_type==2){
        $types='14,59,51,16,52,68';
    }
    else if($cari_pers_type==6){
        $types='3,4';
    }
    else if($cari_pers_type==7){
        $types='3,4';
    }
    $query2 = $ci->db->query("SELECT * FROM `geopos_invoice_type` Where id IN ($types) ");
    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }
}
function all_products()
{
    $ci =& get_instance();
    $ci->load->database();
    $loc =   $ci->session->userdata('set_firma_id');

    $query2 = $ci->db->query("SELECT * FROM `geopos_products` where loc = $loc");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}
function araclar()
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT araclar.*,geopos_customers.company FROM `araclar` LEFT JOIN geopos_customers ON araclar.firma_id = geopos_customers.id");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}
function nakliye_item_tip()
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `nakliye_item_tip`");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}


function nakliye_item_button($id,$nakliye_item_id,$form_id){
    $ci =& get_instance();
    $ci->load->database();
    $button='';

    if($id==1) // Malzeme Talebi
    {

        $kontrol = $ci->db->query("SELECT * FROM talep_form_nakliye_to_mt Where talep_item_id=$nakliye_item_id");
        if($kontrol->num_rows()){
            $personel_name='';

            $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
            $status=$details->status_name;
            if($details->status_id==13){
                $personel_name=personel_detailsa($kontrol->row()->yukleyen_pers_id)['name'];
                $button="<span class='badge badge-secondary'>$status | $personel_name</span>";


            }
            if($details->status_id==14){
                $personel_name=personel_detailsa($kontrol->row()->tehvil_pers_id)['name'];
                $button="<span class='badge badge-secondary'>$status | $personel_name</span>";
            }

            elseif($details->status_id==11){
                $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
                $status=$details->status_name;
                $button="<span class='badge badge-secondary'>$status</span>";
            }
             elseif($details->status_id==9){
                $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
                $status=$details->status_name;
                $button="<span class='badge badge-secondary'>$status</span>";
            }

            if($details->status_id!=11 && $details->status_id!=9){
                foreach ($kontrol->result() as $items){
                    $mt_id = $items->mt_id;
                    $mt_details = $ci->db->query("SELECT * FROM talep_form Where id=$mt_id")->row();
                    $button.="&nbsp;<a href='/malzemetalep/view/$mt_id' target='_blank' class='btn-sm btn btn-success'><i class='fa fa-eye'></i> ".$mt_details->code."</button>";
                }
            }

            if($details->status_id==15){
                $button = '<button type="button" class="btn btn-info payment_talep" nakliye_item_id="'.$nakliye_item_id.'" form_id="'.$form_id.'"> Ödeme Talep Et - İşlemi Tamamla</button>';

            }

        }
        else {
            $button = '<button type="button" class="btn btn-info mt_info" nakliye_item_id="'.$nakliye_item_id.'" form_id="'.$form_id.'"> MT Bİlgileri Giriş Yap</button>';

            $mt_talep_kontrol = $ci->db->query("SELECT * FROM nakliye_mt_talep Where talep_item_id = $nakliye_item_id");
            if($mt_talep_kontrol->num_rows()){
                if($mt_talep_kontrol->row()->mt_id == ''){
                    $button.="&nbsp; Talep Edildi... Bekleyiniz";
                }
                else {
                    $mt_talep_kontrol = $ci->db->query("SELECT * FROM nakliye_mt_talep Where talep_item_id = $nakliye_item_id ")->row();
                    $mt_array=$mt_talep_kontrol->mt_id;
                    $id_str_ = json_decode($mt_array);
                    if($id_str_){
                        $id_str=implode(',',$id_str_);
                        $mt_details = $ci->db->query("SELECT * FROM talep_form Where id IN($id_str)")->result();
                        $personel_name_=personel_details($mt_talep_kontrol->mt_talep_personel_id);
                        $text=$mt_talep_kontrol->mt_text.' | '.$mt_talep_kontrol->updated_at;
                        foreach($mt_details as $items){
                            $button.="&nbsp;<span class='badge badge-secondary' data-popup='popover' data-trigger='hover' data-content='$text' data-original-title='$personel_name_'>$items->code</span>";
                        }
                    }

                }
             }
            elseif($mt_talep_kontrol->num_rows()==0) {
                $button.= '&nbsp;<button type="button" class="btn btn-info new_mt_bildirimi" nakliye_item_id="'.$nakliye_item_id.'" form_id="'.$form_id.'"> MT Yok İse Talep Et</button>';


            }


        }

   }
    if($id==2) // Dopo Stok Transferi
    {

        $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();


        if($details->status_id==1){
            $asamalar='';
            $text="Depoları Belirle";
            $button.= ' <button type="button" class="btn btn-info depocu_bildirimi" nakliye_item_id="'.$nakliye_item_id.'" form_id="'.$form_id.'"> '.$text.'</button>'.$asamalar;

        }
        elseif($details->status_id==13){

            $asamalar='';
            $warehouse_transfer_kontrol =$ci->db->query("SELECT * FROM nakliye_talep_transfer_item Where n_item_id=$nakliye_item_id");
            if($warehouse_transfer_kontrol->num_rows()){
                $text='Depoları Görüntüle';
                $warehouse_transfer_k=$ci->db->query("SELECT * FROM nakliye_talep_transfer Where n_item_id=$nakliye_item_id and bildirim_durumu=0")->num_rows();

                if($warehouse_transfer_k){
                    $button.='<button type="button" class="btn btn-success depo_bildirim_baslat_new" n_item_id="'.$nakliye_item_id.'"><i class="fa fa-bell"></i> Bildirim Başlat</button>';
                }
                else {
                    $asamalar.=' <button class="btn btn-warning transfer_asamalari" n_item_id="'.$nakliye_item_id.'" ><i class="fa fa-list"></i> Aşamalar</button>';
                }
            }

            $text="Depoları Görüntüle";
            $button.= ' <button type="button" class="btn btn-info depocu_bildirimi" nakliye_item_id="'.$nakliye_item_id.'" form_id="'.$form_id.'"> '.$text.'</button>'.$asamalar;

        }

        if($details->status_id==11){
            $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
            $status=$details->status_name;
            $button="<span class='badge badge-secondary'>$status</span>";
        }
        elseif($details->status_id==12){

            $details_talep = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
            $status=$details_talep->status_name;

            $button="<span class='badge badge-secondary'>$status</span>";

        }



    }
    if($id==3) // Hizmet
    {
        $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
        if($details->status_id==2){
            $button = '<button type="button" class="btn btn-info hizmet_tamamla" nakliye_item_id="'.$nakliye_item_id.'" form_id="'.$form_id.'"> Hizmet Tamamla</button>';
        }
        elseif($details->status_id==11){
            $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
            $status=$details->status_name;
            $button="<span class='badge badge-secondary'>$status</span>";
        }
        elseif($details->status_id==9){
            $details = $ci->db->query("SELECT talep_form_status.name as status_name,talep_form_nakliye_products.status as status_id FROM talep_form_nakliye_products Inner JOIN talep_form_status ON talep_form_nakliye_products.status=talep_form_status.id  Where talep_form_nakliye_products.id=$nakliye_item_id")->row();
            $status=$details->status_name;
            $button="<span class='badge badge-secondary'>$status</span>";
        }
    }

    return $button;
}

function nakliye_item_tip_who($id,$item_id=0)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `nakliye_item_tip` Where id = $id");

    if($query2->num_rows()>0)
    {
        $row = $query2->row();
        $messages='';
        $style='';
        if($item_id){
            $style='
    color: #cf4700;
    animation-name: flash;
    -webkit-animation-duration: 2s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;';

            $details = $ci->db->query("SELECT * FROM `talep_form_nakliye_to_mt` Where talep_item_id = $item_id");
            if($details->num_rows()){
                foreach ($details->result() as  $items){
                    $messages.="Ürün Cinsi : ".$items->urun_cinsi.'</br>';
                    $messages.="Ürün M3 : ".$items->urun_m3.'</br>';
                    $messages.="Ürün Ağırlık : ".$items->urun_agirlik.'</br>';
                    $messages.="Ürün Tonaj : ".$items->urun_tonaj.'</br>';
                }
            }
        }
        return array(
            'name'=>$row,
            'style'=>$style,
            'messages'=>html_entity_decode($messages,ENT_COMPAT, 'UTF-8')
        );

    }
    else
    {
        return 0;
    }

}
function nakliye_tip_details($tip_id,$item_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $product_details='';
    $html='';
    $mt_array=[];
    if($tip_id==1){

        $arac_yukleme_details = $ci->db->query("SELECT * FROM talep_form_nakliye_product_arac Where n_item_id=$item_id");
        if($arac_yukleme_details->num_rows()){
            foreach ($arac_yukleme_details->result() as $arac_items){
                $stock_details = $ci->db->query("SELECT * FROM talep_form_nakliye_to_mt Where talep_item_id=$item_id");
            }
        }


        $mt_id = $ci->db->query("SELECT * FROM talep_form_nakliye_to_mt Where talep_item_id=$item_id");
        if($mt_id->num_rows()){
            foreach ($mt_id->result() as $values){
                $mt_array[]=$values->mt_id;
            }
            $id_str = implode(',',$mt_array);
            $talep_details = $ci->db->query("SELECT * FROM `talep_form` Where id IN ($id_str)");
            if($talep_details->num_rows()){
                foreach ($talep_details->result() as $talep_values){
                    $html.='<span n_item_id="'.$item_id.'" m_talep_id="'.$talep_values->id.'"  class="mt_info_arac badge badge-info mr-1">'.$talep_values->code.'</span>';
                }
            }

        }
    }
    else if($tip_id==2){
        $html.='<button type="button" class="btn btn-warning transfer_arac_view"  eq="0"
                            nakliye_item_id="'.$item_id.'" 
                            tip="3" ><i class="fa fa-truck"></i> Araç İçini Görüntüle</button>';
    }

    return $html;

}


function arac_ekipmanlari($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT ekipmanlar.* FROM `arac_ekipmanlari`  JOIN ekipmanlar ON ekipmanlar.id = arac_ekipmanlari.ekipman_id Where arac_ekipmanlari.arac_id = $id");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}
function arac_aktive_surucu($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT geopos_employees.*,arac_suruculeri.talep_id,geopos_users.email,geopos_users.date_created FROM `arac_suruculeri`  JOIN geopos_employees ON geopos_employees.id = arac_suruculeri.user_id JOIN geopos_users ON geopos_employees.id = geopos_users.id Where arac_suruculeri.arac_id = $id and arac_suruculeri.status=2");

    if($query2->num_rows()>0)
    {
        $row = $query2->row();
        return $row;
    }
    else
    {
        return 0;
    }

}
function arac_izinleri($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT icazeler.* FROM `arac_icazeleri`  JOIN icazeler ON icazeler.id = arac_icazeleri.icaze_id Where arac_icazeleri.arac_id = $id");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}
function araclar_list($type)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT araclar.*,geopos_customers.company FROM `araclar` LEFT JOIN geopos_customers ON araclar.firma_id = geopos_customers.id Where araclar.kiralik_demirbas=$type");

    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        return $row;
    }
    else
    {
        return 0;
    }

}
function lj_satinalma_onay_kontrol($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $aau_id=$ci->aauth->get_user()->id;
    $sort_kontol = $ci->db->query("SELECT * FROM `lsf_table_file_staff` where user_id = $aau_id");
    if($sort_kontol->num_rows()){


    if($sort_kontol->row()->sort==1){
        $query2 = $ci->db->query("SELECT * FROM `lsf_table_file_item`  Where lsf_id=$id");


        if($query2->num_rows()>0)
        {
            if($query2->row()){
                if($query2->row()->status==1){
                    return 'Proje Müdürü İncelemesinde';
                }
                elseif($query2->row()->status==2){
                    return 'Cari Bakiyesinde Alacaklandı';
                }
                elseif($query2->row()->status==3){
                    return 'Onaylandı Fatura Bekliyor';
                }
                elseif($query2->row()->status==4){
                    return 'Fatura Geldi';
                }
                elseif($query2->row()->status==5){
                    return 'Ödendi';
                }
                elseif($query2->row()->status==8){
                    return 'Hizmet Talebi İptal Edildi';
                }
                elseif($query2->row()->status==6){
                    return 'Düzeliş İstendi';
                }
                elseif($query2->row()->status==7){
                    return 'Genel Müdür İncelemesinde';
                }

            }


        }
        else
        {
            return 0;
        }
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `lsf_table_file_item`  Where lsf_id=$id");


        if($query2->num_rows()>0)
        {
            if($query2->row()){
                if($query2->row()->status==1){
                    return 'Genel Müdür İncelemesinde';
                }
                elseif($query2->row()->status==2){
                    return 'Cari Bakiyesinde Alacaklandı';
                }
                elseif($query2->row()->status==3){
                    return 'Onaylandı Fatura Bekliyor';
                }
                elseif($query2->row()->status==4){
                    return 'Fatura Geldi';
                }
                elseif($query2->row()->status==5){
                    return 'Ödendi';
                }
                elseif($query2->row()->status==8){
                    return 'Hizmet Talebi İptal Edildi';
                }
                elseif($query2->row()->status==6){
                    return 'Düzeliş İstendi';
                }
                elseif($query2->row()->status==7){
                    return 'Genel Müdür İncelemesinde';
                }

            }


        }
        else
        {
            return 0;
        }
    }
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `lsf_table_file_item`  Where lsf_id=$id");


        if($query2->num_rows()>0)
        {
            if($query2->row()){
                if($query2->row()->status==1){
                    return 'Proje Müdürü İncelemesinde';
                }
                elseif($query2->row()->status==2){
                    return 'Cari Bakiyesinde Alacaklandı';
                }
                elseif($query2->row()->status==3){
                    return 'Onaylandı Fatura Bekliyor';
                }
                elseif($query2->row()->status==4){
                    return 'Fatura Geldi';
                }
                elseif($query2->row()->status==5){
                    return 'Ödendi';
                }
                elseif($query2->row()->status==8){
                    return 'Hizmet Talebi İptal Edildi';
                }
                elseif($query2->row()->status==6){
                    return 'Düzeliş İstendi';
                }
                elseif($query2->row()->status==7){
                    return 'Genel Müdür Onayladı';
                }

            }


        }
        else
        {
            return 0;
        }
    }



}
function arac_view($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `araclar` Where id =$id");

    if($query2->num_rows()>0)
    {
        $row = $query2->row();
        return $row;
    }
    else
    {
        return 0;
    }

}
function arac_firma($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT geopos_customers.company FROM `araclar` LEFT JOIN geopos_customers ON araclar.firma_id = geopos_customers.id Where araclar.id=$id");

    if($query2->num_rows()>0)
    {
        $row = $query2->row();
        return $row;
    }
    else
    {
        return 0;
    }

}
function customer_projects($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_projects` Where cid=$id");
    $row = $query2->result();
    return $row;



}
function customer_projects_id($id,$csd)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_projects` Where id=$id and cid=$csd");
    $row = $query2->row();
    return $row;



}


function all_bolum_proje($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_project_bolum");
    $ci->db->where("geopos_project_bolum.pid=$id");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}
function parent_asama_sorgula($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_milestones");
    $ci->db->where("geopos_milestones.parent_id=$id");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}
function all_bolum_asama($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_milestones");
    $ci->db->where("geopos_milestones.pid=$id");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}

function all_asama_alt_asama($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_milestones");
    $ci->db->where("geopos_milestones.parent_id=$id");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}
function all_bolum_task($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_todolist");
    $ci->db->where("geopos_todolist.asama_id=$id");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}

function all_ana_masraf()
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_cost");
    $ci->db->where("parent_id=0");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}
function all_alt_masraf()
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_cost");
    $ci->db->where("parent_id!=0");

    $query = $ci->db->get();

    $querys = $query->result();


    return $querys;
}

function purchase_in_sayim($id)
{
    $ci =& get_instance();
    $ci->load->database();

    //$id sayim_id


    $query2 = $ci->db->query("SELECT * FROM `geopos_sayim_to_purchase` WHERE sayim_id=$id LIMIT 1")->row_array();
    $purchase_id=$query2['purchase_id'];



    $query2 = $ci->db->query("SELECT * FROM `geopos_purchase` WHERE id=$purchase_id");
    return $query2->row_array();
}
function purchase_in_depo($id)
{
    $ci =& get_instance();
    $ci->load->database();

    //$id sayim_id


    $query2 = $ci->db->query("SELECT * FROM `geopos_purchase` WHERE id=$id")->row_array();
    $depo_id=$query2['depo_id'];

    return $depo_id;
}
function sayim_products_details($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `geopos_sayim_items` WHERE tid=$id");
    return $query2->result_array();
}
function project_to_depo($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `geopos_warehouse` WHERE proje_id=$id");
        if($query2->num_rows()>0)
        {
            return $query2->row();
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 0;
    }



}
function purchase_status($id=0)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id!=0)
    {
        $query2 = $ci->db->query("SELECT * FROM `geopos_purchase_status` WHERE  id =$id")->row_array();
        return $query2['name'];
    }

    else
    {
        $query2 = $ci->db->query("SELECT * FROM `geopos_purchase_status`");
        return $query2->result_array();
    }



}
function invoice_status($id=0)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id)
    {
        $query2 = $ci->db->query("SELECT * FROM `invoice_status` WHERE  id =$id")->row_array();
        return $query2['name'];
    }
    else
    {
        $query2 = $ci->db->query("SELECT * FROM `invoice_status`");
        return $query2->result_array();
    }



}
function invoice_status_ogren($id=0)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `invoice_status` WHERE  id =$id")->row_array();
    return $query2['name'];



}
function surucu_notes_status()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `surucu_notes_status`")->result();
    return $query2;



}

function depolar()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_warehouse`");
    return $query2->result_array();
}

function onay_durumlari_ogre($type,$file_id,$string)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id");
    if($query2->num_rows()>0)
    {
        if(isset($query2->row()->$string))
        {
            return $query2->row()->$string;
        }
        else {
            return 1;
        }

    }
    else
    {
        return 1;
    }

}
function onay_durumlari_ogren_product_user($type,$file_id,$string,$product,$mt)
{
    $ci =& get_instance();
    $sayi=0;
    $ci->load->database();


    $query= $ci->db->query("SELECT * FROM `geopos_talep_items` WHERE geopos_talep_items.`product_name`='$product' and geopos_talep_items.tip=$file_id")->result();

    foreach ($query as $details)
    {

        $query2 = $ci->db->query("SELECT * FROM `geopos_onay` WHERE geopos_onay.type=$type and geopos_onay.file_id=$file_id and geopos_onay.malzeme_items_id=$details->id");

        foreach($query2->result() as $quer)
        {
            if($quer->$string==3)
            {
                $sayi =1;
            }

        }

    }

    if($sayi==1)
    {
        return 3;
    }
    else
    {
        return 1;
    }



}
function onay_durumlari_ogren_product_user_firma($type,$file_id,$string,$product,$mt,$malzeme_talep_id)
{
    $ci =& get_instance();
    $sayi=0;
    $ci->load->database();


    $query= $ci->db->query("SELECT * FROM `geopos_talep_items` WHERE geopos_talep_items.`product_name`='$product' and geopos_talep_items.tip=$file_id")->result();

    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` WHERE geopos_onay.type=$type and geopos_onay.file_id=$file_id and geopos_onay.malzeme_items_id=$malzeme_talep_id");

    foreach($query2->result() as $quer)
    {
        if($quer->$string==3)
        {
            $sayi =1;
        }

    }
    if($sayi==1)
    {
        return 3;
    }
    else
    {
        return 1;
    }



}
function onay_durumlari_ogren_product_user_ref($string,$mt)
{
    $ci =& get_instance();
    $sayi=0;
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` WHERE geopos_onay.malzeme_items_id=$mt")->row();

    if($query2->$string==3)
    {
        $sayi =1;
    }

    if($sayi==1)
    {
        return 3;
    }
    else
    {
        return 1;
    }



}

function firma_onay_kontrol($sf_id,$fima){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_talep_items INNER JOIN geopos_onay ON geopos_talep_items.id = geopos_onay.malzeme_items_id Where geopos_talep_items.tip = $sf_id and geopos_talep_items.firma='$fima' and geopos_onay.genel_mudur_status=3");
    if($query2->num_rows()>0){
        return true;
    }
    else {
        return false;
    }
}

function onay_durumlari_ogren_satin_alma($type,$file_id,$string,$saat_str='')
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id");
    if($query2->num_rows()>0)
    {

        $notes= $string.'_note';
        $saat_strs= '';

        if($saat_str!=''){
            $saat_strs= $saat_str.'_onay_saati';
        }




        $mesasge='';
        foreach ($query2->result() as $q)
        {

            $note=$q->$notes;
            $saat='';
            if($saat_str!=''){
                $saat=$q->$saat_strs;
            }


            if($q->$string==3)
            {
                $malzeme_talep_id=$q->malzeme_items_id;
                $query=$ci->db->query("SELECT * FROM `geopos_talep_items` Where id=$malzeme_talep_id")->row();
                $mesasge.= '<b>'.$query->product_name.' '.$query->product_detail.'</b> Ürünü İçin <b>'.$query->firma.'</b> Onaylanmıştır. Açıklama : '.$note.' '.$saat.'</br>';

            }
            else if($q->$string==4)
            {
                $malzeme_talep_id=$q->malzeme_items_id;
                $query=$ci->db->query("SELECT * FROM `geopos_talep_items` Where id=$malzeme_talep_id")->row();
                $mesasge.= '<b>'.$query->product_name.' '.$query->product_detail.'</b> Ürünü İçin <b>'.$query->firma.'</b> İptal Vermiştir. Açıklama : '.$note.' '.$saat.'</br>';

            }
            else if($q->$string==2)
            {
                $malzeme_talep_id=$q->malzeme_items_id;
                $query=$ci->db->query("SELECT * FROM `geopos_talep_items` Where id=$malzeme_talep_id")->row();
                $mesasge.= '<b>'.$query->product_name.' '.$query->product_detail.'</b> Ürünü İçin Yorum Yapmıştır. Açıklama :<b> '.$note.' '.$saat.'</b></br>';

            }
        }
        return $mesasge;



    }
    else
    {
        return 'Bekliyor';
    }

}
function onay_durumlari_ogren_product($type,$file_id,$product_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id and malzeme_items_id=$product_id");
    if($query2->num_rows()>0)
    {
        if($query2->row()->proje_sorumlusu_status == 4  || $query2->row()->proje_muduru_status == 4 || $query2->row()->genel_mudur_status == 4 || $query2->row()->finans_status == 4 || $query2->row()->finans_status == 4 || $query2->row()->bolum_muduru_status == 4 || $query2->row()->satinalma_personeli_status == 4 )
        {
            return 0;
        }
        else
        {
            return 1;
        }


    }
    else
    {
        return 1;
    }

}
function onay_durumlari_ogren_product_sf($type,$file_id,$file_alt_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id and alt_file_id=$file_alt_id");
    if($query2->num_rows()>0)
    {
        if($query2->row()->satinalma_status == 4  || $query2->row()->proje_muduru_status == 4 || $query2->row()->genel_mudur_status == 4 || $query2->row()->finans_status == 4 ||  $query2->row()->bolum_muduru_status == 4 )
        {
            return 0;
        }
        else
        {
            return 1;
        }


    }
    else
    {
        return 1;
    }

}
function onay_durumlari_ogren_product_str($type,$file_id,$product_id,$string)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id and malzeme_items_id=$product_id");
    if($query2->num_rows()>0)
    {
        if(isset($query2->row()->$string))
        {
            $notes=$string.'_note';
            return array(
                'durum'=> $query2->row()->$string,
                'note'=> $query2->row()->$notes
            );
        }
        else {
            return array(
                'durum'=> 1,
                'note'=> ''
            );
        }

    }
    else
    {
        return array(
            'durum'=> 1,
            'note'=> ''
        );
    }

}

function malzeme_talep_depo_miktari($file_id,$product_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where  file_id=$file_id and malzeme_items_id=$product_id");
    if($query2->num_rows()>0)
    {
        return $query2->row()->depoda_bulunan_mik;
    }
}

function onay_durumlari_ogren_product_onay_saati($type,$file_id,$product_id,$string)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id and malzeme_items_id=$product_id");
    if($query2->num_rows()>0)
    {
        if(isset($query2->row()->$string))
        {
            return array(
                'onay_saati'=> $query2->row()->$string
            );
        }
        else {
            return array(
                'onay_saati'=> ''
            );
        }

    }
    else
    {
        return array(
            'onay_saati'=> ''
        );
    }

}

function sayim_product($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `geopos_sayim_items` WHERE pid=$id");
    return $query2->row_array();
}

function sayim_onay_mail()
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT sayim_onay_pers_id FROM `geopos_system` WHERE id=1");
    $row = $query2->row_array();
    $sayim_onay_pers_id = $row['sayim_onay_pers_id'];
    $email='';
    if($sayim_onay_pers_id)
    {
        $query3 = $ci->db->query("SELECT email FROM `geopos_users` WHERE id=$sayim_onay_pers_id");
        $rows = $query3->row_array();
        $email = $rows['email'];
        return array(
            'email'=>$email,
            'user_id'=>$sayim_onay_pers_id
        );
    }
    else
    {
        $email=$row['email'];
        return array(
            'email'=>$email,
            'user_id'=>0
        );
    }




}

function siparis_eksik_stok($product_id,$qty)
{
    $ci =& get_instance();
    $ci->load->database();


    $query = $ci->db->query("SELECT SUM(qty) as  qty FROM `geopos_product_to_warehouse` WHERE product_id=$product_id");
    $row = $query->row_array();

    $miktar = $row['qty'];

    if($miktar<$qty)
    {
        $eksik_miktar=$miktar-$qty;
        return array(
            'product_id'=>$product_id,
            'eksik_miktar'=>abs($eksik_miktar)
        );
    }




}

function siparis_detay_ogren($purchase_id,$pid)
{
    $ci =& get_instance();
    $ci->load->database();


    $query = $ci->db->query("SELECT * FROM `geopos_purchase_items` WHERE pid=$pid and tid=$purchase_id");
    $row = $query->row_array();
    return array(
        'product_id'=>$row['pid'],
        'rulo_miktari'=>$row['rulo_miktari'],
        'qty'=>$row['qty'],
        'product_name'=>$row['product']
    );
}


function para_birimi()
{
    $ci =& get_instance();
    $ci->load->database();

    $query = $ci->db->query("SELECT * FROM geopos_currencies");
    $row = $query->result_array();

    return $row;


}
function para_birimi_id($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE  id=$id");
    $row = $query->row_array();

    return $row;


}
function personel_depertman($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query = $ci->db->query("SELECT * FROM geopos_hrm where typ=3 and id=$id");
    $row = $query->row_array();

    return $row;


}
function personel_depertman_list()
{
    $ci =& get_instance();
    $ci->load->database();

    $query = $ci->db->query("SELECT * FROM geopos_hrm where typ=3");
    $row = $query->result();

    return $row;


}
function satinalma_yonlendirme($product_id,$talep_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query = $ci->db->query("SELECT * FROM geopos_onay where file_id=$talep_id and malzeme_items_id = $product_id");
    $row = $query->row_array();

    return $row['satinalma_yonlendirme'];


}

function doviz($kur,$date)
{
    $ci =& get_instance();
    $ci->load->database();

    $return=1;

    /* $xml = simplexml_load_file('https://www.cbar.az/currencies/'.$date.'.xml');

     foreach ($xml->ValType as $type) {

         //var_dump($type);

         if($type['Type']=='Xarici valyutalar')
         {
             foreach ($type->Valute as $ccc)
             {
                 if($ccc['Code']==$kur)
                 {
                     echo $ccc->Value;
                 }
             }


         }





     }*/

    $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$kur' LIMIT 1")->row();
    $return=$query->rate;


    return $return;
}

function old_rulo_quantity($product_id,$invoice_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $querys= $ci->db->query("SELECT * FROM `geopos_products` WHERE pid=$product_id");
    $rows = $querys->row_array();
    $en = $rows['en'];
    $boy = $rows['boy'];

    $m2=$en*$boy /10000; // 46



    $query = $ci->db->query("SELECT * FROM `geopos_invoice_items` WHERE pid=$product_id and tid=$invoice_id");

    $row = $query->row_array();
    $adet = $row['qty']; //322

    $rulo_miktarı=$adet/$m2; //322/46

    return $rulo_miktarı; // 7


}
function old_rulo_quantity_sayim($product_id,$invoice_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $querys= $ci->db->query("SELECT * FROM `geopos_products` WHERE pid=$product_id");
    $rows = $querys->row_array();
    $en = $rows['en'];
    $boy = $rows['boy'];

    $m2=$en*$boy /10000; // 46



    $query = $ci->db->query("SELECT * FROM `geopos_sayim_items` WHERE pid=$product_id and tid=$invoice_id");

    $row = $query->row_array();
    $adet = $row['qty']; //322

    $rulo_miktarı=$adet/$m2; //322/46

    return $rulo_miktarı; // 7


}


function rulo_hesapla($product_id,$qty)
{
    $ci =& get_instance();
    $ci->load->database();

    $querys= $ci->db->query("SELECT * FROM `geopos_products` WHERE pid=$product_id");
    $rows = $querys->row_array();
    $en = $rows['en'];
    $boy = $rows['boy'];

    if($en!=0)
    {
        if($rows['paketleme_miktari']>0)
        {
            $rulo_miktarı=$qty/$rows['paketleme_miktari']; //322/46
        }
        else
        {

            $rulo_miktarı=1;
        }



    }
    else
    {


        $rulo_miktarı=$qty; //322/46
    }



    return $rulo_miktarı; // 7


}

function rulo_miktari_sorgula($id,$type)

{



    if($type=='invoice')
    {
        $table='geopos_invoice_items';
    }

    else
    {
        $table='geopos_purchase_items';
    }
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("$table.*,geopos_products.toplam_rulo");

    $ci->db->from("$table");

    $ci->db->where("$table.tid", $id);

    $ci->db->join('geopos_products', "$table.pid=geopos_products.pid", 'left');

    $query = $ci->db->get();

    $querys = $query->result_array();

    $data=0;

    foreach ($querys as $queryss)
    {
        if($queryss['toplam_rulo']!=0)
        {
            $data = 1;
        }

    }

    return $data;





}


function rulo_miktari_sorgula_purchase($id,$purchase_id)

{



    $table='geopos_purchase_items';

    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_purchase_items");

    $ci->db->where("geopos_purchase_items.tid", $purchase_id);
    $ci->db->where("geopos_purchase_items.pid", $id);


    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['rulo_miktari'];




}
function paketleme_tipi($id)

{


    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("geopos_paketleme_tipi.name");

    $ci->db->from("geopos_products");

    $ci->db->join('geopos_paketleme_tipi', "geopos_paketleme_tipi.id=geopos_products.paketleme_tipi");

    $ci->db->where("geopos_products.pid", $id);


    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['name'];




}

function paketleme_miktari($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("geopos_products.paketleme_miktari");

    $ci->db->from("geopos_products");
    $ci->db->where("geopos_products.pid", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['paketleme_miktari'];

}
function izin_durumu($val)
{
    $deger='';
    if($val==0)
    {
        $deger='Bekliyor';
    }
    else if($val==1)
    {
        $deger='Ödenişli Onaylandı';
    }
    else if($val==2)
    {
        $deger='Öz Habına Olarak Onaylandı';
    }
    else
    {
        $deger='İptal Edildi';
    }


    return $deger;

}
function metrekare_agirlik_hesapla($id,$qty)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("geopos_products.metrekare_agirligi");

    $ci->db->from("geopos_products");
    $ci->db->where("geopos_products.pid", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['metrekare_agirligi']/1000*$qty;

}
function project_status($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_project_status");
    $ci->db->where("geopos_project_status.id", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['name'];
}


function izin_status($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_izin_status");
    $ci->db->where("geopos_izin_status.id", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['name'];
}
function task_status($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_task_status");
    $ci->db->where("geopos_task_status.id", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['name'];
}
function task_statuss()
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_task_status");

    $query = $ci->db->get();

    $querys = $query->result_array();


    return $querys;
}

function project_derece($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_project_derece");
    $ci->db->where("geopos_project_derece.id", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['name'];
}

function invoice_type_desc($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_invoice_type");
    $ci->db->where("id", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['description'];
}
function bolum_getir($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_project_bolum");
    $ci->db->where("geopos_project_bolum.id", $id);

    $query = $ci->db->get();

    $querys = $query->row_array();


    return $querys['name'];
}
function bolum_to_asama($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id){
        $ci->db->select("*");

        $ci->db->from("geopos_project_bolum");
        $ci->db->where("geopos_project_bolum.id", $id);

        $query = $ci->db->get();

        $querys = $query->row_array();
        return $querys['name'];

    }
    else {
        return "-";
    }





}
function task_to_asama($id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id){
        $ci->db->select("*");

        $ci->db->from("geopos_milestones");
        $ci->db->where("geopos_milestones.id", $id);


        $query = $ci->db->get();

        $querys = $query->row_array();



        return $querys['name'];
    }
    else {
        return "-";
    }

}

function task_to_asama_parent($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $asamalar = $ci->db->query("SELECT * FROM `geopos_milestones` WHERE  id=$id")->row();
    if($asamalar){
        $name_asama = $asamalar->name;
    }
    else {
        $name_asama='';
    }


    if(!empty($asamalar->parent_id))
    {

        $p_asama = $ci->db->query("SELECT * FROM `geopos_milestones` WHERE  id=$asamalar->parent_id")->row();
        $name_asama=$p_asama->name.' | '.$name_asama;
    }

    return $name_asama;

}
function invoice_task_total($id)
{
    $ci =& get_instance();
    $ci->load->database();

//    $ci->db->select("SUM(total) as total,kur_degeri");
//
//    $ci->db->from("geopos_invoices");
//    $ci->db->where("geopos_invoices.task_id", $id);
//
//    $query = $ci->db->get();
//
//    $querys = $query->row_array();
//
//    $total= $querys['total']*$querys['kur_degeri'];


    $is_kalemi_details = $ci->db->query("SELECT * FROM geopos_todolist Where id = $id")->row();

    $total = $ci->db->query("SELECT SUM(subtotal) as total FROM geopos_project_items_gider Where asama_id = $is_kalemi_details->asama_id")->row()->total;

    return  $total;

}
function calisma_sekli($type_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_calisma_type");
    $ci->db->where("type", $type_id);

    $query = $ci->db->get();

    $querys = $query->result_array();

    return  $querys;

}

function numberClean($number)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    $number = str_replace($row['key2'], "", $number);
    $number = str_replace($row['key1'], ".", $number);
    return $number;
}




function asama_invoice($id,$project_id)
{
    $ci =& get_instance();
    $ci->load->database();
//
//    $ci->db->select("*");
//
//    $ci->db->from("geopos_milestones");
//    $ci->db->where("geopos_milestones.id=$id");
//    $ci->db->where("geopos_milestones.pid=$project_id");
//
//    $query = $ci->db->get();
//
//    $querys = $query->result_array();
//
//    $total=0;
//
//    foreach ($querys as $queryss)
//    {
//        $ci->db->select("SUM(total) as total,kur_degeri");
//
//        $ci->db->from("geopos_invoices");
//
//        $ci->db->where("geopos_invoices.asama_id", $queryss['id']);
//
//        $que = $ci->db->get();
//
//        $ques = $que->row_array();
//
//        $t=$ques['total']*$ques['kur_degeri'];
//
//        $total+=$t;
//    }

    $total = $ci->db->query("SELECT SUM(subtotal) as total FROM geopos_project_items_gider Where asama_id = $id")->row()->total;


    return  $total;

}

function bolum_invoice($id,$project_id)
{
    $ci =& get_instance();
    $ci->load->database();

  //  $ci->db->select("*");
//
//    $ci->db->from("geopos_project_bolum");
//    $ci->db->where("geopos_project_bolum.id=$id");
//    $ci->db->where("geopos_project_bolum.pid=$project_id");
//
//    $query = $ci->db->get();
//
//    $querys = $query->result_array();
//
//    $total=0;
//
//    foreach ($querys as $queryss)
//    {
//        $ci->db->select("SUM(total) as total,kur_degeri");
//
//        $ci->db->from("geopos_invoices");
//
//        $ci->db->where("geopos_invoices.bolum_id", $queryss['id']);
//
//        $que = $ci->db->get();
//
//        $ques = $que->row_array();
//
//        $t=$ques['total']*$ques['kur_degeri'];
//
//        $total+=$t;
//    }

    $total = $ci->db->query("SELECT SUM(subtotal) as total FROM geopos_project_items_gider Where bolum_id = $id")->row()->total;


    return  $total;

}

function is_kalemleri_invoice($id,$project_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_todolist");
    $ci->db->where("geopos_todolist.id=$id");
    $ci->db->where("geopos_todolist.proje_id=$project_id");

    $query = $ci->db->get();

    $querys = $query->result_array();

    $total=0;

    foreach ($querys as $queryss)
    {
        $ci->db->select("SUM(total) as total,kur_degeri");

        $ci->db->from("geopos_invoices");

        $ci->db->where("geopos_invoices.task_id", $queryss['id']);

        $que = $ci->db->get();

        $ques = $que->row_array();

        $t=$ques['total']*$ques['kur_degeri'];

        $total+=$t;
    }


    return  $total;

}

function gider_hesapla($string,$proje_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select("geopos_invoices.tax_oran,geopos_invoices.subtotal,geopos_invoices.kur_degeri,geopos_cost.name,geopos_cost.parent_id,geopos_invoices.method");
    $ci->db->from("geopos_invoices");
    $ci->db->join("geopos_cost",'geopos_invoices.masraf_id=geopos_cost.id','LEFT');
    $ci->db->where("geopos_invoices.proje_id", $proje_id);
    //$ci->db->where("geopos_invoices.invoice_type_id=", 21); // Masraf olduğuna dair

    $que = $ci->db->get();
    $ques = $que->result_array();

    $banka_komisyon=0;
    $nakit_komisyon=0;
    $toplam=0;
    $tax_t=0;
    foreach ($ques as $qs)
    {
        $ci->db->select("*");
        $ci->db->from("geopos_cost");
        $ci->db->where("id",$qs['parent_id']);
        $ci->db->where('name', $string);
        $que = $ci->db->get();
        if($que->num_rows()>0)
        {
            $t=($qs['subtotal']*$qs['kur_degeri']);
            $toplam=$toplam+($qs['subtotal']*$qs['kur_degeri']);
            $tax=$t*($qs['tax_oran']/100);
            $tax_t=$tax_t+$tax;
        }


    }
    return array('total'=>$toplam,'tax'=>$tax_t);

}
function proje_faturalari($proje_id)
{
    $ci =& get_instance();
    $ci->load->database();


    $ci->db->select("SUM(subtotal) as total,SUM(tax) as tax_t,kur_degeri");

    $ci->db->from("geopos_invoices");

    $ci->db->where("geopos_invoices.proje_id", $proje_id);
    $ci->db->where("geopos_invoices.invoice_type_id=", 2);

    $que = $ci->db->get();

    $ques = $que->row_array();

    $t=$ques['total']*$ques['kur_degeri'];
    $tax_t=$ques['tax_t']*$ques['kur_degeri'];

    return array('total'=>$t,'tax'=>$tax_t);
}
function proje_maliyeti($pid)
{
    $ci =& get_instance();
    $ci->load->database();


    $types=[2,24,41,29,30,4,7,12,14,31,33,35,36,37,38,43,45];
    $ci->db->select("SUM(total) as total,kur_degeri");

    $ci->db->from("geopos_invoices");

    $ci->db->where("geopos_invoices.proje_id", $pid);
    $ci->db->where_in("geopos_invoices.invoice_type_id", $types);
    $ci->db->where("geopos_invoices.status!=", 3);

    $que = $ci->db->get();

    $ques = $que->row_array();

    $t=$ques['total']*$ques['kur_degeri'];

    return $t;


}

function nakit_komisyonlari_proje($pid)
{
    $nakit_komisyon=0;
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("subtotal,kur_degeri");
    $ci->db->from("geopos_invoices");
    $ci->db->where("geopos_invoices.proje_id", $pid);
    $ci->db->where("geopos_invoices.invoice_type_id!=", 4);

    $que = $ci->db->get();

    $ques = $que->result_array();

    foreach ($ques as $qs)
    {
        $t=($qs['subtotal']*$qs['kur_degeri']);
        $nakit_komisyon=$nakit_komisyon+($t*0.0006);
    }



    return $nakit_komisyon;
}
function banka_komisyonlari_proje($pid)
{
    $banka_komisyon=0;
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("subtotal,kur_degeri");
    $ci->db->from("geopos_invoices");
    $ci->db->where("geopos_invoices.proje_id", $pid);
    $ci->db->where("geopos_invoices.invoice_type_id!=", 4);

    $que = $ci->db->get();

    $ques = $que->result_array();

    foreach ($ques as $qs)
    {
        $t=($qs['subtotal']*$qs['kur_degeri']);
        $banka_komisyon=$banka_komisyon+($t*0.0012);
    }



    return $banka_komisyon;
}

function satis_hesapla($product_id)
{


    $ci =& get_instance();
    $ci->load->database();
    $productlist=array();

    $urun=$ci->db->query("SELECT * FROM geopos_products WHERE pid = $product_id")->row_array();

    if($urun['parent_id']!=0)
    {
        $data = $ci->db->query("SELECT geopos_invoice_items.pid ,geopos_invoice_items.product as product_name, geopos_invoices.invoicedate,geopos_customers.company,geopos_invoices.invoice_no as tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoice_items.subtotal,geopos_invoices.invoice_type_desc
FROM geopos_invoice_items
LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid
LEFT JOIN geopos_customers ON geopos_customers.id=geopos_invoices.csd
WHERE geopos_invoice_items.pid='$product_id'
AND geopos_invoices.status!='canceled'

UNION ALL

SELECT geopos_purchase_items.pid, geopos_purchase_items.product as product_name, geopos_purchase.invoicedate,geopos_customers.company,geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase_items.subtotal,'Sipariş Fişi' as invoice_type_desc
FROM geopos_purchase_items
LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid
LEFT JOIN geopos_customers ON geopos_customers.id=geopos_purchase.csd
WHERE
geopos_purchase_items.pid='$product_id'
AND geopos_purchase.status=3
AND geopos_purchase.convert_to_invoice=0

UNION ALL

SELECT geopos_stok_cikis_items.product_id as pid,geopos_stok_cikis_items.product_name, geopos_stok_cikis.fis_date as invoicedate,geopos_customers.company,geopos_stok_cikis.fis_no as tid, geopos_stok_cikis_items.product_qty as qty,0 as price,0 as subtotal, if(type=1,'Çıkış Fişi','Giriş Fişi') as invoice_type_desc
FROM geopos_stok_cikis_items
LEFT JOIN geopos_stok_cikis ON geopos_stok_cikis.id=geopos_stok_cikis_items.stok_fis_id
LEFT JOIN geopos_customers ON geopos_customers.id=geopos_stok_cikis.customer_id
WHERE
geopos_stok_cikis_items.product_id=$product_id order by invoicedate asc")->result_array();

        if(isset($data))
        {
            $productlist[0] = $data;
        }


        return $productlist;

    }
    else
    {
        $parent_urun=$ci->db->query("SELECT * FROM geopos_products WHERE parent_id = $product_id")->result_array();
        $prodindex=0;
        foreach ($parent_urun as $prnt)
        {
            $product_id=$prnt['pid'];
            $data = $ci->db->query("SELECT geopos_invoice_items.pid, geopos_invoice_items.product as product_name, geopos_invoices.invoicedate,geopos_customers.company,geopos_invoices.invoice_no as tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoice_items.subtotal,geopos_invoices.invoice_type_desc
                        FROM geopos_invoice_items
                        LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid
                        LEFT JOIN geopos_customers ON geopos_customers.id=geopos_invoices.csd
                        WHERE geopos_invoice_items.pid='$product_id'
                        AND geopos_invoices.status!='canceled'

                        UNION ALL

                        SELECT geopos_purchase_items.pid, geopos_purchase_items.product as product_name, geopos_purchase.invoicedate,geopos_customers.company,geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase_items.subtotal,'Sipariş Fişi' as invoice_type_desc
                        FROM geopos_purchase_items
                        LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid
                        LEFT JOIN geopos_customers ON geopos_customers.id=geopos_purchase.csd
                        WHERE
                        geopos_purchase_items.pid='$product_id'
                        AND geopos_purchase.status=3
                        AND geopos_purchase.convert_to_invoice=0

                        UNION ALL

                        SELECT geopos_stok_cikis_items.product_id as pid, geopos_stok_cikis_items.product_name, geopos_stok_cikis.fis_date as invoicedate,geopos_customers.company,geopos_stok_cikis.fis_no as tid, geopos_stok_cikis_items.product_qty as qty,0 as price,0 as subtotal, if(type=1,'Çıkış Fişi','Giriş Fişi') as invoice_type_desc
                        FROM geopos_stok_cikis_items
                        LEFT JOIN geopos_stok_cikis ON geopos_stok_cikis.id=geopos_stok_cikis_items.stok_fis_id
                        LEFT JOIN geopos_customers ON geopos_customers.id=geopos_stok_cikis.customer_id
                        WHERE
                        geopos_stok_cikis_items.product_id=$product_id order by invoicedate asc")->result_array();

            if(isset($data))
            {



                $productlist[$prodindex] = $data;
                $prodindex++;
            }


        }



        return $productlist;
    }



}

function account_type()
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM geopos_account_type");
    $row = $query2->result_array();
    return $row;


}
function adresler()
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM adresler");
    $row = $query2->result();
    return $row;


}
function adres_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM adresler Where id=$id");
    $row = $query2->row();
    return $row;


}
function transaction_filter_tip()
{
    $ci =& get_instance();
    $ci->load->database();
    $type="3,4,12,14,17,18,19,20,27,28,33";
    $query2 = $ci->db->query("SELECT * FROM geopos_invoice_type Where id IN ($type)");
    $row = $query2->result();
    return $row;
}
function cari_pers_type()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM cari_pers_type");
    $row = $query2->result();
    return $row;


}
function cari_pers_type_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM cari_pers_type where id=$id");
    $row = $query2->row();
    return $row;


}
function account_type_islem()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_account_type where `value`=1");
    $row = $query2->result();
    return $row;


}
function lojistik_item_firma($id,$firma_id)
{
    $ci =& get_instance();
    $ci->load->database();

//    $query2 = $ci->db->query("SELECT * FROM  lojistik_satinalma_item  where `lojistik_id`=$id and firma_id=$firma_id");
//    $row = $query2->result();
//    return $row;

    $ci->db->select('lojistik_satinalma_item.*,geopos_projects.name as proje_name,araclar.name as arac_name,geopos_units.name as unit_name,geopos_customers.company');
    $ci->db->from('lojistik_satinalma_item');
    $ci->db->join('geopos_projects','lojistik_satinalma_item.proje_id=geopos_projects.id');
    $ci->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
    $ci->db->join('geopos_units','lojistik_satinalma_item.unit_id=geopos_units.id');
    $ci->db->join('geopos_customers','lojistik_satinalma_item.firma_id=geopos_customers.id');
    $ci->db->where('lojistik_satinalma_item.lojistik_id',$id);
    $ci->db->where('lojistik_satinalma_item.firma_id',$firma_id);
    $ci->db->order_by('lojistik_satinalma_item.location', 'DESC');
    $query = $ci->db->get();
    return $query->result();


}
function lojistik_item_location($id,$sf_item_id,$tip)
{
    $ci =& get_instance();
    $ci->load->database();


    $query = $ci->db->query("SELECT * FROM satinalma_location Where sf_item_id=$sf_item_id and lojistik_id = $id GROUP BY sf_item_id");

    $array=[];
    if($query->num_rows()){
        foreach ($query->result() as $item){
            $ci->db->select('lojistik_satinalma_item.*,geopos_projects.name as proje_name,araclar.name as arac_name,geopos_units.name as unit_name,geopos_customers.company');
            $ci->db->from('lojistik_satinalma_item');
            $ci->db->join('geopos_projects','lojistik_satinalma_item.proje_id=geopos_projects.id');
            $ci->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
            $ci->db->join('geopos_units','lojistik_satinalma_item.unit_id=geopos_units.id');
            $ci->db->join('geopos_customers','lojistik_satinalma_item.firma_id=geopos_customers.id','LEFT');
            $ci->db->join('satinalma_location','lojistik_satinalma_item.id=satinalma_location.sf_item_id');
            $ci->db->where('lojistik_satinalma_item.lojistik_id',$id);
            $ci->db->where('lojistik_satinalma_item.id',$item->sf_item_id);
            $ci->db->order_by('lojistik_satinalma_item.location', 'DESC');
            $query = $ci->db->get();
            if($query->num_rows()){
                $array['items'][] = ['result'=>$query->row(),'l_id'=>$item->id];
            }

        }
    }

    return $array;




//    $ci->db->select('lojistik_satinalma_item.*,geopos_projects.name as proje_name,araclar.name as arac_name,geopos_units.name as unit_name,geopos_customers.company');
//    $ci->db->from('lojistik_satinalma_item');
//    $ci->db->join('geopos_projects','lojistik_satinalma_item.proje_id=geopos_projects.id');
//    $ci->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
//    $ci->db->join('geopos_units','lojistik_satinalma_item.unit_id=geopos_units.id');
//    $ci->db->join('geopos_customers','lojistik_satinalma_item.firma_id=geopos_customers.id');
//    $ci->db->where('lojistik_satinalma_item.lojistik_id',$id);
//    $ci->db->where('lojistik_satinalma_item.location',"$location");
//    $ci->db->order_by('lojistik_satinalma_item.location', 'DESC');



}

function location_name($sf_item_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT locations.* FROM satinalma_location INNER JOIN  locations ON satinalma_location.location_id = locations.id where sf_item_id=$sf_item_id");
 $html='';
    if($query2->num_rows()){
        foreach ($query2->result() as $value){
            $html.=$value->location.' ';
        }

    }
    return $html;


}
function location_name_sorgu($id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT locations.* From locations where id=$id");
 $html='';
    if($query2->num_rows()){

        return  $query2->row();

    }
    return $html;


}
function location_name_($sf_item_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT locations.* FROM satinalma_location INNER JOIN  locations ON satinalma_location.location_id = locations.id where sf_item_id=$sf_item_id");
 $html='';
    if($query2->num_rows()){
        return  $query2->result();
    }

    else {
        return $html;
    }


}


function account_type_sorgu($id)
{
    $ci =& get_instance();
    $ci->load->database();


    if(isset($id))
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_account_type where id=$id");
        $row = $query2->row_array();
        return $row['name'];
    }
    else {
        return 'Metod Seçilmedi';
    }



}
function account_count($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_accounts where loc=$id");
    $row = $query2->num_rows();
    return $row;


}
function all_account()
{
    $ci =& get_instance();
    $ci->load->database();
    $loc =   $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_accounts Where status=1 and loc=$loc");
    $row = $query2->result();
    return $row;


}

function personel_account($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $loc =   $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_accounts where eid= $id and status = 1  and loc=$loc");
    $row = $query2->result_array();
    return $row;


}
function hesap_getir($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_accounts where id=$id");
    $row = $query2->row();
    return $row;


}

function ozet_devir($tip,$string)
{
    //0;alış faturaları 1;Satış faturaları 2;siparişler 3;teklifler;4;kasalar
    $ci =& get_instance();
    $ci->load->database();
    date_default_timezone_set('Asia/Baku');

    //$date1 = dateen($ci->input->post("from-date"));

    //if( empty( $date1 ) ) $date1 = date('Y-m-d');
    $date1 = date('Y-m-d');


    if($string=='devir')
    {
        $whr=("DATE( invoicedate ) < '" . datefordatabasefilter($date1) . "' and ");
        $whr2=("DATE( invoicedate ) < '" . datefordatabasefilter($date1) . "' and ");
    }
    else if($string=='bakiye')
    {

        $whr=("DATE( invoicedate ) <= '" . datefordatabasefilter($date1) . "' and
             DATE( invoicedate ) >= '" . datefordatabasefilter($date1) . "' and ");

        $whr2=("DATE( invoicedate ) <= '" . datefordatabasefilter($date1) . "' and
             DATE( invoicedate ) >= '" . datefordatabasefilter($date1) . "' and ");

    }



    $table='';
    if($tip==0)
    {
        $table='geopos_invoices';
        $whr.=("invoice_type_id = 2");
        $query= $ci->db->select("(if(SUM( total*kur_degeri),SUM( total*kur_degeri),0)) as total ")
            ->from($table)
            ->where($whr)
            ->get()
            ->row();
        return
            array(
                'total'=>$query->total
            );
    }
    else if($tip==1)
    {
        $table='geopos_invoices';
        $whr.=("invoice_type_id = 1");
        $query= $ci->db->select("(if(SUM( total*kur_degeri),SUM( total*kur_degeri),0)) as total ")
            ->from($table)
            ->where($whr,null,false)
            ->get()
            ->row();
        return
            array('total'=>$query->total);
    }
    else if($tip==2)
    {
        $table='geopos_purchase';
        $whr.=("status = 3");
        $query= $ci->db->select("(if(SUM( total),SUM( total),0)) as total ")
            ->from($table)
            ->where($whr)
            ->get()
            ->row();
        return
            array('total'=>$query->total);
    }
    else if($tip==3)
    {
        $table='geopos_quotes';
        $whr.=("status = 'accepted'");
        $query= $ci->db->select("(if(SUM( total),SUM( total),0)) as total ")
            ->from($table)
            ->where($whr,null,false)
            ->get()
            ->row();
        return
            array('total'=>$query->total);

    }
    else if($tip==4)
    {
        $bakiye=0;
        $loc=$ci->aauth->get_user()->loc;
        $borc=0;
        $alacak=0;


        if($string=='devir')
        {
            $wher=("  DATE( invoicedate ) < '" . datefordatabasefilter($date1) . "' and geopos_invoices.masraf_id!='' and ");
        }
        else if($string=='bakiye')
        {

            $wher=("DATE( invoicedate ) <= '" . datefordatabasefilter($date1) . "' and
             DATE( invoicedate ) >= '" . datefordatabasefilter($date1) . "' and   geopos_invoices.masraf_id!='' and");

        }


        $query = $ci->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices INNER JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id  WHERE
             geopos_invoice_type.type_value = 'transaction'
             and geopos_invoices.acid is not null and $wher geopos_invoices.loc=$loc");

        $row = $query->result_array();
        foreach ($row as $rows)
        {
            $bakiye+=$rows['alacak']-$rows['borc'];
            $alacak+=$rows['alacak'];
            $borc+=$rows['borc'];
        }

        return
            array(
                'total'=>$bakiye,
                'borc'=>$borc,
                'alacak'=>$alacak,
            );
    }
    if($tip==5) {
        $table = 'geopos_invoices';
        $whr .= ("invoice_type_id =1 ");
        $query = $ci->db->select("(if(SUM( tax*kur_degeri),SUM( tax*kur_degeri),0)) as total ")
            ->from($table)
            ->where($whr)
            ->get()
            ->row();


        $whr2 .= ("invoice_type_id =2 ");
        $query2 = $ci->db->select("(if(SUM( tax*kur_degeri),SUM( tax*kur_degeri),0)) as total ")
            ->from($table)
            ->where($whr2)
            ->get()
            ->row();

        $alis_kdv_total = $query->total;
        $satis_kdv_total = $query2->total;
        $devir=$satis_kdv_total-$alis_kdv_total;

        return array(
            'total'=>$devir,
            'satis_kdv_total'=>$satis_kdv_total,
            'alis_kdv_total'=>$alis_kdv_total

        );

    }





}
function cariler_bakiye_alacak_borc($string,$search='',$cust_group='')
{
    $ci =& get_instance();
    $ci->load->database();
    $where='';
    if($search!='')
    {
        $where="and  geopos_customers.company LIKE'%$search%'";
    }

    if($cust_group!='')
    {
        $where.="and  geopos_customers.musteri_tipi=$cust_group";
    }

    //date
    $baslangic_date = "2022-03-31 23:20:35";
    //date

    $query2 = $ci->db->query("SELECT  geopos_customers.id as customer_id,
        geopos_customers.company,geopos_invoice_type.description,
        geopos_invoices.invoicedate,geopos_invoices.invoice_type_id,
        IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL)) as borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL))as alacak,
        geopos_invoices.total,geopos_invoices.kur_degeri,
        geopos_invoice_type.transactions FROM geopos_invoices
        INNER JOIN geopos_customers on geopos_invoices.csd=geopos_customers.id
        LEFT JOIN geopos_invoice_type On geopos_invoices.invoice_type_id=geopos_invoice_type.id
        where geopos_invoice_type.id IN(1,2,3,4,17,18,19,20,24) and geopos_invoices.invoicedate<= '$baslangic_date' and geopos_invoices.status!=3
        $where
        GROUp BY geopos_invoices.csd ");


    if($string=='ekstre')
    {
        $row = $query2->result_array();
        return $row;
    }
    else if($string=='count')
    {

        $row = $query2->num_rows();
        return $row;
    }

    else if($string=='filter')
    {

        $row = $query2->num_rows();
        return $row;
    }

}

function cariler_kdv_total($string,$search='')
{
    $ci =& get_instance();
    $ci->load->database();
    $where='';
    if($search!='')
    {
        $where=" and  geopos_customers.company LIKE'%$search%'";
    }

    $query2 = $ci->db->query("SELECT
        geopos_customers.id as customer_id,geopos_customers.company,geopos_invoice_type.description,
        geopos_invoices.invoicedate,geopos_invoices.invoice_type_id,
        IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.tax,NULL)) as satis_faturasi_kdv_total,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.tax,NULL))as alis_faturasi_kdv_total,
        geopos_invoices.total,geopos_invoices.kur_degeri,
        geopos_invoice_type.transactions FROM geopos_invoices
        INNER JOIN geopos_customers on geopos_invoices.csd=geopos_customers.id
        INNER JOIN geopos_invoice_type On geopos_invoices.invoice_type_id=geopos_invoice_type.id
        where (geopos_invoice_type.type_value='fatura'  OR geopos_invoice_type.id=19)
        $where
        GROUp BY geopos_invoices.csd ");




    if($string=='ekstre')
    {
        $row = $query2->result_array();
        return $row;
    }
    else if($string=='count')
    {

        $row = $query2->num_rows();
        return $row;
    }

    else if($string=='filter')
    {

        $row = $query2->num_rows();
        return $row;
    }

}

function saatler()
{
    $saat=array();
    for ($j=1;$j<25;$j++)
    {

        for ($i=0;$i<60;$i++)
        {
            if($j<10) {
                if($i<10)
                {
                    $saat[]='0'.$j.':0'.$i;
                }
                else
                {
                    $saat[]='0'.$j.':'.$i;
                }

            }
            else
            {
                if($i<10)
                {
                    $saat[]=$j.':0'.$i;
                }
                else
                {
                    $saat[]=$j.':'.$i;
                }
            }

        }
    }


    $sayi=count($saat);

    for($i=0;$i<$sayi;$i++)
    {
        $deger=$saat[$i];
        echo "<option value='$deger'>$deger</option>";

    }




}

function account_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_accounts WHERE id=$id");
    $row = $query2->row();
    return $row;
}
function not_account()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_accounts WHERE id IN(46,45,44,36,37) ");
    $row = $query2->result_array();
    return $row;
}

function not_account_acik()
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_accounts WHERE id IN(46,45,44,36,37) ");
    $row = $query2->result_array();
    return $row;
}

function account_method_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT geopos_account_type.name,geopos_accounts.holder from `geopos_accounts` INNER JOIN `geopos_account_type` ON
      geopos_accounts.`account_type`=geopos_account_type.id  where geopos_accounts.id=$id");
    $row = $query2->row_array();
    return $row;


}

function masraf_cari_personel_fatura($tip,$cari_personel_fatura_id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($tip==1) // Cari
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_customers WHERE id=$cari_personel_fatura_id");
        $row = $query2->row_array();
        return $row['company'];
    }
    else  if($tip==2)  //Personel
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_employees WHERE id=$cari_personel_fatura_id");
        $row = $query2->row_array();
        return $row['name'];
    }
    else  if($tip==3)  //Fatura
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_invoices WHERE id=$cari_personel_fatura_id");
        $row = $query2->row_array();
        return $row['invoice_no'];
    }
    else if($tip==0)
    {
      return '';
    }
    else
    {
        return '';
    }


}

function amountExchange_s($number, $id = 0, $loc = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($loc > 0 && $id == 0) {
        $query = $ci->db->query("SELECT cur FROM geopos_locations WHERE id='$loc' LIMIT 1");
        $row = $query->row_array();
        $id = $row['cur'];
    }
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM geopos_currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $rate = $row['rate'];
        $dec_point = $row['dpoint'];
        $totalamount = $rate * $number;
        $decimal_after = $row['decim'];
        $totalamount = number_format($totalamount, $decimal_after, $dec_point, '');
        return $totalamount;
    } else {
        $query = $ci->db->query("SELECT currency FROM geopos_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        $number = number_format($number, $row['url'], $row['key1'], '');
        return $number;
    }

}


function masraf_name($id=0)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id!=''){
        $query2 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$id");
        if($query2->num_rows()>0){
            $row = $query2->row_array();
            return $row['name'];
        }
        else {
            return '';
        }
    }
    else {
        return '';
    }


}
function ana_masraf_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $name='';
    $query2 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$id");
    if($query2->num_rows()){
        $row = $query2->row_array();
        $parent_id= $row['parent_id'];
        if($parent_id){
            $query3 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$parent_id");
            $row3 = $query3->row_array();
            $name =$row3['name'];
        }


    }

    return $name;
}
function ana_masraf_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$id");
    $row = $query2->row_array();
    $parent_id= $row['parent_id'];

    $query3 = $ci->db->query("SELECT * FROM geopos_cost WHERE id=$parent_id");
    $row3 = $query3->row();
    return $row3;
}
function ihracat_dosyaları()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_ihracat");
    $row = $query2->result();
    return $row;

}
function fatura_details($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_invoices` WHERE id=$id");
    $row = $query2->row();
    return $row;

}
function ihracat_urunleri($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT geopos_invoice_items.*,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
geopos_invoices.kur_degeri,geopos_invoices.para_birimi FROM geopos_invoices INNER JOIN geopos_invoice_items ON geopos_invoices.id=geopos_invoice_items.tid WHERE geopos_invoices.dosya_id=$id and geopos_invoices.invoice_type_id=2   ");
    $row = $query2->result();
    return $row;

}
function ihracat_giderleri($id,$gumrukcu_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT geopos_invoice_items.*,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,geopos_invoices.notes FROM geopos_invoices INNER JOIN geopos_invoice_items ON geopos_invoices.id=geopos_invoice_items.tid WHERE geopos_invoices.dosya_id=$id
and geopos_invoices.invoice_type_id=24  and geopos_invoices.csd!=$gumrukcu_id  ");
    $row = $query2->result();
    return $row;

}
function gumrukcu_tahsilat_odeme($id,$gumrukcu_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("
SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,geopos_invoices.invoice_no,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices LEFT JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id  WHERE geopos_invoices.dosya_id=$id
 and geopos_invoices.csd=$gumrukcu_id and (geopos_invoices.invoice_type_id=3 or
 geopos_invoices.invoice_type_id=4 or geopos_invoices.invoice_type_id=24) GROUP BY geopos_invoices.invoicedate ASC");
    $row = $query2->result();
    return $row;

}


function ihracat_toplam_gider($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT SUM(geopos_invoices.total*geopos_invoices.kur_degeri) as gider_total FROM geopos_invoices  WHERE geopos_invoices.dosya_id=$id and geopos_invoices.invoice_type_id=24 ");
    $row = $query2->row();
    return $row->gider_total;

}

function son_alis_fiyati($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("select * from geopos_product_price where product_id=$id and invoice_id is not null ORDER BY id DESC LIMIT 1");



    $query3 = $ci->db->query("Select geopos_invoice_items.*,geopos_invoices.kur_degeri From geopos_invoices Inner JOIN geopos_invoice_items On geopos_invoices.id=geopos_invoice_items.tid
Where geopos_invoices.invoice_type_id=2 and geopos_invoice_items.pid=$id ORDER BY id DESC LIMIT 1");

    if($query2->num_rows()>0)
    {
        $row = $query2->row_array();
        return $row['price']*$row['kur_degeri'];
    }
    else if($query3->num_rows()>0)
    {

        $row2 = $query3->row_array();

        return $row2['price']*$row2['kur_degeri'];
    }
    else
    {
        return 0;
    }



}

function ortalama_alis_fiyati($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $total_qty=0;
    $total_price=0;

    $query2 = $ci->db->query("select * from geopos_product_price where product_id=$id and invoice_id is not null ORDER BY id DESC");
    $query3 = $ci->db->query("Select geopos_invoice_items.*,geopos_invoices.kur_degeri From geopos_invoices Inner JOIN geopos_invoice_items On geopos_invoices.id=geopos_invoice_items.tid
Where geopos_invoices.invoice_type_id=2 and geopos_invoice_items.pid=$id ORDER BY id DESC");


    if($query2->num_rows()>0)
    {
        $row = $query2->result();
        foreach ($row as $prd)
        {

            $total_qty+=$prd->quantity;
            $total_price+=$prd->price*$prd->kur_degeri*$prd->quantity;


        }

        if($total_price!=0)
        {
            return $total_price/$total_qty;
        }
        else
        {
            return 0;
        }

    }
    else if($query3->num_rows()>0)
    {
        $row = $query3->result();

        foreach ($row as $prd)
        {

            $total_qty+=$prd->qty;
            $total_price+=$prd->price*$prd->kur_degeri*$prd->qty;


        }

        if($total_price!=0)
        {
            return $total_price/$total_qty;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 0;
    }


}

function son_maliyet_fiyati($son_alis_fiyati,$id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query=$ci->db->query("Select * FROM geopos_product_price Where product_id=$id and invoice_id is null  ORDER BY id DESC LIMIT 1 ");
    if($query->num_rows()>0)
    {
        $prd=$query->row();
        return ($prd->price*$prd->kur_degeri)+$son_alis_fiyati;
    }
    else
    {
        return $son_alis_fiyati;
    }
}

function ortalama_maliyet_fiyati($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $maliyet_fiyati=0;
    $total_qty=0;

    $query=$ci->db->query("SELECT * FROM geopos_ihracat_maliyet_dagitim Where product_id=$id");

    if($query->num_rows()>0)
    {
        $prd=$query->result();
        foreach ($prd as $prds)
        {
            $maliyet_fiyati+=$prds->toplam_alis_maliyet_fiyati;
            $total_qty+=$prds->quantity;
        }

        if($maliyet_fiyati!=0)
        {
            return $maliyet_fiyati/$total_qty;
        }
        else
        {
            return 0;
        }

    }
    else
    {
        return 0;
    }

}


function son_satis_fiyati($id)
{
    $ci =& get_instance();
    $ci->load->database();



    $query3 = $ci->db->query("Select geopos_invoice_items.*,geopos_invoices.kur_degeri From geopos_invoices Inner JOIN geopos_invoice_items On geopos_invoices.id=geopos_invoice_items.tid
Where geopos_invoices.invoice_type_id=1 and geopos_invoice_items.pid=$id ORDER BY id DESC LIMIT 1");

    if($query3->num_rows()>0)
    {

        $row2 = $query3->row_array();

        return $row2['price']*$row2['kur_degeri'];
    }
    else
    {
        return 0;
    }



}
function dagitim_sekli($id)
{
    $ci =& get_instance();
    $ci->load->database();



    $query3 = $ci->db->query("SELECT * FROM geopos_ihracat_maliyet_dagitim WHERE ihracat_id=$id LIMIT 1");

    if($query3->num_rows()>0)
    {

        $row2 = $query3->row_array();

        return $row2['dagilim_sekli'];
    }
    else
    {
        return 0;
    }


}
function ihracat_maliyet_dagitim($id)
{
    $ci =& get_instance();
    $ci->load->database();



    $query3 = $ci->db->query("SELECT * FROM geopos_ihracat_maliyet_dagitim WHERE ihracat_id=$id ");

    if($query3->num_rows()>0)
    {

        $row2 = $query3->result_array();

        return $row2;
    }
    else
    {
        return 0;
    }


}
function maliyet_dagilim_ogren($ihracat_id,$product_id)
{
    $ci =& get_instance();
    $ci->load->database();



    $query3 = $ci->db->query("SELECT * FROM geopos_ihracat_maliyet_dagitim WHERE ihracat_id=$ihracat_id and product_id=$product_id ");

    if($query3->num_rows()>0)
    {

        $row2 = $query3->row_array();

        return $row2;
    }
    else
    {
        return 0;
    }


}

function is_kalemleri_status()
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database

    $query2 = $ci->db->query("SELECT * FROM geopos_is_kalemleri_status");
    $row = $query2->result();
    return $row;



}
function is_kalemleri_status_id($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_is_kalemleri_status WHERE id=$id");
    $rows = $query1->row_array();
    return $rows;

}
function son_alis_olan_firma($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM `geopos_invoice_items` WHERE `pid` =$id GROUP BY pid");
    $rows = $query1->row();
    if(isset($rows))
    {
        $invoice_id=$rows->tid;
        $query2 = $ci->db->query("SELECT geopos_customers.company FROM geopos_invoices INNER JOIN geopos_customers on geopos_invoices.csd=geopos_customers.id WHERE geopos_invoices.id=$invoice_id");
        $rows = $query2->row();
        return $rows->company;

    }
    else
    {
        return '';
    }


}
function talep_item_alt($id,$product_name,$limit)
{
    $ci =& get_instance();
    $ci->load->database();
    //$query1 = $ci->db->query("SELECT * FROM geopos_talep_items WHERE id=$id LIMIT $limit,1");
    $query1 = $ci->db->query("SELECT * FROM geopos_talep_items WHERE `product_name`='$product_name' and geopos_talep_items.tip=$id  LIMIT $limit,1");
    if($query1->num_rows()>0)
    {
        $rows = $query1->row_array();
        return $rows;
    }
    else
    {
        return array('firma'=>'','firma_tel'=>'','price'=>'','subtotal'=>'','teklif_tarih_no'=>'','odeme_sekli'=>'','odeme_tarihi'=>'');
    }


}
function invoice_to_talep($invoice_id,$tip){
    $ci =& get_instance();
    $ci->load->database();


    $html=false;
    if($tip!=0){
        $query1 = $ci->db->query("SELECT * FROM invoice_to_talep WHERE tip=$tip and invoice_id = $invoice_id");
    }
    else {
        $query1 = $ci->db->query("SELECT * FROM invoice_to_talep WHERE invoice_id = $invoice_id");
    }

    if($query1->num_rows()>0){
        $html ='<li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                        <span class="d-none d-lg-inline-block ml-2">Talepler</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                        <div class="dropdown-content-body p-2">
                            <div class="row no-gutters">
                    ';
        foreach ($query1->result() as $rows){
            if($rows->tip==1) // Malzeme Talep Formu
            {
                $html.='  <div class="col-4">
                                    <a href="/requested/view?id='.$rows->talep_id.'" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="fa fa-list fa-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Malzeme Talep Formu</div>
                                    </a>
                                </div>';
            }
            else if($rows->tip==2) // Satınalma  Formu
            {
                $html.='  <div class="col-4">
                                    <a href="/form/satinalma_view?id='.$rows->talep_id.'" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="fa fa-list fa-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Satınalma Talep Formu</div>
                                    </a>
                                </div>';
            }

            else if($rows->tip==5) // Avans  Formu
            {
                $html.='  <div class="col-4">
                                    <a href="/form/avans_view?id='.$rows->talep_id.'" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="fa fa-list fa-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Avans Talep Formu</div>
                                    </a>
                                </div>';

            }
            else if($rows->tip==6) // Avans  Formu
            {

                $html.='  <div class="col-4">
                                    <a href="/form/odeme_talep_view?id='.$rows->talep_id.'" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="fa fa-list fa-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Ödeme Talep Formu</div>
                                    </a>
                                </div>';

            }
            else if($rows->tip==4) // Gider  Formu
            {
                $html.='  <div class="col-4">
                                    <a href="/form/gider_view?id='.$rows->talep_id.'" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="fa fa-list fa-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Gider Talep Formu</div>
                                    </a>
                                </div>';

            }




        }
        $html.='</div></div></div></li>';
    }
        return $html;


}

function talep_to_odeme($invoice_id){
    $ci =& get_instance();
    $ci->load->database();


    $html=false;

    $query1 = $ci->db->query("SELECT * FROM geopos_invoice_transactions WHERE invoice_id = $invoice_id");

    if($query1->num_rows()>0){
        $html ='<div class="btn-group">
                        <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> İşlemler</button>
                        <div class="dropdown-menu">';
        foreach ($query1->result() as $rows){

            $html.='<a href="/transactions/view?id='.$rows->transaction_id.'"  class="btn btn-success btn-sm">İşlemi Görüntüle</a>
                            <div class="dropdown-divider"></div>';


        }
        $html.='</div></div>';
    }
    return $html;


}

function invoice_to_talep_sorgu($invoice_id,$tip){
    $ci =& get_instance();
    $ci->load->database();

    $result=false;
    $query1 = $ci->db->query("SELECT talep_id FROM invoice_to_talep WHERE tip=$tip and invoice_id = $invoice_id");
    if($query1->num_rows()>0) {
       foreach ($query1->result() as $row){
           $result[]=$row->talep_id;
       }
    }
    return $result;


}
function talep_list($type)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_talep WHERE tip=$type and  `status` NOT IN (4,6)");
    $rows = $query1->result();
    return $rows;

}


function talep_list_onay($type)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=[];
    $query1 = $ci->db->query("SELECT * FROM geopos_talep WHERE tip=$type and  `status` IN (5,3)");
    $rows = $query1->result();
    foreach ($rows as $values){
        $kontrol = satin_alma_formu_list($values->id);
        if($kontrol==''){
            $data[]=$values;
        }

    }
    return $data;

}
function talep_detail($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$id");
    $rows = $query1->row();
    $href='';
    if($rows->tip==1) // Malzeme Talep Formu
    {
        $href = "<a class='btn btn-success' href='/requested/view?id=".$id."'>Talep Görüntüle</a> ";
    }
    else if($rows->tip==2) // Satınalma  Formu
    {
        $href = "<a class='btn btn-success' href='/form/satinalma_view?id=".$id."'>Talep Görüntüle</a> ";
    }
    else if($rows->tip==5) // Avans  Formu
    {
        $href = "<a class='btn btn-success' href='/form/avans_view?id=".$id."'>Talep Görüntüle</a> ";
    }
    else if($rows->tip==4) // Gider  Formu
    {
        $href = "<a class='btn btn-success' href='/form/gider_view?id=".$id."'>Talep Görüntüle</a> ";
    }
    return $href;

}

function talep_details($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_talep WHERE id=$id");
    $rows = $query1->row();
    return $rows;

}
function talep_list_finance()
{
    $ci =& get_instance();
    $ci->load->database();
    //$query1 = $ci->db->query("SELECT * FROM geopos_talep where `status` IN (1,2,3,5,7)");
    $query1 = $ci->db->query("SELECT * FROM geopos_talep");
    $rows = $query1->result();
    return $rows;

}
function ihale_list()
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_ihale");
    $rows = $query1->result();
    return $rows;

}
function talep_list_proje($type,$proje_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $data_array=array();

    $query1 = $ci->db->query("SELECT * FROM geopos_talep WHERE tip=$type and proje_id=$proje_id")->result();
    foreach ($query1 as $querys)
    {
        $data_array[]=array('id'=>$querys->id,'talep_no'=>$querys->talep_no);
        /*
        $query_satin = $ci->db->query("SELECT * FROM geopos_talep WHERE tip=2 and proje_id=$proje_id")->result();
        foreach ($query_satin as $st)
        {
            if($st->malzeme_talep_form_id!=$querys->id)
            {

            }
        }
        */
    }
    return $data_array;

}
function kdv_odemesi($val,$id)
{
    $ci =& get_instance();
    $ci->load->database();
    $total=0;
    $kdv = $ci->db->query("SELECT * FROM geopos_customers WHERE id=$id")->row()->kdv_orani;
    $kdvs = 18;


    if($val==1) // Ödenen Esas Meblağ
    {
        $query1 = $ci->db->query("SELECT total,kur_degeri,tax_oran FROM geopos_invoices WHERE csd=$id and method=3 and invoice_type_id IN (4,17) ");
        $rows = $query1->result();
        foreach ($rows as $r)
        {
            if($r->tax_oran==0){
                $total=0;
            }
            else {
                $total+=$r->total*$r->kur_degeri;
            }

        }
    }
    else if($val==2) // Gönderilmesi gereken kdv
    {
        if($kdv!=0)
        {
            $esas_meb=0;
            $query1 = $ci->db->query("SELECT total,kur_degeri,tax_oran FROM geopos_invoices WHERE csd=$id and method=3 and invoice_type_id IN (4,17) ");
            $rows = $query1->result();
            foreach ($rows as $r)
            {
                if($r->tax_oran==0){
                    $esas_meb=0;
                }
                else {
                    $esas_meb+=$r->total*$r->kur_degeri;
                }

            }

            $total=$esas_meb*($r->tax_oran/100);
        }
        else
        {
            $total=0;
        }

    }
    else if($val==3) // KDV Ödemeleri
    {
        if($kdv!=0)
        {
            $query1 = $ci->db->query("SELECT total,kur_degeri,tax_oran FROM geopos_invoices WHERE csd=$id and method=4 and invoice_type_id=19");
            $rows = $query1->result();
            foreach ($rows as $r)
            {
                $total+=$r->total*$r->kur_degeri;
            }
        }
        else
        {
            $total=0;
        }
    }

    else if($val==4) // Bakiye
    {

        if($kdv!=0) {

            $esas_meb = 0;
            $gonderilmesi_gereken_kdv = 0;
            $gonderilen_kdv = 0;
            $query1 = $ci->db->query("SELECT total,kur_degeri,tax_oran FROM geopos_invoices WHERE csd=$id and method=3 and invoice_type_id IN (4,17) ");
            $rows = $query1->result();
            foreach ($rows as $r) {
                $esas_meb += $r->total * $r->kur_degeri;
            }

            $gonderilmesi_gereken_kdv = $esas_meb * ($r->tax_oran / 100);

            $query2 = $ci->db->query("SELECT total,kur_degeri,tax_oran FROM geopos_invoices WHERE csd=$id and method=4 and invoice_type_id=19");
            $rows = $query2->result();
            foreach ($rows as $r) {
                $gonderilen_kdv += $r->total * $r->kur_degeri;
            }

            $total = $gonderilmesi_gereken_kdv - $gonderilen_kdv;
        }
        else
        {
            $total=0;
        }

    }

    return $total;

}

function cari_bazli_proje($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $parent_id=$ci->db->query("SELECT * FROM geopos_customers WHERE parent_id=$id");

    $array=array($id);
    if($parent_id->num_rows()>0)
    {

        foreach ($parent_id->result() as $prt)
        {

            $array[]=$prt->id;
        }



    }

    $str = implode(",",$array);
    $w="geopos_invoices.csd IN ($str)";



    $query1 = $ci->db->query("SELECT * FROM geopos_invoices INNER JOIN geopos_projects ON geopos_invoices.proje_id=geopos_projects.id WHERE $w GROUP  BY geopos_invoices.proje_id");
    $rows = $query1->result();
    return $rows;

}
function min_satin_alima($talep_id,$product_name)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM `geopos_talep_items` WHERE `tip` = $talep_id and product_name='$product_name' and  firma is NOT NULL ORDER BY `geopos_talep_items`.`price` ASC LIMIT 1");
    $rows = $query1->row_array();
    return $rows;

}
function ort_satin_alma($talep_id,$product_name)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT AVG(price) as ort FROM `geopos_talep_items` WHERE `tip` = $talep_id and product_name='$product_name' ORDER BY `geopos_talep_items`.`price`");
    $rows = $query1->row_array();
    return $rows['ort'];

}

function ihale_tipi()
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM ihale_sekli");
    $rows = $query1->result();
    return $rows;
}
function ihale_fiyat_bul($firma_id,$item_id,$oturum_id,$ihale_id)
{
    if($oturum_id==0)
    {
        $oturum_id=1;
    }
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_ihale_items_firma WHERE firma_id=$firma_id and item_id=$item_id and oturum=$oturum_id and ihale_id=$ihale_id");
    $rows = $query1->row()->fiyat;
    return $rows;
}
function ihale_details($firma_id,$item_id,$oturum_id,$ihale_id,$string)
{
    if($oturum_id==0)
    {
        $oturum_id=1;
    }
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_ihale_items_firma WHERE firma_id=$firma_id and item_id=$item_id and oturum=$oturum_id and ihale_id=$ihale_id");
    $rows = $query1->row()->$string;
    return $rows;
}

function firma_total_teklif($firma_id,$ihale_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $oturum = $ci->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE `ihale_id` = $ihale_id AND `firma_id` = $firma_id GROUP BY oturum ORDER BY `geopos_ihale_items_firma`.`oturum` DESC LIMIT 1")->row()->oturum;
    $query1 = $ci->db->query("SELECT SUM(fiyat) as total FROM `geopos_ihale_items_firma` WHERE ihale_id=$ihale_id and firma_id=$firma_id and oturum=$oturum");
    $rows = $query1->row();
    return $rows;
}

function ihale_tipi_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM ihale_sekli WHERE id=$id");
    $rows = $query1->row();
    return $rows->name;
}
function ihale_to_customer($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_ihale_to_cari WHERE ihale_id=$id");
    $rows = $query1->result();
    return $rows;
}

function month_name($number){
    $mont=[
        1=>'Ocak',
        2=>'Şubat',
        3=>'Mart',
        4=>'Nisan',
        5=>'Mayıs',
        6=>'Haziran',
        7=>'Temmuz',
        8=>'Ağustos',
        9=>'Eylül',
        10=>'Ekim',
        11=>'Kasım',
        12=>'Aralık',
    ];

    $ay = $mont[date($number)];

    return $ay ;

}

function numaric_update($id){
    $ci =& get_instance();
    $ci->load->database();
    $operator= "deger+1";
    $ci->db->set('deger', "$operator", FALSE);
    $ci->db->where('tip', $id);
    $ci->db->update('numaric');
}

function permit_status($status){

    if($status==0){
        return 'Bekliyor';
    }
    elseif($status==1){
            return 'Onaylandı';
        }
    elseif($status==2){
            return 'İptal Edildi';
        }
}

function numaric($tip)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM numaric Where tip=$tip");
    $rows = $query1->row();
    date_default_timezone_set('Asia/Baku');
    $gun=date('d');
    $ay=date('m');
    $yil=date('Y');
    $kode='';
    if($tip==1)
    {
        $kode='GT';
    }
    else if($tip==2)
    {
        $kode='MT';
    }
    else if($tip==3)
    {
        $kode='SF';
    }
    else if($tip==4)
    {
        $kode='SE';
    }
    else if($tip==5)
    {
        $kode='AT';
    }
    else if($tip==6)
    {
        $kode='TEKLIF';
    }
    else if($tip==7)
    {
        $kode='TEHVİL';
    }
    else if($tip==8)
    {
        $kode='F';
    }
    else if($tip==9)
    {
        $kode='Stok Fişi';
    }

    else if($tip==10)
    {
        $kode='Controller';
    }
    else if($tip==12)
    {
        $kode='ODM';
    }
    else if($tip==13)
    {
        $kode='PRK';
    }
    else if($tip==14)
    {
        $kode='LJT';
    }
    else if($tip==15)
    {
        $kode='MKM';
    }
    else if($tip==16)
    {
        $kode='LJS';
    }
    else if($tip==19)
    {
        $kode='LSF';
    }
    else if($tip==20)
    {
        $kode='ART';
    }
    else if($tip==21)
    {
        $kode='MKS';
    }
    else if($tip==22)
    {
        $kode='MPRJ';
    }
    else if($tip==25)
    {
        $kode='SFT';
    }

    else if($tip==26)
    {
        $kode='MKR';
    }

    else if($tip==27)
    {
        $kode='MPK';
    }
    else if($tip==29)
    {
        $kode='MKT';
    }

    else if($tip==30)
    {
        $kode='MPT';
    }
    else if($tip==31)
    {
        $kode='URC';
    }
    else if($tip==32)
    {
        $kode='URF';
    }
    else if($tip==33)
    {
        $kode='SFS';
    }
    else if($tip==34)
    {
        $kode='SFT';
    }
    else if($tip==35)
    {
        $kode='PB';
    }
    else if($tip==36)
    {
        $kode='BC';
    }
    else if($tip==37)
    {
        $kode='M2D';
    }
    else if($tip==38)
    {
        $kode='M2G';
    }
    else if($tip==39)
    {
        $kode='M2GI';
    }
    else if($tip==40)
    {
        $kode='M2F';
    }
    else if($tip==41)
    {
        $kode='M2EN';
    }
    else if($tip==42)
    {
        $kode='M2CP';
    }

    else if($tip==43)
    {
        $kode='MNIT';
    }
    else if($tip==44)
    {
        $kode='MCCT';
    }
    else if($tip==45)
    {
        $kode='PV';
    }
    else if($tip==46)
    {
        $kode='PBN';
    }
    else if($tip==47)
    {
        $kode='PAN';
    }
    else if($tip==48)
    {
        $kode='MPB';
    }
    else if($tip==49)
    {
        $kode='MPA';
    }


    if($tip==17)
    {
        $ret = $kode='tnd-'.$rows->deger;
        return $ret;
    }
    if($tip==23)
    {
        $ret = $kode='mktnd-'.$rows->deger;
        return $ret;
    }
    if($tip==18)
    {
        $ret = $kode='izin-'.$rows->deger;
        return $ret;
    }
    if($tip==28)
    {

        return $rows->deger;
    }


    else {
        $ret=$kode.'-'.$gun.$ay.$yil.'-'.$rows->deger;
        return $ret;
    }


}


function to_excel($array, $filename) {
    header('Content-Disposition: attachment; filename='.$filename.'.xls');
    header('Content-type: application/force-download');
    header('Content-Transfer-Encoding: binary');
    header('Pragma: public');
    print "\xEF\xBB\xBF"; // UTF-8 BOM
    $h = array();
    foreach($array->result_array() as $row){
        foreach($row as $key=>$val){
            if(!in_array($key, $h)){
                $h[] = $key;
            }
        }
    }
    echo '<table><tr style="border: 1px solid gray">';
    foreach($h as $key) {
        $key = ucwords($key);
        echo '<th>'.$key.'</th>';
    }
    echo '</tr>';

    foreach($array->result_array() as $row){
        echo '<tr style="border: 1px solid gray">';
        foreach($row as $val)
            writeRow($val);
    }
    echo '</tr>';
    echo '</table>';


}

function writeRow($val) {
    echo '<td>'.$val.'</td>';
}

function referans_urunleri($id,$firma_name)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query( "SELECT * FROM `geopos_talep_items` WHERE tip=$id and firma='$firma_name' and ref_urun=1 ORDER BY `geopos_talep_items`.`price` ASC")->result_array();
    return $query1;

}
function satin_alma_urun_sayisi($satin_alma_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sayi=0;
    $query1 = $ci->db->query( "SELECT * FROM `geopos_talep_items` WHERE `tip` = $satin_alma_id and ref_urun=0 GROUP BY product_name ")->result();
    foreach ($query1 as $key=>$qs)
    {
        $sayi=$sayi+1;
    }

    return $sayi;

}

function firma_teklif_count($firma,$id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sayi=0;
    $query1 = $ci->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$id and firma LIKE '%$firma%'  and ref_urun=0 GROUP BY product_name")->num_rows();


    return $query1;

}

function satin_alma_urun_onay_sayisi($type,$file_id,$string)
{
    $ci =& get_instance();
    $ci->load->database();
    if(isset($string))
    {
        $query2 = $ci->db->query("SELECT * FROM `geopos_onay` Where `type`=$type and file_id=$file_id");
        if($query2->num_rows()>0)
        {

            $notes= $string.'_note';



            $sayi=0;
            $mesasge='';
            foreach ($query2->result() as $q)
            {


                if($q->$string==3)
                {
                    $malzeme_talep_id=$q->malzeme_items_id;
                    $query=$ci->db->query("SELECT * FROM `geopos_talep_items` Where id=$malzeme_talep_id")->row();
                    $sayi++;

                }

            }
            return $sayi;



        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 0;
    }


}

function satinalma_urun_to_firma($id,$product_name)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$id and  product_name ='$product_name' and ref_urun=0 ORDER BY `price` ASC ")->result_array();
    return $query1;

}
function satin_alma_formu_list_ihale($ihale_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $talep='';

    $query3 = $ci->db->query("SELECT * FROM `geopos_talep` WHERE geopos_talep.ihale_formu_id=$ihale_id");
    if($query3->num_rows()>0)
    {
        $id=$query3->row()->id;
        $talep_no=$query3->row()->talep_no;
        $talep.="<a class='btn btn-primary btn-sm' target='_blank' href='/form/satinalma_view?id=$id'>$talep_no</a> ";
    }


    return $talep;

}
function satin_alma_formu_list($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $talep='';
    $query1 = $ci->db->query("SELECT * FROM `geopos_talep` WHERE malzeme_talep_form_id=$id");
    $query2 = $ci->db->query("SELECT * FROM `ihale_to_malzeme_talep` WHERE malzeme_talep_id =$id");
    if($query1->num_rows()>0)
    {
        foreach ($query1->result() as $taleps)
        {
            $talep.="<a class='btn btn-primary btn-sm' href='/form/satinalma_view?id=$taleps->id'>$taleps->talep_no</a> ";
        }

    }
    else
    {
        if($query2->num_rows()>0)
        {
            $ihale_id = $query2->row()->ihale_id;
            $query3 = $ci->db->query("SELECT * FROM `geopos_talep` WHERE geopos_talep.ihale_formu_id=$ihale_id");
            if($query3->num_rows()>0)
            {
                $id=$query3->row()->id;
                $talep_no=$query3->row()->talep_no;
                $talep.="<a class='btn btn-primary btn-sm' href='/form/satinalma_view?id=$id'>$talep_no</a> ";
            }


        }
    }
    return $talep;

}
function hareketler()
{
    $ci =& get_instance();
    $ci->load->database();

    $where_loc='';
    if($ci->session->userdata('set_firma_id')){

        $where_loc = 'and geopos_invoices.loc ='.$ci->session->userdata('set_firma_id');
    }
    $query1 = $ci->db->query("SELECT * FROM `geopos_invoices` WHERE  invoice_type_id IN (3,4,14,19,20,23,27,28,41) $where_loc ORDER BY `geopos_invoices`.`id` DESC LIMIT 8")->result();
    return $query1;

}

function odeme_bekleyen_talepler()
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query(" SELECT * FROM `geopos_talep`  WHERE  tip IN (5,4,6,7) and status IN (3,5) ORDER BY `geopos_talep`.`id` DESC ")->result();
    return $query1;

}
function odeme_bekleyen_talepler_new($status)
{
    $ci =& get_instance();
    $ci->load->database();

    $where='';
    if($status==12){
        $aauth_id = $ci->aauth->get_user()->id;
        if($aauth_id!=61){

            $where='and payment_personel_id='.$aauth_id;
        }

    }

    $where_loc_customer='';
    if($ci->session->userdata('set_firma_id')){

        $where_loc_customer = 'and talep_form_customer.loc ='.$ci->session->userdata('set_firma_id');
    }

    $where_loc_personel='';
    if($ci->session->userdata('set_firma_id')){

        $where_loc_personel = 'and talep_form_personel.loc ='.$ci->session->userdata('set_firma_id');
    }

    $talep_form_customer_new='';
    $talep_form_nakliye='';
    if($ci->session->userdata('set_firma_id')){

        $talep_form_customer_new = 'and talep_form_customer_new.loc ='.$ci->session->userdata('set_firma_id');
        $talep_form_nakliye = 'and talep_form_nakliye_products.loc ='.$ci->session->userdata('set_firma_id');
    }

    $all = $ci->db->query("
SELECT COUNT(id) as sayi,'Cari Gider Talebi' as name,5 as total_tip,'/onay/caribekleyen?tip=2&status=$status' as href FROM talep_form_customer_new Where status=$status and talep_form_customer_new.type=1 $where $talep_form_customer_new
UNION ALL
SELECT COUNT(id) as sayi,'Cari Jojistik Talebi' as name,6 as total_tip,'/onay/carilojistik?tip=6&status=$status' as href FROM talep_form_nakliye_products Where status=$status $where $talep_form_nakliye
UNION ALL
SELECT COUNT(id) as sayi,'Cari Avans Talebi'  as name,2 as total_tip,'/onay/caribekleyen?tip=3&status=$status' as href FROM talep_form_customer Where status=$status and talep_form_customer.type=2 $where $where_loc_customer
UNION ALL
SELECT COUNT(id) as sayi,'Personel Gider Talebi'  as name,3 as total_tip,'/onay/personelbekleyen?tip=2&status=$status' as href FROM talep_form_personel Where status=$status and talep_form_personel.tip=1 $where $where_loc_personel
UNION ALL
SELECT COUNT(id) as sayi,'Personel Avans Talebi'  as name,4 as total_tip,'/onay/personelbekleyen?tip=3&status=$status' as href FROM talep_form_personel Where status=$status and talep_form_personel.tip=2 $where $where_loc_personel")->result();

    return $all;

}
function odeme_bekleyen_talepler_total($id,$status)
{
    $ci =& get_instance();
    $ci->load->database();

    $cari_gider_total_nakit=0;
    $cari_gider_total_banka=0;

    $cari_avans_total_nakit=0;
    $cari_avans_total_banka=0;

    $personel_avans_nakit=0;
    $personel_avans_banka=0;

    $personel_gider_nakit=0;
    $personel_gider_banka=0;

    $where='';
    if($status==12){

        $aauth_id = $ci->aauth->get_user()->id;
        if($aauth_id!=61){

            $where='and payment_personel_id='.$aauth_id;
        }


    }

    if($id==2){
        $where_loc='';
        if($ci->session->userdata('set_firma_id')){

            $where_loc = 'and talep_form_customer.loc ='.$ci->session->userdata('set_firma_id');
        }
        $cari_avans = $ci->db->query("SELECT talep_form_customer.method,talep_form_customer_products.total FROM talep_form_customer INNER JOIN talep_form_customer_products ON talep_form_customer.id=talep_form_customer_products.form_id Where talep_form_customer.status=$status and talep_form_customer.type=2 $where $where_loc");
        if($cari_avans->num_rows()){
            foreach ($cari_avans->result() as $items){

                if($items->method==1) // Nakit
                {
                    $cari_avans_total_nakit+=$items->total;
                }
                else if($items->method==3) // Banka
                {
                    $cari_avans_total_banka+=$items->total;
                }
            }
        }
        return [
            'total_nakit'=>amountFormat($cari_avans_total_nakit),
            'total_nakit_float'=>$cari_avans_total_nakit,
            'total_banka'=>amountFormat($cari_avans_total_banka),
            'total_banka_float'=>$cari_avans_total_banka,
            'total'=>amountFormat($cari_avans_total_nakit+$cari_avans_total_banka),
        ];
    }
    elseif($id==3){
        $where_loc='';
        if($ci->session->userdata('set_firma_id')){

            $where_loc = 'and talep_form_personel.loc ='.$ci->session->userdata('set_firma_id');
        }
        $personel_gider = $ci->db->query("SELECT talep_form_personel.method,talep_form_personel_products.total FROM talep_form_personel INNER JOIN talep_form_personel_products ON talep_form_personel_products.form_id = talep_form_personel.id Where talep_form_personel.status=$status and talep_form_personel.tip=1 $where $where_loc");
        if($personel_gider->num_rows()){
            foreach ($personel_gider->result() as $items){


                if($items->method==1) // Nakit
                {
                    $personel_gider_nakit+=$items->total;
                }
                else if($items->method==3) // Banka
                {
                    $personel_gider_banka+=$items->total;
                }

            }
        }
        return [
            'total_nakit'=>amountFormat($personel_gider_nakit),
            'total_nakit_float'=>$personel_gider_nakit,
            'total_banka'=>amountFormat($personel_gider_banka),
            'total_banka_float'=>$personel_gider_banka,
            'total'=>amountFormat($personel_gider_nakit+$personel_gider_banka),
        ];
    }
    elseif($id==4){
        $where_loc='';
        if($ci->session->userdata('set_firma_id')){

            $where_loc = 'and talep_form_personel.loc ='.$ci->session->userdata('set_firma_id');
        }
        $cari_avans = $ci->db->query("SELECT talep_form_personel.method,talep_form_personel_products.total FROM talep_form_personel INNER JOIN talep_form_personel_products ON talep_form_personel_products.form_id = talep_form_personel.id Where talep_form_personel.status=$status and talep_form_personel.tip=2 $where $where_loc");
        if($cari_avans->num_rows()){
            foreach ($cari_avans->result() as $items){
                if($items->method==1) // Nakit
                {
                    $personel_avans_nakit+=$items->total;
                }
                else if($items->method==3) // Banka
                {
                    $personel_gider_banka+=$items->total;
                }
            }
        }
        return [
            'total_nakit'=>amountFormat($personel_avans_nakit),
            'total_nakit_float'=>$personel_avans_nakit,
            'total_banka'=>amountFormat($personel_gider_banka),
            'total_banka_float'=>$personel_gider_banka,
            'total'=>amountFormat($personel_avans_nakit+$personel_gider_banka),
        ];
    }
    elseif($id==5){
        $where_loc='';
        if($ci->session->userdata('set_firma_id')){

            $where_loc = 'and talep_form_customer_new.loc ='.$ci->session->userdata('set_firma_id');
        }
        $cari_gider = $ci->db->query("SELECT talep_form_customer_new.method,
       talep_form_customer_products_new.total FROM talep_form_customer_new 
    INNER JOIN talep_form_customer_products_new on talep_form_customer_new.id=talep_form_customer_products_new.form_id 
Where talep_form_customer_new.status=$status and talep_form_customer_new.type=1 $where $where_loc");
        if($cari_gider->num_rows()){
            foreach ($cari_gider->result() as $items){
                if($items->method==1) // Nakit
                {
                    $cari_gider_total_nakit+=$items->total;
                }
                else if($items->method==3) // Banka
                {
                    $cari_gider_total_banka+=$items->total;
                }

            }
        }
        return [
            'total_nakit'=>amountFormat($cari_gider_total_nakit),
            'total_nakit_float'=>$cari_gider_total_nakit,
            'total_banka'=>amountFormat($cari_gider_total_banka),
            'total_banka_float'=>$cari_gider_total_banka,
            'total'=>amountFormat($cari_gider_total_banka+$cari_gider_total_nakit),
        ];
    }

    elseif($id==6){
        $where_loc='';
        if($ci->session->userdata('set_firma_id')){

            $where_loc = 'and talep_form_nakliye_products.loc ='.$ci->session->userdata('set_firma_id');
        }
        $cari_gider = $ci->db->query("SELECT talep_form_nakliye_products.method,
       talep_form_nakliye_products.total FROM talep_form_nakliye_products 
Where talep_form_nakliye_products.status=$status   $where $where_loc");
        if($cari_gider->num_rows()){
            foreach ($cari_gider->result() as $items){
                if($items->method==1) // Nakit
                {
                    $cari_gider_total_nakit+=$items->total;
                }
                else if($items->method==3) // Banka
                {
                    $cari_gider_total_banka+=$items->total;
                }

            }
        }
        return [
            'total_nakit'=>amountFormat($cari_gider_total_nakit),
            'total_nakit_float'=>$cari_gider_total_nakit,
            'total_banka'=>amountFormat($cari_gider_total_banka),
            'total_banka_float'=>$cari_gider_total_banka,
            'total'=>amountFormat($cari_gider_total_banka+$cari_gider_total_nakit),
        ];
    }


}

function odeme_emri_kontrol_($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_invoices Where tid=$id where invoice_type_id=42");
    if($query1->num_rows()){
        return false;
    }
    else {
        return true;
    }

}
function cari_forma2_list($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT * FROM geopos_invoices Where csd=$id and invoice_type_id IN(29,30)");
    if($query1->num_rows()){
       return $query1->result();
    }
    else {
        return true;
    }

}
function odeme_bekleyen_talepler_($length=0,$start=0,$search='',$column='',$sort='',$payer='0',$proje=0,$status=0)
{
    $ci =& get_instance();
    $ci->load->database();
    $limit='';
    $where=' talep.tip IN (5,4,6,7)';
    $wher3='';
    $wher2='';
    $where_forma2='';
    $where_='';
    $order_by='';
    if($length!=0){
        $limit ="LIMIT $start,$length ";
    }
    if($length==-1){
        $limit ="";
    }
    if($search!=''){
        $where.= ' and (proje_name LIKE "%'.$search.'%"  or talep_no LIKE "%'.$search.'%" or total LIKE "%'.$search.'%" or payer LIKE "%'.$search.'%" )';
        $where_forma2.= ' and (proje_name LIKE "%'.$search.'%"  )';
    }

    if($search!=''){
        $where_forma2.= ' and (total LIKE "%'.$search.'%" or payer LIKE "%'.$search.'%" )';
    }
    if($payer!='0'){

        $where_.= ' and payer = "'.$payer.'"';

    }
    if($proje!=0){
        $where_.= ' and proje_id = "'.$proje.'"';

    }
    if($status!=0){
        $where_.= ' and status = "'.$status.'"';
    }
    if($column!=''){
        $column_='';

        if($column==0){
            $order_by="ORDER BY `talep`.`id`";
        }
        else  if($column==1){
            $column_="tip";
            $order_by ='ORDER BY talep.'.$column_.' '.$sort;
        }
        else  if($column==2){
            $column_="proje_name";
            $order_by ='ORDER BY talep.'.$column_.' '.$sort;
        }
        else  if($column==3){
            $column_="proje_name";
            $order_by ='ORDER BY talep.'.$column_.' '.$sort;
        }

    }
    else {
        $order_by="ORDER BY `talep`.`id` ASC";
    }
    $query1 = $ci->db->query("SELECT talep.*, 0 as invoice_type_id FROM `geopos_talep` as talep  WHERE   $where $where_  and  talep.tip IN (5,4,6,7) and  talep.status IN (3,5)  $order_by  $limit ")->result();

    $query2 = $ci->db->query("SELECT geopos_invoices.*, 10 as tip FROM `geopos_invoices` INNER JOIN geopos_onay ON geopos_invoices.id = geopos_onay.file_id WHERE geopos_onay.type = 10 $where_ and geopos_onay.genel_mudur_status=3 and geopos_invoices.status IN (17) $where_forma2 ORDER BY `geopos_invoices`.`id` ASC")->result();

    $array = array_merge($query1,$query2);

    return array_sort($array,'id','SORT_DESC');

}

function odeme_onaylanan_talepler_($length=0,$start=0,$search='',$column='',$sort='',$payer='0',$proje=0,$status=0,$user_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $limit='';
    $where=' talep.tip IN (5,4,6,7)';
    $wher3='';
    $wher2='';
    $where_='';
    $where_form_2='';
    $order_by='';
    if($length!=0){
        $limit ="LIMIT $start,$length ";
    }
    if($length==-1){
        $limit ="";
    }
    if($search!=''){
        $where.= ' and (proje_name LIKE "%'.$search.'%"  or talep_no LIKE "%'.$search.'%" or total LIKE "%'.$search.'%" or payer LIKE "%'.$search.'%" )';

    }
    if($payer!='0'){

        $where_.= ' and payer = "'.$payer.'"';

    }
    if($proje!=0){
        $where_.= ' and proje_id = "'.$proje.'"';
        $where_form_2.= ' and proje_id = "'.$proje.'"';

    }
    if($status!=0){
        $where_.= ' and status = "'.$status.'"';
    }
    else {
        $where_.=' and status=7';
    }
    if($column!=''){
        $column_='';

        if($column==0){
            $order_by="ORDER BY `talep`.`id`".' '.$sort;
        }
        else  if($column==1){
            $column_="tip";
            $order_by ='ORDER BY talep.'.$column_.' '.$sort;
        }
        else  if($column==2){
            $column_="proje_name";
            $order_by ='ORDER BY talep.'.$column_.' '.$sort;
        }
        else  if($column==3){
            $column_="proje_name";
            $order_by ='ORDER BY talep.'.$column_.' '.$sort;
        }

    }
    else {
        $order_by="ORDER BY `talep`.`id` ASC";
    }
    $role = '';

    $query1 = $ci->db->query("SELECT talep.*, 0 as invoice_type_id,0 as eid FROM `geopos_talep` as talep  WHERE   $where $where_  $role $order_by  $limit ")->result();


    $query2 = $ci->db->query("SELECT geopos_invoices.*, 10 as tip FROM `geopos_invoices` INNER JOIN geopos_onay ON geopos_invoices.id = geopos_onay.file_id WHERE geopos_onay.type = 10
                and geopos_onay.genel_mudur_status=3 and geopos_invoices.status=10 $role  $where_form_2 $where_ ORDER BY `geopos_invoices`.`id` ASC ")->result();



    $data_forma2=[];
    foreach ($query2 as $forma_2){

        $odeme_total=0;
        $teminat=0;
        $ceza_total=0;
        $kur_degeri=para_birimi_id($forma_2->para_birimi)['rate'];
        $carpim=$kur_degeri;
        foreach (forma_2_pay_history($forma_2->id) as  $value){
            if($value->invoice_type_id == 55) // Teminat
            {
                $teminat+=$value->total;
            }
            else if($value->invoice_type_id == 54 || $value->invoice_type_id == 65) // Ceza
            {
                $ceza_total+=$value->total;
            }
            else if($value->invoice_type_id == 57) // Prim
            {
                $prim+=$value->total;
            }
            else { // Ödeme
                $odeme_total += $value->total;
            }
        }
        $total_cikan = $odeme_total  + $teminat + $ceza_total;
        $kalan = ($forma_2->total*$carpim)-($total_cikan);
        if($kalan > 0){
            $data_forma2[]=$forma_2;
        }
    }
    $array = array_merge($query1,$data_forma2);

    return array_sort($array,'id','SORT_DESC');

}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case 'SORT_ASC':
                asort($sortable_array);
                break;
            case 'SORT_DESC':
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function talep_payer(){
    $ci =& get_instance();
    $ci->load->database();
    ///$query1 = $ci->db->query("SELECT talep.*, IF(talep.cari_pers=2,(SELECT geopos_customers.company FROM geopos_customers Where id = talep.talep_eden_pers_id),(SELECT name FROM geopos_employees Where id = talep.talep_eden_pers_id)) as talep_eden_name  FROM `geopos_talep` as talep  WHERE  talep.tip IN (5,4)  and  talep.status IN (3,5) GROUP  BY talep.payer ")->result();
    $query1 = $ci->db->query("SELECT payer FROM `geopos_talep` as talep WHERE talep.tip IN (5,4,7) and status=7 ORDER BY `talep`.`id` asc")->result();
    $query2 = $ci->db->query("SELECT payer FROM `geopos_invoices` INNER JOIN geopos_onay ON geopos_invoices.id = geopos_onay.file_id WHERE geopos_onay.type = 10 and geopos_onay.genel_mudur_status=3 and geopos_invoices.status=10 ORDER BY `geopos_invoices`.`id` ASC")->result();

    $array=$query1;
    $result = [];
    if($query2){
        $array=array_merge($query1,$query2);
    }

    foreach ($array as $items){
        $result[]=$items->payer;
    }

    return array_unique($result);
}
function talep_payer_onay_bekleyen(){
    $ci =& get_instance();
    $ci->load->database();
    ///$query1 = $ci->db->query("SELECT talep.*, IF(talep.cari_pers=2,(SELECT geopos_customers.company FROM geopos_customers Where id = talep.talep_eden_pers_id),(SELECT name FROM geopos_employees Where id = talep.talep_eden_pers_id)) as talep_eden_name  FROM `geopos_talep` as talep  WHERE  talep.tip IN (5,4)  and  talep.status IN (3,5) GROUP  BY talep.payer ")->result();
    $query1 = $ci->db->query("SELECT payer FROM `geopos_talep` as talep WHERE talep.tip IN (5,4,6,7) and talep.tip IN (5,4,6,7) and talep.status IN (3,5) ORDER BY `talep`.`id`")->result();
    $query2 = $ci->db->query("SELECT payer FROM `geopos_invoices` INNER JOIN geopos_onay ON geopos_invoices.id = geopos_onay.file_id WHERE geopos_onay.type = 10 and geopos_onay.genel_mudur_status=3 and geopos_invoices.status IN (17) ORDER BY `geopos_invoices`.`id` ASC")->result();

    $array=$query1;
    $result = [];
    if($query2){
        $array=array_merge($query1,$query2);
    }

    foreach ($array as $items){
        $result[]=$items->payer;
    }

    return array_unique($result);
}
function array_key_uniq($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}
function talep_total(){
    $ci =& get_instance();
    $ci->load->database();


    $query1 = $ci->db->query("SELECT SUM(total) as total  FROM `geopos_talep` as talep  WHERE  talep.tip IN (5,4)  and  talep.status IN (3,5)")->row();
    $query2 = $ci->db->query("SELECT SUM(total) as total  FROM `geopos_invoices` as talep  WHERE   talep.status IN (10) ")->row();

    return floatval($query1->total)+$query2->total;
}
function talep_total_onaylanan(){
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query("SELECT SUM(total) as total  FROM `geopos_talep` as talep  WHERE  talep.tip IN (5,4)  and  talep.status IN (7) ")->row();

    $query2 = $ci->db->query("SELECT SUM(total) as total  FROM `geopos_invoices` as talep  WHERE talep.status IN (10) ")->row();

    return floatval($query1->total)+$query2->total;
}
function odeme_emri_kontrol($talep_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query1 = $ci->db->query(" SELECT * FROM `geopos_invoices`  WHERE  tid=$talep_id and invoice_type_id=42")->row();
    return $query1;

}


function depo_urun_status()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_depo_urun_status` ")->result();
    return $query2;


}

function talep_id_getir($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_talep_items` where id =$id")->row()->tip;
    return $query2;


}
function depo_urun_status_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_depo_urun_status` where id =$id")->row()->name;
    return $query2;


}
function depo_toplam_teslim_qty($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT SUM(teslim_alinan_miktar) as qty FROM `geopos_depo_onay` where talep_item_id =$id")->row()->qty;
    return $query2;
}
function depo_notes_ogren($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT notes FROM `geopos_depo_onay` where talep_item_id =$id  LIMIT 1");
    if($query2->num_rows()>0)
    {
        return $query2->row()->notes;
    }
    else
    {
        return '';
    }

}
function depo_tehvil_id($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT tehvil_id FROM `geopos_depo_onay` where talep_item_id =$id  LIMIT 1");
    if($query2->num_rows()>0)
    {
        return $query2->row()->tehvil_id;
    }
    else
    {
        return '';
    }

}
function depo_onay_details($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_depo_onay` where id=$id");
    if($query2->num_rows()>0)
    {
        return $query2->row();
    }
    else
    {
        return '';
    }

}
function malzeme_details_depo($talep_id,$talep_item_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT geopos_talep_items.id, geopos_talep.talep_no, geopos_talep.proje_name, geopos_talep_items.firma,
 geopos_talep_items.product_name, geopos_talep_items.qty, geopos_talep_items.unit, geopos_talep.tip, geopos_talep_items.depo_alim_durumu
  FROM geopos_onay INNER JOIN geopos_talep_items ON geopos_onay.malzeme_items_id=geopos_talep_items.id INNER JOIN geopos_talep ON
  geopos_talep.id=geopos_talep_items.tip WHERE geopos_onay.genel_mudur_status=3 and geopos_talep_items.id=$talep_item_id
");
    if($query2->num_rows()>0)
    {
        return $query2->row();
    }
    else
    {
        return '';
    }

}

function onay_kimde_ogren($tip,$id)
{
    $ci =& get_instance();
    $ci->load->database();


    if($tip==2) // Satın Alma Talep
    {
        $proje_muduru_array=array();
        $genel_mudur_array=array();
        $finans_mudur_array=array();
        $kontrol=array();

        $query=$ci->db->query("SELECT * FROM geopos_onay where file_id=$id")->result();
        foreach ($query as $q)
        {
            $proje_sorumlusu_array[]=$q->proje_sorumlusu_status;
            $proje_muduru_array[]=$q->proje_muduru_status;
            $bolum_muduru_array[]=$q->bolum_muduru_status;
            $genel_mudur_array[]=$q->genel_mudur_status;
            $finans_mudur_array[]=$q->finans_status;
        }


        if (in_array("3", $proje_muduru_array)) // Onay
        {
            $kontrol=array('proje_muduru',1);
        }
        else
        {
            $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->	proje_muduru_id;
            $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name;
            return $name;
        }


        if (in_array("3", $genel_mudur_array)) // Onay
        {
            $kontrol=array('genel_mudur',1);
        }
        else
        {
            $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->genel_mudur_id;
            $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name;
            return $name;
        }
        if (in_array("3", $finans_mudur_array)) // Onay
        {
            $kontrol=array('finans_mudur',1);
        }
        else
        {
            /* $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->finans_departman_pers_id;
             $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name; */
            return 'Burçak Erdal';
        }
    }

    else
    {
        $proje_sorumlusu_array=array();
        $proje_muduru_array=array();
        $bolum_muduru_array=array();
        $genel_mudur_array=array();
        $finans_mudur_array=array();
        $kontrol=array();
        $query=$ci->db->query("SELECT * FROM geopos_onay where file_id=$id")->result();
        $count = count($query);
        foreach ($query as $q)
        {
            $proje_sorumlusu_array[]=$q->proje_sorumlusu_status;
            $proje_muduru_array[]=$q->proje_muduru_status;
            $bolum_muduru_array[]=$q->bolum_muduru_status;
            $genel_mudur_array[]=$q->genel_mudur_status;
            $finans_mudur_array[]=$q->finans_status;
        }
        if (in_array("3", $proje_sorumlusu_array)) // Onay
        {
            $kontrol=array('proje_sorumlusu',1);
        }
        else
        {
            $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->proje_sorumlusu_id;
            $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name;
            return $name;
        }


        if (in_array("3", $proje_muduru_array)) // Onay
        {
            $kontrol=array('proje_muduru',1);
        }
        else
        {
            $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->	proje_muduru_id;
            $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name;
            return $name;
        }

        if (in_array("3", $bolum_muduru_array)) // Onay
        {
            $kontrol=array('bolum_muduru',1);
        }
        else
        {
            $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->bolum_mudur_id;
            $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name;
            return $name;
        }

        if (in_array("3", $genel_mudur_array)) // Onay
        {
            $kontrol=array('genel_mudur',1);
        }
        else
        {
            $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->genel_mudur_id;
            $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name;
            return $name;
        }

        if (in_array("3", $finans_mudur_array)) // Onay
        {
            $kontrol=array('finans_mudur',1);
        }
        else
        {
            /* $pers_id=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row()->finans_departman_pers_id;
             $name=$ci->db->query("SELECT * FROM geopos_employees where id=$pers_id")->row()->name; */
            return 'Burçak Erdal';
        }




    }



}

function onay_saati($id,$tip){
    $ci =& get_instance();
    $ci->load->database();
    $query=$ci->db->query("SELECT * FROM `geopos_onay` WHERE `proje_muduru_onay_saati` IS NOT NULL and file_id=$id LIMIT 1");
    if($query->num_rows()>0){
        if($tip==1){ // malzeme talep proje m. proje s. depo m. genel m.
            $query= $query->row_array();
            $array=[
                ($query['proje_muduru_onay_saati'])?$query['proje_muduru_onay_saati']:'',
                ($query['proje_sorumlusu_onay_saati'])?$query['proje_sorumlusu_onay_saati']:'',
                ($query['bolum_muduru_saati'])?$query['bolum_muduru_saati']:'',
            ];
        }
        else if($tip==2){ // satın alma formu
            $query= $query->row_array();
            $array=[
                ($query['proje_muduru_onay_saati'])?$query['proje_muduru_onay_saati']:'',
                ($query['genel_mudur_onay_saati'])?$query['proje_sorumlusu_onay_saati']:'',
            ];
        }
        else if($tip==4){ // Gider Talep alma formu
            $query= $query->row_array();
            $array=[
                ($query['proje_muduru_onay_saati'])?$query['proje_muduru_onay_saati']:'',
                ($query['proje_sorumlusu_onay_saati'])?$query['proje_sorumlusu_onay_saati']:'',
                ($query['bolum_muduru_saati'])?$query['bolum_muduru_saati']:'',
                ($query['genel_mudur_onay_saati'])?$query['proje_sorumlusu_onay_saati']:'',
            ];
        }
        else if($tip==5){ // Gider Talep alma formu
            $query= $query->row_array();
            $array=[
                ($query['proje_muduru_onay_saati'])?$query['proje_muduru_onay_saati']:'',
                ($query['proje_sorumlusu_onay_saati'])?$query['proje_sorumlusu_onay_saati']:'',
                ($query['bolum_muduru_saati'])?$query['bolum_muduru_saati']:'',
                ($query['genel_mudur_onay_saati'])?$query['proje_sorumlusu_onay_saati']:'',
            ];
        }


        rsort($array);
      return $array[0];

    }
    else {
        $query=$ci->db->query("SELECT * FROM geopos_talep where id=$id")->row_array();
        return $query['olusturma_tarihi'];
    }
}

function talep_onay_iptal_kontrol($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $proje_sorumlusu_array=array();
    $proje_muduru_array=array();
    $bolum_muduru_array=array();
    $genel_mudur_array=array();
    $finans_mudur_array=array();
    $kontrol=array();
    $query=$ci->db->query("SELECT * FROM geopos_onay where file_id=$id")->result();
    $count = count($query);
    $sayi=0;


    foreach ($query as $q)
    {
        $proje_sorumlusu_array[]=$q->proje_sorumlusu_status;
        $proje_muduru_array[]=$q->proje_muduru_status;
        $bolum_muduru_array[]=$q->bolum_muduru_status;
        $genel_mudur_array[]=$q->genel_mudur_status;
        $finans_mudur_array[]=$q->finans_status;
    }

    if (in_array("1", $proje_sorumlusu_array)) // Onay
    {
        $sayi =  0;
    }
    else if (in_array("3", $proje_sorumlusu_array)) // Onay
    {
        $sayi =  0;
    }
    else  if (in_array("3", $proje_muduru_array)) // Onay
    {
        $sayi =  0;
    }
    else if (in_array("3", $bolum_muduru_array)) // Onay
    {
        $sayi =  0;
    }
    else  if (in_array("3", $genel_mudur_array)) // Onay
    {
        $sayi =  0;

    }
    else if (in_array("3", $finans_mudur_array)) // Onay
    {
        $sayi =  0;
    }
    else
    {
        $sayi = 1;
    }

    return $sayi;








}


function personel_id_ogren($name)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_employees` WHERE name LIKE '%$name%' ORDER BY `id` DESC");
    $row = $query2->row_array();


    return $row['id'];
}


function customer_id_ogren($name)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_customers` WHERE company LIKE '$name' ORDER BY `id` DESC");
    $row = $query2->row_array();


    return $row['id'];
}
function proje_id_ogren($name)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_projects` WHERE `name` LIKE '$name'");
    if($query2->num_rows()>0)
    {
        $row = $query2->row_array();


        return $row['id'];
    }
    else
    {
        return 0;
    }

}
function invoice_type_id_ogren($name)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_invoice_type` WHERE `description` LIKE '$name'");
    $row = $query2->row_array();


    return $row['id'];
}
function odeme_tipi_id_ogren($name)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_account_type` WHERE `name` LIKE '$name'");
    $row = $query2->row_array();
    return $row['id'];
}

function onay_bekleyen_izinler($user_id,$id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_izinler` WHERE id=$id and  (`bolum_sorumlusu`=$user_id or `genel_mudur`=$user_id or `bolum_pers_id`=$user_id or `finans_pers_id`=$user_id)");

    if($query2->num_rows()>0) {

        if ($query2->row()->bolum_pers_id == $user_id) //sorumlu Personel Müdür
        {
            if ($query2->row()->bolum_pers_status == 1)
            {
                return 1;
            }
            else if ($query2->row()->bolum_pers_status == 2)
            {
                return 1;
            }
            else if ($query2->row()->bolum_pers_status == 3)
            {
                return 1;
            }
            else
            {
                return  0;

            }
        }

        if ($query2->row()->bolum_sorumlusu == $user_id) //Ofis Menejeri
        {
            if ($query2->row()->bolum_pers_status == 1 || $query2->row()->bolum_pers_status == 2)
            {
                if ($query2->row()->status == 1)
                {
                    return 1;
                }
                else if ($query2->row()->status == 2)
                {
                    return 1;
                }
                else if ($query2->row()->status == 3)
                {
                    return 1;
                }
                else
                {
                    return  0;

                }
            }
            else
            {
                return 1;
            }

        }

        if ($query2->row()->finans_pers_id == $user_id)
        {
            if ($query2->row()->bolum_pers_status == 1 || $query2->row()->bolum_pers_status == 2) {
                if ($query2->row()->finas_pers_status == 1) {
                    return 1;
                } else if ($query2->row()->finas_pers_status == 2) {
                    return 1;
                }
                else if ($query2->row()->finas_pers_status == 3) {
                    return 1;
                } else {
                    return 0;

                }
            }
            else
            {
                return 1;
            }
        }

        if ($query2->row()->genel_mudur == $user_id)
        {
            if ($query2->row()->finas_pers_status == 1 || $query2->row()->finas_pers_status == 2)
            {
                if ($query2->row()->genel_mudur_status == 1) {
                    return 1;
                }
                else if ($query2->row()->genel_mudur_status == 2) {
                    return 1;
                }
                else if ($query2->row()->genel_mudur_status == 3)
                {
                    return 1;
                }
                else {
                    return 0;

                }
            }
            else
            {
                return 1;
            }
        }




    }
    else
    {
        return 1;
    }



}

function onay_bekleyen_izinler_durum($user_id,$id)
{
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_izinler` WHERE id=$id and  (`bolum_sorumlusu`=$user_id or `genel_mudur`=$user_id or `bolum_pers_id`=$user_id or `finans_pers_id`=$user_id)");

    if($query2->num_rows()>0) {

        if ($query2->row()->bolum_pers_id == $user_id) //sorumlu Personel Müdür
        {
            if ($query2->row()->bolum_pers_status == 1)
            {
                echo "<span class='badge badge-info'>Ödenişli Onaylandı</span>";
            }
            else if ($query2->row()->bolum_pers_status == 2)
            {
                echo "<span class='badge badge-info'>Öz Habına Olarak Onaylandı</span>";
            }
            else if ($query2->row()->bolum_pers_status == 3)
            {
                echo "<span class='badge badge-success'>İptal Edildi</span>";
            }
            else
            {
                echo "<span class='badge badge-success'>Bekliyor</span>";

            }
        }

        else if ($query2->row()->bolum_sorumlusu == $user_id) //Ofis Menejeri
        {
            if ($query2->row()->bolum_pers_status == 1 || $query2->row()->bolum_pers_status == 2)
            {
                if ($query2->row()->status == 1)
                {
                    echo "<span class='badge badge-info'>Ödenişli Onaylandı</span>";
                }
                else if ($query2->row()->status == 2)
                {
                    echo "<span class='badge badge-info'>Öz Habına Olarak Onaylandı</span>";
                }
                else if ($query2->row()->status == 3)
                {
                    echo "<span class='badge badge-danger'>İptal Edildi</span>";
                }
                else
                {
                    echo "<span class='badge badge-success'>Bekliyor</span>";

                }
            }

        }

        else if ($query2->row()->genel_mudur == $user_id)
        {
            if ($query2->row()->status == 1 || $query2->row()->status == 2)
            {
                if ($query2->row()->genel_mudur_status == 1) {
                    echo "<span class='badge badge-info'>Ödenişli Onaylandı</span>";
                }
                else if ($query2->row()->genel_mudur_status == 2) {
                    echo "<span class='badge badge-info'>Öz Habına Olarak Onaylandı</span>";
                }
                else if ($query2->row()->genel_mudur_status == 3)
                {
                    echo "<span class='badge badge-danger'>İptal Edildi</span>";
                }
                else {
                    echo "<span class='badge badge-success'>Bekliyor</span>";

                }
            }
        }

        else if ($query2->row()->finans_pers_id == $user_id)
        {
            if ($query2->row()->genel_mudur_status == 1 || $query2->row()->genel_mudur_status == 2) {
                if ($query2->row()->finas_pers_status == 1) {
                    echo "<span class='badge badge-info'>Ödenişli Onaylandı</span>";
                } else if ($query2->row()->finas_pers_status == 2) {
                    echo "<span class='badge badge-info'>Öz Habına Olarak Onaylandı</span>";
                }
                else if ($query2->row()->finas_pers_status == 3) {
                    return 1;
                } else {
                    echo "<span class='badge badge-success'>Bekliyor</span>";

                }
            }
        }


    }
    else
    {
        echo "";
    }



}
function izinler()
{
    $ci =& get_instance();
    $ci->load->database();
    $aauth_id = $ci->aauth->get_user()->id;
    $ci->db->select('upc.*,user_permit.user_id');
    $ci->db->from('user_permit_confirm upc');
    $ci->db->join('user_permit','upc.user_permit_id=user_permit.id');
    $ci->db->where('upc.staff_id',$aauth_id);
    $ci->db->where('upc.staff_status',null);
    $ci->db->where('upc.sort=(SELECT MIN(sort) From user_permit_confirm Where `user_permit_confirm`.`staff_status` IS NULL and upc.user_permit_id =user_permit_confirm.user_permit_id )');
    $ci->db->where('user_permit.status',0);
    if($ci->session->userdata('set_firma_id')){
        $ci->db->where('user_permit.loc =', $ci->session->userdata('set_firma_id')); //2019-11-23 14:28:57
    }
    $ci->db->group_by('upc.user_permit_id');
    $query = $ci->db->get();
    if($query->num_rows()){
        return $query->result();
    }
    else {
        return false;
    }


}

function izin_saat_kontrol($pers_id){
    $ci =& get_instance();
    $ci->load->database();
    $date = new DateTime('now');
    $m= $date->format('m');
    $y= $date->format('Y');
    $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
    $where1 = "user_permit.end_date BETWEEN '".$y."-".$m."-01 09:00:00' AND '".$y."-".$m."-".$total_ay_sayisi_." 18:00:00'";
    $where2 = "user_permit.start_date BETWEEN '".$y."-".$m."-01 09:00:00' AND '".$y."-".$m."-".$total_ay_sayisi_." 18:00:00'";

    $ci->db->select("DATE_FORMAT(user_permit.end_date, '%m') as month,user_permit.code,geopos_employees.name,user_permit.end_date,user_permit.start_date,TIMESTAMPDIFF(HOUR,user_permit.start_date,user_permit.end_date) as toplam_saat,TIMESTAMPDIFF(MINUTE,user_permit.start_date,user_permit.end_date) as toplam_dk");
    $ci->db->from('user_permit');
    $ci->db->join('geopos_employees','user_permit.user_id=geopos_employees.id');
    $ci->db->where($where1);
    $ci->db->where($where2);
    $ci->db->where('user_permit.status',1);
    $ci->db->where('user_permit.user_id',$pers_id);
    $query = $ci->db->get();
    if($query->num_rows()){
        $total_saaat = 0;
        $items =  $query->result();
        foreach ($items as $values){
            if($values->toplam_saat < 8){
                $total_saaat += $values->toplam_saat;
            }

        }
        return $total_saaat;
    }
    else {
        return false;
    }
}

function izin_gun_kontrol($pers_id){
    $ci =& get_instance();
    $ci->load->database();
    $date = new DateTime('now');
    $m= $date->format('m');
    $y= $date->format('Y');
    $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
    $where1 = "user_permit.end_date BETWEEN '".$y."-01-01 09:00:00' AND '".$y."-12-".$total_ay_sayisi_." 18:00:00'";
    $where2 = "user_permit.start_date BETWEEN '".$y."-01-01 09:00:00' AND '".$y."-12-".$total_ay_sayisi_." 18:00:00'";

    $ci->db->select("DATE_FORMAT(user_permit.end_date, '%m') as month,user_permit.code,geopos_employees.name,user_permit.end_date,user_permit.start_date,TIMESTAMPDIFF(HOUR,user_permit.start_date,user_permit.end_date) as toplam_saat,TIMESTAMPDIFF(MINUTE,user_permit.start_date,user_permit.end_date) as toplam_dk");
    $ci->db->from('user_permit');
    $ci->db->join('geopos_employees','user_permit.user_id=geopos_employees.id');
    $ci->db->where($where1);
    $ci->db->where($where2);
    $ci->db->where('user_permit.status',1);
    $ci->db->where('user_permit.permit_type',1);
    $ci->db->where('user_permit.user_id',$pers_id);
    $query = $ci->db->get();
    if($query->num_rows()){
        $total_saaat = 0;
        $toplam_gun = 0;
        $items =  $query->result();
        foreach ($items as $prd){
            if($prd->toplam_saat==9){
                $toplam_gun+=1;
            }
            else{
                if($prd->toplam_saat%24){
                    $kalan_saat = $prd->toplam_saat%9;
                    if($kalan_saat > 3){

                        $toplam_gun++;
                        $kalan_saat=0;
                    }
                    else {
                        $saat = $prd->toplam_saat%24;
                        if($saat > 3){

                            $toplam_gun++;
                            $kalan_saat=0;
                        }
                    }
                }

                $toplam_gun+= intval($prd->toplam_saat/24);
            }

        }
        return $toplam_gun;
    }
    else {
        return 0;
    }
}

function teminat_type()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `geopos_teminat_type`")->result();
    return $query2;

}

function cari_alacak_borc_bakiye($id,$type,$method,$invoice_type)
{
    $ci =& get_instance();
    $ci->load->database();

    if($method=='invoice')
    {
        $whr='';
        if($type!=0)
        {
            $whr.="geopos_invoices.method IN($type) and";
        }
        $query2 = $ci->db->query("SELECT  geopos_customers.id as customer_id,
        geopos_customers.company,geopos_invoice_type.description,
        geopos_invoices.invoicedate,geopos_invoices.invoice_type_id,
        IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0)) as borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0))as alacak,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.subtotal,0)) as kdvsiz_borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.subtotal,0))as kdvsiz_alacak,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.tax,0)) as kdv_borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.tax,0))as kdv_alacak,

        geopos_invoices.total,geopos_invoices.kur_degeri,
        geopos_invoice_type.transactions FROM geopos_invoices
        INNER JOIN geopos_customers on geopos_invoices.csd=geopos_customers.id
        INNER JOIN geopos_invoice_type On geopos_invoices.invoice_type_id=geopos_invoice_type.id
        where $whr geopos_invoices.invoice_type_id IN($invoice_type) and geopos_invoices.status!=3 AND geopos_invoices.csd=$id
       ");
        return  $query2->row_array();
    }
    else if($method=='transaction')
    {
        $whr='';
        if($type!=0)
        {
            $whr.="geopos_invoices.method IN($type) and";
        }
        $query2 = $ci->db->query("SELECT  geopos_customers.id as customer_id,
        geopos_customers.company,geopos_invoice_type.description,
        geopos_invoices.invoicedate,geopos_invoices.invoice_type_id,
        IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0)) as borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0))as alacak,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.subtotal,0)) as kdvsiz_borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.subtotal,0))as kdvsiz_alacak,
        SUM(IF(geopos_invoice_type.transactions='income',geopos_invoices.tax,0)) as kdv_borc,
        SUM(IF(geopos_invoice_type.transactions='expense',geopos_invoices.tax,0))as kdv_alacak,

        geopos_invoices.total,geopos_invoices.kur_degeri,
        geopos_invoice_type.transactions FROM geopos_invoices
        INNER JOIN geopos_customers on geopos_invoices.csd=geopos_customers.id
        INNER JOIN geopos_invoice_type On geopos_invoices.invoice_type_id=geopos_invoice_type.id
        where $whr geopos_invoices.invoice_type_id IN($invoice_type) AND geopos_invoices.csd=$id
       ");
        return  $query2->row_array();

    }



}

function talep_user_id_ogren($string,$id)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT * FROM `geopos_talep` WHERE id=$id")->row();

    return $query2->$string;
}
function kont_history($cont_id,$desc,$status_id){
    $ci =& get_instance();
    $ci->load->database();

    $data = array(
        'cont_id' => $cont_id,
        'cont_user_id' => $ci->aauth->get_user()->id,
        'description' => $desc,
        'status_id' => $status_id
    );

    return $ci->db->insert('geopos_controller_history', $data);
}
function kont_kayit($islem_tipi,$islem_id)
{
    $ci =& get_instance();
    $ci->load->database();

    if($islem_tipi==21){
        $eid=$ci->aauth->get_user()->id;
        $islem_tipi_d='';

        $details = $ci->db->query("SELECT * FROM kont_type Where id = $islem_tipi")->row();
        $cost_persoenl_id = $ci->db->query("SELECT * FROM geopos_system Where id = 1")->row()->cost_pers_id;

        $kontrol = $ci->db->query("SELECT * FROM geopos_controller Where islem_id = $islem_id and type_id = $islem_tipi");
        if($kontrol->num_rows()){
            //status update
            $cont_id = $kontrol->row()->id;
            $ci->db->query("UPDATE geopos_controller set cont_status=1,cont_pers_id=$cost_persoenl_id,view=0 WHERE  id = $cont_id");
        }
        else {
            $data = array(
                'kullanici_id'=>$eid,
                'islem_tipi'=>$details->name,
                'islem_id'=>$islem_id,
                'islem_link'=>$details->href.$islem_id,
                'type_id'=>$islem_tipi,
                'cont_pers_id'=>$cost_persoenl_id,
                'talep_no'=>numaric(10)

            );

            $ci->db->insert('geopos_controller', $data);

            $operator= "deger+1";
            $ci->db->set('deger', "$operator", FALSE);
            $ci->db->where('tip', 10);
            $ci->db->update('numaric');
        }
    }





}

function cari_kont_kayit($cari_id,$date,$notes){

    $ci =& get_instance();
    $ci->load->database();
    $eid=$ci->aauth->get_user()->id;

    $data = array(
        'user_id'=>$eid,
        'cari_id'=>$cari_id,
        'notes'=>$notes,
        'date'=>$date

    );

    return $ci->db->insert('geopos_cari_controller', $data);

}


function controller_status($id=0)
{
    $ci =& get_instance();
    $ci->load->database();

    if($id!=0)
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_controller_status WHERE id=$id");
        $row = $query2->row_array();
        $image = $row['name'];
        return $image;

    }
    else
    {
        $query2 = $ci->db->query("SELECT * FROM geopos_controller_status");
        $row = $query2->result_array();
        return $row;
    }



}


function log_mesaj($table,$table_id,$msisdn,$link,$mesaj,$firma_id)
{
    $ci =& get_instance();
    $ci->load->database();


    $data = array(
        'table_name'=>$table,
        'table_id'=>$table_id,
        'msisdn'=>$msisdn,
        'link'=>$link,
        'mesaj'=>$mesaj,
        'firma_id'=>$firma_id

    );

    $ci->db->insert('geopos_sms', $data);



}

function avans($customer_id,$tip){
    $ci =& get_instance();
    $ci->load->database();
    $date = new DateTime('now');
    $date->modify('last day of this month');
    $hesaplanacak_ay=$date->format('m');
    $date_y=$date->format('Y');
    $guns_=date("t");



    $date_bitis=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
    $date_baslangic=$date_y.'-'.$hesaplanacak_ay.'-'.'01';


    $whre = '';
    $wr = '';

    $whre.=' AND maas_ay ='.$hesaplanacak_ay;

    $hakedis=0;
    if($tip==3)
    {
        $hakedis=$ci->db->query("SELECT resmi_maas as total_hak FROM geopos_employees where id=$customer_id")->row_array();
        $wr="(invoice_type_id=16 or invoice_type_id=49 or invoice_type_id=12) ";
    }
    else {
        $hakedis=$ci->db->query("SELECT gayri_resmi_maas as total_hak FROM geopos_employees where id=$customer_id")->row_array();
        $wr="(invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12) ";
    }

    $query = $ci->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and $wr and method=$tip $whre");
    $result = $query->result_array();
    $total=0;



    $hakedis=$hakedis['total_hak'];



    if ($query->num_rows() > 0)
    {
        foreach ($result as $row)
        {
            $total+=$row['total']; // avans toplam
        }
        $kalan = $hakedis-$total;

    }
    else
    {
        $kalan=$hakedis;
    }



    return ['avans'=>$total,'kalan'=>$kalan];
}
    function total_avans($tip){
        $ci =& get_instance();
        $ci->load->database();
        $date = new DateTime('now');
        $date->modify('last day of this month');
        $hesaplanacak_ay=$date->format('m');
        $date_y=$date->format('Y');
        $guns_=date("t");



        $date_bitis=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
        $date_baslangic=$date_y.'-'.$hesaplanacak_ay.'-'.'01';


        $whre = '';

        $whre.='AND DATE(geopos_invoices.invoicedate) >='.datefordatabasefilter($date_baslangic);
        $whre.='AND DATE(geopos_invoices.invoicedate) <='.datefordatabasefilter($date_bitis);


        $query = $ci->db->query("SELECT * FROM geopos_invoices where (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34)  and method=$tip $whre");
        $result = $query->result_array();
        $total=0;

        $type='';
        if($tip==1) //NAkit
        {
            $type ='13';
        }
        else {
            $type ='31';
        }
        $hakedis=$ci->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where (invoice_type_id=$type or invoice_type_id=26) and method=$tip $whre")->row_array();
        $hakedis=$hakedis['total_hak'];



        if ($query->num_rows() > 0)
        {
            foreach ($result as $row)
            {
                $total+=$row['total']; // avans toplam
            }
            $kalan = $hakedis-$total;

        }
        else
        {
            $kalan=$hakedis;
        }



        return ['avans'=>$total,'kalan'=>$kalan,'hakedis'=>$hakedis];
    }

    function gider_kalemi($talep_id) {
        $ci =& get_instance();
        $ci->load->database();
        $desc ='';

        $hakedis=$ci->db->query("SELECT * FROM `geopos_talep_items` WHERE `tip` = $talep_id ORDER BY `id` DESC")->result_array();
        foreach ($hakedis as $rows){
            $desc.=' '.$rows['product_name'];
        }

        return $desc;
    }

    function developer_onayi($talep_id) {
        $ci =& get_instance();
        $ci->load->database();

        $durum=$ci->db->query("SELECT * FROM `geopos_developer_table` WHERE `talep_id` = $talep_id");

        if($durum->num_rows()>0){
              if($durum->row()->status==1){
                  return 1;
              }
              else{
                  return 0;
              }
          }
          else{
              return 0;
          }

    }

    function forma_2_pay_history($id){
        $ci =& get_instance();
        $ci->load->database();
        $data = [];
        $result = [];

        $query=$ci->db->query("SELECT * FROM `geopos_invoice_transactions`  Where invoice_id = $id and tip=1");
        $query2=$ci->db->query("SELECT transaction_pay.*,geopos_employees.name, -1 as invoice_type_id  FROM `transaction_pay` INNER JOIN geopos_employees ON transaction_pay.aauth_id=geopos_employees.id WHERE transaction_pay.forma2_id=$id ORDER BY transaction_pay.id DESC");

        if($query->num_rows()>0){
            foreach ($query->result() as $value){
                $data[]=$ci->db->query("SELECT geopos_invoices.*,geopos_invoice_transactions.total as total_transaction FROM `geopos_invoices` INNER JOIN geopos_invoice_transactions ON geopos_invoices.id = geopos_invoice_transactions.transaction_id WHERE geopos_invoices.id = $value->transaction_id and geopos_invoice_transactions.invoice_id = $id ")->row();
            }

            foreach ($data as $key){
                $result[]=$key;
            }
        }

        if($query2->num_rows()>0){
            foreach ($query2->result() as $key){
                $result[]=$key;
            }
        }


        return $result;

    }

function customer_parent($id){
    $ci =& get_instance();
    $ci->load->database();

    $id_parent = [];
    $query=$ci->db->query("SELECT *  FROM customer_to_parent Where customer_id =$id")->result();
    foreach ($query as $value)
    {
        $id_parent[] = $value->parent_id;
    }

    return $id_parent;
}
function talep_pay_history($id){
    $ci =& get_instance();
    $ci->load->database();

    $query=$ci->db->query("SELECT SUM(total) as total FROM `geopos_invoice_transactions`  Where invoice_id = $id and tip=7")->row();
    return $query->total;

}
function sf_firma_total($talep_id,$firma){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT SUM(subtotal) as total FROM `geopos_talep_items` WHERE `firma` = '$firma' and tip=$talep_id")->row();

    return amountFormat($query2->total);
}

function forma_2_kontrol($inv){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM  invoice_to_forma_2 WHERE invoice_id=$inv");
    if($query2->num_rows()){
        return false;
    }
    else
    {
        return true;
    }

}
function tehvil_durumu($inv){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM  invoice_to_tehvil WHERE tehvil_id=$inv");
    if($query2->num_rows()){
        return true;
    }
    else
    {
        return false;
    }

}

function protokoller($cari_id){

    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `cari_razilastirma` WHERE `cari_id` = $cari_id and deleted_at is null and razi_status =1");
    if($query2->num_rows()){
        return $query2->result();
    }
    else {
        return false;
    }

}

function personel_mezuniyet_x($pers_id,$tip,$start,$end){

    $ci =& get_instance();
    $ci->load->database();

    $date = new DateTime('now');

    if($tip==1)//mezuniyet
    {
        $query2 = $ci->db->query("SELECT * FROM `salary_grad` WHERE `personel_id` = $pers_id and (created_at >= '$start' and created_at  <= '$end') and mezuniyer_st =1");
        if($query2->num_rows()){
            return $query2->num_rows();
        }
        else {
            return false;
        }

    }
    else {
        $hastalik=[];
        $query2 = $ci->db->query("SELECT * FROM `salary_grad` WHERE `personel_id` = $pers_id and (created_at >= '$start' and created_at  <= '$end') and hastalik_st =1");
        if($query2->num_rows()){
            $count=0;
            $tutar=0;
           foreach ($query2->result() as $values){
               $count++;
               $tutar=floatval($values->hastalik_tutar);
           }
           return array('hastalik_sayisi'=>$count,'tutar'=>$tutar);
        }
        else {
            return false;
        }
    }



}

function lojistik_durum_kontrol($id,$talep_id){
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT lojistik_onay.created_at,lojistik_onay.desc,lojistik_status.name FROM `lojistik_onay` INNER JOIN lojistik_status ON lojistik_onay.status=lojistik_status.id WHERE lojistik_onay.user_id = $id and lojistik_onay.talep_id=$talep_id and lojistik_onay.type=1 ORDER BY `lojistik_onay`.`id` DESC LIMIT 1");
    if($query2->num_rows()){
        return '<p style="width: fit-content;font-size: 10px;background: #cdcdcd;padding: 4px;">Onay Saati : '.$query2->row()->created_at.' Açıklama : '.$query2->row()->desc.' Durumu : '.$query2->row()->name."</p>";
    }
    else {
        return "";
    }
}
function arac_form_step_durum($id,$talep_id){
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM aracform_step Where user_id = $id and form_id=$talep_id");
    if($query2->num_rows()){
        $status = 'Bekliyor';
        $desc='';
        $date='';
        if($query2->row()->status==1){
            $status = 'Onaylandı';
            $desc = $query2->row()->desc;
            $date= $query2->row()->created_at;
        }
        elseif($query2->row()->status==2){
            $status = 'İptal Edildi';
            $desc = $query2->row()->desc;
            $date= $query2->row()->created_at;
        }
        return '<p style="width: fit-content;font-size: 10px;padding: 4px;">Onay Saati : '.$date.' Açıklama : '.$desc.' Durumu : '.$status."</p>";
    }
    else {
        return "";
    }
}


function personel_belge_kontrol($pers_id,$arac_id,$type,$arac_suruculeri_id){
    $ci =& get_instance();
    $ci->load->database();

    $whre='';
    if($type!=8){
        $whre=" and arac_id=$arac_id ";
    }
    $query2 = $ci->db->query("SELECT * FROM geopos_documents_pers Where fid = $pers_id and file_type=$type $whre");
    if($query2->num_rows()){
        $file = $query2->row()->filename;
        return "<a href='/userfiles/documents/$file' target='_blank' class='btn btn-success'><i class='fa fa-image'></i> Var</a>";
    }
    else {
        $kontrol = $ci->db->query("SELECT * FROM belge_talep_kontrol Where user_id = $pers_id and arac_id=$arac_id and type=$type and arac_suruculeri_id=$arac_suruculeri_id");
        if($kontrol->num_rows()){
            if($kontrol->row()->status==1){
               return "<span class='badge badge-warning'>Belge Talep Edilmiş</span>";
            }
        }
        else {
            return "<button type='button' class='btn btn-info belge_talep' arac_suruculeri_id='$arac_suruculeri_id' filetype='$type' pers_id='$pers_id'><i class='fa fa-question'></i> Belge Talep Et</button>";
        }

    }
}

function lojistiksf_durum_kontrol($id,$talep_id){
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT lojistik_onay.created_at,lojistik_onay.desc,lojistik_status.name FROM `lojistik_onay` INNER JOIN lojistik_status ON lojistik_onay.status=lojistik_status.id WHERE lojistik_onay.user_id = $id and lojistik_onay.talep_id=$talep_id and lojistik_onay.type=2 ORDER BY `lojistik_onay`.`id` DESC LIMIT 1");
    if($query2->num_rows()){
        return '<p style="line-height: 20px;font-size: 11px;padding-top: 10px;">Onay Saati : '.$query2->row()->created_at.'<br> Açıklama : '.$query2->row()->desc.' <br>Durumu : '.$query2->row()->name."</p>";
    }
    else {
        return "";
    }
}

function lojistik_status($id){
    $ci =& get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM  lojistik_status WHERE id=$id ");
    if($query2->num_rows()){
        return $query2->row()->name;
    }
    else {
        return "";
    }
}

function lojistik_sf_details($talep_id,$user_id){
    $ci =& get_instance();
    $ci->load->database();

    $totals = $ci->db->query("SELECT * FROM lojistik_satinalma_total Where  sf_id = $talep_id and user_id = $user_id");
    if($totals->num_rows()){
        return [
            'total'=>amountFormat($totals->row()->total)
        ];
    }
   else {
       return [
           'total'=>amountFormat(0)
       ];
   }

}
function lojistik_items_location($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT * FROM `locations`  Where  lojistik_id = $lojistik_id and item_id = $item_id and type =$type");
    if($totals->num_rows()){
        $i=1;
        foreach ($totals->result() as $values){
            $html.='<span class="badge badge-info">'.$i.'-'.$values->location.'</span>&nbsp;';
            $i++;
        }
        return $html;
    }
   else {
       return $html;
   }

}
function surucu_status($id){
    $ci =& get_instance();
    $ci->load->database();
    return $ci->db->query("SELECT * FROM `surucu_status`  Where  id = $id")->row()->html;
}
function arac_surucu_kontrol($arac_id){
    $ci =& get_instance();
    $ci->load->database();
     $kontrol = $ci->db->query("SELECT * FROM `arac_suruculeri`  Where  arac_id = $arac_id and status=2");
    if($kontrol->num_rows()){
        if(personel_details($kontrol->row()->user_id)=='Firma'){
            return 'Sürücü Atanmamış';
        }
        else {
            return personel_details($kontrol->row()->user_id);
        }
    }
    else {
        return "";
    }
}

function datetimefark($bitis,$baslangic){
    $fark = strtotime($bitis) - strtotime($baslangic);
    $dakika = $fark / 60;
    $saniye_farki = floor($fark - (floor($dakika) * 60));

    $saat = $dakika / 60;
    $dakika_farki = floor($dakika - (floor($saat) * 60));

    $gun = $saat / 24;
    $saat_farki = floor($saat - (floor($gun) * 24));

    $yil = floor($gun/365);
    $gun_farki = floor($gun - (floor($yil) * 365));
    return [
        'yil'=>$yil,
        'gun'=>$gun_farki,
        'saat'=>$saat_farki,
        'dakika'=>$dakika_farki,
        'saniye'=>$saniye_farki,
    ];
}


function surucu_status_result(){
    $ci =& get_instance();
    $ci->load->database();
    return $ci->db->query("SELECT * FROM `surucu_status`")->result();
}
function lojistik_items_sf_html($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT geopos_talep.* FROM `lojistik_sf` INNER JOIN geopos_talep ON lojistik_sf.sf_id =geopos_talep.id Where  lojistik_sf.lojistik_id = $lojistik_id and item_id = $item_id and lojistik_sf.type =$type");
    if($totals->num_rows()){
        $i=1;
        foreach ($totals->result() as $values){
           $html.='<span class="badge badge-info">'.$values->talep_no.'</span>&nbsp;';
            $i++;
        }
        return $html;
    }
   else {
       return $html;
   }

}
function lojistik_items_sf($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT geopos_talep.* FROM `lojistik_sf` INNER JOIN geopos_talep ON lojistik_sf.sf_id =geopos_talep.id Where  lojistik_sf.lojistik_id = $lojistik_id and item_id = $item_id and lojistik_sf.type =$type");
    if($totals->num_rows()){
        $i=1;
        foreach ($totals->result() as $values){
            $html.='<a href="/form/satinalma_view?id='.$values->id.'" <span class="badge badge-warning">'.$values->talep_no.'</span></a>&nbsp;';
            $i++;
        }
        return $html;
    }
   else {
       return $html;
   }

}
function lojistik_items_protokol($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT cari_razilastirma.* FROM `satinalma_protokol` INNER JOIN cari_razilastirma ON satinalma_protokol.protokol_id =cari_razilastirma.id Where  satinalma_protokol.lojistik_id = $lojistik_id and satinalma_protokol.sf_item_id = $item_id");
    if($totals->num_rows()){
        $i=1;
        foreach ($totals->result() as $values){
            $html.='<button class="btn btn-success btn-sm razi_view" type="button" data-object-id="'.$values->id.'">'.$values->code.'</button>&nbsp;';
            $i++;
        }
        return $html;
    }
   else {
       return $html;
   }

}
function lojistik_items_protokol_($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT cari_razilastirma.* FROM `satinalma_protokol` INNER JOIN cari_razilastirma ON satinalma_protokol.protokol_id =cari_razilastirma.id Where  satinalma_protokol.lojistik_id = $lojistik_id and satinalma_protokol.sf_item_id = $item_id");
    if($totals->num_rows()){

        return $totals->result();
    }
   else {
       return $html;
   }

}
function lojistik_items_personel($lojistik_id,$item_id){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT * FROM lojistik_to_personel Where lojistik_id = $lojistik_id and item_id =$item_id");
    if($totals->num_rows()){
        return personel_details($totals->row()->pers_id);
    }
   else {
       return $html;
   }

}
function lojistik_items_personel_($lojistik_id,$item_id){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT * FROM lojistik_to_personel Where lojistik_id = $lojistik_id and item_id =$item_id");
    if($totals->num_rows()){
        return $totals->row()->pers_id;
    }
   else {
       return $html;
   }

}
function durum_sorgula($arac_id){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT * FROM surucu_notes Where arac_id = $arac_id ORDER BY `surucu_notes`.`id` DESC LIMIT 1");
    if($totals->num_rows()){
        $status_id =  $totals->row()->surucu_notes_status_id;
        return $ci->db->query("SELECT * FROM surucu_notes_status Where id = $status_id")->row()->name;

    }
   else {
       return $html;
   }

}
function lojistik_items_location_($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT * FROM `locations`  Where  lojistik_id = $lojistik_id and item_id = $item_id and type =$type");
    if($totals->num_rows()){
        return $totals->result() ;
    }
    else {
        return false;
    }

}
function arac_history_status($status_id=0){
    $ci =& get_instance();
    $ci->load->database();
    $totals=0;
    if($status_id==0){
        $totals = $ci->db->query("SELECT * FROM `arac_history_status`")->result();
        return $totals;
    }
    else {
        $totals = $ci->db->query("SELECT * FROM `arac_history_status` WHERE id=$status_id")->row();
        return $totals;
    }

}
function lojistik_items_sf_($lojistik_id,$item_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $html='';
    $totals = $ci->db->query("SELECT geopos_talep.* FROM `lojistik_sf` INNER JOIN geopos_talep ON lojistik_sf.sf_id = geopos_talep.id Where  lojistik_sf.lojistik_id = $lojistik_id and item_id = $item_id and lojistik_sf.type =$type");
    if($totals->num_rows()){
        return $totals->result() ;
    }
    else {
        return false;
    }

}
function file_item_toplam_tutar_sorgula($file_id){
    $ci =& get_instance();
    $ci->load->database();
    $html=0;
    $totals = $ci->db->query("SELECT * FROM lsf_table_file_item Where lsf_table_file_id=$file_id and status=1");
    if($totals->num_rows()){
        foreach($totals->result() as $items){
            $tot = floatval($items->toplam_teklif)+floatval($items->toplam_gider);
            $html+=$tot;
        }
        return $html;
    }
    else {
        return false;
    }

}
function personel_bakiye_report($id){
    $ci =& get_instance();
    $ci->load->database();

    $nakit_borc=0;
    $bakiye=0;
    $nakit_bakiye=0;
    $nakit_alacak=0;
    $banka_alacak=0;
    $banka_borc=0;
    $banka_bakiye=0;
    $result = $ci->db->query("SELECT geopos_invoices.id,geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (12,13,14,31,49,53,26,15) and geopos_invoices.`invoicedate` > '2020-12-31 23:59:59'
                ORDER BY invoicedate ASC");
    if($result->num_rows()){
        foreach ($result->result() as $ites){
            if($ites->odeme_tipi){
                if($ites->odeme_tipi==1) // Nakit
                {
                    $nakit_borc+=$ites->borc;
                    $nakit_alacak+=$ites->alacak;
                }
                elseif($ites->odeme_tipi==3){ //banka
                    $banka_borc+=$ites->borc;
                    $banka_alacak+=$ites->alacak;
                }
            }
            else {

                if($ites->notes=='Banka Hakediş'){ //banka
                    $banka_borc+=$ites->borc;
                    $banka_alacak+=$ites->alacak;
                }
                else {

                    $nakit_borc+=$ites->borc;
                    $nakit_alacak+=$ites->alacak;
                }
            }
        }
        $borc = $banka_borc+$nakit_borc;
        $bor = $banka_borc+$nakit_borc;
        $alacak = $banka_alacak+$nakit_alacak;

        $bakiye += ($borc-$alacak);


    }
    return  amountFormat(abs($bakiye)).($bakiye>0?" (B)":" (A)");;
}


function onay_sort($type,$proje_id,$personel_id=0,$talep_id=0){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $data=[];
    if($type==1) // Bu Bir Malzeme Talebi İse
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
            {
                return false;
            }
            else
            {

                $san_tex=0;
                $kontrol = $ci->db->query("SELECT * FROM talep_form_products Where form_id=$talep_id");
                if($kontrol->num_rows()){
                    foreach ($kontrol->result() as $items){
                        $cat_kontrol = $ci->db->query("SELECT * FROM geopos_products Where pid=$items->product_id and pcat=186");
                        if($cat_kontrol->num_rows()){
                            $san_tex++;
                        }
                    }
                }
                $loc = $ci->session->userdata('set_firma_id');
                if($loc!=15){
                    if($san_tex){
                        $data = [

                            ['sort'=>1,'user_id'=>522], //hacıali
                            ['sort'=>2,'user_id'=>$proje_sorumlusu],
                            ['sort'=>3,'user_id'=>$proje_muduru_id],
                            ['sort'=>4,'user_id'=>1009],
                            ['sort'=>5,'user_id'=>$genel_mudur_id]
                        ];
                    }
                    else {
                        $data = [
                            ['sort'=>1,'user_id'=>$proje_sorumlusu],
                            ['sort'=>2,'user_id'=>$proje_muduru_id],
                            ['sort'=>3,'user_id'=>1009],
                            ['sort'=>4,'user_id'=>946],
                            ['sort'=>5,'user_id'=>$genel_mudur_id]
                        ];
                    }
                }
                else {
                    $data = [
                        ['sort'=>1,'user_id'=>$proje_sorumlusu],
                        ['sort'=>2,'user_id'=>$proje_muduru_id],
                        ['sort'=>3,'user_id'=>$genel_mudur_id]
                    ];
                }


                return $data;

            }
        }



    }
    elseif($type==2) //cari gider talebi ise
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
            {
                return false;
            }
            else
            {



                $san_tex=0;
                $kontrol = $ci->db->query("SELECT * FROM talep_form_customer_new Where id=$talep_id and demirbas_id IN(6,615,433)");
                if($kontrol->num_rows()){
                    $san_tex++;
                }
                $loc = $ci->session->userdata('set_firma_id');
                if($loc!=15){
                    if($san_tex){
                        $data = [
                            ['sort'=>1,'user_id'=>21],
                            ['sort'=>2,'user_id'=>1006],
                            ['sort'=>3,'user_id'=>946],
                            ['sort'=>4,'user_id'=>$proje_sorumlusu],
                            ['sort'=>5,'user_id'=>$proje_muduru_id],
                            ['sort'=>6,'user_id'=>946],
                            ['sort'=>7,'user_id'=>1009],
                            ['sort'=>8,'user_id'=>$genel_mudur_id],
                            ['sort'=>9,'user_id'=>$muhasebe_muduru_id]
                        ];
                    }
                    else {
                        $data = [
                            ['sort'=>1,'user_id'=>21],
                            ['sort'=>2,'user_id'=>$proje_sorumlusu],
                            ['sort'=>3,'user_id'=>$proje_muduru_id],
                            ['sort'=>4,'user_id'=>39],
                            ['sort'=>5,'user_id'=>946],
                            ['sort'=>6,'user_id'=>1009],
                            ['sort'=>7,'user_id'=>$genel_mudur_id],
                            ['sort'=>8,'user_id'=>$muhasebe_muduru_id]
                        ];
                    }
                }
                else {
                    $data = [
                        ['sort'=>1,'user_id'=>$proje_sorumlusu],
                        ['sort'=>2,'user_id'=>$proje_muduru_id],
                        ['sort'=>3,'user_id'=>$genel_mudur_id],
                        ['sort'=>4,'user_id'=>$muhasebe_muduru_id]
                    ];
                }




                return $data;

            }
        }


    }
    elseif($type==3) //Personel gider talebi ise
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
            {
                return false;
            }
            else
            {
                $loc = $ci->session->userdata('set_firma_id');
                if($loc!=15){
                    $sorumlu_pers_id = $ci->db->query("SELECT * FROM geopos_employees Where id=$personel_id")->row()->sorumlu_pers_id;
                    $data = [
                        ['sort'=>1,'user_id'=>21],
                        ['sort'=>2,'user_id'=>946],
                        ['sort'=>3,'user_id'=>$sorumlu_pers_id],
                        ['sort'=>4,'user_id'=>946],
                        ['sort'=>5,'user_id'=>1009],
                        ['sort'=>6,'user_id'=>$genel_mudur_id],
                        ['sort'=>7,'user_id'=>$muhasebe_muduru_id]
                    ];
                }
                else{
                    $sorumlu_pers_id = $ci->db->query("SELECT * FROM geopos_employees Where id=$personel_id")->row()->sorumlu_pers_id;
                    $data = [
                        ['sort'=>1,'user_id'=>$sorumlu_pers_id],
                        ['sort'=>2,'user_id'=>$genel_mudur_id],
                        ['sort'=>3,'user_id'=>$muhasebe_muduru_id]
                    ];
                }


                return $data;

            }
        }


    }
    elseif($type==4) //cari Avans talebi ise
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
            {
                return false;
            }
            else
            {
                $data = [
                    ['sort'=>1,'user_id'=>$muhasebe_muduru_id],
                    ['sort'=>2,'user_id'=>$proje_sorumlusu],
                    ['sort'=>3,'user_id'=>$proje_muduru_id],
                    ['sort'=>4,'user_id'=>946],
                    ['sort'=>5,'user_id'=>1009],
                    ['sort'=>6,'user_id'=>$genel_mudur_id],
                    ['sort'=>7,'user_id'=>39]



                ];

                return $data;

            }
        }


    }
    elseif($type==5) //Personel Avans talebi ise
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
            {
                return false;
            }
            else
            {


                $loc = $ci->session->userdata('set_firma_id');
                if($loc!=15){
                    $sorumlu_pers_id = $ci->db->query("SELECT * FROM geopos_employees Where id=$personel_id")->row()->sorumlu_pers_id;
                    $data = [
                        ['sort'=>1,'user_id'=>62],
                        ['sort'=>2,'user_id'=>$sorumlu_pers_id],
                        ['sort'=>3,'user_id'=>1009],
                        ['sort'=>4,'user_id'=>$genel_mudur_id],
                        ['sort'=>5,'user_id'=>$muhasebe_muduru_id]
                    ];
                }
                else
                {
                    $sorumlu_pers_id = $ci->db->query("SELECT * FROM geopos_employees Where id=$personel_id")->row()->sorumlu_pers_id;
                    $data = [
                        ['sort'=>1,'user_id'=>$sorumlu_pers_id],
                        ['sort'=>2,'user_id'=>$genel_mudur_id],
                        ['sort'=>3,'user_id'=>$muhasebe_muduru_id]
                    ];
                }
                return $data;
            }
        }


    }
    elseif($type==6) // Malzeme listesi Onayı
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
            {
                return false;
            }
            else
            {
                $data = [
                    ['sort'=>1,'user_id'=>$proje_sorumlusu],
                    ['sort'=>2,'user_id'=>$proje_muduru_id],
                    ['sort'=>3,'user_id'=>1009],
                    ['sort'=>4,'user_id'=>$genel_mudur_id],
                    ['sort'=>5,'user_id'=>21]
                ];

                return $data;

            }
        }



    }
    else if($type==7) // sadece malzeme talep onayıdır
    {

        $talep_details = $ci->db->query("SELECT * FROM talep_form Where id = $talep_id")->row();
        $depo_sorumlusu=0;

        $warehouse_details = $ci->db->query("SELECT * FROM geopos_warehouse Where id = $talep_details->warehouse_id")->row();
        if($warehouse_details->pers_id){
            $depo_sorumlusu=$warehouse_details->pers_id;
        }


        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null) || ($depo_sorumlusu==0))
            {
                return false;
            }
            else
            {
                $san_tex=0;
                $kontrol = $ci->db->query("SELECT * FROM talep_form_products Where form_id=$talep_id");
                if($kontrol->num_rows()){
                    foreach ($kontrol->result() as $items){
                        $cat_kontrol = $ci->db->query("SELECT * FROM geopos_products Where pid=$items->product_id and pcat=186");
                        if($cat_kontrol->num_rows()){
                            $san_tex++;
                        }
                    }
                }

                $loc = $ci->session->userdata('set_firma_id');
                if($loc!=15){
                    if($san_tex){
                        $data = [
                            ['sort'=>1,'user_id'=>522], // Hacıali
                            ['sort'=>2,'user_id'=>$depo_sorumlusu],
                            ['sort'=>3,'user_id'=>$proje_sorumlusu],
                            ['sort'=>4,'user_id'=>$proje_muduru_id],
                            ['sort'=>5,'user_id'=>1009],
                            ['sort'=>6,'user_id'=>$genel_mudur_id]
                        ];
                    }
                    else {
                        $data = [
                            ['sort'=>1,'user_id'=>$depo_sorumlusu],
                            ['sort'=>2,'user_id'=>$proje_sorumlusu],
                            ['sort'=>3,'user_id'=>$proje_muduru_id],
                            ['sort'=>4,'user_id'=>1009],
                            ['sort'=>5,'user_id'=>$genel_mudur_id]
                        ];
                    }
                }
                else {
                    $data = [
                        ['sort'=>1,'user_id'=>$depo_sorumlusu],
                        ['sort'=>2,'user_id'=>$proje_sorumlusu],
                        ['sort'=>3,'user_id'=>$proje_muduru_id],
                        ['sort'=>4,'user_id'=>$genel_mudur_id]
                    ];
                }
                return $data;
            }
        }


    }
    elseif($type==8) // Bu Bir forma2 ise
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = 66;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;

        if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null)|| ($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null))
        {
            return false;
        }
        else
        {
            $data = [

                ['sort'=>1,'user_id'=>39],
                ['sort'=>2,'user_id'=>$muhasebe_muduru_id],
                ['sort'=>3,'user_id'=>$proje_sorumlusu],
                ['sort'=>4,'user_id'=>$proje_muduru_id],
                ['sort'=>5,'user_id'=>1009],
                ['sort'=>6,'user_id'=>$genel_mudur_id],
                ['sort'=>7,'user_id'=>946],
                ['sort'=>8,'user_id'=>39],

            ];

            return $data;

        }

    }
    elseif($type==9) // Bu Bir maaş Onay sıralaması
    {
        $proje_details = $ci->db->query("SELECT * FROM maas_onay_sort Where proje_id=$proje_id ORDER BY sort asc");
        $data=[];
        if($proje_details->num_rows()){
            foreach ($proje_details->result() as $items){
                $data[] = ['sort'=>$items->sort,'user_id'=>$items->user_id];
            }
            return $data;
        }
        else
        {
            return  false;
        }
    }
    elseif($type==10) // Bu izin talebiyse
    {
        $sorumlu_pers_id = personel_details_full($personel_id)['sorumlu_pers_id'];
        $proje_id_ = $ci->db->query("SELECT * FROM personel_salary  Where personel_id=$personel_id and status=1")->row()->proje_id;
        $proje_muduru = $ci->db->query("SELECT * FROM  geopos_projects Where id=$proje_id_")->row()->proje_muduru_id;
        $data=[];
        $loc = $ci->session->userdata('set_firma_id');
        if($loc==5){
            if($proje_id_==46){
                $data = [
                    ['sort'=>1,'user_id'=>1007],
                    ['sort'=>2,'user_id'=>$sorumlu_pers_id],
                    ['sort'=>3,'user_id'=>62],
                    ['sort'=>4,'user_id'=>39],

                ];
            }
            else {
                $data = [
                    ['sort'=>1,'user_id'=>1007],
                    ['sort'=>2,'user_id'=>$sorumlu_pers_id],
                    ['sort'=>3,'user_id'=>$proje_muduru],
                    ['sort'=>4,'user_id'=>62],
                    ['sort'=>5,'user_id'=>39],


                ];
            }

        }
        else {
            $data = [

                ['sort'=>1,'user_id'=>$sorumlu_pers_id],
                ['sort'=>2,'user_id'=>$proje_muduru]

            ];
        }

        return $data;
    }
    else if($type==11) // lojistik_talebi
    {

        $talep_details = $ci->db->query("SELECT * FROM talep_form_nakliye Where id = $talep_id")->row();

        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;


        if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
        {
            return false;
        }
        else
        {
            $loc = $ci->session->userdata('set_firma_id');
            if($loc!=15){
                $data = [

                    ['sort'=>1,'user_id'=>$proje_sorumlusu],
                    ['sort'=>2,'user_id'=>$proje_muduru_id],
                    ['sort'=>3,'user_id'=>1009],
                    ['sort'=>4,'user_id'=>$genel_mudur_id],
                    ['sort'=>5,'user_id'=>289]
                ];
            }
            else {
                $data = [
                    ['sort'=>1,'user_id'=>$proje_sorumlusu],
                    ['sort'=>2,'user_id'=>$proje_muduru_id],
                    ['sort'=>3,'user_id'=>$genel_mudur_id]
                ];
            }
            return $data;
        }
    }
    elseif($type==12) // Bu Bir faturaysa
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muhasebe_mudur_id  = $proje_details->muhasebe_muduru_id;
        $proje_muduru_id  = 66;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;

        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null)|| ($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null)|| ($proje_muhasebe_mudur_id==0 || $proje_muhasebe_mudur_id==null))
            {
                return false;
            }
            else
            {
                $data = [
                    ['sort'=>1,'user_id'=>946],
                    ['sort'=>2,'user_id'=>$proje_muhasebe_mudur_id],
                    ['sort'=>3,'user_id'=>$proje_sorumlusu],
                    ['sort'=>4,'user_id'=>$proje_muduru_id],
                    ['sort'=>5,'user_id'=>946],
                    ['sort'=>6,'user_id'=>1009],
                    ['sort'=>7,'user_id'=>$genel_mudur_id],
                    ['sort'=>8,'user_id'=>39],

                ];

                return $data;

            }
        }



    }
    elseif($type==13) // Bu bir nakkliye talebinde depolar arasu transfer ise
    {
        $item_id = $talep_id;
        $result = $ci->db->query("SELECT * FROM nakliye_talep_transfer_item Where n_item_id=$talep_id ORDER BY sort ASC");
        if($result->num_rows()){

            foreach ($result->result() as $items){
                $sort=$items->sort;
                $user_id = warehouse_details($items->warehouse_id)->pers_id;
                if($user_id){
                    $data[] = ['sort'=>$sort,'user_id'=>$user_id,'nakliye_talep_transfer_item_id'=>$items->id];
                }
                else {
                    $data=[];
                    break;

                }
            }

        }

        return $data;

    }
    elseif($type==14) // Bu Bir malzeme talebi stok kontrol aşamasıysa
    {
        $talep_type = $ci->db->query("SELECT * FROM talep_form Where id = $talep_id")->row()->talep_type;
        if($talep_type==3){
            $data = [
                ['sort'=>1,'user_id'=>21]
            ];
        }
        else {
            $data = [
                ['sort'=>1,'user_id'=>984]
            ];
        }


        return $data;
    }
    elseif($type==15) // razılaştırma
    {
        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muhasebe_mudur_id  = $proje_details->muhasebe_muduru_id;
        $proje_muduru_id  = 66;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;
        if($proje_id==220){ //gizli
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        elseif($proje_id==219){ //ege
            $data = [
                ['sort'=>1,'user_id'=>$proje_muduru_id],
                ['sort'=>2,'user_id'=>39],
                ['sort'=>3,'user_id'=>$genel_mudur_id]
            ];
        }
        else {
            if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null)|| ($muhasebe_muduru_id==0 || $muhasebe_muduru_id==null)|| ($proje_muhasebe_mudur_id==0 || $proje_muhasebe_mudur_id==null))
            {
                return false;
            }
            else
            {
                $data = [
                    ['sort'=>1,'user_id'=>$proje_muhasebe_mudur_id],
                    ['sort'=>2,'user_id'=>$proje_sorumlusu],
                    ['sort'=>3,'user_id'=>$proje_muduru_id],
                    ['sort'=>4,'user_id'=>$genel_mudur_id],

                ];

                return $data;

            }
        }


    }
    else if($type==16) // lojistik_talebi satınalma
    {

        $talep_details = $ci->db->query("SELECT * FROM talep_form_nakliye Where id = $talep_id")->row();

        $proje_details = $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muduru_id  = $proje_details->proje_muduru_id;
        $genel_mudur_id  = $proje_details->genel_mudur_id;

        if(($proje_sorumlusu==0 || $proje_sorumlusu==null) || ($proje_muduru_id==0 || $proje_muduru_id==null) || ($genel_mudur_id==0 || $genel_mudur_id==null))
        {
            return false;
        }
        else
        {
            $loc = $ci->session->userdata('set_firma_id');
            if($loc!=15){
                $data = [

                    ['sort'=>1,'user_id'=>$proje_sorumlusu],
                    ['sort'=>2,'user_id'=>$proje_muduru_id],
                    ['sort'=>3,'user_id'=>946],
                    ['sort'=>4,'user_id'=>1009],
                    ['sort'=>5,'user_id'=>$genel_mudur_id],
                    ['sort'=>6,'user_id'=>289]
                ];
            }
            else {
                $data = [
                    ['sort'=>1,'user_id'=>$proje_sorumlusu],
                    ['sort'=>2,'user_id'=>$proje_muduru_id],
                    ['sort'=>3,'user_id'=>$genel_mudur_id]
                ];
            }
            return $data;
        }
    }

}



function talep_history($id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT talep_history.* FROM talep_history Where talep_id=$id ORDER BY talep_history.id DESC");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_history_customer($id,$tip=1){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT customer_talep_history.* FROM customer_talep_history Where talep_id=$id and tip=$tip ORDER BY customer_talep_history.id DESC");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_history_nakliye($id,$tip=1){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT talep_form_nakliye_history.* FROM talep_form_nakliye_history Where talep_id=$id ORDER BY talep_form_nakliye_history.id DESC");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_history_personel($id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT personel_talep_history.* FROM personel_talep_history Where talep_id=$id ORDER BY personel_talep_history.id DESC");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_onay_new($type,$id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and type=$type ORDER BY `talep_onay_new`.`sort` ASC ");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_onay_new_invoices($type,$id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT * FROM invoices_onay_new Where invoices_id=$id and type=$type ORDER BY `invoices_onay_new`.`sort` ASC ");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_onay_new_who($type,$id,$user_id){
    $ci =& get_instance();
    $ci->load->database();

    $durum = false;
    $proje_details = $ci->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and type=$type and user_id = $user_id");
    if($proje_details->num_rows()){
       foreach ( $proje_details->result() as $items){
           if($items->staff==1){
              $durum = true;
              continue;
           }
       }

    }
    return $durum;
}

function invoices_talep_onay_new_who($type,$id,$user_id){
    $ci =& get_instance();
    $ci->load->database();

    $durum = false;
    $g_durum = false;
    $proje_details = $ci->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and type=$type and user_id = $user_id");
    if($proje_details->num_rows()){
        foreach ( $proje_details->result() as $items){
            if($items->staff==1){
                $durum = true;
                continue;
            }
        }
    }
    if($durum){
        $proje_id =  $ci->db->query("SELECT * FROM geopos_invoices Where id=$id")->row()->proje_id;
        $proj_details =  $ci->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        if($user_id==$proj_details->genel_mudur_id){
            $g_durum=true;
        }
    }
    $array=['durum'=>$durum,'g_durum'=>$g_durum];
    return $array;
}



function talep_onay_customer_new($type,$id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT * FROM talep_onay_customer_new Where talep_id=$id and type=$type ORDER BY `talep_onay_customer_new`.`sort` ASC ");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}

function talep_onay_razilastirma($id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT * FROM razilastirma_onay Where razilastirma_id=$id ORDER BY `razilastirma_onay`.`sort` ASC ");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}
function talep_onay_nakliye($type,$id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT * FROM talep_onay_nakliye Where talep_id=$id and type=$type ORDER BY `talep_onay_nakliye`.`sort` ASC ");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}

function talep_onay_personel_new($type,$id){
    $ci =& get_instance();
    $ci->load->database();

    $proje_details = $ci->db->query("SELECT * FROM talep_onay_personel_new Where talep_id=$id and type=$type ORDER BY `talep_onay_personel_new`.`sort` ASC ");
    if($proje_details->num_rows()){
        return  $proje_details->result();
    }
    else {
        return false;
    }

}

function techizat_kontrol($id){
    $ci =& get_instance();
    $ci->load->database();
    $secili_meteralial=false;
    if($id){

        $item_count = $ci->db->query("SELECT * FROM talep_form_products Where form_id=$id")->num_rows();
        $proje_details = $ci->db->query("SELECT * FROM talep_form_cari Where talep_id=$id GROUP BY item_id")->num_rows();
        if($proje_details){
            $secili_meteralial = $ci->db->query("SELECT * FROM talep_form_cari Where talep_id=$id GROUP BY item_id")->result();
        }
        if($proje_details==$item_count){
            return  [
                'message'=>'<div class="col-md-2 text-success" style="padding-top: 8px;"><i class="fa fa-check margin-right-5"></i><b>Təbrik edirik :</b></div><div class="col-md-7" style="padding-top: 8px;"><span>Bu mərhələdə bütün əməliyyatları tamamladınız, növbəti mərhələyə keçə bilərsiniz.</span></div>',
                'secili_olanlar'=>$secili_meteralial,
                'durum'=>1,

            ];
        }
        elseif($proje_details==0){
            return  [
                'message'=>' <div class="col-md-2 text-danger"><i class="fa fa-exclamation-circle margin-right-5"></i><b>Xəbərdarlıq :</b></div><div class="col-md-10"><span>Siz heç bir cari seçməmisiniz</span></div>',
                'secili_olanlar'=>$secili_meteralial,
                'durum'=>0,
            ];
        }
        else {
            return  [
                'message'=>' <div class="col-md-2 text-danger"><i class="fa fa-exclamation-circle margin-right-5"></i><b>Xəbərdarlıq :</b></div><div class="col-md-10"><span>Siz bazı meteryallerde cari seçməmisiniz</span></div>',
                'secili_olanlar'=>$secili_meteralial,
                'durum'=>2,
            ];
        }
    }
    else {
        return  [
            'message'=>' <div class="col-md-2 text-danger"><i class="fa fa-exclamation-circle margin-right-5"></i><b>Xəbərdarlıq :</b></div><div class="col-md-10"><span>Siz bazı meteryallerde cari seçməmisiniz</span></div>',
            'secili_olanlar'=>$secili_meteralial,
            'durum'=>2,
        ];
    }



}
function techizat_kontrol_item($id){
    $ci =& get_instance();
    $ci->load->database();
    $data = [];

    $secili_meteralial = $ci->db->query("SELECT * FROM talep_form_cari Where item_id=$id");
    if($secili_meteralial->num_rows()){
       foreach ($secili_meteralial->result() as $items){
           $data[]=[
               'cari_name'=>customer_details($items->cari_id)['company'],
               'cari_id'=>$items->cari_id
           ];
       }
    }
    return $data;
}
function techizatcilar($id){
    $ci =& get_instance();
    $ci->load->database();
    $data = [];
    $products = [];

    if($id){
        $secili_cari = $ci->db->query("SELECT * FROM talep_form_cari Where talep_id=$id GROUP BY cari_id");
        if($secili_cari->num_rows()){
            foreach ($secili_cari->result() as $items){
                $products =  $ci->db->query("SELECT talep_form_products.* FROM talep_form_cari INNER JOIN talep_form_products ON talep_form_cari.item_id = talep_form_products.id Where talep_id=$id and cari_id=$items->cari_id")->result();
                $data[]=[
                    'cari_name'=>customer_details($items->cari_id)['company'],
                    'cari_phone'=>customer_details($items->cari_id)['phone'],
                    'cari_email'=>customer_details($items->cari_id)['email'],
                    'cari_id'=>$items->cari_id,
                    'products'=>$products,
                ];
            }
        }
    }



    return $data;
}
function techizatcilar_items($id,$cari_id){
    $ci =& get_instance();
    $ci->load->database();
    $data = [];
    $products = [];

    if($id){
        foreach ($cari_id as $items){
            $products =  $ci->db->query("SELECT talep_form_products.* FROM talep_form_cari INNER JOIN talep_form_products ON talep_form_cari.item_id = talep_form_products.id Where talep_id=$id and cari_id=$items")->result();
            $data[]=[
                'cari_name'=>customer_details($items)['company'],
                'cari_phone'=>customer_details($items)['phone'],
                'cari_email'=>customer_details($items)['email'],
                'cari_id'=>$items,
                'products'=>$products,
            ];
        }
    }




    return $data;
}
function techizatcilar_item($id,$cari_id){
    $ci =& get_instance();
    $ci->load->database();
    $products = [];
    if($id){
        $products =  $ci->db->query("SELECT talep_form_products.* FROM talep_form_cari INNER JOIN talep_form_products ON talep_form_cari.item_id = talep_form_products.id Where talep_id=$id and cari_id=$cari_id")->result();

    }
   return $products;
}
function teklif_durumlari($form_id,$cari_id){
    $ci =& get_instance();
    $ci->load->database();
    $data = [];
    if($form_id) {
        $details = $ci->db->query("SELECT talep_form_teklif_cari_details.* FROM talep_form_teklifler INNER JOIN talep_form_teklif_cari_details ON talep_form_teklifler.id = talep_form_teklif_cari_details.teklif_id Where talep_form_teklifler.form_id=$form_id and talep_form_teklifler.cari_id=$cari_id");
        if ($details->num_rows()) {

            foreach ($details->result() as $items) {
                $status = '<div style="padding-bottom: 5px;"><span data-html="true" rel="tooltip" title="" data-original-title="Gönderildi"><i class="fa fa-check" title="Göndərildi"></i> Göndərildi  <b>' . $items->create_at . '</b></span></div>';
                if ($items->status == 1) {
                    $status = '<div style="padding-bottom: 5px;"><span data-html="true" rel="tooltip" title="" data-original-title="Gönderildi"><i class="fa fa-check" title="Göndərildi"></i> Göndərildi  <b>' . $items->create_at . '</b></span></div>';
                } elseif ($items->status == 2) {
                    $status = '<div style="padding-bottom: 5px;"><span data-html="true" rel="tooltip" title="" data-original-title="Gönderildi"><i class="fa fa-check" title="Göndərildi"></i> Göndərildi  <b>' . $items->create_at . '</b></span></div>';
                    $status .= '<div style="padding-bottom: 5px;"><i class="fa fa-eye" title="Təklif Təchizatçı tərəfindən Baxılıb"></i> Təchizatçı Baxıldı  ' . $items->updated_at . '</div>';
                } elseif ($items->status == 3) {
                    $status = '<div style="padding-bottom: 5px;"><span data-html="true" rel="tooltip" title="" data-original-title="Gönderildi"><i class="fa fa-check" title="Göndərildi"></i> Göndərildi  <b>' . $items->create_at . '</b></span></div>';
                    $status .= '<div style="padding-bottom: 5px;"><i class="fa fa-eye" title="Təklif Təchizatçı tərəfindən Baxılıb"></i> Təchizatçı Baxıldı  <b>' . $items->updated_at . '</b></div>';
                    $status .= '<div style="padding-bottom: 5px;"><i class="fa fa-check" title="Təchizatçı Cavab verdi"></i> Təchizatçı Cavab verdi </div>';
                }
                $data[] = [
                    'phone' => '<div style="padding-bottom: 5px;"><i class="fa fa-phone"></i> ' . $items->phone . '</div>',
                    'status' => $status,
                    'status_id' => $items->status,
                    'teklif_id' => $items->teklif_id,
                ];
            }
            return ['status' => 1, 'data' => $data,];
        } else {
            return ['status' => 0, 'text' => '<div><i class="fa fa-clock"></i> Yaradılmağı gözləyir</div>'];
        }
    }
    else {
        return ['status' => 0, 'text' => '<div></div>'];
    }

}

function cari_to_teklif($cari_id,$form_id){
    $ci =& get_instance();
    $ci->load->database();
    if($form_id){
        $details =  $ci->db->query("SELECT * FROM talep_form_teklifler  Where talep_form_teklifler.form_id=$form_id and talep_form_teklifler.cari_id=$cari_id");
        if($details->num_rows()){
            return $details->row();
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }


}
function cari_to_teklif_details($item_id,$teklif_id){
    $ci =& get_instance();
    $ci->load->database();

        $details =  $ci->db->query("SELECT * FROM talep_form_teklifler_item  Where talep_form_teklifler_item.teklif_id=$teklif_id and talep_form_teklifler_item.item_id=$item_id");
        if($details->num_rows()){
            return $details->row();
        }
        else {
            return false;
        }



}

function teklif_update_kontrol($teklif_id){
    $ci =& get_instance();
    $ci->load->database();
    $details =  $ci->db->query("SELECT * FROM talep_form_teklifler_details  Where tf_teklif_id=$teklif_id");
    if($details->num_rows()){
       $details_ = $details->row();
        return [
            'details'=> $details_,
            'item_details'=> $ci->db->query("SELECT * FROM talep_form_teklifler_item_details  Where details_id=$details_->id")->result(),
        ];
    }
    else {
        return false;
    }

}
function teklif_update_item_kontrol($item_id,$details_id){
    $ci =& get_instance();
    $ci->load->database();

    return $ci->db->query("SELECT * FROM talep_form_teklifler_item_details  Where tfitem_id=$item_id and details_id=$details_id")->row();

}
function muqayese_details($item_id){
    $ci =& get_instance();
    $ci->load->database();

    $count = 0;
    $cari_id = [];
    $depo = [];
    if($item_id){
        $details =  $ci->db->query("SELECT * FROM `talep_form_teklifler`  Where form_id=$item_id")->result();
        foreach ($details as $items){
            $teklif_id = $items->id;
            $details =  $ci->db->query("SELECT * FROM `talep_form_teklif_cari_details`  Where teklif_id=$teklif_id and status=3");
            if($details->num_rows()){
                foreach ($details->result() as $values){
                    $cari_id[]=['id'=>$values->cari_id,'company'=>customer_details($values->cari_id)['company'],'teklif_id'=>$teklif_id];
                }

                $count+=$details->num_rows();

            }


        }
    }



    return [
        'count'=>$count,
        'cari'=>$cari_id
    ];

}
function teklif_cari_details($teklif_id){
    $ci =& get_instance();
    $ci->load->database();


    $details =  $ci->db->query("SELECT * FROM `talep_form_teklifler_details`  Where tf_teklif_id=$teklif_id");
    return $details->row();

}

function cari_details_items($id,$cari_id,$item_id){
    $ci =& get_instance();
    $ci->load->database();


    $teklif_details = $ci->db->query("SELECT * FROM `talep_form_teklifler` Where cari_id = $cari_id and form_id= $id")->row();

    $teklif_id = $teklif_details->id;

    $teklif_items_details = $ci->db->query("SELECT * FROM `talep_form_teklifler_details` where tf_teklif_id=$teklif_id");

    if($teklif_items_details->num_rows()){
        $details_id = $teklif_items_details->row()->id;
        $para_birimi = $teklif_items_details->row()->para_birimi;

        $item_Details =   $ci->db->query("SELECT * FROM `talep_form_teklifler_item_details` Where details_id=$details_id and tfitem_id=$item_id");
      if($item_Details->num_rows()){
         return [
             'details'=>$item_Details->row(),
             'para_birimi'=>$para_birimi
             ];

      }
      else {
          return false;
      }
  }
    else {
        return false;
    }


}
function ihale_onaylanan_urunler($talep_id){
    $ci =& get_instance();
    $ci->load->database();
    $onaylanan_urunler=[];


    if($talep_id){
        $talep_details =  $ci->db->query("SELECT * FROM `talep_form` Where id=$talep_id")->row();
        $projects =  $ci->db->query("SELECT * FROM `geopos_projects` Where id=$talep_details->proje_id")->row();
        $details =  $ci->db->query("SELECT * FROM `talep_form_products` Where form_id=$talep_id")->result();
        foreach ($details as $products){
            $tf_id=[];
            $talep_form_teklifler_item_details_id= $ci->db->query(" SELECT t.*
          FROM talep_form_teklifler_item_details t
          WHERE tfitem_id=$products->id")->result();
            foreach ($talep_form_teklifler_item_details_id as $items){
                $tf_id[]=$items->id;
            }
            if($tf_id){
                $tf_id_d=implode(',',$tf_id);
                $onay_list= $ci->db->query("SELECT * FROM `teklif_onay_list` Where talep_form_teklifler_item_details_id IN ($tf_id_d) and form_id=$talep_id and product_id=$products->product_id and user_id=$projects->genel_mudur_id");
                if($onay_list->num_rows()){
                    $onaylanan_urunler[]=[
                        'id'=>$onay_list->row()->id,
                        'product_id'=>$products->product_id,
                        'qty'=>$products->product_qty,
                        'unit_id'=>$products->unit_id,
                        'new_product_id'=>$products->new_product_id,
                        'product_type'=>$products->product_type,
                        'talep_form_product_id'=>$products->id,
                        'type'=>$onay_list->row()->type,
                        'warehouse_id'=>$onay_list->row()->warehouse_id,
                        'talep_form_teklifler_item_details_id'=>$onay_list->row()->talep_form_teklifler_item_details_id,
                    ];
                }
            }



        }
    }


    return $onaylanan_urunler;

}


function talep_form_teklifler_item_details($id){
    $ci =& get_instance();
    $ci->load->database();
    $onaylanan_urunler=[];
    $details =  $ci->db->query("SELECT * FROM `talep_form_teklifler_item_details` Where id=$id")->row();
    return $details;

}

function talep_form_teklifler_item($id){
    $ci =& get_instance();
    $ci->load->database();
    $onaylanan_urunler=[];
    $details =  $ci->db->query("SELECT * FROM `talep_form_teklifler_details` Where id=$id")->row();
    return $details;

}



function talep_form_teklifler($id){
    $ci =& get_instance();
    $ci->load->database();
    $onaylanan_urunler=[];
    $details =  $ci->db->query("SELECT * FROM `talep_form_teklifler` Where id=$id")->row();
    return $details;

}

function siparis_list_kontrol($id){
    $ci =& get_instance();
    $ci->load->database();
    if($id){
        $details =  $ci->db->query("SELECT * FROM `siparis_list_form` Where talep_id=$id and deleted_at is Null");
        if($details->num_rows()){
            return $details->result();
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }


}
function siparis_list_kontrol_onaylanan($id){
    $ci =& get_instance();
    $ci->load->database();
    $details =  $ci->db->query("SELECT * FROM `siparis_list_form` Where talep_id=$id and deleted_at is Null and file_status=2");
    if($details->num_rows()){
        return $details->result();
    }
    else {
        return false;
    }

}
function talep_form_product_details($product_id,$talep_id){
    $ci =& get_instance();
    $ci->load->database();
    $details =  $ci->db->query("SELECT t.*
          FROM talep_form_products t
          WHERE product_id=$product_id and form_id=$talep_id");
    if($details->num_rows()){
        return $details->row();
    }
    else {
        return false;
    }

}
function all_personel_point_value()
{

    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $olusturan = $ci->session->userdata('id');
    $query2 = $ci->db->query("SELECT personel_point_value.*,geopos_employees.`name` as personel_name FROM personel_point_value JOIN geopos_employees ON personel_point_value.auth_id=geopos_employees.id Where  personel_point_value.loc=$loc ");
    $row = $query2->result();
    return $row;

}

function cari_bakiye_genel($cari_id){
    $ci =& get_instance();
    $ci->load->database();

    $result = [];
    $forma2_durum='';
    $no=0;
    $bakiye=0;
    $borc_toplam=0;
    $alacak_toplam=0;
    $sql=$ci->db->query("SELECT `geopos_invoices`.`end_date_islem`, `geopos_invoices`.`proje_id`, `geopos_invoices`.`stok_guncelle`,
       `geopos_invoice_type`.`description`, `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`,
       `geopos_invoices`.`invoicedate`, `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`,
       `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`, `geopos_invoices`.`invoicedate`, 
       `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`, `geopos_invoice_type`.`type_value`,
       IF(geopos_invoices.method!='', `geopos_invoices`.`method`, 'null') as odeme_tipi, IF(geopos_invoice_type.id=19, 
           `geopos_invoices`.`total`, 0) as kdv_borc, IF(geopos_invoice_type.id=20, `geopos_invoices`.`total`, 0) as kdv_alacak, 
       IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc, IF(geopos_invoice_type.transactions='expense',
           `geopos_invoices`.`total`, NULL) as alacak, IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc_sub,
       IF(geopos_invoice_type.transactions='expense', `geopos_invoices`.`total`, NULL) as alacak_sub, 
       `geopos_invoices`.`total`, `geopos_invoices`.`subtotal`, `geopos_invoices`.`kur_degeri`, `geopos_invoices`.`para_birimi`, 
       `geopos_invoices`.`notes`, `geopos_invoice_type`.`transactions`, `geopos_invoices`.`csd`, `geopos_invoices`.`id` as `inv_id` 
FROM `geopos_invoices` LEFT JOIN `geopos_invoice_type` ON `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` 
WHERE `geopos_invoice_type`.`id` IN(1, 2, 3, 4, 7, 8, 17, 18, 19, 20, 21, 22, 23, 24, 38, 43, 44, 45, 46, 47, 48, 39, 40, 54, 55, 29, 30, 62, 24, 41, 61, 65, 69) AND 
      `geopos_invoices`.`cari_pers_type` != 7 AND `geopos_invoices`.`csd` = $cari_id 
ORDER BY DATE(geopos_invoices.end_date_islem) ASC ");
    if($sql->num_rows()){
        $result_=$sql->result_array();
        $data_array_new=[];

        $kontrol =  $ci->db->query("SELECT transaction_pay.* FROM transaction_pay Where cari_id = $cari_id");
        if($kontrol->num_rows()){
            $total=0;
            $array_details=[];
            foreach ($kontrol->result() as $items_new){



                $code='';
                $details  =  $ci->db->query("SELECT * FROM geopos_invoices Where id = $items_new->invoice_id")->row();
                $avans_detaisl = $ci->db->query("SELECT * FROM talep_form_customer Where id=$items_new->avans_id");
                if($avans_detaisl->num_rows()){
                    $code = $avans_detaisl->row()->code;
                }
                else {
                    if($details){
                        $code=$details->notes;
                    }

                }

                $total+=$items_new->amount;
                $data_array_new[]=
                    [
                        'invoicedate'=>$items_new->created_at,
                        'proje_id'=>$items_new->proje_id,
                        'odeme_tipi'=>$items_new->method,
                        'borc'=>$items_new->amount,
                        'total'=>$items_new->amount,
                        'stok_guncelle'=>0,
                        'invoice_no'=>$code.' Parçalı Ödeme',
                        'inv_id'=>$items_new->avans_id,
                        'alacak'=>0,
                        'csd'=>$items_new->cari_id,
                        'fatura_durumu_s'=>0,
                        'type_id'=>4,
                        'kur_degeri'=>0,
                        'para_birimi'=>1,
                        'type_value'=>'parcali',
                        'transactions'=>'expense',
                        'notes'=>'',
                        'description'=>'MƏXARİC',
                        'end_date_islem'=>$items_new->created_at,
                    ];

                $array_details[]=$items_new->avans_id;

            }


            $uniq = array_unique($array_details);
            if(count($uniq)){
                foreach ($uniq as $cvla)
                {


                    $form_total=0;
                    $form_total_details=$ci->db->query("SELECT SUM(total) as total,talep_form_customer.status FROM talep_form_customer_products
                    INNER JOIN talep_form_customer ON talep_form_customer_products.form_id=talep_form_customer.id Where talep_form_customer_products.form_id=$cvla")->row();
                    if($form_total_details->status==10){
                        $form_total=$ci->customeravans->form_total($cvla);
                    }
                    else {
                        $form_total = $ci->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    }


                    $total =  $ci->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    $kalan = floatval($form_total)-floatval($total);

                    $avans_detaisl = $ci->db->query("SELECT * FROM talep_form_customer Where id=$cvla")->row();


                    if($kalan > 0)
                    {
                        $data_array_new[]=
                            [
                                'invoicedate'=>$avans_detaisl->created_at,
                                'proje_id'=>$avans_detaisl->proje_id,
                                'odeme_tipi'=>$avans_detaisl->method,
                                'borc'=>$kalan,
                                'total'=>$kalan,
                                'stok_guncelle'=>0,
                                'invoice_no'=>$avans_detaisl->code.' Parçalı Ödeme (QALIQ)',
                                'inv_id'=>$cvla,
                                'alacak'=>0,
                                'csd'=>$cari_id,
                                'fatura_durumu_s'=>0,
                                'type_id'=>4,
                                'kur_degeri'=>0,
                                'para_birimi'=>1,
                                'type_value'=>'',
                                'transactions'=>'expense',
                                'notes'=>'',
                                'description'=>'MƏXARİC',
                                'end_date_islem'=>$avans_detaisl->created_at,
                            ];
                    }
                }
            }




        }



        $bakiye=0;
        $ekstes_ = array_merge($result_,$data_array_new);
        foreach ($ekstes_ as $invoices) {

            $inv_id_=$invoices['inv_id'];

            if($invoices['fatura_durumu_s']!=3)
            {
                if($invoices['type_id']!=55)
                {
                    if($invoices['type_id']==29 || $invoices['type_id']==30){
                        if($invoices['fatura_durumu_s']==18 || $invoices['fatura_durumu_s']==17 || $invoices['fatura_durumu_s']==2) {
//                            if($invoices['odeme_tipi']==1){
                            $carpim=1;

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


//                            if ($invoices['transactions'] == 'expense') {
//
//                                $alacak_toplam += $total*$carpim;
//                            } elseif ($invoices['transactions'] == 'income') {
//                                $borc_toplam += $total*$carpim;
//                            }
                            $alacak_toplam += $alacak;
                            $borc_toplam += $borc;
                            $bakiye += ($borc-$alacak);

//                            }
                        }
                        else {
                            continue;
                        }

                    }
                    elseif($invoices['type_id']==69)
                    {
                        $inv_id = $invoices['inv_id'];
                        $tehvil_kontrol = tehvil_durumu($inv_id);
                        if (!$tehvil_kontrol) {
                            {
                                $carpim=1;

                                $kur_degeri = para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim = $kur_degeri;


                                $no++;
                                $row = array();


                                if ($invoices['type_id'] == 1 || $invoices['type_id'] == 2) {
                                    $borc = $invoices['borc_sub'] * $carpim;
                                    $alacak = $invoices['alacak_sub'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else if ($invoices['type_id'] == 19 || $invoices['type_id'] == 20) {
                                    $borc = $invoices['kdv_borc'] * $carpim;
                                    $alacak = $invoices['kdv_alacak'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else {
                                    $borc = $invoices['borc'] * $carpim;
                                    $alacak = $invoices['alacak'] * $carpim;
                                    $total = $invoices['total'];
                                }

                                $style = '';
                                if ($invoices['stok_guncelle'] == 0) {
                                    $style = "background-color: red;color: white;";
                                }


//                                if ($invoices['transactions'] == 'expense') {
//
//                                    $alacak_toplam += $total * $carpim;
//                                } elseif ($invoices['transactions'] == 'income') {
//                                    $borc_toplam += $total * $carpim;
//                                }

                                $alacak_toplam += $alacak;
                                $borc_toplam += $borc;

                                $bakiye += ($borc-$alacak);
                            }
                        }

                    }
                    else
                    {
                        $inv_id = $invoices['inv_id'];
                        $forma_2_kontorl =forma_2_kontrol($inv_id);
                        if($forma2_durum==1 || $forma2_durum==''){
                            if($forma_2_kontorl){
                                $carpim=1;

                                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim=$kur_degeri;


                                $no++;
                                $row = array();


                                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                {
                                    $borc=$invoices['borc_sub']*$carpim;
                                    $alacak=$invoices['alacak_sub']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                {
                                    $borc=$invoices['kdv_borc']*$carpim;
                                    $alacak=$invoices['kdv_alacak']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else
                                {
                                    $borc=$invoices['borc']*$carpim;
                                    $alacak=$invoices['alacak']*$carpim;
                                    $total=$invoices['total'];
                                }

                                $style='';
                                if($invoices['stok_guncelle'] == 0 )
                                {
                                    $style="background-color: red;color: white;";
                                }

                                $kontrol =  $ci->db->query("SELECT transaction_pay.* FROM transaction_pay Where invoice_id = $inv_id_");
                                if(!$kontrol->num_rows()){
//                                    if ($invoices['transactions'] == 'expense') {
//                                        $alacak_toplam += $total*$carpim;
//                                    } elseif ($invoices['transactions'] == 'income') {
//                                        $borc_toplam += $total*$carpim;
//                                    }

                                    $alacak_toplam += $alacak;
                                    $borc_toplam += $borc;

                                    $bakiye += ($borc-$alacak);
                                }

                            }
                        }
                        elseif($forma2_durum==2) {
                            $carpim=1;

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


//                            if ($invoices['transactions'] == 'expense') {
//                                $alacak_toplam += $total*$carpim;
//                            } elseif ($invoices['transactions'] == 'income') {
//                                $borc_toplam += $total*$carpim;
//                            }
                            $alacak_toplam += $alacak;
                            $borc_toplam += $borc;
                            $bakiye += ($borc-$alacak);
                        }


                    }
                }


            }

        }

    }

    $tutar = amountFormat(abs($bakiye)).($bakiye>0?" (B)":" (A)");

    return [
        'tutar'=>$tutar,
        'borc_toplam'=>amountFormat($borc_toplam),
        'alacak_toplam'=>amountFormat($alacak_toplam),
    ];
}

function cari_proje_bakiye_kontrol($id,$file_id=0){
    $ci =& get_instance();
    $ci->load->database();
//    $id = $this->input->post('talep_id');
//    $file_id = $this->input->post('file_id');
    $details = $ci->db->query("SELECT * FROM talep_form_customer Where id=$id")->row();
    $avans_type=$details->avans_type;
    $cari_id=$details->cari_id;
    $avans_file_id=$details->file_id;
    $proje_id=$details->proje_id;
    $result = [];
    $forma2_durum='';
    $no=0;
    $bakiye=0;
    $borc_toplam=0;
    $alacak_toplam=0;
    $code='';



    $sql=$ci->db->query("SELECT `geopos_invoices`.`end_date_islem`, `geopos_invoices`.`proje_id`, `geopos_invoices`.`stok_guncelle`,
       `geopos_invoice_type`.`description`, `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`,
       `geopos_invoices`.`invoicedate`, `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`,
       `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`, `geopos_invoices`.`invoicedate`, 
       `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`, `geopos_invoice_type`.`type_value`,
       IF(geopos_invoices.method!='', `geopos_invoices`.`method`, 'null') as odeme_tipi, IF(geopos_invoice_type.id=19, 
           `geopos_invoices`.`total`, 0) as kdv_borc, IF(geopos_invoice_type.id=20, `geopos_invoices`.`total`, 0) as kdv_alacak, 
       IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc, IF(geopos_invoice_type.transactions='expense',
           `geopos_invoices`.`total`, NULL) as alacak, IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc_sub,
       IF(geopos_invoice_type.transactions='expense', `geopos_invoices`.`total`, NULL) as alacak_sub, 
       `geopos_invoices`.`total`, `geopos_invoices`.`subtotal`, `geopos_invoices`.`kur_degeri`, `geopos_invoices`.`para_birimi`, 
       `geopos_invoices`.`notes`, `geopos_invoice_type`.`transactions`, `geopos_invoices`.`csd`, `geopos_invoices`.`id` as `inv_id` 
FROM `geopos_invoices` LEFT JOIN `geopos_invoice_type` ON `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` 
WHERE `geopos_invoice_type`.`id` IN(1, 2, 3, 4, 7, 8, 17, 18, 19, 20, 21, 22, 23, 24, 38, 43, 44, 45, 46, 47, 48, 39, 40, 54, 55, 29, 30, 62, 24, 41, 61, 65, 69) AND 
      `geopos_invoices`.`cari_pers_type` != 7 AND `geopos_invoices`.`proje_id` = $proje_id AND `geopos_invoices`.`csd` = $cari_id 
ORDER BY DATE(geopos_invoices.end_date_islem) ASC ");

    if($sql->num_rows()){
        $result_=$sql->result_array();
        $data_array_new=[];

        $kontrol =  $ci->db->query("SELECT transaction_pay.* FROM transaction_pay Where cari_id = $cari_id and  proje_id =$proje_id");
        if($kontrol->num_rows()){
            $total=0;
            $array_details=[];
            foreach ($kontrol->result() as $items_new){



                $code='';
                $details  =  $ci->db->query("SELECT * FROM geopos_invoices Where id = $items_new->invoice_id")->row();
                $avans_detaisl = $ci->db->query("SELECT * FROM talep_form_customer Where id=$items_new->avans_id");
                if($avans_detaisl->num_rows()){
                    $code = $avans_detaisl->row()->code;
                }
                else {
                    $code=$details->notes;
                }




                $total+=$items_new->amount;
                $data_array_new[]=
                    [
                        'invoicedate'=>$items_new->created_at,
                        'proje_id'=>$items_new->proje_id,
                        'odeme_tipi'=>$items_new->method,
                        'borc'=>$items_new->amount,
                        'total'=>$items_new->amount,
                        'stok_guncelle'=>0,
                        'invoice_no'=>$code.' Parçalı Ödeme',
                        'inv_id'=>$items_new->avans_id,
                        'alacak'=>0,
                        'csd'=>$items_new->cari_id,
                        'fatura_durumu_s'=>0,
                        'type_id'=>4,
                        'kur_degeri'=>0,
                        'para_birimi'=>1,
                        'type_value'=>'parcali',
                        'transactions'=>'expense',
                        'notes'=>'',
                        'description'=>'MƏXARİC',
                        'end_date_islem'=>$items_new->created_at,
                    ];

                $array_details[]=$items_new->avans_id;

            }


            $uniq = array_unique($array_details);
            if(count($uniq)){
                foreach ($uniq as $cvla)
                {


                    $form_total=0;
                    $form_total_details=$ci->db->query("SELECT SUM(total) as total,talep_form_customer.status FROM talep_form_customer_products
                    INNER JOIN talep_form_customer ON talep_form_customer_products.form_id=talep_form_customer.id Where talep_form_customer_products.form_id=$cvla")->row();
                    if($form_total_details->status==10){
                        $form_total=$ci->customeravans->form_total($cvla);
                    }
                    else {
                        $form_total = $ci->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    }


                    $total =  $ci->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    $kalan = floatval($form_total)-floatval($total);

                    $avans_detaisl = $ci->db->query("SELECT * FROM talep_form_customer Where id=$cvla")->row();


                    if($kalan > 0)
                    {
                        $data_array_new[]=
                            [
                                'invoicedate'=>$avans_detaisl->created_at,
                                'proje_id'=>$avans_detaisl->proje_id,
                                'odeme_tipi'=>$avans_detaisl->method,
                                'borc'=>$kalan,
                                'total'=>$kalan,
                                'stok_guncelle'=>0,
                                'invoice_no'=>$avans_detaisl->code.' Parçalı Ödeme (QALIQ)',
                                'inv_id'=>$cvla,
                                'alacak'=>0,
                                'csd'=>$cari_id,
                                'fatura_durumu_s'=>0,
                                'type_id'=>4,
                                'kur_degeri'=>0,
                                'para_birimi'=>1,
                                'type_value'=>'',
                                'transactions'=>'expense',
                                'notes'=>'',
                                'description'=>'MƏXARİC',
                                'end_date_islem'=>$avans_detaisl->created_at,
                            ];
                    }
                }
            }




        }



        $bakiye=0;
        $ekstes_ = array_merge($result_,$data_array_new);
        foreach ($ekstes_ as $invoices) {

            $inv_id_=$invoices['inv_id'];

            if($invoices['fatura_durumu_s']!=3)
            {
                if($invoices['type_id']!=55)
                {
                    if($invoices['type_id']==29 || $invoices['type_id']==30){
                        if($invoices['fatura_durumu_s']==18 || $invoices['fatura_durumu_s']==17 || $invoices['fatura_durumu_s']==2) {
//                            if($invoices['odeme_tipi']==1){
                            $carpim=1;

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


                            $alacak_toplam += $alacak;
                            $borc_toplam += $borc;
                            $bakiye += ($borc-$alacak);

//                            }
                        }
                        else {
                            continue;
                        }

                    }
                    elseif($invoices['type_id']==69)
                    {
                        $inv_id = $invoices['inv_id'];
                        $tehvil_kontrol = tehvil_durumu($inv_id);
                        if (!$tehvil_kontrol) {
                            {
                                $carpim=1;

                                $kur_degeri = para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim = $kur_degeri;


                                $no++;
                                $row = array();


                                if ($invoices['type_id'] == 1 || $invoices['type_id'] == 2) {
                                    $borc = $invoices['borc_sub'] * $carpim;
                                    $alacak = $invoices['alacak_sub'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else if ($invoices['type_id'] == 19 || $invoices['type_id'] == 20) {
                                    $borc = $invoices['kdv_borc'] * $carpim;
                                    $alacak = $invoices['kdv_alacak'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else {
                                    $borc = $invoices['borc'] * $carpim;
                                    $alacak = $invoices['alacak'] * $carpim;
                                    $total = $invoices['total'];
                                }

                                $style = '';
                                if ($invoices['stok_guncelle'] == 0) {
                                    $style = "background-color: red;color: white;";
                                }

                                $alacak_toplam += $alacak;
                                $borc_toplam += $borc;

                                $bakiye += ($borc-$alacak);
                            }
                        }

                    }
                    else
                    {
                        $inv_id = $invoices['inv_id'];
                        $forma_2_kontorl =forma_2_kontrol($inv_id);
                        if($forma2_durum==1 || $forma2_durum==''){
                            if($forma_2_kontorl){
                                $carpim=1;

                                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim=$kur_degeri;


                                $no++;
                                $row = array();


                                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                {
                                    $borc=$invoices['borc_sub']*$carpim;
                                    $alacak=$invoices['alacak_sub']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                {
                                    $borc=$invoices['kdv_borc']*$carpim;
                                    $alacak=$invoices['kdv_alacak']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else
                                {
                                    $borc=$invoices['borc']*$carpim;
                                    $alacak=$invoices['alacak']*$carpim;
                                    $total=$invoices['total'];
                                }

                                $style='';
                                if($invoices['stok_guncelle'] == 0 )
                                {
                                    $style="background-color: red;color: white;";
                                }


                                $kontrol =  $ci->db->query("SELECT transaction_pay.* FROM transaction_pay Where invoice_id = $inv_id_");
                                if(!$kontrol->num_rows()){
                                    $alacak_toplam += $alacak;
                                    $borc_toplam += $borc;

                                    $bakiye += ($borc-$alacak);
                                }





                            }
                        }
                        elseif($forma2_durum==2) {
                            $carpim=1;

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


                            $alacak_toplam += $alacak;
                            $borc_toplam += $borc;
                            $bakiye += ($borc-$alacak);
                        }


                    }
                }


            }

        }

    }

    $tutar = amountFormat(abs($bakiye)).($bakiye>0?" (B)":" (A)");


    $table='';

    $avans_file_kontrol=0;
    $avans_kontrol_num=0;
    $avans_kontrol_num2=0;
    $avans_kontrol = $ci->db->query("SELECT * FROM talep_form_customer Where cari_id=$cari_id and proje_id = $proje_id and avans_type=$avans_type and file_id=$file_id and type = 2 and status NOT IN (10) and id!=$id");
    if($avans_kontrol->num_rows()){
        $avans_kontrol_num++;
        $table.='<table class="table-bordered table">
<thead>
<tr>
<td>Talep Kodu</td>
<td>Tarih</td>
<td>Talep Eden Personel</td>
<td>Tutar</td>
<td>File</td>
<td>Talep Durumu</td>
</tr>
</thead>
<tbody>
';

        foreach ($avans_kontrol->result() as $items) {


            $avans_type_new=$items->avans_type;





            $details = avans_file_details($avans_type_new,$items->file_id);


            $text=' <div style="color: crimson;margin: 14px 0px 0 14px;text-decoration: underline;font-weight: bolder;">Aynı File Ait Açık Avans Mevcuttur.Tekrar Avans Açamassınız. Lütfen Var Olan Avansın Tutarını Güncelleyiniz</div>';
            $avans_file_kontrol=1;


            $status=talep_form_status_details($items->status)->name;
            $pers_name = personel_detailsa($items->talep_eden_user_id)['name'];
            $form_total = $ci->db->query("SELECT SUM(total) as total FROM talep_form_customer_products Where form_id=$id")->row()->total;
            $button="<a href='/customeravanstalep/view/$items->id' class='btn btn-info btn-sm' target='_blank'>$items->code</a>";
            $table.='<tr>
                <td>'.$button.'</td>
                <td>'.$items->created_at.'</td>
                <td>'.$pers_name.'</td>
                <td>'.amountFormat($form_total).'</td>
                <td>'.$details.$text.'</td>
                <td>'.$status.'</td>
                </tr>';
        }
        $table.="
</tbody>
</table>";
    }



    $table2='';

    $avans_kontrol2 = $ci->db->query("SELECT * FROM talep_form_customer Where cari_id=$cari_id and proje_id = $proje_id and type = 2 and status NOT IN (10) and id!=$id");
    if($avans_kontrol2->num_rows()){
        $avans_kontrol_num2++;
        $table2.='<table class="table-bordered table">
<thead>
<tr>
<td>Talep Kodu</td>
<td>Tarih</td>
<td>Talep Eden Personel</td>
<td>Tutar</td>
</tr>
</thead>
<tbody>
';

        $total_avans=0;
        foreach ($avans_kontrol2->result() as $items) {
            $avans_type_new=$items->avans_type;


            $details = avans_file_details($avans_type_new,$items->file_id);


            $text=' <div style="color: crimson;margin: 14px 0px 0 14px;text-decoration: underline;font-weight: bolder;">Aynı File Ait Açık Avans Mevcuttur.Tekrar Avans Açamassınız. Lütfen Var Olan Avansın Tutarını Güncelleyiniz</div>';
            $avans_file_kontrol=1;


            $status=talep_form_status_details($items->status)->name;
            $pers_name = personel_detailsa($items->talep_eden_user_id)['name'];
            $form_total = $ci->db->query("SELECT SUM(total) as total FROM talep_form_customer_products Where form_id=$items->id")->row()->total;
            $table2.='<tr>
                <td>'.$items->code.'</td>
                <td>'.dateformat($items->created_at).'</td>
                <td>'.$pers_name.'</td>
                <td>'.amountFormat($form_total).'</td>
                </tr>';
            $total_avans+=$form_total;
        }

        $table2.="<tr>
<td colspan='3' style='text-align: right;'><b>Genel Toplam</b> </td>
<td><b>".amountFormat($total_avans)."</b></td>
</tr>";
        $table2.="
</tbody>
</table>";
    }

    $proje_bakiyesi=[];

    if(all_projects()){
        foreach (all_projects() as $proje_item){
            if(cari_bakiye_proje_genel($cari_id,$proje_item->id)){
                if($proje_id!=$proje_item->id){
                    $proje_bakiyesi[]=[
                        'proje_name'=>proje_name($proje_item->id),
                        'proje_id'=>$proje_item->id,
                        'proje_code'=>proje_code($proje_item->id),
                        'bakiye'=>cari_bakiye_proje_genel($cari_id,$proje_item->id)['tutar'],
                        'alacak_toplam'=>cari_bakiye_proje_genel($cari_id,$proje_item->id)['alacak_toplam'],
                        'borc_toplam'=>cari_bakiye_proje_genel($cari_id,$proje_item->id)['borc_toplam'],
                    ];
                }

            }

        }
    }


    return [
        'status'=>200,
        'proje_bakiye'=>$tutar,
        'proje_bakiye_alacak'=>amountFormat($alacak_toplam),
        'proje_bakiye_borc'=>amountFormat($borc_toplam),
        'genel_bakiye'=>cari_bakiye_genel($cari_id)['tutar'],
        'p_genel_bakiye_alacak'=>cari_bakiye_genel($cari_id)['alacak_toplam'],
        'p_genel_bakiye_borc'=>cari_bakiye_genel($cari_id)['borc_toplam'],
        'projeler_bakiyesi'=>$proje_bakiyesi,
        'avans_kontrol_num'=>$avans_kontrol_num,
        'acikta_bululanan_avans'=>$table,
        'proje_tum_avanslar'=>$table2,
        'avans_file_kontrol'=>$avans_file_kontrol,
    ];

}


function cari_bakiye_proje_genel($cari_id,$proje_id){
    $ci =& get_instance();
    $ci->load->database();

    $result = [];
    $forma2_durum='';
    $no=0;
    $bakiye=0;
    $borc_toplam=0;
    $alacak_toplam=0;
    $sql=$ci->db->query("SELECT `geopos_invoices`.`end_date_islem`, `geopos_invoices`.`proje_id`, `geopos_invoices`.`stok_guncelle`,
       `geopos_invoice_type`.`description`, `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`,
       `geopos_invoices`.`invoicedate`, `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`,
       `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`, `geopos_invoices`.`invoicedate`, 
       `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`, `geopos_invoice_type`.`type_value`,
       IF(geopos_invoices.method!='', `geopos_invoices`.`method`, 'null') as odeme_tipi, IF(geopos_invoice_type.id=19, 
           `geopos_invoices`.`total`, 0) as kdv_borc, IF(geopos_invoice_type.id=20, `geopos_invoices`.`total`, 0) as kdv_alacak, 
       IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc, IF(geopos_invoice_type.transactions='expense',
           `geopos_invoices`.`total`, NULL) as alacak, IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc_sub,
       IF(geopos_invoice_type.transactions='expense', `geopos_invoices`.`total`, NULL) as alacak_sub, 
       `geopos_invoices`.`total`, `geopos_invoices`.`subtotal`, `geopos_invoices`.`kur_degeri`, `geopos_invoices`.`para_birimi`, 
       `geopos_invoices`.`notes`, `geopos_invoice_type`.`transactions`, `geopos_invoices`.`csd`, `geopos_invoices`.`id` as `inv_id` 
FROM `geopos_invoices` LEFT JOIN `geopos_invoice_type` ON `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` 
WHERE `geopos_invoice_type`.`id` IN(1, 2, 3, 4, 7, 8, 17, 18, 19, 20, 21, 22, 23, 24, 38, 43, 44, 45, 46, 47, 48, 39, 40, 54, 55, 29, 30, 62, 24, 41, 61, 65, 69) AND 
      `geopos_invoices`.`cari_pers_type` != 7 AND `geopos_invoices`.`csd` = $cari_id and `geopos_invoices`.`proje_id` = $proje_id 
ORDER BY DATE(geopos_invoices.end_date_islem) ASC ");
    if($sql->num_rows()){
        $result_=$sql->result_array();
        $data_array_new=[];

        $kontrol =  $ci->db->query("SELECT transaction_pay.* FROM transaction_pay Where cari_id = $cari_id and proje_id=$proje_id");
        if($kontrol->num_rows()){
            $total=0;
            $array_details=[];
            foreach ($kontrol->result() as $items_new){




                $code='';
                $details  =  $ci->db->query("SELECT * FROM geopos_invoices Where id = $items_new->invoice_id")->row();
                $avans_detaisl = $ci->db->query("SELECT * FROM talep_form_customer Where id=$items_new->avans_id");
                if($avans_detaisl->num_rows()){
                    $code = $avans_detaisl->row()->code;
                }
                else {
                    if($details){
                        $code=$details->notes;
                    }

                }




                $total+=$items_new->amount;
                $data_array_new[]=
                    [
                        'invoicedate'=>$items_new->created_at,
                        'proje_id'=>$items_new->proje_id,
                        'odeme_tipi'=>$items_new->method,
                        'borc'=>$items_new->amount,
                        'total'=>$items_new->amount,
                        'stok_guncelle'=>0,
                        'invoice_no'=>$code.' Parçalı Ödeme',
                        'inv_id'=>$items_new->avans_id,
                        'alacak'=>0,
                        'csd'=>$items_new->cari_id,
                        'fatura_durumu_s'=>0,
                        'type_id'=>4,
                        'kur_degeri'=>0,
                        'para_birimi'=>1,
                        'type_value'=>'parcali',
                        'transactions'=>'expense',
                        'notes'=>'',
                        'description'=>'MƏXARİC',
                        'end_date_islem'=>$items_new->created_at,
                    ];

                $array_details[]=$items_new->avans_id;

            }


            $uniq = array_unique($array_details);
            if(count($uniq)){
                foreach ($uniq as $cvla)
                {


                    $form_total=0;
                    $form_total_details=$ci->db->query("SELECT SUM(total) as total,talep_form_customer.status FROM talep_form_customer_products
                    INNER JOIN talep_form_customer ON talep_form_customer_products.form_id=talep_form_customer.id Where talep_form_customer_products.form_id=$cvla")->row();
                    if($form_total_details->status==10){
                        $form_total=$ci->customeravans->form_total($cvla);
                    }
                    else {
                        $form_total = $ci->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    }


                    $total =  $ci->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    $kalan = floatval($form_total)-floatval($total);

                    $avans_detaisl = $ci->db->query("SELECT * FROM talep_form_customer Where id=$cvla")->row();


                    if($kalan > 0)
                    {
                        $data_array_new[]=
                            [
                                'invoicedate'=>$avans_detaisl->created_at,
                                'proje_id'=>$avans_detaisl->proje_id,
                                'odeme_tipi'=>$avans_detaisl->method,
                                'borc'=>$kalan,
                                'total'=>$kalan,
                                'stok_guncelle'=>0,
                                'invoice_no'=>$avans_detaisl->code.' Parçalı Ödeme (QALIQ)',
                                'inv_id'=>$cvla,
                                'alacak'=>0,
                                'csd'=>$cari_id,
                                'fatura_durumu_s'=>0,
                                'type_id'=>4,
                                'kur_degeri'=>0,
                                'para_birimi'=>1,
                                'type_value'=>'',
                                'transactions'=>'expense',
                                'notes'=>'',
                                'description'=>'MƏXARİC',
                                'end_date_islem'=>$avans_detaisl->created_at,
                            ];
                    }
                }
            }




        }



        $bakiye=0;
        $ekstes_ = array_merge($result_,$data_array_new);
        foreach ($ekstes_ as $invoices) {

            $inv_id_=$invoices['inv_id'];

            if($invoices['fatura_durumu_s']!=3)
            {
                if($invoices['type_id']!=55)
                {
                    if($invoices['type_id']==29 || $invoices['type_id']==30){
                        if($invoices['fatura_durumu_s']==18 || $invoices['fatura_durumu_s']==17 || $invoices['fatura_durumu_s']==2) {
//                            if($invoices['odeme_tipi']==1){
                            $carpim=1;

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


//                            if ($invoices['transactions'] == 'expense') {
//
//                                $alacak_toplam += $total*$carpim;
//                            } elseif ($invoices['transactions'] == 'income') {
//                                $borc_toplam += $total*$carpim;
//                            }
                            $alacak_toplam += $alacak;
                            $borc_toplam += $borc;
                            $bakiye += ($borc-$alacak);

//                            }
                        }
                        else {
                            continue;
                        }

                    }
                    elseif($invoices['type_id']==69)
                    {
                        $inv_id = $invoices['inv_id'];
                        $tehvil_kontrol = tehvil_durumu($inv_id);
                        if (!$tehvil_kontrol) {
                            {
                                $carpim=1;

                                $kur_degeri = para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim = $kur_degeri;


                                $no++;
                                $row = array();


                                if ($invoices['type_id'] == 1 || $invoices['type_id'] == 2) {
                                    $borc = $invoices['borc_sub'] * $carpim;
                                    $alacak = $invoices['alacak_sub'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else if ($invoices['type_id'] == 19 || $invoices['type_id'] == 20) {
                                    $borc = $invoices['kdv_borc'] * $carpim;
                                    $alacak = $invoices['kdv_alacak'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else {
                                    $borc = $invoices['borc'] * $carpim;
                                    $alacak = $invoices['alacak'] * $carpim;
                                    $total = $invoices['total'];
                                }

                                $style = '';
                                if ($invoices['stok_guncelle'] == 0) {
                                    $style = "background-color: red;color: white;";
                                }


//                                if ($invoices['transactions'] == 'expense') {
//
//                                    $alacak_toplam += $total * $carpim;
//                                } elseif ($invoices['transactions'] == 'income') {
//                                    $borc_toplam += $total * $carpim;
//                                }

                                $alacak_toplam += $alacak;
                                $borc_toplam += $borc;
                                $bakiye += ($borc-$alacak);
                            }
                        }

                    }
                    else
                    {
                        $inv_id = $invoices['inv_id'];
                        $forma_2_kontorl =forma_2_kontrol($inv_id);
                        if($forma2_durum==1 || $forma2_durum==''){
                            if($forma_2_kontorl){
                                $carpim=1;

                                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim=$kur_degeri;


                                $no++;
                                $row = array();


                                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                {
                                    $borc=$invoices['borc_sub']*$carpim;
                                    $alacak=$invoices['alacak_sub']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                {
                                    $borc=$invoices['kdv_borc']*$carpim;
                                    $alacak=$invoices['kdv_alacak']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else
                                {
                                    $borc=$invoices['borc']*$carpim;
                                    $alacak=$invoices['alacak']*$carpim;
                                    $total=$invoices['total'];
                                }

                                $style='';
                                if($invoices['stok_guncelle'] == 0 )
                                {
                                    $style="background-color: red;color: white;";
                                }

                                $kontrol =  $ci->db->query("SELECT transaction_pay.* FROM transaction_pay Where invoice_id = $inv_id_");
                                if(!$kontrol->num_rows()){
//                                    if ($invoices['transactions'] == 'expense') {
//                                        $alacak_toplam += $total*$carpim;
//                                    } elseif ($invoices['transactions'] == 'income') {
//                                        $borc_toplam += $total*$carpim;
//                                    }
                                    $alacak_toplam += $alacak;
                                    $borc_toplam += $borc;

                                    $bakiye += ($borc-$alacak);
                                }

                            }
                        }
                        elseif($forma2_durum==2) {
                            $carpim=1;

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


//                            if ($invoices['transactions'] == 'expense') {
//
//                                $alacak_toplam += $total*$carpim;
//                            } elseif ($invoices['transactions'] == 'income') {
//                                $borc_toplam += $total*$carpim;
//                            }
                            $alacak_toplam += $alacak;
                            $borc_toplam += $borc;
                            $bakiye += ($borc-$alacak);
                        }


                    }
                }


            }

        }

    }

    $tutar = amountFormat(abs($bakiye)).($bakiye>0?" (B)":" (A)");
    if($alacak_toplam > 0 || $borc_toplam > 0){
        return [
            'tutar'=>$tutar,
            'alacak_toplam'=>amountFormat($alacak_toplam),
            'borc_toplam'=>amountFormat($borc_toplam),
        ];
    }

    else {
        return false;
    }

}













