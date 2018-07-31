DELIMITER $$
CREATE PROCEDURE createUser(IN inLogin VARCHAR(255), IN inFirstname VARCHAR(255), IN inSurname VARCHAR(255), IN inBirthDate VARCHAR(10), IN inPassword VARCHAR(255), IN inEmail VARCHAR(254))
/* Cette procédure créer un nouvelle utilisateur dans la base. Celui si est non validé par défaut. */
BEGIN
	INSERT INTO users (Login, Firstname, Surname, BirthDate, Password, Email, EmailValided) VALUES (inLogin, inFirstname, inSurname, inBirthDate, PASSWORD(inPassword), inEmail, 0);
END $$