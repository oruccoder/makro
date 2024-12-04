<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Varyantlar</span></h4>
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
                                        <table id="product_table" class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <th>Ürün Opsiyon</th>
                                                <th>Açıklaması</th>
                                                <th>Action</th>
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




<style>
    .group-buttons {
        outline: none !important;
        border-radius: 0px !important;
        border: 1px solid gray;
    }
</style>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
    $(document).ready(function() {

        $('.select2').select2();
        draw_data();
    });

    function draw_data() {
        $('#product_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': "<?php echo base_url() . 'productoption/ajax_list' ?>",
                'type': 'POST',
                'data': {}
            },
            'columnDefs': [{
                'targets': [0],
                'orderable': false,
            }, ],
            dom: 'Blfrtip',
            buttons: [

                {
                    text: '<i class="fa fa-plus"></i> Yeni Opsiyon Elave et',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Yeni Opsiyon Elave et',
                            icon: 'fa fa-plus-square 3x',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: function() {
                                let self = this;
                                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                let responses;
                                html += `
                                <div class='mb-5'>
                                    <div class="form-row">
                                         <div class="form-group col-md-6">
                                            <label>Opsiyon Adı</label>
                                            <input type="text" class='form-control name' required>
                                         </div>

                                         <div class="form-group col-md-6">
                                            <label>Opsiyon Aciklamasi</label>
                                            <input type="text" class='form-control description'>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Varyantın Ekleneceği Ürünler</label>
                                             <select id="product" class="form-control product" multiple>

                                              </select>
                                        </div>

                                         <div class="form-group mt-4">
                                            <button class="btn btn-success" id="new_add_line"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <table class="table" id="option_value_list">
                                            <thead>
                                                <tr>
                                                    <th>Değer Adı</th>
                                                    <th>Değer Açıklaması</th>
                                                     <th id="parent_value_text_new" style="display: none">Bağlı Varyant</th>
                                                    <th>işlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input class="form-control value_name" placeholder="Ör: Kırmızı"></td>
                                                    <td class="value_desc_td"><input class="form-control value_desc" placeholder="Ör: Kırmızı Renk"></td>
                                                    <td>#</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                `;
                                let data = {
                                    crsf_token: crsf_hash,
                                }
                                $.post(baseurl + 'productoption/option_value', data, (response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    let responses = jQuery.parseJSON(response);
                                    $.each(responses.details, function (index_, item_value) {
                                        $('#parent_option_new').append(new Option(item_value.name, item_value.id, false, false));
                                    });
                                  });
                                self.$content.find('#person-list').empty().append(html);
                                return $('#person-container').html();
                                },
                            buttons: {
                                formSubmit: {
                                    text: 'Gondər',
                                    btnClass: 'btn-blue',
                                    action: function() {
                                        $('#loading-box').removeClass('d-none');
                                        let count = $('.value_name').length;
                                        let value_details = [];
                                        for (let i = 0; i < count; i++ ){
                                            value_details.push({
                                                'value_name':$('.value_name').eq(i).val(),
                                                'value_desc':$('.value_desc').eq(i).val(),
                                                'parent_value_id':$('.parent_option_select').eq(i).val()
                                            });
                                        }



                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            name: $('.name').val(),
                                            description: $('.description').val(),
                                            parent_option: $('#parent_option_new').val(),
                                            product: $('#product').val(),
                                            value_details: value_details
                                        }

                                        $.post(baseurl + 'productoption/create', data_post, (response) => {
                                            let data = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (data.status == 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: data.message,
                                                    buttons: {
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                            action: function() {
                                                                table_product_id_ar = [];
                                                                $('#product_table').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            } else if (data.status == 410) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: responses.message,
                                                    buttons: {
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
                                cancel: {
                                    text: 'İmtina et',
                                    btnClass: "btn btn-danger btn-sm",
                                    action: function() {
                                        table_product_id_ar = [];
                                    }
                                }
                            },
                            onContentReady: function() {


                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $('.product').select2({
                                    dropdownParent: $(".jconfirm-box-container"),
                                    minimumInputLength: 3,
                                    allowClear: true,
                                    placeholder:'Seçiniz',
                                    language: {
                                        inputTooShort: function() {
                                            return 'En az 3 karakter giriniz';
                                        }
                                    },
                                    ajax: {
                                        method:'POST',
                                        url: '<?php echo base_url().'stockio/getall_products' ?>',
                                        dataType: 'json',
                                        data:function (params)
                                        {
                                            let query = {
                                                search: params.term,
                                                warehouse_id: 0,
                                                crsf_token: crsf_hash,
                                            }
                                            return query;
                                        },
                                        processResults: function (data) {
                                            return {
                                                results: $.map(data, function (data) {
                                                    return {
                                                        text: data.product_name,
                                                        product_name: data.product_name,
                                                        id: data.pid,

                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    },
                                }).on('change',function (data) {
                                })

                                // bind to events
                                var jc = this;
                                this.$content.find('form').on('submit', function(e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                }
            ]
        });
    }


    $(document).on('click','#new_add_line',function (){

        let value = $('#parent_option').val();
        let value_2 = $('#parent_option_new').val();
        if(parseInt(value) ||  parseInt(value_2)){
            let eq=$('#option_value_list tbody tr').length;
            let say = parseInt(eq)-1;
            let id = $(this).attr('product_option_id');
            $('#option_value_list tbody').append(`<tr>
                    <td><input class="form-control value_name" placeholder="Ör: Kırmızı"><input type="hidden" class="value_id" value="0"></td>
                    <td><input class="form-control value_desc" placeholder="Ör: Kırmızı Renk"></td>
                    <td><select class="form-control  parent_option_select" multiple id="parent_option_select">

                                                            </select>
                    </td>
                    <td><button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button></td>
                </tr>`)

            let val='';
            if(value){
                val =parseInt(value);
            }
            if(value_2){
                val =parseInt(value_2);
            }
            let data = {
                crsf_token: crsf_hash,
                option_id: val
            }
            setTimeout(function() {
                $.post(baseurl + 'productoption/info_options_value', data, (response) => {
                    let responses = jQuery.parseJSON(response);
                    $.each(responses.details, function (index, item) {
                        $('.parent_option_select').eq(eq).append(new Option(item.name, item.id, false, false));
                    });
                });
            }, 2000);




        }
        else {
            $('#option_value_list tbody').append(`<tr>
                    <td><input class="form-control value_name" placeholder="Ör: Kırmızı"><input type="hidden" class="value_id" value="0"></td>
                    <td><input class="form-control value_desc" placeholder="Ör: Kırmızı Renk"></td>
                    <td><button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button></td>
                </tr>`)
        }



    })


    $(document).on('click', '.edit', function() {
        let id = $(this).attr('product_option_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Opsiyon Düzenle',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function() {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html += `<div class='mb-3'>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Opsiyon Adı</label>
                                        <input type="text" class='form-control name'>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Opsiyon Acıklaması</label>
                                        <input type="text" class='form-control description'>
                                    </div>

  <div class="form-group col-md-12">
                                            <label>Varyantın Ekleneceği Ürünler</label>
                                             <select id="product" class="form-control product" multiple>

                                              </select>
                                        </div>

                                    <div class="form-group mt-4">
                                            <button class="btn btn-success" id="new_add_line"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <table class="table" id="option_value_list">
                                            <thead>
                                                <tr>
                                                    <th>Değer Adı</th>
                                                    <th>Değer Açıklaması</th>
                                                    <th id="parent_value_text" style="display: none">Bağlı Varyant</th>
                                                    <th>işlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>


                                </div>

                                </div> 
                            `;
                let data = {
                    crsf_token: crsf_hash,
                    id: id
                }


                let table_report = '';
                $.post(baseurl + 'productoption/info', data, (response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $.each(responses.details_value, function (index, item) {
                        $('#option_value_list tbody').append(` <tr>
                                        <td><input class="form-control value_name" value="`+item.name+`"><input type="hidden" class="value_id" value="`+item.id+`"></td>
                                        <td class="value_desc_td"><input class="form-control value_desc" value="`+item.description+`"></td>
                                         <td><button class="btn btn-danger delete_line" delete_id="`+item.id+`"><i class="fa fa-trash"></i></button></td>
                                    </tr>`);
                    });

                    $.each(responses.list_options, function (index_, item_value) {
                        $('#parent_option').append(new Option(item_value.name, item_value.id, false, false));
                    });

                    //$('.option').eq(index).val(item_.option_id).trigger('change')

                    $('.name').val(responses.details_items[0].name)
                    $('.description').val(responses.details_items[0].description)
                    $('#parent_option').val(responses.details_items[0].parent_option).select2().trigger('change');

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {
                        $('#loading-box').removeClass('d-none');

                        let count = $('.value_name').length;
                        let value_details = [];
                        for (let i = 0; i < count; i++ ){
                            value_details.push({
                                'value_name':$('.value_name').eq(i).val(),
                                'value_desc':$('.value_desc').eq(i).val(),
                                'value_id':$('.value_id').eq(i).val(),
                                'parent_value_id':$('.parent_option_select').eq(i).val()
                            });
                        }
                        let data_post = {
                            id: id,
                            crsf_token: crsf_hash,
                            name: $('.name').val(),
                            description: $('.description').val(),
                            product: $('#product').val(),
                            parent_option: $('#parent_option').val(),
                            value_details: value_details,
                        }
                        $.post(baseurl + 'productoption/update', data_post, (response) => {
                            $('#loading-box').addClass('d-none');
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function() {
                                                table_product_id_ar = [];
                                                $('#product_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        },
                                    }
                                });
                            } else if (data.code == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons: {
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
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action: function() {
                        table_product_id_ar = [];
                    }
                }
            },

            onContentReady: function() {

                $('.product').select2({
                    dropdownParent: $(".jconfirm-box-container"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder:'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method:'POST',
                        url: '<?php echo base_url().'stockio/getall_products' ?>',
                        dataType: 'json',
                        data:function (params)
                        {
                            let query = {
                                search: params.term,
                                warehouse_id: 0,
                                crsf_token: crsf_hash,
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (data) {
                                    return {
                                        text: data.product_name,
                                        product_name: data.product_name,
                                        id: data.pid,

                                    }
                                })
                            };
                        },
                        cache: true
                    },
                }).on('change',function (data) {
                })

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })







    $(document).on('change','#parent_option',function (){
        let value = $(this).val();

        if(parseInt(value)){
            $('#parent_value_text').css('display','block')
            $('.new_value_parent').remove();
            let say = $('.value_desc_td').length;
            for (let i=0; i<parseInt(say);i++){
                let value_id = $('.value_id').eq(i).val();
                $('#option_value_list tbody tr .value_desc_td').eq(i).after(`
                                            <td class="new_value_parent"><select eq=`+i+` class="form-control parent_option_select vl_`+value_id+`" multiple>

                                        </select></td>
                                            `);
            }

            $('#loading-box').removeClass('d-none');
            setTimeout(function() {
            let data = {
                crsf_token: crsf_hash,
                option_id: parseInt(value)
            }
                $.post(baseurl + 'productoption/info_options_value', data, (response) => {
                    let responses = jQuery.parseJSON(response);
                    $.each(responses.details, function (index, item) {
                        $('.parent_option_select').append(new Option(item.name, item.id, false, false));
                    });

                    for (let i=0; i<parseInt(say);i++){
                        let value_id = $('.value_id').eq(i).val()
                        let data_new = {
                            value_id: parseInt(value_id)
                        }
                        let ar=[];
                        $.post(baseurl + 'productoption/parent_value_get', data_new, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $.each(responses.details, function (index, item) {
                                ar.push(item.value_id);
                            });
                            $('.vl_'+parseInt(value_id)).val(ar.slice())
                        });

                    }


                });

                $('#loading-box').addClass('d-none');
            }, 5000);




        }
        else {
            $('.new_value_parent').remove();
            $('#parent_value_text').css('display','none')
        }
    })

    $(document).on('change','#parent_option_new',function (){
        let value = $(this).val();
        if(parseInt(value)){
            $('#parent_value_text_new').css('display','block');
            $('.new_value_parent').remove();
            let say = $('.value_desc_td').length;
            for (let i=0; i<parseInt(say);i++){
                $('#option_value_list tbody tr .value_desc_td').eq(i).after(`
                                <td class="new_value_parent"><select eq=`+i+` class="form-control parent_option_select" multiple>
                            </select></td>
                                            `);
            }
            $('#loading-box').removeClass('d-none');
            setTimeout(function() {
                let data = {
                    crsf_token: crsf_hash,
                    option_id: parseInt(value)
                }
                $.post(baseurl + 'productoption/info_options_value', data, (response) => {
                    let responses = jQuery.parseJSON(response);
                    $.each(responses.details, function (index, item) {
                        $('.parent_option_select').append(new Option(item.name, item.id, false, false));
                    });


                });

                $('#loading-box').addClass('d-none');
            }, 5000);

        }
        else {
            $('.new_value_parent').remove();
            $('#parent_value_text_new').css('display','none')
        }
    })


    $(document).on('click', '.delete', function() {
        let id = $(this).attr('product_option_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Silmek Üzeresiniz Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'sil',
                    btnClass: 'btn-blue',
                    action: function() {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            id: id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'productoption/delete', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.code == 200) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function() {
                                                $('#product_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        }

                                    }
                                });
                            } else {
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
                                    buttons: {
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
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click','.delete_line',function (){
        let delete_id = $(this).attr('delete_id');
        let obj=$(this);
        if(delete_id){
            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Sil',
                icon: 'fas fa-trash 3x',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-8 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: 'Silmek İstediğinizden Emin Misiniz?',

                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function() {
                            $('#loading-box').removeClass('d-none');

                            let data_post = {
                                delete_id: delete_id,
                            }
                            $.post(baseurl + 'productoption/delete_value', data_post, (response) => {
                                $('#loading-box').addClass('d-none');
                                let data = jQuery.parseJSON(response);
                                if (data.code == 200) {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: data.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                                action: function() {
                                                    obj.parent().parent().remove();
                                                }
                                            },
                                        }
                                    });
                                } else if (data.code == 410) {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: data.message,
                                        buttons: {
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
                    cancel: {
                        text: 'İmtina et',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },

                onContentReady: function() {


                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        }
        else {
            obj.parent().parent().remove();
        }



    })


</script>