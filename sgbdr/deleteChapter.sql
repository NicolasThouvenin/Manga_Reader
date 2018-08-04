DELIMITER $$
CREATE PROCEDURE deleteChapter(IN inChapterId INTEGER)
/* Cette procédure supprime un chapitre de la base grâce à son Id. Les numéros situé après sont décrémententés. */
BEGIN
	DECLARE oldNumber INT;
	SELECT Number INTO oldNumber FROM chapters;
	DELETE FROM chapters WHERE Id = inChapterId;
	UPDATE chapters SET Numero = Numero - 1 WHERE Id = inChapterId AND chapters.Numero > oldNumber;
END $$