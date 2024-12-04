<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form id="data_form">

            <input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo $purchase_id; ?>">
            <input type="hidden" name="iid" id="iid" value="<?php echo $_GET['id']; ?>">

            <div class="row">



                <div class="col-sm-12 cmp-pnl">
                    <div class="inner-cmp-pnl">


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="toAddInfo"
                                       class="caption"><?php echo $this->lang->line('Note') ?></label>
                                <textarea class="form-control round" name="notes" rows="2"><?php echo $invoice['notes'] ?></textarea></div>

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
                            <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr></thead> <tbody>
                        <?php $i = 0;
                        foreach ($products as $row) {
                            echo '<tr >
                        <td><input type="text" class="form-control text-center" name="product_name[]" id="productnamee-' . $i . '"  value="' . $row['product'] . '">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . +$row['toplam_rulo'] . '" ><input type="hidden" name="old_product_qty[]" value="' . $row['qty'] . '" ></td>
                        
                        <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="icon-minus-square"></i> </button>
                        </td>
                        <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . $row['totaltax'] . '">
                        <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . $row['totaldiscount'] . '">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . $row['subtotal'] . '">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
                             <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">
                                   <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['code'] . '">
                    </tr> ';
                            $i++;
                        } ?>
                        <tr class="last-item-row sub_c">
                            <td class="add-row">
                                <button type="button" class="btn btn-light-green" aria-label="Left Align"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Add product row" id="addproducte">
                                    <i class="icon-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                </button>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="sub_c" style="display: table-row;">
                            <td align="right" colspan="6"><input  class="btn btn-success sub-btn"
                                                                 value="<?php echo $this->lang->line('Update') ?>"
                                                                 id="submit-data" data-loading-text="Updating...">
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>

                <input type="hidden" value="sayim/editaction" id="action-url">
                <input type="hidden" value="puchase_search" id="billtype">
                <input type="hidden" value="<?php echo $i ; ?>" name="counter" id="ganak">
                <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                <input type="hidden" value="<?=$this->common->taxhandle_edit($invoice['taxstatus']) ?>" name="taxformat" id="tax_format">
                <input type="hidden" value="<?= $invoice['format_discount'] ; ?>" name="discountFormat" id="discount_format">
                <input type="hidden" value="<?= $invoice['taxstatus'] ; ?>" name="tax_handle" id="tax_status">
                <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                <input type="hidden" value="<?=@number_format(($invoice['ship_tax']/$invoice['shipping'])*100,2,'.','') ?>" name="shipRate" id="ship_rate">
                <input type="hidden" value="<?=$invoice['ship_tax_type']; ?>" name="ship_taxtype" id="ship_taxtype">
                <input type="hidden" value="<?= $invoice['ship_tax'] ; ?>" name="ship_tax" id="ship_tax">


        </form>
    </div>

</article>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
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

                                <label class="col-sm-2 col-form-label"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control">
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

                                <div class="input-group">
                                    <label class="display-inline-block custom-control custom-radio ml-1">
                                        <input type="checkbox" name="customer1" class="custom-control-input"
                                               id="copy_address">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description ml-0"><?php echo $this->lang->line('Same As Billing') ?></span>
                                    </label>

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
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript"> $('.editdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});</script>


<div style="display: none">
    <audio  class="audios" id="yes-audio" controls preload="none">
        <source src="/audios/Watsonia.mp3" type="audio/mpeg">
    </audio>

    <audio class="audios" id="no-audio" controls preload="none">
        <source src="/audios/Run.mp3" type="audio/mpeg">
    </audio>
