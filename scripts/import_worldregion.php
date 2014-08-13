#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

die();

// script d'import de la liste des codes regions dans l'objet WorldRegion
// @see http://www.maxmind.com/app/fips_include

$str = file_get_contents(ADHOC_ROOT_PATH . '/fips_include');
$tab = array();

// extraction
$rows = explode("\n", $str);
foreach($rows as $row) {
    if($row) {
        list($ccode, $rcode, $rlib) = explode(",", $row);
        $tab[$ccode][$rcode] = str_replace('"', '', trim($rlib));
    }
}

// display
echo "array(\n";
foreach($tab as $ccode => $reg) {
    echo "    '".$ccode."' => array(\n";
    foreach($reg as $rcode => $rlib) {
        echo "        '".$rcode."' => \"".$rlib."\",\n";
    }
    echo "    ),\n";
}
echo ");\n";

