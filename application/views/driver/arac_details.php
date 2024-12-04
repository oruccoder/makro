<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $name; ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">

                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-arac_karti" data-toggle="tab" href="#arac_karti" role="tab" aria-controls="nav-home" aria-selected="true">Araç Kartı</a>
                                            <a class="nav-item nav-link" id="nav-aktive_surucu" data-toggle="tab" href="#aktive_surucu" role="tab" aria-controls="nav-profile" aria-selected="false">Aktif Sürücü</a>
                                            <a class="nav-item nav-link" id="nav-lokasyon_info" data-toggle="tab" href="#lokasyon_info" role="tab" aria-controls="nav-contact" aria-selected="false">Araç Talep Formları</a>
                                            <a class="nav-item nav-link" id="nav-surucu_notes" data-toggle="tab" href="#surucu_notes" role="tab" aria-controls="nav-contact" aria-selected="false">Sürücü Durum Bildirme</a>
                                            <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#upload" role="tab" aria-controls="nav-contact" aria-selected="false">Dosyalar</a>
                                            <a class="nav-item nav-link" id="nav-giderler" data-toggle="tab" href="#giderler" role="tab" aria-controls="nav-contact" aria-selected="false">Giderler</a>
                                        </div>
                                    </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="arac_karti" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-4">
                                                        <div class="card">
                                                            <img class="card-img-top" resim_yolu="<?php echo base_url() . 'userfiles/product/' . $details->image_text; ?>" src="<?php echo base_url() . 'userfiles/product/' . $details->image_text; ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-4">
                                                        <div class="card">
                                                            <div class="span8">
                                                                <h3><?php echo $details->name;?></h3>
                                                                <h4><?php echo $details->plaka;?></h4>
                                                                <h6><?php echo $details->marka.' - '.$details->model;?></h6>
                                                                <h6><?php echo $details->yil.' - '.$details->renk;?></h6>
                                                                <h6><?php echo $details->yakit_tipi?></h6>
                                                                <?php if(arac_ekipmanlari($details->id)){ ?>
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Ekipmanlar</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        foreach (arac_ekipmanlari($details->id) as $items){
                                                                            echo " <tr>
                                                                                                <td>$items->name</td>
                                                                                            </tr>
                                                                                                ";
                                                                        }
                                                                        ?>

                                                                        </tbody>
                                                                    </table>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <?php if(arac_izinleri($details->id)){ ?>
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>İzinler</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        foreach (arac_izinleri($details->id) as $items){
                                                                            echo " <tr>
                                                                                                <td>$items->name</td>
                                                                                            </tr>
                                                                                                ";
                                                                        }
                                                                        ?>

                                                                        </tbody>
                                                                    </table>
                                                                    <?php
                                                                }
                                                                ?>


                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="aktive_surucu" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="card-body">
                                                    <div class="row">
<!--                                                    --><?php //if(arac_aktive_surucu($details->id)){
//
//                                                        $employee = arac_aktive_surucu($details->id);
//                                                        ?>
<!---->
<!--                                                            <div class="col-sm-2 col-md-2 col-lg-2 mt-4">-->
<!--                                                                <div class="card">-->
<!--                                                                    <img class="card-img-top"  src="--><?php //echo base_url('userfiles/employee/' . pesonel_picture_url(arac_aktive_surucu($details->id)->id)); ?><!--" >-->
<!--                                                                </div>-->
<!--                                                            </div>-->
<!--                                                            <div class="col-sm-2 col-md-2 col-lg-2 mt-4">-->
<!--                                                                <div class="card" style="padding: 15px;">-->
<!---->
<!--                                                                    <h4><strong>--><?php //echo $employee->name ?><!--</strong></h4>-->
<!---->
<!--                                                                    <div class="row m-t-lg">-->
<!--                                                                        <div class="col-md-12">-->
<!--                                                                            <strong>--><?php //echo $this->lang->line('Address') ?>
<!--                                                                                : </strong>--><?php //echo $employee->address ?>
<!--                                                                        </div>-->
<!---->
<!--                                                                    </div>-->
<!--                                                                    <div class="row m-t-lg">-->
<!--                                                                        <div class="col-md-12">-->
<!--                                                                            <strong>--><?php //echo $this->lang->line('City') ?>
<!--                                                                                : </strong>--><?php //echo $employee->city ?>
<!--                                                                        </div>-->
<!---->
<!--                                                                    </div>-->
<!--                                                                    <div class="row m-t-lg">-->
<!--                                                                        <div class="col-md-12">-->
<!--                                                                            <strong>--><?php //echo $this->lang->line('Region') ?>
<!--                                                                                : </strong>--><?php //echo $employee->region ?>
<!--                                                                        </div>-->
<!---->
<!--                                                                    </div>-->
<!--                                                                    <div class="row m-t-lg">-->
<!--                                                                        <div class="col-md-12">-->
<!--                                                                            <strong>--><?php //echo $this->lang->line('Country') ?>
<!--                                                                                : </strong>--><?php //echo $employee->country ?>
<!--                                                                        </div>-->
<!---->
<!--                                                                    </div>-->
<!--                                                                    <hr>-->
<!--                                                                    <div class="row m-t-lg">-->
<!--                                                                        <div class="col-md-12">-->
<!--                                                                            <strong>--><?php //echo $this->lang->line('Phone') ?><!--</strong> --><?php //echo $employee->phone; ?>
<!--                                                                        </div>-->
<!---->
<!--                                                                    </div>-->
<!--                                                                    <div class="row m-t-lg">-->
<!--                                                                        <div class="col-md-12">-->
<!--                                                                            <strong>EMail</strong> --><?php //echo $employee->email; ?>
<!--                                                                        </div>-->
<!---->
<!--                                                                    </div>-->
<!---->
<!---->
<!--                                                                </div>-->
<!--                                                            </div>-->
<!--                                                            <div class="col-md-8">-->
<!--                                                                <div class="row mt-5">-->
<!--                                                                    <div class="col-md-12">-->
<!--                                                                        <table class="table">-->
<!--                                                                            <thead>-->
<!--                                                                            <tr>-->
<!--                                                                                <td>Sürücü Vesigesi</td>-->
<!--                                                                                <td>Etibarname</td>-->
<!--                                                                                <td>Muqavele</td>-->
<!--                                                                            </tr>-->
<!--                                                                            </thead>-->
<!--                                                                            <tbody>-->
<!--                                                                            <tr>-->
<!--                                                                                <td>  --><?php //echo  personel_belge_kontrol($employee->id,$details->id,8,0)?><!--</td>-->
<!--                                                                                <td>  --><?php //echo  personel_belge_kontrol($employee->id,$details->id,9,0)?><!--</td>-->
<!--                                                                                <td>  --><?php //echo  personel_belge_kontrol($employee->id,$details->id,10,0)?><!--</td>-->
<!--                                                                            </tr>-->
<!--                                                                            </tbody>-->
<!--                                                                        </table>-->
<!---->
<!--                                                                    </div>-->
<!---->
<!--                                                                </div>-->
<!---->
<!--                                                            </div>-->
<!--                                                            --><?php
//                                                            } ?>
                                                            <div class="col-md-12">
                                                                <table id="invoices_drivers" class="table"  style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Sürücü</th>
                                                                            <th>SÜRÜCÜ VESIGESI</th>
                                                                            <th>ETIBARNAME</th>
                                                                            <th>MUQAVELE</th>
                                                                            <th>Aktif Olma Tarihi</th>
                                                                            <th>Pasif Olma Tarihi</th>
                                                                            <th>Durum</th>
                                                                            <th>İşlem</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>


                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="lokasyon_info" role="tabpanel" aria-labelledby="nav-profile-tab">

                                                <div class="card-body">
                                                    <table id="invoices_driver" class="table"  style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Araç Talep No</th>
                                                            <th>Lokasyon</th>
                                                            <th>Görev Sebebi</th>
                                                            <th>Başlangıç Tarihi</th>
                                                            <th>Bitiş Tarihi</th>
                                                            <th>Benzin Tutar</th>
                                                            <th>Yemek Tutar</th>
                                                            <th>Talep Eden</th>
                                                            <th>Durum</th>
                                                            <th>İşlem</th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                                </div>
                                                <div class="card-body">


<!--                                                    --><?php //if(arac_aktive_surucu($details->id)){
//                                                        $talep_id = arac_aktive_surucu($details->id)->talep_id;
//                                                        if($talep_id){
//                                                            $talep_details = arac_talep_form_details($talep_id);
//                                                            ?>
<!--                                                            <div class="card">-->
<!--                                                                <div class="span8">-->
<!--                                                                    <h3><b>Talep Kodu : </b> <button class='btn btn-success view' talep_id='--><?php //echo $talep_id ?><!--' type='button'><i class='fa fa-eye'></i> --><?php //echo $talep_details->code ?><!--</button></h3>-->
<!--                                                                    <h4><b>Lokasyon : </b>--><?php //echo $talep_details->lokasyon;?><!--</h4>-->
<!--                                                                    <h6><b>Görev Sebebi : </b>--><?php //echo $talep_details->gorev_sebebi;?><!--</h6>-->
<!--                                                                    <h6><b>Başlangıç - Bitiş Tarihi : </b>--><?php //echo $talep_details->start_date.' - '.$talep_details->end_date;?><!--</h6>-->
<!---->
<!--                                                                    --><?php
//                                                                    $text=false;
//                                                                    if(datetimefark($talep_details->end_date,$talep_details->start_date)['yil']){
//                                                                        $text.=datetimefark($talep_details->end_date,$talep_details->start_date)['yil'].' Yıl ';
//                                                                    }
//
//                                                                    if(datetimefark($talep_details->end_date,$talep_details->start_date)['gun']){
//                                                                        $text.=datetimefark($talep_details->end_date,$talep_details->start_date)['gun'].' Gün ';
//                                                                    }
//                                                                    if(datetimefark($talep_details->end_date,$talep_details->start_date)['saat']){
//                                                                        $text.=datetimefark($talep_details->end_date,$talep_details->start_date)['saat'].' saat ';
//                                                                    }
//
//                                                                    if(datetimefark($talep_details->end_date,$talep_details->start_date)['dakika']){
//                                                                        $text.=datetimefark($talep_details->end_date,$talep_details->start_date)['dakika'].' dakika ';
//                                                                    }
//                                                                    if($text){
//                                                                        echo "<p><b>".$text.'</b> Kadar Araç İçin İzin Alınmıştır</p>';
//                                                                    }
//
//                                                                    echo '<p id="demo"></p>';
//
//                                                                    $date=explode('-',$talep_details->end_date);
//                                                                    $date_=explode('-',$talep_details->end_date);
//                                                                    $time=explode(' ',$date_[2]);
//                                                                    $times=explode(':',$time[1]);
//
//                                                                    $ay = explode(' ',$date[2]);
//
//                                                                    $monthName = date("M", strtotime(mktime(0, 0, 0, intval($date[1]), 1, 1900)));
//
//
//
//                                                                    //Jan 5, 2024 15:37:25
//                                                                    $text_=$monthName.' '.intval($ay[0]).', '.intval($date[0]).' '.$times[0].':'.$times[1].':'.$times[2];
//
//                                                                    echo "<input type='hidden' id='bitis_time' value='$text_'>";
//
//
//
//
//                                                                    ?>
<!---->
<!--                                                                </div>-->
<!--                                                            </div>-->
<!---->
<!--                                                            --><?php
//                                                        }
//                                                    }
//                                                    ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="surucu_notes" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="card-body">
                                                    <table class="table" id="surucu_notes_table" style="width: 100%;">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Durum</th>
                                                            <th>Lokasyon</th>
                                                            <th>Teslim Tarihi</th>
                                                            <th>Tehvil Tarihi</th>
                                                            <th>Teslim / Tehvil Personel</th>
                                                            <th>Açıklama</th>
                                                            <th style="width: 9% !important;">İşlem</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="card-body">
                                                    <table class="table" id="dosyalar" style="width: 100%;">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Dosya Adı</th>
                                                            <th>Açıklaması</th>
                                                            <th>İşlem Tarih</th>
                                                            <th>Kayıt Tarihi</th>
                                                            <th>Teslim Eden Personel</th>
                                                            <th>Tehvil Alan Personel</th>
                                                            <th>Dosya</th>
                                                            <th style="width: 9% !important;">İşlem</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="giderler" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="card-body">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <form action="#">
                                                                    <fieldset class="mb-3">
                                                                        <div class="form-group row">
                                                                            <div class="col-lg-2">
                                                                                <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                                                                       class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                                                                       data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-md-12" style="text-align: center;font-size: 25px;font-weight: bold;">
                                                                           <span id="total-arac-gider">Gider Toplamı : <?php echo arac_gider_totals($details->id);?></span>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <table class="table" id="demisbas_list" width="100%">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Tarih</th>
                                                                                    <th>Gider Adı</th>
                                                                                    <th>Miktarı</th>
                                                                                    <th>Birim Fiyatı</th>
                                                                                    <th>Toplam Tutar</th>
                                                                                    <th>Talep Kodu</th>
                                                                                    <th>Talep Durumu</th>
                                                                                </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .span8{
        padding: 15px;
    }
</style>

    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        var url = '<?php echo base_url() ?>arac/file_handling';

        $(document).ready(function (){

            <?php if(arac_aktive_surucu($details->id)){
                               $talep_id = arac_aktive_surucu($details->id)->talep_id;
                               if($talep_id){

                               ?>
       var countDownDate = new Date($("#bitis_time").val()).getTime();

       // Update the count down every 1 second
       var x = setInterval(function() {

           // Get today's date and time
           var now = new Date().getTime();

           // Find the distance between now and the count down date
           var distance = countDownDate-now;

           // Time calculations for days, hours, minutes and seconds
           var days = Math.floor(distance / (1000 * 60 * 60 * 24));
           var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
           var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
           var seconds = Math.floor((distance % (1000 * 60)) / 1000);

           // Display the result in the element with id="demo"
           document.getElementById("demo").innerHTML = days + " Gün " + hours + " Saat "
               + minutes + " Dakika " + seconds + " Saniye Süresi Kalmıştır";

           // If the count down is finished, write some text
           if (distance < 0) {
               clearInterval(x);
               document.getElementById("demo").innerHTML = "Süresi Dolmuştur";
           }
       }, 1000);

       <?php }} ?>

        draw_data_notes();
        dosyalar();
        draw_data_driver()
        draw_data_drivers()
        draw_data_gider()
  })


        $(document).on('click', ".status_change", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Durum',
                icon: 'fa fa-signal',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<div class="form-group col-md-12">
      <label for="firma_id">Status</label>
     <select class="form-control select-box required" id="status">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (surucu_status_result() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>`,
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-success',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                talep_id: talep_id,
                                status: $('#status').val(),
                            }
                            $.post(baseurl + 'driver/status_change',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.status=='Success'){
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
                                                    $('#invoices_drivers').DataTable().destroy();
                                                    draw_data_drivers();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status=='Error'){

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

        $(document).on('click', ".arac_atama", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Araç Atama',
                icon: 'fa fa-truck',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<div class="form-group col-md-12">
      <label for="arac_id">Talebin Atanacağı Araç</label>
     <select class="form-control select-box required" id="arac_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (araclar_list(3) as $emp){
                $emp_id=$emp->id;
                $name=$emp->name.'-'.$emp->plaka;
                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>`,
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-success',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                talep_id: talep_id,
                                arac_id: $('#arac_id').val(),
                            }
                            $.post(baseurl + 'driver/arac_change',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.status=='Success'){
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
                                                    $('#invoices_driver').DataTable().destroy();
                                                    draw_data_driver();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status=='Error'){

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




   $(document).on('click', ".belge_talep", function (e) {
       let type = $(this).attr('filetype');
       let pers_id = $(this).attr('pers_id');
       let arac_id = '<?php echo $details->id ?>';
       let arac_suruculeri_id = $(this).attr('arac_suruculeri_id');
       $.confirm({
           theme: 'modern',
           closeIcon: true,
           title: 'Dikkat',
           icon: 'fa fa-bell',
           type: 'orange',
           animation: 'scale',
           useBootstrap: true,
           columnClass: "small",
           containerFluid: !0,
           smoothContent: true,
           draggable: false,
           content:'<form action="" class="formName">' +
               '<div class="form-group">' +
               '<p>Personelden Eksik Belge Talep Edilecektir Emin Misiniz?<p/>' +
               '</form>',
           buttons: {
               formSubmit: {
                   text: 'Bildirim Oluştur',
                   btnClass: 'btn-blue',
                   action: function () {
                       $('#loading-box').removeClass('d-none');
                       let data = {
                           crsf_token: crsf_hash,
                           type: type,
                           pers_id: pers_id,
                           arac_id: arac_id,
                           arac_suruculeri_id: 0,
                       }
                       $.post(baseurl + 'driver/belge_bildirim_olustur_',data,(response) => {
                           let responses = jQuery.parseJSON(response);
                           $('#loading-box').addClass('d-none');
                           if(responses.status=='Success'){
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
                                       }
                                   }
                               });

                           }
                           else if(responses.status=='Error'){

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
   $(document).on('click','.view',function (){
       let talep_id =$(this).attr('talep_id')
       $.confirm({
           theme: 'modern',
           closeIcon: true,
           title: 'Araç Talep Formunu Detayları',
           icon: 'fa fa-eye',
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
               html += `<form>
                   <div class="form-row">
                   <div class="form-group col-md-12">
                   <label for="arac_id">Talep Edilen Araç</label>
                   <input type="text" class="form-control" disabled id="arac_id">
           </div>
           </div>
               <div class="form-row">
                   <div class="form-group col-md-6">
                       <label for="lokasyon">Lokasyon</label>
                       <input type="text" class="form-control" disabled id="lokasyon">
                   </div>
                   <div class="form-group col-md-6">
                       <label for="gorev_sebebi">Görev Sebebi</label>
                       <input type="text" class="form-control" disabled id="gorev_sebebi">

                   </div>
               </div>
               <div class="form-row">
                   <div class="form-group col-md-6">
                       <label for="start_date">Başlangıç Tarihi ve Saati</label>
                       <input type="datetime-local" disabled class="form-control" id="start_date">

                   </div>
                   <div class="form-group col-md-6">
                       <label for="end_date">Bitiş Tarihi ve Saati</label>
                       <input type="datetime-local" disabled class="form-control" id="end_date">
                   </div>
               </div>
               <div class="form-row">
                   <div class="form-group col-md-3">
                       <label for="benzin_talebi">Benzin Talebi</label>
                       <input type="checkbox" disabled class="form-control" id="benzin_talebi">
                   </div>
                   <div class="form-group col-md-3">
                       <label for="benzin_miktari">Benzin Miktarı (Litre)</label>
                       <input type="number" disabled class="form-control" id="benzin_miktari">
                   </div>
                   <div class="form-group col-md-3">
                       <label for="yemek_talebi">Yemek Talebi</label>
                       <input type="checkbox" disabled class="form-control" id="yemek_talebi">
                   </div>
                   <div class="form-group col-md-3">
                       <label for="yemek_tutari">Yemek Ücreti (AZN)</label>
                       <input type="number" disabled class="form-control" id="yemek_tutari">
                   </div>
               </div>
               <hr>
                   <div class="form-row">
                       <div class="form-group col-md-3">
                           <label for="proje_muduru_id">Proje Müdürü</label>
                           <select disabled class="form-control select-box required" id="proje_muduru_id">
                               <?php foreach (all_personel() as $emp){
               $emp_id=$emp->id;
               $name=$emp->name;
               ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="genel_mudur_id">Genel Müdür</label>
                                <select disabled class="form-control select-box required" id="genel_mudur_id">
                                    <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                                <div class="form-group col-md-3">
                                <label for="teknika_sorumlu_id">Teknika Sorumlusu</label>
                                <select disabled class="form-control select-box required" id="teknika_sorumlu_id">
                                    <?php foreach (all_personel() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                             <div class="form-group col-md-3">
                                <label for="proje_id">Proje Seçiniz</label>
                                <select disabled class="form-control select-box pm_zorunlu" id="proje_id">
                                  <option value="0">Proje Seçiniz</option>
                                        <?php foreach (all_projects() as $emp){
                    $emp_id=$emp->id;
                    $name=$emp->name;
                    ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                </select>
                            </div>



                        </div>
                    </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        talep_id: talep_id,
                    }

                    let table_report='';
                    $.post(baseurl + 'aracform/get_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        $('#arac_id').val(responses.items.arac_name);

                        $('#lokasyon').val(responses.items.lokasyon)
                        $('#gorev_sebebi').val(responses.items.gorev_sebebi)
                        $('#start_date').val(responses.items.start_date)
                        $('#end_date').val(responses.items.end_date)
                        if(responses.items.proje_id){
                            $('#proje_id').val(responses.items.proje_id).select2().trigger('change');
                        }
                        if(responses.items.benzin_talebi==1){
                            $('#benzin_talebi').click()
                        }
                        else {
                            $('#benzin_talebi').prop('checked',false)
                        }
                        if(responses.items.yemek_talebi==1){
                            $('#yemek_talebi').click()
                        }
                        else {
                            $('#yemek_talebi').prop('checked',false)
                        }
                        $('#benzin_miktari').val(responses.items.benzin_miktari)
                        $('#yemek_tutari').val(responses.items.yemek_tutari)


                        $('#proje_muduru_id').val(responses.users[0].user_id).select2().trigger('change');

                        $('#genel_mudur_id').val(responses.users[1].user_id).select2().trigger('change');
                        $('#teknika_sorumlu_id').val(responses.users[2].user_id).select2().trigger('change');
                    });

                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    cancel: {
                        text: 'Kapat',
                        btnClass: "btn btn-warning",
                    }
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
        })


        function draw_data_notes() {
            $('#surucu_notes_table').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('driver/ajax_list_notes')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'arac_id': <?=$details->id?>}
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
                        text: '<i class="fa fa-truck"></i> Yeni Durum Ekle',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni Durum Ekle',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="location">Lokasyon</label>
      <input type="text" class="form-control" id="location" placeholder="depo">
    </div>
    <div class="form-group col-md-6">
      <label for="status">Durum</label>

     <select class="form-control select-box required" id="status">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (surucu_notes_status() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
   </div>
</div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="teslim_date">Teslim Tarihi</label>
      <input type="datetime-local" class="form-control" id="teslim_date">
    </div>
  <div class="form-group col-md-6">
       <label for="tehvil_date">Tehvil Tarihi</label>
      <input type="datetime-local" class="form-control" id="tehvil_date">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="model">Açıklama</label>
      <input type="desc" class="form-control" id="desc" placeholder="Açıklama">
    </div>
  </div>
  </div>
 <div class="form-row">

      <div class="form-group col-md-6">
      <label for="active_surucu_id">Sürücü</label>
     <select class="form-control select-box required" id="active_surucu_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
     <div class="form-group col-md-6">
      <label for="model">Aktif Sürücüyü Pasif Yap</label>
      <input type="checkbox" class="form-control" id="aktive_pasive" >
    </div>
      </div>
</form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');

                                            let aktive_pasive = $('#aktive_pasive').is(':checked')?1:0;
                                            let data = {
                                                crsf_token: crsf_hash,
                                                location:  $('#location').val(),
                                                active_surucu_id:  $('#active_surucu_id').val(),
                                                desc:  $('#desc').val(),
                                                teslim_date:  $('#teslim_date').val(),
                                                tehvil_date:  $('#tehvil_date').val(),
                                                status:  $('#status').val(),
                                                aktive_pasive:  aktive_pasive,
                                                arac_id:  "<?php echo $details->id ?>",
                                            }
                                            $.post(baseurl + 'driver/surucu_notes_create',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status=='Success'){
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
                                                                    $('#surucu_notes_table').DataTable().destroy();
                                                                    draw_data_notes();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status=='Error'){

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
                    }
                ]
            });
        }

        function dosyalar() {
            $('#dosyalar').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('driver/ajax_list_files')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'arac_id': <?=$details->id?>}
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
                        text: '<i class="fa fa-truck"></i> Yeni Dosya Ekle',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni Dosya Ekle',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="file_name">Dosya Adı</label>
      <input type="text" class="form-control" id="file_name">
    </div>
    <div class="form-group col-md-6">
      <label for="desc">Dosya Açıklaması</label>
      <input type="text" class="form-control" id="desc" >
    </div>

</div>

  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="teslim_date">İşlem Tarihi</label>
      <input type="datetime-local" class="form-control" id="islem_date">
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="status">Teslim Eden Sürücü</label>

     <select class="form-control select-box required" id="teslim_user_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
   </div>
   <div class="form-group col-md-6">
      <label for="status">Teslim Alan Sürücü </label>

     <select class="form-control select-box required" id="tehvil_user_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->name;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
   </div>
  </div>
 <div class="form-row">

      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
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
</form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');

                                            let aktive_pasive =$('#aktive_pasive').is(':checked')?1:0;
                                            let data = {
                                                crsf_token: crsf_hash,
                                                file_name:  $('#file_name').val(),
                                                desc:  $('#desc').val(),
                                                islem_date:  $('#islem_date').val(),
                                                teslim_user_id:  $('#teslim_user_id').val(),
                                                tehvil_user_id:  $('#tehvil_user_id').val(),
                                                image_text:  $('#image_text').val(),
                                                arac_id:  "<?php echo $details->id ?>",
                                            }
                                            $.post(baseurl + 'driver/surucu_files_create',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status=='Success'){
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
                                                                    $('#dosyalar').DataTable().destroy();
                                                                    dosyalar();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status=='Error'){

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
                    }
                ]
            });
        }

        $(document).on('click', ".delete_surucu_notes", function (e) {
            let id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'İptal',
                icon: 'fa fa-trash',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-3 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: '<p>Girilen Durum Bilgisini Silmek İçin Emin Misiniz?</p>',
                buttons: {
                    formSubmit: {
                        text: 'Sil',
                        btnClass: 'btn-red',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                id:id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'driver/surucu_notes_delete',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content:responses.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    $('#surucu_notes_table').DataTable().destroy();
                                                    draw_data_notes();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status=='Error'){

                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat',
                                        content:responses.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                            }
                                        }
                                    });
                                }
                                $('#loading-box').addClass('d-none');
                            })



                        }
                    },
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
        $(document).on('click', ".delete_surucu_files", function (e) {
            let id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'İptal',
                icon: 'fa fa-trash',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-3 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: '<p>Girilen Dosya Bilgisini Silmek İçin Emin Misiniz?</p>',
                buttons: {
                    formSubmit: {
                        text: 'Sil',
                        btnClass: 'btn-red',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                id:id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'driver/surucu_files_delete',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content:responses.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    $('#dosyalar').DataTable().destroy();
                                                    dosyalar();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status=='Error'){

                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat',
                                        content:responses.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                            }
                                        }
                                    });
                                }
                                $('#loading-box').addClass('d-none');
                            })



                        }
                    },
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


        function draw_data_driver() {
            $('#invoices_driver').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                "autoWidth": false,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('aracform/ajax_list_details')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'arac_id':<?=$id?>}
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
            });
        }
        function draw_data_drivers() {
            $('#invoices_drivers').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                "autoWidth": false,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('aracform/ajax_list_details_surucu')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'arac_id':<?=$id?>}
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
                        text: '<i class="fa fa-plus"></i> Yeni Sürücü Ataması',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni Sürücü ',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-8 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                          <label for="asama_id">Yeni Sürücü Seçiniz</label>
                                            <select class="form-control select-box account_id" id="surucu_id">
                                               <?php foreach (all_personel() as $emp){
                                                                    $emp_id=$emp->id;
                                                                    $name=$emp->name;
                                                                    ?>
                                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-row">
                                           <div class="form-group col-md-12">
                                          <label for="marka">Açıqlama / Qeyd</label>
                                          <textarea class="form-control" id="desc"></textarea>
                                        </div>
                                    </div>
                                    </form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Sorğunu Açın',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');

                                            let data = {
                                                crsf_token: crsf_hash,
                                                surucu_id:  $('#surucu_id').val(),
                                                desc:  $('#desc').val(),
                                                arac_id:  "<?php echo $details->id ?>",
                                            }
                                            $.post(baseurl + 'aracform/create_driver',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status==200){
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
                                                                    $('#invoices_drivers').DataTable().destroy();
                                                                    draw_data_drivers();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status==410){

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
                                    }
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
                    }
            ]
            });
        }


        function draw_data_gider(start_date='',end_date) {
            $('#demisbas_list').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('demirbas/ajax_list_gider_firma')?>",
                    'type': 'POST',
                    'data': {
                        'demisbas_id':'<?php echo $details->id;?>',
                        'table_name':'araclar',
                        'start_date':start_date,
                        'end_date':end_date,
                    }
                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,

                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7,8,9,10]
                        }
                    },
                ]
            });
        }


        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            $('#demisbas_list').DataTable().destroy();
            draw_data_gider(start_date, end_date);

        });
    </script>


    <style>

        #demo {
            font-size: 15px;
            font-weight: bolder;
            background: #495770;
            width: fit-content;
            padding: 15px 7px 15px 7px;
            color: white;"
        }

        .badge-warning{
            margin-bottom: 3px;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
            color: #ffffff;
            background-color: #3b475e;
            border-color: #F5F7FA #F5F7FA #F5F7FA;
            height: 64px;
            font-size: 20px;
            margin: auto;
            text-align: center;
            padding: 15px;
            border-radius: 0px;
        }
        .nav-tabs .nav-link{
            height: 64px;
            font-size: 20px;
            margin: auto;
            text-align: center;
            padding: 15px;
            background: #617497;
            color: white;
            border-color: #F5F7FA #F5F7FA #F5F7FA;
            border-radius: 0px;
        }
        .nav.nav-tabs .nav-item:hover{
            color: #fff;
            font-weight: 700;
            background: #7a92bf;
        }
        .jconfirm .jconfirm-box div.jconfirm-content-pane .jconfirm-content {
            overflow: hidden;
        }
        .chat .chat-history {
            padding: 30px 30px 20px;
            border-bottom: 2px solid white;
        }
        .chat .chat-history .message-data {
            margin-bottom: 15px;
        }
        .chat .chat-history .message-data-time {
            color: #a8aab1;
            padding-left: 6px;
        }
        .chat .chat-history .message {
            color: white;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 5px;
            margin-bottom: 30px;
            width: 90%;
            position: relative;
        }
        .chat .chat-history .message:after {
            content: "";
            position: absolute;
            top: -15px;
            left: 20px;
            border-width: 0 15px 15px;
            border-style: solid;
            border-color: #CCDBDC transparent;
            display: block;
            width: 0;
        }
        .chat .chat-history .you-message {
            background: #CCDBDC;
            color:#003366;
        }
        .chat .chat-history .me-message {
            background: #E9724C;
        }
        .chat .chat-history .me-message:after {
            border-color: #E9724C transparent;
            right: 20px;
            top: -15px;
            left: auto;
            bottom:auto;
        }
        .chat .chat-message {
            padding: 30px;
        }
        .chat .chat-message .fa-file-o, .chat .chat-message .fa-file-image-o {
            font-size: 16px;
            color: gray;
            cursor: pointer;
        }

        .chat-ul li{
            list-style-type: none;
        }


        .you {
            color: #CCDBDC;
        }

        .me {
            color: #E9724C;
        }

    </style>


