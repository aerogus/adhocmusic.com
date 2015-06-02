<?php

class Controller
{
    static function get_videos()
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');
    
        $videos  =  Video::getVideos(array(
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));

        return $videos;
    }

    static function get_audios()
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut'); 
        $limit   = (int) Route::params('limit');

        $audios  =  Audio::getAudios(array(
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut, 
            'limit'   => $limit,
        ));

        return $audios;
    }

    static function get_photos()
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut'); 
        $limit   = (int) Route::params('limit');

        $photos  = Photo::getPhotos(array(
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));

        return $photos;
    }

    static function get_events()
    {
        $groupe = (int) Route::params('groupe');
        $lieu   = (int) Route::params('lieu');
        $datdeb = (string) Route::params('datdeb');
        $datfin = (string) Route::params('datfin');
        $sort   = (string) Route::params('sort');
        $debut  = (int) Route::params('debut'); 
        $limit  = (int) Route::params('limit');

        $events = Event::getEvents(array(
            'groupe'  => $groupe,
            'lieu'    => $lieu,
            'datdeb'  => $datdeb,
            'datfin'  => $datfin,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));

        return $events;
    }

    static function doc()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('source_client', highlight_file(ADHOC_LIB_PATH . '/AdHocClientApi.class.php', true));

        return $smarty->fetch('doc.tpl');
    }

    static function console()
    {
        $action  = (string) Route::params('action');
        $format  = (string) Route::params('format');
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $datdeb  = (string) Route::params('datdeb');
        $datfin  = (string) Route::params('datfin');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $sens    = (string) Route::params('sens');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        $smarty = new AdHocSmarty();

        $smarty->assign('actions', array(
            'get-events',
            'get-audios',
            'get-videos',
            'get-photos',
        ));

        $smarty->assign('formats', array(
            'json',
            'phpser',
            'txt',
        ));

        $smarty->assign('action', $action);
        $smarty->assign('format', $format);
        $smarty->assign('groupe', $groupe);
        $smarty->assign('event', $event);
        $smarty->assign('datdeb', $datdeb);
        $smarty->assign('datfin', $datfin);
        $smarty->assign('lieu', $lieu);
        $smarty->assign('contact', $contact);
        $smarty->assign('sort', $sort);
        $smarty->assign('sens', $sens);
        $smarty->assign('debut', $debut);
        $smarty->assign('limit', $limit);

        if(Tools::isSubmit('form-console')) {
            $resp = AdHocClientApi::query(
                array(
                    'action'  => $action,
                    'format'  => $format,
                    'groupe'  => $groupe,
                    'event'   => $event,
                    'datdeb'  => $datdeb,
                    'datfin'  => $datfin,
                    'lieu'    => $lieu,
                    'contact' => $contact,
                    'sort'    => $sort,
                    'sens'    => $sens,
                    'debut'   => $debut,
                    'limit'   => $limit,
                )
            );
            $smarty->assign('resp', $resp);
        }

        return $smarty->fetch('console.tpl');
    }
}

