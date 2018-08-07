DELIMITER ;;
CREATE PROCEDURE createVolume(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inStartDate VARCHAR(10), IN inComicId INTEGER,
					OUT lastVolumeId INTEGER, OUT lastVolumeNumber INTEGER)
/* Cette procédure créer un nouveau tome dans la base et retourne son Id et son numéro. Le numéro du tome est calculé automatiquement. */
BEGIN
	SELECT Count(*) + 1 INTO lastVolumeNumber FROM volumes WHERE comicId = inComicId;
	SET lastVolumeId = -1;
	INSERT INTO volumes (Title, Number, Synopsis, StartDate, comicId) VALUES (inTitle, lastVolumeNumber, inSynopsis, inStartDate, inComicId);
	SET lastVolumeId = LAST_INSERT_ID();
END ;;