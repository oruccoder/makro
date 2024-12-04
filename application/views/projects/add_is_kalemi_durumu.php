<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>İş Kalemi Durumu Ekle</h5>
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
        <div class="card card-block">   <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                    <div id="notify" class="alert alert-success" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"></div>
                    </div>
                    <div class="card card-block">


                        <form method="post" id="data_form" class="form-horizontal">



                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="status_name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Durum"
                                           class="form-control margin-bottom  required" name="status_name">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                                    <input type="hidden" value="projects/add_is_kalemi_durumu" id="action-url">
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

