<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Fehle Kartı</span></h4>
            <a type="button" href="#" class="header-elements-toggle text-body d-lg-none menu-right"><i class="icon-more"></i></a>

        </div>

    </div>
</div>
<script>
    $('.menu-right').click(function(){

        $('#menu-right').removeClass('d-none');
        $('#menu-right').toggleClass('active')
    })
</script>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="d-lg-flex align-items-lg-start">
                    <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-none sidebar-expand-lg profil_sidebar">
                        <div class="sidebar-content">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-img-actions d-inline-block mb-3">
                                        <img class="img-fluid rounded-circle" id="profile_images"
                                             src="<?php echo base_url('userfiles/employee/' . fehle_picture_url($details->id)); ?>"
                                             width="170" height="170" alt="">

                                    </div>

                                    <h6 class="font-weight-semibold mb-0"><?php echo $details->name; ?></h6>
                                    <span class="d-block opacity-75"><?php echo $details->job ?></span>

                                </div>

                                <ul class="nav nav-sidebar">
                                    <li class="nav-item">
                                        <a href="#profile" class="nav-link active" id="base-tab2" data-toggle="tab">
                                            <i class="icon-user"></i>
                                            Fehle Kart Bilgileri
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#orders" class="nav-link" id="base-tab5" data-toggle="tab">
                                            <i class="fa fa-file"></i>
                                            Raporlar
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content flex-1">
                        <div class="tab-pane fade active show" id="profile">

                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Profil Bilgileri</h6>
                                </div>

                                <div class="card-body">
                                    <form action="<?php echo base_url()?>personelp/new_password" method="post">

                                        <input type="hidden" name="id" class="pers_id" value="<?php echo $details->id ?>">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>AD SOYAD</label>
                                                    <span class="form-control"><?php echo $details->name ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Fin Kodu</label>
                                                    <span class="form-control"><?php echo $details->fin_no ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Seri No</label>
                                                    <span class="form-control"><?php echo $details->seri_no ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Telefon</label>
                                                    <span class="form-control"><?php echo $details->phone ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>AÇIK ADRES</label>
                                                    <span class="form-control"><?php echo $details->address ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>RAYON</label>
                                                    <span class="form-control"><?php echo $details->city ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>ŞEHER</label>
                                                    <span class="form-control"><?php echo $details->region ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>ÜLKE</label>
                                                    <span class="form-control"><?php echo $details->country ?></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>Vatandaşlık</label>
                                                    <span class="form-control"><?php echo vatandaslik($details->vatandaslik)['name'] ?></span>
                                                </div>

                                                <div class="col-lg-3">
                                                    <label>Meslek</label>
                                                    <span class="form-control"><?php echo $details->job ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>SORUMLU PERSONEL </label>
                                                    <span class="form-control"><?php echo personel_details_full($details->sorumlu_pers_id)['name'] ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>GÜNLÜK MAAŞ</label>
                                                    <input type="password" readonly="readonly" id="salary_day"
                                                           value="<?php echo $details->salary_day ?>"
                                                           class="form-control">
                                                    <i class="fa fa-eye-slash" id="salary_day_show"></i>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <label>Profil Fotoğrafı</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="fileupload">
                                                        <label class="custom-file-label"
                                                               for="customFile">Seçiniz</label>
                                                    </div>
                                                    <span class="form-text text-muted">Desteklenen Format :  png, jpg. Max dosya boyuru 2Mb</span>
                                                </div>
                                            </div>
                                        </div>



                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="orders">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Raporlar</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="doctable" class="table tab-content-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $this->lang->line('Title') ?></th>
                                                <th>Dosya Tipi</th>
                                                <th>Araç</th>
                                                <th>Belge Başlangıç Tarihi</th>
                                                <th>Bitiş Tarihi</th>
                                                <th><?php echo $this->lang->line('Action') ?></th>

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
</div>
<div id="menu-right" class="d-none">
    <div class="box">
        <ul class="nav nav-sidebar">
            <li class="nav-item">
                <a href="#profile" class="nav-link active" id="base-tab2" data-toggle="tab">
                    <i class="icon-user"></i>
                    Personel Kart Bilgileri
                </a>
            </li>
            <li class="nav-item">
                <a href="#hesap_ekstresi" class="nav-link" id="base-tab3" data-toggle="tab">
                    <i class="fa fa-list"></i>
                    Hesap Ekstresi
                </a>
            </li>
            <li class="nav-item">
                <a href="#raziekstesi" class="nav-link" id="base-tab9" data-toggle="tab">
                    <i class="fa fa-list"></i>
                    Razı Ekstresi
                </a>
            </li>
            <li class="nav-item">
                <a href="#inbox" class="nav-link" id="base-tab4" data-toggle="tab">
                    <i class="fa fa-question"></i>
                    İzinler
                </a>
            </li>
            <li class="nav-item">
                <a href="#orders" class="nav-link" id="base-tab5" data-toggle="tab">
                    <i class="fa fa-file"></i>
                    Raporlar
                </a>
            </li>
            <li class="nav-item">
                <a href="#is_avanslari" class="nav-link" id="base-tab6" data-toggle="tab">
                    <i class="fa fa-money-bill"></i>
                    İş Avansları

                </a>
            </li>
            <li class="nav-item">
                <a href="#personel_giderleri" class="nav-link" id="base-tab7" data-toggle="tab">
                    <i class="fa fa-coins"></i>
                    Personel Giderleri

                </a>
            </li>
            <li class="nav-item">
                <a href="#hastalik_mezuniyet" class="nav-link" id="base-tab8" data-toggle="tab">
                    <i class="fa fa-hospital-user"></i>
                    Hastalık ve Mezuniyet
                </a>
            </li>

            <?php
            if ($this->aauth->premission(78)->write) {

                ?>
                <li class="nav-item">
                    <a href="#personel_razi" class="nav-link" id="base-tab8" data-toggle="tab">
                        <i class="fa fa-hospital-user"></i>
                        Personel Razı
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>
<style>


    [id*="menu-"] {
        background: #ffffff;
        bottom: 0;
        color: #858585;
        height: 100%;
        position: absolute;
        top: 0;
        width: 205px;
        z-index: 99;
    }


    #menu-right {
        border-left: 1px solid #d9d9d9;
        top: 122px;
        right: 0;
        width: 205px;
        -webkit-transform: translate3d(205px,0,0);
        -moz-transform: translate3d(205px,0,0);
        transform: translate3d(205px,0,0);
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }
    #menu-right.active {
        right: 0;
        -webkit-transform: translate3d(0,0,0);
        -moz-transform: translate3d(0,0,0);
        transform: translate3d(0,0,0);
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }
    section.active, header.active, .intro.active, #menu-left.active, footer.active {
        -webkit-transform: translate3d(205px,0,0);
        -moz-transform: translate3d(205px,0,0);
        transform: translate3d(205px,0,0);
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }
    #extres_length, #extres_info, #extres_paginate, #extres_filter {
        display: none;
    }



    #extre_mezuniyet_length, #extre_mezuniyet_info, #extre_mezuniyet_paginate, #extre_mezuniyet_filter {
        display: none;
    }

    #extre_razi_length, #extre_razi_info, #extre_razi_paginate, #extre_razi_filter {
        display: none;
    }

    #extre_borclandirma_length, #extre_borclandirma_info, #extre_borclandirma_paginate, #extre_borclandirma_filter {
        display: none;
    }

    #extre_razi_length, #extre_razi_info, #extre_razi_paginate, #extre_razi_filter
    {
        display: none;
    }
