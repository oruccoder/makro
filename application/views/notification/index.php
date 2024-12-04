<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/notifations.css?v=<?php echo rand(11111,99999) ?>">
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
                            <section>c
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <?php $cari_bildirimleri = razi_count_func()+onay_qaime_list_func()+forma2_new_count_func()+caricezatalepcount_func()+atama_gider_talep_func()+atama_cari_avans_talep_func()?>

                                        <div class="row mb-4">
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="cari_form()">
                                                        <div class="card-body all_functions" style="text-align: center">

                                                            <i class="fa fa-users fa-4x"></i>
                                                            <h4>Cari Bildirimleri</h4>
                                                            <div class="badges_black">
                                                                <?php echo $cari_bildirimleri?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats  mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="personel_form()">
                                                        <div class="card-body all_functions" style="text-align: center">
                                                            <i class="fa fa-people-arrows fa-4x"></i>
                                                            <h4>Personel Bildirimleri</h4>
                                                            <?php $perspnel_bildirimleri = bekleyentask_func()+ warehousetransfercount_func()+atama_personel_avans_talep_func()+atama_personel_gider_talep_func()+countgiderhizmet_func()?>
                                                            <div class="badges_black"><?php echo $perspnel_bildirimleri?></div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats  mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="fiinans_form()">
                                                        <div class="card-body all_functions" style="text-align: center">
                                                            <i class="fa fa-coins fa-4x"></i>
                                                            <h4>Finans Bildirimleri</h4>
                                                            <?php $finans_bildirimleri= count_kasa_func()+bekleyenprimcount_func()+ajax_podradci_borclandirma_func();?>
                                                            <div class="badges_black"><?php echo $finans_bildirimleri?></div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats  mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="maas_form()">
                                                        <div class="card-body all_functions" style="text-align: center">
                                                            <i class="fa fa-money-bill fa-4x"></i>
                                                            <h4>Maaş Bildirimleri</h4>
                                                            <?php $maas_bildirimleri = bordro_edit_count_func()+maascount_func()+bekleyenmaascount_func()+muhasebeview_func() ?>
                                                            <div class="badges_black"><?php echo $maas_bildirimleri?></div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats  mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="talep_form()">
                                                        <div class="card-body all_functions" style="text-align: center">
                                                            <i class="fa fa-list-alt fa-4x"></i>
                                                            <h4>Malzeme Talep Bildirimleri</h4>
                                                            <?php $malzeme_talep_bildirimleri = stok_kontol_hizmet()+
                                                                beklyen_malzeme_count_func()+
                                                                personelsatinalmalistcount_func()+
                                                                ihalelistcount_func()+
                                                                odemeemrilistcount_func()+
                                                                siparislistcount_func()+
                                                                siparis_finist_list_count_func()+
                                                                bekleyen_sened_list_count_func()+
                                                                tehvil_list_count_func()+
                                                                qaimelistcount_func()+
                                                                talepwarehousetransfercount_func()+
                                                                odemetalepcount_func()+
                                                                avanslistcount_func()+
                                                                odemelistcountnew_func()+
                                                                ihalebeklyenlistcount_func()+
                                                                transfertaleplist_func()+
                                                                count_gider_mt_func();
                                                            ?>
                                                            <div class="badges_black"><?php echo $malzeme_talep_bildirimleri?></div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats  mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="hizmet_form()">
                                                        <div class="card-body all_functions" style="text-align: center">
                                                            <i class="fa fa-car-battery fa-4x"></i>
                                                            <h4>Hizmet Talep Bildirimleri</h4>
                                                            <?php $hizmet =stok_kontol_hizmet_func()+
                                                                bekleyen_hizmet_count_func()+
                                                                personelsatinalmahizmetlistcount_func()+
                                                                ihalelistcounthizmet_func()+
                                                                siparislistcounthizmet_func()+
                                                                siparis_finishizmet_list_count_func()+
                                                                bekleyen_sened_list_hizmet_count_func()+
                                                                tehvil_list_count_hizmet_func()+
                                                                hizmetqaimelistcount_func()?>
                                                            <div class="badges_black"><?php echo $hizmet?></div>
                                                        </div>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <div class="card card-stats  mb-4 mb-xl-0">
                                                    <a href="#" type="button" class="form_a" onclick="nakliye_form()">
                                                        <div class="card-body all_functions" style="text-align: center">
                                                            <i class="fa fa-truck fa-4x"></i>
                                                            <h4>Nakliye Talep Bildirimleri</h4>
                                                            <?php $nakliye_talepleri =  nakliye_mt_talep_func()+nakliyeteklifbekleyen_func()+atama_nakliye_talep_func()?>
                                                            <div class="badges_black"><?php echo $nakliye_talepleri?></div>
                                                        </div>
                                                    </a>
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



