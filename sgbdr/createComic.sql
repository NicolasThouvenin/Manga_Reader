DELIMITER $$
CREATE PROCEDURE createComic(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inStartDate VARCHAR(10), IN inAuthorId INTEGER, IN inCoverExt VARCHAR(10),
								OUT lastComicId INTEGER)
/* Cette procédure créer un nouveau comic dans la base et retourne son Id. La table Authors est également mise à jour. */
BEGIN
	SET lastComicId = -1;
	INSERT INTO comics (Title, Synopsis, StartDate, coverExt) VALUES (inTitle, inSynopsis, inStartDate, inCoverExt);
	SET lastComicId = LAST_INSERT_ID();
	INSERT INTO authors (comicId, userId) VALUES (lastComicId, inAuthorId);
END $$