<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Update Your Details') ?> (<?php echo $user['username'] ?> )</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>




<div class="content">
    <div class="card card-block bg-white">

    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>

        <?php
        $disabled='';
        if($eid==$this->aauth->get_user()->id)
        {
            $disabled='readonly';
        }
        if($this->aauth->get_user()->roleid==7 || $this->aauth->get_user()->roleid==9)
        {
            $disabled='';
        }
        ?>
    <div class="row">
        <div class="col-md-2 ">
            <div class="card card-block card-body">
                <h5><?php echo $this->lang->line('Update Profile Picture') ?></h5>
                <hr>
                <div class="ibox-content no-padding border-left-right">
                    <img alt="profile picture" id="dpic" class="img-responsive col"
                         src="<?php echo base_url('userfiles/employee/') . pesonel_picture_url($user['id']) ?>">
                </div>
                <hr>
                <p><label for="fileupload">Profil Fotoğrafı</label><input
                            id="fileupload" type="file"
                            name="files[]"></p></div>
            <!-- signature -->

            <div style="display: none" class="card card-block card-body"><h5><?php echo $this->lang->line('Update Your Signature') ?></h5>
                <hr>
                <div class="ibox-content no-padding border-left-right">
                    <img alt="sign_pic" id="sign_pic" class="img-responsive col col"
                         src="<?php echo base_url('userfiles/employee_sign/') . $user['sign'] ?>">
                </div>
                <hr>
                <p>
                    <label for="sign_fileupload"><?php echo $this->lang->line('Change Your Signature') ?></label><input
                            id="sign_fileupload" type="file"
                            name="files[]"></p></div>


        </div>
        <div class="col-md-10">

                <form method="post" id="product_action" class="form-horizontal">
                        <div class="col-sm-12">



                        <div class="form-group row">
                            <div class="col-sm-4">
                            <label class="col-form-label"
                                   for="name"><?php echo $this->lang->line('Name') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="Name"
                                       class="form-control margin-bottom  required" name="name"
                                       value="<?php echo $user['name'] ?>">
                            </div>
                            </div>

                        <div class="col-md-2">
                            <label class="col-form-label"
                                   for="ise_baslangic_tarihi"><?php echo $this->lang->line('ise_baslangic_tarihi') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="Name"
                                       class="form-control margin-bottom editdate" name="date_created" autocomplete="false"
                                       value="<?php echo dateformat($user['date_created']) ?>">
                            </div>
                        </div>

                            <div class="col-md-2">
                            <label class="col-form-label"
                                   for="birthday"><?php echo $this->lang->line('dogum_tarihi') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="Name"
                                       class="form-control margin-bottom editdate" name="birthday" autocomplete="false"
                                       value="<?php echo dateformat($user['birthday']) ?>">
                            </div>
                        </div>

                     <div class="col-md-4">
                            <label  class="col-form-label"
                                   for="address"><?php echo $this->lang->line('Address') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="address"
                                       class="form-control margin-bottom" name="address"
                                       value="<?php echo $user['address'] ?>">
                            </div>
                        </div>


                        </div>



                        <div class="form-group row">
                                <div class="col-md-4">
                            <label  class="col-form-label"
                                   for="city"><?php echo $this->lang->line('il_duzenle') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="city"
                                       class="form-control margin-bottom" name="city"
                                       value="<?php echo $user['city'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label  class="col-form-label"
                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="Country"
                                       class="form-control margin-bottom" name="country"
                                       value="<?php echo $user['country'] ?>">
                            </div>
                            </div>
                            <div class="col-md-4">
                           <label  class="col-form-label"
                                   for="country"><?php echo $this->lang->line('posta_kodu') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="Postbox"
                                       class="form-control margin-bottom" name="postbox"
                                       value="<?php echo $user['postbox'] ?>">
                            </div>
                            </div>
                        </div>




                        <div class="form-group row">
                                <div class="col-md-2">
                            <label  class="col-form-label"
                                   for="phone"><?php echo $this->lang->line('Phone') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="phone"
                                       class="form-control margin-bottom" name="phone"
                                       value="<?php echo $user['phone'] ?>">
                            </div>
                            </div>

                            <div class="col-md-2">
                                 <label  class="col-form-label"
                                   for="phone"><?php echo $this->lang->line('Phone2') ?></label>

                                <div class="input-group">
                                    <input type="text"
                                           class="form-control margin-bottom" name="phonealt"
                                           value="<?php echo $user['phonealt'] ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                 <label  class="col-form-label"
                                   for="phone"><?php echo $this->lang->line('fin_no') ?></label>

                                <div class="input-group">
                                    <input type="text"
                                           class="form-control margin-bottom" name="fin_no"
                                           value="<?php echo $user['fin_no'] ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                 <label  class="col-form-label"
                                   for="phone"><?php echo $this->lang->line('kan_grubu') ?></label>

                                <div class="input-group">
                                    <input type="text"
                                           class="form-control margin-bottom" name="kan_grubu"
                                           value="<?php echo $user['kan_grubu'] ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label  class="col-form-label"
                                   for="email"><?php echo $this->lang->line('Email') ?></label>

                            <div class="input-group">
                                <input type="text" placeholder="email"
                                       class="form-control margin-bottom  required" name="email"
                                       value="<?php echo $user['email'] ?>">
                            </div>
                            </div>
                        </div>


                        <div class="form-group row">
                                <div class="col-md-2">
                                    <label  class="col-form-label"
                                   for="name"><?php echo $this->lang->line('Business Location') ?></label>

                                <select <?php echo $disabled ?> name="location" class="form-control margin-bottom">
                                    <option value="<?php echo $user['loc'] ?>"><?php echo $this->lang->line('Do not change') ?></option>
                                    <option value="0"><?php echo $this->lang->line('Default') ?></option>
                                    <?php $loc = locations();

                                    foreach ($loc as $row) {
                                         $id = $row['id'];
                                     $loc = $row['cname'];
                                 if($row['id']==$user['loc'])
                                {
                                    echo "<option selected value='$id'>$loc</option>";

                                }else{
                                        echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                                    }
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label"
                                       for="roleid"><?php echo $this->lang->line('UserRole') ?></label>


                                <select   name="roleid" class="form-control margin-bottom">
                                    <?php foreach (role_name() as $rol){
                                        if($rol['role_id']==$user['roleid'])
                                        {
                                            ?>   <option selected value="<?= $rol['role_id'] ?>"><?= $rol['name'] ?></option><?php
                                        }
                                        else {
                                            ?>
                                            <option value="<?= $rol['role_id'] ?>"><?= $rol['name'] ?></option>
                                            <?php
                                        }
                                        ?>



                                    <?php } ?>

                                </select>
                            </div>
                             <?php if ($this->aauth->get_user()->roleid >= 0) { ?>

                            <div class="col-md-2">
                                <label class="col-form-label"
                                       for="roleid"><?php echo $this->lang->line('vatandaslik') ?></label>


                                <select name="vatandaslik"
                                        class="form-control margin-bottom">
                                    <?php foreach (vatandaslik() as $rol){
                                        if($rol['id']==$user['vatandaslik'])
                                        {
                                            ?>   <option selected value="<?= $rol['id'] ?>"><?= $rol['name'] ?></option><?php
                                        }
                                        else {
                                            ?>
                                            <option value="<?= $rol['id'] ?>"><?= $rol['name'] ?></option>
                                            <?php
                                        }
                                        ?>



                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label"
                                       for="roleid"><?php echo $this->lang->line('cinsiyet') ?></label>


                                <select name="cinsiyet"
                                        class="form-control margin-bottom">

                                    <?php if($user['cinsiyet']=='Kadın'){
                                        ?>
                                        <option selected value="Kadın">Kadın</option>
                                        <option  value="Erkek">Erkek</option>

                                        <?php
                                    } else { ?>
                                        <option  value="Kadın">Kadın</option>
                                        <option selected  value="Erkek">Erkek</option>
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label"
                                       for="roleid"><?php echo $this->lang->line('medeni_durumu') ?></label>


                                <select name="medeni_durumu"
                                        class="form-control margin-bottom">

                                    <?php if($user['medeni_durumu']=='Bekar'){
                                        ?>
                                        <option selected value="Bekar">Bekar</option>
                                        <option  value="Evli">Evli</option>

                                        <?php
                                    } else { ?>
                                        <option  value="Bekar">Bekar</option>
                                        <option selected  value="Evli">Evli</option>
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label"
                                       for="roleid"><?php echo $this->lang->line('cocuk_durumu') ?></label>


                                <select name="cocuk_durumu"
                                        class="form-control margin-bottom">

                                    <?php if($user['cocuk_durumu']=='Var'){
                                        ?>
                                        <option selected value="Var">Var</option>
                                        <option  value="Yok">Yok</option>

                                        <?php
                                    } else { ?>
                                        <option selected value="Yok">Yok</option>
                                        <option   value="Var">Var</option>
                                    <?php } ?>

                                </select>
                            </div>




                                </div>



                        <?php } ?>
                       <div class="form-group row">

                    <!--div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('Salary') ?></label>


                        <input <?php echo $disabled ?>  type="text"  onkeypress="return isNumber(event)"
                               class="form-control margin-bottom salary" name="salary"
                               value="<?php echo $user['salary'] ?>">
                    </div>
                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('resmi_maas') ?></label>


                        <input <?php echo $disabled ?>  type="text" onkeypress="return isNumber(event)"
                               class="form-control margin-bottom resmi_maas" min="0" name="resmi_maas"
                               value="<?php echo $user['resmi_maas'] ?>">
                    </div>
                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('gayri_resmi_maas') ?></label>


                        <input <?php echo $disabled ?>  type="text"  onkeypress="return isNumber(event)"
                               class="form-control margin-bottom gayri_resmi_maas" min="0" name="gayri_resmi_maas"
                               value="<?php echo $user['gayri_resmi_maas'] ?>">
                    </div!-->

                </div>


                              <div class="form-group row">

                                  <div class="col-sm-2">
                                      <label class="col-form-label"
                                             for="city"> <?php echo $this->lang->line('Commission') ?>
                                          %</label>


                                      <input <?php echo $disabled ?>  type="number" value="<?php echo $user['c_rate'] ?>"
                                                                      class="form-control margin-bottom" name="commission">

                                      <small class="col">Tüm Satışlarda Geçerli Olacaktır.
                                      </small>
                                  </div>


                                  <div class="col-sm-4">
                                      <label class="col-form-label"
                                             for="name"><?php echo $this->lang->line('Department') ?></label>
                                      <select <?php echo $disabled ?>  name="department" class="form-control margin-bottom">

                                          <option value="0"><?php echo $this->lang->line('Default') ?></option>
                                          <?php

                                          foreach ($dept as $row) {
                                              $id = $row['id'];
                                              $department = $row['val1'];
                                              if($row['id']==$user['dept'])
                                              { echo "<option selected value='$id'>$department</option>";

                                              }else{
                                                  echo ' <option value="' . $row['id'] . '"> ' . $row['val1'] . '</option>';
                                              }
                                          }

                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-sm-2">
                                      <label class="col-form-label"
                                             for="phone"><?php echo $this->lang->line('sorumlu_personel') ?></label>

                                      <select name="sorumlu_pers_id" class="form-control margin-bottom select-box">
                                          <?php

                                          foreach (personel_list() as $row) {
                                              $id = $row['id'];
                                              $name = $row['name'];
                                              if($row['id']==$user['sorumlu_pers_id'])
                                              {
                                                  echo "<option selected value='$id'>$name</option>";

                                              }
                                              else {
                                                  echo ' <option value="' . $id . '"> ' . $name . '</option>';
                                              }
                                          }

                                          ?>
                                      </select>
                                  </div>

                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="phone"><?php echo $this->lang->line('calisma_sekli') ?></label>

                        <select <?php echo $disabled ?>  name="calisma_sekli" class="form-control margin-bottom">

                            <?php

                            foreach (calisma_sekli(1) as $row) {
                                 $id = $row['id'];
                                $calisma_sekli = $row['name'];
                                 if($row['id']==$user['calisma_sekli'])
                                { echo "<option selected value='$id'>$calisma_sekli</option>";

                                }
                                else {
                                    echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                                }

                            }

                            ?>
                        </select>
                    </div>


                    <div class="col-sm-2">
                    <label class="col-form-label"
                           for="city"> <?php echo $this->lang->line('sozlesme_turu') ?>
                    </label>

                        <select <?php echo $disabled ?>  name="sozlesme_turu" class="form-control margin-bottom">
                            <?php

                            foreach (calisma_sekli(2) as $row) {
                                 $id = $row['id'];
                                $sozlesme_turu = $row['name'];
                                 if($row['id']==$user['sozlesme_turu'])
                                {
                                    echo "<option selected value='$id'>$sozlesme_turu</option>";

                                }
                                else {
                                  echo ' <option value="' . $row['id'] . '"> ' . $row['name'] . '</option>';
                                }



                            }

                            ?>
                        </select>
                    </div>


                    <div class="col-sm-2">
                        <label class="col-form-label"
                               for="name"><?php echo $this->lang->line('sozlesme_tarihi') ?></label>
                        <input <?php echo $disabled ?>  type="text" class="form-control"
                               placeholder="Sözleşme Tarihi" name="sozlesme_date" id="sozlesme_date"
                               data-toggle="datepicker"
                               autocomplete="false">
                    </div>

                  <div class="col-sm-2">
                      <label class="col-form-label"
                             for="name"><?php echo $this->lang->line('ayrilma_tarihi') ?></label>
                      <input <?php echo $disabled ?>  type="text" class="form-control"
                                                      placeholder="Sözleşme Tarihi" name="ayrilma_date" id="ayrilma_date"
                                                      data-toggle="datepicker"
                                                      autocomplete="false">
                  </div>
                  <div class="col-sm-1">
                      <label class="col-form-label"
                             for="name"><?php echo $this->lang->line('ayrilma_sebebi') ?></label>
                      <input <?php echo $disabled ?>  type="text" class="form-control"
                                                      placeholder="Ayrılma Nedeni" name="ayrilma_sebebi" id="ayrilma_sebebi">
                  </div>

                                  <div class="col-sm-1">
                                      <label class="col-form-label"
                                             for="name">Sorumlu Kişi</label>
                                      <input type="text" name="sorumlu_kisi"  value="<?php echo $user['sorumlu_kisi'] ?>" class="form-control">
                                  </div>
                                  <div class="col-sm-2">
                                      <label class="col-form-label"
                                             for="phone">Birim</label>
                                      <input type="text" class="form-control margin-bottom birim"  name="birim" value="<?php echo $user['birim'] ?>">


                                  </div>
                </div>

                            <div class="form-group row">

                                <!--div class="col-sm-2">
                                    <label class="col-form-label"
                                           for="phone">Firma Durumu</label>
                                    <input type="text" class="form-control margin-bottom firma_durumu"  name="firma_durumu" value="<?php echo $user['firma_durumu'] ?>">


                                </div>


                                    <div class="col-md-2">
                                        <label class="col-form-label"
                                               for="roleid">Çalıştığı Proje</label>


                                        <select name="proje_id"
                                                class="form-control margin-bottom select-box" >
                                            <?php foreach (all_projects() as $projects){
                                                if($projects->id==$user['proje_id'])
                                                {
                                                    ?>   <option selected value="<?= $projects->id ?>"><?= $projects->name ?></option><?php
                                                }
                                                else {
                                                    ?>
                                                    <option value="<?= $projects->id ?>"><?= $projects->name ?></option>
                                                    <?php
                                                }
                                                ?>



                                            <?php } ?>
                                        </select>
                                     </div>
                                    <div class="col-md-2">
                                        <label class="col-form-label"
                                               for="roleid">Maaş Tipi</label>


                                        <select name="salary_type"
                                                class="form-control margin-bottom select-box" >
                                            <?php foreach (salary_type() as $type){
                                                if($type->id==$user['salary_type'])
                                                {
                                                    ?>   <option selected value="<?= $type->id ?>"><?= $type->name ?></option><?php
                                                }
                                                else {
                                                    ?>
                                                    <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                                    <?php
                                                }
                                                ?>



                                            <?php } ?>
                                        </select>
                                     </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label"
                                               for="roleid">Günlük</label>
                                        <input type="number" class="form-control margin-bottom"  name="salary_gunluk" value="<?php echo $user['salary_gunluk'] ?>">
                                     </div!-->



                            </div>




                        <div class="form-group row">
                            <div class="col-md-4">
                                 <input type="hidden"
                               name="eid"
                               value="<?php echo $user['id'] ?>">
                            </div>
                        </div>



                        <div class="form-group row">

                            <label class="col-form-label" ></label>

                            <div class="col-sm-4">
                                <input type="submit" id="profile_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update') ?>"
                                       data-loading-text="Updating...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $("#profile_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'employee/update';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    $(function () {

        $('.select-box').select2();
    });
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>employee/displaypic';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'id':<?php echo $user['id'] ?>},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');


                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/employee/' + data.result + '?' + new Date().getTime());

            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');


        // Sign
        var sign_url = '<?php echo base_url() ?>employee/user_sign?id=<?php echo $user['id'] ?>';
        $('#sign_fileupload').fileupload({
            url: sign_url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#sign_pic").attr('src', '<?php echo base_url() ?>userfiles/employee_sign/' + data.result + '?' + new Date().getTime());


            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
    $('.editdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});


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
