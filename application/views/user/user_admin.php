<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column bg-login">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-12 offset-md-12 col-xs-12" style="    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;">

                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-header no-border">
                            <div class="card-title text-xs-center">
                                <div class="p-1"><img width="100%"
                                                      src="<?php echo base_url('userfiles/company/') . $this->config->item('logo'); ?>"
                                                      alt="Logo"></div>
                            </div>

                            <h3 class="card-subtitle  text-muted text-xs-center font-small-4 pt-2">
                                <span><?php echo $firma_adi; ?></span>
                            </h3>
                            <h6 class="card-subtitle text-muted text-xs-center font-small-3 pt-2">
                                <span><?php echo $this->lang->line('employee_login_panel') ?></span>
                            </h6>
                        </div>
                        <div class="card-body collapse in">
                            <div class="card-block">
                                <?php
                                $attributes = array('class' => 'form-horizontal form-simple', 'id' => 'login_form');
                                echo form_open('user/checklogin',$attributes);
                                ?>


                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <input type="text" class="form-control form-control-lg input-lg" name="username"
                                           placeholder="<?php echo $this->lang->line('Your Email') ?>" required>
                                    <div class="form-control-position">
                                        <i class="icon-head"></i>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="password" class="form-control form-control-lg input-lg"
                                           name="password" placeholder="<?php echo $this->lang->line('Your Password') ?>" required>
                                    <div class="form-control-position">
                                        <i class="icon-key3"></i>
                                    </div>
                                </fieldset>

                                <?php
                                date_default_timezone_set('Asia/Baku');

                                $gun=date('N');
                                $date = date('H');

                                if($date<=18 && $date > 6 && $gun!=7)
                                {

                                    ?>

                                    <p style="text-align: center">


                                        Bugün Saat 19:00'a kadar geçerli olan kodunuz : <?php echo kodu_getir()?>
                                    </p>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-lg input-lg"
                                               name="kode" placeholder="">
                                        <div class="form-control-position">
                                            <i class="icon-key3"></i>
                                        </div>
                                    </fieldset>

                                <?php }
                                else
                                {
                                    echo '<input type="hidden" class="form-control form-control-lg input-lg"
                                               name="kode" >';
                                }?>
                                <?php if ($response) {
                                    echo '<div id="notify" class="alert alert-danger" >
                            <a href="#" class="close" data-dismiss="alert">&times;</a> <div class="message">' . $response . '</div>
                        </div>';
                                } ?>

                                <?php if ($this->aauth->get_login_attempts() > 1 && $captcha_on) {
                                    echo '<script src="https://www.google.com/recaptcha/api.js"></script>
									<fieldset class="form-group position-relative has-icon-left">
                                      <div class="g-recaptcha" data-sitekey="' . $captcha . '"></div>
                                    </fieldset>';
                                } ?>
                                <fieldset class="form-group row">
                                    <!--div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                            <fieldset>
                                                <input type="checkbox" id="remember-me" class="chk-remember"
                                                       name="remember_me">
                                                <label for="remember-me"> <?php echo $this->lang->line('remember_me') ?></label>
                                            </fieldset>
                                        </div-->
                                    <div class="col-md-6 col-xs-12 text-xs-center text-md-right"><a
                                            href="<?php echo base_url('user/forgot'); ?>" class="card-link">
                                            <?php echo $this->lang->line('forgot_password') ?>?</a></div>

                                    <div class="col-md-6 col-xs-12 text-xs-center text-md-right"><a
                                            href="<?php echo base_url('user/firma_unut'); ?>" class="card-link">
                                            Firma Girişi</a></div>
                                </fieldset>
                                <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                        class="icon-unlock2"></i> <?php echo $this->lang->line('login') ?>
                                </button>


                                </form>
                            </div>
                        </div>
                        <!--div class="card-footer">
                            <div class="col-md-12 col-xs-12 text-xs-center">

                                <h6 class="card-subtitle text-muted text-xs-center font-small-3 pt-2"><a
                                            href="<?php echo base_url('crm'); ?>"
                                            class="card-link"><?php echo $this->lang->line('customer_login') ?></a></h6>
                            </div>
                        </div-->
                    </div>
                </div>


            </section>

        </div>

    </div>


</div>
