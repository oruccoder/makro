
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Üretim Reçeteleri</span></h4>
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
                                        <table id="invoices" class="table datatable-show-all"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Kodu</th>
                                                <th>Adı</th>
                                                <th>Oluşturma Tarihi</th>
                                                <th>Üretilen Ürün</th>
                                                <th>İşlem</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

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

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    let table_product_id_ar = [];
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
                'url': "<?php echo site_url('uretim/ajax_list')?>",
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
                    text: '<i class="fa fa-plus"></i> Yeni Reçete Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Reçete Əlavə Edin ',
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
   <div class="form-group col-md-12">
      <label for="name">Reçete Adı</label>
     <input type='text' class='form-control' id='recete_adi' name='recete_adi'>
    </div>
        <div class="form-group col-md-12">
      <label for="name">Reçete Tipi</label>
      <select class="form-control select-box recete_tipi project required" id="recete_tipi">
                <option value="71">İş Kalemi Reçetesi</option>
                <option value="11">Sifariş Reçetesi</option>

            </select>
    </div>
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id project required" id="project">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->code;
                            ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
    <div class="form-group col-md-12">
      <label for="name">Üretilecek Ürün</label>
      <select class="form-control product_id required" id="product_id">
                <option value="0">Seçiniz</option>

            </select>
    </div>
    <div class="form-group col-md-12">
      <label for="name">Ürün Birimi</label>
      <select class="form-control  uretim_unit_id required" id="uretim_unit_id">
                       <?php foreach (units() as $row) {
                                $id = $row['id'];
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$id'>$title</option>";
                            }
                            ?>

            </select>
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Fayl</label>
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
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sorğunu Açın',
                                    btnClass: 'btn-blue',
                                    action: function () {


                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            recete_adi:  $('#recete_adi').val(),
                                            recete_tipi:  $('#recete_tipi').val(),
                                            proje_id:  $('#project').val(),
                                            warehouse_id:  $('#warehouse').val(),
                                            desc:  $('#desc').val(),
                                            product_id:  $('#product_id').val(),
                                            product_details:  table_product_id_ar,
                                            image_text:  $('#image_text').val(),
                                            uretim_unit_id:  $('#uretim_unit_id').val(),
                                        }
                                        $.post(baseurl + 'uretim/create_save',data,(response) => {
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
                                                                location.href = responses.index
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
                            },
                            onContentReady: function () {


                                $('.product_id').select2({
                                    dropdownParent: $(".jconfirm-box-container"),
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
                                                warehouse_id: 0,
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
                                })

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



    $(document).on('change','#product_id',function(){

        let product_id = $(this).val();
        let warehouse = $("#warehouse").val();
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
                    crsf_token: crsf_hash,
                    product_id: product_id
                }

                let table_report='';
                $.post(baseurl + 'uretim/get_product_to_value',data,(response) => {
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
                        else {


                        }
                        table_product_id_ar.push({product_id : product_id,product_options:option_details });
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
    $(document).on('change','.warehouse', function () {

        let id = $('.warehouse').val();
        if(parseInt(id)){
            $('#product_id').attr('disabled',false);
        }
        else {
            $('#product_id').attr('disabled',true);
        }
    })





    $(document).on('click', ".talep_sil", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Oluşturduğunuz Formu İptal Etmek Üzeresiniz Emin Misiniz?<p/>' +
                '</div>' +
                '<div class="form-group">' +
                '<input id="desc" class="form-control">' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-red',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id: talep_id,
                        }
                        $.post(baseurl + 'aracform/iptal_et',data,(response) => {
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
        let talep_id =$(this).attr('talep_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Araç Talep Formunu Düzenle',
            icon: 'fa fa-pen',
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
                        <label for="arac_id">Talep Edilen Araç</label>
                    <select class="form-control select-box firma_id required" id="arac_id">
                        <option value="0">Seçiniz</option>
                        <?php foreach (araclar_list(3) as $emp){
                $emp_id=$emp->id;
                $plaka=$emp->plaka;
                $name=$emp->name;
                ?>
                        <option value="<?php echo $emp_id; ?>"><?php echo $name.'-'.$plaka; ?></option>
                        <?php } ?>
                    </select>
                </div>
                </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lokasyon">Lokasyon</label>
                            <input type="text" class="form-control" id="lokasyon" placeholder="Bakü-Gence">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gorev_sebebi">Görev Sebebi</label>
                            <input type="text" class="form-control" id="gorev_sebebi" placeholder="ABC Müşterisi İle Görüşme">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Başlangıç Tarihi ve Saati</label>

                              <input type='text' class='datetime_pickers form-control start_date' id='start_date'>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Bitiş Tarihi ve Saati</label>

                              <input type='text' class='datetime_pickers form-control end_date' id='end_date'>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="benzin_talebi">Benzin Talebi</label>
                            <input type="checkbox" class="form-control" id="benzin_talebi">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="benzin_miktari">Benzin Miktarı (AZN)</label>
                            <input type="number" disabled class="form-control" id="benzin_miktari">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="yemek_talebi">Yemek Talebi</label>
                            <input type="checkbox" class="form-control" id="yemek_talebi">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="yemek_tutari">Yemek Ücreti (AZN)</label>
                            <input type="number" disabled class="form-control" id="yemek_tutari">
                        </div>
                    </div>
                    <hr>
                        <div class="form-row">
                              <div class="form-group col-md-3">
                                <label for="pers_id">Talep Eden Personel</label>
                                <select class="form-control select-box required" id="pers_id">
                                    <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="proje_muduru_id">Ofis Menejeri</label>
                                <select class="form-control select-box required" id="proje_muduru_id">
                                    <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="genel_mudur_id">Finans Müdürü</label>
                                <select class="form-control select-box required" id="genel_mudur_id">
                                    <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="teknika_sorumlu_id">Teknika Sorumlusu</label>
                                <select class="form-control select-box required" id="teknika_sorumlu_id">
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
                        <div class="form-group col-md-6">
                          <label for="surucu_sms_status">Sms Olarak Sürücüye Bildir</label>
                          <input type="checkbox" class="form-control" id="surucu_sms_status">
                        </div>
                           <div class="form-group col-md-6">
                          <label for="surucu_sms_text">Sms Mesajı</label>
                          <input type="text" class="form-control" id="surucu_sms_text">
                        </div>
                    </div>
                    </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    talep_id: talep_id,
                }

                let table_report='';
                $.post(baseurl + 'aracform/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#arac_id').val(responses.items.arac_id).select2().trigger('change');
                    $('#lokasyon').val(responses.items.lokasyon)
                    $('#gorev_sebebi').val(responses.items.gorev_sebebi)
                    $('#start_date').val(responses.items.start_date)
                    $('#end_date').val(responses.items.end_date)
                    $('#surucu_sms_text').val(responses.items.surucu_sms_text)
                    if(responses.items.benzin_talebi==1){
                        $('#benzin_talebi').click()
                    }

                    if(responses.items.surucu_sms_status==1){
                        $('#surucu_sms_status').click()
                    }
                    else {
                        $('#benzin_talebi').prop('checked',false)
                    }
                    if(responses.items.yemek_talebi==1){
                        $('#yemek_talebi').click()
                    }
                    else {
                        $('#yemek_talebi').prop('checked',false)
                    }
                    $('#benzin_miktari').val(responses.items.benzin_miktari)
                    $('#yemek_tutari').val(responses.items.yemek_tutari)


                    $('#pers_id').val(responses.items.user_id).select2().trigger('change');
                    $('#proje_muduru_id').val(responses.users[0].user_id).select2().trigger('change');
                    $('#genel_mudur_id').val(responses.users[1].user_id).select2().trigger('change');
                    $('#teknika_sorumlu_id').val(responses.users[2].user_id).select2().trigger('change');
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let benzin_talebi =$('#benzin_talebi').is(':checked')?1:0;
                        let surucu_sms_status =$('#surucu_sms_status').is(':checked')?1:0;

                        let benzin_miktari=0;
                        let yemek_tutari=0;
                        if(benzin_talebi==1){
                            benzin_miktari=$('#benzin_miktari').val();
                        }

                        let yemek_talebi =$('#yemek_talebi').is(':checked')?1:0;

                        if(yemek_talebi==1){
                            yemek_tutari=$('#yemek_tutari').val();
                        }

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            arac_id:  $('#arac_id').val(),
                            talep_id:  talep_id,
                            lokasyon:  $('#lokasyon').val(),
                            gorev_sebebi:  $('#gorev_sebebi').val(),
                            start_date:  $('#start_date').val(),
                            end_date:  $('#end_date').val(),
                            proje_muduru_id:  $('#proje_muduru_id').val(),
                            genel_mudur_id:  $('#genel_mudur_id').val(),
                            teknika_sorumlu_id:  $('#teknika_sorumlu_id').val(),
                            pers_id:  $('#pers_id').val(),
                            benzin_talebi:  benzin_talebi,
                            benzin_miktari:  $('#benzin_miktari').val(),
                            yemek_talebi:  yemek_talebi,
                            surucu_sms_status:  surucu_sms_status,
                            surucu_sms_text:  $('#surucu_sms_text').val(),
                            yemek_tutari:  $('#yemek_tutari').val(),
                        }
                        $.post(baseurl + 'aracform/update_save',data,(response) => {
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
                $('.datetime_pickers').datetimepicker({
                    dayOfWeekStart : 1,
                    lang:'tr',
                });


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
    $(document).on('click','.view',function (){
        let talep_id =$(this).attr('talep_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Araç Talep Formunu Detayları',
            icon: 'fa fa-eye',
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
                        <label for="arac_id">Talep Edilen Araç</label>
                        <input type="text" class="form-control" disabled id="arac_id">
                </div>
                </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lokasyon">Lokasyon</label>
                            <input type="text" class="form-control" disabled id="lokasyon">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gorev_sebebi">Görev Sebebi</label>
                            <input type="text" class="form-control" disabled id="gorev_sebebi">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Başlangıç Tarihi ve Saati</label>
                             <input type='text' class='datetime_pickers form-control start_date' id='start_date'>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Bitiş Tarihi ve Saati</label>
                             <input type='text' class='datetime_pickers form-control end_date' id='end_date'>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="benzin_talebi">Benzin Talebi</label>
                            <input type="checkbox" disabled class="form-control" id="benzin_talebi">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="benzin_miktari">Benzin Miktarı (AZN)</label>
                            <input type="number" disabled class="form-control" id="benzin_miktari">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="yemek_talebi">Yemek Talebi</label>
                            <input type="checkbox" disabled class="form-control" id="yemek_talebi">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="yemek_tutari">Yemek Ücreti (AZN)</label>
                            <input type="number" disabled class="form-control" id="yemek_tutari">
                        </div>
                    </div>
                    <hr>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="proje_muduru_id">Ofis Menejeri</label>
                                <select disabled class="form-control select-box required" id="proje_muduru_id">
                                    <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="genel_mudur_id">Finans Müdürü</label>
                                <select disabled class="form-control select-box required" id="genel_mudur_id">
                                    <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                                <div class="form-group col-md-3">
                                <label for="teknika_sorumlu_id">Teknika Sorumlusu</label>
                                <select disabled class="form-control select-box required" id="teknika_sorumlu_id">
                                    <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                             <div class="form-group col-md-3">
                                <label for="proje_id">Proje Seçiniz</label>
                                <select disabled class="form-control select-box pm_zorunlu" id="proje_id">
                                  <option value="0">Proje Seçiniz</option>
                                        <?php foreach (all_projects() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                </select>
                            </div>



                        </div>
                    </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    talep_id: talep_id,
                }

                let table_report='';
                $.post(baseurl + 'aracform/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#arac_id').val(responses.items.arac_name);

                    $('#lokasyon').val(responses.items.lokasyon)
                    $('#gorev_sebebi').val(responses.items.gorev_sebebi)
                    $('#start_date').val(responses.items.start_date)
                    $('#end_date').val(responses.items.end_date)
                    if(responses.items.proje_id){
                        $('#proje_id').val(responses.items.proje_id).select2().trigger('change');
                    }
                    if(responses.items.benzin_talebi==1){
                        $('#benzin_talebi').click()
                    }
                    else {
                        $('#benzin_talebi').prop('checked',false)
                    }
                    if(responses.items.yemek_talebi==1){
                        $('#yemek_talebi').click()
                    }
                    else {
                        $('#yemek_talebi').prop('checked',false)
                    }
                    $('#benzin_miktari').val(responses.items.benzin_miktari)
                    $('#yemek_tutari').val(responses.items.yemek_tutari)


                    $('#proje_muduru_id').val(responses.users[0].user_id).select2().trigger('change');

                    $('#genel_mudur_id').val(responses.users[1].user_id).select2().trigger('change');
                    $('#teknika_sorumlu_id').val(responses.users[2].user_id).select2().trigger('change');
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-warning",
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
