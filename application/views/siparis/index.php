<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Sipariş Listesi </span></h4>
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
                        <th>No</th>
                        <th>Sipariş Kodu</th>
                        <th>Sipariş Tarihi</th>
                        <th>Cari</th>
                        <th>Açıklama</th>
                        <th>Durum</th>
                        <th>İşlem</th>
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

    var url = '<?php echo base_url() ?>arac/file_handling';

    let table_product_id_ar=[];
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
                'url': "<?php echo site_url('siparis/ajax_list')?>",
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
                    text: '<i class="fa fa-truck"></i> Yeni Sipariş Ekle',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Sipariş Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
  <div class="form-row">
   <div class="form-group col-md-12">
      <label for="cari_id">Cari Adı</label>
     <select class="form-control select-box cari_id" id="cari_id">
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
      <label for="marka">Cari Proje Adı</label>
      <select class="form-control select-box cari_proje_id" id="cari_proje_id">
            <option value="0">Cari Seçiniz</option>

    </select>
    </div>
  <div class="form-group col-md-6">
      <label for="yil">Teslimat Deposu</label>
      <select class="form-control select-box cari_teslimat_id" id="cari_teslimat_id">
            <option value="0">Cari Seçiniz</option>

    </select>
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
       <label for="warehouse_id">Çıkış Deposu</label>
     <select class="form-control select-box warehouse_id required" id="warehouse_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_warehouse() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->title;
                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
    </div>
    <div class="form-group col-md-3">
      <label for="active_surucu_id">Sorumlu Personel</label>
     <select class="form-control select-box required" id="sorumlu_personel">
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
      <label for="active_surucu_id">Açıklama</label>
      <input type='text' class='form-control' id='desc'>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
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
      </div>
      <hr>

      <div class="form-row">
      <div class="form-group col-md-12">
      <button class='btn btn-success' type='button' id='add-product'><i class='fa fa-plus'></i> Ürün Ekle</button>
      </div>


      <table class='table' id='items'>
          <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Miktar</th>
                <th>Birim</th>
                <th>EDV Hariç Birim Fiyatı</th>
                <th>EDV Hariç Toplam Fiyat</th>
                <th>İşlem</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
          </div>
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sipariş Oluştur',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let count = $('.result-row').length;
                                        let collection = [];

                                        for(let i=0;i<count;i++){
                                            let data_new = {
                                                unit_id: $('.result-row').eq(i).data('unit-id'),
                                                option_id: $('.result-row').eq(i).data('option-id'),
                                                value_id: $('.result-row').eq(i).data('option-value-id'),
                                                product_id: $('.result-row').eq(i).data('product_id'),
                                                qty: $('.result-row').eq(i).data('qty'),
                                                price: $('.result-row').eq(i).data('price'),
                                                total_price: $('.result-row').eq(i).data('total_price'),
                                            }

                                            collection.push(data_new)
                                        }

                                        let data = {
                                            collection: collection,
                                            cari_id:  $('#cari_id').val(),
                                            cari_proje_id:  $('#cari_proje_id').val(),
                                            cari_teslimat_id:  $('#cari_teslimat_id').val(),
                                            warehouse_id:  $('#warehouse_id').val(),
                                            sorumlu_personel:  $('#sorumlu_personel').val(),
                                            desc:  $('#desc').val(),
                                            table_product_id_ar:  table_product_id_ar,
                                            image_text:  $('#image_text').val(),
                                        }
                                        $.post(baseurl + 'siparis/create_save',data,(response) => {
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

    $(document).on('change','.cari_id',function (){
        let cari_id = $(this).val();
        let data = {
           cari_id:cari_id
        }
        $.post(baseurl + 'customers/teslimat_details',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.cari_teslimat_id option').remove()
            $('.cari_proje_id option').remove()
            $('#loading-box').addClass('d-none');
            if(responses.status==200){
                if(responses.teslimat_details.length){
                    responses.teslimat_details.forEach((item_,index) => {
                        $('.cari_teslimat_id').append(new Option(item_.unvan_teslimat, item_.id, false, false)).trigger('change');
                    })
                }
                else {
                    $('.cari_teslimat_id').append(new Option('Cari Seçiniz', '', false, false));
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Teslimat Adresi Tanımlanmamış',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

                if(responses.proje_details.length){
                    responses.proje_details.forEach((item_,index) => {
                        $('.cari_proje_id').append(new Option(item_.proje_name, item_.id, false, false)).trigger('change');
                    })
                }
                else{
                    $('.cari_proje_id').append(new Option('Cari Seçiniz', '', false, false));
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Proje Tanımlanmamış',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            }
            else if(responses.status== 410){
                $('.cari_teslimat_id').append(new Option('Cari Seçiniz', '', false, false));
                $('.cari_proje_id').append(new Option('Cari Seçiniz', '', false, false));
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
        })

    })
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

    $(document).on('click','#add-product',function (){
        table_product_id_ar=[];
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Ekle',
            icon: 'fa fa-eye',
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
      <label for="product">Ürün Adı</label>
     <select class="form-control select-box product required" id="product">
    </select>
    </div>
     <div class="form-group col-md-12">
          <label for="qty">Miktar</label>
            <input type="number" class="form-control" value='0' id="qty">
    </div>
    <div class="form-group col-md-12">
          <label for="unit_id">Birim</label>
            <select class="form-control select-box unit_id required" id="unit_id">
                    <?php foreach (units() as $emp){
                    ?>
                    <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                <?php } ?>
         </select>
    </div>
        <div class="form-group col-md-12">
          <label for="price">EDV Hariç Birim Fiyatı</label>
            <input type="number" class="form-control" value='0' id="price">
    </div
</div>

</form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        if(table_product_id_ar){
                            let i=$('#items>tbody>tr').length;
                            let qty = $('#qty').val();
                            let unit_id = $('#unit_id').val();
                            let price = $('#price').val();
                            let unit_name = $('#unit_id :selected').text();
                            let product_name = $('#product :selected').text();
                            let option_id_data='';
                            let option_value_id_data='';
                            if(table_product_id_ar[0]){
                                 option_id_data=table_product_id_ar[0].option_id_data
                                 option_value_id_data=table_product_id_ar[0].option_value_id_data
                            }
                            let total_price=price*qty;
                            let product_id=table_product_id_ar[0].product_id
                            $("#items>tbody").append('<tr  data-total_price="'+total_price+'" data-qty="'+qty+'" data-price="'+price+'" data-unit-id="'+unit_id+'" data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-product_id="'+product_id+'"  id="remove'+i+'" class="result-row">' +
                                '<td>'+ product_name +'<span>'+table_product_id_ar[0].varyasyon_html+'</span></td>' +
                                '<td>'+qty+'</td>' +
                                '<td>'+unit_name+'</td>' +
                                '<td>'+ price+'</td>' +
                                '<td>'+ total_price+'</td>' +
                                //'<td> <button data-id="'+i+'" class="btn btn-danger recete_item_remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                '<td> <button class="btn btn-danger recete_item_remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                '</tr>' );
                        }


                    }
                },
            },
            onContentReady: function () {
                $('.product').select2({
                    dropdownParent: $(".jconfirm"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder:'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method:'POST',
                        url: '<?php echo base_url().'stockio/getall_products' ?>',
                        dataType: 'json',
                        data:function (params)
                        {
                            let query = {
                                search: params.term,
                                warehouse_id: $('#warehouse').val(),
                                crsf_token: crsf_hash,
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (data) {
                                    return {
                                        text: data.product_name,
                                        product_name: data.product_name,
                                        id: data.pid,

                                    }
                                })
                            };
                        },
                        cache: true
                    },
                }).on('change',function (data) {

                    let product_id = $(this).val();
                    let warehouse = 0;
                    let varyasyon_durum=false;
                    let i =1;
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
                                crsf_token: crsf_hash,
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
                                text: 'Devam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let option_details=[];
                                    if(varyasyon_durum){
                                        $('.option-value:checked').each((index,item) => {
                                            option_details.push({
                                                'option_id':$(item).attr('data-option-id'),
                                                'option_name':$(item).attr('data-option-name'),
                                                'option_value_id':$(item).attr('data-value-id'),
                                                'option_value_name':$(item).attr('data-option-value-name'),
                                            })
                                        });
                                    }

                                    i++;
                                    let data_post = {
                                        crsf_token: crsf_hash,
                                        id: product_id,
                                        warehouse:warehouse,
                                        option_details:option_details
                                    }
                                    let data='';
                                    let result=false;
                                    let sayi=0;
                                    $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                                        let data_res = jQuery.parseJSON(response);

                                        let units = '<select class="form-control select-box line_unit_id">';
                                        data_res.units.forEach((item,index) => {
                                            units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                        })
                                        units+='</select>';
                                        if (data_res.code == 200) {
                                            data = {
                                                qty:          data_res.result.qty,
                                                unit_id:      data_res.result.unit_id,
                                                fis_type:     $("#type").val(),
                                                fis_name:     $("#type").find(':selected').data("name"),
                                                unit_name:    data_res.result.unit_name,
                                                warehouse_id: $("#warehouse").val(),
                                                anbar_name:   $("#warehouse").find(':selected').data('name'),
                                                product_id:   data_res.result.product_id,
                                                product_name: data_res.result.product_name,
                                                option_details: option_details

                                            }

                                            if(!result){
                                                let varyasyon_html='';
                                                let option_id_data='';
                                                let option_value_id_data='';
                                                if(option_details){
                                                    for (let i=0; i < option_details.length;i++){
                                                        varyasyon_html+=option_details[i].option_name+' : '+option_details[i].option_value_name+'<br>';
                                                        if(i===(option_details.length)-1){
                                                            option_id_data+=option_details[i].option_id;
                                                            option_value_id_data+=option_details[i].option_value_id;
                                                        }
                                                        else {
                                                            option_id_data+=option_details[i].option_id+',';
                                                            option_value_id_data+=option_details[i].option_value_id+',';
                                                        }

                                                    }


                                                }

                                                // $("#result>tbody").append('<tr data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-product_id="'+data.product_id+'"  id="remove'+i+'" class="result-row">' +
                                                //     '<td>'+i+'</td> ' +
                                                //     '<td>'+ data.product_name +'</td>' +
                                                //     '<td>'+ varyasyon_html +'</td>' +
                                                //     '<td>'+units+'</td>' +
                                                //     '<td> <input type="number" class="form-control qty" value="0"></td>' +
                                                //     '<td> <input type="number" class="form-control fire_oran"  value="0"></td>' +
                                                //     '<td> <input type="number" disabled class="form-control fire_miktar"  value="0"></td>' +
                                                //     '<td> <input type="number" disabled class="form-control toplam_miktar"  value="0"></td>' +
                                                //     '<td> <button data-id="'+i+'" class="btn btn-danger recete_item_remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                                //     '</tr>' );
                                                table_product_id_ar.push({
                                                    product_id : data.product_id,
                                                    product_options:data.option_details,
                                                    varyasyon_html:varyasyon_html,
                                                    option_id_data:option_id_data,
                                                    option_value_id_data:option_value_id_data,
                                                });

                                                return false;

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
                                                    content: 'Ürün Daha Önceden Eklenmiştir',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                            }

                                        }
                                    })
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
            }
        });
    })


</script>
