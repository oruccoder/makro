<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Üretim Fişi #<?php echo $invoice['code'] ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col col-xs-12 col-sm-12 col-md-12 mb-12">
                                                        <div class="jarviswidget mb-3">
                                                            <div class="borderedccc no-padding">
                                                                <div class="widget-body" style="padding: 15px;">
                                                                    <?php
                                                                    $disabled='';
                                                                    if($invoice['status']==3 || $invoice['status']==4 ){
                                                                        $disabled='disabled';
                                                                    } ?>
                                                                    <button type="button" class="btn btn-info edit_uretim" <?php echo $disabled;?> talep_id="<?php echo $invoice['id']?>"><i class="fa fa-pen"></i> Məlumatı Yeniləyin</button>
                                                                    <a type="button" class="btn btn-warning" href="/uretim/print_uretim/<?php echo $invoice['id']?>" target="_blank"><i class="fa fa-print"></i> Çap Et</a>

                                                                    <?php
                                                                    $button='';
                                                                    if(fis_to_siparis($invoice['id'])['status']==200){
                                                                        $id=fis_to_siparis($invoice['id'])['details']->id;
                                                                        $fis_code=fis_to_siparis($invoice['id'])['details']->invoice_no;
                                                                        $cari_id=fis_to_siparis($invoice['id'])['details']->csd;
                                                                        echo "<input type='hidden' id='siparis_cari_id' value='$cari_id'>";
                                                                        $button='<a class="btn btn-success" type="button" target="_blank" href="/siparis/view/'.$id.'"><i class="fa fa-eye"></i> Sifariş Qəbzinə Baxın '.$fis_code.'</a>';
                                                                    }
                                                                    echo $button;
                                                                    ?>

                                                                    <button class='btn btn-danger status_chage' <?php echo $disabled;?>  type='button' data-uretim_id='<?php echo $invoice['id']?>'><i class='fa fa-retweet'></i> Statusu Yenilə</button>
                                                                    <button class='btn btn-success confirm' <?php echo $disabled;?>  type='button' data-uretim_id='<?php echo $invoice['id']?>'><i class='fa fa-check'></i> İstehsal Yaradın</button>
                                                                    <?php if(uretim_tehvil_fisleri($invoice['id'])['status']==200){ ?>
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                            Tehvil Formları <span class="caret"></span></button>
                                                                        <ul class="dropdown-menu" role="menu">
                                                                        <?php foreach (uretim_tehvil_fisleri($invoice['id'])['details'] as $fis_items){ ?>
                                                                            <li><a href="/uretim/tehvilprint/<?php echo $fis_items->id ?>"><?php echo $fis_items->invoice_no ?></a></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                    <?php } ?>
                                                                    <style>
                                                                        .dropdown-menu>li>a {
                                                                            display: block;
                                                                            padding: 3px 20px;
                                                                            clear: both;
                                                                            font-weight: 400;
                                                                            line-height: 1.42857143;
                                                                            color: #333;
                                                                            white-space: nowrap;
                                                                        }
                                                                    </style>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                        <div class="jarviswidget">
                                                            <input type="hidden" id="talep_id" value="<?php echo $invoice['id'] ?>">
                                                            <header>
                                                                <h4>Məlumat Sorğunun</h4></header>
                                                            <div class="borderedccc no-padding">
                                                                <div class="widget-body">
                                                                    <div class="col col-xs-12 col-sm-12 col-md-12 no-padding">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Şirkət: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin">MAKRO 2000 EĞİTİM TEKNOLOJİLERİ İNŞAAT TAAHHÜT İÇ VE DIŞ TİCARET ANONİM ŞİRKETİ</span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Açıklama: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo $invoice['uretim_desc']?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Fiş Kodu: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <?php echo $invoice['code'] ?>
                                                                                    </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Fiş Tarihi: </span></td>
                                                                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo dateformat_new($invoice['uretim_date'])?></span></td>


                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Oluşturan Personel: </span></td>
                                                                                    <td class="vert-align-mid" >
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo personel_details($invoice['user_id'])?></span>
                                                                                    </td>

                                                                                </tr>
                                                                                <tr>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Üretilecek Ürün : </span></td>
                                                                                    <td class="vert-align-mid" >
                                                                                        <?php
                                                                                        $option_html='Varyasyonsuz';
                                                                                        $details_options = uretim_new_products($invoice['recete_id']);

                                                                                        if($details_options){
                                                                                            $option_html='';
                                                                                            foreach ($details_options as $options_items){
                                                                                                $option_html.=varyasyon_string_name($options_items->option_id,$options_items->option_value_id);
                                                                                            }
                                                                                        }

                                                                                        $search = ['<p>','</p>'];
                                                                                        ?>


                                                                                        <span class="txt-color-darken no-padding " data-popup="popover" title="" data-trigger="hover" data-content="<?php echo str_replace($search,'',$option_html)?>" data-original-title="Varyasyolar"><b><?php echo ' <b>'.product_details($invoice['product_id'])->product_name.'</b> '.amountFormat_s($invoice['quantity']).' '.units_($invoice['unit_id'])['name'];?></b></span>

                                                                                        <style>
                                                                                            .tooltip {
                                                                                                position: relative;
                                                                                                display: inline-block;
                                                                                                border-bottom: 1px dotted black;
                                                                                            }

                                                                                            .tooltip .tooltiptext {
                                                                                                visibility: hidden;
                                                                                                width: 120px;
                                                                                                background-color: black;
                                                                                                color: #fff;
                                                                                                text-align: center;
                                                                                                border-radius: 6px;
                                                                                                padding: 5px 0;

                                                                                                /* Position the tooltip */
                                                                                                position: absolute;
                                                                                                z-index: 1;
                                                                                            }

                                                                                            .tooltip:hover .tooltiptext {
                                                                                                visibility: visible;
                                                                                            }
                                                                                        </style>
                                                                                    </td>

                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Depo : </span></td>
                                                                                    <td class="vert-align-mid" >
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo warehouse_details($invoice['depo_id'])->title?></span>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Fiş Durumu: </span></td>
                                                                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo uretim_status($invoice['status'])->name?></span></td>


                                                                                </tr>


                                                                                </tbody></table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget" id="wid-id-7">
                                                            <header> <h4>Üretim Materialları</h4></header>
                                                            <?php if($products){  //varsa ?>
                                                                <table class="table" id="dt_table_list">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th><?php echo $this->lang->line('Item Name') ?></th>
                                                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                                                        <th class="text-xs-left"><?php echo $this->lang->line('fire') ?></th>
                                                                        <th class="text-xs-left"><?php echo $this->lang->line('fire_quantity') ?></th>
                                                                        <th class="text-xs-left"><?php echo $this->lang->line('toplam_tuketilen') ?></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php $c = 1;

                                                                    foreach ($products as $row) {
                                                                        $unit_ = units_($row['unit_id'])['name'];
                                                                        echo '<tr>
                                <th scope="row">' . $c . '</th>
                                                            <td>' . $row['name'] . '</td>                 
                                                             <td>' .amountFormat_s($row['quantity_2']).' '.$unit_ . '</td>
                                                            <td>' . '% '.$row['fire'].'</td>
                                                            <td>' .amountFormat_s($row['fire_quantity']).' '.$unit_. '</td>
                                                            <td>' .amountFormat_s($row['toplam_tuketilen']).' '.$unit_. '</td>
                                                        </tr>';


                                                                        $c++;
                                                                    } ?>


                                                                    </tbody>
                                                                </table>

                                                                <?php

                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget">
                                                            <header> <h4>Üretim Hareketleri</h4></header>
                                                            <table class="table" id="mt_talep_history" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Personel Adı</th>
                                                                    <th>Açıklama</th>
                                                                    <th>İşlem Tarihi</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .image_talep_product{
        position: relative;
        display: inline-block;
        width: 10%;
        white-space: nowrap;
        vertical-align: bottom;
    }
    .input-group-addon{
        border: 1px solid gray;
        border-left: none;
        border-radius: 0px 17px 16px 0px;
        padding: 12px;
        font-size: 12px;
    }
    .nav-tabs .nav-link.disabled{
        color: #ffffff !important;
        background: #7585a3 !important;
    }
</style>
<link href="<?php echo  base_url() ?>app-assets/talep.css?v=<?php echo rand(11111,99999) ?>" rel="stylesheet" type="text/css">
<script>
    $(document).ready(function (){
        draw_data_history();
    })

    function draw_data_history(talep_id=0) {
        $('#mt_talep_history').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'ajax': {
                'url': "<?php echo site_url('uretim/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: $('#talep_id').val(),
                    tip: 2,
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

            ]
        });
    };
    $(document).on('click','.edit_uretim',function (){
        uretim_table_product_id_ar=[];
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgileri Düzenle',
            icon: 'fa fa-pen',
            type: 'orange',
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
      <label for="name">Miktar</label>
      <input type='numaric' class='form-control miktar' id='miktar'>
      <input type='hidden' class=' hid_mik' id='hid_mik'>
    </div>

</div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
    </div>
</div>
</form>
   `;

                let data = {
                    crsf_token: crsf_hash,
                    uretim_id: $('#talep_id').val()
                }

                let table_report='';
                $.post(baseurl + 'uretim/get_info_fis',data,(response) => {
                    self.$content.find('#person-list').empty().append(html)
                    let responses = jQuery.parseJSON(response);

                    $('#miktar').val(responses.items.quantity);
                    $('#hid_mik').val(responses.items.quantity);
                    $('#desc').val(responses.items.uretim_desc);

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
                            uretim_id:  $('#talep_id').val(),
                            miktar:  $('#miktar').val(),
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'uretim/update_save_uretim',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status == 200){
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
                                                location.reload();
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

                $('.product_id').select2({
                    dropdownParent: $(".jconfirm-box-container"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder:'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method:'POST',
                        url: '<?php echo base_url().'stockio/getall_products' ?>',
                        dataType: 'json',
                        data:function (params)
                        {
                            let query = {
                                search: params.term,
                                warehouse_id: 0,
                                crsf_token: crsf_hash,
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (data) {
                                    return {
                                        text: data.product_name,
                                        product_name: data.product_name,
                                        id: data.pid,

                                    }
                                })
                            };
                        },
                        cache: true
                    },
                }).on('change',function (data) {
                })

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

            }
        });
    })
    $(document).on('keyup','.miktar',function (){
        let new_qty = $(this).val();
        let data = {
            crsf_token: crsf_hash,
            uretim_id: $('#talep_id').val(),
            qty: new_qty,
        }

        let table_report='';
        $.post(baseurl + 'uretim/stok_kontrol',data,(response) => {
            let responses = jQuery.parseJSON(response);
            if(responses.status==0){
                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: 'Stok Uyarısı',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-3 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: responses.message,
                    buttons: {
                        cancel:{
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
                            action:function(){
                                $('#miktar').val($('.hid_mik').val())
                            }
                        },
                    }
                });
            }

        });
    })

    $(document).on('click', ".status_chage", function (e) {
        let talep_id = $(this).data('uretim_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Durum',
            icon: 'fa fa-signal',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`
            <div class="form-group col-md-12">
      <label for="firma_id">Açıklama</label>
     <input type='text' class='form-control' id='desc'>
    </div>
            <div class="form-group col-md-12">
      <label for="firma_id">Status</label>
     <select class="form-control select-box required" id="status">
                                       <option value="1">Bekliyor</option>
                                        <option value="2">Üretimde</option>
                                        <option value="4">İptal</option>
                                    </select>

    </div>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-success',
                    action: function () {
                        let desc=$('#desc').val();
                        if(parseInt($('#status').val())==4){
                            if(desc.length==0){
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
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id: talep_id,
                            desc: desc,
                            status: $('#status').val(),
                        }
                        $.post(baseurl + 'uretim/status_change',data,(response) => {
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
                                              location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

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

    $(document).on('click','.confirm',function (){
        let talep_id = $(this).data('uretim_id');

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'İstehsal Yaradın',
            icon: 'fa fa-check-square 3x',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="cari_proje_id">Müştəri Layihəsinin Adı</label>
                          <select class="form-control select-box cari_proje_id" id="cari_proje_id">
                                <?php foreach (customers_project_details($cari_id) as $items)
                                {
                                    echo "<option value='$items->id'>$items->proje_name</option>";
                                }

                                ?>

                        </select>
                        </div>
                      <div class="form-group col-md-6">
                          <label for="yil">Çatdırılma Ambarı</label>
                          <select class="form-control select-box cari_teslimat_id" id="cari_teslimat_id">
                                  <?php foreach (customer_teslimat_adresleri($cari_id) as $items)
                                    {
                                        echo "<option value='$items->id'>$items->unvan_teslimat</option>";
                                    }

                                    ?>

                        </select>
                        </div>
                    </div>
                     <div class="form-row">
                           <div class="form-group col-md-6">
                                <label>Maşın Qaydiyat Nömresi</label>
                                <input type="text" id="plaka_no" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Çatdırılmaq Üçün istehsal Edilen Miqdarı</label>
                                <input type="number" value="0" id="uretim_qty" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Qeyd</label>
                            <input type="text" id="desc" class="form-control">
                        </div>
                    </form>`,
            buttons: {
                formSubmit: {
                    text: 'Əməliyyatı Qeydiyyatdan Keçirin',
                    btnClass: 'btn-blue',
                    action: function() {
                        let data_post = {
                            uretim_id : talep_id,
                            desc : $('#desc').val(),
                            plaka_no : $('#plaka_no').val(),
                            cari_proje_id : $('#cari_proje_id').val(),
                            cari_teslimat_id : $('#cari_teslimat_id').val(),
                            uretim_qty : $('#uretim_qty').val(),
                        }
                        $.post(baseurl + 'uretim/muhasebe', data_post, (response) => {
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function() {
                                                location.reload();
                                                // $('#muhasebelestirme').remove()
                                                // $('.muhasebelestirme').append("<a href='/products/view_stok_fisi?id="+data.stok_id+"'>Stok Fişini Görüntüle</a>");

                                            }
                                        }
                                    }
                                });

                            } else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons: {
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
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action: function() {
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function() {

                $('#fileupload_').fileupload({
                    url: baseurl + 'upload/file_upload',
                    dataType: 'json',
                    formData: {
                        '<?= $this->security->get_csrf_token_name() ?>': crsf_hash,
                        'path': '/userfiles/product/'
                    },
                    done: function(e, data) {
                        var img = 'default.png';
                        $.each(data.result.files, function(index, file) {
                            img = file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function(e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
</script>