DELIMITER ;;
CREATE PROCEDURE getChapterFolderPath(IN inChapterId INT, OUT chapterFolderPath VARCHAR(255))
/* Cette procédure retourne le chemin du dossier d'images d'un chapitre. */
BEGIN
	SELECT CONCAT(volumes.comicId, '\\', volumes.Id , '\\', chapter.Id)
	INTO chapterFolderPath
	FROM chapters
	JOIN volumes
	ON chapters.comicId = volumes.Id
	WHERE chapters.Id = inChapterId;
END ;;