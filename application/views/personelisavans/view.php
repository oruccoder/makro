<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Avans Talebi Görüntüle</span></h4>
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
                                                        <a href="/personelavanstalep" class="btn btn-warning"><i class="fa fa-arrow-left"></i> İstək siyahısı</a>
                                                        <button type="button" class="btn btn-info talep_notes" talep_id="<?php echo $details->id ?>"><i class="fa fa-reply"></i> Talep Hakkında Notlar</button>
                                                        <button type="button" class="btn btn-danger talep_sil" talep_id="<?php echo $details->id ?>" ><i class="fa fa-ban"></i> Talep İptal Et</button>

                                                        <button type="button" class="btn btn-success talep_kapat" talep_id="<?php echo $details->id ?>" ><i class="fa fa-check"></i> Talep Kapat</button>

                                                        <button  tutar="<?php echo $kalan ?>"   type="button" tip="muhasebe"  class="btn btn-success form_transaction_payment"><i class="fa fa-money-bill"></i></button>

                                                        <button  islem_tipi="5" islem_id="<?php echo $details->id ?>" type="button" class="btn btn-success  add_not_new">Not Ekle</button>
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
                                                        <div class="col col-xs-12 col-sm-12 col-md-12 no-padding">
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
                                                                        <td class="vert-align-mid" ><span class=" txt-color-darken no-padding"> Personel: </span></td>
                                                                        <td class="vert-align-mid" colspan="2">
                                                                            <span class=" txt-color-darken no-padding no-margin"><b><?php echo personel_details_full($details->personel_id)['name']?></b></span>
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
                                                                                <?php echo talep_odemeler($details->id); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="vert-align-mid"><span class=" txt-color-darken no-padding">Talep Eden: </span></td>
                                                                        <td class="vert-align-mid" colspan="2">
                                                                            <span class=" txt-color-darken no-padding no-margin"><b><?php echo personel_details($details->talep_eden_user_id)?></b></span>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
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
                                                                            <th>Tanım</th>
                                                                            <th>Miktar</th>
                                                                            <th>Birim</th>
                                                                            <th>Fiyat</th>
                                                                            <th>Toplam Tutar</th>
                                                                            <th>Temin Tarihi</button></th>
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

                                                                            $tutar = personelavans_item_kontrol($details->talep_eden_user_id)['tutar'];
                                                                            if($tutar<$values->total){
                                                                                $style='style="
    text-align: center;
    font-weight: 800;font-size: 16px;background-color: #940000db;color: white;"';
                                                                               echo "<tr><td colspan='11' ".$style.">Bu talepte Tutar Değişikliği Olmuştur</td></tr>";
                                                                            }


                                                                            ?>
                                                                            <tr  id="remove<?php echo $values->id?>">
                                                                                <td><?php echo $i ?></td>
                                                                                <td><?php echo $values->name ?></td>
                                                                                <td><?php echo $values->product_desc ?></td>
                                                                                <td><?php echo $values->product_kullanim_yeri ?></td>
                                                                                <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->product_qty ?>" class="form-control item_qty"></td>
                                                                                <td><?php echo $values->unit_name ?></td>
                                                                                <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->price ?>" class="form-control item_price"></td>
                                                                                <td><?php echo amountFormat($values->total);?></td>
                                                                                <td><?php echo dateformat_new($values->product_temin_date) ?></td>
                                                                                <td><?php echo progress_status_details($values->progress_status_id)->name;?></td>
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
<!--                                                                <div class="text-center">-->
<!--                                                                    <button  type="button" class="btn btn-primary add_product" style="margin: 20px;"><i class="fa fa-plus"></i> Tələb etmək üçün material təyin edin</button>-->
<!--                                                                </div>-->
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
                                                                    <a class="nav-item nav-link <?php  if($details->status==1){ echo "active"; } ?>"   <?php  if($iptal_status==1) { echo $nav_style; } ?> id="nav-talep" data-toggle="tab" href="#talep" role="tab" aria-controls="nav-home" aria-selected="true">Talep Süreci</a><span class="chevron" <?php  if($iptal_status==1) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php  if($details->status==11){ echo "active"; } ?>"   <?php  if($iptal_status==11) { echo $nav_style; } ?> id="nav-techizat"  <?php  if($details->status >=11){ echo 'data-toggle="tab"'; } ?>  href="#techizat" role="tab" aria-controls="nav-home" aria-selected="true">Ödeme Süreci</a><span class="chevron" <?php  if($iptal_status==11) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php  if($details->status==12){ echo "active"; } ?>"   <?php  if($iptal_status==12) { echo $nav_style; } ?> id="nav-odeme"     <?php  if($details->status >=12){ echo 'data-toggle="tab"'; } ?>  href="#odeme" role="tab" aria-controls="nav-home" aria-selected="true">Ödeme Ekranı</a><span class="chevron" <?php  if($iptal_status==12) { echo $chevron_stye; } ?>></span>
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
                                                                                <th>Tanım</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Fiyat</th>
                                                                                <th>Toplam Tutar</th>
                                                                                <th>Temin Tarihi</button></th>
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

                                                                                ?>
                                                                                <tr  id="remove<?php echo $values->id?>">
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $values->name ?></td>
                                                                                    <td><?php echo $values->product_desc ?></td>
                                                                                    <td><?php echo $values->product_kullanim_yeri ?></td>
                                                                                    <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->product_qty ?>" class="form-control item_qty"></td>
                                                                                    <td><?php echo $values->unit_name ?></td>
                                                                                    <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->price ?>" class="form-control item_price"></td>
                                                                                    <td><?php echo amountFormat($values->total);?></td>
                                                                                    <td><?php echo dateformat_new($values->product_temin_date) ?></td>
                                                                                    <td><?php echo progress_status_details($values->progress_status_id)->name;?></td>
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
                                                                <div class="tab-pane fade <?php  if($details->status==11){ echo "active show"; } ?>" id="techizat" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Personel</th>
                                                                            <th>Toplam Tutar</th>
                                                                            <th>Ödeme Yapacak Personel</th>
                                                                            <th>İşlem</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><?php echo $odeme_details['cari'] ?></td>
                                                                            <td><?php echo $odeme_details['toplam_tutar'] ?></td>
                                                                            <td><select class="form-control select-box pay_personel_id">
                                                                                    <option value="0">Seçiniz</option>
                                                                                    <?php foreach (account_personel() as $emp){
                                                                                        $emp_id=$emp->id;
                                                                                        $name=$emp->name;
                                                                                        $selected='';
                                                                                        if($details->payment_personel_id){
                                                                                            if($details->payment_personel_id==$emp_id){
                                                                                                $selected='selected';
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <option <?php echo $selected;?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <button <?php echo $disabled_button?> type="button" eq="<?php echo $eq; ?>" class="btn btn-success form_update_payment"><i class="fa fa-check"></i></button>
                                                                            </td>
                                                                        </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==12){ echo "active show"; } ?>" id="odeme" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Personel</th>
                                                                            <th>Toplam Tutar</th>
                                                                            <th>İşlem</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><?php echo $odeme_details['cari'] ?></td>
                                                                            <td><?php echo $odeme_details['toplam_tutar'] ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $disabled_odeme='';

                                                                                if($details->odeme_durum){
                                                                                    $disabled_odeme = 'disabled';
                                                                                }

                                                                                ?>
                                                                                <button <?php echo $disabled_odeme;?> tutar="<?php echo $odeme_details['toplam_tutar_float'] ?>"  type="button" eq="<?php echo $eq; ?>" tip="odeme" class="btn btn-success form_transaction_payment"><i class="fa fa-check"></i></button>
                                                                            </td>
                                                                        </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==9){ echo "active show"; } ?>" id="tamamlama" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <h3 class="mb-4" style="text-align: center">İşlem Tamamlandı</h3>
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

                                                                foreach (talep_onay_personel_new(1,$details->id) as $items) {
                                                                    $durum='-';
                                                                    $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                    if($items->status==1){
                                                                        $durum='Onaylandı';
                                                                        $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                    }
                                                                    if($items->staff==1 && $items->status==0){
                                                                        $durum='Gözləmedə';
                                                                        $button='<button class="btn btn-info onayla" aauth_sort_id = "'.$items->id.'" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <!--?php echo roles(role_id($items->user_id))?-->
                                                                        <th>(P-AT Onayı)</th>
                                                                        <th><?php echo personel_details($items->user_id)?></th>
                                                                        <th><?php echo $durum;?></th>
                                                                        <th><?php echo $button;?></th>
                                                                    </tr>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if(talep_onay_new(2,$details->id)){ //   if(talep_onay_new(3,$details->id)){
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
                                                                                <label class="col-form-label">Personel</label>
                                                                                <select class="form-control select-box" id="personel_id">
                                                                                    <?php foreach (all_personel() as $emp){
                                                                                        $emp_id=$emp->id;
                                                                                        $name=$emp->name;
                                                                                        $selected='';
                                                                                        if($details->personel_id==$emp_id){
                                                                                            $selected='selected';
                                                                                        }
                                                                                        ?>
                                                                                        <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3 mb-2">
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

                                                                            <div class="col-md-3 mb-2">
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
                                                <div class="col col-md-12 col-xs-12">
                                                    <div class="jarviswidget">
                                                        <header> <h4>Talep Hareketleri</h4></header>

                                                        <?php if(talep_history_personel($details->id)){
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
                                                                foreach (talep_history_personel($details->id) as $items){

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
    var url = '<?php echo base_url() ?>personelavanstalep/file_handling';
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
                            personel_id:$('#personel_id').val(),
                            progress_status_id:$('#progress_status_id').val(),
                            talep_eden_user_id:$('#personel_id').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'personelavanstalep/update_form',data,(response)=>{
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
                        $.post(baseurl + 'personelavanstalep/upload_file',data,(response) => {
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
                        $.post(baseurl + 'personelavanstalep/delete_file',data,(response)=>{
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
        let file_id =$(this).attr('file_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Talebe Gider Kalemi Atama',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-8 col-md-8">
                        <div class="jarviswidget">
                            <header><h4>Gider Listesi Arama Alanı</h4></header>
                            <div class="borderedccc">
                                <div class="widget-body">
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <fieldset>
                                            <div class="row mb-2">
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Kategori Bazlı Ara</label>
                                                    <select class="form-control select-box" id="category_id">
                                                    <option value='0'>Seçiniz</option>
                                                            <?php
            foreach (all_ana_masraf() as $row) {
                $cid = $row->id;
                $title = $row->name;
                echo "<option value='$cid'>$title</option>";
            }
            ?>
                                                    </select>
                                                </section>
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Gider Adı</label>
                                                    <input type="texy" placeholder="Min 3 karakter veya Kategori Seçini" class="form-control" id="search_name">
                                                </section>
                                            </div>
                                            <div class="row mb-2">
                                                <section class="col col-sm-12 col-md-12">
                                                    <button class="btn btn-info" id="search_button"><i class="fa fa-search"></i>&nbsp;Ara</button>
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
                            <header><h4>Atanan Giderler (<?php echo proje_code($details->proje_id)?>)</h4></header>
                            <table class="table table_create_products">
                                <thead>
                                    <tr>
                                        <th>Malzeme</th>
                                        <th>Miktar</th>
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
                            <header><h4>Giderler</h4></header>
                            <table class="table table_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Gider</th>
                                        <th>Açıklama</th>
                                        <th>Tanım</th>
                                        <th>Temin Tarihi  &nbsp;<button class="temin_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Aciliyet Durumu &nbsp;<button class="aciliyet_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Birim &nbsp;<button class="birim_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Miktar</th>
                                        <th>Tutar</th>
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
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
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
                    crsf_token: crsf_hash,
                }
                $.post(baseurl + 'personelavanstalep/search_products',data,(response)=>{
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
            $.post(baseurl + 'personelavanstalep/search_products',data,(response)=>{
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
        $.post(baseurl + 'personelavanstalep/create_form_items',data,(response)=>{
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
                        $.post(baseurl + 'personelavanstalep/delete_item_form',data,(response)=>{
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
                        $.post(baseurl + 'personelavanstalep/update_item_form',data,(response)=>{
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
            <p>Personelin Maaş Avans Ödemesini Yapmak İstediğinizden Emin Misiniz?<p/>
            <input class="form-control alacak_tutar" value="`+tutar+`">
             </div>
               <div class="form-group">
            <input class="form-control not" placeholder='Açıklama'>
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
            </selected>
            </div>
            </form>`,

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let account_id = $('.account_id').val();
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
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            talep_id:$('#talep_id').val(),
                            account_id:$('.account_id').val(),
                            alacak_tutar:$('.alacak_tutar').val(),
                            not:$('.not').val(),
                            tip:tip
                        }
                        $.post(baseurl + 'personelavanstalep/customer_payment_update',data,(response)=>{
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
                            $.post(baseurl + 'personelavanstalep/update_form_payment',data,(response)=>{
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
                        $.post(baseurl + 'personelavanstalep/form_bildirim_olustur',data,(response)=>{
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
        let aauth_sort_id  = $(this).attr('aauth_sort_id');
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
                <p>Durum Bildirmek Üzeresiniz Emin Misiniz?<p/>
                <div class="form-group ">
                            <select class="form-control" id="status">
                               <option value="1">Onayla</option>
                               <option value="0">İptal Et</option>
                               <option value="-1">Talebi Geri Gönder</option>
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
                        text: 'Güncelle',
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
                                status:$('#status').val(),
                                $desc:$('#desc').val(),
                                product_details:product_details,
                                aauth_sort_id:aauth_sort_id,
                                type:1,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'personelavanstalep/onay_olustur',data,(response)=>{
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
                        $.post(baseurl + 'personelavanstalep/status_upda',data,(response) => {
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
                        $.post(baseurl + 'personelavanstalep/status_upda',data,(response) => {
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


