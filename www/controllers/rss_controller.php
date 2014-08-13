<?php

setlocale(LC_ALL, 'en_GB.UTF8');

class Controller
{
    public static function news()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('newslist', News::getNewsList(array(
            'online' => true,
            'sort'   => 'created_on',
            'sens'   => 'DESC',
            'debut'  => 0,
            'limit'  => 10,
        )));

        return $smarty->fetch('rss/news.tpl');
    }
}
