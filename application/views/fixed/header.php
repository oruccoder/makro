<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title><?php echo $title?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?= base_url().'assets/global_assets/css/icons/icomoon/styles.min.css?v='.rand(11111,99999) ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url().'assets/assets_file/css/components.min.css?v='.rand(11111,99999) ?>" rel="stylesheet" type="text/css">
    <link href="<?='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url().'assets/assets_file/css/all.min.css?v='.rand(11111,99999) ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url().'assets/assets_file/css/style.css?v='.rand(11111,99999) ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url().'assets/assets_file/css/custom.css?v='.rand(11111,99999) ?>" rel="stylesheet" type="text/css">
    <script src="<?= base_url().'assets/global_assets/js/main/jquery.min.js?v='.rand(11111,99999)?>"></script>
    <script src="<?= base_url().'assets/global_assets/js/main/bootstrap.bundle.min.js?v='.rand(11111,99999)?>"></script>
    <script src="<?= base_url().'assets/assets_file/js/app.js?v='.rand(11111,99999)?>"></script>
    <script src="<?= base_url().'assets/assets_file/js/app-menu.js?v='.rand(11111,99999)?>"></script>
    <script src="<?php echo base_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>

    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script src="<?php echo base_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/portjs/accounting.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/app-assets/js/datetimepickers/jquery.datetimepicker.css"/>
    <script src="/app-assets/js/datetimepickers/jquery.datetimepicker.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/app-assets/js/datetimepickers/build/jquery.datetimepicker.full.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/app-assets/js/datetimepickers/build/jquery.datetimepicker.full.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script>
        let baseurl="<?= base_url()?>";
        let  crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
    </script>

<?php
    $csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
    );
?>

    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

    <!--Start of Tawk.to Script-->
<!--    <script type="text/javascript">-->
<!--        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();-->
<!--        (function(){-->
<!--            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];-->
<!--            s1.async=true;-->
<!--            s1.src='https://embed.tawk.to/62f0e5b537898912e961d5ba/1g9ug2jql';-->
<!--            s1.charset='UTF-8';-->
<!--            s1.setAttribute('crossorigin','*');-->
<!--            s0.parentNode.insertBefore(s1,s0);-->
<!--        })();-->
<!--    </script>-->
    <!--End of Tawk.to Script-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


