<div class="content-body">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="thermal_a" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="content-body">
                <div id="invoice-template" class="card-body" style="    text-align: center;">



                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="" style="max-height: 120px;">
                            <p class="font_11"> <?php echo $this->lang->line('project_name') . ': ' . $invoice['proje_name'] . '</p>';?>
                            <p class="font_11"> <?php echo 'Talep Eden : ' . personel_details($invoice['talep_eden_pers_id']) . '</p>';?>
                            <p class="font_11">Malzeme Talep Formu</p>
                            <p class="font_11"> <?php echo 'Talep No : '. $invoice['talep_no'] . '</p>'; ?>
                                <?php echo '<p class="font_11"><span class="text-muted">'.$this->lang->line('creation date').'  :</span> ' . dateformat($invoice['olusturma_tarihi']) . '</p> 
                            ';
                                ?>
                        </div>

                    </div>
                    <!--/ Invoice Company Details -->


                    <!--/ Invoice Customer Details -->

                    <?php
                    $hm_='';
                    $gm='';

                    ?>

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table">
                                <form id="data_form" type="POST">
                                    <table class="table-responsive">
                                        <thead style="font-size: 11px;">

                                        <tr>
                                            <th>#</th>
                                            <th>Eylem</th>
                                            <th><?php echo $this->lang->line('Item Name') ?></th>
                                            <th>Not</th>
                                            <th> <select class="form-control tumunu_sec"">
                                                <option value="0">Satın Almaya Atanan Personel</option>
                                                <?php
                                                foreach (personel_list() as $emp)
                                                {
                                                    $emp_id=$emp['id'];
                                                    $name=$emp['name'];
                                                    echo '<option value="'.$emp_id.'">'.$name.'</option>';
                                                } ?>

                                                </select></th>
                                            <th class="text-center"><?php echo $this->lang->line('Quantity') ?></th>

                                        </tr>
                                        </thead>

                                        <tbody style="font-size: 11px;">

                                        <?php $c = 1;
                                        $sub_t = 0;
                                        $talep_id=$invoice['id'];

                                        foreach ($products as $row) {

                                            $opt="";
                                            foreach (personel_list() as $emp){
                                                $emp_id=$emp['id'];
                                                $name=$emp['name'];
                                                $sub_t += $row['price'] * $row['qty'];
                                                $product_id = $row['id'];
                                                $selected='';

                                                $satin_alma_yon=satinalma_yonlendirme($product_id,$talep_id);
                                                if($satin_alma_yon==$emp_id)
                                                {
                                                    $selected="selected";
                                                }
                                                $opt.='<option '.$selected.' value="'.$emp_id.'">'.$name.'</option>';
                                            }

                                            $hm_="<th>Satın Alma</th>";
                                            $gm="<td><select class='form-control satin_alma_' name='satin_alma_[]'>
        <option value='0'>Seçiniz</option>$opt
        
        </select></td>";


                                            if(onay_durumlari_ogren_product(1,$_GET['id'],$product_id))
                                            {



                                                echo '<tr>
                                                    <th scope="row">' . $c . '</th>
                                                    <th scope="row"><button  class="btn btn-success btn-xs onayla" status="3" >✓</button>&nbsp
                                                    <button  class="btn btn-danger btn-xs iptal" status="4">X</button></th>
                                                    <td>' . $row['product_name'] . '</td>             
                                                    <td>  <input class="form-control input-xs note" name="note[]" id="inputxs" type="text"></td>    
                                                    ';
                                                echo $gm;
                                                echo '<td>' . $row['qty'] .' '. $row['unit'] . '</td>                    
                                                    <input type="hidden" class="product_id" name="product_id[]" value="'.$product_id.'">
                                                    <input type="hidden" class="talep_id" name="talep_id[]" value="'.$talep_id.'">
                                                    <input type="hidden" class="pers_id" name="pers_id[]" value="'.$_GET['pers_id'].'">
                                                </tr>';


                                                $c++;
                                            }
                                        }?>
                                        <tr>
                                            <th colspan="3" scope="row"><button id="tumunu_onayla" type="button" class="btn btn-info btn-xs">Tümünü Təstiqle</button></th>
                                            <th colspan="3" scope="row"><button style="float: right;" class="btn btn-info btn-xs islem_bitir">İşlemi Bitir</button></th>
                                        </tr>


                                        </tbody>

                                    </table>
                                    <div style="text-align: center">
                                        <p ><?php echo $invoice['description']?></p>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <style>
                            .table th, .table td
                            {
                                padding: 7px !important;
                            }
                            .mt-2, .my-2
                            {
                                margin-top: 0 !important;
                            }
                            .font_11
                            {
                                font-size: 11px;
                            }
                        </style>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    select
    {
        font-size: 9px !important;
    }
