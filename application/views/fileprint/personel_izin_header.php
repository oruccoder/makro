
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>Personel İzin Talep Formu<br></h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Talep No</td>
        <td><?= $details->creatad_at.' - '.$details->code ?></td>
    </tr>
    <tr>
    <tr>
        <td>Talep Eden</td>
        <td><?= personel_details($details->user_id) ?></td>
    </tr>
    <tr>
        <td>Başlangıç Tarihi</td>
        <td><?= $details->start_date?></td>
    </tr>
    <tr>
        <td>Bitiş Tarihi</td>
        <td><?= $details->end_date?></td>
    </tr>

</table>


<br/>

