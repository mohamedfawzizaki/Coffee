<?php

namespace App\Models\Branch;

use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class BranchProduct extends Model
{
    use ForceTimeZone;
    protected $fillable = ['branch_id', 'product_id', 'category_id', 'status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(PCategory::class);
    }

}
