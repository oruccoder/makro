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
                                                <a class="nav-item nav-link" id="nav-depo" data-toggle="tab" href="#depo" role="tab" aria-controls="nav-contact" aria-selected="false">Depo Takibi</a>
                                                <!--a class="nav-item nav-link" id="nav-demirbas" data-toggle="tab" href="#demirbas" role="tab" aria-controls="nav-contact" aria-selected="false">Demirbaşlar</a!-->
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#activities" role="tab" aria-controls="nav-contact" aria-selected="false">Faaliyet Günlüğü</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#files" role="tab" aria-controls="nav-contact" aria-selected="false">Dosyalar</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#notes" role="tab" aria-controls="nav-contact" aria-selected="false">Notlar</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#invoices" role="tab" aria-controls="nav-contact" aria-selected="false">Proje Faturaları</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#comments" role="tab" aria-controls="nav-contact" aria-selected="false">Yorumlar</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#tum_giderler" role="tab" aria-controls="nav-contact" aria-selected="false">Tüm Giderler</a>
                                                <a class="nav-item nav-link" id="nav-upload" data-toggle="tab" href="#formalar_" role="tab" aria-controls="nav-contact" aria-selected="false">Forma2</a>
                                            </div>
                                        </nav>

                                        <div class="tab-content px-1 pt-1">
                                            <div role="tabpanel" class="tab-pane active show" id="active"
                                                 aria-labelledby="active-tab" aria-expanded="true">
                                                <div class="table-responsive col-sm-12">
                                                    <table class="table datatable-show-all">

                                                        <tbody>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('Project Title') ?></th>
                                                            <td>
                                                                <p><?php echo $project['name'] ?></p>

                                                            </td>

                                                        </tr>
                                                        <!-- Proje Yetki -->
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('project_adresi') ?></th>
                                                            <td>
                                                                <p><?php echo $project['project_adresi'] ?></p>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('project_sehir') ?></th>
                                                            <td>
                                                                <p><?php echo $project['project_sehir'] ?></p>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('proje_yetkili_adi') ?></th>
                                                            <td>
                                                                <p><?php echo $project['project_yetkili_adi'] ?></p>

                                                            </td>

                                                        </tr>


                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('project_yetkli_no') ?></th>
                                                            <td>
                                                                <p><?php echo $project['project_yetkili_no'] ?></p>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('project_yetkili_email') ?></th>
                                                            <td>
                                                                <p><?php echo $project['project_yetkili_email'] ?></p>

                                                            </td>

                                                        </tr>



                                                        <!-- Proje Yetki -->

                                                        <!--tr>
                                                <th scope="row"><?php echo $this->lang->line('Priority') ?></th>
                                                <td>
                                                    <p><?php echo project_derece($project['priority']) ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Status') ?></th>
                                                <td>
                                                    <p><?php echo project_status($project['status']) ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Progress') ?></th>
                                                <td>
                                                    <input type="range" min="0" max="100"
                                                           value="<?php echo $project['progress'] ?>" class="slider"
                                                           id="progress">
                                                    <p><span id="prog"></span></p>

                                                </td>

                                            </tr-->
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('Customer') ?></th>
                                                            <td>
                                                                <p><?php echo $project['customer'] ?></p>
                                                                <p class="text-muted"><?php echo $project['email'] ?></p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('Start Date') ?></th>
                                                            <td>
                                                                <p><?php echo dateformat($project['sdate']) ?></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('Due Date') ?></th>
                                                            <td>
                                                                <p><?php echo dateformat($project['edate']) ?></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('Warehouse') ?></th>
                                                            <td>

                                                                <p><?php if(project_to_depo($project['id']))
                                                                    {
                                                                        $depo_id=project_to_depo($project['id'])->id;
                                                                        echo "<a target='_blank' class='btn btn-success' href='/warehouse/view/$depo_id'>".project_to_depo($project['id'])->title.'</a>';
                                                                    }
                                                                    else { echo 'Depo Tanımlanmamış';    }
                                                                    ?></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Görülmüş İş Girişi</th>
                                                            <td>

                                                                <?php  $proje_id=$project['id'];  echo "<a target='_blank' class='btn btn-success' href='/projects/is_kalemleri?id=$proje_id'>".'Giriş Yap'.'</a>'; ?>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('sozlesme_numarasi') ?></th>
                                                            <td>
                                                                <p><?php echo $project['sozlesme_numarasi'] ?></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('proje_muduru') ?></th>
                                                            <td>
                                                                <p><?php echo personel_details($project['proje_muduru']) ?></p>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('sozlesme_tarihi') ?></th>
                                                            <td>
                                                                <p><?php echo dateformat($project['sozlesme_date']) ?></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('Budget') ?></th>
                                                            <td>
                                                                <p><?php echo amountFormat($project['worth']) ?></p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><?php echo $this->lang->line('sozlesme_tutari') ?></th>
                                                            <td>
                                                                <p><?php echo amountFormat($project['sozlesme_tutari']) ?></p>

                                                            </td>

                                                        </tr>


                                                        <tr>
                                                            <th scope="row">Anlık Maliyet</th>
                                                            <td><?php //$proje_maliyeti=proje_maliyeti($project['id'])//
                                                                //
                                                                $proje_maliyeti = $new_maliyet?>
                                                                <p><?php echo amountFormat($proje_maliyeti) ?></p>
                                                                <p><a href="/projects/maliyet_raporu/<?php echo $project['id'];?>" class="btn btn-success">Maliyet Raporu</a> </p>


                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Komisyon Anlık Maliyet</th>
                                                            <td><?php $komisyon=nakit_komisyonlari_proje($project['id'])+banka_komisyonlari_proje($project['id']); ?>
                                                                <p><?php echo amountFormat($komisyon) ?></p>

                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Proje Maliyetinde Yüzdelik Oran</th>
                                                            <td>
                                                                <p><?php
                                                                    if($project['worth']!=0)
                                                                    {
                                                                        echo round($proje_maliyeti  /$project['worth']*100,2)    ;
                                                                    }
                                                                    else
                                                                    {
                                                                        echo 0;
                                                                    }
                                                                    ?>%</p>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Bildirimler</th>
                                                            <td>
                                                                <p><?php switch ($project['ptype']) {
                                                                        case 0 :
                                                                            echo 'Bildirimler Kapalı';
                                                                            break;
                                                                        case 1 :
                                                                            echo 'Personllere Mail İlet';
                                                                            break;

                                                                        case 2 :
                                                                            echo 'Personel ve Müşteriye Mail İlet';
                                                                            break;
                                                                    }

                                                                    ?></p>

                                                            </td>

                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab"
                                                 aria-expanded="false">
                                                <table id="todotable" style="display: block;
    overflow: auto;" class="genis datatable-show-all" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipi</th>
                                                        <th>Adı</th>
                                                        <th>Bölüm</th>
                                                        <th>Bağlı Olduğu Aşama</th>
                                                        <th>Aşama</th>
                                                        <th>Fiyat</th>
                                                        <th>Birim</th>
                                                        <th>Miktar</th>
                                                        <th>Oran</th>
                                                        <th>Toplam Fiyat</th>
                                                        <!--th>Başlangıç Tarihi</-th>
                                                        <th>Bitiş Tarihi</th-->
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
                                                            <th>Depoya Giriş Miktarı</th>
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
                                                 aria-labelledby="activities-tab" aria-expanded="false" style="max-height: 500px;overflow: auto;"><p><a
                                                            href="<?php echo base_url('projects/addactivity?id=' . $project['id']) ?>"
                                                            class="btn btn-primary btn-sm rounded">
                                                        <?php echo $this->lang->line('Add activity') ?>
                                                    </a></p>
                                                <?php
                                                foreach ($activities as $row) { ?>


                                                    <div class="form-group row">


                                                        <div class="col-sm-10">
                                                            <?php

                                                            echo '- ' . $row['value'] . '<br><br>';


                                                            ?>
                                                        </div>
                                                    </div>
                                                <?php }
                                                ?>
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
                                                            <th>Birim</th>
                                                            <th>Miktar</th>
                                                            <th>KDV Hariç Birim F.</th>
                                                            <th>KDV Oranı</th>
                                                            <th>Net Toplam</th>
                                                            <th>KDV</th>
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
                                                            <th>Toplam</th>
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



