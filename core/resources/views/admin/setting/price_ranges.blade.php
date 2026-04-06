@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-7">
        <div class="card b-radius--10">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Manage Price Range Filters')</h5>
                <p class="text-muted small mt-1 mb-0">@lang('These ranges appear on the products page to help customers filter by price.')</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.setting.price.ranges.update') }}" method="POST">
                    @csrf
                    <div id="price-ranges-wrapper">
                        @foreach($priceRanges as $index => $range)
                        <div class="price-range-row d-flex align-items-center gap-2 mb-3">
                            <input type="text" name="label[]" class="form-control"
                                placeholder="Label (e.g. Under 50K)" value="{{ $range['label'] }}" required>
                            <input type="number" name="min[]" class="form-control"
                                placeholder="Min" value="{{ $range['min'] }}" min="0" required>
                            <input type="number" name="max[]" class="form-control"
                                placeholder="Max (leave 0 for no limit)" value="{{ $range['max'] ?? 0 }}" min="0">
                            <button type="button" class="btn btn-sm btn-outline--danger remove-row" title="Remove">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" id="addRangeBtn" class="btn btn-sm btn-outline--primary mb-4">
                        <i class="las la-plus"></i> @lang('Add Range')
                    </button>

                    <div class="d-flex">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Save Price Ranges')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card b-radius--10">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('Preview')</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">@lang('This is how the price filter will look on the products page:')</p>
                <ul class="list-group list-group-flush" id="previewList">
                    @foreach($priceRanges as $range)
                        <li class="list-group-item d-flex align-items-center gap-2 py-2">
                            <i class="las la-circle text-muted"></i>
                            <span>{{ $range['label'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
(function($){
    $('#addRangeBtn').on('click', function(){
        var row = `<div class="price-range-row d-flex align-items-center gap-2 mb-3">
            <input type="text" name="label[]" class="form-control" placeholder="Label (e.g. Under 50K)" required>
            <input type="number" name="min[]" class="form-control" placeholder="Min" min="0" value="0" required>
            <input type="number" name="max[]" class="form-control" placeholder="Max (0 = no limit)" min="0" value="0">
            <button type="button" class="btn btn-sm btn-outline--danger remove-row" title="Remove">
                <i class="las la-times"></i>
            </button>
        </div>`;
        $('#price-ranges-wrapper').append(row);
    });

    $(document).on('click', '.remove-row', function(){
        $(this).closest('.price-range-row').remove();
    });
})(jQuery);
</script>
@endpush
