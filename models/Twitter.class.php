<?php

class Twitter
{
    public static function getLastNews($twitter_id, $force_import = false)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_tweet`, `screen_name`, `created_on`, `imported_on`, `text`
                FROM `adhoc_groupe_twitter`
                WHERE `screen_name` = '".$db->escape($twitter_id)."'
                ORDER BY `created_on` DESC
                LIMIT 0, 5";

        $news = $db->queryWithFetch($sql);

        foreach($news as $idx => $n)
        {
            $news[$idx]['parsed_text_1'] = self::makeTextCliquable($n['text'], 1);
            $news[$idx]['parsed_text_2'] = self::makeTextCliquable($n['text'], 2);
        }
        return $news;
    }

    public static function getLastGroupsNews()
    {
      $db = DataBase::getInstance();

      $sql = "SELECT `g`.`id_groupe`, `g`.`name`, `gt`.`id_tweet`, `gt`.`screen_name`, `gt`.`created_on`, `gt`.`imported_on`, `gt`.`text`
              FROM `adhoc_groupe_twitter` `gt`, `adhoc_groupe` `g`
              WHERE `g`.`twitter_id` = `gt`.`screen_name`
              AND `gt`.`screen_name` <> 'adhocmusic'
              GROUP BY `gt`.`screen_name`
              ORDER BY `gt`.`created_on` DESC";

      $news = $db->queryWithFetch($sql);

      foreach($news as $idx => $n)
      {
          $news[$idx]['groupe'] = Groupe::getInstance($n['id_groupe']);
          $news[$idx]['parsed_text_1'] = self::makeTextCliquable($n['text'], 1);
          $news[$idx]['parsed_text_2'] = self::makeTextCliquable($n['text'], 2);
      }

      return $news;
    }

    public static function makeTextCliquable($str, $mode = 2)
    {
        $regexp_url = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

        if(preg_match($regexp_url, $str, $url)) {
            if($mode == 1) {
                // seul le lien est cliquable
                $output = preg_replace($regexp_url, '<a href="'.$url[0].'">'.$url[0].'</a>', $str);
            } elseif($mode == 2) {
                // l'ensemble du texte est cliquable, l'url est cachée
                $str = str_replace($url[0], '', $str);
                $output = '<a href="'.$url[0].'">'.$str.'</a>';
            }
        } else {
            // pas de lien trouvé
            $output = $str;
        }

        return trim($output);
    }
}
