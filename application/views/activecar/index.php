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
                <h2 style="text-align: center">Aktif Araçların Listesi</h2></br></br></br>
                <div class="row">
                    <?php
                     if($items){
                     foreach ($items as $values) {
                         $status_name='Durum Bildirilmemiş';
                         if($values->status_name){
                             $status_name = $values->status_name;
                         }
                         ?>
                        <div class="col-xl-2 col-lg-2 col-4">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch" style="height: 180px;">
                                        <div class="p-2 text-center bg-dark bg-darken-2">
                                            <i class="fa fa-truck text-bold-200  font-large-2 white"></i>
                                        </div>
                                        <div class="p-1 bg-gradient-y2-dark white media-body">
                                            <a class="arac_hareketleri" arac_id="<?php echo $values->arac_id ?>"  lojistik_car_id="<?php echo $values->lojistik_car_id ?>"  lojistik_id="<?php echo $values->lojistik_id ?>"> <h3 style="color: white;line-height: 55px;font-weight: bold"><?php echo  $values->plaka ?></h3> </a> <h3 style="color: white;line-height: 55px;font-weight: bold"><?php echo  $values->name ?></br></h3><p><?php echo  $status_name ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                     }
                 ?>
                </div>


            </div>
        </div>
    </div>

    <style>
        .bg-gradient-y2-dark {
            background-image: -webkit-gradient(linear, left top, left bottom, from(#1b2942), color-stop(50%, #1b2942), to(#1b2942));
            background-image: -webkit-linear-gradient(#1b2942, #1b2942 50%, #1b2942);
            background-image: -moz-linear-gradient(#1b2942, #1b2942 50%, #1b2942);
            background-image: -o-linear-gradient(#1b2942, #1b2942 50%, #1b2942);
            background-image: linear-gradient(#14294e, #324b78 50%, #37507c)
            background-repeat: no-repeat; }
    </style>

    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">


        $(document).on('click','.arac_hareketleri',function (e){

            let lojistik_car_id = $(this).attr('lojistik_car_id');
            let lojistik_id = $(this).attr('lojistik_id');
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Araç Hareketleri',
                icon: 'fa fa-exclamation',
                type: 'light',
                animation: 'zoom',
                columnClass: 'col-md-8 col-md-offset-3',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group table_history">'+
                        '</div>' +
                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    let table_report='';
                    $.post(baseurl + 'employee/projeler',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        table_report =`<div style="padding-bottom: 10px;"></div>
                        <table id="invoices_report"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>İşlem Tarihi</th>
                            <th>Açıklama</th>
                            <th>Lokasyon</th>
                            <th>İşlem Yapan Personel</th>
                            <th>Durum</th>

                        </tr>
                        </thead>


                    </table>`;
                        $('.table_history').empty().html(table_report);
                        draw_data_report(lojistik_car_id);
                    });



                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    cancel:{
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
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
        function draw_data_report(lojistik_car_id=0) {
            $('#invoices_report').DataTable({
                'serverSide': true,
                'processing': true,
                "scrollX": true,
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('style',data[25]);
                },
                aLengthMenu: [
                    [ -1,10, 50, 100, 200],
                    ["Tümü",10, 50, 100, 200]
                ],
                'ajax': {
                    'url': "<?php echo site_url('lojistikcar/ajax_list_history_info')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        lojistik_car_id: lojistik_car_id,
                    }
                },
                'columnDefs': [
                    {
                        'targets': [1],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,

                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7,8,9,10]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7,8,9,10]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7,8,9,10]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4,5,6,7,8,9,10]
                        }
                    },
                ]
            });
        };
    </script>
