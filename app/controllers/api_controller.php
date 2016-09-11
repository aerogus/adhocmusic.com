<?php

/**
 * API AD'HOC
 */
class Controller
{
    const VERSION = 1.0;

    /**
     * @return array
     */
    static function videos()
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        return Video::getVideos(array(
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));
    }

    /**
     * @return array
     */
    static function audios()
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        return Audio::getAudios(array(
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));
    }

    /**
     * @return array
     */
    static function photos()
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        return Photo::getPhotos(array(
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));
    }

    /**
     * @return array
     */
    static function events()
    {
        $groupe = (int) Route::params('groupe');
        $lieu   = (int) Route::params('lieu');
        $datdeb = (string) Route::params('datdeb');
        $datfin = (string) Route::params('datfin');
        $sort   = (string) Route::params('sort');
        $debut  = (int) Route::params('debut');
        $limit  = (int) Route::params('limit');

        return Event::getEvents(array(
            'groupe'  => $groupe,
            'lieu'    => $lieu,
            'datdeb'  => $datdeb,
            'datfin'  => $datfin,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ));
    }
}
