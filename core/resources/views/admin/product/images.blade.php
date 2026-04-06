@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.product.image.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="payment-method-item">
                            <div class="payment-method-body">
                                <div class="row align-items-end">
                                    <input type="hidden" name="id" value="{{ $product->id }}" required>

                                    <div class="col-lg-12 form-group mb-0">
                                        <label for="image">@lang('Add New Images')</label>
                                        <div class="file-upload-wrapper" data-text="@lang('Select your images!')">
                                            <input type="file" name="image[]" id="image" class="file-upload-field" accept=".jpg,.png,.jpeg"
                                                multiple />
                                        </div>
                                        <small>
                                            @lang('Supported Files:') @lang('.png'), @lang('.jpg'), @lang('.jpeg'). @lang('Image will be resized into ')
                                            {{ getFileSize('product') }}@lang('px')
                                        </small>
                                        <div id="fileUploadsContainer"></div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                                    </div>

                                    <div class="col-lg-12">
                                        <h5 class="my-2">@lang('Product Images')</h5>
                                        <div class="payment-method-header imageField">
                                            @foreach ($product->images as $data)
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview"
                                                            style="background-image: url('{{ getImage(getFilePath('product') . '/' . $data->image, getFileSize('product')) }}')">
                                                        </div>
                                                    </div>
                                                    <div class="avatar-edit">
                                                        <input type="file" name="image[]" class="profilePicUpload " id="image{{ $data->image }}"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <label class="bg--danger border-0 confirmationBtn" data-id='{{ $data->id }}'
                                                            data-question="@lang('Are you sure to delete this product image?')"
                                                            data-action="{{ route('admin.product.image.delete', [$product->id, $data->id]) }}">
                                                            <i class="la la-trash"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.product.update.page', $product->id) }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-desktop"></i>
        @lang('View Details')
    </a>
    <x-back route="{{ route('admin.product.index') }}" />
@endpush


@push('style')
    <style>
        .payment-method-item .payment-method-header {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .payment-method-item .payment-method-header .thumb {
            width: 220px;
            position: relative;
            margin-bottom: 0px;
        }

        .payment-method-item .payment-method-header .thumb .profilePicPreview {
            width: 210px;
            height: 210px;
            display: block;
            border: 3px solid #f1f1f1;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            background-size: cover;
            background-position: center;
        }

        .payment-method-item .payment-method-header .thumb .avatar-edit {
            position: absolute;
            bottom: -15px;
            right: 0;
        }

        .payment-method-item .payment-method-header .thumb .avatar-edit label {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            border: 2px solid #fff;
            font-size: 18px;
            cursor: pointer;
        }

        .payment-method-item .payment-method-header .thumb .profilePicUpload {
            font-size: 0;
            opacity: 0;
            width: 0;
        }
    </style>
@endpush
