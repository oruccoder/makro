<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
        <h5>Randevu Ekle</h5>
                    </div>
                    </div>
                    </div>



<div class="content">
    <div class="card">
        <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="name">Personel</label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" name="personel_l">

                                <?php foreach (personel_list() as $emp){
                                    $emp_id=$emp['id'];
                                    $name=$emp['name'];
                                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Konu</label>
                        <div class="col-md-10">
                            <input id="title" name="title" type="text" class="form-control input-md"/>
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
                                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Kurum / Firma</label>

                        <div class="col-sm-10">
                            <input id="kurum_firma" name="kurum_firma" type="text" class="form-control input-md"/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Yetkili Kişi</label>
                        <div class="col-md-10">
                            <input id="yetkkili_kisi" name="yetkkili_kisi" type="text" class="form-control input-md"/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Telefon</label>
                        <div class="col-md-10">
                            <input id="telefon" name="telefon" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Görüşme Sebebi</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Randevu Başlangıç Tarihi</label>
                        <div class="col-md-10">
                           <input type="datetime-local" class="form-control" name="baslangic" id="baslangic">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="title">Randevu Bitiş Tarihi</label>
                        <div class="col-md-10">
                           <input type="datetime-local" class="form-control" name="bitis">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="etkinlik_saati">Durum</label>
                        <div class="col-md-10">
                            <select class="form-control" id="status" name="status">
                                <option value="0">Bekliyor</option>
                                <option value="2">Onaylandı</option>
                                <option value="1">Görüşme Tamamlandı</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-2 control-label"
                               for="etkinlik_saati">Görüşme Adresi</label>
                        <div class="col-md-10">
                            <select class="form-control" id="adres_id" name="adres_id">
                               <?php foreach (adresler() as $value)
                               {
                                   echo "<option value='$value->id'>$value->name</option>";
                               } ?>
                            </select>
                        </div>
                    </div>



                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Oluştur" data-loading-text="Adding...">
                            <input type="hidden" value="events/addEventT" id="action-url">
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
