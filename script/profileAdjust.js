function homeSmallAdjust(x) {
    if (x.matches) {
        header("s");
        avatar = document.getElementById("avatar_pic");
        avatar.width = "150";
        avatar.height = "150";
        console.log(avatar);
    }
}

function homeLargeAdjust(x) {
    if (x.matches) {
        header("l");
        avatar = document.getElementById("avatar_pic");
        avatar.width = "250";
        avatar.height = "250";
        console.log(avatar);
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