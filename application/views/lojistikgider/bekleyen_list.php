<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Lojistik Gider</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">

                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>

                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th>Araç</th>
                        <th>Gider Kalemi</th>
                        <th>Miktar</th>
                        <th>Birim</th>
                        <th>Birim Fiyatı</th>
                        <th>Toplam Fiyat</th>
                        <th>Açıklama</th>
                        <th>Detaylar</th>
                        <th>İşlem</th>


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>

                        <th>Araç</th>
                        <th>Gider Kalemi</th>
                        <th>Miktar</th>
                        <th>Birim</th>
                        <th>Birim Fiyatı</th>
                        <th>Toplam Fiyat</th>
                        <th>Açıklama</th>
                        <th>Detaylar</th>
                        <th>İşlem</th>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    var url = '<?php echo base_url() ?>razilastirma/file_handling';


    $(document).ready(function () {
        draw_data()
    });

    function draw_data() {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('lojistikgider/ajax_list_bekleyen')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });
    }
    $(document).on('click', ".gider_onay", function (e) {
        let onay_id = $(this).attr('onay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Onay',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Gideri Onaylamak İçin Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim Onayladım" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-success',
                    action: function () {

                        let desc = $('#desc').val()
                        let placeholder = $('#desc').attr('placeholder');
                        let value = $('#desc').val()
                        if (value.length == 0) {
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc: desc,
                            onay_id: onay_id,
                            status: 1,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/gider_onay_iptal', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 'Success') {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
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
                                                $('#invoices').DataTable().destroy();
                                                draw_data()
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 'Error') {

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })


                    }
                },
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

    $(document).on('click', ".gider_iptal", function (e) {
        let onay_id = $(this).attr('onay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Gideri İptal Etmek İçin Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim İptal Ediyorum" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Gideri İptal Et',
                    btnClass: 'btn-red',
                    action: function () {
                        let desc = $('#desc').val()
                        let placeholder = $('#desc').attr('placeholder');
                        let value = $('#desc').val()
                        if (value.length == 0) {
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc: desc,
                            onay_id: onay_id,
                            status: 2,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistikgider/gider_onay_iptal', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 'Success') {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
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
                                                $('#invoices').DataTable().destroy();
                                                draw_data();

                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 'Error') {

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
                        })


                    }
                },
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
