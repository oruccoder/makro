<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Proje Görüntüleme</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">
                            <div id="notify" class="alert alert-success" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>

                                <div class="message"></div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <input type="hidden" id="dashurl" value="projects/task_stats?id=<?php echo $project['id']; ?>">

                                        <nav>
                                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-arac_karti" data-toggle="tab" href="#active" role="tab" aria-controls="nav-home" aria-selected="true"> <?php echo $this->lang->line('Summary') ?></a>
                                                <a class="nav-item nav-link" id="nav-aktive_surucu" data-toggle="tab" href="#proje_yerleri" role="tab" aria-controls="nav-profile" aria-selected="false">Proje Bölümleri</a>
                                                <a class="nav-item nav-link" id="nav-lokasyon_info" data-toggle="tab" href="#milestones" role="tab" aria-controls="nav-contact" aria-selected="false">Aşamaları</a>
                                                <a class="nav-item nav-link" id="nav-surucu_notes" data-toggle="tab" href="#link" role="tab" aria-controls="nav-contact" aria-selected="false">İş Kalemleri</a>
                                                <a class="nav-item nav-link" id="nav-stoklar" data-toggle="tab" href="#stoklar" role="tab" aria-controls="nav-contact" aria-selected="false">Malzeme Listesi</a>
                                                <a class="nav-item nav-link" id="nav-stok_takibi" data-toggle="tab" href="#stok_takibi" role="tab" aria-controls="nav-contact" aria-selected="false">Stok Takibi</a>
                                                <!--a class="nav-item nav-link" id="nav-depo" data-toggle="tab" href="#depo" role="tab" aria-controls="nav-contact" aria-selected="false">Depo Takibi</a!-->
                                                <!--a class="nav-item nav-link" id="nav-demirbas" data-toggle="tab" href="#demirbas" role="tab" aria-controls="nav-contact" aria-selected="false">Demirbaşlar</a!-->
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#activities" role="tab" aria-controls="nav-contact" aria-selected="false">Nakliye Talepleri</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#files" role="tab" aria-controls="nav-contact" aria-selected="false">Dosyalar</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#notes" role="tab" aria-controls="nav-contact" aria-selected="false">Notlar</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#invoices" role="tab" aria-controls="nav-contact" aria-selected="false">Proje Faturaları</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#comments" role="tab" aria-controls="nav-contact" aria-selected="false">Yorumlar</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#tum_giderler" role="tab" aria-controls="nav-contact" aria-selected="false">Tüm Giderler</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#razilastirma" role="tab" aria-controls="nav-contact" aria-selected="false">Razilaştırma</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#formalar_" role="tab" aria-controls="nav-contact" aria-selected="false">Forma2</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#mt_urun" role="tab" aria-controls="nav-contact" aria-selected="false">Mt Ürün Raporu</a>
                                            </div>
                                        </nav>

                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active show" id="active"
                                                 aria-labelledby="active-tab" aria-expanded="true">
                                                <div class="row" style="text-align: justify;">
                                                    <div class="col-md-4" style="height: 790px;border-right: 2px solid gray;">
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
                                                                                <td><h6 class="mb-0"><?php echo $project['code'] ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">Proje Adı</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo $project['name'] ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">Proje Adresi</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo $project['project_adresi'] ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">Başlangıç Tarihi</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo $project['sdate'] ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">Bitiş Tarihi</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo $project['edate'] ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">PROJE Sorumlusu</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo personel_details($project['proje_sorumlusu_id']) ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">PROJE MÜDÜRÜ</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo personel_details($project['proje_muduru']) ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">PROJE Muhasib</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo personel_details($project['muhasebe_muduru_id']) ?></h6></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><h6 class="mb-0">Sifarişci</h6></td>
                                                                                <td><h6 class="mb-0"><?php echo $project['customer'] ?></h6></td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" style="height: 790px;border-right: 2px solid gray;">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th rowspan="2" style="color: #ee5e29;font-size: 18px;">Proje Bütçe Bilgileri Bilgileri</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><h6 class="mb-0">Sözleşme Numarası</h6></td>
                                                                            <td><h6 class="mb-0"><?php echo $project['sozlesme_numarasi'] ?></h6></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><h6 class="mb-0">Sözleşme Tarihi</h6></td>
                                                                            <td><h6 class="mb-0"><?php echo $project['sozlesme_date'] ?></h6></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><h6 class="mb-0">Sözleşme Tutarı</h6></td>
                                                                            <td><h6 class="mb-0"><?php echo amountFormat($project['sozlesme_tutari']) ?></h6></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><h6 class="mb-0">Bütçe</h6></td>
                                                                            <td><h6 class="mb-0"><?php echo amountFormat($project['worth']) ?></h6></td>
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
                                                    <div class="col-md-4" style="height: 790px;border-right: 2px solid gray;">
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
                                                                            <td><h6 class="mb-0">Depo</h6></td>
                                                                            <?php   $depo_id=project_to_depo($project['id'])->id; ?>
                                                                            <td><h6 class="mb-0"><?php echo  "<a target='_blank' class='btn btn-success' href='/warehouse/view/$depo_id'>".project_to_depo($project['id'])->title.'</a>'; ?></h6></td>
                                                                        </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" style="overflow: auto" id="link" role="tabpanel" aria-labelledby="link-tab"
                                                 aria-expanded="false">
                                                <table id="todotable"  class="table datatable-show-all"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox" class="form-control all_checked_is_kalemleri"></th>
                                                        <th>#</th>
                                                        <th>Tipi</th>
                                                        <th>Adı</th>
                                                        <th>Bölüm</th>
                                                        <th>Aşama</th>
                                                        <th>Fiyat</th>
                                                        <th>Miktar</th>
                                                        <th>Görülen İş</th>
                                                        <th>Kalan</th>
                                                        <th>Toplam Fiyat</th>
                                                        <th>Anlık Maliyet</th>
                                                        <th>Sorumlu Personel</th>
                                                        <th>Cari / Firma</th>
                                                        <th><?php echo $this->lang->line('Status') ?></th>
                                                        <th><?php echo $this->lang->line('Actions') ?></th>


                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>

                                                </table>
                                            </div>
                                            <!--thread-->
                                            <div class="tab-pane fade" id="thread" role="tabpanel" aria-labelledby="thread-tab"
                                                 aria-expanded="false">

                                                <ul class="timeline">
                                                    <?php $flag = true;
                                                    $total = count($thread_list);
                                                    foreach ($thread_list as $row) {


                                                        ?>
                                                        <li class="<?php if (!$flag) {
                                                            echo 'timeline-inverted';
                                                        } ?>">
                                                            <div class="timeline-badge info"><?php echo $total ?></div>
                                                            <div class="timeline-panel">
                                                                <div class="timeline-heading">
                                                                    <h4 class="timeline-title"><?php echo $row['name'] ?></h4>
                                                                    <p>
                                                                        <small class="text-muted"><i
                                                                                    class="glyphicon glyphicon-time"></i> <?php echo $row['emp'] . ' ' . $row['start'] . ' ~ ' . $row['duedate'] ?>
                                                                        </small>
                                                                    </p>
                                                                </div>
                                                                <div class="timeline-body">
                                                                    <p><?php echo $row['description'] ?></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php $flag = !$flag;
                                                        $total--;
                                                    } ?>


                                                </ul>


                                            </div>
                                            <!--thread-->
                                            <!--milestones-->
                                            <div class="tab-pane fade" id="milestones" role="tabpanel"
                                                 aria-labelledby="milestones-tab" aria-expanded="false">
                                                <div class="table-responsive">
                                                    <table id="asamalar" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Bağlı Olduğu Bölüm</th>
                                                            <th>Bağlı Olduğu Aşama </th>
                                                            <th>Aşama Adı</th>
                                                            <th>Sorumlu Personel</th>
                                                            <th>Cari / Taşeron Firma</th>
                                                            <th>Bütçe</th>
                                                            <th>Anlık Maliyet</th>
                                                            <th><?php echo $this->lang->line('Settings') ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--milestones-->


                                            <div class="tab-pane fade" id="stoklar" role="tabpanel"
                                                 aria-labelledby="stoklar-tab" aria-expanded="false">
                                                <div class="table-responsive">
                                                    <table id="stoklar_table" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th><input type="checkbox" class="form-control all_select_mt_list"></th>
                                                            <th>#</th>
                                                            <th>Bölüm</th>
                                                            <th>Aşama</th>
                                                            <th>Stok</th>
                                                            <th>Stok Açıklaması</th>
                                                            <th>Varyasyon</th>
                                                            <th>Tamamlayıcı Ürünler</th>
                                                            <th>Miktar</th>
                                                            <th>Birim Fiyatı</th>
                                                            <th>Tip</th>
                                                            <th><?php echo $this->lang->line('Settings') ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="stok_takibi" role="tabpanel"
                                                 aria-labelledby="stok_takibi-tab" aria-expanded="false">
                                                <div class="table-responsive">
                                                    <table id="stok_takibi_table" class="table datatable-show-all"
                                                           cellspacing="0" width="100%" style="    font-size: 14px;">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Mahsul</th>
                                                            <th>Güncel Depo Miktarı</th>
                                                            <th>Kullanılan Miktar</th>
<!--                                                            <th>Depoya Giriş Miktarı</th>-->
                                                            <th>Bölüm Adı</th>
                                                            <th>Aşama Adı</th>
                                                            <th>Sorumlu Kişi</th>
                                                            <th>İşlemi Yapan Personel</th>
                                                            <th>Fiş No</th>
                                                            <th>tarih</th>
                                                            <th>Açıklama</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="depo" role="tabpanel"
                                                 aria-labelledby="depo-tab" aria-expanded="false">
                                                <div class="table-responsive">
                                                    <table id="warehouse_table" class="table datatable-show-all"
                                                           cellspacing="0" width="100%" style="    font-size: 14px;">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Mahsul</th>
                                                            <th>Tamamlayıcı Ürün</th>
                                                            <th>Güncel Depo Miktarı</th>
                                                            <th>Sorumlu Kişi</th>
                                                            <th>Tarih</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <!--                <div class="tab-pane fade" id="demirbas" role="tabpanel"-->
                                            <!--                     aria-labelledby="demirbas-tab" aria-expanded="false">-->
                                            <!--                    <div class="table-responsive">-->
                                            <!--                        <table id="demirbas" class="table datatable-show-all"-->
                                            <!--                               cellspacing="0" width="100%">-->
                                            <!--                            <thead>-->
                                            <!--                            <tr>-->
                                            <!--                                <th>#</th>-->
                                            <!--                                <th>Bölüm</th>-->
                                            <!--                                <th>Aşama</th>-->
                                            <!--                                <th>Stok</th>-->
                                            <!--                                <th>Varyasyon</th>-->
                                            <!--                                <th>Miktar</th>-->
                                            <!--                                <th>--><?php //echo $this->lang->line('Settings') ?><!--</th>-->
                                            <!--                            </tr>-->
                                            <!--                            </thead>-->
                                            <!--                            <tbody>-->
                                            <!--                            </tbody>-->
                                            <!--                        </table>-->
                                            <!--                    </div>-->
                                            <!---->
                                            <!--                </div>-->


                                            <!--proje yerleri-->
                                            <div class="tab-pane fade" id="proje_yerleri" role="tabpanel"
                                                 aria-labelledby="milestones-tab" aria-expanded="false">
                                                <div class="table-responsive">

                                                    <table id="proje_bolumleri" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Bölüm Kodu</th>
                                                            <th><?php echo $this->lang->line('Name') ?></th>
                                                            <th><?php echo $this->lang->line('Budget') ?></th>
                                                            <th>Anlık Maliyet</th>
                                                            <th><?php echo $this->lang->line('Settings') ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Bölüm Kodu</th>
                                                            <th><?php echo $this->lang->line('Name') ?></th>
                                                            <th><?php echo $this->lang->line('Budget') ?></th>
                                                            <th>Anlık Maliyet</th>
                                                            <th><?php echo $this->lang->line('Settings') ?></th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--proje yerleri-->

                                            <!--activities-->
                                            <div class="tab-pane fade" id="activities" role="tabpanel"
                                                 aria-labelledby="activities-tab" aria-expanded="false" style="max-height: 500px;overflow: auto;"><p>

                                                <div class="table-responsive">

                                                    <table id="nakliye_talepleri" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Talep Kodu</th>
                                                            <th>Aciliyet</th>
                                                            <th>Tarih</th>
                                                            <th>Talep Eden</th>
                                                            <th>Proje</th>
                                                            <th>Tutar</th>
                                                            <th>Qalıq Ödeme</th>
                                                            <th>Durum</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

<!--                                                    <a-->
<!--                                                            href="--><?php //echo base_url('projects/addactivity?id=' . $project['id']) ?><!--"-->
<!--                                                            class="btn btn-primary btn-sm rounded">-->
<!--                                                        --><?php //echo $this->lang->line('Add activity') ?>
<!--                                                    </a></p>-->
<!--                                                --><?php
//                                                foreach ($activities as $row) { ?>
<!---->
<!---->
<!--                                                    <div class="form-group row">-->
<!---->
<!---->
<!--                                                        <div class="col-sm-10">-->
<!--                                                            --><?php
//
//                                                            echo '- ' . $row['value'] . '<br><br>';
//
//
//                                                            ?>
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                --><?php //}
//                                                ?>
                                            </div>
                                            <!--activities-->
                                            <!--files-->
                                            <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab"
                                                 aria-expanded="false">
                                                <p>
                                                    <?php foreach ($p_files as $row) { ?>


                                                <section class="form-group row">


                                                    <div data-block="sec" class="col-sm-12">
                                                        <div class="card card-block"><?php


                                                            echo '<a href="' . base_url('userfiles/project/' . $row['value']) . '">' . $row['value'] . '</a><a href="#" class="btn btn-danger float-xs-right delete-custom" data-did="1" data-object-id="' . $row['meta_data'] . '"><i class="icon-trash-b"></i></a> ';

                                                            echo '<br><br>';
                                                            ?></div>
                                                    </div>
                                                </section>
                                                <?php } ?>
                                                </p>
                                                <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>...</span>
                                                    <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
                                                <br>
                                                <br>
                                                <!-- The global progress bar -->
                                                <div id="progress" class="progress">
                                                    <div class="progress-bar progress-bar-success"></div>
                                                </div>
                                                <!-- The container for the uploaded files -->
                                                <div id="files" class="files"></div>
                                                <br>
                                            </div>
                                            <!--Files-->
                                            <!--notes-->
                                            <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab"
                                                 aria-expanded="false">
                                                <form method="post" id="data_form">
                                                    <div class="form-group row">


                                                        <div class="col-sm-12">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10"
                                  name="content"><?php echo $project['note']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">


                                                        <div class="col-sm-10">
                                                            <input type="submit" class="btn btn-success sub-btn"
                                                                   value="<?php echo $this->lang->line('Update') ?> "
                                                                   id="submit-data" data-loading-text="Creating...">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="projects/set_note" id="action-url">
                                                    <input type="hidden" value="<?php echo $project['id']; ?>" name="nid">
                                                </form>
                                            </div>
                                            <!--notes-->
                                            <!--invoices-->
                                            <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab"
                                                 aria-expanded="false">
                                                <p><a href="<?php echo base_url('invoices/create?project=' . $project['id']) ?>"
                                                      class="btn btn-primary btn-sm rounded">
                                                        <?php echo $this->lang->line('Create New Invoice') ?>
                                                    </a></p>

                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-1">

                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('ProjectInvoices') ?></th>
                                                            <th><?php echo $this->lang->line('Customer') ?></th>
                                                            <th><?php echo $this->lang->line('Status') ?></th>
                                                            <th><?php echo $this->lang->line('Due') ?></th>
                                                            <th><?php echo $this->lang->line('Amount') ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $genel_toplam=0;
                                                        $company_name='Cari Seçilmemiş';
                                                        foreach ($invoices as $item) {


                                                            if(isset($item['csd']))
                                                            {
                                                                $company_name=customer_details($item['csd'])['company'];
                                                            }
                                                            echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'invoices/view?id=' . $item['id'] . '">#' . $item['invoice_no'] . '</a></td>
                                <td class="text-truncate"><a href="' . base_url() . 'customers/view?id=' . $item['csd'] . '">' . $company_name . '</a></td>

                                <td class="text-truncate"><span class="tag tag-default st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td>
                                <td class="text-truncate">' . $item['invoicedate'] . '</td>
                                <td class="text-truncate"> ' . amountFormat($item['total']*$item['kur_degeri']) . '</td>
                            </tr>';
                                                            $genel_toplam+=$item['total']*$item['kur_degeri']; } ?>

                                                        </tbody>
                                                        <tfoot>
                                                        <tr>

                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="no-sort">Toplam</th>
                                                            <th class="no-sort"><?php echo amountFormat($genel_toplam);?></th>

                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--invoices-->
                                            <!--comments-->
                                            <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab"
                                                 aria-expanded="false">
                                                <p>Comments timeline among team members and customer.</p>
                                                <form method="post" id="data_form2">
                                                    <div class="form-group row">


                                                        <div class="col-sm-12">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">


                                                        <div class="col-sm-10">
                                                            <input type="submit" class="btn btn-success sub-btn"
                                                                   value="<?php echo $this->lang->line('Comment') ?> "
                                                                   id="submit-data2" >
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="projects/addcomment" id="action-url2">
                                                    <input type="hidden" value="<?php echo $project['id']; ?>" name="nid">
                                                </form>
                                                <ul class="timeline">
                                                    <?php $flag = true;
                                                    $total = count($comments_list);
                                                    foreach ($comments_list as $row) {


                                                        ?>
                                                        <li class="<?php if (!$flag) {
                                                            echo 'timeline-inverted';
                                                        } ?>">
                                                            <div class="timeline-badge info"><?php echo $total ?></div>
                                                            <div class="timeline-panel">
                                                                <div class="timeline-heading">
                                                                    <h4 class="timeline-title"><?php if ($row['key3']) echo $row['customer'] . ' Reply <small>(Customer)</small>'; else echo $row['employee'] . ' Reply <small>(Employee)</small>'; ?></h4>

                                                                </div>
                                                                <div class="timeline-body">
                                                                    <p><?php echo $row['value'] ?></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php $flag = !$flag;
                                                        $total--;
                                                    } ?>


                                                </ul>


                                            </div>
                                            <!--comments-->
                                            <!--Tüm Giderler-->
                                            <div class="tab-pane fade" id="tum_giderler" role="tabpanel"  aria-labelledby="tum-giderler" aria-expanded="false">

                                                <style>
                                                    table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
                                                    {
                                                        padding-right: 114px !important;
                                                    }
                                                </style>
                                                <div class="table-responsive">
                                                    <table id="all_gider" class="table datatable-show-all table-hover"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tarih</th>
                                                            <th>Firma</th>
                                                            <th>Fatura No</th>
                                                            <th>Tip</th>
                                                            <!--                                    <th>Ürün</th>-->
                                                            <th>Açıklama</th>
