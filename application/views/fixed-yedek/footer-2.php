
<script src="<?= base_url().'assets/global_assets/js/plugins/ui/prism.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/tables/datatables/datatables.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/notifications/jgrowl.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/notifications/noty.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/notifications/sweet_alert.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js'?>"></script>
<script src="<?= base_url().'assets/global_assets/js/plugins/forms/selects/select2.min.js'?>"></script>
</body>
</html>

<div class="navbar navbar-expand-lg navbar-light">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
        <div class="navbar-collapse collapse" id="navbar-footer">
                <span class="navbar-text">
                    &copy; 2022. Makro2000 - ERP
                </span>
            <ul class="navbar-nav ml-lg-auto">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link font-weight-semibold">
                            <span class="text">
                                <i class="fas fa-hard-hat mr-2"></i> <span><?php echo $this->aauth->get_user()->username ?></span>
                            </span>
					</a>

				</li>
                <li class="nav-item">
                    <a href="https://makro2000.com.tr" class="navbar-nav-link font-weight-semibold">
                            <span class="text-pink">
                                <i class="fas fa-hard-hat mr-2"></i> makro2000.com.tr
                            </span>
                    </a>

                </li>

            </ul>
        </div>
    </div>
</div>
<div id="loading-box" class="d-none">
    <div class="lds-ripple"><div></div><div></div></div>
</div>
