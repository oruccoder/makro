<?php



class Soap extends CI_Controller

{

    public function __construct()

    {
    	$this->load->library("Nusoap_lib", "");
        parent::__construct();

    }

    


}

?>