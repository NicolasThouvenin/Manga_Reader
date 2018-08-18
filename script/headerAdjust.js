var isAdd = document.getElementById("add");
var isSearch = document.getElementById("searchbar");

/**
 * Adapt the dispal for small devices
 * @param {MediaQueryList object}
 * @returns {undefined}
 */
function header(size) {

    if (size === "s") { // If media query matches
        if (isSearch) {
            isSearch.style.display = "none";
        }
        document.getElementById("userTab").style.display = "none";
        if (isAdd) {
            isAdd.value = "+";
        }
        document.getElementsByClassName("smallLog")[0].style.display = "inline-block";
        if (document.getElementsByClassName("registerButton")[0]) {
            document.getElementsByClassName("registerButton")[0].style.display = "none";
            document.getElementsByClassName("regularButton")[0].style.display = "none";
        } else {
            document.getElementsByClassName("userName")[0].style.display = "none";
            document.getElementsByClassName("userName")[1].style.display = "none";
        }
    } else if (size === "l") {
        if (isAdd) {
            isAdd.value = "Add Creation";
        }
        document.getElementById("userTab").style.display = "block";
        document.getElementById("searchbar").style.display = "inline-block";
        document.getElementsByClassName("smallLog")[0].style.display = "none";
        if (document.getElementsByClassName("registerButton")[0]) {
            document.getElementsByClassName("registerButton")[0].style.display = "inline-block";
            document.getElementsByClassName("regularButton")[0].style.display = "inline-block";
        } else {
            document.getElementsByClassName("userName")[0].style.display = "block";
            document.getElementsByClassName("userName")[1].style.display = "block";
        }
    }
}

/**
 * toggle the display of the User Bar in small devices
 * The username and the log out link
 * @param {none}
 * @returns {undefined}
 */
function toggleUserTab() {
    if (isSearch) {
        /* If the searchbar is open, close it*/
        if (isSearch.style.display !== "none") {
            isSearch.style.display = "none";
        }
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

/**
 * Toggle the display of the search bar in small devices
 * @param {none}
 * @returns {undefined}
 */
function toggleSearch() {
    /* If the usertab is open, close it*/
    if (document.getElementsByClassName("connected")[0]) {
        if (document.getElementById("userTab").style.display !== "none") {
            document.getElementById("userTab").style.display = "none";
            document.getElementsByClassName("userName")[0].style.display = "none";
            document.getElementsByClassName("userName")[1].style.display = "none";
        }
    }
    if (isSearch.style.display === "none") {
        isSearch.style.display = "inline-block";
    } else {
        isSearch.style.display = "none";
    }
}

