<div class="row">
    <div class="container mt-2 mb-2" style="max-width: 1900px">
        <div class="timeline-container">
            <div class="timeline">
                <input type="hidden" id="talep_status_id" value="<?=$details->status?>">
                <?php
                // Talep durumu ve previous parametresi kontrolü
                $talep_status = $details->status;

                // Mevcut URL'den 'previous' parametresini al
                $previous = $this->input->get('previous');

                foreach (malzemetalepstatus() as $key => $surec):
                    // Durum sınıflarını belirle
                    if ($previous && $surec->id == $previous) {
                        $statusClass = 'highlight'; // Previous durumu için özel sınıf
                    } elseif ($surec->id < $talep_status) {
                        $statusClass = 'completed'; // Önceki durumlar
                    } elseif ($surec->id == $talep_status) {
                        $statusClass = 'active'; // Mevcut durum
                    } else {
                        $statusClass = 'disabled'; // Gelecek durumlar
                    }
                    ?>
                    <div
                            class="timeline-step <?php echo $statusClass; ?>"
                            onclick="<?php echo "viewProcess($surec->id, '$surec->name','$surec->url')"; ?>">
                        <?php echo $surec->name; ?>
                    </div>
                <?php endforeach; ?>


            </div>
        </div>
    </div>
</div>

<script>
    function viewProcess(step, name, url) {
        // Mevcut durumu al (status)
        const status = $('#talep_status_id').val(); // Mevcut durum (hidden input veya select'ten alındığını varsayıyoruz)

        // Mevcut sayfanın URL'sini al
        const currentUrl = window.location.href;

        // URL'yi temizle (varsa önceki parametreyi kaldır)
        const baseUrlPage = currentUrl.split('?')[0]; // Sadece temel URL

        // Status ile Step eşit ise URL'den previous ekleme
        if (step == status) {
            // Sadece temel URL'ye yönlendir
            window.location.href = baseUrlPage;
        } else {
            // Yeni URL'yi oluştur
            const newUrl = `${baseUrlPage}?${url}`;

            // Yeni URL'ye yönlendir
            window.location.href = newUrl;
        }
    }

</script>
