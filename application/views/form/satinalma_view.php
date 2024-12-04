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

                            <a href="<?php echo '/requested/satinalma_edit?id=' . $invoice['id']; ?>" class="btn btn-warning mb-1"><i
                                        class="icon-pencil"></i> <?php echo $this->lang->line('Edit_talep') ?></a>

                            <a href="<?php echo '/form/exportxls_satinalma?id=' . $invoice['id']; ?>" class="btn btn-success mb-1">Onaylanan Ürünleri Çıkar</a>

                            <a href="#" class="btn btn-success mb-1 satinalma_emri">Satın Alma Başladı</a>

                            <?php if($invoice['bildirim_durumu']==1)
                            {
                                ?>
                                <button disabled id="onay_iste" type="button" class="btn btn-info mb-1">Onay Sistemine Sunulmuştur</button>
                                <?php
                            }
                            else {?>
                                <button  id="onay_iste" type="button" class="btn btn-info mb-1">Onay Sistemini Başlat</button>
                            <?php } ?>

                            <?php if($invoice['malzeme_talep_form_id']!=0){ ?>
                                <a target="_blank" class="btn btn-info mb-1" href="/requested/view?id=<?php echo $invoice['malzeme_talep_form_id'] ?>">Malzeme Talep Formu</a>
                            <?php } else if($invoice['ihale_formu_id']!=0) {
                                ?>
                                <a target="_blank" class="btn btn-info mb-1" href="/ihale/view?id=<?php echo $invoice['ihale_formu_id'] ?>">İhale Formu</a>

                                <?php
                            } ?>

                            <button id="talep_iptal"  sf_id ="<?php echo $_GET['id']; ?>"  class="btn btn-warning mb-1">Talebi İptal Et</button>


                            <a href="#talep_kapat" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-warning mb-1">Talebi Kapat</a>



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








                            <div class="btn-group ">
                                <button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="icon-print"></i> <?php echo $this->lang->line('Print') ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="<?php echo '/requested/print_satinalma?id=' . $invoice['id']; ?>" target="_blank"><?php echo $this->lang->line('Print') ?></a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="<?php echo '/requested/print_satinalma?id=' . $invoice['id']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                </div>
                            </div>

                            <button id="proje_muduru_genel_mudur"
                                    class="btn btn-large btn-info mb-1">Proje M. Onayladığı Ü. Onayla</button>




                            <div id="urun_bilgi_popup" class="modal  fade">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content ">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                                            <h4 class="modal-title">Eksik Ürün Bilgisi</h4>
                                        </div>
                                        <div class="modal-body" id="view_object_eksik_urun">
                                            <p></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal"
                                                    class="btn"><?php echo $this->lang->line('Close') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="urun_bilgi_popup_all_firma" class="modal  fade">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content ">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                                            <h4 class="modal-title">Onay Bekleyen Ürünler</h4>
                                        </div>
                                        <div class="modal-body" id="view_object_urunler">
                                            <p></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal"
                                                    class="btn"><?php echo $this->lang->line('Close') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="onayla_popup" class="modal  fade">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content ">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                                            <h4 class="modal-title">Ürün Onaylama Ekranı</h4>
                                        </div>
                                        <div class="modal-body" id="view_object">
                                            <p></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="view-object-id" value="">

                                            <button type="button" data-dismiss="modal" id="guncelle_sayfa"
                                                    class="btn"><?php echo $this->lang->line('Close') ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>


                                $(document).on('click', "#guncelle_sayfa", function (e) {

                                    setTimeout(function () {
                                        location.reload(true);
                                    }, 1000);
                                });

                                $(document).on('click', ".urun_bilgi_popup", function (e) {
                                    e.preventDefault();
                                    var deger = <?php echo $_GET['id'] ?>;
                                    var firma_adi = $(this).attr('firma_adi');

                                    $('#view_model').modal({backdrop: 'static', keyboard: false});
                                    var actionurl = 'form/eksik_urun_bilgileri';
                                    $.ajax({
                                        url: baseurl + actionurl,
                                        data:'id='+deger+'&firma_adi='+firma_adi+'&'+crsf_token+'='+crsf_hash,
                                        type: 'POST',
                                        dataType: 'html',
                                        success: function (data) {
                                            $('#view_object_eksik_urun').html(data);

                                        }

                                    });

                                });
                                $(document).on('click', ".urun_bilgi_popup_all_firma", function (e) {
                                    e.preventDefault();
                                    var deger = <?php echo $_GET['id'] ?>;

                                    $('#view_model').modal({backdrop: 'static', keyboard: false});
                                    var actionurl = 'form/eksik_urun_bilgileri_onay';
                                    $.ajax({
                                        url: baseurl + actionurl,
                                        data:'id='+deger+'&'+crsf_token+'='+crsf_hash,
                                        type: 'POST',
                                        dataType: 'html',
                                        success: function (data) {
                                            $('#view_object_urunler').html(data);


                                        }

                                    });

                                });


                                $(document).on('click', ".onayla_popup", function (e) {
                                    e.preventDefault();
                                    var deger = <?php echo $_GET['id'] ?>;
                                    var product_name = $(this).attr('product_name');

                                    $('#view_model').modal({backdrop: 'static', keyboard: false});
                                    var actionurl = 'form/urun_bilgileri';
                                    $.ajax({
                                        url: baseurl + actionurl,
                                        data:'id='+deger+'&product_name='+product_name+'&'+crsf_token+'='+crsf_hash,
                                        type: 'POST',
                                        dataType: 'html',
                                        success: function (data) {
                                            $('#view_object').html(data);

                                        }

                                    });

                                });


                                $(document).on('click', ".satinalma_emri", function (e) {
                                    e.preventDefault();
                                    var id = <?php echo $_GET['id'] ?>;
                                    var actionurl = 'form/satinalma_emri_olustur';
                                    $.ajax({
                                        url: baseurl + actionurl,
                                        data:'id='+id+'&'+crsf_token+'='+crsf_hash,
                                        type: 'POST',
                                        dataType: 'json',
                                        beforeSend: function(){
                                            $(this).html('Bekleyiniz');
                                            $(this).prop('disabled', true); // disable button

                                        },
                                        success: function (data) {

                                            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                                            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                                            $("html, body").scrollTop($("body").offset().top);

                                        },
                                        error: function (data) {
                                            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                                            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                                            $("html, body").scrollTop($("body").offset().top);
                                        }

                                    });

                                });
                            </script>


                            </div><?php
                        } else {
                            echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                        } ?>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">
                            <p><b>Toplam <a  data-toggle="modal" data-remote="false" class="urun_bilgi_popup_all_firma" href="#urun_bilgi_popup_all_firma"><?php echo $sayis=satin_alma_urun_sayisi($_GET['id']);   ?></a>  Adet Ürün İçin Fiyat Aldınız.</b></p>

                            <?php
                            $string='proje_muduru_status';
                            if($this->aauth->get_user()->id==$invoice['proje_muduru_id'])
                            {
                                $string="proje_muduru_status";
                            }
                            else if($this->aauth->get_user()->id==$invoice['genel_mudur_id'])
                            {
                                $string="genel_mudur_status";
                            }
                            else if($this->aauth->get_user()->id==$invoice['finans_departman_pers_id'])
                            {
                                $string="finans_status";
                            }



                            if($string!=''){
                                ?>
                                <p><b>Toplam <?php echo satin_alma_urun_onay_sayisi(2,$_GET['id'],$string); ?> Adet Ürün İçin Onay Verdiniz.</b></p>
                                <p><b>Toplam <a  data-toggle="modal" data-remote="false" class="urun_bilgi_popup_all_firma" href="#urun_bilgi_popup_all_firma"><?php echo $sayis-satin_alma_urun_onay_sayisi(2,$_GET['id'],$string); ?></a> Adet Ürün Onay Bekliyor.</b></p>

                            <?php } ?>




                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                            <h2>Satın Alma Formu</h2>
                            <p style="font-size: 12px;"> <?php echo $this->config->item('prefix') . ' #' . $invoice['talep_no'] . '</p>'; ?>

                                <?php echo '<p  style="font-size: 12px;"><span class="text-muted">'.$this->lang->line('creation date').'  :</span> ' . dateformat($invoice['olusturma_tarihi']) . '</p>
                           ';
                                ?>

                            <p style="font-size: 12px;"> <?php echo $this->lang->line('project_name') . ': ' . $invoice['proje_name'] . '</p>';?>
                            <p style="font-size: 12px;">Satın Alma Sorumlusu : <?php echo personel_details($invoice['satinalma_personeli']) ?></p>
                            <p style="font-size: 12px;">Satın Alma Müdürü :  <?php echo personel_details($invoice['satinalma_mudur_id']) ?></p>
                            <?php if($invoice['status']==4) {
                                ?>
                                <p  style="padding-left: 12px;"> <?php echo '<span class="text-danger">İptal Eden Persone ve Açıklama : </span> ' . personel_details($invoice['iptal_pers_id']).' | '.$invoice['iptal_desc']; ?></p>
                                <?
                            } ?>

                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->

                    <!--/ Invoice Customer Details -->

                    <style>
                        .table th, .table td
                        {
                            padding: 3px 11px !important;
                        }
                        .table th, .table td
                        {
                            border: 1px solid #a5a5a5 !important;

                        }
                        .btn-danger
                        {
                            font-size: 21px !important;
                        }
                    </style>


                    <hr>
                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table col-sm-12">
                                <table class="table table-striped" id="crtstable">
                                    <thead>

                                    <tr>
                                        <!--th style="text-align: center"><input class="input-sm" type="checkbox" id="tumunu_sec" checked></th-->
                                        <th>Firma</th>
                                        <th>Firma Telefon</th>
                                        <th>Toplam Fiyat</th>
                                        <th>Teklif Durumu</th>
                                        <th>PDF</th>
                                        <th>Onay / İptal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;
                                    $i=1;

                                    $sayi = count($firmalar);

                                    foreach ($firmalar as $key=>$row) {

                                        $disc=0;
                                        if($discount){

                                            foreach ($discount as $dis){

                                                if($dis['firma_id']==$row->firma_id){
                                                    $disc=$dis['dis'];
                                                }
                                            }
                                        }


                                        $str='';
                                        if(firma_teklif_count($row->firma,$_GET['id'])==$sayis)
                                        {
                                            $str = '<td rowspan="1" width="20%" style="">Firma Tüm Ürünlere Teklif Vermiştir.</td>';
                                        }
                                        else
                                        {
                                            $kalan = $sayis-firma_teklif_count($row->firma,$_GET['id']);

                                            $str='<td style="background: #ff000085;color: white;" rowspan="1" width="20%" >Firma <b><a href="#urun_bilgi_popup" style="color: #2c5252 !important;" class="urun_bilgi_popup" firma_adi="'.$row->firma.'"  data-toggle="modal" data-remote="false" >'.abs($kalan).'</a></b> Ürün Eksik Şekilde Teklif Vermiştir</td>';

                                        }

                                        ?>
                                        <tr>

                                            <td rowspan="1" width="15%" style="text-align: center;line-height: 14px;"><a  href="#onayla_popup"  product_name="<?php echo $row->firma_id ?>" data-toggle="modal" data-remote="false" class="btn btn-primary mb-1 onayla_popup"><?php echo customer_details($row->firma_id)['company'] ?></a></td>
                                            <td rowspan="1" width="10%" style="text-align: center"><?php echo $row->firma_tel ?></td>
                                            <td rowspan="1" width="20%" style=""><?php $totals = firma_teklif_tutar($row->firma,$_GET['id'],$invoice['para_birimi']); $totals=$totals-floatval($disc); echo amountFormat($totals) ?> <?php echo "İndirim Tutarı : ". amountFormat($disc) ?> <?php if(firma_teklif_tutar_ekstra($row->firma,$_GET['id'])!=0) { ?> - Ekstra Teklif <?php echo amountFormat(firma_teklif_tutar_ekstra($row->firma,$_GET['id']),$invoice['para_birimi']);  } ?></td>


                                            <?php echo $str; ?>
                                            <td rowspan="1" width="20%" style="">
                                                <a href="/form/print_teklif_firma?id=<?php echo $_GET['id']?>&firma_id=<?php echo $row->firma_id ?>" class="btn btn-info btn-sm">Firmanın Teklif Verdiği PDF</a>&nbsp;
                                                <a href="/form/print_teklif_firma_ekstra?id=<?php echo $_GET['id']?>&firma_id=<?php echo $row->firma_id ?>" class="btn btn-info btn-sm">E</a>&nbsp;
                                                <a href="/form/onaylanan_print_teklif_firma?id=<?php echo $_GET['id']?>&firma_id=<?php echo $row->firma_id ?>" class="btn btn-info btn-sm">Genel Müdürün Onayladığı PDF</a>
                                            </td>
                                            <td rowspan="1" width="20%" style="">

                                                <button  firma_adi="<?php echo $row->firma ?>" class="btn btn-success btn-xs firma_onayla"  status="3" >✓</button>
                                                <button  firma_adi="<?php echo $row->firma ?>" class="btn btn-success btn-xs firma_iptal" style="background-color: #ff7588 !important;border-color: #ff7588 !important;"  status="4" >x</button>
                                                <?php if(firma_onay_kontrol($_GET['id'],$row->firma)) {?>
<button class="btn btn-success btn-xs create-discount-for-supply" sf_id="<?php echo $_GET['id'] ?>" firma="<?php echo $row->firma_id ?>"><i class="fa fa-tags"></i></button>

<!--												<div>-->
<!--<button class="btn btn-success btn-xs odeme_talebi_create" sf_id="--><?php //echo $_GET['id'] ?><!--" firma="--><?php //echo $row->firma ?><!--" style="background-color: #dcb622 !important;border-color: #dcb622 !important;"><b>Ön Ödeme Talep Et</b></button>-->
<!--												</div>-->
                                            <?php } ?>
                                            </td>

                                        </tr>


                                        <?php
                                        $c++;
                                        $i++;
                                        $sub_t+=firma_teklif_tutar($row->firma,$_GET['id']);

                                    } ?>
                                    <tr>
                                        <td colspan="2" style="text-align: right"><b>Ortalama</b></td>
                                        <td colspan="1" style="text-align: left"><b><?php echo amountFormat(($sub_t/$sayi),$invoice['para_birimi']) ?></b></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-xs-center text-md-left">

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Satın Alma Personeli</br><?php echo ' ('.personel_details($invoice['kullanici_id']).')'?></th>
                                            <th>Proje Müdürü</br><?php echo ' ('.personel_details($invoice['proje_muduru_id']).')'?></th>
                                            <th>Genel Müdürü</br><?php echo ' ('.personel_details($invoice['genel_mudur_id']).')'?></th>
                                            <th>Finans Departmanı</br><?php echo ' ('.personel_details($invoice['finans_departman_pers_id']).')'?></th>
                                        </tr>
                                        <td><?php echo $invoice['aciklama']?></td>
                                        <td><?php echo onay_durumlari_ogren_satin_alma(2,$_GET['id'],'proje_muduru_status','proje_muduru') ?></td>
                                        <td><?php echo onay_durumlari_ogren_satin_alma(2,$_GET['id'],'genel_mudur_status','genel_mudur') ?></td>
                                        <td><?php echo onay_durumlari_ogren_satin_alma(2,$_GET['id'],'finans_status','finans') ?></td>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--button onclick="exportTableToCSV($('#crtstable'), 'export.xls')">Çıkar</button-->

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

    $("#tumunu_sec").change(function() {
        if (this.checked) {
            $(".tumunu_sec").each(function() {
                this.checked=true;
            });
        } else {
            $(".tumunu_sec").each(function() {
                this.checked=false;
            });
        }
    });

    function onayla(id) {
        var array = [];

        $(".tumunu_sec:checked").map(function(){
            array.push($(this).val());
        });
        var talep_id=<?php echo $_GET['id'] ?>;
        var tip=2;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/satinalma_item_onay',
            type: 'POST',
            data: {
                'item_ids':array,
                'talep_id':talep_id,
                'tip':tip,
                'pers_id':pers_id,
                'status':id,
            },
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {

                if (data.status == "Success") {

                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });

    }

    function onayla2() {


        var talep_id=<?php echo $_GET['id'] ?>;
        var firma_adi=$('#firma_id').val();
        var status=$('#firma_sec').attr('status');
        var tip=2;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/satinalma_item_onay_firma_bazli',
            type: 'POST',
            data: {
                'firma_adi':firma_adi,
                'talep_id':talep_id,
                'tip':tip,
                'pers_id':pers_id,
                'status':status
            },
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {

                if (data.status == "Success") {

                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });

    }

    function exportTableToCSV($table, filename) {

        //rescato los títulos y las filas
        var $Tabla_Nueva = $table.find('tr:has(td,th)');
        // elimino la tabla interior.
        var Tabla_Nueva2= $Tabla_Nueva.filter(function() {
            return (this.childElementCount != 1 );
        });


        var $rows = Tabla_Nueva2,
            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // Solo Dios Sabe por que puse esta linea
            colDelim = (filename.indexOf("xls") !=-1)? '"\t"': '","',
            rowDelim = '"\r\n"',


            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row);
                var   $cols = $row.find('td:not(.hidden),th:not(.hidden)');

                return $cols.map(function (j, col) {
                    var $col = $(col);
                    var text = $col.text().replace(/\./g, '');
                    return text.replace('"', '""'); // escape double quotes

                }).get().join(tmpColDelim);
                csv =csv +'"\r\n"' +'fin '+'"\r\n"';
            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"';



        download_csv(csv, filename);


    }



    function download_csv(csv, filename) {
        var csvFile;
        var downloadLink;
        var BOM = "\uFEFF";
        // CSV FILE
        csvFile = new Blob([csv], { type: 'application/vnd.ms-excel' });

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // We have to create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Make sure that the link is not displayed
        downloadLink.style.display = "none";

        // Add the link to your DOM
        document.body.appendChild(downloadLink);

        // Lanzamos
        downloadLink.click();
    }
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

    $(document).on('click', "#proje_muduru_genel_mudur", function (e) {

        var talep_id=<?php echo $_GET['id'] ?>;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/proje_muduru_urunleri_onayla',
            type: 'POST',
            data: {
                'talep_id':talep_id,
                'pers_id':pers_id,
                'status':3,
            },
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {

                if (data.status == "Success") {

                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });


    });

    $(document).on('click', ".firma_onayla,.firma_iptal", function (e) {

        var talep_id=<?php echo $_GET['id'] ?>;
        var firma_adi=$(this).attr('firma_adi');
        var status=$(this).attr('status');
        var tip=2;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/satinalma_item_onay_firma_bazli',
            type: 'POST',
            data: {
                'firma_adi':firma_adi,
                'talep_id':talep_id,
                'tip':tip,
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

                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });


    });

    $(document).on('click', ".onayla_,.iptal", function (e) {

        var status=$(this).attr('status');
        if(status==3)
        {
            $(this).closest('tr').css('background-color','rgb(107 107 107)');
            $(this).closest('tr').css('color','white');
        }
        else
        {
            $(this).closest('tr').css('background-color','white');
            $(this).closest('tr').css('color','#404E67');
        }


        e.preventDefault();
        var eq=$(this).parent().parent().index();

        var item_alt_id=$(this).attr('item_id');


        var talep_id=<?php echo $_GET['id'] ?>;
        var notes=$('.notes').eq(eq-1).val();
        var tip=2;


        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/satinalma_item_onay_products',
            type: 'POST',
            data: {
                'item_ids':item_alt_id,
                'talep_id':talep_id,
                'notes':notes,
                'tip':tip,
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

                    $("#notifys .messages").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notifys").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notifys .messages").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

            },
            error: function (data) {
                $("#notifys .messages").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notifys").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });




    });

    $(document).on('click', ".kayit_ekle", function (e) {
        e.preventDefault();
        var eq=$(this).parent().parent().index();

        var talep_id=<?php echo $_GET['id'] ?>;
        var secenek_note=$('.secenek_note').val();
        var secenek=$('.secenek').val();
        var product_name=$('#product_name').val();
        var tip=2;
        var pers_id=<?php echo  $this->aauth->get_user()->id; ?>;

        jQuery.ajax({
            url: baseurl + 'form/satinalma_item_onay_detay',
            type: 'POST',
            data: {
                'secenek_note':secenek_note,
                'product_name':product_name,
                'secenek':secenek,
                'talep_id':talep_id,
                'tip':tip,
                'pers_id':pers_id,
                'status':3,
            },
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {

                if (data.status == "Success") {

                    $("#notifys .messages").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notifys").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notifys .messages").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

            },
            error: function (data) {
                $("#notifys .messages").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notifys").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });




    });

    $(document).on('click',"#onay_iste",function(e) {

        var talep_id=<?php echo  $_GET['id']; ?>;
        jQuery.ajax({
            url: baseurl + 'requested/bildirim_olustur_satin_alma',
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


	$(document).on('click', ".create-discount-for-supply", function (e) {
        let sf_id = $(this).attr('sf_id');
        let firma = $(this).attr('firma');
        $.confirm({
			theme: 'material',
			closeIcon: true,
			title: 'Seçilmiş firmaya uyğun qiymət endirimi',
			icon: 'fa fa-tags',
			type: 'green',
			animation: 'scale',
			useBootstrap: true,
			columnClass: "col-md-6 mx-auto",
			containerFluid: !0,
			smoothContent: true,
			draggable: false,
			content:'' +
				'<form action="" class="formName">' +
				'<div class="form-group">' +
				'<label>Endirim məbləği</label>' +
				'<input type="text" placeholder="Məbləği daxil edin" id="discount-amount" class="form-control" required />' +
				'</div>' +
				'</form>',
			buttons: {
				formSubmit: {
                    text: 'Endrirmi tədbiq et',
                    btnClass: 'btn-success',
                    action: function () {
                        let discount = this.$content.find('#discount-amount').val();
                        if(discount < 1){
                            $.alert('Endirim məbləği yanlış daxil edilib');
                            return false;
                        }
						let postData = {
							sf_id: sf_id,
							firma: firma,
							discount: discount
						};
						$.post(baseurl + 'form/discount_create', postData, (response) => {
							let res = JSON.parse(response);
							if(res.code == 410){
								$.alert(res.error);
								return false;
							}
							if(res.code == 200){
								window.location.reload();
							}
						});
                    }
                },
                cancel: {
					text: 'Pəncərəni bağla',
					action: function(){
					}
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
		})
	});

    $(document).on('click', ".odeme_talebi_create", function (e) {
        let sf_id = $(this).attr('sf_id');
        let firma = $(this).attr('firma');
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
                    '<p>Ödeme Talebi Etmek Üzeresiniz! Emin misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Ödeme Tipi</label>' +
                    '<select class="form-control method" name="method" id="method"><option value="1">Nakit</option><option value="3">Banka</option></select>'+
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Net Toplam</label>' +
                    '<input type="number" disabled name="net_tutar" id="net_tutar" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Toplam KDV</label>' +
                    '<input type="number" disabled name="total_kdv" id="total_kdv"  class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Toplam</label>' +
                    '<input type="number" disabled name="total" id="total" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Kalan</label>' +
                    '<input type="number" disabled name="kalan" id="kalan" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Talep Edilen Tutar</label>' +
                    '<input type="number" name="talep_total" onkeyup="amount_max()"  id="talep_total" class="form-control name" />' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    sf_id: sf_id,
                    firma: firma,
                }

                $.post(baseurl + 'form/sf_info_firma', data, (response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    if(responses.status=='Success'){
                        $('#net_tutar').val(responses.net_tutar.toFixed(2));
                        $('#total_kdv').val(responses.tax.toFixed(2));
                        $('#total').val(responses.total.toFixed(2));
                        $('#kalan').val(responses.kalan.toFixed(2));
                        $('#talep_total').attr('max',responses.kalan.toFixed(2))
                        if(responses.method){
                            $('.method').val(responses.method)
                        }
                    }
                    else {
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content:responses.message,
                            buttons: {
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                        $('.close').click();
                        return false;

                    }

                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady: function () {
            },
            buttons: {
                formSubmit: {
                    text: 'Onayla',
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
                        let talep_total = $('#talep_total').val();
                        let total_kdv = $('#total_kdv').val();
                        let net_tutar = $('#net_tutar').val();
                        let total = $('#total').val();
                        let method = $('#method').val();
                        jQuery.ajax({
                            url: baseurl + 'form/odeme_talep_create',
                            dataType: "json",
                            method: 'post',
                            data: 'method=' + method + '&total=' + total + '&net_tutar=' + net_tutar + '&total_kdv=' + total_kdv + '&talep_total=' + talep_total + '&desc=' + desc + '&sf_id=' + sf_id + '&firma=' + firma + '&tip=' + 'sf' +  '&' + crsf_token + '=' + crsf_hash,
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

    function amount_max(){

        let element='#talep_total';
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }


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





</script>
