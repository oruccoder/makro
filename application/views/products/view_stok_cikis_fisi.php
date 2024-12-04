<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="thermal_a" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="invoice-template" class="card-body">
                <div class="row">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col-lg-12">
                            <?php
                            $validtoken = hash_hmac('ripemd160', $stok_cikis['id'], $this->config->item('encryption_key'));

                            $link = base_url('billing/view?id=' . $stok_cikis['id'] . '&token=' . $validtoken);
                            if ($stok_cikis['status'] != 'canceled') { ?>
                                <div class="title-action">

                                    <a href="<?php echo 'stok_cikis?id=' . $stok_cikis['id']; ?>" class="btn btn-warning mb-1"><i
                                                class="icon-pencil"></i> <?php echo $this->lang->line('edit_stok_fisi') ?></a>

                                    <?php
                                    $href='sc_print_fis?id='. $stok_cikis['id'];
                                    ?>

                                    <a href="<?php echo $href; ?>" target="_blank" class="btn btn-success mb-1 btn-min-width"><i
                                                class="icon-print"></i> <?php echo $this->lang->line('print_fis') ?></a>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row mt-2">
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                        <img src="<?php  $loc=location($stok_cikis['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                             class="img-responsive p-1 m-b-2" style="max-height: 120px;">

                    </div>
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                        <h2>

                            <?php
                            if($type==2)
                            {
                                echo $this->lang->line('Stock Giris');
                            }
                            else
                            {
                                echo $this->lang->line('Stock Cikis');
                            }
                            ?>
                        </h2>
                        <p style="margin-bottom: 0;"> <?php echo $this->lang->line('fis_name') . ' : ' . $stok_cikis['fis_name'] . '</p>';?>


                            <?php echo '<p style="margin-bottom: 0;">'.$this->lang->line('Fis Number') .' : ' . $stok_cikis['id'] . '</p>'; ?>

                    </div>
                </div>
                <!--/ Invoice Company Details -->


                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table table-striped">
                                <thead>

                                <tr>
                                    <th>#</th>
                                    <?php if($stok_cikis['customer_type']==2){
                                        ?>
                                        <th class="">Bölüm</th>
                                        <th class="">Asama</th>
                                    <?php } ?>
                                    <th><?php echo $this->lang->line('Item Name') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('unit') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $c = 1;
                                $sub_t = 0;

                                foreach ($products as $row) {
                                    echo '<tr><td scope="row">' . $c . '</td>';
                                    if($stok_cikis['customer_type']==2)
                                    {
                                        echo '<td scope="row">' . bolum_getir($row->bolum_id) . '</td>
                                                                 <td>' . task_to_asama($row->asama_id) . '</td>';
                                    }
                                    echo '
                                                    <td>' . $row->product . '</td>
                                                     <td>' . $row->qty . '</td>
                                                    <td>' .units_($row->unit)["name"].'</td>

                                              </tr>';



                                    $c++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Invoice Footer -->


                <hr>
                <pre><?php echo $this->lang->line('Stok Access URL') ?>: <?php
                    echo $link ?></pre>


            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>invoices/file_handling?id=<?php echo $invoice['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>invoices/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>




<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 150,
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

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });


    });


</script>
