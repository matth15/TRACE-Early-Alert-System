<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page not found</title>
    <link rel="stylesheet" href="<?= baseurl()?>/public/assets/style.css">
    <link rel="stylesheet" href="<?= baseurl() ?>/public/assets/css/bootstrap.min.css">
</head>

<body>
    <section class="pnf-section min-vh-100 bg-secondary ">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <img class=" w-100" src="<?php baseurl()?>/public/assets/images/scienerc-404-error-.webp" alt="" srcset="">
                        <h1 class="p-0 text-light">404</h1>
                    </div>
                    <div class="col col-12">
                        <h5>Sorry, the page you've requested not found.</h5>
                    </div>
                    <div class="col col-12 py-3">
                        <button type="button" onclick="redirectToHomepage()" class="btn btn-danger btn-sm shadow">Back to homepage</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
  function redirectToHomepage() {
    //back to homepage 
    window.location.href = "/home";
  }
</script>
    <script src="/public/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>