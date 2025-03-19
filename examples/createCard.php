<?php


require_once __DIR__.'/../vendor/autoload.php';

use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;

// Create a gateway for the Kovena Gateway
// (routes to GatewayFactory::create)
$gateway = Omnipay::create('Kovena');

// Initialise the gateway
$gateway->initialize(array(
	'apiKey' => '70999ce011ea1892be9ca237f0ee8511',
	'testMode' => true
));

$new_card = new CreditCard(array(
			'firstName'    => 'Example',
			'lastName'     => 'Customer',
			'number'       => '4111111111111111',
			'expiryMonth'  => '12',
			'expiryYear'   => '2030',
			'cvv'          => '123',
			'email'        => 'customer@example.com',
));

// Do a create card transaction on the gateway
$response = $gateway->createCard(array(
	'card'              => $new_card,
))->send();

$correlationId = $response->getCorrelationId();
echo "Correlation ID: ".$correlationId;

if ($response->isSuccessful()) {
   echo "Gateway createCard was successful.\n";
   // Find the card ID
   $kovena_vault_token = $response->getCardReference();
   echo "kovena vault token = " . $kovena_vault_token . "\n";
}