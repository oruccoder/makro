<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">
            <h5><?= $this->lang->line('Trending Products') . ' ' . $this->lang->line('Graphical Reports') ?></h5>

            <hr>
            <div class="form-group">
                <!-- basic buttons -->
                <button type="button"
                        class="update_chart btn btn-primary btn-min-width btn-lg mr-1 mb-1"
                        data-val="week"><?= $this->lang->line('This') . ' ' . $this->lang->line('Week') ?></button>
                <button type="button"
                        class="update_chart btn btn-secondary btn-min-width  btn-lg mr-1 mb-1"
                        data-val="month"><?= $this->lang->line('This') . ' ' . $this->lang->line('Month') ?></button>
                <button type="button"
                        class="update_chart btn btn-success btn-min-width  btn-lg mr-1 mb-1"
                        data-val="year"><?= $this->lang->line('This') . ' ' . $this->lang->line('Year') ?></button>
                <button type="button"
                        class="update_chart btn btn-info btn-min-width  btn-lg mr-1 mb-1"
                        data-val="custom"><?= $this->lang->line('Custom Range') . ' ' . $this->lang->line('Date') ?></button>

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
                                class="btn btn-blue-grey btn-min-width  mr-1 mb-1">Submit
                        </button>
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
            echo '{y: "' . $item['product_name'] . '", a: ' . $item['qty'] . ' },';
        }
            ?>
        ];
        draw_c(cat_data);
    });

    function draw_c(cat_data) {
        $('#cat-chart').empty();
        Morris.Bar({
            element: 'cat-chart',
            data: cat_data,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Qty'],
            barColors: [
                '#4D8000',
            ],
            barFillColors: [
                '#34cea7',
            ],
            barOpacity: 0.6,
        });
    }

    $(document).on('click', ".update_chart", function (e) {
        e.preventDefault();
        var a_type = $(this).attr('data-val');
        if (a_type == 'custom') {
            $('#custom_c').show();
        }
        else {
            $.ajax({
                url: baseurl + 'chart/trending_products_update',
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
            url: baseurl + 'chart/trending_products_update',
            dataType: 'json',
            method: 'POST',
          data: $('#chart_custom').serialize()+'&<?=$this->security->get_csrf_token_name()?>=<?=$this->security->get_csrf_hash(); ?>',
            success: function (data) {
                draw_c(data);
            }
        });

    });


</script>