function homeSmallAdjust(x) {
    if (x.matches) {
        header("s");
        cover = document.getElementById("cover");
        cover.width = "150";
        cover.height = "225";
        console.log(cover);
    }
}

function homeLargeAdjust(x) {
    if (x.matches) {
        header("l");
        cover = document.getElementById("cover");
        cover.width = "250";
        cover.height = "375";
        console.log(cover);
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

homeLargeAdjust(m);
m.addListener(homeLargeAdjust);

homeLargeAdjust(l);
l.addListener(homeLargeAdjust);