<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bordro İşlemleri</span></h4>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table class="table datatable-show-all" id="personel" width="100%">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>No</td>
                                                <td>Bordro Tarihi</td>
                                                <td>Proje</td>
                                                <td>Oluşturan Personel</td>
                                                <td>Açıklama</td>
                                                <td>Durum</td>
                                                <td>Detaylar</td>
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

<script>
    $(document).ready(function () {
        $('.select-box').select2();
        draw_data();
    })
    function draw_data() {
        $('#personel').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('salary/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-user-plus"></i> Yeni Bordro Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Bordro ',
                            icon: 'fa fa-user-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                  <div class="form-row">
                                       <div class="form-group col-md-6">
                                          <label for="name">Bordro Yılı</label>
                                             <select class='form-control select-box' id='bordro_yili'>
                                               <option value="2023">2023</option>
                                               <option value="2024">2024</option>
                                               <option value="2025">2025</option>
                                               <option value="2026">2026</option>
                                           </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="name">Bordro Ayı</label>
                                          <select class='form-control select-box' id='bordro_ayi'>
                                          <?php foreach (az_month() as $items) {
                                                 echo "<option value='$items->id'>$items->month</option>";
                                            }
                                            ?>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                         <div class="form-group col-md-12">
                                            <label>Proje</label>
                                            <select class="form-control name select-box name" name="proje_id_modal" id="proje_id_modal">
                                            <option value=''>Seçiniz</option>
                                                  <?php foreach (all_projects() as $items) {
                                                        echo "<option value='$items->id'>$items->name</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                           <label>Personeller</label>
                                           <select class="form-control select-box zorunlu_text" name="pers_id[]" multiple id="pers_id"><option>Seçiniz</option>
                                           </select>
                                        </div>
                                    </div>
                                        <div class="form-row">
                                         <div class="form-group col-md-12">
                                              <label for="name">Açıklama</label>
                                               <input type='text' class='form-control' id='desc'>
                                        </div>
                                    </div>
                                </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let name_say = $('.zorunlu_text').length;
                                        let req = 0 ;
                                        for (let i = 0; i < name_say;i++){
                                            let name = $('.zorunlu_text').eq(i).val();
                                            if(!(name)){
                                                req++;
                                            }
                                        }
                                        if(req > 0){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Tüm Alanlar Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            bordro_yili:  $('#bordro_yili').val(),
                                            bordro_ayi:  $('#bordro_ayi').val(),
                                            proje_id:  $('#proje_id_modal').val(),
                                            pers_id:  $('#pers_id').val(),
                                            desc:  $('#desc').val(),
                                        }
                                        $.post(baseurl + 'salary/create_save',data,(response) => {
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
                                                                window.location.href= responses.link;
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
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $(document).on('change','#proje_id_modal',function (e){

                                    let data = {
                                        crsf_token: crsf_hash,
                                        proje_id : $(this).val()
                                    }

                                    $.post(baseurl + 'employee/proje_to_pers',data,(response) => {
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm-box-container")
                                        });
                                        $('#pers_id').empty().trigger("change");
                                        let responses = jQuery.parseJSON(response);
                                        $('#pers_id').append(new Option('Tüm Projedeki Personeller', 0, false, false)).trigger('change');
                                        responses.item.forEach((item_,index) => {
                                            $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                                        })
                                    });
                                })
                            }
                        });
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [2,3,4]
                    }
                }
            ]
        });
    };

    $(document).on('click', ".iptal", function (e) {
        let bordro_id = $(this).data('id');
        let status = 3;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Bordro İptal Etmek Üzeresiniz? Emin Misiniz?<p/>' +
                '<label>Açıklama</label>' +
                '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control name" />' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Açıklama Zorunludur',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            bordro_id: bordro_id,
                            status: status,
                            desc: name,
                        }
                        $.post(baseurl + 'salary/status_change', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status == 200) {
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
                                                $('#personel').DataTable().destroy();
                                                draw_data();
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
                                            btnClass: "btn btn-link text-dark",
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
</script>