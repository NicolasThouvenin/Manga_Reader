function toFilterComic(filterInput) {

  /*
    Cette function créer une propriété array dans sessionStorage.
    Celui-ci est alimenté par la page comicFilter.php qui va chercher les données dans la base de données.
    On associe à un mot clé de recherche une liste de résultat.
  */

  var trimInput = filterInput.value.trim();
  if (trimInput === '') {
    // Si la chaine et vide ou ne contient que des carcatères invisibles. On réaffache tout les comics et on sort de la fonction.
    showAllComicCards();
    return;
  };

  var keyword = trimInput.toLowerCase();

  var comicFilters = {};  

  if ('comicFilters' in sessionStorage) {
    comicFilters = JSON.parse(sessionStorage.getItem('comicFilters'));

  } else {
    sessionStorage.setItem('comicFilters', JSON.stringify(comicFilters));
  };

  if (keyword[0] in comicFilters) {
    var comicFilter = comicFilters[keyword[0]];
    filterComicCard(keyword, comicFilter);

  } else if (keyword.length === 1) {

    /* On intérroge la base de données que si le filterInput ne possède qu'un seul caractère et que celui-ci n'est pas déjà dans l'objet window.comicFilters.
      Par la suite on pourra utiliser les données renvoyées par le serveur */

    $.ajax({
      dataType: 'json',
      url: 'comicFilter.php?keyword=' + keyword,

      success: function(result) {
        var comicFilters = JSON.parse(sessionStorage.getItem('comicFilters'));
        comicFilters[keyword[0]] = result;
        sessionStorage.setItem('comicFilters', JSON.stringify(comicFilters));

        /* On récupère la valeur courante du le filterInput car en attendant la réponse du serveur l'utilisateur à potentiellement réécrit ou effacer des caractères */ 
        var filterInput = document.getElementById('searchbar');
        toFilterComic(filterInput);
      },

      error: function(error) {
        console.log(error);
      }
    });

  } else {
    showAllComicCards();
  };
};


function filterComicCard(keyword, comicFilter) {

  //Cette function masque les comic filtrés par un mot clé.

  var visibleComics = [];

  for (authorOrTitle in comicFilter) {
    if (authorOrTitle.indexOf(keyword) > -1) {
      comicFilter[authorOrTitle].forEach(function(comicId) {
        var comicElementId = 'comicId_' + comicId;
        visibleComics.push(comicElementId);
      });
    };
  };

  showAllComicCards();

  var elements = document.getElementsByClassName('comic');

  Array.prototype.forEach.call(elements, function(element) {
      if (visibleComics.indexOf(element.id)  === -1) {
          element.classList.add('comic-no-visible');
      };
  });
};

function showAllComicCards() {
  //Cette function réaffiche tout les comics.
  var elements = document.getElementsByClassName('comic-no-visible');
  Array.prototype.forEach.call(elements, function(element) {
      element.classList.remove('comic-no-visible');
  });
};