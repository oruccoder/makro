/* ------------------------------------------------------------------------------
 *
 *  # Steps wizard
 *
 *  Demo JS code for form_wizard.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var FormWizard = function() {


    //
    // Setup module components
    //

    // Wizard
    var _componentWizard = function() {
        if (!$().steps) {
            console.warn('Warning - steps.min.js is not loaded.');
            return;
        }

        // Basic wizard setup
        $('.steps-basic').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Geri',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'İleri <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Kayıt <i class="icon-paperplane ml-2"></i>'
            },
            onFinished: function (event, currentIndex) {
                let url =$('#add_modal').val();
                let cari_list =$('#cari_list').val();
                let csr =$('#csr').val();

                // Cari Bilgileri
                let company = $('#modal-add-company').val();
                let parent_id = $('#modal-add-parent_id').val();
                let country_id = $('#modal-add-country_id').val();
                let zone_id = $('#modal-add-zone_id').val();
                let rayon_id = $('#modal-add-rayon_id').val();
                let adres = $('#modal-add-adres').val();
                let gsm = $('#modal-add-gsm').val();
                let phone = $('#modal-add-phone').val();
                let email = $('#modal-add-email').val();
                let image = $('#modal-add-image').val();
                let sorumlu_pers_id = $('#modal-add-sorumlu_pers_id').val();
                let group_id = $('#modal-add-group_id').val();
                let cari_tip_id = $('#modal-add-cari_tip_id').val();
                let sektor_id = $('#modal-add-sektor_id').val();
                let voen = $('#modal-add-voen').val();
                let teminat_id = $('#modal-add-teminat_id').val();
                let teminat_aciklamasi = $('#modal-add-teminat_aciklamasi').val();
                let fullname = $('#modal-add-fullname').val();
                let f_kredi_tutari = $('#f_kredi_tutari').val();
                let kredi_turari = $('#kredi_turari').val();
                // Cari Bilgileri
                let length_ = $('.banka_adi').length;
                let banka_ar=[];
                let hesap_ar=[];
                let swift_ar=[];
                let iden_ar=[];
                let mux_ar=[];
                let banka_adresi_ar=[];
                let bankatel_ar=[];
                let bankafax_ar=[];
                let kod_ar=[];
                let banka_voen_ar=[];
                let para_birimi_ar=[];
                for (let i =0; i < length_; i++ )
                {
                    banka_ar.push($('.banka_adi').eq(i).val());
                    hesap_ar.push($('.hesap_no').eq(i).val());
                    swift_ar.push($('.swift').eq(i).val());
                    iden_ar.push($('.id_no').eq(i).val());
                    mux_ar.push($('.muxbir_hesap').eq(i).val());
                    banka_adresi_ar.push($('.banka_adresi').eq(i).val());
                    bankatel_ar.push($('.banka_tel').eq(i).val());
                    bankafax_ar.push($('.banka_fax').eq(i).val());
                    kod_ar.push($('.kod').eq(i).val());
                    banka_voen_ar.push($('.banka_voen').eq(i).val());
                    para_birimi_ar.push($('.para_birimi_id').eq(i).val());
                }
                // Cari Bilgileri

                // Cari Personelleri
                let length_p = $('.pers_fullname').length;

                let pers_fullname_ar=[];
                let pers_description_ar=[];
                let pers_mail_ar=[];
                let departman_ar=[];
                let pers_gsm_ar=[];
                for (let j =0; j < length_p; j++ )
                {
                    pers_fullname_ar.push($('.pers_fullname').eq(j).val());
                    pers_description_ar.push($('.pers_description').eq(j).val());
                    pers_mail_ar.push($('.pers_mail').eq(j).val());
                    departman_ar.push($('.departman').eq(j).val());
                    pers_gsm_ar.push($('.pers_gsm').eq(j).val());
                }
                // Cari Personelleri
                $.post(url,
                    {
                        _token: csr,
                        parent_id: parent_id,
                        company: company,
                        country_id: country_id,
                        zone_id: zone_id,
                        rayon_id: rayon_id,
                        adres: adres,
                        gsm: gsm,
                        phone: phone,
                        email: email,
                        image: image,
                        sorumlu_pers_id: sorumlu_pers_id,
                        group_id: group_id,
                        cari_tip_id: cari_tip_id,
                        sektor_id: sektor_id,
                        voen: voen,
                        teminat_id: teminat_id,
                        teminat_aciklamasi: teminat_aciklamasi,
                        fullname: fullname,
                        banka : banka_ar,
                        hesap : hesap_ar,
                        swift : swift_ar,
                        iden : iden_ar,
                        mux : mux_ar,
                        banka_adresi : banka_adresi_ar,
                        bankatel : bankatel_ar,
                        bankafax : bankafax_ar,
                        kod : kod_ar,
                        banka_voen : banka_voen_ar,
                        para_birimi : para_birimi_ar,
                        pers_fullname:pers_fullname_ar,
                        pers_mail:pers_mail_ar,
                        pers_description:pers_description_ar,
                        departman:departman_ar,
                        pers_gsm:pers_gsm_ar,
                        f_kredi_tutari:f_kredi_tutari,
                        kredi_turari:kredi_turari,
                    },function(response){
                        if(response.code == 410){
                            response.error.forEach((error) => {
                                new Noty({
                                    text: error,
                                    type: 'error',
                                    theme: 'limitless',
                                    layout: 'topRight',
                                    timeout: 2500
                                }).show();
                            });
                            return false;
                        }
                        if(response.code == 200){
                            $('#modal-add-form')[0].reset();
                            $('#modal-add-container').modal('hide');
                            let cari_list =$('#cari_list').val();
                            datatable.ajax.url(cari_list).load();
                            new Noty({
                                text: response.message,
                                type: 'success',
                                theme: 'limitless',
                                layout: 'topRight',
                                timeout: 2500
                            }).show();
                        }
                    });

            }
        });

        $('.steps-basic_update').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Geri',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'İleri <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Kayıt <i class="icon-paperplane ml-2"></i>'
            },
            onFinished: function (event, currentIndex) {
                let url =$('#update_modal').val();
                let cari_list =$('#cari_list').val();
                let csr =$('#csr').val();
                let id = $('#modal-update-id').val();
                // Cari Bilgileri
                let company = $('#modal-update-company').val();
                let parent_id = $('#modal-update-parent_id').val();
                let country_id = $('#modal-update-country_id').val();
                let zone_id = $('#modal-update-zone_id').val();
                let rayon_id = $('#modal-update-rayon_id').val();
                let adres = $('#modal-update-adres').val();
                let gsm = $('#modal-update-gsm').val();
                let phone = $('#modal-update-phone').val();
                let email = $('#modal-update-email').val();
                let image = $('#modal-update-image').val();
                let sorumlu_pers_id = $('#modal-update-sorumlu_pers_id').val();
                let group_id = $('#modal-update-group_id').val();
                let cari_tip_id = $('#modal-update-cari_tip_id').val();
                let sektor_id = $('#modal-update-sektor_id').val();
                let voen = $('#modal-update-voen').val();
                let teminat_id = $('#modal-update-teminat_id').val();
                let teminat_aciklamasi = $('#modal-update-teminat_aciklamsi').val();
                let fullname = $('#modal-update-fullname').val();
                let f_kredi_tutari = $('#f_kredi_tutari').val();
                let kredi_turari = $('#kredi_turari').val();
                // Cari Bilgileri
                // Mağaza Bilgileri
                let api_key = $('#modal-update-api-key').val();
                let api_secret = $('#modal-update-api-secret').val();
                let seller_id = $('#modal-update-seller-id').val();
                // Mağaza Bilgileri
                let length_ = $('.update_banka_adi').length;
                let banka_ar=[];
                let hesap_ar=[];
                let swift_ar=[];
                let iden_ar=[];
                let mux_ar=[];
                let banka_adresi_ar=[];
                let bankatel_ar=[];
                let bankafax_ar=[];
                let kod_ar=[];
                let banka_voen_ar=[];
                let para_birimi_ar=[];
                for (let i =0; i < length_; i++ )
                {
                    banka_ar.push($('.update_banka_adi').eq(i).val());
                    hesap_ar.push($('.update_hesap_no').eq(i).val());
                    swift_ar.push($('.update_swift').eq(i).val());
                    iden_ar.push($('.update_id_no').eq(i).val());
                    mux_ar.push($('.update_muxbir_hesap').eq(i).val());
                    banka_adresi_ar.push($('.update_banka_adresi').eq(i).val());
                    bankatel_ar.push($('.update_banka_tel').eq(i).val());
                    bankafax_ar.push($('.update_banka_fax').eq(i).val());
                    kod_ar.push($('.update_kod').eq(i).val());
                    banka_voen_ar.push($('.update_banka_voen').eq(i).val());
                    para_birimi_ar.push($('.update_para_birimi_id').eq(i).val());
                }
                // Cari Bilgileri

                // Cari Personelleri
                let length_p = $('.update_pers_fullname').length;

                let pers_fullname_ar=[];
                let pers_description_ar=[];
                let pers_mail_ar=[];
                let departman_ar=[];
                let pers_gsm_ar=[];
                for (let j =0; j < length_p; j++ )
                {
                    pers_fullname_ar.push($('.update_pers_fullname').eq(j).val());
                    pers_description_ar.push($('.update_pers_description').eq(j).val());
                    pers_mail_ar.push($('.update_pers_mail').eq(j).val());
                    departman_ar.push($('.update_departman').eq(j).val());
                    pers_gsm_ar.push($('.update_pers_gsm').eq(j).val());
                }
                // Cari Personelleri
                $.post(url,
                    {
                        _token: csr,
                        id: id,
                        company: company,
                        parent_id: parent_id,
                        country_id: country_id,
                        zone_id: zone_id,
                        rayon_id: rayon_id,
                        adres: adres,
                        gsm: gsm,
                        phone: phone,
                        email: email,
                        image: image,
                        sorumlu_pers_id: sorumlu_pers_id,
                        group_id: group_id,
                        cari_tip_id: cari_tip_id,
                        sektor_id: sektor_id,
                        voen: voen,
                        teminat_id: teminat_id,
                        teminat_aciklamasi: teminat_aciklamasi,
                        fullname: fullname,
                        banka : banka_ar,
                        hesap : hesap_ar,
                        swift : swift_ar,
                        iden : iden_ar,
                        mux : mux_ar,
                        banka_adresi : banka_adresi_ar,
                        bankatel : bankatel_ar,
                        bankafax : bankafax_ar,
                        kod : kod_ar,
                        banka_voen : banka_voen_ar,
                        para_birimi : para_birimi_ar,
                        pers_fullname:pers_fullname_ar,
                        pers_mail:pers_mail_ar,
                        pers_description:pers_description_ar,
                        departman:departman_ar,
                        pers_gsm:pers_gsm_ar,
                        f_kredi_tutari:f_kredi_tutari,
                        kredi_turari:kredi_turari,
                        api_key:api_key,
                        api_secret:api_secret,
                        seller_id:seller_id,
                    },function(response){
                        if(response.code == 410){
                            response.error.forEach((error) => {
                                new Noty({
                                    text: error,
                                    type: 'error',
                                    theme: 'limitless',
                                    layout: 'topRight',
                                    timeout: 2500
                                }).show();
                            });
                            return false;
                        }
                        if(response.code == 200){
                            $('#modal-update-form')[0].reset();
                            $('#modal-update-container').modal('hide');
                            let cari_list =$('#cari_list').val();
                            datatable.ajax.url(cari_list).load();
                            new Noty({
                                text: response.message,
                                type: 'success',
                                theme: 'limitless',
                                layout: 'topRight',
                                timeout: 2500
                            }).show();
                        }
                    });

            }
        });

        // Personel Kartı Ekleme
        $('.steps-async').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            loadingTemplate: '<div class="card-body text-center"><i class="icon-spinner2 spinner mr-2"></i>  #text#</div>',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Geri',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'İleri <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Kayıt <i class="icon-paperplane ml-2"></i>'
            },
            onContentLoaded: function (event, currentIndex) {
                $(this).find('.card-body').addClass('hide');
            },
            onFinished: function (event, currentIndex) {
                let url =$('#add_modal').val();
                let name = $('#modal-add-name').val();
                let email = $('#modal-add-email').val();
                let password = $('#modal-add-password').val();
                let role_id = $('#modal-add-role').val();
                let vatandaslik=$('#modal-add-vatandaslik').val();
                let cinsiyet=$('#modal-add-cinsiyet').val();
                let dogum_tarihi=$('#modal-add-dogum_tarihi').val();
                let kan_grubu=$('#modal-add-kan_grubu').val();
                let fin_kodu=$('#modal-add-fin_kodu').val();
                let medeni_durumu=$('#modal-add-medeni_durumu').val();
                let cocuk_durumu=$('#modal-add-cocuk_durumu').val();
                let country_id=$('#modal-add-country_id').val();
                let zone_id=$('#modal-add-zone_id').val();
                let rayon_id=$('#modal-add-rayon_id').val();
                let acik_adres=$('#modal-add-acik_adres').val();
                let telefon=$('#modal-add-telefon').val();
                let ad_telefon=$('#modal-add-ad_telefon').val();
                let maas=$('#modal-add-maas').val();
                let banka_maas=$('#modal-add-banka_maas').val();
                let nakit_maas=$('#modal-add-nakit_maas').val();
                let komisyon_orani=$('#modal-add-komisyon_orani').val();
                let department=$('#modal-add-department').val();
                let sorumlu_user=$('#modal-add-sorumlu_user').val();
                let sorumlu_kisi='Rugviva';
                let calisma_sekli=$('#modal-add-calisma_sekli').val();
                let ise_baslama_date=$('#modal-add-ise_baslama_date').val();
                let sozlesme_tarihi=$('#modal-add-ise_baslama_date').val();
                let firma_durumu=1;
                $.post(url,
                    {
                        _token: $('#csr').val(),
                        name: name,
                        email: email,
                        role_id: role_id,
                        password: password,
                        vatandaslik:vatandaslik,
                        cinsiyet:cinsiyet,
                        dogum_tarihi:dogum_tarihi,
                        kan_grubu:kan_grubu,
                        fin_kodu:fin_kodu,
                        medeni_durumu:medeni_durumu,
                        cocuk_durumu:cocuk_durumu,
                        country_id:country_id,
                        zone_id:zone_id,
                        rayon_id:rayon_id,
                        acik_adres:acik_adres,
                        telefon:telefon,
                        ad_telefon:ad_telefon,
                        maas:maas,
                        banka_maas:banka_maas,
                        nakit_maas:nakit_maas,
                        komisyon_orani:komisyon_orani,
                        department:department,
                        sorumlu_user:sorumlu_user,
                        sorumlu_kisi:sorumlu_kisi,
                        calisma_sekli:calisma_sekli,
                        ise_baslama_date:ise_baslama_date,
                        sozlesme_tarihi:sozlesme_tarihi,
                        firma_durumu:firma_durumu
                    },function(response){
                        if(response.code == 410){
                            response.error.forEach((error) => {
                                new Noty({
                                    text: error,
                                    type: 'error',
                                    theme: 'limitless',
                                    layout: 'topRight',
                                    timeout: 2500
                                }).show();
                            });
                            return false;
                        }
                        if(response.code == 200){
                            $('#modal-add-form')[0].reset();
                            $('#modal-add-container').modal('hide');
                            let user_list =$('#user_list').val();
                            datatable.ajax.url(user_list).load();
                            new Noty({
                                text: response.message,
                                type: 'success',
                                theme: 'limitless',
                                layout: 'topRight',
                                timeout: 2500
                            }).show();
                        }
                    });
            }
        });

        $('.steps-async_update').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            titleTemplate: '<span class="number">#index#</span> #title#',
            loadingTemplate: '<div class="card-body text-center"><i class="icon-spinner2 spinner mr-2"></i>  #text#</div>',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Geri',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'İleri <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Güncelle <i class="icon-paperplane ml-2"></i>'
            },
            onContentLoaded: function (event, currentIndex) {
                $(this).find('.card-body').addClass('hide');
            },
            onFinished: function (event, currentIndex) {
                let id = $('#modal-update-id').val();
                let url =$('#update_modal').val();
                let name = $('#modal-update-name').val();
                let email = $('#modal-update-email').val();
                let password = $('#modal-update-password').val();
                let role_id = $('#modal-update-role').val();
                let vatandaslik=$('#modal-update-vatandaslik').val();
                let cinsiyet=$('#modal-update-cinsiyet').val();
                let dogum_tarihi=$('#modal-update-dogum_tarihi').val();
                let kan_grubu=$('#modal-update-kan_grubu').val();
                let fin_kodu=$('#modal-update-fin_kodu').val();
                let medeni_durumu=$('#modal-update-medeni_durumu').val();
                let cocuk_durumu=$('#modal-update-cocuk_durumu').val();
                let country_id=$('#modal-update-country_id').val();
                let zone_id=$('#modal-update-zone_id').val();
                let rayon_id=$('#modal-update-rayon_id').val();
                let acik_adres=$('#modal-update-acik_adres').val();
                let telefon=$('#modal-update-telefon').val();
                let ad_telefon=$('#modal-update-ad_telefon').val();
                let maas=$('#modal-update-maas').val();
                let banka_maas=$('#modal-update-banka_maas').val();
                let nakit_maas=$('#modal-update-nakit_maas').val();
                let komisyon_orani=$('#modal-update-komisyon_orani').val();
                let department=$('#modal-update-department').val();
                let sorumlu_user=$('#modal-update-sorumlu_user').val();
                let sorumlu_kisi='Rugviva';
                let calisma_sekli=$('#modal-update-calisma_sekli').val();
                let ise_baslama_date=$('#modal-update-ise_baslama_date').val();
                let sozlesme_tarihi=$('#modal-update-ise_baslama_date').val();
                let firma_durumu=1;
                $.post(url,
                    {
                        _token: $('#csr').val(),
                        id: id,
                        name: name,
                        email: email,
                        role_id: role_id,
                        password: password,
                        vatandaslik:vatandaslik,
                        cinsiyet:cinsiyet,
                        dogum_tarihi:dogum_tarihi,
                        kan_grubu:kan_grubu,
                        fin_kodu:fin_kodu,
                        medeni_durumu:medeni_durumu,
                        cocuk_durumu:cocuk_durumu,
                        country_id:country_id,
                        zone_id:zone_id,
                        rayon_id:rayon_id,
                        acik_adres:acik_adres,
                        telefon:telefon,
                        ad_telefon:ad_telefon,
                        maas:maas,
                        banka_maas:banka_maas,
                        nakit_maas:nakit_maas,
                        komisyon_orani:komisyon_orani,
                        department:department,
                        sorumlu_user:sorumlu_user,
                        sorumlu_kisi:sorumlu_kisi,
                        calisma_sekli:calisma_sekli,
                        ise_baslama_date:ise_baslama_date,
                        sozlesme_tarihi:sozlesme_tarihi,
                        firma_durumu:firma_durumu
                    },function(response){
                        if(response.code == 410){
                            response.error.forEach((error) => {
                                new Noty({
                                    text: error,
                                    type: 'error',
                                    theme: 'limitless',
                                    layout: 'topRight',
                                    timeout: 2500
                                }).show();
                            });
                            return false;
                        }
                        if(response.code == 200){
                            $('#modal-update-form')[0].reset();
                            $('#modal-update-container').modal('hide');
                            let user_list =$('#user_list').val();
                            datatable.ajax.url(user_list).load();
                            new Noty({
                                text: response.message,
                                type: 'success',
                                theme: 'limitless',
                                layout: 'topRight',
                                timeout: 2500
                            }).show();
                        }
                    });
            }
        });

        // Saving wizard state
        $('.steps-state-saving').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Previous',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'Next <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Submit form <i class="icon-paperplane ml-2"></i>'
            },
            transitionEffect: 'fade',
            saveState: true,
            autoFocus: true,
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Specify custom starting step
        $('.steps-starting-step').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Previous',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'Next <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Submit form <i class="icon-paperplane ml-2"></i>'
            },
            transitionEffect: 'fade',
            startIndex: 2,
            autoFocus: true,
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });

        // Enable all steps and make them clickable
        $('.steps-enable-all').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'fade',
            enableAllSteps: true,
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Previous',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'Next <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Submit form <i class="icon-paperplane ml-2"></i>'
            },
            onFinished: function (event, currentIndex) {
                alert('Form submitted.');
            }
        });


        //
        // Wizard with validation
        //

        // Stop function if validation is missing
        if (!$().validate) {
            console.warn('Warning - validate.min.js is not loaded.');
            return;
        }

        // Show form
        var form = $('.steps-validation').show();


        // Initialize wizard
        $('.steps-validation').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            titleTemplate: '<span class="number">#index#</span> #title#',
            labels: {
                previous: $('html').attr('dir') == 'rtl' ? '<i class="icon-arrow-right8 mr-2"></i> Previous' : '<i class="icon-arrow-left8 mr-2"></i> Previous',
                next: $('html').attr('dir') == 'rtl' ? 'Next <i class="icon-arrow-left8 ml-2"></i>' : 'Next <i class="icon-arrow-right8 ml-2"></i>',
                finish: 'Submit form <i class="icon-paperplane ml-2"></i>'
            },
            transitionEffect: 'fade',
            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {

                    // To remove error styles
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }

                form.validate().settings.ignore = ':disabled,:hidden';
                return form.valid();
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ':disabled';
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert('Submitted!');
            }
        });


        // Initialize validation
        $('.steps-validation').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },

            // Different components require proper error label placement
            errorPlacement: function(error, element) {

                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo( element.closest('.form-check').parent() );
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo( element.parent() );
                }

                // Input group and custom controls
                else if (element.parent().is('.custom-file, .custom-control') || element.parents().hasClass('input-group')) {
                    error.appendTo( element.parent().parent() );
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentWizard();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormWizard.init();
});
