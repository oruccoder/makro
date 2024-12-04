<?php

class Stockio extends CI_Controller
{
    const  LTR = 'ltr';
    public function __construct()
    {
        parent::__construct();

        $this->load->library("Aauth");
        $this->load->model('Stockio_model') ;
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Anbar Giris Cixis';
        $this->load->view('fixed/header', $head);
        $this->load->view('stockio/view');
        $this->load->view('fixed/footer');
    }
    public function get_warehouse_products(){
        $id = $this->input->post('id');
        if(stock_qty_warehouse_products($id)){
            echo json_encode(array('code'=>200,'result'=>stock_qty_warehouse_products($id)));
        }
        else
        {
            echo json_encode(array('code'=>410,'result'=>false));
        }
    }

    public function get_warehouse_products_(){
        $id = $this->input->post('warehouse');
        $option_details = $this->input->post('option_details');
        $product_id = $this->input->post('id');
        $unit_get=[];
        foreach (units() as $items){
            $unit_get[]=[
                'id'=>$items['id'],
                'name'=>$items['name']
            ];
        }

        if(stock_qty_warehouse_new($product_id,$id,$option_details)){
            echo json_encode(array('units'=>$unit_get,'code'=>200,'result'=>stock_qty_warehouse_new($product_id,$id,$option_details)));
        }
        else
        {
            echo json_encode(array('code'=>410,'result'=>false));
        }
    }

    public function get_stock_product(){
        $option_details = $this->input->post('option_details');
        $product_id = $this->input->post('id');

        if(stock_qty($product_id,$option_details)){
            echo json_encode(array('code'=>200,'result'=>stock_qty($product_id,$option_details)));
        }
        else
        {
            echo json_encode(array('code'=>410,'result'=>false));
        }
    }

    public function product_details(){

        $product_id = $this->input->post('id');
        $product_name = product_name($product_id);
        $data=[
            'product_id'=>$product_id,
            'product_name'=>$product_name
        ];

        if($data){
            echo json_encode(array('code'=>200,'result'=>$data));
        }


    }

