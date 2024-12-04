<div class="col-xl-12 col-lg-12">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card">

        <div class="card-header">

            <h4 class="card-title" style="text-align: center;font-size: 20px;font-weight: 600;font-family: inherit;">Tehvil Alınan Dosyalar</h4>
            <div class="row">


                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>


            </div>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <table id="invoice_dosyalar" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th><?php echo $this->lang->line('tehvil_no') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>

                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media (min-width: 576px)
    {
        .modal-dialog {
            max-width: 750px !important;
            margin: 1.75rem auto;
        }
    }

</style>

<div id="pop_model_depo_bilgi" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('urun_tehvil_bilgileri'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_urun" method="post">
                    <div class="modal-body" id="view_object_depo_bilgi">
                        <p></p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model_talep_urun" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_urun_gunc" method="post">
                    <div class="row">
                        <div class="col mb-1"><label
                                for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <?php foreach (depo_urun_status() as $st)
                                {
                                    echo "<option value='$st->id'>$st->name</option>";
                                } ?>
                            </select>

                        </div>
                    </div>
                    <input name="talep_ids_array_urun" id="talep_ids_array_urun" type="hidden">
                    <input name="talep_qty_array_urun" id="talep_qty_array_urun" type="hidden">
                    <input name="talep_note_array_urun" id="talep_note_array_urun" type="hidden">

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden"  id="action-url" value="form/update_toplu_depo_urun">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_update_urun"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>



    $(document).on('click', ".pop_model_depo_bilgi", function (e) {
        e.preventDefault();
        var talep_item_id=$(this).attr('malzeme_talep_id')

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'form/depo_onay_bilgileri';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+talep_item_id+'&'+crsf_token+'='+crsf_hash,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#view_object_depo_bilgi').html(data);

            }

        });

    });
    $(document).on('click', "#talep_id_aktar_urun", function (e) {
        var array = [];
        var array_qty = [];
        var array_note = [];

        $(".talep_ids_urun:checked").map(function(){
            array.push($(this).val());
            array_qty.push($('#teslim_alinan_miktar-'+$(this).val()).val());
            array_note.push($('#note-'+$(this).val()).val());
        });

        $('#talep_ids_array_urun').val(array);
        $('#talep_qty_array_urun').val(array_qty);
        $('#talep_note_array_urun').val(array_note);

    })

    $('.tumunu_sec_urun').click(function(event) {  //on click
        if(this.checked) { // check select status
            $(":checkbox").attr("checked", true);
        }else{
            $(":checkbox").attr("checked", false);
        }
    });
    $(document).ready(function () {

        $('.select-box').select2();
        $('.select2').select2();
        draw_data5();

    });

    setInterval(function(){

            $('#invoice_dosyalar').DataTable().destroy();
            draw_data5();
        },
        300000);


    $('#search').click(function () {
        var talep_no = $('#talep_no').val();
        var proje_id = $('#proje_id').val();
        var firma_id = $('#firma_id').val();
        var pers_id = $('#pers_id').val();
        var status_id = $('#status_id').val();
        $('#invoice_dosyalar').DataTable().destroy();
        draw_data5(talep_no, proje_id,firma_id,pers_id,status_id);
    });


    function draw_data5(talep_no = '', proje_id = '',firma_id='',pers_id='',status_id='') {
        $('#invoice_dosyalar').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('reports/invoice_depo_dosyalari')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_no: talep_no,
                    proje_id: proje_id,
                    firma_id:firma_id,
                    pers_id:pers_id,
                    status_id:status_id,
                    tip:2 // tehvil alınanlar
                }
            },
            'columnDefs': [
                {
                    'targets': [0, 1,2],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1,2]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1,2]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1,2]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1,2]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1,2]
                    }
                },
            ]
        });
    };

    $(document).on('click', "#submit_model_update_urun", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_urun_gunc").serialize();
        var action_url= $('#form_model_urun_gunc #action-url').val();
        $("#pop_model_talep_urun").modal('hide');
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
</script>

<style>
    input[type="radio"], input[type="checkbox"]
    {
        width: auto !important;
    }
</style>
