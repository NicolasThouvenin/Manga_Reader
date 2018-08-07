DELIMITER ;;
CREATE PROCEDURE getChapterFolderPath(IN inChapterId INT, OUT chapterFolderPath VARCHAR(255))
/* Cette procédure retourne le chemin du dossier d'images d'un chapitre. */
BEGIN
	SELECT CONCAT(comics.Id, '\\', volumes.Id , '\\', chapters.Id)
	INTO chapterFolderPath
	FROM comics
	JOIN volumes
	ON comics.Id = volumes.comicId
	JOIN chapters
	ON volumes.Id = chapters.volumeId
	WHERE chapters.Id = inChapterId;
END ;;