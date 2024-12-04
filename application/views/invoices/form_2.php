<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('form_2_listesi') ?> <a
                        href="<?php echo base_url('invoices/new_forma_2') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i></a></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-2">Forma 2 Tarihi</div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                               class="date30 form-control form-control-sm" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                               data-toggle="datepicker" autocomplete="off"/>
                    </div>

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                    </div>
                    <div class="col-md-2">
                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>
                    </div>

                </div>
                <hr>
                <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th>Forma 2 Tipi</th>
                        <th>Muqavile No</th>
                        <th>Forma2 No</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th>Proje</th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
<!--                        <th class="no-sort">Ödeme</th>-->


                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<div id="pop_modal_transaction" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Ödeme Ekranı</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_pay" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Tip</label>
                            <input readonly name="cari_text" class="form-control" id="cari_text">
                            <input name="cari_pers_type"  type="hidden" id="cari_pers_type">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Proje</label>
                            <input readonly name="proje_text" class="form-control" id="proje_text">
                            <input type="hidden"  id="proje_id_pay" name="proje_id">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Proje Bölümü</label>
                            <input readonly name="bolum_text" class="form-control" id="bolum_text">
                            <input type="hidden" name="bolum_id" id="bolum_id">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label cst_label">Cari</label>
                            <input readonly name="payer_name" class="form-control" id="payer_name">
                            <input type="hidden" name="payer_id"  id="payer_id">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Tür</label>
                            <select name="pay_type" class="form-control" id="pay_type">
                                <?php foreach (transaction_type() as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Ödeme Türü</label>
                            <select name="paymethod" class="form-control" id="paymethod">
                                <option>Seçiniz</option>
                                <?php foreach (account_type_islem() as $acc)
                                {
                                    echo "<option value='$acc->id'>$acc->name</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-6 maas_ay" style="display: none">

                            <label class="form-label">Seçilen Aya İstinaden</label>
                            <select name="maas_ay" class="form-control" id="maas_ay">
                                <option value="1">Ocak - 01</option>
                                <option value="2">Şubat - 02</option>
                                <option value="3">Mart - 03</option>
                                <option value="4">Nisan - 04</option>
                                <option value="5">Mayıs - 05</option>
                                <option value="6">Haziran - 06</option>
                                <option value="7">Temmuz - 07</option>
                                <option value="8">Ağuston - 08</option>
                                <option value="9">Eylül - 09</option>
                                <option value="10">Ekim - 10</option>
                                <option value="11">Kasım - 11</option>
                                <option value="12">Aralık - 12</option>
                            </select>

                        </div>
                        <input type="hidden" name="cari_in_invoice" id="cari_in_invoice">

                        <div class="col-sm-6 ">
                            <label class="form-label">İşlem Tarihi</label>
                            <input type="text" class="form-control required"
                                   name="date" data-toggle="datepicker" id="invoice_date" autocomplete="false">
                        </div>

                        <div class="col-sm-6 ">
                            <label class="form-label">Ödeme Para Birimi</label>
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
                        <div class="col-sm-6 ">
                            <label class="form-label">Kur Değeri</label>
                            <input type="text" class="form-control" placeholder="Kur"
                                   name="kur_degeri" id="kur_degeri" value="1">
                        </div>

                        <div class="col-sm-6 ">
                            <label class="form-label">Hesap</label>
                            <select name="pay_acc" class="form-control pay_acc">
                                <option>Ödeme Türü Seçiniz</option>

                            </select>
                        </div>
                        <div class="col-sm-6 ">
                            <label class="form-label">Toplam</label>
                            <input type="number" placeholder="Tutar"
                                   class="form-control margin-bottom  required" name="amount" id="amount">
                        </div>
                        <div class="col-sm-6 ">
                            <label class="form-label">Açıklama</label>
                            <input type="text" placeholder="Note"
                                   class="form-control" name="note" id="notes">
                        </div>
                        <div class="col-sm-6 ">
                            <label class="form-label">Durum</label>
                            <select name="status" id="status" class="form-control">
                                <?php
                                foreach (invoice_status()  as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden"  id="action-url" value="transactions/save_trans">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_pay"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-dialog {
        max-width: 50% !important;
    }
    .col-sm-6{
        padding-bottom: 10px !important;
    }
</style>

<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click', "#submit_model_pay", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_pay").serialize();
        var action_url= $('#form_model_pay #action-url').val();
        $("#pop_modal_transaction").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $(document).on('change','#paymethod',function (e){
        var paymethod = $(this).val();
        $(".pay_acc option").remove();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/kasalar',
            data: 'metod=' +paymethod,
            success: function (datas) {
                if(datas)
                {
                    var data = jQuery.parseJSON(datas);
                    jQuery.each(data.kasalar, function (key, item) {
                        $(".pay_acc").append('<option value="'+ item.id +'">'+item.holder +'</option>');
                    });


                }

            }
        });


    })
    $(document).on('change', "#cari_pers_type", function (e) {
        var deger = $(this).val();
        if(deger==2)
        {
            $("#pay_type option").remove();
            $('#pay_type').append($('<option>').val(14).text('Avans'));
            $('#pay_type').append($('<option>').val(50).text('Personel Razı'));
            $('#pay_type').append($('<option>').val(51).text('Personel Borç Ödeme'));
            $('#pay_type').append($('<option>').val(16).text('Sipariş Prim Ödemesi'));
            $('#pay_type').append($('<option>').val(52).text('Personel Borçlandırma'));
            $('#pay_type').append($('<option>').val(12).text('Maaş Ödemesi'));
            $('#pay_type').append($('<option>').val(49).text('Banka Maaş Ödemesi'));
            $('.maas_ay').css('visibility','visible');
        }
        else if(deger==1 || deger==7)
        {
            $("#pay_type option").remove();
            $('#pay_type').append($('<option>').val(3).text('Tahsilat'));
            $('#pay_type').append($('<option>').val(4).text('Ödeme'));
            $('#pay_type').append($('<option>').val(43).text('Avans Ödemesi'));
            $('#pay_type').append($('<option>').val(44).text('Avans Tahsilatı'));
            $('#pay_type').append($('<option>').val(45).text('Forma2 Ödemesi'));
            $('#pay_type').append($('<option>').val(46).text('Forma2 Tahsilatı'));
            $('#pay_type').append($('<option>').val(54).text('Forma2 Cezası'));
            $('#pay_type').append($('<option>').val(55).text('Forma2 Depozit'));
            $('#pay_type').append($('<option>').val(57).text('Forma2 Prim'));
            $('#pay_type').append($('<option>').val(17).text('Fatura Ödeme'));
            $('#pay_type').append($('<option>').val(18).text('Fatura Tahsilatı'));
            $('#pay_type').append($('<option>').val(19).text('Fatura KDV Ödemesi'));
            $('#pay_type').append($('<option>').val(20).text('Fatura KDV Tahsilatı'));
            $('#pay_type').append($('<option>').val(47).text('Avans Fatura KDV Ödemesi'));
            $('#pay_type').append($('<option>').val(48).text('Avans Fatura KDV Tahsilatı'));
            $('#pay_type').append($('<option>').val(22).text('Devir Alacak'));
            $('#pay_type').append($('<option>').val(23).text('Devir Borç'));
            $('.maas_ay').css('visibility','hidden');

        }
        else if(deger==5)
        {
            $("#pay_type option").remove();
            $('#pay_type').append($('<option>').val(0).text('Seçiniz'));
            $('#pay_type').append($('<option>').val(33).text('Personel Giderleri Ödeme'));
            $('.maas_ay').css('visibility','hidden');

        }
        else if(deger==3)
        {
            $("#pay_type option").remove();
            $('#pay_type').append($('<option>').val(4).text('Ödeme'));
            $('#pay_type').append($('<option>').val(19).text('Fatura KDV Ödemesi'));
            $('.maas_ay').css('visibility','hidden');

        }

        else if(deger==4)
        {
            $("#pay_type option").remove();
            $('#pay_type').append($('<option>').val(25).text('Açılış Bakiyesi'));
            $('.maas_ay').css('visibility','hidden');

        }
        else if(deger==6)
        {
            $("#pay_type option").remove();
            $('#pay_type').append($('<option>').val(4).text('Ödeme'));
            $('#pay_type').append($('<option>').val(3).text('Tahsilat'));
            $('.maas_ay').css('visibility','hidden');

        }
    });
    function saveMDataa(o_data,action_url) {
        var errorNum = farmCheck();
        if (errorNum > 0) {
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("#notify .message").html("<strong>Hata</strong>");
            $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
        } else {
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {


                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                        window.setTimeout(function () {
                            window.location.reload();
                        }, 3000);
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
        }
    }

    $(document).on('click', ".odeme_button", function (e) {

        e.preventDefault();
        let forma_2_id = $(this).attr('data-id');
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

                html += '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Ödeme Talebi Etmek Üzeresiniz! Emin misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Ödeme Tipi</label>' +
                    '<select class="form-control method" name="method" id="method"><option value="1">Nakit</option><option value="3">Banka</option></select>'+
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Net Toplam</label>' +
                    '<input type="number" disabled name="net_tutar" id="net_tutar" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Toplam KDV</label>' +
                    '<input type="number" disabled name="total_kdv" id="total_kdv"  class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Toplam</label>' +
                    '<input type="number" disabled name="total" id="total" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Kalan</label>' +
                    '<input type="number" disabled name="kalan" id="kalan" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Talep Edilen Tutar</label>' +
                    '<input type="number" name="talep_total" onkeyup="amount_max()"  id="talep_total" class="form-control name" />' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    id: forma_2_id,
                }

                $.post(baseurl + 'invoices/forma2_info', data, (response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);

                    if(responses.status=='Success'){


                        let sub_total = parseFloat(responses.details.subtotal);
                        let tax = parseFloat(responses.details.tax);
                        let total = parseFloat(responses.details.total);
                        let kalan = parseFloat(responses.kalan);

                        $('#net_tutar').val(sub_total.toFixed(2));
                        $('#total_kdv').val(tax.toFixed(2));
                        $('#total').val(total.toFixed(2));
                        $('#kalan').val(kalan);
                        $('#talep_total').attr('max',responses.kalan)
                        if(responses.details.method){
                            $('.method').val(responses.details.method)
                        }
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
                            content:responses.message,
                            buttons: {
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                        $('.close').click();
                        return false;

                    }

                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady: function () {
            },
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
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
                        let talep_total = $('#talep_total').val();
                        let total_kdv = $('#total_kdv').val();
                        let net_tutar = $('#net_tutar').val();
                        let total = $('#total').val();
                        let method = $('#method').val();



                        let data = {
                            crsf_token: crsf_hash,
                            method: method,
                            total: total,
                            net_tutar: net_tutar,
                            total_kdv: total_kdv,
                            talep_total: talep_total,
                            desc: desc,
                            forma_2_id: forma_2_id,
                            firma: '',
                            tip: 'forma2',
                        }

                        $.post(baseurl + 'form/odeme_talep_create', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 'Success') {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'yellow',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'yellow',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
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




        // $.ajax({
        //     type: "POST",
        //     url: baseurl + 'reports/invoices_details',
        //     data: 'talep_id='+ id+
        //         '&'+crsf_token+'='+crsf_hash,
        //     success: function (data) {
        //         var data_ = jQuery.parseJSON(data);
        //         if(data_.status=='Success'){
        //             let cari_pers_type = data_.item.cari_pers;
        //             let proje_id = data_.item.proje_id;
        //             let proje_text = data_.item.proje_name;
        //
        //
        //             $('#cari_pers_type').val(1)
        //             $('#cari_text').val('Cari')
        //             $('.cst_label').empty().append('Cari');
        //             $("#pay_type option").remove();
        //             $('#pay_type').append($('<option>').val(3).text('Tahsilat'));
        //             $('#pay_type').append($('<option>').val(4).text('Ödeme'));
        //             $('#pay_type').append($('<option>').val(43).text('Avans Ödemesi'));
        //             $('#pay_type').append($('<option>').val(44).text('Avans Tahsilatı'));
        //             $('#pay_type').append($('<option>').val(45).text('Forma2 Ödemesi'));
        //             $('#pay_type').append($('<option>').val(46).text('Forma2 Tahsilatı'));
        //             $('#pay_type').append($('<option>').val(54).text('Forma2 Cezası'));
        //             $('#pay_type').append($('<option>').val(55).text('Forma2 Depozit'));
        //             $('#pay_type').append($('<option>').val(57).text('Forma2 Prim'));
        //             $('#pay_type').append($('<option>').val(17).text('Fatura Ödeme'));
        //             $('#pay_type').append($('<option>').val(18).text('Fatura Tahsilatı'));
        //             $('#pay_type').append($('<option>').val(19).text('Fatura KDV Ödemesi'));
        //             $('#pay_type').append($('<option>').val(20).text('Fatura KDV Tahsilatı'));
        //             $('#pay_type').append($('<option>').val(47).text('Avans Fatura KDV Ödemesi'));
        //             $('#pay_type').append($('<option>').val(48).text('Avans Fatura KDV Tahsilatı'));
        //             $('#pay_type').append($('<option>').val(22).text('Devir Alacak'));
        //             $('#pay_type').append($('<option>').val(23).text('Devir Borç'));
        //             $('.maas_ay').css('display','none');
        //
        //
        //
        //             let bolum_name='';
        //             if(data_.item.proje_bolum_name!='null'){
        //                 bolum_name =data_.item.proje_bolum_name;
        //             }
        //             $('#proje_id_pay').val(proje_id)
        //
        //             $('#proje_text').val(data_.item.proje_name)
        //             $('#notes').val(data_.item.description)
        //             $('#cari_in_invoice').val(id)
        //
        //             $('#bolum_id').val(data_.item.proje_bolum_id)
        //             $('#bolum_text').val(bolum_name);
        //             $('#payer_id').val(data_.item.csd);
        //             $('#payer_name').val(data_.item.payer);
        //             $('#amount').val(parseFloat(data_.item.total));
        //
        //
        //         }
        //
        //     }
        // });
    })
    $(document).ready(function () {




        draw_data();

        function draw_data(start_date = '', end_date = '') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('invoices/form2_ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ]
            });
        };

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });
    });

    function amount_max(){

        let element='#talep_total';
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }
</script>
