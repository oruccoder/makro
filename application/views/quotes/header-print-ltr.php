<table style="text-align: center">
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location(5);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                    style="max-height:80px;max-width:150px;padding-top: 5px"><br>
                Makro 2000 Eğitim Teknolojileri İnşaat Taahhüt<br>
                İç ve Dış Ticaret Anonim" Şirketinin<br>
                Azərbaycan Respublikasındaki Filialı<br>
                VÖEN : 1800732691 Baku / Azerbaijan<br>
                Phone: +994 12 597 48 18 Mail : info@makro2000.com.tr<br><br>
                <h3><b>PROFORMA INVOICE</b></h3>

            </td>


        </tr>
    </table>

<div style="margin: auto;padding: 4mm;">
    <table class="subtotals" style="font-size: 13px;text-align: center;">
        <tr>
            <td  style="width:14%" rowspan="4">Firma / Company</td>
            <td  style="width:36%"  rowspan="4">
                <?php echo $invoice['company'] . '<br>';
                echo $invoice['cname'] . '<br>';
                if ($invoice['phone']) echo $invoice['phone'];
                ?>

            </td>
        </tr>
        <tr>
            <td  style="width:50%" rowspan="1">Fatura No / Invoice<br><?php echo $invoice['tid']; ?></td>

        </tr>
        <tr>
            <td  style="width:50%" rowspan="1">Tarih / Date<br><?php echo dateformat($invoice['invoicedate']); ?>
            </td>


        </tr>


    </table>
</div>

