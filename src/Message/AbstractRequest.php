<?php


namespace Omnipay\Kovena\Message;

use Omnipay\Kovena\Trails\HasBookingParameters;
use Omnipay\Kovena\Trails\HasGatewayParameters;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
	use HasGatewayParameters;
	use HasBookingParameters;
	
	protected $liveHost = 'https://gateway.kovena.com/v1';
	protected $testHost = 'https://staging-gateway.kovena.com/v1';


	public function getHost(){
		return $this->getTestMode() ? $this->testHost : $this->liveHost;
	}
	
	abstract public function getEndpoint();
	
    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getHeaders()
    {
        $headers = array();
        $headers['Content-Type'] = 'application/json';

        if($this->getHttpMethod() == 'POST'){
			if ($this->getIdempotencyKeyHeader()) {
				$headers['idempotency-key'] = $this->getIdempotencyKeyHeader();
			}else{
				$headers['idempotency-key'] = $this->generateUUID();
			}
		}
		
		$headers['Authorization'] = 'Bearer '.$this->getAccessTokenHeader();

        return $headers;
    }

	public function sendData($data)
	{
        $headers = $this->getHeaders();
        $endpoint = $this->getEndpoint();
        $method = $this->getHttpMethod();
        $httpResponse = $this->httpClient->request(
            $method,
            $endpoint,
            $headers,
			json_encode($data)
        );
		return $this->createResponse($httpResponse->getBody()->getContents());
	}

	protected function createResponse($data)
	{
		return $this->response = new Response($this, $data);
	}

    public function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
    }

	
}