<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Forma 2</title>
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
            line-height: 12pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 11pt;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 3pt;
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
            line-height: 12pt;
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
            font-size: 12pt;
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

        .form2{
            border: 1px solid black;
        }


    </style>
</head>

<body>

<?php

$kur_degeri=para_birimi_id($invoice['para_birimi'])['rate'];
$carpim=$kur_degeri;
?>

<div class="invoice-box">


    <br>
    <table  style="font-size: 12px" class="party">
        <thead>
        <tr>
            <td>Sifarişçi: </td>
            <td><strong>
                    <?php if($invoice['invoice_type_id']==29){ ?>
                    <?php $loc=location(5);  echo $loc['cname']; ?></strong><br>
                <?php
                }
                else
                {
                    if($invoice['csd']!=0)
                    {
                        echo customer_details($invoice['csd'])['company'];
                    }
                }
                ?>

            </td>
            <td>
                Forma 2
            </td>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>Podratçı : </td>
            <td>
                <strong>
                    <?php if($invoice['invoice_type_id']==30)
                    { ?>
                    <?php $loc=location(5);  echo $loc['cname']; ?></strong>
                </br>
                <?php
                }
                else
                {
                    if($invoice['csd']!=0)
                    {
                        echo 'Fiziki Şexs'.' '.customer_details($invoice['csd'])['company'].customer_details($invoice['csd'])['taxid'];
                    }
                }
                ?>

            </td>
        </tr>


        <tr>
            <td>Forma2 No:</td>
            <td><?php echo $invoice['invoice_no'];?></td>
        </tr>
        <tr>
            <td>Muqavile No:</td>
            <td><?php echo $invoice['muqavele_no'];?></td>
        </tr>
        <tr>
            <td>Proje Adı:</td>
            <td><?php echo proje_name($invoice['proje_id']);?></td>
            <td style="text-align: right"><?php echo  dateformat($invoice['invoicedate'])?></td>
        </tr>
        <tr>
            <td>Not:</td>
            <td><?php echo $invoice['notes'];?></td>
        </tr>

        </tbody>
    </table>
    <table  style="font-size: 12px" class="plist form2" cellpadding="0" cellspacing="0">



        <?php $c = 1;
        $sub_t = 0;

        $line="<tr class='form2'>
            <td rowspan='2' class='form2' style='text-align: center;'>
               No
            </td>

            <td rowspan='2' class='form2' style='text-align: center;'>
               Görülmüş İşler
            </td>
               <td rowspan='2' class='form2' style='text-align: center;'>
               Aşama
            </td>

            <td rowspan='2' class='form2' style='text-align: center;'>
              Ölçü Vehidi
            </td>
            <td class='form2' rowspan='1' colspan='3' style='text-align: center;'>
                Yerine Getirilmiş İşler</td>
            </tr>
            <tr>
            <td class='form2' style='text-align: center;'>
              Miqdari
            </td>
            <td class='form2' style='text-align: center;'>
                Qiymeti
            </td>
            <td class='form2' style='text-align: center;'>
                Cemi
            </td>

        </tr>";

        foreach ($bolumler as $blm)
        {
            $totals=0;
            $f_totals=0;
            echo "<tr><td colspan='6' style='text-align: center;' class='form2'><b>$blm->name</b></td></tr>";

            echo $line;

            foreach ($products as $row) {
                $desc = '';
                if($row['item_desc']!='undefined'){
                    $desc = '<span style="font-size: 9px">('.$row['item_desc'].')</span>';
                }
                $f_totals=$f_totals+$row['subtotal'];
                if($blm->id==$row['id'])
                {
                    $totals=$totals+$row['subtotal'];

                    echo '<tr>
                                <td class="form2" style="text-align: center">' . $c . '</td>
                                <td class="form2">' . $row['product'].' '.$desc.'</td>
                                <td class="form2">' . $row['asama_name'].'</td>
                                  <td class="form2">'.units_($row['unit'])['name'] . '</td>
                                    <td class="form2">' . +$row['qty']. '</td>
                                 <td class="form2" style="text-align: right;">' . amountFormat($row['price']*$carpim) . '</td>
                                 <td class="form2"  style="text-align: right;">' . amountFormat($row['subtotal']*$carpim) . '</td>
                            </tr>';


                    $c++;
                }

            }

            echo '<tr>
                    <td colspan="2" class="form2" style="text-align: right;">Cemi</td>
                    <td colspan="4" class="form2" style="text-align: right;">'.amountFormat($totals**$carpim).'</td>
                    </tr>';

        }

        ?>


    </table>
    <br>
    <?php
    $tax_status='';
    if($invoice['taxstatus']=='yes'){
        $tax_status = 'Fiyatlar ƏDV Dahildir.';
    }
    elseif($invoice['taxstatus']=='no') {
        $tax_status = 'Fiyatlar ƏDV Hariçtir.';
    }
    ?>
    <div style="margin-left: 60%">
        <table class="subtotal"  style="font-size: 12px">


            <tr>


                <td>Yekun Cemi</td>

                <td><strong><?php
                        echo amountFormat($f_totals*$carpim );
                        echo '</strong></td>
            </tr>
            <tr>
            <td>ƏDV </td><td>'.$tax_status.'</td>
