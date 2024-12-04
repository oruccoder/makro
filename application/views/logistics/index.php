<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Lojistik Satınalma</span></h4>
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
                                        <table id="invoices" class="table datatable-show-all"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Oluşturma Tarihi</th>
                                                <th>Talep No</th>
                                                <th>Durum</th>
                                                <th>Formu Oluşturan Personel</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Oluşturma Tarihi</th>
                                                <th>Talep No</th>
                                                <th>Durum</th>
                                                <th>Formu Oluşturan Personel</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </tfoot>
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
    <script type="text/javascript">

        var url = '<?php echo base_url() ?>razilastirma/file_handling';



        function new_draw_data(prje_id){
            $('#todotable').DataTable().destroy();
            $('#todotable').DataTable({
                "processing": true,
                "serverSide": true,
                aLengthMenu: [
                    [ 10, 50, 100, 200,-1],
                    [10, 50, 100, 200,"Tümü"]
                ],
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('data-block', '0');
                    $(row).attr('style', data[13]);
                },
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('razilastirma/todo_load_list_forma2')?>",
                    "type": "POST",
                    data: {'pid': prje_id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                "columnDefs": [
                    {
                        "targets": [1],
                        "orderable": true,
                    },
                ],

            });
        }

        $(document).ready(function () {
            draw_data()
        });
        function draw_data() {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('logistics/ajax_list')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [

                ]
            });
        }

        $(document).on('click', ".talep_iptal", function (e) {
            let talep_id = $(this).attr('talep_id');
            let status = 3;
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Talebi İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'İptal Et',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            var name = this.$content.find('.name').val();
                            if (!name) {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Açıklama Zorunludur',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });

                                return false;

                            }

                            let desc = $('#desc').val()
                            jQuery.ajax({
                                url: baseurl + 'logistics/sf_talep_iptal',
                                dataType: "json",
                                method: 'post',
                                data: 'desc=' + desc + '&status=' + status + '&talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $(this).html('Bekleyiniz');
                                    $(this).prop('disabled', true); // disable button

                                },
                                success: function (data) {
                                    if (data.status == "Success") {
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Başarılı',
                                            content:data.message,
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
                                    } else {
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Dikkat',
                                            content:data.message,
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
                                    }
                                    $('#loading-box').addClass('d-none');
                                },
                                error: function (data) {
                                    $.alert(data.message);
                                    $('#loading-box').addClass('d-none');
                                }
                            });


                        }
                    },
                    cancel: {
                        text: 'Vazgeç',
                        btnClass: "btn btn-warning btn-sm close",
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
