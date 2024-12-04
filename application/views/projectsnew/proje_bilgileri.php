<div class="row" style="text-align: justify;">
    <div class="col-lg-4 col-md-12 col-xs-12 col-sm-12" style="height: 450px;border-right: 2px solid gray;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pb-2">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th rowspan="2" style="color: #ee5e29;font-size: 18px;">Proje Hakkında Bilgiler</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><h6 class="mb-0">Proje Kodu</h6></td>
                                <td><h6 class="mb-0"><?php echo $details->code ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="mb-0">Proje Adı</h6></td>
                                <td><h6 class="mb-0"><?php echo $details->name ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="mb-0">Proje Adresi</h6></td>
                                <td><h6 class="mb-0"><?php echo $details->project_adresi ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="mb-0">Başlangıç Tarihi</h6></td>
                                <td><h6 class="mb-0"><?php echo $details->sdate ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="mb-0">Bitiş Tarihi</h6></td>
                                <td><h6 class="mb-0"><?php echo $details->edate ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="mb-0">PROJE MÜDÜRÜ</h6></td>
                                <td><h6 class="mb-0"><?php echo personel_details($details->proje_muduru) ?></h6></td>
                            </tr>
                            <tr>
                                <td><h6 class="mb-0">Sifarişci</h6></td>
                                <td><h6 class="mb-0"><?php echo $details->customer ?></h6></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-xs-12 col-sm-12" style="height: 450px;border-right: 2px solid gray;">
        <div class="col-md-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th rowspan="2" style="color: #ee5e29;font-size: 18px;">Proje Bütçe Bilgileri</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><h6 class="mb-0">Sözleşme Numarası</h6></td>
                            <td><h6 class="mb-0"><?php echo $details->sozlesme_numarasi ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="mb-0">Sözleşme Tarihi</h6></td>
                            <td><h6 class="mb-0"><?php echo $details->sozlesme_date ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="mb-0">Sözleşme Tutarı</h6></td>
                            <td><h6 class="mb-0"><?php echo amountFormat($details->sozlesme_tutari) ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="mb-0">Bütçe</h6></td>
                            <td><h6 class="mb-0"><?php echo amountFormat($details->worth) ?></h6></td>
                        </tr>
                        <tr>
                            <td><h6 class="mb-0">Anlık Maliyet</h6></td>
                            <td><h6 class="mb-0"><?php echo amountFormat($new_maliyet); ?></h6></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-xs-12 col-sm-12" style="height: 450px;border-right: 2px solid gray;">
        <div class="col-md-12">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th rowspan="2" style="color: #ee5e29;font-size: 18px;">Diğer Bilgileri</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <?php   $depo=project_to_depo($details->prj);
                            $depo_id=0;
                            if($depo){
                                $depo_id=project_to_depo($details->prj)->id;
                                ?>
                                <td><h6 class="mb-0">Depo</h6></td>
                                <td><h6 class="mb-0"><?php echo  "<a target='_blank' class='btn btn-success' href='/warehouse/view/$depo_id'>".project_to_depo($details->prj)->title.'</a>'; ?></h6></td>
                                <?php
                            }
                            ?>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>