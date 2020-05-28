<?php
namespace App\Acme\Billing;


use PHPUnit\Runner\Exception;
use Stripe\Stripe;

use Stripe\Charge;

class StripeBilling implements BillingInterface{
    public function __construct()
    {
        Stripe::setApiKey( \config('stripe.secret_key'));
    }

    public function charge(array $data)
    {
        try {
            try {
                $token = \Stripe\Token::create(array(
                    "card" => array(
                        "number" => $data['number'],
                        "exp_month" => $data['exp_month'],
                        "exp_year" => $data['exp_year'],
                        "cvc" => $data['cvc']
                    )
                ));

            } catch (\Stripe\Exception\CardException $e) {
                return $e->getMessage();
            }

            if(auth()->check()){
                $user = auth()->user();
            }else{
                $user = auth()->guard('api')->user();
            }

            // Create a Customer:
            $customer = \Stripe\Customer::create([
                'source' => $token,
                'email' => $user->email,
            ]);


            return \Stripe\Charge::create(array(
                "amount" => $data['amount'] * 100,
                "currency" => "aud",
                'customer' => $customer->id,
            ));
        } catch (\Stripe\Error\InvalidRequest $e) {
            return $e->getMessage();
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {
            return $e->getMessage();
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {
            return $e->getMessage();
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {
            return $e->getMessage();
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            return $e->getMessage();
            // Something else happened, completely unrelated to Stripe
        }


//        try{
//            return Charge::create([
//                'amount'=> $data['amount']*100, //10*100 per 10$
//                'currency'=>'GBP',
//                'description'=>$data['description'],
//                'source'=>$data['token']
//            ]);
//        }
//        catch (\Stripe\Error\RateLimit $e) {
//            // Too many requests made to the API too quickly
//            return 'Rate Limit Error';
//        } catch (\Stripe\Error\InvalidRequest $e) {
//            // Invalid parameters were supplied to Stripe's API
//            return 'Invalid Request Error';
//        } catch (\Stripe\Error\Authentication $e) {
//            // Authentication with Stripe's API failed
//            return 'Authentication Error';
//            // (maybe you changed API keys recently)
//        } catch (\Stripe\Error\ApiConnection $e) {
//            // Network communication with Stripe failed
//            return 'API Connection Error';
//        } catch (\Stripe\Error\Base $e) {
//            // Display a very generic error to the user, and maybe send
//            // yourself an email
//            return 'Base Error';
//        } catch (Exception $e) {
//            // Something else happened, completely unrelated to Stripe
//
//            return 'Payment Failed please try again !';
//        }
    }
}
