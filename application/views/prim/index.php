<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Prim ve Ceza Listesi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table class="table datatable-show-all" id="personel_table" width="100%">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Personel Adı</td>
                                                <td>Açıklama</td>
                                                <td>Oluşturma Tarihi</td>
                                                <td>Hesaplama Ayı</td>
                                                <td>Tip</td>
                                                <td>Tutar</td>
                                                <td>İşlem</td>
                                            </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        draw_data();
    })

    function draw_data() {
        $('#personel_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('prim/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                }
            },
            'columnDefs': [
                {
                    'targets': [4],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 2, 3]
                    }
                }
            ]
        });
    };
    $(document).on('click','.view',function (){
        let prim_id = $(this).attr('prim_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Detaylar',
            icon: 'fa fa-eye',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html=`<form>
                             <div class="row">
                               <div class="card col-md-12">
<p id="desc_prim"></p>
									  <ul class="list-group list-group-flush" style="text-align: justify;">
									  </ul>
									</div>
                            </div>
                                </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    prim_id: prim_id,
                }


                let li='';
                $.post(baseurl + 'prim/get_info_prim_confirm',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $.each(responses.item, function (index, items) {
                            let durum='';
                            if(items.staff_status==1){
                                durum='Onaylandı';
                            }
                            else if(items.staff_status==2){
                                durum='İptal Edildi';
                                desc=`<li>`+items.staff_desc+`</li>`;
                            }
                            li+=`<li class="list-group-item"><b>Personel Adı : </b>&nbsp;`+items.name+`</li><ul><li>`+durum+`</li>`+items.description+`</ul>`;
                        });

                        $('.list-group-flush').empty().append(li);
                    }
                    else {
                        $('.list-group-flush').empty().append('<p>Bildirim Başlatılmamış</p>');
                    }


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
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
    })
</script>