</head>
<body tabindex="0">
<div class="navbar navbar-expand-lg navbar-dark bg-dark navbar-static shadow-none">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="navbar-brand wmin-0 mr-lg-5 p-0" style="font-size: unset !important;">
        <a href="/" class="d-inline-block">
            <div class="navbar-logo">
                <div class="pro">Makro Pro Yazılım</div>
            </div>
        </a>
    </div>
    <div class="navbar-brand wmin-0 mr-lg-5 p-0" style="font-size: unset !important;">
        <div class="overflow-auto overflow-xl-visible scrollbar-hidden flex-1">
            <!--            <ul class="navbar-nav flex-row text-nowrap align-items-center">-->
            <!--                <li class="nav-item h-100" style="    margin-top: 10px;">-->
            <!--                    <a href="/user/logout" class="navbar-nav-link d-inline-flex align-items-center h-100" data-content="Çıxış">-->
            <!--						<i class="fa fa-power-off"></i>-->
            <!--                    </a>-->
            <!--                </li>-->
            <!--            </ul>-->
            <style>
                .flash-button{
                    background:#ee5350;
                    padding:5px 10px;
                    color:#fff;
                    border:none;
                    border-radius:5px;

                    animation-name: flash;
                    animation-duration: 1s;
                    animation-timing-function: linear;
                    animation-iteration-count: infinite;

                //Firefox 1+
                -webkit-animation-name: flash;
                    -webkit-animation-duration: 1s;
                    -webkit-animation-timing-function: linear;
                    -webkit-animation-iteration-count: infinite;

                //Safari 3-4
                -moz-animation-name: flash;
                    -moz-animation-duration: 1s;
                    -moz-animation-timing-function: linear;
                    -moz-animation-iteration-count: infinite;
                }

                @keyframes flash {
                    0% { opacity: 1.0; }
                    50% { opacity: 0.5; }
                    100% { opacity: 1.0; }
                }

                //Firefox 1+
                @-webkit-keyframes flash {
                    0% { opacity: 1.0; }
                    50% { opacity: 0.5; }
                    100% { opacity: 1.0; }
                }

                //Safari 3-4
                @-moz-keyframes flash {
                    0% { opacity: 1.0; }
                    50% { opacity: 0.5; }
                    100% { opacity: 1.0; }
                }
            </style>

            <ul class="navbar-nav flex-row">

                <?php
                if(countgiderhizmet_func()){ ?>
                <li class="nav-item nav-item-dropdown-lg dropdown hizmet_tamm d-none">
                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell flash-button"></i>
                        <span class="d-none d-lg-inline-block ml-2">Hizmet Tamamlama</span>
                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up flash-button"><?php echo countgiderhizmet_func()?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                        <div class="dropdown-content-body p-2">
                            <div class="row no-gutters">

                                <?php

                                foreach (user_hizmet_tamamlama() as $items) {
                                    $tutar =  hizmet_tutar_getir($items->id)
                                    ?>
                                    <div class="col-12">
                                        <a href="/onay/giderhizmetbekleyen" target="_blank"  style="background: transparent;border: none;" type="button" class="d-block text-body text-center ripple-dark rounded p-3">
                                            <i class="icon-stack text-pink icon-2x"></i>
                                            <div class="font-size-sm font-weight-semibold text-uppercase mt-2"><span style="font-size: 10px;text-decoration: underline;"><?php echo $items->code ?></span><br> Hizmet Tamamlamanız Gereken Gider<br>
                                            <span style="text-decoration: underline;color: red;">Eğer Tamamlama Yapılmazsa Maaşınızdan <b><?php echo $tutar ?></b> Kesilecektir</span>
                                            </div>

                                        </a>
                                    </div>
                                <?php }
                                ?>

                            </div>
                        </div>
                    </div>
                </li>
                <?php }
                ?>
                <?php if(parent_locations_kontrol()){
                    ?>
                    <li class="nav-item nav-item-dropdown-lg dropdown">
                        <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="d-none d-lg-inline-block ml-2">Diğer Firmalar İçin Bildirimleriniz</span>
                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="all_count_firma">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                            <div class="dropdown-content-body p-2">
                                <div class="row no-gutters">

                                    <?php foreach (parent_locations_kontrol() as $items) { ?>
                                            <input type="hidden" class="hidden_user_id_other" value="<?php echo $items['user_id'] ?>" firma_id="<?php echo $items['firma_id'] ?>">
                                    <div class="col-4">
                                        <button  style="background: transparent;border: none;" tip="maas" type="button" class="firma_update_onay d-block text-body text-center ripple-dark rounded p-3" user_id="<?php echo $items['user_id'] ?>" firma_id="<?php echo $items['firma_id'] ?>">
                                            <i class="icon-stack text-pink icon-2x"></i>
                                            <div class="font-size-sm font-weight-semibold text-uppercase mt-2"><span style="font-size: 10px;text-decoration: underline;"><?php echo $items['firma_name'] ?></span><br> Maaş Onayı</div>
                                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up" user_id="<?php echo $items['user_id'] ?>" firma_id="<?php echo $items['firma_id'] ?>" id="maas_onayi_<?php echo $items['firma_id'] ?>">0</span>
                                        </button>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                } ?>



                <li class="nav-item nav-item-dropdown-lg dropdown">


                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="d-none d-lg-inline-block ml-2">Bekleyen Bildirimler</span>
                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="all_count">0</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                        <div class="dropdown-content-body p-2">
                            <div class="row no-gutters">
                                <div class="col-4">
                                    <!--a href="/form/bekleyen_talepler" class="d-block text-body text-center ripple-dark rounded p-3"-->
                                    <a href="/onay/malzemetaleplist" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-file-check icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Talepler</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="talepler">0</span>
                                    </a>

                                    <a href="/virman/list" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-piggy-bank text-primary icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Kasa Talepleri</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="kasa_talepleri">0</span>
                                    </a>
                                </div>

                                <div class="col-4">
                                    <a href="/reports/maas_onayi" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-stack text-pink icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Maaş Onayı</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="maas_onayi">0</span>
                                    </a>

                                    <a href="/reports/prim_onaylari" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-sort text-success icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Prim / Ceza</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="prim_ceza">0</span>
                                    </a>
                                </div>

                                <div class="col-4">
                                    <a href="/reports/bekleyen_forma_2" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-file-css text-info icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Forma2</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up forma_2_count">0</span>
                                    </a>

                                    <a href="/notification" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-map5 text-danger icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Tümü</div>
                                    </a>
                                </div>


                                <div class="col-4">
                                    <a href="/reports/customer_onay" class="d-block text-body text-center ripple-dark rounded p-3">
                                    <i style="font-size: 26px" class="fa-solid fa-manat-sign"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Cari Onayı</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="maas_onayi">2</span>
                                    </a>

                                </div>


                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i>
                        <span class="d-none d-lg-inline-block ml-2"><?php echo $this->aauth->get_user()->username ?>-<?php      $loc = $this->session->userdata('set_firma_id'); echo location($loc)['sort_name'] ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="/personelgidertalep" class="dropdown-item"><i class="icon-user-lock"></i> Giderlerim</a>
                        <a href="/personelavanstalep" class="dropdown-item"><i class="icon-coins"></i> Avanslarım</a>
                        <a href="/" class="dropdown-item"><i class="icon-comment-discussion"></i> İzinlerim</a>
                        <a href="/personelaction/tasktopersonel" class="dropdown-item"><i class="fa fa-flask"></i> Atadığım Görevler</a>
                        <a href="/personelaction/personeltotask" class="dropdown-item"><i class="fa fa-flask"></i> Atanan Görevler</a>
                        <div class="dropdown-divider"></div>
                        <a href="/user/profile" class="dropdown-item"><i class="icon-gear"></i> Profilim</a>
                        <?php if(parent_to_locations_kontrol()){
                            foreach (parent_to_locations_kontrol() as $items){
                                ?>
                                <div class="dropdown-divider"></div>
                                    <button type="button" tip="dashboard" class="firma_update_onay dropdown-item" user_id="<?php echo $items['user_id'] ?>" firma_id="<?php echo $items['firma_id'] ?>"><?php echo $items['firma_name'].'- '.$items['user_name']?></button>
                                <?php
                            }
                        } ?>

                    </div>
                </li>

                <!--                <li class="nav-item nav-item-dropdown-lg dropdown">-->
                <!--                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">-->
                <!--                        <i class="icon-pulse2"></i>-->
                <!--                        <span class="d-none d-lg-inline-block ml-2">Profilim</span>-->
                <!--                    </a>-->
                <!---->
                <!--                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">-->
                <!--                        <div class="dropdown-content-header">-->
                <!--                            <span class="font-size-sm line-height-sm text-uppercase font-weight-semibold">Latest activity</span>-->
                <!--                            <a href="#" class="text-body"><i class="icon-search4 font-size-base"></i></a>-->
                <!--                        </div>-->
                <!---->
                <!--                        <div class="dropdown-content-body dropdown-scrollable">-->
                <!--                            <ul class="media-list">-->
                <!--                                <li class="media">-->
                <!--                                    <div class="mr-3">-->
                <!--                                        <a href="#" class="btn btn-success rounded-pill btn-icon"><i class="icon-mention"></i></a>-->
                <!--                                    </div>-->
                <!---->
                <!--                                    <div class="media-body">-->
                <!--                                        <a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks"-->
                <!--                                        <div class="font-size-sm text-muted mt-1">4 minutes ago</div>-->
                <!--                                    </div>-->
                <!--                                </li>-->
                <!---->
                <!--                                <li class="media">-->
                <!--                                    <div class="mr-3">-->
                <!--                                        <a href="#" class="btn btn-pink rounded-pill btn-icon"><i class="icon-paperplane"></i></a>-->
                <!--                                    </div>-->
                <!---->
                <!--                                    <div class="media-body">-->
                <!--                                        Special offers have been sent to subscribed users by <a href="#">Donna Gordon</a>-->
                <!--                                        <div class="font-size-sm text-muted mt-1">36 minutes ago</div>-->
                <!--                                    </div>-->
                <!--                                </li>-->
                <!---->
                <!--                                <li class="media">-->
                <!--                                    <div class="mr-3">-->
                <!--                                        <a href="#" class="btn btn-primary rounded-pill btn-icon"><i class="icon-plus3"></i></a>-->
                <!--                                    </div>-->
                <!---->
                <!--                                    <div class="media-body">-->
                <!--                                        <a href="#">Chris Arney</a> created a new <span class="font-weight-semibold">Design</span> branch in <span class="font-weight-semibold">Limitless</span> repository-->
                <!--                                        <div class="font-size-sm text-muted mt-1">2 hours ago</div>-->
                <!--                                    </div>-->
                <!--                                </li>-->
                <!---->
                <!--                                <li class="media">-->
                <!--                                    <div class="mr-3">-->
                <!--                                        <a href="#" class="btn btn-purple rounded-pill btn-icon"><i class="icon-truck"></i></a>-->
                <!--                                    </div>-->
                <!---->
                <!--                                    <div class="media-body">-->
                <!--                                        Shipping cost to the Netherlands has been reduced, database updated-->
                <!--                                        <div class="font-size-sm text-muted mt-1">Feb 8, 11:30</div>-->
                <!--                                    </div>-->
                <!--                                </li>-->
                <!---->
                <!--                                <li class="media">-->
                <!--                                    <div class="mr-3">-->
                <!--                                        <a href="#" class="btn btn-warning rounded-pill btn-icon"><i class="icon-comment"></i></a>-->
                <!--                                    </div>-->
                <!---->
                <!--                                    <div class="media-body">-->
                <!--                                        New review received on <a href="#">Server side integration</a> services-->
                <!--                                        <div class="font-size-sm text-muted mt-1">Feb 2, 10:20</div>-->
                <!--                                    </div>-->
                <!--                                </li>-->
                <!---->
                <!--                                <li class="media">-->
                <!--                                    <div class="mr-3">-->
                <!--                                        <a href="#" class="btn btn-teal rounded-pill btn-icon"><i class="icon-spinner11"></i></a>-->
                <!--                                    </div>-->
                <!---->
                <!--                                    <div class="media-body">-->
                <!--                                        <strong>January, 2018</strong> - 1320 new users, 3284 orders, $49,390 revenue-->
                <!--                                        <div class="font-size-sm text-muted mt-1">Feb 1, 05:46</div>-->
                <!--                                    </div>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </div>-->
                <!---->
                <!--                        <div class="dropdown-content-footer bg-light">-->
                <!--                            <a href="#" class="font-size-sm line-height-sm text-uppercase font-weight-semibold text-body mr-auto">All activity</a>-->
                <!--                            <div>-->
                <!--                                <a href="#" class="text-body" data-popup="tooltip" title="" data-original-title="Clear list"><i class="icon-checkmark3"></i></a>-->
                <!--                                <a href="#" class="text-body ml-2" data-popup="tooltip" title="" data-original-title="Settings"><i class="icon-gear"></i></a>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </li>-->

                <li class="nav-item">
                    <a href="/user/logout" class="navbar-nav-link navbar-nav-link-toggler">
                        <i class="icon-switch2"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
<div id="person-container" class="d-none">
    <div class="media-list p-2" id="person-list"></div>
</div>
<script>
    $(function() {
        $.ajax({

            url: baseurl + 'notification/select_count',
            dataType: 'json',
            success: function (data) {
                $('#talepler').html(data.talep_count_bell);
                $('#maas_onayi').html(data.bekleyen_maas_count);
                $('.forma_2_count').html(data.forma_2_count);
                $('#kasa_talepleri').html(data.kasa_count);
                $('#prim_ceza').html(data.bekleyen_prim_count);

            },
            error: function (data) {
                $('#response').html('Error')
            }

        });

        $.ajax({
            url: baseurl + 'locations/othercompany',
            dataType: 'json',
            success: function (data) {
                if(data.status==200){
                    $.each(data.items, function (index, file) {
                        $('#'+file.id_name).html(file.count);
                       });

                    $('#all_count_firma').empty().html(data.totals)
                }


            },
            error: function (data) {
                $('#response').html('Error')
            }

        });



        $('.select-box').select2();

        jQuery.ajax({
            url: baseurl + 'notification/all_count',
            type: 'POST',
            data: crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function(data) {
                if (data.status == "Success") {
                    $('#all_count').empty().html(data.count)
                }
            },
            error: function(data) {

            }
        });
    })
</script>

<div class="navbar navbar-expand navbar-light px-0 px-lg-3">
    <div class="overflow-auto overflow-xl-visible scrollbar-hidden flex-1">
        <ul class="navbar-nav flex-row text-nowrap">
            <li class="nav-item">
                <a href="/" class="navbar-nav-link">
                    <i class="icon-home4 mr-2"></i>

                </a>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-lg">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Fatura Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>qaime/createall" class="dropdown-item"><i class="fas fa-list"></i>Yeni Fatura</a>
                    <a href="<?= base_url(); ?>qaime" class="dropdown-item"><i class="fas fa-list"></i>Fatura Listesi</a>
                    <a href="<?= base_url(); ?>formainvoices" class="dropdown-item"><i class="fas fa-list"></i>Forma2</a>
                    <a href="<?= base_url(); ?>siparis" class="dropdown-item"><i class="fas fa-list"></i>Sipariş Formu</a>
                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Cari Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>customers" class="dropdown-item"><i class="fas fa-list"></i>Cariler</a>
                    <a href="<?= base_url(); ?>customers/passive_list" class="dropdown-item"><i class="fas fa-list"></i>Pasif Cariler</a>
                    <a href="<?= base_url(); ?>clientgroup" class="dropdown-item"><i class="fas fa-list"></i>Cari Grupları</a>
                    <a href="<?= base_url(); ?>razilastirma/razilastirma_list_all" class="dropdown-item"><i class="fas fa-list"></i>Cari Razılaştırma Listesi</a>
                    <a href="<?= base_url(); ?>customers/cari_projeleri" class="dropdown-item"><i class="fas fa-list"></i>Cari Projeler</a>
                    <a href="<?= base_url(); ?>customers/carionaybekleyen" class="dropdown-item"><i class="fas fa-list"></i>Cari Onay Bekleyen</a>
                    <a href="<?= base_url(); ?>podradci" class="dropdown-item"><i class="fas fa-list"></i>Alt Podradçılar</a>
                    <a href="<?= base_url(); ?>personelp" class="dropdown-item"><i class="fas fa-list"></i>Podradçı Personeller</a>
                    <a href="<?= base_url(); ?>worker" class="dropdown-item"><i class="fas fa-list"></i>Fehle Kartları</a>
                    <a href="<?= base_url(); ?>worker/run_list" class="dropdown-item"><i class="fas fa-list"></i>Fehle Çalışmaları</a>


                </div>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Stok Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>urun" class="dropdown-item"><i class="fas fa-list"></i>Ürünler</a>
                    <a href="<?= base_url(); ?>urun/alt_urun" class="dropdown-item"><i class="fas fa-list"></i>Alt Ürünler</a>
                    <a href="<?= base_url(); ?>productoption" class="dropdown-item"><i class="fas fa-list"></i>Varyantlar</a>
                    <a href="<?= base_url(); ?>warehouse" class="dropdown-item"><i class="fas fa-list"></i>Depolar</a>
                    <button class="dropdown-item cloud_clear" id="cloud_clear"><i class="fas fa-list"></i>FİŞ LİSTEMİ TEMİZLE</button>
                    <a href="<?= base_url(); ?>stockio" class="dropdown-item"><i class="fas fa-list"></i>Stok Giriş / Çıkışları</a>
                    <a href="<?= base_url(); ?>newproductcategory" class="dropdown-item"><i class="fas fa-list"></i>Kategoriler</a>
                    <a href="<?= base_url(); ?>newunits" class="dropdown-item"><i class="fas fa-list"></i>Ölçü Birimleri</a>
                    <a href="<?= base_url(); ?>stocktransfer" class="dropdown-item"><i class="fas fa-list"></i>Stok Transferi</a>
                    <a href="<?= base_url(); ?>arac" class="dropdown-item"><i class="fas fa-list"></i>Araçlar</a>
                    <a href="<?= base_url(); ?>arac/mk_araclist" class="dropdown-item"><i class="fas fa-list"></i>Makro Araçları</a>
                    <a href="<?= base_url(); ?>demirbas" class="dropdown-item"><i class="fas fa-list"></i>Gider Yönetimi</a>
                    <a href="<?= base_url(); ?>uretim" class="dropdown-item"><i class="fas fa-list"></i>Üretim</a>
                    <a href="<?= base_url(); ?>azpetrol" class="dropdown-item"><i class="fas fa-list"></i>Az Petrol</a>
                    <a href="<?= base_url(); ?>benzin" class="dropdown-item"><i class="fas fa-list"></i>Çen Yönetimi</a>
                    <a href="<?= base_url(); ?>faturaitem" class="dropdown-item"><i class="fas fa-list"></i>Fatura Tanımlamaları</a>
                    <a href="<?= base_url(); ?>printerler" class="dropdown-item"><i class="fas fa-list"></i>Printer / Bilgisayarlar</a>
                    <a href="<?= base_url(); ?>items" class="dropdown-item"><i class="fas fa-list"></i>Diğer Tanımlamalar</a>
                </div>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Finans Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>transactions" class="dropdown-item"><i class="fas fa-list"></i>Finans İşlemleri</a>
                    <a href="<?= base_url(); ?>faktorinq" class="dropdown-item"><i class="fas fa-list"></i>Faktorinq</a>
                    <a href="<?= base_url(); ?>accounts" class="dropdown-item"><i class="fas fa-list"></i>Hesaplar</a>
                    <a href="<?= base_url(); ?>virman" class="dropdown-item"><i class="fas fa-list"></i>Kasalar Arası Virman</a>
                    <a href="<?= base_url(); ?>accounts/gunun_ozeti" class="dropdown-item"><i class="fas fa-list"></i>Günün Özeti</a>
                    <a href="<?= base_url(); ?>cost" class="dropdown-item"><i class="fas fa-list"></i>Giderler</a>
<!--                    <a href="--><?//= base_url(); ?><!--ihale" class="dropdown-item"><i class="fas fa-list"></i>İhale</a>-->
                </div>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Personel Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>personel" class="dropdown-item"><i class="fas fa-list"></i>Personeller</a>
                    <a href="<?= base_url(); ?>personelgidertalep/all_list" class="dropdown-item"><i class="fas fa-list"></i>Personel Gider Talepleri</a>
                    <a href="<?= base_url(); ?>personelavanstalep/all_list" class="dropdown-item"><i class="fas fa-list"></i>Personel Avans Talepleri</a>
                    <a href="<?= base_url(); ?>disablepersonel" class="dropdown-item"><i class="fas fa-list"></i>Pasif Personeller</a>
                    <a href="<?= base_url(); ?>personelaction/personel_task" class="dropdown-item"><i class="fas fa-list"></i>Görevlendirme</a>
                    <a href="<?= base_url(); ?>attendance" class="dropdown-item"><i class="fas fa-list"></i>Personel Çizelge Girişleri</a>
                    <a href="<?= base_url(); ?>attendance/report" class="dropdown-item"><i class="fas fa-list"></i>Personel Çizelge Raporu</a>
                    <a href="<?= base_url(); ?>attendance/signature" class="dropdown-item"><i class="fas fa-list"></i>Personel İmza</a>
<!--                    <a href="--><?//= base_url(); ?><!--employee/payroll_list" class="dropdown-item"><i class="fas fa-list"></i>Bordrolar</a>-->
<!--                    <a href="--><?//= base_url(); ?><!--controller/personel_takip" class="dropdown-item"><i class="fas fa-list"></i>Personel Takip</a>-->
                    <a href="<?= base_url(); ?>prim" class="dropdown-item"><i class="fas fa-list"></i>Personel Prim/Cezalar</a>
                    <a href="<?= base_url(); ?>salary" class="dropdown-item"><i class="fas fa-list"></i>Bordro İşlemleri</a>

                    <a href="<?= base_url(); ?>salary/allbordro" class="dropdown-item"><i class="fas fa-list"></i>Tüm Bordrolar</a>
                    <?php
                    if ($this->aauth->premission(76)->write) { ?>
                        <a href="<?= base_url(); ?>personelpoint" class="dropdown-item"><i class="fas fa-list"></i>Personel Puanlama</a>
                    <?php   } ?>

                    <?php
                    if ($this->aauth->premission(77)->write) { ?>
                        <a href="<?= base_url(); ?>personelpointvalue" class="dropdown-item"><i class="fas fa-list"></i>Personel Yetkinlikleri</a>
                    <?php   } ?>
                    <?php
                    if ($this->aauth->premission(79)->write) { ?>
                        <a href="<?= base_url(); ?>reports/personel_izin_raporu" class="dropdown-item"><i class="fas fa-list"></i>Personel İzin Raporu</a>
                    <?php   } ?>

                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Proje Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>projects" class="dropdown-item"><i class="fas fa-list"></i>Projeler</a>
                    <a href="<?= base_url(); ?>projestoklari/fislist" class="dropdown-item"><i class="fas fa-list"></i>Proje Stok Giriş / Çıkış</a>
                    <a href="<?= base_url(); ?>projects/is_kalemleri_durumlari" class="dropdown-item"><i class="fas fa-list"></i>İş Kalemi Durumları</a>
                </div>
            </li>

            <?php
            if ($this->aauth->get_user()->id==21) { ?>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Yeni Proje
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>projectsnew" class="dropdown-item"><i class="fas fa-list"></i>Projeler</a>
                    <a href="<?= base_url(); ?>projectasama" class="dropdown-item"><i class="fas fa-list"></i>Simeta Aşamaları</a>
                    <a href="<?= base_url(); ?>projectiskalemleri" class="dropdown-item"><i class="fas fa-list"></i>Simeta İş Kalemleri</a>
                </div>
            </li>
            <?php } ?>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Talepler
                </a>
                <div class="dropdown-menu">
<!--                    <a href="--><?//= base_url(); ?><!--form/malzeme_talep_list" class="dropdown-item"><i class="fas fa-list"></i>Malzeme Talep Formu</a>-->
                    <a href="<?= base_url(); ?>malzemetalep" class="dropdown-item"><i class="fas fa-list"></i>Malzeme Talep Formu</a>
                    <a href="<?= base_url(); ?>hizmet" class="dropdown-item"><i class="fas fa-list"></i>Hizmet Talep Formu</a>
                    <a type="button" onclick="cleartalep()" class="dropdown-item"><i class="fas fa-list"></i>Talep Listemi Temizle</a>
<!--                    <a href="--><?//= base_url(); ?><!--form/satinalma_formu_list" class="dropdown-item"><i class="fas fa-list"></i>Satın Alma Formu</a>-->
<!--                    <a href="--><?//= base_url(); ?><!--form/gider_talebi_list" class="dropdown-item"><i class="fas fa-list"></i>Gider Talebi</a>-->

                    <a href="<?= base_url(); ?>carigidertalepnew/talep_sepeti" class="dropdown-item"><i class="fas fa-list"></i>Gider Talebi</a>
                    <?php  if($this->aauth->get_user()->id==39 || $this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==67 || $this->aauth->get_user()->id==174 || $this->aauth->get_user()->id==663 || $this->aauth->get_user()->id==735){ ?>
                    <a href="<?= base_url(); ?>carigidertalepnew" class="dropdown-item"><i class="fas fa-list"></i>Yetkili Gider Talebi</a>
                    <?php } ?>
                    <a href="<?= base_url(); ?>customeravanstalep" class="dropdown-item"><i class="fas fa-list"></i>Avans Talebi</a>
                    <a href="<?= base_url(); ?>nakliye" class="dropdown-item"><i class="fas fa-list"></i>Nakliye Talebi</a>
                    <a href="<?= base_url(); ?>caricezatalep" class="dropdown-item"><i class="fas fa-list"></i>Cari Ceza Talebi</a>
                    <a href="<?= base_url(); ?>lojistik" class="dropdown-item"><i class="fas fa-list"></i>ESKİ Lojistik Talebi</a>
                    <a href="<?= base_url(); ?>logistics" class="dropdown-item"><i class="fas fa-list"></i>ESKİ Lojistik Satınalma Talebi</a>
                    <a href="<?= base_url(); ?>logistics/lojistikhizmetlist" class="dropdown-item"><i class="fas fa-list"></i>Lojistik Araç Raporu</a>
                    <a href="<?= base_url(); ?>aracform" class="dropdown-item"><i class="fas fa-list"></i>Araç Talep Formu</a>

                    <a href="<?= base_url(); ?>reports/gider_talep_report" class="dropdown-item"><i class="fas fa-list"></i>Cari Gider Raporu</a>
                    <a href="<?= base_url(); ?>reports/malzeme_talep_report" class="dropdown-item"><i class="fas fa-list"></i>Malzeme Talep Raporu</a>
                    <a href="<?= base_url(); ?>reports/mt_depo_report_urun" class="dropdown-item"><i class="fas fa-list"></i>Malzeme Talep Qalıq Raporu</a>
                    <a href="<?= base_url(); ?>nakliye/report" class="dropdown-item"><i class="fas fa-list"></i>Nakliye Raporu</a>
                    <?php    if ($this->aauth->premission(70)->read) { ?>
                    <a href="<?= base_url(); ?>form/malzeme_talep_list" class="dropdown-item"><i class="fas fa-list"></i>Eski MT</a>
                    <a href="<?= base_url(); ?>form/satinalma_formu_list" class="dropdown-item"><i class="fas fa-list"></i>Eski SF</a>
                    <a href="<?= base_url(); ?>form/gider_talebi_list" class="dropdown-item"><i class="fas fa-list"></i>Eski GT</a>
                    <a href="<?= base_url(); ?>form/avans_talebi_list" class="dropdown-item"><i class="fas fa-list"></i>Eski AT</a>
                    <?php } ?>
                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                   Asistan
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>meeting" class="dropdown-item"><i class="fas fa-list"></i>Toplantılar</a>
                    <a href="<?= base_url(); ?>customermeeting" class="dropdown-item"><i class="fas fa-list"></i>Randevular</a>
<!--                    <a href="--><?//= base_url(); ?><!--tools/notes" class="dropdown-item"><i class="fas fa-list"></i>Notlar</a>-->
                    <a href="<?= base_url(); ?>controller/holidays" class="dropdown-item"><i class="fas fa-list"></i>Tatil Günleri</a>
                    <?php    if ($this->aauth->premission(80)->read) { ?>
                    <a href="<?= base_url(); ?>controller/index" class="dropdown-item"><i class="fas fa-list"></i>Nezaret İşlemleri</a>
                    <a href="<?= base_url(); ?>reports/stok_raporu" class="dropdown-item"><i class="fas fa-list"></i>Stok Raporu</a>

                    <?php } ?>
                    <a href="<?= base_url(); ?>tender" class="dropdown-item"><i class="fas fa-list"></i>Tender</a>
                    <a href="<?= base_url(); ?>excel/tender_index" class="dropdown-item"><i class="fas fa-list"></i>Tender Dosya Yükle</a>
                </div>
            </li>
<!--            <li class="nav-item dropdown nav-item-dropdown-xl">-->
<!--                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">-->
<!--                    <i class="fas fa-file-invoice mr-2"></i>-->
<!--                    Raporlar-->
<!--                </a>-->
<!--                <div class="dropdown-menu">-->
<!--                    <a href="--><?//= base_url(); ?><!--reports/cari_bakiye" class="dropdown-item"><i class="fas fa-list"></i>Cari Bakiye Raporu</a>-->
<!--                    <a href="--><?//= base_url(); ?><!--reports/kdv_raporu" class="dropdown-item"><i class="fas fa-list"></i>KDV Raporu</a>-->
<!--                    <a href="--><?//= base_url(); ?><!--reports/product_report" class="dropdown-item"><i class="fas fa-list"></i>Stok Raporu</a>-->
<!--                    <a href="--><?//= base_url(); ?><!--raporlar/razi_report" class="dropdown-item"><i class="fas fa-list"></i>Personel Razı Raporu</a>-->
<!--                    <a href="--><?//= base_url(); ?><!--logistics/lojistikhizmetlist" class="dropdown-item"><i class="fas fa-list"></i>Lojistik Araç Raporu</a>-->
<!--                </div>-->
<!--            </li>-->

            <?php
            if ($this->aauth->premission(38)->read) { ?>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Ayarlar
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>roleapproval" class="dropdown-item"><i class="fas fa-list"></i>Kullanıcı Yetkilendirme</a>
                    <a href="<?= base_url(); ?>permissions" class="dropdown-item"><i class="fas fa-list"></i>Yetkilendirme</a>
                </div>
            </li>
            <?php  } ?>

            <?php
            if ($this->aauth->premission(75)->read) { ?>
                <li class="nav-item dropdown nav-item-dropdown-xl">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Firmalar
                    </a>
                    <div class="dropdown-menu">
                        <?php
                        foreach (firmalar() as $firma){
                            ?>
                            <button class="dropdown-item firma_update" firma_id="<?php echo $firma->id?>"><i class="fas fa-list"></i><?php echo $firma->cname?></button>
                            <?php
                        }
                        ?>

                    </div>
                </li>
            <?php  } ?>

            </li>
        </ul>
    </div>
</div>

<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg new_side">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-user-material" style="background: #667a9f;">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <button style="display: none;" type="button" class="btn btn-outline-light border-transparent btn-icon btn-sm rounded-pill">

                            </button>
                        </div>
                        <a href="#" class="flex-1 text-center"><img src="<?php echo site_url('/userfiles/employee/').$this->aauth->get_user()->employes->picture?>" class="img-fluid shadow-sm" width="80" height="80" alt=""></a>
                        <div class="flex-1 text-right">
                            <button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3"><?php echo $this->aauth->get_user()->employes->name ?></h6>
                        <span class="font-size-sm text-white text-shadow-dark"><?php echo $this->aauth->get_user()->employes->address ?></span>
                    </div>
                </div>
            </div>

        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="/" class="nav-link active">
                        <i class="icon-home4"></i>
                        <span>Kontrol Paneli</span>
                    </a>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Fatura Yönetimi</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Fatura">
                        <li class="nav-item"><a href="<?= base_url(); ?>invoices/create" class="nav-link"><i class="fas fa-list"></i>Yeni Fatura</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>invoices"        class="nav-link"><i class="fas fa-list"></i>Fatura Listesi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>formainvoices"        class="nav-link"><i class="fas fa-list"></i>Forma2</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>siparis"        class="nav-link"><i class="fas fa-list"></i>Sipariş Formu</a></li>

                    </ul>
                </li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Cari Yönetimi</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Cari">
                        <li class="nav-item"><a href="<?= base_url(); ?>customers" class="nav-link"><i class="fas fa-list"></i>Cariler</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>clientgroup" class="nav-link"><i class="fas fa-list"></i>Cari Grupları</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>customers/cari_projeleri" class="nav-link"><i class="fas fa-list"></i>Cari Projeleri</a></li>
                        <a href="<?= base_url(); ?>podradci" class="dropdown-item"><i class="fas fa-list"></i>Alt Podradçılar</a>
                        <a href="<?= base_url(); ?>personelp" class="dropdown-item"><i class="fas fa-list"></i>Podradçı Personeller</a>
                        <a href="<?= base_url(); ?>worker" class="dropdown-item"><i class="fas fa-list"></i>Fehle Kartları</a>
                        <a href="<?= base_url(); ?>worker/run_list" class="dropdown-item"><i class="fas fa-list"></i>Fehle Çalışmaları</a>


                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Stok Yönetimi</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Stok">
                         <li class="nav-item"><a href="<?= base_url(); ?>urun" class="nav-link"><i class="fas fa-list"></i>Ürünler</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>productoption" class="nav-link"><i class="fas fa-list"></i>Varyantlar</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>warehouse" class="nav-link"><i class="fas fa-list"></i>Depolar</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>stockio" class="nav-link"><i class="fas fa-list"></i>Stok Giriş / Çıkışları</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>newproductcategory" class="nav-link"><i class="fas fa-list"></i>Kategoriler</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>newunits" class="nav-link"><i class="fas fa-list"></i>Ölçü Birimleri</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>stocktransfer" class="nav-link"><i class="fas fa-list"></i>Stok Transferi</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>arac" class="nav-link"><i class="fas fa-list"></i>Araçlar</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>arac/mk_araclist" class="nav-link"><i class="fas fa-list"></i>Makro Araçlar</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>demirbas" class="nav-link"><i class="fas fa-list"></i>Gider Yönetimi</a></li>
                         <li class="nav-item"><a href="<?= base_url(); ?>uretim" class="nav-link"><i class="fas fa-list"></i>Üretim</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Finans Yönetimi</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Finans">
                        <li class="nav-item"><a href="<?= base_url(); ?>transactions" class="nav-link"><i class="fas fa-list"></i>Finans İşlemleri</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>faktorinq" class="nav-link"><i class="fas fa-list"></i>Faktorinq</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>accounts" class="nav-link"><i class="fas fa-list"></i>Hesaplar</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>virman" class="nav-link"><i class="fas fa-list"></i>Kasalar Arası Virman</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>accounts/gunun_ozeti" class="nav-link"><i class="fas fa-list"></i>Günün Özeti</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>cost" class="nav-link"><i class="fas fa-list"></i>Giderler</a>
                        <!--                    	<a href="--><?//= base_url(); ?><!--ihale" class="dropdown-item"><i class="fas fa-list"></i>İhale</a>-->
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Personel Yönetimi</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Personel">
                        <li class="nav-item"><a href="<?= base_url(); ?>personel" class="nav-link"><i class="fas fa-list"></i>Personeller</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>personelgidertalep/all_list" class="nav-link"><i class="fas fa-list"></i>Personel Gider Talepleri</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>personelavanstalep/all_list" class="nav-link"><i class="fas fa-list"></i>Personel Avans Talepleri</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>disablepersonel" class="nav-link"><i class="fas fa-list"></i>Pasif Personeller</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>personelaction/personel_task" class="nav-link"><i class="fas fa-list"></i>Görevlendirme</a></li
                        <li class="nav-item"><a href="<?= base_url(); ?>prim" class="nav-link"><i class="fas fa-list"></i>Personel Prim/Cezalar</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>salary" class="nav-link"><i class="fas fa-list"></i>Bordro İşlemleri</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>salary/allbordro" class="nav-link"><i class="fas fa-list"></i>Tüm Bordrolar</a></li>
                        <a href="<?= base_url(); ?>attendance" class="dropdown-item"><i class="fas fa-list"></i>Personel Çizelge Girişleri</a>
                        <a href="<?= base_url(); ?>attendance/report" class="dropdown-item"><i class="fas fa-list"></i>Personel Çizelge Raporu</a>
                        <a href="<?= base_url(); ?>attendance/signature" class="dropdown-item"><i class="fas fa-list"></i>Personel İmza</a>
                        <?php
                        if ($this->aauth->premission(76)->write) { ?>
                            <li class="nav-item"><a href="<?= base_url(); ?>personelpoint" class="nav-link"><i class="fas fa-list"></i>Personel Puanlama</a></li>
                        <?php   } ?>

                        <?php
                        if ($this->aauth->premission(77)->write) { ?>
                            <li class="nav-item"><a href="<?= base_url(); ?>personelpointvalue" class="nav-link"><i class="fas fa-list"></i>Personel Yetkinlikleri</a></li>

                        <?php   } ?>
                        <?php
                        if ($this->aauth->premission(79)->write) { ?>
                            <li class="nav-item"><a href="<?= base_url(); ?>reports/personel_izin_raporu" class="nav-link"><i class="fas fa-list"></i>Personel İzin Raporu</a></li>

                        <?php   } ?>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Proje Yönetimi</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Proje">
                        <li class="nav-item"><a href="<?= base_url(); ?>projects" class="nav-link"><i class="fas fa-list"></i>Projeler</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>projestoklari/fislist" class="nav-link"><i class="fas fa-list"></i>Proje Stok Giriş / Çıkış</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>projects/is_kalemleri_durumlari" class="nav-link"><i class="fas fa-list"></i>İş Kalemi Durumları</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Talepler</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Talepler">

                        <!--                    	<a href="--><?//= base_url(); ?><!--form/malzeme_talep_list" class="dropdown-item"><i class="fas fa-list"></i>Malzeme Talep Formu</a>-->
                       <!--                    <a href="--><?//= base_url(); ?><!--form/satinalma_formu_list" class="dropdown-item"><i class="fas fa-list"></i>Satın Alma Formu</a>-->
                        <!--                    <a href="--><?//= base_url(); ?><!--form/gider_talebi_list" class="dropdown-item"><i class="fas fa-list"></i>Gider Talebi</a>-->
                        <li class="nav-item"><a href="<?= base_url(); ?>malzemetalep" class="nav-link"><i class="fas fa-list"></i>Malzeme Talep Formu</a></li>
                        <li class="nav-item"><a type="button" onclick="cleartalep()" class="nav-link"><i class="fas fa-list"></i>Talep Listemi Temizle</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>carigidertalep" class="nav-link"><i class="fas fa-list"></i>Gider Talebi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>customeravanstalep" class="nav-link"><i class="fas fa-list"></i>Avans Talebi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>nakliye" class="nav-link"><i class="fas fa-list"></i>Nakliye Talebi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>caricezatalep" class="nav-link"><i class="fas fa-list"></i>Cari Ceza Talebi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>lojistik" class="nav-link"><i class="fas fa-list"></i>Lojistik Talebi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>logistics" class="nav-link"><i class="fas fa-list"></i>Lojistik Satınalma Talebi</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>logistics/lojistikhizmetlist" class="nav-link"><i class="fas fa-list"></i>Lojistik Araç Raporu</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>aracform" class="nav-link"><i class="fas fa-list"></i>Araç Talep Formu</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>reports/gider_talep_report" class="nav-link"><i class="fas fa-list"></i>Cari Gider Raporu</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>reports/malzeme_talep_report" class="nav-link"><i class="fas fa-list"></i>Malzeme Talep Raporu</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Asistan</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Asistan">
                        <li class="nav-item"><a href="<?= base_url(); ?>meeting" class="nav-link"><i class="fas fa-list"></i>Toplantılar</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>customermeeting" class="nav-link"><i class="fas fa-list"></i>Randevular</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>controller/holidays" class="nav-link"><i class="fas fa-list"></i>Tatil Günleri</a></li>
                        <?php    if ($this->aauth->premission(80)->read) { ?>
                            <li class="nav-item"><a href="<?= base_url(); ?>controller/index" class="nav-link"><i class="fas fa-list"></i>Nezaret İşlemleri</a></li>
                        <?php } ?>
                        <!--                    <a href="--><?//= base_url(); ?><!--tools/notes" class="dropdown-item"><i class="fas fa-list"></i>Notlar</a>-->

                    </ul>
                </li>
                <!--            <li class="nav-item dropdown nav-item-dropdown-xl">-->
                <!--                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">-->
                <!--                    <i class="fas fa-file-invoice mr-2"></i>-->
                <!--                    Raporlar-->
                <!--                </a>-->
                <!--                <div class="dropdown-menu">-->
                <!--                    <a href="--><?//= base_url(); ?><!--reports/cari_bakiye" class="dropdown-item"><i class="fas fa-list"></i>Cari Bakiye Raporu</a>-->
                <!--                    <a href="--><?//= base_url(); ?><!--reports/kdv_raporu" class="dropdown-item"><i class="fas fa-list"></i>KDV Raporu</a>-->
                <!--                    <a href="--><?//= base_url(); ?><!--reports/product_report" class="dropdown-item"><i class="fas fa-list"></i>Stok Raporu</a>-->
                <!--                    <a href="--><?//= base_url(); ?><!--raporlar/razi_report" class="dropdown-item"><i class="fas fa-list"></i>Personel Razı Raporu</a>-->
                <!--                    <a href="--><?//= base_url(); ?><!--logistics/lojistikhizmetlist" class="dropdown-item"><i class="fas fa-list"></i>Lojistik Araç Raporu</a>-->
                <!--                </div>-->
                <!--            </li>-->
                <?php   if ($this->aauth->premission(38)->read) { ?>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Ayarlar</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Ayarlar">
                        <li class="nav-item"><a href="<?= base_url(); ?>roleapproval" class="nav-link"><i class="fas fa-list"></i>Kullanıcı Yetkilendirme</a></li>
                        <li class="nav-item"><a href="<?= base_url(); ?>permissions" class="nav-link"><i class="fas fa-list"></i>Yetkilendirme</a></li>
                    </ul>
                </li>
                <?php  } ?>
                <?php
                if ($this->aauth->premission(75)->read) { ?>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Firmalar</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Ayarlar">
                            <?php
                            foreach (firmalar() as $firma){
                                ?>
                                <li class="nav-item">  <button class="dropdown-item firma_update" firma_id="<?php echo $firma->id?>"><i class="fas fa-list"></i><?php echo $firma->cname?></button></li>

                                <?php
                            }
                            ?>

                        </ul>
                    </li>
                <?php  } ?>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>


<?php
$n_user_id = $this->aauth->get_user()->id;
$kontrol = $this->db->query("SELECT * FROM new_pass Where user_id = $n_user_id and status=1")->num_rows();
if($kontrol){
    $rows = $this->db->query("SELECT * FROM new_pass Where user_id = $n_user_id and status=1 ORDER BY id DESC LIMIT 1")->row();
    $new_pass = strtolower($rows->pass_new);
    $kontrol_pass = strtolower("makro7373");

    if($new_pass == $kontrol_pass){
        header("Location: /user/updatepassword/".$n_user_id);
    }


}
else {
    header("Location: /user/updatepassword/".$n_user_id);
}
?>

<script src="<?= base_url().'assets/global_assets/js/plugins/ui/prism.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/tables/datatables/datatables.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/notifications/jgrowl.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/notifications/noty.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/notifications/sweet_alert.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/forms/selects/select2.min.js'?>"></script>

<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(document).ready(function () {
        duyuru_kontrol();
       // borclandirma_kontrol();

    });

    setTimeout(function(){
        $('.borclandirma_kontrol_button').click();
    }, 2400);

    $(document).on('click', '.stock_view', function() {
        let product_stock_code_id = $(this).attr('product_stock_id');
        let product_id = $(this).attr('product_id');
        let id = 0;
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Alt Ürün Stok Kartı',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function() {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+= ` <div class='mb-3'>
                                    <div class="row" style='text-align: justify;'>
                                        <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
                                             <div class="col-md-12">
                                                 <div class="row">
                                                    <div class="col-md-6 pb-2">
                                                        <label>Stok Kodu</label>
                                                        <input type="text"  class='form-control product_code' disabled>
                                                     </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label>Stok Tipi</label>
                                                        <select class="form-control select-box pro_type">
                                                            <option value='0'>Secin</option>
                                                            <?php
                foreach (all_product_type() as $item) {
                    echo "<option value='$item->id'>$item->name</option>";
                }
                ?>
                                                        </select>
                                                     </div>
                                                     <div class="col-md-12 pb-2">
                                                        <label>Stok Adı AZ</label>
                                                        <input type="text" class='form-control product_name'>
                                                     </div>
                                                          <div class="col-md-12 pb-2">
                                                        <label>Stok Adı TR</label>
                                                        <input type="text" class='form-control product_name_tr'>
                                                     </div>
                                                          <div class="col-md-12 pb-2">
                                                        <label>Stok Adı EN</label>
                                                        <input type="text" class='form-control product_name_en'>
                                                     </div>
                                                    <div class="col-md-8 pb-2">
                                                        <label>Kısa Tanım</label>
                                                        <input type="text" class='form-control short_name'>
                                                     </div>
                                                    <div class="col-md-4 pb-2">
                                                        <label>Marka</label>
                                                        <input type="text" class='form-control marka'>
                                                    </div>
                                                       <div class="col-md-12 pb-2">

                                                    </div>
                                                    <div class="col-md-12 pb-2 degisken_varyant">
                                                    </div>
                                                    <hr>

                                                    <div class="col-md-3 pb-2">
                                                        <label>Yoğunluk</label>
                                                        <input type="text" class='form-control yogunluk'>
                                                    </div>
                                                      <div class="col-md-3 pb-2">
                                                        <label>İç Çap (mm)</label>
                                                        <input type="text" class='form-control ic_cap'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Dış Çap (mm)</label>
                                                        <input type="text" class='form-control dis_cap'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>t (mm)</label>
                                                        <input type="text" class='form-control t'>
                                                    </div>
                                                      <hr>

                                                        <div class="col-md-6 pb-2">
                                                        <label>Çap 1</label>
                                                        <input type="text" class='form-control capone'>
                                                    </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label>Çap 2</label>
                                                        <input type="text" class='form-control captwo'>
                                                    </div>
                                                    <div class="col-md-12 pb-2">
                                                    <hr>
                                                    </div>
                                                    <div class="col-md-6 pb-2">
                                                        <label>Emniyet Stoğu</label>
                                                        <input type="text" class='form-control emniyet_stok'>
                                                    </div>
                                                      <div class="col-md-6 pb-2">
                                                        <label>Min. Sip. Mik.</label>
                                                        <input type="text" class='form-control min_sip_mik'>
                                                    </div>
                                                     <div class="col-md-4 pb-2">
                                                        <label>Sipariş Katları</label>
                                                        <input type="text" class='form-control siparis_katlari'>
                                                    </div>
                                                      <div class="col-md-4 pb-2">
                                                        <label>İskarta Oranı</label>
                                                        <input type="text" class='form-control iskarta_orani'>
                                                    </div>
                                                      <d    iv class="col-md-4 pb-2">
                                                        <label>Üretim Katsayısı</label>
                                                        <input type="text" class='form-control uretim_katsayisi'>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
                                             <div class="col-md-12">
                                                 <div class="row">

                                                       <div class="col-md-3 pb-2">
                                                        <label>Palet (Euro)</label>
                                                         <input type="text" class='form-control palet'>
                                                     </div>
                                                        <div class="col-md-3 pb-2">
                                                        <label>Denye (Hacim)</label>
                                                         <input type="text" class='form-control denye'>
                                                     </div>
                                                        <div class="col-md-3 pb-2">
                                                        <label>Brüt Ağırlık (Kg/Gr)</label>
                                                         <input type="text" class='form-control brut_agirlik'>
                                                     </div>
                                                        <div class="col-md-3 pb-2">
                                                        <label>Net Ağırlık (Kg/Gr)</label>
                                                         <input type="text" class='form-control net_agirlik'>
                                                     </div>
                                                        <div class="col-md-6 pb-2">
                                                        <label>Gerçek</label>
                                                        <input type="checkbox" class='form-control gercek' style='width: 50px;'>
                                                     </div>
                                                       <div class="col-md-6 pb-2">
                                                        <label>Aktif</label>
                                                        <input type="checkbox" class='form-control status' style='width: 50px;'>
                                                     </div>
                                                     <div class="col-md-12 pb-2"> <hr></div>

                                                    <div class="col-md-6 pb-2">
                                                        <label>Barkod</label>
                                                        <input type="text" class='form-control barcode' disabled>
                                                     </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label>Standart Kod</label>
                                                        <input type="text" class='form-control standart_code'>
                                                     </div>
                                                         <div class="col-md-6 pb-2">
                                                        <label>Özel Kod 1</label>
                                                        <input type="text" class='form-control ozel_kod_1'>
                                                     </div>
                                                           <div class="col-md-6 pb-2">
                                                        <label>Özel Kod 2</label>
                                                        <input type="text" class='form-control ozel_kod_2'>
                                                     </div>
                                                       <div class="col-md-6 pb-2">
                                                        <label>Özel Kod 3</label>
                                                        <input type="text" class='form-control ozel_kod_3'>
                                                     </div>
                                                         <div class="col-md-6 pb-2">
                                                        <label>Baz Miktarı</label>
                                                        <input type="text" class='form-control baz_miktari'>
                                                     </div>
                                                      <div class="col-md-12 pb-2"> <hr></div>

                                                        <div class="col-md-12 pb-2">
                                                        <label>Fire Stok Kodu</label>
                                                        <input type="text" class='form-control fire_stok_kodu'>
                                                     </div>
                                                        <div class="col-md-12 pb-2">
                                                        <label>Malzeme Grubu 1</label>
                                                        <select class="form-control select-box mg_1 category_id">
                                                        <option value='0'>Secin</option>
                                                                                <?php

                foreach (category_list_() as $item) :

                    $id = $item['id'];
                    $title = $item['title'];
                    $new_title = _ust_kategori_kontrol($id).$title;
                    echo "<option value='$id'>$new_title</option>";

                endforeach;
                ?>
                                                    </select>
                                                     </div>
                                                          <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 2</label>
                                                        <input type="text" class='form-control mg_2'>
                                                     </div>
                                                          <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 3</label>
                                                        <input type="text" class='form-control mg_3'>
                                                     </div>
                                                          <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 4</label>
                                                        <input type="text" class='form-control mg_4'>
                                                     </div>
                                                      <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 5</label>
                                                        <input type="text" class='form-control mg_5'>
                                                     </div>
                                                     <div class="col-md-12 pb-2">
                                                        <label>Ürün Etiketleri(Virgülle Ayırınız)</label>
                                                        <textarea type="text" class='form-control tag'></textarea>
                                                     </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                           <div class="col-md-6 pb-2">
                                                                <label>Stok Birimi</label>
                                                                 <select class='form-control select-box unit'>
                                                                <?php foreach (units() as $items){
                    $id=$items['id'];
                    $name=$items['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                                </select>
                                                             </div>
                                                             <div class="col-md-6 pb-2">
                                                                <label>Birim 2</label>
                                                                <select class='form-control select-box unit_2'>
                                                                    <?php foreach (units() as $items){
                    $id=$items['id'];
                    $name=$items['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                                </select>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Satınalma Sipariş Birimi</label>
                                                               <select class='form-control select-box satinalama_siparis_birimi'>
                                                                <?php foreach (units() as $items){
                    $id=$items['id'];
                    $name=$items['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                                </select>

                                                             </div>
                                                                 <div class="col-md-6 pb-2">
                                                                <label>Satınalma Kabul Birimi</label>
                                                                    <select class='form-control select-box satinalama_kabul_birimi'>
                                                                    <?php foreach (units() as $items){
                    $id=$items['id'];
                    $name=$items['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                                </select>
                                                             </div>
                                                                <div class="col-md-6 pb-2">
                                                                <label>Satış Birimi</label>
                                                                 <select class='form-control select-box satis_birimi'>
                                                                    <?php foreach (units() as $items){
                    $id=$items['id'];
                    $name=$items['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                                </select>

                                                             </div>
                                                              <div class="col-md-12 pb-2"> <hr></div>
                                                                <div class="col-md-6 pb-2">
                                                                <label>Temin Türü</label>
                                                                <input type="text" class='form-control temin_turu'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Satınalma Türü</label>
                                                                <input type="text" class='form-control satinalma_turu'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>İmalat Sipariş Birimi</label>
                                                                <input type="text" class='form-control imalat_siparis_birimi'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Rapor Birimi</label>
                                                                <input type="text" class='form-control rapor_birimi'>
                                                             </div>
                                                                 <div class="col-md-6 pb-2">
                                                                <label>Satınalam Süresi</label>
                                                                <input type="text" class='form-control satinalma_suresi'>
                                                             </div>
                                                                 <div class="col-md-6 pb-2">
                                                                <label>İmalat Teda. Süresi</label>
                                                                <input type="text" class='form-control imalat_tedarik_suresi'>
                                                             </div>
                                                              <div class="col-md-12 pb-2"> <hr></div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>KDV</label>
                                                                <input type="text" class='form-control kdv'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Ean</label>
                                                                <input type="text" class='form-control ean'>
                                                             </div>

                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>
                                     </div>
                                     <div class="row" style='text-align: justify;'>
                                       <div class="col-md-12 pb-2">
                                         <hr>
                                     </div>
                                     </div>
                                      <div class="row" style='text-align: justify;'>
                                            <div class="col-md-6 pb-2">
                                            <label>Ürün Aciqlamasi</label>
                                                <textarea type="text" class='form-control product_description'></textarea>
                                          </div>
                                             <div class="col-md-6 pb-2">
                                             <label for="resim">Resim</label>
                                   <div>
                                     <img class="myImg update_image" style="width: 322px;">
                                   </di>
                                     <div id="progress" class="progress">
                                          <div class="progress-bar progress-bar-success"></div>
                                     </div>
                                      <table id="files" class="files"></table><br>

                                      <span class="btn btn-success fileinput-button" style="width: 100%">
                                      <i class="glyphicon glyphicon-plus"></i>

                                      <span>Seçiniz...</span>
                                      <input id="fileupload_update_parent" type="file" name="files[]">

                                      <input type="hidden" class="image_text_update_parent" name="image_text_update_parent" id="image_text_update_parent">
                                          </div>
                                      </div>
                                </div>
                                `;
                let data = {
                    crsf_token: crsf_hash,
                    product_stock_code_id: product_stock_code_id
                }

                let table_report = '';
                $.post(baseurl + 'urun/parent_info', data, (response) => {


                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.product_description').val(responses.details_items[0].product_des)
                    $('#image_text_update_parent').val(responses.details_items[0].image);
                    $('.update_image').attr('src', baseurl + '' + responses.details_items[0].image);
                    $(".product_code").val(responses.code);
                    $(".pro_type").val(responses.details_items[0].product_type);
                    $(".product_name").val(responses.details_items[0].product_name);
                    $(".product_name_tr").val(responses.details_items[0].product_name_tr);
                    $(".product_name_en").val(responses.details_items[0].product_name_en);
                    $(".short_name").val(responses.details_items[0].short_name);
                    $(".marka").val(responses.details_items[0].marka);
                    $(".kalinlik").val(responses.details_items[0].kalinlik);
                    $(".en").val(responses.details_items[0].en);
                    $(".boy").val(responses.details_items[0].boy);
                    $(".yukseklik").val(responses.details_items[0].yukseklik);
                    $(".yogunluk").val(responses.details_items[0].yogunluk);
                    $(".ic_cap").val(responses.details_items[0].ic_cap);
                    $(".dis_cap").val(responses.details_items[0].dis_cap);
                    $(".t").val(responses.details_items[0].t);
                    $(".emniyet_stok").val(responses.details_items[0].alert);
                    $(".min_sip_mik").val(responses.details_items[0].min_sip_mik);
                    $(".siparis_katlari").val(responses.details_items[0].siparis_katlari);
                    $(".iskarta_orani").val(responses.details_items[0].iskarta_orani);
                    $(".uretim_katsayisi").val(responses.details_items[0].uretim_katsayisi);
                    $(".palet").val(responses.details_items[0].palet);
                    $(".denye").val(responses.details_items[0].denye);
                    $(".brut_agirlik").val(responses.details_items[0].brut_agirlik);
                    $(".net_agirlik").val(responses.details_items[0].net_agirlik);

                    $(".en2").val(responses.details_items[0].en2);
                    $(".t2").val(responses.details_items[0].t2);
                    $(".1magirlik").val(responses.details_items[0].magirlik);
                    $(".l").val(responses.details_items[0].l);
                    $(".capone").val(responses.details_items[0].capone);
                    $(".captwo").val(responses.details_items[0].captwo);

                    if(responses.details_items[0].status==1){
                        $('.status').click()
                    }
                    else {
                        $('.status').prop('checked',false);
                    }

                    if(responses.details_items[0].gercek==1){
                        $('.gercek').click()
                    }
                    else {
                        $('.gercek').prop('checked',false);
                    }



                    $(".barcode").val(responses.details_items[0].barcode);
                    $(".standart_code").val(responses.details_items[0].standart_code);
                    $(".ozel_kod_1").val(responses.details_items[0].ozel_kod_1);
                    $(".ozel_kod_2").val(responses.details_items[0].ozel_kod_2);
                    $(".ozel_kod_3").val(responses.details_items[0].ozel_kod_3);
                    $(".baz_miktari").val(responses.details_items[0].baz_miktari);
                    $(".fire_stok_kodu").val(responses.details_items[0].fire_stok_kodu);
                    $(".mg_1").val(responses.details_items[0].mg_1);
                    $(".mg_2").val(responses.details_items[0].mg_2);
                    $(".mg_3").val(responses.details_items[0].mg_3);
                    $(".mg_4").val(responses.details_items[0].mg_4);
                    $(".mg_5").val(responses.details_items[0].mg_5);
                    $(".tag").val(responses.details_items[0].tag);
                    $(".tag").val(responses.details_items[0].tag);
                    $(".unit").val(responses.details_items[0].unit);
                    $(".unit_2").val(responses.details_items[0].unit_2);
                    $(".satinalama_siparis_birimi").val(responses.details_items[0].satinalama_siparis_birimi);
                    $(".satinalama_kabul_birimi").val(responses.details_items[0].satinalama_kabul_birimi);
                    $(".satis_birimi").val(responses.details_items[0].satis_birimi);
                    $(".temin_turu").val(responses.details_items[0].temin_turu);
                    $(".satinalma_turu").val(responses.details_items[0].satinalma_turu);
                    $(".imalat_siparis_birimi").val(responses.details_items[0].imalat_siparis_birimi);
                    $(".rapor_birimi").val(responses.details_items[0].rapor_birimi);
                    $(".satinalma_suresi").val(responses.details_items[0].satinalma_suresi);
                    $(".imalat_tedarik_suresi").val(responses.details_items[0].imalat_tedarik_suresi);
                    $(".kdv").val(responses.details_items[0].taxrate);
                    $(".ean").val(responses.details_items[0].ean);
                    $(".product_description").val(responses.details_items[0].product_des);
                    $(".image_text").val(responses.details_items[0].image_text);


                    id =responses.details_items[0].id

                    // $(".pro_type").val(responses.details_items[0].product_type) $('.simeta_product_name').val(responses.details_items[0].simeta_product_name)
                    // $('.simeta_code').val(responses.details_items[0].simeta_code)
                    // $("#demirbas_id").val(responses.details_items[0].demirbas_id)
                    $('.degisken_varyant').empty().append(responses.varyant_degerleri);

                });
                self.$content.find('#person-list').empty().append(html);


                return $('#person-container').html();
            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {

                        let status =$('.status').is(':checked')?1:0;
                        let gercek =$('.gercek').is(':checked')?1:0;
                        let data_post = {
                            id: id,
                            product_stock_code_id: product_stock_code_id,
                            product_id: product_id,
                            crsf_token: crsf_hash,
                            product_name: $('.product_name').val(),
                            product_name_tr: $('.product_name_tr').val(),
                            product_name_en: $('.product_name_en').val(),
                            pro_type: $('.pro_type').val(),
                            product_description: $('.product_description').val(),
                            image: $('#image_text_update').val(),
                            product_code:$('.product_code').val(),
                            short_name:$('.short_name').val(),
                            marka:$('.marka').val(),
                            kalinlik:$('.kalinlik').val(),
                            en:$('.en').val(),
                            boy:$('.boy').val(),
                            yukseklik:$('.yukseklik').val(),
                            yogunluk:$('.yogunluk').val(),
                            ic_cap:$('.ic_cap').val(),
                            dis_cap:$('.dis_cap').val(),
                            t:$('.t').val(),
                            emniyet_stok:$('.emniyet_stok').val(),
                            min_sip_mik:$('.min_sip_mik').val(),
                            siparis_katlari:$('.siparis_katlari').val(),
                            iskarta_orani:$('.iskarta_orani').val(),
                            uretim_katsayisi:$('.uretim_katsayisi').val(),
                            palet:$('.palet').val(),
                            denye:$('.denye').val(),
                            brut_agirlik:$('.brut_agirlik').val(),
                            net_agirlik:$('.net_agirlik').val(),
                            gercek:gercek,
                            status: status,
                            barcode:$('.barcode').val(),
                            standart_code:$('.standart_code').val(),
                            ozel_kod_1:$('.ozel_kod_1').val(),
                            ozel_kod_2:$('.ozel_kod_2').val(),
                            ozel_kod_3:$('.ozel_kod_3').val(),
                            baz_miktari:$('.baz_miktari').val(),
                            fire_stok_kodu:$('.fire_stok_kodu').val(),
                            mg_1:$('.mg_1').val(),
                            mg_2:$('.mg_2').val(),
                            mg_3:$('.mg_3').val(),
                            mg_4:$('.mg_4').val(),
                            mg_5:$('.mg_5').val(),
                            tag:$('.tag').val(),
                            unit:$('.unit').val(),
                            unit_2:$('.unit_2').val(),
                            satinalama_siparis_birimi:$('.satinalama_siparis_birimi').val(),
                            satinalama_kabul_birimi:$('.satinalama_kabul_birimi').val(),
                            satis_birimi:$('.satis_birimi').val(),
                            temin_turu:$('.temin_turu').val(),
                            satinalma_turu:$('.satinalma_turu').val(),
                            imalat_siparis_birimi:$('.imalat_siparis_birimi').val(),
                            rapor_birimi:$('.rapor_birimi').val(),
                            satinalma_suresi:$('.satinalma_suresi').val(),
                            imalat_tedarik_suresi:$('.imalat_tedarik_suresi').val(),
                            kdv:$('.kdv').val(),
                            ean:$('.ean').val(),
                            // crsf_token: crsf_hash,
                            // product_name: $('.product_name').val(),
                            // simeta_product_name: $('.simeta_product_name').val(),
                            // simeta_code: $('.simeta_code').val(),
                            // category_id: $('.category_id').val(),
                            // product_description: $('.product_description').val(),
                            // pro_type: $('.pro_type').val(),
                             image: $('#image_text_update_parent').val(),
                            // demirbas_id: $('#demirbas_id').val()
                        }


                        $.post(baseurl + 'urun/update_parent', data_post, (response) => {
                            // console.log(data_post)
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
                                                table_product_id_ar = [];
                                                $('#product_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        },
                                    }
                                });
                            }
                            else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
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

                $('#fileupload_update_parent').fileupload({
                    url: baseurl + 'urun/file_handling',
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

                        $('#image_text_update_parent').val('/userfiles/product/' + img);
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
    })


    $(document).on('click','.button_podradci_borclandirma',function (){

        let cari_pers_type=0;
        let tip=$(this).attr('tip');
        let islem_id=$(this).attr('islem_id');
        let islem_tipi=$(this).attr('islem_tipi');
        let title = "Cari / Personel Borçlandırma Talebi";
        let icon='fa fa-plus';
        if(tip=="create"){
            title="Cari / Personel Borçlandırma";
            icon='fa fa-plus';
        }

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: title,
            icon: icon,
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-row">
                        <div class="form-group col-md-12 alt_div_podradci" >
                          <label for="name">İşlem Türü</label>
                          <select class="form-control cari_pers_type" id="cari_pers_type" name="cari_pers_type" >
                                <option value="0">Seçiniz</option>
                                <?php foreach (cari_pers_type_talep() as $pers)
                                    {
                                    echo "<option value='$pers->id'>$pers->name</option>";
                                    } ?>
                            </select>
                            </div>
                            <div class='list'></div>
                        </div>
                    </form>`,
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name = $('.cari_pers_type').val()
                        if(!parseInt(name)){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'İşlem Türü Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        cari_pers_type = $('.cari_pers_type').val();
                        let title='Cari'
                        let select=` <select class="form-control zorunlu_text select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="0">Seçiniz</option>
                                                                    <?php foreach (all_customer() as $pers)
                        {
                            echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                        } ?>
                                                                </select>`;
                        if(cari_pers_type==2){
                            title='Personel'
                            select=` <select class="form-control zorunlu_text select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="0">Seçiniz</option>
                                                                    <?php foreach (all_personel() as $pers)
                            {
                                echo "<option name='$pers->name' value='$pers->id'>$pers->name</option>";
                            } ?>
                                                                </select>`;
                        }

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: title,
                            icon: 'fa fa-plus',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "medium",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                          <div class="form-row">
                                            <div class="form-group col-md-12">
                                              <label for="name">`+title+`</label>
                                                    `+select+`
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                              <label for="name">Tutar</label>
                                                   <input type="number" value="0" class="form-control tutar zorunlu_text">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                              <label for="name">Açıklama</label>
                                                   <input type="text" class="form-control desc zorunlu_text">
                                                </div>
                                            </div>
                                            <input type='hidden' name='payer_id' class="payer_id" value='`+cari_pers_type+`'>
                                        </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Devam',
                                    btnClass: 'btn-blue',
                                    action: function () {


                                        let tutar = $('.tutar').val()
                                        let desc = $('.desc').val()
                                        let payer_id = $('.payer_id').val()
                                        if(!parseInt(tutar)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Tutar Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        if(!parseInt(payer_id)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content:   title+' Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        if(!desc){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Açıklama Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        $('#loading-box').removeClass('d-none');
                                        let data = {
                                            payer_id: payer_id,
                                            desc: desc,
                                            tutar: tutar,
                                            cari_pers_type: cari_pers_type,
                                            islem_tipi: islem_tipi,
                                            islem_id: islem_id,
                                            tip: tip,
                                        }
                                        $.post(baseurl + 'transactions/create_podradci_borc', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            if (responses.status == 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                        }
                                                    }
                                                });
                                                $('#loading-box').addClass('d-none');

                                            } else if (responses.status == 410) {

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
                                                $('#loading-box').addClass('d-none');


                                            }
                                        });
                                    },
                                },
                            },
                            onContentReady: function () {

                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })
                                // bind to events
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });


                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                let data = {
                    crsf_token: crsf_hash,
                    islem_id: islem_id,
                    islem_tipi: islem_tipi,
                }

                let table_report='';
                $.post(baseurl + 'transactions/podradci_html',data,(response) => {
                    let responses = jQuery.parseJSON(response);
                    $('.list').empty().html(responses.html);


                });

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
    $(document).on('click','.borclandirma_sil',function (){
        let id = $(this).attr('b_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: "Dikkat Bu İşlemi Silmek İstediğinizden Emin Misiniz?",
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            id: id
                        }
                        $.post(baseurl + 'transactions/borclandirma_sil', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');

                            } else if (responses.status == 410) {

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
                                $('#loading-box').addClass('d-none');


                            }
                        });
                    },
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
    function borclandirma_kontrol(){
        let path_name = document.location.pathname;
        let sonuc_mt = path_name.search('malzemetalep/view');
        let sonuc_gt = path_name.search('carigidertalepnew/view');
        let sonuc_at = path_name.search('customeravanstalep/view');
        let sonuc_forma2 = path_name.search('formainvoices/view');
        let sonuc_nakliye = path_name.search('nakliye/view');
        let sonuc_qaime = path_name.search('invoices/view');
        if(sonuc_mt==1 || sonuc_gt==1 || sonuc_at==1 || sonuc_forma2==1 || sonuc_nakliye==1 || sonuc_qaime==1){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-info',
                type: 'warning',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                title: 'Bilgi',
                content: "Bu Talepte Podradçı / Personel Borçlandırma Yapabilirsiniz.",
                buttons:{
                    formSubmit: {
                        text: 'Tamam',
                        btnClass: 'btn-blue borclandirma_kontrol_button'
                    }
                }
            });
        }

    }

    $(document).on('click','.firma_update',function (){
        let firma_id = $(this).attr('firma_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Firma Değiştirme',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Firma Değiştirmek Üzeresiniz Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Değiştir',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            firma_id:  firma_id
                        }
                        $.post(baseurl + 'locations/set_firma',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                window.location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
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

    $(document).on('click','.firma_update_onay',function (){
        let firma_id = $(this).attr('firma_id');
        let user_id = $(this).attr('user_id');
        let tip = $(this).attr('tip');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Firma Değiştirme',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Firma Değiştirmek Üzeresiniz Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Değiştir',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            firma_id:  firma_id,
                            user_id:  user_id,
                            tip:  tip,
                        }
                        $.post(baseurl + 'locations/set_firma_onay',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {

                                                window.location.href = responses.href;
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
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
    function duyuru_kontrol(){

        let data = {
            crsf_token: crsf_hash,
        }

        let table_report='';
        $.post(baseurl + 'notification/get_duyuru',data,(response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {

                responses.details.forEach((item) => {
                    $.confirm({
                        theme: 'modern',
                        closeIcon: true,
                        title: 'Duyuru',
                        icon: 'fa fa-bullhorn',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "medium",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: "<p style='font-size: 19px;font-weight: bolder;color: cornflowerblue;line-height: 46px;text-align: initial;'>"+item.text+"</p>",
                        buttons: {
                            formSubmit: {
                                text: 'Okundu Olarak İşaretle',
                                btnClass: 'btn-blue',
                                action: function () {
                                    $('#loading-box').removeClass('d-none');
                                    let data = {
                                        id: item.id,
                                    }
                                    $.post(baseurl + 'notification/duyuru_onay', data, (response) => {
                                        let responses = jQuery.parseJSON(response);
                                        if (responses.status == 200) {
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-check',
                                                type: 'green',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Başarılı',
                                                content: responses.message,
                                                buttons: {
                                                    formSubmit: {
                                                        text: 'Tamam',
                                                        btnClass: 'btn-blue',
                                                    }
                                                }
                                            });
                                            $('#loading-box').addClass('d-none');

                                        } else if (responses.status == 410) {

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
                                            $('#loading-box').addClass('d-none');


                                        }
                                    });
                                },
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


            }
        });

    }
</script>
<script>
    $(document).on('change','.custom-control-input',function (){
        let value = $(this).data('value-id');
        let key = $(this).attr('key');
        let parent_id = $(this).attr('parent_id');
        let key_plus = parseInt(key)+1;
        let count=$('.div_vs').length;

        for(let i=0;i<count;i++){
            if(i > key){
                $('.div_vs').eq(i).css('visibility','hidden')
                $('.custom-radio-'+i).css('visibility','hidden')
                if(parseInt(parent_id)==0){
                    $('.div_vs').eq(i).css('visibility','visible')
                    $('.custom-radio-'+i).css('visibility','visible')
                }
            }
            else{
                if(parseInt(parent_id)==0){
                    $('.div_vs').eq(i).css('visibility','visible')
                    $('.custom-radio-'+i).css('visibility','visible')
                }
            }
        }

        $('.div_vs').eq(key_plus).css('visibility','visible')



        let data_new = {
            value_id: parseInt(value)
        }
        let ar=[];
        $.post(baseurl + 'productoption/parent_value_get', data_new, (response) => {
            let responses = jQuery.parseJSON(response);
            $.each(responses.details, function (index, item) {
                $('.value_div_'+item.value_id).css('visibility','visible');
                $('#option_value_id_'+item.value_id+'').prop('checked',false)
            });
            //$('.vl_'+parseInt(value_id)).val(ar.slice())
        });
    })

    $(document).on('keyup','.option_search_keyword',function (){

        var input, filter, table, tr, td, i, txtValue;
        let tablec = $(this).data('tablec');
        table =  $('.'+tablec+'');
        filter =  $(this).val().toUpperCase();
        tr =  $('.'+tablec+' tr');
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    })

    $(document).on('click','.cloud_clear',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Havuzdaki Listeniz',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Fiş Listeniz Temizlenecek Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'warehouse/clear_cloud',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.code==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                               location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.code==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
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
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
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
    $(document).on('click','.pay_odenis',function (){
        let id = $(this).data('inv_id');
        alert(id);
    })

    jQuery.ajax({
        url: baseurl + 'carigidertalepnew/countgiderhizmet',
        type: 'POST',
        data: crsf_token+'='+crsf_hash,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                if(data.count){
                    $('#count_cari_new_select').empty().html(data.count)
                    $('.hizmet_tamm').removeClass('d-none');
                }
                else {
                    $('.hizmet_tamm').addClass('d-none');
                }

            }
        },
        error: function (data) {

        }
    });

    $(document).on('click','.add_not_new',function (){

        let islem_tipi = $(this).attr('islem_tipi');
        let islem_id = $(this).attr('islem_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'not Ekle',
            icon: 'fa fa-list',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<input class="form-control desc" placeholder="Açıklama"'+
                '</div>'+
                '</div>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name = $('.desc').val()
                        if(!name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Açıklama Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            islem_tipi:islem_tipi,
                            islem_id:islem_id,
                            desc:name,
                        }
                        $.post(baseurl + 'form/creat_new_notes',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.messages,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content:responses.messages,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

                        });

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
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
    $(document).on('click','.delete_not_new',function (){

        let id = $(this).attr('note_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Sil',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'Silmek İstediğinizden Emin misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            id:id
                        }
                        $.post(baseurl + 'form/delete_new_notes',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.messages,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content:responses.messages,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

                        });

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
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
    function isEmpty(value) {
        let deger =  (value == null || (typeof value === "string" && value.trim().length === 0));
        if(deger){
            return "";
        }
        else {

            return value;
        }
    }
    function isEmptyTF(value) {
        let deger =  (value == null || (typeof value === "string" && value.trim().length === 0));
        if(deger){
            return false;
        }
        else {

            return true;
        }
    }
    $(document).on('click','.option_view_btn',function () {
        let stock_id = $(this).attr('stock_code_id');
        if(stock_id){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Detaylar',
                icon: 'fa fa-filter',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "large",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: function () {
                    let self = this;
                    let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let data = {
                        stock_id: stock_id
                    }

                    let table_report='';
                    $.post(baseurl + 'urun/get_value_is',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        $('.list').empty().html(responses.html)
                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    cancel:{
                        text: 'Vazgeç',
                        btnClass: "btn btn-danger btn-sm",
                    },


                },
                onContentReady: function () {
                    setTimeout(function(){
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm")
                        })
                    }, 1000);
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }

            });

        }
    })

    $(document).on('click','.parent_image_replace',function (){
        let product_stock_code_id= $(this).attr('product_stock_code_id');
        let url= $(this).attr('src');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Resim',
            icon: 'fas fa-image',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<div class="content">
                        <div class="row">
                            <div class="col-md-6 pb-2">
                                 <img class="myImg" style="width: 322px;" src="`+url+`">
                             </div>
                            <div class="col-md-6 pb-2">
                             <div id="progress" class="progress">
                                  <div class="progress-bar progress-bar-success"></div>
                             </div>
                              <table id="files" class="files"></table><br>

                              <span class="btn btn-success fileinput-button" style="width: 100%">
                              <i class="glyphicon glyphicon-plus"></i>

                              <span>Seçiniz...</span>
                              <input id="fileupload_update_new" type="file" name="files[]">

                              <input type="hidden" class="image_text_update_new" name="image_text_update_new" id="image_text_update_new">
                             <div>
                        </div>
                    </div> `,

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {


                        let data_post = {
                            product_stock_code_id: product_stock_code_id,
                            image_text_update_new: $('.image_text_update_new').val(),
                        }


                        $.post(baseurl + 'urun/parent_image_update', data_post, (response) => {
                            // console.log(data_post)
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

                                        },
                                    }
                                });
                            }
                            else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
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
                //
                // $('#fileupload_update_new').fileupload({
                //     submit: function (e, data) {
                //         var $this = $(this);
                //         console.log($this);
                //         $.getJSON('/urun/file_handling', function (result) {
                //             data.formData = result; // e.g. {id: 123}
                //             data.jqXHR = $this.fileupload('send', data);
                //         });
                //         return false;
                //     }
                // });

                $('#fileupload_update_new').fileupload({

                    url: baseurl + 'urun/file_handling',
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

                        $('#image_text_update_new').val('/userfiles/product/' + img);
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

                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

</script>
</body>
<style>
    ::-webkit-scrollbar {
        height: 15px;
    }

    ::-webkit-scrollbar-thumb {
        background: #05867c;
        -webkit-border-radius: 1ex;
    }

    .req {
        color: red;
    }

    .is-invalid-select2 {
        border: 1px solid #dc3545 !important;
        border-radius: 0.25rem;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

</style>
</html>


