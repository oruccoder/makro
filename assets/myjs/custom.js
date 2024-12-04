var billtype = $('#billtype').val();
var billtype2 = $('#billtype2').val();
var d_csrf=crsf_token+'='+crsf_hash;
$('#addproduct').on('click', function () {

    if($('#para_birimi').val())
    {
        var currencys=$('#para_birimi').val();
    }
    else
        {
            var currencys='AZN';
        }



    var cvalue = parseInt($('#ganak').val())+1;
    var invoice_type=$("#invoice_type").val();
    var nxt=parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;

    if(invoice_type==36)
    {
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" id="productname-' + cvalue + '"></td>' +
            '<td class="sozle_hid"><input type="text" class="form-control text-center" name="item_desc[]" ' +
            'id="item_desc-' + cvalue + '">'+
            '</td>' +
            '<td><input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog(),paketleme_hesapla(' + functionNum + ')" autocomplete="off"' +
            ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
            'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
            ' name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
            'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currencys +'</span> ' +
            '</strong></td> <td><select class="select2 form-control depo_id_item select-box" name="depo_id_item[]" ></select></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="">' +
            ' <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            ' <input type="hidden" name="invoice_item_id[]" value="0"> ' +
            '</tr>';
    }
   else if(invoice_type==35)
    {
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" id="productname-' + cvalue + '"></td>' +
            '<td class="sozle_hid"><input type="text" class="form-control text-center" name="item_desc[]" ' +
            'id="item_desc-' + cvalue + '">'+
            '</td>' +
            '<td><input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog(),paketleme_hesapla(' + functionNum + ')" autocomplete="off"' +
            ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
            'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
            ' name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
            'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currencys +'</span> ' +
            '</strong></td> <td><select class="select2 form-control depo_id_item select-box" name="depo_id_item[]"></select></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="">' +
            ' <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            ' <input type="hidden" name="invoice_item_id[]" value="0"> ' +
            '</tr>';
    }
    else
    {
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" id="productname-' + cvalue + '"></td><td>' +
            '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog(),paketleme_hesapla(' + functionNum + ')" autocomplete="off"' +
            ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
            'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
            ' name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
            'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currencys +'</span> ' +
            '</strong></td> <td><select class="select2 form-control depo_id_item select-box" name="depo_id_item[]"></select></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="">' +
            ' <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            ' <input type="hidden" name="invoice_item_id[]" value="0"> ' +
            '</tr>';
    }



//product row

    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);
    $('.select-box').select2();

    if(invoice_type==36)
    {
        $('.sozle_hid').css('display','table-cell');
    }
    else if(invoice_type==35)
    {
        $('.sozle_hid').css('display','table-cell');
    }
    else
    {
        $('.sozle_hid').css('display','none');
    }


    var sum=$('#subttlform').val();
    var cid = $('#customer_id').val();
    //kalan kredi hesaplama
    $.ajax({
        type: "POST",
        url: baseurl + 'search_products/c_credit',
        data:
            'cid='+ cid+
            '&sum='+ sum+
            '&'+crsf_token+'='+crsf_hash,
        success: function (data) {

            $('#customer_hesaplaan_kalan_credit').html('Hesaplanan Kalan Kredi : <strong>'+data+'</strong>');
        }
    });

    disc_degis($('#discount_rate').val());

    var url_depolar='invoices/depolar';
    $.ajax({
        type: "POST",
        url: baseurl + url_depolar,
        data:crsf_token+'='+crsf_hash,
        success: function (data) {
            if(data)
            {

                $('.depo_id_item').eq(cvalue).append($('<option>').val(0).text('Seçiniz'));

                jQuery.each(jQuery.parseJSON(data), function (key, item) {
                    $(".depo_id_item").eq(cvalue).append('<option value="'+ item.id +'">'+ item.title +'</option>');
                });
                //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
            }

        }
    });

    row = cvalue;
    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'invoice_type='+invoice_type+'&name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid='+$(".depo_id_item").eq(cvalue).val()+'&'+d_csrf,
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


    var proje_id=$('#proje_id').val();
    if(proje_id!=0)
    {
        $('.depo_id_item').children('option').remove();
        $.ajax({
            dataType: "json",
            method: 'post',
            url: baseurl + 'search_products/proje_deposu',
            data:'proje_id='+ proje_id,
            success: function (data) {
                $(".depo_id_item").append('<option  selected value="'+ data.id +'">'+ data.name+'</option>');

            }
        });
    }


});