</style>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>

    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>worker/displaypic';
        $('#fileupload').fileupload({
            url: url,
            formData: {
                '<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?php echo $details->id ?>
            },
            done: function (e, data) {
                let text = data.result

                let result = text.replace(/"/g, '');


                $("#profile_images").attr('src', '<?php echo base_url() ?>userfiles/employee/' + result);

                let data_update = {
                    id: <?php echo $details->id ?>,
                    image: result,
                }
                $.post(baseurl + 'worker/update_image', data_update, (response) => {
                    let responses = jQuery.parseJSON(response);
                    if (responses.status == 200) {
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Başarılı!',
                            content: responses.messages,
                            buttons: {
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                    action: function () {
                                        location.reload()
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


                $('#loading-box').addClass('d-none');




            },
            progressall: function (e, data) {

                $('#loading-box').removeClass('d-none');

            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
    $(document).on('click', '#salary_show', function () {
        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#salary').attr('type') === "password" ? "text" : "password";
                $('#salary').attr("type", new_type);
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

    })

    $(document).on('click', '#bank_salary_show', function () {

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#bank_salary').attr('type') === "password" ? "text" : "password";
                $('#bank_salary').attr("type", new_type);
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
    })

    $(document).on('click', '#net_salary_show', function () {

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#net_salary').attr('type') === "password" ? "text" : "password";
                $('#net_salary').attr("type", new_type);
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
    })

    $(document).on('click', '#salary_day_show', function () {


        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#salary_day').attr('type') === "password" ? "text" : "password";
                $('#salary_day').attr("type", new_type);
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
    })

    $(document).ready(function () {
        draw_data()

        $('#base-tab2').on('click', function () {
            $('.sorting').click()
        });
    });

    $('#base-tab3').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab9').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab7').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab5').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab4').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab6').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab8').on('click', function () {
        $('.sorting').click()
    });

    function draw_data(start_date = '', end_date = '') {
        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('worker/document_load_list')?>",
                "type": "POST",
                'data': {
                    start_date: start_date,
                    end_date: end_date,
                    'cid': <?=$details->id ?>,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Dosya Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Dosya Ekleyin ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Başlangıç Tarihi</label>
      <input type='date' class='form-control baslangic_date'>
    </div>
    <div class="form-group col-md-6">
      <label for="name">Bitiş Tarihi</label>
      <input type='date' class='form-control bitis_date'>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
      <label for="bolum_id">Başlık</label>
       <input type'text' class='form-control title'>
    </div>
       <div class="form-group col-md-3">
      <label for="bolum_id">Dopsya Tipi</label>
           <select class="form-control file_type" id="file_type" name="file_type">
                    <?php foreach (personel_file_type() as $items) {
                                echo "<option value='$items->id'>$items->name</option>";
                            }?>
               </select>
    </div>
     <div class="form-group col-md-3">
      <label for="bolum_id">ETIBARNAME İÇIN ARAÇ SEÇINIZ</label>
           <select class="form-control select-box arac_id" id="arac_id" name="arac_id">
                                   <option value="0">Seçiniz</option>
                                    <?php foreach (araclar() as $items) {
                                echo "<option value='$items->id'>$items->name</option>";
                            }?>
                               </select>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Fayl</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="files[]">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>
       </div>
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sorğunu Açın',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            baslangic_date: $('.baslangic_date').val(),
                                            bitis_date: $('.bitis_date').val(),
                                            title: $('.title').val(),
                                            file_type: $('.file_type').val(),
                                            arac_id: $('.arac_id').val(),
                                            image_text: $('#image_text').val(),
                                            personel_id:  <?php echo $details->id?>,
                                        }
                                        $.post(baseurl + 'worker/create_file', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status == 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#doctable').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            } else if (responses.status == 410) {

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
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                var url = '<?php echo base_url() ?>worker/adddocument';

                                $('#fileupload_').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        var img = 'default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img = file.name;
                                        });

                                        $('#image_text').val(img);
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

    function currencyFormat(num) {
        var deger = num.toFixed(2).replace('.', ',');
        return deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' AZN';
    }
    $(document).on('click', '.eye-permit', function () {
        let permit_id = $(this).data('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İzin Görüntüle',
            icon: 'fa fa-eye',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
                             <div class="row">
                               <div class="card col-md-12">
<p id="text"></p>
									  <ul class="list-group list-group-flush" style="text-align: justify;">
									  </ul>
									</div>
                            </div>
                                </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    permit_id: permit_id,
                }


                let li = '';
                $.post(baseurl + 'personelaction/get_info_permit_confirm', data, (response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if (responses.status == 200) {
                        $('#text').empty().text('Açıklama : '+responses.details_permit.description)
                        $.each(responses.item, function (index, item) {

                            let durum = 'Bekliyor';
                            let desc = '';
                            if (item.staff_status == 1) {
                                durum = 'Onaylandı | '+ item.staff_desc;
                            } else if (item.staff_status == 2) {
                                durum = 'İptal Edildi';
                                desc = `<li>` + item.staff_desc + `</li>`;
                            }
                            li += `<li class="list-group-item"><b>` + item.sort + `. Personel Adı : </b>&nbsp;` + item.name + `</li><ul><li>` + durum + `</li>` + desc + `</ul>`;
                        });

                        $('.list-group-flush').empty().append(li);
                    } else {
                        $('.list-group-flush').empty().append('<p>Bildirim Başlatılmamış</p>');
                    }


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function (index, file) {
                            img = file.name;
                        });

                        $('#image_text').val(img);
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
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click', '.delete-object', function () {
        let permit_id = $(this).data('object-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dosya Sil',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Dosyayı Silmek İstediğinizden Emin Misiniz',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            id: permit_id,
                        }
                        $.post(baseurl + 'worker/delete_document', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#doctable').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 410) {

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
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function (index, file) {
                            img = file.name;
                        });

                        $('#image_text').val(img);
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
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })


</script>