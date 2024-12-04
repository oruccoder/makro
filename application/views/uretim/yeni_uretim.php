<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yeni Üretim</span></h4>
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
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                                        <div class="jarviswidget">
                                                            <div class="card-body">


                                                                <?php


                                                                $product_id = recete_id_in_product($recete_id);

                                                                $product_name = product_name($product_id); ?>
                                                                <h2 class="baslik" style="text-align: center">  <?php echo '<b>'.$product_name.'</b>';?> İçin Üretim Bilgileri</h2><br>


                                                                <form id="uretim_form">
                                                                    <input type="hidden" value="<?php echo $recete_id;?>" id="recete_id_get" name="recete_id_get">

                                                                    <?php if($recete_id){
                                                                        echo "<input type='hidden' value='$product_id' id='new_prd_id' name='new_prd_id'>";
                                                                        echo "<input type='hidden' value='$product_name' id='new_prd_name' name='new_prd_name'>";
                                                                        $product_id = recete_id_in_product($recete_id);
                                                                        $product_name = product_name($product_id);

                                                                    } ?>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Depo</label>
                                                                        <select class="form-control select-box" id="warehouse_id" name="warehouse_id">
                                                                            <option value="0">Seçiniz</option>
                                                                            <?php foreach (all_warehouse() as $items){
                                                                                echo "<option value='".$items->id."'>".$items->title."</option>";
                                                                            } ?>
                                                                        </select>
                                                                        <small id="emailHelp" class="form-text text-muted">Üretimde Kullanılacak Depoyu Seçiniz</small>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Miktar</label>
                                                                        <input type="text" class="form-control" placeholder="Miktar" disabled name="miktar" id="miktar">
                                                                        <small id="emailHelp" class="form-text text-muted">Ürün Miktarını Belirtiniz</small>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputPassword1">Açıklama</label>
                                                                        <input type="text" class="form-control" placeholder="Üretim Açıklaması"
                                                                               name="uretim_aciklamasi" id="uretim_aciklamasi"  >
                                                                    </div>

<!--                                                                    <button type="submit" class="btn btn-primary">Submit</button>-->
                                                                </form>
                                                                <div class="row recete_div">
                                                                    <div class="offset-lg-4 col-lg-4">
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="button" id="post_button" disabled class="btn btn-info btn-lg devam" data-tid="continue-to-ingredients-list">Üretim Fişi Oluştur</button>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
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


<style>
    .col-form-label
    {
        padding-top: 0.4rem !important;
    }
    .mt-4
    {
        margin-top: 1.5rem !important;

    }
    .justify-content-center {
        justify-content: center !important;
    }
     .d-flex {
         display: flex !important;
     }

    @media (min-width: 992px){
    .ml-lg-0, .mx-lg-0
        margin-left: 0px !important;
    }
    @media (min-width: 992px){
    .mr-lg-0, .mx-lg-0
        margin-right: 0px !important;
    }
     .ml-4, .mx-4 {
         margin-left: 1.5rem !important;
     }

     .mr-4, .mx-4 {
         margin-right: 1.5rem !important;
     }
     .mt-2, .my-2 {
         margin-top: 0.5rem !important;
     }

    .ml-3, .mx-3 {
        margin-left: 1rem !important;
    }
     .flex-grow-1 {
         flex-grow: 1 !important;
     }
    .ml-3, .mx-3 {
        margin-left: 1rem !important;
    }
    ml-3, .mx-3 {
        margin-left: 1rem !important;
    }
</style>

