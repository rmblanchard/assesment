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


    $client = new MongoDB\Client($dbConnectionString);

    $collection = $client->$dbdatabase->persons;

    if (!isset($_POST['submit'])) {
      echo " No valid Post ";
    } else {
      echo "FIRSTNAME : " . $_POST['txtFirstName'] . "<BR>";
      echo "SurName : " . $_POST['txtLastName'] . "<BR>";
      echo "ID NUMBER : " . $_POST['txtIDNumber'] . "<BR>";
      echo "Date Of Birth : " . $_POST['txtDateOfBirth'] . "<BR>";
    }

    
    $result = $collection->insertOne( [ 'Name' => $_POST["txtFirstName"], 
                                        'Surname' => $_POST["txtLastName"],
                                        'IDNumber' => $_POST["txtIDNumber"],
                                        'DateOfBirth' => $_POST["txtDateOfBirth"] ] );
                                        

    echo "Inserted with Object ID '{$result->getInsertedId()}'";

    phpinfo();



?>





</main><!-- /.container -->


<?php 

    require 'footer.php';
    
?>
  </body>
</html>
