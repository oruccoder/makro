<link href="<?php echo base_url(); ?>assets/portcss/bootstrap-colorpicker.min.css" rel="stylesheet"/>
<script src='<?php echo base_url(); ?>assets/portjs/moment.min.js'></script>
<script src="<?php echo base_url(); ?>assets/portjs/fullcalendar.min.js"></script>
<script src='<?php echo base_url(); ?>assets/portjs/bootstrap-colorpicker.min.js'></script>
<script src='<?php echo base_url('assets/portjs/main.js') . APPVER; ?>'></script>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Project') ?></h5>
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
       
         <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                            


            <form method="post" id="data_form" class="form-horizontal">

               

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Project Title') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Adı"
                               class="form-control margin-bottom  required" name="name">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_adresi"><?php echo $this->lang->line('project_adresi') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Adresi"
                               class="form-control margin-bottom  required" name="project_adresi">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_sehir"><?php echo $this->lang->line('project_sehir') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Şehri"
                               class="form-control margin-bottom  required" name="project_sehir">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_yetkili_adi"><?php echo $this->lang->line('proje_yetkili_adi') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Yetkili Adı"
                               class="form-control margin-bottom  required" name="project_yetkili_adi">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_yetkili_no"><?php echo $this->lang->line('project_yetkli_no') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Yetkili Numarası"
                               class="form-control margin-bottom  required" name="project_yetkili_no">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="project_yetkili_email"><?php echo $this->lang->line('project_yetkili_email') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Proje Yetkili E-Mail"
                               class="form-control margin-bottom  required" name="project_yetkili_email">
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
                              ?>
                              <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                              <?php  } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="progress"><?php echo $this->lang->line('Progress') ?>
                        (%)</label>

                    <div class="col-sm-10">
                        <input type="range" min="0" max="100" value="0" class="slider" id="progress" name="progress">
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
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                            <?php  } ?>
                        </select>


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

                    <label class="col-sm-2 col-form-label"
                           for="name"><?php echo $this->lang->line('Customer Can View') ?></label>

                    <div class="col-sm-4">
                        <select name="customerview" class="form-control">
                            <option value='true'>Evet</option>
                            <option value='false'>Hayır</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name"><?php echo $this->lang->line('Customer Can Comment') ?></label>

                    <div class="col-sm-4">
                        <select name="customercomment" class="form-control">
                            <option value='true'>Evet</option>
                            <option value='false'>Hayır</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="worth"><?php echo $this->lang->line('Budget') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Projeye Ayrılan Tahmini Bütçe"
                               class="form-control margin-bottom  " name="worth">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sozlesme_tutari"><?php echo $this->lang->line('sozlesme_tutari') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Sözleşmede Anlaşılan Rakam"
                               class="form-control margin-bottom  " name="sozlesme_tutari">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sozlesme_numarasi"><?php echo $this->lang->line('sozlesme_numarasi') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Sözleşme Numarası"
                               class="form-control margin-bottom  " name="sozlesme_numarasi">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sozlesme_tarihi"><?php echo $this->lang->line('sozlesme_tarihi') ?></label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required"
                               placeholder="Sözleşme Tarihi" name="sozlesme_date"
                               data-toggle="datepicker" autocomplete="false">
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
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Project Assign to') ?></label>

                    <div class="col-sm-8">
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

                <div class="form-group row" style="display: none">

                    <label class="col-sm-2 col-form-label" for="phase"><?php echo $this->lang->line('Project Phase') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Aşama1,Aşama2,Aşama3,Aşama..."
                               class="form-control margin-bottom  " name="phase">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Start Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required"
                               placeholder="Start Date" name="sdate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Due Date') ?></label>

                    <div class="col-sm-2">
                        <input type="text" id="pdate_2" class="form-control required edate"
                               placeholder="End Date" name="edate"
                              autocomplete="false" value="<?php echo dateformat(date('Y-m-d', strtotime('+30 days', strtotime(date('Y-m-d'))))) ?>">
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

                <div id="hidden_div" class="row form-group" style="display: none">
                    <label class="col-md-2 control-label" for="color">Renk</label>
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
                                  autocomplete="false" rows="10" name="content"></textarea>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="tags"><?php echo $this->lang->line('Tags') ?></label>

                    <div class="col-sm-10">
                        <input type="text" placeholder="Etiketler"
                               class="form-control margin-bottom" name="tags">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name">Bildirimler</label>

                    <div class="col-sm-4">
                        <select name="ptype" class="form-control">
                            <option value='0'>Hayır</option>
                            <option value='1'>Personllere Mail İlet</option>
                            <option value='2'>Personel ve Müşteriye Mail İlet</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('project_add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="projects/addproject" id="action-url">

                    </div>
                </div>


            </form>
        </div>
    </div>
</article>
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

    $('.edate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    var slider = $('#progress');
    var textn = $('#prog');
    textn.text(slider.val() + '%');
    $(document).on('change', slider, function (e) {
        e.preventDefault();
        textn.text($('#progress').val() + '%');

    });
</script>
    </div>
    </div>