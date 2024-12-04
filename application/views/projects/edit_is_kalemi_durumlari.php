<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">İŞ KALEMI DURUMU DÜZENLE</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
<div class="content-body">
    <div class="card">
        <div class="card-body">
            <div class="tab-content px-3 pt-3">
                <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                    <div id="notify" class="alert alert-success" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"></div>
                    </div>

                    <div class=" card-block">

                        <form method="post" id="data_form" class="form-horizontal">


                            <input type="hidden" name="catid" value="<?php echo $is_kalemi_durumlari['id'] ?>">


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label" for="product_cat_name">İsim</label>

                                <div class="col-sm-8">
                                    <input type="text"
                                           class="form-control margin-bottom  required" name="product_cat_name"
                                           value="<?php echo $is_kalemi_durumlari['name'] ?>">
                                </div>
                            </div>



                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                           value="Güncelle" data-loading-text="Updating...">
                                    <input type="hidden" value="projects/edit_is_kalemi_durumlari" id="action-url">
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    <footer style="margin-top: 400px">

    </footer>
    </div>

