<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $title ?></span></h4>
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
                                        <table id="stoklar" class="table datatable-show-all" width="100%">
                                            <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Proje</td>
                                                <td>Proje Bölümü</td>
                                                <td>Proje Aşaması</td>
                                                <td>Mahsul</td>
                                                <td>İşlemler</td>
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
        $('.select-box').select2();
        draw_data();
        function draw_data() {
            $('#stoklar').DataTable({
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
                    'url': "<?php echo site_url('onay/proje_stoklari_bekleyen_ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    }
                },
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[9]);

                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    }
                ]
            });
        };
    })

    $(document).on('mouseover','.proje_name_string',function(){
        let name = $(this).data('content');
        $.alert({
            theme: 'material',
            icon: 'fa fa-home',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Proje Adı',
            content:name,
            buttons:{
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark close_proje",
                }
            }
        });
        setTimeout(function() {
            $('.close_proje').click()
        }, 3000);

    })
</script>