<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 29.01.2020
 * Time: 16:15
 */
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Fatura Yazdır #<?php echo $invoice['invoice_no'] ?></title>
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
            padding: 0;
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
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>
            <?php if(isset($invoice['name'])){ ?>
            <td><?php echo $this->lang->line('Customer') ?>:</td>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php $loc=location($invoice['loc']);  echo $loc['cname']; ?></strong><br>
                <?php echo
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] .'<br>'. $loc['country']. ' -  ' . $loc['postbox'] . '<br>'.$this->lang->line('Phone').': ' . $loc['phone'] . '<br> '.$this->lang->line('Email').': ' . $loc['email'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' .$loc['taxid'];
                ?>
            </td>

            <?php if(isset($invoice['name'])){ ?>
            <td>
                <?php echo '<strong>'.$invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'] . '<br>' . $invoice['country'] . '-' . $invoice['postbox'] . '<br>'.$this->lang->line('Phone').': ' . $invoice['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
            </td>
        <?php } ?>

        </tbody>
    </table>
    <table  style="font-size: 12px" class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Date') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Account') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Debit') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Credit') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Method') ?>
            </td>
            <td>
                <?php echo $this->lang->line('type') ?>
            </td>

        </tr>

        <?php $c = 1;

        $last=0;
        foreach ($products as $row) {

            $last+=$row['total']*$row['kur_degeri'];


            echo '<tr>
                                <td>' . dateformat($row['date']) . '</td>
                                <td>' . $row['account'] . '</td>
                                <td>' . amountFormat($row['debit'],$row['int_pb']) . '</td>
                                <td>' . amountFormat($row['credit'],$row['int_pb']) . '</td>
                               <td>' .account_type_sorgu($row['method']). '</td>
                               <td>' .$row['invoice_type_desc']. '</td>
                            </tr>';


        } ?>


    </table>
    <br>
    <?php if (count($products)>0){ ?>
    <div style="margin-left: 60%">
        <table class="subtotal"  style="font-size: 12px">


            <tr class="f_summary">


                <td><?php echo $this->lang->line('SubTotal') ?>:</td>

                <td><?php echo  amountFormat($invoice['subtotal'],$invoice['para_birimi']) ?></td>
            </tr>
            <?php if ($invoice['tax'] > 0) {
                echo '<tr>

                <td> ' . $this->lang->line('Total Tax') . ' :</td>

                <td>' .  amountFormat($invoice['tax'],$invoice['para_birimi']) . '</td>
            </tr>';
            }
            if ($invoice['discount'] > 0) {
                echo '<tr>


                <td>' . $this->lang->line('Total Discount') . ':</td>

                <td>' .  amountFormat($invoice['discount'],$invoice['para_birimi']). '</td>
            </tr>';

            }

            ?>
            <tr>


                <td><?php echo $this->lang->line('Grand Total') ?>:</td>

                <td><strong><?php
                        echo amountFormat($invoice['total'],$invoice['para_birimi'] );
                        echo '</strong></td>
            </tr>
            '?>
            <tr class="bg-grey bg-lighten-4">
                <td class="text-bold-800"><?php echo $this->lang->line('azn_total') ?></td>
                <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                    $rming = $invoice['total']*$invoice['kur_degeri'];

                    echo ' <span >' . amountFormat($rming,1) . '</span></strong>'; ?></td>

            </tr>
<!--            <tr class="bg-grey bg-lighten-4">-->
<!--                <td class="text-bold-800">--><?php //echo $this->lang->line('kur_degeri') ?><!--</td>-->
<!--                <td class="text-bold-800 text-xs-right"> --><?php
//                    $kur_degeri = $invoice['kur_degeri'];
//
//                    echo ' <span >' . amountFormat($kur_degeri,1) . '</span></strong>'; ?><!--</td>-->
<!--            </tr>-->
<!---->
<!--            <tr class="bg-grey bg-lighten-4">-->
<!--                <td class="text-bold-800">--><?php //echo $this->lang->line('alinan_total') ?><!--</td>-->
<!--                <td class="text-bold-800 text-xs-right"> --><?php
//
//
//
//
//                    echo ' <span >' . amountFormat($last,1) . '</span></strong>'; ?><!--</td>-->
<!--            </tr>-->
<!--            <tr class="bg-grey bg-lighten-4">-->
<!--                <td class="text-bold-800">--><?php //echo $this->lang->line('kalan_total') ?><!--</td>-->
<!--                <td class="text-bold-800 text-xs-right"> --><?php
//
//                    if($_GET['tip']==1)
//                    {
//                        $kalan_tutar=($invoice['total']*$invoice['kur_degeri'])-$last;
//                    }
//                    else
//                        {
//                            $kalan_tutar=($invoice['tax']*$invoice['kur_degeri'])-$last;
//                        }
//
//
//                    echo ' <span >' . amountFormat($kalan_tutar,1) . '</span></strong>'; ?><!--</td>-->
<!--            </tr>-->
            <?php echo '
            </table>';
            ?>
    </div>
    <?php } ?>



    <?php echo '<div class="terms">' . $invoice['notes'] . '<br>';


    ?>
</div>

</body>
</html>
