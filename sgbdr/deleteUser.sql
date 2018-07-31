DELIMITER $$
CREATE PROCEDURE deleteUser(IN inId INT)
/* Cette procédure supprime un utilisateur à partir de son Id. */
BEGIN
	DELETE FROM users where Id = inId;
END $$

CALL createUser(2);