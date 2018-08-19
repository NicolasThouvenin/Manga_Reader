DELIMITER $$
CREATE PROCEDURE deleteVolume(IN inVolumeId INTEGER)
/* This stored procedure delete a volume from volumes table. The next volumes numbers are updated.  */
BEGIN
	DECLARE oldNumber INT;
	SELECT Number INTO oldNumber FROM volumes;
	DELETE FROM volumes WHERE Id = inVolumeId;
	UPDATE volumes SET Numero = Numero - 1 WHERE Id = inVolumeId AND volumes.Numero > oldNumber;
END $$