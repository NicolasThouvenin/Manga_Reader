DELIMITER $$
CREATE PROCEDURE addToken(IN inLogin VARCHAR(255), IN inToken VARCHAR(64))
/* Cette procédure ajoute un token attaché à un login dans la base de données. */
BEGIN
	INSERT INTO tokens (Token, Login) VALUES (inToken, inLogin);
END $$