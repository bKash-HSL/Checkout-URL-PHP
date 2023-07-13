<?php

    include 'token.php';
    
    $credentials_json = file_get_contents('config.json'); 
    $credentials_arr = json_decode($credentials_json,true);
    
    function create()
    {       
        getToken();
        global $credentials_arr;
        
        if(!$_POST['amount'] || $_POST['amount'] < 1){
           header("Location: payment.php");  
           exit;
        }
        
        $post_token = array(
            'mode' => '0011',
            'amount' => $_POST['amount'] ? $_POST['amount'] : 1,
            'payerReference' => " ",
            'callbackURL' => "http://" . $_SERVER['SERVER_NAME']."/".basename(__DIR__)."/callback.php", // Your callback URL
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => 'Inv'.rand()
        );

        $url = curl_init($credentials_arr['base_url']."/checkout/create");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            'Authorization:'. $_SESSION["token"],
            'X-APP-Key:'. $credentials_arr['app_key']
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $result_data = curl_exec($url);
        curl_close($url);

        $response = json_decode($result_data, true);

        header("Location: ".$response['bkashURL']); 
        exit;
    }   
  

    if (isset($_POST['form_submitted'])){
        echo create(); 
    }
    
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bkash Payment</title>
</head>

<body>
    <div style="text-align: center;">
        <br><br>
        <form action="payment.php" method="POST">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount"><br><br>
            <input type="hidden" name="form_submitted" value="1" />
            <input type="submit" value="Pay With Bkash">
        </form>
    </div>
</body>

</html>
