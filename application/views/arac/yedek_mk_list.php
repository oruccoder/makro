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
                <h2 style="text-align: center">Makro2000 Araçların Listesi</h2></br></br></br>
                <div class="row">
                    <?php
                    if($items){
                        foreach ($items as $values) {
                            $images = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $values->image_text . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $values->image_text . '" ></span>';
                            ?>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="media align-items-stretch" style="height: 180px;">
                                            <div class="p-2 text-center bg-dark bg-darken-2">
                                                <?php echo $images?>
                                                <br>
                                                <br>
                                                <?php if(personel_details($values->active_surucu_id)!='Firma'){ echo  "<b>".personel_details($values->active_surucu_id)."</b>"; } else { echo arac_surucu_kontrol($values->id ); }?>
                                                <?php if(arac_talep_kontrol($values->id)){
                                                    $talep_details = arac_talep_kontrol($values->id);

                                                    $date=explode('-',$talep_details->end_date);
                                                    $date_=explode('-',$talep_details->end_date);
                                                    $time=explode(' ',$date_[2]);
                                                    $times=explode(':',$time[1]);

                                                    $ay = explode(' ',$date[2]);



                                                    $monthName = date("M", strtotime(mktime(0, 0, 0, intval($date[1]), 1, 1900)));



                                                    //Jan 5, 2024 15:37:25
                                                    $text_=$monthName.' '.intval($ay[0]).', '.intval($date[0]).' '.$times[0].':'.$times[1].':'.$times[2];
                                                    ?>
                                                    <p class="demo"></p>
                                                    <input type="hidden" class="times" value="<?php echo $text_ ?>">
                                                    <?php
                                                }?>
                                            </div>
                                            <div class="p-1 bg-gradient-y2-dark white media-body">
                                                <a target="_blank" href="/driver/arac_details/<?php echo $values->id ?>"<h3 style="color: white;font-size: xx-large;line-height: 55px;font-weight: bold"><?php echo  $values->plaka ?></h3> </a> <h3 style="color: white;line-height: 35px;font-weight: bold"><?php echo  $values->name ?></br><p><?php echo  $values->marka.'-'.$values->model ?><br/><?php echo durum_sorgula($values->id);?></p></h3>

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

        .bg-dark {
            background-color: #FFF !important;
            border: 1px solid #1b2942;
            border-radius: 4px 0px 4px 0px;
        }
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


        $(document).ready(function (){
            var x = setInterval(function() {

                let count = $('.times').length;
                for (let i = 0; i < count;i++){
                    var countDownDate = new Date($(".times").eq(i).val()).getTime();

                    // Update the count down every 1 second


                    // Get today's date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate-now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result in the element with id="demo"

                    $('.demo').eq(i).empty().html( days + " Gün " + hours + " Saat "
                        + minutes + " Dakika</br>" + seconds + " Saniye Süresi Kalmıştır");

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        clearInterval(x);
                        $('.demo').eq(i).empty().html('Süresi Dolmuştur')

                    }

                }


            }, 1000);
        })


    </script>
