<?php

namespace App\Livewire\Dashboard\Admin\Role;

use App\Models\Role;
use Livewire\Component;

class RoleEdit extends Component
{
    public $name;

    public $permissions = [];

    public $role;

    public function mount($role)
    {
        $this->role = Role::findOrFail($role);
        $this->name = $this->role->name;

        // Initialize all as false
        foreach (roleModel() as $permission) {
            foreach (roleMap() as $map) {
                $this->permissions[$permission][$map] = false;
            }
        }

        // Set existing permissions to true
        $existingPermissions = $this->role->permissions->pluck('name')->toArray();
        foreach ($existingPermissions as $permName) {
            $parts = explode('-', $permName);
            if (count($parts) === 2) {
                $this->permissions[$parts[0]][$parts[1]] = true;
            }
        }
    }

    public function selectGroup($group, $value)
    {
        if (isset($this->permissions[$group])) {
            foreach ($this->permissions[$group] as $action => $status) {
                $this->permissions[$group][$action] = $value;
            }
        }
    }

    public function render()
    {
        $model = roleModel();
        $actions = roleMap();

        return view('livewire.dashboard.admin.role.role-edit', [
            'model'       => $model,
            'actions'     => $actions,
            'role'        => $this->role,
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'permissions' => 'required|array'
        ]);

        $this->role->name = $this->name;
        $this->role->display_name = $this->name;
        $this->role->description = $this->name;
        $this->role->save();

        $formattedPermissions = [];
        foreach ($this->permissions as $permission => $actions) {
            if (is_array($actions)) {
                foreach ($actions as $action => $value) {
                    if ($value == true) {
                        $formattedPermissions[] = $permission . '-' . $action;
                    }
                }
            }
        }

        $this->role->syncPermissions($formattedPermissions);

        session()->flash('success', __('Role updated successfully'));

        $this->redirect('/dashboard/role/role', navigate: true);
    }
}
