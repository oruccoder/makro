<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Cari Onaylama Bildirimi</span></h4>
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
                                        <table class="table datatable-show-all" id="personel" width="100%">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>No</td>
                                                <td>Bordro Tarihi</td>
                                                <td>Proje</td>
                                                <td>Oluşturan Personel</td>
                                                <td>Açıklama</td>
                                                <td>Durum</td>
                                                <td>Detaylar</td>
                                            </tr>
                                            </thead>
                                        </table>
                                        <button class="iptal btn btn-danger" data-id="123" data-href="salary/details/123">Detaylar</button>
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


<script>
    $(document).ready(function () {
    $('.select-box').select2();
    draw_data();
    
    $(document).on('click', '.iptal', function () {
        let id = $(this).data('id');
        let url = $(this).data('href');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modalNo').text(data.no);
                $('#modalBordroTarihi').text(data.bordro_tarihi);
                $('#modalProje').text(data.proje);
                $('#modalPersonel').text(data.personel);
                $('#modalAciklama').text(data.aciklama);
                $('#modalDurum').text(data.durum);
                
                $('#approveModal').modal('show');
                
                $('.approve-btn').off('click').on('click', function () {
                    approve_request(id);
                });

                $('.reject-btn').off('click').on('click', function () {
                    reject_request(id);
                });
            }
        });
    });
});

function approve_request(id) {
    $.ajax({
        url: "<?php echo site_url('salary/approve')?>",
        type: "POST",
        data: { id: id },
        success: function (response) {
            alert("Onaylandı!");
            $('#approveModal').modal('hide');
            $('#personel').DataTable().ajax.reload();
        }
    });
}

function reject_request(id) {
    $.ajax({
        url: "<?php echo site_url('salary/reject')?>",
        type: "POST",
        data: { id: id },
        success: function (response) {
            alert("Reddedildi!");
            $('#approveModal').modal('hide');
            $('#personel').DataTable().ajax.reload();
        }
    });
}


    $(document).on('click', ".iptal", function (e) {
        let bordro_id = $(this).data('id');
        let status = 3;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Bordro İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
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
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            bordro_id: bordro_id,
                            status: status,
                            desc: name,
                        }
                        $.post(baseurl + 'salary/status_change', data, (response) => {
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
                                            action: function () {
                                                $('#personel').DataTable().destroy();
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