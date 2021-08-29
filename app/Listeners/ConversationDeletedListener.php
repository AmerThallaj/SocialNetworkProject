<?php

namespace App\Listeners;

use App\Events\ConversationDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConversationDeletedListener
{

    /**
     * Handle the event.
     *
     * @param  ConversationDeletedEvent  $event
     * @return void
     */
    public function handle(ConversationDeletedEvent $event)
    {
        foreach($event->conversation->messages as $message){
            $message->delete();
        }
    }
}
