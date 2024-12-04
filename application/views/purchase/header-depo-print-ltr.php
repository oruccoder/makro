
<h4 style="text-align: center"><?php echo $this->lang->line('Depo Purchase Order') ?></h4>


<table>
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                     style="max-height:130px;max-width:200px;">
            </td>


            <td class="myw">
			<table class="top_sum">
                <tr>
                    <td><?php echo $this->lang->line('Order') ?></td><td><?php  echo  prefix(2). $invoice['tid'] ?></td>
                </tr>
                <tr>
                     <td><?php echo $this->lang->line('Order Date') ?></td><td><?php echo $invoice['invoicedate'] ?></td>
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
</br>