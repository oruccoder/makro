<article class="content">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card card-block">

        <div class="card card-block">
            <h4><?php echo $this->lang->line('Profit').' '.$this->lang->line('Data') ?></h4>
            <hr>

            <div class="row sameheight-container">
                <div class="col-md-6">
                        <ul>
                        <li class="font-large-x1 blue "><?php echo $this->lang->line('Total') . ' ' . $this->lang->line('Profit') ?>
                            <span id="p1" class="font-large-x1 red float-xs-right"><i class=" icon-refresh spinner"></i></span>
                        </li>
                        <hr>
                        <li class="font-large-x1 green"><?php echo $this->lang->line('Total') . ' ' . $this->lang->line('Month') . ' ' . $this->lang->line('Profit') ?>
                            <span id="p2" class="font-large-x1 blue float-xs-right"><i
                                        class=" icon-refresh spinner"></i></span></li>


                        <li class="font-large-x1 orange" id="param1"></li>

                    </ul>
                </div>

            </div>

        </div>

    </div>
    <div class="card card-block">
        <div class="card card-block">
            <form method="post" id="product_action" class="form-horizontal">
                <div class="grid_3 grid_4">
                    <h6><?php echo $this->lang->line('Custom Range') ?></h6>
                    <hr>


                    <div class="form-group row">

                        <label class="col-sm-3 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>

                        <div class="col-sm-6">
                            <select name="pay_acc" class="form-control">
                                <option value='0'><?php echo $this->lang->line('All') ?></option>
                                <?php
                                foreach ($locations as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['cname'];
                                    $holder = $row['address'];
                                    echo "<option value='$cid'>$acn - $holder</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-3 control-label"
                               for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="sdate" id="sdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3 control-label"
                               for="edate"><?php echo $this->lang->line('To Date') ?></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control required"
                                   placeholder="End Date" name="edate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-3 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="hidden" name="check" value="ok">
                            <input type="submit" id="calculate_profit" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Calculate') ?>"
                                   data-loading-text="Calculating...">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</article>
<script type="text/javascript" >
    $("#calculate_profit").click(function (e) {
    e.preventDefault();
    var actionurl= baseurl + 'reports/customprofit';
    actionCaculate(actionurl);
});

            setTimeout(function () {
        $.ajax({
            url: baseurl + 'reports/fetch_data?p=profit',
            dataType: 'json',
            success: function (data) {
                $('#p1').html(data.p1);
                $('#p2').html(data.p2);

            },
            error: function (data) {
                $('#response').html('Error')
            }

        });
    }, 2000);
    </script>