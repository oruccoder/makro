<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Farktorinq Listesi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            Farktorinq Listesi
        </div>
    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="text" name="start_date" id="start_date"
                                               class="date30 form-control form-control-sm" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                               data-toggle="datepicker" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
<!--                                    <div class="col-lg-3">-->
<!--                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>-->
<!--                                    </div>-->
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>

                            <th>Muqvile No</th>
                            <th>Adı</th>
                            <th>Verilme Tarihi</th>
                            <th>Bitme Tarihi</th>
                            <th>Faiz</th>
                            <th>Esas Borç</th>
                            <th>Bugün Hesapşanmış Faiz</th>
                            <th>Tastiglenmiş Meblağ</th>
                            <th>Techizatçı / Alıcı</th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>



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
                                <input class="form-control fonksiyon" value="500" min="500" type="number" id="tutar" name="tutar" max="550000">

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
                                <input class="form-control fonksiyon" value="1" type="number" id="fatura_sayisi" name="fatura_sayisi" max="5000">
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
                                <input type="text" class="form-control  required"
                                       placeholder="Billing Date" name="verilme_tarihi" id="verilme_tarihi"
                                       data-toggle="datepicker"
                                       autocomplete="false">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="invocieno" class="caption">Bitme Tarihi</label>

                            <div class="input-group">
                                <input type="text" class="form-control  required"
                                       placeholder="Billing Date" name="bitme_tarihi" id="bitme_tarihi"
                                       data-toggle="datepicker"
                                       autocomplete="false">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Faturalar</label>

                            <div class="input-group">
                                <select class="form-contol select-box" multiple name="faturalar[]">
                                    <option value="0">Seçiniz</option>
                                    <?php foreach (alis_faturalari() as $fatura)
                                    {
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
                                        echo "<option value='$customer->id'> $customer->company </option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Muqavile No</label>

                            <div class="input-group">
                                <input class="form-control"  name="muqavile_no">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="invocieno" class="caption">Faiz</label>

                            <div class="input-group">
                                <input class="form-control"  name="faiz">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <input type="hidden" id="action-url" value="faktorinq/faktorinq_action">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="submit-data-new">Oluştur</button>
                    <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


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
                <input type="hidden" id="action-url" value="faktorinq/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<style>
    .datepicker-top-left, .datepicker-top-right
    {
        z-index: 99999 !important;
    }
</style>



<script type="text/javascript">

    $(document).on('click','#submit-data-new',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Faktorinq Oluşturma ',
            icon: 'fa fa-plus',
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
                        $.post(baseurl + 'faktorinq/faktorinq_action',$('#data_form').serialize(),(response)=>{
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
                                            action: function (){
                                                $('#invoices').DataTable().destroy();
                                                draw_data();
                                            }
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



    $(document).ready(function () {
        $('.select-box').select2({'width':'300px'});
        draw_data();


    });
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
    function draw_data(start_date = '', end_date = '') {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('faktorinq/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    tip: 37, //faktorinq
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
                    text: '<i class="fa fa-plus"></i> Yeni Faktorinq Oluştur',
                    action: function ( e, dt, node, config ) {
                        e.preventDefault();
                        $('#calculate').modal({backdrop: 'static', keyboard: false});
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5,6,7,8,9]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5,6,7,8,9]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5,6,7,8,9]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5,6,7,8,9]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5,6,7,8,9]
                    }
                },
            ]
        });
    };
</script>