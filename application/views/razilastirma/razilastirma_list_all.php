<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bekleyen Razılaştırmalar</span></h4>
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
                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th>Razilaştırma Kodu</th>
                        <th>Proje</th>
                        <th>Cari</th>
                        <th>Ödeme Metodu</th>
                        <th>KDV Oranı</th>
                        <th>Net Toplam</th>
                        <th>KDV Toplam</th>
                        <th>Genel Toplam</th>
                        <th>Onay Durumu</th>
                        <th>Razılaştırma Durumu</th>
                        <th>Forma 2 Oluştur</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    var url = '<?php echo base_url() ?>razilastirma/file_handling';

    $(document).ready(function () {
        draw_data()
    });
    function draw_data() {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('razilastirma/ajax_list_all')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            'columnDefs': [
                {
                    'targets': [10],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: []
        });
    }



    $(document).on('click','.razilastirma_onay',function (){
        let id = $(this).attr('data-object-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'RAZILAŞTIRMA PROTOKOLÜ DURUM BİLDİR',
            icon: 'fa fa-question',
            type: 'orange',
            animation: 'scale',
            columnClass: 'Small',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Açıklama</label></br>' +
                    '<input type="text" placeholder="İnceledim Onayladım" id="desc" class="form-control">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Durum</label></br>' +
                    '<select class="form-control" id="status"><option value="1">Onayla</option><option value="2">İptal Et</option></select>' +
                    '</div>' +
                    '</form>';


                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }

                let table_report='';
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Durum Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        var status = this.$content.find('#status').val();
                        var desc = this.$content.find('#desc').val();
                        if(status==2){
                            if(!desc){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: 'İptal Ettiğiniz Halde Açıklama Girmek Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }
                            else {
                                let placeholder = this.$content.find('#desc').attr('placeholder');
                                let value = this.$content.find('#desc').val();
                                if(value.length == 0){
                                    desc = placeholder;
                                }
                                let data = {
                                    id:id,
                                    desc:desc,
                                    status:status,
                                    crsf_token: crsf_hash,
                                }
                                $.post(baseurl + 'razilastirma/change_status',data,(response)=>{
                                    let responses = jQuery.parseJSON(response);
                                    if(responses.status=='Success'){
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'grey',
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
                                                        $('#loading-box').addClass('d-none');
                                                        $('#invoices').DataTable().destroy();
                                                        draw_data()

                                                    }
                                                }
                                            }
                                        });

                                    }
                                    else if(responses.status=='Error'){

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
                                        $('#loading-box').addClass('d-none');
                                    }
                                });
                            }

                        }

                        $('#loading-box').addClass('d-none');

                        let placeholder = this.$content.find('#desc').attr('placeholder');
                        let value = this.$content.find('#desc').val();
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        let data = {
                            id:id,
                            desc:desc,
                            status:status,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'razilastirma/change_status',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
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
                                                $('#loading-box').addClass('d-none');
                                                $('#invoices').DataTable().destroy();
                                                draw_data()

                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'modenr',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
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
                            $('#loading-box').addClass('d-none');
                        });



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

    $(document).on('click','.razilastirma_forma_2',function(){

        let razilastirma_id = $(this).attr('razilastirma_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Forma 2 Oluştur',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html = `<form id='data_form_iskalemi'>
                    <div class="form-row">
                    <input id='razilastirma_id' name='razilastirma_id' type='hidden'>


                    <div class="form-group col-md-3">
                    <label for="name">Cari Tipi</label>
                    <select name="invoice_type" class="form-control select-box" id="invoice_type" name='invoice_type'>
                        <option value='0'>Seçiniz</option>
                          <?php foreach (forma2_invoice_type() as $type){
                    echo "<option value='$type->id'>$type->description</option>";
                } ?>
                    </select>
            </div>

                    <div class="form-group col-md-6">
                    <label for="name">Cari</label>
                    <select name="cari_id" class="form-control" disabled id="cari_id" name='cari_id'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (all_customer() as $all_cust)
                {
                    echo "<option value='$all_cust->id'>$all_cust->company</option>";
                } ?>
                    </select>
            </div>



                <div class="form-group col-md-3">
                    <label for="name">KDV Durumu</label>
                    <select disabled name="kdv_status" class="form-control select-box kdv_status" id="kdv_status" name='kdv_status'>
                        <option value='no'>KDV HARİÇ</option>
                        <option value='yes'>KDV Dahil</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">KDV Oranı</label>
                    <input type="text" class="form-control tax_oran" id="tax_oran" value="0" disabled name='tax_oran'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Fatura Durumu</label>
                    <select class="form-control select-box" id="invoice_durumu" name='invoice_durumu'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (invoice_durumu_forma2() as $acc)
                {
                    echo "<option value='$acc->id'>$acc->name</option>";
                } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="name">Muqavele No</label>
                    <input type="text" class="form-control nuqavele_no" disabled id="nuqavele_no" name='nuqavele_no'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Forma 2 Tarihi</label>
                    <input type="date" class="form-control fis_date" id="fis_date" name='fis_date'>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">Açıklama</label>
                    <input type="text" class="form-control fis_note" id="fis_note" name='fis_note'>
                </div>

                <hr>
                    <div class='is_razilastirma_table col-md-12'></div>
<table class="table mt-5  is_razilastirma_table_edit" width="100%">
                                    <thead>
                                        <tr>
                                              <th>Görülecek İş</th>
                                              <th>Açıklama</th>
                                                <th>Birim Fiyatı(Kdv Hariç)</th>
                                                <th>Miktarı</th>
                                                 <th>Birim</th>
                                                <th>Toplam Tutar</th>
                                                <th>Sil</th>
                                            </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <tfoot>
                                      </tfoot>


                                 </table>
                </div>
            </form>`;

                let data = {
                    id: razilastirma_id,
                }
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#cari_id').val(responses.details.cari_id).trigger("change");
                    $('#method_id').val(responses.details.odeme_sekli).trigger("change");
                    $('#kdv_status').val(responses.details.tax_statusproduc).trigger("change");
                    $('#tax_oran').val(responses.details.tax_oran);
                    $('#nuqavele_no').val(responses.details.muqavele_no);
                    $('#g_date_edit').val(responses.details.date);
                    $('#description_edit').val(responses.details.description);
                    $('#image_text_is_kalemi').val(responses.details.file);
                    $('#razilastirma_id').val(responses.details.id);

                    let net_tutar = "<span style='font-weight: bold;'  class='net_tutar'>"+currencyFormat(parseFloat(responses.details.net_tutar))+"</span><input type='hidden' class='net_tutar_total_hidden' value='"+responses.details.net_tutar+"'>";
                    let kdv_tutar = "<span style='font-weight: bold;'  class='kdv_tutar'>"+currencyFormat(parseFloat(responses.details.tax_tutar))+"</span><input type='hidden' class='kdv_tutar_total_hidden' value='"+responses.details.tax_tutar+"'>";
                    let genel_tutar = "<span style='font-weight: bold;'  class='genel_tutar'>"+currencyFormat(parseFloat(responses.details.genel_tutar))+"</span><input type='hidden' class='genel_tutar_total_hidden' value='"+responses.details.genel_tutar+"'>";


                    let table_is='';
                    $.each(responses.item_details, function (q, item) {

                        let item_sub=parseFloat(item.qty)*parseFloat(item.price);
                        let quantity="<input onkeyup='item_hesap("+q+")'  eq='"+q+"' type='number' value='"+item.qty+"' class='form-control qty' name='qty[]'>"
                        let price="<input onkeyup='item_hesap("+q+")' eq='"+q+"' type='number' value='"+item.price+"' class='form-control price' name='price[]'>"
                        let toplam_tutar = "<span class='item_toplam_tutar'>"+currencyFormat(parseFloat(item_sub))+"</span><input type='hidden' class='item_toplam_tutar_hidden' value='"+item_sub+"'>";

                        table_is+=` <tr class='tr_clone_`+q+`'>
                                            <td>`+item.name+`</td>
<td><input type='text' class='form-control' name='item_desc[]'></td>
                                            <td>`+price+`</td>
                                            <td>`+quantity+`</td>
                                            <td>`+ item.unit_name+`</td>
                                            <td>`+toplam_tutar+`<input type='hidden' class='item_task_id' name='item_task_id[]' value='`+ item.task_id+`'></td>
                                            <td>
<button type="button" class="btn btn-danger delete_item_razi" ><i class="fa fa-trash"></i></button>
 <button type="button" class="btn btn-info clone" clone_name="tr_clone_`+q+`"><i class="fa fa-plus"></i></button>
</td>
                                            </tr>`;


                    })


                    $(".is_razilastirma_table_edit>tbody").append(table_is);
                    let table_is_tfoot=`<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Net Tutar</td><input type='hidden' name='net_tutar_db' class='net_tutar_db'>
                        <td>`+net_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">KDV Toplam</td><input type='hidden' name='kdv_tutar_db' class='kdv_tutar_db'>
                        <td>`+kdv_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Genel Toplam</td><input type='hidden' name='genel_tutar_db' class='genel_tutar_db'>
                        <td>`+genel_tutar+`</td>

</tr>`;

                    $(".is_razilastirma_table_edit>tfoot").append(table_is_tfoot);


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();

            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {



                        let invoice_type = $('#invoice_type').val();

                        if(parseInt(invoice_type) == 0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Cari Tipi Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        $('#loading-box').removeClass('d-none');

                        $.post(baseurl + 'formainvoices/create_new',$('#data_form_iskalemi').serialize(),(response)=>{
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
                                            text: 'Forma 2 Görüntüle',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.href = '/formainvoices/view?id='+responses.id;
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

                item_hesap(0);

                $('#fileupload_is').fileupload({
                    url: '/razilastirma/file_handling',
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_is_kalemi').val(img);
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

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    function item_hesap(t){
        let say = $('.qty').length;
        let item_price=0;
        let toplam_tutar=0;
        let net_tutar=0;
        let kdv_tutar=0;
        let genel_tutar=0;
        let tax_oran = $('#tax_oran').val();

        for(let eq=0;eq<say;eq++){
            let item_qty= $('.qty').eq(eq).val();
            let item_price= $('.price').eq(eq).val();
            let toplam_tutar = parseFloat(item_price) *parseFloat(item_qty);
            $('.item_toplam_tutar').eq(eq).empty().text(currencyFormat(toplam_tutar))
            $('.item_toplam_tutar_hidden').eq(eq).val(toplam_tutar)






            net_tutar+=parseFloat($('.item_toplam_tutar_hidden').eq(eq).val());


        }

        if(parseInt(tax_oran)){
            genel_tutar= net_tutar* (1+(tax_oran/100));
            kdv_tutar= net_tutar * ((tax_oran/100));
        }
        else {
            genel_tutar=net_tutar;
        }

        $('.net_tutar').empty().text(currencyFormat(net_tutar))
        $('.kdv_tutar').empty().text(currencyFormat(kdv_tutar))
        $('.genel_tutar').empty().text(currencyFormat(genel_tutar))
        $('.net_tutar_db').val(net_tutar);
        $('.kdv_tutar_db').val(kdv_tutar);
        $('.genel_tutar_db').val(genel_tutar);


    }

    $(document).on("click",".forma2_list_view",function(){
        let razilastirma_id = $(this).attr('razilastirma_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgi',
            icon: 'fa fa-exclamation',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+=` <div class="form-row">
                <table id="result_parent" class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Forma 2 No</th>
                      <th scope="col">Cari</th>
                      <th scope="col">Net Tutar</th>
                      <th scope="col">KDV Tutar</th>
                      <th scope="col">Toplam</th>
                      <th scope="col">Görüntüle</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
            </div>
`;

                let data = {
                    crsf_token: crsf_hash,
                    razilastirma_id: razilastirma_id,
                }
                let table_report='';
                $.post(baseurl + 'formainvoices/get_razilastirma',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    let i=1;
                    $.each(responses.items, function (index, item) {
                        $("#result_parent>tbody").append('<tr class="result-row">' +
                            '<td>'+i+'</td> ' +
                            '<td>'+ item.invoice_no +'</td>' +
                            '<td>'+ item.payer +'</td>' +
                            '<td>'+currencyFormat(parseFloat(item.subtotal))+'</td>' +
                            '<td>'+currencyFormat(parseFloat(item.tax))+'</td>' +
                            '<td>'+currencyFormat(parseFloat(item.total))+'</td>' +
                            '<td> <a type="button" href="/formainvoices/view?id='+item.id+'" target="_blank" class="btn btn-info"><i class="fa fa-eye"></i></a></td>' +
                            '</tr>' );
                        i++;
                    });

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
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

    $(document).on('click','.view',function (){
        let id = $(this).attr('data-object-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'RAZILAŞTIRMA PROTOKOLÜ',
            icon: 'fa fa-eye',
            type: 'green',
            animation: 'scale',
            columnClass: 'col-md-12',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<label>Proje</label></br>' +
                    '<b><span id="proje_id"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Ödeme Tipi</label></br>' +
                    '<b><span id="odeme_tipi"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Ödeme Şekli</label></br>' +
                    '<b><span id="odeme_sekli"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Para Birimi</label></br>' +
                    '<b><span id="cur_id"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>KDV Durum</label></br>' +
                    '<b><span id="kdv_durum"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>KDV Oranı</label></br>' +
                    '<b><span id="kdv_oran"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Avans Oranı</label></br>' +
                    '<b><span id="oran"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Muqavele No</label></br>' +
                    '<b><span id="muqavele_no"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Geçerlilik Tarihi</label></br>' +
                    '<b><span id="date"></span></b>' +
                    '</div>' +
                    '<div class="col-md-12">' +
                    '<label>PDF</label></br>' +
                    '<b><span id="pdf"></span></b>' +
                    '</div>' +
                    '<div class="col-md-12 table_rp_view">'+
                    '</div>' +
                    '</div>' +
                    '</div>' +

                    '</form>';


                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }

                let table_report='';
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    $('#proje_id').empty().html(responses.details.proje_name)
                    $('#odeme_tipi').empty().html(responses.details.odeme_tipi_name)
                    $('#odeme_sekli').empty().html(responses.details.odeme_sekli_name)
                    $('#oran').empty().html(responses.details.oran)
                    $('#muqavele_no').empty().html(responses.details.muqavele_no)
                    $('#date').empty().html(responses.details.date)
                    $('#cur_id').empty().html(responses.cur_name)
                    $('#kdv_durum').empty().html(responses.tax_durum)
                    $('#kdv_oran').empty().html(responses.details.tax_oran)
                    $('#pdf').empty().html("<a href='/userfiles/product/"+responses.details.file+"' class='btn btn-info' target='_blank'>PDF GÖRÜNTÜLE</a>")

                    table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Görülecek İş</th>
                                <th>Birim Fiyatı</th>
                                <th>Miktarı</th>
                                <th>Birim</th>
                                <th>Toplam Tutar</th>
                            </tr>
                        </thead><tbody id="todo_tbody">`;

                    responses.item_details.forEach((item_,index) => {
                        let toplam_tutar = parseFloat(item_.price)*item_.qty;
                        table_report+=` <tr>
                                            <td>`+item_.name+`</td>

                                            <td>`+currencyFormat(parseFloat(item_.price))+`</td>
                                            <td>`+item_.qty+`</td>
                                            <td>`+item_.unit_name+`</td>
                                            <td>`+currencyFormat(parseFloat(toplam_tutar))+`</td>
                                            </tr>`;
                    });


                    table_report+=`</tbody></table>`;
                    $('.table_rp_view').empty().html(table_report);


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
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

    $(document).on('click','.razilastirma_onay_detay',function (){
        let id = $(this).attr('data-object-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'RAZILAŞTIRMA ONAY DETAYI',
            icon: 'fa fa-eye',
            type: 'orange',
            animation: 'scale',
            columnClass: 'medium',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_rp">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }

                let table_report='';
                $.post(baseurl + 'razilastirma/onay_details_get',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let responses = jQuery.parseJSON(response);

                    table_report =responses.html;
                    $('.table_rp').empty().html(table_report);
                });


                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
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

    $(document).on('click','.delete_item_razi',function (){
            $(this).parent().parent().remove();
        item_hesap(0);
    })

    $(document).on('click','.clone',function(){
        let name=$(this).attr('clone_name');
        $("."+name).clone().appendTo( ".is_razilastirma_table_edit tbody");
        item_hesap(0);

    })

</script>
