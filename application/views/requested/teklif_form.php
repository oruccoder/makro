<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group row">

                                <div class="col-md-3">
                                    <label class="col-form-label"
                                           for="name"><?php echo $this->lang->line('talep no') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Talep  No #"
                                               class="form-control margin-bottom  required" value="<?php echo numaric(3);?>" name="talep_no">
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control Tarihi required" id="tsn_due"
                                               name="olusturma_tarihi"
                                               placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="taxformat" class="col-form-label">Hazırlayan</label>
                                    <select class="form-control select-box" name="hazirlayan_per_is">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($_GET['pers_id']==$emp_id)
                                            {
                                                ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php
                                            }
                                            else
                                                {
                                                    ?>
                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php
                                                }
                                            ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                <input type="hidden" name="satin_alma_muduru" value="<?php echo $_GET['pers_id'] ?>">
                                <input type="hidden" name="proje_muduru_id" value="<?php echo $genel_mudur_id?>">
                                <input type="hidden" name="proje_id" value="<?php echo $proje_id?>">
                                <input type="hidden" name="proje_name" value="<?php echo proje_name($proje_id)?>">
                                <input type="hidden" name="genel_mudur_id" value="<?php echo $genel_mudur_id?>">
                                <input type="hidden" name="finans_departman_pers_id" value="<?php echo $finans_departman_pers_id?>">
                                <input type="hidden" name="satinalma_personeli" value="<?php echo $_GET['pers_id'] ?>">
                                <input type="hidden" name="bolum_mudur_id" value="<?php echo $genel_mudur_id?>">
                                <input type="hidden" name="bolum_adi" value="">

                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday">Malzeme Talep Formu</label>

                                    <div class="input-group">
                                        <select class="form-control select-box" name="malzeme_talep_form_id" id="malzeme_talep_form_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (talep_list(1) as $talep)
                                            {
                                                if($tid==$talep->id)
                                                {
                                                    echo "<option selected value='$talep->id'>$talep->talep_no</option>";
                                                }
                                                else
                                                    {
                                                        echo "<option value='$talep->id'>$talep->talep_no</option>";
                                                    }

                                            } ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div id="saman-row" class="">
                        <table class="table table-responsive tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('product detail') ?></th>
                                <th width="20%">Firma</th>
                                <th width="20%">Firma Telefon</th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="5%" class="text-center">Birim</th>
                                <th width="15%" class="text-center">Birim Fiyatı</th>
                                <th width="10%" class="text-center">Esas Meblağ Edv H.</th>
                                <th width="10%" class="text-center">Teklif No / Tarih </th>
                                <th width="10%" class="text-center">Ödeme Şekli / Nakliye D.</th>
                                <th width="10%" class="text-center">Ödeme Tarihi </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>


                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]"
                                           placeholder="<?php echo $this->lang->line('product detail') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma[]"
                                           placeholder="Firma">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma_tel[0]"
                                           placeholder="Firma Telefonu">
                                </td>
                                <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('0'), billUpyog()"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]" id="unit-0"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>




                                <td>
                                    <input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('0'), billUpyog()"
                                           autocomplete="off">
                                </td>

                                <td>
                                    <input type="text" class="form-control product_tutar" name="product_tutar[]"
                                           onkeypress="return isNumber(event)" id="product_tutar-0"
                                           onkeyup="rowTotalSF('0'), billUpyog()" autocomplete="off">

                                </td>
                                <td>
                                    <input type="text" class="form-control teklif_tarih_no" name="teklif_tarih_no[]" id="teklif_tarih_no-0">

                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_sekli" name="odeme_sekli[]" id="odeme_sekli-0">
                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_tarihi" name="odeme_tarihi[]" id="odeme_tarihi-0">
                                </td>

                                <td class="text-center">
                                    <button type="hidden" class="removeProd"></button>
                                </td>
                            </tr>


                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align" id="addproduct_talep">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>



                            <tr class="sub_c" style="display: table-row;">
                                <input type="hidden" name="tip"  value="">

                                <td align="right" colspan="12"><input type="submit" class="btn btn-success sub-btn btn-lg"
                                                                      value="<?php echo $this->lang->line('requested talep') ?> "
                                                                      id="submit-data" data-loading-text="Creating...">

                                </td>

                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="AZN" id="para_birimi">
                    <input type="hidden" value="billing/action_satinalma" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?=$taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?=$taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?=$this->common->disc_status()['disc_format']; ?>" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?=$this->common->disc_status()['ship_rate']; ?>" name="shipRate" id="ship_rate">
                    <input type="hidden" value="<?=$this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype" id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">

                </form>
            </div>
        </div>
    </div>
</div>
<style>

        .container {
            max-width: 100% !important;
        }

</style>

