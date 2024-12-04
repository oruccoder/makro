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

                        if ($invoice['status'] != 'canceled') { ?>
                            <div class="title-action">

                            <a href="<?php echo 'edit?id=' . $invoice['id']; ?>" class="btn btn-warning mb-1"><i
                                        class="icon-pencil"></i> <?php echo $this->lang->line('Edit_talep') ?></a>

                            <!--

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle mb-1"
                                        data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="icon-envelope-o"></span> Email
                                </button>
                                <div class="dropdown-menu"><a href="#sendEmail" data-toggle="modal"
                                                              data-remote="false" class="dropdown-item sendbill"
                                                              data-type="notification"><?php echo $this->lang->line('Invoice Notification') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                       class="dropdown-item sendbill"
                                       data-type="reminder"><?php echo $this->lang->line('Payment Reminder') ?></a>
                                    <a
                                            href="#sendEmail" data-toggle="modal" data-remote="false"
                                            class="dropdown-item sendbill"
                                            data-type="received"><?php echo $this->lang->line('Payment Received') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                       class="dropdown-item sendbill" href="#"
                                       data-type="overdue"><?php echo $this->lang->line('Payment Overdue') ?></a><a
                                            href="#sendEmail" data-toggle="modal" data-remote="false"
                                            class="dropdown-item sendbill"
                                            data-type="refund"><?php echo $this->lang->line('Refund Generated') ?></a>

                                </div>

                            </div>

                            SMS
                            <div class="btn-group">
                                <button type="button" class="btn btn-blue dropdown-toggle mb-1"
                                        data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="icon-envelope-o"></span> SMS
                                </button>
                                <div class="dropdown-menu"><a href="#sendSMS" data-toggle="modal"
                                                              data-remote="false" class="dropdown-item sendsms"
                                                              data-type="notification"><?php echo $this->lang->line('Invoice Notification') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#sendSMS" data-toggle="modal" data-remote="false"
                                       class="dropdown-item sendsms"
                                       data-type="reminder"><?php echo $this->lang->line('Payment Reminder') ?></a>
                                    <a
                                            href="#sendSMS" data-toggle="modal" data-remote="false"
                                            class="dropdown-item sendsms"
                                            data-type="received"><?php echo $this->lang->line('Payment Received') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#sendSMS" data-toggle="modal" data-remote="false"
                                       class="dropdown-item sendsms" href="#"
                                       data-type="overdue"><?php echo $this->lang->line('Payment Overdue') ?></a><a
                                            href="#sendSMS" data-toggle="modal" data-remote="false"
                                            class="dropdown-item sendbill"
                                            data-type="refund"><?php echo $this->lang->line('Refund Generated') ?></a>

                                </div>

                            </div>

                            -->

                            <div class="btn-group ">
                                <button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="icon-print"></i> <?php echo $this->lang->line('Print') ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="<?php echo 'printinvoice?id=' . $invoice['id']; ?>" target="_blank"><?php echo $this->lang->line('Print') ?></a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="<?php echo 'printinvoice?id=' . $invoice['id']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                </div>


                            </div>
                            <?php

                            $durum = developer_onayi($invoice['id']);



                            if($invoice['dev_bildirim']==1 )
                            {
                                ?>
                                <button disabled id="onay_iste" type="button" class="btn btn-info mb-1">Onay Sistemine Sunulmuştur</button>
                                <?php
                            }
                            else{
                                ?>
                                <button  id="onay_iste" type="button" class="btn btn-info mb-1">Onay Sistemini Başlat</button>

                            <?php } ?>



                            <?php

                            if($this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==732 || $this->aauth->get_user()->id==640 || $this->aauth->get_user()->id==735)
                            {
                                if(developer_onayi($invoice['id']))
                                {
                                    ?>
                                    <button disabled id="onay_iste_dev" type="button" class="btn btn-info mb-1">Yazılım Onayı Verilmiştir</button>
                                    <?php
                                }
                                else {?>
                                    <button  id="onay_iste_dev" type="button" class="btn btn-info mb-1">Yazılım Onayı Ver</button>
                                <?php } ?>
                            <?php } ?>



                            <a href="#personel_bildirimi" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-cyan mb-1">Personel Bildirimi Yap</a>

                            <a href="#proje_degistir" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-cyan mb-1">Proje Değiştir</a>

                            <button id="talep_iptal"  sf_id ="<?php echo $_GET['id']; ?>"  class="btn btn-warning mb-1">Talebi İptal Et</button>

                            <a href="#talep_kapat" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-danger mb-1">Talebi Kapat</a>

                            <style>
                                @media (min-width: 576px)
                                {
                                    .modal-dialog {
                                        max-width: 900px !important;
                                        margin: 1.75rem auto;
                                    }
                                }
                            </style>
                            <div id="personel_bildirimi" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title">Personel Bildirimi</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="form_model" method="post">
                                                <table class="table">
                                                    <tr>
                                                        <th>Personel</th>
                                                        <th>Mesajınız</th>
                                                    </tr>
                                                    <tr>
                                                        <td><select  name="personel_l[]" class="form-control mb-1 select-box" multiple>

                                                                <option selected>Personel Seçiniz</option>
                                                                <?php foreach (personel_list() as $emp){
                                                                    $emp_id=$emp['id'];
                                                                    $name=$emp['name'];
                                                                    ?>
                                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name ?></option>
                                                                <?php } ?>
                                                            </select></td>
                                                        <td>
                                                            <input name="mesaj" class="form-control" value="<?php echo $invoice['talep_no'].' Numarali Malzeme Talebi icin arastirma talep ediyoruz' ?>">
                                                            <input type="hidden" name="malzeme_talep_id" value="<?php echo $invoice['id'];?>">
                                                        </td>
                                                    </tr>

                                                </table>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                                    <input type="hidden"  id="action-url" value="requested/arastirma_talep_olustur">
                                                    <button type="button" class="btn btn-primary"
                                                            id="arastirma_talep_olustur">Gönder</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div id="talep_kapat" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title">Talep Kapat</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="form_model" method="post">

                                                <p>Kapatmak İstediğinizden Emin Misiniz? İşlemi Geri Alamazsınız!</p>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                                    <input type="hidden"  id="action-url" value="form/talep_iptal">
                                                    <input type="hidden"  name="status" value="1"> <!-- Kapat -->
                                                    <input type="hidden" name="talep_id" id="talep_id"  value="<?php echo $_GET['id']?>">
                                                    <button type="button" class="btn btn-primary"
                                                            id="talep_kapat_btn">Güncelle</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="proje_degistir" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title">Proje Değiştir</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="form_model" method="post">
                                                <table class="table">
                                                    <tr>
                                                        <th width="50%">Proje</th>
                                                        <th width="50%">Proje Bölümü</th>
                                                    </tr>

                                                    <tr>
                                                        <td  width="50%">
                                                            <select  name="proje_id" class="form-control mb-1 select-box" id="proje_bolum_id_key">

                                                                <option>Proje Seçiniz</option>
                                                                <?php foreach (all_projects() as $emp){
                                                                    $emp_id=$emp->id;
                                                                    $name=$emp->name;
                                                                    if($emp_id==$invoice['proje_id'])
                                                                    {
                                                                        echo "<option selected value='$emp_id'>$name</option>";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<option value='$emp_id'>$name</option>";
                                                                    }
                                                                    ?>

                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td  width="50%"><select id="proje_bolum_id" name="proje_bolum_id" class="form-control mb-1 requred">

                                                                <?php echo "<option selected value='".$invoice['proje_bolum_id']."'>".$invoice['proje_bolum_name']."</option>"; ?>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                </table>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                                    <input type="hidden"  id="action-url" value="requested/proje_guncelle">
                                                    <input type="hidden" name="talep_id" id="talep_id"  value="<?php echo $_GET['id']?>">
                                                    <button type="button" class="btn btn-primary"
                                                            id="proje_guncelle">Güncelle</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!--a href="#pop_model" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-cyan mb-1" title="Change Status"
                            ><span class="icon-tab"></span> <?php echo $this->lang->line('Change Status') ?></a-->
                            <!--
                            <a href="#cancel-bill" class="btn btn-danger mb-1" id="cancel-bill"><i
                                        class="icon-minus-circle"> </i> <?php echo $this->lang->line('Cancel') ?>
                            </a>

-->



                            </div><?php
                        } else {
                            echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                        } ?>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-4 col-sm-12 text-xs-center text-md-left" style="background-color: #cdcdcd5c;border-radius: 34px;font-size: 16px;font-weight: 900;"><p></p>
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">
                            <p  style="padding-left: 15px;"> <?php echo $this->lang->line('project_name') . ': ' . $invoice['proje_name'] . '</p>';?>
                            <p  style="padding-left: 15px;"> <?php echo 'Bölüm Adı: ' . $invoice['proje_bolum_name'] . '</p>';?>
                            <p  style="padding-left: 15px;"> <?php echo 'Tel/E-mail: '. $invoice['tel'] .' '.$invoice['email'] . '</p>';?>
                            <p  style="padding-left: 15px;"> <?php echo $this->lang->line('Description').': '. $invoice['description']. '</p>';?>
                            <p  style="padding-left: 15px;"> <?php echo '<span class="text-muted">'.$this->lang->line('creation date').'  :</span> ' . dateformat($invoice['olusturma_tarihi']); ?></p>
                            <p  style="padding-left: 15px;"> <?php echo '<span class="text-danger">Durum : </span> ' . purchase_status($invoice['status']); ?></p>
                            <?php if($invoice['status']==4) {
                                ?>
                                <p  style="padding-left: 15px;"> <?php echo '<span class="text-danger">İptal Eden Persone ve Açıklama : </span> ' . personel_details($invoice['iptal_pers_id']).' | '.$invoice['iptal_desc']; ?></p>
                                <?php
                            } ?>

                        </div>
                        <div class="col-md-8 col-sm-12 text-xs-center text-md-right">
                            <?php if($invoice['stok_durumu']==1){
                                echo " <h2>Hizmet Talep Formu</h2>";
                            }
                            else {
                                echo " <h2>Malzeme Talep Formu</h2>";
                            }
                            ?>

                            <p class="pb-1"> <?php echo $this->config->item('prefix') . ' #' . $invoice['talep_no'] . '</p>'; ?>
                            <p class="pb-1">Talep Oluşturan Personel : <span style="font-weight: 900"><?php echo personel_details($invoice['kullanici_id']) ?></span> </p>


                        </div>


                        <div class="col-md-6">
                            <p class="pb-1">Personel Depertmanı:</p>
                            <select class="form-control col-md-6" id="pers_dep_list">
                                <option value="0">Tümü</option>
                                <?php foreach (personel_depertman_list() as $dep)
                                {
                                    echo "<option value='$dep->id'>$dep->val1</option>";
                                } ?>
                            </select>
                            <?php ?>
                            </p>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row">
                        <div class="col-sm-12 text-xs-center text-md-left">
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800">
                                    <!-- Müşteri Bilgileri -->
                                </li>
                            </ul>

                        </div>
                        <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-right">

                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <form id="data_form" type="POST">
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">


                                    <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <?php
                                            if($kullanici_id==$depo_mudur_id)
                                            {
                                                ?>  <th>Depo Miktarı</th><?php

                                            }
                                            ?>
                                            <th><?php echo $this->lang->line('Item Name') ?></th>
                                            <th><?php echo $this->lang->line('product detail') ?></th>
                                            <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                            <th>Proje Sorumlusu</br><?php echo ' ('.personel_details($invoice['proje_sorumlusu_id']).')'?></th>
                                            <th>Proje Müdürü </br><?php echo ' ('.personel_details($invoice['proje_muduru_id']).')'?></th>
                                            <th>Depo Müdürü Durumu</br><?php echo ' ('.personel_details($invoice['bolum_mudur_id']).')'?></th>
                                            <th>Genel Müdürü Durumu</br><?php echo ' ('.personel_details($invoice['genel_mudur_id']).')'?></th>
                                            <th class="no-short">

                                                <select class="form-control tumunu_sec select-box" id="personel_list">
                                                    <option value="0">Satın Almaya Atanan Personel</option>
                                                    <?php
                                                    foreach (personel_list() as $emp)
                                                    {
                                                        $emp_id=$emp['id'];
                                                        $name=$emp['name'];
                                                        echo '<option value="'.$emp_id.'">'.$name.'</option>';
                                                    } ?>

                                                </select>
                                            </th>


                                        </tr>
                                        </thead>


                                    </table>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <td colspan="9"></td>
                                        </tr>
                                        </thead>
                                        <tr>
                                            <th colspan="3" scope="row"><button id="tumunu_onayla" type="button" class="btn btn-info btn-xs">Tümünü Təstiqle</button>
                                                <button id="tumunu_iptal_et" type="button" class="btn btn-danger btn-xs">Tümünü İptal Et</button>
                                            </th>
                                            <th colspan="6" scope="row"><button style="float: right;" class="btn btn-info btn-xs islem_bitir">İşlemi Bitir</button></th>
                                        </tr>
                                    </table>



                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="depo_durum" value="<?php echo $depo_durum;?>">

<style>
    div.dataTables_wrapper div.dataTables_info
    {
        display: none !important;
    }
    div.dataTables_wrapper div.dataTables_paginate ul.pagination
    {
        display: none !important;
    }
    .table th, .table td
    {
        padding: 9px !important;
    }
</style>

<script type="text/javascript">


    var depo_durum=0;


    $(document).on('click',"#onay_iste",function(e) {

        var talep_id=<?php echo  $_GET['id']; ?>;
        jQuery.ajax({
            url: baseurl + 'requested/yazilim_bildirimi',
            type: 'POST',
            data: {
                'talep_id':talep_id,
            },
            dataType: 'json',
            beforeSend: function(){
                $("#onay_iste").html('Bekleyiniz');
                $("#onay_iste").prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $("#onay_iste").html('Onay Sistemine Sunulmuştur.');
                    $("#onay_iste").prop('disabled', true); // disable button

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

    $(document).on('click',"#onay_iste_dev",function(e) {

        var talep_id=<?php echo  $_GET['id']; ?>;
        jQuery.ajax({
            url: baseurl + 'requested/bildirim_olustur',
            type: 'POST',
            data: {
                'talep_id':talep_id,
            },
            dataType: 'json',
            beforeSend: function(){
                $("#onay_iste").html('Bekleyiniz');
                $("#onay_iste").prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $("#onay_iste").html('Onay Sistemine Sunulmuştur.');
                    $("#onay_iste").prop('disabled', true); // disable button

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

    $(document).on('click',"#tumunu_onayla",function(e) {

        jQuery.ajax({
            url: baseurl + 'form/malzeme_talep_product_status_toplu',
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


    $(document).on('click',"#tumunu_iptal_et",function(e) {

        jQuery.ajax({
            url: baseurl + 'form/malzeme_talep_product_status_toplu_iptal',
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
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 3000);
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


        var depo_mik=0;

        var depo_durum =$('#depo_durum').val();

        if(depo_durum==1)
        {
            depo_mik=$(".depo_var_olan_mik").eq(eq).val();
        }
        var product_id=$(".product_id").eq(eq).val();
        var talep_id=$(".talep_id").eq(eq).val();
        var note=$(".note").eq(eq).val();
        var satin_alma_=$(".satin_alma_").eq(eq).val();
        var tip=1;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        if(satin_alma_==0)
        {
            alert("Satın Alma Personeni Seçiniz");
        }
        else
        {
            if(status==3)
            {
                $(this).closest('tr').css('background-color','rgb(69 187 149)');
                $(this).closest('tr').css('color','white');
            }
            else if(status==4)
            {
                $(this).closest('tr').css('background-color','#f9798b');
                $(this).closest('tr').css('color','white');
            }
            else
            {
                $(this).closest('tr').css('background-color','white');
                $(this).closest('tr').css('color','#404E67');
            }
            jQuery.ajax({
                url: baseurl + 'form/malzeme_talep_product_status',
                type: 'POST',
                data: {
                    'product_id':product_id,
                    'talep_id':talep_id,
                    'satin_alma_':satin_alma_,
                    'tip':tip,
                    'note':note,
                    'pers_id':pers_id,
                    'status':status,
                    'depo_mik':depo_mik,
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
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/malzeme_talep_islem_bitir',
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

    $("#pers_dep_list").on('change',function () {

        $("#personel_list option").remove();
        $(".satin_alma_ option").remove();
        var dep=$('#pers_dep_list').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'form/personel_list',
            data:
                'dep='+ dep+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#personel_list').append($('<option>').val(0).text('Satın Almaya Atanan Personel'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#personel_list").append('<option value="'+ item.id +'">'+ item.name+'</option>');
                    });

                    $('.satin_alma_').append($('<option>').val(0).text('Satın Almaya Atanan Personel'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $(".satin_alma_").append('<option value="'+ item.id +'">'+ item.name+'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    })


    $('.tumunu_sec').on('change',function () {
        var deger=$('.tumunu_sec').val();


        $('.satin_alma_').val(deger);
    });


    $(function () {




        // disc_degis($('#discount_rate').val());

        $('.select-box').select2();
    });

    $(document).ready(function () {

        window.setTimeout(function () {
            $('.select-box').select2();
        }, 2000);


        draw_data();

        function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('form/ajax_list_talep')?>",
                    'type': 'POST',
                    'data': {
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        alt_firma:alt_firma,
                        status:status,
                        proje_id:proje_id,
                        tip:<?php echo $_GET['id'] ?>
                    }
                },
                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Malzeme Talep Formu '+'<?php echo $invoice['talep_no'] ?>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7]
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Malzeme Talep Formu '+'<?php echo $invoice['talep_no'] ?>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7]
                        }
                    },
                    {
                        extend: 'csv',
                        title: 'Malzeme Talep Formu '+'<?php echo $invoice['talep_no'] ?>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7]
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Malzeme Talep Formu '+'<?php echo $invoice['talep_no'] ?>',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7]
                        }
                    },
                ]
            });



        };

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var alt_firma = $('#alt_firma').val();
            var status = $('#status').val();
            var proje_id = $('#proje_id').val();
            var invoice_type_id = $('#invoice_type_id').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,alt_firma,status,proje_id,invoice_type_id);

        });
    });


</script>
<script>
    $(document).on('click', "#arastirma_talep_olustur", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model").serialize();
        var action_url= $('#form_model #action-url').val();
        $("#personel_bildirimi").modal('hide');
        saveMDataa(o_data,action_url);
    });


    $(document).on('click', "#proje_guncelle", function (e) {
        e.preventDefault();
        var o_data =  $("#proje_degistir #form_model").serialize();
        var action_url= $('#proje_degistir #form_model #action-url').val();
        $("#proje_degistir").modal('hide');
        saveMDataa(o_data,action_url);
        window.setTimeout(function () {
            window.location.reload();
        }, 2000);
    });



    $(document).on('click', "#talep_kapat_btn", function (e) {
        e.preventDefault();
        var o_data =  $("#talep_kapat #form_model").serialize();
        var action_url= $('#talep_kapat #form_model #action-url').val();
        $("#talep_kapat").modal('hide');
        saveMDataa(o_data,action_url);
        window.setTimeout(function () {
            window.location.reload();
        }, 2000);
    });
    function saveMDataa(o_data,action_url) {
        var errorNum = farmCheck();
        if (errorNum > 0) {
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("#notify .message").html("<strong>Hata</strong>");
            $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
        } else {
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {


                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                        window.setTimeout(function () {
                            window.location.reload();
                        }, 3000);
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
    }


        $('#proje_bolum_id_key').on('change',function () {
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


    $(document).on('click', "#talep_iptal", function (e) {
        let sf_id = $(this).attr('sf_id');
        let status = 0;
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;

                html += '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Talebi İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);

                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady: function () {
            },
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Açıklama Zorunludur',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }

                        let desc = $('#desc').val()
                        jQuery.ajax({
                            url: baseurl + 'form/talep_iptal',
                            dataType: "json",
                            method: 'post',
                            data: 'desc=' + desc + '&status=' + status + '&talep_id=' + sf_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                } else {
                                    $.alert(data.message);
                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
                            }
                        });


                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })


</script>

