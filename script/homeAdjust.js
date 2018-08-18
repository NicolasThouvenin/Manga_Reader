function homeSmallAdjust(x) {
    header(x);
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
var l = window.matchMedia("(min-width: 1008px)");

homeSmallAdjust(s); // Call listener function at run time
s.addListener(homeSmallAdjust); // Attach listener function on state changes

homeLargeAdjust(l); // Call listener function at run time
l.addListener(homeLargeAdjust); // Attach listener function on state changes