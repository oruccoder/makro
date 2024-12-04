<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 13:33
 */
?>
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Gider Kalemleri</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <a class="btn btn-danger box-shadow--4dp ripple has-ripple" style="color: #ffffff;" onclick='editgider(0,"")' type="button"><i class="fa fa-plus"></i>&nbsp;Yeni Ana Masraf Kalemi Ekle</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <div class="row">
                            <?php foreach ($ana_gider_kalemleri as $gd) { ?>

                                <div class="col-xl-6 col-lg-6 col-xs-6">
                                    <section class="panel panel-primary">
                                        <header class="panel-heading">
                                            <a style="color: white" onclick="editgider('<?php echo $gd->id ?>','<?php echo $gd->name ?>')" ><?php echo $gd->name;?></a>
                                            <span class="pull-right">
                                            <button style="padding: 1px 12px;" class="btn btn-warning" onclick="EditSubAccount('<?php echo $gd->id ?>','', '<?php echo $gd->name ?>',0,'',0)" type="button">Alt Gider Ekle <i class="fa fa-plus"></i></button>
                                        </span>
                                        </header>
                                        <div class="panel-body">
                                            <?php foreach ($alt_gider_kalemleri as $agd) {
                                                if($agd->parent_id==$gd->id){
                                                    ?>
                                                    <a class="btn btn-success" onclick="EditSubAccount('<?php echo $gd->id ?>', '<?php echo $agd->id ?>', '<?php echo $gd->name ?>',1,'<?php echo $agd->name ?>',<?php echo $agd->unit ?>)" style="color: white;margin-top: 4px; margin-right:4px;"><?php echo $agd->name ?></a>
                                                <?php }
                                            } ?>
                                        </div>
                                    </section>

                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="sub_gider_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Gider Kalemi Tanımlama</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"
                               for="name">Ana Kalem</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control margin-bottom" id="ana_gider">
                            <input type="hidden" name="ana_gider_id" id="ana_gider_id">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-4 col-form-label"
                               for="phone">Gider Kalemi</label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Elektrik" class="form-control margin-bottom" name="gider_kalemi" id="gider_kalemi">
                            <input type="hidden" name="gider_id" id="gider_id">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-4 col-form-label"
                               for="phone">Birim</label>

                        <div class="col-sm-8">
                            <select name="unit" id="unit" class="form-control">
                                <option value="0">Seçiniz</option>
                                <?php
                                foreach (units() as $row) {
                                    $id = $row['id'];
                                    $cid = $row['code'];
                                    $title = $row['name'];
                                    echo "<option value='$id'>$cid</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

               </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="type" name="type" value="">
                <input type="hidden" id="action-url">
                <input type="hidden" id="delete-url" value="cost/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger"
                        id="deleteGider">Sil</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="addGiderButton">Kaydet</button>

                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>


<div id="gider_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Ana Masraf Kalemi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"
                               for="name">Ana Masraf Kalemi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control margin-bottom" id="ana_gider_name">
                            <input type="hidden" name="ana_gider_id2" id="ana_gider_id2">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="type" name="type" value="">
                <input type="hidden" id="action-url" value="cost/anaUpdate">
                <input type="hidden" id="delete-url" value="cost/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger"
                        id="deleteGider2">Sil</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="updateGiderButton">Kaydet</button>

                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function editgider(id,name) {
        $('#ana_gider_name').val(name);
        $('#ana_gider_id2').val(id);
        $('#gider_model').modal({backdrop: 'static', keyboard: false});
    }
    function EditSubAccount(id,alt_id, ana_gider, type,$parent_value,unit) {

        $('#gider_kalemi').val('');
        $('#unit option:selected').removeAttr("selected");
        $('#type').val('');
        $('#gider_id').val(alt_id);
        $('#ana_gider_id').val(id);
        $('#action-url').val('cost/gider_kalemi_i');
        if(type==0)
        {
            $('#deleteGider').css('display','none');
        }
        else
            {
                $('#deleteGider').css('display','block');
            }

        $('#ana_gider').val(ana_gider);
        $('#gider_kalemi').val($parent_value);
        $("#unit option[value="+unit+"]").attr('selected', 'selected');
        $('#type').val(type);
        $('#sub_gider_model').modal({backdrop: 'static', keyboard: false});
    }

    $("#addGiderButton").on("click", function() {
        var o_data = 'id=' + $('#ana_gider_id').val()+'&alt_id=' + $('#gider_id').val()+'&gider_kalemi='+ $('#gider_kalemi').val()+'&unit='+ $('#unit').val()+'&type='+ $('#type').val();
        var action_url= $('#sub_gider_model #action-url').val();
        addObject(o_data,action_url);
    });

    $("#deleteGider").on("click", function() {
        var o_data = 'id=' + $('#gider_id').val();
        var action_url= $('#sub_gider_model #delete-url').val();
        addObject(o_data,action_url);
    });

    $("#deleteGider2").on("click", function() {
        var o_data = 'id=' + $('#ana_gider_id2').val();
        var action_url= $('#gider_model #delete-url').val();
        addObject(o_data,action_url);
    });

    $("#updateGiderButton").on("click", function() {
        var o_data = 'id=' + $('#ana_gider_id2').val()+'&gider_kalemi='+ $('#ana_gider_name').val();
        var action_url= $('#gider_model #action-url').val();
        addObject(o_data,action_url);
    });

</script>
<style>

    .panel-heading {
        border-bottom: 1px dotted rgba(0, 0, 0, 0.2);
        padding: 15px;
        text-transform: uppercase;
        color: #535351;
        font-size: 14px;
        font-weight: bold;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    .panel-primary>.panel-heading {
        color: #fff;
        background-color: #337ab7;
        border-color: #337ab7;
    }
    .panel
    {
        border: none;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
</style>

