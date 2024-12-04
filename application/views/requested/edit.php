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


                                <div class="col-md-2">
                                    <label class="col-form-label"
                                    ><?php echo $this->lang->line('proje name') ?></label>

                                    <div class="input-group">

                                        <input type="text" class="form-control " name="proje_name" id="proje_name"
                                               placeholder="Proje"  value="<?php echo $invoice['proje_name'] ?>"
                                               autocomplete="off"/>

                                        <div id="customer-box-result"></div>

                                        <input type="hidden" name="proje_id" id="proje_id"  value="<?php echo $invoice['proje_id'] ?>">

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="col-form-label">Proje Bölümü</label>

                                    <div class="input-group">
                                        <select class="form-control required" id="proje_bolum_id" name="proje_bolum_id">
                                            <option selected value="<?php echo $invoice['proje_bolum_id']; ?>"><?php echo $invoice['proje_bolum_name']; ?></option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-1">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control required editdate" id="tsn_due"
                                               name="olusturma_tarihi"
                                               placeholder="Due Date"  value="<?php echo dateformat($invoice['olusturma_tarihi']) ?>"  autocomplete="false">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('talep_eden_muesese') ?></label>
                                    <select class="form-control Tarihi" name="talep_eden_pers_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['talep_eden_pers_id'])
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
                                <div class="col-sm-1">

                                    <label for="taxformat" class="col-form-label">Proje Sorumlusu</label>
                                    <select class="form-control proje_sorumlusu_id" name="proje_sorumlusu_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            if($emp_id==$invoice['proje_sorumlusu_id'])
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
                                    <select class="form-control proje_muduru_id" name="proje_muduru_id">

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
                                    <select class="form-control Tarihi" name="genel_mudur_id">

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

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group row">

                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label">Bölüm Müdürü</label>
                                    <select class="form-control bolum_mudur_id" name="bolum_mudur_id">

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


                                <div class="col-md-1">
                                    <label class="col-form-label"
                                    ><?php echo $this->lang->line('email') ?></label>

                                    <div class="input-group">
                                        <input type="email" placeholder="email"
                                               class="form-control margin-bottom " value="<?php echo $invoice['email'] ?>" name="email" autocomplete="false"
                                        >
                                    </div>
                                </div>



                                <div class="col-md-1">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('Phone') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Telefon numarası"
                                               class="form-control margin-bottom editdate" value="<?php echo $invoice['tel'] ?>" name="tel" autocomplete="false"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('Description') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="description"
                                               class="form-control margin-bottom editdate" value="<?php echo $invoice['description'] ?>" name="description" autocomplete="false"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday">Gönderme Şekli</label>

                                    <div class="input-group">
                                        <input type="text" placeholder="description"
                                               class="form-control margin-bottom editdate" name="gonderme_sekli" value="<?php echo $invoice['gonderme_sekli'] ?>" autocomplete="false"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">

                                    <label for="discountFormat"
                                           class="col-form-label"><?php echo $this->lang->line('Discount') ?></label>
                                    <div class="input-group">
                                        <select class="form-control Tarihi"
                                                id="discount_format" name="discount_format">

                                            <?php echo " <option  value='%'>Yüzde (%)</option>
                                                       <option selected value='flat'>Sabit</option>";
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="col-form-label"><?php echo $this->lang->line('Discount') ?></label>
                                        <input type="text" class="form-control" placeholder="İndirim" onkeyup="disc_degis(this.value)" name="discount_rate" id="discount_rate"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-1">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="col-form-label">Proje Stokları</label>

                                        <input type="checkbox" id="stok_durumu" name="stok_durumu" class="form-control" >
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div id="saman-row" class="col-sm-12">
                        <table class="table-responsive tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="15%" class="text-center proje_hid"><?php echo $this->lang->line('proje_yerleri') ?></th>
                                <th width="15%" class="text-center proje_hid">Bağlı Olduğu Aşama</th>
                                <th width="15%" class="text-center proje_hid"><?php echo $this->lang->line('Milestones Title') ?></th>
                                <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('Measurement Unit') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('product detail') ?></th>

                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <!--th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Amount') ?></th-->
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>


                            </thead>
                            <tbody>

                            <?php $i = 0;
                            foreach ($products as $row) {
                                echo '<tr>
                                <td class="proje_hid">
                                    <input type="text" value="'.bolum_getir($row['bolum_id']).'" class="form-control text-center bolum" name="bolum[]" id="bolum-' . $i . '">
                                    <input type="hidden" name="bolum_id[]" id="bolum_id_val-' . $i . '" value="'.$row['bolum_id'].'">
                                </td>
                                <td class="proje_hid">
                                <input type="text" value="'.task_to_asama($row['bagli_oldugu_asama_id']).'" class="form-control text-center bagli_oldugu_asama" name="bagli_oldugu_asama[]"  id="bagli_oldugu_asama-' . $i . '" >
                                    <input type="hidden" name="bagli_oldugu_asama_id_val[]" id="bagli_oldugu_asama_id_val-' . $i . '">
                                </td>
                                <td class="proje_hid"><input type="text" value="'.task_to_asama($row['asama_id']).'"  class="form-control text-center asama" name="asama[]"  id="asama-' . $i . '">
                                    <input type="hidden" name="asama_id[]" id="asama_id_val-' . $i . '">
                                </td>

                                <td><input type="text" class="form-control product_name" readonly name="product_name[]" id="product_name-' . $i . '"
                                         value="'.$row['product_name'].'"  >
                                </td>
                                <td>
                                    <input type="text" class="form-control" readonly id="unit-' . $i . '"  name="unit[]" value="'.$row['unit'].'" >
                                </td>
                                <td>
                                    <input type="text" class="form-control" readonly name="product_detail[]" value="'.$row['product_detail'].'" >
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]"  id="amount-' . $i . '"
                                value="'.$row['qty'].'" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                           autocomplete="off"></td>

                                <td class="text-center">
                            <button type="button" data-rowid="'.$i.'" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button>
                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . $row['totaltax'] . '">
                                <input type="hidden" name="disca[]"  id="disca-' . $i . '" value="' . $row['totaldiscount'] . '">
                                <input type="hidden" class="pdIn" name="pid[]"  id="pid-' . $i . '" value="' . $row['product_id'] . '">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . $row['subtotal'] . '">
                            </tr>';
                                $i++;
                            } ?>

                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align" id="addproduct_talep">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>




                            <input type="hidden" name="tip"  value="">

                            <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn btn-lg"
                                                                 value="Talep Güncelle"
                                                                 id="submit-data" data-loading-text="Creating...">

                            </td>

                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="<?php echo $invoice['id'] ?>" name="tip_id" id="tip_id">
                    <input type="hidden" value="AZN" id="para_birimi">
                    <input type="hidden" value="<?php echo $this->aauth->get_user()->loc ?>" id="loc_id">
                    <input type="hidden" value="requested/editaction" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="<?php echo $i ; ?>" name="counter" id="ganak">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?=$this->common->taxhandle_edit('yes') ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?=$taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
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
        if( deger!=0 || deger!="")
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

        $("#proje_bolum_id option").remove();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: baseurl + 'projects/proje_bolum_ajax',
            data: 'pid='+cid+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {


                $('#proje_bolum_id').append($('<option>').val('').text('Seçiniz'));

                jQuery.each((data), function (key, item) {
                    $("#proje_bolum_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                });

            }
        });


    }

    $(function () {

        // disc_degis($('#discount_rate').val());

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

        var data='';

        var durum=$("#stok_durumu").prop('checked')
        if(durum==false)
        {
            data = '<tr>' +
                '<td><input type="text" class="form-control product_name" id="product_name-'+cvalue+'" name="product_name[]" ' +
                'placeholder="Ürün Adını veya Kodunu Giriniz" autofocus></td>' +
                '<td><input  class="form-control unit" placeholder="Ölçü Birimi"  name="unit[]" id="unit-' + cvalue + '"></td>' +
                '<td><input type="text" class="form-control" placeholder="Ürün Bilgileri" name="product_detail[]"></td>'+
                '<td><input type="text" class="form-control req amnt" name="product_qty[]" ' +
                'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), ' +
                'billUpyog()" autocomplete="off"' +
                ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> ' +
                '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
                '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
                'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
                '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
                '</tr>';
        }
        else
        {
            data = '<tr>' +
                '<td class="proje_hid"><input type="text" class="form-control text-center bolum" name="bolum[]"'+
                'placeholder="<?php echo $this->lang->line('proje_yerleri') ?>" id="bolum-' + cvalue + '">   <input type="hidden" name="bolum_id[]" id="bolum_id_val-' + cvalue + '" class="bolum_id"> </td>'+
                '<td class="proje_hid"><input type="text" class="form-control text-center asama" name="bagli_oldugu_asama[]"  id="bagli_oldugu_asama-' + cvalue + '"'+
                'placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >'+
                '<input type="hidden" name="bagli_oldugu_asama_id_val[]" id="bagli_oldugu_asama_id_val-' + cvalue + '">'+
                '</td>'+
                '<td class="proje_hid"><input type="text" class="form-control text-center asama" name="asama[]"'+
                'placeholder="<?php echo $this->lang->line('Milestones Title') ?>" id="asama-' + cvalue + '">  <input type="hidden" name="asama_id[]" id="asama_id_val-' + cvalue + '"> </td>'+

                '<td><input type="text" class="form-control product_name" id="product_name-'+cvalue+'" name="product_name[]" ' +
                'placeholder="Ürün Adını veya Kodunu Giriniz" autofocus></td>' +
                '<td><input  class="form-control unit" placeholder="Ölçü Birimi"  name="unit[]" id="unit-' + cvalue + '"></td>' +
                '<td><input type="text" class="form-control" placeholder="Ürün Bilgileri" name="product_detail[]"></td>'+
                '<td><input type="text" class="form-control req amnt" name="product_qty[]" ' +
                'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), ' +
                'billUpyog()" autocomplete="off"' +
                ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> ' +
                '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
                '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
                'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
                '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
                '</tr>';
        }




        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);

        disc_degis($('#discount_rate').val());

        row = cvalue;

        $('#bolum-' + cvalue).autocomplete({
            source: function (request, response) {
                $('#bagli_oldugu_asama-'+ cvalue).val('');
                $('#asama-'+ cvalue).val('');
                $('#bagli_oldugu_asama_id_val-'+ cvalue).val(0);
                $('#asama_id_val-'+ cvalue).val(0);
                $('#product_name-'+ cvalue).val('');
                var proje_id=$('#proje_id').val()
                $.ajax({
                    url: baseurl + 'search_products/proje_bolumleri',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var bolum_id = item[0];
                            return {
                                label: bolum_id,
                                value: bolum_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var bolum_id=ui.item.data[1];
                $('#bolum_id_val-'+cvalue).val(bolum_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('#asama-' + cvalue).autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-'+cvalue).val()
                $.ajax({
                    url: baseurl + 'search_products/proje_asamalari',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+'&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&name_startsWith=' + request.term + '&bolum_id=' + bolum_id,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var asama_id = item[0];
                            return {
                                label: asama_id,
                                value: asama_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var asama_id=ui.item.data[1];
                $('#asama_id_val-'+cvalue).val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });
        $('#bagli_oldugu_asama-' + cvalue).autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-' + cvalue).val()
                $.ajax({
                    url: baseurl + 'search_products/bagli_proje_asamalari',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term + '&bolum_id=' + bolum_id,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var asama_id = item[0];
                            return {
                                label: asama_id,
                                value: asama_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var asama_id=ui.item.data[1];
                $('#bagli_oldugu_asama_id_val-' + cvalue).val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        var selectedProducts = [];
        $('#product_name-' + cvalue).autocomplete({
            source: function (request, response) {

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                var asama_id=$('#asama_id_val-'+cvalue).val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-'+cvalue).val();
                let prj_st = $("#stok_durumu").is(":checked")?1:0
                url=''

                var durum=$("#stok_durumu").prop('checked')

                if(durum==false)
                {
                    url="search_products/malzeme_talep_search_stok";
                }
                else
                {


                    url="search_products/malzeme_talep_search";
                }

                $.ajax({
                    url: baseurl + url,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&prj_st=' + prj_st+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&' + d_csrf,
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
                id = 0;
                var discount = ui.item.data[4];
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];
                var qty=ui.item.data[8];
                var unit_id=ui.item.data[9];
                $('.pdIn').each(function(index,item){
                    selectedProducts.push($(item).val());
                })

                console.log(selectedProducts);
                var check = selectedProducts.filter(function(item){
                    return item === pid;
                })

                if(check.length > 0){
                    $('.pdIn[value="'+check[0]+'"]').focus().css('border-color','red');
                    event.target.value = ' ';
                    event.target.className += ' is-invalid';
                    event.preventDefault();
                } else {

                    $('#amount-' + cvalue).val(1);
                    $('#qiymet-' + cvalue).val(price);
                    $('#product_qty-' + cvalue).val(qty);
                    $('#pid-' + cvalue).val(pid);
                    $('#discount-' + cvalue).val(discount);
                    $('#dpid-' + cvalue).val(dpid);
                    $('#unit-' + cvalue).val(unit_id);
                    $('#hsn-' + cvalue).val(hsn);
                    $('#alert-' + cvalue).val(alert);
                    $('#unit_id-' + cvalue).val(unit_id);
                    billUpyog();
                }


            },
            change: function (event, ui) {
                if (!ui.item) {
                    this.value = ''
                    $('#pid-'+cvalue).val(0)

                }
                else{
                    // return your label here
                }
            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });



    });

    $(function () {

        var cvalue=0;
        var row=0;
        $('.bolum').autocomplete({
            source: function (request, response) {

                var id=$(this)[0].bindings[0].id;
                cvalue = id.split("-")[1];

                $('#bagli_oldugu_asama-'+ cvalue).val('');
                $('#asama-'+ cvalue).val('');
                $('#bagli_oldugu_asama_id_val-'+ cvalue).val(0);
                $('#asama_id_val-'+ cvalue).val(0);
                $('#product_name-'+ cvalue).val('');

                var proje_id=$('#proje_id').val()
                $.ajax({
                    url: baseurl + 'search_products/proje_bolumleri',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var bolum_id = item[0];
                            return {
                                label: bolum_id,
                                value: bolum_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var bolum_id=ui.item.data[1];
                $('#bolum_id_val-'+cvalue).val(bolum_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });
        $('.bagli_oldugu_asama').autocomplete({
            source: function (request, response) {

                var id=$(this)[0].bindings[0].id;
                cvalue = id.split("-")[1];

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-' + cvalue).val()
                $.ajax({
                    url: baseurl + 'search_products/bagli_proje_asamalari',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term + '&bolum_id=' + bolum_id,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var asama_id = item[0];
                            return {
                                label: asama_id,
                                value: asama_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var asama_id=ui.item.data[1];
                $('#bagli_oldugu_asama_id_val-' + cvalue).val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('.asama').autocomplete({
            source: function (request, response) {
                var id=$(this)[0].bindings[0].id;
                cvalue = id.split("-")[1];

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-'+cvalue).val()
                $.ajax({
                    url: baseurl + 'search_products/proje_asamalari',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+'&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&name_startsWith=' + request.term + '&bolum_id=' + bolum_id,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var asama_id = item[0];
                            return {
                                label: asama_id,
                                value: asama_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var asama_id=ui.item.data[1];
                $('#asama_id_val-'+cvalue).val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });
        var selectedProducts = [];
        $('.product_name').autocomplete({
            source: function (request, response) {
                var id=$(this)[0].bindings[0].id;
                var cvalue = id.split("-")[1];
                var row = id.split("-")[1];

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                var asama_id=$('#asama_id_val-'+cvalue).val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-'+cvalue).val()
                let prj_st = $("#stok_durumu").is(":checked")?1:0

                $.ajax({
                    url: baseurl + 'search_products/malzeme_talep_search',
                    dataType: "json",
                    method: 'post',
                    data: '&proje_id=' + proje_id+ '&prj_st=' + prj_st+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&' + d_csrf,
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
                id = 0;
                var discount = ui.item.data[4];
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];
                var qty=ui.item.data[8];
                var unit_id=ui.item.data[9];
                $('.pdIn').each(function(index,item){
                    selectedProducts.push($(item).val());
                })
                console.log(selectedProducts);
                var check = selectedProducts.filter(function(item){
                    return item === pid;
                })

                if(check.length > 0){
                    $('.pdIn[value="'+check[0]+'"]').focus().css('border-color','red');
                    event.target.value = ' ';
                    event.target.className += ' is-invalid';
                    event.preventDefault();
                } else {

                    $('#amount-0').val(1);
                    $('#qiymet-0').val(price);
                    $('#product_qty-0').val(qty);
                    $('#pid-' + cvalue).val(pid);
                    $('#discount-0').val(discount);
                    $('#dpid-0').val(dpid);
                    $('#unit-' + cvalue).val(unit_id);
                    $('#hsn-0').val(hsn);
                    $('#alert-0').val(alert);
                    $('#unit_id-0').val(unit_id);
                    billUpyog();
                }


            },
            change: function (event, ui) {
                if (!ui.item) {
                    $('#pid-'+cvalue).val(0)
                    this.value = '';}
                else{
                    // return your label here
                }
            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

    })

    $('#stok_durumu').on('change',function () {

        var durum=$("#stok_durumu").prop('checked');
        if(durum==false)
        {
            $('.proje_hid').css('display','none')
        }
        else
        {
            $('.proje_hid').css('display','table-cell')
        }
    });

    window.onload = function () {

        var durum=$("#stok_durumu").prop('checked');
        if(durum==false)
        {
            $('.proje_hid').css('display','none')
        }
        else
        {
            $('.proje_hid').css('display','table-cell')
        }

    };

</script>
