<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Üretim Reçetesi <?php echo $details->invoice_no ?></span></h4>
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
                                                                    <button type="button" class="btn btn-info edit_uretim" talep_id="<?php echo $details->id?>"><i class="fa fa-pen"></i> Bilgileri Güncelle</button>
                                                                    <a type="button" class="btn btn-warning" href="/uretim/print_recete_is/<?php echo $details->id?>" target="_blank"><i class="fa fa-print"></i> Yazdır</a>
                                                                    <!--                                                                    <a type="button" class="btn btn-success" href="/uretim/yeni_uretim?id=--><?php //echo $details->id?><!--" target="_blank"><i class="fa fa-plus"></i> Üretime Gönder</a>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                        <div class="jarviswidget">
                                                            <input type="hidden" id="talep_id" value="<?php echo $details->id ?>">
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

                                                                                <!--                                                                                <tr>-->
                                                                                <!--                                                                                    <td class="vert-align-mid" style="border:none" ><span class="font-sm txt-color-darken no-padding"> Proje Bölüm: </span></td>-->
                                                                                <!--                                                                                    <td class="vert-align-mid" style="border:none" >-->
                                                                                <!--                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin">--><?php //echo bolum_getir($details->bolum_id)?><!--</span>-->
                                                                                <!--                                                                                    </td>-->
                                                                                <!--                                                                                    <td class="vert-align-mid" style="border:none"><span class="font-sm txt-color-darken no-padding">Proje Aşaması: </span></td>-->
                                                                                <!--                                                                                    <td class="vert-align-mid" style="border:none">-->
                                                                                <!--                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin">--><?php //echo task_to_asama($details->asama_id)?><!--</span>-->
                                                                                <!--                                                                                    </td>-->
                                                                                <!--                                                                                </tr>-->


                                                                                <tr>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Açıklama: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo $details->notes?></span>
                                                                                    </td>
                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding dgt_relatedPersons">Reçete Kodu: </span></td>
                                                                                    <td class="vert-align-mid">
                                                                                    <span class="font-md-2 txt-color-darken no-padding dgt_relatedPersons no-margin">
                                                                                        <?php echo $details->invoice_no; ?>
                                                                                    </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="vert-align-mid" ><span class="font-sm txt-color-darken no-padding"> Reçete Tarihi: </span></td>
                                                                                    <td class="vert-align-mid" ><span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo dateformat_new($details->invoicedate)?></span></td>


                                                                                    <td class="vert-align-mid"><span class="font-sm txt-color-darken no-padding">Oluşturan Personel: </span></td>
                                                                                    <td class="vert-align-mid" >
                                                                                        <span class="font-md-2 txt-color-darken no-padding no-margin"><?php echo personel_details($details->eid)?></span>
                                                                                    </td>

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
                                                            <header> <h4>Reçete Materialları</h4></header>
                                                            <?php if($items){  //varsa ?>
                                                                <table class="table" id="dt_table_list">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Resim</th>
                                                                        <th>Malzeme</th>
                                                                        <th>Varyasyon</th>
                                                                        <th>Miktar</th>
                                                                        <th>Birim</th>
                                                                        <th>Fire Oranı</th>
                                                                        <th>Fire Miktarı</th>
                                                                        <th>Toplam Miktar</th>
                                                                        <th>Sil</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                    $i=1;
                                                                    $eq=0;
                                                                    foreach ($items as $values) {
                                                                        $html='';

                                                                        //$p_price = piyasa_fiyati($values->product_id,$talep_form_product_options_teklif_values);

                                                                        $image=product_full_details($values->pid)['image']
                                                                        ?>
                                                                        <tr id="remove<?php echo $values->id?>">
                                                                            <td><?php echo $i ?></td>
                                                                            <td><span class="avatar-lg align-baseline"><img class="image_talep_product" src="<?php echo base_url().'userfiles/product/thumbnail/'.$image ?>"></span></td>
                                                                            <td><?php echo $values->product ?></td>
                                                                            <td><?php echo invoice_options_html($values->id)?></td>
                                                                            <td><?php echo amountFormat_s($values->qty) ?></td>
                                                                            <td><?php echo units_($values->unit)['name'] ?></td>
                                                                            <td><?php echo amountFormat_s($values->fire).' %'; ?></td>
                                                                            <td><?php echo amountFormat_s($values->fire_quantity).' '.units_($values->unit)['name'] ?></td>
                                                                            <td><?php echo amountFormat_s($values->fire_qty_total).' '.units_($values->unit)['name'] ?></td>
                                                                            <td><button type="button" class="btn btn-danger form_remove_products" type_="1" durum="1" item_id="<?php echo $values->id?>"><i class="fa fa-trash"></i></button></td>



                                                                            <td></td>
                                                                        </tr>
                                                                        <?php $i++; } ?>

                                                                    </tbody>
                                                                </table>

                                                                <?php

                                                            }
                                                            else {
                                                                ?>
                                                                <div class="mt-2">
                                                                    <h2 style="text-align: center">Zəhmət olmasa material əlavə etməyi unutmayın...</h2>
                                                                </div>


                                                                <?php
                                                            }?>

                                                            <div class="text-center">
                                                                <button  type="button" class="btn btn-primary add_product" style="margin: 20px;"><i class="fa fa-plus"></i> Tələb etmək üçün material təyin edin</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col col-md-12 col-xs-12">
                                                        <div class="jarviswidget">
                                                            <header> <h4>Sorğu ilə Əlaqəli Fayllar</h4></header>
                                                            <div class="borderedccc no-padding">
                                                                <?php if($file_details){
                                                                    foreach ($file_details as $file_items){
                                                                        ?>
                                                                        <ul class="list-inline">
                                                                            <li id="systemfile_2" class="col-sm-12 margin-bottom-5">
                                                                                <div class="well welldocument">
                                                                                    <label><b><?php echo $file_items->image_text?></b></label>
                                                                                    <div class="">
                                                                                        <div class="font-xs">Yüklenme Tarihi: <?php echo dateformat_new($file_items->created_at)?></div>
                                                                                        <div class="font-xs">Yükleyen: <?php echo personel_details($file_items->user_id)?></div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="btn-group">
                                                                                            <a class="btn btn-success" download href="<?php echo base_url() . 'userfiles/product/'.$file_items->image_text ?>"  >
                                                                                                <i class="fa fa-download"></i>
                                                                                            </a>
                                                                                            <button class="btn btn-danger delete_file" file_id="<?php echo $file_items->id?>">
                                                                                                <i class="fa fa-trash"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="clear:both"></div>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    <?php }
                                                                } ?>
                                                                <hr>
                                                                <ul class="list-inline">
                                                                    <li id="systemfile_2" class="margin-bottom-5">
                                                                        <div class="well welldocument">
                                                                            <button class="btn btn-success new_file">Yeni Dosya Ekle</button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col col-md-12 col-xs-12">
                                                    <div class="jarviswidget">
                                                        <header> <h4>Reçete Hareketleri</h4></header>
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


