# Omnipay: Kovena

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `omnipay/kovena` with Composer:

```
composer require league/omnipay:^3 kovena/omnipay-kovena
```
## Basic Usage

The following gateways are provided by this package:

* [Kovena Payment Solutions](https://kovena.com/docs/api/)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

### Kovena Connect

Kovena is an embedded payment gateway service which replaces a traditional merchant facility. 
Accept Visa, Mastercard and Amex while managing fraud with free and customisable 3DS tools. 
Simplify you guest's payment experience today with Kovena.

Enjoy this incredible payment integration with no lock-in contracts or sign-up fees.

Register to place your hotel on our top priority list during our fast-approaching launch.

    * No extra subscription fees
    * Only pay per successful transaction
    * No refund fees, in fact, you receive the original fee back!

Read more on Kovena Payment Solution [here](https://kovena.com/).

## Examples

### Initialize Gateway

```php
use Omnipay\Omnipay;

// Create a gateway for the Kovena Gateway
$gateway = Omnipay::create('Kovena');

// Initialize the gateway
$gateway->initialize([
    'apiKey' => 'your-api-key',
    'merchantId' => 'your-merchant-id',
    'testMode' => true
]);
```

### Authorize a Payment

```php
$response = $gateway->authorize([
    'amount' => '10.00',
    'currency' => 'AUD',
    'cardReference' => 'vault-token',
    'reference' => 'merchant_ref_001',
    'description' => 'Make purchase',
    'booking_info' => [
        'booking_date' => "2025-03-18",
        'booking_ref' => 'merchant_booking_ref_001',
        'check_in_date' => '2025-03-20',
        'check_out_date' => '2025-03-21',
        'customer_name' => 'Customer Name',
        'customer_email' => 'customer@example.com',
        'customer_phone' => '1234567890',
        'customer_country' => 'US',
        'surcharge_amount' => '0',
        'original_transaction_amount' => '10.00',
        'original_transaction_currency' => 'AUD',
    ]
])->send();

if ($response->isSuccessful()) {
    echo "Charge Reference: " . $response->getChargeReference() . "\n";
    echo "Transaction Reference: " . $response->getTransactionReference() . "\n";
}
```

### Capture an Authorized Payment

```php
$response = $gateway->capture([
    'amount' => '10.00',
    'chargeReference' => 'charge-reference-from-authorize',
    'booking_info' => [
        // Include booking information as shown in authorize example
    ]
])->send();
```

### Purchase (Authorize + Capture)

```php
$response = $gateway->purchase([
    'amount' => '10.00',
    'currency' => 'AUD',
    'cardReference' => 'vault-token',
    'reference' => 'merchant_ref_001',
    'description' => 'Make purchase',
    'booking_info' => [
        // Include booking information as shown in authorize example
    ]
])->send();
```

### Refund a Transaction

```php
$response = $gateway->refund([
    'amount' => '10.00',
    'chargeReference' => 'original-charge-reference',
    'transactionReference' => 'original-transaction-reference',
    'booking_info' => [
        // Include booking information as shown in authorize example
    ]
])->send();
```

### Response Handling

```php
if ($response->isSuccessful()) {
    // Transaction was successful
    $chargeReference = $response->getChargeReference();
    $transactionReference = $response->getTransactionReference();
} else {
    // Transaction failed
    echo $response->getMessage();
}
```
## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/),
or better yet, fork the library and submit a pull request.
# omnipay-kovena
