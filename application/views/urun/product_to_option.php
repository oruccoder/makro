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
        <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="grid_3 grid_4 animated fadeInRight">
                <div class="table-responsive">
                    <div class="row" style="padding-left: 13px;">
                        <div class="col-12">
                            <table id="product_table" class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>Ürün Adı</th>
                                        <th>Ürün Opsiyon Değeri</th>
                                        <th>Açıklaması</th>
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


<style>
    .group-buttons {
        outline: none !important;
        border-radius: 0px !important;
        border: 1px solid gray;
    }
</style>


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
                'url': "<?php echo base_url() . 'productToOption/ajax_list' ?>",
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
                    text: '<i class="fa fa-plus"></i> Yeni Ürün Opsiyonu Elave et',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Yeni Ürün Opsiyonu Elave et',
                            icon: 'fa fa-plus-square 3x',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `
                            <div class='mb-3'>

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Kateqori</label>
                                        <select class="form-control select-box product_id">
                                            <option value='0'>Secin</option>
                                                <?php
                                                foreach (get_all_product() as $item) {
                                                    echo "<option value='$item->id'>$item->name</option>";
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Ürün Tipi</label>
                                        <select class="form-control select-box product_option_value_id">
                                            <option value='0'>Secin</option>
                                                <?php
                                                foreach (get_all_product_option_value() as $item) {
                                                    echo "<option value='$item->id'>$item->name</option>";
                                                }
                                                ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label>Ürün Opsiyon Acıqlaması</label>
                                    <input type="text" class='form-control description'>
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
                                            description: $('.description').val(),
                                            product_id: $('.product_id').val(),
                                            product_option_value_id: $('.product_option_value_id').val(),
                                        }

                                        $.post(baseurl + 'productToOption/create', data_post, (response) => {
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


    $(document).on('click', '.edit', function() {
        let id = $(this).attr('product_to_option_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Opsiyonu Düzenle',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function() {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html += `
                    <div class='mb-3'>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Kateqori</label>
                                <select class="form-control select-box product_id">
                                    <option value='0'>Secin</option>
                                        <?php
                                        foreach (get_all_product() as $item) {
                                            echo "<option value='$item->id'>$item->name</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                                    
                            <div class="form-group col-md-6">
                                <label>Ürün Tipi</label>
                                <select class="form-control select-box product_option_value_id">
                                    <option value='0'>Secin</option>
                                        <?php
                                        foreach (get_all_product_option_value() as $item) {
                                            echo "<option value='$item->id'>$item->name</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                                    
                        </div>
                                    
                        <div class="form-group">
                            <label>Ürün Opsiyon Acıqlaması</label>
                            <input type="text" class='form-control description'>
                        </div>
                                
                    </div>
                `;
                let data = {
                    crsf_token: crsf_hash,
                    id: id
                }


                let table_report = '';
                $.post(baseurl + 'productToOption/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.product_id').val(responses.details_items[0].product_id)
                    $('.product_option_value_id').val(responses.details_items[0].product_option_value_id)
                    $('.description').val(responses.details_items[0].description)

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
                            id: id,
                            crsf_token: crsf_hash,
                            description: $('.description').val(),
                            product_id: $('.product_id').val(),
                            product_option_value_id: $('.product_option_value_id').val(),
                        }

                        $.post(baseurl + 'productToOption/update', data_post, (response) => {
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
                    placeholder: 'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method: 'POST',
                        url: '<?php echo base_url() . 'product/info' ?>',
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
        let id = $(this).attr('product_to_option_id')
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
                        $.post(baseurl + 'productToOption/delete', data, (response) => {
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
</script>