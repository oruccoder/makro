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


function category_list($cat_id = 0)

{

    $ci = &get_instance();
    $ci->load->database();

    $loc = $ci->session->userdata('set_firma_id');
    if ($cat_id != 0) {

        $query = $ci->db->query("SELECT `id`,`parent_id`,`cat_type`,`extra`, if( (SELECT GROUP_CONCAT(cat2.title,'-->',cat1.title) From 
        geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) is null ,cat2.title, (SELECT GROUP_CONCAT(cat1.title,'-->',cat2.title) From 
        geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) ) as title FROM `geopos_product_cat` cat2 where cat2.id!=$cat_id and cat2.loc=$loc
        ORDER BY cat2.id DESC");
    } else {
        $query = $ci->db->query("SELECT `id`,`parent_id`,`cat_type`,`extra`, if( (SELECT GROUP_CONCAT(cat2.title,'-->',cat1.title) From geopos_product_cat cat1 WHERE 
        cat1.id=cat2.parent_id ) is null ,cat2.title, (SELECT GROUP_CONCAT(cat1.title,'-->',cat2.title) From geopos_product_cat cat1 WHERE cat1.id=cat2.parent_id ) ) as title FROM 
        `geopos_product_cat` cat2 where cat2.loc=$loc
        ORDER BY cat2.id DESC");
    }

    return $query->result_array();
}



function category_list_($cat_id = 0)

{

    $ci = &get_instance();
    $ci->load->database();

    $loc = $ci->session->userdata('set_firma_id');

    $query = $ci->db->query("SELECT * FROM geopos_product_cat where geopos_product_cat.loc=$loc
        ORDER BY geopos_product_cat.id DESC");
    return $query->result_array();
}


function get_all_product_option_value()
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->select("*");
    $query2 = $query2->where('deleted_at', NULL, FALSE);
    $query2 = $query2->get('product_option_value');
    
    $row = $query2->result();
    return $row;
}
function get_product_option_value($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->select("*");
    $query2 = $query2->where('deleted_at', NULL, FALSE);
    $query2 = $query2->where('product_option_id', $id);
    $query2 = $query2->get('product_option_value');

    $row = $query2->result();
    return $row;
}


function get_all_product_option()
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->select("*");
    $query2 = $query2->where('deleted_at', NULL, FALSE);
    $query2 = $query2->get('product_options');
    
    $row = $query2->result();
    return $row;
}



function get_all_product()
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->select("*");
    $query2 = $query2->where('deleted_at', NULL, FALSE);
    $query2 = $query2->get('products');
    
    $row = $query2->result();
    return $row;
}



function all_categories()
{
    $ci = &get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM geopos_product_cat where loc = $loc ORDER BY id DESC");
    $row = $query2->result();
    return $row;
}


function all_product_type()
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM geopos_product_type");
    $row = $query2->result();
    return $row;
}



function onaylanan_firma_list($talep_id)
{
    $ci = &get_instance();
    $ci->load->database();

    if($talep_id){
        $query2 = $ci->db->query("SELECT * FROM `siparis_list_form` WHERE  deleted_at is null and staf_status=2 and talep_id=$talep_id GROUP BY cari_id");

        if ($query2->num_rows()) {
            return $query2->result();
        } else {
            return false;
        }
    }
    else {
        return false;
    }

}
function file_type_details($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `customer_file_type` WHERE  id=$id");

    if ($query2->num_rows()) {
        return $query2->row();
    } else {
        return false;
    }
}
function customer_file_type()
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `customer_file_type`");

    if ($query2->num_rows()) {
        return $query2->result();
    } else {
        return false;
    }
}
function customer_files($cari_id, $type)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `geopos_documents` Where fid=$cari_id and file_type_id=$type");

    if ($query2->num_rows()) {
        return $query2->result();
    } else {
        return false;
    }
}
function senedler($cari_id, $talep_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `talep_senet` Where cari_id=$cari_id and talep_id=$talep_id");

    if ($query2->num_rows()) {
        return $query2->row();
    } else {
        return false;
    }
}
function talep_to_warehouse($id)
{
    $ci = &get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_form` Where id=$id")->row();
        if ($query2->warehouse_id) {
            $user_id = $ci->aauth->get_user()->id;
            return $ci->db->query("SELECT * FROM geopos_warehouse Where id = $query2->warehouse_id and pers_id=$user_id ")->row();
        } else {
            return false;
        }
    }
    else {
        return false;
    }


}
function tehvil_products($id)
{
    $ci = &get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_form` Where id=$id")->row();
        $warehouse_id = $query2->warehouse_id;

        if($warehouse_id){
            $query2_ = $ci->db->query("SELECT warehouse_teslimat.*,talep_form_products.product_stock_code_id FROM `warehouse_teslimat`LEFT JOIN talep_form_products ON warehouse_teslimat.talep_form_product_id=talep_form_products.id Where warehouse_teslimat.form_id=$id and warehouse_teslimat.teslim_edilecek_warehouse_id=$warehouse_id");
            if ($query2_->num_rows()) {
                return $query2_->result();
            } else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }


}

