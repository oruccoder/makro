<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Employee Details') ?> </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">

    <div class=" bg-white">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="card-body">
                <div class="form-group row">

                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('UserName') ?>
                            <small class="error">(Use Only a-z0-9)</small>
                        </label>

                        <div class="input-group">
                            <input type="text"
                                   class="form-control margin-bottom required" name="username"
                                   placeholder="username">
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('vatandaslik') ?>
                        </label>

                        <div class="input-group">
                            <select class="form-control" name="vatandaslik">
                               <?php foreach (vatandaslik() as $vat) {?>
                                   <option value="<?php echo $vat['id']; ?>"><?php echo $vat['name']; ?> </option>

                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="e-mail"><?php echo $this->lang->line('cinsiyet') ?>
                        </label>

                        <div class="input-group">
                            <select class="form-control" name="cinsiyet">
                                    <option value="Kadın"><?php echo 'Kadın'; ?> </option>
                                    <option value="Erkek"><?php echo 'Erkek'; ?> </option>
                            </select>
                        </div>

                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="e-mail"><?php echo $this->lang->line('dogum_tarihi') ?>
                        </label>

                        <div class="input-group">
                            <input type="text" placeholder="Doğum Tarihi"
                                   class="form-control margin-bottom" name="birthday"
                                   data-toggle="datepicker"
                                   autocomplete="false">
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="e-mail">E-mail
                        </label>

                        <div class="input-group">
                            <input type="email" placeholder="email"
                                   class="form-control margin-bottom required" name="email"
                                   placeholder="email">
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="password"><?php echo $this->lang->line('password_giris') ?>

                        </label>

                        <div class="input-group">
                           <input type="text" placeholder="Password"
                                  class="form-control margin-bottom required" name="password"
                                  placeholder="password">
                        </div>

                    </div>

                </div>
                <div class="form-group row">


                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('medeni_durumu') ?></label>


                        <select name="medeni_durumu" class="form-control margin-bottom">
                            <option value="Bekar"><?php echo 'Bekar'; ?> </option>
                            <option value="Evli"><?php echo 'Evli'; ?> </option>
                        </select>
                    </div>

                        <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('cocuk_durumu') ?></label>


                            <select name="cocuk_durumu" class="form-control margin-bottom">
                                <option value="Yok"><?php echo 'Yok'; ?> </option>
                                <option value="Var"><?php echo 'Var'; ?> </option>
                            </select>
                        </div>
                        <div class="col-sm-2">

                            <label class="col-form-label"
                                   for="name"><?php echo $this->lang->line('Business Location') ?></label>


                            <select name="location" class="form-control margin-bottom">
                                <option value="0"><?php echo $this->lang->line('Default') ?></option>
                                <?php $loc = locations();

                                foreach ($loc as $row) {
                                    echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-form-label"
                                   for="name"><?php echo $this->lang->line('adi_soyadi') ?></label>
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom required" name="name"
                                   placeholder="Full name">
                        </div>
                    <div class="col-sm-2">
                            <label class="col-form-label"
                                   for="name"><?php echo $this->lang->line('kan_grubu') ?></label>
                            <input type="text" placeholder="Kan Grubu"
                                   class="form-control margin-bottom" name="kan_grubu">
                        </div>
                    <div class="col-sm-2">
                            <label class="col-form-label"
                                   for="name"><?php echo $this->lang->line('fin_no') ?></label>
                            <input type="text" placeholder="Fin Kodu"
                                   class="form-control margin-bottom required" name="fin_no">
                        </div>
                    </div>


                <div class="form-group row">

                    <div class="col-sm-4">
                    <label class="col-form-label"
                           for="address"><?php echo $this->lang->line('Address') ?></label>


                        <input type="text" placeholder="address"
                               class="form-control margin-bottom" name="address">
                    </div>

                    <div class="col-sm-4">
                    <label class="col-form-label"
                           for="city"><?php echo $this->lang->line('City') ?></label>


                        <input type="text" placeholder="City"
                               class="form-control margin-bottom" name="city">
                    </div>
                    <div class="col-sm-4">
                        <label class=" col-form-label"
                               for="city"><?php echo $this->lang->line('Region') ?></label>


                        <input type="text" placeholder="Region"
                               class="form-control margin-bottom" name="region">
                    </div>

                </div>
                <div class="form-group row">



                    <div class="col-sm-4">
                    <label class="col-form-label"
                           for="country"><?php echo $this->lang->line('Country') ?></label>


                        <input type="text" placeholder="Country"
                               class="form-control margin-bottom" name="country">
                    </div>
                    <div class="col-sm-4">
                    <label class="col-form-label"
                           for="country"><?php echo $this->lang->line('posta_kodu') ?></label>


                        <input type="text" placeholder="Postbox"
                               class="form-control margin-bottom" name="postbox">
                    </div>

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('Phone') ?></label>


                        <input type="text" placeholder="phone"
                               class="form-control margin-bottom" name="phone">
                    </div>

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('Phone2') ?></label>


                        <input type="text" placeholder="phone"
                               class="form-control margin-bottom" name="phonealt">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('Salary') ?></label>


                        <input type="text" placeholder="Salary" onkeypress="return isNumber(event)"
                               class="form-control margin-bottom salary" name="salary"
                               value="0">
                    </div>
                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('resmi_maas') ?></label>


                        <input type="text" placeholder="Salary" onkeypress="return isNumber(event)"
                               class="form-control margin-bottom resmi_maas" min="0" name="resmi_maas"
                               value="0">
                    </div>
                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('gayri_resmi_maas') ?></label>


                        <input type="text" placeholder="Salary" onkeypress="return isNumber(event)"
                               class="form-control margin-bottom gayri_resmi_maas" min="0" name="gayri_resmi_maas"
                               value="0">
                    </div>

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="city"> <?php echo $this->lang->line('Commission') ?>
                        %</label>


                        <input type="number" placeholder="Komisyon %" value="0"
                               class="form-control margin-bottom" name="commission">

                    <small class="col">Tüm Satışlarda Geçerli Olacaktır.
                    </small>
                    </div>

                    <div class="col-md-2">
                        <label class="col-form-label"
                               for="roleid"><?php echo $this->lang->line('UserRole') ?></label>
                        <select  name="roleid" class="form-control margin-bottom">
                            <?php foreach (role_name() as $rol){
                         ?>
                                <option value="<?= $rol['role_id'] ?>"><?= $rol['name'] ?></option>



                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('Department') ?></label>
                        <select name="department" class="form-control margin-bottom">

                            <option value="0"><?php echo $this->lang->line('Default') ?></option>
                            <?php

                            foreach ($dept as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['val1'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="phone"><?php echo $this->lang->line('sorumlu_personel') ?></label>

                        <select name="sorumlu_pers_id" class="form-control margin-bottom">
                            <?php

                            foreach (personel_list() as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('calisma_sekli') ?></label>

                        <select name="calisma_sekli" class="form-control margin-bottom">
                            <?php

                            foreach (calisma_sekli(1) as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="col-form-label"
                               for="ise_baslangic_tarihi"><?php echo $this->lang->line('ise_baslangic_tarihi') ?></label>

                        <div class="input-group">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="date_created"
                                   data-toggle="datepicker"
                                   autocomplete="false">
                        </div>
                    </div>

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="city"> <?php echo $this->lang->line('sozlesme_turu') ?>
                    </label>

                        <select name="sozlesme_turu" class="form-control margin-bottom">
                            <?php

                            foreach (calisma_sekli(2) as $row) {
                                echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>


                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('sozlesme_tarihi') ?></label>
                        <input type="text" class="form-control"
                               placeholder="Sözleşme Tarihi" name="sozlesme_date" id="sozlesme_date"
                               data-toggle="datepicker"
                               autocomplete="false">
                    </div>

                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name">Sorumlu Kişi</label>
                        <input type="text" name="sorumlu_kisi" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="phone">Birim</label>
                        <input type="text" class="form-control margin-bottom birim"  name="birim" placeholder="Şantiye">


                    </div>
                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="phone">Firma Durumu</label>
                        <input type="text" class="form-control margin-bottom firma_durumu"  name="firma_durumu" placeholder="Bizde">


                    </div>



                </div>



                <div class="form-group row">

                    <div class="col-sm-4">
                    <label class="col-form-label"></label>


                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>"
                               data-loading-text="Adding...">
                        <input type="hidden" value="employee/submit_user" id="action-url">
                    </div>
                </div>

            </div>

        </form>
    </div>

</div>
</div>

<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
</script>

<script>

    function actionProduct1(actionurl) {

        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });


    }



    $(document).on('keyup', ".resmi_maas", function (e) {
        var resmi_maas = $(this).val();
        if(resmi_maas=='')
        {
            resmi_maas=0;
        }
        var maas_toplam=$('.salary').val();
        var gayri_resmi=parseFloat(maas_toplam)-parseFloat(resmi_maas);
        $('.gayri_resmi_maas').val(gayri_resmi.toFixed(2));

    });
    $(document).on('keyup', ".gayri_resmi_maas", function (e) {
        var resmi_maas = $(this).val();
        if(resmi_maas=='')
        {
            resmi_maas=0;
        }
        var maas_toplam=$('.salary').val();
        var gayri_resmi=parseFloat(maas_toplam)-parseFloat(resmi_maas);
        $('.resmi_maas').val(gayri_resmi.toFixed(2));

    });
</script>