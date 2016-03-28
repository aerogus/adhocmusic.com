#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/common-cli.inc.php';

Email::send(
    'guillaume.seznec@gmail.com',
    "Concert Reggae/Chanson à Epinay-sur-Orge",
    'test',
    array()
);

