<table >
    <tr>
        <td class="myco">
            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                 style="padding-left:18px;max-height:180px;max-width:250px;">
        </td>
        <td>

        </td>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="1" ><h3 ><?php


                            echo $invoice['description'] ?>

                        </h3><br></td>
                </tr>
                <tr>
                    <td>Talep No</td><td><?php echo $invoice['talep_no'] ?></td>
                </tr>
                <tr>
                    <td>Oluşturma Tarihi</td><td><?php echo $invoice['olusturma_tarihi'] ?></td>
                </tr>
                <tr>
                    <td>Satın Alma Personeli </td><td><?php echo personel_details($invoice['kullanici_id']) ?></td>
                </tr>
                <tr>
                    <td>Depo Personeli </td><td><?php echo personel_details($invoice['bolum_mudur_id']) ?></td>
                </tr>
                <tr>
                    <td>İletişim </td>
                    <td><?php echo personel_detailsa($invoice['kullanici_id'])['phone'] ?></td>
                </tr>
               
            </table>



        </td>
    </tr>
</table>
<br>

