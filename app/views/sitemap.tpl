<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

{foreach $groupes as $groupe}
<url>
<loc>{$groupe->getUrl()}</loc>
</url>
{/foreach}

{foreach $lieux as $lieu}
<url>
<loc>{$lieu->getUrl()}</loc>
</url>
{/foreach}

{foreach $events as $event}
<url>
<loc>{$event->getUrl()}</loc>
</url>
{/foreach}

</urlset>
