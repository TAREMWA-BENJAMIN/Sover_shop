@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-section pt-50 pb-50">
        <div class="row g-3 justify-content-center">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-10">
                    <div class="post-item">
                        <div class="post-thumb">
                            <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '800x510') }}" alt="Blog">
                        </div>
                        <div class="post-content">
                            <span class="meta-date">{{ showDateTime($blog->created_at, 'd M, Y') }}</span>
                            <h4 class="title">
                                <a href="{{ route('blog.details', $blog->slug) }}">
                                    {{ strLimit($blog->data_values->title, 45) }}
                                </a>
                            </h4>
                        </div>
                        <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($blogs->hasPages())
            <div class="mt-4">
                {{ paginateLinks($blogs) }}
            </div>
        @endif

    </section>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
