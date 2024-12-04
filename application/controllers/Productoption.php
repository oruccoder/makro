<?php


class Productoption extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('ProductOptionModel', 'productOption');
        $this->load->model('ProductOptionValueModel', 'productOptionValue');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }




    public function index()
    {
        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Urun Opsiyon";

        $this->load->view('fixed/header', $head);

        $this->load->view('urun/product_option');

        $this->load->view('fixed/footer');
    }




    public function ajax_list()
    {

        $list = $this->productOption->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');

        // print_r($list);die;
        foreach ($list as $prd) {

            $edit = "<button class='btn btn-warning edit' product_option_id='$prd->id' title='Düzenle'><i class='fa fa-pen'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger delete' product_option_id='$prd->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $prd->description;
            $row[] = $edit . $cancel;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->productOption->count_all(),
            "recordsFiltered" => $this->productOption->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }




    public function create()
    {
        $this->db->trans_start();
        $result = $this->productOption->create_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['messages']));
        }
    }



    public function info()
    {
        $id = $this->input->post('id');

        $details_items = $this->productOption->details_item($id);
        $details_value = $this->productOptionValue->details_item($id);
        $list_options = $this->productOption->list_options();

        echo json_encode(array('status' => 'Success',
            'details_items' => $details_items,
            'details_value'=>$details_value,
            'list_options'=>$list_options,
        ));
    }


    public function update()
    {
        $this->db->trans_start();
        $result = $this->productOption->update();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['messages']));
        }
    }


    public function delete()
    {
        $result = $this->productOption->delete();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }

    public function delete_value()
    {
        $result = $this->productOption->delete_value();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }


    public function getValue()
    {
        $id = $this->input->post('id');

        $product_options = $this->productOption->getValue($id);

        echo json_encode(['product_options' => $product_options]);
    }

    public function info_options(){
        $product_id = $this->input->post('product_id');
        $details  = $this->productOption->get_details();
        $product_options = $this->productOption->get_product_option($product_id);
        echo json_encode(array('code' => 200,'details'=>$details,'product_options'=>$product_options));
    }


    public function info_options_new(){
        $product_id = $this->input->post('product_id');


        $html='';
        $details = $this->db->query("Select po.id,po.name From product_to_options as pto INNER JOIN product_options as po ON pto.option_id=po.id WHERE pto.product_id=$product_id ORDER BY pto.sort");
        $option_id=[];
        $options_values=[];
        if($details->num_rows()){
            foreach ($details->result() as $options){
                $option_id[]=['option_id'=>$options->id,'option_name'=>$options->name];
            }

            foreach ($option_id as $items){
                $op_id=$items['option_id'];
                $op_name=$items['option_name'];
                $values = $this->db->query("SELECT * FROM product_option_value WHERE product_option_value.product_option_id=$op_id")->result_array();
                $options_values[]=['option_id'=>$op_id,'option_name'=>$op_name,'items'=>$values];
            }

            $html='<div class="row" >';

            foreach ($options_values as $key=>$items){
                $option_name = $items['option_name'];
                $option_id = $items['option_id'];
                $col = (count($items) == 3) ? 4:3;
                $visable='visibility: visible;';


                $html .= '<div class="col-md-'.$col.' div_vs" key='.$key.'  style="max-height: 300px;overflow: auto;'.$visable.'">';
                $html .= '<div style="position: initial;" class="font-weight-semibold mb-2">'.$option_name.' <span class="text-danger">*</span></div>';
                $html .='<input type="text" class="form-control option_search_keyword" data-tablec="'.$items['option_id'].'" placeholder="Kelime Yazınız.."><table class="'.$items['option_id'].'"><thead><tr><th></th></tr></thead><tbody>';

                foreach ($items['items'] as $j=>$values){
                    $html.='<tr><td>';
                    $border = (($j+1) == count($values)) ? '' : 'border-bottom';
                    $html.= '<div  class="custom-control custom-radio custom-control mb-2 pb-2 '.$border.'">';
                    $html.= '<input  type="radio" class="custom-control-input option-value" data-value-id="'.$values['id'].'" data-option-id="'.$option_id.'"  data-option-name="'.$option_name.'" data-option-value-name="'.$values['name'].'"   name="option_id_'.$option_id.'" id="option_value_id_'.$values['id'].'">';
                    $html.= '<label   class="custom-control-label" for="option_value_id_'.$values['id'].'">'.$values['name'].'</label>';
                    $html.= '&nbsp;<span style="font-size: 10px;" class="text-muted">&nbsp;'.$values['description'].'</span></div>';
                    $html.='</tr></td>';

                }
                $html.='</tbody></table>';
                $html.= '</div>';

            }

            $html.= '</div>';
        }
        else {
            return ['status'=>false,'html'=>''];
        }

        echo json_encode(array('code' => 200,'details'=>$html));




    }


    public function info_options_value(){
        $option_id= $this->input->post('option_id');
        $details  = $this->productOptionValue->details_item($option_id);
        echo json_encode(array('code' => 200,'details'=>$details));
    }



    public function option_value(){
        $details  = $this->productOption->get_details();
        echo json_encode(array('code' => 200,'details'=>$details));
    }

    public function parent_value_get(){
        $value_id= $this->input->post('value_id');
        $details  = $this->productOption->parent_value_get($value_id);
        echo json_encode(array('code' => 200,'details'=>$details));
    }




}
