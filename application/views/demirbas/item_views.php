<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Detaylar</span></h4>
        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
    </div>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="#">
                                                <fieldset class="mb-3">
                                                    <div class="form-group row">
                                                        <div class="col-lg-2">
                                                            <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                                                   class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                                                   data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table" id="demisbas_list" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Tarih</th>
                                                                <th>Gider Adı</th>
                                                                <th>Miktarı</th>
                                                                <th>Birim Fiyatı</th>
                                                                <th>Toplam Tutar</th>
                                                                <th>Talep Kodu</th>
                                                                <th>Talep Durumu</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        draw_data_gider()
    });

    function draw_data_gider(start_date='',end_date) {
        $('#demisbas_list').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('demirbas/ajax_list_gider_firma')?>",
                'type': 'POST',
                'data': {
                    'demisbas_id':'<?php echo $demisbas_id;?>',
                    'table_name':'<?php echo $table_name;?>',
                    'start_date':start_date,
                    'end_date':end_date,
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,

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
    }


    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        $('#demisbas_list').DataTable().destroy();
        draw_data_gider(start_date, end_date);

    });
</script>