<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
}
?>

<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Cari Onay Bekleyen</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-wrapper">
        <div class="content">
            <!-- Filter Section -->
            <div class="card">
                <div class="card-body">
                    <form action="#">
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <select class="select-box form-control" id="customer_group_id" name="customer_group_id">
                                    <option value="">Cari Grupları</option>
                                    <?php foreach (customer_group_list() as $row) { 
                                        echo "<option value='$row->id'>$row->name</option>"; 
                                    } ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="card">
                <div class="card-body">
                    <div id="notify" class="alert alert-success" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <div class="message"></div>
                    </div>
                    <div class="container-fluid">
                        <section>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <table id="clientstable" class="table datatable-show-all" cellspacing="0" width="100%">
                                        <thead class="table_head">
                                            <tr>
                                                <th>#</th>
                                                <th>Durum</th>
                                                <th>Logo</th>
                                                <th><?php echo $this->lang->line('Name') ?></th>
                                                <?php if ($due) {
                                                    echo '<th>' . $this->lang->line('Due') . '</th>';
                                                } ?>
                                                <th><?php echo $this->lang->line('Address') ?></th>
                                                <th><?php echo $this->lang->line('Email') ?></th>
                                                <th><?php echo $this->lang->line('Phone') ?></th>
                                                <th>Sorumlu Personel</th>
                                                <th><?php echo $this->lang->line('Approval') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be dynamically inserted here -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Durum</th>
                                                <th>Logo</th>
                                                <th><?php echo $this->lang->line('Name') ?></th>
                                                <?php if ($due) {
                                                    echo '<th>' . $this->lang->line('Due') . '</th>';
                                                } ?>
                                                <th><?php echo $this->lang->line('Address') ?></th>
                                                <th>Email</th>
                                                <th><?php echo $this->lang->line('Mobile') ?></th>
                                                <th>Sorumlu Personel</th>
                                                <th><?php echo $this->lang->line('Approval') ?></th>
                                            </tr>
                                        </tfoot>
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

<!-- Hidden Input for Active Status -->
<input type="hidden" value="<?php echo $active_status ?? 0; ?>" id="active_status">


<!-- Delete Customer Modal -->
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('are_you_sure_delete_customer') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="form-control" id="object-id" name="deleteid" value="0">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<style>
    .table_head{
        background-color: #385F71;
        color: #fff;
        padding: 10px;
    }

    .dataTables_filter input {
    outline: 0;
    width: 16rem;
    padding: .5rem 1rem;
}


.dataTables_filter>label:after {
    font-size: .8125rem;
    display: inline-block;
    position: absolute;
    top: 70%;
    right: 1rem;
}
</style>


