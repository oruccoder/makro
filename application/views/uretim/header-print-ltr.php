 <table>
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                     style="max-height:180px;max-width:250px;">
            </td>
            <td>

            </td>
            <td class="myw">
			<table class="top_sum">
			<tr>
            <td><?php echo $this->lang->line('Recete Number') ?></td><td><?php echo  $invoice['tid'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Reçete Date') ?></td><td><?php echo $invoice['invoicedate'] ?></td>
			</tr>
			<?php if($invoice['invoice_name']) { ?>
			<tr>
            <td><?php echo $this->lang->line('recete_name') ?></td><td><?php echo $invoice['invoice_name'] ?></td>
			</tr>
            <?php } ?>
            <tr>
                <td><?php echo $this->lang->line('mamul_name') ?></td><td><?php echo  product_name($invoice['new_prd_id']); ?></td>
            </tr>

			</table>
			
	
               
            </td>
        </tr>
    </table>
 <br>