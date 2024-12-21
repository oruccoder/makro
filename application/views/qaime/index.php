<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Faturalar</span></h4>
        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
    </div>
</div>
<div class="container-fluid">
    <!-- Ana İçerik -->
    <div class="content" id="content">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-group row">

                        <div class="col-md-12">

                            <table id="invoices" class="table datatable-show-all" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="form-control one_invoice_ids"></th>
                                    <th>Tarih</th>
                                    <th>Fatura Türü</th>
                                    <th>Fatura No</th>
                                    <th>Proje Adı</th>
                                    <th>Müşteri</th>
                                    <th>Açıklama</th>
                                    <th>Esas Meblağ</th>
                                    <th>KDV</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                    <th>Alt Firma</th>
                                    <th>Ayarlar</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                    <div id="rightSidebar">
                        <h4>Filtreleme</h4>
                        <form>
                            <div class="form-group">

                                <select class="select-box form-control" id="alt_firma" name="alt_firma" >
                                    <option  value="">Alt Firma</option>
                                    <?php foreach (all_customer() as $row)
                                    {
                                        echo "<option value='$row->id'>$row->company</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="select-box form-control" id="status" name="status" >
                                    <option  value="">Durum</option>
                                    <?php foreach (invoice_status() as $rows)
                                    {
                                        ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="select-box form-control" id="proje_id" name="proje_id" >
                                    <option value="">Proje Seçiniz</option>
                                    <option value="0">Projesizler</option>
                                    <?php foreach (all_projects() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="select-box form-control" id="invoice_type_id" name="invoice_type_id" >
                                    <option value="">Fatura Tipi</option>
                                    <?php foreach (invoice_type() as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                       class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                            </div>
                            <div class="form-group">
                                <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                       data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                            </div>

                            <button type="button" name="search" id="search" class="btn btn-success btn-block">Filtrele</button>
                            <button type="reset" onclick="window.location.href='/qaime'" class="btn btn-secondary btn-block">
                                Temizle
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Sağ Sidebar -->

</div>
<!-- Sağ Sidebar -->

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('rightSidebar');
        const content = document.getElementById('content');

        sidebar.classList.toggle('open'); // Sidebar'ı aç/kapat
        content.classList.toggle('shifted'); // İçeriği kaydır
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
                'url': "<?php echo site_url('qaime/ajax_list')?>",
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
                    'targets': [0,11,12],
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
                },
                {
                    text: '<i class="fa fa-filter"></i> Durum Güncelle',
                    action: function (e, dt, node, config) {
                        status_change(); // Fonksiyonu çağır
                    }
                },
                {
                    text: '<i class="fa fa-filter"></i> Filtreleme Yap',
                    action: function (e, dt, node, config) {
                        toggleSidebar(); // Fonksiyonu çağır
                    }
                }
            ]
        });
    };

    $(document).on('change','.one_invoice_ids',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.invoice_ids').prop('checked',true)
        }
        else {
            $('.invoice_ids').prop('checked',false)
        }
    })

    function status_change(){
        let checked_count = $('.invoice_ids:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Qaime Seçilmemiş!',
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
            let array = $(".invoice_ids:checked").map(function () {
                return $(this).val();
            }).get();
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
                content:`<form>
                      <div class="form-group col-md-12">
                                  <label for="name">Durum Bildirme</label>
                                  <select name="status" class="form-control mb-1" id="status_change">
                                        <option value="1">Bekliyor</option>
                                        <option value="2">Ödendi</option>
                                        <option value="3">İptal Edildi</option>
                                        <option value="5">Yeni Fatura</option>
                                        <option value="6">Bankaya İşle</option>
                                        <option value="7">Kdv Ödenmeli</option>
                                        <option value="8">Ön Ödeme</option>
                                        <option value="9">Acil Ödeme</option>
                                        <option value="10">Ödeme Yap</option>
                                        <option value="11">Projesi Belirsiz</option>
                                        <option value="12">Proje Müdürü Onayladı</option>
                                        <option value="13">Bankta</option>
                                        <option value="14">Genel Müdür Onayladı</option>
                                        <option value="16">Yoklandı</option>
                                        <option value="17">Onaylandı</option>
                                        <option value="18">Ödeme Bekliyor</option>
                                        <option value="19">Muhasebe Kontrolünde</option>
                                        <option value="20">Üretime Verildi</option>
                                        <option value="21">Tamamlandı</option>
                                        <option value="22">Onay İşlemi Tamamlandı Bank Onayı Bekliyor</option>

                                </select>
                            </div>
                    </form>


                           `,
                buttons: {
                    formSubmit: {
                        text: 'Onayla',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data_post = {
                                array: array,
                                status: $('#status_change').val(),
                            }
                            $.post(baseurl + 'invoices/update_status_toplu_dashboard',data_post,(response)=>{
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
        }
    }



</script>
<style>
    /* Sağ Sidebar */
    #rightSidebar {
        position: fixed;
        top: 0;
        right: -300px; /* Gizli başlangıç */
        width: 300px;
        height: 100%;
        background-color: #f8f9fa;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
        padding: 15px;
        z-index: 1050;
        transition: right 0.3s ease-in-out;
    }

    /* Sidebar Açık Hali */
    #rightSidebar.open {
        right: 0;
    }

    /* Ana İçerik */
    .content {
        transition: margin-right 0.3s ease-in-out;
    }

    /* Ana İçerik Kayma Hali */
    .content.shifted {
        margin-right: 300px; /* Sidebar genişliği kadar sola kayar */
    }

    /* Sidebar Kapat Butonu */
    .close-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #dc3545;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }

    /* Açma Butonu */
    .open-btn {
        margin: 10px;
    }
</style>