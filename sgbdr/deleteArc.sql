DELIMITER $$
CREATE PROCEDURE deleteArc(IN inArcId INTEGER)
/* Cette procédure supprime un nouvel Arc de la base grâce à son Id. */
BEGIN
	DELETE FROM narrativeArcs WHERE Id = inArcId;
END $$