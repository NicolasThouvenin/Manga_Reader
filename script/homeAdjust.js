function homeSmallAdjust(x) {
    if (x.matches) {
        header("s");
        article = document.querySelectorAll("article > a > img");
        for (i = 0; i < article.length; i++) {
            console.log(article[i]);
            article[i].width = "100";
            article[i].height = "150";
        }
    }
}

function homeLargeAdjust(x) {
    if (x.matches) {
        header("l");
        article = document.querySelectorAll("article > a > img");
        for (i = 0; i < article.length; i++) {
            console.log(article[i]);
            article[i].width = "150";
            article[i].height = "225";
        }
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