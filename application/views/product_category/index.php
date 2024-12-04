<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Üren kateqorileri </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="product_table" class="table datatable-responsive">
                    <thead>
                    <tr>
                        <td>#</td>
                        <th>Code</th>
                        <th>Kategori Ağacı</th>
                        <th>Kateqori Adı</th>
                        <th>Numaric</th>
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

<script src="<?php echo base_url('app-assets/product_category/js/product_category.js') ?>"></script>

<script>
    $(document).ready(function () {
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
                'url': baseurl + 'newproductcategory/ajax_list',
                'type': 'POST',
            },
            'columnDefs': [{
                'targets': [0],
                'orderable': false,
            },],
            dom: 'Blfrtip',
            buttons: [

                {
                    text: '<i class="fa fa-plus"></i> Yeni Kateqori Elave et',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Yeni Kateqori Elave et',
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

                                   <div class="form-group col-md-12">
                                       <label>Sorumlu Personel</label>
                                       <select class="form-control select-box sorumlu_perid" id="sorumlu_perid">
                                                <?php foreach (all_personel() as $emp){
                                                                $emp_id=$emp->id;
                                                                $name=$emp->name;
                                                                ?>
                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                       <label>Kateqori Adı (AZ)</label>
                                       <input type="text" class='form-control title'>
                                    </div>
                                       <div class="form-group col-md-12">
                                       <label>Kateqori Adı (TR)</label>
                                       <input type="text" class='form-control tr_title'>
                                    </div>
                                       <div class="form-group col-md-12">
                                       <label>Kateqori Adı (EN)</label>
                                       <input type="text" class='form-control en_title'>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Üst Kateqorisi</label>
                                        <select class="form-control select-box parent_id">
                                        <option value='0'>Secin</option>
                                            <?php
                            foreach (category_list_() as $item) :

                                $id = $item['id'];
                                $title = $item['title'];
                                $new_title = _ust_kategori_kontrol($id).$title;

                                echo "<option value='$id'>$new_title</option>";

                            endforeach;
                            ?>
                                        </select>


                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Grup Kodu (HARF)</label>
                                            <input type="text" class='form-control code'>
                                        </select>


                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Grup Kodu(Sayısal)</label>
                                            <input type="text" class='form-control num_code'>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Kısa Kod</label>
                                            <input type="text" class='form-control product_varyant'>
                                        </select>
                                    </div>

                                </div>

                            </div>
                            `,
                            buttons: {
                                formSubmit: {
                                    text: 'Gondər',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            title: $('.title').val(),
                                            tr_title: $('.tr_title').val(),
                                            en_title: $('.en_title').val(),
                                            parent_id: $('.parent_id').val(),
                                            num_code: $('.num_code').val(),
                                            code: $('.code').val(),
                                            product_varyant: $('.product_varyant').val(),
                                            sorumlu_perid: $('.sorumlu_perid').val(),
                                        }

                                        $.post(baseurl + 'newproductcategory/create', data_post, (response) => {
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
                                                            action: function () {
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
                                    action: function () {
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

    $(document).on('click','.new_numaric_create',function (){
        let cat_id = $(this).attr('cat_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Başlangıç Numarası',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<div class="form-group col-md-12">
                                       <label>Başlangıç Numarası</label>
                                       <input type="number" class='form-control numaric_val'>
                                    </div>`,

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data_post = {
                            cat_id: cat_id,
                            crsf_token: crsf_hash,
                            numaric_val: $('.numaric_val').val(),
                        }
                        $.post(baseurl + 'newproductcategory/numaric_insert', data_post, (response) => {
                            console.log(data_post)
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
                                            action: function () {
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
                    action: function () {
                        table_product_id_ar = [];
                    }
                }
            },

            onContentReady: function () {

                $('.product').select2({
                    dropdownParent: $(".jconfirm-box-container"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder: 'Seçiniz',
                    language: {
                        inputTooShort: function () {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method: 'POST',
                        url: baseurl + 'product/info',
                        dataType: 'json',
                        data: function (params) {
                            let query = {
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
                }).on('change', function (data) {
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
    })


    $(document).on('click', '.edit', function () {
        let product_cat_id = $(this).attr('product_cat_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Kateqori Düzenle',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html +=
                    `
            <div class='mb-3'>
                <div class="form-row">

                            <div class="form-group col-md-12">
                                       <label>Sorumlu Personel</label>
                                       <select class="form-control select-box sorumlu_perid" id="sorumlu_perid">
                                                <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                 <div class="form-group col-md-12">
                                       <label>Kateqori Adı (AZ)</label>
                                       <input type="text" class='form-control title'>
                                    </div>
                                       <div class="form-group col-md-12">
                                       <label>Kateqori Adı (TR)</label>
                                       <input type="text" class='form-control tr_title'>
                                    </div>
                                       <div class="form-group col-md-12">
                                       <label>Kateqori Adı (EN)</label>
                                       <input type="text" class='form-control en_title'>
                                    </div>

                    <div class="form-group col-md-12">
                        <label>Üst Kateqorisi</label>
                        <select class="form-control select-box parent_id">
                            <option value='0'>Secin</option>
                                <?php
                    foreach (category_list_() as $item) :

                        $id = $item['id'];
                        $title = $item['title'];
                        $new_title = _ust_kategori_kontrol($id).$title;
                        echo "<option value='$id'>$new_title</option>";

                    endforeach;
                    ?>
                        </select>
                    </div>
                     <div class="form-group col-md-12">
                                        <label>Grup Kodu</label>
                                            <input type="text" class='form-control code'>
                                        </select>


                                    </div>
                                             <div class="form-group col-md-12">
                                        <label>Grup Kodu(Sayısal)</label>
                                            <input type="text" class='form-control num_code'>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Kısa Kod</label>
                                            <input type="text" class='form-control product_varyant'>
                                        </select>
                                    </div>

                </div>
            </div>           
            `;
                let data = {
                    crsf_token: crsf_hash,
                    product_cat_id: product_cat_id
                }

                let table_report = '';
                $.post(baseurl + 'newproductcategory/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.parent_id').val(responses.details_items[0].parent_id)
                    $('.code').val(responses.details_items[0].code_string)
                    $('.sorumlu_perid').val(responses.details_items[0].sorumlu_perid)
                    $('.title').val(responses.details_items[0].title)
                    $('.tr_title').val(responses.details_items[0].tr_title)
                    $('.en_title').val(responses.details_items[0].en_title)
                    $('.num_code').val(responses.details_items[0].code_numaric)
                    $('.product_varyant').val(responses.details_items[0].product_varyant)

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let data_post = {
                            product_cat_id: product_cat_id,
                            crsf_token: crsf_hash,
                            title: $('.title').val(),
                            tr_title: $('.tr_title').val(),
                            en_title: $('.en_title').val(),
                            parent_id: $('.parent_id').val(),
                            code: $('.code').val(),
                            num_code: $('.num_code').val(),
                            product_varyant: $('.product_varyant').val(),
                            sorumlu_perid: $('.sorumlu_perid').val(),
                        }


                        $.post(baseurl + 'newproductcategory/update', data_post, (response) => {
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
                                            action: function () {
                                                table_product_id_ar = [];
                                                $('#product_table').DataTable().destroy();
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
                    action: function () {
                        table_product_id_ar = [];
                    }
                }
            },

            onContentReady: function () {

                $('.product').select2({
                    dropdownParent: $(".jconfirm-box-container"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder: 'Seçiniz',
                    language: {
                        inputTooShort: function () {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method: 'POST',
                        url: baseurl + 'product/info',
                        dataType: 'json',
                        data: function (params) {
                            let query = {
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
                }).on('change', function (data) {
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
    })


    $(document).on('click', '.delete', function () {
        let product_cat_id = $(this).attr('product_cat_id')
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
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            product_cat_id: product_cat_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'newproductcategory/delete', data, (response) => {
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
                                            action: function () {
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