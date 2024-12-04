
    <table>
        <tr>
            <td class="myw">
                <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                     style="padding-left:13px;max-height:180px;max-width:150px;">
            </td>
            <td>

            </td>
            <td class="myw">
			<table class="top_sum">
                <tr>
                       <td colspan="1" class="t_center"><h2 ><?php echo $this->lang->line('sayim') ?></h2><br><br></td>
                    </tr>
			<tr>
            <td><?php echo $this->lang->line('sayim') ?></td><td><?php  echo  $invoice['sayim_name'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('sayim_bas_tar') ?></td><td><?php echo $invoice['invoicedate'] ?></td>
			</tr>
                <tr>
            <td><?php echo $this->lang->line('sorumlu_personel') ?></td><td><?php echo personel_details($invoice['pers_id']) ?></td>
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