<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">

                    <h5>Randevu Düzenle</h5>
                    <hr>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Personel</label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" name="personel_l">

                                <?php foreach (personel_list() as $emp){
                                    $emp_id=$emp['id'];
                                    $name=$emp['name'];
                                    if($details->pers_id==$emp_id){
                                        echo "<option selected value='$emp_id'>$name</option>";
                                    }
                                    else
                                        {
                                            echo "<option value='$emp_id'>$name</option>";
                                        }
                                    ?>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Konu</label>
                        <div class="col-md-10">
                            <input id="title"  value="<?php echo $details->title?>" name="title" type="text" class="form-control input-md"/>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Cari</label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" name="cari_id">

                                <option value="">Seçiniz</option>
                                <?php foreach (all_customer() as $emp){
                                    $emp_id=$emp->id;
                                    $name=$emp->company;
                                    if($details->customer_id==$emp_id){
                                        echo "<option selected value='$emp_id'>$name</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='$emp_id'>$name</option>";
                                    }
                                    ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Kurum / Firma</label>

                        <div class="col-sm-10">
                            <input id="kurum_firma" name="kurum_firma" value="<?php echo $details->kurum_firma?>" type="text" class="form-control input-md"/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Yetkili Kişi</label>
                        <div class="col-md-10">
                            <input id="yetkkili_kisi" name="yetkkili_kisi"  value="<?php echo $details->yetkkili_kisi?>"  type="text" class="form-control input-md"/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Telefon</label>
                        <div class="col-md-10">
                            <input id="telefon" name="telefon" value="<?php echo $details->telefon?>" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Görüşme Sebebi</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="description"  name="description"><?php echo $details->description?></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Randevu Başlangıç Tarihi</label>
                        <div class="col-md-10">
                            <input type="datetime-local" class="form-control" name="baslangic"  value="<?php echo date_ajanda($details->etkinlik_saati).'T'.$details->etkinlik_saati_rel?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Randevu Bitiş Tarihi</label>
                        <div class="col-md-10">
                            <input type="datetime-local" class="form-control" name="bitis"  value="<?php echo date_ajanda($details->etkinlik_saati_bitis).'T'.$details->etkinlik_saati_bitis_rel?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Görüşme Başlangıç Tarihi</label>
                        <div class="col-md-10">
                            <input type="datetime-local" class="form-control" name="g_baslangic" value="<?php echo date_ajanda($details->g_baslama_date).'T'.$details->g_baslama_date_rel?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Görüşme Bitiş Tarihi</label>
                        <div class="col-md-10">
                            <input type="datetime-local" class="form-control" name="g_bitis" value="<?php echo date_ajanda($details->g_bitis_date).'T'.$details->g_bitis_date_rel?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Görüşmeye Personel Davet Et</label>
                        <div class="col-md-10">
                            <select class="form-control select-box" name="personel_yen[]" id="personel_yen" multiple style="width: 47%;">

                                <?php foreach (personel_list() as $emp){
                                    $emp_id=$emp['id'];
                                    $name=$emp['name'];
                                    $personeller=randevu_personelleri_list($details->id);
                                    if(in_array($emp_id,$personeller))
                                    {
                                        echo "<option selected value='$emp_id'>$name</option>";
                                    }
                                    else
                                        {
                                            echo "<option value='$emp_id'>$name</option>";
                                        }

                                    ?>
                                <?php } ?>
                            </select>

                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="etkinlik_saati">Durum</label>
                        <div class="col-md-10">
                            <select class="form-control" id="status" name="status">
                                <?php if($details->status==0)
                                {
                                    ?>
                                    <option selected value="0">Bekliyor</option>
                                    <option value="2">Onaylandı</option>
                                    <option value="1">Görüşme Tamamlandı</option>
                                    <option  value="3">Görüşme Ertele</option>
                                    <option  value="4">İptal Et</option>
                                    <?php
                                }
                                else if($details->status==2)
                                {
                                    ?>
                                    <option  value="0">Bekliyor</option>
                                    <option selected value="2">Onaylandı</option>
                                    <option value="1">Görüşme Tamamlandı</option>
                                    <option  value="3">Görüşme Ertele</option>
                                    <option  value="4">İptal Et</option>
                                    <?php
                                }
                                else if($details->status==1)
                                {
                                    ?>
                                    <option  value="0">Bekliyor</option>
                                    <option  value="2">Onaylandı</option>
                                    <option selected value="1">Görüşme Tamamlandı</option>
                                    <option  value="3">Görüşme Ertele</option>
                                    <option  value="4">İptal Et</option>
                                    <?php
                                }

                                else if($details->status==3)
                                {
                                    ?>
                                    <option  value="0">Bekliyor</option>
                                    <option  value="2">Onaylandı</option>
                                    <option  value="1">Görüşme Tamamlandı</option>
                                    <option selected value="3">Görüşme Ertele</option>
                                    <option  value="4">İptal Et</option>
                                    <?php
                                }
                                else if($details->status==4)
                                {
                                    ?>
                                    <option  value="0">Bekliyor</option>
                                    <option  value="2">Onaylandı</option>
                                    <option  value="1">Görüşme Tamamlandı</option>
                                    <option  value="3">Görüşme Ertele</option>
                                    <option selected  value="4">İptal Et</option>
                                    <?php
                                }

                                ?>


                            </select>
                        </div>
                    </div>



                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Düzenle" data-loading-text="Adding...">

                            <input type="hidden" value="events/updateEventT" id="action-url">
                            <input type="hidden" value="<?php echo $details->id?>" name="id">
                        </div>
                    </div>




                </form>
            </div>
        </div>
    </div>
</div>
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
    });
</script>