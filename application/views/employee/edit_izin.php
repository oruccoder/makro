<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 30.01.2020
 * Time: 16:41
 */
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $title; ?></h5>
            <hr>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="card card-block">


                    <form method="post" id="data_form" class="card-body">

                        <input type="hidden" name="izin_id" value="<?php echo $details->id?>">
                        <input type="hidden" name="emp_id" value="<?php echo $details->emp_id?>">


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_catname"><?php echo $this->lang->line('why') ?></label>

                            <div class="col-sm-4">
                                <input type="text" placeholder="İzin Nedeni"
                                       class="form-control margin-bottom  required" value="<?php echo $details->izin_sebebi ?>" name="description">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_catname"><?php echo $this->lang->line('starting date') ?></label>

                            <div class="col-sm-2">
                                <div class="input-group-addon"><span class="icon-calendar-o"
                                                                     aria-hidden="true"></span></div>

                                <input  class="form-control required"
                                       name="baslangic_tarihi"
                                       placeholder="Başlangıç Tarihi" value="<?php echo dateformat($details->bas_date )?>">
                            </div>
                            <div class="col-sm-2">

                                <input type="text" class="form-control  required" id="baslangic_saati"
                                       name="baslangic_saati" value="<?php echo $details->bas_saati ?>" placeholder="Başlangıç Saati Ör:14:00" >
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_catname"><?php echo $this->lang->line('end date') ?></label>

                            <div class="col-sm-2">
                                <div class="input-group-addon"><span class="icon-calendar-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control  required"
                                       name="bitis_tarihi"
                                       placeholder="Bitiş Tarihi"  value="<?php echo dateformat($details->bitis_date )?>"  autocomplete="false">
                            </div>
                            <div class="col-sm-2">

                                <input type="text" class="form-control  required" id="bitis_saati"
                                       name="bitis_saati"  value="<?php echo $details->bit_saati ?>"
                                       placeholder="Bitiş Saati Ör:16:00">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_catname"><?php echo $this->lang->line('izin_tipi') ?></label>

                            <div class="col-sm-4">
                               <select name="izin_tipi"  class="form-control">
                                   <?php if($details->izin_tipi=='Ücretli') {?>
                                   <option selected value="Ücretli">Ücretli</option>
                                   <option value="Ücretsiz">Ücretsiz</option>
                                   <?php }
                                   else if($details->izin_tipi=='Ücretsiz') {?>
                                       <option  value="Ücretli">Ücretli</option>
                                       <option selected value="Ücretsiz">Ücretsiz</option>
                                   <?php }
                                   else  {?>
                                       <option>Seçiniz</option>
                                       <option  value="Ücretli">Ücretli</option>
                                       <option  value="Ücretsiz">Ücretsiz</option>
                                   <?php }
                                   ?>
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="status"><?php echo $this->lang->line('Status') ?></label>

                            <div class="col-sm-4">
                               <select name="status" class="form-control">
                                   <?php if($details->status==0) {?>
                                   <option selected value="0">Bekliyor</option>
                                   <option value="1">Onaylandı</option>
                                   <option value="2">Red Edildi</option>
                                   <?php }
                                   if($details->status==1) {?>
                                   <option  value="0">Bekliyor</option>
                                   <option selected value="1">Onaylandı</option>
                                   <option value="2">Red Edildi</option>
                                   <?php }
                                   if($details->status==2) {?>
                                       <option  value="0">Bekliyor</option>
                                       <option  value="1">Onaylandı</option>
                                       <option selected value="2">Red Edildi</option>
                                   <?php }?>

                               </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <input type="hidden" id="action-url" value="employee/izin_duzenle_action">

                            <div class="col-sm-4">
                                <input type="submit" id="submit-data"  class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('izin_duzenle') ?>" data-loading-text="Adding...">

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

