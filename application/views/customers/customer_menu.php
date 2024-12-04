<div class="row mt-3">
    <div class="col-md-12">
        <!--a href="<?php echo base_url('transactions/add') ?>"
           class="btn btn-blue btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('yeni_islem') ?></a-->
        <a href="<?php echo base_url('customers/view?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="fa fa-user"></i> <?php echo $this->lang->line('View') ?></a>
        <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?>
        </a>
        <a href="<?php echo base_url('customers/alt_invoices?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="fa fa-file-text"></i>Alt Cari Faturaları
        </a>
        <a  href='#pop_model_alacaklandirma_musteri' data-toggle='modal' data-remote='false'  class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1" id="customer_alacaklandir_musteri">
            <i class="fa fa-money" aria-hidden="true" title="Yeni Ekle"></i>Alacaklandır / Borçlandır
        </a>
        <a  href='#pop_model_kontrol' data-toggle='modal' data-remote='false'  class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1" id="kontrol_customer">
            <i class="fa fa-file" aria-hidden="true" title="Kontrol Notu Ekle"></i>Kontrol Notu Ekle
        </a>



        <!--a href="<?php echo base_url('customers/statement_sozlesme?para_birimi=tumu&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> Sözleşme Ekstresi</a>

        <a href="<?php echo base_url('customers/statement?para_birimi=tumu&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('tumu_hesap_ekstresi') ?></a>

        <a href="<?php echo base_url('customers/statement?para_birimi=AZN&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                class="fa fa-money"></i> <?php echo $this->lang->line('azn_hesap_ekstresi') ?>
        </a>
        <a href="<?php echo base_url('customers/statement?para_birimi=TRY&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('tl_hesap_ekstresi') ?>
        </a>
        <a href="<?php echo base_url('customers/statement?para_birimi=USD&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('usd_hesap_ekstresi') ?>
        </a>
        <a href="<?php echo base_url('customers/statement?para_birimi=EUR&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('euro_hesap_ekstresi') ?>
        </a>
        <a href="<?php echo base_url('customers/statement?para_birimi=RUB&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('rub_hesap_ekstresi') ?>
        </a>
            <a href="<?php echo base_url('customers/siparis_ekstre?para_birimi=tumu&id=' . $details['id']) ?>"
           class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                    class="fa fa-money"></i> <?php echo $this->lang->line('siparis_hesap_ekstresi') ?>
        </a-->


        <a href="<?php echo base_url('customers/avanstalep?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="fa fa-quote-left"></i> Avans Talepleri
        </a>

        <a href="<?php echo base_url('customers/quotes?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="fa fa-quote-left"></i> <?php echo $this->lang->line('Quotes') ?>
        </a> <a href="<?php echo base_url('customers/projects?id=' . $details['id']) ?>"
                class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-2"><i
                    class="fa fa-bullhorn"></i> <?php echo $this->lang->line('Projects') ?>
        </a>
        <a href="<?php echo base_url('razilastirma/list/' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-2"><i
                    class="fa fa-bullhorn"></i>Razılaştırma Listesi
        </a>
        <!--a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>&t=sub"
           class="btn btn-flickr btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('Subscriptions') ?>
        </a-->
        <a href="<?php echo base_url('customers/notes?id=' . $details['id']) ?>"
           class="btn btn-light btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                    class="fa fa-book"></i> <?php echo $this->lang->line('Notes') ?>
        </a>


        <!--a href="<?php echo base_url('customers/documents?id=' . $details['id']) ?>"
           class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                class="icon-folder"></i> <?php echo $this->lang->line('Documents') ?>
        </a-->
        <a href="<?php echo base_url('customers/randevu_list?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                    class="icon-folder"></i> Randevu Listesi
        </a>
        <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
           class="btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1 btn btn-info btn-md"><i
                    class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
        </a>


        <button type="button"
           class="changepassword btn btn-light btn-md mr-1 mb-1 btn-block btn-lighten-1 btn btn-danger btn-md"><i
                    class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
        </button>


    </div>
</div>
<input type="hidden" id="cari_id_hidden" value="<?php echo $details['id'] ?>">

<style>
    #dpic
    {
        width: 100% !important;
        height: auto !important;
    }
</style>
<script>
    $('.changepassword').on('click',function (){
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html += `<form>
                          <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">Kullanıcı Giriş Numarası</label>
                                  <input type="number" class="form-control number" placeholder="">
                             </div>
                            </div>
                         <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="name">Kullanıcı Giriş Şifresi</label>
                                  <input type="text" class="form-control pass" placeholder="Kullanıcı Giriş Şifresi">
                             </div>
                        </div>
                    </form>`;

                let data = {
                    crsf_token: crsf_hash,
                    cari_id: $('#cari_id_hidden').val()
                }

                let table_report='';
                $.post(baseurl + 'customers/customer_details',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    if(responses.cari_info){
                        $('.number').val(responses.cari_info.phone)
                    }
                    else {
                        $('.number').val(responses.cari_details.phone)
                    }
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let number = $('.number').val()
                        let pass = $('.pass').val()

                        let data = {
                            number:number,
                            crsf_token: crsf_hash,
                            pass: pass,
                            cari_id: $('#cari_id_hidden').val()
                        }
                        $.post(baseurl + 'customers/update_pass',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload()
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

                        });


                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm close",
                }
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
</script>
