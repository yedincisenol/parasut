<?php

include './vendor/autoload.php';

use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\Models\Me;

// Get user's companies example

$isStage = false;
$username = 'email-of-user';
$password = 'password-of-user';
$clientId = 'clientid-from-parasut';
$companyId = 'company-id';
$clientSecret = 'client-secret-from-parasut';

$client = new Client($clientId, $clientSecret, '', $username, $password, $companyId, $isStage);
$client->login();
$user = (new Me($client))->get([
    'include' => 'user_roles,companies,profile'
]);

print_r($user->getIncluded('companies'));