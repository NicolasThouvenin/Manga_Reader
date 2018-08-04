DELIMITER $$
CREATE PROCEDURE deleteVolume(IN inVolumeId INTEGER)
/* Cette procédure supprime un tome de la base grâce à son Id. Les numéros situé après sont décrémententés. */
BEGIN
	DECLARE oldNumber INT;
	SELECT Number INTO oldNumber FROM volumes;
	DELETE FROM volumes WHERE Id = inVolumeId;
	UPDATE volumes SET Numero = Numero - 1 WHERE Id = inVolumeId AND volumes.Numero > oldNumber;
END $$