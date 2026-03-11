<?php

namespace App\Livewire\Dashboard\General\Form;

use App\Models\Form\Form;
use Livewire\Component;

class FormBuilder extends Component
{
    public $category;

    public $category_id;

    public $form;

    public $fields = [];

    public $fieldTypes = ['text', 'textarea', 'select', 'checkbox', 'radio', 'image', 'gallery', 'number', 'date', 'time',
    'datetime', 'color', 'range', 'email', 'url', 'tel', 'password','list'];

    public $prePreparedLists = [
        'Countries' => ['USA', 'Canada', 'UK'],
        'Colors'    => ['Red', 'Blue', 'Green'],
        'Sizes'     => ['Small', 'Medium', 'Large'],
    ];

    public $formName;

    public $fieldType;

    public function mount($category)
    {
        $this->category = $category;

        $this->category_id = $category->id;

        $this->form = Form::where('category_id', $this->category_id)->first();

        if ($this->form) {
            $this->fields   = json_decode($this->form->fields, true);
            $this->formName = $this->form->name;
        }
    }


    public function render()
    {
        return view('livewire.dashboard.form.form-builder');
    }


    public function updateField($index)
    {
        // Reset field-specific properties when type changes
        if (!isset($this->fields[$index]['type'])) {
            return;
        }

        $currentField = [
            'label'    => $this->fields[$index]['label'] ?? '',
            'type'     => $this->fields[$index]['type'],
            'required' => $this->fields[$index]['required'] ?? false,
        ];

        switch ($this->fields[$index]['type']) {
            case 'text':
                $currentField['translatable'] = $this->fields[$index]['translatable'] ?? false;
                break;
            case 'select':
                $currentField['list'] = $this->fields[$index]['list'] ?? null;
                $currentField['options'] = $this->fields[$index]['options'] ?? '';
                break;
        }

        $this->fields[$index] = $currentField;
    }

    public function addField()
    {
        $this->fields[] = [
            'label' => '',
            'type' => 'text',
            'required' => false,
            'translatable' => false,
            'options' => [],
            'list' => null,
        ];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }


    public function saveForm()
    {
        $validated = $this->validate([
            'formName'              => 'required|string|max:255',
            'fields'                => 'required|array',
            'fields.*.label'        => 'required|string|max:255',
            'category_id'           => 'required|numeric',
            // 'fields.*.type'         => ['required', 'string', 'in:' . implode(',', $this->fieldTypes)],
            // 'fields.*.required'     => 'boolean',
            // 'fields.*.translatable' => 'boolean',
            // 'fields.*.options'      => 'string|nullable',
            // 'fields.*.list'         => 'string|nullable',
        ]);


         Form::updateOrCreate(
            ['category_id' => $this->category_id],
            [
                'name'        => $this->formName,
                'fields'      => json_encode($this->fields),
                'category_id' => $this->category_id,
            ]
        );

        request()->session()->flash('message', __('Form saved successfully!'));

        $this->reset(['fields', 'formName']);

        $this->redirect('/dashboard/pcategory/form/'.$this->category_id, navigate: true);
    }

}
