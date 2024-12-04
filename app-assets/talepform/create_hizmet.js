$(document).on('click','.bildirim_olustur',function (){
    let talep_id = $('#talep_id').val();
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
                        type:1,
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/form_bildirim_olustur',data,(response)=>{
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

$(document).on('click','.qaime_asamasine_gec',function (){

    let data_update = {
        talep_id:$('#talep_id').val(),
        crsf_token: crsf_hash
    }
    $.post(baseurl + 'hizmet/forma2_kontrol',data_update,(response)=> {
        let responses = jQuery.parseJSON(response);
        if (responses.status == 200) {
            $.alert({
                theme: 'material',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Başarılı!',
                content: responses.message,
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                        action: function () {
                            location.reload();
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
    })
})
$(document).on('click','.bildirim_olustur_satinalma',function (){

    let data_update = {
        talep_id:$('#talep_id').val(),
        crsf_token: crsf_hash,
        type:2
    }
    $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=>{
        let responses = jQuery.parseJSON(response);
        if(responses.status=='Success'){
            $('#loading-box').addClass('d-none');
            let talep_id = $('#talep_id').val();
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
                    '<p>Satın Alma Bildirimi Başlatmak Üzeresiniz Emin Misiniz?<p/>'+
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:talep_id,
                                type:2,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'hizmet/form_bildirim_olustur',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-checkh',
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
                                                    location.reload();
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

})

$(document).on('click','#tehvil_print',function (){
    let checked_count = $('.one_tehvil_products:checked').length;
    if (checked_count == 0) {
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Ürün Seçilmemiş!',
            buttons: {
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
        return false;
    }
    else {
        let tehvil_details=[];
        $('.one_tehvil_products:checked').each((index,item) => {
            tehvil_details.push({
                teslimat_warehouse_id:$(item).attr('teslimat_warehouse_id'),
                product_id:$(item).attr('product_id'),
            })
        });

        $('#loading-box').removeClass('d-none');
        let data = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            tehvil_details: tehvil_details,
        }
        $.post(baseurl + 'hizmet/tehvil_print',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.code==200){
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
                                window.location.href = responses.href;

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
})

$(document).on('click','.form_remove_products',function (){
    let item_id =$(this).attr('item_id');
    let durum =$(this).attr('durum');
    let type = $(this).attr('type_');
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
                        item_id:item_id,
                        type:type,
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/delete_item_form',data,(response)=>{
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
                                content: 'Başarılı Bir Şekilde Silindi Edildi!',
                                buttons:{
                                    formSubmit: {
                                        text: 'Tamam',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            let remove = '#remove'+ item_id
                                            $(remove).remove();
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
                                content: 'Hata Aldınız! Yöneticiye Başvurun',
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


$(document).on('click','.new_file',function (){
    let talep_id =$('#talep_id').val();
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'Yəni Fayl',
        icon: 'fa fa-file',
        type: 'dark',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "small",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content:` <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Fayl</label>
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
</form>`,
        buttons: {
            formSubmit: {
                text: 'Yükle',
                btnClass: 'btn-blue',
                action: function () {
                    $('#loading-box').removeClass('d-none');

                    let data = {
                        crsf_token: crsf_hash,
                        talep_id:  talep_id,
                        image_text:  $('#image_text_update').val(),
                    }
                    $.post(baseurl + 'hizmet/upload_file',data,(response) => {
                        let responses = jQuery.parseJSON(response);
                        $('#loading-box').addClass('d-none');
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
                                            location.reload()
                                        }
                                    }
                                }
                            });

                        }
                        else if(responses.status=='Error'){

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




$(document).on('click','.form_add_cari',function (){
    let eq = $(this).attr('eq');

    let data = {
        cari_id:$('.cari_id').eq(eq).val(),
        item_id:item_id,
        form_id:$('#talep_id').val(),
        crsf_token: crsf_hash,
    }
    $.post(baseurl + 'hizmet/form_cari_list_create',data,(response)=>{
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
                content: responses.message,
                buttons:{
                    formSubmit: {
                        text: 'Tamam',
                        btnClass: 'btn-blue',
                        action: function () {
                            let table=`<tr id="remove_cari`+responses.cari_id+`">
                                                    <td>`+responses.cari_name+`</td>
                                                    <td>`+responses.cari_phone+`</td>
                                                    <td><button type="button" item_id='`+responses.cari_id+`' class="btn btn-danger btn-sm form_remove_cari" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                            $('.table_create_cari tbody').append(table);
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

})

$(document).on('click','.form_remove_cari',function (e){
    let item_id =$(this).attr('item_id');
    let durum =$(this).attr('durum');
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
                        item_id:item_id,
                        talep_id:$('#talep_id').val(),
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/delete_cari_form',data,(response)=>{
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
                                content: 'Başarılı Bir Şekilde Silindi!',
                                buttons:{
                                    formSubmit: {
                                        text: 'Tamam',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            //$('.form_remove_cari').parent().parent().remove();
                                            let remove = '#remove_cari'+ item_id
                                            $(remove).remove();
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
                                content: 'Hata Aldınız! Yöneticiye Başvurun',
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
$(document).on('click','.tahmini_fiyat',function (){
    let item_id = $(this).attr('item_id');
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'Dikkat',
        icon: 'fa fa-money',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "col-md-4 mx-auto",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content:'<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label class="form-label">Fiyat (AZN)</label>'+
            '<input type="number" class="form-control" id="price">'+
            '</form>',
        buttons: {
            formSubmit: {
                text: 'Ekle',
                btnClass: 'btn-blue',
                action: function () {
                    $('#loading-box').removeClass('d-none');
                    let data = {
                        item_id:item_id,
                        talep_id:$('#talep_id').val(),
                        price:$('#price').val(),
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/product_price_details_add',data,(response)=>{
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
                                content: 'Başarılı Bir Şekilde Eklendi!',
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
                                content: 'Hata Aldınız! Yöneticiye Başvurun',
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
$(document).on('click','.form_update',function (){
    let file_id =$(this).attr('file_id');
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'SORĞUNUN Düzenlenmesi',
        icon: 'fa fa-pen',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "col-md-4 mx-auto",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content:'<form action="" class="formName">' +
            '<div class="form-group">' +
            '<p>Güncellemek Üzeresiniz Emin Misiniz?<p/>'+
            '</form>',
        buttons: {
            formSubmit: {
                text: 'Güncelle',
                btnClass: 'btn-blue',
                action: function () {
                    $('#loading-box').removeClass('d-none');
                    let data = {
                        file_id:$('#talep_id').val(),
                        talep_type:$('#talep_type').val(),
                        desc:$('#desc').val(),
                        transfer_status:$('#transfer_status').val(),
                        proje_id:$('#proje_id').val(),
                        asama_id:$('#asama_id').val(),
                        bolum_id:$('#bolum_id').val(),
                        all_users:$('#all_users').val(),
                        gider_durumu:$('#gider_durumu').val(),
                        progress_status_id:$('#progress_status_id').val(),
                        talep_eden_user_id:$('#talep_eden_user_id').val(),
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/update_form',data,(response)=>{
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
                                content: 'Başarılı Bir Şekilde Düzenlendi!',
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
                                content: 'Hata Aldınız! Yöneticiye Başvurun',
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

$(document).on('click','.delete_file',function (){
    let file_id =$(this).attr('file_id');
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
                    let job_id = [];
                    $('.one_select:checked').each((index,item) => {
                        job_id.push($(item).attr('id'));
                    });
                    let data = {
                        file_id:file_id,
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/delete_file',data,(response)=>{
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
                                content: 'Başarılı Bir Şekilde Silindi Edildi!',
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
                                content: 'Hata Aldınız! Yöneticiye Başvurun',
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

$(document).on('click','.yonetim_users',function (){
    let talep_id =$('#talep_id').val();
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'ƏLAQƏLI INSANLAR',
        icon: 'fa fa-users',
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
            html += `<form>
                          <div class="form-row">
                            <div class="form-group col-md-12 add_list">

                            </div>
                        </div>
                    </form>`;

            let data = {
                crsf_token: crsf_hash,
                talep_id: talep_id,
            }

            let table_report='';
            $.post(baseurl + 'hizmet/get_all_users',data,(response) => {
                self.$content.find('#person-list').empty().append(html);
                let responses = jQuery.parseJSON(response);
                responses.users.forEach((item) => {
                    table_report +=`  <div class="form-row"><div class="form-group col-md-12">
                                <label class="form-check-label" for="ekipman_check">
                                    `+item.name+`
                                </label>
                        </div></div>`;
                })
                $('.add_list').empty().html(table_report);


            });
            self.$content.find('#person-list').empty().append(html);
            return $('#person-container').html();
        },
        buttons: {
            cancel: {
                text: 'Kapat',
                btnClass: "btn btn-warning btn-sm close",
            }
        },
        onContentReady: function () {
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


$(document).on('change','.all_select',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_select').prop('checked',true)
    }
    else {
        $('.one_select').prop('checked',false)
    }
})
$(document).on('change','.all_on_odeme_check',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_on_odeme_check').prop('checked',true)
    }
    else {
        $('.one_on_odeme_check').prop('checked',false)
    }
})

$(document).on('change','.all_tehvil_products',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_tehvil_products').prop('checked',true)
    }
    else {
        $('.one_tehvil_products').prop('checked',false)
    }
})

$(document).on('change','.all_sened_cari_list',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_sened_cari_list').prop('checked',true)
    }
    else {
        $('.one_sened_cari_list').prop('checked',false)
    }
});
$(document).on('change','.all_tehvil_cari_list',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_tehvil_cari_list').prop('checked',true)
    }
    else {
        $('.one_tehvil_cari_list').prop('checked',false)
    }
});



$(document).on('change','.all_siparis_onay_checkbox',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_siparis_onay_checkbox').prop('checked',true)
    }
    else {
        $('.one_siparis_onay_checkbox').prop('checked',false)
    }
})

$(document).on('change','.all_select_cari',function (){
    let status = $(this).prop('checked');
    if(status){
        $('.one_select_cari').prop('checked',true)
    }
    else {
        $('.one_select_cari').prop('checked',false)
    }
})


$(document).on('click','.muqaleve_view',function (){
    let eq = $(this).attr('eq');
    let muqavele_id = $('.muqavele').eq(eq).val();
    let file_name = $('option:selected', '.muqavele').eq(eq).attr('file_name');


    if(!parseInt(muqavele_id)){
        $.alert({
            theme: 'material',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Muqavele Seçilmemiştir',
            buttons:{
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
    }
    else {
        window.open(baseurl+"/userfiles/documents/"+file_name, "_blank");
    }
})
$(document).on('click','.razilastirma_view',function (){
    let eq = $(this).attr('eq');
    let muqavele_id = $('.razilastirma').eq(eq).val();
    let file_name = $('option:selected', '.razilastirma').eq(eq).attr('file_name');
    if(!parseInt(muqavele_id)){
        $.alert({
            theme: 'material',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Razılaştırma Seçilmemiştir',
            buttons:{
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
    }
    else {
        window.open(baseurl+"/userfiles/documents/"+file_name, "_blank");
    }
})

$(document).on('click','.tehvil_view',function (){
    let eq = $(this).attr('eq');
    let muqavele_id = $('.tehvil_teslim').eq(eq).val();
    let file_name = $('option:selected', '.tehvil_teslim').eq(eq).attr('file_name');
    if(!parseInt(muqavele_id)){
        $.alert({
            theme: 'material',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Tehvil Teslim Seçilmemiştir',
            buttons:{
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
    }
    else {
        window.open(baseurl+"/userfiles/documents/"+file_name, "_blank");
    }
})
$(document).on('click','#search_button_cari',function (){
    let keyword = $('#search_name_cari').val();
    if(keyword.length < 3){
        $.alert({
            theme: 'material',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'En az 3 Karakter Yazmalısınız',
            buttons:{
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
    }
    else {
        $('#loading-box').removeClass('d-none');
        let data = {
            keyword:keyword,
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'hizmet/search_cari',data,(response)=>{
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
                    content: 'Başarılı Bir Şekilde Cari Bulundu!',
                    buttons:{
                        formSubmit: {
                            text: 'Tamam',
                            btnClass: 'btn-blue',
                            action: function () {
                                let table = '';
                                responses.cari_list.forEach((item,index) => {
                                    let no = parseInt(index)+parseInt(1);
                                    table+=`<tr>
                                                    <td>`+no+`</td>
                                                    <td><input type="hidden" class="cari_id" value="`+item.cari_id+`">`+item.company+`</td>
                                                    <td>`+item.sektor+`</td>
                                                    <td>`+item.email+`</td>
                                                    <td>`+item.phone+`</td>
                                                    <td><button eq='`+index+`' class="btn btn-success btn-sm form_add_cari"><i class='fa fa-plus'></i></button></td>
                                                <tr>`;
                                })
                                $('.table_carilist tbody').empty().html(table);
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
                    content: 'Kriterlere Uygun Cari Bulunamadı!',
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
})

$(document).on('click','.odeme_talep_et',function (){
    let checked_count = $('.one_on_odeme_check:checked').length;
    if (checked_count == 0) {
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Firma Seçilmemiş!',
            buttons: {
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
        return false;
    }
    else {
        let avans_details=[];
        $('.one_on_odeme_check:checked').each((index,item) => {
            avans_details.push({
                talep_form_teklifler_details_id:$(item).attr('talep_form_teklifler_details_id'),
                talep_form_teklifler_id:$(item).attr('talep_form_teklifler_id'),
                cari_id:$(item).attr('cari_id'),
                avans_tutari:$(item).attr('avans_tutari'),
                para_birimi:$(item).attr('para_birimi'),
                toplam_tutar:$(item).attr('toplam_tutar'),
                method_id:$(item).attr('method_id'),
            })
        });

        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:2
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 'Success') {
                $('#loading-box').addClass('d-none');
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Ödeme',
                    icon: 'fa fa-bank',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: 'Güncellemek İstediğinizden Eminmisiniz?',
                    buttons: {
                        formSubmit: {
                            text: 'Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {
                                $('#loading-box').removeClass('d-none');
                                let data = {
                                    talep_id:$('#talep_id').val(),
                                    crsf_token: crsf_hash,
                                    avans_details: avans_details,
                                }
                                $.post(baseurl + 'hizmet/odeme_create',data,(response)=>{
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
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
        })
    }
})

$(document).on('click','.avans_talep_et',function (){
    let checked_count = $('.one_on_odeme_check:checked').length;
    if (checked_count == 0) {
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Firma Seçilmemiş!',
            buttons: {
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
        return false;
    }
    else {
        let avans_details=[];
        let avans_total=0;
        $('.one_on_odeme_check:checked').each((index,item) => {
            let avans_tt=parseFloat($(item).attr('avans_tutari'));
            avans_total+=avans_tt;
            if(avans_tt > 0){
                avans_details.push({
                    talep_form_teklifler_details_id:$(item).attr('talep_form_teklifler_details_id'),
                    talep_form_teklifler_id:$(item).attr('talep_form_teklifler_id'),
                    cari_id:$(item).attr('cari_id'),
                    avans_tutari:$(item).attr('avans_tutari'),
                    para_birimi:$(item).attr('para_birimi'),
                    toplam_tutar:$(item).attr('toplam_tutar'),
                    method_id:$(item).attr('method_id'),
                })
            }

        });


        if(avans_total > 0){
            let data_update = {
                talep_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
                type:2
            }
            $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
                let responses = jQuery.parseJSON(response);
                if (responses.status == 'Success') {
                    $('#loading-box').addClass('d-none');
                    $.confirm({
                        theme: 'modern',
                        closeIcon: false,
                        title: 'Avans',
                        icon: 'fa fa-bank',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: 'Güncellemek İstediğinizden Eminmisiniz?',
                        buttons: {
                            formSubmit: {
                                text: 'Oluştur',
                                btnClass: 'btn-blue',
                                action: function () {
                                    $('#loading-box').removeClass('d-none');
                                    let data = {
                                        talep_id:$('#talep_id').val(),
                                        crsf_token: crsf_hash,
                                        avans_details: avans_details,
                                    }
                                    $.post(baseurl + 'hizmet/avans_create',data,(response)=>{
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
                                text: 'Kapat',
                                btnClass: "btn btn-danger btn-sm",
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
                content: 'Avans Tutarı Belirtilmemiş Sened Aşamasına Geçebilirsiniz!',
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
})

$(document).on('click','.tehvil_al',function () {
    let checked_count = $('.one_tehvil_products:checked').length;
    if (checked_count == 0) {
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Ürün Seçilmemiş!',
            buttons: {
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
        return false;
    }
    else {
        let product_details=[];
        let cari_id_arr = [];
        $('.one_tehvil_products:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            product_details.push({
                product_id:$(item).attr('product_id'),
                talep_form_product_id:$(item).attr('talep_form_product_id'),
                qty:$('.warehouse_item_qty').eq(eq).val(),
            })
            cari_id_arr.push($(item).attr('cari_id'))
        });



        let uniq_method = $.grep(cari_id_arr, function(v, k) {
            return $.inArray(v, cari_id_arr) === k;
        });

        if(uniq_method.length > 1){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Farklı Cariler Seçilemez!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }

        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:4
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 'Success') {
                $('#loading-box').addClass('d-none');
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Forma2',
                    icon: 'fa fa-check',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: `<form id='data_form_iskalemi'>
                    <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Muqavele No</label>
                    <input type="text" class="form-control nuqavele_no zorunlu" id="nuqavele_no" name='nuqavele_no'>
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Forma 2 Tarihi</label>
                    <input type="date" class="form-control fis_date zorunlu" id="fis_date" name='fis_date'>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">Açıklama</label>
                    <input type="text" class="form-control fis_note" id="fis_note" name='fis_note'>
                </div>
                </div>
            </form>`,
                    buttons: {
                        formSubmit: {
                            text: 'Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {


                                let zorunlu = $('.zorunlu').val();
                                if(!isEmpty(zorunlu) ){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Muqavele No Zorunludur',
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

                                let data = {
                                    talep_id:$('#talep_id').val(),
                                    nuqavele_no:$('#nuqavele_no').val(),
                                    fis_date:$('#fis_date').val(),
                                    fis_note:$('#fis_note').val(),
                                    cari_id:parseInt(uniq_method),
                                    crsf_token: crsf_hash,
                                    product_details: product_details,

                                }
                                $.post(baseurl + 'formainvoices/create_new_hizmet',data,(response)=>{
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
                        }
                    },
                    onContentReady: function () {
                        document.getElementById('fis_date').valueAsDate = new Date();
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
        })
    }
});


$(document).on('click','.sened_update',function (){
    let checked_count = $('.one_sened_cari_list:checked').length;
    if(checked_count==0){
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Firma Seçilmemiş!',
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

        let product_details=[];
        $('.one_sened_cari_list:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            product_details.push({
                item_id:$(item).attr('item_id'),
                cari_id:$(item).attr('cari_id'),
                muqavele:$('.muqavele').eq(eq).val(),
                razilastirma:$('.razilastirma').eq(eq).val()
                // tehvil_teslim:$('.tehvil_teslim').eq(eq).val(),
            })
        });


        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:2
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 'Success') {
                $('#loading-box').addClass('d-none');
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Sened',
                    icon: 'fa fa-file',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: 'Güncellemek İstediğinizden Eminmisiniz?',
                    buttons: {
                        formSubmit: {
                            text: 'Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {
                                $('#loading-box').removeClass('d-none');

                                let data = {
                                    talep_id:$('#talep_id').val(),
                                    crsf_token: crsf_hash,
                                    product_details: product_details,
                                }
                                $.post(baseurl + 'hizmet/siparis_senet_update',data,(response)=>{
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
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
        })
    }
})


$(document).on('click','.anbar_asama',function (){

    let data_update = {
        talep_id:$('#talep_id').val(),
        crsf_token: crsf_hash,
        type:2
    }
    $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
        let responses = jQuery.parseJSON(response);
        if (responses.status == 'Success') {
            $('#loading-box').addClass('d-none');
            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Forma2',
                icon: 'fa fa-list',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: 'Güncellemek İstediğinizden Eminmisiniz?',
                buttons: {
                    formSubmit: {
                        text: 'Oluştur',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');

                            let data = {
                                talep_id:$('#talep_id').val(),
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'hizmet/anbar_asama_update',data,(response)=>{
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
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
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
    })
})

$(document).on('click','.tehvil_update',function (){
    let checked_count = $('.one_tehvil_cari_list:checked').length;
    if(checked_count==0){
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Firma Seçilmemiş!',
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

        let product_details=[];
        $('.one_tehvil_cari_list:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            product_details.push({
                item_id:$(item).attr('item_id'),
                cari_id:$(item).attr('cari_id'),
                tehvil_teslim:$('.tehvil_teslim').eq(eq).val(),
            })
        });


        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:4
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 'Success') {
                $('#loading-box').addClass('d-none');
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Sened',
                    icon: 'fa fa-file',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: 'Güncellemek İstediğinizden Eminmisiniz?',
                    buttons: {
                        formSubmit: {
                            text: 'Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {
                                $('#loading-box').removeClass('d-none');

                                let data = {
                                    talep_id:$('#talep_id').val(),
                                    crsf_token: crsf_hash,
                                    product_details: product_details,
                                }
                                $.post(baseurl + 'hizmet/tehvil_senet_update',data,(response)=>{
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
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
        })
    }
})

$(document).on('click','.siparis_onay_iptal_finish',function (){
    let tip=$(this).attr('tip');
    let checked_count = $('.one_siparis_onay_checkbox:checked').length;
    if(tip!=0){
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
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
            let product_details=[];
            $('.one_siparis_onay_checkbox:checked').each((index,item) => {
                let eq = $(item).attr('eq');
                product_details.push({
                    id:$(item).attr('item_id'),
                })
            });

            let data_update = {
                talep_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
                type:3
            }
            $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
                let responses = jQuery.parseJSON(response);
                if (responses.status == 'Success') {
                    let content_mes='';
                    let fa_text='';
                    let type_text='';
                    let title_text='';
                    if(parseInt(tip)==1){
                        fa_text='fa fa-check'
                        type_text='green';
                        title_text='Onay';
                        content_mes='Siparişin Son Durumunu Onaylamak İstediğinizden Emin Misiniz?';
                    }
                    else if(parseInt(tip)==2){
                        fa_text='fa fa-edit'
                        type_text='green';
                        title_text='Düzeliş';
                        content_mes='Siparişin Son Durumunu Düzelişe Göndermek Emin Misiniz?<div><input class="form-control desct" placeholder="Adetler Doğru Değil"></div>';
                    }
                    else if(parseInt(tip)==0){
                        fa_text='fa fa-ban'
                        type_text='red';
                        title_text='İptal';
                        content_mes='Siparişin Son Durumunu İptal Etmek İstediğinizden Emin Misiniz?<div><input class="form-control desct" placeholder="İnceledim İptal Ediyorum"></div>';
                    }
                    $('#loading-box').addClass('d-none');

                    $.confirm({
                        theme: 'modern',
                        closeIcon: false,
                        title: title_text,
                        icon: fa_text,
                        type: type_text,
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: content_mes,
                        buttons: {
                            formSubmit: {

                                text: 'Durum Bildir',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let desct='';
                                    if(parseInt(tip)!=1)
                                    {
                                        desct=$('.desct').val();
                                        if(!desct){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Açıklama Zorunludur',
                                                buttons:{
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
                                        talep_id:$('#talep_id').val(),
                                        crsf_token: crsf_hash,
                                        product_details: product_details,
                                        tip: tip,
                                        desct: desct,
                                    }
                                    $.post(baseurl + 'hizmet/siparis_update',data,(response)=>{
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
                                text: 'Kapat',
                                btnClass: "btn btn-danger btn-sm",
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
            })
        }
    }
    else {
        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:3
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 'Success') {
                let content_mes='';
                let fa_text='';
                let type_text='';
                let title_text='';

                fa_text='fa fa-ban'
                type_text='red';
                title_text='İptal';
                content_mes='Siparişin Son Durumunu İptal Etmek İstediğinizden Emin Misiniz?<div><input class="form-control desct" placeholder="İnceledim İptal Ediyorum"></div>';

                $('#loading-box').addClass('d-none');

                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: title_text,
                    icon: fa_text,
                    type: type_text,
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: content_mes,
                    buttons: {
                        formSubmit: {
                            text: 'Durum Bildir',
                            btnClass: 'btn-blue',
                            action: function () {
                                let desct='';
                                if(parseInt(tip)!=1)
                                {
                                    desct=$('.desct').val();
                                    if(!desct){
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Dikkat!',
                                            content: 'Açıklama Zorunludur',
                                            buttons:{
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
                                    talep_id:$('#talep_id').val(),
                                    crsf_token: crsf_hash,
                                    product_details: [],
                                    tip: tip,
                                    desct: desct,
                                }
                                $.post(baseurl + 'hizmet/siparis_update',data,(response)=>{
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
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
        })
    }
})

$(document).on('click','.avans_onayla',function (){
    let cari_id = $(this).attr('cari_id');
    let talep_form_avans_id = $(this).attr('talep_form_avans_id');
    let tip = $(this).attr('tip');

    let title = 'Avans İptali';
    let icon = 'fa fa-ban';
    let type = 'red';
    let message = 'İptal Etmek İstediğinizden Emin Misiniz? <input type="text" placeholder="İptal Sebebi" class="form-control desc">';
    if(tip==1){
        title = 'Avans Onayı';
        icon = 'fa fa-check';
        type = 'green';
        message = 'Onaylamak İstediğinizden Emin Misiniz?';
    }

    $.confirm({
        theme: 'modern',
        closeIcon: false,
        title: title,
        icon: icon,
        type: type,
        animation: 'scale',
        useBootstrap: true,
        columnClass: "small",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: message,
        buttons: {
            formSubmit: {
                text: 'Güncelle',
                btnClass: 'btn-blue',
                action: function () {
                    let desc='';
                    if(tip==2){
                        desc = $('.desc').val();
                        if(!desc){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'İptal Durumunda Açıklama Zorunludur',
                                buttons:{
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
                        talep_id:$('#talep_id').val(),
                        cari_id:cari_id,
                        desc:desc,
                        crsf_token: crsf_hash,
                        talep_form_avans_id: talep_form_avans_id,
                        tip: tip,
                    }
                    $.post(baseurl + 'hizmet/avans_onay_iptal',data,(response)=>{
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
                text: 'Kapat',
                btnClass: "btn btn-danger btn-sm",
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

$(document).on('click','.odeme_onayla',function (){
    let cari_id = $(this).attr('cari_id');
    let talep_form_avans_id = $(this).attr('talep_form_avans_id');
    let tip = $(this).attr('tip');


    let title = 'Ödeme İptali';
    let icon = 'fa fa-ban';
    let type = 'red';

    if(tip==1){
        title = 'Ödeme Onayı';
        icon = 'fa fa-check';
        type = 'green';
    }

    let muhasebe_id=0;
    $.confirm({
        theme: 'modern',
        closeIcon: false,
        title: title,
        icon: icon,
        type: type,
        animation: 'scale',
        useBootstrap: true,
        columnClass: "small",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: function () {
            let self = this;
            let html = 'İptal Etmek İstediğinizden Emin Misiniz? <input type="text" placeholder="İptal Sebebi" class="form-control desc">';
            if(tip==1){


                html = 'Ödeme Yapacak Personeli Seçiniz <select class="form-control select-box name" name="muhasebe_id" id="muhasebe_id"><option value="0">Seçiniz</option>';
                let data = {
                    crsf_token: crsf_hash,
                }

                $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    responses.item.forEach((item_,index) => {
                        $('#muhasebe_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                    })

                });


            }
            else {
                let html = 'İptal Etmek İstediğinizden Emin Misiniz? <input type="text" placeholder="İptal Sebebi" class="form-control desc">';

            }



            return $('#person-container').html();
        },
        onContentReady:function (){
        },
        buttons: {
            formSubmit: {
                text: 'Güncelle',
                btnClass: 'btn-blue',
                action: function () {
                    let desc='';
                    muhasebe_id = $('#muhasebe_id').val();
                    if(tip==2){
                        muhasebe_id='';
                        desc = $('.desc').val();
                        if(!desc){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'İptal Durumunda Açıklama Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                    }
                    else {
                        if(parseInt(muhasebe_id)==0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Ödeme Yapacak PErsonel Seçilmelidir',
                                buttons:{
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
                        talep_id:$('#talep_id').val(),
                        muhasebe_id:muhasebe_id,
                        cari_id:cari_id,
                        desc:desc,
                        crsf_token: crsf_hash,
                        talep_form_avans_id: talep_form_avans_id,
                        tip: tip,
                    }
                    $.post(baseurl + 'hizmet/odeme_onay_iptal',data,(response)=>{
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
                text: 'Kapat',
                btnClass: "btn btn-danger btn-sm",
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

$(document).on('click','.odeme_yap',function (){
    let cari_id = $(this).attr('cari_id');
    let talep_code = $(this).attr('talep_code');
    let cari_name = $(this).attr('cari_name');
    let proje_id = $(this).attr('proje_id');
    let proje_code = $(this).attr('proje_code');
    let method_name = $(this).attr('method_name');
    let method_id = $(this).attr('method_id');
    let para_birimi_id = $(this).attr('para_birimi_id');
    let para_birimi_name = $(this).attr('para_birimi_name');
    let talep_form_avans_id = $(this).attr('talep_form_avans_id');
    let total = $(this).attr('total');
    let tip = $(this).attr('tip');

    title = 'Ödeme Yap';
    icon = 'fa fa-bank';
    type = 'green';

    let muhasebe_id=0;
    $.confirm({
        theme: 'modern',
        closeIcon: false,
        title: title,
        icon: icon,
        type: type,
        animation: 'scale',
        useBootstrap: true,
        columnClass: "large",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: function () {
            let self = this;
            let html = `
             <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label">Tip</label>
                            <input readonly name="cari_text" class="form-control" id="cari_text" value="Cari">
                            <input name="cari_pers_type" value="1"  type="hidden" id="cari_pers_type">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Proje</label>
                            <input readonly name="proje_text" class="form-control" value="`+proje_code+`" id="proje_text">
                            <input type="hidden"  id="proje_id_pay" name="proje_id" value="`+proje_id+`">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label cst_label">Cari</label>
                            <input readonly name="payer_name" class="form-control" value="`+cari_name+`" id="payer_name">
                            <input type="hidden" name="payer_id"  id="payer_id" value="`+cari_id+`">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Ödeme Türü</label>
                            <select name="pay_type" class="form-control pay_type" id="pay_type">
                              <option value="">Ödeme Türü Seçiniz</option>
                              <option value="4">Ödeme</option>
                              <option value="43">Avans Ödemesi</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Hesap</label>
                            <select class="form-control account_id" name="account_id" id="account_id">
                            <option value="">Seçiniz</option>
                            </select>
                        </div>  
                             
                             <div class="col-sm-6">
                            <label class="form-label">Method</label>
                             <input readonly name="method_text" class="form-control" value="`+method_name+`" id="method_text">
                            <input type="hidden"  id="method_id" name="method_id" value="`+method_id+`">
                        </div>
                     
                        <div class="col-sm-6 ">
                            <label class="form-label">Ödeme Para Birimi</label>
                             <input readonly name="para_birimi_text" class="form-control" value="`+para_birimi_name+`" id="para_birimi_text">
                             <input type="hidden"  id="para_birimi_id" name="para_birimi_id" value="`+para_birimi_id+`">
                        </div>
                        <div class="col-sm-6 ">
                            <label class="form-label">Kur Değeri</label>
                            <input type="text" class="form-control" placeholder="Kur"
                                   name="kur_degeri" id="kur_degeri" value="1">
                        </div>
                        <div class="col-sm-6 ">
                            <label class="form-label">Toplam</label>
                            <input type="number" placeholder="Tutar"  value="`+total+`" class="form-control margin-bottom amount" max="`+total+`"  name="amount" onkeyup="amount_max(this)" id="amount">
                        </div>
                        <div class="col-sm-6 ">
                            <label class="form-label">Açıklama</label>
                            <input type="text" placeholder="Note"
                                   class="form-control" name="note" value="`+talep_code+' İstinaden Ödeme'+`" id="notes">
                        </div>
                    </div>`;
            let data = {
                crsf_token: crsf_hash,
            }

            $.post(baseurl + 'hizmet/accountlist',data,(response) => {
                self.$content.find('#person-list').empty().append(html);
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });

                let responses = jQuery.parseJSON(response);
                responses.account_list.forEach((item_,index) => {
                    $('#account_id').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                })
            });
            return $('#person-container').html();
        },
        onContentReady:function (){
        },
        buttons: {
            formSubmit: {
                text: 'Güncelle',
                btnClass: 'btn-blue',
                action: function () {
                    let account_id = this.$content.find('.account_id').val();
                    if(!account_id){
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: 'Hesap Zorunludur',
                            buttons:{
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                        return false;
                    }

                    let pay_type = this.$content.find('.pay_type').val();
                    if(!pay_type){
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: 'Ödeme Türü',
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

                    let data = {
                        talep_id:$('#talep_id').val(),
                        account_id:$('#account_id').val(),
                        cari_pers_type:$('#cari_pers_type').val(),
                        proje_id_pay:$('#proje_id_pay').val(),
                        pay_type:$('#pay_type').val(),
                        method_id:$('#method_id').val(),
                        para_birimi_id:$('#para_birimi_id').val(),
                        kur_degeri:$('#kur_degeri').val(),
                        notes:$('#notes').val(),
                        amount:$('#amount').val(),
                        cari_id:cari_id,
                        crsf_token: crsf_hash,
                        talep_form_avans_id: talep_form_avans_id,
                        tip: tip,
                    }
                    $.post(baseurl + 'hizmet/transaction_create',data,(response)=>{
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
                text: 'Kapat',
                btnClass: "btn btn-danger btn-sm",
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

$(document).on('click','.avans_price_update',function(){
    let talep_form_teklifler_details_id = $(this).attr('talep_form_teklifler_details_id');
    let avans_tutar = $(this).attr('avans_tutar');
    let cari_id = $(this).attr('cari_id');
    let alt_total_val = $(this).attr('alt_total_val');


    $.confirm({
        theme: 'modern',
        closeIcon: false,
        title: 'Avans Güncelleme',
        icon: 'fa fa-bank',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "small",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: 'Talep Edeceğiniz Avans Miktarını Giriniz?<br><input type="number" onkeyup="amount_max(this)" value="'+avans_tutar+'" max="'+alt_total_val+'" class="form-control avans_tutar">',
        buttons: {
            formSubmit: {
                text: 'Güncelle',
                btnClass: 'btn-blue',
                action: function () {
                    $('#loading-box').removeClass('d-none');

                    let data = {
                        talep_id:$('#talep_id').val(),
                        avans_tutar:$('.avans_tutar').val(),
                        cari_id:cari_id,
                        crsf_token: crsf_hash,
                        talep_form_teklifler_details_id: talep_form_teklifler_details_id,
                    }
                    $.post(baseurl + 'hizmet/avans_update',data,(response)=>{
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
                text: 'Kapat',
                btnClass: "btn btn-danger btn-sm",
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
// $(document).on('click','.qaime_create',function (){
//     let firma_id = [];
//     let lsf_id = [];
//
//     $('.one_qaime_products:checked').each((index,item) => {
//         firma_id.push($(item).attr('teslim_firma_id'))
//     });
//
//     let uniq = $.grep(firma_id, function(v, k) {
//         return $.inArray(v, firma_id) === k;
//     });
//     if(uniq.length > 1){
//         $.alert({
//             theme: 'modern',
//             icon: 'fa fa-exclamation',
//             type: 'red',
//             animation: 'scale',
//             useBootstrap: true,
//             columnClass: "col-md-4 mx-auto",
//             title: 'Dikkat!',
//             content: 'Farklı Firmalar Seçilemez!',
//             buttons:{
//                 prev: {
//                     text: 'Tamam',
//                     btnClass: "btn btn-link text-dark",
//                 }
//             }
//         });
//         return false;
//     }
// })
$(document).on('click','.siparis_onay',function (){
    let checked_count = $('.one_siparis_checkbox:checked').length;
    if(checked_count==0){
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Ürün Seçilmemiş!',
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

        let product_details=[];
        $('.one_siparis_checkbox:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            product_details.push({
                product_id:$(item).attr('product_id'),
                talep_id:$(item).attr('talep_id'),
                teklif_qty:$(item).attr('teklif_qty'),
                unit_id:$(item).attr('unit_id'),
                price:$(item).attr('price'),
                discount:$(item).attr('discount'),
                edv_oran:$(item).attr('edv_oran'),
                edv_type:$(item).attr('edv_type'),
                cemi:$(item).attr('cemi'),
                umumi_cemi:$(item).attr('umumi_cemi'),
                not:$(item).attr('not'),
                para_birimi:$(item).attr('para_birimi'),
                cari_id:$(item).attr('cari_id'),
                warehouse_id:$(item).attr('warehouse_id'),
                onay_list_id:$(item).attr('onay_list_id'),
                talep_form_product_id:$(item).attr('talep_form_product_id'),
                new_item_qty:$('.new_item_qty').eq(eq).val(),
                new_item_price:$('.new_item_price').eq(eq).val(),
                new_item_discount:$('.item_discount').eq(eq).val(),
                new_item_kdv:$('.item_kdv').eq(eq).val(),
                new_item_edv_durum:$('.item_edv_durum').eq(eq).val(),
                item_edvsiz_hidden:$('.item_edvsiz_hidden').eq(eq).val(),
                edv_tutari_hidden:$('.edv_tutari_hidden').eq(eq).val(),
                discount_type:$('.discount_type').eq(eq).val(),
                item_umumi_hidden:$('.item_umumi_hidden').eq(eq).val(),
                item_umumi_cemi_hidden:$('.item_umumi_cemi_hidden').eq(eq).val(),
                item_discount_hidden:$('.item_discount_hidden').eq(eq).val(),
                new_unit_id:$('.new_unit_id').eq(eq).val(),
                new_item_desc:$('.new_item_desc').eq(eq).val(),
            })
        });
        console.log(product_details);

        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:2
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=> {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 'Success') {
                $('#loading-box').addClass('d-none');
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Sipariş',
                    icon: 'fa fa-check',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: 'Siparişin Son Durumunu Onaya Sunmak İstediğinizden Emin Misiniz?',
                    buttons: {
                        formSubmit: {
                            text: 'Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {
                                $('#loading-box').removeClass('d-none');

                                let data = {
                                    talep_id:$('#talep_id').val(),
                                    crsf_token: crsf_hash,
                                    product_details: product_details,
                                }
                                $.post(baseurl + 'hizmet/siparis_create',data,(response)=>{
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
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
        })
    }
})

$(document).on('click','.teklif_olustur',function (){
    let file_id =$(this).attr('file_id');
    let checked_count = $('.one_select_cari:checked').length;
    if(checked_count==0){
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: 'Herhangi Bir Cari Seçilmemiş!',
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

        let data_update = {
            talep_id:$('#talep_id').val(),
            crsf_token: crsf_hash,
            type:2
        }
        $.post(baseurl + 'hizmet/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status=='Success'){
                $('#loading-box').addClass('d-none');
                cari_item_id=[];
                $('.one_select_cari:checked').each((index,item) => {
                    cari_item_id.push($(item).attr('item_id'))
                });
                $.confirm({
                    theme: 'modern',
                    closeIcon: false,
                    title: 'Təklif Forması',
                    icon: 'fa fa-plus',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-12 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: function () {
                        let self = this;
                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                        let responses;
                        html +=`<div class="content-body">
                     <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                 <div class="row">
                                  <div class="col col-xs-12 col-sm-12 col-md-12">
                                     <select class="form-control ihale_suresi">
                                         <option value="">İhale Süresi Seçiniz</option>
                                         <option value="1">1 Saat</option>
                                         <option value="3">3 Saat</option>
                                         <option value="5">5 Saat</option>
                                         <option value="7">7 Saat</option>
                                         <option value="9">9 Saat</option>
                                         <option value="12">12 Saat</option>
                                         <option value="24">1 Gün</option>
                                         <option value="72">3 Gün</option>
                                         <option value="120">5 Gün</option>
                                         <option value="168">7 Gün</option>
                                         <option value="360">15 Gün</option>
                                     </select>
                                    </div>
                                 </div>
                                 <br>
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <div class="jarviswidget">
                                            <header><h4>Təchizatçılar üçün</h4></header>
                                            <div class="borderedccc">
                                                <div class="widget-body">
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                      <table class="table cari_detils_listy">
                                                        <thead>
                                                            <tr>
                                                                <th>Şirket Adı</th>
                                                                <th>Gönderilecek SMS Numaralrı</th>
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
                            </div>
                        </div>
                    </div>`;
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id: talep_id,
                            cari_item_id: cari_item_id,
                        }

                        let table_report='';
                        $.post(baseurl + 'hizmet/get_all_cari_list',data,(response) => {
                            self.$content.find('#person-list').empty().append(html);
                            let responses = jQuery.parseJSON(response);
                            responses.items.forEach((item) => {
                                table_report +=`<tr><td>`+item.cari_name+`</td><td><input type="hidden" class="cari_id" value="`+item.cari_id+`"><input class="form-control input_tag cari_phone" value="`+item.cari_phone+`"></td></tr>`;
                            })
                            $('.cari_detils_listy tbody').empty().html(table_report);


                        });
                        self.$content.find('#person-list').empty().append(html);
                        return $('#person-container').html();
                    },
                    buttons: {
                        formSubmit: {
                            text: 'Təklif Oluştur ve Paylaşmaq Üçün İnsanlara Göndərin',
                            btnClass: 'btn-blue',
                            action: function () {
                                let name = $('.ihale_suresi').val()
                                if(!name){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'İhale Süresi Zorunludur',
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
                                let count = $('.cari_phone').length;
                                let cari_details=[];
                                for (i=0; i<count; i++){
                                    cari_details.push({
                                        'cari_id':$('.cari_id').eq(i).val(),
                                        'cari_phone':$('.cari_phone').eq(i).val(),
                                    })
                                }
                                let data = {
                                    talep_id:talep_id,
                                    crsf_token: crsf_hash,
                                    ihale_suresi: $('.ihale_suresi').val(),
                                    cari_details: cari_details,
                                }
                                $.post(baseurl + 'hizmet/teklif_create',data,(response)=>{
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
                                            content: 'Başarılı Bir Teklif Oluşturuldu!',
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
                                            content: 'Hata Aldınız! Yöneticiye Başvurun',
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
                            text: 'Kapat',
                            btnClass: "btn btn-danger btn-sm",
                        }
                    },
                    onContentReady: function () {
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        })

                        $(".input_tag").tagsinput('items')

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
        })


    }
})


$(document).on('click','.teklif_edit',function (){
    let cari_id = $(this).attr('cari_id');
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'Teklif Detayları',
        icon: 'fa fa-question',
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
                        item_id:item_id,
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'hizmet/delete_item_form',data,(response)=>{
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
                                content: 'Başarılı Bir Şekilde Silindi Edildi!',
                                buttons:{
                                    formSubmit: {
                                        text: 'Tamam',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            if(durum==1){
                                                location.reload();
                                            }
                                            else {
                                                $('.teklif_edit').parent().parent().remove();
                                            }

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
                                content: 'Hata Aldınız! Yöneticiye Başvurun',
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

$(document).on('change','.item_edv_durum',function (){
    let edv_durum  =$(this).val();
    $('.item_edv_durum').val(edv_durum)
    let count = $('.item_qty').length;
    for (let i=0; i<count; i++){
        item_hesap(i)
    }

})
$('.new_item_qty, .new_item_price, .item_discount, .item_kdv').keyup(function (){
    item_hesap($(this).attr('eq'))
})

function item_hesap(eq){
    let discount_type= $('.discount_type').eq(eq).val();
    let item_qty= $('.new_item_qty').eq(eq).val();
    let item_price= $('.new_item_price').eq(eq).val();
    let item_discount= $('.item_discount').eq(eq).val();
    let item_kdv= $('.item_kdv').eq(eq).val();
    let edv_durum = parseInt($('.item_edv_durum').eq(eq).val());

    let item_edvsiz = item_price/(1+(item_kdv/100));
    //let cemi = parseFloat(item_qty)*parseFloat(item_edvsiz);
    let cemi = parseFloat(item_qty)*parseFloat(item_price);

    let edvsiz=0;
    let edv_tutari=0;
    let discount=0;
    let edv_tutari_price=0;
    let item_umumi_cemi = cemi;


    if(item_discount){

        if(discount_type==2){
            discount = cemi * (parseFloat(item_discount)/100);
            item_umumi_cemi = cemi * (100 - parseFloat(item_discount)) / 100
        }
        else {
            item_umumi_cemi = cemi-parseFloat(item_discount)
            discount=parseFloat(item_discount)
        }


    }

    // if(edv_durum){
    //     edv_tutari = item_umumi_cemi* (parseFloat(item_kdv)/100);
    //     edvsiz = cemi-parseFloat(edv_tutari)
    //
    // }
    // else {
    //     edv_tutari = item_umumi_cemi* (parseFloat(item_kdv)/100);
    //     item_umumi_cemi=item_umumi_cemi-parseFloat(edv_tutari);
    //     cemi = cemi-parseFloat(edv_tutari)
    //     edvsiz=cemi;
    // }

    if(edv_durum){

        edv_tutari = item_umumi_cemi *(parseFloat(item_kdv)/100);
        // edv_tutari = item_umumi_cemi * (parseFloat(item_kdv)/100);
        // edvsiz = cemi-parseFloat(edv_tutari)
        //
        // edv_tutari_price = item_price* (parseFloat(item_kdv)/100);

    }
    else {

        edv_tutari = item_umumi_cemi *(parseFloat(item_kdv)/100);

        // edv_tutari = item_umumi_cemi * (parseFloat(item_kdv)/100);
        // item_umumi_cemi=item_umumi_cemi-parseFloat(edv_tutari);
        // cemi = cemi-parseFloat(edv_tutari)
        // edvsiz=cemi;
        //
        // edv_tutari_price = 0;
    }

    edvsiz_item = item_price-edv_tutari_price;


    $('.item_edvsiz_hidden').eq(eq).val(edvsiz.toFixed(2));
    $('.edv_tutari_hidden').eq(eq).val(edv_tutari.toFixed(2));

    $('.item_discount_hidden').eq(eq).val(discount.toFixed(2));

    $('.item_umumi').eq(eq).val(cemi.toFixed(2));
    $('.item_umumi_hidden').eq(eq).val(cemi.toFixed(2));

    $('.item_umumi_cemi').eq(eq).val(item_umumi_cemi.toFixed(2));
    $('.item_umumi_cemi_hidden').eq(eq).val(item_umumi_cemi.toFixed(2));

    total_hesapla();


}

function total_hesapla(){

    let cemi_total = 0;
    let cemi_umumi_total = 0;
    let item_discount_total = 0;
    let item_edvsiz_total = 0;
    let edv_tutari_total = 0;
    let para_birimi=1;
    let count = $('.item_qty').length;
    for (let i=0; i<count; i++){
        cemi_total +=parseFloat($('.item_umumi_cemi_hidden').eq(i).val());
        cemi_umumi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
        item_discount_total +=parseFloat($('.item_discount_hidden').eq(i).val());
        item_edvsiz_total +=parseFloat($('.item_edvsiz_hidden').eq(i).val());
        edv_tutari_total +=parseFloat($('.edv_tutari_hidden').eq(i).val());
        para_birimi  =$('option:selected', '.para_birimi').eq(i).attr('code');
    }






    let teslimat_cemi_hidden=  parseFloat($('.teslimat_cemi_hidden').val());
    let teslimat_edv_total_hidden=  parseFloat($('.teslimat_edv_total_hidden').val());
    let teslimat_total_hidden=  parseFloat($('.teslimat_total_hidden').val());

    item_edvsiz_total=item_edvsiz_total+teslimat_cemi_hidden;
    edv_tutari_total=edv_tutari_total+teslimat_edv_total_hidden;
    cemi_umumi_total=cemi_umumi_total+teslimat_total_hidden;

    $('#alt_sub_total').empty().text(item_edvsiz_total.toFixed(2)+' '+para_birimi)
    $('.alt_sub_total_val').val(item_edvsiz_total.toFixed(2));

    $('#alt_total').empty().text(cemi_umumi_total.toFixed(2)+' '+para_birimi)
    $('.alt_total_val').val(cemi_umumi_total.toFixed(2));

    $('#alt_discount_total').empty().text(item_discount_total.toFixed(2)+' '+para_birimi)
    $('.alt_discount_total_val').val(item_discount_total.toFixed(2));

    $('#alt_edv_total').empty().text(edv_tutari_total.toFixed(2)+' '+para_birimi)
    $('.alt_edv_total_val').val(edv_tutari_total.toFixed(2));
}


function amount_max(obj){

    let max = $(obj).attr('max');
    if(parseFloat($(obj).val())>parseFloat(max)){
        $(obj).val(parseFloat(max))
        return false;
    }
}

$(document).ready(function () {

    let ihale_durum=$('.ihale_durum').val();
    let time_tip = $('#time_tip').val();
    if(parseInt(time_tip)){
        if(parseInt(ihale_durum)==2)
        {
            button="Teklifler Açılmıştır.";
            document.getElementById("ihale_sure_div").innerHTML =button;
        }
        else {
            var countDownDate = new Date($("#ihale_suresi").val()).getTime();

            // Update the count down every 1 second
            var x = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById("ihale_sure_div").innerHTML = days + " Gün " + hours + " Saat "
                    + minutes + " Dakika " + seconds + " Saniye Süresi Kalmıştır  <button class='btn btn-success ihale_open' tip='1'><i class='fa fa-check'></i> İhale Süresini Durdur ve Teklifleri Aç</button>";

                // If the count down is finished, write some text
                if (distance < 0) {
                    button="İhale Süresi Dolmuştur <button class='btn btn-success ihale_open' tip='2'><i class='fa fa-check'></i>Teklifleri Aç</button>";
                    clearInterval(x);
                    document.getElementById("ihale_sure_div").innerHTML =button;
                }
            }, 1000);
        }

    }
    else {
        document.getElementById("ihale_sure_div").innerHTML = "İhale Süresi Oluşturulmamış";
    }


});

$(document).on('click','.ihale_open',function (){
    let tip = $(this).attr('tip'); // Eğer 1 ise sadece yetkililer açabilir ancak eğer 2 ise hem yetkili hemde satınalma personeli acabilir
    $('#loading-box').removeClass('d-none');
    let data = {
        crsf_token: crsf_hash,
        form_id: $('#talep_id').val(),
        tip: tip
    }
    $.post(baseurl + 'hizmet/ihale_open',data,(response)=>{
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
                content: responses.message,
                buttons:{
                    formSubmit: {
                        text: 'Tamam',
                        btnClass: 'btn-blue',
                        action:function (){
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
})

