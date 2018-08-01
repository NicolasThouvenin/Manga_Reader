DELIMITER $$
CREATE PROCEDURE deleteChapter(IN inChapterId INTEGER)
/* Cette procédure supprime un chapitre de la base grâce à son Id. */
BEGIN
	DELETE FROM chapters WHERE Id = inChapterId;
END $$