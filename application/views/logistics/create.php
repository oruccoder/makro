<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yeni Lojistik Satınalması</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<div class="content">
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
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
                                        <label class="col-form-label">Açıklama</label>
                                        <input type="text" class="form-control required" name="desc" id="desc">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Lojistik Talepleri</label>
                                        <select class="form-control select-box lojistik_talep_id required" multiple id="lojistik_talep_id">
                                            <option value="">Seçiniz</option>
                                            <?php foreach (lojistik_talepleri() as $emp){
                                                $emp_id=$emp->id;
                                                $name=$emp->talep_no;
                                                ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <style>
                                table input.form-control[type="text"]
                                {
                                    width: auto !important;
                                }
                                table select
                                {
                                    width: 200px !important;
                                }
                                table input.form-control[type="number"]
                                {
                                    width: 200px !important;
                                }
                            </style>
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table lojistik_table" >
                                    <thead>
                                    <tr class="item_header bg-gradient-directional-green white">
                                        <td class="text-center" >Proje</td>
                                        <td class="text-center" >Lokasyonlar</td>
                                        <td class="text-center" >SF No</td>
                                        <td class="text-center" >Açıklama</td>
                                        <td class="text-center" >Karşılama Personeli</td>
                                        <td class="text-center" >Araç</td>
                                        <td class="text-center" >Firma</td>
                                        <td class="text-center" >Protokol</td>
                                        <td class="text-center" >Miktar</td>
                                        <td class="text-center" >Birim</td>
                                        <td class="text-center" >Birim Fiyatı</td>
                                        <td class="text-center" >KDV Durum</td>
                                        <td class="text-center" >KDV Oranı</td>
                                        <td class="text-center" >Ödeme Metodu</td>
                                        <td class="text-center">İşlem</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control select-box proje_id required" name="proje_id[]">
                                                <?php foreach (all_projects() as $emp){
                                                    ?>
                                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select-box location required" name="location[]">
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select-box sf_id required" name="sf_id[]">

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="desc[]" class="form-control desc">
                                        </td>
                                        <td>
                                            <select class="form-control select-box personel_id required">
                                                <?php foreach (personel_list() as $emp){
                                                    $emp_id=$emp['id'];
                                                    $name=$emp['name'];
                                                    ?>
                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select-box arac_id required" name="arac_id[]">
                                                <?php foreach (araclar() as $emp){
                                                    ?>
                                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select-box firma_id required" name="firma_id[]">
                                                <option value="0">Seçiniz</option>
                                                <?php foreach (all_customer() as $emp){
                                                    ?>
                                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->company; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control protokol select-box" name="protokol[]">
                                                <option value="0">Firma Seçiniz</option>
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
                                            <input type="number" value="0" class="form-control price">
                                        </td>
                                        <td>
                                            <select class="form-control select-box kdv_durum required">
                                                <option value="0">Hariç</option>
                                                <option value="1">Dahil</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" value="0" class="form-control kdv_oran">
                                        </td>
                                        <td>
                                            <select class="form-control select-box account_type required" name="account_type[]">
                                                <?php foreach (account_type() as $emp){
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
                                    <!--                                <button id="add_product" type="button" class="btn btn-success btn-sm">Satır Ekle</button>-->
                                </div>


                            </div>
                            <div class="col-md-12" style="padding-top: 14px;">
                                <button type="button" class="btn btn-info sub-btn btn-lg" id="talep_create">Talep Oluştur</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .table th, .table td {
        padding-left: 0px;
    }
    .bg-gradient-directional-green {
        background-image: -webkit-linear-gradient(45deg, #18b396, #18b396);
        background-image: -moz-linear-gradient(45deg, #1976D2, #64B5F6);
        background-image: -o-linear-gradient(45deg, #1976D2, #64B5F6);
        background-image: linear-gradient(45deg, #18b396, #178b75);
        background-repeat: repeat-x;
    }
</style>



<script>
    $('#add_product').on('click', function () {
        let data=`  <tr>
                                    <td>
                                        <select class="form-control select-box proje_id required" name="proje_id[]">
                                            <?php foreach (all_projects() as $emp){
        ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                         <select class="form-control location" multiple="multiple" name="location[]">
                                            </select>
                                    </td>
                                    <td>
                                        <input type="text" name="desc[]" class="form-control desc">
                                    </td>

                                    <td>
                                        <select class="form-control select-box arac_id required" name="arac_id[]">
                                            <?php foreach (araclar() as $emp){
        ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                        <td>
                                        <select class="form-control select-box firma_id required" name="firma_id[]">
                                         <option value="0">Seçiniz</option>
                                            <?php foreach (all_customer() as $emp){
        ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->company; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                     <td>
                                        <select class="form-control protokol select-box" name="protokol[]">
                                         <option value="0">Firma Seçiniz</option>
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
                                        <input type="number" value="0" class="form-control price">
                                    </td>
                                    <td>
                                        <select class="form-control select-box kdv_durum required">
                                                <option value="0">Hariç</option>
                                                <option value="1">Dahil</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="0" class="form-control kdv_oran">
                                    </td>
                                    <td>
                                        <select class="form-control select-box account_type required" name="account_type[]">
                                            <?php foreach (account_type() as $emp){
                                                ?>
                                                <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                <td>
                <div class="row">
                <button type="button" class="btn btn-danger btn-sm remove" title="Sil"><i class="fa fa-minus-square"></i></button>&nbsp;
                </td>
                </div>
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

    $(document).on('change','#lojistik_talep_id',function (e) {
        let id = $(this).val();
        let selected_id = [];
        let data_post = {
            crsf_token: crsf_hash,
            id: id,
            type: 1,
        }
        $.post(baseurl + 'logistics/get_lojistik',data_post,(response) => {
            let responses = jQuery.parseJSON(response);
            let  table='';
            if(responses.details.length > 0){
                let count=0;

                $('.lojistik_table tbody tr').remove();
                let i = 0;
                responses.details.forEach((item_,j) => {

                    let options_loc='';
                    let options_sf='';
                    item_.locations.forEach((loc,i) => {
                        options_loc+='<option selected value="'+loc.id+'">'+loc.location+'</option>'
                    })

                    if(item_.sf_no){
                        item_.sf_no.forEach((loc,i) => {
                            options_sf+='<option selected value="'+loc.id+'">'+loc.talep_no+'</option>'
                        })
                    }

                    let data=`  <tr>
                                    <td>
                                        <select class="form-control select-box proje_id required" name="proje_id[]">
                                        <option selected value='`+item_.proje_id+`'>`+item_.proje_name+`</option>
                                            <?php foreach (all_projects() as $emp){
                    ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                    <select class="form-control select-box location required" multiple name="location[]">
                                       `+options_loc+`
                                    </select>
                                    </td>
                                        <td>
                                    <select class="form-control select-box sf_no required" multiple name="sf_no[]">
                                       `+options_sf+`
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="desc[]"  value='`+item_.desc+`'  class="form-control desc">
                                    </td>
                                       <td>
                                        <select class="form-control select-box personel_id required" >
                                            <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control select-box arac_id required" name="arac_id[]">
                                          <option selected value='`+item_.arac_id+`'>`+item_.arac_name+`</option>
                                            <?php foreach (araclar() as $emp){
                    ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select-box firma_id required" name="firma_id[]">
                                         <option value="0">Seçiniz</option>
                                            <?php foreach (all_customer() as $emp){
                    ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->company; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control protokol select-box"  name="protokol[]">
                                         <option value="0">Firma Seçiniz</option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" name="qty[]" value='`+item_.qty+`' desc class="form-control qty">
                                    </td>
                                    <td>
                                        <select class="form-control select-box unit_id required" name="unit_id[]">
                                             <option selected value='`+item_.unit_id+`'>`+item_.unit_name+`</option>
                                            <?php foreach (units() as $emp){
                    ?>
                                                <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="0" class="form-control price">
                                    </td>
                                    <td>
                                        <select class="form-control select-box kdv_durum required">
                                                <option value="0">Hariç</option>
                                                <option value="1">Dahil</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="0" class="form-control kdv_oran">
                                    </td>
                                    <td>
                                        <select class="form-control select-box account_type required" name="account_type[]">
                                            <?php foreach (account_type() as $emp){
                    ?>
                                                <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                <td>
                <div class="row">
                <button type="button" class="btn btn-danger btn-sm remove" title="Sil"><i class="fa fa-minus-square"></i></button>&nbsp;
                <button type="button" class="btn btn-warning clone btn-sm" title="Kopyala"
                proje_id='`+item_.proje_id+`'
                proje_name='`+item_.proje_name+`'
                location='`+item_.location+`'
                desc='`+item_.desc+`'
                qty='`+item_.qty+`'
                unit_id='`+item_.unit_id+`'
                unit_name='`+item_.unit_name+`'
                arac_id='`+item_.arac_id+`'
                arac_name='`+item_.arac_name+`'
                options_loc='`+options_loc+`'
                options_sf='`+options_sf+`'
                ><i class="fa fa-clone"></i></button></td>
                </div>
            </tr>`;

                    $('.lojistik_table tbody ').append(data);
                    $('.select-box').select2();
                })



            }


        });



    })

    $(document).on('click', '.clone', function (e) {
        let proje_id = $(this).attr("proje_id");
        let proje_name = $(this).attr("proje_name");
        let location = $(this).attr("location");
        let qty = $(this).attr("qty");
        let desc = $(this).attr("desc");
        let unit_id = $(this).attr("unit_id");
        let unit_name = $(this).attr("unit_name");
        let arac_name = $(this).attr("arac_name");
        let arac_id = $(this).attr("arac_id");
        let options_loc = $(this).attr("options_loc");
        let options_sf = $(this).attr("options_sf");

        let data=`  <tr>
                                    <td>
                                        <select class="form-control select-box proje_id required" name="proje_id[]">
                                        <option selected value='`+proje_id+`'>`+proje_name+`</option>
                                            <?php foreach (all_projects() as $emp){
        ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                 <td>
                                    <select class="form-control select-box location required" multiple name="location[]">
                                       `+options_loc+`
                                    </select>
                                    </td>
                                        <td>
                                    <select class="form-control select-box sf_no required" multiple name="sf_no[]">
                                       `+options_sf+`
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="desc[]"  value='`+desc+`'  class="form-control desc">
                                    </td>
                                       <td>
                                        <select class="form-control select-box personel_id required">
                                            <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control select-box arac_id required" name="arac_id[]">
                                          <option selected value='`+arac_id+`'>`+arac_name+`</option>
                                            <?php foreach (araclar() as $emp){
        ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                        <td>
                                        <select class="form-control select-box firma_id required" name="firma_id[]">
                                         <option value="0">Seçiniz</option>
                                            <?php foreach (all_customer() as $emp){
        ?>
                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->company; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control protokol select-box"  name="protokol[]">
                                         <option value="0">Firma Seçiniz</option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" name="qty[]" value='`+qty+`' desc class="form-control qty">
                                    </td>
                                    <td>
                                        <select class="form-control select-box unit_id required" name="unit_id[]">
                                             <option selected value='`+unit_id+`'>`+unit_name+`</option>
                                            <?php foreach (units() as $emp){
        ?>
                                                <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="0" class="form-control price">
                                    </td>
                                    <td>
                                        <select class="form-control select-box kdv_durum required">
                                                <option value="0">Hariç</option>
                                                <option value="1">Dahil</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="0" class="form-control kdv_oran">
                                    </td>
                                    <td>
                                        <select class="form-control select-box account_type required" name="account_type[]">
                                            <?php foreach (account_type() as $emp){
        ?>
                                                <option value="<?php echo $emp['id']; ?>"><?php echo $emp['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                <td>
                <div class="row">
                <button type="button" class="btn btn-danger btn-sm remove" title="Sil"><i class="fa fa-minus-square"></i></button>&nbsp</td>
                </div>
            </tr>`;

        $('.lojistik_table tbody ').append(data);
        $('.select-box').select2();

    })
    $(document).on('click', "#talep_create", function (e) {
        let talep_id  = $('#lojistik_talep_id').val()
        if(talep_id.length > 0) {
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
                                    'sf_no':$('.sf_no').eq(i).val(),
                                    'personel_id':$('.personel_id').eq(i).val(),
                                    'desc':$('.desc').eq(i).val(),
                                    'firma_id':$('.firma_id').eq(i).val(),
                                    'protokol':$('.protokol').eq(i).val(),
                                    'arac_id':$('.arac_id').eq(i).val(),
                                    'qty':$('.qty').eq(i).val(),
                                    'unit_id':$('.unit_id').eq(i).val(),
                                    'price':$('.price').eq(i).val(),
                                    'kdv_durum':$('.kdv_durum').eq(i).val(),
                                    'kdv_oran':$('.kdv_oran').eq(i).val(),
                                    'account_type':$('.account_type').eq(i).val(),
                                });

                                if($('.protokol').eq(i).val()=='0'){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content:'Protokol Seçmeniz Gerekmektedir!',
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');
                                    return false;
                                }
                                if($('.firma_id').eq(i).val()=='0'){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content:'Firma Seçmeniz Gerekmektedir!',
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');
                                    return false;
                                }
                            }
                            let data = {
                                lojistik_muduru : $('#lojistik_muduru').val(),
                                proje_muduru : $('#proje_muduru').val(),
                                genel_mudur_id : $('#genel_mudur_id').val(),
                                desc : $('#desc').val(),
                                lojistik_talep_id : $('#lojistik_talep_id').val(),
                                product_details:product_details,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'logistics/create_save',data,(response)=>{
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
        }
        else {

            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content:'Lojistik Talebi Seçmeniz Gerekmektedir!',
                buttons: {
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }

    })

    $("table.lojistik_table").on("click", ".remove", function (event) {
        $(this).closest("tr").remove();
    });

    $(document).ready(function (){
        $('.location').select2({
            tags: true
        });
    })

    $(document).on('change','.firma_id',function (){
        let index_eq =$(this).parent().parent().index();
        let data = {
            firma_id : $(this).val(),
            crsf_token: crsf_hash,
        }
        $.post(baseurl + 'logistics/firma_to_protokol',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            if(responses.status=='Success'){
                let options='';
                $('.protokol').eq(index_eq).empty();
                let newOption = new Option('Protokol Seçiniz', 0, false, false);
                $('.protokol').eq(index_eq).append(newOption);
                responses.items.forEach((item_,j) => {
                    let newOption = new Option(item_.code, item_.id, false, false);
                    $('.protokol').eq(index_eq).append(newOption);
                })


            }
        });
    })

    $(document).on('change','.protokol',function (){
        let id = $(this).val();
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'RAZILAŞTIRMA PROTOKOLÜ',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            columnClass: 'xlarge',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<label>Proje</label></br>' +
                    '<b><span id="proje_id"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Ödeme Tipi</label></br>' +
                    '<b><span id="odeme_tipi"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Ödeme Şekli</label></br>' +
                    '<b><span id="odeme_sekli"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Para Birimi</label></br>' +
                    '<b><span id="cur_id"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>KDV Durum</label></br>' +
                    '<b><span id="kdv_durum"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>KDV Oranı</label></br>' +
                    '<b><span id="kdv_oran"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Avans Oranı</label></br>' +
                    '<b><span id="oran"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Muqavele No</label></br>' +
                    '<b><span id="muqavele_no"></span></b>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<label>Geçerlilik Tarihi</label></br>' +
                    '<b><span id="date"></span></b>' +
                    '</div>' +
                    '<div class="col-md-12">' +
                    '<label>PDF</label></br>' +
                    '<b><span id="pdf"></span></b>' +
                    '</div>' +
                    '<div class="col-md-12 table_rp_view">'+
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';


                let data = {
                    crsf_token: crsf_hash,
                    id:  id,
                }

                let table_report='';
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#proje_id').empty().html(responses.details.proje_name)
                    $('#odeme_tipi').empty().html(responses.details.odeme_tipi_name)
                    $('#odeme_sekli').empty().html(responses.details.odeme_sekli_name)
                    $('#oran').empty().html(responses.details.oran)
                    $('#muqavele_no').empty().html(responses.details.muqavele_no)
                    $('#date').empty().html(responses.details.date)
                    $('#cur_id').empty().html(responses.cur_name)
                    $('#kdv_durum').empty().html(responses.tax_durum)
                    $('#kdv_oran').empty().html(responses.details.tax_oran)
                    $('#pdf').empty().html("<a href='/userfiles/product/"+responses.details.file+"' class='btn btn-info' target='_blank'>PDF GÖRÜNTÜLE</a>")
                    table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Görülecek İş</th>
                                <th>Birim Fiyatı</th>
                                <th>Miktarı</th>
                                <th>Birim</th>
                            </tr>
                        </thead><tbody id="todo_tbody">`;

                    responses.item_details.forEach((item_,index) => {
                        table_report+=` <tr>
                                            <td>`+item_.name+`</td>
                                            <td>`+item_.price+`</td>
                                            <td>`+item_.qty+`</td>
                                            <td>`+item_.unit_name+`</td>
                                            </tr>`;
                    });


                    table_report+=`</tbody></table>`;
                    $('.table_rp_view').empty().html(table_report);


                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
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

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        font-size: 10px !important;
        border: none;
        border-radius: 0px;
        padding-bottom: 0px !important;
        float: none;
    }
    .select2-container--classic .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-selection--multiple .select2-selection__choice{
        padding: 0px 4px !important;
        margin-top: 2px !important;
    }
</style>
