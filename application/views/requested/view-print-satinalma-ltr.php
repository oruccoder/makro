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
    <title>Talep Formu #<?php echo $invoice['id'] ?></title>
    <style>

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
            max-height: 90mm !important;

        }
        .plist tr
        {  font-size: 7px;

        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }


        .plist tr td {
            line-height: 0pt;
            font-size: 7px;
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

<div class="invoice-box" style="width: 100%">

    <table width="100%" class="plist" cellpadding="3" cellspacing="3">
        <tbody>
        <?php $c = 1;
        $sub_t = 0;
        $i=1;

        foreach ($products as $key=>$row) {

            $p=$row['product_name'];

            $product=str_replace("'","\'",$p);
            ?>
            <tr>

                <td rowspan="3" width="5%"><?php echo $c ?></td>
                <td rowspan="3" width="8%" style="font-size:7px;text-align: center;"><?php echo $row['product_name'] ?></td>
                <td rowspan="3" width="7%" style="font-size:7px;text-align: center"><?php echo $row['product_detail'] ?></td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['firma']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['firma_tel']; ?> </td>
                <td rowspan="3" width="5%" style="font-size:7px;text-align: center"><?php echo $row['qty'] ?></td>
                <td rowspan="3" width="5%" style="font-size:7px;text-align: center"><?php echo $row['unit'] ?></td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['price']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['subtotal']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['teklif_tarih_no']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['odeme_sekli']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,0)['odeme_tarihi']; ?> </td>
            </tr>
            <tr>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['firma']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['firma_tel']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['price']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['subtotal']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['teklif_tarih_no']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['odeme_sekli']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,1)['odeme_tarihi']; ?> </td>
            </tr>
            <tr>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['firma']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['firma_tel']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['price']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['subtotal']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['teklif_tarih_no']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['odeme_sekli']; ?> </td>
                <td rowspan="1" width="10%" style="font-size:7px;text-align: center"><?php echo talep_item_alt($row['tip'],$product,2)['odeme_tarihi']; ?> </td>
            </tr>

            <?php
            $c++;
            $i++;
        } ?>

        </tbody>


    </table>


    <!--div style="width: 60%;float:right;">
        <p style="font-size: 9px">
       1)Qiymətlərə ƏDV xariç verilmelidir.<br/>
       2)Təklif neçe gun quvvədədir.<br/>
       3)Odəniş mal təhvil verilende köçürme ile heyata keçirileçektir<br/>
       4)Təhvil verilən mallar QOST/EU/TSE  standartları ilə verilməlidir.<br/>
       5)Məbləğə çatdırılma daxil qiymət verilsin.<br/>
        </p>
    </div-->






</div>