<!--                                                            <th>Birim</th>-->

                                                            <th>Birim Fiyatı</th>
                                                            <th>Miktar</th>
<!--                                                            <th>KDV Oranı</th>-->
<!--                                                            <th>Net Toplam (KDV HARİÇ</th>-->
<!--                                                            <th>KDV</th>-->
                                                            <th>Toplam</th>
                                                            <th>Ödeme Şekli</th>
<!--                                                            <th>Ödeme Durumu</th>-->
<!--                                                            <th>Ödenen</th>-->
<!--                                                            <th>Kalan</th>-->
<!--                                                            <th>KDV Ödenen</th>-->
<!--                                                            <th>KDV Kalan</th>-->
<!--                                                            <th>Gümrük Nakit Ödemeler</th>-->
<!--                                                            <th>Gümrük Köçürme</th>-->
<!--                                                            <th>Nakit Komisyon</th>-->
<!--                                                            <th>Banka Komisyon</th>-->
<!--                                                            <th>Toplam</th>-->
                                                            <th>Fatura / Gider </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

<!--                                                        <tfoot>-->
<!--                                                        <tr>-->
<!---->
<!--                                                            <th></th>-->
<!--                                                            <th>-->
<!--                                                                <input style="width: 170px !important;" type="date" class="form-control"-->
<!--                                                                       placeholder="Billing Date" name="invoicedate" id="invoicedate">-->
<!--                                                            </th>-->
<!--                                                            <th>-->
<!--                                                                <select  style="width: 170px !important;" name="customer_id[]" id="customer_id" class="form-control select-box" multiple>-->
<!--                                                                    <option>Firma</option>-->
<!--                                                                    --><?php
//                                                                    foreach (all_customer() as $customer)
//                                                                    {
//                                                                        echo '<option value="'.$customer->id.'">'.$customer->company.'</option>';
//                                                                    }
//                                                                    ?>
<!--                                                                </select>-->
<!--                                                            </th>-->
<!--                                                            <th><input type="text" class="form-control" placeholder="Fatura No" id="invoice_no" name="invoice_no"></th>-->
<!--                                                                                          <th>-->
<!--                                                                                               <select  style="width: 170px !important;" name="cost_id[]" id="cost_id" class="form-control select-box" multiple >-->
<!--                                                                                                  <option>Hizmet</option>-->
<!--                                                                                                  --><?php
//                                                            //                                        foreach (all_ana_masraf() as $cost)
//                                                            //                                        {
//                                                            //                                            echo '<option value="'.$cost->id.'">'.$cost->name.'</option>';
//                                                            //                                        }
//                                                            //                                        ?>
<!--                                                                                         </select>-->
<!--                                                                                     </th>-->
<!--                                                            <th>-->
<!--                                                                <select  style="width: 170px !important;" name="cost_alt_id[]" id="cost_alt_id" class="form-control select-box" multiple >-->
<!--                                                                    <option>Hizmet</option>-->
<!--                                                                    --><?php
//                                                                    foreach (all_alt_masraf() as $cost)
//                                                                    {
//                                                                        echo '<option value="'.$cost->id.'">'.$cost->name.'</option>';
//                                                                    }
//                                                                    ?>
<!--                                                                </select>-->
<!--                                                            </th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th>-->
<!--
<!--                                                                <select  style="width: 170px !important;" name="odeme_metodu[]" id="odeme_metodu" class="form-control select-box" multiple >-->
<!--                                                                    --><?php
//                                                                    foreach (account_type() as $cost)
//                                                                    {
//                                                                        echo '<option value="'.$cost['id'].'">'.$cost['name'].'</option>';
//                                                                    }
//                                                                    ?>
<!--                                                                </select>-->
<!--                                                            </th>-->
<!--<!--                                                            <th> Ödeme Durumu -->
<!--<!--                                                                <select  style="width: 170px !important;" name="odeme_durumu[]" id="odeme_durumu" class="form-control select-box" multiple >-->
<!--<!--                                                                    <option value="1">Ödendi</option>-->
<!--<!--                                                                    <option value="2">Ödenmedi</option>-->
<!--<!--                                                                    <option value="3">Kısmi Ödeme</option>-->
<!--<!--                                                                </select>-->
<!--<!--                                                            </th>-->
<!--<!--                                                            <th>Ödenen</th>-->
<!--<!--                                                            <th>Kalan</th>-->
<!--<!--                                                            <th>KDV Ödenen</th>-->
<!--<!--                                                            <th>KDV Kalan</th>-->
<!--<!--                                                            <th></th>-->
<!--<!--                                                            <th></th>-->
<!--<!--                                                            <th></th>-->
<!--                                                            <th></th>-->
<!--                                                            <th class="no-sort"></th>-->
<!--                                                            <th class="no-sort"></th>-->
<!---->
<!--                                                        </tr>-->
<!--                                                        </tfoot>-->
                                                    </table>
                                                </div>

                                            </div>
                                            <!--Tüm Giderler-->


                                            <!--razilaştırma Listesi-->
                                            <div class="tab-pane fade" id="razilastirma" role="tabpanel"  aria-labelledby="razilaştırma" aria-expanded="false">

                                                <style>
                                                    table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
                                                    {
                                                        padding-right: 114px !important;
                                                    }
                                                </style>
                                                <div class="table-responsive">
                                                    <table id="razilastirma_list" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Razilaştırma Kodu</th>
                                                            <th>Cari</th>
                                                            <th>Ödeme Metodu</th>
                                                            <th>KDV Oranı</th>
                                                            <th>Net Toplam</th>
                                                            <th>KDV Toplam</th>
                                                            <th>Genel Toplam</th>
                                                            <th>Onay Durumu</th>
                                                            <th>Durum</th>
                                                            <th>İşlem</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--razilaştırma-->

                                            <!--Forma 2 Listesi-->
                                            <div class="tab-pane fade" id="formalar_" role="tabpanel"  aria-labelledby="formalar" aria-expanded="false">

                                                <style>
                                                    table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
                                                    {
                                                        padding-right: 114px !important;
                                                    }
                                                </style>
                                                <div class="table-responsive">
                                                    <table id="forma_2_new" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Tarih</th>
                                                            <th>Forma 2 Tipi</th>
                                                            <th>Muqavile No</th>
                                                            <th>Cari</th>
                                                            <th>Durum</th>
                                                            <th>Açıklama</th>
                                                            <th>Proje</th>
                                                            <th>Eylem</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>

                                                            <th></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>

                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--Forma 2 Listesi-->


                                            <!--Mt Ürünleri-->
                                            <div class="tab-pane fade" id="mt_urun" role="tabpanel"  aria-labelledby="mt_urun" aria-expanded="false">

                                                <style>
                                                    table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
                                                    {
                                                        padding-right: 114px !important;
                                                    }
                                                </style>
                                                <div class="table-responsive">
                                                    <table id="mt_urun_table" class="table datatable-show-all"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>MT Kodu</th>
                                                            <th>Ürün</th>
                                                            <th>Varyant</th>
                                                            <th>Sipariş Miktarı</th>
                                                            <th>Tehvil Detayları</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>

                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                            </div>
                                            <!--Mt Ürünleri-->


                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$milestones = array_map(function($row) {
    $row['bolum_name'] = bolum_getir($row['bolum_id']);
    return $row;
}, $milestones);
?>
<input type="hidden" id="proje_id_hidden" value="<?php echo $project['id']; ?>">
<style>


    table.dataTable tbody tr.odd.selected {
        background-color:#acbad4
    }

    table.dataTable tbody tr.even.selected {
        background-color:#acbad5
    }
    tr.odd.active {
        background-color: #616c87 !important;
        color: white;
    }
    tr.even.active {
        background-color: #616c87 !important;
        color: white;
    }

</style>
<script type="text/javascript">



    function draw_data_all_gider(customer_id ='',invoice_date ='',invoice_no='')
    {
        if($('#customer_id').val())
        {
            customer_id=$('#customer_id').val();
        }

        if($('#invoicedate').val())
        {
            invoice_date=$('#invoicedate').val();
        }
        if($('#invoice_no').val())
        {
            invoice_no=$('#invoice_no').val();
        }

        $('#all_gider').DataTable({

            'processing': true,
            'serverSide': true,
            fixedHeader: true,
            ordering: false,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                //$(row).attr('style',data[5]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projects/all_gider')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    'customer_id':customer_id,
                    'invoice_date':invoice_date,
                    'invoice_no':invoice_no
                }
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            "aLengthMenu": [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // // Total over all pages
                // nakit_komisyon = api
                //     .column( 21 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                // banka_komisyon = api
                //     .column( 22 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );

                // gtoplam = api
                //     .column( 23 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );

                // kdv_toplam = api
                //     .column( 11 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                // net_toplam = api
                //     .column( 10 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                // kdv_haric_b_fiyati = api
                //     .column( 8 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                //
                //
                // odenen = api
                //     .column( 15 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                // kalan = api
                //     .column( 16 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                // kdv_odenen = api
                //     .column( 17 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );
                //
                // kdv_kalan = api
                //     .column( 18 )
                //     .data()
                //     .reduce( function (a, b) {
                //         return floatVal(a) + floatVal(b);
                //     }, 0 );



                // Update footer

                // var nakit_komisyon_t =currencyFormat(floatVal(nakit_komisyon));
                // var banka_komisyon_t =currencyFormat(floatVal(banka_komisyon));
                //
                // var kdv_toplam_t =currencyFormat(floatVal(kdv_toplam));
                // var net_toplam_t =currencyFormat(floatVal(net_toplam));
                // var kdv_haric_b_fiyati_t =currencyFormat(floatVal(kdv_haric_b_fiyati));
                // var odenen_t =currencyFormat(floatVal(odenen));
                // var kalan_t =currencyFormat(floatVal(kalan));
                // var kdv_odenen_t =currencyFormat(floatVal(kdv_odenen));
                // var kdv_kalan_t =currencyFormat(floatVal(kdv_kalan));

                // var gtoplam_t =currencyFormat(floatVal(gtoplam));
                //
                // $( api.column( 21 ).footer() ).html(nakit_komisyon_t);
                // $( api.column( 22 ).footer() ).html(banka_komisyon_t);
                //
                // $( api.column( 11 ).footer() ).html(kdv_toplam_t);
                // $( api.column( 10 ).footer() ).html(net_toplam_t);

                // $( api.column( 23 ).footer() ).html(gtoplam_t);
                // $( api.column( 12 ).footer() ).html(gtoplam_t);
                //$( api.column( 9 ).footer() ).html(kdv_haric_b_fiyati_t);
                //
                // $( api.column( 15 ).footer() ).html(odenen_t);
                // $( api.column( 16 ).footer() ).html(kalan_t);
                // $( api.column( 17 ).footer() ).html(kdv_odenen_t);
                // $( api.column( 18 ).footer() ).html(kdv_kalan_t);
            }

        });


        $('#all_gider tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('active');
        } );
    }


    $(document).on('change', '#customer_id', function(){
        var customer_id = $(this).val();
        $('#all_gider').DataTable().destroy();
        draw_data_all_gider(customer_id);

    });




    $(document).on('keyup', '#invoice_no', function(){
        var invoice_no = $(this).val();
        $('#all_gider').DataTable().destroy();
        draw_data_all_gider('','',invoice_no);

    });

    $(document).on('change', '#invoicedate', function(){
        var invoicedate = $(this).val();
        $('#all_gider').DataTable().destroy();
        draw_data_all_gider('',invoicedate);

    });



    $(document).ready(function () {

        draw_data_all_gider();
        draw_data_bolumler();
        draw_data_asamalar();
        draw_data_iskalemleri();
        draw_data_stoklar();
        draw_data_stok_takibi();
        draw_data_depo_takibi();
        draw_data_razilastirma();
        draw_data();
        draw_data_mt_Report();
        draw_data_nakliye();


    });



    $(document).on('click', ".set-task", function (e) {
        e.preventDefault();
        $('#taskid').val($(this).attr('data-id'));

        $('#pop_model').modal({backdrop: 'static', keyboard: false});

    });

    $(document).on('click',".parent_product",function (){
        let proje_stoklari_id = $(this).attr('proje_stoklari_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Alt Ürünler',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html=`<form>
                    <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="name">Ürün Adı</label>
                    <select id="product_parent" class="form-control product_parent"> </select>

                </div>
            </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="content">Birim</label>
                       <select class="form-control select-box unit_id" id='unit_id'>
                            <?php foreach (units() as $blm)
                            {
                                $id=$blm['id'];
                                $name=$blm['name'];
                                echo "<option data-name='$name' value='$id'>$name</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="butce">Miktar</label>
                        <input type="number" class="form-control" id="qty" value="1">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="content">Birim Fiyatı</label>
                        <input type="text" class="form-control" id="price" value="0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <button type='button' class='btn btn-success add_parent_list'> Listeye Ekle</button>
                    </div>
                </div>
             <div class="form-row">
                <table id="result_parent" class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Mehsul</th>
                      <th scope="col">Varyasyon</th>
                      <th scope="col">Olcu vahidi</th>
                      <th scope="col">Miqdar</th>
                      <th scope="col">Birim Fiyatı</th>
                      <th scope="col">Sil</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
                <input type='hidden' class='proje_stoklari_id' value='`+proje_stoklari_id+`'>
            </div>
            </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    proje_stoklari_id: proje_stoklari_id,
                }
                $.post(baseurl + 'projestoklari/get_parent_products',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        let i=1;
                        $.each(responses.item, function (index, item) {
                            $("#result_parent>tbody").append('<tr data-qty="'+item.qty+'" data-price="'+item.unit_price+'" data-option-id="'+item.option_id+'" data-option-value-id="'+item.option_value_id+'" data-unit_id="'+item.unit_id+'" data-product_id="'+item.product_id+'"  id="remove'+i+'" class="result-row">' +
                                '<td>'+i+'</td> ' +
                                '<td>'+ item.product_name +'</td>' +
                                '<td>'+ item.value_text +'</td>' +
                                '<td>'+item.unit_name+'</td>' +
                                '<td>'+item.qty+'</td>' +
                                '<td>'+item.unit_price+'</td>' +
                                '<td> <button type="button" data-id="'+i+'" class="btn btn-danger delete_row"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                '</tr>' );
                            i++;
                        });
                    }


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let count = $('#result_parent tbody tr').length;
                        let data_post=[];
                        let collection=[];
                        for(let i=0; i < count; i++ ){
                            let data = {

                                product_id: $('#result_parent tbody tr').eq(i).attr('data-product_id'),
                                value_id: $('#result_parent tbody tr').eq(i).attr('data-option-value-id'),
                                unit_id: $('#result_parent tbody tr').eq(i).attr('data-unit_id'),
                                option_id: $('#result_parent tbody tr').eq(i).attr('data-option-id'),
                                price: $('#result_parent tbody tr').eq(i).attr('data-price'),
                                qty: $('#result_parent tbody tr').eq(i).attr('data-qty'),
                            }
                            collection.push(data)
                        }
                        data_post ={
                            proje_stoklari_id:  $('.proje_stoklari_id').val(),
                            collection:collection,

                        }
                        $.post(baseurl + 'projestoklari/create_parent',data_post,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#stoklar_table').DataTable().destroy();
                                                draw_data_stoklar();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.product_parent').select2({
                    dropdownParent: $(".jconfirm-box-container"),
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder:'Seçiniz',
                    language: {
                        inputTooShort: function() {
                            return 'En az 3 karakter giriniz';
                        }
                    },
                    ajax: {
                        method:'POST',
                        url: '<?php echo base_url().'stockio/getall_products' ?>',
                        dataType: 'json',
                        data:function (params)
                        {
                            let query = {
                                search: params.term,
                                warehouse_id: 0,
                                crsf_token: crsf_hash,
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (data) {
                                    return {
                                        text: data.product_name,
                                        product_name: data.product_name,
                                        id: data.pid,

                                    }
                                })
                            };
                        },
                        cache: true
                    },
                }).on('change',function (data) {
                })


                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    let i=1;
    let table_parent_product_id_ar=[];
    $(document).on('click','.add_parent_list',function(){
        let product_id = $("#product_parent").val();
        let varyasyon_durum=false;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Varyasyonlar',
            icon: 'fa fa-filter',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    product_id: product_id
                }
                let table_report='';
                $.post(baseurl + 'malzemetalep/get_product_to_value',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.list').empty().html(responses.html)
                    if(responses.code==200){
                        varyasyon_durum=true;
                    }
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let option_details=[];
                        if(varyasyon_durum){
                            $('.option-value:checked').each((index,item) => {
                                option_details.push({
                                    'option_id':$(item).attr('data-option-id'),
                                    'option_name':$(item).attr('data-option-name'),
                                    'option_value_id':$(item).attr('data-value-id'),
                                    'option_value_name':$(item).attr('data-option-value-name'),
                                })
                            });
                        }
                        else {

                        }
                        let proje_name = '-';
                        let data_post = {
                            crsf_token: crsf_hash,
                            id: product_id,
                            option_details:option_details
                        }
                        let data='';
                        let result=false;
                        let sayi=0;
                        $.post(baseurl + 'stockio/product_details',data_post,(response)=> {
                            let data_res = jQuery.parseJSON(response);

                            // if(table_parent_product_id_ar.length){
                            //     for (let k = 0; k < table_parent_product_id_ar.length; k++){
                            //         if(data_res.result.option_details){
                            //             for (let j=0; j < data_res.result.option_details.length;j++){
                            //                 if(table_parent_product_id_ar[k].product_options[j].option_id==data_res.result.option_details[j].option_id &&  table_product_id_ar[k].product_options[j].option_value_id==data_res.result.option_details[j].option_value_id){
                            //                     sayi++;
                            //                 }
                            //             }
                            //         }
                            //
                            //
                            //     }
                            //
                            //     result = false;
                            //     // if(data_res.result.option_details.length==sayi){
                            //     //     result = true;
                            //     // }
                            //     // else {
                            //     //     result=false;
                            //     // }
                            // }
                            if (data_res.code == 200) {
                                data = {
                                    qty:          $('#qty').val(),
                                    unit_id:      $('#unit_id').val(),
                                    unit_name:      $("#unit_id").find(':selected').data('name'),
                                    price:    $('#price').val(),
                                    product_id:   data_res.result.product_id,
                                    product_name: data_res.result.product_name,
                                    option_details: option_details

                                }

                                if(!result){
                                    let varyasyon_html='';
                                    let option_id_data='';
                                    let option_value_id_data='';
                                    if(option_details){
                                        for (let i=0; i < option_details.length;i++){
                                            varyasyon_html+=option_details[i].option_name+' : '+option_details[i].option_value_name+'<br>';
                                            if(i===(option_details.length)-1){
                                                option_id_data+=option_details[i].option_id;
                                                option_value_id_data+=option_details[i].option_value_id;
                                            }
                                            else {
                                                option_id_data+=option_details[i].option_id+',';
                                                option_value_id_data+=option_details[i].option_value_id+',';
                                            }

                                        }


                                    }

                                    $("#result_parent>tbody").append('<tr data-qty="'+data.qty+'" data-price="'+data.price+'" data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-unit_id="'+data.unit_id+'" data-product_id="'+data.product_id+'"  id="remove'+i+'" class="result-row">' +
                                        '<td>'+i+'</td> ' +
                                        '<td>'+ data.product_name +'</td>' +
                                        '<td>'+ varyasyon_html +'</td>' +
                                        '<td>'+data.unit_name+'</td>' +
                                        '<td>'+data.qty+'</td>' +
                                        '<td>'+data.price+'</td>' +
                                        '<td> <button type="button" data-id="'+i+'" class="btn btn-danger delete_row"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                        '</tr>' );
                                    i++;
                                    table_parent_product_id_ar.push({product_id : data.product_id,product_options:data.option_details });
                                    setTimeout(function(){
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    }, 1000);
                                }
                                else {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Ürün Daha Önceden Eklenmiştir',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }

                            }
                        })
                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                setTimeout(function(){
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm")
                    })
                }, 1000);
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $(document).on('click','.delete_row',function () {
        let stok_id = $(this).data('id')
        let remove = '#remove'+ stok_id
        $(remove).remove();
    })

    $(document).on('click', ".view_task", function (e) {
        e.preventDefault();

        var actionurl = 'tools/view_task';
        var id = $(this).attr('data-id');
        $('#task_model').modal({backdrop: 'static', keyboard: false});


        $.ajax({

            url: baseurl + actionurl,
            type: 'POST',
            data: {'tid': id,'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            dataType: 'json',
            success: function (data) {

                $('#description').html(data.description);
                $('#task_title').html(data.name);
                $('#employee').html(data.employee);
                $('#assign').html(data.assign);
                $('#priority').html(data.priority);
            }

        });

    });
    function draw_data_nakliye() {
        $('#nakliye_talepleri').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('nakliye/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id: $("#proje_id").val(),
                }
            },
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style',data[12]);

            },
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Talep Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni İstək Əlavə Edin ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id proje_id_new required" id="proje_id">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->code;
                            ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="talep_eden_user_id">Talep Eden</label>
      <select class="form-control select-box required" id="talep_eden_user_id">

            <?php foreach (all_personel() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
    </select>
    </div>
    <div class="form-group col-md-6">
      <label for="firma_id">Təcili</label>
        <select class="form-control select-box" id="progress_status_id">

            <?php foreach (progress_status() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select>

    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Fayl</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="files[]">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>
       </div>
</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Sorğunu Açın',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        $('#loading-box').removeClass('d-none');
                                        let data = {
                                            crsf_token: crsf_hash,
                                            progress_status_id:  $('#progress_status_id').val(),
                                            talep_eden_user_id:  $('#talep_eden_user_id').val(),
                                            proje_id:  $('#proje_id').val(),
                                            method:  0,
                                            cari_id:  0,
                                            desc:  $('#desc').val(),
                                            image_text:  $('#image_text').val(),
                                        }
                                        $.post(baseurl + 'nakliye/create_save',data,(response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if(responses.status=='Success'){
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons:{
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                location.href = responses.index
                                                            }
                                                        }
                                                    }
                                                });

                                            }
                                            else if(responses.status=='Error'){

                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: responses.message,
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                            }
                                        })

                                    }
                                },
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $('#fileupload_').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        var img='default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img=file.name;
                                        });

                                        $('#image_text').val(img);
                                    },
                                    progressall: function (e, data) {
                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#progress .progress-bar').css(
                                            'width',
                                            progress + '%'
                                        );
                                    }
                                }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                // bind to events
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ]
        });
    };
    function draw_data_bolumler(){
        $('#proje_bolumleri').DataTable({

            "processing": true,
            "serverSide": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style',data[5]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projebolumleri/ajax_list')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>,'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Bölüm Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Bölüm Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: true,
                            smoothContent: true,
                            draggable: false,
                            content: `<form id="add-section-form">
                      <div class="form-row">
                          <div class="form-group col-md-12">
                              <label for="code">Bölüm Kodu</label>
                              <input type="text" class="form-control" id="code" placeholder="Bölüm Kodu">
                          </div>
                          <div class="form-group col-md-12">
                              <label for="name">Bölüm Adı</label>
                              <input type="text" class="form-control required" id="name" placeholder="Bölüm Adı">
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="butce">Bütçe</label>
                              <input type="number" class="form-control required" id="butce" placeholder="300.000">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="content">Açıklama</label>
                              <input type="text" class="form-control required" id="content" placeholder="Detay">
                          </div>
                      </div>
                  </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        // Doğrulama
                                        let valid = true;
                                        $('#add-section-form .required').each(function () {
                                            if (!$(this).val()) {
                                                $(this).addClass('is-invalid');
                                                valid = false;
                                            } else {
                                                $(this).removeClass('is-invalid');
                                            }
                                        });

                                        if (!valid) {
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                title: 'Hata',
                                                content: 'Lütfen tüm alanları doldurun!',
                                            });
                                            return false;
                                        }

                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            name: $('#name').val(),
                                            code: $('#code').val(),
                                            butce: $('#butce').val(),
                                            content: $('#content').val(),
                                            project: "<?php echo $_GET['id'] ?>"
                                        };

                                        $.post(baseurl + 'projebolumleri/create', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status === 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#proje_bolumleri').DataTable().destroy();
                                                                draw_data_bolumler();
                                                            }
                                                        }
                                                    }
                                                });
                                            } else if (responses.status === 410) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    title: 'Dikkat!',
                                                    content: responses.message,
                                                });
                                            }
                                        });
                                    }
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });

                                const jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click');
                                });
                            }
                        });
                    }
                }
            ]

        });
    }

    function draw_data_stoklar() {
        $('#stoklar_table').DataTable({

            "processing": true,
            "serverSide": true,
                aLengthMenu: [
                    [ 10, 50, 100, 200,-1],
                    [10, 50, 100, 200,"Tümü"]
                ],
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style', data[12]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projestoklari/ajax_list')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5,6,7,8]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5,6,7,8]
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i> Yeni Stok Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Stok Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-8 col-md-8">
                        <div class="jarviswidget">
                            <header><h4>Ürün Arama Alanı</h4></header>
                            <div class="borderedccc">
                                <div class="widget-body">
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <fieldset>
                                            <div class="row mb-2">
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Kategori Bazlı Ara</label>
                                                    <select class="form-control select-box" id="category_id">
                                                    <option value='0'>Seçiniz</option>
                                                            <?php
                            foreach (category_list_() as $item) :

                                $id = $item['id'];
                                $title = $item['title'];
                                $new_title = _ust_kategori_kontrol($id).$title;
                                echo "<option value='$id'>$new_title</option>";

                            endforeach;
                            ?>
                                                    </select>
                                                </section>
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Malzeme Adı</label>
                                                    <input type="texy" placeholder="Min 3 karakter veya Kategori Seçini" class="form-control" id="search_name">
                                                </section>
                                            </div>
                                            <div class="row mb-2">
                                                <section class="col col-sm-12 col-md-12">
                                                    <button class="btn btn-info" tip='1' id="search_button"><i class="fa fa-search"></i>&nbsp;Ara</button>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col col-xs-12 col-sm-4 col-md-4">
                        <div class="jarviswidget" style="max-height: 350px;overflow: auto;">
                            <header><h4>Atanan Malzemeler (<?php echo proje_code($_GET['id'])?>)</h4></header>
                            <table class="table table_create_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Malzeme</th>
                                        <th>Miktar</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <div class="jarviswidget" style="max-height: 630px;overflow: auto;">
                            <header><h4>Malzemeler</h4></header>
                            <table class="table table_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Malzeme</th>
                                        <th>Açıklama</th>
                                        <th>Birim Fiyatı</th>
                                        <th>Proje Bölümü  &nbsp;<button class="bolum_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Proje Aşaması &nbsp;<button class="asama_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Birim &nbsp;<button class="birim_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                        <th>Miktar</th>
                                        <th>İşlem &nbsp;<button class="add_all btn-sm btn btn-info"><i class="fa fa-check-double"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`,
                            buttons: {
                                cancel: {
                                    text: 'Çıkış',
                                    btnClass: "btn btn-danger btn-sm",
                                    action: function () {
                                        $('#stoklar_table').DataTable().destroy();
                                        draw_data_stoklar();
                                    }
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $('#fileupload_').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        var img = 'default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img = file.name;
                                        });

                                        $('#image_text').val(img);
                                    },
                                    progressall: function (e, data) {
                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#progress .progress-bar').css(
                                            'width',
                                            progress + '%'
                                        );
                                    }
                                }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                // bind to events
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i> Elave Stok Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Stok Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-12 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col col-xs-12 col-sm-8 col-md-8">
                        <div class="jarviswidget">
                            <header><h4>Ürün Arama Alanı</h4></header>
                            <div class="borderedccc">
                                <div class="widget-body">
                                    <div class="col col-xs-12 col-sm-12 col-md-12">
                                        <fieldset>
                                            <div class="row mb-2">
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Kategori Bazlı Ara</label>
                                                    <select class="form-control select-box" id="category_id">
                                                    <option value='0'>Seçiniz</option>
                                                            <?php
                            foreach (all_categories() as $row) {
                                $cid = $row->id;
                                $title = $row->title;
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                                                    </select>
                                                </section>
                                                <section class="col col-sm-6 col-md-6">
                                                    <label class="label">Malzeme Adı</label>
                                                    <input type="texy" placeholder="Min 3 karakter veya Kategori Seçini" class="form-control" id="search_name">
                                                </section>
                                            </div>
                                            <div class="row mb-2">
                                                <section class="col col-sm-12 col-md-12">
                                                    <button class="btn btn-info" tip='2' id="search_button"><i class="fa fa-search"></i>&nbsp;Ara</button>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col col-xs-12 col-sm-4 col-md-4">
                        <div class="jarviswidget">
                            <header><h4>Atanan Malzemeler (<?php echo proje_code($_GET['id'])?>)</h4></header>
                            <table class="table table_create_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Malzeme</th>
                                        <th>Miktar</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <div class="jarviswidget">
                            <header><h4>Malzemeler</h4></header>
                            <table class="table table_products">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Malzeme</th>
                                        <th>Açıklama</th>
                                        <th>Birim Fiyatı</th>
                                        <th>Proje Bölümü  &nbsp;<button class="bolum_all btn-sm btn btn-info"><i class="fa-solid fa-check-double"></i></th>
                                        <th>Proje Aşaması &nbsp;<button class="asama_all btn-sm btn btn-info"><i class="fa-solid fa-check-double"></i></th>
                                        <th>Birim &nbsp;<button class="birim_all btn-sm btn btn-info"><i class="fa-solid fa-check-double"></i></th>
                                        <th>Miktar</th>
                                        <th>İşlem &nbsp;<button class="add_all btn-sm btn btn-info"><i class="fa-solid fa-check-double"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`,
                            buttons: {
                                cancel: {
                                    text: 'Çıkış',
                                    btnClass: "btn btn-danger btn-sm",
                                    action: function () {
                                        $('#stoklar_table').DataTable().destroy();
                                        draw_data_stoklar();
                                    }
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $('#fileupload_').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        var img = 'default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img = file.name;
                                        });

                                        $('#image_text').val(img);
                                    },
                                    progressall: function (e, data) {
                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#progress .progress-bar').css(
                                            'width',
                                            progress + '%'
                                        );
                                    }
                                }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                // bind to events
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-check"></i> Stok İşlemini Bitir',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'İşlemleri Tamamla',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-3 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `Stok İşlemini Bitirmek İstediğinizden Emin Misiniz`,
                            buttons: {
                                formSubmit: {
                                    text: 'Güncelle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let data = {
                                            proje_id: $('#proje_id_hidden').val(),
                                            crsf_token: crsf_hash,
                                        }
                                        $.post(baseurl + 'projects/update_stock',data,(response)=>{
                                            let responses = jQuery.parseJSON(response);
                                            if(responses.status==200){
                                                $('#loading-box').addClass('d-none');
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#stoklar_table').DataTable().destroy();
                                                                draw_data_stoklar();
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                            else {
                                                $('#loading-box').addClass('d-none');
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: responses.message,
                                                    buttons: {
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                            }



                                        });
                                    }
                                },
                                cancel: {
                                    text: 'Çıkış',
                                    btnClass: "btn btn-danger btn-sm",
                                    action: function () {
                                        $('#stoklar_table').DataTable().destroy();
                                        draw_data_stoklar();
                                    }
                                }

                            },
                        });
                    }
                },
                {
                    text: '<i class="fa fa-question"></i> Toplu Listeye Ekle / Kaldır',
                    action: function (e, dt, node, config) {
                        let checked_count = $('.one_select_mt_list:checked').length;
                        if (checked_count == 0) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir Ürün Seçilmemiş!',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        } else {

                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Talep Listesi Güncelle',
                                icon: 'fa fa-pen',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-3 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content: 'Talep Listenizi Güncellemek İçin Emin Misiniz?',
                                buttons: {
                                    formSubmit: {
                                        text: 'Evet',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            let stok_id = [];
                                            $('.one_select_mt_list:checked').each((index, item) => {
                                                stok_id.push({
                                                    id: $(item).attr('stok_id')
                                                })
                                            });

                                            let data = {
                                                crsf_token: crsf_hash,
                                                stok_id: stok_id,
                                            }
                                            $.post(baseurl + 'projestoklari/talep_list_create_toplu',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status==200){
                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-check',
                                                        type: 'green',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "small",
                                                        title: 'Başarılı',
                                                        content: responses.message,
                                                        buttons:{
                                                            formSubmit: {
                                                                text: 'Tamam',
                                                                btnClass: 'btn-blue',
                                                                action: function () {
                                                                    $('#stoklar_table').DataTable().destroy();
                                                                    draw_data_stoklar();
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status==410){

                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: responses.message,
                                                        buttons:{
                                                            prev: {
                                                                text: 'Tamam',
                                                                btnClass: "btn btn-link text-dark",
                                                            }
                                                        }
                                                    });
                                                }
                                            })

                                        }
                                    },
                                    cancel:{
                                        text: 'Vazgeç',
                                        btnClass: "btn btn-danger btn-sm",
                                    },
                                },
                                onContentReady: function () {
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })

                                    $('#fileupload_').fileupload({
                                        url: url,
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image_text').val(img);
                                        },
                                        progressall: function (e, data) {
                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                            $('#progress .progress-bar').css(
                                                'width',
                                                progress + '%'
                                            );
                                        }
                                    }).prop('disabled', !$.support.fileInput)
                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });

                        }
                    }
                }
            ]
        })
    }

    function draw_data_stok_takibi() {
        $('#stok_takibi_table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projestoklari/ajax_list_stok_takibi')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
        })
    }



    function draw_data_razilastirma() {
        $('#razilastirma_list').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('razilastirma/ajax_list_projects')?>",
                'type': 'POST',
                'data': {'cid':$('#proje_id_hidden').val(),'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });
    }
    $(document).on('click','.razilastirma_onay',function (){
        let id = $(this).attr('data-object-id');
        $.confirm({
            theme: 'modern',
            icon: 'fa fa-question',
            type: 'orange',
            closeIcon: true,
            title: 'RAZILAŞTIRMA PROTOKOLÜ ONAYA SUN',
            animation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content:'İşlemi Geri Alamazsınız',
            buttons: {
                formSubmit: {
                    text: 'Onay Sistemini Başlat',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            id:id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'razilastirma/onay_start',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#loading-box').addClass('d-none');
                                                $('#razilastirma_list').DataTable().destroy();
                                                draw_data_razilastirma()

                                            }
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                            }
                        });



                    }
                },

            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click','.razilastirma_onay_detay',function (){
        let id = $(this).attr('data-object-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'RAZILAŞTIRMA ONAY DETAYI',
            icon: 'fa fa-eye',
            type: 'orange',
            animation: 'scale',
            columnClass: 'medium',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_rp">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }

                let table_report='';
                $.post(baseurl + 'razilastirma/onay_details_get',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let responses = jQuery.parseJSON(response);

                    table_report =responses.html;
                    $('.table_rp').empty().html(table_report);
                });


                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click','.delete_rezilastirma',function (){
        let id =$(this).attr('razilastirma_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Razılaştırma Sil',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            columnClass: 'small',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content:'İşlemi Geri Alamazsınız',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            id:id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'razilastirma/delete_razilastirma',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#loading-box').addClass('d-none');
                                                $('#razilastirma_list').DataTable().destroy();
                                                draw_data_razilastirma()

                                            }
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                            }
                        });



                    }
                },
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click','.edit_razilastirma',function(){

        let razilastirma_id = $(this).attr('razilastirma_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Razılaştırma Düzenle',
            icon: 'fa fa-pen',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html = `<form id='data_form_iskalemi'>
                    <div class="form-row">
                    <input id='proje_id' name='proje_id' value='`+$('#proje_id_hidden').val()+`' type='hidden'>
                    <input id='razilastirma_id' name='razilastirma_id' type='hidden'>

                    <div class="form-group col-md-3">
                    <label for="name">Cari</label>
                    <select name="cari_id" class="form-control select-box" id="cari_id" name='cari_id'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (all_customer() as $all_cust)
                        {
                            echo "<option value='$all_cust->id'>$all_cust->company</option>";
                        } ?>
                    </select>
            </div>

                <div class="form-group col-md-6">
                    <label for="name">Ödeme Şekli</label>
                    <select class="form-control select-box" id="method_id" name='method_id'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (account_type_islem() as $acc)
                        {
                            echo "<option value='$acc->id'>$acc->name</option>";
                        } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="name">KDV Durumu</label>
                    <input value='no' type='hidden' class='kdv_status' name='kdv_status'>
                    <input type'text' class='form-control' disabled value='KDV HARİÇ'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">KDV Oranı</label>
                    <input type="text" class="form-control tax_oran" id="tax_oran" value="0" name='tax_oran'>
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Muqavele No</label>
                    <input type="text" class="form-control nuqavele_no" id="nuqavele_no" name='nuqavele_no'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Geçerlilik Tarihi</label>
                    <input type="date" class="form-control g_date" id="g_date_edit" name='g_date'>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">Açıklama</label>
                    <input type="text" class="form-control description" id="description_edit" name='description'>
                </div>
                <div class="col-md-12">
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <table id="files" class="files"></table>
                    <br>
                                        <span class="btn btn-success fileinput-button" style="width: 100%">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Protokol İmzalı Dosya...</span>
                                        <input id="fileupload_is" type="file" name="files[]">
                                        <input type="hidden" class="image_text" name="image_text" id="image_text_is_kalemi">
                                        </span>
                </div>
                <hr>
                    <div class='is_razilastirma_table col-md-12'></div>
<table class="table mt-5  is_razilastirma_table_edit" width="100%">
                                    <thead>
                                        <tr>
                                              <th>Görülecek İş</th>
                                                <th>Birim Fiyatı(Kdv Hariç)</th>
                                                <th>Miktarı</th>
                                                 <th>Birim</th>
                                                <th>Toplam Tutar</th>
                                            </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <tfoot>
                                      </tfoot>


                                 </table>
                </div>
            </form>`;

                let data = {
                    id: razilastirma_id,
                }
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#cari_id').val(responses.details.cari_id).trigger("change");
                    $('#method_id').val(responses.details.odeme_sekli).trigger("change");
                    $('#tax_oran').val(responses.details.tax_oran);
                    $('#nuqavele_no').val(responses.details.muqavele_no);
                    $('#g_date_edit').val(responses.details.date);
                    $('#description_edit').val(responses.details.description);
                    $('#image_text_is_kalemi').val(responses.details.file);
                    $('#razilastirma_id').val(responses.details.id);

                    let net_tutar = "<span style='font-weight: bold;'  class='net_tutar'>"+currencyFormat(parseFloat(responses.details.net_tutar))+"</span><input type='hidden' class='net_tutar_total_hidden' value='"+responses.details.net_tutar+"'>";
                    let kdv_tutar = "<span style='font-weight: bold;'  class='kdv_tutar'>"+currencyFormat(parseFloat(responses.details.tax_tutar))+"</span><input type='hidden' class='kdv_tutar_total_hidden' value='"+responses.details.tax_tutar+"'>";
                    let genel_tutar = "<span style='font-weight: bold;'  class='genel_tutar'>"+currencyFormat(parseFloat(responses.details.genel_tutar))+"</span><input type='hidden' class='genel_tutar_total_hidden' value='"+responses.details.genel_tutar+"'>";


                    let table_is='';
                        $.each(responses.item_details, function (q, item) {

                            let item_sub=parseFloat(item.qty)*parseFloat(item.price);
                            let quantity="<input onkeyup='item_hesap("+q+")'  eq='"+q+"' type='number' value='"+item.qty+"' class='form-control qty' name='qty[]'>"
                            let price="<input onkeyup='item_hesap("+q+")' eq='"+q+"' type='number' value='"+item.price+"' class='form-control price' name='price[]'>"
                            let toplam_tutar = "<span class='item_toplam_tutar'>"+currencyFormat(parseFloat(item_sub))+"</span><input type='hidden' class='item_toplam_tutar_hidden' value='"+item_sub+"'>";

                            table_is+=` <tr>
                                            <td>`+item.name+`</td>
                                            <td>`+price+`</td>
                                            <td>`+quantity+`</td>
                                            <td>`+ item.unit_name+`</td>
                                            <td>`+toplam_tutar+`<input type='hidden' class='item_task_id' name='item_task_id[]' value='`+ item.task_id+`'></td>
                                            </tr>`;


                        })


                    $(".is_razilastirma_table_edit>tbody").append(table_is);
                    let table_is_tfoot=`<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Net Tutar</td><input type='hidden' name='net_tutar_db' class='net_tutar_db'>
                        <td>`+net_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">KDV Toplam</td><input type='hidden' name='kdv_tutar_db' class='kdv_tutar_db'>
                        <td>`+kdv_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Genel Toplam</td><input type='hidden' name='genel_tutar_db' class='genel_tutar_db'>
                        <td>`+genel_tutar+`</td>

</tr>`;

                    $(".is_razilastirma_table_edit>tfoot").append(table_is_tfoot);


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();

            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {


                        // Genel Tutar Alanlarının Kontrolü
                        if (
                            !$('.net_tutar_db').val() ||
                            !$('.kdv_tutar_db').val() ||
                            !$('.genel_tutar_db').val()
                        ) {
                            error_log_message('Lütfen tüm hesaplamaların doğru yapıldığından emin olun!');
                            return false; // Fonksiyonu sonlandır
                        }

                        // Price ve Qty Alanlarının Kontrolü
                        let inputs = document.querySelectorAll('.price, .qty');
                        let hasError = false;

                        inputs.forEach((input) => {
                            let value = parseFloat(input.value);

                            // Değer Kontrolü
                            if (!value || value <= 0) {
                                input.style.border = "2px solid red"; // Hatalı alanları vurgula
                                hasError = true;
                            } else {
                                input.style.border = ""; // Hatalı değilse varsayılan stile dön
                            }
                        });

                        if (hasError) {
                            error_log_message('Fiyat  veya Miktar alanları boş, 0 veya geçersiz olamaz!');
                            return false; // Hatalı durumda işlem durduruluyor
                        }

                        // Cari ve Ödeme Şekli Kontrolleri
                        let cari_id = document.getElementById('cari_id').value;
                        let method_id = document.getElementById('method_id').value;

                        if (cari_id === "0") {
                            error_log_message('Lütfen bir Cari Seçiniz');
                            document.getElementById('cari_id').style.border = "2px solid red"; // Hatalı alanı işaretle
                            return false;
                        } else {
                            document.getElementById('cari_id').style.border = ""; // Hata yoksa varsayılan stile dön
                        }

                        if (method_id === "0") {
                            error_log_message('Lütfen bir Ödeme Şekli seçiniz!');
                            document.getElementById('method_id').style.border = "2px solid red"; // Hatalı alanı işaretle
                            return false;
                        } else {
                            document.getElementById('method_id').style.border = ""; // Hata yoksa varsayılan stile dön
                        }

                        // Yükleme Göstergesini Aktif Et
                        $('#loading-box').removeClass('d-none');

                        $.post(baseurl + 'razilastirma/update_razilastirma',$('#data_form_iskalemi').serialize(),(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#razilastirma_list').DataTable().destroy();
                                                draw_data_razilastirma();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
            },
            onContentReady: function () {

                $('#fileupload_is').fileupload({
                    url: '/razilastirma/file_handling',
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_is_kalemi').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click','.razilastirma_forma_2',function(){

        let razilastirma_id = $(this).attr('razilastirma_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Forma 2 Oluştur',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:function (){
                let self = this;
                let html = `<form id='data_form_iskalemi'>
                    <div class="form-row">
                    <input id='proje_id' name='proje_id' value='`+$('#proje_id_hidden').val()+`' type='hidden'>
                    <input id='razilastirma_id' name='razilastirma_id' type='hidden'>


                    <div class="form-group col-md-3">
                    <label for="name">Cari Tipi</label>
                    <select name="invoice_type" class="form-control select-box" id="invoice_type" name='invoice_type'>
                        <option value='0'>Seçiniz</option>
                          <?php foreach (forma2_invoice_type() as $type){
                                    echo "<option value='$type->id'>$type->description</option>";
                        } ?>
                    </select>
            </div>

                    <div class="form-group col-md-6">
                    <label for="name">Cari</label>
                    <select name="cari_id" class="form-control" disabled id="cari_id" name='cari_id'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (all_customer() as $all_cust)
                {
                    echo "<option value='$all_cust->id'>$all_cust->company</option>";
                } ?>
                    </select>
            </div>

               

                <div class="form-group col-md-3">
                    <label for="name">KDV Durumu</label>
                    <select disabled name="kdv_status" class="form-control select-box kdv_status" id="kdv_status" name='kdv_status'>
                        <option value='no'>KDV HARİÇ</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">KDV Oranı</label>
                    <input type="text" class="form-control tax_oran" id="tax_oran" value="0" disabled name='tax_oran'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Fatura Durumu</label>
                    <select class="form-control select-box" id="invoice_durumu" name='invoice_durumu'>
                        <option value='0'>Seçiniz</option>
                        <?php foreach (invoice_durumu_forma2() as $acc)
                {
                    echo "<option value='$acc->id'>$acc->name</option>";
                } ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="name">Muqavele No</label>
                    <input type="text" class="form-control nuqavele_no" disabled id="nuqavele_no" name='nuqavele_no'>
                </div>
                <div class="form-group col-md-3">
                    <label for="name">Forma 2 Tarihi</label>
                    <input type="date" class="form-control fis_date" id="fis_date" name='fis_date'>
                </div>
                <div class="form-group col-md-12">
                    <label for="name">Açıklama</label>
                    <input type="text" class="form-control fis_note" id="fis_note" name='fis_note'>
                </div>
                
                <hr>
                    <div class='is_razilastirma_table col-md-12'></div>
<table class="table mt-5  is_razilastirma_table_edit" width="100%">
                                    <thead>
                                        <tr>
                                              <th>Görülecek İş</th>
                                              <th>Açıklama</th>
                                                <th>Birim Fiyatı(Kdv Hariç)</th>
                                                <th>Miktarı</th>
                                                 <th>Birim</th>
                                                <th>Toplam Tutar</th>
                                                <th>İşlem</th>
                                            </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <tfoot>
                                      </tfoot>


                                 </table>
                </div>
            </form>`;

                let data = {
                    id: razilastirma_id,
                }
                $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#cari_id').val(responses.details.cari_id).trigger("change");
                    $('#method_id').val(responses.details.odeme_sekli).trigger("change");
                    $('#tax_oran').val(responses.details.tax_oran);
                    $('#nuqavele_no').val(responses.details.muqavele_no);
                    $('#g_date_edit').val(responses.details.date);
                    $('#description_edit').val(responses.details.description);
                    $('#image_text_is_kalemi').val(responses.details.file);
                    $('#razilastirma_id').val(responses.details.id);

                    let net_tutar = "<span style='font-weight: bold;'  class='net_tutar'>"+currencyFormat(parseFloat(responses.details.net_tutar))+"</span><input type='hidden' class='net_tutar_total_hidden' value='"+responses.details.net_tutar+"'>";
                    let kdv_tutar = "<span style='font-weight: bold;'  class='kdv_tutar'>"+currencyFormat(parseFloat(responses.details.tax_tutar))+"</span><input type='hidden' class='kdv_tutar_total_hidden' value='"+responses.details.tax_tutar+"'>";
                    let genel_tutar = "<span style='font-weight: bold;'  class='genel_tutar'>"+currencyFormat(parseFloat(responses.details.genel_tutar))+"</span><input type='hidden' class='genel_tutar_total_hidden' value='"+responses.details.genel_tutar+"'>";


                    let table_is='';
                    $.each(responses.item_details, function (q, item) {

                        let item_sub=parseFloat(item.qty)*parseFloat(item.price);
                        let quantity="<input onkeyup='item_hesap("+q+")'  eq='"+q+"' type='number' value='"+item.qty+"' class='form-control qty' name='qty[]'>"
                        let price="<input onkeyup='item_hesap("+q+")' eq='"+q+"' type='number' value='"+item.price+"' class='form-control price' name='price[]'>"
                        let toplam_tutar = "<span class='item_toplam_tutar'>"+currencyFormat(parseFloat(item_sub))+"</span><input type='hidden' class='item_toplam_tutar_hidden' value='"+item_sub+"'>";

                        table_is+=` <tr class='tr_clone_`+q+`'>
                                            <td>`+item.name+`</td>
                                            <td><input type='text' class='form-control' name='item_desc[]'></td>
                                            <td>`+price+`</td>
                                            <td>`+quantity+`</td>
                                            <td>`+ item.unit_name+`</td>
                                            <td>`+toplam_tutar+`<input type='hidden' class='item_task_id' name='item_task_id[]' value='`+ item.task_id+`'></td>
   <td>
<button type="button" class="btn btn-danger delete_item_razi"><i class="fa fa-trash"></i></button>
 <button type="button" class="btn btn-info clone" clone_name="tr_clone_`+q+`"><i class="fa fa-plus"></i></button>
</td>
</tr>`;


                    })


                    $(".is_razilastirma_table_edit>tbody").append(table_is);
                    let table_is_tfoot=`<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Net Tutar</td><input type='hidden' name='net_tutar_db' class='net_tutar_db'>
                        <td>`+net_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">KDV Toplam</td><input type='hidden' name='kdv_tutar_db' class='kdv_tutar_db'>
                        <td>`+kdv_tutar+`</td>
</tr>
<tr>
                        <td colspan="4" style="text-align: end;font-weight: bold;">Genel Toplam</td><input type='hidden' name='genel_tutar_db' class='genel_tutar_db'>
                        <td>`+genel_tutar+`</td>

</tr>`;

                    $(".is_razilastirma_table_edit>tfoot").append(table_is_tfoot);


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();

            },

            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {


                        let invoice_type = $('#invoice_type').val();

                        if(parseInt(invoice_type) == 0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Cari Tipi Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }


                        $('#loading-box').removeClass('d-none');

                        $.post(baseurl + 'formainvoices/create_new',$('#data_form_iskalemi').serialize(),(response)=>{
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Forma 2 Görüntüle',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.href = '/formainvoices/view?id='+responses.id;
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
            },
            onContentReady: function () {
                item_hesap(0);
                $('#fileupload_is').fileupload({
                    url: '/razilastirma/file_handling',
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text_is_kalemi').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })

    function draw_data_depo_takibi() {
        $('#warehouse_table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projestoklari/ajax_list_depo_takibi')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
        })
    }

    $(document).on('click','#search_button',function (){
        let keyword = $('#search_name').val();
        let category_id = parseInt($('#category_id').val());
        let tip = $(this).attr('tip');

        if(category_id==0){
            if(keyword.length < 3){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'En az 3 Karakter Yazmalısınız veya Bir Kategori Seçmelisiniz',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }
            else {
                $('#loading-box').removeClass('d-none');
                let cat_id = parseInt($('#category_id').val());
                let data = {
                    cat_id:cat_id,
                    keyword:keyword,
                    crsf_token: crsf_hash,
                }
                $.post(baseurl + 'malzemetalep/search_products_proje',data,(response)=>{
                    let responses = jQuery.parseJSON(response);
                    if(responses.status=='Success'){
                        $('#loading-box').addClass('d-none');
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Başarılı',
                            content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                            buttons:{
                                formSubmit: {
                                    text: 'Tamam',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let units = '<select class="form-control select-box unit_id">';
                                        responses.units.forEach((item,index) => {
                                            units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                        })
                                        units+='</select>';
                                        let table = '';
                                        responses.products.forEach((item,index) => {
                                            let no = parseInt(index)+parseInt(1);
                                            table+=`<tr>
                                                    <td>`+no+`</td>
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_name+`"></td>
                                                    <td><input type="text" class="product_price form-control"></td>

                                                    <td><select index='`+index+`' class="form-control bolum_id_product select-box">
                                                    <option value=''>Seçiniz</option>
                                                          <?php foreach ($bolumler as $blm)
                                            {
                                                $id=$blm['id'];
                                                $name=$blm['name'];
                                                echo "<option value='$id'>$name</option>";
                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td><select class="form-control asama_id_product select-box"></select></td>
                                                    <td>`+units+`</td>
                                                    <td><input class="product_qty form-control" value="1"></td>
                                                    <td><button eq='`+index+`' tip='`+tip+`' class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                <tr>`;
                                        })
                                        $('.table_products tbody').empty().html(table);


                                        setTimeout(function(){
                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm")
                                            })
                                        }, 1000);



                                    }
                                }
                            }
                        });
                    }
                    else {
                        $('#loading-box').addClass('d-none');
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: 'Kriterlere Uygun Ürün Bulunamadı!',
                            buttons:{
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                    }



                });

            }
        }
        else {
            $('#loading-box').removeClass('d-none');
            let cat_id = parseInt($('#category_id').val())
            let data = {
                cat_id:cat_id,
                keyword:keyword,
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'malzemetalep/search_products_proje',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Ürün Bulundu!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue',
                                action: function () {
                                    let units = '<select class="form-control select-box unit_id">';
                                    responses.units.forEach((item,index) => {
                                        units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                                    })
                                    units+='</select>';
                                    let table = '';
                                    responses.products.forEach((item,index) => {
                                        let no = parseInt(index)+parseInt(1);
                                        table+=`<tr>
                                                    <td>`+no+`</td>
                                                    <td><input type="hidden" class="product_id" value="`+item.product_id+`">`+item.product_name+`</td>
                                                    <td><input type="text" class="product_desc form-control" value="`+item.product_name+`"></td>
                                                    <td><input type="text" class="product_price form-control"></td>

                                                    <td><select index='`+index+`' class="form-control bolum_id_product select-box">
                                                    <option value=''>Seçiniz</option>
                                                          <?php foreach ($bolumler as $blm)
                                        {
                                            $id=$blm['id'];
                                            $name=$blm['name'];
                                            echo "<option value='$id'>$name</option>";
                                        } ?>
                                                        </select>
                                                    </td>
                                                    <td><select class="form-control asama_id_product select-box"></select></td>
                                                    <td>`+units+`</td>
                                                    <td><input class="product_qty form-control" value="1"></td>
                                                    <td><button eq='`+index+`' tip='`+tip+`' class="btn btn-success btn-sm form_add_products"><i class='fa fa-plus'></i></button></td>
                                                <tr>`;
                                    })
                                    $('.table_products tbody').empty().html(table);

                                    setTimeout(function(){
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    }, 1000);



                                }
                            }
                        }
                    });
                }
                else {
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Kriterlere Uygun Ürün Bulunamadı!',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }



            });

        }
    })

    let mt_index=0;
    $(document).on('click','.form_add_products',function (){
        mt_index++;
        let eq = $(this).attr('eq');
        let tip = $(this).attr('tip');
        let varyasyon_durum=false;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Varyasyonlar',
            icon: 'fa fa-filter',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    product_id: $('.product_id').eq(eq).val(),
                }

                let table_report='';
                $.post(baseurl + 'malzemetalep/get_product_to_value',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.list').empty().html(responses.html)
                    if(responses.code==200){
                        varyasyon_durum=true;
                    }
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let option_details=[];
                        if(varyasyon_durum){
                            $('.option-value:checked').each((index,item) => {
                                // option_details.push({
                                //     'option_id':$(item).attr('data-option-id'),
                                //     'option_name':$(item).attr('data-option-name'),
                                //     'option_value_id':$(item).attr('data-value-id'),
                                //     'option_value_name':$(item).attr('data-option-value-name'),
                                // })

                                option_details.push({
                                    'stock_code_id':$(item).attr('stock_code_id'),
                                })
                            });
                        }
                        else {
                        }


                        let data = {
                            product_id:$('.product_id').eq(eq).val(),
                            option_details:option_details,
                            product_desc:$('.product_desc').eq(eq).val(),
                            product_price:$('.product_price').eq(eq).val(),
                            bolum_id_product:$('.bolum_id_product').eq(eq).val(),
                            asama_id_product:$('.asama_id_product').eq(eq).val(),
                            unit_id:$('.unit_id').eq(eq).val(),
                            product_qty:$('.product_qty').eq(eq).val(),
                            proje_id:$('#proje_id_hidden').val(),
                            tip:tip,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'projestoklari/create',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $.each(responses.array_items, function (index, items) {
                                                    let table=`<tr  id="remove`+items.item_id+`" >
                                                    <td>`+mt_index+`</td>
                                                    <td><p>`+items.product_name+`</p><span style="font-size: 12px;">`+items.option_html+`</span></td>
                                                    <td>`+items.qyt_birim+`</td>
                                                    <td><button stok_id='`+items.item_id+`' type_="2" class="btn btn-danger btn-sm delete-stok" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                                                    $('.table_create_products tbody').append(table);
                                                    mt_index++;
                                                })

                                                setTimeout(function(){
                                                    $('.select-box').select2({
                                                        dropdownParent: $(".jconfirm")
                                                    })
                                                }, 1000);
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

                        });
                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {
                setTimeout(function(){
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm")
                    })
                }, 1000);
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })



    function draw_data_asamalar(){
        $('#asamalar').DataTable({

            "processing": true,
            "serverSide": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style',data[10]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projeasamalari/ajax_list')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>,'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Aşama Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Aşama Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: true,
                            smoothContent: true,
                            draggable: false,
                            content: function () {
                                return `<form>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="bolum_id">Proje Bölümleri</label>
                        <select class="form-control select-box" id="bolum_id" name="bolum">
                            <option value="">Seçiniz</option>
                            <?php foreach ($bolumler as $blm): ?>
                                <option value="<?= $blm['id'] ?>"><?= $blm['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="parent_id">Bağlı Olduğu Aşama</label>
                        <select class="form-control select-box" id="parent_id" name="parent_id">
                            <option value="">Seçiniz</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Aşama Adı</label>
                        <input type="text" class="form-control" id="name" placeholder="Elektrik İşleri" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_statement">Cari</label>
                        <select class="form-control select-box" id="customer_statement">
                            <option value="">Seçiniz</option>
                            <?php foreach (all_customer() as $blm): ?>
                                <option value="<?= $blm->id ?>"><?= $blm->company ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pers_id">Sorumlu Personel</label>
                        <select class="form-control select-box" id="pers_id">
                            <option value="">Seçiniz</option>
                            <?php foreach (all_personel() as $blm): ?>
                                <option value="<?= $blm->id ?>"><?= $blm->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="olcu_birimi">Ölçü Birimi</label>
                        <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi">
                            <option value="">Seçiniz</option>
                            <?php foreach (units() as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?> - <?= $row['code'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="quantity">Miktar</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="1" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fiyat">Birim Fiyatı</label>
                        <input type="number" class="form-control" name="fiyat" id="fiyat" value="1" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="toplam_fiyat">Toplam Fiyat</label>
                        <input type="number" class="form-control" name="toplam_fiyat" id="toplam_fiyat" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="butce">Bütçe</label>
                        <input type="number" id="butce" name="butce" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="content">Açıklama</label>
                        <input type="text" class="form-control" name="content" id="content" required>
                    </div>
                </div>
            </form>`;
                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {


                                        let data = {
                                            crsf_token: crsf_hash,
                                            name: $('#name').val(),
                                            customer: $('#customer_statement').val(),
                                            content: $('#content').val(),
                                            bolum: $('#bolum_id').val(),
                                            parent_id: $('#parent_id').val(),
                                            pers_id: $('#pers_id').val(),
                                            butce: $('#butce').val(),
                                            olcu_birimi: $('#olcu_birimi').val(),
                                            quantity: $('#quantity').val(),
                                            fiyat: $('#fiyat').val(),
                                            toplam_fiyat: $('#toplam_fiyat').val(),
                                            project: "<?php echo $_GET['id'] ?>"
                                        };

                                        if (!data.name || !data.bolum || !data.butce || !data.pers_id || !data.olcu_birimi || !data.customer) {
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                title: 'Eksik Bilgi!',
                                                content: 'Lütfen gerekli tüm alanları doldurunuz.',
                                            });
                                            return false;
                                        }
                                        $('#loading-box').removeClass('d-none');
                                        $.post(baseurl + 'projeasamalari/create', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status === 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#asamalar').DataTable().destroy();
                                                                draw_data_asamalar();
                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    title: 'Hata!',
                                                    content: responses.message,
                                                });
                                            }
                                        });
                                    }
                                }
                            },
                            onContentReady: function () {
                                $('#bolum_id').select2();
                                $('#customer_statement').select2({
                                    minimumInputLength: 1,
                                    dropdownParent: $(".jconfirm-box-container"),
                                    ajax: {
                                        url: baseurl + 'search/customer_select',
                                        dataType: 'json',
                                        type: 'POST',
                                        data: (customer) => ({
                                            customer,
                                            '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                                        }),
                                        processResults: (data) => ({
                                            results: $.map(data, (item) => ({
                                                text: item.company,
                                                id: item.id
                                            }))
                                        }),
                                    }
                                });

                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
                            }
                        });
                    }

                }
            ]

        });
    }

    function draw_data_iskalemleri(){
        $('#todotable').DataTable({
            "processing": true,
            "serverSide": true,
            // 'createdRow': function (row, data, dataIndex) {
            //     $(row).attr('data-block', '0');
            //     $(row).attr('style',data[13]);
            // },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projeiskalemleri/ajax_list')?>",
                "type": "POST",
                data: {'pid':<?php echo $project['id']; ?>,'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni İşkalemi Ekle',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni İşkalemi Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form id='data_form_iskalemi'>
                                      <div class="form-row">

                                         <div class="form-group col-md-12">
                                            <label for="name">Proje Bölümleri</label>
                                              <select name="bolum_id" class="form-control select-box bolum_id required" id="bolum_id" name='bolum_id'>
                                              <option value=''>Seçiniz</option>
                                                   <?php foreach(all_bolum_proje($_GET['id']) as $items){
                                echo "<option value='$items->id'>$items->name</option>";
                            } ?>
                                                </select>
                                                 </div>

                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Aşamalar</label>
                                              <select class="form-control select-box asama_new_id required" id="milestone_id" name='group_id[]'>
                                               <option value=''>Seçiniz</option>
                                                </select>
                                                 </div>
                                                     <div class="form-group col-md-12 one_group">
                                          <label for="name">Proje Alt Aşamalar</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id[]">
                                            <option value='0'>Aşama Seçiniz</option>
                                        </select>
                                        </div>
                                               <div class="form-group col-md-12">
                                            <label for="name">İş Kalemi Adı</label>
                                             <input type="text" class="form-control required" id="name_is" name='name_is' placeholder="Elektrik İşlerinin Görülmesi">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                          <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box required" id="pers_id_is" name='pers_id_is'>
                                                                                             <option value=''>Seçiniz</option>

                                                    <?php foreach (all_personel() as $blm)
                            {
                                $id=$blm->id;
                                $name=$blm->name;
                                echo "<option value='$id'>$name</option>";
                            } ?>
                                                </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Cari</label>
                                               <select name="customer_statement_is" class="form-control required" id="customer_statement_is">
                                                                                                  <option value=''>Seçiniz</option>


                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi_is" class="form-control select-box required" id="olcu_birimi_is">
                                                                                         <option value=''>Seçiniz</option>

                                                    <?php
                            foreach (units() as $row) {
                                $id = $row['id'];
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$id'>$title - $cid</option>";
                            }
                            ?>
                                                </select>

                                        </div>


                                    </div>

                                       <div class="form-row">
                                         <div class="form-group col-md-3">
                                          <label for="name">Miktar</label>
                                           <input type="number" class="form-control required" name="quantity_is" id="quantity_is" value="0">
                                        </div>
                                          <div class="form-group col-md-3">
                                          <label for="name">Birim Fiyatı</label>
                                            <input type="text" class="form-control" name="fiyat_is" id="fiyat_is" value="1">
                                        </div>
                                         <div class="form-group col-md-3">
                                          <label for="name">Toplam Fiyatı</label>
                                             <input type="text" class="form-control" name="toplam_fiyat_is" id="toplam_fiyat_is">
                                        </div>
                                        <div class="form-group col-md-3">
                                          <label for="name">Oran (%)</label>
                                            <input type="text" class="form-control" id="oran_is" value="100" name='oran_is'>
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Durum</label>
                                           <select name="status" class="form-control" id="status_is" name='status_is'>
                                                    <?php foreach ($task_status as $tsk)
                                                    { $id=$tsk['id'];
                                                    $name=$tsk['name'];
                                                    ?>
                                                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                          <div class="form-group col-md-6">
                                          <label for="name">Açıklama</label>
                                            <input type="text" class="form-control required" name="content_is" id="content_is">
                                            <input type="hidden" class="form-control " name="project" value="<?php echo $_GET['id'] ?>">
                                        </div>

                                      </div>
                                    </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {


                                        let valid = true;

// Gerekli alanları kontrol et
                                        $('#data_form_iskalemi .required').each(function () {
                                            let element = $(this);

                                            if (element.is('select')) {
                                                // Select2 öğesi için özel kontrol
                                                if (!element.val() || element.val() === "") {
                                                    element.next('.select2').find('.select2-selection').addClass('is-invalid-select2');
                                                    valid = false;
                                                } else {
                                                    element.next('.select2').find('.select2-selection').removeClass('is-invalid-select2');
                                                }
                                            }

                                            else {
                                                // Diğer inputlar için kontrol
                                                if (!element.val()) {
                                                    element.addClass('is-invalid');
                                                    valid = false;
                                                } else {
                                                    element.removeClass('is-invalid');
                                                }
                                            }
                                        });

                                        // Eğer valid değilse uyarı göster ve işlemi durdur
                                        if (!valid) {
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                title: 'Hata',
                                                content: 'Lütfen tüm alanları doldurun!',
                                            });
                                            return false;
                                        }

                                        $('#loading-box').removeClass('d-none');
                                            $.post(baseurl + 'projeiskalemleri/create',$('#data_form_iskalemi').serialize(),(response)=>{
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if(responses.status==200){
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons:{
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#todotable').DataTable().destroy();
                                                                draw_data_iskalemleri();
                                                            }
                                                        }
                                                    }
                                                });

                                            }
                                            else if(responses.status==410){

                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: responses.message,
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                            }
                                        })

                                    }
                                },
                            },
                            onContentReady: function () {


                                $("#customer_statement_is").select2({
                                    minimumInputLength: 1,
                                    dropdownParent: $(".jconfirm-box-container"),
                                   tags: false,
                                    ajax: {
                                        url: baseurl + 'search/customer_select',
                                        dataType: 'json',
                                        type: 'POST',
                                        quietMillis: 50,
                                        data: function (customer) {
                                            return {
                                                customer: customer,
                                                '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                                            };
                                        },
                                        processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    return {
                                                        text: item.company,
                                                        id: item.id
                                                    }
                                                })
                                            };
                                        },
                                    }
                                });

                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i> Razılaştırma OLuştur',
                    action: function ( e, dt, node, config ) {


                        let proje_id =$('#proje_id_hidden').val();;
                        let item_details_is_kalemleri = [];
                        let checked_count = $('.on_checked_is_kalemleri:checked').length;
                        if(checked_count){

                            let table=`<table class='table'>
                                    <thed>
                                        <tr>
                                            <th>Görülecek İş</th>
                                            <th>Miktarı</th>
                                            <th>Birim Fiyatı(Kdv Hariç)</th>
                                            <th>Birim</th>
                                        </tr>
                                    </thed>
`;

                            $('.on_checked_is_kalemleri:checked').each((index,item) => {
                                item_details_is_kalemleri.push({
                                    task_id: $(item).attr('task_id'),
                                    qty: $(item).attr('qty'),
                                    asama_name: $(item).attr('asama_name'),
                                    unit_id: $(item).attr('unit_id'),
                                    unit_name: $(item).attr('unit_name'),
                                    name_is: $(item).attr('name_is'),
                                    price: $(item).attr('price'),
                                })
                            });


                            localStorage.setItem('is_kalemleri_serial',JSON.stringify(item_details_is_kalemleri));

                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Razılaştırma',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-12 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form id='data_form_iskalemi'>
                                      <div class="form-row">
                                      <input id='proje_id' name='proje_id' value='`+proje_id+`' type='hidden'>

                                      <div class="form-group col-md-3">
                                            <label for="name">Cari</label>
                                              <select name="cari_id" class="form-control select-box" id="cari_id" name='cari_id'>
                                              <option value='0'>Seçiniz</option>
                                                      <?php foreach (all_customer() as $all_cust)
                                {
                                    echo "<option value='$all_cust->id'>$all_cust->company</option>";
                                } ?>
                                                </select>
                                         </div>

                                         <div class="form-group col-md-6">
                                            <label for="name">Ödeme Şekli</label>
                                              <select class="form-control select-box" id="method_id" name='method_id'>
                                              <option value='0'>Seçiniz</option>
                                                      <?php foreach (account_type_islem() as $acc)
                                                        {
                                                            echo "<option value='$acc->id'>$acc->name</option>";
                                                        } ?>
                                                </select>
                                         </div>

                                        <div class="form-group col-md-3">
                                            <label for="name">KDV Durumu</label>
                                            <input type='hidden' class='kdv_status' name='kdv_status' value='no'>
                                             <input type='text' disabled class='form-control' value='KDV HARİÇ'>
                                         </div>
                                              <div class="form-group col-md-3">
                                            <label for="name">KDV Oranı</label>
                                               <input type="text" class="form-control tax_oran" id="tax_oran" value="0" name='tax_oran'>
                                             </div>
                                       <div class="form-group col-md-6">
                                            <label for="name">Muqavele No</label>
                                             <input type="text" class="form-control nuqavele_no" id="nuqavele_no" name='nuqavele_no'>
                                        </div>
                                             <div class="form-group col-md-3">
                                            <label for="name">Geçerlilik Tarihi</label>
                                             <input type="date" class="form-control g_date" id="g_date" name='g_date'>
                                        </div>
                                         <div class="form-group col-md-12">
                                            <label for="name">Açıklama</label>
                                             <input type="text" class="form-control description" id="description" name='description'>
                                        </div>
                                         <div class="col-md-12">
                                    <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                        </div>
                            <table id="files" class="files"></table>
                            <br>
                                        <span class="btn btn-success fileinput-button" style="width: 100%">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Protokol İmzalı Dosya...</span>
                                        <input id="fileupload_is" type="file" name="files[]">
                                        <input type="hidden" class="image_text" name="image_text" id="image_text_is_kalemi">
                                        </span>
                                </div>
                                <hr>
                                <div class='is_razilastirma_table col-md-12'></div>

                                    </div>
                                    </form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Ekle',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            // Genel Tutar Alanlarının Kontrolü
                                            if (
                                                !$('.net_tutar_db').val() ||
                                                !$('.kdv_tutar_db').val() ||
                                                !$('.genel_tutar_db').val()
                                            ) {
                                                error_log_message('Lütfen tüm hesaplamaların doğru yapıldığından emin olun!');
                                                return false; // Fonksiyonu sonlandır
                                            }

                                            // Price ve Qty Alanlarının Kontrolü
                                            let inputs = document.querySelectorAll('.price, .qty');
                                            let hasError = false;

                                            inputs.forEach((input) => {
                                                let value = parseFloat(input.value);

                                                // Değer Kontrolü
                                                if (!value || value <= 0) {
                                                    input.style.border = "2px solid red"; // Hatalı alanları vurgula
                                                    hasError = true;
                                                } else {
                                                    input.style.border = ""; // Hatalı değilse varsayılan stile dön
                                                }
                                            });

                                            if (hasError) {
                                                error_log_message('Fiyat  veya Miktar alanları boş, 0 veya geçersiz olamaz!');
                                                return false; // Hatalı durumda işlem durduruluyor
                                            }

                                            // Cari ve Ödeme Şekli Kontrolleri
                                            let cari_id = document.getElementById('cari_id').value;
                                            let method_id = document.getElementById('method_id').value;

                                            if (cari_id === "0") {
                                                error_log_message('Lütfen bir Cari Seçiniz');
                                                document.getElementById('cari_id').style.border = "2px solid red"; // Hatalı alanı işaretle
                                                return false;
                                            } else {
                                                document.getElementById('cari_id').style.border = ""; // Hata yoksa varsayılan stile dön
                                            }

                                            if (method_id === "0") {
                                                error_log_message('Lütfen bir Ödeme Şekli seçiniz!');
                                                document.getElementById('method_id').style.border = "2px solid red"; // Hatalı alanı işaretle
                                                return false;
                                            } else {
                                                document.getElementById('method_id').style.border = ""; // Hata yoksa varsayılan stile dön
                                            }

                                            // Yükleme Göstergesini Aktif Et
                                            $('#loading-box').removeClass('d-none');

                                            // Form Verilerini Gönder
                                            $.post(baseurl + 'razilastirma/save_razilastirma', $('#data_form_iskalemi').serialize(), (response) => {
                                                let responses = jQuery.parseJSON(response);

                                                // Yükleme Göstergesini Kaldır

                                                // Başarılı Durum
                                                if (responses.status === 200) {
                                                    $('#loading-box').addClass('d-none');

                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-check',
                                                        type: 'green',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "small",
                                                        title: 'Başarılı',
                                                        content: responses.message,
                                                        buttons: {
                                                            formSubmit: {
                                                                text: 'Tamam',
                                                                btnClass: 'btn-blue',
                                                                action: function () {
                                                                    $('#todotable').DataTable().destroy();
                                                                    draw_data_iskalemleri(); // Tabloyu yeniden çiz
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                                // Hata Durumu
                                                else if (responses.status === 410) {
                                                    $('#loading-box').addClass('d-none');

                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: responses.message,
                                                        buttons: {
                                                            prev: {
                                                                text: 'Tamam',
                                                                btnClass: "btn btn-link text-dark",
                                                            }
                                                        }
                                                    });
                                                }
                                            });
                                        }

                                    },
                                },
                                onContentReady: function () {



                                    let table_is = ` <table class='table mt-5 ' width="100%">
                                    <thed>
                                        <tr>
                                          <th>Görülecek İş</th>
                                            <th>Aşama</th>
                                            <th>Birim Fiyatı(Kdv Hariç)</th>
                                            <th>Miktarı</th>
                                             <th>Birim</th>
                                            <th>Toplam Tutar</th>
                                        </tr>
                                    </thed>
                                `;



                                    let _serials_new = localStorage.getItem('is_kalemleri_serial');

                                    let net_tutar = "<span style='font-weight: bold;'  class='net_tutar'>0.0 AZN</span><input type='hidden' class='net_tutar_total_hidden' value='0'>";
                                    let kdv_tutar = "<span style='font-weight: bold;'  class='kdv_tutar'>0.0 AZN</span><input type='hidden' class='kdv_tutar_total_hidden' value='0'>";
                                    let genel_tutar = "<span style='font-weight: bold;'  class='genel_tutar'>0.0 AZN</span><input type='hidden' class='genel_tutar_total_hidden' value='0'>";

                                    _serials_new = JSON.parse(_serials_new);
                                    if(_serials_new){
                                        for(let q=0; q<_serials_new.length;q++){

                                            let quantity="<input onkeyup='item_hesap("+q+")'  eq='"+q+"' type='number' value='"+ _serials_new[q].qty+"' class='form-control qty' name='qty[]'>"
                                            let price="<input onkeyup='item_hesap("+q+")' eq='"+q+"' type='number' value='"+ _serials_new[q].price+"' class='form-control price' name='price[]'>"
                                            let toplam_tutar = "<span class='item_toplam_tutar'></span><input type='hidden' class='item_toplam_tutar_hidden' value='0'>";



                                            table_is+=` <tr>
                                            <td>`+_serials_new[q].name_is+`</td>
                                            <td>`+_serials_new[q].asama_name+`</td>
                                            <td>`+price+`</td>
                                            <td>`+quantity+`</td>
                                            <td>`+ _serials_new[q].unit_name+`</td>
                                            <td>`+toplam_tutar+`<input type='hidden' class='item_task_id' name='item_task_id[]' value='`+ _serials_new[q].task_id+`'></td>
                                            </tr>`;

                                        }
                                    }





                                    table_is+=`</tbody><tfoot><tr>
                        <td colspan="5" style="text-align: end;font-weight: bold;">Net Tutar</td><input type='hidden' name='net_tutar_db' class='net_tutar_db'>
                        <td>`+net_tutar+`</td>
</tr>
<tr>
                        <td colspan="5" style="text-align: end;font-weight: bold;">KDV Toplam</td><input type='hidden' name='kdv_tutar_db' class='kdv_tutar_db'>
                        <td>`+kdv_tutar+`</td>
</tr>
<tr>
                        <td colspan="5" style="text-align: end;font-weight: bold;">Genel Toplam</td><input type='hidden' name='genel_tutar_db' class='genel_tutar_db'>
                        <td>`+genel_tutar+`</td>

</tr></tfoot></table>`;
                                    $('.is_razilastirma_table').empty().html(table_is);

                                    item_hesap(0);

                                    $('#fileupload_is').fileupload({
                                        url: '/razilastirma/file_handling',
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image_text_is_kalemi').val(img);
                                        },
                                        progressall: function (e, data) {
                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                            $('#progress .progress-bar').css(
                                                'width',
                                                progress + '%'
                                            );
                                        }
                                    }).prop('disabled', !$.support.fileInput)
                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');

                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });
                        }
                        else {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir İş Kalemi Seçilmemiş!',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                        }


                    }
                }
            ]

        });
    }


    function item_hesap(t) {
        // Toplam ürün sayısını al
        let itemCount = $('.qty').length;

        // Toplamlar için başlangıç değerleri
        let net_tutar = 0;
        let kdv_tutar = 0;
        let genel_tutar = 0;

        // Vergi oranını al ve float'a çevir
        let tax_oran = parseFloat($('#tax_oran').val()) || 0;

        // Her bir ürünü hesapla
        for (let i = 0; i < itemCount; i++) {
            // Miktar ve fiyatı al
            let item_qty = parseFloat($('.qty').eq(i).val()) || 0;
            let item_price = parseFloat($('.price').eq(i).val()) || 0;

            // Toplam tutar hesapla
            let toplam_tutar = item_price * item_qty;

            // DOM güncellemesi
            $('.item_toplam_tutar').eq(i).text(currencyFormat(toplam_tutar));
            $('.item_toplam_tutar_hidden').eq(i).val(toplam_tutar);

            // Net toplamı güncelle
            net_tutar += toplam_tutar;
        }

        // Vergi tutarını ve genel toplamı hesapla
        if (tax_oran > 0) {
            kdv_tutar = net_tutar * (tax_oran / 100);
            genel_tutar = net_tutar + kdv_tutar;
        } else {
            genel_tutar = net_tutar;
        }

        // Genel toplam, vergi ve net toplamı DOM'a yaz
        $('.net_tutar').text(currencyFormat(net_tutar));
        $('.kdv_tutar').text(currencyFormat(kdv_tutar));
        $('.genel_tutar').text(currencyFormat(genel_tutar));

        // Gizli alanlara verileri yaz
        $('.net_tutar_db').val(net_tutar);
        $('.kdv_tutar_db').val(kdv_tutar);
        $('.genel_tutar_db').val(genel_tutar);
    }

    function item_hesap_(t){
        let say = $('.qty').length;
        let item_price=0;
        let toplam_tutar=0;
        let net_tutar=0;
        let kdv_tutar=0;
        let genel_tutar=0;
        let tax_oran = $('#tax_oran').val();

        for(let eq=0;eq<say;eq++){
            let item_qty= $('.qty').eq(eq).val();
            let item_price= $('.price').eq(eq).val();
            let toplam_tutar = parseFloat(item_price) *parseFloat(item_qty);
            $('.item_toplam_tutar').eq(eq).empty().text(currencyFormat(toplam_tutar))
            $('.item_toplam_tutar_hidden').eq(eq).val(toplam_tutar)






            net_tutar+=parseFloat($('.item_toplam_tutar_hidden').eq(eq).val());


        }

        if(parseInt(tax_oran)){
            genel_tutar= net_tutar* (1+(tax_oran/100));
            kdv_tutar= net_tutar * ((tax_oran/100));
        }
        else {
            genel_tutar=net_tutar;
        }

        $('.net_tutar').empty().text(currencyFormat(net_tutar))
        $('.kdv_tutar').empty().text(currencyFormat(kdv_tutar))
        $('.genel_tutar').empty().text(currencyFormat(genel_tutar))
        $('.net_tutar_db').val(net_tutar);
        $('.kdv_tutar_db').val(kdv_tutar);
        $('.genel_tutar_db').val(genel_tutar);


    }
    // function item_hesap(eq){
    //     let item_qty= $('.qty').eq(eq).val();
    //     let item_price= $('.price').eq(eq).val();
    //     let toplam_tutar = parseFloat(item_price) *parseFloat(item_qty);
    //     $('.item_toplam_tutar').eq(eq).empty().text(currencyFormat(toplam_tutar))
    //     $('.item_toplam_tutar_hidden').eq(eq).val(toplam_tutar)
    //
    //
    //     let say = $('.item_toplam_tutar_hidden').length;
    //     let net_tutar=0;
    //     let kdv_tutar=0;
    //     let genel_tutar=0;
    //     let tax_oran = $('#tax_oran').val();
    //     for(let i=0; i<say; i++){
    //         net_tutar+=parseFloat($('.item_toplam_tutar_hidden').eq(i).val());
    //     }
    //
    //     if(parseInt(tax_oran)){
    //         genel_tutar= net_tutar* (1+(tax_oran/100));
    //         kdv_tutar= net_tutar * ((tax_oran/100));
    //     }
    //     else {
    //         genel_tutar=net_tutar;
    //     }
    //     $('.net_tutar').empty().text(currencyFormat(net_tutar))
    //     $('.kdv_tutar').empty().text(currencyFormat(kdv_tutar))
    //     $('.genel_tutar').empty().text(currencyFormat(genel_tutar))
    //     $('.net_tutar_db').val(net_tutar);
    //     $('.kdv_tutar_db').val(kdv_tutar);
    //     $('.genel_tutar_db').val(genel_tutar);
    //
    //
    // }


    $(document).on('keyup','#tax_oran',function(){
        item_hesap(0);
    })
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('click','.clone-task',function (){
        let task_id =$(this).attr('task_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İş Kalemi Kopyala',
            icon: 'fa fa-clone',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'İş Kalemini Kopyalama İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            task_id: task_id,
                        }
                        $.post(baseurl + 'projeiskalemleri/clone',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#todotable').DataTable().destroy();
                                                draw_data_iskalemleri();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });

    $(document).on('click', '.edit-bolum', function () {
        let bolum_id = $(this).attr('bolum_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bölüm Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="code">Bölüm Kodu</label>
                            <input type="text" class="form-control" id="code" placeholder="Bölüm Kodu">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name">Bölüm Adı</label>
                            <input type="text" class="form-control" id="name" placeholder="Bölüm Adı">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="butce">Bütçe</label>
                            <input type="number" class="form-control" id="butce" placeholder="300.000">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="content">Açıklama</label>
                            <input type="text" class="form-control" id="content" placeholder="Detay">
                        </div>
                    </div>
                </form>`;

                // Veriyi sunucudan çek ve formu doldur
                $.post(baseurl + 'projebolumleri/get_info', { crsf_token: crsf_hash, bolum_id: bolum_id }, function (response) {
                    let responses = jQuery.parseJSON(response);
                    self.$content.find('#code').val(responses.item.code);
                    self.$content.find('#name').val(responses.item.name);
                    self.$content.find('#butce').val(responses.item.butce);
                    self.$content.find('#content').val(responses.item.exp);
                });

                return html;
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        // Form verilerini al
                        let data = {
                            crsf_token: crsf_hash,
                            bolum_id: bolum_id,
                            code: $('#code').val(),
                            name: $('#name').val(),
                            butce: $('#butce').val(),
                            content: $('#content').val(),
                            project: "<?php echo $_GET['id'] ?>"
                        };

                        // Zorunlu alan kontrolü
                        if (!data.name || !data.code || !data.butce) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tüm alanları doldurmanız gerekmektedir.',
                            });
                            return false;
                        }

                        // Sunucuya istekte bulun
                        $.post(baseurl + 'projebolumleri/update', data, function (response) {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status === 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#proje_bolumleri').DataTable().destroy();
                                                draw_data_bolumler();
                                            }
                                        }
                                    }
                                });
                            } else if (responses.status === 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                });
                            }
                        });
                    }
                }
            },
            onContentReady: function () {
                // Select2 entegrasyonu
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });
            }
        });
    });



    $(document).on('click', '.edit-asama', function () {
        let asama_id = $(this).attr('asama_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Aşama Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="bolum_id">Proje Bölümleri</label>
                        <select class="form-control select-box" id="bolum_id" name="bolum">
                            <option value="">Seçiniz</option>
                            <?php foreach ($bolumler as $blm): ?>
                                <option value="<?= $blm['id'] ?>"><?= $blm['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="parent_id">Bağlı Olduğu Aşama</label>
                        <select class="form-control select-box" id="parent_id" name="parent_id">

                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Aşama Adı</label>
                        <input type="text" class="form-control" id="name" placeholder="Elektrik İşleri" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customer_statement">Cari</label>
                        <select class="form-control select-box" id="customer_statement">
                            <option value="">Seçiniz</option>
                            <?php foreach (all_customer() as $blm): ?>
                                <option value="<?= $blm->id ?>"><?= $blm->company ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pers_id">Sorumlu Personel</label>
                        <select class="form-control select-box" id="pers_id">
                            <option value="">Seçiniz</option>
                            <?php foreach (all_personel() as $blm): ?>
                                <option value="<?= $blm->id ?>"><?= $blm->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="olcu_birimi">Ölçü Birimi</label>
                        <select class="form-control select-box" id="olcu_birimi">
                            <option value="">Seçiniz</option>
                            <?php foreach (units() as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?> - <?= $row['code'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="quantity">Miktar</label>
                        <input type="number" class="form-control" id="quantity" value="1" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fiyat">Birim Fiyatı</label>
                        <input type="number" class="form-control" id="fiyat" value="1" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="toplam_fiyat">Toplam Fiyat</label>
                        <input type="number" class="form-control" id="toplam_fiyat" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="butce">Bütçe</label>
                        <input type="number" class="form-control" id="butce" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="content">Açıklama</label>
                        <input type="text" class="form-control" id="content" required>
                    </div>
                </div>
            </form>`;

                $.post(baseurl + 'projeasamalari/get_info', { crsf_token: crsf_hash, asama_id: asama_id }, (response) => {
                    let responses = jQuery.parseJSON(response);

                    // Önce parent_id güncellemesi için bir fonksiyon ekleyelim
                    const updateParentOptions = () => {
                        $.post(baseurl + 'projeasamalari/get_parent_options', {
                            crsf_token: crsf_hash,
                            bolum_id: self.$content.find('#bolum_id').val(),
                            proje_id: $('#proje_id_hidden').val()
                        }, (parentResponse) => {
                            let parentOptions = jQuery.parseJSON(parentResponse);

                            // Parent seçeneklerini temizle ve yeni seçenekleri ekle
                            let parentSelect = self.$content.find('#parent_id');
                            parentSelect.empty();
                            parentSelect.append('<option value="">Seçiniz</option>'); // Varsayılan seçenek
                            parentOptions.forEach(option => {
                                parentSelect.append(
                                    `<option value="${option.id}" ${option.id === responses.item.parent_id ? 'selected' : ''}>${option.name}</option>`
                                );
                            });

                            parentSelect.trigger('change');
                        });
                    };

                    // bolum_id alanını ayarla ve değişikliği tetikle
                    self.$content.find('#bolum_id').val(responses.item.bolum_id).trigger('change');

                    // bolum_id alanındaki change olayını dinle
                    self.$content.find('#bolum_id').off('change').on('change', updateParentOptions);

                    // İlk başta parent_id'yi güncelle
                    updateParentOptions();

                    // Diğer alanları doldur
                    self.$content.find('#name').val(responses.item.name);
                    self.$content.find('#butce').val(responses.item.total);
                    self.$content.find('#content').val(responses.item.exp);
                    self.$content.find('#quantity').val(responses.item.quantity);
                    self.$content.find('#fiyat').val(responses.item.fiyat);
                    self.$content.find('#toplam_fiyat').val(responses.item.toplam);
                    self.$content.find('#pers_id').val(responses.item.pers_id).trigger('change');
                    self.$content.find('#olcu_birimi').val(responses.item.olcu_birimi).trigger('change');
                    self.$content.find('#customer_statement')
                        .append(new Option(responses.customer_details.company, responses.customer_details.customer_id, true, true))
                        .trigger('change');
                });


                return html;
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let data = {
                            crsf_token: crsf_hash,
                            asama_id,
                            project: $('#proje_id_hidden').val(),
                            name: $('#name').val(),
                            customer: $('#customer_statement').val(),
                            content: $('#content').val(),
                            bolum: $('#bolum_id').val(),
                            parent_id: $('#parent_id').val(),
                            pers_id: $('#pers_id').val(),
                            butce: $('#butce').val(),
                            olcu_birimi: $('#olcu_birimi').val(),
                            quantity: $('#quantity').val(),
                            fiyat: $('#fiyat').val(),
                            toplam_fiyat: $('#toplam_fiyat').val(),
                        };

                        if (!data.name || !data.bolum || !data.butce) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                title: 'Eksik Bilgi!',
                                content: 'Lütfen gerekli tüm alanları doldurunuz.',
                            });
                            return false;
                        }

                        $.post(baseurl + 'projeasamalari/update', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            if (responses.status === 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#asamalar').DataTable().destroy();
                                                draw_data_asamalar();
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    title: 'Hata!',
                                    content: responses.message,
                                });
                            }
                        });
                    }
                }
            },
            onContentReady: function () {
                $('#customer_statement').select2({
                    minimumInputLength: 1,
                    dropdownParent: $(".jconfirm-box-container"),
                    ajax: {
                        url: baseurl + 'search/customer_select',
                        dataType: 'json',
                        type: 'POST',
                        data: (params) => ({ customer: params.term, crsf_token: crsf_hash }),
                        processResults: (data) => ({
                            results: data.map(item => ({ text: item.company, id: item.id }))
                        }),
                    }
                });
                $('.select-box').select2({ dropdownParent: $(".jconfirm-box-container") });
            }
        });
    });


    $(document).on('click', '.edit-task', function () {
        let task_id = $(this).attr('task_id');
        const milestones = <?php echo json_encode($milestones); ?>;
        const all_personel = <?php echo json_encode(all_personel()); ?>;
        const units = <?php echo json_encode(units()); ?>;
        const task_status = <?php echo json_encode($task_status); ?>;

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İş Kalemi Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: true,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                //
                // <div class="form-group col-md-12">
                //     <label for="milestone_is">Proje Aşamalar</label>
                //     <select name="milestone" class="form-control select-box" id="milestone_is">
                //         <option value="0">Seçiniz</option>
                //         ${milestones.map(row => {
                //         const title = row.parent_id !== 0
                //             ? `${row.bolum_name}-${row.parent_name}-${row.name}`
                //             : `${row.name}-${row.bolum_name}`;
                //         return `<option value="${row.id}">${title}</option>`;
                //     }).join('')}
                //     </select>
                // </div>
                // Form HTML içeriği
                let formHtml = `
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name_is">İş Kalemi Adı</label>
                            <input type="text" class="form-control" id="name_is" placeholder="Elektrik İşlerinin Görülmesi">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pers_id_is">Sorumlu Personel</label>
                            <select class="form-control select-box" id="pers_id_is">
                                ${all_personel.map(person => `<option value="${person.id}">${person.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="customer_statement_is">Cari</label>
                            <select name="customer" class="form-control" id="customer_statement_is">
                                <option value="0">Seçiniz</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="olcu_birimi_is">Ölçü Birimi</label>
                            <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi_is">
                                ${units.map(unit => `<option value="${unit.id}">${unit.name} - ${unit.code}</option>`).join('')}
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="quantity_is">Miktar</label>
                            <input type="number" class="form-control" id="quantity_is" value="1">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fiyat_is">Birim Fiyatı</label>
                            <input type="text" class="form-control" id="fiyat_is" value="1">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="toplam_fiyat_is">Toplam Fiyatı</label>
                            <input type="text" class="form-control" id="toplam_fiyat_is">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="oran_is">Oran (%)</label>
                            <input type="text" class="form-control" id="oran_is" value="100">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status_is">Durum</label>
                            <select name="status" class="form-control select-box" id="status_is">
                                ${task_status.map(status => `<option value="${status.id}">${status.name}</option>`).join('')}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="content_is">Açıklama</label>
                            <input type="text" class="form-control" id="content_is">
                        </div>
                    </div>
                </form>`;

                // Task bilgilerini getir ve formu doldur
                $.post(`${baseurl}projeiskalemleri/get_info`, { crsf_token: crsf_hash, task_id }, (response) => {
                    const { item, customer_details } = jQuery.parseJSON(response);

                    // Form içeriğini güncelle
                    self.$content.find('#name_is').val(item.name);
                    self.$content.find('#quantity_is').val(item.quantity);
                    self.$content.find('#fiyat_is').val(item.fiyat);
                    self.$content.find('#toplam_fiyat_is').val(item.toplam_fiyat);
                    self.$content.find('#oran_is').val(item.oran);
                    self.$content.find('#status_is').val(item.status).trigger('change');
                    self.$content.find('#content_is').val(item.description);
                    self.$content.find('#pers_id_is').val(item.eid).trigger('change');
                    self.$content.find('#olcu_birimi_is').val(item.unit).trigger('change');
                    self.$content.find('#customer_statement_is')
                        .append(new Option(customer_details.company, customer_details.customer_id, true, true))
                        .trigger('change');
                });

                return formHtml;
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        const data = {
                            crsf_token: crsf_hash,
                            task_id,
                            name: $('#name_is').val(),
                            customer: $('#customer_statement_is').val(),
                            oran: $('#oran_is').val(),
                            status: $('#status_is').val(),
                            content: $('#content_is').val(),
                            pers_id: $('#pers_id_is').val(),
                            asama_id: $('#milestone_is').val(),
                            quantity: $('#quantity_is').val(),
                            fiyat: $('#fiyat_is').val(),
                            toplam_fiyat: $('#toplam_fiyat_is').val(),
                            olcu_birimi: $('#olcu_birimi_is').val(),
                            project: "<?php echo $_GET['id'] ?>"
                        };

                        $.post(`${baseurl}projeiskalemleri/update`, data, (response) => {
                            const result = jQuery.parseJSON(response);

                            if (result.status === 200) {
                                $.alert({
                                    theme: 'modern',
                                    type: 'green',
                                    title: 'Başarılı',
                                    content: result.message,
                                    buttons: {
                                        ok: {
                                            text: 'Tamam',
                                            action: () => {
                                                $('#todotable').DataTable().ajax.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $.alert({
                                    theme: 'modern',
                                    type: 'red',
                                    title: 'Hata',
                                    content: result.message,
                                });
                            }
                        });
                    },

                }
            },
            onContentReady: function () {
                // Müşteri seçimi için Select2 yapılandırması
                $("#customer_statement_is").select2({
                    minimumInputLength: 1,
                    dropdownParent: $(".jconfirm-box-container"),
                    tags: false,
                    ajax: {
                        url: baseurl + 'search/customer_select',
                        dataType: 'json',
                        type: 'POST',
                        quietMillis: 50,
                        data: function (customer) {
                            return {
                                customer: customer,
                                '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.company,
                                        id: item.id
                                    };
                                })
                            };
                        },
                    }
                });

                // Diğer Select2 alanları için genel yapılandırma
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });

                // Bölüm ID'yi değiştirdiğinizde Aşama (Parent ID) seçeneklerini yenileme
                $("#milestone_is").on("change", function () {
                    const milestoneId = $(this).val();
                    $.post(baseurl + 'projeasamalari/get_parent_options', {
                        crsf_token: crsf_hash,
                        milestone_id: milestoneId
                    }, (response) => {
                        const options = JSON.parse(response);
                        const parentSelect = $("#parent_id");
                        parentSelect.empty(); // Önce mevcut seçenekleri temizle
                        parentSelect.append('<option value="">Seçiniz</option>'); // Varsayılan seçenek ekle
                        options.forEach(option => {
                            parentSelect.append(
                                `<option value="${option.id}">${option.name}</option>`
                            );
                        });
                    });
                });

                // Form submit işlemi için enter tuşuna basıldığında tetikleme
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // Submit butonunu tetikle
                });
            }

        });
    });


    $(document).on('click','.delete-bolum',function (){
        let bolum_id =$(this).attr('bolum_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bölüm Sil',
            icon: 'fa fa-trash',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Bölümü Silmek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            bolum_id: bolum_id,
                        }
                        $.post(baseurl + 'projebolumleri/delete',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#proje_bolumleri').DataTable().destroy();
                                                draw_data_bolumler();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $(document).on('click','.delete-stok',function (){
        let stok_id =$(this).attr('stok_id')
        let durum = $(this).attr('durum')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Stok Sil',
            icon: 'fa fa-trash',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Stoğu Silmek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            stok_id: stok_id,
                        }
                        $.post(baseurl + 'projestoklari/delete',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {

                                                if(!parseInt(durum)){
                                                    let remove = '#remove'+ stok_id
                                                    $(remove).remove();
                                                }
                                                else{
                                                    $('#stoklar_table').DataTable().destroy();
                                                    draw_data_stoklar();
                                                }

                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $(document).on('click','.talep-plus',function (){
        let stok_id =$(this).attr('stok_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Talep Listeme Ekle / Kaldır',
            icon: 'fa fa-question',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Stoğu Talep Listenize Eklemek İstediğinizden Emin Misiniz?<p>Eğer ürün listenizde ekliyse otomatik kaldırılır</p>',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            stok_id: stok_id,
                        }
                        $.post(baseurl + 'projestoklari/talep_list_create',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#stoklar_table').DataTable().destroy();
                                                draw_data_stoklar();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $(document).on('click','.delete-asama',function (){
        let asama_id =$(this).attr('asama_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Aşama Sil',
            icon: 'fa fa-trash',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Aşamayı Silmek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            asama_id: asama_id,
                        }
                        $.post(baseurl + 'projeasamalari/delete',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#asamalar').DataTable().destroy();
                                                draw_data_asamalar();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })


    $(document).on('click','.delete-task',function (){
        let task_id =$(this).attr('task_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İş Kalemi Sil',
            icon: 'fa fa-trash',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'İş Kalemini Silmek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            task_id: task_id,
                        }
                        $.post(baseurl + 'projeiskalemleri/delete',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#todotable').DataTable().destroy();
                                                draw_data_iskalemleri();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $(document).on('click','.table_line_update',function (){
        let tip = $(this).attr('tip');
        let stok_id = $(this).attr('stok_id');
        let data = {
            crsf_token: crsf_hash,
            stok_id: stok_id,
            tip: tip,
        }
        $.post(baseurl + 'projestoklari/get_info_update',data,(response) => {
            let responses_data = jQuery.parseJSON(response);
            $('#loading-box').addClass('d-none');
            if(responses_data.status==200){

                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: responses_data.title,
                    icon: 'fa fa-pen',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-6 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: responses_data.content,
                    buttons: {
                        formSubmit: {
                            text: 'Güncelle',
                            btnClass: 'btn-blue',
                            action: function () {
                                let data =$("#update_form").serialize();
                                if(tip=='table_product_stock_code_update'){

                                    let stock_code_id = $('.option-value:checked').attr('stock_code_id');

                                    data = {
                                        stock_code_id: stock_code_id,
                                        stok_id: stok_id,
                                        tip: tip
                                    }
                                }
                                $('#loading-box').removeClass('d-none');

                                $.post(baseurl + 'projestoklari/update',data,(response) => {
                                    let responses = jQuery.parseJSON(response);
                                    $('#loading-box').addClass('d-none');
                                    if(responses.status==200){
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-check',
                                            type: 'green',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "small",
                                            title: 'Başarılı',
                                            content: responses.message,
                                            buttons:{
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        $('#stoklar_table').DataTable().destroy();
                                                        draw_data_stoklar();
                                                    }
                                                }
                                            }
                                        });

                                    }
                                    else {
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Dikkat!',
                                            content: responses.message,
                                            buttons:{
                                                prev: {
                                                    text: 'Tamam',
                                                    btnClass: "btn btn-link text-dark",
                                                }
                                            }
                                        });
                                    }
                                })

                            }
                        },
                        cancel:{
                            text: 'Vazgeç',
                            btnClass: "btn btn-danger btn-sm",
                        },
                    },
                    onContentReady: function () {
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        })


                        $("#line_product_id").select2({
                            minimumInputLength: 1,
                            dropdownParent: $(".jconfirm-box-container"),
                            tags: false,
                            ajax: {
                                url:baseurl + 'search/product_select',
                                dataType: 'json',
                                type: 'POST',
                                quietMillis: 50,
                                data: function (product) {
                                    return {
                                        product: product,
                                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.product_name,
                                                id: item.pid
                                            }
                                        })
                                    };
                                },
                            }
                        });
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });

            }
            else if(responses.status==410){

                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: responses.message,
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }
        })
    })


    $(document).on('change', "#bolum_id", function (e) {
        $("#asama_id option").remove();
        $("#parent_id option").remove();
        var bolum_id = $(this).val();
        var proje_id = $('#proje_id_hidden').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projects/asamalar_list',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#parent_id').append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#parent_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });

    $(document).on('change', ".bolum_id_product", function (e) {
        let eq=$(this).attr('index');
        $(".asama_id_product option").eq(eq).remove();
        var bolum_id = $(this).val();
        var proje_id = $('#proje_id_hidden').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'projects/asamalar_list',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('.asama_id_product').eq(eq).append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $(".asama_id_product").eq(eq).append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });
    $(document).keyup('#fiyat',function (){
        var fiyat = $('#fiyat').val();
        var quantity =$('#quantity').val();

        var toplam_fiyat = fiyat*quantity;
        $("#toplam_fiyat").val(toplam_fiyat.toFixed(2));

    });
    $(document).keyup('#quantity',function (){
        var fiyat = $('#fiyat').val();
        var quantity =$('#quantity').val();

        var toplam_fiyat = fiyat*quantity;
        $("#toplam_fiyat").val(toplam_fiyat.toFixed(2));

    });


    $(document).on('change','#line_product_id',function (){
        let product_id  = $(this).val();
        let varyasyon_durum=false;
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Varyasyonlar',
            icon: 'fa fa-filter',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = '<div class="list"></div>'; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let data = {
                    crsf_token: crsf_hash,
                    product_id: product_id,
                }

                let table_report='';
                $.post(baseurl + 'malzemetalep/get_product_to_value',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('.list').empty().html(responses.html)
                    if(responses.code==200){
                        varyasyon_durum=true;
                    }
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel:{
                    text: 'Devam',
                    btnClass: 'btn-blue',
                    action: function () {
                        let option_details_line=[];
                        let options_id='';
                        let option_value_id='';
                        let last = ($('.option-value:checked').length)-1;
                        if(varyasyon_durum){
                            $('.option-value:checked').each((index,item) => {
                                if(index===last){
                                    options_id+=$(item).attr('data-option-id');
                                    option_value_id+=$(item).attr('data-value-id');
                                }
                                else {
                                    options_id+=$(item).attr('data-option-id')+',';
                                    option_value_id+=$(item).attr('data-value-id')+',';
                                }
                            });
                        }
                      $('#line_option_id').val(options_id);
                      $('#line_option_value_id').val(option_value_id);
                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })


    $(document).keyup('#oran_is',function (){
        var fiyat = $('#fiyat_is').val();
        var quantity =$('#quantity_is').val();
        var oran =  $('#oran_is').val();
        if(oran!='')
        {
            oran = oran;
        }
        else
        {
            oran = 100;
        }
        var toplam_fiyat = (fiyat*quantity*oran)/100;
        $("#toplam_fiyat_is").val(toplam_fiyat.toFixed(2));

    });
    function draw_data(start_date = '', end_date = '') {
        $('#forma_2_new').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('formainvoices/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    proje_id: $('#proje_id_hidden').val(),
                    end_date: end_date,
                    tip: 'proje_giderleri'
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
            ]
        });
    }
    function draw_data_mt_Report(start_date = '', end_date = '') {
        $('#mt_urun_table').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('urun/proje_mt_report')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    proje_id: $('#proje_id_hidden').val(),
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5]
                    }
                },
            ]
        });
    }


    $(document).on('click','.gorulmus_is_giris',function (){
        let todolist_id = $(this).attr('task_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İş Girişi Yap',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form>
<div>
<label class="form-control-label">Görülen İş</label>
<input class="form-control qty" type='number' value='1'>
</div>
<div>
<label class="form-control-label">Açıklama</label>
<input class="form-control desc">
</div>
<div>
<label class="form-control-label">Sorumlu Personel</label>
<select class="form-control select-box confirm_user">
                                            <option value='0'>Seçin</option>
                                                <?php
            foreach (all_personel() as $item) {
                echo "<option value='$item->id'>$item->name</option>";
            }
            ?>
                                        </select>
</div>
<div>
<label class="form-control-label">Tarih</label>
<input class="form-control date_input" type='date'>
</div>
</form>`,
            buttons: {
                formSubmit: {
                    text: 'Giriş Yap',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            todolist_id: todolist_id,
                            proje_id: $("#proje_id").val(),
                            qty: $('.qty').val(),
                            desc: $('.desc').val(),
                            confirm_user: $('.confirm_user').val(),
                            date_input: $('.date_input').val(),
                        }
                        $.post(baseurl + 'projeiskalemleri/input_create',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#todotable').DataTable().destroy();
                                                draw_data_iskalemleri();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                        );
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    $(document).on('click','.detay_giris',function (e){

        let talep_id = $(this).attr('task_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İŞ Hareketleri',
            icon: 'fa fa-exclamation',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-12',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_history">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table id="notes_report_is"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kayıt Tarihi</th>
                            <th>İş Giriş Tarihi</th>
                            <th>Sorumlu Personel</th>
                            <th>Giriş Yapan Personel</th>
                            <th>Açıklama</th>
                            <th>İş Giriş Miktarı</th>
                            <th>İşlem</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_history').empty().html(table_report);
                    draw_data_is_girisi(talep_id);
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                    action: function () {
                        $('#todotable').DataTable().destroy();
                        draw_data_iskalemleri();
                    }
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })

    function draw_data_is_girisi(talep_id=0) {
        $('#notes_report_is').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('projeiskalemleri/ajax_list_is_kalemleri_ac')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    talep_id: talep_id,
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                }

            ]
        });
    };

    $(document).on('click', ".is_girisi_sil", function (e) {
        let is_giris_id = $(this).attr('is_giris_id');
        let is_id = $(this).attr('is_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İşi Silmek Üzeresiniz. Emin Misiniz?<p/>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'SİL',
                    btnClass: 'btn-blue',
                    action: function () {

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            is_giris_id:  is_giris_id,
                            proje_id: $("#proje_id").val(),
                        }
                        $.post(baseurl + 'projeiskalemleri/is_giris_delete',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status==200){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#notes_report_is').DataTable().destroy();
                                                draw_data_is_girisi(is_id);
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }
                        })

                    }
                },
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        $('#todotable').DataTable().destroy();
                        draw_data_iskalemleri();
                    }
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })


</script>
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.iframe-transport.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/js/upload/load-image.all.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/js/upload/canvas-to-blob.min.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload.js') ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-process.js') ?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-image.js') ?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-audio.js') ?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-video.js') ?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-validate.js') ?>"></script>

<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = baseurl + 'projects/file_handling?id=<?php echo $project['id']; ?>',
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                        data = $this.data();
                    $this
                        .off('click')
                        .text('Abort')
                        .on('click', function () {
                            $this.remove();
                            data.abort();
                        });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    var slider = $('#progress');
    var textn = $('#prog');
    textn.text(slider.val() + '%');
    $(document).on('change', slider, function (e) {
        e.preventDefault();
        textn.text($('#progress').val() + '%');
        $.ajax({

            url: baseurl + 'projects/progress',
            type: 'POST',
            data: {'pid':<?php echo $project['id']; ?>, 'val': $('#progress').val(),'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            dataType: 'json',
            success: function (data) {

                $('#description').html(data.description);
                $('#task_title').html(data.name);
                $('#employee').html(data.employee);
                $('#assign').html(data.assign);
                $('#priority').html(data.priority);
            }

        });
    });


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }


    $(document).on('change','#method_id',function (){
        let value=$(this).val();
        if(value==1){
            $('#tax_oran').val(0);
            $('#tax_oran').attr('disabled',true);
        }
        else {
            $('#tax_oran').val(0);
            $('#tax_oran').attr('disabled',false);
        }
    })

    $(document).on('click','.bolum_all',function (){
        let temin_date = $('.bolum_id_product').eq(0).val();
        if(temin_date){
            $(".asama_id_product option").remove();
            $('.bolum_id_product').val(temin_date).select2().trigger('change');

            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
        }
        else {
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: '1. Satırda Bölüm Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })

    $(document).on('click','.asama_all',function (){
        let progress_status_id = $('.asama_id_product').eq(0).val();
        if(progress_status_id){
            $('.asama_id_product').val(progress_status_id).select2().trigger('change');
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
        }
        else {
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: '1. Satırda Aciliyet Durumu Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })

    $(document).on('click','.birim_all',function (){
        let unit_id = $('.unit_id').eq(0).val();
        if(unit_id){
            $('.unit_id').val(unit_id).select2().trigger('change');
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
        }
        else {
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: '1. Satırda Birim Seçilmemiş',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })


    $(document).on('change','.all_select_mt_list',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select_mt_list').prop('checked',true)
        }
        else {
            $('.one_select_mt_list').prop('checked',false)
        }
    })

    $(document).on('change','.bolum_id',function (){
        $(".asama_new_id option").remove();
        let id = $(this).val();
        let data = {
            bolum_id: id
        }

        $.post(baseurl + 'projects/get_parent_list_asama',data,(response)=>{
            let responses = jQuery.parseJSON(response);



            if(responses.status==200){
                $('.asama_new_id').append(new Option('Seçiniz', '', false, false));
                responses.items.forEach((item_,index) => {
                    $('.asama_new_id').append(new Option(item_.name, item_.id, false, false));
                })
            }
            else {

                $('.asama_new_id').append(new Option('Aşama Yoktur', 0, false, false));
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: "Aşama Yoktur",
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }


        });

    })
      $(document).on('change','.asama_new_id',function (){
        $("#group_id option").remove();
        let id = $(this).val();
        let data = {
            asama_id: id
        }
        $.post(baseurl + 'projects/get_parent_list',data,(response)=>{
            let responses = jQuery.parseJSON(response);



            if(responses.status==200){
                $('#group_id').append(new Option('Seçiniz', '', false, false));
                responses.items.forEach((item_,index) => {
                    $('#group_id').append(new Option(item_.name, item_.id, false, false));
                })
            }
            else {

                $('#group_id').append(new Option('Alt Grup Yoktur', 0, false, false));
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: "Alt Grup Yoktur",
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }


        });
    })
      $(document).on('change','.group_id',function (){
        let id = $(this).val();

        let data = {
            asama_id: id
        }
        $.post(baseurl + 'projects/get_parent_list',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            let eq=$(this).parent().index();

            if(responses.status==200){

                let class_name = $(this).attr('class');
                if(class_name=='form-control select-box group_id'){


                    if($(this).val()==0){
                        $('.add_group').eq(parseInt(eq)-1).remove();
                    }

                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;
                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }



                }
                else {
                    $('.add_group').remove();
                }


                let add_grp = $('.add_group').length;
                if(parseInt(add_grp)){
                    let say = parseInt(add_grp)-1;
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id[]">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.add_group').eq(say).after(html);

                }
                else {
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id[]">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.one_group').after(html);
                }
            }
            else {

                if($(this).val()==0){
                    $('.add_group').eq(parseInt(eq)-1).remove();
                }

                if($(this).attr('types')=='ones'){

                    $('.add_group').remove();
                }
                else {
                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;

                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }
                }



                $.alert({
                    theme: 'material',
                    icon: 'fa fa-question',
                    type: 'orange',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Alt Aşama Yoktur',
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
            }


        });
    })

    $(document).on('change','.all_checked_is_kalemleri',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.on_checked_is_kalemleri').prop('checked',true)
        }
        else {
            $('.on_checked_is_kalemleri').prop('checked',false)
        }
    })

    $(document).on("click",".forma2_list_view",function(){
        let razilastirma_id = $(this).attr('razilastirma_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bilgi',
            icon: 'fa fa-exclamation',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-12 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+=` <div class="form-row">
                <table id="result_parent" class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Forma 2 No</th>
                      <th scope="col">Cari</th>
                      <th scope="col">Net Tutar</th>
                      <th scope="col">KDV Tutar</th>
                      <th scope="col">Toplam</th>
                      <th scope="col">Görüntüle</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
            </div>
`;

                let data = {
                    crsf_token: crsf_hash,
                    razilastirma_id: razilastirma_id,
                }
                let table_report='';
                $.post(baseurl + 'formainvoices/get_razilastirma',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    let i=1;
                    $.each(responses.items, function (index, item) {
                        $("#result_parent>tbody").append('<tr class="result-row">' +
                            '<td>'+i+'</td> ' +
                            '<td>'+ item.invoice_no +'</td>' +
                            '<td>'+ item.payer +'</td>' +
                            '<td>'+currencyFormat(parseFloat(item.subtotal))+'</td>' +
                            '<td>'+currencyFormat(parseFloat(item.tax))+'</td>' +
                            '<td>'+currencyFormat(parseFloat(item.total))+'</td>' +
                            '<td> <a type="button" href="/formainvoices/view?id='+item.id+'" target="_blank" class="btn btn-info"><i class="fa fa-eye"></i></a></td>' +
                            '</tr>' );
                        i++;
                    });

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",

                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });

    })
    $(document).on('click','.delete_item_razi',function (){
        $(this).parent().parent().remove();
        item_hesap(0);
    })

    $(document).on('click','.clone',function(){
        let name=$(this).attr('clone_name');
        $("."+name).clone().appendTo( ".is_razilastirma_table_edit tbody");
        item_hesap(0);

    })


    function error_log_message(mesaj){
        $.alert({
            theme: 'modern',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            title: 'Dikkat!',
            content: mesaj,
            buttons: {
                prev: {
                    text: 'Tamam',
                    btnClass: "btn btn-link text-dark",
                }
            }
        });
    }


</script>

<style>

    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
        color: #ffffff;
        background-color: #3b475e !important;
        border-color: #F5F7FA #F5F7FA #F5F7FA !important;
        height: 64px;
        font-size: 20px;
        margin: auto;
        text-align: center;
        padding: 15px;
        border-radius: 0px;
    }
    .nav-tabs .nav-link{
        height: 64px;
        font-size: 20px;
        margin: auto;
        text-align: center;
        padding: 15px;
        background: #617497 !important;
        color: white;
        border-color: #F5F7FA #F5F7FA #F5F7FA;
        border-radius: 0px;
    }
    .nav.nav-tabs .nav-item:hover{
        color: #fff;
        font-weight: 700;
        background: #7a92bf;
    }


</style>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
