<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Depo Düzenle</h5>
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


                <input type="hidden" name="catid" value="<?php echo $warehouse['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="product_cat_name">Warehouse Name</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="product_cat_name"
                               value="<?php echo $warehouse['title'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label">Description</label>

                    <div class="col-sm-8">


                        <input type="text" name="product_cat_desc" class="form-control required"
                               aria-describedby="sizing-addon1" value="<?php echo $warehouse['extra'] ?>">

                    </div>

                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

                    <div class="col-sm-6">
                        <select name="lid" class="form-control">
                            <option value='0'><?php echo $this->lang->line('All') ?></option>
                            <?php
                            foreach ($locations as $row) {
                                $cid = $row['id'];
                                $acn = $row['cname'];
                                $holder = $row['address'];
                                if( $warehouse['loc']==$cid)
                                {
                                    echo "<option selected value='$cid'>$acn</option>";
                                }
                                else
                                    {
                                        echo "<option selected value='$cid'>$acn</option>";
                                    }

                            }
                            ?>
                        </select>


                    </div>
                </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="lid"><?php echo $this->lang->line('proje_seciniz') ?></label>

                <div class="col-sm-6">
                    <select name="proje_id" class="form-control" id="proje_id">
                        <option value='0'><?php echo $this->lang->line('proje_seciniz') ?></option>

                        <?php
                        if(all_projects()!=0)
                        {
                            foreach (all_projects() as $project) {
                                $cid = $project->id;
                                $acn = $project->name;

                                if( $warehouse['proje_id']==$cid)
                                {
                                    echo "<option selected value='$cid'>$acn</option>";
                                }

                                else
                                {
                                    echo "<option value='$cid'>$acn</option>";
                                }

                            }
                        }
                        ?>

                    </select>


                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="lid">Depo Sorumlusu</label>

                <div class="col-sm-6">
                    <select name="pers_id" class="form-control select-box">
                        <option value='0'><?php echo $this->lang->line('All') ?></option>
                        <?php
                        foreach (personel_list() as $row) {
                            $cid = $row['id'];
                            $acn = $row['name'];
                            if( $warehouse['pers_id']==$cid)
                            {
                                echo "<option selected value='$cid'>$acn</option>";
                            }
                            else
                            {
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
                               value="Güncelle" data-loading-text="Updating...">
                        <input type="hidden" value="productcategory/editwarehouse" id="action-url">
                    </div>
                </div>

            </div>
        </form>
                </div>
            </div>
        </div>
    </div>

