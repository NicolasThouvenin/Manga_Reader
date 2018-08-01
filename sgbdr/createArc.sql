DELIMITER $$
CREATE PROCEDURE createArc(IN inTitle VARCHAR(255), IN inSynopsie VARCHAR(255), IN inStartDate VARCHAR(10), IN inComicId INTEGER, OUT lastArcId INTEGER)
/* Cette procédure créer un nouvel Arc dans la base et retourne son Id. Le numéro de l'arc est calculer automatiquement. */
BEGIN
	DECLARE inNumber INTEGER;
	SELECT Count(*) + 1 INTO inNumber FROM narrativeArcs WHERE comicId = inComicId;
	SET lastArcId = -1;
	INSERT INTO narrativeArcs (Title, Number, Synopsie, StartDate, comicId) VALUES (inTitle, inNumber, inSynopsie, inStartDate, inComicId);
	SET lastArcId = LAST_INSERT_ID();
END $$