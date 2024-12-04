<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Ceza Talebi Görüntüle</span></h4>
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
                                        <div class="col col-xs-12 col-sm-12 col-md-12 mb-12">
                                            <div class="mb-3">
                                                <div class="no-padding">
                                                    <div class="widget-body">
                                                        <a href="/carigidertalepnew" class="btn btn-warning"><i class="fa fa-arrow-left"></i> İstək siyahısı</a>
                                                        <a target="_blank" href="/caricezatalep/print/<?php echo $details->id ?>" class="btn btn-info"><i class="fa fa-print"></i> Yazdır</a>
                                                        <button type="button" class="btn btn-info talep_notes" talep_id="<?php echo $details->id ?>"><i class="fa fa-reply"></i> Talep Hakkında Notlar</button>
                                                        <?php if($details->status==10){
                                                            ?>
                                                            <button type="button" class="btn btn-warning talep_reverse" talep_id="<?php echo $details->id ?>" ><i class="fa fa-reply"></i> İptal İşlemini Geri Al</button>

                                                            <?php

                                                        } else {

                                                            ?>
                                                            <button type="button" class="btn btn-danger talep_sil" talep_id="<?php echo $details->id ?>" ><i class="fa fa-ban"></i> Talep İptal Et</button>

                                                            <?php
                                                        } ?>


                                                        <button type="button" class="btn btn-success talep_kapat" talep_id="<?php echo $details->id ?>" ><i class="fa fa-check"></i> Talep Kapat</button>

                                                        <button  islem_tipi="8" islem_id="<?php echo  $details->id ?>" type="button" class="btn btn-success  add_not_new">Not Ekle</button>
                                                        <button  onclick="details_notes()" type="button" class="btn btn-success button_view_notes">Notları Görüntüle</button>


                                                        <?php if($items){  //varsa ?>
                                                            <?php if($details->bildirim_durumu==0){
                                                                if($details->status!=10){
                                                                    echo '<button class="btn btn-info bildirim_olustur"><i class="fa fa-bell"></i></button>';
                                                                    ?>
                                                                    <?php
                                                                }
                                                            }
                                                        } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-12">
                                            <div class="jarviswidget">
                                                <input type="hidden" id="talep_id" value="<?php echo $details->id ?>">
                                                <header>
                                                    <h4>Məlumat Sorğunun</h4></header>
                                                <div class="borderedccc no-padding">
                                                    <div class="widget-body">
                                                        <div class="row">
                                                            <div class="col col-xs-6 col-sm-6 col-md-6 no-padding">
                                                                <div class="table-responsive">
                                                                    <table class="table table-responsive">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="vert-align-mid" style="border:none" ><span class=" txt-color-darken no-padding"> Proje: </span></td>
                                                                            <td class="vert-align-mid" style="border:none" colspan="2">
                                                                                <span class="txt-color-darken no-padding " data-popup="popover" title="" data-trigger="hover" data-content="<?php echo proje_name($details->proje_id)?>" data-original-title="Proje Adı"><b><?php echo proje_code($details->proje_id)?></b></span>

                                                                            </td>
                                                                            <td class="vert-align-mid" style="border:none"><span class=" txt-color-darken no-padding">Şirket: </span></td>
                                                                            <td class="vert-align-mid" style="border:none">
                                                                                <span class=" txt-color-darken no-padding no-margin"><b>MAKRO 2000 EĞİTİM TEKNOLOJİLERİ İNŞAAT TAAHHÜT İÇ VE DIŞ TİCARET ANONİM ŞİRKETİ</b></span>
                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td class="vert-align-mid" ><span class=" txt-color-darken no-padding"> Cari: </span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding no-margin"><b><?php echo customer_details($details->cari_id)['company']?></b></span>
                                                                            </td>
                                                                            <td class="vert-align-mid" ><span class=" txt-color-darken no-padding">Ödeme Metodu: </span></td>
                                                                            <td class="vert-align-mid">
                                                                                <span class=" txt-color-darken no-padding no-margin"><b><?php echo account_type_sorgu($details->method)?></b></span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding">Açıklama: </span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding no-margin"><b><?php echo $details->desc?></b></span>
                                                                            </td>
                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding dgt_relatedPersons">Talep Kodu: </span></td>
                                                                            <td class="vert-align-mid">
                                                                                <span class=" txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                    <b><?php echo $details->code; ?></b>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding dgt_relatedPersons">Qaimeler </span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                    <?php echo talep_qaime($details->id); ?>
                                                                                </span>
                                                                            </td>

                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding dgt_relatedPersons">Ödemeler</span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                    <?php echo talep_odemeler_new($details->id,1); ?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding">Talep Eden: </span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding no-margin"><b><?php echo personel_details($details->talep_eden_user_id)?></b></span>
                                                                            </td>

                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding">Bağlı Olduğu Grup: </span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding no-margin"><?php echo who_demirbas($details->demirbas_id)->name?></span>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col col-xs-4 col-sm-4 col-md-4 no-padding">
                                                                <div class="table-responsive">
                                                                    <?php echo demirbas_html($details->demirbas_id,$details->firma_demirbas_id); ?>

                                                                </div>
                                                            </div>
                                                            <div class="col col-xs-2 col-sm-2 col-md-2 no-padding">
                                                                <div class="table-responsive">
                                                                    <?php echo pay_images($details->id); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($details->status==1) { // Talep Durumunda İse  ?>
                                            <div class="col col-xs-12 col-sm-12 col-md-12 mb-12">
                                                <div class="row mt-3">
                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget" id="wid-id-7">
                                                            <header> <h4>Tələb materialları</h4></header>
                                                            <div class="borderedccc no-padding">
                                                                <?php if($items){  //varsa ?>

                                                                    <table class="table ">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Gider</th>
                                                                            <th>Açıklama</th>
                                                                            <th>Miktar</th>
                                                                            <th>Birim</th>
                                                                            <th>Fiyat</th>
                                                                            <th>Toplam Tutar</th>
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

                                                                            ?>
                                                                            <tr  id="remove<?php echo $values->id?>">
                                                                                <td><?php echo $i ?></td>
                                                                                <td><?php echo $values->name ?></td>
                                                                                <td><?php echo $values->product_desc ?></td>
                                                                                <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->product_qty ?>" class="form-control item_qty"></td>
                                                                                <td><?php echo $values->unit_name ?></td>
                                                                                <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->price ?>" class="form-control item_price"></td>
                                                                                <td><?php echo amountFormat($values->total);?></td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button>&nbsp;
                                                                                    <button type="button" eq="<?php echo $eq; ?>" class="btn btn-success form_update_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-check"></i></button>

                                                                                </td>


                                                                                <td></td>
                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                            $eq++

                                                                            ; } ?>

                                                                        </tbody>
                                                                    </table>

                                                                    <?php

                                                                }
                                                                else {
                                                                    ?>
                                                                    <div class="mt-2">
                                                                        <h2 style="text-align: center">Zəhmət olmasa material əlavə etməyi unutmayın...</h2>
                                                                    </div>
                                                                    <?php
                                                                }?>
                                                                <div class="text-center">
                                                                    <button  type="button" class="btn btn-primary add_product" demirbas_id="<?php echo $details->demirbas_id ?>" firma_demirbas_id="<?php echo $details->firma_demirbas_id ?>" style="margin: 20px;"><i class="fa fa-plus"></i> Tələb etmək üçün material təyin edin</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else {
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

                                            <?php
                                            $disabled_button='';
                                            if($details->status==9){
                                                $disabled_button='disabled';
                                            }?>
                                            <div class="col col-xs-12 col-sm-12 col-md-12 mb-12">
                                                <div class="row mt-3">
                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget" id="wid-id-7">
                                                            <nav>
                                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                                    <a class="nav-item nav-link <?php  if($details->status==1){ echo "active"; } ?>"   <?php  if($iptal_status==1) { echo $nav_style; } ?> id="nav-talep"       data-toggle="tab" href="#talep" role="tab" aria-controls="nav-home" aria-selected="true">Talep Süreci</a><span class="chevron" <?php  if($iptal_status==1) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php  if($details->status==9){ echo "active"; } ?>"   <?php  if($iptal_status==9) { echo $nav_style; } ?> id="nav-tamamlama"   <?php  if($details->status ==9){ echo 'data-toggle="tab"'; } ?>   href="#tamamlama" role="tab" aria-controls="nav-home" aria-selected="true">İşlem Sonucu</a><span class="chevron" <?php  if($iptal_status==9) { echo $chevron_stye; } ?>></span>

                                                                </div>
                                                            </nav>
                                                            <div class="tab-content px-1 pt-1">
                                                                <div class="tab-pane fade <?php  if($details->status==1){ echo "active show"; } ?>" id="talep" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <?php if($items){  //varsa ?>

                                                                        <table class="table ">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Gider</th>
                                                                                <th>Açıklama</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Fiyat</th>
                                                                                <th>Toplam Tutar</th>
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

                                                                                ?>
                                                                                <tr  id="remove<?php echo $values->id?>">
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $values->name ?></td>
                                                                                    <td><?php echo $values->product_desc ?></td>
                                                                                    <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->product_qty ?>" class="form-control item_qty"></td>
                                                                                    <td><?php echo $values->unit_name ?></td>
                                                                                    <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->price ?>" class="form-control item_price"></td>
                                                                                    <td><?php echo amountFormat($values->total);?></td>
                                                                                    <td>

                                                                                        <button <?php echo $disabled_button;?> type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button>&nbsp;
                                                                                        <button <?php echo $disabled_button;?> type="button" eq="<?php echo $eq; ?>" class="btn btn-success form_update_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-check"></i></button>

                                                                                    </td>


                                                                                    <td></td>
                                                                                </tr>
                                                                                <?php
                                                                                $i++;
                                                                                $eq++

                                                                                ; } ?>
                                                                            </tbody>
                                                                        </table>

                                                                        <?php

                                                                    } ?>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==9){ echo "active show"; } ?>" id="tamamlama" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <?php
                                                                    if($details->alacak_durum){
                                                                        ?>
                                                                        <h3 class="mb-4" style="text-align: center">İşlem Tamamlandı</h3>
                                                                        <?php
                                                                    }
                                                                    else {
                                                                        ?>
                                                                        <div class="col-md-12" style="padding-bottom: 15px;">
                                                                            <?php if($details->method==3){
                                                                                $toplam_tt=0;
                                                                                $text='Ödeme Metodu Banka Olduğu İçin Cari Alacaklanmayacaktır.Ancak Faturalaştırabilirsiniz!';
                                                                            }
                                                                            else {
                                                                                $toplam_tt=$odeme_details['toplam_tutar_float'];
                                                                                $text='CARIYI Alacaklandırmak İstediğinizden Emin Misiniz?';
                                                                            }?>
                                                                            <button <?php echo $disabled_alacak;?> tutar="<?php echo $toplam_tt ?>" text="<?php echo $text; ?>" type="button" eq="<?php echo $eq; ?>" class="btn btn-warning form_customer_bakiye"><i class="fa fa-building"></i> İş Bitir Ve Cari Alacaklandır</button>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        } ?>
                                        <div class="col col-xs-12 col-sm-12 col-md-12 mb-12">
                                            <div class="row mt-3">
                                                <div class="col col-md-4 col-xs-12">
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
                                                </div>

                                                <?php if($details->bildirim_durumu==1){ ?>
                                                    <div class="col col-md-8 col-xs-12">
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

                                                                foreach (talep_onay_customer_new(1,$details->id) as $items) {




                                                                    $durum='-';
                                                                    $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                    if($items->status==1){
                                                                        $durum='Onaylandı';
                                                                        $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                    }
                                                                    if($items->staff==1 && $items->status==0){
                                                                        $durum='Gözləmedə';
                                                                        $button='<button class="btn btn-info onayla" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <!--?php echo roles(role_id($items->user_id))?-->
                                                                        <th>(CZ Onayı)</th>
                                                                        <th><?php echo personel_details($items->user_id)?></th>
                                                                        <th><?php echo $durum;?></th>
                                                                        <th><?php echo $button;?></th>
                                                                    </tr>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if(talep_onay_new(3,$details->id)){
                                                                    foreach (talep_onay_new(2,$details->id) as $items) {
                                                                        $durum='-';
                                                                        $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                        if($items->status==1){
                                                                            $durum='Onaylandı';
                                                                            $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                        }
                                                                        if($items->staff==1 && $items->status==0){
                                                                            $durum='Gözləmedə';
                                                                            $button='<button disabled class="btn btn-info onayla" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Detayları İnceleyin</button>'.$button_dikkat;
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <!--?php echo roles(role_id($items->user_id))?-->
                                                                            <th> (SF Onayı)</th>
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

                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget">
                                                            <header> <h4>Talep Hareketleri</h4></header>

                                                            <?php if(talep_history_customer($details->id,2)){
                                                                ?>
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Vazife</th>
                                                                        <th>Personel Adı</th>
                                                                        <th>Açıklama</th>
                                                                        <th>İşlem Tarihi</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    foreach (talep_history_customer($details->id,2) as $items){

                                                                        $role = roles(role_id($items->user_id));
                                                                        $name = personel_details($items->user_id);
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $role?></td>
                                                                            <td><?php echo $name ?></td>
                                                                            <td><?php echo $items->desc?></td>
                                                                            <td><?php echo $items->created_at?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>

                                                                <hr>
                                                                <?php
                                                            }?>
                                                        </div>
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="col col-md-8 col-xs-12">
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
                                                                                <label class="col-form-label">Cari</label>
                                                                                <select class="form-control select-box" id="cari_id">
                                                                                    <?php foreach (all_customer() as $emp){
                                                                                        $emp_id=$emp->id;
                                                                                        $name=$emp->company;
                                                                                        $selected='';
                                                                                        if($details->id==$emp_id){
                                                                                            $selected='selected';
                                                                                        }
                                                                                        ?>
                                                                                        <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-2 mb-2">
                                                                                <label class="col-form-label">Ödeme Metodu</label>
                                                                                <select class="form-control select-box" id="method">
                                                                                    <?php foreach (account_type() as $emp){
                                                                                        $emp_id=$emp['id'];
                                                                                        $name=$emp['name'];
                                                                                        $selected='';
                                                                                        if($details->method==$emp_id){
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
                                                                            <div class="col-md-12 mb-2">
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
                                                    <?php
                                                }
                                                ?>


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


<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>app-assets/talep.css">
<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>app-assets/wizard.css">

<script>
    var url = '<?php echo base_url() ?>caricezatalep/file_handling';
    $(document).on('click','.form_update',function (){
        let file_id =$(this).attr('file_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'SORĞUNUN Düzenlenmesi',
            icon: 'fa fa-pen',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Güncellemek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            file_id:$('#talep_id').val(),
                            desc:$('#desc').val(),
                            proje_id:$('#proje_id').val(),
                            method:$('#method').val(),
                            cari_id:$('#cari_id').val(),
                            progress_status_id:$('#progress_status_id').val(),
                            talep_eden_user_id:$('#talep_eden_user_id').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'caricezatalep/update_form',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Düzenlendi!',
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
    $(document).on('click','.new_file',function (){
        let talep_id =$('#talep_id').val();
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yəni Fayl',
            icon: 'fa fa-file',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:` <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Fayl</label>
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
            <input id="fileupload_update" type="file" name="files[]">

            <input type="hidden" class="image_text_update" name="image_text_update" id="image_text_update">
      </div>
</form>`,
            buttons: {
                formSubmit: {
                    text: 'Yükle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            talep_id:  talep_id,
                            image_text:  $('#image_text_update').val(),
                        }
                        $.post(baseurl + 'caricezatalep/upload_file',data,(response) => {
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
                                                location.reload()
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


                $('#fileupload_update').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_update').val(img);
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
    $(document).on('click','.delete_file',function (){
        let file_id =$(this).attr('file_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Silmek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let job_id = [];
                        $('.one_select:checked').each((index,item) => {
                            job_id.push($(item).attr('id'));
                        });
                        let data = {
                            file_id:file_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'caricezatalep/delete_file',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Silindi Edildi!',
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
    $(document).on('click','.add_product',function (){

        let firma_demirbas_id = $(this).attr('firma_demirbas_id');
        let demirbas_id = $(this).attr('demirbas_id');
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
                                                            <th>Tutar</th>
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
                                                            <td><input type='numaric' class='form-control' name='product_qty'></td>
                                                            <td><input type='numaric' class='form-control' name='product_price'>
                                                            <td><button type='button' class='btn btn-success add_items'><i class='fa fa-plus'></td>

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

    $(document).on('click','.add_items',function (){
        $('#loading-box').removeClass('d-none');
        $.post(baseurl + 'caricezatalep/create_form_items',$('#data_form').serialize(),(response)=>{
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
                let data = {
                    keyword:keyword,
                    crsf_token: crsf_hash,
                }
                $.post(baseurl + 'caricezatalep/search_products',data,(response)=>{
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
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
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
                                                    <td><input class="product_qty form-control" value="1"></td>
                                                    <td><input class="product_price form-control" value="0"></td>
                                                    <td><button eq='`+index+`'class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
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

            }
        }
        else {
            $('#loading-box').removeClass('d-none');
            let cat_id = parseInt($('#category_id').val())
            let data = {
                cat_id:cat_id,
                keyword:keyword,
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'caricezatalep/search_products',data,(response)=>{
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
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
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
                                                    <td><input class="product_qty form-control" value="1"></td>
                                                    <td><input class="product_price form-control" value="1"></td>
                                                    <td><button eq='`+index+`'class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
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

        }
    })

    $(document).on('click','.form_add_products',function (){
        let eq = $(this).attr('eq');
        let data = {
            product_id:$('.product_id').eq(eq).val(),
            product_desc:$('.product_desc').eq(eq).val(),
            product_kullanim_yeri:$('.product_kullanim_yeri').eq(eq).val(),
            product_temin_date:$('.product_temin_date').eq(eq).val(),
            progress_status_id:$('.progress_status_id').eq(eq).val(),
            unit_id:$('.unit_id').eq(eq).val(),
            product_qty:$('.product_qty').eq(eq).val(),
            product_price:$('.product_price').eq(eq).val(),
            form_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'caricezatalep/create_form_items',data,(response)=>{
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
                                let table=`<tr  id="remove`+responses.talep_form_products_id+`" >
                                                    <td><p>`+responses.product_name+`</p></td>
                                                    <td>`+responses.qyt_birim+`</td>
                                                    <td><button item_id='`+responses.talep_form_products_id+`' type_="2" class="btn btn-danger btn-sm form_remove_products" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                                $('.table_create_products tbody').append(table);
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


    $(document).on('click','.form_remove_products',function (){
        let item_id =$(this).attr('item_id');
        let durum =$(this).attr('durum');
        let type = $(this).attr('type_');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Silmek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            item_id:item_id,
                            type:type,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'caricezatalep/delete_item_form',data,(response)=>{
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
                                                let remove = '#remove'+ item_id
                                                $(remove).remove();
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
    $(document).on('click','.form_update_products',function (){
        let item_id =$(this).attr('item_id');
        let durum =$(this).attr('durum');
        let type = $(this).attr('type_');
        let eq = $(this).attr('eq');

        let item_price = $('.item_price').eq(eq).val();
        let item_qty = $('.item_qty').eq(eq).val();

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Bu Satırı Güncellemek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            item_id:item_id,
                            type:type,
                            item_price:item_price,
                            item_qty:item_qty,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'caricezatalep/update_item_form',data,(response)=>{
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
                                                //let remove = '#remove'+ item_id
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

    $(document).on('click','.form_customer_bakiye',function (){
        //content:`<form action="" class="formName">
        //    <div class="form-group">
        //    <p>Cariyi Alacaklandırmak İstediğinizden Emin Misiniz?<p/>
        //    <input class="form-control alacak_tutar" value="`+tutar+`">
        //     </div>
        //       <div class="form-group">
        //    <input class="form-control not" placeholder='Açıklama'>
        //    </div>
        //    <div class="form-group">
        //    <select class="form-control account_id">
        //    <option value="0">Kasa Seçiniz</option>
        //    <?php //foreach (personel_account($this->aauth->get_user()->id) as $emp) {
        //        $emp_id = $emp['id'];
        //        $name = $emp['holder'];
        //        $selected = '';
        //        echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        //    }
        //    ?>
        //    </selected>
        //    </div>
        //    </form>`,
        let tutar =$(this).attr('tutar');
        let text =$(this).attr('text');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName">
                <div class="form-group">
                <p>`+text+`<p/>
                <input class="form-control alacak_tutar" type="number" value="`+tutar+`" max='`+tutar+`' onkeyup="amount_max(this)" >
                 </div>
                   <div class="form-group">
                <input class="form-control not" placeholder='Açıklama'>
                </div>
                </div>
                </form>`,

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let account_id = $('.account_id').val();
                        // if(!parseInt(account_id)){
                        //     $.alert({
                        //         theme: 'material',
                        //         icon: 'fa fa-exclamation',
                        //         type: 'red',
                        //         animation: 'scale',
                        //         useBootstrap: true,
                        //         columnClass: "col-md-4 mx-auto",
                        //         title: 'Dikkat!',
                        //         content:'Kasa Seçmek Zorunludur',
                        //         buttons:{
                        //             prev: {
                        //                 text: 'Tamam',
                        //                 btnClass: "btn btn-link text-dark",
                        //             }
                        //         }
                        //     });
                        //     return false;
                        // }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            talep_id:$('#talep_id').val(),
                            // account_id:$('.account_id').val(),
                            alacak_tutar:$('.alacak_tutar').val(),
                            not:$('.not').val(),
                        }
                        $.post(baseurl + 'caricezatalep/customer_alacak_update',data,(response)=>{
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
                                                //let remove = '#remove'+ item_id
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

    $(document).on('click','.form_transaction_payment',function (){

        let tutar =$(this).attr('tutar');
        let tip =$(this).attr('tip');
        let cont = `<form action="" class="formName">
            <div class="form-group">
            <p>Cariye Ödeme Yapmak İstediğinizden Emin Misiniz?<p/>
            <input class="form-control alacak_tutar"  type="number" value="`+tutar+`"  max='`+tutar+`'onkeyup="amount_max(this)">
             </div>
               <div class="form-group">
            <input class="form-control not" placeholder='Açıklama'>
            </div>
            </div>
               <div class="form-group">
            <select class="form-control cach_personel select-box">
                <option value="0">Parayı Verdiğiniz Personel</option>
                <?php foreach (all_personel() as $emp) {
            $emp_id = $emp->id;
            $name = $emp->name;
            $selected = '';
            echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        }
        ?>
                </select>
            </div>
            <div class="form-group">
            <select class="form-control account_id">
            <option value="0">Kasa Seçiniz</option>
            <?php foreach (personel_account($this->aauth->get_user()->id) as $emp) {
            $emp_id = $emp['id'];
            $name = $emp['holder'];
            $selected = '';
            echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        }
        ?>
            </select>
            </div>
            </form>`;
        if(tip=='tamamlama'){
            cont = `<form action="" class="formName">
            <div class="form-group">
            <p>Bir Sonraki Aşamaya Geçilecek Emin Misiniz?<p/>
           <input class="form-control account_id"  type="hidden" value="0">
           <input class="form-control account_id"  type="hidden" value="0">
           <input class="form-control not"  type="hidden" value="0">
            </div>
            </form>`;
        }
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:cont,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let account_id = $('.account_id').val();
                        if(tip!='tamamlama'){
                            if(!parseInt(account_id)){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content:'Kasa Seçmek Zorunludur',
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

                        $('#loading-box').removeClass('d-none');
                        let data = {
                            tip:tip,
                            talep_id:$('#talep_id').val(),
                            account_id:$('.account_id').val(),
                            cach_personel:$('.cach_personel').val(),
                            alacak_tutar:$('.alacak_tutar').val(),
                            not:$('.not').val(),
                        }
                        $.post(baseurl + 'caricezatalep/customer_payment_update',data,(response)=>{
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
                                                //let remove = '#remove'+ item_id
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

    $(document).on('click','.form_update_payment',function (){
        let personel_id = $('.pay_personel_id').val();
        if(parseInt(personel_id)){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Bu Formu Güncellemek İStediğinizden Emin Misiniz?<p/>'+
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:$('#talep_id').val(),
                                personel_id:personel_id,
                            }
                            $.post(baseurl + 'caricezatalep/update_form_payment',data,(response)=>{
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
                                                    //let remove = '#remove'+ item_id
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
                content: 'Ödeme Yapacak Personel Seçmek Zorundasınız',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }

    })

    $(document).on('click','.bildirim_olustur',function (){
        let talep_id = $('#talep_id').val();
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-bell',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Bildirimi Başlatmak Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            talep_id:talep_id,
                            type:1,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'caricezatalep/form_bildirim_olustur',data,(response)=>{
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

    $(document).on('click','.onayla',function (){
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
                <p>Onaylamak Üzeresiniz Emin Misiniz?<p/>
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
                            let count = $('.item_qty').length;
                            for (let i=0; i<count; i++) {
                                product_details.push({
                                    'item_id':$('.item_qty').eq(i).attr('item_id'),
                                    'item_qty':$('.item_qty').eq(i).val(),
                                    'item_price':$('.item_price').eq(i).val(),
                                });
                            }
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:talep_id,
                                progress_status_id:$('#progress_status_id').val(),
                                product_details:product_details,
                                type:1,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'caricezatalep/onay_olustur',data,(response)=>{
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
                '<p><b>Bu İşleme Ait Qaime,Ödeme ve Gider Hareketleri Var İse İptal Olacaktır</b><p/>' +
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
                        $.post(baseurl + 'caricezatalep/status_upda',data,(response) => {
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

    })
    $(document).on('click', ".talep_kapat", function (e) {
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
                '<p>Talep Kapatmak İstediğinizden Emin Misiniz?<p/>' +
                '<p><b>Kapatma Sebebi Girmeniz Gerekmektedir</b><p/>' +
                '<input type="text" id="desc" class="form-control desc" placeholder="Kapatma Sebebi">' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Kapat',
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
                                content: 'Kapatma Sebebi Zorunludur',
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
                            status:  9
                        }
                        $.post(baseurl + 'caricezatalep/status_upda',data,(response) => {
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

    })


    $(document).on('click', ".gider_isle", function (e) {
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
                '<p>Gider Kalemlerine İşlenecek Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İşle',
                    btnClass: 'btn-blue',
                    action: function () {

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            file_id:  talep_id,
                            type:  1
                        }
                        $.post(baseurl + 'demirbas/gider_create_form',data,(response) => {
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

    })

    $(document).on('click', ".invoice_isle", function (e) {
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
                '<p>Gider Faturası Oluşturulacak Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İşle',
                    btnClass: 'btn-blue',
                    action: function () {

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            file_id:  talep_id,
                            type:  4
                        }
                        $.post(baseurl + 'demirbas/gider_create_form',data,(response) => {
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
                        $.post(baseurl + 'caricezatalep/status_upda',data,(response) => {
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
                'url': "<?php echo site_url('caricezatalep/ajax_list_notes')?>",
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
                                        $.post(baseurl + 'caricezatalep/create_save_notes',data,(response) => {
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
                        $.post(baseurl + 'caricezatalep/notes_delete',data,(response) => {
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

    function amount_max(element){
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }

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

</script>

