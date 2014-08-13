{include file="fb/adhocmusic/canvas/common/header.tpl"}

{include file="fb/adhocmusic/canvas/common/boxstart.tpl" title="{$event->getName()}"}

<p>{$event->getDate()}</p>

<p>{$event->getText()|escape}</p>

{include file="fb/adhocmusic/canvas/common/boxend.tpl"}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
