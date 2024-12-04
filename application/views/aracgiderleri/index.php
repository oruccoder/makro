<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Ürünler</span></h4>
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
                                                <th>Gider Adı</th>
                                                <th>Bağlı Olduğu Gider</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
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
<script src="<?php echo base_url('app-assets/products/js/products.js?v='.rand(11111,99999)) ?>"></script>
<script>

    $(document).ready(function (){
        draw_data()
    })



    function draw_data(category_id=0) {
        $('#product_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': baseurl+'urun/ajax_list',
                'type': 'POST',
                'data': {
                    'category_id':category_id
                }
            },
            'columnDefs': [{
                'targets': [],
                'orderable': false,
            }, ],
            dom: 'Blfrtip',
            buttons: [

                {
                    text: '<i class="fa fa-plus"></i> Yeni Ürün Elave et',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Ürün Transfer Fişi',
                            icon: 'fa fa-plus-square 3x',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `
                                <div class='mb-3'>
                                    <div class="form-row">

                                         <div class="form-group col-md-6">
                                            <label>Ürün Adı</label>
                                            <input type="text" class='form-control product_name'>
                                         </div>

                                        <div class="form-group col-md-6">
                                            <label>Kateqori</label>
                                            <select class="form-control select-box category_id">
                                                <option value='0'>Secin</option>
                                                    <?php
                            foreach (all_categories() as $item) {
                                echo "<option value='$item->id'>$item->title</option>";
                            }
                            ?>
                                            </select>
                                        </div>


                                    </div>

                                        <div class="form-row">

                                         <div class="form-group col-md-6">
                                            <label>Simeta Adı</label>
                                            <input type="text" class='form-control simeta_product_name'>
                                         </div>

                                         <div class="form-group col-md-6">
                                            <label>Simeta Kodu</label>
                                            <input type="text" class='form-control simeta_code'>
                                         </div>

                                    </div>


                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>Ürün Aciqlamasi</label>
                                            <input type="text" class='form-control product_description'>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Ürün Tipi</label>
                                            <select class="form-control select-box pro_type">
                                                <option value='0'>Secin</option>
                                                    <?php
                            foreach (all_product_type() as $item) {
                                echo "<option value='$item->id'>$item->name</option>";
                            }
                            ?>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-12">

                                            <label for="resim">Dosya</label>
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
                                        let pro_type = $('.pro_type').val();
                                        if(!parseInt(pro_type)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Ürün Tipi Zorunludur',
                                                buttons: {
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });

                                            return false;
                                        }

                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            product_name: $('.product_name').val(),
                                            simeta_product_name: $('.simeta_product_name').val(),
                                            simeta_code: $('.simeta_code').val(),
                                            category_id: $('.category_id').val(),
                                            product_description: $('.product_description').val(),
                                            pro_type: $('.pro_type').val(),
                                            image: $('#image_text').val()
                                        }

                                        $.post(baseurl + 'urun/create', data_post, (response) => {
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
                                                                let cat_id = $('#category_id_search').val();
                                                                $('#product_table').DataTable().destroy();
                                                                draw_data(cat_id);
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

                                $('#fileupload_').fileupload({
                                    url: baseurl + 'upload/file_upload',
                                    dataType: 'json',
                                    formData: {
                                        '<?= $this->security->get_csrf_token_name() ?>': crsf_hash,
                                        'path': '/userfiles/product/'
                                    },
                                    done: function(e, data) {
                                        var img = 'default.png';
                                        $.each(data.result.files, function(index, file) {
                                            img = file.name;
                                        });

                                        $('#image_text').val(img);
                                    },
                                    progressall: function(e, data) {
                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#progress .progress-bar').css(
                                            'width',
                                            progress + '%'
                                        );
                                    }
                                }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                // bind to events

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
            ]
        });
    }



    $('#search').click(function () {
        var category_id = $('#category_id_search').val();
        $('#product_table').DataTable().destroy();
        draw_data(category_id);
    });

    $(document).on('click', '.edit', function() {
        let product_id = $(this).attr('product_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Düzenle',
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
                                    <div class="form-group col-md-6">
                                        <label>Ürün Adı</label>
                                        <input type="text" class='form-control product_name'>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kateqori</label>
                                        <select class="form-control select-box category_id">
                                            <option value='0'>Secin</option>
                                                <?php
                foreach (all_categories() as $item) {

                    echo "<option value='$item->id'>$item->title</option>";
                }
                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">

                                         <div class="form-group col-md-6">
                                            <label>Simeta Adı</label>
                                            <input type="text" class='form-control simeta_product_name'>
                                         </div>

                                         <div class="form-group col-md-6">
                                            <label>Simeta Kodu</label>
                                            <input type="text" class='form-control simeta_code'>
                                         </div>

                                    </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Ürün Acıqlaması</label>
                                        <input type="text" class='form-control product_description'>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Ürün Tipi</label>
                                        <select class="form-control select-box pro_type">
                                            <option value='0'>Secin</option>
                                                <?php
                foreach (all_product_type() as $item) {
                    echo "<option value='$item->id'>$item->name</option>";
                }
                ?>
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
                            `;
                let data = {
                    crsf_token: crsf_hash,
                    product_id: product_id
                }

                let table_report = '';
                $.post(baseurl + 'urun/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.product_name').val(responses.details_items[0].product_name)
                    $('.simeta_product_name').val(responses.details_items[0].simeta_product_name)
                    $('.simeta_code').val(responses.details_items[0].simeta_code)
                    $('.product_description').val(responses.details_items[0].product_des)
                    $(".category_id").val(responses.details_items[0].pcat)
                    $(".pro_type").val(responses.details_items[0].product_type)
                    $('#image_text_update').val(responses.details_items[0].image);
                    $('.update_image').attr('src', baseurl + '' + responses.details_items[0].image)

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
                            product_id: product_id,
                            crsf_token: crsf_hash,
                            product_name: $('.product_name').val(),
                            simeta_product_name: $('.simeta_product_name').val(),
                            simeta_code: $('.simeta_code').val(),
                            category_id: $('.category_id').val(),
                            product_description: $('.product_description').val(),
                            pro_type: $('.pro_type').val(),
                            image: $('#image_text_update').val()
                        }


                        $.post(baseurl + 'urun/update', data_post, (response) => {
                            // console.log(data_post)
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
                            }
                            else if (data.status == 410) {
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

                $('#fileupload_update').fileupload({
                    url: baseurl + 'upload/file_upload',
                    dataType: 'json',
                    formData: {
                        '<?= $this->security->get_csrf_token_name() ?>': crsf_hash,
                        'path': '/userfiles/product/'
                    },
                    done: function(e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function(index, file) {
                            img = file.name;
                        });

                        $('#image_text_update').val('/userfiles/product/' + img);
                    },
                    progressall: function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');



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
                        url:  baseurl+'product/info',
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
</script>
