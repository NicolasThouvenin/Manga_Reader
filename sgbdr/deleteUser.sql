DELIMITER $$
CREATE PROCEDURE deleteComic(IN inId INT)
/* Cette procédure supprime une BD à partir de son Id. */
BEGIN
	DELETE FROM comics where Id = inId;
END $$

CALL deleteComic(2);