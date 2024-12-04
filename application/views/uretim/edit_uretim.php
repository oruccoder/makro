<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">

                    <div class="message"></div>


                </div>
                <input type="hidden" value="<?php echo $recete_id;?>" id="recete_id_get">


                <?php if($recete_id){
                    $product_id = recete_id_in_product($recete_id);
                    $product_name = product_name($product_id);
                    echo "<input type='hidden' value='$product_id' id='new_prd_id'>";
                    echo "<input type='hidden' value='$product_name' id='new_prd_name'>";
                } ?>

                <h2 class="baslik" style="text-align: center">Ne Üretmek İstersiniz?</h2><br>
                <form id="uretim_form">
                    <input type="hidden" value="<?php echo $uretim_id;?>" name="uretim_id">
                    <div class="form-group row">
                        <div class="offset-lg-3 col-lg-6">

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Mamül Adını Giriniz"
                                       name="uretim_product_name" id="uretim_product_name">
                                <input type="hidden" id="mamul_product_id" name="mamul_product_id">


                            </div>
                        </div>
                    </div>
                    <div class="form-group row miktar" style="display: none">
                        <div class="offset-lg-3 col-lg-6">

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Miktar"
                                       name="miktar" id="miktar" value="<?php echo $miktar?>">


                            </div>
                        </div>
                    </div>
                    <div class="form-group row personel" style="display: none">
                        <div class="offset-lg-3 col-lg-6">

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                <input type="hidden" value="<?php echo $personel_id ?>" name="old_user_id">
                                <select name="personel" class="form-control select-box">
                                    <?php
                                    foreach ($emp as $row) {


                                        $cid = $row['id'];
                                        $title = $row['name'];
                                        if($personel_id==$cid)
                                        {
                                            echo "<option selected value='$cid'>$title</option>";
                                        }
                                        else
                                            {
                                                echo "<option value='$cid'>$title</option>";
                                            }

                                    }
                                    ?>
                                </select>


                            </div>
                        </div>
                    </div>

                    <div class="form-group row uretim_bitis" style="display: none">
                        <div class="offset-lg-3 col-lg-6">

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Tahmini Bitirme Tarihi"
                                       name="uretim_bitis" id="uretim_bitis"  value="<?php echo  dateformat($tahmini_bitirme_tarihi) ?>"
                                       >


                            </div>
                            <p>Tahmini Bitirme Tarihi</p>
                        </div>
                    </div>
                    <div class="form-group row uretim_tarihi" style="display: none">

                        <div class="offset-lg-3 col-lg-6">

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Üretim Tarihi"
                                       name="uretim_tarihi" id="uretim_tarihi"  value="<?php echo  dateformat($uretim_tarihi) ?>" 
                                       >


                            </div>
                            <p>Üretim Tarihi</p>
                        </div>
                    </div>

                    <div class="form-group row uretim_aciklamasi" style="display: none">
                        <div class="offset-lg-3 col-lg-6">

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Üretim Açıklaması"
                                       name="uretim_aciklamasi" id="uretim_aciklamasi" value="<?php echo $uretim_desc; ?>" >


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row yan_urun" style="display: none">
                            <div class="offset-lg-3 col-lg-6">
                                <div class="col d-flex justify-content-end">
                                    <button disabled id="add_row" type="button" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip"
                                            data-original-title="Üretiminiz sonucunda birden fazla ürün ortaya çıkıyorsa
                                            bu bölümü kullanabilirsiniz. Mobilya üretiminde talaş, yoğurt üretiminde kaymak vb."
                                            data-tid="add-more-inflow-ingredient-btn">
                                        <span class="font-weight-light"><i class="icon-plus pr-1"></i>Yan Ürün Ekle</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="row mt-4 uretim_div" style="display: none">
                            <div class="offset-lg-2 col-lg-8 d-flex justify-content-center">
                                <span class="font-20 text-black-50 font-weight-light uretim_baslik" style="display: none">Üretimde Oluşan Yan Ürünler</span>
                            </div>
                            <!-- Ürün Satırı Gelecek -->
                        </div>
                    </div>
                </form>

                <div class="row recete_div">
                    <div class="offset-lg-4 col-lg-4">
                        <div class="d-flex justify-content-center">
                            <button type="button" id="post_button" disabled class="btn btn-info btn-lg devam" data-tid="continue-to-ingredients-list">Üretim Fişini Güncelle</button>
                        </div>
                    </div>
                </div>

                <!-- Reçete Tablosu Gelecek -->
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
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
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



    $('#uretim_product_name').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/search_mamul',
                dataType: "json",
                method: 'post',
                data: 'name_startsWith='+request.term+'&type=product_list&row_num=1&wid'+$("#warehouses option:selected").val()+'&'+d_csrf,
                success: function (data) {

                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                    $('.recete_table').remove();


                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {

            var product_id=ui.item.data[2];
            $('.uretim_tarihi').css('display','block');
            $('.uretim_bitis').css('display','block');
            $('.uretim_aciklamasi').css('display','block');
            $('.miktar').css('display','block');
            $('.personel').css('display','block');
            $('.yan_urun').css('display','block');
            $('#mamul_product_id').val(product_id);


        }
    });
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
        if(deger < 1)
        {
            $('.devam').attr('disabled',true)
            $('.recete_table').remove();
        }
        else
        {
            $('.recete_table').remove();
            $('.devam').attr('disabled',false)
            var mamul_product_id=$('#mamul_product_id').val();
            $.ajax({
                url: baseurl + 'uretim/recete_getir',
                method: 'post',
                data: 'product_id='+mamul_product_id+'&miktar='+deger+'&'+d_csrf,
                success: function (data) {
                    $('.recete_div').after(data);

                }
            });


        }
    });

    $(document).on('click','#post_button',function () {
        $.ajax({
            url: baseurl + 'uretim/update_uretim',
            dataType: "json",
            method: 'post',
            data: $('#uretim_form').serialize()+'&'+d_csrf,
            success: function (data) {
                if (data.status == "Başarılı") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#uretim_form").remove();
                    $(".recete_div").remove();
                    $(".recete_table").remove();
                    $(".baslik").remove();
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }


            }
        });
    });

    $(document).ready(function () {
        var recete_id=$('#recete_id_get').val();

        var mamul_product_id=$('#new_prd_id').val();
        var new_prd_name=$('#new_prd_name').val();
        var miktar=$('#miktar').val();

        if(recete_id)
        {
            $('#mamul_product_id').val(mamul_product_id);
            $('#uretim_product_name').val(new_prd_name);
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
                data: 'product_id='+mamul_product_id+'&miktar='+miktar+'&'+d_csrf,
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

</script>