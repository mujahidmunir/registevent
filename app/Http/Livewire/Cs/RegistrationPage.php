<?php

namespace App\Http\Livewire\Cs;

use App\Models\Registration;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class RegistrationPage extends Component
{
    use WithPagination;

    public $ended_at, $cif, $phone, $bank_id, $address, $city, $reg_id, $first_name, $last_name, $ktp, $rrn, $ticket, $email, $digi, $digicash, $method, $office_id, $sold, $popup;
    public $quantity = 1;
    public $duplicate_cif = false;
    public $duplicate_phone = false;
    public $error_max = false;
    public $edit_mode = null;
    public $query = null;
    public $available = true;
    protected $listeners = ['refresh' => '$refresh', 'edit'];

    protected $rules = [
        'cif' => 'required|max:6|min:6',
        'phone' => 'required|digits_between:10,15|numeric',
        'bank_id' => 'required|numeric|digits_between:13,13',
        'address' => 'required|min:5',
        'city' => 'required:min:3',
        'first_name' => 'required',
        'last_name' => 'required',
        'ktp' => 'required',
        'rrn' => 'required|min:12|max:12|unique:registrations,rrn|gt:0',
        'email' => 'required|email',
        'method' => 'required',
        'digi' => 'accepted',
        'digicash' => 'accepted',
    ];

    public function mount()
    {
        $this->popup = Session::get('popup');
        Session::put('popup', false);
        $ticket = Ticket::query()->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        $this->ended_at = $ticket->ended_at->timestamp;
        $this->ticket = $ticket->toArray();
        $this->countSold();
        $this->reg_id = $this->getCode();
        $this->office_id = Auth::user()->office_id;
        $this->rules['quantity'] = 'required|numeric|digits_between:1,' . $this->ticket['max_ticket'];
    }

    public function render()
    {
        return view('livewire.cs.registration-page', [
            'available' => $this->checkAvailable()
        ]);
    }

    public function save()
    {
        if ($this->edit_mode) {
            $this->rules['rrn'] = 'required|min:12|max:12|gt:0|unique:registrations,rrn,' . $this->edit_mode;
        }

        $expired = Carbon::createFromTimestamp($this->ended_at)->lt(now());

        if($expired){
            dd("EXPIRED");
        }

        $this->validate();

        $values = [
            'ticket_id' => $this->ticket['id'],
            'cif' => $this->cif,
            'phone' => $this->phone,
            'bank_id' => $this->bank_id,
            'address' => $this->address,
            'city' => $this->city,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'ktp' => $this->ktp,
            'rrn' => $this->rrn,
            'email' => $this->email,
            'cs_id' => Auth::id(),
            'digi' => 1,
            'digicash' => 1,
            'quantity' => $this->quantity,
            'office_id' => $this->office_id,
            'payment_method' => $this->method
        ];

        //todo: jika tiket masih tersedia
        if ($this->checkAvailable()) {
            //todo: jika tidak duplicate
            if (!$this->edit_mode) {
                $this->countDuplicate('cif');
                $this->countDuplicate('phone');

                if ($this->duplicate_phone || $this->duplicate_cif) {
                    $this->emit('afterSaving', false, 'DUPLIKAT CIF/NO.HP');
                    return;
                }
            }

            if (!$this->edit_mode) {
                $values['registration_id'] = $this->getCode();
            }

            try {
                Registration::query()->updateOrCreate(['id' => $this->edit_mode], $values);
                $this->clear();
//                $this->emit('afterSaving', true);
                return redirect(request()->header('Referer'));
            } catch (\Exception $exception) {
                $this->emit('afterSaving', false, $exception->getMessage());
            }
        } else {
            $this->emit('afterSaving', false, 'TIKET HABIS');
        }

        $this->countSold();
        $this->emit('refresh');
    }

    public function edit($id)
    {
        $transaction = Registration::find($id);
        $this->edit_mode = $transaction->id;
        $this->cif = $transaction->cif;
        $this->phone = $transaction->phone;
        $this->bank_id = $transaction->bank_id;
        $this->rrn = $transaction->rrn;
        $this->reg_id = $transaction->registration_id;
        $this->ktp = $transaction->ktp;
        $this->first_name = $transaction->first_name;
        $this->last_name = $transaction->last_name;
        $this->city = $transaction->city;
        $this->address = $transaction->address;
        $this->email = $transaction->email;
        $this->digi = $transaction->digi;
        $this->digicash = $transaction->digicash;
        $this->quantity = $transaction->quantity;
        $this->method = $transaction->payment_method;
    }

    public function delete($id)
    {
        Registration::whereId($id)->delete();
    }

    public function clear()
    {
        $this->resetExcept('ticket', 'sold', 'reg_id', 'office_id');
        $this->reg_id = $this->getCode();
    }

    public function updatedCif($val)
    {
        if (strlen($val) < 6) {
            $this->duplicate_cif = false;
        } else {
            $this->countDuplicate('cif');
        }
    }

    public function updatedPhone($val)
    {
        if (strlen($val) < 10) {
            $this->duplicate_phone = false;
        } else {
            $this->countDuplicate('phone');
        }
    }

    public function updatedRrn($val)
    {
        $this->rrn = sprintf("%012d", $val);
    }

    public function updatedQuantity($val)
    {
        if (!empty($val)) {
            if ($val > $this->ticket['max_ticket']) {
                $this->error_max = true;
            } else {
                $this->reset('error_max');
            }
//            if (!empty($this->cif)) {
//                $this->countDuplicate('cif');
//            }
//
//            if (!empty($this->phone)) {
//                $this->countDuplicate('phone');
//            }
        } else {
            $this->reset('error_max', 'quantity');
        }
    }

    private function countDuplicate($group)
    {
        $total = Registration::query()->where($group, $this->{$group})->count() + 1;
        if ($total) {
            $stat = $total > $this->ticket['max_quantity']; //max transaksi
            $this->{"duplicate_$group"} = $stat;
            return $stat;
        }

        $this->{"duplicate_$group"} = false;
    }


    private function checkAvailable()
    {
        $this->available = $this->countSold() < $this->ticket['quota'];
        return $this->available;
    }

    public function searchKTP()
    {
        $transaction = Registration::query()
            ->where('ktp', $this->ktp)
            ->orderBy('id', 'desc')
            ->toBase()
            ->first();

        if (!$transaction) {
            $this->reset('first_name', 'last_name', 'city', 'address');
        } else {
            $this->first_name = $transaction->first_name;
            $this->last_name = $transaction->last_name;
            $this->city = $transaction->city;
            $this->address = $transaction->address;
        }
    }

    private function getCode()
    {
        $count = Registration::withTrashed()->where('ticket_id', $this->ticket['id'])->count();
        $number = ($count + $this->ticket['first_number']);
        $c = strlen($this->ticket['quota']);
        return $this->ticket['name'] . sprintf("%0{$c}d", $number);
    }

    private function countSold()
    {
        $this->sold = Registration::query()->where('ticket_id', $this->ticket['id'])->sum('quantity');
        return $this->sold;
    }

    public function delayCount()
    {
        $this->sold = $this->countSold();
    }
}
