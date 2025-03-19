<?php


namespace Omnipay\Kovena;
use Omnipay\Tests\GatewayTestCase;
use Omnipay\Omnipay;

/**
 * php /var/www/html/vendor/phpunit/phpunit/phpunit tests/GatewayTest.php --filter=testFlow
 */
class GatewayTest extends GatewayTestCase
{
	/**
	 * @var Gateway
	 */
	protected $gateway;

	/**
	 * @var array
	 */
	protected $options;
	
	public function setUp()
	{
		parent::setUp();

		$this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

		$this->options = [
			'testMode' => true,
		];
	}

	public function testCreateToken()
	{
		$request = $this->gateway->createToken(array('customer' => 'cus_foo'));

		$this->assertInstanceOf('Omnipay\Stripe\Message\CreateTokenRequest', $request);
		$params = $request->getParameters();
		$this->assertSame('cus_foo', $params['customer']);
	}

	
	
	public function testFlow()
	{
		$gateway = Omnipay::create('Kovena');
		$gateway->setApiKey('kovena_secret_key');

        $params = [
            "card_number" => 4111111111111111,
            "card_ccv" => 123,
            "expire_month" => 12,
            "expire_year" => 2030,
            "card_name" => "card holder name",
        ];
        $tokenize = $gateway->tokenize($params)->send();
        $tokenData = $tokenize->getResponseData();
        $vaultToken = $tokenData->vault_token;
//        $vaultToken = "dc829200ef6fcbe13ad3dee0ee2";

		$formData = [
            "merchant_id" => 4,
            "vault_token" => $vaultToken,
            "amount" => 10,
            "currency" => "AUD",
            "reference" => "KOVENA_REFERENCE_ID",
            "description" => "Kovena Hotel Name",
            "is_sending_email" => true,
            "booking_info" => [
                "booking_date" => "2025-03-01",
                "booking_ref" => "KOVENA_BOOKING_REF",
                "check_in_date" => "2025-03-02",
                "check_out_date" => "2025-03-03",
                "customer_name" => "lenonard w cordiner",
                "customer_email" => "testing@kovena.com",
                "customer_phone" => "string",
                "customer_country" => "string",
                "surcharge_amount" => 0,
                "original_transaction_amount" => 65.71,
                "original_transaction_currency" => "USD"
            ],
//            'charge_id' => '9e597b1bf4be2d6f8b3a2275ed',
//            'transaction_id' => '9e597b469c5581a2a6117ab72'
        ];
		$response = $gateway->purchase($formData)->send();

		if ($response->isRedirect()) {
			$response->redirect();
		} elseif ($response->isSuccessful()) {
			$data = $response->getResponseData();  //to get response data
//            $data = $response->getResponse(); // to get full response
		} else {
			echo $response->getMessage(); // to get Friendly message
//			echo $response->getErrorMessage(); // to get Error message
//			echo $response->getSuggestMessage(); // to get suggestion action
		}
	}
    
}