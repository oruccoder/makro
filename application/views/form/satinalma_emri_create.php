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

                                <div class="col-sm-1">
                                    <label class="col-form-label"
                                           for="name"><?php echo $this->lang->line('talep no') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Talep No #"
                                               class="form-control margin-bottom  required" name="talep_no"
                                        >
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <label class="col-form-label"
                                    ><?php echo $this->lang->line('proje name') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Proje Adı"
                                               class="form-control margin-bottom editdate" name="proje_name" autocomplete="false"
                                        >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control Tarihi required" id="tsn_due"
                                               name="olusturma_tarihi"
                                               placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxformat" class="col-form-label">Hazırlayan</label>
                                    <select class="form-control Tarihi" name="hazirlayan_per_is">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label for="taxformat" class="col-form-label">Talep Eden</label>
                                    <select class="form-control Tarihi" name="talep_eden_pers_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Satın Alma Sorumlusu</label>
                                    <select class="form-control satin_alma_personeli" name="satin_alma_personeli">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Proje Müdürü</label>
                                    <select class="form-control proje_muduru_id" name="proje_muduru_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('genel_mudur') ?></label>
                                    <select class="form-control Tarihi" name="genel_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Finans Departmanı</label>
                                    <select class="form-control Tarihi" name="finans_departman_pers_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Bölüm Müdürü</label>
                                    <select class="form-control" name="bolum_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div id="saman-row" class="col-sm-12">
                        <table class="table tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('product detail') ?></th>
                                <th width="20%">Uygun Görülen Firma</th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="5%" class="text-center">Birim</th>
                                <th width="15%" class="text-center">Birim Fiyatı</th>
                                <th width="15%" class="text-center">KDV</th>
                                <th width="10%" class="text-center">Tutar</th>
                                <th width="10%" class="text-center">Satın Alma Personeli</th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>


                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]"
                                           placeholder="<?php echo $this->lang->line('product detail') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma[]"  id="firma-0"
                                           placeholder="Firma">
                                </td>

                                <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('0'), billUpyog()"
                                           autocomplete="off" value="1">
                                <input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>




                                <td>
                                    <input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('0'), billUpyog()"
                                           autocomplete="off">

                                </td>
                                <td>
                                    <input type="text" class="form-control req prc" name="tax[]" id="tax-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('0'), billUpyog()"
                                           autocomplete="off">

                                </td>

                                <td>
                                    <input type="text" class="form-control product_tutar" name="product_tutar[]"
                                           onkeypress="return isNumber(event)" id="product_tutar-0"
                                           onkeyup="rowTotalSF('0'), billUpyog()" autocomplete="off">

                                </td>
                                <td>
                                    <select class="form-control Tarihi select2" name="satin_alma_pers_item_id[]">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

                                </td>


                                <td class="text-center">

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
                    <input type="hidden" value="<?php echo $this->aauth->get_user()->loc ?>" id="loc_id">
                    <input type="hidden" value="form/action_satinalma_emri" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">
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

<script>








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
        $('.select2').select2();

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
        var data = `<tr>
                                <td>
                                    <input type="text" class="form-control" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]"
                                           placeholder="<?php echo $this->lang->line('product detail') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="firma[]"  id="firma-`+cvalue+`"
                                           placeholder="Firma">
                                </td>

                                <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off" value="1">
                                <input type="hidden" id="alert-`+cvalue+`" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>




                                <td>
                                    <input type="text" class="form-control req prc" name="product_price[]" id="price-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off">

                                </td>
                                <td>
                                    <input type="text" class="form-control req prc" name="tax[]" id="tax-`+cvalue+`"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()"
                                           autocomplete="off">

                                </td>

                                <td>
                                    <input type="text" class="form-control product_tutar" name="product_tutar[]"
                                           onkeypress="return isNumber(event)" id="product_tutar-`+cvalue+`"
                                           onkeyup="rowTotalSF('`+cvalue+`'), billUpyog()" autocomplete="off">

                                </td>
                                <td>
                                    <select class="form-control Tarihi select2" name="satin_alma_pers_item_id[]">

                                            <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

                                </td>

 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;;
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);
        $('.select-box').select2();
        $('.select2').select2();

        disc_degis($('#discount_rate').val());

        row = cvalue;



    });

    var rowTotalSF = function (numb) {


        var amountVal = formInputGet("#amount", numb);
        var birim_1 = formInputGet("#price", numb);
        var tax = formInputGet("#tax", numb);
        $("#product_tutar-"+numb).val(birim_1*amountVal);
    }
</script>
