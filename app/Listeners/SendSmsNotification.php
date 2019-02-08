<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\StripeWebhooks\StripeWebhookCall;
use App\Services\Twilio;

class SendSmsNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StripeWebhookCall $webhookCall)
    {
        $amount = $webhookCall['payload']['data']['object']['amount'] / 100; 

        $phone_number = getenv('PHONE_NUMBER'); //phone number we want to send the text to

        $message = 'Hi, A new Sale of $' .$amount. ' was just recorded in your store';

        $twilio = new Twilio();

        $twilio->send($phone_number, $message);
    }
}
