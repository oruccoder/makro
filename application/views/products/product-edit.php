<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <div class="card card-block">

                        <h5><?php echo $this->lang->line('Edit Product') ?></h5>
                        <hr>


                        <input type="hidden" name="pid" value="<?php echo $product['pid'] ?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_name"><?php echo $this->lang->line('Product Name') ?>*</label>

                            <div class="col-sm-6">
                                <input type="text" placeholder="Product Name"
                                       class="form-control margin-bottom  required" id="product_name" name="product_name"
                                       value="<?php echo $product['product_name'] ?>">
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
                                        if($product['product_type']==$cid)
                                        { echo "<option selected value='$cid'>$title</option>";

                                        }
                                        else {
                                            echo "<option value='$cid'>$title</option>";
                                        }


                                    }
                                    ?>
                                </select>


                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_cat"><?php echo $this->lang->line('Product Category') ?>*</label>

                            <div class="col-sm-6">
                                <select name="product_cat" class="form-control">
                                    <?php
                                    foreach ($cat as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        if($cat_ware['cid']==$cid)
                                        {
                                            echo "<option selected value='$cid'>$title</option>";
                                        }
                                        else
                                        {
                                            echo "<option value='$cid'>$title</option>";
                                        }

                                    }
                                    ?>
                                </select>


                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_cat"><?php echo $this->lang->line('Warehouse') ?>*</label>

                            <div class="col-sm-6">
                                <select name="product_warehouse" class="form-control">
                                    <?php
                                    foreach ($warehouse as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        if($cat_ware['wid']==$cid)
                                        { echo "<option selected value='$cid'>$title</option>";

                                        }
                                        else {
                                            echo "<option value='$cid'>$title</option>";
                                        }


                                    }
                                    ?>
                                </select>


                            </div>
                        </div>
             
                        <div class="form-group row">

                            <label class="col-sm-2 control-label"
                                   for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>

                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                                    <input type="text" name="product_price" class="form-control required"
                                           placeholder="0.00" aria-describedby="sizing-addon"
                                           onkeypress="return isNumber(event)" value="<?php echo $product['product_price'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 control-label"
                                   for="product_price"><?php echo $this->lang->line('alis_fiyati') ?></label>

                            <div class="col-sm-6">
                                <div class="input-group">

                                    <?php $alis_fiyati=0;
                                    if(son_alis_fiyati($product['pid']))
                                    {
                                        $alis_fiyati=son_alis_fiyati($product['pid']);
                                    }
                                    else {
                                        $alis_fiyati=$product['fproduct_price'];
                                    }?>

                                    <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                                    <input type="text" name="fproduct_price" class="form-control"
                                           placeholder="0.00" aria-describedby="sizing-addon"
                                           onkeypress="return isNumber(event)" disabled value="<?php echo $alis_fiyati; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 control-label"
                                   for="product_price"><?php echo $this->lang->line('iscilik_price') ?></label>

                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                                    <input type="text" name="iscilik_price" class="form-control"
                                           placeholder="0.00" aria-describedby="sizing-addon"
                                           onkeypress="return isNumber(event)" value="<?php echo $product['iscilik_price'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_code"><?php echo $this->lang->line('kalite') ?></label>

                            <div class="col-sm-6">
                                <input type="text" placeholder="Kalite Standartı"
                                       class="form-control" id="kalite" name="kalite" value="<?php echo $product['kalite'] ?>">
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
                                        if($product['paketleme_tipi']==$cid)
                                        { echo "<option selected value='$cid'>$title</option>";

                                        }
                                        else {
                                            echo "<option value='$cid'>$title</option>";
                                        }


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
                                       class="form-control" id="uretim_yeri" name="uretim_yeri" value="<?php echo $product['uretim_yeri'] ?>">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default TAX Rate') ?></label>

                            <div class="col-sm-4">
                                <div class="input-group">

                                    <input type="text" name="product_tax" class="form-control"
                                           placeholder="0.00" aria-describedby="sizing-addon1"
                                           onkeypress="return isNumber(event)" value="<?php echo $product['taxrate'] ?>"><span
                                            class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <small><?php echo $this->lang->line('Tax rate during') ?></small>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default Discount Rate') ?></label>

                            <div class="col-sm-4">
                                <div class="input-group">

                                    <input type="text" name="product_disc" class="form-control"
                                           placeholder="0.00" aria-describedby="sizing-addon1"
                                           onkeypress="return isNumber(event)" value="<?php echo $product['disrate'] ?>"><span
                                            class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <small><?php echo $this->lang->line('Discount rate during') ?></small>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Stock Units') ?>*</label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="Total Items in stock"
                                       class="form-control margin-bottom" name="product_qty" disabled onkeypress="return isNumber(event)"
                                       value="<?php echo toplam_rulo_adet($product['pid'])['toplam_adet']  ?>">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?></label>

                            <div class="col-sm-4">
                                <select name="unit" class="form-control">

                                    <?php

                                    foreach ($units as $row) {
                                        $cid = $row['code'];
                                        $id = $row['id'];
                                        $title = $row['name'];

                                        if($product['unit']==$id)
                                        {
                                            echo "<option selected value='$id'>$title</option>";
                                        }

                                        else
                                        {
                                            echo "<option value='$id'>$title</option>";
                                        }

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
                                       class="form-control margin-bottom" name="metrekare_agirligi"  value="<?php echo $product['metrekare_agirligi'] ?>"
                                       onkeypress="return isNumber(event)">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_cat"><?php echo $this->lang->line('totals').' '.paketleme_tipi($product['pid']) ?></label>

                            <div class="col-sm-4">
                                <input disabled type="number"


                                       class="form-control margin-bottom"  value="<?php echo toplam_rulo_adet($product['pid'])['toplam_rulo'] ?>"
                                       onkeypress="return isNumber(event)">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_cat"><?php echo $this->lang->line('total_agirlik') ?></label>

                            <div class="col-sm-4">
                                <input disabled type="number"
                                       class="form-control margin-bottom"  value="<?php echo $product['toplam_agirlik'] ?>"
                                       onkeypress="return isNumber(event)">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>

                            <div class="col-sm-4">
                                <input type="number" placeholder="Low Stock Alert Quantity"
                                       class="form-control margin-bottom" name="product_qty_alert"  value="<?php echo $product['alert'] ?>"
                                       onkeypress="return isNumber(event)">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('BarCode') ?></label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="BarCode 12 Numeric Digit 123-1-1234567-1"
                                       class="form-control margin-bottom" name="barcode"
                                       onkeypress="return isNumber(event)"  value="<?php echo $product['barcode'] ?>">
                                <small>Leave blank if you want auto generated UPC Format.</small>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                            <div class="col-sm-8">
                        <textarea placeholder="Description"
                                  class="form-control margin-bottom" name="product_desc"
                        ><?php echo $product['product_des'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('raf_no') ?></label>

                            <div class="col-sm-8">

                                <input type="text" name="raf_no" class="form-control"
                                       placeholder="Raf No"
                                       value="<?php echo $product['raf_no'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 control-label"
                                   for="edate"><?php echo $this->lang->line('Valid').' ('.$this->lang->line('To Date') ?>)</label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control required"
                                       placeholder="Expiry Date" name="wdate"
                                       data-toggle="datepicker" autocomplete="false">
                            </div><small>Do not change if not applicable</small>
                        </div><hr>
                        <div class="form-group row">  <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                            <div class="col-sm-6">
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <!-- The container for the uploaded files -->
                                <table id="files" class="files">
                                    <tr><td><a data-url="<?= base_url() ?>products/file_handling?op=delete&name=<?php echo $product['image'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i><?php echo $product['image'] ?> </a><img style="max-height:200px;" src="<?= base_url() ?>userfiles/product/<?php echo $product['image'].'?c='.rand(1,999) ?>"></td></tr>
                                </table>
                                <br>
                                <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                                    <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                                <br>
                                <pre>Allowed: gif, jpeg, png</pre>
                                <br>
                                <!-- The global progress bar -->

                            </div>   </div>
                        <div class="form-group row">
                            <input type="hidden" name="image" id="image" value="<?php echo $product['image'] ?>">
                            <label class="col-sm-2 col-form-label"></label>


                        </div>

                        <!-- Gruplu Ürün -->

                        <?php if($gruplu_urun){
                            ?>
                            <div class="row p-1 gruplu_urun">
                                <div class="col-xs-12">
                                    <button class="btn btn-info tr_clone_add">Yeni Satır Ekle</button>
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
                                            <th>Sil</th>
                                        </tr>
                                        <?php  foreach ($gruplu_urun as $gpd) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="g_pid[]" value="<?php echo $gpd['pid'] ?>">
                                                    <input value="<?php echo $gpd['en'] ?>" class="form-control en required" onkeyup="urun_adi(this)" name="en[]" placeholder="<?php echo $this->lang->line('en') ?>*">
                                                </td>
                                                <td>
                                                    <input value="<?php echo $gpd['boy'] ?>" class="form-control boy required" onkeyup="urun_adi(this)"  name="boy[]" placeholder="<?php echo $this->lang->line('boy') ?>*">
                                                </td>
                                                <td>
                                                    <input value="<?php echo $gpd['product_name'] ?>" class="form-control g_urun_adi" name="g_urun_adi[]" placeholder="<?php echo $this->lang->line('g_urun_name') ?>*">
                                                </td>
                                                <td>
                                                    <input value="<?php echo $gpd['product_code'] ?>" class="form-control g_urun_code required" name="g_urun_code[]" placeholder="<?php echo $this->lang->line('g_urun_code') ?>*">
                                                </td>
                                                <td>
                                                    <input value="<?php echo $gpd['paketleme_miktari'] ?>" class="form-control g_urun_paketleme_miktari required" name="g_urun_paketleme_miktari[]" placeholder="<?php echo $this->lang->line('g_urun_paketleme_miktari') ?>*">
                                                </td>
                                                <td><input value="<?php echo $gpd['qty'] ?>" class="form-control" disabled name="g_stock[]" placeholder="<?php echo $this->lang->line('Stock Units') ?>"> </td>
                                                <td><input value="<?php echo $gpd['alert'] ?>" class="form-control" name="g_alert[]" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"> </td>
                                                <td><button product_id="<?php echo $gpd['pid'] ?>" class="btn btn-red tr_delete">Sil</button></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>

                        <?php } ?>
                        <!-- Gruplu Ürün -->

                        <!-- Gruplu Ürün -->
                        <div class="row p-1 gruplu_urun" style="display: none;">
                            <div class="col-xs-12">
                                <button class="btn btn-info tr_clone_add">Yeni Satır Ekle</button>
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

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>"
                                   data-loading-text="Updating...">
                            <input type="hidden" value="products/editproduct" id="action-url">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js');  $invoice['tid']=0;?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling?id=<?php echo $invoice['tid'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img='default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['tid'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/'+file.name + '"></td></tr>');
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
        var n_row =`<tr>
                                <td>
                                    <input type="hidden" name="g_pid[]"">
                                <input value="" class="form-control en required" onkeyup="urun_adi(this)" name="en[]" placeholder="En Ölçüsünü giriniz (cm)*">
                                </td>
                                <td>
                                    <input value="" class="form-control boy required" onkeyup="urun_adi(this)" name="boy[]" placeholder="Boy Ölçüsünü giriniz (cm)*">
                                </td>
                                <td>
                                    <input value="" class="form-control g_urun_adi" name="g_urun_adi[]" placeholder="Ürün Adını Giriniz*">
                                </td>
                                <td>
                                    <input value="" class="form-control g_urun_code required" name="g_urun_code[]" placeholder="Ürün Kodunu Giriniz*">
                                </td>
                                 <td>
                                    <input value="" class="form-control g_urun_paketleme_miktari " name="g_urun_paketleme_miktari[]" placeholder="Paketleme Miktarı">
                                </td>
                                <td><input value="" class="form-control" name="g_stock[]" disabled placeholder="Eldeki ürün adedi"> </td>
                                <td><input value="" class="form-control" name="g_alert[]" placeholder="Uyarı Miktarı"> </td>
                                <td><button product_id='0' class="btn btn-red tr_delete">Sil</button></td>
                            </tr>`;


        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        var product_id = $(this).attr('product_id');

        var ob=$(this);

        jQuery.ajax({
            url: baseurl + 'products/delete_i',
            dataType: "json",
            method: 'post',
            data: 'deleteid='+product_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if (data.status == "Success") {
                    ob.closest('tr').remove();
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                } else {
                    ob.closest('tr').remove();
                    //$("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    //$("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

            }
        });


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
            //$("html, body").scrollTop($("body").offset().top);
            $('.product_qty').attr('disabled',false)
        }

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

    $('#product_code').keyup(function () {
        var sayi=$('.en').length;
        for(var i=0;i<sayi;i++)
        {
            var en=parseInt($('.en').eq(i).val());
            var boy=parseInt($('.boy').eq(i).val());
            var urun_adi=$('#product_name').val();
            var product_code=$(this).val();
            $('.g_urun_adi').eq(i).val(en+'X'+boy+' '+urun_adi);
            var sayis=i+1;
            $('.g_urun_code').eq(i).val($(this).val()+'-'+sayis);
        }
    });


</script>
