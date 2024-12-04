<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="thermal_a" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="content-body" style="padding-bottom: 10px;">
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                            <p>Malzeme Talep Bilgileri</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                            <p>İhale Bilgileri</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                            <p>Satınalma Bilgileri</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                            <p>Tehvil Bilgileri</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                            <p>Fatura Bilgileri</p>
                        </div>
                    </div>
                </div>

                <div class="row setup-content" id="step-1">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table">
                                    <tr>
                                        <th>Malzeme Talep No</th>
                                        <th><?php echo $malzeme_talep_bilgileri['talep_no'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Proje Adı</th>
                                        <th><?php echo $malzeme_talep_bilgileri['proje_name'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Form Oluşturan Personel</th>
                                        <th><?php echo personel_details($malzeme_talep_bilgileri['kullanici_id']) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Talep Eden Personel</th>
                                        <th><?php echo personel_details($malzeme_talep_bilgileri['talep_eden_pers_id']) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Oluşturma Tarihi</th>
                                        <th><?php echo dateformat($malzeme_talep_bilgileri['olusturma_tarihi']); ?></th>
                                    </tr>

                                    <tr>
                                        <th>Durum</th>
                                        <th><?php echo purchase_status($malzeme_talep_bilgileri['status']); ?></th>
                                    </tr>

                                </table>
                            </div>

                            <div class="form-group">
                                <table id="invoices_malzeme_talep" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Resim</th>
                                        <th><?php echo $this->lang->line('Item Name') ?></th>
                                        <th><?php echo $this->lang->line('product detail') ?></th>
                                        <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                        <th>Proje Sorumlusu</br><?php echo ' ('.personel_details($malzeme_talep_bilgileri['proje_sorumlusu_id']).')'?></th>
                                        <th>Proje Müdürü </br><?php echo ' ('.personel_details($malzeme_talep_bilgileri['proje_muduru_id']).')'?></th>
                                        <th>Depo Müdürü Durumu</br><?php echo ' ('.personel_details($malzeme_talep_bilgileri['bolum_mudur_id']).')'?></th>
                                        <th>Genel Müdürü Durumu</br><?php echo ' ('.personel_details($malzeme_talep_bilgileri['genel_mudur_id']).')'?></th>



                                    </tr>
                                    </thead>


                                </table>
                            </div>


                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >İleri</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-2">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <?php if($ihale) {
                                ?>

                                <table class="table">
                                    <tr>
                                        <th>İhale No</th>
                                        <th><?php echo $ihale->dosya_no ?></th>
                                    </tr>
                                    <tr>
                                        <th>Proje Adı</th>
                                        <th><?php echo proje_name($ihale->proje_id) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Form Oluşturan Personel</th>
                                        <th><?php echo personel_details($ihale->emp_id) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Oluşturma Tarihi</th>
                                        <th><?php echo dateformat($ihale->baslangic_tarihi); ?></th>
                                    </tr>

                                    <tr>
                                        <th>Durum</th>
                                        <th><?php
                                            $status_string='Kapalı';
                                            if($ihale->status==1)
                                            {
                                                $status_string='Açık';
                                            }
                                            echo $status_string; ?></th>
                                    </tr>

                                </table>

                                <table class="table">
                                    <tr>
                                        <th>Resim</th>
                                        <th>Ürün</th>
                                        <th>Detay</th>
                                        <th>Firma</th>
                                        <th>Marka</th>
                                        <th>İstehsalçı Ülke</th>
                                        <th>Miktar</th>
                                        <th>Birim</th>
                                        <th>Firmanın Fiyatı</th>
                                        <th>EDV Durumu</th>
                                        <th>EDV'siz Fiyat </th>
                                        <th>EDV'li Fiyat </th>
                                        <th>EDV'siz Toplam Fiyat</th>
                                        <th>EDV'li Toplam Fiyat</th>
                                    </tr>
                                    <?php $i=0; foreach ($urunler as $datas) {
                                        $p=$datas['product_name'];

                                        $product=str_replace("'","\'",$p);

                                        $onay_durum=onay_durumlari_ogren_product_user(2,$satin_alma_id,$string,$product,$datas['id']);

                                        $product_id=$datas['product_id'];


                                        $images='';
                                        $prd=$this->db->query("SELECT * FROM geopos_products WHERE pid=$product_id");
                                        if($prd->num_rows()>0)
                                        {
                                            $images= $prd->row()->image;
                                        }

                                        $image='<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $images . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $images . '" ></span> &nbsp;';

                                        if($datas['ref_urun']==0)
                                        {


                                            ?>

                                            <tbody>
                                            <tr class="rowid">

                                                <?php $teklifler = satinalma_urun_to_firma($satin_alma_id,$product) ?>
                                                <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><?php echo $image?></td>
                                                <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><b><?php echo $datas['product_name']?></b></br><?php echo product_detail($datas['product_id'])['cat_name'] ?></td>
                                                <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><b>  <?php echo $datas['product_detail']?></td>

                                                <?php foreach (satinalma_urun_to_firma($satin_alma_id,$product) as $datass) {

                                                $kdv_durumu='EDV Hariç';

                                                $edv_tutari=(round($datass['price']*0.18,2));
                                                $toplam_edv_tutari=round($datass['subtotal']*0.18,2);


                                                $edvsiz_fiyat=0;
                                                $edvli_fiyat=0;
                                                $edvli_toplam_fiyat=0;
                                                $edvsiz_toplam_fiyat=0;
                                                if($datass['kdv_dahil_haric']==1)
                                                {

                                                    $kdv_durumu='EDV Dahil';
                                                    $edvsiz_fiyat=$datass['price']/1.18;
                                                    $edvli_fiyat=$datass['price'];
                                                    $edvsiz_toplam_fiyat=$datass['subtotal']/1.18;
                                                    $edvli_toplam_fiyat=$datass['subtotal'];

                                                }
                                                else
                                                {
                                                    $kdv_durumu='EDV Hariç';
                                                    $edvsiz_fiyat=(round($datass['price'],2));
                                                    $edvsiz_toplam_fiyat=$datass['subtotal'];
                                                    $edvli_fiyat=$datass['price']*1.18;
                                                    $edvli_toplam_fiyat=$datass['subtotal']*1.18;



                                                }


                                                $onay_durum=onay_durumlari_ogren_product_user_firma(2,$satin_alma_id,$string,$product,$datas['id'],$datass['id']);


                                                if($onay_durum==3)
                                                {
                                                    //echo "<tr style='background-color: gray;color: white'>";
                                                    echo "<tr>";
                                                }
                                                else
                                                {
                                                    echo "<tr>";
                                                }


                                                ?>


                                                <td><?php echo $datass['firma']?></td>
                                                <td><?php echo $datass['marka']?></td>
                                                <td><?php echo $datass['ulke']?></td>
                                                <td><?php echo $datass['qty']?></td>
                                                <td><?php echo $datass['unit']?></td>
                                                <td><?php echo amountFormat($datass['price'])?></td>
                                                <td><?php echo $kdv_durumu?></td>
                                                <td><?php echo amountFormat($edvsiz_fiyat)?></td>
                                                <td><?php echo amountFormat($edvli_fiyat)?></td>
                                                <td><?php echo amountFormat($edvsiz_toplam_fiyat)?></td>
                                                <td><?php echo amountFormat($edvli_toplam_fiyat)?></td>

                                            </tr>

                                            <?php } ?>
                                            </tr>
                                            </tbody>
                                            <?php

                                        }
                                        ?>


                                    <?php } ?>
                                </table>


                                </table>
                                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >İleri</button>
                            <?php } else {
                                echo "<p>İHALE OLUŞTURULMAMIŞ!";
                            } ?>

                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-3">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <?php if($satin_alma_id!=0) {
                                ?>

                                <table class="table">
                                    <tr>
                                        <th>Satınalma Talep No</th>
                                        <th><?php echo $satinalma['talep_no'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Proje Adı</th>
                                        <th><?php echo $satinalma['proje_name'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Form Oluşturan Personel</th>
                                        <th><?php echo personel_details($satinalma['kullanici_id']) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Talep Eden Personel</th>
                                        <th><?php echo personel_details($satinalma['talep_eden_pers_id']) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Oluşturma Tarihi</th>
                                        <th><?php echo dateformat($satinalma['olusturma_tarihi']); ?></th>
                                    </tr>

                                    <tr>
                                        <th>Durum</th>
                                        <th><?php echo purchase_status($satinalma['status']); ?></th>
                                    </tr>

                                </table>

                                <table class="table">
                                    <tr>
                                        <th>Resim</th>
                                        <th>Ürün</th>
                                        <th>Detay</th>
                                        <th>Firma</th>
                                        <th>Marka</th>
                                        <th>İstehsalçı Ülke</th>
                                        <th>Miktar</th>
                                        <th>Birim</th>
                                        <th>Firmanın Fiyatı</th>
                                        <th>EDV Durumu</th>
                                        <th>EDV'siz Fiyat </th>
                                        <th>EDV'li Fiyat </th>
                                        <th>EDV'siz Toplam Fiyat</th>
                                        <th>EDV'li Toplam Fiyat</th>
                                    </tr>
                                    <?php $i=0; foreach ($urunler as $datas) {
                                        $p=$datas['product_name'];

                                        $product=str_replace("'","\'",$p);

                                        $onay_durum=onay_durumlari_ogren_product_user(2,$satin_alma_id,$string,$product,$datas['id']);


                                        $product_id=$datas['product_id'];


                                        $prd=$this->db->query("SELECT * FROM geopos_products WHERE pid=$product_id");
                                        if($prd->num_rows()>0)
                                        {
                                            $images= $prd->row()->image;
                                        }

                                        $image='<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $images . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $images. '" ></span> &nbsp;';


                                        if($datas['ref_urun']==0)
                                        {


                                            ?>

                                            <tbody>
                                            <tr class="rowid">
                                                <?php $teklifler = satinalma_urun_to_firma($satin_alma_id,$product) ?>
                                                <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><b><?php echo $image ?></b></td>
                                                <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><b><?php echo $datas['product_name']?></b></br><?php echo product_detail($datas['product_id'])['cat_name'] ?></td>
                                                <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><b>  <?php echo $datas['product_detail']?></td>

                                                <?php foreach (satinalma_urun_to_firma($satin_alma_id,$product) as $datass) {

                                                $kdv_durumu='EDV Hariç';

                                                $edv_tutari=(round($datass['price']*0.18,2));
                                                $toplam_edv_tutari=round($datass['subtotal']*0.18,2);


                                                $edvsiz_fiyat=0;
                                                $edvli_fiyat=0;
                                                $edvli_toplam_fiyat=0;
                                                $edvsiz_toplam_fiyat=0;
                                                if($datass['kdv_dahil_haric']==1)
                                                {

                                                    $kdv_durumu='EDV Dahil';
                                                    $edvsiz_fiyat=$datass['price']-$edv_tutari;
                                                    $edvli_fiyat=$datass['price'];
                                                    $edvsiz_toplam_fiyat=$datass['subtotal']/1.18;
                                                    $edvli_toplam_fiyat=$datass['subtotal'];

                                                }
                                                else
                                                {
                                                    $kdv_durumu='EDV Hariç';
                                                    $edvsiz_fiyat=(round($datass['price'],2));
                                                    $edvsiz_toplam_fiyat=$datass['subtotal'];
                                                    $edvli_fiyat=$datass['price']*1.18;
                                                    $edvli_toplam_fiyat=$datass['subtotal']*1.18;



                                                }


                                                $onay_durum=onay_durumlari_ogren_product_user_firma(2,$satin_alma_id,$string,$product,$datas['id'],$datass['id']);


                                                if($onay_durum==3)
                                                {
                                                    echo "<tr style='background-color: gray;color: white'>";

                                                }
                                                else
                                                {
                                                    echo "<tr>";
                                                }

                                                ?>

                                                <td><?php echo $datass['firma']?></td>
                                                <td><?php echo $datass['marka']?></td>
                                                <td><?php echo $datass['ulke']?></td>
                                                <td><?php echo $datass['qty']?></td>
                                                <td><?php echo $datass['unit']?></td>
                                                <td><?php echo amountFormat($datass['price'])?></td>
                                                <td><?php echo $kdv_durumu?></td>
                                                <td><?php echo amountFormat($edvsiz_fiyat)?></td>
                                                <td><?php echo amountFormat($edvli_fiyat)?></td>
                                                <td><?php echo amountFormat($edvsiz_toplam_fiyat)?></td>
                                                <td><?php echo amountFormat($edvli_toplam_fiyat)?></td>

                                            </tr>

                                            <?php } ?>
                                            </tr>
                                            </tbody>
                                            <?php

                                        }
                                        ?>


                                    <?php } ?>
                                </table>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 text-xs-center text-md-left">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th>Proje Müdürü</br><?php echo ' ('.personel_details($satinalma['proje_muduru_id']).')'?></th>
                                                    <th>Genel Müdürü</br><?php echo ' ('.personel_details($satinalma['genel_mudur_id']).')'?></th>
                                                </tr>
                                                <td><?php echo onay_durumlari_ogren_satin_alma(2,$satin_alma_id,'proje_muduru_status') ?></td>
                                                <td><?php echo onay_durumlari_ogren_satin_alma(2,$satin_alma_id,'genel_mudur_status') ?></td>
                                            </table>
                                        </div>
                                    </div>

                                </div>




                            <?php } else {
                                echo "<p>SATINALMA OLUŞTURULMAMIŞ!";
                            } ?>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >İleri</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-4">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <table id="invoice_urunler" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                                <thead>
                                <tr>

                                    <th>No</th>
                                    <th><?php echo $this->lang->line('talep no') ?></th>
                                    <th><?php echo $this->lang->line('Project Title') ?></th>
                                    <th><?php echo $this->lang->line('Company') ?></th>
                                    <th>Resim</th>
                                    <th><?php echo $this->lang->line('Product Name') ?></th>
                                    <th><?php echo $this->lang->line('Sip_Qty') ?></th>
                                    <th><?php echo $this->lang->line('teslim_alinan_miktar') ?></th>
                                    <th><?php echo $this->lang->line('kalan_miktar') ?></th>
                                    <th><?php echo $this->lang->line('Note') ?></th>
                                    <th><?php echo $this->lang->line('Status') ?></th>
                                    <th>Sorumlu Personel</th>
                                    <th>Teslim Tarihi</th>
                                    <th><?php echo $this->lang->line('tehvil_no') ?></th>

                                </tr>
                                </thead>

                            </table>
                            <div id="pop_model_depo_bilgi" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title"><?php echo $this->lang->line('urun_tehvil_bilgileri'); ?></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <form id="form_model_urun" method="post">
                                                <div class="modal-body" id="view_object_depo_bilgi">
                                                    <p></p>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >İleri</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-5">
                    <div class="col-md-12">
                        <div class="col-md-12">


                            <?php if(isset($fatura)) { ?>
                                <table class="table">

                                    <tr>
                                        <th>Cari Bilgileri </th>
                                        <th>
                                            <?php echo "<a href='".base_url('customers/view?id=' . $fatura->csd)."'>".customer_details($fatura->csd)['company'].'</a>' ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Fatura No </th>
                                        <th><?php echo $fatura->invoice_no ?></th>
                                    </tr>

                                    <tr>
                                        <th>Fatura Tarihi</th>
                                        <th><?php echo dateformat($fatura->invoicedate); ?></th>
                                    </tr>
                                    <tr>
                                        <th>Proje Adı</th>
                                        <th><?php echo $fatura->proje_id ?></th>
                                    </tr>
                                    <tr>
                                        <th>Fatura Oluşturan Personel</th>
                                        <th><?php echo personel_details($fatura->eid) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Durum</th>
                                        <th><?php echo invoice_status($fatura->status); ?></th>
                                    </tr>
                                    <tr>
                                        <th>Toplam</th>
                                        <th><?php echo  amountFormat($fatura->total,$fatura->para_birimi)  ?></th>
                                    </tr>
                                    <tr>
                                        <th>Açıklama </th>
                                        <th><?php echo $fatura->notes ?></th>
                                    </tr>

                                </table>
                                <table class="table table-striped">
                                    <thead>


                                    <tr>
                                        <th>#</th>
                                        <th>Resim</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>

                                        <?php if($rulo_miktari==1)
                                        {
                                            ?>
                                            <th class="text-xs-left"><?php echo $this->lang->line('paket_miktari') ?></th>
                                            <?php
                                        } ?>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Tax') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;

                                    foreach ($products as $row) {

                                        $product_id=$row['pid'];
                                        $prd=$this->db->query("SELECT * FROM geopos_products WHERE pid=$product_id")->row();
                                        $image='<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $prd->image . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span> &nbsp;';

                                        $sub_t += $row['price'] * $row['qty'];
                                        echo '<tr>
    <th scope="row">' . $c . '</th>
    <td>'.$image.'</td>
                                <td>' . $row['product'] . '</td>                           
                                   <td>' . +$row['qty'].' '.units_($row['unit'])['name'] . '</td>
                                <td>' . amountFormat($row['price'],$fatura->para_birimi) . '</td>
                               
                                ';

                                        if($rulo_miktari==1)
                                        {
                                            $rulos=rulo_hesapla($row['pid'],$row['qty']);
                                            echo '<td>' . +$rulos . ' '.paketleme_tipi($row['pid']).' </td>';
                                        }



                                        echo '
                               
                                <td>' .$row['tax'].'</td>
                               <td>' . amountFormat($row['subtotal'],$fatura->para_birimi) . '</td>
                           
                            </tr>';


                                        $c++;
                                    } ?>

                                    </tbody>

                                </table>

                                <div class="col-md-5 col-sm-12" style="float: right;">
                                    <p class="lead"><?php echo $this->lang->line('Summary') ?></p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td><?php echo $this->lang->line('Sub Total') ?></td>

                                                <td class="text-xs-right"> <?php echo amountFormat($sub_t,$fatura->para_birimi) ?></td>
                                            </tr>

                                            <tr>
                                                <td><?php echo $this->lang->line('Discount') ?></td>
                                                <td class="text-xs-right"><?php echo amountFormat($fatura->discount,$fatura->para_birimi) ?></td>
                                            </tr>


                                            <tr>
                                                <td><?php echo $this->lang->line('Net Total') ?></td>
                                                <td class="text-xs-right"><?php echo amountFormat($sub_t-$fatura->discount,$fatura->para_birimi) ?></td>
                                            </tr>

                                            <tr>
                                                <td><?php echo $this->lang->line('Total Tax') ?></td>
                                                <td class="text-xs-right"><?php echo amountFormat($fatura->tax,$fatura->para_birimi) ?></td>
                                            </tr>

                                            <tr>
                                                <td class="text-bold-800"><?php echo $this->lang->line('Grand Total') ?></td>
                                                <td class="text-bold-800 text-xs-right"> <?php echo amountFormat($fatura->total,$fatura->para_birimi) ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $this->lang->line('Payment Made') ?></td>
                                                <td class="pink text-xs-right">
                                                    (-) <?php echo ' <span id="paymade">' . amountFormat($fatura->pamnt,$fatura->para_birimi) ?></span></td>
                                            </tr>
                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800"><?php echo $this->lang->line('Balance Due') ?></td>
                                                <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                                    $rming = $fatura->total - $fatura->pamnt;
                                                    if ($rming < 0) {
                                                        $rming = 0;

                                                    }
                                                    echo ' <span id="paydue">' . amountFormat($rming,$fatura->para_birimi) . '</span></strong>'; ?></td>
                                            </tr>

                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800"><?php echo $this->lang->line('azn_total') ?></td>
                                                <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                                    $rming = $fatura->total*$fatura->kur_degeri;

                                                    echo ' <span >' . amountFormat($rming,1) . '</span></strong>'; ?></td>

                                            </tr>
                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800"><?php echo $this->lang->line('kur_degeri') ?></td>
                                                <td class="text-bold-800 text-xs-right"> <?php
                                                    $kur_degeri = $fatura->kur_degeri;

                                                    echo ' <span >' . amountFormat($kur_degeri,1) . '</span></strong>'; ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            <?php } else {
                                echo "FATURA OLUŞTURULMAMIŞ";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

<style>
    #invoices_malzeme_talep_filter, #invoices_malzeme_talep_paginate, #invoice_urunler_paginate, #invoice_urunler_filter
    {
        display: none;
    }
    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
        margin-top: 10px;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        z-order: 0;

    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        background: #41e6e8;
        color: white;
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>


<script>
    $(document).ready(function () {

        window.setTimeout(function () {
            $('.select-box').select2();
        }, 2000);


        draw_data();
        draw_data5(<?php echo $satin_alma_id?>);

        function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
            $('#invoices_malzeme_talep').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('form/ajax_list_talep_view')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        alt_firma:alt_firma,
                        status:status,
                        proje_id:proje_id,
                        tip:<?php echo $_GET['id'] ?>
                    }
                },
                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ],
            });



        };

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var alt_firma = $('#alt_firma').val();
            var status = $('#status').val();
            var proje_id = $('#proje_id').val();
            var invoice_type_id = $('#invoice_type_id').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,alt_firma,status,proje_id,invoice_type_id);

        });

        function draw_data5(talep_no = '', proje_id = '',firma_id='',pers_id='',status_id='',start_date='',end_date='') {
            $('#invoice_urunler').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('form/invoice_depo_urunler_view')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        talep_no: talep_no,
                        proje_id: proje_id,
                        firma_id:firma_id,
                        pers_id:pers_id,
                        status_id:status_id,
                        start_date:start_date,
                        end_date:end_date,
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0,5,6,7,8],
                        'orderable': false,
                    },
                ]

            });
        };
    });

    $(document).on('click', ".pop_model_depo_bilgi", function (e) {
        e.preventDefault();
        var talep_item_id=$(this).attr('malzeme_talep_id')

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'form/depo_onay_bilgileri';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+talep_item_id+'&'+crsf_token+'='+crsf_hash,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#view_object_depo_bilgi').html(data);

            }

        });

    });
</script>

<script>
    $(document).on('click', ".pop_model_depo_bilgi", function (e) {
        e.preventDefault();
        var talep_item_id=$(this).attr('malzeme_talep_id')

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'form/depo_onay_bilgileri';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+talep_item_id+'&'+crsf_token+'='+crsf_hash,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#view_object_depo_bilgi').html(data);

            }

        });

    });
    $(document).ready(function () {

        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;



            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-primary').trigger('click');
    });
</script>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
