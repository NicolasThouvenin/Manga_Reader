DELIMITER $$
CREATE PROCEDURE deleteChapter(IN inChapterId INTEGER)
/* This stored procedure delete a chapter from chapters table. The next chapters numbers are updated. */
BEGIN
	DECLARE oldNumber INT;
	SELECT Number INTO oldNumber FROM chapters;
	DELETE FROM chapters WHERE Id = inChapterId;
	UPDATE chapters SET Numero = Numero - 1 WHERE Id = inChapterId AND chapters.Numero > oldNumber;
END $$