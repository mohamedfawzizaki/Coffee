<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniquePhone implements ValidationRule
{
    protected string $table;
    protected string $column;
    protected mixed $ignoreId;
    protected string $idColumn;

    /**
     * Create a new rule instance.
     *
     * @param string $table The table to check
     * @param string $column The column to check
     * @param mixed $ignoreId Optional ID to ignore (for updates)
     * @param string $idColumn The ID column name (default 'id')
     */
    public function __construct(string $table, string $column = 'phone', mixed $ignoreId = null, string $idColumn = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
        $this->idColumn = $idColumn;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Normalize the incoming value
        $normalized = normalizePhone($value);

        if (empty($normalized)) {
            return;
        }

        $query = DB::table($this->table);

        // Standard UNIQUE check but with variations for performance (index hits)
        $query->where(function ($q) use ($normalized) {
            $column = $this->column;
            
            $q->where($column, $normalized)
              ->orWhere($column, '0' . $normalized)
              ->orWhere($column, '966' . $normalized)
              ->orWhere($column, '+966' . $normalized);
            
            // Robust check for messy legacy data (spaces, dashes, mixed prefixes)
            // SQL logic: TRIM(LEADING '0' FROM REPLACE(REPLACE(REPLACE(REPLACE(phone, '+966', ''), '966', ''), ' ', ''), '-', ''))
            // This is slower but ENSURES no duplicates even with very weird formatting.
            $q->orWhereRaw(
                "TRIM(LEADING '0' FROM REPLACE(REPLACE(REPLACE(REPLACE({$column}, '+966', ''), '966', ''), ' ', ''), '-', '')) = ?",
                [$normalized]
            );
        });

        // Handle 'ignore' for updates
        if ($this->ignoreId) {
            $query->where($this->idColumn, '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail(__('The :attribute has already been taken.'));
        }
    }
}
