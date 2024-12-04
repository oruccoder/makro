<?php
header ('Content-type: text/html; charset=utf-8');

// wsdl cache 'ini devre disi birak
ini_set("soap.wsdl_cache_enabled", "0");


// web servisi icin kullanacagimiz metodlari iceren sinifi dahil et
require_once '../lib/Products.class.php';

// Soap Server nesnesi olustur
$soapServer = new SoapServer("products.wsdl", array('encoding' => 'UTF-8'));


// Soap Server 'a Products sinifini kullanmasini soyle
$soapServer->setClass("Products");


// Soap Server 'i baslat ve gelen istekleri Products sinifina gonder
$soapServer->handle();
?>