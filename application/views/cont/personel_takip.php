<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Personel İş Takip Ekranı</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>


<div class="content">
    <div class="content-body">
        <div class="card border border-dark">
            <div class="card-body">
                <div class="card-content">
                    <div id="notify" class="alert alert-success" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"></div>
                    </div>



                    <div class="card-body">
                        <div class="row">
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
                            <div class="col-md-1">
                                <select class="form-control" id="hesap_yil" style="background: #576c93;color: white;border: #5f7399;">
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>

                                </select>
                            </div>


                            <div class="col-md-5" style="display: flex;justify-content: flex-start;width: 300px">
                                <select id="table_projects"  multiple="multiple" class="select-box select2_">
                                    <option disabled selected hidden value="">Proje Bazlı Raporlama</option>
                                    <?php foreach (all_projects() as $items){
                                        echo "<option value='$items->id'>$items->name</option>";
                                    }?>
                                </select>
                            </div>


                            <div class="col-md-2" style="display: flex;justify-content: flex-start;width: 300px">
                                <select id="maas_type_filter"  multiple="multiple" class="select-box select">
                                    <option disabled selected hidden value="">Maaş Tipi</option>
                                    <?php foreach (salary_type() as $items){
                                        echo "<option value='$items->id'>$items->name</option>";
                                    }?>
                                </select>
                            </div>

                            <div class="col-md-1" style="display: flex;justify-content: flex-end;">
                                <button class="btn btn-info" id="hakedis">Personel Bordro Hesapla</button>&nbsp;

                            </div>


                            <div class="col-md-1" style="display: flex;justify-content: flex-end;">
                                <select id="table_visable"  multiple="multiple" class="select multiselect-filtering">
                                    <option selected value="3">Toplam Maaş</option>
                                    <option selected value="4">İş Günü</option>
                                    <option selected value="5">Geldiği Gün Sayısı</option>
                                    <option selected value="6">Hesaplanan</option>
                                    <option selected value="7">M./ S.H.H(gün)</option>
                                    <option selected value="8">M./ S.H.H (məbləğ) </option>
                                    <option selected value="9">Xəstəlik (məbləğ)</option>
                                    <option selected value="10">Cəmi</option>
                                    <option selected value="11">DSMF (İG)</option>
                                    <option selected value="12">İşsizlik(İG)</option>
                                    <option selected value="13">İ.T.S (İG)</option>
                                    <option selected value="14">DSMF (İşçi)</option>
                                    <option selected value="15">İşsizlik (İşçi)</option>
                                    <option selected value="16">İ.T.S</option>
                                    <option selected value="17">Gelir Vergisi</option>
                                    <option selected value="18">B. Hakedişi</option>
                                    <option selected value="19">B. Avans</option>
                                    <option selected value="21">B. Ödenilecek</option>
                                    <option selected value="22">Prim</option>
                                    <option selected value="23">Ceza</option>
                                    <option selected value="24">N. Ödenilecek</option>
                                    <option selected value="25">Ödenişli İzin</option>
                                    <option selected value="26">Öz Hesabına İzin</option>
                                    <option selected value="27">Razı Toplam</option>
                                    <option selected value="28">N. Borç</option>
                                    <option selected value="29">B. Borç</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <button class="btn btn-success" type="button" id="ise_gelis_ekle">Personel İş Bildirimi</button>
            </div>
        </div>
        <div class="card table-responsive border border-dark">
            <table id="invoices"  class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                <tr>

                    <th>Personel</th>
                    <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                    <th>Proje</th>
                    <th>Toplam Maaş</th>
                    <th>İş Günü</th>
                    <th>Geldiği Gün Sayı</th>
                    <th>Hesaplanan</th>
                    <th>M./ S.H.H(gün)</th>
                    <th>M./ S.H.H(məbləğ)</th>
                    <th>Xəstəlik (məbləğ)</th>
                    <th>Cəmi</th>
                    <th>DSMF (İG)</th>
                    <th>İşsizlik(İG)</th>
                    <th>İ.T.S (İG) </th>
                    <th>DSMF (İşçi)</th>
                    <th>İşsizlik (İşçi)</th>
                    <th>İ.T.S</th>
                    <th>Gelir Vergisi</th>
                    <th>Ödəniləcək məbləğ</th>
                    <th>B. Avans</th>
                    <th>N. Avans</th>
                    <th>B. Tahmini Ödenilecek</th>
                    <th>Prim</th>
                    <th>Ceza</th>
                    <th>N. Ödenilecek</th>
                    <th>Ödenişli İzin</th>
                    <th>Öz Hesabına İzin</th>
                    <th>Razı Toplam</th>
                    <th>N. Borç</th>
                    <th>B. Borç</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Personel</th>
                    <th>#</th>
                    <th>Proje</th>
                    <th></th>
                    <th>İş Günü</th>
                    <th>Geldiği Gün Sayısı</th>
                    <th></th>
                    <th>Məzuniyyət və ya son haqq-hesab(gün)</th>
                    <th>Məzuniyyət və ya son haqq-hesab (məbləğ)</th>
                    <th>Xəstəlik (məbləğ)</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Gelir Vergisi</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Ödenişli İzin</th>
                    <th>Öz Hesabına İzin</th>
                    <th></th>
                    <th>Nakit Borç</th>
                    <th>Banka Borç</th>

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
    .select2_ {
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
             "scrollX": true,
             fixedHeader: true,
             paging: true,
             scrollY: 700,
             scrollX: true,
             scroller: true,


             'createdRow': function (row, data, dataIndex) {
                 $(row).attr('style',data[30]);
             },
             aLengthMenu: [
                 [ 10,-1,50, 100, 200],
                 [10,"Tümü", 50, 100, 200]
             ],
            "order": [[ 0, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/personel_takip_ajax')?>",
                'type': 'POST',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    proje_id: proje_id,
                    maas_type_id: maas_type_id,
                    hesap_yil: hesap_yil,
                }
            },
            'columnDefs': [
                {
                    'targets': [1,6,7,8,9,10,11,18,19,20,21,22,23,24,25,26,27],
                    'orderable': false,
                }
            ],
             // "scrollY":        "900px",
             // "scrollX":        "500px",
             "scrollCollapse": true,
             "paging":         true,
             // fixedColumns:   {
             //     left: 3
             // },
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
                     .column( 6 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );
                 cemi = api
                     .column( 10 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );

                 odenilecek_meblaq = api
                     .column( 18 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );
                 banka_avans = api
                     .column( 19 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );
                 nakit_avans = api
                     .column( 20 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );

                 banka_odeme = api
                     .column( 21 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );
                 nakit_odeme = api
                     .column( 24 )
                     .data()
                     .reduce( function (a, b) {
                         return floatVal(a) + floatVal(b);
                     }, 0 );
                 razi_total = api
                     .column( 27 )
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
                 var razi_total_ =currencyFormat(floatVal(razi_total));


                 $( api.column( 3 ).footer() ).html(toplam_maas_).addClass( 'toplam_maas_' );
                 $( api.column( 6 ).footer() ).html(hesaplanan_).addClass( 'hesaplanan_' );
                 $( api.column( 10 ).footer() ).html(cemi_).addClass( 'cemi_' );
                 $( api.column( 18 ).footer() ).html(odenilecek_meblaq_).addClass( 'odenilecek_meblaq_' );
                 $( api.column( 19 ).footer() ).html(banka_avans_).addClass( 'banka_avans_' );
                 $( api.column( 20 ).footer() ).html(nakit_avans_).addClass( 'nakit_avans_' );
                 $( api.column( 21 ).footer() ).html(banka_odeme_).addClass( 'banka_odeme_' );
                 $( api.column( 24 ).footer() ).html(nakit_odeme_).addClass( 'nakit_odeme_' );
                 $( api.column( 27 ).footer() ).html(razi_total_).addClass( 'razi_total_' );






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
         $('#invoices tfoot').css('display','none');

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
        let nakit_odenilecekt = 0;
        let toplam_maas_ = 0;
        let hesaplanan_ = 0;
        let cemi_ = 0;
        let odenilecek_meblaq_ = 0;
        let banka_avans_ = 0;
        let banka_odeme_ = 0;
        let nakit_avans_ = 0;
        let razi_total_ = 0;

        if(status){
            $('.one_select').prop('checked',true)

        }
        else {
            $('.one_select').prop('checked',false)
        }

        let checked_count = $('.one_select:checked').length;
        for (let i =0; i< checked_count;i++){
            nakit_odenilecekt+=parseFloat($('.one_select').eq(i).attr('nakit_odenilecek'));
            toplam_maas_+=parseFloat($('.one_select').eq(i).attr('salary'));
            hesaplanan_+=parseFloat($('.one_select').eq(i).attr('banka_hesaplanan'));
            cemi_+=parseFloat($('.one_select').eq(i).attr('cemi'));
            odenilecek_meblaq_+=parseFloat($('.one_select').eq(i).attr('odenilecek_meblaq'));
            banka_avans_+=parseFloat($('.one_select').eq(i).attr('banka_avans'));
            banka_odeme_+=parseFloat($('.one_select').eq(i).attr('banka_hakedis'));
            nakit_avans_+=parseFloat($('.one_select').eq(i).attr('nakit_avans'));
            razi_total_+=parseFloat($('.one_select').eq(i).attr('razi_total'));
        }

        $('.nakit_odeme_').empty().html(currencyFormat(floatVal(nakit_odenilecekt)));
        $('.toplam_maas_').empty().html(currencyFormat(floatVal(toplam_maas_)));
        $('.hesaplanan_').empty().html(currencyFormat(floatVal(hesaplanan_)));
        $('.cemi_').empty().html(currencyFormat(floatVal(cemi_)));
        $('.odenilecek_meblaq_').empty().html(currencyFormat(floatVal(odenilecek_meblaq_)));
        $('.banka_avans_').empty().html(currencyFormat(floatVal(banka_avans_)));
        $('.nakit_avans_').empty().html(currencyFormat(floatVal(nakit_avans_)));
        $('.banka_odeme_').empty().html(currencyFormat(floatVal(banka_odeme_)));
        $('.razi_total_').empty().html(currencyFormat(floatVal(razi_total_)));
        $('#invoices tfoot').css('display','none');

    })

    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };

    $(document).on('change','.one_select',function (){
        let nakit_odenilecekt=0;
        let toplam_maas_ = 0;
        let hesaplanan_ = 0;
        let cemi_ = 0;
        let odenilecek_meblaq_ = 0;
        let banka_avans_ = 0;
        let banka_odeme_ = 0;
        let nakit_avans_ = 0;
        let razi_total_ = 0;
        let checked_count = $('.one_select').length;

        for (let i =0; i< checked_count;i++){
            let status = $('.one_select').eq(i).prop('checked');
            if(status){
                nakit_odenilecekt+=parseFloat($('.one_select').eq(i).attr('nakit_odenilecek'));
                toplam_maas_+=parseFloat($('.one_select').eq(i).attr('salary'));
                hesaplanan_+=parseFloat($('.one_select').eq(i).attr('banka_hesaplanan'));
                cemi_+=parseFloat($('.one_select').eq(i).attr('cemi'));
                odenilecek_meblaq_+=parseFloat($('.one_select').eq(i).attr('odenilecek_meblaq'));
                banka_avans_+=parseFloat($('.one_select').eq(i).attr('banka_avans'));
                banka_odeme_+=parseFloat($('.one_select').eq(i).attr('banka_hakedis'));
                nakit_avans_+=parseFloat($('.one_select').eq(i).attr('nakit_avans'));
                razi_total_+=parseFloat($('.one_select').eq(i).attr('razi_total'));
            }

        }
        $('.nakit_odeme_').empty().html(currencyFormat(floatVal(nakit_odenilecekt)));
        $('.toplam_maas_').empty().html(currencyFormat(floatVal(toplam_maas_)));
        $('.hesaplanan_').empty().html(currencyFormat(floatVal(hesaplanan_)));
        $('.cemi_').empty().html(currencyFormat(floatVal(cemi_)));
        $('.odenilecek_meblaq_').empty().html(currencyFormat(floatVal(odenilecek_meblaq_)));
        $('.banka_avans_').empty().html(currencyFormat(floatVal(banka_avans_)));
        $('.nakit_avans_').empty().html(currencyFormat(floatVal(nakit_avans_)));
        $('.banka_odeme_').empty().html(currencyFormat(floatVal(banka_odeme_)));
        $('.razi_total_').empty().html(currencyFormat(floatVal(razi_total_)));
        $('#invoices tfoot').css('display','none');

    })

    $(document).on('change','.all_select_job',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select_job').prop('checked',true)
        }
        else {
            $('.one_select_job').prop('checked',false)
        }
    })

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }


    $(document).on('click', "#ise_gelis_ekle", function (e) {
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Personel İşe Gelişi Bildirimek Üzeresiniz',
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
                    // '<div class="form-group">' +
                    // '<label>İşe Geldi</label>' +
                    // '<input type="checkbox" name="job_status" id="job_status" checked class="form-control" style="width: 5%;" />' +
                    // '</div>' +
                    '<div class="row">' +
                        '<div class="col-md-3">' +
                            '<label>R</label>' +
                            '<input type="checkbox" name="er" id="er" checked class="form-control" style="width: 10%;" />' +
                        '</div>' +
                    '<div class="col-md-3">' +
                            '<label>RO</label>' +
                            '<input type="checkbox" name="ero" id="ero"  class="form-control" style="width: 10%;" />' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<label>M</label>' +
                            '<input type="checkbox" name="er" id="mezuniyet" class="form-control" style="width: 10%;" />' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<label>X</label>' +
                            '<input type="checkbox" name="er" id="hastalik" class="form-control" style="width: 10%;" />' +
                        '</div>' +
                        '<div class="col-md-3 d-none" id="hastalik_div">' +
                            '<label>Xestalik Qiymet</label>' +
                            '<input type="number" name="hestalik_tutar" id="hestalik_tutar" class="form-control" />' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group d-none" id="iptal_desc">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Başlangıç Tarihi (Dahil)</label>' +
                    '<input type="date" id="start_date" data-date-format="DD.MM.YYYY" class="form-control name" >' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Bitiş Tarihi (Dahil)</label>' +
                    '<input type="date"   id="end_date" data-date-format="DD.MM.YYYY"  class="form-control name">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Proje</label>' +
                    '<select class="form-control name select-box name" name="proje_id_modal" id="proje_id_modal">' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Personeller</label>' +
                    '<select class="form-control select-box name" name="pers_id[]" multiple id="pers_id"><option>Seçiniz</option>' +
                    '</select>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }


                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    $('#proje_id_modal').append(new Option('Seçiniz', '', false, false));
                    responses.item.forEach((item_,index) => {
                        $('#proje_id_modal').append(new Option(item_.name, item_.id, false, false));
                    })
                });



                return $('#person-container').html();
            },
            onContentReady:function (){

            },
            buttons: {
                formSubmit: {
                    text: 'Girişi Yap',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tüm Alanlar Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                            $('#loading-box').addClass('d-none');
                        }
                        let desc = $('#desc').val()
                        let start_date = $('#start_date').val()
                        let end_date = $('#end_date').val()


                        // let job_status =  $('#job_status').prop('checked')?1:0;
                        let job_status = 1;
                        let hestalik_tutar = 0;
                        let er =  $('#er').prop('checked')?1:0;
                        let ero =  $('#ero').prop('checked')?1:0;
                        let mezuniyet =  $('#mezuniyet').prop('checked')?1:0;
                        let hastalik =  $('#hastalik').prop('checked')?1:0;
                        if(hastalik){
                            hestalik_tutar = $('#hestalik_tutar').val()

                        }
                        let proje_id = $('#proje_id_modal').val()
                        let pers_id = $('#pers_id').val();
                        jQuery.ajax({
                            url: baseurl + 'controller/personel_takip_add',
                            dataType: "json",
                            method: 'post',
                            data: 'ero='+ero+'&er='+er+'&start_date='+start_date+'&end_date='+end_date+'&job_status='+job_status+'&desc='+desc+'&proje_id='+proje_id+'&pers_id='+pers_id+'&mezuniyet='+mezuniyet+'&hastalik='+hastalik+'&hestalik_tutar='+hestalik_tutar+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $('#loading-box').removeClass('d-none');
                                $('#loading-box').removeClass('d-none');

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    $('#loading-box').addClass("d-none");

                                } else {
                                    $.alert(data.message);
                                    $('#loading-box').addClass("d-none");

                                }

                                let id =$('#table_projects').val();
                                let start_date = $('#hesap_ay').val();
                                let hesap_yil = $('#hesap_yil').val();
                                let maas_type_id = $('#maas_type_filter').val();
                                $('#invoices').DataTable().destroy();
                                draw_data(start_date,id,maas_type_id,hesap_yil)
                            },
                            error: function (data) {
                                $.alert(data.message);
                                $('#loading-box').addClass("d-none");
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

    $(document).on('change','#hastalik',function (e){
        let hastalik =  $('#hastalik').prop('checked')?1:0;
        if(hastalik){
            $('#hastalik_div').removeClass('d-none')
            $('#mezuniyet').prop('checked',false)
            $('#er').prop('checked',false)
            $('#ero').prop('checked',false)
        }
        else{
            $('#hastalik_div').addClass('d-none')
        }
    })
    $(document).on('change','#mezuniyet',function (e){
        let mezuniyet =  $('#mezuniyet').prop('checked')?1:0;
        if(mezuniyet){
            $('#hastalik_div').addClass('d-none')
            $('#hastalik').prop('checked',false)
            $('#er').prop('checked',false)
            $('#ero').prop('checked',false)
        }
    })

    $(document).on('change','#er',function (e){
        let er =  $('#er').prop('checked')?1:0;
        if(er){
            $('#hastalik_div').addClass('d-none')
            $('#hastalik').prop('checked',false)
            $('#mezuniyet').prop('checked',false)
            $('#ero').prop('checked',false)
        }
    })
    $(document).on('change','#ero',function (e){
        let ero =  $('#ero').prop('checked')?1:0;
        if(ero){
            $('#hastalik_div').addClass('d-none')
            $('#hastalik').prop('checked',false)
            $('#mezuniyet').prop('checked',false)
            $('#er').prop('checked',false)
        }
    })

    $(document).on('change','#proje_id_modal',function (e){

        let data = {
            crsf_token: crsf_hash,
            proje_id : $(this).val()
        }

        $.post(baseurl + 'employee/proje_to_pers',data,(response) => {
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });
            $('#pers_id').empty().trigger("change");
            let responses = jQuery.parseJSON(response);
            $('#pers_id').append(new Option('Tüm Projedeki Personeller', 0, false, false)).trigger('change');
            responses.item.forEach((item_,index) => {
                $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
            })
        });
    })

    $(document).on('click','.job_report',function (e){

        let hesaplama_ayi = $(this).attr('hesaplama_ayi');
        let hesaplama_yili = $(this).attr('hesaplama_yili');
        let personel_id = $(this).attr('personel_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Personelin İşe Geliş Kayıtları',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            columnClass: 'xlarge',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_rp">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`<div style="padding-bottom: 10px;"><button class="btn btn-danger all_delete_job" type="button">Seçili Olanları İptal Et</button></div>
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><input type="checkbox" class="form-control all_select_job" style="width: 30px;"></th>
                            <th>Geldiği Gün</th>
                            <th>Giriş Yapan Personel</th>
                            <th>Gün Açıklaması</th>
                            <th>İşlem</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Geldiği Gün</th>
                            <th>Giriş Yapan Personel</th>
                             <th>Gün Açıklaması</th>
                            <th>İşlem</th>

                        </tr>
                        </tfoot>

                    </table>`;
                    $('.table_rp').empty().html(table_report);
                    draw_data_report(personel_id,hesaplama_ayi,hesaplama_yili);
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

    function draw_data_report(personel_id=0,hesaplama_ayi=0,hesaplama_yili=0) {
        $('#invoices_report').DataTable({
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
            'ajax': {
                'url': "<?php echo site_url('controller/personel_job_report')?>",
                'type': 'POST',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    personel_id: personel_id,
                    hesaplama_ayi: hesaplama_ayi,
                    hesaplama_yili: hesaplama_yili,
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

    $(document).on('change','#hesap_ay',function (e){
        let id=  $(this).val();
        let proje_id = $('#table_projects').val();
        let maas_type_id = $('#maas_type_filter').val();
        let hesap_yil = $('#hesap_yil').val();
        $('#invoices').DataTable().destroy();
        draw_data(id,proje_id,maas_type_id,hesap_yil);
    })

    $(document).on('click', "#hakedis", function (e) {

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
                        '<p>Bordro Yapmak Üzeresiniz Emin Misiniz?<p/>'+
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
                        text: 'Emri Ver',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let personel_details = [];
                            $('.one_select:checked').each((index,item) => {
                               personel_details.push({
                                    hesaplama_ayi : $(item).attr('hesaplama_ayi'),
                                    hesaplama_yili : $(item).attr('hesaplama_yili'),
                                    nakit_odenilecek : $(item).attr('nakit_odenilecek'),
                                    prim : $(item).attr('prim'),
                                    ceza : $(item).attr('ceza'),
                                    proje_id : $(item).attr('proje_id'),
                                    personel_id : $(item).attr('personel_id'),
                                    salary : $(item).attr('salary'),
                                    is_gunu : $(item).attr('is_gunu'),
                                    calisilan_gun_sayisi_ : $(item).attr('calisilan_gun_sayisi_'),
                                    banka_hesaplanan : $(item).attr('banka_hesaplanan'),
                                    mezuniyet : $(item).attr('mezuniyet'),
                                    mezuniyet_hesap : $(item).attr('mezuniyet_hesap'),
                                    hastalik_amouth : $(item).attr('hastalik_amouth'),
                                    cemi : $(item).attr('cemi'),
                                    dsmf_isveren : $(item).attr('dsmf_isveren'),
                                    issizlik_isveren : $(item).attr('issizlik_isveren'),
                                    icbari_sigorta_isveren : $(item).attr('icbari_sigorta_isveren'),
                                    dsmf_isci : $(item).attr('dsmf_isci'),
                                    issizlik_isci : $(item).attr('issizlik_isci'),
                                    icbari_sigorta_isci : $(item).attr('icbari_sigorta_isci'),
                                    gelir_vergisi : $(item).attr('gelir_vergisi'),
                                    odenilecek_meblaq : $(item).attr('odenilecek_meblaq'),
                                    banka_avans : $(item).attr('banka_avans'),
                                    nakit_avans : $(item).attr('nakit_avans'),
                                    nakit_borc : $(item).attr('nakit_borc'),
                                    banka_borc : $(item).attr('banka_borc'),
                                    banka_hakedis : $(item).attr('banka_hakedis'),
                                    nakit_hakedis : $(item).attr('nakit_hakedis'),
                                    odenisli_izin_count : $(item).attr('odenisli_izin_count'),
                                    oz_hesabina_count : $(item).attr('oz_hesabina_count'),
                                    kesinti : $(item).attr('kesinti'),
                               })
                            });

                            let data = {
                                personel_details:personel_details,
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'controller/bordro_emri',data,(response)=>{
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
                                        content: 'Başarılı Bir Şekilde Bordro Oluşturldu. Ödemek İçin Onay Bekleyiniz!',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#invoices').DataTable().destroy();
                                    draw_data($('#hesap_ay').val(),$('#table_projects').val(),$('#maas_type_filter').val(),$('#hesap_yil').val())
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
        }


    })
    $(document).on('click','.all_delete_job',function (){
        let checked_count = $('.one_select_job:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir İş Günü Seçilmemiş!',
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
            let hesaplama_ayi=0;
            let personel_id = 0;
            let hesaplama_yili = 0;
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
                        '<p>İptal Etmek Üzeresiniz Emin Misiniz?<p/>'+
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
                        text: 'Eminim',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let job_id = [];

                            $('.one_select_job:checked').each((index,item) => {
                                job_id.push($(item).attr('id'));
                                hesaplama_ayi=$(item).attr('hesaplama_ayi');
                                hesaplama_yili=$(item).attr('hesaplama_yili');
                                personel_id=$(item).attr('personel_id');
                            });



                            let data = {
                                job_id:job_id,
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'controller/all_delete_job',data,(response)=>{
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
                                        content: 'Başarılı Bir Şekilde İptal Edildi!',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#invoices_report').DataTable().destroy();
                                    draw_data_report(personel_id,hesaplama_ayi,hesaplama_yili)
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
        }
    })






</script>
