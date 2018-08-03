DELIMITER $$
CREATE PROCEDURE createUser(IN inLogin VARCHAR(255), IN inFirstname VARCHAR(255), IN inSurname VARCHAR(255), IN inBirthDate VARCHAR(10), IN inPassword VARCHAR(25), IN inEmail VARCHAR(254), OUT lastUserId INTEGER)
/* Cette procédure créer un nouvelle utilisateur dans la base. Celui-ci est non validé par défaut. */
BEGIN
	INSERT INTO users (Login, Firstname, Surname, BirthDate, Password, Email, EmailValided) VALUES (inLogin, inFirstname, inSurname, inBirthDate, PASSWORD(inPassword), inEmail, 0);
	SET lastUserId = LAST_INSERT_ID();
END $$