<?php


namespace Omnipay\Kovena\Trails;

use Omnipay\Kovena\Message\AuthorizeRequest;
use Omnipay\Kovena\Message\CaptureRequest;
use Omnipay\Kovena\Message\CreateCardRequest;
use Omnipay\Kovena\Message\PurchaseRequest;
use Omnipay\Kovena\Message\RefundRequest;
use Omnipay\Kovena\Message\VoidRequest;

/**
 * Trait HasRequests
 * @package Omnipay\Kovena\Trails
 */
trait HasRequests
{

	/**
	 * @inheritdoc
	 * @return CreateCardRequest
	 */
	public function createCard(array $parameters = array())
	{
		return $this->createRequest(
			CreateCardRequest::class, 
			$parameters
		);
	}

	/**
	 * @inheritdoc
	 * @return PurchaseRequest
	 */
	public function purchase(array $parameters = array())
    {
        return $this->createRequest(
        	PurchaseRequest::class, 
			$parameters
		);
    }

	/**
	 * @inheritdoc
	 * @return PurchaseRequest
	 */
	public function authorize(array $parameters = array())
	{
		return $this->createRequest(
			AuthorizeRequest::class,
			$parameters
		);
	}

	/**
	 * @inheritdoc
	 * @return PurchaseRequest
	 */
	public function refund(array $parameters = array())
	{
		return $this->createRequest(
			RefundRequest::class,
			$parameters
		);
	}

	/**
	 * @inheritdoc
	 * @return PurchaseRequest
	 */
	public function capture(array $parameters = array())
	{
		return $this->createRequest(
			CaptureRequest::class,
			$parameters
		);
	}

	/**
	 * @inheritdoc
	 * @return PurchaseRequest
	 */
	public function void(array $parameters = array())
	{
		return $this->createRequest(
			VoidRequest::class,
			$parameters
		);
	}
}