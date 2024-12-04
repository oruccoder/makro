
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>Uretim <?php echo $details->code ?><br></h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Fiş Kodu</td>
        <td><?php echo $details->code ?></td>
    </tr>
    <tr>
        <td>Fiş Tarihi</td>
        <td><?php echo dateformat($details->uretim_date) ?></td>
    </tr>
    <tr>
        <td>Üretilcek Ürün</td>
        <td><?php

            $option_html='';
            $details_options = uretim_new_products($details->recete_id);

            if($details_options){
                $option_html='';
                foreach ($details_options as $options_items){
                    $option_html.=varyasyon_string_name($options_items->option_id,$options_items->option_value_id);
                }
            }

            echo product_name($details->product_id).' '.$option_html ?></td>
    </tr>
    <tr>
    <tr>
        <td>Üretim Yapan</td>
        <td><?php echo personel_details($details->user_id) ?></td>
    </tr>

    <tr>
        <td>Fiş Durumu</td>
        <td><?php echo uretim_status($details->status)->name?></td>
    </tr>
   <tr>
        <td>Açıklama</td>
        <td><?php echo $details->uretim_desc?></td>
    </tr>

</table>


<br/>

