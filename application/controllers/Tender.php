<?php
/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ******************************************tedtst***************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tender Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tender_model', 'model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->limited = '';
    }
    public function find_similar3($needle,$str,$keep_needle_order=false){
        if(!is_string($needle)||!is_string($str))
        {
            return false;
        }
        $valid=array();
        //get  encodings  and words from haystack and needle
        setlocale(LC_CTYPE, 'en_GB.UTF8');
        $encoding_s=mb_detect_encoding($str);
        $encoding_n=mb_detect_encoding($needle);

        mb_regex_encoding ($encoding_n);
        $pneed=array_filter(mb_split('\W',$needle));

        mb_regex_encoding ($encoding_s);
        $pstr=array_filter(mb_split('\W',$str));



        foreach($pneed as $k=>$word)//loop trough needle's words
        {
            foreach($pstr as $key=>$w)
            {
                if($encoding_n!==$encoding_s)
                {//if $encodings are not the same make some transliteration
                    $tmp_word=($encoding_n!=='ASCII')?to_ascii($word,$encoding_n):$word;
                    $tmp_w=($encoding_s!=='ASCII')?to_ascii($w,$encoding_s):$w;
                }else
                {
                    $tmp_word=$word;
                    $tmp_w=$w;
                }

                $tmp[$tmp_w]=levenshtein($tmp_w,$tmp_word);//collect levenshtein distances
                $keys[$tmp_w]=array($key,$w);

            }

            $nominees=array_flip(array_keys($tmp,min($tmp)));//get the nominees
            $tmp=10000;
            foreach($nominees as $nominee=>$idx)
            {//test sound like to get more precision
                $idx=levenshtein(metaphone($nominee),metaphone($tmp_word));
                if($idx<$tmp){
                    $answer=$nominee;//get the winner

                }
                unset($nominees[$nominee]);
            }
            if(!$keep_needle_order){
                $valid[$keys[$answer][0]]=$keys[$answer][1];//get the right form of the winner
            }
            else{
                $valid[$k]=$keys[$answer][1];
            }
            $tmp=$nominees=array();//clean a little for the next iteration
        }
        if(!$keep_needle_order)
        {
            ksort($valid);
        }

        $valid=array_values($valid);//get only the values
        /*return the array of the closest value to the
        needle according to this algorithm of course*/
        return $valid;

    }
    public function index(){


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Tender List';
        $this->load->view('fixed/header', $head);
        $this->load->view('tender/index');
        $this->load->view('fixed/footer');


    }

    public function new_test()
    {
        $aranan = 'Özüboşaldan avtomobil Kamaz';

        $kelimeler  = array(
            'Özüboşaldan avtomobil Kamaz 66115,2011 15t daşınma məsafəsi - 10 km. 1-ci sinifli yük (yalnız işçilik qiymətləndirilir)',

        'Qruntun hər növbəti 5 m daşınması zamanı 01-01-033-02
normasına əlavə etmək (Əlavə 10m) (yalnız işçilik qiymətləndirilir','Xəndəklərin, çalaların və çuxurların əl ilə doldurulması, qruntun
qrupu: 2 (yalnız işçilik qiymətləndirilir)');


        $enyakin = -1;
        foreach ($kelimeler as $kelime)
        {
            $lev = levenshtein($aranan, $kelime);

            if ($lev == 0)
            {
                $benzer = $kelime;
                $enyakin = 0;
                break;
            }

            if ($lev <= $enyakin || $enyakin < 0)
            {
                $benzer  = $kelime;
                $enyakin = $lev;
            }
        }

        echo "aranan kelime: $aranan <br>";
        if ($enyakin == 0) {
            echo "Bulundu: $benzer";
        } else {
            echo "Bunu mu demek istediniz: $benzer ?";
        }
    }

    public function arastir()
    {
        $oran=80;
        $source = "Guraşdırma kabelləri H05VV-F
3x1,5 (yalnız material/avadanlıq qiymətləndirilir)";
        $needle = $this->db->query("SELECT * FROM tender_list")->result_array();
        $count=0;


        foreach ($needle as $string){
            similar_text($string['name'],$source,$similarity);
            if($similarity > $oran){
                echo $string['name'].' | Oran '.round($similarity,2)."<br>";
                $count++;
            }

        }
        if(!$count){
            echo "Belirlenen Oranda Bulunamadı";
        }
    }

    public function ajax_list()
    {

        //SELECT REPLACE(code, '\n', '') From tender_list WHERE code;
        $list = $this->model->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        $oran = $this->input->post('oran');
        $search = $this->input->post('search');
        foreach ($list as $invoices) {
            if($search){
//                $this->db->query("select * from tender_list where name like '%$search%'");

                similar_text($invoices->name,$search,$similarity);
                if($similarity > $oran){
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $invoices->code;
                    $row[] = $invoices->name;
                    $row[] = $invoices->olcu_vahidi;
                    $row[] = amountFormat_se($invoices->malzeme);
                    $row[] = amountFormat_se($invoices->iscilik);
                    $row[] = amountFormat_se($invoices->sadece_iscilik);
                    $row[] = amountFormat_se($invoices->emeq_haqqi);
                    $row[] = amountFormat_se($invoices->toplam);
                    $data[] = $row;
                }
                else {
                    $like = " name LIKE '%" . $this->db->escape_like_str($search) . "%' or code LIKE '%" . $this->db->escape_like_str($search) . "%' ";
                    $sql =  $this->db->query("SELECT * FROM tender_list Where $like");


                    if($sql->num_rows()){
                        foreach ($sql->result() as $values){
                            if($values->id == $invoices->id){
                                $no++;
                                $row = array();
                                $row[] = $no;
                                $row[] = $invoices->code;
                                $row[] = $invoices->name;
                                $row[] = $invoices->olcu_vahidi;
                                $row[] = amountFormat_se($invoices->malzeme);
                                $row[] = amountFormat_se($invoices->iscilik);
                                $row[] = amountFormat_se($invoices->sadece_iscilik);
                                $row[] = amountFormat_se($invoices->emeq_haqqi);
                                $row[] = amountFormat_se($invoices->toplam);
                                $data[] = $row;
                            }
                        }
                    }
                }
            }
            else {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $invoices->code;
                $row[] = $invoices->name;
                $row[] = $invoices->olcu_vahidi;
                $row[] = amountFormat_se($invoices->malzeme);
                $row[] = amountFormat_se($invoices->iscilik);
                $row[] = amountFormat_se($invoices->sadece_iscilik);
                $row[] = amountFormat_se($invoices->emeq_haqqi);
                $row[] = amountFormat_se($invoices->toplam);
                $data[] = $row;
            }




        }
        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->model->count_all($this->limited),
            "recordsFiltered" => 1,
            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function a2jax_list()
    {

        $list = $this->model->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        $oran = $this->input->post('oran');
        $search = $this->input->post('search');
        $enyakin=-1;

        foreach ($list as $invoices) {
            $benzer='';
            if($search){

                $lev = levenshtein($search, $invoices->name);

                if ($lev == 0)
                {
                    $benzer = $invoices->name;
                    $enyakin = 0;
                    break;
                }

                if ($lev <= $enyakin || $enyakin < 0)
                {
                    $benzer  = $invoices->name;
                    $enyakin = $lev;
                }
                if($benzer){
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $invoices->name;
                    $row[] = $invoices->olcu_vahidi;
                    $row[] = amountFormat($invoices->price);
                    $row[] = amountFormat($invoices->i_price);
                    $row[] = amountFormat($invoices->total_price);
                    $data[] = $row;
                }
            }
            else {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $invoices->name;
                $row[] = $invoices->olcu_vahidi;
                $row[] = amountFormat($invoices->price);
                $row[] = amountFormat($invoices->i_price);
                $row[] = amountFormat($invoices->total_price);
                $data[] = $row;
            }




        }
        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->model->count_all($this->limited),
            "recordsFiltered" => 1,
            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }
}