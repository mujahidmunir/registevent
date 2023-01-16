<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ticket;
use App\Models\Registration;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TicketPage extends Component
{
    use WithPagination;

    public $name, $first_number, $last_number, $quota, $started_at, $ended_at;
    public $max_quantity = 2;
    public $max_ticket = 1;
    public $active = 0;
    public $edit_mode = null;
    public $query = null;

    protected $rules = [
        'name' => 'required',
        'first_number' => 'required',
        'last_number' => 'required',
        'quota' => 'required',
        'max_quantity' => 'required',
        'active' => 'required',
        'started_at' => 'required',
        'ended_at' => 'required',
        'max_ticket' => 'required|gte:1',
    ];

    public function render()
    {
        $q = $this->query;
        $tickets = Ticket::query()
            ->withCount('registrations')
            ->orderBy('id', 'desc');

        if (!empty($this->query)) {
            $tickets = $tickets->where('name', 'like', '%' . $q . '%');
        }

        $tickets = $tickets->paginate(10);

        return view('livewire.admin.ticket-page', [
            'tickets' => $tickets
        ]);
    }

    public function save()
    {
        $this->validate();
        Ticket::query()->updateOrCreate(['id' => $this->edit_mode], [
            'name' => $this->name,
            'first_number' => $this->first_number,
            'last_number' => $this->last_number,
            'quota' => $this->quota,
            'max_quantity' => $this->max_quantity,
            'active' => $this->active,
            'max_ticket' => $this->max_ticket,
            'started_at' => Carbon::createFromFormat("Y-m-d", $this->started_at)->startOfDay(),
            'ended_at' => Carbon::createFromFormat("Y-m-d", $this->ended_at)->endOfDay(),
        ]);

        $this->clear();
        flash('Data tersimpan', 'success');
    }

    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $this->name = $ticket->name;
        $this->first_number = $ticket->first_number;
        $this->last_number = $ticket->last_number;
        $this->quota = $ticket->quota;
        $this->max_quantity = $ticket->max_quantity;
        $this->active = $ticket->active;
        $this->started_at = $ticket->started_at->format('Y-m-d');
        $this->ended_at = $ticket->ended_at->format('Y-m-d');
        $this->edit_mode = $id;
        $this->max_ticket = $ticket->max_ticket;
    }

    public function clear()
    {
        $this->reset();
    }

    public function delete($id)
    {
        Ticket::whereId($id)->delete();
    }

    public function activator($id)
    {
        $current = Ticket::find($id);
        Ticket::query()->update([
            'active' => 0
        ]);
        $current->update([
            'active' => $current->active ? 0 : 1
        ]);
    }

    public function updatedFirstNumber()
    {
        $this->countQuota();
    }

    public function updatedLastNumber()
    {
        $this->countQuota();
    }

    private function countQuota()
    {
        if ($this->first_number && $this->last_number) {
            $this->quota = $this->last_number - $this->first_number + 1;
        }
    }

}
