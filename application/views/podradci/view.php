<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">   <?php echo $details->company?> </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="content-inner">
                    <!-- Cover area -->
                    <div class="profile-cover">
                        <div class="profile-cover-img2"></div>
                        <div class="d-flex align-items-center text-center text-lg-start flex-column flex-lg-row position-absolute start-0 end-0 bottom-0">
                            <div class="me-lg-3 mb-2 mb-lg-0">
                                <a href="#">
                                    <img src="<?php echo base_url() . 'userfiles/podradci/'.$details->picture?>" class="img-thumbnail rounded-circle shadow profile_picture" alt="" style="width: 100%;height: 130px;padding: 0;margin-left: 0px;">
                                </a>
                            </div>

                            <div class="pl-3 profile-cover-text text-white">
                                <h1 class="mb-0"> <?php echo $details->company?> </h1>
                                <span class="d-block"><?php echo $details->sektor?> </span>
                            </div>
                        </div>
                    </div>
                    <!-- /cover area -->


                    <!-- Profile navigation -->
                    <div class="border-bottom py-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                   aria-controls="tab1" href="#tab1" role="tab"
                                   aria-selected="true">Cari Kart Bilgileri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-2" data-toggle="tab"
                                   aria-controls="tab2" href="#tab2" role="tab"
                                   aria-selected="true">Belgeler</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab"
                                 aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="name">Firma Adı</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Firma Adı" class="form-control margin-bottom b_input" disabled="" value="<?php echo $details->company?>" name="company">
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="address"> Adres</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder=" Adres" class="form-control margin-bottom b_input" disabled="" name="address" value="<?php echo $details->adres?>" id="mcustomer_address1">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="phone"> Firma Telefon</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder=" Firma Telefon" class="form-control margin-bottom required b_input" disabled="" name="phone" value="<?php echo $details->telefon?>" id="mcustomer_phone">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label" for="name">Yetkili Kişi</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Yetkili Kişi" class="form-control margin-bottom b_input required" disabled="" name="name" value="<?php echo $details->yetkili_kisi?>" id="mcustomer_name">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label" for="name">Yetkili Tel</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Yetkili Tel" class="form-control margin-bottom b_input required" disabled="" name="yetkili_tel" value="<?php echo $details->yetkili_telefon?>" id="yetkili_tel">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="name">Sektör</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Firma Sektörü" class="form-control margin-bottom b_input" disabled="" value="<?php echo $details->sektor?>" name="sektor">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="name">Firma Hakkında Bilgi</label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Firma Hakkında Bilgi" class="form-control margin-bottom b_input" disabled="" value="<?php echo $details->desc?>" name="company_about">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="name">Bağlı Olduğu Cari</label>

                                            <div class="col-sm-8">
                                                <input type="text"  class="form-control margin-bottom b_input" disabled="" value="<?php echo $ana_cari ?>" name="company_about">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="name">Bağlı Olduğu Podradçi</label>

                                            <div class="col-sm-8">
                                                <input type="text"  class="form-control margin-bottom b_input" disabled="" value="<?php echo $alt_podradci?>" name="company_about">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="name">Profil Resmi</label>

                                            <div class="col-sm-8">
                                                <input type="file" class="form-control upload_excel" id="userfile" name="userfile"/>
                                            </div>
                                            <div class="col-sm-2">
                                            <button class="btn btn-outline-info upload_button" podradci_id="<?php echo $details->id?>"><i class="fa fa-upload"></i> Yükle</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="link-tab2" aria-expanded="true">
                                <table id="doctable" class="table datatable-show-all"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Title') ?></th>
                                        <th>Başlangıç Tarihi</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Proje</th>
                                        <th>Dosya Tipi</th>
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
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<style>
    .profile-cover-img2 {
        background-position: 45% 40%;
        background-repeat: no-repeat;
        background-size: 50%;
        height: 8.88rem;
    }
    .rounded-circle{
        border-radius: 0 !important;
    }
</style>

<script>

    $(document).ready(function () {

        draw_data_belgeler();
    })
    $(document).on('click','.upload_button',function (){

        let formData = new FormData();
        formData.append("userfile", userfile.files[0]);
        formData.append("id", $(this).attr('podradci_id'));
        $.ajax({
            type: "POST",
            url: baseurl + 'podradci/upload_profil_picture',
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(responses){
                if (responses.status == 200) {
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        title: 'Dikkat!',
                        content: responses.message,
                        buttons: {
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                                action: function() {
                                    $('.profile_picture').attr("src", responses.filename);

                                }
                            }
                        }
                    });
                }
                else {
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
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
            }
        });

    })

    function draw_data_belgeler(start_date = '', end_date = '') {
        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('podradci/document_load_list')?>",
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
                    text: '<i class="fa fa-file"></i> Yeni Belge Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Belge Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Belge Adı</label>
      <input type="text" class="form-control" id="name" placeholder="Açık Pickup">
    </div>
     <div class="form-group col-md-6">
      <label for="firma_id">Belge Tipi Adı</label>
     <select class="form-control select-box" id="file_type_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (customer_file_type() as $emp){
                            $emp_id = $emp->id;
                            $name = $emp->name;
                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>

  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="baslangic_date">Başlangıç Tarihi</label>
      <input type="date" class="form-control" id="baslangic_date">
    </div>
  <div class="form-group col-md-3">
      <label for="bitis_date">Bitiş Tarihi</label>
      <input type="date" class="form-control" id="bitis_date" ">
    </div>
    <div class="form-group col-md-6">
      <label for="proje_id">Proje</label>
       <select class="form-control select-box" id="proje_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_projects() as $emp){
                            $emp_id = $emp->id;
                            $name = $emp->code;
                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="userfile">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            bitis_date: $('#bitis_date').val(),
                                            baslangic_date: $('#baslangic_date').val(),
                                            file_type_id: $('#file_type_id').val(),
                                            name: $('#name').val(),
                                            proje_id: $('#proje_id').val(),
                                            cari_id: "<?=$details->id ?>",
                                            image_text: $('#image_text').val(),
                                        }
                                        $.post(baseurl + 'podradci/add_document', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status == 'Success') {
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
                                                                draw_data_belgeler();
                                                            }
                                                        }
                                                    }
                                                });

                                            } else if (responses.status == 'Error') {

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

                                $('#fileupload_').fileupload({
                                    url: '<?php echo base_url() ?>podradci/file_handling',
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {

                                        var img = 'default.png';
                                        let responses = data.result;
                                        if(responses.status==200){
                                            $('#image_text').val(responses.filename);

                                        }
                                        else {
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: responses.code,
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                        }

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


    $(document).on('click', ".talep_sil", function (e) {
        let edit_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            columnClass: "small",
            draggable: false,
            content: '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Dosyayı Silmek Üzeresiniz? Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            edit_id: edit_id,
                        }
                        $.post(baseurl + 'customers/remove_document', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 'Success') {
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
                                                draw_data_belgeler();
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 'Error') {

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