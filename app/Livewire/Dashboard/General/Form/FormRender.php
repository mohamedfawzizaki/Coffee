<?php

namespace App\Livewire\Dashboard\General\Form;

use Livewire\Component;

class FormRender extends Component
{
    public $form;

    public $fields;

    public function mount($form)
    {
        $this->form = $form;

        if ($this->form) {
            $this->fields = json_decode($this->form->fields, true);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.form.form-render');
    }
}
