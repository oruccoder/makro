<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Lojistik Talepleri</span></h4>
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
                                                <th>Oluşturma Tarihi</th>
                                                <th>Talep No</th>
                                                <th>Durum</th>
                                                <th>Formu Oluşturan Personel</th>
                                                <th>Satınalma Formu</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Oluşturma Tarihi</th>
                                                <th>Talep No</th>
                                                <th>Durum</th>
                                                <th>Formu Oluşturan Personel</th>
                                                <th>Satınalma Formu</th>
                                                <th>İşlem</th>
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
</div>




    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        var url = '<?php echo base_url() ?>razilastirma/file_handling';



        function new_draw_data(prje_id){
            $('#todotable').DataTable().destroy();
            $('#todotable').DataTable({
                "processing": true,
                "serverSide": true,
                aLengthMenu: [
                    [ 10, 50, 100, 200,-1],
                    [10, 50, 100, 200,"Tümü"]
                ],
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('data-block', '0');
                    $(row).attr('style', data[13]);
                },
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('razilastirma/todo_load_list_forma2')?>",
                    "type": "POST",
                    data: {'pid': prje_id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                "columnDefs": [
                    {
                        "targets": [1],
                        "orderable": true,
                    },
                ],

            });
        }

        $(document).ready(function () {
            draw_data()
        });
        function draw_data() {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('lojistik/ajax_list')?>",
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
                buttons: [

                ]

            });
        }


    </script>
