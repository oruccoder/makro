<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Lojistik Görüntüleme</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div id="invoice-template" class="card-body">
                                            <div class="btn-group ">
                                                <a  href="<?php echo '/lojistik/print/' . $details->id; ?>" class="btn btn-success mb-1"><i class="fa fa-print"></i> <?php echo $this->lang->line('Print') ?></a>
                                            </div>

                                            <?php
                                            $disabled='';
                                            if($details->bildirim_durumu) {
                                                $disabled = 'disabled';
                                            }
                                            else {
                                                ?>
                                                <div class="btn-group ">
                                                    <a  href="<?php echo '/lojistik/edit/' . $details->id; ?>" class="btn btn-warning mb-1"><i class="icon-pencil"></i>Düzenle</a>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="btn-group">
                                                <button <?php echo $disabled; ?> type="button" id="onay_sistemi" talep_id ="<?php echo $details->id ; ?>" class="btn btn-info mb-1"><i class="icon-check"></i>Onay Sistemini Başlat</button>
                                            </div>
                                            <div class="btn-group ">
                                                <button id="talep_iptal"  talep_id ="<?php echo $details->id ; ?>"  class="btn btn-danger mb-1">Talebi İptal Et</button>
                                            </div>
                                            <div class="btn-group ">
                                                <button id="talep_onay"  talep_id ="<?php echo $details->id ; ?>"  class="btn btn-success mb-1">Talebi Onayla</button>
                                            </div>
                                            <div id="invoice-company-details" class="row mt-2">
                                                <div class="col-md-4 col-sm-12 text-xs-center text-md-left" style="font-size: 16px;font-weight: 900;"><p></p>
                                                    <h2>Lojistik Talep Formu</h2>
                                                    <p>Talep No : <?php echo $details->talep_no; ?></p>
                                                    <p>Oluştrma Tarihi : <?php echo $details->created_at; ?></p>
                                                    <p>Lojistik Müdürü : <?php echo personel_details($details->lojistik_muduru); ?>&nbsp; &nbsp;<?php echo lojistik_durum_kontrol($details->lojistik_muduru,$details->id)?></p>
                                                    <p>Proje Müdürü : <?php echo personel_details($details->proje_muduru); ?></p>&nbsp;&nbsp;<?php echo lojistik_durum_kontrol($details->proje_muduru,$details->id)?></p>
                                                    <p>Genel Müdürü : <?php echo personel_details($details->genel_mudur); ?></p>&nbsp;&nbsp;<?php echo lojistik_durum_kontrol($details->genel_mudur,$details->id)?></p>
                                                    <p>Açıklama : <?php echo $details->description; ?></p>
                                                </div>
                                            </div>
                                            <div>
                                                <table class="table datatable-show-all">
                                                    <tr>
                                                        <td>#</td>
                                                        <td>Proje Adı</td>
                                                        <td>Başlangıç ve Bitiş Noktası </td>
                                                        <td>Açıklama</td>
                                                        <td>SF NO</td>
                                                        <td>Araç </td>
                                                        <td>Miktar </td>
                                                        <td>Birim </td>
                                                    </tr>
                                                    <?php $i=1; foreach ($items as $item) {
                                                        $location = lojistik_items_location($details->id,$item->id,1);
                                                        $sf_no = lojistik_items_sf($details->id,$item->id,1);
                                                        echo "<tr>
                                    <td>$i</td>
                                    <td>$item->proje_name</td>
                                    <td>$location</td>
                                    <td>$item->desc</td>
                                    <td>$sf_no</td>
                                    <td>$item->arac_name</td>
                                    <td>$item->qty</td>
                                    <td>$item->unit_name</td>
                                </tr>
                                ";
                                                        $i++; } ?>
                                                </table>
                                            </div>
                                        </div>
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
    $(document).on('click', "#talep_iptal", function (e) {
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
                            url: baseurl + 'lojistik/talep_iptal',
                            dataType: "json",
                            method: 'post',
                            data: 'desc=' + desc + '&status=' + status + '&talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                } else {
                                    $.alert(data.message);
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

    $(document).on('click', "#talep_onay", function (e) {
        let talep_id = $(this).attr('talep_id');
        let status = 3;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi Onaylamak Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="İnceledim Onayladım" class="form-control name" />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        jQuery.ajax({
                            url: baseurl + 'lojistik/talep_onay',
                            dataType: "json",
                            method: 'post',
                            data: 'desc=' + desc + '&status=' + status + '&talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
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
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');
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
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                    $.alert(data.message);
                                    $('#loading-box').addClass('d-none');
                                }

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

    $(document).on('click', "#onay_sistemi", function (e) {
        let talep_id = $(this).attr('talep_id');

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
                '<p>Talebi Onaya Sunmak Üzeresiniz? Emin Misiniz?<p/>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        jQuery.ajax({
                            url: baseurl + 'lojistik/talep_onay_start',
                            dataType: "json",
                            method: 'post',
                            data: 'talep_id=' + talep_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $('#loading-box').addClass('d-none');
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
                                                    location.reload();
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
                                        title: 'Dikkat',
                                        content:data.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                }

                            },
                            error: function (data) {
                                $('#loading-box').addClass('d-none');
                                $.alert(data.message);

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
