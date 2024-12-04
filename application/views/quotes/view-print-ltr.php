<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Teklif Yazdır #<?php echo $invoice['tid'] ?></title>
    <style>	
        body {
            color: #2B2000;
			font-family: 'Helvetica';						
        }
        .invoice-box {
            width: 210mm;
            height: 217mm;
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
			border: 1px solid #1d1d1d;
        }

        .subtotals tr td {
            line-height: 10pt;
		    padding: 6pt;
        }

		.subtotals tr td {
			border: 2px solid #1d1d1d;
        }

        .headers tr td {
            line-height: 10pt;
		    padding: 6pt;
        }

		.headers tr td {
			border: none;
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
            border: 1px solid #1d1d1d;
        }

        table tr.b_class td{
            border-bottom: 1px solid #1d1d1d;
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

	  <br/>
    <table class="plist" cellpadding="0" cellspacing="0" style="font-size: 12px">


        <tr class="heading">
            <td>
               No
            </td>
            <td>
                <?php echo $this->lang->line('quo_item_name') ?>
            </td>

            <td>
                <?php echo $this->lang->line('quo_qty') ?>
            </td>
            <td>
                <?php echo $this->lang->line('quo_unit') ?>
            </td>
            <td>
                <?php echo $this->lang->line('quo_price') ?>
            </td>

            <td>
                <?php echo $this->lang->line('quo_sub_total') ?>
            </td>
        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        $i=1;
        foreach ($products as $row) {
            $sub_t+=$row['price']*$row['qty'];

            echo '<tr class="item"> 
                            <td>' . $i  . '</td>
                            <td>' . product_cat($row['pid']).  '<br>'.product_desc($row['pid']).'</td>
                            <td style="width:12%;">' . $row['qty']. '</td>   
                            <td style="width:12%;">' .units_($row['unit'])['name'] . '</td>   
                            <td style="width:12%;">' . amountExchange($row['price'],$invoice['multi'],$invoice['loc']) . '</td>';

                           echo '<td>' . amountExchange($row['subtotal'],$invoice['multi'],$invoice['loc']) . '</td>
                        </tr>';

            $i++;

        }
        ?>


    </table>


    <table class="subtotal" style="font-size: 16px;font-weight: bold;">
        <thead>
        <tbody>
        <tr>
            <td class="myco2"  rowspan="4" colspan="4"></td>
        </tr>

        <tr>


            <td ><?php echo $this->lang->line('quo_toplam') ?></td>

            <td ><?php echo amountExchange($sub_t,$invoice['multi'],$invoice['loc']); ?></td>
        </tr>
      <?php

		if ($invoice['discount'] > 0) {

            if($invoice['format_discount']=='%')
            {
                $fd='%';
                $rate=intval($invoice['discount_rate']);
            }
            else
                {
                    $fd='(Sabit)';
                    $rate='';
                }
                echo '<tr>


            <td>' . $this->lang->line('quo_dis') .$fd.$rate. '</td>

            <td>' . amountExchange($invoice['discount'],$invoice['multi'],$invoice['loc']) . '</td>
        </tr>';

        }
		    if ($invoice['shipping'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Shipping') . ':</td>

            <td>' . amountExchange($invoice['shipping'],$invoice['multi'],$invoice['loc']) . '</td>
        </tr>';

        }

		?>
        <tr>


            <td><?php echo $this->lang->line('quo_total') ?> </td>

            <td><strong><?php
                    $total=floatval($sub_t)-floatval($invoice['discount']);
    echo amountExchange($total,$invoice['multi'],$invoice['loc']);
    echo '</strong></td>
		</tr></tbody>
		</table><br>';


    ?>
                    <table class="subtotal">

                        <tr>
                            <td>Ödeme Şekli / Payment:</td>
                            <td><?php echo $invoice['terms'];?></td>
                        </tr>
                        <tr>

                            <td>Not / Note:</td>
                            <td><?php echo $invoice['notes']; ?></td>
                        </tr>
                        <tr>
                            <td>Geçerlilik Tarihi / Validity Period:</td>
                            <td><?php echo dateformat($invoice['invoiceduedate']); ?></td>
                        </tr>
                        <tr>
                            <td>Detaylar / Details:</td>
                            <td><?php echo $invoice['proposal']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->lang->line('quo_teslimat') ?>:</td>
                            <td><?php echo $invoice['teslimat']; ?></td>
                        </tr>
                        <tr>
                            <td>Müşteri Temsilciniz:</td>
                            <td><?php echo personel_details_full($invoice['eid'])['name'] ?></td>
                        </tr>
                    </table>

</div>




</div>
</body>
</html>
