<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Tüm Bildirimler</span></h4>
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
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/virman/list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Kasa Talepleri</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="kasacount"><?php echo count_kasa_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray mr-2">Onayda Bekleyen Virman İşlemleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/raporlar/edit_salary_report">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Bordro Düzenleme Onayı</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="bordro_edit"><?php echo bordro_edit_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-users"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Düzenleme Talebi Olan Bordrolar</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/razilastirma/bekleyen_list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Protokol Onayları</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="razi_count"><?php echo razi_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Razılaştırma Protokol Onayları</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/reports/maas_onayi">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Bekleyen Maaş Onayı</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="maascount"> <?php echo maascount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onay Bekleyen Emeq Haqları</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/reports/maas_odemesi">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Bekleyen Maaş Ödemesi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="bekleyenmaascount"><?php echo bekleyenmaascount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-credit-card"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray mr-2">Onay Bekleyen Maaş Ödemesi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/onay_qaime_list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Onay Bekleyen Qaimeler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="onay_qaime_list"><?php echo onay_qaime_list_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onay Bekleyen Qaime Listesi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/reports/bekleyen_forma_2">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Bekleyen Forma2 Onayı</h5>
                                                                    <!--                                                        <span class="h2_ font-weight-bold mb-0" id="forma2count">0</span>-->
                                                                    <span class="h2_ font-weight-bold mb-0 forma_2_count"><?php echo forma2_new_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-question-circle"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onayda Bekleyen Forma2 Listesi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/reports/prim_onaylari">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Prim/Ceza Onayları</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="bekleyenprimcount"><?php echo bekleyenprimcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-address-card"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onay Bekleyen Prim/Ceza Listesi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!--                                            <div class="col-xl-3 col-lg-6 mt-2">-->
                                            <!--                                                <a href="/lojistikgider/bekleyen_list">-->
                                            <!--                                                    <div class="card card-stats mb-4 mb-xl-0">-->
                                            <!--                                                        <div class="card-body">-->
                                            <!--                                                            <div class="row">-->
                                            <!--                                                                <div class="col">-->
                                            <!--                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Lojistik Gideri</h5>-->
                                            <!--                                                                    <span class="h2_ font-weight-bold mb-0" id="bekleyenlojistikgideri">0</span>-->
                                            <!--                                                                </div>-->
                                            <!--                                                                <div class="col-auto">-->
                                            <!--                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">-->
                                            <!--                                                                        <i class="fa fa-truck"></i>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                </div>-->
                                            <!--                                                            </div>-->
                                            <!--                                                            <p class="mt-3 mb-0 text-muted text-sm">-->
                                            <!--                                                                <span class="text-gray">Onay Bekleyen Lojistik Gideri</span>-->
                                            <!--                                                            </p>-->
                                            <!--                                                        </div>-->
                                            <!--                                                    </div>-->
                                            <!--                                                </a>-->
                                            <!--                                            </div>-->



                                        </div>


                                        <div class="row">
                                            <!--                                            <div class="col-xl-3 col-lg-6 mt-2">-->
                                            <!--                                                <a href="/lojistikconfirm">-->
                                            <!--                                                    <div class="card card-stats mb-4 mb-xl-0">-->
                                            <!--                                                        <div class="card-body">-->
                                            <!--                                                            <div class="row">-->
                                            <!--                                                                <div class="col">-->
                                            <!--                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Tamamlanan Lojistik Hizmeti</h5>-->
                                            <!--                                                                    <span class="h2_ font-weight-bold mb-0" id="lojistikhizmet">0</span>-->
                                            <!--                                                                </div>-->
                                            <!--                                                                <div class="col-auto">-->
                                            <!--                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">-->
                                            <!--                                                                        <i class="fa fa-check"></i>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                </div>-->
                                            <!--                                                            </div>-->
                                            <!--                                                            <p class="mt-3 mb-0 text-muted text-sm">-->
                                            <!--                                                                <span class="text-gray">İncelenmesi Bekleyen Lojistik Hizmeti</span>-->
                                            <!--                                                            </p>-->
                                            <!--                                                        </div>-->
                                            <!--                                                    </div>-->
                                            <!--                                                </a>-->
                                            <!--                                            </div>-->
                                            <!--                                            <div class="col-xl-3 col-lg-6 mt-2">-->
                                            <!--                                                <a href="/aracform/bekleyen_list">-->
                                            <!--                                                    <div class="card card-stats mb-4 mb-xl-0">-->
                                            <!--                                                        <div class="card-body">-->
                                            <!--                                                            <div class="row">-->
                                            <!--                                                                <div class="col">-->
                                            <!--                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Bekleyen Araç Talep Formları</h5>-->
                                            <!--                                                                    <span class="h2_ font-weight-bold mb-0" id="beklyenaracform">0</span>-->
                                            <!--                                                                </div>-->
                                            <!--                                                                <div class="col-auto">-->
                                            <!--                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">-->
                                            <!--                                                                        <i class="fa fa-truck-monster"></i>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                </div>-->
                                            <!--                                                            </div>-->
                                            <!--                                                            <p class="mt-3 mb-0 text-muted text-sm">-->
                                            <!--                                                                <span class="text-gray">Araç Talep Eden Personel Listesi</span>-->
                                            <!--                                                            </p>-->
                                            <!--                                                        </div>-->
                                            <!--                                                    </div>-->
                                            <!--                                                </a>-->
                                            <!--                                            </div>-->
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/stok_kontrol_list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Stok Kontrolünde Olan Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="stok_kontrol_list"><?php echo stok_kontol_hizmet() ?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Yeni Açılmış Stoklu Talep</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/malzemetaleplist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Malzeme Talep Onayları</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="beklyen_malzeme_count"><?php echo beklyen_malzeme_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Bekleyen Malzeme Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/personel_satinalma_list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Satınalma Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="personelsatinalmalistcount"><?php echo personelsatinalmalistcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray mr-2">İhalesi ve Satınalması Oluşmamış Talep Listesi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/ihalelist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">İhale Onayı Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="ihalelistcount"><?php echo ihalelistcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">İhalesi Tamamlanmış Onay Bekleyen Talep Listesi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/odemeemrilist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Ödeme Emri Verilen Talapler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="odemeemrilistcount"><?php echo odemeemrilistcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onaylanmış siparişlerin Ödeme Emri bekleyen Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/siparslist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Siparişe Dönüşmeyi Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="siparislistcount"><?php echo siparislistcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-truck-monster"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onaylanmış İhalelerin Sipariş Bekleyen Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/siparisfinishlist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Sipariş Son Kontrol Onayı</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="siparisfinishcount"><?php echo siparis_finist_list_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Sipariş Son Kontrol Onayı</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/bekleyen_sened_list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Senedleri Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="bekleyensenedlist"><?php echo bekleyen_sened_list_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray mr-2">Senedleri Tamamlanmamış Talepler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/tehvillist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Tehvil Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="tehvilwarehousecount"><?php echo tehvil_list_count_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-warehouse"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Satınalması Tamamlanmış Teslim Alınması Beklenen Talepler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/qaimelist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Qaimeye Dönüşmeyi Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="qaimelistcount"><?php echo qaimelistcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onaylanmış siparişlerin qaimesi bekleyen Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/warehouse_transfer">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Ambar Mahsul Transferleri</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="warehousetransfercount"><?php echo warehousetransfercount_func();?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-warehouse"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Bekleyen Transfer Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/talep_warehouse_transfer">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Mehsul Talebi Anbar Transferi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="talepwarehousetransfercount"><?php echo talepwarehousetransfercount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-warehouse"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray mr-2">Taleb Üzerinden Gelen Transferler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/odeme_bekleyen_talepler">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Ödeme Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="odemetalepcount"><?php echo odemetalepcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-warehouse"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Sipariş Onaylanmış Avans / Ödeme Talebi Bekleyenler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/avanslist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Avans Onayı Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="avanslistcount"><?php echo avanslistcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-file"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onaylanmış siparişlerin Avans Onayı bekleyen Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/odemelist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Ödeme Onayı Bekleyen Talapler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="odemelistcount"><?php echo odemelistcountnew_func();?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Onaylanmış siparişlerin Ödeme Onayı bekleyen Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/tekliflist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">İhale Sonlandırma Bekleyenler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="ihalebeklyenlistcount"><?php echo ihalebeklyenlistcount_func() ?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">İhale Sonlandırma bekleyen Talepler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/transferlist">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Transfer Bekleyen Talepler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="transfertaleplist"><?php echo transfertaleplist_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Stok Transferi Yapmanız Gereken Talepler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/bekleyentask">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Bekleyen Görevler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="bekleyentask"><?php echo bekleyentask_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Size Atanmış Bekleyen Görevler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/salary/muhasebe">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Maaş Son Kontrolleri</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="muhasebeview"><?php echo muhasebeview_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Kontrol Bekleyen Maaşlar</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/giderhizmetbekleyen">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Hizmet Tamamlama</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="count_cari_new"><?php echo countgiderhizmet_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">İş GÖrüldü Bekleyen Talepler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/mtgidercreate">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Gidere İşlenmesi Gereken Mt Ürünleri</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="count_gider_mt"><?php echo count_gider_mt_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Mt Ürünleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/nakliye_mt_talep">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Lojistik İçin Mt Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="nakliye_mt_talep"><?php echo nakliye_mt_talep_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Yeni Mt Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/caricezatalep">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Cari Ceza Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="caricezatalep"><?php echo caricezatalepcount_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Carilere Kesilmiş Ceza Talepleri</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/nakliyeteklifbekleyen">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Teklif Bekleyen Nakliyeler</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="nakliyeteklifbekleyen"><?php echo nakliyeteklifbekleyen_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Teklif Bekleyen Nakliyeler</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/caribekleyen?tip=2&status=11">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Atama Bekleyen Cari Gider Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="atama_gider_talep"><?php echo atama_gider_talep_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Personel Seçiminde Bekleyen Gider Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/carilojistik?tip=6&status=11">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Atama Bekleyen Nakliye Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="atama_nakliye_talep"><?php echo atama_nakliye_talep_func();?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Personel Seçiminde Bekleyen Nakliye Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/caribekleyen?tip=3&status=11">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Atama Bekleyen Cari Avans Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="atama_cari_avans_talep"><?php echo atama_cari_avans_talep_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Personel Seçiminde Bekleyen Cari Avans Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/personelbekleyen?tip=3&status=11">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Atama Bekleyen Personel Avans Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="atama_personel_avans_talep"><?php echo atama_personel_avans_talep_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Personel Seçiminde Bekleyen Personel Avans Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/personelbekleyen?tip=2&status=11">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Atama Bekleyen Personel Gider Talebi</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="atama_personel_gider_talep"><?php echo atama_personel_gider_talep_func();?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Personel Seçiminde Bekleyen Personel Gider Talebi</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/podradci_borclandirma">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Podradçi / Personel Borçlandırma Onayı</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="podradci_borclandirma"><?php echo ajax_podradci_borclandirma_func()?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Podradçi / Personel Borçlandırma Onayı</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 mt-2">
                                                <a href="/onay/stok_kontrol_list">
                                                    <div class="card card-stats mb-4 mb-xl-0">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="card-title text-uppercase text-muted mb-0">Stok Kontrolünde Olan Hizmet Talepleri</h5>
                                                                    <span class="h2_ font-weight-bold mb-0" id="stok_kontrol_list_hizmet"><?php echo stok_kontol_hizmet_func();?></span>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="icon icon-shape  text-black rounded-circle shadow">
                                                                        <i class="fa fa-building"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                                <span class="text-gray">Yeni Açılmış Hizmet Talep</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
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



