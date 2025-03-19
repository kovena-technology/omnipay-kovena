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

$chargeReference = '9e757667aa0a48c6b1d2bd39f67fb55b';

// Do a purchase transaction on the gateway
$transaction = $gateway->capture(array(
	'amount' => '10.00',
	'chargeReference' => $chargeReference,
	'booking_info' => array(
		'booking_date' => "2025-03-18",
		'booking_ref' => 'merchant_booking_ref_001',
		'check_in_date' => '2025-03-20',
		'check_out_date' => '2025-03-21',
		'customer_name' => 'Tanya Lynch',
		'customer_email' => 'Quinn.Ziemann@example.org',
		'customer_phone' => '588-427-5593',
		'customer_country' => 'US',
		'surcharge_amount' => '0',
		'original_transaction_amount' => '10.00',
		'original_transaction_currency' => 'AUD',
	)
));

$response = $transaction->send();
$correlationId = $response->getCorrelationId();
echo "Correlation ID: ".$correlationId."\n";

if ($response->isSuccessful()) {
	echo "Capture transaction was successful!\n";
	$charge_id = $response->getChargeReference();
	echo "Charge reference = " . $charge_id . "\n";
	$transaction_id = $response->getTransactionReference();
	echo "Transaction reference = " . $transaction_id . "\n";
}else{
	echo "Error: ".$response->getCode(). " - ". $response->getMessage() . "\n";
}