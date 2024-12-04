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

function razilastirma_status($id)

{

    $ci = &get_instance();
    $ci->load->database();
        $result = $ci->db->query("SELECT * FROM razilastirma_status WHERE id=$id");
        if($result->num_rows())
        {
            return $result->row();
        }
        else {
            return false;
        }

}
function invoice_durumu_forma2_who($id)

{

    $ci = &get_instance();
    $ci->load->database();
        $result = $ci->db->query("SELECT * FROM invoice_durumu_forma2 WHERE id=$id");
        if($result->num_rows())
        {
            return $result->row();
        }
        else {
            return false;
        }

}

function invoice_durumu_forma2()
{

    $ci = &get_instance();
    $ci->load->database();
        $result = $ci->db->query("SELECT * FROM invoice_durumu_forma2");
        if($result->num_rows())
        {
            return $result->result();
        }

}
function new_list_note($id,$islem_id)
{

    $ci = &get_instance();
    $ci->load->database();
        $result = $ci->db->query("SELECT form_all_notes.*,geopos_employees.name FROM form_all_notes INNER JOIN geopos_employees ON form_all_notes.user_id = geopos_employees.id Where islem_tipi=$id and islem_id=$islem_id");
        if($result->num_rows())
        {
            return $result->result();
        }


}
function _ust_kategori_kontrol($id) //7
{

    $ci = &get_instance();
    $ci->load->database();
    $name='';
    $name_son='';
    $name_2='';
    $name_3='';
    $name_4='';
    $name_5='';
    $name_6='';
    $name_7='';
    $name_8='';
    $name_9='';
    $name_10='';
        $result = $ci->db->query("SELECT * FROM geopos_product_cat Where id = $id");
        if($result->num_rows())
        {
            if($result->row()->parent_id){
                $p_id=$result->row()->parent_id;
                $new_result = $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id");

                if($new_result->num_rows())
                {
                    $name_2=$new_result->row()->title.' -> ';

                    if($new_result->row()->parent_id){
                        $p_id2=$new_result->row()->parent_id;
                        $new_result2= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id2");
                        if($new_result2->num_rows()){
                            $name_3=$new_result2->row()->title.' -> ';
                            if($new_result2->row()->parent_id){
                                $p_id3=$new_result2->row()->parent_id;
                                $new_result3= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id3");
                                $name_4= $new_result3->row()->title.' -> ';

                                if($new_result3->row()->parent_id){
                                    $p_id4=$new_result3->row()->parent_id;
                                    $new_result4= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id4");
                                    $name_5= $new_result4->row()->title.' -> ';

                                    if($new_result4->row()->parent_id){
                                        $p_id5=$new_result4->row()->parent_id;
                                        $new_result5= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id5");
                                        $name_6= $new_result5->row()->title.' -> ';

                                        if($new_result5->row()->parent_id){
                                            $p_id6=$new_result5->row()->parent_id;
                                            $new_result6= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id6");
                                            $name_son= $new_result6->row()->title.' -> ';

                                            if($new_result6->row()->parent_id){
                                                $p_id7=$new_result6->row()->parent_id;
                                                $new_result7= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id7");
                                                $name_7= $new_result7->row()->title.' -> ';

                                                if($new_result7->row()->parent_id){
                                                    $p_id8=$new_result7->row()->parent_id;
                                                    $new_result8= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id8");
                                                    $name_8= $new_result8->row()->title.' -> ';

                                                    if($new_result8->row()->parent_id){
                                                        $p_id9=$new_result8->row()->parent_id;
                                                        $new_result9= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id9");
                                                        $name_9= $new_result9->row()->title.' -> ';

                                                        if($new_result9->row()->parent_id){
                                                            $p_id10=$new_result9->row()->parent_id;
                                                            $new_result10= $ci->db->query("SELECT * FROM geopos_product_cat Where id = $p_id10");
                                                            $name_10= $new_result10->row()->title.' -> ';
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                    }

                                }

                            }
                        }



                    }
                    else {
                        $name = '  ->  '.$new_result->row()->title;
                    }

                }
            }
            else  {
                $name.'->';
            }
        }
        $name = $name_10.$name_9.$name_8.$name_7.$name_son.$name_6.$name_5.$name_4.$name_3.$name_2;

        return $name;

}

function _ust_asama_kontrol($id) //7
{

    $ci = &get_instance();
    $ci->load->database();
    $name='';
    $name_son='';
    $name_2='';
    $name_3='';
    $name_4='';
    $name_5='';
    $name_6='';
    $name_7='';
    $name_8='';
    $name_9='';
    $name_10='';
    $result = $ci->db->query("SELECT * FROM geopos_milestones Where id = $id");
    if($result->num_rows())
    {
        if($result->row()->parent_id){
            $p_id=$result->row()->parent_id;
            $new_result = $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id");

            if($new_result->num_rows())
            {
                $name_2=$new_result->row()->name.' -> ';

                if($new_result->row()->parent_id){
                    $p_id2=$new_result->row()->parent_id;
                    $new_result2= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id2");
                    $name_3=$new_result2->row()->name.' -> ';

                    if($new_result2->row()->parent_id){
                        $p_id3=$new_result2->row()->parent_id;
                        $new_result3= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id3");
                        $name_4= $new_result3->row()->name.' -> ';

                        if($new_result3->row()->parent_id){
                            $p_id4=$new_result3->row()->parent_id;
                            $new_result4= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id4");
                            $name_5= $new_result4->row()->name.' -> ';

                            if($new_result4->row()->parent_id){
                                $p_id5=$new_result4->row()->parent_id;
                                $new_result5= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id5");
                                $name_6= $new_result5->row()->name.' -> ';

                                if($new_result5->row()->parent_id){
                                    $p_id6=$new_result5->row()->parent_id;
                                    $new_result6= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id6");
                                    $name_son= $new_result6->row()->name.' -> ';

                                    if($new_result6->row()->parent_id){
                                        $p_id7=$new_result6->row()->parent_id;
                                        $new_result7= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id7");
                                        $name_7= $new_result7->row()->name.' -> ';

                                        if($new_result7->row()->parent_id){
                                            $p_id8=$new_result7->row()->parent_id;
                                            $new_result8= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id8");
                                            $name_8= $new_result8->row()->name.' -> ';

                                            if($new_result8->row()->parent_id){
                                                $p_id9=$new_result8->row()->parent_id;
                                                $new_result9= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id9");
                                                $name_9= $new_result9->row()->name.' -> ';

                                                if($new_result9->row()->parent_id){
                                                    $p_id10=$new_result9->row()->parent_id;
                                                    $new_result10= $ci->db->query("SELECT * FROM geopos_milestones Where id = $p_id10");
                                                    $name_10= $new_result10->row()->name.' -> ';
                                                }
                                            }
                                        }

                                    }
                                }
                            }

                        }

                    }
                }
                else {
                    $name = '  ->  '.$new_result->row()->name;
                }

            }
        }
        else  {
            $name.'->';
        }
    }
    $name = $name_10.$name_9.$name_8.$name_7.$name_son.$name_6.$name_5.$name_4.$name_3.$name_2;

    return $name;

}


function _ust_kategori_kontrol_return_array($id) //7
{

    $ci = &get_instance();
    $ci->load->database();
    $name='';
    $name_son='';
    $name_2='';
    $name_3='';
    $name_4='';
    $name_5='';
    $name_6='';
    $name_7='';
    $name_8='';
    $name_9='';
    $name_10='';

    $arrays[] = $id;
    $result = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $id");
    if($result->num_rows())
    {
        foreach ($result->result() as $items){
            $arrays[] = $items->id;
            $result2 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items->id");
                if($result2->num_rows())
                {
                    foreach ($result2->result() as $items2){
                        $arrays[] = $items2->id;
                        $result3 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items2->id");
                        if($result3->num_rows())
                        {
                            foreach ($result2->result() as $items3){
                                $arrays[] = $items3->id;
                                $result4 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items3->id");
                                if($result4->num_rows())
                                {
                                    foreach ($result4->result() as $items4){
                                        $arrays[] = $items4->id;
                                        $result5 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items4->id");
                                        if($result5->num_rows())
                                        {
                                            foreach ($result5->result() as $items5){
                                                $arrays[] = $items5->id;
                                                $result6 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items5->id");
                                                if($result6->num_rows())
                                                {
                                                    foreach ($result6->result() as $items6){
                                                        $arrays[] = $items6->id;
                                                        $result7 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items6->id");
                                                        if($result7->num_rows())
                                                        {
                                                            foreach ($result7->result() as $items7){
                                                                $arrays[] = $items7->id;
                                                                $result8 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items7->id");
                                                                if($result8->num_rows())
                                                                {
                                                                    foreach ($result8->result() as $items8){
                                                                        $arrays[] = $items8->id;

                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
    }



    $uniq = array_unique($arrays);
    return $uniq;

}

function _ust_kategori_kontrol_return_array_tek($id) //7
{

    $ci = &get_instance();
    $ci->load->database();
    $name='';
    $name_son='';
    $name_2='';
    $name_3='';
    $name_4='';
    $name_5='';
    $name_6='';
    $name_7='';
    $name_8='';
    $name_9='';
    $name_10='';

    $arrays = $id;
    $result = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $id");
    if($result->num_rows())
    {
        foreach ($result->result() as $items){
            $arrays = $items->id;
            $result2 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items->id");
            if($result2->num_rows())
            {
                foreach ($result2->result() as $items2){
                    $arrays  = $items2->id;
                    $result3 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items2->id");
                    if($result3->num_rows())
                    {
                        foreach ($result2->result() as $items3){
                            $arrays  = $items3->id;
                            $result4 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items3->id");
                            if($result4->num_rows())
                            {
                                foreach ($result4->result() as $items4){
                                    $arrays  = $items4->id;
                                    $result5 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items4->id");
                                    if($result5->num_rows())
                                    {
                                        foreach ($result5->result() as $items5){
                                            $arrays  = $items5->id;
                                            $result6 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items5->id");
                                            if($result6->num_rows())
                                            {
                                                foreach ($result6->result() as $items6){
                                                    $arrays  = $items6->id;
                                                    $result7 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items6->id");
                                                    if($result7->num_rows())
                                                    {
                                                        foreach ($result7->result() as $items7){
                                                            $arrays  = $items7->id;
                                                            $result8 = $ci->db->query("SELECT * FROM geopos_product_cat Where parent_id = $items7->id");
                                                            if($result8->num_rows())
                                                            {
                                                                foreach ($result8->result() as $items8){
                                                                    $arrays[] = $items8->id;

                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $arrays;

}



function nakliye_cari_list($id)
{

    $ci = &get_instance();
    $ci->load->database();
    $name=false;
    $result = $ci->db->query("SELECT * FROM talep_form_nakliye_products Where form_id = $id");
    if($result->num_rows())
    {

        $name = $result->result();
    }

    return $name;

}

function nakliye_cari_list_qaime($id)
{

    $ci = &get_instance();
    $ci->load->database();
    $name=false;
    $result = $ci->db->query("SELECT * FROM talep_form_nakliye_products Where form_id = $id GROUP BY cari_id");
    if($result->num_rows())
    {

        $name = $result->result();
    }

    return $name;

}

function nakliye_giderleri($id)
{

    $ci = &get_instance();
    $ci->load->database();
    $name=false;
    $result = $ci->db->query("SELECT * FROM talep_form_nakliye_products Where form_id = $id");
    if($result->num_rows())
    {
        $details=[];
        $demirbas_id = 683; // Lojistik giderleri ID
        foreach ($result->result() as $items){
            $item_id = $items->id;
            $item_gider = $ci->db->query("SELECT 
        talep_form_customer_products_new.product_desc,
       talep_form_customer_new.*,
       talep_form_customer_products_new.cost_id,talep_form_customer_products_new.price,talep_form_customer_products_new.unit_id,
       talep_form_customer_products_new.total,talep_form_customer_products_new.product_qty as qty  FROM talep_form_customer_new 
           INNER JOIN talep_form_customer_products_new ON talep_form_customer_new.id=talep_form_customer_products_new.form_id
                   Where talep_form_customer_new.type=1 and talep_form_customer_new.firma_demirbas_id = $item_id
                 and talep_form_customer_new.demirbas_id=$demirbas_id");
            if($item_gider->num_rows()){
                foreach ($item_gider->result() as $item_gider){
                    $odeme_durum = 'Bekliyor';

                    if($item_gider->odeme_durum){
                        $odeme_durum='Ödendi';
                    }
                    $details[]=[
                        'code'=>$items->code,
                        'gider_code'=>$item_gider->code,
                        'gider_id'=>$item_gider->id,
                        'gider_talep_eden_personel'=>personel_details_full($item_gider->talep_eden_user_id)['name'],
                        'gider_odeme_durumu'=>$odeme_durum,
                        'gider_demirbas_id'=>who_demirbas($item_gider->cost_id)->name.' | '.$item_gider->product_desc,
                        'gider_cari'=>customer_details($item_gider->cari_id)['company'],
                        'gider_birim_fiyati'=>amountFormat($item_gider->price),
                        'gider_miktar'=>amountFormat_s($item_gider->qty).' '.units_($item_gider->unit_id)['name'],
                        'gider_total'=>amountFormat($item_gider->total),
                        'gider_total_net'=>$item_gider->total,
                        'odeme_metodu'=>account_type_sorgu($item_gider->method),
                    ];
                }

            }
        }
        if(count($details)){
            return $details;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }

}

function nakliye_cezalari($id)
{

    $ci = &get_instance();
    $ci->load->database();
    $name=false;
    $result = $ci->db->query("SELECT * FROM talep_form_nakliye_products Where form_id = $id");
    if($result->num_rows())
    {
        $details=[];
        $demirbas_id = 683; // Lojistik giderleri ID
        foreach ($result->result() as $items){
            $item_id = $items->id;
            $item_gider = $ci->db->query("SELECT talep_form_customer_products_new.product_desc,talep_form_customer_new.*,talep_form_customer_products_new.cost_id,talep_form_customer_products_new.price,talep_form_customer_products_new.unit_id,talep_form_customer_products_new.total,talep_form_customer_products_new.product_qty as qty  FROM talep_form_customer_new
INNER JOIN talep_form_customer_products_new ON talep_form_customer_new.id=talep_form_customer_products_new.form_id 
Where talep_form_customer_new.type=3 and talep_form_customer_new.firma_demirbas_id = $item_id and
      talep_form_customer_new.demirbas_id=$demirbas_id");
            if($item_gider->num_rows()){
                foreach ($item_gider->result() as $item_gider){
                    $odeme_durum = 'Bekliyor';
                    if(!$item_gider->odeme_durum){
                        $odeme_durum='Borçlandırıldı';
                    }
                    $details[]=[
                        'code'=>$items->code,
                        'gider_code'=>$item_gider->code,
                        'gider_talep_eden_personel'=>personel_details_full($item_gider->talep_eden_user_id)['name'],
                        'gider_odeme_durumu'=>$odeme_durum,
                        'gider_demirbas_id'=>who_demirbas($item_gider->cost_id)->name.' | '.$item_gider->product_desc,
                        'gider_cari'=>customer_details($item_gider->cari_id)['company'],
                        'gider_birim_fiyati'=>amountFormat($item_gider->price),
                        'gider_miktar'=>amountFormat_s($item_gider->qty).' '.units_($item_gider->unit_id)['name'],
                        'gider_total'=>amountFormat($item_gider->total),
                        'gider_total_net'=>$item_gider->total,
                        'odeme_metodu'=>account_type_sorgu($item_gider->method),
                    ];
                }

            }
        }
        if(count($details)){
            return $details;
        }
        else {
            return false;
        }
    }
    else {
        return false;
    }

}


function time_to_date_format($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format('Y-m-d');
    return $date;
}
function isEmptyFunction($value,$val) {
     $deger =  ($value == null || $value == '' || (gettype($value) === "string" && strlen($value) === 0));
        if($deger){
            return $val;
        }
        else {

            return $value;
        }
    }

function product_onay_kontrol($product_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $values=0;
    $result = $ci->db->query("SELECT * FROM geopos_products Where pid = $product_id");
    if($result->num_rows())
    {
        $values = $result->row()->onay_durumu;
    }
    return $values;
}
function talep_borclandirma($islem_id,$islem_tipi)
{
    $ci = &get_instance();
    $ci->load->database();
    $values=0;
    $result = $ci->db->query("SELECT * FROM talep_borclandirma Where islem_id = $islem_id and islem_tipi=$islem_tipi");
    if($result->num_rows())
    {
        $data=[];
        foreach ($result->result() as $items){

            $durum_s='';
            if($items->durum==1){
                $durum_s="Onaylandı";
            }
            elseif($items->durum==2){
                $durum_s="İptal Edildi";
            }
            else {
                $durum_s="Onay Bekliyor | ".personel_detailsa($items->staff_id)['name'];
            }
            $cari_pers=personel_detailsa($items->payer_id)['name'];
            $tip='Personel';
            if($items->cari_pers_id==1){
                $cari_pers=customer_details($items->payer_id)['company'];
                $tip="CARİ";
            }

            $data[]=[
                'personel'=>personel_detailsa($items->auth_id)['name'],
                'tutar'=>amountFormat($items->tutar),
                'desc'=>$items->desc,
                'cari_pers'=>$cari_pers,
                'tip'=>$tip,
                'durum'=>$durum_s,
                'id'=>$items->id,
                'created_at'=>$items->created_at,
            ];
        }
        return $data;
    }
    else {
        return false;
    }
}
function teklif_onay_list_insert($talep_form_teklifler_item_details_id,$warehouse_id,$type,$user_id,$form_id,$product_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $data_insert = [
        'talep_form_teklifler_item_details_id'=>$talep_form_teklifler_item_details_id,
        'warehouse_id'=>$warehouse_id,
        'type'=>$type,
        'user_id'=>$user_id,
        'form_id'=>$form_id,
        'product_id'=>$product_id
    ];
   if($ci->db->insert('teklif_onay_list', $data_insert)){
       return 1;
   }
   else {
       return 0;
   }
}

function ozet_totals($tip)
{
    $ci = &get_instance();
    $ci->load->database();
    $span_b="";
    $span_n="";
    $span_t="";

    if($tip==1) // forma2 ödeme toplamı
    {
        $nakit = 0;
        $banka = 0;
        $result = $ci->db->query("SELECT geopos_invoices.subtotal FROM geopos_invoices INNER JOIN forma_2_to_muqavele ON geopos_invoices.id = forma_2_to_muqavele.forma_2_id INNER JOIN cari_razilastirma ON forma_2_to_muqavele.muqavele_id=cari_razilastirma.id WHERE geopos_invoices.status=18 and geopos_invoices.invoice_type_id=29 and geopos_invoices.subtotal > 0 and cari_razilastirma.odeme_sekli=1 GROUP BY geopos_invoices.id"); //nakit Forma2
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $nakit+= $items->subtotal;
            }
        }

        $result_banka = $ci->db->query("SELECT geopos_invoices.subtotal FROM geopos_invoices INNER JOIN forma_2_to_muqavele ON geopos_invoices.id = forma_2_to_muqavele.forma_2_id INNER JOIN cari_razilastirma ON forma_2_to_muqavele.muqavele_id=cari_razilastirma.id WHERE geopos_invoices.status=18 and geopos_invoices.invoice_type_id=29 and geopos_invoices.subtotal > 0 and cari_razilastirma.odeme_sekli=3 GROUP BY geopos_invoices.id;"); //Banka Forma2
        if($result_banka->num_rows()){
            foreach ($result_banka->result() as $items_bank){
                $banka+= $items_bank->subtotal;
            }
        }


        $toplam=floatval($banka)+floatval($nakit);
        if($toplam > 0){
            $span_t = "bold_sonuc";
        }
        if($banka > 0){
            $span_b = "bold_sonuc";
        }
        if($nakit > 0){
            $span_n = "bold_sonuc";
        }

        return array(
            'nakit'=>$nakit,
            'banka'=>$banka,
            'toplam'=>$toplam,
            'span_n'=>$span_n,
            'span_b'=>$span_b,
            'span_t'=>$span_t,
        );

    }
    elseif($tip==3) // Personel Gider
    {
        $nakit = 0;
        $banka = 0;
        $result = $ci->db->query("SELECT  SUM(talep_form_personel_products.total) as total  FROM talep_form_personel_products INNER JOIN talep_form_personel ON talep_form_personel_products.form_id= talep_form_personel.id
Where talep_form_personel.method=1 and talep_form_personel.status=12 and talep_form_personel.tip=1 GROUP BY talep_form_personel_products.form_id"); //nakit Personel Gider
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $nakit+= $items->subtotal;
            }

        }

        $result_banka = $ci->db->query("SELECT  SUM(talep_form_personel_products.total) as total  FROM talep_form_personel_products INNER JOIN talep_form_personel ON talep_form_personel_products.form_id= talep_form_personel.id
Where talep_form_personel.method=3 and talep_form_personel.status=12 and talep_form_personel.tip=1 GROUP BY talep_form_personel_products.form_id"); //Banka Personel Gider
        if($result_banka->num_rows()){
            foreach ($result_banka->result() as $items_bank){
                $banka+= $items_bank->subtotal;
            }
        }



        if($banka > 0){
            $span_b = "bold_sonuc";
        }
        if($nakit > 0){
            $span_n = "bold_sonuc";
        }
        $toplam=floatval($banka)+floatval($nakit);
        if($toplam > 0){
            $span_t = "bold_sonuc";
        }

        return array(
            'nakit'=>$nakit,
            'banka'=>$banka,
            'toplam'=>$toplam,
            'span_n'=>$span_n,
            'span_b'=>$span_b,
            'span_t'=>$span_t,
        );

    }
    elseif($tip==4) // Personel Avans
    {
        $nakit = 0;
        $banka = 0;
        $result = $ci->db->query("SELECT  SUM(talep_form_personel_products.total) as subtotal  FROM talep_form_personel_products INNER JOIN talep_form_personel ON talep_form_personel_products.form_id= talep_form_personel.id
Where talep_form_personel.method=1 and talep_form_personel.status=12 and talep_form_personel.tip=2 GROUP BY talep_form_personel_products.form_id"); //nakit Personel Gider
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $nakit+= $items->subtotal;
            }

        }

        $result_banka = $ci->db->query("SELECT  SUM(talep_form_personel_products.total) as subtotal  FROM talep_form_personel_products INNER JOIN talep_form_personel ON talep_form_personel_products.form_id= talep_form_personel.id
Where talep_form_personel.method=3 and talep_form_personel.status=12 and talep_form_personel.tip=2 GROUP BY talep_form_personel_products.form_id"); //Banka Personel Gider
        if($result_banka->num_rows()){
            foreach ($result_banka->result() as $items_bank){
                $banka+= $items_bank->subtotal;
            }
        }

        if($banka > 0){
            $span_b = "bold_sonuc";
        }
        if($nakit > 0){
            $span_n = "bold_sonuc";
        }

        $toplam=floatval($banka)+floatval($nakit);
        if($toplam > 0){
            $span_t = "bold_sonuc";
        }

        return array(
            'nakit'=>$nakit,
            'banka'=>$banka,
            'toplam'=>$toplam,
            'span_n'=>$span_n,
            'span_b'=>$span_b,
            'span_t'=>$span_t,
        );

    }
    elseif($tip==5) // Cari Gider
    {
        $nakit = 0;
        $banka = 0;
        $result = $ci->db->query("SELECT  SUM(talep_form_customer_products.total) as subtotal  FROM talep_form_customer_products INNER JOIN talep_form_customer ON talep_form_customer_products.form_id= talep_form_customer.id
Where talep_form_customer.method=1 and talep_form_customer.status=12 and talep_form_customer.type=2 GROUP BY talep_form_customer_products.form_id"); //nakit Cari Gider
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $nakit+= $items->subtotal;
            }

        }

        $result_banka = $ci->db->query("SELECT  SUM(talep_form_customer_products.total) as subtotal  FROM talep_form_customer_products INNER JOIN talep_form_customer ON talep_form_customer_products.form_id= talep_form_customer.id
Where talep_form_customer.method=3 and talep_form_customer.status=12 and talep_form_customer.type=2 GROUP BY talep_form_customer_products.form_id"); //Banka Personel Gider
        if($result_banka->num_rows()){
            foreach ($result_banka->result() as $items_bank){
                $banka+= $items_bank->subtotal;
            }
        }

        if($banka > 0){
            $span_b = "bold_sonuc";
        }
        if($nakit > 0){
            $span_n = "bold_sonuc";
        }

        $toplam=floatval($banka)+floatval($nakit);
        if($toplam > 0){
            $span_t = "bold_sonuc";
        }

        return array(
            'nakit'=>$nakit,
            'banka'=>$banka,
            'toplam'=>$toplam,
            'span_n'=>$span_n,
            'span_b'=>$span_b,
            'span_t'=>$span_t,
        );

    }
    elseif($tip==6) // Cari Avans
    {
        $nakit = 0;
        $banka = 0;
        $result = $ci->db->query("SELECT  SUM(talep_form_customer_products_new.total) as subtotal  FROM talep_form_customer_products_new INNER JOIN talep_form_customer_new ON talep_form_customer_products_new.form_id= talep_form_customer_new.id
Where talep_form_customer_new.method=1 and talep_form_customer_new.status=12 GROUP BY talep_form_customer_products_new.form_id"); //nakit Cari Gider
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $nakit+= $items->subtotal;
            }

        }

        $result_banka = $ci->db->query("SELECT  SUM(talep_form_customer_products_new.total) as subtotal  FROM talep_form_customer_products_new INNER JOIN talep_form_customer_new ON talep_form_customer_products_new.form_id= talep_form_customer_new.id
Where talep_form_customer_new.method=3 and talep_form_customer_new.status=12 GROUP BY talep_form_customer_products_new.form_id"); //Banka Personel Gider
        if($result_banka->num_rows()){
            foreach ($result_banka->result() as $items_bank){
                $banka+= $items_bank->subtotal;
            }
        }

        if($banka > 0){
            $span_b = "bold_sonuc";
        }
        if($nakit > 0){
            $span_n = "bold_sonuc";
        }

        $toplam=floatval($banka)+floatval($nakit);
        if($toplam > 0){
            $span_t = "bold_sonuc";
        }

        return array(
            'nakit'=>$nakit,
            'banka'=>$banka,
            'toplam'=>$toplam,
            'span_n'=>$span_n,
            'span_b'=>$span_b,
            'span_t'=>$span_t,
        );

    }
    elseif($tip==7)//nakliye talep
    {
        $nakit = 0;
        $banka = 0;
        $result = $ci->db->query("SELECT SUM(total) as subtotal From talep_form_nakliye_products Where status=12 and method=1 GROUP BY talep_form_nakliye_products.form_id"); //nakit Cari Gider
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $nakit+= $items->subtotal;
            }

        }

        $result_banka = $ci->db->query("SELECT SUM(total) as subtotal From talep_form_nakliye_products Where status=12 and method=3 GROUP BY talep_form_nakliye_products.form_id"); //Banka Personel Gider
        if($result_banka->num_rows()){
            foreach ($result_banka->result() as $items_bank){
                $banka+= $items_bank->subtotal;
            }
        }

        if($banka > 0){
            $span_b = "bold_sonuc";
        }
        if($nakit > 0){
            $span_n = "bold_sonuc";
        }

        $toplam=floatval($banka)+floatval($nakit);
        if($toplam > 0){
            $span_t = "bold_sonuc";
        }

        return array(
            'nakit'=>$nakit,
            'banka'=>$banka,
            'toplam'=>$toplam,
            'span_n'=>$span_n,
            'span_b'=>$span_b,
            'span_t'=>$span_t,
        );

    }
}

function cari_totals()
{
    $nakit =  ozet_totals(1)['nakit']+ozet_totals(5)['nakit']+ozet_totals(6)['nakit']+ozet_totals(7)['nakit'];
    $banka =  ozet_totals(1)['banka']+ozet_totals(5)['banka']+ozet_totals(6)['banka']+ozet_totals(7)['banka'];
    $totals = $banka+$nakit;

}

function stok_kontol_hizmet_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->stok_kontrol_list();
    return  $result['count'];


}
function stok_kontol_hizmet()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->stok_kontrol_list();
    return  $result['count'];


}
function count_kasa_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('reports_model');
    $result = $ci->reports_model->countkasa();
    return  $result['count'];


}
function forma2_new_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('reports_model');
    $result = $ci->reports_model->forma2_new_count();
    return  $result['count'];


}
function cikispers_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('cikispers_model');
    $result = $ci->cikispers_model->cikispers();
    return  $result['count'];


}
function bordro_edit_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('raporlar_model');
    $result = $ci->raporlar_model->bordro_edit_count();
    return  $result['count'];


}
function razi_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('razilastirma_model');
    $result = $ci->razilastirma_model->razi_count();
    return  $result['count'];


}
function maascount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('reports_model');
    $result = $ci->reports_model->maascount();
    return  $result['count'];


}
function bekleyenmaascount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('reports_model');
    $result = $ci->reports_model->bekleyenmaascount();
    return  $result['count'];


}
function bekleyenprimcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('reports_model');
    $result = $ci->reports_model->bekleyenprimcount();
    return  $result['count'];


}
function onay_qaime_list_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('reports_model');
    $result = $ci->reports_model->onay_qaime_list();
    return  $result['count'];


}
function beklyen_malzeme_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->beklyen_malzeme_count();
    return  $result['count'];


}
function personelsatinalmalistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->personelsatinalmalistcount();
    return  $result['count'];
}
function personelsatinalmahizmetlistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->personelsatinalmalistcount();
    return  $result['count'];
}
function ihalelistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->ihalelistcount();
    return  $result['count'];
}

function ihalelistcounthizmet_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->ihalelistcount();
    return  $result['count'];
}
function odemeemrilistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->odemeemrilistcount();
    return  $result['count'];
}
function siparislistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->siparislistcount();
    return  $result['count'];
}
function siparislistcounthizmet_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->siparislistcount();
    return  $result['count'];
}
function siparis_finist_list_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->siparis_finist_list_count();
    return  $result['count'];
}
function siparis_finishizmet_list_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->siparis_finist_list_count();
    return  $result['count'];
}
function bekleyen_sened_list_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->bekleyen_sened_list_count();
    return  $result['count'];
}
function bekleyen_sened_list_hizmet_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->bekleyen_sened_list_count();
    return  $result['count'];
}
function tehvil_list_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->tehvil_list_count();
    return  $result['count'];
}

function tehvil_list_count_hizmet_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->tehvil_list_count();
    return  $result['count'];
}
function qaimelistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->qaimelistcount();
    return  $result['count'];
}
function hizmetqaimelistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->qaimelistcount();
    return  $result['count'];
}
function cari_gider_onay_count()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->cari_gider_onay_count();
    return  $result;
}
function cari_avans_onay_count()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->cari_avans_onay_count();
    return  $result;
}
function warehousetransfercount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->warehousetransfercount();
    return  $result['count'];
}
function talepwarehousetransfercount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->talepwarehousetransfercount();
    return  $result['count'];
}
function odemetalepcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->odemetalepcount();
    return  $result['count'];
}
function avanslistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->avanslistcount();
    return  $result['count'];
}
function odemelistcountnew_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->odemelistcountnew();
    return  $result['count'];
}
function ihalebeklyenlistcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->ihalebeklyenlistcount();
    return  $result['count'];
}
function count_gider_mt_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->count_gider_mt();
    return  $result['count'];
}
function transfertaleplist_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('malzemetalep_model');
    $result = $ci->malzemetalep_model->transfertaleplist();
    return  $result['count'];
}
function bekleyentask_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('personelaction_model');
    $result = $ci->personelaction_model->bekleyentask();
    return  $result['count'];
}
function atama_gider_talep_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->atama_gider_talep();
    return  $result['count'];
}
function atama_nakliye_talep_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->atama_nakliye_talep();
    return  $result['count'];
}
function atama_cari_avans_talep_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->atama_cari_avans_talep();
    return  $result['count'];
}
function atama_personel_avans_talep_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->atama_personel_avans_talep();
    return  $result['count'];
}
function atama_personel_gider_talep_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->atama_personel_gider_talep();
    return  $result['count'];
}
function ajax_podradci_borclandirma_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('onay_model');
    $result = $ci->onay_model->ajax_podradci_borclandirma();
    return  $result['count'];
}
function muhasebeview_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('manager_model');
    $result = $ci->manager_model->muhasebeview();
    return  $result['count'];
}
function countgiderhizmet_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('carigidertalepnew_model');
    $result = $ci->carigidertalepnew_model->_count_gider_hizmet();
    return  $result['count'];
}
function nakliye_mt_talep_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('nakliye_model');
    $result = $ci->nakliye_model->nakliye_mt_talep();
    return  $result['count'];
}
function nakliyeteklifbekleyen_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('nakliye_model');
    $result = $ci->nakliye_model->nakliyeteklifbekleyen();
    return  $result['count'];
}
function caricezatalepcount_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('caricezatalep_model');
    $result = $ci->caricezatalep_model->caricezatalepcount();
    return  $result['count'];
}