</style>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>invoices/file_handling?id=<?php echo $invoice['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>invoices/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
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

    $(document).on('click',"#tumunu_onayla",function(e) {

        jQuery.ajax({
            url: baseurl + 'billing/malzeme_talep_product_status_toplu',
            type: 'POST',
            data: $('#data_form').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {

                    $('#'+$('#object-id').val()).remove();
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $( ".islem_bitir" ).trigger( "click" );
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    });

    $(document).on('click', ".onayla,.iptal", function (e) {
        e.preventDefault();
        var eq=$(this).parent().parent().index();
        var status=$(this).attr('status');

        var product_id=$(".product_id").eq(eq).val();
        var talep_id=$(".talep_id").eq(eq).val();
        var note=$(".note").eq(eq).val();
        var satin_alma_=$(".satin_alma_").eq(eq).val();
        var tip=1;
        var pers_id=<?php echo  $_GET['pers_id']; ?>;

        if(satin_alma_==0)
        {
            alert("Satın Alma Personeni Seçiniz");
        }
        else
        {
            jQuery.ajax({
                url: baseurl + 'billing/malzeme_talep_product_status',
                type: 'POST',
                data: {
                    'product_id':product_id,
                    'talep_id':talep_id,
                    'satin_alma_':satin_alma_,
                    'tip':tip,
                    'note':note,
                    'pers_id':pers_id,
                    'status':status,
                },
                dataType: 'json',
                beforeSend: function(){
                    $(this).html('Bekleyiniz');
                    $(this).prop('disabled', true); // disable button

                },
                success: function (data) {

                    if (data.status == "Success") {

                        $('#'+$('#object-id').val()).remove();
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            });
        }






    });


    $(document).on('click', ".islem_bitir", function (e) {
        e.preventDefault();
        var talep_id=<?php echo  $_GET['id']; ?>;
        var pers_id=<?php echo  $_GET['pers_id']; ?>;

        jQuery.ajax({
            url: baseurl + 'billing/malzeme_talep_islem_bitir',
            type: 'POST',
            data: {
                'talep_id':talep_id,
                'pers_id':pers_id,
            },
            dataType: 'json',
            beforeSend: function(){
                $(".islem_bitir").html('Bekleyiniz');
                $(".islem_bitir").prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {
                    $('#'+$('#object-id').val()).remove();
                    $('#invoice-template').remove();
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });




    });
</script>

<!-- Modal HTML -->
<div id="part_payment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Payment Confirmation') ?></h4>
            </div>

            <div class="modal-body">
                <form class="payment">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="input-group">
                                <div class="input-group-addon"><?php echo $this->config->item('currency') ?></div>
                                <input type="text" class="form-control" placeholder="Total Amount" name="amount"
                                       id="rmpay" value="<?php echo $rming ?>">
                            </div>

                        </div>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar4"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control required"
                                       placeholder="Billing Date" name="paydate"
                                       data-toggle="datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Balance"><?php echo $this->lang->line('Client Balance') ?></option>
                                <option value="Bank"><?php echo $this->lang->line('Bank') ?></option>
                            </select><label for="account"><?php echo $this->lang->line('Account') ?></label>

                            <select name="account" class="form-control">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Payment for invoice #<?php echo $invoice['tid'] ?>"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['id'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"
                                                                                                     name="cname"
                                                                                                     value="<?php echo $invoice['name'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="submitpayment"><?php echo $this->lang->line('Make Payment'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- cancel -->
<div id="cancel_bill" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Cancel Invoice'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="cancelbill">


                    <?php echo $this->lang->line('You can not revert'); ?>


            </div>


            <div class="modal-footer">
                <input type="hidden" class="form-control"
                       name="tid" value="<?php echo $invoice['iid'] ?>">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-danger"
                        id="send"><?php echo $this->lang->line('Cancel Invoice'); ?></button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<!-- Modal HTML -->
<div id="sendEmail" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Email'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div id="request">
                <div id="ballsWaveG">
                    <div id="ballsWaveG_1" class="ballsWaveG"></div>
                    <div id="ballsWaveG_2" class="ballsWaveG"></div>
                    <div id="ballsWaveG_3" class="ballsWaveG"></div>
                    <div id="ballsWaveG_4" class="ballsWaveG"></div>
                    <div id="ballsWaveG_5" class="ballsWaveG"></div>
                    <div id="ballsWaveG_6" class="ballsWaveG"></div>
                    <div id="ballsWaveG_7" class="ballsWaveG"></div>
                    <div id="ballsWaveG_8" class="ballsWaveG"></div>
                </div>
            </div>
            <div class="modal-body" id="emailbody" style="display: none;">
                <form id="sendbill">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $invoice['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name'); ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $invoice['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject'); ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message'); ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="invoiceid" name="tid" value="<?php echo $invoice['iid'] ?>">
                    <input type="hidden" class="form-control"
                           id="emailtype" value="">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendM"><?php echo $this->lang->line('Send'); ?></button>
            </div>
        </div>
    </div>
</div>
<!--sms-->
<!-- Modal HTML -->
<div id="sendSMS" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Send'); ?> SMS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div id="request_sms">
                <div id="ballsWaveG1">
                    <div id="ballsWaveG_1" class="ballsWaveG"></div>
                    <div id="ballsWaveG_2" class="ballsWaveG"></div>
                    <div id="ballsWaveG_3" class="ballsWaveG"></div>
                    <div id="ballsWaveG_4" class="ballsWaveG"></div>
                    <div id="ballsWaveG_5" class="ballsWaveG"></div>
                    <div id="ballsWaveG_6" class="ballsWaveG"></div>
                    <div id="ballsWaveG_7" class="ballsWaveG"></div>
                    <div id="ballsWaveG_8" class="ballsWaveG"></div>
                </div>
            </div>
            <div class="modal-body" id="smsbody" style="display: none;">
                <form id="sendsms">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="SMS" name="mobile"
                                       value="<?php echo $invoice['phone'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name'); ?></label>
                            <input type="text" class="form-control"
                                   value="<?php echo $invoice['name'] ?>"></div>
                    </div>

                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message'); ?></label>
                            <textarea class="form-control" name="text_message" id="sms_tem" title="Contents"
                                      rows="3"></textarea></div>
                    </div>


                    <input type="hidden" class="form-control"
                           id="smstype" value="">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-primary"
                        id="submitSMS"><?php echo $this->lang->line('Send'); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <?php foreach (purchase_status() as $prc)
                                {
                                    echo "<option value='".$prc['id']."'>".$prc['name']."</option>";
                                } ?>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required" name="talep_id" id="invoiceid" value="<?php echo $invoice['id'] ?>">
                        <input type="hidden" class="form-control required" name="pers_id" id="pers_id" value="<?php echo $pers_id ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="billing/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    $(function () {
        $('.summernote').summernote({
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });

    });

    $('.tumunu_sec').on('change',function () {
        var deger=$('.tumunu_sec').val();


        $('.satin_alma_').val(deger);
    });


    $(function () {


        // disc_degis($('#discount_rate').val());

        $('.select-box').select2();
    });




</script>
