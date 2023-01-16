<?php

namespace App\Http\Livewire\Admin;

use App\Excel\UsersExport;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class UserPage extends Component
{
    use WithPagination;

    public $name, $nip, $office_id, $phone, $email, $password, $password_confirmation, $domain_name, $is_admin;
    public $edit_mode = null;
    public $offices;
    public $query = null;
    protected $listeners = ['edit', 'delete'];

    protected $rules = [
        'name' => 'required',
        'nip' => 'required',
        'domain_name' => 'required',
        'office_id' => 'required',
        'phone' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required|confirmed|min:6'
    ];

    public function mount()
    {
        $this->offices = Office::query()->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.admin.user-page');
    }

    public function updatedNip($val)
    {

        $val = preg_replace('/[^0-9,.]+/', '', $val);
        $res = '';
        $format = 'xx.xx.xxxx';
        $lVal = strlen($val) - 1;
        $lFormat = strlen($format);

        for ($i = 0; $i <= $lVal; $i++) {
            if ($i >= $lFormat) {
                break;
            }

            if ($format[$i] === '.' && $val[$i] !== '.') {
                $res .= '.';
            }

            $res .= $val[$i];
        }

        $this->nip = $res;
    }


    public function save()
    {

        $update = [
            'name' => $this->name,
            'nip' => $this->nip,
            'office_id' => $this->office_id,
            'phone' => $this->phone,
            'email' => $this->email,
            'active' => 1,
            'domain_name' => $this->domain_name,
            'is_admin' => $this->is_admin
        ];

        if ($this->edit_mode) {
            $this->rules['password'] = 'sometimes|nullable|confirmed|min:6';
            $this->rules['email'] = 'required|unique:users,email,' . $this->edit_mode;
            if (!empty($this->password)) {
                $update['password'] = Hash::make($this->password);
            }
        }

        $this->validate();

        try {
            User::query()->updateOrCreate(['id' => $this->edit_mode], $update);
            $this->clear();
            flash('Data tersimpan', 'success');
            $this->forceRefresh();
        } catch (\Exception $exception) {
            flash($exception->getMessage(), 'danger');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->edit_mode = $user->id;
        $this->name = $user->name;
        $this->nip = $user->nip;
        $this->office_id = $user->office_id;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->domain_name = $user->domain_name;
        $this->is_admin = $user->is_admin;
    }

    public function generate()
    {
        $password = Str::random('8');
        $this->password = $password;
        $this->password_confirmation = $password;
    }

    public function clear()
    {
        $this->resetExcept('offices');
    }

    public function delete($id)
    {
        User::whereId($id)->delete();
        $this->forceRefresh();
    }

    private function forceRefresh()
    {
        return redirect(request()->header('Referer'));
    }
}
