<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Proje Aşamaları </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">

        <div class="card">
            <div class="card-body">
                <form action="#">
                    <fieldset class="mb-3 col-md-12">
                        <div class="form-group row">
                            <div class="col col-sm-8 col-md-8">
                                <select class="form-control select2" id="category_id_search">
                                    <option value="0">Aşamalar</option>

                                    <?php foreach (all_list_proje_asamalari() as $items){
                                        $new_title = parent_asama_kontrol_list($items->id).$items->name;
                                        //$new_title = $items->name;
                                        echo "<option value='$items->id'>$new_title</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="col col-sm-2 col-md-2">
                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="asamalar_table" class="table datatable-responsive">
                    <thead>
                    <tr>
                        <td>#</td>
                        <th><input type="checkbox" class="form-control all_select"></th>
                        <td>ID</td>
                        <th>Kodu (Sistem)</th>
                        <th>Kodu (Simeta)</th>
                        <th>Üst Aşama</th>
                        <th>Adı</th>
                        <th>Açıklama</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>

    $('#search').click(function () {
        var category_id = $('#category_id_search').val();
        $('#asamalar_table').DataTable().destroy();
        draw_data(category_id);
    });

    $(document).ready(function() {
        $('.select2').select2();
        draw_data();
    });


    function draw_data(category_id=0) {
        $('#asamalar_table').DataTable({

            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': baseurl + 'projectasama/ajax_list',
                'type': 'POST',
                'data': {
                    'category_id':category_id
                }
            },
            'columnDefs': [{
                'targets': [0,1],
                'orderable': false,
            }, ],
            dom: 'Blfrtip',
            buttons: [

                {
                    text: '<i class="fa fa-plus"></i> Yeni Aşama Elave et',
                    action: function(e, dt, node, config) {

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Aşama Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Aşama Kodu (Sistem)</label>
                                            <input type="text" class="form-control" name="code" id="code">
                                        </div>
                                           <div class="form-group col-md-6">
                                          <label for="name">Aşama Kodu (Simeta)</label>
                                            <input type="text" class="form-control" name="simeta_code" id="simeta_code">
                                        </div>
                                        <div class="form-group col-md-12">
                                          <label for="name">Aşama Adı</label>
                                            <input type="text" class="form-control" id="name" placeholder="Elektrik İşleri">
                                        </div>
                                       <div class="form-group col-md-12">
                                            <label for="name">Bağlı Olduğu Aşama</label>
                                            <select class="form-control select-box" id="parent_id" name="parent_id">
                                               <option value="0">Bağlı Olduğu Aşama Seçebilirsiniz</option>
                                        <?php foreach (all_list_proje_asamalari() as $items){
                                $new_title = parent_asama_kontrol_list($items->id).$items->name;
                                //$new_title = $items->name;
                                echo "<option value='$items->id'>$new_title</option>";
                            } ?>
                                            </select>
                                        </div>
                                    </div>

                                          <div class="form-group col-md-12">
                                          <label for="name">Açıklama</label>
                                            <input type="text" class="form-control" name="desc" id="desc">
                                        </div>

                                      </div>
                                    </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            name:  $('#name').val(),
                                            desc:  $('#desc').val(),
                                            parent_id:  $('#parent_id').val(),
                                            simeta_code:  $('#simeta_code').val(),
                                            code:  $('#code').val()
                                        }
                                        $.post(baseurl + 'projectasama/create',data,(response) => {
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
                                                                $('#asamalar_table').DataTable().destroy();
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

                                $('#bolum_id').select2().trigger('change');

                                $("#customer_statement").select2({
                                    minimumInputLength: 1,
                                    dropdownParent: $(".jconfirm-box-container"),
                                    tags: false,
                                    ajax: {
                                        url: baseurl + 'search/customer_select',
                                        dataType: 'json',
                                        type: 'POST',
                                        quietMillis: 50,
                                        data: function (customer) {
                                            return {
                                                customer: customer,
                                                '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                                            };
                                        },
                                        processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    return {
                                                        text: item.company,
                                                        id: item.id
                                                    }
                                                })
                                            };
                                        },
                                    }
                                });

                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })
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

                {
                    text: '<i class="fa fa-plus"></i> Seçilileri Proje Elave Et',
                    action: function(e, dt, node, config) {

                        let checked_count = $('.one_select:checked').length;
                        if (checked_count == 0) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir Aşama Seçilmemiş!',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        else {

                            let asama_details=[];
                            $('.one_select:checked').each((index,item) => {
                                asama_details.push({
                                    asama_id:$(item).val(),
                                })
                            });
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Projeye Aşama Ekle',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje</label>
                                            <select class="form-control select-box" id="proje_id" name="proje_id">
                                               <option value="0">Seçiniz</option>
                                        <?php foreach (all_projects() as $items){
                                    //$new_title = $items->name;
                                    echo "<option value='$items->id'>$items->code</option>";
                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Bölüm</label>
                                            <select class="form-control select-box" id="bolum_id" name="bolum_id">
                                               <option value="0">Proje Seçiniz</option>
                                            </select>
                                        </div>

                                        </div>
                                    </form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');

                                            let data = {
                                                crsf_token: crsf_hash,
                                                proje_id:  $('#proje_id').val(),
                                                bolum_id:  $('#bolum_id').val(),
                                                asama_details:  asama_details
                                            }
                                            $.post(baseurl + 'projectasama/create_proje_add',data,(response) => {
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
                                                                    $('#asamalar_table').DataTable().destroy();
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

                                    $('#bolum_id').select2().trigger('change');

                                    $("#customer_statement").select2({
                                        minimumInputLength: 1,
                                        dropdownParent: $(".jconfirm-box-container"),
                                        tags: false,
                                        ajax: {
                                            url: baseurl + 'search/customer_select',
                                            dataType: 'json',
                                            type: 'POST',
                                            quietMillis: 50,
                                            data: function (customer) {
                                                return {
                                                    customer: customer,
                                                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                                                };
                                            },
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.company,
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                        }
                                    });

                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })
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
            ]
        });
    }


    $(document).on('click', '.edit', function() {
        let asama_id = $(this).attr('asama_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Aşama Düzenle',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function() {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html +=
                    `
            <div class='mb-3'>
                <div class="form-row">

       <div class="form-group col-md-6">
                                          <label for="name">Aşama Kodu (Sistem)</label>
                                            <input type="text" class="form-control" name="code" id="code">
                                        </div>
                                           <div class="form-group col-md-6">
                                          <label for="name">Aşama Kodu (Simeta)</label>
                                            <input type="text" class="form-control" name="simeta_code" id="simeta_code">
                                        </div>
                    <div class="form-group col-md-12">
                       <label>Aşama Adı</label>
                       <input type="text" class='form-control name'>
                    </div>


 <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Aşama</label>
                                       <select class="form-control select-box parent_id">
                                        <option value="0">Bağlı Olduğu Aşama Seçebilirsiniz</option>
                                        <?php foreach (all_list_proje_asamalari() as $items){
                        $new_title = parent_asama_kontrol_list($items->id).$items->name;
                        //$new_title = $items->name;
                        echo "<option value='$items->id'>$new_title</option>";
                    } ?>
                                        </select>
                                    </div>
      <div class="form-group col-md-12">
                        <label>Açıklama</label>
                        <input type="text" class='form-control desc'>
                    </div>

                </div>
            </div>
            `;
                let data = {
                    crsf_token: crsf_hash,
                    asama_id: asama_id
                }

                let table_report = '';
                $.post(baseurl + 'projectasama/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.name').val(responses.items.name)
                    $('#code').val(responses.items.code)
                    $('#simeta_code').val(responses.items.simeta_code)
                    $('.desc').val(responses.items.desc)
                    if(responses.parent_durum){
                        $('.parent_id').val(responses.parent.parent_id).select2().trigger('change')
                    }

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {
                        let data_post = {
                            id: asama_id,
                            crsf_token: crsf_hash,
                            name: $('.name').val(),
                            code: $('#code').val(),
                            simeta_code: $('#simeta_code').val(),
                            desc: $('.desc').val(),
                            parent_id: $('.parent_id').val(),
                        }
                        $.post(baseurl + 'projectasama/update', data_post, (response) => {
                            console.log(data_post)
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
                                                $('#asamalar_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        },
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
                    placeholder: 'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method: 'POST',
                        url: baseurl + 'product/info',
                        dataType: 'json',
                        data: function(params) {
                            let query = {
                                crsf_token: crsf_hash,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(data) {
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
                }).on('change', function(data) {})

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


    $(document).on('click', '.delete', function() {
        let id = $(this).attr('asama_id')
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
                        }
                        $.post(baseurl + 'projectasama/delete', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 200) {
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
                                                $('#units_table').DataTable().destroy();
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

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })

    $(document).on('change', "#proje_id", function (e) {
        $("#bolum_id option").remove();
        var proje_id = $(this).val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projectsnew/bolumler_list_select',
            data:'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                let data_r = jQuery.parseJSON(data)
                if(data_r.length)
                {
                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#bolum_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }
                else {
                    $('#bolum_id').append($('<option>').val(0).text('Projeye Atanmış Bölüm Bulunamadı'));
                }

            }
        });

    });
</script>