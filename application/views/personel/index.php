<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">personel İşlemleri</span></h4>
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
                                                <td>Personel Adı</td>
                                                <td>Pozisyon</td>
                                                <td>Çalıştığı Proje</td>
                                                <td>Tel</td>
                                                <td>Bakiye</td>
                                                <td>Mezuniyet</td>
                                                <td>Kalan Mezuniyet</td>
                                                <td>Toplam Saat</td>
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
                'url': "<?php echo site_url('personel/ajax_list')?>",
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
                    text: '<i class="fa fa-user-plus"></i> Yeni Personel Kartı Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Personel Kartı Əlavə Edin ',
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
       <div class="form-group col-md-2">
          <label for="name">Ad Soyad</label>
           <input type='text' class='form-control zorunlu_text' id='name'>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Medeni Durumu</label>
          <select class='form-control select-box' id='medeni_durumu'>
               <option value="Bekar"><?php echo 'Bekar'; ?> </option>
               <option value="Evli"><?php echo 'Evli'; ?> </option>
           </select>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Fin Kodu</label>
           <input type='text' class='form-control zorunlu_text' id='fin_no'>
        </div>
         <div class="form-group col-md-2">
          <label for="name">Telefon</label>
           <input type='number' class='form-control zorunlu_text' id='phone'>
        </div>
            <div class="form-group col-md-2">
          <label for="name">E-Mail</label>
           <input type='text' class='form-control zorunlu_text' id='email'>
        </div>
            <div class="form-group col-md-2">
          <label for="name">Giriş Şifresi</label>
           <input type='text' class='form-control zorunlu_text' id='password'>
        </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-3">
          <label for="name">Açık Adres</label>
           <input type='text' class='form-control zorunlu_text' id='address'>
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
      <label for="name">Vatandaşlık</label>
       <select name="vatandaslik" class="form-control select-box zorunlu" id="vatandaslik">
           <?php foreach (vatandaslik() as $vat) {?>
               <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name']; ?> </option>
            <?php } ?>
        </select>
    </div>
     <div class="form-group col-md-3">
      <label for="name">Cinsiyet</label>
       <select name="cinsiyet" class="form-control select-box zorunlu" id="cinsiyet">
            <option value="Kadın">Kadın</option>
            <option value="Erkek">Erkek</option>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="name">Pozisyon</label>
       <select name="roleid" class="form-control select-box zorunlu" id="roleid">
           <?php foreach (role_name() as $rol){
            ?>
                 <option value="<?php echo $rol['role_id']; ?>"><?php echo $rol['name']; ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="name">Sorumlu Personel</label>
       <select name="roleid" class="form-control select-box zorunlu" id="sorumlu_pers_id">
           <?php foreach (all_personel() as $rol){
               ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
            <?php } ?>
        </select>
    </div>
    </div>
     <div class="form-row">
        <div class="form-group col-md-3">
          <label for="name">Proje</label>
           <select name="proje_id" class="form-control select-box zorunlu" id="proje_id">
               <?php foreach (all_projects() as $vat) {?>
                   <option value="<?php echo $vat->id; ?>"><?php echo $vat->name; ?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Çalışma Şekli</label>
           <select name="proje_id" class="form-control select-box zorunlu" id="calisma_sekli">
               <?php  foreach (calisma_sekli(1) as $row) {
                    echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                }
                    ?>
            </select>
        </div>
        <div class="form-group col-md-2">
          <label for="name">İşe Başlama Tarihi</label>
          <input type='date' class='form-control zorunlu_text' id='ise_baslangic_tarihi'>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Maaş Tipi</label>
           <select name="salary_type" class="form-control select-box zorunlu" id="salary_type">
              <?php foreach (salary_type() as $type){
                    echo ' <option value="' . $type->id . '"> ' . $type->name . '</option>';
                    }
                ?>
         </select>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Çalıştığı Firma</label>
           <select name="loc_id" class="form-control select-box zorunlu" id="loc_id">
              <?php foreach (firmalar() as $type){
                    echo ' <option value="' . $type->id . '"> ' . $type->cname . '</option>';
                    }
                ?>
         </select>
        </div>
    </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="name">Toplam Maaş</label>
          <input type='number' class='form-control' id='salary' value='0'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Banka Maaş</label>
          <input type='number' class='form-control' id='bank_salary' value='0'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Kelbecer Farkı</label>
          <input type='number' class='form-control' id='net_salary' value='0'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Günlük Maaş</label>
          <input type='number' class='form-control' id='salary_day' value='0'>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Aylık Maas</label>
          <input type='number' class='form-control' id='aylik_maas' value='0'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Paralel Firma</label>
          <select class='form-control paralel_firma_id select-box'>
          <option value='0'>Seçiniz</option>
          <?php
                                foreach (firmalarthisnot() as $items){
                                    echo "<option value='$items->id'>$items->cname</option>";
                                }
                            ?>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Paralel Firma</label>
          <select class='form-control paralel_pers_id select-box'>
          <option value='0'>Firma Seçiniz</option>

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
                                            net_salary:  $('#net_salary').val(),
                                            bank_salary:  $('#bank_salary').val(),
                                            salary:  $('#salary').val(),
                                            salary_type:  $('#salary_type').val(),
                                            loc_id:  $('#loc_id').val(),
                                            ise_baslangic_tarihi:  $('#ise_baslangic_tarihi').val(),
                                            calisma_sekli:  $('#calisma_sekli').val(),
                                            proje_id:  $('#proje_id').val(),
                                            sorumlu_pers_id:  $('#sorumlu_pers_id').val(),
                                            roleid:  $('#roleid').val(),
                                            cinsiyet:  $('#cinsiyet').val(),
                                            vatandaslik:  $('#vatandaslik').val(),
                                            country:  $('#country').val(),
                                            region:  $('#region').val(),
                                            city:  $('#city').val(),
                                            address:  $('#address').val(),
                                            birthday:  $('#birthday').val(),
                                            email:  $('#email').val(),
                                            phone:  $('#phone').val(),
                                            name:  $('#name').val(),
                                            medeni_durumu:  $('#medeni_durumu').val(),
                                            fin_no:  $('#fin_no').val(),
                                            password:  $('#password').val(),
                                            aylik_maas:  $('#aylik_maas').val(),
                                            paralel_pers_id:  $('.paralel_pers_id').val(),
                                            paralel_firma_id:  $('.paralel_firma_id').val(),
                                        }
                                        $.post(baseurl + 'personel/create_save',data,(response) => {
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
                    text: '<i class="fa fa-money-bill"></i> Alacaklandır/Borçlandır',
                    action:function (e,dt,node,config){
                        let html ='<form action="" class="formName">' +
                            '<div class="form-group">' +
                            '<label>Tutar</label>' +
                            '<input class="form-control modal_alacak" id="tutar_expense" name="tutar" type="number">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Açıklama</label>' +
                            '<input class="form-control modal_alacak" id="aciklama_expense" name="aciklama" type="text">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Tip</label>' +
                            '<select class="form-control modal_alacak" name="alacakak_borc" id="alacakak_borc"><option value="0">Seçiniz</option><option value="26">Personel Alacaklandır</option><option value="70">Personel Borç Ödeme(Kasa Girişi Olarak)</option><option value="34">Personel Borçlandır(Kasa Çıkışı Olmadan)</option><option value="52">Personel Borçlandır(Kasa Çıkışı)</option><option value="53">Personel Cərimə</option></select>' +
                            '</div>' +
                            '<div class="form-group" >' +
                            '<label>Ödeme Tipi</label>' +
                            '<select class="form-control modal_alacak" name="method" id="method"><option value="0">Seçiniz</option><option value="1">Nakit</option><option value="3">Banka</option></select>' +
                            '</div>' +
                            '<div class="form-group account_pers d-none" >' +
                            '<label>Kasa</label><br/>' +
                            '<select class="form-control select-box" name="csd" id="csd"></select>' +
                            '</div>' +
                            '<div class="form-group vade_pers d-none" >' +
                            '<label>Vade Sayısı</label>' +
                            '<input class="form-control" id="vade" name="vade" min="1" value="1" type="number"><span class="text-danger" id="aylik_tutar"></span>' +
                            '</div>' +
                            '<div class="form-group">'+`

                            <div class="col-sm-12 cerime_pers d-none">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <table id="files" class="files"></table>
                            <br>
                            <span class="btn btn-success fileinput-button" style="width: 100%">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>İmzalı Dosya...</span>
                            <input id="fileupload" type="file" name="files[]">
                            <input type="hidden" class="image" name="image" id="image">
                            </span>
                            </div>`+
                            `<div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="send-sms-alacak" name="send-sms-alacak" checked>
                                     <label class="form-check-label" for="defaultCheck1">
                                      Sms Gönder
                                        </label>
                                </div>
                            </div>
                            </form>`;
                        let checked_count = $('.one_select:checked').length;
                        if(checked_count==0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir Personel Seçilmemiş!',
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
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Personel Alacak / Borç',
                                icon: 'fa fa-money-bill',
                                type: 'orange',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:html,
                                buttons: {
                                    formSubmit: {
                                        text: 'Oluştur',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            var name = this.$content.find('.modal_alacak').val();
                                            if(!name){
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

                                            let personel_details = [];
                                            $('.one_select:checked').each((index,item) => {
                                                personel_details.push($(item).attr('pers_id'));
                                            })


                                            let data = {
                                                crsf_token: crsf_hash,
                                                tutar_expense : $('#tutar_expense').val(),
                                                aciklama_expense : $('#aciklama_expense').val(),
                                                alacakak_borc : $('#alacakak_borc').val(),
                                                method : $('#method').val(),
                                                send_sms : $('#send-sms-alacak').prop('checked'),
                                                acid : $('#csd').val(),
                                                vade : $('#vade').val(),
                                                image : $('#image').val(),
                                                personel_details :personel_details
                                            }

                                            $.post(baseurl + 'personel/personel_ajax_alacak_borc',data,(response) => {
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
                                    $('#fileupload').fileupload({
                                        url: "transactions/file_handling",
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image').val(img);
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
                    }
                },

                {
                    text: '<i class="fa fa-plus"></i> Prim / Ceza ',
                    action:function (e,dt,node,config){
                        let html ='<form action="" class="formName">' +
                            '<div class="form-group">' +
                            '<label>Tutar</label>' +
                            '<input class="form-control is_ciskis" id="tutar" name="tutar" type="number">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Açıklama</label>' +
                            '<input class="form-control is_ciskis" id="aciklama" name="aciklama" type="text">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Proje</label>' +
                            '<select class="form-control is_ciskis select-box" name="proje_id_modal" id="proje_id_modal">';
                            <?php
                        if(all_projects()){
                        foreach (all_projects() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->code;
                            ?>
                            html+='<option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>';
                            <?php } }?>
                            html+='</select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Tip</label>' +
                            '<select class="form-control is_ciskis" name="type" id="type"><option value="1">Prim</option><option value="2">Ceza</option></select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Prim/Ceza Maaş Ayı</label>' +
                            '<select class="form-control hesaplanan_ay_" name="hesaplanan_ay_" id="hesaplanan_ay_">'+
                            '<option value="">Seçiniz</option>'+
                            '<option value="1">01 - Ocak</option>'+
                            '<option value="2">02 - Şubat</option>'+
                            '<option value="3">03 - Mart</option>'+
                            '<option value="4">04 - Nisan</option>'+
                            '<option value="5">05 - Mayıs</option>'+
                            '<option value="6">06 - Haziran</option>'+
                            '<option value="7">07 - Temmuz</option>'+
                            '<option value="8">08 - Ağustos</option>'+
                            '<option value="9">09 - Eylül</option>'+
                            '<option value="10">10 - Ekim</option>'+
                            '<option value="11">11 - Kasım</option>'+
                            '<option value="12">12 - Aralık</option>'+
                            '</select>' +
                            '</div>' +
                            '<div class="form-group">'+`

                            <div class="col-sm-12">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <table id="files" class="files"></table>
                            <br>
                            <span class="btn btn-success fileinput-button" style="width: 100%">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>İmzalı Dosya...</span>
                            <input id="fileupload_" type="file" name="files[]">
                            <input type="hidden" class="image_text" name="image_text" id="image_text">
                            </span>
                            </div>`+'</form>';

                        let checked_count = $('.one_select:checked').length;
                        if(checked_count==0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir Personel Seçilmemiş!',
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
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Ceza / Prim Talebi',
                                icon: 'fa fa-plus',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content: html,
                                buttons: {
                                    formSubmit: {
                                        text: 'Talep Oluştur',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            var name = this.$content.find('.is_ciskis').val();
                                            var hesaplanan_ay = this.$content.find('.hesaplanan_ay_').val();
                                            var image_text_ = this.$content.find('.image_text').val();
                                            if(!name || !image_text_){
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

                                            if(!hesaplanan_ay){
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: 'Hesaplanacak Maaş Ayını seçmelisiniz',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                                return false;
                                            }



                                            let personel_details = [];
                                            $('.one_select:checked').each((index,item) => {
                                                personel_details.push($(item).attr('pers_id'));
                                            })


                                            let data = {
                                                tutar : $('#tutar').val(),
                                                image_text : $('#image_text').val(),
                                                hesaplanan_ay_ : $('#hesaplanan_ay_').val(),
                                                aciklama : $('#aciklama').val(),
                                                proje_id_modal : $('#proje_id_modal').val(),
                                                type : $('#type').val(),
                                                personel_details :personel_details
                                            }

                                            $.post(baseurl + 'personel/personel_prim_talep',data,(response) => {
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
                                        dropdownParent: $(".jconfirm")
                                    })

                                    $('#fileupload_').fileupload({
                                        url: "transactions/file_handling",
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

                    }
                },
                {
                  text: '<i class="fa fa-ban"></i> İş Çıkışı',
                  action:function (e,dt,node,config){
                      let checked_count = $('.one_select:checked').length;
                      if(checked_count==0){
                          $.alert({
                              theme: 'material',
                              icon: 'fa fa-exclamation',
                              type: 'red',
                              animation: 'scale',
                              useBootstrap: true,
                              columnClass: "col-md-4 mx-auto",
                              title: 'Dikkat!',
                              content: 'Herhangi Bir Personel Seçilmemiş!',
                              buttons:{
                                  prev: {
                                      text: 'Tamam',
                                      btnClass: "btn btn-link text-dark",
                                  }
                              }
                          });
                          return false;
                      }
                      else{
                         let html ='<form action="" class="formName">' +
                              '<div class="form-group">' +
                              '<label>İş Çıkış Tarihi</label>' +
                              '<input class="form-control is_ciskis" id="is_cikis_date" name="is_cikis_date" type="date">' +
                              '</div>' +
                              '<div class="form-group">' +
                              '<label>Hesap Kesim Tarihi</label>' +
                              '<input class="form-control is_ciskis" id="hesap_kesim_date" name="hesap_kesim_date" type="date">' +
                              '</div>' +
                              '<div class="form-group">' +
                              '<label>Ayrılma Sebebi</label>' +
                              '<input class="form-control is_ciskis" id="is_cikis_desc" name="is_cikis_desc name" type="text">' +
                              '</div>' +
                              '</form>';
                          $.confirm({
                              theme: 'modern',
                              closeIcon: true,
                              title: 'İş Çıkış Bildirme',
                              icon: 'fa fa-ban',
                              type: 'red',
                              animation: 'scale',
                              useBootstrap: true,
                              columnClass: "col-md-6 mx-auto",
                              containerFluid: !0,
                              smoothContent: true,
                              draggable: false,
                              content: html,
                              buttons: {
                                  formSubmit: {
                                      text: 'Güncelle',
                                      btnClass: 'btn-blue',
                                      action: function () {
                                          var name = this.$content.find('.is_ciskis').val();
                                          if(!name){
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
                                          let personel_details = [];
                                          $('.one_select:checked').each((index,item) => {
                                              personel_details.push($(item).attr('pers_id'));
                                          })
                                          let data = {
                                              tutar : $('#tutar').val(),
                                              is_cikis_desc : $('#is_cikis_desc').val(),
                                              is_cikis_date : $('#is_cikis_date').val(),
                                              hesap_kesim_date : $('#hesap_kesim_date').val(),
                                              personel_details :personel_details
                                          }

                                          $.post(baseurl + 'personel/personel_is_cikis_update',data,(response) => {
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

                  }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1,3,4,5,6,7,]
                    }
                }
            ]
        });
    };



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
            title: 'Yeni Personel Kartı Düzenle ',
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
       <div class="form-group col-md-3">
          <label for="name">Ad Soyad</label>
           <input type='text' class='form-control zorunlu_text' id='name'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Medeni Durumu</label>
          <select class='form-control select-box' id='medeni_durumu'>
               <option value="Bekar"><?php echo 'Bekar'; ?> </option>
               <option value="Evli"><?php echo 'Evli'; ?> </option>
           </select>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Fin Kodu</label>
           <input type='text' class='form-control zorunlu_text' id='fin_no'>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Telefon</label>
           <input type='number' class='form-control zorunlu_text' id='phone'>
        </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-3">
          <label for="name">Açık Adres</label>
           <input type='text' class='form-control zorunlu_text' id='address'>
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
      <label for="name">Vatandaşlık</label>
       <select name="vatandaslik" class="form-control select-box zorunlu" id="vatandaslik">
           <?php foreach (vatandaslik() as $vat) {?>
               <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name']; ?> </option>
            <?php } ?>
        </select>
    </div>
     <div class="form-group col-md-3">
      <label for="name">Cinsiyet</label>
       <select name="cinsiyet" class="form-control select-box zorunlu" id="cinsiyet">
            <option value="Kadın">Kadın</option>
            <option value="Erkek">Erkek</option>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="name">Pozisyon</label>
       <select name="roleid" class="form-control select-box zorunlu" id="roleid">
           <?php foreach (role_name() as $rol){
                ?>
                 <option value="<?php echo $rol['role_id']; ?>"><?php echo $rol['name']; ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="name">Sorumlu Personel</label>
       <select name="roleid" class="form-control select-box zorunlu" id="sorumlu_pers_id">
           <?php foreach (all_personel() as $rol){
                ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
            <?php } ?>
        </select>
    </div>
    </div>
     <div class="form-row">
        <div class="form-group col-md-3">
          <label for="name">Proje</label>
           <select name="proje_id" class="form-control select-box zorunlu" id="proje_id">
               <?php foreach (all_projects() as $vat) {?>
                   <option value="<?php echo $vat->id; ?>"><?php echo $vat->name; ?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Çalışma Şekli</label>
           <select name="proje_id" class="form-control select-box zorunlu" id="calisma_sekli">
               <?php  foreach (calisma_sekli(1) as $row) {
                    echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group col-md-2">
          <label for="name">İşe Başlama Tarihi</label>
          <input type='date' class='form-control zorunlu_text' id='ise_baslangic_tarihi'>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Maaş Tipi</label>
           <select name="salary_type" class="form-control select-box zorunlu" id="salary_type">
              <?php foreach (salary_type() as $type){
                    echo ' <option value="' . $type->id . '"> ' . $type->name . '</option>';
                }
                ?>
         </select>
        </div>
               <div class="form-group col-md-2">
          <label for="name">Çalıştığı Firma</label>
           <select name="loc_id" class="form-control select-box zorunlu" id="loc_id">
              <?php foreach (firmalar() as $type){
                    echo ' <option value="' . $type->id . '"> ' . $type->cname . '</option>';
                }
                ?>
         </select>
        </div>
    </div>
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="name">Toplam Maaş</label>
          <input type='password' class='form-control' id='salary' value='0'>
          <i class="fa fa-eye-slash" id="salary_show"></i>

        </div>
        <div class="form-group col-md-3">
          <label for="name">Banka Maaş</label>
          <input type='password' class='form-control' id='bank_salary' value='0'>
           <i class="fa fa-eye-slash" id="bank_salary_show"></i>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Kelbecer Farkı</label>
          <input type='password' class='form-control' id='net_salary' value='0'>
          <i class="fa fa-eye-slash" id="net_salary_show"></i>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Günlük Maaş</label>
          <input type='password' class='form-control' id='salary_day' value='0'>
           <i class="fa fa-eye-slash" id="salary_day_show"></i>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Aylık Maas</label>
          <input type='number' class='form-control' id='aylik_maas' value='0'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Paralel Firma</label>
          <select class='form-control paralel_firma_id select-box'>
          <option value='0'>Seçiniz</option>
          <?php
                foreach (firmalarthisnot() as $items){
                    echo "<option value='$items->id'>$items->cname</option>";
                }
                ?>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Paralel Firma</label>
          <select class='form-control paralel_pers_id'>
          <option value='0'>Firma Seçiniz</option>

          </select>
    </div>
</form>`;
                let data = {
                    id: pers_id,
                }

                $.post(baseurl + 'personel/info',data,(response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.items.name);
                    $('#medeni_durumu').val(responses.items.medeni_durumu).select2().trigger('change');

                    $('#fin_no').val(responses.items.fin_no);
                    $('#phone').val(responses.items.phone);
                    $('#address').val(responses.items.address);
                    $('#city').val(responses.items.city);
                    $('#region').val(responses.items.region);
                    $('#country').val(responses.items.country);


                    $('#vatandaslik').val(responses.items.vatandaslik).select2().trigger('change');
                    $('#cinsiyet').val(responses.items.cinsiyet).select2().trigger('change');
                    $('#roleid').val(responses.users_details.roleid).select2().trigger('change');
                    $('#sorumlu_pers_id').val(responses.items.sorumlu_pers_id).select2().trigger('change');
                    $('#proje_id').val(responses.salary_details.proje_id).select2().trigger('change');
                    $('#calisma_sekli').val(responses.items.calisma_sekli).select2().trigger('change');
                    $('#loc_id').val(responses.items.loc).select2().trigger('change');
                    $('#ise_baslangic_tarihi').val(responses.items.ise_baslama_tarihi);

                    $('#salary_type').val(responses.salary_details.salary_type).select2().trigger('change');
                    $('#salary').val(responses.salary_details.salary);
                    $('#bank_salary').val(responses.salary_details.bank_salary);
                    $('#net_salary').val(responses.salary_details.net_salary);
                    $('#salary_day').val(responses.salary_details.salary_day);
                    $('#aylik_maas').val(responses.salary_details.aylik_maas);
                    if(responses.paralel_details){
                        $('.paralel_firma_id').val(responses.paralel_details.paralel_firma_id).select2().trigger('change');

                    }

                    setTimeout(function() {
                        if(responses.paralel_details){

                            $('.paralel_pers_id').val(responses.paralel_details.paralel_pers_id);
                            $('.paralel_pers_id').select2({
                                dropdownParent: $(".jconfirm")
                            })
                        }
                    }, 2000);


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
                            aylik_maas:  $('#aylik_maas').val(),
                            net_salary:  $('#net_salary').val(),
                            bank_salary:  $('#bank_salary').val(),
                            salary:  $('#salary').val(),
                            salary_type:  $('#salary_type').val(),
                            loc_id:  $('#loc_id').val(),
                            ise_baslangic_tarihi:  $('#ise_baslangic_tarihi').val(),
                            calisma_sekli:  $('#calisma_sekli').val(),
                            proje_id:  $('#proje_id').val(),
                            sorumlu_pers_id:  $('#sorumlu_pers_id').val(),
                            roleid:  $('#roleid').val(),
                            cinsiyet:  $('#cinsiyet').val(),
                            vatandaslik:  $('#vatandaslik').val(),
                            country:  $('#country').val(),
                            region:  $('#region').val(),
                            city:  $('#city').val(),
                            address:  $('#address').val(),
                            birthday:  $('#birthday').val(),
                            phone:  $('#phone').val(),
                            name:  $('#name').val(),
                            medeni_durumu:  $('#medeni_durumu').val(),
                            fin_no:  $('#fin_no').val(),
                            paralel_pers_id:  $('.paralel_pers_id').val(),
                            paralel_firma_id:  $('.paralel_firma_id').val(),
                        }
                        $.post(baseurl + 'personel/update',data,(response) => {
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
                        $.post(baseurl + 'personel/disable_user',data,(response) => {
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

                $.post(baseurl + 'personel/cart_list',data,(response) => {
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
                        $.post(baseurl + 'personel/add_cart',data,(response) => {
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
        $.post(baseurl + 'personel/yetkili_kontrol',data_update,(response)=>{
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
        $.post(baseurl + 'personel/yetkili_kontrol',data_update,(response)=>{
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
        $.post(baseurl + 'personel/yetkili_kontrol',data_update,(response)=>{
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
        $.post(baseurl + 'personel/yetkili_kontrol',data_update,(response)=>{
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
        $.post(baseurl + 'personel/yetkili_kontrol',data_update,(response)=>{
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
        $.post(baseurl + 'personel/listpersonelfirma',data,(response)=>{
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
            $.post(baseurl + 'personel/mezuniyet_update',data,(response) => {
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

