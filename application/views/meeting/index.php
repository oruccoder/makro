<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Toplantilar </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>


<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="tab-content px-1 pt-1">
                    <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab"
                         aria-expanded="true">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>

                        <table id="meeting_table" class="table datatable-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <td>#</td>
                                <th>Kodu</th>
                                <th>isteyen</th>
                                <th>oluşturan</th>
                                <th>Onaylayan</th>
                                <th>zaman</th>
                                <th>tipi</th>
                                <th>yer</th>
                                <th>durum</th>
                                <th>oluşturulma tarihi</th>
                                <th>onaylanma tarihi</th>
                                <!-- <th>iptal tarihi</th> -->
                                <th>İşlem</th>
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

<script>
    $(document).ready(function () {
        $('.select2').select2();
        draw_data();
    });


    function draw_data() {
        $('#meeting_table').DataTable({

            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': baseurl + 'Meeting/ajax_list',
                'type': 'POST',
                'data': {}
            },
            'columnDefs': [{
                'targets': [0],
                'orderable': false,
            },],
            dom: 'Blfrtip',
            buttons: [

                {
                    text: '<i class="fa fa-plus"></i> Yeni Toplantı Oluştur',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Toplantı Oluştur',
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

                                    <div class="form-group col-md-4">
                                       <label>Talep Eden</label>
                                       <select class="form-control select-box by_user zorunlu">
                                            <option value='0'>Seçin</option>
                                                <?php
                            foreach (all_personel() as $item) {
                                echo "<option value='$item->username'>$item->name</option>";
                            }
                            ?>
                                        </select>
                                    </div>

 
                                    <div class="form-group col-md-4">
                                    <label>Toplantı tipi</label>
                                        <select class="form-control select-box type zorunlu">
                                            <option value='0'>Seçin</option>
                                            <option value='offline'>offline</option>
                                            <option value='online'>online</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-4">
                                       <label>zaman</label>
                                       <input class="form-control time datetime_pickers" type="text">
                                    </div>


                                    
                                </div><hr>

                                <div class="form-row">

                                <div class="form-group col-md-6">
                                       <label>Onaylayıcı Kişi</label>
                                       <select class="form-control select-box confirm_user zorunlu">
                                            <option value='0'>Seçin</option>
                                                <?php
                            foreach (all_personel() as $item) {
                                echo "<option value='$item->id'>$item->name</option>";
                            }
                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6">
                                       <label>Toplantı yeri</label>
                                       <input class="form-control location" type="text">
                                    </div>

                                </div><hr>


                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label>Açıklama</label>
                                        <textarea class='form-control description' rows="5"></textarea>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label>Katılacak Kişiler</label>
                                        <select class="form-control members select-box" multiple>
                                            <option value='0'>Seçin</option>
                                                <?php
                            foreach (all_personel() as $item) {
                                echo "<option value='$item->id'>$item->name</option>";
                            }
                            ?>
                                        </select>
                                        </div>

                                </div>                               

                            </div>

                            `,
                            buttons: {
                                formSubmit: {
                                    text: 'Oluştur',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let members = $('.members').val();
                                        let requred = $('.zorunlu').length;
                                        let requred_count = 0
                                        if (!members.length) {
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Katılacak Kişileri Seçmelisiniz',
                                                buttons: {
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        for (let i = 0; i < requred; i++) {
                                            let values = $('.zorunlu').eq(i).val();
                                            if (parseInt(values) == 0) {
                                                requred_count++
                                            }
                                        }
                                        if ($('.time').val() == '') {
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Tarih Zorunludur',
                                                buttons: {
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        if (requred_count) {
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Zorunlu Alanlar Mevcut',
                                                buttons: {
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }

                                        $('#loading-box').removeClass('d-none');
                                        let data_post = {
                                            crsf_token: crsf_hash,
                                            by_user: $('.by_user').val(),
                                            location: $('.location').val(),
                                            time: $('.time').val(),
                                            description: $('.description').val(),
                                            type: $('.type').val(),
                                            confirm_user: $('.confirm_user').val(),
                                            members: $('.members').val(),
                                        }

                                        $.post(baseurl + 'meeting/create', data_post, (response) => {

                                            let data = jQuery.parseJSON(response);
                                            if (data.status == 200) {
                                                $('#loading-box').addClass('d-none');
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
                                                                $('#meeting_table').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            } else if (data.status == 410) {
                                                $('#loading-box').addClass('d-none');
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
                                    action: function () {
                                        table_product_id_ar = [];
                                    }
                                }
                            },
                            onContentReady: function () {

                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $('.datetime_pickers').datetimepicker({
                                    dayOfWeekStart: 1,
                                    lang: 'tr',
                                });

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


    $(document).on('click', '.confirm', function () {
        let meeting_id = $(this).attr('meeting_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Toplantı onayla',
            icon: 'fas fa-check 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
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

                                    <div class="form-group col-md-4">
                                    <label>Toplantı tipi</label>
                                        <select class="form-control select-box type">
                                            <option value='0'>Seçin</option>
                                            <option value='offline'>offline</option>
                                            <option value='online'>online</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                       <label>zaman</label>
                                       <input class="form-control time datetime_pickers" type="text">
                                    </div>

                                    <div class="form-group col-md-4">
                                       <label>Toplantı yeri</label>
                                       <input class="form-control location" type="text">
                                    </div>

                                </div><hr>

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label>Açıklama</label>
                                        <textarea class='form-control description' rows="5"></textarea>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label>Katılacak Kişiler</label>
                                        <select class="form-control members select-box" multiple>
                                                <?php
                    foreach (all_users() as $item) {
                        echo "<option value='$item->id'>$item->username</option>";
                    }
                    ?>
                                        </select>
                                        </div>

                                </div>                               

                            </div>
            `;
                let data = {
                    crsf_token: crsf_hash,
                    meeting_id: meeting_id
                }

                let table_report = '';
                $.post(baseurl + 'meeting/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('.type').val(responses.details_items[0].type)
                    $('.time').val(responses.details_items[0].time)
                    $('.location').val(responses.details_items[0].location)
                    $('.description').val(responses.details_items[0].description)

                    let user_id = [];
                    for (let i = 0; i < responses.details_items.length; i++) {
                        user_id.push(responses.details_items[i].user_id)
                    }

                    $('.members').val(user_id)

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },

            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {

                        let data_post = {
                            meeting_id: meeting_id,
                            crsf_token: crsf_hash,
                            type: $('.type').val(),
                            time: $('.time').val(),
                            location: $('.location').val(),
                            description: $('.description').val(),
                            members: $('.members').val(),
                        }


                        $.post(baseurl + 'meeting/update', data_post, (response) => {
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
                                                $('#meeting_table').DataTable().destroy();
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

                $('.datetime_pickers').datetimepicker({
                    dayOfWeekStart: 1,
                    lang: 'tr',
                });
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


    $(document).on('click', '.cancel', function () {
        let meeting_id = $(this).attr('meeting_id')
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
                '<p>İptal Etmek Üzeresiniz Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            meeting_id: meeting_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'meeting/cancel', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.code == 200) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
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
                                                $('#meeting_table').DataTable().destroy();
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

    $(document).on('click', '.open', function () {
        let meeting_id = $(this).attr('meeting_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Toplantıya katılan kişiler',
            icon: 'fa-solid fa-eye 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = '<ul class="list-group"> </ul>';
                let responses;


                let data = {
                    crsf_token: crsf_hash,
                    meeting_id: meeting_id
                }

                let table_report = '';
                $.post(baseurl + 'meeting/members', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    var i = 0;

                    $.each(responses.details_member, function (key, value) {
                        i++
                        html = html + "<li class='list-group-item list-group-item-dark'>" + i + ' - ' + value.user_name + "</li>"
                    });

                    $('.list-group').html(html)

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },

            buttons: {

                cancel: {
                    text: 'Kapat',
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
    })
</script>