<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 18.01.2020
 * Time: 11:52
 */
?>
<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">


                    <div class="message"></div>
                </div>
                <div class="card-body">
                    <form id="data_form">

                        <input type="hidden" name="customer_id_cart" value="<?php echo $user_id_cart; ?>">
                        <?php if($purchase_id!=0){ ?>
                            <input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo $purchase_id; ?>">
                        <?php } else { ?>
                            <input type="hidden" id="purchase_id" value="0">
                            <select  class="form-control" name="purchase_id">
                                <option>Sayım Yapılacak Siparişi Seçiniz</option>
                            </select>


                        <?php } ?>
                        <div class="row">



                            <div class="col-sm-12 cmp-pnl">
                                <div class="inner-cmp-pnl">


                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="toAddInfo"
                                                   class="caption"><?php echo $this->lang->line('Note') ?></label>
                                            <textarea class="form-control round" name="notes" rows="2"></textarea></div>

                                    </div>


                                </div>
                            </div>

                        </div>


                        <div id="saman-row">
                            <table class="table-responsive tfr my_stripe" width="100%">

                                <thead>
                                <tr class="item_header bg-gradient-directional-amber">
                                    <th width="90%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                    <th width="15%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>

                                    <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                </tr>

                                </thead>  <tbody>



                                <tr>
                                    <td><input type="text" class="form-control text-center" name="product_name[]"
                                               placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productnamee-0' autofocus>
                                    </td>
                                    <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                               onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                               autocomplete="off" value="0"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>


                                    <td class="text-center">

                                    </td>
                                    <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                    <input type="hidden" name="disca[]" id="disca-0" value="0">
                                    <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                                    <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                    <input type="hidden" name="unit[]" id="unit-0" value="">
                                    <input type="hidden" name="hsn[]" id="hsn-0" value="">
                                </tr>

                                <tr class="last-item-row sub_c">
                                    <td class="add-row">
                                        <button type="button" class="btn btn-success"  id="addproducte">
                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                        </button>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>


                                <tr class="sub_c" style="display: table-row;">
                                    <td align="right" colspan="6">
                                        <input class="btn btn-success sub-btn btn-lg" value="<?php echo $this->lang->line('Generate Sayim') ?>"
                                               id="submit-data" data-loading-text="Creating...">

                                    </td>
                                </tr>




                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" value="new_i" id="inv_page">
                        <input type="hidden"  name="cid" id="customer_id">
                        <input type="hidden" value="sayim/action" id="action-url">
                        <input type="hidden" value="puchase_search" id="billtype">
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


                <div>

                    <h3 style="text-align: center">Sayım Yapılacak Sipariş Bilgileri</h3>
                    <table class="table tfr my_stripe" width="100%">
                        <thead>
                        <tr class="item_header bg-gradient-directional-blue white" width="100%">
                            <th width="90%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                            <th width="15%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                        </tr>
                        <?php foreach ($products as $prd) { ?>
                            <tr>

                                <td><?php echo $prd['product']; ?></td>
                                <td><?php echo rulo_hesapla($prd['pid'],$prd['qty']).' Rulo'; ?></td>

                            </tr>
                        <?php } ?>


                        </thead>  <tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

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
                url: baseurl + 'sayim/sayim_urunleri',
                dataType: "json",
                method: 'post',
                async:false,
                data: 'purchase_id='+purchase_id+'&'+d_csrf,
                success: function (responsive) {
                    //console.log(responsive[0]);
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
                    var sayim_durumu=0;
                    var sayim_tipi='';

                    var urun_durumu=true;

                    //urunler[0][1]['product_id'];

                    for (var i=0; i< urunler[0].length;i++ )
                    {
                        sayim_tipi=urunler[0][i]['durum']; //4
                        if(ui.item[2] == urunler[0][i]['product_id'])
                        {

                            $('#productnamee-0').val(urunler[0][i]['product_name']);
                            pid=urunler[0][i]['product_id'];
                            qty_new=urunler[0][i]['qty']; // 8
                            stok_mik=urunler[0][i]['stok_mik']; //4
                            sayim_durumu=urunler[0][i]['siparis_durumu']; //4


                            $('#pid-0').val(pid);
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


                            if(sayim_durumu==0)
                            {
                                if(parseFloat(stok_mik) > parseFloat(qty_new))
                                {
                                    if(parseFloat(qty_new) >= parseFloat(sayi) && ui.item[2]==pid )
                                    {
                                        durum=false;

                                        var qty=parseInt(sayi)+parseInt(1);


                                        $('.amnt').eq(i).val(qty);

                                        $('#productnamee-' + cvalue).val('');
                                        playAudio('yes');
                                        $('#addproducte').click();
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
                            else
                            {
                                $('#productnamee-'+cvalue).val('');
                                playAudio('No');
                                alert('Ürünün Sayımı Tamamlanmıştır!');
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

                            if(sayim_durumu==0)
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
                                $('#productnamee-'+cvalue).val('');
                                playAudio('No');
                                alert('Ürünün Sayımı Tamamlanmıştır!');
                                return false;
                            }


                        }
                        else
                        {
                            if(sayim_tipi=='depo_sayimi')
                            {
                                playAudio('yes');
                                return true;
                            }
                            else
                            {
                                playAudio('No');
                                alert('Bu Ürün Siparişte Yok!')
                                return false;
                            }

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
                ' value="0" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="sil" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
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
                    var sayim_durumu =0;
                    var sayim_tipi='';


                    var urun_durumu=true;

                    //urunler[0][1]['product_id'];



                    for (var i=0; i< urunler[0].length;i++ )
                    {
                        sayim_tipi=urunler[0][i]['durum']; //4
                        if(ui.item[2] == urunler[0][i]['product_id'])
                        {
                            //console.log(i+' Eşit'+' pid:'+urunler[0][i]['product_id']);
                            pid=urunler[0][i]['product_id'];
                            qty_new=urunler[0][i]['qty'];
                            stok_mik=urunler[0][i]['stok_mik'];
                            sayim_durumu=urunler[0][i]['siparis_durumu'];

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

                            if(sayim_durumu==0)
                            {
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
                    }

                    if(durum==true)
                    {
                        if(ui.item[2]==pid )
                        {
                            id_arr = $(this).attr('id');

                            id = id_arr.split("-");

                            var sayi= $('.amnt').eq(id[1]).val();

                            if(sayim_durumu==0)
                            {
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

                                    if(sayim_tipi=='depo_sayimi')
                                    {
                                        playAudio('yes');
                                        id_arr = $(this).attr('id');

                                        id = id_arr.split("-");

                                        var sayi= $('.amnt').eq(id[1]).val();


                                        var qty = parseInt(sayi) + parseInt(1);


                                        $('.amnt').eq(i).val(qty);
                                        return true;
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
                            else
                            {
                                $('#productnamee-'+cvalue).val('');
                                playAudio('No');
                                alert('Ürünün Sayımı Tamamlanmıştır!')

                                return false;
                            }


                        }
                        else
                        {
                            if(sayim_tipi=='depo_sayimi')
                            {
                                playAudio('yes');
                                id_arr = $(this).attr('id');

                                id = id_arr.split("-");

                                var sayi= $('.amnt').eq(id[1]).val();


                                var qty = parseInt(sayi) + parseInt(1);


                                $('.amnt').eq(i).val(qty);
                                return true;
                            }
                            else
                            {
                                playAudio('No');
                                alert('Bu Ürün Siparişte Yok!')
                                return false;
                            }

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
