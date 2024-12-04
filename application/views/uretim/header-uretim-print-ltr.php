 <table>
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location($invoice['loc_id']);  echo  base_url('userfiles/company/makro_lab.PNG') ?>"
                     style="padding-left:18px;max-height:180px;max-width:250px;">
            </td>
            <td>

            </td>
            <td class="myw">
			<table class="top_sum">
			<tr>
                <?php if(isset($invoice['uretim_desc'])){ ?><td>Üretim Açıklaması</td><td> <?php echo $invoice['uretim_desc'] ?></td><?php } ?>
			</tr>
                <tr>
                    <td>Sorumlu Personel</td><td> <?php echo $personel; ?></td>
                </tr>
			<tr>
                <td>Kullanılan Reçete</td><td><?php echo  recete_name($invoice['recete_id']) ?></td>
			</tr>
                <tr>
                    <td>Üretilen Mamul</td>
                    <td> <?php echo $invoice['product_name'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Üretim Miktarı</td><td><?php echo $invoice['quantity'].' '.product_unit($invoice['product_id']) ?></td>
                </tr>
                <tr>
                    <td>Üretim Tarihi</td><td><?php echo $invoice['uretim_date'] ?></td>
                </tr>


			</table>



            </td>
        </tr>
    </table>
 <table class="party"  style="font-size: 12px">
     <thead>
     <tr class="heading">
         <td> <?php echo $this->lang->line('firma') ?></td>
     </tr>
     </thead>
     <tbody>
     <tr>
         <td width="100%">
             <?php echo '<strong>'.$customer['company'] . '</strong><br>';
             echo 'Yetkili Adı: '.$customer['name'] . '<br>';
             if ($customer['company']) echo 'Adres: '.$customer['company'] . ' ';
             echo $customer['address'] . '<br> ' . $customer['city'] . ' ' . $customer['country'];
             if ($customer['taxid']) echo '<br>' . $this->lang->line('voyn') . ': ' . $customer['taxid'];
             ?>
         </td>

     </tr>
     </tbody>
 </table>


 <table class="plist" cellpadding="0" cellspacing="0">


     <tr class="heading">
         <td width="5%">
             Sıra
         </td>
         <td width="20%">
             No
         </td>
         <td width="40%">
             <?php echo $this->lang->line('Item Name') ?>
         </td>
         <td>
             <?php echo $this->lang->line('Qty') ?>
         </td>
         <td>
             Birim
         </td>
         <td >
             Fiyat
         </td>
         <td >
           Toplam
         </td>



     </tr>

 </table>

 <br>
