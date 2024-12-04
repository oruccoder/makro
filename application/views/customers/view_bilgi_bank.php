
<form method="post" id="form_model_banka_edit">


    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('hesap_numarasi') ?></label>
            <input class="form-control" name="hesap_numarasi" value="<?php echo $details['hesap_numarasi']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('iden_numarasi') ?></label>
            <input class="form-control" name="iden_numarasi" value="<?php echo $details['iden_numarasi']; ?>">

        </div>

    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka') ?></label>
            <input class="form-control" name="banka" value="<?php echo $details['banka']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_unvan') ?></label>
            <input class="form-control" name="banka_unvan" value="<?php echo $details['banka_unvan']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_tel') ?></label>
            <input class="form-control" name="banka_tel" value="<?php echo $details['banka_tel']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_fax') ?></label>
            <input class="form-control" name="banka_fax" value="<?php echo $details['banka_fax']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('kod') ?></label>
            <input class="form-control" name="kod" value="<?php echo $details['kod']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('swift') ?></label>
            <input class="form-control" name="swift" value="<?php echo $details['swift_kodu']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_voen') ?></label>
            <input class="form-control" name="banka_voen" value="<?php echo $details['bank_voen']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('muh_hesab') ?></label>
            <input class="form-control" name="muh_hesab" value="<?php echo $details['muhbir_hesab']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('invoice_para_birimi') ?></label>
            <select name="para_birimi" id="para_birimi" class="form-control">
                <?php
                foreach (para_birimi()  as $row) {
                    $cid = $row['id'];
                    $title = $row['code'];
                    if($details['para_birimi']==$cid)
                    {
                        echo "<option selected value='$cid'>$title</option>";
                    }
                    else
                    {
                        echo "<option value='$cid'>$title</option>";
                    }

                }
                ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
        <input type="hidden"  id="action-url-bank" value="customers/customer_bank_edit">
        <input type="hidden"  id="id_bank_edit" name="id_bank_edit" value="<?php echo $details['id']?>">
        <button type="button" class="btn btn-primary"
                id="customer_bank_edit">Düzenle</button>
    </div>
</form>
