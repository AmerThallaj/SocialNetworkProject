<?php

namespace App\Listeners;

use App\Events\RelationDeletedEvent;
use App\Models\RelationUser;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Queue\InteractsWithQueue;

class RelationDeletedListener
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
    public function handle(RelationDeletedEvent $event)
    {
        $event->conversation->delete();
    }
}
