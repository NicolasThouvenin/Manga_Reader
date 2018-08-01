DELIMITER $$
CREATE PROCEDURE detachComicFromGenre(IN inGenreId INTEGER, IN inComicId INTEGER)
/* Déatache une BD à un genre. */
BEGIN
	DELETE FROM searchComics WHERE genreId = inGenreId AND comicId = inComicId;
END $$