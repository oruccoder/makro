<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <div class="message"></div>
                </div>
                <div class="card-body">
                         <form method="post" id="data_form" class="form-horizontal">

                    <h5><?php echo $this->lang->line('Add New Note') ?></h5>
                    <hr>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name">Personel</label>

                        <div class="col-sm-10">
                            <select class="form-control select-box" name="pers_id">

                                <?php foreach (personel_list() as $emp){
                                    $emp_id=$emp['id'];
                                    $name=$emp['name'];
                                    ?>
                                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                     <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Title') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Note Title"
                                   class="form-control margin-bottom  required" name="title">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-10">
                            <textarea class="summernote"
                                      placeholder=" Note"
                                      autocomplete="false" rows="10" name="content">MÜŞTERİ ADI SOYADI:</br> MÜŞTERİ TEL: </br>GÖRÜŞME SAATİ: </br>SEBEP: </br> </textarea>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add Note') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="tools/addnote" id="action-url">
                        </div>
                    </div>


                </form>
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
</script>