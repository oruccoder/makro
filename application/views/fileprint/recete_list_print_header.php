
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
        <td style="text-align: center; border: 1px solid gray;" rowspan="3"> <h2>Reçete <?php echo $details->invoice_no ?><br></h2></td>
    </tr>



</table>

<br/>

<table class="mycooo1" style="font-size: 10px">
    <tr>
        <td>Reçete Adı</td>
        <td><?php echo $details->invoice_name ?></td>
    </tr>
    <tr>
        <td>Reçete Tarihi</td>
        <td><?php echo dateformat($details->create_date) ?></td>
    </tr>
    <?php if($details->invoice_type_id==11) { ?>
    <tr>
        <td>Üretilcek Ürün</td>
        <td><?php

            $option_html='';
            $details_options = uretim_new_products($details->id);

            if($details_options){
                $option_html='';
                foreach ($details_options as $options_items){
                    $option_html.=varyasyon_string_name($options_items->option_id,$options_items->option_value_id);
                }
            }

            echo product_name($details->new_prd_id).' '.$option_html ?></td>
    </tr>
    <?php } ?>
    <tr>
    <tr>
        <td>Talep Eden</td>
        <td><?php echo personel_details($details->eid) ?></td>
    </tr>

    <tr>
        <td>Açıklama</td>
        <td><?php echo $details->notes ?></td>
    </tr>

</table>


<br/>

