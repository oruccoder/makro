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

                                <div class="col-sm-2">
                                    <label class="col-form-label"
                                           for="name"><?php echo $this->lang->line('talep no') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Proje  No #"
                                               class="form-control margin-bottom  required"  name="talep_no"
                                             >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                <label class="col-form-label"
                                      ><?php echo $this->lang->line('proje name') ?></label>

                                <div class="input-group">
                                    <input type="text" placeholder="Proje Adı"
                                           class="form-control margin-bottom editdate" name="proje_name" autocomplete="false"
                                          >
                                </div>
                            </div>

                                <div class="col-md-1">
                                <label class="col-form-label"
                                       for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                <div class="input-group">
                                   <input type="text" class="form-control round required" id="tsn_due"
                                                       name="olusturma_tarihi"
                                                       placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                                <div class="col-sm-1">
                                    <label class="col-form-label"
                                           for="name"><?php echo $this->lang->line('approval date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control round required" id="tsn_due"
                                                           name="onay_tarihi"
                                                           placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                        <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('talep_eden_muesese') ?></label>
                                        <select class="form-control round" name="talep_eden_pers_id">

                                            <?php foreach (personel_list() as $emp){
                                                $emp_id=$emp['id'];
                                                $name=$emp['name'];
                                                ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                                <div class="col-sm-2">

                                        <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('satinalma_pazarlama') ?></label>
                                    <select class="form-control round" name="satinalma_pers_id">

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
                                    <select class="form-control round" name="genel_mudur_id">

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
                         <div class="col-sm-12">
                            <div class="form-group row">

                                <div class="col-sm-6 hidden">
                                    <label for="taxformat"
                                           class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                    <select class="form-control round"
                                            onchange="changeTaxFormat(this.value)"
                                            id="taxformat">

                                        <?php echo $taxlist; ?>
                                    </select>
                                </div>

                                 <div class="col-md-2">
                                <label class="col-form-label"
                                      ><?php echo $this->lang->line('email') ?></label>

                                <div class="input-group">
                                    <input type="email" placeholder="email"
                                           class="form-control margin-bottom editdate" name="email" autocomplete="false"
                                          >
                                </div>
                            </div>



                            <div class="col-md-2">
                                <label class="col-form-label"
                                       for="birthday"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="input-group">
                                    <input type="text" placeholder="Telefon numarası"
                                           class="form-control margin-bottom editdate" name="tel" autocomplete="false"
                                          >
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('Description') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="description"
                                               class="form-control margin-bottom editdate" name="description" autocomplete="false"
                                        >
                                    </div>
                                </div>
                            <div class="col-md-2">

                                        <label for="discountFormat"
                                               class="col-form-label"><?php echo $this->lang->line('Discount') ?></label>
                                    <div class="input-group">
                                        <select class="form-control round"
                                                id="discount_format" name="discount_format">

                                            <?php echo " <option  value='%'>Yüzde (%)</option>
                                                       <option selected value='flat'>Sabit</option>";
                                            ?>

                                        </select>
                                </div>
                            </div>
                                <div class="col-md-2">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="col-form-label"><?php echo $this->lang->line('Discount') ?></label>
                                        <input type="text" class="form-control" placeholder="İndirim" onkeyup="disc_degis(this.value)" name="discount_rate" id="discount_rate"
                                        >
                                    </div>
                                </div>
                            </div>


                            </div>
                         </div>

                    <div id="saman-row" class="col-sm-12">
                        <table class="table-responsive tfr my_stripe">
                                <thead>
                                    <tr class="item_header bg-gradient-directional-blue white">
                                        <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                        <th width="15%" class="text-center"><?php echo $this->lang->line('Measurement Unit') ?></th>
                                         <th width="15%" class="text-center"><?php echo $this->lang->line('product detail') ?></th><th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                        <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                        <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                        <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                        <th width="10%" class="text-center"><?php echo $this->lang->line('Amount') ?></th>
                                        <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                    </tr>


                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" name="product_name[]"
                                                   placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="unit[]"
                                                   placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                        </td>
                                         <td>
                                            <input type="text" class="form-control" name="product_detail[]"
                                                   placeholder="<?php echo $this->lang->line('product detail') ?>">
                                        </td>
                                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                                   autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                                   autocomplete="off"></td>
                                        <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                                   autocomplete="off"></td>
                                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                                   onkeypress="return isNumber(event)" id="discount-0"
                                                   onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                        <td>
                                            <strong><span class='ttlText' id="result-0">0</span><span class="currenty"> AZN</span></strong>
                                            <span class="currenty"> <?= currency($this->aauth->get_user()->loc); ?></span>
                                        </td>
                                        <td class="text-center">

                                        </td>
                                        <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                        <input type="hidden" name="disca[]" id="disca-0" value="0">
                                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                                        <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                        <input type="hidden" name="hsn[]" id="hsn-0" value="">
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
                                        <td colspan="7" align="right">
                                            <input type="hidden" value="0" id="subtotal"  name="subtotal">
                                            <strong><?php echo $this->lang->line('Sub Total') ?></strong>
                                        </td>
                                        <td align="left" colspan="2"><span
                                                    class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                            <span id="subtotalr" class="lightMode">0</span></td>
                                    </tr>

                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="7" align="right">
                                            <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                        <td align="left" colspan="2"><span
                                                    class="currenty lightMode"><?php echo $this->config->item('currency');
                                                if (isset($_GET['project'])) {
                                                    echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                                } ?></span>
                                            <span id="discs" class="lightMode">0</span></td>
                                    </tr>


                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="7" align="right">
                                            <strong><?php echo $this->lang->line('Net Total') ?></strong></td>
                                        <td align="left" colspan="2"><span
                                                    class="currenty lightMode"><?php echo $this->config->item('currency');
                                                if (isset($_GET['project'])) {
                                                    echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                                } ?></span>
                                            <input type="hidden" id="nettotalinp" name="nettotalinp">
                                            <span id="nettotal" class="lightMode">0</span></td>
                                    </tr>

                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="7" align="right">
                                            <input type="hidden" value="0" id="subttlform"  name="subtotal">
                                            <strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                        </td>
                                        <td align="left" colspan="2"><span
                                                    class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                            <span id="taxr" class="lightMode">0</span></td>
                                    </tr>


                                    <tr class="sub_c hidden">
                                        <td colspan="7" align="right">
                                            <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                                        <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                            onkeypress="return isNumber(event)"
                                                                            placeholder="Value"
                                                                            name="shipping" autocomplete="off"
                                                                            onkeyup="billUpyog()"> ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency');?> <span id="ship_final">0</span> )</td>
                                    </tr>

                                    <tr class="sub_c" style="display: table-row;">
                                       <td class="hidden" colspan="2"><?php if ($exchange['active'] == 1){
                                            echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                            <select name="mcurrency"
                                                    class="selectpicker form-control">
                                                <option value="0">Default</option>
                                                <?php foreach ($currency as $row) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                                } ?>

                                            </select><?php } ?></td>

                                        <td colspan="7" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                                                (<span
                                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                        </td>
                                        <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                            id="invoiceyoghtml" readonly="">

                                        </td>
                                         <td class="hidden" colspan="2"><?php echo $this->lang->line('Payment Terms') ?> <select name="pterms"
                                       class="selectpicker form-control"><?php foreach ($terms as $row) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                } ?>

                                            </select></td>
                                    </tr>
                                    <tr class="sub_c" style="display: table-row;">
                                       <input type="hidden" name="tip"  value="">

                                        <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn btn-lg"
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
                    <input type="hidden" value="requested/action" id="action-url">
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
        var data = '<tr><td><input type="text" class="form-control" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" autofocus></td>' +
            '<td><input  class="form-control" placeholder="Ölçü Birimi"  name="unit[]" id="unit-' + cvalue + '"></td>' +
            '<td><input type="text" class="form-control" placeholder="Ürün Bilgileri" name="product_detail[]"></td>'+
            '<td><input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), ' +
            'billUpyog()" autocomplete="off"' +
            ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> ' +
            '<td><input type="text" ' +
            'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
            ' name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
            'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currencys +'</span> ' +
            '</strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            '</tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);

        disc_degis($('#discount_rate').val());

        row = cvalue;



    });
</script>
