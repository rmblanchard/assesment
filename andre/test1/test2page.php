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

    function createNameData($paramNumber, $data){
        //Create array of data for the CSV file, $paramNumber is the number of rows to create


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

    $outputFolder = "output";
    $outputFileName = "nameList.csv";

    $fullOutputCSV = $outputFolder . "/" . $outputFileName;



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

 

        //create $data array to hold generated person info


        $rowIndex = 0;
        $maxRows = 10;

        $data = [];
        $data["0000000000000"] = [
                    [
                        "Id" => 0,
                        "FirstName" => "FirstName",
                        "Surname" => "Surname",
                        "Initials" => "Initials",
                        "Age" => "Age",
                        "DateOfBirth" => "DateOfBirth"
                    ]
            ];

        //
        for ($i = 1 ; $i <= $maxRows; $i++) {

            println("RowIndex : {$i}");

            $vAge = mt_rand(1,100);

            $vMonth = mt_rand(1,12);
    
            $vYear = date('Y') - $vAge;
            //println($vYear);
    
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
    
            //println($vDay);
    
            $vDateOfBirth = mktime(0, 0, 0, $vDay, $vMonth, $vYear);
    
            //println($vMonth);
            //println($vYear);
            //println($vAge);
            //println(date("Y-m-d h:i:sa", $vDateOfBirth));
    
            $vFName = $vNameArray[mt_rand(0,19)];
            $vSName = $vSurnameArray[mt_rand(0,19)];
            $vInitial = $vFName[0];
    
    
    
            // Provides: Hll Wrld f PHP
            $specChar = array(" ", "-", "_", "/");
            $arrayKey = str_replace($specChar, "", "{$vFName}{$vSName}{$vInitial}{$vAge}{$vDateOfBirth}");

            if (array_key_exists($arrayKey, $data)) {
                println ("Data Key Exists already : {$arrayKey} ***");
            } else {
    
            //print($arrayKey);
                $data[$arrayKey] = 
                    [
                        "Id" => $i,
                        "FirstName" => $vFName,
                        "Surname" => $vSName,
                        "Initials" => $vInitial,
                        "Age" => $vAge,
                        "DateOfBirth" => $vDateOfBirth
                    ]
                ;
            } //else

        } //for

        var_dump($data);


        //write to csv file

        //header('Content-Type: text/csv');
        //header('Content-Disposition: attachment; filename="output/sample.csv"');


        //Craete output file (overwrite if file exists)
        $fp = fopen($fullOutputCSV, 'w');

        $strLine = implode(", ", array_values($data));

        $dKeys = array_keys($data);

        echo "<PRE>";
        print_r($data); 

        foreach ($data as $dkey=>$dvalue){
            print_r($dvalue);
            //exit;

            println("Array Key : " . $dkey);
            $v = array_values($dvalue);

            println("Array Value : " . array_values($v));
            println("======================");

        }

        foreach ($dKeys as $dataKey){
            println ("Data Key : " . $dataKey);
            //println ("Data Value for Key :" . $data['$dataKey']);
            $text = implode(", ", $data[$dataKey]);
            println("Text : " . $text);
            println(implode(", ", array_values($data[$dataKey])));
            println ("***************");
        }

        println("strLine : " . $strLine);

        //fwrite($fp, implode(", ", array_keys($data)));
        foreach ( $data as $line ) {
                $line_values = array_values($line);
                println($line_values . "** imploded : **" . explode($line_values));


            $keys = array_keys($line);
            println ("array_keys : " . $keys);
            println ("array_values : " . array_values($line));
            println ("implode values : " . implode(", ", array_values($line)));
            //foreach ($keys as $k) {
               // println ("keys: " . $k);
                //println(implode(", ", $k));
                //fwrite($fp, implode(", ", $line[$k]));
            //}

            //$val = implode(",", $line);
            //println($line);
            //println($val);
        //    fputcsv($fp, $line);
        }
        fclose($fp);
        


?>


</div>

</main><!-- /.container -->


<?php 

    require 'footer.php';
    
?>
  </body>
</html>
