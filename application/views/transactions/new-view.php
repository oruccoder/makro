<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Makbuz</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
             <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <?php echo '<a onclick="window.print();" target="_blank" class="btn btn-info btn-xs" style="color: white">Yazdır</a>'; ?>
                        <?php
                        if($trans['ext']!='default.png' && $trans['ext']!=''){
                        echo '<a target="_blank" href="' . base_url() . 'userfiles/product/' . $trans['ext'] . '"  class="btn btn-info btn-xs"  title="Dosya">Dosya Görüntüle</a>';
                        }
                        ?>
                        <?php if($this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==39) {
                            ?>
                            <button class="btn btn-success price_update" data-object-id="<?php echo  $trans['id']?>" price="<?php echo  $trans['total']?>" >
                                Tutar Güncelle
                            </button>
                            <button class="btn btn-success proje_update" data-object-id="<?php echo  $trans['id']?>" proje_id="<?php echo  $trans['proje_id']?>" >
                                Proje Güncelle
                            </button>
                            <?php
                        } ?>

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
                                                        <span>Makbuz No</span>
                                                        <strong>MKB#<?php echo $trans['id']?></strong>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <span>Tarih</span>
                                                        <strong><?php echo dateformat($trans['invoicedate'])?></strong>
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
                                                        <span><?php if($trans['cari_pers_type']==2) echo 'Personel'; else { echo 'Cari'; }; ?></span>
                                                        <strong>
                                                            <?php echo $trans['payer']?>
                                                        </strong>
                                                        <p>
                                                            <?php if($trans['cari_pers_type']==2){
                                                                $datails = personel_detailsa($trans['csd']);
                                                                echo $datails['address'].'<br>
                                                                    '.$datails['city'].' '.$datails['region'].'<br>
                                                                   '.$datails['phone'].'<br>';
                                                            }
                                                            else {
                                                                $datails = customer_details($trans['csd']);

                                                            }
                                                            ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="line-items">
                                                <div class="headers clearfix">
                                                    <div class="row">
                                                        <?php if($trans['acid']!=0){ ?>
                                                        <div class="col-md-4">Hesap / Kasa</div>
                                                            <div class="col-md-4">İşlem</div>
                                                        <?php } else { ?>
                                                            <div class="col-md-8">İşlem</div>
                                                      <?php  } ?>

                                                        <div class="col-md-4 text-right">Tutar</div>
                                                    </div>
                                                </div>
                                                <div class="items">
                                                    <div class="row item">
                                                        <?php if($trans['acid']!=0){ ?>
                                                        <div class="col-md-4 desc">
                                                            <?php echo hesap_getir($trans['acid'])->holder ?>
                                                        </div>
                                                        <div class="col-md-4 desc">
                                                            <?php }
                                                            else {
                                                                ?>
                                                                <div class="col-md-8 desc">
                                                                <?php
                                                            }?>

                                                                <?php
                                                                $cost_name='';
                                                                if($trans['masraf_id']!=0){
                                                                    $cost_name = masraf_name($trans['masraf_id']);
                                                                }
                                                                echo $trans['invoice_type_desc'].' '.$cost_name ?>
                                                            </div>
                                                            <div class="col-md-4 amount text-right">
                                                                <?php echo amountFormat($trans['total']) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="total text-right">
                                                        <p class="extra-notes">
                                                            <strong>Not</strong>
                                                            <?php echo $trans['notes'] ?>
                                                        </p>
                                                        <div class="field grand-total">
                                                            Toplam <span>   <?php echo amountFormat($trans['total']) ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <br>
                                                <br>
                                                <br>
                                                <div class="row">
                                                    <p class="col-md-6 text-left" >Sorumlu Personel</p>
                                                    <p class="col-md-6 text-right" ><?php if($trans['cari_pers_type']==2) echo 'Personel'; else { echo 'Cari'; }; ?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-md-6 text-left" style="font-weight: bold"><?php  echo personel_detailsa($trans['eid'])['name']; ?></p>
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
                 <?php if(parcala_multi_kontrol($trans['id'])['status']) { ?>
                <div class="card">
                 <table class="table table-bordered">
                     <thead>
                     <tr>
                         <td>No</td>
                         <td>İşlem Tarihi</td>
                         <td>İşlemi Yapan Personel</td>
                         <td>Proje</td>
                         <td>Tutar</td>
                         <td>Açıklama</td>
                         <td>İşlem</td>
                     </tr>
                     </thead>
                     <tbody>
                     <?php  $i = 1; foreach(parcala_multi_kontrol($trans['id'])['details'] as $items_value){
                         ?>
                         <tr>
                             <th><?php echo $i;?></th>
                             <th><?php echo $items_value->created_at;?></th>
                             <th><?php echo personel_detailsa($items_value->aauth_id)['name'];?></th>
                             <th><?php echo proje_code($items_value->proje_id);?></th>
                             <th><?php echo amountFormat($items_value->amount);?></th>
                             <th><?php echo invoice_details($items_value->invoice_transaction_id)->notes;?></th>
                             <th><a target="_blank" class="btn btn-outline-success" href="/transactions/view?id=<?php echo $items_value->invoice_transaction_id?>">Görüntüle</a></th>
                         </tr>
                         <?php
                    $i++; } ?>

                     </tbody>
                 </table>
             </div>
                 <?php  } ?>
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
    $(document).on('click', ".price_update", function (e) {
        let invoice_id = $(this).attr('data-object-id');
        let price = $(this).attr('price');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Tutar Güncelleme!',
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
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_rp">'+
                    '<input class="form-control price_update_val" id="price_update" value="'+floatVal(price)+'" name="price_update">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var name = this.$content.find('.price_update_val').val();
                        if(!name){
                            ('#loading-box').addClass('d-none');
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tüm Alanlar Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;

                        }
                        let data = {
                            invoice_id:invoice_id,
                            price:$('#price_update').val(),
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'accounts/price_update',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Güncellendi.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#trans_table').DataTable().destroy();
                                draw_data();
                            }
                            else if(responses.status=='Error'){
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
                cancel:{
                    text: 'Kapat',
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

    $(document).on('click', ".proje_update", function (e) {
        let invoice_id = $(this).attr('data-object-id');
        let proje_id = $(this).attr('proje_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Proje Güncelleme!',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+=` <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id" id="proje_id">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                $emp_id=$emp->id;
                $name=$emp->code;
                ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
</div>`;

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.proje_id').val(proje_id).select2().trigger('change');

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
                            invoice_id:invoice_id,
                            proje_id:$('.proje_id').val(),
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'accounts/proje_update_transaction',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Güncellendi.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#trans_table').DataTable().destroy();
                                draw_data();
                            }
                            else if(responses.status=='Error'){
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
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.proje_id').select2({
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
    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };
</script>
