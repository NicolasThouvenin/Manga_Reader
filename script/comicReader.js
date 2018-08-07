
    $('body').keyup(function (e) {
        if (e.keyCode == 39) {
            plusSlides(1);
        }
        if (e.keyCode == 37) {
            plusSlides(-1);
        }
    });

    var slideIndex = 1;
    showSlides(slideIndex);

// Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        var i;
        var bubbles = document.getElementsByClassName("bubble");

        if (n > bubbles.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = bubbles.length;
        }
        for (i = 0; i < bubbles.length; i++) {
            bubbles[i].style.display = "none";
        }

        bubbles[slideIndex - 1].style.display = "block";

    }

