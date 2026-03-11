<?php

namespace App\Livewire\Dashboard\Admin\Role;

use Livewire\Component;

class RoleCreate extends Component
{
    public $name;

    public $permissions = [];

    public function mount()
    {
        $this->permissions = [];
        foreach (roleModel() as $permission) {
            foreach (roleMap() as $map) {
                $this->permissions[$permission][$map] = false;
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

        return view('livewire.dashboard.admin.role.role-create', compact('model', 'actions'));
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array'
        ]);

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

        $role = \App\Models\Role::create([
            'name'         => $this->name,
            'display_name' => $this->name,
            'description'  => $this->name,
        ]);

        $role->syncPermissions($formattedPermissions);

        request()->session()->flash('success', __('Role created successfully'));

        $this->redirect('/dashboard/role/role', navigate: true);
    }
}
