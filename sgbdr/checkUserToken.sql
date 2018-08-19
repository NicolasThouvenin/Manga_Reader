DELIMITER $$
CREATE PROCEDURE checkUserToken(IN inLogin VARCHAR(255), IN inToken VARCHAR(64), OUT isAuthentified BOOLEAN)
/* This stored procedure returns 1 if the login and token match with an row of the tokens table. If not 0. */
BEGIN
	SELECT count(*) INTO isAuthentified FROM tokens WHERE Login = inLogin AND Token = inToken;
END $$