<form id="attendanceForm">
    <input type="hidden" name="date" id="date" value="<?= $date ?>">
    <input type="hidden" name="project_id" id="project_id" value="<?= $project_id ?>">
    <input type="hidden" name="tip" id="tip" value="1">
    <div class="form-container">
        <table>
            <thead>
            <tr>
                <th>Personel</th>
                <th>
                    Giriş Saati
                    <div class="header-input-container">
                        <input type="time" id="apply-entry-time">
                        <button type="button" class="apply-to-all" data-column="entry_time">Tümüne Uygula</button>
                    </div>
                </th>
                <th>
                    Mola Başlangıcı
                    <div class="header-input-container">
                        <input type="time" id="apply-break-start">
                        <button type="button" class="apply-to-all" data-column="break_start">Tümüne Uygula</button>
                    </div>
                </th>
                <th>
                    Mola Bitişi
                    <div class="header-input-container">
                        <input type="time" id="apply-break-end">
                        <button type="button" class="apply-to-all" data-column="break_end">Tümüne Uygula</button>
                    </div>
                </th>
                <th>
                    Çıkış Saati
                    <div class="header-input-container">
                        <input type="time" id="apply-exit-time">
                        <button type="button" class="apply-to-all" data-column="exit_time">Tümüne Uygula</button>
                    </div>
                </th>
                <th>Giriş İmza</th>
                <th>Çıkış İmza</th>
                <th>Açıklama</th>
                <th>Dosya</th>
            </tr>
            </thead>
            <tbody>
            <?php $first_row = true; // İlk satırı belirlemek için ?>

            <?php foreach ($project_users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <input type="time" name="entry_time[<?= $user->id ?>]"
                               value="<?= $user->entry_time && $user->entry_time !== '00:00:00' ? $user->entry_time : '' ?>"
                               class="entry_time">
                    </td>
                    <td>
                        <input type="time" name="break_start[<?= $user->id ?>]"
                               value="<?= $user->break_start && $user->break_start !== '00:00:00' ? $user->break_start : '' ?>"
                               class="break_start">
                    </td>
                    <td>
                        <input type="time" name="break_end[<?= $user->id ?>]"
                               value="<?= $user->break_end && $user->break_end !== '00:00:00' ? $user->break_end : '' ?>"
                               class="break_end">
                    </td>
                    <td>
                        <input type="time" name="exit_time[<?= $user->id ?>]"
                               value="<?= $user->exit_time && $user->exit_time !== '00:00:00' ? $user->exit_time : '' ?>"
                               class="exit_time">
                    </td>
                    <td>
                        <img src="<?= $user->in_signature_path && $user->in_signature_path !== base_url().'userfiles/attach/no_signature.png' ? base_url().$user->in_signature_path : base_url().'userfiles/attach/no_signature.png' ?>" name="signature[<?= $user->id ?>]" class="img-resonsive" width="120px" height="100px">
                        <br><span> <?= $user->in_signature_date ?? '' ?></span>
                    </td>
                    <td>
                        <img src="<?= $user->out_signature_path && $user->out_signature_path !== base_url().'userfiles/attach/no_signature.png' ? base_url().$user->out_signature_path : base_url().'userfiles/attach/no_signature.png' ?>" name="signature[<?= $user->id ?>]" class="img-resonsive" width="120px" height="100px">
                        <br><span> <?= $user->out_signature_date ?? '' ?></span>
                    </td>
                    <td>
                                                <textarea name="description[<?= $user->id ?>]" class="description">
                                                    <?= htmlspecialchars($user->description ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                </textarea>
                    </td>

                    <?php if ($first_row): ?>
                        <td rowspan="<?= count($project_users) ?>">
                            <div class="container">
                                <h3>Dosya Yükle</h3>

                                <!-- Mevcut Dosya -->
                                <div id="existingFile">
                                    <!-- Burada mevcut dosya bilgisi gösterilecek -->
                                </div>

                                <form id="uploadFormFile" enctype="multipart/form-data">
                                    <label for="file">Dosya Seç:</label>
                                    <input type="file" class="file" name="file" required>
                                    <button type="button" id="dosya_file">Yükle</button>
                                </form>
                                <div id="uploadResult"></div>
                            </div>
                        </td>
                        <?php $first_row = false; // İlk satırdan sonraki satırlarda dosya alanını gösterme ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button type="button" id="saveRecords">Tüm Kayıtları Kaydet</button>
    </div>
</form>
<div id="responseMessage" style="text-align: center; margin-top: 20px;"></div>
