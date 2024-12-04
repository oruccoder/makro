<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Personel İzin Raporu</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card border border-dark">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <select class="form-control" id="hesap_yil" style="background: #576c93;color: white;border: #5f7399;">
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>


                    <div class="col-md-2">
                        <select class="form-control" id="hesap_ay" style="background: #576c93;color: white;border: #5f7399;">
                            <option value="-1">Hesaplama Ayı Seçiniz</option>
                            <option value="01">Ocak</option>
                            <option value="02">Şubat</option>
                            <option value="03">Mart</option>
                            <option value="04">Nisan</option>
                            <option value="05">Mayıs</option>
                            <option value="06">Haziran</option>
                            <option value="07">Temmuz</option>
                            <option value="08">Ağustos</option>
                            <option value="09">Eylül</option>
                            <option value="10">Ekim</option>
                            <option value="11">Kasım</option>
                            <option value="12">Aralık</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Personel</th>
                        <th>İzin Dönemi</th>
                        <th>Toplam Mezuniyet İzini</th>
                        <th>Toplam Saatlik İzin</th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>

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

<script type="text/javascript">

    $(document).ready(function () {
        draw_data();
    });

    function draw_data(hesap_ay = -1, hesap_yil = '') {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('reports/ajax_list_personel_izin_raporu')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    'hesap_ay': hesap_ay,
                    'hesap_yil': hesap_yil,
                    'user_name': "<?php echo isset($_GET['user_name'])?$_GET['user_name']:''; ?>",
                    'month': "<?php echo isset($_GET['month'])?$_GET['month']:''; ?>",
                    'year': "<?php echo isset($_GET['year'])?$_GET['year']:''; ?>",

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

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if (start_date != '' && end_date != '') {
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date);
        } else {
            alert("Date range is Required");
        }
    });

    $(document).on('change','#hesap_ay',function (e){
        let id=  $(this).val();
        let hesap_yil = $('#hesap_yil').val();
        $('#invoices').DataTable().destroy();
        draw_data(id,hesap_yil);
    })

    $(document).on('change','#hesap_yil',function (e){
        let hesap_yil=  $(this).val();
        let id = $('#hesap_ay').val();
        $('#invoices').DataTable().destroy();
        draw_data(id,hesap_yil);
    })
</script>

<footer style="margin-top: 450px">

</footer>