DELIMITER//

CREATE PROCEDURE UserAuth(
	IN username VARCHAR(50)
    IN userpassword VARCHAR(50)
)
BEGIN
	SELECT UserID FROM TeleUsers
    WHERE UserName = username
    AND UserPassword = userpassword
END

DELIMITER ;