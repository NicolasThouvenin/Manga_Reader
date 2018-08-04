DELIMITER $$
CREATE PROCEDURE createChapter(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inVolumeId INTEGER, OUT lastChapterId INTEGER)
/* Cette procédure créer un nouveau tome dans la base et retourne son Id. Le numéro du tome est calculé automatiquement. */
BEGIN
	DECLARE inNumber INTEGER;
	SELECT Count(*) + 1 INTO inNumber FROM chapters WHERE volumeId = inVolumeId;
	SET lastChapterId = -1;
	INSERT INTO chapters (Title, Number, Synopsis, volumeId) VALUES (inTitle, inNumber, inSynopsis, inVolumeId);
	SET lastChapterId = LAST_INSERT_ID();
END $$