<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Tehvil Alan Personel</th>
                <th>Tehvil Tarihi</th>
                <th>Miktar</th>

            </tr>
            <?php foreach ($data as $datas) { ?>
                <tr>
                    <td><?php echo personel_details($datas['user_id'])?></td>
                    <td><?php echo dateformat_time($datas['teslim_tarihi'])?></td>
                    <td><?php echo round($datas['teslim_alinan_miktar'],2)?></td>
                </tr>

            <?php } ?>
        </table>

    </div>
</div>