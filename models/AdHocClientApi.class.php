<?php

/**
 * Client de l'API REST/JSON AD'HOC
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class AdHocClientApi
{
    const API_URL = 'http://www.adhocmusic.com/api';
    const API_FORMAT = 'json';

    /**
     * Exécute une requête sur l'API REST AD'HOC
     *
     * @param array $data
     * @return string
     */
    static function query($data)
    {
        $params = '';
        foreach($data as $field => $value) {
            if($field !== 'action') {
                $params .= $field . '=' . $value . '&';
            }
        }

        $resp = file_get_contents(self::API_URL . '/' . $data['action'] . '.' . self::API_FORMAT . '?' . substr($params, 0, -1));

        if(self::API_FORMAT === 'json') {
            return json_decode($resp);
        }
        return $resp;
    }   
}

