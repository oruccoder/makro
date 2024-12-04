<div class="content-body">
    <div class="card">
        <div class="card-header">
          <h5><?php echo $this->lang->line('Add New Product Warehouse') ?></h5>
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
                           for="product_catname"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Depo Adı"
                               class="form-control margin-bottom  required" name="product_catname">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Depo Açıklaması"
                               class="form-control margin-bottom" name="product_catdesc">
                    </div>
                </div>
                <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>

                        <div class="col-sm-6">
                            <select name="lid" class="form-control" id="lid">
                                <option value='0'><?php echo $this->lang->line('All') ?></option>
                                <?php
                                foreach ($locations as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['cname'];
                                    $holder = $row['address'];
                                    echo "<option value='$cid'>$acn</option>";
                                }
                                ?>
                            </select>


                        </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                    for="pay_cat"><?php echo $this->lang->line('proje_seciniz') ?></label>
                    <div class="col-sm-6">
                        <select name="proje_id" class="form-control" id="proje_id">
                            <option value='0'><?php echo $this->lang->line('proje_seciniz') ?></option>
                            <?php
                            if(all_projects()!=0)
                            {
                            foreach (all_projects() as $project) {
                                $cid = $project->id;
                                $acn = $project->name;
                                echo "<option value='$cid'>$acn</option>";

                                }
                            }
                            ?>

                        </select>


                    </div>
                    </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="productcategory/addwarehouse" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
</div>

