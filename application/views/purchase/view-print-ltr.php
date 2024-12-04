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
            height: 212mm;
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
    <br>
    <br>

    <table class="party"  style="font-size: 12px">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('firma') ?></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="100%">
                <?php echo '<strong>'.$invoice['company'] . '</strong><br>';
                echo 'Yetkili Adı: '.$invoice['cname'] . '<br>';
                if ($invoice['company']) echo 'Adres: '.$invoice['company'] . ' ';
                echo $invoice['address'] . ' ' . $invoice['city'] . ', ' . $invoice['region'] . ' ' . $invoice['country'] . '-' . $invoice['postbox'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('voyn') . ': ' . $invoice['taxid'];
                ?>
                <?php
                if ($invoice['proje_adi']) echo  '<br><strong> Proje Adı: </strong>'.$invoice['proje_adi'] . '<br>';
                if ($invoice['proje_yetkili_adi']) echo  '<strong> Proje Yetkili Adı: </strong>'.$invoice['proje_yetkili_adi'] . '<br>';
                if ($invoice['proje_tel']) echo '<strong>Proje Yetkili Telefonu: </strong>'.$invoice['proje_tel'] . '<br>';
                if ($invoice['proje_adresi']) echo '<strong>Proje Adresi: </strong>'.$invoice['proje_adresi'];
                if ($invoice['proje_sehir']) echo  '<br> <strong>Proje Şehri: </strong>' . $invoice['proje_sehir'];
                ?>
            </td>

        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0"  style="font-size: 12px">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Item Name') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>
            <td>
                <?php echo $this->lang->line('paket_miktari') ?>
            </td>

            <?php if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>';

            if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>'; ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
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
                            <td>' . $row['product'] . '</td>
							<td style="width:12%;">' . amountExchange($row['price'],$invoice['multi']) . '</td>
                            <td style="width:12%;" >' . +$row['qty'].$row['unit'] . '</td>   ';
            $rulos=rulo_hesapla($row['pid'],$row['qty']);
            echo '<td>' . +$rulos . ' '.paketleme_tipi($row['pid']).' </td>';
            if ($invoice['tax'] > 0)  { $cols++; echo '<td style="width:16%;">' . amountExchange($row['totaltax'], $invoice['multi']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>'; }
            if ($invoice['discount'] > 0) {   $cols++; echo ' <td style="width:16%;">' . amountExchange($row['totaldiscount'], $invoice['multi']) . '</td>'; }
            echo '<td class="t_center">' . amountExchange($row['subtotal'], $invoice['multi']) . '</td>
                        </tr>';
           if($row['product_des'])  { $cc=$cols+1; echo '<tr class="item' . $flag . ' descr"> 
                            <td colspan="'.$cc.'">' . $row['product_des'] . '<br>&nbsp;</td>
							
                        </tr>'; }
            $fill = !$fill;
          
        }

  if ($invoice['shipping'] > 0) { $cols++;}

        ?>


    </table>
    <br>
    <table class="subtotal"  style="font-size: 12px">

       
        <tr>
            <td class="myco2" rowspan="<?php echo $cols ?>"><br><br><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])).'</strong></p><br><p>' . $this->lang->line('Total Amount') . ': ' . amountExchange($invoice['total'], $invoice['multi']) . '</p><br><p>' . $this->lang->line('Paid Amount') . ': ' . amountExchange($invoice['pamnt'], $invoice['multi']); ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountExchange($sub_t, $invoice['multi']); ?></td>
        </tr>
        <?php if ($invoice['tax'] > 0) {
            echo '<tr>        

            <td> ' . $this->lang->line('Total Tax') . ' :</td>

            <td>' . amountExchange($invoice['tax'], $invoice['multi']) . '</td>
        </tr>';
        }
        if ($invoice['discount'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Total Discount') . ':</td>

            <td>' . amountExchange($invoice['discount'], $invoice['multi']) . '</td>
        </tr>';

        }
		    if ($invoice['shipping'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Shipping') . ':</td>

            <td>' . amountExchange($invoice['shipping'], $invoice['multi']) . '</td>
        </tr>';

        }
        ?>
        <tr>


            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td><strong><?php $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;

    }
    echo amountExchange($rming, $invoice['multi']);
    echo '</strong></td>
		</tr>
		</table>
		<br>
		';?>
</div>
</body>
</html>