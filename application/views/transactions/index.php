<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">İşlem Listesi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            İşlem Listesi
        </div>
    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="proje_id" name="proje_id" style="width: 297px !important;">
                                            <option value="0">Proje Seçiniz</option>
                                            <?php
                                            foreach (all_projects() as $agd) {?>
                                                <option value="<?php echo $agd->id ?>"><?php echo $agd->code ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="hesap_id" name="hesap_id" style="width: 297px !important;">
                                            <option value="0">Hesap Seçiniz</option>
                                            <?php
                                            foreach (all_account() as $agd) {?>
                                                <option value="<?php echo $agd->id ?>"><?php echo $agd->holder ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="odeme_turu" name="odeme_turu" style="width: 297px !important;">
                                            <option value="0">Ödeme Türü Seçiniz</option>
                                            <?php
                                            foreach (account_type() as $agd) {?>
                                                <option value="<?php echo $agd['id'] ?>"><?php echo $agd['name'] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="tip_id" name="tip_id" style="width: 297px !important;">
                                            <option value="0">Tip Seçiniz</option>
                                            <?php
                                            foreach (transaction_filter_tip() as $agd) {?>
                                                <option value="<?php echo $agd->id ?>"><?php echo $agd->description ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="start_date" id="start_date"
                                               class="date30 form-control form-control-md" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                               data-toggle="datepicker" autocomplete="off"/>

                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <table id="trans_table" class="table datatable-show-all" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Kasa</th>
                            <th>Cari</th>
                            <th>Tutar</th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('type') ?></th>
                            <th width="250px">Eylem</th>
                            <th>Personel</th>
                            <th>Açıklama</th>
                            <th>Vöen</th>


                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Kasa</th>
                            <th>Cari</th>
                            <th></th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('type') ?></th>
                            <th>Eylem</th>
                            <th>Personel</th>
                            <th>Açıklama</th>
                            <th>Vöen</th>


                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    $(function () {
        $('.select2').select2();
    });

    let cari_pers_type=0;
    let payer_id=0;
    $(document).ready(function () {
        draw_data();
        function draw_data(start_date = '', end_date = '',hesap_id='',odeme_turu='',tip_id='') {
            $('#trans_table').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                responsive: true,
                "aLengthMenu": [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "Tümü"]
                ],
                <?php datatable_lang();?>
                "ajax": {
                    "url": "<?php echo site_url('transactions/translist')?>",
                    "type": "POST",
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date:start_date,
                        end_date:end_date,
                        hesap_id:hesap_id,
                        odeme_turu:odeme_turu,
                        tip_id:tip_id,
                    }
                },
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": true,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Yeni İşlem Girişi',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni İşlem Əlavə Edin ',
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
                                              <label for="name">İşlem Türü</label>
                                              <select class="form-control cari_pers_type" id="cari_pers_type" name="cari_pers_type" >
                                                    <option value="0">Seçiniz</option>
                                                    <?php foreach (cari_pers_type() as $pers)
                                                            {
                                                                echo "<option value='$pers->id'>$pers->name</option>";
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
                                            let name = $('.cari_pers_type').val()
                                            if(!parseInt(name)){
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: 'İşlem Türü Zorunludur',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                                return false;
                                            }

                                            cari_pers_type = $('.cari_pers_type').val();
                                            let title='Cari'
                                            let select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_customer() as $pers)
                                            {
                                                echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                                            } ?>
                                                                </select>`;
                                            if(cari_pers_type==2){
                                                title='Personel'
                                                select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_personel() as $pers)
                                                {
                                                    echo "<option name='$pers->name' value='$pers->id'>$pers->name</option>";
                                                } ?>
                                                                </select>`;
                                            }
                                            else if(cari_pers_type==8){
                                                title='Fehle'
                                                select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_customer_fehle() as $pers)
                                                {
                                                    echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                                                } ?>
                                                 </select>`;
                                            }
                                            else if(cari_pers_type==6){
                                                title='Faktorinq'
                                                select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_faktoring() as $pers)
                                                {
                                                    echo "<option name='$pers->invoice_no' value='$pers->id'>$pers->invoice_name</option>";
                                                } ?>
                                                                </select>`;
                                            }
                                            else if(cari_pers_type==7){ // Gider
                                                title='Gider'
                                                select=` <div class="form-group col-md-12">
                                          <label for="name">Demirbaş Grubu</label>
                                           <select class="form-control select-box payer_id" id="demirbas_id" name="payer_id">
                                            <?php
                                                if(demirbas_group_list(1)){
                                                echo "<option value='0'>Seçiniz</option>";
                                                foreach (demirbas_group_list() as $emp){
                                                $emp_id=$emp->id;
                                                $name=$emp->name;
                                                ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                                                }
                                                else {
                                                ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                                                }

                                                ?>
                                        </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                          <label for="name">İtem Seçimiz</label>
                                           <select class="form-control select-box firma_demirbas_id" id="firma_demirbas_id" name="firma_demirbas_id">
                                            <option value='0'>Demirbaş Grubu Seçiniz</option>
                                        </select>
                                         </div>


                                        <div class="form-group col-md-12 one_group">
                                          <label for="name">Gider Kalemi Grubu</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id">
                                            <option value='0'>Demirbaş Grubu Seçiniz</option>
                                        </select>
                                        </div>`;
                                            }
                                            $.confirm({
                                                theme: 'modern',
                                                closeIcon: true,
                                                title: 'İşlem Bilgileri ',
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
                                                              <label for="name">`+title+`</label>
                                                                    `+select+`
                                                                </div>
                                                            </div>
                                                        </form>`,
                                                buttons: {
                                                    formSubmit: {
                                                        text: 'Devam',
                                                        btnClass: 'btn-blue',
                                                        action: function () {

                                                            let name = $('.payer_id').val()
                                                            if(!parseInt(name)){
                                                                $.alert({
                                                                    theme: 'material',
                                                                    icon: 'fa fa-exclamation',
                                                                    type: 'red',
                                                                    animation: 'scale',
                                                                    useBootstrap: true,
                                                                    columnClass: "col-md-4 mx-auto",
                                                                    title: 'Dikkat!',
                                                                    content: title+' Zorunludur',
                                                                    buttons:{
                                                                        prev: {
                                                                            text: 'Tamam',
                                                                            btnClass: "btn btn-link text-dark",
                                                                        }
                                                                    }
                                                                });
                                                                return false;
                                                            }

                                                            payer_id=$('.payer_id').val();
                                                            firma_demirbas_id=$('.firma_demirbas_id').val();


                                                            let group_id=0;


                                                            if(cari_pers_type==2){

                                                            }
                                                            else if(cari_pers_type==6){

                                                            }
                                                            else if(cari_pers_type==7){
                                                                let ct = $('.group_id').length;
                                                                let eq_g = parseInt(ct)-1;
                                                                group_id=$('.group_id').eq(eq_g).val();
                                                            }
                                                            let content_text=`<form id='data_form' style="font-size: 20px;line-height: 40px;text-align: initial;">
                                                                  <div class="form-row">
                                                                   <div class="form-group col-md-12">
                                                                      <label class='font-weight-bold' for="name">Benzin Durumu</label>
                                                                        <select class="form-control islem_turu_benzin_cen" id="islem_turu_benzin_cen" name="islem_turu_benzin_cen" >
                                                                            <option value="0">Seçiniz</option>
                                                                            <option value="1">Benzin Çen Havuzuna Ekle</option>
                                                                            <option value="2">Benzin Az Petrol Havuzuna Ekle</option>
                                                                        </select>
                                                                        </div>

                                                                         <div class="form-group col-md-12">
                                                                      <label class='font-weight-bold' for="name">Yanacaq Litresi</label>
                                                                      <input type='number' class='form-control' id="benzin_ltr" name="benzin_ltr" >

                                                                        </div>
                                                                    <div class="form-group col-md-12">

                                                                      <label class='font-weight-bold' for="name">Proje</label><span class='text-danger'>*</span>
                                                                        <select class="form-control zorunlu select-box proje_id" id="proje_id" name="proje_id" >
                                                                            <option value="">Seçiniz</option>
                                                                            <?php foreach (all_projects() as $pers)
                                                                            {
                                                                                echo "<option value='$pers->id'>$pers->code</option>";
                                                                            } ?>
                                                                        </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">Proje Bölümleri</label><span class='text-danger'>*</span>
                                                                            <select class="form-control zorunlu select-box proje_bolum_id" id="proje_bolum_id" name="proje_bolum_id" >
                                                                                <option value="">Proje Seçiniz</option>
                                                                            </select>
                                                                        </div>
                                                                         <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">Ödeme Türü</label><span class='text-danger'>*</span>
                                                                            <select class="form-control select-box paymethod" id="paymethod" name="paymethod">
                                                                               <option value="">Seçiniz</option>
                                                                               <?php foreach (account_type_islem() as $acc)
                                                                                    {
                                                                                        echo "<option value='$acc->id'>$acc->name</option>";
                                                                                    } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">İşlem Tarihi</label><span class='text-danger'>*</span>
                                                                                 <input type='text' class='datetime_pickers form-control end_date_islem' name='end_date_islem' id='end_date_islem'>
                                                                            </select>
                                                                        </div>
                                                                           <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">İşlem Türü</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu select-box pay_type" id="pay_type" name="pay_type">
                                                                               <option value="">Ödeme Türü Seçiniz</option>
                                                                            </select>
                                                                        </div>
                                                                           <div class="form-group col-md-12 d-none cari_in_invoice_div">
                                                                            <label class='font-weight-bold invoice_forma2' for="name"></label><span class='text-danger'>*</span>
                                                                                <select class="form-control select-box cari_in_invoice" id="cari_in_invoice" name="cari_in_invoice">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none hesap_div account_div">
                                                                            <label class='font-weight-bold' for="name">Hesap</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu  select-box pay_acc" id="pay_acc" name="pay_acc">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">İşlem Para Birimi</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu  select-box para_birimi" id="para_birimi" name="para_birimi">
                                                                                 <option value="">Seçiniz</option>
                                                                                <?php
                                                                                    foreach (para_birimi()  as $row) {
                                                                                        $cid = $row['id'];
                                                                                        $title = $row['code'];
                                                                                        echo "<option value='$cid'>$title</option>";
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                        </div>

                                                                          <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">Fatura Kuru</label><span class='text-danger'>*</span>
                                                                            <input type="text" class="form-control zorunlu_input kur_degeri" placeholder="Kur" name="kur_degeri" id="kur_degeri" value="1">
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">Tutar</label><span class='text-danger'>*</span>
                                                                           <input type="number" placeholder="Tutar" class="form-control zorunlu_input amount" name="amount" id="amount">
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">Açıklama</label>
                                                                           <input type="text" placeholder="Açıklama" class="form-control notes" name="notes" id="notes">
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                         <label for="resim">Fayl</label>
                                                                           <div id="progress" class="progress">
                                                                                <div class="progress-bar progress-bar-success"></div>
                                                                           </div>
                                                                            <table id="files" class="files"></table><br>
                                                                            <span class="btn btn-success fileinput-button" style="width: 100%">
                                                                            <i class="glyphicon glyphicon-plus"></i>
                                                                            <span>Seçiniz...</span>
                                                                            <input id="fileupload_" type="file" name="files[]">
                                                                            <input type="hidden" class="image_text" name="image_text" id="image_text">

                                                                        </div>
                                                                    </div>

                                                                    <input type='hidden' name='payer_id' value='`+payer_id+`'>
                                                                    <input type='hidden' name='firma_demirbas_id' value='`+firma_demirbas_id+`'>
                                                                    <input type='hidden' name='cari_pers_type' value='`+cari_pers_type+`'>
                                                                    <input type='hidden' class='group_id_val' name='group_id_val' value='`+group_id+`'>
                                                                </form>`

                                                            $.confirm({
                                                                theme: 'modern',
                                                                closeIcon: true,
                                                                title: 'İşlem Bilgileri ',
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
                                                                            let name_say = $('.zorunlu').length;
                                                                            let req = 0 ;
                                                                            for (let i = 0; i < name_say;i++){
                                                                                let name = $('.zorunlu').eq(i).val();
                                                                                 if(!parseInt(name)){
                                                                                     req++;
                                                                                 }
                                                                            }
                                                                            if(req > 0){
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
                                                                            $('#loading-box').removeClass('d-none');
                                                                            $.post(baseurl + 'transactions/save_trans_new',$('#data_form').serialize(),(response)=>{
                                                                                let data = jQuery.parseJSON(response);
                                                                                if(data.status==200){
                                                                                    $('#loading-box').addClass('d-none');
                                                                                    $.alert({
                                                                                        theme: 'modern',
                                                                                        icon: 'fa fa-check',
                                                                                        type: 'green',
                                                                                        animation: 'scale',
                                                                                        useBootstrap: true,
                                                                                        columnClass: "col-md-4 mx-auto",
                                                                                        title: 'Başarılı',
                                                                                        content: data.message,
                                                                                        buttons:{
                                                                                            prev: {
                                                                                                text: 'Tamam',
                                                                                                btnClass: "btn btn-link text-dark",
                                                                                                action:function (){
                                                                                                    $('#trans_table').DataTable().destroy();
                                                                                                    draw_data();
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                }
                                                                                else if(data.status==410) {
                                                                                    $('#loading-box').addClass('d-none');
                                                                                    $.alert({
                                                                                        theme: 'modern',
                                                                                        icon: 'fa fa-exclamation',
                                                                                        type: 'red',
                                                                                        animation: 'scale',
                                                                                        useBootstrap: true,
                                                                                        columnClass: "col-md-4 mx-auto",
                                                                                        title: 'Dikkat!',
                                                                                        content: data.message,
                                                                                        buttons:{
                                                                                            prev: {
                                                                                                text: 'Tamam',
                                                                                                btnClass: "btn btn-link text-dark",
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                }


                                                                            })

                                                                        }
                                                                    },
                                                                },
                                                                onContentReady: function () {
                                                                    $('.select-box').select2({
                                                                        dropdownParent: $(".jconfirm-box-container")
                                                                    })

                                                                    $('.datetime_pickers').datetimepicker({
                                                                        dayOfWeekStart : 1,
                                                                        lang:'tr',
                                                                    });

                                                                    var url = '<?php echo base_url() ?>transactions/file_handling';
                                                                    $('#fileupload_').fileupload({
                                                                        url: url,
                                                                        dataType: 'json',
                                                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                                                        done: function (e, data) {
                                                                            var img='default.png';
                                                                            $.each(data.result.files, function (index, file) {
                                                                                img=file.name;
                                                                            });

                                                                            $('#image_text').val(img);
                                                                        },
                                                                        progressall: function (e, data) {
                                                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                                                            $('#progress .progress-bar').css(
                                                                                'width',
                                                                                progress + '%'
                                                                            );
                                                                        }
                                                                    }).prop('disabled', !$.support.fileInput)
                                                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
                                                    },
                                                },
                                                onContentReady: function () {
                                                    $('.select-box').select2({
                                                        dropdownParent: $(".jconfirm-box-container")
                                                    })

                                                    $('#fileupload_').fileupload({
                                                        url: url,
                                                        dataType: 'json',
                                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                                        done: function (e, data) {
                                                            var img='default.png';
                                                            $.each(data.result.files, function (index, file) {
                                                                img=file.name;
                                                            });

                                                            $('#image_text').val(img);
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                                            $('#progress .progress-bar').css(
                                                                'width',
                                                                progress + '%'
                                                            );
                                                        }
                                                    }).prop('disabled', !$.support.fileInput)
                                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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

                                    },
                                },
                                onContentReady: function () {
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })

                                    $('#fileupload_').fileupload({
                                        url: url,
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image_text').val(img);
                                        },
                                        progressall: function (e, data) {
                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                            $('#progress .progress-bar').css(
                                                'width',
                                                progress + '%'
                                            );
                                        }
                                    }).prop('disabled', !$.support.fileInput)
                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    }

                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '')/100 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );


                    // Update footer

                    var tatals =currencyFormat(floatVal(total));

                    $( api.column( 4 ).footer() ).html(tatals);
                }
            });
        }
    });

    $(document).on('click','.mt_button',function (){
        let pay_id  = $(this).attr('pay_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İşlem Görüntüleme',
            icon: 'fa fa-eye',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">Açıklama</label>
                                <input type="text" class="form-control" id="aciklama">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name">Malzeme Talebi</label>
                                <select class='form-control select-box' id="mt_id">
                                <?php foreach (all_mt_list() as $items){
                                    echo "<option value='$items->id'>$items->code</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </form>`,
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Mt Bağla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            mt_id:$('#mt_id').val(),
                            aciklama:$('#aciklama').val(),
                            pay_id:pay_id,
                        }

                        $.post(baseurl + 'malzemetalep/invoice_pay_mt',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content:responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else if(responses.status==410){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
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
                },
                cancel:{
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
    })

    $(document).on('click','.parcala',function (){
        let pay_id  = $(this).attr('id');
        let csd  = $(this).attr('csd');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'İşlem Görüntüleme',
            icon: 'fa fa-eye',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;

                html+='<form action="" class="formName">' +
                    '<div class="form-group islem_ozeti">' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    pay_id: pay_id,
                }

                $.post(baseurl + 'formainvoices/islem_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let text='';
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        text =`<table class="table">
                                    <thead>
                                        <tr>
                                        <th>İşlem Tarihi</th>
                                        <th>İşlem Tutarı</th>
                                        <th>İşlem Detayları</th>
                                        <th>İşlenecek Tutar</th>
                                        <th>Forma2</th>
                                        <th>Proje</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                        </tr>
                                    </thead>
<tbody>
<tr>
<td>`+responses.details.invoicedate+`</td>
<td>`+currencyFormat(floatVal(responses.details.total))+`</td>
<td><a href='/transactions/view?id=`+responses.details.id+`'  class='btn btn-success' target="_blank"> Görüntüle</a></td>
<td><input type="number" class="form-control amount" max='`+responses.max+`'  onkeyup="amount_max(this)"></td>
<td><select class='form-control select-box forma_2_id'>
    <option value='0'>Seçiniz</option>
</td>
<td><select class='form-control select-box proje_id'>
    <option value='0'>Seçiniz</option>
</td>
<td><input type="text" class="form-control desc">
<input type="hidden"  class="form-control transaction_id" value="`+responses.details.id+`">
<input type="hidden"  class="form-control avans_id" value="`+responses.details.term+`">
<input type="hidden"  class="form-control method" value="`+responses.details.method+`">
</td>
<td><button type="button" class="btn btn-success add_parca_pay" ><i class="fa fa-plus"></i></button>&nbsp;
</td>
</tbody>
                                </table>`;



                        if(responses.islme_durum){
                            text +=`<table class="table">
                                    <thead>
                                        <tr>
                                        <th>İşlem Tarihi</th>
                                        <th>İşlem Detayları</th>
                                        <th>İşlem Tutarı</th>
                                        <th>Bağlı Olduğu Forma 2</th>
                                        <th>Bağlı Proje</th>
                                        <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            $.each(responses.islem_details, function (index, items) {
                                text+=`<tr>
                                        <td>`+items.created_at+`</td>
                                        <td>`+items.desc+`</td>
                                        <td>`+currencyFormat(floatVal(items.amount))+`</td>
                                        <td><select class='form-control select-box forma_2_id_items' index_say='`+index+`' select_id='`+items.forma2_id+`'>
                                            <option value='0'>Seçiniz</option>
                                        </td>
                                        <td><select class='form-control select-box proje_id_items' index_say='`+index+`' select_id='`+items.proje_id+`'>
                                            <option value='0'>Seçiniz</option>
                                        </td>
                                        <td>
<button type="button" class="btn btn-danger update_item_avans" tip='0' index_say='`+index+`' data-pay_id='`+items.id+`'><i class="fa fa-trash"></i></button>&nbsp;
<button type="button" class="btn btn-success update_item_avans" tip='1' index_say='`+index+`' data-pay_id='`+items.id+`'><i class="fa fa-check"></i></button>&nbsp;
</td>
                                        </tr>`;
                            });
                            text+=`</tbody>
                                </table>`;
                        }


                    }

                    $('.islem_ozeti').empty().html(text);
                    $(".forma_2_id option").remove();
                    $('.forma_2_id').append(new Option('Seçiniz', '', false, false));
                    $.each(responses.forma_2_list, function (index, item_) {
                        $('.forma_2_id').append(new Option(item_.invoice_no, item_.id, false, false));
                        $('.forma_2_id_items').append(new Option(item_.invoice_no, item_.id, false, false));
                    });

                    $(".proje_id option").remove();
                    $.each(responses.proje_list, function (index, item_) {
                        $('.proje_id').append(new Option(item_.code, item_.id, false, false));
                        $('.proje_id_items').append(new Option(item_.code, item_.id, false, false));
                    });

                });
                setTimeout(function(){

                    let count =$('.proje_id_items').length;
                    for(let i =0;i<count;i++){
                        let  select_proje_id =$('.proje_id_items').eq(i).attr('select_id');
                        let  select_form2_id =$('.forma_2_id_items').eq(i).attr('select_id');
                        $('.proje_id_items').eq(i).val(select_proje_id).select2().trigger('change');
                        $('.forma_2_id_items').eq(i).val(select_form2_id).select2().trigger('change');
                    }

                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })



                },1000)

                return $('#person-container').html();
            },
            onContentReady:function (){


            },
            buttons: {
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };

    function amount_max(obj){

        let max = $(obj).attr('max');
        if(parseFloat($(obj).val())>parseFloat(max)){
            $(obj).val(parseFloat(max))
            return false;
        }
    }

    $(document).on('click','.edit_transaction_button',function (){
        let transaction_id = $(this).attr('id');
        let term=0;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni İşlem Əlavə Edin ',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html=`<form>

                                          <div class="form-row">
                                            <div class="form-group col-md-12">
                                              <label for="name">İşlem Türü</label>
                                              <select class="form-control select-box cari_pers_type" id="cari_pers_type" name="cari_pers_type" >
                                                    <option value="0">Seçiniz</option>
                                                    <?php foreach (cari_pers_type() as $pers)
                {
                    echo "<option value='$pers->id'>$pers->name</option>";
                } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    transaction_id: transaction_id,
                }

                let table_report='';
                $.post(baseurl + 'transactions/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==410){
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: responses.message,
                            buttons:{
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                    action: function (){
                                        $('.jconfirm-closeIcon').click()
                                    }
                                }
                            }
                        });
                        return false;
                    }
                    $('.cari_pers_type').val(responses.details.cari_pers_type).select2().trigger('change');

                });
                self.$content.find('#person-list').empty().append(html);







                return $('#person-container').html();



            },
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name = $('.cari_pers_type').val()
                        if(!parseInt(name)){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'İşlem Türü Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        cari_pers_type = $('.cari_pers_type').val();
                        let title='Cari'
                        let select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_customer() as $pers)
                        {
                            echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                        } ?>
                                                                </select>`;
                        if(cari_pers_type==2){
                            title='Personel'
                            select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_personel() as $pers)
                            {
                                echo "<option name='$pers->name' value='$pers->id'>$pers->name</option>";
                            } ?>
                                                                </select>`;
                        }
                        else if(cari_pers_type==8){
                            title='Cari'
                            select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_customer_fehle() as $pers)
                            {
                                echo "<option name='$pers->name' value='$pers->id'>$pers->company</option>";
                            } ?>
                                                 </select>`;
                        }
                        else if(cari_pers_type==6){
                            title='Faktorinq'
                            select=` <select class="form-control select-box payer_id" id="payer_id" name="payer_id" >
                                                                    <option value="">Seçiniz</option>
                                                                    <?php foreach (all_faktoring() as $pers)
                            {
                                echo "<option name='$pers->invoice_no' value='$pers->id'>$pers->invoice_name</option>";
                            } ?>
                                                                </select>`;
                        }

                        else if(cari_pers_type==7){ // Gider
                            title='Gider'
                            select=` <div class="form-group col-md-12">
                                          <label for="name">Demirbaş Grubu</label>
                                           <select class="form-control select-box payer_id" id="demirbas_id" name="payer_id">
                                            <?php
                            if(demirbas_group_list(1)){
                            echo "<option value='0'>Seçiniz</option>";
                            foreach (demirbas_group_list() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                            }
                            else {
                            ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                            }

                            ?>
                                        </select>
                                        </div>

                                                  <div class="form-group col-md-12">
                                          <label for="name">İtem Seçimiz</label>
                                           <select class="form-control select-box firma_demirbas_id" id="firma_demirbas_id" name="firma_demirbas_id">
                                            <option value='0'>Demirbaş Grubu Seçiniz</option>
                                        </select>
                                         </div>


                                        <div class="form-group col-md-12 one_group">
                                          <label for="name">Gider Kalemi Grubu</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id">
                                            <option value='0'>Demirbaş Grubu Seçiniz</option>
                                        </select>
                                        </div>`;
                        }
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'İşlem Bilgileri ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:function (){
                                let self = this;
                                let html=`<form>
                                                          <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                              <label for="name">`+title+`</label>
                                                                    `+select+`
                                                                </div>
                                                            </div>
                                                        </form>`;
                                let data = {
                                    crsf_token: crsf_hash,
                                    transaction_id: transaction_id,
                                }


                                let table_report='';
                                $.post(baseurl + 'transactions/get_info',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    let responses = jQuery.parseJSON(response);
                                    term=responses.details.term;
                                    $('.payer_id').val(responses.details.csd).select2().trigger('change');


                                });
                                self.$content.find('#person-list').empty().append(html);
                                return $('#person-container').html();
                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Devam',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let group_id=0;
                                        let name = $('.payer_id').val()

                                        if(!parseInt(name)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: title+' Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }


                                        payer_id=$('.payer_id').val();

                                        if(cari_pers_type==2){

                                        }
                                        else if(cari_pers_type==6){

                                        }

                                        else if(cari_pers_type==7){
                                            let ct = $('.group_id').length;
                                            let eq_g = parseInt(ct)-1;

                                            firma_demirbas_id=$('.firma_demirbas_id').val();
                                            group_id=$('.group_id').eq(eq_g).val();
                                            if(!parseInt(group_id)){
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: title+' Zorunludur',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                                return false;
                                            }
                                        }

                                        let content_text=`<form id='data_form' style="font-size: 20px;line-height: 40px;text-align: initial;">
                                                                  <div class="form-row">
                                                                  <div class="form-group col-md-12">
                                                                      <label class='font-weight-bold' for="name">Benzin Durumu</label>
                                                                        <select class="form-control islem_turu_benzin_cen" id="islem_turu_benzin_cen" name="islem_turu_benzin_cen" >
                                                                            <option value="0">Seçiniz</option>
                                                                            <option value="1">Benzin Çen Havuzuna Ekle</option>
                                                                            <option value="2">Benzin Az Petrol Havuzuna Ekle</option>
                                                                        </select>
                                                                        </div>
                                                                               <div class="form-group col-md-12">
                                                                      <label class='font-weight-bold' for="name">Yanacaq Litresi</label>
                                                                      <input type='number' class='form-control' id="benzin_ltr" name="benzin_ltr" >

                                                                        </div>
                                                                    <div class="form-group col-md-12">
                                                                      <label class='font-weight-bold' for="name">Proje</label><span class='text-danger'>*</span>
                                                                        <select class="form-control zorunlu select-box proje_id" id="proje_id" name="proje_id" >
                                                                            <option value="">Seçiniz</option>
                                                                            <?php foreach (all_projects() as $pers)
                                        {
                                            echo "<option value='$pers->id'>$pers->code</option>";
                                        } ?>
                                                                        </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">Proje Bölümleri</label><span class='text-danger'>*</span>
                                                                            <select class="form-control zorunlu select-box proje_bolum_id" id="proje_bolum_id" name="proje_bolum_id" >
                                                                                <option value="">Proje Seçiniz</option>
                                                                            </select>
                                                                        </div>
                                                                         <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">Ödeme Türü</label><span class='text-danger'>*</span>
                                                                            <select class="form-control select-box paymethod" id="paymethod" name="paymethod">
                                                                               <option value="">Seçiniz</option>
                                                                               <?php foreach (account_type_islem() as $acc)
                                        {
                                            echo "<option value='$acc->id'>$acc->name</option>";
                                        } ?>
                                                                            </select>
                                                                        </div>
                                                                            <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">İşlem Tarihi</label><span class='text-danger'>*</span>
                                                                                 <input type='text' class='datetime_pickers form-control end_date_islem' name='end_date_islem' id='end_date_islem'>
                                                                            </select>
                                                                        </div>
                                                                           <div class="form-group col-md-12">
                                                                            <label class='font-weight-bold' for="name">İşlem Türü</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu select-box pay_type" id="pay_type" name="pay_type">
                                                                               <option value="">Ödeme Türü Seçiniz</option>
                                                                            </select>
                                                                        </div>
                                                                           <div class="form-group col-md-12 d-none cari_in_invoice_div">
                                                                            <label class='font-weight-bold invoice_forma2' for="name"></label><span class='text-danger'>*</span>
                                                                                <select class="form-control select-box cari_in_invoice" id="cari_in_invoice" name="cari_in_invoice">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none hesap_div account_div">
                                                                            <label class='font-weight-bold' for="name">Hesap</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu  select-box pay_acc" id="pay_acc" name="pay_acc">
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">İşlem Para Birimi</label><span class='text-danger'>*</span>
                                                                                <select class="form-control zorunlu  select-box para_birimi" id="para_birimi" name="para_birimi">
                                                                                 <option value="">Seçiniz</option>
                                                                                <?php
                                                                                    foreach (para_birimi()  as $row) {
                                                                                        $cid = $row['id'];
                                                                                        $title = $row['code'];
                                                                                        echo "<option value='$cid'>$title</option>";
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                        </div>
                                                                          <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">Fatura Kuru</label><span class='text-danger'>*</span>
                                                                            <input type="text" class="form-control zorunlu_input kur_degeri" placeholder="Kur" name="kur_degeri" id="kur_degeri" value="1">
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">Tutar</label><span class='text-danger'>*</span>
                                                                           <input type="number" placeholder="Tutar" class="form-control zorunlu_input amount" name="amount" id="amount">
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                            <label class='font-weight-bold' for="name">Açıklama</label>
                                                                           <input type="text" placeholder="Açıklama" class="form-control notes" name="notes" id="notes">
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-none account_div">
                                                                         <label for="resim">Fayl</label>
                                                                               <div>
                                                                                   <img class="myImg update_image" style="width: 322px;">
                                                                                 </di>
                                                                           <div id="progress" class="progress">
                                                                                <div class="progress-bar progress-bar-success"></div>
                                                                           </div>
                                                                            <table id="files" class="files"></table><br>
                                                                            <span class="btn btn-success fileinput-button" style="width: 100%">
                                                                            <i class="glyphicon glyphicon-plus"></i>
                                                                            <span>Seçiniz...</span>
                                                                            <input id="fileupload_" type="file" name="files[]">
                                                                            <input type="hidden" class="image_text" name="image_text" id="image_text">

                                                                        </div>
                                                                    </div>

                                                                    <input type='hidden' name='payer_id' value='`+payer_id+`'>
                                                                    <input type='hidden' name='cari_pers_type' value='`+cari_pers_type+`'>
                                                                      <input type='hidden' class='group_id_val' name='group_id_val' value='`+group_id+`'>
                                                                      <input type='hidden' class='firma_demirbas_id' name='firma_demirbas_id' value='`+firma_demirbas_id+`'>
                                                                    <input type='hidden' value='`+transaction_id+`' name='transaction_id_hidden' id='transaction_id_hidden'>
                                                                </form>

                                                                `;

                                        $.confirm({
                                            theme: 'modern',
                                            closeIcon: true,
                                            title: 'İşlem Bilgileri ',
                                            icon: 'fa fa-question',
                                            type: 'dark',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-12 col-md-offset-2",
                                            containerFluid: !0,
                                            smoothContent: true,
                                            draggable: false,
                                            content:function(){
                                                let self = this;
                                                let html = content_text;

                                                let data = {
                                                    crsf_token: crsf_hash,
                                                    transaction_id: transaction_id,
                                                }

                                                let table_report='';
                                                $.post(baseurl + 'transactions/get_info',data,(response) => {
                                                    $('#loading-box').removeClass('d-none');
                                                    self.$content.find('#person-list').empty().append(html);
                                                    let responses = jQuery.parseJSON(response);
                                                    $('.proje_id').val(responses.details.proje_id).select2().trigger('change');
                                                        setTimeout(function(){
                                                            $('.proje_bolum_id').val(responses.details.bolum_id).select2().trigger('change');
                                                        },1000)


                                                    $('.paymethod').val(responses.details.method).select2().trigger('change');
                                                    setTimeout(function(){
                                                        $('.pay_type').val(responses.details.invoice_type_id).select2().trigger('change');
                                                        $('.islem_turu_benzin_cen').val(responses.details.islem_turu_benzin_cen);


                                                        $('.para_birimi').val(responses.details.para_birimi).select2().trigger('change');
                                                        $('.kur_degeri').val(responses.details.kur_degeri);
                                                        $('.benzin_ltr').val(responses.details.benzin_ltr);
                                                        $('.end_date_islem').val(responses.details.end_date_islem);
                                                        $('.amount').val(responses.details_tranaction.total);
                                                        $('.notes').val(responses.details.notes);
                                                        $('.update_image').attr('src',baseurl+"/userfiles/product/"+responses.details.ext)
                                                    },1000)

                                                    setTimeout(function(){
                                                        if(parseInt(responses.details.acid)){
                                                            $('.pay_acc').val(responses.details.acid).select2().trigger('change');
                                                        }
                                                    },2000)

                                                    setTimeout(function(){
                                                        if(responses.details_tranaction){
                                                            $('.cari_in_invoice').val(responses.details_tranaction.invoice_id).select2().trigger('change');
                                                        }
                                                    },2000)

                                                    setTimeout(function (){
                                                        $('#loading-box').addClass('d-none');
                                                        $('.select-box').select2({
                                                            dropdownParent: $(".jconfirm")
                                                        })
                                                    },3000)


                                                });
                                                self.$content.find('#person-list').empty().append(html);
                                                return $('#person-container').html();

                                            },
                                            buttons: {
                                                formSubmit: {
                                                    text: 'Devam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        let name_say = $('.zorunlu').length;
                                                        let req = 0 ;
                                                        for (let i = 0; i < name_say;i++){
                                                            let name = $('.zorunlu').eq(i).val();
                                                            if(!parseInt(name)){
                                                                req++;
                                                            }
                                                        }
                                                        if(req > 0){
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
                                                        $('#loading-box').removeClass('d-none');
                                                        $.post(baseurl + 'transactions/update_trans_new',$('#data_form').serialize(),(response)=>{
                                                            let data = jQuery.parseJSON(response);
                                                            if(data.status==200){
                                                                $('#loading-box').addClass('d-none');
                                                                $.alert({
                                                                    theme: 'modern',
                                                                    icon: 'fa fa-check',
                                                                    type: 'green',
                                                                    animation: 'scale',
                                                                    useBootstrap: true,
                                                                    columnClass: "col-md-4 mx-auto",
                                                                    title: 'Başarılı',
                                                                    content: data.message,
                                                                    buttons:{
                                                                        prev: {
                                                                            text: 'Tamam',
                                                                            btnClass: "btn btn-link text-dark",
                                                                            action:function (){
                                                                                $('#trans_table').DataTable().destroy();
                                                                                draw_data();
                                                                            }
                                                                        }
                                                                    }
                                                                });
                                                            }
                                                            else if(data.status==410) {
                                                                $('#loading-box').addClass('d-none');
                                                                $.alert({
                                                                    theme: 'modern',
                                                                    icon: 'fa fa-exclamation',
                                                                    type: 'red',
                                                                    animation: 'scale',
                                                                    useBootstrap: true,
                                                                    columnClass: "col-md-4 mx-auto",
                                                                    title: 'Dikkat!',
                                                                    content: data.message,
                                                                    buttons:{
                                                                        prev: {
                                                                            text: 'Tamam',
                                                                            btnClass: "btn btn-link text-dark",
                                                                        }
                                                                    }
                                                                });
                                                            }


                                                        })

                                                    }
                                                },
                                            },
                                            onContentReady: function () {
                                                $('.select-box').select2({
                                                    dropdownParent: $(".jconfirm")
                                                })

                                                $('.datetime_pickers').datetimepicker({
                                                    dayOfWeekStart : 1,
                                                    lang:'tr',
                                                });

                                                var url = '<?php echo base_url() ?>transactions/file_handling';
                                                $('#fileupload_').fileupload({
                                                    url: url,
                                                    dataType: 'json',
                                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                                    done: function (e, data) {
                                                        var img='default.png';
                                                        $.each(data.result.files, function (index, file) {
                                                            img=file.name;
                                                        });

                                                        $('#image_text').val(img);
                                                        $('.update_image').attr('src',baseurl+"/userfiles/product/"+img)
                                                    },
                                                    progressall: function (e, data) {
                                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                                        $('#progress .progress-bar').css(
                                                            'width',
                                                            progress + '%'
                                                        );
                                                    }
                                                }).prop('disabled', !$.support.fileInput)
                                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
                                },
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })
                                $('.firma_demirbas_id').val(term).select2().trigger('change');
                                $('.firma_demirbas_id').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $('#fileupload_').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        var img='default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img=file.name;
                                        });

                                        $('#image_text').val(img);
                                    },
                                    progressall: function (e, data) {
                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#progress .progress-bar').css(
                                            'width',
                                            progress + '%'
                                        );
                                    }
                                }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
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

                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var hesap_id = $('#hesap_id').val();
        var odeme_turu = $('#odeme_turu').val();
        var tip_id = $('#tip_id').val();
        var proje_id = $('#proje_id').val();
        $('#trans_table').DataTable().destroy();
        draw_data(start_date, end_date,hesap_id,odeme_turu,tip_id,proje_id);
    });

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
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


    $(document).on('change','.paymethod',function (){
        $(".pay_type option").remove();
        let proje_id  =$(this).val();
        let data = {
            crsf_token: crsf_hash,
            cari_pers_type: cari_pers_type,
        }
        $.post(baseurl + 'transactions/pay_type_get',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('.pay_type').append(new Option('Seçiniz', '', false, false));
            responses.items.forEach((item_,index) => {
                $('.pay_type').append(new Option(item_.description, item_.id, false, false));
            })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })

    $(document).on('change','.cari_in_invoice',function (){
        let id = $(this).val();
        let pay_type  = $(this).val();
        let pay_types  = $('#pay_type').val();
            let data = {
                crsf_token: crsf_hash,
                id: id,
                pay_types: pay_types,
            }
            if(pay_types==17 || pay_types==18 || pay_types==45 || pay_types==46){
                $.post(baseurl + 'invoices/invoice_details',data,(response) => {
                    let responses = jQuery.parseJSON(response);

                    $('.proje_id').val(responses.details.proje_id).select2().trigger('change');
                    $('#amount').val(responses.details.subtotal);

                    setTimeout(function(){ $('#proje_bolum_id').val(responses.details.bolum_id).select2().trigger('change');
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        })
                    }, 1000);

                });
            }
            else{
                $('#amount').val(0);
            }


    })
    $(document).on('change','.pay_type',function (){
        $(".cari_in_invoice option").remove();
        $(".pay_acc option").remove();
        let pay_type  = $(this).val();
        let data = {
            crsf_token: crsf_hash,
            cari_pers_type: cari_pers_type,
            pay_type: pay_type,
            payer_id: payer_id,
            paymethod: $('.paymethod').val(),
        }
        $.post(baseurl + 'transactions/pay_type_next_process',data,(response) => {
            let responses = jQuery.parseJSON(response);

            if(responses.invoice_list.length > 0){
                $('.cari_in_invoice_div').removeClass('d-none');
                $('.cari_in_invoice').addClass('zorunlu');
                $('.invoice_forma2').empty().text(responses.title);
                $('.cari_in_invoice').append(new Option('Seçiniz', '', false, false));
                responses.invoice_list.forEach((item_,index) => {
                    $('.cari_in_invoice').append(new Option(item_.invoice_no, item_.id, false, false));
                })
                if(responses.list_durum){
                    if(responses.account_list.length > 0){
                        $('.account_div').removeClass('d-none');
                        $('.pay_acc').append(new Option('Seçiniz', '', false, false));
                        responses.account_list.forEach((item_,index) => {
                            $('.pay_acc').append(new Option(item_.holder, item_.id, false, false));
                        })
                    }
                    else if(!responses.account_list){
                        $('.account_div').removeClass('d-none');
                        $('.pay_acc').append(new Option('Size Ait Kasa Bulunamadı', '', false, false));

                    }
                }
            }
            else {
                if(responses.list_durum){
                    $('.cari_in_invoice_div').removeClass('d-none');
                    $('.cari_in_invoice').addClass('zorunlu');
                    $('.invoice_forma2').empty().text(responses.title);
                    $('.cari_in_invoice').append(new Option('Herhangi Bir Veri Bulunamadı', '0', false, false));
                    $('.account_div').addClass('d-none');

                }
                else {
                    $('.cari_in_invoice_div').addClass('d-none');
                    $('.cari_in_invoice').removeClass('zorunlu');
                    $('.account_div').removeClass('d-none');
                }
            }





            if(!responses.list_durum){
                if(responses.account_list.length > 0){
                    $('.account_div').removeClass('d-none');
                    $('.pay_acc').append(new Option('Seçiniz', '', false, false));
                    responses.account_list.forEach((item_,index) => {
                        $('.pay_acc').append(new Option(item_.holder, item_.id, false, false));
                    })
                }
                else if(!responses.account_list){
                    $('.account_div').removeClass('d-none');
                    $('.pay_acc').append(new Option('Size Ait Kasa Bulunamadı', '', false, false));

                }
            }

            if(responses.account_durum  == 0){
                $('.hesap_div').addClass('d-none');
                $('.hesap_div select').removeClass('zorunlu');
            }
            else {
                $('.hesap_div').removeClass('d-none');
                $('.hesap_div select').addClass('zorunlu');
            }

            // $('.pay_type').append(new Option('Seçiniz', '', false, false));
            // responses.items.forEach((item_,index) => {
            //     $('.pay_type').append(new Option(item_.description, item_.id, false, false));
            // })
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            });

        });

    })

    function draw_data(start_date = '', end_date = '',hesap_id='',odeme_turu='',tip_id='',proje_id='') {
        $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "aLengthMenu": [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('transactions/translist')?>",
                "type": "POST",
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date:start_date,
                    end_date:end_date,
                    hesap_id:hesap_id,
                    odeme_turu:odeme_turu,
                    tip_id:tip_id,
                    proje_id:proje_id,

                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );


                // Update footer

                var tatals =currencyFormat(floatVal(total));

                $( api.column( 3 ).footer() ).html(tatals);
            }
        });
    }

    let transaction_id = 0;
    $(document).on('click','.transaction_edit',function (){
        transaction_id = $(this).attr('transaction_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'İşlem Düzenleme',
            icon: 'fa fa-external-link-square-alt 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html += `<form >
                        <div class="row">
                             <div class="col-md-12">
                                 <lable>Tür Seçiniz</lable>
                                <select class="form-control tip">
                                <option value="">Seçiniz</option>
                                <option value='1'>Cari</option>
                                <option value='2'>Gider</option>
                                </select>
                             </div>
                            <div class="col-md-12">
                                 <lable>Cari / Gider Türü</lable>
                                <select class="form-control select-box details_id">
                                <option value="">TİP SEÇİNİZ</option>
                                </select>
                             </div>

                                <div class="col-md-12">
                                 <lable>İşlem Türü</lable>
                                <select class="form-control select-box invoice_type_id zorunlu">
                                <option value="">Seçiniz</option>
                                <option value='4'>Ödeme</option>
                                <option value='3'>Tahsilat</option>
                                <option value='17'>Fatura Ödeme</option>
                                <option value='18'>Fatura Tahsilatı</option>
                                <option value='18'>Fatura KDV Ödemesi</option>
                                <option value='20'>Fatura KDV Tahsilatı</option>
                                </select>
                             </div>
                           </div>
                       <form>
                   `;
                let data = {
                    crsf_token: crsf_hash,
                    transaction_id: transaction_id,
                    tip: $('.tip').val(),
                }
                $.post(baseurl + 'transactions/info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.zorunlu').val();
                        if (!name) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tüm Alanlar Zorunludur',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }

                        let data_post = {
                            details_id: $('.details_id').val(),
                            invoice_type_id: $('.invoice_type_id').val(),
                            tip: $('.tip').val(),
                            transaction_id: transaction_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'transactions/cari_gider_update',data_post,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else if(data.status==410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })
                    }
                },
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        table_product_id_ar = [];
                    }
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
    })

    $(document).on('change','.tip',function (){
        $('#loading-box').removeClass('d-none');
        $(".details_id").empty();
        let data = {
            crsf_token: crsf_hash,
            transaction_id: transaction_id,
            tip: $('.tip').val(),
        }
        $.post(baseurl + 'transactions/info',data,(response) => {
            let responses = jQuery.parseJSON(response);
            responses.details_item.forEach((data) => {
                if($('.tip').val()==1){
                    var options = new Option(data.company, data.id, true, true);
                }
                else{
                    var options = new Option(data.name, data.id, true, true);
                }

                // Append it to the select
                $(".details_id").append(options).trigger('change');
            })
            $('#loading-box').addClass('d-none');
        });
    })
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script>


    $(document).on('click','.qaime_isle',function (){
        let transaction_id=$(this).data('invoice_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Qaime Ödenişine İşle',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`
                    <div class="content">
                     <div class="row">
                            <div class="col col-sm-11 col-md-11">
                                <input type="text" placeholder="Fatura Numarası Giriniz En Az 3 Karakter" class="form-control" id="search_name">
                            </div>
                            <div class="col col-sm-1 col-md-1">

                                 <button type="button" class="btn btn-success search_invoices"><i class="fa fa-search"></i></button>
                            </div>

                            <div class="col col-sm-12 col-md-12">

                                <label class="label">Fatura Listesi</label>
                                <select class="form-control select2" id="new_invoice_id">
                                <option>Fatura Numarası Araması Yapınız</option>
                                </select>
                            </div>
                        </div>
                    </div>
`,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            tutar:  $('.komisyon_tutar').val(),
                            hesap_id:  $('.hesap_id_new').val(),
                            transaction_id: id,
                        }
                        $.post(baseurl + 'transactions/create_komisyon_islem',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status == 200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#trans_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status == 410 ){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })
                    }

                },
            },
            onContentReady: function () {
                $('.select2').select2({
                    dropdownParent: $(".jconfirm")
                })

                var url = '<?php echo base_url() ?>transactions/file_handling';
                $('#fileupload_update').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_update').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    $(document).on('click','.gider_ekle',function (){
        let id=$(this).data('invoice_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Komisyon Giderine İşle',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<div class="col-md-12"><label class="col-form-label">Komisyon Tutarı</label>' +
                '<input type="number" class="form-control komisyon_tutar"></div>' +
                '<div class="col-md-12"><label class="col-form-label">Kasa</label>' +
                '<select class="form-control select2 hesap_id_new" id="hesap_id" name="hesap_id" >'+
                ''+
        <?php
        foreach (all_account() as $agd) {?>
        '<option value="<?php echo $agd->id ?>"><?php echo $agd->holder ?></option>'+
        <?php } ?>
    '</select></div>',
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            tutar:  $('.komisyon_tutar').val(),
                            hesap_id:  $('.hesap_id_new').val(),
                            transaction_id: id,
                        }
                        $.post(baseurl + 'transactions/create_komisyon_islem',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status == 200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#trans_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status == 410 ){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })
                    }

                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })

                var url = '<?php echo base_url() ?>transactions/file_handling';
                $('#fileupload_update').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_update').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    $(document).on('click','.invoice_image',function (){
        let id=$(this).data('invoice_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dosya',
            icon: 'fa fa-pen',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html=`<form>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                         <label for="resim">Dosya</label>
                         <div>
                           <a class="myImg update_image btn btn-succes" href="#" target="_blank"><i class="fa fa-file"></i></a>
                         </di>
                           <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                           </div>
                            <table id="files" class="files"></table><br>

                            <span class="btn btn-success fileinput-button" style="width: 100%">
                            <i class="glyphicon glyphicon-plus"></i>

                            <span>Seçiniz...</span>
                            <input id="fileupload_update" type="file" name="files[]">

                            <input type="hidden" class="image_text_update" name="image_text_update" id="image_text_update">
                      </div>
                           </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    transaction_id: id,
                }

                let table_report='';
                $.post(baseurl + 'transactions/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.details.ext){
                        $('.update_image').attr('href','/userfiles/product/'+responses.details.ext)
                    }
                    else {
                            $('.update_image').css('display','none')
                    }



                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();

            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            image_text:  $('#image_text_update').val(),
                            transaction_id: id,
                        }
                        $.post(baseurl + 'transactions/update_image',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status == 200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#trans_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status == 410 ){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })
                    }

                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
                })

                var url = '<?php echo base_url() ?>transactions/file_handling';
                $('#fileupload_update').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_update').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    $(document).on('change','#demirbas_id',function (){
        $("#group_id option").remove();
        let id = $(this).val();
        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_parent_list',data,(response)=>{
            let responses = jQuery.parseJSON(response);



            if(responses.status==200){
                if(responses.firma_item_list_durum) {


                    $("#firma_demirbas_id option").remove();

                    responses.firma_item_list.forEach((item_s,index) => {
                        $('#firma_demirbas_id').append(new Option(item_s.name, item_s.id, false, false));
                    })

                    $('#group_id').append(new Option('Seçiniz', '', false, false));
                    responses.items.forEach((item_, index) => {
                        $('#group_id').append(new Option(item_.name, item_.id, false, false));
                    })
                }
                else {
                    $('#firma_demirbas_id').append(new Option('İtem Yoktur', 0, false, false));
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'İtem Yoktur',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }
            }
            else {

                $('#group_id').append(new Option('Alt Grup Yoktur', 0, false, false));
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: responses.message,
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }


        });
    })

    $(document).on('change','.group_id',function (){
        let id = $(this).val();

        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_parent_kontrol',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            let eq=$(this).parent().index();

            if(responses.status==200){

                let class_name = $(this).attr('class');
                if(class_name=='form-control select-box group_id'){


                    if($(this).val()==0){
                        $('.add_group').eq(parseInt(eq)-1).remove();
                    }

                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;
                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }



                }
                else {
                    $('.add_group').remove();
                }


                let add_grp = $('.add_group').length;
                if(parseInt(add_grp)){
                    let say = parseInt(add_grp)-1;
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.add_group').eq(say).after(html);

                }
                else {
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.one_group').after(html);
                }
            }
            else {

                if($(this).val()==0){
                    $('.add_group').eq(parseInt(eq)-1).remove();
                }

                if($(this).attr('types')=='ones'){

                    $('.add_group').remove();
                }
                else {
                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;

                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }
                }



                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: responses.message,
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }


        });
    })

    $(document).on('click','.update_item_avans',function (){
        let tip = $(this).attr('tip');
        let id =$(this).data('pay_id');
        let index_say = $(this).attr('index_say');
        let title='İşlem Güncelle';
        let icon='fa fa-pen';
        let types='green';
        let content='İşlemi Güncellemek İstediğinizden Emin Misiniz?';
        if(tip==0) //delete
        {
            title='İşlem Sil';
            icon='fa fa-trash';
            types='red';
            content='İşlemi Silmek İstediğinizden Emin Misiniz?';
        }
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: title,
            icon: icon,
            type: types,
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: content,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            id: id,
                            proje_id: $('.proje_id_items').eq(index_say).val(),
                            forma2_id: $('.forma_2_id_items').eq(index_say).val(),
                            tip: tip
                        }
                        if(tip==0){
                            let data = {

                                tip: tip,
                                id: id
                            }
                        }

                        $.post(baseurl + 'formainvoices/update_item_avans', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 410) {

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {

            }
        });
    })



    $(document).on('click','.add_parca_pay',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İşlem Görüntüleme',
            icon: 'fa fa-eye',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Eklemek İstediğinizden Emin Misiniz?',
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'İşlem Yap',
                    btnClass: 'btn btn-blue yetki',
                    action: function () {
                        if(!floatVal($('.amount').val())){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tutar Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            forma2_id:$('.forma_2_id').val(),
                            proje_id:$('.proje_id').val(),
                            transaction_id:$('.transaction_id').val(),
                            amount: $('.amount').val(),
                            desc: $('.desc').val(),
                            avans_id: $('.avans_id').val(),
                            method: $('.method').val(),
                            pay_id: $('.pay_id').val(),
                        }

                        $.post(baseurl + 'formainvoices/islem_create',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde İşlem Gerçekleşti.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                            else if(responses.status==410){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
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
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })
    $(document).on('change','.forma_2_id',function (){
        let id = $(this).val();

        let data = {
            id: id,
        }
        $.post(baseurl + 'formainvoices/get_info',data,(response) => {
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                $('.proje_id').val(responses.details.proje_id).select2().trigger('change');
                $('.proje_id').attr('disabled',true)
            }
            else {
                $('.proje_id').attr('disabled',false)
            }


        });
    })

    $(document).on('change','.forma_2_id_items',function (){
        let id = $(this).val();
        let eq = $(this).attr('index_say');

        let data = {
            id: id,
        }
        $.post(baseurl + 'formainvoices/get_info',data,(response) => {
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                $('.proje_id_items').eq(eq).val(responses.details.proje_id).select2().trigger('change');
                $('.proje_id_items').eq(eq).attr('disabled',true)
            }
            else {
                $('.proje_id_items').eq(eq).attr('disabled',false)
            }


        });
    })

</script>