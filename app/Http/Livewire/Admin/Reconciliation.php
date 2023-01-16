<?php

namespace App\Http\Livewire\Admin;

use App\Excel\ReconImport;
use App\Models\Reconciliation as ReconDB;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Reconciliation extends Component
{
    use WithFileUploads;

    public $excel;

//    protected $listeners = ['pop'];

    public function render()
    {
        return view('livewire.admin.reconciliation');
    }

    public function upload()
    {
        $this->validate([
            'excel' => 'file|mimes:xlsx, xls'
        ]);

        $data = Excel::toArray(new ReconImport(), $this->excel);
        $data = $data[0];
        array_splice($data, 0, 3);
        $rrn_list = [];

        try {
            DB::beginTransaction();
            $batch = now()->timestamp;
            foreach ($data as $item) {
                $rrn_list[] = $item[9];
                $rrn = $item[9];
                $amount = $item[10];
                $name = $item[4];
                ReconDB::query()->updateOrCreate(
                    [
                        'rrn' => $rrn,
                    ],
                    [
                        'amount' => $amount,
                        'name' => $name,
                        'batch' => $batch
                    ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }


        $this->emit('update', $batch);
    }

//    public function pop()
//    {
//        dd("asd");
//    }
}
