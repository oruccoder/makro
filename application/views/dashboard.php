<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Kontrol Paneli</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            Anasayfa
        </div>
    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <?php if ($this->aauth->premission(39)->read) { ?>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="col-md-12 row">
                                <?php $active_users = aktif_personel_listesi(); ?>

                                <div class="<?php echo !empty($active_users) ? 'col-md-6 col-lg-6 col-sm-6' : 'col-md-12'; ?>">
                                    <div class="row">
                                        <div class="<?php echo !empty($active_users) ? 'col-xl-6' : 'col-xl-2'; ?> col-sm-6 col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a class="text-black" href="/salary/allbordro">
                                                        <div class="d-flex justify-content-between px-md-1">
                                                            <div class="align-self-center">
                                                                <i class="fas fa-users text-info fa-5x"></i>
                                                            </div>
                                                            <div class="text-end">
                                                                <p class="mb-0">Bordrolar</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo !empty($active_users) ? 'col-xl-6' : 'col-xl-2'; ?> col-sm-6 col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a class="text-black" href="/invoices">
                                                        <div class="d-flex justify-content-between px-md-1">
                                                            <div class="align-self-center">
                                                                <i class="fas fa-file text-success fa-5x"></i>
                                                            </div>
                                                            <div class="text-end">
                                                                <p class="mb-0">Faturalar</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo !empty($active_users) ? 'col-xl-6' : 'col-xl-2'; ?> col-sm-6 col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a class="text-black" href="/accounts">
                                                        <div class="d-flex justify-content-between px-md-1">
                                                            <div class="align-self-center">
                                                                <i class="fab fa-first-order text-danger fa-5x"></i>
                                                            </div>
                                                            <div class="text-end">
                                                                <p class="mb-0">Kasalar</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo !empty($active_users) ? 'col-xl-6' : 'col-xl-2'; ?> col-sm-6 col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a class="text-black" href="/projects">
                                                        <div class="d-flex justify-content-between px-md-1">
                                                            <div class="align-self-center">
                                                                <i class="fas fa-people-carry text-danger fa-5x"></i>
                                                            </div>
                                                            <div class="text-end">
                                                                <p class="mb-0">Projeler</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo !empty($active_users) ? 'col-xl-6' : 'col-xl-2'; ?> col-sm-6 col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a class="text-black" href="/reports/onaylananlar">
                                                        <div class="d-flex justify-content-between px-md-1">
                                                            <div class="align-self-center">
                                                                <i class="fas fa-search-location text-warning fa-5x"></i>
                                                            </div>
                                                            <div class="text-end">
                                                                <p class="mb-0">Ödeme Emri Verilenler</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo !empty($active_users) ? 'col-xl-6' : 'col-xl-2'; ?> col-sm-6 col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a class="text-black" href="/form/bekleyen_talepler">
                                                        <div class="d-flex justify-content-between px-md-1">
                                                            <div class="align-self-center">
                                                                <i class="fas fa-user-check text-info fa-5x"></i>
                                                            </div>
                                                            <div class="text-end">
                                                                <p class="mb-0">Bekleyen Talepler</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php if (!empty($active_users)): ?>
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <div class="row mt-1">
                                            <div class="col-xl-12 col-sm-12 col-12">
                                                <table class="table-bordered table">
                                                    <thead>
                                                    <tr>
                                                        <th>Proje</th>
                                                        <th>Aktif Personel Sayısı</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($active_users as $active_user): ?>
                                                        <?php
                                                        // Çalışan sayısına göre sınıf belirle
                                                        if ($active_user->user_count <= 15) {
                                                            $row_class = 'low-staff'; // Az çalışan
                                                            $animation_class = 'animate-low';
                                                        } elseif ($active_user->user_count <= 40) {
                                                            $row_class = 'medium-staff'; // İyi çalışan
                                                            $animation_class = 'animate-medium';
                                                        } else {
                                                            $row_class = 'high-staff'; // Yüksek çalışan
                                                            $animation_class = 'animate-high';
                                                        }
                                                        ?>
                                                        <tr class="<?php echo $row_class . ' ' . $animation_class; ?>">
                                                            <td><?php echo $active_user->project_name.' ('.$active_user->user_type.')'; ?></td>
                                                            <td><?php echo $active_user->user_count; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>



                <?php if($this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==61) { ?>
                <div class="card mobile_hidden">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                        <h3 class="text-warning" style="text-decoration: underline;text-align:center">Ödeme Bekleyen (Beta Sürüm)
                                        </h3>
                                        <?php
                                        $this->load->view('accounts/ozet');
                                        ?>
                                    </div>


                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php } ?>



                <div class="card mobile_hidden">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                        <h3 class="text-warning" style="text-decoration: underline;text-align:center">YARATDIĞINIZ / AÇDIĞINIZ MATERİAL SORĞU SİYAHISI
                                        </h3>
                                        <?php
                                        $this->load->view('malzematalep/all_list');
                                        ?>
                                    </div>


                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <?php if (izinli_personeller()) { ?>
                    <div class="card mobile_hidden">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <?php echo izinli_personeller() ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php if (lojistik_yuklemeleri(13)) { ?>
                    <div class="card mobile_hidden">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <?php echo lojistik_yuklemeleri(13) ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php if (lojistik_yuklemeleri(14)) { ?>
                    <div class="card mobile_hidden">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <?php echo lojistik_yuklemeleri(14) ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>


                <?php if (nakliye_depolar_arasi_transfer(1)) { ?>
                    <div class="card mobile_hidden">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <?php echo nakliye_depolar_arasi_transfer(1) ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php if (nakliye_depolar_arasi_transfer(2)) { ?>
                    <div class="card mobile_hidden">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <?php echo nakliye_depolar_arasi_transfer(2) ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php if ($this->aauth->premission(40)->read) { ?>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6 col-12 col-xs-12 mb-4">
                                        <h5 class="text-info" style="text-align:center">Gider Talepleri</h5>
                                        <div class="table-responsive">
                                            <table id="invoices_gider" class="table responsive" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Cari</th>
                                                    <th>Talep No</th>
                                                    <th>Proje Adı</th>
                                                    <th>Metod</th>
                                                    <th>Tutar</th>
                                                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-6 col-12 col-xs-12 mb-4">
                                        <h5 class="text-info" style="text-align:center">Avans Talepleri</h5>
                                        <div class="table-responsive">
                                            <table id="cari_avans" class="table responsive" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Cari</th>
                                                    <th>Talep No</th>
                                                    <th>Proje Adı</th>
                                                    <th>Metod</th>
                                                    <th>Tutar</th>
                                                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6 col-12 col-xs-12 mb-4">
                                        <h5 class="text-info" style="text-align:center">Personel Gider Talepleri</h5>
                                        <div class="table-responsive">
                                            <table id="personel_gider_talep" class="table responsive" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Perseonel</th>
                                                    <th>Talep No</th>
                                                    <th>Proje Adı</th>
                                                    <th>Metod</th>
                                                    <th>Tutar</th>
                                                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-6 col-12 col-xs-12 mb-4">
                                        <h5 class="text-info" style="text-align:center">Personel Maaş Talepleri</h5>
                                        <div class="table-responsive">
                                            <table id="personel_maas_talep" class="table responsive" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Perseonel</th>
                                                    <th>Talep No</th>
                                                    <th>Proje Adı</th>
                                                    <th>Metod</th>
                                                    <th>Tutar</th>
                                                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php } ?>

<!--                --><?php //if($this->aauth->premission(66)->read){
//                    ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6 col-12 col-xs-12 mb-4">
                                            <h5 class="text-info" style="text-align:center">Lojistik Talepleri</h5>
                                            <div class="table-responsive">
                                                <table id="lojistik_talep" class="table responsive" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tarih</th>
                                                        <th>Personel</th>
                                                        <th>Talep No</th>
                                                        <th>Durum</th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                    </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 col-12 col-xs-12 mb-4">
                                            <h5 class="text-info" style="text-align:center">LOjistik Satınalma Talepleri</h5>
                                            <div class="table-responsive">
                                                <table id="lojistik_satinalma_talep" class="table responsive" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tarih</th>
                                                        <th>Personel</th>
                                                        <th>Talep No</th>
                                                        <th>Tutar</th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                    </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
//                } ?>

                <?php if($this->aauth->premission(67)->read){
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                            <h5 class="text-info" style="text-align:center">Bekleyen Form2 Onayları</h5>
                                            <div class="table-responsive">
                                                <table id="forma2_list" class="table responsive" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Tarih</th>
                                                        <th>Tip</th>
                                                        <th>Muqavele No</th>
                                                        <th>Talep No</th>
                                                        <th>Cari</th>
                                                        <th>Tutar</th>
                                                        <th>Durum</th>
                                                        <th>Proje</th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                    </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
                <?php if($this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==39) {
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                            <h5 class="text-danger" style="text-align:center">Bekleyen Form2 İptal Talepleri</h5>
                                            <div class="table-responsive">
                                                <table id="forma2_list_iptal" class="table responsive" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Tarih</th>
                                                        <th>Muqavele No</th>
                                                        <th>Cari</th>
                                                        <th>Tutar</th>
                                                        <th>Durum</th>
                                                        <th>Proje</th>
                                                        <th>İptal Talep Eden Personel</th>
                                                        <th>İptal Açıklaması</th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                    </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
                <?php if ($this->aauth->premission(41)->read) { ?>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4" style="padding-bottom: 10px;width:100%;height:500px;overflow:auto;">
                                        <h5 class="text-info" style="text-align:center">Atama Bekleyen Talepler</h5>
                                        <table  class="table">
                                            <thead>
                                            <tr>

                                                <th>Form Tipi</th>
                                                <th>Talep Sayısı</th>
                                                <th>Toplam Bakiye</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $total_nakit=0;
                                            $total_banka=0;
                                            foreach (odeme_bekleyen_talepler_new(11) as $items){

                                                $total_nakit +=odeme_bekleyen_talepler_total($items->total_tip,11)['total_nakit_float'];
                                                $total_banka +=odeme_bekleyen_talepler_total($items->total_tip,11)['total_banka_float'];
                                                ?>

                                                <tr>
                                                    <td><a class="btn btn-success btn-sm" href="<?php echo $items->href?>"><?php echo $items->name ?></a></td>
                                                    <td><?php echo $items->sayi ?></td>
                                                    <td><?php echo odeme_bekleyen_talepler_total($items->total_tip,11)['total'] ?></td>
                                                </tr>
                                              <?php } ?>
                                            </tbody>
                                            <tfoot>

                                            <tr>
                                                <td colspan="2" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Nakit Bekleyen Ödeme</span></td>
                                                <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_nakit) ?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Banka Bekleyen Ödeme</span></td>
                                                <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_banka) ?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Toplam Bekleyen Ödeme</span></td>
                                                <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_banka+$total_nakit) ?></span></td>
                                            </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if ($this->aauth->premission(54)->read) { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4" style="padding-bottom: 10px;width:100%;height:500px;overflow:auto;">
                                            <h5 class="text-info" style="text-align:center">Ödeme Emri Verilenler</h5>
                                            <table  class="table">
                                                <thead>
                                                <tr>

                                                    <th>Form Tipi</th>
                                                    <th>Talep Sayısı</th>
                                                    <th>Toplam Bakiye</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                $total_nakit=0;
                                                $total_banka=0;
                                                foreach (odeme_bekleyen_talepler_new(12) as $items){

                                                    $total_nakit +=odeme_bekleyen_talepler_total($items->total_tip,12)['total_nakit_float'];
                                                    $total_banka +=odeme_bekleyen_talepler_total($items->total_tip,12)['total_banka_float'];
                                                    ?>

                                                    <tr>
                                                        <td><a class="btn btn-success btn-sm" href="<?php echo $items->href?>"><?php echo $items->name ?></a></td>
                                                        <td><?php echo $items->sayi ?></td>
                                                        <td><?php echo odeme_bekleyen_talepler_total($items->total_tip,12)['total'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <tfoot>

                                                <tr>
                                                    <td colspan="2" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Nakit Bekleyen Ödeme</span></td>
                                                    <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_nakit) ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Banka Bekleyen Ödeme</span></td>
                                                    <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_banka) ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Toplam Bekleyen Ödeme</span></td>
                                                    <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_banka+$total_nakit) ?></span></td>
                                                </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->aauth->premission(72)->read) { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4" style="padding-bottom: 10px;width:100%;height:500px;overflow:auto;">
                                            <h5 class="text-info" style="text-align:center">Atanmış Talepler</h5>
                                            <table  class="table">
                                                <thead>
                                                <tr>

                                                    <th>Personel</th>
                                                    <th>Talep Tipi</th>
                                                    <th>Talep Sayısı</th>
                                                    <th>Nakit Bakiye</th>
                                                    <th>Banka Bakiye</th>
                                                    <th>Toplam Bakiye</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                $total_nakit=0;
                                                $total_banka=0;
                                                foreach (atanmis_odemeleri() as $items){

                                                    $total_nakit += atanmis_odemeler_details($items->payment_personel_id,$items->tip)['total_nakit_float'];
                                                    $total_banka += atanmis_odemeler_details($items->payment_personel_id,$items->tip)['total_banka_float'];
                                                    ?>

                                                    <tr>
                                                        <td><?php echo personel_details($items->payment_personel_id) ?></td>
                                                        <td><?php echo $items->name ?></td>
                                                        <td><?php echo $items->sayi ?></td>
                                                        <td><?php echo amountFormat(atanmis_odemeler_details($items->payment_personel_id,$items->tip)['total_nakit_float']) ?></td>
                                                        <td><?php echo amountFormat(atanmis_odemeler_details($items->payment_personel_id,$items->tip)['total_banka_float']) ?></td>
                                                        <td><?php echo atanmis_odemeler_details($items->payment_personel_id,$items->tip)['total'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <tfoot>

                                                <tr>
                                                    <td colspan="5" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Nakit Bekleyen Ödeme</span></td>
                                                    <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_nakit) ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Banka Bekleyen Ödeme</span></td>
                                                    <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_banka) ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="border: none;"><span style="font-size: 18px;float: right;line-height: 38px;font-weight: 700;">Toplam Bekleyen Ödeme</span></td>
                                                    <td style="border: none;"><span style="font-size: 18px;float: left;line-height: 38px;font-weight: 700;"><?php echo amountFormat($total_banka+$total_nakit) ?></span></td>
                                                </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($this->aauth->premission(55)->read) { ?>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                        <h5 class="text-info" style="text-align:center">Onay Bekleyen Faturalar</h5>
                                        <a href="#pop_model_invoice" data-toggle="modal" data-remote="false"
                                           class="btn btn-warning btn-md" id="invoice_id_aktar" title="Change Status">Durum Güncelle</a>
                                        <table id="invoices_tables"  class="table responsive" style="width:100%">
                                            <thead>
                                            <tr>

                                                <th>#</th>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th><?php echo $this->lang->line('invoice_type') ?></th>
                                                <th>Fatura No</th>
                                                <th>Proje Adı</th>
                                                <th><?php echo $this->lang->line('Customer') ?></th>
                                                <th>Açıklama</th>
                                                <th>Esas Meblağ</th>
                                                <th>KDV</th>
                                                <th><?php echo $this->lang->line('Amount') ?></th>
                                                <th><?php echo $this->lang->line('Status') ?></th>
                                                <th>Alt Firma</th>
                                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($this->aauth->premission(81)->read) { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                            <h5 class="text-info" style="text-align:center">Bankaya İşlenmesi Bekleyen Qaimeler</h5>
<!--                                            <a href="#pop_model_invoice" data-toggle="modal" data-remote="false"-->
<!--                                               class="btn btn-warning btn-md" id="invoice_id_aktar" title="Change Status">Durum Güncelle</a>-->
                                            <table id="invoices_tables_bank"  class="table responsive" style="width:100%">
                                                <thead>
                                                <tr>

                                                    <th>#</th>
                                                    <th><?php echo $this->lang->line('Date') ?></th>
                                                    <th><?php echo $this->lang->line('invoice_type') ?></th>
                                                    <th>Fatura No</th>
                                                    <th>Proje Adı</th>
                                                    <th><?php echo $this->lang->line('Customer') ?></th>
                                                    <th>Açıklama</th>
                                                    <th>Esas Meblağ</th>
                                                    <th>KDV</th>
                                                    <th><?php echo $this->lang->line('Amount') ?></th>
                                                    <th><?php echo $this->lang->line('Status') ?></th>
                                                    <th>Alt Firma</th>
                                                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->aauth->premission(82)->read) { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                            <h5 class="text-info" style="text-align:center">Bankaya İşlenmesi Bekleyen Qaimeler</h5>
<!--                                            <a href="#pop_model_invoice" data-toggle="modal" data-remote="false"-->
<!--                                               class="btn btn-warning btn-md" id="invoice_id_aktar" title="Change Status">Durum Güncelle</a>-->
                                            <table id="invoices_tables_bank_"  class="table responsive" style="width:100%">
                                                <thead>
                                                <tr>

                                                    <th>#</th>
                                                    <th><?php echo $this->lang->line('Date') ?></th>
                                                    <th><?php echo $this->lang->line('invoice_type') ?></th>
                                                    <th>Fatura No</th>
                                                    <th>Proje Adı</th>
                                                    <th><?php echo $this->lang->line('Customer') ?></th>
                                                    <th>Açıklama</th>
                                                    <th>Esas Meblağ</th>
                                                    <th>KDV</th>
                                                    <th><?php echo $this->lang->line('Amount') ?></th>
                                                    <th><?php echo $this->lang->line('Status') ?></th>
                                                    <th>Alt Firma</th>
                                                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <div class="card mobile_hidden">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <?php if ($this->aauth->premission(43)->read) { ?>
                                    <div class="col-xl-4 col-sm-4 col-12 col-xs-12 mb-4">
                                        <div class="table-responsive">
                                            <table class="table text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th class="w-100 text-danger">Hareketler</th>
                                                    <th>Tip</th>
                                                    <th>Tutar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach (hareketler() as $hrk) {
                                                    if($hrk->invoice_type_id==3) //Tahsilat
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-primary rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">T</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">Tahsilat Yapıldı</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==4) //Ödeme
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-danger rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">Ö</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">Ödeme Yapıldı</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==14) //Avans
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-indigo rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">A</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">Avans Yapıldı</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==19) //KDV ÖDemesi
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-success rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">K</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">KDV Ödemesi Yapıldı</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==20) //Kdv Tah
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-primary rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">K</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">KDV Tahsilatı Yapıldı</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==25) //Kasa Avansı
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-danger rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">K</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">Kasa Avansı Verildi</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==27) //Virman
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-success rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">V</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">Kasalar Arası Virman-Gelen</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    else if($hrk->invoice_type_id==28) //Virman
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <a href="#" class="btn btn-success rounded-pill btn-icon btn-sm">
                                                                            <span class="letter-icon">V</span>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <a href="#" class="text-body font-weight-semibold letter-icon-title"><?php echo $hrk->payer?></a>
                                                                        <div class="text-muted font-size-sm"><i class="icon-checkmark3 font-size-sm mr-1"></i> <?php $list =  explode(" ",$hrk->notes); foreach ($list as $key => $value)  { echo $value.' '; { if($key == 8) { echo "<br>"; } } } ?></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-size-sm">Kasalar Arası Virman-Giden</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="font-weight-semibold mb-0"><?php echo amountFormat($hrk->total) ?></h6>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->aauth->premission(44)->read) { ?>
                                    <div class="col-xl-4 col-sm-4 col-12 col-xs-12 mb-4">
                                        <div class="table-responsive">
                                            <table  class="table text-nowrap">
                                                <thead>
                                                <tr>

                                                    <th class="w-100 text-danger">Son Alış Qaimeleri</th>
                                                    <th>Cari</th>
                                                    <th>Tutar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(last_invoice_list()){
                                                    foreach (last_invoice_list() as $odeme)
                                                    {
                                                        $invoice_no = $odeme->invoice_no;
                                                        $cari_name=$odeme->name;
                                                        $total=amountFormat($odeme->total*$odeme->kur_degeri);

                                                        ?>
                                                        <tr>
                                                            <td><?php echo "<a href='/invoices/view?id=$odeme->id' class='btn btn-info btn-sm'>$invoice_no</a>"; ?></td>
                                                            <td><?php echo $cari_name ?></td>
                                                            <td><?php echo $total ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>


                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($this->aauth->premission(45)->read) { ?>
                                    <div class="col-xl-4 col-sm-4 col-12 col-xs-12 mb-4">
                                        <div class="table-responsive">
                                            <table  class="table text-nowrap">
                                                <thead>
                                                <tr>

                                                    <th class="w-100 text-danger">İzin Talepleri</th>
                                                    <th>Form Tipi</th>
                                                    <th>Personel</th>
                                                    <th>Görüntüle</th>
                                                    <th>Kalan Mezuniyet Günü</th>
                                                    <th>Form Oluşturma Tarihi</th>
                                                    <th>3 Saatlik İzin Raporu</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(izinler()){
                                                    $i=0;
                                                    foreach (izinler() as $odeme)
                                                    {
                                                        $i++;
                                                        $tip='İzin Talebi';
                                                        $href='/employee/permissions_view?id='.$odeme->id;
                                                        $pers_name=personel_details_full($odeme->user_id)['name'];
                                                        $kontrol = izin_saat_kontrol($odeme->user_id);
                                                        $stle='';
                                                        $button='';

                                                        if($kontrol >= 3){
                                                            $date = new DateTime('now');
                                                            $m= $date->format('m');
                                                            $y= $date->format('Y');
                                                            $stle='style="background: red;color: white;"';
                                                            $button='<a href="/reports/personel_izin_raporu?user_name='.$pers_name.'&month='.$m.'&year='.$y.'" class="btn btn-info" target="_blank">İzin Raporuna Bak</a>';
                                                        }
                                                        ?>
                                                        <tr <?php echo $stle?> >
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $tip ?></td>
                                                            <td><?php echo $pers_name ?></td>
                                                            <td><?php echo '<button  type="button" data-id="'.$odeme->id.'" class="btn btn-success btn-sm permit_view">Görüntüle</button>&nbsp;'.$button?></td>
                                                            <td><?php echo  mezuniyet_report($odeme->user_id)['mezuniyet_kalan'];?></td>
                                                            <td><?php echo  $odeme->created_at;?></td>
                                                            <td><?php echo  saatlik_izin_rapor($odeme->user_id)?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>


                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php if ($this->aauth->premission(90)->read) { ?>
                <?php if (personel_cart_gecikmis()) { ?>
                        <div class="card mobile_hidden">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <section>
                                        <div class="row">
                                              <?php echo personel_cart_gecikmis() ?>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
                <?php if ($this->aauth->premission(46)->read) { ?>
                <div class="card mobile_hidden">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <?php
                                        $this->load->view('customer_meeting/index');
                                    ?>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>


                <?php } ?>
                <?php if(vorker_list_run()['status']) { ?>
                    <div class="card mobile_hidden">
                        <div class="card-body">
                            <div class="container-fluid">
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                            <h3 class="text-warning" style="text-decoration: underline;text-align:center">Aktif Fehle Listesi</h3>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>İş Kodu</th>
                                                    <th>Adı</th>
                                                    <th>Proje</th>
                                                    <th>Oluşturan Personel</th>
                                                    <th>Çalışma Bilgileri</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach (vorker_list_run()['details'] as $worker_items) { ?>
                                                    <tr>
                                                        <td><?php echo $worker_items->code;?></td>
                                                        <td><?php echo worker_details($worker_items->pers_id)->name;?></td>
                                                        <td><?php echo proje_code($worker_items->proje_id)?></td>
                                                        <td><?php echo personel_detailsa($worker_items->aauth_id)['name']?></td>
                                                        <td>
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td>Çalışma Tipi</td>
                                                                    <td>Çalışma Miktarı</td>
                                                                    <td>Birim Fiyatı</td>
                                                                    <td>Toplam Fiyat</td>
                                                                    <td>Çalıştığı Gün</td>
                                                                    <td>Şantiye Giriş Saati</td>
                                                                    <td>Şantiye Çıkış Saati</td>
                                                                    <td>Durum</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <th><?php if($worker_items->tip==1) {echo "Günlük";} else { echo "Saatlik";}?></th>
                                                                    <th><?php  echo amountFormat_s($worker_items->miktar).' '.units_($worker_items->birim)['name']?></th>
                                                                    <th><?php  echo amountFormat($worker_items->birim_fiyati)?></th>
                                                                    <th><?php  $total = floatval($worker_items->birim_fiyati) * floatval($worker_items->miktar); echo amountFormat($total)?></th>
                                                                    <th><?php  echo $worker_items->calisma_gunu?></th>
                                                                    <th><?php  echo $worker_items->giris_saati?></th>
                                                                    <th><?php  echo $worker_items->cikis_saati?></th>
                                                                    <th><?php  echo work_item_status($worker_items->id,$worker_items->status)?></th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php  } ?>
                                                </tbody>
                                            </table>

                                        </div>


                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                <?php if ($this->aauth->premission(56)->read) { ?>
                    <div class="card mobile_hidden">
                        <?php
                        $this->load->view('notification/index');
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</div>

<style>/* Renkler */
    .low-staff {
        background-color: #ffdddd; /* Kırmızımsı */
        color: #d9534f;
    }

    .medium-staff {
        background-color: #fff7cc; /* Sarımsı */
        color: #f0ad4e;
    }

    .high-staff {
        background-color: #ddffdd; /* Yeşilimsi */
        color: #5cb85c;
    }

    /* Animasyonlar */
    @keyframes blink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-low {
        animation: blink 1.5s infinite;
    }

    .animate-medium {
        animation: blink 2s infinite;
    }

    .animate-high {
        animation: blink 2.5s infinite;
    }

    /* Renkler */
    .low-staff {
        background-color: #ffdddd; /* Kırmızımsı */
        color: #d9534f;
    }

    .medium-staff {
        background-color: #fff7cc; /* Sarımsı */
        color: #f0ad4e;
    }

    .high-staff {
        background-color: #ddffdd; /* Yeşilimsi */
        color: #5cb85c;
    }

    /* Animasyonlar */
    @keyframes blink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-low {
        animation: blink 1.5s infinite;
    }

    .animate-medium {
        animation: blink 2s infinite;
    }

    .animate-high {
        animation: blink 2.5s infinite;
    }


    /*.table th, .table td { max-width: 100px; min-width: 70px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }*/

    @media
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        .mobile_hidden{
            display:none;
        }
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr { border: 1px solid #ccc; }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }
</style>
<script>

    $(document).on('click','.talep_bildirimi_gonder',function (){
        let pers_id = $(this).attr('pers_id');
        let talep_type = $(this).attr('talep_type');
        let baslik='';
        let code= $(this).attr('code');
        let content_message='';
        if(talep_type=='cari_gider'){
            baslik='Cari Gider Talebi İçin Mail Bildirimi!'
            content_message=' Lütfen Onayınızda Bekleyen '+code+' olan Cari Gider Talebini Onaylayınız';
        }
        else if(talep_type=='cari_avans'){
            baslik='Cari Avans Talebi İçin Mail Bildirimi!'
            content_message=' Lütfen Onayınızda Bekleyen '+code+' olan Cari Avans Talebini Onaylayınız';
        }
        else if(talep_type=='mt_talep'){
            baslik='Malzeme Talebi İçin Mail Bildirimi!'
            content_message=' Lütfen Onayınızda Bekleyen '+code+' olan Malzeme Talebini Onaylayınız';
        }

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: baslik,
            icon: 'fa fa-envelope',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<input value="'+content_message+'" class="content_message form-control"><p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Mail Bildirimi Yap',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            pers_id: pers_id,
                            baslik: baslik,
                            content_message: $('.content_message').val(),
                        }
                        $.post(baseurl + 'malzemetalep/dashboard_mail',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.messages,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: responses.messages,
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

    $(document).on('click','.permit_view',function (){
        let id = $(this).data('id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: false,
            icon: false,
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function (){
                let self = this;
                let html = `<form>
                            <div class="row">
                            <div class='card col-md-6'>
                            <ul class="list-group list-izinler" style="text-align: justify;font-size: 15px;">
                            </ul>
                            </div>
                               <div class="card col-md-6">
									  <ul class="list-group list-group-flush" style="text-align: justify;font-size: 15px;">
										<li class="list-group-item"><b>Proje : </b>&nbsp;<span id="proje"></span></li>
										<li class="list-group-item"><b>Vazife : </b>&nbsp;<span id="vazife"></span></li>
										<li class="list-group-item"><b>Personel : </b>&nbsp;<span id="pers_name"></span></li>
										<li class="list-group-item"><b>Başlangıç T : </b>&nbsp;<span id="start_date"></span></li>
										<li class="list-group-item"><b>Bitiş T. : </b>&nbsp;<span id="end_date"></span></li>
										<li class="list-group-item"><b>Sebep : </b>&nbsp;<span id="description"></span></li>
									  </ul>

                                </div>
<div class="form-group col-md-12">
                                                  <label for="name">Talep Edilen İzin Türü</label>
                                                  <select class="form-control permit_type required" id="permit_type">
                                                            <?php foreach (user_permit_type() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                </div>
									</div>
                            </div>
</form>


                           `;

                let data = {
                    id: id,
                }
                $.post(baseurl + 'personelaction/permit_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $('#proje').empty().text(responses.proje);
                    $('#vazife').empty().text(responses.user_role);
                    $('#pers_name').empty().text(responses.user_name);
                    $('#start_date').empty().text(responses.item.start_date);
                    $('#end_date').empty().text(responses.item.end_date);
                    $('#description').empty().text(responses.item.description);
                    $('#permit_type').val(responses.item.permit_type);

                    $('#text').empty().text('Açıklama : '+responses.details_permit.description)
                    let li = '';
                    $.each(responses.details_permit, function (index, item) {

                        let durum = 'Bekliyor';
                        let desc = '';
                        if (item.staff_status == 1) {
                            durum = '<span style="font-weight: bold">Onaylandı </span>| '+ item.staff_desc;
                        } else if (item.staff_status == 2) {
                            durum = 'İptal Edildi';
                            desc = `<li>` + item.staff_desc + `</li>`;
                        }
                        li += `<li class="list-group-item">` + item.sort + `. Personel Adı : &nbsp;` + item.name + `</li><ul><li>` + durum + `</li>` + desc + `</ul>`;

                    });
                    $('.list-izinler').empty().append(li);




                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        let permit_type = $('#permit_type').val();
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-question',
                            type: 'green',
                            closeIcon: true,
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Açıklama',
                            content: "<input class='desc form-control' placeholder='İnceledim Onaylıyorum'>",
                            buttons:{
                                prev: {
                                    text: 'Durum Bildir',
                                    btnClass: "btn btn-success",
                                    action: function () {

                                        let placeholder = this.$content.find('.desc').attr('placeholder');
                                        let value = this.$content.find('.desc').val();
                                        if (value.length == 0) {
                                            value = placeholder;
                                        }

                                        $('#loading-box').removeClass('d-none');
                                        let data_post = {
                                            confirm_id: id,
                                            permit_type: permit_type,
                                            status: 1,
                                            desc: value,
                                        }
                                        $.post(baseurl + 'personelaction/user_permit_update',data_post,(response)=>{
                                            let data = jQuery.parseJSON(response);
                                            if(data.status==200){
                                                $('#loading-box').addClass('d-none');
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: data.message,
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                            action: function () {
                                                                window.location.reload();
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
                                                    content: data.message,
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
                            }
                        });


                    }
                },
                cancel: {
                    text: 'İptal Et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-question',
                            type: 'green',
                            closeIcon: true,
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Açıklama',
                            content: "<input class='desc form-control' placeholder='iptal sebebi'>",
                            buttons:{
                                prev: {
                                    text: 'Durum Bildir',
                                    btnClass: "btn btn-success",
                                    action: function () {

                                        let desct=$('.desc').val();
                                        if(!desct){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Açıklama Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        else {
                                            $('#loading-box').removeClass('d-none');
                                        }

                                        let data_post = {
                                            confirm_id: id,
                                            status: 2,
                                            desc: $('.desc').val()
                                        }
                                        $.post(baseurl + 'personelaction/user_permit_update',data_post,(response)=>{
                                            let data = jQuery.parseJSON(response);
                                            if(data.status==200){
                                                $('#loading-box').addClass('d-none');
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: data.message,
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                            action: function () {
                                                                window.location.reload();
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
                                                    content: data.message,
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
                            }
                        });

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

    $(document).on('click', "#invoice_id_aktar", function (e) {
        var array = [];

        var array = [];
        $(".invoice_ids:checked").map(function(){
            array.push($(this).val());
        });

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: false,
            icon: false,
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form>

									  <div class="form-group col-md-12">
                                                  <label for="name">Durum Bildirme</label>
                                                  <select name="status" class="form-control mb-1" id="status">
                                                    <option value="6">Bankaya İşle</option>
                                                    <option value="10">Ödeme Yap</option>
                                                    <option value="9">Acil Ödeme</option>
                                                    <option value="1">Beklet</option>
                                                </select>
                                        </div>

</form>


                           `,
            buttons: {
                formSubmit: {
                    text: 'Onayla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data_post = {
                            array: array,
                            status: $('#status').val(),
                        }
                        $.post(baseurl + 'invoices/update_status_toplu_dashboard',data_post,(response)=>{
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function () {
                                                window.location.reload();
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
                                    content: data.message,
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
                    text: 'İptal Et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-question',
                            type: 'green',
                            closeIcon: true,
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Açıklama',
                            content: "<input class='desc form-control' placeholder='iptal sebebi'>",
                            buttons:{
                                prev: {
                                    text: 'Durum Bildir',
                                    btnClass: "btn btn-success",
                                    action: function () {

                                        let desct=$('.desc').val();
                                        if(!desct){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Açıklama Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        else {
                                            $('#loading-box').removeClass('d-none');
                                        }

                                        let data_post = {
                                            confirm_id: id,
                                            status: 2,
                                            desc: $('.desc').val()
                                        }
                                        $.post(baseurl + 'personelaction/user_permit_update',data_post,(response)=>{
                                            let data = jQuery.parseJSON(response);
                                            if(data.status==200){
                                                $('#loading-box').addClass('d-none');
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Başarılı',
                                                    content: data.message,
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                            action: function () {
                                                                window.location.reload();
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
                                                    content: data.message,
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
                            }
                        });

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


    $(document).on('change','.all_lojistik_yukleme',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_lojistik_yukleme').prop('checked',true)
        }
        else {
            $('.one_lojistik_yukleme').prop('checked',false)
        }
    })



    //nakliye talep id ve talep form product ıd ile gönderip statusu 14 yapacağım
    $(document).on('click','.islem_bitir_nakliye13',function(){

        let checked_count = $('.one_lojistik_yukleme:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }


        let lojistik_details=[];

        $('.one_lojistik_yukleme:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            lojistik_details.push({
                talep_form_product_id:$(item).attr('talep_form_product_id'),
                nakliye_id:$(item).attr('nakliye_id'),
            })
        });

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Yükleme Bitir',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,

            content: '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Müəyyən edilmiş Miqdarı Yük Maşına Yüklədiyinizə Əminsinizmi?<p/>'+
                '</div>'+
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Bitir',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            lojistik_details: lojistik_details,
                            type: 'yukleme',
                        }
                        $.post(baseurl + 'nakliye/dashboard_nakiye_item_status_change',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
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
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
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
    $(document).on('click','.islem_bitir_nakliye14',function(){

        let checked_count = $('.one_lojistik_yukleme:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }


        let lojistik_details=[];

        $('.one_lojistik_yukleme:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            lojistik_details.push({
                talep_form_product_id:$(item).attr('talep_form_product_id'),
                nakliye_id:$(item).attr('nakliye_id'),
            })
        });

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Yükleme Bitir',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,

            content: '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Müəyyən edilmiş Miqdarı Depoya Aldığınızdan Əminsinizmi?<p/>'+
                '</div>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Bitir',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            lojistik_details: lojistik_details,
                            type: 'tehvil',
                        }
                        $.post(baseurl + 'nakliye/dashboard_nakiye_item_status_change',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
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
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
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

    $(document).on('click','.add_arac_product_button13',function (){


        let checked_count = $('.one_lojistik_yukleme:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }

       let lojistik_details=[];

        $('.one_lojistik_yukleme:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            lojistik_details.push({
                talep_form_product_id:$(item).attr('talep_form_product_id'),
                nakliye_id:$(item).attr('nakliye_id'),
                miktar:$('.item_qty_values').eq(eq).val()
            })
        });

        let eq =$(this).parent().parent().index()
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Yükleme',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,

            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Müəyyən edilmiş Miqdarı Yük Maşına Yüklədiyinizə Əminsinizmi?<p/>'+
                    '</div><div>' +
                    '<select class="form-control" id="nakliye_item_id"></select>'
                    '</div>'
                    '</form>';

                let data = {
                     lojistik_details: lojistik_details
                }
                $.post(baseurl + 'nakliye/dashboard_nakliye_item',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $("#nakliye_item_id option").remove();
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        responses.items.forEach((item_,index) => {
                            $('#nakliye_item_id').append(new Option(item_.arac_name+' | '+item_.code+' | '+item_.plaka, item_.id, false, false)).trigger('change');
                        })
                    }

                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Yükle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            lojistik_details: lojistik_details,
                            nakliye_item_id : $('#nakliye_item_id').val()
                        }
                        $.post(baseurl + 'nakliye/add_arac_product',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
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
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
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
    $(document).on('click','.add_arac_product_button14',function (){


        let checked_count = $('.one_lojistik_yukleme:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Ürün Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }

        let lojistik_details=[];

        $('.one_lojistik_yukleme:checked').each((index,item) => {
            let eq = $(item).attr('eq');
            lojistik_details.push({
                talep_form_product_id:$(item).attr('talep_form_product_id'),
                nakliye_id:$(item).attr('nakliye_id'),
                miktar:$('.item_qty_values').eq(eq).val()
            })
        });

        let eq =$(this).parent().parent().index()
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Yükleme',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+=`<form action="" class="formName">
                    <div class="form-group">
                     <p>Müəyyən edilmiş Miqdarı Anbarda saxlamağınızdan əminsiniz mi??<p/>
                    </div>
 <div class="form-group">
                    <lable>Anbar</lable>
                    <select id="warehouse_select"  class="form-control select-box warehouse_select">
                        <option value='0'>Anbar Seçin</option>
                        <?php
                foreach (all_warehouse($this->aauth->get_user()->id) as $item) {
                    echo "<option data-name='$item->title' value='$item->id'>$item->title</option>";
                }
                ?>
                    </select>
                </div>
                    <div>
                    <select class="form-control" id="nakliye_item_id"></select>
                </div>
                </form>`;

                let data = {
                    lojistik_details: lojistik_details
                }
                $.post(baseurl + 'nakliye/dashboard_nakliye_item',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $("#nakliye_item_id option").remove();
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        responses.items.forEach((item_,index) => {
                            $('#nakliye_item_id').append(new Option(item_.arac_name+' | '+item_.code+' | '+item_.plaka, item_.id, false, false)).trigger('change');
                        })
                    }

                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Yükle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            lojistik_details: lojistik_details,
                            warehouse_select: $('#warehouse_select').val(),
                            nakliye_item_id: $('#nakliye_item_id').val(),
                        }
                        $.post(baseurl + 'nakliye/add_arac_product_stock',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
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
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
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
    function amount_max(element){
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }

    $(document).on('click','.one_nakliye_transfer',function (){
        let table_product_id_ar=[];
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let warehouse_id = $(this).attr('warehouse_id');
        let onay_id = $(this).attr('onay_id');
        let tip = $(this).attr('tip');
        let nakliye_talep_transfer_item_id = $(this).attr('nakliye_talep_transfer_item_id');

        if(tip==1){
            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Araç Yükleme Fişi',
                icon: 'fa fa-external-link-square-alt 3x',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-8 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: `<form>
                        <div class="row col-md-12">
                            <div class="col-md-8">
                                  <lable>Məhsul</lable>
                                  <select id="product" class="form-control product"></select>
                            </div>
                            <div class="col-md-1 mt-2">
                                <button type="button" id="add-product" warehouse_id="`+warehouse_id+`" class="btn btn-primary mt-2 ">Ekle</buttton>
                          </div>
                        </div>

                     </form>
                     <p class="test"></p>
                      <table id="result" class="table ">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Mehsul</th>
                              <th scope="col">Varyasyon</th>
                              <th scope="col">Güncel Stok Miqdarı</th>
                              <th scope="col">Olcu vahidi</th>
                              <th scope="col">Miqdar</th>
                              <th scope="col">Aciqlama</th>
                              <th scope="col">Sil</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                   `,
                buttons: {

                    formSubmit: {
                        text: 'Gondər',
                        btnClass: 'btn-blue',
                        action: function () {
                            let count = $('.result-row').length;
                            let collection = [];

                            for(let i=0;i<count;i++){
                                let data = {
                                    unit_id: $('.line_unit_id').eq(i).val(),
                                    option_id: $('.result-row').eq(i).data('option-id'),
                                    value_id: $('.result-row').eq(i).data('option-value-id'),
                                    fis_type: $('.result-row').eq(i).data('fis_type'),
                                    warehouse_id: $('.result-row').eq(i).data('warehouse_id'),
                                    product_id: $('.result-row').eq(i).data('product_id'),
                                    product_stock_code_id: $('.result-row').eq(i).data('product_stock_code_id'),
                                    qty: $('.result-row .qty').eq(i).val(),
                                    desc: $('.result-row .desc').eq(i).val(),
                                }

                                collection.push(data)
                            }

                            let data_post = {
                                collection: collection,
                                nakliye_item_id: nakliye_item_id,
                                onay_id: onay_id,
                                tip: tip,
                                nakliye_talep_transfer_item_id: nakliye_talep_transfer_item_id,
                                warehouse_id: warehouse_id,
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'nakliye/transfer_arac_add',data_post,(response)=>{
                                let data = jQuery.parseJSON(response);
                                if(data.status==200){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: data.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });

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
                                        content: data.message,
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
                        text: 'İmtina et',
                        btnClass: "btn btn-danger btn-sm",
                        action:function (){
                            table_product_id_ar = [];
                        }
                    }
                },
                onContentReady: function () {

                    $('.product').select2({
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
                                    warehouse_id: $('#warehouse').val(),
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

                    $('.warehouse').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })
                    $('.project').select2({
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
        }
        else {
            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Tehvil Al',
                icon: 'fa fa-eye 3x',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-8 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: `
                     <p class="test"></p>
                      <table id="result" class="table ">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Anbar</th>
                              <th scope="col">Yükleme Zamanı</th>
                              <th scope="col">Yükleme Yapan Personel</th>
                              <th scope="col">Mehsul</th>
                              <th scope="col">Varyasyon</th>
                              <th scope="col">Aciqlama</th>
                              <th scope="col">Yüklenen Miqdar</th>
                              <th scope="col">Tehvil Miqdarı</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                   `,
                buttons: {
                    formSubmit: {
                        text: 'Tehvil İşlemini Gerçekleştir',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');

                            let tehvil_details = [];
                            let count = $('.tehvil_qty').length;
                            for (let k = 0; k < count; k++){
                                tehvil_details.push({
                                    'tehvil_qty':$('.tehvil_qty').eq(k).val(),
                                    'nakliye_talep_transfer_arac_id':$('.tehvil_qty').eq(k).attr('nakliye_talep_transfer_arac_id')
                                })
                            }

                            let data = {
                                nakliye_item_id: nakliye_item_id,
                                nakliye_talep_transfer_item_id: nakliye_talep_transfer_item_id,
                                onay_id: onay_id,
                                tip: tip,
                                tehvil_details: tehvil_details,
                            }
                            $.post(baseurl + 'nakliye/transfer_tehvil',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status==200){
                                    $('#loading-box').addClass('d-none');
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-chechk',
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
                                                action:function (){
                                                    location.reload();
                                                }
                                            }
                                        }
                                    });
                                }
                                else {
                                    $('#loading-box').addClass('d-none');
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
                                }

                            });

                        }
                    },
                    cancel: {
                        text: 'İmtina et',
                        btnClass: "btn btn-danger btn-sm",
                        action:function (){
                            table_product_id_ar = [];
                        }
                    }
                },
                onContentReady: function () {
                    let data = {
                        nakliye_item_id: nakliye_item_id,
                    }
                    $.post(baseurl + 'nakliye/arac_warehouse_view',data,(response)=>{
                        let responses = jQuery.parseJSON(response);
                        if(responses.status==200){
                            $('#loading-box').addClass('d-none');


                            let j=1;
                            let html="";
                            $.each(responses.items, function (index, item_Value) {
                                html+=`<tr id="remove`+item_Value.id+`">`;
                                html+=`<td>`+j+`</td>`;
                                html+=`<td>`+item_Value.anbar+`</td>`;
                                html+=`<td>`+item_Value.yukleme_zamani+`</td>`;
                                html+=`<td>`+item_Value.yukleme_yapan_personel+`</td>`;
                                html+=`<td>`+item_Value.product_name+`</td>`;
                                html+=`<td>`+item_Value.varyasyon+`</td>`;
                                html+=`<td>`+isEmpty(item_Value.aciklama)+`</td>`;
                                html+=`<td>`+item_Value.miqdar+`</td>`;
                                html+=`<td><input type="number" max="`+item_Value.max_qty+`" nakliye_talep_transfer_arac_id="`+item_Value.nakliye_talep_transfer_arac_id+`" value="`+item_Value.max_qty+`" class="form-control tehvil_qty" onkeyup="amount_max(this)"> </td>`;
                                html+=`</tr>`;
                                j++;
                            })


                            $('#result tbody').empty().append(html);
                        }
                        else {
                            $('#loading-box').addClass('d-none');
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
                        }

                    });
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


    })
    let i =0;
    let table_product_id_ar = [];
    $(document).on('click','#add-product',function(){


        let product_id = $("#product").val();
        let warehouse = $(this).attr('warehouse_id');
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
                                    'stock_code_id':$(item).attr('stock_code_id'),
                                })
                            });
                        }
                        else {


                        }
                        i++;
                        let proje_name = '-';
                        if($("#project").find(':selected').data('name')!==undefined){
                            proje_name = $("#project").find(':selected').data('name');
                        }
                        let data_post = {
                            crsf_token: crsf_hash,
                            id: product_id,
                            warehouse:warehouse,
                            option_details:option_details
                        }
                        let data='';
                        let result=false;
                        let sayi=0;
                        $.post(baseurl + 'stockio/get_warehouse_products_',data_post,(response)=> {
                            let data_res = jQuery.parseJSON(response);

                            let units = '<select class="form-control select-box line_unit_id">';
                            data_res.units.forEach((item,index) => {
                                units+=`<option value="`+item.id+`">`+item.name+`</option>`;
                            })
                            units+='</select>';

                            if (data_res.code == 200) {
                                data = {
                                    qty:          data_res.result.qty,
                                    unit_id:      data_res.result.unit_id,
                                    unit_name:    data_res.result.unit_name,
                                    warehouse_id: warehouse,
                                    product_id:   data_res.result.product_id,
                                    varyasyon_name:   data_res.result.varyasyon_name,
                                    product_stock_code_id:   data_res.result.product_stock_code_id,
                                    product_name: data_res.result.product_name,
                                    option_details: option_details

                                }

                                if(!result){
                                    let varyasyon_html='';
                                    let option_id_data='';
                                    let product_stock_code_id=0;
                                    let option_value_id_data='';
                                    if(data.product_stock_code_id){
                                        product_stock_code_id = option_details[0].product_stock_code_id;
                                    }

                                    $("#result>tbody").append('<tr ' +
                                        'data-product_stock_code_id="'+data_res.result.product_stock_code_id+'" data-option-id="'+option_id_data+'" data-option-value-id="'+option_value_id_data+'" data-unit_id="'+data.unit_id+'"  data-warehouse_id="'+data.warehouse_id+'" data-product_id="'+data.product_id+'"  id="remove'+i+'" class="result-row">' +
                                        '<td>'+i+'</td> ' +
                                        '<td>'+ data.product_name +'</td>' +
                                        '<td>'+ data.varyasyon_name +'</td>' +
                                        '<td>'+data.qty+'</td>' +
                                        '<td>'+units+'</td>' +
                                        '<td> <input type="number" class="form-control qty" onkeyup="amount_max(this)" max="'+data.qty+'"  value="0"></td>' +
                                        '<td> <input type="text" class="form-control desc "  ></td>' +
                                        '<td> <button data-id="'+i+'" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                                        '</tr>' );
                                    setTimeout(function() {
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm")
                                        })
                                    }, 1000);
                                    table_product_id_ar.push({
                                        product_id : data.product_id,
                                        product_options:data.option_details,
                                        product_stock_code_id:data.product_stock_code_id,
                                    });
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
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm")
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

    $(document).on('click','.item_transfer_new_delete',function (){
        let n_t_id = $(this).attr('nakliye_talep_transfer_id');
        let stock_id = $(this).attr('stock_id');

        let data = {
            stock_id: stock_id,
            id: n_t_id,
        }
        $.post(baseurl + 'nakliye/delete_arac_item_stock',data,(response)=>{
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
                    title: 'Dikkat!',
                    content: responses.messages,
                    buttons:{
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
                let remove = '#remove'+ n_t_id;
                $(remove).remove();
            }
            else {
                $('#loading-box').addClass('d-none');
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "small",
                    title: 'Dikkat!',
                    content: responses.messages,
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

    $(document).on('click','.remove' ,function(){
        let remove = '#remove'+ $(this).data('id')
        $(remove).remove();
    })

    $(document).on('click','.transfer_finish',function (){

        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let nakliye_talep_transfer_item_id = $(this).attr('nakliye_talep_transfer_item_id');
        let onay_id = $(this).attr('onay_id');
        let tip = $(this).attr('tip');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Ürün Yükleme Bitir',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,

            content: '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Müəyyən edilmiş Miqdarı Yük Maşına Yüklədiyinizə Əminsinizmi?<p/>'+
                '</div>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Bitir',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            nakliye_item_id: nakliye_item_id,
                            nakliye_talep_transfer_item_id: nakliye_talep_transfer_item_id,
                            onay_id: onay_id,
                            tip: tip,
                        }
                        $.post(baseurl + 'nakliye/transfer_finish',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
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
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
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


    $(document).on('click','.transfer_arac_view',function (){
        let nakliye_item_id = $(this).attr('nakliye_item_id');
        let warehouse_id = $(this).attr('warehouse_id');
        let onay_id = $(this).attr('onay_id');
        let tip = $(this).attr('tip');
        let nakliye_talep_transfer_item_id = $(this).attr('nakliye_talep_transfer_item_id');

        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Araç İçi Görüntüle',
            icon: 'fa fa-eye 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
                     <p class="test"></p>
                      <table id="result" class="table ">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Anbar</th>
                              <th scope="col">Yükleme Zamanı</th>
                              <th scope="col">Yükleme Yapan Personel</th>
                              <th scope="col">Mehsul</th>
                              <th scope="col">Varyasyon</th>
                              <th scope="col">Araçta Bulunan Miqdarı</th>
                              <th scope="col">Aciqlama</th>
                              <th scope="col">işlem</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                   `,
            buttons: {
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function () {
                let data = {
                    nakliye_item_id: nakliye_item_id,
                }
                $.post(baseurl + 'nakliye/arac_warehouse_view',data,(response)=>{
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $('#loading-box').addClass('d-none');


                        let j=1;
                        let html="";
                        $.each(responses.items, function (index, item_Value) {
                            html+=`<tr id="remove`+item_Value.id+`">`;
                            html+=`<td>`+j+`</td>`;
                            html+=`<td>`+item_Value.anbar+`</td>`;
                            html+=`<td>`+item_Value.yukleme_zamani+`</td>`;
                            html+=`<td>`+item_Value.yukleme_yapan_personel+`</td>`;
                            html+=`<td>`+item_Value.product_name+`</td>`;
                            html+=`<td>`+item_Value.varyasyon+`</td>`;
                            html+=`<td>`+item_Value.new_miqdar+`</td>`;
                            html+=`<td>`+isEmpty(item_Value.aciklama)+`</td>`;
                            html+=`<td><button class="btn btn-danger item_transfer_new_delete" nakliye_talep_transfer_id="`+item_Value.id+`" stock_id="`+item_Value.stok_id+`"><i class="fa fa-trash"></i></button></td>`;
                            html+=`</tr>`;
                            j++;
                        })


                    $('#result tbody').empty().append(html);
                    }
                    else {
                        $('#loading-box').addClass('d-none');
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
                    }

                });
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

    function isEmpty(value) {
        let deger =  (value == null || (typeof value === "string" && value.trim().length === 0));
        if(deger){
            return "";
        }
        else {

            return value;
        }
    }

</script>
<script src="<?= base_url().'assets/js/dashboard.js?v='.rand(11111,99999)?>"></script>

