#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../config.php';

Email::send(
    'guillaume.seznec@gmail.com',
    "Concert Reggae/Chanson à Epinay-sur-Orge",
    'test',
    array()
);

