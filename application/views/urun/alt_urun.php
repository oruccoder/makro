<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Ürünler</span></h4>
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
                            <fieldset class="mb-3 col-md-12">
                                <div class="form-group row">
                                    <div class="col col-sm-8 col-md-8">
                                        <select class="form-control select2" id="category_id_search">
                                            <option value="0">Ürün Grupları</option>
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
                                    <div class="col col-sm-2 col-md-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
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
                                        <table id="product_table" class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <th width="130">Resim</th>
                                                <th>Kodu</th>
                                                <th>Ürün adi az</th>
                                                <th>Ürün adi tr</th>
                                                <th>Ürün adi en</th>
                                                <th>kateqori</th>
                                                <th>Ürün tipi</th>
                                                <th>Varyant Değerleri</th>

                                                <th>Barkod</th>
                                                <th>Action</th>
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


<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script src="<?php echo base_url('app-assets/products/js/products.js?v='.rand(11111,99999)) ?>"></script>

<script>

    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:

    });

    $(document).ready(function (){
        draw_data()
    })


    function draw_data(category_id=0) {
        $('#product_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style', data[11]);
            },
            responsive: true,
            "autoWidth": false,
            'order': [],
            'ajax': {
                'url': baseurl+'urun/ajax_list_alt',
                'type': 'POST',
                'data': {
                    'category_id':category_id,
                    'parent_id': "<?php echo isset($_GET['parent_id'])?$_GET['parent_id']:''; ?>",
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                }
            },
            'columnDefs': [{
                'targets': [],
                'orderable': false,
            }, ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: '0,1,2,3,5,6'
                    }
                },
            ],
            initComplete: function (settings, json) {

            }
        });
    }



    $('#search').click(function () {
        var category_id = $('#category_id_search').val();
        $('#product_table').DataTable().destroy();
        draw_data(category_id);
    });


    $(document).on('click','.tags_button',function (){
        let product_id = $(this).attr('product_id');
        let tag_value = $(this).attr('tag_value');
        let types = $(this).attr('types');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Etiketleri',
            icon: 'fas fa-tag 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<span>Kelimeleri Virgülle Ayırınız</span><form>
<textarea class="form-control tag">`+tag_value+`</textarea>
</form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {
                        let data_post = {
                            tag: $('.tag').val(),
                            product_id: product_id,
                            types: types,
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'urun/update_tag', data_post, (response) => {
                            // console.log(data_post)
                            let data = jQuery.parseJSON(response);
                            if (data.code == 200) {
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
                                                $('#product_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        },
                                    }
                                });
                            }
                            else if (data.code == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
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
        })
    })
    //$(document).on('click', '.stock_view', function() {
    //    let product_stock_code_id = $(this).attr('product_stock_id');
    //    let product_id = $(this).attr('product_id');
    //    let id = 0;
    //    $.confirm({
    //        theme: 'modern',
    //        closeIcon: false,
    //        title: 'Alt Ürün Stok Kartı',
    //        icon: 'fas fa-retweet 3x',
    //        type: 'dark',
    //        animation: 'scale',
    //        useBootstrap: true,
    //        columnClass: "col-md-12 mx-auto",
    //        containerFluid: !0,
    //        smoothContent: true,
    //        draggable: false,
    //        content: function() {
    //            let self = this;
    //            let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
    //            let responses;
    //            html+= ` <div class='mb-3'>
    //                                <div class="row" style='text-align: justify;'>
    //                                    <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
    //                                         <div class="col-md-12">
    //                                             <div class="row">
    //                                                <div class="col-md-6 pb-2">
    //                                                    <label>Stok Kodu</label>
    //                                                    <input type="text"  class='form-control product_code' disabled>
    //                                                 </div>
    //                                                 <div class="col-md-6 pb-2">
    //                                                    <label>Stok Tipi</label>
    //                                                    <select class="form-control select-box pro_type">
    //                                                        <option value='0'>Secin</option>
    //                                                        <?php
    //            foreach (all_product_type() as $item) {
    //                echo "<option value='$item->id'>$item->name</option>";
    //            }
    //            ?>
    //                                                    </select>
    //                                                 </div>
    //                                                 <div class="col-md-12 pb-2">
    //                                                    <label>Stok Adı AZ</label>
    //                                                    <input type="text" class='form-control product_name'>
    //                                                 </div>
    //                                                      <div class="col-md-12 pb-2">
    //                                                    <label>Stok Adı TR</label>
    //                                                    <input type="text" class='form-control product_name_tr'>
    //                                                 </div>
    //                                                      <div class="col-md-12 pb-2">
    //                                                    <label>Stok Adı EN</label>
    //                                                    <input type="text" class='form-control product_name_en'>
    //                                                 </div>
    //                                                <div class="col-md-8 pb-2">
    //                                                    <label>Kısa Tanım</label>
    //                                                    <input type="text" class='form-control short_name'>
    //                                                 </div>
    //                                                <div class="col-md-4 pb-2">
    //                                                    <label>Marka</label>
    //                                                    <input type="text" class='form-control marka'>
    //                                                </div>
    //                                                   <div class="col-md-12 pb-2">
    //
    //                                                </div>
    //                                                <div class="col-md-12 pb-2 degisken_varyant">
    //                                                </div>
    //                                                <hr>
    //
    //                                                <div class="col-md-3 pb-2">
    //                                                    <label>Yoğunluk</label>
    //                                                    <input type="text" class='form-control yogunluk'>
    //                                                </div>
    //                                                  <div class="col-md-3 pb-2">
    //                                                    <label>İç Çap (mm)</label>
    //                                                    <input type="text" class='form-control ic_cap'>
    //                                                </div>
    //                                                <div class="col-md-3 pb-2">
    //                                                    <label>Dış Çap (mm)</label>
    //                                                    <input type="text" class='form-control dis_cap'>
    //                                                </div>
    //                                                <div class="col-md-3 pb-2">
    //                                                    <label>t (mm)</label>
    //                                                    <input type="text" class='form-control t'>
    //                                                </div>
    //                                                  <hr>
    //
    //                                                    <div class="col-md-6 pb-2">
    //                                                    <label>Çap 1</label>
    //                                                    <input type="text" class='form-control capone'>
    //                                                </div>
    //                                                 <div class="col-md-6 pb-2">
    //                                                    <label>Çap 2</label>
    //                                                    <input type="text" class='form-control captwo'>
    //                                                </div>
    //                                                <div class="col-md-12 pb-2">
    //                                                <hr>
    //                                                </div>
    //                                                <div class="col-md-6 pb-2">
    //                                                    <label>Emniyet Stoğu</label>
    //                                                    <input type="text" class='form-control emniyet_stok'>
    //                                                </div>
    //                                                  <div class="col-md-6 pb-2">
    //                                                    <label>Min. Sip. Mik.</label>
    //                                                    <input type="text" class='form-control min_sip_mik'>
    //                                                </div>
    //                                                 <div class="col-md-4 pb-2">
    //                                                    <label>Sipariş Katları</label>
    //                                                    <input type="text" class='form-control siparis_katlari'>
    //                                                </div>
    //                                                  <div class="col-md-4 pb-2">
    //                                                    <label>İskarta Oranı</label>
    //                                                    <input type="text" class='form-control iskarta_orani'>
    //                                                </div>
    //                                                  <d    iv class="col-md-4 pb-2">
    //                                                    <label>Üretim Katsayısı</label>
    //                                                    <input type="text" class='form-control uretim_katsayisi'>
    //                                                </div>
    //                                            </div>
    //                                        </div>
    //                                         <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
    //                                         <div class="col-md-12">
    //                                             <div class="row">
    //
    //                                                   <div class="col-md-3 pb-2">
    //                                                    <label>Palet (Euro)</label>
    //                                                     <input type="text" class='form-control palet'>
    //                                                 </div>
    //                                                    <div class="col-md-3 pb-2">
    //                                                    <label>Denye (Hacim)</label>
    //                                                     <input type="text" class='form-control denye'>
    //                                                 </div>
    //                                                    <div class="col-md-3 pb-2">
    //                                                    <label>Brüt Ağırlık (Kg/Gr)</label>
    //                                                     <input type="text" class='form-control brut_agirlik'>
    //                                                 </div>
    //                                                    <div class="col-md-3 pb-2">
    //                                                    <label>Net Ağırlık (Kg/Gr)</label>
    //                                                     <input type="text" class='form-control net_agirlik'>
    //                                                 </div>
    //                                                    <div class="col-md-6 pb-2">
    //                                                    <label>Gerçek</label>
    //                                                    <input type="checkbox" class='form-control gercek' style='width: 50px;'>
    //                                                 </div>
    //                                                   <div class="col-md-6 pb-2">
    //                                                    <label>Aktif</label>
    //                                                    <input type="checkbox" class='form-control status' style='width: 50px;'>
    //                                                 </div>
    //                                                 <div class="col-md-12 pb-2"> <hr></div>
    //
    //                                                <div class="col-md-6 pb-2">
    //                                                    <label>Barkod</label>
    //                                                    <input type="text" class='form-control barcode' disabled>
    //                                                 </div>
    //                                                 <div class="col-md-6 pb-2">
    //                                                    <label>Standart Kod</label>
    //                                                    <input type="text" class='form-control standart_code'>
    //                                                 </div>
    //                                                     <div class="col-md-6 pb-2">
    //                                                    <label>Özel Kod 1</label>
    //                                                    <input type="text" class='form-control ozel_kod_1'>
    //                                                 </div>
    //                                                       <div class="col-md-6 pb-2">
    //                                                    <label>Özel Kod 2</label>
    //                                                    <input type="text" class='form-control ozel_kod_2'>
    //                                                 </div>
    //                                                   <div class="col-md-6 pb-2">
    //                                                    <label>Özel Kod 3</label>
    //                                                    <input type="text" class='form-control ozel_kod_3'>
    //                                                 </div>
    //                                                     <div class="col-md-6 pb-2">
    //                                                    <label>Baz Miktarı</label>
    //                                                    <input type="text" class='form-control baz_miktari'>
    //                                                 </div>
    //                                                  <div class="col-md-12 pb-2"> <hr></div>
    //
    //                                                    <div class="col-md-12 pb-2">
    //                                                    <label>Fire Stok Kodu</label>
    //                                                    <input type="text" class='form-control fire_stok_kodu'>
    //                                                 </div>
    //                                                    <div class="col-md-12 pb-2">
    //                                                    <label>Malzeme Grubu 1</label>
    //                                                    <select class="form-control select-box mg_1 category_id">
    //                                                    <option value='0'>Secin</option>
    //                                                                            <?php
    //
    //            foreach (category_list_() as $item) :
    //
    //                $id = $item['id'];
    //                $title = $item['title'];
    //                $new_title = _ust_kategori_kontrol($id).$title;
    //                echo "<option value='$id'>$new_title</option>";
    //
    //            endforeach;
    //            ?>
    //                                                </select>
    //                                                 </div>
    //                                                      <div class="col-md-6 pb-2">
    //                                                    <label>Malzeme Grubu 2</label>
    //                                                    <input type="text" class='form-control mg_2'>
    //                                                 </div>
    //                                                      <div class="col-md-6 pb-2">
    //                                                    <label>Malzeme Grubu 3</label>
    //                                                    <input type="text" class='form-control mg_3'>
    //                                                 </div>
    //                                                      <div class="col-md-6 pb-2">
    //                                                    <label>Malzeme Grubu 4</label>
    //                                                    <input type="text" class='form-control mg_4'>
    //                                                 </div>
    //                                                  <div class="col-md-6 pb-2">
    //                                                    <label>Malzeme Grubu 5</label>
    //                                                    <input type="text" class='form-control mg_5'>
    //                                                 </div>
    //                                                 <div class="col-md-12 pb-2">
    //                                                    <label>Ürün Etiketleri(Virgülle Ayırınız)</label>
    //                                                    <textarea type="text" class='form-control tag'></textarea>
    //                                                 </div>
    //                                                </div>
    //                                                </div>
    //                                            </div>
    //                                             <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
    //                                                <div class="col-md-12">
    //                                                    <div class="row">
    //                                                       <div class="col-md-6 pb-2">
    //                                                            <label>Stok Birimi</label>
    //                                                             <select class='form-control select-box unit'>
    //                                                            <?php //foreach (units() as $items){
    //                $id=$items['id'];
    //                $name=$items['name'];
    //                echo "<option value='$id'>$name</option>";
    //            } ?>
    //                                                            </select>
    //                                                         </div>
    //                                                         <div class="col-md-6 pb-2">
    //                                                            <label>Birim 2</label>
    //                                                            <select class='form-control select-box unit_2'>
    //                                                                <?php //foreach (units() as $items){
    //                $id=$items['id'];
    //                $name=$items['name'];
    //                echo "<option value='$id'>$name</option>";
    //            } ?>
    //                                                            </select>
    //                                                         </div>
    //                                                          <div class="col-md-6 pb-2">
    //                                                            <label>Satınalma Sipariş Birimi</label>
    //                                                           <select class='form-control select-box satinalama_siparis_birimi'>
    //                                                            <?php //foreach (units() as $items){
    //                $id=$items['id'];
    //                $name=$items['name'];
    //                echo "<option value='$id'>$name</option>";
    //            } ?>
    //                                                            </select>
    //
    //                                                         </div>
    //                                                             <div class="col-md-6 pb-2">
    //                                                            <label>Satınalma Kabul Birimi</label>
    //                                                                <select class='form-control select-box satinalama_kabul_birimi'>
    //                                                                <?php //foreach (units() as $items){
    //                $id=$items['id'];
    //                $name=$items['name'];
    //                echo "<option value='$id'>$name</option>";
    //            } ?>
    //                                                            </select>
    //                                                         </div>
    //                                                            <div class="col-md-6 pb-2">
    //                                                            <label>Satış Birimi</label>
    //                                                             <select class='form-control select-box satis_birimi'>
    //                                                                <?php //foreach (units() as $items){
    //                $id=$items['id'];
    //                $name=$items['name'];
    //                echo "<option value='$id'>$name</option>";
    //            } ?>
    //                                                            </select>
    //
    //                                                         </div>
    //                                                          <div class="col-md-12 pb-2"> <hr></div>
    //                                                            <div class="col-md-6 pb-2">
    //                                                            <label>Temin Türü</label>
    //                                                            <input type="text" class='form-control temin_turu'>
    //                                                         </div>
    //                                                          <div class="col-md-6 pb-2">
    //                                                            <label>Satınalma Türü</label>
    //                                                            <input type="text" class='form-control satinalma_turu'>
    //                                                         </div>
    //                                                          <div class="col-md-6 pb-2">
    //                                                            <label>İmalat Sipariş Birimi</label>
    //                                                            <input type="text" class='form-control imalat_siparis_birimi'>
    //                                                         </div>
    //                                                          <div class="col-md-6 pb-2">
    //                                                            <label>Rapor Birimi</label>
    //                                                            <input type="text" class='form-control rapor_birimi'>
    //                                                         </div>
    //                                                             <div class="col-md-6 pb-2">
    //                                                            <label>Satınalam Süresi</label>
    //                                                            <input type="text" class='form-control satinalma_suresi'>
    //                                                         </div>
    //                                                             <div class="col-md-6 pb-2">
    //                                                            <label>İmalat Teda. Süresi</label>
    //                                                            <input type="text" class='form-control imalat_tedarik_suresi'>
    //                                                         </div>
    //                                                          <div class="col-md-12 pb-2"> <hr></div>
    //                                                          <div class="col-md-6 pb-2">
    //                                                            <label>KDV</label>
    //                                                            <input type="text" class='form-control kdv'>
    //                                                         </div>
    //                                                          <div class="col-md-6 pb-2">
    //                                                            <label>Ean</label>
    //                                                            <input type="text" class='form-control ean'>
    //                                                         </div>
    //
    //                                                    </div>
    //                                                </div>
    //                                             </div>
    //                                        </div>
    //                                 </div>
    //                                 <div class="row" style='text-align: justify;'>
    //                                   <div class="col-md-12 pb-2">
    //                                     <hr>
    //                                 </div>
    //                                 </div>
    //                                  <div class="row" style='text-align: justify;'>
    //                                        <div class="col-md-6 pb-2">
    //                                        <label>Ürün Aciqlamasi</label>
    //                                            <textarea type="text" class='form-control product_description'></textarea>
    //                                      </div>
    //                                         <div class="col-md-6 pb-2">
    //                                         <label for="resim">Resim</label>
    //                               <div>
    //                                 <img class="myImg update_image" style="width: 322px;">
    //                               </di>
    //                                 <div id="progress" class="progress">
    //                                      <div class="progress-bar progress-bar-success"></div>
    //                                 </div>
    //                                  <table id="files" class="files"></table><br>
    //
    //                                  <span class="btn btn-success fileinput-button" style="width: 100%">
    //                                  <i class="glyphicon glyphicon-plus"></i>
    //
    //                                  <span>Seçiniz...</span>
    //                                  <input id="fileupload_update_parent" type="file" name="files[]">
    //
    //                                  <input type="hidden" class="image_text_update_parent" name="image_text_update_parent" id="image_text_update_parent">
    //                                      </div>
    //                                  </div>
    //                            </div>
    //                            `;
    //            let data = {
    //                crsf_token: crsf_hash,
    //                product_stock_code_id: product_stock_code_id
    //            }
    //
    //            let table_report = '';
    //            $.post(baseurl + 'urun/parent_info', data, (response) => {
    //
    //
    //                self.$content.find('#person-list').empty().append(html);
    //                let responses = jQuery.parseJSON(response);
    //
    //                $('.product_description').val(responses.details_items[0].product_des)
    //                $('#image_text_update_parent').val(responses.details_items[0].image);
    //                $('.update_image').attr('src', baseurl + '' + responses.details_items[0].image);
    //                $(".product_code").val(responses.code);
    //                $(".pro_type").val(responses.details_items[0].product_type);
    //                $(".product_name").val(responses.details_items[0].product_name);
    //                $(".product_name_tr").val(responses.details_items[0].product_name_tr);
    //                $(".product_name_en").val(responses.details_items[0].product_name_en);
    //                $(".short_name").val(responses.details_items[0].short_name);
    //                $(".marka").val(responses.details_items[0].marka);
    //                $(".kalinlik").val(responses.details_items[0].kalinlik);
    //                $(".en").val(responses.details_items[0].en);
    //                $(".boy").val(responses.details_items[0].boy);
    //                $(".yukseklik").val(responses.details_items[0].yukseklik);
    //                $(".yogunluk").val(responses.details_items[0].yogunluk);
    //                $(".ic_cap").val(responses.details_items[0].ic_cap);
    //                $(".dis_cap").val(responses.details_items[0].dis_cap);
    //                $(".t").val(responses.details_items[0].t);
    //                $(".emniyet_stok").val(responses.details_items[0].alert);
    //                $(".min_sip_mik").val(responses.details_items[0].min_sip_mik);
    //                $(".siparis_katlari").val(responses.details_items[0].siparis_katlari);
    //                $(".iskarta_orani").val(responses.details_items[0].iskarta_orani);
    //                $(".uretim_katsayisi").val(responses.details_items[0].uretim_katsayisi);
    //                $(".palet").val(responses.details_items[0].palet);
    //                $(".denye").val(responses.details_items[0].denye);
    //                $(".brut_agirlik").val(responses.details_items[0].brut_agirlik);
    //                $(".net_agirlik").val(responses.details_items[0].net_agirlik);
    //
    //                $(".en2").val(responses.details_items[0].en2);
    //                $(".t2").val(responses.details_items[0].t2);
    //                $(".1magirlik").val(responses.details_items[0].magirlik);
    //                $(".l").val(responses.details_items[0].l);
    //                $(".capone").val(responses.details_items[0].capone);
    //                $(".captwo").val(responses.details_items[0].captwo);
    //
    //                if(responses.details_items[0].status==1){
    //                    $('.status').click()
    //                }
    //                else {
    //                    $('.status').prop('checked',false);
    //                }
    //
    //                if(responses.details_items[0].gercek==1){
    //                    $('.gercek').click()
    //                }
    //                else {
    //                    $('.gercek').prop('checked',false);
    //                }
    //
    //
    //
    //                $(".barcode").val(responses.details_items[0].barcode);
    //                $(".standart_code").val(responses.details_items[0].standart_code);
    //                $(".ozel_kod_1").val(responses.details_items[0].ozel_kod_1);
    //                $(".ozel_kod_2").val(responses.details_items[0].ozel_kod_2);
    //                $(".ozel_kod_3").val(responses.details_items[0].ozel_kod_3);
    //                $(".baz_miktari").val(responses.details_items[0].baz_miktari);
    //                $(".fire_stok_kodu").val(responses.details_items[0].fire_stok_kodu);
    //                $(".mg_1").val(responses.details_items[0].mg_1);
    //                $(".mg_2").val(responses.details_items[0].mg_2);
    //                $(".mg_3").val(responses.details_items[0].mg_3);
    //                $(".mg_4").val(responses.details_items[0].mg_4);
    //                $(".mg_5").val(responses.details_items[0].mg_5);
    //                $(".tag").val(responses.details_items[0].tag);
    //                $(".tag").val(responses.details_items[0].tag);
    //                $(".unit").val(responses.details_items[0].unit);
    //                $(".unit_2").val(responses.details_items[0].unit_2);
    //                $(".satinalama_siparis_birimi").val(responses.details_items[0].satinalama_siparis_birimi);
    //                $(".satinalama_kabul_birimi").val(responses.details_items[0].satinalama_kabul_birimi);
    //                $(".satis_birimi").val(responses.details_items[0].satis_birimi);
    //                $(".temin_turu").val(responses.details_items[0].temin_turu);
    //                $(".satinalma_turu").val(responses.details_items[0].satinalma_turu);
    //                $(".imalat_siparis_birimi").val(responses.details_items[0].imalat_siparis_birimi);
    //                $(".rapor_birimi").val(responses.details_items[0].rapor_birimi);
    //                $(".satinalma_suresi").val(responses.details_items[0].satinalma_suresi);
    //                $(".imalat_tedarik_suresi").val(responses.details_items[0].imalat_tedarik_suresi);
    //                $(".kdv").val(responses.details_items[0].taxrate);
    //                $(".ean").val(responses.details_items[0].ean);
    //                $(".product_description").val(responses.details_items[0].product_des);
    //                $(".image_text").val(responses.details_items[0].image_text);
    //
    //
    //                id =responses.details_items[0].id
    //
    //                // $(".pro_type").val(responses.details_items[0].product_type) $('.simeta_product_name').val(responses.details_items[0].simeta_product_name)
    //                // $('.simeta_code').val(responses.details_items[0].simeta_code)
    //                // $("#demirbas_id").val(responses.details_items[0].demirbas_id)
    //                $('.degisken_varyant').empty().append(responses.varyant_degerleri);
    //
    //            });
    //            self.$content.find('#person-list').empty().append(html);
    //
    //
    //            return $('#person-container').html();
    //        },
    //
    //        buttons: {
    //            formSubmit: {
    //                text: 'Güncelle',
    //                btnClass: 'btn-blue',
    //                action: function() {
    //
    //                    let status =$('.status').is(':checked')?1:0;
    //                    let gercek =$('.gercek').is(':checked')?1:0;
    //                    let data_post = {
    //                        id: id,
    //                        product_stock_code_id: product_stock_code_id,
    //                        product_id: product_id,
    //                        crsf_token: crsf_hash,
    //                        product_name: $('.product_name').val(),
    //                        product_name_tr: $('.product_name_tr').val(),
    //                        product_name_en: $('.product_name_en').val(),
    //                        pro_type: $('.pro_type').val(),
    //                        product_description: $('.product_description').val(),
    //                        image: $('#image_text_update').val(),
    //                        product_code:$('.product_code').val(),
    //                        short_name:$('.short_name').val(),
    //                        marka:$('.marka').val(),
    //                        kalinlik:$('.kalinlik').val(),
    //                        en:$('.en').val(),
    //                        boy:$('.boy').val(),
    //                        yukseklik:$('.yukseklik').val(),
    //                        yogunluk:$('.yogunluk').val(),
    //                        ic_cap:$('.ic_cap').val(),
    //                        dis_cap:$('.dis_cap').val(),
    //                        t:$('.t').val(),
    //                        emniyet_stok:$('.emniyet_stok').val(),
    //                        min_sip_mik:$('.min_sip_mik').val(),
    //                        siparis_katlari:$('.siparis_katlari').val(),
    //                        iskarta_orani:$('.iskarta_orani').val(),
    //                        uretim_katsayisi:$('.uretim_katsayisi').val(),
    //                        palet:$('.palet').val(),
    //                        denye:$('.denye').val(),
    //                        brut_agirlik:$('.brut_agirlik').val(),
    //                        net_agirlik:$('.net_agirlik').val(),
    //                        gercek:gercek,
    //                        status: status,
    //                        barcode:$('.barcode').val(),
    //                        standart_code:$('.standart_code').val(),
    //                        ozel_kod_1:$('.ozel_kod_1').val(),
    //                        ozel_kod_2:$('.ozel_kod_2').val(),
    //                        ozel_kod_3:$('.ozel_kod_3').val(),
    //                        baz_miktari:$('.baz_miktari').val(),
    //                        fire_stok_kodu:$('.fire_stok_kodu').val(),
    //                        mg_1:$('.mg_1').val(),
    //                        mg_2:$('.mg_2').val(),
    //                        mg_3:$('.mg_3').val(),
    //                        mg_4:$('.mg_4').val(),
    //                        mg_5:$('.mg_5').val(),
    //                        tag:$('.tag').val(),
    //                        unit:$('.unit').val(),
    //                        unit_2:$('.unit_2').val(),
    //                        satinalama_siparis_birimi:$('.satinalama_siparis_birimi').val(),
    //                        satinalama_kabul_birimi:$('.satinalama_kabul_birimi').val(),
    //                        satis_birimi:$('.satis_birimi').val(),
    //                        temin_turu:$('.temin_turu').val(),
    //                        satinalma_turu:$('.satinalma_turu').val(),
    //                        imalat_siparis_birimi:$('.imalat_siparis_birimi').val(),
    //                        rapor_birimi:$('.rapor_birimi').val(),
    //                        satinalma_suresi:$('.satinalma_suresi').val(),
    //                        imalat_tedarik_suresi:$('.imalat_tedarik_suresi').val(),
    //                        kdv:$('.kdv').val(),
    //                        ean:$('.ean').val(),
    //                        // crsf_token: crsf_hash,
    //                        // product_name: $('.product_name').val(),
    //                        // simeta_product_name: $('.simeta_product_name').val(),
    //                        // simeta_code: $('.simeta_code').val(),
    //                        // category_id: $('.category_id').val(),
    //                        // product_description: $('.product_description').val(),
    //                        // pro_type: $('.pro_type').val(),
    //                         image: $('#image_text_update_parent').val(),
    //                        // demirbas_id: $('#demirbas_id').val()
    //                    }
    //
    //
    //                    $.post(baseurl + 'urun/update_parent', data_post, (response) => {
    //                        // console.log(data_post)
    //                        let data = jQuery.parseJSON(response);
    //                        if (data.status == 200) {
    //                            $.alert({
    //                                theme: 'modern',
    //                                icon: 'fa fa-check',
    //                                type: 'green',
    //                                animation: 'scale',
    //                                useBootstrap: true,
    //                                columnClass: "col-md-4 mx-auto",
    //                                title: 'Başarılı',
    //                                content: data.message,
    //                                buttons: {
    //                                    prev: {
    //                                        text: 'Tamam',
    //                                        btnClass: "btn btn-link text-dark",
    //                                        action: function() {
    //                                            table_product_id_ar = [];
    //                                            $('#product_table').DataTable().destroy();
    //                                            draw_data();
    //                                        }
    //                                    },
    //                                }
    //                            });
    //                        }
    //                        else if (data.status == 410) {
    //                            $.alert({
    //                                theme: 'modern',
    //                                icon: 'fa fa-exclamation',
    //                                type: 'red',
    //                                animation: 'scale',
    //                                useBootstrap: true,
    //                                columnClass: "col-md-4 mx-auto",
    //                                title: 'Dikkat!',
    //                                content: data.message,
    //                                buttons: {
    //                                    prev: {
    //                                        text: 'Tamam',
    //                                        btnClass: "btn btn-link text-dark",
    //                                    }
    //                                }
    //                            });
    //                        }
    //                    })
    //                }
    //            },
    //            cancel: {
    //                text: 'İmtina et',
    //                btnClass: "btn btn-danger btn-sm",
    //                action: function() {
    //                    table_product_id_ar = [];
    //                }
    //            }
    //        },
    //
    //        onContentReady: function() {
    //
    //            $('#fileupload_update_parent').fileupload({
    //                url: baseurl + 'urun/file_handling',
    //                dataType: 'json',
    //                formData: {
    //                    '<?php //= $this->security->get_csrf_token_name() ?>//': crsf_hash,
    //                    'path': '/userfiles/product/'
    //                },
    //                done: function(e, data) {
    //                    var img = 'default.png';
    //                    $.each(data.result.files, function(index, file) {
    //                        img = file.name;
    //                    });
    //
    //                    $('#image_text_update_parent').val('/userfiles/product/' + img);
    //                },
    //                progressall: function(e, data) {
    //                    var progress = parseInt(data.loaded / data.total * 100, 10);
    //                    $('#progress .progress-bar').css(
    //                        'width',
    //                        progress + '%'
    //                    );
    //                }
    //            }).prop('disabled', !$.support.fileInput)
    //                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    //
    //
    //            $('.select-box').select2({
    //                dropdownParent: $(".jconfirm-box-container")
    //            })
    //            // bind to events
    //            var jc = this;
    //            this.$content.find('form').on('submit', function(e) {
    //                // if the user submits the form by pressing enter in the field.
    //                e.preventDefault();
    //                jc.$$formSubmit.trigger('click'); // reference the button and click it
    //            });
    //        }
    //    });
    //})
    $(document).on('click', '.edit', function() {
        let product_id = $(this).attr('product_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Düzenle',
            icon: 'fas fa-retweet 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function() {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+= `
                                <div class='mb-3'>
                                    <div class="row" style='text-align: justify;'>
                                        <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
                                             <div class="col-md-12">
                                                 <div class="row">
                                                    <div class="col-md-6 pb-2">
                                                        <label>Stok Kodu</label>
                                                        <input type="text"  class='form-control product_code'>
                                                     </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label><span class="req">*</span>Stok Tipi</label>
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

                                                    <hr>

                                                        <div class="col-md-3 pb-2">
                                                        <label>Kalınlık (T2)</label>
                                                        <input type="text" class='form-control t2'>
                                                    </div>
                                                      <div class="col-md-3 pb-2">
                                                        <label>En 2 (mm)</label>
                                                        <input type="text" class='form-control en2'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>Boy L (cm)</label>
                                                        <input type="text" class='form-control l'>
                                                    </div>
                                                    <div class="col-md-3 pb-2">
                                                        <label>1 Metre Ağırlık</label>
                                                        <input type="text" class='form-control 1magirlik'>
                                                    </div>
                                                    <hr>

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
                                                      <hr>

                                                        <div class="col-md-6 pb-2">
                                                        <label>Çap 1</label>
                                                        <input type="text" class='form-control capone'>
                                                    </div>
                                                     <div class="col-md-6 pb-2">
                                                        <label>Çap 2</label>
                                                        <input type="text" class='form-control captwo'>
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
                                             <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
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
                                                        <label>Malzeme Grubu 2</label>
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
                                                     <div class="col-md-12 pb-2">
                                                        <label>Ürün Etiketleri(Virgülle Ayırınız)</label>
                                                        <textarea type="text" class='form-control tag'></textarea>
                                                     </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4" style="height: 990px;border-right: 2px solid gray;">
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
                                      </div>
                                </div>
                                `;
                let data = {
                    crsf_token: crsf_hash,
                    product_id: product_id
                }

                let table_report = '';
                $.post(baseurl + 'urun/info', data, (response) => {

                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);


                    $('.product_description').val(responses.details_items[0].product_des)
                    $('#image_text_update').val(responses.details_items[0].image);
                    $('.update_image').attr('src', baseurl + '' + responses.details_items[0].image);
                    $(".product_code").val(responses.details_items[0].product_code);
                    $(".pro_type").val(responses.details_items[0].product_type);
                    $(".product_name").val(responses.details_items[0].product_name);
                    $(".product_name_tr").val(responses.details_items[0].product_name_tr);
                    $(".product_name_en").val(responses.details_items[0].product_name_en);
                    $(".short_name").val(responses.details_items[0].short_name);
                    $(".marka").val(responses.details_items[0].marka);
                    $(".kalinlik").val(responses.details_items[0].kalinlik);
                    $(".en").val(responses.details_items[0].en);
                    $(".boy").val(responses.details_items[0].boy);
                    $(".yukseklik").val(responses.details_items[0].yukseklik);
                    $(".yogunluk").val(responses.details_items[0].yogunluk);
                    $(".ic_cap").val(responses.details_items[0].ic_cap);
                    $(".dis_cap").val(responses.details_items[0].dis_cap);
                    $(".t").val(responses.details_items[0].t);
                    $(".emniyet_stok").val(responses.details_items[0].alert);
                    $(".min_sip_mik").val(responses.details_items[0].min_sip_mik);
                    $(".siparis_katlari").val(responses.details_items[0].siparis_katlari);
                    $(".iskarta_orani").val(responses.details_items[0].iskarta_orani);
                    $(".uretim_katsayisi").val(responses.details_items[0].uretim_katsayisi);
                    $(".palet").val(responses.details_items[0].palet);
                    $(".denye").val(responses.details_items[0].denye);
                    $(".brut_agirlik").val(responses.details_items[0].brut_agirlik);
                    $(".net_agirlik").val(responses.details_items[0].net_agirlik);

                    $(".en2").val(responses.details_items[0].en2);
                    $(".t2").val(responses.details_items[0].t2);
                    $(".1magirlik").val(responses.details_items[0].magirlik);
                    $(".l").val(responses.details_items[0].l);
                    $(".capone").val(responses.details_items[0].capone);
                    $(".captwo").val(responses.details_items[0].captwo);

                    if(responses.details_items[0].status==1){
                        $('.status').click()
                    }
                    else {
                        $('.status').prop('checked',false);
                    }

                    if(responses.details_items[0].gercek==1){
                        $('.gercek').click()
                    }
                    else {
                        $('.gercek').prop('checked',false);
                    }



                    $(".barcode").val(responses.details_items[0].barcode);
                    $(".standart_code").val(responses.details_items[0].standart_code);
                    $(".ozel_kod_1").val(responses.details_items[0].ozel_kod_1);
                    $(".ozel_kod_2").val(responses.details_items[0].ozel_kod_2);
                    $(".ozel_kod_3").val(responses.details_items[0].ozel_kod_3);
                    $(".baz_miktari").val(responses.details_items[0].baz_miktari);
                    $(".fire_stok_kodu").val(responses.details_items[0].fire_stok_kodu);
                    $(".mg_1").val(responses.details_items[0].mg_1);
                    $(".mg_2").val(responses.details_items[0].mg_2);
                    $(".mg_3").val(responses.details_items[0].mg_3);
                    $(".mg_4").val(responses.details_items[0].mg_4);
                    $(".mg_5").val(responses.details_items[0].mg_5);
                    $(".tag").val(responses.details_items[0].tag);
                    $(".unit").val(responses.details_items[0].unit);
                    $(".unit_2").val(responses.details_items[0].unit_2);
                    $(".satinalama_siparis_birimi").val(responses.details_items[0].satinalama_siparis_birimi);
                    $(".satinalama_kabul_birimi").val(responses.details_items[0].satinalama_kabul_birimi);
                    $(".satis_birimi").val(responses.details_items[0].satis_birimi);
                    $(".temin_turu").val(responses.details_items[0].temin_turu);
                    $(".satinalma_turu").val(responses.details_items[0].satinalma_turu);
                    $(".imalat_siparis_birimi").val(responses.details_items[0].imalat_siparis_birimi);
                    $(".rapor_birimi").val(responses.details_items[0].rapor_birimi);
                    $(".satinalma_suresi").val(responses.details_items[0].satinalma_suresi);
                    $(".imalat_tedarik_suresi").val(responses.details_items[0].imalat_tedarik_suresi);
                    $(".kdv").val(responses.details_items[0].taxrate);
                    $(".ean").val(responses.details_items[0].ean);
                    $(".product_description").val(responses.details_items[0].product_des);
                    $(".image_text").val(responses.details_items[0].image_text);



                    // $(".pro_type").val(responses.details_items[0].product_type) $('.simeta_product_name').val(responses.details_items[0].simeta_product_name)
                    // $('.simeta_code').val(responses.details_items[0].simeta_code)
                    // $("#demirbas_id").val(responses.details_items[0].demirbas_id)


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function() {

                        let status =$('.status').is(':checked')?1:0;
                        let gercek =$('.gercek').is(':checked')?1:0;
                        let data_post = {
                            product_id: product_id,
                            crsf_token: crsf_hash,
                            product_name: $('.product_name').val(),
                            product_name_tr: $('.product_name_tr').val(),
                            product_name_en: $('.product_name_en').val(),
                            pro_type: $('.pro_type').val(),
                            product_description: $('.product_description').val(),
                            image: $('#image_text_update').val(),
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
                            status: status,
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
                            tag:$('.tag').val(),
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
                            // crsf_token: crsf_hash,
                            // product_name: $('.product_name').val(),
                            // simeta_product_name: $('.simeta_product_name').val(),
                            // simeta_code: $('.simeta_code').val(),
                            // category_id: $('.category_id').val(),
                            // product_description: $('.product_description').val(),
                            // pro_type: $('.pro_type').val(),
                            // image: $('#image_text_update').val(),
                            // demirbas_id: $('#demirbas_id').val()
                        }


                        $.post(baseurl + 'urun/update', data_post, (response) => {
                            // console.log(data_post)
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
                                                $('#product_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        },
                                    }
                                });
                            }
                            else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
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

                $('#fileupload_update').fileupload({
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

                        $('#image_text_update').val('/userfiles/product/' + img);
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



                $('.product').select2({
                    dropdownParent: $(".jconfirm-box-container"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder: 'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method: 'POST',
                        url:  baseurl+'product/info',
                        dataType: 'json',
                        data: function(params) {
                            let query = {
                                crsf_token: crsf_hash,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(data) {
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
                }).on('change', function(data) {})

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

    $(document).on('click','.eye',function (){
        let product_id =$(this).attr('product_id')
        let product_name ='';
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Detaylar',
            icon: 'fa fa-warehouse',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_history_details">'+
                    '</div>' +
                    '</form>';

                let data = {
                    product_id: product_id,
                }

                let table_report='';
                $.post(baseurl + 'products/product_name',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    product_name = responses.product_name;
                    table_report =`<div style="padding-bottom: 10px;"></div>
                        <table id="invoices_report_details"  class="table" style="width:100%;">
<input type="hidden" id="prd_name" value="`+product_name+`">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Depo</th>
                            <th>Varyasyon</th>
                            <th>Stok Miktarı</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history_details').empty().html(table_report);
                    draw_data_report_details(product_id);
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

            }
        });
    })

    function draw_data_report_details(product_id) {

        $('#invoices_report_details').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('warehouse/ajax_list_product_varyant_details_all')?>",
                'type': 'POST',
                'data': {
                    'warehouse_id': 0,
                    'product_id':product_id
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
                    messageTop: "<div>",
                    extend: 'print',
                    title: '<h3 style="text-align: center">'+$('#prd_name').val()+'</h3>',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2,3,4,5,6]
                    }
                }
            ],
        });
    }
</script>
