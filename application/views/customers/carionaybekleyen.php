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
                                <input type="button" name="search" id="search" value="Filtrele"
                                    class="btn btn-info btn-md" />
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
                                    <table id="clientstable" class="table datatable-show-all" cellspacing="0"
                                        width="100%">
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
                                        <table id="clientstable" class="table">
                                            <!-- data table coming -->
                                             
                                        </table>
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

<input type="hidden" value="<?php echo $active_status ?? 0; ?>" id="active_status">


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('are_you_sure_delete_customer') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="form-control" id="object-id" name="deleteid" value="0">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                    id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                    class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<style>
    .onaylandi {
        background-color: #4CAF50;
    }

    .dataTables_filter input {
    width: 16rem;
    padding: .5rem 1rem;
}

.dataTables_filter>label:after {
    font-size: .9125rem;
    top: 70%;
    right: 1rem;
    margin-top: -.40625rem;
    line-height: 1;
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
                url: "<?php echo site_url('customers/delete_i') ?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&<?= $this->security->get_csrf_token_name() ?>=' + crsf_hash + '<?php if ($due)
                      echo "&due=true" ?>',
                    dataType: 'json',
                    success: function (data) {
                        $("input[name='cust[]']:checked").closest('tr').remove();
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").animate({ scrollTop: $('#notify').offset().top }, 1000);
                    }
                });
            });


            $('#sendMail').on('click', '#sendNowSelected', function (e) {
                e.preventDefault();
                $("#sendMail").modal('hide');
                if ($("#notify").length == 0) {
                    $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
                }
                jQuery.ajax({
                    url: "<?php echo site_url('customers/sendSelected') ?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&' + $("#sendmail_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({ scrollTop: $('#notify').offset().top }, 1000);
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
                url: "<?php echo site_url('customers/sendSmsSelected') ?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&' + $("#sendsms_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({ scrollTop: $('#notify').offset().top }, 1000);
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
            'responsive': true,
            <?php datatable_lang(); ?> 
        'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_list_carionaybekleyen') ?>",
                'type': 'POST',
                'data': function (d) {
                    d['<?= $this->security->get_csrf_token_name() ?>'] = crsf_hash;
                    d['musteri_grup_id'] = status;
                    d['active_status'] = 1;
                    if (typeof due !== 'undefined' && due) {
                        d['due'] = true;
                    }
                },
                'error': function (xhr, error, thrown) {
                    console.log('AJAX error:', error);
                    console.log('XHR:', xhr);
                    alert('DataTables Ajax error: ' + error);
                }
            },
            'columnDefs': [{
                'targets': [0],
                'orderable': false,
            }],
            'createdRow': function (row, data, dataIndex) {
                if (data[1] === 'Onaylandı') {
                    $(row).css('background-color', '#4CAF50');
                }
            },
            'dom': 'Blfrtip',
            'buttons': [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Cari',
                    action: function (e, dt, node, config) {
                        location.href = '/customers/create';
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

    $(document).ready(function () {
    
    $('.onayla-button').each(function () {
        var button = $(this);
        var customerId = button.data('id');

        $.ajax({
            url: '/customers/get_status',
            method: 'POST',
            data: { id: customerId },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.status === 'onaylandı') {
                        button.text('Onaylandı');
                        button.prop('disabled', true);
                    }
                } catch (e) {
                    console.error("JSON parse xətası:", e);
                }
            },
            error: function (xhr, status, error) {
                console.error("Xəta baş verdi:", error, xhr.responseText);
            }
        });
    });
});

document.querySelectorAll('.onayla-button').forEach(button => {
    button.addEventListener('click', function () {
        let cari_id = this.getAttribute('data-cari-id');
        let user_id = this.getAttribute('data-user-id');

        fetch('onayla.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `cari_id=${cari_id}&user_id=${user_id}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        });
    });
});


$(document).on('click', '.update-permission', function () {
    const userId = $(this).data('id');
    const isApproved = $(this).data('approved');

    $.ajax({
        url: '/users/update_permission',
        method: 'POST',
        data: {
            user_id: userId,
            is_approved: isApproved
        },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.success) {
                alert(res.message);
                location.reload();
            } else {
                alert('Xəta: ' + res.message);
            }
        },
        error: function () {
            alert('Bir xəta baş verdi!');
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const customerTable = document.getElementById('customer-table');

    function loadTableData() {
        fetch('/customers/load_list_carionaybekleyen', {
            method: 'POST',
        })
            .then(response => response.json())
            .then(data => {
                const tbody = customerTable.querySelector('tbody');
                tbody.innerHTML = ''; 

                data.data.forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.innerHTML = cell;
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });

                attachOnaylaEvent();
            })
            .catch(error => console.error('Məlumat yüklənərkən xəta baş verdi:', error));
    }

    function attachOnaylaEvent() {
        const buttons = document.querySelectorAll('.onayla-button');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const customerId = this.getAttribute('data-id');

                fetch('/path/to/update_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: customerId }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.classList.remove('btn-primary');
                            this.classList.add('btn-success');
                            this.textContent = 'Onaylandı';
                            this.disabled = true;
                        } else {
                            alert('Status yenilənmədi!');
                        }
                    })
                    .catch(error => console.error('Xəta baş verdi:', error));
            });
        });
    }

    loadTableData();
});

