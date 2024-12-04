<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Forma2 Listesi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            Forma2 Listesi
        </div>
    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content-inner">
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
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                        <table id="invoices" class="table datatable-show-all" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Forma 2 Tipi</th>
                            <th>Muqavile No</th>
                            <th>Forma2 No</th>
                            <th><?php echo $this->lang->line('Customer') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th><?php echo $this->lang->line('Status') ?></th>
                            <th>Proje</th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                            <!--                        <th class="no-sort">Ödeme</th>-->


                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<style>
    .modal-dialog {
        max-width: 50% !important;
    }
    .col-sm-6{
        padding-bottom: 10px !important;
    }
</style>

<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {

        draw_data();

        function draw_data(start_date = '', end_date = '') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('formainvoices/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date
                    }
                },
                dom: 'Blfrtip',
                buttons: [
                    // {
                    //     text: '<i class="fa fa-plus"></i> Yeni Forma2 Oluştur',
                    //     action: function ( e, dt, node, config ) {
                    //         window.location.href = '/formainvoices/create';
                    //     }
                    // },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5,6,7]
                        }
                    }
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
    });

    function amount_max(){

        let element='#talep_total';
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }
</script>
