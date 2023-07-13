<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
          div{
            text-align: center;
             }
    </style>
</head>

<body>
    <div>
        <h1 >Thank you !! your payment has been successfully done.</h1>
        <p>Your Trx ID: <?php if(isset($_GET['trxID'])){
            echo $_GET['trxID'];
        }
        ?>
        </p>
    </div>

</body>

</html>