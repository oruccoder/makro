<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5 class="title"> <?php echo $this->lang->line('Business Registers') ?>
            </h5>

            <hr>
            <table id="reg_table" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Employee Username') ?></th>
                    <th><?php echo $this->lang->line('Open Date') ?></th>
                    <th><?php echo $this->lang->line('Close Date') ?></th>
                     <th><?php echo $this->lang->line('Status') ?></th>
                     <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                     <th>#</th>
                    <th><?php echo $this->lang->line('Employee') ?></th>
                    <th><?php echo $this->lang->line('Open Date') ?></th>
                    <th><?php echo $this->lang->line('Close Date') ?></th>
                     <th><?php echo $this->lang->line('Status') ?></th>
                     <th><?php echo $this->lang->line('Action') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">

    $(document).ready(function () {

        $('#reg_table').DataTable({

            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": "<?php echo site_url('register/load_list')?>",
                "type": "POST",
'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],

        });

        $(document).on('click', ".set-task", function (e) {
            e.preventDefault();
            $('#taskid').val($(this).attr('data-id'));

            $('#pop_model').modal({backdrop: 'static', keyboard: false});

        });



        $(document).on('click', ".view_task", function (e) {
            e.preventDefault();

            var actionurl = 'tools/view_task';
            var id = $(this).attr('data-id');
            $('#task_model').modal({backdrop: 'static', keyboard: false});


            $.ajax({

                url: baseurl + actionurl,
                type: 'POST',
                data: {'tid': id},
                dataType: 'json',
                success: function (data) {

                    $('#description').html(data.description);
                    $('#task_title').html(data.name);
                    $('#employee').html(data.employee);
                    $('#assign').html(data.assign);
                    $('#priority').html(data.priority);
                }

            });

        });



    });

</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('Delete') ?> <?php echo $this->lang->line('Register') ?></strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="register/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view_register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Register') ?></h4>

                </div>

                <!-- Modal Body -->
                <div class="modal-body">


                   <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group  text-bold-600 green">
                                    <label for="amount"><?php echo $this->lang->line('Cash') ?>
                                    </label>
                                    <input type="number" class="form-control green" id="r_cash"
                                           value="0.00"
                                           readonly>
                                </div>
                            </div>
                             <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 blue">
                                    <label for="b_change blue"><?php echo $this->lang->line('Card') ?></label>
                                    <input
                                            type="number"
                                            class="form-control blue"
                                            id="r_card" value="0" readonly>
                                </div>
                            </div>
                        </div>

                     <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group  text-bold-600 indigo">
                                    <label for="amount"><?php echo $this->lang->line('Bank') ?>
                                    </label>
                                    <input type="number" class="form-control indigo" id="r_bank"
                                           value="0.00"
                                           readonly>
                                </div>
                            </div>
                             <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 red">
                                    <label for="b_change"><?php echo $this->lang->line('Change') ?>(-)</label>
                                    <input
                                            type="number"
                                            class="form-control red"
                                            id="r_change" value="0" readonly>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>




                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->


        </div>
    </div>
</div>
<script type="text/javascript">


       $(document).on('click', ".set-reg", function (e) {
            e.preventDefault();
        $.ajax({
        url: baseurl + 'register/view',
        dataType: 'json',
                type:'POST',
                data: 'rid='+$(this).attr('data-id'),
        success: function (data) {
            $('#r_cash').val(data.cash);
             $('#r_card').val(data.card);
              $('#r_bank').val(data.bank);
               $('#r_change').val(data.change);
                $('#r_date').text(data.date);
        }
    });

        });

</script>