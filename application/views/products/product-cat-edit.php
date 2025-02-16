<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="card card-block">

                <h5>Edit Product Category</h5>
                <hr>


                <input type="hidden" name="catid" value="<?php echo $productcat['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="product_cat_name">Category Name</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="product_cat_name"
                               value="<?php echo $productcat['title'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Sub Category Name') ?></label>

                    <div class="col-sm-6">
                        <select name="cat_rel" class="form-control">
                            <option value="0">Ana Kategori Seçiniz</option>
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                if($productcat['parent_id']==$cid)
                                {
                                    echo "<option selected value='$cid'>$title</option>";
                                }

                                else
                                    {
                                        echo "<option value='$cid'>$title</option>";
                                    }

                            }
                            ?>
                        </select>

                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label">Description</label>

                    <div class="col-sm-8">


                        <input type="text" name="product_cat_desc" class="form-control required"
                               aria-describedby="sizing-addon1" value="<?php echo $productcat['extra'] ?>">

                    </div>

                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Update" data-loading-text="Updating...">
                        <input type="hidden" value="productcategory/editcat" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>

