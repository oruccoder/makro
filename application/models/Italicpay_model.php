<?php

class Italicpay_model extends CI_Model
{

    protected static $domain, $paymentDealerAuthentication, $ch;

    function __construct()
    {

        $paymentDealerAuthentication = $this->get();
    }
    public function get()
    {
        $pos = $this->db->query("SELECT * FROM `italic_pay`")->result();
        if($pos)
        {
            foreach ($pos as $value) {
                $DealerCode=$value->DealerCode;
                $Username=$value->Username;
                $Password=$value->Password;
            }
        }
        else
        {
            $DealerCode="";
            $Username="";
            $Password="";
        }


        $strParam = $DealerCode. "MK" . $Username . "PD" . $Password;
        $checkKey = hash("sha256", $strParam);

        $paymentDealerAuthentication = array(
            "DealerCode" => $DealerCode,
            "Username" => $Username,
            "Password" => $Password,
            "CheckKey" => $checkKey
        );
        return $paymentDealerAuthentication;
    }
    public function getJSON($serviceAddress, $paymentDealerRequest)
    {

        $domain = "https://service.moka.com/";
        $postData = array(
            "PaymentDealerAuthentication" => $this->get(),
            "PaymentDealerRequest" => $paymentDealerRequest,
        );

        $ch = curl_init($domain . $serviceAddress);
        curl_setopt_array($ch, array(
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($postData, JSON_UNESCAPED_UNICODE))
            ),
            CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE)
        ));

        $response = curl_exec($ch);

        if ($response == FALSE) {
            die(curl_error($ch));
        }
        return json_decode($response);
    }

    /*
     *
     *
     */
    public function DoDirectPayment($paymentDealerRequest)
    {
        return $this->getJSON("/PaymentDealer/DoDirectPayment", $paymentDealerRequest);
    }

    public function DoDirectPaymentThreeD($paymentDealerRequest)
    {
        return $this->getJSON("/PaymentDealer/DoDirectPaymentThreeD", $paymentDealerRequest);
    }

    public function GetPaymentList($paymentStartDate, $paymentEndDate, $paymentStatus, $trxStatus)
    {
        $paymentDealerRequest = array(
            "PaymentStartDate" => $paymentStartDate,
            "PaymentEndDate" => $paymentEndDate,
            "PaymentStatus" => $paymentStatus,
            "TrxStatus" => $trxStatus
        );
        return $this->getJSON("PaymentDealer/GetPaymentList", $paymentDealerRequest);
    }

    public function GetDealerPaymentTrxDetailList($dealerPaymentId,$otherTrxCode )
    {
        $paymentDealerRequest = array(
            "DealerPaymentId" => $dealerPaymentId,
            "OtherTrxCode" => $otherTrxCode
        );
        return $this->getJSON("PaymentDealer/GetDealerPaymentTrxDetailList", $paymentDealerRequest);
    }

    function searchForId($trxType, $trxStatus, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['TrxType'] === $trxType && $val['TrxStatus'] === $trxStatus) {
                return $key;
            }
        }
        return null;
    }

    public function GetPaymentDetailStatus($trxType, $trxStatus)
    {

        return 0;
    }

}


?>
