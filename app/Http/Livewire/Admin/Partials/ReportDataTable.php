<?php

namespace App\Http\Livewire\Admin\Partials;

use App\Models\Registration;
use Carbon\Carbon;
use Livewire\Component;

class ReportDataTable extends Component
{
    public $heads, $config, $ticket_id, $start, $end;

    protected $listeners = ['update'];

    public function mount()
    {
        $this->heads = [
            'Registrasi ID',
            'Nama Depan',
            'Nama Belakang',
            'No.HP',
            'KTP',
            'Kota',
            'Alamat',
            ['label' => 'Email', 'width' => 5],
            'RRN',
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
            ['label' => 'Status'],
            ['label' => 'Waktu'],
        ];

        $this->build();
    }

    public function render()
    {
        return view('livewire.admin.partials.report-data-table');
    }

    public function update($ticket_id, $start, $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->ticket_id = $ticket_id;
        $data = $this->buildData();
        $this->emit('updateDataTable', $data);
    }

    private function build()
    {
        $this->config = [
            'data' => $this->buildData(),
            'order' => [[0, 'desc']],
            'columnDefs' => [
                ['orderable' => false, 'targets' => 1],
                ['targets' => 3, 'str' => true],
                ['targets' => 4, 'visible' => false, 'str' => true],
                ['targets' => 5, 'visible' => false],
                ['targets' => 13, 'visible' => false],
                ['targets' => 14, 'visible' => false],
                ['targets' => 15],
                ['targets' => 16],
                ['targets' => 17, 'visible' => false],
                ['targets' => 18, 'visible' => false],
            ],
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
                $item->phone,
                $item->ktp,
                $item->city,
                $item->address,
                $item->email,
                $item->rrn,
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
                "<span class='badge badge-$item->validation_color'>$item->validation_text</span>",
                $item->created_at->format('d-m-Y H:i:s'),
            ];
        }

        return $result;
    }

    private function getData()
    {
        $data = Registration::query()
            ->with('cs.office')
            ->where('ticket_id', $this->ticket_id)
            ->orderBy('id', 'desc');

        $date1 = null;
        $date2 = null;

        if ($this->start) {
            $date1 = Carbon::createFromFormat('Y-m-d', $this->start)->startOfDay();
        }

        if ($this->end) {
            $date2 = Carbon::createFromFormat('Y-m-d', $this->end)->endOfDay();
        }

        if ($date1 && $date2) {
            $data = $data->whereBetween('created_at', [$date1, $date2]);
        } else {
            if ($date1) {
                $data = $data->whereBetween('created_at', [$date1, now()]);
            }

            if ($date2) {
                $data = $data->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', '2022-01-01'), $date2]);
            }
        }
        return $data->get();
    }
}
