<?php


namespace Omnipay\Kovena\Message;

/**
 * 
 * @package Omnipay\Kovena\Message
 */
class CaptureRequest extends AbstractRequest
{
	public function getEndpoint()
	{
		$this->validate('chargeReference');
		return $this->getHost().'/charges/'.$this->getChargeReference().'/capture';
	}

	public function getData()
	{
		$this->validate('amount', 'booking_info');
		return [
			"amount" => $this->getAmount(),
			"is_sending_email" => $this->getIsSendingEmail(),
			"booking_info" => $this->getBookingInfo(),
		];
	}
}