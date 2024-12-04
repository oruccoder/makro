<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <h2 class="baslik" style="text-align: center">Hesaplama Yapmak İstediğiniz Mamulü Seçiniz?</h2><br>
            <form id="uretim_form">
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

                <div class="form-group row type_sec">
                    <div class="offset-lg-3 col-lg-6">

                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                           <select class="form-control" id="type_sec">
                               <option >Hesaplama Yapılacak Tipi Seçiniz</option>
                               <option value="1">Malzeme Bazlı Hesaplama</option>
                               <option value="2">Miktar Bazlı Hesaplama</option>
                           </select>


                        </div>
                    </div>
                </div>
                <div class="form-group row miktar" style="display: none">
                    <div class="offset-lg-3 col-lg-6">

                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                            <input type="text" class="form-control" placeholder="Miktar"
                                   name="miktar" id="miktar">


                        </div>
                    </div>
                </div>
            </form>

            <div class="row recete_div">

            </div>

            <!-- Reçete Tablosu Gelecek -->
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


                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {

            var product_id=ui.item.data[2];

            $('#mamul_product_id').val(product_id);


        }
    });


    $('#type_sec').on('change',function () {
        var deger = $(this).val();
        if(deger==2)
        {
            $('.miktar').css('display','block');
        }
        else if(deger==1)
            {
                $('.miktar').css('display','none');
                //hesaplama eldeki ürünlerle ne kadar olacak ona göre yapcağız

                var deger=$('#miktar').val();
                var mamul_product_id=$('#mamul_product_id').val();
                $.ajax({
                    url: baseurl + 'uretim/uretim_qty_hesapla',
                    method: 'post',
                    data: 'product_id='+mamul_product_id+'&'+d_csrf,
                    success: function (data) {
                       alert(data)

                    }
                });
            }
            else
                {
                    alert('Malzeme Yapılacak Tipi Seçiniz')
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
            $('.devam').attr('disabled',true);
            $('.recete_table').remove();
        }
        else
        {
            var dump;

            $('.devam').attr('disabled',false)
            var mamul_product_id=$('#mamul_product_id').val();
            $.ajax({
                url: baseurl + 'uretim/recete_getir',
                method: 'post',
                data: 'product_id='+mamul_product_id+'&miktar='+deger+'&'+d_csrf,
                success: function (data) {
                    $('.recete_table').remove();

                    $('.recete_div').after(data);

                }
            });




        }
    });

    $(document).on('click','#post_button',function () {
        $.ajax({
            url: baseurl + 'uretim/save_uretim',
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

        if(recete_id)
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
                data: 'product_id='+mamul_product_id+'&miktar='+1+'&'+d_csrf,
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