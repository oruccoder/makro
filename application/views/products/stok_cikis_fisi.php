<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">


                    <div class="col-sm-12 cmp-pnl">


                        <div class="inner-cmp-pnl">


                            <div class="form-group row">

                                <div class="col-sm-2"><label for="fis_no"
                                                             class="caption"><?php echo $this->lang->line('fis_type') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <?php if(isset($stok_cikis['type']))
                                        {
                                            if($stok_cikis['type']==2)
                                            {
                                                ?>
                                                <select class="form-control" name="type" id="invoice_type">
                                                    <option selected value="2">Stok Giriş Fişi</option>
                                                    <option value="1">Stok Çıkış Fişi</option>
                                                </select>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <select class="form-control" name="type" id="invoice_type">
                                                    <option  value="2">Stok Giriş Fişi</option>
                                                    <option selected value="1">Stok Çıkış Fişi</option>
                                                </select>
                                                <?php
                                            }
                                        } else { ?>
                                            <select class="form-control" name="type" id="invoice_type">
                                                <option value="2">Stok Giriş Fişi</option>
                                                <option value="1">Stok Çıkış Fişi</option>
                                            </select>
                                        <?php } ?>
                                    </div>
                                </div>


                                <div class="col-sm-2"><label for="fis_name"
                                                             class="caption"><?php echo $this->lang->line('fis_name'); ?></label>

                                    <div class="input-group">

                                        <input type="hidden" class="form-control " placeholder="Fiş #"
                                               name="fis_no"
                                               value="<?php echo isset($stok_cikis['fis_no'])?$stok_cikis['fis_no']:numaric(9) ?>">
                                        <input type="text" class="form-control  required" placeholder="Fiş Adı" id="fis_name"
                                               name="fis_name" autocomplete="false" value="<?php echo isset($stok_cikis['fis_name'])?$stok_cikis['fis_name']:'' ?>">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="invoice_para_birimi" class="caption"><?php echo $this->lang->line('Warehouse'); ?></label>
                                    <select id="warehouses" name="warehouses" class="selectpicker form-control ">

                                        <?php foreach ($warehouse as $row) {

                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            if($stok_cikis['warehouse_id']==$cid)
                                            {
                                                echo "<option selected value='$cid'>$title</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='$cid'>$title</option>";
                                            }

                                        } ?>

                                    </select>
                                </div>


                                <div class="col-sm-1">
                                    <label for="customer_name"class="caption">Cari Tipi</label>
                                    <select class="form-control " id="cari_type" name="cari_type">

                                        <?php
                                        if(isset($stok_cikis['customer_type']))
                                        {


                                            if($stok_cikis['customer_type']==1){ ?>
                                                <option selected value="1">Cari</option>
                                                <option value="2">Proje</option>
                                            <?php } else if($stok_cikis['customer_type']==2)
                                            {
                                                ?>
                                                <option  value="1">Cari</option>
                                                <option selected value="2">Proje</option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <option  value="1">Cari</option>
                                            <option  value="2">Proje</option>
                                            <?php
                                        } ?>
                                    </select>

                                </div>


                                <div class="col-sm-2">
                                    <label for="customer_name"class="caption">Cari / Proje Bul</label>



                                    <?php
                                    $name='';
                                    if($stok_cikis){

                                        if($stok_cikis['customer_type']==1)
                                        {
                                            $name=customer_details($stok_cikis['customer_id'])['company'];
                                        }
                                        else {
                                            $name=proje_name($stok_cikis['customer_id']);
                                        }

                                    }?>

                                    <input type="text" class="form-control " name="customer" id="customer_fis"
                                           placeholder="Cari / Proje" value="<?php echo $name ?>"
                                           autocomplete="off"/>

                                    <div id="customer-box-result"></div>

                                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo  isset($stok_cikis['customer_id'])?$stok_cikis['customer_id']:'' ?>">

                                </div>

                                <input type="hidden" name="sorumlu_pers_id" value="<?php echo  isset($stok_cikis['sorumlu_pers_id'])?$stok_cikis['sorumlu_pers_id']:$this->aauth->get_user()->id ?>">


                                <div class="col-sm-2"><label for="fis_date"
                                                             class="caption"><?php echo $this->lang->line('fis_date'); ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                             aria-hidden="true"></span></div>

                                        <?php if(isset($stok_cikis['fis_date'])) {?>
                                            <input type="text" class="form-control  required"
                                                   placeholder="Fiş Tarihi" name="fis_date" value="<?php echo isset($stok_cikis['fis_date'])?dateformat($stok_cikis['fis_date']):'' ?>"
                                            >

                                        <?php } else { ?>
                                            <input type="text" class="form-control  required"
                                                   placeholder="Fiş Tarihi" name="fis_date"
                                                   data-toggle="datepicker"
                                            >
                                        <?php } ?>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group row">



                                <!-- Araç Bilgileri -->





                                <div class="col-sm-2"><label for="plaka_no"
                                                             class="caption"><?php echo $this->lang->line('plaka_no') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Plaka "
                                               name="plaka_no" value="<?php if(isset($stok_cikis['plaka_no']) )echo $stok_cikis['plaka_no'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-2"><label for="sofor_name"
                                                             class="caption"><?php echo $this->lang->line('sofor_name') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Şöför Adı"
                                               name="sofor_name"  value="<?php if(isset($stok_cikis['sofor_name'])) echo $stok_cikis['sofor_name'];?>" >
                                    </div>
                                </div>
                                <div class="col-sm-2"><label for="sofor_tel"
                                                             class="caption"><?php echo $this->lang->line('sofor_tel') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Şöför Telefonu"
                                               name="sofor_tel"  value="<?php if(isset($stok_cikis['sofor_tel'])) echo $stok_cikis['sofor_tel'];?>" >
                                    </div>
                                </div>




                                <!-- Araç Bilgileri -->

                                <div class="col-sm-1"><label for="Stok Durumu"
                                                             class="caption">Stok Güncelle</label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <?php $che=''; if(isset($stok_cikis['stok_guncelleme']))
                                        {
                                            if($stok_cikis['stok_guncelleme']==1)
                                            {
                                                $che="checked";
                                            }
                                            else {
                                                $che="";
                                            }


                                        }
                                        ?>
                                        <input type="checkbox" <?php echo $che;?> class="form-control" name="stok_durumu">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label for="fis_note"
                                           class="caption"><?php echo $this->lang->line('fis_note') ?></label>
                                    <textarea class="form-control " name="fis_note"  rows="2"><?php echo isset($stok_cikis['fis_note'])?$stok_cikis['fis_note']:'' ?></textarea>
                                </div>


                            </div>

                        </div>
                    </div>



                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">

                            <thead>
                            <tr class="item_header -directional-light-blue">
                                <th class="proje_hid text-center">Bölüm</th>
                                <th class="proje_hid text-center">Asama</th>
                                <th class="proje_hid text-center">Alt Asama</th>
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('unit') ?></th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php

                            if($products!=''){
                                $i=0;
                                foreach ($products as $prd){

                                    ?>

                                    <tr>
                                        <td class="proje_hid">
                                            <input type="text" class="form-control text-center bolum" name="bolum[]" id="bolum-<?php echo $i; ?>"  value="<?php echo bolum_getir($prd->bolum_id) ?>"
                                                   placeholder="<?php echo $this->lang->line('proje_yerleri') ?>" >
                                            <input type="hidden" name="bolum_id[]" id="bolum_id_val-<?php echo $i; ?>" value="<?php echo $prd->bolum_id ?>">
                                        </td>
                                        <td class="proje_hid"><input type="text" class="form-control text-center asama" name="bagli_oldugu_asama[]"  id="bagli_oldugu_asama-<?php echo $i; ?>" value=""
                                                                     placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >
                                            <input type="hidden" name="bagli_oldugu_asama_id_val[]" id="bagli_oldugu_asama_id_val-<?php echo $i; ?>" value="">
                                        </td>
                                        <td class="proje_hid"><input type="text" class="form-control text-center asama" name="asama[]"  id="asama-<?php echo $i; ?>" value="<?php echo task_to_asama($prd->asama_id)?>"
                                                                     placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >
                                            <input type="hidden" name="asama_id[]" id="asama_id_val-<?php echo $i; ?>" value="<?php echo $prd->asama_id ?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control text-center"  value="<?php echo $prd->product ?>"
                                            <input type="hidden"  name="product_name[]" value="<?php echo $prd->product ?>"
                                                   placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-<?php echo $i; ?>'>
                                        </td>
                                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="product_qty-<?php echo $i; ?>"
                                                   onkeypress="return isNumber(event)"
                                                   autocomplete="off" value="<?php echo $prd->qty ?>"><input type="hidden" id="alert-<?php echo $i; ?>" value="<?php echo stok_ogren($prd->pid,$prd->depo_id) ?>" name="alert[]"> </td>
                                        <td><input type="text" class="form-control req unt" id="stok_fis_unit-<?php echo $i; ?>"
                                                   onkeypress="return isNumber(event)" value="<?php echo units_($prd->unit)['name'] ?>"
                                                   autocomplete="off">
                                            <input type="hidden" name="product_unit[]"  value="<?php echo $prd->unit ?>" id="unit-<?php echo $i; ?>"

                                        </td>

                                        <input type="hidden" class="pdIn" name="pid[]" id="pid-<?php echo $i; ?>" value="<?php echo $prd->pid ?>">
                                        <input type="hidden" name="old_product_qty[]" value="<?php echo $prd->qty ?>">
                                        <input type="hidden" name="hsn[]" id="hsn-<?php echo $i; ?>" value="">
                                        <td class="text-center"><button type="button" data-rowid='<?php echo $i; ?>' class="btn btn-danger removeProd"
                                                                        title="Remove" ><i class="fa fa-minus-square"></i> </button> </td>
                                    </tr>



                                    <?php  $i++; }

                            } else { ?>
                                <tr>
                                    <td class="proje_hid"><input type="text" class="form-control text-center bolum" name="bolum[]" id="bolum-0"
                                                                 placeholder="<?php echo $this->lang->line('proje_yerleri') ?>" >
                                        <input type="hidden" name="bolum_id[]" id="bolum_id_val-0">
                                    </td>
                                    <td class="proje_hid"><input type="text" class="form-control text-center asama" name="bagli_oldugu_asama[]"  id="bagli_oldugu_asama-0"
                                                                 placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >
                                        <input type="hidden" name="bagli_oldugu_asama_id_val[]" id="bagli_oldugu_asama_id_val-0">
                                    </td>
                                    <td class="proje_hid"><input type="text" class="form-control text-center asama" name="asama[]"  id="asama-0"
                                                                 placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >
                                        <input type="hidden" name="asama_id[]" id="asama_id_val-0">
                                    </td>
                                    <td><input type="text" class="form-control text-center" name="product_name[]"
                                               placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0'>
                                    </td>
                                    <td><input type="text" class="form-control req amnt" name="product_qty[]" id="product_qty-0"
                                               onkeypress="return isNumber(event)"
                                               autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                    <td><input type="text" class="form-control req unt" id="stok_fis_unit-0"
                                               onkeypress="return isNumber(event)"
                                               autocomplete="off">
                                        <input type="hidden" name="product_unit[]" id="unit-0"
                                    </td>
                                    <td class="text-center"><button type="button" data-rowid='0' class="btn btn-danger removeProd"
                                                                    title="Remove" ><i class="fa fa-minus-square"></i> </button> </td>

                                    <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="3">
                                    <input type="hidden" name="hsn[]" id="hsn-0" value="">

                                </tr>
                            <?php } ?>





                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            id="addProductFis">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">

                                <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn btn-lg"
                                                                     value="<?php echo isset($id)?$this->lang->line('edit_fis'):$this->lang->line('save_fis'); ?> "
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>

                            </tbody>

                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <?php if(isset($id)){ ?>
                        <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
                        <input type="hidden" value="products/stok_cikis_save?id=<?php echo $id ?>" id="action-url">
                    <?php } else { ?>
                        <input type="hidden" value="products/stok_cikis_save" id="action-url">
                        <input type="hidden" value="0" name="counter" id="ganak">
                    <?php } ?>
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="search_newproducts" id="billtype2">


                </form>
            </div>
        </div>

    </div>
</div>

<style>
    .proje_hid
    {
        display: none;
    }
</style>
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


    $('#addProductFis').on('click', function () {


        var data='';
        var cvalue = parseInt($('#ganak').val())+1;
        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;

        var cari_type=$('#cari_type').val();
        if(cari_type==2)
        {
            data = '<tr><td class="proje_hid"><input type="text" class="form-control text-center bolum" name="bolum[]" id="bolum-' + cvalue + '"'+
                'placeholder="<?php echo $this->lang->line('proje_yerleri') ?>" >'+
                '<input type="hidden" name="bolum_id[]" id="bolum_id_val-' + cvalue + '">'+
                '</td>'+
                ' <td class="proje_hid"><input type="text" class="form-control text-center asama" name="bagli_oldugu_asama[]"  id="bagli_oldugu_asama-' + cvalue + '"'+
                ' placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >'+
                '   <input type="hidden" name="bagli_oldugu_asama_id_val[]" id="bagli_oldugu_asama_id_val-' + cvalue + '">'+
                '</td>'+
                ' <td class="proje_hid"><input type="text" class="form-control text-center asama" name="asama[]"  id="asama-' + cvalue + '"'+
                'placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >'+
                '<input type="hidden" name="asama_id[]" id="asama_id_val-' + cvalue + '">'+
                ' </td>'+
                '<td><input type="text" class="form-control text-center" name="product_name[]" ' +
                'placeholder="Ürün Adını veya Kodunu Giriniz" id="productnames-' + cvalue + '"></td><td>' +
                '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
                'id="product_qty-' + cvalue + '" onkeypress="return isNumber(event)" autocomplete="off"' +
                ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
                'class="form-control req unt" id="stok_fis_unit-' + cvalue + '" onkeypress="return isNumber(event)" ' +
                'autocomplete="off"><input type="hidden"  name="product_unit[]" id="units-' + cvalue + '"></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td>' +
                '<input type="hidden" name="fire[]" id="fire-' + cvalue + '" value="0">' +
                '<input type="hidden" name="fire_quantity[]" id="fire_quantity-' + cvalue + '" value="0">' +
                '<input type="hidden"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
                '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
                '</tr>';
        }
        else if(cari_type==1)
        {
            data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
                'placeholder="Ürün Adını veya Kodunu Giriniz" id="productnames-' + cvalue + '"></td><td>' +
                '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
                'id="product_qty-' + cvalue + '" onkeypress="return isNumber(event)" autocomplete="off"' +
                ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
                'class="form-control req unt" id="stok_fis_unit-' + cvalue + '" onkeypress="return isNumber(event)" ' +
                'autocomplete="off"><input type="hidden"  name="product_unit[]" id="units-' + cvalue + '"></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td>' +
                '<input type="hidden" name="fire[]" id="fire-' + cvalue + '" value="0">' +
                '<input type="hidden" name="fire_quantity[]" id="fire_quantity-' + cvalue + '" value="0">' +
                '<input type="hidden"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
                '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
                '</tr>';
        }

//product row

        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);
        if(cari_type==2)
        {
            $('.proje_hid').css('display','table-cell')
        }
        else if(cari_type==1)
        {
            $('.proje_hid').css('display','none')
        }


        row = cvalue;

        var invoice_type=$("#invoice_type").val();

        $('#productnames-' + cvalue).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type='+invoice_type+'&name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid='+$("#warehouses option:selected").val()+'&'+d_csrf,
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

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var punit=ui.item.data[9];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];

                $('#amount-' + id[1]).val(1);
                $('#price-' + id[1]).val(price);
                $('#pid-' + id[1]).val(pid);
                $('#vat-' + id[1]).val(t_r);
                $('#discount-' + id[1]).val(discount);
                $('#dpid-' + id[1]).val(dpid);
                $('#units-' + id[1]).val(unit);
                $('#stok_fis_unit-' + id[1]).val(punit);
                $('#hsn-' + id[1]).val(hsn);
                $('#alert-' + id[1]).val(alert);
                rowTotal(cvalue);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('#bolum-' + cvalue).autocomplete({
            source: function (request, response) {
                $('#bagli_oldugu_asama-'+ cvalue).val('');
                $('#asama-'+ cvalue).val('');
                $('#bagli_oldugu_asama_id_val-'+ cvalue).val(0);
                $('#asama_id_val-'+ cvalue).val(0);
                $('#product_name-'+ cvalue).val('');
                var proje_id=$('#customer_id').val()
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
                var proje_id=$('#customer_id').val()
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
                var proje_id=$('#customer_id').val()
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


        var sideh2 = document.getElementById('rough').scrollHeight;
        var opx3 = sideh2 + 50;
        document.getElementById('rough').style.height = opx3 + "px";



    });

    $("#customer_fis").keyup(function () {

        var cari_type=$('#cari_type').val();
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchfis',
            data: 'keyword=' + $(this).val() +'&'+'cari_type=' + cari_type+'&'+crsf_token+'='+crsf_hash,
            beforeSend: function () {
                $("#customer_fis").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer_fis").css("background", "none");

            }
        });
    });

    $("#cari_type").change(function () {

        var cari_type=$('#cari_type').val();
        if(cari_type==2)
        {
            $('.proje_hid').css('display','table-cell')
        }
        else if(cari_type==1)
        {
            $('.proje_hid').css('display','none')
        }
    });

    function selectCustomerFis(cid, company) {

        $('#customer_id').val(cid);
        $('#customer_fis').val(company);
        $("#customer-box-result").hide();


    }




    $(document).ready(function () {
        var cari_type=$('#cari_type').val();
        if(cari_type==2)
        {
            $('.proje_hid').css('display','table-cell')
        }
        else if(cari_type==1)
        {
            $('.proje_hid').css('display','none')
        }

        var cvalue = parseInt($('#ganak').val()) + 1;

        row = cvalue;

        var invoice_type = $("#invoice_type").val();

        $('.product_name').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#warehouses option:selected").val() + '&' + d_csrf,
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
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price = ui.item.data[1];
                var pid = ui.item.data[2];
                var dpid = ui.item.data[5];
                var punit=ui.item.data[9];
                var unit = ui.item.data[6];
                var hsn = ui.item.data[7];
                var alert = ui.item.data[8];

                $('#amount-' + id[1]).val(1);
                $('#price-' + id[1]).val(price);
                $('#pid-' + id[1]).val(pid);
                $('#vat-' + id[1]).val(t_r);
                $('#discount-' + id[1]).val(discount);
                $('#dpid-' + id[1]).val(dpid);
                $('#units-' + id[1]).val(unit);
                $('#stok_fis_unit-' + id[1]).val(punit);
                $('#hsn-' + id[1]).val(hsn);
                $('#alert-' + id[1]).val(alert);
                rowTotal(cvalue);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('#bolum-0').autocomplete({
            source: function (request, response) {
                $('#bagli_oldugu_asama-0').val('');
                $('#asama-0').val('');
                $('#bagli_oldugu_asama_id_val-0').val(0);
                $('#asama_id_val-0').val(0);
                $('#product_name-0').val('');
                var proje_id=$('#customer_id').val()
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
                $('#bolum_id_val-0').val(bolum_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });
        $('#asama-0').autocomplete({
            source: function (request, response) {
                var proje_id=$('#customer_id').val()
                var bolum_id=$('#bolum_id_val-0').val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-0').val()
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
                $('#asama_id_val-0').val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });
        $('#bagli_oldugu_asama-0').autocomplete({
            source: function (request, response) {
                var proje_id=$('#customer_id').val()
                var bolum_id=$('#bolum_id_val-0').val()
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
                $('#bagli_oldugu_asama_id_val-0').val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

    });







</script>
