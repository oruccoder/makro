

<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 22.01.2020
 * Time: 15:22
 */
?>
<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Teklif Formu #<?php echo $details->code ?></title>
    <style>

        .ft-end{
            text-align: end
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 9px;

        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 4px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 4px;
            padding-bottom: 4px;
            font-size: 7px;
            text-align: left;
            line-height: 10px;
        }

        body {
            color: #2B2000;
            font-family: 'Helvetica';
            width: 210mm;
            height: 90mm !important;

        }


        .invoice-box {

            margin: auto;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;

        }
        .plist
        {
            width: 210mm;
            max-height: 90mm !important;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }


        .plist tr td {
            line-height: 0pt;
            font-size: 10px;
            border-bottom: 1px solid gray;
            border-left: 1px solid gray;
            border-right: 1px solid gray;
        }

        .mycooo1 tr td {
            border-top: 1px solid gray;
            border-bottom: 1px solid gray;
            border-left: 1px solid gray;
            border-right: 1px solid gray;
        }
        .subtotal {
            page-break-inside:avoid;
            font-size:10px;
            font-weight:bold ;
        }

        .subtotal tr td {
            line-height: 5pt;
            padding: 2pt;
        }

        .subtotal tr td {
            border: 2px solid #494949;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right:20pt;
        }

        .invoice-box table td {
            padding: 2px;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 0pt;

        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

        table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td{
            border: 1px solid #ddd;
        }

        table tr.b_class td{
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td{
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 100%;

        }



        .myco2 {
            width: 200pt;
        }

        .myw {
            width: 300pt;
            font-size: 14pt;
            line-height: 14pt;
        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;
        }
        .party {
            border: #ccc 1px solid;
        }


    </style>
</head>

<body>

<div class="invoice-box">
    <table  cellpadding="0" cellspacing="0" id="customers" >
        <thead>
        <tr>
            <td>No</td>
            <th>Məhsul Adı</th>
            <th>Firma</th>
            <th>Sipariş Miktarı</th>
            <th>Teslim Alınan Miktar</th>
            <th>Kalan Miktar</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $eq=1;



if(tehvil_products($details->id)){
    foreach (tehvil_products($details->id) as $product_items){


        $cari_id=$product_items->cari_id;
        $talep_form_product_id=$product_items->talep_form_product_id;
        $form_id=$product_items->form_id;
        $image=product_full_details_parent($product_items->product_stock_code_id,$product_items->product_id)['image'];
        $teslim_alinmis = hizmet_teslim_alinmis($details->id,$product_items->product_id,$talep_form_product_id)['alinan_miktar'];
        $forma_2_html = hizmet_teslim_alinmis($details->id,$product_items->product_id,$talep_form_product_id)['forma2_bilgisi'];

        $kalan_miktar = floatval($product_items->qty)-floatval($teslim_alinmis);
        ?>
            <tr>
              <td><?php echo $eq;?></td>
                <td><?php

                    echo who_demirbas($product_items->product_id)->name;

                    ?><span><?php echo talep_form_product_options_new($product_items->product_stock_code_id) ?>
    </span></td>
            <td><?php echo customer_details($product_items->cari_id)['company'] ?></td>
            <td><?php echo amountFormat_s($product_items->qty) .' '.units_($product_items->unit_id)['name']?></td>
            <td><?php echo amountFormat_s($teslim_alinmis).' '.units_($product_items->unit_id)['name']?></td>
            <td><?php echo amountFormat_s($kalan_miktar).' '.units_($product_items->unit_id)['name']?></td>
        </tr>
        <?php
        $eq++;
        }
        }


        ?>
        </tbody>
    </table>
</div>

