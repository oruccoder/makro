<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Sipariş #<?php echo $invoice->invoice_no ?></span></h4>
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
                                                                    if($invoice->status==3 || $invoice->status==21 ){
                                                                        $disabled='disabled';
                                                                    } ?>
                                                                    <button type="button" class="btn btn-info edit_siparis" <?php echo $disabled;?> data-siparis_id="<?php echo $invoice->id?>"><i class="fa fa-pen"></i> Bilgileri Güncelle</button>
                                                                    <a type="button" class="btn btn-warning" href="/siparis/print_siparis/<?php echo $invoice->id?>?tip=0" target="_blank"><i class="fa fa-print"></i> Qiymetli Yazdır</a>
                                                                    <a type="button" class="btn btn-warning" href="/siparis/print_siparis/<?php echo $invoice->id?>?tip=1" target="_blank"><i class="fa fa-print"></i> Qiymetsiz Yazdır</a>
                                                                    <button class='btn btn-danger status_chage' <?php echo $disabled;?>  type='button' data-siparis_id='<?php echo $invoice->id?>'><i class='fa fa-retweet'></i> Durum Güncelle</button>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                        <div class="jarviswidget">
                                                            <input type="hidden" id="talep_id" value="<?php echo $invoice->id ?>">
                                                            <header>
                                                                <h4>Məlumat Sorğunun</h4></header>
                                                            <div class="borderedccc no-padding">
                                                                <div class="widget-body">
                                                                    <div class="col col-xs-12 col-sm-12 col-md-12 no-padding">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Alıcı: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo customer_details($invoice->csd)['company']?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Cari Layihe Adı: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo customer_new_projects_details($invoice->proje_id)->proje_name ?></span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Çıkış Ünvanı: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo warehouse_details($invoice->depo)->title ?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Çatdırılma Ünvanı: </span></td>
                                                                                    <td class="vert-align-mid" style="border:none">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo customer_teslimat_adres_details($invoice->shipping_id)->unvan_teslimat.' '.customer_teslimat_adres_details($invoice->shipping_id)->adres_teslimat ?></span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Açıklama: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo $invoice->notes?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Sipariş Kodu: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <?php echo $invoice->invoice_no ?>
                                                                                    </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Fiş Tarihi: </span></td>
                                                                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo dateformat_new($invoice->invoicedate)?></span></td>


                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Oluşturan Personel: </span></td>
                                                                                    <td class="vert-align-mid" >
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo personel_details($invoice->eid)?></span>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Sipariş Durumu: </span></td>
                                                                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo invoice_status($invoice->status)?></span></td>


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
                                                            <header> <h4>Sipariş Ürünleri</h4></header>
                                                            <?php if($products){  //varsa ?>
                                                                <table class="table" id="dt_table_list">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Ürün Adı</th>
                                                                        <th>Varyasyon</th>
                                                                        <th>Miktar</th>
                                                                        <th>Birim Fiyatı</th>
                                                                        <th>Toplam Tutar</th>
                                                                        <th>İşlem</th>
                                                                        <th>Ürün Değiştir</th>
                                                                        <th>Sil</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php $c = 1;

                                                                    foreach ($products as $row) {
                                                                        $unit_ = units_($row->unit)['name'];
                                                                        $varyasyon=invoice_options_html($row->id);
                                                                        $button='<button class="btn btn-success confirm" type="button" data-invoice_item_id="'.$row->id.'"><i class="fa fa-check"></i> Üretime Gönder</button>';
                                                                        $reverse='<button class="btn btn-success reverse_product" type="button" data-invoice_item_id="'.$row->id.'"><i class="fa fa-pen"></i> Ürün Değiştir</button>';
                                                                        $delete='<button class="btn btn-danger delete_product" type="button" data-invoice_item_id="'.$row->id.'"><i class="fa fa-trash"></i> Sil</button>';
                                                                        if(siparis_to_fis($row->id)['status']==200){
                                                                            $id=siparis_to_fis($row->id)['details']->id;
                                                                            $fis_code=siparis_to_fis($row->id)['details']->code;
                                                                            $reverse='Üretime Gönderişmiş Ürün Güncellenemez';
                                                                            $delete='Üretime Gönderişmiş Ürün Silinemez';
                                                                            $button='<a class="btn btn-success" type="button" href="/uretim/view_uretim_fisi?id='.$id.'"><i class="fa fa-eye"></i> Üretim Fişi Görüntüle '.$fis_code.'</button>';
                                                                        }
                                                                        echo '<tr>
                                                                                <th scope="row">' . $c . '</th>
                                                                                <td>' . $row->product . '</td>                 
                                                                                <td>' . $varyasyon . '</td>                 
                                                                                 <td>' .amountFormat_s($row->qty).' '.$unit_ . '</td>
                                                                                <td>' . amountFormat($row->price) . '</td>              
                                                                                <td>' . amountFormat($row->subtotal) . '</td>              
                                                                                <td>'.$button.'
                                                                                <td>'.$reverse.'
                                                                                <td>'.$delete.'
                                                                    </td>              
                                                                             
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
<input type="hidden" id="invoice_item_id">
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

    $(document).on('click','.edit_siparis',function (){
        let siparis_id = $(this).data('siparis_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgileri Düzenle',
            icon: 'fa fa-pen',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
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
      <label for="cari_id">Cari Adı</label>
     <select class="form-control select-box cari_id" id="cari_id">
            <option value="0">Seçiniz</option>
            <?php foreach (all_customer() as $emp){
                $emp_id=$emp->id;
                $name=$emp->company;
                ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
    </select>

    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="marka">Cari Proje Adı</label>
      <select class="form-control select-box cari_proje_id" id="cari_proje_id">
            <option value="0">Cari Seçiniz</option>

    </select>
    </div>
  <div class="form-group col-md-6">
      <label for="yil">Teslimat Deposu</label>
      <select class="form-control select-box cari_teslimat_id" id="cari_teslimat_id">
            <option value="0">Cari Seçiniz</option>

    </select>
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
       <label for="warehouse_id">Çıkış Deposu</label>
     <select class="form-control select-box warehouse_id required" id="warehouse_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_warehouse() as $emp){
                $emp_id=$emp->id;
                $name=$emp->title;
                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
    </div>
    <div class="form-group col-md-3">
      <label for="active_surucu_id">Sorumlu Personel</label>
     <select class="form-control select-box required" id="sorumlu_personel">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
     <div class="form-group col-md-3">
      <label for="active_surucu_id">Açıklama</label>
      <input type='text' class='form-control' id='desc'>
    </div>
</div>
<div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
         <div>
           <img class="myImg update_image" style="width: 322px;">
         </di>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>

            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>

            <span>Seçiniz...</span>
            <input id="fileupload_update" type="file" name="files[]">

            <input type="hidden" class="image_text_update" name="image_text_update" id="image_text_update">
      </div>
</form>`;

                let data = {
                    crsf_token: crsf_hash,
                    siparis_id: siparis_id
                }

                let table_report='';
                $.post(baseurl + 'siparis/get_info_siparis',data,(response) => {
                    self.$content.find('#person-list').empty().append(html)
                    let responses = jQuery.parseJSON(response);

                    $('#cari_id').val(responses.items.csd).select2().trigger('change',true)
                    setTimeout(function() {
                        $('#cari_proje_id').val(responses.items.proje_id).select2().trigger('change')
                        $('#cari_teslimat_id').val(responses.items.shipping_id).select2().trigger('change')
                    }, 200);

                    $('#warehouse_id').val(responses.items.depo).select2().trigger('change')
                    $('#sorumlu_personel').val(responses.items.sorumlu_pers_id).select2().trigger('change')
                    $('#desc').val(responses.items.notes);

                    if(responses.items.ext!=='default.png'){
                        $('#image_text_update').val(responses.items.ext);
                        $('.update_image').attr('src',"/userfiles/product/"+responses.items.ext)
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
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            siparis_id:$('#talep_id').val(),
                            cari_id:  $('#cari_id').val(),
                            cari_proje_id:  $('#cari_proje_id').val(),
                            cari_teslimat_id:  $('#cari_teslimat_id').val(),
                            warehouse_id:  $('#warehouse_id').val(),
                            sorumlu_personel:  $('#sorumlu_personel').val(),
                            desc:  $('#desc').val(),
                            image_text:  $('#image_text_update').val(),
                        }
                        $.post(baseurl + 'siparis/update_save_siparis',data,(response) => {
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

                $('#fileupload_update').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_update').val(img);
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
        let talep_id = $(this).data('siparis_id');
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
                                        <option value="20">Üretime Verildi</option>
                                        <option value="21">Tamamlandı</option>
                                        <option value="3">İptal Edildi</option>
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
                        $.post(baseurl + 'siparis/status_change',data,(response) => {
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
        let talep_id = $(this).data('invoice_item_id');
        $('#invoice_item_id').val(talep_id);
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Yeni Üretim',
            icon: 'fa fa-check-square 3x',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html=`<form>
                          <div class="form-row">
                             <div class="form-group col-md-12">
                              <label for="name">Depo Seçiniz</label>
                                   <select id="warehouse_id" class='form-control select-box'>
                                        <?php foreach (all_warehouse() as $items){
                                            echo "<option value='$items->id'>$items->title</option>";
                                                        } ?>
                                    </select>
                            </div>
                            <div class="form-group col-md-12">
                              <label for="name">Reçete Seçiniz</label>
                                   <select id="recete_id" class='form-control select-box'>
                                    </select>
                            </div>
                               <div class="form-group col-md-12">
                              <label for="name">Fiş Açıklaması</label>
                                <input type'text' class='form-control' id='desc'>
                            </div>
                            </div>
                        </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    invoice_item_id: talep_id,
                }

                let table_report='';
                $.post(baseurl + 'siparis/get_product_to_recete',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    if(responses.status==200){
                        $('#recete_id').append(new Option('Seçiniz', 0, false, false)).trigger('change');
                        responses.recete_details.forEach((item_,index) => {
                            $('#recete_id').append(new Option(item_.invoice_no, item_.id, false, false)).trigger('change');
                        })
                    }
                    else {
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

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Üretim Fişi Oluştur',
                    btnClass: 'btn-blue create_button',
                    action: function() {
                        if(!parseInt($('#recete_id').val())){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Reçete Seçmeniz Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        let data_post = {
                            invoice_item_id : talep_id,
                            siparis_id : $('#talep_id').val(),
                            recete_id : $('#recete_id').val(),
                            desc : $('#desc').val(),
                            warehouse_id : $('#warehouse_id').val(),
                        }
                        $.post(baseurl + 'siparis/uretim_fis_create', data_post, (response) => {
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
                                                window.location.href= data.link;
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
                                    content: responses.message,
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

    $(document).on('change','#recete_id, #warehouse_id',function (){
        let id = $('#recete_id').val();
        let warehouse_id = $("#warehouse_id").val();

        if(parseInt(id)){

            let data = {
                crsf_token: crsf_hash,
                recete_id: id,
                warehouse_id: warehouse_id,
                invoice_item_id:$('#invoice_item_id').val()
            }

            let table_report='';
            $.post(baseurl + 'siparis/uretim_kontrol',data,(response) => {
                let responses = jQuery.parseJSON(response);

                if(responses.status==200){
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: responses.messages,
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                                action:function (){
                                    $('.create_button').attr('disabled',false)
                                }
                            }
                        }
                    });

                }
                else {
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: responses.messages,
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                                action:function (){
                                    $('.create_button').attr('disabled',true)
                                }
                            }
                        }
                    });

                }

            });
        }
    })

    $(document).on('change','.cari_id',function (){
        let cari_id = $(this).val();
        let data = {
            cari_id:cari_id
        }
        $.post(baseurl + 'customers/teslimat_details',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.cari_teslimat_id option').remove()
            $('.cari_proje_id option').remove()
            $('#loading-box').addClass('d-none');
            if(responses.status==200){
                if(responses.teslimat_details.length){
                    responses.teslimat_details.forEach((item_,index) => {
                        $('.cari_teslimat_id').append(new Option(item_.adres_teslimat, item_.id, false, false)).trigger('change');
                    })
                }
                else {
                    $('.cari_teslimat_id').append(new Option('Cari Seçiniz', '', false, false));
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Teslimat Adresi Tanımlanmamış',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

                if(responses.proje_details.length){
                    responses.proje_details.forEach((item_,index) => {
                        $('.cari_proje_id').append(new Option(item_.proje_name, item_.id, false, false)).trigger('change');
                    })
                }
                else{
                    $('.cari_proje_id').append(new Option('Cari Seçiniz', '', false, false));
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Proje Tanımlanmamış',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            }
            else if(responses.status== 410){
                $('.cari_teslimat_id').append(new Option('Cari Seçiniz', '', false, false));
                $('.cari_proje_id').append(new Option('Cari Seçiniz', '', false, false));
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: responses.messages,
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }
        })

    })

    let table_product_id_ar=[];
    $(document).on('click','.reverse_product',function (){
        let eq = $(this).parent().parent().index();
        let invoice_item_id =$(this).data('invoice_item_id');
        console.log(eq);
        table_product_id_ar=[];
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Ekle',
            icon: 'fa fa-eye',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
  <div class="form-row">
   <div class="form-group col-md-12">
      <label for="product">Ürün Adı</label>
     <select class="form-control select-box product required" id="product">
    </select>
    </div>
     <div class="form-group col-md-12">
          <label for="qty">Miktar</label>
            <input type="number" class="form-control" value='0' id="qty">
    </div>
    <div class="form-group col-md-12">
          <label for="unit_id">Birim</label>
            <select class="form-control select-box unit_id required" id="unit_id">
                    <?php foreach (units() as $emp){
            ?>
                    <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                <?php } ?>
         </select>
    </div>
        <div class="form-group col-md-12">
          <label for="price">EDV Hariç Birim Fiyatı</label>
            <input type="number" class="form-control" value='0' id="price">
    </div
</div>

</form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        if(table_product_id_ar){
                            let qty = $('#qty').val();
                            let unit_id = $('#unit_id').val();
                            let price = $('#price').val();
                            let unit_name = $('#unit_id :selected').text();
                            let product_name = $('#product :selected').text();
                            let option_id_data='';
                            let option_value_id_data='';
                            if(table_product_id_ar[0]){
                                option_id_data=table_product_id_ar[0].option_id_data
                                option_value_id_data=table_product_id_ar[0].option_value_id_data
                            }
                            let total_price=price*qty;
                            let product_id=table_product_id_ar[0].product_id

                            let data = {
                                invoice_item_id: invoice_item_id,
                                product_id: product_id,
                                product_name:  product_name,
                                option_id_data:  option_id_data,
                                option_value_id_data: option_value_id_data,
                                qty:qty,
                                unit_id: unit_id,
                                price:  price,
                                total_price: total_price
                            }
                            $.post(baseurl + 'siparis/update_item',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.status == 200){
                                    $("#dt_table_list>tbody>tr>td:eq(0)").eq(eq).html(product_name);
                                    $("#dt_table_list>tbody>tr>td:eq(1)").eq(eq).html(table_product_id_ar[0].varyasyon_html);
                                    $("#dt_table_list>tbody>tr>td:eq(2)").eq(eq).html(qty+' '+unit_name);
                                    $("#dt_table_list>tbody>tr>td:eq(3)").eq(eq).html(price);
                                    $("#dt_table_list>tbody>tr>td:eq(4)").eq(eq).html(total_price);
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
                                                action:function (){
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


                    }
                },
            },
            onContentReady: function () {
                $('.product').select2({
                    dropdownParent: $(".jconfirm"),
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
                                warehouse_id: $('#warehouse').val(),
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

                    let product_id = $(this).val();
                    let warehouse = 0;
                    let varyasyon_durum=false;
                    let i =1;
                    $.confirm({
                        theme: 'modern',
                        closeIcon: true,
                        title: 'Varyasyonlar',
                        icon: 'fa fa-filter',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "large",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: function () {
                            let self = this;
                            let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                            let data = {
                                crsf_token: crsf_hash,
                                product_id: product_id
                            }

                            let table_report='';
                            $.post(baseurl + 'malzemetalep/get_product_to_value',data,(response) => {
                                self.$content.find('#person-list').empty().append(html);
                                let responses = jQuery.parseJSON(response);




                                $('.list').empty().html(responses.html)
                                if(responses.code==200){
                                    varyasyon_durum=true;
                                }
                            });
                            self.$content.find('#person-list').empty().append(html);
                            return $('#person-container').html();
                        },
                        buttons: {
                            formSubmit: {
                                text: 'Devam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let option_details=[];
                                    if(varyasyon_durum){
                                        $('.option-value:checked').each((index,item) => {
                                            option_details.push({
                                                'option_id':$(item).attr('data-option-id'),
                                                'option_name':$(item).attr('data-option-name'),
                                                'option_value_id':$(item).attr('data-value-id'),
                                                'option_value_name':$(item).attr('data-option-value-name'),
                                            })
                                        });
                                    }

                                    i++;
                                    let data_post = {
                                        crsf_token: crsf_hash,
                                        id: product_id,
                                        warehouse:warehouse,
                                        option_details:option_details
                                    }
                                    let data='';
                                    let result=false;
                                    let sayi=0;
                                    $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                                        let data_res = jQuery.parseJSON(response);

                                        let units = '<select class="form-control select-box line_unit_id">';
                                        data_res.units.forEach((item,index) => {
                                            units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                        })
                                        units+='</select>';
                                        if (data_res.code == 200) {
                                            data = {
                                                qty:          data_res.result.qty,
                                                unit_id:      data_res.result.unit_id,
                                                fis_type:     $("#type").val(),
                                                fis_name:     $("#type").find(':selected').data("name"),
                                                unit_name:    data_res.result.unit_name,
                                                warehouse_id: $("#warehouse").val(),
                                                anbar_name:   $("#warehouse").find(':selected').data('name'),
                                                product_id:   data_res.result.product_id,
                                                product_name: data_res.result.product_name,
                                                option_details: option_details

                                            }

                                            if(!result){
                                                let varyasyon_html='';
                                                let option_id_data='';
                                                let option_value_id_data='';
                                                if(option_details){
                                                    for (let i=0; i < option_details.length;i++){
                                                        varyasyon_html+=option_details[i].option_name+' : '+option_details[i].option_value_name+'<br>';
                                                        if(i===(option_details.length)-1){
                                                            option_id_data+=option_details[i].option_id;
                                                            option_value_id_data+=option_details[i].option_value_id;
                                                        }
                                                        else {
                                                            option_id_data+=option_details[i].option_id+',';
                                                            option_value_id_data+=option_details[i].option_value_id+',';
                                                        }

                                                    }


                                                }

                                                // $("#result>tbody").append('<tr data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-product_id="'+data.product_id+'"  id="remove'+i+'" class="result-row">' +
                                                //     '<td>'+i+'</td> ' +
                                                //     '<td>'+ data.product_name +'</td>' +
                                                //     '<td>'+ varyasyon_html +'</td>' +
                                                //     '<td>'+units+'</td>' +
                                                //     '<td> <input type="number" class="form-control qty" value="0"></td>' +
                                                //     '<td> <input type="number" class="form-control fire_oran"  value="0"></td>' +
                                                //     '<td> <input type="number" disabled class="form-control fire_miktar"  value="0"></td>' +
                                                //     '<td> <input type="number" disabled class="form-control toplam_miktar"  value="0"></td>' +
                                                //     '<td> <button data-id="'+i+'" class="btn btn-danger recete_item_remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                                //     '</tr>' );
                                                table_product_id_ar.push({
                                                    product_id : data.product_id,
                                                    product_options:data.option_details,
                                                    varyasyon_html:varyasyon_html,
                                                    option_id_data:option_id_data,
                                                    option_value_id_data:option_value_id_data,
                                                });

                                                return false;

                                            }
                                            else {
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: 'Ürün Daha Önceden Eklenmiştir',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                            }

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
            }
        });
    })

    $(document).on('click', ".delete_product", function (e) {
        let invoice_item_id =$(this).data('invoice_item_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İptal',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>ürünü Silmek İstediğinizen Emin Misiniz?</p>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-red',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            invoice_item_id:invoice_item_id,
                        }
                        $.post(baseurl + 'siparis/delete_item',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-success',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
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
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
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
</script>