<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>app-assets/wizard.css">
<link href="<?php echo  base_url() ?>app-assets/talep.css?v=<?php echo rand(11111,99999) ?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script src="<?php echo  base_url() ?>app-assets/talepform/uretim_create.js?v=<?php echo rand(11111,99999)?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript">

    $(document).on('change','.all_siparis_checkbox',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_siparis_checkbox').prop('checked',true)
        }
        else {
            $('.one_siparis_checkbox').prop('checked',false)
        }
    })

    let item_id=[];
    let talep_id=$('#talep_id').val();
    var url = '<?php echo base_url() ?>arac/file_handling';

    $(document).ready(function (){
        draw_data_history();
    })
    $(document).on('click','.add_product',function (){
        let file_id =$(this).attr('file_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Reçete Fişi',
            icon: 'fa fa-external-link-square-alt 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form >
                        <div class="row">
                            <div class="col-md-6">
                                  <lable>Məhsul</lable>
                                  <select id="product" class="form-control product" >

                                  </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" id="add-product-in" class="btn btn-primary mt-2 ">Ekle</buttton>
                              </div>
                        </div>

                     </form>
                     <p class="test"></p>
                          <table id="result" class="table ">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Mehsul</th>
                          <th scope="col">Varyasyon</th>
                          <th scope="col">Olcu vahidi</th>
                          <th scope="col">Miqdar</th>
                          <th scope="col">Fire Oranı</th>
                          <th scope="col">Fire Miktarı</th>
                          <th scope="col">Toplam Miktar</th>
                          <th scope="col">Sil</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                   `,
            buttons: {

                formSubmit: {
                    text: 'Gondər',
                    btnClass: 'btn-blue',
                    action: function () {
                        let count = $('.result-row').length;
                        let collection = [];

                        for(let i=0;i<count;i++){
                            let data = {
                                unit_id: $('.line_unit_id').eq(i).val(),
                                option_id: $('.result-row').eq(i).data('option-id'),
                                product_stock_code_id: $('.result-row').eq(i).data('product_stock_code_id'),
                                value_id: $('.result-row').eq(i).data('option-value-id'),
                                product_id: $('.result-row').eq(i).data('product_id'),
                                qty: $('.result-row .qty').eq(i).val(),
                                fire_oran: $('.result-row .fire_oran').eq(i).val(),
                                fire_miktar: $('.result-row .fire_miktar').eq(i).val(),
                                toplam_miktar: $('.result-row .toplam_miktar').eq(i).val(),
                            }

                            collection.push(data)
                        }

                        let data_post = {
                            collection: collection,
                            invoice_id: talep_id,
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'uretim/create_item',data_post,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function () {
                                                location.reload()
                                            }
                                        }
                                    }
                                });

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
                                    content: data.message,
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
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function () {

                $('.product').select2({
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
                })

                $('.warehouse').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                $('.project').select2({
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
    let table_product_id_ar = [];
    let uretim_table_product_id_ar = [];
    $(document).on('click','#add-product-in',function(){

        let product_id = $('#product').val();
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
                                // option_details.push({
                                //     'option_id':$(item).attr('data-option-id'),
                                //     'option_name':$(item).attr('data-option-name'),
                                //     'option_value_id':$(item).attr('data-value-id'),
                                //     'option_value_name':$(item).attr('data-option-value-name'),
                                // })

                                option_details.push({
                                    'stock_code_id':$(item).attr('stock_code_id'),
                                })
                            });
                        }
                        else {


                        }

                        let proje_name = '-';
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
                                    varyasyon_name:   data_res.result.varyasyon_name,
                                    product_id:   data_res.result.product_id,
                                    product_name: data_res.result.product_name,
                                    option_details: option_details

                                }

                                if(!result){
                                    let varyasyon_html='';
                                    let option_id_data='';
                                    let product_stock_code_id=0;
                                    let option_value_id_data='';
                                    if(data.product_stock_code_id){
                                        product_stock_code_id = option_details[0].product_stock_code_id;
                                    }

                                    $("#result>tbody").append('<tr  data-product_stock_code_id="'+data_res.result.product_stock_code_id+'" data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-product_id="'+data.product_id+'"  id="remove'+i+'" class="result-row">' +
                                        '<td>'+i+'</td> ' +
                                        '<td>'+ data.product_name +'</td>' +
                                        '<td>'+ data.varyasyon_name +'</td>' +
                                        '<td>'+units+'</td>' +
                                        '<td> <input type="number" class="form-control qty" value="0"></td>' +
                                        '<td> <input type="number" class="form-control fire_oran"  value="0"></td>' +
                                        '<td> <input type="number" disabled class="form-control fire_miktar"  value="0"></td>' +
                                        '<td> <input type="number" disabled class="form-control toplam_miktar"  value="0"></td>' +
                                        '<td> <button data-id="'+i+'" class="btn btn-danger recete_item_remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                        '</tr>' );
                                    setTimeout(function() {
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    }, 1000);
                                    table_product_id_ar.push({product_id : data.product_id,product_options:data.option_details });
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
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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


    $(document).on('click','.form_add_products',function (){
        let eq = $(this).attr('eq');
        let proje_stoklari_id = $(this).attr('proje_stoklari_id');
        let option_details=[];

        option_details.push({
            'option_id':$(this).attr('option_id'),
            'option_value_id':$(this).attr('option_value_id'),
        })
        let data = {
            product_id:$('.product_id').eq(eq).val(),
            option_details:option_details,
            proje_stoklari_id:proje_stoklari_id,
            product_desc:$('.product_desc').eq(eq).val(),
            product_kullanim_yeri:$('.product_kullanim_yeri').eq(eq).val(),
            product_temin_date:$('.product_temin_date').eq(eq).val(),
            progress_status_id:$('.progress_status_id').eq(eq).val(),
            unit_id:$('.unit_id').eq(eq).val(),
            product_qty:$('.product_qty').eq(eq).val(),
            form_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'malzemetalep/create_form_items',data,(response)=>{
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
                    content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                    buttons:{
                        formSubmit: {
                            text: 'Tamam',
                            btnClass: 'btn-blue',
                            action: function () {
                                let table=`<tr  id="remove`+responses.talep_form_products_id+`" >
                                                    <td><p>`+responses.product_name+`</p><span style="font-size: 12px;">`+responses.option_html+`</span></td>
                                                    <td>`+responses.qyt_birim+`</td>
                                                    <td><button item_id='`+responses.talep_form_products_id+`' type_="2" class="btn btn-danger btn-sm form_remove_products" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                                $('.table_create_products tbody').append(table);
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
                    content: 'Kriterlere Uygun Ürün Bulunamadı!',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }

        });
    })

    $(document).on('keyup','.qty,.fire_oran',function (){
        let eq = $(this).parent().parent().index();
        let qty = $('.qty').eq(eq).val();
        let fire_oran = $('.fire_oran').eq(eq).val();

        var fire_mik = (qty * fire_oran)/100;
        $(".fire_miktar").eq(eq).val(fire_mik.toFixed(4));
        let toplam_miktar = parseFloat(fire_mik)+parseFloat(qty);
        $(".toplam_miktar").eq(eq).val(toplam_miktar.toFixed(4));
    })

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
      <label for="name">Reçete Adı</label>
     <input type='text' class='form-control' id='recete_adi' name='recete_adi'>
     <input type='hidden' id='product_id_edit' value='0' name='product_id_edit'>
    </div>
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id project required" id="project">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                $emp_id=$emp->id;
                $name=$emp->code;
                ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
    <div class="form-group col-md-12">
      <label for="name">Üretilecek Ürün</label>
      <select class="form-control product_id required" id="product_id">
                <option value="0">Seçiniz</option>

            </select>
    </div>
    <div class="form-group col-md-12">
      <label for="name">Ürün Birimi</label>
      <select class="form-control  uretim_unit_id required" id="uretim_unit_id">
                       <?php foreach (units() as $row) {
                    $id = $row['id'];
                    $cid = $row['code'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
                ?>

            </select>
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
                    recete_id: talep_id,
                }

                let table_report='';
                $.post(baseurl + 'uretim/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html)
                    let responses = jQuery.parseJSON(response);

                    $('#recete_adi').val(responses.items.invoice_name);
                    $('#desc').val(responses.items.notes);
                    $('#project').val(responses.items.proje_id).select2().trigger('change')
                    // $('#product_id').val(responses.items.new_prd_id).select2().trigger('change')
                    $('#uretim_unit_id').val(responses.items.term);

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
                            recete_id:  talep_id,
                            proje_id:  $('#project').val(),
                            recete_adi:  $('#recete_adi').val(),
                            desc:  $('#desc').val(),
                            product_id:  $('#product_id_edit').val(),
                            product_details:  uretim_table_product_id_ar,
                            uretim_unit_id:  $('#uretim_unit_id').val(),
                        }
                        $.post(baseurl + 'uretim/update_save',data,(response) => {
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

    $(document).on('change','#product_id',function(){

        let product_id = $(this).val();
        let warehouse = $("#warehouse").val();
        let varyasyon_durum=false;
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
                $.post(baseurl + 'uretim/get_product_to_value',data,(response) => {
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
                        else {


                        }
                        $('#product_id_edit').val(product_id);
                        uretim_table_product_id_ar.push({product_id : product_id,product_options:option_details });
                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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
                    tip: 1,
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

</script>





