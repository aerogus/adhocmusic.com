<?php

// test api mjml

$user = '0b7f9405-e21a-46ed-bc71-e5ae1b80081f'; // = App ID
$pass = 'cda5e512-82cf-4c9f-b901-f478359d02b7'; // = Secret Key

$mjml = '<mjml><mj-body><mj-container><mj-section><mj-column><mj-text>Hello World</mj-text></mj-column></mj-section></mj-container></mj-body></mjml>';

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://api.mjml.io/v1/render');
curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($c, CURLOPT_USERPWD, "$user:$pass");
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_POST, true); 
curl_setopt($c, CURLOPT_POSTFIELDS, json_encode(['mjml' => $mjml]));

$response = curl_exec($c);

var_dump($response);
// check que $response['error'] est vide
// recup $response['html']

