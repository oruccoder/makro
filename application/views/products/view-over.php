

<div id="notify1" class="alert alert-success" style="display:none;">

    <div class="message"></div>


</div>
<table class="table">
    <?php echo'<tr>
    <td>'.$product['product_name'].'</td>
    <td>Ürün Kodu : '.$product['product_code'].'</td>
    <td> Toplam Miktar : '.toplam_rulo_adet($product['pid'])['toplam_adet'].' '.units_($product['unit'])['name'].'</td>
     <td> Toplam Rezerve Miktar : '.toplam_rulo_adet($product['pid'])['rezerve_qty'].' '.units_($product['unit'])['name'].'</td>
    <td> Toplam '.paketleme_tipi($product['pid']).' : '.toplam_rulo_adet($product['pid'])['toplam_rulo'].' Ad</td>
    <td> Depo : Tümü</td>
    </tr>'; ?>
</table>

<?php if($product_variations) {

    echo  '<h6>'.$this->lang->line('alt_urunler').'</h6>';
    ?>

<table class="table table-striped table-bordered">
    <?php
    foreach ($product_variations as $product_variation) {
    echo'<tr>
            <td><a href="' . base_url() . 'products/edit?id=' . $product_variation['pid']. '" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> ' .$product_variation['product_name'].'</td>
            <td>Ürün Kodu : '.$product_variation['product_code'].'</td>
            <td> Toplam Miktar : '.toplam_rulo_adet($product_variation['pid'])['toplam_adet'].' '.units_($product_variation['unit'])['name'].' Toplam '.paketleme_tipi($product_variation['pid']).' : '.toplam_rulo_adet($product_variation['pid'])['toplam_rulo'].'</td>
            <td> Toplam Rezerve Miktar : '.toplam_rulo_adet($product_variation['pid'])['rezerve_qty'].' '.units_($product_variation['unit'])['name'].'</td>
            <td>Depo Adı: Tüm Depolar</td>
            <td><a href="' . base_url() . 'products/poslabel?id=' . $product_variation['pid'] . '" class="btn btn-primary btn-xs"><span class="fa fa-barcode"></span></a> </td>
            <td><input class="form-control miktar" placeholder="Miktar" name="miktar[]"></td>
            <td><button id="button-cart" product_id="' . $product_variation['pid']. '" class="btn btn-primary btn-xs"><span class="fa fa-shopping-cart"></span></button> </td>
            
             
            </tr>'; } ?>
</table>
<?php }
?>

<?php if(isset($product_warehouse)) {


     echo  '<h6> '.$this->lang->line('Warehouses'). '</h6>';
    ?>
<table class="table table-striped table-bordered">
    <?php
    foreach ($product_warehouse as $prd_w)
    {
    foreach ($prd_w as $product_variation) {
        ?><?php
        echo'<tr>
            <td><a href="' . base_url() . 'products/edit?id=' . $product_variation['pid']. '" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span> ' . $this->lang->line('Edit') . '</a> ' .$product_variation['product_name'].'</td>
            <td>Ürün Kodu : '.$product_variation['product_code'].'</td>
            <td> Toplam Miktar : '.toplam_rulo_adet_depo($product_variation['pid'],$product_variation['depo_id'])['toplam_adet'].' '.units_($product_variation['unit'])['name'].' Toplam '.paketleme_tipi($product_variation['pid']).' : '.toplam_rulo_adet_depo($product_variation['pid'],$product_variation['depo_id'])['toplam_rulo'].'</td>
            <td> Toplam Rezerve Miktar : '.toplam_rulo_adet($product_variation['pid'])['rezerve_qty'].' '.units_($product_variation['unit'])['name'].'</td>
            <td>Depo Adı: '.$product_variation['title'].'</td>
            <td><a href="' . base_url() . 'products/poslabel?id=' . $product_variation['pid'] . '" class="btn btn-primary btn-xs"><span class="fa fa-barcode"></span></a> </td>
            <td><input class="form-control miktar" placeholder="Miktar" name="miktar[]"></td>
            <td><button id="button-cart" product_id="' . $product_variation['pid']. '" class="btn btn-primary btn-xs"><span class="fa fa-shopping-cart"></span> </button> </td>
            
             
            </tr>';
    }

    }
    ?>
    </table>
<?php } ?>
    <hr>
