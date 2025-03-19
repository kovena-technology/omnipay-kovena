<?php


namespace Omnipay\Kovena\Message;
use Omnipay\Tests\TestCase;

/**
 * Class AuthorizeRequestTest
 * php /var/www/html/vendor/phpunit/phpunit/phpunit tests/Message/AuthorizeRequestTest.php
 * @package Omnipay\Kovena\Message
 */
class AuthorizeRequestTest extends TestCase
{
	public function setUp()
	{
		$this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
		$this->request->initialize(
			array(
				'amount' => '10.00',
				'currency' => 'USD',
				'cardReference' => 'kovena_vault_token',
				'reference' => 'merchant_ref_001',
				'description' => 'merchant description',
				'booking_info' => [
					'booking_date' => 'booking date',
					'booking_ref' => 'booking ref',
					'check_in_date' => 'check-in date',
					'check_out_date' => 'check-out date',
					'customer_name' => 'customer name',
					'customer_email' => 'customer email',
					'customer_phone' => 'customer phone',
					'customer_country' => 'customer country',
					'surcharge_amount' => 'surcharge amount',
					'original_transaction_amount' => 'original transaction amount',
					'original_transaction_currency' => 'original transaction currency',
				]
			)
		);
	}
	
	public function testCaptureIsFalse()
	{
		$data = $this->request->getData();
		$this->assertSame('false', $data['capture']);
	}

	public function testSendSuccess()
	{
		$this->setMockHttpResponse(['GetAccessTokenSuccess.txt','TransactionSuccess.txt']);
		$response = $this->request->send();

		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('kovena_vault_token', $response->getCardReference());
		$this->assertSame('kovena_transaction_Id', $response->getTransactionReference());
		$this->assertSame('kovena_charge_id', $response->getChargeReference());
		$this->assertNull($response->getMessage());
	}

	public function testSendError()
	{
		$this->setMockHttpResponse(['GetAccessTokenSuccess.txt','TransactionFailure.txt']);
		$response = $this->request->send();

		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('kovena_vault_token', $response->getCardReference());
		$this->assertSame('kovena_transaction_Id', $response->getTransactionReference());
		$this->assertSame('kovena_charge_id', $response->getChargeReference());
		$this->assertSame('Transaction reject by psp', $response->getMessage());
	}
}