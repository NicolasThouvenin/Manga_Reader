DELIMITER $$
CREATE PROCEDURE createComic(IN inTitle VARCHAR(255), IN inSynopsie VARCHAR(255), IN inStartDate VARCHAR(10), IN inAuthorId INTEGER, OUT lastComicId INTEGER)
/* Cette procédure créer un nouveau comic dans la base et retourne son Id. La table Authors est également mise à jour. */
BEGIN
	SET lastComicId = -1;
	INSERT INTO comics (Title, Synopsie, StartDate) VALUES (inTitle, inSynopsie, inStartDate);
	SET lastComicId = LAST_INSERT_ID();
	INSERT INTO Authors (comicId, userId) VALUES (lastComicId, inAuthorId);
END $$