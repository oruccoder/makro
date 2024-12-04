<div class="content-body">
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
                <div id="invoice-template" class="card-body">



                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location(5);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">

                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                            <p class="pb-1"> <?php echo  $tehvil_no ?></p>

                        </div>

                    </div>
                    <!--/ Invoice Company Details -->


                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line('talep no') ?></th>
                                            <th><?php echo $this->lang->line('Project Title') ?></th>
                                            <th><?php echo $this->lang->line('Company') ?></th>
                                            <th><?php echo $this->lang->line('Product Name') ?></th>
                                            <th><?php echo $this->lang->line('Sip_Qty') ?></th>
                                            <th><?php echo $this->lang->line('teslim_alinan_miktar') ?></th>
                                            <th><?php echo $this->lang->line('kalan_miktar') ?></th>
                                            <th><?php echo $this->lang->line('Note') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $c = 1;
                                        foreach ($products as $row) {

                                            $kalan=floatval($row->qty)-floatval($row->teslim_alinan_miktar);
                                            echo '<tr>
                                                <th scope="row">' . $c . '</th>
                                                <td>' . $row->talep_no . '</td> 
                                                <td>' . $row->proje_name . '</td> 
                                                  <td>' . $row->firma . '</td> 
                                                   <td>' . $row->product_name . '</td> 
                                                <td>' . round($row->qty,2) .' '.$row->unit. '</td> 
                                                <td>' . round($row->teslim_alinan_miktar,2) .' '.$row->unit. '</td> 
                                                <td>' . round($kalan,2).' '.$row->unit. '</td> 
                                                <td>' . $row->notes . '</td> 
                                               
                                                
                                            </tr>';


                                            $c++;
                                        } ?>

                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">


                                <div class="row">
                                    <div class="col-md-8">

                                        <p class="lead mt-1"><br><?php echo $this->lang->line('Note') ?>:</p>
                                        <code>
                                            <?php echo 'note' ?>
                                        </code>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    <hr>


                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Files') ?></th>


                            </tr>
                            </thead>
                            <tbody id="activity">
                            <?php foreach ($attach as $row) {

                                echo '<tr><td><a data-url="' . base_url() . 'form/depo_file_handling?op=delete&name=' . $row['dosya_name'] . '&invoice=' . $tehvil_no . '" class="aj_delete"><i class="btn-danger btn-lg fa fa-trash"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['dosya_name'] . '"> ' . $row['dosya_name'] . ' </a></td></tr>';
                            } ?>

                            </tbody>
                        </table>
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files[]" multiple>
        </span>
                        <br>
                        <pre>Allowed: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>form/depo_file_handling?id=<?php echo $tehvil_no ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>form/depo_file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $tehvil_no ?>" class="aj_delete"><i class="btn-danger btn-sm fa fa-trash"></i> ' + file.name + ' </a></td></tr>');

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
</script>

<!-- Modal HTML -->
<div id="part_payment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body container">
                <form class="payment col-md-12">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="input-group">

                                <div class="col-xs-12 mb-1"><label
                                        for="shortnote">Tutar</label>
                                    <input type="text" class="form-control" placeholder="Total Amount" name="amount"
                                           id="rmpay" value="<?php echo $rming ?>">
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">

                            <label class="col-sm-12 col-form-label"
                                   for="invoice_para_birimi"><?php echo $this->lang->line('odeme_para_birimi') ?></label>

                            <div class="col-sm-12">
                                <select name="para_birimi" id="para_birimi" class="form-control">
                                    <?php
                                    foreach (para_birimi()  as $row) {
                                        $cid = $row['id'];
                                        $title = $row['code'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-12 col-form-label"
                                   for="invoice_kur_degeri"><?php echo $this->lang->line('invoice_kur_degeri') ?></label>

                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Kur"
                                       name="kur_degeri" id="kur_degeri" value="1">
                            </div>

                        </div>
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="col-xs-12 mb-1"><label
                                        for="shortnote">İşlem Tarihi</label>
                                    <input type="date" class="form-control "
                                           placeholder="Billing Date" name="paydate"
                                           data-toggle="datepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <?php foreach (account_type_islem() as $acc)
                                {
                                    echo "<option value='$acc->id'>$acc->name</option>";
                                } ?>
                            </select>
                            <label for="account"><?php echo $this->lang->line('Account') ?></label>
                            <br>

                            <select name="account" class="form-control select-box">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select>
                            <br>
                            <label for="account">Tür</label>
                            <br>

                            <div class="input-group">
                                <select name="pay_type" class="form-control" id="pay_type">
                                    <option value="17">Fatura Ödeme</option>
                                    <option value="18">Fatura Tahsilatı</option>
                                    <option value="19">Fatura KDV Ödemesi</option>
                                    <option value="20">Fatura KDV Tahsilatı</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Fatura No : <?php echo $invoice['invoice_no'] ?>"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control " name="tid" id="invoiceid" value="<?php echo $invoice['id'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="submitpayment">Ekle</button>
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

                    <div class="col mb-1"><label
                            for="shortnote">Personel</label>
                        <select class="form-control select-box" name="pers_id">

                            <?php foreach (personel_list() as $emp){
                                $emp_id=$emp['id'];
                                $name=$emp['name'];
                                ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
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
                <form id="form_model" method="post">


                    <div class="row">
                        <div class="col mb-1"><label
                                for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <?php foreach (invoice_status() as $rows)
                                {
                                    ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                                <?php } ?>


                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="invoices/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_update"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    $(document).on('click', "#submit_model_update", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model").serialize();
        var action_url= $('#form_model #action-url').val();
        $("#pop_model").modal('hide');
        saveMData(o_data,action_url);
    });

    $(function () {

        $('.paydate').datepicker({autoHide: true, format: 'yyyy-mm-dd'});
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


    $(document).on('click', "#cancel-bills", function (e) {
        e.preventDefault();
        $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
            var acturl='transactions/cancelinvoice';
            cancelBills(acturl);
        });
    });

    $(function () {
        $('.select-box').select2();
    })
    function cancelBills(acturl) {
        var $btn;
        jQuery.ajax({
            url: baseurl + acturl,
            type: 'POST',
            data: $('form.cancelbill').serialize()+'&'+crsf_token+'='+crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
                setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }


</script>
