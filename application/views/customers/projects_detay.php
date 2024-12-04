<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>: <?php echo $details['company'] ?></h4>
            
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <div class="row">
                    <div class="col-md-2 border-right border-right-grey">



                        <hr>
                        <!-- Menü Ekle -->
                        <?php $this->load->view('customers/customer_menu'); ?>
                    </div>
                    <div class="col-md-10">

                        <hr>
                        <h5 class="mb-2"><?= $this->lang->line('Account Statement'); ?></h5>
                        <hr>

                        <form action="<?php echo base_url() ?>customers/statement" method="post" role="form">

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <input type="hidden" id="para_birimi" name="para_birimi" value="<?php echo $para_birimi; ?>">

                            <input type="hidden" name="customer" value="<?php echo $id ?>">


                            <div class="form-group row"  style="display: none">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                                <div class="col-sm-9">
                                    <select name="trans_type" class="form-control">
                                        <option value='All'><?php echo $this->lang->line('All Transactions') ?></option>
                                        <option value='Expense'><?php echo $this->lang->line('Debit') ?></option>
                                        <option value='Income'><?php echo $this->lang->line('Credit') ?></option>
                                    </select>


                                </div>
                            </div>


                        </form>

                        <div class="col-md-12">
                            <table class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                   <th>Proje Adı</th>
                                   <th>Sözleşme Tarihi</th>
                                   <th>Sözleşme Tutarı</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?php echo customer_projects_id(@$_GET['id'],@$_GET['csd'])->name?></td>
                                    <td><?php echo dateformat(customer_projects_id(@$_GET['id'],@$_GET['csd'])->sozlesme_date)?></td>
                                    <td><?php echo amountFormat(customer_projects_id(@$_GET['id'],@$_GET['csd'])->sozlesme_tutari)?></td>
                                </tr>
                                </tbody>
                        </div>

                        <div class="col-md-12">
                            <table id="extres_cust" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('Date') ?></th>
                                    <th><?php echo $this->lang->line('transaction_type') ?></th>
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
    </div>


    <div id="sendMail" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Email</h4>
                </div>

                <div class="modal-body">
                    <form id="sendmail_form">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-envelope-o"
                                                                         aria-hidden="true"></span></div>
                                    <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                           value="<?php echo $details['email'] ?>">
                                </div>

                            </div>

                        </div>


                        <div class="row">
                            <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                                <input type="text" class="form-control"
                                       name="customername" value="<?php echo $details['name'] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                                <input type="text" class="form-control"
                                       name="subject" id="subject">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                                <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                        </div>

                        <input type="hidden" class="form-control"
                               id="cid" name="tid" value="<?php echo $details['id'] ?>">
                        <input type="hidden" id="action-url" value="communication/send_general">


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <button type="button" class="btn btn-primary"
                            id="sendNow"><?php echo $this->lang->line('Send') ?></button>
                </div>
            </div>
        </div>
    </div>
    <style>
        #extres_cust_length, #extres_cust_info, #extres_cust_paginate, #extres_cust_filter
        {
            display: none;
        }
    </style>

    <script type="text/javascript">

        $('#sdate_2').datepicker('setDate', '<?php echo date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))); ?>');

    </script>

    <script type="text/javascript">

        var table;
        $(document).on('click','#filtrele',function (e) {
            var val= $('#projects').val();
            draw_data(val);

        });

        function currencyFormat(num) {

            var deger=  num.toFixed(2).replace('.',',');
            return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
        }


        $(document).ready(function () {

            draw_data();


        });
        function draw_data(proje_id = 0){



            table = $('#extres_cust').DataTable({
                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY":        "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('customers/ekstre')?>",
                    'type': 'POST',
                    'dataType':'json',
                    'data': {
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                        'para_birimi':$('#para_birimi').val(),
                        'kdv_tipi':0,
                        'cid':<?php echo @$_GET['csd'] ?>,
                        'proje_id':<?php echo @$_GET['id'] ?>,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        'kdv_durum':'<?php echo @$_GET['kdv_durum'] ?>'

                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
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
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    total2 = api
                        .column( 4 )
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

                    $( api.column( 5 ).footer() ).html(tatals);
                    $( api.column( 4 ).footer() ).html(tatals2);
                    $( api.column( 6 ).footer() ).html(bakiyes+' '+string);
                }
            });

        }









    </script>