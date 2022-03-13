<?php declare(strict_types=1);

define('NB_AUDIOS_PER_PAGE', 80);

final class Controller
{
    /**
     * @return string
     */
    static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Audios");

        $page = (int) Route::params('page');;

        $smarty = new AdHocSmarty();
        $audios = Audio::find(
            [
                'order_by' => 'id_audio',
                'sort' => 'ASC',
            ]
        );
        $nb_audios = count($audios);

        $smarty->assign('audios', $audios);

        // pagination
        $smarty->assign('nb_items', $nb_audios);
        $smarty->assign('nb_items_per_page', NB_AUDIOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/audios/index.tpl');
    }
}
