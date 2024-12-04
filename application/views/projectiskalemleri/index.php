<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> İş Kalemleri </span></h4>
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
                        <th>Kodu (Sistem)</th>
                        <th>Kodu (Simeta)</th>
                        <th>Aşama</th>
                        <th>Adı</th>
                        <th>Ölçü Vahidi</th>
                        <th>Reçete</th>
                        <th>Açıklama</th>
                        <th>Projeye Eklenecek Miktar</th>
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

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })
    $(document).ready(function() {
        $('.select2').select2();
        draw_data();
    });


    $('#search').click(function () {
        var category_id = $('#category_id_search').val();
        $('#asamalar_table').DataTable().destroy();
        draw_data(category_id);
    });


    function draw_data(category_id=0) {
        $('#asamalar_table').DataTable({

            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            aLengthMenu: [
                [10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'order': [],
            'ajax': {
                'url': baseurl + 'projectiskalemleri/ajax_list',
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
                    text: '<i class="fa fa-plus"></i> Yeni İş Kalemi Elave et',
                    action: function(e, dt, node, config) {

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni İş Kalemi Ekle',
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
                                          <label for="name">İş Kalemi Kodu (Sistem)</label>
                                            <input type="text" class="form-control" name="code" id="code">
                                        </div>
                                           <div class="form-group col-md-6">
                                          <label for="name">İş Kalemi Kodu (Simeta)</label>
                                            <input type="text" class="form-control" name="simeta_code" id="simeta_code">
                                        </div>
                                        <div class="form-group col-md-12">
                                          <label for="name">İş Kalemi Adı</label>
                                            <input type="text" class="form-control" id="name" placeholder="Elektrik İşleri">
                                        </div>
                                          <div class="form-group col-md-6">
                                          <label for="name">Ölçü Vahidi Miqdar</label>
                                            <input type="number" class="form-control" id="unit_qty">
                                        </div>
                                         <div class="form-group col-md-6">
                                            <label for="content">Birim</label>
                                           <select class="form-control select-box unit_id" id='unit_id'>
                                                <?php foreach (units() as $blm)
                                                {
                                                    $id=$blm['id'];
                                                    $name=$blm['name'];
                                                    echo "<option data-name='$name' value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="content">Üretim Reçecetesi</label>
                                           <select class="form-control select-box recete_id" id='recete_id'>
                                                <?php foreach (all_recete(71) as $recete_item)
                            {
                                $id=$recete_item->id;
                                $name=$recete_item->invoice_no.' '.$recete_item->invoice_name;
                                echo "<option data-name='$name' value='$id'>$name</option>";
                            } ?>
                                            </select>
                                        </div>
                                       <div class="form-group col-md-12">
                                            <label for="name">Bağlı Olduğu Aşama</label>
                                            <select class="form-control select-box" id="asama_id" name="asama_id">
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
                                            unit_id:  $('#unit_id').val(),
                                            unit_qty:  $('#unit_qty').val(),
                                            recete_id:  $('#recete_id').val(),
                                            asama_id:  $('#asama_id').val(),
                                            simeta_code:  $('#simeta_code').val(),
                                            code:  $('#code').val()
                                        }
                                        $.post(baseurl + 'projectiskalemleri/create',data,(response) => {
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
                    text: '<i class="fa fa-upload"></i> Excel İle İmport',
                    action: function(e, dt, node, config) {

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni İş Kalemi Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`      <form id="ajaxForm" method="POST">
                                <input type="file" class="form-control upload_excel" name="userfile"  required /> <br>
                                <input type="submit" class="btn btn-success" name="submit" value="Yükle">
                            </form>`,
                            buttons: {
                                cancel: {
                                    text: 'Kapat',
                                    btnClass: "btn btn-danger btn-sm"
                                }
                            },
                            onContentReady: function () {


                                $("#ajaxForm").submit(function(e){

                                    e.preventDefault();
                                    $.ajax({
                                        type: "POST",
                                        url: baseurl + 'excel/upload_is_kalemleri',
                                        data: new FormData(this),
                                        dataType: "json",
                                        processData: false,
                                        contentType: false,
                                        success: function(responses){

                                            if (responses.status == 200) {
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
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
                                            else {
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
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
                                        }
                                    });

                                })

                                $('#bolum_id').select2().trigger('change');


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
                    text: '<i class="fa fa-plus"></i> İş Kalemlerini Projeye Ata',
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
                                content: 'Herhangi Bir İş Kalemi Seçilmemiş!',
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

                            let is_kalemi_details=[];
                            $('.one_select:checked').each((index,item) => {
                                let id =$(item).val();
                                is_kalemi_details.push({
                                    is_kalemi_id:$(item).val(),
                                    qty:$('.qty'+id).val(),
                                })
                            });
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Projeye İş Kalemi Ekle',
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
                                                is_kalemi_details:  is_kalemi_details
                                            }
                                            $.post(baseurl + 'projectiskalemleri/create_proje_add',data,(response) => {
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
                                          <label for="name">İş Kalemi Kodu (Sistem)</label>
                                            <input type="text" class="form-control" name="code" id="code">
                                        </div>
                                           <div class="form-group col-md-6">
                                          <label for="name">İş Kalemi Kodu (Simeta)</label>
                                            <input type="text" class="form-control" name="simeta_code" id="simeta_code">
                                        </div>
                    <div class="form-group col-md-12">
                       <label>İş Kalemi Adı</label>
                       <input type="text" class='form-control name'>
                    </div>
                       <div class="form-group col-md-6">
                                          <label for="name">Ölçü Vahidi Miqdar</label>
                                            <input type="number" class="form-control" id="unit_qty">
                                        </div>
                           <div class="form-group col-md-6">
                                            <label for="content">Birim</label>
                                           <select class="form-control select-box unit_id" id='unit_id'>
                                                <?php foreach (units() as $blm)
                    {
                        $id=$blm['id'];
                        $name=$blm['name'];
                        echo "<option data-name='$name' value='$id'>$name</option>";
                    } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="content">Üretim Reçecetesi</label>
                                           <select class="form-control select-box recete_id" id='recete_id'>
                                                <?php foreach (all_recete(71) as $recete_item)
                    {
                        $id=$recete_item->id;
                        $name=$recete_item->invoice_no.' '.$recete_item->invoice_name;
                        echo "<option data-name='$name' value='$id'>$name</option>";
                    } ?>
                                            </select>
                                        </div>


 <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Aşama</label>
                                       <select class="form-control select-box asama_id">
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
                $.post(baseurl + 'projectiskalemleri/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.name').val(responses.items.name)
                    $('#code').val(responses.items.code)
                    $('#unit_id').val(responses.items.unit_id)
                    $('#unit_qty').val(responses.items.unit_qty)
                    $('#recete_id').val(responses.items.recete_id)
                    $('#simeta_code').val(responses.items.simeta_code)
                    $('.desc').val(responses.items.desc)
                    $('.asama_id').val(responses.items.asama_id).select2().trigger('change')

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
                            unit_id: $('#unit_id').val(),
                            unit_qty: $('#unit_qty').val(),
                            simeta_code: $('#simeta_code').val(),
                            recete_id: $('#recete_id').val(),
                            desc: $('.desc').val(),
                            asama_id: $('.asama_id').val(),
                        }
                        $.post(baseurl + 'projectiskalemleri/update', data_post, (response) => {
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
                        $.post(baseurl + 'projectiskalemleri/delete', data, (response) => {
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
                                                $('#asamalar_table').DataTable().destroy();
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