</div>
<script>
    var urunler=[];

    //1. satır için
    $(document).ready(function () {

        //Siparişteki Ürünleri Getirme

        var purchase_id=$('#purchase_id').val();

        $.ajax({
            url: baseurl + 'sayim/sayim_urunleri_edit',
            dataType: "json",
            method: 'post',
            async:false,
            data: 'purchase_id='+purchase_id+'&'+d_csrf,
            success: function (responsive) {
                console.log(responsive[0]);
                urunler.push(responsive);

            }
        });





        //Siparişteki Ürünleri Getirme

        var cvalue = parseInt($('#ganak').val())+1;
        $('#productnamee-0').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'name_startsWith='+request.term+'&type=product_list&row_num=1&wid'+$("#warehouses option:selected").val()+'&'+d_csrf,
                    success: function (data) {
                        if(data=='')
                        {
                            $('#productnamee-0').val('');
                        }
                        response(data);

                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {



                var pid=0;
                var qty_new =0;
                var stok_mik =0;

                var urun_durumu=true;

                //urunler[0][1]['product_id'];

                for (var i=0; i< urunler[0].length;i++ )
                {
                    if(ui.item[2] == urunler[0][i]['product_id'])
                    {

                        pid=urunler[0][i]['product_id'];
                        qty_new=urunler[0][i]['qty']; // 8
                        stok_mik=urunler[0][i]['stok_mik']; //4
                    }

                }

                var durum=true;

                for(var i=0; i < $('.amnt').length;i++)
                {
                    var prd_name2= $('#productnamee-' + i).val();
                    var prd_name= $('#productnamee-0').val();
                    if(prd_name==ui.item[0] || prd_name2==ui.item[0] )
                    {

                        var sayi= $('.amnt').eq(i).val();

                        if(parseFloat(stok_mik) > parseFloat(qty_new))
                        {
                            if(parseFloat(qty_new) >= parseFloat(sayi) && ui.item[2]==pid )
                            {
                                durum=false;

                                var qty=parseInt(sayi)+parseInt(1);


                                $('.amnt').eq(i).val(qty);

                                $('#productnamee-' + cvalue).val('');
                                playAudio('yes');
                                return false;
                            }
                            else
                            {
                                playAudio('No');
                                alert('Siparişteki Adete Ulaşıldı!')
                                $('#productnamee-'+cvalue).val('');
                                return false;
                            }
                        }
                        else
                        {
                            $('#productnamee-'+cvalue).val('');
                            playAudio('No');
                            alert('Depoda Stok Mevcut Değil!')

                            return false;
                        }






                    }
                }

                if(durum==true)
                {
                    id_arr = $(this).attr('id');

                    id = id_arr.split("-");


                    if(ui.item[2]==pid )
                    {
                        var sayi= $('.amnt').eq(id[1]).val();
                        if(parseFloat(stok_mik) > parseFloat(sayi))
                        {
                            playAudio('yes');

                            var t_r = ui[3];
                            if ($("#taxformat option:selected").attr('data-trate')) {

                                var t_r = $("#taxformat option:selected").attr('data-trate');
                            }
                            var discount = ui[4];
                            var custom_discount=$('#custom_discount').val();
                            if(custom_discount>0) discount=deciFormat(custom_discount);

                            $('#amount-' + id[1]).val(1);
                            $('#price-' + cvalue).val(ui.item[1]);
                            $('#pid-' + id[1]).val(ui.item[2]);
                            $('#vat-' + id[1]).val(t_r);
                            $('#discount-' + id[1]).val(discount);
                            $('#dpid-' + id[1]).val(ui.item[5]);
                            $('#unit-' + id[1]).val(ui.item[6]);
                            $('#hsn-' + id[1]).val(ui.item[7]);
                            $('#alert-' + id[1]).val(ui.item[8]);

                            $('#productnamee-' + cvalue).val(ui.item[0]);
                        }
                        else
                        {
                            $('#productnamee-'+cvalue).val('');
                            playAudio('No');
                            alert('Depoda Stok Mevcut Değil!');
                            return false;
                        }

                    }
                    else
                    {
                        playAudio('No');
                        alert('Bu Ürün Siparişte Yok!')
                        return false;
                    }

                }




                rowTotal(cvalue);
                billUpyog();
                $('#addproducte').click();




            }
        })
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {



            if(item.label == 'No Match Found'){
                return $( "<li id='ac' style='width: 29%;background-color: #d7dede;padding: 5px;'>" )
                    .data( "item.autocomplete", item )
                    .append( item.value )
                    .appendTo( ul )
                    .css("cursor", "default");
            } else {
                return $( "<li aria-selected='true' style='width: 29%;background-color: #d7dede;padding: 5px;'>" )
                    .data( "item.autocomplete", item )
                    .append( (item[0]) )
                    .appendTo( ul )
                    .css("cursor", "default");
            }



        }
    });






    function playAudio(result){
        if (result == "yes"){

            $('#yes-audio').trigger('play')
        }
        else if (result == "No"){
            $('#no-audio').trigger('play')
        }

    }



    $('#invoice_type').on('change',function () {
        $('#customer-box').prop('disabled',false);
    });


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




        return sum;

    };

    $(document).ready(function () {
        $('#productname-0').focus();
        SubTotal();
        billUpyog();


    });



    $('#addproducte').on('click', function () {






        var cvalue = parseInt($('#ganak').val())+1;
        var cvalue1 = parseInt($('#ganak').val());


        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;




//product row
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" autofocus id="productnamee-' + cvalue + '"></td><td>' +
            '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"' +
            ' value="0" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="icon-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            '</tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);



        row = cvalue;

        $('#productnamee-'+cvalue).focus();




        $('#productnamee-' + cvalue).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid'+$("#warehouses option:selected").val()+'&'+d_csrf,
                    success: function (data) {
                        if(data=='')
                        {
                            $('#productnamee-'+cvalue).val('');
                        }

                        response(data);

                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {


                var pid=0;
                var qty_new =0;
                var stok_mik =0;


                var urun_durumu=true;

                //urunler[0][1]['product_id'];

                for (var i=0; i< urunler[0].length;i++ )
                {
                    if(ui.item[2] == urunler[0][i]['product_id'])
                    {
                        //console.log(i+' Eşit'+' pid:'+urunler[0][i]['product_id']);
                        pid=urunler[0][i]['product_id'];
                        qty_new=urunler[0][i]['qty'];
                        stok_mik=urunler[0][i]['stok_mik'];

                    }
                }



                var durum=true;

                for(var i=0; i < $('.amnt').length;i++)
                {
                    var prd_name2= $('#productnamee-' + i).val();
                    var prd_name= $('#productnamee-0').val();
                    if(prd_name==ui.item[0] || prd_name2==ui.item[0] )
                    {
                        var sayi = $('.amnt').eq(i).val();
                        if(parseFloat(stok_mik) > parseFloat(sayi))

                        {

                            if (parseFloat(sayi) < parseFloat(qty_new) && ui.item[2] == pid) {
                                durum = false;

                                playAudio('yes');

                                var qty = parseInt(sayi) + parseInt(1);


                                $('.amnt').eq(i).val(qty);

                                $('#productnamee-' + cvalue).val('');

                                return false;
                            }
                            else {
                                playAudio('No');
                                alert('Siparişteki Adete Ulaşıldı!');

                                $('#productnamee-' + cvalue).val('');
                                return false;
                            }
                        }
                        else
                        {
                            $('#productnamee-' + cvalue).val('');
                            playAudio('No');
                            alert('Depoda Stok Mevcut Değil!');


                            return false;
                        }



                    }
                }

                if(durum==true)
                {
                    if(ui.item[2]==pid )
                    {
                        id_arr = $(this).attr('id');

                        id = id_arr.split("-");

                        var sayi= $('.amnt').eq(id[1]).val();
                        if(parseFloat(stok_mik) > parseFloat(sayi) && parseFloat(stok_mik)!=0 )
                        {
                            playAudio('yes');

                            var t_r = ui[3];
                            if ($("#taxformat option:selected").attr('data-trate')) {

                                var t_r = $("#taxformat option:selected").attr('data-trate');
                            }
                            var discount = ui[4];
                            var custom_discount=$('#custom_discount').val();
                            if(custom_discount>0) discount=deciFormat(custom_discount);

                            $('#amount-' + id[1]).val(1);
                            $('#price-' + cvalue).val(ui.item[1]);
                            $('#pid-' + id[1]).val(ui.item[2]);
                            $('#vat-' + id[1]).val(t_r);
                            $('#discount-' + id[1]).val(discount);
                            $('#dpid-' + id[1]).val(ui.item[5]);
                            $('#unit-' + id[1]).val(ui.item[6]);
                            $('#hsn-' + id[1]).val(ui.item[7]);
                            $('#alert-' + id[1]).val(ui.item[8]);

                            $('#productnamee-' + cvalue).val(ui.item[0]);
                        }

                        else
                        {
                            $('#productnamee-'+cvalue).val('');
                            playAudio('No');
                            alert('Depoda Stok Mevcut Değil!')

                            return false;
                        }

                    }
                    else
                    {
                        playAudio('No');
                        alert('Bu Ürün Siparişte Yok!');
                        $('#productnamee-'+cvalue).val('');
                        return false;
                    }

                }




                rowTotal(cvalue);
                billUpyog();
                $('#addproducte').click();




            }
        })
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {



            if(item.label == 'No Match Found'){
                return $( "<li id='ac' style='width: 29%;background-color: #d7dede;padding: 5px;'>" )
                    .data( "item.autocomplete", item )
                    .append( item.value )
                    .appendTo( ul )
                    .css("cursor", "default");
            } else {
                return $( "<li aria-selected='true' style='width: 29%;background-color: #d7dede;padding: 5px;'>" )
                    .data( "item.autocomplete", item )
                    .append( (item[0]) )
                    .appendTo( ul )
                    .css("cursor", "default");
            }



        }






        var sideh2 = document.getElementById('rough').scrollHeight;
        var opx3 = sideh2 + 50;
        document.getElementById('rough').style.height = opx3 + "px";

    });






</script>