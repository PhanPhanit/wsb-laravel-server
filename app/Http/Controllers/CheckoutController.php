<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;

class CheckoutController extends Controller
{
    private function calculateOrderAmount($price) : int
    {
        return (float) $price * 100;
    }
    public function createPaymentIntent(Request $request)
    {
        if(!$request->filled('price')){
            return response([
                'message' => 'Field price require!'
            ], 400);
        }
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try{
            // Alternatively, set up a webhook to listen for the payment_intent.succeeded event
            // and attach the PaymentMethod to a new Customer
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->create();
            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'customer' => $customer->id,
                'amount' => $this->calculateOrderAmount($request->input('price')),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
            return response([
                'clientSecret' => $paymentIntent->client_secret
            ], 200);
        }catch (Error $e) {
            return response([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
