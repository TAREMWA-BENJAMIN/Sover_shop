@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.product.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}" required>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">@lang('Main Image') </label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <x-image-uploader image="{{ $product->image }}" class="w-100" type="product" :required=false />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-8 col-lg-6">
                                <div class="form-group">
                                    <label for="name">@lang('Product Name')</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xl-6">
                                        <label>
                                            @lang('Category')
                                        </label>
                                        <div class="input-group">
                                            <select name="category" class="form-control select2-basic" required>
                                                <option value="">@lang('Select One')</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <div class="input-group mb-3">
                                            <label>
                                                @lang('Brand')
                                            </label>
                                            <select name="brand" class="form-control select2-basic" required>
                                                <option value="">@lang('Select One')</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ __($brand->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label>
                                            @lang('Price')
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-text">{{ gs('cur_sym') }}</div>
                                            <input type="number" class="form-control" step="any" placeholder="0" name="price"
                                                value="{{ getAmount($product->price) }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label>@lang('Discount')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" step="0.01" placeholder="0" name="discount"
                                                value="{{ getAmount($product->discount) }}">
                                            <div class="input-group-text">@lang('%')</div>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label>
                                            @lang('SKU')
                                        </label>
                                        <input type="text" class="form-control " name="sku" value="{{ $product->sku }}" required>
                                    </div>

                                    <div class="form-group  col-xl-6">
                                        <label>@lang('Product Stock')</label>
                                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                    </div>
                                    <div class="form-group col-xl-6">
                                        <label for="status">@lang('Status')</label>
                                        <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger"
                                            data-bs-toggle="toggle" id="status" data-on="@lang('Enable')" data-off="@lang('Disable')"
                                            name="status" @if ($product->status) checked @endif>
                                    </div>

                                    <div class="form-group col-xl-6">
                                        <label for="featured">@lang('Featured')</label>
                                        <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger"
                                            data-bs-toggle="toggle" id="featured" data-on="@lang('Enable')" data-off="@lang('Disable')"
                                            name="featured" @if ($product->featured) checked @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-2">@lang('Description')</label>
                            <textarea rows="15" class="form-control border-radius-5 nicEdit" name="description">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-outline--primary ">
        <i class="la la-undo"></i>@lang('Go Back')
    </a>
@endpush


@push('script')
    <script>
        'use strict';
        (function($) {
            $('select[name=category]').val({{ $product->category_id }}).select2();
            $('select[name=brand]').val({{ $product->brand_id }}).select2();
        })(jQuery)
    </script>
@endpush
