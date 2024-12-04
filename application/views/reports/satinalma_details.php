
<style>
    @media (min-width: 992px)
    {
        .modal-lg {
            max-width: 100% !important;
        }
    }

</style>
<div id="notifys" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="messages"></div>
</div
<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Firma</th>
                <th>Teklif Tarihi</th>
                <th>Firmanın Fiyatı</th>
                <th>EDV Durumu</th>
                <th>EDV'siz Fiyat </th>
                <th>EDV'li Fiyat </th>
                <th>Satınalma</th>
            </tr>
            <?php $i=0; foreach ($urunler as $datass) {


                ?>
                <tbody>
                <tr class="rowid">
                    <?php


                    $edv_tutari=(round($datass['price']*0.18,2));

                    $kdv_durumu='EDV Dahil';
                    $edvsiz_fiyat=$datass['price']-$edv_tutari;
                    $edvli_fiyat=$datass['price'];

                    ?>
                    <td><?php echo $datass['firma_adi']?></td>
                    <td><?php echo $datass['teklif_tarihi']?></td>
                    <td><?php echo amountFormat($datass['price'])?></td>
                    <td><?php echo $kdv_durumu?></td>
                    <td><?php echo amountFormat($edvsiz_fiyat)?></td>
                    <td><?php echo amountFormat($edvli_fiyat)?></td>
                    <td><?php echo $datass['ihale_id'] ?></td>

                </tr>


                </tr>
                </tbody>



            <?php } ?>
        </table>


        </table>


    </div>
</div>

<script>