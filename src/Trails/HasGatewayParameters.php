<?php


namespace Omnipay\Kovena\Trails;


use Omnipay\Kovena\Gateway;
use Omnipay\Kovena\Message\AbstractRequest;
use Omnipay\Kovena\Message\Response;

trait HasGatewayParameters
{

	/**
	 * Get the gateway API Key.
	 *
	 * Authentication is by means of a single secret API key set as
	 * the apiKey parameter when creating the gateway object.
	 *
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->getParameter('apiKey');
	}
	
	/**
	 * Set the gateway API Key.
	 *
	 * Authentication is by means of a single secret API key set as
	 * the apiKey parameter when creating the gateway object.
	 *
	 * @param string $value
	 *
	 * @return Gateway
	 */
	public function setApiKey($value)
	{
        $this->getAccessToken();
		return $this->setParameter('apiKey', $value);
	}

	/**
	 * Connect only
	 *
	 * @return mixed
	 */
	public function getIdempotencyKeyHeader()
	{
		return $this->getParameter('idempotencyKey');
	}

	/**
	 * @param string $value
	 *
	 * @return AbstractRequest
	 */
	public function setIdempotencyKeyHeader($value)
	{
		return $this->setParameter('idempotencyKey', $value);
	}

	/**
	 * Connect only
	 *
	 * @return mixed
	 */
	public function getAccessTokenHeader()
	{
		$accessToken = $this->getParameter('accessToken');
		if(!$accessToken){
			$accessToken = $this->reNewAccessToken();
			$this->setAccessTokenHeader($accessToken);
		}
		return $accessToken;
	}

	/**
	 * @param string $value
	 *
	 * @return AbstractRequest
	 */
	public function setAccessTokenHeader($value)
	{
		return $this->setParameter('accessToken', $value);
	}
	
	/**
	 * @param $value
	 * @return $this
	 */
	public function setMerchantId($value)
	{
		return $this->setParameter('merchantId', $value);
	}

	/**
	 * get the merchant id
	 *
	 * @return string
	 */
	public function getMerchantId()
	{
		return  $this->getParameter('merchantId');
	}
    
    public function setAccessToken($value){
        return $this->setParameter('accessToken', $value);
    }
    public function getAccessToken(){
        return $this->getParameter('accessToken');
    }

	public function reNewAccessToken(){
		$headers = [
			'Content-Type' => 'application/json',
			'x-user-secret-key' => $this->getApiKey()
		];
		$httpResponse = $this->httpClient->request(
			'GET',
			$this->getHost().'/token',
			$headers
		);
		$response = $httpResponse->getBody()->getContents();
		$responseParsed = json_decode($response,true);
		return $responseParsed['data']['access_token'];
	}
}