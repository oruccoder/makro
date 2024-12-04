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
            <td><?php echo $this->lang->line('Invoice') ?></td><td><?php echo $this->config->item('prefix') . ' #' . $invoice['invoice_no'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Invoice Date') ?></td><td><?php echo $invoice['invoicedate'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Due Date') ?></td><td><?php echo $invoice['invoiceduedate'] ?></td>
			</tr>
			<?php if($invoice['refer']) { ?>
			<tr>
            <td><?php echo $this->lang->line('Reference') ?></td><td><?php echo $invoice['refer'] ?></td>
			</tr>
			<?php } ?>
			</table>
			
	
               
            </td>
        </tr>
    </table>
 <br>

