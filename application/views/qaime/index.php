<div class="content-body">
    <div class="card">
        <div class="card-header">
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row mb-2">
                        <div class="col-md-2">
                            <select class="select-box form-control" id="alt_firma" name="alt_firma" >
                                <option  value="">Alt Firma</option>
                                <?php foreach (all_customer() as $row)
                                {
                                    echo "<option value='$row->id'>$row->company</option>";
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select class="select-box form-control" id="status" name="status" >
                                <option  value="">Durum</option>
                                <?php foreach (invoice_status() as $rows)
                                {
                                    ?><option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="select-box form-control" id="proje_id" name="proje_id" >
                                <option value="">Proje Seçiniz</option>
                                <option value="0">Projesizler</option>
                                <?php foreach (all_projects() as $rows)
                                {
                                    ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="select-box form-control" id="invoice_type_id" name="invoice_type_id" >
                                <option value="">Fatura Tipi</option>
                                <?php foreach (invoice_type() as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                   class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                   data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                        </div>
                    </div>
                <div class="row mb-2">
                    <div class="col-md-12 center" style="text-align: center;">
                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="invoices" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarih</th>
                                <th>Fatura Tipi</th>
                                <th>Fatura No</th>
                                <th>Proje</th>
                                <th>Cari</th>
                                <th>Açıklama</th>
                                <th>Esas Meblağ</th>
                                <th>KDV</th>
                                <th>Toplam</th>
                                <th>Alt Firma</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        draw_data()
    });

    $(document).on('change','.warehouse_item', function () {
        let eq = $(this).attr('eq');

        let id = $(this).val();
        if(parseInt(id)){
            $('.product_items').eq(eq).attr('disabled',false);

        }
        else {
            $('.product_items').eq(eq).attr('disabled',true);
        }

    })
    let table_product_id_ar  = [];
    let invoice_type_id  = 0;
    let customer_id  = 0;
    let alt_cari_id  = 0;
    let fatura_product_type  = 0;
    let invoice_no  = '';
    let ajax_url  = '';
    let disabled_class_unit='d-none';
    let disabled_class_unit_str='';
    let invoicedate  = '';
    let para_birimi_name  = '';
    let invocieduedate  = '';
    let proje_id  = 0;
    let proje_bolum_id  = 0;
    let paymethod  = 0;
    let para_birimi  = 0;
    let kur_degeri  = 0;
    let notes  = '';
    function draw_data(start_date = '', end_date = '',alt_firma,status='',proje_id='',invoice_type_id='') {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [ 10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('invoices/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    alt_firma:alt_firma,
                    status:status,
                    proje_id:proje_id,
                    tip:invoice_type_id
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Qaime Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Qaime Əlavə Edin ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                          <div class="form-row">
                                            <div class="form-group col-md-12">
                                              <label for="name">Fatura Tipi</label>
                                              <select class="form-control invoice_type_id" id="invoice_type_id" name="invoice_type_id" >
                                                    <option value="0">Seçiniz</option>
                                                    <?php foreach (invoice_type() as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                                    } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Devam',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let name = $('.invoice_type_id').val()
                                        if(!parseInt(name)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Fatura Tipi Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }

                                        invoice_type_id = $('.invoice_type_id').val();
                                        $.confirm({
                                            theme: 'modern',
                                            closeIcon: true,
                                            title: 'Cari Bilgileri ',
                                            icon: 'fa fa-plus',
                                            type: 'dark',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            containerFluid: !0,
                                            smoothContent: true,
                                            draggable: false,
                                            content:`<form>
                                                          <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                              <label for="name">Cari</label>
                                                                    <select class="form-control select-box customer_id" id="customer_id" name="customer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_customer() as $pers)
                                            {
                                                echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                                            } ?>
                                                                </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                              <label for="name">Alt Cari</label>
                                                                    <select class="form-control select-box alt_cari_id" id="alt_cari_id" name="alt_cari_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_customer() as $pers)
                                            {
                                                echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                                            } ?>
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </form>`,
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Devam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        let name = $('.customer_id').val()
                                                        if(!parseInt(name)){
                                                            $.alert({
                                                                theme: 'material',
                                                                icon: 'fa fa-exclamation',
                                                                type: 'red',
                                                                animation: 'scale',
                                                                useBootstrap: true,
                                                                columnClass: "col-md-4 mx-auto",
                                                                title: 'Dikkat!',
                                                                content: 'Cari Zorunludur',
                                                                buttons:{
                                                                    prev: {
                                                                        text: 'Tamam',
                                                                        btnClass: "btn btn-link text-dark",
                                                                    }
                                                                }
                                                            });
                                                            return false;
                                                        }

                                                        customer_id=$('.customer_id').val();
                                                        alt_cari_id=$('.alt_cari_id').val();

                                                        let content_text=`<form id='data_form' style="font-size: 20px;line-height: 40px;text-align: initial;">
                                                                  <div class="form-row">
                                                                        <div class="form-group col-md-4">
                                                                            <label class='font-weight-bold' for="name">Fatura No</label><span class='text-danger'>*</span>
                                                                             <input type="text" class="form-control zorunlu_new invoice_no" placeholder="Fatura #" name="invoice_no" id='invoice_no'>
                                                                        </div>
                                                                         <div class="form-group col-md-4">
                                                                            <label class='font-weight-bold' for="name">Fatura Tarihi</label><span class='text-danger'>*</span>
                                                                             <input type="date" class="form-control zorunlu_new invoicedate" name="invoicedate" id='invoicedate'>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label class='font-weight-bold' for="name">Ödeme Tarihi</label><span class='text-danger'>*</span>
                                                                             <input type="date" class="form-control zorunlu_new invocieduedate" name="invocieduedate" id='invocieduedate'>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                        <label class='font-weight-bold' for="name">Proje</label><span class='text-danger'>*</span>
                                                                        <select class="form-control zorunlu_new select-box proje_id" id="proje_id" name="proje_id" >
                                                                            <option value="">Seçiniz</option>
                                                                            <?php foreach (all_projects() as $pers)
                                                                            {
                                                                                echo "<option value='$pers->id'>$pers->code</option>";
                                                                            } ?>
                                                                        </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class='font-weight-bold' for="name">Proje Bölümleri</label><span class='text-danger'>*</span>
                                                                            <select class="form-control zorunlu_new select-box proje_bolum_id" id="proje_bolum_id" name="proje_bolum_id" >
                                                                                <option value="">Proje Seçiniz</option>
                                                                            </select>
                                                                        </div>
                                                                         <div class="form-group col-md-6">
                                                                            <label class='font-weight-bold' for="name">Ödeme Türü</label><span class='text-danger'>*</span>
                                                                            <select class="form-control select-box paymethod zorunlu_new" id="paymethod" name="paymethod">
                                                                               <option value="">Seçiniz</option>
                                                                               <?php foreach (account_type_islem() as $acc)
                                                                                {
                                                                                    echo "<option value='$acc->id'>$acc->name</option>";
                                                                                } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class='font-weight-bold' for="name">Fatura Ürün Tipi</label><span class='text-danger'>*</span>
                                                                            <select class="form-control select-box fatura_product_type zorunlu_new" id="fatura_product_type" name="fatura_product_type">
                                                                               <option value="">Seçiniz</option>
                                                                               <?php foreach (fatura_product_type() as $acc)
                                                                                {
                                                                                    echo "<option value='$acc->id'>$acc->name</option>";
                                                                                } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class='font-weight-bold' for="name">İşlem Para Birimi</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu_new para_birimi" id="para_birimi" name="para_birimi">
                                                                                 <option value="">Seçiniz</option>
                                                                                <?php
                                                                                    foreach (para_birimi()  as $row) {
                                                                                        $cid = $row['id'];
                                                                                        $title = $row['code'];
                                                                                        echo "<option data-name='$title' value='$cid'>$title</option>";
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class='font-weight-bold' for="name">Fatura Kuru</label><span class='text-danger'>*</span>
                                                                                  <input type="number" class="form-control kur_degeri" name="kur_degeri" id='kur_degeri' value='1'>
                                                                        </div>
                                                                         <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">Fatura Açıklaması</label>
                                                                             <textarea class="form-control notes " name="notes" rows="2"></textarea>
                                                                        </div>

                                                                    <input type='hidden' name='customer_id' value='`+customer_id+`'>
                                                                    <input type='hidden' name='invoice_type_id' value='`+invoice_type_id+`'>
                                                                    <input type='hidden' name='alt_cari_id' value='`+alt_cari_id+`'>
                                                                </form>`

                                                        $.confirm({
                                                            theme: 'modern',
                                                            closeIcon: true,
                                                            title: 'Qaime Bilgileri ',
                                                            icon: 'fa fa-question',
                                                            type: 'dark',
                                                            animation: 'scale',
                                                            useBootstrap: true,
                                                            columnClass: "col-md-12 col-md-offset-2",
                                                            containerFluid: !0,
                                                            smoothContent: true,
                                                            draggable: false,
                                                            content:content_text,
                                                            buttons: {
                                                                formSubmit: {
                                                                    text: 'Devam',
                                                                    btnClass: 'btn-blue',
                                                                    action: function () {
                                                                        let name_say = $('.zorunlu_new').length;
                                                                        let kontrol = 0 ;
                                                                        for (let i = 0; i < name_say;i++){
                                                                            let name = $('.zorunlu_new').eq(i).val();
                                                                            if(!name){
                                                                                kontrol++;
                                                                            }
                                                                        }
                                                                        kontrol = 0 ;
                                                                        if(kontrol > 0){
                                                                            $.alert({
                                                                                theme: 'material',
                                                                                icon: 'fa fa-exclamation',
                                                                                type: 'red',
                                                                                animation: 'scale',
                                                                                useBootstrap: true,
                                                                                columnClass: "col-md-4 mx-auto",
                                                                                title: 'Dikkat!',
                                                                                content: 'Yıldızlı Alanlar Zorunludur',
                                                                                buttons:{
                                                                                    prev: {
                                                                                        text: 'Tamam',
                                                                                        btnClass: "btn btn-link text-dark",
                                                                                    }
                                                                                }
                                                                            });
                                                                            return false;
                                                                        }

                                                                        invoice_no=$('.invoice_no').val();
                                                                        invoicedate=$('.invoicedate').val();
                                                                        invocieduedate=$('.invocieduedate').val();
                                                                        proje_id=$('.proje_id').val();
                                                                        proje_bolum_id=$('.proje_bolum_id').val();
                                                                        paymethod=$('.paymethod').val();
                                                                        fatura_product_type=$('.fatura_product_type').val();
                                                                        para_birimi=$('.para_birimi').val();
                                                                        para_birimi_name = $('.para_birimi option:selected').data('name');
                                                                        kur_degeri=$('.kur_degeri').val();
                                                                        notes=$('.notes').val();

                                                                        let disabled_class='';
                                                                         ajax_url = '<?php echo base_url().'stockio/getall_products' ?>';
                                                                        let products_class='disabled';
                                                                        // gider İşlemleri
                                                                        if(invoice_type_id==35 || invoice_type_id==36 || invoice_type_id==41 || invoice_type_id==24){
                                                                            disabled_class='d-none';
                                                                            products_class=''
                                                                            ajax_url = '<?php echo base_url().'stockio/getall_cost' ?>';
                                                                        }

                                                                         disabled_class_unit='d-none';
                                                                         disabled_class_unit_str='';
                                                                        if(invoice_type_id==2){
                                                                            disabled_class_unit=''
                                                                            disabled_class_unit_str='d-none'
                                                                        }



                                                                        let content_text_product=`<form id='data_form_post'>
                                                                        <input type="hidden" name="customer_id" value="`+customer_id+`">
                                                                        <input type="hidden" class='products_class' value="`+products_class+`">
                                                                        <input type="hidden" class='disabled_class' value="`+disabled_class+`">
                                                                        <input type="hidden" name="alt_cari_id" value="`+alt_cari_id+`">
                                                                        <input type="hidden" class='invoice_type_id' name="invoice_type_id" value="`+invoice_type_id+`">
                                                                        <input type="hidden" name="invoice_no" value="`+invoice_no+`">
                                                                        <input type="hidden" name="invoicedate" value="`+invoicedate+`">
                                                                        <input type="hidden" name="invocieduedate" value="`+invocieduedate+`">
                                                                        <input type="hidden" name="proje_id" value="`+proje_id+`">
                                                                        <input type="hidden" name="proje_bolum_id" value="`+proje_bolum_id+`">
                                                                        <input type="hidden" name="paymethod" value="`+paymethod+`">
                                                                        <input type="hidden" name="fatura_product_type" value="`+fatura_product_type+`">
                                                                        <input type="hidden" name="kur_degeri" value="`+kur_degeri+`">
                                                                        <input type="hidden" name="notes" value="`+notes+`">

                                                                    <div class="form-row">
<div class="form-group col-md-12">
<button id="add_new_line" type="button" class='btn btn-success'><i class="fa fa-plus"></i>&nbsp;Yeni Satır Ekle</button>
</div>
                                                                        <div class="form-group col-md-12">
                                    <table class="table table-bordered item_table">
                                    <thead>
                                    <tr>
                                        <td>#</td>
                                        <td class='`+disabled_class+`'>Anbar</td>
                                        <td style="width: 350px;">MALZEME</td>
                                        <td class='`+disabled_class+`'>Varyasyon</td>
                                        <td >Miqdar</td>
                                        <td class='`+disabled_class_unit+`'>Birim</td>
                                        <td>Vahid qiymət</td>
                                        <td>Endirim</td>
                                        <td>ƏDV Oran</td>
                                        <td>ƏDV</td>
                                        <td>Cemi (EDVSİZ)</td>
                                        <td>ÜMUMI CƏMI (EDVSİZ)</td>
                                        <td>Not</td>
                                        <td>İslem</td>
                                    </tr>
                                    </thead>
                                    <tbody>

<tr>
                                <td>1</td>
                                <td class='`+disabled_class+`'>
                                <select  eq='0' class="form-control select-box warehouse_item">
                                <option value='0'>Anbar secin</option>
                                   <?php
                                        foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
                                            echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                                        }
                                        ?>
                                </select>
                                </td>
                                <td>
                                    <select id="product" class="form-control product_items" `+products_class+`></select>
                                </td>
                                <td class="varyasyon `+disabled_class+`"></td>
                                <td><div class="input-group "><input type="number" eq="0" value="0" class="form-control item_qty"><span class="input-group-addon font-xs text-right item_unit_name `+disabled_class_unit_str+`"></span></div></td>
                                <td class=' `+disabled_class_unit+`'><select class='select-box form-control item_unit_id'>
                                    <?php foreach (units() as $blm)
                                    {
                                        $id=$blm['id'];
                                        $name=$blm['name'];
                                        echo "<option value='$id'>$name</option>";
                                    } ?>
                                </select></td>
                                <td><div class="input-group "><input type="number" eq="0" value="0" class="form-control item_price"><span class="input-group-addon font-xs text-right item_para_birimi">AZN</span></div></td>
                                <td><div class="input-group "><input type="number" eq="0" value="0.00" class="form-control item_discount"><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                <td><div class="input-group "><input type="number" eq="0" value="18" class="form-control item_kdv"><span class="input-group-addon font-xs text-right">%</span></div></td>
                                <td><select class="form-control item_edv_durum"><option eq="0" selected="" value="1">Dahil</option><option eq="0" value="0">Haric</option></select></td>


                                <td><input value="0" type="number" class="form-control item_umumi" eq="0" disabled=""></td>
                                <td><input value="0" type="number" class="form-control item_umumi_cemi" eq="0" disabled=""></td>
                                <td><input type="text" class="form-control item_desc" value=""></td>
                                <input type="hidden" class="item_edvsiz_hidden" value="169.4915">
                                <input type="hidden" class="edv_tutari_hidden" value="30.5085">
                                <input type="hidden" class="item_umumi_hidden" value="169.4915">
                                <input type="hidden" class="item_umumi_cemi_hidden" value="169.4915">
                                <input type="hidden" class="item_discount_hidden" value="0.0000">
                                <input type="hidden" value="1" class="item_id">
                                <td></td>
</tr>
</tbody>

</table>
                                                                        </div>
                                                                    </div>
                                                                        </form>
                                                                        `;


                                                                        $.confirm({
                                                                            theme: 'modern',
                                                                            closeIcon: true,
                                                                            title: 'Ürün Bilgileri ',
                                                                            icon: 'fa fa-question',
                                                                            type: 'dark',
                                                                            animation: 'scale',
                                                                            useBootstrap: true,
                                                                            columnClass: "col-md-12 col-md-offset-2",
                                                                            containerFluid: !0,
                                                                            smoothContent: true,
                                                                            draggable: false,
                                                                            content:content_text_product,
                                                                            buttons: {
                                                                                formSubmit: {
                                                                                    text: 'Devam',
                                                                                    btnClass: 'btn-blue',
                                                                                    action: function () {

                                                                                    },
                                                                                }
                                                                            },
                                                                            onContentReady: function () {

                                                                                $('.item_para_birimi').empty().text(para_birimi_name)

                                                                                $('.select-box').select2({
                                                                                    dropdownParent: $(".jconfirm-box-container")
                                                                                })

                                                                                $('.product_items').select2({
                                                                                    dropdownParent: $(".jconfirm-box-container"),
                                                                                    minimumInputLength: 3,
                                                                                    width: 'resolve', // need to override the changed default
                                                                                    allowClear: true,
                                                                                    placeholder: 'Seçiniz',
                                                                                    language: {
                                                                                        inputTooShort: function () {
                                                                                            return 'En az 3 karakter giriniz';
                                                                                        }
                                                                                    },
                                                                                    ajax: {
                                                                                        method: 'POST',
                                                                                        url: ajax_url,
                                                                                        dataType: 'json',
                                                                                        data: function (params) {
                                                                                            let query = {
                                                                                                search: params.term,
                                                                                                warehouse_id: $('.warehouse_item').eq(0).val(),
                                                                                                crsf_token: crsf_hash,
                                                                                            }
                                                                                            return query;
                                                                                        },
                                                                                        processResults: function (data) {
                                                                                            var newData = [];
                                                                                            return {
                                                                                                results: $.map(data, function (data) {
                                                                                                    return {
                                                                                                        text: data.product_name,
                                                                                                        product_name: data.product_name,
                                                                                                        unit_name: data.unit_name,
                                                                                                        id: data.pid,

                                                                                                    }
                                                                                                })
                                                                                            };
                                                                                        },
                                                                                        cache: true
                                                                                    },
                                                                                }).on('change', function (data) {

                                                                                    $('.warehouse_item').select2({
                                                                                        dropdownParent: $(".jconfirm")
                                                                                    })
                                                                                    $('.item_unit_id').select2({
                                                                                        dropdownParent: $(".jconfirm")
                                                                                    })


                                                                                    let eq = parseInt($('.item_table tbody tr').length) - 1;
                                                                                    let product_id = $(this).val()

                                                                                    let varyasyon_durum = false;

                                                                                    if (invoice_type_id == 35 || invoice_type_id == 36 || invoice_type_id == 41 || invoice_type_id == 24) {
                                                                                        let attr = data = $(this).select2('data')[0];
                                                                                        $('.item_unit_name').eq(eq).empty().text(attr.unit_name);
                                                                                    } else {
                                                                                        let warehouse = $(".warehouse_item").eq(eq).val();
                                                                                        if(product_id){
                                                                                            $.confirm({
                                                                                                theme: 'modern',
                                                                                                closeIcon: true,
                                                                                                title: 'Varyasyonlar',
                                                                                                icon: 'fa fa-filter',
                                                                                                type: 'green',
                                                                                                animation: 'scale',
                                                                                                useBootstrap: true,
                                                                                                columnClass: "large",
                                                                                                containerFluid: !0,
                                                                                                smoothContent: true,
                                                                                                draggable: false,
                                                                                                content: function () {
                                                                                                    let self = this;
                                                                                                    let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                                                                                    let data = {
                                                                                                        crsf_token: crsf_hash,
                                                                                                        product_id: product_id
                                                                                                    }

                                                                                                    let table_report = '';
                                                                                                    $.post(baseurl + 'malzemetalep/get_product_to_value', data, (response) => {
                                                                                                        self.$content.find('#person-list').empty().append(html);
                                                                                                        let responses = jQuery.parseJSON(response);
                                                                                                        $('.list').empty().html(responses.html)
                                                                                                        if (responses.code == 200) {
                                                                                                            varyasyon_durum = true;

                                                                                                        }
                                                                                                    });
                                                                                                    self.$content.find('#person-list').empty().append(html);
                                                                                                    return $('#person-container').html();
                                                                                                },
                                                                                                buttons: {
                                                                                                    formSubmit: {
                                                                                                        text: 'Devam',
                                                                                                        btnClass: 'btn-blue',
                                                                                                        action: function () {

                                                                                                            let option_details = [];
                                                                                                            if (varyasyon_durum) {
                                                                                                                $('.option-value:checked').each((index, item) => {
                                                                                                                    option_details.push({
                                                                                                                        'option_id': $(item).attr('data-option-id'),
                                                                                                                        'option_name': $(item).attr('data-option-name'),
                                                                                                                        'option_value_id': $(item).attr('data-value-id'),
                                                                                                                        'option_value_name': $(item).attr('data-option-value-name'),
                                                                                                                    })
                                                                                                                });
                                                                                                            }

                                                                                                            let data_post = {
                                                                                                                crsf_token: crsf_hash,
                                                                                                                id: product_id,
                                                                                                                warehouse: warehouse,
                                                                                                                option_details: option_details
                                                                                                            }
                                                                                                            let data = '';
                                                                                                            let result = false;
                                                                                                            let sayi = 0;
                                                                                                            $.post(baseurl + 'stockio/get_warehouse_products_', data_post, (response) => {
                                                                                                                let data_res = jQuery.parseJSON(response);

                                                                                                                if (data_res.code == 200) {

                                                                                                                    if(invoice_type_id==1){
                                                                                                                        if(data_res.result.qty==0){
                                                                                                                            $.alert({
                                                                                                                                theme: 'material',
                                                                                                                                icon: 'fa fa-exclamation',
                                                                                                                                type: 'red',
                                                                                                                                animation: 'scale',
                                                                                                                                useBootstrap: true,
                                                                                                                                columnClass: "col-md-4 mx-auto",
                                                                                                                                title: 'Dikkat!',
                                                                                                                                content: 'Stokta Bulunmamaktadır',
                                                                                                                                buttons:{
                                                                                                                                    prev: {
                                                                                                                                        text: 'Tamam',
                                                                                                                                        btnClass: "btn btn-link text-dark",
                                                                                                                                        action: function () {
                                                                                                                                            $('.product_items').eq(eq).val(0).change();
                                                                                                                                            setTimeout(function() {
                                                                                                                                                $('.warehouse_item').select2({
                                                                                                                                                    dropdownParent: $(".jconfirm")
                                                                                                                                                })
                                                                                                                                                $('.item_unit_id').select2({
                                                                                                                                                    dropdownParent: $(".jconfirm")
                                                                                                                                                })
                                                                                                                                            },1000)
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            });
                                                                                                                            return false;

                                                                                                                        }
                                                                                                                    }

                                                                                                                    data = {
                                                                                                                        product_id: data_res.result.product_id,
                                                                                                                        option_details: option_details,
                                                                                                                        unit_name: data_res.result.unit_name,
                                                                                                                        unit_id: data_res.result.unit_id
                                                                                                                    }
                                                                                                                    let varyasyon_html = '';
                                                                                                                    let option_id_data = '';
                                                                                                                    let option_value_id_data = '';
                                                                                                                    if (option_details) {
                                                                                                                        for (let i = 0; i < option_details.length; i++) {
                                                                                                                            varyasyon_html += option_details[i].option_value_name + '  ';
                                                                                                                            if (i === (option_details.length) - 1) {
                                                                                                                                option_id_data += option_details[i].option_id;
                                                                                                                                option_value_id_data += option_details[i].option_value_id;
                                                                                                                            } else {
                                                                                                                                option_id_data += option_details[i].option_id + ',';
                                                                                                                                option_value_id_data += option_details[i].option_value_id + ',';
                                                                                                                            }

                                                                                                                        }
                                                                                                                    }
                                                                                                                    $('.varyasyon').eq(eq).empty().text(varyasyon_html);
                                                                                                                    $('.item_unit_name').eq(eq).empty().text(data.unit_name);
                                                                                                                    table_product_id_ar.push({
                                                                                                                        product_id: data.product_id,
                                                                                                                        product_options: data.option_details
                                                                                                                    });

                                                                                                                    // else {
                                                                                                                    //     $.alert({
                                                                                                                    //         theme: 'material',
                                                                                                                    //         icon: 'fa fa-exclamation',
                                                                                                                    //         type: 'red',
                                                                                                                    //         animation: 'scale',
                                                                                                                    //         useBootstrap: true,
                                                                                                                    //         columnClass: "col-md-4 mx-auto",
                                                                                                                    //         title: 'Dikkat!',
                                                                                                                    //         content: 'Ürün Daha Önceden Eklenmiştir',
                                                                                                                    //         buttons:{
                                                                                                                    //             prev: {
                                                                                                                    //                 text: 'Tamam',
                                                                                                                    //                 btnClass: "btn btn-link text-dark",
                                                                                                                    //             }
                                                                                                                    //         }
                                                                                                                    //     });
                                                                                                                    // }

                                                                                                                }
                                                                                                            })

                                                                                                            setTimeout(function() {
                                                                                                                $('.item_unit_id').select2({
                                                                                                                    dropdownParent: $(".jconfirm")
                                                                                                                })
                                                                                                            },1000);
                                                                                                        }
                                                                                                    },
                                                                                                    cancel: {
                                                                                                        text: 'Vazgeç',
                                                                                                        btnClass: "btn btn-danger btn-sm",
                                                                                                    }
                                                                                                },
                                                                                                onContentReady: function () {
                                                                                                    $('.select-box').select2({
                                                                                                        dropdownParent: $(".jconfirm-box-container")
                                                                                                    })
                                                                                                    // bind to events
                                                                                                    var jc = this;
                                                                                                    this.$content.find('form').on('submit', function (e) {
                                                                                                        // if the user submits the form by pressing enter in the field.
                                                                                                        e.preventDefault();
                                                                                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                                                                    });
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                    }

                                                                                })


                                                                                var url = '<?php echo base_url() ?>transactions/file_handling';

                                                                                var jc = this;
                                                                                this.$content.find('form').on('submit', function (e) {
                                                                                    // if the user submits the form by pressing enter in the field.
                                                                                    e.preventDefault();
                                                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                                                });
                                                                            }
                                                                        });


                                                                },
                                                                }
                                                            },
                                                            onContentReady: function () {
                                                                $('.select-box').select2({
                                                                    dropdownParent: $(".jconfirm-box-container")
                                                                })

                                                                var url = '<?php echo base_url() ?>transactions/file_handling';

                                                                var jc = this;
                                                                this.$content.find('form').on('submit', function (e) {
                                                                    // if the user submits the form by pressing enter in the field.
                                                                    e.preventDefault();
                                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                                });
                                                            }
                                                        });

                                                    }
                                                },
                                            },
                                            onContentReady: function () {
                                                $('.select-box').select2({
                                                    dropdownParent: $(".jconfirm-box-container")
                                                })




                                                var jc = this;
                                                this.$content.find('form').on('submit', function (e) {
                                                    // if the user submits the form by pressing enter in the field.
                                                    e.preventDefault();
                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                });
                                            }
                                        });

                                    }

                                },
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });
    }
    $(document).on('change','.proje_id',function (){
        $(".proje_bolum_id option").remove();
        let proje_id  =$(this).val();
        let data = {
            crsf_token: crsf_hash,
            pid: proje_id,
        }
        $.post(baseurl + 'projects/proje_bolum_ajax',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.proje_bolum_id').append(new Option('Seçiniz', '', false, false));
            responses.forEach((item_,index) => {
                $('.proje_bolum_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
            })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })
    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var alt_firma = $('#alt_firma').val();
        var status = $('#status').val();
        var proje_id = $('#proje_id').val();
        var invoice_type_id = $('#invoice_type_id').val();
        $('#invoices').DataTable().destroy();
        draw_data(start_date, end_date,alt_firma,status,proje_id,invoice_type_id);

    });
    $(document).on('click','#add_new_line',function (){
        let disabled_class = $('.disabled_class').val();
        let products_class = $('.products_class').val();
        let i = parseInt($('.item_table tbody tr').length);
        let eq = parseInt($('.item_table tbody tr').length);
        $(".item_table>tbody").append(`<tr id="remove`+i+`" class="result-row">
           <td>1</td>
            <td class='`+disabled_class+`'> <select eq='`+i+`' class="form-control select-box warehouse_item">
            <option value='0'>Anbar secin</option>
               <?php
                    foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
                        echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                    }
                    ?>
            </select>
            </td>
            <td>
                <select id="product" class="form-control product_items" `+products_class+`></select>
            </td>
            <td class="varyasyon `+disabled_class+`"></td>
            <td><div class="input-group "><input type="number" eq="0" value="0" class="form-control item_qty"><span class="input-group-addon font-xs text-right item_unit_name `+disabled_class_unit_str+`"></span></div></td>
            <td class=' `+disabled_class_unit+`'><select class='select-box form-control item_unit_id'>
                                            <?php foreach (units() as $blm)
                {
                    $id=$blm['id'];
                    $name=$blm['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                        </select></td>
            <td><div class="input-group "><input type="number" eq="0" value="0" class="form-control item_price"><span class="input-group-addon font-xs text-right item_para_birimi"></span></div></td>
            <td><div class="input-group "><input type="number" eq="0" value="0.00" class="form-control item_discount"><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
            <td><div class="input-group "><input type="number" eq="0" value="18" class="form-control item_kdv"><span class="input-group-addon font-xs text-right">%</span></div></td>
            <td><select class="form-control item_edv_durum"><option eq="0" selected="" value="1">Dahil</option><option eq="0" value="0">Haric</option></select></td>


            <td><input value="0" type="number" class="form-control item_umumi" eq="0" disabled=""></td>
            <td><input value="0" type="number" class="form-control item_umumi_cemi" eq="0" disabled=""></td>
            <td><input type="text" class="form-control item_desc" value=""></td>
            <input type="hidden" class="item_edvsiz_hidden" value="169.4915">
            <input type="hidden" class="edv_tutari_hidden" value="30.5085">
            <input type="hidden" class="item_umumi_hidden" value="169.4915">
            <input type="hidden" class="item_umumi_cemi_hidden" value="169.4915">
            <input type="hidden" class="item_discount_hidden" value="0.0000">
            <input type="hidden" value="1" class="item_id">

             <td> <button type='button' data-id="`+i+`" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>
            `

                    );

        $('.item_para_birimi').empty().text(para_birimi_name)
        products(eq);

    })
    function products(eq){
        $('.product_items').select2({
            dropdownParent: $(".jconfirm-box-container"),
            minimumInputLength: 3,
            width: 'resolve', // need to override the changed default
            allowClear: true,
            placeholder: 'Seçiniz',
            language: {
                inputTooShort: function () {
                    return 'En az 3 karakter giriniz';
                }
            },
            ajax: {
                method: 'POST',
                url: ajax_url,
                dataType: 'json',
                data: function (params) {
                    let query = {
                        search: params.term,
                        warehouse_id: $('.warehouse_item').eq(eq).val(),
                        crsf_token: crsf_hash,
                    }
                    return query;
                },
                processResults: function (data) {
                    var newData = [];
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: data.product_name,
                                product_name: data.product_name,
                                unit_name: data.unit_name,
                                id: data.pid,

                            }
                        })
                    };
                },
                cache: true
            },
        }).on('change', function (data) {


            $('.warehouse_item').select2({
                dropdownParent: $(".jconfirm")
            })

            $('.item_unit_id').select2({
                dropdownParent: $(".jconfirm")
            })

            let product_id = $(this).val()

            let varyasyon_durum = false;

            invoice_type_id = $('.invoice_type_id').val();


            if (invoice_type_id == 35 || invoice_type_id == 36 || invoice_type_id == 41 || invoice_type_id == 24) {
                let attr = data = $(this).select2('data')[0];
                $('.item_unit_name').eq(eq).empty().text(attr.unit_name);
            } else {
                let warehouse = $(".warehouse_item").eq(eq).val();
                if(product_id){
                    $.confirm({
                        theme: 'modern',
                        closeIcon: true,
                        title: 'Varyasyonlar',
                        icon: 'fa fa-filter',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "large",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: function () {
                            let self = this;
                            let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                            let data = {
                                crsf_token: crsf_hash,
                                product_id: product_id
                            }

                            let table_report = '';
                            $.post(baseurl + 'malzemetalep/get_product_to_value', data, (response) => {
                                self.$content.find('#person-list').empty().append(html);
                                let responses = jQuery.parseJSON(response);
                                $('.list').empty().html(responses.html)
                                if (responses.code == 200) {
                                    varyasyon_durum = true;
                                }
                            });
                            self.$content.find('#person-list').empty().append(html);
                            return $('#person-container').html();
                        },
                        buttons: {
                            formSubmit: {
                                text: 'Devam',
                                btnClass: 'btn-blue',
                                action: function () {


                                    let option_details = [];
                                    if (varyasyon_durum) {
                                        $('.option-value:checked').each((index, item) => {
                                            option_details.push({
                                                'option_id': $(item).attr('data-option-id'),
                                                'option_name': $(item).attr('data-option-name'),
                                                'option_value_id': $(item).attr('data-value-id'),
                                                'option_value_name': $(item).attr('data-option-value-name'),
                                            })
                                        });
                                    }

                                    let data_post = {
                                        crsf_token: crsf_hash,
                                        id: product_id,
                                        warehouse: warehouse,
                                        option_details: option_details
                                    }
                                    let data = '';
                                    let result = false;
                                    let sayi = 0;
                                    $.post(baseurl + 'stockio/get_warehouse_products_', data_post, (response) => {
                                        let data_res = jQuery.parseJSON(response);

                                        if (data_res.code == 200) {
                                            if(invoice_type_id==1){
                                                if(data_res.result.qty==0){
                                                    $.alert({
                                                        theme: 'material',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: 'Stokta Bulunmamaktadır',
                                                        buttons:{
                                                            prev: {
                                                                text: 'Tamam',
                                                                btnClass: "btn btn-link text-dark",
                                                                action: function () {
                                                                    $('.product_items').eq(eq).val(0).change();
                                                                    setTimeout(function() {
                                                                        $('.warehouse_item').select2({
                                                                            dropdownParent: $(".jconfirm")
                                                                        })
                                                                        $('.item_unit_id').select2({
                                                                            dropdownParent: $(".jconfirm")
                                                                        })
                                                                    },1000)
                                                                }
                                                            }
                                                        }
                                                    });
                                                    return false;
                                                }
                                            }

                                            data = {
                                                product_id: data_res.result.product_id,
                                                option_details: option_details,
                                                unit_name: data_res.result.unit_name,
                                                unit_id: data_res.result.unit_id
                                            }
                                            let varyasyon_html = '';
                                            let option_id_data = '';
                                            let option_value_id_data = '';
                                            if (option_details) {
                                                for (let i = 0; i < option_details.length; i++) {
                                                    varyasyon_html += option_details[i].option_value_name + '  ';
                                                    if (i === (option_details.length) - 1) {
                                                        option_id_data += option_details[i].option_id;
                                                        option_value_id_data += option_details[i].option_value_id;
                                                    } else {
                                                        option_id_data += option_details[i].option_id + ',';
                                                        option_value_id_data += option_details[i].option_value_id + ',';
                                                    }

                                                }
                                            }
                                            $('.varyasyon').eq(eq).empty().text(varyasyon_html);
                                            $('.item_unit_name').eq(eq).empty().text(data.unit_name);
                                            table_product_id_ar.push({
                                                product_id: data.product_id,
                                                product_options: data.option_details
                                            });

                                        }
                                    })

                                    setTimeout(function() {
                                        $('.item_unit_id').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    },1000);
                                }
                            },
                            cancel: {
                                text: 'Vazgeç',
                                btnClass: "btn btn-danger btn-sm",
                            }
                        },
                        onContentReady: function () {
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            })
                            // bind to events
                            var jc = this;
                            this.$content.find('form').on('submit', function (e) {
                                // if the user submits the form by pressing enter in the field.
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click'); // reference the button and click it
                            });
                        }
                    });
                }

            }



        })
    }

    $(document).on('click','.remove' ,function(){
        let remove = '#remove'+ $(this).data('id')
        $(remove).remove();
    })


</script>
<style>
    .input-group-addon{
        border: 1px solid gray;
        border-left: none;
        border-radius: 0px 17px 16px 0px;
        padding: 12px;
        font-size: 12px;
    }
</style>