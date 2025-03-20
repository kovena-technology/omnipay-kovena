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

	public function testCreateCard()
	{
		$request = $this->gateway->createCard(array('description' => 'foo'));

		$this->assertInstanceOf('Omnipay\Kovena\Message\CreateCardRequest', $request);
		$this->assertSame('foo', $request->getDescription());
	}

	public function testAuthorize()
	{
		$request = $this->gateway->authorize(array('amount' => '10.00'));

		$this->assertInstanceOf('Omnipay\Kovena\Message\AuthorizeRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
	}

	public function testCapture()
	{
		$request = $this->gateway->capture(array('amount' => '10.00'));

		$this->assertInstanceOf('Omnipay\Kovena\Message\CaptureRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
	}

	public function testPurchase()
	{
		$request = $this->gateway->purchase(array('amount' => '10.00'));

		$this->assertInstanceOf('Omnipay\Kovena\Message\PurchaseRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
	}

	public function testRefund()
	{
		$request = $this->gateway->refund(array('amount' => '10.00'));

		$this->assertInstanceOf('Omnipay\Kovena\Message\RefundRequest', $request);
		$this->assertSame('10.00', $request->getAmount());
	}

	public function testVoid()
	{
		$request = $this->gateway->void();

		$this->assertInstanceOf('Omnipay\Kovena\Message\VoidRequest', $request);
	}
}