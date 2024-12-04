
<style>
    @media (min-width: 992px)
    {
        .modal-lg {
            max-width: 70% !important;
        }
    }

</style>
<div id="notifys" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="messages"></div>
</div
<div class="card">
    <h4 style="text-align: center;"><?php echo $product_name; ?></h4>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Ürün</th>
                <th>Marka</th>
                <th>Miktar</th>
            </tr>
            <?php $i=0; foreach ($data as $datas) {
                $p=$datas['product_name'];


                    ?>
                    <tr>
                        <td><?php echo $datas['product_name']?></td>
                        <td><?php echo $datas['marka']?></td>
                        <td><?php echo $datas['qty'].' '.$datas['unit'] ?></td>
                  </tr>



            <?php } ?>
        </table>


    </div>
</div>

<script>

</script>