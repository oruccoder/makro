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

                                <input type="hidden" name="cari_pers_type" value="2">
                                <div class="col-sm-1">
                                    <label class="col-form-label"
                                           for="name">Ödeme Türü</label>

                                    <div class="input-group">
                                        <select name="paymethod" class="form-control" id="paymethod">
                                            <option>Seçiniz</option>
                                            <option value="1">Nakit</option>
                                            <option value="3">Banka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <label class="col-form-label">Tür</label>

                                    <div class="input-group">

                                        <select name="pay_type" class="form-control" id="pay_type">
                                            <option value="14">Avans</option>
                                            <option value="16">Sipariş Prim Ödemesi</option>
                                            <option value="12">Maaş Ödemesi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday"><?php echo $this->lang->line('creation date') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control required"
                                               name="date" data-toggle="datepicker" id="invoice_date"
                                               autocomplete="false">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxformat" class="col-form-label">Hesap</label>
                                    <select name="pay_acc" class="form-control pay_acc select-box">
                                        <option>Hesap Seçiniz</option>
                                        <?php foreach (all_account() as $hesap)
                                        {
                                            echo "<option value='$hesap->id'>$hesap->holder</option>";
                                        } ?>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label"
                                           for="birthday">Personel</label>

                                    <div class="input-group">
                                        <select class="form-control" name="malzeme_talep_form_id" id="malzeme_talep_form_id">
                                           <option value="0">Seçiniz</option>
                                           <option value="1">Tüm Personeller</option>
                                           <option value="2">Manuel Seçilecek</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div id="saman-row" >
                        <table class="table tfr my_stripe">
                            <thead>
                            <tr class="item_header bg-gradient-directional-blue white">
                                <th width="20%" class="text-center">Personel Adı</th>
                                <th width="15%" class="text-center">Tutar</th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>


                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input name="pers_id[]" id="pers_id-0" type="hidden">
                                    <input type="text" class="form-control" name="pers_name[]" id="pers_name-0"
                                           placeholder="Personel Adı Giriniz">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="tutar[]" id="tutar-0"
                                           placeholder="Tutar Giriniz">
                                </td>

                                <td class="text-center">
                                    <input type="hidden" class="removeProd">
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
                                                                      value="Hesap Oluştur"
                                                                      id="submit-data" data-loading-text="Creating...">

                                </td>

                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="AZN" id="para_birimi">
                    <input type="hidden" value="<?php echo $this->aauth->get_user()->loc ?>" id="loc_id">
                    <input type="hidden" value="transactions/pers_toplu_odeme_yap" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">

                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">

                </form>
            </div>
        </div>
    </div>
</div>

<script>



    function selectCustomerSatin(eq,company,ph) {


        $('#company_name').eq(eq).val(company);
        $('#customer_phone').eq(eq).val(ph);
        $("#customer-box").eq(eq).val();
        $("#customer-box-result").eq(eq).hide();


    }

    function firmabul(obj)
    {
        var eq = $(obj).parent().parent().index();
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchSatin',
            data: 'keyword=' + $(obj).val()+'&invoice_type=' + 1 +'&eq=' + eq +'&'+crsf_token+'='+crsf_hash,
            beforeSend: function () {
                $(".customer-box").eq(eq).css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $(".customer-box-result").eq(eq).show();
                $(".customer-box-result").eq(eq).html(data);
                $(".customer-box").css("background", "none");

            }
        });
    }

    $("#malzeme_talep_form_id").on("change",function () {

        $('.removeProd').closest('tr').remove();


        var malzeme_talep_id =$("#malzeme_talep_form_id").val();
        var paymethod =$("#paymethod").val();
        var cvalue=0;
        if(malzeme_talep_id==1)
        {
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/personel_ajax',
                data:
                    'paymethod='+ paymethod+
                    '&'+crsf_token+'='+crsf_hash,
                success: function (data) {
                    $.each(jQuery.parseJSON(data), function(k, v) {
                        var maas = v['maas'];
                        var pers_id = v['pers_id'];
                        var pers_name = v['pers_name'];


                        //EKLEME//


//product row
                        var data = ` <tr>
                                <td>
  <input name="pers_id[]" type="hidden" value="`+pers_id+`"  id="pers_id-`+cvalue+`">
<input type="text" class="form-control" id="pers_name-`+cvalue+`" name="pers_name[]" value=`+pers_name+`
                                           placeholder="Personel Adını Giriniz">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="tutar[]"  value=`+maas+`  id="tutar-`+cvalue+`"
                                           placeholder="Tutar Giriniz">
                                </td>

                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
                        //ajax request
                        // $('#saman-row').append(data);
                        $('tr.last-item-row').before(data);
                        cvalue+1;
                        //EKLEME//

                    });

                }
            });
        }


    })




    $('#invoice_type').on('change',function () {
        $('#customer-box').prop('disabled',false);
    });






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

        $('#pers_name-0').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/personel_ajax_search',
                    dataType: "json",
                    method: 'post',
                        data: 'paymethod='+$("#paymethod").val()+'&name_startsWith='+request.term+'&type=product_list&row_num=1&'+d_csrf,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var product_d = item[1];
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
                $('#tutar-0').val(ui.item.data[0]);
                $('#pers_id-0').val(ui.item.data[2]);
                $('#addproduct_talep').click();


            }
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
                                <td>
  <input name="pers_id[]" type="hidden" id="pers_id-`+cvalue+`">
<input type="text" class="form-control" name="pers_name[]"  id="pers_name-`+cvalue+`"
                                           placeholder="Personel Adı Giriniz">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="tutar[]"  id="tutar-`+cvalue+`"
                                           placeholder="Tutar Giriniz">
                                </td>

                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);


        row = cvalue;

        $('#pers_name-'+cvalue).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/personel_ajax_search',
                    dataType: "json",
                    method: 'post',
                    data: 'paymethod='+$("#paymethod").val()+'&name_startsWith='+request.term+'&type=product_list&row_num=1&'+d_csrf,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var product_d = item[1];
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
                $('#tutar-'+cvalue).val(ui.item.data[0]);
                $('#pers_id-'+cvalue).val(ui.item.data[2]);
                $('#addproduct_talep').click();


            }
        });





    });

    var rowTotalSF = function (numb) {


        var amountVal = formInputGet("#amount", numb);

        var birim_1 = $("#price-"+numb+"-1").val();
        var birim_2 = $("#price-"+numb+"-2").val();
        var birim_3 = $("#price-"+numb+"-3").val();


        $("#product_tutar-"+numb+"-1").val(birim_1*amountVal);
        $("#product_tutar-"+numb+"-2").val(birim_2*amountVal);
        $("#product_tutar-"+numb+"-3").val(birim_3*amountVal);
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
