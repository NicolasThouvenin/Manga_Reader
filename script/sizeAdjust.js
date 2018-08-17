document.getElementById("searchbar").style.display = "none";
function small(x) {
    if (x.matches) { // If media query matches
        document.getElementById("add").value = "+";
        document.getElementsByClassName("smallLog")[0].style.display = "inline-block";
        if (document.getElementsByClassName("registerButton")[0]) {
            document.getElementsByClassName("registerButton")[0].style.display = "none";
            document.getElementsByClassName("regularButton")[0].style.display = "none";
        } else {
            document.getElementsByClassName("userName")[0].style.display = "none";
            document.getElementsByClassName("userName")[1].style.display = "none";
        }
    } else {

        document.getElementById("add").value = "Add Creation";
        document.getElementsByClassName("smallLog")[0].style.display = "none";
        if (document.getElementsByClassName("registerButton")[0]) {
            document.getElementsByClassName("registerButton")[0].style.display = "inline-block";
            document.getElementsByClassName("regularButton")[0].style.display = "inline-block";
        } else {
            document.getElementsByClassName("userName")[0].style.display = "inline-block";
            document.getElementsByClassName("userName")[1].style.display = "inline-block";
        }
    }
}

var x = window.matchMedia("(max-width: 640px)");
small(x); // Call listener function at run time
x.addListener(small); // Attach listener function on state changes

function toggleUserTab() {
    /* If the searchbar is open, close it*/
    if (document.getElementById("searchbar").style.display !== "none") {
        document.getElementById("searchbar").style.display = "none";
    }
    if (document.getElementById("userTab").style.display === "none") {
        document.getElementById("userTab").style.display = "block";
        document.getElementsByClassName("userName")[0].style.display = "inline-block";
        document.getElementsByClassName("userName")[1].style.display = "inline-block";
    } else {
        document.getElementById("userTab").style.display = "none";
        document.getElementsByClassName("userName")[0].style.display = "none";
        document.getElementsByClassName("userName")[1].style.display = "none";
    }
}

function toggleSearch() {
    /* If the usertab is open, close it*/
    if (document.getElementsByClassName("connected")[0]) {
        if (document.getElementById("userTab").style.display !== "none") {
            document.getElementById("userTab").style.display = "none";
            document.getElementsByClassName("userName")[0].style.display = "none";
            document.getElementsByClassName("userName")[1].style.display = "none";
        }
    }
    if (document.getElementById("searchbar").style.display === "none") {
        document.getElementById("searchbar").style.display = "inline-block";
    } else {
        document.getElementById("searchbar").style.display = "none";
    }
}

