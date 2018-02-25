{if !empty($unknown_newsletter)}

<p class="infobulle error">Cette newsletter est introuvable !</p>

{else}

{$newsletter->getHtml()}

{/if} {* test unknown newsletter *}

