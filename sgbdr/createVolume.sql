DELIMITER ;;
CREATE PROCEDURE createVolume(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inStartDate VARCHAR(10), IN inComicId INTEGER,
					OUT lastVolumeId INTEGER, OUT lastVolumeNumber INTEGER)
/* This stored procedure adds a new volume in the volumes table and return its id. The volume number is automaticly calculate automatically. */
BEGIN
	SELECT Count(*) + 1 INTO lastVolumeNumber FROM volumes WHERE comicId = inComicId;
	SET lastVolumeId = -1;
	INSERT INTO volumes (Title, Number, Synopsis, StartDate, comicId) VALUES (inTitle, lastVolumeNumber, inSynopsis, inStartDate, inComicId);
	SET lastVolumeId = LAST_INSERT_ID();
END ;;