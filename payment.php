<?php

    include 'token.php';
    
    $credentials_json = file_get_contents('config.json'); 
    $credentials_arr = json_decode($credentials_json,true);
    
    function create()
    {       
        // getToken();
        global $credentials_arr;
        
        if(!$_POST['amount'] || $_POST['amount'] < 1){
           header("Location: payment.php");  
           exit;
        }
        
        $post_token = array(
            'mode' => '0011',
            'amount' => $_POST['amount'],
            'payerReference' => "1",
            'callbackURL' => "http://" . $_SERVER['SERVER_NAME']."/".basename(__DIR__)."/callback.php", // Your callback URL
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => 'Inv'.rand()
        );

        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            'Authorization:'. getToken(),
            'X-APP-Key:'. $credentials_arr['app_key']
        );

        
        $credentials_arr['sandbox'] ? $base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized' : $base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized';

        $url = curl_init($base_url."/checkout/create");
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, FALSE);
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
    <title>bKash Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .payment-form {
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
        }

        .payment-form label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .payment-form input {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .payment-form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="payment-form">
            <h2>bKash Payment</h2>
            <form action="payment.php" method="POST">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount"><br><br>
                <input type="hidden" name="form_submitted" value="1" />
                <input type="submit" value="Pay With bKash">
            </form>
        </div>
    </div>
</body>

</html>
