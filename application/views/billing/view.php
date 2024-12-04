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

                    <div class="">
                        <?php
                        $validtoken = hash_hmac('ripemd160', $invoice['id'], $this->config->item('encryption_key'));

                        $link = base_url('billing/view?id=' . $invoice['id'] . '&token=' . $validtoken);
                        if ($invoice['status'] != '3') { ?>
                            <div class="title-action">






                            <!-- SMS -->




                            <a href="#pop_model" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-cyan mb-1" title="Change Status"
                            ><span class="icon-tab"></span> <?php echo $this->lang->line('Change Status') ?></a>






                            </div><?php if ($invoice['multi'] > 0) {

                                echo '<div class="tag tag-info text-xs-center mt-2">' . $this->lang->line('Payment currency is different') . '</div>';
                            }
                        } else {
                            echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                        } ?>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left" style="text-align: center"><p></p>
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">
                        </div>

                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row" style="text-align: center">
                        <div class="col-sm-12 text-xs-center text-md-left">
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800"><a
                                            href="<?php echo base_url('customers/view?id=' . $invoice['cid']) ?>"><strong
                                                class="invoice_a"><?php echo '</strong></li><li>' . $invoice['company'] . '</li></a>'; ?>
                                </li>
                            </ul>

                        </div>

                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                    <?php if($invoice['taxstatus']=='cgst'){ ?>

                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('HSN') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>


                                        <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('CGST') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('SGST') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;

                                    foreach ($products as $row) {
                                        $sub_t += $row['price'] * $row['qty'];
                                        $gst = $row['totaltax']/2;
                                        $rate=$row['tax']/2;
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td> 
                            <td>' . $row['code'] . '</td>                          
                            <td>' . amountFormat($row['price'],$invoice['para_birimi']) . '</td>
                             <td>' . +$row['qty'].' '.units_($row['unit'])['name'] . '</td>
                             <td>' . +$row['qty'].' '.units_($row['unit'])['name'] . '</td>
                             
                              <td>' . amountFormat($row['totaldiscount']) . ' (' .amountFormat_s($row['discount']).$this->lang->line($invoice['format_discount']).')</td>
                            <td>' . amountFormat($gst,$invoice['para_birimi']) . ' (' . amountFormat_s($rate) . '%)</td>
                             <td>' . amountFormat($gst,$invoice['para_birimi']) . ' (' . amountFormat_s($rate) . '%)</td>                           
                            <td>' . amountFormat($row['subtotal'],$invoice['para_birimi']) . '</td>
                        </tr>';


                                        $c++;
                                    } ?>

                                    </tbody>
                                    <?php

                                    } elseif($invoice['taxstatus']=='igst'){
                                        ?>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line('Description') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('HSN') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('IGST') ?></th>

                                            <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $c = 1;
                                        $sub_t = 0;

                                        foreach ($products as $row) {
                                            $sub_t += $row['price'] * $row['qty'];

                                            echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td> 
                            <td>' . $row['code'] . '</td>                          
                            <td>' . amountFormat($row['price'],$invoice['para_birimi']) . '</td>
                             <td>' . +$row['qty'].' '.units_($row['unit'])['name'] . '</td>
                              <td>' . amountFormat($row['totaldiscount'],$invoice['para_birimi']) . ' (' .amountFormat_s($row['discount']).$this->lang->line($invoice['format_discount']).')</td>
                            <td>' . amountFormat($row['totaltax'],$invoice['para_birimi']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                                            
                            <td>' . amountFormat($row['subtotal'],$invoice['para_birimi']) . '</td>
                        </tr>';


                                            $c++;
                                        } ?>

                                        </tbody>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <tr>
                                            <th><?php echo $this->lang->line('Description') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                            <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $c = 1;
                                        $sub_t = 0;

                                        foreach ($products as $row) {
                                            $sub_t += $row['price'] * $row['qty'];
                                            echo '<tr>
                            <td>' . $row['product'] . '</td>                           
                            <td>' . amountFormat($row['price'],$invoice['para_birimi']) . '</td>
                              <td>' . +$row['qty'].' '.units_($row['unit'])['name'] . '</td>
                            ';




                                            echo '
                           
                            <!--td>' . amountFormat($row['totaltax'],$invoice['para_birimi']) . ' (' . amountFormat_s($row['tax']) . '%)</-td-->
                           <td>' . amountFormat($row['subtotal'],$invoice['para_birimi']) . '</td>
                        </tr>';


                                            $c++;
                                        } ?>

                                        </tbody>
                                    <?php } ?>
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
                                            <?php echo $invoice['notes'] ?>
                                        </code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead"><?php echo $this->lang->line('Summary') ?></p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><?php echo $this->lang->line('Sub Total') ?></td>

                                            <td class="text-xs-right"> <?php echo amountFormat($sub_t,$invoice['para_birimi']) ?></td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->lang->line('Discount') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($invoice['discount'],$invoice['para_birimi']) ?></td>
                                        </tr>


                                        <tr>
                                            <td><?php echo $this->lang->line('Net Total') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($sub_t-$invoice['discount'],$invoice['para_birimi']) ?></td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->lang->line('Total Tax') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($invoice['tax'],$invoice['para_birimi']) ?></td>
                                        </tr>

                                        <tr>
                                            <td class="text-bold-800"><?php echo $this->lang->line('Grand Total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php echo amountFormat($invoice['total'],$invoice['para_birimi']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Payment Made') ?></td>
                                            <td class="pink text-xs-right">
                                                (-) <?php echo ' <span id="paymade">' . amountFormat($invoice['pamnt'],$invoice['para_birimi']) ?></span></td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('Balance Due') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                                $rming = $invoice['total'] - $invoice['pamnt'];
                                                if ($rming < 0) {
                                                    $rming = 0;

                                                }
                                                echo ' <span id="paydue">' . amountFormat($rming,$invoice['para_birimi']) . '</span></strong>'; ?></td>
                                        </tr>

                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('azn_total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                                $rming = $invoice['total']*$invoice['kur_degeri'];

                                                echo ' <span >' . amountFormat($rming,1) . '</span></strong>'; ?></td>

                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('kur_degeri') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php
                                                $kur_degeri = $invoice['kur_degeri'];

                                                echo ' <span >' . amountFormat($kur_degeri,1) . '</span></strong>'; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr>



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
</script>

<style>
    .table th, .table td
    {
        padding: 5px !important;
    }
</style>
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
                                <option>Seçiniz</option>
                                <option value="12">Proje Müdürü Onayladı</option>
                                <option value="14">Genel Müdür Onayladı</option>
                                <option value="11">Projesi Belirsiz</option>

                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod">Proje Seçiniz</label>
                            <select class="form-control" name="proje_id" id="proje_id">
                                <option value="0">Seçiniz</option>
                                <?php foreach (all_projects() as $project){

                                    if($project->id==$invoice['proje_id'])
                                    {
                                        ?>
                                        <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                        <?php
                                    }
                                    else
                                        {
                                            ?>
                                            <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                            <?php
                                        }
                                    ?>


                                <?php } ?>

                            </select>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod">Açıklama</label>
                          <textarea class="form-control" name="desc"></textarea>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="billing/update_status_invoice">
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
