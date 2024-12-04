<script>
    function drawIncomeChart(dataVisits) {
        $('#dashboard-income-chart').empty();
        Morris.Area({
            element: 'dashboard-income-chart',
            data: dataVisits,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 40',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#00A5A8',
            ],
            pointFillColors: [
                '#00A5A8',
            ],
            fillOpacity: 0.4,
        });
    }

    function drawExpenseChart(dataVisits2) {

        $('#dashboard-expense-chart').empty();
        Morris.Area({
            element: 'dashboard-expense-chart',
            data: dataVisits2,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 0',
            labels: ['<?php echo $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                } else {
                    return '';
                }
            },
            resize: true,
            lineColors: [
                '#ff6e40',
            ],
            pointFillColors: [
                '#34cea7',
            ]
        });
    }


    /********************************************
     *               PRODUCTS SALES              *
     ********************************************/

    <?php

    if( (!$this->aauth->premission(2) ))
    { ?>
    //$(window).on("load", function () {
    //    var sales_data = [
    //        <?php //foreach ($countmonthlychart as $row) {
    //        $total = $row['total'];
    //        echo "{ y: '" . $row['date'] . "', sales: " . $total . ", invoices: " . intval($row['ttlid']) . "},";
    //    } ?>
    //    ];
    //    var months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haz", "Tem", "Ağus", "Eylül", "Ekim", "Kasım", "Aralık"];
    //    Morris.Area({
    //        element: 'products-sales',
    //        data: sales_data,
    //        xkey: 'y',
    //        ykeys: ['sales','invoices'],
    //        labels: ['Ödemeler','İşlem Sayısı'],
    //        behaveLikeLine: true,
    //        xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
    //            var day = x.getDate();
    //            var month = months[x.getMonth()];
    //            return day + ' ' + month;
    //        },
    //        resize: true,
    //        pointSize: 0,
    //        pointStrokeColors: ['#00B5B8', '#FA8E57', '#F25E75'],
    //        smooth: true,
    //        gridLineColor: '#E4E7ED',
    //        numLines: 6,
    //        gridtextSize: 14,
    //        lineWidth: 0,
    //        fillOpacity: 0.9,
    //        hideHover: 'auto',
    //        lineColors: ['#00B5B8', '#F25E75']
    //    });
    //
    //});
    <?php  } ?>

    $(document).on('click', "#send_pm_u", function (e) {
        e.preventDefault();


        sendPM();


    });

    function sendPM() {


        $("#sendUserPM").modal('hide');

        jQuery.ajax({

            url: baseurl + 'messages/sendpm',
            type: 'POST',
            data: $('form.sendpm').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#activity').append(data.activity);
                    $('#rmpay').val(data.amt);
                    $('#paymade').text(data.ttlpaid);
                    $('#paydue').text(data.amt);

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

    $("#username").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/user',
            data: 'username=' + $(this).val(),
            beforeSend: function () {
                $("#username").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#username-result").show();
                $("#username-result").html(data);
                $("#username").css("background", "none");

            }
        });
    });

    $(document).on('click', ".selectuser", function (e) {
        e.preventDefault();

        $("#username-result").hide();

        $("#username").val($(this).attr('data-username'));
        $("#userid").val($(this).attr('data-userid'));


    });

    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            alert($('.summernote').summernote('code'));
            alert($('.summernote').val());
        });
    });



    $(document).on('click', ".view-bilgi", function (e) {
        e.preventDefault();
        $('#view-object-id').val($(this).attr('data-object-id'));

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'invoices/randevu_bilgileri';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+$('#view-object-id').val()+'&'+crsf_token+'='+crsf_hash,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#view_object').html(data);

            }

        });

    });

