<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./vendor/twbs/bootstrap//favicon.ico">

    <title>PHP Assesment - Test 2</title>

    <!-- Bootstrap core CSS -->
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
  </head>

  <body>


<?php


    //functions
    function println($data) {
        echo "<p>{$data}</p>";
    }


    //variables
    $vNameArray = array(
        "Adrien",
        "Belinda",
        "Cathy",
        "Debbie",
        "Edgar",
        "Frank",
        "Gordon",
        "Harry",
        "Ivana",
        "Julien",
        "Kayla",
        "Leigh",
        "Mich",
        "Neil",
        "Olivia",
        "Pat",
        "Quinton",
        "Robert",
        "Steve",
        "Tim" 
    ) ;

    $vSurnameArray = array(
        "Ackerman",
        "Beethoven",
        "Cronje",
        "De Wet",
        "Enkelburt",
        "Finch",
        "Gecko",
        "Haasbriek",
        "Ibis",
        "Jobert",
        "Koekemoer",
        "Le Roux",
        "Moude",
        "Nicols",
        "Olivier",
        "Pienaar",
        "Quebek",
        "Roelofse",
        "Stein",
        "Tiekie" 
    ) ;

    require 'navbar.php';

    require 'header.php';






?>

<main role="main" class="container">

<div class="starter-template">
  <h1>Test 2 - SQLLite, Arrays and CSV File Access</h1>
  <p class="lead">This task is to test your skills in manipulating arrays and file handling. 
                    In this test you will be making a CSV file of variable length, a form will ask for the amount of data to generate. Check the requirements on how to generate the file. 
                    The file will have the following header fields 
                    Id, Name, Surname, Initials, Age, DateOfBirth 
                    The data will look like this 
                    "1","Andre","van Zuydam", "A", "33","13/02/1979" 
                    "2","Tyron James", "Hall", "TJ", "32", "03/06/1980"; 
                    After this you will import the file into a SQLite database and output a count of all the records imported. 
</p>
</div>


<div>

<?php
        var_dump($vSurnameArray);

        println($vNameArray[0]);
        println($vNameArray[19]);

        $vAge = mt_rand(1,100);

        $vMonth = mt_rand(1,12);

        $vYear = date('Y') - $vAge;
        println($vYear);

        $vLongMonths = array(1,3,5,7,8,10,12);

        if (in_array($vMonth, $vLongMonths)) {
            $vDay = mt_rand(1,31);
        } else {
            if ($vMonth == 2){
                $vDay = mt_rand(1,28);
            }
            else{
                $vDay = mt_rand(1,30);
            }
        }

        println($vDay);

        println($vMonth);
        println($vYear);
        println($vAge);
        println($vDay);


?>


</div>

</main><!-- /.container -->


<?php 

    require 'footer.php';
    
?>
  </body>
</html>
