<?php

/**
 * Client de l'API REST/JSON AD'HOC
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class AdHocClientApi
{
    const ID_GROUPE   = '0'; // à remplacer par votre id_groupe
    const ID_CONTACT  = '0'; // à remplacer par votre id_membre
    const API_KEY     = '';  // à remplacer par la clé API qui vous a été fournie

    const API_URL     = 'api.adhocmusic.com';
    const API_VERSION = '2';
    const API_FORMAT  = 'json';

    /**
     * @return array
     */
    static function getPhotos()
    {
        return self::query(
            array(
                'action'  => 'get-photos',
                'groupe'  => self::ID_GROUPE,
                'contact' => self::ID_CONTACT,
                'limit'   => '50',
            )
        );
    }

    /**
     * @return array
     */
    static function getVideos()
    {
        return self::query(
            array(
                'action' => 'get-videos',
                'groupe' => self::ID_GROUPE,
                'limit'  => '50',
            )
        );
    }

    /**
     * @return array
     */
    static function getAudios()
    {
        return self::query(
            array(
                'action' => 'get-audios',
                'groupe' => self::ID_GROUPE,
                'limit'  => '12',
            )
        );
    }

    /**
     * @return array
     */
    static function getEvents()
    {
        return self::query(
            array(
                'action' => 'get-events',
                'groupe' => self::ID_GROUPE,
                'datdeb' => date('Y-m-d'),
                'limit'  => '30',
            )
        );
    }

    /**
     * Exécute une requête sur l'API REST/JSON AD'HOC
     *
     * @param array $data
     * @return string au format json
     */
    static function query($data)
    {
        $params = '';
        foreach($data as $field => $value) {
            $params .= $field . '=' . $value . '&';
        }   
        $resp = file_get_contents('http://' . self::API_URL . '/' . $data['action'] . '.' . $data['format'] . '?' . substr($params, 0, -1));
        return $resp;
        if($data['format'] == 'json') {
            $resp = json_decode($resp);
        }
        return $resp;
    }   
}

