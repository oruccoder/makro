<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></h4>
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


                <div class="row">
                    <div class="col-md-2 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" id="dpic" class="rounded-circle img-border height-150"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>


                        <?php $this->load->view('customers/customer_menu'); ?>


                    </div>
                    <div class="col-md-10">

                        <h4 class="title">
                            <?php echo $this->lang->line('Documents') ?> <a
                                    href="<?php echo base_url('customers/adddocument?id=' . $id) ?>"
                                    class="btn btn-primary btn-sm rounded">
                               <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i>
                            </a>
                            <button type="button" class="btn btn-info add_document"><i class="fa fa-plus"></i>&nbsp;
Yeni Belge Ekle
                            </button>

                        </h4>
                        <div class="row">

                            <div class="col-md-2">Sözleşme Tarihi</div>
                            <div class="col-md-2">
                                <input type="text" name="start_date" id="start_date"
                                       class="date30 form-control form-control-sm" autocomplete="off"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                       data-toggle="datepicker" autocomplete="off"/>
                            </div>

                            <div class="col-md-2">
                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                            </div>
                            <div class="col-md-2">
                                <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>
                            </div>

                        </div>
                        <hr>
                        <hr>


                        <table id="doctable" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line('Title') ?></th>
                                <th>Başlangıç Tarihi</th>
                                <th>Bitiş Tarihi</th>
                                <th><?php echo $this->lang->line('Action') ?></th>


                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>


                    </div>
                </div>


            </div>
        </div>
    </div>


    <div id="sendMail" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Email</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="sendmail_form"><input type="hidden"
                                                    name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                    value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="row">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-envelope-o"
                                                                         aria-hidden="true"></span></div>
                                    <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                           value="<?php echo $details['email'] ?>">
                                </div>

                            </div>

                        </div>


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                                <input type="text" class="form-control"
                                       name="customername" value="<?php echo $details['name'] ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                                <input type="text" class="form-control"
                                       name="subject" id="subject">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                                <textarea name="text" class="summernote" id="contents" title="Contents"></textarea>
                            </div>
                        </div>

                        <input type="hidden" class="form-control"
                               id="cid" name="tid" value="<?php echo $details['id'] ?>">
                        <input type="hidden" id="action-url" value="communication/send_general">


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <button type="button" class="btn btn-primary"
                            id="sendNow"><?php echo $this->lang->line('Send') ?></button>
                </div>
            </div>
        </div>
    </div>


    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this document') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="customers/delete_document">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function draw_data(start_date='',end_date='')
        {
            $('#doctable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                <?php datatable_lang();?>
                "ajax": {
                    "url": "<?php echo site_url('customers/document_load_list')?>",
                    "type": "POST",
                    'data': {
                        start_date: start_date,
                        end_date: end_date,
                        'cid':<?=$id ?>,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        text: '<i class="fa fa-truck"></i> Yeni Belge Ekle',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni Araç Ekle',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-6 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Belge Adı</label>
      <input type="text" class="form-control" id="name" placeholder="Açık Pickup">
    </div>
     <div class="form-group col-md-6">
      <label for="firma_id">Belge Tipi Adı</label>
     <select class="form-control select-box" id="file_type_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (customer_file_type() as $emp){
                                $emp_id=$emp->id;
                                $name=$emp->company;
                                ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>

    </div>
</div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="baslangic_date">Marka</label>
      <input type="date" class="form-control" id="baslangic_date">
    </div>
  <div class="form-group col-md-6">
      <label for="bitis_date">Yıl</label>
      <input type="date" class="form-control" id="bitis_date" ">
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
</form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            $('#loading-box').removeClass('d-none');

                                            let data = {
                                                crsf_token: crsf_hash,
                                                bitis_date:  $('#bitis_date').val(),
                                                baslangic_date:  $('#baslangic_date').val(),
                                                file_type_id:  $('#file_type_id').val(),
                                                name:  $('#name').val(),
                                                cari_id:  "<?php echo $id;?>",
                                                image_text:  $('#image_text').val(),
                                            }
                                            $.post(baseurl + 'customers/add_document',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status=='Success'){
                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-check',
                                                        type: 'green',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "small",
                                                        title: 'Başarılı',
                                                        content: responses.message,
                                                        buttons:{
                                                            formSubmit: {
                                                                text: 'Tamam',
                                                                btnClass: 'btn-blue',
                                                                action: function () {
                                                                    $('#invoices').DataTable().destroy();
                                                                    draw_data();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status=='Error'){

                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: responses.message,
                                                        buttons:{
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
                                },
                                onContentReady: function () {
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })

                                    $('#fileupload_').fileupload({
                                        url: url,
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image_text').val(img);
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
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
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
        $(document).ready(function () {

            draw_data();





        });

        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#doctable').DataTable().destroy();
                draw_data(start_date, end_date);
            } else {
                alert("Date range is Required");
            }
        });


    </script>

    <script type="text/javascript">
        $(function () {
            $('.summernote').summernote({
                height: 100,
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
