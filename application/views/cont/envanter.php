<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Envanter Listesi </h4>




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



            <div class="card-body">


                <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Proje</th>
                        <th>Departman</th>
                        <th>Personel</th>
                        <th>Ürün</th>
                        <th>Miktar</th>
                        <th>Fiyat</th>


                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                    </tfoot>

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

<div id="pop_model_desc" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Açıklama</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_urun" method="post">
                    <div class="modal-body" id="aciklama">
                        <p></p>
                    </div>
                    <div class="modal-footer">

                        <input type="hidden"  id="action-url" value="controller/desc_update">
                        <button type="button" class="btn btn-primary"
                                id="desc_update">Güncelle</button>

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">


    $(document).on('click', "#desc_update", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_urun").serialize();
        var action_url= $('#form_model_urun #action-url').val();
        $("#pop_model_desc").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $(document).on('click', ".pop_model_desc", function (e) {
        e.preventDefault();
        var cont_id=$(this).attr('cont_id')

        $('#pop_model_desc').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'controller/desc';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+cont_id,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#aciklama').html(data);

            }

        });

    });

    var table='';

    function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
        var table = $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/ajax_list_envanter')?>",
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
            "footerCallback": function ( row, data, start, end, display ) {

                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );


                var tatals =currencyFormat(floatVal(total));



                $( api.column( 6 ).footer() ).html(tatals);






            },
        });
    };
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
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
                        $('#invoices').DataTable().destroy();
                        draw_data();
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

    $(document).on('change', ".cont_pers_id", function (e) {
        var deger = $(this).val();
        var eq = $(this).parent().parent().index();
        var id =$(".id").eq(eq).val();

        var action_url="controller/pers_update";
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            'data': {
                yeni_pers_id: deger,
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                    $('#invoices').DataTable().destroy();
                    draw_data();


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

    });
    $(document).on('change', ".cont_status", function (e) {
        var deger = $(this).val();
        var eq = $(this).parent().parent().index();
        var id =$(".id").eq(eq).val();

        var action_url="controller/cont_status_update";
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            'data': {
                yeni_deger_status: deger,
                id: id
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                    $('#invoices').DataTable().destroy();
                    draw_data();


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

    });







</script>
