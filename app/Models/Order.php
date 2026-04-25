<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'order_number',
        'customer_name',
        'phone',
        'division_id',
        'district_id',
        'upazila_id',
        'address',
        'note',
        'items',
        'subtotal',
        'delivery_charge',
        'total',
        'payment_method',
        'status',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'items' => 'array',
            'subtotal' => 'decimal:2',
            'delivery_charge' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    /**
     * Auto-generate order number on creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (! $order->order_number) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    /**
     * Generate a unique order number in MS-2097-XXXX format.
     */
    public static function generateOrderNumber(): string
    {
        $year = now()->year;
        $prefix = "MS-2097-";

        $lastOrder = static::where('order_number', 'like', "{$prefix}%")
            ->orderByDesc('id')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) str_replace($prefix, '', $lastOrder->order_number);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix.str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /** @var array<string, string> */
    public const STATUS_LABELS = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];

    /** @var array<string, string> */
    public const STATUS_COLORS = [
        'pending' => 'yellow',
        'confirmed' => 'blue',
        'shipped' => 'indigo',
        'delivered' => 'green',
        'cancelled' => 'red',
    ];
}
