<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="container">
            <section class="content-body">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">
                    <?php if($deger==1){ ?>
                    <h2 style="text-align: center;">İşleminiz Başarıyla Onaylanmıştır!</h2>
                        <?php } else if($deger==0)  { ?>
                        <h2>İşlem Onaylanmadı! Lütfen Sistem Yöneticisine Başvurunuz.</h2>

                    <?php } else if($deger==2)  { ?>
                        <h2>Daha Önce Onaylanmış.</h2>

                    <?php }  else if($deger==3)  { ?>
                        <h2>Red Yanıtınız Başarıyla İşlenmiştir.</h2>

                        <?php }  else if($deger==4)  { ?>
                        <h2>Red Olarak Yanıt Verişmiştir.</h2>

                        <?php } ?>
                    </div>


                </div>
            </section>
        </div>
    </div>
</div>

