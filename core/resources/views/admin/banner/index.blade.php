@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($banners as $banner)
                            <tr>

                                <td data-label="@lang('Title')">
                                    <span class="font-weight-bold">
                                        {{ shortDescription($banner->title, 30) }}
                                    </span>
                                </td>

                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        @if($banner->product_id != 0)
                                            {{ shortDescription(@$banner->product->name, 30) }}
                                        @else
                                            {{ shortDescription($banner->name, 30) }}
                                        @endif
                                    </span>
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="#" class="icon-btn editBtn" data-toggle="tooltip" title="" data-original-title="@lang('Edit')"
                                        data-title="{{ $banner->title }}"
                                        data-name="{{ $banner->name }}"
                                        data-id="{{ $banner->id }}"
                                        data-product='{{ $banner->product_id }}'
                                        data-image='{{ getImage(imagePath()["banner"]["path"]."/".$banner->image)}}'
                                        >
                                        <i class="las la-pen"></i>
                                    </a>
                                    <a href="#" class="icon-btn delete bg--danger ml-2" data-toggle="tooltip" title="" data-original-title="@lang('Delete')"
                                        data-id="{{ $banner->id }}"
                                        >
                                        <i class="las la-trash text--shadow"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($banners) }}
                </div>
            </div>
        </div>
    </div>

    {{-- ADD METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Banner')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.banner.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="title">@lang('Title') <code>@lang('Like : Get 30% Flat Discount over all Products')</code></label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            @if($products->count() > 0)
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Select Product')</code></label>
                                    <select name="product_id" class="form-control select2-basic" required>
                                        <option value="">@lang('Select One')</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ __($product->name) }}
                                                {{ $product->discount != 0 ? '-' : null }} {{ $product->discount != 0 ? showAmount($product->discount, 2).'%' : null }}
                                                {{ $product->discount != 0 ? 'Discount' : null }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-lg-12 form-group">
                                    <label for="name">@lang('Product Name')</code></label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            @endif
                            <div class="col-lg-12 form-group mt-3">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="profilePicPreview" id="display_image">
                                                        <span class="size_mention"></span>
                                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="avatar-edit mt-35px">
                                            <input type="file" class="profilePicUpload" id="profilePicUpload" accept=".png, .jpg, .jpeg" name="image" required>
                                            <label for="profilePicUpload" id='image_btn' class="bg-primary">@lang('Select Image') </label>
                                            @lang('Supproted image .jpeg, .png, .jpg, 1920x1280')
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- UPDATE METHOD MODAL --}}
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Banner')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="editTitle">@lang('Title') <code>@lang('Like : Get 30% Flat Discount over all Products')</code></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>
                            @if($products->count() > 0)
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Select Product')</code></label>
                                    <select name="product_id" class="form-control select2-basic" required>
                                        <option value="">@lang('Select One')</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ __($product->name) }}
                                                {{ $product->discount != 0 ? '-' : null }} {{ $product->discount != 0 ? showAmount($product->discount, 2).'%' : null }}
                                                {{ $product->discount != 0 ? 'Discount' : null }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-lg-12 form-group">
                                    <label for="name">@lang('Product Name')</code></label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            @endif
                            <input type="hidden" name="id">
                            <div class="col-lg-12 form-group mt-3">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="profilePicPreview" id="display_image">
                                                        <span class="size_mention"></span>
                                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="avatar-edit mt-35px">
                                            <input type="file" class="profilePicUpload" id="profilePicUpload2" accept=".png, .jpg, .jpeg" name="image">
                                            <label for="profilePicUpload2" id='image_btn' class="bg-primary">@lang('Select Image') </label>
                                            @lang('Supproted image .jpeg, .png, .jpg, 1920x1280')
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DELETE METHOD MODAL --}}
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Banner')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.banner.delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" required>
                    <div class="modal-body">
                        <p class="font-weight-bold text-center">@lang('Are you sure to delete this Banner')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn--primary box--shadow1 text--small addNew" type="submit">
        <i class="las la-plus"></i>
        @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('#display_image').hide();

            $('#image_btn').on('click', function() {
                var classNmae = $('#display_image').attr('class');
                if(classNmae != 'profilePicPreview has-image'){
                    $('#display_image').hide();
                }else{
                    $('#display_image').show();
                }
            });

            $('.remove-image').on('click', function(){
                $('.profilePicPreview').hide();
            });

            $('.addNew').on('click', function () {
                var modal = $('#addModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                modal.find('input[name=title]').val($(this).data('title'));
                modal.find('input[name=name]').val($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('select[name=product_id]').val($(this).data('product')).select2();
                modal.find('.profilePicPreview').attr('style','background-image:url('+$(this).data("image")+')');
                modal.modal('show');
            });

            $('.delete').on('click', function () {
                var modal = $('#deleteModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