function tehvil_products_cari($id, $cari_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $query2_ = $ci->db->query("SELECT * FROM `siparis_list_form` WHERE `talep_id` = $id AND `cari_id` = $cari_id and deleted_at is null GROUP BY talep_form_product_id");
    if ($query2_->num_rows()) {
        return $query2_->result();
    } else {
        return false;
    }
}
function tehvil_products_cari_product($id, $cari_id, $product_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $query2_ = $ci->db->query("SELECT * FROM `siparis_list_form` WHERE `talep_id` = $id AND `cari_id` = $cari_id and product_id=$product_id and deleted_at is null;");
    if ($query2_->num_rows()) {
        return $query2_->row();
    } else {
        return false;
    }
}
function tehvil_products_cari_new($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $query2_ = $ci->db->query("SELECT * FROM `siparis_list_form_new` WHERE `siparis_liste_form_id` = $id");
    if ($query2_->num_rows()) {
        return $query2_->row();
    } else {
        return false;
    }
}
function talep_warehouse_details($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `talep_form` Where id=$id")->row();
    $warehouse_id = $query2->warehouse_id;

    $query2_ = $ci->db->query("SELECT * FROM `geopos_warehouse` Where id=$warehouse_id");
    if ($query2_->num_rows()) {
        return $query2_->row();
    } else {
        return false;
    }
}
function invoice_talep_details($id)
{
    $ci = &get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_to_invoice` Where talep_id=$id");
        if ($query2->num_rows()) {
            return $query2->result();
        } else {
            return false;
        }
    }
    else {
        return false;
    }

}
function warehouse_teslimat_transfer($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `warehouse_teslimat_transfer` Where form_id=$id");
    if ($query2->num_rows()) {
        return $query2->result();
    } else {
        return false;
    }
}
function stock_fis_details($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2 = $ci->db->query("SELECT * FROM `stock_transfer` Where id=$id");
    if ($query2->num_rows()) {
        return $query2->row();
    } else {
        return false;
    }
}
function talep_qaime($id,$tip=1)
{
    $ci = &get_instance();
    $ci->load->database();
    $html = '';

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_to_invoice` Where talep_id=$id and  tip=$tip GROUP BY invoice_id");
        if ($query2->num_rows()) {
            foreach ($query2->result() as $items) {
                $invoice_details =  $ci->db->query("SELECT * FROM geopos_invoices Where id=$items->invoice_id and status!=3");
                if($invoice_details->num_rows()){
                    $html .= '<a target="_blank" href="/invoices/view?id=' . $items->invoice_id . '"><span class="badge badge-info">' . $invoice_details->row()->invoice_no . '</span></a>&nbsp;';

                }
             }
            return $html;
        } else {
            return false;
        }
    }
    else {
        return false;
    }

}
function qaime_to_talep($id,$tip=1)
{
    $ci = &get_instance();
    $ci->load->database();
    $html = '';

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_to_invoice` Where invoice_id=$id and  tip=$tip GROUP BY talep_id");
        if ($query2->num_rows()) {
            foreach ($query2->result() as $items) {
                $invoice_details =  $ci->db->query("SELECT * FROM talep_form Where id=$items->talep_id and status!=10");
                if($invoice_details->num_rows()){
                    $html .= '<a target="_blank" href="/malzemetalep/view/' . $items->talep_id . '"><span class="badge badge-info">' . $invoice_details->row()->code . '</span></a>&nbsp;';

                }
             }
            return $html;
        } else {
            return false;
        }
    }
    else {
        return false;
    }

}

function talep_odemeler($id,$tip=1){
    $ci =& get_instance();
    $ci->load->database();
    $html='';

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_form_transaction` Where form_id=$id and talep_tip=$tip");
        if($query2->num_rows()){
            foreach ($query2->result() as $items){
               $invoice_details_ =  $ci->db->query("SELECT * FROM geopos_invoices Where id=$items->islem_id");
               if($invoice_details_->num_rows()){
                   $invoice_details=$invoice_details_->row();
                   $html.='<a target="_blank" href="/transactions/view?id='.$items->islem_id.'"><span class="badge badge-info">'.$invoice_details->invoice_no.' # '.$invoice_details->id.'</span></a>&nbsp;';

               }
            }
            return $html;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }

}
function talep_odemeler_new($id,$tip){
    $ci =& get_instance();
    $ci->load->database();
    $html='';

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_form_customer_new_payment` Where form_id=$id and tip=$tip");
        if($query2->num_rows()){
            foreach ($query2->result() as $items){
               $invoice_details_ =  $ci->db->query("SELECT * FROM geopos_invoices Where id=$items->transaction_id");
               if($invoice_details_->num_rows()){
                   $invoice_details=$invoice_details_->row();
                   $toggle='';
                   if($items->cach_personel){
                       $personel_name=personel_details_full($items->cach_personel)['name'];
                        $toggle='data-popup="popover" data-trigger="hover" data-content="'.$personel_name.'" data-original-title="Pul Verilen Personel"';
                   }
                   $html.='<a '.$toggle.' target="_blank" href="/transactions/view?id='.$items->transaction_id.'"><span class="badge badge-info">'.$invoice_details->invoice_no.' # '.$invoice_details->id.'</span></a>&nbsp;';

               }
            }
            return $html;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }

}

function talep_odemeler_nakliye($id,$tip){
    $ci =& get_instance();
    $ci->load->database();
    $html='';

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `talep_form_nakliye_payment` Where form_id=$id");
        if($query2->num_rows()){
            foreach ($query2->result() as $items){
                $invoice_details_ =  $ci->db->query("SELECT * FROM geopos_invoices Where id=$items->transaction_id");
                if($invoice_details_->num_rows()){
                    $invoice_details=$invoice_details_->row();
                    $toggle='';
                    if($items->cach_personel){
                        $personel_name=personel_details_full($items->cach_personel)['name'];
                        $toggle='data-popup="popover" data-trigger="hover" data-content="'.$personel_name.'" data-original-title="Pul Verilen Personel"';
                    }
                    $html.='<a '.$toggle.' target="_blank" href="/transactions/view?id='.$items->transaction_id.'"><span class="badge badge-info">'.$invoice_details->invoice_no.' # '.$invoice_details->id.'</span></a>&nbsp;';

                }
            }
            return $html;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }

}

function new_siparis_items($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $query2_ = $ci->db->query("SELECT * FROM `siparis_list_form_new` Where siparis_liste_form_id=$id and status=1");
    if ($query2_->num_rows()) {
        return $query2_->row();
    } else {
        return false;
    }
}
function hizmet_teslim_alinmis($talep_id,$product_id,$talep_form_product_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $kalan_miktar = 0;
    $alinan_miktar = 0;

    $array=[];


    $html='Forma2 Oluşturulmamış';
    $items_kontrol = $ci->db->query("SELECT * FROM forma2_ht_items Where item_id = $talep_form_product_id");
    if($items_kontrol->num_rows()){
        $html='<div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Forma2 Listesi
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                foreach ($items_kontrol->result() as $items){
                    $hizmet_id = $items->ht_id;
                    $form_2_id = $ci->db->query("SELECT * FROM forma_2_to_ht Where id = $hizmet_id")->row()->forma_2_id;
                    $forma_2_item_kontrol = $ci->db->query("SELECT * FROM geopos_invoice_items Where tid=$form_2_id and pid=$product_id");
                    if($forma_2_item_kontrol->num_rows()){

                        $forma_2_detils_ = $ci->db->query("SELECT * FROM geopos_invoices Where id = $form_2_id and status!=3");
                        if($forma_2_detils_->num_rows()){
                            $forma_2_detils=$forma_2_detils_->row();
                            $alinan_miktar+=$forma_2_item_kontrol->row()->qty;
                            $forma_2_detils = $ci->db->query("SELECT * FROM geopos_invoices Where id = $form_2_id")->row();
                            $bildirim='Bildirim Başlatılmamış';
                            $style='style="background: red;color: white;"';
                            if($forma_2_detils->bildirim_durumu){
                                $bildirim="Bildirim Başlatılmış";
                                $style='style="background: orange;color: white;"';

                            }
                            $forma2_status =invoice_status($forma_2_detils->status);
                            $inv_=$forma_2_detils->invoice_no.' | '.$bildirim.' | '.$forma2_status;
                            $html.= '<a  target="_blank" '.$style.' href="/formainvoices/view?id='.$form_2_id.'" class="dropdown-item">'.$inv_.'</a>';
                        }
                    }
                }
        $html.='</div></div>';
    }

    return array('alinan_miktar'=>$alinan_miktar,'forma2_bilgisi'=>$html);
}

function tehvil_kalan_miktar($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $kalan_miktar = 0;
    $alinan_miktar = 0;
    $total_qty = $ci->db->query("SELECT * FROM `warehouse_teslimat` Where id=$id")->row()->qty;
    $query2_ = $ci->db->query("SELECT * FROM `teslimat_warehouse_item` Where teslimat_warehouse_id=$id");
    if ($query2_->num_rows()) {
        foreach ($query2_->result() as $items) {
            $alinan_miktar += $items->warehouse_item_qty;
        }
        $kalan_miktar = floatval($total_qty) - floatval($alinan_miktar);
    } else {
        $kontrol = $ci->db->query("SELECT * FROM `warehouse_teslimat` Where id=$id")->row();
        $item_id = $kontrol->talep_form_product_id;
        $form_id = $kontrol->form_id;
        $product_id = $kontrol->product_id;
        $teslim_edilecek_warehouse_id = $kontrol->teslim_edilecek_warehouse_id;
        $product_stock_code = talep_form_product_options_teklif_values($item_id);
        $stock_details = stock_qty_new_mt($product_id,$product_stock_code,$form_id,$teslim_edilecek_warehouse_id);
       
        $kalan_miktar = floatval( $total_qty) - floatval($stock_details['qty']);

    }

    return $kalan_miktar;
}
function teslim_alinmis_miktar($id)
{
    $ci = &get_instance();
    $ci->load->database();

    $alinan_miktar = 0;
    $query2_ = $ci->db->query("SELECT * FROM `teslimat_warehouse_item` Where teslimat_warehouse_id=$id");
    if ($query2_->num_rows()) {
        foreach ($query2_->result() as $items) {
            $alinan_miktar += $items->warehouse_item_qty;
        }
    }
    else {
        $kontrol = $ci->db->query("SELECT * FROM `warehouse_teslimat` Where id=$id")->row();
        $item_id = $kontrol->talep_form_product_id; //21123
        $form_id = $kontrol->form_id; //3608
        $product_id = $kontrol->product_id; //17095
        $teslim_edilecek_warehouse_id = $kontrol->teslim_edilecek_warehouse_id; //165
        $product_stock_code = talep_form_product_options_teklif_values($item_id); //21123
        $stock_details = stock_qty_new_mt($product_id,$product_stock_code,$form_id,$teslim_edilecek_warehouse_id);
        $alinan_miktar = floatval($stock_details['qty']);
    }

    return $alinan_miktar;
}

function hizmet_qaime_qty($form_id,$talep_form_product_id,$product_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $qaime_miktar=0;
    $item_id = $ci->db->query("SELECT * FROM siparis_list_form Where talep_form_product_id=$talep_form_product_id order by id desc LIMIT 1")->row()->id;
    if($item_id){
        $invoice_details = $ci->db->query("SELECT * FROM talep_to_invoice Where talep_id=$form_id and item_id=$item_id");
        foreach ($invoice_details->result() as $values){
            $items_details = $ci->db->query("
SELECT SUM(qty) as totals FROM geopos_invoice_items
    INNER JOIN geopos_invoices ON geopos_invoice_items.tid = geopos_invoices.id 
              Where geopos_invoices.status!=3 and 
      geopos_invoice_items.tid=$values->invoice_id and geopos_invoice_items.pid=$product_id");
            if($items_details->num_rows()){
                $qaime_miktar+=$items_details->row()->totals;
            }
        }
    }

    return ['qaime_qty'=>$qaime_miktar];

}
function tehvil_cari_form_product($cari_id, $form_id, $product_id,$talep_form_product_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $kalan=0;
    $qaime_miktar=0;

    $alinan_miktar = 0;
    if($talep_form_product_id){
        $stock_code_id = talep_form_product_options_teklif_values($talep_form_product_id);
        $query2_ = $ci->db->query("SELECT * FROM `warehouse_teslimat` Where form_id=$form_id and cari_id=$cari_id and product_id=$product_id and talep_form_product_id = $talep_form_product_id");
        if ($query2_->num_rows()) {
            $id = $query2_->row()->id;
            $query_ = $ci->db->query("SELECT * FROM `teslimat_warehouse_item` Where teslimat_warehouse_id=$id");
            if ($query_->num_rows()) {
                foreach ($query_->result() as $items) {
                    $alinan_miktar += $items->warehouse_item_qty;
                }
                $item_id = $ci->db->query("SELECT * FROM siparis_list_form Where talep_form_product_id=$talep_form_product_id order by id desc LIMIT 1")->row()->id;

                if($item_id){
                    $invoice_details = $ci->db->query("SELECT * FROM talep_to_invoice Where talep_id=$form_id and item_id=$item_id");
                    if($invoice_details->num_rows()){
                        foreach ($invoice_details->result() as $values){
                            $items_details = $ci->db->query("
SELECT SUM(qty) as totals FROM geopos_invoice_items
    INNER JOIN geopos_invoices ON geopos_invoice_items.tid = geopos_invoices.id 
    INNER JOIN invoices_item_to_option ON geopos_invoice_items.id = invoices_item_to_option.invoices_item_id 
              Where geopos_invoices.status!=3 and 
      geopos_invoice_items.tid=$values->invoice_id and geopos_invoice_items.pid=$product_id and invoices_item_to_option.product_stock_code_id = $stock_code_id");
                            if($items_details->num_rows()){
                                $qaime_miktar+=$items_details->row()->totals;
                            }
                        }
                    }
                }

            }
            else {
                $kontrol = $ci->db->query("SELECT * FROM `warehouse_teslimat` Where id=$id")->row();
                $item_id = $kontrol->talep_form_product_id;
                $form_id = $kontrol->form_id;
                $product_id = $kontrol->product_id;
                $teslim_edilecek_warehouse_id = $kontrol->teslim_edilecek_warehouse_id;
                $product_stock_code = talep_form_product_options_teklif_values($item_id);
                $stock_details = stock_qty_new_mt($product_id,$product_stock_code,$form_id,$teslim_edilecek_warehouse_id);
                if($stock_details){
                    $alinan_miktar = floatval($stock_details['qty']);
                }
                else {
                    $alinan_miktar=$query2_->row()->qty;
                }
            }
        }
    }


    $kalan=$alinan_miktar-$qaime_miktar;
    if($kalan < 0) {
        $kalan=$alinan_miktar;
    }


    return ['alinan_miktar'=>$alinan_miktar,'kalan'=>$kalan];
}
function talep_form_status_list()
{
    $ci = &get_instance();
    $ci->load->database();
    $query2_ = $ci->db->query("SELECT * FROM `talep_form_status` ");
    return $query2_->result();
}
function talep_form_status_list_info($status,$form_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $type='';
    $message='';
    if($status==1){
        $type='17';
        $message='| Onaylar silip stok kontrolüne düşecektir.';
    }
    elseif($status==2){
        $type='1';
    }
    elseif($status==3){
        $type='2';
    }
    elseif($status==4){
        $type='3';
        $message='| Alınanan Teklifler Silinecek ve Tekrar Teklif Almak Zorunda Kalacaksınız!';
    }
    elseif($status==5){
        $type='4';
    }
    elseif($status==6){

        $query=$ci->db->query("SELECT * FROM talep_form_transaction Where form_id=$form_id")->num_rows();
        if($query){
            $type='0';
        }
        else {
            $type='5';
        }

    }
    elseif($status==7){

        $warehouse_list = $ci->db->query("SELECT * FROM warehouse_teslimat WHERE form_id=$form_id");
        if($warehouse_list->num_rows()){
            $array_id=[];
            foreach ($warehouse_list->result() as $list){
                $array_id[]=$list->id;
            }
            $str =  implode(",", $array_id);
            $warehouse_list_teslimat = $ci->db->query("SELECT * FROM teslimat_warehouse_item WHERE teslimat_warehouse_id IN ($str)");
            if($warehouse_list_teslimat->num_rows()){
                $type='0';
            }
            else {
                $query=$ci->db->query("SELECT * FROM talep_form_transaction Where form_id=$form_id")->num_rows();
                if($query){
                    $type='6';
                }
                else {
                    $type='6';
                }
            }

        }

    }
    elseif($status==8){
        $type='7';
    }
    elseif($status==9){
        $type='8';
    }
    elseif($status==10){
        $type='0';
    }
    elseif($status==11){
        $type='5';
    }
    if($type){
        $query2_ = $ci->db->query("SELECT * FROM `talep_form_status` Where id IN($type)");
        return array('items'=>$query2_->result(),'message'=>$message);
    }
    else {
        return array('items'=>'','message'=>'');
    }

}
function stock_update_new(
    $product_id,
    $unit_id,
    $warehouse_item_qty,
    $type,
    $warehouse_id,
    $aaut_id,
    $talep_id = 0,
    $form_type = 1,
    $proje_stoklari_id=null,
    $tnf_arac_id=0
)
{
    $ci = &get_instance();
    $ci->load->database();
    $data = array(
        'product_id' => $product_id,
        'qty' => $warehouse_item_qty,
        'types' => $type,
        'unit' => $unit_id,
        'warehouse_id' => $warehouse_id,
        'aauth_id' => $aaut_id,
        'mt_id' => $talep_id,
        'form_type' => $form_type,
        'proje_stoklari_id' => $proje_stoklari_id,
        'talep_form_nakliye_product_arac_id' => $tnf_arac_id,
        'loc'     => $ci->session->userdata('set_firma_id')

    );

    $ci->db->insert('stock', $data);
    return  $ci->db->insert_id();
}
function malzeme_talep_product_kontrol($talep_form_product_id,$pid, $talep_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $html = '';
    if($talep_id){
        $details = $ci->db->query("Select * From talep_form Where id=$talep_id")->row();

        $asama_id = $details->asama_id;
        $bolum_id = $details->bolum_id;
        if($ci->db->query("SELECT * FROM talep_form_products Where id=$talep_form_product_id")->num_rows()){
            $product_stock_code_id = $ci->db->query("SELECT * FROM talep_form_products Where id=$talep_form_product_id")->row()->product_stock_code_id;




            if(isset($product_stock_code_id)){
                $query2_ = $ci->db->query("SELECT talep_form_products.* FROM  `talep_form_products` 
    INNER JOIN talep_form ON talep_form_products.form_id = talep_form.id Where 
talep_form_products.form_id !=$talep_id and talep_form_products.product_id=$pid and talep_form_products.product_stock_code_id=$product_stock_code_id
                                                                         and talep_form.asama_id=$asama_id and talep_form.bolum_id=$bolum_id
     and talep_form.status not in (9,10)");
                if ($query2_->num_rows()) {
                    foreach ($query2_->result() as $items) {
                        $code = $ci->db->query("SELECT * FROM `talep_form` Where id=$items->form_id")->row()->code;
                        $html .= "<span  class='badge badge-danger'><i class='fa-solid fa-circle-info '></i>&nbsp" . $code . ' Açıkta Bulunan Talepte Bu Ürün Talep Ediliyor<br></span>';
                    }
                }
                return $html;
            }
            else {
                $query2_ = $ci->db->query("SELECT talep_form_products.* FROM  `talep_form_products` 
    INNER JOIN talep_form ON talep_form_products.form_id = talep_form.id Where 
talep_form_products.form_id !=$talep_id and talep_form_products.product_id=$pid and 
                                                                          talep_form.asama_id=$asama_id and talep_form.bolum_id=$bolum_id
     and talep_form.status not in (9,10)");
                if ($query2_->num_rows()) {
                    foreach ($query2_->result() as $items) {
                        $code = $ci->db->query("SELECT * FROM `talep_form` Where id=$items->form_id")->row()->code;
                        $html .= "<span  class='badge badge-danger'><i class='fa-solid fa-circle-info '></i>&nbsp" . $code . ' Açıkta Bulunan Talepte Bu Ürün Talep Ediliyor<br></span>';
                    }
                }
                return $html;
            }


        }
        else {
            $query2_ = $ci->db->query("SELECT talep_form_products.* FROM  `talep_form_products` 
    INNER JOIN talep_form ON talep_form_products.form_id = talep_form.id Where 
talep_form_products.form_id !=$talep_id and talep_form_products.product_id=$pid and 
                                                                          talep_form.asama_id=$asama_id and talep_form.bolum_id=$bolum_id
     and talep_form.status not in (9,10)");
            if ($query2_->num_rows()) {
                foreach ($query2_->result() as $items) {
                    $code = $ci->db->query("SELECT * FROM `talep_form` Where id=$items->form_id")->row()->code;
                    $html .= "<span  class='badge badge-danger'><i class='fa-solid fa-circle-info '></i>&nbsp" . $code . ' Açıkta Bulunan Talepte Bu Ürün Talep Ediliyor<br></span>';
                }
            }
            return $html;
        }

    }
    else {
        return false;
    }

}
function cari_teklif_nakliye_kontrol($cari_id,$form_id){
    $ci = &get_instance();
    $ci->load->database();
    $nakliye=0;
    $telif_ids = $ci->db->query("SELECT * FROM `talep_form_teklifler` Where form_id =$form_id and cari_id=$cari_id");
    if($telif_ids->num_rows()){
        $teklif_id = $telif_ids->row()->id;
        $nakliye_Details = $ci->db->query("SELECT * FROM `talep_form_teklifler_details` Where tf_teklif_id =$teklif_id");
        if($nakliye_Details->num_rows()){
            $nakliye=$nakliye_Details->row()->teslimat_tutar;
        }
    }
    return $nakliye;
}

function cari_teklif_kontol($form_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $id_ar = [];
    $teklif_kontrol = [];
    $telif_ids = $ci->db->query("SELECT * FROM `talep_form_teklifler` Where form_id =$form_id");
    if ($telif_ids->num_rows()) {
        foreach ($telif_ids->result() as $id) {
            $teklif_kontrol[] = teklif_update_kontrol($id->id);
            $id_ar[] = $id->id;
        }



        $str = implode(',', $id_ar);
        $query2_ = $ci->db->query("SELECT * FROM  `talep_form_teklif_cari_details` Where teklif_id IN ($str) and status=3");
        if ($query2_->num_rows()) {
            if ($teklif_kontrol[0] != '') {
                return  true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function talep_form_item_id($onay_list_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $id_ar = [];
    $telif_ids = $ci->db->query("SELECT * FROM `teklif_onay_list` Where id = $onay_list_id");
    if ($telif_ids->num_rows()) {

        $talep_form_teklifler_item_details_id = $telif_ids->row()->talep_form_teklifler_item_details_id;
        $telif_details = $ci->db->query("SELECT * FROM `talep_form_teklifler_item_details` Where  id = $talep_form_teklifler_item_details_id");
        if ($telif_details->num_rows()) {
            return $telif_details->row()->tfitem_id;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}
function confirm_cari_talep($cari_id, $talep_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $cari_talepleri = $ci->db->query("SELECT talep_form.* FROM `talep_form_cari`  INNER JOIN talep_form ON talep_form_cari.talep_id=talep_form.id Where  talep_form.id!=$talep_id and talep_form.status=8 and talep_form_cari.cari_id = $cari_id GROUP BY talep_form_cari.talep_id");
    if ($cari_talepleri->num_rows()) {
        return $cari_talepleri->result();
    } else {
        return false;
    }
}
function stock_fis_list()
{
    $ci = &get_instance();
    $ci->load->database();
    $cari_talepleri = $ci->db->query("SELECT * FROM `stock_transfer` ORDER BY id DESC ");
    if ($cari_talepleri->num_rows()) {
        return $cari_talepleri->result();
    } else {
        return false;
    }
}
function kelbecer_farki($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $cari_talepleri = $ci->db->query("SELECT net_salary FROM `personel_salary`  where personel_id = $id and status=1");
    if ($cari_talepleri->num_rows()) {
        return $cari_talepleri->row()->net_salary;
    } else {
        return 0;
    }
}
function net_maas_hesaplama($personel_id, $is_gunu)
{
    $ci = &get_instance();
    $ci->load->database();
    $salary_config = $ci->config->item('salary');
    $salary = $ci->db->query("SELECT *FROM personel_salary WHERE personel_id=$personel_id and status=1")->row()->bank_salary;

    $hastalik_amouth = 0;
    $banka_hesaplanan = floatval($salary) / floatval($is_gunu) * floatval($is_gunu);
    $cemi = floatval(0) + floatval($banka_hesaplanan) + floatval(0);

    $cemi = round($cemi, 2);

    if ((floatval($cemi) - floatval($hastalik_amouth)) > $salary_config['salary_200']) {
        $dsmf_isveren = floatval($salary_config['200_buyuk_toplam']) + (floatval($cemi) - floatval($hastalik_amouth) - floatval($salary_config['salary_200'])) * floatval($salary_config['200_buyuk_oran']);
    } else {
        $dsmf_isveren = (floatval($cemi) - floatval($hastalik_amouth)) * floatval($salary_config['200_kucuk_oran']);
    }

    $dsmf_isveren = round($dsmf_isveren, 2);

    $issizlik_isveren = round(($cemi - $hastalik_amouth) * ($salary_config['issizlik_oran'] / 100), 3);
    $issizlik_isci =  ($cemi - $hastalik_amouth) * ($salary_config['issizlik_oran'] / 100);

    $issizlik_isveren = round($issizlik_isveren, 2);
    $issizlik_isci = round($issizlik_isci, 2);

    if ($cemi <= floatval($salary_config['icbari_tavan'])) {
        $icbari_sigorta_isveren = ($cemi - $hastalik_amouth) * ($salary_config['icbari_taban_orani'] / 100);
        $icbari_sigorta_isci = ($cemi - $hastalik_amouth) * ($salary_config['icbari_taban_orani'] / 100);
    } elseif ($cemi > $salary_config['icbari_tavan']) {
        $icbari_sigorta_isveren = $salary_config['icbari_tavan_float'] + ($cemi - $salary_config['icbari_tavan']) * $salary_config['icbari_tavan_orani'] / 100;
        $icbari_sigorta_isci = $salary_config['icbari_tavan_float'] + ($cemi - $salary_config['icbari_tavan']) * $salary_config['icbari_tavan_orani'] / 100;
    }
    $icbari_sigorta_isci = round($icbari_sigorta_isci, 2);
    $icbari_sigorta_isveren = round($icbari_sigorta_isveren, 2);



    if (($cemi - floatval($hastalik_amouth)) > floatval($salary_config['salary_200'])) {
        $dsmf_isci = floatval($salary_config['dsmf_isci_float']) + (floatval($cemi - $hastalik_amouth) - floatval($salary_config['salary_200'])) * (floatval($salary_config['dsmf_isci_oran_max']) / 100);
    } else {
        $dsmf_isci = (floatval($cemi) - floatval($hastalik_amouth)) * (floatval($salary_config['dsmf_isci_oran_min']) / 100);
    }

    $dsmf_isci = round($dsmf_isci, 2);

    if ($cemi > $salary_config['icbari_tavan']) {
        $gelir_vergisi = ($cemi - $salary_config['icbari_tavan']) * (floatval($salary_config['gelir_vergi_oran']) / 100);
    } else {
        $gelir_vergisi = 0;
    }

    $gelir_vergisi = round($gelir_vergisi, 2);
    $kesinti = floatval($dsmf_isci) + floatval($gelir_vergisi) + floatval($icbari_sigorta_isci) + floatval($issizlik_isci);

    return floatval($salary) - floatval($kesinti);
}

function net_maas_hesaplama_number($personel_id, $is_gunu)
{
    $ci = &get_instance();
    $ci->load->database();
    $salary_config = $ci->config->item('salary');
    $salary = $ci->db->query("SELECT *FROM personel_salary WHERE personel_id=$personel_id and status=1")->row()->bank_salary;

    $hastalik_amouth = 0;
    $banka_hesaplanan = floatval($salary) / floatval($is_gunu) * floatval($is_gunu);
    $cemi = floatval(0) + floatval($banka_hesaplanan) + floatval(0);

    $cemi = round($cemi, 2);

    if ((floatval($cemi) - floatval($hastalik_amouth)) > $salary_config['salary_200']) {
        $dsmf_isveren = floatval($salary_config['200_buyuk_toplam']) + (floatval($cemi) - floatval($hastalik_amouth) - floatval($salary_config['salary_200'])) * floatval($salary_config['200_buyuk_oran']);
    } else {
        $dsmf_isveren = (floatval($cemi) - floatval($hastalik_amouth)) * floatval($salary_config['200_kucuk_oran']);
    }

    $dsmf_isveren = round($dsmf_isveren, 2);

    $issizlik_isveren = round(($cemi - $hastalik_amouth) * ($salary_config['issizlik_oran'] / 100), 3);
    $issizlik_isci =  ($cemi - $hastalik_amouth) * ($salary_config['issizlik_oran'] / 100);

    $issizlik_isveren = round($issizlik_isveren, 2);
    $issizlik_isci = round($issizlik_isci, 2);

    if ($cemi <= floatval($salary_config['icbari_tavan'])) {
        $icbari_sigorta_isveren = ($cemi - $hastalik_amouth) * ($salary_config['icbari_taban_orani'] / 100);
        $icbari_sigorta_isci = ($cemi - $hastalik_amouth) * ($salary_config['icbari_taban_orani'] / 100);
    } elseif ($cemi > $salary_config['icbari_tavan']) {
        $icbari_sigorta_isveren = $salary_config['icbari_tavan_float'] + ($cemi - $salary_config['icbari_tavan']) * $salary_config['icbari_tavan_orani'] / 100;
        $icbari_sigorta_isci = $salary_config['icbari_tavan_float'] + ($cemi - $salary_config['icbari_tavan']) * $salary_config['icbari_tavan_orani'] / 100;
    }
    $icbari_sigorta_isci = round($icbari_sigorta_isci, 2);
    $icbari_sigorta_isveren = round($icbari_sigorta_isveren, 2);



    if (($cemi - floatval($hastalik_amouth)) > floatval($salary_config['salary_200'])) {
        $dsmf_isci = floatval($salary_config['dsmf_isci_float']) + (floatval($cemi - $hastalik_amouth) - floatval($salary_config['salary_200'])) * (floatval($salary_config['dsmf_isci_oran_max']) / 100);
    } else {
        $dsmf_isci = (floatval($cemi) - floatval($hastalik_amouth)) * (floatval($salary_config['dsmf_isci_oran_min']) / 100);
    }

    $dsmf_isci = round($dsmf_isci, 2);

    if ($cemi > $salary_config['icbari_tavan']) {
        $gelir_vergisi = ($cemi - $salary_config['icbari_tavan']) * (floatval($salary_config['gelir_vergi_oran']) / 100);
    } else {
        $gelir_vergisi = 0;
    }

    $gelir_vergisi = round($gelir_vergisi, 2);
    $kesinti = floatval($dsmf_isci) + floatval($gelir_vergisi) + floatval($icbari_sigorta_isci) + floatval($issizlik_isci);

    $kalan = $salary - $kesinti;
    return floatval($kalan);
}


function net_maas_hesaplama_salary($salary)
{
    $ci = &get_instance();
    $ci->load->database();
    $is_gunu=30;
    $salary_config = $ci->config->item('salary');
    $hastalik_amouth = 0;
    $banka_hesaplanan = floatval($salary) / floatval($is_gunu) * floatval($is_gunu);
    $cemi = floatval(0) + floatval($banka_hesaplanan) + floatval(0);

    $cemi = round($cemi, 2);

    if ((floatval($cemi) - floatval($hastalik_amouth)) > $salary_config['salary_200']) {
        $dsmf_isveren = floatval($salary_config['200_buyuk_toplam']) + (floatval($cemi) - floatval($hastalik_amouth) - floatval($salary_config['salary_200'])) * floatval($salary_config['200_buyuk_oran']);
    } else {
        $dsmf_isveren = (floatval($cemi) - floatval($hastalik_amouth)) * floatval($salary_config['200_kucuk_oran']);
    }

    $dsmf_isveren = round($dsmf_isveren, 2);

    $issizlik_isveren = round(($cemi - $hastalik_amouth) * ($salary_config['issizlik_oran'] / 100), 3);
    $issizlik_isci =  ($cemi - $hastalik_amouth) * ($salary_config['issizlik_oran'] / 100);

    $issizlik_isveren = round($issizlik_isveren, 2);
    $issizlik_isci = round($issizlik_isci, 2);

    if ($cemi <= floatval($salary_config['icbari_tavan'])) {
        $icbari_sigorta_isveren = ($cemi - $hastalik_amouth) * ($salary_config['icbari_taban_orani'] / 100);
        $icbari_sigorta_isci = ($cemi - $hastalik_amouth) * ($salary_config['icbari_taban_orani'] / 100);
    } elseif ($cemi > $salary_config['icbari_tavan']) {
        $icbari_sigorta_isveren = $salary_config['icbari_tavan_float'] + ($cemi - $salary_config['icbari_tavan']) * $salary_config['icbari_tavan_orani'] / 100;
        $icbari_sigorta_isci = $salary_config['icbari_tavan_float'] + ($cemi - $salary_config['icbari_tavan']) * $salary_config['icbari_tavan_orani'] / 100;
    }
    $icbari_sigorta_isci = round($icbari_sigorta_isci, 2);
    $icbari_sigorta_isveren = round($icbari_sigorta_isveren, 2);



    if (($cemi - floatval($hastalik_amouth)) > floatval($salary_config['salary_200'])) {
        $dsmf_isci = floatval($salary_config['dsmf_isci_float']) + (floatval($cemi - $hastalik_amouth) - floatval($salary_config['salary_200'])) * (floatval($salary_config['dsmf_isci_oran_max']) / 100);
    } else {
        $dsmf_isci = (floatval($cemi) - floatval($hastalik_amouth)) * (floatval($salary_config['dsmf_isci_oran_min']) / 100);
    }

    $dsmf_isci = round($dsmf_isci, 2);

    if ($cemi > $salary_config['icbari_tavan']) {
        $gelir_vergisi = ($cemi - $salary_config['icbari_tavan']) * (floatval($salary_config['gelir_vergi_oran']) / 100);
    } else {
        $gelir_vergisi = 0;
    }

    $gelir_vergisi = round($gelir_vergisi, 2);
    $kesinti = floatval($dsmf_isci) + floatval($gelir_vergisi) + floatval($icbari_sigorta_isci) + floatval($issizlik_isci);

    return floatval($salary) - floatval($kesinti);
}

function db_details($id){
    $ci =& get_instance();
    $ci->load->database();
    $db='';
    if($id==2){ //link DB Bilgileri
        $db = $ci->db->query("SELECT * FROM `geopos_link_db`  Where id=1");
    }
    else {
        $db = $ci->db->query("SELECT * FROM `geopos_db`  Where id=1");
    }

    return $db->row();

}

function talep_status_count($status_id,$talep_type=1){
    $ci =& get_instance();
    $ci->load->database();

    $loc = $ci->session->userdata('set_firma_id');
    if($status_id<0){
        $db = $ci->db->query("SELECT * FROM `talep_form`  Where loc=$loc and talep_type=$talep_type");
    }
    else{
        $db = $ci->db->query("SELECT * FROM `talep_form`  Where status=$status_id and loc=$loc and talep_type=$talep_type");
    }

    if($db->num_rows()){
        return $db->num_rows();
    }
    else {
        return  0;
    }
}

function count_date($date_time){
    $date=explode('-',$date_time);
    $date_=explode('-',$date_time);
    $dates = explode(' ',$date_time);
    $time=explode(' ',$date_[2]);
    $times=explode(':',$time[1]);
    $ay = explode(' ',$date[2]);
    //$monthName = date("M", strtotime(mktime(0, 0, 0, intval($date[1]), 1, 1900)));
    $monthName = date('M', strtotime($dates[0]));
    //Jan 5, 2024 15:37:25
    $text_=$monthName.' '.intval($ay[0]).', '.intval($date[0]).' '.$times[0].':'.$times[1].':'.$times[2];
    return $text_;
}

function teklif_avans_kontrol($talep_id){
    $ci = & get_instance();
    $ci->load->database();
    $id=[];
    $cari_id=[];
    $onaylanan_firma = onaylanan_firma_list($talep_id);
    if($onaylanan_firma){
        foreach ($onaylanan_firma as $items_cari){
            $cari_id[]=$items_cari->cari_id;
        }
        if($cari_id){
            $talep_form_teklifler_details_id=[];
            $cari_id_str=implode(',',$cari_id);
            $query=$ci->db->query("SELECT * FROM talep_form_teklifler Where form_id = $talep_id and cari_id in($cari_id_str)");
            if($query->num_rows()){
                foreach ($query->result() as $items){
                    $id[] = $items->id;
                }


                $id_string = implode(',',$id);
                $kontrol = $ci->db->query("SELECT * FROM talep_form_teklifler_details Where tf_teklif_id IN ($id_string)");
                if($kontrol->num_rows()){
                    foreach ($kontrol->result() as $item){
                        $talep_form_teklifler_details_id[]=$item->id;
                    }
                }

                return $talep_form_teklifler_details_id;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }


}


function teklif_avans_details($tf_teklif_id){
    $ci = & get_instance();
    $ci->load->database();
    $result=[];

    $query=$ci->db->query("SELECT * FROM talep_form_teklifler_details  Where id = $tf_teklif_id ");
    if($query->num_rows()){
        $id = $query->row()->tf_teklif_id;
        $kontrol =$ci->db->query("SELECT talep_form_teklifler.*,geopos_customers.company FROM talep_form_teklifler INNER JOIN geopos_customers ON talep_form_teklifler.cari_id = geopos_customers.id Where talep_form_teklifler.id = $id ");
        if($kontrol->num_rows()){

            $talep_id = $kontrol->row()->form_id;
            $cari_id = $kontrol->row()->cari_id;
            $alt_total=0;
            $siparis_list = $ci->db->query("SELECT * FROM siparis_list_form WHERE talep_id = $talep_id and cari_id = $cari_id and deleted_at is Null")->result();
            foreach ($siparis_list as $items){
                $alt_total+= $ci->db->query("SELECT * FROM siparis_list_form_new WHERE siparis_liste_form_id = $items->id")->row()->item_umumi_hidden;

            }
            $result=[
                'firma_name'=>$kontrol->row()->company,
                'cari_id'=>$cari_id,
                'alt_total_val'=>amountFormat(floatval($alt_total)+floatval($query->row()->teslimat_tutar),$query->row()->para_birimi),
                'avans_price'=>amountFormat($query->row()->avans_price,$query->row()->para_birimi),
                'avans_tutari'=>$query->row()->avans_price,
                'teslimat_tutar'=>$query->row()->teslimat_tutar,
                'toplam_tutar'=>floatval($alt_total)+floatval($query->row()->teslimat_tutar),
                'para_birimi'=>$query->row()->para_birimi,
                'para_birimi_name'=>para_birimi_ogren_id($query->row()->para_birimi),
                'method'=>account_type_sorgu($query->row()->method),
                'method_id'=>$query->row()->method,
                'talep_form_teklifler_id'=>$kontrol->row()->id,
                'talep_form_teklifler_details_id'=>$query->row()->id
            ];


        }

        return  $result;
    }
    else {
        return false;
    }
}
function proje_yetkilileri($proje_id,$type_id){
    $ci = & get_instance();
    $ci->load->database();
    $result=[];

    $query=$ci->db->query("SELECT * FROM geopos_projects  Where id = $proje_id ");
    if($query->num_rows()){
        if($type_id==1)//tüm yetkililer
        {
            $result=
                [
                    ['sort'=>1,'user_id'=>$query->row()->depo_muduru_id],
                    ['sort'=>2,'user_id'=>$query->row()->proje_sorumlusu_id],
                    ['sort'=>3,'user_id'=>$query->row()->proje_muduru_id],
                    ['sort'=>4,'user_id'=>$query->row()->muhasebe_muduru_id],
                    ['sort'=>5,'user_id'=>$query->row()->genel_mudur_id],

            ];
        }
        else if($type_id==2)//proje onay yetkikeri
        {
            $result=
                [
                    ['sort'=>1,'user_id'=>$query->row()->proje_sorumlusu_id],
                    ['sort'=>2,'user_id'=>$query->row()->proje_muduru_id],
                    ['sort'=>3,'user_id'=>$query->row()->genel_mudur_id],

            ];
        }
        else if($type_id==3)//proje muhasebe dahil onay yetkikeri
        {
            $result=
                [
                   ['sort'=>1,'user_id'=>$query->row()->proje_sorumlusu_id],
                   ['sort'=>2,'user_id'=>$query->row()->proje_muduru_id],
                   ['sort'=>3,'user_id'=>$query->row()->muhasebe_muduru_id],
                   ['sort'=>4,'user_id'=>$query->row()->genel_mudur_id],

            ];
        }

        else if($type_id==4)//proje Muduru ve Genel Mudur
        {
            $result=
                [

                    ['sort'=>1,'user_id'=>$query->row()->proje_muduru_id],
                    ['sort'=>2,'user_id'=>$query->row()->genel_mudur_id],

            ];
        }

        else if($type_id==5)//Genel Mudur
        {
            $result=
                [
                    ['sort'=>1,'user_id'=>$query->row()->genel_mudur_id],

            ];
        }


        return array_sort($result,'sort','SORT_ASC');;

    }
    else {
        return false;
    }
}
function avans_odeme_kontrol($talep_id,$type,$cari_id){
    $ci = & get_instance();
    $ci->load->database();
    $result=[];

    $query=$ci->db->query("SELECT * FROM talep_form_avans  Where talep_id = $talep_id and cari_id=$cari_id and type=$type");
    if($query->num_rows()) {
        return true;
    }
    else {
        return false;
    }
}
function avans_odeme_kontrol_details($talep_id,$type,$cari_id){
    $ci = & get_instance();
    $ci->load->database();
    $result=[];

    $query=$ci->db->query("SELECT * FROM talep_form_avans  Where talep_id = $talep_id and cari_id=$cari_id and type=$type");
    if($query->num_rows()) {
        return $query->row();
    }
    else {
        return false;
    }
}
function talep_form_avans_status($status_id){
    $ci = & get_instance();
    $ci->load->database();
    $query=$ci->db->query("SELECT * FROM talep_form_avans_status  Where id =$status_id");
    if($query->num_rows()) {
        return $query->row();
    }
}
function talep_form_status_details($status_id){
    $ci = & get_instance();
    $ci->load->database();

    $query=$ci->db->query("SELECT * FROM talep_form_status  Where id =$status_id");
    if($query->num_rows()) {
        return $query->row();
    }
}
function talep_form_avans_sort_details($status_id){
    $ci = & get_instance();
    $ci->load->database();
    $query=$ci->db->query("SELECT * FROM talep_form_avans_status  Where id =$status_id");
    if($query->num_rows()) {
        return $query->row();
    }
}
function talep_form_sort_why($avas_talep_id){
    $ci = & get_instance();
    $ci->load->database();
    $query=$ci->db->query("SELECT talep_form_avans_sort.*,geopos_employees.name from talep_form_avans_sort 
    INNER JOIN geopos_employees ON talep_form_avans_sort.staff_id =geopos_employees.id 
    where  talep_form_avans_sort.staff_status=0 and talep_form_avans_sort.staff=1 and talep_form_avans_sort.talep_form_avans_id=$avas_talep_id 
ORDER BY talep_form_avans_sort.sort ASC LIMIT 1");
    if($query->num_rows()) {
        return $query->row();
    }
}
function talep_form_muhasebe($avas_talep_id){
    $ci = & get_instance();
    $ci->load->database();
    $query=$ci->db->query("SELECT talep_form_avans_sort.*,geopos_employees.name from talep_form_avans_sort
                                                              INNER JOIN geopos_employees ON talep_form_avans_sort.muhasebe_id =geopos_employees.id
where   talep_form_avans_sort.talep_form_avans_id=$avas_talep_id and sort=1
");
    if($query->num_rows()) {
        return $query->row();
    }
}
function talep_odeme_emri_kontrol($avas_talep_id){
    $ci = & get_instance();
    $ci->load->database();
    $user_id = $ci->aauth->get_user()->id;
    $query=$ci->db->query("SELECT talep_form_avans_sort.*,geopos_employees.name from talep_form_avans_sort INNER JOIN geopos_employees ON talep_form_avans_sort.staff_id =geopos_employees.id  where talep_form_avans_sort.staff_status=4 and talep_form_avans_sort.talep_form_avans_id=$avas_talep_id and talep_form_avans_sort.muhasebe_id = $user_id ORDER BY talep_form_avans_sort.sort DESC LIMIT 1");
    if($query->num_rows()) {
        return $query->row();
    }
    else {
        return false;
    }
}

function get_value_is($stock_id){
    $ci = & get_instance();
    $ci->load->database();

    if($stock_id){
        $details = $ci->db->query("SELECT * FROM product_stock_code Where id=$stock_id")->row();

        $html="<table class='table'><thead><tr><th>STOK KODU - Sistem Kodu</th>";


        $product_to_options_value = $ci->db->query("SELECT * FROM product_to_options_value Where product_stock_code=$stock_id")->result();
        foreach ($product_to_options_value as $id_arr){
            $product_to_option_id[]=$id_arr->product_to_option_id;
        }

        $uniq = array_unique($product_to_option_id);
        foreach ($uniq as $uniq_new){
            $option_id = $ci->db->query("SELECT * FROM product_to_options Where id=$uniq_new")->row()->option_id;
            $option_name = $ci->db->query("SELECT * FROM product_options Where id=$option_id")->row()->name;


            $html.="<td>$option_name</td>";
        }


        $html.="</tr></thead><tbody>";

        $option_btn='<button style="margin-top:5px; " type="button" class="btn-sm btn btn-info stock_view"  product_stock_id="'.$stock_id.'">'.$details->code.'</button>';

        $html.="<tr><td>$option_btn</td>";
        $values=$ci->db->query("SELECT pov.* FROM product_to_options_value
INNER JOIN product_option_value pov on product_to_options_value.option_value_id = pov.id
WHERE
product_stock_code=$stock_id
")->result();
        foreach ($values as $new_items){


            $html.="<td>$new_items->name</td>
                ";
        }
        $html.="</tr>";


        $html.='</tbody></table>';

        return ['status'=>true,'html'=>$html];
    }
    else {
        return ['status'=>false];
    }



}
function product_to_option_html_news($product_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("SElECT * FROM product_stock_code Where product_id = $product_id ORDER BY id ASC");
    if($details->num_rows()){
        $html="<table class='table'><thead><tr><th>STOK KODU - Sistem Kodu</th>";

        $product_to_option_id=[];
        foreach ($details->result() as $items) {
            $product_to_options_value = $ci->db->query("SELECT * FROM product_to_options_value Where product_stock_code=$items->id")->result();
            foreach ($product_to_options_value as $id_arr){
                $product_to_option_id[]=$id_arr->product_to_option_id;
            }
        }

        $uniq = array_unique($product_to_option_id);
        foreach ($uniq as $uniq_new){
            $option_id = $ci->db->query("SELECT * FROM product_to_options Where id=$uniq_new")->row()->option_id;
            $option_name = $ci->db->query("SELECT * FROM product_options Where id=$option_id")->row()->name;
            $html.="<td>$option_name</td>";
        }


         $html.="</tr></thead><tbody>";
        foreach ($details->result() as $items){

            $details_parent = $ci->db->query("SElECT * FROM geopos_products_parent Where product_stock_code_id = $items->id")->row();


            $tags=isset($details_parent->tag)?$details_parent->tag:'';

            $html.="<tr><td><input type='checkbox' class='form-control option-value' stock_code_id='$items->id'>
            <button style='margin-top:5px; '  type='button' class='btn-sm btn btn-info stock_view' product_id='$product_id' product_stock_id='$items->id'> $items->code | $items->sistem_code</button>
            <button class='btn btn-yellow tags_button' product_id='$items->id' tag_value='$tags' types='geopos_products_parent' title='Ürün Etiketleri'><i class='fa fa-tags'></i></button>
            </td>";
            $values=$ci->db->query("SELECT pov.* FROM product_to_options_value
INNER JOIN product_option_value pov on product_to_options_value.option_value_id = pov.id
WHERE
product_stock_code=$items->id
")->result();
            foreach ($values as $new_items){
               $html.="<td>$new_items->name </td>
                ";
            }
            $html.="</tr>";

        }
        $html.='</tbody></table>';

         return ['status'=>true,'html'=>$html];
    }

}
function product_to_option_html_news_radio($product_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("SElECT * FROM product_stock_code Where product_id = $product_id ORDER BY id ASC");
    if($details->num_rows()){
        $html="<table class='table'><thead><tr><th>STOK KODU - Sistem Kodu</th>";

        $product_to_option_id=[];
        foreach ($details->result() as $items) {
            $product_to_options_value = $ci->db->query("SELECT * FROM product_to_options_value Where product_stock_code=$items->id")->result();
            foreach ($product_to_options_value as $id_arr){
                $product_to_option_id[]=$id_arr->product_to_option_id;
            }
        }

        $uniq = array_unique($product_to_option_id);
        foreach ($uniq as $uniq_new){
            $option_id = $ci->db->query("SELECT * FROM product_to_options Where id=$uniq_new")->row()->option_id;
            $option_name = $ci->db->query("SELECT * FROM product_options Where id=$option_id")->row()->name;
            $html.="<td>$option_name</td>";

        }


        $html.="</tr></thead><tbody>";
        foreach ($details->result() as $items){
            $html.="<tr><td><input type='radio' class='form-control option-value' stock_code_id='$items->id' name='radiobutton' >$items->code | $items->sistem_code</td>";
            $values=$ci->db->query("SELECT pov.* FROM product_to_options_value
INNER JOIN product_option_value pov on product_to_options_value.option_value_id = pov.id
WHERE
product_stock_code=$items->id
")->result();
            foreach ($values as $new_items){
                $html.="<td>$new_items->name</td>
                ";
            }
            $html.="</tr>";

        }
        $html.='</tbody></table>';

        return ['status'=>true,'html'=>$html];
    }

}


//
//function product_to_option_html_news($product_id){
//    $ci = & get_instance();
//    $ci->load->database();
//    $details = $ci->db->query("Select po.id,po.name From product_to_options as pto INNER JOIN product_options as po ON pto.option_id=po.id WHERE pto.product_id=$product_id ORDER BY pto.sort");
//    $option_id=[];
//    $options_values=[];
//    if($details->num_rows()){
//        foreach ($details->result() as $options){
//            $option_id[]=['option_id'=>$options->id,'option_name'=>$options->name];
//        }
//
//        foreach ($option_id as $items){
//            $op_id=$items['option_id'];
//            $op_name=$items['option_name'];
//            $values = $ci->db->query("SELECT * FROM product_option_value WHERE product_option_value.product_option_id=$op_id")->result_array();
//            $options_values[]=['option_id'=>$op_id,'option_name'=>$op_name,'items'=>$values];
//        }
//
//        $html='<div class="row" >';
//
//        foreach ($options_values as $key=>$items){
//            $option_name = $items['option_name'];
//            $option_id = $items['option_id'];
//            $col = (count($items) == 3) ? 4:3;
//            $visable='visibility: visible;';
//            $parent_id=0;
//            if($key>0){
//                $visable='visibility: hidden;';
//            }
//            $html .= '<div class="col-md-'.$col.' div_vs" key='.$key.'  style="max-height: 300px;overflow: auto;'.$visable.'">';
//
//            $html .= '<div class="font-weight-semibold mb-2">'.$option_name.' <span class="text-danger">*</span></div>';
//            foreach ($items['items'] as $j=>$values){
//
//                $kontrol=$ci->db->query("SELECT * FROM product_options Where id=$option_id")->row();
//                if($kontrol->parent_option){
//                    $parent_id=1;
//                }
//
//                $border = (($j+1) == count($values)) ? '' : 'border-bottom';
//                $html.= '<div style="'.$visable.'"  key='.$key.' class="value_div_'.$values['id'].' custom-control custom-radio-'.$key.' custom-control mb-2 pb-2 '.$border.'">';
//                $html.= '<input  type="radio" key='.$key.' parent_id='.$parent_id.' class="custom-control-input option-value" data-value-id="'.$values['id'].'" data-option-id="'.$option_id.'"  data-option-name="'.$option_name.'" data-option-value-name="'.$values['name'].'"   name="option_id_'.$option_id.'" id="option_value_id_'.$values['id'].'">';
//                $html.= '<label   class="custom-control-label" for="option_value_id_'.$values['id'].'">'.$values['name'].'</label>';
//                $html.= '&nbsp;<span style="font-size: 10px;" class="text-muted">&nbsp;'.$values['description'].'</span></div>';
//            }
//            $html.= '</div>';
//
//        }
//
//        $html.= '</div>';
//        return ['status'=>true,'html'=>$html];
//    }
//    else {
//        return ['status'=>false,'html'=>''];
//    }
//
//}

function product_to_option_html($product_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("Select po.id,po.name From product_to_options as pto INNER JOIN product_options as po ON pto.option_id=po.id WHERE pto.product_id=$product_id ORDER BY pto.sort");
    $option_id=[];
    $options_values=[];
    if($details->num_rows()){
        foreach ($details->result() as $options){
            $option_id[]=['option_id'=>$options->id,'option_name'=>$options->name];
        }

        foreach ($option_id as $items){
            $op_id=$items['option_id'];
            $op_name=$items['option_name'];
            //$values = $ci->db->query("SELECT * FROM product_option_value WHERE product_option_value.product_option_id=$op_id")->result_array();
            $values = $ci->db->query("SELECT * FROM product_option_value WHERE product_option_value.product_option_id=$op_id")->result_array();
            $options_values[]=['option_id'=>$op_id,'option_name'=>$op_name,'items'=>$values];
        }

        $html='<div class="row" >';

        foreach ($options_values as $key=>$items){
            $option_name = $items['option_name'];
            $option_id = $items['option_id'];
            $col = (count($items) == 3) ? 4:3;
            $visable='visibility: visible;';


            $html .= '<div class="col-md-'.$col.' div_vs" key='.$key.'  style="max-height: 300px;overflow: auto;'.$visable.'">';
            $html .= '<div style="position: initial;" class="font-weight-semibold mb-2">'.$option_name.' <span class="text-danger">*</span></div>';
            $html .='<input type="text" class="form-control option_search_keyword" data-tablec="'.$items['option_id'].'" placeholder="Kelime Yazınız.."><table class="'.$items['option_id'].'"><thead><tr><th></th></tr></thead><tbody>';

           foreach ($items['items'] as $j=>$values){
                $html.='<tr><td>';
                $border = (($j+1) == count($values)) ? '' : 'border-bottom';
                $html.= '<div  class="custom-control custom-radio custom-control mb-2 pb-2 '.$border.'">';
                $html.= '<input  type="radio" class="custom-control-input option-value" data-value-id="'.$values['id'].'" data-option-id="'.$option_id.'"  data-option-name="'.$option_name.'" data-option-value-name="'.$values['name'].'"   name="option_id_'.$option_id.'" id="option_value_id_'.$values['id'].'">';
                $html.= '<label   class="custom-control-label" for="option_value_id_'.$values['id'].'">'.$values['name'].'</label>';
                $html.= '&nbsp;<span style="font-size: 10px;" class="text-muted">&nbsp;'.$values['description'].'</span></div>';
                $html.='</tr></td>';

            }
            $html.='</tbody></table>';
            $html.= '</div>';

        }

        $html.= '</div>';
        return ['status'=>true,'html'=>$html];
    }
    else {
        return ['status'=>false,'html'=>''];
    }

}
function product_to_option_html_warehouse($product_id,$warehouse_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("SELECT
       SUM(IF(types=1,stock.qty,0)) as giren,
       SUM(IF(types=0,stock.qty,0)) as cikan,
stock.unit,
stock.id,stock.qty,stock.types,stock.warehouse_id,
   IF(`stock_to_options`.`option_id`,`stock_to_options`.`option_id`,NULL) as option_id,
       IF(`stock_to_options`.`option_value_id`,`stock_to_options`.`option_value_id`,NULL) as option_value_id,
       IF(`stock_to_options`.`option_value_id`,`stock_to_options`.`option_value_id`,NULL) as s_option_value_id

FROM stock
LEFT JOIN stock_to_options ON stock.id = stock_to_options.stock_id WHERE stock.product_id=$product_id and stock.warehouse_id=$warehouse_id
GROUP BY s_option_value_id");

    $varyasyon=false;
    $html='';
    if($details->num_rows()){
        $html .= '<div style="max-height: 400px;overflow: scroll;" class="col-md-12">';
        $html .= '<div class="font-weight-semibold mb-2">Depoda Bulunan Varyasyonlar<span class="text-danger">*</span></div>';
        $kontrol=[];
        foreach ($details->result() as $items){
            $kalan = floatval($items->giren)-floatval($items->cikan);
            if($items->option_value_id){

                if($kalan){

                    if($items->option_value_id){
                       if(!in_array($items->option_value_id,$kontrol)){
                            $varyasyon=true;

                            $option_value_name = $ci->db->query("SELECT * FROM product_option_value Where id IN ($items->option_value_id)")->result();
                            $option_value_html='<p>';
                            $str='<p>';
                            foreach ($option_value_name as $name_value){
                                $option_value_html .= $name_value->name . "  ";
                                $str .= $name_value->name . "  ";
                            }
                            $str.='</p>';
                            $option_value_html.=': '.$kalan.' '.units_($items->unit)['name'].'</p>';
                            $html.= '<div class="custom-control custom-radio custom-control mb-2 pb-2 border-bottom">';
                            $html.= '<input type="radio" class="custom-control-input option-value" 
                            varyant_tip="1"
                            data-value-id="'.$items->option_value_id.'" 
                            value="option_value_id_'.$items->option_value_id.'" str="'.$str.'"
                            name="option_value_id" max="'.$kalan.'"
                            id="option_value_id_'.$items->option_value_id.'">';
                            $html.= '<label class="custom-control-label" for="option_value_id_'.$items->option_value_id.'">'.$option_value_html.'</label>';
                            $html.= '</div>';
                            $kontrol[] = $items->option_value_id;
                        }

                    }

                }
            }
            else {
                $html.= '<div class="custom-control custom-radio custom-control mb-2 pb-2 border-bottom">';
                $html.= '<input type="radio" class="custom-control-input option-value" 
                data-value-id="0" 
                value="'.$items->id.'"
                id="'.$items->id.'"
                varyant_tip="0"
                str="VAryasyonsuz" 
                name="option_value_id" max="'.$kalan.'" checked>';
                $html.= '<label for="'.$items->id.'" class="custom-control-label">Varyasyonsuz '.amountFormat_s($kalan).' '.units_($items->unit)['name'].'</label>';
                $html.= '</div>';
            }


        }

        $html.= '</div>';
        return ['status'=>true,'html'=>$html,'varyasyonstatus'=>$varyasyon];

    }
    else {
        return ['status'=>false,'html'=>'Bu Ürün Stokta Bulunamamıştır','varyasyonstatus'=>$varyasyon];
    }


}

function array_value_recursive($key, array $arr){
    $val = array();
    array_walk_recursive($arr, function($v, $k) use($key, &$val){
        if($k == $key) array_push($val, $v);
    });
    return count($val) > 1 ? $val : array_pop($val);
}


function proje_to_bolum($proje_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("Select * From geopos_project_bolum Where pid = $proje_id");
    if($details->num_rows()){

        return $details->result();
    }
    else {
        return false;
    }

}
function proje_to_bolum_html($proje_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("Select * From geopos_project_bolum Where pid = $proje_id");
    $bolum_id=[];
    if($details->num_rows()){
        foreach ($details->result() as $bolum){
            $bolum_id[]=['id'=>$bolum->id,'name'=>$bolum->name];
        }

        $html='<div class="row">';
        $col = 4;
        $html .= '<div style="max-height: 400px;overflow: scroll;" class="col-md-'.$col.'">';
        $html .= '<div class="font-weight-semibold mb-2">Bölümler<span class="text-danger">*</span></div>';
        foreach ($bolum_id as $key=>$items){
            $name = $items['name'];
            $id = $items['id'];
            $border = 'border-bottom';
            $html.= '<div class="custom-control custom-radio custom-control mb-2 pb-2 '.$border.'">';
            $html.= '<input type="radio" class="custom-control-input bolum_radio"  data-bolum-id="'.$id.'"  data-bolum-name="'.$name.'" value="bolum_id_val_'.$id.'" name="bolum" id="bolum_id_val_'.$id.'">';
            $html.= '<label class="custom-control-label" for="bolum_id_val_'.$id.'">'.$name.'</label>';
            $html.= '</div>';


        }

        $html.= '</div>';
        $html.= '</div>';
        return ['status'=>true,'html'=>$html];
    }
    else {
        return ['status'=>false,'html'=>''];
    }

}
function bolum_to_asama_html($bolum_id){
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("Select * From geopos_milestones Where bolum_id = $bolum_id");
    $bolum_id=[];
    $html='';
    if($details->num_rows()){
        foreach ($details->result() as $bolum){
            $bolum_id[]=['id'=>$bolum->id,'name'=>$bolum->name];
        }


        $col = 4;
        $html .= '<div style="max-height: 400px;overflow: scroll;" class="asama_div col-md-'.$col.'">';
        $html .= '<div class="font-weight-semibold mb-2">Aşamalar<span class="text-danger">*</span></div>';
        foreach ($bolum_id as $key=>$items){
            $name = $items['name'];
            $id = $items['id'];
            $border = 'border-bottom';
            $html.= '<div class="custom-control custom-radio custom-control mb-2 pb-2 '.$border.'">';
            $html.= '<input type="radio" class="custom-control-input asama_radio"  data-asama-id="'.$id.'"  data-asama-name="'.$name.'" value="asama_id_val_'.$id.'" name="asama" id="asama_id_val_'.$id.'">';
            $html.= '<label class="custom-control-label" for="asama_id_val_'.$id.'">'.$name.'</label>';
            $html.= '</div>';


        }

        $html.= '</div>';
        return ['status'=>true,'html'=>$html];
    }
    else {
        return ['status'=>false,'html'=>''];
    }

}
function talep_form_product_options($id){
    $option_html="<p style='font-size: 11px'>Varyant Tanımlanmamış</p>";
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("SELECT * FROM talep_form_products_options Where talep_form_product_id=$id");

    if($details->num_rows()){
        $option_html='';
        if($details->row()->option_id){
            $option_html.=varyasyon_string_name($details->row()->option_id,$details->row()->option_value_id);
        }

    }
    return $option_html;

}
function talep_form_product_options_new($id){
    $option_html="<p style='font-size: 11px'>Varyant Tanımlanmamış</p>";
    $ci = & get_instance();
    $ci->load->database();
    $varyasyon_name='';
    if($id){
        $details = $ci->db->query("SELECT * FROM product_stock_code Where id=$id");
        $option_html='';
        if($details->num_rows()){
            if($details->row()->code){

                $option_html.=$details->row()->code;
                $fa_button="<i class='fas fa-info-circle' style='font-size: 25px; animation-name: flash;  animation-duration: 1s;animation-timing-function: linear;animation-iteration-count: infinite;color: #0497ab'></i>";
                $varyasyon_name="<span style='cursor:pointer' class='option_view_btn' stock_code_id='$id'>$option_html</span>  ".$fa_button;

            }
        }

    }

    return $varyasyon_name;

}
function talep_form_product_options_new_mobil($id){
    $option_html="<p style='font-size: 11px'>Varyant Tanımlanmamış</p>";
    $ci = & get_instance();
    $ci->load->database();
    $varyasyon_name='';
    if($id){
        $details = $ci->db->query("SELECT * FROM product_stock_code Where id=$id");
        $option_html='';
        if($details->num_rows()){
            if($details->row()->code){

                $option_html.=$details->row()->code;
                $varyasyon_name=$option_html;

            }
        }

    }

    return $varyasyon_name;

}


function talep_form_product_details_items($id){

    $ci = & get_instance();
    $ci->load->database();
    $option_html='';
    $details = $ci->db->query("SELECT * FROM talep_form_products Where id=$id");

    if($details->num_rows()){

        $option_html=product_details($details->row()->product_id)->product_name;

    }
    return $option_html;

}
function talep_form_product_options_print($id){
    $option_html="<p style='font-size: 5px'>Varyant Tanımlanmamış</p>";
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("SELECT * FROM talep_form_products_options Where talep_form_product_id=$id");

    if($details->num_rows()){
        $option_html='';
        if($details->row()->option_id){
            $option_html.=varyasyon_string_name_print($details->row()->option_id,$details->row()->option_value_id);
        }

    }
    return $option_html;

}
function talep_form_product_options_teklif_html($id){
    $option_html="<p style='font-size: 11px'>Varyant Tanımlanmamış</p>";
    $ci = & get_instance();
    $ci->load->database();
    if($id){

        $details = $ci->db->query("SELECT * FROM talep_form_products Where id=$id");

        if($details->num_rows()){
            $option_html='';
            if($details->row()->product_stock_code_id) {
                $code_id = $details->row()->product_stock_code_id;

                if($ci->db->query("SELECT * FROM product_stock_code Where id=$code_id")->num_rows()){
                    $option_html .=$ci->db->query("SELECT * FROM product_stock_code Where id=$code_id")->row()->code;
                }
                else {
                    $option_html.='';
                }

               // $option_html .= varyasyon_string_name($details->row()->option_id, $details->row()->option_value_id);

            }
        }
    }

    return $option_html;

}

function varyasyon_string_name_new($product_stock_code_id=0){
    $ci = & get_instance();
    $ci->load->database();
    $option_html='Varyasyonsuz';
    if($product_stock_code_id){
        $items=$ci->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id");
        if($items->num_rows()){
            $option_html = $items->row()->code;
        }
    }
    return $option_html;
}


function varyasyon_string_name($option_id,$option_value_id,$product_id = 0 ){
    $array=[];
    $ci = & get_instance();
    $ci->load->database();

    $details='';
    $option_html='Varyasyonsuz';
    if($option_value_id){
        $option_html='';
        if($product_id){
            $details = $ci->db->query("SELECT product_options.name,product_option_value.name as value_name FROM product_options
    INNER JOIN product_option_value ON product_options.id=product_option_value.product_option_id
    INNER JOIN product_to_options On product_to_options.option_id=product_options.id
Where product_options.id IN ($option_id) and
        product_option_value.id IN ($option_value_id) and product_to_options.product_id = $product_id ORDER BY product_to_options.sort ASC");
        }
        else {
            $details = $ci->db->query("SELECT product_options.name,product_option_value.name as value_name FROM product_options INNER JOIN product_option_value ON product_options.id=product_option_value.product_option_id
Where product_options.id IN ($option_id) and
        product_option_value.id IN ($option_value_id)");
        }


        if($details->num_rows()){

            foreach ($details->result_array() as $options_items){
                $option_html.="<p> ".$options_items['name'].' : '.$options_items['value_name']."</p>";
            }
        }
    }

    return $option_html;

}

function varyasyon_string_name_print($option_id,$option_value_id){
    $array=[];
    $ci = & get_instance();
    $ci->load->database();

    $option_html='';
    if($option_value_id){
        $details = $ci->db->query("SELECT product_options.name,product_option_value.name as value_name FROM product_options INNER JOIN product_option_value ON product_options.id=product_option_value.product_option_id
Where product_options.id IN ($option_id) and
        product_option_value.id IN ($option_value_id)");

        if($details->num_rows()){

            foreach ($details->result_array() as $options_items){
                $option_html.=$options_items['name'].' : '.$options_items['value_name'];
            }
        }
    }

    return $option_html;

}



function all_users()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_users ");
    $row = $query2->result();
    return $row;


}


function all_roles()
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_role ");
    $row = $query2->result();
    return $row;


}

function confirm_details_permit($role_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $loc =  $ci->session->userdata('set_firma_id');
    $query2 = $ci->db->query("SELECT * FROM role_approvals Where approval_id=$role_id and loc=$loc");
    if($query2->num_rows()){
        $id = $query2->row()->id;
        $queryitem = $ci->db->query("SELECT * FROM role_approvals_items Where role_id=$id");
        if($queryitem->num_rows()){
            return $queryitem->result();
        }

    }
    else {
        return false;
    }

}

function confirm_insert_permit($permit_id,$staff_id,$sort,$status=null)
{
    $ci = &get_instance();
    $ci->load->database();
    $data = array(
        'user_permit_id' => $permit_id,
        'staff_id' => $staff_id,
        'sort' => $sort,
        'staff_status' => $status,

    );
    if($ci->db->insert('user_permit_confirm', $data)){
        return true;
    }
    else {
        return false;
    }

}

function getSmallLink($longurl,$tip){
    $ci = &get_instance();
    $ci->load->database();
    $talep_no = numaric($tip);

    $url = $longurl;
    $sort_url='https://makrolink.site/'.$talep_no;

    $data_items=array
    (
        'sort_link'=>$sort_url,
        'long_link'=>$url,
    );
    $ci->db->insert('sort_link', $data_items);

    $operator= "deger+1";
    $ci->db->set('deger', "$operator", FALSE);
    $ci->db->where('tip', $tip);
    $ci->db->update('numaric');

    $db_details  = db_details(2); // Link DB Bilgileri
    //$firma = new mysqli('localhost', 'link', 'Gm7s6z^8', 'link');
    $firma = new mysqli($db_details->ip, $db_details->db_user, $db_details->db_pass, $db_details->db_name);
    if ($firma->connect_error) {
        die("Connection failed: " . $firma->connect_error);
    }
    $sql="INSERT INTO `sort_link`(`sort_link`, `long_link`) VALUES ('$sort_url','$url')";
    if ($firma->query($sql) === TRUE) {
        return $sort_url;
    }
    else {
        return "Error: " . $sql . "<br>" . $firma->error;
    }

}

function talep_list_kontrol($stok_id, $user_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $details = $ci->db->query("SELECT * FROM talep_list_proje Where proje_stoklari_id=$stok_id and aauth_id=$user_id");

    if ($details->num_rows()) {
        return true;
    }
    else{
        return false;
    }
}
function option_sort($value){

    $return = explode(',',$value);
    sort($return);
    $return= implode(',',$return);

    return $return;
}


function proje_qty_function($proje_id,$product_id,$bolum_id,$asama_id,$option_id,$option_value_id){
    $ci = &get_instance();
    $ci->load->database();

    $option_where='';
    if($option_id){
        $option_where=" and option_id='$option_id' 
      and option_value_id='$option_value_id'";
    }
    $gerekli_miktar =  $ci->db->query("SELECT IF(SUM(proje_stoklari.qty),SUM(proje_stoklari.qty),0) as gerekli_miktar  FROM proje_stoklari 
            Where product_id=$product_id and
       asama_id=$asama_id $option_where")->row()->gerekli_miktar;




    $proje_warehouse_id  = $ci->db->query("SElECT * FROM geopos_warehouse Where proje_id = $proje_id")->row()->id;

    $depoya_giren  =  $ci->db->query("
    SELECT IF(SUM(stc.qty),SUM(stc.qty),0) as miktar from stock stc
INNER JOIN stock_to_options sto on stc.id = sto.stock_id
INNER JOIN talep_form tf on stc.mt_id = tf.id
where stc.product_id=$product_id and sto.option_id='$option_id' and
      sto.option_value_id='$option_value_id' and stc.types=1 and stc.form_type=1 and
     tf.proje_id=$proje_id and tf.asama_id=$asama_id and  stc.warehouse_id=$proje_warehouse_id
      ")->row()->miktar;

    return floatval($gerekli_miktar)-floatval($depoya_giren);


}
function proje_qty_function_new($proje_id,$product_id,$bolum_id,$asama_id,$option_id,$option_value_id,$product_stock_code_id){
    $ci = &get_instance();
    $ci->load->database();

    $option_where='';
    if($product_stock_code_id){
        $option_where=" and product_stock_code_id=$product_stock_code_id";
    }
    $gerekli_miktar =  $ci->db->query("SELECT IF(SUM(proje_stoklari.qty),SUM(proje_stoklari.qty),0) as gerekli_miktar  FROM proje_stoklari 
            Where product_id=$product_id and
       asama_id=$asama_id $option_where")->row()->gerekli_miktar;




    $proje_warehouse_id  = $ci->db->query("SElECT * FROM geopos_warehouse Where proje_id = $proje_id")->row()->id;

    $depoya_giren  =  $ci->db->query("
    SELECT IF(SUM(stc.qty),SUM(stc.qty),0) as miktar from stock stc
INNER JOIN stock_to_options sto on stc.id = sto.stock_id
INNER JOIN talep_form tf on stc.mt_id = tf.id
where stc.product_id=$product_id and sto.option_id='$option_id' and
      sto.option_value_id='$option_value_id' and stc.types=1 and stc.form_type=1 and
     tf.proje_id=$proje_id and tf.asama_id=$asama_id and  stc.warehouse_id=$proje_warehouse_id
      ")->row()->miktar;

    return floatval($gerekli_miktar)-floatval($depoya_giren);


}


function talep_form_product_options_teklif_values($id)
{
    $product_stock_code_id=0;
    $ci = &get_instance();
    $ci->load->database();
    if($id){
    $details = $ci->db->query("SELECT * FROM talep_form_products Where id=$id");


        if ($details->num_rows()) {

            if($details->row()->product_stock_code_id){
                $product_stock_code_id=$details->row()->product_stock_code_id;
            }
        }
    }

    return $product_stock_code_id;
}

function talep_form_product_options_teklif_values_new($id)
{
    $product_stock_code_id=0;
    $ci = &get_instance();
    $ci->load->database();
    if($id){
    $details = $ci->db->query("SELECT * FROM talep_form_products Where id=$id");


        if ($details->num_rows()) {

            if($details->row()->product_stock_code_id){
                $product_stock_code_id=$details->row()->product_stock_code_id;
            }
        }
    }

    return $product_stock_code_id;
}



//
//function talep_form_product_options_teklif_values($id)
//{
//    $array = [];
//    $ci = &get_instance();
//    $ci->load->database();
//    if($id){
//    $details = $ci->db->query("SELECT * FROM talep_form_products_options Where talep_form_product_id=$id");
//
//
//        if ($details->num_rows()) {
//            $option_html = '';
//            foreach ($details->result_array() as $options_items) {
////            $option_id=numaric(28);
////            $option_value_id=numaric(28);
//                $option_id='';
//                $option_value_id='';
//                if($options_items['option_id']){
//                    $option_id=$options_items['option_id'];
//                }
//                if($options_items['option_value_id']){
//                    $option_value_id=$options_items['option_value_id'];
//                }
//                $array[] = [
//                    'option_id' => $option_id,
//                    'option_value_id' => $option_value_id,
//                ];
//                //$option_html.="<span style='font-size: 10px'> ".$options_items['option_name'].' : '.$options_items['option_value_name']."</span>";
//            }
//        }
//    }
//
//    return $array;
//}

function fatura_product_type(){
    $ci = &get_instance();
    $ci->load->database();
    $details = $ci->db->query("SELECT * FROM fatura_product_type")->result();
    return $details;
}



function onay_list_id_sorgu($siparis_list_form_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $query = $ci->db->query("SELECT * from siparis_list_form WHERE id=$siparis_list_form_id");
    if ($query->num_rows()) {
        return $query->row();
    }
}


function all_cost_like($like)
{
    $ci =& get_instance();
    $ci->load->database();


    $query2 = $ci->db->query("SELECT geopos_cost.name as product_name,geopos_cost.id as pid,geopos_units.name as unit_name,geopos_cost.unit as unit_id FROM `geopos_cost` INNER JOIN geopos_units ON geopos_cost.unit=geopos_units.id Where  geopos_cost.name LIKE '%$like%' ");
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

function modul_list()
{
    $ci = &get_instance();
    $ci->load->database();
    $query = $ci->db->query("SELECT * from geopos_premissions");
    if ($query->num_rows()) {
        return $query->result();
    }
}


function last_invoice_list()
{
    $ci = &get_instance();
    $ci->load->database();
    $where_loc='';
    if($ci->session->userdata('set_firma_id')){

        $where_loc = 'and i.loc ='.$ci->session->userdata('set_firma_id');
    }
    $query = $ci->db->query("SELECT i.invoice_no,i.id,i.tid,i.invoicedate,i.total,i.kur_degeri,i.status,i.i_class,c.company as name ,c.picture,i.csd
FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id WHERE i.invoice_type_id = 2 $where_loc ORDER BY i.id DESC LIMIT 8");
    if ($query->num_rows()) {
        return $query->result();
    }
}


function invoice_options_html($id){
    $option_html="<p style='font-size: 11px'>Varyant Tanımlanmamış</p>";
    $ci = & get_instance();
    $ci->load->database();
    $details = $ci->db->query("SELECT * FROM invoices_item_to_option Where invoices_item_id=$id");

    if($details->num_rows()){
        $option_html='';
        foreach ($details->result() as $options_items){
            if($options_items->product_stock_code_id){

                $name = varyasyon_string_name_new($options_items->product_stock_code_id);
                $option_html.="<span style='font-size: 12px'> ".$name."</span>";
            }

        }
    }
    return $option_html;

}

//
//function stock_update_options_new($stock_id, $option_id = 0, $option_value_id = 0)
//{
//    $ci = &get_instance();
//    $ci->load->database();
//    $data = array(
//        'stock_id' => $stock_id,
//        'option_id' => $option_id,
//        'option_value_id' => $option_value_id,
//    );
//
//    $ci->db->insert('stock_to_options', $data);
//}
function stock_update_options_new($stock_id, $product_stock_code_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $data = array(
        'stock_id' => $stock_id,
        'product_stock_code_id' => $product_stock_code_id,
    );

    $ci->db->insert('stock_to_options', $data);
}

function cloud_stock_update($fis_id, $id)
{
    $ci = &get_instance();
    $ci->load->database();
    $ci->db->set('fis', $fis_id);
    $ci->db->set('durum', 1);
    $ci->db->where('id', $id);
    $ci->db->update('cloud_stock');

}


function user_permit_type($id=false)
{
    $ci = &get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `permit_type` WHERE  id=$id");

        if ($query2->num_rows()) {
            return $query2->row();
        } else {
            return false;
        }
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `permit_type`");
        return  $query2->result();
    }

}
function customer_group_list($id=false)
{
    $ci = &get_instance();
    $ci->load->database();

    if($id){
        $query2 = $ci->db->query("SELECT * FROM `geopos_customer_type` WHERE  id=$id");

        if ($query2->num_rows()) {
            return $query2->row();
        } else {
            return false;
        }
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `geopos_customer_type`");
        return  $query2->result();
    }

}

function account_personel(){
    $ci = &get_instance();
    $ci->load->database();
    $list = $ci->db->query('SELECT geopos_employees.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE 
                           geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null GROUP BY geopos_accounts.eid');
    return  $list->result();

}

function avans_type($id=0){
    $ci =& get_instance();
    $ci->load->database();
    if($id==0){
        $details =  $ci->db->query("Select * From customer_avans_type");
        if($details->num_rows()){
            return $details->result();
        }
    }
    else {
        $details =  $ci->db->query("Select * From customer_avans_type Where id = $id");
        if($details->num_rows()){
            return $details->row();
        }
    }

}

function all_file_avans($avans_type,$customer_id){
    $ci = &get_instance();
    $ci->load->database();

    if($avans_type==1){
        $list = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM `geopos_invoices` Where `geopos_invoices`.`csd`=$customer_id and invoice_type_id IN(2,38,41) and status!=3 ");
        return  $list->result();
    }
    else if($avans_type==2){
        $list = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM `geopos_invoices` Where `geopos_invoices`.`csd`=$customer_id and invoice_type_id IN(29,30) and status IN (18)");
        return  $list->result();
    }

    else if($avans_type==3){
        $list = $ci->db->query("SELECT lojistik_satinalma_talep.id,lojistik_satinalma_talep.talep_no as invoice_no FROM `lojistik_satinalma_item` INNER JOIN lojistik_satinalma_talep ON lojistik_satinalma_talep.id =lojistik_satinalma_item.lojistik_id Where `lojistik_satinalma_item`.`firma_id`=$customer_id and  lojistik_satinalma_talep.status!=3 ");
        return  $list->result();
    }
    else if($avans_type==4){
        $list = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM `geopos_invoices` Where `geopos_invoices`.`csd`=$customer_id and invoice_type_id IN(35,36) and status!=3 ");
        return  $list->result();
    }
    else if($avans_type==5){
        $list = $ci->db->query("SELECT cari_razilastirma.id,cari_razilastirma.code as invoice_no  FROM `cari_razilastirma` Where `cari_razilastirma`.`cari_id`=$customer_id and razi_status !=2 ");
        return  $list->result();
    }
    else if($avans_type==6){
        $list = $ci->db->query("SELECT title as invoice_no,geopos_documents.id  FROM `geopos_documents` Where `geopos_documents`.`fid`=$customer_id ");
        return  $list->result();
    }
    else if($avans_type==7){
        $list = $ci->db->query("SELECT talep_form.code as invoice_no,talep_form.id  FROM `talep_form` INNER JOIN talep_form_cari ON talep_form_cari.talep_id = talep_form.id Where `talep_form_cari`.`cari_id`=$customer_id  and talep_form.status!=10 and talep_form.talep_type=2 GROUP BY talep_form.id,`talep_form_cari`.`cari_id`");
        return  $list->result();
    }
}
function avans_file_details($avans_type,$file_id){
    $ci = &get_instance();
    $ci->load->database();

    if($avans_type==1){
        $list = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM `geopos_invoices` Where id =$file_id ");
        $details = $list->row();
        return "<a class='btn btn-secondary' target='_blank'  href='/invoices/view?id=$file_id'>$details->invoice_no Faturayı Görüntüle</a>";
    }
    else if($avans_type==2){
        if($file_id){
            $list = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM `geopos_invoices` Where id =$file_id ");
            if($list->num_rows()){
                $details = $list->row();
                return "<a class='btn btn-secondary' target='_blank'  href='/formainvoices/view?id=$file_id'>$details->invoice_no Forma2 Görüntüle</a>";
            }
            else {

            }
        }

        }



    else if($avans_type==3){
        if($file_id){
            $list = $ci->db->query("SELECT lojistik_satinalma_talep.id,lojistik_satinalma_talep.talep_no FROM `lojistik_satinalma_talep` Where id =$file_id ");
            $details = $list->row();
            return "<a class='btn btn-secondary' target='_blank'  href='/logistics/view/$file_id'>$details->talep_no Lojistik Görüntüle</a>";
        }
        else {
            return '';
        }

    }
    if($avans_type==4){
        if($file_id) {
            $list = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM `geopos_invoices` Where id =$file_id ");
            $details = $list->row();
            return "<a class='btn btn-secondary' target='_blank'  href='/invoices/view?id=$file_id'>$details->invoice_no Sözleşmeyi Görüntüle</a>";
        }
        else {
            return '';
        }

    }
    if($avans_type==5){

        if ($file_id){
            $list = $ci->db->query("SELECT cari_razilastirma.id,cari_razilastirma.code,cari_razilastirma.cari_id,cari_razilastirma.file FROM `cari_razilastirma` Where id =$file_id ");
        }
        else{
            return false;
        }

        $list = $ci->db->query("SELECT cari_razilastirma.id,cari_razilastirma.code,cari_razilastirma.cari_id,cari_razilastirma.file FROM `cari_razilastirma` Where id =$file_id ");
        $details = $list->row();
        return "<a class='btn btn-success' target='_blank' href='/userfiles/product/$details->file'>$details->code Razılaştırma Görüntüle</a>";
    }
    if($avans_type==6){

        if ($file_id){
            $list = $ci->db->query("SELECT title as invoice_no  FROM `geopos_documents` Where `geopos_documents`.`id`=$file_id ");
        }
        else{
            return false;
        }

        $list = $ci->db->query("SELECT * FROM `geopos_documents` Where id =$file_id ");
        $details = $list->row();
        return "<a class='btn btn-secondary' target='_blank' href='/userfiles/product/$details->filename'>$details->title Belge Görüntüle</a>";
    }
    if($avans_type==7){

        if ($file_id){
            $list = $ci->db->query("SELECT code as invoice_no,talep_form.id  FROM `talep_form` Where `talep_form`.`id`=$file_id ");
            $details = $list->row();
            return "<a class='btn btn-secondary' target='_blank' href='/hizmet/view/$details->id'>$details->invoice_no Formu Görüntüle</a>";
        }
        else{
            return false;
        }


    }

}


function varyasyon_value_string($option_value_id){
    $array = [];
    $ci = &get_instance();
    $ci->load->database();

    $option_html = '';
    if($option_value_id){
        $details = $ci->db->query("SELECT product_option_value.name as value_name FROM product_option_value Where product_option_value.id IN ($option_value_id)");
        if ($details->num_rows()) {

            foreach ($details->result_array() as $options_items) {
                $option_html .= "<p> ". $options_items['value_name'] . "</p>";
            }
        }
    }

    return $option_html;
}

function proje_details($id){
    $ci = & get_instance();
    $ci->load->database();
    $query=$ci->db->query("SELECT * FROM geopos_projects  Where id = $id ");
    if($query->num_rows()){
        return $query->row();
    }
    else {
        false;
    }
}
function uretim_status($id=0){
    $ci = & get_instance();
    $ci->load->database();
    if($id){
        $query=$ci->db->query("SELECT * FROM uretim_fis_status  Where id = $id ");
        return $query->row();

    }
    else {
        $query=$ci->db->query("SELECT * FROM uretim_fis_status ");
        return $query->result();
    }

}

function transfer_status($id)
{

    $ci =& get_instance();
    $ci->load->database();

    if($id==0){
        return 'Transfersiz';
    }
    else {
        return 'Transferli';
    }


}

function task_count($personel_id,$tip)
{

    $ci =& get_instance();
    $ci->load->database();

    if($tip==1) // Bekliyor ve devam eden
    {
        $query=$ci->db->query("SELECT * FROM personel_task  Where personel_id = $personel_id and status in (1)");
        return $query->num_rows();

    }
    elseif($tip==2) {
        $query=$ci->db->query("SELECT * FROM personel_task  Where personel_id = $personel_id and status in (2)");
        return $query->num_rows();
    }
    else {
        $query=$ci->db->query("SELECT * FROM personel_task  Where personel_id = $personel_id and status in (3)");
        return $query->num_rows();
    }


}

function product_details($id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_products where pid=$id");
    return $query2->row();
}
function uretim_new_products($id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM uretim_new_product where invoice_id=$id");
    return $query2->result();
}
function siparis_to_fis($siparis_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM siparis_to_uretim_fis where invoice_item_id=$siparis_id");
    if($query2->num_rows()){
        $id=$query2->row()->uretim_fis_id;
        $details = $ci->db->query("SELECT * FROM geopos_uretim where id=$id");
        return array ('status'=>200,'details'=>$details->row());
    }
    else {
        return array ('status'=>410);
    }
}
function fis_to_siparis($fis_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM siparis_to_uretim_fis where uretim_fis_id=$fis_id");
    if($query2->num_rows()){
        $id=$query2->row()->siparis_id;
        $details = $ci->db->query("SELECT * FROM geopos_invoices where id=$id");
        return array ('status'=>200,'details'=>$details->row());
    }
    else {
        return array ('status'=>410);
    }
}
function uretim_tehvil_fisleri($fis_id){
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM geopos_invoices where task_id=$fis_id");
    if($query2->num_rows()){
        return array ('status'=>200,'details'=>$query2->result());
    }
    else {
        return array ('status'=>410);
    }
}
function talep_type($id=0){
    $ci =& get_instance();
    $ci->load->database();
    if($id){
        $query2 = $ci->db->query("SELECT * FROM talep_type where id=$id");
        return $query2->row();
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM talep_type");
        return $query2->result();
    }

}


function atanmis_odemeleri()
{
    $ci =& get_instance();
    $ci->load->database();
    $where_loc_customer='';
    if($ci->session->userdata('set_firma_id')){

        $where_loc_customer = 'and talep_form_customer.loc ='.$ci->session->userdata('set_firma_id');
    }

    $where_loc_personel='';
    if($ci->session->userdata('set_firma_id')){

        $where_loc_personel = 'and talep_form_personel.loc ='.$ci->session->userdata('set_firma_id');
    }

    $all = $ci->db->query("
SELECT COUNT(id) as sayi,payment_personel_id,'Cari Ödemeleri' as name,1  as tip FROM talep_form_customer Where status=12 and  odeme_durum=0 and payment_personel_id is not null $where_loc_customer
GROUP BY payment_personel_id
UNION ALL
SELECT COUNT(id) as sayi,payment_personel_id,'Personel Ödemeleri' as name,2 as tip FROM talep_form_personel Where status=12 and  odeme_durum=0 and payment_personel_id is not null $where_loc_personel
GROUP BY payment_personel_id")->result();

    return $all;

}

function atanmis_odemeler_details($user_id,$tip)
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


    if($tip==1){
        $cari_avans = $ci->db->query("SELECT
talep_form_customer_products.total,talep_form_customer.method From talep_form_customer
INNER JOIN talep_form_customer_products ON talep_form_customer_products.form_id =talep_form_customer.id
Where talep_form_customer.status=12 and  talep_form_customer.payment_personel_id=$user_id
");
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
    else {
        $cari_avans = $ci->db->query("SELECT
talep_form_personel_products.total,talep_form_personel.method From talep_form_personel
INNER JOIN talep_form_personel_products ON talep_form_personel_products.form_id =talep_form_personel.id
Where talep_form_personel.status=12 and  talep_form_personel.payment_personel_id=$user_id
");
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




}

function firmalar(){
    $ci =& get_instance();
    $query = $ci->db->query("SELECT * FROM geopos_locations ORDER BY id");
    return $query->result();
}
function firmalarthisnot(){


    $ci =& get_instance();
    $loc = $ci->session->userdata('set_firma_id');
    $query = $ci->db->query("SELECT * FROM geopos_locations Where id!=$loc ORDER BY id");
    return $query->result();
}

function time_day_get($status){
    $ci =& get_instance();
    $query = $ci->db->query("SELECT * FROM talep_form_status where id=$status");
    if($query->num_rows()){
        return $query->row()->day;
    }
    else {
        return false;
    }
}

function n_gun_sonra($n){
    date_default_timezone_set('Asia/Baku');
    $date = new DateTime('now');
    $start =  $date->format('Y-m-d H:i:s');
    $i=$n*24*60*60;
    $stop_date = date('Y-m-d H:i:s', strtotime($start) + $i);

    return [
        'start_date'=>$start,
        'end_date'=>$stop_date
    ];
}

function customer_personel($tip){
    $ci =& get_instance();
    $loc = $ci->session->userdata('set_firma_id');
    if($tip==1) // Cari
    {
        $query = $ci->db->query("SELECT geopos_customers.id,geopos_customers.company as name FROM geopos_customers Where loc=$loc ORDER BY id");
    }
    else if($tip==2) // Personel
    {
        $query = $ci->db->query("SELECT geopos_employees.id,geopos_employees.name FROM geopos_employees Where loc=$loc ORDER BY id");

    }

    return $query->result();
}
function mt_onay_pers($talep_id,$status){
    $ci =& get_instance();
    $personel_name='Bulunamadı';
    $tarih='Bulunamadı';
    $pers_id=0;

    if($status==1) // Talep Durumdaysa
    {
        $ci->db->select('geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_onay_new');
        $ci->db->join('geopos_employees','talep_onay_new.user_id=geopos_employees.id');
        $ci->db->where("talep_onay_new.type",1);
        $ci->db->where("talep_onay_new.staff",1);
        $ci->db->where('talep_onay_new.talep_id', $talep_id);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
        else {
            $talep_details = $ci->db->query("SELECT * FROM talep_form Where id=$talep_id")->row();
            if(!$talep_details->bildirim_durumu){
                $personel_name='Bildirim Başlatılmamış';
                $tarih=$talep_details->created_at;
                $pers_id=0;
            }
            else {
                $personel_name='Bulunamadı';
                $tarih='Bulunamadı';
                $pers_id=0;
            }
        }
    }
    elseif($status==17) // Talep Durumdaysa
    {
        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_form');
        $ci->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        $ci->db->join('geopos_employees','talep_onay_new.user_id=geopos_employees.id');
        $ci->db->where("talep_onay_new.type",3);
        $ci->db->where("talep_onay_new.staff",1);
        $ci->db->where('talep_form.id', $talep_id);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
    }
    elseif($status==9) // Tamamlandı
    {
        $personel_name = 'Tamamlandığına Göre Onay Bulunmamaktadır.';
        $pers_id=0;
        $tarih = '-';
    }
    elseif($status==2) // Cari Durumunda
    {
        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_form');
        $ci->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        $ci->db->join('geopos_employees','talep_user_satinalma.user_id=geopos_employees.id');
        $ci->db->where('talep_form.id', $talep_id);
        $ci->db->where("talep_user_satinalma.status",1);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
    }
    elseif($status==3) //
    {
        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_form');
        $ci->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        $ci->db->join('geopos_employees','talep_onay_new.user_id=geopos_employees.id');
        $ci->db->where("talep_onay_new.type",2);
        $ci->db->where("talep_onay_new.staff",1);
        $ci->db->where('talep_form.id', $talep_id);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
        else {
            $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
            $ci->db->from('talep_form');
            $ci->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            $ci->db->join('geopos_employees','talep_user_satinalma.user_id=geopos_employees.id');
            $ci->db->where('talep_form.id', $talep_id);
            $ci->db->where("talep_user_satinalma.status",2);
            $query = $ci->db->get();
            if($query->num_rows()){
                $personel_name = $query->row()->pers_name;
                $pers_id=$query->row()->m_pers_id;
                $tarih = '-';
            }
            else {
                $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
                $ci->db->from('talep_form');
                $ci->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
                $ci->db->join('geopos_employees','talep_user_satinalma.user_id=geopos_employees.id');
                $ci->db->where('talep_form.id', $talep_id);
                $ci->db->where("talep_user_satinalma.status",1);
                $query = $ci->db->get();
                if($query->num_rows()){
                    $personel_name = $query->row()->pers_name;
                    $pers_id=$query->row()->m_pers_id;
                    $tarih = '-';
                }
            }
        }
    }
    elseif($status==4){
        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_form');
        $ci->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        $ci->db->join('geopos_employees','talep_onay_new.user_id=geopos_employees.id');
        $ci->db->where("talep_onay_new.type",2);
        $ci->db->where("talep_form.status",4);
        $ci->db->where("talep_onay_new.staff",1);
        $ci->db->where('talep_form.id', $talep_id);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
    }
    elseif($status==5){
        $ci->db->select('siparis_list_form.staff_id');
        $ci->db->from('siparis_list_form');
        $ci->db->where('siparis_list_form.talep_id', $talep_id);
        $ci->db->group_by('siparis_list_form.talep_id');
        $query = $ci->db->get();
        if($query->num_rows()){
            $id = $query->row()->staff_id;
            $pers_id=$query->row()->staff_id;
            $personel_name = $ci->db->query("SELECT * FROM geopos_employees Where id=$id")->row()->name;
            $tarih = '-';
        }
        else {
            $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
            $ci->db->from('talep_form');
            $ci->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            $ci->db->join('geopos_employees','talep_user_satinalma.user_id=geopos_employees.id');
            $ci->db->where('talep_form.id', $talep_id);
            $ci->db->where("talep_form.status",5);
            $query = $ci->db->get();
            if($query->num_rows()){
                $personel_name = $query->row()->pers_name;
                $pers_id=$query->row()->m_pers_id;
                $tarih = '-';
            }
        }
    }
    elseif($status==6) // senet
    {
        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_form');
        $ci->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        $ci->db->join('geopos_employees','talep_user_satinalma.user_id=geopos_employees.id');
        $ci->db->where('talep_form.id', $talep_id);
        $ci->db->where("talep_user_satinalma.status",2);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
    }
    elseif($status==7) // Teslim
    {
        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
        $ci->db->from('talep_form');
        $ci->db->join('geopos_warehouse','talep_form.warehouse_id=geopos_warehouse.id');
        $ci->db->join('geopos_employees','geopos_warehouse.pers_id=geopos_employees.id');
        $ci->db->where('talep_form.id', $talep_id);
        $query = $ci->db->get();
        if($query->num_rows()){
            $personel_name = $query->row()->pers_name;
            $pers_id=$query->row()->m_pers_id;
            $tarih = '-';
        }
    }
    elseif($status==8) // qaime
    {
//        $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
//        $ci->db->from('talep_form');
//        $ci->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id');
//        $ci->db->join('geopos_employees','geopos_projects.muhasebe_muduru_id=geopos_employees.id');
//        $ci->db->where('talep_form.id', $talep_id);
//        $query = $ci->db->get();
//        if($query->num_rows()){
//            $personel_name = $query->row()->pers_name;
//            $pers_id=$query->row()->m_pers_id;
//            $tarih = '-';
//        }


        $personel_name = personel_detailsa(39)['name'];
        $pers_id=39;
        $tarih = '-';
    }
    elseif($status==11) // Ödeme Bekleyen
    {



            $ci->db->select('talep_form_avans_sort.staff_id');
            $ci->db->from('talep_form_avans_sort');
            $ci->db->join('talep_form_avans','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
            $ci->db->where("talep_form_avans.talep_id",$talep_id);
            $ci->db->where("talep_form_avans.type",1);
            $query = $ci->db->get();
            if($query->num_rows()){
                $id = $query->row()->staff_id;
                $pers_id=$query->row()->staff_id;
                $personel_name = $ci->db->query("SELECT * FROM geopos_employees Where id=$id")->row()->name;
                $tarih = '-';
            }
            else{
                $ci->db->select('talep_form_avans_sort.staff_id');
                $ci->db->from('talep_form_avans_sort');
                $ci->db->join('talep_form_avans','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
                $ci->db->where("talep_form_avans.talep_id",$talep_id);
                $ci->db->where("talep_form_avans.type",2);
                $query = $ci->db->get();
                if($query->num_rows()){
                    $id = $query->row()->staff_id;
                    $pers_id=$query->row()->staff_id;
                    $personel_name = $ci->db->query("SELECT * FROM geopos_employees Where id=$id")->row()->name;
                    $tarih = '-';
                }
                else{
                    $ci->db->select('talep_form.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
                    $ci->db->from('talep_form');
                    $ci->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
                    $ci->db->join('geopos_employees','talep_user_satinalma.user_id=geopos_employees.id');
                    $ci->db->where('talep_form.id', $talep_id);
                    $query = $ci->db->get();
                    if($query->num_rows()){
                        $personel_name = $query->row()->pers_name;
                        $pers_id=$query->row()->m_pers_id;
                        $tarih = '-';
                    }
                }
            }


    }
    elseif($status==10) // Ödeme Bekleyen
    {


        $personel_name = 'İptal Durumundan Kaynaklı Onay Yok.';
        $pers_id=0;
        $tarih = '-';

    }
    else {
        $talep_details = $ci->db->query("SELECT * FROM talep_form Where id=$talep_id")->row();
        if(!$talep_details->bildirim_durumu){
            $personel_name='Bildirim Başlatılmamış';
            $tarih=$talep_details->created_at;
            $pers_id=0;
        }
        else {
            $personel_name='Bulunamadı';
            $tarih='Bulunamadı';
            $pers_id=0;
        }
    }
    return [
        'personel_name'=>$personel_name,
        'tarih'=>$tarih,
        'pers_id'=>$pers_id
    ];
}

function gt_onay_pers($talep_id,$status,$tip){
    $ci =& get_instance();
    $personel_name='Bulunamadı';
    $tarih='Bulunamadı';
    $pers_id=0;

    if($status==1){

        if($tip==1){
            $ci->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
            $ci->db->from('talep_form_customer_new');
            $ci->db->join('talep_onay_customer_new','talep_form_customer_new.id=talep_onay_customer_new.talep_id');
            $ci->db->join('geopos_employees','talep_onay_customer_new.user_id=geopos_employees.id');
            $ci->db->where("talep_onay_customer_new.type",$tip);
            $ci->db->where("talep_onay_customer_new.staff",1);
            $ci->db->where('talep_form_customer_new.id', $talep_id);
            $query = $ci->db->get();
            if($query->num_rows()){
                $personel_name = $query->row()->pers_name;
                $pers_id=$query->row()->m_pers_id;
                $tarih = '-';
            }
        }
        else {
            $ci->db->select('talep_form_customer.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
            $ci->db->from('talep_form_customer');
            $ci->db->join('talep_onay_customer_new','talep_form_customer.id=talep_onay_customer_new.talep_id');
            $ci->db->join('geopos_employees','talep_onay_customer_new.user_id=geopos_employees.id');
            $ci->db->where("talep_onay_customer_new.type",$tip);
            $ci->db->where("talep_onay_customer_new.staff",1);
            $ci->db->where('talep_form_customer.id', $talep_id);
            $query = $ci->db->get();
            if($query->num_rows()){
                $personel_name = $query->row()->pers_name;
                $pers_id=$query->row()->m_pers_id;
                $tarih = '-';
            }
        }

    }
    elseif($status==11){
        $personel_name = 'Lokman Biter';
        $pers_id=61;
    }
    elseif($status==12){
        if($tip==1){
            $ci->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
            $ci->db->from('talep_form_customer_new');
            $ci->db->join('geopos_employees','talep_form_customer_new.payment_personel_id=geopos_employees.id');
            $ci->db->where('talep_form_customer_new.id', $talep_id);
            $querys = $ci->db->get();
            if($querys->num_rows()){
                $personel_name = $querys->row()->pers_name;
                $tarih = '-';
                $pers_id=$querys->row()->m_pers_id;
            }
        }


        else {
            $ci->db->select('talep_form_customer.*,geopos_employees.name as pers_name,geopos_employees.id as m_pers_id');
            $ci->db->from('talep_form_customer');
            $ci->db->join('geopos_employees','talep_form_customer.payment_personel_id=geopos_employees.id');
            $ci->db->where('talep_form_customer.id', $talep_id);
            $querys = $ci->db->get();
            if($querys->num_rows()){
                $personel_name = $querys->row()->pers_name;
                $tarih = '-';
                $pers_id=$querys->row()->m_pers_id;
            }
        }
    }

    return [
        'personel_name'=>$personel_name,
        'tarih'=>$tarih,
        'pers_id'=>$pers_id
    ];



}

function cost_kontroller_kode($id,$type){
    $ci =& get_instance();
    $query = $ci->db->query("SELECT * FROM geopos_controller Where islem_id=$id and type_id=$type");
    if($query->num_rows()){
        return [
            'status'=>true,
            'code'=>$query->row()->talep_no
        ];
    }
    else {
        return ['status'=>false];
    }

}

function asama_get($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_milestones");
    $ci->db->where("id", $id);

    $query = $ci->db->get();

    return $query->row();
}

function customer_teslimat_adresleri($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_customer_tadress");
    $ci->db->where("customer_id", $id);

    $query = $ci->db->get();

    return $query->result();
}
function customer_teslimat_adres_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("geopos_customer_tadress");
    $ci->db->where("id", $id);

    $query = $ci->db->get();

    return $query->row();
}
function customers_project_details($id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select("*");

    $ci->db->from("customers_project");
    $ci->db->where("customer_id", $id);

    $query = $ci->db->get();

    return $query->result();
}

function customer_new_projects_details($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM `customers_project` Where id=$id");
    $row = $query2->row();
    return $row;

}
function protok_forma2_avans_kontrol($forma2_id)
{
    $ci =& get_instance();
    $ci->load->database();
//    $query2 = $ci->db->query("SELECT * FROM `forma_2_to_muqavele` Where forma_2_id=$forma2_id");
//    if($query2->num_rows()){
//        $muqavele_id = $query2->row()->muqavele_id;
//        $avans_kontrol  = $ci->db->query("SELECT * FROM `talep_form_customer` Where file_id=$muqavele_id and avans_type = 5 and status=9");
//        if($avans_kontrol->num_rows()){
//            $avans_id = [];
//            foreach ($avans_kontrol->result() as $items){
//                $avans_id[]=$items->id;
//            }
//            $str = implode(',',$avans_id);
//            $odeme_kontrol  = $ci->db->query("SELECT * FROM `geopos_invoices` Where term IN ($str) and invoice_type_id = 4");
//            if($odeme_kontrol->num_rows()){
//                return array('status'=>1,'items'=>$odeme_kontrol->result());
//            }
//            else {
//                return array('status'=>0);
//            }
//
//
//        }
//        else {
//            return array('status'=>0);
//        }
//
//    }
//    else {
//        return array('status'=>0);
//    }



    $query2 = $ci->db->query("SELECT * FROM `geopos_invoices` Where id=$forma2_id");
    if($query2->num_rows()){
        $proje_id = $query2->row()->proje_id;
        $avans_kontrol  = $ci->db->query("SELECT * FROM `talep_form_customer` Where proje_id=$proje_id and avans_type = 5 and status=9");
        if($avans_kontrol->num_rows()){
            $avans_id = [];
            foreach ($avans_kontrol->result() as $items){
                $avans_id[]=$items->id;
            }
            $str = implode(',',$avans_id);
            $odeme_kontrol  = $ci->db->query("SELECT * FROM `geopos_invoices` Where term IN ($str) and invoice_type_id = 4");
            if($odeme_kontrol->num_rows()){
                return array('status'=>1,'items'=>$odeme_kontrol->result());
            }
            else {
                return array('status'=>0);
            }


        }
        else {
            return array('status'=>0);
        }

    }
    else {
        return array('status'=>0);
    }



}

function protok_forma2_avans_kontrol_($forma2_id)
{
    $ci =& get_instance();
    $ci->load->database();
//    $query2 = $ci->db->query("SELECT * FROM `forma_2_to_muqavele` Where forma_2_id=$forma2_id");
//    if($query2->num_rows()){
//        $muqavele_id = $query2->row()->muqavele_id;
//        $avans_kontrol  = $ci->db->query("SELECT * FROM `talep_form_customer` Where file_id=$muqavele_id and avans_type = 5 and status!=10");
//        if($avans_kontrol->num_rows()){
//            return array('status'=>1,'items'=>$avans_kontrol->result());
//        }
//        else {
//            return array('status'=>0);
//        }
//
//    }
//    else {
//        return array('status'=>0);
//    }


    $query2 = $ci->db->query("SELECT * FROM `geopos_invoices` Where id=$forma2_id");
    if($query2->num_rows()){
        $proje_id = $query2->row()->proje_id;
        $avans_kontrol  = $ci->db->query("SELECT * FROM `talep_form_customer` Where proje_id=$proje_id and avans_type = 5 and status!=10");
        if($avans_kontrol->num_rows()){
            return array('status'=>1,'items'=>$avans_kontrol->result());
        }
        else {
            return array('status'=>0);
        }

    }
    else {
        return array('status'=>0);
    }



}
function az_month($id = 0){
    $ci =& get_instance();
    $ci->load->database();
    if($id){

        $query2 = $ci->db->query("SELECT * FROM `az_month` Where id=$id");
        if($query2->num_rows()){
            return $query2->row();
        }
        return false;
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `az_month`");
        if($query2->num_rows()){
            return $query2->result();
        }
    }
}
function bordro_status($id = 0){
    $ci =& get_instance();
    $ci->load->database();
    if($id){

        $query2 = $ci->db->query("SELECT * FROM `bordro_status` Where id=$id");
        if($query2->num_rows()){
            return $query2->row();
        }
        return false;
    }
    else {
        $query2 = $ci->db->query("SELECT * FROM `bordro_status`");
        if($query2->num_rows()){
            return $query2->result();
        }
    }
}
function proje_to_employe($proje_id){
    $ci =& get_instance();
    $ci->load->database();

    $all_personel = $ci->db->query("SELECT geopos_employees.* FROM `geopos_employees`
        Inner JOIN personel_salary ON geopos_employees.id =personel_salary.personel_id
        Inner JOIN geopos_users ON geopos_employees.id =geopos_users.id
    Where geopos_users.banned=0 and  personel_salary.status = 1 and personel_salary.proje_id =$proje_id");
    if($all_personel->num_rows()){
        return $all_personel->result();
    }
    else{
        return 0;
    }

}
function bordro_onay_kimde($bordro_item_id){
    $ci =& get_instance();
    $ci->load->database();

    $all_personel = $ci->db->query("SELECT * FROM salary_onay_new Where bordro_item_id=$bordro_item_id and staff=1");
    if($all_personel->num_rows()){
        $pes_name= personel_details($all_personel->row()->user_id);
        return $pes_name;
    }
    else{
        return 0;
    }

}

function total_sundays($month,$year){
    $sundays=0;
    $total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for($i=1;$i<=$total_days;$i++)
        if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
            $sundays++;
    return $sundays;
}
function azpetrol_bakiye(){
    $ci =& get_instance();
    $ci->load->database();

    $kalan=0;
    $giren = $ci->db->query("SELECT SUM(amounth) as total FROM azpetrol_bakiye Where kart_id=0 and tip=1")->row()->total;
    $cikan = $ci->db->query("SELECT SUM(amounth) as total FROM azpetrol_bakiye Where kart_id=0 and tip=0")->row()->total;
    if($giren){
        $kalan = $giren-$cikan;
    }
    return amountFormat($kalan);

}

function azpetrol_bakiye_cart($cart_id){
    $ci =& get_instance();
    $ci->load->database();

    $kalan=0;
    $giren = $ci->db->query("SELECT SUM(amounth) as total FROM azpetrol_bakiye Where kart_id=$cart_id and tip=1")->row()->total;
    $cikan = $ci->db->query("SELECT SUM(amounth) as total FROM azpetrol_bakiye Where kart_id=$cart_id and tip=0")->row()->total;
    if($giren){
        $kalan = $giren-$cikan;
    }
    return amountFormat($kalan);

}
function azpetrol_cart_count(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM azpetrol_cart Where status=1")->num_rows();

    return $total;

}
function azpetrol_cart_list(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM azpetrol_cart Where status=1")->result();

    return $total;

}


function azpetrol_tanimli_arac(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM azpetrol_cart Where car_id!=0 and status=1")->num_rows();

    return $total;

}

function azpetrol_tanimli_arac_result(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT azpetrol_cart.*,araclar.plaka FROM azpetrol_cart INNER JOIN araclar ON azpetrol_cart.car_id=araclar.id Where azpetrol_cart.car_id!=0 and azpetrol_cart.status=1")->result();

    return $total;

}


function cart_list(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM azpetrol_cart Where car_id=0 and status=1")->result();

    return $total;

}
function azpetrol_tanimsiz_arac(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM araclar Where az_cart_id=0 and kiralik_demirbas=3")->result();

    return $total;

}
function all_arac(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM araclar")->result();

    return $total;

}
function mk_arac_list(){
    $ci =& get_instance();
    $ci->load->database();

    $result=false;
    $arac_list = $ci->db->query("SELECT * FROM araclar Where kiralik_demirbas=3");
    if($arac_list->num_rows()){
        $result = $arac_list->result();
    }
    return $result;

}


function benzin_bakiye(){
    $ci =& get_instance();
    $ci->load->database();

    $kalan=0;
    $giren = $ci->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where tip=1")->row()->total;
    $cikan = $ci->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where tip=0")->row()->total;
    $kalan = $giren-$cikan;

    return amountFormat_s($kalan).' LİTR';

}

function paylist_form(){
    $ci =& get_instance();
    $ci->load->database();

    $giren = $ci->db->query("select * from talep_form_customer_new Inner JOIN talep_form_customer_new_payment On talep_form_customer_new.id =talep_form_customer_new_payment.form_id
Where alacak_durum=0 and status=9 GROUP BY talep_form_customer_new.id")->num_rows();


    return $giren;

}


function benzin_cen_count(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM benzin_cen Where status=1")->num_rows();

    return $total;


}


function benzin_type_list(){
    $ci =& get_instance();
    $ci->load->database();

    $result=false;
    $arac_list = $ci->db->query("SELECT * FROM benzin_type");
    if($arac_list->num_rows()){
        $result = $arac_list->result();
    }
    return $result;

}
function benzin_type_who($id){
    $ci =& get_instance();
    $ci->load->database();

    $result=false;
    $arac_list = $ci->db->query("SELECT * FROM benzin_type where id=$id");
    if($arac_list->num_rows()){
        $result = $arac_list->row();
    }
    return $result;

}

function cen_who($id){
    $ci =& get_instance();
    $ci->load->database();

    $result='-';
    $arac_list = $ci->db->query("SELECT * FROM benzin_cen where id=$id");
    if($arac_list->num_rows()){
        $result = $arac_list->row();
    }
    return $result;

}

function benzin_cen_list(){
    $ci =& get_instance();
    $ci->load->database();

    $total = $ci->db->query("SELECT * FROM benzin_cen Where status=1")->result();

    return $total;

}

function benzin_bakiye_cen($cen_id){
    $ci =& get_instance();
    $ci->load->database();

    $kalan=0;
    $giren = $ci->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where cen_id=$cen_id and tip=1")->row()->total;
    $cikan = $ci->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where cen_id=$cen_id and tip=0")->row()->total;
    if($giren){
        $kalan = $giren-$cikan;
    }

    return array('kalan'=>amountFormat_s($kalan).' Litr','kalan_num'=>($kalan));

}
function benzin_bakiye_cen_amounth($cen_id){
    $ci =& get_instance();
    $ci->load->database();

    $kalan=0;
    $giren = $ci->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where cen_id=$cen_id and tip=1")->row()->total;
    $cikan = $ci->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where cen_id=$cen_id and tip=0")->row()->total;
    if($giren){
        $kalan = $giren-$cikan;
    }
    return amountFormat_s($kalan);

}

function demirbas_group_list($type=1){
    $ci =& get_instance();
    $ci->load->database();

    $result=false;
    $all_result=false;
    $id_array=[];
    $arac_list = $ci->db->query("SELECT * FROM demirbas_parent");
    if($arac_list->num_rows()){
        $result = $arac_list->result();
        foreach ($result as $items){

            $id_array[]=$items->parent_id;

        }

        $str =  implode(",", $id_array);
        $all_result = $ci->db->query("SELECT * FROM demirbas_group Where id Not IN  ($str) and type=$type")->result();
    }
    else {
        $all_res = $ci->db->query("SELECT * FROM demirbas_group Where type=$type");
        if($all_res->num_rows()){
            $all_result = $all_res->result();
        }
    }
    return $all_result;

}


function demirbas_group_list_who($type=1,$demirbas_id){
    $ci =& get_instance();
    $ci->load->database();

    $result=false;
    $all_result=false;
    $id_array=[];
    $arac_list = $ci->db->query("SELECT * FROM demirbas_parent");
    if($arac_list->num_rows()){
        $result = $arac_list->result();
        foreach ($result as $items){

            $id_array[]=$items->parent_id;

        }

        $str =  implode(",", $id_array);
        $all_result = $ci->db->query("SELECT * FROM demirbas_group Where id Not IN  ($str) and type=$type and demirbas_id = $demirbas_id")->result();
    }
    else {
        $all_res = $ci->db->query("SELECT * FROM demirbas_group Where type=$type and demirbas_id = $demirbas_id");
        if($all_res->num_rows()){
            $all_result = $all_res->result();
        }
    }
    return $all_result;

}


function parent_demirbas_kontrol($id){
    $ci =& get_instance();
    $ci->load->database();
    $all_result = $ci->db->query("SELECT * FROM demirbas_parent Where demirbas_group_id=$id");
    if($all_result->num_rows()){
        return true;
    }
    else {
        return  false;
    }
}
function who_demirbas($id){
    $ci =& get_instance();
    $ci->load->database();
    $all_result = $ci->db->query("SELECT * FROM demirbas_group Where id=$id");
    if($all_result->num_rows()){
        return $all_result->row();
    }
    else {
        return  false;
    }
}
function who_departmant($id){
    $ci =& get_instance();
    $ci->load->database();
    $all_result = $ci->db->query("SELECT * FROM geopos_hrm Where id=$id");
    if($all_result->num_rows()){
        return $all_result->row()->val1;
    }
    else {
        return  false;
    }
}
function demirbas_gider_total($id){
    $ci =& get_instance();
    $ci->load->database();
    $all_result = $ci->db->query("SELECT Sum(total) as totals from firma_gider Inner JOIN firma_gider_products on firma_gider.id = firma_gider_products.form_id WHERE firma_gider.demirbas_id=$id");
    if($all_result->num_rows()){
        return $all_result->row()->totals;
    }
    else {
        return  0;
    }
}
function demirbas_alt_gider_total($id){
    $ci =& get_instance();
    $ci->load->database();
    $all_result = $ci->db->query("SELECT Sum(total) as totals from firma_gider Inner JOIN firma_gider_products on firma_gider.id = firma_gider_products.form_id WHERE cost_id=$id");
    if($all_result->row()->totals){
        return $all_result->row()->totals;
    }
    else {
        $child_parent = $ci->db->query("SELECT * FROM demirbas_parent Where demirbas_group_id=$id");
        if($child_parent->num_rows()){

            $id_parent=[];
            foreach ($child_parent->result() as $items){
                $id_parent[]=$items->parent_id;
            }
            $ids =  implode(",", $id_parent);
            $all_result = $ci->db->query("SELECT Sum(total) as totals from firma_gider Inner JOIN firma_gider_products on firma_gider.id = firma_gider_products.form_id WHERE cost_id IN ($ids)");
            return $all_result->row()->totals;

        }
    }
}

function get_firma_demirbas($group_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $result = $ci->db->query("Select* From demirbas_firma Where demirbas_id=$group_id ");
    if($result->num_rows()){
        $table_name = $result->row()->table_name;
        if($table_name){
            $where='';
            if($table_name=='geopos_employees'){
                $loc=$ci->session->userdata('set_firma_id');
                $where="and loc=$loc";
            }
            $result_tables = $ci->db->query("Select * From $table_name Where demirbas_id=$group_id $where ");

            if($result_tables->num_rows()){

                $items = [];
                foreach ($result_tables->result() as $values){
                    if($table_name=="talep_form_nakliye_products"){
                        $items[]=['id'=>$values->id,'name'=>$values->code];
                    }
                    else if($table_name=="geopos_warehouse"){
                        $items[]=['id'=>$values->id,'name'=>$values->title];
                    }
                    else {
                        $items[]=['id'=>$values->id,'name'=>$values->name.' '.$values->code];
                    }

                }

                return [
                    'status'=>1,
                    'tip'=>$table_name,
                    'items'=>$items,
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Tanımlanmış İtem Bulunamadı',
                ];
            }

        }
        else {
            return [
                'status'=>0,
                'message'=>'Tanımlanmış İtem Bulunamadı',
            ];
        }

    }
    else{
        return [
            'status'=>0,
            'message'=>'Gruba Atamnmış Firma Demirbaşı Bulunamadı',
        ];
    }
}
function demirbas_html($id,$firma_demirbas_id){
    $ci =& get_instance();
    $ci->load->database();
    $all_result = $ci->db->query("SELECT * FROM demirbas_firma Where demirbas_id=$id");
    if($all_result->num_rows()){
        $table_name =  $all_result->row()->table_name;
        if($table_name=='araclar'){
            $arac_details  = $ci->db->query("SELECT * FROM araclar where id=$firma_demirbas_id")->row();

            $code=$arac_details->code;
            $plaka=$arac_details->plaka;
            $image="<image src='/userfiles/product/$arac_details->image_text' class='imge' width='400' />";
            $html  = $all_result->row()->html;

            $new_replace   =  str_replace("%code%",$code,$html);
            $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
            $new_replace   =  str_replace("%image%",$image,$new_replace);
            return  $new_replace;


        }
        elseif($table_name=='geopos_employees'){
            $arac_details  = $ci->db->query("SELECT * FROM geopos_employees where id=$firma_demirbas_id")->row();

            $code=$arac_details->id;
            $plaka=$arac_details->name;
            $image="<image src='/userfiles/employee/$arac_details->picture' class='imge' width='100' />";
            $html  = $all_result->row()->html;

            $new_replace   =  str_replace("%code%",$code,$html);
            $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
            $new_replace   =  str_replace("%image%",$image,$new_replace);
            return  $new_replace;


        }
        elseif($table_name=='printerler'){
            $arac_details  = $ci->db->query("SELECT * FROM printerler where id=$firma_demirbas_id")->row();

            $code=$arac_details->code;
            $plaka=$arac_details->name;
            $image="<image src='/userfiles/product/$arac_details->image' class='imge' width='100' />";
            $html  = $all_result->row()->html;

            $new_replace   =  str_replace("%code%",$code,$html);
            $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
            $new_replace   =  str_replace("%image%",$image,$new_replace);
            return  $new_replace;


        }
        elseif($table_name=='fatura_item'){
            $arac_details  = $ci->db->query("SELECT * FROM fatura_item where id=$firma_demirbas_id")->row();

            $code=$arac_details->code;
            $plaka=$arac_details->name;
            $image='-';
            $html  = $all_result->row()->html;

            $new_replace   =  str_replace("%code%",$code,$html);
            $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
            $new_replace   =  str_replace("%image%",$image,$new_replace);
            return  $new_replace;


        }
        elseif($table_name=='geopos_warehouse'){
            $arac_details  = $ci->db->query("SELECT * FROM geopos_warehouse where id=$firma_demirbas_id")->row();

            $code=$arac_details->id;
            $plaka=$arac_details->title;
            $image='-';
            $html  = $all_result->row()->html;

            $new_replace   =  str_replace("%code%",$code,$html);
            $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
            $new_replace   =  str_replace("%image%",$image,$new_replace);
            return  $new_replace;


        }
        elseif($table_name=='items'){
            if($firma_demirbas_id){
                $arac_details  = $ci->db->query("SELECT * FROM items where id=$firma_demirbas_id")->row();


                $code=$arac_details->code;
                $plaka=$arac_details->name;
                $image="<image src='/userfiles/product/$arac_details->image' class='imge' width='100' />";
                $html  = $all_result->row()->html;

                $new_replace   =  str_replace("%code%",$code,$html);
                $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
                $new_replace   =  str_replace("%image%",$image,$new_replace);
                return  $new_replace;
            }
            else {
                return  "";
            }



        }
        elseif($table_name=='talep_form_nakliye_products'){
            $arac_details  = $ci->db->query("SELECT * FROM talep_form_nakliye_products where id=$firma_demirbas_id")->row();

            $code=$arac_details->code;
            $plaka=arac_details($arac_details->arac_id)->name;
            $image="";
            $html  = $all_result->row()->html;

            $new_replace   =  str_replace("%id%",$arac_details->form_id,$html);
            $new_replace   =  str_replace("%code%",$code,$new_replace);
            $new_replace   =  str_replace("%plaka%",$plaka,$new_replace);
            $new_replace   =  str_replace("%image%",$image,$new_replace);
            return  $new_replace;


        }
    }
    else {
        return  false;
    }
}

function demirbas_table_to_name($table_name,$firma_demirbas_id){
    $ci =& get_instance();
    $ci->load->database();

    if($table_name=='araclar'){
        $arac_details  = $ci->db->query("SELECT * FROM araclar where id=$firma_demirbas_id")->row();

        $code=$arac_details->code;
        $plaka=$arac_details->plaka;

        return $code.' - '.$plaka;


    }
    elseif($table_name=='personel'){

        $arac_details  = $ci->db->query("SELECT * FROM geopos_employees where id=$firma_demirbas_id")->row();

        $code=$arac_details->id;
        $plaka=$arac_details->name;

        return $code.' - '.$plaka;


    }
}

function parent_locations_kontrol(){
    $ci =& get_instance();
    $ci->load->database();
    $user_id = $ci->aauth->get_user()->id;
    $loc = $ci->session->userdata('set_firma_id');
    $kontrol = $ci->db->query("SELECT * FROM locations_paralel_pers Where paralel_pers_id=$user_id and paralel_firma_id=$loc");
    if($kontrol->num_rows()){
        $firma_detaisl=[];
        foreach ($kontrol->result() as $items){
            $firma_detaisl[]=
                [
                    'firma_id'=>$items->aauth_firma_id,
                    'user_id'=>$items->aauth_id,
                    'user_name'=>personel_detailsa($items->aauth_id)['name'],
                    'firma_name'=>location($items->aauth_firma_id)['cname'],
                    ];
        }
        return $firma_detaisl;
    }
    else {
        return false;
    }
}
function parent_to_locations_kontrol(){
    $ci =& get_instance();
    $ci->load->database();
    $user_id = $ci->aauth->get_user()->id;
    $loc = $ci->session->userdata('set_firma_id');
    $kontrol = $ci->db->query("SELECT * FROM locations_paralel_pers Where aauth_id=$user_id and aauth_firma_id=$loc");
    if($kontrol->num_rows()){
        $firma_detaisl=[];
        foreach ($kontrol->result() as $items){
            $firma_detaisl[]=
                [
                    'firma_id'=>$items->paralel_firma_id,
                    'user_id'=>$items->paralel_pers_id,
                    'user_name'=>personel_detailsa($items->paralel_pers_id)['name'],
                    'firma_name'=>location($items->paralel_firma_id)['cname'],
                    ];
        }
        return $firma_detaisl;
    }
    else {
        return false;
    }

}

function pay_images($id,$text=''){
    $ci =& get_instance();
    $ci->load->database();
    $kontrol = $ci->db->query("SELECT * FROM talep_form_customer_new_payment Where form_id=$id");
    if($kontrol->num_rows()){
        $ci->db->select('SUM(total) as total');
        $ci->db->from('talep_form_customer_products_new');
        $ci->db->where('cost_id!=',0);
        $ci->db->where('form_id',$id);
        $query = $ci->db->get();
        $totals = $query->row()->total;

        $ci->db->select('SUM(total) as totals');
        $ci->db->from('talep_form_customer_new_payment');
        $ci->db->where('form_id',$id);
        $ci->db->where('tip',1);
        $querys = $ci->db->get();


        $odeme_total =  $querys->row()->totals;


        if($text==''){
            if(intval($totals)==intval($odeme_total)){
                return "<img src='/assets/images/red_new_pay.png' style='width: 70%;'>";
            }
            elseif($odeme_total) {
                return "<img src='/assets/images/green_new_pay.png' style='width: 70%;'>";
            }
            else {
                return '';
            }
        }
        else {
            if(intval($totals)==intval($odeme_total)){
                return "<img src='/assets/images/red_new_pay.png' style='width: 10%;'>";
            }
            elseif($odeme_total) {
                return "<img src='/assets/images/green_new_pay.png' style='width: 10%;'>";
            }
            else {
                return '';
            }
        }

    }
    else {
        return false;
    }
}


function pay_images_avans($id,$text=''){
    $ci =& get_instance();
    $ci->load->database();
    $kontrol = $ci->db->query("SELECT * FROM talep_form_customer_new_payment Where form_id=$id and tip=2");
    if($kontrol->num_rows()){
        $ci->db->select('SUM(total) as total');
        $ci->db->from('talep_form_customer_products');
        $ci->db->where('cost_id!=',0);
        $ci->db->where('form_id',$id);
        $query = $ci->db->get();
        $totals = $query->row()->total;

        $ci->db->select('SUM(total) as totals');
        $ci->db->from('talep_form_customer_new_payment');
        $ci->db->where('form_id',$id);
        $ci->db->where('tip',2);
        $querys = $ci->db->get();


        $odeme_total =  $querys->row()->totals;


        if($text==''){
            if(intval($totals)==intval($odeme_total)){
                return "<img src='/assets/images/red_new_pay.png' style='width: 10%;'>";
            }
            elseif($odeme_total) {
                return "<img src='/assets/images/green_new_pay.png' style='width: 10%;'>";
            }
            else {
                return '';
            }
        }
        else {
            if(intval($totals)==intval($odeme_total)){
                return "<img src='/assets/images/red_new_pay.png' style='width: 10%;'>";
            }
            elseif($odeme_total) {
                return "<img src='/assets/images/green_new_pay.png' style='width: 10%;'>";
            }
            else {
                return '';
            }
        }

    }
    else {
        return false;
    }
}

function pay_images_nakliye($id,$text=''){
    $ci =& get_instance();
    $ci->load->database();
    $kontrol = $ci->db->query("SELECT * FROM talep_form_nakliye_payment Where form_id=$id");
    if($kontrol->num_rows()){


        $array_id=[];
        $items = $ci->db->query("SELECT * FROM talep_form_nakliye_products Where form_id=$id")->result();
        foreach ($items as $item_val){
            $array_id[]=$item_val->id;
        }
        $str =  implode(",", $array_id);

        $ci->db->select('SUM(total) as total');
        $ci->db->from('talep_form_nakliye_products');
//        $ci->db->where('form_item_id!=',0);
        $ci->db->where('form_id',$id);
        $query = $ci->db->get();
        $totals = $query->row()->total;

        $ci->db->select('SUM(total) as totals');
        $ci->db->from('talep_form_nakliye_payment');
        $ci->db->where_in('form_item_id',$array_id);
        $ci->db->where('tip',1);
        $querys = $ci->db->get();


        $odeme_total =  $querys->row()->totals;


        if($text==''){
            if(intval($totals)==intval($odeme_total)){
                return "<img src='/assets/images/red_new_pay.png' style='width: 70%;'>";
            }
            elseif($odeme_total) {
                return "<img src='/assets/images/green_new_pay.png' style='width: 70%;'>";
            }
            else {
                return '';
            }
        }
        else {
            if(intval($totals)==intval($odeme_total)){
                return "<img src='/assets/images/red_new_pay.png' style='width: 10%;'>";
            }
            elseif($odeme_total) {
                return "<img src='/assets/images/green_new_pay.png' style='width: 10%;'>";
            }
            else {
                return '';
            }
        }

    }
    else {
        return false;
    }
}

function saatlik_izin_rapor ($personel_id){


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
    $ci->db->where('user_permit.user_id',$personel_id);
    $query = $ci->db->get();
    //echo $this->db->last_query();;
    $result = $query->result();

    $toplam_saat=0;
    foreach ($result as $prd){
        if($prd->toplam_saat < 4){
            $toplam_saat+=$prd->toplam_saat;
        }
    }
    return $toplam_saat;

}

function mezuniyet_report($personel_id){
    $ci =& get_instance();
    $ci->load->database();
    $toplam=0;
    $kalan=0;
    date_default_timezone_set('Asia/Baku');
    $date = new DateTime('now');
    $yil =  $date->format('Y');
    $kontrol = $ci->db->query("SELECT * FROM personel_mezuniyet Where personel_id=$personel_id and yil=$yil");
    if($kontrol->num_rows()){
        $toplam=$kontrol->row()->mezuniyet;

    }

    $bordro_item = izin_gun_kontrol($personel_id);
    $kalan=$toplam-$bordro_item;
    $kalan_text='<span class="badge-success badge">'.$kalan.'</span>';
    if($kalan < 0){
        $kalan_text='<span class="badge-danger badge">'.$kalan.'</span>';
    }

    return [
        'mezuniyet_total'=>$toplam,
        'mezuniyet_kalan'=>$kalan_text,
        'mezuniyet_kalan_number'=>$kalan,
    ];
}


function nakliye_depolar_arasi_transfer($tip){
    $ci =& get_instance();
    $ci->load->database();
    $user_id = $ci->aauth->get_user()->id;
    $loc = $ci->session->userdata('set_firma_id');
    $sayi=0;
    if($tip==1){
        $text='Maşına Mehsulları Yükləyin ';
        $title='Sizə Təyin Edilmiş Logistika Sifarişləri Yükləyin ';
    }
    elseif($tip==2){
        $text='Maşına Yüklenen Mehsülleri Deponuza Alınız ';
        $title='Sizə Təyin Edilmiş Logistika Sifarişləri İndirin ';
    }
    $table='
<div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
<h3 class="flash-button" style="text-align:center">'.$title.'</h3>
<div class="table-responsive">
<table class="table table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>Lojistik Talep No</th>
                                                  <th>Lojistik Araç Kodu</th>
                                                  <th>Araç Adı</th>
                                                  <th>Açıklama</th>
                                                  <th>İşlem</th>
                                              </tr>
                                          </thead><tbody>';

    $sql=$ci->db->query("SELECT talep_onay_nakliye.id as onay_id,talep_form_nakliye_products.id as item_id,talep_form_nakliye_products.code as item_code,CONCAT(araclar.name,araclar.plaka) as arac_name,talep_form_nakliye.code as nakliye_code,talep_onay_nakliye.nakliye_talep_transfer_item_id,
nakliye_talep_transfer_item.text_desc,nakliye_talep_transfer_item.warehouse_id

FROM talep_onay_nakliye 
INNER JOIN talep_form_nakliye_products ON talep_onay_nakliye.talep_id = talep_form_nakliye_products.form_id 
INNER JOIN talep_form_nakliye ON talep_form_nakliye_products.form_id = talep_form_nakliye.id 
INNER JOIN araclar ON talep_form_nakliye_products.arac_id=araclar.id 
INNER JOIN nakliye_talep_transfer_item ON nakliye_talep_transfer_item.id=talep_onay_nakliye.nakliye_talep_transfer_item_id 
Where talep_onay_nakliye.type=3 and nakliye_talep_transfer_item.type=$tip and talep_onay_nakliye.user_id=$user_id and talep_onay_nakliye.status is null and talep_onay_nakliye.staff=1;
");
    if($sql->num_rows()){
        foreach ($sql->result() as $prd){
            $table.='  <tr>
                          <td>'.$prd->nakliye_code.'</td>
                          <td>'.$prd->item_code.'</td>
                          <td>'.$prd->arac_name.'</td>
                           <td><span>'.$prd->text_desc.'</span></td>
                          <td><button type="button" class="btn btn-success one_nakliye_transfer"  eq="'.$sayi.'"
                            nakliye_item_id="'.$prd->item_id.'" 
                            tip="'.$tip.'" 
                            warehouse_id="'.$prd->warehouse_id.'" 
                            onay_id="'.$prd->onay_id.'" 
                            nakliye_talep_transfer_item_id="'.$prd->nakliye_talep_transfer_item_id.'">'.$text.'</button>
                            
                            <button type="button" class="btn btn-info transfer_finish"  eq="'.$sayi.'"
                            nakliye_item_id="'.$prd->item_id.'" 
                            tip="'.$tip.'" 
                            warehouse_id="'.$prd->warehouse_id.'" 
                            onay_id="'.$prd->onay_id.'" 
                            nakliye_talep_transfer_item_id="'.$prd->nakliye_talep_transfer_item_id.'"><i class="fa fa-check"></i> İşlemi Bitir</button>
                            
                            <button type="button" class="btn btn-warning transfer_arac_view"  eq="'.$sayi.'"
                            nakliye_item_id="'.$prd->item_id.'" 
                            tip="'.$tip.'" 
                            warehouse_id="'.$prd->warehouse_id.'" 
                            onay_id="'.$prd->onay_id.'" 
                            nakliye_talep_transfer_item_id="'.$prd->nakliye_talep_transfer_item_id.'"><i class="fa fa-truck"></i> Araç İçini Görüntüle</button>
                            
                            </td>
                      </tr>';
            $sayi++;
        }
        $table.='  </tbody>
                                      </table></div></div>';
    }

    if($sayi){
        return $table;
    }
    else {
        return  false;
    }

}

function lojistik_yuklemeleri($status){
    $ci =& get_instance();
    $ci->load->database();
    $user_id = $ci->aauth->get_user()->id;
    $loc = $ci->session->userdata('set_firma_id');
    $where='';
    $title='';
    $text='';
    $class='';
    if($status==13){
        $text='Maşına Sifarişləri Yükləyin ';
        $title='Sizə Təyin Edilmiş Logistika Sifarişləri Yükləyin ';
        $where='and yukleme_durum=0 and teslimat_durum=0 and talep_form_nakliye_to_mt.yukleyen_pers_id='.$user_id;
    }
    else if($status==14){
        $text='Ambarınıza Sifarişləri Gəbul Edin ';
        $title='Sizə Verilən Logistika Sifarişləri Gəbul Edin';
        $where='and teslimat_durum=0 and yukleme_durum=1 and talep_form_nakliye_to_mt.tehvil_pers_id='.$user_id;
    }
    $table='
<div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
<h3 class="flash-button" style="text-align:center">'.$title.'</h3>
<button class="btn btn-info  mb-3 add_arac_product_button'.$status.'"><i class="fa fa-plus"></i>&nbsp; Seçilmiş Məhsulları Miqdarları ilə Birlikdə '.$text.'</button>
<button class="btn btn-info  mb-3 islem_bitir_nakliye'.$status.'" status="'.$status.'"><i class="fa fa-plus"></i>&nbsp; Seçilmiş Məhsulları Bitir.</button>
<div class="table-responsive">
<table class="table table-bordered">
                                          <thead>
                                              <tr>
                                                <th><input type="checkbox" class="form-control all_lojistik_yukleme" style="width: 50px;left: 43px;position: relative;"></th></th>
                                                  <th>Lojistik Talep No</th>
                                                  <th>MT</th>
                                                  <th>Ürün</th>
                                                  <th>Miktar</th>
                                                  <th>Birim</th>
                                              </tr>
                                          </thead><tbody>';
    $sql = $ci->db->query("SELECT 
       talep_form_nakliye_products.id as item_id,
       talep_form_products.id as talep_form_product_id,
       talep_form_products.product_stock_code_id,
       talep_form_nakliye.code,
       talep_form_nakliye.id as tfn_id,
       talep_form.code as mt_code,
       talep_form_products.product_desc,
       geopos_products.product_name,
       talep_form_products.product_qty,
       talep_form_products.unit_id,
       talep_form_nakliye_products.status,
       araclar.name as arac_name
FROM talep_form_nakliye_products
Inner JOIN talep_form_nakliye_to_mt On talep_form_nakliye_products.id=talep_form_nakliye_to_mt.talep_item_id
Inner JOIN talep_form_nakliye On talep_form_nakliye_products.form_id=talep_form_nakliye.id
Inner JOIN talep_form_products On talep_form_products.form_id=talep_form_nakliye_to_mt.mt_id
Inner JOIN geopos_products On geopos_products.pid=talep_form_products.product_id
Inner JOIN talep_form On talep_form_products.form_id=talep_form.id
Inner JOIN araclar On talep_form_nakliye_products.arac_id=araclar.id
WHERE talep_form_nakliye_products.status=$status and  talep_form_nakliye.loc=$loc $where GROUP BY talep_form_products.id
");


    $sayi=0;
    if($sql->num_rows()){

        foreach ($sql->result() as $prd){
            $id_array=[];

            $toplam_alinan_qty = $ci->db->query("SElECT SUM(quantity) as total FROM talep_form_nakliye_product_arac Where m_item_id=$prd->talep_form_product_id and n_talep_id=$prd->tfn_id")->row()->total;

            $kalan=0;
            if($status==13){
                $kalan=floatval($prd->product_qty)-floatval($toplam_alinan_qty);
            }
            else if($status==14){

                $talep_form_nakliye_product_arac_id_id = $ci->db->query("SElECT id FROM talep_form_nakliye_product_arac Where m_item_id=$prd->talep_form_product_id and n_talep_id=$prd->tfn_id");

                if($talep_form_nakliye_product_arac_id_id->num_rows()){
                    foreach ($talep_form_nakliye_product_arac_id_id->result() as $item_id){
                        $id_array[]=$item_id->id;
                    }
                }

                $id_str=implode(',',$id_array);


                $toplam_giren=0;
                if(count($id_array)){
                    $toplam_giren = $ci->db->query("SELECT SUM(qty) as total FROM stock Where talep_form_nakliye_product_arac_id IN($id_str) and types=1")->row()->total;
                }


                $kalan=floatval($toplam_alinan_qty)-floatval($toplam_giren);
            }



            $varyant=talep_form_product_options_new($prd->product_stock_code_id);
            $unit_name = units_($prd->unit_id)['name'];
            $table.='  <tr>
                          <td><input type="checkbox" class="form-control one_lojistik_yukleme" eq="'.$sayi.'" nakliye_id="'.$prd->tfn_id.'"   nakliye_item_id="'.$prd->item_id.'" talep_form_product_id="'.$prd->talep_form_product_id.'"></td>
                          <td>'.$prd->code.'</td>
                          <td>'.$prd->mt_code.'</td>
                          <td>'.$prd->product_name.'<span class="text-muted">'.$varyant.'</span></td>
                          <td><input type="number" class="form-control item_qty_values"  value="'.$kalan.'" max="'.$kalan.'" onkeyup="amount_max(this)"></td>
                          <td><span>'.$unit_name.'</span></td>
                      </tr>';
            $sayi++;
        }
        $table.='  </tbody>
                                      </table></div></div>';
    }
    if($sayi){
        return $table;
    }
    else {
        return  false;
    }

}

function izinli_personeller(){
    $ci =& get_instance();
    $ci->load->database();
    $sayi=0;
    $table='<table class="table table-bordered">
                                          <thead>
                                              <tr>
                                                    <th class="text-danger">İzinli Personeller</th>
                                                  <th>Personel</th>
                                                  <th>Proje</th>
                                                  <th>Pozisyon</th>
                                                  <th>Başlangıç Tarihi</th>
                                                  <th>Bitiş Tarihi</th>
                                              </tr>
                                          </thead><tbody>';


    $date = new DateTime('now');
    $date_now_start =  $date->format('Y-m-d 08:00:00');
    $date_now_start_end =  $date->format('Y-m-d 23:59:00');
    $date_now =  $date->format('Y-m-d H:i:s');


    $sql_new = $ci->db->query('SELECT * FROM `user_permit` WHERE (`end_date` >=  "'.$date_now_start_end.'" AND `start_date` <= "'.$date_now_start.'") and status=1');



    //$whre='AND DATE(user_permit.end_date) >="'.$date_now.'"'; //2019-11-23 14:28:57
//    $whre='and (user_permit.end_date NOT BETWEEN "'.$date_now_start.'" and "'.$date_now_start_end.'")'; //2019-11-23 14:28:57
//    //$whre.=' AND DATE(user_permit.start_date) <="'.$date_now_start.'"';  //2019-11-24 14:28:57
//
//    $whre.='and (user_permit.start_date BETWEEN "'.$date_now_start.'" and "'.$date_now_start_end.'")';  //2019-11-24 14:28:57
//    $cart_kontrol = $ci->db->query("SELECT * FROM user_permit WHERE  status=1 $whre");

    $cart_kontrol = $sql_new;


//
//    SELECT * FROM user_permit WHERE status=1 and
//
//    (user_permit.end_date NOT BETWEEN "2024-02-20 08:00:00" and "2024-02-20 18:00:00")
//
//                            and
//    (user_permit.start_date BETWEEN "2024-02-20 08:00:00" and "2024-02-20 23:59:00")



   //echo "SELECT * FROM user_permit WHERE  status=1 $whre";die();

    if($cart_kontrol->num_rows()){
        foreach ($cart_kontrol->result() as $prd){
            $aktif_personel_kontrol =personel_detailsa($prd->user_id)['banned'];
            if($aktif_personel_kontrol==0){


                $proje_id = $ci->db->query("SELECT * FROM personel_salary WHERE  status=1  and personel_id=$prd->user_id")->row()->proje_id;
                $proje_name = proje_name($proje_id);
                $role_id=personel_detailsa($prd->user_id)['roleid'];

                $sayi++;
                $table.='  <tr style="background: red;color:white">
                          <td>'.$sayi.'</td>
                          <td>'.personel_details_full($prd->user_id)['name'].'</td>
                          <td>'.$proje_name.'</td>
                          <td>'.roles($role_id).'</td>
                          <td>'.$prd->start_date.'</td>
                          <td>'.$prd->end_date.'</td>
                      </tr>';
            }


        }
        $table.='  </tbody>
                                      </table>';
    }


    if($sayi){
        return $table;
    }
    else {
        return  false;
    }



}
function personel_cart_gecikmis(){
    $ci =& get_instance();
    $ci->load->database();
    $sayi=0;
    $table='<table class="table table-bordered">
                                          <thead>
                                              <tr>
                                                    <th class="text-danger">Sipariş Vakti Gelmiş Kartlar</th>
                                                  <th>Personel</th>
                                                  <th>Kalan Süre</th>
                                              </tr>
                                          </thead><tbody>';
    foreach (all_personel() as $prd){
        $cart_kontrol = $ci->db->query("SELECT * FROM personel_cart WHERE pers_id=$prd->id and status=1");
        if($cart_kontrol->num_rows()){
            $date = new DateTime('now');
            $yil =  $date->format('Y');
            $m =  $date->format('m');
            $cart_yil=$cart_kontrol->row()->skt_yil;
            $cart_ay=$cart_kontrol->row()->skt_ay;

            if($cart_yil <= $yil){
                $kalan=intval($cart_ay)-intval($m);

                if($kalan <= 1){
                    $sayi++;
                    $table.='  <tr style="background: red;color:white">
                                                  <td>'.$sayi.'</td>
                                                  <td>'.$prd->name.'</td>
                                                  <td>Maaş Kartının 1 Ay veya Daha Az Bir Süre Kalmıştır</td>
                                              </tr>';
                }
            }
        }
    }
    $table.='  </tbody>
                                      </table>';

    if($sayi){
        return $table;
    }
    else {
        return  false;
    }



}

function user_hizmet_tamamlama(){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $arrays=false;
    $table = $ci->db->query("SELECT `talep_form_customer_new`.*, `geopos_employees`.`name` as `pers_name`,
       `progress_status`.`name` as `progress_name`, `talep_form_status`.`color` as `color`,
       `geopos_projects`.`code` as `proje_name`, `talep_form_status`.`name` as `st_name`, 
       `geopos_customers`.`company` FROM `talep_form_customer_new` JOIN
           `geopos_employees` ON `talep_form_customer_new`.`talep_eden_user_id`=`geopos_employees`.`id` LEFT 
               JOIN `progress_status` ON `talep_form_customer_new`.`progress_status_id`=`progress_status`.`id` JOIN 
           `geopos_projects` ON `talep_form_customer_new`.`proje_id`=`geopos_projects`.`id` JOIN `talep_form_status`
               ON `talep_form_customer_new`.`status`=`talep_form_status`.`id` LEFT JOIN `geopos_customers` 
                   ON `talep_form_customer_new`.`cari_id`=`geopos_customers`.`id` WHERE `talep_form_customer_new`.`type` = 1 
        AND `talep_form_customer_new`.`loc` = '$loc' AND `talep_form_customer_new`.`talep_eden_user_id` = '$user_id' AND 
    `talep_form_customer_new`.`alacak_durum` = 0 AND `talep_form_customer_new`.`status` = 9");
    if($table->num_rows()){
        $arrays = $table->result();
    }
    return $arrays;
}
function hizmet_tutar_getir($id){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT SUM(total) as totals FROM talep_form_customer_new_payment Where form_id=$id and cach_personel=$user_id");
    if($table->row()->totals){
        return amountFormat($table->row()->totals);
    }
    else {
        $ci->db->select('SUM(total) as total');
        $ci->db->from('talep_form_customer_products_new');
        $ci->db->where('cost_id!=',0);
        $ci->db->where('form_id',$id);
        $query = $ci->db->get();
        return amountFormat($query->row()->total);
    }

}
function all_mt_list(){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM talep_form Where loc=$loc and status NOT IN(9,10,13)");
    if($table->row()){
        return $table->result();
    }

}

function move_product($id){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM talep_form_products Where move_talep_id=$id");
    if($table->row()){
        return $table->result();
    }
    else{
        return false;
    }

}

function move_kontrol($id){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM talep_form_products Where id=$id and move_talep_id");
    if($table->row()){
        $talep_id=$table->row()->move_talep_id;
        return  "<a class='btn btn-outline-success' target='_blank' href='/malzemetalep/view/$talep_id'>Taşınmış Ürün</a>";
    }
    else{
        return false;
    }

}
function lojistik_talep_mt_list($talep_id){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $text='';
    $table = $ci->db->query("SELECT talep_form.* FROM talep_form_nakliye_to_mt INNER JOIN talep_form ON talep_form_nakliye_to_mt.mt_id = talep_form.id Where talep_form_nakliye_to_mt.talep_item_id=$talep_id");
    if($table->row()){
       foreach ($table->result() as $items){
           $text.='<span style="cursor: pointer;" class="badge badge-success mt_view" mt_id="'.$items->id.'">'.$items->code.'</span><br>';
       }
    }
    else {
        $text='MT SEÇİLMEMİŞ!';
    }

    return $text;


}

function nakliye_arac_yukleme_kontrol($n_item_id){
    $ci =& get_instance();
    $ci->load->database();
    $table = $ci->db->query("SELECT * FROM talep_form_nakliye_product_arac  Where n_item_id=$n_item_id");
    if($table->num_rows()){
        return true;
    }
    else {
        return false;
    }

}
function mt_nakliye($talep_id){
    $ci =& get_instance();
    $ci->load->database();
    $loc = $ci->session->userdata('set_firma_id');
    $user_id = $ci->aauth->get_user()->id;
    $data=[];
    $table = $ci->db->query("SELECT talep_form_nakliye.* FROM talep_form_nakliye_to_mt INNER JOIN talep_form_nakliye ON talep_form_nakliye_to_mt.talep_id = talep_form_nakliye.id Where talep_form_nakliye_to_mt.mt_id=$talep_id GROUP BY talep_form_nakliye_to_mt.talep_id");
    if($table->row()){
       foreach ($table->result() as $items){

           $data[]=[
               'text'=>'<a href="/nakliye/view/'.$items->id.'" target="_blank" style="cursor: pointer;font-size: 15px;" class="badge badge-info mt_view" mt_id="'.$items->id.'">'.$items->code.'</a><br>',
               'details'=>$items
           ];

       }
    }
    return $data;


}


function son_mesaj_detaylari($user_id){
    $ci =& get_instance();
    $ci->load->database();
    $user_id_ = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM mk_chat Where (auth_id=$user_id_ and user_id=$user_id) UNION 
SELECT * FROM mk_chat Where (user_id=$user_id_ and auth_id=$user_id) 

Order BY id Desc LIMIT 1");
    if($table->num_rows()){
        return $table->row();
    }
}
function son_mesaj_detaylari_auth($user_id){
    $ci =& get_instance();
    $ci->load->database();
    $user_id_ = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM mk_chat Where (user_id=$user_id_ and auth_id=$user_id) Order BY id Desc LIMIT 1");
    if($table->num_rows()){
        return $table->row();
    }
}
function all_messages($user_id){
    $ci =& get_instance();
    $ci->load->database();
    $user_id_ = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM mk_chat Where (auth_id=$user_id_ and user_id=$user_id) or (auth_id=$user_id and user_id=$user_id_) Order BY id ASC");
    if($table->num_rows()){
        return $table->result();
    }
}

function all_messages_auth($user_id_){
    $ci =& get_instance();
    $ci->load->database();
    $user_id = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM mk_chat Where (auth_id=$user_id_ and user_id=$user_id) or (auth_id=$user_id and user_id=$user_id_) Order BY id ASC");
    if($table->num_rows()){
        return $table->result();
    }
}
function mesaj_durumu($user_id){
    $ci =& get_instance();
    $ci->load->database();
    $user_id_ = $ci->aauth->get_user()->id;
    $table = $ci->db->query("SELECT * FROM mk_chat Where auth_id=$user_id and user_id=$user_id_ and visable=0 Order BY id ASC");
    if($table->num_rows()){
        return $table->num_rows();
    }
    else {
        return  0;
    }
}


function parent_info($product_stock_code_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $varyant_html='';
    if($product_stock_code_id){
        $code = $ci->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id")->row()->code;

        $ci->db->select('*');
        $ci->db->from('geopos_products_parent');
        $ci->db->where('product_stock_code_id', $product_stock_code_id);
        $query = $ci->db->get();
        $details_items =$query->result();

        $sql = $ci->db->query("SELECT product_options.name as varyant_name,product_option_value.name as deger FROm product_to_options_value
      INNER JOIN product_option_value ON product_to_options_value.option_value_id = product_option_value.id
INNER JOIN product_options ON product_options.id = product_option_value.product_option_id
         Where product_to_options_value.product_stock_code=$product_stock_code_id")->result();
        $varyant_html='<table class="table-bordered table" style="font-size: 10px;color: gray;">';
        foreach ($sql as $items){
            $varyant_html.=
                '<tr><th>'.$items->varyant_name.'</th>
<th>'.$items->deger.'</th>
                    </tr>';
        }
        $varyant_html.='</table>';
    }



    return $varyant_html;
}

function cari_yoklama_detalis($cari_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $details_yoklama = [];
    $inceleme_status = false;

    $details_akt = [];
    $akt_status = false;

    $kontrol = $ci->db->query("SELECT * FROM cari_yoklama Where cari_id= $cari_id and type=1");
    if($kontrol->num_rows()){
        foreach ($kontrol->result() as $items){
            $details_yoklama[]=[
                'pers_id'=>$items->pers_id,
                'yoklama_status'=>'İncelendi',
                'desc'=>$items->desc,
                'created_at'=>$items->created_at,
            ];
        }
    }
    if($details_yoklama){
        $inceleme_status = true;
    }

    $kontrol_akt = $ci->db->query("SELECT * FROM cari_yoklama Where cari_id= $cari_id and type=2");
    if($kontrol_akt->num_rows()){
        foreach ($kontrol_akt->result() as $items){
            $details_akt[]=[
                'pers_id'=>$items->pers_id,
                'yoklama_status'=>'İncelendi',
                'desc'=>$items->desc,
                'created_at'=>$items->created_at,
            ];
        }
    }

    if($details_akt){
        $akt_status = true;
    }



    return array(
        'inceleme_details'=>$details_yoklama,
        'inceleme_status'=>$inceleme_status,

        'details_akt'=>$details_akt,
        'akt_status'=>$akt_status,
    );
}


