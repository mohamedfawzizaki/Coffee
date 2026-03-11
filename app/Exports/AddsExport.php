<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;

class AddsExport implements FromCollection
{
    protected $adds;

    public function __construct($adds)
    {
        $this->adds = $adds;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->adds;
    }
}
