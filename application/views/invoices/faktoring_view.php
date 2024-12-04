<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Faktorinq Görüntüleme</span></h4>
        </div>
        <div>
            <a href="#" class="btn btn-warning edit_button"><i class="fa fa-edit"></i>&nbsp;Düzenle</a>
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
                                        <table class="table">

                                            <tbody>
                                            <tr>
                                                <th scope="row">Muqavile No</th>
                                                <th scope="row">Tastiqlenmiş Meblağ</th>
                                                <th scope="row">Esas Borç</th>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <?php echo $invoice['invoice_name'] ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $tarih1=dateformat($invoice['invoicedate']);
                                                    $tarih2=date('Y-m-d');
                                                    $fark = strtotime($tarih2) - strtotime($tarih1);
                                                    $gun_sayisi=floor($fark / (60 * 60 * 24)) ;

                                                    $yillik=($invoice['total']*(intval($invoice['notes'])==0) ? 0 : (100/intval($invoice['notes'])));
                                                    $hesap=($yillik/360);

                                                    $tastig_t=($hesap*$gun_sayisi)+$invoice['total'];
                                                    echo amountFormat($tastig_t); ?>
                                                </td>
                                                <td>
                                                    <?php  echo amountFormat($invoice['total']); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Verilme Tarihi / Bitme Tarihi</th>
                                                <th>Növü</th>
                                                <th>Bugüne Hesaplanmış Faiz</th>
                                            </tr>
                                            <tr>
                                                <td><?php echo dateformat($invoice['invoicedate']).' / '.dateformat($invoice['invoiceduedate'])  ?></td>
                                                <td>Alış Sifarişinin Maliyyeleşdirilmesi</td>
                                                <td><?php echo amountFormat($hesap*$gun_sayisi) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Faiz Derecesi / Cerime Faizi</th>
                                                <th>Techizatçı Alıcı</th>
                                            </tr>
                                            <tr>
                                                <td><?php echo $invoice['notes'].' %  /  30 %'  ?></td>
                                                <td><?php echo customer_details($invoice['csd'])['company'] ?></td>

                                            </tr>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table">

                                        <tbody>
                                        <tr>
                                            <th scope="row">Cari</th>
                                            <th scope="row">Fatura No</th>
                                            <th scope="row">Tutar</th>

                                        </tr>
                                        <?php foreach ($products as $prd)
                                        {
                                            $id=$prd['pid'];
                                            echo '<tr> 
                                    <td>'.customer_details(invoice_details($id)->csd)['company'].'</td>
                                    <td>'.invoice_details($id)->invoice_no.'</td>
                                    <td>'.amountFormat(invoice_details($id)->total).'</td>
                                    </tr>';
                                        } ?>


                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<div id="calculate" class="modal fade">
    <div class="modal-dialog"  style="max-width: 700px; !important;">
        <div class="modal-content">
            <form id="data_form" type="POST">
                <div class="modal-header">

                    <h4 class="modal-title">Hesaplama</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">


                    <div class="form-group row">
                        <div class="col-sm-6"><label for="invocieno" class="caption">İnvoysun maliyyələşdiriləcək hissəsi</label>

                            <div class="input-group">
                                <input class="form-control fonksiyon" value="<?php echo $invoice['total']?>" min="500" type="number" id="tutar" name="tutar" max="550000">

                            </div>
                            <span style="font-size: 9px;line-height: 30px;">Min : 500 AZN Max: 550000 AZN</span>
                        </div>

                        <div class="col-sm-3"><label for="invocieno" class="caption"><b>Maliyyələşdirmə məbləği</b></label>

                            <div class="input-group">
                                <span id="hesaplanan_tutar">0.00 AZN</span>
                            </div>
                        </div>
                        <div class="col-sm-3"><label for="invocieno" class="caption"><b>Hesablanacaq faiz xərci*</b></label>

                            <div class="input-group">
                                <span id="hesaplanan_faiz">0.00 AZN</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">İnvoysların sayı</label>

                            <div class="input-group">
                                <input class="form-control fonksiyon" value="<?php echo count($products)?>" type="number" id="fatura_sayisi" name="fatura_sayisi" max="5000">
                            </div>
                            <span style="font-size: 9px;line-height: 30px;">Min : 1 invoys Max: 5000 invoys</span>
                        </div>
                        <div class="col-sm-6">
                            </br>
                            <p>
                                *Alıcıdan olan debitor borclarının güzəşt edilməsi hüququnun Banka ötürüldüyü təqdirdə hesablanacaq faiz xərci daha az olacaqdır

                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">İnvoysun ödəniş müddəti</label>

                            <div class="input-group">
                                <input class="form-control fonksiyon" value="5" type="number" id="gun_sayisi" name="gun_sayisi" min="5" max="18">
                            </div>
                            <span style="font-size: 9px;line-height: 30px;">Min : 5 Gün Max: 18 Gün</span>
                        </div>

                        <div class="col-sm-3">
                            <label for="invocieno" class="caption">Verilme Tarihi</label>

                            <div class="input-group">
                                <input type="text" class="form-control editdate required"
                                       placeholder="Billing Date" value="<?php echo dateformat($invoice['invoicedate']) ?>" name="verilme_tarihi" id="verilme_tarihi"

                                       autocomplete="false">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="invocieno" class="caption">Bitme Tarihi</label>

                            <div class="input-group">
                                <input type="text" class="form-control editdate required"
                                       placeholder="Billing Date" value="<?php echo dateformat($invoice['invoiceduedate'])?>" name="bitme_tarihi" id="bitme_tarihi"

                                       autocomplete="false">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Faturalar</label>

                            <div class="input-group">
                                <select class="form-contol select-box" multiple name="faturalar[]">
                                    <option value="0">Seçiniz</option>
                                    <?php
                                    foreach (alis_faturalari() as $fatura)
                                    {
                                         foreach ($products as $prd) {

                                            $id = $prd['pid'];
                                            if($fatura->id==$id)
                                            {
                                                echo "<option selected value='$fatura->id'> $fatura->firma_adi - $fatura->invoice_no </option>";
                                            }

                                        }
                                        echo "<option value='$fatura->id'> $fatura->firma_adi - $fatura->invoice_no </option>";

                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Techizatçı / Alıcı</label>

                            <div class="input-group">
                                <select class="form-contol select-box" name="tec_alici">
                                    <option value="0">Seçiniz</option>
                                    <?php foreach (all_customer() as $customer)
                                    {
                                        if($invoice['csd']==$customer->id)
                                        {
                                            echo "<option selected value='$customer->id'> $customer->company </option>";
                                        }
                                        else
                                            {
                                                echo "<option value='$customer->id'> $customer->company </option>";
                                            }

                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Muqavile No</label>

                            <div class="input-group">
                                <input class="form-control" value="<?php echo $invoice['invoice_name']?>"  name="muqavile_no">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Faiz</label>

                            <div class="input-group">
                                <input class="form-control" value="<?php echo $invoice['notes']?>"  name="faiz">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <input type="hidden" id="action-url" value="invoices/faktorinq_edit_action">
                    <input type="hidden" id="fak_id" name="fak_id" value="<?php echo $_GET['id']?>">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="submit-data-new">Güncelle</button>
                    <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .datepicker-top-left, .datepicker-top-right
    {
        z-index: 99999 !important;
    }
</style>

<script type="text/javascript"> $('.editdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});</script>
<script>

    $(document).on('click','#submit-data-new',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Faktorinq Güncelleme ',
            icon: 'fa fa-question',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'Güncellemek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'invoices/faktorinq_edit_action',$('#data_form').serialize(),(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status=='Success'){
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
                            else{
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

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {

                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })


    $(document).on('click', ".edit_button", function (e) {

        e.preventDefault();
        $('#calculate').modal({backdrop: 'static', keyboard: false});

    });
    $(document).ready(function () {

        $('.select-box').select2({'width':'300px'});
        $('.fonksiyon').keyup();
    });


    $("#faktorinq-confirm").on("click", function() {

        var action_url= $('#calculate #action-url').val();

        removeObject(o_data,action_url);
    });

    $('.fonksiyon').keyup(function () {

        var invoices = $('#fatura_sayisi').val();
        var tutar  = $('#tutar').val();
        var days  = $('#gun_sayisi').val();

        var financing=Math.round(tutar*0.9);

        $('#hesaplanan_tutar').html(currencyFormat(financing));

        if(financing>=30000){
            $('#hesaplanan_faiz').html(currencyFormat(Math.round((financing*0.125)/(360/days))));
        }else{
            if(invoices<10){
                $('#hesaplanan_faiz').html(currencyFormat(Math.round((financing*0.135)/(360/days))));
            }else{
                $('#hesaplanan_faiz').html(currencyFormat(Math.round((financing*0.145)/(360/days))));
            }
        }

    })

    function currencyFormat(num) {
        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
</script>