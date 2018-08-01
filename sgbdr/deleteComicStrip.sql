DELIMITER $$
CREATE PROCEDURE deleteComicStrip(IN inComicStripId INTEGER)
/* Cette procédure supprime une image et renumérote les images du chapitre situées après. */
BEGIN
	DECLARE oldNumber INTEGER;
	SELECT Number INTO oldNumber FROM comicStrips WHERE Id = inComicStripId; 
	DELETE FROM comicStrips WHERE Id = inComicStripId;
	UPDATE comicStrips SET Number = Number - 1 WHERE Id = inComicStripId AND Number > oldNumber;
END $$