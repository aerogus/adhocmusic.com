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
            ->addStep("Photos");

        $smarty = new AdHocSmarty();

        $smarty->assign(
            'photos', Photo::find(
                [
                    'order_by' => 'id_photo',
                    'sort' => 'ASC',
                ]
            )
        );

        return $smarty->fetch('adm/photos/index.tpl');
    }
}
