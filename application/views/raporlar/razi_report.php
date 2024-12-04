<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 24.01.2020
 * Time: 16:24
 */
?>
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Razı Rapor</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="content-body">
                            <div class="card-content">
                                <div id="notify" class="alert alert-success" style="display:none;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                                    <div class="message"></div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <select class="form-control" id="hesap_ay" style="background: #576c93;color: white;border: #5f7399;">
                                                <option value="0">Hesaplama Ayı Seçiniz</option>
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
                                        <div class="col-md-1">
                                            <select class="form-control" id="hesap_yil" style="background: #576c93;color: white;border: #5f7399;">
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>

                                            </select>
                                        </div>
                                    </div>

                                    <hr>
                                    <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>

                                            <th>#</th>
                                            <th><?php echo $this->lang->line('Employee') ?></th>
                                            <th>Bordro Tarihi</th>
                                            <th>Yatırılan Tutar</th>
                                            <th>Çekilen Tutar</th>
                                            <th>Giriş Kasası</th>


                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>

                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                        </tfoot>

                                    </table>
                                </div>
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
<script type="text/javascript">

    $(document).ready(function () {
        draw_data();



    });

    function draw_data(ay=0,yil=0) {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('raporlar/ajax_razi_report')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    'yil': yil,
                    'ay': ay,
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
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    messageTop: "<div style='text-align: center'><img src='http://muhasebe.italicsoft.com/userfiles/company/16058809601269056269.png?t=88' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',

                    footer: true,
                    title:"<h3 style='text-align: center'>Personel Kesintisi</h3>",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };
                // Total over all pages
                let total = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                let total2 = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                var tatals =currencyFormat(floatVal(total));
                var total2_ =currencyFormat(floatVal(total2));
                $( api.column( 3 ).footer() ).html(tatals);
                $( api.column( 4 ).footer() ).html(total2_);
            }
        });
    };
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('change','#hesap_ay',function (e){
        let id=  $(this).val();
        let hesap_yil = $('#hesap_yil').val();
        $('#invoices').DataTable().destroy();
        draw_data(id,hesap_yil);
    })
</script>
