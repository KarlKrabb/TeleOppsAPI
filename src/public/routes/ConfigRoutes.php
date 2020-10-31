<?php

/***********************************************************/
/** Update Work Day Configuration **/
/***********************************************************/
$app->post('/updateconfig', function($request, $response){
    $responseBody = array("Message"=> "hello bla");
    $json = $request->getBody();
    $data = json_decode($json, true);
    $workStart = $data['workStart'];
    $firstBreakStart = $data['firstBreakStart'];
    $firstBreakEnd = $data['firstBreakEnd'];
    $secondBreakStart = $data['secondBreakStart'];
    $secondBreakEnd = $data['secondBreakEnd'];
    $lunchBreakStart = $data['lunchBreakStart'];
    $lunchBreakEnd = $data['lunchBreakEnd'];
    $thirdBreakStart = $data['thirdBreakStart'];
    $thirdBreakEnd = $data['thirdBreakEnd'];
    $workEnd = $data['workEnd'];
    $configID = $data['configID'];
    
    try {
        require_once 'sql/dbconnect.php';

        $updateWorkConfig = "UPDATE `WorkDayConfigs` SET `WorkStart`='$workStart',`FirstBreakStart`='$firstBreakStart',`FirstBreakEnd`='$firstBreakEnd',`SecondBreakStart`='$secondBreakStart',`SecondBreakEnd`='$secondBreakEnd',`LunchBreakStart`='$lunchBreakStart',`LunchBreakEnd`='$lunchBreakEnd',`ThirdBreakStart`='$thirdBreakStart',`ThirdBreakEnd`='$thirdBreakEnd',`EndOfWork`='$workEnd' WHERE `ConfigID` = '$configID'";
        if($mysqli->query($updateWorkConfig) === TRUE)
        {            
            $responseBody["Message"] = "Success";
        }
        else
        {
            $responseBody["Message"] = "Error updating";
        }
        // $responseBody["Message"] = "$configID, $workStart, $firstBreakStart, $firstBreakEnd, $secondBreakStart, $secondBreakEnd, $lunchBreakStart, $lunchBreakEnd, $thirdBreakStart, $thirdBreakEnd, $workEnd";
    } catch (Exception $ex) {
        $responseBody["Message"] = $ex.getMessage();
    }

    $response->getBody()->write(json_encode($responseBody));
});

/***********************************************************/
/** GET User Work Day Config **/
/***********************************************************/
$app->post('/getconfig', function($request, $response){
    $responseBody = array("Message"=> "Test", "Response"=>"{}");
    $json = $request->getBody();
    $data = json_decode($json, true);
    $configID = $data['configID'];

    require_once 'sql/dbconnect.php';    
    try { 
        $workConfig;
        $queryString = "SELECT * FROM WorkDayConfigs WHERE `ConfigID`=$configID";
        $result = $mysqli->query($queryString);
        if($result->num_rows > 0)
        {                        
            while($row = $result->fetch_assoc())
            {
                $workConfig = array(
                    "WorkStart"=>$row["WorkStart"],
                    "FirstBreakStart"=>$row["FirstBreakStart"],
                    "FirstBreakEnd"=>$row["FirstBreakEnd"],
                    "SecondBreakStart"=>$row["SecondBreakStart"],
                    "SecondBreakEnd"=>$row["SecondBreakEnd"],
                    "LunchBreakStart"=>$row["LunchBreakStart"],
                    "LunchBreakEnd"=>$row["LunchBreakEnd"],
                    "ThirdBreakStart"=>$row["ThirdBreakStart"],
                    "ThirdBreakEnd"=>$row["ThirdBreakEnd"],
                    "WorkEnd"=>$row["WorkEnd"],
                );
            }
        };
        $result->free_result();
        $responseBody["Message"] = "Success";
        $responseBody["Response"] = $workConfig;
    } catch (Exception $e) {
        echo $e.getMessage();
        $responseBody["Message"] = $e.getMessage();
    }    
    $response->getBody()->write(json_encode($responseBody));
});

?>