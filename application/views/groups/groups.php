<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> Cari qurupları</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <a href="<?php echo base_url('clientgroup/create') ?>" class="btn btn-primary btn-sm rounded"><i
                        class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i></a>
            <table id="cgrtable" class="table datatable-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Total Clients') ?></th>
                    <th>ACTİON</th>
                </tr>
                </thead>

                <tbody class="table datatable-responsive" cellspacing="0" width="100%">
                <?php $i = 1;
                foreach ($group as $row) {
                    $cid = $row['id'];
                    $title = $row['name'];
                    $total = $row['pc'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$total</td>
                    
                    <td>
                    
                    <a title='DÜZENLE' href='" . base_url("clientgroup/editgroup?id=$cid") . "' class='btn btn-warning btn-xs'><i class='fa fa-pen'></i></a>&nbsp
                    <a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='SİL'><i class='fa fa-trash'></i></a>
                    </td>
                    </tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#cgrtable').DataTable({
            responsive: true,
            dom: 'Blfrtip',
            buttons: []
        });

    });
</script>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Discount'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model">
                    <p>
                        <?php echo $this->lang->line('you can pre-define the discount') ?>
                    </p>
                    <input type="hidden" id="dobject-id" name="gid" value="">


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Discount') ?></label>
                            <input name="disc_rate" class="form-control mb-1" type="number"
                                   placeholder="Discount Rate in %">


                        </div>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="clientgroup/discount_update">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Customer Group') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this customer group') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="clientgroup/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', ".discount-object", function (e) {
        e.preventDefault();
        $('#dobject-id').val($(this).attr('data-object-id'));
        $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
        $('#pop_model').modal({backdrop: 'static', keyboard: false});
    });
</script>