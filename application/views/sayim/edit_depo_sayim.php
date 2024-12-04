<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 18.01.2020
 * Time: 13:07
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
                            <table class="table-responsive tfr my_stripe" width="100%">
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
                                               autocomplete="off" value="' . +$row['qty'] . '" ><input type="hidden" name="old_product_qty[]" value="' . $row['qty'] . '" ></td>
                                    
                                    <td class="text-center">
            <button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button>
                                    </td>
                                    
                                    <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
                                    <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">
                                    <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['code'] . '">
                                </tr> ';
                                    $i++;
                                } ?>
                                <tr class="last-item-row sub_c">
                                    <td class="add-row">
                                        <button type="button" class="btn btn-success"  id="addproducte">
                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
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

                        <input type="hidden" value="sayim/editdepoaction" id="action-url">
                        <input type="hidden" value="puchase_search" id="billtype">
                        <input type="hidden" value="<?php echo $i-1 ; ?>" name="counter" id="ganak">
                        <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                        <input type="hidden"  name="taxformat" id="tax_format">
                        <input type="hidden" value="<?= $invoice['format_discount'] ; ?>" name="discountFormat" id="discount_format">
                        <input type="hidden" value="<?= $invoice['taxstatus'] ; ?>" name="tax_handle" id="tax_status">
                        <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                        <input type="hidden" value="<?=@number_format(($invoice['ship_tax']/$invoice['shipping'])*100,2,'.','') ?>" name="shipRate" id="ship_rate">
                        <input type="hidden" value="<?=$invoice['ship_tax_type']; ?>" name="ship_taxtype" id="ship_taxtype">
                        <input type="hidden" value="<?= $invoice['ship_tax'] ; ?>" name="ship_tax" id="ship_tax">

                    </form>
                </div>
            </div>
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

        var cvalue = parseInt($('#ganak').val());
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



                var durum=true;

                for(var i=0; i < $('.amnt').length;i++)
                {
                    var prd_name2= $('#productnamee-' + i).val();
                    var prd_name= $('#productnamee-0').val();
                    if(prd_name==ui.item[0] || prd_name2==ui.item[0] )
                    {

                        var sayi= $('.amnt').eq(i).val();


                        durum=false;

                        var qty=parseInt(sayi)+parseInt(1);


                        $('.amnt').eq(i).val(qty);

                        $('#productnamee-' + cvalue).val('');
                        playAudio('yes');
                        return false;
                    }
                }

                if(durum==true)
                {
                    id_arr = $(this).attr('id');

                    id = id_arr.split("-");


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




                var durum=true;

                for(var i=0; i < $('.amnt').length;i++)
                {
                    var prd_name2= $('#productnamee-' + i).val();
                    var prd_name= $('#productnamee-0').val();
                    if(prd_name==ui.item[0] || prd_name2==ui.item[0] )
                    {
                        var sayi = $('.amnt').eq(i).val();
                        durum = false;

                        playAudio('yes');

                        var qty = parseInt(sayi) + parseInt(1);


                        $('.amnt').eq(i).val(qty);

                        $('#productnamee-' + cvalue).val('');

                        return false;



                    }
                }

                if(durum==true)
                {
                    id_arr = $(this).attr('id');

                    id = id_arr.split("-");

                    var sayi= $('.amnt').eq(id[1]).val();

                    playAudio('yes');
                    $('#amount-' + id[1]).val(1);
                    $('#price-' + cvalue).val(ui.item[1]);
                    $('#pid-' + id[1]).val(ui.item[2]);
                    $('#vat-' + id[1]).val(0);
                    $('#discount-' + id[1]).val(0);
                    $('#dpid-' + id[1]).val(ui.item[5]);
                    $('#unit-' + id[1]).val(ui.item[6]);
                    $('#hsn-' + id[1]).val(ui.item[7]);
                    $('#alert-' + id[1]).val(ui.item[8]);
                    $('#productnamee-' + cvalue).val(ui.item[0]);
                    $('#productnamee-' + cvalue).val(ui.item[0]);

                }




                rowTotal(cvalue);
                billUpyog();
                $('#addproducte').click();




            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {



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






</script>
