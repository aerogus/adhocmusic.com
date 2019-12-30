{if !empty($unknown_newsletter)}
newsletter introuvable
{else}
{$newsletter->getHtml()}
{/if}

