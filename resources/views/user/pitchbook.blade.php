<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PPP KP - Digital Pitchbook' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/pitchbook.css'])

    {{-- LOAD ORDER: jQuery → jQuery UI → turn.js  (plain scripts, NOT via Vite) --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/turn.min.js') }}"></script>
</head>

{{-- No Tailwind bg class here — pitchbook.css handles the light gray bg --}}
<body>

    <!-- Loading -->
    <div id="loading">
        <div id="loading-spinner"></div>
        <div id="loading-text">Loading Pitchbook&hellip;</div>
    </div>

    <!-- Canvas -->
    <div id="canvas" style="visibility:hidden;">
        <div id="book-zoom">
            <div id="flipbook">
                @for ($i = 1; $i <= 80; $i++)
                    <div class="page" data-page="{{ $i }}">
                        <img
                            src="{{ asset('images/Pitchbook/Slide' . $i . '.PNG') }}"
                            alt="Slide {{ $i }}"
                            loading="{{ $i <= 6 ? 'eager' : 'lazy' }}"
                            draggable="false"
                        />
                    </div>
                @endfor
            </div>
        </div>

        <!-- Slider -->
        <div id="slider-bar">
            <div id="slider"></div>
        </div>
    </div>

    <!-- Nav -->
    <nav id="nav-bar">
        <button id="prevBtn">&#9664; Prev</button>
        <div id="page-counter">
            Page <span id="currentPage">1</span> / <span id="totalPages">80</span>
        </div>
        <button id="nextBtn">Next &#9654;</button>
    </nav>

    <script>
    var TOTAL_PAGES = 80;

    /*
     * Each slide is landscape 16:9.
     * Double-page spread = 2 pages side by side → book ratio = 32:9.
     *
     * Strategy: fit by HEIGHT first (height is the tight constraint for
     * landscape content). The width then naturally equals the image width
     * (i.e. each page is exactly one 16:9 slide wide). If the result is
     * wider than the viewport we scale down by width instead.
     */
    function calcBookSize() {
        var availW = window.innerWidth  - 32;   // 16px each side
        var availH = window.innerHeight - 100;  // nav + slider + gap

        // Fit by height first: book_w = book_h × (32/9)
        var bookH = availH;
        var bookW = Math.round(bookH * 32 / 9);

        // If wider than screen, constrain by width
        if (bookW > availW) {
            bookW = availW;
            bookH = Math.round(bookW * 9 / 32);
        }

        return { w: bookW, h: bookH };
    }

    function numberOfViews(book) {
        return Math.ceil((book.turn('pages') + 2) / 2);
    }
    function getViewNumber(book, page) {
        return Math.ceil(((page || book.turn('page')) + 1) / 2);
    }
    function updatePageCounter(page) {
        $('#currentPage').text(page);
    }
    function preloadImages(start, end) {
        for (var i = start; i <= Math.min(end, TOTAL_PAGES); i++) {
            (new Image()).src = '/images/Pitchbook/Slide' + i + '.PNG';
        }
    }

    function loadApp() {
        var flipbook = $('#flipbook');
        var size     = calcBookSize();

        // Apply dimensions
        $('#book-zoom').css({ width: size.w, height: size.h });
        flipbook.css({ width: size.w, height: size.h });
        $('#slider-bar').css({ width: size.w });

        // Init turn.js
        flipbook.turn({
            width:        size.w,
            height:       size.h,
            duration:     650,
            gradients:    true,
            acceleration: true,
            display:      'double',
            autoCenter:   true,
            elevation:    50,
            pages:        TOTAL_PAGES,

            when: {
                turning: function (e, page) {
                    var book    = $(this);
                    var current = book.turn('page');
                    var pages   = book.turn('pages');
                    if (current > 3 && current < pages - 3) {
                        if (page === 1) {
                            book.turn('page', 2).turn('stop').turn('page', page);
                            e.preventDefault(); return;
                        } else if (page === pages) {
                            book.turn('page', pages - 1).turn('stop').turn('page', page);
                            e.preventDefault(); return;
                        }
                    }
                },
                turned: function (e, page) {
                    updatePageCounter(page);
                    if (typeof $.fn.slider !== 'undefined') {
                        $('#slider').slider('value', getViewNumber($(this), page));
                    }
                    $(this).turn('center');
                    preloadImages(page + 2, page + 12);
                },
                missing: function (e, pages) {
                    console.warn('Missing pages:', pages);
                }
            }
        });

        // Slider
        if (typeof $.fn.slider !== 'undefined') {
            $('#slider').slider({
                min: 1,
                max: numberOfViews(flipbook),
                slide: function (event, ui) {
                    updatePageCounter(Math.max(1, ui.value * 2 - 2));
                },
                stop: function (event, ui) {
                    flipbook.turn('page', Math.max(1, ui.value * 2 - 2));
                }
            });
        } else {
            $('#slider-bar').hide();
        }

        // Mousewheel
        $('#book-zoom').on('wheel', function (e) {
            e.preventDefault();
            var d = e.originalEvent.deltaX || e.originalEvent.deltaY;
            if      (d > 20)  flipbook.turn('next');
            else if (d < -20) flipbook.turn('previous');
        });

        // Keyboard
        $(document).keydown(function (e) {
            switch (e.keyCode) {
                case 37: flipbook.turn('previous');         e.preventDefault(); break;
                case 39: flipbook.turn('next');             e.preventDefault(); break;
                case 36: flipbook.turn('page', 1);          e.preventDefault(); break;
                case 35: flipbook.turn('page',TOTAL_PAGES); e.preventDefault(); break;
            }
        });

        // Buttons
        $('#prevBtn').on('click', function () { flipbook.turn('previous'); });
        $('#nextBtn').on('click', function () { flipbook.turn('next'); });

        // Resize
        $(window).on('resize', function () {
            var s = calcBookSize();
            $('#book-zoom').css({ width: s.w, height: s.h });
            $('#slider-bar').css({ width: s.w });
            flipbook.turn('size', s.w, s.h);
            flipbook.turn('center');
        });

        // Reveal
        $('#totalPages').text(TOTAL_PAGES);
        updatePageCounter(1);
        $('#canvas').css({ visibility: 'visible' });
        setTimeout(function () { $('#loading').fadeOut(400); }, 400);
        preloadImages(1, 20);
    }

    $(document).ready(function () {
        if (typeof $.fn.turn === 'undefined') {
            $('#loading').html(
                '<p style="color:#333;font-family:sans-serif;text-align:center;padding:2rem;">' +
                '&#9888; <strong>turn.js not loaded.</strong><br><br>' +
                '<small>Check that <code>public/js/turn.min.js</code> exists.</small></p>'
            );
            return;
        }
        loadApp();
    });
    </script>

</body>
</html>