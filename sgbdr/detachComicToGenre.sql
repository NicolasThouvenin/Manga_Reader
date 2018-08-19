DELIMITER $$
CREATE PROCEDURE detachComicFromGenre(IN inGenreId INTEGER, IN inComicId INTEGER)
/* Detache a comic from a genre */
BEGIN
	DELETE FROM comicsgenres WHERE genreId = inGenreId AND comicId = inComicId;
END $$