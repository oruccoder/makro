<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Proje Stokları</span></h4>
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
                'url': "<?php echo site_url('projestoklari/ajax_stok_fis_list')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'status_id':1}
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
                    text: '<i class="fa fa-plus"></i> Fiş Listemi Getir',
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
 <div class="col-md-2">
                                 <lable>Personel / Cari</lable>
                                <select  class="form-control select-box cari_pers_type">
                                <option value='0'>Tip Seçinz</option>
                                <option value='1'>Cari</option>
                                <option value='2'>Personel</option>
                                </select>
                             </div>
                             <div class="col-md-4">
                                 <lable>Sorumlu Personel</lable>
                                <select id="personel_id_select" class="form-control select-box personel_id_select">
                                <option value='0'>Cari / Personel Tipi Seçiniz</option>
                                </select>
                             </div>
</div>
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
                                  <th scope="col">Proje&nbsp;<button type="button" class="proje_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                  <th scope="col">Proje Bölümü&nbsp;<button type="button" class="bolum_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                  <th scope="col">Proje Aşaması&nbsp;<button type="button" class="asama_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                  <th scope="col">Aciqlama</th>
                                  <th scope="col">Sil</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                    </table>
                   `;
                                let data_post = {
                                    tip: 2,
                                }
                                $.post(baseurl + 'warehouse/get_cloud_list',data_post,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    let responses = jQuery.parseJSON(response);
                                    let i=1;
                                    responses.details.forEach((data,index) => {
                                        $("#result>tbody").append(`<tr data-product_stock_code_id="`+data.product_stock_code_id+`" data-cloud_stock_id="`+data.id+`"  data-option-id="`+data.option_id+`" data-option-value-id="`+data.option_value_id+`"  data-unit_id="` + data.unit_id + `" data-qty_int="` + data.qty_int + `" data-fis_type="0" data-warehouse_id="` + data.warehouse_id + `" data-product_id="` + data.product_id + `"  id="remove` + i + `" class="result-row">` +
                                            `<td>` + i + `</td> ` +
                                            `<td>Çıkış</td>` +
                                            `<td>` + data.warehouse_name + `</td> ` +
                                            `<td>` + data.product_name + `</td>` +
                                            `<td>` + data.varyasyon_html + `</td>` +
                                            `<td>` + data.unit_name + `</td>` +
                                            `<td>` + data.qty + `</td>` +
                                            `<td><select index_="`+index+`"  class="form-control select-box line_project_id_list">`+
                                            `<option value="0">Lahiyə secin</option>
                                                    <?php
                                                    foreach (all_projects() as $item) {
                                                        echo "<option data-name='$item->name' value='$item->id'>$item->code</option>";
                                                    }
                                                    ?>
                                                </select></td>
                                                 <td><select class="form-control bolum_id select-box"  index_='`+index+`' ></select></td>
                                                 <td><select class="form-control asama_id select-box" index_='`+index+`' ></select></td>
                                                <td><input type="text" class="form-control desc" value=""></td>
                                              <td><button stok_id='`+i+`' class="btn btn-danger btn-sm delete-stok"><i class='fa fa-trash'></i></button></td>
                                                </tr>`);
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
                                        let file_name=$('.cari_pers_type').val();
                                        if(!parseInt(file_name)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Cari veya Personel',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        let count = $('.result-row').length;
                                        let collection = [];
                                        let proje_bs=0;
                                        let bolum_bs=0;

                                        for(let i=0;i<count;i++){
                                            let data = {
                                                fis_type: 0,
                                                cloud_stock_id: $('.result-row').eq(i).data('cloud_stock_id'),
                                                product_stock_code_id: $('.result-row').eq(i).data('product_stock_code_id'),
                                                option_id: $('.result-row').eq(i).data('option-id'),
                                                unit_id: $('.result-row').eq(i).data('unit_id'),
                                                value_id: $('.result-row').eq(i).data('option-value-id'),
                                                warehouse_id: $('.result-row').eq(i).data('warehouse_id'),
                                                product_id: $('.result-row').eq(i).data('product_id'),
                                                qty: $('.result-row').eq(i).data('qty_int'),
                                                product_desc: $('.result-row .desc').eq(i).val(),
                                                proje_id: $('.result-row .line_project_id_list').eq(i).val(),
                                                bolum_id: $('.result-row .bolum_id').eq(i).val(),
                                                asama_id: $('.result-row .asama_id').eq(i).val(),
                                            }
                                            if(!$('.result-row .bolum_id').eq(i).val()){
                                                bolum_bs=1;
                                            }
                                            if(!$('.result-row .line_project_id_list').eq(i).val()){
                                                proje_bs=1;
                                            }
                                            if(!parseInt($('.result-row .line_project_id_list').eq(i).val())){
                                                proje_bs=1;
                                            }
                                            if(!parseInt($('.result-row .bolum_id').eq(i).val())){
                                                bolum_bs=1;
                                            }

                                            collection.push(data)
                                        }


                                        if(parseInt(proje_bs)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Proje Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        if(parseInt(bolum_bs)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Bölüm Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }


                                        let data_post = {
                                            collection: collection,
                                            cari_pers_type:$('.cari_pers_type').val(),
                                            pers_id:$('#personel_id_select').val(),
                                        }

                                        $.post(baseurl + 'projestoklari/create_fis_cloud',data_post,(response)=>{
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
                                                                $('#invoices').DataTable().destroy();
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
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm")
                                })
                            }
                        });

                    }
                }
            ]
        });
    }

    $(document).on('change', ".line_project_id_list", function (e) {
        let eq=$(this).attr('index_');
        $('.bolum_id[index_='+eq+'] option').remove()
        var proje_id = $(this).val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projects/bolumler_list_ajax',
            data:'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {$('.bolum_id').eq(eq).append($('<option>').val(0).text('Seçiniz'));
                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $(".bolum_id").eq(eq).append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });
    $(document).on('change', ".bolum_id", function (e) {
        let eq=$(this).attr('index_');
        $('.asama_id[index_='+eq+'] option').remove()
        var bolum_id = $(this).val();
        var proje_id = $('.line_project_id_list').eq(eq).val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projects/asamalar_list',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('.asama_id').eq(eq).append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $(".asama_id").eq(eq).append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });



    $(document).on('click','.proje_all',function (){
        let temin_date = $('.line_project_id_list').eq(0).val();
        if(temin_date){

            $('.line_project_id_list').val(temin_date).select2().trigger('change');

            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
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
                content: '1. Satırda Proje Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })
    $(document).on('click','.bolum_all',function (){
        let temin_date = $('.bolum_id').eq(0).val();
        if(temin_date){
            $('.bolum_id').val(temin_date).select2().trigger('change');

            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
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
                content: '1. Satırda Bölüm Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })

    $(document).on('click','.asama_all',function (){
        let progress_status_id = $('.asama_id').eq(0).val();
        if(progress_status_id){
            $('.asama_id').val(progress_status_id).select2().trigger('change');
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
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
                content: '1. Satırda Aciliyet Durumu Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })


    let product_option_details=[];
    let option_details=[];
    let table_product_id_ar = [];
    $(document).on('change','.product',function (){
        let tip = $('#type').val();
        product_option_details=[];
        option_details=[];
        let varyasyon_durum=false;
        if( parseInt(tip)==0){
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
                        product_id: $('.product').val(),
                        warehouse_id:$('#warehouse').val()
                    }

                    let table_report='';
                    $.post(baseurl + 'warehouse/get_product_to_value_warehouse',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        $('.list').empty().html(responses.html)
                        varyasyon_durum=responses.varyasyonstatus;
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
        }
        else {
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
                        product_id: $('.product').val()
                    }

                    let table_report='';
                    $.post(baseurl + 'malzemetalep/get_product_to_value',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        $('.list').empty().html(responses.html)
                        if(responses.code==200){
                            varyasyon_durum=true;
                        }
                        else {
                            varyasyon_durum=false;
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
                            $('#loading-box').removeClass('d-none');
                            if(varyasyon_durum){
                                $('.option-value:checked').each((index,item) => {
                                    option_details.push({
                                        'option_id':$(item).attr('data-option-id'),
                                        'option_name':$(item).attr('data-option-name'),
                                        'option_value_id':$(item).attr('data-value-id'),
                                        'option_value_name':$(item).attr('data-option-value-name'),
                                    })
                                });

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
        }


    })
    let mt_index=0;
    $(document).on('change','.line_project_id',function (){
        let proje_id = $(this).val();
        let tip = $('#type').val();
        let warehouse_id = $('#warehouse').val()
        let personel_id = $('#personel_id').val()
        let cari_pers_type = $('#cari_pers_type').val()
        let varyasyon_durum=false;
        let product_id = $('.product').val();
        if(proje_id!=0){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Proje Bölüm Ve Aşamaları',
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
                        proje_id: proje_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'projestoklari/get_proje_bolum_asama',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        $('.list').empty().html(responses.html)

                        if(responses.code==200){
                            varyasyon_durum=true;
                        }
                    else{
                            varyasyon_durum=false;
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
                            let proje_details=[];
                            let asama_id=0;
                            let bolum_id=0;
                            let asama_kontrol  = $('.asama_radio').length;
                            bolum_id = $('.bolum_radio:checked').data('bolum-id');

                            if($('.bolum_radio:checked').length){
                                if(asama_kontrol){
                                    if($('.asama_radio:checked').length){
                                        asama_id = $('.asama_radio:checked').data('asama-id');
                                        proje_details_create(product_id,bolum_id,asama_id,tip,warehouse_id,proje_id,personel_id,cari_pers_type)
                                        mt_index++;
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
                                            content: 'Aşama Seçmek Zorunludur',
                                            buttons:{
                                                prev: {
                                                    text: 'Tamam',
                                                    btnClass: "btn btn-link text-dark",
                                                }
                                            }
                                        });
                                        return false;
                                    }
                                }
                                else {
                                    proje_details_create(product_id,bolum_id,asama_id,tip,warehouse_id,proje_id,personel_id,cari_pers_type)
                                    mt_index++;
                                }
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
                                    content: 'Bölüm Seçmek Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }



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
        }



    })
    function proje_details_create(product_id,bolum_id,asama_id,tip,warehouse_id,proje_id,personel_id,cari_pers_type){
        $('.product').empty();
        let option_details_= [];
        $('.line_project_id').val(0).trigger('change',false,false);
        if( parseInt(tip) == 0 ){
             option_details_  = product_option_details;
        }
        else {
            let value_id='';
            let str='<p>';
            option_details_=[];
            let last = (option_details.length)-1;
               for (let i = 0; i < option_details.length;i++){
                   if(i===last){
                       value_id+=option_details[i].option_value_id;
                       str+=option_details[i].option_value_name;
                   }
                   else {
                       value_id+=option_details[i].option_value_id+',';
                       str+=option_details[i].option_value_name+',';
                   }
               }
            str+='</p>';

            option_details_.push({
                'option_value_id':value_id,
                'option_value_name':str,
                'kalan':0
            });
        }

        let value_text = option_details_[0].option_value_name;
        let value_id = option_details_[0].option_value_id;
        let max = option_details_[0].kalan;
        let data = {
            product_id:product_id,
            bolum_id:bolum_id,
            asama_id:asama_id,
            tip:tip,
            warehouse_id:warehouse_id,
            proje_id:proje_id,
            personel_id:personel_id,
            cari_pers_type:cari_pers_type,
        }
        $.post(baseurl + 'projestoklari/add_product_details',data,(response)=>{
            $('#loading-box').removeClass('d-none');
            let responses = jQuery.parseJSON(response);
            let units = '<select class="form-control select-box line_unit_id">';
            responses.unit.forEach((item,index) => {
                units+=`<option value="`+item.id+`">`+item.name+`</option>`;
            })
            units+='</select>';


            let table=`<tr  id="remove`+mt_index+`" fis_type='`+tip+`' cari_pers_type='`+cari_pers_type+`' proje_id='`+proje_id+`' personel_id='`+personel_id+`' warehouse_id='`+warehouse_id+`' product_id='`+product_id+`' option_value_id='`+value_id+`' bolum_id='`+bolum_id+`' asama_id='`+asama_id+`' >
                        <td>`+mt_index+`</td>
                        <td><p>`+responses.tip_name+`</td>
                        <td><p>`+responses.personel_name+`</td>
                        <td><p>`+responses.warehouse_name+`</td>
                        <td><p>`+responses.product_name+`</p><span style="font-size: 12px;">`+value_text+`</span></td>
                        <td>`+responses.proje_name+`</br><span style="font-size: 12px;">`+responses.bolum_name+`</br>`+responses.asama_name+`</span></td>
                        <td><input type="number" value="0" onkeyup="amount_max(this)" max='`+max+`' class="form-control line_qty"></td>
                        <td>`+units+`</td>
                        <td><input type="text" class="form-control line_desc"></td>
                        <td><button stok_id='`+mt_index+`' class="btn btn-danger btn-sm delete-stok"><i class='fa fa-trash'></i></button></td>
             </tr>`;
            $('#result tbody').append(table);

            setTimeout(function(){
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })
                $('#loading-box').addClass('d-none');
            }, 1000);

        })

    }

    $(document).on('change', ".cari_pers_type", function (e) {
        var deger = $(this).val();

        $("#personel_id_select option").remove();
        let proje_id  =$(this).val();
        let data = {
            crsf_token: crsf_hash,
            tip: deger,
        }
        $.post(baseurl + 'projestoklari/personel_customer_type',data,(response) => {
            let responses = jQuery.parseJSON(response);
            responses.item.forEach((item_,index) => {
                $('.personel_id_select').append(new Option(item_.name, item_.id, false, false)).trigger('change');
            })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });
    })
    $(document).on('change','.bolum_radio',function (){
        let id = $(this).data('bolum-id');
        let data = {
            crsf_token: crsf_hash,
            bolum_id: id,
        }
        let table_report='';
        $.post(baseurl + 'projestoklari/get_proje_bolum_to_asama',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.list .row .asama_div').remove();
            $('.list .row').append(responses.html);

        });

    })
    $(document).on('click','.delete-stok',function () {
        let stok_id = $(this).attr('stok_id')
        let remove = '#remove'+ stok_id
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


    //edit
    $(document).on('click','.edit-stockio',function (){
        let stok_id = $(this).data('id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Stok Fiş Bilgileri',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<div class="row">
                                    <div class="col-md-4">
                                        <lable>Fiş Tipi</lable>
                                            <select class="form-control tip_select">
                                                <option value="1">Stok Giriş Fişi</option>
                                                <option value="0">Stok Çıkış Fişi</option>
                                            </select>
                                            </div>
                                    <div class="col-md-4">
                                 <lable>Anbar</lable>
                                <select id="warehouse_select"  class="form-control select-box warehouse_select">
                                <option value='0'>Anbar Seçin</option>
                                   <?php
                foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
                    echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                }
                ?>
                                </select>
                             </div>
                             <div class="col-md-4">
                                 <lable>Sorumlu Personel</lable>
                                <select id="personel_id_select" class="form-control select-box personel_id_select">
                                <option value='0'>Personel Seçinz</option>
                                   <?php
                foreach (all_personel() as $item) {
                    echo "<option data-name='$item->name' value='$item->id'>$item->name</option>";
                }
                ?>
                                </select>
                             </div>
                             </div>
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
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let tip_select=$('.tip_select').val();
                        let personel_id_select=$('.personel_id_select').val();
                        let warehouse_select=$('.warehouse_select').val();
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
                            content: function () {
                                let self = this;
                                let html = `<form>
                                    <div class="row">
                                    <input type='hidden' value='`+tip_select+`' id="type" >
                                    <input type='hidden' value='`+warehouse_select+`' id="warehouse">
                                    <input type='hidden' value='`+personel_id_select+`' id="personel_id" >
                                    <input type='hidden' value='`+customer_type_id+`' id="customer_type_id" >

                                            <div class="col-md-8">
                                              <lable>Məhsul</lable>
                                              <select id="product" class="form-control product">

                                              </select>
                                        </div>
                                         <div class="col-md-4">
                                            <lable>Lahiyə</lable>
                                                <select id="project" class="form-control select-box project line_project_id">
                                                  <option value="0">Lahiyə secin</option>
                                               <?php
                                foreach (all_projects() as $item) {
                                    echo "<option data-name='$item->name' value='$item->id'>$item->code</option>";
                                }
                                ?>
                                            </select>
                                         </div>


                                    </div>

                                 </form>
                                 <p class="test"></p>
                                      <table id="result" class="table ">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Fistipi</th>
                                      <th scope="col">Sorumlu Personel</th>
                                      <th scope="col">Anbar</th>
                                      <th scope="col">Mehsul</th>
                                      <th scope="col">Layihe</th>
                                      <th scope="col">Miqdar</th>
                                        <th scope="col">Olcu vahidi</th>
                                      <th scope="col">Aciqlama</th>
                                      <th scope="col">Sil</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                                </table>
                               `;
                                let data = {
                                    stok_id: stok_id,
                                    new_tip: $('.tip_select').val(),
                                    new_warehouse: $('.warehouse_select').val(),
                                    new_personel_id: $('.personel_id_select').val()
                                }

                                let table_report='';
                                $.post(baseurl + 'projestoklari/info_stock_details',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    let responses = jQuery.parseJSON(response);
                                        let new_tip = $('.tip_select').val();
                                        let new_warehouse = $('.warehouse_select').val();
                                        let new_personel_id=$('.personel_id_select').val();

                                        responses.item_details.forEach((data,mt_index) => {

                                            let units = '<select class="form-control select-box line_unit_id">';
                                            data.unit_get.forEach((item,index) => {
                                                units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                            })
                                            units+='</select>';


                                            let no = parseInt(mt_index)+1;
                                            let table=`<tr  id="remove`+mt_index+`"
                                                        fis_type='`+new_tip+`'
                                                        proje_id='`+data.proje_id+`'
                                                        personel_id='`+new_personel_id+`'
                                                        warehouse_id='`+new_warehouse+`'
                                                        product_id='`+data.product_id+`'
                                                        option_value_id='`+data.option_value_id+`'
                                                        bolum_id='`+data.bolum_id+`'
                                                        asama_id='`+data.asama_id+`' >
                                                        <td>`+no+`</td>
                                                        <td><p>`+responses.tip_name+`</td>
                                                        <td><p>`+responses.personel_name+`</td>
                                                        <td><p>`+responses.warehouse_name+`</td>
                                                        <td><p>`+data.product_name+`</p><span style="font-size: 12px;">`+data.value_text+`</span></td>
                                                        <td>`+data.proje_name+`</br><span style="font-size: 12px;">`+data.bolum_name+`</br>`+data.asama_name+`</span></td>
                                                        <td><input type="number" value="`+data.miktar+`" onkeyup="amount_max(this)" max='`+data.warehouse_qty_details.qty+`' class="form-control line_qty"></td>
                                                        <td>`+units+`</td>
                                                        <td><input type="text" value="`+data.desc+`" class="form-control line_desc"></td>
                                                        <td><button stok_id='`+mt_index+`' class="btn btn-danger btn-sm delete-stok"><i class='fa fa-trash'></i></button></td>
                                             </tr>`;
                                            $('#result tbody').append(table);
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
                                        let count = $('.line_qty').length;
                                        let collection = [];
                                        let data=[];

                                        for(let i=0; i < count; i++ ){
                                            data = {
                                                qty: $('.line_qty').eq(i).val(),
                                                unit_id: $('.line_unit_id').eq(i).val(),
                                                dec: $('.line_desc').eq(i).val(),
                                                value_id: $('#result tbody tr').eq(i).attr('option_value_id'),
                                                fis_type: $('#result tbody tr').eq(i).attr('fis_type'),
                                                warehouse_id: $('#result tbody tr').eq(i).attr('warehouse_id'),
                                                product_id: $('#result tbody tr').eq(i).attr('product_id'),
                                                proje_id: $('#result tbody tr').eq(i).attr('proje_id'),
                                                personel_id: $('#result tbody tr').eq(i).attr('personel_id'),
                                                bolum_id: $('#result tbody tr').eq(i).attr('bolum_id'),
                                                asama_id: $('#result tbody tr').eq(i).attr('asama_id'),
                                            }

                                            collection.push(data)
                                        }
                                        let data_post = {
                                            collection: collection,
                                            stok_id: stok_id,
                                            crsf_token: crsf_hash,
                                        }

                                        $.post(baseurl + 'projestoklari/update_fis',data_post,(response)=>{
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
                                                                $('#invoices').DataTable().destroy();
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
                                        url: '<?php echo base_url().'projestoklari/getall_products' ?>',
                                        dataType: 'json',
                                        data:function (params)
                                        {
                                            let query = {
                                                search: params.term,
                                                warehouse_id: $('#warehouse').val(),
                                                tip: $('#type').val(),
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

                                $('.personel_id').select2({
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

                        setTimeout(function(){
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm")
                            })
                            $('#loading-box').addClass('d-none');
                        }, 1000);
                    }
                },
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
    //edit

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


    //delete
    $(document).on('click','.cancel-stockio' ,function(){
        let stok_id = $(this).data('id');
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
                        $.post(baseurl + 'projestoklari/delete_fis',data,(response)=>{
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
                                                $('#invoices').DataTable().destroy();
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
    //delete
    //
</script>
<script>
    //{
    //    text: '<i class="fa fa-plus"></i> Yeni Fiş Oluştur',
    //    action: function ( e, dt, node, config ) {
    //        $.confirm({
    //            theme: 'modern',
    //            closeIcon: true,
    //            title: 'Stok Fiş Bilgileri',
    //            icon: 'fa fa-question',
    //            type: 'green',
    //            animation: 'scale',
    //            useBootstrap: true,
    //            columnClass: "medium",
    //            containerFluid: !0,
    //            smoothContent: true,
    //            draggable: false,
    //            content:`
    //                <div class="row">
    //                    <div class="col-md-2">
    //                        <lable>Fiş Tipi</lable>
    //                            <select class="form-control tip_select">
    //                                <option value="1">Stok Giriş Fişi</option>
    //                                <option value="0">Stok Çıkış Fişi</option>
    //                            </select>
    //                            </div>
    //                    <div class="col-md-4">
    //                 <lable>Anbar</lable>
    //                <select id="warehouse_select"  class="form-control select-box warehouse_select">
    //                <option value='0'>Anbar Seçin</option>
    //                   <?php
    //                foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
    //                    echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
    //                }
    //                ?>
    //                </select>
    //             </div>
    //             <div class="col-md-2">
    //                 <lable>Personel / Cari</lable>
    //                <select  class="form-control select-box cari_pers_type">
    //                <option value='0'>Tip Seçinz</option>
    //                <option value='1'>Cari</option>
    //                <option value='2'>Personel</option>
    //                </select>
    //             </div>
    //             <div class="col-md-4">
    //                 <lable>Sorumlu Personel</lable>
    //                <select id="personel_id_select" class="form-control select-box personel_id_select">
    //                <option value='0'>Cari / Personel Tipi Seçiniz</option>
    //                </select>
    //             </div>
    //             </div>
    //             `,
    //            buttons: {
    //                formSubmit: {
    //                    text: 'Devam',
    //                    btnClass: 'btn-blue',
    //                    action: function () {
    //                        let tip_select=$('.tip_select').val();
    //                        let personel_id_select=$('.personel_id_select').val();
    //                        let cari_pers_type=$('.cari_pers_type').val();
    //                        let warehouse_select=$('.warehouse_select').val();
    //                        $.confirm({
    //                            theme: 'modern',
    //                            closeIcon: false,
    //                            title: 'Məhsul Fişi',
    //                            icon: 'fa fa-external-link-square-alt 3x',
    //                            type: 'dark',
    //                            animation: 'scale',
    //                            useBootstrap: true,
    //                            columnClass: "col-md-12 mx-auto",
    //                            containerFluid: !0,
    //                            smoothContent: true,
    //                            draggable: false,
    //                            content: `<form >
    //        <div class="row">
    //        <input type='hidden' value='`+tip_select+`' id="type" >
    //        <input type='hidden' value='`+warehouse_select+`' id="warehouse">
    //        <input type='hidden' value='`+personel_id_select+`' id="personel_id" >
    //        <input type='hidden' value='`+cari_pers_type+`' id="cari_pers_type" >
    //
    //                <div class="col-md-8">
    //                  <lable>Məhsul</lable>
    //                  <select id="product" class="form-control product">
    //
    //                  </select>
    //            </div>
    //             <div class="col-md-4">
    //                <lable>Lahiyə</lable>
    //                    <select id="project" class="form-control select-box project line_project_id">
    //                      <option value="0">Lahiyə secin</option>
    //                   <?php
    //                            foreach (all_projects() as $item) {
    //                                echo "<option data-name='$item->name' value='$item->id'>$item->code</option>";
    //                            }
    //                            ?>
    //                </select>
    //             </div>
    //
    //
    //        </div>
    //
    //     </form>
    //     <p class="test"></p>
    //          <table id="result" class="table ">
    //      <thead>
    //        <tr>
    //          <th scope="col">#</th>
    //          <th scope="col">Fistipi</th>
    //          <th scope="col">Sorumlu Personel</th>
    //          <th scope="col">Anbar</th>
    //          <th scope="col">Mehsul</th>
    //          <th scope="col">Layihe</th>
    //          <th scope="col">Miqdar</th>
    //            <th scope="col">Olcu vahidi</th>
    //          <th scope="col">Aciqlama</th>
    //          <th scope="col">Sil</th>
    //        </tr>
    //      </thead>
    //      <tbody>
    //
    //      </tbody>
    //    </table>
    //   `,
    //                            buttons: {
    //
    //                                formSubmit: {
    //                                    text: 'Göndər',
    //                                    btnClass: 'btn-blue',
    //                                    action: function () {
    //                                        let count = $('.line_qty').length;
    //                                        let collection = [];
    //                                        let data=[];
    //
    //                                        for(let i=0; i < count; i++ ){
    //                                            data = {
    //                                                qty: $('.line_qty').eq(i).val(),
    //                                                unit_id: $('.line_unit_id').eq(i).val(),
    //                                                dec: $('.line_desc').eq(i).val(),
    //                                                value_id: $('#result tbody tr').eq(i).attr('option_value_id'),
    //                                                fis_type: $('#result tbody tr').eq(i).attr('fis_type'),
    //                                                warehouse_id: $('#result tbody tr').eq(i).attr('warehouse_id'),
    //                                                product_id: $('#result tbody tr').eq(i).attr('product_id'),
    //                                                proje_id: $('#result tbody tr').eq(i).attr('proje_id'),
    //                                                personel_id: $('#result tbody tr').eq(i).attr('personel_id'),
    //                                                cari_pers_type: $('#result tbody tr').eq(i).attr('cari_pers_type'),
    //                                                bolum_id: $('#result tbody tr').eq(i).attr('bolum_id'),
    //                                                asama_id: $('#result tbody tr').eq(i).attr('asama_id'),
    //                                            }
    //
    //                                            collection.push(data)
    //                                        }
    //
    //                                        console.log(collection);
    //
    //                                        let data_post = {
    //                                            collection: collection,
    //                                            crsf_token: crsf_hash,
    //                                        }
    //
    //                                        $.post(baseurl + 'projestoklari/create_fis',data_post,(response)=>{
    //                                            let data = jQuery.parseJSON(response);
    //                                            if(data.status==200){
    //                                                $.alert({
    //                                                    theme: 'modern',
    //                                                    icon: 'fa fa-check',
    //                                                    type: 'green',
    //                                                    animation: 'scale',
    //                                                    useBootstrap: true,
    //                                                    columnClass: "col-md-4 mx-auto",
    //                                                    title: 'Başarılı',
    //                                                    content: data.message,
    //                                                    buttons:{
    //                                                        prev: {
    //                                                            text: 'Tamam',
    //                                                            btnClass: "btn btn-link text-dark",
    //                                                            action: function () {
    //                                                                table_product_id_ar = [];
    //                                                                $('#invoices').DataTable().destroy();
    //                                                                draw_data();
    //                                                            }
    //                                                        }
    //                                                    }
    //                                                });
    //
    //                                            }
    //                                            else {
    //                                                $.alert({
    //                                                    theme: 'material',
    //                                                    icon: 'fa fa-exclamation',
    //                                                    type: 'red',
    //                                                    animation: 'scale',
    //                                                    useBootstrap: true,
    //                                                    columnClass: "col-md-4 mx-auto",
    //                                                    title: 'Dikkat!',
    //                                                    content: data.message,
    //                                                    buttons:{
    //                                                        prev: {
    //                                                            text: 'Tamam',
    //                                                            btnClass: "btn btn-link text-dark",
    //                                                        }
    //                                                    }
    //                                                });
    //                                            }
    //                                        })
    //                                    }
    //                                },
    //                                cancel: {
    //                                    text: 'İmtina et',
    //                                    btnClass: "btn btn-danger btn-sm",
    //                                    action:function (){
    //                                        table_product_id_ar = [];
    //                                    }
    //                                }
    //                            },
    //                            onContentReady: function () {
    //
    //                                $('.product').select2({
    //                                    dropdownParent: $(".jconfirm-box-container"),
    //                                    minimumInputLength: 3,
    //                                    allowClear: true,
    //                                    placeholder:'Seçiniz',
    //                                    language: {
    //                                        inputTooShort: function() {
    //                                            return 'En az 3 karakter giriniz';
    //                                        }
    //                                    },
    //                                    ajax: {
    //                                        method:'POST',
    //                                        url: '<?php //echo base_url().'projestoklari/getall_products' ?>//',
    //                                        dataType: 'json',
    //                                        data:function (params)
    //                                        {
    //                                            let query = {
    //                                                search: params.term,
    //                                                warehouse_id: $('#warehouse').val(),
    //                                                tip: $('#type').val(),
    //                                                crsf_token: crsf_hash,
    //                                            }
    //                                            return query;
    //                                        },
    //                                        processResults: function (data) {
    //                                            return {
    //                                                results: $.map(data, function (data) {
    //                                                    return {
    //                                                        text: data.product_name,
    //                                                        product_name: data.product_name,
    //                                                        id: data.pid,
    //
    //                                                    }
    //                                                })
    //                                            };
    //                                        },
    //                                        cache: true
    //                                    },
    //                                }).on('change',function (data) {
    //                                })
    //
    //                                $('.warehouse').select2({
    //                                    dropdownParent: $(".jconfirm-box-container")
    //                                })
    //
    //                                $('.personel_id').select2({
    //                                    dropdownParent: $(".jconfirm-box-container")
    //                                })
    //                                $('.project').select2({
    //                                    dropdownParent: $(".jconfirm-box-container")
    //                                })
    //                                // bind to events
    //                                var jc = this;
    //                                this.$content.find('form').on('submit', function (e) {
    //                                    // if the user submits the form by pressing enter in the field.
    //                                    e.preventDefault();
    //                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
    //                                });
    //                            }
    //                        });
    //
    //                        setTimeout(function(){
    //                            $('.select-box').select2({
    //                                dropdownParent: $(".jconfirm")
    //                            })
    //                            $('#loading-box').addClass('d-none');
    //                        }, 1000);
    //                    }
    //                },
    //            },
    //            onContentReady: function () {
    //                $('.select-box').select2({
    //                    dropdownParent: $(".jconfirm")
    //                })
    //                // bind to events
    //                var jc = this;
    //                this.$content.find('form').on('submit', function (e) {
    //                    // if the user submits the form by pressing enter in the field.
    //                    e.preventDefault();
    //                    jc.$$formSubmit.trigger('click'); // reference the button and click it
    //                });
    //            }
    //        });
    //
    //    }
    //},
</script>