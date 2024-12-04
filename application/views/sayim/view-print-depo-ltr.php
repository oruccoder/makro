<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Purchase Order #<?php echo $invoice['tid'] ?></title>
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
            padding: 10pt 4pt 8pt 4pt;
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
    <table class="party">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php echo $this->lang->line('Supplier') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php  $loc=location($invoice['loc']); echo $loc['cname']; ?></strong><br>
                <?php echo
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] .'<br>'. $loc['country']. ' -  ' . $loc['postbox'] . '<br>'.$this->lang->line('Phone').': ' . $loc['phone'] . '<br> '.$this->lang->line('Email').': ' . $loc['email'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' .$loc['taxid'];
                ?>
            </td>

            <td>
                <?php echo '<strong>'.$invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'] . '<br>' . $invoice['country'] . '-' . $invoice['postbox'] . '<br>'.$this->lang->line('Phone').': ' . $invoice['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Item Image') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Item Name') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Product Code') ?>
            </td>


            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>

        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        foreach ($products as $row) {

            $cols = 3;

            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t+=$row['price']*$row['qty'];


            echo '<tr class="item' . $flag . '"> 
                            <td><img style="width: 10%" src="' . base_url() . 'userfiles/product/thumbnail/' .  urun_image($row['pid']) . '" >'. '</td>
                            <td>' . $row['product'] . '</td>
                              <td>' . $row['code'] . '</td>
							
                            <td style="width:12%;" >' . +$row['qty'].$row['unit'] . '</td>   ';

          
            if($row['product_des'])  { $cc=$cols+1; echo '<tr class="item' . $flag . ' descr"> 
                            <td colspan="'.$cc.'">' . $row['product_des'] . '<br>&nbsp;</td>
							
                        </tr>'; }
            $fill = !$fill;

        }

        if ($invoice['shipping'] > 0) { $cols++;}

        ?>


    </table>

</div>
</body>
</html>