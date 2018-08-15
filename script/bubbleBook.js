$(document).ready(function () {

    /**
     *  Convert the genre Ids to their full names
     * 
     */
    genres = ["listOfGenre", "Action", "Adventure", "Comedy", "Drama", "Fantasy", "Historical", "Horror", "Sci-fi"];

    genreIds = $("#book_genre")[0].innerHTML;
    listGenre = "";
    for (i = 1; i < 9; i++) {
        if (genreIds.search(i) !== -1) {
            listGenre += genres[i] + ", ";
        }
    }
    $("#book_genre")[0].innerHTML = listGenre.slice(0, -2) + ".";

    /**
     *  Remove the last characters form the author name's list
     */
    $("#book_author")[0].innerHTML = $("#book_author")[0].innerHTML.slice(0, -2);

});

/**
 *  Display / Hide the div #new_volume_form
 */
function toggleForm() {
    document.getElementById("new_volume_form").style.display = (document.getElementById("new_volume_form").style.display === "" ? "block" : "");
}