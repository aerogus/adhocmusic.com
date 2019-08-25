<?php

/**
 * @package AdHoc
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PEAR QuickForm
define('EMAIL_VALIDATE_REGEXP_1', <<<EOT
/$^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/
EOT
);

// http://www.regular-expressions.info/email.html
define('EMAIL_VALIDATE_REGEXP_2',  <<<EOT
/^[a-z0-9!#$%&'*+?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/
EOT
);

// source ?
define('EMAIL_VALIDATE_REGEXP_SIMPLE', <<<EOT
/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/
EOT
);

// source ? mais ca marche bien
define('EMAIL_VALIDATE_REGEXP_3', <<<EOT
/^([a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)(\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@([a-z0-9-]+)(\\.[a-z0-9-]+)*(\\.[a-z]{2,4})$/i
EOT
);

/**
 * Outils pour travailler avec les emails
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see PEAR::HTML_QuickForm/Rules/email.php
 */
class Email
{
    /**
     * Validates an email address
     *
     * @param string $email Email address
     *
     * @return bool true if email is valid
     */
    static function validate($email)
    {
        if (preg_match(EMAIL_VALIDATE_REGEXP_3, $email)) {
            return true;
        }
        return false;
    }

    /**
     * Retourne un email sous une forme cryptée (antispam)
     * (encodage de type &#123)
     *
     * @param string $email email
     * @param string $mode  mode (entité html par défaut)
     *
     * @return string
     *
     * @todo autre modes de cryptages
     */
    static function crypt(string $email, string $mode = '1')
    {
        $str    = "";
        $length = mb_strlen($email);
        switch ($mode)
        {
            case "1":
            for ($cpt = 0 ; $cpt < $length ; $cpt++ ) {
                $str .= '&#'.ord($email[$cpt]).';';
            }
            break;

            default:
            break;
        }
        return $str;
    }

    /**
     * Envoi générique d'email à partir du site, via un template smarty
     *
     * @param string ou array $to
     * @param string $subject
     * @param string $tplName
     * @param array $data
     * @param string $attachment
     *
     * @return bool
     */
    static function send($to = '', string $subject = 'sans sujet', string $tplName = 'default', array $data = [], string $attachment = null)
    {
        $subject = trim($subject);

        $tpl = new EmailSmarty();
        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
        }
        $body = $tpl->fetch($tplName . '.tpl');

        $mail           = new PHPMailer();
        $mail->CharSet  = "UTF-8";
        $mail->From     = "contact@adhocmusic.com";
        $mail->FromName = "Site AD'HOC";
        if (!empty($data['email_reply_to'])) {
            $mail->AddReplyTo($data['email_reply_to']);
        } else {
            $mail->AddReplyTo('contact@adhocmusic.com');
        }

        // Bloque l'acheminement de certains mails, à commenter !!
        //$mail->Sender   = "contact@adhocmusic.com";

        $mail->Subject  = $subject;
        $mail->Body     = $body;
        $mail->AltBody  = strip_tags($body);
        $mail->WordWrap = 78;

        if (is_array($to)) {
            foreach ($to as $_to) {
                $mail->AddAddress($_to);
            }
        } else {
            $mail->AddAddress($to);
        }

        if (!is_null($attachment)) {
            $mail->AddStringAttachment($attachment, $_FILES[$attachment]['name'], 'base64', $_FILES[$attachment]['type']);
        }

        if ($mail->Send()) {
            return true;
        }
        return false;
    }
}
