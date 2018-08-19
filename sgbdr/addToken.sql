DELIMITER $$
CREATE PROCEDURE addToken(IN inLogin VARCHAR(255), IN inToken VARCHAR(64))
/* This stored procedure adds login and token in tokens table */
BEGIN
	INSERT INTO tokens (Token, Login) VALUES (inToken, inLogin);
END $$