<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<div class="content-body">
    <div class="card">
        <div class="card-header">
             <h5>Yeni İzin Ekle</h5>
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

             

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('why') ?></label>

                    <div class="col-sm-4">
                       <input type="text" placeholder="İzin Nedeni"
                               class="form-control margin-bottom  required" name="description">
                    </div>
                </div>
                        <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('starting date') ?></label>

                     <div class="col-sm-2">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control  required" id="tsn_due"
                                                   name="baslangic_tarihi"
                                                   placeholder="Başlangıç Tarihi" data-toggle="datepicker" autocomplete="false">
                                        </div>
                        <div class="col-sm-2">

                                            <input type="text" class="form-control  required" id="baslangic_saati"
                                                   name="baslangic_saati"
                                                   placeholder="Başlangıç Saati Ör:14:00" >
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
                                                   placeholder="Bitiş Tarihi" data-toggle="datepicker" autocomplete="false">
                                        </div>
                    <div class="col-sm-2">

                        <input type="text" class="form-control  required" id="bitis_saati"
                               name="bitis_saati"
                               placeholder="Bitiş Saati Ör:16:00">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <input type="hidden" id="action-url" value="employee/permissions_action">

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data"  class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('add permission') ?>" data-loading-text="Adding...">

                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
</div>

