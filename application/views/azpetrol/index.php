<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Azpetrol Kontrol Paneli</span></h4>
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
                                <div class="col-xl-4 col-sm-4 col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="text-black" href="#">
                                                <div class="d-flex justify-content-between px-md-1">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-money-bill text-info fa-5x"></i>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-0">Tüm Bakiye</p>
                                                        <h4 class="pt-1 mt-2 mb-0" id="all_balance"><?php echo azpetrol_bakiye()?></h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-4 col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="text-black cart_count" href="#">
                                                <div class="d-flex justify-content-between px-md-1">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-credit-card text-success fa-5x"></i>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-0">Az Petrol Kart Sayısı</p>
                                                        <h4 class="pt-1 mt-2 mb-0" id="cart_count"><?php echo azpetrol_cart_count();?></h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-4 col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="text-black arac_count" href="#">
                                                <div class="d-flex justify-content-between px-md-1">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-car text-danger fa-5x"></i>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="mb-0">Tanımlı Araç Sayısı</p>
                                                        <h4 class="pt-1 mt-2 mb-0" id="all_cars"><?php echo azpetrol_tanimli_arac();?></h4>
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
                        <button class="btn btn-success balance_update" type="button"><i class="fa fa-plus"></i> Bakiye Ekle</button>
                        <button class="btn btn-info new_kart" type="button"><i class="fas fa-credit-card"></i> Kart Tanımla</button>
                        <button class="btn btn-purple car_to_kart" type="button"><i class="fas fa-car"></i> Araca Kart Tanımla</button>
                        <button class="btn btn-warning kart_to_bakiye" type="button"><i class="fas fa-credit-card"></i> Kart Bakiye İşlemleri</button>

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
                                                        <a class="nav-item nav-link active" id="nav-bakiye-hareketleri" data-toggle="tab" href="#b_hareketleri" role="tab" aria-controls="nav-bakiye-hareketleri" aria-selected="true">BAKIYE HAREKETLERI</a>
                                                        <a class="nav-item nav-link" id="nav-kart-bakiye-hareketleri" data-toggle="tab" href="#k_hareketleri" role="tab" aria-controls="nav-kart-bakiye-hareketleri" aria-selected="false">KART BAKIYE HAREKETLERI</a>
                                                        <a class="nav-item nav-link" id="nav-arac-kart-hareketleri" data-toggle="tab" href="#a_hareketleri" role="tab" aria-controls="nav-arac-kart-hareketleri" aria-selected="false">ARAÇ KART HAREKETLERI</a>
                                                    </div>
                                                </nav>
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="b_hareketleri" role="tabpanel" aria-labelledby="nav-home-tab">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table" id="bakiye_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Tarih</th>
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
                                                    <div class="tab-pane fade show" id="k_hareketleri" role="tabpanel" aria-labelledby="nav-home-tab">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table class="table" id="kart_bakiye_table" width="100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Tarih</th>
                                                                        <th>Kart No</th>
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
                                                                        <th>Araç Plaka No</th>
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
                'url': "<?php echo site_url('azpetrol/ajax_list_bakiye')?>",
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
                'url': "<?php echo site_url('azpetrol/ajax_list_kart_bakiye')?>",
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
                'url': "<?php echo site_url('azpetrol/ajax_list_kart_arac')?>",
                'type': 'POST',
                'data': {'tip':'kart_bakiye'}
            },
            dom: 'Blfrtip',
        });
    }

    $(document).on('click','.balance_update',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bakiye Ekle',
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
                          <label for="name">Tutar</label>
                          <input type="number" class="form-control" id="amounth" value="0">
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
                                content: 'Tutar Zorunludur',
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
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'azpetrol/create_save',data,(response) => {
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
    $(document).on('click','.new_kart',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni Kart',
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
                          <label for="name">Kart Numarası</label>
                          <input type="number" class="form-control" id="card_number" value="0">
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Tanımlanan Araç</label>
                           <select class="form-control select-box" id="car_id">
                            <option value="0">Tanımsız</option>
                            <?php foreach (mk_arac_list() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->code.' - '.$emp->plaka;
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
                            card_number:  $('#card_number').val(),
                            car_id:  $('#car_id').val(),
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'azpetrol/create_save_cart',data,(response) => {
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
    $(document).on('click','.car_to_kart',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Araca Kart Tanımla',
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
                          <label for="name">Kart Numarası</label>
                         <select class="form-control select-box" id="cart_id">
                            <?php foreach (cart_list() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->cart_number
                                ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Tanımlanan Araç</label>
                           <select class="form-control select-box" id="car_id">
                            <?php foreach (azpetrol_tanimsiz_arac() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->code.' - '.$emp->plaka;
                                ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            cart_id:  $('#cart_id').val(),
                            car_id:  $('#car_id').val(),
                        }
                        $.post(baseurl + 'azpetrol/update_car_cart',data,(response) => {
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
    $(document).on('click','.kart_to_bakiye',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Karta Bakiye Aktar',
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
                          <label for="name">Tip</label>
                         <select class="form-control" id="tip">
                          <option value='0'>Bakiye Azaltma</option>
                          <option value='1'>Bakiye Artırma</option>
                        </select>
                        </div>
                    </div>
                       <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="name">Tutar</label>
                          <input type="number" class="form-control" id="amounth" value="0">
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Açıklama</label>
                          <input type="text" class="form-control" id="desc">
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Kart Numarası</label>
                         <select class="form-control select-box" id="cart_id">
                            <?php foreach (azpetrol_cart_list() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->cart_number
                                ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                        </div>

                    </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            cart_id:  $('#cart_id').val(),
                            tip:  $('#tip').val(),
                            amounth:  $('#amounth').val(),
                            desc:  $('#desc').val(),
                        }
                        $.post(baseurl + 'azpetrol/update_balanca_cart',data,(response) => {
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
            title: 'Kartlar',
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
                                    <th>Kart Numarası</th>
                                    <th>Bakiye</th>
                                </tr>
                            </thead>
                            <tbody>
                         <?php foreach (azpetrol_cart_list() as $emp){
                                    $emp_id=$emp->id;
                                    $name=$emp->cart_number
                                    ?>
                                 <tr>
                                    <th><?php echo $name ?></th>
                                    <th><?php echo azpetrol_bakiye_cart($emp_id)?></th>
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

    $(document).on('click','.arac_count',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Araçlar',
            icon: 'fas fa-car',
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
                                    <th>Araç</th>
                                    <th>Kart Numarası</th>
                                    <th>Bakiye</th>
                                </tr>
                            </thead>
                            <tbody>
                         <?php foreach (azpetrol_tanimli_arac_result() as $emp){
            $emp_id=$emp->id;
            $name=$emp->cart_number
            ?>
                                 <tr>
                                    <th><?php echo $emp->plaka ?></th>
                                    <th><?php echo $name ?></th>
                                    <th><?php echo azpetrol_bakiye_cart($emp_id)?></th>
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
</script>