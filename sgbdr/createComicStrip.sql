DELIMITER $$
CREATE PROCEDURE createComicStrip(IN inNumber INTEGER, IN inPath VARCHAR(250), IN inChapterId INTEGER, OUT lastComicStripId INTEGER)
/* Cette procédure créer une nouvelle image dans la base et retourne son Id. */
BEGIN
	DECLARE inNumber INTEGER;
	SET lastComicStripId = -1;
	INSERT INTO comicStrips (Number, Path, chapterId) VALUES (inNumber, inPath, inChapterId);
	SET lastComicStripId = LAST_INSERT_ID();
END $$