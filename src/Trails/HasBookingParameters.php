<?php


namespace Omnipay\Kovena\Trails;


use Omnipay\Common\ParametersTrait;
use \Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Kovena\Utils;

trait HasBookingParameters
{
	public function setChargeReference($value){
		return $this->setParameter('chargeReference', $value);
	}

	public function getChargeReference(){
		return $this->getParameter('chargeReference');
	}

	public function setReference($value){
		return $this->setParameter('reference', $value);
	}

	public function getReference(){
		return $this->getParameter('reference');
	}
	
	public function setIsSendingEmail($value){
		return $this->setParameter('is_sending_email', $value);
	}

	public function getIsSendingEmail(){
		$value = $this->getParameter('is_sending_email');
		return is_null($value) ? 1 : $value;
	}
	
	public function getBookingInfo(){
		return $this->getParameter('booking_info');
	}

	public function setBookingInfo($value){
		return $this->setParameter('booking_info', $value);
	}
	
	public function bookingInfoValidate(){
		$requiredParameters = array(
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

		foreach ($requiredParameters as $key => $val) {
			$check = Utils::getData($this->getParameter('booking_info'),$key);
			if (is_null($check)) {
				throw new InvalidRequestException("The $val is required");
			}
		}

	}
	
}