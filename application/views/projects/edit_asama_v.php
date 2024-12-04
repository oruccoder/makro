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

                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Milestones Title') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Aşama Adı"
                                   class="form-control margin-bottom  required" name="name" value="<?= $edit_data['name'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Ana Aşama Adı</label>

                        <div class="col-sm-10">
                            <select name="parent_id" class="select-box form-control">
                                <option>Seçiniz</option>
                                <?php foreach (all_bolum_asama($prid) as $parent)
                                {
                                    if($edit_data['parent_id']==$parent->id)
                                    {
                                        echo "<option selected value='$parent->id'>$parent->name</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='$parent->id'>$parent->name</option>";
                                    }

                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>

                        <div class="col-sm-10">
                            <select name="customer" class="form-control" id="customer_statement">
                                <?php echo '<option value="' . $edit_data['customer_id'] . '">' . customer_details($edit_data['customer_id'])['company'] . '</option>'; ?>

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
                                    if($edit_data['pers_id']==$id)
                                    {
                                        echo "<option selected value='$id'>$name</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='$id'>$name</option>";
                                    }

                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Measurement Unit') ?></label>

                        <div class="col-sm-4">
                            <select name="olcu_birimi" class="form-control">
                                <option value=''>Yok</option>
                                <?php
                                foreach (units() as $row) {
                                    $id = $row['id'];
                                    $cid = $row['code'];
                                    $title = $row['name'];
                                    if($edit_data['olcu_birimi']==$id)
                                    {
                                        echo "<option selected value='$id'>$title - $cid</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='$id'>$title - $cid</option>";
                                    }

                                }
                                ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Quantity') ?></label>

                        <div class="col-sm-4">
                            <input type="number" value="<?=$edit_data['quantity'] ?>" class="form-control" name="quantity" id="quantity">


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Rate') ?></label>

                        <div class="col-sm-4">
                            <input type="text"  value="<?=$edit_data['fiyat'] ?>" class="form-control" name="fiyat" id="fiyat" >


                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('toplam_fiyat') ?></label>

                        <div class="col-sm-4">
                            <input type="text"   value="<?=$edit_data['toplam'] ?>" class="form-control" name="toplam_fiyat" id="toplam_fiyat">


                        </div>
                    </div>



                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('proje_yerleri') ?></label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" name="bolum">
                                <?php
                                foreach ($bolumler as $blm)
                                {

                                    $id=$blm['id'];
                                    $name=$blm['name'];
                                    if($edit_data['bolum_id']==$id)
                                    {
                                        echo "<option selected value='$id'>$name</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='$id'>$name</option>";
                                    }

                                } ?>
                            </select>
                        </div>
                    </div>




                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Color') ?></label>

                        <div class="col-sm-2">
                            <input id="color" name="color" type="color" class="form-control input-md"
                                   value="#0b97f4" value="<?= $edit_data['color'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="butce">Bütçe</label>

                        <div class="col-sm-2">
                            <input id="butce" value="<?= $edit_data['total'] ?>" name="butce" type="text" class="form-control">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Start Date') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required editdate"
                                   placeholder="Start Date" name="staskdate" value="<?= $edit_data['sdate'] ?>"
                                   autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Due Date') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required editdate"
                                   placeholder="End Date" name="taskdate" value="<?= $edit_data['edate'] ?>"
                                   autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="content"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"><?= $edit_data['exp'] ?></textarea>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">

                            <input type="hidden" value="projects/edit_asama" id="action-url">
                            <input type="hidden" value="<?= $edit_data['id']  ?>" name="asama_id"  id="asama_id">
                            <input type="hidden" value="<?php echo $prid ?>" name="project">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.editdate').datepicker({autoHide: true, format: 'yyyy-mm-dd'});
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

