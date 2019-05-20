<?php

namespace App\Listeners;

use App\Events\NewSubscriberEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminViaSlack
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
     * @param  NewSubscriberEvent  $event
     * @return void
     */
    public function handle(NewSubscriberEvent $event)
    {
       // dump("Notify admin via slack");
    }
}
