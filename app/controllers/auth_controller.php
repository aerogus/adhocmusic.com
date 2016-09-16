<?php

class Controller
{
    /**
     * Page d'identification
     */
    static function login()
    {
        if(!is_ssl()) {
        //    Tools::redirect('/auth/login', true);
        }

        if(Tools::isSubmit('form-login'))
        {
            $pseudo = trim((string) Route::params('pseudo'));
            $password = trim((string) Route::params('password'));
            $facebook_uid = (int) Route::params('facebook_uid');

            if($id_contact = Membre::checkPseudoPassword($pseudo, $password)) {

                // Authentification réussie, on ouvre une session
                $membre = Membre::getInstance($id_contact);

                // update date derniere visite
                $membre->setVisitedNow();

                if($facebook_uid) {
                    $membre->setFacebookUid($facebook_uid);
                }

                $membre->save();

                $_SESSION['membre'] = $membre;

                if(!empty($_SESSION['redirect_after_auth'])) {
                    $url = $_SESSION['redirect_after_auth'];
                    unset($_SESSION['redirect_after_auth']);
                } else {
                    $url = '/membres/tableau-de-bord';
                }

                Log::action(Log::ACTION_LOGIN);

                Tools::redirect($url);

            } else {

                Log::action(Log::ACTION_LOGIN_FAILED);

                $trail = Trail::getInstance();
                $trail->addStep("Identification");

                $smarty = new AdHocSmarty();
                $smarty->assign('auth_failed', true);
                return $smarty->fetch('auth/login.tpl');

            }
        }

        // déjà authentifié
        if(!empty($_SESSION['membre'])) {
            Tools::redirect('/membres/tableau-de-bord');
        } else {
            $smarty = new AdHocSmarty();
            $smarty->assign('not_auth', true);

            $trail = Trail::getInstance();
            $trail->addStep("Identification");

            return $smarty->fetch('auth/login.tpl');
        }
    }

    /**
     * Callback Facebook login
     */
    static function facebook_login_callback()
    {
        $error = trim((string) Route::params('error'));
        if($error === 'access_denied') {
            die("vous n'avez pas autorisé l'application AD'HOC :(");
        }

        $fb = new Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => 'v2.7',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            die('Graph returned an error: ' . $e->getMessage());
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            die('Facebook SDK returned an error: ' . $e->getMessage());
        }

        // le jeton est ok
        if (isset($accessToken)) {
            $_SESSION['facebook_access_token'] = (string) $accessToken;
            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            $response = $fb->get('/me?fields=email');
            $userNode = $response->getGraphUser();
            $id = $userNode->getField('id');
            $email = $userNode->getField('email');

            // si l'email n'est pas autorisée, on ne peut pas relier avec un compte existant
            if(!$email) {
                die("Vous n'avez pas autorisé l'email dans l'appli Facebook AD'HOC, allez dans vos paramètres d'app et effacez l'app, une nouvelle demande d'autorisation vous sera proposée.");
            }

            // le membre est-il connu ?
            if($id_contact = Membre::getIdByEmail($email)) {

                $membre = Membre::getInstance($id_contact);
                $membre->setVisitedNow();
                $membre->setFacebookAccessToken($accessToken);
                $membre->save();

                $_SESSION['membre'] = $membre;

                Log::action(Log::ACTION_LOGIN_FACEBOOK);

                if(!empty($_SESSION['redirect_after_auth'])) {
                    $url = $_SESSION['redirect_after_auth'];
                    unset($_SESSION['redirect_after_auth']);
                } else {
                    $url = '/membres/tableau-de-bord';
                }

                Tools::redirect($url);
            }

            // si non, inscription et remplissage auto de quelques infos
            // récupérer nom, prénom, email, avatar ...
            // email déjà vérifiée par FB

            return 'FB login OK nouveau user';
        }

        return 'FB login KO bizarre';
    }

    /**
     * Page de déconnexion
     */
    static function logout()
    {
        // si bien identifié, destruction de la session
        if(!empty($_SESSION['membre'])) {

            // delete de la session FB
            $membre = Membre::getInstance($_SESSION['membre']->getId());
            $membre->setFacebookAccessToken('');
            $membre->save();

            Log::action(Log::ACTION_LOGOUT);
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
        }

        Tools::redirect('/?logout');
    }

    static function change_password()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueue_script('/js/change-password.js');

        $trail = Trail::getInstance();
        $trail->addStep("Membres", "/membres/tableau-de-bord");
        $trail->addStep("Mon Compte", "/membres/edit/" . $_SESSION['membre']->getId());
        $trail->addStep("Changer le mot de passe");

        $membre = Membre::getInstance($_SESSION['membre']->getId());

        if(Tools::isSubmit('form-password-change'))
        {
            $password_old   = trim((string) Route::params('password_old'));
            $password_new_1 = trim((string) Route::params('password_new_1'));
            $password_new_2 = trim((string) Route::params('password_new_2'));

            if(($password_old !== "") && ($password_new_1 !== "") && ($password_new_1 === $password_new_2))
            {
                if($membre->checkPassword($password_old)) {
                    if($password_new_1 == $password_old) {
                        $smarty->assign('change_ok', true);
                    } else {
                        $membre->setPassword($password_new_1);
                        $membre->save();
                        Log::action(Log::ACTION_PASSWORD_CHANGED);
                        Email::send($membre->getEmail(), 'Mot de passe modifié', 'password-changed', array('pseudo' => $membre->getPseudo()));
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

    static function lost_password()
    {
        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Membres", "/membres/tableau-de-bord");
        $trail->addStep("Mot de passe perdu");

        if(Tools::isSubmit('form-lost-password'))
        {
            $email = (string) Route::params('email');
            if(Email::validate($email)) {
                if($id_contact = Membre::getIdByEmail($email)) {

                    $membre = Membre::getInstance($id_contact);
                    $new_password = Membre::generatePassword(8);
                    $membre->setPassword($new_password);
                    $membre->save();

                    $data = array(
                        'pseudo' => $membre->getPseudo(),
                        'new_password' => $new_password,
                    );

                    if(Email::send($membre->getEmail(), 'Perte du mot de passe', 'password-lost', $data)) {
                        Log::action(Log::ACTION_PASSWORD_REQUESTED);
                        $smarty->assign('sent_ok', true);
                    } else {
                        $smarty->assign('sent_ko', true);
                    }

                } else {
                    if($id_contact = Contact::getIdByEmail($email)) {
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

    static function check_email()
    {
        $out = array();
        $email = (string) Route::params('email');
        if(Email::validate($email)) {
            if($id_contact = Membre::getIdByEmail($email)) {
                $out['status'] = 'KO_ALREADY_MEMBER';
            } else {
                $out['status'] = 'OK';
            }
        } else {
            $out['status'] = 'KO_INVALID_EMAIL';
        }
        return $out;
    }

    static function check_pseudo()
    {
        $out = array();
        $pseudo = (string) Route::params('pseudo');
        if($id_contact = Membre::getIdByPseudo($pseudo)) {
            $out['status'] = 'KO_PSEUDO_UNAVAILABLE';
        } else {
            $out['status'] = 'OK';
        }
        return $out;
    }
}
