<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">PERSONEL BORDRO ONAYI</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>


<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">

                <button class="btn btn-success" id="odenis">Ödeniş Onayı</button>
                <button class="btn btn-danger" id="bordro_iptal">Seçili Bordro İptali</button>

                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>

                <select id="table_projects"  multiple="multiple" class="select-box select">
                    <option disabled selected hidden value="">Proje Bazlı Raporlama</option>
                    <?php foreach (all_projects() as $items){
                        echo "<option value='$items->id'>$items->name</option>";
                    }?>
                </select>


                <div class="col-md-2" style="right: 200px;">
                    <select id="table_visable"  multiple="multiple" class="select multiselect-filtering">
                        <option selected value="2">Bordro Ayı</option>
                        <option selected value="3">Toplam Maaş</option>
                        <option selected value="4">İş Günü</option>
                        <option selected value="5">Hesaplanan</option>
                        <option selected value="6">Cəmi</option>
                        <option  value="7">DSMF (İşəgötürən)</option>
                        <option  value="8">İşsizlik(işəgötürən)</option>
                        <option  value="9">İcbari tibbi sığorta (İşəgötürən)</option>
                        <option  value="10">DSMF (İşçi)</option>
                        <option  value="11">İşsizlik (İşçi)</option>
                        <option  value="12">İcbari tibbi sığorta</option>
                        <option  value="13">Gelir Vergisi</option>
                        <option selected value="14">Ödəniləcək məbləğ</option>
                        <option selected value="15">Banka Avans</option>
                        <option selected value="16">Nakit Avans</option>
                        <option selected value="17">Bankadan Ödenilecek</option>
                        <option selected value="18">Nakit Ödenilecek</option>
                        <option value="19">Ödenişli İzin</option>
                        <option value="20">Öz Hesabına İzin</option>
                        <option selected value="21">Razı Toplam</option>
                    </select>
                </div>

                <table id="invoices"  class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                        <th>Proje</th>
                        <th>Bordro Ayı</th>
                        <th>Toplam Maaş</th>
                        <th>İş Günü</th>
                        <th>Cəmi</th>
                        <th>Hesaplanan</th>
                        <th>DSMF (İşəgötürən)</th>
                        <th>İşsizlik(işəgötürən)</th>
                        <th>İcbari tibbi sığorta (İşəgötürən) </th>
                        <th>DSMF (İşçi)</th>
                        <th>İşsizlik (İşçi)</th>
                        <th>İcbari tibbi sığorta</th>
                        <th>Gelir Vergisi</th>
                        <th>Ödəniləcək məbləğ</th>
                        <th>Banka Avans</th>
                        <th>Nakit Avans</th>
                        <th>Bankadan Ödenilecek</th>
                        <th>Nakit Ödenilecek</th>
                        <th>Ödenişli İzin</th>
                        <th>Öz Hesabına İzin</th>
                        <th>Razı Toplam</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>

                        <th>#</th>
                        <th></th>
                        <th>Bordro Ayı</th>
                        <th>Toplam Maaş</th>
                        <th>Hesaplanan</th>
                        <th></th>
                        <th></th>
                        <th>DSMF (İşəgötürən)</th>
                        <th>İşsizlik(işəgötürən)</th>
                        <th>İcbari tibbi sığorta (İşəgötürən) </th>
                        <th>DSMF (İşçi)</th>
                        <th>İşsizlik (İşçi)</th>
                        <th>İcbari tibbi sığorta</th>
                        <th>Gelir Vergisi</th>
                        <th>Ödəniləcək məbləğ</th>
                        <th>Banka Avans</th>
                        <th>Nakit Avans</th>
                        <th>Bankadan Ödenilecek</th>
                        <th>Nakit Ödenilecek</th>
                        <th>Ödenişli İzin</th>
                        <th>Öz Hesabına İzin</th>
                        <th></th>

                    </tr>
                    </tfoot>

                </table>

            </div>
        </div>
    </div>
</div>


