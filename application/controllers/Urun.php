<?php


class Urun extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('UrunModel', 'product');
        $this->load->model('projestoklari_model', 'stok');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }





    public function index()
    {
//        if (!$this->aauth->premission(2)->read) {
//
//            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
////        }

        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Urun";

        $this->load->view('fixed/header', $head);

        $this->load->view('urun/index');

        $this->load->view('fixed/footer');
    }
    public function alt_urun()
    {

        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Urun";

        $this->load->view('fixed/header', $head);

        $this->load->view('urun/alt_urun');

        $this->load->view('fixed/footer');
    }



    public function urun_qty($id) //BORU QURASTIRILMASI
    {
        echo "<pre>";print_r(stock_qty_new_sorgu($id,null,239));
    }



    public function proje_mt_report()
    {
        $list = $this->product->proje_mt_report();
        $data = [];
        $no = $this->input->post('start');
        foreach ($list as $prd) {


            $talep_form_products_id=$prd->talep_form_products_id;
            $codes='';

            $proje=$prd->pcde;

            $product_stock_id=$prd->product_stock_code_id;

            $warehouse_det=[];

            $sock_where_2='';
            $id=$prd->pid;

            $query_giren = $this->db->query("SELECT stock.qty,stock.warehouse_id,stock.unit,stock.warehouse_id FROM
              stock WHERE  $sock_where_2 stock.product_id=$id and stock.types=1 and stock.form_type=1 and  stock.mt_id=$prd->id");

            if($product_stock_id){

                $code_details = $this->db->query("SELECT * FROM product_stock_code Where id=$prd->product_stock_code_id");
                if($code_details->num_rows()){
                    $codes=$code_details->row()->code;
                }

                $sock_where_2="stock_to_options.product_stock_code_id=$product_stock_id and";
                $query_giren = $this->db->query("SELECT stock.qty,stock.warehouse_id,stock.unit,stock.warehouse_id FROM
              stock INNER JOIN stock_to_options ON stock.id =stock_to_options.stock_id WHERE  $sock_where_2 stock.product_id=$id and stock.types=1 and stock.form_type=1 and  stock.mt_id=$prd->id");
            }




            if($query_giren->num_rows()) {
                foreach ($query_giren->result() as $query_giren_item) {
                    $warehouse_de = $this->db->query("SELECT * FROM geopos_warehouse where id=$query_giren_item->warehouse_id");
                    $warehouse_name='';
                    if ($warehouse_de->num_rows()) {
                        $warehouse_name = $warehouse_de->row()->title;
                    }
                    $warehouse_det[] =
                        [
                            'warehouse_name' =>$warehouse_name,
                            'warehouse_id' =>$query_giren_item->warehouse_id,
                            'qty' =>$query_giren_item->qty,
                            'unit' =>units_($query_giren_item->unit)['name'],
                        ];
                }
            }


            $html='<span class="badge badge-danger">Tehvil Alınmamış</span>';
            $total=0;
            if($warehouse_det){
                $html='<table class="table-bordered table" style="    border-top: 1px solid #dddddd;"><thead><tr>
                    <td>Depo Adı</td>
                    <td>Sorumlu Personel</td>
                    <td>Miktar</td>
                    </tr></thead><tbody>';
                foreach ($warehouse_det as  $w_items){
                    $name=$w_items["warehouse_name"];
                    $qty=$w_items["qty"];
                    $unit=$w_items["unit"];
                    $total+=$qty;


                    $pers_name='';
                    if(warehouse_details($w_items['warehouse_id'])){
                        $pers_id = warehouse_details($w_items['warehouse_id'])->pers_id;
                        $pers_name = personel_detailsa($pers_id)['name'];
                    }

                    $html.='<tr>
                            <td>'.$name.'</td>
                            <td>'.$pers_name.'</td>
                            <td>'.amountFormat_s($qty).' '.$unit.'</td>
                            </tr>';
                }
                $html.='<tbody></tbody></table>';
            }


            $siparis_qty = floatval($prd->product_qty);
            $siparis_unit = $prd->unit_id;

            $tprd_qty=$this->db->query("SELECT * FROM siparis_list_form_new Where talep_form_product_id=$talep_form_products_id");
            if($tprd_qty->num_rows()){
                $siparis_qty=$tprd_qty->row()->new_item_qty;
                $siparis_unit=$tprd_qty->row()->new_unit_id;
            }

            $qaliq=$siparis_qty-floatval($total);
            $qaliq_text = amountFormat_s($qaliq).' '.units_($siparis_unit)['name'];
            if($qaliq>0){
                $qaliq_text="<span class='badge badge-warning'>".amountFormat_s($qaliq).' '.units_($siparis_unit)['name']."</span>";
            }




            $no++;
            $row = [];
            $row[] = $no;
            $row[] = '<a href="/malzemetalep/view/'.$prd->id.'" class="btn btn-success btn-sm" target="_blank">'.$prd->code.'</a>';
            $row[] = $proje.' - '.$talep_form_products_id;
            $row[] = $prd->product_name;
            $row[] = $codes;
            $row[] = amountFormat_s($siparis_qty).' '.units_($siparis_unit)['name'];
            $row[] = $html;
            $row[] = $qaliq_text;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product->count_all_mt_report(),
            "recordsFiltered" => $this->product->count_filtered_mt_report(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_list()
    {

        $list = $this->product->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');
        $url = base_url().'/userfiles/product/';

        foreach ($list as $prd) {

            $style='';
            $product_onay_kontrol=product_onay_kontrol($prd->pid);
            if(!$product_onay_kontrol){
                $style = "background-color: #ff7900;color: white;";
            }

            $edit = "<button class='btn btn-warning edit' product_id='$prd->pid' title='Düzenle'><i class='fa fa-pen'></i></button>&nbsp;";
            $stok = "<button class='btn btn-info eye' product_id='$prd->pid' title='Stok'><i class='fa fa-warehouse'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger delete' product_id='$prd->pid' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";

            $group_button = '';
            $group_button_new = '';
            $group_button_view = '';
            $group_button_view_new = '';
            if ($prd->product_type == 6) // Gruplu Ürün
            {
                $group_button = "<button  class='btn btn-info group_button' product_id='$prd->pid' ><i class='fa fa-filter'></i></button>&nbsp;";
                $group_button_new = "<button class='btn btn-success group_button_new' stok_kode='$prd->product_code' product_id='$prd->pid' title='Gruplu Ürün'><i class='fa fa-filter'></i></button>&nbsp;";
                $group_button_view_new = "<button class='btn btn-secondary group_button_view' product_id='$prd->pid' title='Gruplu Ürün'><i class='fa fa-eye-slash'></i></button>&nbsp;";
                $group_button_view = "<a class='btn btn-success group_button_views' title='Gruplu Ürün' target='_blank' href='/urun/alt_urun?parent_id=$prd->pid'><i class='fa fa-eye'></i></a>&nbsp;";
            }

            $check='';
            if(!$prd->onay_durumu){
                $check='<button class="btn btn-info product_onay" product_id="'.$prd->pid.'" ><i class="fa fa-check"></i></button>';

            }

            //$unit_button = "<button class='btn btn-info unit_button' product_id='$prd->pid' title='Birimler'><i class='fa fa-bars'></i></button>&nbsp;";


            $tags_button = "<button class='btn btn-yellow tags_button' types='geopos_products'  product_id='$prd->pid' tag_value='$prd->tag' title='Ürün Etiketleri'><i class='fa fa-tags'></i></button>&nbsp;";

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = "<img src='$prd->image' alt='' style='max-width:100%' height='auto' class='img-fluid'>";
            $row[] = $prd->product_name;
            $row[] = $prd->product_name_tr;
            $row[] = $prd->product_name_en;
            $row[] = $prd->category_name;
            $row[] = $prd->product_type_name;
            $row[] = $prd->product_code;
            $row[] = $prd->barcode.' | '.$prd->pid;
            $row[] = personel_details($prd->auth_id);
            $row[] = $edit.$stok. $cancel . $group_button.$group_button_new.$group_button_view.$group_button_view_new.$tags_button.$check;
            $row[] = $style;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product->count_all(),
            "recordsFiltered" => $this->product->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_alt()
    {

        $list = $this->product->alt_urun();

        $data = [];
        $no = $this->input->post('start');
        $url = base_url().'/userfiles/product/';

        foreach ($list as $prd) {





            $vowels = array("/userfiles","userfiles");
            $onlyconsonants = str_replace($vowels, "", $prd->image);

//
//            $html='
//
//
//                    <img alt="profile picture" id="dpic'.$prd->id.'" class="img-responsive col" style="width: 150px;"
//                         src="/userfiles'.$onlyconsonants.'">
//                    <input  class="fileuploadnew__" type="file" product_id="'.$prd->id.'"
//                            name="files[]"></p>';



            $stok_code_id=$prd->product_stock_code_id;
            $sql = $this->db->query("SELECT product_options.name as varyant_name,product_option_value.name as deger FROm product_to_options_value
      INNER JOIN product_option_value ON product_to_options_value.option_value_id = product_option_value.id
INNER JOIN product_options ON product_options.id = product_option_value.product_option_id
         Where product_to_options_value.product_stock_code=$stok_code_id")->result();
            $varyant_html='<table class="table-bordered table" style="    border-top: 1px solid #dddddd;">';
            foreach ($sql as $items){
                $varyant_html.=
                    '<tr><th style="color: brown;">'.$items->varyant_name.'</th>
<th style="
    color: #6f6f6f;
">'.$items->deger.'</th>
                    </tr>';
            }
            $varyant_html.='</table>';
            $button='<button style="margin-top:5px; " type="button" class="btn-sm btn btn-info stock_view" product_id="'.$prd->product_id.'" product_stock_id="'.$prd->product_stock_code_id.'"><i class="fa fa-eye"></i></button>';
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = "<img src='/userfiles$onlyconsonants' alt='' style='max-width:100%' height='auto' class='img-fluid parent_image_replace' product_stock_code_id='$prd->product_stock_code_id'>";
            $row[] = $prd->p_code;
            $row[] = $prd->product_name;
            $row[] = $prd->product_name_tr;
            $row[] = $prd->product_name_en;
            $row[] = $prd->category_name;
            $row[] = $prd->product_type_name;
            $row[] = $varyant_html;
            $row[] = $prd->barcode.' | '.$prd->product_stock_code_id;
            $row[] = $button;;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product->count_all_alt_urun(),
            "recordsFiltered" => $this->product->count_filtered_alt_urun(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function file_handling()
    {
        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            if ($this->transactions->meta_delete($name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx|jfif)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));


        }
    }


    public function create()
    {
//        if (!$this->aauth->premission(2)->write) {
//            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
//        }
//        else {
//
//        }

        $this->db->trans_start();
        $result = $this->product->create_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => "Başarılı"));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => "Hata Aldınız.Lütfen Yöneticiye Başvurun."));
        }

    }



    public function info()
    {
        $product_id = $this->input->post('product_id');
        $details_items = $this->product->details_item($product_id);
        echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
    }

    public function parent_info()
    {
        $product_stock_code_id = $this->input->post('product_stock_code_id');
        $code = $this->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id")->row()->code;
        $details_items = $this->product->details_item_parent($product_stock_code_id);

        $sql = $this->db->query("SELECT product_options.name as varyant_name,product_option_value.name as deger FROm product_to_options_value
      INNER JOIN product_option_value ON product_to_options_value.option_value_id = product_option_value.id
INNER JOIN product_options ON product_options.id = product_option_value.product_option_id
         Where product_to_options_value.product_stock_code=$product_stock_code_id")->result();
        $varyant_html='<table class="table-bordered table">';
        foreach ($sql as $items){
            $varyant_html.=
                '<tr><th>'.$items->varyant_name.'</th>
<th>'.$items->deger.'</th>
                    </tr>';
        }
        $varyant_html.='</table>';


        echo json_encode(array('code'=>$code,'status' => 'Success', 'details_items' => $details_items,'varyant_degerleri'=>$varyant_html));
    }




    public function update()
    {
//        if (!$this->aauth->premission(2)->update) {
//            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
//        }
        $product_id= $this->input->post('product_id');
        $kontrol = $this->db->query("SELECT * FROM geopos_products Where pid=$product_id")->row();
//        if($kontrol->onay_durumu==1){
//            if ($this->aauth->get_user()->id==741) {
//                $this->db->trans_start();
//                $result = $this->product->update();
//                if ($result['status']) {
//                    echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
//                    $this->db->trans_complete();
//                } else {
//                    $this->db->trans_rollback();
//                    echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
//                }
//
//            }
//            else {
//                echo json_encode(array('status' => 410, 'message' =>'Onaylanmış Üründür.Yetkiniz Bulunmamaktadır'));
//            }
//        }
//        else {
//
//        }


        $this->db->trans_start();
        $result = $this->product->update();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
        }


    }

    public function update_parent()
    {
        $this->db->trans_start();
        $result = $this->product->update_parent();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
        }

    }

    public function parent_image_update()
    {
        $this->db->trans_start();
        $result = $this->product->parent_image_update();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
        }

    }


    public function delete()
    {

        if ($this->aauth->get_user()->id!=741) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->product->delete();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }

    }

    public function onay()
    {

        $this->db->trans_start();
        $result = $this->product->onay();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }

    }

    public function update_tag()
    {

        $this->db->trans_start();
        $result = $this->product->update_tag();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => 'Başarıyla Güncellendi'));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => 'Hata Aldınız'));
        }

    }
    public function varyant_delete()
    {
//       if ($this->aauth->get_user()->id!=741) {
        if ($this->aauth->get_user()->id!=1147) {
            echo json_encode(array('code' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->product->varyant_delete();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }

    }

    public function delete_product_to_option()
    {
        if ($this->aauth->get_user()->id!=741) {
//        if ($this->aauth->get_user()->id!=21) {
            echo json_encode(array('code' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->product->delete_product_to_option();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }

    }

    public function get_value_is(){
        $stock_id=$this->input->post('stock_id');
        // $html = product_to_option_html($product_id);
        $html = get_value_is($stock_id);
        if($html['status']){
            echo json_encode(array('code' => 200, 'html' =>$html['html'] ));
        }
        else {
            echo json_encode(array('code' => 410, 'html' =>'<h3>Herhangi Bir Varyasyon Bulunamadı</h3>' ));
        }
    }

    public function product_to_option_create()
    {
        $this->db->trans_start();
        $result = $this->product->product_to_option_create();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }

    public function product_to_option_create_new()
    {
        $this->db->trans_start();
        $result = $this->product->product_to_option_create_new();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }
    public function projestoklari_post()
    {
        $this->db->trans_start();
        $result = $this->stok->post_create();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['message']));
        }
    }

    public function new_code_create()
    {
        $this->db->trans_start();
        $result = $this->product->new_code_create();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages'],'new_code'=>$result['new_code']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }
}
