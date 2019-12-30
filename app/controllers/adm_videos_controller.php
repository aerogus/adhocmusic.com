<?php declare(strict_types=1);

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
            ->addStep("Vidéos");

        $smarty = new AdHocSmarty();

        $smarty->assign(
            'videos', Video::find(
                [
                    'order_by' => 'id_video',
                    'sort' => 'ASC',
                ]
            )
        );

        return $smarty->fetch('adm/videos/index.tpl');
    }
}
