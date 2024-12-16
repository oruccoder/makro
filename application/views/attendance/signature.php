<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Mobil İmza</span></h4>
        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content">
            <div class="card">
                <canvas id="signaturePad" width="500" height="300"></canvas>

                <div class="buttons" style="padding: 10px">
                    <button class="btn btn-warning" id="clear">Temizle</button>
                    <button class="btn btn-success" id="save">Kaydet</button>
                </div>

                <div id="uploadResult"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const canvas = document.getElementById("signaturePad");
    const context = canvas.getContext("2d");

    let isDrawing = false;

    function getMousePosition(event) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top
        };
    }

    function getTouchPosition(event) {
        const rect = canvas.getBoundingClientRect();
        const touch = event.touches[0];
        return {
            x: touch.clientX - rect.left,
            y: touch.clientY - rect.top
        };
    }

    // Çizim olayları
    canvas.addEventListener("mousedown", (event) => {
        isDrawing = true;
        const pos = getMousePosition(event);
        context.beginPath();
        context.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener("mousemove", (event) => {
        if (!isDrawing) return;
        const pos = getMousePosition(event);
        context.lineTo(pos.x, pos.y);
        context.stroke();
    });

    canvas.addEventListener("mouseup", () => {
        isDrawing = false;
        context.closePath();
    });

    canvas.addEventListener("mouseout", () => {
        isDrawing = false;
    });

    canvas.addEventListener("touchstart", (event) => {
        event.preventDefault();
        isDrawing = true;
        const pos = getTouchPosition(event);
        context.beginPath();
        context.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener("touchmove", (event) => {
        event.preventDefault();
        if (!isDrawing) return;
        const pos = getTouchPosition(event);
        context.lineTo(pos.x, pos.y);
        context.stroke();
    });

    canvas.addEventListener("touchend", () => {
        isDrawing = false;
        context.closePath();
    });

    // Temizleme Butonu
    document.getElementById("clear").addEventListener("click", () => {
        context.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById("uploadResult").innerHTML = "";
    });

    document.getElementById("save").addEventListener("click", () => {
        const dataURL = canvas.toDataURL("image/png"); // İmza PNG formatında alınır
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Yeni İmza',
            icon: 'fa fa-plus-square 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: `
            <div class='mb-3'>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Personel</label>
                        <select class="form-control select-box user_id required" id="user_id">
                            <option value="0">Seçiniz</option>
                            <?php foreach (proje_to_employe($proje_id) as $emp): ?>
                                <option value="<?= $emp->id ?>"><?= $emp->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Giriş/Çıkış</label>
                        <select class="form-control select-box imza_type required" id="imza_type">
                            <option value="-1">Seçiniz</option>
                                <option value="1">Giriş</option>
                                <option value="0">Çıkış</option>
                        </select>
                    </div>
                </div>
            </div>
        `,
            buttons: {
                formSubmit: {
                    text: 'Gönder',
                    btnClass: 'btn-blue',
                    action: function () {
                        const user_id = $('#user_id').val();
                        const imza_type = $('#imza_type').val();

                        if (!user_id || user_id == "0" || imza_type == "-1") {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                title: 'Hata!',
                                content: 'Alanları Doldurun.',
                            });
                            return false; // Onay penceresini kapatma
                        }

                        const formData = new FormData();
                        formData.append('crsf_token', crsf_hash); // CSRF token
                        formData.append('signature', dataURL);    // İmza Base64 formatında
                        formData.append('pers_id', user_id);      // Seçilen personel ID'si
                        formData.append('imza_type', imza_type);      // Seçilen personel ID'si

                        $.ajax({
                            url: baseurl + 'attendance/upload_signature_ajax',
                            type: 'POST',
                            data: formData,
                            processData: false, // FormData olduğu için false
                            contentType: false, // Varsayılan contentType devre dışı
                            success: function (response) {
                                const data = jQuery.parseJSON(response);
                                if (data.status == 200) {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        title: 'Başarılı',
                                        content: data.message,
                                    });
                                } else {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        title: 'Hata!',
                                        content: data.message,
                                    });
                                }
                            },
                            error: function () {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    title: 'Hata!',
                                    content: 'Personelin Bugün İçin Giriş Veya Çıkış Kaydı Bulunamadı.',
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: 'İptal',
                    btnClass: "btn btn-danger btn-sm",
                    action: function () {
                        // İşlem iptal edildi
                    }
                }
            },
            onContentReady: function () {
                // Select2 entegrasyonu
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });
            }
        });
    });


</script>

<style>
    #signaturePad {
        border: 1px solid black;
        display: block;
        margin: 20px auto;
    }

    .buttons {
        text-align: center;
        margin-top: 10px;
    }

    #signatureImage {
        margin-top: 20px;
        display: none;
        border: 1px solid black;
    }
</style>