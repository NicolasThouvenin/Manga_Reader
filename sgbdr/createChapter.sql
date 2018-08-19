DELIMITER ;;
CREATE PROCEDURE createChapter(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inStartDate VARCHAR(10), IN inVolumeId INTEGER, OUT lastChapterId INTEGER, OUT lastChapterNumber INTEGER)
/* This stored procedure creates a new chapter in the volumes table and return its id. The chapter number is automaticly calculate automatically. */
BEGIN
	SELECT Count(*) + 1 INTO lastChapterNumber FROM chapters
	JOIN volumes
	ON volumeId = volumes.Id
	JOIN comics
	ON comics.Id = volumes.comicId;
	SET lastChapterId = -1;
	INSERT INTO chapters (Title, Number, Synopsis, PublicationDate, volumeId) VALUES (inTitle, lastChapterNumber, inSynopsis, inStartDate, inVolumeId);
	SET lastChapterId = LAST_INSERT_ID();
END ;;