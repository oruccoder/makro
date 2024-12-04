<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bekleyen Görev Listesi</span></h4>
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
                                        <table class="table datatable-show-all" id="personel" width="100%">
                                            <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Kod</td>
                                                <td>Açıklama</td>
                                                <td>Görev Atayan Personel</td>
                                                <td>Atanma Tarihi</td>
                                                <td>Durum</td>
                                                <td>Tecili</td>
                                                <td>Dosya</td>
                                                <td>İşlem</td>
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

    $(document).ready(function () {
        $('.select-box').select2();
        draw_data();
    })

    function draw_data() {
        $('#personel').DataTable({
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
                'url': "<?php echo site_url('personelaction/ajax_list_task_details')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,personel_id:<?php echo $personel_id?>,tip:<?php echo $tip?>
                }
            },
            'columnDefs': [
                {
                    'targets': [7],
                    'orderable': false,
                },
            ],
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style',data[8]);

            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
                }
            ]
        });
    };

    $(document).on('click','.status_change',function (){
        let id = $(this).attr('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Görev Güncelle',
            icon: 'fa fa-pen',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html = `<form>
  <div class="form-row">
               <div class="form-group col-md-6">
      <label for="firma_id">Durum</label>
        <select class="form-control select-box" id="status">

            <?php foreach (task_statuss() as $emp){
                $emp_id=$emp['id'];
                $name=$emp['name'];
                ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-6">
      <label for="name">Açıklama</label>
       <textarea type='text' class='form-control zorunlu_text' id='text'></textarea>
    </div>
     <div class="form-group col-md-12">
        <div class="custom-control custom-switch custom-switch-square custom-control-secondary mb-2">
            <input type="checkbox" class="custom-control-input" id="pers_atama">
            <label class="custom-control-label" for="pers_atama">Görevi Başkasına Atama</label>
        </div>
    </div>
       <div class="form-group col-md-12 d-none atama_personel">
          <select name="personel_id" class="form-control select-box" id="personel_id">
                   <?php foreach (all_personel() as $rol){
                ?>
                 <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
                    <?php } ?>
            </select>
        </div>
    </div>
</form>`;
                let data = {
                    id: id,
                }
                $.post(baseurl + 'personelaction/task_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
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

                        let new_pers_id=0;
                        let val = $('#pers_atama').prop('checked');
                        if(val){
                            new_pers_id=$('#personel_id').val()
                        }
                        let data = {
                            crsf_token: crsf_hash,
                            id:id,
                            text:  $('#text').val(),
                            status:  $('#status').val(),
                            new_pers_id:  new_pers_id
                        }
                        $.post(baseurl + 'personelaction/update_task_change',data,(response) => {
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
                                                $('#personel').DataTable().destroy();
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
                cancel:{
                    text: 'Vazgeç',
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
    })

    $(document).on('change','#pers_atama',function (){
        let val = $(this).prop('checked');
        if(val) //true
        {
            $('.atama_personel').removeClass('d-none');
        }
        else {
            $('.atama_personel').addClass('d-none');
        }
    })

    $(document).on('click','.action_view',function (){
        let id = $(this).attr('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Hareketler',
            icon: 'fa fa-list',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html=`<form action="" class="formName">
                    <div class="form-group table_history">
                    </div>
                    </form>`;
                let data = {
                    id: id,
                }
                $.post(baseurl + 'personelaction/task_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let table_report =`
                        <table id="notes_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>İşlem Tarihi</th>
                            <th>Açıklama</th>
                            <th>Personel</th>
                            <th>Durum</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_history_report(id);
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel:{
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
    })
    function draw_data_history_report(id=0) {
        $('#notes_report').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('personelaction/ajax_list_task_actions')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    id: id,
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                }

            ]
        });
    };
</script>


