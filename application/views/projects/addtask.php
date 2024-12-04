<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Task') ?></h5>
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
    </div>
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">


            <form method="post" id="data_form" class="form-horizontal">

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name">İş Kalemi Tipi</label>

                    <div class="col-sm-10">

                        <select name="gorev_tipi" class="form-control">
                            <option value="1">Hizmet</option>
                            <option value="2">Stok</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name">İş Kalemi Adı</label>

                    <div class="col-sm-10">

                        <input name="name" class="form-control">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Milestones') ?></label>

                    <div class="col-sm-4">
                        <select name="milestone" class="form-control select-box" id="milestone">
                            <?php
                            foreach ($milestones as $row) {
                                $cid = $row['id'];
                                $parent_id = $row['parent_id'];
                                $bolum_name=bolum_getir($row['bolum_id']);

                                if($parent_id!=0)
                                {
                                    $title=$bolum_name.'-'.task_to_asama($parent_id).'-'.$row['name'];
                                }
                                else
                                {
                                    $title=$row['name'].'-'.$bolum_name;
                                }

                                echo "<option value='$cid'>$title </option>";

                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Quantity') ?></label>

                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="quantity" id="quantity">


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Measurement Unit') ?></label>

                    <div class="col-sm-4">
                        <select name="unit" class="form-control" id="olcu_birimi">
                            <option value=''>Yok</option>
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
                           for="pay_cat"><?php echo $this->lang->line('Rate') ?></label>

                    <div class="col-sm-4">
                        <input type="text"  class="form-control" name="fiyat" id="fiyat">


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat">Oran(%)</label>

                    <div class="col-sm-4">
                        <input   class="form-control" name="oran" id="oran">


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('toplam_fiyat') ?></label>

                    <div class="col-sm-4">
                        <input type="text"   class="form-control" name="toplam_fiyat" id="toplam_fiyat">


                    </div>
                </div>

                <!--div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="olcu_birimi"><?php echo $this->lang->line('Measurement Unit') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Ölçü Birimi"
                               class="form-control margin-bottom " name="olcu_birimi">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="miktar"><?php echo $this->lang->line('Quantity') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Miktar"
                               class="form-control margin-bottom " name="miktar">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="fiyati"><?php echo $this->lang->line('iscilik_price') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="İşçilik Fiyatı"
                               class="form-control margin-bottom " name="price">
                    </div>
                </div-->

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Status') ?></label>

                    <div class="col-sm-4">
                        <select name="status" class="form-control">
                            <?php foreach ($task_status as $tsk)
                            { $id=$tsk['id'];
                                $name=$tsk['name'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Priority') ?></label>

                    <div class="col-sm-4">
                        <select name="priority" class="form-control">
                            <option value='Low'>Düşük</option>
                            <option value='Medium'>Orta</option>
                            <option value='High'>Yüksek</option>
                            <option value='Urgent'>Acil</option>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat">İş Listesi</label>

                    <div class="col-sm-4">
                        <select name=simeta_status class="form-control" id="simeta_status">
                            <option value="1">İş Listesinde Var</option>
                            <option value="2">İş Listesinde Yok</option>
                        </select>
                    </div>
                </div>





                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Bill To') ?></label>

                    <div class="col-sm-4">
                        <select name="cari_id" class="form-control select-box">
                            <option value="0">Cari Seçiniz</option>
                            <?php
                            foreach ($cari as $row) {
                                $cid = $row['id'];
                                $title = $row['company'];
                                echo "<option value='$cid'>$title </option>";
                            }
                            ?>
                        </select>


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

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Task Assign to') ?></label>

                    <div class="col-sm-4">
                        <select name="employee" class="form-control select-box">
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
                <!--div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="content"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                    </div>
                </div-->

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add Task') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="projects/save_addtask" id="action-url">
                        <input type="hidden" value="<?php echo $prid ?>" name="project">
                    </div>

                </div>
                <div class="form-group row"><label class="col-sm-2 col-form-label"></label>
                    <p>E-posta iletişimi etkinse, işlem zaman alabilir.</p></div>


            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(function () {
        $('.select-box').select2();


        $(".hizmet").select2({
            tags: true
        });

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

    $(document).on('change', '#milestone', function(){
        var asama_id = $(this).val();
        var actionurl='projects/asama_bilgi_ajax'
        $.ajax({
            url: baseurl + actionurl,
            type: 'POST',
            data: {'asama_id': asama_id,'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            dataType: 'json',
            success: function (data) {
                $('#quantity').val(data.quantity);
                $("#olcu_birimi").val(data.olcu_birimi);
                $("#fiyat").val(data.fiyat);


            }

        });


    });

    $("#oran").keyup(function(){
        var fiyat = $('#fiyat').val();
        var quantity =$('#quantity').val();
        var oran =$(this).val();
        if($(this).val()!='')
        {
            oran =$(this).val();
        }
        else
        {
            oran = 100;
        }
        var toplam_fiyat = (fiyat*quantity*oran)/100;
        $("#toplam_fiyat").val(toplam_fiyat.toFixed(2));

    });
</script>