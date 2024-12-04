<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>

<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Maliyet Hesaplaması</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div id="notify" class="alert alert-success" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"></div>
                    </div>
                        <form id="maliyet_form">
                            <input type="hidden" name="recete_id" value="<?php echo $recete_id ?>">
                        <div class="grid_3 grid_4" style="color: white;">

                            <button class="btn btn-primary btn-sm rounded "  id="alis_fiyati_guncelle"> <?php echo $this->lang->line('update_product_button') ?>
                              <i class="icon-refresh"></i>  </button>
                        </div>

                        <h2 class="baslik" style="text-align: center">Maliyet Hesaplaması</h2>
                            <p style="text-align: center">Maliyeti Hesaplanacak Üretimin Reçetesindeki Ürünlerin Bilgisi</p>
                            <p style="text-align: center">Güncel Maliyet</p>
                            <p style="text-align: center"><b><?php echo amountFormat($maliyet)?></b></p>


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ürün Adı</th>
                                        <th></th>
                                        <th>Alış Fiyatı</th>
                                        <th></th>
                                        <th>Toplam Kullanılacak Miktar</th>
                                        <th></th>
                                        <th>Toplam Tutar</th>
                                    </tr>
                                </thead>
                                <tbody>

                            <?php if($products)
                            {
                                foreach ($products as $prd)
                                {

                                ?>

                                    <tr>
                                        <th><?php echo $prd['product'] ?>
                                            <input type="hidden" name="product_name[]" value="<?php echo $prd['product'];  ?>">
                                            <input type="hidden" name="product_id[]" value="<?php echo $prd['pid'];  ?>">
                                        </th>
                                        <td><?php echo '1 '.units_($prd['unit'])['name'] ?> Alış Fiyatı </td>
                                        <td>
                                            <input data-toggle="tooltip" data-placement="top" product_id="<?php echo $prd['pid'];  ?>" title="Ürün Detaylarından Alış Fiyatı Giriniz.Sonrasında Güncel Fiyatları Çekiniz."
                                                   disabled class="form-control alis_fiyati" value="<?php echo $prd['price']; ?>">

                                            <input type="hidden" name="alis_fiyati[]" class="alis_fiyati_hidden" value="<?php echo  $prd['price'];  ?>">
                                        </td>
                                        <td>X</td>
                                        <td><?php echo product_total_tuketim($prd['pid'],$uretim_id).' '.units_($prd['unit'])['name']?>
                                        <input type="hidden" name="kull_mik[]" class="kull_mik" value="<?php echo floatval(product_total_tuketim($prd['pid'],$uretim_id)) ?>">
                                        </td>
                                        <td>=</td>
                                        <td class="price">0,00 <?= currency($this->aauth->get_user()->loc); ?></td>
                                    </tr>
                            <?php
                                }
                            } ?>

                                <tr>
                                    <td colspan="6" style="text-align: right;"><b>Ara Toplam</b></td>
                                    <td class="genel_toplam1" colspan="6" style="text-align: left;">0,00 <?= currency($this->aauth->get_user()->loc); ?>
                                    </td>
                                    <input type="hidden" name="recete_maliyeti" id="genel_toplam1" value="0">
                                </tr>
                                </tbody>
                            </table>

                            <hr>
                            <h2 class="baslik" style="text-align: center">Önceki Giderler</h2>
                            <p style="text-align: center">Daha Önceden Hesaplanmış Maliyet</p>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Gider Adı</th>
                                    <th>Tutar</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($all_giders as $items){
                                    echo "<tr>
                                    <td>".$items->name."</td>
                                    <td>".amountFormat($items->toplam_price)."</td>
                                    <td><button type='button' class='btn btn-danger gider_remove' data-gider-id='".$items->id."'><i class='fa fa-trash'></i></button></td>
                                </tr>";
                                } ?>
                                </tbody>
                            </table>
                            <hr>

                            <h2 class="baslik" style="text-align: center">Üretim Dönemi Tahmini Giderleri</h2>
                            <p style="text-align: center">Malzeme giderleri dışında üretimin gerçekleşmesi için dönem içerisinde oluşacak tahmini giderlerinizi giriniz</p>
                            <div class="d-flex justify-content-center">
                                <button type="button" id="add_row" class="btn btn-success btn-xs devam" data-tid="continue-to-ingredients-list">Ekle</button>
                            </div>
                             </br>


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="70%">Gider Adı</th>
                                        <th>Tutarı</th>
                                        <th width="5%"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="add_rows">
                                <tr>
                                    <td><select class="form-control" name="gider_tipi[]">
                                            <option value="0">Seçiniz</option>
                                            <option value="İşçilik">İşçilik (Mebel) </option>
                                            <option value="Elektrik">Elektrik</option>
                                            <option value="Yönetim Giderleri">Yönetim Giderleri</option>
                                            <option value="DSMF 22.5% (e/h-nın 15.5 faizi)">DSMF 22.5% (e/h-nın 15.5 faizi)</option>
                                            <option value="Amortizasiya x.(Xammal ve materialın 5 faizi)">Amortizasiya x.(Xammal ve materialın 5 faizi)</option>
                                            <option value="Sex xerci (e/h ve DSMF-nin cemini 20 Faizi)">Sex xerci (e/h ve DSMF-nin cemini 20 Faizi)</option>
                                        </select></td>
                                    <td><input class="form-control tutar" name="tutar[]" value='0.00'></td>
                                    <td style="padding-top: 20px;"><?= currency($this->aauth->get_user()->loc); ?></td>
                                    <td style="padding-top: 17px;"><button  type="button" class="removes close close-danger"
                                                                            data-dismiss="alert" aria-label="Close" data-tid="remove-ingredient-btn"><i class="icon-trash" style="font-size: 1.1em;"></i></button></td>
                                </tr>


                                </tbody>
                                <tr>
                                    <td colspan="2" style="text-align: right;"><b>Ara Toplam</b></td>
                                    <td class="genel_toplam2" colspan="2" style="text-align: left;">0,00 <?= currency($this->aauth->get_user()->loc); ?>

                                    </td>
                                    <input type="hidden" value="0" id="genel_toplam2">
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right;"><b>Genel Toplam</b></td>
                                    <td class="genel_toplam3" colspan="2" style="text-align: left;">0,00 <?= currency($this->aauth->get_user()->loc); ?>

                                    </td>
                                    <input type="hidden" value="0" id="genel_toplam3">
                                </tr>
                            </table>




                            <div class="row recete_div">
                                <div class="offset-lg-4 col-lg-4">
                                    <div class="d-flex justify-content-center">
                                        <button type="button" id="post_button" class="btn btn-info btn-lg devam" data-tid="continue-to-ingredients-list">Maliyeti İşle</button>
                                    </div>


                                </div>

                            </div>
                            <input type="hidden" name="uretim_id" value="<?php echo $uretim_id;?>">
                        </form>



                        <!-- Reçete Tablosu Gelecek -->
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

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
    function satir_guncelle() {
        var cuur = '<?= currency($this->aauth->get_user()->loc); ?>';

        var sayi =$('.kull_mik').length;

        var ara_toplam2=0;

        var genel_toplam=0;
        for(var i=0;i<sayi;i++)
        {
            var deger=$('.alis_fiyati').eq(i).val();
            var kullanilan_mik = $('.kull_mik').eq(i).val();
            var toplam_tutar = parseFloat(deger) * parseFloat(kullanilan_mik);
            genel_toplam+=toplam_tutar;
            $('.price').eq(i).text(currencyFormat(toplam_tutar));
        }

        $('.genel_toplam1').text(currencyFormat(genel_toplam))
        $('#genel_toplam1').val(genel_toplam.toFixed(2));

        ara_toplam2 = $('#genel_toplam2').val();
        var sont= parseFloat(ara_toplam2)+parseFloat(genel_toplam);

        $('.genel_toplam3').text(currencyFormat(sont));
        $('#genel_toplam3').val(sont.toFixed(2));

    }

    $( document ).ready(function() {
        satir_guncelle();

    });

    $(document).on('keyup','.tutar',function (e) {
        var sayi =$('.tutar').length;
        var toplam_tutar=0;
        for(var i=0;i<sayi;i++)
        {
            var deger=$('.tutar').eq(i).val();
            toplam_tutar += parseFloat(deger);

        }
        $('.genel_toplam2').text(currencyFormat(toplam_tutar));
        $('#genel_toplam2').val(toplam_tutar.toFixed(2));
        var ara_toplam1 = $('#genel_toplam1').val();

        var snt=parseFloat(ara_toplam1)+parseFloat(toplam_tutar);

        $('#genel_toplam3').val(snt.toFixed(2));
        $('.genel_toplam3').text(currencyFormat(snt));
    });

    $(document).on('click','#post_button',function (e) {
        setTimeout(function () {
            $.ajax({
                url: baseurl + 'uretim/save_maliyet',
                dataType: "json",
                method: 'post',
                data: $('form').serialize() + '&' + d_csrf,
                success: function (data) {
                    if (data.status == "Başarılı")
                    {
                        alert(data.message);
                        location.href = '/uretim/view_uretim_fisi?id='+data.uretim_id;


                    }
                    else {
                        alert('Sorun Oluştur!')
                    }
                }
            });
        });

    });

    $(document).on('click', '#alis_fiyati_guncelle', function (e) {
        var i=0;

        var $btn =$('#alis_fiyati_guncelle');
        var text=$btn.text();
        $btn.text('Yükleniyor...');
        $btn.attr('disabled',true);
        // simulating a timeout
        setTimeout(function () {
            $.ajax({
                url: baseurl + 'uretim/alis_fiyati_guncelle',
                dataType: "json",
                method: 'post',
                data: $('form').serialize() + '&' + d_csrf,
                success: function (data) {
                    if (data.status == "Başarılı") {
                        var sayi = $('.alis_fiyati').length;
                        for (i=0; i<sayi;i++)
                        {
                            var prd = $('.alis_fiyati').eq(i).attr('product_id');

                            if(data.data[i]['product_id']==prd)
                            {
                                $('.alis_fiyati').eq(i).val(data.data[i]['alis_fiyati']);
                                $('.alis_fiyati_hidden').eq(i).val(data.data[i]['alis_fiyati']);

                            }
                            //console.log(data.data[i]['product_id']);
                        }
                        satir_guncelle();
                        alert(data.message);


                    } else {
                        alert('Sorun Oluştur!')
                    }
                }
            });
            $btn.text(text);
            $btn.attr('disabled',false);
        }, 4000);
    });



    $("#add_row").click(function () {
            var someText = ` <tr>
                            <td><select class="form-control" name="gider_tipi[]">
                                    <option>Seçiniz</option>
                                    <option value="İşçilik">İşçilik (Mebel) </option>
                                    <option value="Elektrik">Elektrik</option>
                                    <option value="Yönetim Giderleri">Yönetim Giderleri</option>
                                    <option value="DSMF 22.5% (e/h-nın 15.5 faizi)">DSMF 22.5% (e/h-nın 15.5 faizi)</option>
                                    <option value="Amortizasiya x.(Xammal ve materialın 5 faizi)">Amortizasiya x.(Xammal ve materialın 5 faizi)</option>
                                    <option value="Sex xerci (e/h ve DSMF-nin cemini 20 Faizi)">Sex xerci (e/h ve DSMF-nin cemini 20 Faizi)</option>
                                </select></td>
                            <td><input class="form-control tutar" name="tutar[]" value='0.00'></td>
                            <td style="padding-top: 20px;"><?= currency($this->aauth->get_user()->loc); ?></td>
                            <td style="padding-top: 17px;"><button  type="button" class="removes close close-danger"
                                data-dismiss="alert" aria-label="Close" data-tid="remove-ingredient-btn"><i class="icon-trash" style="font-size: 1.1em;"></i></button></td>
                        </tr>`;

            $('.add_rows').append(someText);
        }
    );

    $(document).on('click', '.removes', function () {
            $(this).parent().parent().remove();


    });


    $(document).on('click','.gider_remove',function (){
        let id = $(this).data('gider-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İş Kalemi Sil',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Gider Kalemini Silmek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            id: id,
                        }
                        $.post(baseurl + 'uretim/delete_gider',data,(response) => {
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
                                                $('.gider_remove').parent().parent().parent().remove();
                                            }
                                        }
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

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
            }
        });


    })



</script>