<script>



    function selectCustomerSatin(eq,company,ph) {


        $('#company_name').eq(eq).val(company);
        $('#customer_phone').eq(eq).val(ph);
        $("#customer-box").eq(eq).val();
        $("#customer-box-result").eq(eq).hide();


    }

    function firmabul(obj)
    {
        var eq = $(obj).parent().parent().index();
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchSatin',
            data: 'keyword=' + $(obj).val()+'&invoice_type=' + 1 +'&eq=' + eq +'&'+crsf_token+'='+crsf_hash,
            beforeSend: function () {
                $(".customer-box").eq(eq).css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $(".customer-box-result").eq(eq).show();
                $(".customer-box-result").eq(eq).html(data);
                $(".customer-box").css("background", "none");

            }
        });
    }

    $("#malzeme_talep_form_id").on("change",function () {

        $('.removeProd').closest('tr').remove();


        var malzeme_talep_id =$("#malzeme_talep_form_id").val();
        var cvalue=0;
        $.ajax({
            type: "POST",
            url: baseurl + 'billing/talep_urunleri',
            data:
                'talep_id='+ malzeme_talep_id+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                $.each(jQuery.parseJSON(data), function(k, v) {
                    var deger=$('#ganak').val();
                    $('#ganak').val(parseInt(deger) +1);
                    var product_id = v['product_id'];
                    var product_name = v['product_name'];
                    var details = v['details'];
                    var qty = v['qty'];
                    var unit = v['unit'];



                    //EKLEME//


//product row
                    var data = ` <tr>
                                <td><input type="text" class="form-control" name="product_name[]" value="`+product_name+`">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]" value="`+details+`">
                                </td>
                                <td>
                                    <input type="text"  class="form-control" name="firma[]"
                                           placeholder="Firma">
                                            <div class="customer-box-result"></div>

                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma_tel[]"
                                           placeholder="Firma Telefonu">

                                </td>
                                <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off" value=`+qty+`><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]" value=`+unit+`  id="unit-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>




                                <td>
                                    <input type="text" class="form-control req prc" name="product_price[]" id="price-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off">
                                </td>

                                <td>
                                    <input type="text" class="form-control product_tutar" name="product_tutar[]"
                                           onkeypress="return isNumber(event)" id="product_tutar-`+cvalue+`"
                                           onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" class="form-control teklif_tarih_no" name="teklif_tarih_no[]" id="teklif_tarih_no-`+cvalue+`">

                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_sekli" name="odeme_sekli[]" id="odeme_sekli-`+cvalue+`">
                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_tarihi" name="odeme_tarihi[]" id="odeme_tarihi-`+cvalue+`">
                                </td>


                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
                    //ajax request
                    // $('#saman-row').append(data);
                    cvalue=cvalue+1;
                    $('tr.last-item-row').before(data);

                    //EKLEME//

                });

            }
        });

    })




    $('#invoice_type').on('change',function () {
        $('#customer-box').prop('disabled',false);
    });

    $('#iscilik_fiyati_al').click(function () {

        var product_id=$('#pid-0').val();

        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/iscilik_fiyati_al',
            data:
                'product_id='+ product_id+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                var price=$('#price-0').val();
                var urun_adi=$('#productname-0').val();
                var prices=parseFloat(price)+parseFloat(data);
                $('#price-0').val(prices)
                $('#productname-0').val(urun_adi+'-'+' İşçilik Dahil');

            }
        });

    });

    $('#kur_al').click(function () {
        var para_birimi=$('#para_birimi').val();
        var invoice_date=$('#invoice_date').val();
        var loc_id=$('#loc_id').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/kur_al',
            data:
                'para_birimi='+ para_birimi+
                '&invoice_date='+ invoice_date+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                $('#kur_degeri').val(data);

            }
        });

        $('#hdata').attr('data-curr',para_birimi);

        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/curr_degis',
            data:
                'para_birimi='+ para_birimi+
                '&loc='+ loc_id+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                $('.currenty').text(data);
                //alert(data);
            }
        });
    });


    //product total

    function disc_degis(deger) {
        if(deger!=0 || deger!="")
        {
            $('.discount').val(deger);
            $('.discount').trigger("keyup");
            $('.discount').attr('disabled',true)

        }
        else
        {
            $('.discount').attr('disabled',false)
        }

    }

</script>


<script type="text/javascript">

    $(function () {
        $('.select-box').select2();

        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });
    $('#malzeme_talep_form_id').change();

    $('#addproduct_talep').on('click', function () {

        if($('#para_birimi').val())
        {
            var currencys=$('#para_birimi').val();
        }
        else
        {

        }



        var cvalue = parseInt($('#ganak').val())+1;
        var invoice_type=$("#invoice_type").val();
        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;


//product row
        var data = ` <tr>
                                <td><input type="text" class="form-control" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]"
                                           placeholder="<?php echo $this->lang->line('product detail') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma[]"
                                           placeholder="Firma">

                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma_tel[]"
                                           placeholder="Firma Telefonu">
                                </td>
                                <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]"  id="unit-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>




                                <td>
                                    <input type="text" class="form-control req prc" name="product_price[]" id="price-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off">

                                </td>

                                <td>
                                    <input type="text" class="form-control product_tutar" name="product_tutar[]"
                                           onkeypress="return isNumber(event)" id="product_tutar-`+cvalue+`"
                                           onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()" autocomplete="off">

                                </td>
                                <td>
                                    <input type="text" class="form-control teklif_tarih_no" name="teklif_tarih_no[]" id="teklif_tarih_no-`+cvalue+`">

                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_sekli" name="odeme_sekli[]" id="odeme_sekli-`+cvalue+`">
                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_tarihi" name="odeme_tarihi[]" id="odeme_tarihi-`+cvalue+`">
                                </td>


                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);

        disc_degis($('#discount_rate').val());

        row = cvalue;



    });

    var rowTotalSF = function (numb) {


        var amountVal = formInputGet("#amount", numb);

        var birim_1 = $("#price-"+numb).val();


        $("#product_tutar-"+numb).val(birim_1*amountVal);
    }

    $("#proje_name").keyup(function () {

        var cari_type=2;
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchform',
            data: 'keyword=' + $(this).val() +'&'+'cari_type=' + cari_type+'&'+crsf_token+'='+crsf_hash,
            beforeSend: function () {
                $("#proje_name").css("backg", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#proje_name").css("backg", "none");

            }
        });
    });

    function selectProjectFis(cid, company) {

        $('#proje_id').val(cid);
        $('#proje_name').val(company);
        $("#customer-box-result").hide();


    }
</script>
