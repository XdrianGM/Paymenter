<?php

namespace App\Observers;

use App\Events\Ticket\TicketMessageCreated;
use App\Models\TicketMessage;

class TicketMessageObserver
{
    /**
     * Handle the TicketMessage "created" event.
     *
     * @return void
     */
    public function created(TicketMessage $ticketMessage)
    {
        event(new TicketMessageCreated($ticketMessage));
    }

    /**
     * Handle the TicketMessage "updated" event.
     *
     * @return void
     */
    public function updated(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Handle the TicketMessage "deleted" event.
     *
     * @return void
     */
    public function deleted(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Handle the TicketMessage "restored" event.
     *
     * @return void
     */
    public function restored(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Handle the TicketMessage "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(TicketMessage $ticketMessage)
    {
        //
    }
}
