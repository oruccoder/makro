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



class Pdf

{



    function __construct()

    {

        $CI = &get_instance();

    }



    function load($param = NULL)

    {





        require_once APPPATH . '/third_party/vendor/autoload.php';



        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 5, 'margin_right' => 5, 'margin_top' => 5, 'margin_bottom' => 4]);



        //$mpdf->SetDirectionality('RTL');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        return $mpdf;





    }



	function load_en($param = NULL)

    {





        require_once APPPATH . '/third_party/vendor/autoload.php';



        $mpdf = new \Mpdf\Mpdf();



        //$mpdf->SetDirectionality('RTL');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        return $mpdf;





    }





    function load_split($param = NULL)

    {





        require_once APPPATH . '/third_party/vendor/autoload.php';



        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 5, 'margin_right' => 5, 'margin_top' =>40, 'margin_bottom' => 12]);



        //$mpdf->SetDirectionality('RTL');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        $mpdf->use_kwt = true;

        return $mpdf;





    }



        function load_thermal($param = NULL)

    {





        require_once APPPATH . '/third_party/vendor/autoload.php';



        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',  'margin_left' => 1, 'margin_right' => 1, 'margin_top' =>1, 'margin_bottom' => 1]);



        //$mpdf->SetDirectionality('RTL');

        $mpdf->autoScriptToLang = true;

        $mpdf->autoLangToFont = true;

        $mpdf->use_kwt = true;





        return $mpdf;





    }

}