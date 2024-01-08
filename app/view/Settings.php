<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>
       Settings - TRACE Early Alert
    </title>

    <link rel="stylesheet" href="<?= baseurl() ?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= baseurl() ?>/public/assets/main.style.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        var baseurl = '<?php echo baseurl(); ?>';
        var userType = '<?php echo Session::getUserType(); ?>';
    </script>
</head>

<body>

<div class="settings-container">
    <div class="wrapper">
       <div class="container-fluid">
        <div class="row">
            <div class="col">

            </div>
        </div>
       </div>
    </div>
</div>



<?php require_once __DIR__."/partials/Main.footer.php" ?>