</script>
<script>

    $(document).on('click', "#submit_model_update", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model").serialize();
        var action_url= $('#form_model #action-url').val();
        $("#pop_model_talep").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $(document).on('click', "#submit_model_randevu_bilgileri_update", function (e) {
        e.preventDefault();
        var o_data =  $("#data_form").serialize();
        var action_url= $('#data_form #action-url').val();
        $("#view_model").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $(document).on('click', "#submit_model_update_randevu", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_randevu").serialize();
        var action_url= $('#form_model_randevu #action-url').val();
        $("#pop_model_randevu").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $(document).on('click', "#submit_model_update_gorusme", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_gorusme").serialize();
        var action_url= $('#form_model_gorusme #action-url').val();
        $("#pop_model_gorusme").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $(document).on('click', "#submit_model_update_invoice", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_invoice").serialize();
        var action_url= $('#form_model_invoice #action-url').val();
        $("#pop_model_invoice").modal('hide');
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

    $(document).on('click', "#talep_id_aktar", function (e) {
        var array = [];

        $(".talep_ids:checked").map(function(){
            array.push($(this).val());
        });

        $('#talep_ids_array').val(array);

    })

    $(document).on('click', "#gorusme_id_aktar", function (e) {
        var array = [];

        $(".gorusme_ids:checked").map(function(){
            array.push($(this).val());
        });

        $('#gorusme_ids_array').val(array);

    })


    $(document).on('click', "#randevu_id_aktar", function (e) {
        var array = [];

        $(".randevu_ids:checked").map(function(){
            array.push($(this).val());
        });

        $('#randevu_ids_array').val(array);

    })

    $(document).on('click', "#invoice_id_aktar", function (e) {
        var array = [];

        $(".invoice_ids:checked").map(function(){
            array.push($(this).val());
        });

        $('#invoice_id_array').val(array);

    })

    function draw_data(start_date = '', end_date = '',alt_firma,status='') {
        $('#invoices_tables').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('invoices/ajax_list ')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:12
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
    function draw_data2(start_date = '', end_date = '',alt_firma,status='') {
        $('#invoices_gider').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('reports/ajax_list_talep')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:status
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

    function draw_data3(start_date = '', end_date = '',alt_firma,status='') {
        $('#gorusmeler').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('reports/ajax_list_gorusmeler')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:status
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

    function draw_data4(start_date = '', end_date = '',alt_firma,status='') {
        $('#randevuler').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('reports/ajax_list_randevu')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:status
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



    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();
        draw_data2();
        draw_data3();
        draw_data4();

    });

    setInterval(function(){
            $('#gorusmeler').DataTable().destroy();
            $('#invoices_gider').DataTable().destroy();
            $('#randevuler').DataTable().destroy();
            draw_data3();
            draw_data4();
            draw_data2();
        },
        300000);










</script>

<script type="text/javascript">




</script>

<div class="row">


    <?php

    if( ($this->aauth->premission(77) )) { ?>


        <div class="col-xl-2 col-lg-2 col-4">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-info bg-darken-2">
                            <i class="fa fa-user text-bold-200  font-large-2 white"></i>
                        </div>
                        <div class="p-1 bg-gradient-x-info white media-body">
                            <a href="/employee/payroll_list"> <h3 style="color: white">Personel Bordro</h3></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-4">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-warning bg-darken-2">
                            <i class="fa fa-file-o text-bold-200  font-large-2 white"></i>
                        </div>
                        <div class="p-1 bg-gradient-x-warning white media-body">
                            <a href="/invoices"> <h3 style="color: white">Faturalar</h3></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-4">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-primary bg-darken-2">
                            <i class="fa fa-money text-bold-200  font-large-2 white"></i>
                        </div>
                        <div class="p-1 bg-gradient-x-primary white media-body">
                            <a href="/accounts"> <h3 style="color: white">Kasalar</h3></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-4">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-success bg-darken-2">
                            <i class="icon-briefcase text-bold-200  font-large-2 white"></i>
                        </div>
                        <div class="p-1 bg-gradient-x-success white media-body">
                            <a href="/projects"> <h3 style="color: white">Projeler</h3></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-2 col-4">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-primary bg-darken-2">
                            <i class="fa fa-check text-bold-200  font-large-2 white"></i>
                        </div>
                        <div class="p-1 bg-gradient-x-primary white media-body">
                            <a href="/invoices/onaylanan_invoices"> <h5 style="color: white">Onaylanan Faturalar</h5></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-4">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-danger bg-darken-2">
                            <i class="fa fa-check text-bold-200  font-large-2 white"></i>
                        </div>
                        <div class="p-1 bg-gradient-x-danger white media-body">
                            <a href="/reports/onaylananlar"> <h5 style="color: white">Ödeme Emri Verilenler</h5></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-primary bg-darken-2">
                                    <i class="fa fa-file-text-o text-bold-200  font-large-2 white"></i>
                                </div>
                                <div class="p-1 bg-gradient-x-primary white media-body">
                                    <h5>Bugün İşlenen Faturalar</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-plus"></i> <?= $todayin ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-danger bg-darken-2">
                                    <i class="icon-notebook font-large-2 white"></i>
                                </div>
                                <div class="p-1 bg-gradient-x-danger white media-body">
                                    <h5>Bu Ay İşlenen Faturalar</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?= $monthin ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-warning bg-darken-2">
                                    <i class="icon-basket-loaded font-large-2 white"></i>
                                </div>
                                <div class="p-1 bg-gradient-x-warning white media-body">
                                    <h5>Günlük A. Fatura Top.</h5>
                                    <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i><?= amountExchange($todaysales, 0, $this->aauth->get_user()->loc) ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-success bg-darken-2">
                                    <i class="icon-wallet font-large-2 white"></i>
                                </div>
                                <div class="p-1 bg-gradient-x-success white media-body">
                                    <h5>Aylık A. Fatura Top.</h5>
                                    <h5 class="text-bold-400 mb-0"><i
                                                class="ft-arrow-up"></i> <?= amountExchange($monthsales, 0, $this->aauth->get_user()->loc) ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div-->

    <?php } ?>



</div>
<style>
    .p-1 {
        padding: 2rem !important;
    }
    .select2-container
    {
        width: 100% !important;
    }
</style>

<div class="row match-height">

    <?php  if( ($this->aauth->premission(78) )) { ?>

        <div class="col-xl-6 col-lg-6">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title" style="    text-align: center;
    font-size: 20px;
    font-weight: 600;
    font-family: inherit;">Onay Bekleyen Görüşme Talepleri</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                    <div style="float: right">
                        <a href="#pop_model_gorusme" data-toggle="modal" data-remote="false"
                           class="btn btn-warning btn-md" id="gorusme_id_aktar" title="Change Status">Durum Güncelle</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table id="gorusmeler" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Durum</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title" style="    text-align: center;
    font-size: 20px;
    font-weight: 600;
    font-family: inherit;">Randevuler</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                    <div style="float: right">
                        <a href="#pop_model_randevu" data-toggle="modal" data-remote="false"
                           class="btn btn-warning btn-md" id="randevu_id_aktar" title="Change Status">Durum Güncelle</a>
                    </div>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <table id="randevuler" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th>Konu</th>
                                <th>Görüşme Sebebi</th>
                                <th>Durum</th>
                                <th>Görüntüle</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="pop_model_gorusme" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="form_model_gorusme" method="post">
                            <div class="row">
                                <div class="col mb-1"><label
                                            for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>


                                </div>
                            </div>
                            <div>
                                <select name="status" class="form-control mb-1 select-box">
                                    <option value="1">Beklet</option>
                                    <option value="2">Randevu Ayarla</option>
                                    <option value="3">Təstiqle</option>
                                    <option value="4">Burçak'a Yönlendir</option>
                                    <option value="5">Milad'a Yönlendir</option>
                                    <option value="6">Lamiya'ya Yönlendir</option>
                                    <option value="7">Fevzi'ye Yönlendir</option>
                                    <option value="8">Nijat'a Yönlendir</option>
                                    <option value="9">Mahir'e Yönlendir</option>
                                    <option value="10">Hacı Ali'ye Yönlendirr</option>
                                    <option value="11">İlqar Mikayilov Yönlendir</option>
                                    <option value="13">İlqar Nesibov Yönlendir</option>
                                    <?php foreach (personel_list() as $emp){
                                        $emp_id=$emp['id'];
                                        $name=$emp['name'];
                                        ?>
                                        <option value="<?php echo $name.' Yönlendir'; ?>"><?php echo $name. ' Yönlendir'; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input name="gorusme_ids_array" id="gorusme_ids_array" type="hidden">

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                <input type="hidden"  id="action-url" value="invoices/update_toplu_gorusme">
                                <button type="button" class="btn btn-primary"
                                        id="submit_model_update_gorusme"><?php echo $this->lang->line('Change Status'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="pop_model_randevu" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="form_model_randevu" method="post">
                            <div class="row">
                                <div class="col mb-1"><label
                                            for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                                    <select name="status" class="form-control mb-1">
                                        <option value="3">Bekliyor</option>
                                        <option value="2">Onaylandı</option>
                                        <option value="1">Görüşme Tamamlandı</option>
                                    </select>

                                </div>
                            </div>
                            <input name="randevu_ids_array" id="randevu_ids_array" type="hidden">

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                <input type="hidden"  id="action-url" value="invoices/update_toplu_randevu">
                                <button type="button" class="btn btn-primary"
                                        id="submit_model_update_randevu"><?php echo $this->lang->line('Change Status'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="view_model" class="modal  fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                        <h4 class="modal-title">Randevu Bilgileri</h4>
                    </div>
                    <div class="modal-body" id="view_object">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="view-object-id" value="">

                        <button type="button" class="btn btn-primary"
                                id="submit_model_randevu_bilgileri_update">Güncelle</button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Close') ?></button>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

    <?php  if( ($this->aauth->premission(89) )) { ?>
        <div class="col-xl-12 col-lg-8">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title" style="    text-align: center;
    font-size: 20px;
    font-weight: 600;
    font-family: inherit;">Onay Bekleyen Talepler</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                    <!--div style="float: right;display: none">
                        <a href="#pop_model_talep" data-toggle="modal" data-remote="false"
                           class="btn btn-warning btn-md" id="talep_id_aktar" title="Change Status">Durum Güncelle</a>
                    </div-->
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table id="invoices_gider" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th>Form Tipi</th>
                                <th>Cari / Personel</th>
                                <th>Talep No</th>
                                <th>Açıklama</th>
                                <th>Proje Adı</th>
                                <th>Durum</th>
                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>





        <div id="pop_model_talep" class="modal fade">
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
                                        <option value="3">Onaylandı</option>
                                        <option value="4">İptal Edildi</option>
                                    </select>

                                </div>
                            </div>
                            <input name="talep_ids_array" id="talep_ids_array" type="hidden">

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                <input type="hidden"  id="action-url" value="invoices/update_toplu_talep">
                                <button type="button" class="btn btn-primary"
                                        id="submit_model_update"><?php echo $this->lang->line('Change Status'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>


    <?php if( ($this->aauth->premission(90) )) { ?>
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" style="    text-align: center;
    font-size: 20px;
    font-weight: 600;
    font-family: inherit;">Onay Bekleyen Faturalar</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                    <div style="float: right">
                        <a href="#pop_model_invoice" data-toggle="modal" data-remote="false"
                           class="btn btn-warning btn-md" id="invoice_id_aktar" title="Change Status">Durum Güncelle</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table id="invoices_tables" class="table table-striped table-bordered zero-configuration" cellspacing="0"
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

        <div id="pop_model_invoice" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="form_model_invoice" method="post">
                            <div class="row">
                                <div class="col mb-1"><label
                                            for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                                    <select name="status" class="form-control mb-1">
                                        <option value="6">Bankaya İşle</option>
                                        <option value="10">Ödeme Yap</option>
                                        <option value="9">Acil Ödeme</option>
                                        <option value="1">Beklet</option>


                                    </select>

                                </div>
                            </div>
                            <input name="invoice_id_array" id="invoice_id_array" type="hidden">

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                <input type="hidden"  id="action-url" value="invoices/update_status_toplu">
                                <button type="button" class="btn btn-primary"
                                        id="submit_model_update_invoice"><?php echo $this->lang->line('Change Status'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .list-group-item
            {
                padding: 9px 0.25rem !important;
            }
            .badge
            {
                line-height: 15px !important;
                text-align: inherit !important;
            }
        </style>
        <!-- Hesaplar ve Hareketler -->
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hareketler</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content px-1">
                    <div id="recent-buyers" class="media-list height-450  mt-1 position-relative">

                        <?php foreach (hareketler() as $hrk) {

                            if($hrk->invoice_type_id==3) //Tahsilat
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Tahsilat Yapıldı-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==4) //Ödeme
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Ödeme Yapıldı-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==14) //Avans
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Avans Yapıldı-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }

                            else  if($hrk->invoice_type_id==19) //KDV Ödemesi
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>KDV Ödemesi Yapıldı-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='transactions/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==20) //KDV Tahsilatt
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>KDV Tahsilatt Yapıldı-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==25) //Kasa Avansı
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Kasa Avansı Verildi-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==27) //kasalar Arası Trasfer
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Kasalar Arası Virman-Gelen-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==28) //kasalar Arası Trasfer
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Kasalar Arası Virman-Giden-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }
                            else  if($hrk->invoice_type_id==41) //Gider Faturası
                            {
                                ?>
                                <li class='list-group-item'><span style="width: 80%;" class='badge badge-info float-xs-right'>Gider Faturası Kesildi-<?php echo $hrk->payer?></br><?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></span>
                                    <a style='float: right;' href='accounts/view?id=<?php echo $hrk->id?>'><?php echo amountFormat($hrk->total) ?> </a></li>
                                <?php
                            }



                            ?>


                        <?php } ?>

                    </div>

                    <br>
                </div>
            </div>
        </div>
        <!-- Onay Bekleyen Ödemeler -->
        <div class="col-xl-8 col-lg-9">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title" style="
    font-family: inherit;">Onay Bekleyen Ödemeler</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a href="/reports/onay_bekleyen_odemeler" class="btn btn-warning">Detaylı Rapor</a></li>
                        </ul>
                    </div>
                    <!--div style="float: right;display: none">
                        <a href="#pop_model_talep" data-toggle="modal" data-remote="false"
                           class="btn btn-warning btn-md" id="talep_id_aktar" title="Change Status">Durum Güncelle</a>
                    </div-->
                </div>
                <div class="card-content">
                    <div class="card-body" style="padding-bottom: 10px;width:100%;height:500px;overflow:auto;">
                        <table  class="table">
                            <thead>
                            <tr>

                                <th>Form Tipi</th>
                                <th>Proje</th>
                                <th>Ödeme Bekleyen</th>
                                <th>Açıklama</th>
                                <th>Toplam</th>


                            </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0;
                            foreach (odeme_bekleyen_talepler() as $odeme)
                            {
                                $tip='';
                                $href='';
                                $talep_total = amountFormat($odeme->total);
                                $talep_total_ = $odeme->total;
                                $pers_id=$odeme->talep_eden_pers_id;
                                if($odeme->cari_pers==2){
                                    $pers_name=customer_details($odeme->talep_eden_pers_id)['company'];
                                }
                                else
                                {
                                    $pers_name=personel_details($odeme->talep_eden_pers_id);

                                }

                                $desc = $odeme->description;
                                if($pers_name=='Firma'){
                                    $pers_name ='Cari Oluşturulmamış';
                                    $desc=gider_kalemi($odeme->id);

                                }
                                if($odeme->tip==4)
                                {
                                    $tip='Gider Talebi';
                                    $href='/form/gider_view?id='.$odeme->id;
                                    $talep_total = amountFormat($odeme->total);
                                    $talep_total_ = $odeme->total;

                                }
                                else if($odeme->tip==6)
                                {
                                    $tip='Ödeme Talebi';
                                    $href='/form/odeme_talep_view?id='.$odeme->id;
                                    $talep_total = amountFormat($odeme->talep_total);
                                    $talep_total_ = $odeme->talep_total;
                                }
                                else if($odeme->tip==7)
                                {
                                    $tip='Forma2 Ödeme Talebi';
                                    $href='/form/odeme_talep_view?id='.$odeme->id;
                                    $talep_total = amountFormat($odeme->talep_total);
                                    $talep_total_ = $odeme->talep_total;

                                }
                                if($odeme->tip==5)
                                {
                                    $tip='Avans Talebi';
                                    $href='/form/avans_view?id='.$odeme->id;

                                }

                                if($talep_total>0){
                                    $total+=$talep_total_;

                                    ?>
                                    <tr>
                                        <td><a class="btn btn-success btn-sm" href="<?php echo $href;?>"><?php echo $tip ?></a></td>
                                        <td><?php echo proje_name($odeme->proje_id) ?></td>
                                        <td><?php echo $pers_name ?></td>
                                        <td><?php echo $desc; ?></td>
                                        <td><?php echo $talep_total; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            <?php  } ?>
                            </tbody>
                            <tfoot style="width: 100%;position: absolute;bottom: 0px;background: #f1f1f1;right: 0;text-align: -webkit-right;">
                            <tr>
                                <td colspan="3" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Toplam Bekleyen Ödeme</span></td>
                                <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total) ?></span></td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hesaplar  ve Hareketler-->

    <?php } ?>





</div>
<div class="row match-height">

    <?php
    $l_1 =0;
    $l_2 ='col-xl-4 col-lg-4';
    if( ($this->aauth->premission(80) )) {
        $l_1 =1;
        ?>


        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hesaplar</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content px-1">
                    <div id="recent-buyers" class="media-list height-450  mt-1 position-relative">

                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">Şirket Nakit Hesabı</span>
                            <a style="float: right;" href="/accounts/view?id=50"><?php echo amountFormat(new_balace(50),1) ?> </a>
                        </li>
                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">Paşabank AZN Hesabı</span>
                            <a style="float: right;" href="/accounts/view?id=29"><?php echo amountFormat(new_balace(29),1) ?> </a>
                        </li>
                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">Paşabank USD Hesabı</span>
                            <a style="float: right;" href="/accounts/view?id=42"><?php echo amountFormat(hesap_balance(42),1) ?> </a>
                        </li>

                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">Paşabank EUR Hesabı</span>
                            <a style="float: right;" href="/accounts/view?id=30"><?php echo amountFormat(new_balace(30),1) ?> </a>
                        </li>
                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">Paşabank RUB Hesabı</span>
                            <a style="float: right;" href="/accounts/view?id=32"><?php echo amountFormat(new_balace(32),1) ?> </a>
                        </li>
                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">Paşabank TRY Hesabı</span>
                            <a style="float: right;" href="/accounts/view?id=31"><?php echo amountFormat(new_balace(31),1) ?> </a>
                        </li>


                        <li class="list-group-item"><span class="badge badge-danger float-xs-right">KDV</span>
                            <a style="float: right;" href="/accounts/view?id=33"><?php echo amountFormat(new_balace(33),1) ?> </a>
                        </li>



                    </div>

                    <br>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('recent_invoices') ?></h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <p><span class="float-right"> <a
                                        href="<?php echo base_url() ?>invoices/create"
                                        class="btn btn-primary btn-sm rounded">Fatura Oluştur</a>
                                <a
                                        href="<?php echo base_url() ?>invoices"
                                        class="btn btn-success btn-sm rounded"><?php echo $this->lang->line('Manage Invoices') ?></a>
                               </span>
                        </p>
                    </div>
                </div>
                <div class="card-content">

                    <div class="">
                        <table id="recent-orders" class="table table-hover mb-1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line('Customer') ?></th>
                                <th><?php echo $this->lang->line('Amount') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($recent as $item) {
                                $page = 'subscriptions';
                                $t = 'Sub ';
                                if ($item['i_class'] == 0) {
                                    $page = 'invoices';
                                    $t = '';
                                } elseif ($item['i_class'] == 1) {
                                    $page = 'pos_invoices';
                                    $t = 'POS ';
                                }
                                echo '    <tr>
                                <td class="text-truncate"><a href="' . base_url() . $page . '/view?id=' . $item['id'] . '">' . $t . '#' . $item['invoice_no'] . '</a></td>

                                <td class="text-truncate"> ' . $item['name'] . '</td>
                               <td class="text-truncate">' . amountExchange(($item['total']*$item['kur_degeri']), 0, $this->aauth->get_user()->loc) . '</td>
                            </tr>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php  if( ($this->aauth->premission(81) )) {
        if($l_1){
            $l_2='col-xl-4 col-lg-4';
        }
        else
        {
            $l_2='col-xl-12 col-lg-12';

        }
        ?>

    <div class="<?php echo $l_2;?>">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card">

            <div class="card-header">
                <h4 class="card-title" style="
    font-family: inherit;">Onay Bekleyen İzinler</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
                <!--div style="float: right;display: none">
                    <a href="#pop_model_talep" data-toggle="modal" data-remote="false"
                       class="btn btn-warning btn-md" id="talep_id_aktar" title="Change Status">Durum Güncelle</a>
                </div-->
            </div>
            <div class="card-content">
                <div class="card-body" style="padding-bottom: 10px;width:100%;height:500px;overflow:auto;">
                    <table  class="table">
                        <thead>
                        <tr>

                            <th>Form Tipi</th>
                            <th>Personel</th>
                            <th>Görüntüle</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(izinler()){
                        foreach (izinler() as $odeme)
                        {
                            $tip='İzin Talebi';
                            $href='/employee/permissions_view?id='.$odeme->id;
                            $pers_name=personel_details_full($odeme->user_id)['name'];

                            ?>
                            <tr>
                                <td><a class="btn btn-success btn-sm" href="<?php echo $href;?>"><?php echo $tip ?></a></td>
                                <td><?php echo $pers_name ?></td>
                                <td><?php echo '<button  type="button" data-id="'.$odeme->id.'" class="btn btn-success btn-sm permit_view">Görüntüle</button>' ?></td>
                            </tr>
                            <?php
                        }
                        }
                        ?>


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php } ?>
</div>

<?php  if( ($this->aauth->premission(82) )) { ?>
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <div class="card">
                    <div class="card-content">

                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left w-100">
                                    <h3 class="primary"><?php $ipt = sprintf("%0.0f", ($incomechart * 100) / $goals['income']); ?><?php     setlocale(LC_TIME,"Turkish");
                                        echo ' ' . $ipt . '%' ?></h3><?= '<span class=" font-medium-1 display-block">' . iconv('latin5','utf-8',strftime('%B')). ' ' . $this->lang->line('income') . '</span>'; ?>
                                    <span class="font-medium-1"><?= amountExchange($incomechart, 0, $this->aauth->get_user()->loc) ?></span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="fa fa-money primary font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $ipt ?>%"
                                     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">

                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left w-100">
                                    <h3 class="red"><?php setlocale(LC_TIME, "turkish");


                                        $ipt = sprintf("%0.0f", ($expensechart * 100) / $goals['expense']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' .
                                    iconv('latin5','utf-8',strftime('%B')). ' ' . $this->lang->line('expenses') . '</span>'; ?>
                                    <span class="font-medium-1"><?= amountExchange($expensechart, 0, $this->aauth->get_user()->loc)  ?></span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="ft-external-link red font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $ipt ?>%"
                                     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">

                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left w-100">
                                    <h3 class="blue"><?php $ipt = sprintf("%0.0f", ($aylik_kdv_odemesi * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . iconv('latin5','utf-8',strftime('%B')) . ' '  .'Aylık KDV Ödemesi'. '</span>'; ?>
                                    <span class="font-medium-1"><?= amountExchange($aylik_kdv_odemesi, 0, $this->aauth->get_user()->loc); ?></span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="ft-flag blue font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-blue" role="progressbar" style="width: <?= $ipt ?>%"
                                     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">

                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left w-100">
                                    <h3 class="purple"><?php $ipt = sprintf("%0.0f", (($aylik_kdv_tahsilati) * 100) / $goals['sales']); ?><?php echo ' ' . $ipt . '%' ?></h3><?= '<span class="font-medium-1 display-block">' . iconv('latin5','utf-8',strftime('%B')) . ' ' . 'Aylık KDV Tahsilatı' . '</span>'; ?>
                                    <span class="font-medium-1"><?= amountExchange($aylik_kdv_tahsilati, 0, $this->aauth->get_user()->loc)  ?></span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="ft-inbox purple font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: <?= $ipt ?>%"
                                     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<div id="pop_model_gunluk" class="modal  fade">
    <div class="modal-dialog modal-lg" style="max-width: 90%;">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                <h4 class="modal-title">Günlük Görüşmeler</h4>
            </div>
            <div class="modal-body" id="view_object_gunluk">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Close') ?></button>
            </div>
        </div>
    </div>
</div>
<?php  if( ($this->aauth->premission(83) )) { ?>
<div class="row match-height">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('recent') ?> <a
                            href="<?php echo base_url() ?>transactions"
                            class="btn btn-primary btn-sm rounded"><?php echo $this->lang->line('Transactions') ?></a>
                </h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover mb-1">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?>#</th>
                            <th><?php echo $this->lang->line('Account') ?></th>
                            <th>Cari</th>
                            <th>Total</th>

                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th>İşlem Türü</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($recent_payments as $prd) {

                            $total=$prd['total']*$prd['kur_degeri'];
                            $debit=amountFormat($total,$prd['para_birimi']);
                            echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'transactions/view?id=' . $prd['id'] . '">' . dateformat($prd['invoicedate']) . '</a></td>
                                <td class="text-truncate"> ' .  $prd['account'] . '</td>
                                <td class="text-truncate">' . $prd['payer'] . '</td>
                                <td class="text-truncate">' . $debit . '</td>
                                <td class="text-truncate">' . account_type_sorgu($prd['method']) . '</td>
                                <td class="text-truncate">' . $prd['invoice_type_desc'] . '</td>
                            </tr>';

                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>












</div>


<?php
if ($this->aauth->premission(92))
{
    $this->load->view('events/list_randevu');
}

if ($this->aauth->premission(93))
{



    ?>
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

    <div class="col-xl-12 col-lg-12">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card">

            <div class="card-header">
                <h4 class="card-title" style="    text-align: center;
    font-size: 20px;
    font-weight: 600;
    font-family: inherit;">Onay Bekleyen Ürünler</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
                <div style="float: right;">
                    <a href="#pop_model_talep_urun" data-toggle="modal" data-remote="false"
                       class="btn btn-warning btn-md" id="talep_id_aktar_urun" title="Change Status">Durum Güncelle</a>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <table id="invoice_urunler" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th><input type="checkbox" class="form-control tumunu_sec_urun"></th>
                            <th><?php echo $this->lang->line('talep no') ?></th>
                            <th><?php echo $this->lang->line('Project Title') ?></th>
                            <th><?php echo $this->lang->line('Company') ?></th>
                            <th><?php echo $this->lang->line('Product Name') ?></th>
                            <th><?php echo $this->lang->line('Sip_Qty') ?></th>
                            <th><?php echo $this->lang->line('teslim_alinan_miktar') ?></th>
                            <th><?php echo $this->lang->line('kalan_miktar') ?></th>
                            <th><?php echo $this->lang->line('Note') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>

                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>





    <?php
}
?>


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
        draw_data5();

    });

    setInterval(function(){

            $('#invoice_urunler').DataTable().destroy();
            draw_data5();
        },
        300000);
    function draw_data5(start_date = '', end_date = '',alt_firma,status='') {
        $('#invoice_urunler').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('reports/invoice_depo_urunler')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:status,
                    tip:1 //depo bekleyenler
                }
            },
            'columnDefs': [
                {
                    'targets': [0,5,6,7,8],
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
                        columns: [1, 2, 3, 4,5,6]
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
                        if(data.url)
                        {
                            window.location.href = data.url;
                        }
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

    $(document).on('click','.permit_view',function (){
        let id = $(this).data('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: false,
            icon: false,
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function (){
                let self = this;
                let html = `<form>
                            <div class="row">
                               <div class="card col-md-12">
									  <ul class="list-group list-group-flush" style="text-align: justify;font-size: 15px;">
										<li class="list-group-item"><b>Proje : </b>&nbsp;<span id="proje"></span></li>
										<li class="list-group-item"><b>Vazife : </b>&nbsp;<span id="vazife"></span></li>
										<li class="list-group-item"><b>Personel : </b>&nbsp;<span id="pers_name"></span></li>
										<li class="list-group-item"><b>Başlangıç T : </b>&nbsp;<span id="start_date"></span></li>
										<li class="list-group-item"><b>Bitiş T. : </b>&nbsp;<span id="end_date"></span></li>
										<li class="list-group-item"><b>Sebep : </b>&nbsp;<span id="description"></span></li>
									  </ul>
									</div>
                            </div>
</form>


                           `;

                let data = {
                    id: id,
                }
                $.post(baseurl + 'personelaction/permit_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#proje').empty().text(responses.proje);
                    $('#vazife').empty().text(responses.user_role);
                    $('#pers_name').empty().text(responses.user_name);
                    $('#start_date').empty().text(responses.item.start_date);
                    $('#end_date').empty().text(responses.item.end_date);
                    $('#description').empty().text(responses.item.description);



                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_post = {
                            confirm_id: id,
                            status: 1,
                            desc: '',
                        }
                        $.post(baseurl + 'personelaction/user_permit_update',data_post,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function () {
                                                window.location.reload();
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
                                    content: data.message,
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
                cancel: {
                    text: 'İptal Et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-question',
                            type: 'green',
                            closeIcon: true,
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Açıklama',
                            content: "<input class='desc form-control' placeholder='iptal sebebi'>",
                            buttons:{
                                prev: {
                                    text: 'Durum Bildir',
                                    btnClass: "btn btn-success",
                                    action: function () {

                                        let desct=$('.desc').val();
                                        if(!desct){
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
                                        else {
                                            $('#loading-box').removeClass('d-none');
                                        }

                                        let data_post = {
                                            confirm_id: id,
                                            status: 2,
                                            desc: $('.desc').val()
                                        }
                                        $.post(baseurl + 'personelaction/user_permit_update',data_post,(response)=>{
                                            let data = jQuery.parseJSON(response);
                                            if(data.status==200){
                                                $('#loading-box').addClass('d-none');
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: data.message,
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                            action: function () {
                                                                window.location.reload();
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
                                                    content: data.message,
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
                                }
                            }
                        });

                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
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
<style>
    input[type="radio"], input[type="checkbox"]
    {
        width: auto !important;
    }
</style>
