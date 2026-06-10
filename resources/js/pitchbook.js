/* ============================================================
   pitchbook.js — Turn.js Docs-style Flipbook for PPP KP
   Follows the official turn.js 4th-release "docs" sample logic
   exactly: CSS-driven sizing check, mousewheel plugin, Hash
   URI routing, animated class, addPage on missing.
   ============================================================

   DEPENDS ON (loaded before this file):
     jquery.min.js
     jquery-ui-1.8.20.custom.min.js
     jquery.mousewheel.min.js
     modernizr.2.5.3.min.js
     hash.js
     turn.min.js (loaded by yepnope in the blade template)
     pitchbook.js  ← this file (loaded after yepnope completes)

   TOTAL_PAGES  must be set as a global var before this runs.
   ============================================================ */

/* ── Helpers (same as official sample) ───────────────────── */
function numberOfViews(book) {
    return Math.ceil((book.turn('pages') + 2) / 2);
}

function getViewNumber(book, page) {
    return Math.ceil(((page || book.turn('page')) + 1) / 2);
}

function updatePageCounter(page) {
    $('#currentPage').text(page);
}

/* ── addPage: dynamically injects a page into the flipbook
      when turn.js fires the "missing" event — mirrors the
      official sample's addPage helper.                        */
function addPage(page, book) {
    var obj = book.turn('addPage',
        $('<div/>', { 'class': 'page' }).append(
            $('<img/>', {
                src: '/images/Pitchbook/Slide' + page + '.PNG',
                alt: 'Slide ' + page,
                draggable: false
            })
        ),
        page
    );
}

/* ── Slider bar visual feedback (mirrors moveBar in sample) ─ */
function moveBar(moving) {
    /* The official sample dims the slider while the page turns.
       Kept minimal here — extend if you want the opacity effect. */
}

function setPreview(value) {
    /* Thumbnail preview strip — requires a preview.jpg sprite.
       Left as a no-op; add your own implementation if needed.  */
}

function updateTabs() {
    /* Keeps left/right tab states in sync with current page.
       Extend if you add tab-based navigation.                  */
}

/* ══════════════════════════════════════════════════════════════
   MAIN: loadApp
   Called by yepnope's `complete` callback once turn.js
   (and jQuery UI CSS) have been injected into the page.
   ══════════════════════════════════════════════════════════════ */
