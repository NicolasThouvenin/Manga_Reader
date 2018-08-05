DELIMITER $$
CREATE PROCEDURE getUser(IN inLogin VARCHAR(255), IN inPassword VARCHAR(255))
/* Cette procédure retourne un utilisateur à partir de son login et de son mot de passe. */
BEGIN
	SELECT users.* FROM users WHERE Login = inLogin AND password = PASSWORD(inPassword);
END $$