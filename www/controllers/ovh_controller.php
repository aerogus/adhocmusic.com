<?php

Class Controller
{
    public static function mailingListList()
    {
        $smarty = new AdHocSmarty();

        $ovh = OvhApi::getInstance();
        $list = $ovh->mailingListList();

        $smarty->assign('list', $list);

        return $smarty->fetch('ovh/mailingListList.tpl');
    }

    public static function mailingListInfo()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('ovh/mailingListInfo.tpl');
    }

    public static function mailingListSubscriberList()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('ovh/mailingListSubscriberList.tpl');
    }

    public static function mailingListSubscriberAdd()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('ovh/mailingListSubscriberAdd.tpl');
    }

    public static function mailingListSubscriberDel()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('ovh/mailingListSubscriberDel.tpl');
    }
}
