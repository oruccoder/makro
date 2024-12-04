<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sayım Yazdırma #<?php echo $invoice['tid'] ?></title>
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
        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>#</td>
            <td>
                <?php echo $this->lang->line('Item Name') ?>
            </td>

            <td>
                <?php echo $this->lang->line('Sayim_Qty') ?>
            </td>
            <td>
                <?php echo $this->lang->line('stok_miktari') ?>
            </td>
            <td>
                <?php echo $this->lang->line('kalan_stok') ?>
            </td>


        </tr>

        <?php $c = 1;


        foreach ($products as $row) {

            $stok_miktari=toplam_rulo_adet($row['pid'])['toplam_rulo'].' '.paketleme_tipi($row['pid']);
            $style='';
            $stok_miktari_kalan= floatval($stok_miktari)-floatval($row['qty']);
            if($stok_miktari_kalan<0)
            {
                $style='style="background-color: #6a90d4;color: white;"';
            }
            else if($stok_miktari_kalan>0)
            {


                $style='style="background-color: #ad5656;color: white;"';
            }
            else if($stok_miktari_kalan==0)
            {
                $style='';
            }

            echo '<tr>
                                    <th '.$style.' scope="row">' . $c . '</th>
                                    <td '.$style.'>  ' . $row['product'] . '</td> 
                                     <td  '.$style.' >' . +$row['qty'].' ' .paketleme_tipi($row['pid']). '</td>
                                     <td '.$style.'>  ' . $stok_miktari . '</td>
                                     <td '.$style.'>  ' . $stok_miktari_kalan.' ' .paketleme_tipi($row['pid']).  '</td>
                              
                        </tr>';


            $c++;
        } ?>


    </table>

</div>
</body>
</html>