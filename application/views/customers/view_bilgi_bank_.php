
<form method="post" id="form_model_banka_edit">


    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('hesap_numarasi') ?></label>
            <input class="form-control" name="hesap_numarasi" disabled value="<?php echo $details['hesap_numarasi']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('iden_numarasi') ?></label>
            <input class="form-control" name="iden_numarasi" disabled value="<?php echo $details['iden_numarasi']; ?>">

        </div>

    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka') ?></label>
            <input class="form-control" name="banka" disabled value="<?php echo $details['banka']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_unvan') ?></label>
            <input class="form-control" name="banka_unvan" disabled value="<?php echo $details['banka_unvan']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_tel') ?></label>
            <input class="form-control" name="banka_tel" disabled value="<?php echo $details['banka_tel']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_fax') ?></label>
            <input class="form-control" name="banka_fax" disabled value="<?php echo $details['banka_fax']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('kod') ?></label>
            <input class="form-control" name="kod" disabled value="<?php echo $details['kod']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('swift') ?></label>
            <input class="form-control" name="swift" disabled value="<?php echo $details['swift_kodu']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_voen') ?></label>
            <input class="form-control" name="banka_voen" disabled value="<?php echo $details['bank_voen']; ?>">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('muh_hesab') ?></label>
            <input class="form-control" name="muh_hesab" disabled value="<?php echo $details['muhbir_hesab']; ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('invoice_para_birimi') ?></label>

            <?php
            foreach (para_birimi()  as $row) {
                $cid = $row['id'];
                $title = $row['code'];
                if($details['para_birimi']==$cid)
                {
                    $para_=$title;
                }

            }
            ?>

            <input class="form-control"  disabled value="<?php echo $para_; ?>">
        </div>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
        <a href="/customers/bank_details_print?id=<?php echo $details['id']?>" target="_blank" class="btn btn-primary" >Yazdır</a>
    </div>
</form>
