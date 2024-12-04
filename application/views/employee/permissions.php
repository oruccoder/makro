<div class="content-body">
    <div class="card">
        <div class="card-header">

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <form method="post" id="data_form" class="form-horizontal">
                    <table id="" class="table table-striped table-bordered zero-configuration table-responsive"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Modül</th>
                            <?php foreach (role_name() as $rol)
                            {?>
                                <th><?php echo  $rol['name'] ?></th>
                            <?php } ?>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;

                        foreach ($permission as $row) {
                            $i = $row['id'];
                            $module = $row['module'];

                            echo "<tr>
                            <td>$i</td>
                            <td>$module</td>"; ?>

                            <td><input type="checkbox" name="r_<?= $i ?>_1"
                                       class="m-1" <?php if ($row['r_1']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_2"
                                       class="m-1" <?php if ($row['r_2']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_3"
                                       class="m-1" <?php if ($row['r_3']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_4"
                                       class="m-1" <?php if ($row['r_4']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_5"
                                       class="m-1" <?php if ($row['r_5']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_6"
                                       class="m-1" <?php if ($row['r_6']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_7"
                                       class="m-1" <?php if ($row['r_7']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_8"
                                       class="m-1" <?php if ($row['r_8']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_9"
                                       class="m-1" <?php if ($row['r_9']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_10"
                                       class="m-1" <?php if ($row['r_10']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_11"
                                       class="m-1" <?php if ($row['r_11']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_12"
                                       class="m-1" <?php if ($row['r_12']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_13"
                                       class="m-1" <?php if ($row['r_13']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_14"
                                       class="m-1" <?php if ($row['r_14']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_15"
                                       class="m-1" <?php if ($row['r_15']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_16"
                                       class="m-1" <?php if ($row['r_16']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_17"
                                       class="m-1" <?php if ($row['r_17']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_18"
                                       class="m-1" <?php if ($row['r_18']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_19"
                                       class="m-1" <?php if ($row['r_19']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_20"
                                       class="m-1" <?php if ($row['r_20']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_21"
                                       class="m-1" <?php if ($row['r_21']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_22"
                                       class="m-1" <?php if ($row['r_22']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_23"
                                       class="m-1" <?php if ($row['r_23']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_24"
                                       class="m-1" <?php if ($row['r_24']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_25"
                                       class="m-1" <?php if ($row['r_25']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_26"
                                       class="m-1" <?php if ($row['r_26']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_27"
                                       class="m-1" <?php if ($row['r_27']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_28"
                                       class="m-1" <?php if ($row['r_28']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_29"
                                       class="m-1" <?php if ($row['r_29']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_30"
                                       class="m-1" <?php if ($row['r_30']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_31"
                                       class="m-1" <?php if ($row['r_31']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_32"
                                       class="m-1" <?php if ($row['r_32']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_33"
                                       class="m-1" <?php if ($row['r_33']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_34"
                                       class="m-1" <?php if ($row['r_34']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_35"
                                       class="m-1" <?php if ($row['r_35']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_36"
                                       class="m-1" <?php if ($row['r_36']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_37"
                                       class="m-1" <?php if ($row['r_37']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_38"
                                       class="m-1" <?php if ($row['r_38']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_39"
                                       class="m-1" <?php if ($row['r_39']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_40"
                                       class="m-1" <?php if ($row['r_40']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_41"
                                       class="m-1" <?php if ($row['r_41']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_42"
                                       class="m-1" <?php if ($row['r_42']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_43"
                                       class="m-1" <?php if ($row['r_43']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_44"
                                       class="m-1" <?php if ($row['r_44']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_45"
                                       class="m-1" <?php if ($row['r_45']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_46"
                                       class="m-1" <?php if ($row['r_46']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_47"
                                       class="m-1" <?php if ($row['r_47']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_48"
                                       class="m-1" <?php if ($row['r_48']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_49"
                                       class="m-1" <?php if ($row['r_49']) echo 'checked="checked"' ?>></td>
                            <?php
                            echo "
                    </tr>";
                            //  $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Modül</th>
                            <?php foreach (role_name() as $rol)
                            {?>
                                <th><?php echo  $rol['name'] ?></th>
                            <?php } ?>

                        </tr>
                        </tfoot>
                    </table>
                    <div class="form-group row">

                        <div class="col-sm-1"></div>

                        <div class="col-sm-6">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom btn-lg"
                                   value="<?php echo $this->lang->line('Update') ?>"
                                   data-loading-text="Adding...">
                            <input type="hidden" value="employee/permissions_update" id="action-url">
                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#emptable').DataTable({responsive: true});


    });

</script>



