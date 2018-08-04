DELIMITER $$
CREATE PROCEDURE createVolume(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inStartDate VARCHAR(10), IN inComicId INTEGER, OUT lastVolumeId INTEGER)
/* Cette procédure créer un nouveau tome dans la base et retourne son Id. Le numéro du tome est calculé automatiquement. */
BEGIN
	DECLARE inNumber INTEGER;
	SELECT Count(*) + 1 INTO inNumber FROM volumes WHERE comicId = inComicId;
	SET lastVolumeId = -1;
	INSERT INTO volumes (Title, Number, Synopsis, StartDate, comicId) VALUES (inTitle, inNumber, inSynopsis, inStartDate, inComicId);
	SET lastVolumeId = LAST_INSERT_ID();
END $$