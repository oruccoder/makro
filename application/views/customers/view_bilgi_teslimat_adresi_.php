<form method="post" id="form_invoice_details">

    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('unvan') ?></label>
            <input class="form-control" name="unvan_invoice" disabled value="<?php echo $details['unvan_teslimat'] ?>"  placeholder="Ev,İş vs.">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Country') ?></label>
            <input class="form-control" name="country_invoice" disabled value="<?php echo $details['country_teslimat'] ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Region') ?></label>
            <input class="form-control" name="sehir_invoice" disabled value="<?php echo $details['sehir_teslimat'] ?>">

        </div>

        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('City') ?></label>
            <input class="form-control" name="city_invoice" disabled value="<?php echo $details['city_teslimat'] ?>">

        </div>

    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('PostBox') ?></label>
            <input class="form-control" name="post_invoice" disabled value="<?php echo $details['post_teslimat'] ?>">

        </div>

        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Address') ?></label>
            <input class="form-control" name="adres_invoice" disabled value="<?php echo $details['adres_teslimat'] ?>">

        </div>

    </div>

    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Phone') ?></label>
            <input class="form-control" name="phone_invoice" disabled value="<?php echo $details['phone_teslimat'] ?>">

        </div>

        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('email_') ?></label>
            <input class="form-control" name="email_invoice" disabled value="<?php echo $details['email_teslimat'] ?>">

        </div>

    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
    </div>
</form>