$(document).ready(function () {
    
    $('.onayla-button').each(function () {
        var button = $(this);
        var customerId = button.data('id');

        $.ajax({
            url: '/customers/get_status',
            method: 'POST',
            data: { id: customerId },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.status === 'onaylandı') {
                        button.text('Onaylandı');
                        button.prop('disabled', true);
                    }
                } catch (e) {
                    console.error("JSON parse xətası:", e);
                }
            },
            error: function (xhr, status, error) {
                console.error("Xəta baş verdi:", error, xhr.responseText);
            }
        });
    });
});








$(document).ready(function() {
    // "Onayla" düyməsinə basıldığında
    $(document).on('click', '.onayla-button', function() {
        var customerId = $(this).data('id');
        
        $.ajax({
            url: '/customer/update_status',
            type: 'POST',
            data: { id: customerId },
            success: function(response) {
                if (response.success) {
                    // Statusu "onaylandı" olaraq yeniləyirik
                    $(this).replaceWith('<button class="btn btn-success" style="width: 180px; padding: 11px;" disabled>Onaylandı</button>');
                    // "Onayı Geri Al" düyməsini əlavə edirik
                    $(this).closest('tr').find('td:last').append('<button class="btn btn-warning geri-al-button" style="width: 180px; padding: 11px;" data-id="' + customerId + '">Onayı Geri Al</button>');
                }
            },
            error: function() {
                alert('Bir xəta baş verdi.');
            }
        });
    });

    $(document).on('click', '.geri-al-button', function() {
        var customerId = $(this).data('id');
        
        $.ajax({
            url: '/customer/undo_status',
            type: 'POST',
            data: { id: customerId },
            success: function(response) {
                if (response.success) {
                    $(this).replaceWith('<button class="btn btn-success onayla-button" style="width: 180px; padding: 11px;" data-id="' + customerId + '">Onayla</button>');
                    $(this).closest('tr').find('td:last').find('.btn-success').remove();
                }
            },
            error: function() {
                alert('Bir xəta baş verdi.');
            }
        });
    });
});














document.addEventListener('DOMContentLoaded', function () {
    const customerTable = document.getElementById('customer-table');

    function loadTableData() {
        fetch('/customers/load_list_carionaybekleyen', {
            method: 'POST',
        })
            .then(response => response.json())
            .then(data => {
                const tbody = customerTable.querySelector('tbody');
                tbody.innerHTML = '';

                data.data.forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.innerHTML = cell;
                        tr.appendChild(td);
                    });
                    tbody.appendChild(tr);
                });

                attachOnaylaEvent();
            })
            .catch(error => console.error('Məlumat yüklənərkən xəta baş verdi:', error));
    }

    function attachOnaylaEvent() {
        const buttons = document.querySelectorAll('.onayla-button');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const customerId = this.getAttribute('data-id');

                fetch('/path/to/update_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: customerId }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.classList.remove('btn-primary');
                            this.classList.add('btn-success');
                            this.textContent = 'Onaylandı';
                            this.disabled = true;
                        } else {
                            alert('Status yenilənmədi!');
                        }
                    })
                    .catch(error => console.error('Xəta baş verdi:', error));
            });
        });
    }

    loadTableData();
});