function bekleyen_hizmet_count_func()
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->load->model('hizmet_model');
    $result = $ci->hizmet_model->bekleyen_hizmet_count_func();
    return  $result['count'];


}
function aylik_kalan_tutar($person_id)
{
    $ci = &get_instance();
    $ci->load->database();


    $net_maas = net_maas_hesaplama_number($person_id,30);
    //$max_tutar = ($net_maas / 100) * 70;
    $max_tutar = $net_maas/2;
    // echo $max_tutar;

    $date = new DateTime('now');
    $m=date('m');
    $y = date('Y');
    $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);



    $bitis_date = $y.'-'.$m.'-'.$total_ay_sayisi." 23:59:00";
    $baslangic_date = $y.'-'.$m."-1 08:00:00";

    $total_avans = $ci->db->query("SELECT IF(SUM(total),SUM(total),0) as totals FROM `geopos_invoices` WHERE `csd` = $person_id AND `invoice_type_id` = 14 AND `create_date` BETWEEN '$baslangic_date' AND '$bitis_date' ORDER BY `create_date` ASC")->row()->totals;


    $bakiye=personel_bakiye_report_num($person_id)['bakiye'];
    $bakiye_durum=personel_bakiye_report_num($person_id)['durum']; // 1 alacaklı 0 borclu


    if($bakiye_durum){
        $total_avans = 0;
    }
    else {
        if($bakiye<$total_avans){
            $total_avans=$bakiye;
        }
    }

    if($max_tutar>$total_avans){

        $kalan = floatval($max_tutar)-floatval($total_avans);

        return array(
            'status'=>true,
            'tutar'=>$kalan,
            'mesaj'=>"Sizin bu aydan kalan maksimum çekebileceğiniz tutar.",
        );
    }
    else {

        return array(
            'status'=>false,
            'tutar'=>0,
            'mesaj'=>"Sizin Bu Ay Avans Hakkınız Bulunmamaktadır!.Lütfen Sorumlu Olduğunuz Kişilerden Onay Talep Ediniz",
        );
    }


}

