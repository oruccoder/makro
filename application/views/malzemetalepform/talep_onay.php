<div class="page-header">
    <?php
    $this->load->view('malzemetalepform/viewheader');
    ?>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="col col-xs-12 col-sm-12 col-md-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="border-bottom pb-2"><b>Talep Bilgileri</b></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Proje :</th>
                                        <td>
                                <span data-popup="popover" title="Proje Adı" data-trigger="hover" data-content="<?php echo proje_name($details->proje_id)?>">
                                    <a target="_blank" href="/projects/explore?id=<?php echo $details->proje_id?>">
                                        <?php echo proje_code($details->proje_id)?></a>
                                </span>
                                        </td>
                                        <th>Şirket :</th>
                                        <td>Makro 2000 A.Ş</td>
                                    </tr>
                                    <tr>
                                        <th>Proje Bölümü :</th>
                                        <td><?php echo bolum_getir($details->bolum_id)?></td>
                                        <th>Proje Aşaması :</th>
                                        <td><?php echo task_to_asama($details->asama_id)?></td>
                                    </tr>
                                    <tr>
                                        <th>Talep Tarihi :</th>
                                        <td><b><?php echo dateformat_new($details->created_at)?></b></td>
                                        <th>Formu Oluşturan :</th>
                                        <td><b><?php echo personel_details($details->aauth)?></b></td>
                                    </tr>
                                    <tr>
                                        <th>Açıklama :</th>
                                        <td><?php echo $details->desc?></td>
                                        <th>Talep Eden :</th>
                                        <td><b><?php echo personel_details($details->talep_eden_user_id)?></b></td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="border-bottom pb-2"><b>Onay Bilgileri</b></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Onay Türü</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Durum</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (talep_onay_listesi($details->id, 3)['onay_listesi'] as $onay_user):
                                        // Durum ve Buton Ayarı
                                        $durum = $onay_user['onay_durumu'];
                                        $button = '<button class="btn btn-warning btn-sm" disabled><i class="fa fa-question"></i></button>';

                                        if ($onay_user['active']) {
                                            $durum = 'Gözləmedə';
                                            $button = '<button class="btn btn-info btn-sm onayla"  data-onay-id="'.$onay_user['id'].'">
                                <i class="fa fa-check"></i>
                              </button>';
                                        }
                                        ?>
                                        <tr>
                                            <td>(<?php echo $onay_user['onay_tipi_str']; ?>)</td>
                                            <td><?php echo $onay_user['kullanici_ad']; ?></td>
                                            <td><?php echo $durum; ?></td>
                                            <td><?php echo $button; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                    <?php
                    $this->load->view('malzemetalepform/asama');
                    ?>

                </div>
                <div class="row">
                    <div class="col-12">
                        <h4 class="border-bottom pb-2 pt-2"><b>Stok Kontrolü Bekleyen Ürünler</b></h4>
                        <div class="table-responsive">
                            <table class="table table-bordered malzemetalep_products">
                                <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Resim</td>
                                    <td>Malzeme</td>
                                    <td>Tanım</td>
                                    <td>Varyant</td>
                                    <td>Kullanım Yeri</td>
                                    <td>Miktar</td>
                                    <td>Birim</td>
                                    <td>Temin Tarihi</td>
                                    <td>Aciliyet Durumu</td>
                                    <td>Durum</td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php if($talep_products): ?>
                                    <?php foreach ($talep_products as $key => $items): ?>
                                        <tr>
                                            <td><?php echo ++$key; ?></td> <!-- Artırılmış key değeri -->
                                            <td><img src="<?php echo $items['image']; ?>" alt="Product Image" style="max-width: 100px; height: auto;"></td> <!-- Ürün resmi -->
                                            <td><?php echo $items['product_name']; ?></td> <!-- Ürün adı -->
                                            <td><?php echo $items['product_desc']; ?></td>
                                            <td><?php echo $items['varyant']; ?></td>
                                            <td><?php echo $items['kullanim_yeri']; ?></td>
                                            <td><?php echo amountFormat_s($items['qty']); ?></td>
                                            <td><?php echo $items['temin_date']; ?></td>
                                            <td><?php echo $items['birim']; ?></td>
                                            <td><?php echo $items['aciliyet']; ?></td>
                                            <td><?php echo $items['status']; ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>





    $(document).on('click', '.add_product', function () {
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Arama Seçenekleri',
            icon: 'fa fa-search',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: "Ürün Arama Seçeneği Belirleyiniz",
            buttons: {
                productSearch: { // Ürün bazlı arama için buton
                    text: 'Ürün Bazlı Arama',
                    btnClass: "btn btn-success btn-sm",
                    action: function () {
                        // Ürün bazlı aramak için işlemler
                        OpenProductForm();

                    }
                },
                categorySearch: { // Kategori bazlı arama için buton
                    text: 'Kategori Bazlı Arama',
                    btnClass: "btn btn-warning btn-sm",
                    action: function () {
                        // Kategori bazlı aramak için işlemler
                        OpenCategoryForm();
                    }
                }

            },
            onContentReady: function () {


                // İçerik yüklendiğinde yapılacak işlemler
            }
        });
    })

    function OpenCategoryForm(){
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Ekleme',
            icon: 'fa fa-search',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: getCategoryHtml(),
            buttons: {
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                // İçerik yüklendiğinde yapılacak işlemler
                let cache = {}; // Cache için bir nesne
                $('#searchInput').on('input', function () {
                    const query = $(this).val().trim();
                    const cat_id = $('#category_id').val();
                    if(!parseInt(cat_id)){
                        $('#resultsTable tbody').html('<tr><td colspan="3">Kategori Zorunludur.</td></tr>');
                        return;
                    }

                    if (query.length < 3) {
                        $('#resultsTable tbody').html('<tr><td colspan="3">En az 3 harf giriniz.</td></tr>');
                        return;
                    }

                    // Eğer cache'de varsa, direkt oradan çek
                    if (cache[query]) {
                        renderResults(cache[query]);
                        initializeSelect2();
                        return;


                    }

                    $.ajax({
                        url: baseurl + 'malzemetalepform/search_products_category', // Sunucu tarafında arama endpointi
                        type: 'POST',
                        dataType: 'json',
                        data: { query: query,cat_id : cat_id },
                        beforeSend: function () {
                            // Loading göstermek için
                            $('#resultsTable tbody').html('<tr><td colspan="3">Yükleniyor...</td></tr>');

                        },
                        success: function (data) {
                            if (data.success && data.results.length > 0) {
                                cache[query] = data.results; // Cache'e kaydet
                                renderResults(data.results);


                            } else {
                                $('#resultsTable tbody').html('<tr><td colspan="3">Sonuç bulunamadı.</td></tr>');

                            }
                            initializeSelect2();
                        },
                        error: function () {
                            $('#resultsTable tbody').html('<tr><td colspan="3">Bir hata oluştu.</td></tr>');

                        },
                        complete: function () {

                        }
                    });


                });

                initializeSelect2();

            }
        });
    }
    function OpenProductForm(){
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Ürün Ekleme',
            icon: 'fa fa-search',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: getProductHtml(),
            buttons: {
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                // İçerik yüklendiğinde yapılacak işlemler
                let cache = {}; // Cache için bir nesne
                $('#searchInput').on('input', function () {
                    const query = $(this).val().trim();

                    if (query.length < 3) {
                        $('#resultsTable tbody').html('<tr><td colspan="3">En az 3 harf giriniz.</td></tr>');
                        return;
                    }

                    // Eğer cache'de varsa, direkt oradan çek
                    if (cache[query]) {
                        renderResults(cache[query]);
                        initializeSelect2();
                        return;


                    }

                    $.ajax({
                        url: baseurl + 'malzemetalepform/search_products', // Sunucu tarafında arama endpointi
                        type: 'POST',
                        dataType: 'json',
                        data: { query: query },
                        beforeSend: function () {
                            // Loading göstermek için
                            $('#resultsTable tbody').html('<tr><td colspan="3">Yükleniyor...</td></tr>');

                        },
                        success: function (data) {
                            if (data.success && data.results.length > 0) {
                                cache[query] = data.results; // Cache'e kaydet
                                renderResults(data.results);


                            } else {
                                $('#resultsTable tbody').html('<tr><td colspan="3">Sonuç bulunamadı.</td></tr>');

                            }
                            initializeSelect2();
                        },
                        error: function () {
                            $('#resultsTable tbody').html('<tr><td colspan="3">Bir hata oluştu.</td></tr>');

                        },
                        complete: function () {

                        }
                    });


                });

            }
        });
    }
    function getProductHtml() {
        return `
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <input type="text" id="searchInput" placeholder="Ürün arayın..." class="form-control" />
                                </div>
                                <div>
                                    <table id="resultsTable" class="table table-striped table_products">
                                        <thead>
                                            <tr>
                                                <th>Resim</th>
                                                <th>Ürün Adı</th>
                                                <th>Varyant</th>
                                                <th>Tanım</th>
                                                <th>Kullanım Yeri</th>
                                                <th>Temin Tarihi</th>
                                                <th>Aciliyet Durumu</th>
                                                <th>Birim</th>
                                                <th>Miktar</th>
                                                <th>İşlem</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Sonuçlar buraya yüklenecek -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }
    function getCategoryHtml() {
        return `
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control select-box" id="category_id">
                                            ${getCategoryOptions()}
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="searchInput" placeholder="Ürün arayın..." class="form-control" />
                                    </div>
                                </div>
                                <div>
                                    <table id="resultsTable" class="table table-striped table_products">
                                        <thead>
                                            <tr>
                                                <th>Resim</th>
                                                <th>Ürün Adı</th>
                                                <th>Varyant</th>
                                                <th>Tanım</th>
                                                <th>Kullanım Yeri</th>
                                                <th>Temin Tarihi</th>
                                                <th>Aciliyet Durumu</th>
                                                <th>Birim</th>
                                                <th>Miktar</th>
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
                </div>
            </div>
        </div>`;
    }
    function getCategoryOptions() {
        // PHP'de category_list_ işlevini çağırarak döndürülen kategori seçenekleri
        return `
        <option value="0" selected>Seçiniz</option>
        <?php foreach (category_list_() as $category) : ?>
            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endforeach; ?>
    `;
    }
    function renderResults(results) {
        const rows = results.map((item, index) => `
        <tr>
            <td>
                <img src="${baseurl}${item.images}" alt="" style="max-width:40%" height="auto" class="img-fluid">
            </td>
            <td>${item.product_name}</td>
            <td>${item.varyasyon}</td>
            <td>
                <input type="text" class="product_desc form-control" value="${item.product_name}">
            </td>
            <td>
                <input type="text" class="product_kullanim_yeri form-control">
            </td>
            <td>
                <input type="date" class="product_temin_date form-control">
            </td>
            <td>
                <select class="form-control progress_status_id select2-progress-status">
                    ${progressStatusOptions()}
                </select>
            </td>
            <td>
                <select class="form-control select-box unit_id select2-unit" p_unit_id="${item.p_unit_id}">
                    ${unitOptions()}
                </select>
            </td>
            <td>
                <input style="width:70px " class="product_qty form-control" value="0">
            </td>
            <td>
                <button
                    eq="${index}"
                    product_id="${item.product_id}"
                    product_stock_code_id="${item.product_stock_code_id}"
                    class="btn btn-success btn-sm form_add_products">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    `).join('');
        $('#resultsTable tbody').html(rows);

        // Tüm dinamik select elemanlarını select2 ile initialize et
        $('.select2-progress-status').select2({
            placeholder: 'Aciliyet Durumu Seçin',
            width: '100%' // Genişliği ayarlamak için
        });
        $('.select2-unit').select2({
            placeholder: 'Birim Seçin',
            width: '100%' // Genişliği ayarlamak için
        });
    }
    // PHP'den alınan progress_status() fonksiyonunun verilerini döndüren bir helper
    function progressStatusOptions() {
        return `
        <?php foreach (progress_status() as $emp): ?>
            <option value="<?= $emp->id; ?>"><?= $emp->name; ?></option>
        <?php endforeach; ?>
    `;
    }
    // PHP'den alınan units() fonksiyonunun verilerini döndüren bir helper
    function unitOptions() {
        return `
         <option value="">Birim Seçiniz</option>
        <?php foreach (units() as $blm): ?>
            <option value="<?= $blm['id']; ?>"><?= $blm['name']; ?></option>
        <?php endforeach; ?>
    `;
    }
    $(document).on('click', '.form_add_products', function () {
        let eq = $(this).attr('eq');
        let product_stock_code_id = $(this).attr('product_stock_code_id');
        let product_id = $(this).attr('product_id');
        let product_qty = $('.product_qty').eq(eq).val();
        let unit_id = $('.unit_id').eq(eq).val();
        let progress_status_id = $('.progress_status_id').eq(eq).val();
        let product_kullanim_yeri = $('.product_kullanim_yeri').eq(eq).val();
        let product_desc = $('.product_desc').eq(eq).val();
        let product_temin_date = $('.product_temin_date').eq(eq).val();

        // Zorunlu alanlar için kontrol
        if (!product_id || !product_qty || !unit_id || !product_desc || !product_temin_date) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Eksik Bilgi!',
                content: 'Lütfen tüm zorunlu alanları doldurun.',
                buttons: {
                    ok: {
                        text: 'Tamam',
                        btnClass: 'btn-red'
                    }
                }
            });
            return; // İşlemi durdur
        }

        // Verileri oluştur
        let data = {
            product_stock_code_id: product_stock_code_id,
            product_id: product_id,
            product_qty: product_qty,
            unit_id: unit_id,
            progress_status_id: progress_status_id,
            product_kullanim_yeri: product_kullanim_yeri,
            product_desc: product_desc,
            product_temin_date: product_temin_date,
            talep_id: $('#talep_id').val(),
        };

        // POST isteği gönder
        $.post(baseurl + 'malzemetalepform/create_form_items_stock', data, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status === 200) {
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
                            action: function () {
                                // Tabloya ekleme
                                let count  = parseInt($('.malzemetalep_products tbody tr').length)+1;
                                let table = `<tr>
                                <td>${count}</td>
                                <td><img style="max-width:40%" height="auto" class="img-fluid" src="${responses.data.image}"></td>
                                 <td>${responses.data.product_name}</td>
                                 <td>${responses.data.tanim}</td>
                                 <td>${responses.data.option_html}</td>
                                 <td>${responses.data.product_kullanim_yeri}</td>
                                 <td>${responses.data.qyt_birim}</td>
                                 <td>${responses.data.birim}</td>
                                 <td>${responses.data.product_temin_date}</td>
                                 <td>${responses.data.prg_status}</td>
                                <td>
                                    <button item_id="${responses.data.talep_form_products_id}" type_="2" class="btn btn-danger btn-sm form_remove_products" durum="0">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>`;
                                console.log(table);

                                $('.malzemetalep_products tbody').append(table);
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
                            btnClass: "btn btn-link text-dark"
                        }
                    }
                });
            }
        });
    });
    function initializeSelect2() {
        $('.select2-progress-status').select2({
            placeholder: 'Aciliyet Durumu Seçin',
            dropdownParent: $(".jconfirm-box-container")
        });
        $('.select2-unit').select2({
            placeholder: 'Birim Seçin',
            dropdownParent: $(".jconfirm-box-container")
        });

        $('#category_id').select2({
            placeholder: 'Kategori Seçin',
            dropdownParent: $(".jconfirm-box-container")
        });
    }
    $(document).on('keypress', '.item_qty', function (e) {
        if (e.which === 13) { // Enter tuşu kontrolü
            e.preventDefault(); // Sayfanın yenilenmesini engelle

            const itemInput = $(this); // Tıklanan input elemanı
            const itemId = itemInput.attr('item_id'); // item_id değeri
            const qtyValue = itemInput.val(); // Girilen miktar

            // Boş veya geçersiz değer kontrolü
            if (!qtyValue || isNaN(qtyValue) || qtyValue <= 0) {
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Lütfen Geçerli Miktar Girin!',
                    buttons: {
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark"
                        }
                    }
                });
                return;
            }

            // AJAX ile sunucuya gönder
            $.ajax({
                url: baseurl + 'malzemetalepform/update_qty', // Sunucuya gönderilecek endpoint
                type: 'POST',
                dataType: 'json',
                data: {
                    item_id: itemId,
                    qty: qtyValue
                },
                success: function (response) {
                    if (response.status === 200) {
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Başarılı!',
                            content: response.message,
                            buttons: {
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark"
                                }
                            }
                        });
                    } else {
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: response.message,
                            buttons: {
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark"
                                }
                            }
                        });
                    }
                },
                error: function () {
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Sunucu Hatası',
                        buttons: {
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark"
                            }
                        }
                    });
                }
            });
        }
    });
    $(document).on('click','.form_remove_products',function (){
        const itemId = $(this).attr('item_id'); // item_id değeri
        const rowToRemove = $(this).closest('tr'); // İlgili satır
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Formdan Ürün Kaldırma',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: "Ürünü Formdan Kaldırmak İstediğinizden Emin Misiniz",
            buttons: {
                formSubmit: {
                    text:'Listeden Kaldır',
                    btnClass:'btn btn-info btn-sm',
                    action:function (){
                        // AJAX ile sunucuya gönder
                        $.ajax({
                            url: baseurl + 'malzemetalepform/delete_item', // Sunucuya gönderilecek endpoint
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                item_id: itemId,
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    rowToRemove.remove();
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                } else {
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
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
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
        });

    })

    $(document).on('click','.form_remove_products_basvuru',function (){
        const itemId = $(this).attr('item_id'); // item_id değeri
        const rowToRemove = $(this).closest('tr'); // İlgili satır
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Formdan Ürün Kaldırma',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: "Ürünü Formdan Kaldırmak İstediğinizden Emin Misiniz",
            buttons: {
                formSubmit: {
                    text:'Listeden Kaldır',
                    btnClass:'btn btn-info btn-sm',
                    action:function (){
                        // AJAX ile sunucuya gönder
                        $.ajax({
                            url: baseurl + 'malzemetalepform/delete_item_basvuru', // Sunucuya gönderilecek endpoint
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                item_id: itemId,
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    rowToRemove.remove();
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
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
        });

    })
    $(document).on('click', '.onayla', function () {
        const onay_id = $(this).data('onay-id');

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Onay',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: "Onay Vermek Üzeresiniz Emin Misiniz?",
            buttons: {
                formSubmit: {
                    text:'Onay Ver',
                    btnClass:'btn btn-info btn-sm',
                    action:function (){
                        $.ajax({
                            url: baseurl + 'malzemetalepform/talep_form_onayi', // Sunucuya gönderilecek endpoint
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                onay_id: onay_id,
                                talep_id: $('#talep_id').val()
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                                action: function () {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: response.message,
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark"
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Sunucu Hatası',
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark"
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
        });





    });



</script>