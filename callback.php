<?php
  include 'execute.php';

  if (isset($_GET['status'])){
    if ($_GET['status'] == 'success'){
        $result_data = execute($_GET['paymentID']);
        $response = json_decode($result_data, true);
        
        if(isset($response['statusCode']) && $response['statusCode'] != '0000'){
            // Error case
            header("Location: fail.php?statusMessage=".$response['statusMessage']); 
            exit;
        }else{
            // db insert operation strore $response data
            
        header("Location: success.php?trxID=".$response['trxID']); 
        exit;
        }
    }else{
        header("Location: fail.php");  
        exit;
    }
}

?>
