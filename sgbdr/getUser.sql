DELIMITER $$
CREATE PROCEDURE getUser(IN inLogin VARCHAR(255), IN inPassword VARCHAR(255))
/* This stored procedure return an user from login and password */
BEGIN
	SELECT users.* FROM users WHERE Login = inLogin AND password = PASSWORD(inPassword);
END $$