function personelavans_item_kontrol($person_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $net_maas = net_maas_hesaplama_number($person_id,30);

    //$max_tutar = ($net_maas / 100) * 70;
    $max_tutar = $net_maas/2;
    // echo $max_tutar;

    $date = new DateTime('now');
    $m=date('m');
    $y = date('Y');
    $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);



    $bitis_date = $y.'-'.$m.'-'.$total_ay_sayisi." 23:59:00";
    $baslangic_date = $y.'-'.$m."-1 08:00:00";

    $total_avans = $ci->db->query("SELECT IF(SUM(total),SUM(total),0) as totals FROM `geopos_invoices` WHERE `csd` = $person_id AND `invoice_type_id` = 14 AND `create_date` BETWEEN '$baslangic_date' AND '$bitis_date' ORDER BY `create_date` ASC")->row()->totals;

    $bakiye=personel_bakiye_report_num($person_id)['bakiye'];
    $bakiye_durum=personel_bakiye_report_num($person_id)['durum']; // 1 alacaklı 0 borclu


    if($bakiye_durum){
        $total_avans = 0;
    }
    else {
        if($bakiye<$total_avans){
            $total_avans=$bakiye;
        }
    }

    if($max_tutar>$total_avans){

        $kalan = floatval($max_tutar)-floatval($total_avans);

        return array(
            'status'=>true,
            'tutar'=>$kalan,
            'mesaj'=>"Sizin bu aydan kalan maksimum çekebileceğiniz tutar.",
        );
    }
    else {

        return array(
            'status'=>false,
            'tutar'=>0,
            'mesaj'=>"Sizin Bu Ay Avans Hakkınız Bulunmamaktadır!.Lütfen Sorumlu Olduğunuz Kişilerden Onay Talep Ediniz",
        );
    }
}

