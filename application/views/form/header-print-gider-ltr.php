
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>GİDER TALEP FORMU</h2></td>
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
        <td>Proje Bölüm Adı</td>
        <td><?php echo $invoice['proje_bolum_name'] ?></td>
    </tr>
    <tr>
        <td>Talep Eden</td>
        <td><?php
            $pers_cari='';
            $no='';
            if($invoice['cari_pers']==1)
            {
                $pers_cari=personel_details($invoice['talep_eden_pers_id']);
                $no = personel_detailsa($invoice['talep_eden_pers_id'])['phone'];
            }
            else {
                $pers_cari=customer_details($invoice['talep_eden_pers_id'])['company'];
                $no = customer_details($invoice['talep_eden_pers_id'])['phone'];
            }
            echo $pers_cari ?></td>
    </tr>
    <tr>
        <td>Talep No</td>
        <td> <?php echo $invoice['talep_no']; ?></td>
    </tr>


</table>


<br/>

<table class="plist" cellpadding="0" cellspacing="0"  >


    <tr >
        <td width="10%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center">No</td>
        <td width="40%" style="font-size:10px;border: 1px solid gray;text-align: center">Ürün Adı</td>
        <td width="40%" style="font-size:10px;border: 1px solid gray;text-align: center">Açıklama</td>
        <td width="10%" style="font-size:10px;border: 1px solid gray;text-align: center">Miktar-Birim</td>
        <td width="10%" style="font-size:10px;border: 1px solid gray;text-align: center">Birim Fiyatı</td>
        <td width="10%" style="font-size:10px;border: 1px solid gray;text-align: center">Birim Toplam</td>
    </tr>

</table>

<br>

