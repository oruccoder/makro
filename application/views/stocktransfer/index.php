<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Stok Transfer</span></h4>
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
                                                    <th>Çıxış Anbarı</th>
                                                    <th>Giriş Anbarı</th>
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

<script>
    $(document).ready(function () {

        $('.select2').select2();
        draw_data();

    });

    let in_warehouse=0;
    let out_warehouse=0;
    let product_option_details=[];
    let table_product_id_ar=[];
    let option_details=[];
    let i=0;
    function draw_data(){
        $('#stockio').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': "<?php echo base_url(). 'stocktransfer/ajax_list' ?>",
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
                    text: '<i class="fa fa-plus"></i> Yeni Transfer Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Məhsul Transfer Fişi',
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
                             <div class="col-md-6">
                                 <lable>Çıxış Anbarı</lable>
                                <select class="form-control select-box out_warehouse">
                                <option value='0'>Çıxış Anbarı</option>
                                   <?php
                            foreach (all_warehouse() as $item) {
                                echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                            }
                            ?>
                                </select>
                             </div>
                               <div class="col-md-6">
                                 <lable>Giriş Anbarı</lable>
                                <select class="form-control select-box in_warehouse">
                                <option value='0'>Giriş Anbarı</option>
                                   <?php
                            foreach (all_warehouse() as $item) {
                                echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                            }
                            ?>
                                </select>
                             </div>

                        </div>
                     </form>
                   `,
                            buttons: {
                                formSubmit: {
                                    text: 'Devam',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        in_warehouse = $('.in_warehouse').val();
                                        out_warehouse= $('.out_warehouse').val();
                                        if(!parseInt(in_warehouse)){
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Giriş Deposu Seçmek Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        if(!parseInt(out_warehouse)){
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Çıxış Deposu Seçmek Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        $.confirm({
                                            theme: 'modern',
                                            closeIcon: false,
                                            title: 'Məhsul Transfer Fişi',
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
                                                            <div class="col-md-10">
                                                                  <lable>Məhsul</lable>
                                                                  <select id="product" class="form-control product">

                                                                  </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" id="add-product" class="btn btn-primary mt-2 ">Ekle</buttton>
                                                              </div>
                                                        </div>
                                                     </form>
                                                     <p class="test"></p>
                                                          <table id="result" class="table ">
                                                      <thead>
                                                        <tr>
                                                          <th scope="col">#</th>
                                                          <th scope="col">Mehsul</th>
                                                          <th scope="col">Güncel Stok Miqdarı</th>
                                                          <th scope="col">Olcu vahidi</th>
                                                          <th scope="col">Miqdar</th>
                                                          <th scope="col">Aciqlama</th>
                                                          <th scope="col">Sil</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>

                                                      </tbody>
                                                    </table>`,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Gondər',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        let count = $('.result-row').length;
                                                        let collection = [];

                                                        for(let i=0;i<count;i++){
                                                            let data = {
                                                                unit_id: $('.result-row').eq(i).data('unit_id'),
                                                                value_id: $('.result-row').eq(i).data('value_id'),
                                                                product_id: $('.result-row').eq(i).data('product_id'),
                                                                qty: $('.qty').eq(i).val(),
                                                                desc: $('.desc').eq(i).val(),
                                                            }

                                                            collection.push(data)
                                                        }

                                                        let data_post_new = {
                                                            collection: collection,
                                                            in_warehouse: in_warehouse,
                                                            out_warehouse: out_warehouse,
                                                            crsf_token: crsf_hash,
                                                        }


                                                        $.post(baseurl + 'stocktransfer/create',data_post_new,(response)=>{
                                                            let data = jQuery.parseJSON(response);
                                                            if(data.status==200){
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
                                                            else if(data.status==410) {
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
                                                                warehouse_id: out_warehouse,
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
                                                this.$content.find('form').on('submit', function (e) {
                                                    // if the user submits the form by pressing enter in the field.
                                                    e.preventDefault();
                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                });
                                            }
                                        });
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



                                $('.select-box').select2({
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
                }
            ]
        });
    }

    $(document).on('click','.edit',function () {
        let transfer_id = $(this).attr('transfer_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Məhsul Transfer Fişi',
            icon: 'fa fa-external-link-square-alt 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function (){
                let self=this;
                let html=`<form>
                        <div class="row">
                             <div class="col-md-6">
                                 <lable>Çıxış Anbarı</lable>
                                <select class="form-control select-box out_warehouse">
                                <option value='0'>Çıxış Anbarı</option>
                                   <?php
                foreach (all_warehouse() as $item) {
                    echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                }
                ?>
                                </select>
                             </div>
                               <div class="col-md-6">
                                 <lable>Giriş Anbarı</lable>
                                <select class="form-control select-box in_warehouse">
                                <option value='0'>Giriş Anbarı</option>
                                   <?php
                foreach (all_warehouse() as $item) {
                    echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                }
                ?>
                                </select>
                             </div>

                        </div>
                     </form>
                   `;
                let data = {
                    crsf_token: crsf_hash,
                    transfer_id: transfer_id,
                }
                $.post(baseurl + 'stocktransfer/info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.in_warehouse').val(responses.details.in_warehouse_id).select2().trigger('change');
                    $('.out_warehouse').val(responses.details.out_warehouse_id).select2().trigger('change');

                })
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        in_warehouse = $('.in_warehouse').val();
                        out_warehouse= $('.out_warehouse').val();
                        if(!parseInt(in_warehouse)){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Giriş Deposu Seçmek Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        if(!parseInt(out_warehouse)){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Çıxış Deposu Seçmek Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Məhsul Transfer Fişi',
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
                                let html=`<form>
                                            <div class="row">
                                                    <div class="col-md-10">
                                                          <lable>Məhsul</lable>
                                                          <select id="product" class="form-control product">

                                                          </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" id="add-product" class="btn btn-primary mt-2 ">Ekle</buttton>
                                                      </div>
                                                </div>
                                             </form>
                                             <p class="test"></p>
                                                  <table id="result" class="table ">
                                              <thead>
                                                <tr>
                                                  <th scope="col">#</th>
                                                  <th scope="col">Mehsul</th>
                                                  <th scope="col">Güncel Stok Miqdarı</th>
                                                  <th scope="col">Olcu vahidi</th>
                                                  <th scope="col">Miqdar</th>
                                                  <th scope="col">Aciqlama</th>
                                                  <th scope="col">Sil</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                            </table>`;
                                let data = {
                                    crsf_token: crsf_hash,
                                    transfer_id: transfer_id,
                                }

                                let table_report='';
                                $.post(baseurl + 'stocktransfer/info',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    let responses = jQuery.parseJSON(response);
                                    let i=1;
                                    responses.details_items.forEach((data) => {


                                        let option_details=[];
                                        if(data.option_value_id){
                                            option_details.push({
                                                'option_id': data.option_id,
                                                'option_value_id': data.option_value_id,
                                            })
                                        }

                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            id: data.product_id,
                                            option_details: option_details,
                                            warehouse:responses.details.out_warehouse_id
                                        }
                                        $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                                            let data_res = jQuery.parseJSON(response);
                                            if (data_res.code == 200) {
                                                let stk_qt = parseFloat(data_res.result.qty);
                                                let value_id='';
                                                if(data_res.result.option_details)
                                                {
                                                    value_id=data_res.result.option_details[0].option_value_id
                                                }
                                                $("#result>tbody").append('<tr data-unit_id="'+data_res.result.unit_id+'" data-product_id="'+data_res.result.product_id+'"  data-value_id="'+value_id+'" id="remove'+i+'" class="result-row">' +
                                                    '<td>' + i + '</td> ' +
                                                    '<td>' + data_res.result.product_name + '<br>'+data_res.result.option_value_name+'</td>' +
                                                    '<td>' + stk_qt + '</td>' +
                                                    '<td>' + data_res.result.unit_name + '</td>' +
                                                    '<td> <input type="number" class="form-control qty" onkeyup="amount_max(this)" max="' + data_res.result.qty + '"  value="'+data.qty+'"></td>' +
                                                    '<td> <input type="text" class="form-control desc" value="' + data.desc + '"  ></td>' +
                                                    '<td> <button data-id="' + i + '" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                                    '</tr>');
                                                i++;
                                            }
                                        })
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
                                                unit_id: $('.result-row').eq(i).data('unit_id'),
                                                value_id: $('.result-row').eq(i).data('value_id'),
                                                product_id: $('.result-row').eq(i).data('product_id'),
                                                qty: $('.qty').eq(i).val(),
                                                desc: $('.desc').eq(i).val(),
                                            }

                                            collection.push(data)
                                        }

                                        let data_post_new = {
                                            collection: collection,
                                            in_warehouse: in_warehouse,
                                            out_warehouse: out_warehouse,
                                            transfer_id: transfer_id,
                                            crsf_token: crsf_hash,
                                        }
                                        $.post(baseurl + 'stocktransfer/update',data_post_new,(response)=>{
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
                                            else if(data.code==410) {
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
                                                warehouse_id: out_warehouse,
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
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
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

                $('.select-box').select2({
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


    $(document).on('click','#add-product',function(){
        i++;
        product_option_details=[];
        option_details=[];
        let product_id = $("#product").val();
        let warehouse = out_warehouse;
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
                    product_id: product_id,
                    warehouse_id:warehouse
                }

                let table_report='';
                $.post(baseurl + 'warehouse/get_product_to_value_warehouse',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.list').empty().html(responses.html)
                    if(responses.code==200){
                        varyasyon_durum=responses.varyasyonstatus;
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

                        if(varyasyon_durum){
                            $('#loading-box').removeClass('d-none');
                            if($('.option-value:checked')){
                                product_option_details.push({
                                    'option_value_id':$('.option-value:checked').attr('data-value-id'),
                                    'option_value_name':$('.option-value:checked').attr('str'),
                                    'kalan':$('.option-value:checked').attr('max'),
                                })
                            }
                        }
                        else {
                            product_option_details.push({
                                'option_value_id':'',
                                'option_value_name':'',
                                'kalan':$('.option-value:checked').attr('max'),
                            })
                        }
                        setTimeout(function(){
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm")
                            })
                            $('#loading-box').addClass('d-none');
                        }, 1000);

                        let data_post = {
                            crsf_token: crsf_hash,
                            id: product_id,
                            warehouse:warehouse
                        }

                        let data='';
                        let result=false;
                        $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                            let data_res = jQuery.parseJSON(response);

                            if(table_product_id_ar){
                                result = table_product_id_ar.find( ({ product_id }) => product_id === data_res.result.product_id );
                            }
                            if (data_res.code == 200) {
                                data = {
                                    qty:          data_res.result.qty,
                                    unit_id:      data_res.result.unit_id,
                                    unit_name:    data_res.result.unit_name,
                                    warehouse_id: $(".out_warehouse").val(),
                                    anbar_name:   $(".out_warehouse").find(':selected').data('name'),
                                    product_id:   data_res.result.product_id,
                                    product_name: data_res.result.product_name,

                                }

                                let value_id='';
                                let value_text='';
                                let max=0;
                                option_details_  = product_option_details;
                                if(varyasyon_durum){
                                    value_text = option_details_[0].option_value_name;
                                    value_id = option_details_[0].option_value_id;
                                    max = option_details_[0].kalan;
                                }
                                else {
                                    value_text = '';
                                    value_id = '';
                                    max = data_res.result.qty;
                                }


                                    $("#result>tbody").append('<tr data-unit_id="'+data.unit_id+'"data-product_id="'+data.product_id+'"  data-value_id="'+value_id+'" id="remove'+i+'" class="result-row">' +
                                        '<td>'+i+'</td> ' +
                                        '<td>'+ data.product_name +value_text+'</td>' +
                                        '<td>'+max+'</td>' +
                                        '<td>'+data.unit_name+'</td>' +
                                        '<td> <input type="number" class="form-control qty" onkeyup="amount_max(this)" max="'+max+'"  value="0"></td>' +
                                        '<td> <input type="text" class="form-control desc "  ></td>' +
                                        '<td> <button data-id="'+i+'" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                        '</tr>' );
                                    table_product_id_ar.push({product_id : data.product_id });

                                // else {
                                //     $.alert({
                                //         theme: 'material',
                                //         icon: 'fa fa-exclamation',
                                //         type: 'red',
                                //         animation: 'scale',
                                //         useBootstrap: true,
                                //         columnClass: "col-md-4 mx-auto",
                                //         title: 'Dikkat!',
                                //         content: 'Ürün Daha Önceden Eklenmiştir',
                                //         buttons:{
                                //             prev: {
                                //                 text: 'Tamam',
                                //                 btnClass: "btn btn-link text-dark",
                                //             }
                                //         }
                                //     });
                                // }

                            }
                        })


                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        $('#loading-box').removeClass('d-none');
                        setTimeout(function(){
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm")
                            })
                            $('#loading-box').addClass('d-none');
                        }, 1000);
                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
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


    function amount_max(obj){
        let max = $(obj).attr('max');
        if(parseFloat($(obj).val())>parseFloat(max)){
            $(obj).val(parseFloat(max))
            return false;
        }

    }

    $(document).on('click','.remove' ,function(){
        let remove = '#remove'+ $(this).data('id')
        $(remove).remove();
        i--;
    })

    $(document).on('click', ".bildirim_olustur", function (e) {
        let talep_id = $(this).attr('transfer_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-bell',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Oluşturduğunuz Formu Onaya Sunmak Üzeresiniz Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Bildirim Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id: talep_id,
                        }
                        $.post(baseurl + 'stocktransfer/bildirim_olustur',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
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
                                            action: function () {
                                                $('#stockio').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

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


</script>