function talep_form_method_cari($talep_id,$cari_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $talep_details = $ci->db->query("SELECT * FROM talep_form where id = $talep_id")->row();
    $kdv_bilgileri = $ci->db->query("SELECT * FROM talep_form_teklifler Where cari_id = $cari_id and form_id = $talep_id")->row();
    $tf_teklif_id = $ci->db->query("SELECT * FROM talep_form_teklifler where form_id=$talep_id and cari_id=$cari_id")->row()->id;//12
    $odenis_bilgileri = $ci->db->query("SELECT * FROM talep_form_teklifler_details where tf_teklif_id=$tf_teklif_id")->row();
    $method = $odenis_bilgileri->method; //3
    return $method;
}
function talep_avans_kontrol($personel_id)
{
    $ci = &get_instance();
    $ci->load->database();

    $kontrol = $ci->db->query("SELECT * FROM talep_form_personel Where status IN(1,2,3,4,11,12) and personel_id=$personel_id and tip=2")->num_rows();
    if($kontrol){

        return array(
            'status'=>false,
            'message'=>'Açıkta Bulunan Avans Talebiniz Bulunmaktadır!',
        );
    }
    else{
        $d=date('d');
        if(10>intval($d)){
            return array(
                'status'=>false,
                'message'=>'Avans Talebini Her Ayın 10 undan sonra açabilirsiniz',
            );
        }
        else {
            return array(
                'status'=>true,
                'message'=>'Başarıyla Açabilirsiniz!',
            );
        }

    }

}

