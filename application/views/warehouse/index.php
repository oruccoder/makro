<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Depolar</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="invoices" class="table datatable-show-all" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Depo Adı</th>
                            <th>Sorumlu Personel</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    var url = '<?php echo base_url() ?>arac/file_handling';

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
                'url': "<?php echo site_url('warehouse/ajax_list')?>",
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
                {
                    text: '<i class="fa fa-warehouse"></i> Yeni Depo Ekle',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Depo Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Depo Adı</label>
      <input type="text" class="form-control" id="name" placeholder="Proje Deposu">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
      <label for="desc">Depo Açıklaması</label>
      <input type="text" class="form-control" id="desc" placeholder="Makro200 Proje Deposu ">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
      <label for="desc">Proje</label>
           <select class="form-control select-box required" name="proje_id" id="proje_id">
            <option value="0">Seçiniz</option>
            <?php foreach (all_projects() as $project){ ?>
                <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
            <?php } ?>

        </select>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
      <label for="desc">Sorumlu Personel</label>
           <select class="form-control select-box required" name="pers_id" id="pers_id">
            <option value="0">Seçiniz</option>
            <?php foreach (all_personel() as $project){ ?>
                <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
            <?php } ?>

        </select>
    </div>
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
                                            name:  $('#name').val(),
                                            desc:  $('#desc').val(),
                                            proje_id:  $('#proje_id').val(),
                                            pers_id:  $('#pers_id').val(),
                                        }
                                        $.post(baseurl + 'warehouse/create_save',data,(response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if(responses.status=='Success'){
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
                                                                $('#invoices').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            }
                                            else if(responses.status=='Error'){

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
                }
            ]
        });
    }
    $(document).on('click','.edit',function (){
        let id =$(this).attr('id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Depo Düzenle',
            icon: 'fa fa-warehouse',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html += `<form>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="name">Depo Adı</label>
                                  <input type="text" class="form-control" id="name" placeholder="Proje Deposu">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="desc">Depo Açıklaması</label>
                                  <input type="text" class="form-control" id="desc" placeholder="Makro200 Proje Deposu ">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="desc">Proje</label>
                                       <select class="form-control select-box required" name="proje_id" id="proje_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_projects() as $project){ ?>
                                            <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="desc">Sorumlu Personel</label>
                                       <select class="form-control select-box required" name="pers_id" id="pers_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $project){ ?>
                                            <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }

                let table_report='';
                $.post(baseurl + 'warehouse/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.items.title)
                    $('#desc').val(responses.items.extra)
                    $('#proje_id').val(responses.items.proje_id).select2().trigger('change');
                    $('#pers_id').val(responses.items.pers_id).select2().trigger('change');

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            id:  id,
                            name:  $('#name').val(),
                            desc:  $('#desc').val(),
                            proje_id:  $('#proje_id').val(),
                            pers_id:  $('#pers_id').val(),

                        }
                        $.post(baseurl + 'warehouse/update_warehouse',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status=='Success'){
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
                                                $('#invoices').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else{

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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })


                $('#fileupload_update').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_update').val(img);
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
