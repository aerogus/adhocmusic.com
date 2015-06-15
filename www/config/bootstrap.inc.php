<?php

setlocale(LC_ALL, 'fr_FR.UTF8');
ini_set('date.timezone', 'Europe/Paris');
ini_set("default_charset", "UTF-8");

error_reporting(-1); // taquet

// todo: mettre des conditions pour trouver
// tout seul l'environnement
define('ENV', 'PROD'); // TEST ou PROD

if(ENV === 'PROD') {
    define('_DB_HOST_',             'localhost');
    define('_DB_USER_',             'adhocmusic');
    define('_DB_PASSWORD_',         'kK2972Wd');
    define('_DB_DATABASE_',         'adhocmusic');
    define('SERVER_ROOT_PATH',      '/var/www');
    define('ADHOC_ROOT_PATH',       SERVER_ROOT_PATH . '/adhocmusic.com');
    define('DYN_URL',               'http://www.adhocmusic.com');
    define('STATIC_URL',            'http://static.adhocmusic.com');
    define('CACHE_URL',             'http://static.adhocmusic.com');
} elseif(ENV === 'TEST') {
    define('_DB_HOST_',             'localhost');
    define('_DB_USER_',             'root');
    define('_DB_PASSWORD_',         '');
    define('_DB_DATABASE_',         'adhoc');
    define('SERVER_ROOT_PATH',      '/Users/gus/workspace/adhoc');
    define('ADHOC_ROOT_PATH',       SERVER_ROOT_PATH);
    define('DYN_URL',               'http://www.adhocmusic.localhost');
    define('STATIC_URL',            'http://static.adhocmusic.localhost');
    define('CACHE_URL',             'http://static.adhocmusic.localhost');
}

define('COMMON_LIB_PATH',           ADHOC_ROOT_PATH . '/lib');
define('ADHOC_LIB_PATH',            ADHOC_ROOT_PATH . '/models');
define('ADHOC_ROUTES_FILE',         ADHOC_ROOT_PATH . '/www/config/routes');
define('ADHOC_SITE_PATH',           ADHOC_ROOT_PATH . '/www/models');
define('ADHOC_LOG_PATH',            ADHOC_ROOT_PATH . '/log');
define('COMMON_LIB_PHP_PATH',       COMMON_LIB_PATH . '/php');
define('COMMON_LIB_SMARTY_PATH',    COMMON_LIB_PATH . '/smarty');
define('COMMON_LIB_PHPMAILER_PATH', COMMON_LIB_PATH . '/phpmailer');
define('COMMON_LIB_FACEBOOK_PATH',  COMMON_LIB_PATH . '/facebook');
define('DEFAULT_CONTROLLERS_PATH',  ADHOC_ROOT_PATH . '/www/controllers/');

define('DB_ADHOC_DEFAULT',          1);

define('TRAIL_ENABLED', true);
define('ADHOC_COUNTERS', true);

define('SMARTY_TEMPLATE_PATH',   ADHOC_ROOT_PATH . '/www/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/cache/smarty');

define('FB_FAN_PAGE_ID', '161908907197840');
if(strpos($_SERVER['REQUEST_URI'], 'adhocbandpage') === false) {
	// App AD'HOC Music
	define('FB_APP_ID', '50959607741');
	define('FB_API_KEY', '9bff9746d384c2b4dd0c4fa130bcaecd');
	define('FB_SECRET_KEY', 'c2ea0c274c21507404f21688f71f98c1');
	define('FB_APP_ROOT_URL', 'http://apps.facebook.com/adhocmusic');
    define('FB_APP_PAGE_URL', 'http://www.facebook.com/adhocmusic');
} else {
	// App AD'HOC Band Page
	define('FB_APP_ID', '187899161253440');
	define('FB_API_KEY', 'b2a6085ec3e706d0728c3f044987254f');
	define('FB_SECRET_KEY', '73e15d16443e1bda65c55cfc1655b87b');
	define('FB_APP_ROOT_URL', 'http://apps.facebook.com/adhocbandpage');
    define('FB_APP_PAGE_URL', 'http://www.facebook.com/bandpagebyadhoc');
}
define('FB_APP_DEFAUT_AVATAR_GROUPE', STATIC_URL . '/img/note_adhoc_64.png');

require_once 'autoload.inc.php';
require_once 'errors.inc.php';

Tools::sessionInit();

// chargement de l'api FB longue, limiter aux pages nécessaires
//if($_SERVER['REQUEST_URI'] == '/') {
if($_SERVER['REQUEST_URI'] != '/auth/logout') {

    $_SESSION['fb'] = new Facebook(array(
        'appId'  => FB_APP_ID,
        'secret' => FB_SECRET_KEY,
        'fileUpload' => false,
    ));

    if($_SESSION['fb']->getUser()) {
        try {
            if(empty($_SESSION['membre'])) { // pas encore loggué adhoc
                if($id_contact = Membre::getIdContactByFacebookProfileId($_SESSION['fb']->getUser())) {
                    $membre = Membre::getInstance($id_contact);
                    if($membre->getFacebookAutoLogin() || isset($_GET['auth-from-fb'])) {
                        $_SESSION['membre'] = $membre;
                        $membre->setVisitedNow();
                        $membre->save();
                        Log::action(Log::ACTION_LOGIN_FACEBOOK);
                    } else {
                        // on laisse non identifié malgré le fait qu'on ait reconnu son compte AD'HOC via son profil facebook lié
                    }
                } else {
                    // n'a pas de compte ad'hoc ? on lui fait compléter ?
                    //Tools::redirect('/membres/create-fb');
                    mail('guillaume.seznec@gmail.com', 'log adhoc via fb sans compte adhoc', print_r($_SESSION['fb']->api('/me'), true) . "\nid: " . $_SESSION['fb']->getUser());
                }
            }
        } catch (FacebookApiException $e) {
            // gestion exception
        }
    }

} // != logout