function arac_gider_totals($firma_demirbas_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $ci->db->select('
        firma_gider.type,
        firma_gider.talep_id,
        firma_gider.created_at,
        firma_gider.item_name,
        firma_gider.item_desc,
        demirbas_group.name as dg_name,
        firma_gider_products.product_qty,
        firma_gider_products.unit_id,
        firma_gider_products.price,
       firma_gider.code,
       firma_gider.firma_demirbas_id,
       talep_form_status.name as status_name');
        $ci->db->from('firma_gider_products');
        $ci->db->join('firma_gider',' firma_gider_products.form_id=firma_gider.id');
        $ci->db->join('demirbas_group','firma_gider_products.cost_id=demirbas_group.id');
        $ci->db->join('talep_form_status','firma_gider.status=talep_form_status.id');
        $ci->db->where('firma_gider.firma_demirbas_id',$firma_demirbas_id);
        $ci->db->where('firma_gider.table_name','araclar');
    $query = $ci->db->get();
    $querys = $query->result();
    $totals =0;
    if($querys){
        foreach($querys as $items){
            $totals+=floatval($items->price)*floatval($items->product_qty);
        }
    }

    return amountFormat($totals);


}
function kisalt($kelime)
{
    $str=30;
    if (strlen($kelime) > $str)
    {
        if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
        else $kelime = substr($kelime, 0, $str).'..';
    }
    return $kelime;
}
function parcala_multi_kontrol($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $kontrol = $ci->db->query("SELECT * FROM transaction_pay Where invoice_id = $id");
    if($kontrol->num_rows()){
        return array('status'=>true,'details'=>$kontrol->result());
    }
    else {
        return array('status'=>false);
    }
}

function vorker_list_run()
{
    $ci = &get_instance();
    $ci->load->database();
    $kontrol = $ci->db->query("SELECT * FROM worker_run Where forma2_id=0");

    if($kontrol->num_rows()){
        return array('status'=>true,'details'=>$kontrol->result());
    }
    else {
        return array('status'=>false);
    }
}
function vorker_list_run_aauth()
{
    $ci = &get_instance();
    $ci->load->database();
    $aauth_id = $ci->aauth->get_user()->id;
    $kontrol = $ci->db->query("SELECT * FROM worker_run Where aauth_id=$aauth_id");

    if($kontrol->num_rows()){
        return array('status'=>true,'details'=>$kontrol->result());
    }
    else {
        return array('status'=>false);
    }
}
function worker_details($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $kontrol = $ci->db->query("SELECT * FROM worker_list Where id=$id");

    if($kontrol->num_rows()){
       return $kontrol->row();
    }
    else {
        return array('status'=>false);
    }
}
function work_item_status($id,$status)
{
    $ci = &get_instance();
    $ci->load->database();

    if($status==1){
        return 'Aktif';
    }
    elseif($status==2){
        $kontrol = $ci->db->query("SELECT geopos_invoices.id,geopos_invoices.invoice_no FROM worker_run INNER JOIN geopos_invoices ON worker_run.forma2_id = geopos_invoices.id Where worker_run.id=$id")->row();

        $button ="<a class='btn btn-success' target='_blank' href='/formainvoices/view?id=".$kontrol->id."'>".$kontrol->invoice_no."</a>";
        return $button;
    }
    elseif($status==3){
        return 'Tamamlandı';
    }

}
