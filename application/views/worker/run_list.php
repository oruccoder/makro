<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Fehle İşlemleri</span></h4>
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
                                        <table class="table datatable-show-all" id="personel_table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>İş Kodu</th>
                                                    <th>Adı</th>
                                                    <th>Proje</th>
                                                    <th>Çalışma Bilgileri</th>
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
<input id="proje_id_hid" value="0" type="hidden">
<script>
    $(document).ready(function () {
        $('.select-box').select2();
        draw_data();

    })

    function draw_data(){
        $('#personel_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'ajax': {
                'url': "<?php echo site_url('worker/ajax_list_aauth')?>",
                'type': 'POST',
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
                    text: '<i class="fa fa-building"></i> Forma 2 Oluştur',
                    action: function ( e, dt, node, config ) {

                        let checked_count = $('.one_select:checked').length;
                        if(checked_count==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir Fehle Seçilmemiş!',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        let proje_id_arr = [];
                        $('.one_select:checked').each((index,item) => {
                            proje_id_arr.push($(item).attr('proje_id'))
                        });
                        let uniq_method = $.grep(proje_id_arr, function(v, k) {
                            return $.inArray(v, proje_id_arr) === k;
                        });



                        let pers_id_arr = [];
                        $('.one_select:checked').each((index,item) => {
                            pers_id_arr.push($(item).attr('pers_id'))
                        });
                        let uniq_method_pers = $.grep(pers_id_arr, function(v, k) {
                            return $.inArray(v, pers_id_arr) === k;
                        });


                        if(uniq_method_pers.length > 1){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Farklı Fehlelere Aynı Forma 2 Seçilemez!',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        if(uniq_method.length > 1){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Farklı Projelerde Çalışanlar Seçilemez!',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        $('#proje_id_hid').val(proje_id_arr[0]);

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Forma 2 Ekranı',
                            icon: 'fa fa-list',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:function () {
                                let self = this;
                                let html=`<form>
                                        <div class="form-row">
                                           <div class="form-group col-md-3">
                                              <label for="name">Proje Bölümü</label>
                                                       <select class="form-control select-box" id="bolum_id" name="bolum_id">
                                                                       <option value="0">Bölüm Seçiniz</option>

                                            </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                              <label for="name">Proje Aşaması</label>
                                              <select class="form-control select-box" id="asama_id" name="asama_id">
                                                                       <option value="0">Önce Bölüm Seçiniz</option>

                                            </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                              <label for="name">Açıklama</label>
                                               <input type='text' class='form-control zorunlu_text' id='aciklama'>
                                            </div>
                                            <div class="form-group col-md-3">
                                              <label for="name">Forma2 Tarihi</label>
                                               <input type='date' class='form-control zorunlu_text' id='forma_2_tarihi'>
                                            </div>
                                        </div>`;

                                let data = {
                                    proje_id: uniq_method,
                                }
                                $.post(baseurl + 'worker/proje_details',data,(response) => {
                                        self.$content.find('#person-list').empty().append(html);
                                        let responses = jQuery.parseJSON(response);
                                        if(responses.bolumler.length)
                                            {
                                                $.each(responses.bolumler, function (index, item) {
                                                    $("#bolum_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                                                });
                                            }
                                            else {
                                                $('#bolum_id').append($('<option>').val(0).text('Aşama BUlunamadı'));
                                            }
                                    s
                                })

                                self.$content.find('#person-list').empty().append(html);
                                return $('#person-container').html();
                            },

                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let name_say = $('.zorunlu_text').length;
                                        let req = 0 ;
                                        for (let i = 0; i < name_say;i++){
                                            let name = $('.zorunlu_text').eq(i).val();
                                            if(!(name)){
                                                req++;
                                            }
                                        }
                                        if(req > 0){
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
                                        $('#loading-box').removeClass('d-none');


                                        let run_details = [];
                                        $('.one_select:checked').each((index,item) => {
                                            run_details.push($(item).attr('run_id'));
                                        });



                                        let data = {
                                            crsf_token: crsf_hash,
                                            run_details:run_details,
                                            pers_id:uniq_method_pers[0],
                                            proje_id:proje_id_arr[0],
                                            bolum_id:$('#bolum_id').val(),
                                            asama_id:$('#asama_id').val(),
                                            aciklama:$('#aciklama').val(),
                                            forma_2_tarihi:$('#forma_2_tarihi').val(),

                                        }
                                        $.post(baseurl + 'worker/create_forma2',data,(response) => {
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
                                $(document).on('change','.tip',function (){
                                    let val = $(this).val();
                                    let key = $(this).attr('key');
                                    if(val==2){
                                        $('.miktar').eq(key).prop('disabled', false);
                                    }
                                    else {
                                        $('.miktar').eq(key).prop('disabled', true);
                                        $('.miktar').eq(key).val(1);

                                    }


                                })

                            }
                        });
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1,3,4,5,6,7,8]
                    }
                }
            ]
        });
    }

    $(document).on('click','.check_out_clock',function (){
        let run_id = $(this).attr('run_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Çıkış Saati Girişi',
            icon: 'fa fa-clock',
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
                                      <label for="name">Çıkış Saati</label>
                                       <input type='time' class='form-control zorunlu_text' id='cikis_saati'>
                                    </div>
                                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let name_say = $('.zorunlu_text').length;
                        let req = 0 ;
                        for (let i = 0; i < name_say;i++){
                            let name = $('.zorunlu_text').eq(i).val();
                            if(!(name)){
                                req++;
                            }
                        }
                        if(req > 0){
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
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            cikis_saati:  $('#cikis_saati').val(),
                            run_id:  run_id
                        }
                        $.post(baseurl + 'worker/update_time_out',data,(response) => {
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
                                                $('#personel_table').DataTable().destroy();
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

    $(document).on('change', "#bolum_id", function (e) {
        $("#asama_id option").remove();
        var bolum_id = $(this).val();
        var proje_id = $('#proje_id_hid').val()
        $.ajax({
            type: "POST",
            url: baseurl + 'worker/asama_list',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                let data_r = jQuery.parseJSON(data)
                if(data_r.asamalar.length)
                {
                    jQuery.each(data_r.asamalar, function (key, item) {
                        $("#asama_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }
                else {
                    $('#asama_id').append($('<option>').val(0).text('Aşama Bulunamadı'));
                }

            }
        });

    });



</script>