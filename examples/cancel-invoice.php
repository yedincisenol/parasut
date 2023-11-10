<?php

include './vendor/autoload.php';

use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\Models\SaleInvoice;

// Get user's companies example

$isStage = false;
$username = 'email-of-user';
$password = 'password-of-user';
$clientId = 'clientid-from-parasut';
$companyId = 'company-id';
$clientSecret = 'client-secret-from-parasut';
$invoiceId = 'invoice-id';

$client = new Client($clientId, $clientSecret, '', $username, $password, $companyId, $isStage);
$client->login();
$invoiceCancelled = (new SaleInvoice($client))->cancelInvoice($invoiceId);

print_r($invoiceCancelled);