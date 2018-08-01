DELIMITER $$
CREATE PROCEDURE createVolume(IN inTitle VARCHAR(255), IN inSynopsie VARCHAR(255), IN inStartDate VARCHAR(10), IN inNarrativeArcId INTEGER, OUT lastVolumeId INTEGER)
/* Cette procédure créer un nouveau tome dans la base et retourne son Id. Le numéro du tome est calculé automatiquement. */
BEGIN
	DECLARE inNumber INTEGER;
	SELECT Count(*) + 1 INTO inNumber FROM volumes WHERE narrativeArcId = inNarrativeArcId;
	SET lastVolumeId = -1;
	INSERT INTO volumes (Title, Number, Synopsie, StartDate, narrativeArcId) VALUES (inTitle, inNumber, inSynopsie, inStartDate, inNarrativeArcId);
	SET lastVolumeId = LAST_INSERT_ID();
END $$