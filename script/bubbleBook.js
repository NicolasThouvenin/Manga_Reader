$(document).ready(function () {

    /**
     *  Convert the genre Ids to their full names
     * 
     */
    genres = ["Action", "Adventure", "Comedy", "Drama", "Fantasy", "Historical", "Horror", "Sci-fi"];
    /**/
     genreIds = $("#book_genre")[0].innerHTML;
     listGenre = "";
     for (i = 1; i < 9; i++) {
     if (genreIds.search(i) !== -1) {
     listGenre += genres[i] + ", ";
     }
     }
     $("#book_genre")[0].innerHTML = listGenre.slice(0, -2) + ".";
     
     $("#book_author")[0].innerHTML = $("#book_author")[0].innerHTML.slice(0, -2);
     
    
     // Put the title of the comic as the page title
    document.title = title;

});