
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>Araç Talep FORMU</h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Talep No</td>
        <td><?php echo dateformat($details->created_at).' - '.$details->code ?></td>
    </tr>
    <tr>
        <td>Talep Eden</td>
        <td><?php echo personel_details($details->user_id) ?></td>
    </tr>
    

</table>


<br/>

