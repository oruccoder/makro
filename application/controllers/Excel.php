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


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Excel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }

    public function tender_index(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Excel İmport';
        $this->load->view('fixed/header', $head);
        $this->load->view('excel/index');
        $this->load->view('fixed/footer');

    }

    public function upload_tender_post()
    {


        $config['upload_path'] = './userfiles/excel2/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = 999999;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            echo json_encode(array(
                'status' => 410,
                'message'=>"Hata Aldınız"

            ));

        } else {
            $data['filename'] = $this->upload->data()['file_name'];
            $inputFileName='./userfiles/excel2/'.$data['filename'];
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            $reader= \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);
            $sheet = $spreadsheet->getSheet(0);
            $count_rows = 0;
            foreach ($sheet->getRowIterator() as $row){

                $code = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
                $product_name = $spreadsheet->getActiveSheet()->getCell('B'.$row->getRowIndex());
                $olcu_Vahidi = $spreadsheet->getActiveSheet()->getCell('C'.$row->getRowIndex());
                $malzeme = $spreadsheet->getActiveSheet()->getCell('D'.$row->getRowIndex());
                $iscilik = $spreadsheet->getActiveSheet()->getCell('E'.$row->getRowIndex());
                $sadece_iscilik = $spreadsheet->getActiveSheet()->getCell('F'.$row->getRowIndex());
                $emeq_haqqi = $spreadsheet->getActiveSheet()->getCell('G'.$row->getRowIndex());
                $toplam = $spreadsheet->getActiveSheet()->getCell('H'.$row->getRowIndex());

                if(isset($olcu_Vahidi)){
                    $data=array(

                        'code'=>$code,
                        'name'=>$product_name,
                        'olcu_vahidi'=>$olcu_Vahidi,
                        'malzeme'=>$malzeme,
                        'iscilik'=>$iscilik,
                        'sadece_iscilik'=>$sadece_iscilik,
                        'emeq_haqqi'=>$emeq_haqqi,
                        'toplam'=>$toplam,
                    );
                    $this->db->insert('tender_list',$data);
                    $count_rows++;
                }


            }
            if($count_rows){
                echo json_encode(array(
                    'status' => 200,
                    'message'=>$count_rows.' Adet Kayıt Edildi'

                ));
            }
            else {
                echo json_encode(array(
                    'status' => 410,
                    'message'=>"Hata Aldınız"

                ));
            }

        }
    }

    public function upload_is_kalemleri()
    {


        $config['upload_path'] = './userfiles/excel2/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = 999999;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            echo json_encode(array(
                'status' => 410,
                'message'=>"Hata Aldınız D"

            ));

        }
        else {
            $data['filename'] = $this->upload->data()['file_name'];
            $inputFileName='./userfiles/excel2/'.$data['filename'];
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
            $reader= \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);
            $sheet = $spreadsheet->getSheet(0);
            $count_rows = 0;
            foreach ($sheet->getRowIterator() as $key=>$row){

                if($key > 1){
                    $name = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
                    $code = $spreadsheet->getActiveSheet()->getCell('B'.$row->getRowIndex());
                    $simeta_code = $spreadsheet->getActiveSheet()->getCell('C'.$row->getRowIndex());
                    $desc = $spreadsheet->getActiveSheet()->getCell('D'.$row->getRowIndex());
                    $loc = 5;
                    $unit_qty = $spreadsheet->getActiveSheet()->getCell('F'.$row->getRowIndex());
                    $unit_id = $spreadsheet->getActiveSheet()->getCell('G'.$row->getRowIndex());
                    $asama_id = $spreadsheet->getActiveSheet()->getCell('H'.$row->getRowIndex());
                    $recete_id = 0;
                    $new_code = isEmptyFunction( $code,numaric(48));
                    $new_desc = isEmptyFunction( $desc,$name);
                    $simeta_code_new = isEmptyFunction( $simeta_code,$new_code);


                    $kontrol = $this->db->query("SELECT * FROM projeiskalmeleri Where name ='$name' and asama_id=$asama_id");
                    if(!$kontrol->num_rows()){
                        $data = array(
                            'code'=>$new_code,
                            'name'=>$name,
                            'recete_id'=>$recete_id,
                            'asama_id'=>$asama_id,
                            'desc'=>$new_desc,
                            'unit_qty'=>$unit_qty,
                            'unit_id'=>$unit_id,
                            'simeta_code'=>$simeta_code_new,
                            'auth_id' => $this->aauth->get_user()->id,
                            'loc' =>  $loc
                        );
                        if($this->db->insert('projeiskalmeleri',$data)){
                            numaric_update(48);
                            $count_rows++;
                        }
                    }
                }


            }
            if($count_rows){
                echo json_encode(array(
                    'status' => 200,
                    'message'=>$count_rows.' Adet Kayıt Edildi'

                ));
            }
            else {
                echo json_encode(array(
                    'status' => 410,
                    'message'=>"Hata Aldınızs"

                ));
            }

        }
    }

    public function tender(){


        $inputFileName='./userfiles/excel_import/import2.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader= \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);
        $sheet = $spreadsheet->getSheet(0);
        $count_rows = 0;
        foreach ($sheet->getRowIterator() as $row){

            $code = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
            $product_name = $spreadsheet->getActiveSheet()->getCell('B'.$row->getRowIndex());
            $olcu_Vahidi = $spreadsheet->getActiveSheet()->getCell('C'.$row->getRowIndex());
            $malzeme = $spreadsheet->getActiveSheet()->getCell('D'.$row->getRowIndex());
            $iscilik = $spreadsheet->getActiveSheet()->getCell('E'.$row->getRowIndex());
            $sadece_iscilik = $spreadsheet->getActiveSheet()->getCell('F'.$row->getRowIndex());
            $emeq_haqqi = $spreadsheet->getActiveSheet()->getCell('G'.$row->getRowIndex());

            if(isset($olcu_Vahidi)){
                $data=array(

                    'code'=>$code,
                    'name'=>$product_name,
                    'olcu_vahidi'=>$olcu_Vahidi,
                    'malzeme'=>$malzeme,
                    'iscilik'=>$iscilik,
                    'sadece_iscilik'=>$sadece_iscilik,
                    'emeq_haqqi'=>$emeq_haqqi,
                );
                $this->db->insert('tender_list',$data);
                $count_rows++;
            }

        }
        echo $count_rows;
    }

}