<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ok yeah</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <style>
        body{
            width: 100%;
            background-color: #f7f8f9;
            font-family: 'Roboto', sans-serif;
        }
        .center{
            text-align: center;
        }
        .center h1{
            text-transform: capitalize;
            font-size: 2rem;

        }
        .center .info-date{
            font-size: 7rem;
        }
    </style>
</head>
<body>
    <div class="center">
        <h1>oh yeah docker</h1>
        <div class="info-date">
            <?= (new \DateTime())->format('Y') ?>
        </div>
    </div>
</body>
</html>