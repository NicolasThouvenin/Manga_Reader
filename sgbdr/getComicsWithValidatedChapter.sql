DELIMITER $$
CREATE PROCEDURE getComicsWithValidatedChapter()
/* This stored procedure return all comics with one ou more validated chapter */
BEGIN
	SELECT DISTINCT comics.*
	FROM chapters
	JOIN volumes
	ON chapters.volumeId = volumes.Id
	JOIN comics
	ON volumes.comicId = comics.Id
	WHERE chapters.Validated = 1;
END $$