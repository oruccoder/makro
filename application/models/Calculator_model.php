<?php
class Calculator_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function hitung($bilangan1,$bilangan2,$operator){
        switch ($operator) {
            case '+':
                return $bilangan1+$bilangan2;
                break;
            case '-':
                return $bilangan1-$bilangan2;
                break;
            case '*':
                return $bilangan1*$bilangan2;
                break;
            case '/':
                return $bilangan1/$bilangan2;
                break;
            default:
                return '';
                break;
        }
    }
}