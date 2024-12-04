<?php


class UploadModel extends CI_Model {



    public function file_upload($name = '', $path, $type = null)
    {

        
        if (isset($type)) {

            if ($this->transactions->meta_delete($name)) {

                return true;
            }
        } else {

            $this->load->library("Uploadhandler_generic", array(

//                'accept_file_types' => '/\.(pdf|gif|jpe?g|jpg|png|xlsx)$/i', 'upload_dir' => FCPATH . $path, 'upload_url' => base_url() . $path
                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));
        }
    }




}