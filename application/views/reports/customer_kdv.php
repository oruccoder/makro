<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 27.01.2020
 * Time: 18:04
 */
?>

<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4 class="card-title"><?php echo $details['company'] . ' || ' . $this->lang->line('cari_kdv_raporu') ?> </h4>
        </div>
    </div>
</div>


<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="card-body">


                    <table id="extres" class="table table-striped table-bordered zero-configuration"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Firma</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('transaction_type') ?></th>
                            <th>Proje Adı</th>
                            <th><?php echo $this->lang->line('Invoice Number') ?></th>
                            <th><?php echo $this->lang->line('payment_type') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>

                        </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    div.dataTables_wrapper div.dataTables_length select {
        width: 50px !important;
    }
</style>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="location_logo" value="<?php $loc = location($this->aauth->get_user()->loc);
echo base_url('userfiles/company/' . $loc['logo']) ?>">
<input type="hidden" id="cari_name"
       value="<?php echo $details['company'] . ' || ' . $this->lang->line('cari_kdv_raporu') ?>">
<input type="hidden" id="para_birimi" value="<?php echo $_GET['para_birimi'] ?>">
<script type="text/javascript">

    $(document).ready(function () {

        var url = $('#location_logo').val();
        var cari = $('#cari_name').val();
        var para_birimi = $('#para_birimi').val();
        var para_birimi_str = '';

        if (para_birimi == 'tumu') {
            para_birimi_str = 'AZN';
        } else {
            para_birimi_str = para_birimi;
        }


        draw_data();

        function draw_data(start_date = '', end_date = '') {
            $('#extres').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('customers/ekstre')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi': $('#para_birimi').val(),
                        'cid':<?php echo @$_GET['id'] ?>,
                        'kdv_durum': '2',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                            columns: [0, 1, 2, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 4, 5, 6, 7]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 4, 5, 6, 7]
                        }
                    },
                    {
                        messageTop: "<div style='text-align: center'><img src='" + url + "' style='max-height:180px;max-width:90px;'>",
                        messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                            "+994 12 597 48 18<br/>" +
                            "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                        extend: 'print',

                        footer: true,
                        title: "<h3 style='text-align: center'>" + cari + "</h3>",
                        exportOptions: {
                            columns: [0, 1, 2, 4, 5, 6, 7]
                        }
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '') / 100 :
                            typeof i === 'number' ?
                                i : 0;
                    };


                    total2 = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    // Total over all pages
                    total = api
                        .column(7)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    // Update footer

                    var bakiye = floatVal(total2) - floatVal(total);
                    var string = '';
                    if (floatVal(total2) > floatVal(total)) {

                        string = '(B)';
                    } else {
                        string = '(A)'
                    }

                    var tatals = currencyFormat(floatVal(total), para_birimi_str);
                    var tatals2 = currencyFormat(floatVal(total2), para_birimi_str);
                    var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)), para_birimi_str);


                    $(api.column(6).footer()).html(tatals2);
                    $(api.column(7).footer()).html(tatals);
                    $(api.column(8).footer()).html(bakiyes + ' ' + string);
                }
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

    function currencyFormat(num, para_birimi_str) {

        var deger = num.toFixed(2).replace('.', ',');
        return deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' ' + para_birimi_str;
    }
</script>

