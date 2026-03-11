<?php

namespace App\Livewire\Dashboard\Finance\Currency;

use App\Models\Finance\Currency;
use Livewire\Attributes\Title;
use Livewire\Component;

class CurrencyIndex extends Component
{
    public $currencies;

    public $name;
    public $symbol;
    public $code;
    public $rate;
    public $is_default;
    public $status;

    public $currency_id;


    public function mount()
    {
        $this->currencies = Currency::all();
    }

    #[Title('Currencies')]
    public function render()
    {
        return view('livewire.dashboard.finance.currency.currency-index');
    }

    public function store()
    {
         $this->validate([
            'name'       => 'required|string|max:255|unique:currencies',
            'symbol'     => 'required|string|max:255|unique:currencies',
            'code'       => 'required|string|max:255|unique:currencies',
            'rate'       => 'required|numeric|min:0',
         ]);

         Currency::create([
            'name'       => $this->name,
            'symbol'     => $this->symbol,
            'code'       => $this->code,
            'rate'       => $this->rate,
         ]);

         $this->reset();

         $this->dispatch('refresh-currencies');

         $this->currencies = Currency::all();

         request()->session()->flash('success', __('Currency created successfully'));


    }

    public function makeDefault()
    {
        $currency = Currency::find($this->currency_id);

        $currency->is_default = true;

        $currency->save();

        $otherCurrencies = Currency::where('id', '!=', $currency->id)->update(['is_default' => false]);

        $this->dispatch('refresh-currencies');

        $this->currencies = Currency::all();

        request()->session()->flash('success', __('Currency updated successfully'));

    }
}
