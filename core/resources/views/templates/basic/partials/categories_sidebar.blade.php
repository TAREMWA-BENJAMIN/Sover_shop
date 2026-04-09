<div class="cat-sidebar">
    <div class="cat-sidebar__header">
        <h5 class="cat-sidebar__title">
            <i class="las la-th-list me-2"></i>@lang('Products')
        </h5>
    </div>
    <ul class="cat-sidebar__list">
        @foreach ($categories as $cat)
            <li class="cat-sidebar__item">
                <a href="{{ route('products', ['category' => $cat->slug]) }}" class="cat-sidebar__link">
                    @php
                        $catSlug = strtolower($cat->slug ?? $cat->name);
                        $icon = 'las la-tag';
                        if (str_contains($catSlug, 'humidifier')) $icon = 'las la-tint';
                        elseif (str_contains($catSlug, 'perfume')) $icon = 'las la-spray-can';
                        elseif (str_contains($catSlug, 'shoe')) $icon = 'las la-shoe-prints';
                        elseif (str_contains($catSlug, 'bag')) $icon = 'las la-shopping-bag';
                        elseif (str_contains($catSlug, 'watch')) $icon = 'las la-clock';
                        elseif (str_contains($catSlug, 'cloth') || str_contains($catSlug, 'shirt') || str_contains($catSlug, 'apparel')) $icon = 'las la-tshirt';
                        elseif (str_contains($catSlug, 'electronic') || str_contains($catSlug, 'computer')) $icon = 'las la-laptop';
                        elseif (str_contains($catSlug, 'phone') || str_contains($catSlug, 'mobile')) $icon = 'las la-mobile-alt';
                        elseif (str_contains($catSlug, 'beauty') || str_contains($catSlug, 'cosmetic')) $icon = 'las la-magic';
                        elseif (str_contains($catSlug, 'health') || str_contains($catSlug, 'medical')) $icon = 'las la-heartbeat';
                        elseif (str_contains($catSlug, 'home') || str_contains($catSlug, 'furniture')) $icon = 'las la-home';
                        elseif (str_contains($catSlug, 'toy') || str_contains($catSlug, 'kid') || str_contains($catSlug, 'baby')) $icon = 'las la-child';
                        elseif (str_contains($catSlug, 'sport') || str_contains($catSlug, 'fitness')) $icon = 'las la-dumbbell';
                        elseif (str_contains($catSlug, 'book') || str_contains($catSlug, 'stationery')) $icon = 'las la-book';
                        elseif (str_contains($catSlug, 'car') || str_contains($catSlug, 'vehicle') || str_contains($catSlug, 'auto')) $icon = 'las la-car';
                    @endphp
                    <div class="cat-sidebar__icon">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div class="cat-sidebar__info">
                        <span class="cat-sidebar__name">{{ __($cat->name) }}</span>
                        <span class="cat-sidebar__count">{{ $cat->products_count }} @lang('products')</span>
                    </div>
                    <i class="las la-angle-right cat-sidebar__arrow"></i>
                </a>

                {{-- Flyout Panel --}}
                @if ($cat->products->count())
                    <div class="cat-flyout">
                        <div class="cat-flyout__header">
                            <span>{{ __($cat->name) }}</span>
                            <a href="{{ route('products', ['category' => $cat->slug]) }}" class="cat-flyout__view-all">@lang('View All') &rarr;</a>
                        </div>
                        <div class="cat-flyout__grid">
                            @foreach ($cat->products as $product)
                                <a href="{{ route('product.details', [$product->id, $product->slug]) }}" class="cat-flyout__product">
                                    <div class="cat-flyout__img">
                                        <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}" alt="{{ __($product->name) }}">
                                    </div>
                                    <div class="cat-flyout__product-info">
                                        <span class="cat-flyout__product-name">{{ Str::limit(__($product->name), 40) }}</span>
                                        <span class="cat-flyout__product-price">
                                            @if ($product->discount > 0)
                                                {{ gs('cur_sym') }}{{ afterDiscount($product->price, $product->discount) }}
                                            @else
                                                {{ gs('cur_sym') }}{{ getAmount($product->price) }}
                                            @endif
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<style>
/* ========== Sidebar ========== */
.cat-sidebar {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    overflow: visible;
    margin-bottom: 20px;
    position: relative;
}

