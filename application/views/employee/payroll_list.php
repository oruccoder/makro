<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Bordrolar </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card border border-dark">
            <div class="card-body">
                <div class="row">
                     <div class="col-md-1">
                        <select class="form-control" id="hesap_yil" style="background: #576c93;color: white;border: #5f7399;">
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>


                    <div class="col-md-2">
                        <select class="form-control" id="hesap_ay" style="background: #576c93;color: white;border: #5f7399;">
                            <option value="">Hesaplama Ayı Seçiniz</option>
                            <option value="01">Ocak</option>
                            <option value="02">Şubat</option>
                            <option value="03">Mart</option>
                            <option value="04">Nisan</option>
                            <option value="05">Mayıs</option>
                            <option value="06">Haziran</option>
                            <option value="07">Temmuz</option>
                            <option value="08">Ağustos</option>
                            <option value="09">Eylül</option>
                            <option value="10">Ekim</option>
                            <option value="11">Kasım</option>
                            <option value="12">Aralık</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <select id="table_projects"  multiple="multiple" class="select-box select">
                            <option disabled selected hidden value="">Proje Bazlı Raporlama</option>
                            <option value="35">OFİS</option>
                            <option value="3">GENCE HERBI POLIS</option>
                            <option value="75">KELBECER - LAÇIN</option>
                            <option value="6">SUMGAYT HERBİ POLİS</option>
                            <option value="9">LENKEREN</option>
                            <option value="11">TURİZM</option>
                            <option value="47">Depo</option>
                            <option value="43">Zaqatala</option>
                            <option value="107">Lisensiya</option>
                            <option value="48">Lokman Bey Ev</option>
                            <option value="126">M.N.I,Ş.Q.BINASI</option>
                            <option value="118">100-1</option>
                            <option value="72">AĞDAM HƏRBİ HİSSƏ</option>
                        </select>
                    </div>

                    <div class="col-md-4" style="display: flex;justify-content: flex-end;">
                        <button class="btn btn-info" id="islemler">İşlemler</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card table-responsive border border-dark">
            <table id="invoices" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>Personel</th>
                    <th>Proje</th>
                    <th>İş Günü</th>
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
                    <th>Bankadan Hakediş</th>
                    <th>Nakit Ödenilecek</th>
                    <th>Nakit Hakediş</th>
                    <th>Razı Toplam</th>
                    <th>Banka Ödeme Durumu</th>
                    <th>Nakit Ödeme Durumu</th>
                    <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>

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
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
                </tfoot>

            </table>
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
    .select2 {
        width: max-content !important; ;
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
    let salary_details = [];

    $(document).on('click', ".pop_model_desc", function (e) {
        e.preventDefault();
        var cont_id=$(this).attr('cont_id')

        $('#pop_model_desc').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'controller/desc';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+cont_id,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#aciklama').html(data);

            }

        });

    });

    let table='';



    function draw_data(start_date = '',proje_id=0,maas_type_id=0,hesap_yil='') {

        table = $('#invoices').DataTable({
            'serverSide': true,
            'processing': true,
            fixedHeader: true,
            paging: true,
            scrollY: 700,
            scrollX: true,
            scroller: true,

            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                [10 , "Tümü", 50, 100, 200]
            ],
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/personel_takip_ajax_')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    proje_id: proje_id,
                    maas_type_id: maas_type_id,
                    hesap_yil: hesap_yil,
                }
            },
            'columnDefs': [

            ],
  
            "scrollCollapse": true,
            "paging":         true,

            'columnDefs': [
                {
                    'targets': [25],
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
                brut_maas = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                net_maas = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                hastalik = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                mezuniyet_tutar= api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                kesintiler = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                toplam_avans = api
                    .column( 10 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                banka_avans = api
                    .column( 11 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                nakit_avans = api
                    .column( 12 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                kesinti_banka = api
                    .column( 13 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                kesinti_nakit = api
                    .column( 14 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                nakit_geri_odeme = api
                    .column( 15 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                    bankadan_odenilecek = api
                        .column( 18 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );
                    banka_hakedis = api
                        .column( 19 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );
                    nakit_odenilecek = api
                        .column( 20 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );
                    nakit_hakedis = api
                        .column( 21 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );
                    razi_total = api
                        .column( 22 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );


                // Update footer

                var brut_maas_ =currencyFormat(floatVal(brut_maas));
                var net_maas_ =currencyFormat(floatVal(net_maas));
                var hastalik_ =currencyFormat(floatVal(hastalik));
                var mezuniyet_tutar_ =currencyFormat(floatVal(mezuniyet_tutar));
                var kesintiler_ =currencyFormat(floatVal(kesintiler));
                var toplam_avans_ =currencyFormat(floatVal(toplam_avans));
                var banka_avans_ =currencyFormat(floatVal(banka_avans));
                var nakit_avans_ =currencyFormat(floatVal(nakit_avans));
                var kesinti_banka_ =currencyFormat(floatVal(kesinti_banka));
                var kesinti_nakit_ =currencyFormat(floatVal(kesinti_nakit));
                var nakit_geri_odeme_ =currencyFormat(floatVal(nakit_geri_odeme));
                var bankadan_odenilecek_ =currencyFormat(floatVal(bankadan_odenilecek));
                var banka_hakedis_ =currencyFormat(floatVal(banka_hakedis));
                var nakit_odenilecek_ =currencyFormat(floatVal(nakit_odenilecek));
                var nakit_hakedis_ =currencyFormat(floatVal(nakit_hakedis));
                var razi_totals_ =currencyFormat(floatVal(razi_total));


                $( api.column( 4 ).footer() ).html(brut_maas_);
                $( api.column( 5 ).footer() ).html(net_maas_);
                $( api.column( 6 ).footer() ).html(hastalik_);
                $( api.column( 7 ).footer() ).html(mezuniyet_tutar_);
                $( api.column( 9 ).footer() ).html(kesintiler_);
                $( api.column( 10 ).footer() ).html(toplam_avans_);
                $( api.column( 11 ).footer() ).html(banka_avans_);
                $( api.column( 12).footer() ).html(nakit_avans_);
                $( api.column( 13 ).footer() ).html(kesinti_banka_);
                $( api.column( 14 ).footer() ).html(kesinti_nakit_);
                $( api.column( 15 ).footer() ).html(nakit_geri_odeme_);
                $( api.column( 18 ).footer() ).html(bankadan_odenilecek_);
                $( api.column( 19 ).footer() ).html(banka_hakedis_);
                $( api.column( 20 ).footer() ).html(nakit_odenilecek_);
                $( api.column( 21 ).footer() ).html(nakit_hakedis_);
                $( api.column( 22 ).footer() ).html(razi_totals_);





            },


        });

        new $.fn.dataTable.FixedHeader( table );

        $('#invoices').on('shown.bs.collapse', function () {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
        setTimeout(function () {
            $('#invoices').DataTable().destroy();
        },5000)

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
            let maas_type_id = $('#maas_type_filter').val();
            let start_date = $('#hesap_ay').val();
            let hesap_yil = $('#hesap_yil').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date,id,maas_type_id,hesap_yil)

        })
        $(document).on('change','#maas_type_filter',function (){
            let maas_type_id = $(this).val();
            let start_date = $('#hesap_ay').val();
            let hesap_yil = $('#hesap_yil').val();
            let id = $('#table_projects').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date,id,maas_type_id,hesap_yil)

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



    $(document).on('change','#hesap_ay',function (e){
        let id=  $(this).val();
        let proje_id = $('#table_projects').val();
        let hesap_yil = $('#hesap_yil').val();
        let maas_type_id = $('#maas_type_filter').val();
        $('#invoices').DataTable().destroy();
        draw_data(id,proje_id,maas_type_id,hesap_yil);
    })

    $(document).on('click', "#islemler", function (e) {


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
                content: 'Herhangi Bir Personel Seçilmemiş!',
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
                columnClass: "Small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;

                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<label>Lütfen İşlem Seçiniz</label>'+
                        '<select class="form-control" id="islem_sec"><option value="">Seçiniz</option><option value="1">Nakit Ödenecekleri Kasaya İşle</option><option value="2">Razıları Kasaya İşle</option><option value="4">Düzenle</option></select>'+
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

                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'İşleme Devam',
                        btnClass: 'btn-blue',
                        action: function () {
                            let rep_id = [];
                            $('.one_select:checked').each((index,item) => {
                                rep_id.push($(item).attr('rep_id'))
                            });
                            let islem_sec = $('#islem_sec').val();
                            if(islem_sec==1)//nakit kasa işleme
                            {
                                $.confirm({
                                    theme: 'material',
                                    closeIcon: true,
                                    title: 'Dikkat',
                                    icon: 'fa fa-exclamation',
                                    type: 'dark',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "Small",
                                    containerFluid: !0,
                                    smoothContent: true,
                                    draggable: false,
                                    content: function () {
                                        let self = this;
                                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                        let responses;

                                        html+='<form action="" class="formName">' +
                                                '<div class="form-group">' +
                                                    '<label>Kasa</label>' +
                                                    '<select class="form-control name" name="acid" id="acid"><option value="0">Seçiniz</option>' +
                                                    '</select>' +
                                                '</div>' +
                                                '<div class="form-group">' +
                                                '<label>Toplam Tutar : <span id="total_tutar"></span></label>' +
                                                '<div class="tables"></div>'+
                                                '</div>' +
                                            '</form>';


                                        let data = {
                                            crsf_token: crsf_hash,
                                            rep_id: rep_id,
                                        }
                                        let table_report ='';
                                        $.post(baseurl + 'controller/ajax_account_bordro_nakit',data,(response) => {
                                            self.$content.find('#person-list').empty().append(html);
                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm-box-container")
                                            });
                                            let responses = jQuery.parseJSON(response);
                                            responses.item.forEach((item_,index) => {
                                                $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                                            })


                                            table_report =`<table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Personel</th>
                                                                    <th>Nakit Geri Alınacak Tutar</th>
                                                                </tr>
                                                            </thead>
                                                           <tbody>`;
                                            responses.nakit.forEach((item_,index) => {
                                                table_report +=`<tr>
                                                                    <td>`+item_.name+`</td>
                                                                    <td>`+item_.tutar+`</td>
                                                                </tr>`;
                                            })

                                            table_report +=`</tbody></table>`;
                                            $('.tables').empty().html(table_report);
                                            $('#total_tutar').empty().text(responses.toplam_tutar);

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
                                                $('#loading-box').removeClass('d-none');

                                                let data = {
                                                    crsf_token: crsf_hash,
                                                    rep_id: rep_id,
                                                    account_id: $('#acid').val(),
                                                }
                                                let table_report ='';
                                                $.post(baseurl + 'controller/create_nakit_kasa',data,(response) => {
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
                                            text: 'Geri',
                                            btnClass: "btn btn-danger btn-sm",
                                            action:function (){
                                                $('#islemler').click();
                                            }

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
                            else if(islem_sec==2) //Razıların kasaya işlenmesi
                            {
                                $.confirm({
                                    theme: 'material',
                                    closeIcon: true,
                                    title: 'Dikkat',
                                    icon: 'fa fa-exclamation',
                                    type: 'dark',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "Small",
                                    containerFluid: !0,
                                    smoothContent: true,
                                    draggable: false,
                                    content: function () {
                                        let self = this;
                                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                        let responses;

                                        html+='<form action="" class="formName">' +
                                            '<div class="form-group">' +
                                            '<label>Kasa</label>' +
                                            '<select class="form-control name" name="acid" id="acid"><option value="0">Seçiniz</option>' +
                                            '</select>' +
                                            '</div>' +
                                            '<div class="form-group">' +
                                            '<label>Toplam Tutar : <span id="total_tutar"></span></label>' +
                                            '<div class="tables"></div>'+
                                            '</div>' +
                                            '</form>';


                                        let data = {
                                            crsf_token: crsf_hash,
                                            rep_id: rep_id,
                                        }
                                        let table_report ='';
                                        $.post(baseurl + 'controller/ajax_account_bordro_razi',data,(response) => {
                                            self.$content.find('#person-list').empty().append(html);
                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm-box-container")
                                            });
                                            let responses = jQuery.parseJSON(response);
                                            responses.item.forEach((item_,index) => {
                                                $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                                            })


                                            table_report =`<table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Personel</th>
                                                                    <th>Yatırılacak Tutar</th>
                                                                    <th>Nakit Çekilecek Tutar</th>
                                                                </tr>
                                                            </thead>
                                                           <tbody>`;
                                            responses.nakit.forEach((item_,index) => {
                                                table_report +=`<tr>
                                                                    <td>`+item_.name+`</td>
                                                                    <td>`+item_.tutar+`</td>
                                                                    <td><input rep_id='`+item_.rep_id+`' class="form-control cekilecek_tutar" value="0" type="number"></td>
                                                                </tr>`;
                                            })

                                            table_report +=`</tbody></table>`;
                                            $('.tables').empty().html(table_report);
                                            $('#total_tutar').empty().text(responses.toplam_tutar);

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
                                                let details = [];
                                                  if($('#hesap_ay').val()==''){
                                                      $.alert({
                                                          theme: 'material',
                                                          icon: 'fa fa-exclamation',
                                                          type: 'red',
                                                          animation: 'scale',
                                                          useBootstrap: true,
                                                          columnClass: "col-md-4 mx-auto",
                                                          title: 'Dikkat!',
                                                          content: 'Hesaplama Ayı Seçiniz',
                                                          buttons:{
                                                              prev: {
                                                                  text: 'Tamam',
                                                                  btnClass: "btn btn-link text-dark",
                                                              }
                                                          }
                                                      });
                                                      return false;
                                                  }
                                                  if($('#acid').val()==''){
                                                      $.alert({
                                                          theme: 'material',
                                                          icon: 'fa fa-exclamation',
                                                          type: 'red',
                                                          animation: 'scale',
                                                          useBootstrap: true,
                                                          columnClass: "col-md-4 mx-auto",
                                                          title: 'Dikkat!',
                                                          content: 'Kasa Seçiniz',
                                                          buttons:{
                                                              prev: {
                                                                  text: 'Tamam',
                                                                  btnClass: "btn btn-link text-dark",
                                                              }
                                                          }
                                                      });
                                                      return false;
                                                  }
                                                $('.cekilecek_tutar').each((index,item) => {
                                                    if($('.cekilecek_tutar').eq(index).val()==0){
                                                        $.alert({
                                                            theme: 'material',
                                                            icon: 'fa fa-exclamation',
                                                            type: 'red',
                                                            animation: 'scale',
                                                            useBootstrap: true,
                                                            columnClass: "col-md-4 mx-auto",
                                                            title: 'Dikkat!',
                                                            content: 'Nakit Çekilecek Tutar 0 Olamaz',
                                                            buttons:{
                                                                prev: {
                                                                    text: 'Tamam',
                                                                    btnClass: "btn btn-link text-dark",
                                                                    action: function () {
                                                                        $('#islemler').click()

                                                                    }
                                                                }
                                                            }
                                                        });

                                                        return false;
                                                    }
                                                    else {
                                                        details.push({
                                                            'rep_id':$('.cekilecek_tutar').eq(index).attr('rep_id'),
                                                            'value':$('.cekilecek_tutar').eq(index).val()
                                                        })

                                                    }
                                                });

                                                let data = {
                                                    hesap_ay: $('#hesap_ay').val(),
                                                    hesap_yil: $('#hesap_yil').val(),
                                                    crsf_token: crsf_hash,
                                                    details: details,
                                                    account_id: $('#acid').val(),
                                                }
                                                $.post(baseurl + 'controller/create_razi_kasa',data,(response) => {
                                                    $('#loading-box').removeClass('d-none');
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
                                                                prev: {
                                                                    text: 'Tamam',
                                                                    btnClass: "btn btn-link text-dark",
                                                                }
                                                            }
                                                        });
                                                        return false;
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
                                                    return false;

                                                });
                                            }
                                        },
                                        cancel:{
                                            text: 'Geri',
                                            btnClass: "btn btn-danger btn-sm",
                                            action: function () {
                                                $('#islemler').click()

                                            }

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
                            else if(islem_sec==4) //Düzenle
                            {
                                $.confirm({
                                    theme: 'material',
                                    closeIcon: true,
                                    title: 'Dikkat',
                                    icon: 'fa fa-exclamation',
                                    type: 'dark',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "large",
                                    containerFluid: !0,
                                    smoothContent: true,
                                    draggable: false,
                                    content: function () {
                                        let self = this;
                                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                        let responses;

                                        html+='<form action="" class="formName">' +
                                            '<div class="form-group">' +
                                            '<div class="tables"></div>'+
                                            '</div>' +
                                            '</form>';


                                        let data = {
                                            crsf_token: crsf_hash,
                                            rep_id: rep_id,
                                        }
                                        let table_report ='';
                                        $.post(baseurl + 'controller/ajax_account_bordro_edit',data,(response) => {
                                            self.$content.find('#person-list').empty().append(html);
                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm-box-container")
                                            });
                                            let responses = jQuery.parseJSON(response);
                                            responses.item.forEach((item_,index) => {
                                                $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                                            })


                                            table_report =`<table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Personel</th>
                                                                    <th>Toplam Avans</th>
                                                                    <th>Banka Avans</th>
                                                                    <th>Nakit Avans</th>
                                                                    <th>Kesilecek Banka T.</th>
                                                                    <th>Kesilecek Nakit T.</th>
                                                                    <th>Nakit Geri Ö.</th>
                                                                    <th>Bankadan Ödenilecek</th>
                                                                    <th>Bankadan Hakediş</th>
                                                                    <th>Nakit Ödenilecek</th>
                                                                    <th>Nakit Hakediş</th>
                                                                </tr>
                                                            </thead>
                                                           <tbody>`;
                                            responses.nakit.forEach((item_,index) => {
                                                table_report +=`<tr>
                                                                    <td>`+item_.name+`</td>
                                                                    <td><input class="form-control toplam_avans" value="`+item_.toplam_avans+`" type="number"></td>
                                                                    <td><input class="form-control banka_avans" value="`+item_.banka_avans+`" type="number"></td>
                                                                    <td><input class="form-control nakit_avans" value="`+item_.nakit_avans+`" type="number"></td>
                                                                    <td><input class="form-control aylik_kesinti" value="`+item_.aylik_kesinti+`" type="number"></td>
                                                                    <td><input class="form-control aylik_kesinti_nakit" value="`+item_.aylik_kesinti_nakit+`" type="number"></td>
                                                                    <td><input class="form-control nakit_geri_odenen" value="`+item_.nakit_geri_odenen+`" type="number"></td>
                                                                    <td><input class="form-control odenilecek_meblaq" value="`+item_.odenilecek_meblaq+`" type="number"></td>
                                                                    <td><input class="form-control banka_hakedis" value="`+item_.banka_hakedis+`" type="number"></td>
                                                                    <td><input class="form-control nakit_odenilecek" value="`+item_.nakit_odenilecek+`" type="number"></td>
                                                                    <td><input class="form-control nakit_hakedis" rep_id="`+item_.rep_id+`" value="`+item_.nakit_hakedis+`" type="number"></td>
                                                                </tr>`;
                                            })

                                            table_report +=`</tbody></table>`;
                                            $('.tables').empty().html(table_report);

                                        });
                                        self.$content.find('#person-list').empty().append(html);
                                        return $('#person-container').html();
                                    },
                                    onContentReady:function (){
                                    },
                                    buttons: {
                                        formSubmit: {
                                            text: 'Güncelle',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#loading-box').removeClass('d-none');
                                                $('.nakit_hakedis').each((index,item) => {
                                                    salary_details.push({
                                                        rep_id : $(item).attr('rep_id'),
                                                        nakit_hakedis : $(item).val(),
                                                        nakit_odenilecek : $('.nakit_odenilecek').eq(index).val(),
                                                        banka_hakedis : $('.banka_hakedis').eq(index).val(),
                                                        odenilecek_meblaq : $('.odenilecek_meblaq').eq(index).val(),
                                                        nakit_geri_odenen : $('.nakit_geri_odenen').eq(index).val(),
                                                        aylik_kesinti_nakit : $('.aylik_kesinti_nakit').eq(index).val(),
                                                        aylik_kesinti : $('.aylik_kesinti').eq(index).val(),
                                                        nakit_avans : $('.nakit_avans').eq(index).val(),
                                                        banka_avans : $('.banka_avans').eq(index).val(),
                                                        toplam_avans : $('.toplam_avans').eq(index).val(),
                                                    })
                                                });

                                                let data_confirm = {
                                                    crsf_token: crsf_hash,
                                                    details:salary_details
                                                }
                                                $.post(baseurl + 'controller/salary_edit_confirm',data_confirm,(response) => {

                                                    let responses = jQuery.parseJSON(response);
                                                    if(responses.status=='Success'){

                                                        $('#loading-box').addClass('d-none');

                                                        confirm_smsm(responses.confirm_id)
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
                                                        return false;
                                                    }

                                                });

                                            }

                                        },
                                        cancel:{
                                            text: 'Geri',
                                            btnClass: "btn btn-danger btn-sm",
                                            action: function () {
                                                $('#islemler').click()

                                            }

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
                                    content: 'Herhangi Bir İşlem Türü Seçmediniz',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

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


    function confirm_smsm(confirm_id){
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<input type="number" class="form-control" id="code" placeholder="Doğrulama Kodunu Giriniz">`,
            buttons: {
                formSubmit: {
                    text: 'Doğrula',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            code:$('#code').val(),
                            details:salary_details,
                            last_id:confirm_id,
                        }
                        $.post(baseurl + 'controller/salary_edit_report',data,(response) => {
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
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

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
                                            action: function () {
                                                confirm_smsm(confirm_id);
                                            }
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
    }


</script>
