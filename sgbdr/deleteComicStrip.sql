DELIMITER $$
CREATE PROCEDURE deleteComicStrip(IN inComicStripId INTEGER)
/* This stored procedure delete a comic strip from comicstrips table. The next comicstrips numbers are updated.  */
BEGIN
	DECLARE oldNumber INTEGER;
	SELECT Number INTO oldNumber FROM comicStrips WHERE Id = inComicStripId; 
	DELETE FROM comicStrips WHERE Id = inComicStripId;
	UPDATE comicStrips SET Number = Number - 1 WHERE Id = inComicStripId AND Number > oldNumber;
END $$