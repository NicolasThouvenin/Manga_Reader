DELIMITER $$
CREATE PROCEDURE getComicsWithValidatedChapter()
/* Cette procédure stockée renvoie la liste des comics avec au moins un chapitre validé */
BEGIN
	SELECT DISTINCT comics.*
	FROM chapters
	JOIN volumes
	ON chapters.volumeId = volumes.Id
	JOIN comics
	ON volumes.comicId = comics.Id
	WHERE chapters.Validated = 1;
END $$