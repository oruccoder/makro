<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Add Promo') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="code"><?php echo $this->lang->line('Code') ?></label>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Code"
                               class="form-control margin-bottom  required" name="code" value="<?php echo $this->coupon->generate(8) ?>">
                    </div>
                </div>
                    <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="amount"><?php echo $this->lang->line('Amount') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Amount"
                               class="form-control margin-bottom  required" name="amount" value="0">
                    </div>
                </div>

                     <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="qty"><?php echo $this->lang->line('Qty') ?></label>

                    <div class="col-sm-2">
                        <input type="number" placeholder="Amount"
                               class="form-control margin-bottom  required" name="qty" value="1">
                    </div>
                </div>

                  <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="valid"><?php echo $this->lang->line('Valid') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required"
                               placeholder="Start Date" name="valid"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>
                 <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="link_ac"><?php echo $this->lang->line('Link to account') ?></label>

                    <div class="col-sm-2">
                      <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="link_ac" class="custom-control-input" value="yes" >
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">Yes</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="link_ac" class="custom-control-input" value="no" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">No</span>
                                            </label>
                                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="pay_acc"><?php echo $this->lang->line('Account') ?></label>

                    <div class="col-sm-4">
                        <select name="pay_acc" class="form-control">
                            <?php
                            foreach ($accounts as $row) {
                                $cid = $row['id'];
                                $acn = $row['acn'];
                                $holder = $row['holder'];
                                echo "<option value='$cid'>$acn - $holder</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="note"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="Short Note"
                               class="form-control margin-bottom" name="note" >
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="promo/create" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>
<script type="text/javascript">

</script>