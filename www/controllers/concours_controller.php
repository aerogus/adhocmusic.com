<?php

class Controller
{
    public static function index()
    {
        $trail = Trail::getInstance();
        $trail->addStep("Jeux Concours", "/concours/");

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "♫ Jeux Concours - CDs et Places de Concerts à Gagner !");
        $smarty->assign('description', "Jeux Concours - CDs et Places de Concerts à Gagner !");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");

        $smarty->assign('concours', Concours::getActifs());

        return $smarty->fetch('concours/index.tpl');
    }

    public static function show()
    {
        $id = (int) Route::params('id');

        $concours = new Concours($id);

        $trail = Trail::getInstance();
        $trail->addStep("Jeux Concours", "/concours/");
        $trail->addStep($concours->getTitle(), "/concours/show/" . $concours->getId());

        $smarty = new AdHocSmarty();
        $smarty->assign('title', $concours->getTitle());
        $smarty->assign('description', "Jeux Concours - CDs et Places de Concerts à Gagner !");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");
        $smarty->assign('concours', $concours);
        $smarty->assign('og_image', 'http://static.adhocmusic.com/img/concours/c5.jpg');
        return $smarty->fetch('concours/show.tpl');
    }

    public static function play()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $concours = new Concours($id);

        $trail = Trail::getInstance();
        $trail->addStep("Jeux Concours", "/concours/");
        $trail->addStep($concours->getTitle(), "/concours/show/" . $concours->getId());

        $smarty = new AdHocSmarty();
        $smarty->assign('title', $concours->getTitle());
        $smarty->assign('description', "Jeux Concours - CDs et Places de Concerts à Gagner !");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");
        $smarty->assign('concours', $concours);

        if(Tools::isSubmit('form-concours-play'))
        {
            $id_contact = (int) $_SESSION['membre']->getId();
            $nb_qr = $concours->getQrCount();
    
            try {
                $concours->addParticipant($id_contact, $_SESSION['ip'], $_SESSION['host']);
                for($i = 1 ; $i <= $nb_qr ; $i++)
                {
                    $field_name = 'q' . $i;
                    $concours->addReponse($id_contact, $i, (int) Route::params($field_name));
                }
                $smarty->assign('show_congrats', true);
            }
            catch(Exception $e) {
                $smarty->assign('error', 'already_played');
            }
        }
        else
        {
            $smarty->assign('show_form', true);
        }

        return $smarty->fetch('concours/play.tpl');
    }

    public static function results()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id = (int) Route::params('id');

        $concours = new Concours($id);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Jeux Concours", "/concours/");
        $trail->addStep($concours->getTitle(), "/concours/show/" . $concours->getId());

        $smarty->assign('concours', $concours);

        $smarty->assign('results', $concours->getResults());

        return $smarty->fetch('concours/results.tpl');
    }
}
