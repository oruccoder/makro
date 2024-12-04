<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> <?php echo $this->lang->line('Customer Details') ?> </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>







<div class="content">
    <div class="card">
        <div class="card-content">

            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" style="width: 100%" id="dpic" class="rounded-circle img-border"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>
                        <!-- Menü Ekle -->
                        <?php $this->load->view('customers/customer_menu'); ?>
                    </div>
                    <div class="col-md-10">
                        <div id="mybutton" class="mb-1">

                            <div class="">
                                <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?>
                                </a>
                                <a href="#sendMail" data-toggle="modal" data-remote="false"
                                   class="btn btn-primary btn-md " data-type="reminder"><i
                                            class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                </a>


                                <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                   class="btn btn-info btn-md"><i
                                            class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                </a>


                                <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
                                   class="btn btn-danger btn-md"><i
                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                </a>

                                <?php if($details['musteri_tipi']=='10')
                                {
                                    ?>
                                    <a  href='#pop_model_alacaklandirma' data-toggle='modal' data-remote='false'  class="btn btn-primary btn-md" id="customer_alacaklandir">
                                        <i class="fa fa-money" aria-hidden="true" title="Yeni Ekle"></i>Alacaklandır / Borçlandır
                                    </a>
                                    <?php
                                } ?>


                            </div>

                        </div>
                        <hr>
                        <h5 class="mb-2"><?= $this->lang->line('Account Statement'); ?></h5>
                        <hr>

                        <form action="<?php echo base_url() ?>customers/statement" method="post" role="form">

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <input type="hidden" id="para_birimi" name="para_birimi" value="<?php echo isset($_GET['para_birimi'])?$_GET['para_birimi']:$para_birimi; ?>">

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
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary btn-md" value="<?php echo $this->lang->line('print_ekstre') ?>">


                                </div>

                            </div>
                        </form>
                        <div class="">
                            <table id="extres_cust" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('Date') ?></th>
                                    <th>Firma</th>
                                    <th>Ana Para</th>
                                    <th>EDV</th>
                                    <th>Oran</th>
                                    <th>Hesaplanan</th>
                                    <th>Ödenen</th>
                                    <th>Bakiye</th>
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

    <div id="pop_model_alacaklandirma" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">İşlem</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model_alacak">

                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">Tip</label>
                            <select name="alacakak_borc" class="form-control" id="alacakak_borc">
                                <?php foreach (cari_alacak_borc() as $acc)
                                {
                                    echo "<option value='$acc->id'>$acc->description</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">Kasa</label>
                            <select name="acid" class="form-control" id="acid">
                                <?php foreach (not_account() as $acc)
                                {
                                    $id=$acc['id'];
                                    $holder=$acc['holder'];
                                    echo "<option value='$id'>$holder</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">Firma Seçiniz</label><br>
                            <select style="width: 300px" class="form-control select-box" id="alt_customer_id" name="alt_customer_id">
                                <option>Seçiniz</option>
                                <?php foreach (all_customer() as $customer){
                                    echo "<option value='".$customer->id."'>".$customer->company."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">İşlem Tipi</label>
                            <select name="islem_tipi" class="form-control" id="islem_tipi">
                                <option value="0">Seçiniz</option>
                                <option value="2">Finans İşlemi</option>
                                <option value="3">KDV</option>
                            </select>
                        </div>


                        <div class="col-sm-12">
                            <label class="col-form-label" for="name">İşlemler</label>
                            <select name="islem_listesi" class="form-control" id="islem_listesi">
                                <option value="0">İşlem Tipi Seçiniz</option>
                            </select>
                        </div>




                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">Tutar</label>
                            <input class="form-control" type="text" name="alacak_tutar" id="alacak_tutar">
                        </div>



                        <div class="col-sm-12">
                            <label class="col-form-label" for="name">Oran (%)</label>
                            <input class="form-control" type="text" id='oran' name="oran">
                        </div>


                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">Hesaplanan Tutar</label>
                            <input class="form-control" type="text" name="hesaplanan_tutar" id="hesaplanan_tutar">
                        </div>

                        <div class="col-sm-12">
                            <label class="col-form-label"
                                   for="name">Tarih</label>
                            <input data-toggle="invoicedate" autocomplete="false" class="form-control required"  placeholder="Billing Date" name="dates">
                        </div>

                        <br>
                        <div class="modal-footer">

                            <input type="hidden" name="invoice_id" id="invoice_id">
                            <input type="hidden" name="ana_cari_id" id="ana_cari_id" value="<?php echo $_GET['id']?>">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url-alacak" value="transactions/cari_alacak_borc">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model_alacak"><?php echo $this->lang->line('Yes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        #extres_cust_length, #extres_cust_info, #extres_cust_paginate, #extres_cust_filter,.kdv_hid
        {
            display: none;
        }
        .datepicker-container
        {
            z-index: 9999999 !important; ;
        }
    </style>

    <script type="text/javascript">

        $('#sdate_2').datepicker('setDate', '<?php echo date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))); ?>');

    </script>

    <script type="text/javascript">

        $(function () {
            $('.select-box').select2();
        });
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
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[7]);
                },
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('customers/ekstre_musteri')?>",
                    'type': 'POST',
                    'dataType':'json',
                    'data': {
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                        'para_birimi':$('#para_birimi').val(),
                        'kdv_tipi':0,
                        'cid':<?php echo @$_GET['id'] ?>,
                        'proje_id':proje_id,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        'kdv_durum':'<?php echo @$_GET['kdv_durum'] ?>',
                        'tahvil_durum':'<?php echo @$_GET['tahvil_durum'] ?>'

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
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    total2 = api
                        .column( 5 )
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

                    //$( api.column( 6 ).footer() ).html(tatals);
                    //$( api.column( 5 ).footer() ).html(tatals2);
                    //$( api.column( 7 ).footer() ).html(bakiyes+' '+string);
                }
            });

        }



        $(document).on('change', "#islem_tipi", function (e) {

            $("#islem_listesi option").remove();
            var islem_tipi = $('#islem_tipi option:selected').val();
            var alt_customer_id = $('#alt_customer_id option:selected').val();
            var alacakak_borc = $('#alacakak_borc option:selected').val();


            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/islem_listesi_getir',
                data:
                    'islem_tipi='+ islem_tipi+
                    '&alt_customer_id='+ alt_customer_id+
                    '&alacakak_borc='+ alacakak_borc+
                    '&'+crsf_token+'='+crsf_hash,
                success: function (data) {
                    if(data)
                    {

                        $('#islem_listesi').append($('<option>').val(0).text('İşlemi Seçiniz'));

                        jQuery.each(jQuery.parseJSON(data), function (key, item) {
                            $("#islem_listesi").append('<option kalan="'+ item.tutar_o +'" value="'+ item.id +'">'+ item.tutar+'-'+item.note +'</option>');
                        });
                        //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                    }

                }
            });






        });

        $(document).on('change', "#islem_listesi", function (e) {
            var islem_listesi_id = $('#islem_listesi option:selected').val();
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/invoice_id_getir',
                data:
                    'islem_listesi_id='+ islem_listesi_id+
                    '&'+crsf_token+'='+crsf_hash,
                success: function (data) {
                    if(data)
                    {
                        $("#invoice_id").val(data);

                    }

                }
            });




        });

        $("#oran").keyup(function () {

            var oran =$("#oran").val();
            var alacak_tutar =$("#alacak_tutar").val();
            var hesaplama = (alacak_tutar*oran)/100;
            $("#hesaplanan_tutar").val(hesaplama.toFixed(2));

        });


        $(document).on('click', "#submit_model_alacak", function (e) {
            e.preventDefault();
            var o_data =  $("#form_model_alacak").serialize();
            var action_url= $('#form_model_alacak #action-url-alacak').val();
            $("#pop_model_alacaklandirma").modal('hide');
            saveMDataHak(o_data,action_url);
        });


        function saveMDataHak(o_data,action_url) {
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {


                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            });
        }





    </script>