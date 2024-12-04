    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                </div>
                <div class="col-md-12">
                </div>
            </div>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="grid_3 grid_4 animated fadeInRight">
                    <div class="table-responsive">
                        <div class="row" style="padding-left: 13px;">
                            <div class="col-12">
                                <table id="product_table" class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <th>name</th>
                                            <th>category id</th>
                                            <th>code</th>
                                            <th>barcode</th>
                                            <th>type</th>
                                            <th>unit_id</th>
                                            <th>parent_id</th>
                                            <th>image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <style>
        .group-buttons {
            outline: none !important;
            border-radius: 0px !important;
            border: 1px solid gray;
        }
    </style>
    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

    <script>
        $(document).ready(function() {

            $('.select2').select2();
            draw_data();

        });



        function draw_data() {
            $('#product_table').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                "autoWidth": false,
                'order': [],
                'ajax': {
                    'url': "<?php echo base_url() . 'mahsul/ajax_list' ?>",
                    'type': 'POST',
                    'data': {}
                },
                'columnDefs': [{
                    'targets': [0],
                    'orderable': false,
                }, ],
                dom: 'Blfrtip',
                buttons: [

                    {
                        text: '<i class="fa fa-plus"></i> Yeni Mehsul Elave et',
                        action: function(e, dt, node, config) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: false,
                                title: 'Məhsul Transfer Fişi',
                                icon: 'fa fa-plus-square 3x',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-12 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content: `
                                <div class='mb-3'>
                                    <div class="form-row">

                                         <div class="form-group col-md-6">
                                            <label>Mehsul Adi</label>
                                            <input type="text" class='form-control product_name'>
                                         </div>

                                        <div class="form-group col-md-6">
                                            <label>Kategori</label>
                                            <select class="form-control select-box cat_id">
                                                <option value='0'>Secin</option>
                                                    <?php
                                                    foreach (all_categories() as $item) {
                                                        echo "<option value='$item->id'>$item->title</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>Mehsul Aciqlamasi</label>
                                            <input type="text" class='form-control product_description'>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Mehsul Tipi</label>
                                            <select class="form-control select-box pro_type">
                                                <option value='0'>Secin</option>
                                                    <?php
                                                    foreach (all_product_type() as $item) {
                                                        echo "<option value='$item->id'>$item->name</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>

                                    </div> 


                                    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Dosya</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="files[]">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>

                                    
                                </div>
                                `,
                                buttons: {
                                    formSubmit: {
                                        text: 'Gondər',
                                        btnClass: 'btn-blue',
                                        action: function() {
                                            let collection = [];

                                            let data = {
                                                product_name: $('.product_name').val(),
                                                cat_id: $('.cat_id').val(),
                                                product_description: $('.product_description').val(),
                                                pro_type: $('.pro_type').val(),
                                                // product_image: $('.product_image').val(),
                                            }

                                            collection.push(data)

                                            let data_post = {
                                                collection: collection,
                                                crsf_token: crsf_hash,
                                            }

                                            $.post(baseurl + 'mahsul/create', data_post, (response) => {
                                                let data = jQuery.parseJSON(response);
                                                if (data.status == 200) {
                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-check',
                                                        type: 'green',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Başarılı',
                                                        content: data.message,
                                                        buttons: {
                                                            prev: {
                                                                text: 'Tamam',
                                                                btnClass: "btn btn-link text-dark",
                                                                action: function() {
                                                                    table_product_id_ar = [];
                                                                    $('#stockio').DataTable().destroy();
                                                                    draw_data();
                                                                }
                                                            }
                                                        }
                                                    });

                                                } else if (data.status == 410) {
                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: responses.message,
                                                        buttons: {
                                                            prev: {
                                                                text: 'Tamam',
                                                                btnClass: "btn btn-link text-dark",
                                                            }
                                                        }
                                                    });
                                                }
                                            })
                                        }
                                    },
                                    cancel: {
                                        text: 'İmtina et',
                                        btnClass: "btn btn-danger btn-sm",
                                        action: function() {
                                            table_product_id_ar = [];
                                        }
                                    }
                                },
                                onContentReady: function() {

                                    $('#fileupload_').fileupload({
                                            url: baseurl+'upload/file_upload',
                                            dataType: 'json',
                                            formData: {
                                                '<?= $this->security->get_csrf_token_name() ?>': crsf_hash , 'path':'userfiles/company'
                                            },
                                            done: function(e, data) {
                                                var img = 'default.png';
                                                $.each(data.result.files, function(index, file) {
                                                    img = file.name;
                                                });

                                                $('#image_text').val(img);
                                            },
                                            progressall: function(e, data) {
                                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                                $('#progress .progress-bar').css(
                                                    'width',
                                                    progress + '%'
                                                );
                                            }
                                        }).prop('disabled', !$.support.fileInput)
                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                    // bind to events

                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function(e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });
                        }
                    }
                ]
            });
        }
    </script>