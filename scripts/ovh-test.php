#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$ovh = OvhApi::getInstance();


// récupération de l'ensemble des factures
$invoices = $ovh->billingInvoiceList();

$i = array();
foreach($invoices as $invoice) {
    $i[$invoice->billnum] = $invoice->date . "\t" . $invoice->totalPriceWithVat;
}
asort($i);
// affichage des factures par ordre chronologique
foreach($i as $billnum => $bill) {
    echo $billnum . "\t" . $bill . "\n";
}

die();

$domains = $ovh->domainList();
p($domains);

foreach($domains as $domain)
{
    p($ovh->domainInfo($domain));
}