    public function store_update(){
        $this->db->trans_start();
        $index=0;
        $stock_io_id = $this->input->post('id');
        $rusults = $this->input->post('collection');
        $data_items = array(
            'pers_id'      => $this->aauth->get_user()->id,
            'warehouse_id'     => $this->input->post('warehouse_id'),
            'type'     => $this->input->post('fis_type'),
        );
        $this->db->where('id', $stock_io_id);
        $this->db->update('stock_io', $data_items);

        $this->db->delete('stock_io_products', array('stock_io_id' => $stock_io_id));
        $this->db->delete('stock', array('mt_id' => $stock_io_id,'form_type'=>3));
        if($rusults){
            foreach($rusults as $result){
                // Depoya giriş / Çıkış
                stock_update_new($result['product_id'],$result['unit_id'],$result['qty'],$this->input->post('fis_type'),$this->input->post('warehouse_id'),$this->aauth->get_user()->id,$stock_io_id,3);
                $stock_id = $this->db->insert_id();
                // Depoya giriş / Çıkış

                $data_product = array(
                    'stock_io_id' => $stock_io_id,
                    'stock_id' => $stock_id,
                    'description'  => $result['desc'],
                    'product_id'  => $result['product_id'],
                    'unit_id'     => $result['unit_id'],
                    'qty'         => $result['qty'],
                    'product_stock_code_id'         => $result['product_stock_code_id'],
                    'option_id'         => option_sort($result['option_id']),
                    'option_value_id'         => option_sort($result['value_id']),
                );
                if($this->db->insert('stock_io_products', $data_product)){
                    stock_update_options_new($stock_id,$result['product_stock_code_id']);
                    $index++;
                }
            }
            if($index){
                echo json_encode(array('code'=>200,'message'=> "Prosses Uğurla tamalandı"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }



        }

    }
    public function store(){
        $this->db->trans_start();
        $index=0;
        $rusults = $this->input->post('collection');




        $code = numaric(9);
        $data_items = array(
            'pers_id'      => $this->aauth->get_user()->id,
            'code'         => $code ,
            'warehouse_id'     => $this->input->post('warehouse_id'),
            'type'     => $this->input->post('fis_type'),
            'loc'     => $this->session->userdata('set_firma_id')
        );
        $this->db->insert('stock_io', $data_items);
        $stock_io_id = $this->db->insert_id();


        if($rusults){

            foreach($rusults as $result){
                // Depoya giriş / Çıkış
                    stock_update_new($result['product_id'],$result['unit_id'],$result['qty'],$result['fis_type'],$this->input->post('warehouse_id'),$this->aauth->get_user()->id,$stock_io_id,3);
                    $stock_id = $this->db->insert_id();
                // Depoya giriş / Çıkış

                $data_product = array(
                    'stock_io_id' => $stock_io_id,
                    'stock_id' => $stock_id,
                    'description'  => $result['desc'],
                    'product_id'  => $result['product_id'],
                    'unit_id'     => $result['unit_id'],
                    'qty'         => $result['qty'],
                    'product_stock_code_id'         => $result['product_stock_code_id'],
                    'option_id'         => option_sort($result['option_id']),
                    'option_value_id'         => option_sort($result['value_id']),
                );
                if($this->db->insert('stock_io_products', $data_product)){
                    stock_update_options_new($stock_id,$result['product_stock_code_id']);
                    $index++;
                }
            }

            if($index){
                $operator= "deger+1";
                $this->db->set('deger', "$operator", FALSE);
                $this->db->where('tip', 9);
                $this->db->update('numaric');
                $this->aauth->applog("Stok Fişi Oluşturuldu : File Code : ".$code, $this->aauth->get_user()->username);
                echo json_encode(array('code'=>200,'message'=> "Prosses Uğurla tamalandı"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }



        }

    }
    public function create_list_store(){
        $this->db->trans_start();
        $index=0;
        $rusults = $this->input->post('collection');
        $warehouse_list = [];
        foreach ($rusults as $items){
            $warehouse_list[]=$items['warehouse_id'];
        }
        $uniq_ = array_unique($warehouse_list);
        if(count($uniq_) > 1){
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' =>"Farklı Depolardan Çıkışı Aynı Anda Oluşturamazsınız!"));
        }
        else {

            $code = numaric(9);
            $data_items = array(
                'pers_id'      => $this->aauth->get_user()->id,
                'code'         => $code ,
                'warehouse_id'     => $uniq_[0],
                'type'     => '0',
                'loc'     => $this->session->userdata('set_firma_id')
            );
            $this->db->insert('stock_io', $data_items);
            $stock_io_id = $this->db->insert_id();
            if($rusults){


                foreach($rusults as $result){
                    // Depoya giriş / Çıkış
                    stock_update_new($result['product_id'],$result['unit_id'],$result['qty'],$result['fis_type'],$result['warehouse_id'],$this->aauth->get_user()->id,$stock_io_id,3);
                    $stock_id = $this->db->insert_id();
                    // Depoya giriş / Çıkış

                    $data_product = array(
                        'stock_io_id' => $stock_io_id,
                        'stock_id' => $stock_id,
                        'description'  => $result['desc'],
                        'product_id'  => $result['product_id'],
                        'unit_id'     => $result['unit_id'],
                        'qty'         => $result['qty'],
                        'option_id'         => option_sort($result['option_id']),
                        'option_value_id'         => option_sort($result['value_id']),
                    );
                    if($this->db->insert('stock_io_products', $data_product)){
                        stock_update_options_new($stock_id,$result['option_id'],$result['value_id']);
                        cloud_stock_update($stock_io_id,$result['cloud_stock_id']);
                        $index++;
                    }
                }

                if($index){
                    $operator= "deger+1";
                    $this->db->set('deger', "$operator", FALSE);
                    $this->db->where('tip', 9);
                    $this->db->update('numaric');
                    $this->aauth->applog("Stok Fişi Oluşturuldu : File Code : ".$code, $this->aauth->get_user()->username);
                    echo json_encode(array('code'=>200,'message'=> "Prosses Uğurla tamalandı"));
                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('code' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }



            }
        }





    }
    public function ajax_list(){
        $items  =  $this->Stockio_model->get_all();
        $data = array();
        $no = 0;
       foreach ($items as $item ){
            $edit = "<button data-id='$item->stock_io_id_new' class='btn btn-danger cancel-stockio'><i class='fa fa-ban'></i></button>&nbsp
            <button data-id='$item->stock_io_id_new' class='btn btn-warning edit-stockio'><i class='fa fa-edit'></i></button>&nbsp
            <button data-id='$item->stock_io_id_new' class='btn btn-indigo file-stockio'><i class='fa fa-file'></i></button>&nbsp
            <a type='button' href='print/?print=$item->stock_io_id_new&whareouse=$item->warehouse_id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i></a>  ";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->fis_code;
           $row[] = $item->fis_type_name;
            $row[] = $item->warehouse;
            $row[] =$edit;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stockio_model->all_count(),
            "recordsFiltered" => $this->Stockio_model->all_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function get_product(){
        $id = $this->input->post('id');

        $item =  $this->Stockio_model->get_product($id)->row();
//        echo var_export($item);
//       exit;
        $row = array();
        $row['id'] = $item->stock_io_id ;
        $row['warehouse']   = $item->warehouse_id;
        $row['fis_type']    = $item->type;;
        $row['proje']       = $item->proje_id;;
        $row['product_id']  = $item->product_id;;
        $row['qty']         = $item->qty;
        $row['description'] = $item->description;


        $output = array(
            "data" => $row,
        );
        //output to json format
        echo json_encode($output);
    }
    public function update(){
        echo $id =  $this->input->post('id');
        $stock_io  = array(
            'pers_id'      => $this->aauth->get_user()->id,
            'warehouse_id' => $this->input->post('warehouse'),
            'type'         => $this->input->post('type'),
            'description'  => $this->input->post('description'),
        );

        $this->db->where('id', $id);
        $this->db->update('stock_io', $stock_io);

        $stock_io_product = array(
            'product_id'  =>  $this->input->post('product'),
            'unit_id'     =>  $this->input->post('description'),
            'qty'         =>  $this->input->post('qty'),
        );

        $this->db->where('stock_io_id', $id);
        $this->db->update('stock_io_products', $stock_io_product);

        echo json_encode(array('code'=>200,'message'=> "Prosses Uğurla tamalandı"));

    }

    public function info(){
        $id = $this->input->post('talep_id');
        $details =  $this->Stockio_model->details($id);
        $item =  $this->Stockio_model->get_product($id);
        echo json_encode(array(
            'code'=>200,
            'item'=> $item,
            'details'=> $details,
            ));


    }

    public function varyasyon_name(){
        $option_id = $this->input->post('option_id');
        $option_details = $this->input->post('option_details');
        $product_stock_code_id = $this->input->post('product_stock_code_id');
        $option_value_id = $this->input->post('option_value_id');
              echo json_encode(array(
                  'code'=>200,
                  'varyasyon'=> varyasyon_string_name_new($option_details[0]['stock_code_id'])
              ));
    }

    public function delete_file(){
        $this->db->trans_start();
        $stock_io_id = $this->input->post('stock_io_id');
        if($this->db->delete('stock_io', array('id' => $stock_io_id))){
            $this->db->delete('stock_io_products', array('stock_io_id' => $stock_io_id));
            $this->db->delete('stock', array('mt_id' => $stock_io_id,'form_type'=>3));
            $this->aauth->applog("Stok Fişi Silindi  : File ID : ".$stock_io_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla İptal Edildi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function getall_products(){
        echo json_encode(all_products_like($this->input->post('search'),$this->input->post('warehouse_id')));
    }

    public function getall_cost(){
        echo json_encode(all_cost_like($this->input->post('search')));
    }

    public function update_table(){
        $this->db->trans_start();
        $tip = $this->input->post('tip');
        $stock_io_id = $this->input->post('stock_io_id');
        $val = $this->input->post('val');

        $info = $this->db->query("SELECT * FROM stock_io_products Where stock_io_id=$stock_io_id")->row();
        $stock_id = $info->stock_id;
        $qty = $info->qty;

        $stock_io_product = array(
            'qty'         =>  $val,
        );
        $this->db->where('stock_io_id', $stock_io_id);
        $this->db->update('stock_io_products', $stock_io_product);



        $stock_io_product_update = array(
            'qty'         =>  $val,
        );
        $this->db->where('id', $stock_id);
        if(  $this->db->update('stock', $stock_io_product_update)){
            $this->aauth->applog("Stok Fişi Güncellendi  : Eski QTY : $qty Yeni QTY : $val | ".$stock_io_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function print(){

        $id = (int) $_GET['print'];

        $details =  $this->Stockio_model->details($id);
        $item =  $this->Stockio_model->get_product($id);

        $data['details'] = $details;
        $data['items'] = $item;

        ini_set('memory_limit', '64M');

        $html =    $this->load->view('stockio/view-print-'.LTR, $data, true);
        $header =  $this->load->view('stockio/header-print-'.LTR, $data,true);

        //PDF Rendering

        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

       $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . 12 . '</div>');

        $pdf->WriteHTML($html);

        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Malzeme__'.$details->code);


        if ($this->input->get('d')) {
            $pdf->Output($file_name. '.pdf', 'D');
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }

    }




}



