<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Nakliye Talebi Görüntüle</span></h4>
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
                                                      <a href="/nakliye" class="btn btn-secondary" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İstek Siyahısı"><i class="fa fa-arrow-left"></i></a>

                                                        <a target="_blank" href="/nakliye/print/<?php echo $details->id ?>" class="btn btn-secondary" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Yazdır"><i class="fa fa-print"></i> </a>
                                                        <button type="button" class="btn btn-secondary talep_notes" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep Hakkında Notlar"><i class="fa fa-list"></i> </button>
                                                        <?php if($details->status==10){
                                                            ?>
                                                            <button type="button" class="btn btn-secondary talep_reverse" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal İşlemini Geri Al"><i class="fa fa-reply"></i> </button>

                                                            <?php

                                                        } else {

                                                            ?>
                                                            <button type="button" class="btn btn-danger talep_sil" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep İptal Et"><i class="fa fa-ban"></i> </button>

                                                            <?php
                                                        } ?>

                                                        <button type="button" class="btn btn-secondary talep_kapat" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep Kapat"><i class="fa fa-check"></i> </button>

                                                        <button  tutar="<?php echo $kalan ?>"   type="button" tip="muhasebe" talep_id="<?php echo $details->id ?>"  class="btn btn-secondary form_transaction_payment" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Ödeme Yap"><i class="fa fa-money-bill"></i></button>

                                                        <button  type="button" class="btn btn-secondary button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="7" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
                                                        <button  type="button" class="btn btn-secondary button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="7" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>
                                                        <button  type="button" class="btn btn-secondary button_qaime" islem_id="<?php echo $details->id ?>" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Qaime Oluştur"><i class="fa fa-file-alt"></i></button>



                                                        <?php if($items){  //varsa ?>
                                                            <?php if($details->bildirim_durumu==0){
                                                                if($details->status!=10){
                                                                    echo '<button class="btn btn-secondary bildirim_olustur" type="1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Bildirim Başlat"><i class="fa fa-bell"></i></button>';
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


<!--                                                                        <tr>-->
<!--                                                                            <td class="vert-align-mid" ><span class=" txt-color-darken no-padding"> Cari: </span></td>-->
<!--                                                                            <td class="vert-align-mid" colspan="2">-->
<!--                                                                                <span class=" txt-color-darken no-padding no-margin"><b>--><?php //echo customer_details($details->cari_id)['company']?><!--</b></span>-->
<!--                                                                            </td>-->
<!--                                                                            <td class="vert-align-mid" ><span class=" txt-color-darken no-padding">Ödeme Metodu: </span></td>-->
<!--                                                                            <td class="vert-align-mid">-->
<!--                                                                                <span class=" txt-color-darken no-padding no-margin"><b>--><?php //echo account_type_sorgu($details->method)?><!--</b></span>-->
<!--                                                                            </td>-->
<!--                                                                        </tr>-->

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
<!--                                                                                    --><?php //echo talep_qaime($details->id); ?>
                                                                                </span>
                                                                            </td>

                                                                            <td class="vert-align-mid"><span class=" txt-color-darken no-padding dgt_relatedPersons">Ödemeler</span></td>
                                                                            <td class="vert-align-mid" colspan="2">
                                                                                <span class=" txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                    <?php echo talep_odemeler_nakliye($details->id,1); ?>
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
                                                            <div class="col col-xs-2 col-sm-2 col-md-2 no-padding">
                                                                <div class="table-responsive">
                                                                    <?php echo pay_images_nakliye($details->id); ?>
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
                                                                            <th>Kod</th>
                                                                            <th>Lokasyon</th>
                                                                            <th>Yükleme Yapacak Firma / Sorumlu Personel</th>
                                                                            <th>Talep Tipi</th>
                                                                            <th>Açıklama</th>
<!--                                                                            <th>Miktar</th>-->
<!--                                                                            <th>Birim</th>-->
<!--                                                                            <th>Fiyat</th>-->
<!--                                                                            <th>Toplam Tutar</th>-->
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
                                                                                <td><?php echo $values->code ?></td>
                                                                                <td><?php echo $values->lokasyon ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($values->cari_pers_type == 1) {
                                                                                        echo customer_details($values->yukleme_yapacak_cari_id)['company'];
                                                                                    } elseif ($values->cari_pers_type == 2) {
                                                                                        echo personel_details($values->yukleme_yapacak_cari_id);
                                                                                    } else {
                                                                                        echo "Bilinmeyen Tip";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                <span style="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['style'] ?>" class="txt-color-darken no-padding " data-html="true" data-popup="popover" title="" data-trigger="hover" data-content="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['messages'] ?>" data-original-title="Talep Tipi"><b><?php echo nakliye_item_tip_who($values->nakliye_item_tip)['name'] ?></b></span>
                                                                                </td>
</td>
                                                                                <td><?php echo $values->product_desc ?></td>
<!--                                                                                <td><input  eq="--><?php //echo $eq ?><!--" item_id="--><?php //echo $values->id?><!--" type="number" value="--><?php //echo $values->product_qty ?><!--" class="form-control item_qty"></td>-->
<!--                                                                                <td>--><?php //echo $values->unit_name ?><!--</td>-->
<!--                                                                                <td><input  eq="--><?php //echo $eq ?><!--" item_id="--><?php //echo $values->id?><!--" type="number" value="--><?php //echo $values->price ?><!--" class="form-control item_price"></td>-->
<!--                                                                                <td>--><?php //echo amountFormat($values->total);?><!--</td>-->
                                                                                <td>
                                                                                    <button type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button>&nbsp;
                                                                                    <button type="button" eq="<?php echo $eq; ?>" class="btn btn-success form_update_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-check"></i></button>

                                                                                    <?php
                                                                                    echo nakliye_item_button($values->nakliye_item_tip,$values->id,$details->id);

                                                                                    ?>

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
                                                                }
                                                                $disable_add_button='';
                                                                if($details->bildirim_durumu!=0){
                                                                    $disable_add_button='disabled';
                                                                }
                                                                ?>


                                                                <div class="text-center">
                                                                    <button  type="button" <?php echo $disable_add_button;?>  class="btn btn-primary add_product" demirbas_id="<?php echo $details->demirbas_id ?>" firma_demirbas_id="<?php echo $details->firma_demirbas_id ?>" style="margin: 20px;"><i class="fa fa-plus"></i> Tələb etmək üçün material təyin edin</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                        else {
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
                                                                    <a class="nav-item nav-link <?php  if($details->status==3){ echo "active"; } ?>"   <?php  if($iptal_status==3) { echo $nav_style; } ?> id="nav-teklif"       data-toggle="tab" href="#teklif" role="tab" aria-controls="nav-home" aria-selected="true">Teklif</a><span class="chevron" <?php  if($iptal_status==1) { echo $chevron_stye; } ?>></span>
                                                                    <a class="nav-item nav-link <?php  if($details->status==5){ echo "active"; } ?> "  <?php  if($iptal_status==5) { echo $nav_style; } ?> id="nav-siparis" <?php  if($details->status >= 5){ echo 'data-toggle="tab"'; } ?>  href="#siparis" role="tab" aria-controls="nav-contact" aria-selected="false">İşlemler</a>
                                                                    <a class="nav-item nav-link" id="nav-siparis" data-toggle="tab"  href="#giderler" role="tab" aria-controls="nav-contact" aria-selected="false">Giderler</a>
                                                                    <a class="nav-item nav-link" id="nav-siparis" data-toggle="tab"  href="#cezalar" role="tab" aria-controls="nav-contact" aria-selected="false">Cezalar</a>
                                                                </div>
                                                            </nav>
                                                            <div class="tab-content px-1 pt-1">
                                                                <div class="tab-pane fade <?php  if($details->status==1){ echo "active show"; } ?>" id="talep" role="tabpanel" aria-labelledby="active-tab" aria-expanded="true">
                                                                    <?php if($items){  //varsa ?>

                                                                        <table class="table ">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Kod</th>
                                                                                <th>Lokasyon</th>
                                                                                <th>Yükleme Yapacak Firma</th>
                                                                                <th>Talep Tipi</th>
                                                                                <th>Açıklama</th>
                                                                                <!--                                                                            <th>Miktar</th>-->
                                                                                <!--                                                                            <th>Birim</th>-->
                                                                                <!--                                                                            <th>Fiyat</th>-->
                                                                                <!--                                                                            <th>Toplam Tutar</th>-->
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
                                                                                    <td><?php echo $values->code ?></td>
                                                                                    <td><?php echo $values->lokasyon ?></td>
                                                                                    <td><?php echo customer_details($values->yukleme_yapacak_cari_id)['company'] ?></td>
                                                                                    <!--                                                                                <td>--><?php //echo account_type_sorgu($values->method) ?><!--</td>-->
                                                                                    <td>
                                                                                        <span style="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['style'] ?>" class="txt-color-darken no-padding " data-html="true" data-popup="popover" title="" data-trigger="hover" data-content="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['messages'] ?>" data-original-title="Talep Tipi"><b><?php echo nakliye_item_tip_who($values->nakliye_item_tip)['name'] ?></b></span>

                                                                                    </td>
                                                                                    <td><?php echo $values->product_desc ?></td>
                                                                                    <!--                                                                                <td><input  eq="--><?php //echo $eq ?><!--" item_id="--><?php //echo $values->id?><!--" type="number" value="--><?php //echo $values->product_qty ?><!--" class="form-control item_qty"></td>-->
                                                                                    <!--                                                                                <td>--><?php //echo $values->unit_name ?><!--</td>-->
                                                                                    <!--                                                                                <td><input  eq="--><?php //echo $eq ?><!--" item_id="--><?php //echo $values->id?><!--" type="number" value="--><?php //echo $values->price ?><!--" class="form-control item_price"></td>-->
                                                                                    <!--                                                                                <td>--><?php //echo amountFormat($values->total);?><!--</td>-->
                                                                                    <td>
                                                                                        <button type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button>&nbsp;
                                                                                        <button type="button" eq="<?php echo $eq; ?>" class="btn btn-success form_update_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-check"></i></button>

                                                                                        <?php
                                                                                        echo nakliye_item_button($values->nakliye_item_tip,$values->id,$details->id);

                                                                                        ?>

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
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==3){ echo "active show"; } ?>" id="teklif" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                                    <?php if($items){  //varsa ?>

                                                                        <table class="table ">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Kod</th>
                                                                                <th width="12%">Yükleme Yapacak Firma</th>
                                                                                <th width="7%">Cari</th>
                                                                                <th width="7%">Araç</th>
                                                                                <th>Lokasyon</th>
                                                                                <th>Tip</th>
                                                                                <th>Detaylar</th>
                                                                                <th>Açıklama</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Fiyat</th>
                                                                                <th>Toplam Tutar</th>
                                                                                <th>Method</th>
                                                                                <th>İşlem</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $i=1;
                                                                            $eq=0;

                                                                            if($details->bildirim_durumu ){
                                                                                $disabled='disabled';
                                                                            }
                                                                            foreach ($items as $values) {

                                                                                $disabled_button='';
                                                                                if($values->status!=5){
                                                                                    $disabled_button='disabled';
                                                                                }

                                                                                ?>
                                                                                <tr  id="remove<?php echo $values->id?>">
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $values->code ?></td>

                                                                                    <td>
                                                                                        <?php
                                                                                        if ($values->cari_pers_type == 1) {
                                                                                            ?>

                                                                                            <select class='form-control select-box yukleme_yapacak_cari_id'>
                                                                                                <option value='0'>Cari Seçiniz</option>
                                                                                                <?php foreach (all_customer() as $customer_item){
                                                                                                    $id=$customer_item->id;
                                                                                                    $name=$customer_item->company;
                                                                                                    $selected='';
                                                                                                    if($id==$values->yukleme_yapacak_cari_id){
                                                                                                        $selected='selected';
                                                                                                    }
                                                                                                    echo "<option $selected  value='$id'>$name</option>";
                                                                                                } ?>
                                                                                            </select>

                                                                                            <?php
                                                                                        } elseif ($values->cari_pers_type == 2) {
                                                                                            ?>
                                                                                            <select class='form-control select-box yukleme_yapacak_cari_id'>
                                                                                                <option value='0'>Personel Seçiniz</option>
                                                                                                <?php foreach (all_personel() as $personel_item){
                                                                                                    $id=$personel_item->id;
                                                                                                    $name=$personel_item->name;
                                                                                                    $selected='';
                                                                                                    if($id==$values->yukleme_yapacak_cari_id){
                                                                                                        $selected='selected';
                                                                                                    }
                                                                                                    echo "<option $selected  value='$id'>$name</option>";
                                                                                                } ?>
                                                                                            </select>

                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </td>


                                                                                    <td>

                                                                                        <select class='form-control select-box cari_id'>
                                                                                            <option value='0'>Cari Seçiniz</option>
                                                                                            <?php foreach (all_customer() as $customer_item){
                                                                                                $id=$customer_item->id;
                                                                                                $name=$customer_item->company;
                                                                                                $selected='';
                                                                                                if($id==$values->cari_id){
                                                                                                    $selected='selected';
                                                                                                }
                                                                                                echo "<option $selected  value='$id'>$name</option>";
                                                                                            } ?>
                                                                                        </select>
                                                                                      </td>
                                                                                    <!--                                                                                    <td>--><?php //echo account_type_sorgu($values->method) ?><!--</td>-->
                                                                                    <td>

                                                                                        <select class='form-control select-box arac_id'>
                                                                                            <option value='0'>Araç Seçiniz</option>
                                                                                            <?php foreach (all_arac() as $arac_item){
                                                                                                $id=$arac_item->id;
                                                                                                $name=$arac_item->name;
                                                                                                $selected='';
                                                                                                if($id==$values->arac_id){
                                                                                                    $selected='selected';
                                                                                                }
                                                                                                echo "<option $selected  value='$id'>$name</option>";
                                                                                            } ?>
                                                                                        </select>

                                                                                    </td>
                                                                                    <td><?php echo $values->lokasyon ?></td>
                                                                                    <td>

                                                                                        <span style="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['style'] ?>" class="txt-color-darken no-padding " data-html="true" data-popup="popover" title="" data-trigger="hover" data-content="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['messages'] ?>" data-original-title="Talep Tipi"><b><?php echo nakliye_item_tip_who($values->nakliye_item_tip)['name'] ?></b></span>

                                                                                    </td>
                                                                                    <td><?php echo nakliye_tip_details($values->nakliye_item_tip,$values->id) ?></td>
                                                                                    <td><?php echo $values->product_desc ?></td>
                                                                                    <td><input   eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->product_qty ?>" class="form-control item_qty"></td>
                                                                                    <td><?php echo $values->unit_name ?></td>
                                                                                    <td><input  eq="<?php echo $eq ?>" item_id="<?php echo $values->id?>" type="number" value="<?php echo $values->price ?>" class="form-control item_price"></td>

                                                                                    <td><?php echo amountFormat($values->total);?></td>
                                                                                    <td>

                                                                                        <select class='form-control method' name="method">
                                                                                            <option value='0'>Seçiniz</option>
                                                                                            <?php foreach (account_type() as $account_type_items){
                                                                                                $id=$account_type_items['id'];
                                                                                                $name=$account_type_items['name'];
                                                                                                $selected='';
                                                                                                if($id==$values->method){
                                                                                                    $selected='selected';
                                                                                                }
                                                                                                echo "<option $selected value='$id'>$name</option>";
                                                                                            } ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>


                                                                                        <button type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button>&nbsp;
                                                                                        <button type="button" eq="<?php echo $eq; ?>" class="btn btn-success form_update_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-check"></i></button>
                                                                                        <?php if($values->nakliye_item_tip==1){
                                                                                            echo "<button eq='".$eq."' item_id='".$values->id."' class='btn btn-info form_pers_update'><i class='fa fa-users'></i> T. T Pers</button>";
                                                                                        }?>


                                                                                        <?php

                                                                                        ?>
                                                                                        <!--                                                                                        <button type="button" eq="--><?php //echo $eq; ?><!--" class="btn btn-success form_add_arac_product" type_="1" durum="1" item_id="--><?php //echo $values->id?><!--"><i class="fa fa-list"></i> Ürünleri Araca Yükle</button>-->
                                                                                        <!--                                                                                        <button type="button" eq="--><?php //echo $eq; ?><!--" class="btn btn-success form_update_products_teslimat" type_="1" durum="1" item_id="--><?php //echo $values->id?><!--"><i class="fa fa-check"></i> Aracı Yola Sal</button>-->

                                                                                    </td>


                                                                                    <td></td>
                                                                                </tr>
                                                                                <?php
                                                                                $i++;
                                                                                $eq++

                                                                                ; } ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <div class="text-center">

                                                                            <?php if($details->satinalma_bildirimi==0){
                                                                            if($details->status!=10){
                                                                            echo '<button class="btn btn-info bildirim_olustur" type="2"><i class="fa fa-bell"></i> Fiyatlandırmayı Onaya Sun</button>';
                                                                            ?>
                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                            <button  type="button" class="btn btn-primary add_product_teklif" demirbas_id="<?php echo $details->demirbas_id ?>" firma_demirbas_id="<?php echo $details->firma_demirbas_id ?>" style="margin: 20px;"><i class="fa fa-plus"></i> Tələb etmək üçün araç ve qiymetlendirme təyin edin</button>

                                                                            <?php
                                                                                    ?>
                                                                        </div>


                                                                        <?php

                                                                    } ?>
                                                                </div>
                                                                <div class="tab-pane fade <?php  if($details->status==5){ echo "active show"; } ?>" id="siparis" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                                                    <?php if($items){  //varsa ?>

                                                                        <table class="table ">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Kod</th>
                                                                                <th width="12%">Yükleme Yapacak Firma / Sorumlu Personel</th>
                                                                                <th width="7%">Cari</th>
                                                                                <th width="7%">Araç</th>
                                                                                <th>Lokasyon</th>
                                                                                <th>Tip</th>
                                                                                <th>Detaylar</th>
                                                                                <th>Açıklama</th>
                                                                                <th>Miktar</th>
                                                                                <th>Birim</th>
                                                                                <th>Fiyat</th>
                                                                                <th>Toplam Tutar</th>
                                                                                <th>Method</th>
                                                                                <th>İşlem</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $i=1;
                                                                            $eq=0;

                                                                            if($details->bildirim_durumu ){
                                                                                $disabled='disabled';
                                                                            }
                                                                            foreach ($items as $values) {

                                                                                $disabled_button='';
                                                                                if($values->status!=5){
                                                                                    $disabled_button='disabled';
                                                                                }

                                                                                ?>
                                                                                <tr  id="remove<?php echo $values->id?>">
                                                                                    <td><?php echo $i ?></td>
                                                                                    <td><?php echo $values->code ?></td>
                                                                                    <td>
                                                                                        <?php

                                                                                        if($values->cari_pers_type==1){
                                                                                            echo customer_details($values->yukleme_yapacak_cari_id)['company'];
                                                                                        }
                                                                                        elseif($values->cari_pers_type==2){
                                                                                            echo personel_details($values->yukleme_yapacak_cari_id);

                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php echo customer_details($values->cari_id)['company']?>
                                                                                    </td>
                                                                                    <!--                                                                                    <td>--><?php //echo account_type_sorgu($values->method) ?><!--</td>-->
                                                                                    <td>
                                                                                        <?php
                                                                                        if($values->arac_id){
                                                                                        $arac_details = arac_details($values->arac_id);
                                                                                        echo isset($arac_details)?arac_details($values->arac_id)->name:'Araç Seçilmemiş!';
                                                                                        }
                                                                                        else {
                                                                                            echo "Araç Seçilmemeiş";
                                                                                        }
                                                                                        ?>


                                                                                    </td>
                                                                                    <td><?php echo $values->lokasyon ?></td>
                                                                                    <td>

                                                                                        <span style="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['style'] ?>" class="txt-color-darken no-padding " data-html="true" data-popup="popover" title="" data-trigger="hover" data-content="<?php echo nakliye_item_tip_who($values->nakliye_item_tip,$values->id)['messages'] ?>" data-original-title="Talep Tipi"><b><?php echo nakliye_item_tip_who($values->nakliye_item_tip)['name'] ?></b></span>

                                                                                    </td>
                                                                                    <td><?php echo nakliye_tip_details($values->nakliye_item_tip,$values->id) ?></td>
                                                                                    <td><?php echo $values->product_desc ?></td>
                                                                                    <td><?php echo amountFormat_s($values->product_qty) ?></td>
                                                                                    <td><?php echo $values->unit_name ?></td>
                                                                                    <td><?php echo amountFormat($values->price)?></td>

                                                                                    <td><?php echo amountFormat($values->total);?></td>
                                                                                    <td>
                                                                                        <?php echo account_type_sorgu($values->method) ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        echo nakliye_item_button($values->nakliye_item_tip,$values->id,$details->id);

                                                                                        ?>
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
                                                                <div class="tab-pane fade" id="giderler" role="tabpanel"  aria-labelledby="link-tab" aria-expanded="false">
                                                                    <?php

                                                                    if(nakliye_giderleri($details->id)){
                                                                        $total=0;
                                                                        echo "<table class='table'>
                                                                                  <thead>
                                                                                  <th>Lojistik Araç Kodu</th>
                                                                                  <th>Gider Talep Kodu</th>
                                                                                  <th>Gider Talep Eden Personel</th>
                                                                                  <th>Gider Ödeme Durumu</th>
                                                                                  <th>Gider Carisi</th>
                                                                                  <th>Gider Adı</th>
                                                                                  <th>Miktar</th>
                                                                                  <th>Birim Fiyatı</th>
                                                                                  <th>Toplam Tutar</th>
                                                                                  <th>Ödeme Metodu</th>
                                                                                  </thead><tbody>";
                                                                        foreach (nakliye_giderleri($details->id) as $nakliye_gider_items){
                                                                            $total+=$nakliye_gider_items['gider_total_net'];
                                                                            $gider_id = $nakliye_gider_items['gider_id'];
                                                                            echo "<tr>
                                                                                <td>".$nakliye_gider_items['code']."</td>
                                                                                <td><a href='/carigidertalepnew/view/$gider_id' class='btn btn-outline-secondary' target='_blank'>".$nakliye_gider_items['gider_code']."</a></td>
                                                                                <td>".$nakliye_gider_items['gider_talep_eden_personel']."</td>
                                                                                <td>".$nakliye_gider_items['gider_odeme_durumu']."</td>
                                                                                <td>".$nakliye_gider_items['gider_cari']."</td>
                                                                                <td>".$nakliye_gider_items['gider_demirbas_id']."</td>
                                                                                <td>".$nakliye_gider_items['gider_miktar']."</td>
                                                                                <td>".$nakliye_gider_items['gider_birim_fiyati']."</td>
                                                                                <td>".$nakliye_gider_items['gider_total']."</td>
                                                                                <td>".$nakliye_gider_items['odeme_metodu']."</td>
                                                                                </tr>";
                                                                        }
                                                                        echo "</tbody><tfoot><tr><td colspan='8' style='text-align: right;font-weight: bold;font-size: 15px;'>Toplam Tutar</td><td  style='text-align: left;font-weight: bold;font-size: 15px;'>".amountFormat($total)."</td></tr></tfoot></table>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="tab-pane fade" id="cezalar" role="tabpanel"  aria-labelledby="link-tab" aria-expanded="false">
                                                                    <?php

                                                                    if(nakliye_cezalari($details->id)){
                                                                        $total=0;
                                                                        echo "<table class='table'>
                                                                                  <thead>
                                                                                  <th>Lojistik Araç Kodu</th>
                                                                                  <th>Ceza Talep Kodu</th>
                                                                                  <th>Ceza Talep Eden Personel</th>
                                                                                  <th>Ceza Borç Durumu</th>
                                                                                  <th>Ceza Verilen Cari</th>
                                                                                  <th>Ceza Adı</th>
                                                                                  <th>Miktar</th>
                                                                                  <th>Birim Fiyatı</th>
                                                                                  <th>Toplam Tutar</th>
                                                                                  <th>Cezalandırma Metodu</th>
                                                                                  </thead><tbody>";
                                                                        foreach (nakliye_cezalari($details->id) as $nakliye_gider_items){
                                                                            $total+=$nakliye_gider_items['gider_total_net'];
                                                                            echo "<tr>
                                                                                <td>".$nakliye_gider_items['code']."</td>
                                                                                <td>".$nakliye_gider_items['gider_code']."</td>
                                                                                <td>".$nakliye_gider_items['gider_talep_eden_personel']."</td>
                                                                                <td>".$nakliye_gider_items['gider_odeme_durumu']."</td>
                                                                                <td>".$nakliye_gider_items['gider_cari']."</td>
                                                                                <td>".$nakliye_gider_items['gider_demirbas_id']."</td>
                                                                                <td>".$nakliye_gider_items['gider_miktar']."</td>
                                                                                <td>".$nakliye_gider_items['gider_birim_fiyati']."</td>
                                                                                <td>".$nakliye_gider_items['gider_total']."</td>
                                                                                <td>".$nakliye_gider_items['odeme_metodu']."</td>
                                                                                </tr>";
                                                                        }
                                                                        echo "</tbody><tfoot><tr><td colspan='8' style='text-align: right;font-weight: bold;font-size: 15px;'>Toplam Tutar</td><td  style='text-align: left;font-weight: bold;font-size: 15px;'>".amountFormat($total)."</td></tr></tfoot></table>";
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
                                                            <?php if(talep_borclandirma($details->id,7)){
                                                                foreach (talep_borclandirma($details->id,7) as $b_items){
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
                                                                foreach (talep_onay_nakliye(1,$details->id) as $items) {
                                                                    $durum='-';
                                                                    $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                    if($items->status==1){
                                                                        $durum='Onaylandı';
                                                                        $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                    }
                                                                    if($items->staff==1 && $items->status==0){
                                                                        $durum='Gözləmedə';
                                                                        $button='<button class="btn btn-info onayla" type="1" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <!--?php echo roles(role_id($items->user_id))?-->
                                                                        <th>(LJT Onayı)</th>
                                                                        <th><?php echo personel_details($items->user_id)?></th>
                                                                        <th><?php echo $durum;?></th>
                                                                        <th><?php echo $button;?></th>
                                                                    </tr>
                                                                    <?php
                                                                } ?>

                                                                <?php
                                                                if(talep_onay_nakliye(2,$details->id)){
                                                                    foreach (talep_onay_nakliye(2,$details->id) as $items) {
                                                                        $durum='-';
                                                                        $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                                        if($items->status==1){
                                                                            $durum='Onaylandı';
                                                                            $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                                        }
                                                                        if($items->staff==1 && $items->status==0){
                                                                            $durum='Gözləmedə';
                                                                            $button='<button class="btn btn-info onayla" type="2" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
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

                                                            <?php if(talep_history_nakliye($details->id,2)){
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
                                                                    foreach (talep_history_nakliye($details->id,2) as $items){

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
    var url = '<?php echo base_url() ?>nakliye/file_handling';

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
                        $.post(baseurl + 'nakliye/update_form',data,(response)=>{
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
                        $.post(baseurl + 'nakliye/upload_file',data,(response) => {
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
                        $.post(baseurl + 'nakliye/delete_file',data,(response)=>{
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
    $(document).on('click', '.add_product', function () {
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Teklif Ekleyin',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form action="" class="formName" id='data_form'>
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12">
                    <table class="table table_products">
                        <thead>
                            <tr>
                                <th>Açıklama</th>
                                <th>Lokasyon (Yükleme Yeri)</th>
                                <th>Yükleme Tipi</th>
                                <th>Yükleme Yapacak Cari/Personel</th>
                                <th>Talep Tipi</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type='text' class='form-control' name='product_desc'></td>
                                <td><input type='text' class='form-control' name='lokasyon'></td>
                                <td>
                                    <select class='form-control select-box' name='cari_pers_type' id='cari_pers_type'>
                                        <option value='0'>Seçiniz</option>
                                        <option value='1'>Cari</option>
                                        <option value='2'>Personel</option>
                                    </select>
                                </td>
                                <td id="yukleme_yapacak_container">
                                    <select class='form-control select-box' name="yukleme_yapacak_cari_id">
                                        <option value='0'>Seçiniz</option>
                                        <?php foreach (all_customer() as $items) {
                echo "<option value='$items->id'>$items->company</option>";
            } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class='form-control' name="nakliye_item_tip">
                                        <option value='0'>Seçiniz</option>
                                        <?php foreach (nakliye_item_tip() as $items) {
                echo "<option value='$items->id'>$items->name</option>";
            } ?>
                                    </select>
                                </td>
                                <td>
                                    <button type='button' class='btn btn-success add_items'>
                                        <i class='fa fa-plus'></i>
                                    </button>
                                    <input type='hidden' value='<?php echo $details->id ?>' name='form_id'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>`,
            buttons: {
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                    action: function () {
                        location.reload();
                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });

                // Dinamik yükleme tipi değişikliği
                $('#cari_pers_type').on('change', function () {
                    let type = $(this).val();
                    let container = $('#yukleme_yapacak_container');
                    container.empty(); // Önce mevcut seçenekleri temizle

                    if (type == '1') {
                        // Cari seçimi
                        container.append(`
                        <select class='form-control select-box' name="yukleme_yapacak_cari_id">
                            <option value='0'>Seçiniz</option>
                            <?php foreach (all_customer() as $items) {
                            echo "<option value='$items->id'>$items->company</option>";
                        } ?>
                        </select>
                    `);
                    } else if (type == '2') {
                        // Personel seçimi
                        container.append(`
                        <select class='form-control select-box' name="yukleme_yapacak_cari_id">
                            <option value='0'>Seçiniz</option>
                            <?php foreach (all_personel() as $items) {
                            echo "<option value='$items->id'>$items->name</option>";
                        } ?>
                        </select>
                    `);
                    } else {
                        container.append(`
                        <select class='form-control select-box' name="yukleme_yapacak_cari_id">
                            <option value='0'>Seçiniz</option>
                        </select>
                    `);
                    }

                    // Yeni eklenen select-box için Select2 başlat
                    container.find('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                });

                // Form içeriği gönderme işlemi
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    });

    $(document).on('click','.add_product_teklif',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Teklif Ekleyin',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName" id='data_form'>
                                         <div class="row">
                                           <div class="col col-xs-12 col-sm-12 col-md-12">

                                                <table class="table table_products">
                                                    <thead>
                                                        <tr>
                                                            <th>Açıklama</th>
                                                            <th>Lokasyon</th>
                                                            <th>Cari</th>
                                                            <th>Ödeme Türü</th>
                                                            <th>Araç</th>
                                                            <th>Talep Tipi</th>
                                                            <th>Birim</th>
                                                            <th>Miktar</th>
                                                            <th>Tutar</th>
                                                            <th>İşlem</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>

                                                            <td><input type='text' class='form-control' name='product_desc'></td>
                                                             <td><input type='text' class='form-control' name='lokasyon'></td>
                                                             <td>

                                                             <select class='form-control select-box' name="cari_id" id="cari_id">
                                                               <option value='0'>Seçiniz</option>
                                                                        <?php foreach (all_customer() as $items){
                echo "<option value='$items->id'>$items->company</option>";
            } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                             <select class='form-control' name="method" id="method">
                                                               <option value='0'>Seçiniz</option>
                                                                        <?php foreach (account_type() as $items){
                $id=$items['id'];
                $name=$items['name'];
                echo "<option value='$id'>$name</option>";
            } ?>
                                                                    </select>
                                                                </td><td>
                                                             <select class='form-control select-box' name="arac_id" id="arac_id">
                                           <option value='0'>Seçiniz</option>
                                                    <?php foreach (araclar() as $items){
                echo "<option value='$items->id'>$items->name.' '.$items->code</option>";
            } ?>
                                                    </select>
                                                    </td>
                                                       <td>
                                                             <select class='form-control' name="nakliye_item_tip" id="nakliye_item_tip">
                                                               <option value='0'>Seçiniz</option>
                                                                        <?php foreach (nakliye_item_tip() as $items){
                echo "<option value='$items->id'>$items->name</option>";
            } ?>
                                                                    </select>
                                                                </td>
                                                          <td><select class="form-control select-box unit_id" name='unit_id' id="unit_id">
                                                                 <?php foreach (units() as $blm)
            {
                $id=$blm['id'];
                $name=$blm['name'];
                echo "<option value='$id'>$name</option>";
            } ?>
                                                                </select>
                                                            </td>
                                                            <td><input type='numaric' class='form-control' name='product_qty' value="1"></td>
                                                            <td><input type='numaric' class='form-control' name='product_price' value="1">
                                                            <td><button type='button' class='btn btn-success add_items_siparis'><i class='fa fa-plus'></td>

                                                            <input type='hidden' value='<?php echo $details->id?>' name='form_id'>
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

    $(document).on('click','.add_items_siparis',function (){
        let desct=$('#cari_id').val();
        let method=$('#method').val();
        let arac_id=$('#arac_id').val();
        let nakliye_item_tip=$('#nakliye_item_tip').val();
        if(desct == 0 || method==0 || arac_id==0 || nakliye_item_tip==0){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Cari / Araç / Ödeme Metodu / Nakliye Tipi Zorunludur',
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
        $.post(baseurl + 'nakliye/create_form_items_satinalma',$('#data_form').serialize(),(response)=>{
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
    $(document).on('click','.add_items',function (){
        $('#loading-box').removeClass('d-none');
        $.post(baseurl + 'nakliye/create_form_items',$('#data_form').serialize(),(response)=>{
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
                $.post(baseurl + 'nakliye/search_products',data,(response)=>{
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
            $.post(baseurl + 'nakliye/search_products',data,(response)=>{
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
        $.post(baseurl + 'nakliye/create_form_items',data,(response)=>{
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
                                                    <td><p>`+responses.product_name+' | '+responses.mt_text+`</p></td>
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
                        $.post(baseurl + 'nakliye/delete_item_form',data,(response)=>{
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

    $(document).on('click','.form_pers_update',function(){
        let item_id =$(this).attr('item_id');
        let eq = $(this).attr('eq');

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

            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+=` <div class="form-group col-md-12">
                            <label for="name">Malzemeyi Yükleyecek Personel</label>
                            <select class='form-control select-box' id="yukleyen_pers_id" name='yukleyen_pers_id'>
                               <option value='0'>Seçiniz</option>
                                <?php foreach (all_personel() as $items){
                    echo "<option value='$items->id'>$items->name</option>";
                } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Malzemeyi Tehvil Alacak Personel</label>
                            <select class='form-control select-box' id="tehvil_pers_id" name='tehvil_pers_id'>
                               <option value='0'>Seçiniz</option>
                                <?php foreach (all_personel() as $items){
                    echo "<option value='$items->id'>$items->name</option>";
                } ?>
                            </select>
                        </div>`;

                let data = {
                    item_id: item_id,
                }

                let table_report='';
                $.post(baseurl + 'nakliye/personel_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $('#yukleyen_pers_id').val(responses.yukleyen_pers_id).select2().trigger('change');
                        $('#tehvil_pers_id').val(responses.tehvil_pers_id).select2().trigger('change');
                    }
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
                        let data = {
                            item_id:item_id,
                            yukleyen_pers_id:$('#yukleyen_pers_id').val(),
                            tehvil_pers_id:$('#tehvil_pers_id').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'nakliye/update_item_pers',data,(response)=>{
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
    $(document).on('click','.form_update_products',function (){
        let item_id =$(this).attr('item_id');
        let durum =$(this).attr('durum');
        let type = $(this).attr('type_');
        let eq = $(this).attr('eq');

        let item_price = $('.item_price').eq(eq).val();
        let item_qty = $('.item_qty').eq(eq).val();
        let arac_id = $('.arac_id').eq(eq).val();
        let cari_id = $('.cari_id').eq(eq).val();
        let method = $('.method').eq(eq).val();
        let yukleme_yapacak_cari_id = $('.yukleme_yapacak_cari_id').eq(eq).val();

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
                            arac_id:arac_id,
                            cari_id:cari_id,
                            method:method,
                            yukleme_yapacak_cari_id:yukleme_yapacak_cari_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'nakliye/update_item_form',data,(response)=>{
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
    $(document).on('click','.form_update_products_teslimat',function (){
        let item_id =$(this).attr('item_id');
        let type =$(this).attr('type_');

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
                '<p>Aracı Yola Salmak Üzeresiniz<p/>'+
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
                        }
                        $.post(baseurl + 'nakliye/update_item_form_teslimat',data,(response)=>{
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
                        $.post(baseurl + 'nakliye/customer_alacak_update',data,(response)=>{
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


    $(document).on('click','.button_qaime',function (){

        let talep_id =$(this).attr('talep_id');


        let cont = `<form action="" class="formName">
            <div class="form-group">
            <p>Cari Seçiniz<p/>
             </div>
               <div class="form-group">
               <select class="form-control cari_id" >
                <?php foreach (nakliye_cari_list_qaime($details->id) as $emp) {
            $cari_id = $emp->cari_id;
            $name = customer_details($cari_id)['company'];
            $selected = '';
            echo '<option  value="' . $cari_id . '">' . $name . '</option>';
        }
        ?>
                </select>
            </div>


            </form>`;
        $.confirm({
            theme: 'material',
            closeIcon: false,
            title: 'Qaime Forması Adım 1',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:cont,
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
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
                                    cari_id: $('.cari_id').val(),
                                }

                                let table_report='';
                                $.post(baseurl + 'nakliye/qaime_ajax',data,(response) => {
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

                                        let data = {
                                            talep_id:talep_id,
                                            crsf_token: crsf_hash,
                                        }
                                        $.post(baseurl + 'nakliye/qaime_create',data,(response)=>{
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







        //
        //let talep_id =$(this).attr('talep_id');
        //let tip =$(this).attr('tip');
        //let cont = `<form action="" class="formName">
        //    <div class="form-group">
        //    <p>Cariye Ödeme Yapmak İstediğinizden Emin Misiniz?<p/>
        //
        //     </div>
        //
        //       <div class="form-group">
        //       <select class="form-control select-box" multiple="multiple" >
        //        <?php //foreach (nakliye_cari_list($details->id) as $emp) {
        //    $emp_id = $emp->id;
        //    $name = $emp->code;
        //    $selected = '';
        //    echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        //}
        //?>
        //        </select>
        //    </div>
        //
        //
        //    </form>`;
        //$.confirm({
        //    theme: 'modern',
        //    closeIcon: true,
        //    title: 'Dikkat',
        //    icon: 'fa fa-check',
        //    type: 'green',
        //    animation: 'scale',
        //    useBootstrap: true,
        //    columnClass: "col-md-12 mx-auto",
        //    containerFluid: !0,
        //    smoothContent: true,
        //    draggable: false,
        //    content:cont,
        //    buttons: {
        //        formSubmit: {
        //            text: 'Güncelle',
        //            btnClass: 'btn-blue',
        //            action: function () {
        //                let account_id = $('.account_id').val();
        //                let cach_cari_id = $('.cach_cari_id').val();
        //                let cach_method = $('.cach_method').val();
        //                if(tip!='tamamlama'){
        //                    if(!parseInt(account_id)){
        //                        $.alert({
        //                            theme: 'material',
        //                            icon: 'fa fa-exclamation',
        //                            type: 'red',
        //                            animation: 'scale',
        //                            useBootstrap: true,
        //                            columnClass: "col-md-4 mx-auto",
        //                            title: 'Dikkat!',
        //                            content:'Kasa Seçmek Zorunludur',
        //                            buttons:{
        //                                prev: {
        //                                    text: 'Tamam',
        //                                    btnClass: "btn btn-link text-dark",
        //                                }
        //                            }
        //                        });
        //                        return false;
        //                    }
        //                    if(!parseInt(cach_cari_id)){
        //                        $.alert({
        //                            theme: 'material',
        //                            icon: 'fa fa-exclamation',
        //                            type: 'red',
        //                            animation: 'scale',
        //                            useBootstrap: true,
        //                            columnClass: "col-md-4 mx-auto",
        //                            title: 'Dikkat!',
        //                            content:'Cari Zorunludur',
        //                            buttons:{
        //                                prev: {
        //                                    text: 'Tamam',
        //                                    btnClass: "btn btn-link text-dark",
        //                                }
        //                            }
        //                        });
        //                        return false;
        //                    }
        //                    if(!parseInt(cach_method)){
        //                        $.alert({
        //                            theme: 'material',
        //                            icon: 'fa fa-exclamation',
        //                            type: 'red',
        //                            animation: 'scale',
        //                            useBootstrap: true,
        //                            columnClass: "col-md-4 mx-auto",
        //                            title: 'Dikkat!',
        //                            content:'Ödeme Metodu Zorunludur',
        //                            buttons:{
        //                                prev: {
        //                                    text: 'Tamam',
        //                                    btnClass: "btn btn-link text-dark",
        //                                }
        //                            }
        //                        });
        //                        return false;
        //                    }
        //                }
        //
        //                $('#loading-box').removeClass('d-none');
        //                let data = {
        //                    tip:tip,
        //                    talep_id:$('#talep_id').val(),
        //                    account_id:$('.account_id').val(),
        //                    cach_personel:$('.cach_personel').val(),
        //                    cach_cari_id:$('.cach_cari_id').val(),
        //                    cach_method:$('.cach_method').val(),
        //                    alacak_tutar:$('.alacak_tutar').val(),
        //                    item_id:$('.item_id').val(),
        //                    not:$('.not').val(),
        //                }
        //                $.post(baseurl + 'nakliye/customer_payment_update',data,(response)=>{
        //                    let responses = jQuery.parseJSON(response);
        //                    if(responses.status=='Success'){
        //                        $('#loading-box').addClass('d-none');
        //                        $.alert({
        //                            theme: 'modern',
        //                            icon: 'fa fa-check',
        //                            type: 'green',
        //                            animation: 'scale',
        //                            useBootstrap: true,
        //                            columnClass: "col-md-4 mx-auto",
        //                            title: 'Başarılı',
        //                            content: responses.message,
        //                            buttons:{
        //                                formSubmit: {
        //                                    text: 'Tamam',
        //                                    btnClass: 'btn-blue',
        //                                    action: function () {
        //                                        //let remove = '#remove'+ item_id
        //                                        location.reload()
        //                                    }
        //                                }
        //                            }
        //                        });
        //                    }
        //                    else {
        //                        $('#loading-box').addClass('d-none');
        //                        $.alert({
        //                            theme: 'material',
        //                            icon: 'fa fa-exclamation',
        //                            type: 'red',
        //                            animation: 'scale',
        //                            useBootstrap: true,
        //                            columnClass: "col-md-4 mx-auto",
        //                            title: 'Dikkat!',
        //                            content:responses.message,
        //                            buttons:{
        //                                prev: {
        //                                    text: 'Tamam',
        //                                    btnClass: "btn btn-link text-dark",
        //                                }
        //                            }
        //                        });
        //                    }
        //
        //                });
        //
        //            }
        //        },
        //        cancel:{
        //            text: 'Vazgeç',
        //            btnClass: "btn btn-danger btn-sm",
        //        }
        //    },
        //    onContentReady: function () {
        //
        //        $('.select-box').select2({
        //            dropdownParent: $(".jconfirm-box-container")
        //        })
        //        // bind to events
        //        var jc = this;
        //        this.$content.find('form').on('submit', function (e) {
        //            // if the user submits the form by pressing enter in the field.
        //            e.preventDefault();
        //            jc.$$formSubmit.trigger('click'); // reference the button and click it
        //        });
        //    }
        //});
    })


    $(document).on('click','.form_transaction_payment',function (){

        let tutar =$(this).attr('tutar');
        let talep_id =$(this).attr('talep_id');
        let tip =$(this).attr('tip');
        let cont = `<form action="" class="formName">
            <div class="form-group">
            <p>Cariye Ödeme Yapmak İstediğinizden Emin Misiniz?<p/>
            <input class="form-control alacak_tutar"  type="number" value="`+tutar+`"  max='`+99999999+`'onkeyup="amount_max(this)">
             </div>
               <div class="form-group">
            <input class="form-control not" placeholder='Açıklama'>
            </div>
            </div>
               <div class="form-group">

               <select class="form-control item_id select-box">
                <option value="0">İşlem Kodu</option>
                <?php foreach (nakliye_cari_list($details->id) as $emp) {
            $emp_id = $emp->id;
            $name = $emp->code;
            $selected = '';
            echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        }
        ?>
                </select>
            </div>

              <div class="form-group">


            <select class="form-control cach_cari_id select-box">
                <option value="0">Ödeme Yapılacak Cari</option>
                <?php foreach (all_customer() as $emp) {
            $emp_id = $emp->id;
            $name = $emp->company;
            $selected = '';
            echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        }
        ?>
                </select>
            </div>

               <div class="form-group">


            <select class="form-control cach_method select-box">
                <option value="0">Ödeme Metodu</option>
                <?php foreach (account_type_islem() as $emp) {
            $emp_id = $emp->id;
            $name = $emp->name;
            $selected = '';
            echo '<option  value="' . $emp_id . '">' . $name . '</option>';
        }
        ?>
                </select>
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
                        let cach_cari_id = $('.cach_cari_id').val();
                        let cach_method = $('.cach_method').val();
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
                            if(!parseInt(cach_cari_id)){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content:'Cari Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }
                            if(!parseInt(cach_method)){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content:'Ödeme Metodu Zorunludur',
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
                            cach_cari_id:$('.cach_cari_id').val(),
                            cach_method:$('.cach_method').val(),
                            alacak_tutar:$('.alacak_tutar').val(),
                            item_id:$('.item_id').val(),
                            not:$('.not').val(),
                        }
                        $.post(baseurl + 'nakliye/customer_payment_update',data,(response)=>{
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
    $(document).on('change','.item_id',function () {
        let item_id = $(this).val();

        let data = {
            item_id:item_id
        }
        $.post(baseurl + 'nakliye/item_info',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.items){
                if(parseInt(responses.items.cari_id)){
                   let cari_id = responses.items.cari_id;
                   $('.cach_cari_id').val(cari_id).select2().trigger('change');
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
                        content:'Seçilen işlem kodunda cari belirlenmemiştir.Lütfen Cari Seçiniz',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }
                if(parseInt(responses.items.method)){
                   let method = responses.items.method;
                    $('.cach_method').val(method).select2().trigger('change');
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
                        content:'Seçilen işlem kodunda ödeme metodu belirlenmemiştir.Lütfen Ödeme Metodu Seçiniz',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }
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
                            $.post(baseurl + 'nakliye/update_form_payment',data,(response)=>{
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
        let type = $(this).attr('type');
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
                            type:type,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'nakliye/form_bildirim_olustur',data,(response)=>{
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
        let type  = $(this).attr('type');
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
                                type:type,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'nakliye/onay_olustur',data,(response)=>{
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
                        $.post(baseurl + 'nakliye/status_upda',data,(response) => {
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
                        $.post(baseurl + 'nakliye/status_upda',data,(response) => {
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
                        $.post(baseurl + 'nakliye/status_upda',data,(response) => {
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

    function details_notes(){
        let talep_id = $('#talep_id').val();
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
    $(document).on('click','.payment_talep',function (){
        let nakliye_item_id=$(this).attr('nakliye_item_id');
        let form_id=$(this).attr('form_id');

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
                <p>Ödeme İşlemlerine Başlamak Üzeresiniz Emin Misiniz?<p/>
                </form>`,

            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            form_id:form_id,
                            nakliye_item_id:nakliye_item_id
                        }
                        $.post(baseurl + 'nakliye/odeme_talep',data,(response)=>{
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

    })


    $(document).on('click','.hizmet_tamamla',function (){
        let nakliye_item_id=$(this).attr('nakliye_item_id');
        let form_id=$(this).attr('form_id');

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
                <p>Hizmet Tamamlanıp Ödeme İşlemleri Başlayacak emin Misiniz?<p/>
                </form>`,

            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            form_id:form_id,
                            nakliye_item_id:nakliye_item_id
                        }
                        $.post(baseurl + 'nakliye/odeme_talep',data,(response)=>{
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
                'url': "<?php echo site_url('nakliye/ajax_list_notes')?>",
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
                                        $.post(baseurl + 'nakliye/create_save_notes',data,(response) => {
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
                        $.post(baseurl + 'nakliye/notes_delete',data,(response) => {
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

    $(document).on('click','.form_add_arac_product',function (){
        let talep_form_product_id = $(this).attr('item_id');

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
                    talep_form_product_id: talep_form_product_id,
                }

                let table_report='';
                $.post(baseurl + 'nakliye/arac_add_product',data,(response) => {
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

    function amount_max(element){
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }

    $(document).on('click','.add_arac_product_button',function (){
        let talep_form_product_id = $(this).attr('talep_form_product_id');
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let eq =$(this).parent().parent().index()
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Yükleme',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Ürünü Belirtilen Miktar Kadar Araca Yüklemek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Yükle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            nakliye_item_id: nakliye_item_id,
                            talep_form_product_id: talep_form_product_id,
                            miktar:$('.item_qty_values').eq(eq).val()
                        }
                        $.post(baseurl + 'nakliye/add_arac_product',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
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
                                            action:function (){
                                                $('.item_qty_values').eq(eq).val(responses.kalan);
                                                $('.item_qty_values').eq(eq).attr('max',responses.kalan);
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
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

    $(document).on('click','.mt_info',function (){
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let form_id = $(this).attr('form_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İşlem Yap',
            icon: 'fa fa-bell',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form id='data_form'><div class="form-group row">
            <input type='hidden' value='`+nakliye_item_id+`' name='nakliye_item_id'>
            <input type='hidden' value='`+form_id+`' name='form_id'>
                        <div class="form-group col-md-12">
                            <label for="name">Lojistik İçin Malzeme Talebi</label>
                            <select class='form-control select-box' id="mt_id" multiple name='mt_id[]'>
                               <option value='0'>Seçiniz</option>
                                <?php foreach (all_mt_list() as $items){
                                echo "<option value='$items->id'>$items->code</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Ürün Cinsi</label>
                            <input type="text" class='form-control urun_cinsi' name='urun_cinsi'>
                        </div>
                         <div class="form-group col-md-12">
                            <label>Ürün M3</label>
                            <input type="text" class='form-control urun_m3' name='urun_m3'>
                        </div>
                       <div class="form-group col-md-12">
                            <label>Ürün Ağırlık</label>
                            <input type="text" class='form-control urun_agirlik' name='urun_agirlik'>
                        </div>
                      <div class="form-group col-md-12">
                            <label>Ürün Tonaj</label>
                            <input type="text" class='form-control urun_tonaj' name='urun_tonaj'>
                        </div>


                    </div></form>`,
                buttons: {
                formSubmit: {
                    text: 'Bildirim Başlat',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'nakliye/save_items',$('#data_form').serialize(),(response)=>{
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

    $(document).on('click','.mt_info_arac',function (){
        let n_item_id =$(this).attr('n_item_id');
        let m_talep_id =$(this).attr('m_talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Detaylar',
            icon: 'fa fa-question',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-12',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_mt_info">'+
                    '</div>' +
                    '</form>';

                let data = {
                    n_item_id: n_item_id,
                    m_talep_id: m_talep_id,
                    nakliye_id: $('#talep_id').val(),
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table id="table_mt_info"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Yükleme Tarihi</th>
                            <th>Ürün</th>
                            <th>Yükleyen Personel</th>
                            <th>Yüklenen Miktar</th>
                            <th>Teslim Alınan Miktar</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_mt_info').empty().html(table_report);
                    draw_data_mt_arac(n_item_id,m_talep_id,$('#talep_id').val());
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

    function draw_data_mt_arac(n_item_id,m_talep_id,talep_id=0) {
        $('#table_mt_info').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[6]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('nakliye/mt_info_arac')?>",
                'type': 'POST',
                'data': {
                    n_item_id: n_item_id,
                    m_talep_id: m_talep_id,
                    talep_id: talep_id
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
                        columns: [0, 1, 2,3, 4,5]
                    }
                }

            ]
        });
    };

    $(document).on('click','.new_mt_bildirimi',function (){
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let form_id = $(this).attr('form_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Mt Talep Et',
            icon: 'fa fa-bell',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form id='data_form'><div class="form-group row">
            <input type='hidden' value='`+nakliye_item_id+`' name='nakliye_item_id'>
            <input type='hidden' value='`+form_id+`' name='form_id'>
                        <div class="form-group col-md-12">
                            <label for="name">Mt Talep Edilecek Personel</label>
                            <select class='form-control select-box' id="mt_talep_personel" name='mt_talep_personel'>
                               <option value='0'>Seçiniz</option>
                                <?php foreach (all_personel() as $items){
                echo "<option value='$items->id'>$items->name</option>";
            } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="name">Açıklama</label>
                            <input type="text" class="form-control" name="talep_text">
                        </div>

                    </div></form>`,
            buttons: {
                formSubmit: {
                    text: 'Bildirim Başlat',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'nakliye/save_mt_talep',$('#data_form').serialize(),(response)=>{
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

    $(document).on('click','.depocu_bildirimi',function(){
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let form_id = $(this).attr('form_id');
        let tip=$(this).attr('tip'); //1 depo 2 transfer depo
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-warehouse',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+=`<form action="" class="formName"
                <div class="form-group">
                <table class='table add_table'>
                    <thead>
                        <tr>
                            <th>Depo</th>
                            <th>Tip</th>
                            <th>Sıralama</th>
                            <th>Açıklama</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class='form-control select-box warehouse_id'>
                                    <?php foreach (all_warehouse() as $item_warehouse){
                    echo "<option value='$item_warehouse->id'>$item_warehouse->title</option>";
                } ?>
                                </select>
                            </td>
                            <td>
                              <select class='form-control type'>
                                    <option value="1">Yükleme Yapacak Depo</option>
                                    <option value="2">Teslim Alacak Depo</option>
                                </select>
                            </td>
                            <td>
                                <input type='number' class='form-control sort'>
                            </td>
                              <td>
                                <input type='text' class='form-control text_desc'>
                            </td>
                            <td><button type='button' nakliye_item_id='`+nakliye_item_id+`' class='btn btn-success nakliye_transfer_add'><i class='fa fa-plus'></i> Ekle</button></td>
                        </tr>
                    </tbody>
                </table>
                 <table class='table_details table' style='display:none'>
                    <thead>
                        <tr>
                            <th>Depo</th>
                            <th>Tip</th>
                            <th>Sıralama</th>
                            <th>Açıklama</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                     </tbody>
                </form>`;
                let data = {
                    nakliye_item_id: nakliye_item_id,
                }
                let table_report='';
                $.post(baseurl + 'nakliye/talep_nakliye_transfer_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $('.table_details').css('display','inline-table');
                        $.each(responses.items, function (index, value) {
                            $('.table_details tbody').append(`
                        <tr>
                            <td>`+value.warehose_name+`</td>
                            <td>`+value.type_text+`</td>
                            <td>`+value.sort+`</td>
                            <td>`+value.text+`</td>
                            <td><button type='button' class='btn btn-danger delete_warehouse' item_id='`+value.item_id+`'><i class='fa fa-trash'></button></td>
                        </tr>`)
                        });

                        if(parseInt(responses.bildirim_durumu)==1){
                            $('.add_table').css('display','none')
                            $('.delete_warehouse').css('display','none')
                        }

                    }
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

    $(document).on('click','.depo_bildirim_baslat_new',function (){
        let nakliye_item_id = $(this).attr('n_item_id');
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
            content:"<p>Depolara Bildirim Gitmek Üzere Emin Misiniz?</p>",
            buttons: {
                formSubmit: {
                    text: 'Bildirim Başlat',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            nakliye_item_id: nakliye_item_id,
                        }
                        $.post(baseurl + 'nakliye/transfer_bildirimi',data,(response)=>{
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
                    text: 'Kapat',
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

    $(document).on('click','.nakliye_transfer_add',function (){
        let warehouse_id = $('.warehouse_id').val();
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let type = $('.type').val();
        let sort = $('.sort').val();
        let text_desc = $('.text_desc').val();


        $('#loading-box').removeClass('d-none');
        let data_update = {
            n_id:$('#talep_id').val(),
            n_item_id: nakliye_item_id,
            warehouse_id: warehouse_id,
            type: type,
            sort: sort,
            text_desc: text_desc
        }
        $.post(baseurl + 'nakliye/transfer_item_add',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                $('#loading-box').addClass('d-none');
                    $('.table_details').css('display','inline-table');

                    $('.table_details tbody').append(`
                        <tr>
                            <td>`+responses.warehose_name+`</td>
                            <td>`+responses.type_text+`</td>
                            <td>`+responses.sort+`</td>
                            <td>`+responses.text+`</td>
                            <td><button type='button' class='btn btn-danger delete_warehouse' item_id='`+responses.id+`'><i class='fa fa-trash'></button></td>
                        </tr>`)

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

    })

    $(document).on('click','.delete_warehouse',function (){

        let obj=$(this);
        let id = $(this).attr('item_id');
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
                        $.post(baseurl + 'nakliye/delete_warehouse_item',data,(response)=>{
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
                                                obj.parent().parent().remove();
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
    $(document).on('click','.transfer_asamalari',function (){
        let item_id = $(this).attr('n_item_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Depo Aşaması',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,

            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                let data = {
                    item_id: item_id,
                }

                let table_report='';
                $.post(baseurl + 'nakliye/transfer_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        html = responses.html;
                        self.$content.find('#person-list').empty().append(html);
                    }
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


    let table_product_id_ar=[];
    $(document).on('click','.transfer_arac_view',function (){
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Araç İçi Görüntüle',
            icon: 'fa fa-eye 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
                     <p class="test"></p>
                      <table id="result" class="table ">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Anbar</th>
                              <th scope="col">Yükleme Zamanı</th>
                              <th scope="col">Yükleme Yapan Personel</th>
                              <th scope="col">Mehsul</th>
                              <th scope="col">Varyasyon</th>
                              <th scope="col">Miqdarı</th>
                              <th scope="col">Aciqlama</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                   `,
            buttons: {
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function () {
                let data = {
                    nakliye_item_id: nakliye_item_id,
                }
                $.post(baseurl + 'nakliye/arac_warehouse_view',data,(response)=>{
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $('#loading-box').addClass('d-none');


                        let j=1;
                        let html="";
                        $.each(responses.items, function (index, item_Value) {
                            html+=`<tr id="remove`+item_Value.id+`">`;
                            html+=`<td>`+j+`</td>`;
                            html+=`<td>`+item_Value.anbar+`</td>`;
                            html+=`<td>`+item_Value.yukleme_zamani+`</td>`;
                            html+=`<td>`+item_Value.yukleme_yapan_personel+`</td>`;
                            html+=`<td>`+item_Value.product_name+`</td>`;
                            html+=`<td>`+item_Value.varyasyon+`</td>`;
                            html+=`<td>`+item_Value.miqdar+`</td>`;
                            html+=`<td>`+isEmpty(item_Value.aciklama)+`</td>`;
                             html+=`</tr>`;
                            j++;
                        })


                        $('#result tbody').empty().append(html);
                    }
                    else {
                        $('#loading-box').addClass('d-none');
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
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

