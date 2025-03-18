<?php

namespace Omnipay\Kovena;


use Omnipay\Kovena\Trails\HasGatewayParameters;
use Omnipay\Kovena\Trails\HasRequests;

/**
 * Kovena Class
 *
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class Gateway extends \Omnipay\Common\AbstractGateway
{
	use HasRequests;
	use HasGatewayParameters;
	
	public function getName()
	{
		return 'Kovena';
	}

	/**
	 * @return array
	 */
	public function getDefaultParameters()
	{
		return [
			'apiKey'    => null,
			'merchantId'    => null,
			'testMode'      => true,
		];
	}
}