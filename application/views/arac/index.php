<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Araç Listesi </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Resim</th>
                        <th>Araç Kodu</th>
                        <th>Plaka No</th>
                        <th>Araç</th>
                        <th>Firma</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Resim</th>
                        <th>Araç Kodu</th>
                        <th>Plaka No</th>
                        <th>Araç</th>
                        <th>Firma</th>
                        <th>İşlem</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        var url = '<?php echo base_url() ?>arac/file_handling';

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
                    'url': "<?php echo site_url('arac/ajax_list')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
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
                        text: '<i class="fa fa-truck"></i> Yeni Araç Ekle',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni Araç Ekle',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Araç Adı</label>
      <input type="text" class="form-control" id="name" placeholder="Açık Pickup">
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="kiralik_demirbas">Araç Durumu</label>
        <select class="form-control" id="kiralik_demirbas">
        <option value="1">Geçici</option>
        <option value="2">Kiralık</option>
        <option value="3">Demirbaş</option>
        </select>
    </div>
    <div class="form-group col-md-6">
      <label for="firma_id">Firma Adı</label>
     <select class="form-control select-box firma_id required" id="firma_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_customer() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->company;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="marka">Marka</label>
      <input type="text" class="form-control" id="marka" placeholder="Toyota">
    </div>
  <div class="form-group col-md-6">
      <label for="yil">Yıl</label>
      <input type="number" class="form-control" id="yil" placeholder="2021">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="model">Model</label>
      <input type="text" class="form-control" id="model" placeholder="Hillux">
    </div>
    <div class="form-group col-md-6">
      <label for="plaka">Plaka</label>
      <input type="text" class="form-control" id="plaka" placeholder="99AB123">
    </div>
  </div>
  </div>
  <div class="form-row">
      <div class="form-group col-md-6">
        <label for="renk">Renk</label>
        <input type="text" class="form-control" id="renk" placeholder="Boz">
      </div>
      <div class="form-group col-md-6">
        <label for="bagaj_hacmi">Bagaj Hacmi (Litre)</label>
        <input type="number" class="form-control" id="bagaj_hacmi" placeholder="30">
      </div>
  </div>
  <div class="form-row">
      <div class="form-group col-md-6">
      <label for="yakit_tipi">Yakıt Tipi</label>
      <input type="text" class="form-control" id="yakit_tipi" placeholder="Dizel">
    </div>
    <div class="form-group col-md-6">
       <label for="ortalama_yakit">Ortalama Yakıt</label>
       <input type="text" class="form-control" id="ortalama_yakit" placeholder="5.6">
    </div>
</div>

  <div class="form-row">
      <div class="form-group col-md-6">
        <label for="agirlik">Ağırlık (Ton)</label>
        <input type="number" class="form-control" id="agirlik" placeholder="2.5">
      </div>
     <div class="form-group col-md-6">
      <label for="sase_no">Şase No</label>
      <input type="text" class="form-control" id="sase_no" placeholder="23123">
    </div>
