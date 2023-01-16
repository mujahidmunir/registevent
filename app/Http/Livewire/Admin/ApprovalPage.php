<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovalPage extends Component
{
    use WithPagination;

    public $ids = [];
    public $query_active = 0;
    public $query = '';
    public $selectAll = false;
    public $ids_tmp = [];

    public function render()
    {
        $users = User::with('office')->orderBy('updated_at', 'desc');
        $users = $this->buildFilter($users);
        $users = $users->paginate(20);
        foreach ($users as $user) {
            $this->ids_tmp[] = $user->id;
        }

        return view('livewire.admin.approval-page', [
            'users' => $users
        ]);
    }

    public function updatedQueryActive()
    {
        $this->clear();
    }

    public function buildFilter($users)
    {
        $users = $users->where('active', $this->query_active);

        if (!empty($this->query)) {
            $q = $this->query;
            $users = $users->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('domain_name', 'like', "%$q%");
            });
        }

        return $users;
    }

    public function approve($id, $status)
    {
        User::whereId($id)->update([
            'active' => $status
        ]);

        $this->reset('ids');
        $this->emit('pop', true);
    }

    public function massApprove()
    {
        $active = $this->query_active ? 0 : 1;
        User::whereIn('id', $this->ids)->update([
            'active' => $active
        ]);
    }

    public function updatedSelectAll($v)
    {
        if ($v) {
            $this->ids = $this->ids_tmp;
        } else {
            $this->clear();
        }
    }

    private function clear()
    {
        $this->reset('ids', 'selectAll');
    }

    public function delete($id)
    {
        User::whereId($id)->delete();
        $this->emit('pop', true);
    }
}
