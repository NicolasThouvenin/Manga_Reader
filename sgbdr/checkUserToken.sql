DELIMITER $$
CREATE PROCEDURE checkUserToken(IN inLogin VARCHAR(255), IN inToken VARCHAR(64), OUT isAuthentified BOOLEAN)
/* Cette procédure retourne 0 ou 1 si le login et le token correspondent à ce qu'il y a dans la BD. */
BEGIN
	SELECT count(*) INTO isAuthentified FROM tokens WHERE Login = inLogin AND Token = inToken;
END $$