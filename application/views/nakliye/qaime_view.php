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
                                    <input type="hidden" class="csd" value="<?php echo $cari_id?>">
                                </div>
                                <div class="clientinfo">
                                    <div id="customer_address1"><strong><?php echo customer_details($cari_id)['address'] ?> <br><?php echo customer_details($cari_id)['city'].','.customer_details($cari_id)['country']?></strong></div>
                                </div>
                                <div class="clientinfo">
                                    <div type="text" id="customer_phone">Phone: <strong><?php echo customer_details($cari_id)['phone'] ?></strong><br>Email: <strong><?php echo customer_details($cari_id)['email']?></strong></div>
                                </div>
                                <hr>
                                <div class="clientinfo">
                                    <div type="text" id="invoice_type">Fatura Tipi:
                                        <select class="invoice_type form-control">
                                            <option value="2">ALIŞ QAİMƏ FAKTURASI</option>
                                            <option value="38">ALIŞ</option>
                                            <option selected value="24">GİDER QAİMƏ FAKTURASI</option>
                                            <option value="41">GİDER</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6 cmp-pnl">
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"  class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control invoice_no" placeholder="Invoice #" name="invoice_no">
                                            <div class="input-group-addon"><i class="fa fa-file"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invoice_date"  class="caption">Fatura Tarihi</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control invoicedate" placeholder="Invoice #" name="invoicedate">
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
                                                    if($id==1){
                                                        $selected='selected';
                                                    }
                                                    echo "<option code='$name' $selected value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3"><label for="invoice_date"  class="caption">Çatdırılma T.</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control teslimat_tutar" value="0">
                                            <input class="form-control teslimat_cemi_hidden" type="hidden" value="0">
                                            <input class="form-control teslimat_edv_total_hidden" type="hidden" value="0">
                                            <input class="form-control teslimat_total_hidden" type="hidden" value="0">
                                        </div>
                                    </div>

                                    <div class="col-sm-6"><label for="invoice_date"  class="caption">EDV</label>
                                        <div class="input-group">
                                            <select class="form-control edv_durum">
                                                <?php
                                                $edv_durum=0;
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
                                            <input type="date" class="form-control invoiceduedate" placeholder="Invoice #" name="invoiceduedate">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="alt_cari_id" class="caption">Alt Firma</label>
                                        <div class="input-group">
                                            <select name="alt_cari_id" id="alt_cari_id" class="form-control select-box alt_cari_id">
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
<!--                                    <div class="col-sm-3">-->
<!--                                        <label for="alt_cari_id" class="caption">İskonto Tipi</label>-->
<!--                                        <div class="input-group">-->
<!--                                            <select class="form-control discount_type">-->
<!--                                                <option code="%" --><?php //echo ($discount_type==2)?'selected':''; ?><!-- value='2'>%</option>-->
<!--                                                <option code="Float" --><?php //echo ($discount_type==1)?'selected':''; ?><!-- value='1'>Float</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <div class="col-sm-3">
                                        <label for="alt_cari_id" class="caption">Ödeme Tipi</label>
                                        <div class="input-group">
                                            <select class="form-control method">
                                                <option value="0">Seçiniz</option>
                                                <?php
                                                foreach (account_type() as $items){
                                                    $id=$items['id'];
                                                    $name=$items['name'];
                                                    $selected='';
                                                    if($id==3){
                                                        $selected='selected';
                                                    }
                                                    echo "<option $selected value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="alt_cari_id" class="caption">Açıklama</label>
                                        <div class="input-group">
                                            <textarea class="form-control description" name="description" id="description"></textarea>
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
                                        <td>Tehvil Miktarı</td>
                                        <td>Vahid qiymət</td>
                                        <td>Endirim</td>
                                        <td>ƏDV Oran</td>
                                        <td>ƏDV</td>
                                        <td>Cemi (EDVSİZ)</td>
                                        <td>ÜMUMI CƏMI (EDVSİZ)</td>
                                        <td>Durum</td>
                                    </tr>
                                    </thead>
                                    <tbody class="item_tbody">

                                    <?php $eq=0; ?>
                                    <tr>
                                        <td>1</td>
                                        <td>LOJISTIK GIDERLERI -> YÜK DASIMA XIDMETI</td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='1' class='form-control item_qty_qaimt'>" ?><span class="input-group-addon font-xs text-right">Adet</span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='0'  class='form-control item_price_qaimt'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='0'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='18'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                        <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo (0)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!0)?'selected':''; ?>  value="0">Haric</option></select></td>
                                        <td><input value="" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                        <td><input value="" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>

                                        <input type="hidden" class="item_edvsiz_hidden" value="0">
                                        <input type="hidden" class="item_edvsiz_hidden_price" value="0">
                                        <input type="hidden" class="edv_tutari_hidden" value="0">
                                        <input type="hidden" class="item_umumi_hidden" value="0">
                                        <input type="hidden" class="item_umumi_cemi_hidden" value="0">
                                        <input type="hidden" class="item_discount_hidden" value="0">
                                        <input type="hidden" value="756" class="item_product_id">
                                        <input type="hidden" value="9" class="item_unit_id">
                <td>-</td>
                                    </tr>

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
                                        <td colspan="8" style="text-align: end;font-weight: 600;">Net Cemi:</td>
                                        <td style="font-weight: 600;"><span id="net_cemi_total">0 AZN</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: end;font-weight: 600;">ƏDV:</td>
                                        <td style="font-weight: 600;"><span id="alt_edv_total">0 AZN</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: end;font-weight: 600;">ümumi cəmi:</td>
                                        <td style="font-weight: 600;"><span id="alt_total">0 AZN</span></td>
                                    </tr>
                                    <input type="hidden" class="alt_net_cemi_total">
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
<input type="hidden" class="kdv_oran_details" value="1">

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


    $(document).on('click','.remove_qaime',function (){
        let item_id =$(this).attr('item_id');
        let remove = '#removeqaime'+item_id;
        $(remove).remove();
    })

    $(document).on('change','.para_birimi',function (){
        let para_birimi  =$('option:selected', '.para_birimi').attr('code');
        $('.item_para_birimi').empty().html(para_birimi)

    })
    $(document).on('change','.discount_type',function (){
        let discount_type  =$('option:selected', '.discount_type').attr('code');
        $('.item_discount_type').empty().html(discount_type)
        let count = $('.item_qty_qaimt').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })
    $(document).on('change','.edv_durum',function (){
        let edv_durum  =$(this).val();
        $('.item_edv_durum').val(edv_durum)
        let count = $('.item_qty_qaimt').length;
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
        let count = $('.item_qty_qaimt').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

        localStorage.clear();

    })


    $('.item_qty_qaimt, .item_price_qaimt, .item_discount, .item_kdv').keyup(function (){
        item_hesap($(this).attr('eq'))
    })


    $(document).on('change','.item_edv_durum',function (){
        let eq  =$('option:selected', '.item_edv_durum').attr('eq');
        item_hesap(eq);

    })

    function item_hesap(eq){
        let discount_type= $('.discount_type').val();
        let item_qty_qaimt= $('.item_qty_qaimt').eq(eq).val();
        let item_price_qaimt= $('.item_price_qaimt').eq(eq).val();
        let item_discount= $('.item_discount').eq(eq).val();
        let item_kdv= $('.item_kdv').eq(eq).val();
        let edv_durum = parseInt($('.item_edv_durum').eq(eq).val());

        //let item_edvsiz = item_price_qaimt/(1+(item_kdv/100));
        let item_edvsiz = item_price_qaimt;
        let cemi = parseFloat(item_qty_qaimt)*parseFloat(item_edvsiz);

        let edvsiz=0;
        let edvsiz_item=0;
        let edv_tutari=0;
        let edv_tutari_price=0;
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


            cemi = cemi / (1+ (parseFloat(item_kdv)/100));
            edv_tutari = cemi *(parseFloat(item_kdv)/100);
            edv_tutari_price = cemi * (parseFloat(item_kdv)/100);

            // edv_tutari = item_umumi_cemi * (parseFloat(item_kdv)/100);
            // edvsiz = cemi-parseFloat(edv_tutari)
            //
            // edv_tutari_price = item_price_qaimt* (parseFloat(item_kdv)/100);

        }
        else {


            edv_tutari = item_umumi_cemi *(parseFloat(item_kdv)/100);


            //
            // edv_tutari = item_umumi_cemi * (parseFloat(item_kdv)/100);
            // item_umumi_cemi=item_umumi_cemi+parseFloat(edv_tutari);
            // cemi = cemi-parseFloat(edv_tutari)
            // edvsiz=cemi;

            edv_tutari_price = 0;
        }


        edvsiz_item = item_price_qaimt-edv_tutari_price;

        $('.item_edvsiz_hidden').eq(eq).val(edvsiz.toFixed(4));
        $('.item_edvsiz_hidden_price').eq(eq).val(edvsiz_item.toFixed(4));


        $('.edv_tutari_hidden').eq(eq).val(edv_tutari.toFixed(4));

        $('.item_discount_hidden').eq(eq).val(discount.toFixed(4));

        $('.item_umumi').eq(eq).val(cemi.toFixed(4));
        $('.item_umumi_hidden').eq(eq).val(cemi.toFixed(4));

        $('.item_umumi_cemi').eq(eq).val(item_umumi_cemi.toFixed(4));
        $('.item_umumi_cemi_hidden').eq(eq).val(item_umumi_cemi.toFixed(4));

        total_hesapla();


    }

    function total_hesapla(){

        let cemi_total = 0;
        let cemi_umumi_total = 0;
        let item_discount_total = 0;
        let item_edvsiz_total = 0;
        let edv_tutari_total = 0;
        let count = 1;
        for (let i=0; i<count; i++){
            cemi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
            cemi_umumi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
            item_discount_total +=parseFloat($('.item_discount_hidden').eq(i).val());
            item_edvsiz_total +=parseFloat($('.item_edvsiz_hidden').eq(i).val());
            edv_tutari_total +=parseFloat($('.edv_tutari_hidden').eq(i).val());
        }


        let para_birimi  =$('option:selected', '.para_birimi').attr('code');



        let teslimat_cemi_hidden=  0;
        let teslimat_edv_total_hidden=  parseFloat($('.teslimat_edv_total_hidden').val());
        let teslimat_total_hidden=  parseFloat($('.teslimat_total_hidden').val());

        item_edvsiz_total=cemi_total+teslimat_cemi_hidden;
        edv_tutari_total=edv_tutari_total+teslimat_edv_total_hidden;
        cemi_umumi_total=cemi_umumi_total+teslimat_total_hidden;

        $('#alt_sub_total').empty().text(item_edvsiz_total.toFixed(2)+' '+para_birimi)
        $('.alt_sub_total_val').val(item_edvsiz_total.toFixed(4));



        $('#alt_discount_total').empty().text(item_discount_total.toFixed(2)+' '+para_birimi)
        $('.alt_discount_total_val').val(item_discount_total.toFixed(4));

        let net_cemi_total = item_edvsiz_total-item_discount_total;
        $('#net_cemi_total').empty().text(net_cemi_total.toFixed(2)+' '+para_birimi)
        $('.alt_net_cemi_total').val(net_cemi_total.toFixed(4));

        $('#alt_edv_total').empty().text(edv_tutari_total.toFixed(2)+' '+para_birimi)
        $('.alt_edv_total_val').val(edv_tutari_total.toFixed(4));

        let alt_total = net_cemi_total+edv_tutari_total;
        $('#alt_total').empty().text(alt_total.toFixed(2)+' '+para_birimi)
        $('.alt_total_val').val(alt_total.toFixed(4));
    }

    $(document).on('click','.guncelle',function (){
        let method = $('.method').val();
        if(parseInt(method)){
            let product_details=[];
            let count = $('.item_qty_qaimt').length;
            for (let i=0; i < count; i++){
                product_details.push({
                    'item_id':$('.item_id').eq(i).val(),
                    'item_qty_qaimt':$('.item_qty_qaimt').eq(i).val(),
                    'item_price_qaimt':$('.item_price_qaimt').eq(i).val(),
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>app-assets/talep.css">

