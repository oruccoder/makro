<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Teklif Yazdır #<?php echo $invoice['talep_no'] ?></title>
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
            <td><?php echo $this->lang->line('Customer') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <?php echo '<strong>'.$firma['name'] . '</strong><br>';
                if ($firma['company']) echo $firma['company'] . '<br>';
                echo $firma['address'] . '<br>' . $firma['city'] . ', ' . $firma['region'] . '<br>' . $firma['country'] . '-' . $firma['postbox'] . '<br>'.$this->lang->line('Phone').': ' . $firma['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $firma['email'];
                ?>
            </td>

        </tbody>
    </table>
    <br/>
    <table  style="font-size: 12px" class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Description') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
               KDV Durumu
            </td>
            <td>
              Toplam
            </td>
            <td>
              Ödeme
            </td>
        </tr>

        <?php $c = 1;
        $sub_t = 0;

        foreach ($products as $row) {
            $sub_t += $row['subtotal'];
            $kdv_durum='KDV Hariç';
            if($row['kdv_dahil_haric']==1)
            {
                $kdv_durum='KDV Dahil';
            }
            echo '<tr>
                                <td>' . $row['product_name'] . '</td>
                                <td>' . +$row['qty'].' '.$row['unit'] . '</td>
                                <td>' . amountFormat($row['price'],$invoice['para_birimi']) . '</td>
                                <td>' .$kdv_durum . '</td>
                                <td>' . amountFormat($row['subtotal'],$invoice['para_birimi']) . '</td>
                            </tr>';


        } ?>


    </table>
    <br>
    <div style="margin-left: 60%">
        <table class="subtotal"  style="font-size: 12px">


            <tr class="f_summary">


                <td>Net Toplam</td>

                <td><?php echo  amountFormat($sub_t,$invoice['para_birimi']) ?></td>


            </tr>
            <tr>
                <td>İndirim</td>

                <td><?php echo  amountFormat($dis,$invoice['para_birimi']) ?></td>
            </tr>
            <tr>
                <td>Genel Toplam</td>

                <td><?php $kalan = $sub_t-floatval($dis); echo  amountFormat($kalan,$invoice['para_birimi']) ?></td>
            </tr>

            <?php echo '
            </table>';
            ?>
    </div>



    <?php echo '<div class="terms">' . $invoice['description'] . '<br>';


    ?>
</div>

</body>
</html>
