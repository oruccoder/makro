<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<div class="content-body">
     <div class="card">
        <div class="card-header">
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
    <div class="card-content">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Add').' '.$this->lang->line('Attendance') ?></h5>
                <hr>

<div class="form-group row"> 

                    <label class="col-sm-3 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Employees') ?></label>

                    <div class="col-sm-6">
                        <select name="employee[]" class="form-control required select-box" multiple="multiple">
                            <?php
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                 <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="from"><?php echo $this->lang->line('Date') ?></label>

                                <div class="col-sm-2">
                                    <input type="text" class="form-control b_input required"
                                           placeholder="Start Date" name="adate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="todate"><?php echo $this->lang->line('From') ?></label>

                                <div class="col-sm-2">
                                    <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control input-small timepicker1" name="from">
            <span class="input-group-addon"><i class="icon-clock"></i></span>
        </div>
                                </div>
                            </div>
                 <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="todate"><?php echo $this->lang->line('To') ?></label>

                                <div class="col-sm-2">
                                  <div class="input-group bootstrap-timepicker timepicker">
            <input type="text" class="form-control input-small timepicker2" name="to">
            <span class="input-group-addon"><i class="icon-clock"></i></span>
        </div>
                                </div>
                            </div>

                <div class="form-group row">

                    <label class="col-sm-3 col-form-label" for="note"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="Note"
                               class="form-control margin-bottom b_input" name="note">
                    </div>
                </div>



                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="employee/attendance" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>
 <script type="text/javascript">
            $('.timepicker1').timepicker('setTime', '09:00 AM');
            $('.timepicker2').timepicker('setTime', '05:00 PM');
            $('.select-box').select2();
        </script>