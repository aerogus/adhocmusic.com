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
    static function videos() : array
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        return Video::getVideos([
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ]);
    }

    /**
     * @return array
     */
    static function audios() : array
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        return Audio::getAudios([
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ]);
    }

    /**
     * @return array
     */
    static function photos() : array
    {
        $groupe  = (int) Route::params('groupe');
        $event   = (int) Route::params('event');
        $lieu    = (int) Route::params('lieu');
        $contact = (int) Route::params('contact');
        $sort    = (string) Route::params('sort');
        $debut   = (int) Route::params('debut');
        $limit   = (int) Route::params('limit');

        return Photo::getPhotos([
            'groupe'  => $groupe,
            'event'   => $event,
            'lieu'    => $lieu,
            'contact' => $contact,
            'sort'    => $sort,
            'debut'   => $debut,
            'limit'   => $limit,
        ]);
    }

    /**
     * @return array
     */
    static function events() : array
    {
        $groupe = (int) Route::params('groupe');
        $lieu   = (int) Route::params('lieu');
        $datdeb = (string) Route::params('datdeb');
        $datfin = (string) Route::params('datfin');
        $sort   = (string) Route::params('sort');
        $debut  = (int) Route::params('debut');
        $limit  = (int) Route::params('limit');

        return Event::getEvents([
            'groupe' => $groupe,
            'lieu'   => $lieu,
            'datdeb' => $datdeb,
            'datfin' => $datfin,
            'sort'   => $sort,
            'debut'  => $debut,
            'limit'  => $limit,
        ]);
    }
}
