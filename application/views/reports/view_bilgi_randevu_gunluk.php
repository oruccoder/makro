<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Randevu Adresi</th>
                <th>Kurum</th>
                <th>Yetkili Kişi</th>
                <th>Görüşme Sebebi</th>
                <th>Başlangıç Tarihi</th>
                <th>Bitiş Tarihi</th>
                <th>Durum</th>
                <th>Dahil Edilen Pers.</th>
                <th>Eylem</th>
            </tr>
            <?php foreach ($data as $datas) { ?>
            <tr>
                <?php
                $id=$datas['id'];
                $btn='';
                $s='';
                if($datas['status']==0)
                {
                    $s='Beklliyor';

                    $btn ="<a class='btn btn-info' href='/events/editrandevu?id=$id'>Güncelle</a>";
                }
               else if($datas['status']==1)
                {
                    $s='Görüşme Tamamlandı';
                    $btn ="<button class='btn btn-info'  disabled >Güncelleme Yapılamaz</button>";
                }
               else if($datas['status']==2)
               {
                   $s='Onaylandı';
                   $btn ="<a class='btn btn-info' href='/events/editrandevu?id=$id'>Güncelle</a>";
               }
               else
               {
                   $s='Onaylandı';
                   $btn ="<button class='btn btn-info'  disabled >Güncelleme Yapılamaz</button>";
               }
               ?>
                <td><?php echo adres_ogren($datas['adres_id'])->name ?></td>
                <td><?php echo $datas['kurum_firma']?></td>
                <td><?php echo $datas['yetkkili_kisi']?></td>
                <td><?php echo $datas['description']?></td>
                <td><?php echo dateformat_time($datas['etkinlik_saati'])?></td>
                <td><?php echo dateformat_time($datas['etkinlik_saati_bitis'])?></td>
                <td><?php echo $s; ?></td>
                <td><?php echo randevu_personelleri($datas['id'])?></td>
                <td><?php echo $btn?></td>
            </tr>

            <?php } ?>
        </table>

    </div>
</div>
