
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2><?php if($invoice['type']==2) {echo "STOK GİRİŞ FİŞİ"; } else { echo "STOK ÇIKIŞ FİŞİ"; } ?> </h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Talep Tarihi</td>
        <td><?php echo dateformat($invoice['fis_date']) ?></td>
    </tr>
    <tr>
        <?php if($invoice['customer_type']==2){
            ?>
            <td>Proje Adı</td>
            <td> <?php echo proje_name($invoice['customer_id']) ?></td>
            <?php
        } else
        {
            ?>
            <td>Cari Adı</td>
            <td> <?php echo customer_details($invoice['customer_id'])['company'] ?></td>
            <?php
        }

        ?>

    </tr>
    <tr>
        <td>Sorumlu Personel</td>
        <td><?php echo personel_details($invoice['sorumlu_pers_id']) ?></td>
    </tr>
    <tr>
        <td>Telefon</td>
        <td><?php echo $invoice['sofor_tel'] ?></td>
    </tr>
    <tr>
        <td>Fiş No</td>
        <td> <?php echo $invoice['fis_no']; ?></td>
    </tr>
    <tr>
        <td rowspan="">Plaka No</td>
        <td><?php echo $invoice['plaka_no'] ?></td>
    </tr>
    <tr>
        <td rowspan="">Şöfor Adı</td>
        <td><?php echo $invoice['sofor_name'] ?></td>
    </tr>
    <tr>
        <td rowspan="">Şöfor Tel</td>
        <td><?php echo $invoice['sofor_tel'] ?></td>
    </tr>
    <tr>
        <td rowspan="">Açıklama</td>
        <td><?php echo $invoice['fis_note'] ?></td>
    </tr>

</table>


<br/>

<table class="plist" cellpadding="0" cellspacing="0"  >
    <tr class="heading">
        <td width="33%">#</td>

        <td width="33%">
            <?php echo $this->lang->line('Item Name') ?>
        </td>

        <td width="33%">
            <?php echo $this->lang->line('Qty') ?>
        </td>
    </tr>

</table>

<br>

