

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
            <th>#</th>
            <th>MALZEME</th>
            <th>Varyasyon</th>
            <th>TEKLIF MIKTARI</th>
            <th>VAHID QIYMƏT</th>
            <th>ENDIRIM</th>
            <th>ƏDV ORAN</th>
            <th>ƏDV </th>
            <th>CEMI (EDVSİZ)</th>
            <th>ÜMUMI CƏMI (EDVSİZ)	</th>
            <th>NOT</th>
        </tr>

        <tbody style="font-family: Open Sans">
        <?php
        $i=1;
        $eq=0;
        foreach ($items_ as $items){

        if($teklif_kontrol){

        if($details->talep_type==1){
            $product_name= product_details_($items->product_id)->product_name;
        }
        elseif($details->talep_type==2) {
            $product_name= product_details_($items->product_id)->product_name;
        }
        elseif($details->talep_type==3) {
            $product_name= who_demirbas($items->product_id)->name;
        }

        $details_items = teklif_update_item_kontrol($items->id,$details_id);


        $unit_name = units_($items->unit_id)['name'];
        if($items->product_type==2){
            $product_name = cari_product_details($items->product_id)->product_name;
            $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
        }
        $edv_text='Hariç';
        if($details_items->edv_type==1){
            $edv_text='Dahil';
        }

        ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $product_name; ?></td>
            <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
            <td><?php echo floatval($details_items->qty) ?> <span class="input-group-addon font-xs text-right"><?php echo $unit_name ?></span></div></td>
            <td><?php echo amountFormat($details_items->price) ?></td>
            <td><?php echo $details_items->discount; ?> <span class="input-group-addon font-xs text-right item_discount_type">%</span></td>
            <td><?php echo $details_items->edv_oran; ?> <span class="input-group-addon font-xs text-right">%</span></td>
            <td><?php  echo  $edv_text;?></td>

            <td><?php echo amountFormat($details_items->sub_total) ?></td>
            <td><?php echo amountFormat($details_items->total) ?></td>
            <td><?php echo $details_items->item_desc;?></td>
            </tr>
            <?php
}
        else{
            $details = cari_to_teklif_details($items->id,$teklif_id);
            $price = floatval($details->price);
            $endirim = floatval(0);
            $edv = floatval(0);
            $product_name = product_name($items->product_id);
            $unit_name = units_($items->unit_id)['name'];
            if($items->product_type==2){
                $product_name = cari_product_details($items->product_id)->product_name;
                $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
            }
            $edv_text='Hariç';
            if($teklif_details->kdv==1){
                $edv_text='Dahil';
            }
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $product_name ?></td>
                <td><?php echo $items->product_qty;?><span class="input-group-addon font-xs text-right"><?php echo $unit_name?></span></td>
                <td><?php echo amountFormat($price) ?></td>
                <td><?php echo $endirim ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></td>
                <td><?php echo $teklif_details->kdv_oran ?><span class="input-group-addon font-xs text-right">%</span></td>
                <td><?php echo $edv_text;?></td>
                <td><input value="0" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                <td><input value="0" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                <td><input type="text" class="form-control item_desc" value="<?php echo $details->notes;?>"></td>
            </tr>
            <?php
        }
        $i++;
        $eq++;


        } ?>


<tr>
    <td colspan="8"></td>
    <td>Cəmi:</td>
    <td><?php echo amountFormat($teklif_details_items->alt_sub_total_val)?></td>
</tr>

<tr>
    <td colspan="8"></td>
    <td>Güzəşt:</td>
    <td><?php echo amountFormat($teklif_details_items->alt_discount_total_val)?></td>
</tr>
<tr>
    <td colspan="8"></td>
    <td>Net Cemi:</td>
    <td><?php echo amountFormat($teklif_details_items->alt_sub_total_val-$teklif_details_items->alt_discount_total_val)?></td>
</tr>
<tr>
    <td colspan="8"></td>
    <td>ƏDV:</td>
    <td><?php echo amountFormat($teklif_details_items->alt_edv_total_val)?></td>
</tr>
<tr>
    <td colspan="8"></td>
    <td>ümumi cəmi:</td>
    <td><?php echo amountFormat($teklif_details_items->alt_total_val)?></td>
</tr>


<tr>
    <td colspan="8"></td>
    <td>Ödeme Şekli:</td>
    <td><?php echo account_type_sorgu($teklif_details_items->method)?></td>
</tr>
<tr>
    <td colspan="8"></td>
    <td>Ön Ödeme:</td>
    <td><?php echo amountFormat($teklif_details_items->avans_price)?></td>
</tr>
<tr>
    <td colspan="8"></td>
    <td>Nakliye:</td>
    <td><?php echo amountFormat($teklif_details_items->teslimat_tutar)?></td>
</tr>

</tbody>



    </table>

</div>

