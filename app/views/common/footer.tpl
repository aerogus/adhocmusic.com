
</div>{* .site-content *}

{include file="common/footer-menu.tpl"}

<button type="button" id="up" name="retour en haut de la page">↑</button>

{if $js_vars}
<script>
{foreach $js_vars as $js_var}
{$js_var}
{/foreach}
</script>
{/if}

{if $script_vars}
<script>
var asv = {$script_vars|json_encode_numeric_check nofilter}
</script>
{/if}

{foreach $footer_scripts as $script_url}
<script src="{$script_url}"></script>
{/foreach}

{foreach $inline_scripts as $inline_script}
<script>
{$inline_script}
</script>
{/foreach}

</body>
</html>
