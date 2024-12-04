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
            height: 290mm;
            margin: auto;
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
            line-height: 10pt;
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
        $sub_t = 0;

        foreach ($products as $row) {
            $sub_t += $row['price'] * $row['qty'];
            echo '<tr>
                <th width="3%">' . $c . '</th>
                    <td width="54%">' . $row['product'] . '</td>                 
                     <td width="10%">' . +$row['qty'].' '.$row['unit'] . '</td>
                    <td width="10%">' . '% '.$row['fire'].'</td>
                    <td width="10%">' .$row['fire_quantity'].' '.$row['unit']. '</td>
                    <td width="13%">' .product_total_tuketim($row['pid'],$id).' '.$row['unit']. '</td>
                </tr>';


            $c++;
        } ?>

        </tbody>


    </table>
    <br>
   </div>
</div>
</body>
</html>