$(document).on('click', '.onayla-button', function () {
    var customerId = $(this).data('id');

    $.ajax({
        url: '/customers/approve_customer',
        method: 'POST',
        data: { id: customerId },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message);

                var button = $('button[data-id="' + customerId + '"]');
                button.removeClass('btn-primary onayla-button')
                      .addClass('btn-success')
                      .text('Onaylandı')
                      .prop('disabled', true);
            } else {
                alert("Xəta: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert("Xəta: Status yenilənə bilmədi. " + error);
        }
    });
});

$(document).ready(function () {
    $('.onayla-button').each(function () {
        var button = $(this);
        var customerId = button.data('id');

        $.ajax({
            url: '/customers/get_status',
            method: 'POST',
            data: { id: customerId },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.status === 'onaylandı') {
                        button.text('Onaylandı');
                        button.prop('disabled', true); 
                    }
                } catch (e) {
                    console.error("JSON parse xətası:", e);
                }
            },
            error: function (xhr, status, error) {
                console.error("Xəta baş verdi:", error, xhr.responseText);
            }
        });
    });
});

    $(document).on('click', '.onayla', function () {
        var cari_id = $(this).attr('cari_id');
        var button = $(this);

        $.ajax({
            url: "<?php echo site_url('customers/onayla_action') ?>",
            type: "POST",
            data: {
                'cari_id': cari_id,
                '<?= $this->security->get_csrf_token_name() ?>': crsf_hash,
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    var row = button.closest('tr');
                    row.find('td:nth-child(2)').text('Onaylandı');
                    row.css('background-color', '#4CAF50');
                    button.remove();
                    alert('Cari başarıyla onaylandı!');
                } else {
                    alert('Hata: ' + response.message);
                }
            },
            error: function () {
                alert('Bir hata oluştu!');
            }
        });
    });

    $(document).on('click', '.approve-button', function () {
        const customerId = $(this).data('id');
        console.log("Təsdiqləmə düyməsinə basıldı. ID:", customerId);
        approveCustomer(customerId);
    });

    function approveCustomer(customerId) {
        if (!customerId) {
            alert("Müştərinin ID-si mövcud deyil!");
            return;
        }

        $.ajax({
            url: '/customers/approve',
            method: 'POST',
            data: { id: customerId },
            success: function (response) {
                console.log("Serverdən cavab:", response);
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert("Xəta: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log("Xəta baş verdi:", error, xhr.responseText);
                alert("Serverdə xəta baş verdi: " + error);
            }
        });
    }


    $(document).on('click', '.passive', function () {
        let cari_id = $(this).attr('cari_id');
        let status = $(this).attr('status');
        let titles = 'Cariyi Aktif Yap';
        let icon = "fa fa-eye"
        let colors = 'green';
        let cont = 'Aktif Yapmak İstediğinizden Emin Misiniz?'
        if (status == 0) {
            titles = 'Cariyi Pasif Yap';
            icon = "fa fa-eye-slash";
            colors = "red";
            cont = "Pasif Yapmak İstediğinizden Emin Misiniz?";
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
                        $.post(baseurl + 'customers/passive_update', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 200) {
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
                                    buttons: {
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
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });

    })
    $(document).on('click', '.akt_yoklama', function () {
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
                            types: $('#types').val(),
                            desc: $('#desc').val(),
                            crsf_token: crsf_hash,
                            cari_id: cari_id,
                        }
                        $.post(baseurl + 'customers/akt_yok_update', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 200) {
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
                                    buttons: {
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
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    })
    function cari_tables(cari_id) {
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
            content: function () {
                let self = this;
                let html = `<form >
                        <div class="row div_ap">
                         </div>
                   `;
                let data_post = {
                    cari_id: cari_id,
                }
                $.post(baseurl + 'customers/get_yoklama_details', data_post, (response) => {
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
                $(document).on('click', '.delete_yoklama', function () {
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
                                    $.post(baseurl + 'customers/yoklama_delete', data, (response) => {
                                        let responses = jQuery.parseJSON(response);
                                        if (responses.status == 200) {
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
                                                buttons: {
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
                                text: 'Kapat',
                                btnClass: "btn btn-danger btn-sm",
                            }
                        },
                        onContentReady: function () {
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            })
                            var jc = this;
                            this.$content.find('form').on('submit', function (e) {
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click');
                            });
                        }
                    });
                })
            }
        });
    }


</script>