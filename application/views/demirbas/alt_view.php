<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold"><?php echo $details->code.' - '.$details->name?> Yönetimi</span></h4>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table" id="demisbas_list" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Gider Kodu</th>
                                            <th>Adı</th>
                                            <th>Toplam Gider</th>
                                            <th>İşlemler</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        draw_data();
    });

    function draw_data() {
        $('#demisbas_list').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('demirbas/ajax_list_view_alt')?>",
                'type': 'POST',
                'data': {'demisbas_id':'<?php echo $demisbas_id?>'}
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,

                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });
    }

    $(document).on('click', '.edit_button', function() {
        let demirbas_id = $(this).attr('demirbas_id');
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
                    `<form action="" class="formName" id='data_form'>

                                         <div class="form-group col-md-12">
                                          <label for="name">Adı</label>
                                          <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                          <div class="form-group col-md-12">
                                          <label for="name">Açıklama</label>
                                         <input class='form-control' id='desc' name="desc">
                                        </div>
                                        </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    demirbas_id: demirbas_id
                }

                let table_report = '';
                $.post(baseurl + 'demirbas/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#name').val(responses.details_items.name)
                    $('#desc').val(responses.details_items.desc)
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
                            demirbas_id: demirbas_id,
                            crsf_token: crsf_hash,
                            name: $('#name').val(),
                            desc: $('#desc').val(),
                        }
                        $.post(baseurl + 'demirbas/update', data_post, (response) => {
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
                                                $('#demisbas_list').DataTable().destroy();
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
</script>