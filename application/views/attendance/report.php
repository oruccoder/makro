<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Personel Çizelge Raporu</span></h4>
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
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="select-box form-control" id="proje_id" name="proje_id" >
                                    <option value="0">Proje Seçiniz</option>
                                    <?php foreach (all_projects() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                    <?php } ?>
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
                            <div class="col-lg-2">
                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Proje Adı</th>
                            <th>Kullanıcı Adı</th>
                            <th>Vazife</th>
                            <th>Toplam Çalışma (Saat)</th>
                            <th>Toplam Mola (Saat)</th>
                            <th>Toplam Gün</th>
                            <th>Çizelge Tarihi</th>
                            <th>Personel Tipi</th>
                            <th>İmzalar</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-dialog {
        max-width: 50% !important;
    }
    .col-sm-6{
        padding-bottom: 10px !important;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>

    $(document).ready(function () {

        $('.select-box').select2();
        draw_data();
    })



    $('#search').on('click',function (){
        let proje_id = $('#proje_id').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        $('#invoices').DataTable().destroy();
        draw_data(proje_id,start_date,end_date);

    })


    function draw_data(proje = null,start_date=null,end_date=null) {
        var datatable = $('#invoices').DataTable({
            autoWidth: false,
            pagingType: "full_numbers",
            processing: true,
            aLengthMenu: [
                [10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            serverSide: true,
            'ajax': {
                'url': "<?php echo site_url('attendance/all_reports_ajax')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    project_id:proje,
                    start_date:start_date,
                    end_date:end_date,

                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 3, 4, 5,6,7,8]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 3, 4,5,6,7,8]
                    }
                }
            ]
        });
    }

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
    function htmlDecode(data) {
        let txt = document.createElement('textarea');
        txt.innerHTML = data;
        return txt.value;
    }


    $(document).on('click', ".signature_history", function (e) {

        let proje_id = $(this).attr('proje_id');
        let start_date = $(this).attr('start_date');
        let end_date = $(this).attr('end_date');
        let pers_id = $(this).attr('pers_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'İmzalar',
            icon: 'fa fa-exclamation',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-8 col-md-offset-3',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_history">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table id="notes_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>İşlem Tarihi</th>
                            <th>Giriş İmza</th>
                            <th>Çıkış İmza</th>
                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_notes_report(proje_id,start_date,end_date,pers_id);
                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
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

    function draw_data_notes_report(proje_id,start_date,end_date,pers_id) {
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
                'url': "<?php echo site_url('attendance/imza_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id: proje_id,
                    start_date: start_date,
                    proje_id: proje_id,
                    end_date: end_date,
                    pers_id: pers_id,
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
                },
                {
                    text: '<i class="fa fa-plus"></i> Yeni Not Oluştur',
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
                                      <label for="name">Not</label>
                                      <textarea class="form-control" id="table_notes"></textarea>

                                    </div>
                                </div>
                                </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sorğunu Açın',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let name = $('#table_notes').val()
                                        if(!name){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Açıklama Zorunludur',
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
                                            table_notes:  $('#table_notes').val(),
                                            talep_id: talep_id
                                        }
                                        $.post(baseurl + 'malzemetalep/create_save_notes',data,(response) => {
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
                                                                $('#notes_report').DataTable().destroy();
                                                                draw_data_notes_report(talep_id);
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
    };

</script>

