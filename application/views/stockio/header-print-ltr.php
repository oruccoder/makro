<table >
    <tr>
        <td class="myco">
            <img src="<?php  $loc=location(5);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                 style="padding-left:18px;max-height:180px;max-width:250px;">
        </td>
        <td>
        </td>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="1" ><h3 >
                           Məhsul Fişi
                        </h3><br></td>
                </tr>
                <tr>
                    <td>Fiş kod:</td><td><?php echo $details->code ?></td>
                </tr>
                <tr>
                    <td>Fiş Tipi</td><td><?php echo $details->type ==1 ? 'Giris' : 'Cixis' ?></td>
                </tr>
                <tr>
                    <td>Anbar</td><td><?php echo warehouse_details($details->warehouse_id)->title ?></td>
                </tr>
                <tr>
                    <td>Fiş tarihi:</td><td><?php echo $details->created_at ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

