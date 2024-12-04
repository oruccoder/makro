<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Stoklar</span></h4>
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
                            <div class="col-lg-4">
                                <select class="select-box form-control" id="category_id" name="category_id" >
                                    <option value="0">Kategori Seçiniz</option>
                                    <?php
                                    foreach (category_list_() as $item) :

                                        $id = $item['id'];
                                        $title = $item['title'];
                                        $new_title = _ust_kategori_kontrol($id).$title;
                                        echo "<option value='$id'>$new_title</option>";

                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="select-box form-control" id="warehouse_id" name="warehouse_id" >
                                    <option value="0">Depo Seçiniz</option>
                                    <?php
                                    foreach (all_warehouse() as $item) :

                                        $id = $item->id;
                                        $title = $item->title;
                                        echo "<option value='$id'>$title</option>";

                                    endforeach;
                                    ?>
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
                            <th>Kategori</th>
                            <th>Sistem Stok Kodu</th>
                            <th>Stok Kodu</th>
                            <th>Stok Adı</th>
                            <th>Stok Tipi</th>
                            <th>Depo</th>
                            <th>Toplam Miktar</th>
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


    $('#category_id').on('change',function (){
        let category_id = $(this).val();
        let warehouse_id = $('#warehouse_id').val();
        $('#invoices').DataTable().destroy();
        draw_data(category_id,warehouse_id);

    })

    $('#warehouse_id').on('change',function (){
        let warehouse_id = $(this).val();
        let category_id = $('#category_id').val();
        $('#invoices').DataTable().destroy();
        draw_data(category_id,warehouse_id);

    })


    function draw_data(category_id = 0,warehouse_id=0) {
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
                'url': "<?php echo site_url('reports/ajax_list_stok_raporu')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    category_id:category_id,
                    warehouse_id:warehouse_id,

                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 2, 3, 4,5,6,7,8]
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

