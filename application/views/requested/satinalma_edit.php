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
                                               class="form-control margin-bottom  required" value="<?php echo $invoice['talep_no'] ?>" name="talep_no"
                                        >
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <label class="col-form-label"
                                    ><?php echo $this->lang->line('proje name') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Proje Adı"
                                               class="form-control margin-bottom " value="<?php echo $invoice['proje_name'] ?>" id="proje_name" name="proje_name" autocomplete="false">

                                        <div id="customer-box-result"></div>

                                        <input type="hidden" name="proje_id" value="<?php echo $invoice['proje_id'] ?>" id="proje_id">

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control required editdate" id="tsn_due"
                                               name="olusturma_tarihi"
                                               placeholder="Due Date"  value="<?php echo dateformat($invoice['olusturma_tarihi']) ?>"  autocomplete="false">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxformat" class="col-form-label">Hazırlayan</label>
<!--                                    <input name="hazirlayan_per_is" type="hidden" value="--><?php //echo $invoice['hazirlayan_pers_id']; ?><!--">-->
<!--                                    <input class="form-control" disabled value="--><?php //echo personel_details($invoice['hazirlayan_pers_id']); ?><!--">-->

                                    <select class="form-control hazirlayan_per_is select-box" name="hazirlayan_per_is">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['hazirlayan_pers_id'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Satın Alma Müdürü</label>

<!--                                    <input name="satin_alma_muduru" type="hidden" value="--><?php //echo $invoice['satinalma_mudur_id']; ?><!--">-->
<!--                                    <input class="form-control" disabled value="--><?php //echo personel_details($invoice['satinalma_mudur_id']); ?><!--">-->

                                    <select class="form-control satin_alma_muduru select-box" name="satin_alma_muduru">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['satinalma_mudur_id'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>

                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Proje Müdürü</label>
                                    <select class="form-control proje_muduru_id select-box" name="proje_muduru_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['proje_muduru_id'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('genel_mudur') ?></label>
                                    <select class="form-control Tarihi select-box" name="genel_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['genel_mudur_id'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Finans Departmanı</label>
                                    <select class="form-control select-box" name="finans_departman_pers_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['finans_departman_pers_id'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Satın Alma Personeli</label>
<!--                                    <input name="satinalma_personeli" type="hidden" value="--><?php //echo $invoice['satinalma_personeli']; ?><!--">-->
<!--                                    <input class="form-control" disabled value="--><?php //echo personel_details($invoice['satinalma_personeli']); ?><!--">-->

                                    <select class="form-control satinalma_personeli select-box" name="satinalma_personeli">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['satinalma_personeli'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>


                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Depo / Şantiye Müdürü</label>
                                    <select class="form-control select-box" name="bolum_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['bolum_mudur_id'])
                                            { ?>
                                                <option selected value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php

                                            } else {
                                                ?>
                                                <option  value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday">Açıklama</label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Açıklama"
                                               class="form-control margin-bottom editdate"  value="<?php echo $invoice['aciklama'] ?>"  name="aciklama" autocomplete="false"
                                        >
                                        <input type="hidden" placeholder="Bölüm Adı"
                                               class="form-control margin-bottom editdate"  value="<?php echo $invoice['bolum_adi'] ?>"  name="bolum_adi" autocomplete="false"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday">Malzeme Talep Formu</label>

                                    <div class="input-group">
                                        <select class="form-control select-box" name="malzeme_talep_form_id" id="malzeme_talep_form_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (talep_list(1) as $talep)
                                            {
                                                if($invoice['malzeme_talep_form_id']==$talep->id)
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
                                <div class="col-md-1">
                                    <label class="col-form-label"
                                           for="birthday">İhale Formu</label>

                                    <div class="input-group">
                                        <select class="form-control select-box" name="ihale_formu_id" id="ihale_formu_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (ihale_list() as $talep)
                                            {
                                                if($invoice['ihale_formu_id']==$talep->id)
                                                {
                                                    echo "<option selected value='$talep->id'>$talep->dosya_no</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$talep->id'>$talep->dosya_no</option>";
                                                }

                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label class="col-form-label"
                                           for="birthday">Para Birimi</label>
                                    <div class="input-group">
                                        <select name="para_birimi_" id="para_birimi_" class="form-control">
                                            <?php
                                            foreach (para_birimi()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['code'];
                                                if($invoice['para_birimi']==$cid)
                                                {
                                                    echo "<option selected value='$cid->id'>$title</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$talep->id'>$title</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                    <style>
                        table input.form-control[type="text"]
                        {
                            width: auto !important;
                        }
                        table select
                        {
                            width: 200px !important;
                        }
                    </style>

                    <div id="saman-row" class="" style="overflow-x:auto;">
                        <table class="table tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('product detail') ?></th>
                                <th width="10%" class="text-center">Marka - Kalite</th>
                                <th width="10%" class="text-center">İstehsalçı Ülke	</th>
                                <th width="20%">Firma</th>
                                <th width="10%">Firma Telefon</th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="5%" class="text-center">Birim</th>
                                <th width="15%" class="text-center">Birim Fiyatı</th>
                                <th width="15%" class="text-center">EDV</th>
                                <th width="10%" class="text-center">Toplam</th>
                                <th width="10%" class="text-center">Teklif No / Tarih </th>
                                <th width="10%" class="text-center">Nakliye D</th>
                                <th width="10%" class="text-center">Ödeme Şekli.</th>
                                <th width="10%" class="text-center">Ödeme Tarihi </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>


                            </thead>
                            <tbody>
                            <?php $i=0; foreach ($products  as $row)  { ?>
                                <tr>
                                    <td><input type="text" class="form-control" name="product_name[]"
                                               value="<?php echo $row['product_name']?>"><input type="hidden" class="form-control" name="product_id[]"
                                                                                                value="<?php echo $row['product_id']?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="product_detail[]"
                                               value="<?php echo $row['product_detail']?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="marka[]"
                                               placeholder="Marka" value="<?php echo $row['marka'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="ulke[]"
                                               placeholder="Ülke" value="<?php echo $row['ulke'] ?>">
                                    </td>
                                    <td>

                                        <select name="firma[]" class="form-control select-box">
                                            <option>Firma Seçiniz</option>
                                            <?php foreach (all_customer() as $customer)
                                            {
                                                if($row['firma']==$customer->company)
                                                {
                                                    echo "<option selected value='$customer->id'>$customer->company</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$customer->id'>$customer->company</option>";
                                                }

                                            } ?>
                                        </select>


                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="firma_tel[]"
                                               placeholder="Firma Telefonu" value="<?php echo $row['firma_tel']?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-<?php echo $i ?>"
                                               onkeypress="return isNumber(event)" onkeyup="rowTotalSF('<?php echo $i; ?>'), billUpyog()"
                                               autocomplete="off"  value="<?php echo $row['qty']?>"> </td>
                                    <td>
                                        <input type="text" class="form-control" name="unit[]"
                                               value="<?php echo $row['unit']?>">
                                    </td>




                                    <td>
                                        <input type="text" class="form-control req prc"  onkeyup="rowTotalSF(<?php echo $i ?>), billUpyog()" name="product_price[]" id="price-<?php echo $i ?>"
                                               onkeypress="return isNumber(event)" value="<?php echo $row['price'] ?>"
                                               autocomplete="off">
                                        <input type="hidden" name="ref_urun[]" value="0">

                                    </td>

                                    <td>
                                        <select class="form-control" name="kdv_durumu[]">
                                            <?php if($row['kdv_dahil_haric']==0)
                                            {
                                                echo '<option selected value="0">Hariç</option>
                                                    <option value="1">Dahil</option>';
                                            } else
                                            {
                                                echo '<option  value="0">Hariç</option>
                                                    <option selected value="1">Dahil</option>';
                                            }
                                            ?>

                                        </select>
                                    </td>

                                    <td>
                                        <input type="text" class="form-control product_tutar" name="product_tutar[]"
                                               onkeypress="return isNumber(event)" id="product_tutar-<?php echo $i ?>" onkeyup="rowTotalSF(<?php echo $i ?>), billUpyog()"  value="<?php echo $row['subtotal'] ?>"
                                               autocomplete="off">

                                    </td>
                                    <td>
                                        <input type="text" class="form-control teklif_tarih_no" value="<?php echo $row['teklif_tarih_no'] ?>" name="teklif_tarih_no[]" id="teklif_tarih_no-0">

                                    </td>
                                    <td>
                                        <input type="text" class="form-control odeme_sekli" value="<?php echo $row['odeme_sekli'] ?>" name=odeme_sekli[]" id="odeme_sekli-0">

                                    </td>
                                    <td>
                                        <select class="form-control method" id="method-0" name="method[]">
                                            <?php if($row['method']==3){
                                                ?>
                                                <option selected value="3">Banka</option>
                                                <option value="1">Nakit</option>

                                                <?php
                                            }
                                            elseif($row['method']==1) {
                                                ?>
                                                <option  value="3">Banka</option>
                                                <option selected value="1">Nakit</option>

                                                <?php
                                            } else {
                                                ?>
                                                <option  value="3">Banka</option>
                                                <option  value="1">Nakit</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control odeme_tarihi" value="<?php echo $row['odeme_tarihi']?>" name="odeme_tarihi[]" id="odeme_tarihi-0">

                                    </td>


                                    <td class="text-center"><button type="button" data-rowid="1" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button> </td>
                                </tr>

                                <?php $i++; } ?>


                            <!--tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align" id="addproduct_talep">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr-->



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
                    <input type="hidden" value="<?php echo $invoice['id'] ?>" name="tip_id" id="tip_id">
                    <input type="hidden" value="requested/edit_action_satinalma" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
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
        var data = ` <tr>
                                <td><input type="text" class="form-control" name="product_name[]" placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]"
                                           placeholder="<?php echo $this->lang->line('product detail') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="marka[]"
                                           placeholder="marka">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="ulke[]"
                                           placeholder="ulke">
                                </td>
                                <td>
                                    <select name="firma[]" class="form-control select-box">
                                       <option>Firma Seçiniz</option>
                                       <?php foreach (all_customer() as $customer)
        {
            echo "<option value='$customer->company'>$customer->company</option>";
        } ?>
                                                                   </select>
                                           <input type="hidden" name="firma_id[]" value="0">

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

                                           <input type="hidden" name="ref_urun[]" value="0">


                                </td>

                                <td>
                                   <select class="form-control" name="kdv_durumu[]">
                                       <option value="0">Hariç</option>
                                       <option value="1">Dahil</option>
                                   </select>
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
                                    <select class="form-control method" id="method-`+cvalue+`" name="method[]">
                                          <option value="3">Banka</option>
                                        <option value="1">Nakit</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control odeme_tarihi" name="odeme_tarihi[]" id="odeme_tarihi-`+cvalue+`">
                                </td>


                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);

        $('.select-box').select2();


        disc_degis($('#discount_rate').val());

        row = cvalue;



    });

    var rowTotalSF = function (numb) {


        var amountVal = formInputGet("#amount", numb);

        var birim_1 = $("#price-"+numb).val();


        // var tax=  $("#tax-"+numb).val();

        var total =birim_1*amountVal;
        //var deger=total*(1+(tax/100))


        $("#product_tutar-"+numb).val(total.toFixed(2));
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
