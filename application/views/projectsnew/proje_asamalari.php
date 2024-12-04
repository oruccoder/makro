<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="col-md-12">
            <table id="asamalar_table" class="table datatable-show-all"
                   cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Aşama Kodu</th>
                    <th>Simeta Kodu</th>
                    <th>Bağlı Olduğu Bölüm</th>
                    <th>Bağlı Olduğu Aşama </th>
                    <th>Aşama Adı</th>
                    <th>Anlık Maliyet</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

    let proje_id = $('#proje_id').val();
    $(document).ready(function () {
        draw_data_asamalar();
    });

    function draw_data_asamalar(){
        $('#asamalar_table').DataTable({

            "processing": true,
            "serverSide": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style',data[10]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projeasamalari/ajax_list')?>",
                "type": "POST",
                data: {'pid':proje_id,'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Aşama Eklae',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Aşama Ekle',
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
                                            <label for="name">Proje Bölümleri</label>
                                            <select class="form-control select-box" id="bolum_id" name="bolum">
                                                <?php foreach (proje_to_bolum($details->prj) as $blm)
                            {
                                $id=$blm->id;
                                $name=$blm->name;
                                echo "<option value='$id'>$name</option>";
                            } ?>
                                            </select>
                                        </div>
                                               <div class="form-group col-md-12">
                                            <label for="name">Aşama Seçiniz</label>
                                                                    <select class="form-control select-box" id="parent_id" name="parent_id">
                                    <?php foreach (all_list_proje_asamalari() as $items){
                                $new_title = parent_asama_kontrol_list($items->id).$items->name;
                                //$new_title = $items->name;
                                echo "<option value='$items->id'>$new_title</option>";
                            } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                          <label for="content">Cari</label>
                                               <select name="customer" class="form-control" id="customer_statement">
                                                    <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box" id="pers_id">
                                                    <?php foreach (all_personel() as $blm)
                            {
                                $id=$blm->id;
                                $name=$blm->name;
                                echo "<option value='$id'>$name</option>";
                            } ?>
                                                </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi">
                                                    <?php
                            foreach (units() as $row) {
                                $id = $row['id'];
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$id'>$title - $cid</option>";
                            }
                            ?>
                                                </select>

                                        </div>
                                    </div>

                                       <div class="form-row">
                                         <div class="form-group col-md-4">
                                          <label for="name">Miktar</label>
                                           <input type="number" class="form-control" name="quantity" id="quantity" value="1">
                                        </div>
                                          <div class="form-group col-md-4">
                                          <label for="name">Birim Fiyatı</label>
                                            <input type="text" class="form-control" name="fiyat" id="fiyat" value="1">
                                        </div>
                                         <div class="form-group col-md-4">
                                          <label for="name">Toplam Fiyatı</label>
                                             <input type="text" class="form-control" name="toplam_fiyat" id="toplam_fiyat">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Bütçe</label>
                                             <input id="butce" name="butce" type="text" class="form-control">
                                        </div>
                                          <div class="form-group col-md-6">
                                          <label for="name">Açıklama</label>
                                            <input type="text" class="form-control" name="content" id="content">
                                        </div>

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
                                            name:  $('#name').val(),
                                            customer:  $('#customer_statement').val(),
                                            content:  $('#content').val(),
                                            bolum:  $('#bolum_id').val(),
                                            parent_id:  $('#parent_id').val(),
                                            pers_id:  $('#pers_id').val(),
                                            butce:  $('#butce').val(),
                                            olcu_birimi:  $('#olcu_birimi').val(),
                                            quantity:  $('#quantity').val(),
                                            fiyat:  $('#fiyat').val(),
                                            toplam_fiyat:  $('#toplam_fiyat').val(),
                                            project:  proje_id
                                        }
                                        $.post(baseurl + 'projeasamalari/create',data,(response) => {
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
                                                                $('#asamalar_table').DataTable().destroy();
                                                                draw_data_asamalar();
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

                                $('#bolum_id').select2().trigger('change');

                                $("#customer_statement").select2({
                                    minimumInputLength: 1,
                                    dropdownParent: $(".jconfirm-box-container"),
                                    tags: false,
                                    ajax: {
                                        url: baseurl + 'search/customer_select',
                                        dataType: 'json',
                                        type: 'POST',
                                        quietMillis: 50,
                                        data: function (customer) {
                                            return {
                                                customer: customer,
                                                '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                                            };
                                        },
                                        processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    return {
                                                        text: item.company,
                                                        id: item.id
                                                    }
                                                })
                                            };
                                        },
                                    }
                                });

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
                    }
                }
            ]

        });
    }



    $(document).on('click','.edit-asama',function (){
        let asama_id =$(this).attr('asama_id');
        let parent_id=0;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Aşama Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Bölümleri</label>
                                            <select class="form-control select-box" id="bolum_id" name="bolum">
                                                <?php foreach (proje_to_bolum($details->prj) as $blm)
                                                {
                                                    $id=$blm->id;
                                                    $name=$blm->name;
                                                    echo "<option value='$id'>$name</option>";
                                                } ?>
                                                </select>
                                        </div>
                                           <div class="form-group col-md-12">
                                         <label for="name">Aşama Seçiniz</label>
                                                                    <select class="form-control select-box" id="parent_id" name="parent_id">
                                    <?php foreach (all_list_proje_asamalari() as $items){
                    $new_title = parent_asama_kontrol_list($items->id).$items->name;
                    //$new_title = $items->name;
                    echo "<option value='$items->id'>$new_title</option>";
                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                          <label for="content">Cari</label>
                                               <select name="customer" class="form-control" id="customer_statement">
                                                    <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box" id="pers_id">
                                                    <?php foreach (all_personel() as $blm)
                {
                    $id=$blm->id;
                    $name=$blm->name;
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi">
                                                    <?php
                foreach (units() as $row) {
                    $id = $row['id'];
                    $cid = $row['code'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title - $cid</option>";
                }
                ?>
                                                </select>

                                        </div>
                                    </div>

                                       <div class="form-row">
                                         <div class="form-group col-md-4">
                                          <label for="name">Miktar</label>
                                           <input type="number" class="form-control" name="quantity" id="quantity" value="1">
                                        </div>
                                          <div class="form-group col-md-4">
                                          <label for="name">Birim Fiyatı</label>
                                            <input type="text" class="form-control" name="fiyat" id="fiyat" value="1">
                                        </div>
                                         <div class="form-group col-md-4">
                                          <label for="name">Toplam Fiyatı</label>
                                             <input type="text" class="form-control" name="toplam_fiyat" id="toplam_fiyat">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Bütçe</label>
                                             <input id="butce" name="butce" type="text" class="form-control">
                                        </div>
                                          <div class="form-group col-md-6">
                                          <label for="name">Açıklama</label>
                                            <input type="text" class="form-control" name="content" id="content">
                                        </div>

                                      </div>
                                    </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    asama_id: asama_id,
                }


                let table_report='';
                $.post(baseurl + 'projeasamalari/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.item.name);
                    $('#butce').val(responses.item.total);
                    $('#content').val(responses.item.exp);

                    parent_id = responses.item.default_proje_asama_id;

                    $('#code').val(responses.item.code);
                    $('#simeta_code').val(responses.item.simeta_code);
                    $('#quantity').val(responses.item.quantity);
                    $('#fiyat').val(responses.item.fiyat);
                    $('#toplam_fiyat').val(responses.item.toplam);
                    $('#customer_statement').append(new Option(responses.customer_details.company, responses.customer_details.customer_id, true, true)).trigger('change');
                    $('#bolum_id').val(responses.item.bolum_id).select2().trigger('change')
                    $('#pers_id').val(responses.item.pers_id).select2().trigger('change')
                    $('#parent_id').val(responses.item.default_proje_asama_id).select2().trigger('change')
                    $('#olcu_birimi').val(responses.item.olcu_birimi).select2().trigger('change')

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
                            asama_id: asama_id,
                            name:  $('#name').val(),
                            customer:  $('#customer_statement').val(),
                            content:  $('#content').val(),
                            bolum:  $('#bolum_id').val(),
                            parent_id:  $('#parent_id').val(),
                            pers_id:  $('#pers_id').val(),
                            butce:  $('#butce').val(),
                            olcu_birimi:  $('#olcu_birimi').val(),
                            quantity:  $('#quantity').val(),
                            fiyat:  $('#fiyat').val(),
                            toplam_fiyat:  $('#toplam_fiyat').val(),
                            simeta_code:  $('#simeta_code').val(),
                            code:  $('#code').val(),
                            project:  proje_id
                        }
                        $.post(baseurl + 'projeasamalari/update',data,(response) => {
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
                                                $('#asamalar_table').DataTable().destroy();
                                                draw_data_asamalar();
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
                }
            },
            onContentReady: function () {

                $('#parent_id').val(parent_id).select2().trigger('change')

                $("#customer_statement").select2({
                    minimumInputLength: 1,
                    dropdownParent: $(".jconfirm-box-container"),
                    tags: false,
                    ajax: {
                        url: baseurl + 'search/customer_select',
                        dataType: 'json',
                        type: 'POST',
                        quietMillis: 50,
                        data: function (customer) {
                            return {
                                customer: customer,
                                '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.company,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    }
                });

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
    $(document).on('click','.delete-asama',function (){
        let asama_id =$(this).attr('asama_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Aşama Sil',
            icon: 'fa fa-trash',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Aşamayı Silmek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            asama_id: asama_id,
                        }
                        $.post(baseurl + 'projeasamalari/delete',data,(response) => {
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
                                                $('#asamalar_table').DataTable().destroy();
                                                draw_data_asamalar();
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

    })


</script>