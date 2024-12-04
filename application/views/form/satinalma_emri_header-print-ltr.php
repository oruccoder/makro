
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>SATIN ALMA EMRİ</h2></td>
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
        <td>Talep Eden</td>
        <td><?php echo personel_details($invoice['talep_eden_pers_id']) ?></td>
    </tr>

    <tr>
        <td>Proje Müdürü</td>
        <td><?php echo personel_details($invoice['proje_muduru_id']) ?></td>
    </tr>
    <tr>
        <td>Satın Alma Sorumlusu</td>
        <td><?php echo personel_details($invoice['satinalma_personeli']) ?></td>
    </tr>
</table>


<br/>

<table class="plist" cellpadding="0" cellspacing="0"  >


    <tr>
        <th width="5%"  style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" >#</th>
        <th width="20%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
        <th width="15%"  style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center"class="text-center"><?php echo $this->lang->line('product detail') ?></th>
        <th width="20%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center">Uygun Görülen Firma</th>
        <th width="8%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center">Miktar / Birim</th>
        <th width="15%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center">KDV'siz Birim Alış Fiyatı</th>
        <th width="15%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center">KDV'li Birim Alış Fiyatı</th>
        <th width="15%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center">KDV'siz Tutar</th>
        <th width="15%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center">KDV'li Tutar</th>
        <th width="10%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center" class="text-center">Satın Alma Personeli</th>
    </tr>

</table>

<br>

