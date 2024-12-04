<div class="content-body">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <div class="card">
        <div class="card-content">

            <div class="content-body">
                <div id="invoice-template" class="card-body" style="text-align: center;">

                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location(5);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="" style="max-height: 70px;"><br><br>
                            <p>Yönlendiren Personel : <b><?php echo $yonlendirme_personeli ?></b></p>
                            <form >
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Araç Adı</label>
                                    <input disabled class="form-control" value="<?php  echo $arac_adi; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Plaka</label>
                                    <input disabled class="form-control" value="<?php  echo $plaka; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sürücü</label>
                                    <input disabled class="form-control" value="<?php  echo $sofor_adi; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sürücü Telefon</label>
                                    <input disabled class="form-control" value="<?php  echo $tel; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mevcut Durum</label>
                                    <input disabled class="form-control" value="<?php  echo $mvcut_status; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Durum</label>
                                    <select class="form-control" id="status">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach ($statusler as $items){
                                            echo "<option value='$items->id'>$items->name</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Aracı Personele Yönlendir</label>
                                    <small id="emailHelp" class="form-text text-muted">Eğer Araca Tekrar Durum Bildirmeyecekseniz Aracı Yeni Personele Atayabilirsiniz</small>
                                    <select class="form-control select-box" id="pers_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach ($employe_list as $items){
                                            echo "<option value='$items->id'>$items->name</option>";
                                        } ?>
                                    </select>
                                </div>
                                <button type="button" id="guncelle" personel_histort_id="<?php echo $personelen_history_id ?>"  aaut_id="<?php echo $aaut_id ?>" class="btn btn-primary">Güncelle</button>
                            </form>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

</script>



<script type="text/javascript">

    $(document).on('click', "#guncelle", function (e) {
        let personel_histort_id = $(this).attr('personel_histort_id');
        let status = $('#status').val();
        let pers_id = $('#pers_id').val();
        let aaut_id = $(this).attr('aaut_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Durum Bildir',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: '<p>Araca Yeni Durum Bildirmek Üzeresiniz Emin Misiniz?</p></br><input class="form-control" placeholder="İnceledim Durum Değiştiriyorum" id="desc">',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-success',
                    action: function () {
                        let desc = $('#desc').val()
                        let placeholder =$('#desc').attr('placeholder');
                        let value =$('#desc').val()
                        if(value.length == 0){
                            desc = placeholder;
                        }
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            desc:desc,
                            personel_histort_id:personel_histort_id,
                            status:status,
                            pers_id:pers_id,
                            aaut_id:aaut_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'billing/updata_car_status',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat',
                                    content:responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                            }
                            $('#loading-box').addClass('d-none');
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

    $(function () {
        $('.select-box').select2();
        $('.summernote').summernote({
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });

    });





</script>
