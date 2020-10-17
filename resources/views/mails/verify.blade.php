<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activation Token</title>
    <style type="text/css">
        body{
            background-color: #dcdcdc;
        }
        .wrapper{
            margin: auto;
            width: 400px;
            border: 1px solid #868686;
            background: white;
            padding: 10px;
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <p>
            Your activation code is <b>{{$activationToken}}</b>.
        </p>
        <p>
            Your activation code is only valid for two hours
        </p>
    </div>
</body>
</html>