function loadApp() {

    var flipbook = $('.sample-docs');

    /* ── Official sample guard: wait until CSS gives the element
         real dimensions before initialising turn.js             */
    if (flipbook.width() === 0 || flipbook.height() === 0) {
        setTimeout(loadApp, 10);
        return;
    }

    /* ── Mousewheel (uses jquery.mousewheel plugin, exact match
         to the official sample)                                 */
    $('#book-zoom').mousewheel(function (event, delta, deltaX, deltaY) {

        var data      = $(this).data(),
            step      = 30,
            fb        = $('.sample-docs'),
            actualPos = $('#slider').slider('value') * step;

        if (typeof data.scrollX === 'undefined') {
            data.scrollX    = actualPos;
            data.scrollPage = fb.turn('page');
        }

        data.scrollX = Math.min(
            $('#slider').slider('option', 'max') * step,
            Math.max(0, data.scrollX + deltaX)
        );

        var actualView = Math.round(data.scrollX / step),
            page       = Math.min(fb.turn('pages'), Math.max(1, actualView * 2 - 2));

        if ($.inArray(data.scrollPage, fb.turn('view', page)) === -1) {
            data.scrollPage = page;
            fb.turn('page', page);
        }

        if (data.scrollTimer) clearInterval(data.scrollTimer);

        data.scrollTimer = setTimeout(function () {
            data.scrollX    = undefined;
            data.scrollPage = undefined;
            data.scrollTimer = undefined;
        }, 1000);
    });

    /* ── Slider ──────────────────────────────────────────────── */
    $('#slider').slider({
        min: 1,
        max: 100,   /* corrected below after turn() init */

        start: function (event, ui) {
            if (!window._thumbPreview) {
                window._thumbPreview = $('<div/>', { 'class': 'thumbnail' }).html('<div></div>');
                setPreview(ui.value);
                window._thumbPreview.appendTo($(ui.handle));
            } else {
                setPreview(ui.value);
            }
            moveBar(false);
        },

        slide: function (event, ui) {
            setPreview(ui.value);
            /* Live page-counter update while dragging */
            updatePageCounter(Math.max(1, ui.value * 2 - 2));
        },

        stop: function () {
            if (window._thumbPreview) window._thumbPreview.removeClass('show');
            $('.sample-docs').turn('page', Math.max(1, $(this).slider('value') * 2 - 2));
        }
    });

    /* ── URI / Hash routing (exact copy from official sample) ── */
    Hash.on('^page\\/([0-9]*)$', {
        yep: function (path, parts) {
            var page = parts[1];
            if (page !== undefined) {
                if ($('.sample-docs').turn('is'))
                    $('.sample-docs').turn('page', page);
            }
        },
        nop: function (path) {
            if ($('.sample-docs').turn('is'))
                $('.sample-docs').turn('page', 1);
        }
    });

    /* ── Keyboard (← → arrows) ──────────────────────────────── */
    $(document).keydown(function (e) {
        switch (e.keyCode) {
            case 37: $('.sample-docs').turn('previous'); e.preventDefault(); break;
            case 39: $('.sample-docs').turn('next');     e.preventDefault(); break;
            case 36: $('.sample-docs').turn('page', 1);              e.preventDefault(); break;
            case 35: $('.sample-docs').turn('page', TOTAL_PAGES);    e.preventDefault(); break;
        }
    });

    /* ── Nav buttons ─────────────────────────────────────────── */
    $('#prevBtn').on('click', function () { $('.sample-docs').turn('previous'); });
    $('#nextBtn').on('click', function () { $('.sample-docs').turn('next'); });

    /* ══════════════════════════════════════════════════════════
       CREATE THE FLIPBOOK — matches official sample options
       ══════════════════════════════════════════════════════════ */
    flipbook.turn({
        elevation:    50,
        acceleration: true,          /* hardware acceleration on */
        gradients:    true,
        autoCenter:   true,
        duration:     700,
        display:      'double',
        pages:        TOTAL_PAGES,

        when: {

            turning: function (e, page, view) {
                var book        = $(this),
                    currentPage = book.turn('page'),
                    pages       = book.turn('pages');

                /* Hard-cover guard — same as official sample */
                if (currentPage > 3 && currentPage < pages - 3) {
                    if (page === 1) {
                        book.turn('page', 2).turn('stop').turn('page', page);
                        e.preventDefault(); return;
                    } else if (page === pages) {
                        book.turn('page', pages - 1).turn('stop').turn('page', page);
                        e.preventDefault(); return;
                    }
                } else if (page > 3 && page < pages - 3) {
                    if (currentPage === 1) {
                        book.turn('page', 2).turn('stop').turn('page', page);
                        e.preventDefault(); return;
                    } else if (currentPage === pages) {
                        book.turn('page', pages - 1).turn('stop').turn('page', page);
                        e.preventDefault(); return;
                    }
                }

                Hash.go('page/' + page).update();

                if (page === 1 || page === pages)
                    $('.sample-docs .tabs').hide();
            },

            turned: function (e, page, view) {
                var book = $(this);

                updatePageCounter(page);
                $('#slider').slider('value', getViewNumber(book, page));

                if (page !== 1 && page !== book.turn('pages'))
                    $('.sample-docs .tabs').fadeIn(500);
                else
                    $('.sample-docs .tabs').hide();

                book.turn('center');
                updateTabs();
            },

            start: function (e, pageObj) {
                moveBar(true);
            },

            end: function (e, pageObj) {
                var book = $(this);
                setTimeout(function () {
                    $('#slider').slider('value', getViewNumber(book));
                }, 1);
                moveBar(false);
            },

            missing: function (e, pages) {
                for (var i = 0; i < pages.length; i++)
                    addPage(pages[i], $(this));
            }
        }

    }).turn('page', 2);  /* open to page 2 — both hard covers visible */

    /* Correct slider max now that we know the real page count */
    $('#slider').slider('option', 'max', numberOfViews(flipbook));

    flipbook.addClass('animated');

    /* ── Resize handler ──────────────────────────────────────── */
    $(window).on('resize', function () {
        var s = calcBookSize();
        $('#book-zoom').css({ width: s.w, height: s.h });
        $('.sample-docs').css({ width: s.w, height: s.h });
        $('#slider-bar').css({ width: s.w });
        flipbook.turn('size', s.w, s.h);
        flipbook.turn('center');
    });

    /* ── Reveal ──────────────────────────────────────────────── */
    $('#totalPages').text(TOTAL_PAGES);
    updatePageCounter(1);
    $('#canvas').css({ visibility: 'visible' });
    setTimeout(function () { $('#loading').fadeOut(400); }, 300);
}

/* ── Size calculator ─────────────────────────────────────────
   Each slide is 16:9. Double-page spread = 32:9.
   Fit by height first; fall back to width constraint.         */
function calcBookSize() {
    var availW = window.innerWidth  - 32;   /* 16 px each side   */
    var availH = window.innerHeight - 90;   /* nav + slider + gap */

    var bookH = availH;
    var bookW = Math.round(bookH * 32 / 9);

    if (bookW > availW) {
        bookW = availW;
        bookH = Math.round(bookW * 9 / 32);
    }

    return { w: bookW, h: bookH };
}