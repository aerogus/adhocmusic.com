<?php

/**
 * API AD'HOC
 */
class Controller
{
    /**
     *
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

        $videos  = Video::getVideos(array(
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

    /**
     *
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

        $audios  = Audio::getAudios(array(
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

    /**
     *
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

    /**
     *
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
}
