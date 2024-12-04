<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold"> Üretim Fişi</span></h4>
        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div id="invoice-template" class="card-body">
                <div class="row wrapper white-bg page-heading">

                    <div class="col-lg-12">
                            <input type="hidden" value="<?php echo $invoice['id']; ?>" id="uretim_id">
                            <?php
                            if ($invoice['status'] != 'canceled') { ?>
                                <div class="title-action">


                                    <?php if($invoice['muhasebe_durumu']==0){ ?>
<!--                                <a href="--><?php //echo 'edit_uretim?id=' . $invoice['id']; ?><!--" class="btn btn-warning mb-1"><i-->
<!--                                        class="icon-pencil"></i> --><?php //echo $this->lang->line('Edit Uretim') ?><!--</a>-->
                                <?php } else { ?>

                                    <button title="Muhasebeleşmiş Olan Fiş Düzenlenemez" disabled class="btn btn-warning mb-1"><i
                                                class="icon-pencil"></i> <?php echo $this->lang->line('Edit Uretim') ?></button>
                                    <?php } ?>

                                <div class="btn-group ">
                                    <button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="icon-print"></i> <?php echo $this->lang->line('Print') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo 'printuretim?id=' . $invoice['id']; ?>" target="_blank"><?php echo $this->lang->line('Print') ?></a>

                                        <a class="dropdown-item"
                                           href="<?php echo 'print_uretim_maliyet?id=' . $invoice['id']; ?>" target="_blank"><?php echo $this->lang->line('print_uretim_maliyet') ?></a>

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'printuretim?id=' . $invoice['id']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                    </div>
                                </div>







                                </div><?php
                            } else {
                                echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                            } ?>
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2 col-md-6">

                        <div class="text-xs-center text-md-left">
                            <h2><?php echo $this->lang->line('uretim_name') ?></h2>
                            <dl class="row mt-2">
                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Kullanılan Reçete</span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <span>
                                    <a data-tid="show-recipe-link" target="_blank" href="/uretim/view/<?php echo $invoice['recete_id']?>"><?php echo recete_name($invoice['recete_id']) ?>
                                    </a></span>
                                </dd>
                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretilen Mamul</span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <?php echo $invoice['product_name'] ?>
                                    </span>
                                </dd>
                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretim Miktarı</span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <span>
                                    <?php echo $invoice['quantity'].' '.units_($invoice['unit_id'])['name']; ?>
                                    </span>
                                </dd>
                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretim Tarihi</span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <span><?php echo dateformat($invoice['uretim_date']) ?></span>
                                </dd>
                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretim Maliyeti</span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <?php
                                    $lang='Hesapla';
                                    if($invoice['maliyet']!=0)
                                    {
                                        $lang=amountFormat($invoice['maliyet']);
                                    }
                                    ?>
                                    <a data-tid="record-material-cost-calculate-btn" href='uretim_maliyet?id=<?php echo $invoice['id'];  ?>'><?php echo $lang; ?></a>
                                </dd>

                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretim Birim Maliyeti </span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <?php
                                    if($invoice['maliyet']!=0)
                                    {
                                        ?>
                                        <span class="font-16 font-weight-normal"> <?php echo amountFormat($invoice['maliyet']/$invoice['quantity']); ?></span>
                                        <?php
                                    }
                                    else
                                        {
                                            ?>
                                            <span class="font-16 font-weight-normal"><?php echo amountFormat(0) ?></span>
                                            <?php
                                        }
                                    ?>


                                </dd>
                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretim Durumu</span>
                                </dt>
                                <dd class="col-7 col-lg-9 muhasebelestirme">
                                    <?php if($invoice['muhasebe_durumu']==0){ ?>
                                    <button class="btn btn-success" id="muhasebelestirme" >Üretimi Bitir</button>
                                    <?php } else { ?>
                                    <a  href="/products/view_stok_fisi?id=<?php echo stok_fis_id_ogren($invoice['id']) ?>">Stok Fişini Görüntüle</a>
                                    <?php } ?>
                                </dd>

                                <dt class="col-5 col-lg-3">
                                    <span class="font-16 font-weight-normal">Üretim Açıklaması</span>
                                </dt>
                                <dd class="col-7 col-lg-9">
                                    <span>
                                    <?php echo $invoice['uretim_desc'] ?>
                                    </span>
                                </dd>

                            </dl>

                        </div>

                    </div>
                    <!--/ Invoice Company Details -->
                    <?php if($invoice['customer_id']){ ?>
                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row">
                            <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                                <img src="<?php  $loc=location($invoice['loc_id']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                     class="img-responsive m-b-2" style="max-height: 120px;">
                            </div>
                            <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                                <ul class="px-0 list-unstyled">


                                    <li class="text-bold-800"><a
                                            href="<?php echo base_url('customers/view?id=' . $invoice['customer_id']) ?>"><strong
                                                class="invoice_a"><?php echo $customer_details['name'] . '</strong></a></li><li>' . $customer_details['company'] . '</li><li>' . $customer_details['address'] . ', ' . $customer_details['city'] . ',' . $customer_details['region'] . '</li><li>' . $customer_details['country'] . ',' . $customer_details['postbox'] . '</li><li>'.$this->lang->line('Phone') .': ' . $customer_details['phone'] . '</li><li>'.$this->lang->line('Email') .': ' . $customer_details['email'];

                                                ?>
                                    </li>
                                </ul>

                            </div>

                        </div>
                    <?php } ?>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>

                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Item Name') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('fire') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('fire_quantity') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('toplam_tuketilen') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;

                                    foreach ($products as $row) {
                                        $unit_ = units_($row['unit_id'])['name'];
                                        echo '<tr>
                                                            <th scope="row">' . $c . '</th>
                                                            <td>' . $row['name'] . '</td>                 
                                                             <td>' .floatval($row['quantity_2']).' '.$unit_ . '</td>
                                                            <td>' . '% '.$row['fire'].'</td>
                                                            <td>' .floatval($row['fire_quantity']).' '.$unit_. '</td>
                                                            <td>' .floatval($row['toplam_tuketilen']).' '.$unit_. '</td>
                                                        </tr>';


                                        $c++;
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p></p>

                    </div>

                    <!-- Invoice Footer -->



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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Cancel Invoice'); ?></h4>
            </div>
            <div class="modal-body">
                <form class="cancelbill">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo $this->lang->line('You can not revert'); ?>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" value="<?php echo $invoice['id'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <button type="button" class="btn btn-primary"
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Email'); ?></h4>
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
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $invoice['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                for="shortnote"><?php echo $this->lang->line('Customer Name'); ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $invoice['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                for="shortnote"><?php echo $this->lang->line('Subject'); ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                for="shortnote"><?php echo $this->lang->line('Message'); ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="invoiceid" name="tid" value="<?php echo $invoice['id'] ?>">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Send'); ?> SMS</h4>
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
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="SMS" name="mobile"
                                       value="<?php echo $invoice['phone'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                for="shortnote"><?php echo $this->lang->line('Customer Name'); ?></label>
                            <input type="text" class="form-control"
                                   value="<?php echo $invoice['name'] ?>"></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
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

    $(document).on('click','#muhasebelestirme',function () {
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Üretimi Bitir',
            icon: 'fa fa-check-square 3x',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `Üretimi Bitirmek İstediğinizden Emin Misiniz?`,
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function() {
                        let data_post = {
                            uretim_id : $('#uretim_id').val()
                        }
                        $.post(baseurl + 'uretim/muhasebe', data_post, (response) => {
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function() {
                                                location.reload();
                                                // $('#muhasebelestirme').remove()
                                                // $('.muhasebelestirme').append("<a href='/products/view_stok_fisi?id="+data.stok_id+"'>Stok Fişini Görüntüle</a>");

                                            }
                                        }
                                    }
                                });

                            } else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })
                    }
                },
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action: function() {
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function() {

                $('#fileupload_').fileupload({
                    url: baseurl + 'upload/file_upload',
                    dataType: 'json',
                    formData: {
                        '<?= $this->security->get_csrf_token_name() ?>': crsf_hash,
                        'path': '/userfiles/product/'
                    },
                    done: function(e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function(index, file) {
                            img = file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });


    });


</script>
