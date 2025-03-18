<?php


namespace Omnipay\Kovena\Message;

/**
 *
 *
 * @package Omnipay\Kovena\Message
 */
class VoidRequest extends AbstractRequest
{
	public function getEndpoint()
	{
		$this->validate('chargeReference');
		return $this->getHost().'/charges/'.$this->getChargeReference().'/capture';
	}
	
	public function getHttpMethod()
	{
		return 'DELETE';
	}

	public function getData()
	{
		$this->validate( 'booking_info');
		return [
			"is_sending_email" => $this->getIsSendingEmail(),
			"booking_info" => $this->getBookingInfo(),
		];
	}
	
}