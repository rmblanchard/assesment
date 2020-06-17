<!DOCTYPE html>
<html>
<head>
    <title>
        PHP Assesment - Andre - Test 1 (MongoDB)
    </title>
</head>

<body>

<p>
Create an HTML form with the following input fields to allow for the capturing of data into a Mongo database: 
Name, Surname, Id No, Date of Birth, POST button, CANCEL button 
Create a Mongo database with a relevant schema to store the input fields in. 
REQUIREMENTS: 
•	Save 3 records into the database without duplicating the Id No. The ability to capture a duplicate Id No in the database table is an immediate fail. 
•	If a duplicate Id No is found up on capturing, the user must be informed about this and the form repopulated. People do not like to input their information in twice. 
•	Validate the Id No field to make sure it is a number and that it is only 13 characters long. 
•	Validate the Date of birth field to make sure that the input date is in the format dd/mm/YYYY. 
•	There must be a valid data in the name and surname fields and no characters that can cause a record not to be inputted into the database. 

PASS: 
•	Validation works as per requirements 
•	Date of birth field is captured correctly and is stored properly in the database 
•	The Id No field is no more than 13 chars long. (Bonus – check match with Date of Birth) 
•	No duplicate ids are in the database and the user is made aware of this. 
</p>




<?php

// requires imports

// This path should point to Composer's autoloader
require 'vendor/autoload.php';



echo "Andre Test 1";

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->demo->beers;

$result = $collection->insertOne( [ 'name' => 'Hinterland', 'brewery' => 'BrewDog' ] );

echo "Inserted with Object ID '{$result->getInsertedId()}'";



phpinfo();

?>

</body>
</html>