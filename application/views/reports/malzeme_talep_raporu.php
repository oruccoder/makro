<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Malzeme Talepleri</span></h4>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <div class="message"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="select-box form-control filters" id="proje_id" name="proje_id" >
                                    <option value="0">Proje Seçiniz</option>
                                    <?php foreach (all_projects() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="select-box form-control filters" id="cari_id" name="cari_id" >
                                    <option value="0">Cari</option>
                                    <?php foreach (all_customer() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->company?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="select-box form-control filters" id="status_id" name="status_id" >
                                    <option value="0">Talep Durumu</option>
                                    <?php foreach (talep_form_status_list() as $rows)
                                    {
                                        ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Talep Kodu</th>
                            <th>Açıklama</th>
                            <th>Proje</th>
                            <th>Ürün</th>
                            <th>Miktar</th>
                            <th>Birim</th>
                            <th>Tutar</th>
                            <th>Cari</th>
                            <th>Durum</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-dialog {
        max-width: 50% !important;
    }
    .col-sm-6{
        padding-bottom: 10px !important;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>

    $(document).ready(function () {

        $('.select-box').select2();
        draw_data();
    })


    $('.filters').on('change',function (){
        let proje_id = $('#proje_id').val();
        let cari_id = $('#cari_id').val();
        let status_id = $('#status_id').val();
        $('#invoices').DataTable().destroy();
        draw_data(proje_id,cari_id,status_id);

    })


    function draw_data(proje = 0,cari_id=0,status_id=0) {
        var datatable = $('#invoices').DataTable({
            autoWidth: false,
            pagingType: "full_numbers",
            processing: true,
            aLengthMenu: [
                [10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            serverSide: true,
            'ajax': {
                'url': "<?php echo site_url('reports/ajax_malzeme_raporu')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje:proje,
                    cari_id:cari_id,
                    status_id:status_id,

                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 3, 4, 5,6,7,8]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 3, 4,5,6,7,8]
                    }
                }
            ]
        });
    }

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }
    function htmlDecode(data) {
        let txt = document.createElement('textarea');
        txt.innerHTML = data;
        return txt.value;
    }

</script>

