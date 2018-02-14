<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

{foreach $groupes as $groupe}
<url>
<loc>/groupes/{$groupe.id}</loc>
</url>
{/foreach}

{foreach $lieux as $lieu}
<url>
<loc>/lieux/{$lieu.id}</loc>
</url>
{/foreach}

{foreach $events as $event}
<url>
<loc>/events/{$event.id}</loc>
</url>
{/foreach}

</urlset>
