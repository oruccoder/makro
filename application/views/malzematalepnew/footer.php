<div class="card mobile_none" style="box-shadow: none;">
    <div class="card-body">
        <div class="row">
            <div class="col col-md-12 col-xs-12 mobile_text">
                <header><h4 class="mobile_text_header">Talep Hareketleri</h4></header>
                <table class="table" id="mt_talep_history" width="100%">
                    <thead>
                    <tr>
                        <th>Personel Adı</th>
                        <th>Açıklama</th>
                        <th>İşlem Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="content mobile_none">
    <div class="card" style="box-shadow: none;">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12">
                    <header> <h4 class="mobile_text_header">Sorğu ilə Əlaqəli Fayllar</h4></header>
                    <?php if($file_details){
                        foreach ($file_details as $file_items){
                            ?>
                            <ul class="list-inline">
                                <li id="systemfile_2" class="col-sm-12 margin-bottom-5">
                                    <div class="well welldocument">
                                        <label><b><?php echo $file_items->image_text?></b></label>
                                        <div class="">
                                            <div class="font-xs">Yüklenme Tarihi: <?php echo dateformat_new($file_items->created_at)?></div>
                                            <div class="font-xs">Yükleyen: <?php echo personel_details($file_items->user_id)?></div>
                                        </div>
                                        <div class="text-center">
                                            <div class="btn-group">
                                                <a class="btn btn-success mobile_button" download href="<?php echo base_url() . 'userfiles/product/'.$file_items->image_text ?>"  >
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <button class="btn btn-danger delete_file mobile_button" file_id="<?php echo $file_items->id?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                </li>

                            </ul>
                        <?php }
                    } ?>
                    <ul class="list-inline">
                        <li id="systemfile_2" class="margin-bottom-5">
                            <div class="well welldocument">
                                <button class="btn btn-success new_file mobile_button">Yeni Dosya Ekle</button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12">
                    <h2 class="text-bold-700 mobile_text_header">Talep İle İlgili Borçlandırmalar</h2>
                    <table class="table mobile_text  table-responsive">
                        <thead>
                        <tr>
                            <td>Oluşturan Personel</td>
                            <td>Tutar</td>
                            <td>Açıklama</td>
                            <td>Tip</td>
                            <td>İşlem Yapılan Şahıs</td>
                            <td>Tarih</td>
                            <td>Durum</td>
                            <td>İşlem</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(talep_borclandirma($details->id,1)){
                            foreach (talep_borclandirma($details->id,1) as $b_items){
                                ?>
                                <tr>
                                    <td><?php echo $b_items['personel'] ?></td>
                                    <td><?php echo $b_items['tutar'] ?></td>
                                    <td><?php echo $b_items['desc'] ?></td>
                                    <td><?php echo $b_items['tip'] ?></td>
                                    <td><?php echo $b_items['cari_pers'] ?></td>
                                    <td><?php echo $b_items['created_at'] ?></td>
                                    <td><?php echo $b_items['durum'] ?></td>
                                    <td><button class="btn btn-outline-danger borclandirma_sil" b_id="<?php echo $b_items['id']?>"><i class="fa fa-ban"></i></button></td>
                                </tr>
                                <?php
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-border{
        border: none;

    }
    .no-padding{
        padding: 0;
    }
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }
    @media (max-width: 991.98px) {
        .mobile_text{
            font-size: 9px;
        }
        .mobile_text_header{
            font-size: 12px;
        }
        .mobile_button{
            padding: 5px;
        }
        .mobile_none{
            display: none;
        }
    }
    .table-bordered{
        border-top: 1px solid #dddddd !important;
    }
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
        background-color: #45748a;
        border-radius:0px;
    }
    .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        flex-direction: row;
        align-content: stretch;
        justify-content: center;
    }
    .nav-pills{
        background: #e6e6e6;
        padding: 15px;

    }
    .nav-item button {
        background: none;
    }
    .dataTable thead .sorting_asc:after{
        display: none;
    }


</style>
<script src="<?php echo  base_url() ?>app-assets/talepform/createnew.js?v=<?php echo rand(11111,99999)?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script src="https://cdn.datatables.net/select/2.0.3/js/select.dataTables.js"></script>

<script>
    function draw_data() {
        $('#project_table').DataTable({
            scrollX:        "300px",
            scrollCollapse: true,
            fixedColumns:   {
                left: 3
            },
            "columnDefs": [
                { "width": "10px", "targets": 0 },
                { "width": "40px", "targets": 1 },
                { "width": "100px", "targets": 2 },
                { "width": "70px", "targets": 3 },
                { "width": "70px", "targets": 4 },
                { "width": "70px", "targets": 5 }
            ],
            paging:         false,
            'ordering': false,
            select: true,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Tümünü Yazdır',
                    footer: true,
                    exportOptions: {
                        columns: [2, 3, 4,5,6,7,8,9,10]
                    },
                },
                {
                    extend: 'print',
                    text: 'Seçili Olanları Yazdı',
                    exportOptions: {
                        columns: [2, 3, 4,5,8,9,10]
                    },
                }

            ]

        });
    }
</script>