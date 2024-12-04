<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Stok Giriş Çıkış Fişleri</span></h4>
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
                                        <table id="stockio" class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <th>Kod</th>
                                                <th>Tip</th>
                                                <th>Anbar</th>
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


    $(document).on('keyup', ".item_qty_update", function (e) {

        let val = $(this).val();
        let stock_io_id = $(this).attr('stock_io_id');
        let eq=$(this).parent().parent().index();
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
                    '<p>Miktarı Güncellemek Üzeresiniz Eminmisimiz? <p/>' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            jQuery.ajax({
                                url: baseurl + 'stockio/update_table',
                                dataType: "json",
                                method: 'post',
                                data: 'tip=1&val=' + val + '&stock_io_id=' + stock_io_id + '&' + crsf_token + '=' + crsf_hash,
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
                                                        $('#stockio').DataTable().destroy();
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
    })
    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })
    let  i = 0;
    $(document).ready(function () {

        $('.select2').select2();
        draw_data();

    });

    function draw_data(){
        $('#stockio').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': "<?php echo base_url(). 'stockio/ajax_list' ?>",
                'type': 'POST',
                'data': {}
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
                    text: '<i class="fa fa-plus"></i> Yeni Fiş Oluştur',
                            action: function ( e, dt, node, config ) {
                            stockio()
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i> Fiş Listemi Görüntüle',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Məhsul Fişi',
                            icon: 'fa fa-external-link-square-alt 3x',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:function ()
                            {
                                let self = this;
                                let html = `<form >
                        <div class="row">
                         <p class="test"></p>
                              <table id="result" class="table ">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Fistipi</th>
                                  <th scope="col">Anbar</th>
                                  <th scope="col">Mehsul</th>
                                  <th scope="col">Varyasyon</th>
                                  <th scope="col">Olcu vahidi</th>
                                  <th scope="col">Miqdar</th>
                                  <th scope="col">Aciqlama</th>
                                  <th scope="col">Sil</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                    </table>
                   `;
                                let data_post = {
                                    tip: 1,
                                }
                                $.post(baseurl + 'warehouse/get_cloud_list',data_post,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    let responses = jQuery.parseJSON(response);
                                    let i=1;
                                    responses.details.forEach((data,index) => {
                                        $("#result>tbody").append('<tr data-cloud_stock_id="'+data.id+'"  data-option-id="'+data.option_id+'" data-option-value-id="'+data.option_value_id+'"  data-unit_id="' + data.unit_id + '" data-qty_int="' + data.qty_int + '" data-fis_type="0" data-warehouse_id="' + data.warehouse_id + '" data-product_id="' + data.product_id + '"  id="remove' + i + '" class="result-row">' +
                                            '<td>' + i + '</td> ' +
                                            '<td>Çıkış</td>' +
                                            '<td>' + data.warehouse_name + '</td> ' +
                                            '<td>' + data.product_name + '</td>' +
                                            '<td>' + data.varyasyon_html + '</td>' +
                                            '<td>' + data.unit_name + '</td>' +
                                            '<td>' + data.qty + '</td>' +
                                           '<td> <input type="text" class="form-control desc" value=""  ></td>' +
                                            '<td> <button data-id="' + i + '" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                            '</tr>');
                                        i++;
                                    })
                                });
                                self.$content.find('#person-list').empty().append(html);
                                return $('#person-container').html();
                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Gondər',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let count = $('.result-row').length;
                                        let collection = [];

                                        for(let i=0;i<count;i++){
                                            let data = {
                                                fis_type: 0,
                                                cloud_stock_id: $('.result-row').eq(i).data('cloud_stock_id'),
                                                option_id: $('.result-row').eq(i).data('option-id'),
                                                unit_id: $('.result-row').eq(i).data('unit_id'),
                                                value_id: $('.result-row').eq(i).data('option-value-id'),
                                                warehouse_id: $('.result-row').eq(i).data('warehouse_id'),
                                                product_id: $('.result-row').eq(i).data('product_id'),
                                                qty: $('.result-row').eq(i).data('qty_int'),
                                                desc: $('.result-row .desc').eq(i).val(),
                                            }

                                            collection.push(data)
                                        }

                                        let data_post = {
                                            collection: collection,
                                        }

                                        $.post(baseurl + 'stockio/create_list_store',data_post,(response)=>{
                                            let data = jQuery.parseJSON(response);
                                            if(data.code==200){
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
                                                            action: function () {
                                                                table_product_id_ar = [];
                                                                $('#stockio').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            }
                                            else {
                                                $.alert({
                                                    theme: 'material',
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
                                cancel: {
                                    text: 'İmtina et',
                                    btnClass: "btn btn-danger btn-sm",
                                    action:function (){
                                        table_product_id_ar = [];
                                    }
                                }
                            },
                            onContentReady: function () {
                            }
                        });
                    }
                }

            ]
        });
    }


    $(document).on('click','.edit-stockio',function (){
        let talep_id = $(this).attr('data-id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Məhsul Fişi Düzenle',
            icon: 'fa fa-external-link-square-alt 3x',
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
                html += `<form >
                        <div class="row">
                             <div class="col-md-2">
                                <lable>Fiş tipi</lable>
                                <select id="type" class="form-control">
                                    <option value="1" data-name="Giris">Giriş</option>
                                    <option value="0" data-name="Cixis">Çıxış</option>
                                </select>
                             </div>
                             <div class="col-md-4">
                                 <lable>Anbar</lable>
                                <select id="warehouse"  class="form-control select-box warehouse">
                                <option value='0'>Anbar secin</option>
                                   <?php
                foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
                    echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                }
                ?>
                                </select>
                             </div>

                            <div class="col-md-2">
                                  <lable>Məhsul</lable>
                                  <select id="product" class="form-control product" disabled>

                                  </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="add-product" class="btn btn-primary mt-2 ">Ekle</buttton>
                              </div>
                        </div>

                     </form>
                     <p class="test"></p>
                          <table id="result" class="table ">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Fistipi</th>
                          <th scope="col">Anbar</th>
                          <th scope="col">Mehsul</th>
                          <th scope="col">Varyasyon</th>
                          <th scope="col">Güncel Stok Miqdarı</th>
                          <th scope="col">Olcu vahidi</th>
                          <th scope="col">Miqdar</th>
                          <th scope="col">Aciqlama</th>
                          <th scope="col">Sil</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                   `;

                let data = {
                    crsf_token: crsf_hash,
                    talep_id: talep_id,
                }

                let table_report='';
                $.post(baseurl + 'stockio/info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    let fis_name = 'Giriş';
                    if(!parseInt(responses.details.type)){
                        fis_name='Cixis';
                    }
                    $('#type').val(responses.details.type);
                    $('#warehouse').val(responses.details.warehouse_id).select2().trigger('change');
                    $('#project').val(responses.details.proje_id).select2().trigger('change');
                    let i=1;
                        responses.item.forEach((data) => {
                            let proje_name =data.project_name;
                            if(proje_name==null){
                                proje_name='-';
                            }

                            let option_details=[];
                            option_details.push({
                                'stock_code_id':data.product_stock_code_id
                            })

                            let varyasyon_name='';
                            if(data.product_stock_code_id){
                                let data_post = {
                                    crsf_token: crsf_hash,
                                    option_id: data.option_id,
                                    option_value_id:data.option_value_id,
                                    option_details:option_details
                                }
                                $.post(baseurl + 'stockio/varyasyon_name',data_post,(response)=> {
                                    let data_varyasyon = jQuery.parseJSON(response);
                                    if(data_varyasyon.code==200){
                                        varyasyon_name=data_varyasyon.varyasyon;
                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            id: data.pid,
                                            option_details: option_details,
                                            warehouse:responses.details.warehouse_id
                                        }
                                        $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                                            let data_res = jQuery.parseJSON(response);

                                            let units = '<select class="form-control select-box line_unit_id">';
                                            data_res.units.forEach((item,index) => {
                                                let selected='';
                                                if(data.unit_id==item.id){
                                                    selected='selected';
                                                }
                                                units+=`<option `+selected+` value="`+item.id+`">`+item.name+`</option>`;
                                            })
                                            units+='</select>';

                                            if (data_res.code == 200) {
                                                let stk_qt = parseFloat(data_res.result.qty);


                                                $("#result>tbody").append('<tr data-product_stock_code_id="'+data.product_stock_code_id+'" data-option-id="'+data.option_id+'" data-option-value-id="'+data.option_value_id+'"  data-unit_id="' + data.unit_id + '" data-fis_type="' + data.fis_type + '" data-warehouse_id="' + data.warehouse_id + '" data-project_id="' + data.project_id + '" data-product_id="' + data.product_id + '"  id="remove' + i + '" class="result-row">' +
                                                    '<td>' + i + '</td> ' +
                                                    '<td>' + fis_name + '</td>' +
                                                    '<td>' + data.warehouse + '</td> ' +
                                                    '<td>' + data.product_name + '</td>' +
                                                    '<td>' + varyasyon_name + '</td>' +
                                                    '<td>' + stk_qt + '</td>' +
                                                    '<td>' + units + '</td>' +
                                                    '<td> <input type="number" class="form-control qty" onkeyup="amount_max(this)" max="' + data_res.result.qty + '"  value="'+data.qty+'"></td>' +
                                                    '<td> <input type="text" class="form-control desc" value="' + data.item_desc + '"  ></td>' +
                                                    '<td> <button data-id="' + i + '" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                                    '</tr>');
                                                i++;
                                                setTimeout(function() {
                                                    $('.select-box').select2({
                                                        dropdownParent: $(".jconfirm")
                                                    })
                                                }, 1000);


                                            }
                                        })
                                    }
                                });
                            }
                            else {
                                let data_post = {
                                    crsf_token: crsf_hash,
                                    id: data.pid,
                                    warehouse:responses.details.warehouse_id
                                }
                                $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                                    let data_res = jQuery.parseJSON(response);

                                    if (data_res.code == 200) {
                                        let stk_qt = parseFloat(data_res.result.qty);
                                        let units = '<select class="form-control select-box line_unit_id">';
                                        data_res.units.forEach((item,index) => {
                                            let selected='';
                                            if(data.unit_id==item.id){
                                                selected='selected';
                                            }
                                            units+=`<option `+selected+` value="`+item.id+`">`+item.name+`</option>`;
                                        })
                                        units+='</select>';
                                        $("#result>tbody").append('<tr data-option-id="'+data.option_id+'" data-option-value-id="'+data.option_value_id+'"  data-unit_id="' + data.unit_id + '" data-fis_type="' + data.fis_type + '" data-warehouse_id="' + data.warehouse_id + '" data-project_id="' + data.project_id + '" data-product_id="' + data.product_id + '"  id="remove' + i + '" class="result-row">' +
                                            '<td>' + i + '</td> ' +
                                            '<td>' + fis_name + '</td>' +
                                            '<td>' + data.warehouse + '</td> ' +
                                            '<td>' + data.product_name + '</td>' +
                                            '<td>' + varyasyon_name + '</td>' +
                                            '<td>' + stk_qt + '</td>' +
                                            '<td>' + units + '</td>' +
                                            '<td> <input type="number" class="form-control qty" onkeyup="amount_max(this)" max="' + data_res.result.qty + '"  value="'+data.qty+'"></td>' +
                                            '<td> <input type="text" class="form-control desc" value="' + data.item_desc + '"  ></td>' +
                                            '<td> <button data-id="' + i + '" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                            '</tr>');
                                        i++;
                                    }
                                })
                            }


                        })
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let count = $('.result-row').length;
                        let collection = [];

                        for(let i=0;i<count;i++){
                            let data = {
                                unit_id: $('.line_unit_id').eq(i).val(),
                                option_id: $('.result-row').eq(i).data('option-id'),
                                product_stock_code_id: $('.result-row').eq(i).data('product_stock_code_id'),
                                value_id: $('.result-row').eq(i).data('option-value-id'),
                                fis_type: $('.result-row').eq(i).data('fis_type'),
                                warehouse_id: $('.result-row').eq(i).data('warehouse_id'),
                                product_id: $('.result-row').eq(i).data('product_id'),
                                qty: $('.result-row .qty').eq(i).val(),
                                desc: $('.result-row .desc').eq(i).val(),
                            }

                            collection.push(data)
                        }

                        let data_post = {
                            collection: collection,
                            id: talep_id,
                            proje_id: $('#project').val(),
                            warehouse_id: $('#warehouse').val(),
                            fis_type:  $('#type').val(),
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'stockio/store_update',data_post,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.code==200){
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
                                            action: function () {
                                                table_product_id_ar = [];
                                                $('#stockio').DataTable().destroy();
                                                draw_data();
                                            }
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
                    action:function (){
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function () {

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
                                warehouse_id: $('#warehouse').val(),
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

                $('.warehouse').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                $('.project').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
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


    function stockio() {

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Məhsul Fişi',
            icon: 'fa fa-external-link-square-alt 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form >
                        <div class="row">
                             <div class="col-md-2">
                                <lable>Fiş tipi</lable>
                                <select id="type" class="form-control">
                                    <option value="1" data-name="Giris">Giriş</option>
                                    <option value="0" data-name="Cixis">Çıxış</option>
                                </select>
                             </div>
                             <div class="col-md-4">
                                 <lable>Anbar</lable>
                                <select id="warehouse"  class="form-control select-box warehouse">
                                <option value='0'>Anbar secin</option>
                                   <?php
            foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
                echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
            }
            ?>
                                </select>
                             </div>

                            <div class="col-md-2">
                                  <lable>Məhsul</lable>
                                  <select id="product" class="form-control product" disabled>

                                  </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="add-product" class="btn btn-primary mt-2 ">Ekle</buttton>
                              </div>
                        </div>

                     </form>
                     <p class="test"></p>
                          <table id="result" class="table ">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Fistipi</th>
                          <th scope="col">Anbar</th>
                          <th scope="col">Mehsul</th>
                          <th scope="col">Varyasyon</th>
                          <th scope="col">Güncel Stok Miqdarı</th>
                          <th scope="col">Olcu vahidi</th>
                          <th scope="col">Miqdar</th>
                          <th scope="col">Aciqlama</th>
                          <th scope="col">Sil</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                   `,
            buttons: {

                formSubmit: {
                    text: 'Gondər',
                    btnClass: 'btn-blue',
                    action: function () {
                        let count = $('.result-row').length;
                        let collection = [];

                        for(let i=0;i<count;i++){
                            let data = {
                                unit_id: $('.line_unit_id').eq(i).val(),
                                option_id: $('.result-row').eq(i).data('option-id'),
                                value_id: $('.result-row').eq(i).data('option-value-id'),
                                fis_type: $('.result-row').eq(i).data('fis_type'),
                                warehouse_id: $('.result-row').eq(i).data('warehouse_id'),
                                product_id: $('.result-row').eq(i).data('product_id'),
                                product_stock_code_id: $('.result-row').eq(i).data('product_stock_code_id'),
                                qty: $('.result-row .qty').eq(i).val(),
                                desc: $('.result-row .desc').eq(i).val(),
                            }

                            collection.push(data)
                        }

                        let data_post = {
                            collection: collection,
                            proje_id: $('#project').val(),
                            warehouse_id: $('#warehouse').val(),
                            fis_type:  $('#type').val(),
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'stockio/store',data_post,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.code==200){
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
                                            action: function () {
                                                table_product_id_ar = [];
                                                $('#stockio').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else {
                                $.alert({
                                    theme: 'material',
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
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function () {

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
                                warehouse_id: $('#warehouse').val(),
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

                $('.warehouse').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                $('.project').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
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


    $(document).on('change','.warehouse', function () {

        let id = $('.warehouse').val();
        if(parseInt(id)){
            $('#product').attr('disabled',false);
        }
        else {
            $('#product').attr('disabled',true);
        }
    })
    let table_product_id_ar = [];
    $(document).on('click','#add-product',function(){

        let product_id = $("#product").val();
        let warehouse = $("#warehouse").val();
        let varyasyon_durum=false;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Varyasyonlar',
            icon: 'fa fa-filter',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    product_id: product_id
                }

                let table_report='';
                $.post(baseurl + 'malzemetalep/get_product_to_value',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);




                    $('.list').empty().html(responses.html)
                    if(responses.code==200){
                        varyasyon_durum=true;
                    }
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let option_details=[];
                        if(varyasyon_durum){
                            $('.option-value:checked').each((index,item) => {
                                // option_details.push({
                                //     'option_id':$(item).attr('data-option-id'),
                                //     'option_name':$(item).attr('data-option-name'),
                                //     'option_value_id':$(item).attr('data-value-id'),
                                //     'option_value_name':$(item).attr('data-option-value-name'),
                                // })

                                option_details.push({
                                    'stock_code_id':$(item).attr('stock_code_id'),
                                })
                            });
                        }
                        else {


                        }
                        i++;
                        let proje_name = '-';
                        if($("#project").find(':selected').data('name')!==undefined){
                            proje_name = $("#project").find(':selected').data('name');
                        }
                        let data_post = {
                            crsf_token: crsf_hash,
                            id: product_id,
                            warehouse:warehouse,
                            option_details:option_details
                        }
                        let data='';
                        let result=false;
                        let sayi=0;
                        $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                            let data_res = jQuery.parseJSON(response);

                            let units = '<select class="form-control select-box line_unit_id">';
                            data_res.units.forEach((item,index) => {
                                units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                            })
                            units+='</select>';

                            if (data_res.code == 200) {
                                data = {
                                    qty:          data_res.result.qty,
                                    unit_id:      data_res.result.unit_id,
                                    fis_type:     $("#type").val(),
                                    fis_name:     $("#type").find(':selected').data("name"),
                                    unit_name:    data_res.result.unit_name,
                                    warehouse_id: $("#warehouse").val(),
                                    anbar_name:   $("#warehouse").find(':selected').data('name'),
                                    product_id:   data_res.result.product_id,
                                    varyasyon_name:   data_res.result.varyasyon_name,
                                    product_stock_code_id:   data_res.result.product_stock_code_id,
                                    product_name: data_res.result.product_name,
                                    option_details: option_details

                                }

                                if(!result){
                                    let varyasyon_html='';
                                    let option_id_data='';
                                    let product_stock_code_id=0;
                                    let option_value_id_data='';
                                    if(data.product_stock_code_id){
                                        product_stock_code_id = option_details[0].product_stock_code_id;
                                    }

                                    $("#result>tbody").append('<tr data-product_stock_code_id="'+data_res.result.product_stock_code_id+'" data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-unit_id="'+data.unit_id+'" data-fis_type="'+data.fis_type+'" data-warehouse_id="'+data.warehouse_id+'" data-project_id="'+data.project_id+'" data-product_id="'+data.product_id+'"  id="remove'+i+'" class="result-row">' +
                                        '<td>'+i+'</td> ' +
                                        '<td>'+ data.fis_name+'</td>' +
                                        '<td>'+ data.anbar_name +'</td> ' +
                                        '<td>'+ data.product_name +'</td>' +
                                        '<td>'+ data.varyasyon_name +'</td>' +
                                        '<td>'+data.qty+'</td>' +
                                        '<td>'+units+'</td>' +
                                        '<td> <input type="number" class="form-control qty" onkeyup="amount_max(this)" max="'+data.qty+'"  value="0"></td>' +
                                        '<td> <input type="text" class="form-control desc "  ></td>' +
                                        '<td> <button data-id="'+i+'" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                        '</tr>' );
                                            setTimeout(function() {
                                                $('.select-box').select2({
                                                    dropdownParent: $(".jconfirm")
                                                })
                                            }, 1000);
                                    table_product_id_ar.push({
                                        product_id : data.product_id,
                                        product_options:data.option_details,
                                        product_stock_code_id:data.product_stock_code_id,
                                    });
                                }
                                else {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Ürün Daha Önceden Eklenmiştir',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }

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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })
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
    $(document).on('click','.remove' ,function(){
        let remove = '#remove'+ $(this).data('id')
        $(remove).remove();
    })



    function amount_max(obj){

        let tip = $('#type').val();
        if(parseInt(tip)==0){
            let max = $(obj).attr('max');
            if(parseFloat($(obj).val())>parseFloat(max)){
                $(obj).val(parseFloat(max))
                return false;
            }
        }

    }

    $(document).on('click','.cancel-stockio' ,function(){
        let stock_io_id = $(this).data('id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İptal Etmek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            stock_io_id:stock_io_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'stockio/delete_file',data,(response)=>{
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
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                $('#stockio').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
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
                                    content:  responses.message,
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


    //file
    $(document).on('click','.file-stockio',function (){
        let stok_id = $(this).data('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dosyalar',
            icon: 'fa fa-file',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `
<table class="table">
    <thead>
        <tr>
            <th>Dosya Adı</th>
            <th>Dosya</th>
            <th>Yüklenen Dosya Adı</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input class="form-control file_name"></td>
            <td>
<input type="file" name="files[]" id="fileupload_update">
<input type="hidden" id="image_text_update">
</td>
<td>
 <span class="file_text_span badge bg-yellow text-black"></span>
</td>
        </tr>
    </tbody>
</table>
<div class="col-md-12"><button class='btn btn-success' stock_io_id='`+stok_id+`' id="new_file">Ekle</button></div>
<hr>
<h3>Yüklenen Dosyalar</h3>
<table class="table" id='file_list'>
    <thead>
        <tr>
            <th>No</th>
            <th>Dosya Adı</th>
            <th>Yükleme Yapan Personel</th>
            <th>Yükleme Tarihi</th>
            <th>Dosya</th>
            <th>İslem</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
`;
                let data = {
                    crsf_token: crsf_hash,
                    stok_id: stok_id,
                }

                let table_report='';
                $.post(baseurl + 'projestoklari/stokdetails',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.tip_select').val(responses.item.type).trigger('change');
                    $('#warehouse_select').val(responses.item.warehouse_id).trigger('change');
                    $('#personel_id_select').val(responses.item.pers_id).trigger('change');


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
                    dropdownParent: $(".jconfirm")
                })

                $('#file_list').DataTable().destroy();
                file_list_data(stok_id);

                var url = '<?php echo base_url() ?>projestoklari/file_handling';
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
                        $('.file_text_span').empty().text(img);
                    },
                    progressall: function (e, data) {
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
    //file

    //file_list
    function file_list_data(stok_id) {
        $('#file_list').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('projestoklari/ajax_stok_fis_list_file')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'stok_id':stok_id}
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
                }
            ]
        });
    }
    //file_list

    //new_file
    $(document).on('click','#new_file',function (){
        let file_name =  $('.file_name').val();
        let file =  $('#image_text_update').val();
        let stock_io_id =  $(this).attr('stock_io_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dosya Ekleme',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Dosyayı Eklemek üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Yükle',
                    btnClass: 'btn-blue',
                    action: function () {
                        if(!file_name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Dosya Adı Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        if(!file){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Dosya Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        if(!file_name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Dosya Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        $('#loading-box').removeClass('d-none');
                        let data = {
                            stock_io_id:stock_io_id,
                            file_name:file_name,
                            file:file,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'projestoklari/insert_file_fis',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
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
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                $('.file_name').val('')
                                                $('#image_text_update').val('')
                                                $('.file_text_span').text('')
                                                $('#file_list').DataTable().destroy();
                                                file_list_data(stock_io_id);
                                            }
                                        }
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
                                    content:  responses.message,
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
    //new_file


    //file_uploda

    //file_uploda

    // file delete
    $(document).on('click','.cancel-stockio-file' ,function(){
        let stok_id = $(this).data('id');
        let stock_io_id = $(this).data('stock_io_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Silmek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            stok_id:stok_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'projestoklari/delete_fis_file',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
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
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                $('#file_list').DataTable().destroy();
                                                file_list_data(stock_io_id);
                                            }
                                        }
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
                                    content:  responses.message,
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
    //delete




</script>
