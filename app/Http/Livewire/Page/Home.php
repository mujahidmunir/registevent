<?php

namespace App\Http\Livewire\Page;

use App\Models\Registration;
use App\Models\Ticket;
use Livewire\Component;

class Home extends Component
{
    public $time;
    public $remaining_ticket = 'loading...';

    public function mount()
    {
        $ticket = Ticket::query()
            ->withSum('registrations', 'quantity')
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->first();

        if ($ticket) {
            $this->remaining_ticket = $ticket->quota - $ticket->registrations_sum_quantity;
            $this->time = $ticket->ended_at->format('F d, Y H:i:s');
        } else {
            $this->remaining_ticket = 0;
            $this->time = 'Jan 1, 2000 00:00:01';
        }
    }

    public function render()
    {
        return view('livewire.page.home')->layout('layout.home');
    }
}
