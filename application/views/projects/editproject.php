<link href="<?php echo base_url(); ?>assets/portcss/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<script src='<?php echo base_url(); ?>assets/portjs/moment.min.js'></script>
<script src="<?php echo base_url(); ?>assets/portjs/fullcalendar.min.js"></script>
<script src='<?php echo base_url(); ?>assets/portjs/bootstrap-colorpicker.min.js'></script>
<script src='<?php echo base_url('assets/portjs/main.js') . APPVER; ?>'></script>

<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h5><?php echo $this->lang->line('Edit Project') ?></h5>
            </div>
        </div>


    <div class="content">
        <div class="content-body">
            <div class="card">
                <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">

                        <form method="post" id="data_form" class="form-horizontal">



                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Project Title') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Project Title"
                               class="form-control margin-bottom  required" name="name"
                               value="<?php echo $project['name'] ?>">
                    </div>
                </div>



                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_adresi"><?php echo $this->lang->line('project_adresi') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Adresi"
                               class="form-control margin-bottom  required" value="<?php echo $project['project_adresi'] ?>" name="project_adresi">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_sehir"><?php echo $this->lang->line('project_sehir') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Şehri"
                               class="form-control margin-bottom  required" value="<?php echo $project['project_sehir'] ?>" name="project_sehir">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_yetkili_adi"><?php echo $this->lang->line('proje_yetkili_adi') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Yetkili Adı"
                               class="form-control margin-bottom  required" value="<?php echo $project['project_yetkili_adi'] ?>" name="project_yetkili_adi">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_yetkili_no"><?php echo $this->lang->line('project_yetkli_no') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Yetkili Numarası"
                               class="form-control margin-bottom  required" value="<?php echo $project['project_yetkili_no'] ?>" name="project_yetkili_no">
                    </div>
                </div>
                <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="project_yetkili_email"><?php echo $this->lang->line('project_yetkili_email') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Proje Yetkili E-Mail"
                                   class="form-control margin-bottom  required" name="project_yetkili_email" value="<?php echo $project['project_yetkili_email'] ?>"
                        </div>
                    </div>
                </div>



                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Status') ?></label>

                    <div class="col-sm-4">
                        <select name="status" class="form-control">
                            <?php foreach ($project_status as $ps )
                            {
                                $id=$ps['id'];
                                $name=$ps['name'];
                                if($project['status']==$id){
                                ?>
                                <option selected value="<?php echo $id; ?>"><?php echo $name; ?></option>
                            <?php  } else { ?>
                                    <option  value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                <?php
                                }

                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="progress"><?php echo $this->lang->line('Progress') ?>
                        (%)</label>

                    <div class="col-sm-10">
                        <input type="range" min="0" max="100" value="<?php echo $project['progress'] ?>" class="slider"
                               id="progress" name="progress">
                        <p><span id="prog"></span></p>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Priority') ?></label>

                    <div class="col-sm-4">
                        <select name="priority" class="form-control">

                            <?php foreach ($project_derece as $ps )
                            {
                                $id=$ps['id'];
                                $name=$id=$ps['name'];
                                if($project['priority']==$id){
                                    ?>
                                    <option selected value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                <?php  } else { ?>
                                    <option  value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                    <?php
                                }

                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>

                    <div class="col-sm-10">
                        <select name="customer" class="form-control" id="customer_statement">
                            <?php echo '<option value="' . $project['cid'] . '">' . $project['customer'] . '</option>'; ?>

                        </select>


                    </div>

                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name"><?php echo $this->lang->line('Customer Can View') ?></label>

                    <div class="col-sm-4">
                        <select name="customerview" class="form-control">

                            <?php if( $project['meta_data']=='true')
                            {
                                echo '<option selected value="true">Evet</option>';
                                echo '<option  value="true">Hayır</option>';
                            } else {
                                echo '<option  value="true">Evet</option>';
                                echo '<option selected  value="true">Hayır</option>';
                            } ?>

                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name"><?php echo $this->lang->line('Customer Can Comment') ?></label>

                    <div class="col-sm-4">
                        <select name="customercomment" class="form-control">

                            <?php if( $project['value']=='true')
                            {
                                echo '<option selected value="true">Evet</option>';
                                echo '<option  value="true">Hayır</option>';
                            } else {
                                echo '<option  value="true">Evet</option>';
                                echo '<option selected  value="true">Hayır</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="worth"><?php echo $this->lang->line('Budget') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Budget"
                               class="form-control margin-bottom  required" name="worth"
                               value="<?php echo $project['worth'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sozlesme_tutari"><?php echo $this->lang->line('sozlesme_tutari') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Sözleşmede Anlaşılan Rakam"
                               class="form-control margin-bottom  " name="sozlesme_tutari"
                               value="<?php echo $project['sozlesme_tutari'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sozlesme_numarasi"><?php echo $this->lang->line('sozlesme_numarasi') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Sözleşme Numarası"
                               class="form-control margin-bottom" name="sozlesme_numarasi"  value="<?php echo $project['sozlesme_numarasi'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sozlesme_tarihi"><?php echo $this->lang->line('sozlesme_tarihi') ?></label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required"
                               placeholder="Sözleşme Tarihi" name="sozlesme_date"
                               data-toggle="datepicker" autocomplete="false" value="<?php echo $project['sozlesme_date'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="proje_muduru"><?php echo $this->lang->line('proje_muduru') ?></label>

                    <div class="col-sm-8">
                        <select name="proje_muduru" class="form-control required select-box">
                            <?php
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                if($project['proje_muduru_id']==$cid)
                                {
                                    echo "<option selected value='$cid'>$title</option>";
                                }
                                else
                                {
                                    echo "<option value='$cid'>$title</option>";
                                }

                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="proje_sorumlusu_id">Proje Sorumlusu</label>

                    <div class="col-sm-8">
                        <select name="proje_sorumlusu_id" class="form-control required select-box">
                            <?php
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                if($project['proje_sorumlusu_id']==$cid)
                                {
                                    echo "<option selected value='$cid'>$title</option>";
                                }
                                else
                                {
                                    echo "<option value='$cid'>$title</option>";
                                }

                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="muhasebe_muduru_id">Muhasebe Müdürü</label>

                    <div class="col-sm-8">
                        <select name="muhasebe_muduru_id" class="form-control required select-box">
                        <?php
                        foreach ($emp as $row) {
                            $cid = $row['id'];
                            $title = $row['name'];
                            if($project['muhasebe_muduru_id']==$cid)
                            {
                                echo "<option selected value='$cid'>$title</option>";
                            }
                            else
                            {
                                echo "<option value='$cid'>$title</option>";
                            }

                        }
                        ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="genel_mudur_id">Genel Müdür</label>

                    <div class="col-sm-8">
                        <select name="genel_mudur_id" class="form-control required select-box">
                        <?php
                        foreach ($emp as $row) {
                            $cid = $row['id'];
                            $title = $row['name'];
                            if($project['genel_mudur_id']==$cid)
                            {
                                echo "<option selected value='$cid'>$title</option>";
                            }
                            else
                            {
                                echo "<option value='$cid'>$title</option>";
                            }

                        }
                        ?>
                        </select>


                    </div>
                </div>





                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Start Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required edate"
                               placeholder="Start Date" name="sdate"
                                autocomplete="false" value="<?php echo dateformat($project['sdate']) ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Due Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required edate"
                               placeholder="End Date" name="edate"
                                autocomplete="false" value="<?php echo dateformat($project['edate']) ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name">Takvimde Göster</label>

                    <div class="col-sm-4">
                        <select name="link_to_cal" class="form-control" id="link_to_cal">
                            <option value='0'>Hayır</option>
                            <option value='1'>Bitiş Tarihini İşaretle</option>
                            <option value='2'>Başlangıç Tarihini İşaretle</option>
                        </select>
                    </div>
                </div>

                <div id="hidden_div" class="row " style="display: none">
                    <label class="col-md-2 control-label" for="color">Color</label>
                    <div class="col-md-4">
                        <input id="color" name="color" type="text" class="form-control input-md"
                               readonly="readonly"/>
                        <span class="help-block">Renk Seçiniz</span>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="content"><?php echo $this->lang->line('Note') ?></label>

                    <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10"
                                  name="content"><?php echo $project['note'] ?></textarea>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="tags"><?php echo $this->lang->line('Tags') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Tags"
                               class="form-control margin-bottom " name="tags"
                               value="<?php echo $project['tag'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name">Bildirimler</label>

                    <div class="col-sm-4">

                        <select name="ptype" class="form-control">

                            <?php if( $project['ptype']==0)
                            {
                                echo '<option selected value="0">Hayır</option>';
                                echo '<option  value="1">Personllere Mail İlet</option>';
                                echo '<option  value="2">Personel ve Müşteriye Mail İlet</option>';
                            } else if( $project['ptype']==1) {
                                echo '<option  value="0">Hayır</option>';
                                echo '<option selected  value="1">Personllere Mail İlet</option>';
                                echo '<option  value="2">Personel ve Müşteriye Mail İlet</option>';
                            }
                            else {
                                 echo '<option  value="0">Hayır</option>';
                                echo '<option   value="1">Personllere Mail İlet</option>';
                                echo '<option selected value="2">Personel ve Müşteriye Mail İlet</option>';

                            }?>


                        </select>

                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Assign to') ?></label>

                    <div class="col-sm-8">
                        <select name="employee[]" class="form-control select-box" multiple="multiple">
                            <?php
                            foreach ($emp2 as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid' selected>- $title -</option>";
                            }
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

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="projects/edit" id="action-url">
                        <input type="hidden" value="<?php echo $project['prj'] ?>" name="p_id">

                    </div>
                </div>


            </form>
                </div>
             </div>
        </div>
    </div>
</div>
<script type="text/javascript">

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

    $("#customer_statement").select2({
        minimumInputLength: 4,
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
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
        }
    });

    $('.edate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});

    var slider = $('#progress');
    var textn = $('#prog');
    textn.text(slider.val() + '%');
    $(document).on('change', slider, function (e) {
        e.preventDefault();
        textn.text($('#progress').val() + '%');

    });

</script>
