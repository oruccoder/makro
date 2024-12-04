
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>TEVHİL FORMU</h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Tevhil Tarihi</td>
        <td><?php date_default_timezone_set('Asia/Baku'); echo date("Y-m-d H:i:s"); ?></td>
    </tr>
    <tr>
        <td>Tevhil Alan</td>
        <td><?php echo personel_detailsa($this->aauth->get_user()->id)['name'] ?></td>
    </tr>
    <tr>
        <td>Tehvil No</td>
        <td><?php echo $tehvil_id;?></td>
    </tr>
</table>


<br/>

<table class="plist" cellpadding="0" cellspacing="0">


    <tr>
        <td width="16.6%" style="font-size:10px;padding: 5px;border: 1px solid gray;text-align: center">No</td>
        <td width="16.6%" style="font-size:10px;border: 1px solid gray;text-align: center">Talep No</td>
        <td width="16.6%" style="font-size:10px;border: 1px solid gray;text-align: center">Firma</td>
        <td width="16.6%" style="font-size:10px;border: 1px solid gray;text-align: center">Ürün Adı</td>
        <td width="16.6%" style="font-size:10px;border: 1px solid gray;text-align: center">Tehvil A. Miktar</td>
        <td width="16.6%" style="font-size:10px;border: 1px solid gray;text-align: center">Not</td>
    </tr>

</table>

<br>

