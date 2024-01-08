<?php

$page_title = "Log In";
require_once(__DIR__ . '/partials/Header.inc.php');
require_once(__DIR__ . '/partials/Nav.inc.php');
?>

<section class="form-section" id="form-section">
  <div class="wrapper p-1">
    <div class="container shadow bg-light rounded-3 p-2 p-sm-4 ">
      <div class="row">
        <h1>
          Login
        </h1>

        <form action="<?= baseurl() ?>/auth/login/" method="POST">
          <?php Session::warning('LOGIN-WARNING') ? Session::warning('LOGIN-WARNING') : '' ?>
          <?php Session::danger('LOGIN-ERROR') ? Session::danger('LOGIN-ERROR') : '' ?>
          <?php Session::success('LOGIN-SUCCESS') ? Session::success('LOGIN-SUCCESS') : '' ?>
          <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>">

          <hr>
          <div class="col-12 ">
            <div class="form-group col-12 my-2 pt-1">
              <input type="email" class="form-control rounded-1" name="email" value="<?= old_value('email') ?>" id="emailInput" placeholder="TRACE E-mail">
            </div>
            <div class="form-group password-container col-12 ">
              <input type="password" class="form-control rounded-1" name="password" value="<?= old_value('password') ?>" id="passwordInput" placeholder="Password">
            </div>
            <div class="form-check pt-1 pb-2 pb-sm-3 mx-1" >
              <input class="form-check-input" type="checkbox" value="" id="show-password-toggle">
              <label class="form-check-label" style="cursor: pointer;" for="show-password-toggle">Show password</label>
            </div>
            <div class="form-group d-grid col-12">
              <button type="submit" class="btn btn-primary py-2" name="login_submit">Login</button>
            </div>
            <hr>
            <div class="text-center pb-2">
              <a href="<?= baseurl() ?>/auth/forgot_password" class="forgot-password-btn ">Forgot password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?php
require_once(__DIR__ . '/partials/Footer.inc.php');?>