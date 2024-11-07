<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Contact;
use Adhoc\Model\Membre;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Email;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

final class Controller
{
    /**
     * Page hybride d'identification + création de compte
     *
     * @return string
     */
    public static function auth(): string
    {
        // déjà authentifié
        if (!empty($_SESSION['membre'])) {
            Tools::redirect('/membres/tableau-de-bord');
        }

        $twig = new AdHocTwig();

        Trail::getInstance()
            ->addStep('Se connecter ou créer un compte');

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/auth/login.js');
        $twig->enqueueScript('/js/membres/create.js');

        return $twig->render('auth/auth.twig');
    }

    /**
     * Page d'identification
     *
     * @return string
     */
    public static function login(): string
    {
        // déjà authentifié
        if (!empty($_SESSION['membre'])) {
            Tools::redirect('/membres/tableau-de-bord');
        }

        if (Tools::isSubmit('form-login')) {
            $pseudo = trim((string) Route::params('pseudo'));
            $password = trim((string) Route::params('password'));
            $_POST['password'] = '********'; // sécu

            if (mb_strlen($pseudo) === 0 || mb_strlen($password) === 0) {
                Log::action(Log::ACTION_LOGIN_FAILED, print_r($_POST, true));
                die;
            }

            if ($id_contact = Membre::checkPseudoPassword($pseudo, $password)) {
                // Authentification réussie, on ouvre une session
                $membre = Membre::getInstance($id_contact);

                // update date derniere visite
                $membre->setVisitedNow();

                $membre->save();

                $_SESSION['membre'] = $membre;

                if (!empty($_SESSION['redirect_after_auth'])) {
                    $url = $_SESSION['redirect_after_auth'];
                    unset($_SESSION['redirect_after_auth']);
                } else {
                    $url = '/membres/tableau-de-bord';
                }

                Log::action(Log::ACTION_LOGIN);

                Tools::redirect($url);
            } else {
                Log::action(Log::ACTION_LOGIN_FAILED, print_r($_POST, true));

                Trail::getInstance()
                    ->addStep("Se connecter");

                $twig = new AdHocTwig();
                $twig->enqueueScript('/js/auth/login.js');
                $twig->assign('robots', 'noindex,nofollow');
                $twig->assign('auth_failed', true);
                return $twig->render('auth/login.twig');
            }
        } else {
            Tools::redirect('/auth/auth');
        }
    }

    /**
     * Page de déconnexion
     *
     * @return void
     */
    public static function logout(): void
    {
        // si bien identifié, destruction de la session
        if (!empty($_SESSION['membre'])) {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();

            Log::action(Log::ACTION_LOGOUT);
        }

        Tools::redirect('/?logout');
    }

    /**
     * @return string
     */
    public static function changePassword(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/auth/change-password.js');

        $twig->assign('robots', 'noindex,nofollow');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes infos persos', '/membres/edit')
            ->addStep('Changer le mot de passe');

        $membre = Membre::getInstance($_SESSION['membre']->getIdContact());

        if (Tools::isSubmit('form-password-change')) {
            $password_old   = trim((string) Route::params('password_old'));
            $password_new_1 = trim((string) Route::params('password_new_1'));
            $password_new_2 = trim((string) Route::params('password_new_2'));

            if (($password_old !== '') && ($password_new_1 !== '') && ($password_new_1 === $password_new_2)) {
                if ($membre->checkPassword($password_old)) {
                    if ($password_new_1 === $password_old) {
                        $twig->assign('change_ok', true);
                    } else {
                        $membre->setPassword($password_new_1);
                        $membre->save();
                        $twig->assign('new_password', $password_new_1); // DEBUG ONLY
                        Log::action(Log::ACTION_PASSWORD_CHANGED, $password_new_1);
                        Email::send($membre->getContact()->getEmail(), 'Mot de passe modifié', 'password-changed', ['pseudo' => $membre->getPseudo()]);
                        $twig->assign('change_ok', true);
                    }
                } else {
                    $twig->assign('change_ko', true);
                }
            } else {
                $twig->assign('change_ko', true);
            }
        } else {
            $twig->assign('form', true);
        }

        return $twig->render('auth/change-password.twig');
    }

    /**
     * @return string
     */
    public static function lostPassword(): string
    {
        // déjà authentifié
        if (!empty($_SESSION['membre'])) {
            Tools::redirect('/membres/tableau-de-bord');
        }

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/auth/lost-password.js');

        Trail::getInstance()
            ->addStep("Mot de passe oublié");

        if (Tools::isSubmit('form-lost-password')) {
            $email = (string) Route::params('email');
            if (Email::validate($email)) {
                if ($id_contact = Membre::getIdByEmail($email)) {
                    $membre = Membre::getInstance($id_contact);
                    $new_password = Tools::generatePassword(12);
                    $membre->setPassword($new_password);
                    $membre->save();

                    $data = [
                        'pseudo' => $membre->getPseudo(),
                        'new_password' => $new_password,
                    ];

                    if (Email::send($membre->getContact()->getEmail(), 'Perte du mot de passe', 'password-lost', $data)) {
                        Log::action(Log::ACTION_PASSWORD_REQUESTED);
                        $twig->assign('sent_ok', true);
                    } else {
                        $twig->assign('sent_ko', true);
                        $twig->assign('new_password', $new_password); // DEBUG ONLY
                    }
                } else {
                    if ($id_contact = Contact::getIdByEmail($email)) {
                        // pas membre mais contact
                        $twig->assign('err_email_unknown', true);
                    } else {
                        // pas contact du tout
                        $twig->assign('err_email_unknown', true);
                    }
                }
            } else {
                $twig->assign('err_email_invalid', true);
            }

            return $twig->render('auth/lost-password.twig');
        }

        $twig->assign('form', true);

        return $twig->render('auth/lost-password.twig');
    }

    /**
     * Retourne si un email est déjà présente en base
     *
     * @return array<string,string>
     */
    public static function checkEmail(): array
    {
        $email = (string) Route::params('email');
        $out = ['email' => $email];

        if (Email::validate($email)) {
            if ($id_contact = Membre::getIdByEmail($email)) {
                $out['status'] = 'KO_ALREADY_MEMBER';
            } else {
                $out['status'] = 'OK';
            }
        } else {
            $out['status'] = 'KO_INVALID_EMAIL';
        }
        return $out;
    }

    /**
     * Retourne la disponibilité d'un pseudo
     *
     * @return array<string,string>
     */
    public static function checkPseudo(): array
    {
        $pseudo = (string) Route::params('pseudo');
        $out = ['pseudo' => $pseudo];

        if (($id_contact = Membre::getIdByPseudo($pseudo)) !== false) {
            $out['status'] = 'KO_PSEUDO_UNAVAILABLE';
        } else {
            $out['status'] = 'OK';
        }
        return $out;
    }
}
