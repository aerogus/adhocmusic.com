#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * ce script va renter de retrouver les events fb des groupes qui ont liés leur page
 */

require_once COMMON_LIB_FACEBOOK_PATH . '/facebook.php';

$fb = new Facebook(array(
    'appId'  => FB_APP_ID,
    'secret' => FB_SECRET_KEY,
    'fileUpload' => false,
));

if($fb->getUser()) {
   echo "oui";
} else {
   echo "non";
}

$db = DataBase::getInstance();
$sql = 'SELECT id_groupe, name, facebook_page_id FROM adhoc_groupe WHERE facebook_page_id IS NOT NULL AND facebook_page_id <> ""';
$grps = $db->queryWithFetch($sql);

foreach($grps as $grp)
{
    echo "Groupe : " . $grp['name'] . " \t id " . $grp['id_groupe'] ." \t facebook_page_id : " . $grp['facebook_page_id'] . "\n";
    $page = $fb->api('/' . $grp['facebook_page_id']);
    if(empty($page)) {
        echo "BUGGGGGGGGGGGGGGGGGGGGGGGG\n";
    } else { 
       //var_dump($page);
       echo "recup page OK\n";
    }
    //$evts = $fb->api('/' . $grp['facebook_page_id'] .'/events?access_token='.$fb->getAccessToken());
    //foreach($evts['data'] as $evt) {
    //    echo "evt : ". $evt['start_time'] . " -> " . $evt['end_time'] . " - " . $evt['name'] . " - " . $evt['location'] . "\n";
    //}
}


