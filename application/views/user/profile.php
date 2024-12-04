<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Employee Details') ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 border-right">

                        <?php if(isset($employee['picture']))
                        {
                            ?>
                            <div style="border-radius: 50%;overflow: hidden;background: linear-gradient(#00000000,#676767);position: relative;width: 350px;height: 350px;">
                                <img  alt="image" class="img-responsive col"
                                      src="<?php echo base_url('userfiles/employee/' . $employee['picture']); ?>">
                            </div>
                            <?php
                        } ?>
                        <hr>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <a href="<?php echo base_url('employee/update?id=' . $employee['id']) ?>"
                                   class="btn btn-purple btn-block"><i
                                            class="icon-pencil"></i> <?php echo $this->lang->line('edit') ?>
                                </a>
                            </div>
                            <br/>
                            <div class="col-md-12">
                                <a href="<?php echo base_url('user/updatepassword?id=' . $eid) ?>"
                                   class="btn btn-primary btn-block"><i
                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                </a>
                            </div>
                            <br/>
                            <div class="col-md-12">
                                <button
                                   class="btn btn-secondary btn-block onay_atama"><i
                                            class="fa fa-user-alt"></i> Onaylarımı Başkasına Atama Yap
                                </button>
                            </div>
                        </div>
                        <br/>
                        <h4><strong><?php echo $employee['name'] ?></strong></h4>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Address') ?>
                                    : </strong><?php echo $employee['address'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('City') ?>
                                    : </strong><?php echo $employee['city'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Region') ?>
                                    : </strong><?php echo $employee['region'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Country') ?>
                                    : </strong><?php echo $employee['country'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('posta_kodu') ?>
                                    : </strong><?php echo $employee['postbox'] ?>
                            </div>

                        </div>
                        <hr>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('ise_baslangic_tarihi') ?></strong> <?php echo dateformat($employee['date_created']); ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('maas') ?></strong> <?php echo amountFormat($employee['salary'])  ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Phone') ?></strong> <?php echo $employee['phone']; ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong>EMail</strong> <?php echo $employee['email']; ?>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-9">
                        <div class="card-content">
                            <div class="card-body">

                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                           aria-controls="tab1" href="#tab1" role="tab"
                                           aria-selected="true"><?php echo $this->lang->line('pers_odeme') ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                           href="#tab2" role="tab"
                                           aria-selected="false"><?php echo $this->lang->line('pers_izin') ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                           href="#tab3" role="tab"
                                           aria-selected="false">Raporlar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                           href="#tab4" role="tab"
                                           aria-selected="false"><?php echo $this->lang->line('pers_mesai')?></a>
                                    </li>

                                    <?php if(izin_yetkilisi_pers($this->aauth->get_user()->id)){

                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5"
                                               href="#tab5" role="tab"
                                               aria-selected="false"><?php echo $this->lang->line('personel_izinleri')?></a>
                                        </li>
                                        <?php
                                    } ?>


                                </ul>

                                <div class="tab-content px-1 pt-1">
                                    <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extres" class="table datatable-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th><?php echo $this->lang->line('transaction_type') ?></th>
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
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="link-tab" aria-expanded="true">
                                        <div class="col-md-12">
                                            <div class="responsive">
                                                <table id="izinler" class="table datatable-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Talep No</th>
                                                        <th>Form Oluşturma Tarihi</th>
                                                        <th>Başlangıç Tarihi</th>
                                                        <th>Bitiş Tarihi</th>
                                                        <th>Bildirim Durumu</th>
                                                        <th>İzin Tipi</th>
                                                        <th>Durum</th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">

                                        <h4 class="title">
                                            <a
                                                    href="<?php echo base_url('employee/adddocument?id=' . $this->aauth->get_user()->id) ?>"
                                                    class="btn btn-primary btn-sm rounded">
                                                <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i>
                                            </a>
                                        </h4>
                                        <div class="row">

                                            <div class="col-md-2">Tarih</div>
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

                                        </div>
                                        <hr>
                                        <hr>


                                        <table id="doctable" class="table datatable-responsive" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $this->lang->line('Title') ?></th>
                                                <th>Dosya Tipi</th>
                                                <th>Araç</th>
                                                <th>Belge Başlangıç Tarihi</th>
                                                <th>Bitiş Tarihi</th>
                                                <th><?php echo $this->lang->line('Action') ?></th>


                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false"></div>
                                    <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="personel_izinleri" class="table datatable-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><?php echo $this->lang->line('personel_adi') ?></th>
                                                        <th><?php echo $this->lang->line('starting date') ?></th>
                                                        <th class="no-sort"><?php echo $this->lang->line('end date') ?></th>
                                                        <th class="no-sort"><?php echo $this->lang->line('permission_status') ?></th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Calculate Total Sales') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?php echo $this->lang->line('Do you want mark') ?>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-6">
                                <label class="col-form-label"
                                       for="name">Hesaplanacak Gün Sayısı</label>
                                <input type="text" class="form-control" id="gun_sayisi" onkeyup="maas_hesapla(this.value)" name="gun_sayisi" placeholder="Hesaplanacak Gün Sayısı" value="30"
                                       autocomplete="false">
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label"
                                       for="name">Hakediş</label>
                                <input type="text" class="form-control" id="new_maas_inp"  name="new_maas" placeholder="Aylık Maaş" value="<?php echo $employee['salary'] ?>">
                                <input type="hidden" class="form-control" id="new_maas" value="<?php echo $employee['salary'] ?>">
                            </div>



                        </div>

                        <div class="modal-footer">
                            <input type="hidden" class="form-control required"
                                   name="eid" id="invoiceid" value="<?php echo $eid ?>">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                            <input type="hidden" id="action-url" value="employee/calc_sales">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Yes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="pop_model2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Calculate Income') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model2">


                        <div class="row">
                            <div class="col mb-1"><label for="pmethod"></label>
                                Bu ay İçin Maaş ve alacak Hesaplanması Yapılsın mı?
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" class="form-control required"
                                   name="eid" id="invoiceid" value="<?php echo $eid ?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                            <input type="hidden" id="action-url"  value="employee/calc_income">
                            <button type="button" class="btn btn-primary submit_model2" id="submit_model2">Evet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        #extres_length, #extres_info, #extres_paginate, #extres_filter
        {
            display: none;
        }
    </style>

    <script>

        function draw_data(start_date='',end_date='')
        {
            $('#doctable').DataTable({

                "processing": true,
                "serverSide": true,
                responsive: true,
                <?php datatable_lang();?>
                "ajax": {
                    "url": "<?php echo site_url('employee/document_load_list')?>",
                    "type": "POST",
                    'data': {
                        start_date: start_date,
                        end_date: end_date,
                        'cid':<?=$this->aauth->get_user()->id ?>,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": false,
                    },
                ],

            });
        }
        $(document).ready(function () {

            draw_data();





        });

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#doctable').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });

        $('#base-tab2').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab5').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab1').on('click', function () {
            $('.sorting').click()
        });
        $(document).ready(function () {
            $('.sorting').click()
            $('#extres').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY":        "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_data')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi':'tumu',
                        'cid':<?php echo $employee['id'] ?>,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    total2 = api
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

                    $( api.column( 4 ).footer() ).html(tatals);
                    $( api.column( 3 ).footer() ).html(tatals2);
                    $( api.column( 5 ).footer() ).html(bakiyes+' '+string);
                }
            });


           draw_data_izinler()

            $('#personel_izinleri').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY":        "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/personel_izinleri')?>",
                    'type': 'POST',
                    'data': {
                        'cid':<?php echo $employee['id'] ?>,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false
                    }
                ]
            });
        });


        function currencyFormat(num) {

            var deger=  num.toFixed(2).replace('.',',');
            return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
        }





        function maas_hesapla(deger) {

            var new_maas=$('#new_maas').val();
            var gunluk=parseFloat(new_maas)/30;
            var hesapla=gunluk*deger;
            $('#new_maas_inp').val(hesapla.toFixed(2));



        }


        $('.submit_model2').on('click', function () {

            setTimeout(function(){   $('#extres').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY":        "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_data')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi':'tumu',
                        'cid':<?php echo $employee['id'] ?>,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );

                    total2 = api
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

                    $( api.column( 4 ).footer() ).html(tatals);
                    $( api.column( 3 ).footer() ).html(tatals2);
                    $( api.column( 5 ).footer() ).html(bakiyes+' '+string);
                }
            }); }, 3000);

        });



        //izinler

        function draw_data_izinler(){
            $('#izinler').DataTable({
                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY":        "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('personelaction/ajax_list_izinler')?>",
                    'type': 'POST',
                    'data': {
                        'tip':"p",
                        'cid':<?php echo $employee['id'] ?>,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false
                    }
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        text: '<i class="fa fa-file"></i> Yeni İzin Ekle',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni İzin Ekle',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
                                <div class="form-group col-md-12"><p style="font-weight: bold;color: #ee5350;text-decoration: underline;font-size: 19px;">Kalan İzin Gün Sayınız <br><?php echo mezuniyet_report($this->aauth->get_user()->id)['mezuniyet_kalan'];?></h2></div>

                                              <div class="form-row">
                                                <div class="form-group col-md-12">
                                                  <label for="name">İzin Türü</label>
                                                  <select class="form-control permit_type required" id="permit_type">
                                                            <?php foreach (user_permit_type() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                </div>
                                            </div>

                                              <div class="form-row">
                                                <div class="form-group col-md-12">
                                                  <label for="name">İzin Sebebi</label>
                                                  <input type="text" class="form-control description" id="description">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                             <div class="form-group col-md-6">
                                                  <label for="start_date">Başlangıç Tarihi</label>

                                                   <input type='text' class='datetime_pickers form-control start_date_permit' id='start_date_permit'>
                                                </div>
                                                 <div class="form-group col-md-6">
                                                  <label for="end_date">Bitiş Tarihi</label>
                                                  <input type='text' class='datetime_pickers form-control end_date_permit' id='end_date_permit'>
                                                </div>
                                            </div>

                                            </form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');
                                            let data = {
                                                crsf_token: crsf_hash,
                                                description:  $('#description').val(),
                                                start_date:  $('#start_date_permit').val(),
                                                end_date:  $('#end_date_permit').val(),
                                                permit_type:  $('#permit_type').val(),
                                                user_id: <?php echo $employee['id'] ?>
                                            }
                                            $.post(baseurl + 'personelaction/create_permit',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status==200){
                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-check',
                                                        type: 'green',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "small",
                                                        title: 'Başarılı',
                                                        content: responses.message,
                                                        buttons:{
                                                            formSubmit: {
                                                                text: 'Tamam',
                                                                btnClass: 'btn-blue',
                                                                action: function () {
                                                                    $('#izinler').DataTable().destroy();
                                                                    draw_data_izinler();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else{

                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: responses.message,
                                                        buttons:{
                                                            prev: {
                                                                text: 'Tamam',
                                                                btnClass: "btn btn-link text-dark",
                                                            }
                                                        }
                                                    });
                                                }
                                            })

                                        }
                                    },
                                },
                                onContentReady: function () {
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })

                                    $('.datetime_pickers').datetimepicker({
                                        dayOfWeekStart : 1,
                                        lang:'tr',
                                    });

                                    $('#fileupload_').fileupload({
                                        url: url,
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image_text').val(img);
                                        },
                                        progressall: function (e, data) {
                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                            $('#progress .progress-bar').css(
                                                'width',
                                                progress + '%'
                                            );
                                        }
                                    }).prop('disabled', !$.support.fileInput)
                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });
                        }
                    }
                ]
            });
        }

        $(document).on('click','.cancel-permit',function (){
            let permit_id = $(this).data('id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-trash',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Silmek Üzeresiniz Emin Misiniz?<p/>'+
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Sil',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                id:permit_id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'personelaction/delete_permit',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status==200){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action:function (){
                                                    $('#izinler').DataTable().destroy();
                                                    draw_data_izinler();
                                                }
                                            }
                                        }
                                    });
                                }
                                else {
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content:  responses.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }

                            });

                        }
                    },
                    cancel:{
                        text: 'Vazgeç',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
                    $('.start_date_permit').datetimepicker();
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });

        })

        $(document).on('click','.notifation-permit',function (){
            let permit_id = $(this).data('id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-bell',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Bildirim Başlatmak Üzeresiniz?<p/>'+
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Başlat',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                id:permit_id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'personelaction/notifation_permit',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status==200){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action:function (){
                                                    $('#izinler').DataTable().destroy();
                                                    draw_data_izinler();
                                                }
                                            }
                                        }
                                    });
                                }
                                else {
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content:  responses.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }

                            });

                        }
                    },
                    cancel:{
                        text: 'Vazgeç',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });

        })

        $(document).on('click','.edit-permit',function (){
            let permit_id = $(this).data('id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'İzin Düzenle',
                icon: 'fa fa-pen',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:function (){
                    let self = this;
                    let html=`<form>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label for="name">İzin Sebebi</label>
                                      <input type="text" class="form-control description" id="description">
                                    </div>
                                </div>
                                <div class="form-row">
                                 <div class="form-group col-md-6">
                                      <label for="start_date">Başlangıç Tarihi</label>
                                      <input type='text' class='datetime_pickers form-control start_date_permit' id='start_date_permit'>
                                    </div>
                                     <div class="form-group col-md-6">
                                      <label for="end_date">Bitiş Tarihi</label>
                                      <input type='text' class='datetime_pickers form-control end_date_permit' id='end_date_permit'>
                                    </div>
                                </div>
<div class="form-row">
                                        <div class="form-group col-md-12">
                                          <label for="name">İzin Türü</label>
                                          <select class="form-control permit_type required" id="permit_type">
                                                    <?php foreach (user_permit_type() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        permit_id: permit_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'personelaction/get_info_permit',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        //$('.payer_id').val(responses.item.csd).select2().trigger('change');
                        $('.description').val(responses.item.description)
                        $('.start_date_permit').val(responses.item.start_date)
                        $('.end_date_permit').val(responses.item.end_date)
                        $("#permit_type").val(responses.item.permit_type).trigger("change");

                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                permit_id:  permit_id,
                                description:  $('#description').val(),
                                start_date:  $('#start_date_permit').val(),
                                end_date:  $('#end_date_permit').val(),
                                permit_type:  $('#permit_type').val(),
                                user_id: <?php echo $employee['id'] ?>
                            }
                            $.post(baseurl + 'personelaction/update_permit',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.status==200){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    $('#izinler').DataTable().destroy();
                                                    draw_data_izinler();
                                                }
                                            }
                                        }
                                    });

                                }
                                else{

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: responses.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }
                            })

                        }
                    },
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })

                    $('.datetime_pickers').datetimepicker({
                        dayOfWeekStart : 1,
                        lang:'tr',
                    });

                    $('#fileupload_').fileupload({
                        url: url,
                        dataType: 'json',
                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                        done: function (e, data) {
                            var img='default.png';
                            $.each(data.result.files, function (index, file) {
                                img=file.name;
                            });

                            $('#image_text').val(img);
                        },
                        progressall: function (e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                            );
                        }
                    }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        })

        $(document).on('click','.eye-permit',function (){
            let permit_id = $(this).data('id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'İzin Görüntüle',
                icon: 'fa fa-eye',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:function (){
                    let self = this;
                    let html=`<form>
                             <div class="row">
                               <div class="card col-md-12">
									  <ul class="list-group list-group-flush" style="text-align: justify;">
									  </ul>
									</div>
                            </div>
                                </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        permit_id: permit_id,
                    }


                    let li='';
                    $.post(baseurl + 'personelaction/get_info_permit_confirm',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        if(responses.status==200){
                            $.each(responses.item, function (index, item) {

                                let durum='Bekliyor'
                                let desc='';
                                if(item.staff_status==1){
                                    durum='Onaylandı Onaylanan İzin Tipi : '+item.permit_name+" | "+item.staff_desc;;
                                }
                                else if(item.staff_status==2){
                                    durum='İptal Edildi';
                                    desc=`<li>`+item.staff_desc+`</li>`;
                                }
                                li+=`<li class="list-group-item"><b>`+item.sort+`. Personel Adı : </b>&nbsp;`+item.name+`</li><ul><li>`+durum+`</li>`+desc+`</ul>`;
                            });

                            $('.list-group-flush').empty().append(li);
                        }
                        else {
                            $('.list-group-flush').empty().append('<p>Bildirim Başlatılmamış</p>');
                        }


                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    cancel:{
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })

                    $('#fileupload_').fileupload({
                        url: url,
                        dataType: 'json',
                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                        done: function (e, data) {
                            var img='default.png';
                            $.each(data.result.files, function (index, file) {
                                img=file.name;
                            });

                            $('#image_text').val(img);
                        },
                        progressall: function (e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                            );
                        }
                    }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        })
        //izinler


        $('.onay_atama').on('click',function (){
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html += `<form>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">Atanacak Personel</label>
                                  <select class="select-box atama_pers_id form-control">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                                            $emp_id=$emp->id;
                                            $name=$emp->name;
                                            ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                                        </select>
                             </div>
                             <div class="form-group col-md-12">
                                <label for="name">Durum</label>
                                  <select class="status form-control">
                                        <option value="1">Seçili Personeli Aktif Yap</option>
                                        <option value="0">Seçili Personeli Pasif Yap</option>
                                        </select>
                             </div>
                            </div>
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        pers_id: <?php echo $employee['id'] ?>
                    }

                    let table_report='';
                    $.post(baseurl + 'personel/dev_kontrol',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);

                        if(responses.devr_user_id){
                            $('.atama_pers_id').val(responses.devr_user_id).select2().trigger('change');
                            $('.status').val(responses.status_user)

                        }
                        else {
                            $('.atama_pers_id').val(0).select2().trigger('change');
                        }
                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {

                            let card_number = $('.atama_pers_id').val();
                            if(card_number==0){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: 'ATANACAK PERSONEL ZORUNLUDUR',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });

                                return false;
                            }


                            $('#loading-box').removeClass('d-none');
                            let number = $('.number').val()
                            let pass = $('.pass').val()

                            let data = {
                                devr_pers_id: $('.atama_pers_id').val(),
                                status: $('.status').val(),
                                pers_id: <?php echo $employee['id'] ?>,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'personel/update_atama_pers',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status==200){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload()
                                                }
                                            }
                                        }
                                    });
                                }
                                else {
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: responses.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }

                            });


                        }
                    },
                    cancel: {
                        text: 'Vazgeç',
                        btnClass: "btn btn-warning btn-sm close",
                    }
                },
                onContentReady: function () {

                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        })



    </script>
