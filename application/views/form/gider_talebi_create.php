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
                                               placeholder="Proje"
                                               autocomplete="off"/>

                                        <div id="customer-box-result"></div>

                                        <input type="hidden" name="proje_id" id="proje_id">

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label">Proje Bölümü</label>

                                    <div class="input-group">
                                        <select class="form-control required" id="proje_bolum_id" name="proje_bolum_id">
                                            <option>Seçiniz</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control Tarihi required" id="tsn_due"
                                               name="olusturma_tarihi"
                                               placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>

                                <div class="col-sm-1">

                                    <label for="taxformat" class="col-form-label">Proje Sorumlusu</label>
                                    <select class="form-control select-box proje_sorumlusu_id" name="proje_sorumlusu_id">

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
                                    <select class="form-control select-box proje_muduru_id" name="proje_muduru_id">

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
                                    <select class="form-control select-box bolum_mudur_id" name="bolum_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-1">

                                    <label for="taxformat" class="col-form-label">Finans Müdürü</label>
                                    <select class="form-control select-box finans_mudur_id" name="finans_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <label class="col-form-label"
                                           for="birthday">STOK</label>

                                    <div class="input-group">
                                        <input type="checkbox"
                                               class="form-control margin-bottom " name="stok_cost" autocomplete="false"
                                        >
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group row">

                                <div class="col-sm-6 hidden">
                                    <label for="taxformat"
                                           class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                    <select class="form-control Tarihi"
                                            onchange="changeTaxFormat(this.value)"
                                            id="taxformat">

                                        <?php echo $taxlist; ?>
                                    </select>
                                </div>




                                <div class="col-sm-2">

                                    <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('genel_mudur') ?></label>
                                    <select class="form-control select-box Tarihi" name="genel_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];
                                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-1">
                                    <label for="taxformat" class="col-form-label">Ödeme Türü<span style="color: red">*</span></label>
                                    <select class="form-control required"  id="method" name="method">
                                        <option value="">Seçiniz</option>
                                        <option value="1">Nakit</option>
                                        <option value="3">Banka</option>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <label for="taxformat" class="col-form-label">Cari/Personel<span style="color: red">*</span></label>
                                    <select class="form-control required"  id="cari_pers" name="cari_pers">
                                        <option value="">Seçiniz</option>
                                        <option value="1">Personel</option>
                                        <option value="2">Cari</option>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxformat" class="col-form-label"><?php echo $this->lang->line('talep_eden_muesese') ?><span style="color: red">*</span></label>
                                    <select class="form-control Tarihi select-box required" name="talep_eden_pers_id"  id="talep_eden_pers_id">
                                        <option value="">Cari veya Personel Seçiniz</option>
                                    </select>
                                </div>

                                <div class="col-sm-2 invoice">
                                    <label for="taxformat" class="col-form-label">Faturalar</label>
                                    <select class="form-control Tarihi select-box" name="invoice" id="invoice">
                                        <option>Cari veya Personel Seçiniz</option>
                                    </select>
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
                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('Description') ?></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="description"
                                               class="form-control margin-bottom editdate" name="description" autocomplete="false">
                                    </div>
                                </div>
                                <div class="col-md-1 hidden">
                                    <label class="col-form-label"
                                           for="birthday">Bölüm Adı</label>

                                    <div class="input-group">
                                        <input type="text" placeholder="Bölüm Adı"
                                               class="form-control margin-bottom " name="bolum_adi" autocomplete="false">
                                    </div>
                                </div>



                            </div>


                        </div>
                    </div>

                    <div id="saman-row" >
                        <table class="table-responsive tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">



                                <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('Measurement Unit') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('product detail') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                <!--th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th-->
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Amount') ?></th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>


                            </thead>
                            <tbody>
                            <tr>

                                <td><input type="text" class="form-control product_name" name="product_name[]" id="product_name-0"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control unit" id="unit-0"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                    <input type="hidden" name="unit[]" id="unit_id-0">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="product_detail[]"
                                           placeholder="<?php echo $this->lang->line('product detail') ?>">
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal_gider('0'), billUpyog_gider()"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>


                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal_gider('0'), billUpyog_gider()"
                                           autocomplete="off"></td>
                                <!--td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal_gider('0'), billUpyog_gider()"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal_gider('0'), billUpyog_gider()" autocomplete="off"></td-->

                                <td>
                                    <input type="hidden" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal_gider('0'), billUpyog_gider()"
                                           autocomplete="off"
                                    <input type="hidden" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal_gider('0'), billUpyog_gider()" autocomplete="off">
                                    <strong><span class='ttlText' id="result-0">0</span><span class="currenty"> AZN</span></strong>
                                    <span class="currenty"> <?= currency($this->aauth->get_user()->loc); ?></span>
                                </td>
                                <td class="text-center">

                                </td>

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
                                <td colspan="5"></td>
                            </tr>
                            <input type="hidden" value="0" id="subtotal"  name="subtotal">
                            <input type="hidden" value="0" id="total"  name="total">


                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="5" align="right">
                                    <input type="hidden" value="0" id="subtotal"  name="subtotal">
                                    <strong><?php echo $this->lang->line('Sub Total') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                    <span id="subtotalr" class="lightMode">0</span></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="5" align="right">
                                    <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency');
                                        if (isset($_GET['project'])) {
                                            echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                        } ?></span>
                                    <span id="discs" class="lightMode">0</span></td>
                            </tr>


                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="5" align="right">
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
                                <td colspan="5" align="right">
                                    <input type="hidden" value="0" id="subttlform"  name="subtotal">
                                    <strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                    <span id="taxr" class="lightMode">0</span></td>
                            </tr>


                            <tr class="sub_c hidden">
                                <td colspan="5" align="right">
                                    <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                    onkeypress="return isNumber(event)"
                                                                    placeholder="Value"
                                                                    name="shipping" autocomplete="off"
                                                                    onkeyup="billUpyog_gider()"> ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency');?> <span id="ship_final">0</span> )</td>
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

                                <td colspan="5" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
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
                    <input type="hidden" value="form/action_gider" id="action-url">
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
                    <input type="hidden" value="-1" id="invoice_type">

                </form>
            </div>
        </div>
    </div>
