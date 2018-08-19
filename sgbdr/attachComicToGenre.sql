DELIMITER $$
CREATE PROCEDURE attachComicToGenre(IN inGenreId INTEGER, IN inComicId INTEGER)
/* This stored procedure adds genre id and comic id in the comicsgenres table */
BEGIN
	INSERT INTO comicsgenres (genreId, comicId) VALUES (inGenreId, inComicId);
END $$