<style>
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    .multiselect-container>li{
        width: max-content !important;
    }

    select:invalid{
        color: gray;
    }


</style>



<div id="person-container" class="d-none">
    <div class="media-list p-2" id="person-list"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.19/daterangepicker.css" integrity="sha512-DG39shQ6p6XXWvyFHLmDiSkWvNcHJlcsyrPtTSyM2SvSeK+nHxsKYWxtvrIJNSo+PwhzNNqOZoeM4IM3YN57Mw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.19/daterangepicker.js" integrity="sha512-6LIPT63EUP55i7cSGGfeKhSq/XlfrZhbR9cVVQrjCe0HtA6XSwID9DnQCCC9C8hsWMV0sJ7QC4brSUnEYBxVqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" integrity="sha512-S1l1mfpQS+XBPSgS8cCqElwRx24IcAYrwxLJg6WaFkG9J8bfNuilkoqkGny/rz7jS7Bo03qnzeBtE9LElt/fDg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js" integrity="sha512-51zCUepQrZHYlWe4Sb3sbjdjbIjYuYFRIQ0s55cUM+65qRN4PlwuFnwPdtKW5xsPXHqjn5r/mJtgxbr7fahsTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>



<script type="text/javascript">

    let table='';



    function draw_data(start_date = '',proje_id=0) {

        table = $('#invoices').DataTable({
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
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/personel_salary_report_ajax')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    proje_id: proje_id,
                }
            },
            'columnDefs': [
                {
                    'targets': [0,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21],
                    'orderable': false,
                },
                {
                    "targets": [7,8,9,10,11,12,19,20],
                    "visible": false
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
                toplam_maas = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                hesaplanan = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                cemi = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 5 );

                odenilecek_meblaq = api
                    .column( 14 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                banka_avans = api
                    .column( 15 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                nakit_avans = api
                    .column( 16 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                banka_odeme = api
                    .column( 17 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                nakit_odeme = api
                    .column( 18 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                razi_toplam = api
                    .column( 21 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );


                // Update footer

                var toplam_maas_ =currencyFormat(floatVal(toplam_maas));
                var hesaplanan_ =currencyFormat(floatVal(hesaplanan));
                var cemi_ =currencyFormat(floatVal(cemi));
                var odenilecek_meblaq_ =currencyFormat(floatVal(odenilecek_meblaq));
                var banka_avans_ =currencyFormat(floatVal(banka_avans));
                var nakit_avans_ =currencyFormat(floatVal(nakit_avans));
                var banka_odeme_ =currencyFormat(floatVal(banka_odeme));
                var nakit_odeme_ =currencyFormat(floatVal(nakit_odeme));
                var razi_toplam_ =currencyFormat(floatVal(razi_toplam));


                $( api.column( 3 ).footer() ).html(toplam_maas_);
                $( api.column( 5 ).footer() ).html(hesaplanan_);
                $( api.column( 6 ).footer() ).html(cemi_);
                $( api.column( 14 ).footer() ).html(odenilecek_meblaq_);
                $( api.column( 15 ).footer() ).html(banka_avans_);
                $( api.column( 16 ).footer() ).html(nakit_avans_);
                $( api.column( 17 ).footer() ).html(banka_odeme_);
                $( api.column( 18 ).footer() ).html(nakit_odeme_);
                $( api.column( 21 ).footer() ).html(razi_toplam_);





            },
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


    $(document).ready(function () {







        $('.select-box').select2();
        $('#table_visable').multiselect({
            enableHTML: true,
            nonSelectedText:'Göster / Gizle',
            onChange: function(element, checked) {
                let  column = table.column( element.val() );
                if(checked){

                    column.visible(true);
                }
                else {
                    column.visible(false);

                }
            }
        });

        $(document).on('change','#table_projects',function (){
            let id = $(this).val();
            let start_date = $('#hesap_ay').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date,id)
        })



        draw_data();


    });

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })

    function currencyFormat(num) {


        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }



    $(document).on('click', ".project_personel_salary", function (e) {

        let proje_id = $(this).attr('proje_id');
        let hesaplama_ayi = $(this).attr('hesaplama_ayi');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: false,
            icon:false,
            type: 'dark',
            animation: 'scale',
            columnClass: 'xlarge',
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<div class="col-md-4">' +
                    '</div><div class="card-body"><div class="table_rp">'+
                    '</div></div></div>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table id="invoices_report" class="table display nowrap" style="width:100%;font-size: 15px;font-weight: bold;">

                        <thead>
                        <tr>
                            <th>Personel</th>
                            <th style="width: 10px !important;">İş Günü</th>
                            <th>Geldiği Gün Sayısı</th>
                            <th>Brüt Maaş</th>
                            <th>Net Maaş</th>
                            <th>Hastalık</th>
                            <th>Mezuniyet Tutar</th>
                            <th>Mezuniyet Gün</th>
                            <th>Kesintiler(DSMF-SİGORTA-VERGİ)</th>
                            <th>Toplam (Avans)</th>
                            <th>Banka Avans</th>
                            <th>Nakit Avans</th>
                            <th>Aylık Kesilecek B. Tutar</th>
                            <th>Aylık Kesilecek  N. Tutar</th>
                            <th>Nakit Geri Ödeme</th>
                            <th>Prim</th>
                            <th>Ceza</th>
                            <th>Bankadan Ödenilecek</th>
                            <th>Nakit Ödenilecek</th>
                            <th>Kelbecer Farkı</th>
                            <th>Bordro Tekrar Oluşsun</th>

                        </tr>
                        </thead>


                    </table>`;
                    table_report+='<table class="table">' +
                        '<tr>' +
                        '<td>Toplam Avans</td>' +
                        '<td><span id="toplam_avans">0</span></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Toplam Banka Avans</td>' +
                        '<td><span id="banka_avans_text">0</span></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Toplam Nakit Avans</td>' +
                        '<td><span id="nakit_avans_text">0</span></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Toplam Banka Ödenecek</td>' +
                        '<td><span id="banka_odencek_text">0</span></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Toplam Nakit Ödenecek</td>' +
                        '<td><span id="nakit_odencek_text">0</span></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Toplam Nakit Geri Ödencek</td>' +
                        '<td><span id="geri_odencek_text">0</span></td>' +
                        '</tr>' +
                        '</table>';
                    $('.table_rp').empty().html(table_report);
                    draw_data_report(proje_id,hesaplama_ayi);
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

    function draw_data_report(proje_id=0,hesaplama_ayi=0) {

        let t_toplam_avans = 0;
        let t_toplam_banka_avans=0;
        let t_total_nakit_avans = 0;
        let t_banka_odenecek = 0;
        let t_nakit_odenecek = 0;
        let t_nakit_geri_odeme = 0;
        let t_razi_total = 0;
        $('#invoices_report').DataTable({
            'serverSide': true,
            'processing': true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[21]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/personel_project_ajax_salary')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id: proje_id,
                    hesaplama_ayi: hesaplama_ayi,
                }
            },
            'columnDefs': [

            ],
            dom: 'Blfrtip',
            "scrollY":        "500px",
            "scrollX":        "500px",
            "scrollCollapse": true,
            "paging":         false,
            fixedColumns:   {
                left: 1
            },
            buttons: [
                {
                    text: '<i class="fa fa-check"></i> Güncelle',
                    className: 'btn btn-primary',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Dikkat',
                            icon: 'fa fa-question',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:'<form action="" class="formName">' +
                                '<div class="form-group">' +
                                '<p>Yapılan Tüm Değişikleri Kaydetmek Üzeresiniz Emin Misiniz?<p/>' +
                                '</div>' +
                                '</form>',
                            buttons: {
                                formSubmit: {
                                    text: 'Evet',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        $('#loading-box').removeClass('d-none');
                                        let details = [];
                                        let count = $('.kesinti_maas').length;
                                        for (let i = 0; i < count; i++){
                                            details.push({
                                                'id':$('.kesinti_maas').eq(i).attr('repid'),
                                                'kesinti_banka':$('.kesinti_maas').eq(i).val(), // banka kesinti
                                                'kesinti_nakit':$('.kesinti_n_maas').eq(i).val(), // nakit kesinti
                                                'nakit_geri_odeme':$('.nakit_geri_odeme').eq(i).val(),
                                            })
                                        }

                                        let data = {
                                            crsf_token: crsf_hash,
                                            details: details,
                                        }

                                        let table_report='';
                                        $.post(baseurl + 'controller/update_salary_all',data,(response) => {
                                            let responses = jQuery.parseJSON(response);
                                            if (responses.status == "Success") {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content:responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                        }
                                                    }
                                                });
                                            } else {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
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
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,

                },

            ],
            "drawCallback": function( settings ) {

                $('.text_totals').each(function( index ) {
                    let toplam_avans = $('.text_totals').eq(index).attr('toplam_avans');
                    let toplam_banka_avans = $('.text_totals').eq(index).attr('toplam_banka_avans');
                    let total_nakit_avans = $('.text_totals').eq(index).attr('total_nakit_avans');
                    let banka_odenecek = $('.banka_hakedis').eq(index).attr('bank_odenecek');
                    let nakit_odenecek = $('.text_totals').eq(index).attr('nakit_odenecek');
                    let razi_total = $('.nakit_geri_odeme').eq(index).attr('razi_total');
                    let nakit_geri_odeme = $('.nakit_geri_odeme').eq(index).val();
                    t_razi_total+=parseFloat(razi_total);
                    t_toplam_avans+=parseFloat(toplam_avans);
                    t_toplam_banka_avans+=parseFloat(toplam_banka_avans);
                    t_total_nakit_avans+=parseFloat(total_nakit_avans);
                    t_banka_odenecek+=parseFloat(banka_odenecek);
                    t_nakit_odenecek+=parseFloat(nakit_odenecek);
                    t_nakit_geri_odeme+=parseFloat(nakit_geri_odeme);
                })

                let t_n = parseFloat(t_razi_total)+parseFloat(t_nakit_geri_odeme);

                $('#toplam_avans').empty().text(currencyFormat(t_toplam_avans/2));
                $('#banka_avans_text').empty().text(currencyFormat(t_toplam_banka_avans/2));
                $('#nakit_avans_text').empty().text(currencyFormat(t_total_nakit_avans/2));
                $('#banka_odencek_text').empty().text(currencyFormat(t_banka_odenecek/2));
                $('#nakit_odencek_text').empty().text(currencyFormat(t_nakit_odenecek/2));
                $('#geri_odencek_text').empty().text(currencyFormat(t_n/2));

            }

        });


    };

    $(document).on('click', "#odenis", function (e) {
        let checked_count = $('.one_select:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                title: 'Dikkat!',
                content: 'Herhangi Proje Seçilmemiş!',
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
                theme: 'modern',
                closeIcon: true,
                title: 'Ödeme Emri Vermek Üzeresiniz!',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let html_ ='<div class="form-group yetkili" style="display: none">' +
                        '<label>Ödeme Tip</label>' +
                        '<select id="method"  class="form-control name" ><option value="1">Nakit Maaşlar Ödensin</option><option value="2">Banka Maaşları Ödensin</option></select>' +
                        '</div><div class="form-group yetkili" style="display: none">' +
                        '<label>Ödeme Yapacak Personel</label>' +
                        '<select class="form-control select-box name" name="pers_id" id="pers_id"><option value="0">Seçiniz</option>' +
                        '</select>' +
                        '</div>';

                    let responses;

                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<label>Ödeme Tip</label>' +
                        '<select id="method"  class="form-control name" ><option value="3">Maaşlar Ödensin</option></select>' +
                        '</div>' +
                        '<div class="form-group yetkili" style="display: none">' +
                        '<label>Ödeme Yapacak Personel</label>' +
                        '<select class="form-control name" name="pers_id" id="pers_id">' +
                        '</select>' +
                        '</div>'+
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
                            $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        if(responses.yetkili==1){
                            $('.yetkili').css('display','block');
                        }
                        else {
                            $('.yetkili').css('display','none');
                        }

                    });

                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Ödeme Emri Ver',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            var name = this.$content.find('.name').val();
                            var pers_id = this.$content.find('#pers_id').val();
                            if(name==0){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: 'Tüm Alanlar Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                                return false;

                            }
                            let proje_id = [];
                            $('.one_select:checked').each((index,item) => {
                                proje_id.push({
                                    proje_id:$(item).attr('proje_id'),
                                    hesaplama_ayi:$(item).attr('hesaplama_ayi'),
                                    hesaplama_yili:$(item).attr('hesaplama_yili')
                                })
                            });


                            let data = {
                                proje_id:proje_id,
                                method:$('#method').val(),
                                pers_id:$('#pers_id').val(),
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'controller/bordro_odeme_emri',data,(response)=>{
                                let responses = jQuery.parseJSON(response);

                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: 'Başarılı Bir Şekilde Bordro Ödeme Emri Verildi.',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#invoices').DataTable().destroy();
                                    draw_data()
                                }
                                else if(responses.status=='Error'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
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
        }
    })

    $(document).on('click', "#bordro_iptal", function (e) {
        let checked_count = $('.one_select:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                title: 'Dikkat!',
                content: 'Herhangi Proje Seçilmemiş!',
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
                theme: 'modern',
                closeIcon: true,
                title: 'İptal',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'Bordro İptal Etmek Üzeresiniz Emin Misiniz?<input type="text" class="form-control" id="desc_input">',
                buttons: {
                    formSubmit: {
                        text: 'İptal Et',
                        btnClass: 'btn-green',
                        action: function () {

                            let name = $('#desc_input').val();
                            if(!name){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: 'Açıklama Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                                return false;

                            }

                            $('#loading-box').removeClass('d-none');
                            let proje_details = [];
                            $('.one_select:checked').each((index,item) => {
                                proje_details.push({
                                    proje_id:$(item).attr('proje_id'),
                                    hesaplama_ayi:$(item).attr('hesaplama_ayi'),
                                    hesaplama_yili:$(item).attr('hesaplama_yili')
                                })
                            });


                            let data = {
                                proje_details:proje_details,
                                desc:name,
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'controller/bordro_iptal',data,(response)=>{
                                let responses = jQuery.parseJSON(response);

                                if(responses.status==200){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: 'Başarılı Bir Şekilde Bordro Ödeme Emri Verildi.',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#invoices').DataTable().destroy();
                                    draw_data()
                                }
                                else if(responses.status==410){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
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
        }
    })


    $(document).on('click', ".tekrar_bordro", function (e) {
        let rep_id = $(this).attr('rep_id');
        let proje_id = $(this).attr('proje_id');
        let hesaplama_ayi = $(this).attr('hesaplama_ayi');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Tekrar Bordro İstemek Üzeresiniz!',
            icon: 'fa fa-question',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3

                let responses;

                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Açıklama *</label>' +
                    '<input type="text" placeholder="Tutarlar Doğru Değil" id="desc" class="form-control name">' +
                    '</div>' +
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

                });

                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Kaydet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var name = this.$content.find('.name').val();
                        if(name==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Açıklama Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            $('#loading-box').addClass('d-none');
                            return false;

                        }



                        let data_let = {
                            desc:$('#desc').val(),
                            rep_id:rep_id,
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'controller/tekrar_bordro',data_let,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Tekrar Bordro İstendi.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                                $('#invoices').DataTable().destroy();
                                draw_data()

                                $('#invoices_report').DataTable().destroy();
                                draw_data_report(proje_id,hesaplama_ayi);
                            }
                            else if(responses.status=='Error'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
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



    $(document).on('keyup', ".kesinti_maas", function (e) {


        let val = $(this).val();
        let eq=$(this).parent().parent().index();
        let banka_hakedis = $('.banka_hakedis').eq(eq).attr('banka_hakedis')
        let pers_name = $(this).attr('pers_name')
        let repid = $(this).attr('repid')


        let kalan = parseFloat(banka_hakedis)-parseFloat(val);


        $('.banka_hakedis').eq(eq).empty().text(currencyFormat(kalan))
        $('.text_totals').eq(eq).attr('toplam_banka_avans',kalan)
        $('.banka_hakedis').eq(eq).attr('b_hak',kalan),


            hesap()



        let cur_val = currencyFormat(parseFloat(val));

        if (e.which == 13) {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-question',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>'+pers_name+' Adlı Personelinizden '+cur_val+' Kesilecektir. Ödenecek Banka Toplamı : '+currencyFormat(kalan)+'Eminmisimiz? <p/>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let desc = $('#desc').val()
                            jQuery.ajax({
                                url: baseurl + 'controller/update_salary_report',
                                dataType: "json",
                                method: 'post',
                                data: 'kalan=' + kalan + '&val=' + val + '&repid=' + repid + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $(this).html('Bekleyiniz');
                                    $(this).prop('disabled', true); // disable button

                                },
                                success: function (data) {
                                    if (data.status == "Success") {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-check',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Başarılı',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                }
                                            }
                                        });
                                    } else {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Dikkat',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
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



    });


    $(document).on('keyup', ".kesinti_n_maas", function (e) {


        let val = $(this).val();
        let eq=$(this).parent().parent().index();
        let nakit_hakedis =parseFloat( $('.nakit_hakedis').eq(eq).attr('nakit_hakedis'));
        let pers_name = $(this).attr('pers_name')
        let repid = $(this).attr('repid')
        let kalan = 0;
        if(nakit_hakedis > 0 ){
            if(val > nakit_hakedis){
                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: 'Dikkat',
                    icon: 'fa fa-question',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content:'Nakit Alacağı Girdiğiniz Tutar Kadar Değildir.Nakit Alacağı : '+currencyFormat(nakit_hakedis)+' En Fazla Kesebileceğiniz Tutar : ' + currencyFormat(nakit_hakedis),
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    },
                    buttons: {
                        formSubmit: {
                            text: 'Tamam',
                            btnClass: 'btn-blue',
                        }
                    }
                });
                $(this).val(nakit_hakedis);
                kalan = parseFloat(val)-parseFloat(nakit_hakedis);


                $('.nakit_geri_odeme').eq(eq).val(kalan)
                $('.nakit_hakedis').eq(eq).empty().text(currencyFormat(parseFloat(nakit_hakedis)-parseFloat(nakit_hakedis)))
            }
            else {
                kalan = parseFloat(nakit_hakedis)-parseFloat(val);
                $('.nakit_hakedis').eq(eq).empty().text(currencyFormat(kalan))
            }


        }
        else {
            $('.nakit_geri_odeme').eq(eq).val(parseFloat(val))
        }

        // $('.text_totals').eq(eq).attr('total_nakit_avans',kalan)


        //$('.nakit_hakedis').eq(eq).attr('nakit_hakedis',kalan),

        hesap()




        let cur_val = currencyFormat(parseFloat(val));

        if (e.which == 13) {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-question',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>'+pers_name+' Adlı Personelinizden '+cur_val+' Kesilecektir. Ödenecek Nakit Toplamı : '+currencyFormat(kalan)+'Eminmisimiz? <p/>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let desc = $('#desc').val()
                            jQuery.ajax({
                                url: baseurl + 'controller/update_salary_report_nakit_maas',
                                dataType: "json",
                                method: 'post',
                                data: 'kalan=' + kalan + '&val=' + val + '&repid=' + repid + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $(this).html('Bekleyiniz');
                                    $(this).prop('disabled', true); // disable button

                                },
                                success: function (data) {
                                    if (data.status == "Success") {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-check',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Başarılı',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                }
                                            }
                                        });
                                    } else {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Dikkat',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
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



    });


    $(document).on('keyup', ".nakit_geri_odeme", function (e) {


        let val = $(this).val();
        let eq=$(this).parent().parent().index();
        let banka_hakedis = $('.banka_hakedis').eq(eq).attr('banka_hakedis')
        let pers_name = $(this).attr('pers_name')
        let repid = $(this).attr('repid')
        let proje_id = $(this).attr('proje_id')
        let hesaplama_ayi = $(this).attr('hesaplama_ayi')
        let kalan = parseFloat(banka_hakedis)-parseFloat(val);
        let cur_val = currencyFormat(parseFloat(val));




        if (e.which == 13) {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-question',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>'+pers_name+' Adlı Personelinizden '+cur_val+' Nakit Olarak  Geri Alınacaktır. Eminmisimiz? <p/>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let desc = $('#desc').val()
                            jQuery.ajax({
                                url: baseurl + 'controller/update_salary_report_nakit',
                                dataType: "json",
                                method: 'post',
                                data: 'val=' + val + '&repid=' + repid + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $(this).html('Bekleyiniz');
                                    $(this).prop('disabled', true); // disable button

                                },
                                success: function (data) {
                                    if (data.status == "Success") {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-check',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Başarılı',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        $('#invoices_report').DataTable().destroy();
                                                        draw_data_report(proje_id,hesaplama_ayi);
                                                    }

                                                }
                                            }
                                        });
                                    } else {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Dikkat',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
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

        hesap()

    });

    function currencyFormat(num) {

        var deger = num.toFixed(2).replace('.', ',');
        return deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' AZN';
    }



    function hesap(){

        let t_toplam_avans = 0;
        let t_razi_total = 0;
        let t_toplam_banka_avans=0;
        let t_total_nakit_avans = 0;
        let t_banka_odenecek = 0;
        let t_nakit_odenecek = 0;
        let t_nakit_geri_odeme = 0;
        $('.text_totals').each(function( index ) {
            let toplam_avans = $('.text_totals').eq(index).attr('toplam_avans');
            let toplam_banka_avans = $('.text_totals').eq(index).attr('toplam_banka_avans');
            let total_nakit_avans = $('.text_totals').eq(index).attr('total_nakit_avans');
            let banka_odenecek = $('.banka_hakedis').eq(index).attr('b_hak');
            let nakit_odenecek = $('.text_totals').eq(index).attr('nakit_odenecek');
            let razi_total = $('.nakit_geri_odeme').eq(index).attr('razi_total');
            let nakit_geri_odeme = $('.nakit_geri_odeme').eq(index).val();
            t_razi_total+=parseFloat(razi_total);
            t_toplam_avans+=parseFloat(toplam_avans);
            t_toplam_banka_avans+=parseFloat(toplam_banka_avans);
            t_total_nakit_avans+=parseFloat(total_nakit_avans);
            t_banka_odenecek+=parseFloat(banka_odenecek);
            t_nakit_odenecek+=parseFloat(nakit_odenecek);
            t_nakit_geri_odeme+=parseFloat(nakit_geri_odeme);
        })
        let t_n = parseFloat(t_razi_total)+parseFloat(t_nakit_geri_odeme);
        $('#toplam_avans').empty().text(currencyFormat(t_toplam_avans));
        $('#banka_avans_text').empty().text(currencyFormat(t_toplam_banka_avans));
        $('#nakit_avans_text').empty().text(currencyFormat(t_total_nakit_avans));
        $('#banka_odencek_text').empty().text(currencyFormat(t_banka_odenecek));
        $('#nakit_odencek_text').empty().text(currencyFormat(t_nakit_odenecek));
        $('#geri_odencek_text').empty().text(currencyFormat(t_n));
    }


</script>

<style>
    @media (min-width: 1200px)
    {
        .container {
            max-width: 2334px !important;
        }
    }


</style>
