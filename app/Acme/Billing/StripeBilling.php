<?php
namespace App\Acme\Billing;

use PHPUnit\Runner\Exception;
use Stripe\Stripe;
use Config;
use Stripe\Charge;

class StripeBilling implements BillingInterface{
    public function __construct()
    {
        Stripe::setApiKey(Config::get('stripe.secret_key'));
    }

    public function charge(array $data)
    {
        try{
            return Charge::create([
                'amount'=> $data['amount']*100, //10*100 per 10$
                'currency'=>'GBP',
                'description'=>$data['description'],
                'card'=>$data['token']
            ]);
        }
        catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return 'Rate Limit Error';
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return 'Invalid Request Error';
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            return 'Authentication Error';
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return 'API Connection Error';
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return 'Base Error';
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe

            return 'Payment Failed please try again !';
        }
    }
}
