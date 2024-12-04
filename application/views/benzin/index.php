<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Yanacaq Çeni Kontrol Paneli</span></h4>
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
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-6 col-sm-6 col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="text-black" href="#">
                                                <div class="d-flex justify-content-between px-md-1">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-money-bill text-info fa-5x"></i>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-0">Tüm Yanacaq</p>
                                                        <h4 class="pt-1 mt-2 mb-0" id="all_balance"><?php echo benzin_bakiye()?></h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-6 col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="text-black cart_count" href="#">
                                                <div class="d-flex justify-content-between px-md-1">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-credit-card text-success fa-5x"></i>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-0">Çen Sayısı</p>
                                                        <h4 class="pt-1 mt-2 mb-0" id="cart_count"><?php echo benzin_cen_count();?></h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <button class="btn btn-success balance_update" type="button"><i class="fa fa-plus"></i> Yanacaq Elave Et</button>
                        <button class="btn btn-info new_kart" type="button"><i class="fas fa-credit-card"></i> Çen Elave Et</button>
                        <button class="btn btn-warning kart_to_bakiye" type="button"><i class="fas fa-credit-card"></i> Çene Yanacaq Elave Et</button>
                        <button class="btn btn-purple car_to_kart" type="button"><i class="fas fa-car"></i> Maşına Yanacaq Elave Et</button>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="card mobile_hidden">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <section>
                                        <div class="row">
                                            <div class="container-fluid">
                                                <nav>
                                                    <div class="nav nav-tabs nav-tabs-solid nav-justified border mb-3" id="nav-tab" role="tablist">
                                                        <a class="nav-item nav-link active" id="nav-bakiye-hareketleri" data-toggle="tab" href="#b_hareketleri" role="tab" aria-controls="nav-bakiye-hareketleri" aria-selected="true">Yanacaq HAREKETLERI</a>
                                                        <a class="nav-item nav-link" id="nav-kart-bakiye-hareketleri" data-toggle="tab" href="#k_hareketleri" role="tab" aria-controls="nav-kart-bakiye-hareketleri" aria-selected="false">ÇEN Yanacaq HAREKETLERI</a>
                                                        <a class="nav-item nav-link" id="nav-arac-kart-hareketleri" data-toggle="tab" href="#a_hareketleri" role="tab" aria-controls="nav-arac-kart-hareketleri" aria-selected="false">ARAÇ Yanacaq HAREKETLERI</a>
                                                    </div>
                                                </nav>
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="b_hareketleri" role="tabpanel" aria-labelledby="nav-home-tab">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table" id="bakiye_table" width="100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Tarih</th>
                                                                        <th>İşlemi Yapan Personel</th>
                                                                        <th>Çen Kodu</th>
                                                                        <th>Benzin Tipi</th>
                                                                        <th>Araç Kodu - Plakası</th>
                                                                        <th>Tip</th>
                                                                        <th>Litr</th>
                                                                        <th>Açıklama</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show" id="k_hareketleri" role="tabpanel" aria-labelledby="nav-home-tab">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table" id="kart_bakiye_table" width="100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Tarih</th>
                                                                        <th>Çen Kodu</th>
                                                                        <th>Yanacaq Növü</th>
                                                                        <th>İşlemi Yapan Personel</th>
                                                                        <th>Tip</th>
                                                                        <th>Tutar</th>
                                                                        <th>Açıklama</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show" id="a_hareketleri" role="tabpanel" aria-labelledby="nav-home-tab">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table" id="arac_hareketleri" width="100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Tarih</th>
                                                                        <th>Çen Kodu</th>
                                                                        <th>Araç Plaka No</th>
                                                                        <th>İşlemi Yapan Personel</th>
                                                                        <th>Tip</th>
                                                                        <th>Tutar</th>
                                                                        <th>Açıklama</th>
                                                                        <th>Cari Durumu</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
    </div>
