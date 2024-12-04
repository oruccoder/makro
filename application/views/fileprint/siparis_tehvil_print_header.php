
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>Tehvil Formu<br></h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 12px">
    <tr>
        <td style=" border-top: hidden; border-left:hidden;border-right:hidden  ">Alıcı</td>
        <td style="border: hidden;text-align: right">Tarih ____/_______/_______</td>
    </tr>
    <tr>
        <td style="text-align: center;line-height:25px;border: 1px solid black"><?php echo customer_details($siparis_details->csd)['company'] ?><br><?php echo customer_details($siparis_details->csd)['address'] ?></td>
        <td style="text-align: right">Gönderiş Nömresi <?php echo $details->invoice_no;?><br>Sipariş Nömresi <?php echo $siparis_details->invoice_no;?></td>

    </tr>

</table>
<br>


