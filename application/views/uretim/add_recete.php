<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">


                    <div class="message"></div>
                </div>
                <div class="card-body">
                <form method="post" id="data_form">


                        <div class="col-sm-12 cmp-pnl">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                        <div id="customerpanel" class="inner-cmp-pnl">
                                        <div class="form-group row">
                                            <div class="fcol-sm-12">
                                                <h3 class="title">
                                                    Cari Ekle
                                                    <a href='#' class="btn btn-success btn-sm " data-toggle="modal" data-target="#addCustomer">
                                                         <i class="fa fa-plus-square" title="Cari Ekle"></i>
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="frmSearch col-sm-12"><label for="cst"
                                                                                    class="caption"><?php echo $this->lang->line('Search Client'); ?></label>
                                                <input type="text" class="form-control round" name="cst" id="customer-box"
                                                       placeholder="Müşteri Adı veya Telefon Numarası Giriniz"
                                                       autocomplete="off"/>

                                                <div id="customer-box-result"></div>
                                            </div>

                                        </div>

                            </div>
                                </div>
                                <div class="col-sm-6">
                                    <div id="customer">
                                        <div class="clientinfo">
                                            <?php echo $this->lang->line('Client Details'); ?>
                                            <hr>
                                            <input type="hidden" name="customer_id" id="customer_id" value="0">
                                            <div id="customer_name"></div>
                                        </div>
                                        <div class="clientinfo">

                                            <div id="customer_address1"></div>
                                        </div>

                                        <div class="clientinfo">

                                            <div id="customer_phone"></div>
                                        </div>
                                        <div class="clientinfo">

                                            <div id="customer_credit"></div>
                                        </div>
                                        <div class="clientinfo">

                                            <div id="customer_kalan_credit"></div>
                                        </div>
                                        <div class="clientinfo">

                                            <div id="customer_hesaplaan_kalan_credit"></div>
                                        </div>
                                        <hr>
                                        <div id="customer_pass"></div>



                                    </div>
                                </div>
                            </div>

                            <div class="inner-cmp-pnl">


                                <div class="form-group row">

                                    <div class="col-sm-12"><h3
                                            class="title"><?php echo $this->lang->line('Recete Properties') ?></h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="receteno"
                                                                 class="caption"><?php echo $this->lang->line('Recete Number') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Reçete #"
                                                   name="receteno"
                                                   value="">
                                        </div>
                                    </div>


                                    <div class="col-sm-6"><label for="recetedate"
                                                                 class="caption"><?php echo $this->lang->line('recete_name'); ?></label>

                                        <div class="input-group">

                                            <input type="text" class="form-control round required" placeholder="Reçete Adı" id="recete_adi" name="recete_adi" autocomplete="false">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="recetedate"
                                                                 class="caption"><?php echo $this->lang->line('Reçete Date'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   placeholder="Billing Date" name="recetedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="receteno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Referans #"
                                                   name="refer">
                                        </div>
                                    </div>


                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="status" class="caption"><?php echo $this->lang->line('Warehouse') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                            <select name="warehouses" id="warehouses" class="form-control select-box">
                                                <?php

                                                foreach (depolar() as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('Recete Note') ?></label>
                                        <textarea class="form-control round" name="notes" rows="2"></textarea>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('new_uretim_product') ?></label>
                                        <p style="font-size: x-small">Üretilecek Ürünü Seçebilirsiniz. Veya Yeni Ürün Oluşturabilirsiniz.</p>
                                        <input required type="text" class="form-control text-center required" name="productnames2"
                                               placeholder="<?php echo $this->lang->line('new_uretim_product') ?>" id='productnames2'>
                                        <input type="hidden" id="new_prd_id" name="new_prd_id">
                                    </div>
                                </div>


                            </div>
                        </div>



                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">

                            <thead>
                            <tr class="item_header bg-gradient-directional-amber">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('unit') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('fire') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('fire_quantity') ?></th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="product_qty-0"
                                           onkeypress="return isNumber(event)" onkeyup="fire_hesapla('0')"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td><input type="text" class="form-control req unt" name="product_unit[]" id="unit-0"
                                           onkeypress="return isNumber(event)" onkeyup="fire_hesapla('0')"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control fire " name="product_fire[]" id="fire-0"
                                           onkeypress="return isNumber(event)" onkeyup="fire_hesapla('0')"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control fire_quantity" name="product_fire_quantity[]"
                                           onkeypress="return isNumber(event)" id="fire_quantity-0"
                                           onkeyup="fire_hesapla('0')" autocomplete="off"></td>

                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                <input type="hidden" name="hsn[]" id="hsn-0" value="">
                            </tr>




                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addproductrecete">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">

                                <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn btn-lg"
                                                                     value="<?php echo $this->lang->line('Generate Recete') ?> "
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>

                            </tbody>

                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="uretim/action" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="search_newproducts" id="billtype2">
                    <input type="hidden" value="0" name="counter" id="ganak">

                </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-purple white">

                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom crequired" name="email"
                                           id="mcustomer_email">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address" id="mcustomer_address1">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city" id="mcustomer_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region"
                                           class="form-control margin-bottom" name="region">
                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom" name="country" id="mcustomer_country">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox"
                                           class="form-control margin-bottom" name="postbox">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Company"
                                           class="form-control margin-bottom" name="company">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="TAX ID"
                                           class="form-control margin-bottom" name="taxid" id="mcustomer_city">
                                </div>


                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label  col-form-label-sm"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control form-control-sm">
                                        <?php
                                        foreach ($customergrouplist as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>


                        </div>

                        <!-- shipping -->
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                            <div class="form-group row">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="customer1s"
                                           id="copy_address">
                                    <label class="custom-control-label"
                                           for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
                                </div>


                                <div class="col-sm-10">
                                    <?php echo $this->lang->line("leave Shipping Address") ?>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name_s" name="name_s"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone_s" id="mcustomer_phone_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email_s"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom" name="email_s"
                                           id="mcustomer_email_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address_s"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address_s"
                                           id="mcustomer_address1_s">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city_s" id="mcustomer_city_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region_s"
                                           class="form-control margin-bottom" name="region_s">
                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom" name="country_s" id="mcustomer_country_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox_s"
                                           class="form-control margin-bottom" name="postbox_s">
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="Ekle"/>
                </div>
            </form>
        </div>
    </div>
</div>


<script>









    //product total
    var samanYog = function () {

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

        var cid = $('#customer_id').val();



        return sum;

    };

//js eklenecek


    $('#addproductrecete').on('click', function () {


        var cvalue = parseInt($('#ganak').val())+1;
        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;


//product row
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" id="productnames-' + cvalue + '"></td><td>' +
            '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="product_qty-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="fire_hesapla(' + functionNum + ') " autocomplete="off"' +
            ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
            'class="form-control req unt" name="product_unit[]" id="unit-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="fire_hesapla(' + functionNum + ')" autocomplete="off"></td><td> <input type="text" class="form-control fire"' +
            ' name="product_fire[]" id="fire-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="fire_hesapla(' + functionNum + ')" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control fire_quantity" ' +
            'name="product_fire_quantity[]" onkeypress="return isNumber(event)" id="fire_quantity-' + cvalue + '" onkeyup="fire_hesapla(' + functionNum + ')" ' +
            'autocomplete="off"></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Sil" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td>' +
            '<input type="hidden" name="fire[]" id="fire-' + cvalue + '" value="0">' +
            '<input type="hidden" name="fire_quantity[]" id="fire_quantity-' + cvalue + '" value="0">' +
            '<input type="hidden"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            '</tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);


        row = cvalue;

        $('#productnames-' + cvalue).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid='+$("#warehouses option:selected").val()+'&'+d_csrf,
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
                id_arr = $(this).attr('id');
                id = id_arr.split("-");
                var t_r = ui.item.data[3];
                if ($("#taxformat option:selected").attr('data-trate')) {

                    var t_r = $("#taxformat option:selected").attr('data-trate');
                }
                var discount = ui.item.data[4];
                var custom_discount=$('#custom_discount').val();
                if(custom_discount>0) discount=deciFormat(custom_discount);

                $('#amount-' + id[1]).val(1);
                $('#price-' + id[1]).val(ui.item.data[1]);
                $('#pid-' + id[1]).val(ui.item.data[2]);
                $('#vat-' + id[1]).val(t_r);
                $('#discount-' + id[1]).val(discount);
                $('#dpid-' + id[1]).val(ui.item.data[5]);
                $('#unit-' + id[1]).val(ui.item.data[6]);
                $('#hsn-' + id[1]).val(ui.item.data[7]);
                $('#alert-' + id[1]).val(ui.item.data[8]);
                rowTotal(cvalue);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });


        var sideh2 = document.getElementById('rough').scrollHeight;
        var opx3 = sideh2 + 50;
        document.getElementById('rough').style.height = opx3 + "px";



    });


    var fire_hesapla = function (numb) {

        var miktar=$("#product_qty-" + numb).val();
        var fire_yuzdesi=$("#fire-" + numb).val();
        var fire_mik = (miktar * fire_yuzdesi)/100;
        $("#fire_quantity-" + numb).val(deciFormat(fire_mik));
    };






</script>