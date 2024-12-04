
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Audit İşlemleri</span></h4>
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
                                        <table id="invoices" class="table datatable-show-all" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>İşlem Tarihi</th>
                                                    <th>Kayıt Eden Pesonel</th>
                                                    <th>İşlem Tipi</th>
                                                    <th>İşlem ID</th>
                                                    <th>Kontroller Durumu</th>
                                                    <th>Kontroller Personeli</th>
                                                    <th>Kontroller İşlem Geçmişi</th>
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





<script type="text/javascript">




    var table='';


    function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
        var table = $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('controller/ajax_list')?>",
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
            ]
        });
    };
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

        let data_update = {
            yeni_pers_id:deger,
            id: id,
        }
        $.post(baseurl + 'controller/pers_update',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                $('#loading-box').addClass('d-none');
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
            else {
                $('#loading-box').addClass('d-none');
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
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
            $('#invoices').DataTable().destroy();
            draw_data();

        });

    });
    $(document).on('change', ".cont_status", function (e) {
        var deger = $(this).val();
        var eq = $(this).parent().parent().index();
        let cont_id = $(this).data('cont_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Açıklama',
            icon: 'fa fa-text',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:"<input type='text' placeholder='Açıklama Zorunludur' class='form-control' id='desc'>",
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let desc = $('#desc').val()
                        if(!desc){
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

                        let data_update = {
                            cont_id:cont_id,
                            status_id: deger,
                            desc: desc
                        }

                        $.post(baseurl + 'controller/cost_status_change',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
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
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
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

                    }
                },
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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


        // var action_url="controller/cont_status_update";
        // jQuery.ajax({
        //     url: baseurl + action_url,
        //     type: 'POST',
        //     'data': {
        //         yeni_deger_status: deger,
        //         id: id
        //     },
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.status == "Success") {
        //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //             $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
        //             $("html, body").scrollTop($("body").offset().top);
        //
        //             $('#invoices').DataTable().destroy();
        //             draw_data();
        //
        //
        //         } else {
        //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //             $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        //             $("html, body").scrollTop($("body").offset().top);
        //         }
        //     },
        //     error: function (data) {
        //         $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
        //         $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        //         $("html, body").scrollTop($("body").offset().top);
        //     }
        // });

    });

    $(document).on('click','.cont_info',function (e){

        let talep_id = $(this).data('cont_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Kontrol Hareketleri',
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
                            <th>Açıklama</th>
                            <th>Personel</th>
                            <th>Durum</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_notes_report(talep_id);
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

    function draw_data_notes_report(talep_id=0) {
        $('#notes_report').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('controller/ajax_list_cont_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: talep_id,
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