//caculations
var precentCalc = function (total, percentageVal) {
    return (total / 100) * percentageVal;
};
//format
var deciFormat = function (minput) {
    if(!minput) minput=0;
    return parseFloat(minput).toFixed(4);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = parseFloat($('#coupon_amount').val());
    }
    return cp;
 };
var shipTot = function () {
    var ship_val = accounting.unformat($('.shipVal').val(), accounting.settings.number.decimal);
    var ship_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        ship_p = (ship_val * ship_rate) / 100;
        ship_val = ship_val + ship_p;
    } else if (tax_status == 'incl') {
        ship_p = (ship_val * ship_rate) / (100 + ship_rate);
    }
    $('#ship_tax').val(accounting.formatNumber(ship_p));
    $('#ship_final').html(accounting.formatNumber(ship_p));
    return ship_val;
};


//actions
var deleteRow = function (num) {
    var prodTotalID;
    var prodttl;
    var subttl;
    var totalSubVal;
    var totalBillVal;
    var totalSelector = $("#subttlform");
    prodTotalID = "#total-" + num;
    prodttl = $(prodTotalID).val();
    subttl = totalSelector.val();
    totalSubVal = deciFormat(subttl - prodttl);
    totalSelector.val(totalSubVal);
    $("#subttlid").html(totalSubVal);
    totalBillVal = totalSubVal + shipTot - coupon;
    //final total
   var clean=deciFormat(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#bigtotal").html(clean);
};


var billUpyog = function () {
    //var totalBillVal = deciFormat(parseFloat(samanYog()) + parseFloat(shipTot()))-coupon();
    var nettotal=$('#nettotalinp').val();

    var totalBillVal = deciFormat(parseFloat(nettotal) + parseFloat(TaxTotal()));
    $("#mahayog").html(totalBillVal);
    $("#subttlform").val(samanYog());
    $("#subttlform2").val(samanYog());
    $("#invoiceyoghtml").val(totalBillVal);
    $("#bigtotal").html(deciFormat(totalBillVal));







};

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
    $("#taxr2").val(taxc);



    //kalan kredi hesaplama


    return sum;

};

var o_rowTotal = function (numb) {
    //most res
    var result;
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

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    }
    else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    }
    else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax


        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var rowTotal = function (numb) {



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

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //precentCalc KDV Hesaplama


            if($("#discount-" + numb).val()!=0)
            {

                var Inpercentage = precentCalc(parseFloat($("#amount-" + numb).val())*parseFloat($("#price-" + numb).val())*(1-(parseFloat($("#discount-" + numb).val()/100))), vatVal);
                totalValue = parseFloat($("#amount-" + numb).val())*parseFloat($("#price-" + numb).val());
                taxo = deciFormat(Inpercentage);
            }
            else
                {
                    var Inpercentage = precentCalc(totalPrice, vatVal);
                    totalValue = parseFloat($("#amount-" + numb).val())*parseFloat($("#price-" + numb).val());
                    taxo = deciFormat(Inpercentage);
                }




            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue =  totalValue = parseFloat($("#amount-" + numb).val())*parseFloat($("#price-" + numb).val());
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue =  totalValue = parseFloat($("#amount-" + numb).val())*parseFloat($("#price-" + numb).val());
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    }
    else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    }
    else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            }
            else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax


        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
    SubTotal();
};
var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'yes') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('%');
    }
    else if (getSelectv == 'inclusive') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('incl');

    }
    else {
        $("#tax_status").val('no');
        $("#tax_format").val('off');

    }
    var discount_handle = $("#discount_format option:selected").val();
    var tax_handle = $("#tax_format").val();
    formatRest(tax_handle, discount_handle, trate);

}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {
        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format option:selected").val(getSelectv);
    }
    else {
        $("#discount_format option:selected").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, getSelectv);
}

