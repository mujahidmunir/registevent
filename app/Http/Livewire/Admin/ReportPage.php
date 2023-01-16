<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ticket;
use Livewire\Component;

class ReportPage extends Component
{

    public $tickets, $ticket_id, $start, $end;

    public function mount()
    {
        $this->tickets = Ticket::query()
            ->selectRaw("id, CONCAT(name, CASE WHEN active > 0 THEN ' (active)' ELSE ' (inactive)' END) as name")
            ->orderBy('id', 'desc')
            ->pluck('name', 'id')
            ->toArray();
        if (count($this->tickets)) {
            $this->ticket_id = Ticket::whereActive(1)->orderBy('id', 'desc')->toBase()->first()->id;
        }
    }

    public function updatedTicketId()
    {
        $this->updateData();
    }

    public function updatedStart($d)
    {
        $this->updateData();
    }

    public function updatedEnd()
    {
        $this->updateData();
    }

    private function updateData()
    {
        $this->emit('update', $this->ticket_id, $this->start, $this->end);
    }

    public function render()
    {
        return view('livewire.admin.report-page');
    }

    public function clearDate($val)
    {
        $this->reset($val);
        $this->updateData();
    }
}
