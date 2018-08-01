DELIMITER $$
CREATE PROCEDURE createComic(IN inTitle VARCHAR(255), IN inSynopsie VARCHAR(255), IN inStartDate VARCHAR(10))
/* Cette procédure créer un nouveau comic dans la base. Celui-ci est non validé par défaut. */
BEGIN
	INSERT INTO comics (Title, Synopsie, StartDate) VALUES (inTitle, inSynopsie, inStartDate);
END $$