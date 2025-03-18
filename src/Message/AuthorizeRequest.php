<?php


namespace Omnipay\Kovena\Message;

/**
 * @package Omnipay\Kovena\Message
 */
class AuthorizeRequest extends PurchaseRequest
{
    
	public function getData()
	{
		$data = parent::getData();
		$data['capture'] = 'false';
		return $data;
	}
    
}