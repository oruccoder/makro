<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yeni Hesap</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <?php
                                        $attributes = array('class' => 'form-horizontal', 'id' => 'data_form');
                                        echo form_open('',$attributes);
                                        ?>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="accno"><?php echo $this->lang->line('Account No') ?></label>

                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Account Number"
                                                       class="form-control margin-bottom required" name="accno">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="holder"><?php echo $this->lang->line('Name') ?></label>

                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Name"
                                                       class="form-control margin-bottom required" name="holder">
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="invoice_para_birimi"><?php echo $this->lang->line('odeme_para_birimi') ?></label>

                                            <div class="col-sm-6">
                                                <select name="para_birimi" id="para_birimi" class="form-control">
                                                    <?php
                                                    foreach (para_birimi()  as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['code'];
                                                        echo "<option value='$cid'>$title</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="acode"><?php echo $this->lang->line('Note') ?></label>

                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Note"
                                                       class="form-control margin-bottom" name="acode">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="lid"><?php echo $this->lang->line('kasa_tipi') ?></label>

                                            <div class="col-sm-6">
                                                <select name="kasa_tipi" class="form-control">
                                                    <?php

                                                    foreach (account_type() as $row) {
                                                        $cid = $row['id'];
                                                        $acn = $row['name'];
                                                        $holder = $row['address'];
                                                        echo "<option value='$cid'>$acn</option>";
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="lid">Sorumlu Personel</label>

                                            <div class="col-sm-6">
                                                <select name="account_eid" class="form-control select-box" id="account_eid">
                                                    <?php

                                                    foreach (personel_list() as $row) {
                                                        $cid = $row['id'];
                                                        $acn = $row['name'];
                                                        $holder = $row['address'];
                                                        echo "<option value='$cid'>$acn</option>";
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"></label>

                                            <div class="col-sm-4">
                                                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                                       value="<?php echo $this->lang->line('Add Account') ?>" data-loading-text="Adding...">
                                                <input type="hidden" value="accounts/addacc" id="action-url">
                                            </div>
                                        </div>


                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

