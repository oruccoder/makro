<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Faturalar</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            Faturalar
        </div>
    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content-inner">
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
                        <table id="invoices" class="table datatable-show-all" cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th><input type="checkbox" class="form-control one_invoice_ids"></th>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('invoice_type') ?></th>
                                <th>Fatura No</th>
                                <th>Proje Adı</th>
                                <th><?php echo $this->lang->line('Customer') ?></th>
                                <th>Açıklama</th>
                                <th>Esas Meblağ</th>
                                <th>KDV</th>
                                <th><?php echo $this->lang->line('Amount') ?></th>
                                <th><?php echo $this->lang->line('Status') ?></th>
                                <th>Alt Firma</th>
                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>




<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>


<div id="pop_models" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model" method="post">
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <?php foreach (invoice_status() as $rows)
                                {
                                    ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                                <?php } ?>


                            </select>

                        </div>
                    </div>
                    <input name="invoice_id_array" id="invoice_id_array" type="hidden">

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden"  id="action-url" value="invoices/update_status_toplu">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_update"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">


    $(document).on('change','.one_invoice_ids',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.invoice_ids').prop('checked',true)
        }
        else {
            $('.invoice_ids').prop('checked',false)
        }
    })

    $(document).on('click', "#ids_aktar", function (e) {
        var array = [];

        $(".invoice_ids:checked").map(function(){
            array.push($(this).val());
        });

        $('#invoice_id_array').val(array);

    })
    $(document).on('click', "#submit_model_update", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model").serialize();
        var action_url= $('#form_model #action-url').val();
        $("#pop_models").modal('hide');
        saveMDataa(o_data,action_url);
    });
    function saveMDataa(o_data,action_url) {
        var errorNum = farmCheck();
        if (errorNum > 0) {
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("#notify .message").html("<strong>Hata</strong>");
            $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
        } else {
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {


                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                        window.setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            });
        }
    }
    $(document).ready(function () {

            $('.select-box').select2();

        draw_data();




        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var alt_firma = $('#alt_firma').val();
            var status = $('#status').val();
            var proje_id = $('#proje_id').val();
            var invoice_type_id = $('#invoice_type_id').val();
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date,alt_firma,status,proje_id,invoice_type_id);

        });
    });


    $(document).on('click', '.cancel', function () {
        let invoice_id = $(this).attr('invoice_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İptal Etmek Üzeresiniz Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            invoice_id: invoice_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'invoices/cancel', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.code == 200) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
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
                                                $('#invoices').DataTable().destroy();
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



    function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [ 10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('invoices/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:status,
                    proje_id:proje_id,
                    tip:invoice_type_id
                }
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
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                }
            ]
        });
    };

    $(document).on('click','#change_toplu_status',function (){

        let checked_count = $('.invoice_ids:checked').length;
        if (checked_count == 0) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi  Bir Fatura Seçilmemiş!',
                buttons: {
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }
        else {
            let invoice_id = [];
            $('.invoice_ids:checked').each((index,item) => {
                invoice_id.push($(item).val())
            });

            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-chechk',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<form action="" class="formName">
                    <div class="form-group">
                    <select class="select-box form-control" id="status_change" name="status" >
                    <option  value="0">Durum</option>
                            <?php foreach (invoice_status() as $rows)
                            {
                            ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                            <?php } ?>
                        </select>
                    </form>`,
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {
                            let status=$('#status_change').val();
                            if(!parseInt(status)){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Durum Zorunludur',
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
                                invoice_id:invoice_id,
                                status:$('#status_change').val(),
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'invoices/update_status_toplu',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status==200){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'grey',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    var start_date = $('#start_date').val();
                                                    var end_date = $('#end_date').val();
                                                    var alt_firma = $('#alt_firma').val();
                                                    var status = $('#status').val();
                                                    var proje_id = $('#proje_id').val();
                                                    var invoice_type_id = $('#invoice_type_id').val();
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data(start_date, end_date,alt_firma,status,proje_id,invoice_type_id);
                                                }
                                            }
                                        }
                                    });
                                }
                                else {
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Hata Aldınız! Yöneticiye Başvurun',
                                        buttons:{
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
                    cancel:{
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
        }


    })


</script>
