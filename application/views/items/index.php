<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Diğer <Tanımlamalar></Tanımlamalar></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="units_table" class="table datatable-responsive">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                        <th>No</th>
                        <th>Birim</th>
                        <th>Kodu</th>
                        <th>Departman</th>
                        <th>Sorumlu Personel</th>
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
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    var url = '<?php echo base_url() ?>arac/file_handling';
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


    function draw_data() {
        $('#units_table').DataTable({

            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': baseurl + 'items/ajax_list',
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
                    text: '<i class="fa fa-plus"></i> Yeni Birim Elave et',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Yeni Birim Elave et',
                            icon: 'fa fa-plus-square 3x',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `
                            <div class='mb-3'>
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                       <label>Isim</label>
                                       <input type="text" class='form-control name'>
                                    </div>



 <div class="form-group col-md-6">
  <label for="cost_id">Demirbaş Grubu</label>
      <select class="form-control select-box" id="demirbas_id" name="demirbas_id">
                                            <?php
                            if(demirbas_group_list(1)){
                            echo "<option value='0'>Seçiniz</option>";
                            foreach (demirbas_group_list() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                            }
                            else {
                            ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                            }

                            ?>
                                        </select>
    </div>
     <div class="form-group col-md-6">
      <label for="name">Sorumlu Personel</label>
       <select name="roleid" class="form-control select-box zorunlu" id="personel_id">
       <option value='0'>Seçiniz</option>
           <?php foreach (all_personel() as $rol){
                            ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group col-md-6">
      <label for="name">Departman</label>
       <select name="roleid" class="form-control select-box zorunlu" id="departman_id">
       <option value='0'>Seçiniz</option>
           <?php foreach (personel_depertman_list() as $rol){
                            ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->val1; ?> </option>
            <?php } ?>
        </select>
    </div>



    <div class="form-group col-md-12">
                                       <label>Proje</label>
                                       <select class="form-control select-box pm_zorunlu" id="proje_id">
                                  <option value="0">Proje Seçiniz</option>
                                        <?php foreach (all_projects() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                </select>
                                    </div>

                            </div>
                              <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Resim</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="files[]">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>
                            </div>


                            `,
                            buttons: {
                                formSubmit: {
                                    text: 'Gondər',
                                    btnClass: 'btn-blue',
                                    action: function() {

                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            name: $('.name').val(),
                                            proje_id: $('#proje_id').val(),
                                            demirbas_id: $('#demirbas_id').val(),
                                            personel_id: $('#personel_id').val(),
                                            departman_id: $('#departman_id').val(),
                                            image_text:  $('#image_text').val(),
                                        }

                                        $.post(baseurl + 'items/create', data_post, (response) => {
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
                                                                $('#units_table').DataTable().destroy();
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

                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })
                                $('#fileupload_').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        var img='default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img=file.name;
                                        });

                                        $('#image_text').val(img);
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
                                this.$content.find('form').on('submit', function(e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-print"></i> Seçili Olanlara Barkod Yazdır',
                    action: function(e, dt, node, config) {
                        let checked_count = $('.one_select:checked').length;
                        if(checked_count==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir İtem Seçilmemiş!',
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
                                closeIcon: false,
                                title: 'Barkod Yazdırma',
                                icon: 'fa fa-print 3x',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content: `Barkod Yazdırılacak Emin Misiniz?`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Gondər',
                                        btnClass: 'btn-blue',
                                        action: function() {

                                            let items_id = [];
                                            $('.one_select:checked').each((index,item) => {
                                                items_id.push($(item).val())
                                            });
                                            let data_post = {
                                                crsf_token: crsf_hash,
                                                items_id: items_id,
                                            }

                                            $.post(baseurl + 'items/barcode_creates', data_post, (response) => {
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
                                                                    location.href=data.url;

                                                                }
                                                            }
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

                    }
                }
            ]
        });
    }


    $(document).on('click', '.edit', function() {
        let unit_id = $(this).attr('unit_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Düzenle',
            icon: 'fas fa-pen 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
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
                                       <label>Isim</label>
                                       <input type="text" class='form-control name'>
                                    </div>



 <div class="form-group col-md-6">
  <label for="cost_id">Demirbaş Grubu</label>
      <select class="form-control select-box" id="demirbas_id" name="demirbas_id">
                                            <?php
                    if(demirbas_group_list(1)){
                    echo "<option value='0'>Seçiniz</option>";
                    foreach (demirbas_group_list() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                    }
                    else {
                    ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                    }

                    ?>
                                        </select>
    </div>

 <div class="form-group col-md-6">
      <label for="name">Sorumlu Personel</label>
       <select name="roleid" class="form-control select-box zorunlu" id="personel_id">
       <option value='0'>Seçiniz</option>
           <?php foreach (all_personel() as $rol){
                    ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group col-md-6">
      <label for="name">Departman</label>
       <select name="roleid" class="form-control select-box zorunlu" id="departman_id">
       <option value='0'>Seçiniz</option>
           <?php foreach (personel_depertman_list() as $rol){
                    ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->val1; ?> </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group col-md-12">
                                       <label>Proje</label>
                                       <select class="form-control select-box pm_zorunlu" id="proje_id">
                                  <option value="0">Proje Seçiniz</option>
                                        <?php foreach (all_projects() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                </select>
                                    </div>

                             </div>
                             <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Resim</label>
         <div>
           <img class="myImg update_image" style="width: 322px;">
         </di>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>

            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>

            <span>Seçiniz...</span>
            <input id="fileupload_update" type="file" name="files[]">

            <input type="hidden" class="image_text_update" name="image_text_update" id="image_text_update">
      </div>

                            </div>

                            `;
                let data = {
                    crsf_token: crsf_hash,
                    unit_id: unit_id
                }

                let table_report = '';
                $.post(baseurl + 'items/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.name').val(responses.details_items[0].name)
                    $('#proje_id').val(responses.details_items[0].proje_id).select2().trigger('change');
                    $('#demirbas_id').val(responses.details_items[0].demirbas_id).select2().trigger('change');
                    $('#departman_id').val(responses.details_items[0].departman_id).select2().trigger('change');
                    $('#personel_id').val(responses.details_items[0].personel_id).select2().trigger('change');
                    $('#image_text_update').val(responses.details_items[0].image);
                    $('.update_image').attr('src',"/userfiles/product/"+responses.details_items[0].image)

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
                            unit_id: unit_id,
                            crsf_token: crsf_hash,
                            name: $('.name').val(),
                            proje_id: $('#proje_id').val(),
                            demirbas_id: $('#demirbas_id').val(),
                            personel_id: $('#personel_id').val(),
                            departman_id: $('#departman_id').val(),
                            image_text:  $('#image_text_update').val(),
                        }


                        $.post(baseurl + 'items/update', data_post, (response) => {
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
                                                $('#units_table').DataTable().destroy();
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
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })


    $(document).on('click', '.delete', function() {
        let unit_id = $(this).attr('unit_id')
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
                            unit_id: unit_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'items/delete', data, (response) => {
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
</script>s