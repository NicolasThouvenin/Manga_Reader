DELIMITER $$
CREATE PROCEDURE createComicStrip(IN inNumber INTEGER, IN inExt VARCHAR(250), IN inChapterId INTEGER, OUT lastComicStripId INTEGER)
/* Cette procédure créer une nouvelle image dans la base et retourne son Id. */
BEGIN
	SET lastComicStripId = -1;
	INSERT INTO comicStrips (Number, Ext, chapterId) VALUES (inNumber, inExt, inChapterId);
	SET lastComicStripId = LAST_INSERT_ID();
END $$