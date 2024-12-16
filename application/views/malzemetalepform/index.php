<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Malzema Talep Listesi</span></h4>
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
                        <fieldset class="mb-3">
                            <?php $this->load->view('malzemetalepform/mtheader');?>
                        </fieldset>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Tələn Nomresi</th>
                            <th>Təcili</th>
                            <th>İstək Tarixi</th>
                            <th>Tələb Açan</th>
                            <th>Layihə</th>
                            <th>Vəziyyət</th>
                            <th>Transfer Durum</th>
                            <th>Onay Kimde</th>
                            <th>Gecikme Tarihi</th>
                            <th>İşlemler</th>
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
<script>
    $(document).ready(function () {
        draw_data()
    });
    function draw_data(status_id = 0) {
        $('#invoices').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                responsive: true,
                order: [],
                ajax: {
                url: "<?php echo site_url('malzemetalepform/ajax_list') ?>",
                    type: 'POST',
                    data: {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        'status_id': status_id,
                }
        },
        createdRow: function (row, data) {
            $(row).attr('style', data[10]);
        },
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
            dom: 'Blfrtip',
            buttons: [{
            text: '<i class="fa fa-plus"></i> Yeni Talep Oluştur',
            action: function () {
                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: 'Yeni Talep Ekleyin',
                    icon: 'fa fa-plus',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-8 mx-auto",
                    containerFluid: true,
                    smoothContent: true,
                    draggable: false,
                    content: generateFormContent(),
                    buttons: {
                        formSubmit: {
                            text: 'Sorunu Açın',
                            btnClass: 'btn-blue',
                            action: function () {
                                if (!validateForm()) return false;

                                $('#loading-box').removeClass('d-none');
                                let data = {
                                    crsf_token: crsf_hash,
                                    progress_status_id: $('#progress_status_id').val(),
                                    talep_eden_user_id: $('#talep_eden_user_id').val(),
                                    proje_id: $('#proje_id').val(),
                                    bolum_id: $('#bolum_id').val(),
                                    asama_id: $('#asama_id').val(),
                                    desc: $('#desc').val(),
                                };

                                $.post(baseurl + 'malzemetalepform/create_save', data, (response) => {
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
        }]
    });
    }
    // Form HTML içeriğini oluşturma
    function generateFormContent() {
        return `
    <form>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="proje_id">Proje</label>
                <select class="form-control select-box proje_id required" id="proje_id">
                    <option value="0">Seçiniz</option>
                    <?php foreach (all_projects() as $emp): ?>
                        <option value="<?php echo $emp->id; ?>"><?php echo $emp->code; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="bolum_id">Proje Bölümü</label>
                <select class="form-control select-box" id="bolum_id">
                    <option value="0">Seçiniz</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="asama_id">Proje Aşaması</label>
                <select class="form-control select-box" id="asama_id">
                    <option value="0">Seçiniz</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="talep_eden_user_id">Talep Eden</label>
                <select class="form-control select-box" id="talep_eden_user_id">
                    <option value="0">Seçiniz</option>
                    <?php foreach (all_personel() as $emp): ?>
                        <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="progress_status_id">Təcili</label>
                <select class="form-control select-box" id="progress_status_id">
                    <?php foreach (progress_status() as $emp): ?>
                        <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="desc">Açıklama / Qeyd</label>
                <textarea class="form-control" id="desc"></textarea>
            </div>
        </div>
    </form>`;
    }

    // Form doğrulama işlemi
    function validateForm() {
        const requiredFields = [
            { id: 'proje_id', message: 'Proje Zorunludur' },
            { id: 'bolum_id', message: 'Bölüm Zorunludur' },
            { id: 'asama_id', message: 'Aşama Zorunludur' },
            { id: 'talep_eden_user_id', message: 'Talep Eden Personel Zorunludur' }
        ];

        for (const field of requiredFields) {
            if (!parseInt($(`#${field.id}`).val())) {
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: field.message,
                    buttons: {
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark"
                        }
                    }
                });
                return false;
            }
        }
        return true;
    }

    // Response durumunu işleme
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
                        btnClass: "btn btn-link text-dark"
                    }
                }
            });
        }
    }

    $(document).on('change','.proje_id',function (){
        $("#asama_id option").remove();
        $("#bolum_id option").remove();
        let proje_id  =$(this).val();
        let data = {
            crsf_token: crsf_hash,
            pid: proje_id,
        }
        $.post(baseurl + 'projects/proje_bolum_ajax',data,(response) => {
            let responses = jQuery.parseJSON(response);
            responses.forEach((item_,index) => {
                $('#bolum_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
            })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })

    $(document).on('change','#bolum_id',function (){
        $("#asama_id option").remove();
        let bolum_id  =$(this).val();
        let proje_id  =$('.proje_id').val();
        let data = {
            crsf_token: crsf_hash,
            bolum_id: bolum_id,
            asama_id: 0,
            proje_id: proje_id,
        }
        $.post(baseurl + 'projects/proje_asamalari_ajax',data,(response) => {
            let responses = jQuery.parseJSON(response);
            responses.forEach((item_,index) => {
                $('#asama_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
            })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })

</script>