<script>

    function cari_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Cari Bildirimleri',
            icon: 'fa fa-users 2x',
            type: 'orange',
            useBootstrap: true,
             columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/razilastirma/bekleyen_list" data-toggle="tooltip"  data-original-title="Protokol Onayları" data-popup="popover"
                           data-trigger="hover" data-placement="top" data-content="Razılaştırma Protokol Onayları">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo razi_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Protokol Onayları
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/onay_qaime_list"  data-original-title="Onay Bekleyen Qaime Listesi"
                           data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onay Bekleyen Qaimeler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo onay_qaime_list_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Onay Bekleyen Qaime Listesi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/reports/bekleyen_forma_2"  data-original-title="Bekleyen Forma2 Onayı"   data-popup="popover"
                           data-trigger="hover" data-placement="top" data-content="Onayda Bekleyen Forma2 Listesi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo forma2_new_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Bekleyen Forma2 Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/caricezatalep"  data-original-title="Cari Ceza Talepleri"   data-popup="popover"
                           data-trigger="hover" data-placement="top" data-content="Carilere Kesilmiş Ceza Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo caricezatalepcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Cari Ceza Talepleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                      <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/caribekleyen?tip=3&status=11" data-content="Personel Seçiminde Bekleyen Cari Avans Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo atama_cari_avans_talep_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Atama Bekleyen Cari Avans Talebi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/caribekleyen?tip=2&status=11" data-content="Personel Seçiminde Bekleyen Gider Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo atama_gider_talep_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Atama Bekleyen Cari Gider Talebi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                   let mes = $(this).attr('data-content');
                   $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


    });
    }
    function personel_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Personel Bildirimleri',
            icon: 'fa fa-people-arrows 2x',
            type: 'orange',
            useBootstrap: true,
             columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/bekleyentask"
                           data-trigger="hover" data-placement="top" data-content="Size Atanmış Bekleyen Görevler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo bekleyentask_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Bekleyen Görevler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/warehouse_transfer"  data-content="Bekleyen Transfer Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo warehousetransfercount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Ambar Mahsul Transferleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/personelbekleyen?tip=3&status=11"  data-content="Personel Seçiminde Bekleyen Personel Avans Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo atama_personel_avans_talep_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Atama Bekleyen Personel Avans Talebi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/personelbekleyen?tip=2&status=11"  data-content="Personel Seçiminde Bekleyen Personel Gider Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo atama_personel_gider_talep_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Atama Bekleyen Personel Gider Talebi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/giderhizmetbekleyen"  data-content="İş GÖrüldü Bekleyen Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo countgiderhizmet_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Hizmet Tamamlama
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                    let mes = $(this).attr('data-content');
                    $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


        });
    }
    function fiinans_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Finans Bildirimleri',
            icon: 'fa fa-coins 2x',
            type: 'orange',
            useBootstrap: true,
             columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/virman/list"
                           data-trigger="hover" data-placement="top" data-content="Onayda Bekleyen Virman İşlemleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo count_kasa_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Kasa Talepleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/reports/prim_onaylari"  data-content="Onay Bekleyen Prim/Ceza Listesi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo bekleyenprimcount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Prim/Ceza Onayları
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/podradci_borclandirma"  data-content="Podradçi / Personel Borçlandırma Onayı">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo ajax_podradci_borclandirma_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Podradçi / Personel Borçlandırma Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                    let mes = $(this).attr('data-content');
                    $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


        });
    }
    function maas_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Maaş Bildirimleri',
            icon: 'fa fa-money 2x',
            type: 'orange',
            useBootstrap: true,
             columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/raporlar/edit_salary_report"
                           data-trigger="hover" data-placement="top" data-content="Düzenleme Talebi Olan Bordrolar">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo bordro_edit_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Bordro Düzenleme Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/reports/maas_onayi"  data-content="Bekleyen Maaş Onayı">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo maascount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                       Onay Bekleyen Emeq Haqları
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/reports/maas_odemesi"  data-content="Onay Bekleyen Maaş Ödemesi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo bekleyenmaascount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Bekleyen Maaş Ödemesi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/salary/muhasebe"  data-content="Son Kontrol Bekleyen Maaşlar">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo muhasebeview_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                       Maaş Son Kontrolü
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                    let mes = $(this).attr('data-content');
                    $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


        });
    }

    function talep_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            alignMiddle:true,
            title: 'Malzeme Talep Bildirimleri',
            icon: 'fa fa-list-alt 2x',
            type: 'orange',
            useBootstrap: true,
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: 1,
            columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/stok_kontrol_list"
                           data-trigger="hover" data-placement="top" data-content="Yeni Açılmış Stoklu Talep">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo stok_kontol_hizmet()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Stok Kontrolünde Olan Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/malzemetaleplist"  data-content="Onay Bekleyen Malzeme Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo beklyen_malzeme_count_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Bekleyen Malzeme Talepleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/personel_satinalma_list"  data-content="İhalesi ve Satınalması Oluşmamış Talep Listesi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo personelsatinalmalistcount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Satınalma Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/ihalelist"  data-content="İhalesi Tamamlanmış Onay Bekleyen Talep Listesi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo ihalelistcount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      İhale Onayı Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/odemeemrilist"  data-content="Onaylanmış siparişlerin Ödeme Emri bekleyen Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo odemeemrilistcount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Ödeme Emri Verilen Talapler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/siparslist"  data-content="Onaylanmış İhalelerin Sipariş Bekleyen Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo siparislistcount_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Siparişe Dönüşmeyi Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/siparisfinishlist"  data-content="Sipariş Son Kontrol Onayı">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo siparis_finist_list_count_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Sipariş Son Kontrol Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/bekleyen_sened_list"  data-content="Senedleri Bekleyen Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo bekleyen_sened_list_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Senedleri Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/tehvillist"  data-content="Satınalması Tamamlanmış Teslim Alınması Beklenen Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo tehvil_list_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Tehvil Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/qaimelist"  data-content="Onaylanmış siparişlerin qaimesi bekleyen Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo qaimelistcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Qaimeye Dönüşmeyi Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/talep_warehouse_transfer"  data-content="Anbar stok transferi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo talepwarehousetransfercount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Talep Üzerinden Gelen Transferler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/odeme_bekleyen_talepler"  data-content="Sipariş Onaylanmış Avans / Ödeme Talebi Bekleyenler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo odemetalepcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Ödeme Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/avanslist"  data-content="Onaylanmış siparişlerin Avans Onayı bekleyen Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo avanslistcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Avans Onayı Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/odemelist"  data-content="Onaylanmış siparişlerin Ödeme Onayı bekleyen Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo odemelistcountnew_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Ödeme Onayı Bekleyen Talapler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/tekliflist"  data-content="İhale Sonlandırma bekleyen Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo ihalebeklyenlistcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      İhale Sonlandırma Bekleyenler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/transferlist"  data-content="Stok Transferi Yapmanız Gereken Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo transfertaleplist_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Transfer Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/mtgidercreate"  data-content="Mt Ürünleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo count_gider_mt_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Gidere İşlenmesi Gereken Mt Ürünleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                    let mes = $(this).attr('data-content');
                    $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


        });
    }
    function nakliye_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Nakliye Bildirimleri',
            icon: 'fa fa-truck 2x',
            type: 'orange',
            useBootstrap: true,
             columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/nakliye_mt_talep"
                           data-trigger="hover" data-placement="top" data-content="Yeni Mt Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo nakliye_mt_talep_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Lojistik İçin Mt Talebi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/nakliyeteklifbekleyen"  data-content="Teklif Bekleyen Nakliyeler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo nakliyeteklifbekleyen_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                       Teklif Bekleyen Nakliyeler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/carilojistik?tip=6&status=11"  data-content="Personel Seçiminde Bekleyen Nakliye Talebi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo atama_nakliye_talep_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                        Atama Bekleyen Nakliye Talebi
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                    let mes = $(this).attr('data-content');
                    $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


        });
    }

    function hizmet_form(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Hizmet Bildirimleri',
            icon: 'fa fa-car-battery 2x',
            type: 'orange',
            useBootstrap: true,
             columnClass: 'col-md-12 col-md-offset-12 col-xs-12 col-xs-offset-12',
            animation: 'zoom',
            closeAnimation: 'scale',
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class='m4 forms' style="display: flex;">
                     <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/stok_kontrol_list_hizmet"
                           data-trigger="hover" data-placement="top" data-content="Yeni Açılmış Hizmet Talep">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo stok_kontol_hizmet_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Stok Kontrolünde Olan Hizmet Talepleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/hizmet_talep_form"
                           data-trigger="hover" data-placement="top" data-content="Talep Aşamasında Olan Hizmet Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo bekleyen_hizmet_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Hizmet Talep Formu Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/personel_satinalma_list_hizmet"
                           data-trigger="hover" data-placement="top" data-content="Satınalma Bekleyen Hizmet Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo personelsatinalmahizmetlistcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                        Satınalma Bekleyen Hizmet Talep Formu Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/ihalelist_hizmet"  data-content="İhalesi Tamamlanmış Onay Bekleyen Hizmet Talep Listesi">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo ihalelistcounthizmet_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      İhale Onayı Bekleyen Hizmet Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/siparslist_hizmet"  data-content="Onaylanmış İhalelerin Sipariş Bekleyen Hizmet Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo siparislistcounthizmet_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Siparişe Dönüşmeyi Bekleyen Hizmet Talepleri
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/siparisfinishlist_hizmet"  data-content="Sipariş Son Kontrol Onayı">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>

                                        <div class="badges_black"><?php echo siparis_finishizmet_list_count_func()?></div>

                                    </div>
                                    <div class="text-gray" >
                                      Sipariş Son Kontrol Onayı
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/bekleyen_sened_list_hizmet"  data-content="Senedleri Bekleyen Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo bekleyen_sened_list_hizmet_count_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Senedleri Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/tehvillist_hizmet"  data-content="Satınalması Tamamlanmış Forma2  Beklenen Talepler">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo tehvil_list_count_hizmet_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Forma2 Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xs-12 m10">
                        <a href="/onay/hizmetqaimelist"  data-content="Onaylanmış siparişlerin qaimesi bekleyen Talepleri">
                            <div class="card card-stats in_stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="notifier new">
                                        <i class="fa fa-bell bells"></i>
                                        <div class="badges_black"><?php echo hizmetqaimelistcount_func()?></div>
                                    </div>
                                    <div class="text-gray" >
                                      Qaimeye Dönüşmeyi Bekleyen Talepler
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                </div>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                this.$content.closest('.jconfirm').css('z-index', 1);

                $("a").hover(function(){
                    let mes = $(this).attr('data-content');
                    $(this).attr('title-new', mes);

                })

                let div_count = $('.notifier div').length;
                for (let i = 0; i < div_count; i++){
                    let count =  parseInt($('.notifier div').eq(i).html());
                    if(count){
                        $('.new div').eq(i).removeClass('badges_black');
                        $('.new div').eq(i).addClass('badges');
                    }
                }


                let div_count_ = $('.all_functions div').length;
                for (let i = 0; i < div_count_; i++){
                    let count =  parseInt($('.all_functions div').eq(i).html());
                    if(count){
                        $('.all_functions div').eq(i).removeClass('badges_black');
                        $('.all_functions div').eq(i).addClass('badges');
                    }
                }
            }


        });
    }


    $(function () {

        let div_count = $('.notifier div').length;
        for (let i = 0; i < div_count; i++){
            let count =  parseInt($('.notifier div').eq(i).html());
            if(count){
                $('.new div').eq(i).removeClass('badges_black');
                $('.new div').eq(i).addClass('badges');
            }
        }


        let div_count_ = $('.all_functions div').length;
        for (let i = 0; i < div_count_; i++){
            let count =  parseInt($('.all_functions div').eq(i).html());
            if(count){
                $('.all_functions div').eq(i).removeClass('badges_black');
                $('.all_functions div').eq(i).addClass('badges');
            }
        }





        $('.select-box').select2();


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



    })
</script>
