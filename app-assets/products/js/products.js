
$(document).ready(function() {
    $('.select2').select2();

});
$(document).on('click', '.delete', function() {
    let product_id = $(this).attr('product_id')
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'Dikkat',
        icon: 'fa fa-ban',
        type: 'red',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "col-md-4 mx-auto",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<p>Silmek Üzeresiniz Emin Misiniz?<p/>' +
            '</form>',
        buttons: {
            formSubmit: {
                text: 'sil',
                btnClass: 'btn-blue',
                action: function() {
                    $('#loading-box').removeClass('d-none');
                    let data = {
                        product_id: product_id,
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'urun/delete', data, (response) => {
                        let responses = jQuery.parseJSON(response);
                        if (responses.code == 200) {
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
                                buttons: {
                                    formSubmit: {
                                        text: 'Tamam',
                                        btnClass: 'btn-blue',
                                        action: function() {
                                            $('#product_table').DataTable().destroy();
                                            draw_data();
                                        }
                                    }

                                }
                            });
                        } else {
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
                                buttons: {
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
                btnClass: "btn btn-danger btn-sm",
            }
        },
        onContentReady: function() {
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
$(document).on('click', '.product_onay', function() {
    let product_id = $(this).attr('product_id')
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'Dikkat',
        icon: 'fa fa-check',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "col-md-4 mx-auto",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<p>Onaylamak Üzeresiniz Emin Misiniz?<p/>' +
            '</form>',
        buttons: {
            formSubmit: {
                text: 'sil',
                btnClass: 'btn-blue',
                action: function() {
                    $('#loading-box').removeClass('d-none');
                    let data = {
                        product_id: product_id,
                        crsf_token: crsf_hash,
                    }
                    $.post(baseurl + 'urun/onay', data, (response) => {
                        let responses = jQuery.parseJSON(response);
                        if (responses.code == 200) {
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
                                buttons: {
                                    formSubmit: {
                                        text: 'Tamam',
                                        btnClass: 'btn-blue',
                                        action: function() {
                                            $('#product_table').DataTable().destroy();
                                            draw_data();
                                        }
                                    }

                                }
                            });
                        } else {
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
                                buttons: {
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
                btnClass: "btn btn-danger btn-sm",
            }
        },
        onContentReady: function() {
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


$(document).on('click','.group_button_view',function (){
    let product_id = $(this).attr('product_id');
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
                text: 'Seçili Varyasyonu Sil',
                btnClass: 'btn-blue',
                action: function () {
                    let option_details=[];
                        $('.option-value:checked').each((index,item) => {
                            option_details.push({
                                'stock_code_id':$(item).attr('stock_code_id'),
                            })
                        });

                    let data = {
                        product_id:product_id,
                        option_details:option_details
                    }
                    $.post(baseurl + 'urun/varyant_delete',data,(response)=>{
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
            addproject: {
                text: 'Proje Malzeme Listesine Ekle',
                btnClass: 'btn-blue',
                action: function(){

                    let option_details_news=[];
                    $('.option-value:checked').each((index,item) => {
                        option_details_news.push({
                            'stock_code_id':$(item).attr('stock_code_id'),
                        })
                    });

                    if($('.option-value:checked').length){
                        let talep_durum=0;
                        let proje_id=0;
                        let bolum_id=0;
                        let asama_id=0;
                        $.confirm({
                            theme: 'modern',
                            closeIcon: false,
                            title: 'Proje Bilgileri Giriniz',
                            icon: 'fas fa-questions',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: function () {
                                let self = this;
                                let html = `<div class="form-row">
                                                    <div class="form-group col-md-12">
                                                      <label for="name">Layihə / Proje</label>
                                                      <select class="form-control select-box proje_id proje_id_new required" id="proje_id">
                                                            
                                                            </select>
                                                    </div>
                                                </div>        
                                            <div class="form-row">
                                             <div class="form-group col-md-6">
                                                  <label for="bolum_id">Proje Bölümü</label>
                                                  <select class="form-control select-box bolum_id_new" id="bolum_id">
                                                        <option value="0">Seçiniz</option>
                                                </select>
                                                </div>
                                            <div class="form-group col-md-6">
                                              <label for="asama_id">Proje Aşaması</label>
                                                <select class="form-control select-box asama_id_new" id="asama_id">
                                                   <option value="0">Seçiniz</option>
                                                </select>
                                                </div>
                                                     <div class="form-group col-md-6">
                                                          <label for="asama_id">Miktar</label>
                                                           <input type="number" class="form-control proje_qty">
                                                </div>
                                                       <div class="form-group col-md-6">
                                                          <label for="asama_id">Birim</label>
                                                              <select class="form-control select-box unit_proje required" id="unit_proje">
                                                            
                                                            </select>
                                                </div>
                                            </div>`;
                                let responses;

                                let data = {
                                    crsf_token: crsf_hash,
                                }

                                let table_report='';
                                $.post(baseurl + 'employee/projeler',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);

                                    let responses = jQuery.parseJSON(response);
                                    $('.proje_id_new').append(new Option('Seçiniz', '', false, false));
                                    responses.item.forEach((item_,index) => {
                                        $('.proje_id_new').append(new Option(item_.name, item_.id, false, false));
                                    })

                                    $('.unit_proje').append(new Option('Seçiniz', '', false, false));
                                    responses.units.forEach((item_units,index) => {
                                        $('.unit_proje').append(new Option(item_units.name, item_units.id, false, false));
                                    })
                                });
                                self.$content.find('#person-list').empty().append(html);
                                return $('#person-container').html();
                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Devam',
                                    btnClass: 'btn-blue',
                                    action: function() {


                                        let data_post_news = {
                                            product_id: product_id,
                                            proje_id: $('.proje_id_new').val(),
                                            bolum_id: $('.bolum_id_new').val(),
                                            asama_id: $('.asama_id_new').val(),
                                            proje_qty: $('.proje_qty').val(),
                                            proje_unit: $('.unit_proje').val(),
                                            option_details: option_details_news
                                        }
                                        $.post(baseurl + 'urun/projestoklari_post', data_post_news, (response) => {
                                            $('#loading-box').addClass('d-none');
                                            let data = jQuery.parseJSON(response);
                                            if (data.code == 200) {
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
                                                        }
                                                    }
                                                });

                                            } else if (data.code == 410) {
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
                                    text: 'İptal',
                                    btnClass: "btn btn-danger btn-sm"
                                }
                            },

                            onContentReady: function() {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
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
                            content: 'Ürün Seçilmelidir',
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
            },
            cancel:{
                text: 'Vazgeç',
                btnClass: "btn btn-danger btn-sm",
            },


        },
        onContentReady: function () {
            setTimeout(function(){
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })
            }, 1000);
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




$(document).on('click','.group_button_new',function (){
    let product_id = $(this).attr('product_id');
    let stok_kode = $(this).attr('stok_kode');
    $.confirm({
        theme: 'modern',
        closeIcon: false,
        title: 'Seçenekler',
        icon: 'fa fa-plus',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "col-md-12 mx-auto",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: function() {
            let self = this;
            let html = `<div class="form-group">
                                        </div>
                                        <div>
                                        <label class="control-label">Sistem Kodu</label>
                                        <input type="text" placeholder="Sistem Kodu" value="`+stok_kode+`" class="form-control sistem_code">
</div>
</br>
</br>
                                       <div class="add_table"></div>


                                </div>
                `;

            let data = {
                crsf_token: crsf_hash,
                product_id: product_id
            }

            let table_report='';
            $.post(baseurl + 'productoption/info_options_new',data,(response) => {
                self.$content.find('#person-list').empty().append(html);
                let responses = jQuery.parseJSON(response);
                if(responses.code==200){
                    $('.add_table').empty().append(responses.details);

                }



            });
            self.$content.find('#person-list').empty().append(html);
            return $('#person-container').html();
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
        },
        buttons: {
            formSubmit: {
                text: 'Gondər',
                btnClass: 'btn-blue',
                action: function() {

                    var name = this.$content.find('.sistem_code').val();
                    if (!name) {
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: 'Sistem Kodu Zorunludur',
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

                    let option_details=[];
                    $('.option-value:checked').each((index,item) => {
                        option_details.push({
                            'option_id':$(item).attr('data-option-id'),
                            'option_name':$(item).attr('data-option-name'),
                            'option_value_id':$(item).attr('data-value-id'),
                            'option_value_name':$(item).attr('data-option-value-name'),
                        })
                    });

                    let data_post = {
                        crsf_token: crsf_hash,
                        product_id: product_id,
                        sistem_code: $('.sistem_code').val(),
                        option_details: option_details,
                    }

                    $.post(baseurl + 'urun/product_to_option_create_new', data_post, (response) => {
                        $('#loading-box').addClass('d-none');
                        let data = jQuery.parseJSON(response);
                        if (data.code == 200) {
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
                                            table_product_id_ar = [];
                                            $('#product_table').DataTable().destroy();
                                            draw_data();
                                        }
                                    }
                                }
                            });

                        } else if (data.code == 410) {
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
        }
    });
})

$(document).on('click','.group_button',function (){
    let product_id = $(this).attr('product_id');
    $.confirm({
        theme: 'modern',
        icon: 'fa fa-filter',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "large",
        title: 'Seçenekler',
        content: function() {
            let self = this;
            let html = `<div class="form-group">
                                            <button class="btn btn-success" id="new_add_line"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <table class="table" id="option_value_list">
                                            <thead>
                                                <tr>
                                                    <th>Seçenek</th>
                                                    <th>Öncelik</th>
                                                    <th>işlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <td><select class="form-control select-box option"></select></td>
                                            <td><input class="form-control sort"></td>
</tr>
                                            </tbody>
                                        </table>


                                </div>
                `;

            let data = {
                crsf_token: crsf_hash,
                product_id: product_id
            }

            let table_report='';
            $.post(baseurl + 'productoption/info_options',data,(response) => {
                self.$content.find('#person-list').empty().append(html);
                let responses = jQuery.parseJSON(response);
                if(responses.product_options){
                    $('#option_value_list tbody tr').eq(0).remove()
                    $.each(responses.product_options, function(index, item_) {
                        $('#option_value_list tbody').append(`<tr>
                                <td><select class="form-control select-box option"></select></td>
                                 <td><input class="form-control sort"></td>
                                <td><button class="btn btn-danger delete_line" item_id="`+item_.id+`"><i class="fa fa-trash"></i></button></td>
                        </tr>`);

                        $.each(responses.details, function(index_, item_value) {
                            $('.option').eq(index).append(new Option(item_value.name, item_value.id, false, false));
                        });

                        $('.option').eq(index).val(item_.option_id).trigger('change')
                        $('.sort').eq(index).val(item_.sort)


                    });




                }
                else {
                    $('.option').append(new Option('Seçiniz', '', false, false));
                    $.each(responses.details, function(index, item_) {
                        $('.option').append(new Option(item_.name, item_.id, false, false));
                    });
                }


            });
            self.$content.find('#person-list').empty().append(html);
            return $('#person-container').html();
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
        },
        buttons: {
            formSubmit: {
                text: 'Gondər',
                btnClass: 'btn-blue',
                action: function() {
                    $('#loading-box').removeClass('d-none');
                    let option_details = [];
                    let count = $('.option').length;
                    for (let i  = 0; i<count; i++ ){
                        option_details.push({
                           'option_id': $('.option').eq(i).val(),
                           'sort': $('.sort').eq(i).val(),
                        });
                    }

                    let data_post = {
                        crsf_token: crsf_hash,
                        product_id: product_id,
                        option_details: option_details,
                    }

                    $.post(baseurl + 'urun/product_to_option_create', data_post, (response) => {
                        $('#loading-box').addClass('d-none');
                        let data = jQuery.parseJSON(response);
                        if (data.code == 200) {
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
                                            table_product_id_ar = [];
                                            $('#product_table').DataTable().destroy();
                                            draw_data();
                                        }
                                    }
                                }
                            });

                        } else if (data.code == 410) {
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
        }
    });
})

$(document).on('click','#new_add_line',function (){
   let eq =  $('#option_value_list tbody tr').length
    $('#option_value_list tbody').append(`<tr>
        <td><select class="form-control select-box option"></select></td>
        <td><input class="form-control sort"></td>
        <td><button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button></td>
</tr>`);

    let data = {
        crsf_token: crsf_hash
    }
    $.post(baseurl + 'productoption/info_options',data,(response) => {
        let responses = jQuery.parseJSON(response);
        $('.option').eq(eq).append(new Option('Seçiniz', '', false, false));
        $.each(responses.details, function(index, item_) {
            $('.option').eq(eq).append(new Option(item_.name, item_.id, false, false));
        });
    });
    $('.select-box').select2({
        dropdownParent: $(".jconfirm-box-container")
    })

})


$(document).on('click','.delete_line',function (){
    let product_to_options_id =  $(this).attr('item_id');
    $.confirm({
        theme: 'modern',
        closeIcon: true,
        title: 'Varyasyon Sil',
        icon: 'fa fa-trash',
        type: 'dark',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "col-md-3 mx-auto",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: 'Bölümü Silmek İstediğinizden Emin Misiniz?',
        buttons: {
            formSubmit: {
                text: 'Sil',
                btnClass: 'btn-blue',
                action: function () {
                    $('#loading-box').removeClass('d-none');

                    let data = {
                        crsf_token: crsf_hash,
                        product_to_options_id: product_to_options_id,
                    }
                    $.post(baseurl + 'urun/delete_product_to_option',data,(response) => {
                        let responses = jQuery.parseJSON(response);
                        $('#loading-box').addClass('d-none');
                        if(responses.code==200){
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
                        else if(responses.code==410){

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
            },
        },
        onContentReady: function () {
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })


        }
    });

})

$(document).on('change','.proje_id_new',function (){
    $(".asama_id_new option").remove();
    $(".bolum_id_new option").remove();
    let proje_id  =$(this).val();
    let data = {
        crsf_token: crsf_hash,
        pid: proje_id,
    }
    $.post(baseurl + 'projects/proje_bolum_ajax',data,(response) => {
        let responses = jQuery.parseJSON(response);
        responses.forEach((item_,index) => {
            $('.bolum_id_new').append(new Option(item_.name, item_.id, false, false)).trigger('change');
        })
        $('.select-box').select2({
            dropdownParent: $(".jconfirm-box-container")
        });

    });

})

$(document).on('change','.bolum_id_new',function (){
    $(".asama_id_new option").remove();
    let bolum_id  =$(this).val();
    let proje_id  =$('.proje_id_new').val();
    let data = {
        crsf_token: crsf_hash,
        bolum_id: bolum_id,
        asama_id: 0,
        proje_id: proje_id,
    }
    $.post(baseurl + 'projects/proje_asamalari_ajax',data,(response) => {
        let responses = jQuery.parseJSON(response);
        responses.forEach((item_,index) => {
            $('.asama_id_new').append(new Option(item_.name, item_.id, false, false)).trigger('change');
        })
        $('.select-box').select2({
            dropdownParent: $(".jconfirm-box-container")
        });

    });

})