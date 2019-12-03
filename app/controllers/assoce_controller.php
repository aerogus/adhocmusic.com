<?php declare(strict_types=1);

final class Controller
{
    /**
     * @return string
     */
    static function assoce(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("L'Association");

        return $smarty->fetch('assoce/presentation.tpl');
    }

    /**
     * @return string
     */
    static function concerts(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Concerts");

        $smarty->enqueue_script('/js/masonry-4.2.2.min.js');
        $smarty->enqueue_script('/js/imagesloaded-4.1.4.min.js');

        $smarty->enqueue_script('/js/assoce-concerts.js');

        // tri antéchrono des saisons
        $smarty->assign('events', array_reverse(Event::getAdHocEventsBySeason()));

        return $smarty->fetch('assoce/concerts.tpl');
    }

    /**
     * @return string
     */
    static function afterworks(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Afterworks");

        return $smarty->fetch('assoce/afterworks.tpl');
    }

    /**
     * @return string
     */
    static function festival(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Festival");

        return $smarty->fetch('assoce/festival.tpl');
    }

    /**
     * @return string
     */
    static function equipe(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()->addStep("Équipe");

        $smarty->assign('membres', MembreAdhoc::getStaff(true));

        return $smarty->fetch('assoce/equipe.tpl');
    }
}
