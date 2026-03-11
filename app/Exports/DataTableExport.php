<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataTableExport implements FromCollection, WithHeadings, WithMapping
{
    protected $rows;
    protected $columns;

    public function __construct($rows, $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return collect($this->columns)->map(function($column) {
            return $column->getTitle();
        })->toArray();
    }

    public function map($row): array
    {
        return collect($this->columns)->map(function($column) use ($row) {
            $value = $row->{$column->getField()};

            // Handle formatted columns
            if (method_exists($column, 'getFormatCallback') && $column->getFormatCallback()) {
                $formatter = $column->getFormatCallback();
                $value = $formatter($value, $row, $column);
                // Strip HTML tags if the value was formatted as HTML
                $value = strip_tags($value);
            }

            return $value;
        })->toArray();
    }
}
