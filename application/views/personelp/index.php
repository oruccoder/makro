<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Podradçı personel İşlemleri</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <div class="message"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="select-box form-control" id="proje_id_filt" name="proje_id_filt" >
                                    <option value="0">Proje Seçiniz</option>
                                    <?php foreach (all_projects() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->code?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select class="select-box form-control" id="cari_id" name="cari_id" >
                                    <option value="0">Ana Podradçı</option>
                                    <?php foreach (all_customer() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select class="select-box form-control" id="parent_id" name="parent_id" >
                                    <option value="0">Alt Podradçı</option>
                                    <?php
                                    foreach (all_list_podradci() as $items){
                                        $new_title = parent_podradci_kontrol_list($items->id);
                                        echo "<option value='$items->id'>$new_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                            </div>
                        </div>
                    </div>
                </div>
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
                                                <td>Ana Podradçi</td>
                                                <td>Bağlı Olduğu Alt Podradçi</td>
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



    $('#search').on('click',function (){
        let proje_id = $('#proje_id_filt').val();
        let cari_id = $('#cari_id').val();
        let parent_id = $('#parent_id').val();
        $('#personel').DataTable().destroy();
        draw_data(proje_id,cari_id,parent_id);

    })

    function draw_data(proje_id = null,cari_id=null,parent_id=null) {
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
                'url': "<?php echo site_url('personelp/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id:proje_id,
                    cari_id:cari_id,
                    parent_id:parent_id,
                }
            },
            'columnDefs': [
                {
                    'targets': [0,2,6,7,8,9],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-user-plus"></i> Yeni Personel Kartı Oluştur',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Personel Kartı Əlavə Edin',
                            icon: 'fa fa-user-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form id='data_form'>
                              <div class="form-row">
  <div class="form-group col-md-6">
                   <label>Bağlı Olduğu  Podradçi</label>
                   <select class="form-control select-box ana_cari required">
                    <option value="">Bağlı Olduğu Podradci</option>
                    <?php foreach (all_customer() as $items){
                                $new_title = $items->company;
                                echo "<option value='$items->id'>$new_title</option>";
                            } ?>
                    </select>
                </div>
                 <div class="form-group col-md-6">
                   <label>Bağlı Olduğu Alt Podradçi</label>
                   <select class="form-control select-box parent_id">
                    <option value="0">Bağlı Olduğu Podradci</option>
                    <?php foreach (all_list_podradci() as $items){
                                $new_title = parent_podradci_kontrol_list($items->id);
                                echo "<option value='$items->id'>$new_title</option>";
                            } ?>
                    </select>
                </div>
            </div>
            </div>
  <div class="form-row">
       <div class="form-group col-md-2">
          <label for="name">Ad Soyad</label>
           <input type='text' class='form-control required' id='name'>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Medeni Durumu</label>
          <select class='form-control select-box' id='medeni_durumu'>
               <option value="Bekar"><?php echo 'Bekar'; ?> </option>
               <option value="Evli"><?php echo 'Evli'; ?> </option>
           </select>
        </div>
        <div class="form-group col-md-1">
          <label for="name">Fin Kodu</label>
           <input type='text' class='form-control required' id='fin_no'>
        </div>
             <div class="form-group col-md-1">
          <label for="name">Seri No</label>
           <input type='text' class='form-control required' id='seri_no'>
        </div>
         <div class="form-group col-md-2">
          <label for="name">Telefon</label>
           <input type='number' class='form-control required' id='phone'>
        </div>
            <div class="form-group col-md-2">
          <label for="name">E-Mail</label>
           <input type='text' class='form-control required' id='email'>
        </div>
          <div class="form-group col-md-2">
          <label for="name">Açık Adres</label>
           <input type='text' class='form-control required' id='address'>
        </div>
    </div>

    <div class="form-row">
 <div class="form-group col-md-3">
      <label for="name">Vatandaşlık</label>
       <select name="vatandaslik" class="form-control select-box required" id="vatandaslik">
           <?php foreach (vatandaslik() as $vat) {?>
               <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name']; ?> </option>
            <?php } ?>
        </select>
    </div>
         <div class="form-group col-md-3">
          <label for="name">Rayon</label>
           <input type='text' class='form-control required' id='city'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Şeher</label>
           <input type='text' class='form-control required' id='region'>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Ülke</label>
           <input type='text' class='form-control required' id='country'>
        </div>
    </div>
     <div class="form-row">

     <div class="form-group col-md-3">
      <label for="name">Cinsiyet</label>
       <select name="cinsiyet" class="form-control select-box required" id="cinsiyet">
            <option value="Kadın">Kadın</option>
            <option value="Erkek">Erkek</option>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="name">Pozisyon</label>
       <select name="roleid" class="form-control select-box required" id="roleid">
           <?php foreach (role_name() as $rol){
                            ?>
                 <option value="<?php echo $rol['role_id']; ?>"><?php echo $rol['name']; ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="name">Sorumlu Personel</label>
       <select name="roleid" class="form-control select-box required" id="sorumlu_pers_id">
           <?php foreach (all_personel() as $rol){
                            ?>
         <option value="<?php echo $rol->id; ?>"><?php echo $rol->name; ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
          <label for="name">Proje</label>
           <select name="proje_id" class="form-control select-box required" id="proje_id">
               <?php foreach (all_projects() as $vat) {?>
                   <option value="<?php echo $vat->id; ?>"><?php echo $vat->name; ?> </option>
                <?php } ?>
            </select>
        </div>
    </div>
     <div class="form-row">

        <div class="form-group col-md-3">
          <label for="name">Çalışma Şekli</label>
           <select name="proje_id" class="form-control select-box required" id="calisma_sekli">
               <?php  foreach (calisma_sekli(1) as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                            }
                            ?>
            </select>
        </div>
        <div class="form-group col-md-2">
          <label for="name">İşe Başlama Tarihi</label>
          <input type='date' class='form-control required' id='ise_baslangic_tarihi'>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Maaş Tipi</label>
           <select name="salary_type" class="form-control select-box required" id="salary_type">
              <?php foreach (salary_type() as $type){
                                echo ' <option value="' . $type->id . '"> ' . $type->name . '</option>';
                            }
                            ?>
         </select>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Sifarişçi Firma</label>
           <select name="loc_id" class="form-control select-box required" id="loc_id">
              <?php foreach (firmalar() as $type){
                                echo ' <option value="' . $type->id . '"> ' . $type->cname . '</option>';
                            }
                            ?>
         </select>
        </div>
            <div class="form-group col-md-3">
          <label for="name">Toplam Maaş</label>
          <input type='number' class='form-control' id='salary' value='0'>
        </div>
    </div>
      <div class="form-row">

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

    </div>
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let errorMessage = 'Tüm Alanlar Zorunludur';

                                        let valid = true;

// Gerekli alanları kontrol et
                                        $('#data_form .required').each(function () {
                                            let element = $(this);

                                            if (element.is('select')) {
                                                // Select2 öğesi için özel kontrol
                                                if (!element.val() || element.val() === "") {
                                                    element.next('.select2').find('.select2-selection').addClass('is-invalid-select2');
                                                    valid = false;
                                                } else {
                                                    element.next('.select2').find('.select2-selection').removeClass('is-invalid-select2');
                                                }
                                            }

                                            else {
                                                // Diğer inputlar için kontrol
                                                if (!element.val()) {
                                                    element.addClass('is-invalid');
                                                    valid = false;
                                                } else {
                                                    element.removeClass('is-invalid');
                                                }
                                            }
                                        });

                                        // Eğer tüm kontrollerden geçemezse uyarı göster
                                        if (!valid) {
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: errorMessage,
                                                buttons: {
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }

                                        // Eğer tüm alanlar doluysa işlemi devam ettir
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            salary_day: $('#salary_day').val(),
                                            net_salary: $('#net_salary').val(),
                                            bank_salary: $('#bank_salary').val(),
                                            salary: $('#salary').val(),
                                            salary_type: $('#salary_type').val(),
                                            loc_id: $('#loc_id').val(),
                                            ise_baslangic_tarihi: $('#ise_baslangic_tarihi').val(),
                                            calisma_sekli: $('#calisma_sekli').val(),
                                            proje_id: $('#proje_id').val(),
                                            sorumlu_pers_id: $('#sorumlu_pers_id').val(),
                                            roleid: $('#roleid').val(),
                                            cinsiyet: $('#cinsiyet').val(),
                                            vatandaslik: $('#vatandaslik').val(),
                                            country: $('#country').val(),
                                            region: $('#region').val(),
                                            city: $('#city').val(),
                                            address: $('#address').val(),
                                            birthday: $('#birthday').val(),
                                            email: $('#email').val(),
                                            phone: $('#phone').val(),
                                            name: $('#name').val(),
                                            medeni_durumu: $('#medeni_durumu').val(),
                                            fin_no: $('#fin_no').val(),
                                            seri_no: $('#seri_no').val(),
                                            aylik_maas: $('#aylik_maas').val(),
                                            podradci_id: $('.parent_id').val(),
                                            ana_cari: $('.ana_cari').val(),
                                        };

                                        $.post(baseurl + 'personelp/create_save', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status == 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
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
                                            } else if (responses.status == 410) {
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
                                        });
                                    }
                                },
                                cancel: {
                                    text: 'Vazgeç',
                                    btnClass: "btn btn-danger btn-sm",
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
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
                        $new_title = parent_podradci_kontrol_list($items->id);
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
           <input type='text' class='form-control required' id='name'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Medeni Durumu</label>
          <select class='form-control select-box' id='medeni_durumu'>
               <option value="Bekar"><?php echo 'Bekar'; ?> </option>
               <option value="Evli"><?php echo 'Evli'; ?> </option>
           </select>
        </div>
        <div class="form-group col-md-1">
          <label for="name">Fin Kodu</label>
           <input type='text' class='form-control required' id='fin_no'>
        </div>
           <div class="form-group col-md-2">
          <label for="name">Seri No</label>
           <input type='text' class='form-control required' id='seri_no'>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Telefon</label>
           <input type='number' class='form-control required' id='phone'>
        </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-3">
          <label for="name">Açık Adres</label>
           <input type='text' class='form-control required' id='address'>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Rayon</label>
           <input type='text' class='form-control required' id='city'>
        </div>
        <div class="form-group col-md-3">
          <label for="name">Şeher</label>
           <input type='text' class='form-control required' id='region'>
        </div>
         <div class="form-group col-md-3">
          <label for="name">Ülke</label>
           <input type='text' class='form-control required' id='country'>
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
          <input type='date' class='form-control required' id='ise_baslangic_tarihi'>
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
        <div class="form-group col-md-2">
          <label for="name">Kelbecer Farkı</label>
          <input type='password' class='form-control' id='net_salary' value='0'>
          <i class="fa fa-eye-slash" id="net_salary_show"></i>
        </div>
        <div class="form-group col-md-2">
          <label for="name">Günlük Maaş</label>
          <input type='password' class='form-control' id='salary_day' value='0'>
           <i class="fa fa-eye-slash" id="salary_day_show"></i>
        </div>
         <div class="form-group col-md-2">
          <label for="name">Aylık Maas</label>
          <input type='number' class='form-control' id='aylik_maas' value='0'>
        </div>

</form>`;
                let data = {
                    id: pers_id,
                }

                $.post(baseurl + 'personelp/info',data,(response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.items.name);
                    $('#medeni_durumu').val(responses.items.medeni_durumu).select2().trigger('change');

                    $('#fin_no').val(responses.items.fin_no);
                    $('#seri_no').val(responses.items.seri_no);
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
                            seri_no:  $('#seri_no').val(),
                        }
                        $.post(baseurl + 'personelp/update',data,(response) => {
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

