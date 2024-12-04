<link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
<style>
    .notestbody {
        display: block;
        height: 150px;
        overflow: auto;
    }
    .notesthead, .notestbody .notestr {
        display: table;
        width: 100%;
        table-layout: fixed;/* even columns width , fix width of table too*/
    }
    .notesthead {
        width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
    }
    .notestable {
        width: 100%;
    }
    body {
        color: #2B2000;
        font-family: 'Helvetica';
    }
    .invoice-box {
        width: 210mm;
        height: 297mm;
        margin: auto;
        padding: 4mm;
        border: 0;

        color: #000;
    }

    table {
        width: 100%;
        text-align: left;
        border-collapse: collaps
    }

    .plist tr td {
    }

    .subtotal tr td {
        padding: 6pt;
    }

    .subtotal tr td {
        border: 1px solid #ddd;
    }

    .sign {
        text-align: right;
        margin-right: 110pt;
    }

    .sign1 {
        text-align: right;
        margin-right: 90pt;
    }

    .sign2 {
        text-align: right;
        margin-right: 115pt;
    }

    .sign3 {
        text-align: right;
        margin-right: 115pt;
    }

    .terms {
        margin-right:20pt;
    }

    .invoice-box table td {
        padding: 6pt 4pt 2pt 4pt;
        vertical-align: top;

    }

    .invoice-box table.top_sum td {
        padding-bottom: 3px;
    }

    .party tr td:nth-child(3) {
        text-align: end;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20pt;

    }

    table tr.top table td.title {
        color: #555;
    }

    table tr.information table td {
        padding-bottom: 20pt;
    }

    table tr.heading td {
        background: #515151;
        color: #FFF;
        padding: 6pt;

    }

    table tr.details td {
        padding-bottom: 20pt;
    }

    .invoice-box table tr.item td{
        border: 1px solid #ddd;
    }

    table tr.b_class td{
        border-bottom: 1px solid #ddd;
    }

    table tr.b_class.last td{
        border-bottom: none;
    }

    table tr.total td:nth-child(4) {
        border-top: 2px solid #fff;
        font-weight: bold;
    }

    .myco {
        width: 400pt;
    }

    .myco2 {
        width: 300pt;
    }

    .myw {
        width: 240pt;

    }

    .mfill {
        background-color: #eee;
    }

    .descr {
        color: #515151;
    }

    .tax {

        color: #515151;
    }

    .t_center {
        text-align: right;

    }

    .form2{
        border: 1px solid black;
        padding: 10px;
    }


</style>
<?php

$kur_degeri=para_birimi_id($invoice['para_birimi'])['rate'];
$carpim=$kur_degeri;
?>

