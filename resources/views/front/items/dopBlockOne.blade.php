<section class="u-clearfix u-container-align-left u-custom-color-2 u-lightbox u-section-6" id="carousel_60ed">
    <div class="u-clearfix u-sheet u-sheet-1">
        <h2 class="u-align-center-lg u-align-center-md u-align-center-sm u-align-center-xs u-align-left-xl u-text u-text-default u-text-1"
            data-animation-name="customAnimationIn" data-animation-duration="1500">Караоке лофт {{$city2}}
        </h2>
        <p class="u-align-center-lg u-align-center-md u-align-center-sm u-align-center-xs u-align-left-xl u-text u-text-default u-text-2"
            data-animation-name="customAnimationIn" data-animation-duration="1500" data-animation-delay="500">
            Наша караоке комната {{$city2}}</p>
        <div class="u-expanded-width u-layout-horizontal u-list u-list-1">
            <div class="u-repeater u-repeater-1">
                @if ($page->gallery2)
                    @foreach (unserialize($page->gallery2) as $gal)
                    <div class="u-container-style u-image u-list-item u-radius u-repeater-item u-shading u-image-1"
                        data-image-width="4000" data-image-height="1800"
                        style="background-image:linear-gradient(0deg, rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('{{$gal}}');">
                        <div class="u-container-layout u-similar-container u-container-layout-1"></div>
                    </div>
                    @endforeach
                @endif
            </div>
            <a class="u-absolute-vcenter u-gallery-nav u-gallery-nav-prev u-grey-70 u-icon-circle u-opacity u-opacity-70 u-spacing-10 u-text-white u-gallery-nav-1"
                href="#" role="button">
                <span aria-hidden="true">
                    <svg viewBox="0 0 451.847 451.847">
                        <path d="M97.141,225.92c0-8.095,3.091-16.192,9.259-22.366L300.689,9.27c12.359-12.359,32.397-12.359,44.751,0
c12.354,12.354,12.354,32.388,0,44.748L173.525,225.92l171.903,171.909c12.354,12.354,12.354,32.391,0,44.744
c-12.354,12.365-32.386,12.365-44.745,0l-194.29-194.281C100.226,242.115,97.141,234.018,97.141,225.92z"></path>
                    </svg>
                </span>
                <span class="sr-only">
                    <svg viewBox="0 0 451.847 451.847">
                        <path d="M97.141,225.92c0-8.095,3.091-16.192,9.259-22.366L300.689,9.27c12.359-12.359,32.397-12.359,44.751,0
c12.354,12.354,12.354,32.388,0,44.748L173.525,225.92l171.903,171.909c12.354,12.354,12.354,32.391,0,44.744
c-12.354,12.365-32.386,12.365-44.745,0l-194.29-194.281C100.226,242.115,97.141,234.018,97.141,225.92z"></path>
                    </svg>
                </span>
            </a>
            <a class="u-absolute-vcenter u-gallery-nav u-gallery-nav-next u-grey-70 u-icon-circle u-opacity u-opacity-70 u-spacing-10 u-text-white u-gallery-nav-2"
                href="#" role="button">
                <span aria-hidden="true">
                    <svg viewBox="0 0 451.846 451.847">
                        <path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744
L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284
c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"></path>
                    </svg>
                </span>
                <span class="sr-only">
                    <svg viewBox="0 0 451.846 451.847">
                        <path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744
L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284
c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"></path>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>