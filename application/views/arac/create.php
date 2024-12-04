<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-form-label">Firma</label>
                                    <select class="form-control select-box firma_id required" id="firma_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_customer() as $emp){
                                            $emp_id=$emp->id;
                                            $name=$emp->company;
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Plaka NO</label>
                                    <input class="form-control" type="text" id="plaka_no">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Araç Adı</label>
                                    <input class="form-control" type="text" id="name">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-info sub-btn btn-lg" id="talep_create">Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .table th, .table td {
        padding-left: 0px;
    }
</style>

<script>

    $(document).on('click', "#talep_create", function (e) {
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Araç Kaydı',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            columnClass: 'small',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: 'Araç Oluşturmak Üzeresiniz Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Kaydet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            firma_id : $('#firma_id').val(),
                            plaka_no : $('#plaka_no').val(),
                            name : $('#name').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'arac/create_save',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Araç Listesi',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.href=responses.index;
                                            }
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'material',
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
                                $('#loading-box').addClass('d-none');
                            }
                        });



                    }
                },
                cancel:{
                    text: 'Kapat',
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
