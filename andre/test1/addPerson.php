<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./vendor/twbs/bootstrap//favicon.ico">

    <title>PHP Assesment - Add Person</title>

    <!-- Bootstrap core CSS -->
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
  </head>

  <body>


<?php


    function test_input($data) {
      echo "test input : ({$data})";
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    function show_error($errMesg) {
      echo "<H3>ERROR</h3>";
      echo "<p>{$errMesg}</p><p>Use the back button to go back to the previous page.</p><p><button type='button' class='btn btn-primary'>Ok</button></p>";
    }

    
	//Validate($_POST['idnumber']);
	function Validate($idNumber) {
		$correct = true;
		if (strlen($idNumber) !== 13 || !is_numeric($idNumber) ) {
			echo "ID number does not appear to be authentic - input not a valid number";
			$correct = false; die();
		}

		$year = substr($idNumber, 0,2);
		$currentYear = date("Y") % 100;
		$prefix = "19";
		if ($year < $currentYear)
		    $prefix = "20";
	    $id_year = $prefix.$year;

        $id_month = substr($idNumber, 2,2);
        $id_date = substr($idNumber, 4,2);

		$fullDate = $id_date. "-" . $id_month. "-" . $id_year;
		
		if (!$id_year == substr($idNumber, 0,2) && $id_month == substr($idNumber, 2,2) && $id_date == substr($idNumber, 4,2)) {
			echo 'ID number does not appear to be authentic - date part not valid'; 
			$correct = false;
		}
		$genderCode = substr($idNumber, 6,4);
        $gender = (int)$genderCode < 5000 ? "Female" : "Male";

       $citzenship = (int)substr($idNumber, 10,1)  === 0 ? "citizen" : "resident";//0 for South African citizen, 1 for a permanent resident

        $total = 0;
        $count = 0;
	    for ($i = 0;$i < strlen($idNumber);++$i)
	    {
		    $multiplier = $count % 2 + 1;
		    $count ++;
		    $temp = $multiplier * (int)$idNumber{$i};
		    $temp = floor($temp / 10) + ($temp % 10);
		    $total += $temp;
	    }
	    $total = ($total * 9) % 10;

	    if ($total % 10 != 0) {
	        echo 'ID number does not appear to be authentic - check digit is not valid';
		    $correct = false;
	    }

        if ($correct){
            echo nl2br( "\nSouth African ID Number:   ". $idNumber .
                '  Birth Date:   ' . $fullDate.
                '  Gender:  ' . $gender .
                '  SA Citizen:  ' . $citzenship);
        }

      return ($correct);
  }
  
  function getDateOfBirth($idNumber) {
    $year = substr($idNumber, 0,2);
		$currentYear = date("Y") % 100;
		$prefix = "19";
		if ($year < $currentYear)
		    $prefix = "20";
	    $id_year = $prefix.$year;

        $id_month = substr($idNumber, 2,2);
        $id_date = substr($idNumber, 4,2);

    $fullDate = $id_date. "-" . $id_month. "-" . $id_year;
    
    return $fullDate;

  }

    
    require 'navbar.php';

    require 'header.php';

?>

<main role="main" class="container">

<div class="starter-template">
  <h1>Add Person to Mongo DB</h1>
  <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
</div>



<?php

    
    $dbserver = "localhost";
    $dbport = "27017";
    $dbdatabase = "testdb";

    $dbConnectionString = "mongodb://{$dbserver}:{$dbport}"; 

    //echo "Connection String: {$dbConnectionString}";
    //$client = new MongoDB\Client("mongodb://localhost:27017");

    //require 'g_mongodb.php';

    //define variables for form
    $vFName = $vSName = $vIDNo = $vDOB = "";
    $hasError = false;




    $client = new MongoDB\Client($dbConnectionString);

    $collection = $client->$dbdatabase->persons;

    if (!isset($_POST['submit'])) {
      echo " No valid Post ";
      $hasError = true;
    } else {
      $vFName = test_input($_POST['txtFirstName']);
      $vSName = test_input($_POST['txtLastName']);
      $vIDNo =  test_input($_POST['txtIDNumber']);
      $vDOB =  test_input($_POST['txtDateOfBirth']);
    }


    //Perform validation


    //echo "First Name: {$vFName}";
    //var_dump($vFName);

    if ($vFName == "") {
        echo "firstname : {$vFName}";
        show_error("First Name is Required");
        $hasError = true;
    }

    if ($vSName == "") {

        show_error("Surname is Required");
        $hasError = true;
    }

    if ($vIDNo == "") {

        show_error("ID Number is Required");
        $hasError = true;
    }


    if ($vDOB == "") {

        show_error("Date of Birth is Required");
        $hasError = true;
    }




    if (Validate($vIDNo)) {
      $vDOB = getDateOfBirth($vIDNo);
    } else {
      show_error("Not a valid South African ID Number");
      $hasError = true;
    }

    
    //echo "Has Error : {$hasError}";

    if (!$hasError) {

      $result = $collection->insertOne( [ 'Name' => $vFName, 
                                        'Surname' => $vSName,
                                        'IDNumber' => $vIDNo,
                                        'DateOfBirth' => $vDOB ]);

      //Adding index on ID Number incase a new database has been created for the first time
      $idxCount = 0;
      //echo "Count : " . count($collection->listIndexes());
    
      foreach ($collection->listIndexes() as $index) { //Checking if more than one index exists in the case of a new collection being created
          $idxCount = $idxCount + 1;
      }
  
      //echo "Index Count : {$idxCount}";
  
      if ($idxCount < 2) {
        //create unique index for ID number if it does not exist
        $indexName = $collection->createIndex(['IDNumber' => 1], ['unique' => 1]);
        echo "Unique Index Created for ID Number : {$indexName}. <br>";    
      }
      //                            
                                    

      echo "<p>Inserted with Object ID '{$result->getInsertedId()}'</p>";
      echo "<p>{$vFName}</p>";
      echo "<p>{$vSName}</p>";
      echo "<p>{$vIDNo}</p>";
      echo "<p>{$vDOB}</p>";
      

    } else {

      show_error("Has Error - nothing saved");

    }






?>





</main><!-- /.container -->


<?php 

    require 'footer.php';




    
?>
  </body>
</html>
