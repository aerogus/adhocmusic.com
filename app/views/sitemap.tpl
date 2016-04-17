<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

{foreach from=$groupes item=groupe}
<url>
<loc>/groupes/{$groupe.id}</loc>
</url>
{/foreach}

{foreach from=$lieux item=lieu}
<url>
<loc>/lieux/show/{$lieu.id}</loc>
</url>
{/foreach}

{foreach from=$events item=event}
<url>
<loc>/events/show/{$event.id}</loc>
</url>
{/foreach}

</urlset>
