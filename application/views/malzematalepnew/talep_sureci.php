<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Malzeme Talebi - Talep Süreci</span></h4>
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
                    $data_status['status_head']=1;
                    $this->load->view('malzematalepnew/header',$data_status)
                    ?>
                </div>
                <div class="col-md-12 no-padding" style="padding-top: 15px;">
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
<!--                                    <td><span class="mobile_text">--><?php //echo talep_form_product_options_new($talep_products->product_stock_code_id).' '.parent_info($talep_products->product_stock_code_id) ?><!--</span></td>-->
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
                                        <button type="button" class="btn btn-danger form_ban_products mobile_button" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Talep Listesinden Kaldırmak İçin Tıklayınız" eq="<?php echo $eq?>" type_="1" durum="1" item_id="<?php echo $talep_products->id?>"><i class="fa fa-ban"></i></button></td>



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
                    <?php if(iptal_products($details->id)){
                        ?>
                            <hr>
                            <header>
                                <h4>İptal Edilen Ürünler</h4>
                            </header>
                        <table class="table table-bordered" style="color: #8b8b8b;">
                            <thead>
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
                                <td class="mobile_text">Durum</td>
                                <td class="mobile_text">İptal Eden Personel</td>
                            </tr>
                            </thead>
                            <?php
                            foreach (iptal_products($details->id) as $talep_products_iptal){

                                $bolum_name= bolum_getir($talep_products_iptal->bolum_id);
                                $asama_name=task_to_asama($talep_products_iptal->asama_id);

                                $product_code='';
                                $product_details = product_details_($talep_products_iptal->product_id);
                                if($details->talep_type==1){
                                    $product_code = $product_details->product_code;
                                }
                                $image=product_full_details($talep_products_iptal->product_id)['image']
                                ?>
                                <tr>
                                    <td class="mobile_text"><?php echo $i; ?></td>
                                    <td width="100px"><img src="<?php echo site_url().$image ?>" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>
                                    <td><span class="mobile_text"><?php echo $product_details->product_name.' <br><span class="text-muted">'.$product_code.'</span>'; ?><span class="mobile_text"></td>
                                    <!--                                    <td><span class="mobile_text">--><?php //echo talep_form_product_options_new($talep_products->product_stock_code_id).' '.parent_info($talep_products->product_stock_code_id) ?><!--</span></td>-->
                                    <td><span class="mobile_text"><?php echo talep_form_product_options_new($talep_products_iptal->product_stock_code_id)?></span></td>

                                    <td class="mobile_text"><?php echo category_details($product_details->pcat)->title ?></td>
                                    <td class="mobile_text"><?php echo $talep_products_iptal->product_kullanim_yeri ?></td>
                                    <td class="mobile_text"><span><p style="text-decoration: underline;"><?php echo $bolum_name;?></p></span></td>
                                    <td class="mobile_text"><span><p style="text-decoration: underline;"><?php echo $asama_name;?></p></span></td>
                                    <td class="mobile_text"><span><?php echo $talep_products->product_qty ?></span></td>
                                    <td class="mobile_text"><?php echo units_($talep_products_iptal->unit_id)['name'] ?></td>
                                    <td class="mobile_text"><?php echo dateformat_new($talep_products_iptal->product_temin_date) ?></td>
                                    <td class="mobile_text"><?php echo progress_status_details($talep_products_iptal->progress_status_id)->name;?></td>
                                    <td class="mobile_text"><?php echo personel_details($talep_products_iptal->iptal_eden_pers_id);?></td>



                                </tr>
                                <?php
                                $i++;
                                $eq++;
                            }
                            ?>
                        </table>
                        <?php
                    } ?>
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
    <div class="content">
        <div class="card" style="box-shadow: none">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-12 col-xs-12">
                        <header> <h4>Təsdiqləmə SIRASI</h4></header>
                        <table class="table table-bordered" style="width: 100%">

                            <thead>
                            <tr>
                                <td>Tip</td>
                                <td>Personel</td>
                                <td>Durum</td>
                                <td>İşlem</td>
                            </tr>
                            </thead>
                            <?php
                            $button_dikkat='';
                            if($note_list){
                                $button_dikkat="<i class='fas fa-exclamation-triangle button_view_notes' onmouseover='details_notes()' style='
                                                                padding: 0px;
                                                                margin-left: 11px;
                                                                color: red;
                                                                font-size: 34px;
                                                                position: relative;
                                                                top: 7px;
                                                                animation-name: flash;
                                                                -webkit-animation-duration: 2s;
                                                                -webkit-animation-timing-function: linear;
                                                                -webkit-animation-iteration-count: infinite;
'></i>";
                            }

                            if(talep_onay_new(1,$details->id)){
                                foreach (talep_onay_new(1,$details->id) as $items) {
                                    $durum='-';
                                    $button='<button class="btn btn-warning mobile_button mobile_text"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
                                    if($items->status==1){
                                        $durum='Onaylandı';
                                        $button='<button class="btn btn-success mobile_button mobile_text"><i class="fa fa-check"></i>&nbsp;Təsdiqlendi</button>';
                                    }
                                    if($items->staff==1 && $items->status==0){
                                        $durum='Gözləmedə';
                                        $button='<button class="btn btn-info mobile_button mobile_text onayla" aauth_id="'.$this->aauth->get_user()->id.'" user_id="'.$items->user_id.'"><i class="fa fa-check"></i>&nbsp;Təsdiq Edin</button>'.$button_dikkat;
                                    }
                                    ?>

                                    <tbody>
                                    <tr>
                                        <!--?php echo roles(role_id($items->user_id))?-->
                                        <th class="mobile_text">(Talep Süreci Onayı)</th>
                                        <th class="mobile_text"><?php echo personel_details($items->user_id)?></th>
                                        <th class="mobile_text"><?php echo $durum;?></th>
                                        <th class="mobile_text"><?php echo $button;?></th>
                                    </tr>
                                    </tbody>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
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

    $(document).on('click','.onayla',function (){
        let talep_id = $('#talep_id').val();
        let aauth_id  = $(this).attr('aauth_id');
        let user_id  = $(this).attr('user_id');
        if(aauth_id!=user_id){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Yetkiniz Bulunmamaktadır',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
        else {
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<form action="" class="formName">
                <div class="form-group">
                <p>Onaylamak Üzeresiniz Emin Misiniz?<p/>
                <div class="form-group">
                            <select class="form-control select-box" id="satinalma_personeli">
                               <option value="0">Satınalma Personeli Seçiniz</option>
                                <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                $selected='';
                if($talep_user_satinalma){
                    if($talep_user_satinalma->user_id==$emp_id){
                        $selected='selected';
                    }
                }
                ?>
                                    <option <?php echo $selected;?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                            </select>
                            </div>
                             <div class="form-group">
                              <label for="firma_id">Təcili</label>
                                <select class="form-control select-box" id="progress_status_id">

                                    <?php foreach (progress_status() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                $selected='';
                if($details->progress_status_id==$emp_id){
                    $selected='selected';
                }
                ?>
                                        <option <?php echo $selected; ?> value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

    </div>
                </form>`,

                buttons: {
                    formSubmit: {
                        text: 'Evet',
                        btnClass: 'btn-blue',
                        action: function () {
                            let product_details=[];
                            let name = $('#satinalma_personeli').val()
                            if(!parseInt(name)){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Satınalama Personeli Seçmelisiniz',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }
                            let count = $('.item_qty').length;
                            for (let i=0; i<count; i++) {
                                product_details.push({
                                    'item_id':$('.item_qty').eq(i).attr('item_id'),
                                    'item_qty':$('.item_qty').eq(i).val(),
                                });
                            }
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                talep_id:talep_id,
                                progress_status_id:$('#progress_status_id').val(),
                                product_details:product_details,
                                type:1,
                                crsf_token: crsf_hash,
                                satinalma_personeli: $('#satinalma_personeli').val(),
                            }
                            $.post(baseurl + 'malzemetalepnew/onay_olustur',data,(response)=>{
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





</script>