<script type="text/javascript">
    $(document).ready(function () {
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


        draw_data();


        $(document).on('click', "#delete_selected", function (e) {
            e.preventDefault();
            if ($("#notify").length == 0) {
                $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
            }
            alert($(this).attr('data-lang'));
            jQuery.ajax({
                url: "<?php echo site_url('customers/delete_i')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&<?=$this->security->get_csrf_token_name()?>=' + crsf_hash + '<?php if ($due) echo "&due=true" ?>',
                dataType: 'json',
                success: function (data) {
                    $("input[name='cust[]']:checked").closest('tr').remove();
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
        });


        //uni sender
        $('#sendMail').on('click', '#sendNowSelected', function (e) {
            e.preventDefault();
            $("#sendMail").modal('hide');
            if ($("#notify").length == 0) {
                $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
            }
            jQuery.ajax({
                url: "<?php echo site_url('customers/sendSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&' + $("#sendmail_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
        });

        $('#sendSmsS').on('click', '#sendSmsSelected', function (e) {
            e.preventDefault();
            $("#sendSmsS").modal('hide');
            if ($("#notify").length == 0) {
                $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
            }
            jQuery.ajax({
                url: "<?php echo site_url('customers/sendSmsSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&' + $("#sendsms_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
        });


    });

    $('#search').click(function () {
        var customer_group_id = $('#customer_group_id').val();
        $('#clientstable').DataTable().destroy();
        draw_data(customer_group_id);

    });

    function draw_data(status = 1) {
        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang(); ?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_list_carionaybekleyen') ?>",
                'type': 'POST',
                'data': {
                    '<?= $this->security->get_csrf_token_name() ?>': crsf_hash <?php if ($due)
                        echo ",'due':true" ?>,
                        'musteri_grup_id': status,
                        'active_status': 1,
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                'createdRow': function (row, data, dataIndex) {
                    if (data[1] === 'Onaylandı') {
                        $(row).css('background-color', '#4CAF50');
                    }
                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Yeni Cari',
                        action: function (e, dt, node, config) {
                            location.href = '/customers/create'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                ],
            });
        }

        $(document).on('click', '.approve-btn', function() {
    var customerId = $(this).data('customer-id');
    var statusElement = $('#' + customerId + '-status');
    $.ajax({
        url: 'onayla.php',
        type: 'POST',
        data: { id: customerId },
        success: function(response) {
            if (response === 'success') {
                statusElement.text('Onaylandı');
            } else {
                alert('Xəta baş verdi!');
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
        const onaylaButtons = document.querySelectorAll('.btn-success'); 

        onaylaButtons.forEach(button => {
            button.addEventListener('click', function () {
                const customerRow = this.closest('tr');
                const statusCell = customerRow.querySelector('td:nth-child(2)');

                if (statusCell) {
                    statusCell.textContent = 'Onaylandı'; 
                    this.disabled = true;
                    this.textContent = 'Onaylandı';
                }
            });
        });
    });

    $(document).on('click', '.onayla-btn', function () {
    const cariId = $(this).attr('cari_id'); // Elementin cari_id atributunu alır
    const button = $(this); // Button elementi
    const statusCell = $(`#status-${cariId}`); // Statusun olduğu element

    console.log(`Cari ID: ${cariId}`);
    console.log(`Status Cell: `, statusCell);

    if (statusCell.length === 0) {
        console.error(`Status element tapılmadı: #status-${cariId}`);
        return;
    }

    $.ajax({
        url: 'customers/update_status',
        type: 'POST',
        data: { id: cariId, status: 'approved' },
        success: function (response) {
            console.log('Server cavabı:', response); 
            let data;
            try {
                data = typeof response === 'string' ? JSON.parse(response) : response;
            } catch (e) {
                console.error('JSON parse error:', e);
                alert('Serverdən düzgün cavab alınmadı!');
                return;
            }

            if (data.success) {
                console.log('Status uğurla dəyişdi');
                statusCell.text('Onaylandı');
                button.prop('disabled', true).text('Onaylandı');
            } else {
                alert(data.message || 'Status güncəllənmədi!');
            }
        },
        error: function () {
            alert('Xəta baş verdi!');
        }
    });
});




    $(document).on('click','.passive',function (){
        let cari_id = $(this).attr('cari_id');
        let status = $(this).attr('status');
        let titles = 'Cariyi Aktif Yap';
        let icon="fa fa-eye"
        let colors='green';
        let cont='Aktif Yapmak İstediğinizden Emin Misiniz?'
        if(status==0){
            titles='Cariyi Pasif Yap';
            icon="fa fa-eye-slash";
            colors="red";
            cont="Pasif Yapmak İstediğinizden Emin Misiniz?";
        }
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: titles,
            icon: icon,
            type: colors,
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: cont,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            cari_id: cari_id,
                            status: status,
                        }
                        $.post(baseurl + 'customers/passive_update',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
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
                                                var customer_group_id = $('#customer_group_id').val();
                                                $('#clientstable').DataTable().destroy();
                                                draw_data(customer_group_id);
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
                cancel: {
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

    })
    $(document).on('click','.akt_yoklama',function (){
        let cari_id = $(this).attr('cari_id');

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Cari Durum Bildir',
            icon: "fa fa-check",
            type: "green",
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<div class="col-md-12 pb-1">
                    <select id="types" class="form-control">
                    <option value="2">Akt Yapıldı</option>
                    <option value="1">Cari Yoklandı</option>
                    </select>
</div>
<div class="col-md-12">
                  <textarea class="form-control" id="desc" placeholder="Açıklama"></textarea>
</div>`,
            buttons: {
                formSubmit: {
                    text: 'Durum Bildir',
                    btnClass: 'btn-blue',
                    action: function () {

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            types:$('#types').val(),
                            desc:$('#desc').val(),
                            crsf_token: crsf_hash,
                            cari_id: cari_id,
                        }
                        $.post(baseurl + 'customers/akt_yok_update',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
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
                                                var customer_group_id = $('#customer_group_id').val();
                                                $('#clientstable').DataTable().destroy();
                                                draw_data(customer_group_id);
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
                cancel: {
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

    })
    function cari_tables(cari_id)
    {
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Bilgilendirme',
            icon: 'fa fa-external-link-square-alt 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function ()
            {
                let self = this;
                let html = `<form >
                        <div class="row div_ap">
                         </div>
                   `;
                let data_post = {
                    cari_id: cari_id,
                }
                $.post(baseurl + 'customers/get_yoklama_details',data_post,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.div_ap').append(responses.html)
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {

                $(document).on('click','.delete_yoklama',function (){
                    let id = $(this).attr('yk_id');
                    $.confirm({
                        theme: 'modern',
                        closeIcon: false,
                        title: 'Durumu Sil',
                        icon: 'fa fa-trash',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: 'Belirtilen durumu silmek istediğinizden emin misiniz?',
                        buttons: {
                            formSubmit: {
                                text: 'Güncelle',
                                btnClass: 'btn-blue',
                                action: function () {

                                    $('#loading-box').removeClass('d-none');

                                    let data = {
                                        crsf_token: crsf_hash,
                                        id: id,
                                    }
                                    $.post(baseurl + 'customers/yoklama_delete',data,(response)=>{
                                        let responses = jQuery.parseJSON(response);
                                        if(responses.status==200){
                                            $('#loading-box').addClass('d-none');
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-check',
                                                type: 'green',
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
                                                            var customer_group_id = $('#customer_group_id').val();
                                                            $('#clientstable').DataTable().destroy();
                                                            draw_data(customer_group_id);
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
                            cancel: {
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

                })
            }
        });
    }


</script>
