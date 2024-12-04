<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Podraci Listesi </span></h4>
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
                        <td>#</td>
                        <th>Firma Adı</th>
                        <th>Yetkili Adı</th>
                        <th>Telefon</th>
                        <th>Adres</th>
                        <th>Ana Cari</th>
                        <th>Alt Podradci</th>
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
                'url': baseurl + 'podradci/ajax_list',
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
                    text: '<i class="fa fa-plus"></i> Yeni Podradçı Elave et',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Yeni Podradçı Elave et',
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
                                       <label>Firma Adı</label>
                                       <input type="text" class='form-control company'>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label>Yetkili Adı</label>
                                       <input type="text" class='form-control yetkili_kisi'>
                                    </div>
                                         <div class="form-group col-md-6">
                                       <label>Yetkili Telefon</label>
                                       <input type="text" class='form-control yetkili_telefon'>
                                    </div>
                                     <div class="form-group col-md-6">
                                       <label>Sektör</label>
                                       <input type="text" class='form-control sektor'>
                                    </div>
                                        <div class="form-group col-md-6">
                                       <label>Adres</label>
                                       <input type="text" class='form-control adres'>
                                    </div>
                                          <div class="form-group col-md-6">
                                       <label>Telefon</label>
                                       <input type="text" class='form-control telefon'>
                                    </div>
                                    <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Cari</label>
                                       <select class="form-control select-box ana_cari">
                                        <option value="0">Bağlı Olduğu Cari</option>
                                        <?php foreach (all_customer() as $items){
                                echo "<option value='$items->id'>$items->company</option>";
                            } ?>
                                        </select>
                                    </div>
                                     <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Alt Podradçi</label>
                                       <select class="form-control select-box parent_id">
                                        <option value="0">Bağlı Olduğu Podradci</option>
                                        <?php foreach (all_list_podradci() as $items){
                                $new_title = parent_podradci_kontrol_list($items->id).$items->company;
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

                            `,
                            buttons: {
                                formSubmit: {
                                    text: 'Gondər',
                                    btnClass: 'btn-blue',
                                    action: function() {
                                        let ana_cari =  parseInt($('.ana_cari').val());
                                        if(!ana_cari){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat',
                                                content:'Bağlı Olduğu Cari Zorunludur',
                                            });
                                            return false;

                                        }
                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            company: $('.company').val(),
                                            yetkili_kisi: $('.yetkili_kisi').val(),
                                            yetkili_telefon: $('.yetkili_telefon').val(),
                                            sektor: $('.sektor').val(),
                                            adres: $('.adres').val(),
                                            telefon: $('.telefon').val(),
                                            ana_cari: $('.ana_cari').val(),
                                            desc: $('.desc').val(),
                                            parent_id: $('.parent_id').val(),
                                        }

                                        $.post(baseurl + 'podradci/create', data_post, (response) => {
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
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                }
            ],

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
            columnClass: "col-md-8 mx-auto",
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
                                       <label>Firma Adı</label>
                                       <input type="text" class='form-control company'>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label>Yetkili Adı</label>
                                       <input type="text" class='form-control yetkili_kisi'>
                                    </div>
                                         <div class="form-group col-md-6">
                                       <label>Yetkili Telefon</label>
                                       <input type="text" class='form-control yetkili_telefon'>
                                    </div>
                                     <div class="form-group col-md-6">
                                       <label>Sektör</label>
                                       <input type="text" class='form-control sektor'>
                                    </div>
                                        <div class="form-group col-md-6">
                                       <label>Adres</label>
                                       <input type="text" class='form-control adres'>
                                    </div>
                                          <div class="form-group col-md-6">
                                       <label>Telefon</label>
                                       <input type="text" class='form-control telefon'>
                                    </div>
                                    <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Cari</label>
                                       <select class="form-control select-box ana_cari">
                                        <option value="0">Bağlı Olduğu Cari</option>
                                        <?php foreach (all_customer() as $items){
                        echo "<option value='$items->id'>$items->company</option>";
                    } ?>
                                        </select>
                                    </div>
                                     <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Alt Podradçi</label>
                                       <select class="form-control select-box parent_id">
                                        <option value="0">Bağlı Olduğu Podradci</option>
                                        <?php foreach (all_list_podradci() as $items){
                        $new_title = parent_podradci_kontrol_list($items->id).$items->company;
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
                $.post(baseurl + 'podradci/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.company').val(responses.items.company);
                    $('.yetkili_kisi').val(responses.items.yetkili_kisi);
                    $('.yetkili_telefon').val(responses.items.yetkili_telefon);
                    $('.sektor').val(responses.items.sektor);
                    $('.adres').val(responses.items.adres);
                    $('.telefon').val(responses.items.telefon);
                    $('.desc').val(responses.items.desc);

                    $('.ana_cari').val(responses.items.ana_cari).select2().trigger('change')
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
                            crsf_token: crsf_hash,
                            company: $('.company').val(),
                            id: asama_id,
                            yetkili_kisi: $('.yetkili_kisi').val(),
                            yetkili_telefon: $('.yetkili_telefon').val(),
                            sektor: $('.sektor').val(),
                            adres: $('.adres').val(),
                            telefon: $('.telefon').val(),
                            ana_cari: $('.ana_cari').val(),
                            desc: $('.desc').val(),
                            parent_id: $('.parent_id').val(),
                        }

                        $.post(baseurl + 'podradci/update', data_post, (response) => {
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
                        $.post(baseurl + 'podradci/delete', data, (response) => {
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
</script>