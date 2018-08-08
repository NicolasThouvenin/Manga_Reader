function filter(input) {

    $.ajax({
      dataType: 'json',
      url: 'filter.php?keyword=' + input.value,

      success: function(result) {

        var visibleComics = [];
        for (foundKeyWord in result) {
            visibleComics.push('comicId_' + result[foundKeyWord]);
        };


        var elements = document.getElementsByClassName('comic-no-visible');

        Array.prototype.forEach.call(elements, function(element) {
            element.classList.remove('comic-no-visible');
        });


        var elements = document.getElementsByClassName('comic');

        Array.prototype.forEach.call(elements, function(element) {
            if (visibleComics.indexOf(element.id)  === -1) {
                element.classList.add('comic-no-visible');
            };
        });

      },

      error: function(error) {
        console.log(error);
      }
    });


}