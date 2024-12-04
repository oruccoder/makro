<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Məhsul fiş çap # <?php echo $details->proje_id ?></title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }
        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
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
            padding: 6pt 4pt 2pt 4pt;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding-bottom: 3px;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

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
            width: 400pt;
        }

        .myco2 {
            width: 300pt;
        }

        .myw {
            width: 240pt;
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
    <br>
    <table  style="font-size: 12px" class="party">
        <thead>
        <tr class="heading">
            <td>#</td>
            <?php if($details->fis_tur==3){ ?>
            <td>Proje Bilgileri</td>
            <?php } ?>
            <td>MEHSUL</td>
            <td>VARYASYON</td>
            <td>MİQDAR</td>
            <td>AÇIQLAMA</td>
        </tr>
        </thead>
        <tbody>
        <?php
            $i = 1;
        foreach ($items as $item){ ?>
            <tr class="">
                <td> <?php echo $i++ ?> </td>
                <?php if($details->fis_tur==3){ ?>
                <td><?php echo proje_code($item->proje_id) ?><p><?php echo bolum_to_asama($item->bolum_id).'<br>'.task_to_asama($item->asama_id)?></p></td>
                <?php } ?>
                <td> <?=$item->product_name ?> </td>
                <td> <?=varyasyon_string_name_new($item->product_stock_code_id) ?> </td>
                <td> <?=$item->qty.' '.$item->unit_name ?> </td>
                <td> <?php echo  $item->description ? $item->description : '-' ?> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br/>
    <p style="font-size: 10px">* Yukarıda belirtilen Ürünleri Eksiksiz teslim aldım / teslim ettim</p><br><br>
    <footer style="padding-bottom: 90px">

        <table  style="font-size: 12px">
            <tr>
                <td style="text-align: center"><b>Tehvil Veren</b></td>
                <td style="text-align: center"><b>Tehvil Alan</b></td>
            </tr>
            <tr>
                <td style="text-align: center"><?php echo personel_details_full($details->aauth_id)['name'] ?></td>
                <td style="text-align: center"><?php

//                    if($details->fis_tur==2 || $details->fis_tur==1){
                    if($details->cari_pers_type==2){
                        echo personel_details_full($details->pers_id)['name'];
                    }
//                    elseif($details->fis_tur==3){
                        else {
                        echo customer_details($details->pers_id)['company'];
                    }


                    ?></td>
            </tr>

        </table>
    </footer>
</div>

</body>
</html>
