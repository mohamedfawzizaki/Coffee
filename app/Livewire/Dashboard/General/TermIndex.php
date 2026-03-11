<?php

namespace App\Livewire\Dashboard\General;

use App\Models\General\Term;
use Livewire\Component;
use Livewire\Attributes\Title;

class TermIndex extends Component
{
    public $terms;

    public $ar = ['content' => ''];
    public $en = ['content' => ''];



    public function mount()
    {
        $this->terms = Term::first();

        if ($this->terms) {
            $this->ar['content'] = $this->terms->translate('ar')->content ?? '';
            $this->en['content'] = $this->terms->translate('en')->content ?? '';
        }
    }

    #[Title('Terms & Conditions')]
    public function render()
    {
        $locales = ['ar', 'en'];
        return view('livewire.dashboard.general.term-index', compact('locales'));
    }

    public function saveContentAndSaveTerms($arContent = null, $enContent = null)
    {
        // Update content from JavaScript if provided
        if ($arContent !== null) {
            $this->ar['content'] = $arContent;
        }
        if ($enContent !== null) {
            $this->en['content'] = $enContent;
        }

        $this->saveTerms();
    }

    public function saveTerms()
    {
        $this->validate([
            'ar.content' => 'required',
            'en.content' => 'required',
        ]);

        $terms = Term::firstOrCreate([]);

        $terms->update([
            'ar' => ['content' => $this->ar['content']],
            'en' => ['content' => $this->en['content']],
        ]);

        session()->flash('message', __('Terms & Conditions updated successfully'));

        $this->redirect('/dashboard/terms', navigate: true);
    }
}
