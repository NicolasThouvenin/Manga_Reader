DELIMITER ;;
CREATE PROCEDURE getChapterFolderPath(IN inChapterId INT, OUT chapterFolderPath VARCHAR(255))
/* Return a standard chapter images folder path */
BEGIN
	SELECT CONCAT(comics.Id, '/', volumes.Id , '/', chapters.Id)
	INTO chapterFolderPath
	FROM comics
	JOIN volumes
	ON comics.Id = volumes.comicId
	JOIN chapters
	ON volumes.Id = chapters.volumeId
	WHERE chapters.Id = inChapterId;
END ;;