.cat-sidebar__header {
    background: #e8041b;
    padding: 14px 18px;
    border-radius: 8px 8px 0 0;
}

.cat-sidebar__title {
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    margin: 0;
}

.cat-sidebar__list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.cat-sidebar__item {
    border-bottom: 1px solid #f0f0f0;
    position: relative;
}

.cat-sidebar__item:last-child {
    border-bottom: none;
}

.cat-sidebar__link {
    display: flex;
    align-items: center;
    padding: 11px 14px;
    text-decoration: none;
    color: #333;
    transition: background 0.15s ease;
    gap: 10px;
}

.cat-sidebar__link:hover,
.cat-sidebar__item:hover > .cat-sidebar__link {
    background: #fff5f5;
    color: #e8041b;
}

.cat-sidebar__link:hover .cat-sidebar__arrow,
.cat-sidebar__item:hover > .cat-sidebar__link .cat-sidebar__arrow {
    color: #e8041b;
}

.cat-sidebar__icon {
    width: 34px;
    height: 34px;
    background: #f0f4ff;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
    color: #e8041b;
}

.cat-sidebar__info {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.cat-sidebar__name {
    font-size: 13.5px;
    font-weight: 500;
    line-height: 1.3;
    color: #222;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cat-sidebar__item:hover .cat-sidebar__name {
    color: #e8041b;
}

.cat-sidebar__count {
    font-size: 11px;
    color: #999;
    margin-top: 1px;
}

.cat-sidebar__arrow {
    color: #ccc;
    font-size: 12px;
    flex-shrink: 0;
}

/* ========== Flyout ========== */
.cat-flyout {
    display: none;
    position: absolute;
    top: 0;
    left: 100%;
    width: 350px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 0 8px 8px 8px;
    box-shadow: 4px 4px 20px rgba(0,0,0,0.12);
    z-index: 9999;
    padding: 10px 0;
    max-height: 400px;
    overflow-y: auto;
}

.cat-sidebar__item:hover .cat-flyout {
    display: block;
}

.cat-flyout__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #e8041b;
    padding: 8px 12px;
    margin-bottom: 0;
}

.cat-flyout__header span {
    font-size: 14px;
    font-weight: 700;
    color: #222;
}

.cat-flyout__view-all {
    font-size: 11px;
    color: #e8041b;
    text-decoration: none;
    font-weight: 500;
}

.cat-flyout__view-all:hover {
    text-decoration: underline;
}

.cat-flyout__grid {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.cat-flyout__product {
    display: flex;
    flex-direction: row;
    align-items: center;
    text-decoration: none;
    border: none;
    border-bottom: 1px solid #f0f0f0;
    border-radius: 0;
    overflow: visible;
    transition: background 0.2s ease;
    background: #ffffff;
    padding: 8px 12px;
}

.cat-flyout__product:last-child {
    border-bottom: none;
}

.cat-flyout__product:hover {
    box-shadow: none;
    transform: none;
    border-color: transparent;
    background: #f8f8f8;
}

.cat-flyout__img {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    border-radius: 6px;
    overflow: hidden;
    background: #f8f8f8;
    margin-right: 12px;
}

.cat-flyout__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cat-flyout__product-info {
    padding: 0;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    justify-content: center;
}

.cat-flyout__product-name {
    font-size: 12px;
    color: #222;
    line-height: 1.35;
    font-weight: 600;
    margin-bottom: 0;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.cat-flyout__product-price {
    font-size: 14px;
    color: #e8041b;
    font-weight: 700;
    display: none;
}
</style>
