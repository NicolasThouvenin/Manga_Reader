DELIMITER $$
CREATE PROCEDURE attachComicToGenre(IN inGenreId INTEGER, IN inComicId INTEGER)
/* Rattache une BD à un genre. */
BEGIN
	INSERT INTO searchComics (genreId, comicId) VALUES (inGenreId, inComicId);
END $$