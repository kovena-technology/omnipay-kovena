<?php


namespace Omnipay\Kovena\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Kovena\Utils;

class Response extends AbstractResponse
{

    protected $request;
    protected $data;
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = json_decode($data,true);
    }

	public function isSuccessful()
	{
		return $this->getAttributeData('success',false);
	}
    
    public function getResponse(){
        return $this->data;
    }
    
    public function getResponseData()
    {
        if($this->isSuccessful()) {
            return $this->getAttributeData('data',[]);
        }
        return null;
    }

	public function getCode()
	{
		return $this->getAttributeData('error',null);
	}
	
    public function getMessage()
    {
    	$message = $this->getAttributeData('friendly_message',null);
    	return empty($message) ? null : $message;
    }
    
    public function getErrorMessage(){
        return $this->getAttributeData('message',null);
    }
    
    public function getSuggestMessage(){
		return $this->getAttributeData('suggestion_action',null);
    }
    
    public function getCorrelationId(){
		return $this->getAttributeData('correlation_id',null);
    }
    
    public function getGatewayError(){
		return $this->getAttributeData('error_gateway_details',null);
    }
    
    public function getCardReference(){
		return $this->getAttributeData('data.vault_token',null);
	}

	public function getTransactionId(){
		return $this->getTransactionReference();
	}
	
	public function getTransactionReference(){
		return $this->getAttributeData('data.transaction_id',null);
	}
	
	public function getChargeReference(){
		return $this->getAttributeData('data.charge_id',null);
	}

	/**
	 * Get an item from an array or object using "dot" notation.
	 *
	 * @param  mixed   $target
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	function getAttributeData( $key, $default = null)
	{
		$target = $this->data;
		return Utils::getData($target,$key, $default);
	}
}