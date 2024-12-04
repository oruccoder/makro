<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $name; ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="invoices" class="table datatable-responsive"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Talep Eden Personel</th>
                        <th>Araç Talep No</th>
                        <th>Etibarname</th>
                        <th>Muqavele</th>
                        <th>Sürücü Belgesi</th>
                        <th>Durum</th>
                        <th>İşlem</th>

                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Talep Eden Personel</th>
                        <th>Araç Talep No</th>
                        <th>Etibarname</th>
                        <th>Muqavele</th>
                        <th>Sürücü Belgesi</th>
                        <th>Durum</th>
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
                "autoWidth": false,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('driver/ajax_list')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'arac_id':<?=$id?>}
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
            });
        }




        $(document).on('click', ".belge_talep", function (e) {
            let type = $(this).attr('filetype');
            let pers_id = $(this).attr('pers_id');
            let arac_suruculeri_id = $(this).attr('arac_suruculeri_id');
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
                    '<p>Personelden Eksik Belge Talep Edilecektir Emin Misiniz?<p/>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Bildirim Oluştur',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                type: type,
                                pers_id: pers_id,
                                arac_suruculeri_id: arac_suruculeri_id,
                            }
                            $.post(baseurl + 'driver/belge_bildirim_olustur',data,(response) => {
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

        $(document).on('click', ".status_change", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Durum',
                icon: 'fa fa-signal',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<div class="form-group col-md-12">
      <label for="firma_id">Status</label>
     <select class="form-control select-box required" id="status">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (surucu_status_result() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>`,
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-success',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                talep_id: talep_id,
                                status: $('#status').val(),
                            }
                            $.post(baseurl + 'driver/status_change',data,(response) => {
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

        $(document).on('click', ".arac_atama", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Atama',
                icon: 'fa fa-truck',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<div class="form-group col-md-12">
      <label for="arac_id">Talebin Atanacağı Araç</label>
     <select class="form-control select-box required" id="arac_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (araclar_list(3) as $emp){
                $emp_id=$emp->id;
                $name=$emp->name.'-'.$emp->plaka;
                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>`,
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-success',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                talep_id: talep_id,
                                arac_id: $('#arac_id').val(),
                            }
                            $.post(baseurl + 'driver/arac_change',data,(response) => {
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
                            <input type="datetime-local" class="form-control" id="start_date">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Bitiş Tarihi ve Saati</label>
                            <input type="datetime-local" class="form-control" id="end_date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="benzin_talebi">Benzin Talebi</label>
                            <input type="checkbox" class="form-control" id="benzin_talebi">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="benzin_miktari">Benzin Miktarı (Azn)</label>
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
                            <div class="form-group col-md-4">
                                <label for="proje_muduru_id">Proje Müdürü</label>
                                <select class="form-control select-box required" id="proje_muduru_id">
                                    <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="genel_mudur_id">Genel Müdür</label>
                                <select class="form-control select-box required" id="genel_mudur_id">
                                    <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
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
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {
                            let benzin_talebi =$('#benzin_talebi').is(':checked')?1:0;

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
                                benzin_talebi:  benzin_talebi,
                                benzin_miktari:  $('#benzin_miktari').val(),
                                yemek_talebi:  yemek_talebi,
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

        $(document).on('click','.view_talep_form',function (){
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
                            <input type="datetime-local" disabled class="form-control" id="start_date">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Bitiş Tarihi ve Saati</label>
                            <input type="datetime-local" disabled class="form-control" id="end_date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="benzin_talebi">Benzin Talebi</label>
                            <input type="checkbox" disabled class="form-control" id="benzin_talebi">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="benzin_miktari">Benzin Miktarı (Azn)</label>
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
