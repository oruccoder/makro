<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 23.01.2020
 * Time: 11:59
 */
?>
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Avans Talepleri</span></h4>
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
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="text" name="start_date" id="start_date"
                                               class="date30 form-control form-control-sm" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                               data-toggle="datepicker" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <button  style="    float: right;" type="button" name="first" id="first" value="" class="btn btn-info btn-sm">Kendi Taleplerim</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="invoices" class="table datatable-show-all" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>

                                                <th><?php echo $this->lang->line('creation date') ?></th>
                                                <th><?php echo $this->lang->line('approval date') ?></th>
                                                <th>Talep No</th>
                                                <th><?php echo $this->lang->line('proje name') ?></th>
                                                <th>Toplam</th>
                                                <th><?php echo $this->lang->line('Status') ?></th>
                                                <th>Formu Oluşturan Pers.</th>
                                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


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


<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Talep Formu Sil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p>Talep Formunu Silmek İstediğinizden Emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="form/delete_talep">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="status_get" value="<?php echo isset($_GET['status'])?$_GET['status']:'' ?>">
<script type="text/javascript">

    $(document).ready(function () {

        draw_data();

        function draw_data(start_date = '', end_date = '',first=0) {

            var status =$('#status_get').val();
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('form/malzeme_ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        first: first,
                        tip: 5
                    }
                },
                'columnDefs': [
                    {
                        'targets': [6,7],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Yeni Talep',
                        action: function(e, dt, node, config) {
                            location.href = '/form/avans_talebi';
                        }
                    },
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
        $('#first').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,1);
        });
    });
</script>
