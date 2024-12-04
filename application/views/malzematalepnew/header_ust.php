<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="widget-body">
                    <a href="/malzemetalep" class="btn btn-secondary mobile_button" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İstek Siyahısı"><i class="fa fa-arrow-left"></i></a>
                    <button type="button" class="btn btn-secondary mobile_button talep_notes" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep Hakkında Notlar" talep_id="<?php echo $details->id ?>"><i class="fa fa-list"></i></button>
                    <?php if($details->status==10){
                        ?>
                        <button type="button" class="btn btn-secondary talep_reverse mobile_button" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal İşlemini Geri Al" talep_id="<?php echo $details->id ?>" ><i class="fa fa-reply"></i></button>

                        <?php

                    } else {

                        ?>
                        <button type="button" class="btn btn-danger talep_sil mobile_button" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep İptal Et" ><i class="fa fa-ban"></i></button>

                        <?php
                    } ?>


                    <!--                                                                    <button type="button" class="btn btn-success cari_update" talep_id="--><?php //echo $details->id ?><!--"><i class="fa fa-pen"></i> Cari Değiştir</button>-->
                    <button type="button" class="btn btn-secondary talep_donustur mobile_button"  talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talebi Bir Önceki Adıma Al"><i class="fa fa-reply"></i></button>
                    <button type="button" class="btn btn-secondary talep_pay mobile_button" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Ödeme Ekle"><i class="fa fa-money-bill"></i></button>
                    <button type="button" class="btn btn-secondary mobile_button transfer_status_change_new" transfer_status="<?php echo $details->transfer_status?>" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Transfer Durumunu Değiştir"><i class="fa fa-warehouse"></i></button>
                    <button  islem_tipi="7" islem_id="<?php echo $details->id ?>" type="button" class="btn btn-secondary mobile_button add_not_new" data-popup="popover" data-trigger="hover" data-original-title="Bilgilendirme"  data-placement="top" data-content="Not Ekle"><i class="fa fa-notes-medical"></i></button>
                    <button  onclick="details_notes()" type="button" class="btn btn-secondary mobile_button button_view_notes" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Notları Görüntüle"><i class="fa fa-list-alt"></i></button>
                    <button  type="button" class="btn btn-secondary mobile_button button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="1" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
                    <button  type="button" class="btn btn-secondary mobile_button button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="1" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>


                    <?php if($details->gider_durumu) { ?>
                        <a target="_blank" href="/demirbas/mt_create/<?php echo $details->id ?>" class="btn btn-secondary "><i class="fa fa-plus"></i> Gidere İşle</a>
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
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" id="talep_id" value="<?php echo $details->id ?>">
                <input type="hidden" id="proje_id_hidden" value="<?php echo $details->proje_id ?>">
                <header>
                    <h4 class="mobile_text_header">Məlumat Sorğunun</h4>
                </header>
                <div class="borderedccc no-padding">
                    <div class="widget-body row">
                        <?php
                        $div='<div class="col col-xs-12 col-sm-12 col-md-12 no-padding">';
                        if($details->talep_type==3) {
                            $div='<div class="col col-xs-8 col-sm-8 col-md-8 no-padding">';
                        }
                        echo $div;
                        ?>

                        <div class="table-responsive">
                            <table class="table table-bordered mobile_text" style="font-weight: 500;">
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
                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Talep Tarihi: </span></td>
                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo dateformat_new($details->created_at)?>&nbsp;</span></td>

                                    <td class="vert-align-mid">Talep Oluşturan Personel: </td>
                                    <td class="vert-align-mid" ><?php echo personel_details($details->aauth)?></td>

                                    <?php if($details->transfer_status) { ?>
                                        <td class="vert-align-mid " ><div class="dgt_isPlaces"><span class="font-sm txt-color-darken no-padding">Transfer Teslimat Yeri: </span></div></td>
                                        <td class="vert-align-mid">
                                            <label class="font-md-2 txt-color-darken no-padding dgt_isPlaces no-margin">
                                                <?php if(!$details->transfer_warehouse_id) {
                                                    ?>
                                                    <button class="btn btn-danger warehouse_create mobile_button" tip="2"><i class="fa fa-warehouse"></i>&nbsp;Çatdırılma Yeri</button>
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
                                                            $title ='<button class="btn btn-info transfer_status_change mobile_button" tip="2"><i class="fa fa-check"></i> Transfer Tamamla</button>';
                                                        }
                                                        ?>

                                                        <button class="btn btn-success warehouse_create mobile_button" tip="2"><i class="fa fa-warehouse"></i>&nbsp;<?php echo  warehouse_details($details->transfer_warehouse_id)->title ?></button><?php echo $title ?>

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
                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><input class="form-control no-padding no-border update_val mobile_text" tip="desc" type="text" value="<?php echo $details->desc?>"></span>
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


                                <tr>
                                    <td class="vert-align-mid " ><div class="dgt_isPlaces"><span class="font-sm txt-color-darken no-padding">Son Teslimat Yeri: </span></div>

                                    <td class="vert-align-mid">
                                        <label class="font-md-2 txt-color-darken no-padding dgt_isPlaces no-margin">
                                            <?php

                                            $transfer_status = '';
                                            if ($details->status == 7) {
                                                if ($details->transfer_status != 0) {
                                                    if (!$details->transfer_bildirim) {
                                                        $transfer_status = ' <button type="button" class="btn btn-secondary transfer_bildirim" talep_id=' . $details->id . '><b></b>Bildirim Başlat</button>';
                                                    } else {
                                                        if ($details->transfer_status == 1) {
                                                            $transfer_status = 'Transfer Bildirimi Başlatıldı';
                                                        } elseif ($details->transfer_status == 2) {
                                                            $transfer_status = 'Transfer Yapıldı';
                                                        }
                                                    }
                                                }

                                            }

                                            if(!$details->warehouse_id) {
                                                ?>
                                                <button class="btn btn-danger warehouse_create mobile_button" tip="1"><i class="fa fa-warehouse"></i>&nbsp;Çatdırılma Yeri</button><?php echo $transfer_status?>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <div class="dgt_isPlaces">
                                                    <button class="btn btn-success warehouse_create mobile_button" tip="1"><i class="fa fa-warehouse"></i>&nbsp;<?php echo  warehouse_details($details->warehouse_id)->title ?></button><?php echo $transfer_status?>
                                                    <br>
                                                    <?php echo  $details->warehouse_notes ?>
                                                </div>
                                                <?php
                                            }?>
                                        </label>
                                    </td>
                                    <td class="vert-align-mid " ><div class="dgt_isPlaces"><span class="font-sm txt-color-darken no-padding">Talep Durumu : </span></div>
                                    <td class="vert-align-mid " ><div class="dgt_isPlaces"><span class="font-sm txt-color-darken no-padding"><?php echo talep_form_status_details($details->status)->name?> </span></div>

                                </tr>
                                </tbody></table>
                        </div>

                    </div>
                    <?php if($details->talep_type==3) { ?>
                        <div class="col col-xs-4 col-sm-4 col-md-4 no-padding">
                            <div class="table-responsive">
                                <?php echo demirbas_html($details->demirbas_id,$details->firma_demirbas_id); ?>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="talep_status" value="<?php echo $details->status?>">