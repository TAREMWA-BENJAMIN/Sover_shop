 @php
     $footer = getContent('footer.content', true);
     $links = getContent('social_icon.element', false, null, true);
     $policyPages = getContent('policy_pages.element', false, null, true);
 @endphp

 <div class="container p-0">
     <footer class="footer-section">
         <div class="footer-wrapper">
             <ul class="footer-links">
                 <li><a href="{{ route('about') }}">@lang('About')</a></li>
                 <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
                 <li><a href="{{ route('faq') }}">@lang('Faq')</a></li>
                 @foreach ($policyPages as $singlePolicy)
                     <li>
                         <a href="{{ route('policy.pages', $singlePolicy->slug) }}">
                             {{ __($singlePolicy->data_values->title) }}
                         </a>
                     </li>
                 @endforeach

                 @if (gs()->multi_language)
                     @php
                         $language = App\Models\Language::all();
                         $selectLang = $language->where('code', config('app.locale'))->first();
                     @endphp
                     <li class="language dropdown">
                         <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                             <div class="language-content">
                                 <div class="language_flag">
                                     <img src="{{ getImage(getFilePath('language') . '/' . $selectLang->image, getFileSize('language')) }}"
                                         alt="flag">
                                 </div>
                                 <p class="language_text_select">{{ __(@$selectLang->name) }}</p>
                             </div>
                             <span class="collapse-icon"><i class="las la-angle-down"></i></span>
                         </button>
                         <div class="dropdown-menu langList_dropdow py-2" style="">
                             <ul class="langList">
                                 @foreach ($language as $item)
                                     <li class="language-list">
                                         <a class="language-list__thumb" href="{{ route('lang', $item->code) }}">
                                             <div class="language_flag">
                                                 <img src="{{ getImage(getFilePath('language') . '/' . $item->image, getFileSize('language')) }}"
                                                     alt="flag">
                                             </div>

                                         </a>
                                         <a class="language-list__text" href="{{ route('lang', $item->code) }}">
                                             <p
                                                 class="language_text @if (session('lang') == $item->code) custom--dropdown__selected @endif">
                                                 {{ __($item->name) }}</p>
                                         </a>
                                     </li>
                                 @endforeach
                             </ul>
                         </div>
                     </li>
                 @endif
             </ul>
             <ul class="social-links">
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
             <p class="copy-rights">@lang('Copyright') &copy; {{ date('Y') }} {{ __(gs('sitename')) }}
                 @lang('All Rights Reserved')</p>
         </div>
     </footer>
 </div>
 @push('script')
 <script>
     $(document).ready(function() {
         const $mainlangList = $(".langList");
         const $langBtn = $(".language-content");
         const $langListItem = $mainlangList.children();
         $langListItem.each(function() {
             const $innerItem = $(this);
             const $languageText = $innerItem.find(".language_text");
             const $languageFlag = $innerItem.find(".language_flag");
             $innerItem.on("click", function(e) {
                 $langBtn.find(".language_text_select").text($languageText.text());
                 $langBtn.find(".language_flag").html($languageFlag.html());
             });
         });
     });
 </script>
@endpush