function formatRest(taxFormat, disFormat, trate = '') {
    var amntArray = [];
    var idArray = [];
    $('.amnt').each(function () {
        var v = deciFormat($(this).val());
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    var prcArray = [];
    $('.prc').each(function () {
        var v = deciFormat($(this).val());
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        if (trate) {
            $(this).val(trate);
            var v = deciFormat(trate);
        }
        else {
            var v = deciFormat($(this).val());
        }

        vatArray.push(v);
    });

    var discountArray = [];
    $('.discount').each(function () {
        var v = deciFormat($(this).val());
        discountArray.push(v);
    });


    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];

        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == '') {
            vatVal = 0;
        }
        if (discountVal == '') {
            discountVal = 0;
        }
        if (taxFormat == '%') {
            if (disFormat == '%' || disFormat == 'flat') {



                var Inpercentage = precentCalc(result, vatVal);
                var result = parseFloat(result) + Inpercentage;
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'flat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }
            }
            else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'bflat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }

                var Inpercentage = precentCalc(result, vatVal);
                var result = parseFloat(result) + Inpercentage;
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

            }
        }

        else if (taxFormat == 'incl') {

            if (disFormat == '%' || disFormat == 'flat') {


                var Inpercentage = (+result * +vatVal) / (100 + +vatVal);
                var result = parseFloat(result);
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'flat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }
            }
            else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'bflat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }


                var Inpercentage = (+result * +vatVal) / (100 + +vatVal);
                var result = parseFloat(result);
                taxr = parseFloat(taxr) + parseFloat(Inpercentage);
                $("#texttaxa-" + x).html(deciFormat(Inpercentage));
                $("#taxa-" + x).val(deciFormat(Inpercentage));

            }
        }
        else {

            if (disFormat == '%' || disFormat == 'flat') {

                var result = parseFloat($("#amount-" + x).val()) * parseFloat($("#price-" + x).val());
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'flat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }
            }
            else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    var result = parseFloat(result) - parseFloat(Inpercentage);
                    $("#disca-" + x).val(deciFormat(Inpercentage));
                    discsr = parseFloat(discsr) + parseFloat(Inpercentage);
                } else if (disFormat == 'bflat') {
                    var result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(deciFormat(discountVal));
                    discsr += parseFloat(discountVal);
                }

                //   var result = parseFloat($("#amount-" + i).val()) * parseFloat($("#price-" + i).val());
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

            }
        }

        $("#total-" + x).val(deciFormat(result));
        //$("#result-" + x).html(deciFormat(result));



    }
  var sum = deciFormat(samanYog());
        $("#subttlid").html(sum);
        $("#taxr").html(deciFormat(taxr));
        $("#taxr2").val(deciFormat(taxr));
        $("#discs").html(deciFormat(discsr));
             billUpyog();

}
//remove productrow


    $('#saman-row').on('click', '.removeProd', function () {

        var pidd = $(this).closest('tr').find('.pdIn').val();
        var pqty = $(this).closest('tr').find('.amnt').val();
        var depo = $(this).closest('tr').find('.depo_id_item').val();
        pqty = pidd + '-' + pqty+'-'+depo;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('#data_form');
        $(this).closest('tr').remove();
        $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
        $('.amnt').each(function (index) {
            rowTotal(index);
            billUpyog();
        });

        return false;
    });


    $('#productname-0').autocomplete({


        source: function (request, response) {
            var invoice_type=$('#invoice_type').val();
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
              data: 'invoice_type='+invoice_type+'&name_startsWith='+request.term+'&type=product_list&row_num=1&wid='+$(".depo_id_item").eq(0).val()+'&'+d_csrf,
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
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                var t_r = $("#taxformat option:selected").attr('data-trate');
            }
               var discount = ui.item.data[4];
          var custom_discount=$('#custom_discount').val();
          if(custom_discount>0) discount=deciFormat(custom_discount);
            $('#amount-0').val(1);
            $('#price-0').val(ui.item.data[1]);
            $('#pid-0').val(ui.item.data[2]);
            $('#vat-0').val(t_r);
            $('#discount-0').val(discount);
            $('#dpid-0').val(ui.item.data[5]);
            $('#unit-0').val(ui.item.data[6]);
            $('#stok_fis_unit-0').val(ui.item.data[9]);
            $('#hsn-0').val(ui.item.data[7]);
            $('#alert-0').val(ui.item.data[8]);
            rowTotal(0);

            billUpyog();
            $('#addproducte').click();


        }
    });
    $(document).on('click', ".select_pos_item", function (e) {
        var pid = $(this).attr('data-pid');
        var stock = $(this).attr('data-stock');
        var flag = true;
           var discount = $(this).attr('data-discount');
          var custom_discount=$('#custom_discount').val();
          if(custom_discount>0) discount=deciFormat(custom_discount);
        $('.pdIn').each(function () {

            if (pid == $(this).val()) {

           var pi = $(this).attr('id');
                var arr = pi.split('-');
                pi = arr[1];
             $('#discount-' + pi).val(discount);
                var stotal = +deciFormat($('#amount-' + pi).val()) + 1;

                if (stotal <= stock) {
                    $('#amount-' + pi).val(+deciFormat($('#amount-' + pi).val()) + +1);
                     $('#search_bar').val('').focus();
                }
                else {
                    $('#stock_alert').modal('toggle');
                }
                rowTotal(pi);
                billUpyog();
     $('#amount-'+pi).focus();
                flag = false;
            }
        });
        var t_r = $(this).attr('data-tax');
        if ($("#taxformat option:selected").attr('data-trate')) {

            var t_r = $("#taxformat option:selected").attr('data-trate');
        }
        if (flag) {
            var ganak = $('#ganak').val();
            var cvalue = parseInt(ganak);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row div').length;
            var data = '<tr id="ppid-' + cvalue + '"><td colspan="7" ><input type="text" class="form-control text-center"' +
                ' name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '">' +
                '<input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"></td></tr><tr><td>' +
                '<input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" ' +
                'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control req prc"' +
                ' name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
                'autocomplete="off"  value="' + $(this).attr('data-price') + '"></td><td> <input type="text" class="form-control vat" name="product_tax[]" ' +
                'id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  ' +
                'value="' + t_r + '"></td>  <td><input type="text" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" ' +
                'id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"></td> <td>' +
                '<span class="currenty">' + currencys + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td ' +
                'class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> ' +
                '<input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"></tr>';

            //ajax request
            // $('#saman-row').append(data);
            $('#pos_items').append(data);
            rowTotal(cvalue);
            billUpyog();
            $('#ganak').val(cvalue + 1);
            $('#search_bar').val('').focus();
           // $(document).scrollTop($(document).height());
        }
    });

