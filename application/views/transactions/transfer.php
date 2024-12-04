<div class="content-body">
    <div class="card">
        <div class="card-header">
           <h5><?php echo $this->lang->line('Add New Transfer') ?></h5>
                <hr>
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
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">
              


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('From Account') ?></label>

                    <div class="col-sm-6">
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

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('To Account') ?></label>

                    <div class="col-sm-6">
                        <select name="pay_acc2" class="form-control">
                            <?php
                            foreach ($accounts as $row) {
                                $cid = $row['id'];
                                $acn = $row['acn'];
                                $holder = $row['holder'];
                                $para_birimi = $row['para_birimi'];
                                echo "<option para_birimi='' value='$cid'>$acn - $holder</option>";
                            }
                            ?>
                        </select>


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

                    <label class="col-sm-2 col-form-label"
                           for="invoice_kur_degeri">Kur</label>

                    <div class="col-sm-3">
                        <input type="text" class="form-control round" placeholder="Kur"
                               name="kur_degeri" id="kur_degeri" value="1">
                        <span id="str_alert"></span>
                    </div>
                    <div class="col-sm-3">
                        <a style="color: #fff;" class="btn btn-success kur" id="kur_al"><?php echo $this->lang->line('online_button') ?></a>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="amount"><?php echo $this->lang->line('Amount') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Amount"
                               class="form-control margin-bottom  required" name="amount">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add transaction') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="transactions/save_transfer" id="action-url">
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
        <input type="hidden" class="form-control required"
               name="date" data-toggle="datepicker" id="invoice_date"
               autocomplete="false">
</div>
    <script>
   
        $('#kur_al').click(function () {
            var para_birimi=$('#para_birimi').val();
            var invoice_date=$('#invoice_date').val();
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/kur_al',
                data: 'para_birimi='+ para_birimi+
                    '&invoice_date='+ invoice_date,
                success: function (data) {
                    $('#kur_degeri').val(data);

                }
            });


        });
        </script>
