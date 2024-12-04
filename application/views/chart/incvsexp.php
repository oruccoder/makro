<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">
            <h5><?= $this->lang->line('Income') . ' vs ' .  $this->lang->line('Income') . ' '.$this->lang->line('Graphical Reports') ?></h5>

            <hr>
            <div class="form-group">
                <!-- basic buttons -->
                <button type="button"
                        class="update_chart btn btn-primary btn-min-width btn-lg mr-1 mb-1" data-val="week"><?= $this->lang->line('This') . ' ' . $this->lang->line('Week') ?></button>
                <button type="button"
                        class="update_chart btn btn-secondary btn-min-width  btn-lg mr-1 mb-1" data-val="month"><?= $this->lang->line('This') . ' ' . $this->lang->line('Month') ?></button>
                <button type="button"
                        class="update_chart btn btn-success btn-min-width  btn-lg mr-1 mb-1" data-val="year"><?= $this->lang->line('This') . ' ' . $this->lang->line('Year') ?></button>
                <button type="button"
                        class="update_chart btn btn-info btn-min-width  btn-lg mr-1 mb-1" data-val="custom"><?= $this->lang->line('Custom Range') . ' ' . $this->lang->line('Date') ?></button>

            </div>
<form id="chart_custom">
            <div id="custom_c" class="form-group card card-block" style="display: none ">
                <div class="col-md-4">
                    <label class="col-md-4 control-label"
                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                    <div class="col-md-8">
                        <input type="text" class="form-control required date30"
                               placeholder="Start Date" name="sdate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>
                <div class="col-md-4">

                    <label class="col-md-4 control-label"
                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                    <div class="col-md-8">
                        <input type="text" class="form-control required"
                               placeholder="End Date" name="edate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>
                <div class="col-md-4">
 <input type="hidden" name="p"
                              value="custom">


                 <button type="button" id="custom_update_chart"
                        class="btn btn-blue-grey btn-min-width  mr-1 mb-1">Submit</button>
                </div>
            </div>
    </form>
            <div class="card-body collapse in">
                <div class="card-block">
                    <div id="cat-chart" height="400"></div>
                </div>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {
        var cat_data = [
            <?php foreach ($chart as $item) {
                if($item['type']=='Income'){ echo '{label: "' . $item['type']. '", value: ' .$item['credit'] . ' },'; }
                 elseif($item['type']=='Expense'){  echo '{label: "' . $item['type']. '", value: ' . $item['debit'] . ' },';}
        }
            ?>
        ];
        draw_c(cat_data);
    });

    function draw_c(cat_data) {
        var cat_color = ['#4DB380','#E64D66',
        ];
        $('#cat-chart').empty();

        Morris.Donut({
            element: 'cat-chart',
            data: cat_data,
            resize: true,
            colors: cat_color,
            gridTextSize: 6,
            gridTextWeight: 400
        });
    }


$(document).on('click', ".update_chart", function (e) {
    e.preventDefault();
var a_type =$(this).attr('data-val');
if(a_type=='custom'){
    $('#custom_c').show();
}
else {
    $.ajax({
        url: baseurl + 'chart/incvsexp_update',
        dataType: 'json',
        method: 'POST',
        data: {'p': $(this).attr('data-val'),'<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'},
        success: function (data) {
            draw_c(data);
        }


    });
}
});


    $(document).on('click', "#custom_update_chart", function (e) {
    e.preventDefault();
    $.ajax({
        url: baseurl + 'chart/incvsexp_update',
        dataType: 'json',
        method: 'POST',
        data: $('#chart_custom').serialize()+'&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash(); ?>',
        success: function (data) {
            draw_c(data);
        }
    });

});


</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Customer</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this customer?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>