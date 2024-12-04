<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Personel Kartı</span></h4>
            <a type="button" href="#" class="header-elements-toggle text-body d-lg-none menu-right"><i class="icon-more"></i></a>

        </div>

    </div>
</div>
<script>
    $('.menu-right').click(function(){

        $('#menu-right').removeClass('d-none');
        $('#menu-right').toggleClass('active')
    })
</script>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="d-lg-flex align-items-lg-start">
                    <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-none sidebar-expand-lg profil_sidebar">
                        <div class="sidebar-content">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-img-actions d-inline-block mb-3">
                                        <img class="img-fluid rounded-circle" id="profile_images"
                                             src="<?php echo base_url('userfiles/employee/' . pesonel_picture_url($details->id)); ?>"
                                             width="170" height="170" alt="">

                                    </div>

                                    <h6 class="font-weight-semibold mb-0"><?php echo $details->name; ?></h6>
                                    <span class="d-block opacity-75"><?php echo role_name($users_details->roleid)['name']; ?></span>
                                    <h6 class="font-weight-semibold mb-0">
                                        <div class="rating">
                                            <div class="rating-upper" style="width: 0%">
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                            </div>
                                            <div class="rating-lower">
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                            </div>
                                        </div>
                                        <?php if (isset($point_value['result'])){
                                            echo '<p>'.$point_value['result'].' %</p>
                                                <a href="#" class="nav-link" id="base-tab9" data-toggle="tab">aylik degerlendirme raporu <br>'.$date=explode(" ",$point_value['created_at'])[0].'</a>';

                                        }
                                        else
                                        {
                                            echo "<p>".$point_value['not_found']."</p>";
                                        }
                                        ?>

                                    </h6>
                                </div>

                                <ul class="nav nav-sidebar">
                                    <li class="nav-item">
                                        <a href="#profile" class="nav-link active" id="base-tab2" data-toggle="tab">
                                            <i class="icon-user"></i>
                                            Personel Kart Bilgileri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#hesap_ekstresi" class="nav-link" id="base-tab3" data-toggle="tab">
                                            <i class="fa fa-list"></i>
                                            Hesap Ekstresi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#raziekstesi" class="nav-link" id="base-tab9" data-toggle="tab">
                                            <i class="fa fa-list"></i>
                                            Razı Ekstresi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#inbox" class="nav-link" id="base-tab4" data-toggle="tab">
                                            <i class="fa fa-question"></i>
                                            İzinler
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#orders" class="nav-link" id="base-tab5" data-toggle="tab">
                                            <i class="fa fa-file"></i>
                                            Raporlar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#is_avanslari" class="nav-link" id="base-tab6" data-toggle="tab">
                                            <i class="fa fa-money-bill"></i>
                                            İş Avansları

                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#personel_giderleri" class="nav-link" id="base-tab7" data-toggle="tab">
                                            <i class="fa fa-coins"></i>
                                            Personel Giderleri

                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#hastalik_mezuniyet" class="nav-link" id="base-tab8" data-toggle="tab">
                                            <i class="fa fa-hospital-user"></i>
                                            Hastalık ve Mezuniyet
                                        </a>
                                    </li>

                                    <?php
                                    if ($this->aauth->premission(78)->write) {

                                    ?>
                                    <li class="nav-item">
                                        <a href="#personel_razi" class="nav-link" id="base-tab8" data-toggle="tab">
                                            <i class="fa fa-hospital-user"></i>
                                            Personel Razı
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <!--                                    <li class="nav-item-divider"></li>-->
                                    <!--                                    <li class="nav-item">-->
                                    <!--                                        <a href="login_advanced.html" class="nav-link" data-toggle="tab">-->
                                    <!--                                            <i class="icon-switch2"></i>-->
                                    <!--                                            Logout-->
                                    <!--                                        </a>-->
                                    <!--                                    </li>-->


                                    <li class="nav-item">
                                        <a href="#malzeme_talebi" class="nav-link" id="base-tab8" data-toggle="tab">
                                            <i class="fa fa-hospital-user"></i>
                                            Bekleyen Malzeme Talepleri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#cari_gider_talebi" class="nav-link" id="base-tab8" data-toggle="tab">
                                            <i class="fa fa-hospital-user"></i>
                                            Bekleyen Cari Gider Talepleri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#cari_avans_talebi" class="nav-link" id="base-tab8" data-toggle="tab">
                                            <i class="fa fa-hospital-user"></i>
                                            Bekleyen Cari Avans Talepleri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#maas_duzenlemeleri" class="nav-link" id="base-tab8" data-toggle="tab">
                                            <i class="fa fa-hospital-user"></i>
                                            Maaş Düzenlemeleri
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content flex-1">
                        <div class="tab-pane fade active show" id="profile">

                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Profil Bilgileri</h6>
                                </div>

                                <div class="card-body">
                                    <form action="<?php echo base_url()?>personel/new_password" method="post">

                                        <input type="hidden" name="id" class="pers_id" value="<?php echo $details->id ?>">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>AD SOYAD</label>
                                                    <span class="form-control"><?php echo $details->name ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>MEDENI DURUMU</label>
                                                    <span class="form-control"><?php echo $details->medeni_durumu ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Fin Kodu</label>
                                                    <span class="form-control"><?php echo $details->fin_no ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Telefon</label>
                                                    <span class="form-control"><?php echo $details->phone ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>AÇIK ADRES</label>
                                                    <span class="form-control"><?php echo $details->address ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>RAYON</label>
                                                    <span class="form-control"><?php echo $details->city ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>ŞEHER</label>
                                                    <span class="form-control"><?php echo $details->region ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>ÜLKE</label>
                                                    <span class="form-control"><?php echo $details->country ?></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>Vatandaşlık</label>
                                                    <span class="form-control"><?php echo vatandaslik($details->vatandaslik)['name'] ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>CINSIYET</label>
                                                    <span class="form-control"><?php echo $details->cinsiyet ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>POZISYON</label>
                                                    <span class="form-control"><?php echo role_name($users_details->roleid)['name']; ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>SORUMLU PERSONEL </label>
                                                    <span class="form-control"><?php echo personel_details_full($details->sorumlu_pers_id)['name'] ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>Email</label>
                                                    <input type="text" readonly="readonly"
                                                           value="<?php echo $users_details->email ?>"
                                                           class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>PROJE</label>
                                                    <span class="form-control"><?php echo proje_code($salary_details->proje_id) ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>İŞE BAŞLAMA TARIHI</label>
                                                    <span class="form-control"><?php echo $details->ise_baslama_tarihi ?></span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>MAAŞ TIPI</label>
                                                    <span class="form-control"><?php echo salary_type($salary_details->salary_type)->name ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label>TOPLAM MAAŞ</label>
                                                    <input type="password" readonly="readonly" id="salary"
                                                           value="<?php echo $salary_details->salary ?>"
                                                           class="form-control">
                                                    <i class="fa fa-eye-slash" id="salary_show"></i>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>BANKA MAAŞ</label>
                                                    <input type="password" readonly="readonly" id="bank_salary"
                                                           value="<?php echo $salary_details->bank_salary ?>"
                                                           class="form-control">
                                                    <i class="fa fa-eye-slash" id="bank_salary_show"></i>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>KELBECER FARKI</label>
                                                    <input type="password" readonly="readonly" id="net_salary"
                                                           value="<?php echo $salary_details->net_salary ?>"
                                                           class="form-control">
                                                    <i class="fa fa-eye-slash" id="net_salary_show"></i>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>GÜNLÜK MAAŞ</label>
                                                    <input type="password" readonly="readonly" id="salary_day"
                                                           value="<?php echo $salary_details->salary_day ?>"
                                                           class="form-control">
                                                    <i class="fa fa-eye-slash" id="salary_day_show"></i>
                                                </div>
                                            </div>
                                        </div>

										<!-- Bu ( yeni şifre oluşturun bolumu) bolumu Busra , Feride ve kisinin kendisi gore bilir -->
										
										<?php if(($this->aauth->get_user()->employes->id) == 21 or 
												 ($this->aauth->get_user()->employes->id) == 735 or 
												 ($this->aauth->get_user()->employes->id) == $details->id):
										?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>yeni şifre oluşturun</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                            </div>
                                        </div>
										<?php endif; ?>
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <label>Profil Fotoğrafı</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="fileupload">
                                                        <label class="custom-file-label"
                                                               for="customFile">Seçiniz</label>
                                                    </div>
                                                    <span class="form-text text-muted">Desteklenen Format :  png, jpg. Max dosya boyuru 2Mb</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Güncelle</button>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="hesap_ekstresi">

                            <!-- Available hours -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Ödemeler ve Hesap Ekstresi</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="extres" class="table tab-content-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                <th><?php echo $this->lang->line('payment_type') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                                <th class="no-sort">Açıklama</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="card-header">
                                    <h6 class="card-title">Borç Ekstresi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="extre_borclandirma" class="table tab-content-bordered"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                <th><?php echo $this->lang->line('payment_type') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="raziekstesi">

                            <!-- Available hours -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Razı Ekstresi</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="extre_razi" class="table tab-content-bordered"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                <th><?php echo $this->lang->line('payment_type') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>

                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>

                                <div class="card-header">
                                    <h6 class="card-title">Borç Ekstresi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="extre_borclandirma" class="table tab-content-bordered"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                <th><?php echo $this->lang->line('payment_type') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="inbox">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">İzinler</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="izinler" class="table tab-content-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Talep No</th>
                                                <th>Talep Oluşturma Tarihi</th>
                                                <th>Başlangıç Tarihi</th>
                                                <th>Bitiş Tarihi</th>
                                                <th>Bildirim Durumu</th>
                                                <th>İzin Tipi</th>
                                                <th>Durum</th>
                                                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="orders">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Raporlar</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="doctable" class="table tab-content-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $this->lang->line('Title') ?></th>
                                                <th>Dosya Tipi</th>
                                                <th>Araç</th>
                                                <th>Belge Başlangıç Tarihi</th>
                                                <th>Bitiş Tarihi</th>
                                                <th><?php echo $this->lang->line('Action') ?></th>

                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="is_avanslari">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">İş Avansları</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="extre_is" class="table tab-content-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                <th><?php echo $this->lang->line('payment_type') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>

                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="personel_giderleri">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Personel Giderleri</h6>
                                </div>

                                <div class="card-body">

                                    <div class="card">
                                        <div class="card-body">
                                            <form action="#">
                                                <fieldset class="mb-3">
                                                    <div class="form-group row">
                                                        <div class="col-lg-2">
                                                            <input type="text" name="start_date" id="start_date" data-toggle="filter_date"
                                                                   class="form-control form-control-md" autocomplete="off" placeholder="Başlangıç Tarihi"/>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input type="text" name="end_date" id="end_date" class="form-control form-control-md"
                                                                   data-toggle="filter_date" autocomplete="off" placeholder="Bitiş Tarihi"/>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table" id="extre_gider" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Tarih</th>
                                                                <th>Gider Adı</th>
                                                                <th>Miktarı</th>
                                                                <th>Birim Fiyatı</th>
                                                                <th>Toplam Tutar</th>
                                                                <th>Gider Kodu</th>
                                                                <th>Talep Durumu</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="chart-container">-->
<!--                                        <table id="extre_gider" class="table tab-content-bordered" cellspacing="0"-->
<!--                                               width="100%">-->
<!--                                            <thead>-->
<!--                                            <tr>-->
<!--                                                <th>--><?php //echo $this->lang->line('Date') ?><!--</th>-->
<!--                                                <th>--><?php //echo $this->lang->line('transaction_type') ?><!--</th>-->
<!--                                                <th>--><?php //echo $this->lang->line('payment_type') ?><!--</th>-->
<!--                                                <th class="no-sort">Tutar</th>-->
<!--                                            </tr>-->
<!--                                            </thead>-->
<!--                                            <tbody>-->
<!--                                            </tbody>-->
<!---->
<!--                                            <tfoot>-->
<!--                                            <tr>-->
<!--                                                <th></th>-->
<!--                                                <th></th>-->
<!--                                                <th class="no-sort"></th>-->
<!--                                                <th class="no-sort"></th>-->
<!---->
<!--                                            </tr>-->
<!--                                            </tfoot>-->
<!--                                        </table>-->
<!---->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="hastalik_mezuniyet">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Hastalık ve Mezuniyet</h6>
                                </div>

                                <div class="card-body">
                                    <div class="chart-container">
                                        <table id="extre_mezuniyet" class="table tab-content-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                <th>Tip</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>
                                                <th class="no-sort"></th>

                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                            if ($this->aauth->premission(78)->write) {

                                ?>
                                <div class="tab-pane fade" id="personel_razi">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Personel Razı</h6>
                                            <div class="card-body">
                                                <div class="chart-container">
                                                    <table id="extre_razi" class="table table-striped table-bordered zero-configuration"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('Date') ?></th>
                                                            <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                            <th><?php echo $this->lang->line('payment_type') ?></th>
                                                            <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                            <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                            <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>

                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="no-sort"></th>
                                                            <th class="no-sort"></th>

                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php

                            }
                            ?>


                        <div class="tab-pane fade" id="malzeme_talebi">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <section>
                                            <div class="row">
                                                <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                                    <h3 class="text-danger" style="text-align:center">Malzeme Talep Onay Raporu</h3>
                                                    <div class="table-responsive">
                                                        <table id="invoices_talep_onay_report" class="table responsive" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Talep Tipi</th>
                                                                <th>Talep No</th>
                                                                <th>Onay Sırası</th>
                                                                <th>Durum</th>
                                                                <th>Görüntüle</th>
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
                        </div>
                        <div class="tab-pane fade" id="cari_gider_talebi">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <section>
                                            <div class="row">
                                                <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                                    <h3 class="text-danger" style="text-align:center">Cari Gider Onay Raporu</h3>
                                                    <div class="table-responsive">
                                                        <table id="invoices_cari_talep_onay_report" class="table responsive" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Talep Tipi</th>
                                                                <th>Talep No</th>
                                                                <th>Onay Sırası</th>
                                                                <th>Durum</th>
                                                                <th>Görüntüle</th>
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
                        </div>
                        <div class="tab-pane fade" id="cari_avans_talebi">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <section>
                                            <div class="row">
                                                <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                                    <h3 class="text-danger" style="text-align:center">Cari Avans Onay Raporu</h3>
                                                    <div class="table-responsive">
                                                        <table id="invoices_cari_avans_onay_report" class="table responsive" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Talep Tipi</th>
                                                                <th>Talep No</th>
                                                                <th>Onay Sırası</th>
                                                                <th>Durum</th>
                                                                <th>Görüntüle</th>
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
                        </div>
                        <div class="tab-pane fade" id="maas_duzenlemeleri">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <section>
                                            <div class="row">
                                                <div class="col-xl-12 col-sm-12 col-12 col-xs-12 mb-4">
                                                    <h3 class="text-danger" style="text-align:center">Maaş Düzenlemeleri</h3>
                                                    <div class="table-responsive">
                                                        <table  class="table responsive" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Oluşturma Tarihi</th>
                                                                <th>Oluşturan Personel</th>
                                                                <th>Durum</th>
                                                                <th>Proje</th>
                                                                <th>Brüt Maaş</th>
                                                                <th>Net Maaş</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $i=1; foreach (personel_salary_history($details->id) as $salary_details){
                                                                $durum='<span class="badge badge-danger">Pasif</span>';
                                                                $brut_maas=amountFormat($salary_details->salary);
                                                                $net_maas=amountFormat(net_maas_hesaplama_salary($salary_details->salary));
                                                                $proje=proje_code($salary_details->proje_id);
                                                                $personel=personel_detailsa($salary_details->staff_id)['name'];
                                                                if($salary_details->status){
                                                                    $durum='<span class="badge badge-success">Aktif</span>';
                                                                }

                                                                echo "<tr>
                                                                        <td>$i</td>
                                                                        <td>$salary_details->created_at</td>
                                                                        <td>$personel</td>
                                                                        <td>$durum</td>
                                                                        <td>$proje</td>
                                                                        <td>$brut_maas</td>
                                                                        <td>$net_maas</td>
                                                                        <td></td>
                                                                    </tr>";

                                                                $i++;  } ?>
                                                            </tbody>

                                                        </table>
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
        </div>
    </div>
</div>
<div id="menu-right" class="d-none">
    <div class="box">
        <ul class="nav nav-sidebar">
            <li class="nav-item">
                <a href="#profile" class="nav-link active" id="base-tab2" data-toggle="tab">
                    <i class="icon-user"></i>
                    Personel Kart Bilgileri
                </a>
            </li>
            <li class="nav-item">
                <a href="#hesap_ekstresi" class="nav-link" id="base-tab3" data-toggle="tab">
                    <i class="fa fa-list"></i>
                    Hesap Ekstresi
                </a>
            </li>
            <li class="nav-item">
                <a href="#raziekstesi" class="nav-link" id="base-tab9" data-toggle="tab">
                    <i class="fa fa-list"></i>
                    Razı Ekstresi
                </a>
            </li>
            <li class="nav-item">
                <a href="#inbox" class="nav-link" id="base-tab4" data-toggle="tab">
                    <i class="fa fa-question"></i>
                    İzinler
                </a>
            </li>
            <li class="nav-item">
                <a href="#orders" class="nav-link" id="base-tab5" data-toggle="tab">
                    <i class="fa fa-file"></i>
                    Raporlar
                </a>
            </li>
            <li class="nav-item">
                <a href="#is_avanslari" class="nav-link" id="base-tab6" data-toggle="tab">
                    <i class="fa fa-money-bill"></i>
                    İş Avansları

                </a>
            </li>
            <li class="nav-item">
                <a href="#personel_giderleri" class="nav-link" id="base-tab7" data-toggle="tab">
                    <i class="fa fa-coins"></i>
                    Personel Giderleri

                </a>
            </li>
            <li class="nav-item">
                <a href="#hastalik_mezuniyet" class="nav-link" id="base-tab8" data-toggle="tab">
                    <i class="fa fa-hospital-user"></i>
                    Hastalık ve Mezuniyet
                </a>
            </li>

            <?php
            if ($this->aauth->premission(78)->write) {

                ?>
                <li class="nav-item">
                    <a href="#personel_razi" class="nav-link" id="base-tab8" data-toggle="tab">
                        <i class="fa fa-hospital-user"></i>
                        Personel Razı
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>
<style>


    [id*="menu-"] {
        background: #ffffff;
        bottom: 0;
        color: #858585;
        height: 100%;
        position: absolute;
        top: 0;
        width: 205px;
        z-index: 99;
    }


    #menu-right {
        border-left: 1px solid #d9d9d9;
        top: 122px;
        right: 0;
        width: 205px;
        -webkit-transform: translate3d(205px,0,0);
        -moz-transform: translate3d(205px,0,0);
        transform: translate3d(205px,0,0);
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }
    #menu-right.active {
        right: 0;
        -webkit-transform: translate3d(0,0,0);
        -moz-transform: translate3d(0,0,0);
        transform: translate3d(0,0,0);
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }
    section.active, header.active, .intro.active, #menu-left.active, footer.active {
        -webkit-transform: translate3d(205px,0,0);
        -moz-transform: translate3d(205px,0,0);
        transform: translate3d(205px,0,0);
        -webkit-transition: all 500ms ease-in-out;
        -moz-transition: all 500ms ease-in-out;
        transition: all 500ms ease-in-out;
    }
    #extres_length, #extres_info, #extres_paginate, #extres_filter {
        display: none;
    }



    #extre_mezuniyet_length, #extre_mezuniyet_info, #extre_mezuniyet_paginate, #extre_mezuniyet_filter {
        display: none;
    }

    #extre_razi_length, #extre_razi_info, #extre_razi_paginate, #extre_razi_filter {
        display: none;
    }

    #extre_borclandirma_length, #extre_borclandirma_info, #extre_borclandirma_paginate, #extre_borclandirma_filter {
        display: none;
    }

    #extre_razi_length, #extre_razi_info, #extre_razi_paginate, #extre_razi_filter
    {
        display: none;
    }
