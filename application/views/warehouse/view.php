<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php  echo $details->title ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
             <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Resim</th>
                                <th>Kategori</th>
                                <th>Stok Adı</th>
                                <th>Stok Miktarı</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

        </div>
    </div>
</div>

    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        var url = '<?php echo base_url() ?>arac/file_handling';

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
                    'url': "<?php echo site_url('warehouse/ajax_list_details')?>",
                    'type': 'POST',
                    'data': {'id': <?php echo $id; ?>}
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
            });
        }

        function draw_data_report(warehouse_id,product_id) {

            let product_name=
            $('#invoices_report').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('warehouse/ajax_list_product_details')?>",
                    'type': 'POST',
                    'data': {
                        'id': warehouse_id,
                        'product_id':product_id
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
                        messageTop: "<div>",
                        extend: 'print',
                        title: '<h3 style="text-align: center">'+$('#prd_name').val()+'</h3>',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2,3,4,5,6]
                        }
                    }
                ],
            });
        }

        $(document).on('click','.details',function (){
            let warehouse_id =$(this).attr('warehouse')
            let product_id =$(this).attr('product_id')
            let product_name ='';
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Detaylar',
                icon: 'fa fa-warehouse',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-12 mx-auto",
                containerFluid: !0,
                smoothContent: true,
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
                        product_id: product_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'products/product_name',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        product_name = responses.product_name;
                        table_report =`<div style="padding-bottom: 10px;"></div>
                        <table id="invoices_report"  class="table" style="width:100%;">
<input type="hidden" id="prd_name" value="`+product_name+`">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Varyasyon</th>
                            <th>Stok Miktarı</th>
                            <th>İşlem</th>
                            <th>İşlemi Yapan Personel</th>
                            <th>İşlem Türü</th>
                            <th>Tarih</th>

                        </tr>
                        </thead>

                    </table>`;
                        $('.table_history').empty().html(table_report);
                        draw_data_report(warehouse_id,product_id);
                    });



                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    cancel:{
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })


                    $('#fileupload_update').fileupload({
                        url: url,
                        dataType: 'json',
                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                        done: function (e, data) {
                            var img='default.png';
                            $.each(data.result.files, function (index, file) {
                                img=file.name;
                            });

                            $('#image_text_update').val(img);
                        },
                        progressall: function (e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                            );
                        }
                    }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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



        $(document).on('click','.details_varyant',function (){
            let warehouse_id =$(this).attr('warehouse')
            let product_id =$(this).attr('product_id')
            let product_name ='';
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Detaylar',
                icon: 'fa fa-warehouse',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-12 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group table_history_details">'+
                        '</div>' +
                        '</form>';

                    let data = {
                        product_id: product_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'products/product_name',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        product_name = responses.product_name;
                        table_report =`<div style="padding-bottom: 10px;"></div>
                        <table id="invoices_report_details"  class="table" style="width:100%;">
<input type="hidden" id="prd_name" value="`+product_name+`">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Varyasyon</th>
                            <th>Stok Miktarı</th>
                            <th>Stok Çıkış Fiş Listesi</th>
                            <th>Proje Stok Çıkış Fiş Listesi</th>

                        </tr>
                        </thead>

                    </table>`;
                        $('.table_history_details').empty().html(table_report);
                        draw_data_report_details(warehouse_id,product_id);
                    });



                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    cancel:{
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {

                }
            });
        })

        function draw_data_report_details(warehouse_id,product_id) {

                $('#invoices_report_details').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'stateSave': true,
                    responsive: true,
                    <?php datatable_lang();?>
                    'order': [],
                    'ajax': {
                        'url': "<?php echo site_url('warehouse/ajax_list_product_varyant_details')?>",
                        'type': 'POST',
                        'data': {
                            'warehouse_id': warehouse_id,
                            'product_id':product_id
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
                            messageTop: "<div>",
                            extend: 'print',
                            title: '<h3 style="text-align: center">'+$('#prd_name').val()+'</h3>',
                            footer: true,
                            exportOptions: {
                                columns: [0, 1, 2,3,4,5,6]
                            }
                        }
                    ],
                });
        }

        $(document).on('click','.cikis_fis',function (){
            let qty=0;
            let data_post = {
                tip:$(this).attr('tip'),
                option_id:$(this).data('option_id'),
                option_value_id:$(this).data('option_value_id'),
                warehouse_id:$(this).data('warehouse_id'),
                product_id:$(this).data('product_id'),
                product_stock_code_id:$(this).data('product_stock_code_id'),
                unit:$(this).data('unit')
            };
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Ürün Ekle',
                icon: 'fa fa-plus',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Ürünü Stok Fiş Listesine Eklemek İstediğinizden Emin Misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="number" name="qty" id="qty" value="0" class="form-control qty">' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Ekle',
                        btnClass: 'btn-blue',
                        action: function () {

                            $('#loading-box').removeClass('d-none');
                            qty=$('#qty').val();
                            let data = {
                                details : data_post,
                                qty : qty,
                                update : 0,
                            }
                            $.post(baseurl + 'warehouse/cloud_stock',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.code==200){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                            }
                                        }
                                    });

                                }
                                else if(responses.code==100){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-question',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Bilgi',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Güncelle',
                                                btnClass: 'btn-blue',
                                                action:function (){
                                                    let new_data = {
                                                        details : data_post,
                                                        qty : qty,
                                                        update : 1,
                                                    }
                                                    $.post(baseurl + 'warehouse/cloud_stock',new_data,(response) => {
                                                        let responses = jQuery.parseJSON(response);
                                                        $('#loading-box').addClass('d-none');
                                                        if(responses.code==200){
                                                            $.alert({
                                                                theme: 'modern',
                                                                icon: 'fa fa-check',
                                                                type: 'green',
                                                                animation: 'scale',
                                                                useBootstrap: true,
                                                                columnClass: "small",
                                                                title: 'Başarılı',
                                                                content: responses.message,
                                                                buttons:{
                                                                    formSubmit: {
                                                                        text: 'Tamam',
                                                                        btnClass: 'btn-blue',
                                                                    }
                                                                }
                                                            });

                                                        }
                                                        else if(responses.code==410){

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
                                            },
                                        }
                                    });

                                }
                                else if(responses.code==410){

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
                    },
                },
                onContentReady: function () {
                }
            });

        })



    </script>
