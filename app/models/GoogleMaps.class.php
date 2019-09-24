<?php declare(strict_types=1);

/**
 * Gestion des cartes Google
 *
 * @package AdHoc
 *
 * @see http://code.google.com/intl/fr/apis/maps/documentation/services.html#Geocoding
 * @see http://code.google.com/intl/fr/apis/maps/documentation/geocoding/index.html
 * @see http://www.touraineverte.com/aide-documentation-exemple-tutoriel-didacticiel/api-google-maps/geocodeur/geocoder-adresse-postale-suggerer-proche/coordonnees-gps-latitude-longitude/gclientgeocoder-getlocations.htm
 */
class GoogleMaps
{
    /**
     * Défini dans config.php
     *
     * @param string
     */
    const API_KEY = GOOGLE_MAPS_API_KEY;

    /**
     * Retourne l'url de l'image statique d'une googlemap
     *
     * @param array $params loc "l.at,l.ong" (obligatoire)
     *                      zoom (0 à 21)
     *                      size "largeurxhauteur"
     *                      maptype roadmap|satellite|hybrid|terrain
     *                      format png|gif|jpg
     *                      mobile true|false
     *                      sensor true|false
     *                      icon full url
     *
     * @return string
     *
     * @see http://code.google.com/intl/fr/apis/maps/documentation/staticmaps/
     */
    static function getStaticMap($params)
    {
        if (!array_key_exists('loc', $params)) {
            return '';
        }
        if (!array_key_exists('zoom', $params)) {
            $params['zoom'] = '15';
        }
        if (!array_key_exists('size', $params)) {
            $params['size'] = '320x320';
        }
        if (!array_key_exists('maptype', $params)) {
            $params['maptype'] = 'roadmap';
        }
        if (!array_key_exists('format', $params)) {
            $params['format'] = 'png';
        }
        if (!array_key_exists('mobile', $params)) {
            $params['mobile'] = 'false';
        }
        if (!array_key_exists('sensor', $params)) {
            $params['sensor'] = 'false';
        }
        if (!array_key_exists('icon', $params)) {
            $params['icon'] = '/img/pin/note.png';
        }

        return 'https://maps.googleapis.com/maps/api/staticmap'
          . '?center=' . $params['loc']
          . '&zoom=' . $params['zoom']
          . '&size=' . $params['size']
          . '&maptype=' . $params['maptype']
          . '&mobile=' . $params['mobile']
          . '&format=' . $params['format']
          . '&sensor=' . $params['sensor']
          . '&markers=' . urlencode('icon:' . $params['icon'] . '|shadow:true|label:Lieu|' . $params['loc'])
          . '&key=' . self::API_KEY;
    }

    /**
     * Fait une requête de geocoding à google
     *
     * @param string $addr addr
     *
     * @return array ou false
     */
    static function getGeocode($addr)
    {
        if (empty($addr)) {
            return ['status' => 'EMPTY_REQUEST'];
        }

        $url  = 'http://maps.googleapis.com/maps/api/geocode/json'
              . '?address=' . urlencode($addr)
              . '&region=fr'
              . '&key=' . self::API_KEY;

        $data = file_get_contents($url);
        $data = json_decode($data);
        if ($data->status === 'OK') {
            if (count($data->results)) {
                $lat = (float) $data->results[0]->geometry->location->lat;
                $lng = (float) $data->results[0]->geometry->location->lng;
                return [
                    'status' => 'OK',
                    'lat' => $lat,
                    'lng' => $lng,
                ];
            }
        }
        return ['status' => $data->status];
    }
}
