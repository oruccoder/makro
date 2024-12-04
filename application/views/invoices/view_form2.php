
<style>
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
        border-collapse: collapse;
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

            <div class="content-body">
                <div class="col-md-12">
                    <br>
                    <?php
                    $disabled='';
                    if($invoice['status']!=3)
                    {
                        if($invoice['bildirim_durumu']==1)
                        {
                            ?>
                            <button disabled id="onay_iste" type="button" class="btn btn-info mb-1">Onay Sistemine Sunulmuştur</button>&nbsp;

                            <?php
                        }
                        else {?>
                            <button  id="onay_iste" type="button" class="btn btn-info mb-1">Onay Sistemini Başlat</button>
                            <a href="/invoices/edit_forma_2/<?php echo $_GET['id'] ?>"  class="btn btn-warning mb-1">Düzenle</a>
                        <?php } ?>
                    <?php } ?>
                    <?php if($invoice['status']==3){
                        $disabled ='disabled';
                    }else {
                    if($this->aauth->get_user()->id == 61 || $this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 174) {
                        ?>
                        <button id="status_change" old_status="<?php echo $invoice['status']; ?>" data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-success mb-1">Durum Güncelle</button>&nbsp;
                        <?php
                    }
                    } ?>
                    <button <?php echo $disabled ?> id="talep_iptal" data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-danger mb-1">Talebi İptal Et</button>&nbsp;
                </div>
                <div class="col-md-12">


                    <br>
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
                            <td>
                                Forma 2
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
                                        echo 'Fiziki Şexs'.' '.customer_details($invoice['csd'])['company'].customer_details($invoice['csd'])['taxid'];
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
                            <td style="text-align: right"><?php echo  dateformat($invoice['invoicedate'])?></td>
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

                        </tbody>
                    </table>
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
                            else{ // Ödeme
                                $odeme_total+=$value->total_transaction;
                            }
                            ?>
                            <tr>
                                <td><?php echo $value->invoicedate ?></td>
                                <td><?php echo $value->notes ?></td>
                                <td><?php echo personel_details($value->eid) ?></td>
                                <td><?php echo account_type_sorgu($value->method) ?></td>
                                <td><?php echo $value->invoice_type_desc ?></td>
                                <td><?php echo amountFormat($value->total_transaction) ?></td>
                            </tr>
                            <?php

                        } ?>
                        <?php

                        $total_cikan = $odeme_total  + $teminat + $ceza_total;
                        $kalan = (($f_totals*$carpim)+$invoice['tax'])-($total_cikan);
                        $toplam_hakedis = ($f_totals*$carpim) +($prim*$carpim) +  $invoice['tax'];
                        $teminat=$teminat-$temiat_odeme;
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: right">Forma2 Net Toplamı</td>
                            <td><b><?php echo amountFormat($f_totals*$carpim )?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right"> KDV Toplamı (<?php echo round($invoice['tax_oran'],2).' %';?> )</td>
                            <td><b><?php echo amountFormat($invoice['tax'] )?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right"> Forma2 Toplamı</td>
                            <td><b><?php echo amountFormat((floatval($f_totals*$carpim)) +$invoice['tax'] )?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right">Prim Toplamı</td>
                            <td><b><?php echo amountFormat($prim*$carpim )?></b></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right">Toplam Hakediş</td>
                            <td><b><?php echo amountFormat($toplam_hakedis )?></b></td>
                        </tr>
                        <tr>

                            <td colspan="5" style="text-align: right">Ödeme Toplamı</td>
                            <td><b><?php echo amountFormat($odeme_total )?></b></td>
                        </tr>
                        <tr>

                            <td colspan="5" style="text-align: right">Kesinti Toplamı</td>
                            <td><b><?php echo amountFormat($ceza_total )?></b></td>
                        </tr>
                        <tr>

                            <td colspan="5" style="text-align: right">Teminat Toplamı</td>
                            <td><b><?php echo amountFormat($teminat )?></b></td>
                        </tr>

                        <tr>
                            <td colspan="5" style="text-align: right">Kalan</td>
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
            </div>
            <div class="content-body">
                <table class="table">
                    <tr>
                        <td><button id="tumunu_onayla"  type="button"  class="btn btn-success">Formu Onayla</button>
                            <button id="tumunu_iptal_et" type="button"  class="btn btn-danger">Formu İptal Et</button>
                        </td>

                    </tr>

                </table>

            </div>
            <div class="content-body">
                <table class="table">
                    <tr>
                        <th>Proje Sorumlusu <br>(<?php echo personel_details($invoice['proje_sorumlu_id'])?>)</th>
                        <th>Proje Müdürü <br>(<?php echo personel_details($invoice['proje_muduru_id'])?>)</th>
                        <th>Genel Müdür <br>(<?php echo personel_details($invoice['genel_mudur_id'])?>)</th>
                    </tr>
                    <tr>

                        <td><?php echo purchase_status(onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_sorumlusu_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(10,$_GET['id'],0,"proje_sorumlusu_onay_saati")['onay_saati']).'<br>'.onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_sorumlusu_status")['note'];?></td>
                        <td><?php echo purchase_status(onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_muduru_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(10,$_GET['id'],0,"proje_muduru_onay_saati")['onay_saati']).'<br>'.onay_durumlari_ogren_product_str(10,$_GET['id'],0,"proje_muduru_status")['note'];?></td>
                        <td><?php echo purchase_status(onay_durumlari_ogren_product_str(10,$_GET['id'],0,"genel_mudur_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(10,$_GET['id'],0,"genel_mudur_onay_saati")['onay_saati']).'<br>'.onay_durumlari_ogren_product_str(10,$_GET['id'],0,"genel_mudur_status")['note'];?></td>

                    </tr>

                </table>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    $(document).on('click',"#onay_iste",function(e) {

        var invoice_id=<?php echo  $_GET['id']; ?>;
        jQuery.ajax({
            url: baseurl + 'invoices/bildirim_olustur_forma2',
            type: 'POST',
            data: {
                'invoice_id':invoice_id,
            },
            dataType: 'json',
            beforeSend: function(){
                $("#onay_iste").html('Bekleyiniz');
                $("#onay_iste").prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $("#onay_iste").html('Onay Sistemine Sunulmuştur.');
                    $("#onay_iste").prop('disabled', true); // disable button

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    });



    $(document).on('click',"#tumunu_onayla",function(e) {
        let id = <?php echo $_GET['id'] ?>;
        let onay_tipi  = 0;


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

                $.post(baseurl + 'invoices/forma2_user_kontrol',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let genel_html='';
                    let responses = jQuery.parseJSON(response);
                    if(responses.genel_mudur){
                        genel_html ='<label>Onay Tipi</label>' +
                            '<select id="onay_tipi" class="form-control name"><option value="1">Cariye İşle</option></select>';

                    }
                    else {
                        genel_html = '<p>Onay vermek üzeresiniz. Emin misiniz?</p>';
                    }




                    $('.genel_mudur_onayi').empty().html(genel_html);

                });

                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Forma Onay Ver',
                    btnClass: 'btn-blue',
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

                        $.post(baseurl + 'invoices/forma2_onay',data,(response)=>{
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
        //     url: baseurl + 'invoices/forma2_onay',
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
                            url: baseurl + 'invoices/forma2_iptal',
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


    $(document).on('click', "#talep_iptal", function (e) {
        let id = $(this).attr('data-id');
        $.confirm({
            title: 'Dikkat!',
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi İptal Etmek üzerisiniz!Emin misiniz?<p/>' +
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
                        jQuery.ajax({
                            url: baseurl + 'invoices/form2_iptal_ajax',
                            dataType: "json",
                            method: 'post',
                            data: 'desc='+desc+'&foma2_id='+id+'&'+crsf_token+'='+crsf_hash,
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
                            url: baseurl + 'invoices/form2_status_change',
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

</script>
