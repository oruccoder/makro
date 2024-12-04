<?php
?>
<script>

    let talep_durum=0;
    let proje_id=0;
    let bolum_id=0;
    let asama_id=0;
    $.confirm({
        theme: 'modern',
        closeIcon: false,
        title: 'Bilgi',
        icon: 'fas fa-questions',
        type: 'dark',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "small",
        containerFluid: !0,
        smoothContent: true,
        draggable: false,
        content: 'Açılan Stok Kartı Malzeme Talebinde Kullanılacak Mı?'
        buttons: {
            formSubmit: {
                text: 'Evet',
                btnClass: 'btn-blue',
                action: function() {
                    talep_durum=1;
                    $.confirm({
                        theme: 'modern',
                        closeIcon: false,
                        title: 'Proje Bilgileri Giriniz',
                        icon: 'fas fa-questions',
                        type: 'dark',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: ` <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id proje_id_new required" id="proje_id">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                        $emp_id=$emp->id;
                        $name=$emp->code;
                        ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="bolum_id">Proje Bölümü</label>
      <select class="form-control select-box bolum_id_new" id="bolum_id">
            <option value="0">Seçiniz</option>
    </select>
    </div>
    <div class="form-group col-md-6">
      <label for="asama_id">Proje Aşaması</label>
        <select class="form-control select-box asama_id_new" id="asama_id">
           <option value="0">Seçiniz</option>
        </select>

    </div>
</div>`,
                        buttons: {
                            formSubmit: {
                                text: 'Devam',
                                btnClass: 'btn-blue',
                                action: function() {
                                    proje_id=$('.proje_id_new').val();
                                    bolum_id=$('.bolum_id_new').val();
                                    asama_id=$('.asama_id_new').val();
                                    $.confirm({
                                        theme: 'modern',
                                        closeIcon: false,
                                        title: 'Yeni Stok Kartı',
                                        icon: 'fa fa-plus-square 3x',
                                        type: 'dark',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-12 mx-auto",
                                        containerFluid: !0,
                                        smoothContent: true,
                                        draggable: false,
                                        content: `
                                <div class='mb-3'>
                                    <div class="row" style='text-align: justify;'>
                                        <div class="col-md-4" style="height: 790px;border-right: 2px solid gray;">
                                             <div class="col-md-12">
                                                 <div class="row">
                                                    <div class="col-md-6 pb-2">
                                                        <label>Stok Kodu</label>
                                                        <input type="text" class='form-control product_code'>
                                                     </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label>Stok Tipi</label>
                                                        <select class="form-control select-box pro_type">
                                                            <option value='0'>Secin</option>
                                                            <?php
                                        foreach (all_product_type() as $item) {
                                            echo "<option value='$item->id'>$item->name</option>";
                                        }
                                        ?>
                                                        </select>
                                                     </div>
                                                     <div class="col-md-12 pb-2">
                                                        <label>Stok Adı AZ</label>
                                                        <input type="text" class='form-control product_name'>
                                                     </div>
                                                          <div class="col-md-12 pb-2">
                                                        <label>Stok Adı TR</label>
                                                        <input type="text" class='form-control product_name_tr'>
                                                     </div>
                                                          <div class="col-md-12 pb-2">
                                                        <label>Stok Adı EN</label>
                                                        <input type="text" class='form-control product_name_en'>
                                                     </div>
                                                    <div class="col-md-8 pb-2">
                                                        <label>Kısa Tanım</label>
                                                        <input type="text" class='form-control short_name'>
                                                     </div>
                                                    <div class="col-md-4 pb-2">
                                                        <label>Marka</label>
                                                        <input type="text" class='form-control marka'>
                                                    </div>
                                                       <div class="col-md-12 pb-2">
                                                    <hr>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Kalınlık</label>
                                                        <input type="text" class='form-control kalinlik'>
                                                    </div>
                                                      <div class="col-md-3 pb-2">
                                                        <label>En (mm)</label>
                                                        <input type="text" class='form-control en'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Boy (mm)</label>
                                                        <input type="text" class='form-control boy'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Yükseklik (mm)</label>
                                                        <input type="text" class='form-control yukseklik'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Yoğunluk</label>
                                                        <input type="text" class='form-control yogunluk'>
                                                    </div>
                                                      <div class="col-md-3 pb-2">
                                                        <label>İç Çap (mm)</label>
                                                        <input type="text" class='form-control ic_cap'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Dış Çap (mm)</label>
                                                        <input type="text" class='form-control dis_cap'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>t (mm)</label>
                                                        <input type="text" class='form-control t'>
                                                    </div>
                                                    <div class="col-md-12 pb-2">
                                                    <hr>
                                                    </div>
                                                    <div class="col-md-6 pb-2">
                                                        <label>Emniyet Stoğu</label>
                                                        <input type="text" class='form-control emniyet_stok'>
                                                    </div>
                                                      <div class="col-md-6 pb-2">
                                                        <label>Min. Sip. Mik.</label>
                                                        <input type="text" class='form-control min_sip_mik'>
                                                    </div>
                                                     <div class="col-md-4 pb-2">
                                                        <label>Sipariş Katları</label>
                                                        <input type="text" class='form-control siparis_katlari'>
                                                    </div>
                                                      <div class="col-md-4 pb-2">
                                                        <label>İskarta Oranı</label>
                                                        <input type="text" class='form-control iskarta_orani'>
                                                    </div>
                                                      <div class="col-md-4 pb-2">
                                                        <label>Üretim Katsayısı</label>
                                                        <input type="text" class='form-control uretim_katsayisi'>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                             <div class="col-md-4" style="height: 790px;border-right: 2px solid gray;">
                                             <div class="col-md-12">
                                                 <div class="row">

                                                       <div class="col-md-3 pb-2">
                                                        <label>Palet (Euro)</label>
                                                         <input type="text" class='form-control palet'>
                                                     </div>
                                                        <div class="col-md-3 pb-2">
                                                        <label>Denye (Hacim)</label>
                                                         <input type="text" class='form-control denye'>
                                                     </div>
                                                        <div class="col-md-3 pb-2">
                                                        <label>Brüt Ağırlık (Kg/Gr)</label>
                                                         <input type="text" class='form-control brut_agirlik'>
                                                     </div>
                                                        <div class="col-md-3 pb-2">
                                                        <label>Net Ağırlık (Kg/Gr)</label>
                                                         <input type="text" class='form-control net_agirlik'>
                                                     </div>
                                                        <div class="col-md-6 pb-2">
                                                        <label>Gerçek</label>
                                                        <input type="checkbox" class='form-control gercek' style='width: 50px;'>
                                                     </div>
                                                       <div class="col-md-6 pb-2">
                                                        <label>Aktif</label>
                                                        <input type="checkbox" class='form-control status' style='width: 50px;'>
                                                     </div>
                                                     <div class="col-md-12 pb-2"> <hr></div>

                                                    <div class="col-md-6 pb-2">
                                                        <label>Barkod</label>
                                                        <input type="text" class='form-control barcode' disabled>
                                                     </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label>Standart Kod</label>
                                                        <input type="text" class='form-control standart_code'>
                                                     </div>
                                                         <div class="col-md-6 pb-2">
                                                        <label>Özel Kod 1</label>
                                                        <input type="text" class='form-control ozel_kod_1'>
                                                     </div>
                                                           <div class="col-md-6 pb-2">
                                                        <label>Özel Kod 2</label>
                                                        <input type="text" class='form-control ozel_kod_2'>
                                                     </div>
                                                       <div class="col-md-6 pb-2">
                                                        <label>Özel Kod 3</label>
                                                        <input type="text" class='form-control ozel_kod_3'>
                                                     </div>
                                                         <div class="col-md-6 pb-2">
                                                        <label>Baz Miktarı</label>
                                                        <input type="text" class='form-control baz_miktari'>
                                                     </div>
                                                      <div class="col-md-12 pb-2"> <hr></div>

                                                        <div class="col-md-12 pb-2">
                                                        <label>Fire Stok Kodu</label>
                                                        <input type="text" class='form-control fire_stok_kodu'>
                                                     </div>
                                                        <div class="col-md-12 pb-2">
                                                        <label>Malzeme Grubu 1</label>
                                                        <select class="form-control select-box mg_1 category_id">
                                                        <option value='0'>Secin</option>
                                                                                <?php

                                        foreach (category_list_() as $item) :

                                            $id = $item['id'];
                                            $title = $item['title'];
                                            $new_title = _ust_kategori_kontrol($id).$title;
                                            echo "<option value='$id'>$new_title</option>";

                                        endforeach;
                                        ?>
                                                    </select>
                                                     </div>
                                                          <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 2</label>urun
                                                        <input type="text" class='form-control mg_2'>
                                                     </div>
                                                          <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 3</label>
                                                        <input type="text" class='form-control mg_3'>
                                                     </div>
                                                          <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 4</label>
                                                        <input type="text" class='form-control mg_4'>
                                                     </div>
                                                      <div class="col-md-6 pb-2">
                                                        <label>Malzeme Grubu 5</label>
                                                        <input type="text" class='form-control mg_5'>
                                                     </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4" style="height: 790px;border-right: 2px solid gray;">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                           <div class="col-md-6 pb-2">
                                                                <label>Stok Birimi</label>
                                                                 <select class='form-control select-box unit'>
                                                                <?php foreach (units() as $items){
                                            $id=$items['id'];
                                            $name=$items['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                                </select>
                                                             </div>
                                                             <div class="col-md-6 pb-2">
                                                                <label>Birim 2</label>
                                                                <select class='form-control select-box unit_2'>
                                                                    <?php foreach (units() as $items){
                                            $id=$items['id'];
                                            $name=$items['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                                </select>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Satınalma Sipariş Birimi</label>
                                                               <select class='form-control select-box satinalama_siparis_birimi'>
                                                                <?php foreach (units() as $items){
                                            $id=$items['id'];
                                            $name=$items['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                                </select>

                                                             </div>
                                                                 <div class="col-md-6 pb-2">
                                                                <label>Satınalma Kabul Birimi</label>
                                                                    <select class='form-control select-box satinalama_kabul_birimi'>
                                                                    <?php foreach (units() as $items){
                                            $id=$items['id'];
                                            $name=$items['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                                </select>
                                                             </div>
                                                                <div class="col-md-6 pb-2">
                                                                <label>Satış Birimi</label>
                                                                 <select class='form-control select-box satis_birimi'>
                                                                    <?php foreach (units() as $items){
                                            $id=$items['id'];
                                            $name=$items['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                                </select>

                                                             </div>
                                                              <div class="col-md-12 pb-2"> <hr></div>
                                                                <div class="col-md-6 pb-2">
                                                                <label>Temin Türü</label>
                                                                <input type="text" class='form-control temin_turu'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Satınalma Türü</label>
                                                                <input type="text" class='form-control satinalma_turu'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>İmalat Sipariş Birimi</label>
                                                                <input type="text" class='form-control imalat_siparis_birimi'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Rapor Birimi</label>
                                                                <input type="text" class='form-control rapor_birimi'>
                                                             </div>
                                                                 <div class="col-md-6 pb-2">
                                                                <label>Satınalam Süresi</label>
                                                                <input type="text" class='form-control satinalma_suresi'>
                                                             </div>
                                                                 <div class="col-md-6 pb-2">
                                                                <label>İmalat Teda. Süresi</label>
                                                                <input type="text" class='form-control imalat_tedarik_suresi'>
                                                             </div>
                                                              <div class="col-md-12 pb-2"> <hr></div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>KDV</label>
                                                                <input type="text" class='form-control kdv'>
                                                             </div>
                                                              <div class="col-md-6 pb-2">
                                                                <label>Ean</label>
                                                                <input type="text" class='form-control ean'>
                                                             </div>

                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>
                                     </div>
                                     <div class="row" style='text-align: justify;'>
                                       <div class="col-md-12 pb-2">
                                         <hr>
                                     </div>
                                     </div>
                                      <div class="row" style='text-align: justify;'>
                                            <div class="col-md-6 pb-2">
                                            <label>Ürün Aciqlamasi</label>
                                                <textarea type="text" class='form-control product_description'></textarea>
                                          </div>
                                             <div class="col-md-6 pb-2">
                                            <label>Ürün Resmi</label>
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
                                </div>
                                `,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Gondər',
                                                btnClass: 'btn-blue',
                                                action: function() {
                                                    let pro_type = $('.pro_type').val();
                                                    if(!parseInt(pro_type)){
                                                        $.alert({
                                                            theme: 'material',
                                                            icon: 'fa fa-exclamation',
                                                            type: 'red',
                                                            animation: 'scale',
                                                            useBootstrap: true,
                                                            columnClass: "col-md-4 mx-auto",
                                                            title: 'Dikkat!',
                                                            content: 'Ürün Tipi Zorunludur',
                                                            buttons: {
                                                                prev: {
                                                                    text: 'Tamam',
                                                                    btnClass: "btn btn-link text-dark",
                                                                }
                                                            }
                                                        });

                                                        return false;
                                                    }

                                                    let status =$('.status').is(':checked')?1:0;
                                                    let gercek =$('.gercek').is(':checked')?1:0;
                                                    let data_post = {
                                                        crsf_token: crsf_hash,
                                                        product_name: $('.product_name').val(),
                                                        product_name_tr: $('.product_name_tr').val(),
                                                        product_name_en: $('.product_name_en').val(),
                                                        pro_type: $('.pro_type').val(),
                                                        product_description: $('.product_description').val(),
                                                        image: $('#image_text').val(),
                                                        product_code:$('.product_code').val(),
                                                        short_name:$('.short_name').val(),
                                                        marka:$('.marka').val(),
                                                        kalinlik:$('.kalinlik').val(),
                                                        en:$('.en').val(),
                                                        boy:$('.boy').val(),
                                                        yukseklik:$('.yukseklik').val(),
                                                        yogunluk:$('.yogunluk').val(),
                                                        ic_cap:$('.ic_cap').val(),
                                                        dis_cap:$('.dis_cap').val(),
                                                        t:$('.t').val(),
                                                        emniyet_stok:$('.emniyet_stok').val(),
                                                        min_sip_mik:$('.min_sip_mik').val(),
                                                        siparis_katlari:$('.siparis_katlari').val(),
                                                        iskarta_orani:$('.iskarta_orani').val(),
                                                        uretim_katsayisi:$('.uretim_katsayisi').val(),
                                                        palet:$('.palet').val(),
                                                        denye:$('.denye').val(),
                                                        brut_agirlik:$('.brut_agirlik').val(),
                                                        net_agirlik:$('.net_agirlik').val(),
                                                        gercek:gercek,
                                                        status:status,
                                                        barcode:$('.barcode').val(),
                                                        standart_code:$('.standart_code').val(),
                                                        ozel_kod_1:$('.ozel_kod_1').val(),
                                                        ozel_kod_2:$('.ozel_kod_2').val(),
                                                        ozel_kod_3:$('.ozel_kod_3').val(),
                                                        baz_miktari:$('.baz_miktari').val(),
                                                        fire_stok_kodu:$('.fire_stok_kodu').val(),
                                                        mg_1:$('.mg_1').val(),
                                                        mg_2:$('.mg_2').val(),
                                                        mg_3:$('.mg_3').val(),
                                                        mg_4:$('.mg_4').val(),
                                                        mg_5:$('.mg_5').val(),
                                                        unit:$('.unit').val(),
                                                        unit_2:$('.unit_2').val(),
                                                        satinalama_siparis_birimi:$('.satinalama_siparis_birimi').val(),
                                                        satinalama_kabul_birimi:$('.satinalama_kabul_birimi').val(),
                                                        satis_birimi:$('.satis_birimi').val(),
                                                        temin_turu:$('.temin_turu').val(),
                                                        satinalma_turu:$('.satinalma_turu').val(),
                                                        imalat_siparis_birimi:$('.imalat_siparis_birimi').val(),
                                                        rapor_birimi:$('.rapor_birimi').val(),
                                                        satinalma_suresi:$('.satinalma_suresi').val(),
                                                        imalat_tedarik_suresi:$('.imalat_tedarik_suresi').val(),
                                                        kdv:$('.kdv').val(),
                                                        ean:$('.ean').val()


                                                        // demirbas_id: $('#demirbas_id').val(),
                                                        // simeta_product_name: $('.simeta_product_name').val(),
                                                        // simeta_code: $('.simeta_code').val(),
                                                        // category_id: $('.category_id').val(),



                                                    }

                                                    $.post(baseurl + 'urun/create', data_post, (response) => {
                                                        let data = jQuery.parseJSON(response);
                                                        if (data.status == 200) {
                                                            $.alert({
                                                                theme: 'modern',
                                                                icon: 'fa fa-check',
                                                                type: 'green',
                                                                animation: 'scale',
                                                                useBootstrap: true,
                                                                columnClass: "col-md-4 mx-auto",
                                                                title: 'Başarılı',
                                                                content: data.message,
                                                                buttons: {
                                                                    prev: {
                                                                        text: 'Tamam',
                                                                        btnClass: "btn btn-link text-dark",
                                                                        action: function() {
                                                                            table_product_id_ar = [];
                                                                            let cat_id = $('#category_id_search').val();
                                                                            $('#product_table').DataTable().destroy();
                                                                            draw_data(cat_id);
                                                                        }
                                                                    }
                                                                }
                                                            });

                                                        } else if (data.status == 410) {
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
                                                    })
                                                }
                                            },
                                            cancel: {
                                                text: 'İmtina et',
                                                btnClass: "btn btn-danger btn-sm",
                                                action: function() {
                                                    table_product_id_ar = [];
                                                }
                                            }
                                        },
                                        onContentReady: function() {

                                            $('#fileupload_').fileupload({
                                                url: baseurl + 'urun/file_handling',
                                                dataType: 'json',
                                                formData: {
                                                    '<?= $this->security->get_csrf_token_name() ?>': crsf_hash,
                                                    'path': '/userfiles/product/'
                                                },
                                                done: function(e, data) {
                                                    var img = 'default.png';
                                                    $.each(data.result.files, function(index, file) {
                                                        img = file.name;
                                                    });

                                                    $('#image_text').val(img);
                                                },
                                                progressall: function(e, data) {
                                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                                    $('#progress .progress-bar').css(
                                                        'width',
                                                        progress + '%'
                                                    );
                                                }
                                            }).prop('disabled', !$.support.fileInput)
                                                .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                            // bind to events

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

                                }
                            },
                            cancel: {
                                text: 'İptal',
                                btnClass: "btn btn-danger btn-sm",
                                action: function() {
                                    return false;
                                }
                            }
                        },

                        onContentReady: function() {

                        }
                    });

                }
            },
            cancel: {
                text: 'Hayır',
                btnClass: "btn btn-danger btn-sm",
                action: function() {

                }
            }
        },

        onContentReady: function() {

        }
    });
</script>