</div>
 <div class="form-row">
      <div class="form-group col-md-6">
      <label for="active_surucu_id">Aktif Sürücü</label>
     <select class="form-control select-box required" id="active_surucu_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
     <div class="form-group col-md-3">
      <label for="cost_id">Benzin Gider Kalemi</label>
      <select class="form-control select-box required" id="benzin_cost_id">
        <option value="0">Seçiniz</option>
        <?php foreach (all_alt_masraf() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
    </select>
    </div>
     <div class="form-group col-md-3">
      <label for="cost_id">Yemek Gider Kalemi</label>
      <select class="form-control select-box required" id="yemek_cost_id">
        <option value="0">Seçiniz</option>
        <?php foreach (all_alt_masraf() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
    </select>
    </div>
</div>

<div class='form-row'>
<div class="form-group col-md-12">
  <label for="cost_id">Demirbaş Grubu</label>
      <select class="form-control select-box" id="demirbas_id" name="demirbas_id">
                                            <?php
                                if(demirbas_group_list(1)){
                                echo "<option value='0'>Seçiniz</option>";
                                foreach (demirbas_group_list() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                                }
                                else {
                                ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                                }

                                ?>
                                        </select>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Resim</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="files[]">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>
</form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');

                                            let data = {
                                                crsf_token: crsf_hash,
                                                plaka:  $('#plaka').val(),
                                                active_surucu_id:  $('#active_surucu_id').val(),
                                                kiralik_demirbas:  $('#kiralik_demirbas').val(),
                                                name:  $('#name').val(),
                                                firma_id:  $('#firma_id').val(),
                                                marka:  $('#marka').val(),
                                                yil:  $('#yil').val(),
                                                model:  $('#model').val(),
                                                renk:  $('#renk').val(),
                                                bagaj_hacmi:  $('#bagaj_hacmi').val(),
                                                yakit_tipi:  $('#yakit_tipi').val(),
                                                ortalama_yakit:  $('#ortalama_yakit').val(),
                                                agirlik:  $('#agirlik').val(),
                                                sase_no:  $('#sase_no').val(),
                                                image_text:  $('#image_text').val(),
                                                yemek_cost_id:  $('#yemek_cost_id').val(),
                                                benzin_cost_id:  $('#benzin_cost_id').val(),
                                                demirbas_id:  $('#demirbas_id').val(),
                                            }
                                            $.post(baseurl + 'arac/create_save',data,(response) => {
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
                                                                    $('#invoices').DataTable().destroy();
                                                                    draw_data();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status== 410){

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
                    }
                ]
            });
        }




        $(document).on('click', ".talep_sil", function (e) {
            let arac_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Aracı Silmek Üzeresiniz? Emin Misiniz?<p/>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Sil',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let desc = $('#desc').val()
                            jQuery.ajax({
                                url: baseurl + 'arac/remove',
                                dataType: "json",
                                method: 'post',
                                data: 'arac_id=' + arac_id + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $(this).html('Bekleyiniz');
                                    $(this).prop('disabled', true); // disable button

                                },
                                success: function (data) {
                                    if (data.status == "Success") {
                                        $.alert(data.message);
                                        $('#invoices').DataTable().destroy();
                                        draw_data()
                                    } else {
                                        $.alert(data.message);
                                        $('#invoices').DataTable().destroy();
                                        draw_data()
                                    }
                                    $('#loading-box').addClass('d-none');
                                },
                                error: function (data) {
                                    $.alert(data.message);
                                    $('#loading-box').addClass('d-none');
                                }
                            });


                        }
                    },
                    cancel: {
                        text: 'Vazgeç',
                        btnClass: "btn btn-warning btn-sm close",
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
            let arac_id =$(this).attr('talep_id')
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Düzenle',
                icon: 'fa fa-plus',
                type: 'dark',
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
                      <label for="name">Araç Adı</label>
                      <input type="text" class="form-control" id="name" placeholder="Açık Pickup">
                    </div>
                </div>
                <div class="form-row">
                 <div class="form-group col-md-6">
                      <label for="kiralik_demirbas">Araç Durumu</label>
                        <select class="form-control select-box" id="kiralik_demirbas">
                        <option value="1">Geçici</option>
                        <option value="2">Kiralık</option>
                        <option value="3">Demirbaş</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="firma_id">Firma Adı</label>
                     <select class="form-control select-box firma_id required" id="firma_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_customer() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->company;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="marka">Marka</label>
      <input type="text" class="form-control" id="marka" placeholder="Toyota">
    </div>
  <div class="form-group col-md-6">
      <label for="yil">Yıl</label>
      <input type="number" class="form-control" id="yil" placeholder="2021">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="model">Model</label>
      <input type="text" class="form-control" id="model" placeholder="Hillux">
    </div>
    <div class="form-group col-md-6">
      <label for="plaka">Plaka</label>
      <input type="text" class="form-control" id="plaka" placeholder="99AB123">
    </div>
  </div>
  </div>
  <div class="form-row">
      <div class="form-group col-md-6">
        <label for="renk">Renk</label>
        <input type="text" class="form-control" id="renk" placeholder="Boz">
      </div>
      <div class="form-group col-md-6">
        <label for="bagaj_hacmi">Bagaj Hacmi (Litre)</label>
        <input type="number" class="form-control" id="bagaj_hacmi" placeholder="30">
      </div>
  </div>
  <div class="form-row">
      <div class="form-group col-md-6">
      <label for="yakit_tipi">Yakıt Tipi</label>
      <input type="text" class="form-control" id="yakit_tipi" placeholder="Dizel">
    </div>
    <div class="form-group col-md-6">
       <label for="ortalama_yakit">Ortalama Yakıt</label>
       <input type="text" class="form-control" id="ortalama_yakit" placeholder="5.6">
    </div>
</div>

  <div class="form-row">
      <div class="form-group col-md-6">
        <label for="agirlik">Ağırlık (Ton)</label>
        <input type="number" class="form-control" id="agirlik" placeholder="2.5">
      </div>
     <div class="form-group col-md-6">
      <label for="sase_no">Şase No</label>
      <input type="text" class="form-control" id="sase_no" placeholder="23123">
    </div>
</div>
 <div class="form-row">
      <div class="form-group col-md-6">
      <label for="active_surucu_id">Aktif Sürücü</label>
     <select class="form-control select-box required" id="active_surucu_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>


    </div>
    <div class="form-group col-md-3">
      <label for="cost_id">Benzin Gider Kalemi</label>
      <select class="form-control select-box required" id="benzin_cost_id">
        <option value="0">Seçiniz</option>
        <?php foreach (all_alt_masraf() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
    </select>
    </div>
     <div class="form-group col-md-3">
      <label for="cost_id">Yemek Gider Kalemi</label>
      <select class="form-control select-box required" id="yemek_cost_id">
        <option value="0">Seçiniz</option>
        <?php foreach (all_alt_masraf() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
    </select>
    </div>
    </div>
    <div class='form-row'>
<div class="form-group col-md-12">
  <label for="cost_id">Demirbaş Grubu</label>
      <select class="form-control select-box" id="demirbas_id" name="demirbas_id">
                                            <?php
                    if(demirbas_group_list(1)){
                    echo "<option value='0'>Seçiniz</option>";
                    foreach (demirbas_group_list() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                    }
                    else {
                    ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                    }

                    ?>
                                        </select>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Resim</label>
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
</form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        arac_id: arac_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'arac/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html)
                        let responses = jQuery.parseJSON(response);
                        $('#name').val(responses.items.name)
                        $('#firma_id').val(responses.items.firma_id).select2().trigger('change')
                        $('#kiralik_demirbas').val(responses.items.kiralik_demirbas).select2().trigger('change')
                        $('#active_surucu_id').val(responses.items.active_surucu_id).select2().trigger('change')
                        $('#marka').val(responses.items.marka)
                        $('#yil').val(responses.items.yil)
                        $('#model').val(responses.items.model)
                        $('#plaka').val(responses.items.plaka)
                        $('#demirbas_id').val(responses.items.demirbas_id)
                        $('#renk').val(responses.items.renk)
                        $('#bagaj_hacmi').val(responses.items.bagaj_hacmi)
                        $('#yakit_tipi').val(responses.items.yakit_tipi)
                        $('#ortalama_yakit').val(responses.items.ortalama_yakit)
                        $('#agirlik').val(responses.items.agirlik)
                        $('#sase_no').val(responses.items.sase_no);
                        $('#yemek_cost_id').val(responses.items.yemek_cost_id);
                        $('#benzin_cost_id').val(responses.items.benzin_cost_id);
                        $('#image_text_update').val(responses.items.image_text);
                        $('.update_image').attr('src',"https://muhasebe.makro2000.com.tr/userfiles/product/"+responses.items.image_text)

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
                                arac_id:  arac_id,
                                plaka:  $('#plaka').val(),
                                active_surucu_id:  $('#active_surucu_id').val(),
                                kiralik_demirbas:  $('#kiralik_demirbas').val(),
                                demirbas_id:  $('#demirbas_id').val(),
                                name:  $('#name').val(),
                                firma_id:  $('#firma_id').val(),
                                marka:  $('#marka').val(),
                                yil:  $('#yil').val(),
                                model:  $('#model').val(),
                                renk:  $('#renk').val(),
                                bagaj_hacmi:  $('#bagaj_hacmi').val(),
                                yakit_tipi:  $('#yakit_tipi').val(),
                                ortalama_yakit:  $('#ortalama_yakit').val(),
                                agirlik:  $('#agirlik').val(),
                                sase_no:  $('#sase_no').val(),
                                image_text:  $('#image_text_update').val(),
                                yemek_cost_id:  $('#yemek_cost_id').val(),
                                benzin_cost_id:  $('#benzin_cost_id').val(),
                            }
                            $.post(baseurl + 'arac/update_save',data,(response) => {
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
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
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

        $(document).on('click','.ekipmanlar',function (){
            let arac_id =$(this).attr('talep_id')
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Ekipmanları',
                icon: 'fa fa-plus',
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
                            <div class="form-group col-md-12 add_ekipman">

                            </div>
                        </div>
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        arac_id: arac_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'arac/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);



                        responses.ekipmanlar.forEach((item) => {
                            table_report +=`  <div class="form-row"><div class="form-group col-md-12">
                            <input class="form-check-input ekipman_check" val_id="`+item.id+`" type="checkbox" value="`+item.id+`">
                                <label class="form-check-label" for="ekipman_check">
                                    `+item.name+`
                                </label>
                        </div></div>`;
                        })
                        $('.add_ekipman').empty().html(table_report);

                        if(responses.arac_ekipmanlari){
                            responses.arac_ekipmanlari.forEach((item_) => {
                                $("input[value='"+item_.id+"']").prop('checked',true);
                            })
                        }

                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {
                            let check_id = [];
                            for (let i =0; i< $('.ekipman_check').length; i++){
                                let checked = ($('.ekipman_check').eq(i).is(":checked")) ? true : false;
                                if(checked){
                                    check_id.push($('.ekipman_check').eq(i).val())
                                }
                            }
                            $('#loading-box').removeClass('d-none');

                            let data = {
                                crsf_token: crsf_hash,
                                arac_id:  arac_id,
                                check_id:  check_id
                            }
                            $.post(baseurl + 'arac/update_ekipman',data,(response) => {
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
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
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

        $(document).on('click','.date_sozlesme',function (){
            let arac_id =$(this).attr('talep_id')
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Bakım / Servis Tarihleri',
                icon: 'fa fa-plus',
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
                    <div class="form-group col-md-12">
                      <label for="name">Servis Tipi</label>
                      <select class="form-control select-box bakim_id required" id="bakim_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (bakimlar() as $emp){
                                                    $emp_id=$emp->id;
                                                    $name=$emp->name;
                                                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="firma_id">Firma Adı</label>
                     <select class="form-control select-box firma_id required" id="firma_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_customer() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->company;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="firma_id">Sorumlu Personel</label>
                     <select class="form-control select-box user_id required" id="user_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="son_yapilma_tarihi">Son Yapılma Tarihi</label>
      <input type="date" class="form-control" id="son_yapilma_tarihi">
    </div>
  <div class="form-group col-md-4">
      <label for="ay_yil">Tekrar Zaman Dilimi</label>
      <select class="form-control" id="ay_yil">
      <option value="1">Aylık</option>
      <option value="2">Yıllık</option>

      <select>
</div>
 <div class="form-group col-md-4">
      <label for="tekrar_zamani">Tekrar Zamanı</label>
      <select class="form-control" id="tekrar_zamani">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="5">6</option>
      <select>
</div>
</div>
<div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
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
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        arac_id: arac_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'arac/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);

                        responses.ekipmanlar.forEach((item) => {
                            table_report +=`  <div class="form-row"><div class="form-group col-md-12">
                            <input class="form-check-input ekipman_check" val_id="`+item.id+`" type="checkbox" value="`+item.id+`">
                                <label class="form-check-label" for="ekipman_check">
                                    `+item.name+`
                                </label>
                        </div></div>`;
                        })
                        $('.add_ekipman').empty().html(table_report);

                        if(responses.arac_ekipmanlari){
                            responses.arac_ekipmanlari.forEach((item_) => {
                                $("input[value='"+item_.id+"']").prop('checked',true);
                            })
                        }

                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Kayıt Et',
                        btnClass: 'btn-blue',
                        action: function () {

                            let bakim_id=$('#bakim_id').val();
                            let user_id=$('#user_id').val();
                            let firma_id=$('#firma_id').val();
                            let son_yapilma_tarihi=$('#son_yapilma_tarihi').val();
                            let tekrar_zamani=$('#tekrar_zamani').val();
                            let ay_yil=$('#ay_yil').val();
                            let image_text_update=$('#image_text_update').val();
                            $('#loading-box').removeClass('d-none');

                            let data = {
                                crsf_token: crsf_hash,
                                arac_id:  arac_id,
                                bakim_id:  bakim_id,
                                user_id:  user_id,
                                firma_id:  firma_id,
                                tekrar_zamani:  tekrar_zamani,
                                ay_yil:  ay_yil,
                                son_yapilma_tarihi:  son_yapilma_tarihi,
                                image_text_update:  image_text_update,
                            }
                            $.post(baseurl + 'arac/update_bakim',data,(response) => {
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
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
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


        $(document).on('click','.icazeler',function (){
            let arac_id =$(this).attr('talep_id')
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç İcazeleri',
                icon: 'fa fa-plus',
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
                    <div class="form-group col-md-12">
                      <label for="name">İcazeler</label>
                      <select class="form-control select-box icaze_id required" id="icaze_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (icazeler() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="firma_id">Sorumlu Personel</label>
                     <select class="form-control select-box user_id required" id="user_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>
<div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
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
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        arac_id: arac_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'arac/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);

                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Kayıt Et',
                        btnClass: 'btn-blue',
                        action: function () {

                            let icaze_id=$('#icaze_id').val();
                            let user_id=$('#user_id').val();
                            let image_text_update=$('#image_text_update').val();
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                arac_id:  arac_id,
                                icaze_id:  icaze_id,
                                user_id:  user_id,
                                image_text_update:  image_text_update,
                            }
                            $.post(baseurl + 'arac/update_icaze',data,(response) => {
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
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
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


        $(document).on('click','.oil',function (){
            let arac_id =$(this).attr('talep_id')
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Benzin Kartı Tanımlama',
                icon: 'fa fa-plus',
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
                    <div class="form-group col-md-6">
                      <label for="name">Benzin Kart Numarası</label>
                      <input type="text" class="form-control" id="kart_no">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="firma_id">Firma Adı</label>
                     <select class="form-control select-box firma_id required" id="firma_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_customer() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->company;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="firma_id">Sorumlu Personel</label>
                     <select class="form-control select-box user_id required" id="user_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>
<div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Benzin Kartı Resmi</label>
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
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        arac_id: arac_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'arac/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);

                        if(responses.arac_oil){
                            $('#kart_no').val(responses.arac_oil.kart_no)
                            $('#image_text_update').val(responses.arac_oil.file_name)
                            $('#firma_id').val(responses.arac_oil.firma_id).select2().trigger('change');
                            $('#user_id').val(responses.arac_oil.user_id).select2().trigger('change');
                            $('.update_image').attr('src',"https://muhasebe.makro2000.com.tr/userfiles/product/"+responses.arac_oil.file_name)
                        }

                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {

                            let kart_no=$('#kart_no').val();
                            let firma_id=$('#firma_id').val();
                            let user_id=$('#user_id').val();
                            let image_text_update=$('#image_text_update').val();
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                arac_id:  arac_id,
                                firma_id:  firma_id,
                                kart_no:  kart_no,
                                user_id:  user_id,
                                image_text_update:  image_text_update,
                            }
                            $.post(baseurl + 'arac/update_oil',data,(response) => {
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
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
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

        $(document).on('click','.traffic',function (){
            let arac_id =$(this).attr('talep_id')
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Ceza Tanımlama',
                icon: 'fa fa-plus',
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
                    <div class="form-group col-md-6">
                      <label for="name">Ceza Tipi</label>
                     <select class="form-control select-box ceza_id required" id="ceza_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (trafik_cezalari() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="firma_id">Sorumlu Personel</label>
                     <select class="form-control select-box user_id required" id="user_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="tutar">Tutar</label>
                      <input type="number" class="form-control" id='tutar'>
                     </div>
                           <div class="form-group col-md-4">
                      <label for="tutar">Ceza Tarihi</label>
                      <input type="date" class="form-control" id='date'>
                     </div>
                    <div class="form-group col-md-4">
                      <label for="tutar">P. Ekstresine Yansıt</label>
                     <select class="form-control" id="ekstere_status">
                     <option value="0">Hayır</option>
                     <option value="1">Evet</option>
                     </select>
                     </div>
</div>
<div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Ceza Tutanağı</label>
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
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        arac_id: arac_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'arac/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);

                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Ekle',
                        btnClass: 'btn-blue',
                        action: function () {

                            let ceza_id=$('#ceza_id').val();
                            let user_id=$('#user_id').val();
                            let tutar=$('#tutar').val();
                            let date=$('#date').val();
                            let ekstere_status=$('#ekstere_status').val();
                            let image_text_update=$('#image_text_update').val();
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                arac_id:  arac_id,
                                ceza_id:  ceza_id,
                                tutar:  tutar,
                                user_id:  user_id,
                                date:  date,
                                ekstere_status:  ekstere_status,
                                image_text_update:  image_text_update,
                            }
                            $.post(baseurl + 'arac/update_ceza',data,(response) => {
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
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
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




    </script>
