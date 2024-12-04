<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Cari Gider Talebi</span></h4>
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

                                <div class="form-row">

                                    <div class="col-md-2 form-group">
                                        <input type="button" name="search" id="aauth" value="Yaratdığın Taleplere Bak" class="btn btn-success form-control "/>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <input type="button" id="clear" value="Aramayi Sifirla" class="btn btn-warning form-control"/>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <span style="font-size:16px" class="badge-success badge">Bekleyen Ödeme Toplamı :<b> <?php echo $totals;?></b></span>
                                        <span style="font-size:16px" class="badge-success badge">Bekleyen Banka Ödeme Toplamı :<b> <?php echo $bank;?></b></span>
                                        <span style="font-size:16px" class="badge-success badge">Bekleyen Nakit Ödeme Toplamı :<b> <?php echo $nakit;?></b></span>
                                    </div>

                                </div>

                            </section>
                        </div>
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
                                                    <td>Cari</td>
                                                    <td>Aciliyet</td>
                                                    <td>Tarih</td>
                                                    <td>Talep Eden</td>
                                                    <td>Proje</td>
                                                    <td>Tutar</td>
                                                    <td>Durum</td>

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

    var url = '<?php echo base_url() ?>carigidertalep/file_handling';
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();

        $('#aauth').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data('aauth');
        });


        $('#clear').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data();
        });

        function draw_data(aauth = 'absent') {
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
                    'url': "<?php echo site_url('carigidertalep/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        aauth: aauth,
                    }
                },
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[9]);

                },
                dom: 'Blfrtip',
                buttons: [
//                    {
//                        text: '<i class="fa fa-plus"></i> Yeni Talep Oluştur',
//                        action: function ( e, dt, node, config ) {
//                            $.confirm({
//                                theme: 'modern',
//                                closeIcon: true,
//                                title: 'Yeni İstək Əlavə Edin ',
//                                icon: 'fa fa-plus',
//                                type: 'dark',
//                                animation: 'scale',
//                                useBootstrap: true,
//                                columnClass: "col-md-8 mx-auto",
//                                containerFluid: !0,
//                                smoothContent: true,
//                                draggable: false,
//                                content:`<form>
//  <div class="form-row">
//    <div class="form-group col-md-12">
//      <label for="name">Layihə / Proje</label>
//      <select class="form-control select-box proje_id proje_id_new required" id="proje_id">
//                <option value="0">Seçiniz</option>
//                <?php //foreach (all_projects() as $emp){
//                                $emp_id=$emp->id;
//                                $name=$emp->code;
//                                ?>
//                    <option value="<?php //echo $emp_id; ?>//"><?php //echo $name; ?>//</option>
//                <?php //} ?>
//            </select>
//    </div>
//</div>
//<div class="form-row">
// <div class="form-group col-md-6">
//      <label for="bolum_id">Cari</label>
//      <select class="form-control select-box cari_id" id="cari_id">
//            <option value="0">Seçiniz</option>
//             <?php //foreach (all_customer() as $emp){
//                                $emp_id=$emp->id;
//                                $name=$emp->company;
//                                ?>
//                    <option value="<?php //echo $emp_id; ?>//"><?php //echo $name; ?>//</option>
//                <?php //} ?>
//    </select>
//    </div>
//    <div class="form-group col-md-6">
//      <label for="asama_id">Ödeme Türü</label>
//        <select class="form-control select-box odeme_turu" id="odeme_turu">
//           <option value="0">Seçiniz</option>
//           <option value="1">Naqd</option>
//           <option value="3">Köçürme</option>
//        </select>
//
//    </div>
//</div>
//<div class="form-row">
// <div class="form-group col-md-6">
//      <label for="talep_eden_user_id">Talep Eden</label>
//      <select class="form-control select-box required" id="talep_eden_user_id">
//
//            <?php //foreach (all_personel() as $emp){
//                                $emp_id=$emp->id;
//                                $name=$emp->name;
//                                ?>
//                <option value="<?php //echo $emp_id; ?>//"><?php //echo $name; ?>//</option>
//            <?php //} ?>
//    </select>
//    </div>
//    <div class="form-group col-md-6">
//      <label for="firma_id">Təcili</label>
//        <select class="form-control select-box" id="progress_status_id">
//
//            <?php //foreach (progress_status() as $emp){
//                                $emp_id=$emp->id;
//                                $name=$emp->name;
//                                ?>
//                <option value="<?php //echo $emp_id; ?>//"><?php //echo $name; ?>//</option>
//            <?php //} ?>
//        </select>
//
//    </div>
//</div>
//  <div class="form-row">
//    <div class="form-group col-md-12">
//      <label for="marka">Açıqlama / Qeyd</label>
//      <textarea class="form-control" id="desc"></textarea>
//    </div>
//</div>
//    <div class="form-row">
//      <div class="form-group col-md-12">
//         <label for="resim">Fayl</label>
//           <div id="progress" class="progress">
//                <div class="progress-bar progress-bar-success"></div>
//           </div>
//            <table id="files" class="files"></table><br>
//            <span class="btn btn-success fileinput-button" style="width: 100%">
//            <i class="glyphicon glyphicon-plus"></i>
//            <span>Seçiniz...</span>
//            <input id="fileupload_" type="file" name="files[]">
//            <input type="hidden" class="image_text" name="image_text" id="image_text">
//      </div>
//       </div>
//</form>`,
//                                buttons: {
//                                    formSubmit: {
//                                        text: 'Sorğunu Açın',
//                                        btnClass: 'btn-blue',
//                                        action: function () {
//                                            $('#loading-box').removeClass('d-none');
//
//                                            let data = {
//                                                crsf_token: crsf_hash,
//                                                progress_status_id:  $('#progress_status_id').val(),
//                                                talep_eden_user_id:  $('#talep_eden_user_id').val(),
//                                                proje_id:  $('#proje_id').val(),
//                                                method:  $('#odeme_turu').val(),
//                                                cari_id:  $('#cari_id').val(),
//                                                desc:  $('#desc').val(),
//                                                image_text:  $('#image_text').val(),
//                                            }
//                                            $.post(baseurl + 'carigidertalep/create_save',data,(response) => {
//                                                let responses = jQuery.parseJSON(response);
//                                                $('#loading-box').addClass('d-none');
//                                                if(responses.status=='Success'){
//                                                    $.alert({
//                                                        theme: 'modern',
//                                                        icon: 'fa fa-check',
//                                                        type: 'green',
//                                                        animation: 'scale',
//                                                        useBootstrap: true,
//                                                        columnClass: "small",
//                                                        title: 'Başarılı',
//                                                        content: responses.message,
//                                                        buttons:{
//                                                            formSubmit: {
//                                                                text: 'Tamam',
//                                                                btnClass: 'btn-blue',
//                                                                action: function () {
//                                                                    location.href = responses.index
//                                                                }
//                                                            }
//                                                        }
//                                                    });
//
//                                                }
//                                                else if(responses.status=='Error'){
//
//                                                    $.alert({
//                                                        theme: 'modern',
//                                                        icon: 'fa fa-exclamation',
//                                                        type: 'red',
//                                                        animation: 'scale',
//                                                        useBootstrap: true,
//                                                        columnClass: "col-md-4 mx-auto",
//                                                        title: 'Dikkat!',
//                                                        content: responses.message,
//                                                        buttons:{
//                                                            prev: {
//                                                                text: 'Tamam',
//                                                                btnClass: "btn btn-link text-dark",
//                                                            }
//                                                        }
//                                                    });
//                                                }
//                                            })
//
//                                        }
//                                    },
//                                },
//                                onContentReady: function () {
//                                    $('.select-box').select2({
//                                        dropdownParent: $(".jconfirm-box-container")
//                                    })
//
//                                    $('#fileupload_').fileupload({
//                                        url: url,
//                                        dataType: 'json',
//                                        formData: {'<?//=$this->security->get_csrf_token_name()?>//': crsf_hash},
//                                        done: function (e, data) {
//                                            var img='default.png';
//                                            $.each(data.result.files, function (index, file) {
//                                                img=file.name;
//                                            });
//
//                                            $('#image_text').val(img);
//                                        },
//                                        progressall: function (e, data) {
//                                            var progress = parseInt(data.loaded / data.total * 100, 10);
//                                            $('#progress .progress-bar').css(
//                                                'width',
//                                                progress + '%'
//                                            );
//                                        }
//                                    }).prop('disabled', !$.support.fileInput)
//                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
//                                    // bind to events
//                                    var jc = this;
//                                    this.$content.find('form').on('submit', function (e) {
//                                        // if the user submits the form by pressing enter in the field.
//                                        e.preventDefault();
//                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
//                                    });
//                                }
//                            });
//                        }
//                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0,1, 2, 3, 4, 5, 6, 7]
                        }
                    }
                ]
            });
        };
    })

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
                '<p><b>Bu İşleme Ait Qaime ve Stok Hareketleri Var İse İptal Olacaktır</b><p/>' +
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
                        $.post(baseurl + 'carigidertalep/status_upda',data,(response) => {
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
                                            action: function () {
                                                $('#cari_gider_talep_list').DataTable().destroy();
                                                draw_data();
                                            }
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
</script>


