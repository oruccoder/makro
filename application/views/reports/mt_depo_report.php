<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Mt Ürün Durum Raporu</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <div class="message"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="select-box form-control" id="proje_id" name="proje_id" >
                                    <option value="0">Proje Seçiniz</option>
                                    <?php foreach (all_projects() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="table-responsive">
                        <table id="mt_urun_table" class="table datatable-show-all"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>MT Kodu</th>
                                <th>Proje</th>
                                <th>Ürün</th>
                                <th>Varyant</th>
                                <th>Sipariş Miktarı</th>
                                <th>Tehvil Detayları</th>
                                <th>Qalıq</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>


    $('#proje_id').on('change',function (){
        let proje_id = $('#proje_id').val();
        $('#mt_urun_table').DataTable().destroy();
        draw_data_mt_Report(proje_id,);

    })


    $(document).ready(function () {
        draw_data_mt_Report();
    });
    function draw_data_mt_Report(proje_id='') {
        $('#mt_urun_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('urun/proje_mt_report')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id: proje_id
                }
            },
            'columnDefs': [
                {
                    'targets': [0,6],
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
    }
</script>