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
            ->addStep("Audios");

        $smarty = new AdHocSmarty();

        $smarty->assign(
            'audios', Audio::find(
                [
                    'order_by' => 'id_audio',
                    'sort' => 'ASC',
                ]
            )
        );

        return $smarty->fetch('adm/audios/index.tpl');
    }
}
