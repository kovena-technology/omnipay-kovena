<?php


namespace Omnipay\Kovena\Message;
use Omnipay\Tests\TestCase;

/**
 * Class CreateCardRequestTest
 * php /var/www/html/vendor/phpunit/phpunit/phpunit tests/Message/CreateCardRequestTest.php --filter=testDataWithCard
 * @package Omnipay\Kovena\Message
 */
class CreateCardRequestTest extends TestCase
{
	public function setUp()
	{
		$this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest());
		$this->request->setCard($this->getValidCard());
		$this->request->setApiKey('70999ce011ea1892be9ca237f0ee8511');
		$this->request->setTestMode(true);
	}

	public function testCard()
	{
		$this->expectExceptionMessage("The card parameter is required");
		$this->expectException(\Omnipay\Common\Exception\InvalidRequestException::class);
		$this->request->setCard(null);
		$this->request->getData();
	}

	public function testDataWithCard()
	{
		$card = $this->getValidCard();
		$this->request->setCard($card);
		$data = $this->request->getData();

		$this->assertSame($card['number'], $data['card_number']);
	}
	
	public function testSendSuccess()
	{
		$this->setMockHttpResponse(['GetAccessTokenSuccess.txt','CreateCardSuccess.txt']);
		$response = $this->request->send();

		$this->assertTrue($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertSame('19f768fd31b5da3e4397bcb825633e46', $response->getCardReference());
		$this->assertNull($response->getMessage());
	}

	public function testSendFailure()
	{
		$this->setMockHttpResponse(['GetAccessTokenSuccess.txt','CreateCardFailure.txt']);
		$response = $this->request->send();

		$this->assertFalse($response->isSuccessful());
		$this->assertFalse($response->isRedirect());
		$this->assertNull($response->getCardReference());
		$this->assertSame('Tokenization not found.', $response->getMessage());
	}
}