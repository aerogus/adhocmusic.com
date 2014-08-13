<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>

    <title>AD'HOC Music - News</title>
    <language>fr-fr</language>
    <link>http://www.adhocmusic.com</link>
    <description>Toutes les dernières news de l'association AD'HOC</description>
    <atom:link href="http://www.adhocmusic.com/rss/news.rss" rel="self" type="application/rss+xml" />

    {foreach from=$newslist item=news}
    <item>
      <title>{$news.title|escape}</title>
      <link>{$news.url}</link>
      <guid isPermaLink="true">http://www.adhocmusic.com/news/{$news.id|escape}</guid>
      <description>{$news.text|@strip_tags|truncate:300|escape}</description>
      <pubDate>{$news.created_on|date_format:'%a, %d %b %Y %H:%M:%S %z'}</pubDate>
    </item>
    {/foreach}

  </channel>
</rss>
