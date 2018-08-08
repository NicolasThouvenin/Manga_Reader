DELIMITER ;;
CREATE PROCEDURE createChapter(IN inTitle VARCHAR(255), IN inSynopsis VARCHAR(255), IN inVolumeId INTEGER, OUT lastChapterId INTEGER, OUT lastChapterNumber INTEGER)
/* Cette procédure créer un nouveau tome dans la base et retourne son Id. Le numéro du tome est calculé automatiquement. */
BEGIN
	SELECT Count(*) + 1 INTO lastChapterNumber FROM chapters
	JOIN volumes
	ON volumeId = volumes.Id
	JOIN comics
	ON comics.Id = volumes.comicId;
	SET lastChapterId = -1;
	INSERT INTO chapters (Title, Number, Synopsis, volumeId) VALUES (inTitle, lastChapterNumber, inSynopsis, inVolumeId);
	SET lastChapterId = LAST_INSERT_ID();
END ;;