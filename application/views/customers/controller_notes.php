<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
               Cari Kontroller Notları
            </h5>

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
                <table id="emptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Cari</th>
                        <th>Tarih</th>
                        <th>Açıklama</th>
                        <th>Kullanıcı</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                    foreach ($data as $row) {
                        echo "<tr>
                    <td>$i</td>
                    <td>$row->company</td>
                    <td>$row->date</td>
                    <td>$row->notes</td>
                    <td>$row->pers_name</td>
                    </tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#emptable').DataTable({
            responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                }
            ],
        });


    });
</script>
