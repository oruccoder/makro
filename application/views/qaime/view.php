<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo invoice_type_desc($invoice->invoice_type_id)?> Görüntüle</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            <?php echo invoice_type_desc($invoice->invoice_type_id)?> Görüntüleme
        </div>
    </div>
</div>
<div class="container-fluid">
    <!-- Ana İçerik -->
    <div class="content" id="content">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class=" bg-transparent header-elements-inline py-0">
                        <h6 class="card-title py-3">Fatura Kodu : <b><?php echo $invoice->invoice_no; ?> </b>| Proje Kodu : <b><?php echo proje_code($invoice->proje_id) ?></b> </h6>
                        <div class="header-elements">
                            <button  islem_tipi="2" islem_id="<?php echo $invoice->id?>" type="button" class="btn btn-light btn-sm add_not_new"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Not Ekle"><i class="fa fa-notes-medical"></i></button>&nbsp;&nbsp;
                            <button  onclick="details_notes()" type="button" class="btn btn-light btn-sm button_view_notes"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Notları Görüntüle"><i class="fa fa-list"></i></button>&nbsp;&nbsp;
                            <a href="/demirbas/invoicecreate/<?php echo $invoice->id?>" type="button" class="btn btn-light btn-sm" target="_blank"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Gidere İşle"><i class="fa fa-plus"></i> </a>&nbsp;&nbsp;
                            <?php
                            $disabled='';
                            if($invoice->status==3 ){
                                $disabled='disabled';
                            }
                            ?>

                            <a type="button" href="<?php echo '/invoices/odeme_gecmisi?id='.$invoice->id.'&tip=3'; ?>" class="btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Ödeme Geçmişi"><i class="icon-printer "></i></a>
                            <button <?php echo $disabled;?>  type="button" class="part_payment btn btn-light btn-sm ml-2" title="Partial Payment" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Tahsilat Ekle"><i class="fa fa-money-bill"></i></button>
                            <?php
                            $disabled_onay_s='disabled';
                            if($invoice->status==1) {
                                $disabled_onay_s='';
                            }
                            if($this->aauth->get_user()->id==39){
                                $disabled_onay_s='';
                            }

                            ?>

                            <button  <?php echo $disabled;?>  type="button" data-invoice-id="<?= $invoice->id ?>" class="invoice_iptal btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal Et"><i class="icon-cancel-circle2 "></i>  </button>

                            <?php
                            if($invoice->bildirim_durumu){

                                if ($invoice->status != 0 && $invoice->status != 1) {
                                    ?>
                                    <button  data-invoice-id="<?= $invoice->id ?>"  type="button" class="invoice_status_change btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Durum Değiştir"><i class="icon-check2"></i>  </button>

                                    <?php
                                }
                            }
                            ?>

                            <?php
                            if ($invoice->status != 3 && !$invoice->bildirim_durumu) {

                            ?>
                                    <a type="button"  href="<?php echo '/qaime/edit/' . $invoice->id; ?>" class="btn btn-light btn-sm" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Düzenle"><i class="icon-file-check"></i></a>
                                    <button  id="onay_iste"  data-invoice-id="<?= $invoice->id ?>" type="button" class="btn btn-light btn-sm ml-2"  data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onay Sistemini Başlat"><i class="fa fa-bell"></i> </button>

                                    <?php
                                }
                            ?>

                            <button  type="button" class="btn btn-light btn-sm ml-2 button_podradci_borclandirma" islem_id="<?php echo $invoice->id ?>" islem_tipi="6" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
                            <button  type="button" class="btn btn-light btn-sm ml-2 button_podradci_borclandirma" islem_id="<?php echo $invoice->id ?>" islem_tipi="6" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>



                        </div>

                    </div>
                </div>

                <div id="print_page">
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Müşteri Bilgileri -->
                                <div class="mb-4">
                                    <div class="d-inline-flex align-items-center mt-2 mb-1" >
                                        <img src="<?php  $loc=location($invoice->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>" class="mb-3 mt-2" alt="" style="width: 200px;">
                                    </div>
                                    <ul class="list list-unstyled mb-0">
                                        <li><span class="font-weight-semibold"><?php echo $customer_details->company; ?></span></li>
                                        <li><?php echo $customer_details->address.' '.$customer_details->city.' '.$customer_details->region; ?></li>
                                        <li><?php echo $customer_details->country; ?></li>
                                        <li><?php echo $customer_details->phone; ?></li>

                                    </ul>
                                    <?php if(invoice_to_talep($invoice->id,0)){ ?>
                                        <div class="list list-unstyled" >
                                            <b>Bağlı Malzeme Talepleri</b><br>
                                            <?php echo invoice_to_talep($invoice->id,0); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(qaime_to_nakliye($invoice->id)){ ?>
                                        <div class="list list-unstyled" >
                                            <b>Bağlı Olduğu Nakliyeler</b><br>
                                            <?php  echo qaime_to_nakliye($invoice->id); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if(qaime_to_forma2($invoice->id)){ ?>
                                        <div class="list list-unstyled" >
                                            <b>Bağlı Olduğu Forma 2</b><br>
                                            <?php  echo qaime_to_forma2($invoice->id); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if(qaime_to_talep($invoice->id)){ ?>
                                        <div class="list list-unstyled" >
                                            <b>Bağlı Olduğu Malzeme Talepleri</b><br>
                                            <?php  echo qaime_to_talep($invoice->id); ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Fatura Bilgileri -->
                                <div class="text-sm-right mb-4">
                                    <h4 class="text-primary mb-2 mt-lg-2"><?php echo invoice_type_desc($invoice->invoice_type_id)?> # <?php echo $invoice->invoice_no;?></h4>
                                    <ul class=" mb-2 mt-lg-2" style="list-style: none;">
                                        <li>Toplam Tutar : <span class="font-weight-semibold"><?php echo amountFormat($invoice->total,$invoice->para_birimi) ?></span></li>
                                        <li><?php echo invoice_type_desc($invoice->invoice_type_id)?> Tarihi: <span class="font-weight-semibold"><?php echo date_izin($invoice->invoicedate) ?></span></li>
                                        <li><?php echo invoice_type_desc($invoice->invoice_type_id)?> Durumu: <span class="font-weight-semibold"><?php echo ($invoice->status?invoice_status($invoice->status):'Bekliyor') ?></span></li>
                                        <li>Fatura Açıklama : <?php echo $invoice->notes ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                <tr>
                                    <th>Sıra</th>
                                    <th>Mehsul</th>
                                    <th class="text-xs-left">Vahid Qiymət</th>
                                    <th class="text-xs-left">Miqdar</th>
                                    <th class="text-xs-left">ƏDV Oran</th>
                                    <th class="text-xs-left">ƏDV Tutar</th>
                                    <th class="text-xs-left">Endirim Oran (<?php echo ($invoice->format_discount == '%' ? '%' : 'Sabit'); ?>)</th>
                                    <th class="text-xs-left">Endrim Toplamı</th>
                                    <th class="text-xs-left">Cemi (İndirimli)</th>
                                    <th class="text-xs-left">Cemi (İndirimsiz)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sub_t=0;
                                foreach ($products as $key=>$item){
                                    $xx = '';
                                    if($invoice->invoice_type_id==24 || $invoice->invoice_type_id==41){
                                        if($item->demirbas_id){
                                            $xx = who_demirbas($item->demirbas_id)->name ? who_demirbas($item->demirbas_id)->name : '';

                                        }
                                    }
                                    else {
                                        $xx= '<span class="text-muted">'.$item->product_code.'</span>';
                                    }
                                    $product_name = $item->product_name.' | '.$xx;
                                    $sub_t += $item->price*$item->qty;
                                    echo '<tr>';
                                    echo '<td>'.(intval($key)+1).'</td>';
                                    echo '<td>'.$product_name.'</td>';
                                    echo '<td>'.amountFormat($item->price).'</td>';
                                    echo '<td>'.amountFormat_s($item->qty).' '.units_($item->unit)['name'].'</td>';
                                    echo '<td>'.amountFormat_s($item->tax).'</td>';
                                    echo '<td>'.amountFormat($item->totaltax).'</td>';
                                    echo '<td>'.amountFormat_s($item->discount).'</td>';
                                    echo '<td>'.amountFormat($item->totaldiscount).'</td>';
                                    echo '<td>'.amountFormat(($item->price*$item->qty)-$item->totaldiscount).'</td>';
                                    echo '<td>'.amountFormat($item->price*$item->qty).'</td>';
                                    echo '</tr>';

                                } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="10"></td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1" style="text-align: left"><b>Cəmi</b></td>
                                    <td><b><?=amountFormat($invoice->subtotal,$invoice->para_birimi)?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1" style="text-align: left"><b>Güzəşt</b></td>
                                    <td><b><?=amountFormat($invoice->discount,$invoice->para_birimi)?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1" style="text-align: left"><b>Net Cemi</b></td>
                                    <td><b><?=amountFormat(floatval($sub_t)-floatval($invoice->discount),$invoice->para_birimi)?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1" style="text-align: left"><b>ƏDV</b></td>
                                    <td><b><?=amountFormat($invoice->tax,$invoice->para_birimi)?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1" style="text-align: left"><b>ümumi Cəmi</b></td>
                                    <td><b><?=amountFormat($invoice->total,$invoice->para_birimi)?></b></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="col-md-12">
                    <h3 style="text-align: center">TƏSDIQLƏMƏ SIRASI</h3>
                        <?php
                        if(new_talep_onay_new_invoices(1,$invoice->id)['status']){
                            echo new_talep_onay_new_invoices(1,$invoice->id)['html'];
                        }
                        else {
                            ?>
                                <table class="table table-bordered">
                                        <tr><td style="text-align: center"><b>Bildirim Başlatılmamış</b></td></tr>
                                </table>
                            <?php
                        }
                        ?>

                </div>
                <hr>
                <div class="col-md-12 text-center ">
                    <button  type="button" class="hover_effect btn btn-secondary history_view"  data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Qaime Hareketlerini Görüntüle"><i class="fa fa-list"></i> Qaime Hareketlerini Göster/Gizle</button>

                </div>
                <hr>
                <div class="col-md-12 row history_card" style="visibility: hidden; display: none;" id="history_card">
                    <div class="col-md-12">
                        <h2 class="text-bold-700" style="text-align: center;text-decoration: underline;font-family: monospace;">Talep Hareketleri</h2>
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
                    <div class="col-md-12">
                        <h2 class="text-bold-700" style="text-align: center;text-decoration: underline;font-family: monospace;">Qaime İle İlgili Borçlandırmalar</h2>
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
                            <?php if(talep_borclandirma($invoice->id,6)){
                                foreach (talep_borclandirma($invoice->id,6) as $b_items){
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
</div>
<style>

    .hover_effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .dikkat_button{
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
    }
    @media print {
        body * {
            visibility: hidden; /* Tüm içeriği gizle */
        }

        #print_page, #print_page * {
            visibility: visible; /* Sadece yazdırılacak içeriği göster */
        }

        #print_page {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; /* Tüm genişliği kapla */
        }

        /* Sayfanın sığdırılması */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: auto;
        }

        table {
            width: 100%; /* Tablo genişliği tamamen kullan */
            border-collapse: collapse;
        }

        table th, table td {
            font-size: 14px; /* Daha küçük yazı boyutu */
            padding: 3px; /* Hücre içi boşluk */
        }


        /* Sayfa kırılmaları önleme */
        .no-break {
            page-break-inside: avoid;
        }
    }
</style>
<?php
$talep_data = new_talep_onay_new_invoices(1, $invoice->id);
$users = isset($talep_data['onay_veren_id_array']) ? $talep_data['onay_veren_id_array'] : [];
?>
<script>

    $('.history_view').on('click', function () {
        const card = $('#history_card');

        if (card.css('visibility') === 'hidden') {
            card.css('visibility', 'visible').slideDown('slow'); // Açılma efekti
        } else {
            card.slideUp('slow', function () {
                card.css('visibility', 'hidden'); // Kapanma efekti

            });
        }
    });
    function details_notes() {
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
            content: `<?= $content ?>`,
            buttons: {
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            }
        });
    }
    $(document).on('click', '.part_payment', function () {
        $.get(baseurl + 'qaime/get_payinvoice_form_data?invoice_id=<?php echo $invoice->id ?>', function (responses) {
            let response = jQuery.parseJSON(responses);

            // Sunucudan gelen veriler
            const {
                rming,
                para_birimi,
                invoice_type_desc,
                invoice_no,
                invoice_id,
                csd,
                account_types
            } = response;

            let para_birimi_options = '';
            para_birimi.forEach(row => {
                para_birimi_options += `<option value="${row.id}">${row.code}</option>`;
            });

            let account_options = '';
            account_types.forEach(acc => {
                account_options += `<option value="${acc.id}">${acc.name}</option>`;
            });

            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'İşlem Bilgileri',
                icon: 'fa fa-plus',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "medium",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: `
                <form>
                    <div class="form-group">
                        <label for="name">Tutar</label>
                        <input type="text" class="form-control" name="amount" id="rmpay" value="${rming}">
                    </div>
                    <div class="form-group">
                        <label for="name">Para Birimi</label>
                        <select name="para_birimi" id="para_birimi" class="form-control">
                            ${para_birimi_options}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">${invoice_type_desc} Kuru</label>
                        <input type="text" class="form-control" name="kur_degeri" id="kur_degeri" value="1">
                    </div>
                    <div class="form-group">
                        <label for="name">Ödeme Türü</label>
                        <select class="form-control paymethod" id="pmethod" name="pmethod">
                            <option value="">Seçiniz</option>
                            ${account_options}
                        </select>
                    </div>
                        <div class="form-group">
                         <label for="name">Tür</label><span class='text-danger'>*</span>
                         <select class="form-control zorunlu select-box pay_type" id="pay_type" name="pay_type">
                           <option value="">Ödeme Türü Seçiniz</option>
                        </select>
                    </div>
                    <div class="form-group">
                         <label for="name">Hesap</label><span class='text-danger'>*</span>
                        <select class="form-control zorunlu  select-box pay_acc" id="pay_acc" name="pay_acc">
                          <option value="">Ödeme Türü Seçiniz</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="name">Not</label>
                                <input type="text" class="form-control shortnote"
                           name="shortnote" placeholder="Short note"
                           value="<?php echo invoice_type_desc($invoice->invoice_type_id)?> No : <?php echo $invoice->invoice_no ?>">
                            </div>
                        </div>
                    </div>
                </form>`,
                buttons: {
                    formSubmit: {
                        text: 'Devam',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none'); // Yükleme ekranını göster
                            let data = {
                                'cari_id':<?php echo $invoice->csd ?>,
                                'invoice_id':<?php echo $invoice->id ?>,
                                'amount': $('#rmpay').val(),
                                'para_birimi': $('#para_birimi').val(),
                                'kur_degeri': $('#kur_degeri').val(),
                                'paymethod': $('#pmethod').val(),
                                'pay_type': $('#pay_type').val(),
                                'pay_acc': $('#pay_acc').val(),
                                'notes': $('#shortnote').val(),
                                'pay_array': $('#pay_array').val(),
                            };

                            $.ajax({
                                url: baseurl + 'transactions/new_payinvoice', // Sunucuya gönderilecek endpoint
                                type: 'POST',
                                dataType: 'json',
                                data: data,
                                success: function (response) {
                                    if (response.status === 200) {
                                        $('#loading-box').addClass('d-none'); // Yükleme ekranını göster

                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-check',
                                            type: 'green',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Başarılı!',
                                            content: response.message,
                                            buttons: {
                                                prev: {
                                                    text: 'Tamam',
                                                    btnClass: "btn btn-link text-dark",
                                                    action: function () {
                                                        location.reload();
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        $('#loading-box').addClass('d-none'); // Yükleme ekranını göste
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Dikkat!',
                                            content: response.message,
                                            buttons: {
                                                prev: {
                                                    text: 'Tamam',
                                                    btnClass: "btn btn-link text-dark"
                                                }
                                            }
                                        });
                                    }
                                },
                                error: function () {
                                    $('#loading-box').addClass('d-none'); // Yükleme ekranını göster

                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Sunucu Hatası',
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'Kapat',
                        btnClass: 'btn-danger'
                    }
                }
            });
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
            payer_id: <?php echo $invoice->csd?>,
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
    $(document).on('click', '.invoice_iptal', function () {
        let invoice_id = $(this).data('invoice-id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal Etmek İstediğinizden Emin Misiniz?',
            icon: 'fa fa-question',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
            <div class="col-lg-12">
                <input type="text" class="form-control" id="desc" placeholder="İptal Sebebi">
            </div>
        `,
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        let desct = $('#desc').val();
                        if (!desct.trim()) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                title: 'Dikkat!',
                                content: 'İptal sebebi boş olamaz. Lütfen bir açıklama girin.',
                            });
                            return false;
                        }

                        let data = {
                            'invoice_id': invoice_id,
                            'status_id': 3,
                            'desc': desct.trim(),
                        };

                        $('#loading-box').removeClass('d-none'); // Yükleme ekranını göster

                        $.post(baseurl + 'invoices/new_cancelinvoice', data, (responses) => {
                            let response = jQuery.parseJSON(responses);

                            $('#loading-box').addClass('d-none'); // Yükleme ekranını gizle

                            if (!response || typeof response !== 'object') {
                                $.alert({
                                    theme: 'modern',
                                    type: 'red',
                                    title: 'Hata',
                                    content: 'Sunucudan geçerli bir yanıt alınamadı!',
                                });
                                return;
                            }

                            if (response.status === 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    title: 'Başarılı',
                                    content: response.message,
                                    buttons: {
                                        ok: {
                                            text: 'Tamam',
                                            action: function () {
                                                location.reload(); // Sayfayı yeniler
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    title: 'Dikkat!',
                                    content: response.message || 'Bir hata oluştu.',
                                });
                            }
                        }).fail(() => {
                            $('#loading-box').addClass('d-none'); // Yükleme ekranını gizle
                            $.alert({
                                theme: 'modern',
                                type: 'red',
                                title: 'Hata',
                                content: 'Sunucuya bağlanırken bir hata oluştu. Lütfen tekrar deneyin.',
                            });
                        });
                    }
                },
                cancel: {
                    text: 'Hayır',
                    btnClass: 'btn-danger'
                }
            }
        });
    });
    $(document).on('click', '.invoice_status_change', function () {
        let invoice_id = $(this).data('invoice-id');

        $.get(baseurl + 'qaime/get_invoice_status', function (responses) {
            let statuses = jQuery.parseJSON(responses);

            let options = '';
            statuses.forEach(status => {
                options += `<option value="${status.id}">${status.name}</option>`;
            });

            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-pen',
                type: 'red',
                content: `
                <div class="col-lg-12">
                    <label for="status_id">Durum</label>
                    <select id="status_id" class="form-control">${options}</select>
                </div>
            `,
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            let status_id = $('#status_id').val();
                            if (!status_id) {
                                $.alert('Durum seçimi zorunludur!');
                                return false;
                            }

                            let data = {
                                invoice_id: invoice_id,
                                status_id: status_id,
                            };

                            toggleLoading(true);
                            $.post(baseurl + 'invoices/new_cancelinvoice', data, function (responses) {
                                let response = jQuery.parseJSON(responses);

                                toggleLoading(false);
                                if (response.status === 200) {
                                    $.alert({
                                        theme: 'modern',
                                        type: 'green',
                                        title: 'Başarılı',
                                        content: response.message,
                                        buttons: {
                                            ok: {
                                                text: 'Tamam',
                                                action: function () {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert('Hata: ' + response.message);
                                }
                            }).fail(function () {
                                toggleLoading(false);
                                $.alert('Sunucuya bağlanırken bir hata oluştu.');
                            });
                        }
                    },
                    cancel: {
                        text: 'Hayır',
                        btnClass: 'btn-danger'
                    }
                }
            });
        });
    });
    $(document).on('click', "#onay_iste", function (e) {
        var invoice_id = $(this).data('invoice-id'); // Data attribute'den al

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
            content: `
            <form action="" class="formName">
                <div class="form-group">
                    <p>Bildirimi başlatmak üzeresiniz, emin misiniz?</p>
                </div>
            </form>
        `,
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        toggleLoading(true); // Yükleme ekranını göster

                        let data = {
                            talep_id: invoice_id,
                            type: 1,
                        };

                        $.post(baseurl + 'invoices/onay_baslat', data, function (responses) {
                            let response = jQuery.parseJSON(responses);
                            toggleLoading(false); // Yükleme ekranını gizle

                            // Yanıt kontrolü
                            if (!response || typeof response !== 'object') {
                                $.alert({
                                    theme: 'modern',
                                    type: 'red',
                                    title: 'Hata',
                                    content: 'Sunucudan geçerli bir yanıt alınamadı!',
                                });
                                return;
                            }

                            // Başarı ve hata durumları
                            if (response.status === 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    title: 'Başarılı',
                                    content: response.message,
                                    buttons: {
                                        ok: {
                                            text: 'Tamam',
                                            action: function () {
                                                location.reload(); // Sayfayı yenile
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    title: 'Dikkat!',
                                    content: response.message || 'Bir hata oluştu.',
                                });
                            }
                        }).fail(function () {
                            toggleLoading(false); // Yükleme ekranını gizle
                            $.alert({
                                theme: 'modern',
                                type: 'red',
                                title: 'Hata',
                                content: 'Sunucuya bağlanırken bir hata oluştu. Lütfen tekrar deneyin.',
                            });
                        });
                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // Form gönderildiğinde butona tıkla
                });
            }
        });
    });
    function toggleLoading(isLoading) {
        $('#loading-box').toggleClass('d-none', !isLoading);
    }
    $(document).on('click', '.onayla', function () {
        const onay_id = $(this).attr('onay_id');

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Onay',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: "Onay Vermek Üzeresiniz Emin Misiniz?",
            buttons: {
                formSubmit: {
                    text:'Onay Ver',
                    btnClass:'btn btn-info btn-sm',
                    action:function (){
                        $.ajax({
                            url: baseurl + 'qaime/qaime_onay', // Sunucuya gönderilecek endpoint
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                onay_id: onay_id,
                                invoice_id: <?php echo $invoice->id?>
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                                action: function () {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
                                        }
                                    }
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
        });





    });

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
                'url': "<?php echo site_url('qaime/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: <?php echo  $invoice->id; ?>,
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

    $('.reverse_qaime').on('click', function () {

        const onay_id = $(this).attr('onay_id');

        // PHP'den gelen veriyi JSON olarak alın
        let users = <?php echo json_encode($users); ?>;

        // Gelen veriyi kullanarak dinamik bir select kutusu oluşturun
        let select = `
        <form>
        <div class="form-group">
             <select class="form-control" id="personel_id">
                ${Object.values(users).map(item => `
                    <option value="${item.user_id}">${item.name}</option>
                `).join('')}
            </select>
            </div>
            <div class="form-group">
             <input type="text" class="form-control" id="description" placeholder="Açıklama Zorunludur">
            </div>
        </form>
    `;

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Göndermek İstediğiniz Personeli Seçiniz',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: select,
            buttons: {
                formSubmit: {
                    text: 'Geri Gönder',
                    btnClass: 'btn-blue',
                    action: function () {
                        let aciklama = $('#description').val()
                        if(!aciklama){
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
                            'invoice_id':<?php echo $invoice->id ?>,
                            'text':$('#description').val(),
                            'personel_id':$('#personel_id').val(),
                            'onay_id':onay_id
                        };
                        $.ajax({
                            url: baseurl + 'qaime/reverseonay', // Sunucuya gönderilecek endpoint
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if (response.status === 200)
                                {
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                                action: function () {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
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
            }
        });
    });



</script>

<?php
