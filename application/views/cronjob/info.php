<article class="content">
    <div class="card card-block">
        <?php if ($message) {

            echo '<div id = "notify" class="alert alert-success"  >
            <a href = "#" class="close" data - dismiss = "alert" >&times;</a >

            <div class="message" >Token updated successfully!</div >
        </div >';
        } ?>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <div class="card-block"><h5>Cron Job Management </h5>

                <hr>
                <p>The software utility Cron is a time-based job scheduler. People who set up and maintain automated
                    application task use cron to schedule jobs to run periodically at fixed times, dates, or intervals.
                    Recommended cron job scheduling is in midnight.</p><br><a
                        href="<?php echo base_url('cronjob/generate'); ?>" class="btn btn-primary btn-sm rounded">
                    Update Cron Token
                </a>
                <p></p>
                <h4 class="text-gray-dark"><?php echo $corn['cornkey']; ?></h4>

                <hr>
                <p class="text-bold-500"> Subscription Invoices Auto Management URL is</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/subscription?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/subscription?token=' . $corn['cornkey']) ?></pre>
                <hr>

                <hr>
                <p class="text-bold-500"> Para Birimleri Azerbeycana Göre Güncelleme</p>


                <?php
                $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                $firma_kodu=$dbnames['firma_kodu'];

                ?>


                <pre class="card-block card">WGET <?php echo base_url("firma_login/token_giris.php?firma_kodu=$firma_kodu&type=azn_update&token=".$corn['cornkey']) ?></pre>
                <hr>

                <p class="text-bold-500">Due Invoices Autometic Email URL is </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>

                <hr>
                <p class="text-bold-500">Automatic Report data update</p>
                <p>
                    <small>This action will update the monthly sales,sold items, total income and expenses of past 12
                        months.
                    </small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>

                <p class="text-bold-500">Automatic Currency Exchange Rates update</p>
                <p>
                    <small>This action will update the payment Currency Exchange Rates.
                    </small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>
                     <hr>
                 <p class="text-bold-500"> Clean Drafts URL is</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/cleandrafts?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/cleandrafts?token=' . $corn['cornkey']) ?></pre>
                <hr>
    <p class="text-bold-500"> Promo/Coupon Expired is</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/promo?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/promo?token=' . $corn['cornkey']) ?></pre>

                <hr>
    <p class="text-bold-500"> Low Stock  Products Alert</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/stock_alert?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/stock_alert?token=' . $corn['cornkey']) ?></pre>
                  <hr>
                    <p class="text-bold-500">Expiring  Products Alert</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/expiry_alert?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/expiry_alert?token=' . $corn['cornkey']) ?></pre>
                  <hr>
                    <p class="text-bold-500">Database BackUp</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/dbbackup?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/dbbackup?token=' . $corn['cornkey']) ?></pre>
                 <hr>
                    <p class="text-bold-500">Clean 7 Days Old Log</p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/cleanlog?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/cleanlog?token=' . $corn['cornkey']) ?></pre>
            </div>


        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({});

    });
</script>