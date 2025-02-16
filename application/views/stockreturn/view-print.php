<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Purchase Order #<?php echo $invoice['tid'] ?></title>

    <style>
        body {
            color: #2B2000;
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;

            font-size: 16pt;
            line-height: 24pt;

            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: 17pt;
            text-align: left;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
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
            margin-right: 105pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 5pt 4pt;
            vertical-align: top;

        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        .invoice-box table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

        .invoice-box table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #fff;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 500pt;
        }

        .myco2 {
            width: 290pt;
        }

        .myw {
            width: 180pt;
            font-size: 14pt;
            line-height: 30pt;
        }

        .mfill {
            background-color: #eee;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body style="font-family: Helvetica;">
<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                     style="max-width:260px;">
            </td>
            <td>

            </td>
            <td class="myw"><h4 ><?php

                       switch($invoice['i_class'])
                                {
                                    case 0 : $type_i=$this->lang->line('Stock Return');
                                    break;
                                    case 1 :$type_i=$this->lang->line('Customer').' '.$this->lang->line('Stock Return');
                                    break;
                                    case 2  :$type_i=$this->lang->line('Credit Note');
                                    break;
                                }


                    echo $type_i ?></h4>
                <?php echo $this->lang->line('Order') ?>
                : <?php echo  prefix(4). $invoice['tid'] . '<br>
                                '.$this->lang->line('Order Date').' &nbsp;: ' . $invoice['invoicedate'] . '<br>
                                 '.$this->lang->line('Due Date').'  : ' . $invoice['invoiceduedate'] . ''; ?>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php if($invoice['i_class']) {
echo $this->lang->line('Customer');
                }
                else {
                    echo $this->lang->line('Supplier');
                    }
 ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php echo $loc['cname']; ?></strong><br>
                <?php echo
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] .'<br>'. $loc['country']. ' -  ' . $loc['postbox'] . '<br>'.$this->lang->line('Phone').': ' . $loc['phone'] . '<br> '.$this->lang->line('Email').': ' . $loc['email'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' .$loc['taxid'];
                ?>
            </td>

            <td>
                <?php echo $invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $invoice['city'] . '<br>Phone: ' . $invoice['phone'] . '<br>Email: ' . $invoice['email'];

                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Description') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>
            <?php if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>'; ?>
            <td>
                <?php echo $this->lang->line('Discount') ?>
            </td>
            <td>
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>

        <?php $i = 1;
        $fill = false;
        $sub_t=0;
        foreach ($products as $row) {
            $sub_t+=$row['price']*$row['qty'];
            $cols = 3;
if ($invoice['discount'] > 0) {   $cols++; }   if ($invoice['shipping'] > 0) { $cols++; }
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            echo '<tr class="item' . $flag . '"> 
                            <td>' . $row['product'] . '</td>
							<td style="width:12%;">' . amountFormat($row['price']) . '</td>
                            <td style="width:12%;">' . +$row['qty'].$row['unit'] . '</td>   ';
            if ($invoice['tax'] > 0) { echo '<td style="width:16%;">' . amountFormat($row['totaltax']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>';
            $cols++;
            }
            echo ' <td style="width:16%;">' . amountFormat($row['totaldiscount']) . '</td>
                            <td>' . amountFormat($row['subtotal']) . '</td>
                        </tr>';
            if($row['product_des'])  { $cols++; echo '<tr class="item' . $flag . '"> 
                            <td colspan="'.$cols.'">' . $row['product_des'] . '<br>&nbsp;</td>
							
                        </tr>'; }
            $fill = !$fill;
            $i++;
        }

        ?>


    </table>
    <table class="subtotal">
        <thead>
        <tbody>
        <tr>
            <td class="myco2" rowspan="<?php echo $cols ?>"><br><br><br>
                <p><?php echo '<strong>Status: ' . strtoupper($invoice['status']) . '</strong></p><br><p>Total Amount: ' . amountFormat($invoice['total']) . '</p><br><p>Paid Amount: ' . amountFormat($invoice['pamnt']); ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountFormat($sub_t); ?></td>
        </tr>
        <?php if ($invoice['tax'] > 0) {
            echo '<tr>        

            <td> ' . $this->lang->line('Total Tax') . ' :</td>

            <td>' . amountFormat($invoice['tax']) . '</td>
        </tr>';
        } 		if ($invoice['discount'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Total Discount') . ':</td>

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
            <td><?php echo $this->lang->line('Amount Due') ?> :</td>
            <td><strong><?php $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;
    }
    echo amountFormat($rming);
    echo '</strong></td>
		</tr></tbody>
		</table><div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . base_url('userfiles/employee_sign/' . $employee['sign']) . '" width="160" height="50" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div><div class="sign3">' . user_role($employee['roleid']) . '</div> <br><div class="terms">' . $invoice['notes'] . '<hr><strong>' . $this->lang->line('Terms') . ':</strong><br>';

    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?></div>
</div>
</body>
</html>
