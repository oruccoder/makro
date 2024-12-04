<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-8 col-md-8">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    let nakliye=0;
    let kdv=0;
    let cari_id="<?php echo $cari_id ;?>";
    let form_id=<?php echo $form_id ;?>;
    let tftcd_id=<?php echo $tftcd_id ;?>;
    let status=<?php echo $status ;?>;
    $(document).ready(function (){

        if(status){
            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Dikkat',
                icon: 'fa fa-money-bill',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Təklif Qiymətlərinizə ƏDV daxildir, yoxsa yox?<p/>'+
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Bəli',
                        btnClass: 'btn-blue',
                        action: function () {
                            kdv=1;
                            $.confirm({
                                theme: 'modern',
                                closeIcon: false,
                                title: 'Dikkat',
                                icon: 'fa fa-truck',
                                type: 'green',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:'<form action="" class="formName">' +
                                    '<div class="form-group">' +
                                    '<p>Təklif Qiymətlərinizə Çatdırılma daxildir, yoxsa yox?<p/>'+
                                    '</form>',
                                buttons: {
                                    formSubmit: {
                                        text: 'Bəli',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            nakliye=1;
                                            list_teklif();

                                        }
                                    },
                                    cancel:{
                                        text: 'Yox',
                                        btnClass: "btn btn-danger btn-sm",
                                        action: function () {
                                            nakliye=0;
                                            list_teklif();
                                        }
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
                    },
                    cancel:{
                        text: 'Yox',
                        btnClass: "btn btn-danger btn-sm",
                        action: function () {
                            kdv=0;
                            $.confirm({
                                theme: 'modern',
                                closeIcon: false,
                                title: 'Dikkat',
                                icon: 'fa fa-truck',
                                type: 'green',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:'<form action="" class="formName">' +
                                    '<div class="form-group">' +
                                    '<p>Təklif Qiymətlərinizə Çatdırılma daxildir, yoxsa yox?<p/>'+
                                    '</form>',
                                buttons: {
                                    formSubmit: {
                                        text: 'Bəli',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            nakliye=1;
                                            list_teklif();
                                        }
                                    },
                                    cancel:{
                                        text: 'Yox',
                                        btnClass: "btn btn-danger btn-sm",
                                        action: function () {
                                            nakliye=0;
                                            list_teklif();
                                        }
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
            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'Daha Önceden Teklif Verilmiştir!',
                buttons: {
                        cancel:{
                            text: 'Tamam',
                            btnClass: "btn btn-danger btn-sm"
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

    })

    function list_teklif(){
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Taleb Qiymetlendirme',
            icon: false,
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto col-md-12",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<div class="content-body">
            <div class="card">
                <div class="card-content">
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-12">
                               <div class="col col-xs-12 col-sm-12 col-md-12">
                                    <fieldset>
                                        <div class="row">
                                           <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                                                <p class="font_11"> <?php echo 'Talep Eden : ' . personel_details(21) . '</p>';?>
                                                <p class="font_11"> <?php echo 'Talep Eden Tel : <a href="tel:0' . personel_details_full(21)['phone'] . '">İletişime Geç</a></p>';?>
                                                <p class="font_11"> <?php echo 'Talep No : '.$code.'</p>'; ?>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" >
                    <div style="overflow: auto;width: 297px;text-align: initial;">
                        <div class="row">
                            <div>
                                    <table class="table table_carilist" style='width:500px'>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th >Malzeme</th>
                                                <th width='30%'>Marka</th>
                                                <th>Talep Miktarı</th>
                                                <th>Vahid Qiyməti</th>
                                                <th width='30%'>Not</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($items_ as $items){
                                            $product_name = product_detail($items->product_id)['product_detail']['product_name'];
                                            $unit = units_($items->unit_id)['name'];
                                            echo "<tr>";
                                            echo "<td>$i</td>";
                                            echo "<td>$product_name</td>";
                                            echo "<td><input type='text' class='form-control new-input marka'></td>";
                                            echo "<td>$items->product_qty $unit</td>";
                                            echo "<td><input type='number' class='form-control new-input price' value='0'><input type='hidden' class='item_id' value='$items->id'></td>";
                                            echo "<td><input type='text' class='form-control new-input notes'></td>";
                                            echo "</tr>";

                                            $i++; } ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>`,
            buttons: {
                formSubmit: {
                    text: 'Kaydet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let product_details=[];
                        let count = $('.item_id').length;
                        for (let i = 0;i < count; i++){
                            product_details.push({
                                'item_id':$('.item_id').eq(i).val(),
                                'marka':$('.marka').eq(i).val(),
                                'price':$('.price').eq(i).val(),
                                'notes':$('.notes').eq(i).val(),
                            })
                        }

                        let data_update = {
                            talep_id:form_id,
                            tftcd_id:tftcd_id,
                            crsf_token: crsf_hash,
                            cari_id: cari_id,
                            product_details: product_details,
                            nakliye: nakliye,
                            kdv: kdv,
                        }
                        $.post(baseurl + 'billing/teklif_olustur',data_update,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Teklifiniz Oluşturuldu!',
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
</script>

<style>

    .table{
        font-size: 12px !important;
    }
    .jconfirm .jconfirm-box div.jconfirm-title-c .jconfirm-title{
        font-size: 12px;
    }
    h4{
        font-size: 11px;
    }
    .font_11{
        font-size: 11px;
        margin: 1px !important;
    }
    .new-input{

        height: 10px !important;
        font-size: 9px;
        width: 100px;

    }
</style>
