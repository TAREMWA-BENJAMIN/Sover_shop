<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use GlobalStatus;

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function hotDealPrice()
    {
        return afterDiscount($this->price, GeneralSetting::value('hot_deal_discount'));
    }

    public function price()
    {
        if ($this->hot_deal == 1) $price = $this->hotDealPrice();
        else $price = $this->discount > 0 ? afterDiscount($this->price, $this->discount) : $this->price;
        return $price;
    }

    public function scopeFilters()
    {
        $category = Category::where('slug', request('category'))->first(['id']);
        $brand = Brand::where('slug', request('brand'))->first(['id']);
        $search = request('search');

        return $this->when($search, function ($q, $search) {
            return $q->where('name', 'like', "%$search%");
        })
            ->when($category, function ($q, $category) {
                return $q->where('category_id', $category->id);
            })
            ->when($brand, function ($q, $brand) {
                return $q->where('brand_id', $brand->id);
            })
            ->when(request('attribute'), function ($q) {
                if (request('attribute') == 'hot-deal') {
                    return $q->where('hot_deal', 1);
                } elseif (request('attribute') == 'discounted') {
                    return $q->where('discount', '!=', 0);
                } elseif (request('attribute') == 'featured') {
                    return $q->where('featured', 1);
                }
            });
    }

    public function featuredBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->featuredBadgeData(),
        );
    }

    public function featuredBadgeData()
    {
        $html = '';
        if ($this->featured == Status::ENABLE) {
            $html = '<span class="badge badge--success">' . trans('Yes') . '</span>';
        } else {
            $html = '<span class="badge badge--dark">' . trans('No') . '</span>';
        }
        return $html;
    }
}
