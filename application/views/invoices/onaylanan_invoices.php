<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Manage Invoices') ?> <a
                    href="<?php echo base_url('invoices/create') ?>"
                    class="btn btn-primary btn-sm rounded">
                    <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i></a></h4>




            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <select class="select-box form-control" id="alt_firma" name="alt_firma" >
                            <option  value="">Alt Firma</option>
                            <?php foreach (all_customer() as $row)
                            {
                                echo "<option value='$row->id'>$row->company</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select class="select-box form-control" id="status" name="status" >
                            <option  value="">Durum</option>
                            <?php foreach (invoice_status() as $rows)
                            {
                                ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="select-box form-control" id="proje_id" name="proje_id" >
                            <option value="">Proje Seçiniz</option>
                            <option value="0">Projesizler</option>
                            <?php foreach (all_projects() as $rows)
                            {
                                ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="select-box form-control" id="invoice_type_id" name="invoice_type_id" >
                            <option value="">Fatura Tipi</option>
                            <?php foreach (invoice_type() as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                               class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                               data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                    </div>






                </div>


            </div>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-1">
                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                    </div>
                    <div class="col-md-1">
                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                    </div>
                    <div class="col-md-1">
                        <a href="#pop_models" data-toggle="modal" data-remote="false"
                           class="btn btn-warning btn-md" id="ids_aktar" title="Change Status"
                        >Durum</a>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
            <div class="card-body">


                <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th>#</th>
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


<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

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

        function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('invoices/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        alt_firma:alt_firma,
                        status:6,
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
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ]
            });
        };

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


</script>