<script>
    var sayac=0;
    $("#add_row").click(function () {
            sayac++;
            var someText = `<div class="offset-lg-2 col-lg-8">
                        <div class="ingredient-item mt-2  mx-4 mx-lg-0">
                            <div class="d-flex flex-wrap row">
                                <div class="flex-grow-1 ml-3"><div class="" style="display: inline;">
                                        <input class="form-control " placeholder="Ürün adını giriniz" data-tid="input-ingredient-autocomplete" role="combobox" aria-autocomplete="list" aria-expanded="false" autocomplete="off" value="">
                                    </div>
                                </div>
                                <div class="ml-3" style="max-width: 250px;">
                                    <div class="input-group">
                                        <input class="form-control false" type="number" required="" min="0" step="0.0001" data-tid="input-ingredient-quantity" placeholder="Miktar" value="">
                                    </div>
                                </div>
                                <div class="col-form-label ml-3"><button  type="button" class="removes close close-danger"
                                data-dismiss="alert" aria-label="Close" data-tid="remove-ingredient-btn"><i class="icon-trash" style="font-size: 1.1em;"></i></button></div>
                            </div>
                        </div>
                    </div>`;

            $('.uretim_div').css('display','block');
            $('.uretim_baslik').css('display','block');
            $('.uretim_div').append(someText);
        }
    );


    $(document).on('click', '.removes', function () {
        if ($('.removes').length > 1) {
            $(this).parent().parent().parent().parent().remove();
        }
        else
        {
            $('.uretim_div').css('display','none');
            $('.uretim_baslik').css('display','none');
            $(this).parent().parent().parent().parent().remove();

        }
    });

     $(document).on('keyup', '#miktar', function (e) {
        var deger=$('#miktar').val();
        var warehouse_id=$('#warehouse_id').val();
        if(deger < 1)
        {
            $('.devam').attr('disabled',true);
            $('.recete_table').remove();
        }
        else
            {
                var dump;

                $('.devam').attr('disabled',false)
                var mamul_product_id=$('#new_prd_id').val();
                $.ajax({
                    url: baseurl + 'uretim/recete_getir',
                    method: 'post',
                    data: 'product_id='+mamul_product_id+'&miktar='+deger+'&recete_id='+$('#recete_id_get').val()+'&warehouse_id='+warehouse_id,
                    success: function (data) {

                        let responses = jQuery.parseJSON(data);
                        $('.recete_table').remove();

                        $('.recete_div').after(responses.message);
                        if(responses.status){
                            $('#post_button').attr('disabled',true);
                        }
                        else {
                            $('#post_button').attr('disabled',false);
                        }

                    }
                });




            }
     });

     $(document).on('click','#post_button',function () {
         // $.ajax({
         //     url: baseurl + 'uretim/save_uretim',
         //     dataType: "json",
         //     method: 'post',
         //     data: $('#uretim_form').serialize()+'&'+d_csrf,
         //     success: function (data) {
         //         if (data.status == "Başarılı") {
         //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
         //             $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
         //             $("html, body").scrollTop($("body").offset().top);
         //             $("#uretim_form").remove();
         //             $(".recete_div").remove();
         //             $(".recete_table").remove();
         //             $(".baslik").remove();
         //         } else {
         //             $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
         //             $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
         //             $("html, body").scrollTop($("body").offset().top);
         //         }
         //
         //
         //     }
         // });

         $.confirm({
             theme: 'modern',
             closeIcon: false,
             title: 'Üretim Fişi Oluşturma',
             icon: 'fas fa-check 3x',
             type: 'green',
             animation: 'scale',
             useBootstrap: true,
             columnClass: "small",
             containerFluid: !0,
             smoothContent: true,
             draggable: false,
             content: 'Üretim Fişi Oluşturmak İstediğinizden Emin Misiniz?',
             buttons: {
                 formSubmit: {
                     text: 'Evet',
                     btnClass: 'btn-blue',
                     action: function() {
                         $('#loading-box').removeClass('d-none');
                         $.post(baseurl + 'uretim/save_uretim', $('#uretim_form').serialize(), (response) => {
                             $('#loading-box').addClass('d-none');
                             let data = jQuery.parseJSON(response);
                             if (data.status == 200) {
                                 $.alert({
                                     theme: 'modern',
                                     icon: 'fa fa-check',
                                     type: 'green',
                                     animation: 'scale',
                                     useBootstrap: true,
                                     columnClass: "col-md-4 mx-auto",
                                     title: 'Başarılı',
                                     content: data.message,
                                     buttons: {
                                         prev: {
                                             text: 'Tamam',
                                             btnClass: "btn btn-link text-dark",
                                             action: function() {
                                                 window.location.href= data.link;
                                             }
                                         },
                                     }
                                 });
                             } else if (data.status == 410) {
                                 $.alert({
                                     theme: 'modern',
                                     icon: 'fa fa-exclamation',
                                     type: 'red',
                                     animation: 'scale',
                                     useBootstrap: true,
                                     columnClass: "col-md-4 mx-auto",
                                     title: 'Dikkat!',
                                     content: data.message,
                                     buttons: {
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
                 cancel: {
                     text: 'İmtina et',
                     btnClass: "btn btn-danger btn-sm",
                 }
             },

             onContentReady: function() {


                 $('.select-box').select2({
                     dropdownParent: $(".jconfirm-box-container")
                 })
                 // bind to events
                 var jc = this;
                 this.$content.find('form').on('submit', function(e) {
                     // if the user submits the form by pressing enter in the field.
                     e.preventDefault();
                     jc.$$formSubmit.trigger('click'); // reference the button and click it
                 });
             }
         });

     });

    $(document).ready(function () {
        var recete_id=$('#recete_id_get').val();

        var mamul_product_id=$('#new_prd_id').val();
        var new_prd_name=$('#new_prd_name').val();
        var warehouse_id=$('#warehouse_id').val();

        if(recete_id && parseInt(warehouse_id))
        {
            $('#mamul_product_id').val(mamul_product_id);
            $('#uretim_product_name').val(new_prd_name);
            $('#miktar').val(1);
            $('.uretim_tarihi').css('display','block');
            $('.uretim_bitis').css('display','block');
            $('.uretim_aciklamasi').css('display','block');
            $('.miktar').css('display','block');
            $('.personel').css('display','block');
            $('.yan_urun').css('display','block');
            $('.devam').attr('disabled',false)
            $.ajax({
                url: baseurl + 'uretim/recete_getir',
                method: 'post',
                data: 'product_id='+mamul_product_id+'&miktar=1&recete_id='+$('#recete_id_get').val()+'&warehouse_id='+warehouse_id,
                success: function (data) {
                    $('.recete_div').after(data);

                }
            });

        }
    });

    function siparis_emri(pid,grk_stk) {
        $.ajax({
            url: baseurl + 'uretim/siparis_emri',
            method: 'post',
            data: 'product_id='+pid+'&miktar='+grk_stk+'&'+d_csrf,
            success: function (data) {
                alert('Sipariş Emri Oluşturuldu');


            }
        });
    }


    $( "#warehouse_id").change(function() {
        let val=$(this).val();
        if(parseInt(val))
        {
            $('#miktar').attr('disabled',false);
        }
        else
        {
            $('#miktar').attr('disabled',true);
        }

    });

</script>