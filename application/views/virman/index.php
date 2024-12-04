<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Virman İşlemleri</span></h4>
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
                                        <table class="table datatable-show-all" id="virman" width="100%">
                                            <thead>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Talap Eden Kasa</td>
                                                    <td>Talap Edilen Kasa</td>
                                                    <td>Tarih</td>
                                                    <td>Açıklama</td>
                                                    <td>İşlem</td>
                                                </tr>
                                            </thead>
                                        </table>

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
<script>
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();



    })


    $(document).on('change','#out_account',function (){
        var deger = $('option:selected',this).attr('doviz');
        $('.giren_hesap_para_birimi').html(deger);
    })


    $(document).on('change','#in_account',function (){
        var deger = $('option:selected',this).attr('doviz');
        $('.cikan_hesap_para_birimi_str').html(deger);

    });

    $(document).on('keyup','#kur_degeri',function (){
        var val =1/$(this).val();
        $('.cevirme_deger').html($(this).val());
        $('.cevirme_deger2').html(val.toFixed(3));


        var carpan=$('.cevirme_deger2').html();
        var deger= $('#out_price').val()*carpan;
        $('#in_price').val(deger.toFixed(2));
        $('#account_in_price').val(deger.toFixed(2));
        $('#account_out_price').val( $('#out_price').val());
    })


    $(document).on('keyup','#out_price',function (){
        var carpan=$('.cevirme_deger2').html();
        var deger=$(this).val()*carpan;
        $('#in_price').val(deger.toFixed(2));
        $('#account_in_price').val(deger.toFixed(2));
        $('#account_out_price').val($(this).val());


    })

    $(document).on('keyup','#in_price',function (){
        var carpan=$('.cevirme_deger').html();
        var deger=$(this).val()*carpan;
        $('#account_out_price').val(deger.toFixed(2));
        $('#out_price').val(deger.toFixed(2));
        $('#account_in_price').val($(this).val());

    })

    function draw_data() {
        $('#virman').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('virman/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                }
            },
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style',data[9]);

            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Talep Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni İstək Əlavə Edin ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Çıkan Kasa</label>
       <select name="out_account" class="form-control select-box zorunlu" id="out_account">
            <option value="0">Seçiniz</option>
            <?php
                            foreach (all_account() as $row) {
                                $cid = $row->id;
                                $acn = $row->acn;
                                $holder = $row->holder;
                                $doviz = para_birimi_ogren_id($row->para_birimi);
                                $balance = amountFormat(new_balace($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                                echo "<option doviz='$doviz' value='$cid'>$acn - $holder</option>";
                            }
                            ?>
        </select>
    </div>
    <div class="form-group col-md-6">
      <label for="name">Giren Kasa</label>
       <select name="in_account" class="form-control select-box zorunlu" id="in_account">
            <option value="0">Seçiniz</option>
            <?php
                            foreach (all_account() as $row) {
                                $cid = $row->id;
                                $acn = $row->acn;
                                $holder = $row->holder;
                                $doviz = para_birimi_ogren_id($row->para_birimi);
                                $balance = amountFormat(new_balace($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                                echo "<option doviz='$doviz' value='$cid'>$acn - $holder</option>";
                            }
                            ?>
        </select>
         <span style="border: none !important;" class="form-control" id="text">1 <t class="cikan_hesap_para_birimi_str">AZN</t> = <t class="cevirme_deger">1</t> <t class="giren_hesap_para_birimi">EURO</t></span>
        <span style="border: none !important;" class="form-control" id="text">1  <t class="giren_hesap_para_birimi">EURO</t>= <t class="cevirme_deger2">1</t> <t class="cikan_hesap_para_birimi_str">AZN</t></span>
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-4">
      <label for="bolum_id">Çıkan Tutar</label>
      <input class="form-control zorunlu_text" name="out_price" id="out_price">
    </div>
    <div class="form-group col-md-4">
      <label for="asama_id">Kur</label>
       <input type="text" class="form-control" placeholder="Kur" name="kur_degeri" id="kur_degeri" value="1">
    </div>
     <div class="form-group col-md-4">
      <label for="asama_id">Giren Tutar</label>
            <input class="form-control zorunlu" name="in_price" id="in_price">
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="bolum_id">Hesaba Geçecek Çıkan Tutar</label>
      <input class="form-control zorunlu" name="account_out_price" id="account_out_price">
    </div>
     <div class="form-group col-md-6">
      <label for="asama_id">Hesaba Geçecek Gelen Tutar</label>
            <input class="form-control zorunlu" name="account_in_price" id="account_in_price">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
    </div>
     <div class="form-group col-md-6">
      <label for="marka">Tarih</label>
      <input type="date" class="form-control" id="invoice_date" >
    </div>
</div>
       </div>
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sorğunu Açın',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let out_account = $('#out_account').val();
                                        let in_account = $('#in_account').val();
                                        let out_price = $('#out_price').val();
                                        if(!parseInt(out_account)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat',
                                                content:'Çıkan Kasayı Seçmek Zorunludur',
                                            });
                                            return false;

                                        }
                                        if(!parseInt(in_account)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat',
                                                content:'Giren Kasayı Seçmek Zorunludur',
                                            });
                                            return false;

                                        }
                                        if(!out_price){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat',
                                                content:'Tutar Yazmalısınız',
                                            });
                                            return false;
                                        }

                                        let data = {
                                            crsf_token: crsf_hash,
                                            invoice_date:  $('#invoice_date').val(),
                                            desc:  $('#desc').val(),
                                            account_in_price:  $('#account_in_price').val(),
                                            account_out_price:  $('#account_out_price').val(),
                                            in_price:  $('#in_price').val(),
                                            kur_degeri:  $('#kur_degeri').val(),
                                            out_price:  $('#out_price').val(),
                                            in_account:  $('#in_account').val(),
                                            out_account:  $('#out_account').val(),
                                        }
                                        $.post(baseurl + 'virman/create_save',data,(response) => {
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
                                                                $('#virman').DataTable().destroy();
                                                                draw_data();
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
                                cancel:{
                                    text: 'Vazgeç',
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
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        });
    };

    $(document).on('click','.bildirim_olustur',function (){
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-bell',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Bildirimi Başlatmak Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            talep_id:talep_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'virman/bildirim_olustur',data,(response)=>{
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
                                                $('#virman').DataTable().destroy();
                                                draw_data();
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

    $(document).on('click','.talep_sil',function (){
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Transferi Silmek İstediğinizden Emin Misiniz<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            talep_id:talep_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'virman/delete',data,(response)=>{
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
                                                $('#virman').DataTable().destroy();
                                                draw_data();
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

    $(document).on('click','.edit',function (){
        let id=$(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Transfer İşlemi Düzenle',
            icon: 'fa fa-pen',
            type: 'dark',
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
    <div class="form-group col-md-6">
      <label for="name">Çıkan Kasa</label>
       <select name="out_account" class="form-control select-box zorunlu" id="out_account">
            <option value="0">Seçiniz</option>
            <?php
              foreach (all_account() as $row) {
                  $cid = $row->id;
                  $acn = $row->acn;
                  $holder = $row->holder;
                  $doviz = para_birimi_ogren_id($row->para_birimi);
                  $balance = amountFormat(new_balace($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                  echo "<option doviz='$doviz' value='$cid'>$acn - $holder</option>";
              }
              ?>
        </select>
    </div>
    <div class="form-group col-md-6">
      <label for="name">Giren Kasa</label>
       <select name="in_account" class="form-control select-box zorunlu" id="in_account">
            <option value="0">Seçiniz</option>
            <?php
              foreach (all_account() as $row) {
                  $cid = $row->id;
                  $acn = $row->acn;
                  $holder = $row->holder;
                  $doviz = para_birimi_ogren_id($row->para_birimi);
                  $balance = amountFormat(new_balace($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                  echo "<option doviz='$doviz' value='$cid'>$acn - $holder</option>";
              }
              ?>
        </select>
         <span style="border: none !important;" class="form-control" id="text">1 <t class="cikan_hesap_para_birimi_str">AZN</t> = <t class="cevirme_deger">1</t> <t class="giren_hesap_para_birimi">EURO</t></span>
        <span style="border: none !important;" class="form-control" id="text">1  <t class="giren_hesap_para_birimi">EURO</t>= <t class="cevirme_deger2">1</t> <t class="cikan_hesap_para_birimi_str">AZN</t></span>
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-4">
      <label for="bolum_id">Çıkan Tutar</label>
      <input class="form-control zorunlu" name="out_price" id="out_price">
    </div>
    <div class="form-group col-md-4">
      <label for="asama_id">Kur</label>
       <input type="text" class="form-control" placeholder="Kur" name="kur_degeri" id="kur_degeri" value="1">
    </div>
     <div class="form-group col-md-4">
      <label for="asama_id">Giren Tutar</label>
            <input class="form-control zorunlu" name="in_price" id="in_price">
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="bolum_id">Hesaba Geçecek Çıkan Tutar</label>
      <input class="form-control zorunlu" name="account_out_price" id="account_out_price">
    </div>
     <div class="form-group col-md-6">
      <label for="asama_id">Hesaba Geçecek Gelen Tutar</label>
            <input class="form-control zorunlu" name="account_in_price" id="account_in_price">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
    </div>
     <div class="form-group col-md-6">
      <label for="marka">Tarih</label>
      <input type="date" class="form-control" id="invoice_date" >
    </div>
</div>
       </div>
</form>`;
                let data = {
                    id: id,
                }

                $.post(baseurl + 'virman/info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#invoice_date').val(responses.items.date);
                    $('#desc').val(responses.items.desc);
                    $('#account_in_price').val(responses.items.account_in_price);
                    $('#account_out_price').val(responses.items.account_out_price);
                    $('#in_price').val(responses.items.in_price);
                    $('#kur_degeri').val(responses.items.kur_degeri);
                    $('#out_price').val(responses.items.out_price);
                    $('#in_account').val(responses.items.in_account_id).select2().trigger('change');
                    $('#out_account').val(responses.items.out_account_id).select2().trigger('change');
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Sorğunu Açın',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            id:  id,
                            invoice_date:  $('#invoice_date').val(),
                            desc:  $('#desc').val(),
                            account_in_price:  $('#account_in_price').val(),
                            account_out_price:  $('#account_out_price').val(),
                            in_price:  $('#in_price').val(),
                            kur_degeri:  $('#kur_degeri').val(),
                            out_price:  $('#out_price').val(),
                            in_account:  $('#in_account').val(),
                            out_account:  $('#out_account').val(),
                        }
                        $.post(baseurl + 'virman/update',data,(response) => {
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
                                                $('#virman').DataTable().destroy();
                                                draw_data();
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
                cancel:{
                    text: 'Vazgeç',
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

    $(document).on('click','.view',function (){
        let id=$(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Transfer İşlemi Görüntüle',
            icon: 'fa fa-eye',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html=`<form>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <table class="table virman_onay_list" width="100%">
                        <thead>
                        <tr>
                            <td>Sıra</td>
                            <td>Personel</td>
                            <td>İşlem Görecek Kasa</td>
                            <td>Talep Tutarı</td>
                            <td>Onaylanan Tutar</td>
                            <td>Açıklama</td>
                            <td>Onay Tarihi</td>
                            <td>Durum</td>
                        </tr>
                        </thead>
<tbody></tbody>
                       </table>
                    </div>
                </div>
                </form>`;
                let data = {
                    id: id,
                }

                $.post(baseurl + 'virman/info_onay',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $.each(responses.items_onay, function (index, value) {
                        let kasa_id = value.out_account_id;
                        let talep_price = value.out_price_text;
                        let status='Bekliyor';

                        let onaylanan_price=value.onaylanan_price_out_text;

                        if(value.sort==2){
                            kasa_id = value.in_account_id;
                            talep_price = value.in_price_text;
                            onaylanan_price = value.onaylanan_price_in_text;
                        }
                        if(value.status==1){
                            status='Onaylandı';
                        }
                        else if(value.status==2){
                            status='İptal Edildi';
                        }
                        $(".virman_onay_list>tbody").append(`
                            <tr>
                                <td>`+value.sort+`</td>
                                <td>`+value.user_id+`</td>
                                <td>`+kasa_id+`</td>
                                <td>`+talep_price+`</td>
                                <td>`+onaylanan_price+`</td>
                                <td>`+value.desc+`</td>
                                <td>`+value.update_at+`</td>
                                <td>`+status+`</td>
                            </tr>
                            `);
                    });
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


