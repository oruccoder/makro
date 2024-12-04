<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">BEKLEYEN FORMA2 LISTESI</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">

                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th>Forma 2 Tipi</th>
                        <th>Muqavile No</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th>Proje</th>
                        <th>Genel Müdür Emri</th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


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
        $('#talep_id').val($(this).attr('data-id'));
        let id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: baseurl + 'reports/invoices_details',
            data: 'talep_id='+ id+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                var data_ = jQuery.parseJSON(data);
                if(data_.status=='Success'){
                    let cari_pers_type = data_.item.cari_pers;
                    let proje_id = data_.item.proje_id;
                    let proje_text = data_.item.proje_name;


                    $('#cari_pers_type').val(1)
                    $('#cari_text').val('Cari')
                    $('.cst_label').empty().append('Cari');
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



                    let bolum_name='';
                    if(data_.item.proje_bolum_name!='null'){
                        bolum_name =data_.item.proje_bolum_name;
                    }
                    $('#proje_id_pay').val(proje_id)

                    $('#proje_text').val(data_.item.proje_name)
                    $('#notes').val(data_.item.description)
                    $('#cari_in_invoice').val(id)

                    $('#bolum_id').val(data_.item.proje_bolum_id)
                    $('#bolum_text').val(bolum_name);
                    $('#payer_id').val(data_.item.csd);
                    $('#payer_name').val(data_.item.payer);
                    $('#amount').val(parseFloat(data_.item.total));


                }

            }
        });
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
                    'url': "<?php echo site_url('invoices/form2_ajax_list_muhasebe')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        status: 19,
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
</script>

<footer style="margin-top: 450px">

</footer>