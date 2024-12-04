<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 17.02.2020
 * Time: 11:22
 */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('envanter_raporu') ?> </h4>
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

                <hr>
                <table id="extres" class="table table-striped table-bordered zero-configuration"
                       cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Item Name') ?></th>
                                <th><?php echo $this->lang->line('Product Code') ?></th>
                                <th><?php echo $this->lang->line('unit') ?></th>
                                <th><?php echo $this->lang->line('Quantity') ?></th>
                                <th><?php echo $this->lang->line('son_alis_fiyati') ?></th>
                                <th><?php echo $this->lang->line('ortalama_alis_fiyati') ?></th>
                                <th><?php echo $this->lang->line('son_maliyet') ?></th>
                                <th><?php echo $this->lang->line('ortalama_maliyet') ?></th>
                                <th><?php echo $this->lang->line('son_satis') ?></th>
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


<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>

<input type="hidden" id="location_logo" value="<?php  $loc=location($this->aauth->get_user()->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>">
<input type="hidden" id="para_birimi" value="AZN">
<script type="text/javascript">

    $(document).ready(function () {

        var url=$('#location_logo').val();
        var cari='Envanter Raporu';
        var para_birimi=$('#para_birimi').val();
        var para_birimi_str='';

        if(para_birimi=='tumu')
        {
            para_birimi_str='AZN';
        }
        else {
            para_birimi_str=para_birimi;
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
                    'url': "<?php echo site_url('reports/ajax_envanter_raporu')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi':$('#para_birimi').val(),
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
                            columns: [0, 1, 2, 4,5,6]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 4,5,6]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 4,5,6]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 4,5,6,7,8]
                        }
                    },
                    {
                        messageTop: "<div style='text-align: center'><img src='http://muhasebe.italicsoft.com/userfiles/company/16058809601269056269.png?t=88' style='max-height:180px;max-width:90px;'>",
                        messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                        extend: 'print',

                        footer: true,
                        title:"<h3 style='text-align: center'>"+cari+"</h3>",
                        exportOptions: {
                            columns: [0, 1, 2, 4,5,6,7,8]
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
                    quantity = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    son_alis = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    ort_alis = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    son_maliyet = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    ort_maliyet = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    son_satis = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );









                    var quantity_ =floatVal(quantity);
                    var son_alis_ =currencyFormat(floatVal(son_alis),'AZN');
                    var ort_alis_ =currencyFormat(floatVal(ort_alis),'AZN');
                    var son_maliyet_ =currencyFormat(floatVal(son_maliyet),'AZN');
                    var ort_maliyet_ =currencyFormat(floatVal(ort_maliyet),'AZN');
                    var son_satis_ =currencyFormat(floatVal(son_satis),'AZN');


                    $( api.column( 3 ).footer() ).html(quantity_);
                    $( api.column( 4 ).footer() ).html(son_alis_);
                    $( api.column( 5 ).footer() ).html(ort_alis_);
                    $( api.column( 6 ).footer() ).html(son_maliyet_);
                    $( api.column( 7 ).footer() ).html(ort_maliyet_);
                    $( api.column( 8 ).footer() ).html(son_satis_);
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
    function currencyFormat(num,para_birimi_str) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' '+para_birimi_str;
    }
</script>


