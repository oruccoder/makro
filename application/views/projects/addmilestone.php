<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Milestone') ?></h5>
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

        <div class="card card-block">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <form method="post" id="data_form" class="form-horizontal">

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('proje_yerleri') ?></label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" id="bolum_id" name="bolum">
                                <?php foreach ($bolumler as $blm)
                                {
                                    $id=$blm['id'];
                                    $name=$blm['name'];
                                    echo "<option value='$id'>$name</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Ana Aşama Adı</label>

                        <div class="col-sm-10">
                            <select name="parent_id"  id="parent_id" class="select-box form-control">

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Milestones Title') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Aşama Adı"
                                   class="form-control margin-bottom  required" name="name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>

                        <div class="col-sm-10">
                            <select name="customer" class="form-control" id="customer_statement">
                                <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                            </select>


                        </div>

                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('sorumlu_personel') ?></label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" name="pers_id">
                                <?php foreach ($personel as $blm)
                                {
                                    $id=$blm['id'];
                                    $name=$blm['name'];
                                    echo "<option value='$id'>$name</option>";
                                } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Measurement Unit') ?></label>

                        <div class="col-sm-4">
                            <select name="olcu_birimi" class="form-control" id="unit">
                                <?php
                                foreach (units() as $row) {
                                    $id = $row['id'];
                                    $cid = $row['code'];
                                    $title = $row['name'];
                                    echo "<option value='$id'>$title - $cid</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Quantity') ?></label>

                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="quantity" id="quantity" value="1">


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Rate') ?></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="fiyat" id="fiyat" value="1">


                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('toplam_fiyat') ?></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="toplam_fiyat" id="toplam_fiyat">


                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Color') ?></label>

                        <div class="col-sm-2">
                            <input id="color" name="color" type="color" class="form-control input-md"
                                   value="#0b97f4">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="butce">Bütçe</label>

                        <div class="col-sm-2">
                            <input id="butce" name="butce" type="text" class="form-control">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Start Date') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="staskdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Due Date') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="End Date" name="taskdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="content"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="projects/addmilestone" id="action-url">
                            <input type="hidden" value="<?php echo $prid ?>" id="proje_id" name="project">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("#customer_statement").select2({
        minimumInputLength: 1,
        tags: [],
        ajax: {
            url: baseurl + 'search/customer_select',
            dataType: 'json',
            type: 'POST',
            quietMillis: 50,
            data: function (customer) {
                return {
                    customer: customer,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.company,
                            id: item.id
                        }
                    })
                };
            },
        }
    });

    $(document).on('change', "#bolum_id", function (e) {
        $("#asama_id option").remove();
        var bolum_id = $(this).val();
        var proje_id = $('#proje_id').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projects/asamalar_list',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#parent_id').append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#parent_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });

    $(function () {
        $('.select-box').select2();

        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });

    $("#fiyat").keyup(function(){
        var fiyat = $('#fiyat').val();
        var quantity =$('#quantity').val();

        var toplam_fiyat = fiyat*quantity;
        $("#toplam_fiyat").val(toplam_fiyat.toFixed(2));

    });

    $("#quantity").keyup(function(){
        var fiyat = $('#fiyat').val();
        var quantity =$('#quantity').val();

        var toplam_fiyat = fiyat*quantity;
        $("#toplam_fiyat").val(toplam_fiyat.toFixed(2));

    });
</script>