</div>
<script>
    $(document).on('click','.benzin_type_change',function (){
        let bakiye_id = $(this).attr('bakiye_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yanacaq Tipi Belirle',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-row">
<div class="form-group col-md-12">
                          <label for="name">Yanacaq Tipi</label>
                           <select class="form-control select-box" id="benzin_type_id">
                            <?php foreach (benzin_type_list() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Elave Et',
                    btnClass: 'btn-blue',
                    action: function () {


                        $('#loading-box').removeClass('d-none');

                        let data = {
                            benzin_type_id:  $('#benzin_type_id').val(),
                            bakiye_id:  bakiye_id
                        }
                        $.post(baseurl + 'benzin/update_bakiye_benzin_type',data,(response) => {
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
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status== 410){

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
            }
        });

    })
    $(document).on('click','.balance_update',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yanacaq Elave Et',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="name">Litre</label>
                          <input type="number" class="form-control" id="amounth" value="0">
                        </div>
<div class="form-group col-md-12">
                          <label for="name">Yanacaq Tipi</label>
                           <select class="form-control select-box" id="benzin_type_id">
                            <?php foreach (benzin_type_list() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>

                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Açıklama</label>
                          <input type="text" class="form-control" id="desc">
                        </div>
                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Elave Et',
                    btnClass: 'btn-blue',
                    action: function () {
                        let amounth = $('#amounth').val();
                        if(amounth==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Lite Zorunludur',
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
                            crsf_token: crsf_hash,
                            amounth:  $('#amounth').val(),
                            benzin_type_id:  $('#benzin_type_id').val(),
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'benzin/create_save',data,(response) => {
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
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status== 410){

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
            }
        });
    })
    $(document).on('click','.kart_to_bakiye',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Çene Yanacaq Aktar',
            icon: 'fa fa-car',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                       <div class="form-row">
<div class="form-group col-md-12">
                          <label for="name">Çen Kodu</label>
                         <select class="form-control select-box" id="cen_id">
                              <option value='0'>Seçiniz</option>
                            <?php foreach (benzin_cen_list() as $emp){
            $emp_id=$emp->id;
            $name=$emp->code;
            $benzin_type_id=$emp->benzin_type_id;
            $benzin_type = benzin_type_who($benzin_type_id)->name;
            ?>
                                <option benzin_type_id='<?php echo $benzin_type_id; ?>' value="<?php echo $emp_id; ?>"><?php echo $name.' | '.$benzin_type; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Litr</label>
                          <input type="number" class="form-control" id="amounth" max='0' value="0" onkeyup="amount_max(this)">
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Açıklama</label>
                          <input type="text" class="form-control" id="desc">
                        </div>


                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let cen_id = $('#cen_id').val();
                        if(cen_id==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Çen Zorunludur',
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


                        let benzin_type_id = $('option:selected', '#cen_id').attr('benzin_type_id');
                        let data = {
                            crsf_token: crsf_hash,
                            cen_id:  $('#cen_id').val(),
                            amounth:  $('#amounth').val(),
                            desc:  $('#desc').val(),
                            benzin_type_id:  benzin_type_id,
                        }
                        $.post(baseurl + 'benzin/update_balanca_cen',data,(response) => {
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
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status== 410){

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
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

            }
        });
    })
    $(document).on('click','.new_kart',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni Çen',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-row">
                      <div class="form-group col-md-12">
                          <label for="name">Proje Kodu</label>
                           <select class="form-control select-box" id="proje_id">
                             <?php foreach (all_projects() as $project){ ?>
                <option value="<?php  echo $project->id ?>"><?php  echo $project->code ?></option>
            <?php } ?>
                        </select>

                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Yanacaq Tipi</label>
                           <select class="form-control select-box" id="benzin_type_id">
                            <?php foreach (benzin_type_list() as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>

                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Açıklama</label>
                          <input type="text" class="form-control" id="desc">
                        </div>
                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let card_number = $('#card_number').val();
                        if(card_number==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Kart Numarası Zorunludur',
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
                            crsf_token: crsf_hash,
                            proje_id:  $('#proje_id').val(),
                            benzin_type_id:  $('#benzin_type_id').val(),
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'benzin/create_save_cen',data,(response) => {
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
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status== 410){

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
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
            }
        });
    })


    $(document).on('click','.cart_count',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Çenler',
            icon: 'fas fa-credit-card',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Çen Kodu</th>
                                    <th>Proje Kodu</th>
                                    <th>Yanacaq Növü</th>
                                    <th>Litr</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                         <?php foreach (benzin_cen_list() as $emp){
            $emp_id=$emp->id;
            $name=$emp->code;
            $proje_kodu=proje_code($emp->proje_id);
            $benzin_type_id=$emp->benzin_type_id;
            $b_amounth=benzin_bakiye_cen_amounth($emp_id);
            $durum=true;
            if($b_amounth>0){
                $durum=false;
            }
            ?>
                                 <tr>
                                    <th><?php echo $name ?></th>
                                    <th><?php echo $proje_kodu ?></th>
                                    <th><?php echo benzin_type_who($benzin_type_id)->name ?></th>
                                    <th><?php echo benzin_bakiye_cen($emp_id)['kalan']?></th>
                                    <th><button type='button' durum='<?php echo $durum ?>' cen_id='<?php echo $emp_id?>' class='btn btn-danger delete_cen'><i class='fa fa-ban'></i></button></th>
                                <tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </form>`,
            buttons: {
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
            }
        });
    })

    $(document).on('change','#cen_id',function (){

        let id = $('option:selected', '#cen_id').attr('benzin_type_id');
        let data = {
            crsf_token: crsf_hash,
            benzin_type_id:  id
        }
        $.post(baseurl + 'benzin/benzin_type_quantity',data,(response) => {
            let responses = jQuery.parseJSON(response);

            if(responses.status==200){

                $('#amounth').attr('max',responses.kalan);
            }
            else if(responses.status== 410){

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
    })
    $(document).on('change','#cen_id_new',function (){

        let id = $(this).val();
        let data = {
            crsf_token: crsf_hash,
            cen_id:  id
        }
        $.post(baseurl + 'benzin/benzin_bakiye_cen',data,(response) => {
            let responses = jQuery.parseJSON(response);

            if(responses.status==200){

                $('#amounth').attr('max',parseFloat(responses.kalan_num));
            }
            else if(responses.status== 410){

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
    })
    $(document).on('click','.car_to_kart',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Maşına Yanacaq Elave Et',
            icon: 'fa fa-car',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="name">Tanımlanan Maşın</label>
                           <select class="form-control select-box" id="car_id">
                            <?php foreach (all_arac() as $emp){
            $emp_id=$emp->id;
            $name=$emp->code.' - '.$emp->plaka;
            ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Çen</label>
                           <select class="form-control select-box" id="cen_id_new">
                           <option value='0'>Seçiniz</option>
                            <?php foreach (benzin_cen_list() as $emp){
            $emp_id=$emp->id;
            $name=$emp->code;
            $benzin_type_id=$emp->benzin_type_id;
            $benzin_type = benzin_type_who($benzin_type_id)->name;
            ?>
                                <option benzin_type_id='<?php echo $benzin_type_id; ?>' value="<?php echo $emp_id; ?>"><?php echo $name.' | '.$benzin_type; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                           <div class="form-group col-md-12">
                          <label for="name">Litre</label>
                          <input type="number" class="form-control" id="amounth" onkeyup="amount_max(this)" value="0">
                        </div>

                         <div class="form-group col-md-12">
                          <label for="name">Açıklama</label>
                          <input type="text" class="form-control" id="desc">
                        </div>
                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {

                        let cen_id = $('#cen_id_new').val();
                        if(cen_id==0){
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Çen Zorunludur',
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
                            crsf_token: crsf_hash,
                            cen_id:  $('#cen_id_new').val(),
                            car_id:  $('#car_id').val(),
                            amounth:  $('#amounth').val(),
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'benzin/update_car_cen',data,(response) => {
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
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status== 410){

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
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
            }
        });
    })


    function amount_max(obj){

        let max = $(obj).attr('max');
        if(parseFloat($(obj).val())>parseFloat(max)){
            $(obj).val(parseFloat(max))
            return false;
        }
    }

    $(document).ready(function () {
        draw_data();
        draw_data_kart();
        draw_data_arac();
    });
    function draw_data() {
        $('#bakiye_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('benzin/ajax_list_bakiye')?>",
                'type': 'POST',
                'data': {'tip':'bakiye'}
            },
            dom: 'Blfrtip',


        });
    }

    function draw_data_kart() {
        $('#kart_bakiye_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('benzin/ajax_list_kart_bakiye')?>",
                'type': 'POST',
                'data': {'tip':'kart_bakiye'}
            },
            dom: 'Blfrtip',
        });
    }

    function draw_data_arac() {
        $('#arac_hareketleri').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('benzin/ajax_list_kart_arac')?>",
                'type': 'POST',
                'data': {'tip':'kart_bakiye'}
            },
            dom: 'Blfrtip',
        });
    }
    $(document).on('click','.delete_cen',function (){
        let durum =$(this).attr('durum');
        let cen_id =$(this).attr('cen_id');
        if(durum){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Çen Pasifleştir',
                icon: 'fa fa-ban',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'Pasif Etmek İstediğinizden Emin Misiniz?.Geri Alamazsınız.',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                cen_id:  cen_id

                            }
                            $.post(baseurl + 'benzin/delete_cen',data,(response) => {
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
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status== 410){

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
                }
            });
        }
        else {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Bu Çende Yanacaq Mevcut.Silme Yapılamaz!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })


    $(document).on('click','.cari_borclandir',function (){
        let durum =$(this).attr('tip');
        let benzin_cari_durumu_id =$(this).attr('benzin_cari_durumu_id');
        if(durum){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Cari Borçalandır',
                icon: 'fas fa-money-bill',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,

                content: function () {
                    let self = this;
                    let html = `<form>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="name">Proje Seçiniz</label>
                          <select class="form-control select-box" id="proje_id">
                                <?php foreach (all_projects() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->code;
                                ?>
                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                        <?php } ?>
                    </select>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Verilen Yanacaq Litresi</label>
                           <input disabled class='form-control' id='yanacaq_litre'>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Firma Adı</label>
                            <input disabled class='form-control' id="firma_name">
                            <input type="hidden" class='form-control' id="firma_id">
                        </div>
                           <div class="form-group col-md-12">
                          <label for="name">Borçlandırılacak Tutar</label>
                          <input type="number" class="form-control" id="amounth" value="0">
                        </div>
                         <div class="form-group col-md-12">
                          <label for="name">Açıklama</label>
                          <input type="text" class="form-control" id="desc">
                        </div>
                    </div>
                </form>`;
                    let data = {
                        benzin_cari_durumu_id: benzin_cari_durumu_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'benzin/get_info_benzin_cari',data,(response) => {


                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);

                        $('#yanacaq_litre').val(responses.details.benzin_litre);
                        $('#firma_name').val(responses.details.company);
                        $('#firma_id').val(responses.details.firma_id);


                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    formSubmit: {
                        text: 'Borçlandır',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                benzin_cari_durumu_id:  benzin_cari_durumu_id,
                                proje_id:  $('#proje_id').val(),
                                yanacaq_litre:  $('#yanacaq_litre').val(),
                                firma_name:  $('#firma_name').val(),
                                firma_id:  $('#firma_id').val(),
                                amounth:  $('#amounth').val(),
                                desc:  $('#desc').val(),

                            }
                            $.post(baseurl + 'benzin/cari_borclandir',data,(response) => {
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
                                                    $('#arac_hareketleri').DataTable().destroy();
                                                    draw_data_arac();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status== 410){

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
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })

                }
            });
        }
        else {

            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Cari Borçalandırma Bilgileri',
                icon: 'fa fa-eye',
                type: 'yellow',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'Pasif Etmek İstediğinizden Emin Misiniz?.Geri Alamazsınız.',
                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                cen_id:  cen_id

                            }
                            $.post(baseurl + 'benzin/delete_cen',data,(response) => {
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
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status== 410){

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
                }
            });
        }
    })
</script>