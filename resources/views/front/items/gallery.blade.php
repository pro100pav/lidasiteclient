<section class="u-align-center u-clearfix u-container-align-center u-custom-color-2 u-section-11" id="sec-e6d6">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-expanded-width u-gallery u-layout-grid u-lightbox u-show-text-on-hover u-gallery-1">
            <div class="u-gallery-inner u-gallery-inner-1">
                @if ($page->image)
                    @foreach (unserialize($page->image) as $image)
                    <div class="u-effect-fade u-gallery-item u-gallery-item-1">
                        <div class="u-back-slide">
                            <img class="u-back-image u-expanded"
                                src="{{$image}}">
                        </div>
                        <div class="u-over-slide u-shading u-over-slide-1"></div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <h5 class="u-text u-text-default u-text-1"> {{$page->adres}}<br>Время работы: ежедневно с 10.00
            до 03:00
        </h5>
        <a href="#"
            class="u-active-none u-btn u-btn-rectangle u-button-style u-hover-none u-none u-btn-1"><span
                class="u-icon"><svg class="u-svg-content" viewBox="0 0 405.333 405.333" x="0px" y="0px"
                    style="width: 1em; height: 1em;">
                    <path
                        d="M373.333,266.88c-25.003,0-49.493-3.904-72.704-11.563c-11.328-3.904-24.192-0.896-31.637,6.699l-46.016,34.752    c-52.8-28.181-86.592-61.952-114.389-114.368l33.813-44.928c8.512-8.512,11.563-20.971,7.915-32.64    C142.592,81.472,138.667,56.96,138.667,32c0-17.643-14.357-32-32-32H32C14.357,0,0,14.357,0,32    c0,205.845,167.488,373.333,373.333,373.333c17.643,0,32-14.357,32-32V298.88C405.333,281.237,390.976,266.88,373.333,266.88z">
                    </path>
                </svg></span>&nbsp;{{$page->phone}}
        </a>
    </div>
</section>