<style>

    :root {
        --blue: #5e72e4;
        --indigo: #5603ad;
        --purple: #8965e0;
        --pink: #f3a4b5;
        --red: #f5365c;
        --orange: #fb6340;
        --yellow: #ffd600;
        --green: #2dce89;
        --teal: #11cdef;
        --cyan: #2bffc6;
        --white: #fff;
        --gray: #8898aa;
        --gray-dark: #32325d;
        --light: #ced4da;
        --lighter: #e9ecef;
        --primary: #5e72e4;
        --secondary: #f7fafc;
        --success: #2dce89;
        --info: #11cdef;
        --warning: #fb6340;
        --danger: #f5365c;
        --light: #adb5bd;
        --dark: #212529;
        --default: #172b4d;
        --white: #fff;
        --neutral: #fff;
        --darker: black;
        --breakpoint-xs: 0;
        --breakpoint-sm: 576px;
        --breakpoint-md: 768px;
        --breakpoint-lg: 992px;
        --breakpoint-xl: 1200px;
        --font-family-sans-serif: Open Sans, sans-serif;
        --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    @-ms-viewport {
        width: device-width;
    }

    figcaption,
    footer,
    header,
    main,
    nav,
    section {
        display: block;
    }



    [tabindex='-1']:focus {
        outline: 0 !important;
    }

    h2,
    h5 {
        margin-top: 0;
        margin-bottom: .5rem;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    dfn {
        font-style: italic;
    }

    strong {
        font-weight: bolder;
    }

    a {
        text-decoration: none;
        color: #5e72e4;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }

    a:hover {
        text-decoration: none;
        color: #233dd2;
    }

    a:not([href]):not([tabindex]) {
        text-decoration: none;
        color: inherit;
    }

    a:not([href]):not([tabindex]):hover,
    a:not([href]):not([tabindex]):focus {
        text-decoration: none;
        color: inherit;
    }

    a:not([href]):not([tabindex]):focus {
        outline: 0;
    }

    caption {
        padding-top: 1rem;
        padding-bottom: 1rem;
        caption-side: bottom;
        text-align: left;
        color: #8898aa;
    }

    button {
        border-radius: 0;
    }

    button:focus {
        outline: 1px dotted;
        outline: 5px auto -webkit-focus-ring-color;
    }

    input,
    button {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        margin: 0;
    }

    button,
    input {
        overflow: visible;
    }

    button {
        text-transform: none;
    }

    button,
    [type='reset'],
    [type='submit'] {
        -webkit-appearance: button;
    }

    button::-moz-focus-inner,
    [type='button']::-moz-focus-inner,
    [type='reset']::-moz-focus-inner,
    [type='submit']::-moz-focus-inner {
        padding: 0;
        border-style: none;
    }

    input[type='radio'],
    input[type='checkbox'] {
        box-sizing: border-box;
        padding: 0;
    }

    input[type='date'],
    input[type='time'],
    input[type='datetime-local'],
    input[type='month'] {
        -webkit-appearance: listbox;
    }

    legend {
        font-size: 1.5rem;
        line-height: inherit;
        display: block;
        width: 100%;
        max-width: 100%;
        margin-bottom: .5rem;
        padding: 0;
        white-space: normal;
        color: inherit;
    }

    [type='number']::-webkit-inner-spin-button,
    [type='number']::-webkit-outer-spin-button {
        height: auto;
    }

    [type='search'] {
        outline-offset: -2px;
        -webkit-appearance: none;
    }

    [type='search']::-webkit-search-cancel-button,
    [type='search']::-webkit-search-decoration {
        -webkit-appearance: none;
    }

    ::-webkit-file-upload-button {
        font: inherit;
        -webkit-appearance: button;
    }

    [hidden] {
        display: none !important;
    }

    h2,
    h5,
    .h2,
    .h5 {
        font-family: inherit;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: .5rem;
        color: #32325d;
    }

    h2,
    .h2 {
        font-size: 1.25rem;
    }
    .h2_ {
        font-size: 2.25rem;
        font-family: inherit;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: .5rem;
        color: #32325d;
    }

    .h2_title {
        font-size: 2.25rem;
        font-family: inherit;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: .5rem;
        color: #32325d;
    }

    h5,
    .h5 {
        font-size: .8125rem;
    }

    .container-fluid {
        width: 100%;
        margin-right: auto;
        margin-left: auto;
        padding-right: 15px;
        padding-left: 15px;
    }

    .row {
        display: flex;
        margin-right: -15px;
        margin-left: -15px;
        flex-wrap: wrap;
    }

    .col,
    .col-auto,
    .col-lg-6,
    .col-xl-3,
    .col-xl-6 {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .col {
        max-width: 100%;
        flex-basis: 0;
        flex-grow: 1;
    }

    .col-auto {
        width: auto;
        max-width: none;
        flex: 0 0 auto;
    }

    @media (min-width: 992px) {
        .col-lg-6 {
            max-width: 50%;
            flex: 0 0 50%;
        }
    }

    @media (min-width: 1200px) {
        .col-xl-3 {
            max-width: 25%;
            flex: 0 0 25%;
        }
        .col-xl-6 {
            max-width: 50%;
            flex: 0 0 50%;
        }
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        border: 1px solid rgba(0, 0, 0, 0.14);
        border-radius: .375rem;
        background-color: #fff;
        background-clip: border-box;
    }

    .card-body {
        padding: 1.5rem;
        flex: 1 1 auto;
    }

    .card-title {
        margin-bottom: 1.25rem;
    }

    @keyframes progress-bar-stripes {
        from {
            background-position: 1rem 0;
        }
        to {
            background-position: 0 0;
        }
    }

    . {
        background-color: #11cdef !important;
    }

    a.:hover,
    a.:focus,
    button.:hover,
    button.:focus {
        background-color: #0da5c0 !important;
    }

    . {
        background-color: #fb6340 !important;
    }

    a.:hover,
    a.:focus,
    button.:hover,
    button.:focus {
        background-color: #fa3a0e !important;
    }

    . {
        background-color: #f5365c !important;
    }

    a.:hover,
    a.:focus,
    button.:hover,
    button.:focus {
        background-color: #ec0c38 !important;
    }

    .bg-default {
        background-color: #172b4d !important;
    }

    a.bg-default:hover,
    a.bg-default:focus,
    button.bg-default:hover,
    button.bg-default:focus {
        background-color: #0b1526 !important;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .align-items-center {
        align-items: center !important;
    }

    @media (min-width: 1200px) {
        .justify-content-xl-between {
            justify-content: space-between !important;
        }
    }

    .shadow {
        box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    .mr-2 {
        margin-right: .5rem !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .mb-5 {
        margin-bottom: 3rem !important;
    }

    .pt-5 {
        padding-top: 3rem !important;
    }

    .pb-8 {
        padding-bottom: 8rem !important;
    }

    .m-auto {
        margin: auto !important;
    }

    @media (min-width: 768px) {
        .pt-md-8 {
            padding-top: 8rem !important;
        }
    }

    @media (min-width: 1200px) {
        .mb-xl-0 {
            margin-bottom: 0 !important;
        }
    }

    .text-nowrap {
        white-space: nowrap !important;
    }

    .text-center {
        text-align: center !important;
    }

    .text-uppercase {
        text-transform: uppercase !important;
    }

    .font-weight-bold {
        font-weight: 600 !important;
    }

    .text-black {
        color: #fff !important;
    }

    .text-gray {
        color: #2dce89 !important;
    }

    a.text-gray:hover,
    a.text-gray:focus {
        color: #24a46d !important;
    }

    .text-gray {
        color: #fb6340 !important;
    }

    a.text-gray:hover,
    a.text-gray:focus {
        color: #fa3a0e !important;
    }

    .text-gray {
        color: #3d3d3d !important;
    }

    a.text-gray:hover,
    a.text-gray:focus {
        color: #3d3d3d !important;
    }

    .text-black {
        color: #000000 !important;
    }

    a.text-black:hover,
    a.text-black:focus {
        color: #4b4b4b !important;
    }

    .text-muted {
        color: #8898aa !important;
    }

    @media print {
        *,
        *::before,
        *::after {
            box-shadow: none !important;
            text-shadow: none !important;
        }
        a:not(.btn) {
            text-decoration: underline;
        }
        p,
        h2 {
            orphans: 3;
            widows: 3;
        }
        h2 {
            page-break-after: avoid;
        }
        @ page {
        size: a3;
    }
        body {
            min-width: 992px !important;
        }
    }

    figcaption,
    main {
        display: block;
    }

    main {
        overflow: hidden;
    }

    . {
        background-color: #ffd600 !important;
    }

    a.:hover,
    a.:focus,
    button.:hover,
    button.:focus {
        background-color: #ccab00 !important;
    }


    @keyframes floating-lg {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(15px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(10px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    @keyframes floating-sm {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(5px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    [class*='shadow'] {
        transition: all .15s ease;
    }

    .text-sm {
        font-size: .875rem !important;
    }

    .text-black {
        color: #000000 !important;
    }

    a.text-black:hover,
    a.text-black:focus {
        color: #282828 !important;
    }

    [class*='btn-outline-'] {
        border-width: 1px;
    }

    .card-stats .card-body {
        padding: 1rem 1.5rem;
    }

    .main-content {
        position: relative;
    }

    @media (min-width: 768px) {
        .main-content .container-fluid {
            padding-right: 39px !important;
            padding-left: 39px !important;
        }
    }

    .footer {
        padding: 2.5rem 0;
        background: #f7fafc;
    }

    .footer .copyright {
        font-size: .875rem;
    }

    .header {
        position: relative;
    }

    .icon {
        width: 3rem;
        height: 3rem;
    }

    .icon i {
        font-size: 2.25rem;
    }

    .icon-shape {
        display: inline-flex;
        padding: 12px;
        text-align: center;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
    }

    .icon-shape i {
        font-size: 1.25rem;
    }

    @media (min-width: 768px) {
        @ keyframes show-navbar-dropdown {
        0% {
            transition: visibility .25s, opacity .25s, transform .25s;
            transform: translate(0, 10px) perspective(200px) rotateX(-2deg);
            opacity: 0;
        }
        100% {
            transform: translate(0, 0);
            opacity: 1;
        }
    }
        @keyframes hide-navbar-dropdown {
            from {
                opacity: 1;
            }
            to {
                transform: translate(0, 10px);
                opacity: 0;
            }
        }
    }

    @keyframes show-navbar-collapse {
        0% {
            transform: scale(.95);
            transform-origin: 100% 0;
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes hide-navbar-collapse {
        from {
            transform: scale(1);
            transform-origin: 100% 0;
            opacity: 1;
        }
        to {
            transform: scale(.95);
            opacity: 0;
        }
    }

    p {
        font-size: 1rem;
        font-weight: 300;
        line-height: 1.7;
    }

    }


</style>

<script>
    $(function () {
        let count = $('.h2_').length;


        setTimeout(function(){
            for(let i = 0; i < count; i++){
                let values  = $('.h2_').eq(i).text();
                if(parseInt(values) > 0){
                    $('.h2_').eq(i).css('color','#fff');
                    $('.h2_').eq(i).css('background','#f22c2c');
                    $('.h2_').eq(i).css('border-radius','50%');
                    $('.h2_').eq(i).css('padding','10px');
                    $('.h2_').eq(i).css('line-height','60px');
                    $('.h2_').eq(i).css('font-size','2rem');
                }
            }
        }, 1500);


        $('.select-box').select2();

        //
        // jQuery.ajax({
        //     url: baseurl + 'notification/muhasebeview',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#muhasebeview').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        jQuery.ajax({
            url: baseurl + 'carigidertalepnew/countgiderhizmet',
            type: 'POST',
            data: crsf_token+'='+crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    // $('#count_cari_new').empty().html(data.count)
                    if(data.count){
                        // $('#count_cari_new_select').empty().html(data.count)
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

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/count_gider_mt',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#count_gider_mt').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'nakliye/nakliye_mt_talep',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#nakliye_mt_talep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'nakliye/nakliyeteklifbekleyen',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#nakliyeteklifbekleyen').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'caricezatalep/caricezatalepcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#caricezatalep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });


        // jQuery.ajax({
        //     url: baseurl + 'reports/cikispers',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#cikispers').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        //jQuery.ajax({
        //    url: "<?php //echo  base_url()?>//" + 'reports/countkasa',
        //    type: 'POST',
        //    data: crsf_token+'='+crsf_hash,
        //    dataType: 'json',
        //    success: function (data) {
        //        if (data.status == "Success") {
        //            $('#kasacount').empty().html(data.count)
        //        }
        //    },
        //    error: function (data) {
        //        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        //        $("html, body").scrollTop($("body").offset().top);
        //    }
        //});

        // jQuery.ajax({
        //     url: baseurl + 'razilastirma/razi_count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#razi_count').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //         $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //         $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        //         $("html, body").scrollTop($("body").offset().top);
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'reports/maascount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#maascount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });


        // jQuery.ajax({
        //     url: baseurl + 'logistics/lojistikhizmetcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#lojistikhizmet').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'aracform/beklyenaracform',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#beklyenaracform').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        //
        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/beklyen_malzeme_count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#beklyen_malzeme_count').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/bekleyen_sened_list_count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#bekleyensenedlist').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/tehvil_list_count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#tehvilwarehousecount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/qaimelistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#qaimelistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'stocktransfer/warehousetransfercount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#warehousetransfercount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'stocktransfer/talepwarehousetransfercount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#talepwarehousetransfercount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/odemetalepcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#odemetalepcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/avanslistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#avanslistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/odemelistcountnew',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#odemelistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/transfertaleplist',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#transfertaleplist').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'personelaction/bekleyentask',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#bekleyentask').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });




        // jQuery.ajax({
        //     url: baseurl + 'onay/atama_gider_talep',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#atama_gider_talep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'onay/atama_nakliye_talep',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#atama_nakliye_talep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'onay/atama_cari_avans_talep',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#atama_cari_avans_talep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'onay/atama_personel_avans_talep',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#atama_personel_avans_talep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'onay/atama_personel_gider_talep',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#atama_personel_gider_talep').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'onay/ajax_podradci_borclandirma',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#podradci_borclandirma').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'reports/forma2count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#forma2count').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/ihalebeklyenlistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#ihalebeklyenlistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/odemeemrilistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#odemeemrilistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/personelsatinalmalistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#personelsatinalmalistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/ihalelistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#ihalelistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/siparislistcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#siparislistcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'malzemetalep/siparis_finist_list_count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#siparisfinishcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'raporlar/bordro_edit_count',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#bordro_edit').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

        // jQuery.ajax({
        //     url: baseurl + 'reports/bekleyenmaascount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#bekleyenmaascount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'reports/onay_qaime_list',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#onay_qaime_list').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });



        // jQuery.ajax({
        //     url: baseurl + 'reports/bekleyenprimcount',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#bekleyenprimcount').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });
        // jQuery.ajax({
        //     url: baseurl + 'lojistikgider/bekleyenlojistikgideri',
        //     type: 'POST',
        //     data: crsf_token+'='+crsf_hash,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $('#bekleyenlojistikgideri').empty().html(data.count)
        //         }
        //     },
        //     error: function (data) {
        //
        //     }
        // });

    })
</script>
