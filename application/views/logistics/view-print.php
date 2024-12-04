

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
    <title>Talep Formu #<?php echo $details->id ?></title>
    <style>


        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;

        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;

            text-align: left;
            background-color: #04AA6D;
            color: white;
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
    <table  cellpadding="0" cellspacing="0" id="customers">

        <tr>
            <th>Lokasyon</th>
            <th>Firma</th>
            <th>Protokol</th>
            <th>Proje Adı</th>
            <!--                                    <th>Açıklama</th>-->
            <th>SF No</th>
            <!--                                    <th>Personel</th>-->
            <th>Araç </th>
            <th>Miktar </th>
            <th>Birim </th>
            <th>Birim Fiyatı</th>
            <th>KDV Durum</th>
            <th>KDV Oran</th>
            <th>Ödeme Metodu</th>
        </tr>
        <tbody style="font-family: Open Sans">
        <?php
        $total=0;

        if($items){
            foreach ($items as $key=> $item) {
                $rows = count($items)+floatval(1);
                ?>

<!--                <tr>-->

                    <?php
                    $loc='';
                    $l_id=0;
                    $loc = '';
                    ?>
                    <!--                    <td rowspan="2" style="text-align: center;vertical-align: inherit;    border-right: 1px solid;">--><?php //echo $loc ?><!--</td>-->
                    <?php

                    if(lojistik_item_location($details->id,$item['sf_item_id'],2)['items']){
                        foreach (lojistik_item_location($details->id,$item['sf_item_id'],2)['items'] as $values_){


                            $values = $values_['result'];

                            $loc = location_name($item['sf_item_id']);


                            $price = amountFormat($values->price);
                            $metod = account_type_sorgu($values->account_type);
                            $sf_no = lojistik_items_sf_html($details->id,$values->id,2);
                            $protokol =lojistik_items_protokol($details->id,$values->id,2);

                            $total+=($values->price)*($values->qty);
                            $kdv='Dahil';
                            if($values->kdv_durum==0){
                                $kdv='Hariç';
                            }
                            echo "<tr>
                                                    <td>$loc</td>
                                                    <td>$values->company</td>
                                                    <td>$protokol</td>
                                                    <td>$values->proje_name</td>
                                                    <td>$sf_no</td>
                                                    <td>$values->arac_name</td>
                                                    <td>$values->qty</td>
                                                    <td>$values->unit_name</td>
                                                    <td>$price</td>
                                                    <td>$kdv</td>
                                                    <td>$values->kdv_oran</td>
                                                    <td>$metod</td>
                                 </tr>";

                            $l_id = $values_['l_id'];
                        }
                    }

                    ?>

<!--                </tr>-->


            <?php  }

        ?>
        <tr style="font-weight: 900;">
            <td colspan="7"></td>
            <td><span style="float: left">Net Toplam</span></td>
            <td><?php echo  amountFormat($total); ?></td>
        </tr>
        <?php
        }
       ?>


            </tbody>



    </table>

</div>

