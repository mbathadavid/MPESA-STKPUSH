<?php 
if (isset($_POST['pay'])) {
    $phone = $_POST['number'];
    $amount = $_POST['amount'];
    $phonenumber = "254".$phone;
    stkPush($amount,$phonenumber);
    }

    function lipanampesapassword(){
        date_default_timezone_set("Africa/Nairobi");
        $timestamp = date('YmdHis');
        $shortcode = "174379";
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $password = base64_encode($shortcode.$passkey.$timestamp);

        return $password;
    }

    function newAcccessToken(){
        $consumerkey = "Yg2b68yN2DBshXEZyo3E2TFeojrOiirn";
        $consumersecret = "tr862Kqbs67BdNBL";
        $credentials = base64_encode($consumerkey.":".$consumersecret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type: application/json"));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token = json_decode($curl_response);
        curl_close($curl);

        return $access_token->access_token;
    }

    function stkPush($amount,$phone) {
        $url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
        $curl_post_data = [
           "BusinessShortCode" => 174379,
            "Password" => lipanampesapassword(),
            "Timestamp" => date('YmdHis'),
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA" => $phone,
            "PartyB" => 174379,
            "PhoneNumber" => $phone,
            "CallBackURL" => "https://tender-starfish-24.loca.lt/MPESA/processmpesa.php",
            "AccountReference" => "Prime Markets",
            "TransactionDesc" => "Payment for my listing in electronics category"  
        ];

        $data_string = json_encode($curl_post_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization:Bearer '.newAcccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        print_r($curl_response);
    }
 

 ?>