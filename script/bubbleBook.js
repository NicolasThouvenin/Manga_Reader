$(document).ready(function () {
    book = {
        Id: "2",
        Title: "Berserk",
        Author: "Miura Kentaro",
        Release: "1989",
        Genre: "Action, Adventure, Fantasy, Horror, Mature, Seinen, Supernatural, Tragedy",
        Extention: "jpg",
        Synopsis: "Guts, known as the Black Swordsman, seeks sanctuary from the demonic forces attracted to him and his woman because of a demonic mark on their necks, and also vengeance against the man who branded him as an unholy sacrifice. Aided only by his titanic strength gained from a harsh childhood lived with mercenaries, a gigantic sword, and an iron prosthetic left hand, Guts must struggle against his bleak destiny, all the while fighting with a rage that might strip him of his humanity.",
        Volume: {
            39: [343, 350],
            38: [334, 342],
            37: [325, 333],
            36: [316, 324],
            35: [307, 315],
            34: [299, 306],
            33: [1, 298]

        }
    };

    /*
    disizatrszt = {
        "number":1,
        "title":"Le voyage vers l'Ouest",
        "synopsie":"Un gars rencontre un cochon et part vers l'Ouest",
        "startDate":"2018-07-31",
        "endDate":"",
        "volumes":{
            "number":1,
            "title":"Le trés méchant Tutu",
            "synopsie":"Le gars et le cochon doivent détruire les armées du méchant Tutu",
            "startDate":"2018-07-31",
            "endDate":"",
            "chapters":{
                "number":1,
                "title":"La rencontre",
                "synopsie":"Le gars rencontre le cochon",
                "validated":1,
                "publicationDate":"2018-08-01"
            }
        }
    };
    console.log(disizatrszt["number"]);
    */

    $.getJSON("script/test.JSON", function (json) {
        console.log(json);


        /*      with the object
            
            // changing the metainformation
            $("#book_title")[0].innerHTML = book.Title;
            $("#book_author")[0].innerHTML = book.Author;
            $("#book_release")[0].innerHTML = book.Release;
            $("#book_genre")[0].innerHTML = book.Genre;
            $("#synopsis")[0].innerHTML = book.Synopsis;
        
            //changing the Chapter header
            $("#chapter > p")[0].innerHTML = book.Title+" Chapters";
        */
        /*  with the JSON */

        // changing the metainformation
        $("#book_title")[0].innerHTML = json["title"];
        //$("#book_author")[0].innerHTML = json[""startDate""];
        $("#book_release")[0].innerHTML = json["startDate"];
        //$("#book_genre")[0].innerHTML = book.Genre;
        $("#synopsis")[0].innerHTML = json["synopsie"];

        //changing the Chapter header
        $("#chapter > p")[0].innerHTML = json["title"] + " Chapters";
        // generating the chapters
        //while 
    });
});