</tr>
            '?>

                        <?php echo '
            </table>';
                        ?>
    </div>


    <h6 style="text-align: center">İşlem Geçmişi</h6>
    <table class="table subtotal" style="font-size: 8px;margin: 2px !important;">
        <tr>
            <td>Ödeme Tarihi</td>
            <td>Not</td>
            <td>Ödeme Tipi</td>
            <td>İşlem Tipi</td>
            <td>Ödeme Tutarı</td>
        </tr>
        <?php
        $odeme_total = 0;
        $teminat = 0;
        $ceza_total = 0;
        $prim = 0;
        $temiat_odeme = 0;
        foreach (forma_2_pay_history($_GET['id']) as  $value){
            if($value->invoice_type_id == 55) // Teminat
            {
                $teminat+=$value->total_transaction;
            }
            else if($value->invoice_type_id == 54 || $value->invoice_type_id == 65) // Ceza
            {
                $ceza_total+=$value->total_transaction;
            }
            else if($value->invoice_type_id == 57) // Prim
            {
                $prim+=$value->total_transaction;
            }
            else if($value->invoice_type_id == 61) // Teminat Ödemesi
            {
                $temiat_odeme+=$value->total_transaction;
            }
            else{ // Ödeme
                $odeme_total+=$value->total_transaction;
            }
            ?>
            <tr>
                <td><?php echo $value->invoicedate ?></td>
                <td><?php echo $value->notes ?></td>
                <td><?php echo account_type_sorgu($value->method) ?></td>
                <td><?php echo $value->invoice_type_desc; ?></td>
                <td><?php echo amountFormat($value->total_transaction) ?></td>
            </tr>
            <?

        } ?>
        <?php
        $total_cikan = $odeme_total  +$teminat + $ceza_total;
        $kalan = ($f_totals*$carpim)-($total_cikan);
        $toplam_hakedis = ($f_totals*$carpim) +($prim*$carpim);
        $teminat=$teminat-$temiat_odeme;
        ?>
        <tr>
            <td colspan="4" style="text-align: right">Forma2 Toplamı</td>
            <td><b><?php echo amountFormat($f_totals*$carpim )?></b></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right">Prim Toplamı</td>
            <td><b><?php echo amountFormat($prim*$carpim )?></b></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right">Toplam Hakediş</td>
            <td><b><?php echo amountFormat($toplam_hakedis )?></b></td>
        </tr>
        <tr>

            <td colspan="4" style="text-align: right">Ödeme Toplamı</td>
            <td><b><?php echo amountFormat($odeme_total )?></b></td>
        </tr>
        <tr>

            <td colspan="4" style="text-align: right">Kesinti Toplamı</td>
            <td><b><?php echo amountFormat($ceza_total )?></b></td>
        </tr>
        <tr>

            <td colspan="4" style="text-align: right">Teminat Toplamı</td>
            <td><b><?php echo amountFormat($teminat )?></b></td>
        </tr>

        <tr>
            <td colspan="4" style="text-align: right">Kalan</td>
            <td><b><?php echo amountFormat($kalan); ?></b></td>
        </tr>

    </table>

    <table  style="font-size: 10px" class="party">
        <thead>
        <tr>
            <td>Sifarişçi :<br><strong>
                    <?php if($invoice['invoice_type_id']==29){ ?>
                    <?php $loc=location(5);  echo $loc['cname']; ?></strong><br>
                <?php
                }
                else
                {
                    if($invoice['csd']!=0)
                    {
                        echo customer_details($invoice['csd'])['company'].customer_details($invoice['csd'])['taxid'];
                    }
                }
                ?>

                <b>PROJE SORUMLUSU</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>PROJE MÜDÜRÜ</b> <br>
                <!--                --><?php //echo personel_details($invoice['payer'])?>


                <!--                --><?php //echo personel_details($invoice['payer'])?>
                MILAD KADKHODAEI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo personel_details($invoice['proje_sorumlu_id']) ?>
            </td>
            <td style="text-align: right;">Podratçı :<br>
                <strong>
                    <?php if($invoice['invoice_type_id']==30){ ?>
                    <?php $loc=location(5);  echo $loc['cname']; ?></strong><br>
                <?php
                }
                else
                {
                    $v = (customer_details($invoice['csd'])['taxid'])?customer_details($invoice['csd'])['taxid']:'';
                    if($invoice['csd']!=0)
                    {

                        echo customer_details($invoice['csd'])['company'].$v;
                    }
                    else {
                        echo customer_details($invoice['csd'])['company'].$v;
                    }
                }


                ?>
            </td>
        </tr>
        </thead>
        <tbody>



    </table>

</div>

</body>
</html>
