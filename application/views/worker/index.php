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
                                        <table class="table datatable-show-all" id="personel" width="100%">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>No</td>
                                                <td>Foto</td>
                                                <td>Fehle Adı</td>
                                                <td>Telefon</td>
                                                <td>Fin Kodu</td>
                                                <td>Seri No</td>
                                                <td>Rayon</td>
                                                <td>Meslek</td>
                                                <td>Sorumlu Olduğu Personel</td>
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


    $(document).ready(function(){
        $("input[type='search']").wrap("<form>");
        $("input[type='search']").closest("form").attr("autocomplete","off");
    });


    function draw_data() {
        $('#personel').DataTable({
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
                'url': "<?php echo site_url('worker/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                }
            },
            'columnDefs': [
                {
                    'targets': [0,5,6],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-user-plus"></i> Yeni Fehle Kartı Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Fehle Kartı Əlavə Edin ',
                            icon: 'fa fa-user-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,

                            content:`<form>
                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                      <label for="name">Ad Soyad</label>
                                       <input type='text' class='form-control zorunlu_text' id='name'>
                                    </div>

                                    <div class="form-group col-md-1">
                                      <label for="name">Fin Kodu</label>
                                       <input type='text' class='form-control zorunlu_text' id='fin_no'>
                                    </div>
                                    <div class="form-group col-md-1">
                                      <label for="name">Seri No</label>
                                       <input type='text' class='form-control zorunlu_text' id='seri_no'>
                                    </div>
                                     <div class="form-group col-md-2">
                                      <label for="name">Telefon</label>
                                       <input type='number' class='form-control zorunlu_text' id='phone'>
                                    </div>

                                      <div class="form-group col-md-4">
                                      <label for="name">Açık Adres</label>
                                       <input type='text' class='form-control zorunlu_text' id='address'>
                                    </div>
                                </div>
                                <div class="form-row">
                                 <div class="form-group col-md-3">
                                      <label for="name">Vatandaşlık</label>
                                       <select name="vatandaslik" class="form-control select-box zorunlu" id="vatandaslik">
                                           <?php foreach (vatandaslik() as $vat) {?>
                                               <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                         <div class="form-group col-md-3">
                                          <label for="name">Rayon</label>
                                           <input type='text' class='form-control zorunlu_text' id='city'>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="name">Şeher</label>
                                           <input type='text' class='form-control zorunlu_text' id='region'>
                                        </div>
                                         <div class="form-group col-md-3">
                                          <label for="name">Ülke</label>
                                           <input type='text' class='form-control zorunlu_text' id='country'>
                                        </div>
                                    </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                      <label for="name">Sorumlu Personel</label>
                                       <select name="roleid" class="form-control select-box zorunlu" id="sorumlu_pers_id">
                                           <?php foreach (all_personel() as $rol){
                                                            ?>
                                         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                          <div class="form-group col-md-3">
                                      <label for="name">Meslek</label>
                                      <input type='text' class='form-control zorunlu_text' id='job'>
                                    </div>
                                    <div class="form-group col-md-3">
                                      <label for="name">Günlük Maaş</label>
                                      <input type='number' class='form-control' id='salary_day' value='0'>
                                    </div>
                                    <div class="form-group col-md-2">
                                      <label for="name">Sifarişçi Firma</label>
                                       <select name="loc_id" class="form-control select-box zorunlu" id="loc_id">
                                          <?php foreach (firmalar() as $type){
                                                            echo ' <option value="' . $type->id . '"> ' . $type->cname . '</option>';
                                                        }
                                                        ?>
                                     </select>
                                    </div>
                                    </div>
                                </form>`,
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

                                        let data = {
                                            crsf_token: crsf_hash,
                                            salary_day:  $('#salary_day').val(),
                                            loc_id:  $('#loc_id').val(),
                                            sorumlu_pers_id:  $('#sorumlu_pers_id').val(),
                                            vatandaslik:  $('#vatandaslik').val(),
                                            seri_no:  $('#seri_no').val(),
                                            country:  $('#country').val(),
                                            region:  $('#region').val(),
                                            city:  $('#city').val(),
                                            address:  $('#address').val(),
                                            phone:  $('#phone').val(),
                                            name:  $('#name').val(),
                                            fin_no:  $('#fin_no').val(),
                                            job:  $('#job').val(),
                                        }
                                        $.post(baseurl + 'worker/create_save',data,(response) => {
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
                                                                $('#personel').DataTable().destroy();
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
                    text: '<i class="fa fa-building"></i> Fehle Çalıştır',
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


                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Çalışan Fehle Giriş Ekranı',
                            icon: 'fa fa-user-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,

                            content:function () {
                                let self = this;
                                let html='';

                                let personel_id = [];
                                $('.one_select:checked').each((index,item) => {
                                    personel_id.push($(item).attr('pers_id'));
                                });
                                let data = {
                                    id: personel_id,
                                }
                                $.post(baseurl + 'worker/personel_get_all',data,(response) => {

                                    let responses = jQuery.parseJSON(response);

                                    html=`<table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Fehle Adı</th>
                                                <th>Ödeme Tipi</th>
                                                <th>Tip (Gün / Saat)</th>
                                                <th>Miktar</th>
                                                <th>Birim</th>
                                                <th>Birim Fiyatı</th>
                                                <th>Proje</th>
                                                <th>İşe Başladığı Gün</th>
                                                <th>Giriş Saati</th>
                                                <th>Açıklama</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                                    $.each(responses.items, function (index, item) {
                                        html+=`
                                            <tr>
                                                <td>`+item.name+`</td>
                                                <td><select class="form-control odeme_tipi"">
                                            <option value="1">Nakit</option>
                                        </select></td>
                                                <td><select class="form-control tip" key='`+index+`'>
                                            <option value="1">Günlük</option>
                                            <option value="2">Saatlik</option>
                                        </select></td>
                                                <td> <input type='number' class='form-control miktar' disabled='disabled' value="1"></td>
                                                <td> <select class="form-control select-box birim">
                                       <?php foreach (units() as $blm)
                                        {
                                            $id=$blm['id'];
                                            $name=$blm['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                         </select></td>
                                                <td> <input type='number' class='form-control zorunlu_text birim_fiyati' value='`+item.salary_day+`'></td>
                                                <td><select class="form-control select-box proje_id">
                                                <?php foreach (all_projects() as $acc) {
                                            echo "<option value='$acc->id'>$acc->code</option>";
                                        } ?>
                                            </select></td>
                                                <td> <input type='date' class='form-control zorunlu_text calisma_gunu'></td>
                                                <td> <input type='time' class='form-control zorunlu_text giris_saati'></td>
                                                <td> <input type='text' class='form-control zorunlu_text aciklama'></td>
                                                <input type='hidden' class='pers_id' value='`+item.id+`'>
                                            </tr>

                                            `;
                                            })
                                            html+=`
                                        </tbody>
                                    </table>`;


                                    self.$content.find('#person-list').empty().append(html);

                                });
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


                                        let product_details=[];
                                        let count = $('.pers_id').length;
                                        for (let i=0; i<count; i++) {
                                            product_details.push({
                                                'pers_id':$('.pers_id').eq(i).val(),
                                                'birim_fiyati':$('.birim_fiyati').eq(i).val(),
                                                'miktar':$('.miktar').eq(i).val(),
                                                'birim':$('.birim').eq(i).val(),
                                                'tip':$('.tip').eq(i).val(),
                                                'proje_id':$('.proje_id').eq(i).val(),
                                                'odeme_tipi':$('.odeme_tipi').eq(i).val(),
                                                'aciklama':$('.aciklama').eq(i).val(),
                                                'calisma_gunu':$('.calisma_gunu').eq(i).val(),
                                                'giris_saati':$('.giris_saati').eq(i).val(),
                                            });
                                        }

                                        let data = {
                                            crsf_token: crsf_hash,
                                            product_details:product_details

                                        }
                                        $.post(baseurl + 'worker/create_worker',data,(response) => {
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
    };

    $(document).on('click', '.podradci_button', function() {
        let personel_id = $(this).attr('personel_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Podradçi',
            icon: 'fa fa-users',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function() {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html +=
                    `
                            <div class='mb-3'>
                                <div class="form-row">
                                <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu  Podradçi</label>
                                       <select class="form-control select-box ana_cari">
                                        <option value="0">Bağlı Olduğu Podradci</option>
                                        <?php foreach (all_customer() as $items){
                        $new_title = $items->company;
                        echo "<option value='$items->id'>$new_title</option>";
                    } ?>
                                        </select>
                                    </div>
                                     <div class="form-group col-md-12">
                                       <label>Bağlı Olduğu Alt Podradçi</label>
                                       <select class="form-control select-box parent_id">
                                        <option value="0">Bağlı Olduğu Podradci</option>
                                        <?php foreach (all_list_podradci() as $items){
                        $new_title = parent_podradci_kontrol_list($items->id).$items->company;
                        echo "<option value='$items->id'>$new_title</option>";
                    } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            `;
                let data = {
                    crsf_token: crsf_hash,
                    personel_id: personel_id
                }

                let table_report = '';
                $.post(baseurl + 'personelp/info_personel', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.info_durum){
                        $('.parent_id').val(responses.info.podradci_id).select2().trigger('change')
                    }
                    $('.ana_cari').val(responses.ana_cari).select2().trigger('change')

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            personel_id: personel_id,
                            podradci_id: $('.parent_id').val(),
                            ana_cari: $('.ana_cari').val(),
                        }
                        $.post(baseurl + 'personelp/update_personel', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 200) {
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
                                                $('#personel').DataTable().destroy();
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



    $(document).on('change','#alacakak_borc',function (){
        let id = $(this).val();
        if(id == 34 || id == 52 || id == 70){
            $('.vade_pers').removeClass('d-none');
            if(id == 52 || id == 70){
                $('.account_pers').removeClass('d-none');
            }
            else {
                $('.account_pers').addClass('d-none');
            }
        }
        else {
            $('.vade_pers').addClass('d-none');
        }

        if(id==53){

            $('.cerime_pers').removeClass('d-none');
            $('.account_pers').addClass('d-none');
            $('.account_pers').addClass('d-none');
        }
        else {
            $('.cerime_pers').addClass('d-none');
        }




    })
    $(document).on('change','#method',function (){
        $('#csd').empty()
        let data = {
            crsf_token: crsf_hash,
            method: $(this).val(),
        }
        $.post(baseurl + 'accounts/kasalar',data,(response) => {
            let responses = jQuery.parseJSON(response);
            responses.item.account_list.forEach((item_,index) => {
                $('#csd').append(new Option(item_.holder, item_.id, false, false));
            })
        });
    })


    $(document).on('keyup','#vade',function (){
        let vade_sayisi = $(this).val();
        let tutar = $('#tutar_expense').val();
        if(tutar != 0){
            let aylik_tutar = parseFloat(tutar)/parseFloat(vade_sayisi);
            $('#aylik_tutar').empty().html('Aylık Ödeme Tutarı : '+currencyFormat(aylik_tutar))
        }

    })
    $(document).on('click','.edit',function (){

        let pers_id=$(this).attr('pers_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Fehle Kartı Düzenle ',
            icon: 'fa fa-user-edit',
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
                                   <div class="form-group col-md-4">
                                      <label for="name">Ad Soyad</label>
                                       <input type='text' class='form-control zorunlu_text' id='name'>
                                    </div>

                                    <div class="form-group col-md-1">
                                      <label for="name">Fin Kodu</label>
                                       <input type='text' class='form-control zorunlu_text' id='fin_no'>
                                    </div>
                                    <div class="form-group col-md-1">
                                      <label for="name">Seri No</label>
                                       <input type='text' class='form-control zorunlu_text' id='seri_no'>
                                    </div>
                                     <div class="form-group col-md-2">
                                      <label for="name">Telefon</label>
                                       <input type='number' class='form-control zorunlu_text' id='phone'>
                                    </div>

                                      <div class="form-group col-md-4">
                                      <label for="name">Açık Adres</label>
                                       <input type='text' class='form-control zorunlu_text' id='address'>
                                    </div>
                                </div>
                                <div class="form-row">
                                 <div class="form-group col-md-3">
                                      <label for="name">Vatandaşlık</label>
                                       <select name="vatandaslik" class="form-control select-box zorunlu" id="vatandaslik">
                                           <?php foreach (vatandaslik() as $vat) {?>
                                               <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                         <div class="form-group col-md-3">
                                          <label for="name">Rayon</label>
                                           <input type='text' class='form-control zorunlu_text' id='city'>
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="name">Şeher</label>
                                           <input type='text' class='form-control zorunlu_text' id='region'>
                                        </div>
                                         <div class="form-group col-md-3">
                                          <label for="name">Ülke</label>
                                           <input type='text' class='form-control zorunlu_text' id='country'>
                                        </div>
                                    </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                      <label for="name">Sorumlu Personel</label>
                                       <select name="roleid" class="form-control select-box zorunlu" id="sorumlu_pers_id">
                                           <?php foreach (all_personel() as $rol){
                ?>
                                         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                          <div class="form-group col-md-3">
                                      <label for="name">Meslek</label>
                                      <input type='text' class='form-control zorunlu_text' id='job'>
                                    </div>
                                    <div class="form-group col-md-3">
                                      <label for="name">Günlük Maaş</label>
                                      <input type='number' class='form-control' id='salary_day' value='0'>
                                    </div>
                                    <div class="form-group col-md-2">
                                      <label for="name">Sifarişçi Firma</label>
                                       <select name="loc_id" class="form-control select-box zorunlu" id="loc_id">
                                          <?php foreach (firmalar() as $type){
                    echo ' <option value="' . $type->id . '"> ' . $type->cname . '</option>';
                }
                ?>
                                     </select>
                                    </div>
                                    </div>
                                </form>`;
                let data = {
                    id: pers_id,
                }

                $.post(baseurl + 'worker/info',data,(response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.items.name);


                    $('#fin_no').val(responses.items.fin_no);
                    $('#seri_no').val(responses.items.seri_no);
                    $('#phone').val(responses.items.phone);
                    $('#address').val(responses.items.address);
                    $('#city').val(responses.items.city);
                    $('#region').val(responses.items.region);
                    $('#country').val(responses.items.country);
                    $('#job').val(responses.items.job);

                    $('#vatandaslik').val(responses.items.vatandaslik).select2().trigger('change');
                    $('#cinsiyet').val(responses.items.cinsiyet).select2().trigger('change');
                    $('#sorumlu_pers_id').val(responses.items.sorumlu_pers_id).select2().trigger('change');
                    $('#loc_id').val(responses.items.loc_id).select2().trigger('change');
                    $('#salary_day').val(responses.items.salary_day);

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        // let name_say = $('.zorunlu_text').length;
                        // let req = 0 ;
                        // for (let i = 0; i < name_say;i++){
                        //     let name = $('.zorunlu_text').eq(i).val();
                        //     if(!(name)){
                        //         req++;
                        //     }
                        // }
                        // if(req > 0){
                        //     $.alert({
                        //         theme: 'material',
                        //         icon: 'fa fa-exclamation',
                        //         type: 'red',
                        //         animation: 'scale',
                        //         useBootstrap: true,
                        //         columnClass: "col-md-4 mx-auto",
                        //         title: 'Dikkat!',
                        //         content: 'Tüm Alanlar Zorunludur',
                        //         buttons:{
                        //             prev: {
                        //                 text: 'Tamam',
                        //                 btnClass: "btn btn-link text-dark",
                        //             }
                        //         }
                        //     });
                        //     return false;
                        // }

                        let data = {
                            crsf_token: crsf_hash,
                            personel_id: pers_id,
                            salary_day:  $('#salary_day').val(),
                            loc_id:  $('#loc_id').val(),
                            sorumlu_pers_id:  $('#sorumlu_pers_id').val(),
                            vatandaslik:  $('#vatandaslik').val(),
                            seri_no:  $('#seri_no').val(),
                            country:  $('#country').val(),
                            region:  $('#region').val(),
                            city:  $('#city').val(),
                            address:  $('#address').val(),
                            phone:  $('#phone').val(),
                            name:  $('#name').val(),
                            fin_no:  $('#fin_no').val(),
                            job:  $('#job').val(),
                        }
                        $.post(baseurl + 'worker/update',data,(response) => {
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
                                                $('#personel').DataTable().destroy();
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
                    dropdownParent: $(".jconfirm")
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
    $(document).on('click','.disabled_button',function (){

        let pers_id=$(this).attr('pers_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Pasifleştirme ',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'Pasifleştirmek İstediğinizden Emin Misiniz',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            personel_id: pers_id,
                        }
                        $.post(baseurl + 'personelp/disable_user',data,(response) => {
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
                                                $('#personel').DataTable().destroy();
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
                    dropdownParent: $(".jconfirm")
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


    $(document).on('click','.cart_button',function (){

        let pers_id=$(this).attr('pers_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Maaş Kartları ',
            icon: 'fa fa-credit-card',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html=`<div class="content">
                            <div class="row">

                      <table class="table card-list " style="width: 100%">
                        <thead>
                        <tr>
                            <td>Sıra</td>
                            <td>Kart No</td>
                            <td>Son Kullanım Tarihi</td>
                            <td>Durum</td>
                        </tr>
                        </thead>
<tbody></tbody>
                       </table>
                </div>
                </div>
`;
                let data = {
                    pers_id: pers_id,
                }

                $.post(baseurl + 'personelp/cart_list',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    if(responses.status==200){
                        $.each(responses.list, function (index, value) {
                            let say=parseInt(index)+parseInt(1);
                            status='<span class="badge-success badge">Aktif</span>';
                            if(value.status==0){
                                status='<span class="badge-danger badge">Pasif</span>';
                            }
                            $(".card-list>tbody").append(`
                            <tr>
                                <td>`+say+`</td>
                                <td>`+value.number+`</td>
                                <td>`+value.skt_ay+'-'+value.skt_yil+`</td>
                                <td>`+status+`</td>
                            </tr>
                            `);
                        });
                        $(".card-list>tbody").append(`
                            <tr>
                                <td colspan="4"><button pers_id='`+pers_id+`' class="btn btn-success add_new_kart"><i class="fa fa-plus"></i> Yeni Kart Ekle</button></td>
                            </tr>
                            `);

                    }
                    else {
                        $(".card-list>tbody").append(`
                            <tr>
                                <td colspan="4"><p>`+responses.messages+`</p><br><button pers_id='`+pers_id+`' class="btn btn-success add_new_kart"><i class="fa fa-plus"></i> Yeni Kart Ekle</button></td>
                            </tr>
                            `);
                    }

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


                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    $(document).on('click','.add_new_kart',function (){
        let pers_id = $(this).attr('pers_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni Kart ',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`
              <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="arac_id">Kart Numarası</label>
                    <input type="number" class="form-control cart_no" placeholder="0000000000000000" maxlength="16" onkeyup="amount_max(this)">
                </div>
                <div class="form-group col-md-12">
                    <label for="arac_id">Son Kullanma (AY)</label>
                    <input type="number" class="form-control skt_ay" placeholder="01" maxlength="2" max="12" onkeyup="amount_max(this)">
                </div>
                <div class="form-group col-md-12">
                    <label for="arac_id">Son Kullanma (YIL)</label>
                    <input type="number" class="form-control skt_yil" placeholder="2023" maxlength="4" onkeyup="amount_max(this)">
                </div>
            </div>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            personel_id: pers_id,
                            skt_yil: $('.skt_yil').val(),
                            skt_ay: $('.skt_ay').val(),
                            cart_no: $('.cart_no').val(),
                        }
                        $.post(baseurl + 'personelp/add_cart',data,(response) => {
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
                                                $('#personel').DataTable().destroy();
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
                    dropdownParent: $(".jconfirm")
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
    $(document).on('click','#salary_show',function (){
        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#salary').attr('type') === "password" ? "text" : "password";
                $('#salary').attr("type", new_type);
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

    $(document).on('click','#bank_salary_show',function (){

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#bank_salary').attr('type') === "password" ? "text" : "password";
                $('#bank_salary').attr("type", new_type);
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

    $(document).on('click','#net_salary_show',function (){

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#net_salary').attr('type') === "password" ? "text" : "password";
                $('#net_salary').attr("type", new_type);
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

    $(document).on('click','#salary_day_show',function (){


        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#salary_day').attr('type') === "password" ? "text" : "password";
                $('#salary_day').attr("type", new_type);
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


    $(document).on('click','.bakiye_show',function (){


        let data_update = {
            crsf_token: crsf_hash,
            id: 58,
        }
        $.post(baseurl + 'personelp/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('.bakiye').attr('type') === "password" ? "text" : "password";
                $('.bakiye').attr("type", new_type);
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

    $(document).on('change','.paralel_firma_id',function (){
        $(".paralel_pers_id option").remove();
        let data = {
            firma_id : $(this).val(),
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'personelp/listpersonelfirma',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status=='200'){
                let options='';
                responses.list.forEach((item_,j) => {
                    let newOption = new Option(item_.name, item_.id, false, false);
                    $('.paralel_pers_id').append(newOption).trigger('change');
                })

            }
            else if(responses.status=='410'){
                let newOption = new Option('Seçiniz', 0, false, false);
                $('.paralel_pers_id').append(newOption).trigger('change');
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
        });
    })


    $(document).on('keypress','.mezuniyet',function (event){

        let deger = $(this).val();
        let pers_id = $(this).attr('pers_id');

        if (event.key === "Enter") {
            $('#loading-box').addClass('d-none');
            let data = {
                pers_id: pers_id,
                deger:deger,
            }
            $.post(baseurl + 'personelp/mezuniyet_update',data,(response) => {
                let responses = jQuery.parseJSON(response);

                if(responses.status==200){
                    $('#loading-box').addClass('d-none');
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
                                    $('#personel').DataTable().destroy();
                                    draw_data();
                                }
                            }
                        }
                    });

                }
                else if(responses.status==410){
                    $('#loading-box').addClass('d-none');
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
    })
    function amount_max(element){
        let max = $(element).attr('max');
        let maxlength = $(element).attr('maxlength');

        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
        if(parseInt($(element).val().length) > parseInt(maxlength)){
            let val =$(element).val().slice(0,parseInt(maxlength))
            $(element).val(parseFloat(val))
            return false;
        }
    }

</script>
<style>
    input:focus-visible {
        outline: none;
        border: none;
    }
</style>

