<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Statement</title>

    <style>
        body {
            color: #2B2000;
            font-family: Arial;
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 1mm;
            border: 0;

            font-size: 12pt;
            line-height:12pt;

            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: 15pt;
            text-align: left;
        }

        .plist tr td {
            line-height: 8pt;
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
            margin-right: 115pt;
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

<body <?php if(LTR=='rtl') echo'dir="rtl"'; ?>>
<div class="invoice-box">
    <table >
        <tr>
            <td class="myco" style="text-align: center">
                <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                     style="max-width:190px;">
            </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php echo $this->lang->line('Customer') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><h3><?php echo $this->config->item('ctitle'); ?></h3>
                <?php echo
                    $this->config->item('address') . '<br>' . $this->config->item('city') . ',' . $this->config->item('country') . '<br>Phone: ' . $this->config->item('phone') . '<br> Email: ' . $this->config->item('email'); ?>
            </td>

            <td>
                <?php echo $customer['name'] . '</strong><br>' . $customer['address'] . '<br>' . $customer['city'] . '<br>Phone: ' . $customer['phone'] . '<br>Email: ' . $customer['email']; ?>
                <?php if($proje_id!=0)
                {
                    echo "<br>Proje Adı : <b>".proje_name($proje_id).'</b>';
                } ?>
            </td>
        </tr>
        </tbody>
    </table>
    <style>
        .plist tr td
        {
            border: 1px solid #bdbdbd;
            font-size: 12px;
        }

    </style>
    <table class="plist" cellpadding="0" cellspacing="0" >

        <tr>

            <td><strong><?php echo $this->lang->line('Date') ?></strong></td>
            <td><strong><?php echo $this->lang->line('transaction_type') ?></strong></td>
            <td class="no-sort"><strong><?php echo $this->lang->line('borc') ?></strong></td>
            <td class="no-sort"><strong><?php echo $this->lang->line('alacak') ?></strong></td>
            <td class="no-sort"><strong><?php echo $this->lang->line('bakiye') ?></strong></td>


        </tr>

        <?php
        $fill = false;
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $carpim=1;
        $birim=0;
        foreach ($list as $invoices) {

            if($para_biri_s!='tumu')
            {
                $carpim=1;
                $birim=$invoices['para_birimi'];
            }
            else
            {
                $carpim=$invoices['kur_degeri'];
                $birim=1;
            }


            $borc=floatval($invoices['borc'])*floatval($carpim);
            $alacak=floatval($invoices['alacak'])*floatval($carpim);
            if ($invoices['transactions'] == 'expense') {
                $alacak_toplam += floatval($invoices['total'])*floatval($carpim);
            } elseif ($invoices['transactions']  == 'income') {
                $borc_toplam += floatval($invoices['total'])*floatval($carpim);
            }
            $bakiye += ($borc-$alacak);


            echo '<tr class="item">
            <td>' . dateformat($invoices['invoicedate']) . '</td>
            <td>' . $invoices['description'] . '</td>
            <td>' . amountFormat($borc,$birim) . '</td>
            <td>' . amountFormat($alacak,$birim) . '</td>
            <td>' .amountFormat(abs($bakiye),$birim).($bakiye>0?" (B)":" (A)"). '</td></tr>';
            $fill = !$fill;
        }
        ?>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><?php echo amountFormat($borc_toplam,$birim) ?></td>
                <td><?php echo amountFormat($alacak_toplam,$birim) ?></td>
                <td><?php echo amountFormat(abs($bakiye),$birim).($bakiye>0?" (B)":" (A)") ?></td>
            </tr>
        </tfoot>
    </table>


</div>
</body>
</html>
