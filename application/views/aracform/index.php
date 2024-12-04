
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Araç Talep Formu</span></h4>
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
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                               class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                               data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="proje_id" name="proje_id" >
                                            <option value="">Proje Seçiniz</option>
                                            <option value="0">Projesizler</option>
                                            <?php foreach (all_projects() as $rows)
                                            {
                                                ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select-box " id="filter_arac_id">
                                            <option value="0">Araç Seçiniz</option>
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
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-warning btn-md" id="change_toplu_status" title="Change Status">Durum</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
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
                                                <th>Resim</th>
                                                <th>Talep Kodu</th>
                                                <th>Plaka No</th>
                                                <th>Araç</th>
                                                <th>Talep Eden</th>
                                                <th>Lokasyon</th>
                                                <th>Başlangıç Tarihi ve Bitiş Tarihi</th>
                                                <th>Durum</th>
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

        var url = '<?php echo base_url() ?>arac/file_handling';

        $(document).ready(function () {
            draw_data()
        });
        function draw_data(start_date='', end_date='',arac_id='',proje_id='') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('aracform/ajax_list')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        proje_id:proje_id,
                        arac_id:arac_id
                    }
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
                        text: '<i class="fa fa-truck"></i> Yeni Araç Talep Et',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni Araç Talep Et',
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
 <div class="form-row">
  <div class="form-group col-md-12">
        <label for="proje_id">Proje Seçiniz</label>
        <select class="form-control select-box pm_zorunlu" id="proje_id">
                <?php foreach (all_projects() as $emp){
        $emp_id=$emp->id;
        $name=$emp->name;
        ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
        </select>
    </div>
    </div>
  <hr>
    <div class="form-row">
    <div class="form-group col-md-3">
      <label for="proje_muduru_id">Talep Eden</label>
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
      <label for="benzin_talebi">Sms Olarak Sürücüye Bildir</label>
      <input type="checkbox" class="form-control" id="surucu_sms_status">
    </div>
       <div class="form-group col-md-6">
      <label for="benzin_talebi">Sms Mesajı</label>
      <input type="text" class="form-control" id="surucu_sms_text">
    </div>
</div>
</form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
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
                                                proje_id:  $('#proje_id').val(),
                                                lokasyon:  $('#lokasyon').val(),
                                                gorev_sebebi:  $('#gorev_sebebi').val(),
                                                start_date:  $('#start_date').val(),
                                                end_date:  $('#end_date').val(),
                                                proje_muduru_id:  $('#proje_muduru_id').val(),
                                                pers_id:  $('#pers_id').val(),
                                                genel_mudur_id:  $('#genel_mudur_id').val(),
                                                teknika_sorumlu_id:  $('#teknika_sorumlu_id').val(),
                                                benzin_talebi:  benzin_talebi,
                                                benzin_miktari:  $('#benzin_miktari').val(),
                                                yemek_talebi:  yemek_talebi,
                                                surucu_sms_status:  surucu_sms_status,
                                                yemek_tutari:  $('#yemek_tutari').val(),
                                                surucu_sms_text:  $('#surucu_sms_text').val(),
                                            }
                                            $.post(baseurl + 'aracform/create_save',data,(response) => {
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


        $(document).on('change', "#benzin_talebi", function (e) {
            let benzin_talebi =$('#benzin_talebi').is(':checked')?1:0;
            if(this.checked) {

                $('#benzin_miktari').attr('disabled',false)
            }
            else {
                $('#benzin_miktari').val(0)
                $('#benzin_miktari').attr('disabled',true)
            }
        });


        $(document).on('change', "#yemek_talebi", function (e) {
            let yemek_talebi =$('#yemek_talebi').is(':checked')?1:0;
            if(this.checked) {

                $('#yemek_tutari').attr('disabled',false)
            }
            else {
                $('#yemek_tutari').val(0)
                $('#yemek_tutari').attr('disabled',true)
            }
        });


        $(document).on('click', ".bildirim_olustur", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-bell',
                type: 'orange',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Oluşturduğunuz Formu Onaya Sunmak Üzeresiniz Emin Misiniz?<p/>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Bildirim Oluştur',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                talep_id: talep_id,
                            }
                            $.post(baseurl + 'aracform/bildirim_olustur',data,(response) => {
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

                    <div class="form-group col-md-12">
                        <label for="proje_id">Proje Seçiniz</label>
                        <select class="form-control select-box pm_zorunlu" id="proje_id">
                          <option value="0">Proje Seçiniz</option>
                                <?php foreach (all_projects() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                <?php } ?>
                        </select>
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
                        $('#proje_id').val(responses.items.proje_id)
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
                                proje_id:  $('#proje_id').val(),
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


        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var arac_id = $('#filter_arac_id').val();
            var proje_id = $('#proje_id').val();
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,arac_id,proje_id);

        });




    </script>
