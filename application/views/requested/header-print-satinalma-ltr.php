<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 22.01.2020
 * Time: 15:23
 */
?>


<table class="mycos" width="100%">

    <tr>

        <td style="text-align: center; border: 1px solid gray;padding: 30px"  rowspan="2">
            <img src="https://muhasebe.makro2000.com.tr/userfiles/company/16058809601269056269.png?t=88" style="max-height:180px;max-width:100px;">
        </td>
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>SATIN ALMA FORMU</h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Talep Tarihi</td>
        <td><?php echo dateformat($invoice['olusturma_tarihi']) ?></td>
    </tr>
    <tr>
        <td>Proje Adı</td>
        <?php if(isset($invoice['proje_name'])){ ?>
            <td> <?php echo $invoice['proje_name'] ?></td>
        <?php } ?>
    </tr>
    <tr>
        <td>Bölüm Adı</td>
        <td><?php echo $invoice['bolum_adi'] ?></td>
    </tr>
    <tr>
        <td>Satın Alma Sorumlusu</td>
        <td><?php echo personel_details($invoice['satinalma_personeli']) ?></td>
    </tr>
    <tr>
        <td>Satın Alma Müdürü</td>
        <td><?php echo personel_details($invoice['satinalma_mudur_id']) ?></td>
    </tr>
</table>


<br/>

<table class="plist" cellpadding="0" cellspacing="0"  >


    <tr >
        <td width="5%" style="font-size:7px;padding: 5px;border: 1px solid gray;text-align: center">NO</td>
        <td width="8%" style="font-size:7px;border: 1px solid gray;text-align: center">ÜRÜN</td>
        <td width="7%" style="font-size:7px;border: 1px solid gray;text-align: center">AÇIKLAMA</td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">FİRMA </td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">FİRMA TELEFON </td>
        <td width="5%" style="font-size:7px;border: 1px solid gray;text-align: center">MİKTAR</td>
        <td width="5%" style="font-size:7px;border: 1px solid gray;text-align: center">BİRİM</td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">BİRİM FİYAT</td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">TUTAR</td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">TEKLİF TARİH/NO</td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">ÖDEME ŞEKLİ</td>
        <td width="10%" style="font-size:7px;border: 1px solid gray;text-align: center">ÖDEME TARİHİ</td>
    </tr>

</table>

<br>

