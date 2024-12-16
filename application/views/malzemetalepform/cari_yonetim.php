<div class="page-header">
    <?php
    $this->load->view('malzemetalepform/viewheader');
    ?>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="col col-xs-12 col-sm-12 col-md-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="border-bottom pb-2"><b>Talep Bilgileri</b></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Proje :</th>
                                        <td>
                                <span data-popup="popover" title="Proje Adı" data-trigger="hover" data-content="<?php echo proje_name($details->proje_id)?>">
                                    <a target="_blank" href="/projects/explore?id=<?php echo $details->proje_id?>">
                                        <?php echo proje_code($details->proje_id)?></a>
                                </span>
                                        </td>
                                        <th>Şirket :</th>
                                        <td>Makro 2000 A.Ş</td>
                                    </tr>
                                    <tr>
                                        <th>Proje Bölümü :</th>
                                        <td><?php echo bolum_getir($details->bolum_id)?></td>
                                        <th>Proje Aşaması :</th>
                                        <td><?php echo task_to_asama($details->asama_id)?></td>
                                    </tr>
                                    <tr>
                                        <th>Talep Tarihi :</th>
                                        <td><b><?php echo dateformat_new($details->created_at)?></b></td>
                                        <th>Formu Oluşturan :</th>
                                        <td><b><?php echo personel_details($details->aauth)?></b></td>
                                    </tr>
                                    <tr>
                                        <th>Açıklama :</th>
                                        <td><?php echo $details->desc?></td>
                                        <th>Talep Eden :</th>
                                        <td><b><?php echo personel_details($details->talep_eden_user_id)?></b></td>
                                    </tr>

                                    </thead>
                                </table>
                            </div>
                        </div>


                    </div>
                    <?php
                    $this->load->view('malzemetalepform/asama');
                    ?>

                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="border-bottom pb-2 pt-2"><b>Stok Kontrolü Bekleyen Ürünler</b></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered malzemetalep_products">
                                <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Resim</td>
                                    <td>Malzeme</td>
                                    <td>Tanım</td>
                                    <td>Varyant</td>
                                    <td>Kullanım Yeri</td>
                                    <td>Miktar</td>
                                    <td>Birim</td>
                                    <td>Temin Tarihi</td>
                                    <td>Aciliyet Durumu</td>
                                    <td>Durum</td>
                                    <td>Satın Alma Personeli</td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php if($talep_products): ?>
                                    <?php foreach ($talep_products as $key => $items): ?>
                                        <tr>
                                            <td><?php echo ++$key; ?></td> <!-- Artırılmış key değeri -->
                                            <td><img src="<?php echo $items['image']; ?>" alt="Product Image" style="max-width: 100px; height: auto;"></td> <!-- Ürün resmi -->
                                            <td><?php echo $items['product_name']; ?></td> <!-- Ürün adı -->
                                            <td><?php echo $items['product_desc']; ?></td>
                                            <td><?php echo $items['varyant']; ?></td>
                                            <td><?php echo $items['kullanim_yeri']; ?></td>
                                            <td><?php echo amountFormat_s($items['qty']); ?></td>
                                            <td><?php echo $items['birim']; ?></td>
                                            <td><?php echo $items['temin_date']; ?></td>
                                            <td><?php echo $items['aciliyet']; ?></td>
                                            <td><?php echo $items['status']; ?></td>
                                            <td><?php echo (malzemetalep_item_satinalma($items['id'])['status']) ? malzemetalep_item_satinalma($items['id'])['personel_name'] : 'Personel Atanmamış' ; ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>

    $(document).on('click', '.onayla', function () {
        const onay_id = $(this).data('onay-id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Onay',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: "Onay Vermek Üzeresiniz Emin Misiniz?",
            buttons: {
                formSubmit: {
                    text:'Onay Ver',
                    btnClass:'btn btn-info btn-sm',
                    action:function (){
                        $.ajax({
                            url: baseurl + 'malzemetalepform/talep_form_onayi', // Sunucuya gönderilecek endpoint
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                onay_id: onay_id,
                                talep_id: $('#talep_id').val()
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                                action: function () {
                                                    location.reload();
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
                                        title: 'Dikkat!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
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
        });
    });
    $(document).on('change','.all_checked',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_checked').prop('checked',true)
        }
        else {
            $('.one_checked').prop('checked',false)
        }
    })


    //nakliye talep id ve talep form product ıd ile gönderip statusu 14 yapacağım
    $(document).on('click','.satinalma_atama',function() {
        let checkedCount = $('.one_checked:checked').length;

        if (checkedCount === 0) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons: {
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }

        let urunDetails = [];
        $('.one_checked:checked').each(function () {
            urunDetails.push({
                item_id: $(this).data('item-id')
            });
        });

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Personel Ataması',
            icon: 'fa fa-users',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: `
        <div>
            <p>Satın Alma Personeli Seçiniz</p>
            <select class="form-control select-box satinalma_user_id select2-personel">
                ${personelOptions()}
            </select>
        </div>
    `,
            buttons: {
                formSubmit: {
                    text: 'Atama Yap',
                    btnClass: 'btn btn-info btn-sm',
                    action: function () {
                        // Seçili personel kontrolü
                        const satinalmaUserId = $('.satinalma_user_id').val();
                        if (!satinalmaUserId || satinalmaUserId === '0') {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Lütfen bir satın alma personeli seçiniz!',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark"
                                    }
                                }
                            });
                            return false; // İşlemi durdur
                        }

                        // AJAX ile sunucuya veri gönder
                        $.ajax({
                            url: baseurl + 'malzemetalepform/satinalma_user_atama',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                satinalma_user_id: satinalmaUserId,
                                urunDetails: urunDetails,
                                talep_id: $('#talep_id').val()
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                                action: function () {
                                                    location.reload();
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
                                        title: 'Dikkat!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
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
                initializeSelect2();
                // İçerik yüklendiğinde yapılacak işlemler
            }
        });




    });

    function initializeSelect2() {
        $('.select-box').select2({
            placeholder: 'Satınalama Personeli Seçiniz',
            dropdownParent: $(".jconfirm-box-container")
        });
    }

    function personelOptions() {
        return `
         <option value="">Personel Seçiniz</option>
        <?php foreach (all_personel() as $blm): ?>
            <option value="<?= $blm->id; ?>"><?= $blm->name; ?></option>
        <?php endforeach; ?>
    `;
    }
</script>