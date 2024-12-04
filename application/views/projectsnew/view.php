<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title">
            <h4 style="text-decoration:underline"><span class="font-weight-semibold">Proje Bilgisi <?php echo $details->name ?> -  <?php echo $details->code ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<input type="hidden" id="proje_id" value="<?php echo $details->prj?>">
<div class="content">
    <div class="card">
        <div class="card-body">
            <?php $this->load->view("projectsnew/proje_bilgileri") ?>
        </div>
    </div>
    <div class="card" style="box-shadow: none;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 no-padding">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link no-border active show" id="nav-proje_bolumleri" data-toggle="tab" href="#proje_bolumleri" role="tab" aria-selected="false">Bölümler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-proje_asamalari" data-toggle="tab" href="#proje_asamalari" role="tab" aria-selected="false">Aşamalar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-is_kalemleri" data-toggle="tab" href="#is_kalemleri" role="tab" aria-selected="false">İş Kalemleri</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link no-border"  id="nav-malzeme_listesi" data-toggle="tab" href="#malzeme_listesi" role="tab" aria-selected="false">Malzeme Listesi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border"  id="nav-all_gider" data-toggle="tab" href="#all_gider" role="tab" aria-selected="false">Proje Tüm Giderleri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border"  id="nav-faturalar" data-toggle="tab" href="#faturalar" role="tab" aria-selected="false">Faturalar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-forma_2" data-toggle="tab" href="#forma_2" role="tab" aria-selected="false">Forma2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-razilastirma_listesi" data-toggle="tab" href="#razilastirma_listesi" role="tab" aria-selected="false" >Razılaştırma</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-dosyalar" data-toggle="tab" href="#dosyalar" role="tab" aria-selected="false">Dosyalar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-nakliye_talepleri" data-toggle="tab" href="#nakliye_talepleri" role="tab" aria-selected="false">Nakliye Talepleri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-malzeme_talepleri" data-toggle="tab" href="#malzeme_talepleri" role="tab" aria-selected="false">Proje Talepleri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link no-border" id="nav-avans_talepleri" data-toggle="tab" href="#avans_talepleri" role="tab" aria-selected="false">Cari Avans Talepleri</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active show" id="proje_bolumleri" aria-labelledby="proje_bolumleri-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/proje_bolumleri") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="proje_asamalari" aria-labelledby="proje_bolumleri-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/proje_asamalari") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="is_kalemleri" aria-labelledby="is_kalemleri-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/is_kalemleri") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="malzeme_listesi" aria-labelledby="malzeme_listesi-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/malzeme_listesi") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="all_gider" aria-labelledby="all_gider-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/all_gider") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="faturalar" aria-labelledby="faturalar-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/faturalar") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="forma_2" aria-labelledby="forma_2-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/forma_2") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="razilastirma_listesi" aria-labelledby="razilastirma_listesi-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/razilastirma_listesi") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="dosyalar" aria-labelledby="dosyalar-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/dosyalar") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="nakliye_talepleri" aria-labelledby="nakliye_talepleri-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/nakliye_talepleri") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="malzeme_talepleri" aria-labelledby="malzeme_talepleri-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/malzeme_talepleri") ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="avans_talepleri" aria-labelledby="avans_talepleri-tab" aria-expanded="true">
                            <?php $this->load->view("projectsnew/avans_talepleri") ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("projectsnew/header") ?>

