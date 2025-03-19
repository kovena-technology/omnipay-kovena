<?php


namespace Omnipay\Kovena\Message;
use Omnipay\Common\Exception\InvalidRequestException;
/**
 * Kovena Create Credit Card Request.
 *
 *
 * ### Example
 *
 * <code>
 *   // Create a credit card object
 *   // This card can be used for testing.
 *   // The CreditCard object is also used for creating customers.
 *   $new_card = new CreditCard(array(
 *               'firstName'    => 'Example',
 *               'lastName'     => 'Customer',
 *               'number'       => '4111111111111111',
 *               'expiryMonth'  => '12',
 *               'expiryYear'   => '2030',
 *               'cvv'          => '123',
 *               'email'        => 'customer@example.com',
 *   ));
 *
 *   // Do a create card transaction on the gateway
 *   $response = $gateway->createCard(array(
 *       'card'              => $new_card,
 *   ))->send();
 *   if ($response->isSuccessful()) {
 *       echo "Gateway createCard was successful.\n";
 *       // Find the card ID
 *       $kovena_vault_token = $response->getCardReference();
 *       echo "kovena vault token = " . $kovena_vault_token . "\n";
 *   }
 * </code>
 *
 * @see CreateCustomerRequest
 */
class CreateCardRequest extends AbstractRequest
{
	public function getData()
	{
		$this->validate('card');
		$card = $this->getCard();
		$card->validate();
		$cvv = $card->getCvv();
		$data = array();
		
		$data['card_number'] = $card->getNumber();
		if (!empty($cvv)) {
			$data['cvc'] = $cvv;
		}
		$data['expire_month'] = $card->getExpiryMonth();
		$data['expire_year'] = $card->getExpiryYear();
		$data['card_name'] = $card->getName();
		
		return $data;
	}

	public function getEndpoint()
	{
		return $this->getHost().'/vault';
	}
}