<div class="content-body">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                </div>
                <div class="col-md-12">
                </div>
            </div>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab"
                 aria-expanded="true">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="grid_3 grid_4 animated fadeInRight">
                    <div class="table-responsive">
                        <div class="row" style="padding-left: 13px;">
                            <div class="col-12">
                                <table id="invoices" class="table table-striped table-bordered zero-configuration">
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
                        <hr>

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
                'url': "<?php echo site_url('stockfis/ajax_stok_fis_list')?>",
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
                    text: '<i class="fa fa-plus"></i> Yeni Fiş Oluştur',
                    action: function ( e, dt, node, config ) {
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
                            content:`
                                <div class="row">
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
                             `,
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
                                            content: `<form >
                        <div class="row">
                        <input type='hidden' value='`+tip_select+`' id="type" >
                        <input type='hidden' value='`+warehouse_select+`' id="warehouse">
                        <input type='hidden' value='`+personel_id_select+`' id="personel_id" >

                                <div class="col-md-12">
                                  <lable>Məhsul</lable>
                                  <select id="product" class="form-control product">

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
                          <th scope="col">Miqdar</th>
                            <th scope="col">Olcu vahidi</th>
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
                                                    text: 'Göndər',
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

                                                        console.log(collection);

                                                        let data_post = {
                                                            collection: collection,
                                                            crsf_token: crsf_hash,
                                                        }

                                                        $.post(baseurl + 'stockfis/create_fis',data_post,(response)=>{
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

                    }
                }
            ]
        });
    }
    let product_option_details=[];
    let option_details=[];
    let table_product_id_ar = [];
    $(document).on('change','.product',function (){
        let tip = $('#type').val();
        let product_id =$('.product').val();
        let warehouse_id = $('#warehouse').val();
        let personel_id = $('#personel_id').val();
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

                            if(varyasyon_durum){
                                $('#loading-box').removeClass('d-none');
                                if($('.option-value:checked')){
                                    product_option_details.push({
                                        'option_value_id':$('.option-value:checked').attr('data-value-id'),
                                        'option_value_name':$('.option-value:checked').attr('str'),
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

                            proje_details_create(product_id,0,0,tip,warehouse_id,0,personel_id)
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
    function proje_details_create(product_id,bolum_id,asama_id,tip,warehouse_id,proje_id,personel_id){
        mt_index++;
        $('.product').empty();
        let option_details_= [];
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
        }
        $.post(baseurl + 'projestoklari/add_product_details',data,(response)=>{
            $('#loading-box').removeClass('d-none');
            let responses = jQuery.parseJSON(response);
            let units = '<select class="form-control select-box line_unit_id">';
            responses.unit.forEach((item,index) => {
                units+=`<option value="`+item.id+`">`+item.name+`</option>`;
            })
            units+='</select>';


            let table=`<tr  id="remove`+mt_index+`" fis_type='`+tip+`' proje_id='`+proje_id+`' personel_id='`+personel_id+`' warehouse_id='`+warehouse_id+`' product_id='`+product_id+`' option_value_id='`+value_id+`' bolum_id='`+bolum_id+`' asama_id='`+asama_id+`' >
                        <td>`+mt_index+`</td>
                        <td><p>`+responses.tip_name+`</td>
                        <td><p>`+responses.personel_name+`</td>
                        <td><p>`+responses.warehouse_name+`</td>
                        <td><p>`+responses.product_name+`</p><span style="font-size: 12px;">`+value_text+`</span></td>
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

                                            <div class="col-md-12">
                                              <lable>Məhsul</lable>
                                              <select id="product" class="form-control product">
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

                                        $.post(baseurl + 'stockfis/update_fis',data_post,(response)=>{
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
                        $.post(baseurl + 'stockfis/delete_fis',data,(response)=>{
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

</script>
