<!---->
<!--<div class="content">-->
<!--    <div class="content-wrapper">-->
<!--        <div class="content">-->
<!--            <div class="card">-->
<!--                -->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<table id="invoices" class="table datatable-show-all"
       cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Tələn Nomresi</th>
        <th>Təcili</th>
        <th>İstək Tarixi</th>
        <th>Tələb Eden</th>
        <th>Layihə</th>
        <th>Vəziyyət</th>
        <th>Transfer Durum</th>
        <th>Onay Kimde</th>
        <th>Gecikme Tarihi</th>
        <th>İşlemler</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    $('#search').click(function () {
        var tansfer_status = $('#tansfer_status').val();
        var status = $('#status').val();
        $('#invoices').DataTable().destroy();
        draw_data(status,tansfer_status);

    });

    var url = '<?php echo base_url() ?>arac/file_handling';

    $(document).ready(function () {
        draw_data()
    });
    function draw_data(status_id=0,transfer_status=-1) {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('malzemetalep/ajax_list_all_list')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'status_id':status_id,'transfer_status':transfer_status}
            },
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style',data[10]);

            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
        });
    }






    $(document).on('click','.status_filer_button',function (){
        let status_id = $(this).attr('status_id');
        $('#invoices').DataTable().destroy();
        draw_data(status_id);
    })




</script>

<link href="<?php echo  base_url() ?>app-assets/talep.css?v=<?php echo rand(11111,99999) ?>" rel="stylesheet" type="text/css">
