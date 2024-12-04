       

         <a href="<?php echo 'Products/print_list_bilgi?id=' . $product['pid']; ?>" target="_blank" style="float: right;background-color: #b3e2ec;padding: 10px;border-radius: 50px;margin-bottom: 9px;"><i class="icon-print"></i></a>
        <div class="row">
            
             <div class="col-md-5">
                
                <div class="card card-block">
              
                <div class="form-group row">

 <label style="width: 50%; bottom: 9px;" class="col-sm-6 col-form-label" for="product_name"><?= $this->lang->line('Product Name') ?></label>

                    <div class="col-sm-6">
                     <label ><?= $product['product_name'] ?></label>
                    </div>
                </div> 
                  
            
                <div class="form-group row">

                    <label style="width: 50%; bottom: 9px;" class="col-sm-6 col-form-label" for="product_cat"><?= $this->lang->line('Product Category') ?></label>

                    <div class="col-sm-6 col-md-6">
                      
                    <?=$product['category'] ?>

                    </div>
                </div>

                <div class="form-group row">

                    <label style="width: 50%; " class="col-sm-6 col-form-label" for="product_cat"><?= $this->lang->line('Warehouse') ?></label>

                    <div class="col-sm-6">
                         <?=$product['warehouse'] ?>

                    </div>
                </div>
                <div class="form-group row">

                    <label style="width: 50%; bottom: 9px;" class="col-sm-6 col-form-label" for="product_code"><?= $this->lang->line('Product Code') ?></label>

                    <div class="col-sm-6">
                      
                              <label><?=$product['product_code'] ?></label>
                    </div>
                </div>
                 <div class="form-group row">

                    <label style="width: 50%; bottom: 9px;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Product Retail Price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                           
                         <label><?=$product['product_price'] ?> AZN</label>
                          
                        </div>
                    </div>
                </div>


         <div class="form-group row">

                    <label style="width: 50%;"  class="col-sm-6 control-label" for="product_price"><?=$this->lang->line('kalite') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?=$product['kalite'] ?></label>
                        </div>
                    </div>
                </div>


                   
         <div class="form-group row">

                    <label style="width: 50%;"  class="col-sm-6 control-label" for="product_price"><?=$this->lang->line('uretim_yeri') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?=$product['uretim_yeri'] ?></label>
                        </div>
                    </div>
                </div>

                 <div class="form-group row">

                    <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Default TAX Rate') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?php echo $product['taxrate'] ?>  %</label>
                        </div>
                    </div>
                </div>

              
                
            </div>

        </div>


   <div class="col-md-5">
         
                <div class="form-group row">

                    <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Measurement Unit') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?php echo units_($product['units'])['name'] ?></label>
                        </div>
                    </div>
				</div>
				<div class="form-group row">

                    <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Measurement Unit Weight') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?php echo $product['metrekare_agirligi'] ?></label>
                        </div>
                    </div>
				</div>
				<div class="form-group row">

                    <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('total_m2') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?php echo $product['qty'] ?></label>
                        </div>
                    </div>
				</div>
				<?php if ($product['product_des']==!null) {
					
				 ?>
				<div class="form-group row">

                    <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <label><?php echo $product['product_des'] ?></label>
                        </div>
                    </div>
				</div>
			<?php } ?>
            </div>

        <div class="col-md-2">
            <img style="width:100%" src="/userfiles/product/<?= $product['image'] ?>">
        </div>

    </div>

<div class="row">
	<div class="col-md-12">
        <?php //var_dump($children);exit; ?>
        <?php foreach($children as $child): ?>
    		<div class="form-group row" style="margin: 10px 20px;box-shadow: 1px 1px 3px #cac7c7;">
                <table class="table">
                    <tr>
                        
                        <th>Ürün Adı</th>
                        <th>Ürün Kodu</th>
                        <th>Paketleme Miktarı</th>
                        <th>Miktar</th>
                    </tr>
                    <tr>
                        
                        <td><?= $child->product_name ?></td>
                        <td><?= $child->product_code ?></td>
                        <td><?= $child->paketleme_miktari ?></td>
                        <td><?= $child->qty ?></td>
                    </tr>
                </table>
    	    </div>
        <?php endforeach; ?>
    </div>
</div>
            
<script>
    
     function print_function2() {
      var deger = $("select[name='productstable_length']" ).val();
      location.href = "/products/print_list_bilgi?pid="+deger;


    }


</script>

