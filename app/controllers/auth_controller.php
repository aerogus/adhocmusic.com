<?php declare(strict_types=1);

final class Controller
{
    /**
     * Page d'identification
     *
     * @return string
     */
    static function login(): string
    {
        // déjà authentifié
        if (!empty($_SESSION['membre'])) {
            Tools::redirect('/membres/tableau-de-bord');
        }

        if (Tools::isSubmit('form-login')) {
            $pseudo = trim((string) Route::params('pseudo'));
            $password = trim((string) Route::params('password'));

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

                Log::action(Log::ACTION_LOGIN_FAILED);

                Trail::getInstance()
                    ->addStep("Identification");

                $smarty = new AdHocSmarty();
                $smarty->assign('auth_failed', true);
                return $smarty->fetch('auth/login.tpl');

            }
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('not_auth', true);

        Trail::getInstance()
            ->addStep("Identification");

        return $smarty->fetch('auth/login.tpl');
    }

    /**
     * Page de déconnexion
     *
     * @return ?string
     */
    static function logout()
    {
        // si bien identifié, destruction de la session
        if (!empty($_SESSION['membre'])) {

            Log::action(Log::ACTION_LOGOUT);
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
        }

        Tools::redirect('/?logout');
    }

    /**
     * @return string
     */
    static function change_password(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/change-password.js');

        Trail::getInstance()
            ->addStep("Tableau de bord", "/membres/tableau-de-bord")
            ->addStep("Mes Infos Persos", "/membres/edit")
            ->addStep("Changer le mot de passe");

        $membre = Membre::getInstance($_SESSION['membre']->getId());

        if (Tools::isSubmit('form-password-change')) {
            $password_old   = trim((string) Route::params('password_old'));
            $password_new_1 = trim((string) Route::params('password_new_1'));
            $password_new_2 = trim((string) Route::params('password_new_2'));

            if (($password_old !== '') && ($password_new_1 !== '') && ($password_new_1 === $password_new_2)) {
                if ($membre->checkPassword($password_old)) {
                    if ($password_new_1 === $password_old) {
                        $smarty->assign('change_ok', true);
                    } else {
                        $membre->setPassword($password_new_1);
                        $membre->save();
                        $smarty->assign('new_password', $password_new_1); // DEBUG ONLY
                        Log::action(Log::ACTION_PASSWORD_CHANGED, $password_new_1);
                        Email::send($membre->getEmail(), 'Mot de passe modifié', 'password-changed', ['pseudo' => $membre->getPseudo()]);
                        $smarty->assign('change_ok', true);
                    }
                } else {
                    $smarty->assign('change_ko', true);
                }
            } else {
                $smarty->assign('change_ko', true);
            }
        } else {
            $smarty->assign('form', true);
        }

        return $smarty->fetch('auth/change-password.tpl');
    }

    /**
     * @return string
     */
    static function lost_password(): string
    {
        // déjà authentifié
        if (!empty($_SESSION['membre'])) {
            Tools::redirect('/membres/tableau-de-bord');
        }

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/lost-password.js');

        Trail::getInstance()
            ->addStep("Mot de passe oublié");

        if (Tools::isSubmit('form-lost-password')) {
            $email = (string) Route::params('email');
            if (Email::validate($email)) {
                if ($id_contact = Membre::getIdByEmail($email)) {

                    $membre = Membre::getInstance($id_contact);
                    $new_password = Tools::generatePassword(8);
                    $membre->setPassword($new_password);
                    $membre->save();

                    $data = [
                        'pseudo' => $membre->getPseudo(),
                        'new_password' => $new_password,
                    ];

                    if (Email::send($membre->getEmail(), 'Perte du mot de passe', 'password-lost', $data)) {
                        Log::action(Log::ACTION_PASSWORD_REQUESTED);
                        $smarty->assign('sent_ok', true);
                    } else {
                        $smarty->assign('sent_ko', true);
                        $smarty->assign('new_password', $new_password); // DEBUG ONLY
                    }

                } else {
                    if ($id_contact = Contact::getIdByEmail($email)) {
                        // pas membre mais contact
                        $smarty->assign('err_email_unknown', true);
                    } else {
                        // pas contact du tout
                        $smarty->assign('err_email_unknown', true);
                    }
                }
            } else {
                $smarty->assign('err_email_invalid', true);
            }

            return $smarty->fetch('auth/lost-password.tpl');
        }

        $smarty->assign('form', true);

        return $smarty->fetch('auth/lost-password.tpl');
    }

    /**
     * Retourne si un email est déjà présente en base
     *
     * @return array
     */
    static function check_email(): array
    {
        $out = [];
        $email = (string) Route::params('email');
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
     * @return array
     */
    static function check_pseudo(): array
    {
        $out = [];
        $pseudo = (string) Route::params('pseudo');
        if ($id_contact = Membre::getIdByPseudo($pseudo)) {
            $out['status'] = 'KO_PSEUDO_UNAVAILABLE';
        } else {
            $out['status'] = 'OK';
        }
        return $out;
    }
}
