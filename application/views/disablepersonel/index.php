<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Pasif Personel İşlemleri</span></h4>
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
                                                <td>Personel Adı</td>
                                                <td>Pozisyon</td>
                                                <td>Çalıştığı Proje</td>
                                                <td>Bakiye</td>
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
                'url': "<?php echo site_url('disablepersonel/ajax_list')?>",
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
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        });
    };



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
        <div class="form-group col-md-3">
          <label for="name">İşe Başlama Tarihi</label>
          <input type='date' class='form-control zorunlu_text' id='ise_baslangic_tarihi'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Maaş Tipi</label>
           <select name="salary_type" class="form-control select-box zorunlu" id="salary_type">
              <?php foreach (salary_type() as $type){
                    echo ' <option value="' . $type->id . '"> ' . $type->name . '</option>';
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
    </div>
</form>`;
                let data = {
                    id: pers_id,
                }

                $.post(baseurl + 'disablepersonel/info',data,(response) => {
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
                    $('#ise_baslangic_tarihi').val(responses.items.ise_baslama_tarihi);

                    $('#salary_type').val(responses.salary_details.salary_type).select2().trigger('change');
                    $('#salary').val(responses.salary_details.salary);
                    $('#bank_salary').val(responses.salary_details.bank_salary);
                    $('#net_salary').val(responses.salary_details.net_salary);
                    $('#salary_day').val(responses.salary_details.salary_day);
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

                        let data = {
                            crsf_token: crsf_hash,
                            personel_id: pers_id,
                            salary_day:  $('#salary_day').val(),
                            net_salary:  $('#net_salary').val(),
                            bank_salary:  $('#bank_salary').val(),
                            salary:  $('#salary').val(),
                            salary_type:  $('#salary_type').val(),
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
                        }
                        $.post(baseurl + 'disablepersonel/update',data,(response) => {
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
            title: 'Aktifleştirme ',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'Aktifleştirmek İstediğinizden Emin Misiniz',
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
                        $.post(baseurl + 'disablepersonel/disable_user',data,(response) => {
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
        $.post(baseurl + 'disablepersonel/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#salary').attr('type') === "password" ? "text" : "password";
                $('#salary').attr("type", new_type);
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

    $(document).on('click','#bank_salary_show',function (){

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'disablepersonel/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#bank_salary').attr('type') === "password" ? "text" : "password";
                $('#bank_salary').attr("type", new_type);
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

    $(document).on('click','#net_salary_show',function (){

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'disablepersonel/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#net_salary').attr('type') === "password" ? "text" : "password";
                $('#net_salary').attr("type", new_type);
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

    $(document).on('click','#salary_day_show',function (){


        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'disablepersonel/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('#salary_day').attr('type') === "password" ? "text" : "password";
                $('#salary_day').attr("type", new_type);
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


    $(document).on('click','.bakiye_show',function (){


        let data_update = {
            crsf_token: crsf_hash,
            id: 58,
        }
        $.post(baseurl + 'disablepersonel/yetkili_kontrol',data_update,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let new_type = $('.bakiye').attr('type') === "password" ? "text" : "password";
                $('.bakiye').attr("type", new_type);
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

</script>
<style>
    input:focus-visible {
        outline: none;
        border: none;
    }
</style>

