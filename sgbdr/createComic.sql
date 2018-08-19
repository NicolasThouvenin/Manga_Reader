DELIMITER ;;
CREATE PROCEDURE createComic(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inStartDate VARCHAR(10), IN inAuthorId INTEGER, IN inCoverExt VARCHAR(10),
								OUT lastComicId INTEGER)
/* This stored procedure creates a no validated comic in comics table and return its Id */
BEGIN
	SET lastComicId = -1;
	INSERT INTO comics (Title, Synopsis, StartDate, coverExt) VALUES (inTitle, inSynopsis, inStartDate, inCoverExt);
	SET lastComicId = LAST_INSERT_ID();
	INSERT INTO authors (comicId, userId) VALUES (lastComicId, inAuthorId);
END ;;