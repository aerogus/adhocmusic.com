<?php

/**
 * Client de l'API REST/JSON AD'HOC
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class AdHocClientApi
{
    const API_URL     = 'https://www.adhocmusic.com/api';
    const API_VERSION = 'v1';
    const API_FORMAT  = 'json';

    /**
     * Exécute une requête sur l'API REST AD'HOC
     *
     * @param array $data données
     *
     * @return string
     */
    static function query(array $data): string
    {
        $params = '';
        foreach ($data as $field => $value) {
            $params .= $field . '=' . $value . '&';
        }

        $resp = file_get_contents(self::API_URL . '/' . self::API_VERSION . '/' . $data['action'] . '.' . self::API_FORMAT . '?' . substr($params, 0, -1));

        if (self::API_FORMAT === 'json') {
            return json_decode($resp);
        }
        return $resp;
    }
}
