
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Avans Görüntüle</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
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
                                                                if ($invoice['status'] != 'canceled') { ?>
                                                                    <div class="title-action">

                                                                    <a href="<?php echo 'avans_edit?id=' . $invoice['id']; ?>" class="btn btn-warning mb-1"><i
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
                                                                               href="<?php echo 'avansprintinvoice?id=' . $invoice['id']; ?>" target="_blank"><?php echo $this->lang->line('Print') ?></a>

                                                                            <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item"
                                                                               href="<?php echo 'avansprintinvoice?id=' . $invoice['id']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                                                        </div>
                                                                    </div>

                                                                    <div class="btn-group ">
                                                                        <button id="talep_iptal"  sf_id ="<?php echo $_GET['id']; ?>"  class="btn btn-warning mb-1">Talebi İptal Et</button>


                                                                    </div>
                                                                    <div class="btn-group ">

                                                                        <a href="#talep_kapat" data-toggle="modal" data-remote="false"
                                                                           class="btn btn-large btn-danger mb-1">Talebi Kapat</a>

                                                                    </div>
                                                                    <div class="btn-group ">

                                                                        <button id="status_change"  data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-success mb-1">Durum Güncelle</button>&nbsp;

                                                                    </div>


                                                                    <!--                            <div class="btn-group ">-->
                                                                    <!---->
                                                                    <!--                                <a href="#odeme_emri" data-toggle="modal" data-remote="false"-->
                                                                    <!--                                   class="btn btn-large btn-success mb-1">Ödeme Emri Ver</a>-->
                                                                    <!---->
                                                                    <!--                            </div>-->



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

                                                                    <div id="odeme_emri" class="modal fade">
                                                                        <style>
                                                                            .select2-container--classic .select2-selection--single, .select2-container--default .select2-selection--single
                                                                            {
                                                                                width: 460px !important;
                                                                            }
                                                                        </style>
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">

                                                                                    <h4 class="modal-title">Ödeme Emri</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                </div>

                                                                                <div class="modal-body">
                                                                                    <form id="form_model" method="post">

                                                                                        <div class="col-md-12">
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 mb-1">
                                                                                                    <label for="pmethod">Kasa Seçiniz</label>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 mb-1">
                                                                                                    <select class="form-control mb-1 select-box" name="kasa">
                                                                                                        <option value="0">Seçiniz</option>
                                                                                                        <?php
                                                                                                        foreach (all_account() as $row) {
                                                                                                            $cid = $row->id;
                                                                                                            $acn = $row->acn;
                                                                                                            $holder = $row->holder;
                                                                                                            $doviz = para_birimi_ogren_id($row->para_birimi);
                                                                                                            $balance = amountFormat(hesap_balance($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                                                                                                            echo "<option doviz='$doviz' value='$cid'>$acn - $holder | $balance</option>";
                                                                                                        }
                                                                                                        ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 mb-1">
                                                                                                    <label for="pmethod">Ödeme Tarihi</label>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 mb-1">
                                                                                                    <input type="date" name="odeme_tarihi" class="form-control">

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 mb-1">
                                                                                                    <label for="pmethod">Açıklama</label>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 mb-1">
                                                                                                    <textarea class="form-control" name="aciklama"></textarea>

                                                                                                </div>
                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="modal-footer">

                                                                                            <button type="button" class="btn btn-default"
                                                                                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                                                                            <input type="hidden"  id="action-url" value="form/odeme_emri">
                                                                                            <input type="hidden" name="talep_id" id="talep_id"  value="<?php echo $_GET['id']?>">
                                                                                            <button type="button" class="btn btn-primary"
                                                                                                    id="odeme_emri_btn">Güncelle</button>
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
                                                                    <p class="pb-1" style="padding-left: 15px;"> <?php echo $this->lang->line('project_name') . ': ' . $invoice['proje_name'] . '</p>';?>
                                                                    <p  style="padding-left: 15px;"> <?php echo 'Bölüm Adı: ' . $invoice['proje_bolum_name'] . '</p>';?>
                                                                    <p class="pb-1" style="padding-left: 15px;"> <?php echo $this->lang->line('Description').': '. $invoice['description']. '</p>';?>
                                                                    <p  style="padding-left: 15px;"> <?php echo '<span class="text-danger">Durum : </span> ' . purchase_status($invoice['status']); ?></p>
                                                                    <?php if($invoice['status']==4) {
                                                                        ?>
                                                                        <p  style="padding-left: 15px;"> <?php echo '<span class="text-danger">İptal Eden Persone ve Açıklama : </span> ' . personel_details($invoice['iptal_pers_id']).' | '.$invoice['iptal_desc']; ?></p>
                                                                        <?
                                                                    } ?>
                                                                    <p class="pb-1" style="padding-left: 15px;">  <?php echo '<span class="text-muted">'.$this->lang->line('creation date').'  :</span> ' . dateformat($invoice['olusturma_tarihi']) . '';?> </p>

                                                                    <?php if(odeme_emri_kontrol($_GET['id']))
                                                                    {
                                                                        $kasa=odeme_emri_kontrol($_GET['id'])->odeme_emri_id;
                                                                        $odeme_tarihi=odeme_emri_kontrol($_GET['id'])->invoicedate;
                                                                        $notes=odeme_emri_kontrol($_GET['id'])->notes;
                                                                        $hesap=personel_details($kasa);
                                                                        $date=dateformat($odeme_tarihi);
                                                                        echo "<p>Ödeme Yapacak Personel : $hesap</p>";
                                                                        echo "<p >Ödeme Tarihi : $date</p>";
                                                                        echo "<p >Açıklama : $notes</p>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-8 col-sm-12 text-xs-center text-md-right">
                                                                    <h2>Avans Talep Formu</h2>
                                                                    <p class="pb-1"> <?php echo $this->config->item('prefix') . ' #' . $invoice['talep_no'] . '</p>'; ?>

                                                                        <?php
                                                                        if($invoice['cari_pers']==2){
                                                                            $inv_id=$invoice['invoice_id'];
                                                                            if($invoice['invoice_id']){
                                                                                if($invoice['talep_or_invoice']==1){
                                                                                    $details =   invoice_details($invoice['invoice_id']);
                                                                                    $dec =$details->invoice_type_desc.' '.$details->invoice_no;
                                                                                    if($details->invoice_type_id == 29 || $details->invoice_type_id == 30){
                                                                                        $href = "/invoices/print_form?id=".$inv_id;
                                                                                    }
                                                                                    else {
                                                                                        $href = "/invoices/printinvoice?id=".$inv_id;
                                                                                    }
                                                                                }
                                                                                elseif($invoice['talep_or_invoice']==3){

                                                                                    $href = "/logistics/view/".$inv_id;
                                                                                    $dec = "Lojistik Satınalma";
                                                                                }
                                                                                else {
                                                                                    $details = talep_details($invoice['invoice_id']);
                                                                                    $dec=$details->talep_no;
                                                                                    $href = "/form/satinalma_view?id=".$inv_id;
                                                                                }

                                                                                ?>
                                                                                <a href="<?php echo $href; ?>" class='btn btn-info'><?php echo $dec ?> Önizle</a>
                                                                                <?
                                                                            }

                                                                            ?>

                                                                        <?php  }
                                                                        ?>

                                                                        <?php

                                                                        if(talep_to_odeme($invoice['id'])){
                                                                            echo talep_to_odeme($invoice['id']);
                                                                        }
                                                                        ?>

                                                                        </br>
                                                                        </br>
                                                                    <p class="pb-1">Talep Oluşturan Personel : <span style="font-weight: 900"><?php echo personel_details($invoice['kullanici_id']) ?></span> </p>

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

                                                            </div>
                                                            <!--/ Invoice Customer Details -->

                                                            <!-- Invoice Items Details -->
                                                            <form id="data_form" type="POST">
                                                                <div id="invoice-items-details" class="pt-2">
                                                                    <div class="row">
                                                                        <div class="table-responsive col-sm-12">
                                                                            <table class="table table-striped">
                                                                                <thead>

                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <?php if($invoice['cari_pers']==2)
                                                                                    {
                                                                                        echo '<th>Cari</th>';
                                                                                    }
                                                                                    else {
                                                                                        echo '<th>Personel</th>';
                                                                                    }
                                                                                    ?>

                                                                                    <th>Detay</th>
                                                                                    <th width="8%"><?php echo $this->lang->line('Quantity') ?></th>
                                                                                    <th width="8%">Tutar</th>
                                                                                    <th width="8%">Toplam</th>
                                                                                    <th>Proje Sorumlusu</br><?php echo ' ('.personel_details($invoice['proje_sorumlusu_id']).')'?></th>
                                                                                    <th>Proje Müdürü</br><?php echo ' ('.personel_details($invoice['proje_muduru_id']).')'?></th>
                                                                                    <th>Bölüm Müdürü </br><?php echo ' ('.personel_details($invoice['bolum_mudur_id']).')'?></br></th>
                                                                                    <th>Genel Müdürü </br><?php echo ' ('.personel_details($invoice['genel_mudur_id']).')'?></br></th>
                                                                                    <th>Finans Departman </br><?php echo ' ('.personel_details($invoice['finans_departman_pers_id']).')'?></br></th>


                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php $c = 1;
                                                                                $sub_t = 0;

                                                                                $pers_cari_name='';
                                                                                if($invoice['cari_pers']==1)
                                                                                {
                                                                                    $pers_cari_name=personel_details($invoice['talep_eden_pers_id']);
                                                                                }
                                                                                else
                                                                                {

                                                                                    $pers_cari_name=customer_details($invoice['talep_eden_pers_id'])['company'];
                                                                                }
                                                                                foreach ($products as $row) {
                                                                                    $product_id=$row['id'];
                                                                                    $sub_t += $row['subtotal'];
                                                                                    $price_str=' <td><input hidden name="price[]" class="form-control price" value="'.$row['price'].'">'.amountFormat($row['price']).'</td>';

//                                            if($this->aauth->get_user()->id==61)
//                                            {
//                                                $price_str=' <td><input name="price[]" class="form-control price" value="'.round($row['price'],2).'"></td>';
//                                            }
//                                            else
//                                            {
//                                                $price_str=' <td><input hidden name="price[]" class="form-control price" value="'.$row['price'].'">'.amountFormat($row['price']).'</td>';
//                                            }

                                                                                    echo '<tr>
                            <th scope="row"><button  class="btn btn-success btn-xs onayla" status="3" >✓</button>&nbsp
                            <button  class="btn btn-danger btn-xs iptal" status="4">X</button></th>
                            <td>' . $pers_cari_name.'</td>
                            <td>'.$row['product_name'].'  '. $row['product_detail'] . '</td>
                            <td>' . floatval($row['qty']) .' '. units_($row['unit'])['name'] . '</td>
                            '.$price_str.'
                            <td>' . amountFormat($row['subtotal']) . '</td>
                            <td>' .purchase_status(onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"proje_sorumlusu_status")['durum']).'<br>'.onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"proje_sorumlusu_status")['note'].'</td>
                            <td>' .purchase_status(onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"proje_muduru_status")['durum']).'<br>'.onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"proje_muduru_status")['note'].'</td>
                            <td>' .purchase_status(onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"bolum_muduru_status")['durum']).'<br>'.onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"bolum_muduru_status")['note'].'</td>
                            <td>' .purchase_status(onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"genel_mudur_status")['durum']).'<br>'.onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"genel_mudur_status")['note'].'</td>
                            <td>' .purchase_status(onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"finans_status")['durum']).'<br>'.onay_durumlari_ogren_product_str(5,$_GET['id'],$product_id,"finans_status")['note'].'</td>
                            <input type="hidden" class="product_id" name="product_id[]" value="'.$product_id.'">
                            <input type="hidden" class="talep_id" name="talep_id[]" value="'.$invoice['id'].'">
                            <input type="hidden" class="pers_id" name="pers_id[]" value="'.$this->aauth->get_user()->id.'">
                        </tr>';


                                                                                    $c++;
                                                                                } ?>

                                                                                <tr>
                                                                                    <th colspan="1" scope="row"><button id="tumunu_onayla" type="button" class="btn btn-info btn-xs">Tümünü Təstiqle</button></th>
                                                                                    <th colspan="1" scope="row"></th>
                                                                                    <th colspan="1" scope="row"></th>
                                                                                    <th colspan="1" scope="row"></th>
                                                                                    <th colspan="1" scope="row"></th>
                                                                                    <th colspan="1" scope="row"><?php echo amountFormat($sub_t)?></th>
                                                                                    <th colspan="8" scope="row"><button style="float: right;" class="btn btn-info btn-xs islem_bitir">İşlemi Bitir</button></th>
                                                                                </tr>

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                            </form>
                                                            <div class="row">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><?php echo $this->lang->line('Files') ?></th>


                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="activity">
                                                                    <?php foreach ($attach as $row) {

                                                                        echo '<tr><td><a data-url="' . base_url() . 'form/avans_file_handling?op=delete&name=' . $row['col1'] . '&talep_id=' . $invoice['id'] . '" class="aj_delete"><i class="btn-danger btn-lg fa fa-trash"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
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
                                                                <pre>Tip: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
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
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(document).on('click',"#tumunu_onayla",function(e) {

        jQuery.ajax({
            url: baseurl + 'form/avans_talep_product_status_toplu',
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
        var price=$(".price").eq(eq).val();
        var tip=5;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/avans_talep_product_status',
            type: 'POST',
            data: {
                'product_id':product_id,
                'talep_id':talep_id,
                'tip':tip,
                'note':note,
                'pers_id':pers_id,
                'status':status,
                'price':price,
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




    });


    $(document).on('click', ".islem_bitir", function (e) {
        e.preventDefault();
        var talep_id=<?php echo  $_GET['id']; ?>;
        var pers_id=<?php echo  $this->aauth->get_user()->id ?>;

        jQuery.ajax({
            url: baseurl + 'form/avans_talep_islem_bitir',
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
                        <input type="hidden" class="form-control required"
                               name="talep_id" id="invoiceid" value="<?php echo $invoice['id'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="requested/update_status">
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



    $(document).on('click', "#odeme_emri_btn", function (e) {
        e.preventDefault();
        var o_data =  $("#odeme_emri #form_model").serialize();
        var action_url= $('#odeme_emri #form_model #action-url').val();
        $("#odeme_emri").modal('hide');
        saveMDataa(o_data,action_url);

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


    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>form/avans_file_handling?id=<?php echo $invoice['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>form/avans_file_handling?op=delete&name=' + file.name + '&talep_id=<?php echo $invoice['id'] ?>" class="aj_delete"><i class="btn-danger btn-lg fa fa-trash"></i> ' + file.name + ' </a></td></tr>');

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
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                '</div></form>',
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

    $(document).on('click', "#status_change", function (e) {
        let id = $(this).attr('data-id');
        $.confirm({
            title: 'Dikkat!',
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Durum</label>' +
                '<select class="form-control" id="form_2_status_id"><option value="11">Bankada</option><option value="6">Kapatıldı</option><option value="4">İptal</option></select>' +
                '</div>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let form_2_status_id = $('#form_2_status_id').val()
                        jQuery.ajax({
                            url: baseurl + 'invoices/form2_status_change',
                            dataType: "json",
                            method: 'post',
                            data: 'status_id='+form_2_status_id+'&talep_id='+id+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    window.setTimeout(function () {
                                        window.location.reload();
                                    }, 1000);
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
                cancel: function () {
                    //close
                },
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
