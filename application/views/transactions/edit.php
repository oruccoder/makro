<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>İşlem Düzenle</h4>
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
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                    <form method="post" id="data_form" class="form-horizontal">
                        <div class="grid_3 grid_4">

                            <div class="form-group row hidden">
                                <label class="caption col-xs-6 col-form-label"></label>
                                <div class="input-group" class="col-xs-6">
                                    <label class="display-inline-block custom-control custom-radio ml-1">
                                        <input type="radio" name="ty_p" class="custom-control-input"
                                               value="0" checked="">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description ml-0"><?php echo $this->lang->line('Customer') ?></span>
                                    </label>
                                    <label class="display-inline-block custom-control custom-radio">
                                        <input type="radio" name="ty_p" class="custom-control-input"
                                               value="1">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description ml-0"><?php echo $this->lang->line('Supplier') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div id="customerpanel" class="form-group row">
                                <label for="toBizName"
                                       class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('Type') ?> <span
                                            style="color: red;">*</span></label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="cari_pers_type" name="cari_pers_type">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (cari_pers_type() as $pers)
                                        {
                                            if($editdata['cari_pers_type']==$pers->id)
                                            {
                                                echo "<option selected value='$pers->id'>$pers->name</option>";
                                            }
                                            else
                                                {
                                                    echo "<option value='$pers->id'>$pers->name</option>";
                                                }

                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="product_price">Proje Seçiniz</label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="proje_id" class="form-control select-box" id="proje_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (all_projects() as $row) {

                                                if($editdata['proje_id']==$row->id)
                                                {
                                                    echo "<option selected value='$row->id'>$row->name</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$row->id'>$row->name</option>";
                                                }
                                            } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="product_price">Proje Bölümü Seçiniz</label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select class="form-control required" id="proje_bolum_id" name="proje_bolum_id">

                                            <?php
                                            if($editdata['proje_id']!=0){
                                                foreach (all_bolum_proje($editdata['proje_id']) as $row) {

                                                    if($editdata['bolum_id']==$row->id)
                                                    {
                                                        echo "<option selected value='$row->id'>$row->name</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='$row->id'>$row->name</option>";
                                                    }
                                                }
                                            }
                                           ?>
                                        </select>

                                    </div>
                                </div>
                            </div>


                            <div class="frmSearch">
                                <div class="form-group row">

                                    <label for="cst" class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('cari_pers') ?> </label>
                                    <div class="col-sm-6" >
                                        <input type="text" class="form-control" name="cst" id="trans-box"
                                               placeholder="Müşteri / Personel Adı veya Telefon Numarası Giriniz"
                                               autocomplete="off"/>

                                        <div id="trans-box-result" class="sbox-result"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="customerpanel" class="form-group row">
                                <label for="toBizName"
                                       class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('C/o') ?></label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="payer_id" id="customer_id" value="<?php echo $editdata['csd']?>">
                                    <input type="hidden" name="masraf_id" id="masraf_id" value="<?php echo $editdata['masraf_id']?>">
                                    <input type="hidden" name="invoice_id_masraf" id="invoice_id_masraf" value="<?php echo $editdata['tid']?>">
                                    <input type="text" class="form-control" name="payer_name" value="<?php echo $editdata['payer']?>" id="company_name">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="product_price"><?php echo $this->lang->line('Method') ?> </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="paymethod" class="form-control" id="paymethod">
                                            <?php foreach (account_type_islem() as $acc)
                                            {

                                                if($editdata['method']==$acc->id)
                                                {
                                                    echo "<option selected value='$acc->id'>$acc->name</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$acc->id'>$acc->name</option>";
                                                }
                                            } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 control-label"
                                       for="product_price"><?php echo $this->lang->line('Type') ?></label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="pay_type" class="form-control" id="pay_type">
                                            <?php foreach (transaction_type() as $row) {
                                                echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                            } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row maas_ay" style="visibility: hidden">

                                <label class="col-sm-2 control-label"
                                       for="maas_ay">Seçilen Aya İstinaden</label>

                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <select name="maas_ay" class="form-control" id="maas_ay">
                                            <option value="1">Ocak - 01</option>
                                            <option value="2">Şubat - 02</option>
                                            <option value="3">Mart - 03</option>
                                            <option value="4">Nisan - 04</option>
                                            <option value="5">Mayıs - 05</option>
                                            <option value="6">Haziran - 06</option>
                                            <option value="7">Temmuz - 07</option>
                                            <option value="8">Ağuston - 08</option>
                                            <option value="9">Eylül - 09</option>
                                            <option value="10">Ekim - 10</option>
                                            <option value="11">Kasım - 11</option>
                                            <option value="12">Aralık - 12</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row talep_id_row" >

                                <label class="col-sm-2 control-label"
                                       for="talep_id">Talep No</label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="talep_id[]" class="form-control select-box" multiple id="talep_id">
                                            <option value="0">Talep Seçiniz</option>
                                            <?php foreach (talep_list_finance() as $value){
                                                echo "<option value='$value->id'>$value->talep_no</option>";
                                            } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row cari_in_invoice" style="visibility: hidden">

                                <label class="col-sm-2 control-label"
                                       for="cari_in_invoice"><?php echo $this->lang->line('cari_in_invoice') ?></label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="cari_in_invoice" class="form-control" id="cari_in_invoice">

                                        </select>

                                    </div>
                                </div>
                            </div>



                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Account') ?></label>

                                <div class="col-sm-6">
                                    <select name="pay_acc" class="form-control">
                                        <option>Seçiniz</option>
                                        <?php
                                        foreach (account_type() as $ac_type)
                                        {

                                            $name=$ac_type['name'];
                                            echo "<optgroup label='$name'>";
                                            foreach ($accounts as $row) {
                                                $cid = $row['id'];
                                                $acn = $row['acn'];
                                                $holder = $row['holder'];
                                                if($ac_type['id']==$row['account_type'])
                                                {
                                                    $balance=amountFormat(hesap_balance($cid));

                                                    if($editdata['acid']==$cid)
                                                    {
                                                        echo "<option selected value='$cid'>$holder ($balance)</option>";
                                                    }
                                                    else
                                                        {
                                                            echo "<option value='$cid'>$holder ($balance)</option>";
                                                        }

                                                }


                                            }
                                            echo "</optgroup>";
                                        }

                                        ?>
                                    </select>


                                </div>
                            </div>

                            <input type="hidden" name="act" value="add_product">

