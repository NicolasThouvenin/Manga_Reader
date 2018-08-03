$(document).ready(function () {

    /**
     *  Convert the genre Ids to their full names
     * 
     */
    genres = ["Action", "Adventure", "Comedy", "Drama", "Fantasy", "Historical", "Horror", "Sci-fi"];

    genreIds = $("#book_genre")[0].innerHTML;
    listGenre = "";
    for (i = 1; i < 9; i++) {
        if (genreIds.search(i) !== -1) {
            listGenre += genres[i] + ", ";
        }
    }
    $("#book_genre")[0].innerHTML = listGenre.slice(0, -2) + ".";

    // Put the title of the comic as the page title
    document.title = title;

    /*          Dynamic generation of the chapters list */

    console.log(book);
    i = 0;
    j = 0;
    while (book.volume[i]) {
        $("#chapters").append("<div id='vol" + i + "'></div> <!-- vol" + i + " -->");
        $("#vol" + i).append("<p class='volume'>Volume " + i + "</p>");
        $("#vol" + i).append("<span class='volume_title'>" + book.volume[i].title + "</span>");
        $("#vol" + i).append("<span class='volume_synopsis'>" + book.volume[i].synopsis + "</span>");
        $("#vol" + i).append("<span class='volume_release'>" + book.volume[i].startDate + "</span>");
        $("#chapters").append("<ul class='chlist'></ul>");

        while (book.volume[i].chapter[j]) {
            $("#vol" + i + " > ul").append("<li></li> class='chapter" + book.volume[i].chapter[j].number + "'>");
                    j++;
        }
        i++;
    }




});