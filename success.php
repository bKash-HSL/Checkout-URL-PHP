<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
        }

        .container h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .container p {
            color: #777;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your payment has been successfully done.</h1>
        <p>Your Trx ID: <?php if(isset($_GET['trxID'])){
            echo $_GET['trxID'];
        }
        ?></p>
    </div>
</body>

</html>
