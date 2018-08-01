DELIMITER $$
CREATE PROCEDURE deleteVolume(IN inVolumeId INTEGER)
/* Cette procédure supprime un tome de la base grâce à son Id. */
BEGIN
	DELETE FROM volumes WHERE Id = inVolumeId;
END $$