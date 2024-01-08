class TestEmail {

private function __construct() {}

public static function sendEmail($type, $email, $userData, $data) {
    try {
        // Recipient email address
       

        // Message body
        $message = '';

        switch ($type) {
            case (Config::get('mailer/email_email_verification')):
                $to = $email;
                $subject = Config::get('mailer/email_email_verification_subject');
                $message = Templates::getEmailVerificationBody($userData, $data);
                break;
            case (Config::get('mailer/email_revoke_email')):
                $to = $email;
                $subject = Config::get('mailer/email_revoke_email_subject');
                $message = Templates::getRevokeEmailBody($userData, $data);
                break;
            case (Config::get('mailer/email_update_email')):
                $to = $email;
                $subject = Config::get('mailer/email_update_email_subject');
                $message = Templates::getUpdateEmailBody($userData, $data);
                break;
            case (Config::get('mailer/email_password_reset')):
                $to = $email;
                $subject = Config::get('mailer/email_password_reset_subject');
                $message = Templates::getPasswordResetBody($userData, $data);
                break;
            case (Config::get('mailer/email_report_bug')):
                $subject = "[" . ucfirst($data["label"]) . "] " . Config::get('mailer/email_report_bug_subject') . " | " . $data["subject"];
                $message = Templates::getReportBugBody($userData, $data);
                break;
            case (Config::get('mailer/email_contact_form')):
                $subject = $data["subject"];
                $message = Templates::getContactBody($data);
                break;
            case (Config::get('mailer/email_quote_form')):
                $subject = Config::get('mailer/email_quote_form_subject');
                $message = Templates::getQuoteBody($data);
                break;
            case (Config::get('mailer/email_payment_receipt')):
                $subject = Config::get('mailer/email_payment_receipt_subject');
                $message = Templates::getReceiptBody($data);
                break;
        }

        // Headers for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: " . Config::get('mailer/email_from_name') . " <" . Config::get('mailer/email_from') . ">" . "\r\n";

        // Send the email using the mail function
        $mailed = mail($to, $subject, $message, $headers);

        if ($mailed) {
            echo "Email sent successfully to $to";
        } else {
            echo "Email sending failed";
        }

    } catch (Exception $e) {
        Session::set('danger', 'Message could not be sent. <br> <strong>Mailer Error:</strong> ' . $e->getMessage());
    }
}
}
