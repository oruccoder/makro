<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bekleyen Qaime Listesi</span></h4>
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
                                            <table id="cari_gider_talep_list" class="table datatable-show-all" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Fatura Tipi</td>
                                                <td>Proje Adı</td>
                                                <td>Cari</td>
                                                <td>Esas Meblağ</td>
                                                <td>KDV</td>
                                                <td>Toplam</td>
                                                <td>Görüntüle</td>
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
<input type="hidden" value="<?php echo $type?>" id="tip">
<script>
    $(document).ready(function () {
        draw_data();
    });
    function draw_data() {
        let type = $('#tip').val();

        let url_ajax="<?php echo site_url('onay/bekleyen_qaime_list')?>"
        $('#cari_gider_talep_list').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('onay/bekleyen_qaime_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    'tip':type
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
        });
    };
</script>