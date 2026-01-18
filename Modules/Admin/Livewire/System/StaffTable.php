<?php

namespace Modules\Admin\Livewire\System;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StaffTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $filterRole = '';

    public $selected = [];
    public $selectAll = false;

    // Reset Logic
    public function updatedSearch() { $this->resetPage(); $this->resetSelection(); }
    public function updatedFilterRole() { $this->resetPage(); $this->resetSelection(); }
    public function updatingPage() { $this->resetSelection(); }
    
    public function resetSelection() { $this->selected = []; $this->selectAll = false; }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function deleteSelected()
    {
        // Không cho xóa chính mình
        if (in_array(auth()->id(), $this->selected)) {
            $this->dispatch('notify', content: 'Không thể xóa tài khoản đang đăng nhập!', type: 'error');
            return;
        }

        User::whereIn('id', $this->selected)->delete();
        $this->resetSelection();
        $this->dispatch('notify', content: 'Đã xóa nhân viên.', type: 'success');
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            $this->dispatch('notify', content: 'Không thể xóa chính mình!', type: 'error');
            return;
        }
        User::find($id)->delete();
        $this->dispatch('notify', content: 'Đã xóa nhân viên.', type: 'success');
    }

    private function getQuery()
    {
        return User::query()
            ->with('roles') // Eager load roles
            ->whereHas('roles') // Chỉ lấy user có vai trò (Staff)
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterRole, function($q) {
                $q->whereHas('roles', function($r) {
                    $r->where('id', $this->filterRole);
                });
            })
            ->latest();
    }

    public function render()
    {
        $users = $this->getQuery()->paginate($this->perPage);
        $roles = Role::all(); // Cho filter

        return view('Admin::livewire.system.staff-table', [
            'users' => $users,
            'roles' => $roles
        ]);
    }
}