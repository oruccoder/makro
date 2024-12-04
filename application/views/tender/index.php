<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Tender List</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content" style="    text-transform: capitalize !important;">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">

                                    <div class="col-lg-8">
                                        <input type="text" style="    text-transform: capitalize !important;"  id="search_value" class="form-control form-control-md" placeholder="Aramak İstediğiniz Kelime"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="oran" id="oran" class="form-control form-control-md"
                                               value="90"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search_button" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="" type="button" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table id="invoices" class="table datatable-show-all" cellspacing="0" width="100%" >
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>Kod</th>
                                <th>Adı</th>
                                <th>Birim</th>
                                <th>Malzeme</th>
                                <th>İŞÇİLİK</th>
                                <th>SADECE İŞÇİLİK</th>
                                <th>EMEQ HAKKI</th>
                                <th>Toplam</th>
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
    #invoices_filter{
        display: none;
    }
</style>
<script>
    $('#search_button').click(function () {
        var search_value = $('#search_value').val();
        var oran = $('#oran').val();
        $('#invoices').DataTable().destroy();
        draw_data(search_value, oran);

    });
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();





    });
    function draw_data(search = '', oran = 0) {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [ -1,10],
                ["Tümü",10]
            ],
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('tender/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    search: search,
                    oran: oran,
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
                },
            ]
        });
    };
</script>
