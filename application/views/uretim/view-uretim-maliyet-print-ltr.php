<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 14.01.2020
 * Time: 16:58
 */
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Üretim Reçetesi #<?php echo $invoice['id'] ?></title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }


        .invoice-box {
            width: 210mm;
            height: 310mm;
            margin: auto;
            border: 0;
            font-size: 8pt;
            line-height: 8pt;
            color: #000;

        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }


        .plist tr td {
            line-height: 2pt;
            font-size: 9pt;




        }
        .plist tr
        {
            border: 1px solid #ddd;
        }
        .subtotal {
            page-break-inside:avoid;
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
            padding: 8pt 2pt 8pt 4pt;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 9pt;
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
            width: 400pt;
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

    <table class="plist" cellpadding="0" cellspacing="0">
        <tbody>
        <?php $c = 1;
        $d=1;
        $sub_t = 0;
        $sub_t2=0;

        foreach ($products as $row) {

           $total_price= floatval( $row['quantity_2'])*floatval($row['alis_fiyati']);
            $sub_t+=$total_price;
            echo '<tr>
                <th width="5%" >' . $c . '</th>
                    <td width="15%">' . product_full_details($row['pid'])['product_code'] . '</td>                 
                    <td width="46%">' . $row['name'] . '</td>                 
                     <td width="10%">' . $row['quantity_2'] . '</td>
                     <td width="10%" >' .product_unit($row['pid']) . '</td>
                    <td width="10%">'.$row['alis_fiyati'].'</td>
                    <td >' .round($total_price,3).'</td>
                </tr>';


            $c++;
        } ?>
        <tr>

            <th colspan="6">Cemi Meterial</th>
            <th><?php echo round($sub_t,3);?></th>
        </tr>

        <?php  foreach ($uretim_maliyet as $row) {

            $total_price= floatval( 1)*floatval($row['alis_fiyati']);
            $sub_t2+=$total_price;
            echo '<tr>
                <th width="5%" >' . $d . '</th>
                    <td width="15%">' . $row['id'] . '</td>                 
                    <td width="46%">' . $row['name'] . '</td>                 
                     <td>1</td>
                     <td>Ad</td>
                    <td>'.$row['alis_fiyati'].'</td>
                    <td>' .round($total_price,3).'</td>
                </tr>';


            $d++;
        } ?>

        <tr>

            <th colspan="6">Cemi</th>
            <th><?php echo round($sub_t+$sub_t2,3);?></th>
        </tr>


        </tbody>


    </table>
    <br>
</div>
</div>
</body>
</html>
