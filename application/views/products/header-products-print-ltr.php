<table>
    <tr>
        <td class="myco">
            <img src="<?php  $loc=location(5);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                 style="max-height:180px;max-width:250px;">
        </td>
        <td>

        </td>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="1" class="t_center"><h2 ><?php

                            echo $this->lang->line('Ürün Listesi');
                            ?></h2><br><br></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('Date') ?></td><td><?php echo date("Y/m/d"); ?></td>
                </tr>

            </table>
        </td>
    </tr>
</table>
<br>