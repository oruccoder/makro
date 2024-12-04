<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 6.02.2020
 * Time: 15:52
 */
?>
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


                            echo $invoice['invoice_type_desc'] ?>

                        </h3><br></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('fis_belge_no') ?></td><td><?php echo $this->config->item('prefix') . ' #' . $invoice['invoice_no'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('masraf_kalemi') ?></td><td><?php echo masraf_name($invoice['masraf_id'] )?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('islem_date') ?></td><td><?php echo $invoice['invoicedate'] ?></td>
                </tr>

            </table>



        </td>
    </tr>
</table>
<br>


