<?php

declare(strict_types=1);

namespace Adhoc\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('EMAIL_VALIDATE_REGEXP', '/^.+\@.+\..+$/i');

/**
 * Outils pour travailler avec les emails
 *
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
    public static function validate(string $email): bool
    {
        if (preg_match(EMAIL_VALIDATE_REGEXP, $email)) {
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
    public static function crypt(string $email, string $mode = '1')
    {
        $str    = '';
        $length = mb_strlen($email);
        switch ($mode) {
            case '1':
                for ($cpt = 0; $cpt < $length; $cpt++) {
                    $str .= '&#' . ord($email[$cpt]) . ';';
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
     * @param string|array<string> $to
     * @param string               $subject
     * @param string               $tplName
     * @param array<string,mixed>  $data
     * @param ?string              $attachment
     *
     * @return bool
     * @throws \Exception
     */
    public static function send(string|array $to = '', string $subject = 'sans sujet', string $tplName = 'default', array $data = [], ?string $attachment = null): bool
    {
        $subject = trim($subject);

        $tpl = new EmailTwig();
        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
        }
        $body = $tpl->render('emails/' . $tplName . '.twig');

        $mail           = new PHPMailer(true);
        $mail->CharSet  = "UTF-8";
        $mail->From     = "contact@adhocmusic.com";
        $mail->FromName = "AD'HOC";
        if (isset($data['email_reply_to'])) {
            $mail->addReplyTo($data['email_reply_to']);
        } else {
            $mail->addReplyTo('contact@adhocmusic.com');
        }

        // Bloque l'acheminement de certains mails, à commenter !!
        $mail->Sender   = "contact@adhocmusic.com";

        $mail->Subject  = $subject;
        $mail->Body     = $body;
        $mail->AltBody  = strip_tags($body);
        $mail->WordWrap = 78;

        if (!is_array($to)) {
            $to = [$to];
        }

        $cpt = 0;
        foreach ($to as $_to) {
            if (Email::validate($_to)) {
                $mail->addAddress($_to);
                $cpt++;
            }
        }
        if ($cpt === 0) {
            return false;
        }

        if (!is_null($attachment)) {
            $mail->addStringAttachment($attachment, $_FILES[$attachment]['name'], 'base64', $_FILES[$attachment]['type']);
        }

        return $mail->send();
    }
}
