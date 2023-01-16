<?php

namespace App\Http\Livewire\Cs\Partials;

use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegistrationDataTable extends Component
{
    public $heads, $config, $ticket_id, $office_id;

    protected $listeners = ['update'];

    public function mount()
    {
        $this->heads = [
            'Registrasi ID',
            'Nama Depan',
            'Nama Belakang',
            'KTP',
            'No. HP',
            'Rekening',
            'Kota',
            'Email',
            'CIF',
            'Jumlah',
            'RRN',
            'CS',
            'Status',
//            'Action',
        ];

        $this->office_id = Auth::user()->office_id;
        $this->build();
    }

    public function render()
    {
        return view('livewire.cs.partials.registration-data-table');
    }

    private function build()
    {
        $this->config = [
            'data' => $this->buildData(),
            'order' => [[0, 'desc']],
            'columnDefs' => [
            ]
        ];
    }

    private function buildData()
    {
        $result = [];
        foreach ($this->getData() as $item) {
            $result[] = [
                $item->registration_id,
                $item->first_name,
                $item->last_name,
                $item->ktp,
                $item->phone,
                $item->bank_id,
                $item->city,
                $item->email,
                $item->cif,
                $item->quantity,
                $item->rrn,
                $item->cs->name,
                "<span class='badge badge-$item->validation_color'>$item->validation_text</span>",
//                $item->validation ? '' : '<button class="btn btn-warning btn-xs" wire:click="testing(`' . $item->id . '`)">Edit</button>',
            ];
        }

        return $result;
    }

    private function getData()
    {
        return Registration::query()
            ->with('cs.office')
            ->where('ticket_id', $this->ticket_id)
            ->whereOfficeId($this->office_id)
            ->orderBy('id', 'desc')
            ->get();

    }

    public function testing($id)
    {
        $this->emitUp('edit', $id);
    }
}
