<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                Randevular <a href="<?php echo base_url('events/addrandevu') ?>"
                              class="btn btn-primary btn-sm rounded">
                    <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i>
                </a>
            </h5>
        </div>
        <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">

                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="grid_3 grid_4">

                    <p>&nbsp;</p>
                    <table id="notestable" class="table table-striped table-bordered zero-configuration" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Randevu Personeli</th>
                            <th>Kurum / Firma</th>
                            <th>Yetkili Kişi</th>
                            <th>Konu</th>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi </th>
                            <th>Durum </th>
                            <th><?php echo $this->lang->line('Action') ?></th>
                            <th>Gerçekleşen Baş.T</th>
                            <th>Gerçekleşen Bit.T</th>


                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function draw_data_notes() {
            $('#notestable').DataTable({

                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "ajax": {
                    "url": "<?php echo site_url('events/randevu_load')?>",
                    "type": "POST",
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": false,
                    },
                ],

            });
        }

        $(document).ready(function () {

            draw_data_notes();

        });

    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this note') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="tools/delete_note">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function gorusme_durumu(id) {
            jQuery.ajax({
                url: baseurl + 'tools/gorusme_onayla?id='+id,
                type: 'POST',
                data: $('#data_form').serialize(),
                dataType: 'json',
                beforeSend: function(){
                    $(this).html('Bekleyiniz');
                    $(this).prop('disabled', true); // disable button

                },
                success: function (data) {
                    if (data.status == "Success") {

                        $('#invoice-template').remove();
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            });

        }

    </script>
