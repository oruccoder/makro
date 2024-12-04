<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">ONAYLANAN MAAŞLAR</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <button class="btn btn-success" style="margin: 3px" id="odenis">Ödeniş Yap</button>  <br/>   <button class="btn btn-success"style="margin: 3px" id="alacaklandir_personel">Personel Alacaklandır</button>

                    <select id="table_projects"  multiple="multiple" class="select-box select">
                        <option disabled selected hidden value="">Proje Bazlı Raporlama</option>
                        <?php foreach (all_projects() as $items){
                            echo "<option value='$items->id'>$items->name</option>";
                        }?>
                    </select>

                    <div class="col-sm-2">
                        <div class="input-group">
                            <select class="form-control bordro_ayi">
                                <option value="0">Bordro Ayı Seçiniz</option>
                                <option value="1">Ocak</option>
                                <option value="2">Şubat</option>
                                <option value="3">Mart</option>
                                <option value="4">Nisan</option>
                                <option value="5">Mayıs</option>
                                <option value="6">Haziran</option>
                                <option value="7">Temmuz</option>
                                <option value="8">Ağustos</option>
                                <option value="9">Eylül</option>
                                <option value="10">Ekim</option>
                                <option value="11">Kasım</option>
                                <option value="12">Aralık</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2" style="display: flex;justify-content: flex-end;">
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
                            <option selected  value="21">Maaş Tipi</option>
                            <option selected  value="22">Banka Maaş</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="invoices"  class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th><input type="checkbox" class="form-control all_select" style="width: 30px;margin-top: 100px"></th>
                        <th>Personel</th>
                        <th>Banka Alacak Durumu</th>
                        <th>Nakit Alacak Durumu</th>
                        <th>Bordro Ayı</th>
                        <th>Toplam Maaş</th>
                        <th>İş Günü</th>
                        <th>Hesaplanan</th>
                        <th>Cəmi</th>
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
                        <th>Bankadan Hakediş</th>
                        <th>Nakit Ödenilecek</th>
                        <th>Ödenişli İzin</th>
                        <th>Öz Hesabına İzin</th>
                        <th>Maaş Tipi</th>
                        <th>Banka Maaş</th>
                        <th>Razı Toplam</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <!--                        <th>#</th>-->
                        <th></th>
                        <th></th>
                        <th>Banka Alacak Durumu</th>
                        <th>Nakit Alacak Durumu</th>
                        <th>Bordro Ayı</th>
                        <th>Toplam Maaş</th>
                        <th></th>
                        <th>Hesaplanan</th>
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
                        <th>Bankadan Hakediş</th>
                        <th>Nakit Ödenilecek</th>
                        <th>Ödenişli İzin</th>
                        <th>Öz Hesabına İzin</th>
                        <th>Maaş Tipi</th>
                        <th>Banka Maaş</th>
                        <th>Razı Toplam</th>

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



    function draw_data(start_date = '',proje_id=0,bordro_ayi=0) {

        table = $('#invoices').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[27]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/personel_salary_report_ajax_odenis')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    status: 1,
                    proje_id: proje_id,
                    bordro_ayi: bordro_ayi,
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
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
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                hesaplanan = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                cemi = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 5 );

                odenilecek_meblaq = api
                    .column( 16 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                banka_avans = api
                    .column( 17 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                nakit_avans = api
                    .column( 18 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                banka_odeme = api
                    .column( 19 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                nakit_odeme = api
                    .column( 20 )
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


                $( api.column( 5 ).footer() ).html(toplam_maas_);
                $( api.column( 7 ).footer() ).html(hesaplanan_);
                $( api.column( 8 ).footer() ).html(cemi_);
                $( api.column( 16 ).footer() ).html(odenilecek_meblaq_);
                $( api.column( 17 ).footer() ).html(banka_avans_);
                $( api.column( 18 ).footer() ).html(nakit_avans_);
                $( api.column( 19 ).footer() ).html(banka_odeme_);
                $( api.column( 20 ).footer() ).html(nakit_odeme_);





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

    function draw_data_report(proje_id=0) {

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
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/personel_project_ajax_salary')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id: proje_id,
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

    $(document).on('click', ".project_personel_salary", function (e) {
        let proje_id = $(this).attr('proje_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Projede Bulunan Personel Emek Hakları',
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
                    table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                        <tr>
                            <th>Personel</th>
                            <th>Toplam Maaş</th>
                            <th>İş Günü</th>
                            <th>Geldiği Gün Sayısı</th>
                            <th>Hesaplanan</th>
                            <th>Cəmi</th>
                            <th>Banka Avans</th>
                            <th>Nakit Avans</th>
                            <th>Bankadan Ödenilecek</th>
                            <th>Nakit Ödenilecek</th>
                            <th>Ödenişli İzin</th>
                            <th>Öz Hesabına İzin</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                             <th>Personel</th>
                            <th>Toplam Maaş</th>
                            <th>İş Günü</th>
                            <th>Geldiği Gün Sayısı</th>
                            <th>Hesaplanan</th>
                            <th>Cəmi</th>
                            <th>Banka Avans</th>
                            <th>Nakit Avans</th>
                            <th>Bankadan Ödenilecek</th>
                            <th>Nakit Ödenilecek</th>
                            <th>Ödenişli İzin</th>
                            <th>Öz Hesabına İzin</th>

                        </tr>
                        </tfoot>

                    </table>`;
                    $('.table_rp').empty().html(table_report);
                    draw_data_report(proje_id);
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


    $(document).on('click', "#odenis", function (e) {
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
                theme: 'material',
                closeIcon: true,
                title: 'Ödeme Yapmak Üzeresiniz!',
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
                        '<label>Ödeme Tip</label>' +
                        '<select id="method"  class="form-control name" ><option value="1">Nakit Maaşlar Ödensin</option><option value="2">Banka Maaşları Ödensin</option></select>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Kasa</label>' +
                        '<select class="form-control select-box name" name="acid" id="acid"><option value="0">Seçiniz</option>' +
                        '</select>' +
                        '</div>' +
                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    $.post(baseurl + 'controller/ajax_account_emp',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        let responses = jQuery.parseJSON(response);
                        responses.item.forEach((item_,index) => {
                            $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                        })

                    });

                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Ödeme Yap',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            var name = this.$content.find('.name').val();
                            var acid = this.$content.find('#acid').val();
                            if(!name){
                                ('#loading-box').addClass('d-none');
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
                                $
                            }
                            if(!acid){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Kasa Seçmek Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

                            }


                            let report_id = [];
                            $('.one_select:checked').each((index,item) => {
                                report_id.push($(item).attr('report_id'))
                            });


                            let data = {
                                report_id:report_id,
                                method:$('#method').val(),
                                acid:$('#acid').val(),
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'controller/personel_maas_odeme',data,(response)=>{
                                let responses = jQuery.parseJSON(response);

                                if(responses.status=='Success'){
                                    setTimeout(function () {
                                        // This will be executed after 1,000 milliseconds
                                        $('#loading-box').addClass('d-none');
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'grey',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Başarılı',
                                            content: 'Başarılı Bir Şekilde Bordro Ödeme Yapıldı.',
                                            buttons:{
                                                prev: {
                                                    text: 'Tamam',
                                                    btnClass: "btn btn-link text-dark",
                                                }
                                            }
                                        });
                                    }, 10000);



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

                            let id = $('#table_projects').val();
                            let start_date = $('#hesap_ay').val();
                            $('#invoices').DataTable().destroy();
                            draw_data(start_date,id)

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

    $(document).on('change','.bordro_ayi',function (){
        let id = $(this).val();
        if(id){
            $('#invoices').DataTable().destroy();
            let id_proje = $('#table_projects').val();
            draw_data("",id,id)
        }
    })

    $(document).on('click', "#alacaklandir_personel", function (e) {
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
                theme: 'material',
                closeIcon: true,
                title: 'Ödeme Yapmak Üzeresiniz!',
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
                        '<label>Ödeme Tip</label>' +
                        '<select id="method"  class="form-control name" ><option value="1">Nakit Alacaklandır</option><option value="2">Banka Alacaklandır</option></select>' +
                        '</div>' +
                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    $.post(baseurl + 'controller/ajax_account_emp',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        let responses = jQuery.parseJSON(response);
                        responses.item.forEach((item_,index) => {
                            $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                        })

                    });

                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Ödeme Yap',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            var name = this.$content.find('.name').val();
                            if(!name){
                                ('#loading-box').addClass('d-none');
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
                                $
                            }

                            let report_id = [];
                            $('.one_select:checked').each((index,item) => {
                                report_id.push($(item).attr('report_id'))
                            });


                            let data = {
                                report_id:report_id,
                                method:$('#method').val(),
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'controller/personel_maas_alacaklandirma',data,(response)=>{
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

                            let id = $('#table_projects').val();
                            let start_date = $('#hesap_ay').val();
                            $('#invoices').DataTable().destroy();
                            draw_data(start_date,id)

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
