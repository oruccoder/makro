<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5><?php echo $this->lang->line('Products') ?></h5>

            <hr>
            <table id="productstable" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Stock') ?></th>
                        <th><?php echo $this->lang->line('Code') ?></th>
                        <th><?php echo $this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('Price') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Stock') ?></th>
                        <th><?php echo $this->lang->line('Code') ?></th>
                        <th><?php echo $this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('Price') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#productstable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('products/product_list') . '?id=' . $_GET['id']; ?>",
                "type": "POST",
                'data': {
                    '<?= $this->security->get_csrf_token_name() ?>': crsf_hash
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],

        });
        $(document).on('click', ".view-object", function(e) {
            e.preventDefault();
            $('#view-object-id').val($(this).attr('data-object-id'));

            $('#view_model').modal({
                backdrop: 'static',
                keyboard: false
            });

            var actionurl = $('#view-action-url').val();
            $.ajax({
                url: baseurl + actionurl,
                data: 'id=' + $('#view-object-id').val() + '&' + crsf_token + '=' + crsf_hash,
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    $('#view_object').html(data);

                }

            });

        });
    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="view_model" class="modal  fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
            </div>
            <div class="modal-body" id="view_object">
                <p></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="view-object-id" value="">
                <input type="hidden" id="view-action-url" value="products/view_over">

                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Close') ?></button>
            </div>
        </div>
    </div>
</div>