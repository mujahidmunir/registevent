<?php

namespace App\Http\Livewire\Admin;

use App\Models\Reconciliation;
use App\Models\Registration;
use Livewire\Component;

class ValidatorPage extends Component
{
    public $config2 = [];
    public $heads = [
        'Registrasi ID',
        'Nama Depan',
        'Nama Belakang',
        'No.HP',
        'KTP',
        'Kota',
        'Alamat',
        ['label' => 'Email', 'width' => 5],
        'RRN',
        'Status',
        'CIF',
        ['label' => 'Jumlah', 'width' => 2],
        ['label' => 'Total', 'width' => 2],
        ['label' => 'Method', 'width' => 5],
        ['label' => 'Digi', 'width' => 2],
        ['label' => 'Digicash', 'width' => 2],
        ['label' => 'CS Nama'],
        ['label' => 'CS Cabang'],
        ['label' => 'CS NIP'],
        ['label' => 'CS Domain Name'],
        ['label' => 'Waktu'],
        ['label' => 'Action'],
    ];

    public $config = [
        'data' => [],
        'order' => [[0, 'desc']],
        'buttons' => [
            'buttons' => [
                [
                    'className' => 'btn-default',
                    'extend' => 'pageLength',
                ],
                [
                    'className' => 'btn-default',
                    'extend' => 'print',
                    'exportOptions' => ['columns' => ':lt(21)'],
                    'text' => '<i class="fas fa-fw fa-lg fa-print"></i>'
                ],
                [
                    'className' => 'btn-default',
                    'extend' => 'csv',
                    'exportOptions' => ['columns' => ':lt(21'],
                    'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>'
                ],
                [
                    'className' => 'btn-default',
                    'extend' => 'excel',
                    'exportOptions' => ['columns' => ':lt(21)'],
                    'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>'
                ],
                [
                    'className' => 'btn-default',
                    'extend' => 'pdf',
                    'exportOptions' => ['columns' => ':lt(21)'],
                    'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>'
                ]
            ],
            'dom' => [
                'button' => [
                    'className' => 'btn'
                ]
            ]
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => 1],
            ['targets' => 3, 'str' => true],
            ['targets' => 4, 'visible' => false, 'str' => true],
            ['targets' => 8, 'str' => true],
            ['targets' => 6, 'visible' => false],
            ['targets' => 14, 'visible' => false],
            ['targets' => 15, 'visible' => false],
//            ['targets' => 15, 'visible' => false],
//            ['targets' => 16, 'visible' => false],
            ['targets' => 16, 'visible' => false],
            ['targets' => 17, 'visible' => false],
        ],

    ];


    public function mount()
    {
        $this->config2 = $this->config;
        $this->buildData(0);
        $this->buildData(1);
    }

    public function render()
    {
        return view('livewire.admin.validator-page');
    }


    private function buildData($status)
    {
        $c = 0;
        $registrations = Registration::query();
        if ($status) {
            $config_name = 'config2';
            $registrations = $registrations->where('validation', '!=', 1);
        } else {
            $config_name = 'config';
            $registrations = $registrations->where('validation', '=', 1);
        }

        $registrations->with('cs.office')->orderBy('id', 'desc')->chunk(1000, function ($registrations) use (&$c, $config_name) {
            foreach ($registrations as $item) {
                $c += 1;
                $status = "<span class='badge badge-" . $item->validation_color . "'>" . $item->validation_text . "</span>";
                if ($item->validation != 1) {
                    $btn = "<button onclick='confirm(`Yakin akan approve data?`) || event.stopImmediatePropagation()' wire:click='approve($item->id,1)' class='btn btn-success btn-xs'>Approve</button>";
                } else {
                    $btn = "<button onclick='confirm(`Yakin akan disapprove data?`) || event.stopImmediatePropagation()' wire:click='approve($item->id,2)' class='btn btn-danger btn-xs'>Disapprove</button>";
                }

                $this->{$config_name}['data'][] = [
                    $item->registration_id,
                    $item->first_name,
                    $item->last_name,
                    $item->phone,
                    $item->ktp,
                    $item->city,
                    $item->address,
                    $item->email,
                    $item->rrn,
                    $status,
                    $item->cif,
                    $item->quantity,
                    $item->quantity * config('app.ticket_price'),
                    $item->payment_method_text,
                    $item->digi ? 'Yes' : 'No',
                    $item->digicash ? 'Yes' : 'No',
                    $item->cs->name,
                    $item->cs->office->name,
                    $item->cs->nip,
                    $item->cs->domain_name,
                    $item->created_at->format('d-m-Y H:i:s'),
                    $btn
                ];
            }
        });
        $this->{$config_name}['pageLength'] = $c;
    }

//    private function buildData2()
//    {
//        $recons = Reconciliation::query()->orderBy('id', 'desc')->toBase()->get();
//        foreach ($recons as $recon) {
//            $valid = "<span class='badge badge-success'>VALID</span>";
//            $invalid = "<span class='badge badge-danger'>INVALID</span>";
//            $this->config2['data'][] = [
//                $recon->name,
//                $recon->amount,
//                $recon->status ? $valid : $invalid,
//                $recon->rrn,
//            ];
//        }
//    }

    public function approve($id, $val)
    {
        Registration::query()->where('id', $id)->update([
            'validation' => $val
        ]);

        return redirect(request()->header('Referer'));
    }

}
