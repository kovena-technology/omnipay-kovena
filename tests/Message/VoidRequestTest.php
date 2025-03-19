<?php


namespace Omnipay\Kovena\Message;
use Omnipay\Tests\TestCase;

/**
 * Class VoidRequestTest
 * php /var/www/html/vendor/phpunit/phpunit/phpunit tests/Message/RefundRequestTest.php
 * @package Omnipay\Kovena\Message
 */
class VoidRequestTest extends TestCase
{
	public function setUp()
	{
		$this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
		$this->request->initialize(
			array(
				'amount' => '10.00',
				'chargeReference' => 'chargeReference',
				'transactionReference' => 'transactionReference',
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
			)
		);
	}

	public function testChargeReferenceRequired()
	{
		$this->expectExceptionMessage("The chargeReference parameter is required");
		$this->expectException(\Omnipay\Common\Exception\InvalidRequestException::class);
		$this->request->setChargeReference(null);
		$this->request->getEndpoint();
	}

	public function testEndpoint()
	{
		$this->request->setChargeReference('chargeId');
		$endpoint = $this->request->getEndpoint();
		$this->assertContains('/charges/chargeId/capture',$endpoint);
	}

	public function testBookingInfo()
	{
		$this->expectExceptionMessage("The booking_info parameter is required");
		$this->expectException(\Omnipay\Common\Exception\InvalidRequestException::class);
		$this->request->setBookingInfo(null);
		$this->request->getData();
	}

	public function testDataWithBookingInfo()
	{
		$bookingInfo = array(
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
		);
		$this->request->setBookingInfo($bookingInfo);
		$data = $this->request->getData();

		$this->assertSame($bookingInfo['booking_date'], $data['booking_info']['booking_date']);
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