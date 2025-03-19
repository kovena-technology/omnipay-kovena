<?php

namespace Omnipay\Kovena\Message;

use Omnipay\Kovena\Trails\HasBookingParameters;

/**
 *
 * <code>
 *      $gateway = Omnipay::create('Kovena');
 *      $gateway->setApiKey('api_key');
 *
 *      $formData = [
 *          "merchant_id" => 4,
 *          "vault_token" => "c7396277088f6cdc35883",
 *          "amount" => 100,
 *          "currency" => "AUD",
 *          "reference" => "KOVENA_REFERENCE_ID",
 *          "description" => "Kovena Hotel Name",
 *          "is_sending_email" => true,
 *           "booking_info" => [
 *              "booking_date" => "2025-03-01",
 *              "booking_ref" => "KOVENA_BOOKING_REF",
 *              "check_in_date" => "2025-03-02",
 *              "check_out_date" => "2025-03-03",
 *              "customer_name" => "lenonard w cordiner",
 *              "customer_email" => "testing@kovena.com",
 *              "customer_phone" => "string",
 *              "customer_country" => "string",
 *              "surcharge_amount" => 0,
 *              "original_transaction_amount" => 65.71,
 *              "original_transaction_currency" => "USD"
 *          ]
 *      ];
 *      $response = $gateway->purchase($formData)->send();
 *
 *      if ($response->isRedirect()) {
 *          $response->redirect();
 *      } elseif ($response->isSuccessful()) {
 *          $data = $response->getResponseData();
 *      } else {
 *          echo $response->getMessage();
 *      }
 * </code>
 *
 * @package Omnipay\Kovena\Message
 */

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
		$this->validate('amount', 'currency', 'cardReference','reference','description','booking_info');
    	$this->bookingInfoValidate();
    	
		$data = array();
		$data['capture'] = 'true';
		$data['merchant_id'] = $this->getMerchantId();
		$data['amount'] = $this->getAmount();
		$data['currency'] = $this->getCurrency();
		$data['vault_token'] = $this->getCardReference();
		$data['reference'] = $this->getReference();
		$data['description'] = $this->getDescription();
		$data['is_sending_email'] = $this->getIsSendingEmail();

		$data['booking_info'] = $this->getBookingInfo();
		
		return $data;
    }

	public function getEndpoint()
	{
		return $this->getHost().'/charges';
	}

}