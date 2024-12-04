<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yeni Lojistik Talebi</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <div class="message"></div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <form method="post" id="data_form">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Lojistik Müdürü</label>
                                                            <select class="form-control select-box lojistik_muduru required" id="lojistik_muduru">
                                                                <?php foreach (personel_list() as $emp){
                                                                    $emp_id=$emp['id'];
                                                                    $name=$emp['name'];
                                                                    ?>
                                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Proje Müdürü</label>
                                                            <select class="form-control select-box proje_muduru required" id="proje_muduru">
                                                                <?php foreach (personel_list() as $emp){
                                                                    $emp_id=$emp['id'];
                                                                    $name=$emp['name'];
                                                                    ?>
                                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Genel Müdürü</label>
                                                            <select class="form-control select-box genel_mudur_id required" id="genel_mudur_id">
                                                                <?php foreach (personel_list() as $emp){
                                                                    $emp_id=$emp['id'];
                                                                    $name=$emp['name'];
                                                                    ?>
                                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="col-form-label">Açıklama</label>
                                                            <input type="text" class="form-control required" name="desc" id="desc">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <table class="table lojistik_table">
                                                        <thead>
                                                        <tr>
                                                            <td width="10%">Proje</td>
                                                            <td width="10%">Başlangıç ve Bitiş Noktası</td>
                                                            <td width="15%">Açıklama</td>
                                                            <td width="10%">Sf No</td>
                                                            <td width="10%">Araç</td>
                                                            <td width="15%">Miktar</td>
                                                            <td width="15%">Birim</td>
                                                            <td>İşlem</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <select class="form-control select-box proje_id required" name="proje_id[]">
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_projects() as $emp){
                                                                        ?>
                                                                        <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <!--                                            <input type="text" name="location[]" class="form-control location">-->

                                                                <select class="form-control location" multiple="multiple" name="location[]">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="desc[]" class="form-control desc">
                                                            </td>
                                                            <td>
                                                                <select class="form-control select-box sf_id" multiple="multiple" name="sf_id[]">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control select-box arac_id required" name="arac_id[]">
                                                                    <?php foreach (araclar() as $emp){
                                                                        ?>
                                                                        <option value="<?php echo $emp->id; ?>"><?php echo $emp->name.' '.$emp->code; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="qty[]" class="form-control qty">
                                                            </td>
                                                            <td>
                                                                <select class="form-control select-box unit_id required" name="unit_id[]">
                                                                    <?php foreach (units() as $emp){
                                                                        ?>
                                                                        <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div>
                                                        <button id="add_product" type="button" class="btn btn-success btn-sm">Satır Ekle</button>
                                                    </div>
                                                    <div style="float: right;">
                                                        <button type="button" class="btn btn-info sub-btn btn-lg" id="talep_create">Talep Oluştur</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
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




<style>
    .table th, .table td {
        padding-left: 0px;
    }
</style>

<script>
    $('#add_product').on('click', function () {
        let data=`<tr>
                <td><select class="form-control select-box proje_id required" name="proje_id[]">
                 <option value="">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                     ?>
                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                <?php } ?>
                    </select>
                    </td>
                   <td>  <select class="form-control location" multiple="multiple" name="location[]">
                                            </select></td>
                   <td><input type="text" name="desc[]" class="form-control desc"></td>
                    <td>
                                            <select class="form-control select-box sf_id" multiple="multiple" name="sf_id[]">
                                            </select>
                                        </td>
                   <td>
                        <select class="form-control select-box arac_id required" name="arac_id[]">
                        <?php foreach (araclar() as $emp){
                                 ?>
                            <option value="<?php echo $emp->id; ?>"><?php echo $emp->name.' '.$emp->code; ?></option>
                        <?php } ?>
                        </select>
                </td>
                <td><input type="number" name="qty[]" class="form-control qty"></td>
                <td> <select class="form-control select-box unit_id required" name="unit_id[]">
                                                <?php foreach (units() as $emp){
        ?>
                                                    <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                                <?php } ?>
                                            </select></td>
                <td><button type="button" class="btn btn-danger remove" title="Sil"><i class="fa fa-minus-square"></i></button></td>
            </tr>`;

                $('.lojistik_table tbody ').append(data);
                $('.select-box').select2();
                $('.location').select2({
                    tags: true
                });
    })


    $("table.lojistik_table").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();
    });

    $(document).on('click', "#talep_create", function (e) {
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Lojistik Talebi Oluşturma',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            columnClass: 'small',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: 'Lojistik Talebi Oluşturmak Üzeresiniz Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Talep Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let product_details = [];
                        let count = $('.proje_id').length;
                        for (let i=0; i < count; i++){
                            product_details.push({
                                'proje_id':$('.proje_id').eq(i).val(),
                                'location':$('.location').eq(i).val(),
                                'sf_no':$('.sf_id').eq(i).val(),
                                'desc':$('.desc').eq(i).val(),
                                'arac_id':$('.arac_id').eq(i).val(),
                                'qty':$('.qty').eq(i).val(),
                                'unit_id':$('.unit_id').eq(i).val(),
                            });
                        }
                        let data = {
                            lojistik_muduru : $('#lojistik_muduru').val(),
                            proje_muduru : $('#proje_muduru').val(),
                            genel_mudur_id : $('#genel_mudur_id').val(),
                            desc : $('#desc').val(),
                            product_details:product_details,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'lojistik/create_save',data,(response)=>{
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
                                            text: 'Talebi Görüntüle',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.href=responses.view;
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

    $(document).on('change','.proje_id',function (){
        let index_eq =$(this).parent().parent().index();
        let data = {
            proje_id : $(this).val(),
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'lojistik/proje_to_sf',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status=='Success'){
                let options='';
                responses.items.forEach((item_,j) => {
                    let newOption = new Option(item_.talep_no, item_.id, false, false);
                    $('.sf_id').eq(index_eq).append(newOption).trigger('change');
                })


            }
        });
    })

    $(document).ready(function (){
        $('.location').select2({
            tags: true
        });
    })
</script>
