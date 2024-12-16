<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Xidmət Talebi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<input type="hidden" id="talep_type" value="<?php echo $details->talep_type?>">
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
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col col-xs-12 col-sm-12 col-md-12 mb-12">
                                                        <div class="jarviswidget mb-3">
                                                            <div class="borderedccc no-padding">
                                                                <div class="widget-body" style="padding: 15px;">
                                                                    <a href="/hizmet" class="btn btn-secondary" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İstek Siyahısı"><i class="fa fa-arrow-left"></i></a>
                                                                    <button type="button" class="btn btn-secondary talep_notes" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep Hakkında Notlar" talep_id="<?php echo $details->id ?>"><i class="fa fa-list"></i></button>
                                                                    <?php if($details->status==10){
                                                                        ?>
                                                                        <button type="button" class="btn btn-secondary talep_reverse" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal İşlemini Geri Al" talep_id="<?php echo $details->id ?>" ><i class="fa fa-reply"></i></button>

                                                                        <?php

                                                                    } else {

                                                                        ?>

                                                                            <?php  if($this->aauth->get_user()->id==741 || $this->aauth->get_user()->id==21 ||  $this->aauth->get_user()->id==39 || $this->aauth->get_user()->id==735) { ?>
                                                                        <button type="button" class="btn btn-danger talep_sil" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep İptal Et" ><i class="fa fa-ban"></i></button>

                                                                                <?php  }?>
                                                                        <?php
                                                                    } ?>


                                                                    <!--                                                                    <button type="button" class="btn btn-success cari_update" talep_id="--><?php //echo $details->id ?><!--"><i class="fa fa-pen"></i> Cari Değiştir</button>-->
                                                                    <button type="button" class="btn btn-secondary talep_donustur"  talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talebi Bir Önceki Adıma Al"><i class="fa fa-reply"></i></button>
                                                                    <button type="button" class="btn btn-secondary talep_pay" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Ödeme Ekle"><i class="fa fa-money-bill"></i></button>
                                                                    <button  islem_tipi="7" islem_id="<?php echo $details->id ?>" type="button" class="btn btn-secondary add_not_new" data-popup="popover" data-trigger="hover" data-original-title="Bilgilendirme"  data-placement="top" data-content="Not Ekle"><i class="fa fa-notes-medical"></i></button>
                                                                    <button  onclick="details_notes()" type="button" class="btn btn-secondary button_view_notes" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Notları Görüntüle"><i class="fa fa-list-alt"></i></button>
                                                                    <button  type="button" class="btn btn-secondary button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="1" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
                                                                    <button  type="button" class="btn btn-secondary button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="1" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>


                                                                    <?php if($details->gider_durumu) { ?>
                                                                        <!--button type="button" class="btn btn-success"><i class="fa fa-check"></i> Birbaşa Sifarişə Dönüştür</button-->
                                                                        <?php
                                                                    } ?>
                                                                    <?php if(mt_nakliye($details->id)){ ?>
                                                                        <button type="button" id="ljt_view"  mt_id="<?php echo $details->id ?>" class="btn btn-secondary flash-button">
                                                                            <i class="fa fa-truck fa-2x"></i>&nbsp; Lojistik Hareketleri
                                                                        </button>

                                                                    <?php   }  ?>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                        <div class="jarviswidget">
                                                            <input type="hidden" id="talep_id" value="<?php echo $details->id ?>">
                                                            <input type="hidden" id="talep_code" value="<?php echo $details->code ?>">
                                                            <header>
                                                                <h4>Məlumat Sorğunun</h4></header>
                                                            <div class="borderedccc no-padding">
                                                                <div class="widget-body row">
                                                                    <div class="col col-xs-8 col-sm-8 col-md-8 no-padding">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" style="border:none" ><span class="font-sm txt-color-darken no-padding"> Proje: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none" >
                                                                                        <span class="txt-color-darken no-padding " data-popup="popover" title="" data-trigger="hover" data-content="<?php echo proje_name($details->proje_id)?>" data-original-title="Proje Adı"><b><a target="_blank" href="/projects/explore?id=<?php echo $details->proje_id?>"><?php echo proje_code($details->proje_id)?></b></a></span>

                                                                                    </td>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Şirkət: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin">MAKRO 2000 EĞİTİM TEKNOLOJİLERİ İNŞAAT TAAHHÜT İÇ VE DIŞ TİCARET ANONİM ŞİRKETİ</span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="vert-align-mid" style="border:none" ><span class="font-sm txt-color-darken no-padding"> Proje Bölüm: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none" >
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo bolum_getir($details->bolum_id)?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Proje Aşaması: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo task_to_asama($details->asama_id)?></span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Talep Tarihi: </span></td>
                                                                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo dateformat_new($details->created_at)?>&nbsp;<?php echo personel_details($details->aauth)?></span></td>
                                                                                    <td class="vert-align-mid " ><div class="dgt_isPlaces"><span class="font-sm txt-color-darken no-padding">İşten Sorumlu Personel: </span></div>
                                                                                        <?php
                                                                                        $transfer_status='';
                                                                                        if($details->status==7){
                                                                                            if($details->transfer_status!=0){
                                                                                                if(!$details->transfer_bildirim){
                                                                                                    $transfer_status=' <button type="button" class="btn btn-secondary transfer_bildirim" talep_id='.$details->id.'><b></b>Bildirim Başlat</button>';
                                                                                                }
                                                                                                else {
                                                                                                    if($details->transfer_status==1){
                                                                                                        $transfer_status='Transfer Bildirimi Başlatıldı';
                                                                                                    }
                                                                                                    elseif($details->transfer_status==2){
                                                                                                        $transfer_status='Transfer Yapıldı';
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                        }
                                                                                        ?>

                                                                                    </td>
                                                                                    <td class="vert-align-mid">
                                                                                        <label class="font-md-2 txt-color-darken no-padding dgt_isPlaces no-margin">
                                                                                            <?php if(!$details->warehouse_id) {
                                                                                                ?>
                                                                                                <button class="btn btn-danger warehouse_create" tip="1"><i class="fa fa-building"></i>&nbsp;Personel Seçiniz</button><?php echo $transfer_status?>
                                                                                                <?php
                                                                                            }
                                                                                            else {
                                                                                                ?>
                                                                                                <div class="dgt_isPlaces">
                                                                                                    <button class="btn btn-success warehouse_create" tip="1" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="<?php echo  $details->warehouse_notes ?>"><i class="fa fa-building"></i>&nbsp;<?php echo  personel_detailsa($details->warehouse_id)['name'] ?></button><?php echo $transfer_status?>


                                                                                                </div>
                                                                                                <?php
                                                                                            }?>
                                                                                        </label>
                                                                                    </td>

                                                                                    <?php if($details->transfer_status) { ?>
                                                                                        <td class="vert-align-mid " ><div class="dgt_isPlaces"><span class="font-sm txt-color-darken no-padding">Transfer Teslimat Yeri: </span></div></td>
                                                                                        <td class="vert-align-mid">
                                                                                            <label class="font-md-2 txt-color-darken no-padding dgt_isPlaces no-margin">
                                                                                                <?php if(!$details->transfer_warehouse_id) {
                                                                                                    ?>
                                                                                                    <button class="btn btn-danger warehouse_create" tip="2"><i class="fa fa-warehouse"></i>&nbsp;Çatdırılma Yeri</button>
                                                                                                    <?php
                                                                                                }
                                                                                                else {
                                                                                                    ?>
                                                                                                    <div class="dgt_isPlaces">
                                                                                                        <?php
                                                                                                        $title='';
                                                                                                        if($details->transfer_status==2){
                                                                                                            $title='Transfer Tamamlandı';
                                                                                                        }
                                                                                                        else {
                                                                                                            $title ='<button class="btn btn-info transfer_status_change" tip="2"><i class="fa fa-check"></i> Transfer Tamamla</button>';
                                                                                                        }
                                                                                                        ?>

                                                                                                        <button class="btn btn-success warehouse_create" tip="2"><i class="fa fa-warehouse"></i>&nbsp;<?php echo  warehouse_details($details->transfer_warehouse_id)->title ?></button><?php echo $title ?>

                                                                                                        <?php echo  $details->transfer_warehouse_notes ?>
                                                                                                    </div>
                                                                                                    <?php
                                                                                                }?>
                                                                                            </label>
                                                                                        </td>
                                                                                    <?php } ?>

                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Talep Eden: </span></td>
                                                                                    <td class="vert-align-mid" >
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo personel_details($details->talep_eden_user_id)?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Satınalma Personeli </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                        <?php if(!$talep_user_satinalma) {
                                                                                            ?>
                                                                                            <span class="font-md-2 txt-color-darken no-padding no-margin">Henüz Personel Atanmamış</span></p>
                                                                                            <?php
                                                                                        }
                                                                                        else {
                                                                                            ?>
                                                                                            <div class="dgt_isPlaces">
                                                                                                <button class="btn btn-success sales_person_update" tip="1"><i class="fa fa-user"></i>&nbsp;<?php echo personel_details($talep_user_satinalma->user_id); ?></button>

                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Açıklama: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo $details->desc?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Talep Kodu: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <?php echo $details->code; ?>
                                                                                    </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Qaimeler </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <?php echo talep_qaime($details->id); ?>
                                                                                    </span>
                                                                                    </td>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Ödemeler</span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <?php echo talep_odemeler($details->id); ?>
                                                                                    </span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">İhale Hakkında </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <div id="ihale_sure_div"></div>
                                                                                        <?php
                                                                                        $date=date("Y-m-d H:i:s");
                                                                                        if($ihale_time){
                                                                                            if($ihale_time->durum==2){
                                                                                                echo "<input value='2' type='hidden' id='time_tip'>";
                                                                                            }
                                                                                            else {
                                                                                                echo "<input value='1' type='hidden' id='time_tip'>";
                                                                                            }
                                                                                            $date =  $ihale_time->finish_date;

                                                                                        }
                                                                                        else {
                                                                                            echo "<input value='0' type='hidden' id='time_tip'>";
                                                                                        }

                                                                                        $text_ = count_date($date);
                                                                                        ?>
                                                                                        <input type="hidden" id="ihale_suresi" value="<?php echo $text_?>">
                                                                                    </span>
                                                                                    </td>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Talep Tipi</span></td>
                                                                                        <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                      <?php echo talep_type($details->talep_type)->name?>
                                                                                    </span>
                                                                                        </td>




                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Talep İçi Transfer</span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin" style="color: #e15601;font-weight: bold;">
                                                                                        <?php if($talep_in){
                                                                                            echo "Bu Talebe Başka Bir Talepten Ürün Transfer Olmuştur.Talep Sürecinden Bakabilirsiniz";
                                                                                        } ?>

                                                                                        <?php if($talep_out){
                                                                                            echo "Bu Talepten Başka Bir Talebe Ürün Transfer Olmuştur.Talep Sürecinden Bakabilirsiniz";
                                                                                        } ?>
                                                                                    </span>
                                                                                    </td>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Talep Durumu</span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin" style="color: #e15601;font-weight: bold;">
                                                                                        <?php {
                                                                                            echo talep_form_status_details($details->status)->name;
                                                                                        } ?>

                                                                                    </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php if($details->talep_type==3) { ?>
                                                                                <tr>

                                                                                    <td class="vert-align-mid"><span class=" txt-color-darken no-padding">Bağlı Olduğu Grup: </span></td>
                                                                                    <td class="vert-align-mid" colspan="2">
                                                                                        <span class=" txt-color-darken no-padding no-margin">

                                                                                            <?php
                                                                                            if($details->id < 3193){

                                                                                            }
                                                                                            else {
                                                                                                echo  who_demirbas($details->demirbas_id)->name;
                                                                                            }
                                                                                           ?></span>
                                                                                    </td>
                                                                                </tr>

                                                                                <?php } ?>


                                                                                </tbody></table>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col col-xs-4 col-sm-4 col-md-4 no-padding">
                                                                        <div class="table-responsive">
                                                                            <?php echo demirbas_html($details->demirbas_id,$details->firma_demirbas_id); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--                    <div class="col col-xs-12 col-sm-12 col-md-4">-->
                                                    <!--                        <div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" style="" role="widget">-->
                                                    <!--                            <div class="borderedccc no-padding" role="content">-->
                                                    <!--                                <div class="jarviswidget-editbox"></div>-->
                                                    <!--                                <div class="widget-body">-->
                                                    <!--                                    <div class="col col-xs-12 col-sm-12 col-md-12" style="min-height: 120px;padding: 20px 0px;">-->
                                                    <!--                                        <div class="col-xs-12" style="border-right: 1px solid #ededed;">-->
                                                    <!--                                            <div class="text-center">-->
                                                    <!--                                                <div class="bannerCount">-->
                                                    <!--                                                    <span title="Təxmini tələb miqdarı">-->
                                                    <!--                                                        <span class="refsumtl font-xs">0 </span>-->
                                                    <!--                                                    </span>-->
                                                    <!--                                                </div>-->
                                                    <!--                                                <div class="bannerDesc margin-bottom-10 ">-->
                                                    <!--                                                    <a href="javascript:void(0);" class="" rel="popover-hover" data-placement="top" data-original-title="Necə hesablanır" data-content="Kullanıcının beyan ettiği ve Talep içerisindeki malzeme, hizmetlere ilişkin alınmış olan son fiyatlara göre hesaplanıyor (teklif,sipariş,fatura,depo)">-->
                                                    <!--                                                        Təxmini tələb miqdarı <i class="fa fa-info-circle"></i>-->
                                                    <!--                                                    </a>-->
                                                    <!---->
                                                    <!--                                                </div>-->
                                                    <!--                                            </div>-->
                                                    <!--                                        </div>-->
                                                    <!--                                    </div>-->
                                                    <!--                                </div>-->
                                                    <!--                            </div>-->
                                                    <!--                        </div>-->
                                                    <!--                    </div>-->
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget" id="wid-id-7">
                                                            <header> <h4>Tələb materialları</h4></header>
                                                            <?php

                                                            $disabled='';
                                                            if($details->status==1 || $details->status==17) { ?>
                                                                <div class="borderedccc no-padding">
                                                                    <?php if($items){  //varsa ?>
                                                                        <a href="/hizmet/talep_list_print/<?php echo $details->id; ?>" class="btn btn-warning" title="Talep Listesi">Talep PDF Çıxış</a>

                                                                        <table class="table ">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <?php if($details->talep_type!=3) { ?>
                                                                                <th>Xidmət</th>
                                                                                <?php } else { echo "<th>Gider Tanımı</th>"; }  ?>
                                                                                <th>Tanım</th>
                                                                                <?php if($details->talep_type!=3){
                                                                                    echo "<th>Varyant</th>";
                                                                                } ?>
                                                                                <th>İnfo</th>
                                                                                <th>Kullanım Yeri</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Temin Tarihi</button></th>
                                                                                <th>Son Alınan Fiyat</th>
                                                                                <th>Talep Fiyatı</th>
                                                                                <th>Aciliyet Durumu</th>
                                                                                <th>İşlem</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $i=1;
                                                                            $eq=0;

                                                                            if($details->bildirim_durumu){
                                                                                $disabled='disabled';
                                                                            }
                                                                            foreach ($items as $values) {


                                                                                $talep_form_product_options_teklif_values=talep_form_product_options_teklif_values($values->id);
                                                                                $html='';
                                                                                //$p_price = piyasa_fiyati($values->product_id,$talep_form_product_options_teklif_values);
                                                                                $p_price = piyasa_fiyati_new($values->product_id,$values->id);
                                                                                $product_details = product_details_($values->product_id);
                                                                                if(!$p_price){
                                                                                    //$html='</br><button eq="'.$eq.'" item_id="'.$values->id.'" class="btn btn-button btn-sm tahmini_fiyat" style="color: red;font-size: x-small">Tahmini Fiyat Giriniz</button>';
                                                                                }
                                                                                $product_code='';
                                                                                if($details->talep_type==1){
                                                                                    $product_code = $product_details->product_code;
                                                                                }

                                                                                $image=product_full_details_parent($values->product_stock_code_id,$values->product_id)['image']
                                                                                ?>
                                                                                <tr  id="remove<?php echo $values->id?>">
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $values->product_name.' <span class="text-muted">'.$product_code.'</span>'; ?></td>
                                                                                    <td><?php echo $values->product_desc ?></td>
                                                                                    <?php if($details->talep_type!=3){ ?>
                                                                                    <td><?php echo talep_form_product_options_new($values->product_stock_code_id) ?></td>
                                                                                    <?php } ?>

                                                                                    <td><?php echo malzeme_talep_product_kontrol($values->id,$values->product_id,$details->id,$talep_form_product_options_teklif_values) ?></td>
                                                                                    <td><?php echo $values->product_kullanim_yeri ?></td>
                                                                                    <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->product_qty ?>" class="form-control item_qty" style="width:110px"></td>
                                                                                    <td><?php echo $values->unit_name ?></td>
                                                                                    <td><?php echo dateformat_new($values->product_temin_date) ?></td>
                                                                                    <td><?php echo amountFormat($p_price).' '.$html ?></td>
                                                                                    <td><?php echo amountFormat(0);?></td>
                                                                                    <td><?php echo progress_status_details($values->progress_status_id)->name;?></td>
                                                                                    <td><button type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button></td>
                                                                                    <td>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php $i++; } ?>

                                                                            </tbody>
                                                                        </table>

                                                                        <?php

                                                                    }
                                                                    else {
                                                                        ?>
                                                                        <div class="mt-2">
                                                                            <h2 style="text-align: center">Zəhmət olmasa Xidmət əlavə etməyi unutmayın...</h2>
                                                                        </div>



                                                                        <?php
                                                                    }?>



                                                                    <div class="text-center">
                                                                        <button  type="button" talep_type="<?php echo $details->talep_type?>" demirbas_id="<?php echo $details->demirbas_id?>" firma_demirbas_id="<?php echo $details->firma_demirbas_id ?>" class="btn btn-primary add_product" style="margin: 20px;"><i class="fa fa-plus"></i> Tələb etmək üçün xidmət təyin edin</button>
                                                                    </div>


                                                                </div>
                                                            <?php }
                                                            elseif($details->status!=1){

                                                            ?>


                                                            <nav>
                                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                                    <?php
                                                                    $warehouse_status='';
                                                                    if(talep_to_warehouse($details->id)){
                                                                        $warehouse_status='disabled';
                                                                    }
                                                                    $iptal_status=0;
                                                                    $nav_style='';
                                                                    $chevron_stye='';
                                                                    if($details->status==10) // İptal ise
                                                                    {
                                                                        $iptal_status = $details->iptal_status;
                                                                        $nav_style='style="background-color: #eb1539 !important;"';
                                                                        $chevron_stye = 'style="border-left: #eb1539 !important;"';
                                                                    }


                                                                    ?>

                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==1 || $details->status==17){ echo "active"; } ?>"   <?php  if($iptal_status==1) { echo $nav_style; } ?> id="nav-talep" data-toggle="tab" href="#talep" role="tab" aria-controls="nav-home" aria-selected="true">Talep Süreci</a><span class="chevron" <?php  if($iptal_status==1) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==2){ echo "active"; } ?>"   <?php  if($iptal_status==2) { echo $nav_style; } ?> id="nav-techizat" data-toggle="tab" href="#techizat" role="tab" aria-controls="nav-home" aria-selected="true">Cari Seçin</a><span class="chevron" <?php  if($iptal_status==2) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==3){ echo "active"; } ?> "  <?php  if($iptal_status==3) { echo $nav_style; } ?> id="nav-teklif"  <?php  if($details->status >= 3){ echo 'data-toggle="tab"'; } ?>  href="#teklif" role="tab" aria-controls="nav-profile" aria-selected="false">Təklif Süreci</a><span class="chevron" <?php  if($iptal_status==3) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==4){ echo "active"; } ?> "  <?php  if($iptal_status==4) { echo $nav_style; } ?> id="nav-kiyaslama"<?php  if($details->status >= 4){ echo 'data-toggle="tab"'; } ?>  href="#kiyaslama" role="tab" aria-controls="nav-contact" aria-selected="false">Müqayisə Edin</a><span class="chevron" <?php  if($iptal_status==4) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==5){ echo "active"; } ?> "  <?php  if($iptal_status==5) { echo $nav_style; } ?> id="nav-siparis" <?php  if($details->status >= 5){ echo 'data-toggle="tab"'; } ?>  href="#siparis" role="tab" aria-controls="nav-contact" aria-selected="false">Teklif Son Durum</a><span class="chevron" <?php  if($iptal_status==5) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==6){ echo "active"; } ?> "  <?php  if($iptal_status==6) { echo $nav_style; } ?> id="nav-senedler" <?php  if($details->status >= 6){ echo 'data-toggle="tab"'; } ?>  href="#senedler" role="tab" aria-controls="nav-contact" aria-selected="false">Senedler</a><span class="chevron" <?php  if($iptal_status==6) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php  if($details->status==7){ echo "active"; } ?> " id="nav-teslimat" <?php  if($details->status >= 6){ echo 'data-toggle="tab"'; } ?>  <?php  if($iptal_status==7) { echo $nav_style; } ?> href="#teslimat" role="tab" aria-controls="nav-contact" aria-selected="false">Forma2 / İş Görüldü</a><span class="chevron" <?php  if($iptal_status==7) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php echo $warehouse_status; ?> <?php  if($details->status==8){ echo "active"; } ?> "  <?php  if($iptal_status==8) { echo $nav_style; } ?> id="nav-qaime" <?php  if($details->status >= 8){ echo 'data-toggle="tab"'; } ?>  href="#qaime" role="tab" aria-controls="nav-contact" aria-selected="false">Baş Ofis Muhasib</a>
                                                                </div>
                                                            </nav>
                                                            <div class="tab-content px-1 pt-1">
                                                                <div class="tab-pane fade <?php  if($details->status==1 || $details->status==17){ echo "active show"; } ?>" id="talep" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <?php if($items){  //varsa ?>

                                                                        <a href="/hizmet/talep_list_print/<?php echo $details->id; ?>" class="btn btn-warning" title="Talep Listesi">Talep PDF Çıxış</a>

                                                                        <table class="table" id="dt_table_list">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Resim</th>
                                                                                <th>Xidmət</th>
                                                                                <th>Tanım</th>
                                                                                <th>Varyant</th>
                                                                                <th>İnfo</th>
                                                                                <th>Kullanım Yeri</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Temin Tarihi</button></th>
                                                                                <th>Son Alınan Fiyat</th>
                                                                                <th>Talep Fiyatı</th>
                                                                                <th>Aciliyet Durumu</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $i=1;
                                                                            $eq=0;

                                                                            if($details->bildirim_durumu){
                                                                                $disabled='disabled';
                                                                            }
                                                                            foreach ($items as $values) {
                                                                                $html='';

                                                                                $talep_form_product_options_teklif_values=talep_form_product_options_teklif_values($values->id);
                                                                                $p_price = piyasa_fiyati_new($values->product_id,$values->id);

                                                                                $image=product_full_details_parent($values->product_stock_code_id,$values->product_id)['image']
                                                                                ?>
                                                                                <tr  id="remove<?php echo $values->id?>">
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><span class="avatar-lg align-baseline"><img class="image_talep_product"  src="<?php echo base_url().$image ?>"></span></td>
                                                                                    <td><?php echo $values->product_name ?></td>
                                                                                    <td><?php echo $values->product_desc."<br>".move_kontrol($values->id) ?></td>
                                                                                    <td><?php echo talep_form_product_options_new($values->product_stock_code_id) ?></td>
                                                                                    <td><?php echo malzeme_talep_product_kontrol($values->id,$values->product_id,$details->id) ?></td>
                                                                                    <td><?php echo $values->product_kullanim_yeri ?></td>
                                                                                    <td><?php echo $values->product_qty ?></td>
                                                                                    <td><?php echo $values->unit_name ?></td>
                                                                                    <td><?php echo dateformat_new($values->product_temin_date) ?></td>
                                                                                    <td><?php echo amountFormat($p_price).' '.$html ?></td>
                                                                                    <td><?php echo amountFormat(0);?></td>
                                                                                    <td><?php echo progress_status_details($values->progress_status_id)->name;?></td>


                                                                                    <td></td>
                                                                                </tr>
                                                                                <?php $i++; } ?>

                                                                            <?php if(move_product($details->id)) {
                                                                                echo "<tr><td colspan='13' style='text-align: center;font-size: 18px;font-weight: 900;text-decoration: underline;color: red;'>Taşınan Ürünler</td></tr>";
                                                                                $k=0;
                                                                                foreach (move_product($details->id) as $move_product_items){
                                                                                    $k++;
                                                                                    $image=product_full_details_parent($move_product_items->product_stock_code_id,$move_product_items->product_id)['image']

                                                                                    ?>
                                                                                    <tr style="color: #c1c1c1;">
                                                                                        <td><?php echo $k ?></td>
                                                                                        <td><span class="avatar-lg align-baseline"><img class="image_talep_product" src="<?php echo base_url().$image ?>"></span></td>
                                                                                        <td><?php echo product_details_($move_product_items->product_id)->product_name ?></td>
                                                                                        <td><?php echo $move_product_items->product_desc ?></td>
                                                                                        <td><?php echo talep_form_product_options_new($move_product_items->product_stock_code_id) ?></td>
                                                                                        <td><a href="/hizmet/view/<?php echo $move_product_items->form_id;?>" target="_blank" class="btn btn-outline-success">MT Görüntüle</a> </td>
                                                                                        <td><?php echo $move_product_items->product_kullanim_yeri ?></td>
                                                                                        <td><?php echo $move_product_items->product_qty ?></td>
                                                                                        <td><?php echo units_($move_product_items->unit_id)['name'] ?></td>
                                                                                        <td><?php echo dateformat_new($move_product_items->product_temin_date) ?></td>
                                                                                        <td><?php echo amountFormat($p_price).' '.$html ?></td>
                                                                                        <td><?php echo amountFormat(0);?></td>
                                                                                        <td><?php echo progress_status_details($move_product_items->progress_status_id)->name;?></td>


                                                                                        <td></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }

                                                                            }?>



                                                                            </tbody>
                                                                        </table>

                                                                        <?php

                                                                    } ?>

                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==2){ echo "active show"; } ?>" id="techizat" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <?php if(techizat_kontrol($details->id)){

                                                                        echo techizat_kontrol($details->id)['message'];

                                                                    } ?>


                                                                    <div class="col-md-12 pt-4">
                                                                        <table class="table">
                                                                            <thead>
                                                                            <tr>
                                                                                <td>
                                                                                    <input class="form-control all_select" type="checkbox" style="margin-left: 17px;width: 16px;">
                                                                                </td>
                                                                                <?php if($details->talep_type!=3){ ?>
                                                                                <th>Resim</th>
                                                                                <?php } ?>
                                                                                <th>Xidmət Təsviri</th>
                                                                                <?php if($details->talep_type!=3){ ?>
                                                                                <th>Varyant</th>
                                                                                <?php } ?>
                                                                                <th>Seçilmiş Cariler</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Temin Tarihi</th>
                                                                                <th>Talep Fiyatı</th>
                                                                                <th>Aciliyet Durumu</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $i=1; foreach ($items as $values) {
                                                                                if($values->product_type==1){
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <label class="checkbox">
                                                                                                <input type="checkbox" name="materialCheck" item_id="<?php echo $values->id ?>" talep_id="<?php $details->id ?>" class="one_select"><i style="top: 12px;"></i>
                                                                                            </label>

                                                                                        </td>
                                                                                    <?php if($details->talep_type!=3){

                                                                                        $image=product_full_details_parent($values->product_stock_code_id,$values->product_id)['image']
                                                                                        ?>
                                                                                        <td><span class="avatar-lg align-baseline"><img class="image_talep_product" src="<?php echo base_url().'/'.$image ?>"></span></td>

                                                                                    <?php } ?>
                                                                                        <td><?php echo $values->product_name ?></td>
                                                                                        <?php if($details->talep_type!=3){ ?>
                                                                                        <td><?php echo talep_form_product_options_new($values->product_stock_code_id) ?></td>
                                                                                        <?php } ?>
                                                                                        <td>
                                                                                            <?php if(techizat_kontrol_item($values->id)) {
                                                                                                foreach (techizat_kontrol_item($values->id) as $items){
                                                                                                    $cari_id = $items["cari_id"];
                                                                                                    echo "<p style='font-size:10px'>".$items['cari_name']."</p>";
                                                                                                }
                                                                                            } else {
                                                                                                echo "<span class='badge text-danger'>Cari Seçilmemiş</span>";
                                                                                            }?>
                                                                                        </td>
                                                                                        <td><?php echo $values->product_qty ?></td>
                                                                                        <td><?php echo $values->unit_name ?></td>
                                                                                        <td><?php echo $values->product_temin_date ?></td>
                                                                                        <td><?php echo amountFormat(0);?></td>
                                                                                        <td><?php echo progress_status_details($values->progress_status_id)->name;?></td>


                                                                                        <td></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                $i++;
                                                                            }
                                                                            ?>



                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-12 pt-4 pb-2">
                                                                        <button type="button" class="btn btn-info cari_ekle"><i class="fa fa-check"></i>&nbsp;Cari Axtarın</button>
                                                                        <?php if($details->talep_type==1){ ?>
                                                                        <button type="button" class="btn btn-info product_move"><i class="fa fa-check"></i>&nbsp;Seçili Ürünleri Talebe Transfer Et</button>
                                                                    <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <!--                                    --><?php // if($details->status==2) { ?>
                                                                    <!--                                  -->
                                                                    <!--                                    --><?php //} ?>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==3){ echo "active show"; } ?>" id="teklif" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                                    <h3>Təklif Sorğuları Yaradılmağı Gözləyir</h3>
                                                                    <?php if(techizat_kontrol($details->id)) { ?>
                                                                        <div class="col-md-12 pt-4 pb-2">
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input class="form-control all_select_cari" type="checkbox" style="margin-left: 17px;width: 16px;">
                                                                                    </td>
                                                                                    <th>Cari</th>
                                                                                    <th>Materiallar</th>
                                                                                    <th>Varyantlar</th>
                                                                                    <th>Vəziyyət</th>
                                                                                    <th>Yetki</th>
                                                                                    <th>Sil</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach (techizatcilar($details->id) as $items){

                                                                                    $cari_id=$items['cari_id'];
                                                                                    $cari_giris_code='Bulunamadı.Oluşturunuz.';
                                                                                    $cari_giris_pass='Bulunamadı.Oluşturunuz.';
                                                                                    if(customer_info($cari_id)){
                                                                                        $cari_giris_code  =customer_info($cari_id)->phone;
                                                                                        $cari_giris_pass  =customer_info($cari_id)->pass_num;
                                                                                    }
                                                                                    $bilgi = 'Kullanıcı Adı : '.$cari_giris_code.' | Şife :  '.$cari_giris_pass;
                                                                                    ?><tr id="remove_cari<?php echo $cari_id?>">
                                                                                    <td>
                                                                                        <?php if(!teklif_durumlari($details->id,$items['cari_id'])['status']){  ?>
                                                                                            <label class="checkbox">
                                                                                                <input type="checkbox" class="one_select_cari" item_id="<?php echo $items['cari_id'] ?>"><i style="top: 12px;"></i>
                                                                                            </label>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td><a href="/customers/view?id=<?php echo $cari_id?>" target="_blank" data-original-title="Giriş Bilgileri"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $bilgi?>"><?php echo $items['cari_name'];?></a></td>
                                                                                    <td>
                                                                                        <?php foreach ($items['products'] as $prd) {

                                                                                            if($prd->product_type==2){
                                                                                                $product_name = cari_product_details($prd->product_id)->product_name;
                                                                                                echo "<p style='font-size: 10px'>Carinin Teklifi : ".$product_name."</p>";
                                                                                            }
                                                                                            else {
                                                                                                if($details->talep_type==1){
                                                                                                    echo "<p style='font-size: 10px'>".product_name($prd->product_id)."</p>";
                                                                                                }
                                                                                                elseif($details->talep_type==2){
                                                                                                    echo "<p style='font-size: 10px'>".product_name($prd->product_id)."</p>";
                                                                                                }
                                                                                                elseif($details->talep_type==3){
                                                                                                    if($details->id < 3193){
                                                                                                        echo "<p style='font-size: 10px'>".cost_details($prd->product_id)->name."</p>";
                                                                                                    }
                                                                                                    else {
                                                                                                        echo "<p style='font-size: 10px'>".who_demirbas($prd->product_id)->name."</p>";
                                                                                                    }



                                                                                                }

                                                                                            }
                                                                                        }

                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php foreach ($items['products'] as $prd) {

                                                                                            if($prd->product_type==2){
                                                                                                $product_name = cari_product_details($prd->product_id)->product_name;
                                                                                                echo "<p style='font-size: 10px'>Carinin Teklifi : ".$product_name."</p>";

                                                                                            }
                                                                                            else {
                                                                                                echo "<p>".talep_form_product_options_teklif_html($prd->id).'</p>';
                                                                                            }
                                                                                        }

                                                                                        ?>
                                                                                    </td>
                                                                                    <td>

                                                                                        <?php

                                                                                        if($details->talep_type==1){
                                                                                            if(!teklif_durumlari($details->id,$items['cari_id'])['status']){
                                                                                                echo teklif_durumlari($details->id,$items['cari_id'])['text'];
                                                                                            }
                                                                                            else {



                                                                                                foreach (teklif_durumlari($details->id,$items['cari_id'])['data'] as $items_){
                                                                                                    $teklif_id = $items_['teklif_id'];
                                                                                                    if($items_['status_id']==3){
                                                                                                        $cari_id = $items['cari_id'];
                                                                                                        $display='display:none';
                                                                                                        if($ihale_time){

                                                                                                            if($ihale_time->durum==2){
                                                                                                                $display='display:inline';
                                                                                                            }

                                                                                                            echo '<input type="hidden" value="'.$ihale_time->durum.'" class="ihale_durum">';
                                                                                                        }


                                                                                                        if(teklif_update_kontrol($teklif_id)){
                                                                                                            echo '<input type="hidden" value="1" class="teklif_status">';

                                                                                                            echo '<div style="padding-bottom: 15px;">
                                                                <a target="_blank" class="btn btn-sm btn-info teklif_visable" style="'.$display .'" cari_id="'.$cari_id.'" href="/hizmet/teklif_update_view?cari_id='.$cari_id.'&form_id='.$details->id.'"><i class="fa fa-edit"></i></a>
                                                                <a href="/hizmet/teklif_print?cari_id='.$cari_id.'&form_id='.$details->id.'" style="'.$display .'" class="btn btn-sm btn-warning teklif_visable" title="PDF Çıxış"><i class="fa fa-file-pdf"></i></a>
                                                            </div>


                                                                ';
                                                                                                        }
                                                                                                        else {
                                                                                                            echo '<input type="hidden" value="0" class="teklif_status">';
                                                                                                            echo '<div style="padding-bottom: 15px;">
                                                                <a target="_blank" class="btn btn-sm btn-info teklif_visable" cari_id="'.$cari_id.'" style="'.$display .'"  href="/hizmet/teklif_update_view?cari_id='.$cari_id.'&form_id='.$details->id.'"><i class="fa fa-edit"></i></a>
                                                                    <a href="/hizmet/teklif_print?cari_id='.$cari_id.'&form_id='.$details->id.'" class="btn btn-sm btn-warning teklif_visable" style="'.$display .'" title="PDF Çıxış"><i class="fa fa-file-pdf"></i></a>
                                                            </div>


                                                                ';
                                                                                                        }


                                                                                                    }
                                                                                                    echo $items_['status'].$items_['phone'];
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        elseif($details->talep_type==2){
                                                                                            if(!teklif_durumlari($details->id,$items['cari_id'])['status']){
                                                                                                echo teklif_durumlari($details->id,$items['cari_id'])['text'];
                                                                                            }
                                                                                            else {



                                                                                                foreach (teklif_durumlari($details->id,$items['cari_id'])['data'] as $items_){
                                                                                                    $teklif_id = $items_['teklif_id'];
                                                                                                    if($items_['status_id']==3){
                                                                                                        $cari_id = $items['cari_id'];
                                                                                                        $display='display:none';
                                                                                                        if($ihale_time){

                                                                                                            if($ihale_time->durum==2){
                                                                                                                $display='display:inline';
                                                                                                            }

                                                                                                            echo '<input type="hidden" value="'.$ihale_time->durum.'" class="ihale_durum">';
                                                                                                        }


                                                                                                        if(teklif_update_kontrol($teklif_id)){
                                                                                                            echo '<input type="hidden" value="1" class="teklif_status">';

                                                                                                            echo '<div style="padding-bottom: 15px;">
                                                                <a target="_blank" class="btn btn-sm btn-info teklif_visable" style="'.$display .'" cari_id="'.$cari_id.'" href="/hizmet/teklif_update_view?cari_id='.$cari_id.'&form_id='.$details->id.'"><i class="fa fa-edit"></i></a>
                                                                <a href="/hizmet/teklif_print?cari_id='.$cari_id.'&form_id='.$details->id.'" style="'.$display .'" class="btn btn-sm btn-warning teklif_visable" title="PDF Çıxış"><i class="fa fa-file-pdf"></i></a>
                                                            </div>


                                                                ';
                                                                                                        }
                                                                                                        else {
                                                                                                            echo '<input type="hidden" value="0" class="teklif_status">';
                                                                                                            echo '<div style="padding-bottom: 15px;">
                                                                <a target="_blank" class="btn btn-sm btn-info teklif_visable" cari_id="'.$cari_id.'" style="'.$display .'"  href="/hizmet/teklif_update_view?cari_id='.$cari_id.'&form_id='.$details->id.'"><i class="fa fa-edit"></i></a>
                                                                    <a href="/hizmet/teklif_print?cari_id='.$cari_id.'&form_id='.$details->id.'" class="btn btn-sm btn-warning teklif_visable" style="'.$display .'" title="PDF Çıxış"><i class="fa fa-file-pdf"></i></a>
                                                            </div>


                                                                ';
                                                                                                        }


                                                                                                    }
                                                                                                    echo $items_['status'].$items_['phone'];
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        elseif($details->talep_type==3){

                                                                                            $cari_id = $items['cari_id'];

                                                                                            if($ihale_time){
                                                                                                echo '<input type="hidden" value="'.$ihale_time->durum.'" class="ihale_durum">';
                                                                                            }

                                                                                            echo '<input type="hidden" value="1" class="teklif_status">';

                                                                                            echo '<div style="padding-bottom: 15px;">
                                                                <a target="_blank" class="btn btn-sm btn-info"  cari_id="'.$cari_id.'" href="/hizmet/teklif_update_view?cari_id='.$cari_id.'&form_id='.$details->id.'"><i class="fa fa-edit"></i></a>
                                                                <a href="/hizmet/teklif_print?cari_id='.$cari_id.'&form_id='.$details->id.'" class="btn btn-sm btn-warning teklif_visable" title="PDF Çıxış"><i class="fa fa-file-pdf"></i></a>
                                                            </div>


                                                                ';
                                                                                        }


                                                                                        ?></td>
                                                                                    <td>
                                                                                        <button onclick="teklif_ver(<?php echo $items['cari_id'] ?>,<?php  echo $details->id?>)" type="button" class="btn btn-light btn-sm teklif_ver_button"><i class="icon-file-check mr-2"></i> Teklif Ver</button>
                                                                                    </td>
                                                                                    <td><button type="button" class="btn btn-danger form_remove_cari" item_id="<?php echo $cari_id?>" talep_id="<?php echo $details->id?>"><i class="fa fa-trash"></i></button></td>

                                                                                    </tr>
                                                                                    <?php

                                                                                }?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        <?php  if($details->status==3) { ?>
                                                                            <div class="col-md-12 pt-4 pb-2">
                                                                                <button type="button" class="btn btn-info teklif_olustur"><i class="fa fa-check"></i>&nbsp;Teklif Yaradın</button>
                                                                                <?php

//                                                                                if(cari_teklif_kontol($details->id)){
                                                                                if($ihale_time){


                                                                                    if($ihale_time->durum==2){
                                                                                        ?>
                                                                                        <button type="button" class="btn btn-success bildirim_olustur_satinalma"><i class="fa fa-bell"></i>&nbsp;Onaya Sun</button>
                                                                                        <?php
                                                                                    }
//                                                                                }
                                                                                }
                                                                                ?>

                                                                            </div>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==4){ echo "active show"; } ?>" id="kiyaslama" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                                    <div class="col-md-12 pt-4 pb-2">
                                                                        <table class="table">
                                                                            <thead>
                                                                            <tr>
                                                                                <td>#</td>
                                                                                <th>Teklif Veren Carilerin Sayı</th>
                                                                                <th>Materialların Sayı</th>
                                                                                <th>Əməliyyatlar</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td><?php
                                                                                    $company='';
                                                                                    $products='';
                                                                                    foreach (muqayese_details($details->id)['cari'] as $items){
                                                                                        $company.=$items['company'].'</br>';
                                                                                    }

                                                                                    foreach ($data_products as $p_items){

                                                                                        $products.=$p_items->product_name.' <b>'.$p_items->product_qty.' '.$p_items->unit_name.'</b></br>';
                                                                                    }

                                                                                    echo "<button type='button' class='btn btn-secondary cari_view_button' company='".$company."'>".muqayese_details($details->id)['count']."</button></td>";
                                                                                    ?>
                                                                                <td>
                                                                                    <?php echo "<button type='button' class='btn btn-secondary products_view_button' company='".$products."'>".count($data_products)."</button></td>";
                                                                                    ?>
                                                                                </td>
                                                                                <!--td><a href="/hizmet/teklif_incele/<?php echo $details->id?>" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp; İncele</a></td-->
                                                                                <!--                                                    --><?php // if($details->status==4) { ?>
                                                                                <?php
                                                                                $disabled_btn='disabled';
                                                                                if(talep_onay_new_who(2,$details->id,$this->aauth->get_user()->id)){
                                                                                    $disabled_btn='';
                                                                                }?>
                                                                                <td><button  type="button" id="teklif_incele" form_id="<?php echo $details->id?>"  class="btn btn-info"><i class="fa fa-eye"></i>&nbsp; İncele</button></td>
                                                                                <!--                                                    --><?php //} ?>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==5){ echo "active show"; } ?>" id="siparis" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                                    <script>
                                                                        $(document).ready(function (){
                                                                            let count = $('.item_qty').length;
                                                                            for (let i=0; i<count; i++){
                                                                                item_hesap(i)
                                                                            }
                                                                        })

                                                                    </script>
                                                                    <?php   $siparis_list_kontrol = siparis_list_kontrol($details->id);

                                                                    ?>
                                                                    <div class="pb-2">
                                                                        <a href="/hizmet/siparis_print/<?php echo $details->id; ?>" class="btn btn-warning" title="Sifaris PDF Çıxış">Sifariş PDF Çıxış</a>
                                                                    </div>
                                                                    <div class="col-md-12 pt-4 pb-2" style="overflow: auto;">
                                                                        <table class="table">
                                                                            <thead>
                                                                            <tr>
                                                                                <td><?php if(!$siparis_list_kontrol)
                                                                                    {
                                                                                    ?>
                                                                                    <input type="checkbox" class="all_siparis_checkbox" style="margin-left: 19px;"></td>
                                                                                <?php
                                                                                }
                                                                                else {
                                                                                    ?>
                                                                                    <input type="checkbox"  style="visibility: hidden;" checked class="all_siparis_onay_checkbox" style="margin-left: 19px;"></td>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <th>Xidmət TƏSVIRI</th>
                                                                                <th>TEKLIF MIKTARI</th>
                                                                                <th>Yeni TEKLIF MIKTARI</th>
                                                                                <th>Yeni Ölçü Vahidi</th>
                                                                                <th>Açıklama</th>
                                                                                <th>VAHID QIYMƏT</th>
                                                                                <th>Yeni VAHID QIYMƏT</th>
                                                                                <th>ENDIRIM</th>
                                                                                <th>ƏDV ORAN</th>
                                                                                <th>ƏDV</th>
                                                                                <th>EDVSİZ CEMI</th>
                                                                                <th>EDVSİZ ÜMUMI CƏMI</th>
                                                                                <th>NOT</th>
                                                                                <th>Onaylanan Firma</th>
                                                                                <th>Onaylanan Depo</th>
                                                                                <th>Durum</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody style="font-size: 11px;">
                                                                            <?php
                                                                            $yetkili=false;
                                                                            if($siparis_list_kontrol) {

                                                                                $eq=0;
                                                                                $cari_array=[];
                                                                                foreach ($siparis_list_kontrol as $urunler){
                                                                                    $onay_list_id_sorgu=onay_list_id_sorgu($urunler->id)->onay_list_id;
                                                                                    if($urunler->staff_id == $this->aauth->get_user()->id){
                                                                                        $yetkili=true;
                                                                                    }
                                                                                    if($urunler->staf_status==1){
                                                                                        $durum='Genel Müdür Onayında Bekliyor';
                                                                                    }
                                                                                    elseif($urunler->staf_status==2){
                                                                                        $durum='Genel Müdür Onayladı';
                                                                                    }
                                                                                    elseif($urunler->staf_status==3){
                                                                                        $durum='Genel Müdür İptal Etti';
                                                                                    }

                                                                                    $qty=$urunler->teklif_qty;
                                                                                    $unit=units_($urunler->unit_id)['code'];
                                                                                    $cari_name=customer_details($urunler->cari_id)['company'];
                                                                                    $cari_array[]=$urunler->cari_id;
                                                                                    $onaylanan_depo='-';
                                                                                    if($urunler->warehouse_id){
                                                                                        $onaylanan_depo= warehouse_details($urunler->warehouse_id)->title;
                                                                                        $cari_name='-';
                                                                                    }

                                                                                    $new_items =  new_siparis_items($urunler->id);

                                                                                    $discount_type_name =  ($new_items->discount_type == 2) ? '%' : 'float';

                                                                                    $edv_type_=$new_items->new_item_edv_durum;
                                                                                    if($edv_type_){
                                                                                        //dahil
                                                                                        $edv_type='Dahil';
                                                                                    }
                                                                                    else {
                                                                                        $edv_type='Hariç';
                                                                                    }
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <label class="checkbox">
                                                                                                <input style="visibility: hidden;" checked type="checkbox" eq="<?php echo $eq ?>" item_id="<?php echo $urunler->id ?>" class="one_siparis_onay_checkbox"><i style="top: 12px;"></i>
                                                                                            </label>
                                                                                        </td>
                                                                                        <th>
                                                                                            <?php
                                                                                            echo who_demirbas($urunler->product_id)->name;
                                                                                          ?>

                                                                                        <th>
                                                                                            <?php
                                                                                            $style='';
                                                                                            if($urunler->teklif_qty!=$new_items->new_item_qty){
                                                                                                $style ='background: #fd4e4e;color: #fff;';
                                                                                            }

                                                                                            $style_price='';
                                                                                            if($urunler->price!=$new_items->new_item_price){
                                                                                                $style_price ='background: #00b60a;color: #fff;';
                                                                                            }

                                                                                            $style_desc='';
                                                                                            if($new_items->new_item_desc){
                                                                                                $style_desc ='background: #42bcff;color: #fff;';
                                                                                            }
                                                                                            echo "<p>$urunler->teklif_qty $unit</p>";?>
                                                                                        </th>
                                                                                        <th style="<?php echo $style;?>">
                                                                                            <?php echo $new_items->new_item_qty?>
                                                                                        </th>
                                                                                        <th>
                                                                                            <?php echo units_($new_items->new_unit_id)['name']?>
                                                                                        </th>
                                                                                        <th style="<?php echo $style_desc ?>"><?php echo $new_items->new_item_desc ?></th>
                                                                                        <th><?php echo amountFormat($urunler->price,$urunler->para_birimi) ?></th>
                                                                                        <th style="<?php echo $style_price;?>"><?php echo amountFormat($new_items->new_item_price,$urunler->para_birimi)?></th>
                                                                                        <th><?php echo $new_items->new_item_discount.' '.$discount_type_name ?></th>
                                                                                        <th><?php echo $new_items->new_item_kdv.' %'; ?></th>
                                                                                        <th><?php echo $edv_type ?></th>
                                                                                        <th><?php echo amountFormat($new_items->item_umumi_hidden,$urunler->para_birimi) ?></th>
                                                                                        <th><?php echo amountFormat($new_items->item_umumi_cemi_hidden,$urunler->para_birimi) ?></th>
                                                                                        <th><?php echo $urunler->not ?></th>
                                                                                        <th><?php echo $cari_name ?></th>
                                                                                        <th><?php echo $onaylanan_depo ?></th>
                                                                                        <th><?php echo $durum ?></th>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $eq++; }

                                                                            }
                                                                            else{


                                                                            $i=1;
                                                                            $eq=0;
                                                                            $durum='Bekliyor';
                                                                            $cari_array=[];
                                                                            foreach (ihale_onaylanan_urunler($details->id) as $urunler){


                                                                            $qty=0;
                                                                            $onay_list_id=$urunler['id'];
                                                                            $price=0;
                                                                            $discount='-';
                                                                            $edv_oran='-';
                                                                            $edv_type='-';
                                                                            $cemi=0;
                                                                            $umumi_cemi=0;
                                                                            $not='-';
                                                                            $para_birimi=1;
                                                                            $new_desc='';
                                                                            $cari_name='-';
                                                                            $onaylanan_depo='-';
                                                                            $warehouse_id=0;
                                                                            $unit=units_($urunler['unit_id'])['code'];
                                                                            $pid = $urunler['product_id'];

                                                                            if($urunler['product_type']==1){
                                                                                $pid = $urunler['product_id'];
                                                                            }
                                                                            else {
                                                                                $pid = $urunler['new_product_id'];
                                                                            }
                                                                            if($urunler['type']==1){ //firmadır

                                                                                $talep_form_teklifler_item_details= talep_form_teklifler_item_details($urunler['talep_form_teklifler_item_details_id']);
                                                                                $details_id = $talep_form_teklifler_item_details->details_id; //5
                                                                                $talep_form_teklifler_item = talep_form_teklifler_item($details_id);
                                                                                $teklif_id = $talep_form_teklifler_item->tf_teklif_id; //9
                                                                                $talep_form_teklifler = talep_form_teklifler($teklif_id);
                                                                                $cari_id = $talep_form_teklifler->cari_id;
                                                                                $cari_array[]=isset($talep_form_teklifler->cari_id)?$talep_form_teklifler->cari_id:0;
                                                                                $para_birimi = isset($talep_form_teklifler->para_birimi)?$talep_form_teklifler->para_birimi:1;
                                                                                $cari_name=customer_details($cari_id)['company'];
                                                                                $qty=$talep_form_teklifler_item_details->qty;
                                                                                $price=$talep_form_teklifler_item_details->price;
                                                                                $discount=$talep_form_teklifler_item_details->discount;
                                                                                $edv_oran=$talep_form_teklifler_item_details->edv_oran;
                                                                                $edv_type_=$talep_form_teklifler_item_details->edv_type;
                                                                                $cemi=$talep_form_teklifler_item_details->sub_total;
                                                                                $umumi_cemi=$talep_form_teklifler_item_details->total;
                                                                                $not=$talep_form_teklifler_item_details->item_desc;
                                                                                $kdv_total = $talep_form_teklifler_item_details->kdv_total;
                                                                                $discount_type = $talep_form_teklifler_item_details->discount_type;
                                                                                $discount_total = $talep_form_teklifler_item_details->discount_total;
                                                                                $unit_name = units_($urunler['unit_id'])['name'];
                                                                                if($edv_type_){
                                                                                    //dahil
                                                                                    $edv_type='Dahil';
                                                                                }
                                                                                else {
                                                                                    $edv_type='Hariç';
                                                                                }

                                                                                $discount_type_name =  ($discount_type == 2) ? '%' : 'float';

                                                                                $qty = $talep_form_teklifler_item_details->qty;
                                                                                $edv_type_text = $talep_form_teklifler_item_details->edv_type;
                                                                                $tax_oran_text = $talep_form_teklifler_item_details->edv_oran;
                                                                                $text_Desc=$talep_form_teklifler_item_details->item_desc;
                                                                            }
                                                                            else {
                                                                                $cemi=0;
                                                                                $discount_type_name='-';
                                                                                $discount=0;
                                                                                $discount_total=0;
                                                                                $kdv_total =0;
                                                                                $discount_type = 0;
                                                                                $para_birimi = 1;
                                                                                $price=0;
                                                                                $umumi_cemi=0;
                                                                                $warehouse_id = $urunler['warehouse_id'];
                                                                                $details_ = warehouse_details($warehouse_id);
                                                                                $onaylanan_depo=$details_->title;
                                                                                $qty=$urunler['qty'];
                                                                                $unit_name = units_($urunler['unit_id'])['name'];
                                                                                $edv_type_text=0;
                                                                                $tax_oran_text=0;
                                                                                $text_Desc='';
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"
                                                                                               product_id="<?php echo $pid ?>"
                                                                                               talep_form_product_id="<?php echo $urunler['talep_form_product_id'] ?>"
                                                                                               talep_id="<?php echo $details->id ?>"
                                                                                               teklif_qty="<?php echo $qty ?>"
                                                                                               unit_id="<?php echo $urunler['unit_id'] ?>"
                                                                                               price="<?php echo $price ?>"
                                                                                               discount="<?php echo $discount ?>"
                                                                                               edv_oran="<?php echo $edv_oran ?>"
                                                                                               edv_type="<?php echo $edv_type ?>"
                                                                                               cemi="<?php echo $cemi ?>"
                                                                                               umumi_cemi="<?php echo $umumi_cemi ?>"
                                                                                               not="<?php echo $not ?>"
                                                                                               para_birimi="<?php echo $para_birimi ?>"
                                                                                               cari_id="<?php echo $cari_id ?>"
                                                                                               warehouse_id="<?php echo $warehouse_id ?>"
                                                                                               onay_list_id="<?php echo $onay_list_id ?>"
                                                                                               eq="<?php echo $eq ?>"

                                                                                               class="one_siparis_checkbox"><i style="top: 12px;"></i>
                                                                                    </label>
                                                                                </td>
                                                                                <th>
                                                                                    <?php
                                                                                    echo who_demirbas($pid)->name;
                                                                                    ?>


                                                                                </th>
                                                                                <td><?php echo $qty.' '.$unit_name ?></td>
                                                                                <td><?php echo "<input style='width: 125px;' type='number' eq='$eq'  value='$qty' class='form-control new_item_qty'>" ?></td>
                                                                                <td><select style='width: 125px;'  eq='<?php echo $eq ?>'  class="form-control select-box new_unit_id">
                                                                                        <?php foreach (units() as $unit_items){
                                                                                            $selected='';
                                                                                            $id_=$unit_items['id'];
                                                                                            $name=$unit_items['name'];
                                                                                            if($id_==$urunler['unit_id']){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            echo "<option $selected value='$id_'>$name</option>";
                                                                                        }?>
                                                                                    </select>
                                                                                </td>
                                                                                <td><?php echo "<input style='width: 125px;' type='text' eq='$eq'  class='form-control new_item_desc'>" ?></td>
                                                                                <td><?php echo amountFormat($price,$para_birimi) ?></td>
                                                                                <td><?php echo "<input type='number' eq='$eq' value='$price'  class='form-control new_item_price'>" ?></td>
                                                                                <td><?php echo "<div class='input-group ' style='width: 125px;'><input style='width: 66px;' type='number' eq='$eq' value='$discount'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type"><?php echo $discount_type_name; ?></span></div></td>
                                                                    <td><?php echo "<div class='input-group ' style='width: 125px;'><input style='width: 66px;' type='number' eq='$eq' value='$tax_oran_text'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                                                <td><select class="form-control item_edv_durum" style='width: 125px;'><option  eq='<?php echo $eq; ?>' <?php echo ($edv_type_text)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$edv_type_text)?'selected':''; ?>  value="0">Haric</option></select></td>

                                                                <td><input style='width: 125px;' value="<?php echo $cemi ?>" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                                                <td><input style='width: 125px;' value="<?php echo $umumi_cemi ?>" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                                                                <td><?php echo $text_Desc;?></td>
                                                                <input type="hidden" class="item_edvsiz_hidden" value="<?php echo $cemi ?>">
                                                                <input type="hidden" class="edv_tutari_hidden" value="<?php echo $kdv_total ?>">
                                                                <input type="hidden" class="discount_type" eq="<?php echo $eq ?>" value="<?php echo $discount_type ?>">
                                                                <input type="hidden" class="para_birimi" eq="<?php echo $eq ?>" value="<?php echo $para_birimi ?>">
                                                                <input type="hidden" class="item_umumi_hidden" value="<?php echo $cemi ?>">
                                                                <input type="hidden" class="item_umumi_cemi_hidden" value="<?php echo $umumi_cemi ?>">
                                                                <input type="hidden" class="item_discount_hidden" value="<?php echo $discount_total ?>">

                                                                <th><?php echo $cari_name ?></th>
                                                                <th><?php echo $onaylanan_depo ?></th>
                                                                <th><?php echo $durum ?></th>
                                                                </tr>

                                                                <?php
                                                                $i++;
                                                                $eq++;

                                                                }
                                                                }

                                                                ?>
                                                                </tbody>
                                                                </table>


                                                            </div>


                                                            <?php  if($details->status==5) { ?>
                                                                <div class="col-md-12 pt-4 pb-2">
                                                                    <?php   if(!$siparis_list_kontrol){ ?>
                                                                        <button class="btn btn-success siparis_onay"><i class="fa fa-check"></i> Son Halini Onaya Sun</button>
                                                                    <?php }
                                                                    else {
                                                                        if($yetkili){
                                                                            ?>

                                                                            <button tip="1" class="btn btn-success siparis_onay_iptal_finish"><i class="fa fa-check"></i> Son Halini Onayla</button>
<!--                                                                            <button tip="2" class="btn btn-warning siparis_onay_iptal_finish"><i class="fa fa-pen"></i> Düzeliş İste</button>-->
<!--                                                                            <button tip="0" class="btn btn-danger siparis_onay_iptal_finish"><i class="fa fa-ban"></i> Satınalmayı Durdur Formu İptal Et</button>-->
                                                                            <?php
                                                                        }

                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>

                                                        <div class="tab-pane fade <?php  if($details->status==6){ echo "active show"; } ?>" id="senedler" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                            <div class="col-md-12 pt-4 pb-2">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="all_sened_cari_list" style="margin-left: 19px;"></td>
                                                                        <th>Cari Adı</th>
                                                                        <th>Muqavele</th>
                                                                        <th>Seçili Olanı Görüntüle</th>
                                                                        <th>Razılaştırma Protokolü</th>
                                                                        <th>Seçili Olanı Görüntüle</th>
                                                                        <!--                                                                    <th>Tehvil Teslim Aktı</th>-->
                                                                        <!--                                                                    <th>Seçili Olanı Görüntüle</th>-->
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php if(onaylanan_firma_list($details->id)){
                                                                        $i=0;
                                                                        foreach (onaylanan_firma_list($details->id) as $cari_list){
                                                                            ?>
                                                                            <tr>
                                                                                <td><label class="checkbox">
                                                                                        <input type="checkbox" cari_id="<?php echo $cari_list->cari_id ?>" eq="<?php echo $i;?>" item_id="<?php echo $cari_list->id ?>" class="one_sened_cari_list"><i style="top: 12px;"></i>
                                                                                    </label>
                                                                                </td>
                                                                                <td><?php echo customer_details($cari_list->cari_id)['company']?></td>
                                                                                <td>
                                                                                    <select class="form-control select-box muqavele">
                                                                                        <option value="0">Seçiniz</option>
                                                                                        <?php foreach (customer_files($cari_list->cari_id,2) as $items){
                                                                                            $selected='';
                                                                                            $senedler = senedler($cari_list->cari_id,$details->id);
                                                                                            if($senedler){
                                                                                                if($senedler->muqavele){
                                                                                                    if($senedler->muqavele==$items->id){
                                                                                                        $selected='selected';
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            echo "<option $selected file_name='$items->filename'  value='$items->id'>$items->title</option>";
                                                                                        }?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <button eq="<?php echo $i ?>" type="button" class="btn btn-success muqaleve_view"><i class="fa fa-file"></i></button>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-control select-box razilastirma">
                                                                                        <option value="0">Seçiniz</option>
                                                                                        <?php foreach (customer_files($cari_list->cari_id,1) as $items){
                                                                                            $selected='';
                                                                                            $senedler = senedler($cari_list->cari_id,$details->id);
                                                                                            if($senedler){
                                                                                                if($senedler->razilastirma){
                                                                                                    if($senedler->razilastirma==$items->id){
                                                                                                        $selected='selected';
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            echo "<option $selected  file_name='$items->filename'  value='$items->id'>$items->title</option>";
                                                                                        }?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <button eq="<?php echo $i ?>"  type="button" class="btn btn-success razilastirma_view"><i class="fa fa-file"></i></button>
                                                                                </td>
                                                                                <!--                                                                            <td>-->
                                                                                <!--                                                                                <select class="form-control select-box tehvil_teslim">-->
                                                                                <!--                                                                                    <option value="0">Seçiniz</option>-->
                                                                                <!--                                                                                    --><?php //foreach (customer_files($cari_list->cari_id,3) as $items){
                                                                                //                                                                                        $selected='';
                                                                                //                                                                                        $senedler = senedler($cari_list->cari_id,$details->id);
                                                                                //                                                                                        if($senedler){
                                                                                //                                                                                            if($senedler->tehvil_teslim){
                                                                                //                                                                                                if($senedler->tehvil_teslim==$items->id){
                                                                                //                                                                                                    $selected='selected';
                                                                                //                                                                                                }
                                                                                //                                                                                            }
                                                                                //                                                                                        }
                                                                                //                                                                                        echo "<option $selected file_name='$items->filename' value='$items->id'>$items->title</option>";
                                                                                //                                                                                    }?>
                                                                                <!--                                                                                </select>-->
                                                                                <!--                                                                            </td>-->
                                                                                <!--                                                                            <td>-->
                                                                                <!--                                                                                <button eq="--><?php //echo $i ?><!--"  type="button" class="btn btn-success tehvil_view"><i class="fa fa-file"></i></button>-->
                                                                                <!--                                                                            </td>-->
                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
<!--                                                            --><?php // if($details->status==6) { ?>
                                                                <div class="col-md-12 pt-4 pb-2">
                                                                    <button class="btn btn-success sened_update"><i class="fa fa-check"></i> Senedleri Güncelle</button>
                                                                    <button class="btn btn-success anbar_asama"><i class="fa fa-check"></i> Forma2  Aşamasına Geçiş Yap</button>
                                                                </div>
<!--                                                            --><?php //} ?>

                                                        </div>

                                                        <div class="tab-pane fade <?php  if($details->status==7){ echo "active show"; } ?>" id="teslimat" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">


                                                            <div class="pb-2">
                                                                <button id="tehvil_print" class="btn btn-outline-warning" title="Tehvil PDF Çıxış">Seçili Olanları PDF Çıxış</button>
                                                            </div>
                                                            <div class="col-md-12 pt-4 pb-2">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="all_tehvil_products" style="margin-left: 19px;"></td>
                                                                        <th>Resim</th>
                                                                        <th>Xidmət Adı</th>
                                                                        <th>Firma</th>
                                                                        <th>Sipariş Miktarı</th>
                                                                        <th>Kalan Miktar</th>
                                                                        <th>İş Görülen Miktar</th>
                                                                        <th>İşin Görüleceği Miktar</th>
                                                                        <th>İşlem</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php

                                                                    $eq=0;

                                                                    if(tehvil_products($details->id)){
                                                                        foreach (tehvil_products($details->id) as $product_items){


                                                                            $cari_id=$product_items->cari_id;
                                                                            $talep_form_product_id=$product_items->talep_form_product_id;
                                                                            $form_id=$product_items->form_id;
                                                                            $image=product_full_details_parent($product_items->product_stock_code_id,$product_items->product_id)['image'];
                                                                            $teslim_alinmis = hizmet_teslim_alinmis($details->id,$product_items->product_id,$talep_form_product_id)['alinan_miktar'];
                                                                            $forma_2_html = hizmet_teslim_alinmis($details->id,$product_items->product_id,$talep_form_product_id)['forma2_bilgisi'];

                                                                            $kalan_miktar = floatval($product_items->qty)-floatval($teslim_alinmis);
                                                                            ?>
                                                                            <tr>
                                                                                <td><label class="checkbox">
                                                                                        <input type="checkbox"  class="one_tehvil_products" eq="<?php echo $eq ?>"
                                                                                               teslimat_warehouse_id="<?php echo $product_items->id ?>"
                                                                                               product_id="<?php echo $product_items->product_id?>"
                                                                                               cari_id="<?php echo $cari_id?>"
                                                                                               talep_form_product_id="<?php echo $talep_form_product_id?>"
                                                                                               form_id="<?php echo $form_id?>"

                                                                                        ><i style="top: 12px;"></i>
                                                                                    </label>
                                                                                </td>
                                                                                <td width="100px"><img src="<?php echo site_url().$image ?>" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>
                                                                                <td><?php

                                                                                    echo who_demirbas($product_items->product_id)->name;

                                                                                    ?><span><?php echo talep_form_product_options_new($product_items->product_stock_code_id) ?>
</span></td>
                                                                                <?php
//                                                                                $pr
//                                                                                $image=product_full_details_parent($product_items->product_stock_code_id,$product_items->product_id)['image']

                                                                                ?>

                                                                                <td><?php echo customer_details($product_items->cari_id)['company'] ?></td>
                                                                                <td><?php echo $product_items->qty .' '.units_($product_items->unit_id)['name']?></td>
                                                                                <td><?php echo $kalan_miktar.' '.units_($product_items->unit_id)['name']?></td>
                                                                                <td><?php echo $teslim_alinmis.' '.units_($product_items->unit_id)['name']?></td>
                                                                                <td><input type="number" value="<?php echo $kalan_miktar?>" class="form-control warehouse_item_qty" max="<?php echo $kalan_miktar ?>" onkeyup="amount_max(this)">
                                                                                    <input type="hidden" class="form-control warehouse_item_notes">
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $forma_2_html ?>
                                                                                </td>

                                                                            </tr>
                                                                            <?php
                                                                            $eq++;
                                                                        }
                                                                        if(warehouse_teslimat_transfer($details->id)){
                                                                            foreach (warehouse_teslimat_transfer($details->id) as $product_items) {
                                                                                $stokc_fis_id = $product_items->stock_fis_id;
                                                                                $stock_code='Stok Transfer Fişi Oluştutulmamış';
                                                                                if($stokc_fis_id){
                                                                                    $stock_fis_details = stock_fis_details($stokc_fis_id);
                                                                                    $stock_code = 'Stok Transfer Fişi - '.$stock_fis_details->code;
                                                                                }

                                                                                ?>
                                                                                <tr>
                                                                                    <td>#</td>
                                                                                    <td><?php
                                                                                        echo who_demirbas($product_items->product_id)->name;
                                                                                        ?></td>
                                                                                    <td><?php echo warehouse_details($product_items->warehouse_id)->title ?></td>
                                                                                    <td><?php echo $product_items->qty .' '.units_($product_items->unit_id)['name']?></td>
                                                                                    <td><?php echo "-"; ?></td>
                                                                                    <td><?php echo "-"; ?></td>
                                                                                    <td><?php echo $stock_code;?></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            <?php }
                                                                        }
                                                                    }

                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-12 pt-4 pb-2">
                                                                <button class="btn btn-outline-success tehvil_al"><i class="fa fa-check"></i> Forma2 Oluştur</button>
                                                                <button class="btn btn-outline-secondary qaime_asamasine_gec" ><i class="fa fa-check"></i> Qaime Aşamasına Geç</button>
                                                                <?php
                                                                if($this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==39)
                                                                {
                                                                    ?>
                                                                    <button class="btn btn-success product_duzenle"><i class="fa fa-check"></i> Düzenle</button>

                                                                    <?php
                                                                } ?>

                                                            </div>

                                                        </div>
                                                        <div class="tab-pane fade <?php  if($details->status==8){ echo "active show"; } ?>" id="qaime" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                            <div class="col-md-12 pt-4 pb-2">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="all_qaime_products" style="margin-left: 19px;"></td>
                                                                        <th>Xidmət Adı</th>
                                                                        <th>Firma</th>
                                                                        <th>Sipariş Miktarı</th>
                                                                        <th>İş Görüldü Miktar</th>
                                                                        <th>Qaimesi Oluşmamış Miktar</th>
                                                                        <th>Ödeme Metodu</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php

                                                                    $eq=0;
                                                                    $invoice_details = invoice_talep_details($details->id);
                                                                    $item_array=[];
                                                                    if($invoice_details){
                                                                        foreach ($invoice_details as $items_invoices){
                                                                            $item_array[]=$items_invoices->item_id;
                                                                        }
                                                                    }
                                                                    if(tehvil_products($details->id)){
                                                                        foreach (tehvil_products($details->id) as $product_items){
                                                                           $method_id=talep_form_method_cari($details->id,$product_items->cari_id);

                                                                            $talep_form_product_id=$product_items->talep_form_product_id;


                                                                            $teslim_alinmis = hizmet_teslim_alinmis($details->id,$product_items->product_id,$talep_form_product_id)['alinan_miktar'];
                                                                            $kalan_miktar = tehvil_kalan_miktar($product_items->id);
                                                                            if($teslim_alinmis){
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <!--                                                                                --><?php //  if(!in_array($tehvil_products_cari_product,$item_array)) { ?>
                                                                                        <label class="checkbox">
                                                                                            <input type="checkbox" method_id="<?php echo $method_id?>" id_val="<?php echo $product_items->id?>" talep_form_product_id="<?php echo $product_items->talep_form_product_id?>"  class="one_qaime_products" teslim_product_id="<?php echo $product_items->product_id ?>" teslim_firma_id="<?php echo $product_items->cari_id ?>" teslim_qty="<?php echo $teslim_alinmis; ?>"  eq="<?php echo $eq ?>" teslimat_warehouse_id="<?php echo $product_items->id ?>" ><i style="top: 12px;"></i>
                                                                                        </label>
                                                                                        <!--                                                                                --><?php //} ?>
                                                                                    </td>
                                                                                    <td><?php

                                                                                        echo who_demirbas($product_items->product_id)->name;


                                                                                        $qaime_qty = hizmet_qaime_qty($details->id,$product_items->talep_form_product_id,$product_items->product_id)['qaime_qty'];
                                                                                        $kalan = floatval($teslim_alinmis)-floatval($qaime_qty);

                                                                                        ?></td>
                                                                                    <td><?php echo customer_details($product_items->cari_id)['company'] ?></td>
                                                                                    <td><?php echo amountFormat_s($product_items->qty) .' '.units_($product_items->unit_id)['name']?></td>
                                                                                    <td><?php echo amountFormat_s($teslim_alinmis).' '.units_($product_items->unit_id)['name']?></td>
                                                                                    <td><?php echo amountFormat_s($kalan).' '.units_($product_items->unit_id)['name']?></td>
                                                                                    <td>
                                                                                        <?php echo account_type_sorgu($method_id) ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                                $eq++;
                                                                            }






                                                                            //$tehvil_products_cari_product=tehvil_products_cari_product($details->id,$product_items->cari_id,$product_items->product_id)->id;



                                                                        }
                                                                    }


                                                                    ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <?php  if($details->status==8) { ?>
                                                                <div class="col-md-12 pt-4 pb-2">
                                                                    <button class="btn btn-success qaime_create"><i class="fa fa-check"></i> Qaime Oluştur</button>
                                                                    <button class="btn btn-info confirm_asama_update"><i class="fa fa-file"></i> Talebi Tamamla</button>

                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col col-md-6 col-xs-12">
                                                <div class="jarviswidget">
                                                    <header> <h4>Sorğu ilə Əlaqəli Fayllar</h4></header>
                                                    <div class="borderedccc no-padding">
                                                        <?php if($file_details){
                                                            foreach ($file_details as $file_items){
                                                                ?>
                                                                <ul class="list-inline">
                                                                    <li id="systemfile_2" class="col-sm-12 margin-bottom-5">
                                                                        <div class="well welldocument">
                                                                            <label><b><?php echo $file_items->image_text?></b></label>
                                                                            <div class="">
                                                                                <div class="font-xs">Yüklenme Tarihi: <?php echo dateformat_new($file_items->created_at)?></div>
                                                                                <div class="font-xs">Yükleyen: <?php echo personel_details($file_items->user_id)?></div>
                                                                            </div>
                                                                            <div class="text-center">
                                                                                <div class="btn-group">
                                                                                    <a class="btn btn-success" download href="<?php echo base_url() . 'userfiles/product/'.$file_items->image_text ?>"  >
                                                                                        <i class="fa fa-download"></i>
                                                                                    </a>
                                                                                    <button class="btn btn-danger delete_file" file_id="<?php echo $file_items->id?>">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <div style="clear:both"></div>
                                                                        </div>
                                                                    </li>

                                                                </ul>
                                                            <?php }
                                                        } ?>
                                                        <hr>
                                                        <ul class="list-inline">
                                                            <li id="systemfile_2" class="margin-bottom-5">
                                                                <div class="well welldocument">
                                                                    <button class="btn btn-success new_file">Yeni Dosya Ekle</button>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h2 class="text-bold-700" style="text-align: center;text-decoration: underline;font-family: monospace;">Talep İle İlgili Borçlandırmalar</h2>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <td>Oluşturan Personel</td>
                                                                <td>Tutar</td>
                                                                <td>Açıklama</td>
                                                                <td>Tip</td>
                                                                <td>İşlem Yapılan Şahıs</td>
                                                                <td>Tarih</td>
                                                                <td>Durum</td>
                                                                <td>İşlem</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(talep_borclandirma($details->id,1)){
                                                                foreach (talep_borclandirma($details->id,1) as $b_items){
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $b_items['personel'] ?></td>
                                                                        <td><?php echo $b_items['tutar'] ?></td>
                                                                        <td><?php echo $b_items['desc'] ?></td>
                                                                        <td><?php echo $b_items['tip'] ?></td>
                                                                        <td><?php echo $b_items['cari_pers'] ?></td>
                                                                        <td><?php echo $b_items['created_at'] ?></td>
                                                                        <td><?php echo $b_items['durum'] ?></td>
                                                                        <td><button class="btn btn-outline-danger borclandirma_sil" b_id="<?php echo $b_items['id']?>"><i class="fa fa-ban"></i></button></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <?php
                                            if($details->status!=17){
                                                if($details->bildirim_durumu==0){
                                                    if($details->status!=10){
                                                        ?>

                                                        <div class="col col-md-6 col-xs-12">
                                                            <div class="jarviswidget">
                                                                <header> <h4>Məlumat Sorğunun</h4></header>
                                                                <div class="borderedccc">
                                                                    <div class="widget-body">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group row">
                                                                                <div class="col-md-4 mb-2">
                                                                                    <label class="col-form-label">Proje</label>
                                                                                    <select class="form-control select-box" id="proje_id">
                                                                                        <?php foreach (all_projects() as $emp){
                                                                                            $emp_id=$emp->id;
                                                                                            $name=$emp->code;
                                                                                            $selected='';
                                                                                            if($details->proje_id==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            ?>
                                                                                            <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-2 mb-2">
                                                                                    <label class="col-form-label">Proje Bölümü</label>
                                                                                    <select class="form-control select-box" id="bolum_id">
                                                                                        <?php foreach (all_bolum_proje($details->proje_id) as $emp){
                                                                                            $emp_id=$emp->id;
                                                                                            $name=$emp->name;
                                                                                            $selected='';
                                                                                            if($details->bolum_id==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            ?>
                                                                                            <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-2 mb-2">
                                                                                    <label class="col-form-label">Proje Aşaması</label>
                                                                                    <select class="form-control select-box" id="asama_id">
                                                                                        <?php foreach (all_bolum_to_asama($details->bolum_id) as $emp){
                                                                                            $emp_id=$emp->id;
                                                                                            $name=$emp->name;
                                                                                            $selected='';
                                                                                            if($details->bolum_id==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            ?>
                                                                                            <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-2 mb-2">
                                                                                    <label class="col-form-label">Talep Eden</label>
                                                                                    <select class="form-control select-box" id="talep_eden_user_id">
                                                                                        <?php foreach (all_personel() as $emp){
                                                                                            $emp_id=$emp->id;
                                                                                            $name=$emp->name;
                                                                                            $selected='';
                                                                                            if($details->talep_eden_user_id==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            ?>
                                                                                            <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md-2 mb-2">
                                                                                    <label class="col-form-label">Təcili</label>
                                                                                    <select class="form-control select-box" id="progress_status_id">
                                                                                        <?php foreach (progress_status() as $emp){
                                                                                            $emp_id=$emp->id;
                                                                                            $name=$emp->name;
                                                                                            $selected='';
                                                                                            if($details->progress_status_id==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            ?>
                                                                                            <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-12">
                                                                            <div class="form-group row">
                                                                                <div class="col-md-4 mb-2">
                                                                                    <label class="col-form-label">Talep Tipi</label>
                                                                                    <select class="form-control select-box" id="talep_type">
                                                                                        <?php foreach (talep_type() as $emp){
                                                                                            $emp_id=$emp->id;
                                                                                            $name=$emp->name;
                                                                                            $selected='';
                                                                                            if($details->talep_type==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                            ?>
                                                                                            <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-2 mb-2">
                                                                                    <label class="col-form-label">Transfer Durumu</label>
                                                                                    <select class="form-control select-box" id="transfer_status">
                                                                                        <?php
                                                                                        if($details->transfer_status==0){
                                                                                            ?>
                                                                                            <option  selected value="0">Transfersiz</option>
                                                                                            <option value="1">Transferli</option>
                                                                                            <?php
                                                                                        }
                                                                                        else {
                                                                                            ?>
                                                                                            <option value="0">Transfersiz</option>
                                                                                            <option selected value="1">Transferli</option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-2 mb-2">
                                                                                    <label class="col-form-label">Gider Durumu</label>
                                                                                    <select class="form-control select-box" id="gider_durumu">
                                                                                        <?php
                                                                                        if($details->gider_durumu==0){
                                                                                            ?>
                                                                                            <option  selected value="0">Gidere İşlenmesin</option>
                                                                                            <option value="1">Gidere İşlensin</option>
                                                                                            <?php
                                                                                        }
                                                                                        else {
                                                                                            ?>
                                                                                            <option value="0">Gidere İşlenmesin</option>
                                                                                            <option selected value="1">Gidere İşlensin</option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-4 mb-2">
                                                                                    <label class="col-form-label">İstək Təsviri / Qeyd</label>
                                                                                    <textarea class="form-control" id="desc"><?php echo $details->desc?></textarea>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group row">
                                                                                <div class="col-md-12 mb-2">
                                                                                    <button class="btn btn-success form_update">Güncelle</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } }
                                            }
                                            else {
                                                ?>
                                                <div class="col col-md-6 col-xs-12">
                                                    <div class="jarviswidget">
                                                        <header> <h4>Təsdiqləmə qaydaları</h4></header>
                                                        <p style="text-align: center">TƏSDIQLƏMƏ SIRASI</p>
                                                        <table class="table">
                                                            <?php
                                                            $button_dikkat='';
                                                            if($note_list){
                                                                $button_dikkat="<i class='fas fa-exclamation-triangle button_view_notes' onmouseover='details_notes()' style='
                                                                padding: 0px;
                                                                margin-left: 11px;
                                                                color: red;
                                                                font-size: 34px;
                                                                position: relative;
                                                                top: 7px;
                                                                animation-name: flash;
                                                                -webkit-animation-duration: 2s;
                                                                -webkit-animation-timing-function: linear;
                                                                -webkit-animation-iteration-count: infinite;
'></i>";
                                                            }

                                                            foreach (talep_onay_new(3,$details->id) as $items) {
                                                                $durum='-';
                                                                $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                if($items->status==1){
                                                                    $durum='Onaylandı';
                                                                    $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                }
                                                                if($items->staff==1 && $items->status==0){
                                                                    $durum='Gözləmedə';
                                                                    $button='<button   class="btn btn-info onayla_stok_kontrol" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <!--?php echo roles(role_id($items->user_id))?-->
                                                                    <th>(Stok Kontrol Onayı)</th>
                                                                    <th><?php echo personel_details($items->user_id)?></th>
                                                                    <th><?php echo $durum;?></th>
                                                                    <th><?php echo $button;?></th>
                                                                </tr>
                                                                <?php
                                                            } ?>
                                                        </table>
                                                    </div>
                                                </div>

                                                <?php
                                            }

                                            ?>

                                            <?php if($items){  //varsa ?>
                                                <?php if($details->bildirim_durumu==1){ ?>
                                                    <div class="col col-md-6 col-xs-12">
                                                        <div class="jarviswidget">
                                                            <header> <h4>Təsdiqləmə qaydaları</h4></header>
                                                            <p style="text-align: center">TƏSDIQLƏMƏ SIRASI</p>
                                                            <table class="table">
                                                                <?php
                                                                $button_dikkat='';
                                                                if($note_list){
                                                                    $button_dikkat="<i class='fas fa-exclamation-triangle button_view_notes' onmouseover='details_notes()' style='

                                                                    padding: 0px;
                                                                    margin-left: 11px;
                                                                    color: red;
                                                                    font-size: 34px;
                                                                    position: relative;
                                                                    top: 7px;
                                                                    animation-name: flash;
                                                                    -webkit-animation-duration: 2s;
                                                                    -webkit-animation-timing-function: linear;
                                                                    -webkit-animation-iteration-count: infinite;
                                                                
                                                                '></i>";
                                                                }

                                                                if(!talep_onay_new(2,$details->id)){
                                                                    if(talep_onay_new(1,$details->id)){
                                                                        foreach (talep_onay_new(1,$details->id) as $items) {
                                                                            $durum='-';
                                                                            $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                            if($items->status==1){
                                                                                $durum='Onaylandı';
                                                                                $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                            }
                                                                            if($items->staff==1 && $items->status==0){
                                                                                $durum='Gözləmedə';
                                                                                $button='<button sort="'.$items->sort.'" class="btn btn-info onayla" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <!--?php echo roles(role_id($items->user_id))?-->
                                                                                <th>(Xidmət Tlp. Onayı)</th>
                                                                                <th><?php echo personel_details($items->user_id)?></th>
                                                                                <th><?php echo $durum;?></th>
                                                                                <th><?php echo $button;?></th>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }

                                                                }

                                                                if(talep_onay_new(2,$details->id)){
                                                                    foreach (talep_onay_new(2,$details->id) as $items) {
                                                                        $durum='-';
                                                                        $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                        if($items->status==1){
                                                                            $durum='Onaylandı';
                                                                            $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                        }
                                                                        if($items->staff==1 && $items->status==0){
                                                                            $durum='Gözləmedə';
                                                                            $button='<button  disabled class="btn btn-info" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Detayları İnceleyin</button>'.$button_dikkat;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <!--?php echo roles(role_id($items->user_id))?-->
                                                                            <th> (İhale Onayı)</th>
                                                                            <th><?php echo personel_details($items->user_id)?></th>
                                                                            <th><?php echo $durum;?></th>
                                                                            <th><?php echo $button;?></th>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php } ?>


                                                <div class="col col-md-12 col-xs-12" style="
    margin-top: 30px;
">
                                                    <div class="jarviswidget">
                                                        <header> <h4>Talep Hareketleri</h4></header>
                                                        <table class="table" id="mt_talep_history" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Personel Adı</th>
                                                                <th>Açıklama</th>
                                                                <th>İşlem Tarihi</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>

                                                        <!--                                                        --><?php //if(talep_history($details->id)){
                                                        //                                                            ?>
                                                        <!--                                                            <table class="table">-->
                                                        <!--                                                                <thead>-->
                                                        <!--                                                                <tr>-->
                                                        <!--                                                                    <th>Vazife</th>-->
                                                        <!--                                                                    <th>Personel Adı</th>-->
                                                        <!--                                                                    <th>Açıklama</th>-->
                                                        <!--                                                                    <th>İşlem Tarihi</th>-->
                                                        <!--                                                                </tr>-->
                                                        <!--                                                                </thead>-->
                                                        <!--                                                                <tbody>-->
                                                        <!--                                                                --><?php
                                                        //                                                                foreach (talep_history($details->id) as $items){
                                                        //                                                                    if($items->type==1){
                                                        //                                                                        $role = roles(role_id($items->user_id));
                                                        //                                                                        $name = personel_details($items->user_id);
                                                        //                                                                    }
                                                        //                                                                    else {
                                                        //                                                                        $role='TƏCHIZATÇI';
                                                        //                                                                        $name=customer_details($items->user_id)['company'];
                                                        //                                                                    }
                                                        //                                                                    ?>
                                                        <!--                                                                    <tr>-->
                                                        <!--                                                                        <td>--><?php //echo $role?><!--</td>-->
                                                        <!--                                                                        <td>--><?php //echo $name ?><!--</td>-->
                                                        <!--                                                                        <td>--><?php //echo $items->desc?><!--</td>-->
                                                        <!--                                                                        <td>--><?php //echo $items->created_at?><!--</td>-->
                                                        <!---->
                                                        <!--                                                                    </tr>-->
                                                        <!--                                                                    --><?php
                                                        //                                                                }
                                                        //                                                                ?>
                                                        <!--                                                                </tbody>-->
                                                        <!--                                                            </table>-->
                                                        <!---->
                                                        <!--                                                            <hr>-->
                                                        <!--                                                            --><?php
                                                        //                                                        }?>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            ?>

                                        </div>
                                        <?php if($items){  //varsa ?>
                                            <?php if($details->bildirim_durumu==0){
                                                if($details->status!=10){
                                                    ?>
                                                    <div class="row mt-3">
                                                        <div class="col col-md-4 col-xs-12">
                                                            <div class="jarviswidget">
                                                                <header> <h4>Təsdiqləmə qaydaları</h4></header>
                                                                <div class="borderedccc no-padding">


                                                                    <table class="table table-responsive">
                                                                        <tr>
                                                                            <td><?php echo roles(role_id($details->talep_eden_user_id)) ?></td>
                                                                            <td><button class="btn btn-info bildirim_olustur"><i class="fa fa-bell"></i></button></td>
                                                                        </tr>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        } ?>
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
    .image_talep_product{
        position: relative;
        display: inline-block;
        width: 10%;
        white-space: nowrap;
        vertical-align: bottom;
    }
    .input-group-addon{
        border: 1px solid gray;
        border-left: none;
        border-radius: 0px 17px 16px 0px;
        padding: 12px;
        font-size: 12px;
    }
    .nav-tabs .nav-link.disabled{
        color: #ffffff !important;
        background: #7585a3 !important;
    }
</style>


<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>app-assets/wizard.css">
<link href="<?php echo  base_url() ?>app-assets/talep.css?v=<?php echo rand(11111,99999) ?>" rel="stylesheet" type="text/css">
<script src="<?php echo  base_url() ?>app-assets/talepform/create_hizmet.js?v=<?php echo rand(11111,99999)?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript">

    $(document).on('change','.all_siparis_checkbox',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_siparis_checkbox').prop('checked',true)
        }
        else {
            $('.one_siparis_checkbox').prop('checked',false)
        }
    })

    let item_id=[];
    let talep_id=$('#talep_id').val();
    let cari_item_id=[];
    var url = '<?php echo base_url() ?>arac/file_handling';

    $(document).on('click','.add_product',function (){
        let file_id =$(this).attr('file_id');

        let talep_type =$(this).attr('talep_type');
        let firma_demirbas_id =$(this).attr('firma_demirbas_id');
        let demirbas_id =$(this).attr('demirbas_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Gider Kalemi Ekleyin',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName" id='data_form'>

                                        <div class="form-group col-md-12 one_group">
                                          <label for="name">Gider Kalemi Grubu</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id[]">
                                            <?php
            if(demirbas_group_list_who(2,$details->demirbas_id)){
            echo "<option value='0'>Seçiniz</option>";
            foreach (demirbas_group_list_who(2,$details->demirbas_id) as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
            }
            else {
            ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
            }

            ?>
                                        </select>
                                        </div>
                                         <div class="row">
                                           <div class="col col-xs-12 col-sm-12 col-md-12">

                                                <table class="table table_products">
                                                    <thead>
                                                        <tr>
                                                            <th>Açıklama</th>
                                                            <th>Birim</th>
                                                            <th>Miktar</th>
                                                            <th>İşlem</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>

                                                            <td><input type='text' class='form-control' name='product_desc'></td>
                                                          <td><select class="form-control select-box unit_id" name='unit_id'>
                                                                 <?php foreach (units() as $blm)
            {
                $id=$blm['id'];
                $name=$blm['name'];
                echo "<option value='$id'>$name</option>";
            } ?>
                                                                </select>
                                                            </td>
                                                            <td><input type='numaric' class='form-control' name='product_qty'></td>                                                            <td><button type='button' class='btn btn-success form_add_products'><i class='fa fa-plus'></td>

                                                            <input type='hidden' value='<?php echo $details->id?>' name='form_id'>
                                                            <input type='hidden' value='`+firma_demirbas_id+`' name='firma_demirbas_id'>
                                                            <input type='hidden' value='`+demirbas_id+`' name='demirbas_id'>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>


                                        </form>`,
            buttons: {
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                    action:function(){
                        location.reload();
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

    $(document).on('click','.temin_all',function (){
        let temin_date = $('.product_temin_date').eq(0).val();
        if(temin_date){
            $('.product_temin_date').val(temin_date)
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
                content: '1. Satırda Temin Tarihi Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })

    $(document).on('click','.aciliyet_all',function (){
        let progress_status_id = $('.progress_status_id').eq(0).val();
        if(progress_status_id){
            $('.progress_status_id').val(progress_status_id)
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
                content: '1. Satırda Aciliyet Durumu Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })

    $(document).on('click','.birim_all',function (){
        let unit_id = $('.unit_id').eq(0).val();
        if(unit_id){
            $('.unit_id').val(unit_id).select2().trigger('change');
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
                content: '1. Satırda Birim Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })

    $(document).on('click','#teklif_incele',function (){
        let form_id =$(this).attr('form_id');
        $.confirm({
            theme: 'material',
            closeIcon: false,
            icon: false,
            title: false,
            type: 'green',
            //animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12",
            containerFluid: !0,
            //smoothContent: true,
            //draggable: false,
            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    form_id: form_id,
                }

                let table_report='';
                $.post(baseurl + 'hizmet/teklif_incele_ajax',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    table_report=response;
                    $('.list').empty().html(table_report);
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                },
                formSubmit: {
                    text: 'Onay Ver',
                    btnClass: 'btn-blue',
                    action: function () {
                        let _serials = localStorage.getItem('product_serial');
                        if(_serials) {
                            _serials = JSON.parse(_serials);
                        }
                        if(!_serials){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Seçim Yapmalısınız',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return  false;
                        }
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            form_id: form_id,
                            data: _serials,
                        }

                        $.post(baseurl + 'hizmet/teklif_onay',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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
                moreButtons: {
                    text: 'Proje Müdürün Onayladığı Ürünlere Onay Ver',
                    btnClass: 'btn-success',
                    action: function () {
                        localStorage.clear();
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            form_id: form_id,
                        }

                        $.post(baseurl + 'hizmet/teklif_onay_proje_muduru_onayi',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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

    $(document).on('click','.add_all',function (){

        let len = $('.form_add_products').length;
        if(len){
            for (let eq = 0; eq < len; eq++ ){
                let option_details=[];

                option_details.push({
                    'option_id':$('.form_add_products').eq(eq).attr('option_id'),
                    'option_value_id':$('.form_add_products').eq(eq).attr('option_value_id'),
                });
                let data = {
                    product_id:$('.product_id').eq(eq).val(),
                    product_stock_code_id:$('.product_stock_code_id').eq(eq).val(),
                    option_details:option_details,
                    proje_stoklari_id:$('.form_add_products').eq(eq).attr('proje_stoklari_id'),
                    product_desc:$('.product_desc').eq(eq).val(),
                    product_kullanim_yeri:$('.product_kullanim_yeri').eq(eq).val(),
                    product_temin_date:$('.product_temin_date').eq(eq).val(),
                    progress_status_id:$('.progress_status_id').eq(eq).val(),
                    unit_id:$('.unit_id').eq(eq).val(),
                    product_qty:$('.product_qty').eq(eq).val(),
                    form_id:$('#talep_id').val(),
                    crsf_token: crsf_hash,
                }
                $.post(baseurl + 'hizmet/create_form_items',data,(response)=>{
                    let responses = jQuery.parseJSON(response);
                    if(responses.status=='Success'){
                        $('#loading-box').addClass('d-none');
                        let table=`<tr  id="remove`+responses.id+`" >
                                                      <td><p>`+responses.product_name+`</p><span style="font-size: 12px;">`+responses.option_html+`</span></td>
                                                    <td>`+responses.qyt_birim+`</td>
                                                    <td><button item_id='`+responses.id+`' type_="2" class="btn btn-danger btn-sm form_remove_products" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                        $('.table_create_products tbody').append(table);

                    }
                });
            }
            $.alert({
                theme: 'modern',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Başarılı',
                content: 'Başarılı Bir Şekilde Ürünler Eklendi!',
                buttons:{
                    formSubmit: {
                        text: 'Tamam',
                        btnClass: 'btn-blue',
                        action: function () {

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
                content: 'Herhangi Bir Ürün Bulunamadı!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }


    })

    $(document).on('click','.form_add_products',function (){


        $.post(baseurl + 'hizmet/create_form_items_gider',$('#data_form').serialize(),(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status=='Success'){
                $('#loading-box').addClass('d-none');
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-check',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Başarılı',
                    content: 'Başarılı Bir Şekilde Ürün Eklendi!',
                    buttons:{
                        formSubmit: {
                            text: 'Tamam',
                            btnClass: 'btn-blue',
                            action: function () {
                                $("input[name='product_desc']").val('');
                                $("input[name='product_qty']").val('');
                                $("input[name='product_price']").val('');

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
                    content: 'Kriterlere Uygun Ürün Bulunamadı!',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }
        });

    })

    $(document).ready(function (){
        //
        // let data_update = {
        //     id:$('#talep_id').val(),
        //     type:21
        // }
        // $.post(baseurl + 'controller/cost_control',data_update,(response)=>{
        //     let responses = jQuery.parseJSON(response);
        //     if(responses.status==200){
        //         $('#loading-box').addClass('d-none');
        //     }
        //     else {
        //         $.alert({
        //             theme: 'material',
        //             icon: 'fa fa-exclamation',
        //             type: 'red',
        //             animation: 'scale',
        //             useBootstrap: true,
        //             columnClass: "col-md-4 mx-auto",
        //             title: 'Dikkat!',
        //             content: responses.message,
        //             buttons:{
        //                 prev: {
        //                     text: 'Tamam',
        //                     btnClass: "btn btn-link text-dark",
        //                     action: function () {
        //                         if(responses.status_id==6){
        //                             $('#loading-box').addClass('d-none');
        //                             let data_new = {
        //                                 id:$('#talep_id').val(),
        //                                 type:21,
        //                                 view:1,
        //                                 status:1,
        //                                 cont_id:responses.cont_id
        //                             }
        //                             $.post(baseurl + 'controller/cost_control_update_new',data_new,(response)=>{
        //                                 let responses = jQuery.parseJSON(response);
        //                                 if(responses.status==200){
        //                                     $('#loading-box').addClass('d-none');
        //                                     $.alert({
        //                                         theme: 'modern',
        //                                         icon: 'fa fa-check',
        //                                         type: 'green',
        //                                         animation: 'scale',
        //                                         useBootstrap: true,
        //                                         columnClass: "small",
        //                                         title: 'Bilgi!',
        //                                         content: responses.message,
        //                                         buttons:{
        //                                             prev: {
        //                                                 text: 'Tamam',
        //                                                 btnClass: "btn btn-link text-dark",
        //                                                 action: function () {
        //                                                     location.reload()
        //                                                 }
        //                                             }
        //                                         }
        //                                     });
        //                                 }
        //                                 else {
        //                                     $('#loading-box').addClass('d-none');
        //                                     $.alert({
        //                                         theme: 'modern',
        //                                         icon: 'fa fa-exclamation',
        //                                         type: 'red',
        //                                         animation: 'scale',
        //                                         useBootstrap: true,
        //                                         columnClass: "small",
        //                                         title: 'Dikkat!',
        //                                         content: responses.message,
        //                                         buttons:{
        //                                             prev: {
        //                                                 text: 'Tamam',
        //                                                 btnClass: "btn btn-link text-dark",
        //                                             }
        //                                         }
        //                                     });
        //                                 }
        //                             })
        //
        //                         }
        //                         else {
        //                             $('#loading-box').removeClass('d-none');
        //                         }
        //
        //                     }
        //                 }
        //             }
        //         });
        //     }
        //
        // });


        draw_data_history();
        // let count = $('.teklif_status').length;
        // let array = [];
        // for (let i=0; i<count; i++){
        //     let durum  = parseInt($('.teklif_status').eq(i).val());
        //     array.push(durum);
        //     if(durum){
        //         $('.bildirim_olustur_satinalma').attr('disabled',false);
        //         return false;
        //     }
        //     else {
        //         $('.bildirim_olustur_satinalma').attr('disabled',true);
        //        return false;
        //     }
        // }

        // let  found = array.find(element => element > 0);

    })


    $(document).on('click','.onayla_stok_kontrol',function (){
        let talep_id = $('#talep_id').val();
        let aauth_id  = $(this).attr('aauth_id');
        let user_id  = $(this).attr('user_id');
        if(aauth_id!=user_id){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Yetkiniz Bulunmamaktadır',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
        else {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<form action="" class="formName">
                <div class="form-group">
                <p>Onaylamak Üzeresiniz Emin Misiniz? Onay Vermesini İstediğiniz Personelleri Seçiniz veya Direkt Olarak Onay Verebilirsiniz<p/>
                <div class="form-group">
                            <select class="form-control select-box" id="onay_new_list" multiple>
                                <?php foreach (all_personel_satinalma() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                $selected='';
                if($talep_user_satinalma){
                    if($talep_user_satinalma->user_id==$emp_id){
                        $selected='selected';
                    }
                }
                ?>
                                    <option <?php echo $selected;?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                            </select>
                            </div>

                </form>`,

                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            let product_details=[];
                            let count = $('.item_qty').length;
                            for (let i=0; i<count; i++) {
                                product_details.push({
                                    'item_id':$('.item_qty').eq(i).attr('item_id'),
                                    'item_qty':$('.item_qty').eq(i).val(),
                                });
                            }
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:talep_id,
                                progress_status_id:1,
                                product_details:product_details,
                                type:3,
                                crsf_token: crsf_hash,
                                onay_new_list: $('#onay_new_list').val(),
                            }
                            $.post(baseurl + 'hizmet/onay_olustur_stok_kontrol',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload()
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
                                        content: responses.message,
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

    })
    $(document).on('click','.onayla',function (){
        let talep_id = $('#talep_id').val();
        let aauth_id  = $(this).attr('aauth_id');
        let user_id  = $(this).attr('user_id');
        let sort  = $(this).attr('sort');
        if(aauth_id!=user_id){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Yetkiniz Bulunmamaktadır',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
        else {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<form action="" class="formName">
                <div class="form-group">
                <p>Onaylamak Üzeresiniz Emin Misiniz?<p/>
                <div class="form-group">
                            <select class="form-control select-box" id="satinalma_personeli">
                               <option value="0">Satınalma Personeli Seçiniz</option>
                                <?php foreach (all_personel_satinalma() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                $selected='';
                if($talep_user_satinalma){
                    if($talep_user_satinalma->user_id==$emp_id){
                        $selected='selected';
                    }
                }
                ?>
                                    <option <?php echo $selected;?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                            </select>
                            </div>
                             <div class="form-group">
                              <label for="firma_id">Təcili</label>
                                <select class="form-control select-box" id="progress_status_id">

                                    <?php foreach (progress_status() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                $selected='';
                if($details->progress_status_id==$emp_id){
                    $selected='selected';
                }
                ?>
                                        <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

    </div>
                </form>`,

                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            let product_details=[];
                            let name = $('#satinalma_personeli').val()
                            if(!parseInt(name)){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Satınalama Personeli Seçmelisiniz',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }
                            let count = $('.item_qty').length;
                            for (let i=0; i<count; i++) {
                                product_details.push({
                                    'item_id':$('.item_qty').eq(i).attr('item_id'),
                                    'item_qty':$('.item_qty').eq(i).val(),
                                });
                            }
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:talep_id,
                                sort:sort,
                                progress_status_id:$('#progress_status_id').val(),
                                product_details:product_details,
                                type:1,
                                crsf_token: crsf_hash,
                                satinalma_personeli: $('#satinalma_personeli').val(),
                            }
                            $.post(baseurl + 'hizmet/onay_olustur',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload()
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
                                        content: responses.message,
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

    })

    $(document).on('click','.product_move',function (){
        let file_id =$(this).attr('file_id');
        let item_product_id=[];
        let checked_count = $('.one_select:checked').length;

        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }

        else {

            let data_update = {
                talep_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
                type:2
            }
            $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $('.one_select:checked').each((index,item) => {
                        item_product_id.push($(item).attr('item_id'))
                    });
                    $.confirm({
                        theme: 'modern',
                        closeIcon: false,
                        title: 'MT Ürün Transferi',
                        icon: 'fa fa-plus',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: `<div class="content-body">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                    <select class="form-control select-box new_mt_id">
                                                        <?php foreach(all_mt_list() as $item_mt){
                                                            echo "<option value='$item_mt->id'>$item_mt->code</option>";
                        } ?>
                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                      <label for="name">Açıklama</label>
                                                      <textarea class="form-control" id="table_notes"></textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`,
                        buttons: {
                            formSubmit: {
                                text: 'Atama Yap',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let name = $('#table_notes').val()
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
                                    let data_update = {
                                        talep_id:$('#talep_id').val(),
                                        crsf_token: crsf_hash,
                                        item_product_id: item_product_id,
                                        new_mt_id: $('.new_mt_id').val(),
                                        desc: $('#table_notes').val(),
                                    }
                                    $.post(baseurl + 'hizmet/product_move',data_update,(response)=>{
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
                                                content: responses.message,
                                                buttons:{
                                                    formSubmit: {
                                                        text: 'Tamam',
                                                        btnClass: 'btn-blue',
                                                        action: function () {
                                                            location.reload()
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
                                                content: responses.message,
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
                            cancel: {
                                text: 'Kapat',
                                btnClass: "btn btn-danger btn-sm",
                                action: function () {
                                    location.reload();
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
                        content: responses.message,
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


    })

    $(document).on('click','.cari_ekle',function (){
        let file_id =$(this).attr('file_id');
        let checked_count = $('.one_select:checked').length;

        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }

        else {

            let data_update = {
                talep_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
                type:2
            }
            $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $('.one_select:checked').each((index,item) => {
                        item_id.push($(item).attr('item_id'))
                    });
                    $.confirm({
                        theme: 'modern',
                        closeIcon: false,
                        title: 'Talebe Cari Atama',
                        icon: 'fa fa-plus',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-12 mx-auto",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: `<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-8 col-md-8">
                        <div class="jarviswidget">
                            <header><h4>Xidmət Cari Arama Alanı</h4></header>
                            <div class="borderedccc">
                                <div class="widget-body">
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <fieldset>
                                            <div class="row mb-2">
                                                <section class="col col-sm-12 col-md-12">
                                                    <label class="label">Cari Adı</label>
                                                    <input type="texy" placeholder="Min 3 karakter<" class="form-control" id="search_name_cari">
                                                </section>
                                            </div>
                                            <div class="row mb-2">
                                                <section class="col col-sm-12 col-md-12">
                                                    <button class="btn btn-info" id="search_button_cari"><i class="fa fa-search"></i>&nbsp;Ara</button>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col col-xs-12 col-sm-4 col-md-4">
                        <div class="jarviswidget">
                            <header><h4>Atanan Cariler (<?php echo proje_code($details->proje_id)?>)</h4></header>
                            <table class="table table-responsive table_create_cari">
                                <thead>
                                    <tr>
                                        <th>Şirket Adı</th>
                                        <th>Gönderilecek SMS No</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <div class="jarviswidget">
                            <header><h4>Cariler</h4></header>
                            <table class="table table-responsive table_carilist">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cari</th>
                                        <th>Sektör</th>
                                        <th>Email</th>
                                        <th>Telefon</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`,
                        buttons: {
                            cancel: {
                                text: 'Kapat',
                                btnClass: "btn btn-danger btn-sm",
                                action: function () {
                                    location.reload();
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
                        content: responses.message,
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


    })


    $(document).on('click','.cari_view_button',function (){
        let content = $(this).attr('company');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgi',
            icon: 'fa fa-users',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:content,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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

    $(document).on('click','.products_view_button',function (){
        let content = $(this).attr('company');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgi',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:content,
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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

    $(document).on('click','.sales_person_update',function (){


        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Satınalma Personeli Güncelleme',
            icon: 'fa fa-user',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`
            <form action="" class="formName">
                <div class="form-group">
                            <select class="form-control select-box" id="sales_personel_id">
                                    <?php foreach (all_personel() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            $selected='';
            if($talep_user_satinalma){
                if($talep_user_satinalma->user_id==$emp_id){
                    $selected='selected';
                }
            }
            ?>
                                    <option <?php echo $selected;?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                            </select>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_update = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                            sales_personel_id: $('#sales_personel_id').val()
                        }
                        $.post(baseurl + 'hizmet/sales_personel_update',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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

    $(document).on('click','#pay_set_update',function (){
        let staff_id = $(this).attr('staff_id');
        let sort_avans_id = $(this).attr('sort_avans_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ödeme Yapacak Personeli Güncelleme',
            icon: 'fa fa-user',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `
                <form action="" class="formName">
                    <div class="form-group">
                                <select class="form-control select-box" id="payment_personel_id">
                                        <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select>
                    </form>`;
                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('#payment_personel_id').val(staff_id)
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_update = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                            payment_personel_id: $('#payment_personel_id').val(),
                            staff_id: staff_id,
                            sort_avans_id: sort_avans_id,
                        }
                        $.post(baseurl + 'hizmet/payment_personel_update',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Güncellendi',
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: 'Hata Aldınız! Yöneticiye Başvurun',
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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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
    $(document).on('click','.warehouse_create',function (){

        let tip=$(this).attr('tip'); //1 depo 2 transfer depo
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-building',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName">
                <div class="form-group">
                <input class='form-control' id='warehouse_text' placeholder='Açıklama'>
                </div>
                <div class="form-group">
                            <select class="form-control select-box" id="warehouse_id">
                               <option value="0">Seçiniz</option>
                                <?php foreach (all_personel() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_update = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                            warehouse_id: $('#warehouse_id').val(),
                            warehouse_text: $('#warehouse_text').val(),
                            tip: tip
                        }
                        $.post(baseurl + 'hizmet/warehouse_update',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Eklendi',
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: 'Hata Aldınız! Yöneticiye Başvurun',
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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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

    $(document).on('click','.transfer_status_change',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName">
                <p>Transfer İşlemini Tamamlanamak İstediğinizden Emin Misiniz?</p>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_update = {
                            talep_id:$('#talep_id').val(),
                        }
                        $.post(baseurl + 'hizmet/transfer_status_change',data_update,(response)=>{
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
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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

    $(document).on('click','#talep_list_get',function (){
        let data = {
            proje_id:"<?php echo $details->proje_id ?>",
            bolum_id:"<?php echo $details->bolum_id ?>",
            asama_id:"<?php echo $details->asama_id ?>",
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'hizmet/talep_list_get',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status=='Success'){
                $('#loading-box').addClass('d-none');
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-check',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Başarılı',
                    content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                    buttons:{
                        formSubmit: {
                            text: 'Tamam',
                            btnClass: 'btn-blue',
                            action: function () {
                                let units = '<select class="form-control select-box unit_id">';
                                responses.units.forEach((item,index) => {
                                    units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                })
                                units+='</select>';
                                let table = '';
                                responses.products.forEach((item,index) => {
                                    let no = parseInt(index)+parseInt(1);
                                    table+=`<tr>
                                                    <td>`+no+`</td>
                                                                                                        <td width="100px"><img src="<?php echo site_url() ?>`+item.images+`" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>

                                                    <td>
                                                    <input type="hidden" class="product_stock_code_id" value="`+item.product_stock_code_id+`">
                                                    <input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
                                                  <td>`+item.option_html+`</td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_desc+`"></td>
                                                    <td><input type="text" class="product_kullanim_yeri form-control"></td>
                                                    <td><input type="date"  class="product_temin_date form-control"></td>
                                                    <td><select class="form-control progress_status_id">
                                                    <?php foreach (progress_status() as $emp){
                                    $emp_id=$emp->id;
                                    $name=$emp->name;
                                    ?>
                                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                                </select></td>
                                                    <td><select class="form-control select-box unit_id" p_unit_id='`+item.p_unit_id+`'>
                                                     <?php foreach (units() as $blm)
                                    {
                                        $id=$blm['id'];
                                        $name=$blm['name'];
                                        echo "<option value='$id'>$name</option>";
                                    } ?>
                                                    </select>
                                                    </td>
                                                    <td><input class="product_qty form-control" max='`+item.max_qty+`' onkeyup="amount_max(this)" value="`+item.max_qty+`"></td>
                                                    <td><button proje_stoklari_id='`+item.proje_stoklari_id+`' eq='`+index+`' option_id="`+item.option_id+`" option_value_id="`+item.option_value_id+`" class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                <tr>`;
                                })
                                $('.table_products tbody').empty().html(table);

                                setTimeout(function(){
                                    let  unit_count = $('.unit_id').length;
                                    for(let k = 0; k < unit_count; k++){
                                        let unit_id = $('.unit_id').eq(k).attr('p_unit_id');
                                        $('.unit_id').eq(k).val(unit_id).select2().trigger('change')
                                    }

                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm")
                                    })
                                }, 1000);



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
                    content: 'Kriterlere Uygun Ürün Bulunamadı!',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }



        });
    })

    $(document).on('click','#search_button',function (){
        let keyword = $('#search_name').val();
        let category_id = parseInt($('#category_id').val());

        if(category_id==0){
            if(keyword.length < 3){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'En az 3 Karakter Yazmalısınız veya Bir Kategori Seçmelisiniz',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }
            else {
                $('#loading-box').removeClass('d-none');
                let cat_id = parseInt($('#category_id').val());
                let data = {
                    cat_id:cat_id,
                    keyword:keyword,
                    proje_id:"<?php echo $details->proje_id ?>",
                    bolum_id:"<?php echo $details->bolum_id ?>",
                    asama_id:"<?php echo $details->asama_id ?>",
                    talep_type:"<?php echo $details->talep_type ?>",
                    crsf_token: crsf_hash,
                }
                $.post(baseurl + 'hizmet/search_products',data,(response)=>{
                    let responses = jQuery.parseJSON(response);
                    if(responses.status=='Success'){
                        $('#loading-box').addClass('d-none');
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Başarılı',
                            content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                            buttons:{
                                formSubmit: {
                                    text: 'Tamam',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let units = '<select class="form-control select-box unit_id">';
                                        responses.units.forEach((item,index) => {
                                            units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                        })
                                        units+='</select>';
                                        let table = '';
                                        responses.products.forEach((item,index) => {
                                            let no = parseInt(index)+parseInt(1);
                                            table+=`<tr>
                                                    <td>`+no+`</td>
                                                    <td width="100px"><img src="<?php echo site_url() ?>`+item.images+`" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>
                                                              <input type="hidden" class="product_stock_code_id" value="`+item.product_stock_code_id+`">
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">
                                                    `+item.product_name+`</td>
                                                  <td>`+item.option_html+`</td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_name+`"></td>
                                                    <td><input type="text" class="product_kullanim_yeri form-control"></td>
                                                    <td><input type="date"  class="product_temin_date form-control"></td>
                                                    <td><select class="form-control progress_status_id">
                                                    <?php foreach (progress_status() as $emp){
                                            $emp_id=$emp->id;
                                            $name=$emp->name;
                                            ?>
                                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                                </select></td>
                                                    <td><select class="form-control select-box unit_id" p_unit_id='`+item.p_unit_id+`'>
                                                     <?php foreach (units() as $blm)
                                            {
                                                $id=$blm['id'];
                                                $name=$blm['name'];
                                                echo "<option value='$id'>$name</option>";
                                            } ?>
                                                    </select>
                                                    </td>
                                                    <td><input class="product_qty form-control" max='`+item.max_qty+`' onkeyup="amount_max(this)" value="1"></td>
                                                    <td><button proje_stoklari_id="`+item.proje_stoklari_id+`" eq='`+index+`' option_id="`+item.option_id+`" option_value_id="`+item.option_value_id+`" class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                </tr>`;
                                        })
                                        $('.table_products tbody').empty().html(table);

                                        setTimeout(function(){
                                            let  unit_count = $('.unit_id').length;
                                            for(let k = 0; k < unit_count; k++){
                                                let unit_id = $('.unit_id').eq(k).attr('p_unit_id');
                                                $('.unit_id').eq(k).val(unit_id).select2().trigger('change')
                                            }

                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm")
                                            })
                                        }, 1000);



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
                            content: 'Kriterlere Uygun Ürün Bulunamadı!',
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
        }
        else {
            $('#loading-box').removeClass('d-none');
            let cat_id = parseInt($('#category_id').val())
            let data = {
                cat_id:cat_id,
                proje_id:"<?php echo $details->proje_id ?>",
                bolum_id:"<?php echo $details->bolum_id ?>",
                asama_id:"<?php echo $details->asama_id ?>",
                talep_type:"<?php echo $details->talep_type ?>",
                keyword:keyword,
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'hizmet/search_products',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let units = '<select class="form-control select-box unit_id">';
                                    responses.units.forEach((item,index) => {
                                        units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                    })
                                    units+='</select>';
                                    let table = '';
                                    responses.products.forEach((item,index) => {
                                        let no = parseInt(index)+parseInt(1);
                                        table+=`<tr>
                                                    <td>`+no+`</td>
                                                   <input type="hidden" class="product_stock_code_id" value="`+item.product_stock_code_id+`">
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
                                                 <td><span class="option_view_btn" stock_code_id="`+item.product_stock_code_id+`">`+item.option_html+`</span></td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_name+`"></td>
                                                    <td><input type="text" class="product_kullanim_yeri form-control"></td>
                                                    <td><input type="date"  class="product_temin_date form-control"></td>
                                                    <td><select class="form-control progress_status_id">
                                                    <?php foreach (progress_status() as $emp){
                                        $emp_id=$emp->id;
                                        $name=$emp->name;
                                        ?>
                                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                                </select></td>
                                                    <td><select class="form-control select-box unit_id" p_unit_id='`+item.p_unit_id+`'>
                                                     <?php foreach (units() as $blm)
                                        {
                                            $id=$blm['id'];
                                            $name=$blm['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                    </select>
                                                    </td>
                                                    <td><input class="product_qty form-control" max='`+item.max_qty+`' onkeyup="amount_max(this)" value="1"></td>
                                                    <td><button proje_stoklari_id="`+item.proje_stoklari_id+`" eq='`+index+`' option_id="`+item.option_id+`" option_value_id="`+item.option_value_id+`" class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                </tr>`;
                                    })
                                    $('.table_products tbody').empty().html(table);

                                    setTimeout(function(){
                                        let  unit_count = $('.unit_id').length;
                                        for(let k = 0; k < unit_count; k++){
                                            let unit_id = $('.unit_id').eq(k).attr('p_unit_id');
                                            $('.unit_id').eq(k).val(unit_id).select2().trigger('change')
                                        }

                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    }, 1000);
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
                        content: 'Kriterlere Uygun Ürün Bulunamadı!',
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
    })

    $(document).on('click','.talep_donustur',function (){
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Talebi İstenilen Aşamaya Dünüştürme',
            icon: 'fa fa-question',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Emin Misiniz<p/>'+
                '</div>'+
                '<div class="form-group">' +
                '<input class="form-control iptal_desc" placeholder="Açıklama"'+
                '</div><br>'+
                '<div class="form-group">' +
                '<select class="form-control" id="update_status_id">'+
                <?php
                if(talep_form_status_list_info($details->status,$details->id)['items']){
                foreach (talep_form_status_list_info($details->status,$details->id)['items'] as $emp){
                $emp_id=$emp->id;
                $name=$emp->name.' '.talep_form_status_list_info($details->status,$details->id)['message'];
                ?>
                '<option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>'+
                <?php }
                }
                else {
                ?>
                '<option value="0">Aşama Değiştirilemez</option>'+
                <?php
                }

                ?>

                '</select>'+
                '</div>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name = $('.iptal_desc').val()
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
                            talep_id:talep_id,
                            status:$('#update_status_id').val(),
                            iptal_desc:name,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'hizmet/talep_asama_update',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
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
                                    content:responses.message,
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
    $(document).on('click','.qaime_asama_update',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Tehvil İşlemlerini Bitir',
            icon: 'fa fa-warehouse',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Bu işlem yapıldıktan sonra bu ürünler ile ilgili artık işlem yapamazsınız.İşlemi Yapmak İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'hizmet/qaime_status',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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


    $(document).on('click','.sened_asama_update',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Sened Aşamasına Geçiş',
            icon: 'fa fa-file',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Bu işlem yapıldıktan sonra bu ürünler ile ilgili artık işlem yapamazsınız.İşlemi Yapmak İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'hizmet/sened_status',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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

    $(document).on('click','.confirm_asama_update',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Talep İşlemlerini Bitir',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Talebi Kapatmak İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'hizmet/confirm_status',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: responses.message,
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
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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

    $(document).on('change','.all_qaime_products',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_qaime_products').prop('checked',true)
        }
        else {
            $('.one_qaime_products').prop('checked',false)
        }
    })


    $(document).on('click','.qaime_create',function (){
        let firma_id = [];
        let product_id = [];
        let talep_form_product_id = [];
        let lsf_id = [];
        let method_id_arr = [];

        $('.one_qaime_products:checked').each((index,item) => {
            firma_id.push($(item).attr('teslim_firma_id'))
            product_id.push($(item).attr('teslim_product_id'))
            method_id_arr.push($(item).attr('method_id'))
            talep_form_product_id.push($(item).attr('talep_form_product_id'))
        });

        let uniq = $.grep(firma_id, function(v, k) {
            return $.inArray(v, firma_id) === k;
        });

        let uniq2 = $.grep(method_id_arr, function(v, k) {
            return $.inArray(v, method_id_arr) === k;
        });

        for (let k=0;k<uniq2.length;k++){
            if(uniq2[k]==1)
            {
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Nakit Ödeme Methoduna Qaime Kesilemez!',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
                return false;
            }
        }

        if(uniq.length > 1){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Farklı Firmalar Seçilemez!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }
        else {
            let product_details = [];
            let data_update = {
                talep_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
                type:5
            }
            $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.confirm({
                        theme: 'material',
                        closeIcon: false,
                        title: 'Qaime Forması',
                        icon: 'fa fa-plus',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-12 mx-auto",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: function () {
                            let self = this;
                            let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                            let data = {
                                crsf_token: crsf_hash,
                                form_id: talep_id,
                                cari_id: uniq,
                                product_id: product_id,
                                talep_form_product_id: talep_form_product_id,
                            }

                            let table_report='';
                            $.post(baseurl + 'hizmet/qaime_ajax',data,(response) => {
                                self.$content.find('#person-list').empty().append(html);
                                table_report=response;
                                $('.list').empty().html(table_report);


                            });
                            self.$content.find('#person-list').empty().append(html);
                            return $('#person-container').html();
                        },
                        buttons: {
                            formSubmit: {
                                text: 'Qaime Oluştur',
                                btnClass: 'btn-blue',
                                action: function () {
                                    $('#loading-box').removeClass('d-none');

                                    let count = $('.item_qty').length;
                                    let product_details=[];
                                    for (i=0; i<count; i++){
                                        product_details.push({
                                            'item_qty':$('.item_qty').eq(i).val(),
                                            'item_price':$('.item_price').eq(i).val(),
                                            'item_discount':$('.item_discount').eq(i).val(),
                                            'item_kdv':$('.item_kdv').eq(i).val(),
                                            'item_edv_durum':$('.item_edv_durum').eq(i).val(),
                                            'item_umumi_hidden':$('.item_umumi_hidden').eq(i).val(),
                                            'item_umumi_cemi_hidden':$('.item_umumi_cemi_hidden').eq(i).val(),
                                            'edv_tutari_hidden':$('.edv_tutari_hidden').eq(i).val(),
                                            'item_unit_id':$('.item_unit_id').eq(i).val(),
                                            'item_discount_hidden':$('.item_discount_hidden').eq(i).val(),
                                            'item_id':$('.item_id').eq(i).val(),
                                            'product_id':$('.item_product_id').eq(i).val(),
                                            'talep_form_item_id':$('.talep_form_item_id').eq(i).val(),
                                        })
                                    }
                                    let data = {
                                        concat_mt_id:$('.concat_mt_id').val(),
                                        talep_id:talep_id,
                                        invoice_no:$('.invoice_no').val(),
                                        teslimat_tutar:$('.teslimat_tutar').val(),
                                        discount_type:$('.discount_type').val(),
                                        edv_durum:$('.edv_durum').val(),
                                        invoicedate:$('.invoicedate').val(),
                                        invoiceduedate:$('.invoiceduedate').val(),
                                        subtotal:$('.alt_sub_total_val').val(),
                                        discount:$('.alt_discount_total_val').val(),
                                        tax:$('.alt_edv_total_val').val(),
                                        tax_oran:0,
                                        total:$('.alt_total_val').val(),
                                        csd:$('.csd').val(),
                                        invoice_type_id:$('.invoice_type').val(),
                                        method:$('.method').val(),
                                        para_birimi:$('.para_birimi').val(),
                                        alt_cari_id:$('.alt_cari_id').val(),
                                        description:$('.description').val(),
                                        crsf_token: crsf_hash,
                                        product_details: product_details,
                                    }
                                    $.post(baseurl + 'hizmet/qaime_create',data,(response)=>{
                                        let responses = jQuery.parseJSON(response);
                                        if(responses.status=='Success'){
                                            $('#loading-box').addClass('d-none');
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-check',
                                                type: 'green',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Başarılı',
                                                content: responses.message,
                                                buttons:{
                                                    formSubmit: {
                                                        text: 'Tamam',
                                                        btnClass: 'btn-blue',
                                                        action: function () {
                                                            location.reload()
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
                                                content: responses.message,
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
                            cancel: {
                                text: 'Kapat',
                                btnClass: "btn btn-danger btn-sm",
                            }
                        },
                        onContentReady: function () {
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            })

                            $(".input_tag").tagsinput('items')

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
    })

    $(document).on('click','.talep_notes',function (e){

        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Talep Notları',
            icon: 'fa fa-exclamation',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-8 col-md-offset-3',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_history">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table id="notes_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>İşlem Tarihi</th>
                            <th>Açıklama</th>
                            <th>Personel</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_notes_report(talep_id);
                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
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

    function draw_data_notes_report(talep_id=0) {
        $('#notes_report').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('hizmet/ajax_list_notes')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: talep_id,
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i> Yeni Not Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni İstək Əlavə Edin ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="name">Not</label>
                                      <textarea class="form-control" id="table_notes"></textarea>

                                    </div>
                                </div>
                                </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sorğunu Açın',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let name = $('#table_notes').val()
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
                                            crsf_token: crsf_hash,
                                            table_notes:  $('#table_notes').val(),
                                            talep_id: talep_id
                                        }
                                        $.post(baseurl + 'hizmet/create_save_notes',data,(response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if(responses.status=='Success'){
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
                                                                $('#notes_report').DataTable().destroy();
                                                                draw_data_notes_report(talep_id);
                                                            }
                                                        }
                                                    }
                                                });

                                            }
                                            else if(responses.status=='Error'){

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
                    }
                }

            ]
        });
    };



    function draw_data_history(talep_id=0) {
        $('#mt_talep_history').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'ajax': {
                'url': "<?php echo site_url('hizmet/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: $('#talep_id').val(),
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

            ]
        });
    };


    $(document).on('click', ".notes_sil", function (e) {
        let notes_id = $(this).attr('notes_id');
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Notu Silmek Üzeresiniz. Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            notes_id:  notes_id,
                        }
                        $.post(baseurl + 'hizmet/notes_delete',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status=='Success'){
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
                                                $('#notes_report').DataTable().destroy();
                                                draw_data_notes_report(talep_id);
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

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

    $(document).on('click', ".talep_sil", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talep İptal Etmek Üzeresiniz?<p/>' +
                '<p><b>Bu İşleme Ait Qaime ve Stok Hareketleri Var İse İptal Olacaktır</b><p/>' +
                '<input type="text" id="desc" class="form-control desc" placeholder="İptal Sebebi Zorunludur">' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
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
                                content: 'İptal Sebebi Zorunludur',
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
                            crsf_token: crsf_hash,
                            file_id:  talep_id,
                            desc:  $('.desc').val(),
                            status:  10
                        }
                        $.post(baseurl + 'hizmet/status_upda',data,(response) => {
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


    $(document).on('click', ".cari_update", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Güncelleme',
            icon: 'fa fa-pen',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    talep_id: talep_id,
                }

                let table_report='<table class="table" style="text-align: initial;" id="cari_details">' +
                    '<tr>' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Tanımlı Cari</th>' +
                    '<th>Yeni Cari</th>' +
                    '</tr></thead></tr><tbody>';
                $.post(baseurl + 'hizmet/talep_form_teklif_cari_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $.each(responses.details, function (index, items) {
                            table_report+=`
                    <tr>
                        <td>`+items.company+`</td>
                        <td> <select class="form-control select-box firma_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_customer() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->company;
                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select><input type='hidden' class='old_cari' value='`+items.cari_id+`'></td>
                    </tr>`;
                        });
                        table_report+='</tbody></table>';
                        $('.list').empty().html(table_report);

                    }





                });
                self.$content.find('#person-list').empty().append(html);
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let count =$('.firma_id').length;
                        let kontrol=0;
                        for(let i = 0; i < count; i++){
                            if(parseInt($('.firma_id').eq(i).val())>0){
                                kontrol++;
                            }
                        }

                        if(!kontrol){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'En az 1 cari seçmelisiniz',
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

                        let product_details=[];
                        for (let i = 0;i < count; i++){
                            product_details.push({
                                'firma_id':$('.firma_id').eq(i).val(),
                                'old_cari':$('.old_cari').eq(i).val(),
                            })
                        }
                        let data = {
                            talep_id:  talep_id,
                            product_details:  product_details
                        }
                        $.post(baseurl + 'hizmet/mt_cari_update',data,(response) => {
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

    })

    $(document).on('click', ".talep_reverse", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İptal İşlemini Geri Almak Üzeresiniz?<p/>' +
                '<p><b>Bu İşleme Ait Qaime Geri Alınacak Ancak Stok Hareketleri Var ise Geri Gelmeyecektir. Stok Hareketleri İçin Fiş Oluşturulmalıdır</b><p/>' +
                '<input type="text" id="desc" class="form-control desc" placeholder="İptal Geri Alma Sebebi Zorunludur">' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
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
                                content: 'İptal Geri Alma Sebebi Zorunludur',
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
                            crsf_token: crsf_hash,
                            file_id:  talep_id,
                            desc:  $('.desc').val(),
                            status:  -1
                        }
                        $.post(baseurl + 'hizmet/status_upda',data,(response) => {
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



    $(document).on('click', ".transfer_bildirim", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-bell',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Transfer Bildirimi Başlatmak Üzeresiniz Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id:  talep_id,
                        }
                        $.post(baseurl + 'hizmet/transfer_bildirimi',data,(response) => {
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
                                                location.reload();
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

    });
    $(document).on('click','.talep_pay',function(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-bell',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<div class="list">
                                <div class='form-group'>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Cari Seçiniz</label>
                                        <select class='form-control' id='cari_id_pay'>
<option value='0'>Cari Seçiniz</option>
                                    </select>
                                 </div>
                                </div>
                                <div class='form-group'>
                                <div class="row">
                                    <div class="col-md-12">
                                    <label>İşlem Seçiniz</label>
                                    <select class='form-control select-box' id='transaction_id'>
<option value='0'>Cari Seçiniz</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            </div>
`;


                let data = {
                    crsf_token: crsf_hash,
                    form_id: $('#talep_id').val(),
                }

                let table_report='';
                $.post(baseurl + 'hizmet/talep_pay_info',data,(result) => {
                    self.$content.find('#person-list').empty().append(html);
                    let response = jQuery.parseJSON(result);
                    if(response.status==200){

                        let cari_details = response.cari_details;
                        cari_details.forEach((item_,index) => {
                            $('#cari_id_pay').append(new Option(item_.company, item_.id, false, false)).trigger('change');
                        })

                    }
                    else {
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: response.message,
                            buttons:{
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                        return false;
                    }

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            talep_id:  $('#talep_id').val(),
                            cari_id_pay:  $('#cari_id_pay').val(),
                            transaction_id:  $('#transaction_id').val(),
                        }
                        $.post(baseurl + 'hizmet/talep_pay',data,(response) => {
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
                                                location.reload();
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
    })

    $(document).on('change','#cari_id_pay',function (){
        let id = $(this).val();

        let data = {
            cari_id: id
        }

        let table_report='';
        if(id!=0){
            $.post(baseurl + 'hizmet/talep_pay_cari_transactions',data,(result) => {
                let response = jQuery.parseJSON(result);
                if(response.status==200){
                    $('#transaction_id').empty()
                    $('#transaction_id').append(new Option('SEÇİNİZ',0, false, false)).trigger('change');


                    let transactions = response.transactions;
                    transactions.forEach((item_,index) => {
                        $('#transaction_id').append(new Option(item_.invoicedate+'-'+item_.total+' - '+item_.method+' | '+item_.notes, item_.id, false, false)).trigger('change');
                    })

                }
                else {
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: response.message,
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                    return false;
                }

            });
        }


    })
    $(document).on('click','.transfer_status_change_new',function(){
        let transfer_status = $(this).attr('transfer_status');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-bell',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `
<div class="list">

                            </div>`;


                let data = {
                    crsf_token: crsf_hash,
                    form_id: $('#talep_id').val(),
                }

                let table_report='';
                $.post(baseurl + 'hizmet/transfer_details',data,(result) => {
                    self.$content.find('#person-list').empty().append(html);
                    let response = jQuery.parseJSON(result);
                    $('.list').empty().html(response.html);

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            talep_id:  $('#talep_id').val(),
                            warehouse_id:  $('#warehouse_id').val(),
                            transfer_warehouse_id:  $('#transfer_warehouse_id').val(),
                            transfer_status:  transfer_status,
                        }



                        $.post(baseurl + 'hizmet/transfer_change_new',data,(response) => {
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
                                                location.reload();
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
                                    content: responses.messages,
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

    $(document).on('click','#ljt_view',function (){
        let mt_id = $(this).attr('mt_id');
        $.confirm({
            theme: 'material',
            closeIcon: false,
            icon: false,
            title: false,
            type: 'green',
            useBootstrap: true,
            columnClass: "col-md-12",
            containerFluid: !0,

            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    mt_id: mt_id,
                }

                let table_report='';
                $.post(baseurl + 'nakliye/mt_view',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report=responses.html;
                    $('.list').empty().html(table_report);


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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

    function details_notes(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Notlar',
            icon: 'fa fa-bell',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`  <table class="table notestable" style="
    text-align: center;
">
                                                        <thead class="notesthead" id="notesthead">
                                                        <tr>
                                                            <th>Personel</th>
                                                            <th>Not</th>
                                                            <th>Oluşturma Tarihi</th>
                                                            <th>İşlem</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="notestbody">
                                                        <?php
            if($note_list){
            foreach ($note_list as $list){
            ?>
                                                            <tr class="notestr">
                                                                <td><?= $list->name?></td>
                                                                <td><?= $list->notes?></td>
                                                                <td><?= $list->created_at?></td>
                                                                <td><button class="delete_not_new btn btn-danger" note_id="<?php echo $list->id?>" type="button">SİL</button></td>
                                                            </tr>
                                                            <?php
            }
            }?>

                                                        </tbody>
                                                    </table>`,
            buttons: {
                cancel:{
                    text: 'Kapat',
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
    }


    $(document).on('change','.group_id',function (){
        let id = $(this).val();

        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_parent_kontrol',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            let eq=$(this).parent().index();

            if(responses.status==200){

                let class_name = $(this).attr('class');
                if(class_name=='form-control select-box group_id'){


                    if($(this).val()==0){
                        $('.add_group').eq(parseInt(eq)-1).remove();
                    }

                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;
                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }



                }
                else {
                    $('.add_group').remove();
                }


                let add_grp = $('.add_group').length;
                if(parseInt(add_grp)){
                    let say = parseInt(add_grp)-1;
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id[]">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.add_group').eq(say).after(html);

                }
                else {
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id[]">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.one_group').after(html);
                }
            }
            else {

                if($(this).val()==0){
                    $('.add_group').eq(parseInt(eq)-1).remove();
                }

                if($(this).attr('types')=='ones'){

                    $('.add_group').remove();
                }
                else {
                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;

                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }
                }



                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'orange',
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


        });
    })
    $(document).on('click','.product_duzenle',function () {
        let checked_count = $('.one_tehvil_products:checked').length;
        if (checked_count == 0) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons: {
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }
        else {
            let product_details=[];
            $('.one_tehvil_products:checked').each((index,item) => {
                let eq = $(item).attr('eq');
                product_details.push({
                    product_id:$(item).attr('product_id'),
                    teslimat_warehouse_id:$(item).attr('teslimat_warehouse_id'),
                })
            });

            let data_update = {
                talep_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
                type:4
            }

            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Düzenle',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: `
                <h4>Depo Giriş İşlemleri Silinecektir. Tekrar Deponuza Giriş Yapmanız Gereklidir.</h4>
                <div class='form-group'>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                            <input class="form-control yeni_miktar" placeholder="yeni miktar">
                            </div>

 <div class="col-md-12 mb-2">
<select  class="form-control select-box new_unit_id">
                                                                                        <?php foreach (units() as $unit_items){
                    $selected='';
                    $id_=$unit_items['id'];
                    $name=$unit_items['name'];
                    echo "<option $selected value='$id_'>$name</option>";
                }?>
                                                                                    </select>
</div>
 <div class="col-md-12 mb-2">
                            <input class="form-control birim_fiyati" placeholder="birim_fiyati">

</div>
 <div class="col-md-12 mb-2">
                            <input class="form-control aciklama" placeholder="aciklama">

</div>
</div>
</div>

`,
                buttons: {
                    formSubmit: {
                        text: 'Oluştur',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');

                            let data = {
                                talep_id:$('#talep_id').val(),
                                crsf_token: crsf_hash,
                                product_details: product_details,
                                yeni_miktar: $('.yeni_miktar').val(),
                                new_unit_id: $('.new_unit_id').val(),
                                aciklama: $('.aciklama').val(),
                                birim_fiyati: $('.birim_fiyati').val(),
                            }
                            $.post(baseurl + 'hizmet/product_duzenle',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload()
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
                                        content: responses.message,
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
                    cancel: {
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
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
        }
    });

 $(document).on('click','#cari_hesap_faktura_add',function (){
     let cari_id = $(this).attr('cari_id');
     let talep_code = $('#talep_code').val();
     let message = "Sayın Yetkili Makro2000 Şirketi sizden hesap faktura beklemektedir. MT Kodu : "+talep_code;
     $.confirm({
         theme: 'modern',
         closeIcon: false,
         title: 'Hesap Fakturası İsteme Sms Forması',
         icon: 'fa fa-plus',
         type: 'green',
         animation: 'scale',
         useBootstrap: true,
         columnClass: "col-md-12 mx-auto",
         containerFluid: !0,
         smoothContent: true,
         draggable: false,
         content: function () {
             let self = this;
             let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
             let responses;
             html +=`<div class="content-body">
                     <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
<div class="col col-xs-12 col-sm-12 col-md-12">
  <header><h4>Mesajınız</h4></header>
<textarea class="form-control" id="sms_mesaji">`+message+`</textarea>
</div>
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <div class="jarviswidget">
                                            <header><h4>Təchizatçılar üçün</h4></header>
                                            <div class="borderedccc">
                                                <div class="widget-body">
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                      <table class="table cari_detils_listy">
                                                        <thead>
                                                            <tr>
                                                                <th>Şirket Adı</th>
                                                                <th>Gönderilecek SMS Numaralrı</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
             let data = {
                 crsf_token: crsf_hash,
                 cari_id: cari_id,
             }

             let table_report='';
             $.post(baseurl + 'hizmet/get_all_cari_sms',data,(response) => {
                 self.$content.find('#person-list').empty().append(html);
                 let responses = jQuery.parseJSON(response);
                 responses.items.forEach((item) => {
                     table_report +=`<tr><td>`+item.cari_name+`</td><td><input type="hidden" class="cari_id" value="`+item.cari_id+`"><input class="form-control input_tag cari_phone" value="`+item.cari_phone+`"></td></tr>`;
                 })
                 $('.cari_detils_listy tbody').empty().html(table_report);


             });
             self.$content.find('#person-list').empty().append(html);
             return $('#person-container').html();
         },
         buttons: {
             formSubmit: {
                 text: 'Sms Gönder',
                 btnClass: 'btn-blue',
                 action: function () {

                     $('#loading-box').removeClass('d-none');
                     let count = $('.cari_phone').length;
                     let cari_details=[];
                     for (i=0; i<count; i++){
                         cari_details.push({
                             'cari_id':$('.cari_id').eq(i).val(),
                             'cari_phone':$('.cari_phone').eq(i).val(),
                         })
                     }
                     let data = {
                         talep_id:$('#talep_id').val(),
                         crsf_token: crsf_hash,
                         cari_details: cari_details,
                         sms_mesaji: $('#sms_mesaji').val(),
                     }
                     $.post(baseurl + 'hizmet/hesap_faktura_sms',data,(response)=>{
                         let responses = jQuery.parseJSON(response);
                         if(responses.status=='Success'){
                             $('#loading-box').addClass('d-none');
                             $.alert({
                                 theme: 'modern',
                                 icon: 'fa fa-check',
                                 type: 'green',
                                 animation: 'scale',
                                 useBootstrap: true,
                                 columnClass: "col-md-4 mx-auto",
                                 title: 'Başarılı',
                                 content: responses.message,
                                 buttons:{
                                     formSubmit: {
                                         text: 'Tamam',
                                         btnClass: 'btn-blue',
                                         action: function () {
                                             location.reload()
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
                                 content: responses.message,
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
             cancel: {
                 text: 'Kapat',
                 btnClass: "btn btn-danger btn-sm",
             }
         },
         onContentReady: function () {
             $('.select-box').select2({
                 dropdownParent: $(".jconfirm-box-container")
             })

             $(".input_tag").tagsinput('items')

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
        function teklif_ver($cari_id,$form_id){
        let status=1;

        let data = {
            crsf_token: crsf_hash,
            cari_id: $cari_id,
            form_id: $form_id,
        }
        $.post(baseurl + 'hizmet/hizmet_view_yetki',data,(response) => {
            let responses = jQuery.parseJSON(response);
             let status = responses.details.status_yetki;
             let get_items = responses.details.html;
            if(parseInt(status)==1){
                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: 'Dikkat',
                    icon: 'fa fa-money-bill',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content:'<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<p>Təklif Qiymətlərinizə ƏDV daxildir, yoxsa yox?<p/>'+
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Bəli',
                            btnClass: 'btn-blue',
                            action: function () {
                                kdv=1;
                                $.confirm({
                                    theme: 'modern',
                                    closeIcon: false,
                                    title: 'Dikkat',
                                    icon: 'fa fa-truck',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    containerFluid: !0,
                                    smoothContent: true,
                                    draggable: false,
                                    content:'<form action="" class="formName">' +
                                        '<div class="form-group">' +
                                        '<p>Təklif Qiymətlərinizə Çatdırılma daxildir, yoxsa yox?<p/>'+
                                        '</form>',
                                    buttons: {
                                        formSubmit: {
                                            text: 'Bəli',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                nakliye=1;
                                                list_teklif(get_items);

                                            }
                                        },
                                        cancel:{
                                            text: 'Yox',
                                            btnClass: "btn btn-danger btn-sm",
                                            action: function () {
                                                nakliye=0;
                                                list_teklif(get_items);
                                            }
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
                            }
                        },
                        cancel:{
                            text: 'Yox',
                            btnClass: "btn btn-danger btn-sm",
                            action: function () {
                                kdv=0;
                                $.confirm({
                                    theme: 'modern',
                                    closeIcon: false,
                                    title: 'Dikkat',
                                    icon: 'fa fa-truck',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    containerFluid: !0,
                                    smoothContent: true,
                                    draggable: false,
                                    content:'<form action="" class="formName">' +
                                        '<div class="form-group">' +
                                        '<p>Təklif Qiymətlərinizə Çatdırılma daxildir, yoxsa yox?<p/>'+
                                        '</form>',
                                    buttons: {
                                        formSubmit: {
                                            text: 'Bəli',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                nakliye=1;
                                                list_teklif(get_items);
                                            }
                                        },
                                        cancel:{
                                            text: 'Yox',
                                            btnClass: "btn btn-danger btn-sm",
                                            action: function () {
                                                nakliye=0;
                                                list_teklif(get_items);
                                            }
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
                            }
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
            } // Teklif Ver
            else if(parseInt(status)==4) {
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Dikkat',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content:'İhale Süresi Dolmuştur!',
                    buttons: {
                        cancel:{
                            text: 'Tamam',
                            btnClass: "btn btn-danger btn-sm"
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
            } // ihale Süresi Dolmuş
            else {
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Dikkat',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content:'Daha Önceden Teklif Verilmiştir!',
                    buttons: {
                        cancel:{
                            text: 'Tamam',
                            btnClass: "btn btn-danger btn-sm"
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
            } //teklif verilmiş


        });

    }

    function list_teklif(html){
        // <p class="font_11"><button class='btn btn-info btn-sm create_product'><i class='fa fa-plus'></i> Yeni Ürün Ekle</button></p>
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: false,
            icon: false,
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 ",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<div class="content-body">`+html+`

            </div>`,
            buttons: {
                formSubmit: {
                    text: 'Kaydet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let product_details=[];
                        let count = $('.item_id').length;
                        for (let i = 0;i < count; i++){
                            product_details.push({
                                'item_id':$('.item_id').eq(i).val(),
                                'marka':$('.marka').eq(i).val(),
                                'price':$('.price').eq(i).val(),
                                'notes':$('.notes').eq(i).val(),
                            })
                        }

                        let data_update = {
                            cari_id:$('#cari_id_hidden').val(),
                            talep_id:$('#form_id_hidden').val(),
                            tftcd_id:$('#tftcd_id_hidden').val(),
                            product_details: product_details,
                            nakliye: nakliye,
                            kdv: kdv,
                        }
                        $.post(baseurl + 'hizmet/yetki_teklif_olustur',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Teklifiniz Oluşturuldu!',
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
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
                                    content: 'Hata Aldınız! Yöneticiye Başvurun',
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
    }

</script>

<style>
    .delivery-progress .wrapper.active .circle{
        stroke: #fff;
        stroke-width: 0;
        align-items: center;
        background: #f16623;
        border: 3px solid #f16623;
        border-radius: 50px;
        display: flex;
        height: 80px;
        justify-content: center;
        position: relative;
        width: 80px;

    }
    .delivery-progress .wrapper .content{
        text-align: center;
    }
    .delivery-progress .content {
        color: #6e7787;
        font-size: 14px;
        font-weight: 500;
        margin-top: 20px;
    }
    .ty-content, .ty-content-non-align {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 70%;
        align-items: center;
    }

    .delivery-progress-flex, .wrapper
    {
        display: flex;
    }

    .delivery-progress {
        justify-content: space-around;
        margin-bottom: 20px;
        margin-top: 20px;
        overflow-x: auto;
        width: 100%;
    }
    .wrapper {
        align-items: center;
        flex: 1 1;
        flex-direction: column;
        justify-content: flex-start;
        position: relative;
    }
    .delivery-progress .wrapper *{
        position: relative;
        z-index: 2;
    }

    .delivery-progress .wrapper:not(:first-child).active:before {
        background: #f16623;
    }
    .wrapper:not(.truck-wrapper):not(:first-child):before {
        background: #afbbca;
        content: "";
        height: 4px;
        position: absolute;
        right: 50%;
        top: 40px;
        width: 100%;
        z-index: 1;
    }
    .circle-active{
        background: #0bc15c;
        border: 3px solid #0bc15c;
    }

    .delivery-main-message {
        font-size: 25px;
        font-weight: 300;
        margin-top: 20px;
        text-align: center;
    }
    .delivery-main-message.orange {
        color: #f16623;
    }
</style>




