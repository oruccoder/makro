<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Virman</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <form method="post" id="data_form" class="form-horizontal">
                                            <input type="hidden" class="form-control required"
                                                   name="date" data-toggle="datepicker" id="invoice_date"
                                                   autocomplete="false">
                                            <div class="grid_3 col-sm-12">



                                                <div class="form-group row">

                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Çıkan Kasa</label>
                                                        <div class="col-sm-6">
                                                            <select name="cikan_hesap" class="form-control select-box zorunlu" id="cikan_hesap">
                                                                <option value="0">Seçiniz</option>
                                                                <?php
                                                                foreach (all_account() as $row) {
                                                                    $cid = $row->id;
                                                                    $acn = $row->acn;
                                                                    $holder = $row->holder;
                                                                    $doviz = para_birimi_ogren_id($row->para_birimi);
                                                                    $balance = amountFormat(new_balace($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                                                                    echo "<option doviz='$doviz' value='$cid'>$acn - $holder</option>";
                                                                }
                                                                ?>
                                                            </select>


                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Giren Kasa </label>

                                                        <div class="col-sm-6">
                                                            <select name="gelen_hesap" class="form-control select-box zorunlu" id="gelen_hesap">
                                                                <option value="0">Seçiniz</option>
                                                                <?php
                                                                foreach (all_account() as $row) {
                                                                    $cid = $row->id;
                                                                    $acn = $row->acn;
                                                                    $holder = $row->holder;
                                                                    $doviz = para_birimi_ogren_id($row->para_birimi);
                                                                    $balance = amountFormat(new_balace($cid),$row->para_birimi); //amountFormat($row['lastbal']);
                                                                    echo "<option doviz='$doviz' value='$cid'>$acn - $holder </option>";
                                                                }
                                                                ?>
                                                            </select>


                                                        </div>
                                                    </div>





                                                    <div class="col-sm-4">
                                                        <label class="col-sm-4 col-form-label"
                                                               for="invoice_kur_degeri">Kur</label>


                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" placeholder="Kur"
                                                                   name="kur_degeri" id="kur_degeri" value="1">
                                                        </div>


                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="col-sm-4">
                                                            <span style="border: none !important;width: 400px !important;" class="form-control" id="text">1 <t class="cikan_hesap_para_birimi_str">AZN</t> = <t class="cevirme_deger">1</t> <t class="giren_hesap_para_birimi">EURO</t></span>
                                                            <span style="border: none !important;width: 400px !important;" class="form-control" id="text">1  <t class="giren_hesap_para_birimi">EURO</t>= <t class="cevirme_deger2">1</t> <t class="cikan_hesap_para_birimi_str">AZN</t></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Çıkan Tutar</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control zorunlu" name="tutar_cikan" id="tutar_cikan">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Gelen Tutar</label>

                                                        <div class="col-sm-6">
                                                            <input class="form-control zorunlu" name="gelen_tutar" id="tutar_giren">
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Hesaba Geçecek Çıkan Tutar</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" name="tutar_cikan" id="hesap_tutar_cikan" >
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Hesaba Geçecek Gelen Tutar</label>

                                                        <div class="col-sm-6">
                                                            <input class="form-control" name="tutar_gelen" id="hesap_tutar_gelen">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Tarih</label>

                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control  required"
                                                                   placeholder="Billing Date" name="invoicedate" id="invoice_date"
                                                                   data-toggle="datepicker"
                                                                   autocomplete="false">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-sm-6 col-form-label"
                                                               for="pay_cat">Açıklama</label>

                                                        <div class="col-sm-6">
                                                            <textarea class="form-control" name="notes"></textarea>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input style="float: right" type="button" onclick="action_doviz()" id="submit_doviz" class="btn btn-success margin-bottom"value="<?php echo $this->lang->line('Add transaction') ?>" data-loading-text="Adding...">
                                                            <input  type="submit" id="submit-data" style="visibility: hidden">
                                                            <input type="hidden" value="transactions/save_transfer_doviz" id="action-url">
                                                        </div>





                                                    </div>





                                                </div>

                                        </form>
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



    <script>

        $('#cikan_hesap').on('change', function() {
            var deger = $('option:selected',this).attr('doviz');
            $('.giren_hesap_para_birimi').html(deger);

        });

        $('#gelen_hesap').on('change', function() {
            var deger = $('option:selected',this).attr('doviz');
            $('.cikan_hesap_para_birimi_str').html(deger);

        });

        $('#kur_degeri').keyup(function () {

            var val =1/$(this).val();
            $('.cevirme_deger').html($(this).val());
            $('.cevirme_deger2').html(val.toFixed(3));


            var carpan=$('.cevirme_deger2').html();
            var deger= $('#tutar_cikan').val()*carpan;
            $('#tutar_giren').val(deger.toFixed(2));
            $('#hesap_tutar_gelen').val(deger.toFixed(2));
            $('#hesap_tutar_cikan').val( $('#tutar_cikan').val());




        })

        $('#tutar_cikan').keyup(function () {

            var carpan=$('.cevirme_deger2').html();

            var deger=$(this).val()*carpan;
            $('#tutar_giren').val(deger.toFixed(2));
            $('#hesap_tutar_gelen').val(deger.toFixed(2));
            $('#hesap_tutar_cikan').val($(this).val());


        })

        $('#tutar_giren').keyup(function () {

            var carpan=$('.cevirme_deger').html();

            var deger=$(this).val()*carpan;
            $('#hesap_tutar_cikan').val(deger.toFixed(2));
            $('#tutar_cikan').val(deger.toFixed(2));
            $('#hesap_tutar_gelen').val($(this).val());


        })

        $('#kur_al').click(function () {
            var para_birimi=$('#para_birimi').val();
            var invoice_date=$('#invoice_date').val();
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/kur_al',
                data: 'para_birimi='+ para_birimi+
                    '&invoice_date='+ invoice_date,
                success: function (data) {
                    $('#kur_degeri').val(data);

                }
            });


        });

        function action_doviz(){
            let value_say =0 ;
            let count = $('.zorunlu').length;
            for (let i = 0; i < count; i++){
                let  value  = $('.zorunlu').eq(i).val();
                if(value=='' || value=='0'){
                    value_say++;

                }
            }

            if(value_say){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content:  'Zorunlu Alanlar Mevcut',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
                return false;
            }
            else {
                $('#submit-data').click();
            }
        }
    </script>
