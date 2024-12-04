<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Lojistik Satınalma Talebi</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <div class="message"></div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="content-body">


                                            <nav>
                                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="nav-talep_form" data-toggle="tab" href="#talep_form" role="tab" aria-controls="nav-home" aria-selected="true">Satın Alma Formu</a>

                                                    <!--                        --><?php //if($details->status==2 || $details->status==3){
                                                    //                            ?>
                                                    <a class="nav-item nav-link" id="nav-gider_form" data-toggle="tab" href="#gider_form" role="tab" aria-controls="nav-profile" aria-selected="false">Giderler</a>
                                                    <a class="nav-item nav-link" id="nav-arac_form" data-toggle="tab" href="#arac_form" role="tab" aria-controls="nav-contact" aria-selected="false">Araç Yönetimi</a>
                                                    <a class="nav-item nav-link" id="nav-notes" data-toggle="tab" href="#notes" role="tab" aria-controls="nav-contact" aria-selected="false">Notlar</a>
                                                    <a class="nav-item nav-link" id="nav-gun" data-toggle="tab" href="#gun" role="tab" aria-controls="nav-contact" aria-selected="false">Əlavə Gün Sayısı</a>
                                                    <a class="nav-item nav-link" id="nav-personel" data-toggle="tab" href="#personelhareketleri" role="tab" aria-controls="nav-contact" aria-selected="false">Personel Hareketleri</a>


                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="talep_form" role="tabpanel" aria-labelledby="nav-home-tab">
                                                    <div id="invoice-template" class="card-body">
                                                        <div class="btn-group ">
                                                            <a  href="<?php echo '/logistics/print/' . $details->id; ?>" class="btn btn-success mb-1"><i class="icon-print"></i> <?php echo $this->lang->line('Print') ?></a>
                                                        </div>

                                                        <?php
                                                        $disabled='';
                                                        if($details->bildirim_durumu) {
                                                            $disabled = 'disabled';
                                                        }
                                                        else {
                                                            ?>
                                                            <div class="btn-group ">
                                                                <a  href="<?php echo '/logistics/edit/' . $details->id; ?>" class="btn btn-warning mb-1"><i class="icon-pencil"></i>Düzenle</a>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                        <div class="btn-group">
                                                            <button <?php echo $disabled; ?> type="button" id="onay_sistemi" talep_id ="<?php echo $details->id ; ?>" class="btn btn-info mb-1"><i class="icon-check"></i>Onay Sistemini Başlat</button>
                                                        </div>
                                                        <div class="btn-group ">
                                                            <button id="talep_iptal"  talep_id ="<?php echo $details->id ; ?>"  class="btn btn-danger mb-1">Talebi İptal Et</button>
                                                        </div>
                                                        <div class="btn-group ">
                                                            <button id="talep_onay"  talep_id ="<?php echo $details->id ; ?>"  class="btn btn-success mb-1">Talebi Onayla</button>
                                                        </div>
                                                        <div class="btn-group ">
                                                            <ul class="px-0 list-unstyled">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-question"></i> Lojistik Talepleri</button>
                                                                    <div class="dropdown-menu">
                                                                        <?php  foreach ($lojistik_talep as $taleps){
                                                                            echo '<a target="_blank" href="/lojistik/view/'.$taleps->l_id.'"  class="btn btn-info btn-sm  ml-1">Lojistik Talebi</a>
                                                        <div class="dropdown-divider"></div>';
                                                                        } ?>
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                        <div id="invoice-company-details" class="row mt-2">
                                                            <div class="col-md-6 col-sm-12 text-xs-center text-md-left" style="font-size: 16px;font-weight: 900;"><p></p>
                                                                <h2>Lojistik Satınalma Talep Formu</h2>
                                                                <p>Talep No : <?php echo $details->talep_no; ?></p>
                                                                <p>Oluştrma Tarihi : <?php echo $details->created_at; ?></p>
                                                                <!--                            <p>Lojistik Müdürü : --><?php //echo personel_details($details->lojistik_muduru); ?><!--&nbsp; &nbsp;--><?php //echo lojistik_durum_kontrol($details->lojistik_muduru,$details->id)?><!--</p>-->
                                                                <!--                            <p>Proje Müdürü : --><?php //echo personel_details($details->proje_muduru); ?><!--</p>&nbsp;&nbsp;--><?php //echo lojistik_durum_kontrol($details->proje_muduru,$details->id)?><!--</p>-->
                                                                <!--                            <p>Genel Müdürü : --><?php //echo personel_details($details->genel_mudur); ?><!--</p>&nbsp;&nbsp;--><?php //echo lojistik_durum_kontrol($details->genel_mudur,$details->id)?><!--</p>-->
                                                                <p>Açıklama : <?php echo $details->description; ?></p>
                                                                <p>Durum : <?php echo lojistik_status($details->status); ?></p>

                                                            </div>
                                                            <!--                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right" style="font-size: 16px;font-weight: 900;"><p></p>-->
                                                            <!--                            <p><b>Seçim Toplamınız</b></p><h1 id="tutar">0.00 AZN</h1><input type="hidden" id="total" value="0">-->
                                                            <!--                        </div>-->
                                                        </div>
                                                        <div>
                                                            <table class="table ">
                                                                <thead>
                                                                <tr>
                                                                    <th>Lokasyon</th>
                                                                    <th>Firma</th>
                                                                    <th>Protokol</th>
                                                                    <th>Proje Adı</th>
                                                                    <!--                                    <th>Açıklama</th>-->
                                                                    <th>SF No</th>
                                                                    <!--                                    <th>Personel</th>-->
                                                                    <th>Araç </th>
                                                                    <th>Miktar </th>
                                                                    <th>Birim </th>
                                                                    <th>Birim Fiyatı</th>
                                                                    <th>KDV Durum</th>
                                                                    <th>KDV Oran</th>
                                                                    <th>Ödeme Metodu</th>
                                                                    <!--                                    --><?php //if($details->status==2){
                                                                    //                                        echo "<th>İşlem</th>";
                                                                    //                                    } ?>
                                                                    <!--                                    <th>Seçim</th>
                                                                    <td><input type='checkbox' class='form-control selected' price='$values->price' qty='$values->qty' lojistik_id='$details->id'  item_id='$key' ></td>
                                                                    -->
                                                                </tr>
                                                                </thead>

                                                                <?php
                                                                $total=0;
                                                                $i=0;
                                                                foreach ($items as $key=> $item) {




                                                                    $sty=' style=""';

                                                                    $rows = count($items)+floatval(1);
                                                                    ?>
                                                                    <tbody <?php echo $sty ?> >
                                                                    <tr>

                                                                        <?php


                                                                        $loc='';
                                                                        $l_id=0;
                                                                        $loc = location_name($item['sf_item_id']);
                                                                        ?>
                                                                        <td rowspan="<?php  echo $rows; ?>" style="text-align: center;vertical-align: inherit;    border-right: 1px solid;"><?php echo $loc ?></td>
                                                                        <?php





                                                                        foreach (lojistik_item_location($details->id,$item['sf_item_id'],2)['items'] as $values_){


                                                                            $values = $values_['result'];
                                                                            if(isset($values->price)){
                                                                                $price = amountFormat($values->price);
                                                                                $metod = account_type_sorgu($values->account_type);
                                                                                $sf_no = lojistik_items_sf($details->id,$values->id,2);
                                                                                $protokol = lojistik_items_protokol($details->id,$values->id,2);
                                                                            }
                                                                            else {
                                                                                $price = amountFormat(0);
                                                                                $metod=0;
                                                                                $sf_no=0;
                                                                                $protokol=0;
                                                                            }



                                                                            $total+=($values->price)*($values->qty);
//                                            $pers = lojistik_items_personel($details->id,$values->id);
                                                                            $kdv='Dahil';
                                                                            if($values->kdv_durum==0){
                                                                                $kdv='Hariç';
                                                                            }
                                                                            //                                                <td>$values->desc</td>
//                                            <td>$pers</td>
                                                                            echo "<tr>
                                                <td>$values->company</td>
                                                <td>$protokol</td>
                                                <td>$values->proje_name</td>
                                                <td>$sf_no</td>
                                                <td>$values->arac_name</td>
                                                <td>$values->qty</td>
                                                <td>$values->unit_name</td>
                                                <td>$price</td>
                                                <td>$kdv</td>
                                                <td>$values->kdv_oran</td>
                                                <td>$metod</td>";
//                                                  if($details->status==2){
//                                                      $lj_satinalma_onay_kontrol = lj_satinalma_onay_kontrol($values->id);
//                                                      if($lj_satinalma_onay_kontrol){
//                                                          echo "<td>$lj_satinalma_onay_kontrol</td>";
//                                                      }
//                                                      else {
//                                                          echo "<td class='hizmet_tamamla_btn'><button eq='$i' id='$values->id' lojistik_id='$details->id' class='btn btn-success islem_bitir'><i class='fa fa-question'></i>&nbsp; Hizmet Tamamlandı</button></td>";
//
//                                                      }
//                                                 }
                                                                            echo "


                                            </tr>
                                            ";
                                                                            $l_id = $values_['l_id'];
                                                                        }
                                                                        ?>

                                                                    </tr>

                                                                    </tbody>
                                                                    <?php   $i++;  } ?>

                                                                <tbody>
                                                                <tr style="font-weight: 900;">
                                                                    <td><span>Net Toplam</span></td>
                                                                    <td><?php echo  amountFormat($total); ?></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Lojistik Müdürü ( <?php echo personel_details($details->lojistik_muduru) ?>)<?php echo lojistiksf_durum_kontrol($details->lojistik_muduru,$details->id) ?></th>
                                                                    <th>Proje Müdürü ( <?php echo personel_details($details->proje_muduru) ?>) <?php echo lojistiksf_durum_kontrol($details->proje_muduru,$details->id) ?></th>
                                                                    <th>Genel Müdür ( <?php echo personel_details($details->genel_mudur) ?>)<?php echo lojistiksf_durum_kontrol($details->genel_mudur,$details->id) ?></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <!--                                    <td style="line-height: 30px;">--><?php //echo personel_details($details->lojistik_muduru); ?><!--<br>--><?php //echo 'Onaylanan Satınalma Tutarı: '.lojistik_sf_details($details->id,$details->lojistik_muduru)['total'] ?><!--<br><button class="btn btn-info detaylar" type="button" tip="--><?php //echo $details->lojistik_muduru ?><!--" lojistik_id="--><?php //echo $details->id ?><!--">Detaylar</button></td>-->
                                                                    <!--                                    <td style="line-height: 30px;">--><?php //echo personel_details($details->proje_muduru); ?><!--<br>--><?php //echo 'Onaylanan Satınalma Tutarı: '.lojistik_sf_details($details->id,$details->proje_muduru)['total'] ?><!--<br><button class="btn btn-info detaylar" type="button" tip="--><?php //echo $details->proje_muduru ?><!--" lojistik_id="--><?php //echo $details->id ?><!--">Detaylar</button></td>-->
                                                                    <!--                                    <td style="line-height: 30px;">--><?php //echo personel_details($details->genel_mudur); ?><!--<br>--><?php //echo 'Onaylanan Satınalma Tutarı: '.lojistik_sf_details($details->id,$details->genel_mudur)['total'] ?><!--<br><button class="btn btn-info detaylar" type="button" tip="--><?php //echo $details->genel_mudur ?><!--" lojistik_id="--><?php //echo $details->id ?><!--">Detaylar</button></td>-->
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="gider_form" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <div class="card-body">
                                                        <button type="button" class="btn btn-success add_cost" lojistik_id="<?php echo $details->id ?>" ><i class="fa fa-plus"></i></button></br></br>
                                                        <table class="table datatable-show-all" id="gider_yonetimi" style="width: 100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Araç</th>
                                                                <th>Gider Kalemi</th>
                                                                <th>Miktar</th>
                                                                <th>Birim</th>
                                                                <th>Birim Fiyatı</th>
                                                                <th>Toplam Fiyat</th>
                                                                <th>Açıklama</th>
                                                                <th>Lokasyon</th>
                                                                <th style="width: 9% !important;">İşlem</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                                <div class="tab-pane fade" id="arac_form" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <div class="card-body">
                                                        <table class="table datatable-show-all" id="arac_yonetimi" style="width:100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Araç</th>
                                                                <th>Plaka</th>
                                                                <th>Şoför</th>
                                                                <th>Tel</th>
                                                                <th>Araç Hareketleri</th>
                                                                <th>İşlem</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <div class="card-body">
                                                        <button type="button" class="btn btn-success add_notes" lojistik_id="<?php echo $details->id ?>" ><i class="fa fa-plus"></i></button>
                                                        <div class="container clearfix">
                                                            <h3 style="text-align: center;">Bu Lojistik ile ilgili notlarınızı ekleyebilirsiniz.... </h3>


                                                            <div class="chat">
                                                                <div class="chat-history">
                                                                    <ul class="chat-ul">
                                                                        <?php if($item_notes)
                                                                        {
                                                                            foreach ($item_notes as $items){
                                                                                if($items->type==1){ // Lojistik Müdürü
                                                                                    ?>
                                                                                    <li class="clearfix">
                                                                                        <div class="message-data align-right">
                                                                                            <span class="message-data-name">Lojistik Müdürü (<?php echo personel_details($items->user_id) ?> - <?php echo $items->created_at ?>)</span><i class="fa fa-circle me"></i>
                                                                                        </div>
                                                                                        <div class="message me-message float-right">  <?php echo $items->notes ?> </div>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                                elseif($items->type==2){ // Proje Müdürü
                                                                                    ?>
                                                                                    <li>
                                                                                        <div class="message-data">
                                                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Proje Müdürü (<?php echo personel_details($items->user_id) ?> - <?php echo $items->created_at ?>)</span>
                                                                                        </div>
                                                                                        <div class="message you-message">
                                                                                            <?php echo $items->notes ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                                elseif($items->type==3){ // Genel Müdür
                                                                                    ?>
                                                                                    <li>
                                                                                        <div class="message-data">
                                                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Genel Müdür (<?php echo personel_details($items->user_id) ?> - <?php echo $items->created_at ?>)</span>
                                                                                        </div>
                                                                                        <div class="message you-message">
                                                                                            <?php echo $items->notes ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                                elseif($items->type==4){ // Sf Sorumlusu
                                                                                    ?>
                                                                                    <li>
                                                                                        <div class="message-data">
                                                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Satınalma Personeli (<?php echo personel_details($items->user_id) ?> - <?php echo $items->created_at ?>)</span>
                                                                                        </div>
                                                                                        <div class="message you-message">
                                                                                            <?php echo $items->notes ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                                elseif($items->type==5){ // Finans Sorumlusu
                                                                                    ?>
                                                                                    <li>
                                                                                        <div class="message-data">
                                                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Finans Müdürü (<?php echo personel_details($items->user_id) ?> - <?php echo $items->created_at ?>)</span>
                                                                                        </div>
                                                                                        <div class="message you-message">
                                                                                            <?php echo $items->notes ?>
                                                                                        </div>
                                                                                    </li>
                                                                                    <?php
                                                                                }

                                                                            }
                                                                        } ?>
                                                                    </ul>
                                                                </div> <!-- end chat-history -->
                                                            </div> <!-- end chat -->

                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="tab-pane fade" id="gun" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <div class="card-body">
                                                        <button  type="button" class="btn btn-success add_gun" lojistik_id="<?php echo $details->id ?>" ><i class="fa fa-plus"></i></button></br></br>
                                                        <table class="table datatable-show-all" id="gun_yonetimi" style="width: 100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Araç</th>
                                                                <th>Kaldığı Gün Sayısı</th>
                                                                <th>Birim Fiyatı</th>
                                                                <th>Toplam Tutar</th>
                                                                <th>İşlem</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>

                                                <div class="tab-pane fade" id="personelhareketleri" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <div class="card-body">
                                                        <table class="table datatable-show-all" id="personel_yonetimi" style="width: 100%;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Durum Bildiren Personel</th>
                                                                <th>Araç</th>
                                                                <th>Durum</th>
                                                                <th>İşlem Tarihi</th>
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
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).on('click','.detaylar', function () {
        let lojistik_id = $(this).attr('lojistik_id');
        let tip = $(this).attr('tip');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
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
                    '<div class="form-group table_rp">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    sf_id: lojistik_id,
                    user_id: tip,
                }

                let table_report='';
                $.post(baseurl + 'logistics/user_sf_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                        <tr>
                            <th>Lokasyon</th>
                            <th>Onaylanan Firma</th>
                            <th>Fiyat</th>
                            <th>Onay Açıklaması</th>
                            <th>Onay Tarihi</th>

                        </tr>
                        </thead><tbody>`;
                    responses.details.forEach((item,index) => {
                        table_report +=`<tr>
                                    <td>`+item.lokasyon+`</td>
                                    <td>`+item.company+`</td>
                                    <td>`+currencyFormat(parseFloat(item.price))+`</td>
                                    <td>`+item.desc+`</td>
                                    <td>`+item.created_at+`</td>
                                </tr>`;
                    })

                    table_report +=`</tbody></table>`;
                    $('.table_rp').empty().html(table_report);
                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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
    $(document).on('click', "#talep_iptal", function (e) {
        let talep_id = $(this).attr('talep_id');
        let status = 3;
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Açıklama Zorunludur',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }

                        let desc = $('#desc').val()
                        jQuery.ajax({
                            url: baseurl + 'logistics/sf_talep_iptal',
                            dataType: "json",
                            method: 'post',
                            data: 'desc=' + desc + '&status=' + status + '&talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content:data.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
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
                                        title: 'Dikkat',
                                        content:data.message,
                                        buttons: {
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
                                $('#loading-box').addClass('d-none');
                            },
                            error: function (data) {
                                $.alert(data.message);
                                $('#loading-box').addClass('d-none');
                            }
                        });


                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', "#talep_onay", function (e) {
        let talep_id = $(this).attr('talep_id');
        let status = 3;
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
                '<p>Talebi Onaylamak Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="İnceledim Onayladım" class="form-control name" />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        // let total =$('#total').val()
                        // if(value.length == 0){
                        //     desc = placeholder;
                        // }
                        //
                        // let item_array = [];
                        // $('.selected:checked').each((index,item) => {
                        //     item_array.push({
                        //         'item_id':$(item).attr('item_id'),
                        //         'talep_id':$(item).attr('lojistik_id')
                        //     });
                        // })


                        let data = {
                            // item_id:item_array,
                            desc:desc,
                            // total:total,
                            status:status,
                            talep_id:talep_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'logistics/talep_onay',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
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
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
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
                            $('#loading-box').addClass('d-none');
                        })



                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', "#onay_sistemi", function (e) {
        let talep_id = $(this).attr('talep_id');

        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi Onaya Sunmak Üzeresiniz? Emin Misiniz?<p/>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        jQuery.ajax({
                            url: baseurl + 'logistics/talep_onay_start',
                            dataType: "json",
                            method: 'post',
                            data: 'talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $('#loading-box').addClass('d-none');
                                    $.alert(data.message);
                                } else {
                                    $('#loading-box').addClass('d-none');
                                    $.alert(data.message);
                                }

                            },
                            error: function (data) {
                                $('#loading-box').addClass('d-none');
                                $.alert(data.message);

                            }
                        });


                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $('.selected').change(function(e) {


        let toplam = 0;
        let attr = $(this).attr('item_id');
        let price = $(this).attr('price');
        for (let i = 0; i < $('.selected').length; i++) {
            if ($('.selected').eq(i).attr('item_id') == attr) {
                $('.selected').eq(i).prop('checked', false);
            }
        }
        $(this).prop('checked', true);

        $('.selected:checked').each((index,item) => {
            toplam+= parseFloat($(item).attr('price'))*parseFloat($(item).attr('qty'));
        })
        $('#tutar').empty().text(currencyFormat(toplam));
        $('#total').val(toplam);

    })

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
    $(document).on('click','.razi_view',function (){
        let id = $(this).attr('data-object-id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'RAZILAŞTIRMA PROTOKOLÜ',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            columnClass: 'xlarge',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<label>Proje</label></br>' +
                    '<b><span id="proje_id"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Ödeme Tipi</label></br>' +
                    '<b><span id="odeme_tipi"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Ödeme Şekli</label></br>' +
                    '<b><span id="odeme_sekli"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Para Birimi</label></br>' +
                    '<b><span id="cur_id"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>KDV Durum</label></br>' +
                    '<b><span id="kdv_durum"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>KDV Oranı</label></br>' +
                    '<b><span id="kdv_oran"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Avans Oranı</label></br>' +
                    '<b><span id="oran"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Muqavele No</label></br>' +
                    '<b><span id="muqavele_no"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Geçerlilik Tarihi</label></br>' +
                    '<b><span id="date"></span></b>' +
                    '</div>' +
                    '<div class="col-md-12">' +
                    '<label>PDF</label></br>' +
                    '<b><span id="pdf"></span></b>' +
                    '</div>' +
                    '<div class="col-md-12 table_rp_view">'+
                    '</div>' +
                    '</div>' +
                    '</div>' +

                    '</form>';


                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }

                let table_report='';
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    $('#proje_id').empty().html(responses.details.proje_name)
                    $('#odeme_tipi').empty().html(responses.details.odeme_tipi_name)
                    $('#odeme_sekli').empty().html(responses.details.odeme_sekli_name)
                    $('#oran').empty().html(responses.details.oran)
                    $('#muqavele_no').empty().html(responses.details.muqavele_no)
                    $('#date').empty().html(responses.details.date)
                    $('#cur_id').empty().html(responses.cur_name)
                    $('#kdv_durum').empty().html(responses.tax_durum)
                    $('#kdv_oran').empty().html(responses.details.tax_oran)
                    $('#pdf').empty().html("<a href='/userfiles/product/"+responses.details.file+"' class='btn btn-info' target='_blank'>PDF GÖRÜNTÜLE</a>")

                    table_report =`
                        <table id="invoices_report"  class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Görülecek İş</th>
                                <th>Birim Fiyatı</th>
                                <th>Miktarı</th>
                                <th>Birim</th>
                            </tr>
                        </thead><tbody id="todo_tbody">`;

                    responses.item_details.forEach((item_,index) => {
                        table_report+=` <tr>
                                            <td>`+item_.name+`</td>
                                            <td>`+item_.price+`</td>
                                            <td>`+item_.qty+`</td>
                                            <td>`+item_.unit_name+`</td>
                                            </tr>`;
                    });


                    table_report+=`</tbody></table>`;
                    $('.table_rp_view').empty().html(table_report);


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


    $('#nav-arac_form').on('click', function () {
        $('#arac_yonetimi').DataTable().destroy();
        draw_data_arac();
        $('#gider_yonetimi').DataTable().destroy();
        draw_data_gider();

        $('#gun_yonetimi').DataTable().destroy();
        draw_data_gun();
    });

    $('#nav-gider_form').on('click', function () {
        $('#gider_yonetimi').DataTable().destroy();
        draw_data_gider();

        $('#gun_yonetimi').DataTable().destroy();
        draw_data_gun();
    });

    $('#nav-notes').on('click', function () {
        $('#gun_yonetimi').DataTable().destroy();
        draw_data_gun();
    });

    $('#nav-gun').on('click', function () {
        $('#gun_yonetimi').DataTable().destroy();
        draw_data_gun();
    });
    $('#nav-personel').on('click', function () {
        $('#personel_yonetimi').DataTable().destroy();
        draw_data_personel();
    });

    function draw_data_arac() {
        $('#arac_yonetimi').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('lojistikcar/ajax_list') ?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?=$details->id?>}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },

            ],
            dom: 'Blfrtip',
            buttons: [

            ]
        });
    }

    function draw_data_gider() {
        $('#gider_yonetimi').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('lojistikgider/ajax_list') ?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?=$details->id?>}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
            ]
        });
    }

    function draw_data_gun() {
        $('#gun_yonetimi').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('lojistikgun/ajax_list') ?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?=$details->id?>}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [

            ]
        });
    }

    function draw_data_personel() {
        $('#personel_yonetimi').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('lojistikgun/ajax_list_personel') ?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?=$details->id?>}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [

            ]
        });
    }


    $(document).on('click', ".arac_bilgileri", function (e) {
        let lojistik_id = $(this).attr('lojistik_id');
        let lojistik_car_id = $(this).attr('lojistik_car_id');
        let arac_id = $(this).attr('arac_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Araç Bilgileri',
            icon: 'fa fa-exclamation',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-6 col-md-offset-3',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">'+
                    '<div class="row">' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Plaka</label>' +
                    '<input type="text" class="form-control" id="plaka">' +
                    '</div>' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Şöför Adı Soyadı</label>' +
                    '<input type="text" class="form-control" id="sofor">' +
                    '</div>' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Şöför Tel</label>' +
                    '<input type="text" class="form-control" id="tel">' +
                    '<input type="hidden" class="form-control" value="0" id="lojistik_car_id">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    lojistik_car_id: lojistik_car_id,
                }
                $.post(baseurl + 'lojistikcar/cart_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.item){
                        $('#plaka').val(responses.item.plaka)
                        $('#sofor').val(responses.item.sofor)
                        $('#tel').val(responses.item.tel)
                        $('#lojistik_car_id').val(lojistik_car_id)
                    }
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Bilgileri Kaydet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var plaka = $('#plaka').val();
                        var sofor = $('#sofor').val();
                        var tel = $('#tel').val();
                        var lojistik_car_id = $('#lojistik_car_id').val();
                        if(!plaka){

                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Plaka Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        if(!sofor){

                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Şöför Bilgisi Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;

                        }
                        if(!tel){

                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Telefon Bilgisi Zorunludur',
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
                            lojistik_id:lojistik_id,
                            arac_id:arac_id,
                            plaka:plaka,
                            lojistik_car_id:lojistik_car_id,
                            sofor:sofor,
                            tel:tel,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikcar/create_car',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
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

                                                $('#arac_yonetimi').DataTable().destroy();
                                                draw_data_arac();

                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

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

    $(document).on('click', ".new_history", function (e) {
        let lojistik_car_id = $(this).attr('lojistik_car_id');
        let lojistik_id = $(this).attr('lojistik_id');
        let arac_id = $(this).attr('arac_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Araç Hareketi Oluştur',
            icon: 'fa fa-exclamation',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-6 col-md-offset-3',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">'+
                    '<div class="row">' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Lokasyon</label>' +
                    '<select class="form-control" id="sf_lokasyon_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Durum</label>' +
                    '<select class="form-control" id="status"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" class="form-control" id="desc">' +
                    '</div>' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Karşılama Personeline Bildir</label>' +
                    '<select class="form-control" id="sms_bildir"><option value="1">Bildirim Gönder</option><option value="0">Bildirim Gönderme</option></select>' +
                    '</div>' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Karşılama Personeli Seçiniz</label>' +
                    '<select class="form-control select-box" id="personel_id"><option value="0">Seçiniz</option></select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    lojistik_id: lojistik_id,
                }
                $.post(baseurl + 'lojistikcar/history_get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });


                    $('#personel_id').empty();
                    let newOptionpers = new Option('Seçiniz', 0, false, false);
                    $('#personel_id').append(newOptionpers);
                    responses.employe_list.forEach((item_,j) => {
                        let newOptionpers = new Option(item_.name, item_.id, false, false);
                        $('#personel_id').append(newOptionpers);
                    })


                    $('#sf_lokasyon_id').empty();
                    let newOption = new Option('Seçiniz', 0, false, false);
                    $('#sf_lokasyon_id').append(newOption);
                    responses.items.forEach((item_,j) => {
                        let newOption = new Option(item_.location, item_.id, false, false);
                        $('#sf_lokasyon_id').append(newOption);
                    })

                    $('#status').empty();
                    let newOptions = new Option('Seçiniz', 0, false, false);
                    $('#status').append(newOptions);
                    responses.history.forEach((item_,j) => {
                        let newOptions = new Option(item_.name, item_.id, false, false);
                        $('#status').append(newOptions);
                    })


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Kaydet',
                    btnClass: 'btn-blue',
                    action: function () {

                        var status = $('#status').val();
                        var sf_lokasyon_id = $('#sf_lokasyon_id').val();
                        var desc = $('#desc').val();
                        var personel_id = $('#personel_id').val();
                        if(!desc){
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
                        if(!sf_lokasyon_id){

                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Lokasyon Bilgisi Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;

                        }
                        if(!status){

                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Durum Bilgisi Zorunludur',
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
                            lojistik_id:lojistik_id,
                            sms_bildir:$('#sms_bildir').val(),
                            arac_id:arac_id,
                            lojistik_car_id:lojistik_car_id,
                            status:status,
                            sf_lokasyon_id:sf_lokasyon_id,
                            desc:desc,
                            crsf_token: crsf_hash,
                            personel_id: personel_id,
                        }

                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'lojistikcar/create_history',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
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
                                                $('#loading-box').addClass('d-none');
                                                $('#arac_yonetimi').DataTable().destroy();
                                                draw_data_arac();

                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){
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

    $(document).on('click','.arac_hareketleri',function (e){

        let lojistik_car_id = $(this).attr('lojistik_car_id');
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Araç Hareketleri',
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
                    table_report =`<div style="padding-bottom: 10px;"><button class="btn btn-danger all_delete"  lojistik_car_id='`+lojistik_car_id+`' type="button">Seçili Olanları İptal Et</button></div>
                        <table id="invoices_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                            <th>İşlem Tarihi</th>
                            <th>Açıklama</th>
                            <th>Lokasyon</th>
                            <th>İşlem Yapan Personel</th>
                            <th>Durum</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_report(lojistik_car_id);
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

    function draw_data_report(lojistik_car_id=0) {
        $('#invoices_report').DataTable({
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
                'url': "<?php echo site_url('lojistikcar/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    lojistik_car_id: lojistik_car_id,
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
                    extend: 'excelHtml5',
                    footer: true,

                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });
    };

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })

    $(document).on('click','.all_delete',function (){
        let lojistik_car_id = $(this).attr('lojistik_car_id');
        let checked_count = $('.one_select:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir History Seçilmemiş!',
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
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>İptal Etmek Üzeresiniz Emin Misiniz?<p/>'+
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Eminim',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let job_id = [];
                            $('.one_select:checked').each((index,item) => {
                                job_id.push($(item).attr('id'));
                            });
                            let data = {
                                id_array:job_id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'lojistikcar/all_delete_hisyory',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'grey',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: 'Başarılı Bir Şekilde İptal Edildi!',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#invoices_report').DataTable().destroy();
                                    draw_data_report(lojistik_car_id)
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
        }
    })

    $(document).on('click', ".add_notes", function (e) {
        let lojistik_id = $(this).attr('lojistik_id');
        let lojistik_to_car_id = $(this).attr('lojistik_to_car_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Not</label>' +
                '<input type="text" name="desc" id="desc" class="form-control name" />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {

                        let desc = $('#desc').val()

                        if(!desc){

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
                            desc:desc,
                            lojistik_id:lojistik_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikcar/create_note',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {

                                                let name ='';

                                                    if(responses.type==1){
                                                        data=`<li class="clearfix">
                                                        <div class="message-data align-right">
                                                            <span class="message-data-name">Lojistik Müdürü (`+responses.user_name+'-'+responses.date+`)</span><i class="fa fa-circle me"></i>
                                                        </div>
                                                        <div class="message me-message float-right">  `+responses.desc+` </div>
                                                    </li>`
                                                        $('.chat-ul').after().append(data)
                                                    }
                                                    else if(responses.type==2) {
                                                        data=`<li>
                                                        <div class="message-data">
                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Proje Müdürü (`+responses.user_name+'-'+responses.date+`)</span>
                                                        </div>
                                                        <div class="message you-message">
                                                          `+responses.desc+`
                                                        </div>
                                                    </li>`
                                                        $('.chat-ul').after().append(data)
                                                    }
                                                    else if(responses.type==3) {
                                                        data=`<li>
                                                        <div class="message-data">
                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Genel Müdür (`+responses.user_name+'-'+responses.date+`)</span>
                                                        </div>
                                                        <div class="message you-message">
                                                          `+responses.desc+`
                                                        </div>
                                                    </li>`
                                                        $('.chat-ul').after().append(data)
                                                    }
                                                    else if(responses.type == 4){
                                                        data=`<li>
                                                        <div class="message-data">
                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Satınalma Sorumlusu (`+responses.user_name+'-'+responses.date+`)</span>
                                                        </div>
                                                        <div class="message you-message">
                                                          `+responses.desc+`
                                                        </div>
                                                    </li>`
                                                        $('.chat-ul').after().append(data)
                                                    }
                                                    else if(responses.type == 5){
                                                        data=`<li>
                                                        <div class="message-data">
                                                            <span class="message-data-name"><i class="fa fa-circle you"></i> Finans Müdürü (`+responses.user_name+'-'+responses.date+`)</span>
                                                        </div>
                                                        <div class="message you-message">
                                                          `+responses.desc+`
                                                        </div>
                                                    </li>`
                                                        $('.chat-ul').after().append(data)
                                                    }




                                            }
                                        }
                                    }
                                });

                                $('#loading-box').addClass('d-none');

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                            }

                        })



                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', ".add_cost", function (e) {
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Gider Ekleme',
            icon: 'fa fa-plus',
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
                    '<div class="form-group">'+
                    '<div class="row">' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Araç</label>' +
                    '<select class="form-control name" id="arac_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Lokasyon</label>' +
                    '<select class="form-control name" id="sf_lokasyon_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Gider Kalemi</label>' +
                    '<select class="form-control select-box name" id="cost_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" class="form-control name" id="desc">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Birim</label>' +
                    '<select class="form-control select-box name" id="unit_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Miktar</label>' +
                    '<input type="number" class="form-control name" id="qty">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Birim Fiyatı</label>' +
                    '<input type="text" class="form-control name" id="price">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    lojistik_id: lojistik_id,
                }
                $.post(baseurl + 'lojistikgider/cost_get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let responses = jQuery.parseJSON(response);
                    $('#sf_lokasyon_id').empty();
                    let newOption = new Option('Seçiniz', 0, false, false);
                    $('#sf_lokasyon_id').append(newOption);
                    responses.items.forEach((item_,j) => {
                        let newOption = new Option(item_.location, item_.id, false, false);
                        $('#sf_lokasyon_id').append(newOption);
                    })

                    $('#cost_id').empty();
                    $('#cost_id').append(new Option('Seçiniz', 0, false, false)).trigger('change');
                    responses.cost.forEach((item_,index) => {
                        $('#cost_id').append(new Option(item_.name, item_.id, false, false));
                    })

                    $('#unit_id').empty();
                    $('#unit_id').append(new Option('Seçiniz', 0, false, false)).trigger('change');
                    responses.unit.forEach((item_,index) => {
                        $('#unit_id').append(new Option(item_.name, item_.id, false, false));
                    })


                    $('#arac_id').empty();
                    let newOptions_arac = new Option('Seçiniz', 0, false, false);
                    $('#arac_id').append(newOptions_arac);
                    responses.araclar.forEach((item_,j) => {
                        let newOptions_arac = new Option(item_.name, item_.id, false, false);
                        $('#arac_id').append(newOptions_arac);
                    })


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Gider Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
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
                                content: 'Tüm Aanlar Zorunludur',
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
                            desc:desc,
                            lojistik_id:lojistik_id,
                            arac_id:$('#arac_id').val(),
                            sf_lokasyon_id:$('#sf_lokasyon_id').val(),
                            cost_id:$('#cost_id').val(),
                            desc:$('#desc').val(),
                            unit_id:$('#unit_id').val(),
                            qty:$('#qty').val(),
                            price:$('#price').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/create_cost',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gider_yonetimi').DataTable().destroy();
                                                draw_data_gider();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })



                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', ".gider_duzenle", function (e) {
        let gider_id = $(this).attr('gider_id');
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Gider Düzenle',
            icon: 'fa fa-pencil',
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
                    '<div class="form-group">'+
                    '<div class="row">' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Araç</label>' +
                    '<select class="form-control name" id="arac_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Lokasyon</label>' +
                    '<select class="form-control name" id="sf_lokasyon_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Gider Kalemi</label>' +
                    '<select class="form-control select-box name" id="cost_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" class="form-control name" id="desc">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Birim</label>' +
                    '<select class="form-control select-box name" id="unit_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Miktar</label>' +
                    '<input type="number" class="form-control name" id="qty">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Birim Fiyatı</label>' +
                    '<input type="text" class="form-control name" id="price">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    lojistik_id: lojistik_id,
                    gider_id: gider_id,
                }
                $.post(baseurl + 'lojistikgider/cost_get_info_edit',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let responses = jQuery.parseJSON(response);
                    $('#sf_lokasyon_id').empty();
                    let newOption = new Option('Seçiniz', 0, false, false);
                    $('#sf_lokasyon_id').append(newOption);
                    responses.items.forEach((item_,j) => {
                        let newOption = new Option(item_.location, item_.id, false, false);
                        $('#sf_lokasyon_id').append(newOption);
                    })

                    $('#cost_id').empty();
                    $('#cost_id').append(new Option('Seçiniz', 0, false, false)).trigger('change');
                    responses.cost.forEach((item_,index) => {
                        $('#cost_id').append(new Option(item_.name, item_.id, false, false));
                    })

                    $('#unit_id').empty();
                    $('#unit_id').append(new Option('Seçiniz', 0, false, false)).trigger('change');
                    responses.unit.forEach((item_,index) => {
                        $('#unit_id').append(new Option(item_.name, item_.id, false, false));
                    })


                    $('#arac_id').empty();
                    let newOptions_arac = new Option('Seçiniz', 0, false, false);
                    $('#arac_id').append(newOptions_arac);
                    responses.araclar.forEach((item_,j) => {
                        let newOptions_arac = new Option(item_.name, item_.id, false, false);
                        $('#arac_id').append(newOptions_arac);
                    })

                    $("#arac_id").val(responses.cost_details.arac_id).trigger("change");
                    $("#unit_id").val(responses.cost_details.unit_id).trigger("change");
                    $("#cost_id").val(responses.cost_details.gider_id).trigger("change");
                    $("#sf_lokasyon_id").val(responses.cost_details.satinalma_location_id).trigger("change");
                    $("#desc").val(responses.cost_details.desc);
                    $("#qty").val(responses.cost_details.qty);
                    $("#price").val(responses.cost_details.price);


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Gider Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
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
                                content: 'Tüm Aanlar Zorunludur',
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
                            desc:desc,
                            gider_id:gider_id,
                            lojistik_id:lojistik_id,
                            arac_id:$('#arac_id').val(),
                            sf_lokasyon_id:$('#sf_lokasyon_id').val(),
                            cost_id:$('#cost_id').val(),
                            desc:$('#desc').val(),
                            unit_id:$('#unit_id').val(),
                            qty:$('#qty').val(),
                            price:$('#price').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/update_cost',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gider_yonetimi').DataTable().destroy();
                                                draw_data_gider();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })



                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', ".gider_iptal", function (e) {
        let onay_id = $(this).attr('onay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Gideri İptal Etmek İçin Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim İptal Ediyorum" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Gideri İptal Et',
                    btnClass: 'btn-red',
                    action: function () {
                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc:desc,
                            onay_id:onay_id,
                            status:2,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/gider_onay_iptal',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gider_yonetimi').DataTable().destroy();
                                                draw_data_gider();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
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


    $(document).on('click', ".gider_onay", function (e) {
        let onay_id = $(this).attr('onay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Onay',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Gideri Onaylamak İçin Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim Onayladım" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-success',
                    action: function () {

                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc:desc,
                            onay_id:onay_id,
                            status:1,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/gider_onay_iptal',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gider_yonetimi').DataTable().destroy();
                                                draw_data_gider();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
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

    $(document).on('click', ".rey_details", function (e) {
        let onay_id = $(this).attr('onay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgi',
            icon: 'fa fa-question',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<p id="genel_mudur"></p>';
                html+='<p id="date"></p>';
                html+='<p id="text"></p>';

                let data = {
                    crsf_token: crsf_hash,
                    onay_id: onay_id,
                }
                $.post(baseurl + 'lojistikgider/rey_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        $('#text').empty().html(responses.details.desc);
                        $('#genel_mudur').empty().html(responses.details.pers_name);
                        $('#date').empty().html(responses.details.created_at);
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel: {
                    text: 'Kapat',
                    btnClass: 'btn-success',
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


    $(document).on('click', ".islem_bitir", function (e) {
        let lojistik_id = $(this).attr('lojistik_id');
        let sf_item_id = $(this).attr('id');
        let index_eq = $(this).attr('eq');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Hizmet Tamamlama',
            icon: 'fa fa-check',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'Hizmet Tamamlandığını Bildirmek Üzeresiniz! Emin misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-success',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            sf_item_id:sf_item_id,
                            lojistik_id:lojistik_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'logistics/islem_bitir',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        cancel: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                $('.hizmet_tamamla_btn').eq(index_eq).empty().text('Genel Müdür İncelemedesinde')
                                            }
                                        },
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        cancel: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        },
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })



                    }
                },
                cancel: {
                    text: 'Hayır',
                    btnClass: 'btn-red',
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


    $(document).on('click', ".gider_sil", function (e) {
        let gider_id = $(this).attr('gider_id');
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Gideri Silmek İçin Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim Siliyorum" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Gideri Sil',
                    btnClass: 'btn-red',
                    action: function () {
                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc:desc,
                            gider_id:gider_id,
                            lojistik_id:lojistik_id,
                            status:2,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/gider_sil',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gider_yonetimi').DataTable().destroy();
                                                draw_data_gider();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
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

    $(document).on('click', ".add_gun", function (e) {
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Əlavə Gün Ekleme',
            icon: 'fa fa-plus',
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
                    '<div class="form-group">'+
                    '<div class="row">' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Araç</label>' +
                    '<select class="form-control name" id="arac_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Lokasyon</label>' +
                    '<select class="form-control name" id="lsf_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" class="form-control name" id="desc">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Gün Sayısı</label>' +
                    '<input type="text" class="form-control name" id="gun_sayisi">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Günlük Fiyatı</label>' +
                    '<input type="text" class="form-control name" id="price">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    lojistik_id: lojistik_id,
                }
                $.post(baseurl + 'lojistikgun/gun_get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let responses = jQuery.parseJSON(response);
                    $('#lsf_id').empty();
                    let newOption = new Option('Seçiniz', 0, false, false);
                    $('#lsf_id').append(newOption);
                    responses.items.forEach((item_,j) => {
                        let newOption = new Option(item_.location, item_.id, false, false);
                        $('#lsf_id').append(newOption);
                    })



                    $('#arac_id').empty();
                    let newOptions_arac = new Option('Seçiniz', 0, false, false);
                    $('#arac_id').append(newOptions_arac);
                    responses.araclar.forEach((item_,j) => {
                        let newOptions_arac = new Option(item_.name, item_.id, false, false);
                        $('#arac_id').append(newOptions_arac);
                    })


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Gün Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
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
                                content: 'Tüm Aanlar Zorunludur',
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
                            desc:desc,
                            lojistik_id:lojistik_id,
                            arac_id:$('#arac_id').val(),
                            sf_lokasyon_id:$('#lsf_id').val(),
                            desc:$('#desc').val(),
                            gun_sayisi:$('#gun_sayisi').val(),
                            price:$('#price').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgun/create_gun',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gun_yonetimi').DataTable().destroy();
                                                draw_data_gun();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })



                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', ".update_gun", function (e) {
        let gun_id = $(this).attr('gun_id');
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Gider Düzenle',
            icon: 'fa fa-pencil',
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
                    '<div class="form-group">'+
                    '<div class="row">' +
                    '<div class="col-md-12" style="padding: 13px;">' +
                    '<label>Araç</label>' +
                    '<select class="form-control name" id="arac_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Lokasyon</label>' +
                    '<select class="form-control name" id="sf_lokasyon_id"><option value="">Seçiniz</option></select>' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" class="form-control name" id="desc">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Gün Sayısı</label>' +
                    '<input type="text" class="form-control name" id="gun_sayisi">' +
                    '</div>' +
                    '<div class="col-md-6" style="padding: 13px;">' +
                    '<label>Günlük Fiyatı</label>' +
                    '<input type="text" class="form-control name" id="price">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    lojistik_id: lojistik_id,
                    gun_id: gun_id,
                }
                $.post(baseurl + 'lojistikgun/gun_get_info_edit',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let responses = jQuery.parseJSON(response);
                    $('#sf_lokasyon_id').empty();
                    let newOption = new Option('Seçiniz', 0, false, false);
                    $('#sf_lokasyon_id').append(newOption);
                    responses.items.forEach((item_,j) => {
                        let newOption = new Option(item_.location, item_.id, false, false);
                        $('#sf_lokasyon_id').append(newOption);
                    })



                    $('#arac_id').empty();
                    let newOptions_arac = new Option('Seçiniz', 0, false, false);
                    $('#arac_id').append(newOptions_arac);
                    responses.araclar.forEach((item_,j) => {
                        let newOptions_arac = new Option(item_.name, item_.id, false, false);
                        $('#arac_id').append(newOptions_arac);
                    })

                    $("#arac_id").val(responses.gun_details.arac_id).trigger("change");
                    $("#sf_lokasyon_id").val(responses.gun_details.lsf_id).trigger("change");
                    $("#desc").val(responses.gun_details.desc);
                    $("#price").val(responses.gun_details.unit_price);
                    $("#gun_sayisi").val(responses.gun_details.gun_sayisi);


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Gün Bilgileri Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
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
                                content: 'Tüm Aanlar Zorunludur',
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
                            gun_id:gun_id,
                            desc:desc,
                            lojistik_id:lojistik_id,
                            arac_id:$('#arac_id').val(),
                            sf_lokasyon_id:$('#sf_lokasyon_id').val(),
                            desc:$('#desc').val(),
                            gun_sayisi:$('#gun_sayisi').val(),
                            price:$('#price').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgun/update_gun',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gun_yonetimi').DataTable().destroy();
                                                draw_data_gun();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })



                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
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

    $(document).on('click', ".delete_gun", function (e) {
        let gun_id = $(this).attr('gun_id');
        let lojistik_id = $(this).attr('lojistik_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Girilen Gün Bilgisini Silmek İçin Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim Siliyorum" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Gün Bilgisini Sil',
                    btnClass: 'btn-red',
                    action: function () {
                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc:desc,
                            gun_id:gun_id,
                            lojistik_id:lojistik_id,
                            status:2,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgun/gun_sil',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#gun_yonetimi').DataTable().destroy();
                                                draw_data_gun();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
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



</script>

<style>
    table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting{
        padding-right: 80px !important;
        width: 199px !important;
    }
    .table th, .table td{
        border-top: none!important;
    }
    .badge-warning{
        margin-bottom: 3px;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
        color: #ffffff;
        background-color: #3b475e;
        border-color: #F5F7FA #F5F7FA #F5F7FA;
        height: 64px;
        font-size: 20px;
        margin: auto;
        text-align: center;
        padding: 15px;
        border-radius: 0px;
    }
    .nav-tabs .nav-link{
        height: 64px;
        font-size: 20px;
        margin: auto;
        text-align: center;
        padding: 15px;
        background: #617497;
        color: white;
        border-color: #F5F7FA #F5F7FA #F5F7FA;
        border-radius: 0px;
    }
    .nav.nav-tabs .nav-item:hover{
        color: #fff;
        font-weight: 700;
        background: #7a92bf;
    }
    .jconfirm .jconfirm-box div.jconfirm-content-pane .jconfirm-content {
        overflow: hidden;
    }
    .chat .chat-history {
        padding: 30px 30px 20px;
        border-bottom: 2px solid white;
    }
    .chat .chat-history .message-data {
        margin-bottom: 15px;
    }
    .chat .chat-history .message-data-time {
        color: #a8aab1;
        padding-left: 6px;
    }
    .chat .chat-history .message {
        color: white;
        padding: 18px 20px;
        line-height: 26px;
        font-size: 16px;
        border-radius: 5px;
        margin-bottom: 30px;
        width: 90%;
        position: relative;
    }
    .chat .chat-history .message:after {
        content: "";
        position: absolute;
        top: -15px;
        left: 20px;
        border-width: 0 15px 15px;
        border-style: solid;
        border-color: #CCDBDC transparent;
        display: block;
        width: 0;
    }
    .chat .chat-history .you-message {
        background: #CCDBDC;
        color:#003366;
    }
    .chat .chat-history .me-message {
        background: #E9724C;
    }
    .chat .chat-history .me-message:after {
        border-color: #E9724C transparent;
        right: 20px;
        top: -15px;
        left: auto;
        bottom:auto;
    }
    .chat .chat-message {
        padding: 30px;
    }
    .chat .chat-message .fa-file-o, .chat .chat-message .fa-file-image-o {
        font-size: 16px;
        color: gray;
        cursor: pointer;
    }

    .chat-ul li{
        list-style-type: none;
    }


    .you {
        color: #CCDBDC;
    }

    .me {
        color: #E9724C;
    }


</style>
