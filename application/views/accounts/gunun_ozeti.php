<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Günün Özeti</span></h4>
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
                                        <h3 style="text-align: center"><?php echo date("d-m-Y").' '.$this->lang->line('gunun_ozeti') ?></h3>
                                        <table id="entries" class="table datatable-show-all" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('type') ?></th>
                                                <th><?php echo $this->lang->line('devir') ?></th>

                                                <th><?php echo $this->lang->line('giren') ?></th>
                                                <th><?php echo $this->lang->line('cikan') ?></th>

                                                <th><?php echo $this->lang->line('bakiye') ?></th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th><?php echo $this->lang->line('type') ?></th>
                                                <th><?php echo $this->lang->line('devir') ?></th>

                                                <th><?php echo $this->lang->line('giren') ?></th>
                                                <th><?php echo $this->lang->line('cikan') ?></th>

                                                <th><?php echo $this->lang->line('bakiye') ?></th>


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
<script type="text/javascript">


    $(document).ready(function () {

        $('#entries').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('accounts/gunun_ozeti_data')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                }
            ]
        });
    });
</script>

