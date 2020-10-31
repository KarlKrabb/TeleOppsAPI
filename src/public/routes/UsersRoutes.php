<?php
// include "sql/userAuth.php";


$app->get('/testbla', function($request, $response, $args){
    // $name = $args["name"];

    $response->write("hello");
});

/***********************************************************/
/** User Authentication Route **/
/***********************************************************/
$app->post('/userauth', function($request, $response){
    $responseBody = '';
    $json = $request->getBody();
    $data = json_decode($json, true);
    $username = $data['username'];
    $password = $data['password'];
    
    // $isValid = userAuth($username, $password);

    require_once 'sql/dbconnect.php';
    $userValid = false;
    $userID = '';
    try { 
        $queryString = "CALL UserAuth('$username', '$password')";
        $result = $mysqli->query($queryString);
        if($result->num_rows > 0)
        {                                                
            $userValid = true;
            while($row = $result->fetch_assoc())
            {
                $userID = $row["UserID"];
            }
        };
        $result->free_result();
        $validArr = array("valid"=>$userValid, "UserID"=>$userID);
        // $validArr = array("valid"=>$userValid);
        $responseBody = json_encode($validArr);
        
    } catch (Exception $e) {
        echo $e.getMessage();
        $responseBody = $e.getMessage();
    }    
    $response->getBody()->write($responseBody);
});

/***********************************************************/
/** Add User Route **/
/***********************************************************/
$app->post('/adduser', function($request, $response){
    $responseBody = "";
    $json = $request->getBody();
    $data = json_decode($json, true);
    $username = $data['name'];
    $usersurname = $data['surname'];    
    $email = $data['email'];
    $password = $data['password'];

    require_once 'sql/dbconnect.php';

    try { 
        $configID = '';
        $insertConfigQueryString = "INSERT INTO WorkDayConfigs() VALUES()";
        if($mysqli->query($insertConfigQueryString) === TRUE)
        {
            $configID = $mysqli->insert_id;
        };        

        $newUserID = '';
        $insertUserQueryString = "INSERT INTO `TeleUsers`(`ConfigID`, `UserName`, `UserSurname`, `UserEmail`, `UserPassword`) VALUES('$configID','$username','$usersurname','$email','$password')";
        if($mysqli->query($insertUserQueryString) === TRUE)
        {
            $newUserID = $mysqli->insert_id;
        };

        $addUserArr = array("configID"=>$configID, "newUserID"=>$newUserID);
        
        $responseBody = json_encode($addUserArr);
    } catch (Exception $e) {
        echo $e.getMessage();
        $responseBody = $e.getMessage();
    }    
    $response->getBody()->write($responseBody);
});


/***********************************************************/
/** GET User Info **/
/***********************************************************/
$app->post('/getuser', function($request, $response){
    $responseBody = array("Message"=> "Test", "Response"=>"{}");
    $json = $request->getBody();
    $data = json_decode($json, true);
    $userID = $data['userID'];

    require_once 'sql/dbconnect.php';    
    try { 
        $userInfo;
        $queryString = "SELECT `UserID`,`ConfigID`,`UserName`,`UserSurname`,`UserEmail` FROM TeleUsers WHERE `UserID`=$userID";
        $result = $mysqli->query($queryString);
        if($result->num_rows > 0)
        {                        
            while($row = $result->fetch_assoc())
            {
                $userInfo = array(
                    "UserID"=>$row["UserID"],
                    "ConfigID"=>$row["ConfigID"],
                    "UserName"=>$row["UserName"],
                    "UserSurname"=>$row["UserSurname"],
                    "UserEmail"=>$row["UserEmail"]                    
                );                
            }            
        };
        $result->free_result();
        $responseBody["Message"] = "Success";
        $responseBody["Response"] = $userInfo;
    } catch (Exception $e) {
        echo $e.getMessage();
        $responseBody["Message"] = $e.getMessage();
    }    
    $response->getBody()->write(json_encode($responseBody));
});


?>