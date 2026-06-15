/* ============================================================
   pitchbook.js — Turn.js Single-Page Flipbook for PPP KP

   Strategy:
   - display:'double' but we pass width = ONE page (16:9)
   - turn.js will show only ONE page at a time because the
     total width equals a single page width — no blank half
   - This is the cleanest approach: no clipping, no shifting
     needed. turn.js simply has no room for a second page.

   DEPENDS ON: jquery.min.js, jquery-ui.min.js, turn.min.js
   TOTAL_PAGES must be set as a global before this runs.
   ============================================================ */

/* ── Helpers ──────────────────────────────────────────────── */
function numberOfViews(book) {
    return book.turn('pages');
}

function getViewNumber(book, page) {
    return page || book.turn('page');
}

function updatePageCounter(page) {
    $('#currentPage').text(page);
}

function playFlipSound() {
    var snd = document.getElementById('flipSound');
    if (snd) { snd.currentTime = 0; snd.play().catch(function () {}); }
}

/* ── Size calculator: ONE page at 16:9 ─────────────────────── */
function calcBookSize() {
    var availW = Math.min(window.innerWidth - 32, 850);
    var availH = window.innerHeight - 90;

    var pageH = availH;
    var maxW = 500;
    var pageW = Math.round(pageH * 16 / 9);

    if (pageW > maxW) { pageW = maxW; pageH = Math.round(pageW * 9 / 16); }
    if (pageW > availW) {
        pageW = availW;
        pageH = Math.round(pageW * 9 / 16);
    }

    return { w: pageW, h: pageH };
}

/* ── addPage ─────────────────────────────────────────────── */
function addPage(page, book) {
    book.turn('addPage',
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

/* ── Preload ─────────────────────────────────────────────── */
function preloadImages(start, end) {
    for (var i = start; i <= Math.min(end, TOTAL_PAGES); i++) {
        (new Image()).src = '/images/Pitchbook/Slide' + i + '.PNG';
    }
}

/* ══════════════════════════════════════════════════════════
   MAIN
   ══════════════════════════════════════════════════════════ */
function loadApp() {

    var flipbook = $('#flipbook');
    var size     = calcBookSize();

    /* Both wrapper and flipbook = exact one-page size */
    $('#book-zoom').css({ width: size.w, height: size.h });
    $('#slider-bar').css({ width: size.w });
    flipbook.css({ width: size.w, height: size.h });

    flipbook.turn({
        width:        size.w,       /* ONE page width — no room for blank half */
        height:       size.h,
        duration:     650,
        gradients:    true,
        acceleration: true,
        display:      'single',     /* single page flip animation */
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
                playFlipSound();
            },

            turned: function (e, page) {
                updatePageCounter(page);
                if (typeof $.fn.slider !== 'undefined') {
                    $('#slider').slider('value', page);
                }
                preloadImages(page + 1, page + 10);
            },

            missing: function (e, pages) {
                for (var i = 0; i < pages.length; i++) {
                    addPage(pages[i], $(this));
                }
            }
        }
    });

    /* ── Slider ─────────────────────────────────────────── */
    if (typeof $.fn.slider !== 'undefined') {
        $('#slider').slider({
            min: 1,
            max: TOTAL_PAGES,
            slide: function (event, ui) { updatePageCounter(ui.value); },
            stop:  function (event, ui) { flipbook.turn('page', ui.value); }
        });
    } else {
        $('#slider-bar').hide();
    }

    /* ── Mousewheel ─────────────────────────────────────── */
    $('#book-zoom').on('wheel', function (e) {
        e.preventDefault();
        var d = e.originalEvent.deltaX || e.originalEvent.deltaY;
        if      (d > 20)  flipbook.turn('next');
        else if (d < -20) flipbook.turn('previous');
    });

    /* ── Keyboard ───────────────────────────────────────── */
    $(document).keydown(function (e) {
        switch (e.keyCode) {
            case 37: flipbook.turn('previous');          e.preventDefault(); break;
            case 39: flipbook.turn('next');              e.preventDefault(); break;
            case 36: flipbook.turn('page', 1);           e.preventDefault(); break;
            case 35: flipbook.turn('page', TOTAL_PAGES); e.preventDefault(); break;
        }
    });

    /* ── Nav buttons ────────────────────────────────────── */
    $('#prevBtn').on('click', function () { flipbook.turn('previous'); });
    $('#nextBtn').on('click', function () { flipbook.turn('next'); });

    /* ── Resize ─────────────────────────────────────────── */
    $(window).on('resize', function () {
        var s = calcBookSize();
        $('#book-zoom').css({ width: s.w, height: s.h });
        $('#slider-bar').css({ width: s.w });
        flipbook.css({ width: s.w, height: s.h });
        flipbook.turn('size', s.w, s.h);
        flipbook.turn('center');
    });

    /* ── Reveal ─────────────────────────────────────────── */
    $('#totalPages').text(TOTAL_PAGES);
    updatePageCounter(1);
    $('#canvas').css({ visibility: 'visible' });
    setTimeout(function () { $('#loading').fadeOut(400); }, 400);
    preloadImages(1, 20);
}

/* ── Bootstrap ──────────────────────────────────────────── */
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