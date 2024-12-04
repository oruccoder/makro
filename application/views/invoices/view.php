<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo invoice_type_desc($invoice['invoice_type_id'])?> Görüntüle</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            <?php echo invoice_type_desc($invoice['invoice_type_id'])?> Görüntüleme
        </div>
    </div>
</div>

<div class="content">

    <!-- Invoice template -->
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline py-0">
            <h6 class="card-title py-3">Proje Kodu : <?php echo proje_code($invoice['proje_id']); ?></h6>
            <div class="header-elements">


                <button  islem_tipi="2" islem_id="<?php echo $invoice['id']?>" type="button" class="btn btn-light btn-sm add_not_new"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Not Ekle"><i class="fa fa-notes-medical"></i></button>&nbsp;&nbsp;
                <button  onclick="details_notes()" type="button" class="btn btn-light btn-sm button_view_notes"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Notları Görüntüle"><i class="fa fa-list"></i></button>&nbsp;&nbsp;
                <a href="/demirbas/invoicecreate/<?php echo $invoice['id']?>" type="button" class="btn btn-light btn-sm" target="_blank"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Gidere İşle"><i class="fa fa-plus"></i> </a>&nbsp;&nbsp;

                <?php
                $disabled='';
                if($invoice['status']==3){
                    $disabled='disabled';
                    ?>
<!--                    <button --><?php //echo $disabled;?><!-- type="button" href="--><?php //echo '/invoices/edit?id=' . $invoice['id']; ?><!--" class="btn btn-light btn-sm"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Düzenle"><i class="icon-file-check "></i></button>-->
                    <button <?php echo $disabled;?> href="/invoices/edit?id=<?php echo $invoice['id']?>" type="button" class="btn btn-light btn-sm" target="_blank"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Düzenle"><i class="icon-file-check"></i> </button>&nbsp;&nbsp;

                    <?php
                }
                else {
                    ?>
                    <a type="button" href="<?php echo '/invoices/edit?id=' . $invoice['id']; ?>" class="btn btn-light btn-sm" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Düzenle"><i class="icon-file-check"></i></a>

                    <?php
                }
                ?>

                <a type="button" href="<?php echo '/invoices/printinvoice?id=' . $invoice['id']; ?>" class="btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Yazdır"><i class="icon-printer "></i></a>
                <a type="button" href="<?php echo '/invoices/odeme_gecmisi?id='.$invoice['id'].'&tip=3'; ?>" class="btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Ödeme Geçmişi"><i class="icon-printer "></i></a>
                <button <?php echo $disabled;?>  type="button" class="part_payment btn btn-light btn-sm ml-2" title="Partial Payment" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Tahsilat Ekle"><i class="fa fa-money-bill"></i></button>


                <?php

                $disabled_onay_s='disabled';
                if($invoice['status']==1) {
                    $disabled_onay_s='';
                }
                if($this->aauth->get_user()->id==39){
                    $disabled_onay_s='';
                }

                ?>

                <button  <?php echo $disabled;?>  type="button" class="invoice_iptal btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal Et"><i class="icon-cancel-circle2 "></i>  </button>
                <button <?php echo $disabled_onay_s;?>  type="button" class="invoice_status_change btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Durum Değiştir"><i class="icon-check2"></i>  </button>

                <?php
                if($invoice['status']!=3)
                {
                    if($invoice['bildirim_durumu']==1)
                    {
                        ?>
                        <button disabled id="onay_iste" type="button" class="btn btn-light btn-sm ml-2"><i class="fa fa-bell"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onay Sistemine Sunulmuştur"></i> </button>&nbsp;

                        <?php
                    }
                    else {?>
                        <button  id="onay_iste" type="button" class="btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onay Sistemini Başlat"><i class="fa fa-bell"></i> </button>
                    <?php } ?>
                <?php } ?>

                <button  type="button" class="btn btn-light btn-sm ml-2 button_podradci_borclandirma" islem_id="<?php echo $invoice['id'] ?>" islem_tipi="6" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
                <button  type="button" class="btn btn-light btn-sm ml-2 button_podradci_borclandirma" islem_id="<?php echo $invoice['id'] ?>" islem_tipi="6" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>



            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-4">
                        <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>" class="mb-3 mt-2" alt="" style="width: 120px;">
                        <ul class="list list-unstyled mb-0">
                            <li><span class="font-weight-semibold"><?php echo $invoice['company']; ?></span></li>
                            <li><?php echo $invoice['address'].' '.$invoice['city'].' '.$invoice['region']; ?></li>
                            <li><?php echo $invoice['country']; ?></li>
                            <li><?php echo $invoice['phone']; ?></li>
                            <li>
                                <?php echo qaime_to_talep($invoice['id']); ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-4">
                        <div class="text-sm-right">
                            <h4 class="text-primary mb-2 mt-lg-2"><?php echo invoice_type_desc($invoice['invoice_type_id'])?> # <?php echo $invoice['invoice_no'];?></h4>
                            <ul class=" mb-2 mt-lg-2" style="list-style: none;">
                                <li>Toplam Tutar : <span class="font-weight-semibold"><?php echo amountFormat($invoice['total'],$invoice['para_birimi']) ?></span></li>
                                <li><?php echo invoice_type_desc($invoice['invoice_type_id'])?> Tarihi: <span class="font-weight-semibold"><?php echo dateformat($invoice['invoicedate']) ?></span></li>
                                <li><?php echo invoice_type_desc($invoice['invoice_type_id'])?> Durumu: <span class="font-weight-semibold"><?php echo invoice_status($invoice['status']); ?></span></li>
                              </ul>
                            <ul class="mb-2 mt-lg-2" style="list-style: none;">
                                <?php
                                if(invoice_to_talep($invoice['id'],0)){
                                    echo invoice_to_talep($invoice['id'],0);
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-lg">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Description') ?></th>
                    <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                    <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                    <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                    <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>

                </tr>
                </thead>
                <tbody>
                <?php $c = 1;
                $sub_t = 0;
                foreach ($products as $row) {
                    $item_total=floatval($row['price']) * floatval($row['qty']);

                    $sub_t += $item_total;
                    $html_options = invoice_options_html($row['id']);
                    $unit_reverse="<button data-id='".$row['id']."' data-invoice_id='".$invoice['id']."' class='btn btn-info unit_reverse'>".units_($row['unit'])['name']."</button>";
                    echo '<tr>
                                <th scope="row">' . $c . '</th>
                                <td>' . $row['product'] .' '.$html_options. '</td>
                                <td>' . amountFormat($row['price'],$invoice['para_birimi']) . '</td>
                                <td>' . +$row['qty'].' '.$unit_reverse. '</td>
                                <td>' . amountFormat($row['totaldiscount'],$invoice['para_birimi']) . ' (' .amountFormat_s($row['discount']).$this->lang->line($invoice['format_discount']).')</td>
                                <td>' . amountFormat($row['subtotal'],$invoice['para_birimi']) . '</td>

                            </tr>';


                    $c++;
                } ?>

                </tbody>
            </table>
        </div>

        <div class="card-body">
            <div class="d-lg-flex flex-lg-wrap">

                <div class="pt-2 mb-3 wmin-lg-400 ml-auto">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>ARA TOPLAM:</th>
                                <td class="text-right"><?php echo amountFormat($sub_t,$invoice['para_birimi']) ?></td>
                            </tr>
                            <tr>
                                <th>İSKONTO:</th>
                                <td class="text-right"><?php echo amountFormat($invoice['discount'],$invoice['para_birimi']) ?></td>
                            </tr>
                            <tr>
                                <th>NET TOPLAM:</th>
                                <td class="text-right "><?php echo amountFormat($sub_t-$invoice['discount'],$invoice['para_birimi']) ?></td>
                            </tr>
                            <tr>
                                <th>TOPLAM KDV:</th>
                                <td class="text-right "><?php echo amountFormat($invoice['tax'],$invoice['para_birimi']) ?></td>
                            </tr>
                            <tr>
                                <th>GENEL TOPLAM:</th>
                                <td class="text-right "><?php echo amountFormat($invoice['total'],$invoice['para_birimi']) ?></td>
                            </tr>
                            <tr>
                                <th>ALINAN ÖDEME:</th>
                                <td class="text-right "><?php echo amountFormat($invoice['pamnt'],$invoice['para_birimi']);?></td>
                            </tr>
                            <tr>
                                <th>BEKLEYEN BAKIYE:</th>
                                <?php
                                $rming = $invoice['total'] - $invoice['pamnt'];
                                if ($rming < 0) {
                                    $rming = 0;

                                }
                                ?>
                                <td class="text-right "><?php echo amountFormat($rming,$invoice['para_birimi']);?></td>
                            </tr>
                            <tr>
                                <th>AZN TOPLAM:</th>
                                <?php
                                $rming = $invoice['total']*$invoice['kur_degeri'];
                                ?>
                                <td class="text-right "><?php echo amountFormat($rming,1);?></td>
                            </tr>
                            <tr>
                                <th>KUR DEĞERI:</th>
                                <td class="text-right "><?php echo amountFormat($invoice['kur_degeri']); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <span class="text-muted"><?php echo $invoice['notes'] ?></span>
        </div>
        <div class="card-footer">
            <span class="text-muted"><?php echo $invoice['pers_notes'] ?></span>
        </div>


        <div class="col-md-12">
            <h3 style="text-align: center">TƏSDIQLƏMƏ SIRASI</h3>
            <table class="table">

                <?php
                if(talep_onay_new_invoices(1,$_GET['id'])){

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




                    foreach (talep_onay_new_invoices(1,$_GET['id']) as $items) {
                        $durum='-';
                        $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                        if($items->status==1){
                            $durum='Onaylandı';
                            $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                        }
                        if($items->staff==1 && $items->status==0){
                            $durum='Gözləmedə';
                            $button='<button class="btn btn-info onayla" sort_number="'.$items->id.'" aauth_id="'.$this->aauth->get_user()->id.'" sort="'.$items->sort.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                        }
                        ?>
                        <tr>
                            <!--?php echo roles(role_id($items->user_id))?-->
                            <th>(Qaime Onayı)</th>
                            <th><?php echo personel_details($items->user_id)?></th>
                            <th><?php echo $durum;?></th>
                            <th><?php echo $button;?></th>
                        </tr>
                        <?php
                    }
                }
                else {
                    ?>
                    <tr><td style="text-align: center"><b>Bildirim Başlatılmamış</b></td></tr>
                    <?php
                }
                ?>
            </table>
        </div>

        <div class="col col-md-12 col-xs-12">
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
        </div>

        <div class="card-footer">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Files') ?></th>


                            </tr>
                            </thead>
                            <tbody id="activity">
                            <?php foreach ($attach as $row) {

                                echo '<tr><td><a data-url="' . base_url() . 'invoices/file_handling?op=delete&name=' . $row['col1'] . '&invoice=' . $invoice['id'] . '" class="aj_delete"><i class="btn-danger btn-lg fa fa-trash"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
                            } ?>

                            </tbody>
                        </table>
                        <div class="custom-file">
                            <input id="fileupload" type="file" class="custom-file-input required" name="files[]" multiple>
                            <label class="custom-file-label" for="customFile">Dosy Seç</label>
                        </div>

                        <br>
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <table id="files" class="files"></table>
                        <br>
                    </div>
                    <div class="col-md-6">
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
                            <?php if(talep_borclandirma($invoice['id'],6)){
                                foreach (talep_borclandirma($invoice['id'],6) as $b_items){
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

            </div>

        </div>

    </div>
    <!-- /invoice template -->


</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
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
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            closeIcon: true,
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Dosyayı Silmek İstediğinizden Emin Misiniz?',
            buttons:{
                prev: {
                    text: 'Evet',
                    btnClass: "btn btn-link text-dark",
                    action: function (){

                        jQuery.ajax({
                            url: aurl,
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: 'Başarıyla Silindi',
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                obj.closest('tr').remove();
                                                obj.remove();
                                            }
                                        }
                                    }
                                });

                            }
                        });
                    }
                }
            }
        });


    });
    $(document).on('click','.part_payment',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İşlem Bilgileri ',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="name">Tutar</label>
                                        <input type="text" class="form-control" placeholder="Total Amount" name="amount" id="rmpay" value="<?php echo $rming ?>">
                                    </div>
                                    <div class="col-lg-6">
                                         <label for="name">İş Avansı</label>
                                        <input type="checkbox" class="form-control" name="is_avansi" id="is_avansi">
                                        <input type="hidden"  name="status_is_avans" id="status_is_avans" value="0">
                                        <input type="hidden" id="pay_array" name="pay_array" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <label for="name">Para Birimi</label>
                                        <select name="para_birimi" id="para_birimi" class="form-control">
                                            <?php
                                            foreach (para_birimi()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['code'];
                                                echo "<option value='$cid'>$title</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                         <label for="name"><?php echo invoice_type_desc($invoice['invoice_type_id'])?> Kuru</label>
                                        <input type="text" class="form-control" placeholder="Kur" name="kur_degeri" id="kur_degeri" value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="name">Ödeme Türü</label><span class='text-danger'>*</span>
                                        <select class="form-control select-box paymethod zorunlu" id="pmethod" name="pmethod">
                                           <option value="">Seçiniz</option>
                                           <?php foreach (account_type_islem() as $acc)
                                                {
                                                    echo "<option value='$acc->id'>$acc->name</option>";
                                                } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                         <label for="name">Tür</label><span class='text-danger'>*</span>
                                         <select class="form-control zorunlu select-box pay_type" id="pay_type" name="pay_type">
                                           <option value="">Ödeme Türü Seçiniz</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                         <label for="name">Hesap</label><span class='text-danger'>*</span>
                                        <select class="form-control zorunlu  select-box pay_acc" id="pay_acc" name="pay_acc">
                                          <option value="">Ödeme Türü Seçiniz</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="name">Not</label>
                                        <input type="text" class="form-control shortnote"
                                   name="shortnote" placeholder="Short note"
                                   value="<?php echo invoice_type_desc($invoice['invoice_type_id'])?> No : <?php echo $invoice['invoice_no'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name_say = $('.zorunlu').length;
                        let req = 0 ;
                        for (let i = 0; i < name_say;i++){
                            let name = $('.zorunlu').eq(i).val();
                            if(!parseInt(name)){
                                req++;
                            }
                        }
                        if(req > 0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Yıldızlı Alanlar Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        let data = {
                            'cari_id':<?php echo $invoice['csd'] ?>,
                            'invoice_id':<?php echo $invoice['id'] ?>,
                            'amount': $('#rmpay').val(),
                            'para_birimi': $('#para_birimi').val(),
                            'kur_degeri': $('#kur_degeri').val(),
                            'paymethod': $('#pmethod').val(),
                            'pay_type': $('#pay_type').val(),
                            'pay_acc': $('#pay_acc').val(),
                            'notes': $('#shortnote').val(),
                            'status_is_avans': $('#status_is_avans').val(),
                            'status_is_avans': $('#status_is_avans').val(),
                            'pay_array': $('#pay_array').val(),
                        };
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'transactions/new_payinvoice',data,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action:function (){

                                            }
                                        }
                                    }
                                });
                            }
                            else if(data.status==410) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }


                        })

                    }}
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
    });

    $(document).on('change','.paymethod',function (){
        $(".pay_type option").remove();
        let proje_id  =$(this).val();
        let data = {
            crsf_token: crsf_hash,
            cari_pers_type: 1,
        }
        $.post(baseurl + 'transactions/pay_type_get',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.pay_type').append(new Option('Seçiniz', '', false, false));
            responses.items.forEach((item_,index) => {
                if(item_.id==17 || item_.id==18 || item_.id==19 || item_.id==20){
                    $('.pay_type').append(new Option(item_.description, item_.id, false, false));
                }

            })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })
    $(document).on('change','.pay_type',function (){

        $(".pay_acc option").remove();
        let pay_type  = $(this).val();
        let data = {
            crsf_token: crsf_hash,
            cari_pers_type: 1,
            pay_type: pay_type,
            payer_id: <?php echo $invoice['csd']?>,
            paymethod: $('.paymethod').val(),
        }
        $.post(baseurl + 'transactions/pay_type_next_process',data,(response) => {
            let responses = jQuery.parseJSON(response);

            if(responses.list_durum){
                if(responses.account_list.length > 0){
                    $('.pay_acc').append(new Option('Seçiniz', '', false, false));
                    responses.account_list.forEach((item_,index) => {
                        $('.pay_acc').append(new Option(item_.holder, item_.id, false, false));
                    })
                }
                else if(!responses.account_list){
                    $('.account_div').removeClass('d-none');
                    $('.pay_acc').append(new Option('Size Ait Kasa Bulunamadı', '', false, false));

                }
            }
            else {
                $('.pay_acc').append(new Option('Size Ait Kasa Bulunamadı', '', false, false));
            }


            // $('.pay_type').append(new Option('Seçiniz', '', false, false));
            // responses.items.forEach((item_,index) => {
            //     $('.pay_type').append(new Option(item_.description, item_.id, false, false));
            // })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })

    $(document).on('change', "#is_avansi", function (e) {

        let status = $("input[type='checkbox']").prop('checked')?1:0

        $('#status_is_avans').val(status);
        if(status){

            $('.is_avans_kasa').css('display','block');

            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Personel İş Avansları',
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
                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<label>Personel İş Avansları</label>' +
                        '<div id="cari_table"></div>' +
                        '</div>' +
                        '</div>' +
                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    $.post(baseurl + 'personelaction/personel_pay_list',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        let  table='';
                        if(responses.status=='Success'){
                            if(responses.count!=0){
                                table =`<table class="table"><thead><tr>
                                    <td>#</td>
                                    <td>Personel</td>
                                    <td>Tutar</td>
                                    <td>Ödenen</td>
                                    <td>Tip</td>
                                    <td>Not</td>
                                    <td>Tarih</td>
                                    <td>Kasa</td>
                                    </tr>`;

                                let pay_array = $('#pay_array').val();
                                let arr = pay_array.split(',');
                                responses.data.forEach((item_,index) => {
                                    let checked = '';
                                    if(jQuery.inArray(item_.id, arr) !== -1){
                                        checked = 'checked';
                                    }
                                    table+=`<tr>
                                <td><input `+checked+` type="checkbox" class="form-control name transaction_id" index_number='`+index+`' name="transaction_id[]" value="`+item_.id+`"></td>
                                <td>`+item_.personel+`</td>
                                <td>`+item_.amount+`</td>
                                <td><input type="number" value="`+item_.amount_float+`" class="form-control odenen_tutar" name="odenen_tutar[]"></td>
                                <td>`+item_.tip+`</td>
                                <td>`+item_.notes+`</td>
                                <td>`+item_.date+`</td>
                                <td>`+item_.kasa+`</td>
                            </tr>`;
                                })
                                table +=`</tbody></table>`
                            }
                            else {
                                table='<p style="text-align: center">Herhangi Bir Ödeme Bulunamadı</p>';
                            }

                        }
                        else {
                            table=responses.messages;
                        }

                        $('#cari_table').empty().html(table);

                    });


                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Seçili Olanları Faturaya Bağla ',
                        btnClass: 'btn-blue',
                        action: function () {
                            var name = this.$content.find('.name').val();
                            if(!name){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Tüm Alanlar Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }

                            let avans_details=[];
                            let length = $("input[name='transaction_id[]']:checked").length;
                            if(length > 0 ){
                                for(let i = 0; i< length; i++){

                                    let index_number = $("input[name='transaction_id[]']:checked").eq(i).attr('index_number');
                                    avans_details.push ({
                                        id:$("input[name='transaction_id[]']:checked").eq(i).val(),
                                        price:$('.odenen_tutar').eq(index_number).val()

                                    });

                                }


                                localStorage.setItem('pay_array', JSON.stringify(avans_details));



                                $('#pay_array').val( localStorage.getItem('pay_array'));

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı!',
                                    content: 'Başarılı Bir Şekilde Seçildi',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

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
            $('.is_avans_kasa').css('display','none');
        }


    })

    $(document).on('click','.invoice_iptal',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal Etmek İstediğinizden Emin Misiniz? ',
            icon: 'fa fa-question',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`       <div class="col-lg-12">
                                       <input type='text' class='form-control' id='desc' placeholder="İptal Sebebi">
                                    </div>`,
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {

                        let desct=$('#desc').val();
                        if(!desct){
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


                        let data = {
                            'invoice_id':<?php echo $invoice['id'] ?>,
                            'status_id':3,
                            'desc':$('#desc').val(),
                        };
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'invoices/new_cancelinvoice',data,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else if(data.status==410) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }


                        })

                    }}
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

    $(document).on('click','.invoice_status_change',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat ',
            icon: 'fa fa-pen',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`       <div class="col-lg-12">
                                        <label for="name">Durum</label>
                                        <select name="Durum" id="status_id" class="form-control">
                                            <?php
                                            foreach (invoice_status()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['name'];
                                                echo "<option value='$cid'>$title</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>`,
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            'invoice_id':<?php echo $invoice['id'] ?>,
                            'status_id':$('#status_id').val()
                        };
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'invoices/new_cancelinvoice',data,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else if(data.status==410) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }


                        })

                    }}
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

    $(document).on('click','.unit_reverse',function (){
        let id=$(this).data('id');
        let invoice_id=$(this).data('invoice_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Birim Güncelleme',
            icon: 'fa fa-check',
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
                            <select class="form-control select-box" id="unit_id_update">
                                    <?php foreach (units() as $emp){
                    $emp_id=$emp['id'];
                    $name=$emp['name'];
                    $selected='';

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
                            unit_id:$('#unit_id_update').val(),
                            crsf_token: crsf_hash,
                            invoice_item_id: id,
                            invoice_id: invoice_id
                        }
                        $.post(baseurl + 'invoices/update_unit',data_update,(response)=>{
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



    $(document).on('click',"#onay_iste",function(e) {

        var invoice_id=<?php echo  $_GET['id']; ?>;
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
                            talep_id:invoice_id,
                            type:1
                        }
                        $.post(baseurl + 'invoices/onay_baslat',data,(response)=>{
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
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });



        // jQuery.ajax({
        //     url: baseurl + 'formainvoices/bildirim_olustur',
        //     type: 'POST',
        //     data: {
        //         'invoice_id':invoice_id,
        //     },
        //     dataType: 'json',
        //     beforeSend: function(){
        //         $("#onay_iste").html('Bekleyiniz');
        //         $("#onay_iste").prop('disabled', true); // disable button
        //
        //     },
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //             $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
        //             $("html, body").scrollTop($("body").offset().top);
        //             $('#pstatus').html(data.pstatus);
        //             $("#onay_iste").html('Onay Sistemine Sunulmuştur.');
        //             $("#onay_iste").prop('disabled', true); // disable button
        //
        //         } else {
        //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //             $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        //             $("html, body").scrollTop($("body").offset().top);
        //         }
        //     },
        //     error: function (data) {
        //         $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //         $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        //         $("html, body").scrollTop($("body").offset().top);
        //     }
        // });
    });


    $(document).on('change','#status',function (){
        let status_id = $(this).val();
        if(status_id==-1){
            let data = {
                talep_id:<?php echo  $_GET['id']; ?>,
            }
            $.post(baseurl + 'invoices/check_pers_all',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status==200){
                    let option='';
                    $.each(responses.details, function (index, items) {
                        option+='<option onay_id="'+items.id+'"  sort="'+items.sort+'" value="'+items.user_id+'">'+items.name+'</option>'
                    });
                    let html=`<div class="form-group">
                        <label for="firma_id">Göndermek İstediğiniz Personel</label>
                            <select class="form-control" id="staff_pers_id">
                                `+option+`
                            </select>
                            </div>`;

                    $('.div_appaned').empty().append(html);
                }
                else {
                    $('.div_appaned').empty();
                    $.alert({
                        theme: 'material',
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

            });


        }
        else {
            $('.div_appaned').empty();
        }
        var invoice_id=<?php echo  $_GET['id']; ?>;
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
                icon: 'fa fa-question',
                type: 'orange',
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
<div class="div_appaned"></div>
                             <div class="form-group">
                              <label for="firma_id">Açıklama</label>
                                <input type="text" class="form-control" id="desc" placeholder="İnceledim Onaylıyorum">
                            </div>
                </form>`,

                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            let status = $('#status').val()
                            let desc = $('#desc').val()
                            if(!parseInt(status) || status==-1){
                                if(!desc){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Açıklama Yazmak Zorundasınız',
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
                            else {
                                desc =$('#desc').attr('placeholder');
                            }

                            let staff_details = [];
                            if(status==-1){
                                staff_details = {
                                    staff_id: $('#staff_pers_id').val(),
                                    sort_id: $('option:selected', $('#staff_pers_id')).attr('sort'),
                                    onay_id: $('option:selected', $('#staff_pers_id')).attr('onay_id')
                                };
                            }

                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:<?php echo  $_GET['id']; ?>,
                                status: $('#status').val(),
                                desc:desc,
                                aauth_sort:sort,
                                staff_details:staff_details,
                                type:1,
                            }
                            $.post(baseurl + 'invoices/onay_olustur',data,(response)=>{
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

    $(document).ready(function (){
        draw_data_history();
    })

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
                'url': "<?php echo site_url('formainvoices/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: <?php echo  $_GET['id']; ?>,
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