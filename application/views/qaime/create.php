<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yeni Qaime</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="content" id="content">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 row">
                    <div class="col-md-6"> <!-- Cari Bilgileri -->
                        <div class="form-group row">
                            <div class="frmSearch col-sm-6">
                                <label class="caption">Cari Seçiniz</label><span class='text-danger'>*</span>
                                <select class="select-box form-control required" name="customer_id" id="customer_id">
                                    <option value="">Cari Seçiniz</option>
                                    <?php foreach (all_customer() as $customer_item){
                                        echo '<option value="'.$customer_item->id.'">'.$customer_item->company.'</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="frmSearch col-sm-6">
                                <label class="caption">Proje</label><span class='text-danger'>*</span>
                                <select class="form-control select-box required" name="proje_id" id="proje_id">
                                    <option value="">Seçiniz</option>
                                    <?php foreach (all_projects() as $project){ ?>
                                        <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="frmSearch col-sm-6">
                                <label for="toAddInfo" class="caption">Bölüm Seçiniz</label>
                                <select name="bolum_id" class="form-control select-box" id="bolum_id">
                                    <option value="0">Seçiniz</option>
                                </select>
                            </div>

                            <div class="frmSearch col-sm-6">
                                <label for="toAddInfo" class="caption">Aşama Seçiniz</label>
                                <select name="asama_id" class="form-control select-box" id="asama_id">
                                    <option value="0">Seçiniz</option>
                                </select>
                            </div>

                            <div class="frmSearch col-sm-6">
                                <label for="toAddInfo" class="caption">Nakliye Talep Formu</label>
                                <select id="search_input_nakliye" class="form-control select-box" multiple name="search_input_nakliye[]">
                                </select>
                            </div>
                            <div class="frmSearch col-sm-6">
                                <label for="toAddInfo" class="caption">Forma2 Listesi</label>
                                <select id="forma_2_id" class="form-control select-box" multiple name="forma_2_id[]">
                                </select>
                            </div>
                            <div class="frmSearch col-sm-12">
                                <label for="toAddInfo" class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                <textarea class="form-control required" name="notes" rows="2" id="notes">Açıklama Girilmemiştir</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"  style="border-left: 1px solid gray"> <!-- Fatura Bilgileri -->
                        <div class="form-group row">
                            <div class="frmSearch col-sm-3">
                                <label for="invocieno" class="caption"><?php echo $this->lang->line('Invoice Number') ?></label><span class='text-danger'>*</span>
                                <input type="text" class="zorunlu form-control required" placeholder="Invoice #" name="invoice_no" id="invoice_no">
                            </div>
                            <div class="frmSearch col-sm-3">
                                <label for="invocieno" class="caption">Referans</label>
                                <input type="text" class="form-control  " placeholder="Reference #" name="refer" id="refer">
                            </div>
                            <div class="frmSearch col-sm-3">
                                <label for="invocieno" class="caption">Fatura Tarihi</label><span class='text-danger'>*</span>
                                <input type="date" class="form-control  required" placeholder="Fatura Tarihi" name="invoicedate" id="invoice_date">
                            </div>
                            <div class="frmSearch col-sm-3">
                                <label for="invocieno" class="caption">Ödeme Vade Tarihi</label>
                                <input type="date" class="form-control " placeholder="Fatura Tarihi" name="invocieduedate" id="invocieduedate">
                            </div>
                            <div class="frmSearch col-sm-3">
                                <label for="invocieno" class="caption">Alt Firma</label>
                                <select name="alt_cari_id" id="alt_cari_id" class="form-control select-box">
                                    <?php
                                    echo "<option value='0'>Seçiniz</option>";
                                    foreach (all_customer()  as $row) {
                                        $cid = $row->id;
                                        $title = $row->company;
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="frmSearch col-sm-3">
                                <label for="invocieno" class="caption">Para Birimi</label>
                                <select name="para_birimi" id="para_birimi" class="form-control">
                                    <?php
                                    foreach (para_birimi()  as $row) {
                                        $cid = $row['id'];
                                        $title = $row['code'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="frmSearch col-sm-2">
                                <label for="invocieno" class="caption">Kur Değeri</label>
                                <input type="text" class="form-control required" placeholder="Kur" name="kur_degeri" id="kur_degeri" value="1">
                            </div>

                            <div class="frmSearch col-sm-2">
                                <label for="invocieno" class="caption">KDV</label>
                                <select class="form-control" id="taxformat">
                                    <option value="0">Hariç</option>
                                    <option value="1">Dahil</option>
                                </select>
                            </div>
                            <div class="frmSearch col-sm-2">
                                <label for="invocieno" class="caption">KDV Oran</label>
                                <input type="text" class="form-control required"  name="kdv_oran" id="kdv_oran" value="18">

                            </div>
                            <div class="frmSearch col-sm-6">
                                <label for="invocieno" class="caption">İskonto Tipi</label>
                                <select class="form-control " id="discount_format" name="discount_format">
                                    <?php echo " <option  value='%'>Yüzde (%)</option>
                                        <option selected value='flat'>Sabit</option>";
                                    ?>
                                </select>
                            </div>
                            <div class="frmSearch col-sm-6">
                                <label for="invocieno" class="caption">İskonto</label>
                                <input type="number" class="form-control discount_rate" value="0" placeholder="İndirim"  name="discount_rate" id="discount_rate"
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-12 row">

                    <table class="table table-bordered" id="product_table">
                        <thead>
                        <tr>
                            <th>Sıra</th>
                            <th>Mahsul</th>
                            <th>Vahid Qiymet</th>
                            <th>Miqdar</th>
                            <th>Ölçü Vahidi</th>
                            <th>Edv Oran</th>
                            <th>Endirim Oran</th>
                            <th>Cemi</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>1</th>
                            <th><select class="form-control select-box product_name" style="width: 550px"></select>
                                <input type='hidden' class='product_stock_code_id_input'>
                                <input type='hidden' class='product_demirbas_id'>
                            </th>
                            <th><input class="form-control product_price" type="number"></th>
                            <th><input class="form-control product_qty" value="1" min="1" type="number"></th>
                            <th><select class="select2 form-control product_unit_id select-box" style="max-width: 250px">
                                    <?php foreach (units() as $unit_item){
                                        echo '<option value="'.$unit_item['id'].'">'.$unit_item['name'].'</option>';
                                    } ?>
                                </select>
                            </th>
                            <th><input class="form-control edv_oran" value="18" type="number"></th>
                            <th><input class="form-control indirim_oran" value="0" min="0" type="number"></th>
                            <th><input class="form-control cemi_edvsiz" disabled type="number"></th>
                            <th> <button class="btn btn-success new_add_line"><i class="fa fa-plus"></i></button></th>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="7" class="text-right">Ara Toplam:</th>
                            <th id="ara_toplam">0</th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-right">Toplam İndirim:</th>
                            <th id="indirim_toplami">0</th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-right">Net Toplam:</th> <!-- indirimden sonraki toplam -->
                            <th id="net_toplami">0</th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-right">KDV Toplamı:</th>
                            <th id="kdv_toplami">0</th>
                        </tr>
                        <tr>
                            <th colspan="7" class="text-right">Genel Toplam:</th>
                            <th id="genel_toplam">0</th>
                        </tr>
                        <tr>
                            <th colspan="8" class="text-center"><button type="button" class="btn btn-info" id="create_form"><i class="fa fa-save"></i> Qaime Oluştur</button></th>
                        </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?=$invoice_type_id?>" id="invoice_type_id">
<style>
    .frmSearch {
        padding-bottom: 15px;
    }
    select.is-invalid {
        border-color: #dc3545 !important; /* Kırmızı kenarlık */
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25); /* Hafif kırmızı gölge */
    }

    select.is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

</style>

<script>
    $(document).ready(function () {
        $('.select-box').select2();
        // Yeni Satır Ekle Butonu
        $('.new_add_line').on('click', function () {
            let rowCount = $('#product_table tbody tr').length + 1;
            let newRow = `
        <tr>
            <td>${rowCount}</td>
                            <th><select class="form-control select-box product_name" style="width: 550px"></select>
                            <input type='hidden' class='product_stock_code_id_input'>
                            <input type='hidden' class='product_demirbas_id'>
                            </th>
            <td><input class="form-control product_price" type="number"></td>
            <td><input class="form-control product_qty" value='1' type="number"></td>
            <td>
                <select class="form-control product_unit_id" style="max-width: 250px">
                    <?php foreach (units() as $unit_item){
                echo '<option value="'.$unit_item['id'].'">'.$unit_item['name'].'</option>';
            } ?>
                </select>
            </td>
            <td><input class="form-control edv_oran" value='18' type="number"></td>
            <td><input class="form-control indirim_oran" value='0' type="number"></td>
            <td><input class="form-control cemi_edvsiz" disabled type="number"></td>
            <td><button class="btn btn-danger btn-sm remove_row"><i class="fa fa-trash"></i></button></td>
        </tr>
    `;
            $('#product_table tbody').append(newRow);
            // Yeni eklenen "product_name" inputuna Select2 uygula
            $('#product_table tbody').find('.product_name').last().select2({
                placeholder: "Ürün aramak için yazın...",
                allowClear: true,
                language: {
                    inputTooShort: function () {
                        return "3 karakter daha yazın...";
                    },
                    noResults: function () {
                        return "Sonuç bulunamadı";
                    },
                    searching: function () {
                        return "Arama yapılıyor...";
                    }
                },
                ajax: {
                    url: "<?php echo base_url('qaime/search_products'); ?>",
                    dataType: 'json',
                    method: 'POST',
                    delay: 250,
                    data: function (params) {
                        return { query: params.term };
                    },
                    processResults: function (data) {
                        if (data.success) {
                            return {
                                results: $.map(data.results, function (item) {
                                    return {
                                        id: item.product_id,
                                        text: item.product_name + ' ' + item.varyasyon,
                                        product_stock_code_id: item.product_stock_code_id, // Ekstra veri
                                        demirbas_id: item.demirbas_id // Ekstra veri
                                    };
                                })
                            };
                        } else {
                            return { results: [{ id: '', text: data.message }] };
                        }
                    },
                    cache: true
                },
                minimumInputLength: 3
            });
            // Ek Attribute'yi Almak için Change Event'i
            $('.product_unit_id').select2();


        });
        $('#product_table').on('change', '.product_name', function () {
            let selectedData = $(this).select2('data')[0]; // Select2 verisini al

            if (selectedData && selectedData.product_stock_code_id) {
                let productStockCodeId = selectedData.product_stock_code_id;
                // Değeri başka bir input alanına yazdırma
                $(this).closest('tr').find('.product_stock_code_id_input').val(productStockCodeId);
            } else {
                console.log("Product Stock Code ID bulunamadı!");
            }



            if (selectedData && selectedData.demirbas_id) {
                let productdemirbas_id = selectedData.demirbas_id;
                // Değeri başka bir input alanına yazdırma
                $(this).closest('tr').find('.product_demirbas_id').val(productdemirbas_id);
            } else {
                console.log("Demirbas ID bulunamadı!");
            }


        });
        // Satır Silme Butonu
        $('#product_table').on('click', '.remove_row', function () {
            $(this).closest('tr').remove(); // Satırı sil
            updateRowNumbers(); // Sıra numaralarını güncelle
        });

        // Sıra Numaralarını Güncelle
        function updateRowNumbers() {
            $('#product_table tbody tr').each(function (index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        $('#search_input_nakliye').select2({
            placeholder: "Nakliye aramak için yazın...",
            allowClear: true,
            language: {
                inputTooShort: function () {
                    return "3 karakter daha yazın...";
                },
                noResults: function () {
                    return "Sonuç bulunamadı veya cari seçilmedi";
                },
                searching: function () {
                    return "Arama yapılıyor...";
                }
            },
            ajax: {
                url: "<?php echo base_url('qaime/search_cari_to_nakliye'); ?>", // AJAX isteğinin gönderileceği URL
                dataType: 'json',
                delay: 250, // Gecikme süresi
                data: function (params) {
                    return {
                        search: params.term, // Kullanıcının yazdığı değer
                        cari_id: $('#customer_id').val() // CSD ID
                    };
                },
                processResults: function (data) {
                    if (data.status === 200) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.code
                                };
                            })
                        };
                    } else {
                        return {
                            results: [{ id: '', text: data.message }]
                        };
                    }
                },
                cache: true
            },
            minimumInputLength: 3 // En az 3 karakter yazıldığında AJAX isteği gönderilir
        });

        $('#forma_2_id').select2({
            placeholder: "Forma2 aramak için yazın...",
            allowClear: true,
            language: {
                inputTooShort: function () {
                    return "3 karakter daha yazın...";
                },
                noResults: function () {
                    return "Sonuç bulunamadı veya cari seçilmedi";
                },
                searching: function () {
                    return "Arama yapılıyor...";
                }
            },
            ajax: {
                url: "<?php echo base_url('qaime/search_cari_to_forma_2'); ?>", // AJAX isteğinin gönderileceği URL
                dataType: 'json',
                delay: 250, // Gecikme süresi
                data: function (params) {
                    return {
                        search: params.term, // Kullanıcının yazdığı değer
                        cari_id: $('#customer_id').val() // CSD ID
                    };
                },
                processResults: function (data) {
                    if (data.status === 200) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.code
                                };
                            })
                        };
                    } else {
                        return {
                            results: [{ id: '', text: data.message }]
                        };
                    }
                },
                cache: true
            },
            minimumInputLength: 3 // En az 3 karakter yazıldığında AJAX isteği gönderilir
        });

        // Yeni eklenen "product_name" inputuna Select2 uygula
        $('#product_table tbody').find('.product_name').last().select2({
            placeholder: "Ürün aramak için yazın...",
            allowClear: true,
            language: {
                inputTooShort: function () {
                    return "3 karakter daha yazın...";
                },
                noResults: function () {
                    return "Sonuç bulunamadı";
                },
                searching: function () {
                    return "Arama yapılıyor...";
                }
            },
            ajax: {
                url: "<?php echo base_url('qaime/search_products'); ?>",
                dataType: 'json',
                method: 'POST',
                delay: 250,
                data: function (params) {
                    return { query: params.term,invoice_type_id:<?php echo $invoice_type_id; ?> };
                },
                processResults: function (data) {
                    if (data.success) {
                        return {
                            results: $.map(data.results, function (item) {
                                return {
                                    id: item.product_id,
                                    text: item.product_name + ' ' + item.varyasyon,
                                    product_stock_code_id: item.product_stock_code_id,
                                    demirbas_id: item.demirbas_id,
                                };
                            })
                        };
                    } else {
                        return { results: [{ id: '', text: data.message }] };
                    }
                },
                cache: true
            },
            minimumInputLength: 3
        });
        // Ek Attribute'yi Almak için Change Event'i

        function hesapla() {
            let araToplam = 0;
            let toplamIndirim = 0;
            let netToplam = 0;
            let toplamKDV = 0;

            let taxFormat = $('#taxformat').val(); // EDV Dahil (1) veya Hariç (0)
            let kdv_oran = $('#kdv_oran').val();
            let discountRate = parseFloat($('#discount_rate').val()) || 0; // Genel indirim oranı
            let currency = $('#para_birimi option:selected').text() || 'AZN'; // Para birimi
            let discountFormat = $('#discount_format').val();


            $('#product_table tbody tr').each(function () {
                if(kdv_oran > 0){
                    $(this).find('.edv_oran').val(kdv_oran); // Disable satır bazlı indirim
                }
                let price = parseFloat($(this).find('.product_price').val()) || 0;
                let qty = parseFloat($(this).find('.product_qty').val()) || 0;
                let edvOran = parseFloat($(this).find('.edv_oran').val()) || 0;

                let cemi = price * qty; // KDV'siz toplam tutar
                let indirim = 0;



                // Satır bazlı indirim alanlarını kontrol et
                if (discountRate > 0) {
                    $(this).find('.indirim_oran').val(0).prop('disabled', true); // Disable satır bazlı indirim
                } else {
                    $(this).find('.indirim_oran').prop('disabled', false); // Enable satır bazlı indirim
                    let discountOran = parseFloat($(this).find('.indirim_oran').val()) || 0;

                    // Satır bazlı indirim hesaplama
                    if (discountFormat === "%") {
                        indirim = (cemi * discountOran) / 100;
                    } else if (discountFormat === "flat") {
                        indirim = discountOran;
                    }
                }

                let indirimliTutar = cemi - indirim;
                let kdvTutar = 0;

                // EDV Dahil veya Hariç Hesaplama
                if (taxFormat == "1") { // EDV Dahil
                    kdvTutar = indirimliTutar * (edvOran / (100 + edvOran));
                    indirimliTutar -= kdvTutar;
                } else { // EDV Hariç
                    kdvTutar = (indirimliTutar * edvOran) / 100;
                }

                // Satır bazlı toplamları hesapla
                $(this).find('.cemi_edvsiz').val(indirimliTutar.toFixed(4));

                araToplam += cemi;
                toplamIndirim += indirim;
                netToplam += indirimliTutar;
                toplamKDV += kdvTutar;
            });

            // Genel indirim oranı uygulanırsa buradan hesapla


            if (discountRate > 0) {
                if (discountFormat === "%") {
                    toplamIndirim = (araToplam * discountRate) / 100;
                } else if (discountFormat === "flat") {
                    toplamIndirim = discountRate;
                }
                netToplam = netToplam - toplamIndirim;
                genelToplam = netToplam + toplamKDV ;

            }
            else {
                 genelToplam = netToplam + toplamKDV - toplamIndirim;

            }





            // Alt toplamları yazdırma
            $('#ara_toplam').text(araToplam.toFixed(4) + ' ' + currency);
            $('#indirim_toplami').text(toplamIndirim.toFixed(4) + ' ' + currency);
            $('#net_toplami').text((netToplam).toFixed(4) + ' ' + currency);
            $('#kdv_toplami').text(toplamKDV.toFixed(4) + ' ' + currency);
            $('#genel_toplam').text(genelToplam.toFixed(4) + ' ' + currency);

            // LocalStorage'e kaydetme
            localStorage.setItem('toplamlar', JSON.stringify({
                araToplam: araToplam.toFixed(4),
                toplamIndirim: toplamIndirim.toFixed(4),
                netToplam: (netToplam).toFixed(4),
                toplamKDV: toplamKDV.toFixed(4),
                genelToplam: genelToplam.toFixed(4)
            }));
        }

        // Hesaplamayı Tetikleyen Eventler
        $('#product_table').on('input', '.product_price, .product_qty, .edv_oran, .indirim_oran', hesapla);
        $('#taxformat, #para_birimi, #discount_format').on('change', hesapla);
        $('#discount_rate, #kdv_oran').on('keyup', hesapla);

        // Satır Silme Butonu
        $('#product_table').on('click', '.remove_row', function () {
            $(this).closest('tr').remove();
            hesapla(); // Toplamları güncelle
        });
        $(document).on('change','#proje_id',function (e) {
            $('#asama_id').children('option').remove();
            $('#task_id').children('option').remove();
            $('#bolum_id').children('option').remove();
            $('#alt_asama_id').children('option').remove();
            var proje_id=$(this).val();
            $.ajax({
                url: '/projects/proje_bolum_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&pid=' + proje_id,
                success: function (data) {

                    $("#bolum_id").append('<option  value="0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#bolum_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                    });
                }
            });

            $.ajax({
                dataType: "json",
                method: 'post',
                url: baseurl + 'search_products/proje_deposu',
                data:'proje_id='+ proje_id,
                success: function (data) {
                    $(".depo_id_item").append('<option  selected value="'+ data.id +'">'+ data.name+'</option>');

                }
            });
        });
        $(document).on('change','#bolum_id',function (e) {
            $('#asama_id').children('option').remove();
            $('#task_id').children('option').remove();
            $('#alt_asama_id').children('option').remove();
            var bolum_id=$(this).val();
            var proje_id=$('#proje_id').val();
            $.ajax({
                url: '/projects/proje_ana_asamalari_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&bolum_id=' + bolum_id+'&proje_id=' + proje_id,
                success: function (data) {

                    $("#asama_id").append('<option  value="0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#asama_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                    });
                }
            });
        });
    });

    $('#create_form').on('click',function (){
        let customer_id = $('#customer_id').val();
        let proje_id = $('#proje_id').val();
        let bolum_id = $('#bolum_id').val();
        let asama_id = $('#asama_id').val();
        let search_input_nakliye = $('#search_input_nakliye').val();
        let forma_2_id = $('#forma_2_id').val();
        let notes = $('#notes').val();
        let invoice_no = $('#invoice_no').val();
        let refer = $('#refer').val();
        let invoice_date = $('#invoice_date').val();
        let invocieduedate = $('#invocieduedate').val();
        let alt_cari_id = $('#alt_cari_id').val();
        let para_birimi = $('#para_birimi').val();
        let kur_degeri = $('#kur_degeri').val();
        let discount_format = $('#discount_format').val();
        let discount_rate = $('#discount_rate').val();
        let invoice_type_id = $('#invoice_type_id').val();
        let taxformat = $('#taxformat').val();
        let kdv_oran = $('#kdv_oran').val();
        // Ürün Tablosundaki Verileri Toplama
        let productData = [];
        $('#product_table tbody tr').each(function () {
            let row = {
                product_id: $(this).find('.product_name').val(),
                product_stock_code_id_input: $(this).find('.product_stock_code_id_input').val(),
                product_demirbas_id: $(this).find('.product_demirbas_id').val(),
                product_unit_id: $(this).find('.product_unit_id').val(),
                product_price: parseFloat($(this).find('.product_price').val()) || 0,
                product_qty: parseFloat($(this).find('.product_qty').val()) || 0,
                edv_oran: parseFloat($(this).find('.edv_oran').val()) || 0,
                indirim_oran: parseFloat($(this).find('.indirim_oran').val()) || 0,
                cemi_edvsiz: parseFloat($(this).find('.cemi_edvsiz').val()) || 0
            };
            productData.push(row);
        });
        let localStorageData = JSON.parse(localStorage.getItem('toplamlar')) || {};

        // Tüm Verileri Birleştirme
        let data = {
            form_data: {
                customer_id, proje_id, bolum_id, asama_id, search_input_nakliye, forma_2_id,
                notes, invoice_no, refer, invoice_date, invocieduedate,
                alt_cari_id, para_birimi, kur_degeri, discount_format, discount_rate,invoice_type_id,taxformat,kdv_oran
            },
            product_data: productData,
            local_storage_data: localStorageData
        };

        if (validateForm() && validateProductTable()) {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Yeni Qaime oluşturma',
                icon: 'fa fa-plus',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: true,
                smoothContent: true,
                draggable: false,
                content: 'Qaime Oluşacak Emin Misiniz?',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            $.post(baseurl + 'qaime/create_save', {data: JSON.stringify(data)}, (response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                handleResponse(responses);
                            });
                        }
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                }
            });
        }
    })


    function validateForm() {
        let isValid = true; // Form geçerliliğini kontrol etmek için

        // Tüm required alanlarını kontrol et
        $('input.required, select.required').each(function () {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid'); // Hata durumu
                let fieldName = $(this).attr('name') || $(this).attr('id');
                console.log(fieldName + ' alanı boş!');
            } else {
                $(this).removeClass('is-invalid'); // Hata kaldırılır
            }
        });

        if (!isValid) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                title: 'Dikkat!',
                content: 'Lütfen tüm zorunlu alanları doldurun!',
                buttons: {
                    ok: {
                        text: 'Tamam',
                        btnClass: "btn btn-danger"
                    }
                }
            });
        }

        return isValid;
    }
    function validateProductTable() {
        let isValid = true;

        $('#product_table tbody tr').each(function () {
            // Tüm hataları temizle
            $(this).find('input, select').removeClass('is-invalid');

            // Input alanları kontrolü
            let price = $(this).find('.product_price').val().trim();
            let qty = $(this).find('.product_qty').val().trim();
            let edvOran = $(this).find('.edv_oran').val().trim();

            // Select alanları kontrolü
            let productName = $(this).find('.product_name').val();
            let productUnit = $(this).find('.product_unit_id').val();

            // Fiyat kontrolü
            if (!price || price <= 0) {
                $(this).find('.product_price').addClass('is-invalid');
                isValid = false;
            }

            // Miktar kontrolü
            if (!qty || qty <= 0) {
                $(this).find('.product_qty').addClass('is-invalid');
                isValid = false;
            }

            // EDV kontrolü
            if (!edvOran || edvOran < 0) {
                $(this).find('.edv_oran').addClass('is-invalid');
                isValid = false;
            }

            // Product Name (Ürün Adı) kontrolü
            if (!productName) {
                $(this).find('.product_name').addClass('is-invalid');
                isValid = false;
            }

            // Unit (Birim) kontrolü
            if (!productUnit) {
                $(this).find('.product_unit_id').addClass('is-invalid');
                isValid = false;
            }
        });

        if (!isValid) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                title: 'Dikkat!',
                content: 'Lütfen ürün tablosundaki tüm zorunlu alanları doldurun!',
                buttons: {
                    ok: {
                        text: 'Tamam',
                        btnClass: "btn btn-danger"
                    }
                }
            });
        }

        return isValid;
    }



    function handleResponse(responses) {
        if (responses.status === 200) {
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
                            location.href = responses.index;
                        }
                    }
                }
            });
        } else if (responses.status === 410) {
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
                        btnClass: "btn btn-danger"
                    }
                }
            });
        }
    }
</script>