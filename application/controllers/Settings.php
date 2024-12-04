<?php

/**
 * İtalic Soft Yazılım  ERP - CRM - HRM 
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ************************************************************************
 */



defined('BASEPATH') OR exit('No direct script access allowed');



class Settings extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->li_a = 'settings';



        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        if (!$this->aauth->premission(14)) {



            exit('<h3>Bu bölüme ulaşma yetkiniz bulunmamaktadır!</h3>');



        }



        $this->load->model('settings_model', 'settings');





    }

    public function switch_location()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'loc' => $id
        );
        $this->db->set($data);
        $this->db->where('id', $this->aauth->get_user()->id);
        $this->db->update('geopos_users');
        redirect(base_url('dashboard'));
    }



    public function company()

    {

        $this->load->model('purchase_model', 'purchase');
        $data['emp'] = $this->purchase->employees();



        if ($this->input->post()) {

            $name = $this->input->post('name',true);
            $name = $this->input->post('name',true);

            $phone = $this->input->post('phone',true);
            $personel_id = $this->input->post('personel_id',true);

            $email = $this->input->post('email',true);

            $address = $this->input->post('address',true);

            $city = $this->input->post('city',true);

            $region = $this->input->post('region',true);

            $country = $this->input->post('country',true);

            $postbox = $this->input->post('postbox',true);

            $taxid = $this->input->post('taxid',true);

            $this->settings->update_company(1, $name, $phone, $email, $address, $city, $region, $country, $postbox, $taxid,$personel_id);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Firma Ayarları';

            $data['company'] = $this->settings->company_details(1);



            $this->load->view('fixed/header', $head);

            $this->load->view('settings/company', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function currency()

    {

        $this->li_a = 'billing';

        if ($this->input->post()) {

            $currency = $this->input->post('currency',true);

            $thous_sep = $this->input->post('thous_sep');

            $deci_sep = $this->input->post('deci_sep');

            $decimal = $this->input->post('decimal');

            $spost = $this->input->post('spos');



            $this->settings->update_currency(1, $currency, $thous_sep, $deci_sep, $decimal, $spost);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Currency Settings';

            $data['currency'] = $this->settings->currency();



            $this->load->view('fixed/header', $head);

            $this->load->view('settings/currency', $data);

            $this->load->view('fixed/footer');

        }



    }





    public function billing()

    {

        $this->li_a = 'billing';

        if ($this->input->post()) {

            $invoiceprefix = $this->input->post('invoiceprefix',true);

            $taxid = $this->input->post('taxid',true);

            $taxstatus = $this->input->post('taxstatus',true);

            $lang = $this->input->post('language',true);

            $q_prefix = $this->input->post('q_prefix',true);

            $p_prefix = $this->input->post('p_prefix',true);

            $r_prefix = $this->input->post('r_prefix',true);

            $s_prefix = $this->input->post('s_prefix',true);

            $t_prefix = $this->input->post('t_prefix',true);

            $o_prefix = $this->input->post('o_prefix',true);

            $this->settings->update_billing(1, $invoiceprefix, $taxid, $taxstatus, $lang);

            $this->settings->update_prefix($q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix, $o_prefix);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Billing & TAX Settings';

            $data['company'] = $this->settings->company_details(1);

            $data['prefix'] = $this->settings->prefix();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/billing', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function dtformat()

    {



        if ($this->input->post()) {

            $tzone = $this->input->post('tzone');

            $dateformat = $this->input->post('dateformat');

            $this->settings->update_dtformat(1, $tzone, $dateformat);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Date Time Settings';

            $data['company'] = $this->settings->company_details(1);

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/timeformat', $data);

            $this->load->view('fixed/footer');

        }



    }





    public function companylogo()

    {

        $id = $this->input->get('id');

        $this->load->library("uploadhandler", array(

            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/'

        ));

        $img = (string)$this->uploadhandler->filenaam();

        if ($img != '') {

            $this->settings->companylogo($id, $img);

        }





    }



    //tax





    public function email()

    {



        if ($this->input->post()) {

            $host = $this->input->post('host');

            $port = $this->input->post('port');

            $auth = $this->input->post('auth');

            $auth_type = $this->input->post('auth_type');

            $username = $this->input->post('username');

            $password = $this->input->post('password');

            $sender = $this->input->post('sender');



            $this->load->library('ultimatemailer');



            $test = $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type, $username, $password, $sender, 'Geo POS Test', $sender, 'Geo POS Test', 'Geo POS SMTP Test', 'Hi, This is a Geo POS SMTP Test! Working Perfectly', false, '');



            if ($test) {

                $this->settings->update_smtp($host, $port, $auth, $auth_type, $username, $password, $sender);

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    '<br>Your SMTP settings are invalid. If you think it is a correct configuration, please try with different ports like 465, 587.<br> Still not working please contact to your hosting provider. <br> Free SMTP services are generally blocked by many hosting providers.<br>Please do not send support request to Geo POSSupport Team, we can not help in this matter because in the application email system is working perfectly.'));

            }



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'SMTP Config';

            $data['email'] = $this->settings->email_smtp();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/email', $data);

            $this->load->view('fixed/footer');

        }



    }





    public function billing_terms()

    {

        $this->li_a = 'billing';

        $data['terms'] = $this->settings->billingterms();

        $head['title'] = "Billing Terms";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('settings/terms', $data);

        $this->load->view('fixed/footer');

    }



    public function about()

    {



        $head['title'] = "About";



        $this->load->view('fixed/header', $head);

        $this->load->view('settings/about');

        $this->load->view('fixed/footer');

    }



    public function add_term()

    {

        $this->li_a = 'billing';

        if ($this->input->post()) {

            $title = $this->input->post('title',true);

            $type = $this->input->post('type');

            $term = $this->input->post('terms');



            $this->settings->add_term($title, $type, $term);



        } else {

            $head['title'] = "Add Billing Term";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/add_terms');

            $this->load->view('fixed/footer');

        }

    }





    public function edit_term()

    {

        $this->li_a = 'billing';

        if ($this->input->post()) {

            $id = $this->input->post('id');

            $title = $this->input->post('title',true);

            $type = $this->input->post('type');

            $term = $this->input->post('terms');





            $this->settings->edit_term($id, $title, $type, $term);



        } else {

            $id = $this->input->get('id');



            $data['term'] = $this->settings->get_terms($id);

            $head['title'] = "Edit Billing Term";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/edit_terms', $data);

            $this->load->view('fixed/footer');

        }

    }



    public function delete_terms()

    {



        if ($this->input->post()) {

            $id = $this->input->post('deleteid');





            if ($this->settings->delete_terms($id)) {



                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }



        }

    }



    public function activate()

    {



        if ($this->input->post()) {

            $email = $this->input->post('email',true);

            $code = $this->input->post('code',true);

            $this->settings->update_atformat($email, $code);

        } else {



            $head['title'] = "Geo POSBiiling Software Activation";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/active');

            $this->load->view('fixed/footer');





        }

    }



    public function theme()

    {



        if ($this->input->post()) {

            $tdirection = $this->input->post('tdirection',true);





            $this->settings->theme($tdirection);





        } else {



            $head['title'] = "Theme Settings";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/theme');

            $this->load->view('fixed/footer');





        }

    }



    public function themelogo()

    {



        $this->load->library("uploadhandler", array(

            'accept_file_types' => '/\.(png)$/i', 'upload_dir' => FCPATH . 'userfiles/theme/', 'name' => 'logo-header.png'

        ));





    }



    public function tickets()

    {

        $this->load->model('plugins_model', 'plugins');

        if ($this->input->post()) {

            $service = $this->input->post('service',true);

            $email = $this->input->post('email',true);

            $support = $this->input->post('support',true);

            $sign = $this->input->post('signature');



            $this->plugins->update_api(3, $service, $email, 1, $support, $sign);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Support Ticket Settings';

            $data['support'] = $this->plugins->universal_api(3);

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/ticket', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function tax()

    {

        $this->li_a = 'tax';

        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxsettings($this->config->item('tax'));

        if ($this->input->post()) {



            $taxid = $this->input->post('taxid');

            $taxstatus = $this->input->post('taxstatus');

            $gst_type = $this->input->post('gst_type');



            $this->settings->update_tax(1, $taxid, $taxstatus, $gst_type);



        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Tax Settings';

            $data['company'] = $this->settings->company_details(1);

            $data['prefix'] = $this->settings->prefix();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/tax', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function prefix()

    {

        $this->li_a = 'billing';

        if ($this->input->post()) {

            $invoiceprefix = $this->input->post('invoiceprefix');



            $q_prefix = $this->input->post('q_prefix',true);

            $p_prefix = $this->input->post('p_prefix',true);

            $r_prefix = $this->input->post('r_prefix',true);

            $s_prefix = $this->input->post('s_prefix',true);

            $t_prefix = $this->input->post('t_prefix',true);

            $o_prefix = $this->input->post('o_prefix',true);



            $this->settings->update_prefix($invoiceprefix, $q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix, $o_prefix);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Prefix Settings';

            $data['company'] = $this->settings->company_details(1);

            $data['prefix'] = $this->settings->prefix();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/prefix', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function language()

    {

        $this->load->library("Common");

        if ($this->input->post()) {



            $lang = $this->input->post('language',true);



            $this->settings->update_language(1, $lang);





        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Billing & TAX Settings';

            $data['company'] = $this->settings->company_details(1);

            $data['prefix'] = $this->settings->prefix();

            $data['langs'] = $this->common->languages();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/billing', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function automail()

    {



        if ($this->input->post()) {

            $email = $this->input->post('email');

            $sms = $this->input->post('sms');

            $this->settings->update_automail($email, $sms);



        } else {



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Auto Email SMS Settings';

            $data['auto'] = $this->settings->automail();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/automail', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function taxslabs()

    {

        $this->li_a = 'tax';

        $data['catlist'] = $this->settings->slabs();

        $head['title'] = "TAX Slabs";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('settings/slabs', $data);

        $this->load->view('fixed/footer');

    }



    public function taxslabs_new()

    {

        $this->li_a = 'tax';

        if ($this->input->post()) {

            $tname = $this->input->post('tname',true);

            $trate = $this->input->post('trate');

            $ttype = $this->input->post('ttype');

            $ttype2 = $this->input->post('ttype2');

            $this->settings->add_slab($tname, $trate, $ttype, $ttype2);



        } else {



            $data['catlist'] = $this->settings->slabs();

            $head['title'] = "TAX Slabs";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/tax_create', $data);

            $this->load->view('fixed/footer');

        }

    }



    public function taxslabs_delete()

    {



        if ($this->input->post()) {

            $id = $this->input->post('deleteid');





            if ($this->settings->delete_slab($id)) {



                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }



        }



    }



    public function logdata()

    {

        $this->li_a = 'settings';

        $data['acts'] = $this->settings->logs();

        $head['title'] = "App Log";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('settings/logs', $data);

        $this->load->view('fixed/footer');

    }





    public function warehouse()

    {

        $this->load->model('plugins_model', 'plugins');

        if ($this->input->post()) {

            $wid = $this->input->post('wid');



            $this->plugins->update_api(60, $wid, '', 1, '', '');



        } else {



            $this->db->select('*');

            $this->db->from('geopos_warehouse');



            if ($this->aauth->get_user()->loc) {

                $this->db->where('loc', 0);

                $this->db->or_where('loc', $this->aauth->get_user()->loc);

            }





            $query = $this->db->get();

            $data['warehouses'] = $query->result_array();



            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Default WareHouse';

            $data['ware'] = $this->plugins->universal_api(60);

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/warehouse', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function discship()

    {

        $this->load->model('plugins_model', 'plugins');

        $this->li_a = 'billing';

        $this->load->library("Common");

        $data['discship'] = $this->plugins->universal_api(61);

        if ($this->input->post()) {

            $discstatus = $this->input->post('discstatus');

            $shiptax_type = $this->input->post('shiptax_type');

            $shiptax_rate = $this->input->post('shiptax_rate');

            switch ($discstatus) {





                case 'flat' :

                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('After TAX');

                    break;

                case 'b_p' :

                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('Before TAX');

                    break;

                case 'bflat' :

                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('Before TAX');

                    break;

                default :

                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('After TAX');

                    break;

            }

            $this->plugins->update_api(61, $discstatus, $shiptax_rate, 0, $shiptax_type, $discstatus_name);





        } else {

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = 'Discount & Shipping Settings';

            $data['prefix'] = $this->settings->prefix();

            $this->load->view('fixed/header', $head);

            $this->load->view('settings/discship', $data);

            $this->load->view('fixed/footer');

        }



    }





}