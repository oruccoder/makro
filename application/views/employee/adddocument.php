<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Upload New Document') ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>


<div class="content">
    <div class="card">
        <div class="card-body">
        <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                <?php if ($response == 1) {
                    echo '<div id="notify" class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
                } else if ($response == 0) {
                    echo '<div id="notify" class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
                } ?>
                <?php if(isset($_GET['id'])) { ?>

                    <div class="grid_3 grid_4">


                        <?php echo form_open_multipart('employee/adddocument'); ?>
                        <input type="hidden" value="<?= $id ?>" name="id">

                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label" for="name">Başlangıç Tarihi</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control  required"
                                       placeholder="Billing Date" name="baslangic_date" id="baslangic_date"
                                       data-toggle="datepicker"
                                       autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label" for="name">Bitiş Tarihi</label>

                            <div class="col-sm-6">

                                <input type="text" class="form-control  required"
                                       placeholder="Billing Date" name="bitis_date" id="bitis_date"
                                       data-toggle="datepicker"
                                       autocomplete="false">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('Title') ?></label>

                            <div class="col-sm-6">
                                <input type="text" placeholder="Document Title"
                                       class="form-control margin-bottom  required" name="title">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label" for="name">Dosya Tipi</label>

                            <div class="col-sm-6">
                               <select class="form-control" id="file_type" name="file_type">
                                    <?php foreach(personel_file_type() as $items){
                                        echo "<option value='$items->id'>$items->name</option>";
                                    }?>
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label" for="name">Etibarname İçin Araç Seçiniz</label>

                            <div class="col-sm-6">
                               <select class="form-control select-box" id="arac_id" name="arac_id">
                                   <option value="0">Seçiniz</option>
                                    <?php foreach(araclar() as $items){
                                        echo "<option value='$items->id'>$items->name</option>";
                                    }?>
                               </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('Document') ?>
                                (docx,docs,txt,pdf,xls)</label>

                            <div class="col-sm-6">
                                <input type="file" name="userfile" size="20"/>
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="submit" id="document_add" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Upload Document') ?>" data-loading-text="Adding...">
                            </div>
                        </div>


                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
</div>
