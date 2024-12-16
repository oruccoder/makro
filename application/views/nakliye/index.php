<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Nakliye Talebi</span></h4>
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
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="alt_firma" name="alt_firma" >
                                            <option  value="">Alt Firma</option>
                                            <?php foreach (all_customer() as $row)
                                            {
                                                echo "<option value='$row->id'>$row->company</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="status" name="status" >
                                            <option  value="">Durum</option>
                                            <?php foreach (invoice_status() as $rows)
                                            {
                                                ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="proje_id" name="proje_id" >
                                            <option value="">Proje Seçiniz</option>
                                            <option value="0">Projesizler</option>
                                            <?php foreach (all_projects() as $rows)
                                            {
                                                ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="invoice_type_id" name="invoice_type_id" >
                                            <option value="">Fatura Tipi</option>
                                            <?php foreach (invoice_type() as $row) {
                                                echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                               class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                               data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-warning btn-md" id="change_toplu_status" title="Change Status">Durum</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="cari_gider_talep_list" class="table datatable-show-all" width="100%">
                                            <thead>
                                            <tr>
                                                <td>Talep Kodu</td>
                                                <td>Aciliyet</td>
                                                <td>Tarih</td>
                                                <td>Talep Eden</td>
                                                <td>Proje</td>
                                                <td>Tutar</td>
                                                <td>Qalıq Ödeme</td>
                                                <td>Durum</td>
                                                <td>Açıklama</td>
                                                <td>İşlemler</td>
                                            </tr>
                                            </thead>
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
<script>

    var url = '<?php echo base_url() ?>carigidertalepnew/file_handling';
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();

        $('#aauth').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data('aauth');
        });

        $('#paylist').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data('paylist');
        });


        $('#clear').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data();
        });

        function draw_data(aauth = 'absent',) {
            $('#cari_gider_talep_list').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                aLengthMenu: [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "Tümü"]
                ],
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('nakliye/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        aauth: aauth,
                    }
                },
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[13]);

                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Yeni Talep Oluştur',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni İstək Əlavə Edin ',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-8 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id proje_id_new required" id="proje_id">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->code;
                                ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="talep_eden_user_id">Talep Eden</label>
      <select class="form-control select-box required" id="talep_eden_user_id">

            <?php foreach (all_personel() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
    </select>
    </div>
    <div class="form-group col-md-6">
      <label for="firma_id">Təcili</label>
        <select class="form-control select-box" id="progress_status_id">

            <?php foreach (progress_status() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select>

    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
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
                                            let proje_id = $('.proje_id_new').val();
                                            let desc = $('#desc').val();

                                            // Proje ID doğrulama
                                            if (!parseInt(proje_id)) {
                                                showAlert('Proje Zorunludur');
                                                return false;
                                            }

                                            // Açıklama doğrulama
                                            if (!desc) {
                                                showAlert('Açıklama Zorunludur');
                                                return false;
                                            }

                                            $('#loading-box').removeClass('d-none');

                                            // Form verilerini toplama
                                            let data = {
                                                crsf_token: crsf_hash,
                                                progress_status_id: $('#progress_status_id').val(),
                                                talep_eden_user_id: $('#talep_eden_user_id').val(),
                                                proje_id: proje_id,
                                                method: 0,
                                                cari_id: 0,
                                                desc: desc,
                                                image_text: $('#image_text').val(),
                                            };

                                            // POST isteği
                                            $.post(baseurl + 'nakliye/create_save', data, (response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');

                                                if (responses.status === 'Success') {
                                                    showAlert(responses.message, 'Başarılı', 'green', 'fa-check', responses.index);
                                                } else if (responses.status === 'Error') {
                                                    showAlert(responses.message, 'Dikkat!', 'red', 'fa-exclamation');
                                                }
                                            });
                                        }
                                    },
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
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
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
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0,1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        text: 'Nakliye Talep Formu Anlatım PDF',
                        action: function ( e, dt, node, config ) {
                            window.location.href = "/pdf_file/nakliye_talep_formu.pdf";
                        }
                    }
                ]
            });
        };
    })

    // Yardımcı fonksiyon: Uyarı mesajı gösterme
    function showAlert(message, title = 'Dikkat!', type = 'red', icon = 'fa-exclamation', redirectUrl = null) {
        $.alert({
            theme: 'material',
            icon: `fa ${icon}`,
            type: type,
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: title,
            content: message,
            buttons: {
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                    action: redirectUrl ? () => location.href = redirectUrl : null
                }
            }
        });
    }

    $(document).on('click', ".talep_sil", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talep İptal Etmek Üzeresiniz?<p/>' +
                '<p><b>Bu İşleme Ait Qaime ve Gider Hareketleri Var İse İptal Olacaktır</b><p/>' +
                '<input type="text" id="desc" class="form-control desc" placeholder="İptal Sebebi Zorunludur">' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {

                        let name = $('.desc').val()
                        if(!name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'İptal Sebebi Zorunludur',
                                buttons:{
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
                            crsf_token: crsf_hash,
                            file_id:  talep_id,
                            desc:  $('.desc').val(),
                            status:  10
                        }
                        $.post(baseurl + 'nakliye/status_upda',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
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

    $(document).on('change','#demirbas_id',function (){
        let id =  $(this).val();
        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_firma_demirbas',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            let eq=$(this).parent().index();
            $("#firma_demirbas_id option").remove();
            if(responses.status==200){
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });
                responses.items.forEach((item_,index) => {
                    $('#firma_demirbas_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                })

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
                    content: responses.message,
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }


        });
    })
</script>

