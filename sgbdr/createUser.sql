DELIMITER ;;
CREATE PROCEDURE createUser(IN inLogin VARCHAR(255), IN inFirstname VARCHAR(255), IN inSurname VARCHAR(255), IN inBirthDate VARCHAR(10), 
					IN inPassword VARCHAR(25), IN inEmail VARCHAR(254), OUT lastUserId INTEGER, OUT lastUserEmailKey VARCHAR(64))
/* This stored procedure creates a new user in the users table. An user is not validated by default. */
BEGIN
	SET lastUserEmailKey = SHA2(UUID(), 256);
	INSERT INTO users (Login, Firstname, Surname, BirthDate, Password, Email, EmailValidated, EmailKey)
	VALUES (inLogin, inFirstname, inSurname, inBirthDate, PASSWORD(inPassword), inEmail, 0, lastUserEmailKey);
	SELECT LAST_INSERT_ID() INTO lastUserId;
END ;;