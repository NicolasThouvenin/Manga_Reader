DELIMITER ;;
CREATE PROCEDURE updateUser(IN inId INT, IN inLogin VARCHAR(255), IN inFirstname VARCHAR(255), IN inSurname VARCHAR(255), IN inBirthDate VARCHAR(10), 
					IN inPassword VARCHAR(25), IN inEmail VARCHAR(254), IN inEmailValidated BOOLEAN)
/* Cette procédure met à jour les informations sur un utilisateur. */
BEGIN
	UPDATE users
	SET Login = inLogin, Firstname = inFirstname, Surname = inSurname, BirthDate = inBirthDate, Password = PASSWORD(inPassword), Email = inEmail, EmailValidated = inEmailValidated
	WHERE Id = inId;

END ;;