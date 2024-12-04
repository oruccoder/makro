<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">TAMAMLANAN LOJISTIK HIZMETLERI</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
        <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-success" id="status_chage">Seçili Olanlara Durum Bildir</button>
                    </div>
                </div>

                <hr>
                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                        <th>Dosya Adı</th>
                        <th>Firma</th>
                        <th>Tamamlanma Tarihi</th>
                        <th>Toplam Tutar</th>
                        <th>Ödeme Metodu</th>
                        <th>Durum</th>
                        <th>Detaylar</th>


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
                    </tr>
                    </tfoot>

                </table>
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
<script type="text/javascript">

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })

    $(document).on('change','.all_select_item',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select_item').prop('checked',true)
        }
        else {
            $('.one_select_item').prop('checked',false)
        }
    })

    $(document).ready(function () {
        draw_data();

    });
    function draw_data() {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('lojistikconfirm/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
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
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    messageTop: "<div style='text-align: center'><img src='http://muhasebe.italicsoft.com/userfiles/company/16058809601269056269.png?t=88' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',

                    footer: true,
                    title:"<h3 style='text-align: center'>Personel Kesintisi</h3>",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ],

        });
    };
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('click', ".view", function (e) {
        let method_id = $(this).attr('method_id');
        let file_id = $(this).attr('file_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<h3 style="text-align: center;">Detaylar</h3><div class="table_history"></div>'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    file_id: file_id,
                }
                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    //<button class="btn btn-warning all_islem"  file_id='`+file_id+`' type="button">Seçili Olanları İşlem Bildir</button>
                    table_report =`<div style="padding-bottom: 10px;"></div>
                        <table id="invoices_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>

                            <th><input type="checkbox" class="form-control all_select_item" style="width: 30px;"></th>
                            <th>SF KODU</th>
                            <th>Lokasyon</th>
                            <th>Elave Gün Sayısı</th>
                            <th>Günlük Tutar</th>
                            <th>Elave Gün Toplam Tutarı</th>
                            <th>Araç</th>
                            <th>Araç Teklif Tutarı</th>
                            <th>Açıklamalar</th>
                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_report(file_id);
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


    function draw_data_report(file_id=0) {
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
                'url': "<?php echo site_url('lojistikconfirm/ajax_list_item')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    file_id: file_id,
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

    $(document).on('click',"#status_chage",function (e){
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
                content: 'Herhangi Bir Dosya Seçilmemiş!',
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

            let method_id = [];
            let firma_id = [];

            $('.one_select:checked').each((index,item) => {
                method_id.push($(item).attr('method_id'))
                firma_id.push($(item).attr('firma_id'))
            });

            let uniq_method = $.grep(method_id, function(v, k) {
                return $.inArray(v, method_id) === k;
            });

            if(uniq_method.length > 1){
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Farklı Ödeme Metodları Seçilemez!',
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

                let user_status = 1;//Proje Müdürü
                let option="<?php echo $option;?>";
                   if(uniq_method[0]==3) // Banka
                   {
                        if(option=='0'){
                            option="<option value='3'>Onayla / Fatura Talep Et</option><option value='6'>Düzeliş İste</option><option value='8'>Hizmet Talebini İptal Et</option>";
                            user_status=2;
                        }
                   }
                   else { // nakit
                       if(option=='0'){
                           option="<option value='2'>Onayla / Cari Bakiyesinde Alacaklandır</option><option value='6'>Düzeliş İste</option><option value='8'>Hizmet Talebini İptal Et</option>";
                           user_status=2;
                       }
                   }
                $.confirm({
                    theme: 'material',
                    closeIcon: true,
                    title: 'Dikkat',
                    icon: 'fa fa-exclamation',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: '<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<input class="form-control" id="desc" placeholder="İnceledim">'+
                        '</div>' +
                        '<div class="form-group">' +
                        '<select id="status" class="form-control">'+option+'</select>'+
                        '</div>' +
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Güncelle',
                            btnClass: 'btn-blue',
                            action: function () {

                                let placeholder = $('#desc').attr('placeholder');
                                let desc = $('#desc').val();
                                if(desc.length == 0){
                                    desc = placeholder;
                                }

                                let edit_table_id = [];
                                $('.one_select:checked').each((index,item) => {
                                    edit_table_id.push($(item).attr('file_id'))
                                });
                                let data = {
                                    crsf_token: crsf_hash,
                                    status: $('#status').val(),
                                    edit_table_id: edit_table_id,
                                    user_status: user_status,
                                    desc: desc
                                }

                                $.post(baseurl + 'lojistikconfirm/all_update',data,(response) => {
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
                                        $('#invoices').DataTable().destroy();
                                        draw_data();
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


        }
    })

    $(document).on('click',".all_islem",function (e){
        let checked_count = $('.one_select_item:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Lokasyon Seçilmemiş!',
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
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<input class="form-control" id="desc" placeholder="İnceledim">'+
                    '</div>' +
                    '<div class="form-group">' +
                    '<select id="status" class="form-control"><option value="6">Düzeliş İste</option></select>'+
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {

                            let placeholder = $('#desc').attr('placeholder');
                            let desc = $('#desc').val();
                            if(desc.length == 0){
                                desc = placeholder;
                            }

                            let edit_table_id = [];
                            $('.one_select_item:checked').each((index,item) => {
                                edit_table_id.push($(item).attr('file_item_id'))
                            });
                            let data = {
                                crsf_token: crsf_hash,
                                status: $('#status').val(),
                                edit_table_id: edit_table_id,
                                desc: desc
                            }

                            $.post(baseurl + 'lojistikconfirm/one_item_update',data,(response) => {
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
                                    $('#invoices').DataTable().destroy();
                                    draw_data();
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
    })


</script>
