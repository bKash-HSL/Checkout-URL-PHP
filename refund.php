
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
        

                $post_token = json_encode($post_token);
                $header = array(
                    'Content-Type:application/json',
                    'Authorization:'. $_SESSION["token"],
                    'X-APP-Key:'. $credentials_arr['app_key']
                );
        
                $url = curl_init($credentials_arr['base_url']."/checkout/payment/refund");
                curl_setopt($url, CURLOPT_HTTPHEADER, $header);
                curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
                curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
                $result_data = curl_exec($url);
                curl_close($url);
        
                $response = json_decode($result_data, true);
				
				$message;
				if(isset($response["refundTrxID"])){
					$message = "Refund successful.Refund trx ID : ".$response["refundTrxID"];
				}else{
					$message = "Refund Failed !!";
				}
				
                return $message;
            }   
			
            $refund_msg  = refund();
        }

            ?>
			
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>bKash Refund</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }

        h1 {
            color: #333;
        }

        form {
            text-align: left;
            margin-top: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .response {
            margin-top: 20px;
            color: #e74c3c;
            font-weight: bold;
        }
        
        .response.success {
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>bKash Refund</h1>
        <form action="refund.php" method="POST">
            <label for="paymentID">Payment ID</label>
            <input type="text" id="paymentID" name="paymentID" required>
            
            <label for="trxID">Trx ID</label>
            <input type="text" id="trxID" name="trxID" required>
            
            <label for="amount">Amount</label>
            <input type="text" id="amount" name="amount" required>
            
            <input type="submit" value="Submit">
        </form>
    </div>

    <?php if(isset($refund_msg)): ?>
        <div class="container response">
            <p><?php echo $refund_msg; ?></p>
        </div>
    <?php endif; ?>
</body>
</html>
