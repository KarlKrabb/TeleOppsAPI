DELIMITER //

CREATE PROCEDURE AddUser(
	IN username VARCHAR(50)
    IN usersurname VARCHAR(50)
    IN useremail VARCHAR(100)
    IN userpassword VARCHAR(50)
)
BEGIN
    DECLARE lastInsertedID INT DEFAULT 0;
	DECLARE newUserID INT DEFAULT 0;

    INSERT INTO WorkDayConfigs() VALUES();
    
    SET lastInsertedID = LAST_INSERT_ID();

    INSERT INTO TeleUsers (ConfigID, UserName, UserSurname, UserEmail, UserPassword)
    VALUES(insertedID, username, usersurname, useremail, userpassword);
    
    SET newUserID = SELECT LAST_INSERT_ID();

    SELECT * FROM TeleUsers
    WHERE UserID = newUserID
END

DELIMITER ;