<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 24.01.2020
 * Time: 16:24
 */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('cari_bakiye_raporu') ?> </h4>
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

                    <div class="col-md-2">
                       <select id="cust_group" name="cust_group" class="form-control select-box">
                           <option value="">Müşteri Grubu</option>
                           <?php foreach (geopos_customer_type() as $rows)
                           {
                               echo "<option value='$rows->id'>$rows->name</option>";
                           } ?>
                       </select>


                    </div>

                    <div class="col-md-2">
                        <select id="alacak_borc" name="alacak_borc" class="form-control select-box">
                            <option value="">Bakiye</option>
                            <option value="1">Alacaklılar</option>
                            <option value="2">Borçlular</option>

                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                    </div>
                    <div class="col-md-2">
                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-md">Temizle</a>
                    </div>

                </div>

                <hr>
                <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th><?php echo $this->lang->line('Customers') ?></th>
                        <th><?php echo $this->lang->line('alacak_top') ?></th>
                        <th><?php echo $this->lang->line('borc_top') ?></th>
                        <th><?php echo $this->lang->line('bakiye_top') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tfoot>
                    <tr>

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

        function draw_data(cust_group='',bakiye='') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                aLengthMenu: [
                    [ 10, 50, 100, 200,-1],
                    [10, 50, 100, 200,"Tümü"]
                ],
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('reports/ajax_cari_bakiye')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        cust_group:cust_group,
                        bakiye:bakiye
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
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
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


                    total2 = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );


                    // Total over all pages
                    total = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );





                    // Update footer

                    var bakiye = floatVal(total2)-floatVal(total);
                    var string='';
                    if(floatVal(total2)>floatVal(total))
                    {

                        string='(B)';
                    }
                    else
                    {
                        string='(A)'
                    }

                    var tatals =currencyFormat(floatVal(total));
                    var tatals2 =currencyFormat(floatVal(total2));
                    var bakiyes =currencyFormat(floatVal(Math.abs(bakiye)));


                    $( api.column( 2 ).footer() ).html(tatals2);
                    $( api.column( 3 ).footer() ).html(tatals);
                    $( api.column( 4 ).footer() ).html(bakiyes+' '+string);
                }
            });
        };

        $('#search').click(function () {
            var cust_group = $('#cust_group').val();
            var alacak_borc = $('#alacak_borc').val();
            $('#invoices').DataTable().destroy();
            draw_data(cust_group,alacak_borc);
        });
    });
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
</script>
