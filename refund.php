
        <?php
        include 'token.php'; 
        $credentials_json = file_get_contents('config.json'); 
        $credentials_arr = json_decode($credentials_json,true);

        if ((isset($_POST['paymentID'])) && (isset($_POST['trxID'])) && (isset($_POST['amount']))){
         
            function refund()
            {        
                getToken();
                global $credentials_arr;
                $post_token = array(
                    'paymentID' => $_POST['paymentID'],
                    'amount' => $_POST['amount'],
                    'trxID' => $_POST['trxID'],
                    'sku' => 'sku',
                    'reason' => 'Quality issue'
                );
        
                $url = curl_init($credentials_arr['base_url']."/checkout/payment/refund");
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
    
                return $result_data;
            }   
            echo refund();
        }

            ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bkash Refund Page</title>
</head>
<body>
<div style="text-align: center;">
        <br><br>
        <form action="refund.php" method="POST">
            <label for="paymentID">Payment ID:</label>
            <input type="text" id="paymentID" name="paymentID"><br><br>
            <label for="trxID">Trx ID:</label>
            <input type="text" id="trxID" name="trxID"><br><br>
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount"><br><br>
            <input type="submit" value="Click For Refund">
          </form>
    </div>
</body>
</html>