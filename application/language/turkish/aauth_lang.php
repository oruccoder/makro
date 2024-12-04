<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject'] = 'Hesap Doğrulama';
$lang['aauth_email_verification_code'] = 'Doğrulama Kodunuz: ';
$lang['aauth_email_verification_text'] = " Aşağıdaki bağlantıyı tıklayabilir veya kopyalayıp yapıştırabilirsiniz\n\n";

// Password reset
$lang['aauth_email_reset_subject'] = 'Şifreyi Sıfırlama';
$lang['aauth_email_reset_text'] = "Şifrenizi sıfırlamak için aşağıdaki bağlatıyı tıklayınız veya tarayıcınızın adres çubuğuna kopyalayıp yapıştırabilirsiniz\n\n";

// Password reset success
$lang['aauth_email_reset_success_subject'] = 'Şifre Sıfırlama Başarılı';
$lang['aauth_email_reset_success_new_password'] = 'Şifreniz başarıyla sıfırlandı, yeni şifreniz: ';


/* Error Messages */

// Account creation errors
$lang['aauth_error_email_exists'] = 'Email adresi sistemde kayıtlı, eğer şifrenizi unuttuysanız aşağıdaki linke tıklayabilirsiniz.';
$lang['aauth_error_username_exists'] = "Bu kullanıcı adı sistemde kayıtlı.Lütfen başka bir kullanıcı adı girin veya şifrenizi unuttuysanız aşağıdaki linke tıklayabilirsiniz.";
$lang['aauth_error_email_invalid'] = 'Geçersiz e-mail adresi';
$lang['aauth_error_password_invalid'] = 'Geçersiz Şifre';
$lang['aauth_error_username_invalid'] = 'Geçersiz Kullanıcı Adı';
$lang['aauth_error_username_required'] = 'Kullanıcı Adı Gerekli';
$lang['aauth_error_totp_code_required'] = 'Kimlik Doğrulama Kodu Gerekli';
$lang['aauth_error_totp_code_invalid'] = 'Geçersiz Doğrulama Kodu';


// Account update errors
$lang['aauth_error_update_email_exists'] = 'Email adresi sistemde kayıtlı, lütfen farklı bir email adresi girin.';
$lang['aauth_error_update_username_exists'] = "Kullanıcı adı sistemde kayıtlı, lütfen farklı bir kullanıcı adı girin.";


// Access errors
$lang['aauth_error_no_access'] = 'Üzgünüz istediğiniz kaynağa erişim izniniz yoktur.';
$lang['aauth_error_login_failed_email'] = 'Email adresi ve şifre eşleşmiyor.';
$lang['aauth_error_login_failed_name'] = 'Kullanıcı adı ve şifre eşleşmiyor.';
$lang['aauth_error_login_failed_all'] = 'Email, kullanıcı adı veya şifre eşleşmiyor.';
$lang['aauth_error_login_attempts_exceeded'] = 'Çok fazla hatalı giriş yaptınız, hesabınız bloke edildi.';
$lang['aauth_error_recaptcha_not_correct'] = 'reCAPTCHA metnini yanlış girdiniz.';

// Misc. errors
$lang['aauth_error_no_user'] = 'Bu isimde bir kullanıcı yok';
$lang['aauth_error_account_not_verified'] = 'Hesabınız doğrulanmadı.Lütfen e-mailinizi kontrol edin ve hesabınızı doğrulayın.';
$lang['aauth_error_no_group'] = 'Grup mevcut değil';
$lang['aauth_error_no_subgroup'] = 'Alt grup mevcut değil';
$lang['aauth_error_self_pm'] = 'Kendinize mesaj göndermek mümkün değildir.';
$lang['aauth_error_no_pm'] = 'Özel mesaj bulunamadı.';


/* Info messages */
$lang['aauth_info_already_member'] = 'Kullanıcı zaten bir grubun üyesi';
$lang['aauth_info_already_subgroup'] = 'Alt grup zaten bir grubun üyesi';
$lang['aauth_info_group_exists'] = 'Grup adı zaten mevcut';
$lang['aauth_info_perm_exists'] = 'İzin adı zaten mevcut';
