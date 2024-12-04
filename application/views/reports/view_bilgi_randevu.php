<div class="card">
    <div class="card-body">
        <form id="data_form">
            <input type="hidden" name="id" value="<?php echo $data['id']?>">
            <input type="hidden" name="action-url" id="action-url" value="invoices/randevu_bilgi_update">
            <h6 class="card-subtitle mb-2 text-muted"><b>Randevu Adresi : </b><?php echo adres_ogren($data['adres_id'])->name?></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Kurum / Firma : </b><?php echo $data['kurum_firma']?></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Yetkili Kişi : </b><?php echo $data['yetkkili_kisi']?></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Telefon :</b> <?php echo $data['telefon']?></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Görüşme Sebebi : </b><?php echo $data['description']?></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Randevu Başlangıç : </b><input type="datetime-local" name="baslangic" value="<?php echo date_ajanda($data['etkinlik_saati']).'T'.$data['etkinlik_saati_rel']?>"></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Randevu Bitiş : </b><input style="width: 32%;" type="datetime-local" name="bitis" value="<?php echo date_ajanda($data['etkinlik_saati_bitis']).'T'.$data['etkinlik_saati_bitis_rel']?>"></h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Görüşme Yapacak Personel : </b>
                <select class="form-control select-box" name="personel_l" id="personel_l" style="width: 47%;">

                    <?php foreach (personel_list() as $emp){
                        $emp_id=$emp['id'];
                        $name=$emp['name'];
                        if($data['pers_id']==$emp_id)
                        {
                            echo "<option selected value='$emp_id'>$name</option>";
                        }
                        else
                            {
                                echo "<option value='$emp_id'>$name</option>";
                            }
                        ?>

                    <?php } ?>
                </select>
            </h6>

            <h6 class="card-subtitle mb-2 text-muted"><b>Durum : </b>
                <select class="form-control" name="durum" style="width: 47%;">

                    <option <?php if($data['status']==0) { echo 'selected'; } else { echo ''; } ?> value="0">Bekliyor</option>
                    <option <?php if($data['status']==2) { echo 'selected'; } else { echo ''; } ?> value="2">Onaylandı</option>
                    <option <?php if($data['status']==1) { echo 'selected'; } else { echo ''; } ?> value="1">Görüşme Tamamlandı</option>
                    <option <?php if($data['status']==4) { echo 'selected'; } else { echo ''; } ?> value="4">İptal Et</option>
                </select>
            </h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Görüşmeye Personel Davet Et </b>
                <select class="form-control select-box" name="personel_yen[]" id="personel_yen" multiple style="width: 47%;">

                    <?php foreach (personel_list() as $emp){
                        $emp_id=$emp['id'];
                        $name=$emp['name'];
                        echo "<option value='$emp_id'>$name</option>";
                        ?>
                    <?php } ?>
                </select>

        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('.select-box').select2();
    });
</script>
