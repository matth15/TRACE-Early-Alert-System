<?php

$page_title = "OTP Verification";
require_once(__DIR__ . '/partials/Header.inc.php');
require_once(__DIR__ . '/partials/Nav.inc.php');
?>
<section class="form-section " id="form-section">
    <?php
    $userinfo = $this->authmodel->getProfileInfo(Session::getUserEmail())
        ?  $this->authmodel->getProfileInfo(Session::getUserEmail()) : null;
    ?>
    
    <div class="wrapper px-1 w-100">
        <div class="container shadow bg-light rounded-3" >
            <form action="" method="post">
                <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>">
                <input type="hidden" name="email" value="<?= $userinfo['email'] ?>">
                <h1 class="text-center pt-2"> Email Code Verification</h1>
                <?php Session::success('OTP-SUCCESS') ?  Session::success('OTP-SUCCESS') : ''; ?>
                <?php Session::danger('OTP-ERROR') ? Session::danger('OTP-ERROR') : ''; ?>
                <hr>
                <div class="form-group col-12 py-2 py-sm-3">
                    <input type="text" class="form-control" name="otp_data" id="otpInput" placeholder="Enter code">
                </div>
                <div class="form-group d-flex flex-column py-1 px-3">
                    <button type="submit" class="btn btn-primary " name="otp_submit">Enter code</button>
                  
                </div>
            </form>
            <hr>

            <?php
            //
            if (!is_null($userinfo)) {
                $otpExpiration = strtotime($userinfo['otp_expiration']);
                //
                if ($otpExpiration && time() > $otpExpiration) {
            ?>
                    <form action="<?= baseurl() ?>/auth/resendOTP" method="post">
                        <div class="resend-otp d-flex justify-content-center py-1 py-sm-2">
                            <input type="hidden" name="csrf_token" value="<?= Session::generateCsrfToken(); ?>">
                            <input type="hidden" name="email" value="<?= $userinfo['email'] ?>">
                            <div class="btn-resend-otp">
                                <span class="">Expired code?</span>
                                <button type="submit" class=" btn btn-sm btn-outline-success "> Get a new one.</button>
                            </div>
                        </div>
                    </form>
            <?php }
            } ?>

        </div>
    </div>
</section>
<?php
require_once(__DIR__ . '/partials/Footer.inc.php');
?>