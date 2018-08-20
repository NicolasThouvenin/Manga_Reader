/* Header Elements that will be modified */
var addButon = document.getElementById("add");
var searchBar = document.getElementById("searchbar");
var userTab = document.getElementById("userTab");
var userNames = document.getElementsByClassName("userName");
var headerButon = document.getElementsByClassName("header_button");

/**
 * Adapt the display to device width
 * @param {char} size : size code of the device
 * @returns {undefined}
 */
function header(size) {

    /* For small devices  */
    if (size === "s") {
        if (searchBar) {
            searchBar.style.display = "none";
        }
        if (userTab) {
            userTab.style.display = "none";
        }
        if (addButon) {
            addButon.value = "+";
        }
        document.getElementsByClassName("smallLog")[0].style.display = "inline-block";
        if (headerButon[0]) {
            headerButon[0].style.display = "none";
            headerButon[1].style.display = "none";
        } else {
            userNames[0].style.display = "none";
            userNames[1].style.display = "none";
        }
        /* For large and medium devices */
    } else if (size === "l" || size === "m") {
        if (addButon) {
            addButon.value = "Add Creation";
        }
        if (userTab) {
            userTab.style.display = "block";
        }
        if (searchBar) {
            searchBar.style.display = "inline-block";
        }
        document.getElementsByClassName("smallLog")[0].style.display = "none";
        if (headerButon[0]) {
            headerButon[0].style.display = "inline-block";
            headerButon[1].style.display = "inline-block";
        } else {
            userNames[0].style.display = "block";
            userNames[1].style.display = "block";
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
    if (searchBar) {
        /* If the searchbar is open, close it*/
        if (searchBar.style.display !== "none") {
            searchBar.style.display = "none";
        }
    }
    if (userTab.style.display === "none") {
        userTab.style.display = "block";
        userNames[0].style.display = "inline-block";
        userNames[1].style.display = "inline-block";
    } else {
        userTab.style.display = "none";
        userNames[0].style.display = "none";
        userNames[1].style.display = "none";
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
        if (userTab.style.display !== "none") {
            userTab.style.display = "none";
            userNames[0].style.display = "none";
            userNames[1].style.display = "none";
        }
    }
    if (searchBar.style.display === "none") {
        searchBar.style.display = "inline-block";
    } else {
        searchBar.style.display = "none";
    }
}

