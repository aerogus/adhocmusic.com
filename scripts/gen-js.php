#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * génère le js ad'hoc en cache
 */

$smarty = new Smarty();
$smarty->template_dir = SMARTY_TEMPLATE_PATH;
$smarty->compile_dir = SMARTY_TEMPLATE_C_PATH;
$smarty->config_vars['STATIC_URL'] = STATIC_URL;

$js_cache_file = ADHOC_ROOT_PATH . '/www/public/js/adhoc.min.js';
$js_source     = $smarty->fetch('js/index.tpl');
$js_content    = "/* generated by gen-js at " . date('Y-m-d H:i:s') . "*/\n";
$js_content   .= _minify_js($js_source);

file_put_contents($js_cache_file, $js_content);

function _minify_js($js)
{
    $js = trim($js);
    return $js;
}
