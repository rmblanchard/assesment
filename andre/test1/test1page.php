<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./vendor/twbs/bootstrap//favicon.ico">

    <title>PHP Assesment Test 1 (MongoDB and Form)</title>

    <!-- Bootstrap core CSS -->
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
  </head>

  <body>


<?php
    require 'navbar.php';
    require 'header.php';
?>

<!--
//
// MAIN CONTENT SECTION
//
-->


<main role="main" class="container">

<div class="starter-template">
  <h1>TEST 1 - MongoDB and Form</h1>
  <p class="lead">Create an HTML form with the following input fields to allow for the capturing of data into a Mongo database: 
<ul>
    <li>Name</li>
    <li>Surname</li>
    <li>Id No</li>
    <li>Date of Birth</li>
</ul> and POST button, CANCEL button </P>

<p> Create a Mongo database with a relevant schema to store the input fields in. </p>


</div>


<?php

    //Global Variables
    
    $dbserver = "localhost";
    $dbport = "27017";
    $dbdatabase = "testdb";
    
    $dbConnectionString = "mongodb://{$dbserver}:{$dbport}"; 

    //echo "Connection String: {$dbConnectionString}";
    //$client = new MongoDB\Client("mongodb://localhost:27017");

    //require 'g_mongodb.php';


    $client = new MongoDB\Client($dbConnectionString);
 
    $collection = $client->$dbdatabase->persons;

    //var_dump($collection);

    $idxCount = 0;

    //echo "Count : " . count($collection->listIndexes());


    foreach ($collection->listIndexes() as $index) {
        $idxCount = $idxCount + 1;
    }

    //echo "Index Count : {$idxCount}";

    if ($idxCount < 2) {
      //create unique index for ID number if it does not exist
      $indexName = $collection->createIndex(['IDNumber' => 1], ['unique' => 1]);
      echo "Unique Index Created for ID Number : {$indexName}. <br>";    
    }




/*
    $result = $collection->insertOne( [ 'Name' => 'Ryan', 
                                        'Surname' => 'Blanchard',
                                        'IDNumber' => '7809195360083',
                                        'DateOfBirth' => '1978/09/19' ] );
                                        

    echo "Inserted with Object ID '{$result->getInsertedId()}'";
*/


?>


<div>
<form action='addPerson.php' method="post">
  <div class="form-group">
    <label for="txtFirstName">First Name:</label>
    <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" aria-describedby="fnameHelp" placeholder="Enter First Name">
    <small id="fnameHelp" class="form-text text-muted">Please enter a first name.</small>
  </div>

  <div class="form-group">
    <label for="txtLastName">Surname:</label>
    <input type="text" class="form-control" id="txtLastName" name="txtLastName" aria-describedby="lnameHelp" placeholder="Enter Surname">
    <small id="lnameHelp" class="form-text text-muted">Please enter a surname.</small>
  </div>

  <div class="form-group">
    <label for="txtIDNumber">SA ID Number:</label>
    <input type="text" class="form-control" id="txtIDNumber" name="txtIDNumber" aria-describedby="IDNumberHelp" placeholder="Please enter SA ID Number">
    <small id="IDNumberHelp" class="form-text text-muted">Please enter a ID Number.</small>
  </div>

  <div class="form-group">
    <label for="txtDateOfBirth">Date of Birth:</label>
    <input type="text" class="form-control" id="txtDateOfBirth" name="txtDateOfBirth" aria-describedby="DateOfBirthHelp" placeholder="Please enter a Date of Birth [yyyy/mm/dd].">
    <small id="DateOfBirthHelp" class="form-text text-muted">Please enter a Date of Birth [yyyy/mm/dd].</small>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="cancel" class="btn btn-secondary">Cancel</button>

</form>
</div>

</main><!-- /.container -->


<?php 

    require 'footer.php';

?>


</body>
</html>
