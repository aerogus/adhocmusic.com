<?php

class Controller
{
    public static function index()
    {
        if(!self::isFan('adhocmusic')) {
            return "PAS FAN :(";
        } else {
            return "FAN :)";
        }
    }

    /**
     * fan de la page facebook.com/adhocmusic ?
     * @return bool
     * @deprecated
     */
    protected static function isFanOldMethod()
    {
        $data = self::getSignedRequest();

        if (empty($data["page"]["liked"])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * fan de la page facebook.com/adhocmusic ?
     * @return bool
     */
    protected static function isFan($page_id = null)
    {
        $data = self::getSignedRequest();
return $data['page']['liked'];
        //echo "<pre>".print_r($data, true)."</pre>";

        if(is_null($page_id)) {
            $page_id = FB_FAN_PAGE_ID;
        }

        try {
            $likes = $_SESSION['fb']->api('/me/likes/' . $page_id);
            if(!empty($likes['data'])) {
                return true;
            } else {
                return false;
            }
        }
        catch(FacebookApiException $e) {
            // si pas loggué
            return false;
        }
    }

    /**
     * return @array
     */
    protected static function getSignedRequest()
    {
        if(empty($_REQUEST['signed_request'])) {
            return false;
        }

        $signed_request = $_REQUEST["signed_request"];
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
        $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
        return $data;
    }
}
