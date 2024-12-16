<div class="card" style="visibility: hidden; display: none;" id="history_card">
<div class="card-body">
        <div class="col-12">
            <div class="container-fluid">
                    <header> <h4>Talep Hareketleri</h4></header>
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
<script>
    $(document).ready(function (){
        $('#mt_talep_history').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'ajax': {
                'url': "<?php echo site_url('malzemetalepform/ajax_list_history')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: <?=$talep_id?>
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
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

            ]
        });
    });
</script>