<!---->
<!--                            <div class="form-group row">-->
<!---->
<!--                                <label class="col-sm-2 col-form-label" for="date">--><?php //echo $this->lang->line('Date') ?><!--</label>-->
<!---->
<!--                                <div class="col-sm-6">-->
<!--                                    <input type="text" class="form-control required"-->
<!--                                           name="date" data-toggle="editdatepicker" value="--><?php //echo dateformat($editdata['invoicedate'])?><!--" id="invoice_date"-->
<!--                                           >-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="invoice_para_birimi"><?php echo $this->lang->line('odeme_para_birimi') ?></label>

                                <div class="col-sm-6">
                                    <select name="para_birimi" id="para_birimi" class="form-control">
                                        <?php
                                        foreach (para_birimi()  as $row) {
                                            $cid = $row['id'];
                                            $title = $row['code'];
                                            if($editdata['para_birimi']==$cid)
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
                                       for="invoice_kur_degeri"><?php echo $this->lang->line('invoice_kur_degeri') ?></label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control round" placeholder="Kur"
                                           name="kur_degeri" id="kur_degeri" value="<?php echo $editdata['kur_degeri']?>">
                                </div>
                                <div class="col-sm-3">
                                    <a style="color: #fff;" class="btn btn-success kur" id="kur_al"><?php echo $this->lang->line('online_button') ?></a>
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="amount"><?php echo $this->lang->line('Amount') ?></label>

                                <div class="col-sm-6">
                                    <input type="hidden" name="old_total" value="<?php echo $editdata['total']?>">
                                    <input type="number" placeholder="Tutar"
                                           class="form-control margin-bottom  required" name="amount" value="<?php echo $editdata['total']?>"  id="amount">
                                </div>
                            </div>





                            <div class="form-group row hidden">

                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Category') ?></label>

                                <div class="col-sm-6">
                                    <select name="pay_cat" class="form-control">
                                        <?php
                                        foreach ($cat as $row) {
                                            $cid = $row['id'];
                                            $title = $row['name'];
                                            echo "<option value='$title'>$title</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Note') ?></label>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Note"
                                           class="form-control" name="note" value="<?php echo $editdata['notes']?>">
                                </div>
                            </div>
                            <div class="form-group row">  <label class="col-sm-2 col-form-label">Dosya</label>
                                <div class="col-sm-6">
                                    <div id="progress" class="progress">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                    <!-- The container for the uploaded files -->
                                    <table id="files" class="files">
                                        <tr><td><a data-url="<?= base_url() ?>transactions/file_handling?op=delete&name=<?php echo $editdata['ext'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i><?php echo $editdata['ext'] ?> </a><img style="max-height:200px;" src="<?= base_url() ?>userfiles/product/<?php echo $editdata['ext'].'?c='.rand(1,999) ?>"></td></tr>
                                    </table>
                                    <br>
                                    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                                        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                                    <!-- The global progress bar -->

                                </div>   </div>
                            <div class="form-group row">

                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('invoice_tip') ?></label>
                                        <select class="form-control" name="ithalat_ihracat_tip">
                                            <option value="0">Seçiniz</option>
                                            <?php if($editdata['ithalat_ihracat_tip']==1)
                                            {
                                                ?>
                                                <option selected value="1">İhracat</option>
                                                <option value="0">İthalat</option>
                                                <?php

                                            }
                                             else {
                                                ?>
                                                <option value="1">İhracat</option>
                                                <option selected value="0">İthalat</option>
                                                <?php

                                            } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('dosya_no') ?></label>
                                        <select class="form-control" name="dosya_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (ihracat_dosyaları() as $dosya)
                                            {
                                                if($editdata['dosya_id']==$dosya->id)
                                                {
                                                    echo '<option selected value="'.$dosya->id.'">'.$dosya->dosya_no.'</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="'.$dosya->id.'">'.$dosya->dosya_no.'</option>';
                                                }

                                            } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <input type="hidden" name="image" id="image" value="<?php echo $editdata['ext'] ?>">
                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Add transaction') ?>" data-loading-text="Adding...">
                                    <input type="hidden" value="transactions/edit_trans" id="action-url">
                                    <input type="hidden" name="trans_id" value="<?php echo $trans_id ?>" id="trans_id">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <?php

        $inv_id = isset(cari_in_invoice($editdata['id'])->invoice_id)?cari_in_invoice($editdata['id'])->invoice_id:0; ?>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js');  $invoice['tid']=0;?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>transactions/file_handling?id=<?php echo $editdata['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img='default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>transactions/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $editdata['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/'+file.name + '"></td></tr>');
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

            $("#trans-box").keyup(function () {
                $.ajax({
                    type: "GET",
                    url: baseurl + 'search_products/party_search',
                    data: '' +
                        'keyword=' + $(this).val()+
                        '&cari_pers_type=' +$("#cari_pers_type option:selected").val()+
                        '&ty='+$('input[name=ty_p]:checked').val(),
                    beforeSend: function () {
                        $("#trans-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                    },
                    success: function (data) {
                        $("#trans-box-result").show();
                        $("#trans-box-result").html(data);
                        $("#trans-box").css("background", "none");

                    }
                });
            });

            $('#kur_al').click(function () {
                var para_birimi=$('#para_birimi').val();
                var invoice_date=$('#invoice_date').val();
                $.ajax({
                    type: "POST",
                    url: baseurl + 'search_products/kur_al',
                    data:
                        'para_birimi='+ para_birimi+
                        '&invoice_date='+ invoice_date+
                        '&'+crsf_token+'='+crsf_hash,
                    success: function (data) {
                        $('#kur_degeri').val(data);

                    }
                });


            });


            $(document).on('change', "#cari_pers_type", function (e) {
                var deger = $(this).val();
                if(deger==2)
                {
                    $("#pay_type option").remove();
                    $("#pay_type option").remove();
                    $('#pay_type').append($('<option>').val(14).text('Avans'));
                    $('#pay_type').append($('<option>').val(59).text('Personel İş Masrafı'));
                    $('#pay_type').append($('<option>').val(60).text('Personel İş Masrafı Qalıq Tahsilatı'));
                    // $('#pay_type').append($('<option>').val(50).text('Personel Razı'));
                    $('#pay_type').append($('<option>').val(51).text('Personel Borç Ödeme'));
                    $('#pay_type').append($('<option>').val(16).text('Sipariş Prim Ödemesi'));
                    $('#pay_type').append($('<option>').val(52).text('Personel Borçlandırma'));
                    // $('#pay_type').append($('<option>').val(12).text('Maaş Ödemesi'));
                    // $('#pay_type').append($('<option>').val(49).text('Banka Maaş Ödemesi'));
                    $('.maas_ay').css('visibility','visible');
                }
                else if(deger==1 || deger==7)
                {
                    $("#pay_type option").remove();
                    $('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                    $('#pay_type').append($('<option>').val(4).text('Ödeme'));
                    $('#pay_type').append($('<option>').val(43).text('Avans Ödemesi'));
                    $('#pay_type').append($('<option>').val(44).text('Avans Tahsilatı'));
                    $('#pay_type').append($('<option>').val(45).text('Forma2 Ödemesi'));
                    $('#pay_type').append($('<option>').val(46).text('Forma2 Tahsilatı'));
                    $('#pay_type').append($('<option>').val(54).text('Forma2 Cezası'));
                    $('#pay_type').append($('<option>').val(65).text('Forma2 Kesinti'));
                    $('#pay_type').append($('<option>').val(55).text('Forma2 Teminat'));
                    $('#pay_type').append($('<option>').val(61).text('Forma2 Teminattan Ödeme'));



                    $('#pay_type').append($('<option>').val(17).text('Fatura Ödeme'));
                    $('#pay_type').append($('<option>').val(18).text('Fatura Tahsilatı'));
                    $('#pay_type').append($('<option>').val(19).text('Fatura KDV Ödemesi'));
                    $('#pay_type').append($('<option>').val(20).text('Fatura KDV Tahsilatı'));
                    $('#pay_type').append($('<option>').val(47).text('Avans Fatura KDV Ödemesi'));
                    $('#pay_type').append($('<option>').val(48).text('Avans Fatura KDV Tahsilatı'));
                    $('#pay_type').append($('<option>').val(22).text('Devir Alacak'));
                    $('#pay_type').append($('<option>').val(23).text('Devir Borç'));
                    $('.maas_ay').css('visibility','hidden');

                }
                else if(deger==5)
                {
                    $("#pay_type option").remove();
                    $('#pay_type').append($('<option>').val(0).text('Seçiniz'));
                    $('#pay_type').append($('<option>').val(33).text('Personel Giderleri Ödeme'));
                    $('.maas_ay').css('visibility','hidden');

                }
                else if(deger==3)
                {
                    $("#pay_type option").remove();
                    $('#pay_type').append($('<option>').val(4).text('Ödeme'));
                    $('#pay_type').append($('<option>').val(19).text('Fatura KDV Ödemesi'));
                    $('.maas_ay').css('visibility','hidden');

                }

                else if(deger==4)
                {
                    $("#pay_type option").remove();
                    $('#pay_type').append($('<option>').val(25).text('Açılış Bakiyesi'));
                    $('.maas_ay').css('visibility','hidden');

                }
                else if(deger==6)
                {
                    $("#pay_type option").remove();
                    $('#pay_type').append($('<option>').val(4).text('Ödeme'));
                    $('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                    $('.maas_ay').css('visibility','hidden');

                }
            });


            $(document).on('change', "#paymethod,#pay_type", function (e) {
                var tur_id = $('#cari_pers_type option:selected').val();
                var paymethod = $('#paymethod option:selected').val();
                var pay_type = $('#pay_type option:selected').val();
                var customer_id = $('#customer_id').val();

                if(tur_id==2)
                {


                    if(pay_type==12 || pay_type==14 || pay_type==16 || pay_type==4 || pay_type==49 || pay_type==50 || pay_type==51 || pay_type==52 )
                    {
                        $("#amount").attr('disabled',false);
                        $.ajax({
                            type: "POST",
                            url: baseurl + 'search_products/maas_hesapla',
                            data:
                                'tur_id='+ tur_id+
                                '&paymethod='+ paymethod+
                                '&customer_id='+ customer_id+
                                '&pay_type='+ pay_type+
                                '&'+crsf_token+'='+crsf_hash,
                            success: function (data) {
                                if(data==0)
                                {
                                    if(pay_type!=14)
                                    {
                                        alert('Bu ay için hakediş yoktur!');
                                    }

                                }


                                $("#amount").val(data);

                            }
                        });
                    }

                    else
                    {
                        alert('Lütfen Tür Olarak Maaş Ödemesi / Prim Ödemesi / Avans Seçiniz / Ödeme ');

                    }

                }

                else if(tur_id==5)
                {


                    if(pay_type==33)
                    {

                        $.ajax({
                            type: "POST",
                            url: baseurl + 'search_products/gider_hesapla',
                            data:
                                'tur_id='+ tur_id+
                                '&paymethod='+ paymethod+
                                '&customer_id='+ customer_id+
                                '&pay_type='+ pay_type+
                                '&'+crsf_token+'='+crsf_hash,
                            success: function (data) {
                                if(data==0)
                                {
                                    alert('Ödenmemiş Personel Kesintisi Yoktur!');

                                }
                                else
                                {
                                    $("#amount").val(data);
                                }




                            }
                        });
                    }

                    else
                    {
                        alert('Lütfen Tür Seçiniz ');

                    }

                }
                else  if(tur_id!=3)
                {

                    if(pay_type==17 || pay_type==18 || pay_type==19 || pay_type==20 || pay_type==43 || pay_type==44 || pay_type==45 || pay_type==46  || pay_type==54  || pay_type==65 || pay_type==55  || pay_type==61  )
                    {
                        $("#cari_in_invoice option").remove();

                        $('.cari_in_invoice').css('visibility','visible');

                        $.ajax({
                            type: "POST",
                            url: baseurl + 'transactions/cari_in_invoice',
                            data:
                                'customer_id='+ customer_id+
                                '&pay_type='+ pay_type+
                                '&'+crsf_token+'='+crsf_hash,
                            success: function (data) {
                                if(data)
                                {

                                    $('#cari_in_invoice').append($('<option>').val(0).text('İşlem Yapılacak Faturayı Seçiniz'));

                                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                                        $("#cari_in_invoice").append('<option invoice_no="'+item.invoice_no+'" kalan="'+ item.kalan +'" value="'+ item.id +'">'+ item.invoice_no+'-'+item.type +'</option>');
                                    });
                                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                                }

                            }
                        });

                    }

                    else
                    {
                        $('.cari_in_invoice').css('visibility','hidden');
                    }


                }

                $(".pay_acc option").remove();
                $.ajax({
                    type: "POST",
                    url: baseurl + 'search_products/kasalar',
                    data: 'metod=' +paymethod,
                    success: function (datas) {
                        if(datas)
                        {
                            var data = jQuery.parseJSON(datas);


                            jQuery.each(data.kasalar, function (key, item) {
                                $(".pay_acc").append('<option value="'+ item.id +'">'+item.holder +'</option>');
                            });


                        }

                    }
                });

            });

            $(document).on('change', "#cari_in_invoice", function (e) {
                var kalan = $('option:selected', this).attr('kalan');
                $('#amount').val(kalan);

            });
            $(function () {
                $('.select-box').select2();
                $('#cari_pers_type').change();
                $("#pay_type option[value='"+<?php echo $editdata['invoice_type_id']?>+"']").attr('selected', 'selected');
                $('#pay_type').change();
                setTimeout(function(){
                    $("#cari_in_invoice option[value='"+<?php echo $inv_id ?>+"']").attr('selected', 'selected');
                    }, 2000);



            })

    $('#proje_id').on('change',function (){
        let cid = $(this).val();
        $("#proje_bolum_id option").remove();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: baseurl + 'projects/proje_bolum_ajax',
            data: 'pid='+cid+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {


                $('#proje_bolum_id').append($('<option>').val('').text('Seçiniz'));

                jQuery.each((data), function (key, item) {
                    $("#proje_bolum_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                });

            }
        });
    })
        </script>
