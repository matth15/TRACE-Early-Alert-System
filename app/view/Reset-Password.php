<?php

$page_title = "Forgot password";
require_once __DIR__ . '/partials/Header.inc.php';
require_once __DIR__ . '/partials/Nav.inc.php';

?>
<section class="form-section" id="form-section">
  <?php 
   $userinfo = !empty(Session::getUserEmail()) ? Session::getUserEmail() : null;
  ?>
  <div class="wrapper mx-1">
    <div class="container shadow bg-light rounded-3 p-3 p-sm-4">
      <div class="row ">
        <h1>
          New password
        </h1>
        <form action="<?= baseurl() ?>/auth/reset_password" method="POST">
        
          <?php Session::success('RESET-PASSWORD-SUCCESS') ?  Session::success('RESET-PASSWORD-SUCCESS') : ''; ?>
          <?php Session::danger('RESET-PASSWORD-DANGER') ?  Session::danger('RESET-PASSWORD-DANGER') : ''; ?>
          <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>">
          <input type="hidden" name="email" value="<?= $userinfo ?>">
          <div class="col-12 ">
            <div class="form-group col-12 pb-2">
              <input type="password" class="form-control rounded-1" name="n_pass" placeholder="New password">
            </div>
            <div class="form-group col-12">
              <input type="password" class="form-control rounded-1" name="n_cpass" placeholder="Confirm new password">
            </div>
            <div class="form-group col-12 d-flex justify-content-end py-2">
              <button type="submit" name="reset-password_submit" class="btn btn-primary m-0">Confirm</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?php
include(__DIR__ . '/partials/Footer.inc.php');
?>