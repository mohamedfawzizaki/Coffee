<?php

namespace App\Models\Order;

use App\Models\Admin\Admin;
use App\Models\Branch\Branch;
use App\Models\Branch\BranchManager;
use App\Models\Customer\Customer;
use App\Models\Finance\Coupon;
use App\Models\Product\Product\Product;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use LogsActivity, ForceTimeZone;

    protected $guarded = [];

    // Performance optimization - define fillable fields for mass assignment
    protected $fillable = [
        'status', 'customer_id', 'branch_id', 'total', 'notes',
        'delivery_address', 'delivery_phone', 'send_to', 'manager_id',
        'admin_id', 'coupon_id', 'product_id',
        'grand_total', 'discount', 'tax', 'points', 'payment_method', 'payment_status', 'payment_id', 'note', 'lat', 'lng', 'place', 'created_by', 'title', 'message', 'car_details'
    ];

    // Performance optimization - define fields that need casting
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'total' => 'decimal:2',
    ];

    // Performance optimization - default eager loading relationships
    protected $with = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sendTo()
    {
        return $this->belongsTo(Customer::class, 'send_to');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status']) // Log only status changes for performance
            ->logOnlyDirty() // Log only changed fields
            ->dontSubmitEmptyLogs(); // Don't log empty records
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function manager()
    {
        return $this->belongsTo(BranchManager::class, 'manager_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


}
