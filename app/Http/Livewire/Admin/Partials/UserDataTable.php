<?php

namespace App\Http\Livewire\Admin\Partials;

use App\Models\User;
use Livewire\Component;

class UserDataTable extends Component
{
    protected $listeners = ['refresh' => '$refresh', 'updateData'];
    public $config;
    public $heads = [
        '#',
        'Nama',
        'Domain',
        'NIP',
        'Cabang',
        'No. HP',
        'Email',
        'Role',
        'Action',
    ];

    public function updateData()
    {
        $data = $this->getData();
        $this->emit('updateDataTable', $data);
    }

    public function render()
    {
        return view('livewire.admin.partials.user-data-table');
    }

    public function mount()
    {
        $this->build();
    }

    public function build()
    {
        $data = $this->getData();
        $this->config = [
            'data' => $data,
            'order' => [[0, 'desc']],
            'pageLength' => count($data)
        ];
    }

    private function getData()
    {
        $res = [];
        $users = User::query()
            ->active()
            ->with('office')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($users as $i => $user) {
            $edit = '<button class="btn btn-warning btn-sm" wire:keyt="tt' . $i . '" wire:click="$emit(`edit`, ' . $user->id . ')">edit</button>';
            $delete = '<button class="btn btn-danger btn-sm" onclick="confirm(`Konfirmasi! Apakah anda akan menghapus data?`) || event.stopImmediatePropagation()" wire:click="$emit(`delete`, ' . $user->id . ')">delete</button>';
            $res[] = [
                $i + 1,
                $user->name,
                $user->domain_name,
                $user->nip,
                $user->office->name,
                $user->phone,
                $user->email,
                $user->is_admin ? 'Admin' : 'CS',
                "$edit $delete"
            ];
        }

        return $res;
    }
}
