<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-6 cmp-pnl">
                                <div class="clientinfo">
                                    <div id="customer_company"><strong><?php echo customer_details($cari_id)['company']?></strong></div>
                                </div>
                                <div class="clientinfo">
                                    <div id="customer_address1"><strong><?php echo customer_details($cari_id)['address'] ?> <br><?php echo customer_details($cari_id)['city'].','.customer_details($cari_id)['country']?></strong></div>
                                </div>
                                <div class="clientinfo">
                                    <div type="text" id="customer_phone">Phone: <strong><?php echo customer_details($cari_id)['phone'] ?></strong><br>Email: <strong><?php echo customer_details($cari_id)['email']?></strong></div>
                                </div>
                                <hr>
                                <div class="clientinfo">
                                    <div type="text" id="customer_phone">Fatura Tipi:
                                        <strong>Alış Qaime Fakturası</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 cmp-pnl">
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"  class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Invoice #" name="invoice_no">
                                            <div class="input-group-addon"><i class="fa fa-file"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invoice_date"  class="caption">Fatura Tarihi</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control invoice_date" placeholder="Invoice #" name="invoicedate">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"><label for="invoice_date"  class="caption">Para Birimi</label>
                                        <div class="input-group">
                                            <select class="form-control para_birimi">
                                                <?php
                                                foreach (para_birimi() as $items){
                                                    $id=$items['id'];
                                                    $name=$items['code'];
                                                    $selected='';
                                                    if($id==$para_birimi){
                                                        $selected='selected';
                                                    }
                                                    echo "<option code='$name' $selected value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3"><label for="invoice_date"  class="caption">Çatdırılma T.</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control teslimat_tutar" value="<?php echo $teslimat_tutar?>">
                                            <input class="form-control teslimat_cemi_hidden" type="hidden" value="<?php echo $teslimat_tutar?>">
                                            <input class="form-control teslimat_edv_total_hidden" type="hidden" value="0">
                                            <input class="form-control teslimat_total_hidden" type="hidden" value="<?php echo $teslimat_tutar?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6"><label for="invoice_date"  class="caption">EDV</label>
                                        <div class="input-group">
                                            <select class="form-control edv_durum">
                                                <?php
                                                $edv_durum=$kdv;
                                                ?>
                                                <option <?php echo ($edv_durum)?'selected':''; ?> value='1'>Dahil</option>
                                                <option <?php echo (!$edv_durum)?'selected':''; ?> value='0'>Hariç</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"><label for="invoice_date"  class="caption">Ödeme Vade Tarihi</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control invoice_date" placeholder="Invoice #" name="invocieduedate">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="alt_cari_id" class="caption">Alt Firma</label>
                                        <div class="input-group">
                                            <select name="alt_cari_id" id="alt_cari_id" class="form-control select-box">
                                                <?php
                                                echo "<option value='0'>Seçiniz</option>";
                                                foreach (all_customer()  as $row) {
                                                    $cid = $row->id;
                                                    $title = $row->company;
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="alt_cari_id" class="caption">İskonto Tipi</label>
                                        <div class="input-group">
                                            <select class="form-control discount_type">
                                                <option code="%" <?php echo ($discount_type==2)?'selected':''; ?> value='2'>%</option>
                                                <option code="Float" <?php echo ($discount_type==1)?'selected':''; ?> value='1'>Float</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="alt_cari_id" class="caption">Ödeme Tipi</label>
                                        <div class="input-group">
                                            <select class="form-control method">
                                                <option value="0">Seçiniz</option>
                                                <?php
                                                $method_id=1;
                                                foreach (account_type() as $items){
                                                    $id=$items['id'];
                                                    $name=$items['name'];
                                                    $selected='';
                                                    if($id==$method_id){
                                                        $selected='selected';
                                                    }
                                                    echo "<option $selected value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 cmp-pnl">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>MALZEME</td>
                                        <td>Teklif Miktarı</td>
                                        <td>Vahid qiymət</td>
                                        <td>Endirim</td>
                                        <td>ƏDV Oran</td>
                                        <td>ƏDV</td>
                                        <td>Cemi</td>
                                        <td>ÜMUMI CƏMI</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    $eq=0;
                                    if(tehvil_products_cari($form_id,$cari_id)){
                                    foreach (tehvil_products_cari($form_id,$cari_id) as $items){

                                    $details_items = tehvil_products_cari_new($items->id);
                                    $product_name = product_name($items->product_id);
                                    $unit_name = units_($items->unit_id)['name'];

                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $product_name; ?></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$details_items->new_item_qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name ?></span></div></td>
                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->new_item_price'  class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->new_item_discount'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                    <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->new_item_kdv'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($details_items->new_item_edv_durum)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$details_items->new_item_edv_durum)?'selected':''; ?>  value="0">Haric</option></select></td>
                <td><input value="" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                <td><input value="" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                <input type="hidden" class="item_edvsiz_hidden" value="<?php echo $details_items->item_edvsiz_hidden?>">
                <input type="hidden" class="edv_tutari_hidden" value="<?php echo $details_items->edv_tutari_hidden?>">
                <input type="hidden" class="item_umumi_hidden" value="<?php echo $details_items->item_umumi_hidden?>">
                <input type="hidden" class="item_umumi_cemi_hidden" value="<?php echo $details_items->item_umumi_cemi_hidden?>">
                <input type="hidden" class="item_discount_hidden" value="<?php echo $details_items->item_discount_hidden?>">
                <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
                </tr>

                <?
                $i++;
                $eq++;

                }
                }
                                  ?>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8" style="text-align: end;font-weight: 600;">Cəmi:</td>
                                        <td style="font-weight: 600;"><span id="alt_sub_total">0 AZN</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: end;font-weight: 600;">Güzəşt:</td>
                                        <td style="font-weight: 600;"><span id="alt_discount_total">0 AZN</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: end;font-weight: 600;">ƏDV:</td>
                                        <td style="font-weight: 600;"><span id="alt_edv_total">0 AZN</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: end;font-weight: 600;">ümumi cəmi:</td>
                                        <td style="font-weight: 600;"><span id="alt_total">0 AZN</span></td>
                                    </tr>
                                    <input type="hidden" class="alt_sub_total_val">
                                    <input type="hidden" class="alt_discount_total_val">
                                    <input type="hidden" class="alt_edv_total_val">
                                    <input type="hidden" class="alt_total_val">
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="discount_type" value="2">
<input type="hidden" class="kdv_oran_details" value="1"8>
<input type="hidden" class="kdv_oran_details" value="1"8>

<style>
    .input-group-addon{
        border: 1px solid gray;
        border-left: none;
        border-radius: 0px 17px 16px 0px;
        padding: 13px 10px !important;
        font-size: 12px;
    }
</style>
<script>

    $(document).on('change','.para_birimi',function (){
        let para_birimi  =$('option:selected', '.para_birimi').attr('code');
        $('.item_para_birimi').empty().html(para_birimi)

    })
    $(document).on('change','.discount_type',function (){
        let discount_type  =$('option:selected', '.discount_type').attr('code');
        $('.item_discount_type').empty().html(discount_type)
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })
    $(document).on('change','.edv_durum',function (){
        let edv_durum  =$(this).val();
        $('.item_edv_durum').val(edv_durum)
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })

    function amount_max(element){
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }

    $(document).ready(function (){
       let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

        localStorage.clear();

    })


    $('.item_qty, .item_price, .item_discount, .item_kdv').keyup(function (){
        item_hesap($(this).attr('eq'))
    })

    $('.teslimat_tutar').keyup(function (){
        let teslimat_tutar = parseFloat($('.teslimat_tutar').val());
        let item_kdv = parseFloat($('.kdv_oran_details').val());
        let edv_durum = parseInt($('.edv_durum').val());
        let edv_tutari=0;
        let edvsiz=0;
        let cemi=0;
        let cemi_total=0;
        if(edv_durum)
        {
            edv_tutari = teslimat_tutar* (parseFloat(item_kdv)/100);
            cemi = teslimat_tutar-parseFloat(edv_tutari)
            cemi_total=cemi+edv_tutari;
        }
        else
        {
            edv_tutari = teslimat_tutar* (parseFloat(item_kdv)/100);
            cemi = teslimat_tutar-parseFloat(edv_tutari)
            cemi_total=teslimat_tutar;
        }


        $('.teslimat_cemi_hidden').val(cemi.toFixed(2));
        $('.teslimat_edv_total_hidden').val(edv_tutari.toFixed(2));
        $('.teslimat_total_hidden').val(cemi_total.toFixed(2));
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })

    $(document).on('change','.item_edv_durum',function (){
        let eq  =$('option:selected', '.item_edv_durum').attr('eq');
        item_hesap(eq);

    })

    function item_hesap(eq){
        let discount_type= $('.discount_type').val();
        let item_qty= $('.item_qty').eq(eq).val();
        let item_price= $('.item_price').eq(eq).val();
        let item_discount= $('.item_discount').eq(eq).val();
        let item_kdv= $('.item_kdv').eq(eq).val();
        let edv_durum = parseInt($('.item_edv_durum').eq(eq).val());
        let cemi = parseFloat(item_qty)*parseFloat(item_price);

        let edvsiz=0;
        let edv_tutari=0;
        let discount=0;
        let item_umumi_cemi = cemi;


        if(item_discount){

            if(discount_type==2){
                discount = cemi * (parseFloat(item_discount)/100);
                item_umumi_cemi = cemi * (100 - parseFloat(item_discount)) / 100
            }
            else {
                item_umumi_cemi = cemi-parseFloat(item_discount)
                discount=parseFloat(item_discount)
            }


        }

        if(edv_durum){
            edv_tutari = item_umumi_cemi* (parseFloat(item_kdv)/100);
            edvsiz = cemi-parseFloat(edv_tutari)

        }
        else {
            edv_tutari = item_umumi_cemi* (parseFloat(item_kdv)/100);
            item_umumi_cemi=item_umumi_cemi-parseFloat(edv_tutari);
            cemi = cemi-parseFloat(edv_tutari)
            edvsiz=cemi;
        }



        $('.item_edvsiz_hidden').eq(eq).val(edvsiz.toFixed(2));
        $('.edv_tutari_hidden').eq(eq).val(edv_tutari.toFixed(2));

        $('.item_discount_hidden').eq(eq).val(discount.toFixed(2));

        $('.item_umumi').eq(eq).val(cemi.toFixed(2));
        $('.item_umumi_hidden').eq(eq).val(cemi.toFixed(2));

        $('.item_umumi_cemi').eq(eq).val(item_umumi_cemi.toFixed(2));
        $('.item_umumi_cemi_hidden').eq(eq).val(item_umumi_cemi.toFixed(2));

        total_hesapla();


    }

    function total_hesapla(){

        let cemi_total = 0;
        let cemi_umumi_total = 0;
        let item_discount_total = 0;
        let item_edvsiz_total = 0;
        let edv_tutari_total = 0;
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            cemi_total +=parseFloat($('.item_umumi_cemi_hidden').eq(i).val());
            cemi_umumi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
            item_discount_total +=parseFloat($('.item_discount_hidden').eq(i).val());
            item_edvsiz_total +=parseFloat($('.item_edvsiz_hidden').eq(i).val());
            edv_tutari_total +=parseFloat($('.edv_tutari_hidden').eq(i).val());
        }


        let para_birimi  =$('option:selected', '.para_birimi').attr('code');



       let teslimat_cemi_hidden=  parseFloat($('.teslimat_cemi_hidden').val());
       let teslimat_edv_total_hidden=  parseFloat($('.teslimat_edv_total_hidden').val());
       let teslimat_total_hidden=  parseFloat($('.teslimat_total_hidden').val());

        item_edvsiz_total=item_edvsiz_total+teslimat_cemi_hidden;
        edv_tutari_total=edv_tutari_total+teslimat_edv_total_hidden;
        cemi_umumi_total=cemi_umumi_total+teslimat_total_hidden;

        $('#alt_sub_total').empty().text(item_edvsiz_total.toFixed(2)+' '+para_birimi)
        $('.alt_sub_total_val').val(item_edvsiz_total.toFixed(2));

        $('#alt_total').empty().text(cemi_umumi_total.toFixed(2)+' '+para_birimi)
        $('.alt_total_val').val(cemi_umumi_total.toFixed(2));

        $('#alt_discount_total').empty().text(item_discount_total.toFixed(2)+' '+para_birimi)
        $('.alt_discount_total_val').val(item_discount_total.toFixed(2));

        $('#alt_edv_total').empty().text(edv_tutari_total.toFixed(2)+' '+para_birimi)
        $('.alt_edv_total_val').val(edv_tutari_total.toFixed(2));
    }

    $(document).on('click','.guncelle',function (){
        let method = $('.method').val();
        if(parseInt(method)){
            let product_details=[];
            let count = $('.item_qty').length;
            for (let i=0; i < count; i++){
               product_details.push({
                  'item_id':$('.item_id').eq(i).val(),
                  'item_qty':$('.item_qty').eq(i).val(),
                  'item_price':$('.item_price').eq(i).val(),
                  'item_kdv':$('.item_kdv').eq(i).val(),
                  'item_discount':$('.item_discount').eq(i).val(),
                  'item_edvsiz':$('.item_edvsiz_hidden').eq(i).val(),
                  'edv_tutari':$('.edv_tutari_hidden').eq(i).val(),
                  'item_umumi':$('.item_umumi_hidden').eq(i).val(),
                  'item_umumi_cemi':$('.item_umumi_cemi_hidden').eq(i).val(),
                  'item_discount_umumi':$('.item_discount_hidden').eq(i).val(),
                  'item_desc':$('.item_desc').eq(i).val(),
               });
            }
            $('#loading-box').removeClass('d-none');
            let data = {
                teklif_id : $('#teklif_id').val(),
                cari_id : $('#cari_id').val(),
                form_id : $('#form_id').val(),
                discount_type : $('.discount_type').val(),
                teslimat : $('.teslimat').val(),
                teslimat_tutar : $('.teslimat_tutar').val(),
                edv_durum : $('.edv_durum').val(),
                para_birimi : $('.para_birimi').val(),
                alt_sub_total_val : $('.alt_sub_total_val').val(),
                alt_total_val : $('.alt_total_val').val(),
                alt_discount_total_val : $('.alt_discount_total_val').val(),
                alt_edv_total_val : $('.alt_edv_total_val').val(),
                method : method,
                product_details:product_details,
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'malzemetalep/teklif_update',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Güncellendi!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue'
                            }
                        }
                    });
                }
                else {
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Hata Aldınız!',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            });
        }
        else {
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                title: 'Dikkat!',
                content: 'Ödeniş Metodu Seçmelisiniz',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })


    $('.clickable').click(function (e) {

        let total = 0;
        var clickID     = $(this).data('click');
        var radioButton = '.radio_'+clickID;
        var price       = $(this).attr('azn_tutar_float');
        var talep_form_teklifler_item_details_id = $(this).attr('talep_form_teklifler_item_details_id');
        var miktar       = $(this).attr('miktar');
        var index       = $(this).attr('index');

        var cell = $(e.target).get(0);
        var $this = this;
        $('.crload_'+clickID).html('<i class="fa fa-spinner fa-spin"></i>');

        if($(radioButton).is(":checked")){
            $(radioButton).prop("checked", false);

            var c = $(cell).parents('tr').children('td');
            $(c).each(function () {
                //$(c).removeClass('info');
                $(c).removeClass('select-border');
                $(c).find('.fa-check').removeClass('fa fa-check');
            });
            $('.crload_'+clickID).html('');



        }else{
            $(radioButton).prop("checked", true);
            var c = $(cell).parents('tr').children('td');
            $(c).each(function () {
                //$(c).removeClass('info');
                $(c).removeClass('select-border');
                $(c).find('.fa-check').removeClass('fa fa-check');
            });

            $($this).addClass('select-border');
            $('.crload_'+clickID).html('<i class="fa fa-check fa-2x"></i>');






        }

        let filteredSerial=[];

        filteredSerial.push({
            id: parseInt(clickID),
            price: price,
            index: parseInt(index),
            miktar: parseFloat(miktar),
            talep_form_teklifler_item_details_id: parseInt(talep_form_teklifler_item_details_id),
            total: parseFloat(miktar)*parseFloat(price),
        });


        let _serials = localStorage.getItem('product_serial');

        _serials = JSON.parse(_serials);

        if(_serials){
            let _filtered = filteredSerial[0];
            let otherRows = $.grep(_serials, function( item ) {
                return item.index !== _filtered.index;
            });
            otherRows.push(_filtered);

            localStorage.setItem('product_serial',JSON.stringify(otherRows));
        }
        else{
            localStorage.setItem('product_serial',JSON.stringify(filteredSerial));
        }


        let _serials_new = localStorage.getItem('product_serial');

        _serials_new = JSON.parse(_serials_new);
        total_price=0;
        if(_serials_new){
            for(let j=0; j<_serials_new.length;j++){
                total_price+=parseFloat(_serials_new[j].total);
            }
        }
        else {
            total_price=parseFloat(total);
        }



        let cur_price = currencyFormat(floatVal(total_price))
        $('#secilen_tutar').empty().text(cur_price);

        //console.log('materialID:'+materialID+'\nactionID:'+actionID+'\nrequestID:'+requestID+'\ncompareID:'+compareID+'\nofrReqID:'+ofrReqID+'\nquantity:'+quantity);

    });

    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }


</script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/talep.css">

