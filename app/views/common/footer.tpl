
</div>{* .site-content *}

{include file="common/footer-menu.tpl"}

<button type="button" id="up" name="retour en haut de la page">↑</button>

{if isset($script_vars)}
<script>
var asv = {$script_vars|json_encode_numeric_check nofilter}
</script>
{/if}

{if isset($footer_scripts)}
{foreach $footer_scripts as $script_url}
<script src="{$script_url}"></script>
{/foreach}
{/if}

{if isset($inline_scripts)}
{foreach $inline_scripts as $inline_script}
<script>
{$inline_script}
</script>
{/foreach}
{/if}

</body>
</html>
