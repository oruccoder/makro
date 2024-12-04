<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Malzeme Talebi - Mahsul Ekleme Süreci</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<input type="hidden" id="talep_type" value="<?php echo $details->talep_type?>">

<div class="content">
<?php $this->load->view("malzematalepnew/header_ust") ?>
    <div class="card" style="box-shadow: none;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 no-padding">
                   <?php
                   $data_status['status_head']=21;
                   $this->load->view('malzematalepnew/header',$data_status)
                   ?>
                </div>
                <div class="col-md-12 no-padding" style="padding-top: 15px;">
                    <header style="text-align: center;">
                        <?php      if($details->status==21){ ?>
                        <h4 class="mobile_text_header">Tələb materialları</h4>


                        <button  type="button" talep_type="<?php echo $details->talep_type?>"
                         demirbas_id="<?php echo $details->demirbas_id?>" firma_demirbas_id="<?php echo $details->firma_demirbas_id ?>"
                         class="btn btn-secondary add_product mobile_button" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover"
                         data-placement="top" style="margin-bottom: 10px;" data-content="Tələb etmək üçün material təyin edin"><i class="fa fa-plus"></i> </button>

                        <?php } ?>
                    </header>
                    <hr>
                    <?php
                    if ($items)
                    {
                        echo $kategori_html;
                    }
                    ?>
                    <table class="table table-bordered" id="project_table" width="100%">
                        <thead class="border">
                        <tr>
                            <td class="mobile_text" style="width: 10px !important;">No</td>
                            <td class="mobile_text">Resim</td>
                            <td class="mobile_text">Tanım</td>
                            <td class="mobile_text">Varyant</td>
                            <td class="mobile_text">Ürün Kategorisi</td>
                            <td class="mobile_text">Kullanım Yeri</td>
                            <td class="mobile_text">Bölüm</td>
                            <td class="mobile_text">Aşama</td>
                            <td class="mobile_text">Miktar</td>
                            <td class="mobile_text">Birim</td>
                            <td class="mobile_text">Temin Tarihi</td>
                            <td class="mobile_text">Aciliyet Durumu</td>
                            <td class="mobile_text">Durum</td>
                            <td class="mobile_text">İşlem</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($items) { $i=1;
                            $eq=0;
                            foreach ($items as $talep_products){
                                $bolum_name= bolum_getir($talep_products->bolum_id);
                                $asama_name=task_to_asama($talep_products->asama_id);

                                $product_code='';
                                $product_details = product_details_($talep_products->product_id);
                                if($details->talep_type==1){
                                    $product_code = $product_details->product_code;
                                }
                                $image=product_full_details($talep_products->product_id)['image']
                                ?>
                                <tr>
                                    <td class="mobile_text"><?php echo $i; ?></td>
                                    <td width="100px"><img src="<?php echo site_url().$image ?>" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>
                                    <td><span class="mobile_text"><?php echo $talep_products->product_name.' <br><span class="text-muted">'.$product_code.'</span>'; ?><span class="mobile_text"></td>
                                    <td><span class="mobile_text"><?php echo talep_form_product_options_new($talep_products->product_stock_code_id)?></span></td>
                                    <td class="mobile_text"><?php echo category_details($product_details->pcat)->title ?></td>
                                    <td class="mobile_text"><?php echo $talep_products->product_kullanim_yeri ?></td>
                                    <td class="mobile_text"><span class="table_line_update" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Düzenlemek İçin tıklayınız" tip="table_bolum_update" stok_id="<?php echo $talep_products->id?>"><p style="text-decoration: underline;"><?php echo $bolum_name;?></p></span></td>
                                    <td class="mobile_text"><span class="table_line_update" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Düzenlemek İçin tıklayınız" tip="table_asama_update" stok_id="<?php echo $talep_products->id?>"><p style="text-decoration: underline;"><?php echo $asama_name;?></p></span></td>
                                    <td class="mobile_text"><span class="table_line_update" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Düzenlemek İçin tıklayınız" tip="table_qty_update" stok_id="<?php echo $talep_products->id?>"  class="form-control item_qty"><?php echo $talep_products->product_qty ?></span></td>
                                    <td class="mobile_text"><?php echo $talep_products->unit_name ?></td>
                                    <td class="mobile_text"><?php echo dateformat_new($talep_products->product_temin_date) ?></td>
                                    <td class="mobile_text"><?php echo progress_status_details($talep_products->progress_status_id)->name;?></td>
                                    <td class="mobile_text"><span class="badge badge-warning"><?php echo isset(talep_form_status_details($talep_products->status)->name)?talep_form_status_details($talep_products->status)->name:'Talep Ekleme Süreci';?></span></td>
                                    <td>
                                        <button type="button" class="btn btn-danger form_remove_products mobile_button" eq="<?php echo $eq?>" type_="1" durum="1" item_id="<?php echo $talep_products->id?>"><i class="fa fa-trash"></i></button></td>



                                </tr>
                                <?php
                                $i++;
                                $eq++;
                            }
                        }
                        else {

                            if($details->status==21){
                                echo '<tr>
                                        <td colspan="13">
                                        <h2 style="text-align: center">Zəhmət olmasa material əlavə etməyi unutmayın...</h2>
                                        </td>
                                        </tr>';
                            }
                            else {
                                $status_name='Talep '.talep_form_status_details($details->status)->name.' Aşamasındadır';
                                echo '<tr>
                                        <td colspan="13">
                                        <h2 style="text-align: center">'.$status_name.'</h2>
                                        </td>
                                        </tr>';
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php if(!$details->bildirim_durumu)
                {
                    if($details->status==21){
                    ?>
                <div class="col-md-12" style="text-align: center">
                    <button class="btn btn-secondary mobile_button bildirim_olustur" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="Onaya Sunmak İçin Tıklayınız" style="animation-name: flash;  animation-duration: 1s;animation-timing-function: linear;animation-iteration-count: infinite;"><i class="fa fa-bell"></i></button>
                </div>
                <?php } } ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("malzematalepnew/footer") ?>

<script type="text/javascript">
    $(document).on('click','.table_line_update',function (){
        let tip = $(this).attr('tip');
        let stok_id = $(this).attr('stok_id');
        let data = {
            crsf_token: crsf_hash,
            stok_id: stok_id,
            tip: tip,
        }
        $.post(baseurl + 'malzemetalepnew/get_info_update',data,(response) => {
            let responses_data = jQuery.parseJSON(response);
            $('#loading-box').addClass('d-none');
            if(responses_data.status==200){
                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: responses_data.title,
                    icon: 'fa fa-pen',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-6 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: responses_data.content,
                    buttons: {
                        formSubmit: {
                            text: 'Güncelle',
                            btnClass: 'btn-blue',
                            action: function () {
                                let data =$("#update_form").serialize();
                                $('#loading-box').removeClass('d-none');
                                $.post(baseurl + 'malzemetalepnew/lineupdate',data,(response) => {
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
                                                    // action: function () {
                                                    //     $('#project_table').DataTable().destroy();
                                                    //     draw_data();
                                                    // }
                                                }
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
                        },
                    },
                    onContentReady: function () {
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        })


                        $("#line_product_id").select2({
                            minimumInputLength: 1,
                            dropdownParent: $(".jconfirm-box-container"),
                            tags: false,
                            ajax: {
                                url:baseurl + 'search/product_select',
                                dataType: 'json',
                                type: 'POST',
                                quietMillis: 50,
                                data: function (product) {
                                    return {
                                        product: product,
                                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.product_name,
                                                id: item.pid
                                            }
                                        })
                                    };
                                },
                            }
                        });
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
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
    })
    $(document).ready(function () {


        draw_data_history();
        $('#project_table').DataTable().destroy();
        draw_data()


        $('.select-box').select2();

    })
    $('.update_val').keyup(function (event){
        if (event.keyCode == 13 || event.which == 13){
            let new_deger = $(this).val();
            let data = {
                crsf_token: crsf_hash,
                form_id: $('#talep_id').val(),
                new_deger: new_deger,
                column: $(this).attr('tip'),
            }

            $.post(baseurl + 'malzemetalepnew/column_update',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status==200){
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
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    location.reload()
                                }
                            }
                        }
                    });
                }
                else {
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
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            });
        }
    })

    $(document).on('click','.add_product',function (){
        let file_id =$(this).attr('file_id');

        let talep_type =$(this).attr('talep_type');
        let firma_demirbas_id =$(this).attr('firma_demirbas_id');
        let demirbas_id =$(this).attr('demirbas_id');
        if(talep_type==3){
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Gider Kalemi Ekleyin',
                icon: 'fa fa-plus',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-12 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<form action="" class="formName" id='data_form'>

                                        <div class="form-group col-md-12 one_group">
                                          <label for="name">Gider Kalemi Grubu</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id[]">
                                            <?php
                if(demirbas_group_list_who(2,$details->demirbas_id)){
                echo "<option value='0'>Seçiniz</option>";
                foreach (demirbas_group_list_who(2,$details->demirbas_id) as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                }
                else {
                ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                }

                ?>
                                        </select>
                                        </div>
                                         <div class="row">
                                           <div class="col col-xs-12 col-sm-12 col-md-12">

                                                <table class="table table_products">
                                                    <thead>
                                                        <tr>
                                                            <th>Açıklama</th>
                                                            <th>Birim</th>
                                                            <th>Miktar</th>
                                                            <th>İşlem</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>

                                                            <td><input type='text' class='form-control' name='product_desc'></td>
                                                          <td><select class="form-control select-box unit_id" name='unit_id'>
                                                                 <?php foreach (units() as $blm)
                {
                    $id=$blm['id'];
                    $name=$blm['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                                </select>
                                                            </td>
                                                            <td><input type='numaric' class='form-control' name='product_qty'></td>                                                            <td><button type='button' class='btn btn-success form_add_products'><i class='fa fa-plus'></td>

                                                            <input type='hidden' value='<?php echo $details->id?>' name='form_id'>
                                                            <input type='hidden' value='`+firma_demirbas_id+`' name='firma_demirbas_id'>
                                                            <input type='hidden' value='`+demirbas_id+`' name='demirbas_id'>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>


                                        </form>`,
                buttons: {
                    cancel:{
                        text: 'Vazgeç',
                        btnClass: "btn btn-danger btn-sm",
                        action:function(){
                            location.reload();
                        }
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })
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

            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Talebe Malzeme Atama',
                icon: 'fa fa-plus',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-12 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-8 col-md-8">
                        <div class="jarviswidget">
                            <header><h4>Malzeme Listesi Arama Alanı</h4></header>
                            <div class="borderedccc">
                                <div class="widget-body">
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <fieldset>
                                            <div class="row mb-2">
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Kategori Bazlı Ara</label>
                                                    <select class="form-control select-box" id="category_id">
                                                    <option value='0'>Seçiniz</option>
                                                            <?php
                if($details->talep_type==1){
                    foreach (category_list_() as $item) :

                        $id = $item['id'];
                        $title = $item['title'];
                        $new_title = _ust_kategori_kontrol($id).$title;
                        echo "<option value='$id'>$new_title</option>";

                    endforeach;
                }
                elseif($details->talep_type==2){
                    foreach (category_list_() as $item) :

                        $id = $item['id'];
                        $title = $item['title'];
                        $new_title = _ust_kategori_kontrol($id).$title;
                        echo "<option value='$id'>$new_title</option>";

                    endforeach;
                }
                elseif($details->talep_type==3){
                    foreach (demirbas_group_list() as $row) {
                        $cid = $row->id;
                        $title = $row->name;
                        echo "<option value='$cid'>$title</option>";
                    }
                }

                ?>
                                                    </select>
                                                </section>
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Malzeme Adı</label>
                                                    <input type="texy" placeholder="Min 3 karakter veya Kategori Seçini" class="form-control" id="search_name">
                                                </section>
                                            </div>
                                            <div class="row mb-2">
                                                <section class="col col-sm-12 col-md-12">
                                                    <button class="btn btn-info" id="search_button"><i class="fa fa-search"></i>&nbsp;Ara</button>
                                                </section>

                                            </div>

                                            <?php   if($details->talep_type==1){  ?>
                                              <div class="row mb-2">
                                                    <section class="col col-sm-12 col-md-12">
                                                    <button class="btn btn-success" id="talep_list_get"><i class="fa fa-list"></i>&nbsp;Talep Listemi Getir</button>
                                                </section>
                                            </div>
                                            <?php } ?>

                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col col-xs-12 col-sm-4 col-md-4">
                        <div class="jarviswidget">
                            <header><h4>Atanan Malzemeler (<?php echo proje_code($details->proje_id)?>)</h4></header>
                            <table class="table table_create_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Malzeme</th>
                                        <th>Miktar</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <div class="jarviswidget">
                            <header><h4>Malzemeler</h4></header>
                            <table class="table table_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Resim</th>
                                        <th>Malzeme</th>
                                        <th>Varyant</th>
                                        <th>Tanım</th>
                                        <th>Kullanım Yeri</th>
                                        <th>Bölüm</th>
                                        <th>Aşama</th>
                                        <th>Temin Tarihi  &nbsp;<button class="temin_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Aciliyet Durumu &nbsp;<button class="aciliyet_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Birim &nbsp;<button class="birim_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Miktar</th>
                                        <th>İşlem &nbsp;<button class="add_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
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
    </div>
</div>`,
                buttons: {
                    cancel:{
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                        action:function (){
                            location.reload();
                        }
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })
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

    })
    $(document).on('click','#search_button',function (){
        let keyword = $('#search_name').val();
        let category_id = parseInt($('#category_id').val());

        if(category_id==0){
            if(keyword.length < 3){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'En az 3 Karakter Yazmalısınız veya Bir Kategori Seçmelisiniz',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }
            else {
                $('#loading-box').removeClass('d-none');
                let cat_id = parseInt($('#category_id').val());
                let data = {
                    cat_id:cat_id,
                    keyword:keyword,
                    proje_id:"<?php echo $details->proje_id ?>",
                    bolum_id:"<?php echo $details->bolum_id ?>",
                    asama_id:"<?php echo $details->asama_id ?>",
                    talep_type:"<?php echo $details->talep_type ?>",
                    crsf_token: crsf_hash,
                }
                $.post(baseurl + 'malzemetalepnew/search_products',data,(response)=>{
                    let responses = jQuery.parseJSON(response);
                    if(responses.status=='Success'){
                        $('#loading-box').addClass('d-none');
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Başarılı',
                            content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                            buttons:{
                                formSubmit: {
                                    text: 'Tamam',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let units = '<select class="form-control select-box unit_id">';
                                        responses.units.forEach((item,index) => {
                                            units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                        })
                                        units+='</select>';
                                        let table = '';
                                        responses.products.forEach((item,index) => {
                                            let no = parseInt(index)+parseInt(1);
                                            table+=`<tr>
                                                    <td>`+no+`</td>
                                                    <td width="100px"><img src="<?php echo site_url() ?>`+item.images+`" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>
                                                              <input type="hidden" class="product_stock_code_id" value="`+item.product_stock_code_id+`">
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">
                                                    `+item.product_name+`</td>
                                                  <td>`+item.option_html+`</td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_name+`"></td>
                                                    <td><input type="text" class="product_kullanim_yeri form-control"></td>
                                                    <td width="200px"><select index='`+index+`' class="form-control bolum_id_product select-box">
                                                    <option value='0'>Seçiniz</option>
                                                          <?php foreach ($bolumler as $blm)
                                            {
                                                $id=$blm['id'];
                                                $name=$blm['name'];
                                                echo "<option value='$id'>$name</option>";
                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td width="200px"><select class="form-control asama_id_product select-box"><option value='0'>Seçiniz</option></select></td>
                                                    <td><input type="date"  class="product_temin_date form-control"></td>
                                                    <td><select class="form-control progress_status_id">
                                                    <?php foreach (progress_status() as $emp){
                                            $emp_id=$emp->id;
                                            $name=$emp->name;
                                            ?>
                                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                                </select></td>
                                                    <td><select class="form-control select-box unit_id" p_unit_id='`+item.p_unit_id+`'>
                                                     <?php foreach (units() as $blm)
                                            {
                                                $id=$blm['id'];
                                                $name=$blm['name'];
                                                echo "<option value='$id'>$name</option>";
                                            } ?>
                                                    </select>
                                                    </td>
                                                    <td><input class="product_qty form-control" max='`+item.max_qty+`' onkeyup="amount_max(this)" value="1"></td>
                                                    <td><button proje_stoklari_id="`+item.proje_stoklari_id+`" eq='`+index+`' option_id="`+item.option_id+`" option_value_id="`+item.option_value_id+`" class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                </tr>`;
                                        })
                                        $('.table_products tbody').empty().html(table);

                                        setTimeout(function(){
                                            let  unit_count = $('.unit_id').length;
                                            for(let k = 0; k < unit_count; k++){
                                                let unit_id = $('.unit_id').eq(k).attr('p_unit_id');
                                                $('.unit_id').eq(k).val(unit_id).select2().trigger('change')
                                            }

                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm")
                                            })
                                        }, 1000);



                                    }
                                }
                            }
                        });
                    }
                    else {
                        $('#loading-box').addClass('d-none');
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: 'Kriterlere Uygun Ürün Bulunamadı!',
                            buttons:{
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                    }



                });

            }
        }
        else {
            $('#loading-box').removeClass('d-none');
            let cat_id = parseInt($('#category_id').val())
            let data = {
                cat_id:cat_id,
                proje_id:"<?php echo $details->proje_id ?>",
                bolum_id:"<?php echo $details->bolum_id ?>",
                asama_id:"<?php echo $details->asama_id ?>",
                talep_type:"<?php echo $details->talep_type ?>",
                keyword:keyword,
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'malzemetalepnew/search_products',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let units = '<select class="form-control select-box unit_id">';
                                    responses.units.forEach((item,index) => {
                                        units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                    })
                                    units+='</select>';
                                    let table = '';
                                    responses.products.forEach((item,index) => {
                                        let no = parseInt(index)+parseInt(1);
                                        table+=`<tr>
                                                    <td>`+no+`</td>
                                                   <input type="hidden" class="product_stock_code_id" value="`+item.product_stock_code_id+`">
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
                                                 <td><span class="option_view_btn" stock_code_id="`+item.product_stock_code_id+`">`+item.option_html+`</span></td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_name+`"></td>
                                                    <td><input type="text" class="product_kullanim_yeri form-control"></td>
                                                    <td><input type="date"  class="product_temin_date form-control"></td>
                                                     <td width="200px"><select index='`+index+`' class="form-control bolum_id_product select-box">
                                                    <option value='0'>Seçiniz</option>
                                                          <?php foreach ($bolumler as $blm)
                                        {
                                            $id=$blm['id'];
                                            $name=$blm['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                        </select>
                                                    </td>
                                                    <td width="200px"><select class="form-control asama_id_product select-box"><option value='0'>Seçiniz</option></select></td>

                                                    <td><select class="form-control progress_status_id">
                                                    <?php foreach (progress_status() as $emp){
                                        $emp_id=$emp->id;
                                        $name=$emp->name;
                                        ?>
                                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                                </select></td>
                                                    <td><select class="form-control select-box unit_id" p_unit_id='`+item.p_unit_id+`'>
                                                     <?php foreach (units() as $blm)
                                        {
                                            $id=$blm['id'];
                                            $name=$blm['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                    </select>
                                                    </td>
                                                    <td><input class="product_qty form-control" max='`+item.max_qty+`' onkeyup="amount_max(this)" value="1"></td>
                                                    <td><button proje_stoklari_id="`+item.proje_stoklari_id+`" eq='`+index+`' option_id="`+item.option_id+`" option_value_id="`+item.option_value_id+`" class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                </tr>`;
                                    })
                                    $('.table_products tbody').empty().html(table);

                                    setTimeout(function(){
                                        let  unit_count = $('.unit_id').length;
                                        for(let k = 0; k < unit_count; k++){
                                            let unit_id = $('.unit_id').eq(k).attr('p_unit_id');
                                            $('.unit_id').eq(k).val(unit_id).select2().trigger('change')
                                        }

                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    }, 1000);
                                }
                            }
                        }
                    });
                }
                else {
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Kriterlere Uygun Ürün Bulunamadı!',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }



            });

        }
    })


    $(document).on('change', ".bolum_id_product", function (e) {
        let eq=$(this).attr('index');
        $(".asama_id_product option").eq(eq).remove();
        var bolum_id = $(this).val();
        var proje_id = $('#proje_id_hidden').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projects/asamalar_list',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                let data_r = jQuery.parseJSON(data)
                if(data_r.length)
                {
                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $(".asama_id_product").eq(eq).append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }
                else {
                    $('.asama_id_product').eq(eq).append($('<option>').val(0).text('Aşama BUlunamadı'));
                }

            }
        });

    });

    $(document).on('click','.form_add_products',function (){

        let talep_type = $('#talep_type').val();
        if(talep_type==3){
            $.post(baseurl + 'malzemetalepnew/create_form_items_gider',$('#data_form').serialize(),(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Ürün Eklendi!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    $("input[name='product_desc']").val('');
                                    $("input[name='product_qty']").val('');
                                    $("input[name='product_price']").val('');

                                }
                            }
                        }
                    });
                }
                else {
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Kriterlere Uygun Ürün Bulunamadı!',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }
            });
        }
        else {


            let eq = $(this).attr('eq');


            let bolum_id = $('.bolum_id_product').eq(eq).val()
            let asama_id = $('.asama_id_product').eq(eq).val()
            if(bolum_id==0){
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    title: 'Dikkat!',
                    content: 'Bölüm Zorunludur',
                    buttons: {
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });

                return false;
            }

            if(asama_id==0){
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    title: 'Dikkat!',
                    content: 'Aşama Zorunludur',
                    buttons: {
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });

                return false;
            }


            let proje_stoklari_id = $(this).attr('proje_stoklari_id');
            let option_details=[];

            option_details.push({
                'option_id':$(this).attr('option_id'),
                'option_value_id':$(this).attr('option_value_id'),
            })

            let data = {
                product_id:$('.product_id').eq(eq).val(),
                product_stock_code_id:$('.product_stock_code_id').eq(eq).val(),
                option_details:option_details,
                proje_stoklari_id:proje_stoklari_id,
                product_desc:$('.product_desc').eq(eq).val(),
                bolum_id:$('.bolum_id_product').eq(eq).val(),
                asama_id:$('.asama_id_product').eq(eq).val(),
                product_kullanim_yeri:$('.product_kullanim_yeri').eq(eq).val(),
                product_temin_date:$('.product_temin_date').eq(eq).val(),
                progress_status_id:$('.progress_status_id').eq(eq).val(),
                unit_id:$('.unit_id').eq(eq).val(),
                product_qty:$('.product_qty').eq(eq).val(),
                form_id:$('#talep_id').val(),
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'malzemetalepnew/create_form_items',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let table=`<tr  id="remove`+responses.talep_form_products_id+`" >
                                                    <td><p>`+responses.product_name+`</p><span style="font-size: 12px;">`+responses.option_html+`</span></td>
                                                    <td>`+responses.qyt_birim+`</td>
                                                    <td><button item_id='`+responses.talep_form_products_id+`' type_="2" class="btn btn-danger btn-sm form_remove_products" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                                    $('.table_create_products tbody').append(table);
                                }
                            }
                        }
                    });
                }
                else {
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Kriterlere Uygun Ürün Bulunamadı!',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            });
        }

    })



    function draw_data_history() {
        $('#mt_talep_history').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'ajax': {
                'url': "<?php echo site_url('malzemetalep/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: $('#talep_id').val(),
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

            ]
        });
    }
    function draw_data() {
        $('#project_table').DataTable({
            scrollX:        "300px",
            scrollCollapse: true,
            fixedColumns:   {
                left: 3
            },
            "columnDefs": [
                { "width": "10px", "targets": 0 },
                { "width": "40px", "targets": 1 },
                { "width": "100px", "targets": 2 },
                { "width": "70px", "targets": 3 },
                { "width": "70px", "targets": 4 },
                { "width": "70px", "targets": 5 }
            ],
            paging:         false,
            'ordering': false,

        });
    }

    $(document).on('click','.warehouse_create',function (){

        let tip=$(this).attr('tip'); //1 depo 2 transfer depo
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-warehouse',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName">
                <div class="form-group">
                <input class='form-control' id='warehouse_text' placeholder='Adres Tanımlaması'>
                </div>
                <div class="form-group">
                            <select class="form-control select-box" id="warehouse_id">
                               <option value="0">Seçiniz</option>
                                <?php foreach (all_warehouse() as $emp){
            $emp_id=$emp->id;
            $name=$emp->title;
            ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_update = {
                            talep_id:$('#talep_id').val(),
                            crsf_token: crsf_hash,
                            warehouse_id: $('#warehouse_id').val(),
                            warehouse_text: $('#warehouse_text').val(),
                            tip: tip
                        }
                        $.post(baseurl + 'malzemetalepnew/warehouse_update',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Eklendi',
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Hata Aldınız! Yöneticiye Başvurun',
                                    buttons:{
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
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })
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
