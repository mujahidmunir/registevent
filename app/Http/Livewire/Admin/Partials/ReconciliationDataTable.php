<?php

namespace App\Http\Livewire\Admin\Partials;

use App\Models\Reconciliation;
use App\Models\Registration;
use Livewire\Component;

class ReconciliationDataTable extends Component
{
    public $start, $end, $config, $config2;
    public $valid_ids = [];
    public $valid_rrn = [];
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
        'CIF',
        ['label' => 'Jumlah', 'width' => 2],
        ['label' => 'Method', 'width' => 5],
        ['label' => 'Digi', 'width' => 2],
        ['label' => 'Digicash', 'width' => 2],
        ['label' => 'CS Nama'],
        ['label' => 'CS Divisi'],
        ['label' => 'CS NIP'],
        ['label' => 'CS Domain Name'],
        ['label' => 'Waktu'],
    ];

    public $heads2 = [
        'Nama',
        'Jumlah Pembayaran',
        'RRN'
    ];
    protected $listeners = ['update'];

    public function mount()
    {
        $this->mountConfig();
    }

    public function render()
    {
        return view('livewire.admin.partials.reconciliation-data-table');
    }

    public function update($batch)
    {
        $recs = Reconciliation::query()->where('batch', $batch)->toBase()->pluck('amount', 'rrn')->toArray();
        $ids = array_keys($recs);

        $data = Registration::query()
            ->where('validation', 0)
            ->with('cs.office')
            ->whereIn('rrn', $ids)
            ->get();


        if (!$data) {
            $this->emit('pop', 'error', 'Tidak ada data valid');
        } else {
            $data = $this->buildData($data, $ids, $recs);
            $valid = $data[0];
            $notValid = $data[1];
            if (count($valid)) {
                $this->emit('pop', 'success', "Ditemukan " . count($valid) . " data valid");
            } else {
                $this->emit('pop', 'error', "Tidak ditemukan data valid");
            }


            $this->emit('updateDataTable', $valid);
            $this->emit('updateDataTable2', $notValid);
        }

    }

    private function mountConfig()
    {
        $this->config = [
            'data' => [],
            'order' => [[0, 'desc']],
            'columnDefs' => [
                ['orderable' => false, 'targets' => 1],
                ['targets' => 2, 'str' => true],
                ['targets' => 3, 'visible' => false, 'str' => true],
                ['targets' => 4, 'visible' => false, 'str' => true],
                ['targets' => 5, 'visible' => false],
                ['targets' => 11, 'visible' => false],
                ['targets' => 12, 'visible' => false],
                ['targets' => 13, 'visible' => false],
                ['targets' => 14, 'visible' => false],
                ['targets' => 15, 'visible' => false],
                ['targets' => 16, 'visible' => false],
            ],
        ];

        $this->config2 = [
            'data' => [],
        ];
    }

    private function buildData($data, $rrns, $recs)
    {
        $valids = [];
        $notValids = [];
        $this->valid_ids = [];
        $valid_rrn = [];

        foreach ($data as $item) {
//            $rrns = array_values(array_filter($rrns, fn($m) => $m != $item->rrn));
            $jml = str_replace(".", "", $recs[$item->rrn]);
            if ($jml != (config('app.ticket_price') * $item->quantity)) continue;
            $this->valid_ids[] = $item->id;
            $valid_rrn[] = $item->rrn;
            $this->valid_rrn[] = $item->rrn;
            $valids[] = [
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
                $item->created_at->format('d-m-Y H:i:s'),
            ];
        }

        $recons = Reconciliation::query()->whereIn('rrn', array_diff($rrns, $valid_rrn))->toBase()->get();
        foreach ($recons as $recon) {
            $notValids[] = [
                $recon->name,
                $recon->amount,
                $recon->rrn,
            ];
        }

        return [
            $valids,
            $notValids
        ];
    }

    public function sync()
    {
        Registration::query()->whereIn('id', $this->valid_ids)->where('validation', 0)->update([
            'validation' => 1
        ]);

        Registration::query()->where('validation', 0)->update([
            'validation' => 2
        ]);

        Reconciliation::query()->whereIn('rrn', $this->valid_rrn)->update(['status' => 1]);
        Reconciliation::query()->where('status', 0)->update(['status' => 2]);
        flash("Data tersimpan", 'success');
        return redirect(request()->header('Referer'));
    }

}
