<?php


namespace Omnipay\Kovena\Message;


/**
 *
 *
 * @package Omnipay\Kovena\Message
 */
class RefundRequest extends AbstractRequest
{

	public function getEndpoint()
	{
		$this->validate('chargeReference','transactionReference');
		return $this->getHost().'/charges/'.$this->getChargeReference().'/refunds/'.$this->getTransactionReference();
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