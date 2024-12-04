<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title><?=$title?></title>
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
    <script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script>
        let baseurl="<?= base_url()?>";
        var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
    </script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


</head>
<body>
<div class="navbar navbar-expand-lg navbar-dark bg-dark navbar-static shadow-none">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-paragraph-justify3"></i>
            <span class="badge badge-yellow border-warning m-1"></span>
        </button>
    </div>

    <div class="navbar-brand wmin-0 mr-lg-5 p-0" style="font-size: unset !important;">
        <a href="/" class="d-inline-block">
            <div class="navbar-logo">
                <div class="pro">MakroPro</div>
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
            <ul class="navbar-nav flex-row">
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
                                    <a href="/form/bekleyen_talepler" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-file-check icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Talepler</div>
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="talepler">0</span>
                                    </a>

                                    <a href="/reports/kasa_talepleri" class="d-block text-body text-center ripple-dark rounded p-3">
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
                                        <span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="forma_2">0</span>
                                    </a>

                                    <a href="/notification" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-map5 text-danger icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">D. Bildirimler</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-item-dropdown-lg dropdown">
                    <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i>
                        <span class="d-none d-lg-inline-block ml-2">Hesabım</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                        <div class="dropdown-content-body p-2">
                            <div class="row no-gutters">
                                <div class="col-4">
                                    <a href="/user/profile" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-user-plus icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Profilim</div>
                                    </a>
                                </div>

                                <div class="col-4">
                                    <a href="#" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-coins text-pink icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">Avanslarım</div>
                                    </a>

                                </div>

                                <div class="col-4">
                                    <a href="#" class="d-block text-body text-center ripple-dark rounded p-3">
                                        <i class="icon-comment-discussion text-info icon-2x"></i>
                                        <div class="font-size-sm font-weight-semibold text-uppercase mt-2">İzinlerim</div>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                $('#forma_2').html(data.forma_2_count);
                $('#kasa_talepleri').html(data.kasa_count);
                $('#prim_ceza').html(data.bekleyen_prim_count);

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
                <a href="/" class="navbar-nav-link  {{ (request()->is('home*')) ? 'active' : '' }}">
                    <i class="icon-home4 mr-2"></i>

                </a>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">

            <li class="nav-item dropdown nav-item-dropdown-xl">

                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Fatura Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>invoices/create" class="dropdown-item"><i class="fas fa-list"></i>Yeni Fatura</a>
                    <a href="<?= base_url(); ?>invoices" class="dropdown-item"><i class="fas fa-list"></i>Fatura Listesi</a>
                    <a href="<?= base_url(); ?>formainvoices" class="dropdown-item"><i class="fas fa-list"></i>Forma2</a>
                </div>
            </li>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Cari Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>customers" class="dropdown-item"><i class="fas fa-list"></i>Cariler</a>
                    <a href="<?= base_url(); ?>clientgroup" class="dropdown-item"><i class="fas fa-list"></i>Cari Grupları</a>
                </div>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Stok Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>urun" class="dropdown-item"><i class="fas fa-list"></i>Ürünler</a>
                    <a href="<?= base_url(); ?>productoption" class="dropdown-item"><i class="fas fa-list"></i>Varyasyonlar</a>
                    <a href="<?= base_url(); ?>warehouse" class="dropdown-item"><i class="fas fa-list"></i>Depolar</a>
                    <a href="<?= base_url(); ?>stockio" class="dropdown-item"><i class="fas fa-list"></i>Stok Giriş / Çıkışları</a>
                    <a href="<?= base_url(); ?>newproductcategory" class="dropdown-item"><i class="fas fa-list"></i>Kategoriler</a>
                    <a href="<?= base_url(); ?>newunits" class="dropdown-item"><i class="fas fa-list"></i>Ölçü Birimleri</a>
                    <a href="<?= base_url(); ?>stocktransfer" class="dropdown-item"><i class="fas fa-list"></i>Stok Transferi</a>
                    <a href="<?= base_url(); ?>arac" class="dropdown-item"><i class="fas fa-list"></i>Araçlar</a>
                </div>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Finans Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>transactions" class="dropdown-item"><i class="fas fa-list"></i>Finans İşlemleri</a>
                    <a href="<?= base_url(); ?>invoices/fakrorinq" class="dropdown-item"><i class="fas fa-list"></i>Faktorinq</a>
                    <a href="<?= base_url(); ?>accounts" class="dropdown-item"><i class="fas fa-list"></i>Hesaplar</a>
                    <a href="<?= base_url(); ?>transactions/doviz_transfer" class="dropdown-item"><i class="fas fa-list"></i>Kasalar Arası Virman</a>
                    <a href="<?= base_url(); ?>accounts/gunun_ozeti" class="dropdown-item"><i class="fas fa-list"></i>Günün Özeti</a>
                    <a href="<?= base_url(); ?>cost" class="dropdown-item"><i class="fas fa-list"></i>Giderler</a>
                    <a href="<?= base_url(); ?>ihale" class="dropdown-item"><i class="fas fa-list"></i>İhale</a>
                </div>
            </li>

            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Personel Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>employee" class="dropdown-item"><i class="fas fa-list"></i>Personeller</a>
                    <a href="<?= base_url(); ?>employee/payroll_list" class="dropdown-item"><i class="fas fa-list"></i>Bordrolar</a>
                    <a href="<?= base_url(); ?>controller/personel_takip" class="dropdown-item"><i class="fas fa-list"></i>Personel Takip</a>

                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Proje Yönetimi
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>projects" class="dropdown-item"><i class="fas fa-list"></i>Projeler</a>
                    <a href="<?= base_url(); ?>projects/is_kalemleri_durumlari" class="dropdown-item"><i class="fas fa-list"></i>İş Kalemi Durumları</a>
                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Talepler
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>form/malzeme_talep_list" class="dropdown-item"><i class="fas fa-list"></i>Malzeme Talep Formu</a>
                    <a href="<?= base_url(); ?>malzemetalep" class="dropdown-item"><i class="fas fa-list"></i>New Malzeme Talep Formu</a>
                    <a href="<?= base_url(); ?>form/satinalma_formu_list" class="dropdown-item"><i class="fas fa-list"></i>Satın Alma Formu</a>
                    <a href="<?= base_url(); ?>form/gider_talebi_list" class="dropdown-item"><i class="fas fa-list"></i>Gider Talebi</a>
                    <a href="<?= base_url(); ?>form/avans_talebi_list" class="dropdown-item"><i class="fas fa-list"></i>Ödeme / Avans Talebi</a>
                    <a href="<?= base_url(); ?>lojistik" class="dropdown-item"><i class="fas fa-list"></i>Lojistik Talebi</a>
                    <a href="<?= base_url(); ?>logistics" class="dropdown-item"><i class="fas fa-list"></i>Lojistik Satınalma Talebi</a>
                    <a href="<?= base_url(); ?>aracform" class="dropdown-item"><i class="fas fa-list"></i>Araç Talep Formu</a>
                    <a href="<?= base_url(); ?>aracform" class="dropdown-item"><i class="fas fa-list"></i>Araç Talep Formu</a>
                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                   Asistan
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>meeting" class="dropdown-item"><i class="fas fa-list"></i>Toplantılar</a>
                    <a href="<?= base_url(); ?>events/list_randevu" class="dropdown-item"><i class="fas fa-list"></i>Randevular</a>
                    <a href="<?= base_url(); ?>tools/notes" class="dropdown-item"><i class="fas fa-list"></i>Notlar</a>
                    <a href="<?= base_url(); ?>controller/holidays" class="dropdown-item"><i class="fas fa-list"></i>Tatil Günleri</a>

                </div>
            </li>
            <li class="nav-item dropdown nav-item-dropdown-xl">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Raporlar
                </a>
                <div class="dropdown-menu">
                    <a href="<?= base_url(); ?>reports/cari_bakiye" class="dropdown-item"><i class="fas fa-list"></i>Cari Bakiye Raporu</a>
                    <a href="<?= base_url(); ?>reports/kdv_raporu" class="dropdown-item"><i class="fas fa-list"></i>KDV Raporu</a>
                    <a href="<?= base_url(); ?>reports/product_report" class="dropdown-item"><i class="fas fa-list"></i>Stok Raporu</a>
                    <a href="<?= base_url(); ?>raporlar/razi_report" class="dropdown-item"><i class="fas fa-list"></i>Personel Razı Raporu</a>
                    <a href="<?= base_url(); ?>logistics/lojistikhizmetlist" class="dropdown-item"><i class="fas fa-list"></i>Lojistik Araç Raporu</a>
                </div>
            </li>
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

            </li>
        </ul>
    </div>
</div>

