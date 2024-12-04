<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Onay Listesi</span></h4>
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
                                        <table id="invoices" class="table datatable-show-all"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Tələb Nomresi</th>
                                                <th>Təcili</th>
                                                <th>İstək Tarixi</th>
                                                <th>Tələb Açan</th>
                                                <th>Layihə</th>
                                                <th>Vəziyyət</th>
                                                <th>İşlemler</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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


<input type="hidden" id="tip" value="<?php echo $type ?>">
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    var url = '<?php echo base_url() ?>arac/file_handling';
    $(document).ready(function () {
        draw_data()
    });
    function draw_data() {
        let tip = $("#tip").val();
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('onay/malzemetalep_ajax_list')?>?tip="+tip,
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: []
        });
    }

</script>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/talep.css">