<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="status"><?php echo $this->lang->line('Change Status') ?></label>
                            <select name="stat" class="form-control mb-1">
                                <option value="Due">Due</option>
                                <option value="Progress">Progress</option>
                                <option value="Done">Done</option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="taskid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="tools/set_task">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="task_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h4 class="modal-title" id="task_title"><?php echo $this->lang->line('Details'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1" id="description">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
                                        id="priority"></span></strong>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?>
                            <strong><span
                                        id="employee"></span></strong>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned by') ?>
                            <strong><span
                                        id="assign"></span></strong>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="taskid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- add task -->
<!--dynamic delete -->
<div id="delete_model_1" class="modal fade">
    <form id="mform_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>

                </div>

                <div class="modal-footer">
                    <input type="hidden" id="project_id" name="project_id" value="<?php echo $project['id']; ?>">
                    <input type="hidden" id="object-id_1" value="" name="object_id">
                    <input type="hidden" id="action-url_1" value="projects/delete_file">
                    <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                            id="delete-confirm_1"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--dynamic delete 2-->
<div id="delete_model_2" class="modal fade">
    <form id="mform_2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>

                </div>

                <div class="modal-footer">

                    <input type="hidden" id="object-id_2" value="" name="object_id">
                    <input type="hidden" id="action-url_2" value="projects/delete_milestone">
                    <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                            id="delete-confirm_2"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- 3 -->
<div id="delete_model_3" class="modal fade">
    <form id="mform_3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this task') ?> </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id_3" value="" name="deleteid">
                    <input type="hidden" id="action-url_3" value="tools/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                            id="delete-confirm_3"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- 4 -->
<div id="delete_model_4" class="modal fade">
    <form id="mform_4">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <p>Bu bölümü silmek istediğinizden emin misiniz?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="object-id_4"  name="object_id">
                        <input type="hidden" id="action-url_4" value="projects/delete_bolum">

                        <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                                id="delete-confirm_4"><?php echo $this->lang->line('Delete') ?></button>

                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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
        draw_data();


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
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Bölüm Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                          <label for="name">Bölüm Adı</label>
                                          <input type="text" class="form-control" id="name" placeholder="Bina Adı">

                                        </div>
                                    </div>
                                    <div class="form-row">
                                     <div class="form-group col-md-6">
                                          <label for="butce">Bütçe</label>
                                            <input type="number" class="form-control" id="butce" placeholder="300.000">
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Açıklama</label>
                                          <input type="text" class="form-control" id="content" placeholder="detay">
                                        </div>
                                    </div>
                                    </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            name:  $('#name').val(),
                                            butce:  $('#butce').val(),
                                            content:  $('#content').val(),
                                            project:  "<?php echo $_GET['id'] ?>"
                                        }
                                        $.post(baseurl + 'projebolumleri/create',data,(response) => {
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
                $(row).attr('style', data[5]);
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
                                                let table=`<tr  id="remove`+responses.item_id+`" >
                                                    <td>`+mt_index+`</td>
                                                    <td><p>`+responses.product_name+`</p><span style="font-size: 12px;">`+responses.option_html+`</span></td>
                                                    <td>`+responses.qyt_birim+`</td>
                                                    <td><button stok_id='`+responses.item_id+`' type_="2" class="btn btn-danger btn-sm delete-stok" durum='0'><i class='fa fa-trash'></i></button></td>
                                         <tr>`;
                                                $('.table_create_products tbody').append(table);
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
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Aşama Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Bölümleri</label>
                                            <select class="form-control select-box" id="bolum_id" name="bolum">
                                                <?php foreach ($bolumler as $blm)
                                                    {
                                                        $id=$blm['id'];
                                                        $name=$blm['name'];
                                                        echo "<option value='$id'>$name</option>";
                                                    } ?>
                                            </select>
                                        </div>
                                               <div class="form-group col-md-12">
                                            <label for="name">Bağlı Olduğu Aşama</label>
                                            <select class="form-control select-box" id="parent_id" name="parent_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                     <div class="form-group col-md-6">
                                          <label for="name">Aşama Adı</label>
                                            <input type="text" class="form-control" id="name" placeholder="Elektrik İşleri">
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Cari</label>
                                               <select name="customer" class="form-control" id="customer_statement">
                                                    <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box" id="pers_id">
                                                    <?php foreach (all_personel() as $blm)
                                                            {
                                                                $id=$blm->id;
                                                                $name=$blm->name;
                                                                echo "<option value='$id'>$name</option>";
                                                            } ?>
                                                </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi">
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
                                         <div class="form-group col-md-4">
                                          <label for="name">Miktar</label>
                                           <input type="number" class="form-control" name="quantity" id="quantity" value="1">
                                        </div>
                                          <div class="form-group col-md-4">
                                          <label for="name">Birim Fiyatı</label>
                                            <input type="text" class="form-control" name="fiyat" id="fiyat" value="1">
                                        </div>
                                         <div class="form-group col-md-4">
                                          <label for="name">Toplam Fiyatı</label>
                                             <input type="text" class="form-control" name="toplam_fiyat" id="toplam_fiyat">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Bütçe</label>
                                             <input id="butce" name="butce" type="text" class="form-control">
                                        </div>
                                          <div class="form-group col-md-6">
                                          <label for="name">Açıklama</label>
                                            <input type="text" class="form-control" name="content" id="content">
                                        </div>

                                      </div>
                                    </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            name:  $('#name').val(),
                                            customer:  $('#customer_statement').val(),
                                            content:  $('#content').val(),
                                            bolum:  $('#bolum_id').val(),
                                            parent_id:  $('#parent_id').val(),
                                            pers_id:  $('#pers_id').val(),
                                            butce:  $('#butce').val(),
                                            olcu_birimi:  $('#olcu_birimi').val(),
                                            quantity:  $('#quantity').val(),
                                            fiyat:  $('#fiyat').val(),
                                            toplam_fiyat:  $('#toplam_fiyat').val(),
                                            project:  "<?php echo $_GET['id'] ?>"
                                        }
                                        $.post(baseurl + 'projeasamalari/create',data,(response) => {
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
                            },
                            onContentReady: function () {


                                $("#customer_statement").select2({
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
                }
            ]

        });
    }

    function draw_data_iskalemleri(){
        $('#todotable').DataTable({
            "processing": true,
            "serverSide": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style',data[13]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projeiskalemleri/ajax_list')?>",
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
                            content:`<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Aşamalar</label>
                                              <select name="milestone" class="form-control select-box" id="milestone_is">
                                              <option value='0'>Seçiniz</option>
                                                    <?php
                                                    foreach ($milestones as $row) {
                                                        $cid = $row['id'];
                                                        $parent_id = $row['parent_id'];
                                                        $bolum_name=bolum_getir($row['bolum_id']);

                                                        if($parent_id!=0)
                                                        {
                                                            $title=$bolum_name.'-'.task_to_asama($parent_id).'-'.$row['name'];
                                                        }
                                                        else
                                                        {
                                                            $title=$row['name'].'-'.$bolum_name;
                                                        }

                                                        echo "<option value='$cid'>$title </option>";

                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                               <div class="form-group col-md-12">
                                            <label for="name">İş Kalemi Adı</label>
                                             <input type="text" class="form-control" id="name_is" placeholder="Elektrik İşlerinin Görülmesi">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                          <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box" id="pers_id_is">
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
                                               <select name="customer" class="form-control" id="customer_statement_is">
                                                    <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi_is">
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
                                           <input type="number" class="form-control" name="quantity_is" id="quantity_is" value="1">
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
                                            <input type="text" class="form-control" id="oran_is" value="100">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Durum</label>
                                           <select name="status" class="form-control" id="status_is">
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
                                            <input type="text" class="form-control" name="content_is" id="content_is">
                                        </div>

                                      </div>
                                    </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            name:  $('#name_is').val(),
                                            customer:  $('#customer_statement_is').val(),
                                            oran:  $('#oran_is').val(),
                                            status:  $('#status_is').val(),
                                            content:  $('#content_is').val(),
                                            pers_id:  $('#pers_id_is').val(),
                                            asama_id:  $('#milestone_is').val(),
                                            quantity:  $('#quantity_is').val(),
                                            fiyat:  $('#fiyat_is').val(),
                                            toplam_fiyat:  $('#toplam_fiyat_is').val(),

                                            olcu_birimi:  $('#olcu_birimi_is').val(),
                                            project:  "<?php echo $_GET['id'] ?>"
                                        }
                                        $.post(baseurl + 'projeiskalemleri/create',data,(response) => {
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
                }
            ]

        });
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

    $(document).on('click','.edit-bolum',function (){
        let bolum_id =$(this).attr('bolum_id')
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Bölüm Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="name">Bölüm Adı</label>
                                  <input type="text" class="form-control" id="name" placeholder="Bina Adı">

                                </div>
                            </div>
                            <div class="form-row">
                             <div class="form-group col-md-6">
                                  <label for="butce">Bütçe</label>
                                    <input type="number" class="form-control" id="butce" placeholder="300.000">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="content">Açıklama</label>
                                  <input type="text" class="form-control" id="content" placeholder="detay">
                                </div>
                            </div>
                            </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    bolum_id: bolum_id,
                }

                let table_report='';
                $.post(baseurl + 'projebolumleri/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.item.name);
                    $('#butce').val(responses.item.butce);
                    $('#content').val(responses.item.exp);

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            bolum_id: bolum_id,
                            name:  $('#name').val(),
                            butce:  $('#butce').val(),
                            content:  $('#content').val(),
                            project:  "<?php echo $_GET['id'] ?>"
                        }
                        $.post(baseurl + 'projebolumleri/update',data,(response) => {
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


    $(document).on('click','.edit-asama',function (){
        let asama_id =$(this).attr('asama_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Aşama Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Bölümleri</label>
                                            <select class="form-control select-box" id="bolum_id" name="bolum">
                                                <?php foreach ($bolumler as $blm)
                {
                    $id=$blm['id'];
                    $name=$blm['name'];
                    echo "<option value='$id'>$name</option>";
                } ?>
                                            </select>
                                        </div>
                                               <div class="form-group col-md-12">
                                            <label for="name">Bağlı Olduğu Aşama</label>
                                            <select class="form-control select-box" id="parent_id" name="parent_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                     <div class="form-group col-md-6">
                                          <label for="name">Aşama Adı</label>
                                            <input type="text" class="form-control" id="name" placeholder="Elektrik İşleri">
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Cari</label>
                                               <select name="customer" class="form-control" id="customer_statement">
                                                    <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box" id="pers_id">
                                                    <?php foreach (all_personel() as $blm)
                {
                    $id=$blm->id;
                    $name=$blm->name;
                    echo "<option value='$id'>$name</option>";
                } ?>
                                                </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi">
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
                                         <div class="form-group col-md-4">
                                          <label for="name">Miktar</label>
                                           <input type="number" class="form-control" name="quantity" id="quantity" value="1">
                                        </div>
                                          <div class="form-group col-md-4">
                                          <label for="name">Birim Fiyatı</label>
                                            <input type="text" class="form-control" name="fiyat" id="fiyat" value="1">
                                        </div>
                                         <div class="form-group col-md-4">
                                          <label for="name">Toplam Fiyatı</label>
                                             <input type="text" class="form-control" name="toplam_fiyat" id="toplam_fiyat">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Bütçe</label>
                                             <input id="butce" name="butce" type="text" class="form-control">
                                        </div>
                                          <div class="form-group col-md-6">
                                          <label for="name">Açıklama</label>
                                            <input type="text" class="form-control" name="content" id="content">
                                        </div>

                                      </div>
                                    </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    asama_id: asama_id,
                }

                let table_report='';
                $.post(baseurl + 'projeasamalari/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.item.name);
                    $('#butce').val(responses.item.total);
                    $('#content').val(responses.item.exp);


                    $('#quantity').val(responses.item.quantity);
                    $('#fiyat').val(responses.item.fiyat);
                    $('#toplam_fiyat').val(responses.item.toplam);

                    $('#customer_statement').append(new Option(responses.customer_details.company, responses.customer_details.customer_id, true, true)).trigger('change');

                    $('#bolum_id').val(responses.item.bolum_id).select2().trigger('change')
                    $('#pers_id').val(responses.item.pers_id).select2().trigger('change')
                    $('#parent_id').val(responses.item.parent_id).select2().trigger('change')
                    $('#olcu_birimi').val(responses.item.olcu_birimi).select2().trigger('change')

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            asama_id: asama_id,
                            name:  $('#name').val(),
                            customer:  $('#customer_statement').val(),
                            content:  $('#content').val(),
                            bolum:  $('#bolum_id').val(),
                            parent_id:  $('#parent_id').val(),
                            pers_id:  $('#pers_id').val(),
                            butce:  $('#butce').val(),
                            olcu_birimi:  $('#olcu_birimi').val(),
                            quantity:  $('#quantity').val(),
                            fiyat:  $('#fiyat').val(),
                            toplam_fiyat:  $('#toplam_fiyat').val(),
                            project:  "<?php echo $_GET['id'] ?>"
                        }
                        $.post(baseurl + 'projeasamalari/update',data,(response) => {
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
                }
            },
            onContentReady: function () {


                $("#customer_statement").select2({
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


    })

    $(document).on('click','.edit-task',function (){
        let task_id =$(this).attr('task_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İş Kalemi Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
                                      <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Proje Aşamalar</label>
                                              <select name="milestone" class="form-control select-box" id="milestone_is">
                                              <option value='0'>Seçiniz</option>
                                                    <?php
                foreach ($milestones as $row) {
                    $cid = $row['id'];
                    $parent_id = $row['parent_id'];
                    $bolum_name=bolum_getir($row['bolum_id']);

                    if($parent_id!=0)
                    {
                        $title=$bolum_name.'-'.task_to_asama($parent_id).'-'.$row['name'];
                    }
                    else
                    {
                        $title=$row['name'].'-'.$bolum_name;
                    }

                    echo "<option value='$cid'>$title </option>";

                }
                ?>
                                                </select>
                                        </div>
                                               <div class="form-group col-md-12">
                                            <label for="name">İş Kalemi Adı</label>
                                             <input type="text" class="form-control" id="name_is" placeholder="Elektrik İşlerinin Görülmesi">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                          <div class="form-group col-md-6">
                                          <label for="name">Sorumlu Personel</label>
                                              <select class="form-control select-box" id="pers_id_is">
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
                                               <select name="customer" class="form-control" id="customer_statement_is">
                                                    <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                                                </select>

                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-12">
                                          <label for="content">Ölçü Birimi</label>
                                              <select name="olcu_birimi" class="form-control select-box" id="olcu_birimi_is">
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
                                           <input type="number" class="form-control" name="quantity_is" id="quantity_is" value="1">
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
                                            <input type="text" class="form-control" id="oran_is" value="100">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                         <div class="form-group col-md-6">
                                          <label for="name">Durum</label>
                                           <select name="status" class="form-control select-box" id="status_is">
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
                                            <input type="text" class="form-control" name="content_is" id="content_is">
                                        </div>

                                      </div>
                                    </form>`;
                let data = {
                    crsf_token: crsf_hash,
                    task_id: task_id,
                }

                let table_report='';
                $.post(baseurl + 'projeiskalemleri/get_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    $('#name_is').val(responses.item.name);
                    $('#content_is').val(responses.item.description);


                    $('#quantity_is').val(responses.item.quantity);
                    $('#oran_is').val(responses.item.oran);
                    $('#fiyat_is').val(responses.item.fiyat);
                    $('#toplam_fiyat_is').val(responses.item.toplam_fiyat);

                    $('#customer_statement_is').append(new Option(responses.customer_details.company, responses.customer_details.customer_id, true, true)).trigger('change');

                    $('#pers_id_is').val(responses.item.eid).select2().trigger('change')
                    $('#milestone_is').val(responses.item.asama_id).select2().trigger('change')
                    $('#status_is').val(responses.item.status).select2().trigger('change')
                    $('#olcu_birimi_is').val(responses.item.unit).select2().trigger('change')

                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            task_id: task_id,
                            name:  $('#name_is').val(),
                            customer:  $('#customer_statement_is').val(),
                            oran:  $('#oran_is').val(),
                            status:  $('#status_is').val(),
                            content:  $('#content_is').val(),
                            pers_id:  $('#pers_id_is').val(),
                            asama_id:  $('#milestone_is').val(),
                            quantity:  $('#quantity_is').val(),
                            fiyat:  $('#fiyat_is').val(),
                            toplam_fiyat:  $('#toplam_fiyat_is').val(),
                            olcu_birimi:  $('#olcu_birimi_is').val(),
                            project:  "<?php echo $_GET['id'] ?>"
                        }
                        $.post(baseurl + 'projeiskalemleri/update',data,(response) => {
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
                }
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


    })

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
                                $('#loading-box').removeClass('d-none');
                                let data =$("#update_form").serialize();
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
