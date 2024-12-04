<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>







            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">


                <h2 class="text-xs-center">Güncel Bakiye <?= amountExchange($details['balance'], 0, $this->aauth->get_user()->loc) ?></h2>

                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" value="<?= $details['id'] ?>" name="id">

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>

                        <div class="col-sm-3">
                            <input type="number" placeholder="Tutar Giriniz  0.00"
                                   class="form-control margin-bottom " name="amount">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"></label>

                        <div class="col-sm-3">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Ekle" data-loading-text="Updating...">
                            <input type="hidden" value="customers/balance" id="action-url">
                        </div>
                    </div>


                </form>


                <h5 class="text-xs-center"><?php echo $this->lang->line('Payment History') ?></h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Note') ?></th>


                    </tr>
                    </thead>
                    <tbody id="activity">
                    <?php foreach ($activity as $row) {

                        echo '<tr>
                            <td>' . amountExchange($row['col1'], 0, $this->aauth->get_user()->loc) . '</td><td>' . $row['col2'] . '</td>
                           
                        </tr>';
                    } ?>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
