#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

error_reporting(-1);

/**
 * importe le flux twitter des groupes adhoc
 */

$db = DataBase::getInstance();

// extraction des groupes avec un compte twitter
$sql = "SELECT twitter_id FROM adhoc_groupe WHERE twitter_id <> '' ORDER BY id_groupe ASC";
$grps = $db->queryWithFetchFirstFields($sql);
$grps[] = 'adhocmusic';

var_dump($grps);
die();

foreach($grps as $twitter_id)
{
    echo "--- Import " . $twitter_id . " ---\n";

    //$feed_url = "http://twitter.com/statuses/user_timeline.json?id=".$twitter_id;
    $feed_url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=".$twitter_id.'&count=20';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $feed_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $feed = json_decode(curl_exec($curl));
    curl_close($curl);

    var_dump($feed); die();

    foreach($feed as $item)
    {
        echo $item->id . "\t\t" . $item->id_str . " : " . $item->created_at . " : " . $item->text . "\n";
        $sql = "INSERT INTO `adhoc_groupe_twitter`
                (`id_tweet`, `screen_name`, `created_on`, `imported_on`, `text`)
                VALUES('".$db->escape($item->id)."', '".$db->escape($twitter_id)."', '".$db->escape(date('Y-m-d H:i:s', strtotime($item->created_at)))."', NOW(), '".$db->escape($item->text)."')";
        //echo $sql . "\n";
        try {
            $db->query($sql);
            echo "INSERT OK : " . $item->id . "\n";
        } catch(Exception $e) {
            echo "INSERT KO : " .$item->id . "(déjà saisi ?)\n";
        }
    }
}