$(document).on('click', ".v2_select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock =  accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

    var discount = $(this).attr('data-discount');
    var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
    if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
    var flag = true;
    $('#v2_search_bar').val('');
    $('.pdIn').each(function () {

        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#search_bar').val('').focus();
            } else {
                $('#stock_alert').modal('toggle');
            }
            rowTotal(pi);
            billUpyog();

            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    var sound = document.getElementById("beep");
    sound.play();
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;
        var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0">' +
            ' <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"></div>';
        //ajax request
        // $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();
    }
});

$('#saman-pos2').on('click', '.removeItem', function () {
    var pidd = $(this).attr('data-rowid');
    var pqty = accounting.unformat($('#amount-' + pidd).val(), accounting.settings.number.decimal);
    var old_amnt = $('#amount_old-' + pidd).val();
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $('#ppid-' + pidd).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
    });
    billUpyog();
    return false;
});


$('#saman-row-pos').on('click', '.removeItem', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = accounting.unformat($(this).closest('tr').find('.amnt').val(), accounting.settings.number.decimal);
    var old_amnt = accounting.unformat($(this).closest('tr').find('.old_amnt').val(), accounting.settings.number.decimal);
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('#p' + $(this).closest('tr').find('.pdIn').attr('id')).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);

    });
    billUpyog();

    return false;

});


$(document).on('click', ".quantity-up", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);

    var newVal = oldValue + 1;
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});

$(document).on('click', ".quantity-down", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);
    var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});


//Yeni Yazılan Fonksiyonlar
$(document).ready(function () {
    SubTotal();
});

//Ara Toplam (Sub Total)

var SubTotal = function () {
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

//KDV Toplam
var TaxTotal = function () {
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
    return taxc;

};

$('#productnames2').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: baseurl + 'search_products/' + billtype2,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith='+request.term+'&type=product_list&row_num=1&wid='+$("#warehouses option:selected").val()+'&'+d_csrf,
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

        var product_id=ui.item.data[2];
        if(ui.item.data[2]==0)
        {
            $.ajax({
                url: baseurl + 'search_products/new_product',
                dataType: "json",
                method: 'post',
                data: 'name_startsWith='+ui.item.data[0]+'&'+d_csrf,
                success: function (data) {
                        alert('Yeni Ürün Eklendi');
                        $('#new_prd_id').val(data);




                }
            });
        }
        else
            {
                $('#new_prd_id').val(product_id);
            }

    }
});




