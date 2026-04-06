<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    protected $with = [
        'product'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function deposit()
    {
        return $this->hasOne(Order::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function shipping()
    {
        return $this->hasOne(ShippingInfo::class, 'order_id');
    }
    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::ORDER_PENDING) {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            } elseif ($this->status == Status::ORDER_COMPLETED) {
                $html = '<span><span class="badge badge--success">' . trans('Delivered') . '</span>';
            } elseif ($this->status == Status::ORDER_PROCESSING) {
                $html = '<span class="badge badge--info">' . trans('Processing') . '</span>';
            } elseif ($this->status == Status::ORDER_CANCELLED) {
                $html = '<span class="badge badge--danger">' . trans('Cancelled') . '</span>';
            }
            return $html;
        });
    }
    public function statusBadgeStatus(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::ORDER_COMPLETED) {
                $html = '<span class="badge bg--success badge--md">' . trans('Delivered') . '</span>';
            } elseif ($this->status == Status::ORDER_PROCESSING) {
                $html = '<span><span class="badge bg--info badge--md">' . trans('Processing') . '</span>';
            } elseif ($this->status == Status::ORDER_CANCELLED) {
                $html = '<span class="badge bg--danger badge--md">' . trans('Cancelled') . '</span>';
            } else {
                $html = '<span class="badge bg--warning badge--md">' . trans('Pending') . '</span>';
            }
            return $html;
        });
    }

    public function scopePending($query)
    {
        $query->where('status', Status::ORDER_PENDING);
    }
    public function scopeProcessing($query)
    {
        $query->where('status', Status::ORDER_PROCESSING);
    }
    public function scopeDelivered($query)
    {
        $query->where('status', Status::ORDER_COMPLETED);
    }
    public function scopeCancelled($query)
    {
        $query->where('status', Status::ORDER_CANCELLED);
    }
    public function scopeCod($query)
    {
        $query->where('payment_type', Status::PAYMENT_TYPE_CASH_ON_DELIVERY);
    }
}