</style>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
    $(document).on('click', ".delete_mezuniyet", function (e) {
        let talep_id = $(this).attr('mezuniyet_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İşlemi Silmek Üzeresiniz Emin Misiniz?<p/>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-red',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id: talep_id,
                        }
                        $.post(baseurl + 'employee/mezuniyet_sil',data,(response) => {
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
                                                $('#extre_mezuniyet').DataTable().destroy();
                                                mezuniyet_draw_data();
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

    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>employee/displaypic';
        $('#fileupload').fileupload({
            url: url,
            formData: {
                '<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?php echo $details->id ?>
            },
            done: function (e, data) {
                    $("#profile_images").attr('src', '<?php echo base_url() ?>userfiles/employee/' + data.result);
                    $('#loading-box').addClass('d-none');



            },
            progressall: function (e, data) {

                $('#loading-box').removeClass('d-none');

            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
    $(document).on('click', '#salary_show', function () {
        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personel/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#salary').attr('type') === "password" ? "text" : "password";
                $('#salary').attr("type", new_type);
            } else {
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

    })

    $(document).on('click', '#bank_salary_show', function () {

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personel/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#bank_salary').attr('type') === "password" ? "text" : "password";
                $('#bank_salary').attr("type", new_type);
            } else {
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
    })

    $(document).on('click', '#net_salary_show', function () {

        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personel/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#net_salary').attr('type') === "password" ? "text" : "password";
                $('#net_salary').attr("type", new_type);
            } else {
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
    })

    $(document).on('click', '#salary_day_show', function () {


        let data_update = {
            crsf_token: crsf_hash,
            id: 57,
        }
        $.post(baseurl + 'personel/yetkili_kontrol', data_update, (response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {
                let new_type = $('#salary_day').attr('type') === "password" ? "text" : "password";
                $('#salary_day').attr("type", new_type);
            } else {
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
    })

    $(document).ready(function () {


        eksre_draw_data()
        extre_razi_draw_data()
        extre_is_draw_data()
        extre_gider_draw_data()
        mezuniyet_draw_data()
        extre_borclandirma_draw_data()
        draw_data_izinler()
        draw_data()



        $('#base-tab2').on('click', function () {
            $('.sorting').click()
        });
    });

    $('#base-tab3').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab9').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab7').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab5').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab4').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab6').on('click', function () {
        $('.sorting').click()
    });
    $('#base-tab8').on('click', function () {
        $('.sorting').click()
    });

    function draw_data(start_date = '', end_date = '') {
        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('employee/document_load_list')?>",
                "type": "POST",
                'data': {
                    start_date: start_date,
                    end_date: end_date,
                    'cid': <?=$details->id ?>,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                }
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
                    text: '<i class="fa fa-plus"></i> Yeni Dosya Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Dosya Ekleyin ',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Başlangıç Tarihi</label>
      <input type='date' class='form-control baslangic_date'>
    </div>
    <div class="form-group col-md-6">
      <label for="name">Bitiş Tarihi</label>
      <input type='date' class='form-control bitis_date'>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
      <label for="bolum_id">Başlık</label>
       <input type'text' class='form-control title'>
    </div>
       <div class="form-group col-md-3">
      <label for="bolum_id">Dopsya Tipi</label>
           <select class="form-control file_type" id="file_type" name="file_type">
                    <?php foreach (personel_file_type() as $items) {
                                echo "<option value='$items->id'>$items->name</option>";
                            }?>
               </select>
    </div>
     <div class="form-group col-md-3">
      <label for="bolum_id">ETIBARNAME İÇIN ARAÇ SEÇINIZ</label>
           <select class="form-control select-box arac_id" id="arac_id" name="arac_id">
                                   <option value="0">Seçiniz</option>
                                    <?php foreach (araclar() as $items) {
                                echo "<option value='$items->id'>$items->name</option>";
                            }?>
                               </select>
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
                                            baslangic_date: $('.baslangic_date').val(),
                                            bitis_date: $('.bitis_date').val(),
                                            title: $('.title').val(),
                                            file_type: $('.file_type').val(),
                                            arac_id: $('.arac_id').val(),
                                            image_text: $('#image_text').val(),
                                            personel_id:  <?php echo $details->id?>,
                                        }
                                        $.post(baseurl + 'personel/create_file', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status == 200) {
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
                                                                $('#doctable').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            } else if (responses.status == 410) {

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
                                        })

                                    }
                                },
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                var url = '<?php echo base_url() ?>personel/adddocument';

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
                }
            ]

        });
    }

    function eksre_draw_data() {
        $('#extres').DataTable({
            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/ekstre_data')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo $details->id ?>,
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(4).footer()).html(tatals);
                $(api.column(3).footer()).html(tatals2);
                $(api.column(5).footer()).html(bakiyes + ' ' + string);
            }
        });
    }

    function extre_is_draw_data() {
        $('#extre_is').DataTable({


            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/ekstre_is')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo $details->id ?>,

                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(4).footer()).html(tatals);
                $(api.column(3).footer()).html(tatals2);
                $(api.column(5).footer()).html(bakiyes + ' ' + string);
            }
        });
    }

    function extre_gider_draw_data(start_date='',end_date) {

        $('#extre_gider').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('demirbas/ajax_list_gider_firma')?>",
                'type': 'POST',
                'data': {
                    'demisbas_id':'<?php echo $details->id;?>',
                    'table_name':'geopos_employees',
                    'start_date':start_date,
                    'end_date':end_date,
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,

                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });


        //$('#extre_gider').DataTable({
        //
        //
        //    'processing': true,
        //    'serverSide': true,
        //    "scrollCollapse": true,
        //    "scrollY": "700px",
        //    'stateSave': true,
        //    'order': [],
        //    'ajax': {
        //        'url': "<?php //echo site_url('employee/ekstre_gider')?>//",
        //        'type': 'POST',
        //        'data': {
        //            'para_birimi': 'tumu',
        //            'cid':<?php //echo $details->id ?>//,
        //
        //            '<?php //echo $this->security->get_csrf_token_name()?>//': crsf_hash
        //        }
        //    },
        //    'columnDefs': [
        //        {
        //            'targets': [0],
        //            'orderable': false,
        //        },
        //    ],
        //    dom: 'Blfrtip',
        //    buttons: [
        //        {
        //            extend: 'excelHtml5',
        //            footer: true,
        //            exportOptions: {
        //                columns: [0, 1, 2, 3, 4, 5]
        //            }
        //        },
        //        {
        //            extend: 'pdf',
        //            footer: true,
        //            exportOptions: {
        //                columns: [0, 1, 2, 3, 4, 5]
        //            }
        //        },
        //        {
        //            extend: 'csv',
        //            footer: true,
        //            exportOptions: {
        //                columns: [0, 1, 2, 3, 4, 5]
        //            }
        //        },
        //
        //        {
        //            extend: 'copy',
        //            footer: true,
        //            exportOptions: {
        //                columns: [0, 1, 2, 3, 4, 5]
        //            }
        //        },
        //        {
        //            extend: 'print',
        //            footer: true,
        //            exportOptions: {
        //                columns: [0, 1, 2, 3, 4, 5]
        //            }
        //        },
        //    ],
        //    "footerCallback": function (row, data, start, end, display) {
        //        var api = this.api(), data;
        //
        //        // Remove the formatting to get integer data for summation
        //        var floatVal = function (i) {
        //            return typeof i === 'string' ?
        //                i.replace(/[\AZN,.]/g, '') / 100 :
        //                typeof i === 'number' ?
        //                    i : 0;
        //        };
        //
        //        // Total over all pages
        //        total = api
        //            .column(3)
        //            .data()
        //            .reduce(function (a, b) {
        //                return floatVal(a) + floatVal(b);
        //            }, 0);
        //
        //
        //        var total_ = currencyFormat(floatVal(total));
        //
        //        $(api.column(3).footer()).html(total_);
        //    }
        //});
    }

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        $('#extre_gider').DataTable().destroy();
        extre_gider_draw_data(start_date, end_date);

    });

    function extre_razi_draw_data() {
        $('#extre_razi').DataTable({


            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/ekstre_data_razi')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo $details->id ?>,

                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(4).footer()).html(tatals);
                $(api.column(3).footer()).html(tatals2);
                $(api.column(5).footer()).html(bakiyes + ' ' + string);
            }
        });
    }

    function draw_data_razi(){
        $('#extre_razi').DataTable({


            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/ekstre_data_razi')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo $details->id ?>,
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
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                }
                else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(4).footer()).html(tatals);
                $(api.column(3).footer()).html(tatals2);
                $(api.column(5).footer()).html(bakiyes + ' ' + string);
            }
        });
    }

    function extre_borclandirma_draw_data() {
        $('#extre_borclandirma').DataTable({


            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/ekstre_data_borclandirma')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo $details->id ?>,

                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
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
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(4).footer()).html(tatals);
                $(api.column(3).footer()).html(tatals2);
                $(api.column(5).footer()).html(bakiyes + ' ' + string);
            }
        });
    }


    function currencyFormat(num) {

        var deger = num.toFixed(2).replace('.', ',');
        return deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' AZN';
    }


    function mezuniyet_draw_data() {
        $('#extre_mezuniyet').DataTable({
            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/mezuniyet')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo $details->id ?>,
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                }
            },
            'columnDefs': [
                {
                    'targets': [],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                }
            ],
        });
    }

    function draw_data_izinler() {
        $('#izinler').DataTable({
            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('personelaction/ajax_list_izinler')?>",
                'type': 'POST',
                'data': {
                    'tip': "w",
                    'cid':<?php echo $details->id ?>,
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false
                }
            ],
            dom: 'Blfrtip',

        });
    }

    $(document).on('click', '.eye-permit', function () {
        let permit_id = $(this).data('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İzin Görüntüle',
            icon: 'fa fa-eye',
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
                             <div class="row">
                               <div class="card col-md-12">
<p id="text"></p>
									  <ul class="list-group list-group-flush" style="text-align: justify;">
									  </ul>
									</div>

                            <div class="card col-md-12">
                                  <ul class="list-group list-group-flush" style="text-align: justify;font-size: 15px;">
                                    <li class="list-group-item"><b>Proje : </b>&nbsp;<span id="proje"></span></li>
                                    <li class="list-group-item"><b>Vazife : </b>&nbsp;<span id="vazife"></span></li>
                                    <li class="list-group-item"><b>Personel : </b>&nbsp;<span id="pers_name"></span></li>
                                    <li class="list-group-item"><b>Başlangıç T : </b>&nbsp;<span id="start_date"></span></li>
                                    <li class="list-group-item"><b>Bitiş T. : </b>&nbsp;<span id="end_date"></span></li>
                                    <li class="list-group-item"><b>Sebep : </b>&nbsp;<span id="description"></span></li>
                                  </ul>
                            </div>
                                </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    permit_id: permit_id,
                }


                let li = '';
                $.post(baseurl + 'personelaction/get_info_permit_confirm', data, (response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    if (responses.status == 200) {
                        $('#text').empty().text('Açıklama : '+responses.details_permit.description)
                        $.each(responses.item, function (index, item) {

                            let durum = 'Bekliyor';
                            let desc = '';
                            if (item.staff_status == 1) {
                                durum = 'Onaylandı | '+ item.staff_desc;
                            } else if (item.staff_status == 2) {
                                durum = 'İptal Edildi';
                                desc = `<li>` + item.staff_desc + `</li>`;
                            }
                            li += `<li class="list-group-item"><b>` + item.sort + `. Personel Adı : </b>&nbsp;` + item.name + `</li><ul><li>` + durum + `</li>` + desc + `</ul>`;
                        });

                        $('.list-group-flush').empty().append(li);
                    } else {
                        $('.list-group-flush').empty().append('<p>Bildirim Başlatılmamış</p>');
                    }


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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
    })


    $(document).on('click', '.delete-object', function () {
        let permit_id = $(this).data('object-id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dosya Sil',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Dosyayı Silmek İstediğinizden Emin Misiniz',
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            id: permit_id,
                        }
                        $.post(baseurl + 'personel/delete_document', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 200) {
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
                                                $('#doctable').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            } else if (responses.status == 410) {

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
                        })

                    }
                },
                cancel: {
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
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
    })
    $(document).ready(function(){
        $(".rating-upper").css({
            width: <?php echo   $point_value['result'] = null ? 0 : $point_value['result'] ; ?> + "%"

        });

    });


    $(document).ready(function () {

        $('#invoices_cari_talep_onay_report').DataTable({
            autoWidth: false,
            select: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [ -1],
                ["Tümü"]
            ],
            'ajax': {
                'url': baseurl + '/onay/invoices_cari_onay_report',
                'type': 'POST',
                'data': {
                    tip: 1,
                    page: 'personel',
                    pers_id: $('.pers_id').val(),
                    proje_id:0
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [4]
            }],
            dom: 'Blfrtip',
            buttons: []
        });


        $('#invoices_cari_avans_onay_report').DataTable({
            autoWidth: false,
            select: true,
            aLengthMenu: [
                [ -1],
                ["Tümü"]
            ],
            processing: true,
            serverSide: true,
            'ajax': {
                'url': baseurl + '/onay/invoices_cari_onay_report',
                'type': 'POST',
                'data': {
                    tip: 2,
                    page: 'personel',
                    pers_id: $('.pers_id').val(),
                    proje_id:0
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [4]
            }],
            dom: 'Blfrtip',
            buttons: []
        });

        $('#invoices_talep_onay_report').DataTable({
            autoWidth: false,
            select: true,
            aLengthMenu: [
                [ -1],
                ["Tümü"]
            ],
            processing: true,
            serverSide: true,
            'ajax': {
                'url': baseurl + '/onay/invoices_talep_onay_report',
                'type': 'POST',
                'data': {
                    tip: 1,
                    page: 'personel',
                    pers_id: $('.pers_id').val(),
                    proje_id:0
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [4]
            }],
            dom: 'Blfrtip',
            buttons: []
        });

    })
</script>