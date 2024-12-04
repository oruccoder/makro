<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 23.01.2020
 * Time: 11:59
 */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><a
                    href="<?php echo base_url('form/malzeme_talep_create') ?>"
                    class="btn btn-primary btn-sm rounded">
                    <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i></a></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-2"><?php echo $this->lang->line('creation date') ?></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                               class="date30 form-control form-control-sm" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                               data-toggle="datepicker" autocomplete="off"/>
                    </div>

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                    </div>
                    <div class="col-md-2">
                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>
                    </div>
                    <div class="col-md-2">
                        <button  style="    float: right;" type="button" name="first" id="first" value="" class="btn btn-info btn-sm">Kendi Taleplerim</button>
                    </div>

                </div>
                <hr>
                <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th><?php echo $this->lang->line('creation date') ?></th>
                        <th><?php echo $this->lang->line('approval date') ?></th>
                        <th>Talep No</th>
                        <th><?php echo $this->lang->line('proje name') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th>Formu Oluşturan Pers.</th>
                        <th>Satın Alma Formu</th>
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
<script type="text/javascript">

    $(document).ready(function () {




        draw_data();

        function draw_data(start_date = '', end_date = '',first=0) {
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
                        tip: 1,
                        first: first,
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
