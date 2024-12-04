<div class="content-body">
<div class="card">
    <div class="card-header pb-0">
        <h5><?php echo $this->lang->line('Add New Product') ?></h5>
        <hr>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                 <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
    <div class="card-body">
        <form method="post" id="data_form" class="form-horizontal">
            <div class="card card-block">
                <hr>


                <input type="hidden" name="act" value="add_product">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Product Name') ?>*</label>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Ürün Adı"
                               class="form-control margin-bottom " id="product_name" name="product_name">
                    </div>
                    <div class="col-sm-2">
                        <a id="stok_kontrol" class="btn btn-lg btn-blue margin-bottom">Kontrol Et</a>
                    </div>
                </div>

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
                           for="product_cat"><?php echo $this->lang->line('Product Category') ?>*</label>

                    <div id="refresh" class="col-sm-6">
                        <select name="product_cat" class="form-control select-box">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                        <!--select name="product_cat" class="form-control select-box">
                            <?php
                            foreach ($ana_kategoriler as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<optgroup label='$title'";
                                    foreach ($alt_kat as $prn)
                                    {
                                        if($cid==$prn['parent_id'])
                                        {
                                            $id=$prn['id'];
                                            $name=$prn['title'];
                                            echo "<option value='$id'>$name</option>";
                                        }
                                        else
                                            {
                                                echo ">";
                                            }

                                    }
                                echo "</optgroup>";

                            }
                            ?>
                        </select-->


                    </div>

         <a href='#'  class="btn btn-primary  btn-sm " data-toggle="modal"
         class="a_href" data-target="#form_cat" title="Kategori Ekle">  <i class="fa fa-plus-circle fa-lg" ></i></a>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Warehouse') ?>*</label>

                    <div class="col-sm-6">
                        <select name="product_warehouse" class="form-control select-box">
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                      <a  href="<?php echo base_url('productcategory/addwarehouse') ?>"  class="btn btn-primary btn-sm rounded function" target="_blank"title=" Depo Ekle" >
                    <i class="fa fa-plus-circle fa-lg" ></i></a>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>

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
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('iscilik_price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="iscilik_price" class="form-control"
                                   placeholder="0.00" aria-describedby="sizing-addon1" value="0.00"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('kalite') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Kalite Standartı"
                               class="form-control" id="kalite" name="kalite">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('paketleme_tipi') ?></label>

                    <div class="col-sm-6">
                        <select name="paketleme_tipi" class="form-control">
                            <?php
                            foreach ($paketleme_tipi as $row) {
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
                           for="product_code"><?php echo $this->lang->line('uretim_yeri') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Üretim Yeri"
                               class="form-control" id="uretim_yeri" name="uretim_yeri">
                    </div>
                </div>

                <hr>
                <div class="form-group row">


                    <label class="col-sm-1 col-form-label"><?php echo $this->lang->line('Default TAX Rate') ?></label>
                    <div class="col-sm-3">
                        <div class="input-group">

                            <input type="text" name="product_tax" class="form-control" value="18"
                                   placeholder="<?php echo $this->lang->line('Default TAX Rate') ?>" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>






                    <label class="col-sm-1 col-form-label"><?php echo $this->lang->line('Default Discount Rate') ?></label>
                    <div class="col-sm-3">
                        <div class="input-group">

                            <input type="text" name="product_disc" class="form-control"  value="0"
                                   placeholder="<?php echo $this->lang->line('Default Discount Rate') ?>" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('Discount rate during') ?></small>

                        <small><?php echo $this->lang->line('Tax rate during') ?></small>
                    </div>
                </div>
                <div class="form-group row">


                    <label class="col-sm-1 col-form-label"><?php echo $this->lang->line('Stock Units') ?></label>
                    <div class="col-sm-3">
                        <input type="number" placeholder="<?php echo $this->lang->line('Stock Units') ?>*"
                               class="form-control margin-bottom  product_qty" disabled name="product_qty"  value="0"
                               onkeypress="return isNumber(event)"></div>
                    <label class="col-sm-1 col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>
                               <div class="col-sm-3">

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
                        <select name="unit" class="form-control select-box">
                             <option value=''>None</option>
                            <?php
                            foreach ($units as $row) {
                                $id = $row['id'];
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$id'>$cid</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Measurement Unit Weight') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Metrekare Ağırlığını Giriniz"
                               class="form-control margin-bottom" name="metrekare_agirligi"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>


                          <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('BarCode') ?></label>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Barkod 12 Numaralı Olmalıdır"
                               class="form-control margin-bottom" name="barcode"
                               onkeypress="return isNumber(event)">
                        <small>Leave blank if you want auto generated.</small>
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
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('raf_no') ?></label>

                    <div class="col-sm-8">

                        <input type="text" name="raf_no" class="form-control"
                               placeholder="Raf No">
                    </div>
                </div>
                       <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="edate"><?php echo $this->lang->line('Valid').' ('.$this->lang->line('To Date') ?>)</label>

                                <div class="col-sm-2">
                                    <input type="text" class="form-control "
                                           placeholder="Geçerlilik Tarihi" name="wdate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div><hr>
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

                        </div>   </div>
 <div class="form-group row">

<label class="col-sm-2 col-form-label"></label>


                </div>


                <!-- Gruplu Ürün -->
                <div class="row p-1 gruplu_urun" style="display: none;">
                    <div class="col-xs-12">

                        <hr>
                        <table class="table" id="v_var">
                            <tr>
                                <th>En(Cm)</th>
                                <th>Boy(Cm)</th>
                                <th>Ürün Adı</th>
                                <th>Ürün Kodu</th>
                                <th>Peketleme Miktarı</th>
                                <th>Miktar</th>
                                <th>Uyarı Miktarı</th>
                                <th>Eylem</th>
                            </tr>
                            <tr>
                                <td>
                                    <input value="" class="form-control en" onkeyup="urun_adi(this)" name="en[]" placeholder="<?php echo $this->lang->line('en') ?>*">
                                </td>
                                <td>
                                    <input value="" class="form-control boy" onkeyup="urun_adi(this)"  name="boy[]" placeholder="<?php echo $this->lang->line('boy') ?>*">
                                </td>
                                <td>
                                    <input value="" class="form-control g_urun_adi" name="g_urun_adi[]" placeholder="<?php echo $this->lang->line('g_urun_name') ?>*">
                                </td>
                                <td>
                                    <input value="" class="form-control g_urun_code " name="g_urun_code[]" placeholder="<?php echo $this->lang->line('g_urun_code') ?>*">
                                </td>
                                <td>
                                    <input value="" class="form-control g_urun_paketleme_miktari " name="g_urun_paketleme_miktari[]" placeholder="<?php echo $this->lang->line('g_urun_paketleme_miktari') ?>">
                                </td>
                                <td><input value="" class="form-control" name="g_stock[]" disabled placeholder="<?php echo $this->lang->line('Stock Units') ?>"> </td>

                                <td><input value="" class="form-control" name="g_alert[]" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"> </td>
                                <td><button class="btn btn-red tr_delete">Sil</button></td>
                            </tr>
                        </table>
                    </div>



                </div>
                <!-- Gruplu Ürün -->



                <div class="row">
                      <div class="gruplu_urun" style="display: none;">
                      <button class="btn btn-info tr_clone_add">Yeni Satır Ekle</button>
                  </div>
                <input type="submit" id="submit-data" class="btn btn-blue margin-bottom"
                           value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="products/addproduct" id="action-url">
                                </div>
            </div> <input type="hidden" name="image" id="image" value="default.png">



        </form>
    </div>
    </div>
</div>

<div class="modal fade" id="form_cat" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content col-sm-12">
                <form method="post" id="data_form_cat" class="form-horizontal">
                  <div class="modal-body">
                      <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    </div>
                                        <h5><?php echo $this->lang->line('Add New Product Category') ?></h5>
                                        <hr>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="product_catname"><?php echo $this->lang->line('Category Name') ?></label>

                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Kategori Adı"
                                                       class="form-control margin-bottom" name="product_catname">
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="product_catname"><?php echo $this->lang->line('Sub Category Name') ?></label>

                                            <div class="col-sm-6">
                                                <select name="cat_rel" class="form-control">
                                                    <option value="0">Ana Kategori Seçiniz</option>
                                                    <?php
                                                    foreach ($cat as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['title'];
                                                        echo "<option value='$cid'>$title</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="product_catname"><?php echo $this->lang->line('Description') ?></label>

                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Product Category Short Description"
                                                       class="form-control margin-bottom" name="product_catdesc">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"></label>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                                                <input type="submit" id="mcat_add" class="btn btn-primary submitBtn" value="Ekle"/>
                                            </div>
                                        </div>


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


$("#mcat_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'Productcategory/addcat';
    cat(actionurl);
});
function cat(actionurl) {
    var errorNum = farmCheck2();
    if (errorNum > 0) {
        $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#statusMsg").html("<strong>Hata</strong>: Lüten Zorunlu Alanları Doldurunuz!!");
        $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
    } else {
                $.ajax({
            url: actionurl,
            type: 'POST',
            data: $("#data_form_cat").serialize()+'&'+crsf_token+'='+crsf_hash,
            dataType: 'json',
           success: function (data) {
                if (data.status == "Success") {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
                 $("#form_cat").modal('toggle');
                setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            },
            error: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
            }
        });
    }
}



</script>


