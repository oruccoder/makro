<div class="content-body">
    <div class="card">
         <div class="card-header">
           <h5><?php echo $this->lang->line('Add New Product') ?></h5>
                <hr>

 <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">

        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="card card-block">
              
                <input type="hidden" name="act" value="add_product">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('product_type') ?>*</label>

                    <div class="col-sm-6">
                        <select name="product_type" class="form-control product_type">
                            <?php
                            foreach (product_type() as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Name') ?>*</label>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Ürün Adı"
                               class="form-control margin-bottom required" id="product_name" name="product_name">
                    </div>
                    <div class="col-sm-2">
                        <a id="stok_kontrol" class="btn-lg btn-light-blue">Kontrol Et</a>
                    </div>
                </div>



                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('Code') ?>*</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Ürün Kodu"
                               class="form-control required" id="product_code" name="product_code">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Product Retail Price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" class="form-control "
                                   placeholder="0.00" aria-describedby="sizing-addon"  value="0.00"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('alis_fiyati') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="fproduct_price" class="form-control"
                                   placeholder="0.00" aria-describedby="sizing-addon1" value="0.00"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>


                <hr>
                <div class="form-group row">


                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default TAX Rate') ?></label>
                    <div class="col-sm-2">
                        <div class="input-group">

                            <input type="text" name="product_tax" class="form-control" value="18"
                                   placeholder="<?php echo $this->lang->line('Default TAX Rate') ?>" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>






                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default Discount Rate') ?></label>
                    <div class="col-sm-2">
                        <div class="input-group">

                            <input type="text" name="product_disc" class="form-control"  value="0"
                                   placeholder="<?php echo $this->lang->line('Default Discount Rate') ?>" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>

                </div>
                <div class="form-group row">


                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Stock Units') ?></label>
                    <div class="col-sm-2">
                        <input type="number" placeholder="<?php echo $this->lang->line('Stock Units') ?>*"
                               class="form-control margin-bottom  product_qty" name="product_qty"  value="0"
                               onkeypress="return isNumber(event)"></div>
                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>
                               <div class="col-sm-2">

                        <input type="number" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"
                               class="form-control margin-bottom" name="product_qty_alert"  value="0"
                               onkeypress="return isNumber(event)">
                    </div>

                </div>
<hr>

                  <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?>*</label>

                    <div class="col-sm-4">
                        <select name="unit" class="form-control">
                             <option value=''>None</option>
                            <?php
                            foreach ($units as $row) {
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>




              <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('BarCode') ?></label>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Barkod 12 Numaralı Olmalıdır"
                               class="form-control margin-bottom" name="barcode"
                               onkeypress="return isNumber(event)">
                        <small>Boş bırakıldığında otomatik barkod oluştutulacaktır.</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-8">
                        <textarea placeholder="Açıklama"
                               class="form-control margin-bottom" name="product_desc"
                        ></textarea>
                    </div>
                </div>
               <hr>
                  <div class="form-group row">  <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                         <div class="col-sm-6">
                             <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                             <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                        <br>
                        <pre>Formatlar: gif, jpeg, png (Hızlı yükleme için hafif, küçük resimler kullanın- 200x200)</pre>
                        <br>
                        <!-- The global progress bar -->

                        </div>
                  </div>






                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-lg btn-light-blue margin-bottom"
                           value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="projects/addproduct" id="action-url">
                </div>
            </div> <input type="hidden" name="image" id="image" value="default.png">



        </form>
    </div>
</div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
             formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img='default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/'+file.name + '"></td></tr>');
                    img=file.name;
                });

                $('#image').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });


 $(document).on('click', ".tr_clone_add", function (e) {
     e.preventDefault();
      var n_row =$('#v_var').find('tbody').find("tr:last").clone();

      $('#v_var').find('tbody').find("tr:last").after(n_row);

 });

 $(document).on('click', ".tr_delete", function (e) {
     e.preventDefault();
     $(this).closest('tr').remove();
 });


$( ".product_type" ).change(function() {
    var type=$(this).val();
    if(type==6)
    {
        $('.gruplu_urun').css('display','block');
        //$("html, body").scrollTop($("body").height());
        $('.product_qty').attr('disabled',true);
    }
    else
        {
            $('.gruplu_urun').css('display','none');
           // $("html, body").scrollTop($("body").offset().top);
            $('.product_qty').attr('disabled',false)
        }

});

 $(document).on('click','#stok_kontrol',function () {
     var product_name=$('#product_name').val();
     $.ajax({
         url: baseurl + 'search_products/product_control',
         method: 'post',
         data: 'name_startsWith='+product_name+'&'+d_csrf,
         success: function (data) {
            if(data!=0)
            {
                alert(data);
            }


         }
     });
 });

   function urun_adi(obj) {
       //p = $(obj).parent().parent().parent().parent();
       var p = $(obj).closest('tr').index();
       var eqq=parseInt(p)-1;

       var pdn= $('#product_name').val();

       var pcode=$('#product_code').val();

       var en =  $('.en').eq(eqq).val();
       var boy =  $('.boy').eq(eqq).val();
       var text = en+'X'+boy+' '+pdn;

       $('.g_urun_adi').eq(eqq).val(text);

       var sayi =parseInt(eqq)+1;

       $('.g_urun_code').eq(eqq).val(pcode+'-'+sayi);

   }



</script>