<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Forma 2 Görüntüle</span></h4>
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
                                            <div class="col-md-12">
                                                <br>
                                                <a target="_blank" href="/demirbas/forma2create/<?php echo $_GET['id'] ?>" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Gidere İşle"><i class="fa fa-pencil-ruler"></i></a>&nbsp;
                                                <?php

                                                $disabled='';
                                                if($invoice['status']!=3)
                                                {
                                                    if($invoice['bildirim_durumu']==1)
                                                    {
                                                        ?>
                                                        <button disabled id="onay_iste" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onay Sistemine Sunulmuştur"><i class="fa fa-info"></i></button>&nbsp;

                                                        <?php
                                                    }
                                                    else {?>
                                                        <button  id="onay_iste" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onay Sistemini Başlat"><i class="fa fa-bell"></i></button>
                                                        <button type="button" forma_2_id="<?php echo $_GET['id'] ?>" class="btn btn-secondary mb-1 edit_forma_2" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Düzenle"><i class="fa fa-pen"></i></button>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($invoice['status']==3){
                                                    $disabled ='disabled';
                                                }else {
                                                    if($this->aauth->get_user()->id == 61 || $this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 174) {
                                                        ?>
                                                        <button id="status_change" old_status="<?php echo $invoice['status']; ?>" data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Durum Güncelle"><i class="fa fa-check"></i></button>&nbsp;
                                                        <?php
                                                    }
                                                } ?>
                                                <button <?php echo $disabled ?> id="talep_iptal" data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-danger mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal Talebi Oluştur"><i class="fa fa-question-circle"></i></button>&nbsp;
                                                <?php  if($this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 ) { ?>
                                                <button <?php echo $disabled ?> id="talep_iptal_muhasebe" data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-danger mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talebi İptal Et"><i class="fa fa-ban"></i></button>&nbsp;
                                                <button <?php echo $disabled ?> id="iptal_return" data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal Talebini Yanıtla"><i class="fa fa-reply-all"></i></button>&nbsp;
                                                    <?php
                                                } ?>
                                                <?php if($this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==39) {
                                                    ?>

                                                    <button id="price_update_forma2" forma2_id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Fiyat Güncelle"><i class="fa fa-check-circle"></i></button>&nbsp;

                                                    <?php
                                                } ?>

                                                <button id="file_upload" forma_id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-secondary mb-1" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Dosya Yükle"><i class="fa fa-file-import"></i></button>&nbsp;
                                                <button  islem_tipi="1" islem_id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-secondary mb-1 add_not_new" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Not Ekle"><i class="fa fa-notes-medical"></i></button>
                                                <button  onclick="details_notes()" type="button" class="btn btn-secondary mb-1 button_view_notes" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Notları Görüntüle"><i class="fa fa-list-alt"></i></button>

                                                <button  type="button" class="btn btn-secondary button_podradci_borclandirma mb-1" islem_id="<?php echo $_GET['id'] ?>" islem_tipi="4" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
                                                <button  type="button" class="btn btn-secondary button_podradci_borclandirma mb-1" islem_id="<?php echo $_GET['id'] ?>" islem_tipi="4" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>



                                                <?php $odemeler  = protok_forma2_avans_kontrol($_GET['id']);
                                                if($odemeler['status']){
                                                    ?>

                                                <div class="btn-group">

                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Projeye Bağlı Avans Ödemeleri
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <?php
                                                            $key = 1;
                                                            foreach ($odemeler['items'] as $itmes){ ?>
                                                                <button trans_id="<?php echo $itmes->id?>" class="dropdown-item transaction_pay" type="button"><?php echo $key.' - '.$itmes->invoice_type_desc.' | '.amountFormat($itmes->total)?></button>
                                                                <?php $key++;
                                                            }?>

                                                        </div>
                                                </div>


                                                    <?php
                                                }
                                                ?>

                                                <?php $avanslar  = protok_forma2_avans_kontrol_($_GET['id']);
                                                if($avanslar['status']){
                                                    ?>
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonnew" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Projeye Bağlı Tüm Avanslar
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonnew">
                                                        <?php
                                                        $key = 1;
                                                        foreach ($avanslar['items'] as $items){ ?>
                                                            <a target="_blank" href="/customeravanstalep/view/<?php echo $items->id?>" class="dropdown-item" ><?php echo $key.' - '.$items->code.' | '.talep_form_status_details($items->status)->name?></a>
                                                            <?php $key++;
                                                        }?>

                                                    </div>
                                                </div>

                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <div class="col-md-12">


                                                <br>
                                                <div class="row">
                                                <div class="col-md-6">
                                                    <table  style="" class="party">
                                                        <thead>
                                                        <tr>
                                                            <td>Sifarişçi: </td>
                                                            <td><strong>
                                                                    <?php if($invoice['invoice_type_id']==29){ ?>
                                                                    <?php $loc=location($this->aauth->get_user()->loc);  echo $loc['cname']; ?></strong>
                                                                <br>
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                    if($invoice['csd']!=0)
                                                                    {
                                                                        echo customer_details($invoice['csd'])['company'];
                                                                    }
                                                                }
                                                                ?>

                                                            </td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <tr>
                                                            <td>Podratçı : </td>
                                                            <td>
                                                                <strong>
                                                                    <?php if($invoice['invoice_type_id']==30)
                                                                    { ?>
                                                                    <?php $loc=location($this->aauth->get_user()->loc);  echo $loc['cname']; ?></strong>
                                                                </br>
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                    if($invoice['csd']!=0)
                                                                    {
                                                                        $csd = $invoice['csd'];
                                                                        echo '<a target="_blank" href="/customers/view?id='.$csd.'">Fiziki Şexs'.' '.customer_details($invoice['csd'])['company'].customer_details($invoice['csd'])['taxid'].'</a>';
                                                                    }
                                                                }
                                                                ?>

                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td>Forma2 No:</td>
                                                            <td><?php echo $invoice['invoice_no'];?></td>

                                                        </tr>

                                                        <tr>
                                                            <td>Muqavele No:</td>
                                                            <td><?php echo $invoice['muqavele_no'];?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Proje Adı:</td>
                                                            <td><?php echo proje_name($invoice['proje_id']);?></td>

                                                        </tr>
                                                        <tr>
                                                            <td>Tarih:</td>
                                                            <td><?php echo  dateformat($invoice['invoicedate'])?></td>

                                                        </tr>
                                                        <tr>
                                                            <td>Durum:</td>
                                                            <?php
                                                            $pers_name='';
                                                            if($invoice['updated_user_id']) {
                                                                $pers_name = personel_details($invoice['updated_user_id']);
                                                            } ?>
                                                            <td><?php echo invoice_status($invoice['status']).'  '.$invoice['pers_notes'].' '.$pers_name;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Forma2 Notu:</td>
                                                            <td><?php echo $invoice['notes']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Modül</td>
                                                            <td>
                                                                <?php if($fehle_status){
                                                                    echo '<span style="color: red">Fehle Modülünden Gelmiştir</span>';
                                                                }
                                                                else {

                                                                    echo 'Forma2 Modülünden Gelmiştir.';
                                                                }?>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                </div>

                                                </br>


                                                <table  style="" class="plist form2" cellpadding="0" cellspacing="0">



                                                    <?php $c = 1;
                                                    $sub_t = 0;
                                                    $f_totals=0;

                                                    $line="<tr class='form2'>
                                <td rowspan='2' class='form2' style='text-align: center;'>
                                   No
                                </td>

                                <td rowspan='2' class='form2' style='text-align: center;'>
                                   Görülmüş İşler
                                </td>
                                   <td rowspan='2' class='form2' style='text-align: center;'>
                                  Aşama
                                </td>

                                <td rowspan='2' class='form2' style='text-align: center;'>
                                  Ölçü Vehidi
                                </td>
                                    <td class='form2' rowspan='1' colspan='3' style='text-align: center;'>
                                    Yerine Getirilmiş İşler</td>
                                </tr>


                                <tr>

                                <td class='form2' style='text-align: center;'>
                                  Miqdari
                                </td>
                                <td class='form2' style='text-align: center;'>
                                    Qiymeti
                                </td>
                                <td class='form2' style='text-align: center;'>
                                    Cemi


                            </tr>";


                                                    foreach ($bolumler as $blm)
                                                    {

                                                        $totals=0;

                                                        echo "<tr><td colspan='6' style='text-align: center;' class='form2'><b>$blm->name</b></td></tr>";

                                                        echo $line;

                                                        foreach ($products as $row) {


                                                            $desc = '';
                                                            if($row['item_desc']!='undefined'){
                                                                $desc = '<span style="font-size: 9px">('.$row['item_desc'].')</span>';
                                                            }

                                                            //Burası kapatıldı sonradan açılacak bölüm uyuşmadığı için ürünler gözükmüyor

                                                            if($blm->id==$row['id'])
                                                            {
                                                                $totals=$totals+$row['subtotal'];

                                                                $sub_t += $row['price'] * $row['qty'];

                                                                echo '<tr>
                            <td class="form2" style="text-align: center">' . $c . '</td>
                            <td class="form2">' . $row['product'].' '.$desc.'</td>
                               <td class="form2">' . $row['asama_name'].'</td>
                              <td class="form2">'.units_($row['unit'])['name'] . '</td>
                                <td class="form2">' . +$row['qty']. '</td>
                             <td class="form2" style="text-align: right;">' . amountFormat($row['price']*$carpim) . '</td>


                             <td class="form2"  style="text-align: right;">' . amountFormat($row['subtotal']*$carpim) . '</td>
                        </tr>';


                                                                $c++;

                                                            }

                                                        }

                                                        echo '<tr>
                <td colspan="2" class="form2" style="text-align: right;">Cemi</td>
                <td colspan="4" class="form2" style="text-align: right;">'.amountFormat($totals).'</td>
                </tr>';

                                                        $f_totals+=$totals;
                                                    }

                                                    ?>


                                                </table>
                                                <br>
                                                <div style="margin-left: 60%">
                                                    <?php
                                                    $tax_status='';
                                                    if($invoice['taxstatus']=='yes'){
                                                        $tax_status = 'Fiyatlar ƏDV Dahildir.';
                                                    }
                                                    elseif($invoice['taxstatus']=='no') {
                                                        $tax_status = 'Fiyatlar ƏDV Hariçtir.';
                                                    }
                                                    ?>
                                                    <table class="subtotal"  style="">


                                                        <tr>


                                                            <td>Yekun Cemi</td>

                                                            <td><strong><?php
                                                                    echo amountFormat($f_totals*$carpim );
                                                                    echo '</strong></td>
        </tr>
        <tr>
            <td>ƏDV </td><td>'.$tax_status.'</td>
</tr>
        '?>

                                                                    <?php echo '
        </table>';
                                                                    ?>
                                                </div>

                                                <br>
                                                <h3 style="text-align: center">İşlem Geçmişi</h3>
                                                <table class="table subtotal">
                                                    <tr>
                                                        <td>Ödeme Tarihi</td>
                                                        <td>Not</td>
                                                        <td>Personel</td>
                                                        <td>Ödeme Tipi</td>
                                                        <td>İşlem Tipi</td>
                                                        <td>Ödeme Tutarı</td>
                                                    </tr>
                                                    <?php
                                                    $odeme_total = 0;
                                                    $teminat = 0;
                                                    $ceza_total = 0;
                                                    $prim = 0;
                                                    $temiat_odeme = 0;

                                                    foreach (forma_2_pay_history($_GET['id']) as  $value){

                                                        $total_trans = isset($value->total_transaction)?amountFormat($value->total_transaction):'';
                                                        $desc = isset($value->invoice_type_desc)?$value->invoice_type_desc:'';
                                                        $odeme_metodu = isset($value->method)?account_type_sorgu($value->method):'';
                                                        $personel = isset($value->eid)?personel_details($value->eid):'';
                                                        $notes = isset($value->notes)?$value->notes:'';
                                                        $date = isset($value->invoicedate)?$value->invoicedate:'';
                                                        if($value->invoice_type_id == 55) // Teminat
                                                        {
                                                            $teminat+=$value->total_transaction;
                                                        }
                                                        else if($value->invoice_type_id == 54 || $value->invoice_type_id == 65) // Ceza
                                                        {
                                                            $ceza_total+=$value->total_transaction;
                                                        }
                                                        else if($value->invoice_type_id == 57) // Prim
                                                        {
                                                            $prim+=$value->total_transaction;
                                                        }
                                                        else if($value->invoice_type_id == 61) // Teminat Ödemesi
                                                        {
                                                            $temiat_odeme+=$value->total_transaction;
                                                        }
                                                        else if($value->invoice_type_id == -1) // Avans parça ödemesi
                                                        {
                                                            $odeme_total+=$value->amount;
                                                            $total_trans=amountFormat($value->amount);
                                                            $desc=$value->desc.' <a target="_blank" href="/transactions/view?id='.$value->invoice_transaction_id.'" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Ödeniş Tapşırığı</a>';
                                                            $odeme_metodu=account_type_sorgu($value->method);
                                                            $personel=personel_details($value->aauth_id);
                                                            $notes='';
                                                            $date=$value->created_at;
                                                        }
                                                        else{ // Ödeme
                                                            $odeme_total+=$value->total_transaction;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $date ?></td>
                                                            <td><?php echo $notes ?></td>
                                                            <td><?php echo $personel; ?></td>
                                                            <td><?php echo $odeme_metodu ?></td>
                                                            <td><?php echo $desc;?></td>
                                                            <td><?php echo $total_trans; ?></td>
                                                        </tr>
                                                        <?php

                                                    } ?>
                                                    <?php
                                                    $net_total=$f_totals;
                                                    $kdv_new_totoal=$invoice['tax'];
                                                    if($invoice['taxstatus']=='yes'){
                                                        $net_total=(($f_totals)/(1+($invoice['tax_oran']/100)));
                                                        $kdv_new_totoal=$f_totals-$net_total;
                                                        $f_totals=$net_total;
                                                    }


                                                    $total_cikan = $odeme_total  + $teminat + $ceza_total;
//                                                    $kalan = (($f_totals*$carpim)+$kdv_new_totoal)-($total_cikan);
                                                    $toplam_hakedis = ($f_totals*$carpim) +($prim*$carpim) +  $kdv_new_totoal;
                                                    $teminat=$teminat-$temiat_odeme;

                                                    $forma2_new_toplam = $net_total-$ceza_total;

                                                    $new_tax_tutar=$forma2_new_toplam*($invoice['tax_oran']/100);
                                                    $kalan = (($forma2_new_toplam)+$prim)-($odeme_total)-$teminat;

                                                    ?>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right">Forma2  Toplamı</td>
                                                        <td><b><?php echo amountFormat($net_total*$carpim )?></b></td>

                                                    </tr>
                                                    <tr>

                                                        <td colspan="5" style="text-align: right">Kesinti Toplamı</td>
                                                        <td><b><?php echo amountFormat($ceza_total )?></b></td>
                                                    </tr>
                                                    <tr>

                                                        <td colspan="5" style="text-align: right">Forma2 Net Toplamı</td>
                                                        <td><b><?php echo amountFormat($forma2_new_toplam )?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right"> KDV Toplamı (<?php echo round($invoice['tax_oran'],2).' %';?> )</td>
<!--                                                        <td><b>--><?php //echo amountFormat($kdv_new_totoal )?><!--</b></td>-->
                                                        <td><b><?php echo amountFormat($new_tax_tutar )?></b></td>

                                                        <input type="hidden" value="<?php echo $net_total ?>" id="forma2_net_toplam_hiddden">
                                                        <input type="hidden" value="<?php echo $new_tax_tutar ?>" id="forma2_kdv_toplam_hidden">
                                                        <input type="hidden" value="<?php echo $toplam_hakedis ?>" id="forma2_toplam_hidden">
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right">Toplam Hakediş</td>
                                                        <td><b><?php echo amountFormat($forma2_new_toplam+$new_tax_tutar )?></b></td>
<!--                                                        <td><b>--><?php //echo amountFormat($toplam_hakedis )?><!--</b></td>-->
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right">Prim Toplamı</td>
                                                        <td><b><?php echo amountFormat($prim*$carpim )?></b></td>
                                                    </tr>

                                                    <tr>

                                                        <td colspan="5" style="text-align: right">Ödeme Toplamı</td>
                                                        <td><b><?php echo amountFormat($odeme_total )?></b></td>
                                                    </tr>



                                                    <tr>

                                                        <td colspan="5" style="text-align: right">Teminat Toplamı</td>
                                                        <td><b><?php echo amountFormat($teminat )?></b></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="5" style="text-align: right">Kalan (KDV HARİÇ)</td>
                                                        <td><b><?php echo amountFormat($kalan); ?></b></td>
                                                    </tr>

                                                </table>

                                                <table  style="" class="party">
                                                    <thead>
                                                    <tr>
                                                        <td>Sifarişçi :<br><strong>
                                                                <?php if($invoice['invoice_type_id']==29){ ?>
                                                                <?php $loc=location($this->aauth->get_user()->loc);  echo $loc['cname']; ?></strong><br>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                                if($invoice['csd']!=0)
                                                                {
                                                                    echo customer_details($invoice['csd'])['company'].customer_details($invoice['csd'])['taxid'];
                                                                }
                                                            }
                                                            ?>

                                                            <b>SORUMLU PERSONEL</b> <br>
                                                            <!--                                --><?php //echo personel_details($invoice['payer'])?>
                                                            MILAD KADKHODAEI

                                                        </td>
                                                        <td style="text-align: right;">Podratçı :<br>
                                                            <strong>
                                                                <?php if($invoice['invoice_type_id']==30){ ?>
                                                                <?php $loc=location($this->aauth->get_user()->loc);  echo $loc['cname']; ?></strong><br>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                                $v = (customer_details($invoice['csd'])['taxid'])?customer_details($invoice['csd'])['taxid']:'';
                                                                if($invoice['csd']!=0)
                                                                {

                                                                    echo customer_details($invoice['csd'])['company'].$v;
                                                                }
                                                                else {
                                                                    echo customer_details($invoice['csd'])['company'].$v;
                                                                }
                                                            }


                                                            ?>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>



                                                </table>
                                                <br>
                                                <br>
                                                <br>
                                                <br>


                                            </div>
                                            <div class="row mt-3">
                                                <div class="col col-md-6 col-xs-6">
                                                    <div class="jarviswidget">
                                                        <header> <h4>Sorğu ilə Əlaqəli Fayllar</h4></header>
                                                        <div class="borderedccc no-padding">
                                                            <?php if($file_details){
                                                                foreach ($file_details as $file_items){
                                                                    ?>
                                                                    <ul class="list-inline">
                                                                        <li id="systemfile_2" class="col-sm-12 margin-bottom-5">
                                                                            <div class="well welldocument">
                                                                                <label><b><?php echo $file_items->file_name?></b></label>
                                                                                <div class="">
                                                                                    <div class="font-xs">Yüklenme Tarihi: <?php echo dateformat_new($file_items->created_at)?></div>
                                                                                    <div class="font-xs">Yükleyen: <?php echo personel_details($file_items->user_id)?></div>
                                                                                </div>
                                                                                <div class="text-center">
                                                                                    <div class="btn-group">
                                                                                        <a class="btn btn-success" download href="<?php echo base_url() . 'userfiles/formainvoices/'.$file_items->file_name ?>"  >
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
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col col-md-6 col-xs-6">
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
                                                            <?php if(talep_borclandirma($_GET['id'],4)){
                                                                foreach (talep_borclandirma($_GET['id'],4) as $b_items){
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
<!--                                        <div class="content-body">-->
<!--                                            <table class="table">-->
<!--                                                <tr>-->
<!--                                                    <td><button id="tumunu_onayla"  type="button"  class="btn btn-success">Formu Onayla</button>-->
<!--                                                        <button id="tumunu_iptal_et" type="button"  class="btn btn-danger">Formu İptal Et</button>-->
<!--                                                    </td>-->
<!---->
<!--                                                </tr>-->
<!---->
<!--                                            </table>-->
<!---->
<!--                                        </div>-->
<!--                                        <div class="content-body">-->
<!--                                            <table class="table">-->
<!--                                                <tr>-->
<!--                                                    <th>Proje Sorumlusu <br>(--><?php //echo personel_details($invoice['proje_sorumlu_id'])?><!--)</th>-->
<!--                                                    <th>Proje Müdürü <br>(--><?php //echo personel_details($invoice['proje_muduru_id'])?><!--)</th>-->
<!--                                                    <th>Genel Müdür <br>(--><?php //echo personel_details($invoice['genel_mudur_id'])?><!--)</th>-->
<!--                                                </tr>-->
<!--                                                <tr>-->
<!---->
<!--                                                    <td>--><?php //echo purchase_status(onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_sorumlusu_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(10,$_GET['id'],0,"proje_sorumlusu_onay_saati")['onay_saati']).'<br>'.onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_sorumlusu_status")['note'];?><!--</td>-->
<!--                                                    <td>--><?php //echo purchase_status(onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_muduru_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(10,$_GET['id'],0,"proje_muduru_onay_saati")['onay_saati']).'<br>'.onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_muduru_status")['note'];?><!--</td>-->
<!--                                                    <td>--><?php //echo purchase_status(onay_durumlari_ogren_product_str(10,$_GET['id'],0,"genel_mudur_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(10,$_GET['id'],0,"genel_mudur_onay_saati")['onay_saati']).'<br>'.onay_durumlari_ogren_product_str(10,$_GET['id'],0,"genel_mudur_status")['note'];?><!--</td>-->
<!---->
<!--                                                </tr>-->
<!---->
<!--                                            </table>-->
<!---->
<!--                                        </div>-->
                                    </div>
                                    <div class="col-md-12">
                                        <h3 style="text-align: center">TƏSDIQLƏMƏ SIRASI</h3>
                                        <table class="table">

                                            <?php
                                            if(talep_onay_new_invoices(2,$_GET['id'])){
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
                                                foreach (talep_onay_new_invoices(2,$_GET['id']) as $items) {
                                                    $durum='-';
                                                    $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                                    if($items->status==1){
                                                        $durum='Onaylandı';
                                                        $button='<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                                    }
                                                    if($items->staff==1 && $items->status==0){
                                                        $durum='Gözləmedə';
                                                        $button='<button class="btn btn-info onayla" aauth_id="'.$this->aauth->get_user()->id.'" sort="'.$items->sort.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <!--?php echo roles(role_id($items->user_id))?-->
                                                        <th>(Forma 2 Onayı)</th>
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
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>

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

    $(document).on('change','#status',function (){
        let status_id = $(this).val();
        if(status_id==-1){
            let data = {
                talep_id:<?php echo  $_GET['id']; ?>,
            }
            $.post(baseurl + 'formainvoices/check_pers_all',data,(response)=>{
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
                                type: 2,
                            }
                            $.post(baseurl + 'formainvoices/onay_olustur',data,(response)=>{
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
                            type:2
                        }
                        $.post(baseurl + 'formainvoices/onay_baslat',data,(response)=>{
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



    $(document).on('click',"#tumunu_onayla",function(e) {
        let id = <?php echo $_GET['id'] ?>;
        let onay_tipi  = 0;
        let status = '';
        let d_none = '';


        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Forma 2  Onaylama',
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
                    '<div class="form-group genel_mudur_onayi">' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    invoice_id: id,
                }

                $.post(baseurl + 'formainvoices/forma2_user_kontrol',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let text='';
                    let responses = jQuery.parseJSON(response);
                    if(responses.status=='Success'){
                        if(responses.genel_mudur){
                            text ='<label>Onay Tipi</label>' +
                                '<select id="onay_tipi" class="form-control name"><option value="1">Cariye İşle</option></select>';

                        }
                        else {
                            text = '<p>Onay vermek üzeresiniz. Emin misiniz?</p>';
                        }


                    }
                    else {
                        text='<p>Onay Vermek İçin Yetkiniz Yoktur</p>'
                        $('.yetki').addClass('d-none')
                    }



                    $('.genel_mudur_onayi').empty().html(text);

                });

                return $('#person-container').html();
            },
            onContentReady:function (){

            },
            buttons: {
                formSubmit: {
                    text: 'Forma Onay Ver',
                    btnClass: 'btn btn-blue yetki',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        if($('#onay_tipi').val()!=undefined){
                            onay_tipi = $('#onay_tipi').val();
                        }
                        let data = {
                            invoice_id:id,
                            crsf_token: crsf_hash,
                            onay_tipi: onay_tipi,
                        }

                        $.post(baseurl + 'formainvoices/forma2_onay',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Onay Verildi.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
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
        //     url: baseurl + 'formainvoices/forma2_onay',
        //     dataType: "json",
        //     method: 'post',
        //     data: 'invoice_id='+id+'&'+crsf_token+'='+crsf_hash,
        //     beforeSend: function(){
        //         $(this).html('Bekleyiniz');
        //         $(this).prop('disabled', true); // disable button
        //
        //     },
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //             $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
        //             $("html, body").scrollTop($("body").offset().top);
        //             $('#pstatus').html(data.pstatus);
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


    $(document).on('click',"#tumunu_iptal_et",function(e) {

        $.confirm({
            title: 'Dikkat!',
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>İptal Sebebi</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="name form-control" required />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İşlemi Tamamla',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Açıklama Zorunlu');
                            return false;
                        }
                        let id = <?php echo $_GET['id'] ?>;
                        let desc = $('#desc').val()
                        jQuery.ajax({
                            url: baseurl + 'formainvoices/forma2_iptal',
                            dataType: "json",
                            method: 'post',
                            data: 'desc='+desc+'&invoice_id='+id+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                } else {
                                    $.alert(data.message);
                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
                            }
                        });



                    }
                },
                cancel: function () {
                    //close
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

        // jQuery.ajax({
        //     url: baseurl + 'form/malzeme_talep_product_status_toplu_iptal',
        //     type: 'POST',
        //     data: $('#data_form').serialize(),
        //     dataType: 'json',
        //     beforeSend: function(){
        //         $(this).html('Bekleyiniz');
        //         $(this).prop('disabled', true); // disable button
        //
        //     },
        //     success: function (data) {
        //         if (data.status == "Success") {
        //
        //             $('#'+$('#object-id').val()).remove();
        //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //             $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
        //             $("html, body").scrollTop($("body").offset().top);
        //             $('#pstatus').html(data.pstatus);
        //             window.setTimeout(function () {
        //                 window.location.reload();
        //             }, 3000);
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


    $(document).on('click', "#talep_iptal_muhasebe", function (e) {
        let id = $(this).attr('data-id');
        $.confirm({
            title: 'Dikkat!',
            theme: 'modern',
            closeIcon: true,
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi İptal Et?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="name form-control" required />' +
                '</div>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Tüm alanlar Zorunlu');
                            return false;
                        }
                        let desc = $('#desc').val()

                        let data_post = {
                            crsf_token: crsf_hash,
                            desc:desc,
                            foma2_id: id
                        }
                        $.post(baseurl + 'formainvoices/cancel', data_post, (response) => {
                            $('#loading-box').addClass('d-none');
                            let data = jQuery.parseJSON(response);
                            if (data.status == 'Success') {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
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
                                window.setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            } else if (data.status == 'Erorr') {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons: {
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
                cancel: function () {
                    //close
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
    $(document).on('click', "#iptal_return", function (e) {
        let id = $(this).attr('data-id');
        $.confirm({
            title: 'Dikkat!',
            theme: 'modern',
            closeIcon: true,
            icon: 'fa fa-info',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
                <form action="" class="formName">
                <div class="form-group">
                <p>İptal Talebine Durum Bildir<p/>
                <label>Açıklama</label>
                <input type="text" name="desc" id="yetkili_text" placeholder="Açıklama" class="name form-control" required />
                </div>
                <div class="form-group">
                <label>Durum</label>
                <select class="form-control" id="yetkili_status">
                <option value="1">İptali Onayla (Talebi İptal Et)</option>
                <option value="2">İptal Talebini Reddet (Talebi Geri Çek)</option>
                </select>
                </div>
                </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Durum Bildir',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Tüm alanlar Zorunlu');
                            return false;
                        }
                        let yetkili_text = $('#yetkili_text').val()
                        let yetkili_status = $('#yetkili_status').val()

                        let data_post = {
                            crsf_token: crsf_hash,
                            yetkili_text:yetkili_text,
                            yetkili_status:yetkili_status,
                            foma2_id: id
                        }
                        $.post(baseurl + 'formainvoices/cancel_talep_return', data_post, (response) => {
                            $('#loading-box').addClass('d-none');
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
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
                                window.setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            } else if (data.status == '410') {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons: {
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
                cancel: function () {
                    //close
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
    $(document).on('click', "#talep_iptal", function (e) {
        let id = $(this).attr('data-id');
        $.confirm({
            title: 'Dikkat!',
            theme: 'modern',
            closeIcon: true,
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İptal Talebi Oluşturmak İstemektesiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="name form-control" required />' +
                '</div>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('Tüm alanlar Zorunlu');
                            return false;
                        }
                        let desc = $('#desc').val()
                        let data_post = {
                            crsf_token: crsf_hash,
                            desc:desc,
                            foma2_id: id
                        }
                        $.post(baseurl + 'formainvoices/cancel_talep', data_post, (response) => {
                            $('#loading-box').addClass('d-none');
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
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
                                window.setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            } else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons: {
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
                cancel: function () {
                    //close
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

    $(document).on('click', "#status_change", function (e) {
        let id = $(this).attr('data-id');
        let old_status = $(this).attr('old_status');
        $.confirm({
            title: 'Dikkat!',
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Durum</label>' +
                '<select class="form-control" id="form_2_status_id"><option value="18">Cariye İşle</option><option value="2">Ödendi</option><option value="1">Bekliyor</option></select>' +
                '</div>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let form_2_status_id = $('#form_2_status_id').val()
                        jQuery.ajax({
                            url: baseurl + 'formainvoices/form2_status_change',
                            dataType: "json",
                            method: 'post',
                            data: 'old_status='+old_status+'&form_2_status_id='+form_2_status_id+'&foma2_id='+id+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    window.setTimeout(function () {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    $.alert(data.message);
                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
                            }
                        });



                    }
                },
                cancel: function () {
                    //close
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

    $(document).on('click','.transaction_pay',function (){
        let pay_id  = $(this).attr('trans_id');

        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'İşlem Görüntüleme',
            icon: 'fa fa-eye',
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

                html+='<form action="" class="formName">' +
                    '<div class="form-group islem_ozeti">' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    pay_id: pay_id,
                }

                $.post(baseurl + 'formainvoices/islem_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let text='';
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        text =`<table class="table">
                                    <thead>
                                        <tr>
                                        <th>İşlem Tarihi</th>
                                        <th>İşlem Tutarı</th>
                                        <th>İşlem Detayları</th>
                                        <th>İşlenecek Tutar</th>
                                        <th>Açıklama</th>
                                        </tr>
                                    </thead>
<tbody>
<tr>
<td>`+responses.details.invoicedate+`</td>
<td>`+currencyFormat(floatVal(responses.details.total))+`</td>
<td><a href='/transactions/view?id=`+responses.details.id+`'  class='btn btn-success' target="_blank"> Görüntüle</a></td>
<td><input type="number" class="form-control amount" max='`+responses.max+`'  onkeyup="amount_max(this)"></td>
<td><input type="text" class="form-control desc">
<input type="hidden"  class="form-control transaction_id" value="`+responses.details.id+`">
<input type="hidden"  class="form-control avans_id" value="`+responses.details.term+`">
<input type="hidden"  class="form-control method" value="`+responses.details.method+`">
</td>
</tbody>
                                </table>`;

                        if(responses.islme_durum){
                            text +=`<table class="table">
                                    <thead>
                                        <tr>
                                        <th>İşlem Tarihi</th>
                                        <th>İşlem Detayları</th>
                                        <th>İşlem Tutarı</th>
                                        <th>Bağlı Olduğu Forma 2</th>
                                        <th>Kaldır</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            $.each(responses.islem_details, function (index, items) {
                                text+=`<tr>
                                        <td>`+items.created_at+`</td>
                                        <td>`+items.desc+`</td>
                                        <td>`+currencyFormat(floatVal(items.amount))+`</td>
                                        <td>`+items.invoice_no+`</td>
                                        <td><button type="button" class="btn btn-danger delete_item_avans" data-pay_id='`+items.id+`'><i class="fa fa-trash"></i></button></td>
                                        </tr>`;
                            });
                            text+=`</tbody>
                                </table>`;
                        }
                    }
                    $('.islem_ozeti').empty().html(text);

                });

                return $('#person-container').html();
            },
            onContentReady:function (){

            },
            buttons: {
                formSubmit: {
                    text: 'İşlem Yap',
                    btnClass: 'btn btn-blue yetki',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            forma2_id:<?php echo  $_GET['id']; ?>,
                            transaction_id:$('.transaction_id').val(),
                            amount: $('.amount').val(),
                            desc: $('.desc').val(),
                            avans_id: $('.avans_id').val(),
                            method: $('.method').val(),
                        }

                        $.post(baseurl + 'formainvoices/islem_create',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde İşlem Gerçekleşti.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else if(responses.status==410){
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

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };

    function amount_max(obj){

        let max = $(obj).attr('max');
        if(parseFloat($(obj).val())>parseFloat(max)){
            $(obj).val(parseFloat(max))
            return false;
        }
    }
    $(document).on('click','.delete_item_avans',function (){
        let id = $(this).data('pay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İşlem Sil',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'İşlemi Kaldırmak İstediğinizden Eminmisiniz?',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            id: id,
                            forma2_id: <?php echo  $_GET['id']; ?>,
                        }
                        $.post(baseurl + 'formainvoices/delete_pay', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 410) {

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons: {
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
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {

            }
        });
    })



    $(document).on('click','#price_update_forma2',function (){
        let id = $(this).attr('forma2_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Fiyat GÜncelle',
            icon: 'fa fa-check',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            subtotal:$('#forma2_net_toplam_hiddden').val(),
                            tax:$('#forma2_kdv_toplam_hidden').val(),
                            total:$('#forma2_toplam_hidden').val(),
                            forma2_id: <?php echo  $_GET['id']; ?>,
                        }
                        $.post(baseurl + 'formainvoices/price_update', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 410) {

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons: {
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
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {

            }
        });
    })


    $(document).on('click','.edit_forma_2',function(){

        let forma_2_id = $(this).attr('forma_2_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Forma 2 Düzenle',
            icon: 'fa fa-pen',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html = `<form id='data_form_iskalemi'>
                    <div class="form-row">
                    <input id='razilastirma_id' name='razilastirma_id' type='hidden'>


                    <div class="form-group col-md-3">
                    <label for="name">Cari Tipi</label>
                    <select name="invoice_type" class="form-control select-box" id="invoice_type" name='invoice_type'>
                        <option value='0'>Seçiniz</option>
                          <?php foreach (forma2_invoice_type() as $type){
                    echo "<option value='$type->id'>$type->description</option>";
                } ?>
                    </select>
            </div>

                    <div class="form-group col-md-6">
                    <label for="name">Cari</label>
                    <select name="cari_id" class="form-control" disabled id="cari_id" name='cari_id'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (all_customer() as $all_cust)
                {
                    echo "<option value='$all_cust->id'>$all_cust->company</option>";
                } ?>
                    </select>
            </div>



                <div class="form-group col-md-3">
                    <label for="name">KDV Durumu</label>
                    <select disabled name="kdv_status" class="form-control select-box kdv_status" id="kdv_status" name='kdv_status'>
                        <option value='no'>KDV HARİÇ</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">KDV Oranı</label>
                    <input type="text" class="form-control tax_oran" id="tax_oran" value="0" disabled name='tax_oran'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Fatura Durumu</label>
                    <select class="form-control select-box" id="invoice_durumu" name='invoice_durumu'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (invoice_durumu_forma2() as $acc)
                {
                    echo "<option value='$acc->id'>$acc->name</option>";
                } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="name">Muqavele No</label>
                    <input type="text" class="form-control nuqavele_no" disabled id="nuqavele_no" name='nuqavele_no'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Forma 2 Tarihi</label>
                    <input type="date" class="form-control fis_date" id="fis_date" name='fis_date'>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">Açıklama</label>
                    <input type="text" class="form-control fis_note" id="fis_note" name='fis_note'>
                </div>

                <hr>
                    <div class='is_razilastirma_table col-md-12'></div>
<table class="table mt-5  is_razilastirma_table_edit" width="100%">
                                    <thead>
                                        <tr>
                                              <th>Görülecek İş</th>
                                              <th>Açıklama</th>
                                                <th>Birim Fiyatı(Kdv Hariç)</th>
                                                <th>Miktarı</th>
                                                 <th>Birim</th>
                                                <th>Toplam Tutar</th>
                                            </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <tfoot>
                                      </tfoot>


                                 </table>
                </div>
            </form>`;

                let data = {
                    forma_2_id: forma_2_id,
                }
                $.post(baseurl + 'formainvoices/get_forma_2_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#cari_id').val(responses.details.cid).trigger("change");
                    $('#invoice_type').val(responses.details.invoice_type_id).trigger("change");
                    $('#invoice_durumu').val(responses.details.refer).trigger("change");
                    $('#method_id').val(responses.details.method).trigger("change");
                    $('#tax_oran').val(responses.details.tax_oran);
                    $('#nuqavele_no').val(responses.details.muqavele_no);
                    $('#fis_date').val(responses.bill_date);
                    $('#fis_note').val(responses.details.notes);

                    let net_tutar = "<span style='font-weight: bold;'  class='net_tutar'>"+currencyFormat(parseFloat(responses.details.sub_total))+"</span><input type='hidden' class='net_tutar_total_hidden' value='"+responses.details.net_tutar+"'>";
                    let kdv_tutar = "<span style='font-weight: bold;'  class='kdv_tutar'>"+currencyFormat(parseFloat(responses.details.tax))+"</span><input type='hidden' class='kdv_tutar_total_hidden' value='"+responses.details.tax_tutar+"'>";
                    let genel_tutar = "<span style='font-weight: bold;'  class='genel_tutar'>"+currencyFormat(parseFloat(responses.details.total))+"</span><input type='hidden' class='genel_tutar_total_hidden' value='"+responses.details.genel_tutar+"'>";


                    let table_is='';
                    $.each(responses.details_items, function (q, item) {

                        let item_sub=parseFloat(item.qty)*parseFloat(item.price);
                        let quantity="<input onkeyup='item_hesap("+q+")'  eq='"+q+"' type='number' value='"+item.qty+"' class='form-control qty' name='qty[]'>"
                        let price="<input onkeyup='item_hesap("+q+")' eq='"+q+"' type='number' value='"+item.price+"' class='form-control price' name='price[]'>"
                        let toplam_tutar = "<span class='item_toplam_tutar'>"+currencyFormat(parseFloat(item_sub))+"</span><input type='hidden' class='item_toplam_tutar_hidden' value='"+item_sub+"'>";

                        table_is+=` <tr>
                                            <td>`+item.product+`</td>

<td><input type='text' class='form-control' value='`+item.item_desc+`' name='item_desc[]'></td>
                                            <td>`+price+`</td>
                                            <td>`+quantity+`</td>
                                            <td>`+ item.unit_name+`</td>
                                            <td>`+toplam_tutar+`<input type='hidden' class='item_task_id' name='item_task_id[]' value='`+ item.pid+`'></td>
                                            </tr>`;


                    })


                    $(".is_razilastirma_table_edit>tbody").append(table_is);
                    let table_is_tfoot=`<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Net Tutar</td><input type='hidden' name='net_tutar_db' class='net_tutar_db'>
                        <td>`+net_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">KDV Toplam</td><input type='hidden' name='kdv_tutar_db' class='kdv_tutar_db'>
                        <td>`+kdv_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Genel Toplam</td><input type='hidden' name='genel_tutar_db' class='genel_tutar_db'>
                        <td>`+genel_tutar+`</td><input type='hidden' name='forma_2_id' value="`+forma_2_id+`">

</tr>`;

                    $(".is_razilastirma_table_edit>tfoot").append(table_is_tfoot);


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

                        $.post(baseurl + 'formainvoices/update_new',$('#data_form_iskalemi').serialize(),(response)=>{
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
                                            text: 'Forma 2 Görüntüle',
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
                item_hesap(0);
                $('#fileupload_is').fileupload({
                    url: '/razilastirma/file_handling',
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_is_kalemi').val(img);
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

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    function item_hesap(eq){
        let item_qty= $('.qty').eq(eq).val();
        let item_price= $('.price').eq(eq).val();
        let toplam_tutar = parseFloat(item_price) *parseFloat(item_qty);
        $('.item_toplam_tutar').eq(eq).empty().text(currencyFormat(toplam_tutar))
        $('.item_toplam_tutar_hidden').eq(eq).val(toplam_tutar)


        let say = $('.item_toplam_tutar_hidden').length;
        let net_tutar=0;
        let kdv_tutar=0;
        let genel_tutar=0;
        let tax_oran = $('#tax_oran').val();
        for(let i=0; i<say; i++){
            net_tutar+=parseFloat($('.item_toplam_tutar_hidden').eq(i).val());
        }

        if(parseInt(tax_oran)){
            genel_tutar= net_tutar* (1+(tax_oran/100));
            kdv_tutar= net_tutar * ((tax_oran/100));
        }
        else {
            genel_tutar=net_tutar;
        }
        $('.net_tutar').empty().text(currencyFormat(net_tutar))
        $('.kdv_tutar').empty().text(currencyFormat(kdv_tutar))
        $('.genel_tutar').empty().text(currencyFormat(genel_tutar))
        $('.net_tutar_db').val(net_tutar);
        $('.kdv_tutar_db').val(kdv_tutar);
        $('.genel_tutar_db').val(genel_tutar);


    }


    $(document).on('click','#file_upload',function (){
        let forma_2_id = $(this).attr('forma_id');
        var url = '<?php echo base_url() ?>formainvoices/file_handling';
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
                            forma_2_id:  forma_2_id,
                            image_text:  $('#image_text_update').val(),
                        }
                        $.post(baseurl + 'formainvoices/upload_file',data,(response) => {
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
                                                location.reload()
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
                        let data = {
                            file_id:file_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'formainvoices/delete_file',data,(response)=>{
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



</script>
