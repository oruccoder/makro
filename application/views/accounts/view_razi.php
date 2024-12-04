<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h5><?php echo $account['holder'].' '; echo $this->lang->line('Details') ?></h5>
        </div>
        </div>
        </div>

<!--        <div class="card-body">-->
<!--            <div id="notify" class="alert alert-success" style="display:none;">-->
<!--                <a href="#" class="close" data-dismiss="alert">&times;</a>-->
<!---->
<!--                <div class="message"></div>-->
<!--            </div>-->
<!---->




<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">İşlem Tarihi</div>
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
<!--                <div class="col-md-2">-->
<!--                    <a href="" type="button"  id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>-->
<!--                </div>-->


            </div>
            </div>
            </div>
            </div>

<div class="content">
    <div class="card">
        <div class="card-body">

            <table id="trans_table" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                   width="100%">
                <thead>
                <tr>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th>Kasa</th>
                    <th>Personel</th>
                    <th>Tutar</th>
                    <th><?php echo $this->lang->line('Method') ?></th>
                    <th><?php echo $this->lang->line('type') ?></th>
                    <th>Personel</th>
                    <th>Açıklama</th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th>Kasa</th>
                    <th>Cari</th>
                    <th>Tutar</th>
                    <th><?php echo $this->lang->line('Method') ?></th>
                    <th><?php echo $this->lang->line('type') ?></th>
                    <th>Personel</th>
                    <th>Açıklama</th>



                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
<script>
</script>
<script type="text/javascript">
    var table='';
    function draw_data(start_date = '', end_date = '') {
        table = $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('accounts/account_details_razi?id=') . $_GET['id']?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
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
                total = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );




                var tatals =currencyFormat(floatVal(total));

                $( api.column( 3 ).footer() ).html(tatals);


            },

        });
    }

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
    // $('#trans_table').on( 'page.dt', function () {
    //     var info = table.page.info();
    //     console.log(info);
    //     $('#pageInfo').html( 'Showing page: '+info.page+' of '+info.pages );
    // } );

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if (start_date != '' && end_date != '') {
            $('#trans_table').DataTable().destroy();
            draw_data(start_date, end_date);
        } else {
            alert("Date range is Required");
        }
    });


    $(document).ready(function () {

        draw_data()
    });


</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<footer style="margin-bottom: 280px">

</footer>