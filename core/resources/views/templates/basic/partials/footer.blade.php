 @php
     $footer = getContent('footer.content', true);
     $links = getContent('social_icon.element', false, null, true);
     $policyPages = getContent('policy_pages.element', false, null, true);
 @endphp

 <footer class="footer-section">
     <div class="footer-skyline"></div>
     
     <div class="container footer-content-wrapper">
         <div class="footer-columns">
             <!-- About Us Column -->
             <div class="footer-column">
                 <h4 class="footer-column-title">@lang('About Us')</h4>
                 <ul class="footer-column-links">
                     <li><a href="{{ route('about') }}">@lang('About Jiji')</a></li>
                     <li><a href="{{ route('contact') }}">@lang('Contact Us')</a></li>
                     <li><a href="{{ route('faq') }}">@lang('FAQ')</a></li>
                 </ul>
             </div>

             <!-- Support Column -->
             <div class="footer-column">
                 <h4 class="footer-column-title">@lang('Support')</h4>
                 <ul class="footer-column-links">
                     <li><a href="mailto:support@{{ request()->getHost() }}">support@{{ request()->getHost() }}</a></li>
                     <li><a href="{{ route('faq') }}">@lang('Safety Tips')</a></li>
                     <li><a href="{{ route('contact') }}">@lang('Contact Us')</a></li>
                 </ul>
             </div>

             <!-- Resources Column -->
             <div class="footer-column">
                 <h4 class="footer-column-title">@lang('Our Resources')</h4>
                 <ul class="footer-column-links">
                     @foreach ($policyPages as $singlePolicy)
                         <li>
                             <a href="{{ route('policy.pages', $singlePolicy->slug) }}">
                                 {{ __($singlePolicy->data_values->title) }}
                             </a>
                         </li>
                     @endforeach
                 </ul>
             </div>

             <!-- Hot Links Column -->
             <div class="footer-column">
                 <h4 class="footer-column-title">@lang('Hot Links')</h4>
                 <ul class="footer-column-links">
                     <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                     <li><a href="{{ route('products') }}">@lang('Products')</a></li>
                     <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
                 </ul>
             </div>
         </div>

         <!-- Footer Bottom -->
         <div class="footer-bottom">
             <div class="footer-social">
                 <h4 class="footer-column-title">@lang('Follow Us')</h4>
                 <ul class="social-links footer-social-links">
                     @foreach ($links as $socialLink)
                         <li>
                             <a href="{{ $socialLink->data_values->url }}" target="_blank">
                                 @php
                                     echo $socialLink->data_values->social_icon;
                                 @endphp
                             </a>
                         </li>
                     @endforeach
                 </ul>
             </div>

             @if (gs()->multi_language)
                 @php
                     $language = App\Models\Language::all();
                     $selectLang = $language->where('code', config('app.locale'))->first();
                 @endphp
                 <div class="language-selector-footer">
                     <button class="language-wrapper-footer" data-bs-toggle="dropdown" aria-expanded="false">
                         <div class="language_flag">
                             <img src="{{ getImage(getFilePath('language') . '/' . $selectLang->image, getFileSize('language')) }}"
                                 alt="flag">
                         </div>
                         <p class="language_text_select">{{ __(@$selectLang->name) }}</p>
                     </button>
                     <div class="dropdown-menu langList_dropdow py-2">
                         <ul class="langList">
                             @foreach ($language as $item)
                                 <li class="language-list">
                                     <a href="{{ route('lang', $item->code) }}">
                                         <img src="{{ getImage(getFilePath('language') . '/' . $item->image, getFileSize('language')) }}"
                                             alt="flag" style="margin-right: 8px; height: 18px;">
                                         {{ __($item->name) }}
                                     </a>
                                 </li>
                             @endforeach
                         </ul>
                     </div>
                 </div>
             @endif
         </div>

         <!-- Copyright -->
         <p class="copy-rights">@lang('Copyright') &copy; {{ date('Y') }} {{ __(gs('sitename')) }} @lang('All Rights Reserved')</p>
     </div>
 </footer>

 @push('script')
 <script>
     $(document).ready(function() {
         const $mainlangList = $(".langList");
         const $langBtn = $(".language-wrapper-footer");
         const $langListItem = $mainlangList.children();
         $langListItem.each(function() {
             const $innerItem = $(this);
             $innerItem.on("click", function(e) {
                 e.preventDefault();
             });
         });
     });
 </script>
@endpush
