<?php 
namespace App\Utilities;

use App\Models\User;
use Stripe;

class StripeService
{
    protected $client; 

    public function __construct()
    {
        $stripeSecret = config('services.stripe.secret');
        $this->client = new Stripe\StripeClient($stripeSecret);
    }


    /**
     * Stripe create a customer object 
     * 
     * @return string|null
     */
    public function createCustomer (User $user)
    {
        $customer = $this->client->customers->create([
            'description'   => 'Yummooh stripe customer',
            'email'         => $user->email,
            'name'          => $user->firstname . ' ' . $user->lastname
        ]);

        if (isset($customer['id'])) {
            $user->stripe_customer_token = $customer['id'];
            $user->save();

            return $customer['id'];
        }

        return null;
    }


    public function createCard (User $user, string $cardToken)
    {
        $card = $this->client->customers->createSource($user->stripe_customer_token, [
            'source'    => $cardToken,
        ]);
        
        if (isset($card['id'])) {
            $user->stripe_card_token = $card['id'];
            $user->save();

            return $card['id'];
        }

        return null;
    }
}