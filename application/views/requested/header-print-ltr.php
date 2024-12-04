
<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 22.01.2020
 * Time: 15:23
 */
?>


<table class="mycos" width="100%"  >

    <tr>

        <td style="text-align: center; border: 1px solid gray;padding: 30px"  rowspan="2">
            <img src="https://muhasebe.makro2000.com.tr/userfiles/company/16058809601269056269.png?t=88" style="max-height:180px;max-width:100px;">
        </td>
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>MALZEME TALEP FORMU</h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Talep Tarihi</td>
        <td><?php echo dateformat($invoice['olusturma_tarihi']).' - '.$invoice['talep_no'] ?></td>
    </tr>
    <tr>
        <td>Proje Adı</td>
        <?php if(isset($invoice['proje_name'])){ ?>
            <td><b> <?php echo $invoice['proje_name'] ?></b></td>
        <?php } ?>
    </tr>
    <tr>
        <td>Proje Bölümü</td>
        <?php if(isset($invoice['proje_bolum_name'])){ ?>
            <td><b> <?php echo $invoice['proje_bolum_name'] ?></b></td>
        <?php } ?>
    </tr>
    <tr>
        <td>Talep Eden</td>
        <td><?php echo personel_details($invoice['talep_eden_pers_id']) ?></td>
    </tr>
    <tr>
        <td>Talep Eden Telefon</td>
        <td> <?php echo $invoice['tel'].' '.$invoice['email']; ?></td>
    </tr>
    <tr>
        <td>Gönderme Şekli</td>
        <td><?php echo $invoice['gonderme_sekli'] ?></td>
    </tr>
	<tr>
        <td>Açıklama</td>
        <td><?php echo $invoice['description'] ?></td>
    </tr>
    <tr>
        <td>Teslim Alacak Kişi</td>
        <td><?php echo personel_details($invoice['bolum_mudur_id']) ?></td>
    </tr>
</table>


<br/>

<table class="plist" cellpadding="0" cellspacing="0"  >


    <tr >
        <td width="10%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center">No</td>
        <td width="40%" style="font-size:10px;border: 1px solid gray;text-align: center">Ürün Adı</td>
        <td width="40%" style="font-size:10px;border: 1px solid gray;text-align: center">Açıklama</td>
        <td width="10%" style="font-size:10px;border: 1px solid gray;text-align: center">Miktar-Birim</td>
    </tr>

</table>

<br>

