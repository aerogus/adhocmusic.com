<?php

/**
 * @package adhoc
 */

/**
 * Gestion des cartes Google
 *
 * @package adhoc
 *
 * @see http://code.google.com/intl/fr/apis/maps/documentation/services.html#Geocoding
 * @see http://code.google.com/intl/fr/apis/maps/documentation/geocoding/index.html
 * @see http://www.touraineverte.com/aide-documentation-exemple-tutoriel-didacticiel/api-google-maps/geocodeur/geocoder-adresse-postale-suggerer-proche/coordonnees-gps-latitude-longitude/gclientgeocoder-getlocations.htm
 */
class GoogleMaps
{
    /**
     * clé pour le domaine www.adhocmusic.com
     */
    const API_KEY = 'ABQIAAAA7PeOKqwrtUMPRPRF-gLCixTU5RmDj2SoHXiPTLad0-64-2MtShTh1QvrKRs0t2Rj95LauGO9RBqidg';

    /**
     * version de l'api à utiliser : 2.s|2|2.x
     */
    const VERSION = '2.x';

    /**
     * système avec GPS ?
     */
    const SENSOR = 'false';

    /**
     * retourne le javascript de chargement initial
     */
    public static function getInitJs()
    {
        return 'http://maps.google.com/maps?file=api&amp;v='.self::VERSION.'&amp;sensor='.self::SENSOR.'&amp;key='.self::API_KEY;
    }

    /**
     * retourne l'url de l'image statique d'une googlemap
     *
     * @param string loc "l.at,l.ong" (obligatoire)
     * @param string zoom (0 à 21)
     * @param string size "largeurxhauteur"
     * @param string maptype roadmap|satellite|hybrid|terrain
     * @param string format png|gif|jpg
     * @param string mobile true|false
     * @param string sensor true|false
     * @param string icon full url
     * @return string
     * @see http://code.google.com/intl/fr/apis/maps/documentation/staticmaps/
     */
    public static function getStaticMap($params)
    {
        if(!array_key_exists('loc', $params))
            return '';
        if(!array_key_exists('zoom', $params))
            $params['zoom'] = '15';
        if(!array_key_exists('size', $params))
            $params['size'] = '320x320';
        if(!array_key_exists('maptype', $params))
            $params['maptype'] = 'roadmap';
        if(!array_key_exists('format', $params))
            $params['format'] = 'png';
        if(!array_key_exists('mobile', $params))
            $params['mobile'] = 'false';
        if(!array_key_exists('sensor', $params))
            $params['sensor'] = 'false';
        if(!array_key_exists('icon', $params))
            $params['icon'] = STATIC_URL . '/img/pin/note.png';

        return 'http://maps.google.com/maps/api/staticmap'
          . '?center=' . $params['loc']
          . '&zoom=' . $params['zoom']
          . '&size=' . $params['size']
          . '&maptype=' . $params['maptype']
          . '&mobile=' . $params['mobile']
          . '&format=' . $params['format']
          . '&sensor=' . $params['sensor']
          . '&markers=' . urlencode('icon:' . $params['icon'] . '|shadow:true|label:Lieu|' . $params['loc']);
    }

    /**
     * fait une requête de geocoding à google
     *
     * @param string $addr
     * @return array ou false
     */
    public static function getGeocode($addr)
    {
        if(empty($addr)) {
            return array('status' => 'EMPTY_REQUEST');
        }

        $url  = 'http://maps.googleapis.com/maps/api/geocode/json'
              . '?address=' . urlencode($addr)
              . '&region=fr'
              . '&sensor=false';
        $data = file_get_contents($url);
        $data = json_decode($data);
        if($data->status == 'OK') {
            if(sizeof($data->results)) {
                $lat = (float) $data->results[0]->geometry->location->lat;
                $lng = (float) $data->results[0]->geometry->location->lng;
                return array(
                    'status' => 'OK',
                    'lat' => $lat,
                    'lng' => $lng,
                );
            }
        }
        return array('status' => $data->status);
    }
}
