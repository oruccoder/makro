<div class="content-body">
    <div class="card">
        <div class="card-header">
            <div class="btn-group ">
            <?php echo '<a onclick="window.print();" target="_blank" class="btn btn-info btn-xs" style="color: white">Yazdır</a>'; ?>
            </div>




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
            <div class="receipt-content">
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="invoice-wrapper">
                                <div class="intro">
                                    <img src="<?php  $loc=location($trans['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                         class="img-responsive m-b-2" style="max-height: 120px;">
                                </div>

                                <div class="payment-info">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Ödeme Talep No</span>
                                            <strong><?php echo $trans['talep_no']?></strong>
                                            <button id="talep_iptal"  sf_id ="<?php echo $_GET['id']; ?>"  class="btn btn-warning mb-1">Talebi Kapat</button>
                                            <button id="status_change"  data-id="<?php echo $_GET['id'] ?>" type="button" class="btn btn-success mb-1">Durum Güncelle</button>&nbsp;
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <span>Oluşturma Tarih</span>
                                            <strong><?php echo dateformat($trans['olusturma_tarihi'])?></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-details">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Firma</span>
                                            <strong>
                                                <?php echo $loc['cname']?>
                                            </strong>
                                            <p>
                                                <?php echo $loc['address']?> <br>
                                                <?php echo $loc['email']?> <br>
                                                <?php echo $loc['phone']?> <br>

                                            </p>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <span><?php if($trans['cari_pers']==2) echo 'Cari'; else { echo 'Personel'; }; ?></span>
                                            <strong>
                                                <?php echo $trans['payer']?>
                                            </strong>
                                            <p>
                                                <?php if($trans['cari_pers']==1){
                                                    $datails = personel_detailsa($trans['talep_eden_pers_id']);
                                                    echo $datails['address'].'<br>
                                                        '.$datails['city'].' '.$datails['region'].'<br>
                                                       '.$datails['phone'].'<br>';
                                                }
                                                else {
                                                    $datails = customer_details($trans['talep_eden_pers_id']);

                                                }
                                                ?>

                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="line-items">
                                    <div class="headers clearfix">
                                        <div class="row">
                                            <div class="col-md-4">İşlem</div>
                                            <div class="col-md-4">Talep No</div>
                                            <div class="col-md-4 text-right">Tutar</div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="row item">
                                            <div class="col-md-4 desc">
                                                <?php echo "Ödeme Talebi"?>
                                            </div>
                                            <div class="col-md-4 desc">
                                                <?php if($tip==1) {
                                                    ?>

                                                    <a class="btn btn-success btn-sm" href="/form/satinalma_view?id=<?php echo $trans['malzeme_talep_form_id']?>"><?php echo  $sf_no.' Satın Alma Formuna İstinaden Ödeme Talebi' ?></a>

                                                    <?
                                                }else {
                                                    ?>

                                                    <a class="btn btn-success btn-sm" href="/invoices/view_form2?id=<?php echo $trans['malzeme_talep_form_id']?>"><?php echo  $sf_no.' Forma2ye İstinaden Ödeme Talebi' ?></a>

                                                    <?
                                                }
                                                ?>
                                            </div>
                                                <div class="col-md-4 amount text-right">
                                                    <?php echo amountFormat($trans['talep_total']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total text-right">
                                            <p class="extra-notes">
                                                <strong>Not</strong>
                                                <?php echo $trans['description'] ?>
                                            </p>
                                            <div class="field grand-total">
                                                Toplam <span>   <?php echo amountFormat($trans['talep_total']) ?></span>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <p class="col-md-6 text-left" >Sorumlu Personel</p>
                                        <p class="col-md-6 text-right" ><?php if($trans['cari_pers']==1) echo 'Personel'; else { echo 'Cari'; }; ?></p>
                                    </div>
                                    <div class="row">
                                        <p class="col-md-6 text-left" style="font-weight: bold"><?php  echo personel_detailsa($trans['kullanici_id'])['name']; ?></p>
                                        <p class="col-md-6 text-right" style="font-weight: bold"><?php echo $trans['payer'] ?></p>
                                    </div>

                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .invoice-wrapper
            {
                margin: 3mm 3mm 3mm 3mm;
            }
            .card-header *  {
                display: none;
            }
            .sticky-wrapper {
                display: none;
            }
            .navbar-container content {
                display: none;
            }
            .receipt-content .invoice-wrapper {
                margin-top: 0px !important;
            }
            .content-wrapper{
                padding: none !important;
            }
        }
        .receipt-content .logo a:hover {
            text-decoration: none;
            color: #7793C4;
        }

        .receipt-content .invoice-wrapper {
            background: #FFF;
            padding: 40px 40px 60px;
            margin-top: 40px;
            border-radius: 4px;
            margin-bottom: 25px;
        }

        .receipt-content .invoice-wrapper .payment-details span {
            display: block;
        }
        .receipt-content .invoice-wrapper .payment-details a {
            display: inline-block;
            margin-top: 5px;
        }

        .receipt-content .invoice-wrapper .line-items .print a {
            display: inline-block;
            padding: 13px 13px;
            border-radius: 5px;
            color: #708DC0;
            font-size: 13px;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .line-items .print a:hover {
            text-decoration: none;
            border-color: #333;
            color: #333;
        }


        @media (min-width: 1200px) {
            .receipt-content .container {width: 900px; }
        }

        .receipt-content .logo {
            text-align: center;
            margin-top: 50px;
        }

        .receipt-content .logo a {
            font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
            font-size: 36px;
            letter-spacing: .1px;
            color: #555;
            font-weight: 300;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .intro {
            line-height: 25px;
            color: #444;
        }

        .receipt-content .invoice-wrapper .payment-info {
            margin-top: 25px;
            padding-top: 15px;
        }

        .receipt-content .invoice-wrapper .payment-info span {
            color: #A9B0BB;
        }

        .receipt-content .invoice-wrapper .payment-info strong {
            display: block;
            color: #444;
            margin-top: 3px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-info .text-right {
                text-align: left;
                margin-top: 20px; }
        }
        .receipt-content .invoice-wrapper .payment-details {
            border-top: 2px solid #EBECEE;
            margin-top: 30px;
            padding-top: 20px;
            line-height: 22px;
        }


        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-details .text-right {
                text-align: left;
                margin-top: 20px; }
        }
        .receipt-content .invoice-wrapper .line-items {
            margin-top: 40px;
        }
        .receipt-content .invoice-wrapper .line-items .headers {
            color: #A9B0BB;
            font-size: 13px;
            letter-spacing: .3px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 4px;
        }
        .receipt-content .invoice-wrapper .line-items .items {
            margin-top: 8px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 8px;
        }
        .receipt-content .invoice-wrapper .line-items .items .item {
            padding: 10px 0;
            font-size: 15px;
        }
        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item {
                font-size: 13px; }
        }
        .receipt-content .invoice-wrapper .line-items .items .item .amount {
            letter-spacing: 0.1px;
            color: #84868A;
            font-size: 16px;
        }
        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item .amount {
                font-size: 13px; }
        }

        .receipt-content .invoice-wrapper .line-items .total {
            margin-top: 30px;
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes {
            float: left;
            width: 40%;
            text-align: left;
            font-size: 13px;
            color: #7A7A7A;
            line-height: 20px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .total .extra-notes {
                width: 100%;
                margin-bottom: 30px;
                float: none; }
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
            display: block;
            margin-bottom: 5px;
            color: #454545;
        }

        .receipt-content .invoice-wrapper .line-items .total .field {
            margin-bottom: 7px;
            font-size: 14px;
            color: #555;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total {
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
            color: #20A720;
            font-size: 16px;
        }

        .receipt-content .invoice-wrapper .line-items .total .field span {
            display: inline-block;
            margin-left: 20px;
            min-width: 85px;
            color: #84868A;
            font-size: 15px;
        }

        .receipt-content .invoice-wrapper .line-items .print {
            margin-top: 50px;
            text-align: center;
        }



        .receipt-content .invoice-wrapper .line-items .print a i {
            margin-right: 3px;
            font-size: 14px;
        }

        .receipt-content .footer {
            margin-top: 40px;
            margin-bottom: 110px;
            text-align: center;
            font-size: 12px;
            color: #969CAD;
        }
    </style>
<script>
    $(document).on('click', "#talep_iptal", function (e) {
        let sf_id = $(this).attr('sf_id');
        let status = 0;
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
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talebi Kapatmak Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                '</div></form>',
            buttons: {
                formSubmit: {
                    text: 'Kapat',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Açıklama Zorunludur',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }

                        let desc = $('#desc').val()
                        jQuery.ajax({
                            url: baseurl + 'form/talep_iptal',
                            dataType: "json",
                            method: 'post',
                            data: 'desc=' + desc + '&status=' + status + '&talep_id=' + sf_id + '&' + crsf_token + '=' + crsf_hash,
                            beforeSend: function () {
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                } else {
                                    $.alert(data.message);
                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
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


    $(document).on('click', "#status_change", function (e) {
        let id = $(this).attr('data-id');
        $.confirm({
            title: 'Dikkat!',
            content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Durum</label>' +
                '<select class="form-control" id="form_2_status_id"><option value="11">Bankada</option><option value="6">Kapatıldı</option><option value="4">İptal</option></select>' +
                '</div>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let form_2_status_id = $('#form_2_status_id').val()
                        jQuery.ajax({
                            url: baseurl + 'form/status_change',
                            dataType: "json",
                            method: 'post',
                            data: 'status_id='+form_2_status_id+'&talep_id='+id+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    window.setTimeout(function () {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    $.alert(data.message);
                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
                            }
                        });



                    }
                },
                cancel: function () {
                    //close
                },
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
</script>
