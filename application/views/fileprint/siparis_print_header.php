
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>Sipariş <?php echo $details->invoice_no ?><br></h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Sipariş Tarihi</td>
        <td><?php echo dateformat($details->invoicedate) ?></td>
    </tr>
    <tr>
        <td>Alıcı</td>
        <td><?php echo customer_details($details->csd)['company'] ?></td>
    </tr>
    <tr>
        <td>Çıxış Ünvanı</td>
        <td><?php echo warehouse_details($details->depo)->title ?></td>
    </tr>
    <tr>
        <td>Layihe Adı</td>
        <td><?php echo customer_new_projects_details($details->proje_id)->proje_name ?></td>
    </tr>
    <tr>
        <td>Çatdırılma Ünvanı</td>
        <td><?php echo customer_teslimat_adres_details($details->shipping_id)->unvan_teslimat.' '.customer_teslimat_adres_details($details->shipping_id)->adres_teslimat ?></td>
    </tr>
    <tr>
    <tr>
        <td>Sipariş Sorumlusu</td>
        <td><?php echo personel_details($details->eid) ?></td>
    </tr>

    <tr>
        <td>Açıklama</td>
        <td><?php echo $details->notes ?></td>
    </tr>

</table>


<br/>

