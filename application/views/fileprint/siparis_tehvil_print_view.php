

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
    <title>Tehvil Fişi #<?php echo $details->invoice_no ?></title>
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
            text-transform: uppercase !important;
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

<table style="font-size: 12px">
    <tr>
        <td style=" border-top: hidden; border-left:hidden;  ">Çıkış Ünvanı</td>
        <td style="text-align: center;line-height:20px;border: 1px solid black;"><?php echo warehouse_details($siparis_details->depo)->title ?><br><?php echo warehouse_details($siparis_details->depo)->extra ?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style=" border-top: hidden; border-left:hidden;  ">Layihe Adı Ünvanı</td>
        <td style="text-align: center;line-height:20px;border: 1px solid black"><?php echo customer_new_projects_details($details->proje_id)->proje_name ?></td>

    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style=" border-top: hidden; border-left:hidden;  ">Çatdırılma Ünvanı</td>
        <td style="text-align: center;line-height:20px;border: 1px solid black"><?php echo customer_teslimat_adres_details($details->shipping_id)->unvan_teslimat."<br>".customer_teslimat_adres_details($details->shipping_id)->sehir_teslimat.' '.customer_teslimat_adres_details($details->shipping_id)->city_teslimat.' '.customer_teslimat_adres_details($details->shipping_id)->adres_teslimat.' | Nömre : '.customer_teslimat_adres_details($details->shipping_id)->phone_teslimat ?></td>

    </tr>
</table>
<br>
<table style="font-size: 12px;border: 1px solid black">
    <thead>
    <tr>
        <th style="border: 1x solid black;">Yük Maşınında Betonun miqdarı <?php echo units_($uretim_details->unit_id)['code']?></th>
        <th style="border: 1x solid black;">Toplam Sifariş</th>
        <th style="border: 1x solid black;">Teslim Edilmiş</th>
        <th style="border: 1x solid black;">Kalan</th>
        <th style="border: 1x solid black;">Çatdırılma Üçün Diger</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border-right: 1x solid black;"><?php echo $details->items.' '.units_($uretim_details->unit_id)['name'] ?></td>
        <td style="border-right: 1x solid black;"><?php echo $uretim_details->quantity.' '.units_($uretim_details->unit_id)['name'] ?></td>
        <td style="border-right: 1x solid black;"><?php echo $teslim_edilen_miktar.' '.units_($uretim_details->unit_id)['name'] ?></td>
        <td style="border-right: 1x solid black;"><?php echo $kalan.' '.units_($uretim_details->unit_id)['name'] ?></td>
        <td></td>
    </tr>
    </tbody>
</table>
<br/>


<table style="font-size: 12px;border: 1px solid black">
    <thead>
    <tr>
        <th style="border: 1x solid black;">Ürün Markası</th>
        <th style="border: 1x solid black;">Varyantlar</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border-right: 1x solid black;"><?php echo $uretim_details->product_name ?></td>
        <?php
        $option_html='Varyasyonsuz';
        $details_options = uretim_new_products($uretim_details->recete_id);

        if($details_options){
            $option_html='';
            foreach ($details_options as $options_items){
                $option_html.=varyasyon_string_name($options_items->option_id,$options_items->option_value_id);
            }
        }
        ?>
        <td style="border-right: 1x solid black;"><?php echo $option_html ?></td>
    </tr>
    </tbody>
</table>
<br>
<table class="mycooo1" style="font-size: 12px">
    <tr>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden  ">Maşının Qeydiyyat Nömresi</td>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align: right">Sürücünün İmzası</td>


    </tr>
    <tr>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;"><?php echo $details->pers_notes;?></td>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align: right">____________________</td>
    </tr>

</table>
<br>
<table style="font-size: 12px;border: 1px solid black">
    <thead>
    <tr>
        <th style="border: 1x solid black;">İstehsal Sahesinden Çıxış Vaxtı</th>
        <th style="border: 1x solid black;">Tikinti Sahesine Çatma Vaxtı</th>
        <th style="border: 1x solid black;">Boşaltma Başlanğıc Vaxtı</th>
        <th style="border: 1x solid black;">Boşaltmanın tamamlanması Müddeti</th>
        <th style="border: 1x solid black;">Tikinti Sahesinde Gözleme Müddeti</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border-right: 1x solid black;">&nbsp;</td>
        <td style="border-right: 1x solid black;">&nbsp;</td>
        <td style="border-right: 1x solid black;">&nbsp;</td>
        <td style="border-right: 1x solid black;">&nbsp;</td>
        <td></td>
    </tr>
    </tbody>
</table>
<br/>
<table class="mycooo1" style="font-size: 12px">
    <tr>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden  ">Tehvil Veren ___________________________</td>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align: right">Tehvil Alan ___________________________</td>


    </tr>
</table>
<br>

<table class="mycooo1" style="font-size: 12px">
    <tr>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align:center; ">İstehsalçının Selahiyyetli Şexsi</td>
        <td style="border: hidden"></td>

        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align:right;">Tikinti Sehesinde Selahiyyetli Şexs</td>
        <td style="border: hidden"></td>

    </tr>
    <tr>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;">Ad,Soyad ___________________________</td>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;">İmza____________________</td>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align: right">Ad,Soyad ___________________________</td>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden;text-align: right">İmza____________________</td>
    </tr>

</table>
