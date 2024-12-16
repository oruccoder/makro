<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Proje Katılım Çizelgesi</span></h4>
        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <form action="#">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label>Çizelge Tipi</label>
                                    <select class=" form-control" id="tip" name="tip" >
                                        <option  value="1">Personel</option>
                                        <option  value="2">Podradçı Personel</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row page_row">
                            <h4><?= $project_name ?></h4>
                            <h5><?= $date ?></h5>

                            <div id="userTableContainer">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
    $('#dosya_file').on('click', function (e) {
        e.preventDefault(); // Varsayılan davranışı engelle

        var formData = new FormData(); // FormData nesnesini oluştur

        // Seçilen dosyayı FormData'ya ekle
        var fileInput = $('.file')[0]; // İlk .file öğesini seç
        if (fileInput && fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
            formData.append('project_id', $('#project_id').val());
            formData.append('date', $('#date').val());
        } else {
            $('#uploadResult').html('<p style="color: red;">Lütfen bir dosya seçin.</p>');
            return;
        }



        // AJAX ile dosyayı gönder
        $.ajax({
            url: "<?= site_url('attendance/upload_file_ajax') ?>", // PHP'deki dosya yükleme metodunun URL'si
            type: "POST",
            data: formData,
            processData: false, // Form verilerinin otomatik olarak işlenmesini engelle
            contentType: false, // İçerik türünü otomatik olarak ayarlamasını engelle
            success: function (response) {
                try {
                    var result = JSON.parse(response); // Yanıtı JSON olarak ayrıştır
                    if (result.status === 'success') {
                        $('#uploadResult').html('<p style="color: green;">' + result.message + '</p>');
                        $('#uploadResult').append('<p>Dosya Yolu: <a href="' + result.file_path + '" target="_blank">' + result.file_path + '</a></p>');
                    } else {
                        $('#uploadResult').html('<p style="color: red;">' + result.message + '</p>');
                    }
                } catch (e) {
                    $('#uploadResult').html('<p style="color: red;">Yanıt işlenirken bir hata oluştu.</p>');
                }
            },
            error: function () {
                $('#uploadResult').html('<p style="color: red;">Bir hata oluştu. Lütfen tekrar deneyin.</p>');
            }
        });
    });


    $(document).ready(function () {
        $.ajax({
            url: "<?= site_url('attendance/get_existing_file') ?>", // Mevcut dosya kontrol URL'si
            type: "POST",
            data: { project_id: $('#project_id').val(), date: $('#date').val() },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.status === 'success' && result.file_path) {
                    $('#existingFile').html(
                        '<p>Mevcut Dosya: <a href="' + result.file_path + '" target="_blank">Dosyayı Görüntüle</a></p>'
                    );
                } else {
                    $('#existingFile').html('<p>Bu proje ve tarihe ait bir dosya bulunamadı.</p>');
                }
            },
            error: function () {
                $('#existingFile').html('<p>Mevcut dosya bilgisi alınırken bir hata oluştu.</p>');
            }
        });

    });




    $(document).on('click','.apply-to-all',function (){
        const column = $(this).data("column"); // Hangi sütun uygulanacak
        const value = $(`#apply-${column.replace('_', '-')}`).val(); // Giriş alanındaki değeri al

        if (!value) {
            alert("Lütfen bir değer girin!");
            return;
        }

        // Tüm ilgili input alanlarına değeri uygula
        $(`.${column}`).each(function () {
            $(this).val(value);
        });
    })

    $(document).on('click','#saveRecords',function (){
        // En az bir satır kontrolü
        let isFilled = false;
        $("#attendanceForm .entry_time, #attendanceForm .break_start, #attendanceForm .break_end, #attendanceForm .exit_time, #attendanceForm .description").each(function () {
            if ($(this).val().trim() !== "") {
                isFilled = true;
                return false; // İlk dolu alan bulunduğunda döngüyü durdur
            }
        });

        if (!isFilled) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'En Az Bir Kişi Göndermelisiniz',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return;
        }

        // Confirm işlemi

        $.alert({
            theme: 'modern',
            icon: 'fa fa-question',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            title: 'Başarılı',
            content: 'Kayıtları Göndermek İstediğinizden Emin Misiniz?',
            buttons:{
                formSubmit: {
                    text: 'Tamam',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            url: "<?= site_url('attendance/save_all_records_ajax') ?>",
                            type: "POST",
                            data: $("#attendanceForm").serialize(),
                            dataType: "json",
                            success: function (response) {
                                if (response.status === "success") {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: response.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Dikkat',
                                        content: response.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                            }
                                        }
                                    });
                                }
                            },
                            error: function () {
                                $("#responseMessage").html('<p class="error">Kayıt işlemi sırasında bir hata oluştu.</p>');
                            }
                        });
                    }
                }
            }
        });

        // AJAX isteği gönder
    })



    document.addEventListener('DOMContentLoaded', function () {
        const tipSelect = document.getElementById('tip');
        const userTableContainer = document.getElementById('userTableContainer');

        // Tip seçildiğinde tabloyu güncelle
        tipSelect.addEventListener('change', function () {
            const selectedTip = tipSelect.value;

            // Sunucudan doğru tabloyu almak için bir AJAX çağrısı
            $.ajax({
                url: "<?= site_url('attendance/get_users_by_type') ?>", // PHP'deki dosya yükleme metodunun URL'si
                method: 'POST',
                data: {
                    tip: selectedTip
                },
                success: function (response) {
                    // Sunucudan dönen tabloyu yerleştir
                    userTableContainer.innerHTML = response;
                },
                error: function () {
                    userTableContainer.innerHTML = '<p>Veriler yüklenemedi.</p>';
                }
            });
        });

        // Sayfa yüklendiğinde varsayılan tabloyu yükle
        tipSelect.dispatchEvent(new Event('change'));
    });

</script>

<style>
    .form-container {
        max-height: calc(100vh - 450px); /* Ekran yüksekliği - üst ve alt boşluklar */
        overflow-y: auto; /* Dikey kaydırma çubuğu */
        overflow-x: auto; /* Yatay kaydırmayı gizle */
    }
    .page_row{
        text-align: center;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -.625rem;
        margin-left: -.625rem;
        align-content: center;
        flex-direction: column;
    }
    form {
        width: 100%;
    }
    h1, h2 {
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background-color: #fff;
    }

    table th {
        background-color: #5b6a86;
        color: white;
        position: sticky; /* Sabit başlık için */
        top: 0; /* Sabitleme noktası */
        z-index: 10; /* Üstte kalmasını sağlar */
    }
    table th, table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }
    table th {
        background-color: #5b6a86;
        color: white;
    }
    input[type="time"], textarea, button {
        padding: 5px;
        font-size: 14px;
    }
    button {
        background-color: #2f588d;
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
    }
    button:hover {
        background-color: #a5a5a5;
    }
    .success {
        color: green;
        text-align: center;
    }
    .error {
        color: red;
        text-align: center;
    }
    .header-input-container {
        display: flex;
        flex-direction: column;
        align-items: center; /* Yatay ortalama */
        margin-top: 5px; /* Başlık ile giriş alanı arasında boşluk */
    }

    .header-input-container input[type="time"] {
        margin-bottom: 5px; /* Giriş alanı ile buton arasındaki boşluk */
    }
</style>