</div>

<script>








    $('#invoice_type').on('change',function () {
        $('#customer-box').prop('disabled',false);
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

        var data='';


        data = '<tr>' +
            '<td><input type="text" class="form-control product_name" id="product_name-'+cvalue+'" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" autofocus></td>' +
            '<td> <input type="hidden" name="unit[]" id="unit_id-' + cvalue + '"><input  class="form-control unit" placeholder="Ölçü Birimi"  id="unit-' + cvalue + '"></td>' +
            '<td><input type="text" class="form-control" placeholder="Ürün Bilgileri" name="product_detail[]"></td>'+
            '<td><input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal_gider(' + functionNum + '), ' +
            'billUpyog_gider()" autocomplete="off"' +
            ' value="1" >' +'</td><td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '"'+
            'onkeypress="return isNumber(event)" onkeyup="rowTotal_gider(' + cvalue + '), billUpyog_gider()"</td><td>'+
            ' <input type="hidden" class="form-control vat " name="product_tax[]" id="vat-' + cvalue + '"'+
            'onkeypress="return isNumber(event)" onkeyup="rowTotal_gider(' + cvalue + '), billUpyog_gider()" autocomplete="off"'+
            '<input type="hidden" class="form-control discount" name="product_discount[]" id="discount-' + cvalue + '"'+
            '<strong><span class="ttlText" id="result-' + cvalue + '">0</span><span class="currenty"> AZN</span></strong>'+
            '<span class="currenty"> <?= currency($this->aauth->get_user()->loc); ?></span></td>'+
            '<input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> ' +
            '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
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





        $('#product_name-' + cvalue).autocomplete({
            source: function (request, response) {

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                var asama_id=$('#asama_id_val-'+cvalue).val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-'+cvalue).val();
                url=''

                url="search_products/search";

                $.ajax({
                    url: baseurl + url,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&' + d_csrf,
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


                $('#qiymet-0').val(price);
                $('#product_qty-0').val(qty);
                $('#pid-'+cvalue).val(pid);
                $('#discount-0').val(discount);
                $('#dpid-0').val(dpid);
                $('#unit-'+cvalue).val(unit_id);
                $('#hsn-0').val(hsn);
                $('#alert-0').val(alert);
                $('#unit_id-'+cvalue).val(unit);
                billUpyog_gider();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });



    });

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


    $(document).on('change', "#cari_pers", function (e) {
        $("#talep_eden_pers_id option").remove();
        var cari_pers = $(this).val();
        $.ajax({
            type: "POST",
            url: baseurl + 'form/cari_pers_list',
            data:'cari_pers='+cari_pers+'&'+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#talep_eden_pers_id').append($('<option>').val(0).text('Seçiniz'));

                    if(cari_pers==2)
                    {
                        $('.invoice').css('display','grid')
                    }
                    else
                    {
                        $('.invoice').css('display','none')
                    }
                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#talep_eden_pers_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });

    $(document).on('change', "#talep_eden_pers_id", function (e) {
        $("#invoice option").remove();
        var cari_pers = $(this).val();
        $.ajax({
            type: "POST",
            url: baseurl + 'form/cari_pers_list_invoice',
            data:'cari_id='+cari_pers+'&'+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#invoice').append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#invoice").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

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

        // $.ajax({
        //     type: "POST",
        //     dataType: "json",
        //     url: baseurl + 'search_products/proje_bilgileri',
        //     data: 'proje_id=' +cid,
        //     success: function (data) {
        //         $('.proje_sorumlusu_id').val(data.proje_sorumlusu_id);
        //         $('.proje_muduru_id').val(data.proje_muduru);
        //         $('.genel_mudur_id').val(data.genel_mudur_id);
        //         $('.bolum_mudur_id').val(data.depo_muduru_id);
        //
        //     }
        // });




    }

    $(document).ready(function () {




        var cvalue = parseInt($('#ganak').val()) + 1;

        row = cvalue;

        var invoice_type = $("#invoice_type").val();

        $('#product_name-0').autocomplete({
            source: function (request, response) {

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-0').val()
                var asama_id=$('#asama_id_val-0').val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-0').val()

                url=''

                url="search_products/search";

                $.ajax({
                    url: baseurl +url,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&' + d_csrf,
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

                $('#amount-0').val(1);
                $('#qiymet-0').val(price);
                $('#product_qty-0').val(qty);
                $('#pid-0').val(pid);
                $('#discount-0').val(discount);
                $('#dpid-0').val(dpid);
                $('#unit-0').val(unit_id);
                $('#hsn-0').val(hsn);
                $('#alert-0').val(alert);
                $('#unit_id-0').val(unit);
                billUpyog_gider();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });



    });


    var rowTotal_gider = function (numb) {



        //most res
        var result;
        var page = '';
        var totalValue;
        var amountVal = formInputGet("#amount", numb);
        var priceVal = formInputGet("#price", numb);
        var discountVal = formInputGet("#discount", numb);
        if (discountVal == '') {
            $("#discount-" + numb).val(0);
            discountVal = 0;
        }
        var vatVal = formInputGet("#vat", numb);
        if (vatVal == '') {
            $("#vat-" + numb).val(0);
            vatVal = 0;
        }
        var taxo = 0;
        var disco = 0;
        var totalPrice = (parseFloat(amountVal).toFixed(4)) * priceVal;
        var tax_status = $("#taxformat option:selected").val();
        var disFormat = $("#discount_format option:selected").val();
        if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
            var alertVal = formInputGet("#alert", numb);
            var invoice_type=$("#invoice_type").val();
            if(invoice_type==1)
            {
                if (+alertVal < +amountVal) {
                    var aqt = +alertVal - +amountVal;
                    alert('Stok Az! ' + aqt);
                }
            }

        }


        totalValue = parseFloat(totalPrice);
        $("#result-" + numb).html(deciFormat(totalValue));

        var totalID = "#total-" + numb;
        $(totalID).val(deciFormat(totalValue));
        samanYogGider();
        SubTotalGider();
    };


    var billUpyog_gider = function () {
        //var totalBillVal = deciFormat(parseFloat(samanYog()) + parseFloat(shipTot()))-coupon();
        var nettotal=$('#nettotalinp').val();

        var totalBillVal = deciFormat(parseFloat(nettotal) + parseFloat(TaxTotal()));
        $("#mahayog").html(totalBillVal);
        $("#subttlform").val(samanYog());
        $("#subttlform2").val(samanYog());
        $("#invoiceyoghtml").val(totalBillVal);
        $("#bigtotal").html(deciFormat(totalBillVal));







    };

    var samanYogGider = function () {

        var itempriceList = [];
        var idList = [];
        var r = 0;
        $('.ttInput').each(function () {
            var vv = $(this).val();
            var vid = $(this).attr('id');
            vid = vid.split("-");
            if (vv === '') {
                vv = 0;
            }

            itempriceList.push(vv);
            idList.push(vid[1]);
            r++;
        });
        var sum = 0;
        var taxc = 0;
        var discs = 0;
        var ganak = parseInt($("#ganak").val()) + 1;

        for (var z = 0; z < idList.length; z++) {
            var x = idList[z];
            if (parseFloat(itempriceList[z]) > 0) {
                sum += parseFloat(itempriceList[z]);
            }
            if (parseFloat($("#taxa-" + x).val()) > 0) {
                taxc += parseFloat($("#taxa-" + x).val());
            }
            if (parseFloat($("#disca-" + x).val()) > 0) {
                discs += parseFloat($("#disca-" + x).val());
            }
        }
        discs = deciFormat(discs);
        taxc = deciFormat(taxc);
        sum = deciFormat(sum);
        $("#discs").html(discs);
        $("#taxr").html(taxc);
        $("#taxr2").val(taxc);



        //kalan kredi hesaplama


        return sum;

    };

    var SubTotalGider = function () {
        var itempriceList = [];
        var idList = [];
        var r = 0;
        $('.ttInput').each(function () {
            var vv = $(this).val();
            var vid = $(this).attr('id');
            vid = vid.split("-");
            if (vv === '') {
                vv = 0;
            }

            itempriceList.push(vv);
            idList.push(vid[1]);
            r++;
        });
        var sum = 0;
        var taxc = 0;
        var discs = 0;
        var subtotal = 0;
        var ganak = parseInt($("#ganak").val()) + 1;

        for (var z = 0; z < idList.length; z++) {
            var x = idList[z];
            if (parseFloat(itempriceList[z]) > 0) {
                sum += parseFloat(itempriceList[z]);
            }
            if (parseFloat($("#taxa-" + x).val()) > 0) {
                taxc += parseFloat($("#taxa-" + x).val());
            }
            if (parseFloat($("#disca-" + x).val()) > 0) {
                discs += parseFloat($("#disca-" + x).val());
            }
        }
        discs = deciFormat(discs);
        taxc = deciFormat(taxc);
        sum = deciFormat(sum);
        subtotal = deciFormat(sum);

        $("#subtotalr").html(subtotal);
        $("#nettotal").html(deciFormat(subtotal-discs));
        $("#nettotalinp").val((subtotal-discs));
        return sum;

    };


</script>
