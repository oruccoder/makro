<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Lojistik Hizmet Listesi</span></h4>
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
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="invoices" class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="form-control all_select_talep" style="width: 30px;"></th>
                                                <th>Oluşturma Tarihi</th>
                                                <th>Talep No</th>
                                                <th>Lojistik Talebi</th>
                                                <th>Firma</th>
                                                <th>Lokasyon</th>
                                                <th>Kaldığı Gün Sayısı</th>
                                                <th>Araç</th>
                                                <th>Teklif Fiyatı</th>
                                                <th>Giderler Toplamı</th>
                                                <th>Ödeme Metodu</th>
                                                <th>Durum</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

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



    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        let lsf_id = [];
        $(document).ready(function () {
            draw_data()
        });
        function draw_data() {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('logistics/ajax_lojistikhizmetlist')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
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
                        text: '<i class="fa fa-plus"></i> İşlemler',
                        action: function ( e, dt, node, config ) {
                            let checked_count = $('.one_select_talep:checked').length;
                            if(checked_count==0){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Herhangi Bir Araç Seçilmemiş!',
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
                                let teklif_tutari = [];
                                let toplam_gider = [];
                                lsf_id = [];

                                $('.one_select_talep:checked').each((index,item) => {
                                    lsf_id.push({
                                        'lsf_id':$(item).attr('lsf_id'),
                                        'method_id':$(item).attr('method_id'),
                                        'firma_id':$(item).attr('firma_id'),
                                        'teklif_tutari':$(item).attr('teklif_tutari'),
                                        'toplam_gider':$(item).attr('toplam_gider'),
                                    })
                                    method_id.push($(item).attr('method_id'))
                                    firma_id.push($(item).attr('firma_id'))
                                });

                                let uniq = $.grep(firma_id, function(v, k) {
                                    return $.inArray(v, firma_id) === k;
                                });
                                let uniq_method = $.grep(method_id, function(v, k) {
                                    return $.inArray(v, method_id) === k;
                                });

                                if(uniq.length > 1){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Farklı Firmalar Seçilemez!',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    return false;
                                }
                                else if(uniq_method.length > 1){
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
                                    $.confirm({
                                        theme: 'modern',
                                        closeIcon: true,
                                        title: 'Hizmet Tamamlama',
                                        icon: 'fa fa-check',
                                        type: 'dark',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-3 mx-auto",
                                        containerFluid: !0,
                                        smoothContent: true,
                                        draggable: false,
                                        content:'Hizmet Tamamlandığını Bildirmek Üzeresiniz! Emin misiniz?',
                                        buttons: {
                                            formSubmit: {
                                                text: 'Evet',
                                                btnClass: 'btn-success',
                                                action: function () {
                                                    $('#loading-box').removeClass('d-none');
                                                    let data = {
                                                        crsf_token: crsf_hash,
                                                        details:lsf_id,
                                                    }
                                                    $.post(baseurl + 'logistics/sms_confirm',data,(response)=>{
                                                        let responses = jQuery.parseJSON(response);
                                                        $('#loading-box').addClass('d-none');
                                                        if(responses.status=='Success'){
                                                            confirm_smsm(responses.confirm_id,responses.code)

                                                        }
                                                        else if(responses.status=='Error'){

                                                            $.alert({
                                                                theme: 'modern',
                                                                icon: 'fa fa-exclamation',
                                                                type: 'red',
                                                                animation: 'scale',
                                                                useBootstrap: true,
                                                                columnClass: "col-md-4 mx-auto",
                                                                title: 'Dikkat',
                                                                content:responses.message,
                                                                buttons: {
                                                                    cancel: {
                                                                        text: 'Tamam',
                                                                        btnClass: 'btn-blue',
                                                                    },
                                                                }
                                                            });
                                                        }
                                                        $('#loading-box').addClass('d-none');
                                                    })



                                                }
                                            },
                                            cancel: {
                                                text: 'Hayır',
                                                btnClass: 'btn-red',
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






                            }

                        }
                    }
                ]
            });
        }

        $(document).on('click', ".talep_iptal", function (e) {
            let talep_id = $(this).attr('talep_id');
            let status = 3;
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
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Talebi İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'İptal Et',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
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
                            jQuery.ajax({
                                url: baseurl + 'logistics/sf_talep_iptal',
                                dataType: "json",
                                method: 'post',
                                data: 'desc=' + desc + '&status=' + status + '&talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $(this).html('Bekleyiniz');
                                    $(this).prop('disabled', true); // disable button

                                },
                                success: function (data) {
                                    if (data.status == "Success") {
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Başarılı',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        $('#invoices').DataTable().destroy();
                                                        draw_data();
                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Dikkat',
                                            content:data.message,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        $('#invoices').DataTable().destroy();
                                                        draw_data();
                                                    }
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

        })

        $(document).on('click','.arac_hareketleri',function (e){

            let lojistik_car_id = $(this).attr('lojistik_car_id');
            let lojistik_id = $(this).attr('lojistik_id');
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Araç Hareketleri',
                icon: 'fa fa-exclamation',
                type: 'light',
                animation: 'zoom',
                columnClass: 'col-md-8 col-md-offset-3',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group table_history">'+
                        '</div>' +
                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    let table_report='';
                    $.post(baseurl + 'employee/projeler',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        table_report =`<div style="padding-bottom: 10px;"><button class="btn btn-danger all_delete"  lojistik_car_id='`+lojistik_car_id+`' type="button">Seçili Olanları İptal Et</button></div>
                        <table id="invoices_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                            <th>İşlem Tarihi</th>
                            <th>Açıklama</th>
                            <th>Lokasyon</th>
                            <th>İşlem Yapan Personel</th>
                            <th>Durum</th>

                        </tr>
                        </thead>

                    </table>`;
                        $('.table_history').empty().html(table_report);
                        draw_data_report(lojistik_car_id);
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

        function draw_data_report(lojistik_car_id=0) {
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
                    'url': "<?php echo site_url('lojistikcar/ajax_list_history')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        lojistik_car_id: lojistik_car_id,
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

        $(document).on('change','.all_select_talep',function (){
            let status = $(this).prop('checked');
            if(status){
                $('.one_select_talep').prop('checked',true)
            }
            else {
                $('.one_select_talep').prop('checked',false)
            }
        })

        function confirm_smsm(confirm_id,code){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: `<input type="number" class="form-control" id="code" value="`+code+`" placeholder="Doğrulama Kodunu Giriniz">`,
                buttons: {
                    formSubmit: {
                        text: 'Doğrula',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                code:$('#code').val(),
                                details:lsf_id,
                                last_id:confirm_id,
                            }
                            $.post(baseurl + 'logistics/lsf_table_file_create',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
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
                                                action:function (){
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
                                                }
                                            }
                                        }
                                    });
                                    return false;

                                }
                                else if(responses.status=='Error'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
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
