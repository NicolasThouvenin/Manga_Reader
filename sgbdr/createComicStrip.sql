DELIMITER ;;
CREATE PROCEDURE createComicStrip(IN inFilename VARCHAR(75), IN inChapterId INTEGER, OUT lastComicStripId INTEGER, OUT lastComicStripNumber INTEGER)
/* This stored procedure creates a comic strip in comic strips table and return its Id */
BEGIN
	SET lastComicStripId = -1;
	SET lastComicStripNumber = -1;
	INSERT INTO comicstrips (Number, Filename, chapterId) VALUES (lastComicStripNumber, inFilename, inChapterId);
	SET lastComicStripId = LAST_INSERT_ID();
	SELECT count(*) INTO lastComicStripId FROM comicstrips WHERE chapterId = inChapterId;
END ;;