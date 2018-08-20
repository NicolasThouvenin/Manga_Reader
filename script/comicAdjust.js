/**
 * Adapt the display for small devices
 * @param {MediaQueryList object} x
 * @returns {undefined}
 */
function homeSmallAdjust(x) {
    if (x.matches) {
        header("s");
        cover = document.getElementById("cover");
        cover.width = "150";
        cover.height = "225";
    }
}

/**
 * Adapt the display for large devices
 * @param {MediaQueryList object} x
 * @returns {undefined}
 */
function homeLargeAdjust(x) {
    if (x.matches) {
        header("l");
        cover = document.getElementById("cover");
        cover.width = "250";
        cover.height = "375";
    }
}

/**
 * Adapt the display for medium devices
 * @param {MediaQueryList object} x
 * @returns {undefined}
 */
function homeMediumAdjust(x) {
    if (x.matches) {
        header("m");
        cover = document.getElementById("cover");
        cover.width = "250";
        cover.height = "375";
    }
}

var s = window.matchMedia("(max-width: 640px)");
var m = window.matchMedia("(min-width: 641px) and (max-width: 1008px)");
var l = window.matchMedia("(min-width: 1008px)");

/* Call listener function at run time
 * And attach it on state changes
 */
homeSmallAdjust(s);
s.addListener(homeSmallAdjust);

homeMediumAdjust(m);
m.addListener(homeMediumAdjust);

homeLargeAdjust(l);
l.addListener(homeLargeAdjust);