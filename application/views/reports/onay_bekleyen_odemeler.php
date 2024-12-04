<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Onay Bekleyen Ödemeler</span></h4>
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
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card bg-teal text-white" style="height: 170px;">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0 bekleyen_odeme"></h3>
                                        </div>
                                        <div>
                                            Toplam Bekleyen Ödeme
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-pink text-white" style="height: 170px;">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0 bank_bekleyen"></h3>
                                        </div>
                                        <div>
                                            Toplam Bankadan Bekleyen Ödeme
                                        </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card bg-primary text-white" style="height: 170px;">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0 nakit_bekleyen"></h3>
                                        </div>
                                        <div>
                                            Toplam Nakit Bekleyen Ödeme
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <select class="select-box form-control" id="payer" name="payer" >
                                            <option value="0">Ödeme Bekleyen</option>
                                            <?php foreach (talep_payer_onay_bekleyen() as $rows)
                                            {
                                                ?><option value="<?php echo $rows?>"><?php echo $rows?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="select-box form-control" id="status" name="status" >
                                            <option  value="0">Durum</option>
                                            <?php foreach (purchase_status() as $rows)
                                            {
                                                ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="select-box form-control" id="proje_id" name="proje_id" >
                                            <option value="0">Proje Seçiniz</option>
                                            <?php foreach (all_projects() as $rows)
                                            {
                                                ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="invoices" class="table datatable-show-all" cellspacing="0"  width="100%">
                                            <thead>
                                            <tr>

                                                <th>#</th>
                                                <th>Form Tipi</th>
                                                <th>Proje</th>
                                                <th>Ödeme Bekleyen</th>
                                                <th>Açıklama</th>
                                                <th>Ödeme Tipi</th>
                                                <th>Toplam</th>
                                                <th>Ödenen Toplam</th>
                                                <th>Kalan</th>
                                                <th>İşlem</th>


                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort">İşlem</th>

                                            </tr>
                                            </tfoot>

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
                            <input name="talep_id[]"  type="hidden" id="talep_id">
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
                        <div class="col-sm-6 cari_in_invoice" style="display: block">
                            <label class="form-label">FATURA LISTESI</label>
                            <select name="cari_in_invoice" class="form-control" id="cari_in_invoice">
                            </select>
                        </div>
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
                            <label class="form-label">Toplam</label>
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

<div id="person-container" class="d-none">
    <div class="media-list p-2" id="person-list"></div>
</div>
<style>
    .modal-dialog {
        max-width: 50% !important;
    }
    .col-sm-6{
        padding-bottom: 10px !important;
    }
</style>


<script>

    $(document).on('click', "#submit_model_pay", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_pay").serialize();
        var action_url= $('#form_model_pay #action-url').val();
        $("#pop_modal_transaction").modal('hide');
        saveMDataa(o_data,action_url);
    });
    $(document).on('click', ".odeme_button", function (e) {

        e.preventDefault();
        $('#talep_id').val($(this).attr('data-id'));
        let id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: baseurl + 'reports/talep_details',
            data: 'talep_id='+ id+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                var data_ = jQuery.parseJSON(data);
                if(data_.status=='Success'){
                    let cari_pers_type = data_.item.cari_pers;
                    let proje_id = data_.item.proje_id;
                    let proje_text = data_.item.proje_name;
                    if(cari_pers_type==1) // Personel
                    {
                        $('#cari_pers_type').val(2)
                        $('#cari_text').val('Personel')
                        $('.cst_label').empty().append('Personel');

                        $('.cari_in_invoice').css('display','none');

                        $("#pay_type option").remove();
                        $('#pay_type').append($('<option>').val(14).text('Avans'));
                        $('#pay_type').append($('<option>').val(50).text('Personel Razı'));
                        $('#pay_type').append($('<option>').val(51).text('Personel Borç Ödeme'));
                        $('#pay_type').append($('<option>').val(16).text('Sipariş Prim Ödemesi'));
                        $('#pay_type').append($('<option>').val(52).text('Personel Borçlandırma'));
                        $('#pay_type').append($('<option>').val(12).text('Maaş Ödemesi'));
                        $('#pay_type').append($('<option>').val(49).text('Banka Maaş Ödemesi'));
                        $('.maas_ay').css('display','block');


                    }
                    else if(cari_pers_type==2) // Cari
                    {

                        $('#cari_pers_type').val(1)
                        $('#cari_text').val('Cari')
                        $('.cst_label').empty().append('Cari');
                        $('.cari_in_invoice').css('display','block');

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
                        $('.maas_ay').css('display','none');





                    }



                    let bolum_name='';
                    if(data_.item.proje_bolum_name!='null'){
                        bolum_name =data_.item.proje_bolum_name;
                    }
                    $('#proje_id_pay').val(proje_id)
                    $('#talep_id').val(id)
                    $('#proje_text').val(data_.item.proje_name)
                    $('#notes').val(data_.item.description)

                    $('#bolum_id').val(data_.item.proje_bolum_id)
                    $('#bolum_text').val(bolum_name);
                    $('#payer_id').val(data_.item.talep_eden_pers_id);
                    $('#payer_name').val(data_.item.payer);
                    $('#amount').val(parseFloat(data_.item.total));


                }

            }
        });
    })
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

        let pay_type = $('#pay_type option:selected').val();
        $("#cari_in_invoice option").remove();
        $.ajax({
            type: "POST",
            url: baseurl + 'transactions/cari_in_invoice',
            data:
                'customer_id='+ $('#payer_id').val()+
                '&pay_type='+ pay_type+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#cari_in_invoice').append($('<option>').val(0).text('İşlem Yapılacak Faturayı Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#cari_in_invoice").append('<option invoice_no="'+item.invoice_no+'" kalan="'+ item.kalan +'" value="'+ item.id +'">'+ item.invoice_no+'-'+item.type +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
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

    $(document).ready(function () {

        $('.select-box').select2();
        draw_data();
    })

    $(document).on('click', ".odeme_emri_button", function (e) {
        let id = $(this).attr('data-id');
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
                    '<div class="form-group">' +
                    '<p>Ödeme Emri Vermek Üzeresiniz!Emin misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Ödeme Tarihi</label>' +
                    '<input type="date" name="odeme_date" id="odeme_date" placeholder="Açıklama" class="name form-control" required />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Personel</label>' +
                    '<select class="form-control select-box name user_ids" name="user_id" id="user_id"><option value="0">Seçiniz</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Tutar</label>' +
                    '<input type="number" name="tutar" value="0" id="tutar"  class="name form-control" required />' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    responses.item.forEach((item_,index) => {
                        $('#user_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                    })

                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Emri Ver',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        var user_ids = this.$content.find('.user_ids').val();

                        if(!name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Ödeme Tarihi ve Personel Zorunlu',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        if(user_ids==0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Personel Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        let desc = $('#desc').val()
                        let odeme_date = $('#odeme_date').val()
                        let user_id = $('#user_id').val()
                        let tutar = $('#tutar').val()
                        jQuery.ajax({
                            url: baseurl + 'reports/odeme_emri',
                            dataType: "json",
                            method: 'post',
                            data: 'tutar='+tutar+'&odeme_date='+odeme_date+'&user_id='+user_id+'&desc='+desc+'&talep_id='+id+'&tip='+tip+'&'+crsf_token+'='+crsf_hash,
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
                                    window.setTimeout(function () {
                                        window.location.reload();
                                    }, 1000);

                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
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










    //$('#invoices').DataTable();


    $('#payer').on('change',function (){
        let payer = $(this).val();
        $('#invoices').DataTable().destroy();
        let status = $('#status').val();
        let proje_id = $('#proje_id').val();
        draw_data(payer,proje_id,status);

    })
    $('#status').on('change',function (){
        let status = $(this).val();
        $('#invoices').DataTable().destroy();
        let proje_id = $('#proje_id').val();
        let payer = $('#payer').val();
        draw_data(payer,proje_id,status);

    })
    $('#proje_id').on('change',function (){
        let proje_id = $(this).val();
        $('#invoices').DataTable().destroy();
        let payer = $('#payer').val();
        let status = $('#status').val();
        draw_data(payer,proje_id,status);

    })

    function draw_data(payer = 0,proje = 0,status = 0) {
        var actionurl = 'reports/ajax_bekleyen_odemeler';
        var datatable = $('#invoices').DataTable({
            autoWidth: false,
            pagingType: "full_numbers",
            processing: true,
            aLengthMenu: [
                [-1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            serverSide: true,
            'ajax': {
                'url': "<?php echo site_url('reports/ajax_bekleyen_odemeler')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: '',
                    end_date: '',
                    alt_firma:'',
                    status:status,
                    proje:proje,
                    payer:payer,
                }
            },
            dom: 'Blfrtip',
            buttons: [

                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 2, 3, 4,5,6,7,8]
                    }
                }
            ],
            "footerCallback": function ( row, data, start, end, display ) {


                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );


                var tatals =currencyFormat(floatVal(total));


                $( api.column( 6 ).footer() ).html(tatals);

            },
        });

        let data = {
            crsf_token: crsf_hash,
            art_date: '',
            end_date: '',
            alt_firma:'',
            status:status,
            proje:proje,
            payer:payer,
        }
        $.post(baseurl + 'reports/ajax_bekleyen_odemeler_count',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.bekleyen_odeme').empty().text(responses.totals.total_bekleyen)
            $('.nakit_bekleyen').empty().text(responses.totals.nakit_bekleyen)
            $('.bank_bekleyen').empty().text(responses.totals.bank_bekleyen)

        });
    }

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
    function htmlDecode(data) {
        let txt = document.createElement('textarea');
        txt.innerHTML = data;
        return txt.value;
    }

</script>

