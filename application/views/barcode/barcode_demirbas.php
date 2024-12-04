
<div class="row">
    <div class="col-md-12">
        <?php
        $i=0;
        foreach ($details as $items) {
            $dep='';
            $pers='';
            if(who_departmant($items->departman_id)){
            $dep=' <br> '.who_departmant($items->departman_id);
            }


            ?>
            <div class="col-md-4"><span style="text-transform: uppercase"><?=$items->name.' <br> '.$items->code.' <br> '.personel_details($items->personel_id).$dep; ?></span><br></div>
            <barcode code="<?= $items->barcode ?>" text="1" class="barcode" height=".6"/></barcode>
            <br><br>
        <?php  } ?>

    </div>
</div>

